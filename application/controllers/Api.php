<?php
/**
 * Created by PhpStorm.
 * User: patric
 * Date: 10/30/16
 * Time: 7:46 PM
 */

/**
 * Class Api
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
class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->model("Users_model", "users");
        $this->load->model("Captcha_model", "captcha");
    }

    public function index()
    {
        echo (new Response("failure", "Unknown request."))->toString();
    }

    public function requestPostIdList()
    {
        $this->load->model("Posts_model", "posts");
        $postIds = $this->posts->getLastPostIds();
        echo (new Response("success", NULL, $postIds))->toString();
    }

    public function requestPost()
    {
        $request = $this->input->post("data");
        $print = print_r($request,true);
        $data = json_decode($request);

        if ($request === NULL || $data === NULL || !is_numeric($data->postId)) {
            echo (new Response("failure", "Malformed request.",$print))->toString();
            return;
        }

        $this->load->model("Posts_model", "posts");
        $post = $this->posts->getPost($data->postId);

        echo (new Response("success", "", $post))->toString();
    }

    public function loginInfo()
    {
        if (isset($_SESSION['user']) && $_SESSION['user'] !== NULL) {
            /** @var $user User */
            $user =  $_SESSION['user'];
            $data = array(
                'status' => TRUE,
                'name' => $user->getUsername(),
                'email' => $user->getEmail(),
            );
        } else {
            $data = array(
                'status' => FALSE,
                'name' => NULL,
                'email' => NULL,
            );
        }
        echo (new Response("success", "", $data))->toString();
    }

    public function logout()
    {
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
        echo (new Response("success", "", $data))->toString();
    }

    /**
     * POST Fields required
     * 'username'
     * 'password'
     * 'g-recaptcha-response'
     */
    public function login()
    {
        $response = new Response();

        $username = $this->input->post("username");
        $password = $this->input->post("password");
        $captcha = $this->input->post("g-recaptcha-response");

        if ($username == NULL || $password == NULL) {
            $response->appendMsg("Incomplete or Missing fields.");

        } else {

            $this->captcha->validate($captcha);
            if ($this->captcha->isValid()) {
                $user = $this->users->getUserByLogin($_POST['username'], $_POST['password']);

                if ($user !== NULL) {
                    $response = new Response("success", "You are now logged in.");
                    $_SESSION['user'] = $user;
                } else {
                    $response->appendMsg("Unknown username password combination.");
                }
            } else {
                $response->appendMsg("Unsolved Captcha.");
            }
        }
        echo $response->toString();
    }

    public function register()
    {
        $response = new Response();

        $username = $this->input->post("username");
        $password = $this->input->post("password");
        $email = $this->input->post("email");
        $captcha = $this->input->post("g-recaptcha-response");

        if ($username == NULL || $password == NULL || $email == NULL) {
            $response->appendMsg("Incomplete or Missing fields.");

        } else {
            $this->captcha->validate($captcha);
            if ($this->captcha->isValid()) {
                $user = $this->users->addUser($_POST['username'], $_POST['password'], $_POST['email']);
                if ($user === NULL) {
                    foreach ($this->users->input_errors as $error) {
                        $response->appendMsg($error);
                    }
                } else {
                    $response = new Response("success", "Your account has been created.");
                }
            } else {
                $response->appendMsg("Unsolved Captcha.");
            }
        }
        echo $response->toString();
    }
}