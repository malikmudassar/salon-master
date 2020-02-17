<div class="wrapper">
    <div class="container">

   

        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
<!--                    <button id="btnSaleDashboard" class="btn btn-warning waves-effect waves-light">Gym Dashboard</button>
                    <button id="btnRetailDashboard" class="btn btn-custom  waves-effect waves-light">Training Dashboard</button>
                    -->
                </div>
                <h4 class="page-title">Programs Dashboard</h4>
                
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
            <div class="col-sm-12">
                <h4 class="page-title"></h4>
            </div>
        </div>
        
        <!-- TEST-->
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel"  style="background: transparent;">
            <!-- Wrapper for slides -->
            <div class="carousel-inner" id="top-staff-scroll"></div>

            <!-- Controls -->
            <a class="left carousel-control"  style="background: transparent; color:#808080" href="#carousel-example-generic" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control"  style="background: transparent; color:#808080" href="#carousel-example-generic" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
          </div> <!-- Carousel -->
        
        
        <!--TEST-->
        
        
        <div class="row" id="top-staff">
            
        </div>

       <div class="row" >
                    <div class="col-lg-4">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30"></h4>
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

                            <h4 class="header-title m-t-0 m-b-30"></h4>

                            <div class="nicescroll" style="height: 315px; overflow: hidden; outline: none;" tabindex="5000">
                                <div class="table-responsive">
                                <table class="table" id="uninvoiced">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Visit Date</th>
                                        <th>Customer Name</th>
                                        <th>Total Services</th>
                                        <th></th>
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
       

        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "0",
            "extendedTimeOut": "0",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "tapToDismiss":true
        }
        
        $('#btnSaleDashboard').on('click', function(){
            window.location.assign('<?php echo base_url().'servicesdashboard';?>');
            return false;
            
        });
        $('#btnRetailDashboard').on('click', function(){
            window.location.assign('<?php echo base_url().'retaildashboard';?>');
            return false;
            
        });
        
        
      
        // Build the charts
       // yearchart();
       
    });
    
   
    function draw_grossing_services(mData, total){
        //console.log(mData);
        // Make monochrome colors and set them as default for all pies
        Highcharts.getOptions().plotOptions.pie.colors = (function () {
            var colors = [],
                base = '#ff8acc',//Highcharts.getOptions().colors[0],
                i;

            for (i = 0; i < 10; i += 1) {
                // Start out with a darkened base color (negative brighten), and end
                // up with a much brighter color
                colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
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
                text: '5 Highest Grossing Services'
            },
            subtitle: {
                text: 'Percentages of Rs.'+ total.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' made by the top 5 services this month.'
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
                headerFormat: '<span style="font-size:11px;word-wrap: break-word;">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },
            series: [{
                name: 'Services',
                colorByPoint: true,
                data: mData
            }]
        });
    }
    
    
    function drawyourweek(){
        var categories = <?php echo json_encode($days);?>;
        var customers = <?php echo json_encode($Customers);?>;
        var services = <?php echo json_encode($Services);?>;
        var revenue = <?php echo json_encode($Revenue);?>;
        var balance = <?php echo json_encode($Balance);?>;
        var advance = <?php echo json_encode($Advance);?>;
        
        $('#container').highcharts({
            chart: {
                zoomType: 'xy',
                style: {
                        fontFamily: 'Roboto, sans-serif'
                    }
            },
            credits: false,
            colors: ['#921d5f', '#d05b9d', '#f9c851', '#921d5f', '#ffc7ff', '#71b6f9', '#a2cef8', '#ff8acc', '#f9c851', '#10c469', '#4a59b4',  '#f9c851',  '#ff5b5b', '#7cb5ec', '#434348', '#90ed7d', '#f7a35c', '#8085e9', 
                '#f15c80', '#e4d354', '#2b908f', '#f45b5b', '#91e8e1'],
            title: {
                text: 'Your Work Week'
            },
            subtitle: {
                text: ''
            },
            xAxis: [{
                categories: categories,
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: 'Rs. {value}',
                    style: {
                        color: '#921d5f'
                    }
                },
                title: {
                    text: 'Revenue/Balances',
                    style: {
                        color: '#921d5f'
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Visits/Services',
                    style: {
                        color: '#921d5f'
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color:'#921d5f'
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            series: [{
                name: 'Visits',
                type: 'column',
                yAxis: 1,
                data: customers,
                tooltip: {
                    valuePrefix: ''
                }

            }, {
                name: 'Services',
                type: 'column',
                yAxis: 1,
                data: services,
                tooltip: {
                    valueSuffix: ''
                }

            },{
                name: 'Revenue',
                type: 'spline',
                data: revenue,
                tooltip: {
                    valuePrefix: 'Rs. '
                }
            }, {
                name: 'Balances',
                type: 'spline',
                data: balance,
                tooltip: {
                    valuePrefix: 'Rs. '
                }
            }, {
                name: 'Advance',
                type: 'spline',
                data: advance,
                tooltip: {
                    valuePrefix: 'Rs. '
                }
            }]
        });
       
   }
    
    
    function todayssale(){
       var yesterday=0;
        var today=0;
         
        $.ajax({
            type: "GET",
            url: "dashboard_controller/todayssale",
            data: { },
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) { 
                if(data['Today'].length>=1){
                    today = data['Today'][0]['Total'];
                    $("#todaysale").html(formatDollar(parseInt(today)));
                } 
               
                if(data['Yesterday'].length>=1){
                    yesterday = data['Yesterday'][0]['Total'];
                } 
                
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
                $("#todayperc").html('<div class="progress-bar progress-bar-pink" role="progressbar" aria-valuenow="'+ Math.round(perc) +'" aria-valuemin="0" aria-valuemax="100"style="width: ' +Math.round(perc)+ '%;"><span class="sr-only">'+Math.round(perc)+'% Complete</span></div>');
                
            }
        });
        
    }
    function yesterdaysale(today){
        var yesterday=0;
        // 
        $.ajax({
            type: "GET",
            url: "dashboard_controller/yesterdaysale",
            data: {  },
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) { 
               // console.log(data);
                if(data.length>=1){
                    yesterday = data[0]['Total'];
                } 
            }
        });
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
        $("#todayperc").html('<div class="progress-bar progress-bar-pink" role="progressbar" aria-valuenow="'+ Math.round(perc) +'" aria-valuemin="0" aria-valuemax="100"style="width: ' +Math.round(perc)+ '%;"><span class="sr-only">'+Math.round(perc)+'% Complete</span></div>');
    }
    
    function monthsale(){
        var monthsale=0;
        var cmonth='';
         $.ajax({
            type: "GET",
            url: "dashboard_controller/monthsale",
            data: {},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) { 
                
                if(data.length>=1){
                    monthsale = data[0]['Total'];
                    cmonth = data[0]['Month'];
                } 
                $("#monthrevenue").html(formatDollar(parseInt(monthsale)));
                //$("#monthrevenuechart").value(monthsale);
                $("#monthname").html(cmonth );
            }
        });
    }
    
    function yearsale(){
        var yearsale=0;
        var cyear='';
         $.ajax({
            type: "GET",
            url: "dashboard_controller/yearsale",
            data: {  },
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {  
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
            url: "dashboard_controller/monthlysale",
            data: {  },
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) { 
                 
                mhtml="";
                for (x = 0; x < data.length; x++) {  
                    if(x===0){mhtml += data[x]['Total'];}
                    else {mhtml += ','+data[x]['Total'];}
                } 
                $("#monthlysale").html(mhtml);
                $("#monthlysale").peity("bar", {
                    fill: ["#a2cef8","#71b6f9"],
                    height: 60,
                    width: 100
                  });
            }
        });
    }
    
    function dailysale(){
         $.ajax({
            type: "GET",
            url: "dashboard_controller/dailysale",
            data: {  },
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) { 
                 
                //console.log(data);
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
            url: "dashboard_controller/get_month_commission",
            data: {  },
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {  
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
            url: "dashboard_controller/top_4_clients",
            data: {  },
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {  
                mhtml='';
                xhtml='';
                color='text-warning';
                for (x = 0; x < data.length; x++) {  
//                    mhtml+='<div class="col-lg-3 col-md-6">';
//                    mhtml+='<div class="card-box widget-user">';
//                    mhtml+='<div >';
//                    mhtml+='<img src="<?php echo base_url();?>assets/images/users/avatar-1.jpg" class="img-responsive img-circle"';
//                    mhtml+='alt="client">';
//                    mhtml+='<div class="wid-u-info">';
//                    mhtml+='<h4 class="m-t-0 m-b-5 font-600 ">'+ data[x]['Total'] +'</h4>';
//                    mhtml+='<p class="text-muted m-b-5 font-13">'+ data[x]['customer_name'] +'</p>';
//                    mhtml+='<small class="'+ color +'"><b>'+ data[x]['customer_email'] +'</b></small>';
//                    mhtml+='</div>';
//                    mhtml+='</div>';
//                    mhtml+='</div>';
//                    mhtml+='</div><!-- end col -->';
//                    if(color==='text-warning'){color='text-pink';}else if (color==='text-pink'){ color='text-custom';}else if(color==='text-custom'){color='text-success';}else if (color==='text-success'){color='text-warning';}
//                    
                    
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
            url: "dashboard_controller/top_4_staff",
            data: { },
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {  
                
                mhtml='';
                thtml='';
                color='text-warning';
                var l = data.length - 1;
                for (x = 0; x < data.length; x++) {  
                    
                    mhtml+='<div class="col-lg-3 col-md-4">';
                    mhtml+='<div class="card-box widget-user">';
                    mhtml+='<div >';
                    mhtml+='<img src="<?php echo base_url();?>assets/images/staff/'+ data[x]['staff_image'] +'" class="img-responsive img-circle"';
                    mhtml+='alt="client">';
                    mhtml+='<div class="wid-u-info">';
                    mhtml+='<h5 class="m-t-0 m-b-5 font-600 ">'+ data[x]['Amount'] +'</h5>';
                    mhtml+='<p class="text-muted m-b-5 font-13">'+ data[x]['Staff'] +'</p>';
                    mhtml+='<small class="'+ color +'">Services: <b>'+ data[x]['Services'] +'</b></small>';
                    mhtml+='</div>';
                    mhtml+='</div>';
                    mhtml+='</div>';
                    mhtml+='</div><!-- end col -->';
                    
                    if(color==='text-warning'){color='text-pink';}else if (color==='text-pink'){ color='text-custom';}else if(color==='text-custom'){color='text-success';}else if (color==='text-success'){color='text-warning';}
                    
                    if(x===3){thtml+="<div class='item active'><h4>Excellent . . .</h4>"+mhtml +"</div>"; mhtml='';}
                    else if(x===7 || x===l && x<9) {thtml+="<div class='item'><h4>Good . . .</h4>"+mhtml +"</div>"; mhtml='';}
                    else if(x===11 || x===l && x>8) {thtml+="<div class='item'><h4>Satisfactory . . .</h4>"+mhtml +"</div>"; mhtml='';}
                    
                    
                } 
                //console.log(thtml);
                if(l<3){
                    $("#top-staff").html(thtml);
                    $("#carousel-example-generic").hide();
                }else {
                    $("#top-staff-scroll").html(thtml);
                
                     $('.carousel').carousel({
                            interval: 19000,
                            pause: 'hover'
                    });
                }
            }

        });
    }
    
    
    function uninvoiced_visits(){
         $.ajax({
            type: "GET",
            url: "dashboard_controller/uninvoiced",
            data: {  },
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {  
                mhtml='';
                color='text-warning';
                
                for (x = 0; x < data.length; x++) {  
                    
                    mhtml+='<tr >';
                    mhtml+='<td>'+ data[x]['id_customer_visits'] +'</td>';
                    mhtml+='<td><strong class="'+data[x]['color']+ '">'+ data[x]['customer_visit_date'] +'<strong></td>';
                    mhtml+='<td>'+ data[x]['customer_name'] +'</td>';
                    mhtml+='<td><span class="label label-danger">'+ data[x]['services'] +'</span></td>';
                    mhtml+='<td><form method="post" action="<?php echo base_url();?>scheduler"><input type="hidden" name="csrf_test_name" value="'+ $('#cook').val() +'"><input name="defaultDate" type="hidden" value="'+ data[x]['date1'] +'" /><button type="submit" class="btn btn-icon waves-effect waves-light btn-info btn-xs m-b-5">open</button></form></td>';
                    mhtml+='</tr>';                    


                } 
                $("#uninvoiced tbody").append(mhtml);

            }

        });
    }
    
    function grossing_services(){
        var mData=[];
        var total=0;
         $.ajax({
            type: "GET",
            url: "dashboard_controller/grossing_services",
            data: {  },
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                 
            
                for (x = 0; x < data.length; x++) {  
                    //var mObject = {name: data[x]['name'], y: parseFloat(data[x]['y'])};
                    var mObject = {name: data[x]['name'].substring(0,29), y: parseFloat(data[x]['y'])};
                    
                    mData[x]=mObject;
                    total = total + parseInt(data[x]['paid']);
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
    
   function out_of_stock_count(){
       
        $.ajax({
            type: "GET",
            url: "dashboard_controller/out_of_stock_count",
            data: {  },
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {  
                for (x = 0; x < data.length; x++) {  
                    toastr.info(data[x]['thresholdcount']+' products are running LOW in stocks!!!');
                    
                } 
                
            }

        });
   }
    
    function expiring(){
       
        $.ajax({
            type: "GET",
            url: "dashboard_controller/expiring_products_count",
            data: {  },
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {  
                
                for (x = 0; x < data.length; x++) { 
                    toastr.error(data[x]['expiring']+' products are expired or approaching expiry within 3 months!!!');
                } 
                
            }

        });
   }
    
</script>