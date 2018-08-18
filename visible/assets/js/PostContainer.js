/**
 * Created by patric on 12/08/18.
 */


if (typeof pwell == "undefined")
    pwell = {};

pwell.PostContainer = function () {
    var self = this;
    this.posts = [];
    this.element = $(".post-container")[0];
    this.postIds = [];
    this.position = 0;
    setTimeout(function () {
        self.updatePosts();
    }, 5000);
};

pwell.PostContainer.prototype.updatePosts = function(){
    var self = this;
    pwell.rest.getPostIds({
        success:function(msg,data){
            self.postIds = data;
            if (self.posts.length < pwell.settings.maxPosts) {
                let count = 0;
                for (var i of self.postIds) {
                    if (!self.posts[i] && count < pwell.settings.maxPosts) {
                        count++;
                        pwell.rest.getPost(i,{
                            success:function(msg, data){
                                if(msg === "Operation successful"){
                                    let post = new pwell.Post(data);
                                    self.insert(post);
                                }
                            },
                            error:function(msg,data){
                                if(msg === "Not Found"){
                                    self.postIds.splice(i, 1);
                                    console.error(msg+" id:"+i);
                                }else {
                                    console.error(msg);
                                }
                            }
                        })
                    }
                }
            }
        },
        error:function(msg){
            console.error(msg)
        }
    });
};


pwell.PostContainer.prototype.remove = function (post) {
    if (post && this.posts[post.data.id]) {
        delete this.posts[post.id];
        this.element.removeChild(post.getHTMLElement());
    }
};

pwell.PostContainer.prototype.insert = function (post) {
    let id = post.data.id;
    let followingPost = null;
    if(id === -1){
        let followingPost = this.posts[this.postIds[0]];

        this.element.prepend(post.getHTMLElement());
    }else {
        for (let i = this.postIds.indexOf(+id) + 1; i < this.postIds.length; i++) {
            if (this.posts[this.postIds[i]])
                followingPost = this.posts[this.postIds[i]];
        }
        if (followingPost) {
            this.posts[post.data.id] = post;
            this.element.insertBefore(post.getHTMLElement(), followingPost.getHTMLElement());
        } else {
            this.append(post);
        }
    }
    pwell.controller.updateUI();
};

pwell.PostContainer.prototype.append = function (post) {
    this.element.append(post.getHTMLElement());
    this.posts[post.data.id] = post;
};
