<?php

/**
 * Created by PhpStorm.
 * User: patric
 * Date: 10/15/16
 * Time: 11:57 PM
 */
class Autoloader
{
    public function __construct()
    {
        spl_autoload_register(function ($class_name) {
            require_once APPPATH . "classes/structures/" . $class_name . ".php";
        });
    }
}