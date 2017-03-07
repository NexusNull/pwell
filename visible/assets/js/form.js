/**
 * Created by patric on 7/1/16.
 */

/**
 * @namespace pwell
 * @param FormSelector
 * @param url
 * @constructor
 */

if (typeof pwell == "undefined")
    pwell = {};

pwell.AjaxForm = function (FormSelector, url, captchaId, callback) {
    var self = this;
    this.callback = callback;
    this.FormSelector = FormSelector;
    this.url = url;
    this.status = 0; // 0:closed, 1:opening, 2:open, 3:closing
    this.lastResponse = {};

    this.TimeoutId = 0;
    this.initialHeight = 0;

    this.ElementForm = $(FormSelector);
    this.EFormResponse = this.ElementForm.find(".form-response");

    this.ElementForm.resize(function () {
        if (self.status == 0 && self.status == 3) {
            self.EFormResponse.css('margin-top', -self.EFormResponse.outerHeight());
        }
    });

    this.ElementForm.submit(function (event) {
        event.preventDefault();
        if (self.status != 1 && self.status != 3)
            console.log(self.ElementForm.serialize());
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: self.ElementForm.serialize(),
            success: function (response) {
                if (self.status == 2) { //is open
                    clearTimeout(self.TimeoutId);
                    self.hideResponse(function () {
                        self.showResponse(response.status, response.msg);

                    });
                } else {
                    self.showResponse(response.status, response.msg);
                }
                self.callback("success");
                if (typeof captchas != 'undefined' && typeof grecaptcha != 'undefined')
                    grecaptcha.reset(captchaId);
                self.TimeoutId = setTimeout(function () {
                    self.hideResponse();
                }, 10000);

            },
            error: function (response) {
                self.lastResponse = {
                    status: "error",
                    msg: "Error: " + response
                };
                self.showResponse(response.status, response.msg);
                self.TimeoutId = setTimeout(function () {
                    self.hideResponse();
                }, 10000);
                // alert("Something isn't working right. Try again later.<br>"+msg);
            }
        })
    });
};

pwell.AjaxForm.prototype.showResponse = function (status, msg, callback) {
    var self = this;
    if (typeof callback == 'undefined') {
        callback = function () {
        };
    }
    if (this.status == 0) {
        this.status = 1; //opening
        this.EFormResponse[0].innerHTML = msg;
        self.EFormResponse.css('margin-top', -self.EFormResponse.outerHeight());
        if (status == "success")
            this.EFormResponse.addClass("form-response-success");
        if (status == "failure")
            this.EFormResponse.addClass("form-response-failure");

        self.EFormResponse.animate({marginTop: 0}, 500, "easeOutExpo", function () {
            self.status = 2; //open
            callback(true);
        });
    }
};

pwell.AjaxForm.prototype.hideResponse = function (callback) {
    var self = this;
    if (typeof callback == 'undefined') {
        callback = function () {
        };
    }
    if (this.status == 2) { //is open
        this.status = 3; //closing
        this.EFormResponse[0].innerHTML = "";
        this.EFormResponse.animate({marginTop: -this.EFormResponse.outerHeight()}, 500, "easeOutExpo", function () {
            self.status = 0;
            self.EFormResponse.removeClass("form-response-failure form-response-success");
            callback(false);
        });
    }
};

pwell.ModalForm = function (ModalSelector, FormSelector, url, callback) {
    var self = this;
    this.ElementModal = $(ModalSelector);
    this.captcha = this.ElementModal.find(".captcha");
    this.captchaId = 0;
    this.initialized = false;
    if (this.captcha.length != 0) {
        this.ElementModal.on('shown.bs.modal', function () {
            if (!self.initialized) {
                self.captchaId = captchas[captchas.length] = grecaptcha.render(self.captcha[0].getAttribute('id'), {
                    'sitekey': pwell.reCaptchaSiteKey,
                    'size': 'normal'
                });
                self.initialized = true;
            }
        })
    }
    pwell.AjaxForm.call(this, FormSelector, url, this.captchaId, callback);
};

//Note that Object.create() is unsupported in some older browsers, including IE8:
pwell.ModalForm.prototype = Object.create(pwell.AjaxForm.prototype);
pwell.ModalForm.prototype.constructor = pwell.ModalForm;


var captchas = [];
$(document).ready(function () {
    var AjaxLogin = new pwell.ModalForm("#login", "#LoginForm", "Form/login", function (status) {
        if (status == "success") {
            if (typeof pwell.controller != "undefined" && typeof pwell.controller.checkLoginInfo != "undefined") {
                pwell.controller.checkLoginInfo();
            }
        }
    });
    var AjaxRegister = new pwell.ModalForm("#register", "#RegisterForm", "Form/register");
});