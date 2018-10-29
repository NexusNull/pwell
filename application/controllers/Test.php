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
        $this->load->model("Image_model", "image");
    }

    public function index($id = 0)
    {
        if (ENVIRONMENT == "production")
            return;
        (new Response("success", "", $this->image->getImagesById($id)))->output(Response::HTTP_OK);
    }
    public function search($name = "")
    {
        if (ENVIRONMENT == "production")
            return;
        (new Response("success", "", $this->image->getImagesByName($name)))->output(Response::HTTP_OK);
    }
}