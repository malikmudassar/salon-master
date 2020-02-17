<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">

                <h4 class="page-title">Staff Performance:</h4>
            </div>
        </div>

        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <h4 class="header-title m-t-0 m-b-30">Filters:</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">Select Staff</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <select class="form-control" id="staff">
                                                <option value="">select</option>
                                                <?php foreach ($staffs as $staff) { ?>
                                                    <option value="<?php echo $staff['id_staff']; ?>"><?php echo $staff['staff_fullname']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">Customer</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <input  class="form-control" id="customer"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">Select Date</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 

                                            <div id="appointment_date" class="form-control">
                                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">Get Appointments</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" > 
                                            <button type="button" onclick="runreport()" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><i id="cog" class="fa fa-spin fa-cog" style="display:none; font-size:26px;width: auto;margin-right: 10px;"></i></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">

                            <div class="row">
                                <div class="col-lg-12"> <label class="control-label">Select Type</label></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12"> 
                                    <select onchange="servicetypechange();" class="form-control" id="servicetype">
                                        <option value="0">All</option>
                                        <?php foreach ($servicetypes as $servicetype) { ?>
                                            <option flag="<?php echo $servicetype->flag; ?>" value="<?php echo $servicetype->id_service_types; ?>"><?php echo $servicetype->service_type; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">

                            <div class="row">
                                <div class="col-lg-12"> <label class="control-label">Select Category</label></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12"> 

                                    <select onchange="servicecategorychange()" class="form-control" id="servicecategory">

                                    </select>
                                    
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">

                            <div class="row">
                                <div class="col-lg-12"> <label class="control-label">Select Service</label></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12"> 
                                    <select class="form-control" id="service">
                                    </select>
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

                    <table id="tblappointments" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Staff</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Service</th>
                                
                                <th>Date</th>
                                <th>Service Count</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>After Discount</th>
                                <th>Paid</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
    
        <!--modal start-->
        <div class="modal fade none-border" id="change_appointment_modal" tabindex="-1" role="dialog" aria-labelledby="Cash Register" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Update Reminder Status for visit ID:  <span id="customer_visit_id"></span></h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Customer Name</label>
                                        <div class="col-md-10">
                                            <input readonly="readonly" type="text" class="form-control" id="customername">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Customer Cell</label>
                                        <div class="col-md-10">
                                            <input readonly="readonly" type="text" class="form-control" id="customercell">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                   
                                        <label class="col-md-2 control-label">Services</label>
                                        <div class="col-md-10">
                                            <table class="table table-stripped" id="visitservices">
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                   
                                </div>
                            </div>
                        </form>
                        <div class="form-inline" >
                            <div class="form-group m-l-10">
                                <div class="checkbox checkbox-primary">
                                    <input id="reminder_sms" type="checkbox">
                                    <label for="reminder_sms">
                                        SMS
                                    </label>
                                </div>
                            </div>
                            <div class="form-group m-l-10">
                                <div class="checkbox checkbox-primary">
                                    <input id="reminder_email" type="checkbox">
                                    <label for="reminder_email">
                                        Email
                                    </label>
                                </div>
                            </div>
                            <div class="form-group m-l-10">
                                <div class="checkbox checkbox-primary">
                                    <input id="reminder_call" type="checkbox">
                                    <label for="reminder_call">
                                        Call
                                    </label>
                                </div>
                            </div>
                            <div class="form-group m-l-10">
                                
                                <div>
                                    <label for="visit_service_date">
                                       | Change Date
                                    </label>
                                    <input id='visit_service_date' class='form-control'>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="button" onclick="saveStatus();" class="btn btn-info waves-effect waves-light">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--modal end-->
    </div>


    <script>
        var startdate = '';
        var enddate = '';
        $(document).ready(function () {

            
            $("#visit_service_date").datepicker({
                default: today,
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy-mm-dd'    
            });

            $('#appointment_date').daterangepicker({
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
            }, function (start, end, label) {
                //console.log(start.toISOString(), end.toISOString(), label);
                startdate = start;
                enddate = end;
                $('#appointment_date span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });
           
        });

        function runreport() {

            if (startdate == "" || enddate == "") {
                  swal({
                      title: "Select Date Range",
                      text: "Please select a date Range",
                      type: "warning",
                      confirmButtonText: 'OK!'
                  });
                  return false;
              }
            var sdate = '';
            var edate = '';
            if (startdate !== "" || enddate !== "") {
                sdate = startdate.format('YYYY-MM-DD');
                edate = enddate.format('YYYY-MM-DD');
            }

            $("#cog").show();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url();?>appointment_controller/get_staffinvoices',
                data: {startdate: sdate, enddate: edate, id_service_type: $("#servicetype option:selected").val(), service_type: $("#servicetype option:selected").text(), id_service_category: $("#servicecategory option:selected").val(), service_category: $("#servicecategory option:selected").text(), id_business_services: $("#service option:selected").val(), service_name: $("#service option:selected").text(), staff_id: $("#staff option:selected").val(), customer: $("#customer").val()},
                dataType: "json",
                cache: false,
                async: true,
                success: function (data) {
                    var laststaffid = '0'; var servicecount=0; var price=0; var discount_sum=0; var price_sum=0; var paid =0;
                    var mhtml = ""; var mClass="";
                    for (x = 0; x < data.length; x++) {
                        if(laststaffid=='0' || laststaffid == data[x]['staff_name']){
                            mhtml += "<tr>";
                            mhtml +="<td>"+ data[x]['staff_name']+"</td>";
                            mhtml +="<td>"+ data[x]['service_type']+"</td>";
                            mhtml +="<td>"+ data[x]['service_category']+"</td>";
                            mhtml +="<td>"+ data[x]['service_name']+"</td>";

                            mhtml +="<td>"+ data[x]['Date']+"</td>";
                            mhtml +="<td style='text-align:right;'>"+ data[x]['service_count']+"</td>";
                            servicecount=servicecount+parseInt(data[x]['service_count']);
                            mhtml +="<td style='text-align:right;'>"+ data[x]['price']+"</td>";
                             price=price+parseInt(data[x]['price']);
                            mhtml +="<td style='text-align:right;'>"+ data[x]['discount_sum']+"</td>";
                            discount_sum=discount_sum+parseInt(data[x]['discount_sum']);
                            mhtml +="<td style='text-align:right;'>"+ data[x]['price_sum']+"</td>";
                            price_sum=price_sum+parseInt(data[x]['price_sum']);
                            mhtml +="<td style='text-align:right;'>"+ data[x]['paid']+"</td>";
                            paid=paid+parseInt(data[x]['paid']);
                            mhtml +="</tr>";
                            laststaffid=data[x]['staff_name'];
                        } else {
                            mhtml+="<tr style='background-color:#e8e8e8  !important;  font-weight:bold !important'><td>Total services of "+laststaffid+"</td><td></td><td></td><td></td><td></td><td style='text-align:right;'>"+ servicecount +"</td><td style='text-align:right;'>"+ price +"</td><td style='text-align:right;'>"+ discount_sum +"</td><td style='text-align:right;'>"+ price_sum +"</td><td style='text-align:right;'>"+ paid +"</td>";
                            servicecount=0; price=0; discount_sum=0; price_sum=0; paid=0;
                            mhtml += "<tr>";
                            mhtml +="<td>"+ data[x]['staff_name']+"</td>";
                            mhtml +="<td>"+ data[x]['service_type']+"</td>";
                            mhtml +="<td>"+ data[x]['service_category']+"</td>";
                            mhtml +="<td>"+ data[x]['service_name']+"</td>";

                            mhtml +="<td>"+ data[x]['Date']+"</td>";
                            mhtml +="<td style='text-align:right;'>"+ data[x]['service_count']+"</td>";
                            servicecount=servicecount+parseInt(data[x]['service_count']);
                            mhtml +="<td style='text-align:right;'>"+ data[x]['price']+"</td>";
                             price=price+parseInt(data[x]['price']);
                            mhtml +="<td style='text-align:right;'>"+ data[x]['discount_sum']+"</td>";
                            discount_sum=discount_sum+parseInt(data[x]['discount_sum']);
                            mhtml +="<td style='text-align:right;'>"+ data[x]['price_sum']+"</td>";
                            price_sum=price_sum+parseInt(data[x]['price_sum']);
                            mhtml +="<td style='text-align:right;'>"+ data[x]['paid']+"</td>";
                            paid=paid+parseInt(data[x]['paid']);
                            mhtml +="</tr>";
                            laststaffid=data[x]['staff_name'];
                        }
                        
                    }
                    mhtml+="<tr style='background-color:#e8e8e8  !important;  font-weight:bold !important'><td>Total services of "+laststaffid+"</td><td></td><td></td><td></td><td></td><td style='text-align:right;'>"+ servicecount +"</td><td style='text-align:right;'>"+ price +"</td><td style='text-align:right;'>"+ discount_sum +"</td><td style='text-align:right;'>"+ price_sum +"</td><td style='text-align:right;'>"+ paid +"</td>";
                    $("#tblappointments").dataTable().fnDestroy();
                    $("#tblappointments tbody").html('');
                    $("#tblappointments tbody").append(mhtml);
                    
                    $.fn.dataTable.moment('DD-MM-YYYY');
                    $('#tblappointments').DataTable({
                        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        stateSave: true,
                        ordering: false,
                        fixedHeader: {header: true},
                        dom: "Bfrtlip",
                        buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                                extend: "excel",
                                className: "btn-sm"
                            }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
                        responsive: !0,
                        order: [[ 0, "asc" ],[1,"asc"]]
                    });
                    $("#cog").hide();
                }
            });
            $("#cog").show();
        }

        function servicetypechange() {
            $("#servicecategory").empty();
            $("#service").empty();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url();?>service_controller/getServicesCategories',
                data: {service_type_id: $("#servicetype option:selected").val(), flag: $("#servicetype option:selected").attr("flag")},
                dataType: "json",
                cache: false,
                async: true,
                success: function (data) {
                    var html = "<option value='0'>All</option>";

                    for (x = 0; x < data.length; x++) {
                        html += "<option value='" + data[x]['id_service_category'] + "' flag='" + data[x]['flag'] + "' '>" + data[x]['service_category'] + "</option>";
                    }

                    $("#servicecategory").append(html);
                }
            });
        }

        function servicecategorychange() {
            $("#service").empty();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url();?>service_controller/getServicesByCategory',
                data: {id_service_category: $("#servicecategory option:selected").val(), flag: $("#servicecategory option:selected").attr("flag")},
                dataType: "json",
                cache: false,
                async: true,
                success: function (data) {
                    var html = "<option value='0'>All</option>";

                    for (x = 0; x < data.length; x++) {
                        html += "<option value='" + data[x]['id_business_services'] + "'>" + data[x]['service_name'] + "</option>";
                    }

                    $("#service").append(html);
                }
            });
        }

        function openEdit(visit_id){
            $("#customer_visit_id").text(visit_id);
            $("#visitservices tbody").empty();
            
            
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url();?>appointment_controller/get_appointment',
                data: {id_customer_visit: visit_id},
                dataType: "json",
                cache: false,
                async: true,
                success: function (data) {
                    $("#customername").val(data[0]['customer_name']);
                    $("#customercell").val(data[0]['customer_cell']);
                    
                    if(data[0]['reminder_sms']=="Y"){$('#reminder_sms').prop( "checked", true );
                    } else {$('#reminder_sms').prop( "checked", false);}
                    if(data[0]['reminder_email']=="Y"){$('#reminder_email').prop( "checked", true );
                    } else {$('#reminder_email').prop( "checked", false);}
                    if(data[0]['reminder_call']=="Y"){$('#reminder_call').prop( "checked", true );
                    } else {$('#reminder_call').prop( "checked", false);}
                    
                    mhtml = "";
                    for (x = 0; x < data.length; x++) {
                        mhtml+="<tr>";
                        mhtml+="<td class='id_visit_service' id='" + data[x]['id_visit_services'] + "'>"+data[x]['visit_service_start']+"</td>";
                        mhtml+="<td>"+data[x]['service_type']+"</td>";
                        mhtml+="<td>"+data[x]['service_category']+"</td>";
                        mhtml+="<td>"+data[x]['service_name']+"</td>";
                        mhtml+="<td>"+data[x]['staff_name']+"</td>";
                        
                        mhtml+="</tr>";
                    }
                    console.log(mhtml);
                    $("#visitservices tbody").append(mhtml);
                }
            });
                
            
            $("#cog").hide();
            
            $("#change_appointment_modal").modal("show");
        }
        
        function saveStatus(){
            var reminder_sms="N";        var reminder_email="N";        var reminder_call="N";
            if( $('#reminder_sms').is(':checked') ){reminder_sms = 'Y';}
            if( $('#reminder_email').is(':checked') ){reminder_email = 'Y';}
            if( $('#reminder_call').is(':checked') ){reminder_call = 'Y';}
        
            
            $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>visits_controller/reminder_message_update',
                    data: {customer_visit_id: $("#customer_visit_id").text(), reminder_sms: reminder_sms, reminder_email: reminder_email, reminder_call: reminder_call},
                    success: function(data) {
                       if($('#visit_service_date').val()!==''){
                            
                            update_visit_date();
                            
                        } else {
                            toastr.success('Visit Updated!', 'Done!');    
                            $("#change_appointment_modal").modal("hide");
                        }
                    }
            });
            
            
            
        }
       
   
       
    function update_visit_date(){
        
        var visit_service_id=[];
        var visit_service_olddate=[];
        
        $('#visitservices tr').each(function(row, tr) {
            console.log($(tr).find('td:eq(0)').attr('id'));
            visit_service_id.push($(tr).find('td:eq(0)').attr('id'));
            
        });
        
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>scheduler_controller/change_visit_services_date',
            data: {visit_service_ids: visit_service_id, visit_service_date: $("#visit_service_date").val()},
            success: function(data) {
                toastr.success('Visit Updated!', 'Done!');    
                $("#change_appointment_modal").modal("hide");
                runreport();
            }
        });
      
    }
      
    </script>
