<!-- Assign -->
<div class="modal fade" id="assign">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Assign New Task</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="taskassign_add.php" enctype="multipart/form-data">
                <input type="hidden" class="userid" name="id">
                <div class="form-group">
                    <label for="manager" class="col-sm-3 control-label">Project Manager</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="manager" name="pm_id" required>
                        <option value="" selected>- Select -</option>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="task_delegate_date" class="col-sm-3 control-label">Task Delegation Time & Date</label>

                    <div class="col-sm-9">
                      <input type="datetime-local" class="form-control" id="task_delegate_date" name="task_delegate_date" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="task_submit_date" class="col-sm-3 control-label">Task Submission Time & Date</label>

                    <div class="col-sm-9">
                      <input type="datetime-local" class="form-control" id="task_submit_date" name="task_submit_date" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="task_title" class="col-sm-3 control-label">Task Title</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="task_title" name="task_title" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="task_description_summary" class="col-sm-3 control-label">Task Summary</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="task_description_summary" name="task_description_summary" required>
                    </div>
                </div>

                <p><b>Task Description</b></p>
                <div class="form-group">
                  <div class="col-sm-12">
                    <textarea id="editor1" name="task_description" rows="10" cols="80"></textarea>
                  </div>
                  
                </div>

                <div class="form-group">
                    <label for="task_file" class="col-sm-2 control-label">Task Files (Optional)</label>

                    <div class="col-sm-4">
                      <input type="file" id="task_file" name="task_file[]" multiple>
                    </div>

                    <div class="col-sm-6">
                      <input type="text" id="task_file_name" name="task_file_name" placeholder="Enter file name">
                    </div>
                </div>

                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Edit Task</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="task_edit.php" enctype="multipart/form-data">
                <input type="hidden" class="task_id" name="task_id">
                <input type="hidden" class="user_id" name="id">
                <div class="form-group">
                    <label for="edit_manager" class="col-sm-3 control-label">Project Manager</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="edit_manager" name="pm_id">
                        <option id="pmselected" selected>- Select -</option>
                      </select>
                    </div>
                </div>                
                <div class="form-group">
                    <label for="edit_task_delegate_date" class="col-sm-3 control-label">Task Delegation Time & Date</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_task_delegate_date" name="task_delegate_date" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_task_submit_date" class="col-sm-3 control-label">Task Submission Time & Date</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_task_submit_date" name="task_submit_date" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_task_title" class="col-sm-3 control-label">Task Title</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_task_title" name="task_title" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_task_description_summary" class="col-sm-3 control-label">Task Summary</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_task_description_summary" name="task_description_summary" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_task_status" class="col-sm-3 control-label">Task Status</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="edit_task_status" name="task_status" required>
                        <option value="">- Select -</option>
                        <option value="pending">- Pending -</option>
                        <option value="completed">- Completed -</option>
                        <option value="reassigned">- Reassign -</option>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="task_file" class="col-sm-2 control-label">Add Task Files (Optional)</label>

                    <div class="col-sm-4">
                      <input type="file" id="task_file" name="task_file[]" multiple>
                    </div>

                    <div class="col-sm-6">
                      <input type="text" id="task_file_name" name="task_file_name" placeholder="Enter file name">
                    </div>
                </div>

                <p><b>Task Description</b></p>
                <div class="form-group">
                  <div class="col-sm-12">
                    <textarea id="editor2" name="task_description" rows="10" cols="80"></textarea>
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

<!-- Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Deleting...</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="task_delete.php">
                <input type="hidden" class="task_id" name="id">
                <div class="text-center">
                    <p>DELETE TASK</p>
                    <h2 class="bold task_title"></h2>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
              </form>
            </div>
        </div>
    </div>
</div>