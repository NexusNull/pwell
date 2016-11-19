/**
 * Created by patric on 11/8/16.
 */

/**
 * @namespace pwell
 * @constructor
 */
if (typeof pwell == "undefined")
    pwell = {};

pwell.Controller = function () {
    var self = this;

    this.name = null;
    this.email = null;
    this.loggedin = false;

};

pwell.Controller.prototype.checkLoginInfo = function () {
    var self = this;
    $.ajax({
        type: "POST",
        url: "/Api",
        dataType: "json",
        data: "request=LoginInfo&" +
        "data={}",
        success: function (response) {
            var data = response.data;
            self.loggedin = data.status;
            self.name = data.name;
            self.email = data.email;

            console.log("now we update;");
            self.update();
        },
        error: function (response) {
            console.log("error: checkingLoginInfo");
        }
    });
};

pwell.Controller.prototype.update = function () {
    var loginButtons = $(".login-buttons");
    var userInfo = $(".user-info");
    var nameField = userInfo.find(".name-field");
    if (this.loggedin) {
        loginButtons.hide();
        nameField.html(this.name);

        userInfo.show();
    } else {
        loginButtons.show();
        userInfo.hide();
    }
};

pwell.Controller.prototype.moveTo = function () {

};

pwell.Controller.prototype.logout = function () {
    var self = this;
    $.ajax({
        type: "POST",
        url: "/Api",
        dataType: "json",
        data: "request=Logout&" +
        "data={}",
        complete: function () {
            self.checkLoginInfo();
            setTimeout(function () {
                self.update();
            }, 200);
        }
    });
};

$(document).ready(function () {
    $(".content-navigation").sticky();
    pwell.controller = new pwell.Controller();
    pwell.controller.checkLoginInfo();
});

