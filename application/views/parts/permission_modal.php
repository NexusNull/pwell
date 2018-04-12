<?php
/**
 * Created by PhpStorm.
 * User: Nexus
 * Date: 08.12.2017
 * Time: 21:22
 */
?>
<!-- Permission Modal -->
<div class="modal fade" id="permission" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ManagerLabel">Permissions of <span class="username"></span>. </h4>
            </div>
            <form id="PermissionForm" method="post" action="#">
                <div class="modal-body form-body">
                    <div class="slider">
                        <div class="form-response container-fluid">
                        </div>
                        <input type="text" class="id" hidden="hidden" name="id">
                        <div class="content">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Set Permission</button>
                </div>
            </form>
        </div>
    </div>
</div>