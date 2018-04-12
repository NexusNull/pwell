<?php
/**
 * Created by PhpStorm.
 * User: Nexus
 * Date: 11.12.2017
 * Time: 11:10
 */
?>
<!-- Delete Modal -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ManagerLabel">Delete User</h4>
            </div>
                <div class="modal-body form-body">
                    <p>
                    This action will remove all data related to the user from the Database, it is permanent and can not be undone.
                    Confirm below.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </div>

        </div>
    </div>
</div>
