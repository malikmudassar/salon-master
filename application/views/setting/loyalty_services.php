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
                <h4 class="page-title">Customer Loyalty Scheme Setting</h4>
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
                                <th>Service ID</th>
                                <th>Loyalty Service</th>
                                <th>Required Points</th>
                                <th>Duration</th>
                                <th>Active</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (isset($loyalty_services)) {
                                foreach ($loyalty_services as $loyalty_service) {
                                    ?>
                                    <tr>
                                        <td class="hidden"><?php echo $loyalty_service['id_loyalty_services']; ?></td>
                                        <td><?php echo $loyalty_service['service_id']; ?></td>
                                        <td><?php echo $loyalty_service['service_name']; ?></td>
                                        <td><?php echo $loyalty_service['required_points']; ?></td>
                                        <td><?php echo $loyalty_service['duration']; ?></td>
                                        <td><?php echo $loyalty_service['active']; ?></td>
                                        <td class='noprint'> <button id='btnedit' onclick="openupdate('<?php echo $loyalty_service['id_loyalty_services']; ?>');" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button>  </td>
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
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new Loyalty (Free) Service </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="service_id" class="control-label">Service Name</label>
                                            <input type="text" class="form-control" placeholder="Service Name" id="service_id" name="service_id">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="required_points" class="control-label">Required Points</label>
                                            <input type="text" class="form-control" placeholder="Required Points" id="required_points" name="required_points">
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
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="active" class="control-label">Active</label>
                                            <select class="form-control"  id="active" name="active">
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
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Loyalty Service Setting</h4>
                    </div>
                    <div class="modal-body">
                       <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="editservicename" class="control-label">Service Name</label>
                                            <input type="text" class="form-control" readonly="readonly" placeholder="Service Name" id="editservicename" name="editservicename">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="editrequiredpoints" class="control-label">Required Points</label>
                                            <input type="text" class="form-control" placeholder="Required Points" id="editrequiredpoints" name="editrequiredpoints">
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
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="editactive" class="control-label">Active</label>
                                            <select class="form-control"  id="editactive" name="editactive">
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
                        <input type="hidden" name="loyaltyserviceid" id="loyaltyserviceid" />
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
                $("#service_id").select2({
                    ajax: {
                      url: '<?php echo base_url();?>service_controller/search_loyaltyservices',
                      dataType: 'json',
                      delay: 250,
                      data: function (term, page) {

                        return {
                            servicename: term, // search term
                            page_limit: 30, // page size
                            page: page // page number
                        };
                      },
                      results: function (data, page) {

                            var more = (page * 30) < data.length;
                            return {results: data, more: more};
                        }
                      },
                    escapeMarkup: function (m) { return m; }, // let our custom formatter work
                    minimumInputLength: 3,
                    formatResult: function (option) {
                       return option.service_type + ' | ' + option.service_category + ' | ' + option.service_name +  ' | ' + option.service_desc +  ' | ' + option.service_rate;
                    },
                    formatSelection: function (option) {
                        return option.service_type + ' | ' + option.service_category + ' | ' + option.service_name +  ' | ' + option.service_desc +  ' | ' + option.service_rate;
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

                $("#duration").datetimepicker({
                    format: 'HH:mm:00',
                    enabledHours: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    allowInputToggle: true,
                    stepping: 15
                });

                $("#editduration").datetimepicker({
                    format: 'HH:mm:00',
                    enabledHours: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    allowInputToggle: true,
                    stepping: 15
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
                var data = $("#service_id").select2('data');
                
                if (data.id_business_services !== ""  && $("#required_points").val() !== "" && $("#duration").val() !== "00:00:00") {
                    
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>loyaltyservices_controller/add_loyaltyservice',
                        data: {service_id: data.id_business_services, required_points: $('#required_points').val(), duration: $('#duration').val(), active:$("#active :selected").val()},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'New Service Added to Loyalty List');
                                location.reload();
                            }
                        }
                    });
                }else{
                    swal("Warning!", "Please give service name & duration", "warning");
                }
            }


            function openupdate(id_loyalty_services) {
            
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>loyaltyservices_controller/get_edit_loyaltyservice',
                    data: {id_loyalty_services: id_loyalty_services},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        $("#loyaltyserviceid").val(id_loyalty_services);
                        $("#editservicename").val(data.service_name);
                        $("#editrequiredpoints").val(data.required_points);
                        $("#editduration").val(data.duration);
                        $("#editactive").val(data.active);

                        $("#editservice").modal('show');
                        
                    }
                });
            }
            function update() {
                if ($("#editservicename").val() !== "" && $("#editduration").val() !== "" && $("#editrequiredpoints").val() !== "") {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>loyaltyservices_controller/edit_loyaltyservice',
                        data: {id_loyalty_services: $('#loyaltyserviceid').val(), service_id: $('#editservicename :selected').val(),required_points: $('#editrequiredpoints').val(),duration: $('#editduration').val(), active:$("#editactive :selected").val()},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Loyalty Service Updated');
                                location.reload();
                            }
                        }
                    });
                }else{
                    swal("Warning!", "Please give Loyalty name & duration", "warning");
                }
            }

        </script>