<style>
    /* enable absolute positioning */
    .inner-addon { 
        position: relative; 
    }

    /* style icon */
    .inner-addon .glyphicon {
        position: absolute;
        padding: 10px;
        pointer-events: none;
    }

    /* align icon */
    .left-addon .glyphicon  { left:  0px;}
    .right-addon .glyphicon { right: 0px;}

    /* add padding  */
    .left-addon input  { padding-left:  30px; }
    .right-addon input { padding-right: 30px; }

    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('<?php echo base_url(); ?>assets/images/page-loader-1.gif') 50% 50% no-repeat ;
        display: none;
    }
</style>
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    <button type="button"  onclick="openaddnew();" class="btn btn-custom waves-effect waves-light" >Create Order <span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                </div>
                <h4 class="page-title">Purchase Orders:</h4>
            </div>
        </div>

        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <!--<h4 class="header-title m-t-0 m-b-30">Selection:</h4>-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">&nbsp;</div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">Select Dates</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <div id="reportrange" class="inner-addon left-addon">
                                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                <input style="background-color: white;" readonly class="form-control" type="text" name="range" id="range" />
                                                <input type="hidden" name="rangehidden" id="rangehidden" value="1" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">&nbsp;</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" > 
                                            <button type="button" onclick="runreport();" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><i id="cog" class="fa fa-spin fa-cog" style="display:none; font-size:26px;width: auto;margin-right: 10px;"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>
                    <table id="tblreport" class="table table-striped table-bordered dt-responsive nowrap record" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Ready</th>
                            </tr>
                        </thead>
                        <tbody>
                        <td>Run Orders</td>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

        <!--Add Product Modal-->
        <div id="addpurchaseorder" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addpurchaseorder" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new Purchase Order</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="businessid" class="control-label">Branch</label>
                                            <select id="businessid" name="businessid" class="form-control" >
                                                <?php foreach($businesses as $b){ ?>
                                                <?php if($b['id_business']!==$this->session->userdata('businessid')){?>
                                                    <?php if(isset($business[0]['multibranchpo'])){if($business[0]['multibranchpo']=='Yes'){?>
                                                        <option value="<?php echo $b['id_business']?>"><?php echo $b['business_name']?></option>
                                                    <?php }} ?>
                                                <?php } else { ?>        
                                                        <option selected='selected' value="<?php echo $b['id_business']?>"><?php echo $b['business_name']?></option>
                                                <?php }} ?>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>

                            </div>
                            
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="supplier" class="control-label">Supplier</label>
                                            <select id="supplier" name="supplier" class="form-control" >
                                                <?php
                                                if (isset($suppliers)) {?>
                                                    <option value=""></option>
                                                    <?php foreach ($suppliers as $supplier) {
                                                        ?>
                                                        <option value="<?php echo $supplier['id_business_supplier']; ?>"><?php echo $supplier['supplier_name'].' - '.$supplier['contact_person']; ?></option>
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
                                            <label for="brand" class="control-label">Brand</label>
                                            <select id="brand" name="brand" class="form-control" >
                                                <option value=""></option>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>

                            </div>
                        </div>
                        <div id="loader" class="loader"></div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product" class="control-label">Products</label>
                                            <select id="product" name="product" class="form-control" onchange="">
                                                <option value=""></option>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="orderdate" class="control-label">Date</label>
                                            <input type="text" class="form-control" placeholder="Date" id="orderdate" name="orderdate">
                                        </div> 
                                    </div> 
                                </div>

                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <button style="float:right" onclick="addOrderRows();" type="button" class="btn btn-sm btn-purple waves-effect ">Add Product <i class="ti-arrow-circle-down"></i></button>
                            </div>
                        </div>
                        <div class='row ' style="min-height: 150px;">
                            <div id='order-product-list' class='col-md-12'>
                                <div class="table-responsive">
                                    <table class="table" id="ordertbl">
                                        <thead>
                                            <tr>
                                                <th style="display:none;">Customer ID</th>
                                                <th>#</th>
                                                <th>Brand</th>
                                                <th>Product</th>
                                                <th class="text-custom">Unit Price</th>
                                                <th class="text-custom">Qty</th>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="addnew();" type="button" class="btn btn-custom waves-effect waves-light orderloader"><span>Save</span></button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Product Modal-->

        <!--Edit Purchase order start-->
        <div id="editpurchaseorder" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editpurchaseorder" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Purchase Order</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="supplieredit" class="control-label">Supplier</label>
                                            <select id="supplieredit" name="supplieredit" class="form-control" ><!--old code onchange="supplier_brand(this.value);"-->
                                                <option value=""></option>
                                                <?php
                                                if (isset($suppliers)) {
                                                    foreach ($suppliers as $supplier) {
                                                        
                                                        ?>
                                                        <option value="<?php echo $supplier['id_business_supplier']; ?>"><?php echo $supplier['supplier_name']; ?></option>
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
                                            <label for="brandedit" class="control-label">Brand Edit</label>
                                            <select id="brandedit" name="brandedit" class="form-control" onchange="brandeditchange();"><!--Old code onchange="brand_product(this.value);"-->
                                                <option value=""></option>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>

                            </div>
                        </div>
                        <div id="loader" class="loader"></div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="productedit" class="control-label">Products</label>
                                            <select id="productedit" name="productedit" class="form-control" onchange="">
                                                <option value=""></option>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="orderdateedit" class="control-label">Date</label>
                                            <input type="text" class="form-control" placeholder="Date" id="orderdateedit" name="orderdateedit">
                                        </div> 
                                    </div> 
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="businessidedit" class="control-label">Branch</label>
                                            <select id="businessedit" name="businessedit" class="form-control" onchange="">
                                                <option value=""></option>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <button style="float:right" onclick="editOrderRows();" type="button" class="btn btn-sm btn-purple waves-effect ">Add Product <i class="ti-arrow-circle-down"></i></button>
                            </div>
                        </div>
                        <div class='row ' style="min-height: 150px;">
                            <div id='edit-order-product-list' class='col-md-12'>
                                <div class="table-responsive">
                                    <table class="table" id="edit-ordertbl">
                                        <thead>
                                            <tr>
                                                <th style="display:none;">Customer ID</th>
                                                <th>#</th>
                                                <th>Brand</th>
                                                <th>Product</th>
                                                <th>Unit Price</th>
                                                <th>Qty</th>
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
                    <div class="modal-footer">
                        <input type="hidden" name="edit_purchaseorder_id" id="edit_purchaseorder_id" />
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="editnew();" type="button" class="btn btn-custom waves-effect waves-light orderloader"><span>Save</span></button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--Edit Purchase order end-->

        <script type="text/javascript">

            var startdate = '';
            var enddate = '';
            $(document).ready(function() {
                $(".numeric").keypress(function (e) {
                    //if the letter is not digit then display error and don't type anything
                    if (e.which != 13 && e.which != 8 && e.which != 0  && e.which != 46 && (e.which < 48 || e.which > 57)) {
                       return false;
                   }
                  });
                //var cl = $('.daterangepicker').find('.ranges li:eq(6)').addClass('active')
                //console.log(cl);
            <?php
            //$month_ini = new DateTime("first day of last month");
            //$month_end = new DateTime("last day of last month");

            $query_date = date('Y-m-d');
            // First day of the month.
            $month_ini = date('Y-m-01', strtotime($query_date));
            // Last day of the month.
            $month_end = date('Y-m-t', strtotime($query_date));
            ?>
                var startmonth = '<?php echo date('F j, Y', strtotime($month_ini)); //->format('F j, Y');    ?>';
                var endmonth = '<?php echo date('F j, Y', strtotime($month_end)); //->format('F j, Y');    ?>';
                $('#reportrange input').val(startmonth + ' - ' + endmonth);
                purchase_order('<?php echo $month_ini; //->format('Y-m-d');    ?>', '<?php echo $month_end; //->format('Y-m-d');    ?>');
                //$('[data-toggle="tooltip"]').tooltip();


                $('#tblreport').DataTable({
                    dom: "Bfrtlip",
                    buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                            extend: "excel",
                            className: "btn-sm"
                        }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
                    responsive: !0
                });

                //$('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

                $('#reportrange').daterangepicker({
                    //format: 'MM/DD/YYYY',
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment(),
                    minDate: '01/01/2012',
                    maxDate: '12/31/2099',
//                    dateLimit: {
//                        days: 60
//                    },
                    showDropdowns: true,
                    showWeekNumbers: true,
                    timePicker: false,
                    timePickerIncrement: 1,
                    timePicker12Hour: true,
                    ranges: {
                        'Today': [moment(), moment().add(1, 'days')],
                        'Yesterday': [moment().subtract(1, 'days'), moment()],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment().add(1, 'days')],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment().add(1, 'days')],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    opens: 'left',
                    drops: 'down',
                    buttonClasses: ['btn', 'btn-sm'],
                    applyClass: 'btn-success',
                    cancelClass: 'btn-default',
                    separator: ' to ',
                    locale: {
                        applyLabel: 'Submit',
                        cancelLabel: 'Cancel',
                        fromLabel: 'From',
                        toLabel: 'To',
                        customRangeLabel: 'Custom',
                        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                        firstDay: 1
                    }
                }, function(start, end, label) {
                    //console.log(start.toISOString(), end.toISOString(), label);
                    startdate = start;
                    enddate = end;
                    //$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    $('#reportrange input').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
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

                $('#orderdate').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy-mm-dd'
                });

                $('#orderdateedit').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy-mm-dd'
                });

//                $("#supplier").select2({
//                   allowClear: true
//                });

                $("#brand").select2({
                    allowClear: true
                });

                $("#product").select2({
                    allowClear: true
                });

                ///////////Edit selects.........
                $("#supplieredit").select2({
                    allowClear: true
                });

                $("#brandedit").select2({
                    allowClear: true
                });

                $("#productedit").select2({
                    allowClear: true
                });


                $(document.body).on("change", "#businessid", function() {
                    var businessid = $(this).val();
                    if (businessid && businessid !== "") {
                        $(".loader").fadeIn("slow");
                       //$('#supplier').val(null).trigger('change');
                        $("#supplier option").each(function() { //added a each loop here
                            $(this).remove();
                        });
                       // $("#brand").select2('val', 'All');
                        $("#brand option").each(function() { //added a each loop here
                            $(this).remove();
                        });
                       // $("#product").select2('val', 'All');
                        $("#product option").each(function() { //added a each loop here
                            $(this).remove();
                        });
                        $.ajax({
                            type: 'POST',
                            //url: '<?php //echo base_url("purchaseorder_controller/supplier_brand");    ?>/' + supplierid,
                            url: '<?php echo base_url("purchaseorder_controller/business_suppliers"); ?>',
                            data: {businessid: businessid},
                            dataType: "json",
                            cache: false,
                            async: true,
                            success: function(data) {
                                //$('#supplier').html('');
                                //$('#brandedit').html('');
                                var supplier = "";
                                var supplier_edit = "";
                                if (data.length > 0) {
                                    $("#supplier").append('<option val=""></option>');
                                    for (var i = 0; i < data.length; i++) {
                                        $("#supplier").append('<option value = "' + data[i]['id_business_supplier'] + '">' + data[i]['supplier_name'] + '</option>');
                                        
                                    }

                                } else {
                                    $('#supplier').append('<option value = ""></option>');
                                   
                                }
                            }
                        });
                        
                        $(".loader").fadeOut("slow");
                    }
                });

                //Add code for supplier brand...............
                $(document.body).on("change", "#supplier", function() {
                    //console.log($("#supplier option:selected").val());
                   // console.log($(this).val());
                    var supplierid = $(this).val();
                    if (supplierid && supplierid !== "") {
                        $(".loader").fadeIn("slow");
                        $("#brand").select2('val', 'All');
                        $("#brand option").each(function() { //added a each loop here
                            //$(this).select2('val', '');
                            $(this).remove();
                        });
                        $("#product").select2('val', 'All');
                        $("#product option").each(function() { //added a each loop here
                            //$(this).select2('val', '');
                            $(this).remove();
                        });
                        $.ajax({
                            type: 'POST',
                            //url: '<?php //echo base_url("purchaseorder_controller/supplier_brand");    ?>/' + supplierid,
                            url: '<?php echo base_url("purchaseorder_controller/supplier_brand"); ?>',
                            data: {supplierid: supplierid, businessid: $("#businessid option:selected").val()},
                            dataType: "json",
                            cache: false,
                            async: true,
                            success: function(data) {
                                //$('#brand').html('');
                                //$('#brandedit').html('');
                                var brand = "";
                                var brand_edit = "";
                                if (data.length > 0) {
                                    brand += '<option val=""></option>';
                                    for (var i = 0; i < data.length; i++) {
                                        brand += '<option value = ' + data[i]['id_business_brands'] + '>' + data[i]['business_brand_name'] + '</option>';
                                        //brand_edit += '<option value = ' + data[i]['id_business_brands'] + '>' + data[i]['business_brand_name'] + '</option>';
                                    }
                                    //brand += '<option val="">other</option>';
                                    //brand_edit += '<option val="">other</option>';
                                    $('#brand').html(brand);
                                    //$('#brandedit').html(brand_edit);
                                } else {
                                    $('#brand').append('<option value = ""></option>');
                                    //$('#brandedit').append('<option value = ""></option>');
                                }
                            }
                        });
                        
                        $(".loader").fadeOut("slow");
                    }
                });

                //Edit code for supplier brand...............
                $(document.body).on("change", "#supplieredit", function() {
                    var supplierid = $(this).val();
                    if (supplierid && supplierid !== "") {
                        $(".loader").fadeIn("slow");
                        $("#brandedit").select2('val', 'All');
                        $("#productedit").select2('val', 'All');
                        $("#productedit option").each(function() { //added a each loop here
                            //$(this).select2('val', '');
                            $(this).remove();
                        });
                        $.ajax({
                            type: 'POST',
                            //url: '<?php //echo base_url("purchaseorder_controller/supplier_brand");    ?>/' + supplierid,
                            url: '<?php echo base_url("purchaseorder_controller/supplier_brand"); ?>',
                            data: {supplierid: supplierid, businessid: $("#businessid option:selected").val()},
                            dataType: "json",
                            cache: false,
                            async: true,
                            success: function(data) {
                                //$('#brand').html('');
                                $('#brandedit').html('');
                                //var brand = "";
                                var brand_edit = "";
                                if (data.length > 0) {
                                    for (var i = 0; i < data.length; i++) {
                                        //brand += '<option value = ' + data[i]['id_business_brands'] + '>' + data[i]['business_brand_name'] + '</option>';
                                        brand_edit += '<option value = ' + data[i]['id_business_brands'] + '>' + data[i]['business_brand_name'] + '</option>';
                                    }
                                    //brand += '<option val="">other</option>';
                                   // brand_edit += '<option val="">other</option>';
                                    //$('#brand').html(brand);
                                    $('#brandedit').html(brand_edit);
                                } else {
                                    //$('#brand').append('<option value = ""></option>');
                                    $('#brandedit').append('<option value = ""></option>');
                                }
                            }
                        });
                        $(".loader").fadeOut("slow");
                    }
                });

                //Add code Brand product....
                $(document.body).on("change", "#brand", function() {
                    var brandid = $(this).val();
                    if (brandid && brandid != "") {
                        $(".loader").fadeIn("slow");
                        $("#product").select2('val', 'All');
                        $.ajax({
                            type: 'POST',
                            //url: '<?php //echo base_url("purchaseorder_controller/brand_product");    ?>/' + brandid,
                            url: '<?php echo base_url("purchaseorder_controller/brand_product"); ?>',
                            data: {brandid: brandid, businessid: $("#businessid option:selected").val()},
                            dataType: "json",
                            cache: false,
                            async: true,
                            success: function(data) {
                                $('#product').html('');
                                //$('#productedit').html('');
                                if (data.length > 0) {
                                    for (var i = 0; i < data.length; i++) {
                                        $('#product').append('<option product-price = ' + data[i]['purchase_price'] + ' value = ' + data[i]['id_business_products'] + '>' + data[i]['product'] + ' ' + data[i]['category'] +' ' + data[i]['qty_per_unit'] +' ' + data[i]['measure_unit'] +'</option>');
                                        //$('#productedit').append('<option product-price = ' + data[i]['purchase_price'] + ' value = ' + data[i]['id_business_products'] + '>' + data[i]['product'] + '</option>');
                                    }
                                } else {
                                    $('#product').append('<option value = ""></option>');
                                    //$('#productedit').append('<option value = ""></option>');
                                }
                            }
                        });
                        $(".loader").fadeOut("slow");
                    }
                });

                //Edit code for Brand product......
                

            });
            //TableManageButtons.init();

            function runreport() {
                //var reportname = $('#selectreport').val();
                //console.log(reportname);
                if ($('#rangehidden').val() != 0) {
                    $("#cog").show();
                    setTimeout(function() {
                        $("#cog").hide();
                    }, 500);

                    if (startdate == "" || enddate == "") {
                        return false;
                    } else {
                        $('#rangehidden').val(0);
                    }

                }
                if (startdate == "" || enddate == "") {
                    swal({
                        title: "Select Date Range",
                        text: "Please select a date Range",
                        type: "warning",
                        confirmButtonText: 'OK!'
                    });
                    return false;
                }
                //console.log(startdate);
               // console.log(startdate.format('YYYY-MM-DD') + ' ' + enddate.format('YYYY-MM-DD'));

                //if (reportname === 'purchase_order') {
                purchase_order();
                //}

            }

            function purchase_order(start = null, end = null) {
                var startd = start ? start : startdate.format('YYYY-MM-DD');
                var endd = end ? end : enddate.format('YYYY-MM-DD');
                
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'purchaseorder_controller/purchase_order_list_get',
                    data: {startdate: startd, enddate: endd},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {

                        var hhtml = "<tr><th>ID</th><th>Purchase order number</th><th>For Branch</th><th>Supplier name</th><th>Order date</th><th>Qty</th><th>Total</th><th>Order status</th><th>Created by</th><th>GRN</th><th>Action</th></tr>"

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {

                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['idpurchase_order'] + '</td>';
                            mhtml += '<td><span class="label label-pink">' + data[x]['purchase_order_number'] + '</span></td>';
                            mhtml += '<td>' + data[x]['business_name'] + '</td>';
                            mhtml += '<td>' + data[x]['supplier_name'] + '</td>';
                            mhtml += '<td>' + data[x]['order_date'] + '</td>';
                            mhtml += '<td>' + data[x]['qty'] + '</td>';
                            mhtml += '<td>' + data[x]['total_purchase_pirce'] + '</td>';
                            mhtml += '<td class="text-success">' + data[x]['status'] + '</td>';
                            mhtml += '<td class="text-primary">' + data[x]['created_by'] + '</td>'; 
                            mhtml += '<td><a onclick="set_order(' + data[x]['idpurchase_order'] + ');" class="btn btn-warning btn-sm" href="<?php echo base_url(); ?>grn_list/'+data[x]['idpurchase_order']+'"><span class="fa fa-arrow-right"></span></a>\n\
                                        <input type="hidden" name="ponumber" id="ponumber' + data[x]['idpurchase_order'] + '" value = "' + data[x]['purchase_order_number'] + '" />\n\
                                        <input type="hidden" name="o_status" id="o_status' + data[x]['idpurchase_order'] + '" value = "' + data[x]['status'] + '" />\n\
                                      </td>';
                            
                            mhtml += '<td><a class="btn btn-success btn-sm" target="_blank" href="<?php echo base_url('purchase_order_details'); ?>/' + data[x]['idpurchase_order'] + '"><span class="fa fa fa-print"></span></a>\n\<input type="hidden" name="status" id="status' + data[x]['idpurchase_order'] + '" value = "' + data[x]['status'] + '" />';
                            <?php if($business[0]['multibranchpo']){ ?>
                                //mhtml += '<a href="javascript:void(0);" onclick="purchase_order_edit(' + data[x]['idpurchase_order'] + ');" class="btn btn-icon waves-effect waves-light btn-info m-b-5" ><span class="fa fa-keyboard-o"></span></a>';
                                mhtml += '<a ' + (data[x]['status'] == "Delivered" ? "disabled" : "") + ' onclick="edit_purchase_order(' + data[x]['idpurchase_order'] + ');" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span></a>';
                            <?php } ?>
                            mhtml += '</td>';    
                            //<a ' + (data[x]['status'] == "Delivered" ? "disabled" : "") + ' onclick="edit_purchase_order(' + data[x]['idpurchase_order'] + ');" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span></a>\n\
                            mhtml += '</tr>';
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');

                        $('#tblreport').DataTable({
                            dom: "Bfrtlip",
                            fixedHeader: {header: true},
                            buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                                    extend: "excel",
                                    className: "btn-sm"
                                }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
                            responsive: !0
                        });
                        $("#cog").hide();

                    }
                });
            }

            //This function is using to open purchaseorder_detail for GRN in new page url called good_recieved_note...
            function set_order(porderid) {
                var pordertext = $('#ponumber' + porderid).val();
                var orderstatus = $('#o_status' + porderid).val();
                localStorage.setItem("porderid", porderid);
                localStorage.setItem("pordertext", pordertext);
                localStorage.setItem("orderstatus", orderstatus);
            }


            //function supplier_brand(supplierid) {

            //}

            //function brand_product(brandid) {

            //}

            function openaddnew() {
                $("#addpurchaseorder").modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
            }

            function purchase_order_edit(purchaseorder_id) {
                if (purchaseorder_id) {
                    console.log(purchaseorder_id);
                }
            }

            function addOrderRows() {

                if ($("#supplier").val() === "" || $("#brand").val() === "" || $("#product").val() === "" || $("#orderdate").val() === "") {
                    swal({
                        title: "Supplier/Brand/Product & Date Should not be empty!",
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                    return false;
                }

                var mhtml = "";
                var exists;
                var count = 1;

                //if ($("#product option:selected").val() > 0) {

                $('#order-product-list').find("td.id").each(function(index) {
                    if ($(this).html() === $("#product option:selected").val()) {
                        exists = 1;
                    }
                });

                mhtml += '<tr>';
                mhtml += '<td style="display:none;">' + $("#brand").val() + '</td>';
                mhtml += "<td class='id'>" + $("#product option:selected").val() + "</td>";
                mhtml += "<td>" + $("#brand option:selected").text() + "</td>";
                mhtml += "<td>" + $("#product option:selected").text() + "</td>";
                mhtml += "<td class='text-primary'><abbr title='Edit'><input type='number' style='border:none; width:60px' id = 'product_price' name = 'product_price' value = " + $("#product option:selected").attr('product-price') + " /></abbr></td>";
                mhtml += "<td class='text-primary'><abbr title='Edit'><input type='number' style='border:none; width:50px' value = '1'  id='product_qty' name='product_qty' ></abbr></td>";
                mhtml += "<td style='display:none;'>" + $("#supplier option:selected").val() + "</td>";
                mhtml += "<td style='display:none;'>" + $("#supplier option:selected").text() + "</td>";
                mhtml += "<td style='display:none;'>" + $("#orderdate").val() + "</td>";
                mhtml += '<td style="display:none;">' + $("#businessid option:selected").val() + '</td>';
                mhtml += '<td><span class="label label-danger" onclick="removeproduct(' + $("#product option:selected").val() + ')" style="cursor:pointer">x</span></td>';
                
                mhtml += "</tr>";
                //}
                if (exists !== 1) {
                    $("#order-product-list tbody").append(mhtml);
                } else {
                    swal({
                        title: "Product already added!",
                        text: 'If you want to change this product, please remove and add again.',
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                }
            }

            function removeproduct(val) {
                $('#order-product-list').find("td.id").each(function(index) {
                    if ($(this).html() == val) {
                        $(this).closest('tr').remove();
                    }
                });
            }

            function addnew() {
                retail_updateorder();
                //console.log(retail_storeOTblValues());
            }

            function retail_storeOTblValues() {
                var TableData = new Array();
                $('#ordertbl tr').each(function(row, tr) {
                    TableData[row] = {
                        "brandid": $(tr).find('td:eq(0)').text()
                        , "productid": $(tr).find('td:eq(1)').text()
                        , "brandname": $(tr).find('td:eq(2)').text()
                        , "productname": $(tr).find('td:eq(3)').text()
                        , "productprice": $(tr).find('td:eq(4)').find('#product_price').val()
                        , "productqty": $(tr).find('td:eq(5)').find('#product_qty').val()
                        , "supplierid": $(tr).find('td:eq(6)').text()
                        , "suppliername": $(tr).find('td:eq(7)').text()
                        , "orderdate": $(tr).find('td:eq(8)').text()
                        , "businessid": $(tr).find('td:eq(9)').text()
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
                        url: "purchaseorder_controller/addpurchase_orders",
                        //data: "orderdata=" + TableData,
                        data: {orderdata: TableData},
                        success: function(data) {
                            console.log(data);
                            var result = data.split("|");
                            if (result[0] === "success") {
                                //$("#order-id").val(result[1]);
                                //$('#btngenorderinvoice').show();
                                //retail_clearorder();
                                //retail_openOrder(result[1]);
                                toastr.success('Order created!', 'Done!');
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
                        title: "You have not added any Products",
                        //text: 'Select Product and staff member providing that made the sale.',
                        type: "warning",
                        confirmButtonText: 'OK!'
                    });
                }
//                } else { //update existing order
//                    var TableData;
//                    TableData = retail_storeOTblValues();
//                    TableData = $.toJSON(TableData);
//                    if (TableData.length > 2) {
//                        $.ajax({
//                            type: "POST",
//                            url: "order_controller/updateorder",
//                            data: "&orderdata=" + TableData + "&orderid=" + $("#order-id").val(),
//                            success: function(data) {
//                                var result = data.split("|");
//                                if (result[0] === "success") {
//                                    //retail_clearorder();
//                                    //retail_openOrder(result[1]);
//                                    //$('#btngenorderinvoice').show();
//                                    toastr.success('Order Updated!', 'Done!');
//                                } else {
//                                    swal({
//                                        title: "Error",
//                                        text: result[1],
//                                        type: "error",
//                                        confirmButtonText: 'OK!'
//                                    });
//                                }
//                            }
//                        });
//                    } else {
//                        swal({
//                            title: "You have not added any Products",
//                            text: 'Select Product and staff member providing that made the sale.',
//                            type: "error",
//                            confirmButtonText: 'OK!'
//                        });
//                    }
//                }
            }

            //////////////////Edit Purchase order.....
            function edit_purchase_order(purchaseorder_id) {
                //
                var order_status = $('#status' + purchaseorder_id).val();
                if (purchaseorder_id && order_status !== "Delivered") {
                    $('#edit_purchaseorder_id').val(purchaseorder_id);
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url("purchaseorder_controller/edit_purchaseorder"); ?>',
                        data: {purchaseorder_id: purchaseorder_id},
                        dataType: "json",
                        cache: false,
                        async: true,
                        success: function(data) {
                            var purchaseorder = data['edit_purchaseorder'];
                            var purchaseorder_detail = data['edit_purchaseorder_detail'];
                            $('#supplieredit').select2('data', {id: purchaseorder[0]['supplier_id'], text: purchaseorder[0]['supplier_name']});
                            $('#supplieredit').attr("disabled","disabled");
                            subpplierbrand($('#supplieredit').val());
                            //$('#brandedit').select2('data', {id: purchaseorder_detail[0]['brand_id'], text: purchaseorder_detail[0]['brand_name']});
                            //$('#productedit').select2('data', {id: purchaseorder_detail[0]['product_id'], text: purchaseorder_detail[0]['product_name']});
                            //$('#orderdateedit').val(purchaseorder[0]['order_date']);
                            var mhtml = "";
                            if (purchaseorder_detail.length > 0) {
                                for (var i = 0; i < purchaseorder_detail.length; i++) {
                                    mhtml += '<tr>';
                                    mhtml += '<td style="display:none;">' + purchaseorder_detail[i]['brand_id'] + '</td>';
                                    mhtml += "<td class='id'>" + purchaseorder_detail[i]['product_id'] + "</td>";
                                    mhtml += "<td>" + purchaseorder_detail[i]['brand_name'] + "</td>";
                                    mhtml += "<td>" + purchaseorder_detail[i]['product_name'] + "</td>";
                                    mhtml += "<td class='text-primary'><abbr title='Edit'><input type='number' style='border:none; width:70px'  id = 'product_price_edit' name = 'product_price_edit' value = " + purchaseorder_detail[i]['product_purchase_price'] + " /></abbr></td>";
                                    mhtml += "<td class='text-primary'><abbr title='Edit'><input type='number' style='border:none; width:50px' value='" + purchaseorder_detail[i]['product_qty'] + "' id='product_qty_edit' name='product_qty_edit' ></abbr></td>";
                                    mhtml += "<td style='display:none;'>" + purchaseorder[0]['supplier_id'] + "</td>";
                                    mhtml += "<td style='display:none;'>" + purchaseorder[0]['supplier_name'] + "</td>";
                                    mhtml += "<td style='display:none;'>" + purchaseorder[0]['order_date'] + "</td>";
                                    mhtml += '<td><span class="label label-danger" onclick="removeproduct_edit(' + purchaseorder_detail[i]['product_id'] + ')" style="cursor:pointer">x</span></td>';
                                    mhtml += "</tr>";
                                }
                                $("#edit-order-product-list tbody").html('');
                                $("#edit-order-product-list tbody").append(mhtml);
                            } else {
                            

                            }
                            $("#editpurchaseorder").modal({
                                backdrop: 'static',
                                keyboard: false,
                                show: true
                            });
                        }
                    });
                } else {
                    swal({
                        title: "Purchaseorder Delivered",
                        text:"This purchaseorder delivered you are not able to change/update again!",
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                    return false;
                }
            }
            
            //This function is calling from edit purchase order success function... 
            function subpplierbrand(supplierid){
             
                if (supplierid && supplierid !== "") {
                        $(".loader").fadeIn("slow");
                        $("#brandedit").select2('val', 'All');
                        $("#productedit").select2('val', 'All');
                        $("#productedit option").each(function() { //added a each loop here
                            //$(this).select2('val', '');
                            $(this).remove();
                        });
                        $.ajax({
                            type: 'POST',
                            //url: '<?php //echo base_url("purchaseorder_controller/supplier_brand");    ?>/' + supplierid,
                            url: '<?php echo base_url("purchaseorder_controller/supplier_brand"); ?>',
                            data: {supplierid: supplierid, businessid:$("#businessid option:selected").val()},
                            dataType: "json",
                            cache: false,
                            async: true,
                            success: function(data) {
                               
                                $('#brandedit').html('');
                                
                                var brand_edit = "";
                                if (data.length > 0) {
                                    for (var i = 0; i < data.length; i++) {
                                        //brand += '<option value = ' + data[i]['id_business_brands'] + '>' + data[i]['business_brand_name'] + '</option>';
                                        brand_edit += '<option value = ' + data[i]['id_business_brands'] + '>' + data[i]['business_brand_name'] + '</option>';
                                    }
                                    $('#brandedit').html(brand_edit);
                                } else {
                                    //$('#brand').append('<option value = ""></option>');
                                    $('#brandedit').append('<option value = ""></option>');
                                }
                            }
                        });
                        $(".loader").fadeOut("slow");
                    }
            }

            function editOrderRows() {

                if ($("#supplieredit").val() === "" || $("#brandedit").val() === "" || $("#productedit").val() === "" || $("#orderdateedit").val() === "") {
                    swal({
                        title: "Supplier/Brand/Product & Date Should not be empty!",
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
                    if ($(this).html() === $("#productedit option:selected").val()) {
                        exists = 1;
                    }
                });

                mhtml += '<tr>';
                mhtml += '<td style="display:none;">' + $("#brandedit").val() + '</td>';
                mhtml += "<td class='id'>" + $("#productedit option:selected").val() + "</td>";
                mhtml += "<td>" + $("#brandedit option:selected").text() + "</td>";
                mhtml += "<td>" + $("#productedit option:selected").text() + "</td>";
                mhtml += "<td class='text-primary'><abbr title='Edit'><input type='number' style='border:none; width:70px' id = 'product_price_edit' name = 'product_price_edit' value = " + $("#productedit option:selected").attr('product-price') + " /></abbr></td>";
                mhtml += "<td class='text-primary'><abbr title='Edit'><input type='number' style='border:none; width:50px' value = '1' type='text' id='product_qty_edit' name='product_qty_edit' ></abbr></td>";
                mhtml += "<td style='display:none;'>" + $("#supplieredit option:selected").val() + "</td>";
                mhtml += "<td style='display:none;'>" + $("#supplieredit option:selected").text() + "</td>";
                mhtml += "<td style='display:none;'>" + $("#orderdateedit").val() + "</td>";
                mhtml += '<td><span class="label label-danger" onclick="removeproduct_edit(' + $("#productedit option:selected").val() + ')" style="cursor:pointer">x</span></td>';
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

            function removeproduct_edit(val) {
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
                        "brandid": $(tr).find('td:eq(0)').text()
                        , "productid": $(tr).find('td:eq(1)').text()
                        , "brandname": $(tr).find('td:eq(2)').text()
                        , "productname": $(tr).find('td:eq(3)').text()
                        , "productprice": $(tr).find('td:eq(4)').find('#product_price_edit').val()
                        , "productqty": $(tr).find('td:eq(5)').find('#product_qty_edit').val()
                        , "supplierid": $(tr).find('td:eq(6)').text()
                        , "suppliername": $(tr).find('td:eq(7)').text()
                        , "orderdate": $(tr).find('td:eq(8)').text()

                    }
                });
                TableData.shift();  // first row will be empty - so remove
                return TableData;
            }

            function editnew() {
                edit_retail_updateorder();
                //console.log(retail_storeOTblValues());
            }

            function edit_retail_updateorder() {
                //if ($("#order-id").val() === "") { //add new visit
                var TableData;
                TableData = edit_retail_storeOTblValues();
                TableData = $.toJSON(TableData);
                if (TableData.length > 2) {
                    $('.orderloader span').text('');
                    $('.orderloader span').addClass('fa fa-spin fa-spinner');
                    $.ajax({
                        type: "POST",
                        url: "purchaseorder_controller/updatepurchase_order",
                        //data: "orderdata=" + TableData,
                        data: {orderdata: TableData, purchaseorder_id: $('#edit_purchaseorder_id').val()},
                        success: function(data) {
                            console.log(data);
                            var result = data.split("|");
                            if (result[0] === "success") {
                                //$("#order-id").val(result[1]);
                                //$('#btngenorderinvoice').show();
                                //retail_clearorder();
                                //retail_openOrder(result[1]);
                                toastr.success('Order updated!', 'Done!');
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
                        title: "You have not added any Products",
                        //text: 'Select Product and staff member providing that made the sale.',
                        type: "warning",
                        confirmButtonText: 'OK!'
                    });
                }
//                } else { //update existing order
//                    var TableData;
//                    TableData = retail_storeOTblValues();
//                    TableData = $.toJSON(TableData);
//                    if (TableData.length > 2) {
//                        $.ajax({
//                            type: "POST",
//                            url: "order_controller/updateorder",
//                            data: "&orderdata=" + TableData + "&orderid=" + $("#order-id").val(),
//                            success: function(data) {
//                                var result = data.split("|");
//                                if (result[0] === "success") {
//                                    //retail_clearorder();
//                                    //retail_openOrder(result[1]);
//                                    //$('#btngenorderinvoice').show();
//                                    toastr.success('Order Updated!', 'Done!');
//                                } else {
//                                    swal({
//                                        title: "Error",
//                                        text: result[1],
//                                        type: "error",
//                                        confirmButtonText: 'OK!'
//                                    });
//                                }
//                            }
//                        });
//                    } else {
//                        swal({
//                            title: "You have not added any Products",
//                            text: 'Select Product and staff member providing that made the sale.',
//                            type: "error",
//                            confirmButtonText: 'OK!'
//                        });
//                    }
//                }
            }
            
            function brandeditchange(){
                    
                    var brandid = $('#brandedit').val();
                    console.log(brandid);
                    if (brandid && brandid !== "") {
                        $(".loader").fadeIn("slow");
                        $("#productedit").select2('val', 'All');
                        $.ajax({
                            type: 'POST',
                            //url: '<?php //echo base_url("purchaseorder_controller/brand_product");    ?>/' + brandid,
                            url: '<?php echo base_url("purchaseorder_controller/brand_product"); ?>',
                            data: {brandid: brandid, businessid: $("#businessid option:selected").val()},
                            dataType: "json",
                            cache: false,
                            async: true,
                            success: function(data) {
                                console.log(data);
                                //$('#product').html('');
                                $('#productedit').html('');
                                if (data.length > 0) {
                                    for (var i = 0; i < data.length; i++) {
                                        //$('#product').append('<option product-price = ' + data[i]['purchase_price'] + ' value = ' + data[i]['id_business_products'] + '>' + data[i]['product'] + '</option>');
                                        $('#productedit').append('<option product-price = ' + data[i]['purchase_price'] + ' value = ' + data[i]['id_business_products'] + '>' + data[i]['product'] + '</option>');
                                    }
                                } else {
                                    //$('#product').append('<option value = ""></option>');
                                    $('#productedit').append('<option value = ""></option>');
                                }
                            }
                        });
                        $(".loader").fadeOut("slow");
                    }
                }
         
        </script>
