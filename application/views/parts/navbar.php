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
                <img src="/assets/img/nexus.png"/>
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
                        <li class="dropdown-menu-header">
                            <div class="header"><a href="#">Lua</a></div>
                        </li>
                        <li><a href="#">MineCorp</a></li>
                        <li><a href="#">NexGenUI</a></li>
                        <li class="dropdown-menu-header">
                            <div class="header"><a href="#">Javascript</a></div>
                        </li>
                        <li><a href="#">AL Documentation</a></li>
                        <li><a href="#">AL Bot</a></li>
                        <li><a href="#">Project255</a></li>
                        <li class="dropdown-menu-header">
                            <div class="header"><a href="#">Web</a></div>
                        </li>
                        <li><a href="#">pwell</a></li>
                        <li class="dropdown-menu-header">
                            <div class="header"><a href="#">Java</a></div>
                        </li>
                        <li><a href="#">TeamspeakFun</a></li>
                    </ul>
                </li>
                <li class="dropdown require_perm perm_create_post perm_grant">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Admin
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li class="createPost require_perm perm_create_post"><a href="#" onclick="pwell.controller.createNewPost()">Create Post</a></li>
                        <li class="createPost require_perm perm_grant"><a href="#" onclick="$('#manageUser').modal('show')">Manage User</a></li>
                    </ul>
                </li>
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
            <div class="hanger"></div>
        </div>
    </div>
</nav>
