
goog.provide("pwell.contentNavigator");
if (typeof pwell == "undefined")
    pwell = {};

pwell.ContentNavigator = function(){
    this.element = $($(".content-navigation")[0]);
    this.titleDisplay = this.element.find(".post-navigator-title")[0];
    this.breadcrumbsDisplay = this.element.find(".post-navigator-index")[0];
};

pwell.ContentNavigator.prototype.update = function(data){
    var maxTitleLength = 20;
    var title = ""
    if(data.title.length > maxTitleLength){
        let chars = data.title.split("");
        let found = false;
        for(let i=maxTitleLength-4;i>maxTitleLength-5;i--){
            if(chars[i] === " "){
                found = true;
                title = chars.join("").slice(0,i)+" ...";
                break;
            }
        }
        if(!found){
            title = chars.join("").slice(0,maxTitleLength-4)+"...";
        }
    } else {
        title = data.title;
    }
    this.titleDisplay.innerHTML = title;

    let html = "";
    for(let key in data.headings){
        let heading = data.headings[key];
        html += "<li><a href='#p"+data.id+"_"+key+"'>"+heading+"</a></li>"
    }
    this.breadcrumbsDisplay.innerHTML = "<ul>"+html+"</ul>";

};