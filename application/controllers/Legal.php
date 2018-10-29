<?php
/**
 * Created by PhpStorm.
 * User: nexus
 * Date: 01/09/2018
 * Time: 18:55
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Legal extends CI_Controller
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
        );

        $headerData['style_src'] = array(
            '/assets/css/bootstrap.min.css',
            '/assets/quill/quill.snow.css',
            '/assets/css/katex.min.css',
            '/assets/css/main.css',
        );

        $this->load->view('parts/header', $headerData);
        $this->load->view('parts/navbar');
        $this->load->view('parts/page_legal_impressum');
        $this->load->view('parts/footer');
    }
    public function privacyPolicy()
    {
        $headerData = array();
        $headerData['meta'] = array(
        );

        $headerData['style_src'] = array(
            '/assets/css/bootstrap.min.css',
            '/assets/quill/quill.snow.css',
            '/assets/css/katex.min.css',
            '/assets/css/main.css',
        );

        $this->load->view('parts/header', $headerData);
        $this->load->view('parts/navbar');
        $this->load->view('parts/page_legal_privacy_policy');
        $this->load->view('parts/footer');
    }
    public function cookieUsage()
    {
        $headerData = array();
        $headerData['meta'] = array(
        );

        $headerData['style_src'] = array(
            '/assets/css/bootstrap.min.css',
            '/assets/quill/quill.snow.css',
            '/assets/css/katex.min.css',
            '/assets/css/main.css',
        );

        $this->load->view('parts/header', $headerData);
        $this->load->view('parts/navbar');
        $this->load->view('parts/page_legal_cookie_usage');
        $this->load->view('parts/footer');
    }

}