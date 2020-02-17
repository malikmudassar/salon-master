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
                    <a href="<?php echo base_url('business/tax'); ?>" class="btn btn-custom waves-effect waves-light" >Tax Setting</a>
                </div>
                <h4 class="page-title" >Business</h4>
            </div>


        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if ($this->session->flashdata('errorimage') && $this->session->flashdata('errorimage') != ""){  ?>
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
                                <th>Business Logo</th>
                                <th>Business Name</th>
                                <th>Business Owner</th>
                                <th>Business Contact</th>
                                <th>Business Phones</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (isset($business)) {
                                foreach ($business as $b) {
                                    ?>
                                    <tr>
                                        <td class="hidden"><?php echo $b['id_business']; ?></td>
                                        <td>
                                            <a onclick="upload_image(<?php echo $b['id_business']; ?>, '<?php echo $b['business_logo'] ? $b['business_logo'] : NULL; ?>');" href="javascript:void(0)">
                                                <img width="150" src="<?php echo base_url(); ?>/assets/images/business/<?php echo $b['business_logo']; ?>" />
                                            </a>

                                        </td>
                                        <td><?php echo $b['business_name']; ?></td>
                                        <td><?php echo $b['business_owner']; ?></td>
                                        <td><?php echo $b['business_owner_contact']; ?></td>
                                        <td><?php echo $b['business_phone1'] . ',<br>' . $b['business_phone2'] . ',<br>' . $b['business_phone3'] . ',<br>' . $b['business_phone4']; ?></td>
                                        <td class='noprint' > 
                                            <button id='btnedit' onclick="openupdate(<?php echo $b['id_business']; ?>);" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button> 
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
        <div id="edittype" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="edit$b" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Business</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="business_name" class="control-label">Business Name</label>
                                            <input type="text" class="form-control" placeholder="Business Name" id="business_name" name="business_name">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="business_contact" class="control-label">Business Contact</label>
                                            <input type="text" class="form-control" placeholder="Business Contact" id="business_contact" name="business_contact">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="business_phone2" class="control-label">Business Phone 2</label>
                                            <input type="text" class="form-control" placeholder="Business Phone 2" id="business_phone2" name="business_phone2">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="business_phone4" class="control-label">Business Phone 4</label>
                                            <input type="text" class="form-control" placeholder="Business Phone 4" id="business_phone4" name="business_phone4">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row hidden">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="business_opening_time" class="control-label">Business Opening Time</label>
                                            <input type="text" class="form-control" placeholder="Business Opening Time" id="business_opening_time" name="business_opening_time">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="business_area" class="control-label">Business Area</label>
                                            <input type="text" class="form-control" placeholder="Business Area" id="business_area" name="business_area">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="tax_optional" class="control-label">Tax (optional)</label>
                                            <select class="form-control" id="tax_optional" name="tax_optional">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>

                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="staff_stats" class="control-label">Show Staff Stats</label>
                                            <select class="form-control" id="staff_stats" name="staff_stats">
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>

                                        </div> 
                                    </div> 
                                </div>
                                
                                <div class="row hidden">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="payment_terms" class="control-label">Payment Term</label>
                                            <textarea class="form-control" name="payment_terms" id="payment_terms"></textarea>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="business_owner" class="control-label">Business Owner</label>
                                            <input type="text" class="form-control" placeholder="Business Onwer" id="business_owner" name="business_owner">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="business_phone1" class="control-label">Business Phone 1</label>
                                            <input type="text" class="form-control" placeholder="Business Phone 1" id="business_phone1" name="business_phone1">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="business_phone3" class="control-label">Business Phone 3</label>
                                            <input type="text" class="form-control" placeholder="Business Phone 3" id="business_phone3" name="business_phone3">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row hidden">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="business_closing_time" class="control-label">Business Closing Time</label>
                                            <input type="text" class="form-control" placeholder="Business Closing Time" id="business_closing_time" name="business_closing_time">
                                        </div> 
                                    </div> 
                                </div>
                                
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="rec_allow_prev" class="control-label">Historical Data (Schedular)</label>
                                            <select class="form-control" id="rec_allow_prev" name="rec_allow_prev">
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>

                                        </div> 
                                    </div> 
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="business_address" class="control-label">Business Address</label>
                                            <textarea name="business_address" id="business_address" class="form-control"></textarea>
                                        </div> 
                                    </div> 
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="allow_stock_update" class="control-label">Allow Stock Update for Store Manager</label>
                                            <select class="form-control" id="allow_stock_update" name="allow_stock_update">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="allow_price_update" class="control-label">Allow Price Update for Store Manager</label>
                                            <select class="form-control" id="allow_price_update" name="allow_price_update">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="scheduler_input_search" class="control-label">Show Cash Register</label>
                                            <select class="form-control" id="show_cash_register" name="show_cash_register" >
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div> 
                                    </div> 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="scheduler_input_search" class="control-label">Search Sequence</label>
                                            <select class="form-control" id="scheduler_input_search" name="scheduler_input_search" >
                                                <option value="N">Name First</option>
                                                <option value="Y">Cellphone First</option>
                                            </select>
                                        </div> 
                                    </div> 
                                    
                                     <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="scheduler_style" class="control-label">Scheduler View</label>
                                            <select class="form-control" id="scheduler_style" name="scheduler_style" >
                                                <option value="agendaDay">Staff on Top</option>
                                                <option value="timelineDay">Time on Top</option>
                                            </select>
                                        </div> 
                                    </div> 
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="show_professional" class="control-label">Can Sell Professional Products</label>
                                            <select class="form-control" id="show_professional" name="show_professional" >
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="cc_charge" class="control-label">Charge %age on Credit Cards</label>
                                            <input class="form-control decimal" id="cc_charge" name="cc_charge" />
                                                
                                        </div> 
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="walkin_enable" class="control-label">Walk-In Customers Allowed</label>
                                            <select class="form-control" id="walkin_enable" name="walkin_enable" >
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                            <span class="help-block"><small class="text-danger">Walk-In customers will not have their individual accounts created and will not be part of the CRM!</small></span>
                                            
                                        </div> 
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="walkin_enable" class="control-label">Force Entry of Facials and Hair Color on invoicing</label>
                                            <select class="form-control" id="force_extra_record" name="force_extra_record" >
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
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
        <!--End Edit Service Category Modal-->

        <!--start upload image-->
        <div id="addtypeimage" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addtypeimage" aria-hidden="true" style="display: none;">
            <form action="<?php echo base_url('business/logo/update'); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_test_name" id="logo_csrf" value=""/>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="custom-width-modalLabel">Edit Business Logo</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div id="msg">
                                                    <img id="img" width="100px;" src="" />
                                                </div>
                                                <label for="business_logo" class="control-label">Business Logo</label>
                                                <input class="form-control" type="file" id="business_logo" name="business_logo" />
                                                <input type="hidden" name="org_image" id="org_image" />
                                                <input type="hidden" name="business_id_logo" id="business_id_logo" />
                                            </div> 
                                        </div> 
                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" onclick="$('#logo_csrf').val($('#cook').val());" class="btn btn-custom waves-effect waves-light">Save</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </form>
        </div>
        <!--end upload image-->
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

                $('#datatable-buttons1').DataTable({
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

            function openupdate(business_id) {
                $.ajax({
                    type: 'POST',
                    url: 'business_controller/edit_businessby_id',
                    data: {business_id: business_id},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        $("#business_name").val(data.business_name);
                        $("#business_owner").val(data.business_owner);
                        $("#business_contact").val(data.business_owner_contact);
                        $("#business_phone1").val(data.business_phone1);
                        $("#business_phone2").val(data.business_phone2);
                        $("#business_phone3").val(data.business_phone3);
                        $("#business_phone4").val(data.business_phone4);
                        $("#business_area").val(data.business_area);
                        $("#business_address").val(data.business_address);
                        $("#business_opening_time").val(data.business_opening_time);
                        $("#business_closing_time").val(data.business_closing_time);
                       
                        $("#tax_optional").val(data.tax_optional);
                        $("#show_professional").val(data.show_professional);
                        $("#staff_stats").val(data.staff_stats);
                        $("#payment_terms").val(data.payment_terms);
                        $('#rec_allow_prev').val(data.rec_allow_prev);
                        $('#scheduler_input_search').val(data.scheduler_input_search);
                        $('#show_cash_register').val(data.show_cash_reg);
                        
                        $('#scheduler_style').val(data.scheduler_style);
                        $('#cc_charge').val(data.cc_charge);
                        $('#walkin_enable').val(data.walkin_enable);
                        $("#force_extra_record").val(data.force_extra_record);
                        
                        $("#allow_stock_update").val(data.allow_stock_update);
                        $("#allow_price_update").val(data.allow_price_update);
                        
                        $("#edittype").modal('show');
                    }
                });

                $("#edittype").modal('show');
            }
            function update() {
                if ($("#business_name").val() !== "") {
                    $.ajax({
                        type: 'POST',
                        url: 'business_controller/business_update',
                        data: {
                            business_name: $("#business_name").val(),
                            business_owner: $("#business_owner").val(),
                            business_contact: $("#business_contact").val(),
                            business_phone1: $("#business_phone1").val(),
                            business_phone2: $("#business_phone2").val(),
                            business_phone3: $("#business_phone3").val(),
                            business_phone4: $("#business_phone4").val(),
                            business_opening_time: $("#business_opening_time").val(),
                            business_closing_time: $("#business_closing_time").val(),
                            
                            tax_optional: $("#tax_optional").val(),
                            staff_stats: $("#staff_stats").val(),
                            business_area: $("#business_area").val(),
                            business_address: $("#business_address").val(),
                            payment_terms: $("#payment_terms").val(),
                            rec_allow_prev: $('#rec_allow_prev').val(),
                            
                            show_professional:$('#show_professional option:selected').val(),
                            scheduler_input_search:$('#scheduler_input_search option:selected').val(),
                            show_cash_reg: $('#show_cash_register option:selected').val(),
                            scheduler_style: $('#scheduler_style option:selected').val(),
                            cc_charge: parseFloat($('#cc_charge').val()),
                            walkin_enable: $('#walkin_enable option:selected').val(),
                            force_extra_record: $('#force_extra_record option:selected').val(),
                            allow_stock_update: $('#allow_stock_update option:selected').val(),
                            allow_price_update: $('#allow_price_update option:selected').val()
                        },
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Business Updated');
                                location.reload();
                            }
                        }
                    });
                }
            }

            function upload_image(business_id, image) {
                image = image || null;
                if (business_id && business_id != null) {
                    $("#org_image").val('');
                    $("#business_id_logo").val('');
                    $("#business_id_logo").val(business_id);
                    if (image && image != null) {
                        $("#org_image").val(image);
                        $("#msg #img").attr('src', 'assets/images/business/' + image);
                    } else {
                        $("#msg #img").attr('src', 'assets/images/category/nu.jpg');
                    }
                    $("#addtypeimage").modal("show");
                }
            }

        </script>