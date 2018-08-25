/**
 * Created by patric on 11/8/16.
 */
goog.require("pwell.rest")
goog.provide("pwell.controller");

if (typeof pwell == "undefined")
    pwell = {};

/**
 * @namespace pwell
 * @constructor
 */
pwell.Controller = function (){
    this.loggedin = false;
    this.permissions = {};
    this.currentUserId = 0;
    this.postContainer = null;

};

pwell.Controller.prototype.logout = function(){
    var self = this;
    pwell.rest.logout({
        success: function(){
            self.updateLoginInfo();
        }
    });
};

pwell.Controller.prototype.updateUI = function(){
    var self = this;
    var loginButtons = $(".login-buttons");
    var userInfo = $(".user-info");
    var nameField = userInfo.find(".name-field");
    if(this.loggedin){
        loginButtons.hide();
        userInfo.show();
        nameField.html(this.name);
    } else {
        loginButtons.show();
        userInfo.hide();
    }

    $(".require_perm").each(function(){
        var visible = false;
        for (var j in self.permissions) {
            if ($(this).hasClass(j) && self.permissions[j]) {
                $(this).show();
                visible = true;
                break;
            }
        }
        if(!visible){
            $(this).hide();
        }
    });
};

pwell.Controller.prototype.updateLoginInfo = function () {
    var self = this;
    pwell.rest.getSelfInfo({
        success: function(msg, data){
            self.loggedin = data.status;
            self.name = data.name;
            self.email = data.email;
            self.permissions = data.permissions;
            self.updateUI();
        },
        error: function(){
            console.log("error: checkingLoginInfo");
        }
    })
};

pwell.Controller.prototype.createNewPost = function(){
    let post = new pwell.Post({
        id: -1,
        title: "asd",
        text:"asd"
    });
    pwell.controller.postContainer.insert(post);
    post.enableEditing();
};


$(document).ready(function () {
    $(".content-navigation").sticky();
    pwell.controller = new pwell.Controller();
    pwell.controller.updateLoginInfo();
    pwell.modalController = new pwell.ModalController();
    if (pwell.settings == undefined) {
        console.log("Server failed to deliver settings. switching to defaults");
        pwell.settings = {};
        pwell.settings.maxPosts = 5;
        pwell.settings.loadLastestPosts = true;
    }
    pwell.controller.postContainer = new pwell.PostContainer();
    pwell.controller.postContainer.updatePosts();
});
