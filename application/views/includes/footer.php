
   <!-- Footer -->
                <footer class="footer text-right hidden">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-6">
                                2016-17 Â© SkedWise.
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
            <div class="side-bar right-bar" style="display: none;">
                <a href="javascript:void(0);" class="right-bar-toggle">
                    <i class="zmdi zmdi-close-circle-o"></i>
                </a>
                <h4 class=""><i class="zmdi zmdi-cake"></i> Birthdays</h4>
                
                <div class="notification-list nicescroll" style="padding: 0px 5px;">
                    
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#today" aria-controls="today" role="tab" data-toggle="tab">Today</a></li>
                        <li role="presentation"><a href="#tomorrow" aria-controls="tomorrow" role="tab" data-toggle="tab">Tomorrow</a></li>
                    </ul>
                    
                    <div class="tab-content" style="border: none; padding: 5px 0px;">
                        <div role="tabpanel" class="tab-pane active" id="today">
                            <ul class="list-group list-no-border user-list" id="todayBirthdays"></ul>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="tomorrow">
                            <ul class="list-group list-no-border user-list" id="tomorrowBirthdays"></ul>
                        </div>
                    </div>
                    
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
        <script src="<?php echo base_url(); ?>assets/js/jquery.maskedinput-1.3.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.json.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.blockUI.js"></script>
        <script src="<?php echo base_url();?>assets/js/waves.js"></script>
        <script src="<?php echo base_url();?>assets/js/wow.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.nicescroll.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.scrollTo.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/fileuploads/js/dropify.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap-sweetalert/sweetalert-1/sweet-alert.min.js"></script>
        <!--<script src="<?php echo base_url();?>assets/plugins/bootstrap-sweetalert/sweetalert-2/sweetalert2.min.js"></script>-->
        <script src="<?php echo base_url();?>assets/plugins/toastr/toastr.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
        
        <script src="<?php echo base_url();?>assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
        
        <!-- XEditable Plugin -->
        <!--<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js"></script>-->
        <!--<script type="text/javascript" src="<?php echo base_url();?>assets/pages/jquery.xeditable.js"></script>-->

        <script src="<?php echo base_url();?>assets/plugins/moment/moment.min.js"></script>
     	<script src="<?php echo base_url();?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        
        <?php if(isset($calendar)){?>
        <script src='<?php echo base_url(); ?>assets/plugins/fullcalendar/dist/fullcalendar.min.js'></script>
        <script src='<?php echo base_url(); ?>assets/plugins/fullcalendar/dist/scheduler.min.js'></script>
        <?php } ?>
        
        <?php if(!isset($nodatatable)){?>
        <!-- Datatables-->
        <script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/plug-ins/1.10.16/sorting/datetime-moment.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/buttons.bootstrap.min.js"></script>
        <!--<script src="<?php echo base_url();?>assets/plugins/datatables/jszip.min.js"></script>-->
        <!--<script src="<?php echo base_url();?>assets/plugins/datatables/pdfmake.min.js"></script>-->
        <!--<script src="<?php echo base_url();?>assets/plugins/datatables/vfs_fonts.js"></script>-->
        <script src="<?php echo base_url();?>assets/plugins/datatables/buttons.html5.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/buttons.print.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/responsive.bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.scroller.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.rowGroup.min.js"></script>
        <?php } ?>
        
        <?php if(isset($chart)){?>
         <!-- peity charts -->
        <script src="<?php echo base_url();?>assets/plugins/peity/jquery.peity.min.js"></script>
         
        <!-- KNOB JS -->
        <!--[if IE]>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/jquery-knob/excanvas.js"></script>
        <![endif]-->
        <script src="<?php echo base_url();?>assets/plugins/jquery-knob/jquery.knob.js"></script>
        
        <!--Morris Chart-->
        
        <script src="<?php echo base_url();?>assets/plugins/highcharts/highcharts.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/highcharts/modules/exporting.js"></script>        
        
        <?php } ?>
        <script src="<?php echo base_url(); ?>assets/plugins/searcher/jquery.searcher.js"></script>
        <!-- Validation js (Parsleyjs) -->
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>
        <!-- App js -->
        <script src="<?php echo base_url();?>assets/js/jquery.core.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.app.js"></script>
        
        <script src="<?php echo base_url();?>assets/plugins/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
        
        <script>
            
            $(document).ready(function() {

               //getCustomerBirthdays();
            });
           function update_csrf(){ 
                $.get("welcome/update_csrf", function(data) {
                    $("#cook").val(data['csrf_hash']);
                });
            }
            
            function getCustomerBirthdays(){
                //update_csrf();
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url(); ?>Customer_controller/getCustomerBirthdays',
                  
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(response) {
                        //$("#cook").val(response['csrf_hash']);
                        var data = response;
                        
                        var mhtml_1 = '';
                        var mhtml_2 = '';
                        
                        if(data['today_birthdays'].length === 0){
                            mhtml_1 = '<li class="list-group-item"><a href="#" class="user-list-item"><div class="icon bg-warning"><i class="zmdi zmdi-cake"></i></div><div class="user-desc"><span class="name">Birthday</span><span class="desc">Today there is no birthday</span></div></a></li>';
                        } else{
                            for(var x=0; x < data['today_birthdays'].length; x++){
                                mhtml_1 += '<li class="list-group-item"><a target="_blank" href="<?php echo base_url(); ?>customer_previous_visit/' + data['today_birthdays'][x]['id_customers'] + '" class="user-list-item">';
                                mhtml_1 += '<div class="icon bg-pink"><i class="zmdi zmdi-cake"></i></div>';
                                mhtml_1 += '</div><div class="user-desc"><span class="name">' + data['today_birthdays'][x]['customer_name'] + '</span>';
                                mhtml_1 += '<span class="desc">cell # ' + data['today_birthdays'][x]['customer_cell'] + '</span>';
                                mhtml_1 += '<span class="time">' + data['today_birthdays'][x]['customer_email'] + '</span></div></a></li>';
                            }
                        }
                        
                        if(data['tomorrow_birthdays'].length === 0){
                            mhtml_2 = '<li class="list-group-item"><a href="#" class="user-list-item"><div class="icon bg-warning"><i class="zmdi zmdi-cake"></i></div><div class="user-desc"><span class="name">Birthday</span><span class="desc">Tomorrow there is no birthday</span></div></a></li>';
                        } else{
                            for(var x=0; x < data['tomorrow_birthdays'].length; x++){
                                mhtml_2 += '<li class="list-group-item"><a target="_blank" href="<?php echo base_url(); ?>customer_previous_visit/' + data['tomorrow_birthdays'][x]['id_customers'] + '" class="user-list-item">';
                                mhtml_2 += '<div class="icon bg-pink"><i class="zmdi zmdi-cake"></i></div>';
                                mhtml_2 += '</div><div class="user-desc"><span class="name">' + data['tomorrow_birthdays'][x]['customer_name'] + '</span>';
                                mhtml_2 += '<span class="desc">cell # ' + data['tomorrow_birthdays'][x]['customer_cell'] + '</span>';
                                mhtml_2 += '<span class="time">' + data['tomorrow_birthdays'][x]['customer_email'] + '</span></div></a></li>';
                            }
                        }
                        
                        $("#todayBirthdays").html(mhtml_1);
                        $("#tomorrowBirthdays").html(mhtml_2);
                        
                    }
                    
                });
                
            }

            function ucwords(str) {
                return str.replace(/(?:^|\s)\w/g, function(match) {
                    return match.toUpperCase();
                });
            }
            
            function validateVoucher(){
        
                if($('#voucher-number').val() === ""){
                    return false;
                } else{
                    var voucherno = 'C'+$('#voucher-number').val();

                    $.ajax({
                        type: 'POST',
                        url: 'Voucher_controller/validateVoucher',
                        data: {
                            voucherno: voucherno
                        },
                        success: function(response) {
                            var data = $.parseJSON(response);
                            if(data.length > 0){
                                var html = '<table class="table">';
                                    html += '<thead>';
                                        html += '<tr><th colspan="3">Customer Details</th></tr>';
                                    html += '</thead>';
                                    html += '<tbody>';
                                        html += '<tr><td>Customer Name</td><td>'+data[0]['customer_name']+'</td></tr>';
                                        html += '<tr><td>Customer Email</td><td>'+data[0]['customer_email']+'</td></tr>';
                                        html += '<tr><td>Customer Phone</td><td>'+data[0]['customer_cell']+'</td></tr>';
                                    html += '</tbody>';
                                    html += '<thead>';
                                        html += '<tr><th colspan="3">Voucher Details</th></tr>';
                                    html += '</thead>';
                                    html += '<tbody>';
                                        html += '<tr><td>Type</td><td>'+data[0]['type'].toUpperCase()+'</td></tr>';
                                        html += '<tr><td>Generated on</td><td>'+data[0]['voucher_date']+'</td></tr>';
                                        html += '<tr><td>Expire on</td><td>'+data[0]['valid_until']+'</td></tr>';
                                        html += '<tr><td>Voucher #</td><td>'+data[0]['voucher_number']+'</td></tr>';

                                        if(data[0]['type'] === 'amount'){
                                            html += '<tr><td>Total Amount Rs.</td><td>'+data[0]['amount']+'</td></tr>';
                                            html += '<tr><td>Remaining Amount Rs.</td><td>'+data[0]['remaining_amount']+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 11px;">(This amount will be applied to the invoice)</span></td></tr>';
                                        }
                                        if(data[0]['type'] === 'service'){
                                            html += '<tr><td>Services: </td><td>'+data[0]['service_names'].replace(/\|/g, '<div style="border-bottom: 1px solid #eee;"></div>')+'</td></tr>';
                                        }

                                        html += '<tr><td></td><td></td></tr>';
                                    html += '</tbody>';
                                html += '</table>';
                                
                                html += '<a href="<?php echo base_url(); ?>viewvoucher/'+data[0]['id_order_vouchers']+'" target="_blank" class="btn btn-default waves-effect waves-light">Print Preview</a>';
                                
                                $('#voucherHtml').html(html);
                                $('#voucherHtml').fadeIn();

                            } else{
                                swal({
                                    title: 'Not Found / Expired',
                                    text: 'The provided voucher number '+voucherno+' is not found or expired.',
                                    type: 'error',
                                    confirmButtonText: 'OK!'
                                });
                            }
                        }
                    });
                }

            }
            
            
            function b_switch(){
                $.ajax({
                    type: 'POST',
                    url: 'welcome/switch_b',
                    data: {
                        business_id: <?php echo $this->session->userdata('businessid'); ?>
                    },
                             dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                       // console.log(data.length)
                        $("#modalbusinesslist").html('');
                        if(data.length > 0){
                            var chtml ='';
                            for(x=0; x<data.length;x++){
                               chtml+='<li onclick="submit_business('+data[x]['id_business']+',\''+data[x]['business_name']+'\');"><img src="<?php echo base_url();?>assets/images/business/'+data[x]['business_logo']+'" alt=""> '+ data[x]['business_name']+'</li>';
                            }
                            //console.log(chtml);
                            $("#modalbusinesslist").html(chtml);
                            $("#businessmodal").modal("show");
                        }
                    }
                });
            }
            
            function submit_business(id_business, business_name){
                $('#openagain_csrf').val($('#cook').val());
                $('#id_business').val(id_business);
                $('#business_name').val(business_name);
                
                $("#openagain").submit();
            }
        </script>
        
         <!--Verify Voucher Model-->
        <div id="verifyVoucherModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="verifyVoucherModal" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Verify Voucher</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn waves-effect btn-inverse waves-light" disabled="true">C</button>
                                    </span>
                                    <input type="text" id="voucher-number" name="voucher-number" class="form-control" placeholder="Voucher # e.g. 123">
                                    <span class="input-group-btn">
                                        <button id="btn-voucher-number" onclick="validateVoucher();" class="btn waves-effect waves-light btn-pink"><i class="fa fa-search"></i></button>
                                    </span>
                                </div><br><br>
                                <div class="" id="voucherHtml">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Verify Voucher Model-->
         <!---pick business modal-->
        <?php include 'pick_business_modal.php'; ?>
        <!-- Pick business modal-->
    </body>
</html>
