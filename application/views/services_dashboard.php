<div class="wrapper">
    <div class="container">
        
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    <button id="btnDashboard" class="btn btn-pink waves-effect waves-light">Cumulative Dashboard</button>
                    <button id="btnRetailDashboard" class="btn btn-custom  waves-effect waves-light">Retail Dashboard</button>
                </div>
                <div class="pull-right m-t-15 m-r-15">
                    <button onclick="initAll();" class="btn btn-icon waves-effect waves-light btn-default"> <i class="ti-reload"></i></button>
                </div>
                 <div class="pull-right m-t-15 m-r-5">
                    <?php $now = new \DateTime('now'); $year = $now->format('Y'); $yearstart=$year-3;?>
                    <select id="selectyear" class="form-control">
                        <?php for($x=$yearstart;$x<=$year;$x++){ ?>
                        <option value="<?php echo $x;?>" <?php if($x==$year){echo "selected";} ?> ><?php echo $x;?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="pull-right m-t-15 m-r-5">
                    <?php 
                    $month = $now->format('m');?>
                    <select id="selectmonth" class="form-control">
                        <option value="1" <?php if ($month === '01') {
                        echo "selected";
                    } ?> >January</option>
                        <option value="2" <?php if ($month === '02') {
                        echo "selected";
                    } ?>>February</option>
                        <option value="3" <?php if ($month === '03') {
                        echo "selected";
                    } ?>>March</option>
                        <option value="4" <?php if ($month === '04') {
                        echo "selected";
                    } ?>>April</option>
                        <option value="5" <?php if ($month === '05') {
                        echo "selected";
                    } ?>>May</option>
                        <option value="6" <?php if ($month === '06') {
                        echo "selected";
                    } ?>>June</option>
                        <option value="7" <?php if ($month === '07') {
                        echo "selected";
                    } ?>>July</option>
                        <option value="8" <?php if ($month === '08') {
                        echo "selected";
                    } ?>>August</option>
                        <option value="9" <?php if ($month === '09') {
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
               
                <h4 class="page-title">Services Dashboard</h4>
            </div>
        </div>
        
        <div class="row">
              <div class="col-md-6">
                  <div class="card-box">
                      <div id="container" style="height: 400px;"></div>
                  </div>
              </div>
            <div class="col-md-6">
                <div class="card-box">
                    <div id="grossing_services" style="height: 400px;"></div>
                </div>
                
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6">
               <div class="card-box">
                  <h4 class="header-title m-t-0 m-b-5">Today&#8216;s Service Revenue</h4>

                  <div id="divtodayssale" class="widget-box-2">
                      <div class="widget-detail-2">
                          <span class="badge badge-warning pull-left m-t-20" id="todayincrease">0% 
                            <i class="zmdi zmdi-trending-up"></i> </span>
                             <div class="widget-detail-1">
                                <p class="m-b-0">Cash: <span id="todaycash">0</span></p>
                                <p class="p-t-5 m-b-0">Card: <span id="todaycard">0</span></p>
                                <p class="p-t-5 m-b-0">Bank: <span id="todaybank">0</span></p>
                                <p class="p-t-5 m-b-0">Voucher: <span id="todayvoucher">0</span></p>
                                <p class="m-b-0"><strong>Total: <span id="todayrevenue">0</span></strong></p>
                            </div>
                      </div>
                      
                  </div>
               </div>
           </div><!-- end col -->
            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-5" ><span id="monthname"></span>&#8216;s Revenue Breakup</h4>
                    <div class="widget-chart-1">
                        <div class="widget-chart-box-1 m-t-20" >
                            <span id="dailysale" ></span>
                        </div>
                        <div class="widget-detail-1">
                            <p class="m-b-0">Cash: <span id="monthcash">0</span></p>
                            <p class="p-t-5 m-b-0">Card: <span id="monthcard">0</span></p>
                            <p class="p-t-5 m-b-0">Bank: <span id="monthbank">0</span></p>
                            <p class="p-t-5 m-b-0">Voucher: <span id="monthvoucher">0</span></p>
                            <p class="m-b-0"><strong>Total: <span id="monthrevenue">0</span></strong></p>
                          
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                   <h4 class="header-title m-t-0 m-b-30">This Year's Service Revenue</h4>
                    <div class="widget-chart-1">
                        <div class="widget-chart-box-1">
                            <span id="monthlysale" ></span>
                        </div>
                        <div class="widget-detail-1">
                            <h3 class="p-t-10 m-b-0" id='yearrevenue'> 0 </h3>
                            <p class="text-muted" id='yearname'>Revenue Year</p>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                             <li><a href="javascript:void(0);" onclick="get_month_commission();">Refresh</a></li>
                        </ul>
                    </div>

                    <h4 class="header-title m-t-0 m-b-30">Services Commissions</h4>

                    <div class="widget-box-2">
                        <div class="widget-detail-2">
                            <span class="badge badge-warning pull-left m-t-20"> <i
                                    class="zmdi zmdi-account-box-mail"></i> </span>

                            <h3 class="m-b-0" id="salescommissions"> 0 </h3>
                            <p class="text-muted m-b-25" id="commissionsmonth">Month</p>
                        </div>
                        <div class="progress progress-bar-warning-alt progress-sm m-b-0">
                            <div class="progress-bar progress-bar-success" role="progressbar"
                                 aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"
                                 style="width: 0%;">
                                <span class="sr-only">0% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div>

       <div class="row" >
                    <div class="col-lg-4">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">Top 20 Customers of <span id="customermonthname"></span></h4>
                            <div id="top-clients2" class="inbox-widget nicescroll" style="height: 315px; overflow: hidden; outline: none;" tabindex="5000">
                                <a href="#">
                                    <div class="inbox-item">
                                        <div class="inbox-item-img"></div>
                                        <p class="inbox-item-author"></p>
                                        <p class="inbox-item-text"></p>
                                        <p class="inbox-item-date"></p>
                                    </div>
                                </a>

                            </div>
                        </div>
                    </div><!-- end col -->

                    <div class="col-lg-8">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">Staff Performance this Month </h4>

                            <div class="nicescroll" style="height: 315px; overflow: hidden; outline: none;" tabindex="5000">
                                <div class="table-responsive">
                                <table class="table" id="staffperformance">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Staff</th>
                                        <th>Total Services</th>
                                        <th>Paid</th>
                                        <th>Recoveries</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            
                        </div>
                    </div><!-- end col -->

                </div>         
<script>
    
    $(document).ready(function() {
               
        initAll();
        
        $('#btnDashboard').on('click', function(){
            window.location.assign('<?php echo base_url().'dashboard';?>');
            return false;
            
        });
        $('#btnRetailDashboard').on('click', function(){
            window.location.assign('<?php echo base_url().'retaildashboard';?>');
            return false;
            
        });
        
        $('#container').highcharts({
            chart: {
                type: 'spline',
                style: {
                    fontFamily: 'Roboto, sans-serif'
                }
            },
            credits: false,
            colors: ['#f9c851', '#ff8acc', '#59a9f8 ', '#4a59b4',  '#10c469', '#ff5b5b', '#7cb5ec', '#434348', '#90ed7d', '#f7a35c', '#8085e9', 
                '#f15c80', '#e4d354', '#2b908f', '#f45b5b', '#91e8e1'],
            title: {
                text: 'Total Services Revenue'
            },
            xAxis: {
                categories: [
                    'Jan', 'Feb', 'Mar',
                    'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep',
                    'Oct', 'Nov', 'Dec'
                ],
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
            series: [
                <?php echo $sales; ?>
            ]
        });
        
        
        //grossing_services
        // Build the chart
        
        
       
    });
    
    function draw_grossing_services(mData, total){
        //console.log(mData);
        // Make monochrome colors and set them as default for all pies
        Highcharts.getOptions().plotOptions.pie.colors = (function () {
            var colors = [],
                base = '#f9c851',//Highcharts.getOptions().colors[0],
                i;

            for (i = 0; i < 12; i += 1) {
                // Start out with a darkened base color (negative brighten), and end
                // up with a much brighter color
                colors.push(Highcharts.Color(base).brighten((i - 3) / 14).get());
            }
            return colors;
        }());

        
        
          $('#grossing_services').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
                style: {
                        fontFamily: 'Roboto, sans-serif'
                    }
            },
            credits: false,
//            colors: ['#ff8acc',  '#71b6f9', '#fcdf9b', '#10c469', '#ffd7ed', '#99527a', '#ccff8a', '#434348', '#90ed7d', '#f7a35c', '#8085e9', 
//                '#f15c80', '#e4d354', '#2b908f', '#f45b5b', '#91e8e1'],
            title: {
                text: 'Service Category Share'
            },
            subtitle: {
                text: 'Share of your Service Categories in the selected month.'
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px; word-wrap: break-word;">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },
            series: [{
                name: 'Services',
                colorByPoint: true,
                data: mData
            }]
        });
    }
    
    function todayssale(){
       var yesterday=0;
        var today=0;
        $.ajax({
                type: "GET",
                url: "servicesdashboard_controller/get_todays_breakup",
                data: {  month: $("#selectmonth option:selected").val(), year: $("#selectyear option:selected").val()},
                dataType: "json",
                cache: false,
                async: true,
                success: function(data) {
                     //$("#cook").val(data['csrf_hash']);
                    if(data['cash'].length>0){
                        $("#todaycash").html(formatDollar(parseInt(data['cash'][0]['Total'])));
                        today=today+parseFloat(data['cash'][0]['Total']);
                    }
                    if(data['card'].length>0){
                        $("#todaycard").html(formatDollar(parseInt(data['card'][0]['Total'])));
                        today=today+parseFloat(data['card'][0]['Total']);
                    }
                    if(data['bank'].length>0){
                        $("#todaybank").html(formatDollar(parseInt(data['bank'][0]['Total'])));
                        today=today+parseFloat(data['bank'][0]['Total']);
                    }
                    if(data['voucher'].length>0){
                        $("#todayvoucher").html(formatDollar(parseInt(data['voucher'][0]['Total'])));
                        today=today+parseFloat(data['voucher'][0]['Total']);
                    }                    
                    $("#todayrevenue").html(formatDollar(parseInt(today)));
                    if(data['Yesterday'].length>=1){
                        yesterday = data['Yesterday']['Total'];
                         var difference = parseFloat(today) - parseFloat(yesterday);
                        //console.log(difference);
                        var perc= 0;
                        if(parseFloat(yesterday) >0) {(100*difference)/parseFloat(yesterday);}
                        else {perc= 100;};
                        if (difference > 0){
                            $("#todayincrease").html(perc.toFixed(1) + ' % <i class="zmdi zmdi-trending-up"></i>');
                        } else if (difference < 0){
                            $("#todayincrease").html(perc.toFixed(1) + ' % <i class="zmdi zmdi-trending-down"></i>');
                        } else { 
                            $("#todayincrease").html('0 % <i class="zmdi zmdi-trending-down"></i>'); 
                        }
                        $("#todayperc").html('<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="'+ Math.round(perc) +'" aria-valuemin="0" aria-valuemax="100"style="width: ' +Math.round(perc)+ '%;"><span class="sr-only">'+Math.round(perc)+'% Complete</span></div>');
    
                    } 
                }
            });
            
        }
        function yesterdaysale(today){    
            var yesterday=0;
            $.ajax({
                type: "GET",
                url: "servicesdashboard_controller/yesterdaysale",
                data: {  month: $("#selectmonth option:selected").val(), year: $("#selectyear option:selected").val()},
                dataType: "json",
                cache: false,
                async: true,
                success: function(data) { //$("#cook").val(data['csrf_hash']);
                   // console.log(data);
                    if(data.length>=1){
                        yesterday = data[0]['Total'];
                         var difference = parseFloat(today) - parseFloat(yesterday);
                        //console.log(difference);
                        var perc= 0;
                        if(parseFloat(yesterday) >0) {(100*difference)/parseFloat(yesterday);}
                        else {perc= 100;};
                        if (difference > 0){
                            $("#todayincrease").html(perc.toFixed(1) + ' % <i class="zmdi zmdi-trending-up"></i>');
                        } else if (difference < 0){
                            $("#todayincrease").html(perc.toFixed(1) + ' % <i class="zmdi zmdi-trending-down"></i>');
                        } else { 
                            $("#todayincrease").html('0 % <i class="zmdi zmdi-trending-down"></i>'); 
                        }
                        $("#todayperc").html('<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="'+ Math.round(perc) +'" aria-valuemin="0" aria-valuemax="100"style="width: ' +Math.round(perc)+ '%;"><span class="sr-only">'+Math.round(perc)+'% Complete</span></div>');
    
                    } 
                }
            });

           
    }
    
    function monthsale(){
        var monthsale=0;
        var cmonth='';
        $.ajax({
            type: "GET",
            url: "servicesdashboard_controller/monthsale",
             data: {  month: $("#selectmonth option:selected").val(), year: $("#selectyear option:selected").val()},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                 //$("#cook").val(data['csrf_hash']);
               // console.log(data);
                if(data.length>=1){
                    monthsale = data[0]['Total'];
                    cmonth = data[0]['Month'];
                } 
                $("#monthrevenue").html(formatDollar(parseInt(monthsale)));
                //$("#monthrevenuechart").value(monthsale);
                //$("#monthname").html(cmonth );
            }
        });
    }
    
    function getmonthbreakup(){
        
        var cmonth='';
        var totalamount=0;
        $.ajax({
            type: "GET",
            url: "servicesdashboard_controller/get_months_breakup",
             data: {  month: $("#selectmonth option:selected").val(), year: $("#selectyear option:selected").val()},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) { //$("#cook").val(data['csrf_hash']);
               // console.log(data);
                if(data['cash'].length>=1){
                    $("#monthcash").html(formatDollar(parseInt(data['cash'][0]['Total'])));
                    totalamount=totalamount+parseFloat(data['cash'][0]['Total']);
                    cmonth = data['cash'][0]['Month'];
                } else {$("#monthcash").html('0')}
                if(data['card'].length>=1){
                    $("#monthcard").html(formatDollar(parseInt(data['card'][0]['Total'])));
                    totalamount=totalamount+parseFloat(data['card'][0]['Total']);
                    cmonth = data['card'][0]['Month'];
                } else {$("#monthcard").html('0')}
                if(data['bank'].length>=1){
                    $("#monthbank").html(formatDollar(parseInt(data['bank'][0]['Total'])));
                    totalamount=totalamount+parseFloat(data['bank'][0]['Total']);
                    cmonth = data['bank'][0]['Month'];
                }else {$("#monthbank").html('0')}
                if(data['voucher'].length>=1){
                    $("#monthvoucher").html(formatDollar(parseInt(data['voucher'][0]['Total'])));
                    totalamount=totalamount+parseFloat(data['voucher'][0]['Total']);
                    cmonth = data['voucher'][0]['Month'];
                }else {$("#monthvoucher").html('0')}
                //$("#monthrevenuechart").value(monthsale);
                $("#monthname").html(cmonth);
               
                $("#monthrevenue").html(formatDollar(parseFloat(totalamount)));
            }
        });
    }
    
    function cashsale(){
        var cashsale=0;
        var cmonth='';
        $.ajax({
            type: "GET",
            url: "servicesdashboard_controller/cash_payments",
             data: {  month: $("#selectmonth option:selected").val(), year: $("#selectyear option:selected").val()},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) { //$("#cook").val(data['csrf_hash']);
               // console.log(data);
                if(data.length>=1){
                    cashsale = data[0]['Total'];
                    cmonth = data[0]['Month'];
                } 
                $("#monthcash").html(formatDollar(parseInt(cashsale)));
                //$("#monthrevenuechart").value(monthsale);
                $("#monthname").html(cmonth );
            }
        });
    }
    function cardsale(){
        var cardsale=0;
        var cmonth='';
        $.ajax({
            type: "GET",
            url: "servicesdashboard_controller/card_payments",
             data: {  month: $("#selectmonth option:selected").val(), year: $("#selectyear option:selected").val()},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) { //$("#cook").val(data['csrf_hash']);
               // console.log(data);
                if(data.length>=1){
                    cardsale = data[0]['Total'];
                    cmonth = data[0]['Month'];
                } 
                $("#monthcard").html(formatDollar(parseInt(cardsale)));
               
            }
        });
    }
    function vouchersale(){
        var vouchersale=0;
        var cmonth='';
        $.ajax({
            type: "GET",
            url: "servicesdashboard_controller/voucher_payments",
             data: {  month: $("#selectmonth option:selected").val(), year: $("#selectyear option:selected").val()},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) { //$("#cook").val(data['csrf_hash']);
               // console.log(data);
                if(data.length>=1){
                    vouchersale = data[0]['Total'];
                    cmonth = data[0]['Month'];
                } 
                $("#monthvoucher").html(formatDollar(parseInt(vouchersale)));
                
            }
        });
    }
    function banksale(){
        var banksale=0;
        var cmonth='';
        $.ajax({
            type: "GET",
            url: "servicesdashboard_controller/bank_payments",
             data: {  month: $("#selectmonth option:selected").val(), year: $("#selectyear option:selected").val()},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) { //$("#cook").val(data['csrf_hash']);
               // console.log(data);
                if(data.length>=1){
                    banksale = data[0]['Total'];
                    cmonth = data[0]['Month'];
                } 
                $("#monthloyalty").html(formatDollar(parseInt(banksale)));
                
            }
        });
    }
    function yearsale(){
        var yearsale=0;
        var cyear='';
        $.ajax({
            type: "GET",
            url: "servicesdashboard_controller/yearsale",
             data: {  month: $("#selectmonth option:selected").val(), year: $("#selectyear option:selected").val()},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) { //$("#cook").val(data['csrf_hash']);
               // console.log(data);
                if(data.length>=1){
                    yearsale = data[0]['Total'];
                    cyear = data[0]['Year'];
                } 
                $("#yearrevenue").html(formatDollar(parseInt(yearsale)));
                //$("#monthrevenuechart").value(monthsale);
                $("#yearname").html(cyear + ' Revenue');
            }
        });
    }
    
    function monthlysale(){
        $.ajax({
            type: "GET",
            url: "servicesdashboard_controller/monthlysale",
             data: {  month: $("#selectmonth option:selected").val(), year: $("#selectyear option:selected").val()},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) { //$("#cook").val(data['csrf_hash']);
                mhtml="";
                for (x = 0; x < data.length; x++) {
                    if(x===0){mhtml += data[x]['Total'];}
                    else {mhtml += ','+data[x]['Total'];}
                } 
                $("#monthlysale").html(mhtml);
                $("#monthlysale").peity("bar", {
                    fill: ["#fcdf9b","#f9c851"],
                    height: 60,
                    width: 100
                  });
            }
        });
    }
    
    function dailysale(){
        $.ajax({
            type: "GET",
            url: "servicesdashboard_controller/dailysale",
            dataType: "json",
             data: {  month: $("#selectmonth option:selected").val(), year: $("#selectyear option:selected").val()},
            cache: false,
            async: true,
            success: function(data) { //$("#cook").val(data['csrf_hash']);
                mhtml="";
                for (x = 0; x < data.length; x++) {
                    if(x===0){mhtml += data[x]['Total'];}
                    else {mhtml += ','+data[x]['Total'];}
                } 
                $("#dailysale").html(mhtml);
                $("#dailysale").peity("bar", {
                    fill: ["#fcdf9b","#f9c851"],
                    height: 60,
                    width: 100
                  });
            }
        });
    }
    
    function get_month_commission(){
        $.ajax({
            type: "GET",
            url: "servicesdashboard_controller/get_month_commission",
             data: {  month: $("#selectmonth option:selected").val(), year: $("#selectyear option:selected").val()},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) { //$("#cook").val(data['csrf_hash']);
                mhtml=0;
                cmonth='';
                for (x = 0; x < data.length; x++) {
                    mhtml = mhtml + parseInt(data[x]['Commission']);
                    cmonth=data[x]['Month'];
                } 
                 $("#salescommissions").html(formatDollar(parseInt(mhtml)));
                 $("#commissionsmonth").html(cmonth);
            }

        });
    }
    
    function top_4_clients(){
        $.ajax({
            type: "GET",
            url: "servicesdashboard_controller/top_4_clients",
             data: {  month: $("#selectmonth option:selected").val(), year: $("#selectyear option:selected").val()},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                 //$("#cook").val(data['csrf_hash']);
                mhtml='';
                xhtml='';
                color='text-warning';
                for (x = 0; x < data.length; x++) {
                    xhtml+='<a href="javascript:openAccount('+data[x]['customer_id'] +')">';
                    xhtml+='<div class="inbox-item">';
                    xhtml+='<div class="inbox-item-img"><img src="<?php echo base_url();?>assets/images/users/avatar-1.jpg" class="img-circle" alt="" data-pin-nopin="true"></div>';
                    xhtml+='<p class="inbox-item-author">'+ data[x]['customer_name'] +'</p>';
                    xhtml+='<p class="inbox-item-text">'+ data[x]['Total'] +'</p>';
                    xhtml+='<p class="inbox-item-date">'+ data[x]['customer_email'] +'</p>';
                    xhtml+='</div>';
                    xhtml+='</a>';
                    
                } 
                //$("#top-clients").html(mhtml);
                $("#customermonthname").html($("#selectmonth option:selected").text());
                $("#top-clients2").html(xhtml);
            }

        });
    }
    function openAccount(id){
        
        window.open('customer_previous_visit/' + id);
    }
    function top_4_staff(){
            $.ajax({
            type: "GET",
            url: "servicesdashboard_controller/top_4_staff",
             data: {  month: $("#selectmonth option:selected").val(), year: $("#selectyear option:selected").val()},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                 //$("#cook").val(data['csrf_hash']);
                mhtml='';
                thtml='';
                color='text-success';
                var l = data.length - 1;
                for (x = 0; x < data.length; x++) {
                    
                    mhtml+='<tr>';
                    mhtml+='<td><img style="width:35px" src="<?php echo base_url();?>assets/images/staff/'+ data[x]['staff_image'] +'" class="img-circle" alt="" data-pin-nopin="true"></td>';
                    mhtml+='<td><strong>'+ data[x]['Staff'] +'<strong></td>';
                    mhtml+='<td><span class="label label-warning">'+ data[x]['Services'] +'</span></td>';
                    mhtml+='<td>'+ data[x]['Amount'] +'</td>';
                    mhtml+='<td>'+ data[x]['Recovery'] +'</td>';
                    mhtml+='</tr>';                    


                } 
                $("#staffperformance tbody").html(mhtml);
                
            }

        });
    }
    
    function grossing_services(){
        var mData=[];
        var total=0;
        $.ajax({
            type: "GET",
            url: "servicesdashboard_controller/grossing_services",
             data: {  month: $("#selectmonth option:selected").val(), year: $("#selectyear option:selected").val()},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) { //$("#cook").val(data['csrf_hash']);
               //console.log(data);
                
                for (x = 0; x < data.length; x++) {
                    //var mObject = {name: data[x]['name'], y: parseFloat(data[x]['y'])};
                    var mObject = {name: data[x]['name'].substring(0,29), y: parseFloat(data[x]['y'])};
                    
                    mData[x]=mObject;
                    total = data[x]['paid'];
                } 
                draw_grossing_services(mData, total);
            }

        });
    }
    
    
    function open_sked(date1) {
        window.location= "<?php echo base_url().'scheduler/'?>" + date1 + "";
        
    }
    
    function formatDollar(num) {
        var p = num.toFixed(1).split(".");
        return p[0].split("").reverse().reduce(function(acc, num, i, orig) {
            return  num + (i && !(i % 3) ? "," : "") + acc;
        }, "") + "." + p[1];
    }
    
    function initAll(){
        grossing_services();
        yearsale();
        monthlysale();
        dailysale();
        get_month_commission();
        top_4_staff();
        top_4_clients();
        getmonthbreakup();
        //monthsale();
        todayssale();
        
    }
</script>