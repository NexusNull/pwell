<?php
/**
 * Created by PhpStorm.
 * User: patric
 * Date: 11/18/16
 * Time: 9:52 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
