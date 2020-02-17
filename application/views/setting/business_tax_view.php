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
                    <a onclick="openaddnew();" class="btn btn-custom waves-effect waves-light" >Create New <span class="m-l-5"><i class="fa fa-plus"></i></span></a>
                </div>
                <h4 class="page-title" >Business Taxes</h4>
            </div>


        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if ($this->session->flashdata('errorimage') && $this->session->flashdata('errorimage') != "") { ?>
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Warning!</strong> <?php echo $this->session->flashdata('errorimage'); ?>
                    </div>
                <?php } ?>
            </div>


        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">

                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="hidden">ID</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Percentage</th>
                                <th>Apply on</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (isset($business_tax)) {
                                foreach ($business_tax as $b) {
                                    ?>
                                    <tr>
                                        <td class="hidden"><?php echo $b['id_business_taxes']; ?></td>
                                        <td><?php echo $b['tax_name']; ?></td>
                                        <td><?php echo $b['tax_active'] == "Y" ? "<label class='label label-pink'>Yes</label>" : "<label class='label label-inverse'>No</label>"; ?></td>
                                        <td><?php echo $b['tax_percentage']; ?></td>
                                        <td><?php echo $b['tax_invoice_type']; ?></td>
                                        <td class='noprint' > 
                                            <button id='btnedit' onclick="openupdate(<?php echo $b['id_business_taxes']; ?>);" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button> 
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

        <!--Edit Service Category Modal-->
        <div id="edittax" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="edit$b" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit tax</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="edittax_title" class="control-label">Title</label>
                                            <input type="text" class="form-control" placeholder="Title" id="edittax_title" name="edittax_title">
                                        </div> 
                                    </div> 
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edittax_status" class="control-label">Status</label>
                                            <select class="form-control" id="edittax_status" name="edittax_status">
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>

                                        </div> 
                                    </div> 
                                     
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edittax_invoicetype" class="control-label">Apply On</label>
                                            <select class="form-control" id="edittax_invoicetype" name="edittax_invoicetype">
                                                <option value="service">Service</option>
                                                <option value="sale">Retail</option>
                                            </select>

                                        </div> 
                                    </div> 
                                
                                </div>

                            </div>
                            <div class="col-lg-6">


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="edittax_percentage" class="control-label">Percentage</label>
                                            <input type="text" class="form-control decimal" placeholder="Percentage" id="edittax_percentage" name="edittax_percentage">
                                        </div> 
                                    </div> 
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_business_taxes" id="id_business_taxes" />
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="update();" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Edit Service Category Modal-->

        <!--Add business tax modal start-->
        <div id="addtax" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="edit$b" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new tax</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="tax_title" class="control-label">Title</label>
                                            <input type="text" class="form-control" placeholder="Title" id="tax_title" name="tax_title">
                                        </div> 
                                    </div> 
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tax_status" class="control-label">Status</label>
                                            <select class="form-control" id="tax_status" name="tax_status">
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>

                                        </div> 
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tax_invoicetype" class="control-label">Apply On</label>
                                            <select class="form-control" id="tax_invoicetype" name="tax_invoicetype">
                                                <option value="service">Service</option>
                                                <option value="sale">Retail</option>
                                            </select>

                                        </div> 
                                    </div> 
                                </div>

                            </div>
                            <div class="col-lg-6">


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="tax_percentage" class="control-label">Percentage</label>
                                            <input type="text" class="form-control" placeholder="Percentage" id="tax_percentage" name="tax_percentage">
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
        <!--Add business tax modal end-->

        <script>
            $(document).ready(function() {
                $(".numeric").keypress(function(e) {
                    //if the letter is not digit then display error and don't type anything
                    if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                        return false;
                    }
                });


                $(".decimal").keypress(function(e) {
                    //if the letter is not digit then display error and don't type anything
                    if (e.which != 13 && e.which != 8 && e.which != 0  && e.which != 46 && (e.which < 48 || e.which > 57) ) {

                        return false;
                    }
                });



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

            function openupdate(id_business_taxes) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>business_controller/edit_business_Taxby_id',
                    data: {id_business_taxes: id_business_taxes},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        $("#edittax_title").val(data.tax_name);
                        $("#edittax_percentage").val(data.tax_percentage);
                        $("#edittax_status").val(data.tax_active);
                        $("#edittax_invoicetype").val(data.tax_invoice_type);
                        
                        $("#edittype").modal('show');
                    }
                });

                $('#id_business_taxes').val(id_business_taxes);
                $("#edittax").modal('show');
            }
            function update() {
                if ($("#edittax_title").val() !== "") {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>business_controller/business_taxes_update',
                        data: {
                            id_business_taxes: $("#id_business_taxes").val(),
                            tax_name: $("#edittax_title").val(),
                            tax_active: $("#edittax_status").val(),
                            tax_invoice_type: $("#edittax_invoicetype").val(),
                            tax_percentage: $("#edittax_percentage").val(),
                        },
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Business Tax Updated');
                                location.reload();
                            }
                        }
                    });
                }
            }

            function openaddnew() {
                $("#addtax").modal('show');
            }
            
            function addnew() {
                if ($("#tax_title").val() !== "") {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>business_controller/business_taxes_add',
                        data: {
                            tax_name: $("#tax_title").val(),
                            tax_active: $("#tax_status").val(),
                            tax_invoice_type: $("#tax_invoicetype").val(),
                            tax_percentage: $("#tax_percentage").val(),
                        },
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Business Tax Added');
                                location.reload();
                            }
                        }
                    });
                }
            }

        </script>