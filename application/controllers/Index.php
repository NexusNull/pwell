<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: patric
 * Date: 6/20/16
 * Time: 8:08 AM
 */
class Index extends CI_Controller
{
    public function __construct()
    {


    }

    public function index()
    {
        $this->load->view('welcome_message');
    }


}