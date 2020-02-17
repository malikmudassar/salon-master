        <div class="wrapper">
            <div class="container">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn-group pull-right m-t-15">
                            <button id="btnPBooking" class="btn btn-primary waves-effect waves-light" onclick="open_PBooking();">
                                Add Booking
                            </button>
                        </div>
                        <h4 class="page-title">Bookings</h4>
                    </div>
                </div>
                
                 <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                            <table id="tblbookings" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Package</th>
                                        <th>Booking For</th>
                                        <th>Customer</th>
                                        <th>Customer Cell</th>
<!--                                        <th>Visit ID</th>-->
                                        <th>Visit Date</th>
                                        <th>Advance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $customer=''; $totaladv=0;  $lastid=0; foreach ($bookings as $booking){
                                        $bookingid=$booking['id_bookings']; 
                                        
                                        if($lastid !== $bookingid) {
                                    ?>
                                    <?php if($lastid>0){?>
                                        <tr><td style="border-bottom: 1px solid #888"><?php echo $lastid; ?></td>
                                            <td style="border-bottom: 1px solid #888"></td>
                                            <td style="border-bottom: 1px solid #888"></td>
                                            <td style="border-bottom: 1px solid #888"><?php echo $customer; ?></td>
                                            <td style="border-bottom: 1px solid #888"></td><td style="border-bottom: 1px solid #888"><b>Total Advance:</b></td><td style="border-bottom: 1px solid #888"><b><?php echo $totaladv;?></b></td>
                                            <td style="border-bottom: 1px solid #888"><button type="button" class="btn btn-sm btn-danger waves-effect m-b-5" onclick="cancelVisit(<?php echo $lastid; ?>);" id="btncancelvisit"><i class="ti-close"></i> Cancel</button>
                                            <a target="_blank" href="<?php echo base_url().'ho_print_booking/'.$lastid; ?>" class="btn btn-sm btn-primary waves-effect waves-light m-b-5"> <i class="fa fa-print m-r-5"></i> <span>Print</span> </a>
                                            </td>
                                        </tr>
                                    <?php $totaladv=0;} ?>
                                    
                                    <tr>
                                        <td><?php echo $booking['id_bookings']; ?></td>
                                         <td><?php echo $booking['service_type']; ?></td>
                                         <td><?php echo $booking['service_category']; ?></td>
                                          <td><?php echo $booking['customer_name']; ?></td>
                                        <td><?php 
                                                if( $this->session->userdata('hide_cell') && $this->session->userdata('hide_cell') == "No"){
                                                    $booking['customer_cell'];
                                                } 
                                            ?></td>
                                        <!--<td><?php echo $booking['visit_id']; ?></td>-->
                                        <td><?php echo $booking['visit_date']; ?></td>
                                       
                                        <td><?php echo $booking['advance_amount']; $totaladv=$totaladv+$booking['advance_amount'];?></td>
                                        
                                        <td>
                                            
                                            <button class="btn btn-sm btn-pink m-b-5" onclick="openEdit('<?php echo $booking['visit_id']; ?>')"><i class="ti-pencil"></i></button>
                                            <button onclick='showadvancemodal("<?php echo $booking['visit_id']; ?>");' class='btn btn-warning btn-sm m-b-5' id='btnadvance'><i class="ti-money"></i> Adv.</button>
                                        </td>
                                    </tr>
                                    
                                    <?php $lastid=$bookingid; $customer= $booking['customer_name']; } else { ?> 
                                        <tr>
                                        <td><?php echo $booking['id_bookings']; ?></td>
                                         <td><?php echo $booking['service_type']; ?></td>
                                         <td><?php echo $booking['service_category']; ?></td>
                                          <td><?php echo $booking['customer_name']; ?></td>
                                        <td><?php 
                                                if( $this->session->userdata('hide_cell') && $this->session->userdata('hide_cell') == "No"){
                                                    $booking['customer_cell'];
                                                } 
                                            ?></td>
                                        <!--<td><?php echo $booking['visit_id']; ?></td>-->
                                        <td><?php echo $booking['visit_date']; ?></td>
                                       
                                        
                                       
                                        
                                        <td><?php echo $booking['advance_amount']; $totaladv=$totaladv+$booking['advance_amount'];?></td>
                                        
                                        <td>
                                            
                                            <button class="btn btn-sm btn-pink m-b-5" onclick="openEdit('<?php echo $booking['visit_id']; ?>')"><i class="ti-pencil"></i></button>
                                            <button onclick='showadvancemodal("<?php echo $booking['visit_id']; ?>");' class='btn btn-warning btn-sm m-b-5' id='btnadvance'><i class="ti-money"></i> Adv.</button>
                                        </td>
                                    </tr>

                                    <?php $lastid=$bookingid; $customer= $booking['customer_name']; }}?>
                                    <?php if(isset($booking['id_bookings'])){ ?>
                                    <tr><td style="border-bottom: 1px solid #888"><?php echo $booking['id_bookings']; ?></td>
                                        <td style="border-bottom: 1px solid #888"></td>
                                        <td style="border-bottom: 1px solid #888"></td>
                                        <td style="border-bottom: 1px solid #888"><?php echo $booking['customer_name']; ?></td><td style="border-bottom: 1px solid #888"></td><td style="border-bottom: 1px solid #888"><b>Total Advance:</b></td><td style="border-bottom: 1px solid #888"><b><?php echo $totaladv;?></b></td>
                                        <td style="border-bottom: 1px solid #888"><button type="button" class="btn btn-sm btn-danger waves-effect m-b-5" onclick="cancelVisit(<?php echo $booking['id_bookings']; ?>);" id="btncancelvisit"><i class="ti-close"></i> Cancel</button>
                                            <a target="_blank" href="<?php echo base_url().'ho_print_booking/'.$booking['id_bookings']; ?>" class="btn btn-sm btn-primary waves-effect waves-light m-b-5"> <i class="fa fa-print m-r-5"></i> <span>Print</span> </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Package</th>
                                        <th>Booking For</th>
                                        <th>Customer</th>
                                        <th>Customer Cell</th>
<!--                                        <th>Visit ID</th>-->
                                        <th>Visit Date</th>
                                        <th>Advance</th>
                                        <th>Action</th>
                                        
                                        
                                    </tr>
                                </tfoot>
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
                        <div class="form-inline m-b-10" >
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
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="button" onclick="saveStatus();" class="btn btn-info waves-effect waves-light">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--modal end-->
        
        <!---pick service modal-->
        <?php include 'modals/advance_modal.php'; ?>
        <!-- Pick service modal-->
        
    </div>
      
                
                
    <script type="text/javascript">
        $(document).ready(function() {

        $(".numeric").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 13 && e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });

        $("#visit_service_date").datepicker({
                default: today,
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy-mm-dd'    
            });

             $('#tblbookings').DataTable({
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
                ordering: false
            });
            
        });
        function open_PBooking(){
            window.location.assign('<?php echo base_url();?>ho_booking');
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
                   // console.log(mhtml);
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
           // console.log($(tr).find('td:eq(0)').attr('id'));
            visit_service_id.push($(tr).find('td:eq(0)').attr('id'));
            
        });
        
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>ho_controller/change_visit_services_date',
            data: {customer_visit_id: $("#customer_visit_id").text(), visit_service_ids: visit_service_id, visit_service_date: $("#visit_service_date").val()},
            success: function(data) {
                toastr.success('Visit Updated!', 'Done!');    
                $("#change_appointment_modal").modal("hide");
                 window.location.href='<?php echo base_url(); ?>ho_booking_list';
            }
        });
      
    }
    
    
    function showadvancemodal(visitid){
    var myurl;
        
        myurl = '<?php echo base_url().'pos_controller/getVisitbyid'; ?>';

        $.ajax({
            type: 'POST',
            url: myurl,
            data: {id_customer_visit: visitid},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                console.log(data);
                //$("#txt-customer-search").select2("val", data[0]['customer_name']);
                var mhtml = "";
                var rowcount=1;
                
                var advances=data.advances;
               
                 var totaladvance=0; var ahtml=""; var fhtml="";
                if(advances.length>0){
                    for (x = 0; x < advances.length; x++) {
                        ahtml +='<tr><td>Adv.</td><td>'+ advances[x].date +'</td><td style="text-align:right;">'+ advances[x].advance_amount +'</td><td><button type="button" class="btn btn-sm btn-default" onclick="removeadvance('+ advances[x].id_visit_advance +');" class="text-danger"><i class="ti-close"></i></button></td></tr>';
                        totaladvance= totaladvance+parseFloat(advances[x].advance_amount);
                    }
                    $("#adv_table tbody").html(ahtml);
                    fhtml +='<tr><td></td><td style="font-weight:bold;">Total Advance:</td><td style="font-weight:bold; text-align:right;">'+ totaladvance.toFixed(2) +'</td><td></td></tr>';
                    $("#adv_table tfoot").html(fhtml);
                }else{
                    $("#adv_table tbody").html('');
                    $("#adv_table tfoot").html('');
                }
                
                $("#visitid").val(visitid);
                $("#txtadvance").val(totaladvance);
            }
        });
    
        $("#cc_charge_setting").val($("#cc_charge").val());
        $("#advancemodal").modal("show");
    }
    
    
    function advancemodalclose(){
         window.location.href='<?php echo base_url(); ?>ho_booking_list';
           
    }
    
    
    function cancelVisit(visitid) {
       
        
        swal({
                title: "Are you sure?",
                text: "Give Reason For Cancelling This Booking:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                inputPlaceholder: "reason for cancelling"
              }, function (inputValue) {
                if (inputValue === false) return false;
                if (inputValue === "") {
                  swal.showInputError("You need to write something!");
                  return false
                } 

            $.ajax({
                //url: 'Scheduler_controller/cancelVisit',
                url: "<?php echo base_url() . 'ho_controller/cancelBooking'; ?>",
                //data: 'visitid=' +visitid,
                data: {
                    bookingid: visitid, cancelreason: inputValue
                },
                type: 'POST',
                success: function(response) {



                        swal(
                            'Canceled!',
                            'Booking ' + response + ' has been canceled.',
                            'success'
                            );
                        window.location.href='<?php echo base_url(); ?>ho_booking_list';
                    

                }
            });

        });
    }
    function removeadvance(advanceid){
         $.ajax({
            type: 'POST',
            //url: 'Scheduler_controller/active_staff_list',
            url: "<?php echo base_url() . 'visits_controller/remove_advance'; ?>",
            data:{
                
                advance_id:advanceid
                },
            dataType: "text",
            cache: false,
            async: true,
            success: function(data) {
                if(data === "Advance removed!"){
                    toastr.success(data, 'Done!');
                     window.location.href='<?php echo base_url(); ?>ho_booking_list';
                } else {
                    toastr.error(data);
                }
                
            }
        });
    }
    
    </script>
