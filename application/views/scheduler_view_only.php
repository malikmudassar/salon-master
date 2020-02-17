<div class="wrapper" style="margin-top: 50px !important">
    <div class="full-container" style="margin-top: 0!important">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
               
                <h4 class="page-title">Total Services: <span id="totalvisits" class="page-title"></span></h4>
            </div>
        </div>


        <div class="row" id="mCardbox">
            
            <div class="col-lg-12">


                <div class="card-box" style="position: relative;">
                    
                    <div class="pull-right " style="margin-left: 6px;" data-toggle="tooltip" data-placement="top">
                        <a data-toggle="tooltip" data-placement="top" data-original-title="Refresh" href="javascript:void(0);" onclick="$('#calendar').fullCalendar('refetchEvents');" class="card-drop">
                            <i class="zmdi zmdi-refresh"></i>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" data-original-title="Fullscreen" href="javascript:max();" class="card-drop">
                            <i class="zmdi zmdi-fullscreen"></i>
                        </a>
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

                <!--Staff Reporting Model-->
                <?php include 'modals/staff_reporting_modal_1.php'; ?>
                <!--End Staff Reporting Model-->


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
            z-index: 10060 !important;
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
            //console.log(h);
            var height = h.height;
            var cardbox = $(this).closest(".card-box");
            if ($('#mCardbox').hasClass('card-box-fullscreen')) {
                $(this).removeClass('on');
                $('#mCardbox').removeClass('card-box-fullscreen');
                $('body').removeClass('page-card-box-fullscreen');
                $('.card-box').children('#calendar').css('height', 'auto');
                $('#calendar').fullCalendar('option', 'height', height-200);
            } else {
                
                $(this).addClass('on');
               
                $('#mCardbox').addClass('card-box-fullscreen');
                $('body').addClass('page-card-box-fullscreen');
                $('.card-box').children('#calendar').css('height', height);
                
                $('#calendar').fullCalendar('option', 'height', height-50);
            }
        }
    
    
   
   
</script>
    <?php include 'js_functions/general_js.php'; ?>
    <?php include 'js_functions/calendar_viewonly_js.php'; ?>
    <?php include 'js_functions/visit_js.php'; ?>
    <?php include 'js_functions/blocking_events_js.php'; ?>