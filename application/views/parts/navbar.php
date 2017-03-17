<?php
/**
 * Created by PhpStorm.
 * User: patric
 * Date: 11/18/16
 * Time: 9:54 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<nav class="navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <img src="/assets/img/logo.svg"/>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home <span class="sr-only">(current)</span></a></li>
                <li><a href="https://github.com/Fansana">GitHub</a></li>
                <li><a href="#">Contact</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Projects
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
                <li class="createPost"><a href="#" onclick="pwell.controller.newPost()">Create Post</a></li>
            </ul>
            <div class="login-buttons">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" onclick="$('#login').modal('show')">Login</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" onclick="$('#register').modal('show')">Register</a></li>
                </ul>
            </div>
            <div class="user-info">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" onclick="pwell.controller.logout()">Logout</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" onclick="pwell.controller.moveTo()">Hello <span class="name-field"></span></a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
