<div class="wrapper" >
    <div class="container" style="width: 100% !important">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                
                <div class="btn-group pull-right m-t-15">
                    <input type="hidden" id="userrole" value="<?php echo $this->session->userdata('role');?>" />
                    <input type="hidden" id="show_reg" value="<?php echo $scheduler_style[0]['show_cash_reg'];?>"/>
                    <input type="hidden" id="show_previous" value="<?php echo $time->previous;?>"/>
                    
                    <a href="<?php echo base_url();?>attendance" id="btnAttendance" class="btn btn-purple waves-effect waves-light m-r-10">Attendance</a>
                    
                    <?php if($scheduler_style[0]['show_cash_reg']=='Yes'  || $this->session->userdata('role')=='Admin' || $this->session->userdata('role')=='Super User' ){?>
                    <?php if( $this->session->userdata('role')!=='Sh-Users'){?>
                    <button id="btnCashRegister" class="btn btn-warning waves-effect waves-light">Cash Register</button>
                    <?php } ?>
                    <?php } ?>
                    <button id="btnGiftVoucher" class="btn btn-pink waves-effect waves-light">Voucher</button>
                    <button id="btnRetail" class="btn btn-custom waves-effect waves-light">Retail</button>
                    
                    <button id="btnPBooking" class="btn btn-default waves-effect waves-light" style="display:<?php if(isset($scheduler_style[0]['period_booking'])){if($scheduler_style[0]['period_booking']  === 'Y'){ echo "inline";}else{echo "none";}}else{echo "none";} ?>">
                        Booking
                    </button>
                    <?php if(isset($scheduler_style[0]['pos_enabled']) && $scheduler_style[0]['pos_enabled']=="Yes"){ ?>
                        <a href="<?php echo base_url('pos_services_view');?>" target="_blank" id="btnPOS" class="btn btn-primary waves-effect waves-light">POS</a>
                    <?php } ?>
                    
                </div>
                <?php if( $this->session->userdata('role')!=='Sh-Users'){?>
                <h4 class="page-title">Total Services: <span id="totalvisits" class="page-title"></span></h4>
                <?php } else { ?>
                <h4 class="page-title">Scheduler</h4>
                 <?php } ?>
            </div>
        </div>


        <div class="row" id="mCardbox" >
            
            <div class="col-lg-12">


                <div class="card-box" style="position: relative;">
                    
                    <div class="pull-right " style="margin-left: 6px;" data-toggle="tooltip" data-placement="top">
                        
                        <?php if( $this->session->userdata('role')=="Sh-Users"){?>
                        <form method="post" style="display: inline-block;" action="<?php echo base_url();?>sh_scheduler">
                        <?php }else{?>
                        <form method="post" style="display: inline-block;" action="<?php echo base_url();?>scheduler">
                        <?php }?>
                            <input type="hidden" class="open_csrf" name="csrf_test_name" value="">
                            <div style="display: inline-block; width: 160px; height:28px; "  class="input-group">
                                <input name="defaultDate" style="width:120px; height:28px" class="form-control" type="text" placeholder="mm/dd/yyyy" id="datepicker">
                                <button type="submit" style="display: inline !important; height:28px;" onclick="$('.open_csrf').val($('#cook').val());" class="fc-button fc-state-default fc-corner-left fc-corner-right">go</button>
                            </div>
                        </form>
                        <a data-toggle="tooltip" data-placement="top" data-original-title="Refresh" href="javascript:void(0);" onclick="$('#calendar').fullCalendar('refetchEvents');" class="card-drop">
                            <i class="zmdi zmdi-refresh"></i>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" data-original-title="Fullscreen" href="javascript:max();" class="card-drop">
                            <i class="zmdi zmdi-fullscreen"></i>
                        </a>
                         <?php if($pages>1){?>
                        <form method="post" action="<?php echo base_url();?>scheduler">
                            <input type="hidden" class="open_csrf" name="csrf_test_name" value="">
                            <div style="display: inline-block; width: 160px; height:28px; "  class="input-group">
                                <input name="defaultDate" style="width:120px; height:28px" class="form-control" type="hidden" placeholder="mm/dd/yyyy" id="pagedate">
                                <select class="form-control" name="off_set" style="width:120px; height:30px; line-height: 30px; font-size:11px;">
                                    <?php $x=1; $y=0; while($x <= $pages){?>
                                    <option <?php if($off_set==$y){echo "selected='selected'";} ?> value="<?php echo $y;?>"><?php echo 'page '.$x; ?> </option>
                                    <?php $x++;+$y=$y+$limit;} ?>
                                </select>
                                <button type="submit" style="display: inline !important; height:30px;" onclick="$('.open_csrf').val($('#cook').val()); $('#pagedate').val($('#calendar').fullCalendar('getDate'));" class="fc-button fc-state-default fc-corner-left fc-corner-right">go</button>
                            </div>
                        </form>
                        <?php } ?>
                        
                    </div>


                    <input type="hidden" id="last_update_date">
                    <input type="hidden" id="new_update_date">
                    <input type="hidden" id="last_color_code">
                    <div id="calendar" style=""></div>
                    <div id="calendarOverlay" style="display: none; position: absolute; top: 20px; left: 20px; z-index: 5; background: #fff; opacity: 0.6; text-align: center;">
                        <img style="height: 50px; margin-top: 100px;" src="<?php echo base_url() . 'assets/images/spin-pink.gif'; ?>">
                    </div>
                    <div class="clearfix"></div>
                </div>



                <!--Event View Model-->
                <?php include 'modals/event_view_modal.php'; ?>
                <!--END Event View Model-->

                <!--Cash View Model-->
                <?php include 'modals/cash_modal.php'; ?>
                <!--END Cash View Model-->

                <!-- VISITOR MODAL -->
                <?php //include 'modals/visitor_modal.php'; ?>
                <?php include 'modals/scheduler_modal.php'; ?>
                <!-- END VISITOR MODAL -->

                <!--Retail Model-->
                <?php //include 'modals/retail_modal.php'; ?>
                <!--End Retail Model-->

                <!--Staff Reporting Model-->
                <?php include 'modals/staff_reporting_modal.php'; ?>
                <!--End Staff Reporting Model-->

                <!--Invoice Button Model-->
                <?php include 'modals/invoice_button_modal.php'; ?>
                <!--End Invoice Button Model-->
                
                <!--Block Staff Model-->
                <?php include 'modals/block_staff_modal.php'; ?>
                <!--End Block Staff Model-->

            </div>
            <!-- end col-12 -->
        </div> <!-- end row -->

    </div>

    <?php
    $hours = array();
    $halfs = array();

    for ($i = 0; $i < 23; $i++) {
        $number = strlen($i) > 1 ? $i : '0'.$i;
        $hours[] = $number . ":00:00";
        $halfs[] = $number . ":30:00";
    }
