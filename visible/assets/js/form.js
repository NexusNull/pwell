/**
 * Created by patric on 7/1/16.
 */
goog.provide("pwell.AjaxForm");
goog.provide("pwell.ModalForm");


if (typeof pwell == "undefined")
    pwell = {};

/**
 * @namespace pwell
 * @param FormSelector
 * @param url
 * @constructor
 */
pwell.AjaxForm = function (FormSelector, url, captchaId, callback) {
    var self = this;
    this.callback = callback ? callback : function () {
    };
    this.FormSelector = FormSelector;
    this.url = url;
    this.status = 0; // 0:closed, 1:opening, 2:open, 3:closing

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
        //if (self.status != 1 && self.status != 3);
        var formData = self.ElementForm.serializeArray();
        var data = {};
        for(var i in formData)
            data[formData[i].name] = formData[i].value;
        //console.log(data)

        pwell.rest.login(data.username, data.password, data["g-recaptcha-response"], {
            error: function (msg,data) {
                self.showResponse("failure", msg);
                self.TimeoutId = setTimeout(function () {
                    self.hideResponse();
                }, 10000);
            },
            success: function (msg, data) {
                if (self.status == 2) { //is open
                    clearTimeout(self.TimeoutId);
                    self.hideResponse(function () {
                        self.showResponse("success", msg);

                    });
                } else {
                    self.showResponse("success", msg);
                }
                self.callback({status: "success", event: data});
                if (typeof captchas != 'undefined' && typeof grecaptcha != 'undefined' && self.useCaptcha)
                    grecaptcha.reset(captchaId);
                self.TimeoutId = setTimeout(function () {
                    self.hideResponse();
                }, 10000);
            }
        });
    });
};

pwell.AjaxForm.prototype.showResponse = function (status, msg, callback) {
    var self = this;
    if (typeof callback == 'undefined') {
        callback = function () {
        };
    }
    if (this.status == 0) { //closed
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

pwell.ModalForm = function (ModalSelector, FormSelector, url, callback, useCaptcha) {
    var self = this;
    this.ElementModal = $(ModalSelector);
    this.captcha = this.ElementModal.find(".captcha");
    this.captchaId = 0;
    this.initialized = false;
    this.useCaptcha = !(undefined === useCaptcha) ? useCaptcha : false;
    if (this.captcha.length != 0 && useCaptcha) {
        this.ElementModal.on('shown.bs.modal', function () {
            if (!self.initialized) {
                self.captchaId = captchas[captchas.length] = grecaptcha.render(self.captcha[0].getAttribute('id'), {
                    'sitekey': pwell.settings.siteKey,
                    'size': 'normal'
                });
                self.initialized = true;
            }
        })
    }
    pwell.AjaxForm.call(this, FormSelector, url, useCaptcha ? this.captchaId : 0, callback);
};

//Note that Object.create() is unsupported in some older browsers, including IE8:
pwell.ModalForm.prototype = Object.create(pwell.AjaxForm.prototype);
pwell.ModalForm.prototype.constructor = pwell.ModalForm;


var captchas = [];
$(document).ready(function () {
    var AjaxLogin = new pwell.ModalForm("#login", "#LoginForm", "/REST/user/login", function (response) {
        if (response.status === "success") {
            if (typeof pwell.controller !== "undefined" && typeof pwell.controller.updateLoginInfo !== "undefined") {
                pwell.controller.updateLoginInfo();
                pwell.controller.updateUI()
            }
        }
    }, true);
    var AjaxRegister = new pwell.ModalForm("#register", "#RegisterForm", "/REST/user/register", null, true);
    var AjaxManageUser = new pwell.ModalForm("#manageUser", "#ManageUserForm", "/REST/user/info", function (response) {
        function template(name, value) {
            return "<div class='row'> <div class='col-xs-2' style='text-transform: capitalize'>" + name + "</div><div class='col-xs-10'>" + value + "</div></div>";
        }

        //console.log(response);
        if (response.status === "success") {
            var event = response.event;
            if (event.status == "success") {
                var html = "";
                for (var i in event.data) {
                    html += template(i, event.data[i]);
                }
                pwell.modalController.userId = event.data["id"];
                pwell.modalController.username = event.data["name"];
                $("#manageUser").find(".content")[0].innerHTML = html;
                $(".actionButtons").find("button").removeClass("disabled");
            }
        }
    });
    var AjaxPermission = new pwell.ModalForm("#permission", "#PermissionForm", "/Api/setPerms");
});