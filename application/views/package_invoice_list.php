        <div class="wrapper">
            <div class="container">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">Package Invoices</h4>
                    </div>
                </div>
                
                <div class="row" id="divselection">
                    <div class="col-sm-12">
                        <div class="card-box ">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input placeholder="Customer Name or Phone" type="text" class="form-control" id="customer">
                                        </div>
                                        <div class="col-md-3">
                                            <select id="packagetypes" class="form-control">
                                                <option value="select">Package Types</option>
                                                <?php if($packages){ foreach($packages as $package){ ?>
                                                <option value="<?php echo $package->id_package_type; ?>"><?php echo $package->service_type; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-lg-12"> 
                                                    <div id="reportrange" class="form-control">
                                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                        <span>Select Date Range</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" > 
                                                    <button type="button" id="getPackageInvoices" onclick="getPackageInvoices();" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Search</button>
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
                        
                    </div>
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <form action="<?php echo base_url('open_package_invoice'); ?>" method="post" target="_blank">
                                <input type="hidden" name="csrf_test_name" id="consolidate_view_csrf" value=""/>
                                <h4 class="header-title m-t-0 m-b-30">
                                    <button type="submit" onclick="$('#consolidate_view_csrf').val($('#cook').val());" style="display: none;" id="cciBtn" class="pull-right btn btn-warning btn-bordred waves-effect w-md waves-light m-b-5">Create Consolidated Invoice</button>
                                </h4>
                                <div class="clearfix"></div>
                                <br>
                                <table id="tblinvoice" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer</th>
                                            <th>Customer Cell</th>
                                            <th>Type</th>
                                            <th>Category</th>
                                            <th>Invoice Date</th>
                                            <th>Net Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </form>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->
                
                
                
    <script>
        
        var startdate;
        var enddate;
        
        $(document).ready(function() {

            $('#tblinvoice').DataTable({
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                stateSave: true,
                dom: "Bfrtlip",
                    buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans", footer: true}, {
                            extend: "excel",
                            className: "btn-sm btn-warning btn-trans"
                        }, {extend: "pdf", className: "btn-sm btn-purple btn-trans", footer: true}
                    , {extend: "print", className: "btn-sm btn-primary btn-trans", footer: true}],
                    responsive: !0,
                    //"scrollX": true,
            });
            
            $('#reportrange').daterangepicker({
                format: 'MM/DD/YYYY',
                startDate: moment().subtract(29, 'days'),
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

        });
        
        function getPackageInvoices(){
            var packagetype='';
            var customername='';
            $('#tblinvoice tbody').html('');
            if($('#customer').val() === ""){
                customername='';
//                swal({
//                    title: "Customer name or phone number empty",
//                    text: "Please provide customer name or phone number",
//                    type: "warning",
//                    confirmButtonText: 'OK!'
//                });
//                return false;
            }else {customername=$('#customer').val();}
            if($('#packagetypes option:selected').val() === 'select'){
                packagetype='';
//                swal({
//                    title: "Select Type",
//                    text: "Please select a type",
//                    type: "warning",
//                    confirmButtonText: 'OK!'
//                });
//                return false;
            }else{ packagetype=$('#packagetypes option:selected').text();}
            if(startdate === undefined || enddate === undefined){
                swal({
                    title: "Select date range",
                    text: "Please select date range",
                    type: "warning",
                    confirmButtonText: 'OK!'
                });
                return false;
            }
            $.ajax({
                type: 'POST',
                url: 'invoice_controller/get_package_invoices',
                data: {
                    customer : $('#customer').val(),
                    type : packagetype,
                    start : startdate.format('YYYY-MM-DD'),
                    end : enddate.format('YYYY-MM-DD')
                },
                success: function(result) {
                    var data = $.parseJSON(result);
                    //var hhtml = "<tr><th>#</th><th>Customer Name</th><th>Customer Cell</th><th>Category</th><th>Invoice Date</th><th>Net Amount</th><th>Paid Amount</th><th>Balance</th></tr>"
                    var mhtml = "";
                    if(data.length > 0){
                        for (var x = 0; x < data.length; x++) {
                            mhtml += '<tr>';
                            mhtml += '<td><div class=""><label style="width: 100%;" for="checkbox'+data[x]['id_invoice']+'"><input id="checkbox'+data[x]['id_invoice']+'" type="checkbox" name="invoice_ids[]" value="'+data[x]['id_invoice']+'"></label></div></td>';
                            mhtml += '<td>' + data[x]['customer_name'] + '</td>';
                            mhtml += '<td>' + data[x]['customer_cell'] + '</td>';
                            mhtml += '<td>' + data[x]['service_type'] + '</td>';
                            mhtml += '<td>' + data[x]['service_category'] + '</td>';
                            mhtml += '<td>' + data[x]['invoice_date'] + '</td>';
                            mhtml += '<td>' + data[x]['net_amount'] + '</td>';
                            mhtml += '<td>' + data[x]['paid_amount'] + '</td>';
                            mhtml += '<td>' + data[x]['balance'] + '</td>';
                            mhtml += '</tr>';
                        }
                        $("#tblinvoice").dataTable().fnDestroy();
                        $('#tblinvoice tbody').html(mhtml);
                        $('#cciBtn').show();
                        $('#tblinvoice').DataTable({
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            stateSave: true,
                            fixedHeader: {header: true},
                            dom: "Bfrtlip",
                                buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans", footer: true}, {
                                        extend: "excel",
                                        className: "btn-sm btn-warning btn-trans"
                                    }, {extend: "pdf", className: "btn-sm btn-purple btn-trans", footer: true}
                                , {extend: "print", className: "btn-sm btn-primary btn-trans", footer: true}],
                                responsive: !0,
                                //"scrollX": true,
                        });
                    }
                } 
            });
        }
        
        function cancelinvoice(invoiceid, visitid){
            //Warning Message
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this invoice!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-warning',
                confirmButtonText: "Yes, remove it!",
                closeOnConfirm: true
            }, function (){
                $.ajax({
                    type: 'POST',
                    url: 'invoice_controller/cancelinvoice',
                    data: {invoiceid: invoiceid, visitid:visitid},
                    success: function(data) {
                        var result = data.split("|");
                        if (result[0] === "success") {
                            swal("Deleted!", "Your invoice has been removed.", "success");
                            location.reload();
                        } else {
                            swal("Error!", "Invoice was not removed!.", "error");
                        }
                    } 
                });
            });
        }

        function openinvoice(invoiceid){
            $.ajax({
                    type: 'POST',
                    url: 'invoice_controller/openinvoice',
                    data: {invoiceid: invoiceid},
                    success: function(data) {
                        
                    }
                });
        }
    </script>
