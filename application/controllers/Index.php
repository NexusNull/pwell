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
        $data = array();
        $data['meta'] = array(
            "<script src=\"https://www.google.com/recaptcha/api.js?onload=reCaptcha&render=explicit\" async defer></script>"
        );

        $data['style_src'] = array(
            'assets/css/bootstrap.min.css',
            'assets/css/main.css',
        );

        $data['js_src'] = array(
            'assets/js/jquery-2.2.0.js',
            'assets/js/jquery-ui.js',
            'assets/js/jquery.sticky.js',
            'assets/js/bootstrap.min.js',
            'assets/js/form.js',
            'assets/js/controller.js',
            //'assets/js/effect.bubbles.js',
        );
        $this->load->view('frames/index', $data);
    }


}