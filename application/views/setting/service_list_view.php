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

                <h4 class="page-title" >All Services </h4>

            </div>


        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">

                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID Service</th>
                                <th>Category</th>
                                <th>Service Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Commission %</th>
                                <th>Duration</th>
<!--                                <th>Color</th>-->
                                <th>Active</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (isset($services)) {
                                foreach ($services as $service) {
                                    ?>
                                    <tr>
                                        <td ><?php echo $service['id_business_services']; ?></td>
                                        <td><?php echo $service['service_category']; ?></td>
                                        <td><?php echo $service['service_name']; ?></td>
                                        <td><?php echo $service['service_desc']; ?></td>
                                        <td><?php echo $service['service_rate']; ?></td>
                                        <td><?php echo $service['commission_perc']; ?></td>
                                        <td><?php echo $service['service_duration']; ?></td>
<!--                                        <td><span <?php if ($service['service_color']) { ?> onclick="color_open('<?php echo $service['service_color']; ?>')" <?php } ?> title="<?php echo $service['service_color']; ?>" style="background:<?php echo $service['service_color']; ?>" class="<?php echo $service['service_color'] ? "btn" : ""; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>-->
                                        <td><span class="label <?php
                                            if ($service['service_active'] === "Yes") {
                                                echo 'label-pink';
                                            } else {
                                                echo 'label-inverse';
                                            }
                                            ?>"><?php echo $service['service_active']; ?></span></td>
                                        <td class='noprint'> <button id='btnedit' onclick="openupdate(<?php echo $service['id_business_services']; ?>, <?php echo $service['service_category_id']; ?>);" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button>  </td>
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
        <!--Edit Service  Modal-->
        <div id="editservice" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editservice" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Service </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditserviceid" class="control-label">ID</label>
                                            <input readonly="readonly" type="text" class="form-control" placeholder="Service ID" id="txteditserviceid" name="txteditserviceid">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcategory" class="control-label">Category</label>
                                            <select id="txteditcategory" name="txteditcategory" class="form-control" >
                                                <?php 
                                                if(isset($category)){ 
                                                    foreach ($category as $c){
                                                    ?>
                                                <option value="<?php echo $c['id_service_category']; ?>"><?php echo $c['service_type'].' | '.$c['service_category']; ?></option>
                                                <?php
                                                } 
                                                
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditservice" class="control-label">Service Name</label>
                                            <input type="text" class="form-control" placeholder="Service Name" id="txteditservice" name="txteditservice">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditservicedesc" class="control-label">Description</label>
                                            <input type="text" class="form-control" placeholder="Service Desc" id="txteditservicedesc" name="txteditservicedesc">
                                        </div> 
                                    </div> 
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditserviceactive" class="control-label">Active</label>
                                            <select class="form-control" id="txteditserviceactive" name="txteditserviceactive">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>

                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditserviceprice" class="control-label">Price</label>
                                            <input type="text" <?php if(isset($business[0]['allow_price_update']) && $business[0]['allow_price_update']==='No' && $this->session->userdata('role')=="Store Manager"){?> readonly="readonly" <?php } ?> class="form-control" placeholder="Price" id="txteditserviceprice" name="txteditserviceprice">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditstaffcommission" class="control-label">Staff Commission %</label>
                                            <input type="text" class="form-control" placeholder="Staff Commission" id="txteditstaffcommission" name="txteditstaffcommission">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditstaffcolor" class="control-label">Color</label>
                                            <input id="txteditstaffcolor" type="text" class="colorpicker-default form-control" value="#8fff00">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="txteditserviceduration" class="control-label">Service Duration</label>
                                        <div class="input-group" >
                                            <div class="bootstrap-timepicker" >
                                                <input id="txteditserviceduration" name="txteditserviceduration" type="text" class="form-control" style="position:relative; z-index: 99999999 !important;">
                                            </div>
                                            <span class="input-group-addon bg-pink b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Edit Product in table style start-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="list list-group">
                                    <div class=" list-group-item">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtbrands" class="control-label">Brands</label>
                                                            <select id="txtbrands" name="txtbrands" class="form-control" onchange="getproducts();" >
                                                                <option value="0">Select</option>
                                                                <?php foreach($productsbrand as $brand){ ?>
                                                                <option value="<?php echo $brand['id_business_brands']; ?>"><?php echo $brand['business_brand_name']; ?></option>
                                                                <?php } ?>
                                                            </select>    
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="txtproducts3" class="control-label">Products</label>
                                                            <select id="txtproducts3" name="txtproducts3" class="form-control" >
                                                                
                                                            </select>
                                                        </div> 
                                                    </div> 
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="editproductstatus" class="control-label">Status</label>
                                                            <select id="editproductstatus" name="editproductstatus" class="form-control" >
                                                                <option value="Y">Yes</option>
                                                                <option value="N">No</option>
                                                            </select>
                                                        </div> 
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="editusage_qty" class="control-label">Usage Qty</label>
                                                            <input class="form-control numeric" type="text" name="editusage_qty" id="editusage_qty" placeholder="Quantity Use" />
                                                        </div> 
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button onclick="editOrderRows();" type="button" class="btn btn-custom waves-effect waves-light pull-right">Add Product <span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                                                        </div> 
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row ' style="min-height: 150px;">
                                            <div id='edit-order-product-list' class='col-md-12'>
                                                <div class="table-responsive">
                                                    <table class="table" id="edit-ordertbl">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Product</th>
                                                                <th>Measure Unit</th>
                                                                <th>Qty Use</th>
                                                                <th>Status</th>
                                                                <th>Remove</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Edit Product in table style end-->
                    </div>
                    <div class="modal-footer">
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

                $('.colorpicker-default').colorpicker({
                    format: 'hex'
                });

                $("#txteditserviceduration").datetimepicker({
                    format: 'HH:mm:00',
                    enabledHours: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    allowInputToggle: true,
                    stepping: 15
                });
                
                //Two Select box for products update moving....Start
                $('#txtproducts1').on('change', function() {
                    var val1 = $("#txtproducts1 option:selected").val();
                    var txt1 = $("#txtproducts1 option:selected").text();
                    
                    
                    $('#txtproducts2 option').each(function() {
                        if($(this).attr('value') == val1){
                            alert("already exist!");die;
                        }
                    });
                    
                    $('#txtproducts2').append('<option selected value="'+val1+'">'+txt1+'</opiton>');
     
                });
                $('#txtproducts2').on('click', function() {
                    $("#txtproducts2 option:selected").remove();
                    $('#txtproducts2').find('option').prop('selected',true);
                });
                //Two Select box for products update moving....End
                
                $("#txtproducts3").select2({
                    //maximumSelectionLength: 2
                    //formatNoMatches: Not_Found
                });

            });
            
            function getproducts(){
                $("#txtproducts3").val();
                $("#txtproducts3").text();
                $("#txtproducts3").children().remove();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>product_controller/get_all_products',
                    data: {brand_id: $("#txtbrands :selected").val()},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        for (x = 0; x < data.length; x++) {
                            $("#txtproducts3").append("<option p-measure-qty='"+data[x]['measure_unit']+"' product_show='"+data[x]["product"]+"' title='"+ data[x]["product"]+"' value='"+data[x]["id_business_products"]+"'>"+ data[x]["product"] + " " +data[x]["category"]+ " (" + data[x]["measure_unit"] + ")</option>");  
                        }
                        
                    }
                });
                
            }
            
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

            function openupdate(id_business_services, service_category_id) {

                $("#txteditcategory").val(service_category_id);
                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>service_controller/edit_services',
                    data: {id_business_services: id_business_services},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        var service = data['services'];
                        var serviceproduct = data['services_products'];
                        
                        $("#txteditserviceid").val(service.id_business_services);
                        $("#txteditservice").val(service.service_name);
                        $("#txteditservicedesc").val(service.service_desc);
                        $("#txteditserviceprice").val(service.service_rate);
                        $("#txteditserviceactive").val(service.service_active);
                        $("#txteditstaffcommission").val(service.commission_perc);
                        $("#txteditstaffcolor").val(service.service_color);
                        $("#txteditserviceduration").val(service.service_duration);
                        
                        
                        var mhtml = "";
                        for(var i = 0; i < serviceproduct.length; i++){
                            mhtml += '<tr>';
                            mhtml += '<td class="id">' + serviceproduct[i]['id_business_products'] + '</td>';
                            mhtml += '<td>' + serviceproduct[i]['product'] + '</td>';
                            mhtml += '<td>' + (serviceproduct[i]['measure_unit']? serviceproduct[i]['measure_unit'] : $("#txtproducts3 option:selected").attr('p-measure-qty')) + '</td>';
                            mhtml += '<td>' + serviceproduct[i]['usage_qty'] + '</td>';
                            mhtml += '<td style="display:none;">' + serviceproduct[i]['status'] + '</td>';
                            mhtml += '<td>' + (serviceproduct[i]['status'] === "Y" ? "Yes" : "No") + '</td>';
                            mhtml += '<td><span class="label label-danger" onclick="removeproductedit(' + (serviceproduct[i]['id_business_products'] ? serviceproduct[i]['id_business_products']  :$("#txtproducts3 option:selected").val()) + ')" style="cursor:pointer">x</span></td>';
                            mhtml += "</tr>";
                        }
                        $("#edit-order-product-list tbody").html('');
                        $("#edit-order-product-list tbody").append(mhtml);
                        $("#editservice").modal('show');
                    }
                });
                
                
            }
            function update() {
                if ($("#txteditservice").val() !== "") {
                    var TableData;
                    TableData = edit_retail_storeOTblValues();
                    TableData = $.toJSON(TableData);
                    $.ajax({
                        type: 'POST',
                        url: 'service_controller/update_service',
                        data: {id_business_services: $("#txteditserviceid").val(), service_name: $("#txteditservice").val(), service_desc: $("#txteditservicedesc").val(), service_rate: $("#txteditserviceprice").val(), service_active: $("#txteditserviceactive :selected").val(), commission_perc: $("#txteditstaffcommission").val(), service_color: $("#txteditstaffcolor").val(), service_duration: $("#txteditserviceduration").val(), products: TableData, service_category_id: $("#txteditcategory").val()},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Service Updated');
                                location.reload();
                            }
                        }
                    });
                }
            }

            function color_open(color) {
                $("#idcolor").css("background", color);
                $("#color_modal").modal('show');
            }
            
            //Editing product/status/usage qty functions start.....
            function editOrderRows() {

                if ($("#editproductstatus").val() === "" || $("#txtproducts3").val() === "" || $("#editusage_qty").val() === "") {
                    swal({
                        title: "Product/Status & Qty Should not be empty!",
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                    return false;
                }

                var mhtml = "";
                var exists;
                var count = 1;

                //if ($("#product option:selected").val() > 0) {

                $('#edit-order-product-list').find("td.id").each(function(index) {
                    if ($(this).html() === $("#txtproducts3 option:selected").val()) {
                        exists = 1;
                    }
                });

                mhtml += '<tr>';
                mhtml += '<td class="id">' + $("#txtproducts3 option:selected").val() + '</td>';
                mhtml += '<td>' + $("#txtproducts3 option:selected").attr('product_show') + '</td>';
                mhtml += '<td>' + $("#txtproducts3 option:selected").attr('p-measure-qty') + '</td>';
                mhtml += '<td>' + $("#editusage_qty").val() + '</td>';
                mhtml += '<td style="display:none;">' + $("#editproductstatus option:selected").val() + '</td>';
                mhtml += '<td>' + $("#editproductstatus option:selected").text() + '</td>';
                mhtml += '<td><span class="label label-danger" onclick="removeproductedit(' + $("#txtproducts3 option:selected").val() + ')" style="cursor:pointer">x</span></td>';
                mhtml += "</tr>";
                //}
                if (exists !== 1) {
                    $("#edit-order-product-list tbody").append(mhtml);
                } else {
                    swal({
                        title: "Product already added!",
                        text: 'If you want to change this product, please remove and add again.',
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                }
            }

            function removeproductedit(val) {
                $('#edit-order-product-list').find("td.id").each(function(index) {
                    if ($(this).html() == val) {
                        $(this).closest('tr').remove();
                    }
                });
            }
            
            function edit_retail_storeOTblValues() {
                var TableData = new Array();
                $('#edit-ordertbl tr').each(function(row, tr) {
                    TableData[row] = {
                         "productid": $(tr).find('td:eq(0)').text()
                        , "usageqty": $(tr).find('td:eq(3)').text()
                        , "status": $(tr).find('td:eq(4)').text()

                    }
                });
                TableData.shift();  // first row will be empty - so remove
                return TableData;
            }
            //Editing product/status/usage/qty functions end.....
        </script>