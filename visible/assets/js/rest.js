/**
 * Created by Nexus on 03.05.2018.
 */
goog.provide("pwell.rest");
if (typeof pwell == "undefined")
    pwell = {};
pwell.rest = {};

/**
 *
 * @param username
 * @param password
 * @param captcha
 * @param {object} settings
 * @param {function} settings.success
 * @param {function} settings.error
 */
pwell.rest.login = function (username, password, captcha, settings) {
    if(settings == null) {
        settings = {};
        settings.error = function () {};
        settings.success = function () {};
    }
    this.defaultRequest({
        url: "Rest/user/login",
        method: "POST",
        data: {username: username, password: password, "g-recaptcha-response": captcha},
        success: settings.success,
        error: settings.error
    })
};

/**
 * @param {object} settings
 * @param {function} settings.success
 * @param {function} settings.error
 */
pwell.rest.logout = function (settings) {
    if(settings == null) {
        settings = {};
        settings.error = function () {};
        settings.success = function () {};
    }
    this.defaultRequest({
        url: "/Rest/user/logout",
        method: "GET",
        success: settings.success,
        error: settings.error
    })
};

/**
 * @param username
 * @param password
 * @param captcha
 * @param email
 * @param settings
 */
pwell.rest.register = function (username, password, email, captcha, settings) {
    if(settings == null) {
        settings = {};
        settings.error = function () {};
        settings.success = function () {};
    }
    this.defaultRequest({
        url: "Rest/user/register",
        method: "POST",
        data: {username: username, password: password, email: email, "g-recaptcha-response": captcha},
        success: settings.success,
        error: settings.error
    })
};

pwell.rest.getPost = function (id,settings) {
    if(settings == null) {
        settings = {};
        settings.error = function () {};
        settings.success = function () {};
    }
    this.defaultRequest({url: "Rest/posts/" + id, method: "GET", success: settings.success, error: settings.error})
};

pwell.rest.getPostIds = function (settings) {
    if(settings == null) {
        settings = {};
        settings.error = function () {};
        settings.success = function () {};
    }
    this.defaultRequest({url: "Rest/posts", method: "GET", success: settings.success, error: settings.error})
};

pwell.rest.createPost = function (title, text, settings) {
    if(settings == null) {
        settings = {};
        settings.error = function () {};
        settings.success = function () {};
    }
    var data = "data=" + encodeURIComponent(JSON.stringify({
            title:title,
            text:text
        }));
    this.defaultRequest({url: "Rest/posts/", method: "PUT", data:data, success: settings.success, error: settings.error})
};
pwell.rest.editPost = function (id, title, text, settings) {
    if(settings == null) {
        settings = {};
        settings.error = function () {};
        settings.success = function () {};
    }
    var data = "data=" + encodeURIComponent(JSON.stringify({
            title:title,
            text:text
        }));
    this.defaultRequest({url: "Rest/posts/" + id,data:data, method: "POST", success: settings.success, error: settings.error})
};
pwell.rest.deletePost = function (id,settings) {
    if(settings == null) {
        settings = {};
        settings.error = function () {};
        settings.success = function () {};
    }
    this.defaultRequest({url: "Rest/posts/" + id, method: "DELETE", success: settings.success, error: settings.error})
};
pwell.rest.getUserInfo = function (settings) {
    if(settings == null) {
        settings = {};
        settings.error = function () {};
        settings.success = function () {};
    }
    this.defaultRequest({url: "Rest/user/info", method: "GET", success: settings.success, error: settings.error})
};
/**
 *
 * @param {object} settings
 * @param {function} settings.success
 * @param {function} settings.error
 */
pwell.rest.getSelfInfo = function (settings) {
    if(settings == null) {
        settings = {};
        settings.error = function () {};
        settings.success = function () {};
    }
    this.defaultRequest({url: "Rest/user/info", method: "GET", success: settings.success, error: settings.error})
};
pwell.rest.autoCompleteUser = function (username, settings) {
    if(settings == null) {
        settings = {};
        settings.error = function () {};
        settings.success = function () {};
    }
    this.defaultRequest({url: "Rest/user/info", method: "GET", success: settings.success, error: settings.error})
};
pwell.rest.getUserPerms = function (username,settings) {
    if(settings == null) {
        settings = {};
        settings.error = function () {};
        settings.success = function () {};
    }
    this.defaultRequest({url: "Rest/user/info", method: "GET", success: settings.success, error: settings.error})
};
pwell.rest.setUserPerms = function (username, perms,settings) {
    if(settings == null) {
        settings = {};
        settings.error = function () {};
        settings.success = function () {};
    }
    this.defaultRequest({url: "Rest/user/info", method: "GET", success: settings.success, error: settings.error})
};
pwell.rest.defaultRequest = function (settings) {
    if(settings == null) {
        settings = {};
        settings.error = function () {};
        settings.success = function () {};
    }
    $.ajax({
        type: settings.method,
        url: settings.url,
        dataType: "json",
        data: settings.data,
        success: function (response) {
            var data = null;
            var message = "Operation successful";
            if (response) {
                if (typeof response.msg === "string" && response.msg > 0)
                    message = response.msg;
                if (typeof response.data === "object")
                    data = response.data
            }
            if (typeof settings.success === "function")
                settings.success(message, data);
        },
        error: function (response, err, reason) {
            var message = reason;
            var data = null;
            if (response.responseJSON) {
                if (typeof response.responseJSON.msg === "string" && response.responseJSON.msg > 0)
                    message = response.responseJSON.msg;
                if (typeof response.responseJSON.data === "object")
                    data = response.responseJSON.data
            }
            if (typeof settings.error === "function")
                settings.error(message, data);
        }
    });
};
