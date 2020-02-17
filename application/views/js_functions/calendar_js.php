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
        var view_style = "<?php echo $scheduler_style[0]['scheduler_style']; ?>";
        
       // get_services();
        
        var oldResourceId = null;
        var oldStart = null;
        var calendar = $('#calendar').fullCalendar({
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            defaultView: view_style,
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
            height: $(window).height() - 250,
            lazyFetching: false,
            dayOfMonthFormat: 'dddd DD/MM',
            editable: true,
            allDaySlot: false,
            selectable: true,
            eventLimit: true, // allow "more" link when too many events
            slotWidth: 60,
            nowIndicator : true,
            resourceAreaWidth: '10%',
            resourceLabelText: 'Staff List',
            
            header: {
                left: 'prev,next today',
                center: 'title',
                right: ''+view_style+', agendaWeek, month'
            },
            
            resourceRender: function(resourceObj, labelTds, bodyTds) {
                //console.log(resourceObj);
                $.ajax({
                    url: '<?php echo base_url().'Scheduler_controller/getStaffImages'; ?>',
                    data: {
                        staff_id:resourceObj.id
                    },
                    type: 'POST',
                    success: function(response){
                        //var base_url = '<?php echo base_url(); ?>';
                        
                        if(resourceObj.title==="NoShow Cancellations"){
                            labelTds.css({
                                'cursor':'pointer',
                                //'background-image':'url('+response+')',
                                'background-color' : 'rgba(255, 138, 204, 0.15) !important',
                                'background-size':'50px 50px',
                                'background-repeat':'no-repeat',
                                'height': '105px',
                                'color':'#ff8acc !important',
                                'font-size': '12px',
                                'text-align':'center',
                                'background-position':'center',
                                'overflow': 'hidden'
                            });
                            
                            bodyTds.css('background-color' , 'rgba(249, 200, 81, 0.15) !important');
                        } else if (resourceObj.title==="Waiting List"){
                            labelTds.css({
                                'cursor':'pointer',
                                //'background-image':'url('+response+')',
                                'background-color' : 'rgba(249, 200, 81, 0.15) !important',
                                'background-size':'50px 50px',
                                'background-repeat':'no-repeat',
                                'height': '105px',
                                'color':'#f9c851 !important',
                                'font-size': '12px',
                                'text-align':'center',
                                'background-position':'center',
                                'overflow': 'hidden'
                            });
                            bodyTds.css('background-color' , 'rgba(249, 200, 81, 0.15) !important');
                        } else if (resourceObj.staff_shared==="Yes"){
                            labelTds.css({
                                'cursor':'pointer',
                                'background-image':'url('+response+')',
                                'background-color' : 'rgba(249, 200, 81, 0.15) !important',
                                'background-size':'50px 50px',
                                'background-repeat':'no-repeat',
                                'height': '105px',
                                'color':'#808080',
                                'font-size': '12px',
                                'text-align':'center',
                                'background-position':'center',
                                'overflow': 'hidden'
                            });
                            bodyTds.css('background-color' , 'rgba(249, 200, 81, 0.15) !important');
                        
                        
                        } else {
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
                    async: true,
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
                            console.log(data['visit_events']);
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
                                    var editable = type === 'Invoiced' ? false : true;
                                    var invoicedClass = type === 'Invoiced' ? 'event-invoiced' : '';
                                    var sharedClass = data['visit_events'][k][i].block_other  ;
                                    var border = '#000';
                                    if(sharedClass=='Yes' && parseInt(data['visit_events'][k][i].business_id) !== <?php echo $this->session->userdata('businessid');?> ){
                                         editable=false;
                                        border = 'yellow';
                                        bgColor='#fff';
                                        textColor='Red';
                                        title=" ("+ data['visit_events'][k][i].business_name.toUpperCase() +")-"+title;
                                        
                                    }
                                    
                                    var startDate = data['visit_events'][k][i].visit_service_start;
                                    var endDate = data['visit_events'][k][i].visit_service_end;
                                    
                                    
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
                                    var promo='';
                                    if (data['visit_events'][k][i].promo === 'Yes'){
                                        promo="pinterest";
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
                                        promo: promo,
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
                             <?php if($this->session->userdata('role')!=="Sh-Users" && $this->session->userdata('role')!=="Reception" && $this->session->userdata('role')!=="Board" && $this->session->userdata('role')!=="Store Manager"){?>
                                $('#totalvisits').html(data['service_count'] + ' &asymp; ' + data['service_forecast'] + ' &imof; Appointments = ' + data['visit_count']);
                                //$('#totalvisits').html(data['service_count']  + ' &asymp; ' + data['service_forecast'] + ' &imof; Appointments = ' + data['visit_count']);
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
                //console.log(calEvent);
                var event_id= calEvent.id.substr(1, calEvent.id.length);
                var block=calEvent.id.substr(0, 1);
                if(block=== 'b'){
                    $.ajax({
                        url: '<?php echo base_url().'Scheduler_controller/getStaffDetails/'; ?>',
                        data:{staff_id: calEvent.resourceId, event_id:event_id},
                        type: 'POST',
                        success: function(response){
                            var data = $.parseJSON(response);
                            //console.log(data);
                            $('#block-staff').html(data.staff_fullname);
                            $('#block-event-id').val(calEvent.id);
                            $('#block-reason').html(calEvent.title);
                            $('#block-starttime').html((data.start_time).replace('T', ' '));
                            $('#block-endtime').html((data.end_time).replace('T', ' '));
                            $('#block-remarks').html(data.remarks);
                            $('#block_staff_modal').modal({
                                backdrop:'static',
                                keyboard:false,
                                show:true
                            });
                        }
                    });
                    return false;
                }
                
                if(calEvent.backgroundColor !== '#CCCCCC' && calEvent.backgroundColor !== '#fff'){
                    removeNiceScroll();
                    $('#event_visit_id').val('');
                    
                    $('#visit_block_btns').show();
                    $('#advance_block').show();
                    $('#reminder_alert').show();
                    
                    $('#visit_block1').hide();
                    $('#visit_block2').hide();
                    
                    $("#visit_services_categories").html('');
                    $("#visit_services ul").remove();
                    $("#visit_products ul").remove();
                    
                   // $(".nicescroll_service_types2").niceScroll({cursoropacitymin: 1});
                    $(".nicescroll_service_types2").getNiceScroll().remove();
                    get_services_types();
                   
                    
                    $.ajax({
                        url: '<?php echo base_url().'Scheduler_controller/getvisitdetails'; ?>',
                        data: {
                            visit_service_id:calEvent.visitserviceid
                        },
                        type: 'POST',
                        success: function(response){

                            var data = $.parseJSON(response);

                            if(data['visit'][0]['visit_status'] === 'invoiced' && calEvent.backgroundColor !== '#CCCCCC'){
                                $('#calendar').fullCalendar('refetchEvents');
                                return false;
                            }

                            localStorage.setItem('visit_services', JSON.stringify(data['services']));
                            localStorage.setItem('staff_id', data['visit'][0]['staff_id']);
                            localStorage.setItem('staff_name', data['visit'][0]['staff_name']);
                            localStorage.setItem('start', data['visit'][0]['visit_service_start']);
                            $("#visit-id").val(data['visit'][0]['id_customer_visits']);
                            $("#modal_visit_id").html(data['visit'][0]['id_customer_visits']);
                            $('#staff_visit_service_id').val(calEvent.visitserviceid);
                            $('#alreadyvisitid > strong').html(data['visit'][0]['id_customer_visits']);
                            $("#visit-customerid").val(data['visit'][0]['customer_id']);
                            $("#visit-customername").val(data['visit'][0]['customer_name']);
                            $("#visit-customercell").val(data['visit'][0]['customer_cell']);
                            $("#visit-customeremail").val(data['visit'][0]['customer_email']);
                            $('#visitcustomername').html(data['visit'][0]['customer_name']);
                            
                            var flag=""; var color="";
                            if(data['visit'][0]['customer_type']=="red"){flag="zmdi zmdi-flag txt-danger"; color="red";}
                            else if(data['visit'][0]['customer_type']=="orange") {flag="ti-star";color="orange";}
                            else if(data['visit'][0]['customer_type']=="green") {flag="zmdi zmdi-flag";color="green";}
                            
                            $('#visitcustomertype').html('<i style="color:'+color+';" class="'+flag+'"></i>');
                            $('#visitcustomercell').html(data['visit'][0]['customer_cell']);
                            $('#btncancelservice').attr('visit_service_id', calEvent.visitserviceid);
                            $('#btncancelservice').attr('visit_service_name', calEvent.title);
                            
                            $("#cd_visit_service_id").val(calEvent.visitserviceid);
                             $("#cd_visit_id").val(data['visit'][0]['id_customer_visits']);
                            
                            $('#cs_visit_service_staff_id').val(data['visit'][0]['id_visit_service_staffs']);
                            
                            $("#visit_color_picker").val(data['visit'][0]['visit_color']);
                            
                            $("#sms_visit_id").val(data['visit'][0]['id_customer_visits']);
                            $("#sms_staff_name").val(data['visit'][0]['staff_name']);
                            $("#sms_visit_service_start").val( data['visit'][0]['visit_service_start']);
                            $("#sms_service_category").val(data['visit'][0]['service_category']);
                            $("#sms_service_name").val(data['visit'][0]['service_name']);
                            $("#sms_customer_name").val(data['visit'][0]['customer_name']);
                            $("#sms_customer_cell").val(data['visit'][0]['customer_cell']);
                            
                            getAdditionalStaff();
                            
                            //This below function work for already customer event exist when click it shows balance..If condition for alergies message
                            get_customerbalance_exist_event(data['visit'][0]['customer_id']);
                            if (data['visit'][0]['customer_allergies'] !== "" || data['visit'][0]['customer_alert'] !== "") {
                                $("#alert_text_exist").html('<strong>Customer Alert! Allergic to :</strong> ' + data['visit'][0]['customer_allergies'] + ' | <strong>Other Alerts : </strong>' + data['visit'][0]['customer_alert']);
                                $("#customer_alert_exist").show();
                            }else{
                                $("#customer_alert_exist").hide();
                            }
                            //This above function work for already customer event exist when click it shows balance..If condition for alergies message
                            if(data['visit'][0]['reminder_stricttime'] === "Y"){
                                $('#reminder_alert #reminder_stricttime').prop( "checked", true );
                            }else{
                                $('#reminder_alert #reminder_stricttime').prop( "checked", false );
                            }
                            if(data['visit'][0]['requested'] === "Yes"){
                                $('#reminder_alert #reminder_requested').prop( "checked", true );
                            }else{
                                $('#reminder_alert #reminder_requested').prop( "checked", false );
                            }
                            if(data['visit'][0]['reminder_sms'] === "Y"){
                                $('#reminder_alert #reminder_sms').prop( "checked", true );
                            }else{
                                $('#reminder_alert #reminder_sms').prop( "checked", false );
                            }
                            
                            if(data['visit'][0]['reminder_call'] === "Y"){
                                $('#reminder_alert #reminder_call').prop( "checked", true );
                            }else{
                                $('#reminder_alert #reminder_call').prop( "checked", false );
                            }
                            
                            if(data['visit'][0]['reminder_email'] === "Y"){
                                $('#reminder_alert #reminder_email').prop( "checked", true );
                            }else{
                                $('#reminder_alert #reminder_email').prop( "checked", false );
                            }
                            
                            if(data['visit'][0]['promo'] === "Yes"){
                                $('#reminder_alert #reminder_promo').prop( "checked", true );
                            }else{
                                $('#reminder_alert #reminder_promo').prop( "checked", false );
                            }
                            
                            $('#visit_block_btns #advance_amount').val('');
                            $('#visit_block_btns #advance_mode').val('cash');
                            $('#visit_block_btns #advance_inst').val('');
                            $('#visit_block_btns #advance_comment').val('');
                            $('#visit_block_btns #advance_inst_div').hide();
                            /////////////New Advances//////////////
                            if(data['advances'].length>0){
                                
                                var html=''; var fhtml=''; var total_adv=0;
                                for (var x = 0; x < data['advances'].length; x++) {
                                    html +='<tr><td>Adv.</td><td>'+ data['advances'][x]['date'] +'</td><td style="text-align:right;">'+ data['advances'][x]['advance_amount'] +'</td><td><button type="button" class="btn btn-sm btn-default" onclick="removeadvance('+ data['advances'][x]['id_visit_advance'] +');" class="text-danger"><i class="ti-close"></i></button></td></tr>';
                                    total_adv=total_adv+parseFloat(data['advances'][x]['advance_amount']);
                                }
                                $("#adv_table tbody").html(html);
                                fhtml +='<tr><td></td><td style="font-weight:bold;">Total Advance:</td><td style="font-weight:bold; text-align:right;">'+ total_adv.toFixed(2) +'</td><td></td></tr>';
                                $("#adv_table tfoot").html(fhtml);
                            } else {
                                $("#adv_table tbody").html('');
                                $("#adv_table tfoot").html('');
                                
                            }
                            
                           

                            //check loyalty service
                            if(data['services'][0]['loyalty_service'] === 'Y'){
                                $("#btnaddmoreservices").hide();
                                $("#btnaddadditionalstaff").hide();
                            } else {
                                $("#btnaddmoreservices").show();
                                $("#btnaddadditionalstaff").show();
                            }
                            
                            //check future appointment
                            //btngenerateinvoice
                            var d = new Date();
                           
//                            var datestring = d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-"  + 
//                                   ("0" + d.getDate()).slice(-2) + "T" + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2);
                            var datestring = d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-"  + ("0" + d.getDate()).slice(-2);
                           var newEventDate = calEvent.start.format().split('T');
                            
                            //if(calEvent.start.format() > datestring){
                            if(newEventDate[0] > datestring){$("#btngenerateinvoice").hide();} else {$("#btngenerateinvoice").show();}
                            
                            $('#customer_visit_id_reminder').val(data['visit'][0]['id_customer_visits']);
                            $('#id_visit_service_reminder').val(data['visit'][0]['id_visit_services']);
                            $('#id_visit_service_staff_reminder').val(data['visit'][0]['id_visit_service_staffs']);
                             $('#txtvisitremarks').val(data['visit'][0]['advance_comment']);
                            
                            $('#eventview').modal({
                                backdrop:'static',
                                keyboard:false,
                                show:true
                            });
                           
                        }
                    });

                } else{
                    
                    $.ajax({
                        url: '<?php echo base_url().'Scheduler_controller/getvisitinvoiceid'; ?>',
                        data: {
                            visit_service_id:calEvent.visitserviceid
                        },
                        type: 'POST',
                        success: function(response){
                            
                            var data = response.split('|');
                            if(data[0] === 'success'){
                                window.open('<?php echo base_url().'existinginvoice/'; ?>' + data[1] + '', '_blank');
                                return false;
                            }

                        }
                    });
                }

            },
            
            eventResizeStart: function(event) {
                oldResourceId = event.resourceId;
            },
            
            eventResize: function(event, delta, revertFunc, jsEvent, ui, view) {
                console.log(event);
                if(view.name === view_style || view.name === "agendaWeek"){
                    
                    if(event.className[0] === 'block_event'){
                        $.ajax({
                            url: '<?php echo base_url().'Scheduler_controller/updateBlockEvent'; ?>',
                            data: {
                                block_time_event_id:event.id,
                                staff_id:event.resourceId,
                                start:event.start.format(),
                                end:event.end.format()
                            },
                            type: 'POST',
                            success: function(response){

                                var result = response.split('|');

                                if(result[0] === "success"){

                                    $('#last_update_date').val(result[1]);
                                    toastr.success('Block timing resized!', 'Done!');

                                } else {

                                    swal({
                                        title: "eventResize Error",
                                        text: result[0],
                                        type: "error",
                                        confirmButtonText: 'OK!'
                                    });

                                }

                            }
                        });
                    } else{
                        $.ajax({
                            url: '<?php echo base_url().'Scheduler_controller/updatevisit'; ?>',
                            data: {
                                id_visit_services:event.visitserviceid,
                                staff_id:event.resourceId,
                                old_staff_id:oldResourceId,
                                start:event.start.format(),
                                end:event.end.format()
                            },
                            type: 'POST',
                            success: function(response){

                                var result = response.split('|');

                                if(result[0] === "success"){
                                    if(view.name === view_style){
                                        newEvents(1);
                                        customCalendarView();
                                    }

                                    $('#last_update_date').val(result[1]);
                                   // $('#calendar').fullCalendar('refetchEvents');
                                    toastr.success('Visit timing resized!', 'Done!');

                                } else {

                                    swal({
                                        title: "eventResize Error",
                                        text: result[0],
                                        type: "error",
                                        confirmButtonText: 'OK!'
                                    });

                                }

                            }
                        });
                    }
                    
                } else{
                    event.editable = FALSE;
                }
                
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
                
                oldResourceId = event.resourceId;
                oldStart = event.start.format();
            },
            
            eventDrop: function(event, delta, revertFunc, jsEvent, ui, view) {
                
                //console.log("old start :" + oldStart);
                //console.log("new start :" + event.start._i);
                //console.log(event.start.format());
                var _requested=false;
                var _stricttime=false;
                
                if(typeof event.requested !== 'undefined' && event.requested !== ""){ _requested = true;}
                if(typeof event.stricttime !== 'undefined' && event.stricttime !== ""){ _stricttime = true;}
                
                if(_requested === true && oldResourceId !== event.resourceId){
                    swal({
                        title: "Requested for By the Customer",
                        text: "The Staff Member can not be changed for this service!",
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
                    revertFunc();
                }
                else if(_stricttime === true && oldStart !== event.start.format()){
                    swal({
                        title: "Strict Time Asked By the Customer",
                        text: "The Time for this service can not be changed!",
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
                    revertFunc();
                }
                else if(event.className[0] === 'block_event'){
                    $.ajax({
                        url: '<?php echo base_url().'Scheduler_controller/updateBlockEvent'; ?>',
                        data: {
                            block_time_event_id:event.id,
                            staff_id:event.resourceId,
                            start:event.start.format(),
                            end:event.end.format()
                        },
                        type: 'POST',
                        success: function(response){

                            var result = response.split('|');

                            if(result[0] === "success"){

                                $('#last_update_date').val(result[1]);
                                toastr.success('Block staff changed!!', 'Done!');

                            } else {

                                swal({
                                    title: "eventDrop Error",
                                    text: result[0],
                                    type: "error",
                                    confirmButtonText: 'OK!'
                                });

                            }

                        }
                    });
                } else{
                    var ee=event;
                    //console.log(ee);
                    $.ajax({
                        url: '<?php echo base_url().'Scheduler_controller/updatevisit'; ?>',
                        //data: 'id_visit_services=' +event.id+ '&staff_id=' +event.resourceId+ '&start=' +event.start.format()+ '&end=' +event.end.format(),
                        data: {
                            id_visit_services:event.visitserviceid,
                            staff_id:event.resourceId,
                            old_staff_id:oldResourceId,
                            start:event.start.format(),
                            end:event.end.format()
                        },
                        type: 'POST',
                        success: function(response){

                            var result = response.split('|');

                            if(result[0] === 'success'){
                                //$('#calendar').fullCalendar('refetchEvents');
                                var view = $('#calendar').fullCalendar('getView');
                                if(view.name === view_style){
                                    newEvents(1);
                                    customCalendarView();
                                }
                                $('#last_update_date').val(result[1]);
                                toastr.success('Visit staff changed!', 'Done!');

                            } else {

                                swal({
                                    title: "eventDrop Error",
                                    text: result[0],
                                    type: "error",
                                    confirmButtonText: 'OK!'
                                });

                            }
                        }
                    });
                }
                
            },
            
            select: function(start, end, jsEvent, view, resource) {
                if(view.name === view_style){
                    
                    $.ajax({
                        url: '<?php echo base_url().'Scheduler_controller/checkBlockTime'; ?>',
                        data: {
                            staff_id:resource.id,
                            start:start.format()
                        },
                        type: 'POST',
                        success: function(response){
                            if(response === 'success'){
                                swal({
                                    title: 'This staff time has been blocked!',
                                    text: '',
                                    type: 'error',
                                    confirmButtonText: 'OK!'
                                });
                                return false;
                            } else{
                                //console.log(jsEvent);
                                //console.log(jsEvent.target['className']);
                                var temp='';
                                
                                temp=jsEvent.target['className'];
                                
                                //console.log(temp);
                               // console.log(temp.indexOf("fc-scroller"));
                                if(temp.indexOf("fc-scroller")<0){
                                    localStorage.setItem('start', start.format());
                                    localStorage.setItem('start_date', start.format('YYYY-MM-DD'));
                                    
                                    open_services(resource.id, resource.title);
                                }

                            }
                        }
                    });
                    
                }
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
                
                if(event.promo && event.promo!==''){          
                   icons += "<i style='padding:2px;color:red; background:#fcfcfc'  class='zmdi zmdi-"+event.promo+"'></i> - ";
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
            if(view.name === view_style){
                newEvents(1);
                customCalendarView();
            }
        }, 120000);
        
    });
    
    $(window).on('load', function() {
        $('#calendar').fullCalendar('render');
        $('html, body').css({
            'overflow': 'hidden',
            'height': '100%'
        });
    });
    
    function customCalendarView(){
        
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        
        if (h < 10) {h = "0" + h;}
        if (m < 10) {m = "0" + m;}
        if (s < 10) {s = "0" + s;}
       
        var current=false;
        $('.fc-widget-content').css({'background-color':'transparent'}); //first set all to transparent
        $.each($('.fc-slats tr'), function(index1, value1){ //find current time
            
            var data_time1 = $(this).attr('data-time');
            
            var data_time = data_time1.split(":");
            if(data_time[1]=="00"){
                $(this).css({'font-weight':'bold'});
            }
            
            if(h==data_time[0] && parseInt(m) >= parseInt(data_time[1]) && parseInt(m) < parseInt(data_time[1])+15 && current==false){
                $(this).find('.fc-widget-content').css({'background-color':'rgba(255, 0, 0, 0.1)'});
                current=true;
            }
            
        });
    }
    
</script>
