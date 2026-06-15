<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Add New User</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="tracking_add.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="trackingId" class="col-sm-3 control-label">Tracking ID</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="trackingId" name="trackingId" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="shipmentId" class="col-sm-3 control-label">Shipment ID</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="shipmentId" name="shipmentId" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dateShipped" class="col-sm-3 control-label">Shipment Date</label>

                    <div class="col-sm-9">
                      <input type="date" class="form-control" id="dateShipped" name="dateShipped" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="expDelDate" class="col-sm-3 control-label">Expected Delivery Date</label>

                    <div class="col-sm-9">
                      <input type="date" class="form-control" id="expDelDate" name="expDelDate" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="origin" class="col-sm-3 control-label">Origin</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="origin" name="origin" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="destination" class="col-sm-3 control-label">Destination</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="destination" name="destination" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="sender" class="col-sm-3 control-label">Sender</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="sender" name="sender" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="senderAdd" class="col-sm-3 control-label">Sender Address</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="senderAdd" name="senderAdd" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="receiver" class="col-sm-3 control-label">Receiver</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="receiver" name="receiver" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="receiverAdd" class="col-sm-3 control-label">Receiver Address</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="receiverAdd" name="receiverAdd" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="receiverEmail" class="col-sm-3 control-label">Receiver Email</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="receiverEmail" name="receiverEmail" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="terms" class="col-sm-3 control-label">Terms</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="terms" name="terms" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="reference" class="col-sm-3 control-label">Reference</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="reference" name="reference" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="orderNum" class="col-sm-3 control-label">Order Number</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="orderNum" name="orderNum" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="invoiceNum" class="col-sm-3 control-label">Invoice Number</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="invoiceNum" name="invoiceNum" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="quantity" class="col-sm-3 control-label">Quantity</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="quantity" name="quantity" required>
                    </div>
                </div>
                <p><b>Package</b></p>
                <div class="form-group">
                  <div class="col-sm-12">
                    <textarea id="editor1" name="package" rows="10" cols="80" required></textarea>
                  </div>
                  
                </div>
                <div class="form-group">
                    <label for="service" class="col-sm-3 control-label">Service</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="service" name="service" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="weight" class="col-sm-3 control-label">Weight</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="weight" name="weight" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dimensions" class="col-sm-3 control-label">Dimensions</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="dimensions" name="dimensions" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="location" class="col-sm-1 control-label">Location</label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="location" name="location" required>
                    </div>

                    <label for="dateAndTime" class="col-sm-1 control-label">Time & Date</label>
                    <div class="col-sm-5">
                      <input type="datetime-local" class="form-control" id="dateAndTime" name="dateAndTime" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="remark" class="col-sm-1 control-label">Info</label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="remark" name="remark" required>
                    </div>

                    <label for="status" class="col-sm-1 control-label">Status</label>
                    <div class="col-sm-5">
                      <select class="form-control" id="status" name="status" required>
                        <option value="Registered">- Registered -</option>
                        <option value="In Transit">- In Transit -</option>
                        <option value="On Hold">- On Hold -</option>
                        <option value="Delivered">- Delivered -</option>
                      </select>
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
              <h4 class="modal-title"><b>Edit Tracking</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="tracking_edit.php">
                <input type="hidden" class="trackingid" name="id">
                <div class="form-group">
                    <label for="trackingId" class="col-sm-3 control-label">Tracking ID</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_trackingId" name="trackingId" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="shipmentId" class="col-sm-3 control-label">Shipment ID</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_shipmentId" name="shipmentId" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dateShipped" class="col-sm-3 control-label">Shipment Date</label>

                    <div class="col-sm-9">
                      <input type="date" class="form-control" id="edit_dateShipped" name="dateShipped" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="expDelDate" class="col-sm-3 control-label">Expected Delivery Date</label>

                    <div class="col-sm-9">
                      <input type="date" class="form-control" id="edit_expDelDate" name="expDelDate" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="origin" class="col-sm-3 control-label">Origin</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_origin" name="origin" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="destination" class="col-sm-3 control-label">Destination</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_destination" name="destination" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="sender" class="col-sm-3 control-label">Sender</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_sender" name="sender" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="senderAdd" class="col-sm-3 control-label">Sender Address</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_senderAdd" name="senderAdd" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="receiver" class="col-sm-3 control-label">Receiver</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_receiver" name="receiver" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="receiverAdd" class="col-sm-3 control-label">Receiver Address</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_receiverAdd" name="receiverAdd" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="terms" class="col-sm-3 control-label">Terms</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_terms" name="terms" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="reference" class="col-sm-3 control-label">Reference</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_reference" name="reference" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="orderNum" class="col-sm-3 control-label">Order Number</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_orderNum" name="orderNum" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="invoiceNum" class="col-sm-3 control-label">Invoice Number</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_invoiceNum" name="invoiceNum" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="quantity" class="col-sm-3 control-label">Quantity</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_quantity" name="quantity" required>
                    </div>
                </div>
                <p><b>Package</b></p>
                <div class="form-group">
                  <div class="col-sm-12">
                    <textarea id="editor2" name="package" rows="10" cols="80" required></textarea>
                  </div>
                  
                </div>
                <div class="form-group">
                    <label for="service" class="col-sm-3 control-label">Service</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_service" name="service" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="weight" class="col-sm-3 control-label">Weight</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_weight" name="weight" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dimensions" class="col-sm-3 control-label">Dimensions</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_dimensions" name="dimensions" required>
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

<!-- Update -->
<div class="modal fade" id="update">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Update Tracking</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="tracking_update.php">
                <input type="hidden" id="update_trackingId" name="trackingId">
                <div class="form-group">
                    <label for="location" class="col-sm-3 control-label">Location</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dateAndTime" class="col-sm-3 control-label">Time & Date</label>

                    <div class="col-sm-9">
                      <input type="datetime-local" class="form-control" id="dateAndTime" name="dateAndTime" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="remark" class="col-sm-3 control-label">Info</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="remark" name="remark" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status" class="col-sm-3 control-label">Status</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="status" name="status" required>
                        <option value="Registered">- Registered -</option>
                        <option value="In Transit">- In Transit -</option>
                        <option value="On Hold">- On Hold -</option>
                        <option value="Delivered">- Delivered -</option>
                      </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="update"><i class="fa fa-plane"></i> Update Tracking</button>
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
              <form class="form-horizontal" method="POST" action="tracking_delete.php">
                <input type="hidden" class="trackingid" name="id">
                <div class="text-center">
                    <p>DELETE TRACKING</p>
                    <h2 class="bold trackingId"></h2>
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