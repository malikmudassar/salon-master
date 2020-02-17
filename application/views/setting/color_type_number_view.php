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
                <h4 class="page-title" >Color in <?php echo $color_type[0]['type']; ?> Type</h4>
                <input id='txt_id_type' name='txt_id_type' type='hidden' value="<?php echo $color_type[0]['id']; ?>"
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
                                <th>Color Number</th>
                                <th>Active</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (isset($color_numbers)) {
                                foreach ($color_numbers as $number) {
                                    ?>
                                    <tr>
                                        <td ><?php echo $number['id']; ?></td>
                                        <td><?php echo $number['number']; ?></td>
                                        <td><span class="label <?php
                                            if ($number['status'] === "Yes") {
                                                echo 'label-pink';
                                            } else {
                                                echo 'label-inverse';
                                            }
                                            ?>"><?php echo $number['status']; ?></span></td>
                                        <td class='noprint'> <button id='btnedit' onclick="openupdate(<?php echo $number['id']; ?>);" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button>  </td>
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
        <div id="addcolornumber" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addcolornumber" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new Color Number</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcolornumber" class="control-label">Color Number</label>
                                            <input type="text" class="form-control" placeholder="Color Number" id="txtcolornumber" name="txtcolornumber">
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
        <div id="editcolornumber" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editcolornumber" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Color Number </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcolornumberid" class="control-label">ID</label>
                                            <input readonly="readonly" type="text" class="form-control" placeholder="ID" id="txteditcolornumberid" name="txteditcolornumberid">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcolornumber" class="control-label">Color Number</label>
                                            <input type="text" class="form-control" placeholder="Color Number" id="txteditcolornumber" name="txteditcolornumber">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcolorstatus" class="control-label">Active</label>
                                            <select class="form-control" id="txteditcolorstatus" name="txteditcolorstatus">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>

                                        </div> 
                                    </div> 
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="update();" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Edit Service  Modal-->

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
                    responsive: !0
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

            });

            function openaddnew() {
                $("#addcolornumber").modal('show');
            }
            function addnew() {
                if ($("#txtcolornumber").val() !== "" && $("#txtcolornumber").val() !== "") {
                    $.ajax({
                        type: 'POST',
                        url: 'colors_controller/add_color_number',
                        data: {color_number: $("#txtcolornumber").val(), type_id: $("#txt_id_type").val()},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'New Color Number Added');
                                location.reload();
                            }
                        }
                    });
                }
            }


            function openupdate(id) {
                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>colors_controller/edit_color_number',
                    data: {id_color_number: id},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        $("#txteditcolornumberid").val(id);
                        $("#txteditcolornumber").val(data.number);
                        $("#txteditcolorstatus").val(data.status);
                        
                        $("#editcolornumber").modal('show');
                        
                    }
                });
            }
            function update() {
                if ($("#txteditcolornumber").val() !== "") {
                    $.ajax({
                        type: 'POST',
                        url: 'colors_controller/update_color_number',
                        data: {id_number: $("#txteditcolornumberid").val(), color_number: $("#txteditcolornumber").val(), status: $("#txteditcolorstatus").val()},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Color Number Updated');
                                location.reload();
                            }
                        }
                    });
                }
            }

        </script>