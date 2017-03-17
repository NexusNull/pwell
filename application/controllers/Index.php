<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: patric
 * Date: 6/20/16
 * Time: 8:08 AM
 * @property Posts_model posts
 */
require_once "../application/config/reCaptcha.php";
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
            "<script src=\"https://www.google.com/recaptcha/api.js?render=explicit\" async defer></script>"
        );

        $headerData['style_src'] = array(
            '/assets/css/bootstrap.min.css',
            '/assets/quill/quill.snow.css',
            '/assets/css/main.css',

        );

        $headerData['js_src'] = array(
            '/assets/js/jquery-2.2.0.js',
            '/assets/js/jquery-ui.js',
            '/assets/js/jquery.sticky.js',
            '/assets/js/bootstrap.min.js',
            '/assets/js/form.js',
            '/assets/js/controller.js',
            '/assets/js/post.js',
            '/assets/quill/quill.min.js',
            '/assets/font'
            //'/assets/quill/quill.core.js',
            //'assets/js/effect.bubbles.js',
        );

        $headerData['custom_js'] = "
            if (typeof pwell == \"undefined\")
            pwell = {};
            pwell.settings = {};
            pwell.settings.siteKey = \"" . RECAPTCHA_SITEKEY . "\";
            pwell.settings.loadLastestPosts = true;
            pwell.settings.maxPosts = 5";

        $this->load->view('parts/header', $headerData);
        $this->load->view('parts/navbar');
        $this->load->view('parts/page-content-start');

        $this->load->view('parts/page-content-end');
        $this->load->view('parts/register-modal');
        $this->load->view('parts/login-modal');
        $this->load->view('parts/footer');
    }


}