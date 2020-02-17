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
                    <button type="button" onclick="openaddnew();" class="btn btn-custom waves-effect waves-light" >Add <span class="m-l-5"><i class="fa fa-plus"></i></span></button>

                </div>
                <h4 class="page-title" >Package Service in <?php echo isset($packages_service[0]['service_category']) ? $packages_service[0]['service_category'] : ""; ?></h4>
            </div>


        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">

                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th >ID</th>
                               
                                <th>Service</th>
                                <th>Rate</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (isset($packages_service[0]['id_package_services'])) {
                                foreach ($packages_service as $service) {
                                    ?>
                                    <tr>
                                        <td><?php echo $service['id_package_services']; ?></td>
                                        
                                        <td><?php echo $service['service_name'].' '.$service['service_desc']; ?></td>
                                        <td><?php echo $service['package_service_rate']; ?></td>
                                        <td class='noprint ' > 
                                            <button id='btnedit1' onclick="edit_service(<?php echo $service['id_package_services']; ?>);" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button> 
                                            <button id='btnedit' onclick="removepackage_service(<?php echo $service['id_package_services']; ?>);" class="btn btn-icon waves-effect waves-light btn-danger m-b-5"> <i class="fa fa-trash-o"></i> </button> 
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

        <!--Add Service Category Modal-->
        <div id="addpackagecatmodal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addpackagecatmodal" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a Services in <?php echo isset($packages_service[0]['service_category']) ? $packages_service[0]['service_category'] : ""; ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="background-color:#f6f6f6">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="txtintendedpercoff" class="control-label text-danger">Intended Percentage Off:</label>
                                    <input id="txtintendedpercoff" class="form-control text-danger decimal" onkeyup="$('#txtintendedpriceoff').val('0'); $('#totaldealprice').html('');$('#pricedifference').html('');" value="0">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="txtintendedpricecoff" class="control-label text-danger">Intended Total Price:</label>
                                    <input id="txtintendedpriceoff" class="form-control text-danger numeric" onkeyup="$('#txtintendedpercoff').val('0'); calculatetotal();" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="addpackageservices" class="control-label">Services</label>
                                            <select onchange="filldealprice();" name="addpackageservices" id="addpackageservices" class="form-control">
                                                <?php
                                                if (isset($business_service)) {
                                                    foreach ($business_service as $service) {
                                                        ?>
                                                        <option value="<?php echo $service['id_business_services']; ?>" price="<?php echo $service['service_rate'];?>"><?php echo $service['service_type'].' | '. $service['service_category'] . ' | ' . $service['service_name'] . ' (' . $service['service_rate'] . ')'; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="adddealprice" class="control-label">Deal Price</label>
                                            <input type="text" class="form-control numeric" id="adddealprice" name="adddealprice" />
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <button style="float:right" onclick="addOrderRows();" type="button" class="btn btn-sm btn-purple waves-effect ">Add  <i class="ti-arrow-circle-down"></i></button>
                                </div>
                            </div>
                            <div class='row ' style="min-height: 150px;">
                                <div id='package_services_list' class='col-md-12'>
                                    <div class="table-responsive">
                                        <table class="table" id="ordertbl">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Service</th>
                                                    <th>Deal Price</th>
                                                    <th>Remove</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="2" style="text-align:right;">Total Deal Price:</th>
                                                    <th id="totaldealprice"></th>
                                                    <th id="pricedifference" class="text-danger"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="package_cat_id" id="package_cat_id" value="<?php echo $packages_service[0]['id_package_category']; ?>" />
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="addnew();" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Service Category Modal-->

        <!--Edit package service modal start-->
        <div id="editpackagecatmodal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editpackagecatmodal" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Services in <?php echo isset($packages_service[0]['service_category']) ? $packages_service[0]['service_category'] : ""; ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="editpackage_category" class="control-label">Category</label>
                                            <select name="editpackage_category" id="editpackage_category" class="form-control">
                                                <?php
                                                if (isset($package_category)) {
                                                    foreach ($package_category as $category) {
                                                        ?>
                                                        <option value="<?php echo $category['id_package_category']; ?>"><?php echo $category['package_type'] . ' | ' . $category['package_category']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="editdeal_price" class="control-label">Deal Price</label>
                                            <input type="text" class="form-control numeric" id="editdeal_price" name="editdeal_price" />
                                        </div> 
                                    </div> 
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_package_services" id="id_package_services" />
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="update();" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--Edit package service modal end-->



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

                $("#addpackageservices").select2({
                    //maximumSelectionLength: 2
                    //formatNoMatches: Not_Found
                });

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

            });

            function filldealprice(){
                console.log('price='+$("#addpackageservices option:selected").attr('price'));
                var serviceprice=parseFloat($("#addpackageservices option:selected").attr('price'));
                var intendedperc = parseFloat($("#txtintendedpercoff").val());
                
                
                var finalprice=0;
                
                
                if(intendedperc>0){
                    finalprice= (serviceprice*intendedperc)/100;       
                    finalprice=serviceprice-finalprice;
                    $("#adddealprice").val(finalprice);
                } else {
                    $("#adddealprice").val(serviceprice);
                }
                
            }
            
            function orderservicetype(id, orderid) {
                var type = "packagecat";

                if (id && orderid) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>packages_controller/order_function',
                        data: {id: id, orderid: orderid, type: type},
                        success: function(data) {
                            toastr.success(data, 'Display Order has been updated!');
                            //location.reload();
                        }
                    });
                }
            }

            function deletecategory(catid) {

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
                        url: 'service_controller/delete_category',
                        data: {id_service_category: catid},
                        success: function(data) {
                            var result = data.split("|");

                            if (result[0] === "success") {
                                swal("Deleted!", "Service Category and all its Services have been removed.", "success");
                                location.reload();
                            } else {
                                swal("Error!", "Service Category was not removed!.", "error");
                            }
                        }
                    });
                });
            }

            function openaddnew() {
                //alert('ok');
                $("#txtintendedpercoff").val('0');
                $("#txtintendedpriceoff").val('0');
                $("#totaldealprice").html('');       
                $("#pricedifference").html('');       
                           
                $("#addpackagecatmodal").modal('show');
            }
            function addnew() {
                if ($("#addpackagecat").val() !== "") {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>packages_controller/add_package_category',
                        data: {
                            service_category: $("#addpackagecat").val(),
                            service_category_active: $("#addpackagestatus :selected").val(),
                            package_type_id: '<?php //echo $packages_category[0]['id_package_type'];        ?>'
                        },
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'New Package Category Added');
                                location.reload();
                            }
                        }
                    });
                }
            }


            function removepackage_service(id) {
                swal({
                    title: "Are you sure?",
                    text: "This action will remove services in this category!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn-warning',
                    confirmButtonText: "Yes, remove it!",
                    closeOnConfirm: true
                }, function() {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>packages_controller/delete_package_service',
                        data: {id_package_services: id},
                        success: function(data) {
                            var result = data.split("|");

                            if (result[0] === "success") {
                                swal("Deleted!", "Service have been removed.", "success");
                                location.reload();
                            } else {
                                swal("Error!", "Service was not removed!.", "error");
                            }
                        }
                    });
                });
            }
            function update() {
                if ($("#editpackage_category").val() !== "" && $("#editdeal_price").val() !== "") {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>packages_controller/update_package_services',
                        data: {
                            id_package_services: $("#id_package_services").val(),
                            package_category_id: $("#editpackage_category :selected").val(),
                            service_rate: $("#editdeal_price").val()
                        },
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Package Service Updated');
                                location.reload();
                            }
                        }
                    });
                }
            }

            function edit_service(id_package_services) {
                
                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>packages_controller/edit_package_service',
                    data: {id_package_services: id_package_services},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        $('#id_package_services').val(id_package_services);
                        $('#editpackage_category').val(data.package_category_id);
                        $('#editdeal_price').val(data.service_rate);

                        $("#editpackagecatmodal").modal('show');
                        
                    }
                });
            }

            function addOrderRows() {

                if ($("#addpackageservices").val() === "" || $("#adddealprice").val() === "") {
                    swal({
                        title: "Service & Price Should not be empty!",
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                    return false;
                }

                var mhtml = "";
                var exists;
                var count = 1;

                //if ($("#product option:selected").val() > 0) {

                $('#package_services_list').find("td.id").each(function(index) {
                    if ($(this).html() === $("#addpackageservices option:selected").val()) {
                        exists = 1;
                    }
                });

                mhtml += '<tr>';
                mhtml += '<td class="id">' + $("#addpackageservices").val() + '</td>';
                mhtml += "<td >" + $("#addpackageservices option:selected").text() + "</td>";
                mhtml += "<td class='dealprice'>" + $("#adddealprice").val() + "</td>";
                mhtml += '<td><span class="label label-danger" onclick="removeproduct(' + $("#addpackageservices option:selected").val() + ')" style="cursor:pointer">x</span></td>';
                mhtml += "</tr>";
                $("#adddealprice").val('');
                if (exists !== 1) {
                    $("#package_services_list tbody").append(mhtml);
                    
                    calculatetotal();
                    
                } else {
                    swal({
                        title: "Service already added!",
                        text: 'If you want to change this Service, please remove and add again.',
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                }
            }

            function calculatetotal(){
                var totalprice = 0;
                 $('#package_services_list').find("td.dealprice").each(function(index) {
                    totalprice = totalprice+parseFloat($(this).html());
                });
                
                $("#totaldealprice").html(totalprice);
                
                var intendedprice = parseFloat($("#txtintendedpriceoff").val());
                var pricedifference=0;
                if(intendedprice>0){
                    pricedifference= intendedprice-totalprice;  
                    if(pricedifference>=0){
                        $("#pricedifference").removeClass('text-danger');
                        $("#pricedifference").addClass('text-success');
                        $("#pricedifference").html("Add " + pricedifference);
                    }else {
                         $("#pricedifference").removeClass('text-success');
                        $("#pricedifference").addClass('text-danger');
                        $("#pricedifference").html(pricedifference);
                    }
                }
                
            }

            function removeproduct(val) {
                $('#package_services_list').find("td.id").each(function(index) {
                    if ($(this).html() == val) {
                        $(this).closest('tr').remove();
                    }
                });
                calculatetotal();
            }

            function retail_storeOTblValues() {
                var TableData = new Array();
                $('#ordertbl tr').each(function(row, tr) {
                    TableData[row] = {
                        "service_id": $(tr).find('td:eq(0)').text()
                        , "service_rate": $(tr).find('td:eq(2)').text()

                    }
                });
                TableData.shift();  // first row will be empty - so remove
                return TableData;
            }

            function retail_updateorder() {
                //if ($("#order-id").val() === "") { //add new visit
                var TableData;
                TableData = retail_storeOTblValues();
                TableData = $.toJSON(TableData);
                if (TableData.length > 2) {
                    $('.orderloader span').text('');
                    $('.orderloader span').addClass('fa fa-spin fa-spinner');
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>packages_controller/add_package_service",
                        //data: "orderdata=" + TableData,
                        data: {orderdata: TableData, package_category_id: $('#package_cat_id').val()},
                        success: function(data) {

                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success('Deal created!', 'Done!');
                                location.reload();
                            } else {
                                swal({
                                    title: "Error",
                                    //text: result[1],
                                    type: "error",
                                    confirmButtonText: 'OK!'
                                });
                            }
                        }
                    });
                } else {
                    swal({
                        title: "You have not added any Service",
                        //text: 'Select Product and staff member providing that made the sale.',
                        type: "warning",
                        confirmButtonText: 'OK!'
                    });
                }
            }

            function addnew() {
                retail_updateorder();
            }

        </script>