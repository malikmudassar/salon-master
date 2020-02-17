<script>
    
    $(document).ready(function(){
        
        var calendar = $('#calendar').fullCalendar({
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            defaultView: 'timelineDay',
            timeFormat: 'H:mm',
            slotLabelFormat:"HH:mm",
            slotDuration: '00:15', /* If we want to split day time each 15minutes */
            minTime: '10:00:00',
            maxTime: '20:00:00',
            //defaultDate: '2014-02-01',
            editable: true,
            allDaySlot: false,
            selectable: true,
            eventLimit: true, // allow "more" link when too many events
            
            resourceAreaWidth: '10%',
            resourceLabelText: 'Staff List',
            
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'timelineDay,agendaWeek,month'
            },
            
            resourceRender: function(resourceObj, labelTds, bodyTds) {
                $.ajax({
                    url: '<?php echo base_url().'Scheduler_controller/getStaffImages'; ?>',
                    data: 'staff_id='+resourceObj.id,
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
                            'background-position':'center'
                        });
                    }
                    
                });
            },

            resources: [
                <?php echo $resources; ?>
            ],
            
            events: [
                <?php echo $events; ?>
            ],
            
            eventClick: function(calEvent, jsEvent, view) {
                
                $('#visit-services-change-categories').html('');
                $('#visit-services-change').html('');
                $('#haircolordiv2').hide();
                $('#color-type2').html('');
                $('#color-number2').html('');
                $('#color-duration2').val('0:00');
                $('#color-cost2').val('0');
                
                getservicestochange();
                colortypeschange();
                
                $.ajax({
                    url: 'Scheduler_controller/getvisitdetails',
                    data: 'visit_service_id=' +calEvent.id,
                    type: 'POST',
                    success: function(response){

                        var data = $.parseJSON(response);

                        $('#eventcustomer').html('');
                        $('#eventstaff').html('');
                        $('#eventcategory').html('');
                        $('#eventservice').html('');
                        $('#eventstart').html('');
                        $('#eventend').html('');
                        
                        if(data[0].visit_status === "invoiced"){
                            $('#btngeninvoice').hide();
                            $('#btnchngservice').hide();
                            $('#btncancelservice').hide();
                            $('#btncancelvisit').hide();
                            $('#chngeservice').hide();
                        } else{
                            $('#btngeninvoice').show();
                            $('#btnchngservice').show();
                            $('#btncancelservice').show();
                            $('#btncancelvisit').show();
                            $('#chngeservice').show();
                        }

                        var startdt = data[0].visit_service_start;
                        startdt = startdt.split("T");

                        var startdate = startdt[0].replace(/-/g, '/');
                        var starttime = startdt[1];

                        var enddt = data[0].visit_service_end;
                        enddt = enddt.split("T");

                        var enddate = enddt[0].replace(/-/g, '/');
                        var endtime = enddt[1];

                        $('#eventcustomer').html(data[0].customer_name);
                        $('#eventstaff').html(data[0].staff_names);
                        $('#eventcategory').html(data[0].service_category);
                        $('#eventservice').html(data[0].service_name);
                        $('#eventstart').html(startdate+ " - " +starttime);
                        $('#eventend').html(enddate+ " - " +endtime);
                        $('#visit-id').val(data[0].customer_visit_id);
                        $('#hair_staff_id').val(data[0].staff_ids);
                        $('#hair_staff_name').val(data[0].staff_names);
                        $('#hair_customer_id').val(data[0].id_customers);
                        $('#hair_customer_name').val(data[0].customer_name);
                        
                        $('#btncancelservice').attr('visit_service_id', calEvent.id);
                        $('#btncancelvisit').attr('visit_service_id', calEvent.id);
                        $('#btnchngservice').attr('visit_service_id', calEvent.id);

                        $('#eventview').modal('show');

                    }
                });

            },
            
            eventResize: function(event, delta, revertFunc, jsEvent, ui, view) {
                
                if(view.name === "timelineDay"){
                    
                    $.ajax({
                        url: 'Scheduler_controller/updatevisit',
                        data: 'id_visit_services=' +event.id+ '&staff_id=' +event.resourceId+ '&start=' +event.start.format()+ '&end=' +event.end.format(),
                        type: 'POST',
                        success: function(response){

                            if(response == 'success'){

                                toastr.success('Visit timing resized!', 'Done!');

                            } else {

                                swal({
                                    title: "eventResize Error",
                                    text: response,
                                    type: "error",
                                    confirmButtonText: 'OK!'
                                });

                            }

                        }
                    });
                    
                } else{
                    event.editable = FALSE;
                }
                
            },
            
            eventDrop: function(event, delta, revertFunc, jsEvent, ui, view) {
                
                if(view.name === "timelineDay"){
                
                    $.ajax({
                        url: 'Scheduler_controller/updatevisit',
                        data: 'id_visit_services=' +event.id+ '&staff_id=' +event.resourceId+ '&start=' +event.start.format()+ '&end=' +event.end.format(),
                        type: 'POST',
                        success: function(response){

                            if(response == 'success'){

                                toastr.success('Visit staff changed!', 'Done!');

                            } else {

                                swal({
                                    title: "eventDrop Error",
                                    text: response,
                                    type: "error",
                                    confirmButtonText: 'OK!'
                                });

                            }

                        }
                    });
                
                } else{
                    event.editable = FALSE;
                }
                
            },
            
            select: function(start, end, jsEvent, view, resource) {
                
                if(view.name === 'timelineDay'){
                    
                    $('#visit-services-categories').html('');
                    $('#visit-services').html('');
                    $('#haircolordiv').hide();
                    $('#haircolordiv2').hide();
                    
                    $('#visit-services-change-categories').html('');
                    $('#visit-services-change').html('');
                    $('#color-type').html('');
                    $('#color-number').html('');
                    $('#color-duration').val('0:00');
                    $('#color-cost').val('0');
                    
                    $('#name-search').val('');
                    $('#cell-search').val('');
                    $('#newcustomeradding').hide();
                    $("#divmain").hide();
                    $("#divvisit").hide();
                    $("#multiplesearch").hide();
                    $("#con-close-modal").hide();
                    $("#add-appointment-modal").hide();

                    clearcustomerform();
                    
                    getservices();
                    getservicestochange();
                    colortypes();

                    localStorage.setItem("staff_id", "");
                    localStorage.setItem("staff_name", "");
                    localStorage.setItem("start", "");
                    localStorage.setItem("end", "");
                    localStorage.setItem("date", "");
                    localStorage.setItem("year", "");
                    localStorage.setItem("month", "");
                    localStorage.setItem("day", "");
                    localStorage.setItem("hours", "");
                    localStorage.setItem("minutes", "");
                    localStorage.setItem("seconds", "");
                    localStorage.setItem("time", "");

                    localStorage.setItem("staff_id", resource.id);
                    localStorage.setItem("staff_name", resource.title);
                    localStorage.setItem("start", start.format());
                    localStorage.setItem("end", end.format());
                    localStorage.setItem("date", start.format('YYYY-MM-DD'));
                    localStorage.setItem("year", start.format('YYYY'));
                    localStorage.setItem("month", start.format('MMMM'));
                    localStorage.setItem("day", start.format('dddd'));
                    localStorage.setItem("hours", start.format('hh'));
                    localStorage.setItem("minutes", start.format('mm'));
                    localStorage.setItem("seconds", start.format('ss'));
                    localStorage.setItem("time", start.format('HH:mm:ss'));
                    
                    $('#visit-staff').val(localStorage.getItem('staff_name'));
                    $('#visit-staff-id').val(localStorage.getItem('staff_id'));
                    $('#event-modal').modal('show');
                    
                }

            },
            
            dayClick: function(date, jsEvent, view, resource) {
                
                if (view.name === "month") {
                    $('#calendar').fullCalendar('gotoDate', date);
                    $('#calendar').fullCalendar('changeView', 'agendaDay');
                }
        
            }
           
        });
        
    });
    
</script>