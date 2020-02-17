<link href="<?php echo base_url(); ?>assets/plugins/pivottable-master/dist/pivot.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.css" rel="stylesheet" type="text/css" />


<script src="<?php echo base_url(); ?>assets/plugins/pivottable-master/dist/pivot.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/pivottable-master/dist/c3_renderers.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.3.0/export_renderers.min.js"></script>
<style type="text/css">
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


<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Total Sale</h4>
            </div>
        </div>

        <div class="row" id="mCardbox">
            <div class="col-lg-12">
                <div class="card-box table-responsive">
                    <!--<h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>-->
                    <a data-toggle="tooltip" data-placement="top" data-original-title="Fullscreen" href="javascript:max();" class="card-drop pull-right">
                        <i class="zmdi zmdi-fullscreen"></i>
                    </a><br><br>
                    <div id="output2"></div>
                </div>
            </div><!-- end col -->
        </div>


        <!-- end row -->


        <script type="text/javascript">

            $(document).ready(function() {
                var derivers = $.pivotUtilities.derivers;
                var renderers = $.extend($.pivotUtilities.renderers, $.pivotUtilities.c3_renderers, $.pivotUtilities.export_renderers);
                var sumOverSum = $.pivotUtilities.aggregatorTemplates.sumOverSum;


                $.ajax({
                    type: 'POST',
                    url: 'sales_controller/salesreport_json',
                    dataType: "json",
                    cache: true,
                    //async: false,
                    success: function(data) {
                        $("#output2").pivotUI(data, {
                            rows: ["Month", "Year"],
                            cols: ["Staff"],
                            vals: ["SumofTotal"],
                            //rendererName: "Table Barchart",
                            //renderers: $.pivotUtilities.renderers,
                            aggregatorName: "Sum",
                            //hiddenAttributes: ['Year'],
                        });
                    }
                });

            });

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
                var height = h.height-100;
                var cardbox = $(this).closest(".card-box");
                if ($('#mCardbox').hasClass('card-box-fullscreen')) {
                    $(this).removeClass('on');
                    $('#mCardbox').removeClass('card-box-fullscreen');
                    $('body').removeClass('page-card-box-fullscreen');
                    $('.card-box').children('#output2').css('height', 'auto');
                    //$('#output2').fullCalendar('option', 'height', height - 250);
                } else {

                    $(this).addClass('on');

                    $('#mCardbox').addClass('card-box-fullscreen');
                    $('body').addClass('page-card-box-fullscreen');
                    $('.card-box').children('#output2').css('height', height);
                    //$('#output2').fullCalendar('option', 'height', height);
                }
            }



        </script>
