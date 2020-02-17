<div class="wrapper">
    <div class="container">
        <!-- Single Product -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Retail Chart (Single Product Sale monthly comparison):</h4>
            </div>
        </div>
        <div class="row" id="divselectionsingle">
            <div class="col-sm-12">
                <div class="card-box ">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">1. Brands</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <select id="retail-brand-single" class="form-control"></select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">2. Products </label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <select id="retail-product-single" class="form-control" ></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">3. Draw Chart</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" > 
                                            <button type="button" id="drawChart-single" onclick="//drawChart();" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Draw</button>
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
                    <div id="myChart-single" style="height: 400px;"></div>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end single product -->
        
        
        
        
        
        
        
        <!-- Multiple Products -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Retail Chart (Multiple Products Sale for Selected Month):</h4>
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
                                        <div class="col-lg-12"> <label class="control-label">1. Brands</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <select id="retail-order-brands" class="form-control"></select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">2. Products </label><small> (press ctrl to select multiple)</small></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <select id="retail-order-products" class="form-control" multiple="multiple" ></select>
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

        <script>

            var startdate = "";
            var enddate = "";
            var options;
            $(document).ready(function () {
                retail_getbrands();
                $('#selectreport').select2();
                $('#retail-order-brands').on('click', function () {
                    get_brand_products($(this).val());
                });
                $('#retail-brand-single').on('click', function () {
                    get_brand_products($(this).val());
                });
                
                
                $('#drawChart').on('click', function () {
                    if ($('#retail-order-products option:selected').length === 0) {
                        swal({
                            title: "Select Products",
                            text: "Please select product(s)",
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

                $('#drawChart-single').on('click', function () {
                     
                    if ($('#retail-product-single option:selected').length === 0) {
                        swal({
                            title: "Select Products",
                            text: "Please select product(s)",
                            type: "warning",
                            confirmButtonText: 'OK!'
                        });
                        return false;
                    }

                    drawChart_single();
                     
                });

            });

            function drawChart() {
                $("#cog1").show();
                var month = $('#selectreport option:selected').val();
                var monthname = $('#selectreport option:selected').text();
                var product_ids=[];
                var product_names = [];


                $('#retail-order-products option:selected').each(function () {
                    product_names.push($(this).attr('product'));
                    product_ids.push($(this).val());
                });

                var brand_id = $('#retail-order-brands option:selected').val();

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url();?>sales_controller/get_product_sale',
                    data: {
                        month: month,
                        year: $("#selectyear option:selected").val(),
                        product_ids: product_ids,
                        product_names: product_names
                    },
                    dataType: "json",
                    success: function (data) {
                        render_chart(data, monthname);
                        $("#cog1").hide();
                    }
                });
            }

            function drawChart_single() {
            $("#cog").show();
                var product_id= 0;
                var product_name = '';
                var category='';
                
                product_name = $('#retail-product-single option:selected').attr('product');
                category = $('#retail-product-single option:selected').attr('category');
                product_id = $('#retail-product-single option:selected').val();

                var brand_id = $('#retail-order-brands option:selected').val();

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url();?>sales_controller/get_retail_comparison',
                    data: {
                        product_id: product_id,
                        product_name: product_name
                    },
                    dataType: "json",
                    success: function (data) {
                        render_chart_single(data, product_name, category);
                        $("#cog").hide();
                    }
                });
            }

            function render_chart(series, month) {
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


            function render_chart_single(series, product, cat) {
                $('#myChart-single').highcharts({
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
                        text: 'Sale trends of ' + product + ' - ' + cat
                    },
                    xAxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        title: {
                            text: 'month'
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


            function retail_getbrands() {
                var brandid=1;
                $.ajax({
                    type: 'POST',
                    data: {param:'none'},
                    url: 'product_controller/get_brands',
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function (data) {
                        var chtml = "";
                        for (var x = 0; x < data.length; x++) {
                            if (x==0){brandid=data[x]['id_business_brands'] ;}
                            //console.log(data[x]['business_brand_name'].trim());
                            chtml += '<option value="' + data[x]['id_business_brands'] + '">' + data[x]['business_brand_name'].trim() + '</option>';
                        }
                        //console.log(chtml);
                        $("#retail-order-brands").append(chtml);
                        $("#retail-brand-single").append(chtml);
                        $('#retail-order-brands').select2();
                        $('#retail-brand-single').select2();
                        get_brand_products(brandid);
                    }
                });
            }
            function get_brand_products(brandid){
                 $.ajax({
                    type: 'POST',
                    url: 'product_controller/get_all_products',
                    data: {brand_id: brandid},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function (data) {
                        var chtml = "";
                        for (var x = 0; x < data.length; x++) {
                           chtml += '<option product="'+ data[x]['product'].trim() +'"  category="'+ data[x]['category'] +'" value="' + data[x]['id_business_products'] + '">' + data[x]['product'].trim() + ' - ' + data[x]['category'] + '</option>';
                        }
                        
                        $("#retail-order-products").empty().append(chtml);
                        $("#retail-product-single").empty().append(chtml);
                        $('#retail-product-single').select2();
                    }
                });
                
                
            }

        </script>
