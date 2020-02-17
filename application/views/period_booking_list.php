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
                                        <th>Visit ID</th>
                                        <th>Visit Date</th>
                                        <th>Booking For</th>
                                        <th>Customer</th>
                                        <th>Customer Cell</th>
                                        <th>Type</th>
                                        <?php if($this->session->userdata('role')!=="Sh-Users"){?>
                                        <th>Advance</th>
                                        <th>Payment Mode</th>
                                        <?php } ?>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $lastid=0; foreach ($bookings as $booking){ $visitid=$booking['visit_id']; 
                                        if($lastid !== $visitid) {
                                    ?>
                                    <tr>
                                        <td><?php echo $booking['visit_id']; ?></td>
                                        <td><?php echo $booking['visit_date']; ?></td>
                                        <td><?php echo $booking['service_type']; ?></td>
                                        <td><?php echo $booking['customer_name']; ?></td>
                                        <td><?php 
                                                if( $this->session->userdata('hide_cell') && $this->session->userdata('hide_cell') == "No"){
                                                    $booking['customer_cell'];
                                                } 
                                            ?></td>
                                        <td><?php echo $booking['customer_email']; ?></td>
                                         <?php if($this->session->userdata('role')!=="Sh-Users"){?>
                                        <td><?php echo $booking['advance_amount']; ?></td>                                         
                                        <td><?php echo $booking['advance_mode']; ?></td>
                                        <?php } ?>
                                        <td>
                                            <a target="_blank" href="<?php echo base_url().'print_booking/'.$booking['visit_id']; ?>" class="btn btn-primary waves-effect waves-light m-b-5"> <i class="fa fa-print m-r-5"></i> <span>Open</span> </a>
                                        </td>
                                    </tr>
                                    
                                    <?php $lastid=$visitid; }} ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                         <?php if($this->session->userdata('role')!=="Sh-Users"){?>
                                        <th></th>
                                        <th></th>
                                        <?php } ?>
                                        <th></th>
                                        
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->
            </div>
      
                
                
    <script type="text/javascript">
        $(document).ready(function() {

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
            });
            
        });
        function open_PBooking(){
             <?php if($this->session->userdata('role')=="Sh-Users"){?>
                window.location.assign('<?php echo base_url();?>sh_period_booking');     
             <?php } else { ?>
                window.location.assign('<?php echo base_url();?>period_booking');
             <?php } ?>
        }
    </script>
