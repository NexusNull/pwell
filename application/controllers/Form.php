<?php

/**
 * Created by PhpStorm.
 * User: patric
 * Date: 6/26/16
 * Time: 7:07 PM
 * Desc:Form acceptor
 */
class Form extends CI_Controller
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
        $response = new Response();
        echo $response->toString();
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
            if ($this->captcha->valid) {
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
            if ($this->captcha->valid) {
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