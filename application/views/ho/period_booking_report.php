        <div class="wrapper">
            <div class="container">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class=" pull-right m-t-15">
                            <form method="POST" action='<?php echo base_url();?>ho_booking_report' id="submit_form">
                                <input type="hidden" name="csrf_test_name" id="booking_list_csrf" value=""/>
                                <div class="col-md-4">

                                    <select class="form-control inline m-r-5"  name="staff" id="staff">
                                        <option value="All">All</option>
                                        <?php foreach($users as $user){ ?>
                                        <option <?php if($selecteduser == $user['user_name']){ echo "selected: selected";} ?> value="<?php echo $user['user_name']; ?>"><?php echo $user['user_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">

                                    <input type="text" class="form-control inline datepicker-autoclose m-r-5"  placeholder="mm/dd/yyyy" name="start" id="start_date"  <?php if(isset($start)){echo "value=".$start;} ?> >

                                </div>
                                <div class="col-md-2">

                                    <input type="text" class="form-control inline datepicker-autoclose m-r-5"  placeholder="mm/dd/yyyy" name="end" id="end_date" <?php if(isset($end)){echo "value=".$end;} ?>>

                                </div>
                                <div class="col-md-2">
                                    <button type='button' onclick="$('#booking_list_csrf').val($('#cook').val()); run_report();" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button>
                                </div>
                            </form>
                        </div>
                        <h4 class="page-title">Booking Listing</h4>
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
                                        <th>Customer</th>
                                        <th>Customer Cell</th>
                                        <th>Booking Date</th>
                                        <th>Visit Date</th>
                                        <th>Referring Staff</th>
                                        <th>Package</th>
                                        <th>Price</th>
                                        <th>Advance</th>
                                        <th>Booked By</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bookings as $booking){?>
                                    <tr>
                                        <td><?php echo $booking['id_bookings']; ?></td>
                                        <td><?php echo $booking['customer_name']; ?></td>
                                        <td><?php echo $booking['customer_cell']; ?></td>
                                        <td><?php echo $booking['booking_date']; ?></td>
                                        <td><?php echo $booking['visit_date']; ?></td>
                                        <td><?php echo $booking['referring_staff']; ?></td>
                                        <td><?php echo $booking['service_category']; ?></td>
                                        <td><?php echo $booking['Total']; ?></td>
                                        <td><?php echo $booking['advance']; ?></td>
                                        <td><?php echo $booking['created_by']; ?></td>
                                        <td><?php echo $booking['visit_status']; ?></td>
                                        <td style="border-bottom: 1px solid #888">
                                            <!--<button type="button" class="btn btn-sm btn-danger waves-effect m-b-5" onclick="cancelVisit(<?php echo $booking['id_bookings']; ?>);" id="btncancelvisit"><i class="ti-close"></i> Cancel</button>-->
                                            <a target="_blank" href="<?php echo base_url().'ho_print_booking/'.$booking['id_bookings']; ?>" class="btn btn-sm btn-primary waves-effect waves-light m-b-5"> <i class="fa fa-print m-r-5"></i> <span>Print</span> </a>
                                        </td>
                                    </tr>
                                    
                                    <?php } ?>
                                   
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Customer</th>
                                        <th>Customer Cell</th>
                                        <th>Booking Date</th>
                                        <th>Visit Date</th>
                                        <th>Referring Staff</th>
                                        <th>Package</th>
                                        <th>Price</th>
                                        <th>Advance</th>
                                        <th>Booked By</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->
                
             
        
    </div>
      
            <style>
                .datepicker{top:190px!important}
            </style>            
                
    <script type="text/javascript">
        $(document).ready(function() {
             $('.datepicker-autoclose').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            });
        $(".numeric").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 13 && e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
        
        


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
        
  
    
    function run_report(){
        $('#submit_form').submit();
        
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
    
    </script>
