/**
 * Created by patric on 12/24/16.
 */

if (typeof pwell == "undefined")
    pwell = {};


var Post = function (data) {
    this.shown = false;
    this.data = data;
    this.open= false;
    this.element = {};
};

Post.prototype.append = function () {
    var div = document.createElement('div');
    div.innerHTML = this.template();
    var element = div.firstChild;
    this.element = element;
    $(".post-container").append(element);
};

Post.prototype.remove = function () {
    this.element.parentElement.removeChild(this.element);
};

Post.prototype.minimize = function () {

};

Post.prototype.maximize = function () {

};

Post.prototype.toggle = function(){

};

Post.prototype.template = function(){
    return '<div class="content spacer row post">' +
        //'<div class="col-xs-3 post-image">'+
        //'<img style="width: 100%; height: auto" src="'+this.data.image_link+'" alt="Nothing"/>'+
        //'</div>'+
        '<div>'+
        '<h1 class="post-title clear-fix">'+this.data.title+'</h1>'+
        '<div class="underline"></div>'+
        '<div class="post-meta"><span class="post-author">'+this.data.author+'</span> ~ <span class="post-date">'+this.data.date_written+'</span></div>'+
        //'<p class="post-teaser">'+
        //this.data.teaser+
        //'</p>'+
        '</div>'+
        '<div class="post-text">'+
        this.data.text+
        '</div>'+
        '</div>';
};