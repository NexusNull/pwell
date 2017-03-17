/**
 * Created by patric on 12/24/16.
 */

if (typeof pwell == "undefined")
    pwell = {};


var Post = function (data) {
    this.shown = false;
    this.data = data;
    this.open = false;
    this.element = {};
    this.buttons = {};

    this.editor = null;
};

Post.prototype.append = function (element) {
    this.buttons = element.buttons;
    this.element = element;
    $(".post-container").append(element);
};

Post.prototype.insert = function (element) {
    this.buttons = element.buttons;
    this.element = element;
    $(".post-container").append(element);
};

Post.prototype.createPost = function () {
    var div = document.createElement('div');
    div.innerHTML = this.template();
    var element = div.firstChild;
    element.buttons = {};
    element.buttons.postEditButton = element.getElementsByClassName("post-edit")[0];

    element.buttons.postEditFinishedButton = element.getElementsByClassName("post-edit-finished")[0];

    element.buttons.postDeleteButton = element.getElementsByClassName("post-delete")[0];

    element.buttons.postEditButton.addEventListener("click", this.editPost.bind(this));
    element.buttons.postEditFinishedButton.addEventListener("click", this.submitPost.bind(this));
    element.buttons.postDeleteButton.addEventListener("click", pwell.controller.deletePost.bind(null, this));

    return element;
};

Post.prototype.minimize = function () {

};

Post.prototype.maximize = function () {

};

Post.prototype.toggle = function () {

};

Post.prototype.remove = function () {
    this.element.parentElement.removeChild(this.element);
};

Post.prototype.template = function () {
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

Post.prototype.submitPost = function () {

    this.buttons.postEditButton.classList.remove("hidden");
    this.buttons.postEditFinishedButton.classList.add("hidden");

    if (this.editor != null) {
        var content = this.editor.root.innerHTML;
        var title = this.element.getElementsByClassName("post-title")[0].innerHTML;
        this.data.title = title;
        this.data.text = content;

        /*
         TODO: as of Version "1.2.2" of Quill there is no documented way of destroying the editor object
         As soon as it is, it should be implemented here instead of the manual way.
         */

        //Replace Post
        var element = this.createPost();
        var container = document.getElementsByClassName("post-container")[0];
        var container = document.getElementsByClassName("post-container")[0];
        container.replaceChild(element, this.element);

        this.buttons = element.buttons;
        this.element = element;

        pwell.controller.editPost(this);
    }

};

Post.prototype.editPost = function () {
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
        [{'indent': '-1'}, {'indent': '+1'}],          // outdent/indent
        [{'direction': 'rtl'}],                         // text direction

        [{'size': ['small', false, 'large', 'huge']}],  // custom dropdown
        [{'header': [1, 2, 3, 4, 5, 6, false]}],

        [{'color': []}, {'background': []}],          // dropdown with defaults from theme
        [{'font': []}],
        [{'align': []}],

        ['clean']                                         // remove formatting button
    ];

    var options = {
        modules: {
            toolbar: toolbarOptions
        },
        theme: 'snow'
    };

    titleEle.classList.add("editable");
    titleEle.setAttribute("contentEditable", true);

    this.editor = new Quill(textEle, options);

};