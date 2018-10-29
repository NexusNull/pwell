

if (typeof pwell == "undefined")
    pwell = {};

pwell.ImageManager = function(){
    this.searchBar = $(".image-search-bar")[0];
    this.increment = 0;

    this.currentSelection = null;
    this.quillInstance = null;
    this.image_manage = $("#image_manage");
    this.image_upload = $("#image_upload");
    this.image_menu = $("#image_menu");

    this.selector = this.image_manage.find(".image-selector")[0];
    this.imageEditor = this.image_manage.find(".image-editor-settings");
    this.previewImg = this.image_manage.find(".image-editor-preview-img")[0];
    this.previewName = this.image_manage.find(".preview-img-name")[0];
    this.previewDimensions = this.image_manage.find(".preview-img-dimensions")[0];
    this.previewSize = this.image_manage.find(".preview-img-size")[0];
    this.previewFileType = this.image_manage.find(".preview-img-file-type")[0];
    this.chooseButton = this.image_manage.find(".image-editor-upload-button")[0];
};

pwell.ImageManager.prototype.search = function(name){
    var self = this;
    pwell.rest.getImageByName(name,{
        success: function(msg, data){
            self.updateUI(data);
        },
        error: function(error){
            console.log(error)
        }
    });
};

pwell.ImageManager.prototype.updateImageDisplay = function(id){
    var self = this;
    console.log(2);
    pwell.rest.getImageById(id,{
        success:function(msg, data){
            self.currentSelection = data;
            $(self.previewImg).attr("src", "uploads/original/"+ data.file_name);

            let size = {x:data.size_x, y: data.size_y};

            let fileName = data.name;
            let tmp = fileName.split(".");
            let fileExtension = data.file_type;

            let fileSize = pwell.util.bytesToSize(data.file_size);

            self.previewName.innerText = fileName;
            self.previewDimensions.innerText = size.x+" / "+size.y;
            self.previewSize.innerText = fileSize;
            self.previewFileType.innerText = fileExtension;
        }
    })



};
pwell.ImageManager.prototype.updateUI = function(data){
    this.selector.innerHTML = "";
    for(let i =0; i < data.length; i++){
        var image = data[i];
        let ele = document.createElement("div");
        ele.classList.add("image-card");
        ele.innerHTML = "<div onclick=\"pwell.imageManager.updateImageDisplay("+image.id+")\">\n" +
            "<span></span><img src=\"uploads/small/"+image.filename+"\" class=\"img-fluid\">\n" +
            "</div>";
        this.selector.appendChild(ele);
    }
};

pwell.ImageManager.prototype.setQuill= function(quill){
    this.quillInstance = quill;

};

$(document).ready(function () {
    pwell.imageManager = new pwell.ImageManager();
    pwell.imageManager.searchBar.addEventListener("keyup",function(){
        var i = ++pwell.imageManager.increment;
        setTimeout(function(){
            if(i === pwell.imageManager.increment){
                pwell.imageManager.search(pwell.imageManager.searchBar.value);
            }
        },250);
    });
    pwell.imageManager.chooseButton.addEventListener("click",function(){
        var self = pwell.imageManager;
        console.log(self.currentSelection);
        self.image_manage.modal("hide");
        if(self.currentSelection)
            self.quillInstance.insertEmbed(10, 'image', '/uploads/original/'+self.currentSelection.file_name);
    });
});
