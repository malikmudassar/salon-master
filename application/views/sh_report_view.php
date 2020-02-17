<div class="wrapper">
    <div class="container" style="width:100%">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">SH Reports:</h4>
            </div>
        </div>

        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <h4 class="header-title m-t-0 m-b-30">Selection:</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">1. Select Report</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <select id="selectreport" onchange="reportchanged();" class="form-control">
                                                <option value="select">Select</option>
                                                
                                                
                                                <optgroup label='Appointments'>
                                                   
                                                    <option value="open_visits">Appointments</option>                                                    
                                                    <option value="new_customers">New Customers</option>
                                                    <option value="returning_customers">Returning Customers</option>
                                                    <option value="careof_customers">CareOf Customers</option>
                                                    
                                                 </optgroup>   
                                                <optgroup label='Sales'>
                                                    <option value="sales">Sales Details</option>
                                                    <option value="msales">Monthly Sales</option>
    <!--                                                <option value="ssales">Services Sale</option>-->
                                                    <option value="psales">Products Sale Summary</option>
                                                    <option value="psaled">Products Sale Details</option>
                                                    <option value="sscategory">Service Sales By Category</option>
                                                    <option value="ssales">Services Sale Summary</option>
                                                    <option value="ssaled">Services Sale Details</option>
                                                   
                                                    <option value="payment_breakup">Payment Breakup</option>
                                                    
                                                </optgroup>
                                                
                                                <optgroup label='Retail & Stock'>
                                                    
                                                    <option value="staff_retail_sale_summary">Staff Product Sale</option>                                                
                                                    
                                                </optgroup>
                                                
                                                <optgroup label='Staff'>
                                                    
                                                    <option value="staffperf">Staff Performance</option>
                                                    <option value="requested">Requested Staff</option>
                                                </optgroup>
                                                
                                                <optgroup label='Invoices'>
                                                    <option value="invoices">Invoices</option>
                                                    <option value="recoveries">Recoveries</option>
                                                   
                                                </optgroup>
                                                
                                                <optgroup label='Other Reports'>
                                                    <option value="taxes">Taxes Collected</option>                                                    
                                                    <option value="expenses">Expenses</option>
                                                </optgroup>    
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">2. Select Dates</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <div id="reportrange" class="form-control">
                                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">3. Run Report</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" > 
                                            <button type="button" onclick="runreport();" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><i id="cog" class="fa fa-spin fa-cog" style="display:none; font-size:26px;width: auto;margin-right: 10px;"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-5" id="storeselection" style="display:none;">
                                <div class="col-md-12"><strong class="text-info">Optional Filters:</strong></div>
                                <div class="col-md-4" id="stores" >
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="selectstores">Select Stores</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select class="form-control" id="selectstores">
                                                <?php if($this->session->userdata['common_products']=='Yes'){?>
                                                <option value="">All</option>
                                                <?php } ?>
                                                <?php foreach($stores as $store){ ?>
                                                <option <?php if($store['id_business']==$this->session->userdata['businessid']){echo 'selected="selected"';}?> value="<?php echo $store['id_business_stores']?>"><?php echo $store['business_store'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-5" id="productselection" style="display:none;">
                                <div class="col-md-12"><strong class="text-info">Optional Filters:</strong></div>
                                <div class="col-md-4" id="productbrands" >
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="selectbrands">Select Brand</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select class="form-control" id="selectbrands">
                                                <?php foreach($brands as $brand){ ?>
                                                <option value="<?php echo $brand['id_business_brands']?>"><?php echo $brand['business_brand_name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" id="producttype">
                                    <div class="row">
                                        <div class="col-md-12">
                                             <label for="selectbrands">Select Product Type</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select class="form-control" id="selectproducttype">
                                                <option value="0">All</option>
                                                <option value="n">Retail</option>
                                                <option value="y">Professional</option>
                                            </select>
                                         </div>
                                    </div>                                    
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                             <label for="selectbrands">Select Department</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select class="form-control" id="selectbrandstores">
                                                <?php if($this->session->userdata['common_products']=='Yes'){?>
                                                <option value="">All</option>
                                                <?php } ?>
                                                <?php foreach($stores as $store){ ?>
                                                <option <?php if($store['id_business']==$this->session->userdata['businessid']){echo 'selected="selected"';}?> value="<?php echo $store['id_business_stores']?>"><?php echo $store['business_store'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="row m-t-5" id="serviceselection" style="display:none;">
                                 <div class="col-md-12"><strong class="text-info">Optional Filters:</strong></div>
                                <div class="col-md-4" id="servicetype">
                                    <div class="row">
                                        <div class="col-md-12">
                                             <label for="selectservicetype">Select Service Type</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select onchange="servicetypechange();" class="form-control" id="selectservicetype">
                                                <option value="0">All</option>
                                                <?php foreach($servicetypes as $servicetype){ ?>
                                                <option flag="<?php echo $servicetype->flag; ?>" value="<?php echo $servicetype->id_service_types; ?>"><?php echo $servicetype->service_type;?></option>
                                                <?php } ?>
                                            </select>
                                         </div>
                                    </div>                                    
                                </div>
                                <div class="col-md-4" id="servicecategory">
                                    <div class="row">
                                        <div class="col-md-12">
                                             <label for="selectservicecategory">Select Service Category</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select onchange="servicecategorychange()" class="form-control" id="selectservicecategory">
                                                
                                            </select>
                                         </div>
                                    </div>                                    
                                </div>
                                
                                <div class="col-md-4" id="service">
                                    <div class="row">
                                        <div class="col-md-12">
                                             <label for="selectservice">Select Service</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select class="form-control" id="selectservice">
                                               
                                            </select>
                                         </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row m-t-5" id="staffselection" style="display:none;">  
                                 
                                <div class="col-md-4" id="staff">
                                    <div class="row">
                                        <div class="col-md-12">
                                             <label for="selectstaff">Select Staff</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select class="form-control" id="selectstaff">
                                                 <option value="0">All</option>
                                                <?php foreach($staff as $s){ ?>
                                                <option value="<?php echo $s['id_staff']?>"><?php echo $s['staff_fullname'];?></option>
                                                <?php } ?>
                                            </select>
                                         </div>
                                    </div>                                    
                                </div>
                            </div>
                            
                            <div class="row m-t-5" id="businessselection" style="display:none;">  
                                 
                                <div class="col-md-4" id="business">
                                    <div class="row">
                                        <div class="col-md-12">
                                             <label for="selectbusiness">Select Business</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select class="form-control" id="selectbusiness">
                                                 <option value="0">All</option>
                                                <?php foreach($business as $b){ ?>
                                                <option value="<?php echo $b['id_business']?>"><?php echo $b['business_name'];?></option>
                                                <?php } ?>
                                            </select>
                                         </div>
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
                <div class="card-box">
                    <!--<h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>-->
                    <p class="">
                        <button onclick="attendance_view();" class="btn btn-primary waves-effect waves-light m-b-5 atview"> <span>Month View</span> <i class="fa fa-calendar m-l-5"></i> </button>
                    </p>
                    
                    <div class="row">
                    <div id="tableshow" class="table-responsive">
                        <table class="table table-bordered dt-responsive nowrap record" cellspacing="0" width="100%">
                            <tr><td>Summary:</td>
                                <td style="text-align: right">Total</td>
                                <td id="summary"></td>
                            </tr>
                        </table>
                        <table id="tblreport" class="table table-striped table-bordered dt-responsive nowrap record" cellspacing="0" width="100%">
                            
                            <thead>
                                
                                <tr>
                                    <th>Ready</th>
                                </tr>
                            </thead>
                            <tbody>
                            <td>Run report</td>
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                    <div id="otherview" class="table-responsive">
                        <div class="row">
                            <div class="col-lg-12">
                                <table id="monthview" class="table table-striped table-bordered dt-responsive nowrap " cellspacing="0" >
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <td>Run Month</td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

        <script type="text/javascript">

            var startdate = '';
            var enddate = '';
            $(document).ready(function() {
                
                
                
                $('.atview').css('display', 'none');
                $('#otherview').css('display', 'none');
                //$('[data-toggle="tooltip"]').tooltip();

                $(document).on('click', '.usage_details_btn', function() {

                    var product_id = $(this).attr('product_id');
                    var unit = $(this).attr('unit');
                    var total_qty = $(this).attr('total_qty');
                    var units_used = $(this).attr('units_used');
                    var container_type = $(this).attr('container_type');
                    var service_count = $(this).attr('service_count');
                   
                    
                    $('#tableshow').css('display', 'block');
                    $('#otherview').css('display', 'none');
                    $('.atview').css('display', 'none');

                    $.ajax({
                        type: 'POST',
                        url: 'report_controller/product_usage_details',
                        data: {product_id: product_id, startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                        success: function(response) {
                            var data = $.parseJSON(response);
                            if (data.length > 0) {
                                var hhtml = "<tr><th>Invoice</th>" +
                                        "<th>Service</th>" +
                                        "<th>Product</th>" +
                                        "<th>Customer</th>" +
                                        "<th>Date</th>" +
                                        
                                        "<th>Product Usage</th>" +
                                        "<th>Product Measurement Unit</th>" +
                                        "</tr>";
                                var html = "";
                                var fhtml = "";
                                for (var i = 0; data.length > i; i++) {
                                    
                                    html += '<tr>';
                                    html += '<td><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ data[i]['id_invoice'] +'">' + data[i].id_invoice + '</td>';
                                    html += '<td>' + data[i].service_name  + '</td>';
                                    html += '<td>' + data[i].product_name + ' - ' + data[i].category +  '</td>';
                                    html += '<td>' + data[i].customer_name + '</td>';
                                    html += '<td>' + data[i].Date + '</td>';
                                    
                                    html += '<td>' + data[i].product_qty + '</td>';
                                    html += '<td>' + data[i].product_unit + '</td>';
                                    html += '</tr>';
                                }
                                //html += '<tr><td colspan="7"></td></tr>';
                                html += '<tr>';
                                html += '<td>Total Services : ' + service_count + '</td>';
                                html += '<td></td>';
                                html += '<td></td>';
                                html += '<td></td>';
                                
                                html += '<td></td>';
                                html += '<td>Total Usage : ' + total_qty + ' ' + unit + '</td>';
                                html += '<td>Units Used : ' + units_used + ' ' + container_type + '(s)</td>';
                                html += '</tr>';

                                $("#tblreport").dataTable().fnDestroy();
                                $("#tblreport thead").html('');
                                $("#tblreport tbody").html('');
                                $("#tblreport tfoot").html('');
                                $("#tblreport thead").append(hhtml);
                                $("#tblreport tbody").append(html);
                                //$("#tblreport tfoot").append(fhtml);
                                $.fn.dataTable.moment('DD-MM-YYYY');
                                $('#tblreport').DataTable({
                                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                    stateSave: true, fixedHeader: {header: true},
                                    dom: "Bfrtlip",
                                    buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                                            extend: "excel",
                                            className: "btn-sm"
                                        }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
                                    responsive: !0
                                });

                            }
                        }
                    });

                });

                $(document).on('click', '.commission_btn', function() {

                    var staff_id = $(this).attr('staff_id');
                    var total=0;
                    var paid=0; 
                    $('#tableshow').css('display', 'block');
                    $('#otherview').css('display', 'none');
                    $('.atview').css('display', 'none');

                    $.ajax({
                        type: 'POST',
                        url: 'report_controller/commission_details',
                        data: {staff_id: staff_id, startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                        success: function(response) {
                            var data = $.parseJSON(response);
                            if (data.length > 0) {
                                var hhtml = "<tr>" +
                                        "<th>Staff Name</th>" +
                                        "<th>Service Name</th>" +
                                        "<th>Customer Visit</th>" +
                                        "<th>Invoiced</th>" +
                                        "<th>Invoice ID</th>" +
                                        "<th>Price</th>" +
                                        "<th>Paid Amount</th>" +
                                        "<th>@</th>" +
                                        "<th>Commission</th>" +
                                        "</tr>";
                                var html = "";
                                for (var i = 0; data.length > i; i++) {
                                    
                                    html += '<tr>';
                                    html += '<td>' + data[i].staff_fullname + '</td>';
                                    html += '<td>' + data[i].service_type + ' ' + data[i].service_category + ' ' + data[i].service_name + '</td>';
                                    html += '<td>' + data[i].customer_visit_date + '</td>';
                                    html += '<td>' + data[i].staff_service_date + '</td>';
                                    html += '<td><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ data[i].invoice_id +'">' + data[i].invoice_id + '</a> <span class="text-danger">'+ data[i].reference_invoice_number.substr(data[i].reference_invoice_number.length-4,data[i].reference_invoice_number.length) +'</span></td>';
                                    html += '<td>' + data[i].discounted_price + '</td>';
                                    paid = paid+parseFloat(data[i].paid);
                                    html += '<td>' + data[i].paid + '</td>';
                                    html += '<td>' + data[i].staff_commission + ' %</td>';
                                    var comm =parseFloat(data[i].paid) * parseFloat(data[i].staff_commission)/100;
                                    html += '<td>' + comm.toFixed(2)  + '</td>';
                                    total = total+comm;
                                    html += '</tr>';
                                }
                                total=total.toFixed(2);
                                paid=paid.toFixed(2);
                                $("#tblreport").dataTable().fnDestroy();
                                $("#tblreport thead").html('');
                                $("#tblreport tbody").html('');
                                $("#tblreport tfoot").html('<tr><th colspan=6></th><th>'+paid+'</th><th></th><th><strong>'+total+'</strong></th></tr>');
                                $("#tblreport thead").append(hhtml);
                                $("#tblreport tbody").append(html);
                                //$("#tblreport tfoot").append(fhtml);
                                
                                $("#summary").html(total.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                                //$("#summary").html('');
                                $.fn.dataTable.moment('DD-MM-YYYY');
                                $('#tblreport').DataTable({
                                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                    stateSave: true, fixedHeader: {header: true},
                                    dom: "Bfrtlip",
                                    buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                                            extend: "excel",
                                            className: "btn-sm"
                                        }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
                                    responsive: !0
                                });

                            }
                        }
                    });

                });
                
                 $(document).on('click', '.retail_commission_btn', function() {

                    var staff_id = $(this).attr('staff_id');
                    var total=0;
                    var paid=0; 
                    $('#tableshow').css('display', 'block');
                    $('#otherview').css('display', 'none');
                    $('.atview').css('display', 'none');

                    $.ajax({
                        type: 'POST',
                        url: 'report_controller/retail_commission_details',
                        data: {staff_id: staff_id, startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                        success: function(response) {
                            var data = $.parseJSON(response);
                            if (data.length > 0) {
                                var hhtml = "<tr>" +
                                        "<th>Staff Name</th>" +
                                        "<th>Product Name</th>" +
                                        "<th>Invoce Date</th>" +                                        
                                        "<th>Invoice ID</th>" +
                                        "<th>Price</th>" +
                                        "<th>Paid Amount</th>" +
                                        "<th>@</th>" +
                                        "<th>Commission</th>" +
                                        "</tr>";
                                var html = "";
                                for (var i = 0; data.length > i; i++) {
                                    
                                    html += '<tr>';
                                    html += '<td>' + data[i].staff_fullname + '</td>';
                                    html += '<td>' + data[i].business_brand_name + ' ' + data[i].product + ' ' + data[i].qty_per_unit + ' ' + data[i].measure_unit +'</td>';
                                    html += '<td>' + data[i].invoice_date + '</td>';
                                   
                                    html += '<td><a target="_blank" href="<?php echo base_url();?>existingorderinvoice/'+ data[i].invoice_id +'">' + data[i].invoice_id + '</a> <span class="text-danger">'+ data[i].reference_invoice_number.substr(data[i].reference_invoice_number.length-4,data[i].reference_invoice_number.length) +'</span></td>';
                                    html += '<td>' + data[i].discounted_price + '</td>';
                                    paid = paid+parseFloat(data[i].paid);
                                    html += '<td>' + data[i].paid + '</td>';
                                    html += '<td>' + data[i].commission + ' %</td>';
                                    
                                    html += '<td>' +  data[i].staff_commission  + '</td>';
                                   
                                    html += '</tr>';
                                }
                                total=total.toFixed(2);
                                paid=paid.toFixed(2);
                                $("#tblreport").dataTable().fnDestroy();
                                $("#tblreport thead").html('');
                                $("#tblreport tbody").html('');
                                $("#tblreport tfoot").html('<tr><th colspan=5></th><th>'+paid+'</th><th></th><th><strong>'+total+'</strong></th></tr>');
                                $("#tblreport thead").append(hhtml);
                                $("#tblreport tbody").append(html);
                                //$("#tblreport tfoot").append(fhtml);
                                
                                $("#summary").html(total.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                                //$("#summary").html('');
                                $.fn.dataTable.moment('DD-MM-YYYY');
                                $('#tblreport').DataTable({
                                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                    stateSave: true, fixedHeader: {header: true},
                                    dom: "Bfrtlip",
                                    buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                                            extend: "excel",
                                            className: "btn-sm"
                                        }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
                                    responsive: !0
                                });

                            }
                        }
                    });

                });
                
                $.fn.dataTable.moment('DD-MM-YYYY');
                $('#tblreport').DataTable({
                    dom: "Bfrtlip",
                    buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                            extend: "excel",
                            className: "btn-sm"
                        }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
                    responsive: !0
                });

                $('#monthview').DataTable({
                    dom: "Bfrtlip",
                    buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                            extend: "excel",
                            className: "btn-sm"
                        }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
                    responsive: !0
                });

                //$('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

                $('#reportrange').daterangepicker({
                    format: 'MM/DD/YYYY',
                    startDate: moment().subtract(15, 'days'),
                    endDate: moment(),
                    minDate: '01/01/2012',
                    maxDate: '12/31/2020',
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
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                });
                
                $('#selectreport').select2();
            });
            //TableManageButtons.init();

            
            function reportchanged(){
            
                if ($("#selectreport option:selected").val()=='stock_status'){
                    $("#storeselection").css('display', 'block');
                    
                } else {
                    $("#storeselection").css('display', 'none');
                   
                }
            
                if ($("#selectreport option:selected").val()=='stock_status_brand'){
                    $("#productselection").css('display', 'block');
                    
                } else {
                    $("#productselection").css('display', 'none');
                   
                }
                
                if ($("#selectreport option:selected").val()=='open_visits' || $("#selectreport option:selected").val()=='ssaled' ){
                    
                    $("#serviceselection").css('display', 'block');
                    $("#staffselection").css('display', 'block');
                } else {
                    
                    $("#serviceselection").css('display', 'none');
                    $("#staffselection").css('display', 'none');
                }
                
                if($("#selectreport option:selected").val()=='loyaltyredemption' || $("#selectreport option:selected").val()=='sharedcustomers'){
                    $("#businessselection").css('display', 'block');
                    $("#businessselection").css('display', 'block');
                } else {
                    $("#businessselection").css('display', 'none');
                    $("#businessselection").css('display', 'none');
                }

            }

            function servicetypechange(){
                $("#selectservicecategory").empty();
                $("#selectservice").empty();
                $.ajax({
                    type: 'POST',
                    url: 'service_controller/getServicesCategories',
                    data: {service_type_id: $("#selectservicetype option:selected").val(), flag: $("#selectservicetype option:selected").attr("flag")},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        var html="<option value='0'>All</option>";
                        
                        for (x = 0; x < data.length; x++) {
                            html+="<option value='"+data[x]['id_service_category']+"' flag='"+data[x]['flag']+"' '>"+data[x]['service_category']+"</option>";
                        }
                        
                        $("#selectservicecategory").append(html);
                    }
                });
            }
            
            function servicecategorychange(){
                $("#selectservice").empty();
                $.ajax({
                    type: 'POST',
                    url: 'service_controller/getServicesByCategory',
                    data: {id_service_category: $("#selectservicecategory option:selected").val(), flag: $("#selectservicecategory option:selected").attr("flag")},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        var html="<option value='0'>All</option>";
                        
                        for (x = 0; x < data.length; x++) {
                            html+="<option value='"+data[x]['id_business_services']+"'>"+data[x]['service_name']+"</option>";
                        }
                        
                        $("#selectservice").append(html);
                    }
                });
            }
                
            function runreport() {
                var reportname = $('#selectreport').val();
                //console.log(reportname);
                if (startdate == "" || enddate == "") {
                    swal({
                        title: "Select Date Range",
                        text: "Please select a date Range",
                        type: "warning",
                        confirmButtonText: 'OK!'
                    });
                    return false;
                }

                //console.log(startdate.format('YYYY-MM-DD') + ' ' + enddate.format('YYYY-MM-DD'));
                $("#summary").html('');
                if (reportname === 'sales') {
                    sales();
                } else if (reportname === 'msales') {
                    msales();
                } else if (reportname === 'sscategory') {
                    sscategory();
                } else if (reportname === 'ssales') {
                    ssales();
                } else if (reportname === 'ssaled') {
                    ssaled();
                } else if (reportname === 'staffperf') {
                    staffperf();
                } else if (reportname === 'psales') {
                    psales();
                } else if (reportname === 'psaled') {
                    psaled()
                } else if (reportname === 'pusages') {
                    pusages();
                } else if (reportname === 'invoices') {
                    invoices();
                } else if (reportname === 'recoveries') {
                    recoveries();
                } else if (reportname === 'cancelledinvoices') {
                    cancelledinvoices();
                } else if (reportname === 'commissions') {
                    commissions();
                } else if (reportname === 'retailcommissions') {
                    retailcommissions();
                } else if (reportname === 'taxes') {
                    taxes();
                } else if (reportname === 'attendance') {
                    attendance();
                } else if (reportname === 'discount') {
                    discount();
                } else if (reportname === 'voucher') {
                    voucher();
                } else if (reportname === 'bad_debts') {
                    bad_debts();
                } else if (reportname === 'stock_status') {
                    stock_status();
                } else if (reportname === 'stock_status_brand') {
                    stock_status_brand();
                } else if (reportname === 'expenses') {
                    expenses();
                }else if (reportname === 'dispatch') {
                    dispatch();
                }else if (reportname === 'dispatch_details') {
                    dispatch_details();
                }else if(reportname === 'cancelled_visits'){
                    cancelled_visits();
                }else if(reportname === 'open_visits'){
                    open_visits();
                }else if(reportname === 'customer_profile'){
                    customer_profile();
                }else if(reportname === 'new_customers'){
                    new_customers();
                }else if(reportname === 'returning_customers'){
                    returning_customers();
                }else if(reportname === 'advance_collected'){
                    advance_collected();
                }else if(reportname === 'cash_register'){
                    cash_register();
                }else if(reportname === 'payment_breakup'){ 
                    payment_breakup();
                }else if(reportname === 'payment_breakup_services'){ 
                    payment_breakup_services();        
                }else if(reportname === 'payment_breakup_sale'){ 
                    payment_breakup_sale();        
                } else if(reportname === 'staff_retail_sale_summary'){
                    staff_retail_sale_summary();
                } else if(reportname === 'receivables'){
                    receivables();
                } else if(reportname === 'recoverinvoices'){
                    recoverinvoices();
                } else if (reportname === 'loyaltyredemption'){
                    loyaltyredemption();
                } else if (reportname === 'sharedcustomers'){
                    sharedcustomers();
                } else if (reportname === 'careof_customers'){
                    careof_customers();
                }else if (reportname === 'requested'){
                    requested();
                }
                
            }

            function sales() {
               
                $('#tableshow').css('display', 'block');
                $('.atview').css('display', 'none');
                $('#otherview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/sales',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        var totalpaid=0;
                        var totalbal=0;
                        var totaldiscount=0;
                        var cancel='';

                        var hhtml = "<tr><th>VisitDate</th><th>Invoiced</th><th>Invoice</th><th>Customer</th><th>Sale Type</th><th>Is Recovery?</th><th>Sub Total</th><th class='text-danger'>Discount</th><th>Gross</th><th>Taxes</th><th class='text-info'>Advance</th><th class='text-success'>Net Amount</th><th class='text-info'>Paid</th><th class='text-danger'>Balance</th><th>Remarks</th></tr>"

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            if(data[x]['invoice_status']=="valid"){
                                totalpaid=totalpaid+parseFloat(data[x]['paid']);
                                totalbal=totalbal+parseFloat(data[x]['balance']);
                                totaldiscount=totaldiscount+parseFloat(data[x]['Discount']);
                                cancel='';
                            } else {
                                cancel='text-decoration: line-through;';
                            }
                            mhtml += '<tr>';
                            if(data[x]['reference_number']){
                                mhtml += '<td style="'+cancel+'">Recovery</td>';
                            } else if (data[x]['invoice_status']!=="valid"){ 
                                mhtml += '<td style="'+cancel+'" class="text-danger">Cancelled</td>';
                            } else {
                                mhtml += '<td style="'+cancel+'">' + data[x]['visit'] + '</td>';
                            }
                            mhtml += '<td style="'+cancel+'">' + data[x]['Invoiced'] + '</td>';
                            if(data[x]['Sale Type']=="service"){
                                mhtml += '<td style="'+cancel+'"><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ data[x]['invoice_id'] +'">' + data[x]['invoice_id'] + '</a></td>';
                            } else {
                                mhtml += '<td style="'+cancel+'"><a target="_blank" href="<?php echo base_url();?>existingorderinvoice/'+ data[x]['invoice_id'] +'">' + data[x]['invoice_id'] + '</a></td>';
                            }
                            mhtml += '<td style="'+cancel+'">' + data[x]['customer_name'] + '</td>';
                            mhtml += '<td style="'+cancel+'">' + data[x]['Sale Type'] + '</td>';
                            var res = []; 
                            if(data[x]['reference_number'] && data[x]['reference_number']!=='bad debts'){res = data[x]['reference_number'].split("-")} else {res[2]=''};
                            if(data[x]['Sale Type']=="service"){                            
                                mhtml += '<td style="'+cancel+'"><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ res[2] +'">' + res[2] + '</a></td>';
                            } else {
                                mhtml += '<td style="'+cancel+'"><a target="_blank" href="<?php echo base_url();?>existingorderinvoice/'+ res[2] +'">' + res[2] + '</a></td>';
                            }
                            mhtml += '<td style="'+cancel+'">' + data[x]['Sub Total'] + '</td>';
                            mhtml += '<td style="'+cancel+'" class="text-danger">' + data[x]['Discount'] + '</td>';
                            mhtml += '<td style="font-weight:bold;">' + data[x]['Gross'] + '</td>';
                            mhtml += '<td style="'+cancel+'">' + data[x]['Taxes'] + '</td>';
                            mhtml += '<td class="text-info" style="font-weight:bold;">' + data[x]['advance'] + '</td>';
                            mhtml += '<td class="text-success" style="font-weight:bold;">' + data[x]['Net Amount'] + '</td>';
                            if(data[x]['invoice_status']=="valid"){
                                mhtml += '<td class="text-info" style="font-weight:bold;">' + data[x]['paid'] + '</td>';
                                mhtml += '<td class="text-danger" style="font-weight:bold;">' + data[x]['balance'] + '</td>';                           
                                mhtml += '<td>' + data[x]['discount_remarks'] + '</td>';
                            } else {
                                mhtml += '<td class="text-info" style="font-weight:bold; text-decoration: line-through;">0</td>';
                                mhtml += '<td class="text-danger" style="font-weight:bold; text-decoration: line-through;">0</td>';                           
                                mhtml += '<td>' + data[x]['cancelreason'] + '</td>';
                            }
                            mhtml += '</tr>';
                        }
                        

                        totaldiscount=totaldiscount.toFixed(2);
                        var fhtml="<tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th>"+totaldiscount.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"</th><th></th><th></th><th></th><th></th><th>"+totalpaid.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"</th><th>"+totalbal.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") +"</th><th></th></tr>"
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html(fhtml);
                       
                        $("#summary").html('Received: <strong class="text-info">'+ totalpaid.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '/-</strong>');//&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Balance: <strong class="text-danger">' + totalbal.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '/-</strong>');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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

            function msales() {
            
                var totalpaid=0;
                
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/msales',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(alldata) {
                        var data = alldata['sales'];
                        var advance = alldata['advance'];
                        var voucher = alldata['voucher'];
                        
                        
                        var hhtml = "<tr><th>Month</th><th>Year</th><th>Sub Total</th><th class='text-danger'>Discount</th><th>Gross</th><th>Taxes</th><th class='text-success'>Net Amount</th><th class='text-info'>Invoice</th></tr>";

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            
                            
                            
                            var totalrec = 0;
                            
                            mhtml += '<tr>';
                            mhtml += '<td><span class="label label-pink">' + data[x]['Month'] + '</span></td>';
                            mhtml += '<td><span class="label label-pink">' + data[x]['Year'] + '</span></td>';
                            mhtml += '<td>' + data[x]['Sub Total'] + '</td>';
                            mhtml += '<td class="text-danger">' + data[x]['Discount'] + '</td>';
                            mhtml += '<td>' + data[x]['Gross'] + '</td>';
                            mhtml += '<td>' + data[x]['Taxes'] + '</td>';
                            mhtml += '<td class="text-success" style="font-weight:bold;">' + data[x]['Net Amount'] + '</td>';
                            mhtml += '<td class="text-info" style="font-weight:bold;">' + data[x]['paid'] + '</td>';
                            totalrec=totalrec+parseFloat(data[x]['paid']);
                            
                            mhtml += '</tr>';
                            totalpaid=totalpaid + totalrec;
                        }

                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');
                        totalpaid=totalpaid.toFixed(2);
                       
                        $("#summary").html('Received: <strong class="text-info">'+ totalpaid.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '/-</strong>'); //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Balance: <strong class="text-danger">' + totalbal.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '/-</strong>');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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
            function sscategory(){
                var totalpaid=0;
                var totalbal=0;
                $('#tableshow').css('display', 'block');
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/category_sales',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        var totalpaid=0;
                        var hhtml = "<tr><th>Type</th><th>Category</th><th>Count</th><th>Basic Price</th><th class='text-info'>Total Paid</th></tr>"; //<th class='text-danger'>Balance</th></tr>";
                        
                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
//                            if(data[x]['reference_number']==''){
//                            totalpaid=totalpaid+parseFloat(data[x]['paid']);} else {
//                            totalrecovery=totalrecovery+parseFloat(data[x]['paid']);}
                            mhtml += '<tr>';
                          
                            mhtml += '<td>' + data[x]['service_type'] + '</td>';
                            mhtml += '<td>' + data[x]['service_category'] + '</td>';
                            mhtml += '<td>' + data[x]['services'] + '</td>';
                            mhtml += '<td>' + data[x]['price'] + '</td>';
                            mhtml += '<td class="text-info" style="font-weight:bold;">' + data[x]['paid'] + '</td>';
//                            mhtml += '<td class="text-danger" style="font-weight:bold;">' + data[x]['balance'] + '</td>';
                            mhtml += '</tr>';
                            totalpaid = totalpaid + parseFloat(data[x]['paid']);
                        }
                        totalpaid=totalpaid.toFixed(2);
                        var fhtml="<tr><th></th><th></th><th></th><th></th><th>"+totalpaid.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"</th></tr>"
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html(fhtml);
                        
                      //  $("#summary").html('Received: <strong class="text-info">'+ totalpaid.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '/-</strong>');
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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
            
            function ssales() {
               
                $('#tableshow').css('display', 'block');
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/service_sales',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        var totalpaid=0;
                        var totaldiscount=0;

                        var hhtml = "<tr><th>Type</th><th>Category</th><th>Service</th><th>Count</th><th>Price</th><th  class='text-danger'>Service Discount</th><th  class='text-danger'>Invoice Discount</th><th class='text-success'>Total Payable</th><th class='text-info'>Paid</th></tr>";//<th class='text-danger'>Balance</th></tr>"

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            totalpaid=totalpaid+parseFloat(data[x]['paid']);
                            totaldiscount=totaldiscount+parseFloat(data[x]['discount']);
                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['service_type'] + '</td>';
                            mhtml += '<td>' + data[x]['service_category'] + '</td>';
                            mhtml += '<td>' + data[x]['service_name'] + '</td>';
                            mhtml += '<td>' + data[x]['service_count'] + '</td>';
                            mhtml += '<td>' + data[x]['price'] + '</td>';
                            mhtml += '<td class="text-danger">' + data[x]['discount'] + '</td>';
                            
                            var invoicediscount=parseFloat(data[x]['price']) - parseFloat(data[x]['payable']);
                            
                            if(invoicediscount>=0){
                                mhtml += '<td class="text-danger">' + parseFloat(invoicediscount).toFixed(2)+ '</td>';
                            } else {
                                mhtml += '<td class="text-success">' + parseFloat(invoicediscount*-1).toFixed(2) + ' Extra</td>';
                            }
                            mhtml += '<td>' + data[x]['payable'] + '</td>';
//                            mhtml += '<td class="text-success" style="font-weight:bold;">' + data[x]['Net Amount'] + '</td>';
                            mhtml += '<td class="text-info" style="font-weight:bold;">' + data[x]['paid'] + '</td>';
                            //mhtml += '<td class="text-danger" style="font-weight:bold;">' + data[x]['balance'] + '</td>';
                            mhtml += '</tr>';
                        }
                        totaldiscount=totaldiscount.toFixed(2);
                        totalpaid=totalpaid.toFixed(2);
                        var fhtml="<tr><th></th><th></th><th></th><th></th><th></th><th></th><th>"+totaldiscount.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"</th><th></th><th>"+totalpaid.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"</th></tr>"
                        
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html(fhtml);
                        
                      //  $("#summary").html('Received: <strong class="text-info">'+ totalpaid.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '/-</strong>');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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

            function ssaled() {
                //product_sale_details
                var totalpaid=0;
                var totalrecovery=0;
                $('#tableshow').css('display', 'block');
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/service_sale_details',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD'), id_service_type:$("#selectservicetype option:selected").val(), service_type:$("#selectservicetype option:selected").text(), id_service_category:$("#selectservicecategory option:selected").val(), service_category:$("#selectservicecategory option:selected").text(), id_business_services:$("#selectservice option:selected").val(), service_name:$("#selectservice option:selected").text(), staff_id:$("#selectstaff option:selected").val(), staff_name:$("#selectstaff option:selected").text()},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        var totalpaid=0;
                        var totalbal=0;
                        var totaldiscount=0;

                        var hhtml = "<tr><th>ID</th><th>Category</th><th>VisitDate</th><th>Customer</th><th>Cell</th><th>Staff</th><th>Is Recovery?</th><th>Type</th><th>Service</th><th>InvoiceDate</th><th>Price</th><th>Invoice Discount</th><th>Service Discount</th><th class='text-success'>Discounted Price</th><th class='text-info'>Paid</th></tr>"; //<th class='text-danger'>Balance</th></tr>";

                        var mhtml = ""; var idinvoice='';
                        for (x = 0; x < data.length; x++) {
                            if(idinvoice !== data[x]['id_invoice_details']){
                                totalpaid=totalpaid+parseFloat(data[x]['paid']);
                                totaldiscount=totaldiscount+parseFloat(data[x]['Service Discount']);

                                if(data[x]['reference_number']==''){
                                totalpaid=totalpaid+parseFloat(data[x]['paid']);} else {
                                totalrecovery=totalrecovery+parseFloat(data[x]['paid']);}
                                mhtml += '<tr>';
    //                            mhtml += '<td>' + data[x]['id_invoice'] + '</td>';
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ data[x]['id_invoice'] +'">' + data[x]['id_invoice'] + '</a></td>';
                                mhtml += '<td>' + data[x]['service_category'] + '</td>';
                                mhtml += '<td>' + data[x]['visited'] + '</td>';    
                                mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                                mhtml += '<td>' + data[x]['customer_cell'] + '</td>';
                                mhtml += '<td>' + data[x]['staff'] + '</td>';
                                var res = []; 
                                if(data[x]['reference_number']){res = data[x]['reference_number'].split("-")} else {res[2]=''};
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ res[2] +'">' + res[2] + '</a></td>';

                                mhtml += '<td>' + data[x]['service_type'] + '</td>';

                                mhtml += '<td>' + data[x]['service_name'] + '</td>';

                                mhtml += '<td>' + data[x]['invoiced'] + '</td>';



                                mhtml += '<td>' + data[x]['price'] + '</td>';
                                mhtml += '<td class="text-danger">' + data[x]['Invoice Discount'] + '</td>';
                                mhtml += '<td class="text-danger">' + data[x]['Service Discount'] + '</td>';
                                mhtml += '<td class="text-success" style="font-weight:bold;">' + data[x]['Net Amount'] + '</td>';
                                mhtml += '<td class="text-info" style="font-weight:bold;">' + data[x]['paid'] + '</td>';
    //                            if(idinvoice!==data[x]['id_invoice']){
    //                                mhtml += '<td class="text-danger" style="font-weight:bold;">' + data[x]['balance'] + '</td>';
    //                            } else {
    //                                mhtml += '<td></td>';
    //                            }
                                mhtml += '</tr>';
                            } else {
                                 mhtml += '<tr>';
                                mhtml += '<td style="color:red"><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ data[x]['id_invoice'] +'">' + data[x]['id_invoice'] + '</a></td>';
                                mhtml += '<td style="color:red">' + data[x]['service_category'] + '</td>';
                                mhtml += '<td style="color:red">' + data[x]['visited'] + '</td>';    
                                mhtml += '<td style="color:red">' + data[x]['customer_name'] + '</td>';
                                mhtml += '<td style="color:red">' + data[x]['customer_cell'] + '</td>';
                                mhtml += '<td style="color:red">' + data[x]['staff'] + ' (Additional)</td>';
                                var res = []; 
                                if(data[x]['reference_number']){res = data[x]['reference_number'].split("-")} else {res[2]=''};
                                mhtml += '<td style="color:red"><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ res[2] +'">' + res[2] + '</a></td>';

                                mhtml += '<td style="color:red">' + data[x]['service_type'] + '</td>';

                                mhtml += '<td style="color:red">' + data[x]['service_name'] + '</td>';

                                mhtml += '<td style="color:red">' + data[x]['invoiced'] + '</td>';



                                mhtml += '<td style="color:red">-</td>';
                                mhtml += '<td class="text-danger">-</td>';
                                mhtml += '<td class="text-danger">-</td>';
                                mhtml += '<td class="text-success" style="font-weight:bold;">-</td>';
                                mhtml += '<td class="text-info" style="font-weight:bold;">-</td>';
                                }
                            idinvoice=data[x]['id_invoice_details'];
                        }
                        
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');
                        totalpaid=totalpaid.toFixed(2);
                       // $("#summary").html('New Sale: <strong class="text-info">'+ totalpaid.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '/-</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recovered: <strong class="text-info">'+ totalrecovery.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '/-</strong>');
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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

            function staffperf() {
                // staff performance details
                $('#tableshow').css('display', 'block');
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/staff_performance',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        var hhtml = "<tr><th>Staff</th><th>Type</th><th>Category</th><th>Service</th><th>Count</th></tr>"

                        var mhtml = "";
                        for (var x = 0; x < data.length; x++) {

                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['staff_name'] + '</td>';
                            mhtml += '<td>' + data[x]['service_type'] + '</td>';
                            mhtml += '<td>' + data[x]['service_category'] + '</td>';
                            mhtml += '<td>' + data[x]['service_name']  + '</td>';
                            mhtml += '<td>' + data[x]['service_count'] + '</td>';
                           
                            mhtml += '</tr>';

                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');

                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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

            function psales() {
               
                $('#tableshow').css('display', 'block');
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/product_sales',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        var totaldiscount=0;
                        var totalpaid=0;
                        
                        var hhtml = "<tr><th>Brand</th><th>Product</th><th>Quantity</th><th>Total</th><th>Discount</th><th>Paid</th></tr>"

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            totalpaid=totalpaid+parseFloat(data[x]['Paid']);
                            totaldiscount=totaldiscount+parseFloat(data[x]['Discount']);
                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['brand_name'] + '</td>';
                            mhtml += '<td>' + data[x]['product_name'] + ' - ' + data[x]['category'] + '</td>';
                            mhtml += '<td>' + data[x]['Quantity'] + '</td>';
                            mhtml += '<td class="text-success">' + data[x]['Price'] + '</td>';
                            mhtml += '<td class="text-danger">' + data[x]['Discount'] + '</td>';
                            mhtml += '<td class="text-info">' + data[x]['Paid'] + '</td>';
                            mhtml += '</tr>';
                            
                            
                        }
                        totaldiscount=totaldiscount.toFixed(2);
                        totalpaid=totalpaid.toFixed(2);
                        var fhtml="<tr><th></th><th></th><th></th><th></th><th>"+totaldiscount.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"</th><th>"+totalpaid.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"</th></tr>"
                        
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html(fhtml);
                       
                        //totalbal=totalbal.toFixed(2);
                        //$("#summary").html('Received: <strong class="text-info">'+ totalpaid.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '/-</strong>');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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

            function psaled() {
                
                //product_sale_details
                $('#tableshow').css('display', 'block');
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/product_sale_details',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        var totalpaid=0;
                        var totaldiscount=0;
                        var totalrecovered=0;
                        
                        var hhtml = "<tr><th>ID</th><th>Brand</th><th>Product</th><th>Date</th><th>Customer</th><th>Sold By</th><th>Is Recovery?</th><th>Quantity</th><th>Price</th><th>Discount</th><th>Total</th><th>Paid</th></tr>"

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            if(data[x]['reference_number']==''){
                                totalpaid=totalpaid+parseFloat(data[x]['Paid']);
                            } else { totalrecovered = totalrecovered+parseFloat(data[x]['Paid']);}
                            mhtml += '<tr>';
                            mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existingorderinvoice/'+ data[x]['id_invoice'] +'">' + data[x]['id_invoice'] + '</a></td>';
                            mhtml += '<td>' + data[x]['Brand'] + '</td>';
                            mhtml += '<td>' + data[x]['Product'] + ' - ' + data[x]['category'] + '</td>';
                            mhtml += '<td>' + data[x]['Date'] + '</td>';
                            mhtml += '<td>' + data[x]['Customer'] + '</td>';
                            mhtml += '<td>' + data[x]['Sold By'] + '</td>';
                            var res = []; 
                            if(data[x]['reference_number']){res = data[x]['reference_number'].split("-")} else {res[2]=''};
                            mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existingorderinvoice/'+ res[2] +'">' + res[2] + '</a></td>';
                            mhtml += '<td>' + data[x]['Quantity'] + '</td>';
                            mhtml += '<td>' + data[x]['price'] + '</td>';
                            mhtml += '<td class="text-danger">' + data[x]['Discount'] + '</td>';
                            mhtml += '<td class="text-success">' + data[x]['Total'] + '</td>';
                            mhtml += '<td class="text-info">' + data[x]['Paid'] + '</td>';
                            
                            mhtml += '</tr>';
                        }
                        totalrecovered=totalpaid.toFixed(2);
                        totaldiscount=totaldiscount.toFixed(2);
                        totalpaid=totalpaid.toFixed(2);
                        var fhtml="<tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th>"+totaldiscount.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"</th><th></th><th>"+totalpaid.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"</th></tr>"
                        
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html(fhtml);
                        
                        //totalbal=totalbal.toFixed(2);
                        //$("#summary").html('New Sale: <strong class="text-info">'+ totalpaid.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '/-</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recovered: <strong class="text-info">'+ totalrecovered.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '/-</strong>');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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



            function pusages() {
                $('#tableshow').css('display', 'block');
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/product_usage_summary',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {


                        var hhtml = "<tr><th>Brand</th><th>Product</th><th>Service Count</th><th>Usage</th><th>Unit</th><th>Container Type</th><th>Container Qty</th><th>Container Used</th><th>Action</th></tr>"

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {

                            mhtml += '<tr>';
                            //mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ data[x]['id_invoice'] +'">' + data[x]['id_invoice'] + '</a></td>';
                            mhtml += '<td>' + data[x]['business_brand_name'] + '</td>';
                            mhtml += '<td>' + data[x]['product_name'] + ' - ' + data[x]['category'] + '</td>';
                            mhtml += '<td>' + data[x]['product_count'] + '</td>';
                            mhtml += '<td>' + data[x]['total_qty'] + '</td>';
                            mhtml += '<td>' + data[x]['product_unit'] + '</td>';
                            mhtml += '<td>' + data[x]['Container Type'] + '</td>';
                            mhtml += '<td>' + data[x]['Container Qty'] + '</td>';
                            mhtml += '<td>' + parseFloat(data[x]['Container Used']).toFixed(2) + '</td>';
                            mhtml += '<td><button type="button" product_id="' + data[x]['product_id'] + '" unit="' + data[x]['product_unit'] + '" total_qty="' + data[x]['total_qty'] + '" container_type="' + data[x]['Container Type'] + '" units_used="' + parseFloat(data[x]['Container Used']).toFixed(2) + '" service_count="' + data[x]['product_count'] + '" class="btn btn-sm btn-info usage_details_btn">View Details</button></td>';
                            mhtml += '</tr>';
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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

            function invoices() {
                $('#tableshow').css('display', 'block');
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/invoices',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {

                        var hhtml = "<tr><th>ID #</th><th>Customer</th><th>Payment Mode</th><th>CC</th><th>Date</th><th>Type</th><th>By</th><th>Is Recovery?</th><th class='text-info'>Advance</th><th class='text-info'>Paid</th><th class='text-danger'>Balance</th><th>Sub Total</th><th>Discount</th><th>Gross</th><th>Taxes</th><th class='text-success'>Net Amount</th><th>Discount by</th><th>Contact</th><th>Email</th><th>Remarks</th><th>Cash</th><th>Card</th><th>Check</th><th>Voucher</th></tr>"

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {

                            mhtml += '<tr>';
                            var res = []; 
                            if(data[x]['invoice_number']){res = data[x]['invoice_number'].split("-")} else {res[2]=''};
                            if(data[x]['invoice_type']=="service"){                            
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ res[2] +'">' +  data[x]['invoice_number'] + '</a></td>';
                            } else {
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existingorderinvoice/'+ res[2] +'">' +  data[x]['invoice_number'] + '</a></td>';
                            }
                            mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                            mhtml += '<td>' + data[x]['payment_mode'] + '</td>';
                            mhtml += '<td>' + data[x]['instrument_number'] + '</td>';
                            mhtml += '<td>' + data[x]['invoice_date'] + '</td>';
                            mhtml += '<td>' + data[x]['invoice_type'] + '</td>';
                            mhtml += '<td>' + data[x]['created_by'] + '</td>';
                            var resr = []; 
                            if(data[x]['reference_invoice_number']){resr = data[x]['reference_invoice_number'].split("-")} else {resr[2]=''};
                            if(data[x]['invoice_type']=="service"){                            
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ resr[2] +'">' + data[x]['reference_invoice_number'] + '</a></td>';
                            } else {
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existingorderinvoice/'+ resr[2] +'">' + data[x]['reference_invoice_number'] + '</a></td>';
                            }
                            mhtml += '<td class="text-info" style="font-weight:bold;">' + data[x]['advance_amount'] + '</td>';
                            mhtml += '<td class="text-info" style="font-weight:bold;">' + data[x]['paid_amount'] + '</td>';
                            mhtml += '<td class="text-danger" style="font-weight:bold;">' + data[x]['balance'] + '</td>';
                            mhtml += '<td>' + data[x]['sub_total'] + '</td>';
                            mhtml += '<td>' + data[x]['discount'] + '</td>';
                            mhtml += '<td>' + data[x]['gross_amount'] + '</td>';
                            mhtml += '<td>' + data[x]['tax_total'] + '</td>';
                            mhtml += '<td class="text-success" style="font-weight:bold;">' + data[x]['net_amount'] + '</td>';
                            mhtml += '<td><span class="label label-pink">' + (data[x]['name'] != null ? data[x]['name'] : "") + '</span></td>';
                             mhtml += '<td>' + data[x]['customer_cell'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_email'] + '</td>';
                            mhtml += '<td>' + data[x]['remarks'] + '</td>';
                            mhtml += '<td>' + data[x]['paid_cash'] + '</td>';
                            mhtml += '<td>' + data[x]['paid_card'] + '</td>';
                            mhtml += '<td>' + data[x]['paid_check'] + '</td>';
                            mhtml += '<td>' + data[x]['paid_voucher'] + '</td>';
                            mhtml += '</tr>';
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');

                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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
            
            function recoveries() {
                $('#tableshow').css('display', 'block');
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/recoveries',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {

                        var hhtml = "<tr><th>ID #</th><th>Customer</th><th>Payment Mode</th><th>CC</th><th>Date</th><th>Type</th><th>Is Recovery?</th><th class='text-info'>Paid</th><th class='text-danger'>Balance</th><th>Sub Total</th><th>Discount</th><th>Gross</th><th>Taxes</th><th class='text-success'>Net Amount</th><th>Discount by</th><th>Contact</th><th>Email</th></tr>"

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {

                            mhtml += '<tr>';
                            var res = []; 
                            if(data[x]['invoice_number']){res = data[x]['invoice_number'].split("-")} else {res[2]=''};
                            if(data[x]['invoice_type']=="service"){                            
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ res[2] +'">' +  data[x]['invoice_number'] + '</a></td>';
                            } else {
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existingorderinvoice/'+ res[2] +'">' +  data[x]['invoice_number'] + '</a></td>';
                            }
                            mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                            mhtml += '<td>' + data[x]['payment_mode'] + '</td>';
                            mhtml += '<td>' + data[x]['instrument_number'] + '</td>';
                            mhtml += '<td>' + data[x]['invoice_date'] + '</td>';
                            mhtml += '<td>' + data[x]['invoice_type'] + '</td>';
                            
                            var resr = []; 
                            if(data[x]['reference_invoice_number']){resr = data[x]['reference_invoice_number'].split("-")} else {resr[2]=''};
                            if(data[x]['invoice_type']=="service"){                            
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ resr[2] +'">' + data[x]['reference_invoice_number'] + '</a></td>';
                            } else {
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existingorderinvoice/'+ resr[2] +'">' + data[x]['reference_invoice_number'] + '</a></td>';
                            }
                            
                            mhtml += '<td class="text-info" style="font-weight:bold;">' + data[x]['paid_amount'] + '</td>';
                            mhtml += '<td class="text-danger" style="font-weight:bold;">' + data[x]['balance'] + '</td>';
                            mhtml += '<td>' + data[x]['sub_total'] + '</td>';
                            mhtml += '<td>' + data[x]['discount'] + '</td>';
                            mhtml += '<td>' + data[x]['gross_amount'] + '</td>';
                            mhtml += '<td>' + data[x]['tax_total'] + '</td>';
                            mhtml += '<td class="text-success" style="font-weight:bold;">' + data[x]['net_amount'] + '</td>';
                            mhtml += '<td><span class="label label-pink">' + (data[x]['name'] != null ? data[x]['name'] : "") + '</span></td>';
                             mhtml += '<td>' + data[x]['customer_cell'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_email'] + '</td>';
                            mhtml += '</tr>';
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');

                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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

            function cancelledinvoices() {
                $('#tableshow').css('display', 'block');
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/cancelled_invoices',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {

                        var hhtml = "<tr><th>ID #</th><th>Customer</th><th>Payment Mode</th><th>CC</th><th>Date</th><th>Type</th><th>Reason</th><th>By</th><th>Is Recovery?</th><th class='text-info'>Paid</th><th class='text-danger'>Balance</th><th>Sub Total</th><th>Discount</th><th>Gross</th><th>Taxes</th><th class='text-success'>Net Amount</th><th>Discount by</th><th>Contact</th><th>Email</th></tr>"

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {

                            mhtml += '<tr>';
                            var res = []; 
                            if(data[x]['invoice_number']){res = data[x]['invoice_number'].split("-");} else {res[2]='';}
                            if(data[x]['invoice_type']=="service"){                            
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ res[2] +'">' +  data[x]['invoice_number'] + '</a></td>';
                            } else {
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existingorderinvoice/'+ res[2] +'">' +  data[x]['invoice_number'] + '</a></td>';
                            }
                            mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                            mhtml += '<td>' + data[x]['payment_mode'] + '</td>';
                            mhtml += '<td>' + data[x]['instrument_number'] + '</td>';
                            mhtml += '<td>' + data[x]['invoice_date'] + '</td>';
                            mhtml += '<td>' + data[x]['invoice_type'] + '</td>';
                            mhtml += '<td >' + data[x]['cancelreason'] + '</td>';
                            mhtml += '<td class="text-danger">' + data[x]['cancelled_by'] + '</td>';
                            var resr = []; 
                            if(data[x]['reference_invoice_number']){resr = data[x]['reference_invoice_number'].split("-")} else {resr[2]=''};
                            if(data[x]['invoice_type']=="service"){                            
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ resr[2] +'">' + data[x]['reference_invoice_number'] + '</a></td>';
                            } else {
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existingorderinvoice/'+ resr[2] +'">' + data[x]['reference_invoice_number'] + '</a></td>';
                            }
                            
                            mhtml += '<td class="text-info" style="font-weight:bold;"><strike>' + data[x]['paid_amount'] + '</strike></td>';
                            mhtml += '<td class="text-danger" style="font-weight:bold;"><strike>' + data[x]['balance'] + '</strike></td>';
                            mhtml += '<td><strike>' + data[x]['sub_total'] + '</strike></td>';
                            mhtml += '<td><strike>' + data[x]['discount'] + '</strike></td>';
                            mhtml += '<td><strike>' + data[x]['gross_amount'] + '</strike></td>';
                            mhtml += '<td><strike>' + data[x]['tax_total'] + '</strike></td>';
                            mhtml += '<td class="text-success" style="font-weight:bold;"><strike>' + data[x]['net_amount'] + '</strike></td>';
                            mhtml += '<td><span class="label label-pink">' + (data[x]['name'] != null ? data[x]['name'] : "") + '</span></td>';
                             mhtml += '<td>' + data[x]['customer_cell'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_email'] + '</td>';
                            mhtml += '</tr>';
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');

                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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

            function commissions() {
                $('#tableshow').css('display', 'block');
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/commissions',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {

                        var hhtml = "<tr><th>Staff Name</th><th>Month</th><th>Year</th><th>Total Services</th><th>Paid</th><th>Recoveries</th><th>Total</th><th>Action</th></tr>";
                        var total=0;
                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            total=total+parseFloat(data[x]['Commission']);
                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['staff_name'] + '</td>';
                            mhtml += '<td><span class="label label-danger">' + data[x]['Month'] + '</span></td>';
                            mhtml += '<td><span class="label label-danger">' + data[x]['Year'] + '</span></td>';
                            
                            mhtml += '<td>' + data[x]['Total Services'] + '</td>';
                            mhtml += '<td>' + data[x]['Amount'] + '</td>';
                            mhtml += '<td>' + data[x]['Recovery'] + '</td>';
                            mhtml += '<td>' + data[x]['Total'] + '</td>';
                            //mhtml += '<td>' + data[x]['commission_perc'] + '%</td>';
                            //mhtml += '<td>' + data[x]['Commission'] + '</td>';
                            mhtml += '<td><button type="button" staff_id="' + data[x]['staff_id'] + '" class="btn btn-sm btn-info commission_btn"><i class="fa fa-calculator"></i> Calculate</button></td>';
                            mhtml += '</tr>';
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');
                        total=total.toFixed(2);
                        $("#summary").html(total.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        $("#summary").html('');
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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

            function retailcommissions() {
                $('#tableshow').css('display', 'block');
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/retailcommissions',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {

                        var hhtml = "<tr><th>Staff Name</th><th>Month</th><th>Year</th><th>Total Products</th><th>Paid</th><th>Recoveries</th><th>Total</th><th>Action</th></tr>";
                        var total=0;
                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            total=total+parseFloat(data[x]['Commission']);
                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['staff_name'] + '</td>';
                            mhtml += '<td><span class="label label-danger">' + data[x]['Month'] + '</span></td>';
                            mhtml += '<td><span class="label label-danger">' + data[x]['Year'] + '</span></td>';
                            
                            mhtml += '<td>' + data[x]['Total Products'] + '</td>';
                            mhtml += '<td>' + data[x]['Amount'] + '</td>';
                            mhtml += '<td>' + data[x]['Recovery'] + '</td>';
                            mhtml += '<td>' + data[x]['Total'] + '</td>';
                            //mhtml += '<td>' + data[x]['commission_perc'] + '%</td>';
                            //mhtml += '<td>' + data[x]['Commission'] + '</td>';
                            mhtml += '<td><button type="button" staff_id="' + data[x]['staff_id'] + '" class="btn btn-sm btn-info retail_commission_btn"><i class="fa fa-calculator"></i> Calculate</button></td>';
                            mhtml += '</tr>';
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');
                        total=total.toFixed(2);
                        $("#summary").html(total.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        $("#summary").html('');
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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

            function taxes() {
                $('#tableshow').css('display', 'block');
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/taxes',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {

                        var hhtml = "<tr><th>Month</th><th>Year</th><th>Tax Type</th><th>Total</th></tr>"

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {

                            mhtml += '<tr>';
                            mhtml += '<td><span class="label label-danger">' + data[x]['Month'] + '</span></td>';
                            mhtml += '<td><span class="label label-danger">' + data[x]['Year'] + '</span></td>';
                            mhtml += '<td>' + data[x]['Tax Type'] + '</td>';
                            mhtml += '<td>' + data[x]['Total'] + '</td>';
                            mhtml += '</tr>';
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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

            function attendance() {
                $('#tableshow').css('display', 'block');
                $('.atview').css('display', 'block');
                $("#cog").show();
                var date_array = get_dates();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/attendance',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        var staff = data['staff'];
                        var attend = data['attendance'];

                        var currdate = new Date();
                        //console.log((currdate.getMonth()+1) + "---"+ currdate.getDate());
                        var inout = "";
                        inout += '<tr><td>--</td><td>---</td>';
                        var tabl = 'IN | OUT';
                        var th;
                        var hhtml = "<tr><th>Id</th><th>Staff</th>";
                        for (var d = 0; d <= date_array.length - 1; d++) {
                            var date = date_array[d].split("-");
                            hhtml += "<th style='min-width:60px; border-right: 3px solid rgb(220,220,220);'>" + date[2] + "<br>" + date[3] + "</th>";
                            inout += '<td style="border-right: 3px solid rgb(220,220,220);">' + tabl + '</td>';
                        }
                        inout += '</tr>';
                        hhtml += "</tr>"
                        var final = "";
                        final += hhtml;
                        final += inout;

                        var mhtml = "";
                        for (x = 0; x < staff.length; x++) {
                            mhtml += '<tr>';
                            mhtml += '<td>' + staff[x]['id_staff'] + '</td>';
                            mhtml += '<td><span class="label label-success">' + staff[x]['staff_fullname'] + '</span></td>';
                            var td = "";
                            var day = "";
                            var present = "";
                            for (var d = 0; d <= date_array.length - 1; d++) {
                                for (var i = 0; i < attend.length; i++) {
                                    var dates = date_array[d].split("-");
                                    var date_match = dates[0] + "-" + dates[1] + "-" + dates[2];
                                    var time_show = attend[i]['time_show'];
                                    var timeinout = "<td class='bg-primary' title='IN'>" + attend[i]['time_show'] + '</td>\n\
                                    <td class="bg-pink text-white" title="OUT">' + (attend[i]['time_show_out'] != null ?
                                            attend[i]['time_show_out'] : '') + "</td>";
                                    if (date_match == attend[i]['time_in'] && attend[i]['staff_id'] == staff[x]['id_staff']) {
                                        //present = "<span title = '"+time_show+"' >"+timeinout+"</span>";
                                        present = "<table  class='table table-bordered table-collapse'><tr>" + timeinout + "</tr></table>";

                                    }

                                }
                                td += "<td style='border-right: 3px solid rgb(220,220,220);'>" + present + "</td>";
                                present = "";
                            }

                            mhtml += td;
                            mhtml += '</tr>';
                            day = "";
                        }

                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(final);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');

                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
                            buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                                    extend: "excel",
                                    className: "btn-sm"
                                }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
                            responsive: false,
                            //"scrollX": true,
                            "autoWidth": true,
                            "columnDefs": [
                                {"width": "50%", "targets": 3}
                            ]
                        });
                        $("#cog").hide();
                        attendance_month_view(data);
                    }
                });

            }

            function get_dates() {
                var day = 1000 * 60 * 60 * 24;
                var date1 = new Date(startdate.format('YYYY-MM-DD'));
                var date2 = new Date(enddate.format('YYYY-MM-DD'));
                var DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'];
                var diff = (date2.getTime() - date1.getTime()) / day;
                var date_array = [];
                var days_array = [];
                for (var i = 0; i <= diff; i++)
                {
                    var xx = date1.getTime() + day * i;
                    var yy = new Date(xx);
                    var date_return = yy.getFullYear() + "-" + (yy.getMonth()<10?'0':'') + (yy.getMonth() + 1) + "-" +  yy.getDate() + "-" + DAYS[yy.getDay()];
                    date_array[i] = date_return;
                    days_array[i] = DAYS[yy.getDay()];
                    console.log(date_return);
                    //console.log(yy.getFullYear() + "-" + (yy.getMonth() + 1) + "-" + yy.getDate());
                    //console.log(yy.getDate());
                }

                return date_array;
            }

            function attendance_view() {
                if ($('.atview span').text() == 'Dates View') {
                    $('#tableshow').css('display', 'block');
                    $('.atview span').text('Month View');
                    $('#otherview').css('display', 'none');
                } else {
                    $('.atview span').text('Dates View');
                    $('#tableshow').css('display', 'none');
                    $('#otherview').css('display', 'block');
                }
            }

            function attendance_month_view(data) {
                var date_array = get_dates();
                var staff = data['staff'];
                var attend = data['attendance'];
                var attend_month = data['attendance_month_view'];
                //console.log(attend_month);
                var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                var hhtml = "<tr><th>Id</th><th>Staff</th>";
                for (var d = 0; d <= month.length - 1; d++) {
                    var date = date_array[d].split("-");
                    hhtml += "<th style='min-width:60px;'>" + month[d] + "</th>";

                }
                hhtml += "</tr>"
                var mhtml = "";
                for (var x = 0; x < staff.length; x++) {

                    mhtml += '<tr>';
                    mhtml += '<td>' + staff[x]['id_staff'] + '</td>';
                    mhtml += '<td><span class="label label-success">' + staff[x]['staff_fullname'] + '</span></td>';
                    var td = "";
                    var day = "";
                    var present = "";
                    for (var d = 0; d <= month.length - 1; d++) {
                        for (var i = 0; i < attend_month.length; i++) {
                            if (month[d] == attend_month[i]['month'] && attend_month[i]['staff_id'] == staff[x]['id_staff']) {
                                var percentage = (attend_month[i]['present'] / attend_month[i]['monthdays']) * 100;
                                present = "<span class='label label-primary'>" + Math.round(percentage) + "%</span>";

                            }

                        }
                        td += "<td>" + present + "</td>";
                        present = "";
                    }

                    mhtml += td;
                    mhtml += '</tr>';
                    day = "";
                }

                $("#monthview").dataTable().fnDestroy();
                $("#monthview thead").html('');
                $("#monthview tbody").html('');
                $("#monthview thead").append(hhtml);
                $("#monthview tbody").append(mhtml);

                $('#monthview').DataTable({
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    stateSave: true, fixedHeader: {header: true},
                    dom: "Bfrtlip",
                    buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                            extend: "excel",
                            className: "btn-sm"
                        }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
                    responsive: !0
                });
                $("#cog").hide();
            }

            function discount() {
                $('#tableshow').css('display', 'block');
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/discount',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {

                        var hhtml = "<tr><th>Date</th><th>Invoice Number</th><th>Customer</th><th>Reason</th><th>Actual Price</th><th >Discounted Price</th><th class='text-danger'>Discount</th><th>Remarks</th><th>Given by</th><th>Invoiced By</th></tr>";

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {

                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['Date'] + '</td>';
                            var res = []; 
                            if(data[x]['invoice_number']){res = data[x]['invoice_number'].split("-")} else {res[2]=''};
                            if(data[x]['invoice_type']=="service"){                            
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ res[2] +'">' + data[x]['invoice_number'] + '</a></td>';
                            } else {
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existingorderinvoice/'+ res[2] +'">' + data[x]['invoice_number'] + '</a></td>';
                            }
                             mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                            
                            mhtml += '<td>' + data[x]['discount_type'] + '</td>';
                           mhtml += '<td >' + data[x]['price'] + '</td>';
                           mhtml += '<td >' + data[x]['discounted_price'] + '</td>';
                            mhtml += '<td class="text-danger">' + data[x]['discount'] + '</td>';
                            mhtml += '<td >' + data[x]['discount_remarks'] + '</td>';
                            mhtml += '<td >' + data[x]['by'] + '</td>';
                            mhtml += '<td >' + data[x]['created_by'] + '</td>';
                            mhtml += '</tr>';
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');

                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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

            function voucher() {
                $('#tableshow').css('display', 'block');
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/voucher',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        // console.log("voucher: <?php echo date('d-m-Y', time()); ?>");
                        var hhtml = "<tr><th>Date</th><th>Valid Till</th><th>Voucher #</th><th>Customer</th><th class='text-danger'>Voucher Type</th><th>Payment Mode</th><th class='text-success'>Amount</th><th class='text-success'>Remaining Amount</th></tr>"
                        var todaydate = "<?php echo date('Y-m-d'); ?>";
                        var totalcash=0;
                        var totalcard=0;
                        var totalcheck=0;
                        var totalremaining=0;
                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            var d = data[x]['valid_date'];
                            var v = d.split("-");
                            var valid_date = v[2] + '-' + v[1] + '-' + v[0];
                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['date'] + '</td>';
                            mhtml += '<td>' + (data[x]['valid_date'] >= todaydate ? '<span  style="margin-right:5px">' + valid_date + '</span> <span class="label label-success">Valid</span>' : '<span style="margin-right:5px">' + valid_date + '</span> <span class="label label-danger">Expired</span>') + '</td>';
                            mhtml += '<td>' + data[x]['voucher_number'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                            mhtml += '<td class="text-danger">' + data[x]['type'] + '</td>';
                            mhtml += '<td>' + data[x]['payment_mode'] + '</td>';
                            mhtml += '<td class="text-success">' + data[x]['amount'] + '</td>';
                            mhtml += '<td class="text-success">' + data[x]['remaining_amount'] + '</td>';
                            mhtml += '</tr>';
                            totalcash+= parseInt(data[x]['paid_cash']);
                            totalcard+= parseInt(data[x]['paid_card']);
                            totalcheck+= parseInt(data[x]['paid_check']);
                            totalremaining=totalremaining + parseInt(data[x]['remaining_amount']);
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport thead").append(hhtml);
                        var totalamount = 0;
                        for (x = 0; x < data.length; x++) {
                            totalamount += parseFloat(data[x]['amount']);
                        }
                        $("#tblreport tfoot").html('');
                        $("#tblreport tfoot").append("<tr><td></td><td></td><td></td><td></td><td></td><td>Total:</td><td> " + totalamount.toFixed(2) + "</td><td>"+totalremaining.toFixed(2) + "</td></tr>");
                        $("#summary").html('Cash: '+totalcash+'<br>Card:'+totalcard+'<br>Check:'+totalcheck);
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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

            function bad_debts() {
                $('#tableshow').css('display', 'block');
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/bad_debts',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {


                        var hhtml = "<tr><th>Date</th><th>ID</th><th>Customer</th><th>Sale Type</th><th >Discount</th><th>Paid</th><th >Balance</th><th class='text-success'>Net Amount</th></tr>"

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {

                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['Date'] + '</td>';
                            mhtml += '<td>' + data[x]['invoice_number'] + '</td>';
                            mhtml += '<td>' + data[x]['customer'] + '</td>';
                            mhtml += '<td>' + data[x]['Sale Type'] + '</td>';
                            mhtml += '<td class="text-danger">' + data[x]['Discount'] + '</td>';
                            mhtml += '<td class="text-info" style="font-weight:bold">' + data[x]['paid_amount'] + '</td>';
                            mhtml += '<td><span class="text-danger" style="font-weight:bold"><strike>' + data[x]['balance'] + '</strike></span></td>';
                            mhtml += '<td class="text-success" style="font-wieght:bold;">' + data[x]['Net Amount'] + '</td>';
                            mhtml += '</tr>';
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');

                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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

            function stock_status() {
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/stock_status',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD'), store_id:$("#selectstores option:selected").val()},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {

                        var hhtml = "<tr><th>ID</th><th>Brand</th><th>Product</th><th>BF</th><th>Added Manually</th><th>Purchased</th><th>Transfer In</th><th>Transfer Out</th><th>Sold</th><th>Used</th><th>Returned</th><th>Remaining</th><th>Avg. Price</th><th>Value</th></tr>";

                        var mhtml = "";
                        var fhtml="";
                        var totalvalue=0;
                        for (x = 0; x < data.length; x++) {

                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['id_business_products'] + '</td>';
                            mhtml += '<td>' + data[x]['business_brand_name'] + '</td>';
                            mhtml += '<td>' + data[x]['product'] + ' ' + data[x]['category'] + '</td>';
                            
                            mhtml += '<td >' + (data[x]['BF'] != null ? data[x]['BF'] : "0") + '</td>';
                            mhtml += '<td >' + (data[x]['Qty'] != null ? data[x]['Qty'] : "0") + '</td>';
                            mhtml += '<td >' + (data[x]['purchased'] != null ? data[x]['purchased'] : "0") + '</td>';
                            mhtml += '<td >' + (data[x]['transfer_in'] != null ? data[x]['transfer_in'] : "0") + '</td>';
                            mhtml += '<td >' + (data[x]['transfer_out'] != null ? data[x]['transfer_out'] : "0") + '</td>';
                            
                            mhtml += '<td >' + (data[x]['sold'] != null ? data[x]['sold'] : '0') + '</td>';
                            mhtml += '<td >' + (data[x]['used'] != null ? data[x]['used'] : '0') + '</td>';
                            mhtml += '<td >' + (data[x]['used'] != null ? data[x]['returned'] : '0') + '</td>';
                            mhtml += '<td>' + data[x]['total_stock'] + '</td>';
                            mhtml += '<td>' + data[x]['batch_amount'] + '</td>';
                            mhtml += '<td style="text-align:right">' + data[x]['stock_value'] + '</td>';
                            totalvalue=totalvalue+ parseFloat(data[x]['stock_value']);
                            mhtml += '</tr>';
                        }
                        //console.log(mhtml);
                        fhtml = "<tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th style='text-align:right'>"+totalvalue.toFixed(2)+"</th><th</th></tr>";
                        
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html(fhtml);

                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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
            
            function stock_status_brand(){
                var store_id="";
                if($("#selectbrandstores option:selected").val()!==""){
                    store_id=$("#selectbrandstores option:selected").val();
                }
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/stock_status_brand',
                    data: {brandid: $("#selectbrands option:selected").val(), producttype: $("#selectproducttype option:selected").val(), startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD'), store_id:store_id},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {

                        var hhtml = "<tr><th>ID</th><th>Brand</th><th>Product</th><th>Brought Forward</th><th>Added Manuall</th><th>Purchased</th><th>Transfered In</th><th>Transfered Out</th><th>Sold</th><th>Used</th><th>Returned</th><th>Remaining</th><th>Avg. Price</th><th>Value</th></tr>";

                        var mhtml = "";
                        var totalvalue=0;
                        for (x = 0; x < data.length; x++) {

                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['id_business_products'] + '</td>';
                            mhtml += '<td>' + data[x]['business_brand_name'] + '</td>';
                            mhtml += '<td>' + data[x]['product'] + ' ' + data[x]['category'] + ' ' + data[x]['qty_per_unit'] + ' ' + data[x]['measure_unit']  + '</td>';
                            mhtml += '<td>' + (data[x]['BF'] != null ? data[x]['BF'] : "0") + '</td>';
                            mhtml += '<td class="text-primary">' + (data[x]['Qty'] != null ? data[x]['Qty'] : "0") + '</td>';
                            mhtml += '<td class="text-primary">' + (data[x]['purchased'] != null ? data[x]['purchased'] : "0") + '</td>';
                            mhtml += '<td class="text-primary">' + (data[x]['transfer_in'] != null ? data[x]['transfer_in'] : "0") + '</td>';
                            mhtml += '<td class="text-danger">' + (data[x]['transfer_out'] != null ? data[x]['transfer_out'] : "0") + '</td>';
                            mhtml += '<td class="text-danger">' + (data[x]['sold'] != null ? data[x]['sold'] : '0') + '</td>';
                            mhtml += '<td class="text-danger">' + (data[x]['used'] != null ? data[x]['used'] : '0') + '</td>';
                            mhtml += '<td class="text-danger">' + (data[x]['used'] != null ? data[x]['returned'] : '0') + '</td>';
                            mhtml += '<td>' + data[x]['total_stock'] + '</td>';
                            mhtml += '<td>' + data[x]['batch_amount'] + '</td>';
                            mhtml += '<td style="text-align:right">' + data[x]['stock_value'] + '</td>';
                            totalvalue=totalvalue+ parseFloat(data[x]['stock_value']);
                            mhtml += '</tr>';
                        }
                        var fhtml = "<tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th style='text-align:right'>"+totalvalue.toFixed(2)+"</th><th</th></tr>";
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html(fhtml);

                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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
            
        function expenses() {
            var totalexp=0;
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/expenses',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {

                        var hhtml = "<tr><th>PV ID</th><th>Created Date</th><th>Voucher Date</th><th>Account</th><th>Description</th><th>Payment Amount</th><th>Created by</th></tr>"

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            totalexp=totalexp+parseFloat(data[x]['voucher_amount']);
                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['id_account_vouchers'] + '</td>';
                            mhtml += '<td>' + data[x]['Date'] + '</td>';
                            mhtml += '<td>' + data[x]['VDate'] + '</td>';
                            mhtml += '<td>' + data[x]['account_head'] + '</td>';
                            mhtml += '<td>' + data[x]['description'] + '</td>';
                            mhtml += '<td class="text-danger" style="font-weight:bold">' + data[x]['expenses'] + '</td>';
                            mhtml += '<td>' + data[x]['created_by'] + '</td>';
                            mhtml += '</tr>';
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');
                        totalexp=totalexp.toFixed(2);
                        $("#summary").html("Total Expense: " + totalexp.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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
            
            
            function cancelled_visits() {
            
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/cancelled_visits',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        
                        var hhtml = "<tr><th>Staff</th><th>VisitID</th><th>Booked on </th><th>Customer</th><th>Cell</th><th>Appointment Date</th><th>Category</th><th>Services</th><th class='text-danger'>Business Lost</th><th>Cancellation Reason</th><th>By</th><th>SMS (reminder)</th><th>Call</th><th>Email</th></tr>";

                        var mhtml = "";
                        var visit_id=0;
                        var total_lost=0;
                        for (x = 0; x < data.length; x++) {
                            total_lost = total_lost + parseFloat(data[x]['service_rate']);
                             mhtml += '<tr>';
                            if(data[x]['id_customer_visits'] !== visit_id){
                                mhtml += '<td>' + data[x]['staff_name'] + '</td>';
                                mhtml += '<td>' + data[x]['id_customer_visits'] + '</td>';
                                mhtml += '<td>' + data[x]['customer_visit_date'] + '</td>';                               
                                mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                                mhtml += '<td>' + data[x]['customer_cell'] + '</td>';
                                mhtml += '<td>' + data[x]['visit_service_start'] + '</td>';
                                mhtml += '<td>' + data[x]['service_category'] + '</td>';
                                mhtml += '<td>' + data[x]['service_name'] + ' ' + data[x].service_desc + '</td>';
                                mhtml += '<td class="text-danger" style="text-align:right">' + data[x]['service_rate'] + '</td>';
                                mhtml += '<td>' + data[x]['cancelreason'] + '</td>';
                                mhtml += '<td>' + data[x]['canceled_by'] + '</td>';
                                mhtml += '<td>' + data[x]['reminder_sms'] + '</td>';
                                mhtml += '<td>' + data[x]['reminder_call'] + '</td>';
                                mhtml += '<td>' + data[x]['reminder_email'] + '</td>';
                            } else {
                                mhtml += '<td></td><td></td><td></td><td></td><td></td>' ;
                                mhtml += '<td>' + data[x]['visit_service_start'] + '</td>';
                                mhtml += '<td>' + data[x]['service_category'] + '</td>';
                                mhtml += '<td>' + data[x]['service_name'] + ' ' + data[x].service_desc + '</td>';
                                mhtml += '<td class="text-danger"  style="text-align:right">' + data[x]['service_rate'] + '</td>';
                                mhtml += '<td>' + data[x]['cancelreason'] + '</td>';
                                mhtml += '<td>' + data[x]['canceled_by'] + '</td>';
                                mhtml += '<td>' + data[x]['reminder_sms'] + '</td>';
                                mhtml += '<td>' + data[x]['reminder_call'] + '</td>';
                                mhtml += '<td>' + data[x]['reminder_email'] + '</td>';
                            }
                            mhtml += '</tr>';
                            visit_id=data[x]['id_customer_visits'] ;
                        }
                        
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('<tr><th colspan="8"></th><th class="text-danger" style="text-align:right">'+parseFloat(total_lost).toFixed(2)+'</th><th colspan="5"></th></tr>');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
                            buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                                    extend: "excel",
                                    className: "btn-sm"
                                }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
                            responsive: !0,
                            ordering: false
                        });
                        $("#cog").hide();

                    }
                });
            }
            
            function open_visits() {
            
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/open_visits',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD'), id_service_type:$("#selectservicetype option:selected").val(), service_type:$("#selectservicetype option:selected").text(), id_service_category:$("#selectservicecategory option:selected").val(), service_category:$("#selectservicecategory option:selected").text(), id_business_services:$("#selectservice option:selected").val(), service_name:$("#selectservice option:selected").text(), staff_id:$("#selectstaff option:selected").val()},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        
                        var hhtml = "<tr><th>Appointment</th><th>Visit ID</th><th>Booked On</th><th>Customer</th><th>Cell</th><th>Staff</th><th>Type</th><th>Category</th><th>Services</th><th>SMS (reminder)</th><th>Call</th><th>Email</th></tr>"
                        var lastvisitid=0;
                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            if(lastvisitid!==data[x]['id_customer_visits'] ){
                                mhtml += '<tr style="background:#fff">';
                                mhtml += '<td>' + data[x]['visit_service_start'] + '</td>';
                                mhtml += '<td>' + data[x]['id_customer_visits'] + '</td>';
                                mhtml += '<td>' + data[x]['date'] + '</td>';
                                
                            } else {
                                mhtml += '<tr style="background:#fff">';
                                mhtml += '<td>' + data[x]['visit_service_start'] + '</td>';
                                mhtml += '<td></td><td></td>';
                            }
                            mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_cell'] + '</td>';
                            
                            mhtml += '<td>' + data[x]['staff_name'] + '</td>';
                            mhtml += '<td>' + data[x]['service_type'] + '</td>';
                            mhtml += '<td>' + data[x]['service_category'] + '</td>';
                            mhtml += '<td>' + data[x]['service_name'] + '</td>';
                            mhtml += '<td>' + data[x]['reminder_sms'] + '</td>';
                            mhtml += '<td>' + data[x]['reminder_call'] + '</td>';
                            mhtml += '<td>' + data[x]['reminder_email'] + '</td>';
                            mhtml += '</tr>';
                            lastvisitid = data[x]['id_customer_visits'];
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
                            ordering: false,
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
            function advance_collected(){
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/advance_collected',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        var advancetotal=0;
                        var hhtml = "<tr><th>AdavanceDate</th><th>VisitDate</th><th>Customer</th><th>Cell</th><th>Type</th><th>Category</th><th>Status</th><th>Advance Mode</th><th>Advance</th><th>Advance Inst.</th></tr>"

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            var mhref="";
                            mhtml += '<tr>';
                            if(data[x]['service_flag']=="servicetype"){mhref="<?php echo base_url();?>invoice_controller/print_advance/";}
                            else {mhref="<?php echo base_url();?>print_booking/";}
                            mhtml += '<td ><a style="text-decoration:underline" target="_blank" href="' + mhref + data[x]['id_customer_visits'] +'">' + data[x]['advance_date'] + '</a></td>';
                            mhtml += '<td>' + data[x]['visitdate'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_cell'] + '</td>';
                            mhtml += '<td>' + data[x]['service_type'] + '</td>';
                            mhtml += '<td>' + data[x]['service_category'] + '</td>';
                            mhtml += '<td>' + data[x]['visit_status'] + '</td>';
                            mhtml += '<td>' + data[x]['advance_mode'] + '</td>';
                            mhtml += '<td class="text-primary">' + data[x]['advance_amount'] + '</td>';
                            mhtml += '<td>' + data[x]['advance_inst'] + '</td>';
                            mhtml += '</tr>';
                            
                            advancetotal=advancetotal + parseFloat(data[x]['advance_amount']);
                        }
                        var fhtml="<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>"+advancetotal+"</td><td></td></tr>"
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html(fhtml);
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true, footer: true},
                            dom: "Bfrtlip",
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
            
            function receivables(){
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/receivables',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        var advancetotal=0;
                        var hhtml = "<tr><th>Visit ID</th><th>Customer Name</th><th>Customer Cell</th><th>Visit Date</th><th>Price</th><th>Adv.</th><th>Receivable</th></tr>";

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            var mhref="";
                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['id_customer_visits'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_cell'] + '</td>';
                            mhtml += '<td>' + data[x]['mDate'] + '</td>';
                            mhtml += '<td>' + data[x]['price'] + '</td>';
                            mhtml += '<td>' + data[x]['advance'] + '</td>';
                            mhtml += '<td>' + data[x]['receivables'] + '</td>';
                            mhtml += '</tr>';
                            
                            advancetotal=advancetotal + parseFloat(data[x]['receivables']);
                        }
                        var fhtml="<tr><th></th><th></th><th></th><th></th><th></th><th></th><th>"+advancetotal+"</th></tr>"
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html(fhtml);
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true, footer: true},
                            dom: "Bfrtlip",
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
            
            function recoverinvoices(){
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/recoveryinvoices',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        var balancetotal=0;
                        var hhtml = "<tr><th>ID</th><th>Branch</th><th>Type</th><th>Invoice #</th><th>Visit Date</th><th>Invoice Date</th><th>Customer Name</th><th>Customer Cell</th><th>Balance</th><th>Sub Total</th><th>Adv.</th><th>Discount</th><th>Gross Amount</th><th>Net Amount</th></tr>";

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            var mhref="";
                            mhtml += '<tr>';
                            
                            mhtml += '<td><a target="_blank" href="<?php echo base_url();?>open_recovery_invoice/'+ data[x]['id_invoice'] +'/'+ data[x]['visit_id'] +'">' + data[x]['id_invoice'] + '</a></td>';
                            mhtml += '<td>' + data[x]['business_name'] + '</td>';
                            mhtml += '<td>' + data[x]['invoice_type'] + '</td>';
                            mhtml += '<td>' + data[x]['invoice_number'] + '</td>';
                            mhtml += '<td>' + data[x]['visit_time'] + '</td>';
                            mhtml += '<td>' + data[x]['invoice_date'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_cell'] + '</td>';
                            mhtml += '<td class="text-danger">' + data[x]['balance'] + '</td>';
                            mhtml += '<td>' + data[x]['sub_total'] + '</td>';
                            mhtml += '<td>' + data[x]['advance_amount'] + '</td>';
                            mhtml += '<td>' + data[x]['discount'] + '</td>';
                            mhtml += '<td>' + data[x]['gross_amount'] + '</td>';
                            mhtml += '<td>' + data[x]['net_amount'] + '</td>';
                            mhtml += '</tr>';
                            
                            balancetotal=balancetotal + parseFloat(data[x]['balance']);
                        }
                        var fhtml="<tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th class='text-danger'>"+balancetotal+"</th></tr>"
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html(fhtml);
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true, footer: true},
                            dom: "Bfrtlip",
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
            
            function loyaltyredemption(){
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/loyaltyredemption',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD'), business_id:$("#selectbusiness option:selected").val()},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        var balancetotal=0;
                        var loyaltyused=0;
                        var hhtml = "<tr><th>ID</th><th>Type</th><th>Invoice #</th><th>Visit Date</th><th>Invoice Date</th><th>Customer Name</th><th>Customer Cell</th><th>Redeemed At</th><th>Balance</th><th>Sub Total</th><th>Adv.</th><th>Discount</th><th>Gross Amount</th><th>Net Amount</th><th>Loyalty Used</th></tr>";

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            var mhref="";
                            mhtml += '<tr>';
                            if(data[x]['invoice_type']=="service"){                            
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ data[x]['id_invoice']+'">' + data[x]['id_invoice'] + '</a></td>';
                            } else {
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existingorderinvoice/'+ data[x]['id_invoice']+'">' + data[x]['id_invoice'] + '</a></td>';
                            }
                            
                            mhtml += '<td>' + data[x]['invoice_type'] + '</td>';
                            mhtml += '<td>' + data[x]['invoice_number'] + '</td>';
                            mhtml += '<td>' + data[x]['visit_time'] + '</td>';
                            mhtml += '<td>' + data[x]['invoice_date'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_cell'] + '</td>';
                            mhtml += '<td class="text-primary"><b>' + data[x]['business_name'] + '</b></td>';
                            mhtml += '<td class="text-danger">' + data[x]['balance'] + '</td>';
                            mhtml += '<td>' + data[x]['sub_total'] + '</td>';
                            mhtml += '<td>' + data[x]['advance_amount'] + '</td>';
                            mhtml += '<td>' + data[x]['discount'] + '</td>';
                            mhtml += '<td>' + data[x]['gross_amount'] + '</td>';
                            mhtml += '<td>' + data[x]['net_amount'] + '</td>';
                            mhtml += '<td>' + data[x]['loyalty_used'] + '</td>';
                            mhtml += '</tr>';
                            
                            balancetotal=balancetotal + parseFloat(data[x]['balance']);
                            loyaltyused=loyaltyused + parseFloat(data[x]['loyalty_used']);
                        }
                        var fhtml="<tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th class='text-danger'>"+balancetotal+"</th><th></th><th></th><th></th><th></th><th></th><th class='text-success'>"+loyaltyused+"</tr>"
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html(fhtml);
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true, footer: true},
                            dom: "Bfrtlip",
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
            
            function sharedcustomers(){
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/sharedcustomers',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD'), business_id:$("#selectbusiness option:selected").val()},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        var balancetotal=0;
                        var loyaltyused=0;
                        var hhtml = "<tr><th>ID</th><th>Type</th><th>Invoice #</th><th>Visit Date</th><th>Invoice Date</th><th>Customer Name</th><th>Customer Cell</th><th>Share From</th><th>Balance</th><th>Sub Total</th><th>Adv.</th><th>Discount</th><th>Gross Amount</th><th>Net Amount</th><th>Loyalty Used</th></tr>";

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            var mhref="";
                            mhtml += '<tr>';
                            if(data[x]['invoice_type']=="service"){                            
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ data[x]['id_invoice']+'">' + data[x]['id_invoice'] + '</a></td>';
                            } else {
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existingorderinvoice/'+ data[x]['id_invoice']+'">' + data[x]['id_invoice'] + '</a></td>';
                            }
                            
                            mhtml += '<td>' + data[x]['invoice_type'] + '</td>';
                            mhtml += '<td>' + data[x]['invoice_number'] + '</td>';
                            mhtml += '<td>' + data[x]['visit_time'] + '</td>';
                            mhtml += '<td>' + data[x]['invoice_date'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_cell'] + '</td>';
                            mhtml += '<td class="text-primary"><b>' + data[x]['business_name'] + '</b></td>';
                            mhtml += '<td class="text-danger">' + data[x]['balance'] + '</td>';
                            mhtml += '<td>' + data[x]['sub_total'] + '</td>';
                            mhtml += '<td>' + data[x]['advance_amount'] + '</td>';
                            mhtml += '<td>' + data[x]['discount'] + '</td>';
                            mhtml += '<td>' + data[x]['gross_amount'] + '</td>';
                            mhtml += '<td>' + data[x]['net_amount'] + '</td>';
                            mhtml += '<td>' + data[x]['loyalty_used'] + '</td>';
                            mhtml += '</tr>';
                            
                            balancetotal=balancetotal + parseFloat(data[x]['balance']);
                            loyaltyused=loyaltyused + parseFloat(data[x]['loyalty_used']);
                        }
                        var fhtml="<tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th class='text-danger'>"+balancetotal+"</th><th></th><th></th><th></th><th></th><th></th><th class='text-success'>"+loyaltyused+"</tr>"
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html(fhtml);
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true, footer: true},
                            dom: "Bfrtlip",
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
            
            
            
            function careof_customers(){
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/careofcustomers',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        
                        var hhtml = "<tr><th>Name</th><th>Careof</th><th>Cell</th><th>Email</th><th>Address</th><th>Birthday</th><th>Anniversary</th><th>Alerts</th><th>Allergies</th><th>Added</th><th>By</th></tr>"

                        var mhtml = "";
                        var i=0;
                        for (x = 0; x < data.length; x++) {
                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_careof'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_cell'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_email'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_address'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_birthday'] + '</td>';
                            mhtml += '<td>' + data[x]['anv'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_alert'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_allergies'] + '</td>';
                            //mhtml += '<td>' + data[x]['m'] + '</td>';
                            mhtml += '<td>' + data[x]['created'] + '</td>';
                            mhtml += '<td>' + data[x]['created_by'] + '</td>';
                            mhtml += '</tr>';
                            i++;
                        }
                        //console.log(mhtml);
                        $("#summary").html(i);
                        
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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
            
            function requested(){
                $('#tableshow').css('display', 'block');
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/requested',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {

                        var hhtml = "<tr><th>ID #</th><th>Customer</th><th>Staff</th><th>Service</th><th>Payment Mode</th><th>CC</th><th>Date</th><th>Type</th><th>Is Recovery?</th><th class='text-info'>Advance</th><th class='text-info'>Paid</th><th class='text-danger'>Balance</th><th>Sub Total</th><th>Discount</th><th>Gross</th><th>Taxes</th><th class='text-success'>Net Amount</th><th>Discount by</th><th>Contact</th><th>Email</th><th>Cash</th><th>Card</th><th>Check</th><th>Voucher</th></tr>"

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {

                            mhtml += '<tr>';
                            var res = []; 
                            if(data[x]['invoice_number']){res = data[x]['invoice_number'].split("-")} else {res[2]=''};
                            if(data[x]['invoice_type']=="service"){                            
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ res[2] +'">' +  data[x]['invoice_number'] + '</a></td>';
                            } else {
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existingorderinvoice/'+ res[2] +'">' +  data[x]['invoice_number'] + '</a></td>';
                            }
                            mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                            mhtml += '<td>' + data[x]['staff_name'] + '</td>';
                            mhtml += '<td>' + data[x]['service_name'] + '</td>';
                            mhtml += '<td>' + data[x]['payment_mode'] + '</td>';
                            mhtml += '<td>' + data[x]['instrument_number'] + '</td>';
                            mhtml += '<td>' + data[x]['invoice_date'] + '</td>';
                            mhtml += '<td>' + data[x]['invoice_type'] + '</td>';
                            
                            var resr = []; 
                            if(data[x]['reference_invoice_number']){resr = data[x]['reference_invoice_number'].split("-")} else {resr[2]=''};
                            if(data[x]['invoice_type']=="service"){                            
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ resr[2] +'">' + data[x]['reference_invoice_number'] + '</a></td>';
                            } else {
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existingorderinvoice/'+ resr[2] +'">' + data[x]['reference_invoice_number'] + '</a></td>';
                            }
                            mhtml += '<td class="text-info" style="font-weight:bold;">' + data[x]['advance_amount'] + '</td>';
                            mhtml += '<td class="text-info" style="font-weight:bold;">' + data[x]['paid_amount'] + '</td>';
                            mhtml += '<td class="text-danger" style="font-weight:bold;">' + data[x]['balance'] + '</td>';
                            mhtml += '<td>' + data[x]['sub_total'] + '</td>';
                            mhtml += '<td>' + data[x]['discount'] + '</td>';
                            mhtml += '<td>' + data[x]['gross_amount'] + '</td>';
                            mhtml += '<td>' + data[x]['tax_total'] + '</td>';
                            mhtml += '<td class="text-success" style="font-weight:bold;">' + data[x]['net_amount'] + '</td>';
                            mhtml += '<td><span class="label label-pink">' + (data[x]['name'] != null ? data[x]['name'] : "") + '</span></td>';
                             mhtml += '<td>' + data[x]['customer_cell'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_email'] + '</td>';
                            mhtml += '<td>' + data[x]['paid_cash'] + '</td>';
                            mhtml += '<td>' + data[x]['paid_card'] + '</td>';
                            mhtml += '<td>' + data[x]['paid_check'] + '</td>';
                            mhtml += '<td>' + data[x]['paid_voucher'] + '</td>';
                            mhtml += '</tr>';
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');

                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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
            
            function cash_register(){
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/cash_register',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        console.debug(data);
                        var transaction=data.transactions;
                        var denomination=data.denominations;
                        var expenses=data.expenses;
                        var vouchers=data.vouchers;
                        var yesterdaytill=data.yesterdaytill;
                       
                        
                        var hhtml = "<tr><th>WorkDate</th><th>Total Sale</th><th>+ Advance</th><th>+ Recovery</th><th>+ Retained</th><th>- Balance</th><th>- Expense</th><th>= Total Transactions</th><th>Yesterday's Till</th><th>Additional Amount</th><th>Tomorrow's Till</th><th>Cash Invoices</th><th>Cash In Hand</th><th>Difference</th><th>Remarks</th></tr>";
                        var mhtml = "";
                        
                        for(x=0; x<transaction.length;x++){
                                
                                var totalCash = transaction[x].totalCash !== null ? transaction[x].totalCash : 0;
                                var totalSale = transaction[x].totalSale !== null ? transaction[x].totalSale : 0;
                                var totalBalance = transaction[x].totalBalance !== null ? transaction[x].totalBalance : 0;
                                var totalRecovery = transaction[x].totalRecovery !== null ? transaction[x].totalRecovery : 0;
                                var totalAdvance = transaction[x].totalAdvance !== null ? transaction[x].totalAdvance : 0;
                                var totalService = transaction[x].totalService !== null ? transaction[x].totalService : 0;
                                var totalRetail = transaction[x].totalRetail !== null ? transaction[x].totalRetail : 0;
                                var totalExpense = expenses[x].today_expenses !== null ? expenses[x].today_expenses : 0;
                                //var totalExpense = denomination[x].daily_expense !== null ? denomination[x].daily_expense : 0;
                                var totalVoucher = vouchers[x].totalVoucherAmount !== null ? vouchers[x].totalVoucherAmount : 0;
                                var Cash = transaction[x].Cash !== null ? parseFloat(transaction[x].Cash) - parseFloat(transaction[x].cctip) : 0;
                                var Card = transaction[x].Card !== null ? transaction[x].Card : 0;
                                var Checks = transaction[x].Checks !== null ? transaction[x].Checks : 0;
                               
                                var Voucher = transaction[x].totalVoucher !== null ? transaction[x].totalVoucher : 0;

                                var totalVoucherCash = vouchers[x].Cash !== null ? vouchers[x].Cash : 0;
                                var totalVoucherCard = vouchers[x].Card !== null ? vouchers[x].Card : 0;
                                var totalVoucherChecks = vouchers[x].Checks !== null ? vouchers[x].Checks : 0;
                                var yestertill = yesterdaytill[x].till_amounts !== null ? yesterdaytill[x].till_amounts : 0;
                                var totaltillamounts = denomination[x].till_amounts !== null ?  denomination[x].till_amounts : 0;
                                var additionalamount= denomination[x].cash_addition !== null ? denomination[x].cash_addition : 0;
                                var totalRetained= transaction[x].totalRetained !== null ? transaction[x].totalRetained : 0;
                                var calCash=parseFloat(parseInt(Cash) + parseInt(totalVoucherCash) ).toFixed(2);
                                totalCash = parseFloat(calCash - parseInt(totalExpense)).toFixed(2);
                                totalSale = parseFloat(parseInt(totalSale) + parseInt(totalVoucher)).toFixed(2);
                                
                                var cashInHand= denomination[x].cash !== null ? denomination[x].cash : 0;
                                var difference= denomination[x].diff !== null ? denomination[x].diff : 0;
                                
                                var diff=((parseFloat(parseInt(cashInHand) - parseInt(yestertill) - parseInt(additionalamount)) - parseInt(totalCash)).toFixed(2));
                                
                                var paymentCash = (parseFloat(parseInt(Cash) + parseInt(totalVoucherCash)).toFixed(2));
                                var paymentCard = (parseFloat(parseInt(Card) + parseInt(totalVoucherCard)).toFixed(2));
                                var paymentChecks = (parseFloat(parseInt(Checks) + parseInt(totalVoucherChecks)).toFixed(2));
                                
                                var totalTransaction=parseFloat((parseFloat(totalSale)+parseFloat(totalAdvance)+parseFloat(totalRecovery)+parseFloat(totalRetained))-(parseFloat(totalBalance)+parseFloat(totalExpense))).toFixed(2);
                                
                                mhtml += '<tr>';
                                mhtml += '<td>'+ transaction[x].passeddate +'</td>';
                               
                                mhtml += '<td style="font-weight:bold; text-align:right">'+ totalSale + '</td>';
                                mhtml += '<td class="text-default" style="text-align:right">' + totalAdvance + '</td>';
                                mhtml += '<td class="text-success" style="text-align:right">' + totalRecovery + '</td>';
                                mhtml += '<td style="text-align:right">'+ totalRetained +'</td>';
                                mhtml += '<td class="text-danger" style="text-align:right">' + totalBalance + '</td>';
                                mhtml += '<td class="text-danger" style="text-align:right">' + totalExpense + '</td>';
                                
                                mhtml += '<td class="text-default" style="font-weight:bold; text-align:right">'+ totalTransaction + '</td>';
                                mhtml += '<td style="text-align:right">'+ yestertill +'</td>';
                                mhtml += '<td style="text-align:right">'+ additionalamount +'</td>';
                                
                                mhtml += '<td style="text-align:right">'+ totaltillamounts +'</td>';
                                mhtml += '<td class="text-primary" style="text-align:right">'+ totalCash +'</td>';
                                mhtml += '<td class="text-primary" style="text-align:right">'+ parseFloat(cashInHand).toFixed(2) +'</td>';
                                var c="text-primary";
                                if(parseInt(diff)<0){c="text-danger";} else if(parseInt(diff)>0) {c="text-success";}
                                mhtml += '<td class="'+c+'" style="font-weight:bold; text-align:right;" >' + diff + '</td>';
                                mhtml += '<td>' + denomination[x].remarks + '</td>';
                                
                                mhtml += '</tr>';
                            
                        }
                        
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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
            
            function payment_breakup(){
            
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                var totalcash=0; var totalcard=0; var totalcheck=0;
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/payment_breakup',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        
                        var hhtml = "<tr><th>WorkDate</th><th style='font-weight:bold; text-align:right'>Cash </th><th style='font-weight:bold; text-align:right'>Card</th><th style='font-weight:bold; text-align:right'>Check</th></tr>";
                        var mhtml = "";
                        
                        for(x=0; x<data.length;x++){
                                
                                mhtml += '<tr>';
                                mhtml += '<td>'+ data[x]['workdate'] +'</td>';
                                <?php if($this->session->userdata('role')=="Sh-Users"){?>
                                     mhtml += '<td style="text-align:right">'+ data[x]['cash_only'] + '</td>';
                                    mhtml += '<td class="text-default" style="text-align:right">' + data[x]['card_only'] + '</td>';
                                    mhtml += '<td class="text-success" style="text-align:right">' + data[x]['check_only'] + '</td>';
                                     totalcash=totalcash+parseFloat(data[x]['cash_only']);
                                    totalcard=totalcard+parseFloat(data[x]['card_only']);
                                    totalcheck=totalcheck+parseFloat(data[x]['check_only']);
                                <?php } else {?>
                                    mhtml += '<td style="text-align:right">'+ data[x]['cash'] + '</td>';
                                    mhtml += '<td class="text-default" style="text-align:right">' + data[x]['card'] + '</td>';
                                    mhtml += '<td class="text-success" style="text-align:right">' + data[x]['check'] + '</td>';
                                     totalcash=totalcash+parseFloat(data[x]['cash']);
                                    totalcard=totalcard+parseFloat(data[x]['card']);
                                    totalcheck=totalcheck+parseFloat(data[x]['check']);
                                <?php } ?>
                                mhtml += '</tr>';
                               
                            
                        }
                        
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('<tr><th></th><th style="text-align:right">'+totalcash.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</th><th style="text-align:right">'+totalcard.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</th><th style="text-align:right">'+totalcheck.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</th></tr>');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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
            
            function payment_breakup_services(){
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                var totalcash=0; var totalcard=0; var totalcheck=0;
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/payment_breakup_services',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        
                        var hhtml = "<tr><th>WorkDate</th><th style='font-weight:bold; text-align:right'>Cash </th><th style='font-weight:bold; text-align:right'>Card</th><th style='font-weight:bold; text-align:right'>Check</th></tr>";
                        var mhtml = "";
                        
                        for(x=0; x<data.length;x++){
                                
                                mhtml += '<tr>';
                                mhtml += '<td>'+ data[x]['workdate'] +'</td>';
                                mhtml += '<td style="text-align:right">'+ data[x]['cash'] + '</td>';
                                mhtml += '<td class="text-default" style="text-align:right">' + data[x]['card'] + '</td>';
                                mhtml += '<td class="text-success" style="text-align:right">' + data[x]['check'] + '</td>';
                                mhtml += '</tr>';
                                totalcash=totalcash+parseFloat(data[x]['cash']);
                                totalcard=totalcard+parseFloat(data[x]['card']);
                                totalcheck=totalcheck+parseFloat(data[x]['check']);
                            
                        }
                        
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('<tr><th></th><th style="text-align:right">'+totalcash.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</th><th style="text-align:right">'+totalcard.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</th><th style="text-align:right">'+totalcheck.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</th></tr>');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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
            
            function payment_breakup_sale(){
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                var totalcash=0; var totalcard=0; var totalcheck=0;
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/payment_breakup_sale',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        
                        var hhtml = "<tr><th>WorkDate</th><th style='font-weight:bold; text-align:right'>Cash </th><th style='font-weight:bold; text-align:right'>Card</th><th style='font-weight:bold; text-align:right'>Check</th></tr>";
                        var mhtml = "";
                        
                        for(x=0; x<data.length;x++){
                                
                                mhtml += '<tr>';
                                mhtml += '<td>'+ data[x]['workdate'] +'</td>';
                                mhtml += '<td style="text-align:right">'+ data[x]['cash'] + '</td>';
                                mhtml += '<td class="text-default" style="text-align:right">' + data[x]['card'] + '</td>';
                                mhtml += '<td class="text-success" style="text-align:right">' + data[x]['check'] + '</td>';
                                mhtml += '</tr>';
                                totalcash=totalcash+parseFloat(data[x]['cash']);
                                totalcard=totalcard+parseFloat(data[x]['card']);
                                totalcheck=totalcheck+parseFloat(data[x]['check']);
                            
                        }
                        
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('<tr><th></th><th style="text-align:right">'+totalcash.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</th><th style="text-align:right">'+totalcard.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</th><th style="text-align:right">'+totalcheck.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</th></tr>');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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
            
            function customer_profile(){
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/customer_profile',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        
                        var hhtml = "<tr><th>Name</th><th>Cell</th><th>Card</th><th>Address</th><th>Birthday</th>\n\
                        <th>Anniversary</th><th>Points Earned</th><th>Points Used</th><th>Available Points</th><th>Alerts</th><th>Allergies</th><th>Invoices</th><th>Purchases</th><th>Discount Given</th><th>Credit Given</th></tr>"

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_cell'] + '</td>';
                            mhtml += '<td>' + data[x]['card'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_address'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_birthday'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_anniversary'] + '</td>';
                            mhtml += '<td>' + data[x]['earned'] + '</td>';
                            mhtml += '<td>' + data[x]['used'] + '</td>';
                            mhtml += '<td>' + data[x]['loyalty_points'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_alert'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_allergies'] + '</td>';
                            mhtml += '<td>' + data[x]['invoices'] + '</td>';
                            mhtml += '<td>' + data[x]['Purchases'] + '</td>';
                            mhtml += '<td>' + data[x]['Discounts'] + '</td>';
                            mhtml += '<td>' + data[x]['balance'] + '</td>';
                            mhtml += '</tr>';
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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
            function new_customers(){
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/new_customers',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        
                        var hhtml = "<tr><th>Name</th><th>Cell</th><th>Email</th><th>Address</th><th>Birthday</th><th>Anniversary</th><th>Alerts</th><th>Allergies</th><th>Added</th><th>By</th></tr>"

                        var mhtml = "";
                        var i=0;
                        for (x = 0; x < data.length; x++) {
                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_cell'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_email'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_address'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_birthday'] + '</td>';
                            mhtml += '<td>' + data[x]['anv'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_alert'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_allergies'] + '</td>';
                            //mhtml += '<td>' + data[x]['m'] + '</td>';
                            mhtml += '<td>' + data[x]['created'] + '</td>';
                            mhtml += '<td>' + data[x]['created_by'] + '</td>';
                            mhtml += '</tr>';
                            i++;
                        }
                        //console.log(mhtml);
                        $("#summary").html(i);
                        
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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
            
            
            function returning_customers(){
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/returning_customers',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        
                        var hhtml = "<tr><th>Name</th><th>Invoice Date</th><th>Invoice #</th><th>Cell</th><th>Email</th><th>Address</th><th>Birthday</th><th>Anniversary</th><th>Alerts</th><th>Allergies</th><th>Added</th><th>to</th><th>By</th></tr>";

                        var mhtml = "";
                        var i=0;
                        for (x = 0; x < data.length; x++) {
                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                            mhtml += '<td>' + data[x]['invoice_date'] + '</td>';
                            
                            var res = []; 
                            if(data[x]['invoice_number']){res = data[x]['invoice_number'].split("-")} else {res[2]=''};
                            if(data[x]['invoice_type']=="service"){                            
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existinginvoice/'+ res[2] +'">' +  data[x]['invoice_number'] + '</a></td>';
                            } else {
                                mhtml += '<td><a target="_blank" href="<?php echo base_url();?>existingorderinvoice/'+ res[2] +'">' +  data[x]['invoice_number'] + '</a></td>';
                            }
                            
                            
                            mhtml += '<td>' + data[x]['customer_cell'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_email'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_address'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_birthday'] + '</td>';
                            mhtml += '<td>' + data[x]['anv'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_alert'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_allergies'] + '</td>';
                            //mhtml += '<td>' + data[x]['m'] + '</td>';
                            mhtml += '<td>' + data[x]['created'] + '</td>';
                            mhtml += '<td>' + data[x]['business_name'] + '</td>';
                            mhtml += '<td>' + data[x]['created_by'] + '</td>';
                            mhtml += '</tr>';
                            i++;
                        }
                        //console.log(mhtml);
                        $("#summary").html(i);
                        
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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
            
            function dispatch() {
            
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/dispatch_report',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        
                        var hhtml = "<tr><th>ID</th><th>Product ID</th><th>Product</th><th>Date</th><th>Qty</th><th>Unit Type</th><th>Dispatch Measure</th><th>Measure Unit</th><th>Value</th><th>Dispatched to</th><th>Comment</th><th>Dispatched by</th></tr>"

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            
                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['id_dispatch_note'] + '</td>';
                            mhtml += '<td>' + data[x]['id_business_products'] + '</td>';
                            mhtml += '<td>' + data[x]['Product'] + '</td>';
                           
                            mhtml += '<td>' + data[x]['Date'] + '</td>';
                            mhtml += '<td>' + data[x]['Qty'] + '</td>';
                             mhtml += '<td>' + data[x]['UnitType'] + '</td>';
                            if(parseFloat(data[x]['dispatch_measure'])>0){
                               mhtml += '<td>' + data[x]['dispatch_measure'] + '</td>';
                            }else{
                                mhtml+="<td>"+parseFloat(data[x]['Qty'])*parseFloat(data[x]['qty_per_unit'])+"</td>";
                            }
                            mhtml += '<td>' + data[x]['measure_unit'] + '</td>';
//                          mhtml += '<td class="text-danger" style="font-weight:bold">' + data[x]['ProductCount'] + '</td>';
                            mhtml +='<td>'+ parseFloat(data[x]['batch_amount']) * parseFloat(data[x]['Qty']) + '</td>';
                            mhtml += '<td>' + data[x]['staff_fullname'] + '</td>';
                            mhtml += '<td>' + data[x]['dispatch_comment'] + '</td>';
                            mhtml += '<td>' + data[x]['Created_by'] + '</td>';
                            mhtml += '</tr>';
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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
            
    function dispatch_details(){
        $('#otherview').css('display', 'none');
        $('.atview').css('display', 'none');
        $("#cog").show();
        $.ajax({
            type: 'POST',
            url: 'report_controller/dispatch_details',
            data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {

                var hhtml = "<tr><th>ID</th><th>Product ID</th><th>Product</th><th>Date</th><th>Qty</th><th>Unit Type</th><th>Dispatch Measure</th><th>Measure Unit</th><th>Value</th><th>Dispatched to</th><th>For Client</th><th>Comment</th><th>Dispatched by</th></tr>"

                var mhtml = "";
                for (x = 0; x < data.length; x++) {

                    mhtml += '<tr>';
                    mhtml += '<td>' + data[x]['id_dispatch_note'] + '</td>';
                    mhtml += '<td>' + data[x]['id_business_products'] + '</td>';
                    mhtml += '<td>' + data[x]['Product'] + '</td>';

                    mhtml += '<td>' + data[x]['Date'] + '</td>';
                    mhtml += '<td>' + data[x]['Qty'] + '</td>';
                     mhtml += '<td>' + data[x]['UnitType'] + '</td>';
                    if(parseFloat(data[x]['dispatch_measure'])>0){
                       mhtml += '<td>' + data[x]['dispatch_measure'] + '</td>';
                    }else{
                        mhtml+="<td>"+parseFloat(data[x]['Qty'])*parseFloat(data[x]['qty_per_unit'])+"</td>";
                    }
                    mhtml += '<td>' + data[x]['measure_unit'] + '</td>';
//                          mhtml += '<td class="text-danger" style="font-weight:bold">' + data[x]['ProductCount'] + '</td>';
                    mhtml +='<td>'+ parseFloat(data[x]['batch_amount']) * parseFloat(data[x]['Qty']) + '</td>';
                    mhtml += '<td>' + data[x]['staff_fullname'] + '</td>';
                    mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                    mhtml += '<td>' + data[x]['dispatch_comment'] + '</td>';
                    mhtml += '<td>' + data[x]['Created_by'] + '</td>';
                    mhtml += '</tr>';
                }
                //console.log(mhtml);
                $("#tblreport").dataTable().fnDestroy();
                $("#tblreport thead").html('');
                $("#tblreport tbody").html('');
                $("#tblreport thead").append(hhtml);
                $("#tblreport tbody").append(mhtml);
                $("#tblreport tfoot").html('');

                $.fn.dataTable.moment('DD-MM-YYYY');
                $('#tblreport').DataTable({
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    stateSave: true, fixedHeader: {header: true},
                    dom: "Bfrtlip",
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
    
    function staff_retail_sale_summary(){
                $('#otherview').css('display', 'none');
                $('.atview').css('display', 'none');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'report_controller/staff_retail_sale_summary',
                    data: {startdate: startdate.format('YYYY-MM-DD'), enddate: enddate.format('YYYY-MM-DD')},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        
                        var hhtml = "<tr><th>Staff</th><th>Products</th><th>Quantity</th><th>Paid</th><th>Recovery</th><th>Total</th></tr>"

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            
                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['staff_name'] + '</td>';
                            mhtml += '<td>' + data[x]['Products'] + '</td>';
                            mhtml += '<td>' + data[x]['Quantity'] + '</td>';
                            mhtml += '<td>' + data[x]['Amount'] + '</td>';
                            mhtml += '<td>' + data[x]['Recovery'] + '</td>';
                            mhtml += '<td>' + data[x]['Total'] + '</td>';
                            
                            mhtml += '</tr>';
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('');
                        
                        $.fn.dataTable.moment('DD-MM-YYYY');
                        $('#tblreport').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true, fixedHeader: {header: true},
                            dom: "Bfrtlip",
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
            
    function open_sked(date1) {
        window.location= "<?php echo base_url().'scheduler/'?>" + date1 + "";
        
    }

        </script>
