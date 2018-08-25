<?php
/**
 * Created by PhpStorm.
 * User: patric
 * Date: 10/30/16
 * Time: 7:46 PM
 */

/**
 * Class Rest
 * Handles api requests
 * TODO: Implement spam protection,
 * Valid requests:
 *      LoginInfo <>
 *          status: <true/false>
 *          name: <username>
 *          email: <email>
 * @property Posts_model posts
 * @property User $_SESSION['user']
 */
class Rest extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model("Users_model", "users");
        $this->load->model("Captcha_model", "captcha");
        $this->load->model("Posts_model", "posts");
        $this->load->model("Permission_model", "perm");
    }

    public function index()
    {
        (new Response("failure", "Unknown request."))->output(Response::HTTP_BAD_REQUEST);
    }

    public function users($id)
    {

    }

    public function user($action = NULL)
    {
        switch ($this->input->server('REQUEST_METHOD')) {
            case "GET":
                switch ($action){
                    case "info":
                        if (isset($_SESSION['user']) && $_SESSION['user'] !== NULL) {
                            /** @var $user User */
                            $user = $_SESSION['user'];
                            $data = array('status' => TRUE, 'name' => $user->getUsername(), 'email' => $user->getEmail(), 'permissions' => $this->perm->getUserPermission($user->getId()));
                        } else {
                            $data = array('status' => FALSE, 'name' => NULL, 'email' => NULL, 'permissions' => NULL,);
                        }
                        (new Response("success", "", $data))->output(Response::HTTP_OK);
                        break;
                    case "logout":
                        if (isset($_SESSION['user']) && $_SESSION['user'] !== NULL) {
                            setcookie("PHPSESSID", "", 0);
                            session_destroy();
                            $data = array(
                                'status' => TRUE,
                            );
                        } else {
                            $data = array(
                                'status' => FALSE,
                            );
                        }
                        (new Response("success", "", $data))->output(Response::HTTP_OK);
                        break;
                    default:
                        (new Response("failure", "Unknown request."))->output(Response::HTTP_BAD_REQUEST);
                        break;
                }
                break;
            case "POST":
                switch($action){
                    case "login":
                        $username = $this->input->post("username");
                        $password = $this->input->post("password");
                        $captcha = $this->input->post("g-recaptcha-response");

                        if ($username == NULL || $password == NULL || $captcha == NULL) {
                            (new Response("failure", "Incomplete or missing fields."))->output(Response::HTTP_BAD_REQUEST);
                        } else {
                            $this->captcha->validate($captcha);
                            if ($this->captcha->isValid()) {
                                $user = $this->users->getUserByLogin($username, $password);

                                if ($user !== NULL) {
                                    $_SESSION['user'] = $user;
                                    (new Response("success", "You are now logged in."))->output(Response::HTTP_OK);
                                } else {
                                    (new Response("failure","Unknown username password combination."))->output(Response::HTTP_BAD_REQUEST);
                                }
                            } else {
                                (new Response("failure","Unsolved captcha."))->output(Response::HTTP_BAD_REQUEST);
                            }
                        }
                        break;
                    case "register":

                        $username = $this->input->post("username");
                        $password = $this->input->post("password");
                        $email = $this->input->post("email");
                        $captcha = $this->input->post("g-recaptcha-response");

                        if ($username == NULL || $password == NULL || $email == NULL || $captcha == NULL) {
                            (new Response("failure", "Incomplete or missing fields."))->output(Response::HTTP_BAD_REQUEST);
                        } else {
                            $this->captcha->validate($captcha);
                            if ($this->captcha->isValid()) {
                                $user = $this->users->addUser($username, $password, $email);
                                if ($user === NULL) {
                                    $response = "";
                                    foreach ($this->users->input_errors as $error) {
                                        $response .= $error;
                                    }
                                    (new Response("failure", $response))->output(Response::HTTP_BAD_REQUEST);
                                } else {
                                    (new Response("success", "Your account has been created."))->output(Response::HTTP_OK);
                                }
                            } else {
                                (new Response("failure","Unsolved captcha."))->output(Response::HTTP_BAD_REQUEST);
                            }
                        }
                        break;
                    default:
                        (new Response("failure", "Unknown request."))->output(Response::HTTP_BAD_REQUEST);
                        break;
                }
                break;
            default:
                (new Response("failure", "Unknown request."))->output(Response::HTTP_BAD_REQUEST);
                break;
        }
    }

    public function permissions($id)
    {

    }

    public function posts($id = NULL)
    {
        switch ($this->input->server('REQUEST_METHOD')) {
            case "PUT":
                //Used to create a resource
                if (isset($_SESSION['user']) && $_SESSION['user'] !== NULL) {
                    $user = $_SESSION["user"];
                    if (!$this->perm->hasPermission($user->getId(), "perm_create_post")) {
                        (new Response("failure", "Missing perm_create_post permission"))->output(Response::HTTP_FORBIDDEN);

                    } else {
                        parse_str(file_get_contents("php://input"),$request);

                        if ($request === NULL) {
                            (new Response("failure", "Missing post data", ""))->output(Response::HTTP_BAD_REQUEST);
                        }

                        $data = json_decode($request["data"]);
                        if ($data === NULL) {
                            (new Response("failure", "Malformed request data", ""))->output(Response::HTTP_BAD_REQUEST);
                        }

                        if (!isset($data->text)) {
                            (new Response("failure", "Missing text field", ""))->output(Response::HTTP_BAD_REQUEST);
                        }

                        if (!isset($data->title)) {
                            (new Response("failure", "Missing title field", ""))->output(Response::HTTP_BAD_REQUEST);
                        }

                        $post = $this->posts->createPost();
                        $postId = $post->getId();
                        $postTitle = (isset($data->title) ? strip_tags($data->title) : NULL);
                        $postText = (isset($data->text) ? $data->text : NULL);

                        $this->posts->updatePost($postId, $postText, $postTitle);

                        (new Response("success", "", $post))->output(Response::HTTP_OK);

                    }
                } else {
                    (new Response("failure", "Action requires login"))->output(Response::HTTP_FORBIDDEN);

                }
                break;
            case "POST":
                //Used to edit a resource
                if (isset($_SESSION['user']) && $_SESSION['user'] !== NULL) {
                    $user = $_SESSION["user"];
                    if (!$this->perm->hasPermission($user->getId(), "perm_edit_post")) {
                        (new Response("failure", "Missing perm_edit_post permission"))->output(Response::HTTP_FORBIDDEN);
                    } else {
                        if ($id != NULL) {
                            if (is_numeric($id) && $id > 0) {
                                $request = $this->input->post("data");
                                if ($request === NULL) {
                                    (new Response("failure", "Missing field data"))->output(Response::HTTP_BAD_REQUEST);
                                }

                                $post = $this->posts->getPost($id);

                                $data = json_decode($request);

                                if ($data === NULL) {
                                    (new Response("failure", "Malformed json structure", ""))->output(Response::HTTP_BAD_REQUEST);
                                }

                                if (!isset($data->text)) {
                                    (new Response("failure", "Missing text field", ""))->output(Response::HTTP_BAD_REQUEST);
                                }

                                if (!isset($data->title)) {
                                    (new Response("failure", "Missing title field", ""))->output(Response::HTTP_BAD_REQUEST);
                                }

                                $postTitle = (isset($data->title) ? strip_tags($data->title) : NULL);
                                $postText = (isset($data->text) ? $data->text : NULL);
                                //TODO sanitize your inputs
                                $this->posts->updatePost($id, $postText, $postTitle);

                                (new Response("success", "", $post))->output(Response::HTTP_OK);
                            } else {
                                (new Response("failure", "parameter \"id\" has to be numeric"))->output(Response::HTTP_BAD_REQUEST);
                            }
                        } else {
                            (new Response("failure", "Missing parameter \"id\""))->output(Response::HTTP_BAD_REQUEST);
                        }
                    }
                } else {
                    (new Response("failure", "Action requires login"))->output(Response::HTTP_FORBIDDEN);
                }
                break;
            case "DELETE":
                //Used to edit a resource
                if (isset($_SESSION['user']) && $_SESSION['user'] !== NULL) {
                    $user = $_SESSION["user"];
                    if (!$this->perm->hasPermission($user->getId(), "perm_delete_post")) {
                        (new Response("failure", "Missing perm_delete_post permission"))->output(Response::HTTP_FORBIDDEN);
                    } else {
                        if ($id != NULL) {
                            if (is_numeric($id)) {
                                $post = $this->posts->getPost($id);

                                $this->posts->deletePost($id);
                                (new Response("success", "", $post))->output(Response::HTTP_OK);

                            } else {
                                (new Response("failure", "parameter \"id\" has to be numeric"))->output(Response::HTTP_BAD_REQUEST);
                            }
                        } else {
                            (new Response("failure", "Missing parameter \"id\""))->output(Response::HTTP_BAD_REQUEST);
                        }
                    }
                }
                break;
            case "GET":
                if ($id != NULL) {
                    $post = $this->posts->getPost($id);
                    if ($post) {
                        (new Response("success", "", $post))->output(Response::HTTP_OK);
                    } else {
                        (new Response("failure", "Post not found"))->output(Response::HTTP_NOT_FOUND);
                    }

                } else {
                    $postIds = $this->posts->getLastPostIds();
                    (new Response("success", NULL, $postIds))->output(Response::HTTP_OK);
                }
                break;
            default:
                (new Response("failure", "Unknown request."))->output(Response::HTTP_BAD_REQUEST);
                break;
        }
    }

}