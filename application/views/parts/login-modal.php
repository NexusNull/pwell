<?php
/**
 * Created by PhpStorm.
 * User: patric
 * Date: 11/18/16
 * Time: 9:51 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
