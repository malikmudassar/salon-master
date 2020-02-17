<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datetimepicker/js/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<style type="text/css">
    @media print
    {
        .noprint {display:none;}
    }
</style>
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    <button type="button"  onclick="openaddnew();" class="btn btn-custom waves-effect waves-light" >Add <span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                    
                </div>
                <h4 class="page-title" >Time Block Reasons</h4>
                
            </div>


        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">

                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Block event name</th>
                                <th>Description</th>
                                <th>Duration</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (isset($timebockreason)) {
                                foreach ($timebockreason as $reason) {
                                    ?>
                                    <tr>
                                        <td><?php echo $reason['id_block_events']; ?></td>
                                        <td><?php echo $reason['block_event_name']; ?></td>
                                        <td><?php echo $reason['block_event_desc']; ?></td>
                                        <td><?php echo $reason['block_event_duration']; ?></td>
                                        <td class='noprint'> <button id='btnedit' onclick="openupdate('<?php echo $reason['id_block_events']; ?>');" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button>  </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

        <!--Modals-->

        <!--Add Service  Modal-->
        <div id="addservice" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addservice" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new Block Event</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="blockeventname" class="control-label">Block Event Name</label>
                                            <input type="text" class="form-control" placeholder="Block Event Name" id="blockeventname" name="blockeventname">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description" class="control-label">Description</label>
                                            <input type="text" class="form-control" placeholder="Description" id="description" name="description">
                                        </div> 
                                    </div> 
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="duration" class="control-label">Duration</label>
                                        <div class="input-group" >
                                            <div class="bootstrap-timepicker" >
                                                <input id="duration" name="duration" type="text" class="form-control" style="position:relative; z-index: 99999999 !important;">
                                            </div>
                                            <span class="input-group-addon bg-pink b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="addnew();" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Add Service  Modal-->

        <!--Edit Service  Modal-->
        <div id="editservice" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editservice" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Block Event </h4>
                    </div>
                    <div class="modal-body">
                       <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="editblockeventname" class="control-label">Block Event Name</label>
                                            <input type="text" class="form-control" placeholder="Block Event Name" id="editblockeventname" name="editblockeventname">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="editdescription" class="control-label">Description</label>
                                            <input type="text" class="form-control" placeholder="Description" id="editdescription" name="editdescription">
                                        </div> 
                                    </div> 
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="editduration" class="control-label">Duration</label>
                                        <div class="input-group" >
                                            <div class="bootstrap-timepicker" >
                                                <input id="editduration" name="editduration" type="text" class="form-control" style="position:relative; z-index: 99999999 !important;">
                                            </div>
                                            <span class="input-group-addon bg-pink b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="eventid" id="eventid" />
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="update();" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Edit Service  Modal-->

        <!--Color Modal Start-->
        <div id="color_modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="color_modal" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Service Color </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-1">&nbsp;</div>
                            <div class="col-lg-10">
                                <span style="width:100%; height: 200px;" id="idcolor" class="btn"></span>
                            </div>
                            <div class="col-lg-1">&nbsp;</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--Color Modal End-->
        <script>
            $(document).ready(function() {

                $('#datatable-buttons').DataTable({
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    stateSave: true,
                    dom: "Bfrtlip",
                    buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"}, {
                            extend: "excel",
                            className: "btn-sm btn-warning btn-trans"
                        }, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}],
                    responsive: !0,
                    
                });


                toastr.options = {
                    "closeButton": true,
                    "debug": true,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-bottom-center",
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }

                $("#duration").datetimepicker({
                    format: 'HH:mm:00',
                    enabledHours: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    allowInputToggle: true,
                    stepping: 5
                });

                $("#editduration").datetimepicker({
                    format: 'HH:mm:00',
                    enabledHours: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    allowInputToggle: true,
                    stepping: 5
                });
                
               
                $(".vertical-spin").TouchSpin({
                    verticalbuttons: true,
                    buttondown_class: "btn btn-primary",
                    buttonup_class: "btn btn-primary",
                    verticalupclass: 'ti-plus',
                    verticaldownclass: 'ti-minus'
                });
                var vspinTrue = $(".vertical-spin").TouchSpin({
                    verticalbuttons: true
                });
                if (vspinTrue) {
                    $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
                }

            });
            

            function deleteservice(serviceid) {

                //Warning Message
                swal({
                    title: "Are you sure?",
                    text: "This action cannot be reverted back!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn-warning',
                    confirmButtonText: "Yes, remove it!",
                    closeOnConfirm: true
                }, function() {
                    $.ajax({
                        type: 'POST',
                        url: 'service_controller/delete_service',
                        data: {id_business_services: serviceid},
                        success: function(data) {
                            var result = data.split("|");

                            if (result[0] === "success") {
                                swal("Deleted!", "Service has been removed.", "success");
                                location.reload();
                            } else {
                                swal("Error!", "Service was not removed!.", "error");
                            }
                        }
                    });
                });
            }

            function openaddnew() {
                $("#addservice").modal('show');
            }
            function addnew() {
                if ($("#blockeventname").val() !== "" && $("#duration").val() !== "" && $("#description").val() !== "") {
                    
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>welcome/add_blockevent',
                        data: {blockeventname: $('#blockeventname').val(),description: $('#description').val(),duration: $('#duration').val()},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'New Block Event Added');
                                location.reload();
                            }
                        }
                    });
                }else{
                    swal("Warning!", "Please give event name/description & duration", "warning");
                }
            }


            function openupdate(id_block_events) {
            
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>welcome/get_edit_blockevent',
                    data: {id_block_events: id_block_events},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        $("#eventid").val(id_block_events);
                        $("#editblockeventname").val(data.block_event_name);
                        $("#editduration").val(data.block_event_duration);
                        $("#editdescription").val(data.block_event_desc);

                        $("#editservice").modal('show');
                        
                    }
                });
            }
            function update() {
                if ($("#editblockeventname").val() !== "" && $("#editduration").val() !== "" && $("#editdescription").val() !== "") {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>welcome/edit_blockevent',
                       data: {eventid: $('#eventid').val(),blockeventname: $('#editblockeventname').val(),description: $('#editdescription').val(),duration: $('#editduration').val()},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Block Event Updated');
                                location.reload();
                            }
                        }
                    });
                }else{
                    swal("Warning!", "Please give event name/description & duration", "warning");
                }
            }

        </script>