<?php
/**
 * Created by PhpStorm.
 * User: nexus
 * Date: 31/08/2018
 * Time: 22:54
 */
?>
<div class="modal fade" id="image_menu" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MenuLabel">Select action</h4>
            </div>
            <div class="modal-body image-menu-body">
                <button class="big-button ripple" onclick="$('#image_menu').modal('hide'); setTimeout(function(){$('#image_manage').modal('show');},500);">
                    <div>
                        <img src="assets/img/manage-images.svg" class="svg">
                    </div>

                </button><button class="big-button ripple" onclick="$('#image_menu').modal('hide');setTimeout(function(){$('#image_upload').modal('show');},500);">
                    <div>
                        <img src="assets/img/upload-image.svg" class="svg">
                    </div>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="image_upload" tabindex="-1" role="dialog" ondrop="console.log(event)">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MenuLabel">Upload an image</h4>
            </div>
            <div class="modal-body image-menu-body">
                <div class="container-fluid row">
                    <div class="row">
                        <div class="col-xs-6 image-selector">
                        </div>
                        <div class="col-xs-6 image-editor">
                            <div class="image-editor-preview">
                                <img src="" class="image-editor-preview-img">
                            </div>
                            <div class="image-editor-settings">
                                <div class="row">
                                    <div class="col-sm-6 font-bold">Name:</div>
                                    <div class="col-sm-6 preview-img-name">The Name</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 font-bold">Size:</div>
                                    <div class="col-sm-6 preview-img-dimensions">1080 / 720</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 font-bold">File Size:</div>
                                    <div class="col-sm-6 preview-img-size">5 MB</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 font-bold">File Type:</div>
                                    <div class="col-sm-6 preview-img-file-type">mp4</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <label for="image-file-input" class="btn btn-default float-left">Choose the files</label>
                <input id="image-file-input" type="file" class="form-control" multiple accept="image/*">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary image-editor-upload-button">Upload</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="image_manage" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MenuLabel">Manage all images</h4>
            </div>
            <div class="modal-body image-menu-body">
                <div class="container-fluid row">
                    <div class="row">
                        <div class="search-box-container">
                        </div>
                        <div class="col-xs-6">
                            <input  type="text" class="form-control image-search-bar"><i class="fa fa-search image-search-bar-icon" aria-hidden="true"></i>
                            <div class="image-selector">

                            </div>
                        </div>
                        <div class="col-xs-6 image-editor">
                            <div class="image-editor-preview">
                                <img src="" class="image-editor-preview-img">
                            </div>
                            <div class="image-editor-settings">
                                <div class="row">
                                    <div class="col-sm-6 font-bold">Name:</div>
                                    <div class="col-sm-6 preview-img-name">The Name</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 font-bold">Size:</div>
                                    <div class="col-sm-6 preview-img-dimensions">1080 / 720</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 font-bold">File Size:</div>
                                    <div class="col-sm-6 preview-img-size">5 MB</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 font-bold">File Type:</div>
                                    <div class="col-sm-6 preview-img-file-type">mp4</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary image-editor-upload-button">Choose</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="image_upload_progress" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="MenuLabel">Manage all images</h4>
            </div>
            <div class="modal-body">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>