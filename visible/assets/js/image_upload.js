
if (typeof pwell == "undefined")
    pwell = {};
if (typeof pwell.util == "undefined")
    pwell.util = {};

pwell.util.bytesToSize = function(bytes) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0) return '0 Byte';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
};

pwell.ImageUploader = function(){
    this.files = [];
    this.isUploading = false;

    this.image_upload_progress = $("#image_upload_progress");
    this.image_manage = $("#image_manage");
    this.image_upload = $("#image_upload");
    this.image_menu = $("#image_menu");



    this.selector = this.image_upload.find(".image-selector")[0];
    this.imageEditor = this.image_upload.find(".image-editor-settings");
    this.previewImg = this.image_upload.find(".image-editor-preview-img")[0];
    this.previewName = this.image_upload.find(".preview-img-name")[0];
    this.previewDimensions = this.image_upload.find(".preview-img-dimensions")[0];
    this.previewSize = this.image_upload.find(".preview-img-size")[0];
    this.previewFileType = this.image_upload.find(".preview-img-file-type")[0];
    this.uploadButton = this.image_upload.find(".image-editor-upload-button")[0];
    console.log(this.imageEditor)
    this.uploadButton.addEventListener("click", this.uploadImages.bind(this));

};

pwell.ImageUploader.prototype.updateImageList = function(){
    this.selector.innerHTML = "";
    for(let i=0; i < this.files.length; i++){
        var file = this.files[i];
        let ele = document.createElement("div");
        ele.classList.add("image-card");
        file.element = ele;
        if(file.dataURL){
            ele.innerHTML = "<div onclick=\"pwell.imageController.updateImageDisplay("+i+")\">\n" +
                "<span></span><img src=\""+file.dataURL+"\" class=\"img-fluid\">\n" +
                "</div>";
        } else {
            ele.innerHTML = "<div onclick=\"pwell.imageController.updateImageDisplay("+i+")\">\n" +
                "<span></span><img src=\"assets/img/reload.svg\" class=\"img-fluid\">\n" +
                "</div>";
        }
        this.selector.appendChild(ele);
    }
};

pwell.ImageUploader.prototype.updateImageDisplay = function(id){
    var file = this.files[id];
    $(this.previewImg).attr("src", this.files[id].dataURL);

    let img = new Image();
    img.src = file.dataURL;
    let size = {x:img.width, y: img.height};

    let fileName = file.name;
    let tmp = fileName.split(".");
    let fileExtension = tmp[tmp.length-1].toLowerCase();

    let fileSize = pwell.util.bytesToSize(file.size);

    this.previewName.innerText = fileName;
    this.previewDimensions.innerText = size.x+" / "+size.y;
    this.previewSize.innerText = fileSize;
    this.previewFileType.innerText = fileExtension;
};

pwell.ImageUploader.prototype.addImages = function(files){
    let result = [];
    var self = this;
    for(var i=0;i < files.length; i++){
        result[i] = files[i];
        result[i].dataURL = null;
        (function(index, imageIndex){
            let fileReader = new FileReader();
            fileReader.readAsDataURL(files[index]);
            fileReader.onloadend = function(){
                self.files[imageIndex].dataURL = this.result;
                let jqueryElement = $(self.files[imageIndex].element).find("img");

                if(jqueryElement){
                    jqueryElement.attr("src", this.result);
                }
            }
        })(i, i+self.files.length);
    }
    this.files = this.files.concat(result);
    this.updateImageList();
};

pwell.ImageUploader.prototype.deleteImage = function(id){

};
pwell.ImageUploader.prototype.uploadImages = function(){
    var self = this;
    this.isUploading = true;
    this.image_upload.modal("hide");
    setTimeout(function(){
        let max = self.files.length;
        let current = 0;
        self.image_upload_progress.modal("show");
        let element = self.image_upload_progress.find(".progress-bar")[0];
        element.innerHTML = current + " / " + max;
        element.style.width = ((current/max)*100)+"%";
        let uploadNext = function(){
            console.log(current)
            if(current < max){
                pwell.rest.uploadImage(self.files[current],"",{
                    error: uploadNext,
                    success: uploadNext
                });
                current++;
                element.innerHTML = current + " / " + max;
                element.style.width = ((current/max)*100)+"%";
            } else {
                self.image_upload_progress.modal("hide");
                console.log("Finished upload.")
            }
        };
        console.log("Started upload of "+max+ " files ...");
        uploadNext();
    },500)

};

var files;
$(document).ready(function () {
    pwell.imageController = new pwell.ImageUploader()
    let dropArea = document.getElementById('image_upload')

    function handlerFunction(event){
        event.preventDefault();
        console.log(arguments);
    }

    dropArea.addEventListener('dragenter', handlerFunction, false);
    dropArea.addEventListener('dragleave', handlerFunction, false);
    dropArea.addEventListener('dragover', handlerFunction, false);
    dropArea.addEventListener('drop', function(e) {
        event.preventDefault();
        pwell.imageController.addImages(e.dataTransfer.files);
    }, false)

    var inputElement = document.getElementById("image-file-input");
    inputElement.addEventListener("change", handleFiles, false);
    function handleFiles(event) {
        pwell.imageController.addImages(inputElement.files);
    }
});
