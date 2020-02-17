<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Service Chart</h4>
            </div>
        </div>

        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">1. Category</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <select id="service_category" multiple class="form-control" onchange="get_service();">
                                                <?php foreach ($service_category as $s) { ?>
                                                    <option value="<?php echo $s['id_service_category']; ?>"><?php echo $s['service_category']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">2. Service</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <select id="services" multiple class="form-control">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">3. Run</label></div>
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
        <!--        <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box ">
                            <div id="container1" style="height: 400px;"></div>
                        </div>
                    </div> end col 
                </div>-->

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box ">
                    <div id="container" style="height: 400px;"></div>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
        
         <!-- Multiple Products -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Service Chart (Multiple Service Sale for Selected Month):</h4>
            </div>
        </div>
        
        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">1. Category</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <select id="service_category_multiple" class="form-control" onchange="get_service_multiple(this.value);">
                                                <?php foreach ($service_category as $s) { ?>
                                                    <option value="<?php echo $s['id_service_category']; ?>"><?php echo $s['service_category']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">2. Services </label><small> (press ctrl to select multiple)</small></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <select id="services_multiple" class="form-control" multiple>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">3. Month</label></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <?php $now = new \DateTime('now');
                                            $month = $now->format('m'); ?>
                                            <select id="selectreport" class="form-control">
                                                <option value="1" <?php if ($month === '1') {
                                                echo "selected";
                                            } ?> >January</option>
                                                <option value="2" <?php if ($month === '2') {
                                                echo "selected";
                                            } ?>>February</option>
                                                <option value="3" <?php if ($month === '3') {
                                                echo "selected";
                                            } ?>>March</option>
                                                <option value="4" <?php if ($month === '4') {
                                                echo "selected";
                                            } ?>>April</option>
                                                <option value="5" <?php if ($month === '5') {
                                                echo "selected";
                                            } ?>>May</option>
                                                <option value="6" <?php if ($month === '6') {
                                                echo "selected";
                                            } ?>>June</option>
                                                <option value="7" <?php if ($month === '7') {
                                                echo "selected";
                                            } ?>>July</option>
                                                <option value="8" <?php if ($month === '8') {
                                                echo "selected";
                                            } ?>>August</option>
                                                <option value="9" <?php if ($month === '9') {
                                                echo "selected";
                                            } ?>>September</option>
                                                <option value="10" <?php if ($month === '10') {
                                                echo "selected";
                                            } ?>>October</option>
                                                <option value="11" <?php if ($month === '11') {
                                                echo "selected";
                                            } ?>>November</option>
                                                <option value="12" <?php if ($month === '12') {
                                                echo "selected";
                                            } ?>>December</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-2">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">. Year</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <?php  $now = new \DateTime('now'); $year = $now->format('Y');?>
                                            <?php $yearstart=$year-3;?>
                                            <select id="selectyear" class="form-control">
                                                <?php for($x=$yearstart;$x<=$year;$x++){ ?>
                                                <option value="<?php echo $x;?>" <?php if($x==$year){echo "selected";} ?> ><?php echo $x;?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">4. Draw Chart</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" > 
                                            <button type="button" id="drawChart" onclick="//drawChart();" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Draw</button>
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
                    <div id="myChart" style="height: 400px;"></div>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end Multi products -->


        <script type="text/javascript">


            $(document).ready(function() {

               // $('#service_category').select2();
                //$('#services').select2();
                $("#service_category_multiple").select2();

                //get_service(category_ids);
                
                get_service_multiple($('#service_category_multiple option:selected').val());
                
            });
            
            
            function chart_render(seriesdata) {
                if(seriesdata.length == ""){
                    swal({
                        title: "Data Not Found",
                        //text: "Please select a date Range",
                        type: "warning",
                        confirmButtonText: 'OK!'
                    });
                    return false;
                }
                $('#container').highcharts({
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
                        text: 'Services Sale'
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

            function runreport() {
                $("#cog").show();
                var service_name = [];
                var service_id = [];
                $('#services option:selected').each(function () {
                    service_name.push($(this).text());
                    service_id.push($(this).val());
                });
                //$('#services option:selected').text();
                
                var category_name = [];
                $('#service_category option:selected').each(function () {
                    category_name.push($(this).text());
                });
                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>sales_controller/getservice_chart_sale',
                    data: {service_name: service_name, service_id: service_id, category_name: category_name},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        chart_render(data);
                        $("#cog").hide();
                    }
                });
                
            }

            function get_service() {
                
                category_ids=[];
                $('#service_category option:selected').each(function () {
                    category_ids.push($(this).val());
                });
                
               // console.log(category_ids);
                
                
                if (category_ids) {
                    //$('#services').html('');
                    $("#services").select2('val', 'All');
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>sales_controller/get_services',
                        data: {category_id: category_ids},
                        dataType: "json",
                        cache: false,
                        async: true,
                        success: function(data) {
                            $('#services').html('');
                            var services = data['services'];
                            $.each(services, function(index, value) {
                                $('#services').append('<option value = ' + value['id_business_services'] + ' selected>' + value['service_name'] + '</option>');
                            });
                        }
                    });
                }
            }
            
            function get_service_multiple(category_id) {
                if (category_id) {
                    $("#services_multiple").select2('val', 'All');
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>sales_controller/get_services',
                        data: {category_id: category_id},
                        dataType: "json",
                        cache: false,
                        async: true,
                        success: function(data) {
                            $('#services_multiple').html('');
                            var services = data['services'];
                            $.each(services, function(index, value) {
                                $('#services_multiple').append('<option selected value = ' + value['id_business_services'] + '>' + value['service_name'] + '</option>');
                            });
                        }
                    });
                }
            }
            
            $('#drawChart').on('click', function () {
               
                    if ($('#services_multiple option:selected').length === 0) {
                        swal({
                            title: "Select Services",
                            text: "Please select service(s)",
                            type: "warning",
                            confirmButtonText: 'OK!'
                        });
                        return false;
                    }
                    if ($('#selectreport option:selected').val() === 'select') {
                        swal({
                            title: "Select Month",
                            text: "Please select a Month",
                            type: "warning",
                            confirmButtonText: 'OK!'
                        });
                        return false;
                    }

                    drawChart();
                   
                });
                
        function drawChart() {
             $("#cog1").show();
                var month = $('#selectreport option:selected').val();
                var monthname = $('#selectreport option:selected').text();
                var year = $('#selectyear option:selected').val();
                var service_ids=[];
                var service_names = [];


                $('#services_multiple option:selected').each(function () {
                    service_names.push($(this).text());
                    service_ids.push($(this).val());
                });

                var cat_id = $('#service_category_multiple option:selected').val();
                var cat_name = $('#service_category_multiple option:selected').text();
                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url();?>sales_controller/get_multiple_service_sale',
                    data: {
                        month: month,
                        year: year,
                        service_ids: service_ids,
                        service_names: service_names,                        
                        category_name: cat_name
                    },
                    dataType: "json",
                    success: function (data) {
                        render_chart(data, monthname);
                         $("#cog1").hide();
                    }
                });
            }
            
            function render_chart(series, month) {//Multiple Service chart rendered.....
                $('#myChart').highcharts({
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
                        text: 'Sales for the month of ' + month
                    },
                    xAxis: {
                        categories: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
                        title: {
                            text: month
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

        </script>
