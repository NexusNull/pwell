/**
 * Created by patric on 12/24/16.
 */
goog.provide("pwell.post")
if (typeof pwell == "undefined")
    pwell = {};

pwell.Post = function (data) {
    this.data = data;
    this.element = null;
    this.buttons = {};
    this.editor = null;
    this.buttons = {};

};

pwell.Post.prototype.getHTMLElement = function(){
    if(!this.element) {
        let div = document.createElement('div');
        div.innerHTML = this.template();
        var self = this;
        this.element = div.firstChild;

        this.buttons = {};
        this.buttons.postEditButton = this.element .getElementsByClassName("post-edit")[0];

        this.buttons.postEditFinishedButton = this.element .getElementsByClassName("post-edit-finished")[0];

        this.buttons.postDeleteButton = this.element .getElementsByClassName("post-delete")[0];

        this.buttons.postEditButton.addEventListener("click", function(){
            self.enableEditing()
        });
        this.buttons.postEditFinishedButton.addEventListener("click", function(){
            self.disableEditing()
            if(self.data.id === -1){
                pwell.rest.createPost(self.data.title, self.data.text,{
                    success:function(){
                        self.destroy()
                    }
                })
            } else {
                pwell.rest.editPost(self.data.id, self.data.title, self.data.text,{
                    error:function(msg,data){
                        console.log(arguments);
                    }
                });
            }
        });
        this.buttons.postDeleteButton.addEventListener("click", function(){
            self.destroy();
            pwell.rest.deletePost(self.data.id,{
                error:function(msg,data){
                    console.log(arguments);
                }
            });
        });
        return this.element;
    } else {
        return this.element;
    }
};

pwell.Post.prototype.destroy = function(){
    pwell.controller.postContainer.remove(this);
};

pwell.Post.prototype.template = function () {
    if (pwell.postTemplate != undefined) {
        return pwell.postTemplate(this.data);
    } else
        return '<div class="content spacer row post">' +
            '<div>' +
            '<h1 class="post-title clear-fix">' + this.data.title + '</h1>' +
            '<div class="underline"></div>' +
            '<div class="post-meta"><span class="post-author">' + this.data.author + '</span> ~ <span class="post-date">' + this.data.date_changed + '</span></div>' +
            '</div>' +
            '<div class="post-text">' +
            this.data.text +
            '</div>' +
            '</div>';
};

pwell.Post.prototype.enableEditing = function () {
    var element = this.element;

    this.buttons.postEditFinishedButton.classList.remove("hidden");
    this.buttons.postEditButton.classList.add("hidden");


    var titleEle = element.getElementsByClassName("post-title")[0];

    var textEle = element.getElementsByClassName("post-text")[0];

    var toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],

        [{'header': 1}, {'header': 2}],               // custom button values
        [{'list': 'ordered'}, {'list': 'bullet'}],
        [{'script': 'sub'}, {'script': 'super'}],      // superscript/subscript

        [{'size': ['small', false, 'large', 'huge']}],  // custom dropdown
        [{'header': [1, 2, 3, 4, 5, 6, false]}],

        [{'color': []}, {'background': []}],          // dropdown with defaults from theme
        [{'font': []}],

        ['clean']                                         // remove formatting button
    ];

    var options = {
        modules: {
            toolbar: toolbarOptions
        },
        theme: 'snow'
    };

    titleEle.classList.add("editable");
    titleEle.setAttribute("contentEditable", "true");

    this.editor = new Quill(textEle, options);
};

pwell.Post.prototype.disableEditing = function(){

    this.buttons.postEditButton.classList.remove("hidden");
    this.buttons.postEditFinishedButton.classList.add("hidden");

    if (this.editor != null) {
        var content = this.editor.root.innerHTML;
        var title = this.element.getElementsByClassName("post-title")[0].innerHTML;
        this.data.title = title;
        this.data.text = content;

        $(this.element).find(".ql-toolbar")[0].remove();
        $(this.element).find(".post-title").removeClass("editable");
        $(this.element).find(".post-title").attr('contenteditable','false');

        $(this.element).find(".post-text").removeClass("ql-container");
        $(this.element).find(".post-text").removeClass("ql-snow");

        $(this.element).find(".ql-editor").attr('contenteditable','false');

        $(this.element).find('.post-text').append($('.ql-editor').children());

        $(this.element).find(".ql-editor")[0].remove();
        $(this.element).find(".ql-clipboard")[0].remove();
        $(this.element).find(".ql-tooltip")[0].remove();
    }

};
