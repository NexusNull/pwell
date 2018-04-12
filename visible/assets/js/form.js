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
    this.callback = callback?callback:function(){};
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
        if (self.status != 1 && self.status != 3)
            console.log(self.ElementForm.serialize());
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: self.ElementForm.serialize(),
            success: function (response) {
                console.log(response)
                if (self.status == 2) { //is open
                    clearTimeout(self.TimeoutId);
                    self.hideResponse(function () {
                        self.showResponse(response.status, response.msg);

                    });
                } else {
                    self.showResponse(response.status, response.msg);
                }
                self.callback({status:"success",event:response});
                if (typeof captchas != 'undefined' && typeof grecaptcha != 'undefined' && self.useCaptcha)
                    grecaptcha.reset(captchaId);
                self.TimeoutId = setTimeout(function () {
                    self.hideResponse();
                }, 10000);
            },
            error: function (response) {
                self.showResponse("failure", "Error server answered unexpected");
                console.log(response);
                self.TimeoutId = setTimeout(function () {
                    self.hideResponse();
                }, 10000);
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
    pwell.AjaxForm.call(this, FormSelector, url, useCaptcha?this.captchaId:0, callback);
};

//Note that Object.create() is unsupported in some older browsers, including IE8:
pwell.ModalForm.prototype = Object.create(pwell.AjaxForm.prototype);
pwell.ModalForm.prototype.constructor = pwell.ModalForm;


var captchas = [];
$(document).ready(function () {
    var AjaxLogin = new pwell.ModalForm("#login", "#LoginForm", "/Api/login", function (response) {
        if (response.status == "success") {
            if (typeof pwell.controller != "undefined" && typeof pwell.controller.checkLoginInfo != "undefined") {
                pwell.controller.checkLoginInfo();
            }
        }
    },true);
    var AjaxRegister = new pwell.ModalForm("#register", "#RegisterForm", "/Api/register",null,true);
    var AjaxManageUser = new pwell.ModalForm("#manageUser","#ManageUserForm", "/Api/userInfo", function(response){
        function template(name,value){
            return "<div class='row'> <div class='col-xs-2' style='text-transform: capitalize'>"+name+"</div><div class='col-xs-10'>"+value+"</div></div>";
        }
        console.log(response);
        if(response.status === "success"){
            var event = response.event;
            if(event.status == "success"){
                var html = "";
                for(var i in event.data){
                    html += template(i,event.data[i]);
                }
                pwell.modalController.userId = event.data["id"];
                pwell.modalController.username = event.data["name"];
                $("#manageUser").find(".content")[0].innerHTML = html;
                $(".actionButtons").find("button").removeClass("disabled");
            }
        }
    });
    var AjaxPermission = new pwell.ModalForm("#permission","#PermissionForm", "/Api/setPerms");
});