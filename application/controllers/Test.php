<?php

/**
 * Created by PhpStorm.
 * User: Nexus
 * Date: 30.09.2017
 * Time: 13:30
 */
class Test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Permission_model", "perm");
        $this->load->model("Users_model", "user");
    }

    public function index()
    {
        if (ENVIRONMENT == "production")
            return;
        phpinfo();
    }
}