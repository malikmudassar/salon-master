<script>
    
    function showCalendarOverlay(){
        var h = $('#calendar').height();
        var w = $('#calendar').width();
        $('#calendarOverlay').css({
            'width' : w + 16,
            'height' : h
        });
        $('#calendarOverlay').show();
    }
    
    function hideCalendarOverlay(){
        $('#calendarOverlay').css({
            'display' : 'none'
        });
    }
        
    $(window).load(function(){
        jQuery('#datepicker').datepicker({
                autoclose: true,
                todayHighlight: true
            });
          
            
            
        jQuery('#change_date').datepicker({
                autoclose: true,
                todayHighlight: true,
                format:'yyyy-mm-dd'
            });
        var view_style = "timelineDay";
        
       // get_services();
        
        var oldResourceId = null;
        var oldStart = null;
        var calendar = $('#calendar').fullCalendar({
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            defaultView: 'timelineDay',
            <?php echo isset($defaultDate) && !empty($defaultDate) ? "defaultDate: '".$defaultDate."'," : ""; ?>
            //defaultDate: '2016-11-12',
            titleFormat: 'dddd, MMM DD, YYYY',
            timeFormat: 'h:mm',
            slotLabelFormat:"hh:mm",
            displayEventTime : false,
            slotDuration: '00:15', /* If we want to split day time each 15minutes */
            slotLabelInterval: '00:15',
            slotMinutes: 05,
            minTime: '<?php echo $time->business_opening_time; ?>:00',
            maxTime: '<?php echo $time->business_closing_time; ?>:00',
            height: $(window).height() - 200,
            lazyFetching: false,
            dayOfMonthFormat: 'dddd DD/MM',
            editable: false,
            allDaySlot: false,
            selectable: true,
            eventLimit: true, // allow "more" link when too many events
            slotWidth: 45,
            nowIndicator : true,
            resourceAreaWidth: '10%',
            resourceLabelText: 'Staff List',
            
            header: {
                left: 'prev,next today',
                center: 'title',
                right: ''+view_style+', agendaWeek, month'
            },
            
            resourceRender: function(resourceObj, labelTds, bodyTds) {
                $.ajax({
                    url: '<?php echo base_url().'Scheduler_controller/getStaffImages'; ?>',
                    data: {
                        staff_id:resourceObj.id
                    },
                    type: 'POST',
                    success: function(response){
                        //var base_url = '<?php echo base_url(); ?>';
                        labelTds.css({
                            'cursor':'pointer',
                            'background-image':'url('+response+')',
                            'background-color':'#fff',
                            'background-size':'50px 50px',
                            'background-repeat':'no-repeat',
                            'height': '105px',
                            'color':'#808080',
                            'font-size': '12px',
                            'text-align':'center',
                            'background-position':'center',
                            'overflow': 'hidden'
                        });
                    }
                    
                });
            },

            resources: [
                <?php echo $resources; ?>
            ],
            
            events: function(start, end, timezone, callback) {
                
               // $('#last_update_date').val('');
                
                showCalendarOverlay();
                        
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url().'Scheduler_controller/getAllVisitsByDate'; ?>',
                    data: {
                        start: start.format('YYYY-MM-DD'),
                        end: end.format('YYYY-MM-DD'),
                        previous: '<?php echo $time->previous; ?>'
                    },
                    success: function(response){
                        
                        var data = $.parseJSON(response);
                        var events = [];
                        var customervisits = [];
                        var resourceIds=[];
                        
                        
                        if(data['visit_events'].length > 0){
                            
                            var update_date = "";
                            var last_color_code = "";
                            
                            for(var k = 0; data['visit_events'].length > k; k++){
                                
                                //console.log(data['visit_events'][k]);
                                
                                for(var i = 0; data['visit_events'][k].length > i; i++){
                                
                                    var type = data['visit_events'][k][i].visit_status === 'invoiced' ? 'Invoiced' : 'Visit';
                                    
                                    var eventId = data['visit_events'][k][i].id_visit_services+data['visit_events'][k][i].id_customer_visits;
                                    var visitserviceid=data['visit_events'][k][i].id_visit_services;
                                    var resourceId = data['visit_events'][k][i].staff_id;
                                    var title = data['visit_events'][k][i].customer_name +' - '+ data['visit_events'][k][i].service_category +' - '+ data['visit_events'][k][i].service_name;
                                    var bgColor = type === 'Invoiced' ? '#CCCCCC' : data['visit_events'][k][i].visit_color;
                                    var textColor = data['visit_events'][k][i].visit_color_type === 'Dark' ? (type === 'Invoiced' ? '#000000' : '#ffffff') : '#000000';
                                    var editable =  false;
                                    var invoicedClass = type === 'Invoiced' ? 'event-invoiced' : '';
                                    var startDate = data['visit_events'][k][i].visit_service_start;
                                    var endDate = data['visit_events'][k][i].visit_service_end;
                                    
                                    var border = '#000';
                                    var inservice="";
                                    if(data['visit_events'][k][i].inservice=='Yes' && type !== 'Invoiced'){
                                        if(textColor == "#000000"){
                                            border = 'red';
                                        } else {border='yellow';}
                                        inservice="cut";
                                    }
                                    
                                    var requested="";
                                    if(data['visit_events'][k][i].requested==='Yes' && type !== 'Invoiced'){
                                        
                                        requested="zmdi zmdi-check";;
                                    }
                                    
                                    var flag=''; var flagcolor='';
                                    if(data['visit_events'][k][i].customer_type === 'red'){
                                        flag="zmdi zmdi-flag";
                                        flagcolor="red";
                                    }else if(data['visit_events'][k][i].customer_type === 'orange'){
                                        flag="ti-star";
                                        flagcolor="orange";
                                    }else if(data['visit_events'][k][i].customer_type === 'green'){
                                        flag="zmdi zmdi-flag";
                                        flagcolor="green";
                                    }
                                    
                                    var stricttime='';
                                    if (data['visit_events'][k][i].reminder_stricttime === 'Y'){
                                        stricttime="time";
                                    }
                                    
                                    var advance='';
                                    if (data['visit_events'][k][i].advance === 'true'){
                                        advance="money";
                                    }
                                    var sms='';
                                    if (data['visit_events'][k][i].reminder_sms==='Y'){
                                        sms="comment-outline";
                                    }
                                    var call='';
                                    if (data['visit_events'][k][i].reminder_call==='Y'){
                                        call="phone";
                                    }
                                    var email='';
                                    if (data['visit_events'][k][i].reminder_email==='Y'){
                                        email="email";
                                    }
                                   
                                    events.push({
                                        id: eventId,
                                        resourceId: resourceId,
                                        editable: editable,
                                        title: title,
                                        backgroundColor: bgColor,
                                        textColor: textColor,
                                        borderColor: border,
                                        className: invoicedClass,
                                        start: startDate,
                                        end: endDate,
                                        advance: advance,
                                        sms : sms,
                                        call: call,
                                        email: email,
                                        flag: flag,
                                        flagcolor: flagcolor,
                                        stricttime: stricttime,
                                        inservice: inservice,
                                        requested: requested,
                                        visitserviceid: visitserviceid
                                    });
                                    
                                    if(data['visit_events'][k][i].most_update_date){
                                        update_date = data['visit_events'][k][i].most_update_date;
                                    }
//                                    last_color_code = data['visit_events'][k][i].visit_color;
                                    //console.log(update_date);
                                    
                                }
                                
                            }
                            <?php if($this->session->userdata('role')!=="Reception" && $this->session->userdata('role')!=="Board"){?>
                                $('#totalvisits').html(data['service_count']  + ' &asymp; ' + data['service_forecast'] + ' &imof; Appointments = ' + data['visit_count']);
                            <?php } else { ?>
                                
                                $('#totalvisits').html(data['service_count']  + ' &imof; Appointments = ' + data['visit_count']);
                            <?php } ?>
                            if(update_date!=''){
                                $('#last_update_date').val(update_date);
                            }
                            $('#last_color_code').val(data['visit_last_color']);
                            
                            $('#calendar').fullCalendar('removeEvents');
                            
                        }else{
                            $('#totalvisits').html('');
                            $('#totalvisits').text(0);
                        }
                        if(data['block_events'].length > 0){
                            for(var i = 0; data['block_events'].length > i; i++){
                                events.push({
                                    id: data['block_events'][i].block_time_event_id,
                                    resourceId: data['block_events'][i].staff_id,
                                    editable: true,
                                    title: 'Blocked: ' + data['block_events'][i].block_event_name,
                                    backgroundColor: '#333',
                                    borderColor: '#000',
                                    textColor: '#ffffff',
                                    className: 'block_event',
                                    start: data['block_events'][i].start_time,
                                    end: data['block_events'][i].end_time
                                });
                            }
                        }
                        callback(events);
                        customCalendarView();
                        hideCalendarOverlay();
                    }
                });
                
                
            },
            
            eventClick: function(calEvent, jsEvent, view) {
               

            },
            
            eventResizeStart: function(event) {
                
            },
            
            eventResize: function(event, delta, revertFunc, jsEvent, ui, view) {
                
              
                
            },
            eventMouseover: function(calEvent, jsEvent) {
                var mTitle=calEvent.title.split('-');
                var tooltip = '<div class="tooltipevent" style="width:220px;height:50px;background:#23527c;color:#fff; padding:5px; position:absolute;z-index:10090;">' + mTitle[0]+' - '+ mTitle[1]+' - '+mTitle[2] + '</div>';
                var $tooltip = $(tooltip).appendTo('body');

                $(this).mouseover(function(e) {
                    $(this).css('z-index', 10000);
                    $tooltip.fadeIn('500');
                    $tooltip.fadeTo('10', 1.9);
                }).mousemove(function(e) {
                    $tooltip.css('top', e.pageY + 30);
                    $tooltip.css('left', e.pageX - 100);
                });
            },

            eventMouseout: function(calEvent, jsEvent) {
                $(this).css('z-index', 8);
                $('.tooltipevent').remove();
            },
            eventDragStart: function(event) {
                
               
            },
            
            eventDrop: function(event, delta, revertFunc, jsEvent, ui, view) {
                
            },
            
            select: function(start, end, jsEvent, view, resource) {
                
            },
            
            dayClick: function(date, jsEvent, view, resource) {
                if (view.name === "agendaWeek" || view.name === 'month') {
                    $('#calendar').fullCalendar('gotoDate', date);
                    $('#calendar').fullCalendar('changeView', view_style);
                }
            },
            eventRender: function(event, element) {
                //console.log(event);
                var nextline=false;
                var icons='';
                if(event.flag && event.flag!==''){          
                   icons += "<i style='padding:2px;background:#fff; color:"+event.flagcolor+";' class='"+event.flag+"'></i> - ";
                  // nextline=true;
                }
                if(event.stricttime && event.stricttime!==''){          
                   icons += "<i style='padding:2px;color:red; background:#fcfcfc' class='zmdi zmdi-"+event.stricttime+"'></i> - ";
                  // nextline=true;
                }
                
                if(event.advance && event.advance!==''){          
                   icons += "<i style='color:"+event.textColor+";' class='zmdi zmdi-"+event.advance+"'></i> - ";
                  // nextline=true;
                }
                
                if(event.requested && event.requested!==''){          
                   icons += "<i style='color:"+event.textColor+";' class='zmdi zmdi-"+event.requested+"'></i> - ";
                  // nextline=true;
                }
                
                if(event.inservice && event.inservice!==''){
                    
                    if(event.textColor == "#000000"){
                        icons += "<i style='color:red;' class='fa fa-spin fa-"+event.inservice+"'></i> ";
                    } else {
                        icons += "<i style='color:yellow;' class='fa fa-spin fa-"+event.inservice+"'></i> ";
                    }
                  // nextline=true;
                }
                if(event.sms && event.sms!==''){          
                   icons += "<i style='color:"+event.textColor+";' class='zmdi zmdi-"+event.sms+"'></i> ";
                  // nextline=true;
                }
                if(event.call && event.call!==''){          
                   icons += "<i style='color:"+event.textColor+";' class='zmdi zmdi-"+event.call+"'></i> ";
                 //  nextline=true;
                }
                if(event.email && event.email!==''){          
                   icons += "<i style='color:"+event.textColor+";' class='zmdi zmdi-"+event.email+"'></i> ";
                  // nextline=true;
                }
                if (nextline===true){
                    element.find(".fc-title").prepend(icons + "<br/> ");
                } else {
                    element.find(".fc-title").prepend(icons + ' - ');
                }
             }    
           
        });
        
        setInterval(function(){
        
            var view = $('#calendar').fullCalendar('getView');
            //if(view.name === view_style){
                newEvents();
               // customCalendarView();
            //}
        }, 30000);
       
    });
    
    $(window).on('load', function() {
        $('#calendar').fullCalendar('render');
        max();
        $('html, body').css({
            'overflow': 'hidden',
            'height': '100%'
        });
    });
    
    function customCalendarView(){
        
//        var today = new Date();
//        var h = today.getHours();
//        var m = today.getMinutes();
//        var s = today.getSeconds();
//        
//        if (h < 10) {h = "0" + h;}
//        if (m < 10) {m = "0" + m;}
//        if (s < 10) {s = "0" + s;}
//       
//        var current=false;
//        $('.fc-widget-content').css({'background-color':'transparent'}); //first set all to transparent
//        $.each($('.fc-slats tr'), function(index1, value1){ //find current time
//            
//            var data_time1 = $(this).attr('data-time');
//            
//            var data_time = data_time1.split(":");
//            if(data_time[1]=="00"){
//                $(this).css({'font-weight':'bold'});
//            }
//            
//            if(h==data_time[0] && parseInt(m) >= parseInt(data_time[1]) && parseInt(m) < parseInt(data_time[1])+15 && current==false){
//                $(this).find('.fc-widget-content').css({'background-color':'rgba(255, 0, 0, 0.1)'});
//                current=true;
//            }
//            
//        });
    }
    
</script>
