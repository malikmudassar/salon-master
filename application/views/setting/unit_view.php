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
                <h4 class="page-title" >Measurement Units</h4>

            </div>


        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">

                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th >ID Unit</th>
                                <th>Unit</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (isset($measure_unit)) {
                                foreach ($measure_unit as $unit) {
                                    ?>
                                    <tr>
                                        <td><?php echo $unit['id_measurement_unit']; ?></td>
                                        <td><?php echo $unit['m_unit']; ?></td>
                                        <td class='noprint' > 
                                            <button id='btnedit' onclick="openupdate(<?php echo $unit['id_measurement_unit']; ?>);" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button> 
                                        </td>
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

        <!--Add Unit Modal-->
        <div id="addunit" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addunit" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new Unit</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="unitname" class="control-label">Unit</label>
                                            <input type="text" class="form-control" placeholder="Unit" id="unitname" name="unitname">
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
        <!--End Unit Modal-->

        <!--Edit Unit Modal-->
        <div id="editunit" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editunit" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Unit</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="editunitid" class="control-label">ID</label>
                                            <input type="text" class="form-control" readonly id="editunitid" name="editunitid">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="editunitname" class="control-label">Unit</label>
                                            <input type="text" class="form-control" placeholder="Unit" id="editunitname" name="editunitname">
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
        <!--End Edit Unit Modal-->

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

                $(".numeric").keypress(function(e) {
                    //if the letter is not digit then display error and don't type anything
                    if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                        return false;
                    }
                });

            });

            function deleteproduct(productid) {

                //Warning Message
                swal({
                    title: "Are you sure?",
                    text: "This action will also remove all services in this category!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn-warning',
                    confirmButtonText: "Yes, remove it!",
                    closeOnConfirm: true
                }, function() {
                    $.ajax({
                        type: 'POST',
                        url: 'product_controller/delete_product',
                        data: {id_business_products: productid},
                        success: function(data) {
                            var result = data.split("|");

                            if (result[0] === "success") {
                                swal("Deleted!", "Product has been removed.", "success");
                                location.reload();
                            } else {
                                swal("Error!", "Product was not removed!.", "error");
                            }
                        }
                    });
                });
            }

            function openaddnew() {
                $("#addunit").modal('show');
            }
            function addnew() {
                if ($("#unitname").val() !== "") {

                    //console.log(services);
                    $.ajax({
                        type: 'POST',
                        url: 'unit_controller/add_unit',
                        data: {m_unit: $("#unitname").val()},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'New Unit Added');
                                location.reload();
                            }
                        }
                    });
                }
            }


            function openupdate(id_measurement_unit) {

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>unit_controller/edit_unit',
                    data: {id_measurement_unit: id_measurement_unit},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        $("#editunitid").val(id_measurement_unit);
                        $("#editunitname").val(data.m_unit);


                        $("#editunit").modal('show');
                        
                    }
                });
            }
            function update() {
                if ($("#editunitname").val() !== "") {

                    $.ajax({
                        type: 'POST',
                        url: 'unit_controller/update_unit',
                        data: {id_measurement_unit: $("#editunitid").val(), m_unit: $("#editunitname").val()},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Unit Updated');
                                location.reload();
                            }
                        }
                    });
                }
            }


        </script>