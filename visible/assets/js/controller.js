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

    this.postIndex = [];
    this.posts = [];
    this.template = [];

    this.name = null;
    this.email = null;
    this.loggedin = false;

};

pwell.Controller.prototype.checkLoginInfo = function () {
    var self = this;

    $.ajax({
        type: "POST",
        url: "Api/loginInfo",
        dataType: "json",
        data: "{}",
        success: function (response) {
            var data = response.data;
            self.loggedin = data.status;
            self.name = data.name;
            self.email = data.email;

            if(self.loggedin)
                console.log("User is logged in");
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
        url: "/Api/logout",
        dataType: "json",
        data: "{}",
        complete: function () {
            self.checkLoginInfo();
            setTimeout(function () {
                self.update();
            }, 200);
        }
    });
};

pwell.Controller.prototype.requestPostIds = function(callback){
    if(typeof callback != "function")
        callback = function(){};
    var self = this;
    $.ajax({
        type: "POST",
        url: "/Api/requestPostIdList",
        dataType: "json",
        data: "{}",
        complete: function (data) {
            callback(data.responseJSON.data);
        }
    });
};

pwell.Controller.prototype.requestPost = function(id, callback){
    if(typeof callback != "function")
        callback = function(){};
    var data = {};
    data.postId = id;
    var self = this;
    $.ajax({
        type: "POST",
        url: "/Api/requestPost",
        dataType: "json",
        data: "data=" + JSON.stringify(data),
        complete: function (data) {
            callback(data.responseJSON.data);
        }
    });
};

$(document).ready(function () {
    $(".content-navigation").sticky();
    pwell.controller = new pwell.Controller();
    pwell.controller.checkLoginInfo();

    /*
    $(".post").on("click",function(){
        var element = $(this);
        element.addClass("post-open");
    });
    $(".post-close").on("click",function(e){
        e.cancelBubble = true;
        e.stopPropagation();

        var parent = $(this).parent();
        console.log(parent);
        if(parent.hasClass("post")){
            parent.removeClass("post-open");
            console.log(parent);
        }
    });
    */

    pwell.controller.requestPostIds(function(ids){
        for(var i=0;i<ids.length;i++){
            pwell.controller.requestPost(ids[i],function(data){
                var post = new Post(data);
                pwell.controller.posts.push(post);
                post.append();
            });
        }
    });
});

