<?php
/**
 * Created by PhpStorm.
 * User: patric
 * Date: 11/19/16
 * Time: 11:19 PM
 */
class JsInterface extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function index(){}

    public function postTemplate(){
        $this->load->view("template/template-Post");
    }

    public function settings()
    {
        $this->load->view("parts/javascript-vars");
    }
}