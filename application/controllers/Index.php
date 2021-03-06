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
            "<script src=\"https://www.google.com/recaptcha/api.js?render=explicit\" async defer></script>",
            "<meta http-equiv=\"Content-Security-Policy\" content=\"worker-src 'www.google.com/recaptcha/*'\">",
        );

        $headerData['style_src'] = array(
            '/assets/css/bootstrap.min.css',
            '/assets/quill/quill.snow.css',
            '/assets/css/katex.min.css',
            '/assets/css/main.css',
        );

        $headerData['js_src'] = array(
            '/assets/output/jquery-2.2.0.js',
            '/assets/output/jquery-ui.js',
            '/assets/output/jquery.sticky.js',
            '/assets/output/bootstrap.min.js',
            '/assets/output/katex.min.js',
            '/assets/output/main.min.js',
            '/assets/quill/quill.min.js',
            '/assets/fonts',
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
        $this->load->view('parts/page_content_start');
        $this->load->view('parts/page_accept_cookies');
        $this->load->view('parts/no_js');
        $this->load->view('parts/page_content_end');
        $this->load->view('parts/register_modal');
        $this->load->view('parts/login_modal');
        $this->load->view('parts/manage_user_modal');
        $this->load->view('parts/permission_modal');
        $this->load->view('parts/delete_modal');
        $this->load->view('parts/image_manager_modal');
        $this->load->view('parts/footer');
    }


}