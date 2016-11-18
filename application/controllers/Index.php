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
        parent::__construct();
        session_start();
    }

    public function index()
    {
        $headerData = array();
        $headerData['meta'] = array(
            "<script src=\"https://www.google.com/recaptcha/api.js?onload=reCaptcha&render=explicit\" async defer></script>"
        );

        $headerData['style_src'] = array(
            'assets/css/bootstrap.min.css',
            'assets/css/main.css',
        );

        $headerData['js_src'] = array(
            'assets/js/jquery-2.2.0.js',
            'assets/js/jquery-ui.js',
            'assets/js/jquery.sticky.js',
            'assets/js/bootstrap.min.js',
            'assets/js/form.js',
            'assets/js/controller.js',
            //'assets/js/effect.bubbles.js',
        );
        $this->load->view('parts/header', $headerData);
        $this->load->view('parts/navbar');
        $this->load->view('parts/page-content');
        $this->load->view('parts/register-modal');
        $this->load->view('parts/login-modal');
        $this->load->view('parts/footer');
    }


}