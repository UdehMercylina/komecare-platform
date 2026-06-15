<!--Document Status -->
<div class="modal fade" id="file_status">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Change Document Status</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="document_change_status.php">
                <input type="hidden" class="fileid" name="id">
                <div class="form-group">
                    <label for="status" class="col-sm-3 control-label">Status</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="status" name="status" required>
                        <option selected id="edit_file_status"></option>
                        <option value="requested">- Requested -</option>
                        <option value="submitted">- Submitted -</option>
                        <option value="approved">- Approved -</option>
                      </select>
                    </div>
                </div>
                <div id="textareaContainer"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-info btn-flat" name="update_status"><i class="fa fa-th-large"></i> Change Status</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete document -->
<div class="modal fade" id="file_delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Deleting...</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="document_soft_delete.php">
                <input type="hidden" class="fileid" name="id">
                <div class="text-center">
                    <p>DELETE DOCUMENT</p>
                    <h2 class="bold filetitle"></h2>
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

<!-- Set Password -->
<div class="modal fade" id="password_set">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Set <span class="fullname"></span> Password</b></h4>
              <h2 class="userid"></h2>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="user_password_set.php">
                <input type="hidden" class="userid" name="id">
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>

                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="set_password"><i class="fa fa-check-square-o"></i> Set Password</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!--Request Document -->
<div class="modal fade" id="request_doc">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Request Document From <span class="fullname"></span></b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="document_request.php">
                <input type="hidden" class="userid" name="id">
                <div class="form-group">
                    <label for="document_list" class="col-sm-3 control-label">Document</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="document_list" name="document" required>
                        <option value="" selected disabled>- Select -</option>
                      </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-info btn-flat" name="request"><i class="fa fa-th-large"></i> Request Document</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Approve and Upload Profile -->
<div class="modal fade" id="upload">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Approve and Upload User to Recruitment</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="applicants_upload.php">
                <input type="hidden" class="userid" name="id">
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>

                    <div class="col-sm-9">
                      <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>

                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="edit_password" name="password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="firstname" class="col-sm-3 control-label">First Name</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_firstname" name="firstname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastname" class="col-sm-3 control-label">Last Name</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_lastname" name="lastname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="gender" class="col-sm-3 control-label">Gender</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="gender" name="gender" required>
                        <option selected id="edit_gender"></option>
                        <option value="male">- Male -</option>
                        <option value="female">- Female -</option>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dob" class="col-sm-3 control-label">Date of Birth</label>

                    <div class="col-sm-9">
                      <input type="date" class="form-control" id="edit_dob" name="dob" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="uname" class="col-sm-3 control-label">Username</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_uname" name="uname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="profile_code" class="col-sm-3 control-label">Profile Code</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_profile_code" name="profile_code" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone_no" class="col-sm-3 control-label">Phone Number</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_phone_no" name="phone_no" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-sm-3 control-label">Address (Street)</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_address" name="address" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="town_city" class="col-sm-3 control-label">Town/City</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_town_city" name="town_city" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="postcode" class="col-sm-3 control-label">Post Code</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_postcode" name="postcode" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="country" class="col-sm-3 control-label">Country</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_country" name="country" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="career_path" class="col-sm-3 control-label">Job Role</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_career_path" name="career_path" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="upload"><i class="fa fa-check-square-o"></i> Approve and Upload</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Reject Application -->
<div class="modal fade" id="reject">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Removing...</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="applicant_soft_delete.php">
                <input type="hidden" class="userid" name="id">
                <div class="text-center">
                    <p>REJECT APPLICATION</p>
                    <h2 class="bold fullname"></h2>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Reject</button>
              </form>
            </div>
        </div>
    </div>
</div>