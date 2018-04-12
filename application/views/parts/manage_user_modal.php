<?php
/**
 * Created by PhpStorm.
 * User: Nexus
 * Date: 08.12.2017
 * Time: 21:22
 */
?>
<!-- Permission Modal -->
<div class="modal" id="manageUser" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ManagerLabel">Manage User</h4>
            </div>
            <form id="ManageUserForm" method="post" action="#">
                <div class="modal-body form-body">
                    <div class="slider">
                        <div class="form-response container-fluid">
                        </div>
                        <div class="form-group row">
                            <label for="register-username" class="col-xs-2 col-form-label">Username:</label>
                            <div class="col-xs-6">
                                <input class="form-control" name="username" type="text"
                                       placeholder="Username">
                            </div>
                            <button type="submit" class="btn btn-default col-xs-3">Load</button>
                        </div>
                    </div>

                    <div role="separator" class="divider"></div>
                    <div class="content">

                    </div>
                    <div role="separator" class="divider"></div>
                    <div class="actionButtons">
                        <button type="button" class="btn btn-danger disabled" onclick="if(pwell.modalController.userId !== 0){$('#manageUser').modal('hide'); pwell.modalController.confirmBan();}" >Ban User</button>
                        <button type="button" class="btn btn-danger disabled" onclick="if(pwell.modalController.userId !== 0){$('#manageUser').modal('hide'); pwell.modalController.confirmDelete();}">Delete User</button>
                        <button type="button" class="btn btn-primary disabled" onclick="if(pwell.modalController.userId !== 0){$('#manageUser').modal('hide'); pwell.modalController.permission();}">permissions</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>