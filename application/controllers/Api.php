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
 *      LoginInfo
 *          status: <true/false>
 *          name: <username>
 *          email: <email>
 *      Logout
 *          status: <true/false>
 * @property User $_SESSION['user']
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
        $response = new Response("failure", "Malformed request.");
        $request = $this->input->post("request");
        if ($request !== NULL) {
            if ($request == "LoginInfo") {
                if (isset($_SESSION['user']) && $_SESSION['user'] != NULL) {
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
                $response = new Response("success", "", $data);

            }
            if ($request == "Logout") {
                if (isset($_SESSION['user']) && $_SESSION['user'] != NULL) {
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
                $response = new Response("success", "", $data);
            }
        }
        echo $response->toString();
    }
}