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
    this.permissions = {};

    this.currentUserId = 0;

};

pwell.Controller.prototype.checkLoginInfo = function () {
    var self = this;
    pwell.rest.getSelfInfo({
        success: function(msg, data){
            self.loggedin = data.status;
            self.name = data.name;
            self.email = data.email;
            self.permissions = data.permissions;
            self.update();
        },
        error: function(){
            console.log("error: checkingLoginInfo");
        }
    })
};

pwell.Controller.prototype.update = function () {
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
            }
        }
        if(!visible){
            $(this).hide();
        }

    });
};

pwell.Controller.prototype.moveTo = function () {

};

pwell.Controller.prototype.logout = function () {
    var self = this;
    pwell.rest.logout();
    $.ajax({
        type: "GET",
        url: "/REST/user/logout",
        dataType: "json",
        complete: function () {
            self.checkLoginInfo();
            setTimeout(function () {
                self.update();
            }, 200);
        }
    });
};

pwell.Controller.prototype.requestPostIds = function (callback) {
    if (typeof callback != "function")
        callback = function () {
        };
    var self = this;
    $.ajax({
        type: "GET",
        url: "/REST/posts",
        dataType: "json",
        data: "{}",
        complete: function (data) {
            callback(data.responseJSON.data);
        }
    });
};

pwell.Controller.prototype.requestPost = function (id, callback) {
    if (typeof callback != "function")
        callback = function () {
        };
    $.ajax({
        type: "GET",
        url: "/REST/posts/" + id,
        dataType: "json",
        complete: function (data) {
            callback(data.responseJSON.data);
        }
    });
};

pwell.Controller.prototype.newPost = function () {
    $.ajax({
        type: "PUT",
        url: "/REST/createPost",
        dataType: "json",
        data: "{}",
        complete: function (data) {
            var post = pwell.controller.createPost(data.responseJSON.data);
            post.editPost();
        }
    });
};


pwell.Controller.prototype.createPost = function (data) {
    var post = new Post(data);
    pwell.controller.posts.push(post);
    var element = post.createPost();
    post.append(element);
    pwell.controller.update();
    return post;
};

pwell.Controller.prototype.editPost = function (post) {
    var data = post.data;
    console.log(data);
    $.ajax({
        type: "POST",
        url: "/Api/editPost",
        dataType: "json",
        data: "data=" + encodeURIComponent(JSON.stringify(data)),
        complete: function (data) {
            console.log(data);
            if (data.responseJSON) {
                var post = pwell.controller.createPost(data.responseJSON.data);
                post.editPost();
            }

        }
    });
};

pwell.Controller.prototype.deletePost = function (post) {
    post.remove();
    var id = post.data.id;
    console.log(post.data);
    var data = {"postId": id};
    var self = this;
    $.ajax({
        type: "POST",
        url: "/Api/deletePost",
        dataType: "json",
        data: "data=" + encodeURIComponent(JSON.stringify(data)),
        complete: function (data) {
            console.log(data);
        }
    });
};

$(document).ready(function () {
    $(".content-navigation").sticky();
    pwell.controller = new pwell.Controller();
    pwell.controller.checkLoginInfo();
    pwell.modalController = new pwell.ModalController();
    if (pwell.settings == undefined) {
        console.log("Server failed to deliver settings. switching to defaults");
        pwell.settings = {};
        pwell.settings.maxPosts = 5;
        pwell.settings.loadLastestPosts = true;
    }
    if (pwell.settings.loadLastestPosts) {
        pwell.controller.requestPostIds(function (ids) {
            for (var i = 0; i < Math.min(ids.length, pwell.settings.maxPosts); i++) {
                pwell.controller.requestPost(ids[i], pwell.controller.createPost.bind(this));
            }
        });
    }
});

