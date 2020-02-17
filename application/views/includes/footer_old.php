   <!-- Footer -->
                <footer class="footer text-right">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-6">
                                2016 © SalonPK.
                            </div>
                            <div class="col-xs-6">
                                <ul class="pull-right list-inline m-b-0">
                                    <li>
                                        <a href="#">About</a>
                                    </li>
                                    <li>
                                        <a href="#">Help</a>
                                    </li>
                                    <li>
                                        <a href="#">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- End Footer -->

            </div>
            <!-- end container -->



            <!-- Right Sidebar -->
            <div class="side-bar right-bar">
                <a href="javascript:void(0);" class="right-bar-toggle">
                    <i class="zmdi zmdi-close-circle-o"></i>
                </a>
                <h4 class="">Appointments</h4>
                
                <div class="notification-list nicescroll">
                    <ul class="list-group list-no-border user-list" id="mAppointments">
                       
                    </ul>
                </div>
            </div>
            <!-- /Right-bar -->

        </div>



        <!-- jQuery  -->
        
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/jquery-quicksearch/jquery.quicksearch.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/select2/dist/js/select2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/js/detect.js"></script>
        <script src="<?php echo base_url();?>assets/js/fastclick.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/jquery.json.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.blockUI.js"></script>
        <script src="<?php echo base_url();?>assets/js/waves.js"></script>
        <script src="<?php echo base_url();?>assets/js/wow.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.nicescroll.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.scrollTo.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/fileuploads/js/dropify.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/toastr/toastr.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/moment/moment.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
        
        <!-- XEditable Plugin -->
       
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/pages/jquery.xeditable.js"></script>

        
     	<script src="<?php echo base_url();?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        
        
       <!-- Datatables-->
        <script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/buttons.bootstrap.min.js"></script>
        <!--<script src="<?php echo base_url();?>assets/plugins/datatables/jszip.min.js"></script>-->
        <script src="<?php echo base_url();?>assets/plugins/datatables/pdfmake.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/vfs_fonts.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/buttons.html5.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/buttons.print.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/responsive.bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.scroller.min.js"></script>

         <!-- peity charts -->
        <script src="<?php echo base_url();?>assets/plugins/peity/jquery.peity.min.js"></script>
         
        <!-- KNOB JS -->
        <!--[if IE]>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/jquery-knob/excanvas.js"></script>
        <![endif]-->
        <script src="<?php echo base_url();?>assets/plugins/jquery-knob/jquery.knob.js"></script>

        <!--Morris Chart-->
		<!--<script src="<?php echo base_url();?>assets/plugins/morris/morris.min.js"></script>-->
		<script src="<?php echo base_url();?>assets/plugins/raphael/raphael-min.js"></script>

        <!-- Dashboard init -->
        <!--<script src="<?php echo base_url();?>assets/js/custom.js"></script>-->  
        <!--<script src="<?php echo base_url();?>assets/pages/jquery.dashboard.js"></script>-->
        
        <!-- Validation js (Parsleyjs) -->
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>
        <!-- App js -->
        <script src="<?php echo base_url();?>assets/js/jquery.core.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.app.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
        
        <script>
            $(document).ready(function() {
                 getAppointments();
             });

            function getAppointments() {

                $.ajax({
                    type: 'POST',
                    url: 'appointment_controller/appointments',
                    data: '',
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {

                        var mhtml = '';
                        if (data.length == 0) {
                            mhtml = '<li class="list-group-item"> <a href="#" class="user-list-item"><div class="icon bg-warning"><i class="zmdi zmdi-account"></i></div><div class="user-desc"><span class="name">No Appointments</span><span class="desc">for the day</span><span class="time">0:00</span></div></a></li>';
                        } else {
                            for (x = 0; x < data.length; x++) {

                                mhtml += '<li class="list-group-item"><a href="javascript:void(0)" onclick="getbyid(' + data[x]['customer_id'] + ')" class="user-list-item">';
                                mhtml += '<div class="icon bg-pink"><i class="zmdi zmdi-account"></i></div>';
                                mhtml += '</div><div class="user-desc"><span class="name">' + data[x]['customer_name'] + '</span>';
                                mhtml += '<span class="desc">' + data[x]['appointment_remarks'] + '</span>';
                                mhtml += '<span class="time">' + data[x]['appointment_date_time'] + '</span></div></a></li>';

                            }
                        }
                        $("#mAppointments").html(mhtml);
                    }
                });
            }
        </script> 
    </body>


</html>