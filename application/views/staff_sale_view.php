<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Chart</h4>
            </div>
        </div>

        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <h4 class="header-title m-t-0 m-b-30">Selection:</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">1. Select Staff</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <select id="staff" class="form-control">
                                                <?php foreach ($staff as $s) { ?>
                                                    <?php if ($s['staff_active'] === "Y") { ?>
                                                        <option value="<?php echo $s['id_staff']; ?>"><?php echo $s['staff_fullname']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">2. Run</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" > 
                                            <button type="button" onclick="runreport();" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button>
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
                <div class="card-box ">
                    <div id="staff_chart" style="height: 400px;"></div>
                </div>
            </div>
        </div>

        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <h4 class="header-title m-t-0 m-b-30">Selection:</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">1. Select staff</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <select id="select_multistaff" class="form-control" multiple>
                                                <?php foreach ($staff as $s) { ?>
                                                    <?php if ($s['staff_active'] === "Y") { ?>
                                                        <option value="<?php echo $s['id_staff']; ?>"><?php echo $s['staff_fullname']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">1. Select year</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <?php
                                            $now = new \DateTime('now');
                                            $year = $now->format('Y');
                                            ?>
                                            <?php $yearstart = $year - 3; ?>
                                            <select id="selectyear" class="form-control">
                                                <?php for ($x = $yearstart; $x <= $year; $x++) { ?>
                                                    <option value="<?php echo $x; ?>" <?php
                                                    if ($x == $year) {
                                                        echo "selected";
                                                    }
                                                    ?> ><?php echo $x; ?></option>
                                                        <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">2. Run</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" > 
                                            <button id="drawChart" type="button" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><i id="cog1" class="fa fa-spin fa-cog" style="display:none; font-size:26px;width: auto;margin-right: 10px;"></i></div>
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
                <div class="card-box ">
                    <div id="multistaff_chart" style="height: 400px;"></div>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->


        <script type="text/javascript">


            $(document).ready(function() {

                //$('#staff,#select_multistaff').select2().select2('val','1');
                $('#staff').select2();
                $('#selectyear').select2();



            });
            //TableManageButtons.init();

            //Start Single staff and year chart work..................
            //Call single staff chart by this function...
            function runreport() {
                $("#cog").show();
                var staff_id = $('#staff option:selected').val();
                var staff_name = $('#staff option:selected').text();
                $.ajax({
                    type: 'POST',
                    url: 'sales_controller/staff_sale_graph',
                    data: {staff_id: staff_id, staff_name: staff_name},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        chart_render(data);
                        $("#cog").hide();
                    }
                });
            }

            //Select single staff chart...
            function chart_render(seriesdata) {
                if (seriesdata.length == "") {
                    swal({
                        title: "Data Not Found",
                        //text: "Please select a date Range",
                        type: "warning",
                        confirmButtonText: 'OK!'
                    });
                    return false;
                }
                $('#staff_chart').highcharts({
                    chart: {
                        type: 'spline',
                        style: {
                            fontFamily: 'Roboto, sans-serif'
                        }
                    },
                    credits: false,
                    colors: ['#ff8acc', '#59a9f8 ', '#4a59b4', '#f9c851', '#10c469', '#ff5b5b', '#7cb5ec', '#434348', '#90ed7d', '#f7a35c', '#8085e9',
                        '#f15c80', '#e4d354', '#2b908f', '#f45b5b', '#91e8e1'],
                    title: {
                        text: 'Services Sale by ' + $('#staff option:selected').text()
                    },
                    xAxis: {
                        categories: [
                            'Jan', 'Feb', 'Mar',
                            'Apr', 'May', 'Jun',
                            'Jul', 'Aug', 'Sep',
                            'Oct', 'Nov', 'Dec'
                        ],
//                        categories: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
                        title: {
                            text: 'Months'
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Sales'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }]
                    },
                    series:
                            seriesdata


                });
            }
            //Select Multiple staff and Year chart........
            //End Multi staff and year chart work..................


            //Start Multi staff and year chart work..................
            //Call Multiple staff and Year chart by this function...
            $('#drawChart').on('click', function() {
                
                if ($('#select_multistaff option:selected').length === 0) {
                    swal({
                        title: "Alert!",
                        text: "Please select staff(s)",
                        type: "warning",
                        confirmButtonText: 'OK!'
                    });
                    return false;
                }
                if ($('#selectyear option:selected').val() === '') {
                    swal({
                        title: "Alert!",
                        text: "Please select a Year",
                        type: "warning",
                        confirmButtonText: 'OK!'
                    });
                    return false;
                }

                drawChart();
                
            });

            function drawChart() {
                $("#cog1").show();
                var year = $('#selectyear option:selected').val();
                var staff_ids = [];
                var staff_names = [];


                $('#select_multistaff option:selected').each(function() {
                    staff_names.push($(this).text());
                    staff_ids.push($(this).val());
                });

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>sales_controller/get_multiple_staff_sale',
                    data: {
                        year: year,
                        staff_ids: staff_ids,
                        staff_names: staff_names
                    },
                    dataType: "json",
                    success: function(data) {
                        multi_staff_render_chart(data, year);
                        $("#cog1").hide();
                    }
                });
            }

            //Select Multiple staff and Year chart.....
            function multi_staff_render_chart(series, year) {//Multiple Service chart rendered.....
                $('#multistaff_chart').highcharts({
                    chart: {
                        type: 'spline',
                        style: {
                            fontFamily: 'Roboto, sans-serif'
                        }
                    },
                    credits: false,
                    colors: ['#ff8acc', '#59a9f8 ', '#4a59b4', '#f9c851', '#10c469', '#ff5b5b', '#7cb5ec', '#434348', '#90ed7d', '#f7a35c', '#8085e9',
                        '#f15c80', '#e4d354', '#2b908f', '#f45b5b', '#91e8e1'],
                    title: {
                        text: 'Services Sales for the Year of ' + year
                    },
                    xAxis: {
                        categories: [
                            'Jan', 'Feb', 'Mar',
                            'Apr', 'May', 'Jun',
                            'Jul', 'Aug', 'Sep',
                            'Oct', 'Nov', 'Dec'
                        ],
                        title: {
                            text: year
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Sales'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }]
                    },
                    series: series
                });
            }
            //End Multi staff and year chart work..................

        </script>
