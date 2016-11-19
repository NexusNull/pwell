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
 *      Logout <>
 *          status: <true/false>
 * @property Posts_model posts
 */
class Api extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    public function index()
    {
        $request = $this->input->post("request");
        $data = json_decode($this->input->post("data"));

        if ($request === NULL || $data === NULL) {
            echo (new Response("failure", "Malformed request."))->toString();

            return;
        }
        switch ($request) {
            case "RequestPostList":
                echo $this->requestPostList();
                break;
            case "RequestPost":
                echo $this->requestPost();
                break;
            case "RequestThumbnail":
                echo $this->requestPostThumbnail();
                break;
            case "LoginInfo":
                echo $this->loginInfo();
                break;
            case "Logout":
                echo $this->logout();
                break;
            default:
                echo (new Response("failure", "Unknown request."))->toString();
        }
    }

    private function requestPostList()
    {
        $this->load->model("Posts_model", "posts");
        $postIds = $this->posts->getLastPostIds();

        return (new Response("success", NULL, $postIds))->toString();
    }

    private function requestPost()
    {
        $this->load->model("Posts_model", "posts");
        $postIds = $this->posts->getLastPostIds();

        return (new Response("success", NULL, $postIds))->toString();
    }

    private function requestPostThumbnail()
    {

    }

    private function loginInfo()
    {
        if (isset($_SESSION['user']) && $_SESSION['user'] !== NULL) {
            $user = $_SESSION['user'];
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

        return (new Response("success", "", $data))->toString();
    }

    private function logout()
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

        return (new Response("success", "", $data))->toString();
    }
}