//print_r($hours);
    ?>

    <style>

        <?php foreach ($hours as $hour) { ?>
            .fc-time-grid .fc-slats tr[data-time|='<?php echo $hour; ?>'] .fc-widget-content{
                border-top: 1px solid #797979;
                /*            background: #f1f1f1;*/
/*                padding:5px;*/
            }
            .fc-time-grid .fc-slats tr>td{
                height: 2em;

            }
        <?php } ?>

        .event-invoiced{
            cursor: pointer;
        }
        
        .fc-time-grid-event .fc-title {
                padding: 2px 2px;

        }
        .fc-time-grid .fc-event, .fc-time-grid .fc-bgevent{
            margin: 5px;
        }

        <?php foreach ($halfs as $half) { ?>
            .fc-time-grid .fc-slats tr[data-time|='<?php echo $half; ?>']{
                border-top: 2px dotted #ddd;
                /*            background: #fafafa;*/
            }
        <?php } ?>

        .fc-today{
            background: transparent !important;
        }

        .fc-time-area .fc-widget-header{
            font-weight: normal; 
        }



        /* visit services types */
        .visit-services-types ul {
            list-style: none; padding: 0px;
        }
        .visit-services-types ul li {
            cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
        }
        .visit-services-types ul li img {
            height: 30px;
        }

        /* visit services */
        .visit-services-categories ul {
            list-style: none; padding: 0px;
        }
        .visit-services-categories ul li {
            cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
        }
        .visit-services-categories ul li img {
            height: 30px;
        }

        .visit-services ul {
            list-style: none; padding: 0px;
        }
        .visit-services ul li {
            cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
        }

        .visit-products ul {
            list-style: none; padding: 0px;
        }
        .visit-products ul li {
            cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
        }


        /* gift voucher services */

        .voucher-services-types ul {
            list-style: none; padding: 0px;
        }
        .voucher-services-types ul li {
            cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
        }
        .voucher-services-types ul li img {
            height: 30px;
        }

        #voucher-services-categories ul {
            list-style: none; padding: 0px;
        }
        #voucher-services-categories ul li {
            cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
        }
        #voucher-services-categories ul li img {
            height: 30px;
        }

        #voucher-services ul {
            list-style: none; padding: 0px;
        }
        #voucher-services ul li {
            cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
        }

        .fc-content .fc-rows table .fc-widget-content{
            height: 105px;
        }

        .fc-timeline-event .fc-content{
            white-space: normal!important;
        }


        .card-box-fullscreen {
            z-index: 10060;
            margin: 0;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: #fff;
        }
        /* Full Screen portlet mode */
        .page-card-box-fullscreen {
            overflow: hidden;
        }
    </style>

    <script>
        
        
        var page = 'scheduler';

        function getViewPort() {
            var e = window,
                    a = 'inner';
            if (!('innerWidth' in window)) {
                a = 'client';
                e = document.documentElement || document.body;
            }

            return {
                height: e[a + 'Height']
            };
        }

        // handle portlet fullscreen
        function max() {
            var h = getViewPort();
            var height = h.height;
            var cardbox = $(this).closest(".card-box");
            if ($('#mCardbox').hasClass('card-box-fullscreen')) {
                $(this).removeClass('on');
                $('#mCardbox').removeClass('card-box-fullscreen');
                $('body').removeClass('page-card-box-fullscreen');
                $('.card-box').children('#calendar').css('height', 'auto');
                $('#calendar').fullCalendar('option', 'height', height-250);
            } else {
                
                $(this).addClass('on');
               
                $('#mCardbox').addClass('card-box-fullscreen');
                $('body').addClass('page-card-box-fullscreen');
                $('.card-box').children('#calendar').css('height', height);
                
                $('#calendar').fullCalendar('option', 'height', height);
            }
        }
        $(document).ready(function(){
            toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-center",
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
        });
    </script>

    <?php include 'js_functions/general_js.php'; ?>

    <?php include 'js_functions/calendar_js.php'; ?>

    <?php include 'js_functions/visit_js.php'; ?>

    <?php include 'js_functions/voucher_js.php'; ?>
    
    <?php include 'js_functions/blocking_events_js.php'; ?>

    <?php include 'js_functions/retail_js.php';
    