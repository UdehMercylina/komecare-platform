<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Open Availability Edit For User</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="availability_status.php">
                <input type="hidden" class="userid" name="id">
                <div class="form-group">
                    <label for="status" class="col-sm-3 control-label">Status</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="status" name="status" required>
                        <option selected id="edit_avail_status" style="text-transform: capitalize;"></option>
                        <option value="open"> Open </option>
                        <option value="close"> Close </option>
                      </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Reset Availability -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Reset Availability...</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="availability_soft_delete.php">
                <input type="hidden" class="userid" name="id">
                <div class="text-center">
                    <p>RESET USER AVAILABILITY</p>
                    <h2 class="bold fullname"></h2>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Reset</button>
              </form>
            </div>
        </div>
    </div>
</div>    