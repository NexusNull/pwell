<?php
/**
 * Created by PhpStorm.
 * User: patric
 * Date: 6/26/16
 * Time: 8:17 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

?><!DOCTYPE html>
<html lang="en">
<head><?php
    foreach ($style_src as $src) {
        echo "    <link rel=\"stylesheet\" href=\"$src\">\n";
    }
    foreach ($js_src as $src) {
        echo "    <script type=\"text/javascript\" src=\"$src\"></script>\n";
    }
    foreach ($meta as $html) {
        echo "    $html\n";
    }
    unset($src);
    unset($html);
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patric Wellershaus</title>
</head>
<body class="bubbles">
<canvas id="bubbles" style="display:none; z-index: -1; width: 100%; height:100%;"></canvas>
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
                <img src="assets/img/logo.svg"/>
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

<div class="container page-content">
    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
        <?php
        $this->load->view("frames/content");
        ?>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="login" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times</span></button>
                <h4 class="modal-title" id="LoginLabel">Login</h4>
            </div>
            <form id="LoginForm" method="post" action="Form/login">
                <div class="modal-body form-body">
                    <div class="form-response container-fluid">
                    </div>
                    <div class="form-group row">
                        <label for="login-username" class="col-xs-2 col-form-label">Username:</label>
                        <div class="col-xs-6">
                            <input class="form-control" name="username" type="text" id="login-username"
                                   placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="login-password" class="col-xs-2 col-form-label">Password:</label>
                        <div class="col-xs-6">
                            <input class="form-control" name="password" type="password" id="login-password"
                                   placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="login-keep" class="col-xs-4 col-form-label">Stay logged in:</label>
                        <div class="col-xs-1">
                            <input class="form-control" name="keep" type="checkbox" id="login-keep">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div id="login-reCaptcha" class="captcha col-xs-6 loading">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="register" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="RegisterLabel">Register</h4>
            </div>
            <form id="RegisterForm" method="post" action="Form/register">
                <div class="modal-body form-body">
                    <div class="slider">
                        <div class="form-response container-fluid">
                        </div>

                        <div class="form-group row">
                            <label for="register-username" class="col-xs-2 col-form-label">Username:</label>
                            <div class="col-xs-6">
                                <input class="form-control" name="username" type="text" id="register-username"
                                       placeholder="Username">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="register-email" class="col-xs-2 col-form-label">Email:</label>
                            <div class="col-xs-6">
                                <input class="form-control" name="email" type="text" id="register-email"
                                       placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="register-password" class="col-xs-2 col-form-label">Password:</label>
                            <div class="col-xs-6">
                                <input class="form-control" name="password" type="password" id="register-password"
                                       placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div id="register-reCaptcha" class="captcha col-xs-6 loading">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
