<script>

    function generateInvoice() {
        $('#invoiceForm').submit();
    }
    
    function printadvance(){
        //if($("#advance_amount").val()!=='' && parseInt($("#advance_amount").val())>0){
       // //console.log($('#adv_table').find('tbody').children().length);
        if($("#adv_table tbody tr").length>0 || $("#advance_amount").val()!=='' ){    
            window.open('<?php echo base_url();?>invoice_controller/print_advance/'+ $('#visit-id').val());
        }
    }
    
    function showhideinst(){
    
        if($("#advance_mode option:selected").val()==="bank" || $("#advance_mode option:selected").val()==="card"){
            $("#advance_inst_div").show();
        } else {
            $("#advance_inst_div").hide();
        }
    }
    
    function takeadvance(){
        var advancedate='';
        var newtoday = new Date();
        var todaya = newtoday.getFullYear()+"-"+ (newtoday.getMonth()+1) +"-"+newtoday.getDate();
        var today = todaya;
        $.ajax({
                type: 'POST',
                url: "<?php echo base_url() . 'visits_controller/check_visit'; ?>",
                data:{visit_id: $('#visit-id').val()},
                dataType: "json",
                cache: false,
                async: true,
                success: function(data) {
                    if(data.length>0 && parseInt(data[0]['advance_amount'])>0){
                        ////console.log(data[0]['advance_date']);
                        var newadvancedate=new Date(data[0]['check_date']);
                        var advancedatea = newadvancedate.getFullYear()+"-"+ (newadvancedate.getMonth()+1) +"-"+newadvancedate.getDate();
                        ////console.log("raw "+ data[0]['check_date'] + " advance "+advancedatea+" today "+today);
                        advancedate=advancedatea;
                    }else {
                        advancedate=today;
                    }
                    
                    if(advancedate == today){ 
                        saveadvance(); 
                    } else {
                         swal({
                            title: 'You cannot change the Advance Amount taken on a previous date!',
                            text: 'This action is not allowed now!',
                            type: 'error',
                            confirmButtonText: 'OK!'
                        });
                    }
                }
            });
    
       
    }
    
    function saveadvance(){
        
            if($("#advance_amount").val()===''  || $("#advance_inst_div").is(":visible") && $("#advance_inst").val()==""){
                if($("#advance_amount").val()===''  ){
                    swal({
                        title: 'Please Enter Advance Amount!',
                        text: '',
                        type: 'error',
                        confirmButtonText: 'OK!'
                    });
                    $("#advance_amount").focus();
                } else if($("#advance_inst_div").is(":visible") && $("#advance_inst").val()==""){
                    swal({
                        title: 'Please Enter Instrument Number!',
                        text: '',
                        type: 'error',
                        confirmButtonText: 'OK!'
                    });
                    $("#advance_inst").focus();
                }
                return false;            
            } else {
               
                $.ajax({
                    type: 'POST',
                    //url: 'Scheduler_controller/active_staff_list',
                    url: "<?php echo base_url() . 'visits_controller/add_visit_advance'; ?>",
                    data:{visit_id: $('#visit-id').val(), 
                        advance_amount:$("#advance_amount").val(), 
                        advance_mode:$("#advance_mode option:selected").val(),
                        advance_inst:$("#advance_inst").val(),
                        advance_comment:$("#advance_comment").val()
                        },
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        toastr.success('Advance of Rs'+ $("#advance_amount").val() +' Updated in Visit '+ $('#visit-id').val(), 'Done!');
                        $("#advance_amount").val('');
                        $("#advance_comment").val('');
                        printadvance();
                        $('#eventview').modal('hide');
                    }
                });
            }
        
    }
    
    
    function removeadvance(advanceid){
         $.ajax({
            type: 'POST',
            //url: 'Scheduler_controller/active_staff_list',
            url: "<?php echo base_url() . 'visits_controller/remove_advance'; ?>",
            data:{
                visit_id: $('#visit-id').val(), 
                advance_id:advanceid
                },
            dataType: "text",
            cache: false,
            async: true,
            success: function(data) {
                if(data === "Advance removed!"){
                    toastr.success(data, 'Done!');
                    $('#eventview').modal('hide');
                } else {
                    toastr.error(data);
                }
                
            }
        });
    }
    
    function getAdditionalStaff() {
        $('#additional_staff').children().remove();
        
        $("#change_staff").children().remove();
        
        $("#additional_staff").select2();
        $("#change_staff").select2();
        
        $.ajax({
            type: 'POST',
            //url: 'Scheduler_controller/active_staff_list',
            url: "<?php echo base_url() . 'Scheduler_controller/active_staff_list'; ?>",
            data:{param:'none'},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                var mhtml = "";
                for (var x = 0; x < data.length; x++) {
                    mhtml += '<option value=' + data[x]['id_staff'] + '>' + data[x]['staff_fullname'] + '</option>';
                }
                $("#additional_staff").html(mhtml);
                $("#change_staff").html(mhtml);
            }
        });
        $("#additional_staff").select2('val', '');
        $("#change_staff").select2('val', '');
    }

    function addAdditionalStaff() {
        if ($('#additional_staff').val() === null) {
            swal({
                title: 'Please select any staff!',
                text: '',
                type: 'error',
                confirmButtonText: 'OK!'
            });
            return false;
        }

        var staff_ids = [];
        var staff_names = [];
        $('#additional_staff').children('option:selected').each(function() {
            staff_ids.push($(this).val());
            staff_names.push($(this).text());
        });
        $.ajax({
            type: 'POST',
            //url: 'Scheduler_controller/add_visit_service_staffs',
            url: "<?php echo base_url() . 'Scheduler_controller/add_visit_service_staffs'; ?>",
            data: {
                staff_ids: staff_ids,
                staff_names: staff_names,
                visit_id: $('#visit-id').val(),
                visit_service_id: $('#staff_visit_service_id').val()
            },
            success: function(response) {
                var data = response.split('|');
                if (data[0] === 'success') {
                    
                    $('#eventview').modal('hide');
                    $('#calendar').fullCalendar('refetchEvents');
                    
                    toastr.success('Additional Staff Added!', 'Done!');
                } else if(data[0] === 'duplicates'){
                    var names = $.parseJSON(data[1]);
                    var staffnames = "";
                    var is_are = names.length > 1 ? 'are' : 'is';
                    for(var i=0; names.length > i; i++){
                        staffnames += names[i].staff_name+', ';
                    }
                    
                    staffnames = staffnames.slice(0, -2);
                    
                    swal({
                        title: ''+staffnames+ ' '+is_are+' already in this service!',
                        text: '',
                        type: 'error',
                        confirmButtonText: 'OK!'
                    });
                } else {
                    swal({
                        title: 'There is an unexpected error!',
                        text: '',
                        type: 'error',
                        confirmButtonText: 'OK!'
                    });
                }
            }
        });
    }

    $(window).load(function() {

        fillBday();
        getservicestypes();
        //get_services_types();
    
        $("#dateChangeForm").submit(function(event){
            var form = this;
            event.preventDefault();
            swal({
                title: 'Move Visit To Another Date',
                text: "Are you sure?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff5b5b !important',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes'
                
            }, function(isConfirm) {          
                if(isConfirm){
                    form.submit();
                }
            })
        });
        
        
        $("#staffChangeForm").submit(function(event){
            var form = this;
            event.preventDefault();
            swal({
                title: 'Change Staff for this Service?',
                text: "Are you sure?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff5b5b !important',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes'
                
            }, function(isConfirm) {          
                if(isConfirm){
                    form.submit();
                }
            })
        });
    
            
        $('#additional_staff').select2({
            placeholder: 'Add more Staff (optional)'
        });

        $(document).on('click', '.fc-resource-cell', function() {
            var moment = $('#calendar').fullCalendar('getDate');
            var calendar_date = moment.format('YYYY-MM-DD');
            ////console.log(calendar_date);
            var staff_id = $(this).attr('data-resource-id');
            checkStaffStatus(staff_id);
            $('#staffattendancebuttons button').attr('staff_id', staff_id);
            $('#staffattendancebuttons a').attr('staff_id', staff_id);//get only staff id just keep attr name like this
            $('#staffattendancebuttons a').attr('block_calendar_date', calendar_date);//get only calendar date
            $('#staff-header').html('');
            $('#staff-header').html('');
            $.ajax({
                type: 'POST',
                //url: 'Scheduler_controller/staffreporting',
                url: "<?php echo base_url() . 'Scheduler_controller/staffreporting'; ?>",
                //data: 'staff_id=' +staff_id+ '&calendar_date=' +calendar_date,
                data: {
                    staff_id: staff_id,
                    calendar_date: calendar_date
                },
                success: function(response) {
                    var data = response.split('|');
                    
                    var status = $('#staffonlinestatus').val();
                    if (status === 'online') {
                        $('.stafftimein').hide();
                        $('.stafftimeout').show();
                        status = "<span id='staffstatus' class='label label-success'>Timed In</span>";
                    } else {
                        $('.stafftimeout').hide();
                        $('.stafftimein').show();
                        status = "<span id='staffstatus' class='label label-danger'>Timed Out</span>";
                    }
                    $('#staff-header').html(data[0] + "'s Stats " + status);
                    
                    $('#totalcats').html(data[3]);
                    //$('#totalNetAmount').html('<b>' + getNetAmountTotal().toFixed(2) + '</b>');
                    $('#totalNetAmount').html('<b>' + data[4] + '</b>');
                    //$('#totalDiscount').html('<b>' + getDiscountTotal().toFixed(2) + '</b>');
                    $('#totalDiscount').html('<b>' + data[5] + '</b>');
                    $('#totalShare').html('<b>' + data[6] + '</b>');
                }
            });
            $('#staffreporting').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        });

        $(document).on('click', '.fc-resource-area .fc-content > table > tbody tr', function() {
            var moment = $('#calendar').fullCalendar('getDate');
            var calendar_date = moment.format('YYYY-MM-DD');
            ////console.log(calendar_date);
            var staff_id = $(this).attr('data-resource-id');
            checkStaffStatus(staff_id);
            $('#staffattendancebuttons button').attr('staff_id', staff_id);
            $('#staff-header').html('');
            $.ajax({
                type: 'POST',
                //url: 'Scheduler_controller/staffreporting',
                url: "<?php echo base_url() . 'Scheduler_controller/staffreporting'; ?>",
                //data: 'staff_id=' +staff_id+ '&calendar_date=' +calendar_date,
                data: {
                    staff_id: staff_id,
                    calendar_date: calendar_date
                },
                success: function(response) {
                    
                    var data = response.split('|');
                    var status = $('#staffonlinestatus').val();
                    if (status === 'online') {
                        $('.stafftimein').hide();
                        $('.stafftimeout').show();
                        status = "<span id='staffstatus' class='label label-success'>Timed In</span>";
                    } else {
                        $('.stafftimeout').hide();
                        $('.stafftimein').show();
                        status = "<span id='staffstatus' class='label label-danger'>Timed Out</span>";
                    }
                    $('#staff-header').html(data[0] + "'s Stats " + status);
                   
                    $('#totalcats').html(data[3]);
                    $('#totalNetAmount').html('<b>' + getNetAmountTotal().toFixed(2) + '</b>');
                    $('#totalDiscount').html('<b>' + getDiscountTotal().toFixed(2) + '</b>');
                }
            });
            $('#staffreporting').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        });

        $('#color-duration').timepicker({
            defaultTime: '00:00',
            showMeridian: false,
            maxHours: 12
        });

        $('#color-duration2').timepicker({
            defaultTime: '00:00',
            showMeridian: false,
            maxHours: 12
        });

        $('#detail-customer-wedding').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy/mm/dd'
        });

        
        $('.colorpicker-default').colorpicker({
            format: 'hex'
        });
        $('.colorpicker-rgba').colorpicker();
        

        $("#visit-prod").select2({
            //maximumSelectionLength: 2
        });

        $("#searchpanel input").keypress(function(e) {
            if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
                var mvar = "#btn" + $(this).attr('id');

                $(mvar).trigger('click');

                return false;
            } else {
                return true;
            }
        });
        $("#name-search").on('keyup',function(){
            $("#cell-search").val('');
            $("#card-search").val('');
        });
        $("#cell-search").on('keyup',function(){
            $("#name-search").val('');
            $("#card-search").val('');
        });
        $("#card-search").on('keyup',function(){
            $("#cell-search").val('');
            $("#name-search").val('');
        });
        
        $("#btnname-search").on('click', function() {
            general_search("#btnname-search"); return false;
            var mid = $("#name-search").val();
            $(this).html('<i class="fa fa-spin fa-spinner"></i>');
            $('#name-search').prop('readonly', true);
            $('#cell-search').prop('readonly', true);
            $('#card-search').prop('readonly', true);
            $.ajax({
                type: 'POST',
                //url: 'customer_controller/searchname',
                url: "<?php echo base_url() . 'customer_controller/searchname'; ?>",
                data: {customername: mid},
                dataType: "json",
                cache: false,
                async: true,
                success: function(data) {
                    fillcustomerform(data,'search');
                    $('#btnname-search').html('<i class="fa fa-tag"></i>');
                    $('#name-search').prop('readonly', false);
                    $('#cell-search').prop('readonly', false);
                    $('#card-search').prop('readonly', false);
                }
            });
        });

        $("#btncell-search").on('click', function() {
        general_search("#btncell-search"); return false;
            var mid = $("#cell-search").val();
            $(this).html('<i class="fa fa-spin fa-spinner"></i>');
            $('#name-search').prop('readonly', true);
            $('#cell-search').prop('readonly', true);
            $('#card-search').prop('readonly', true);
            $.ajax({
                type: 'POST',
                //url: 'customer_controller/searchcell',
                url: "<?php echo base_url() . 'customer_controller/searchcell'; ?>",
                data: {customercell: mid},
                dataType: "json",
                cache: false,
                async: true,
                success: function(data) {
                    fillcustomerform(data,'search');
                    $('#btncell-search').html('<i class="fa fa-tag"></i>');
                    $('#name-search').prop('readonly', false);
                    $('#cell-search').prop('readonly', false);
                    $('#card-search').prop('readonly', false);
                }
            });           
        
        });
        
        $("#btncard-search").on('click', function() {
        general_search("#btncard-search"); return false;
            var mid = $("#card-search").val();
            $(this).html('<i class="fa fa-spin fa-spinner"></i>');
            $('#name-search').prop('readonly', true);
            $('#cell-search').prop('readonly', true);
            $('#card-search').prop('readonly', true);
            $.ajax({
                type: 'POST',
                //url: 'customer_controller/searchcell',
                url: "<?php echo base_url() . 'customer_controller/searchcard'; ?>",
                data: {customercard: mid},
                dataType: "json",
                cache: false,
                async: true,
                success: function(data) {
                    fillcustomerform(data,'search');
                    $('#btncard-search').html('<i class="fa fa-credit-card"></i>');
                    $('#name-search').prop('readonly', false);
                    $('#cell-search').prop('readonly', false);
                    $('#card-search').prop('readonly', false);
                }
            });
        });

        $('.newcustomeradding').on('click', function() {
            $("#customer-color").html("");
            $('#txt-customer-name').prop('readonly', false);
            $('#txt-customer-email').prop('readonly', false);
            $('#txt-customer-cell').prop('readonly', false);
            $('#txt-customer-address').prop('readonly', false);
            $('#txt-customer-bday').prop('disabled', false);
            $('#txt-customer-bmonth').prop('disabled', false);
            $('#txt-customer-profession').prop('readonly', false);
            $('#txt-customer-gender').prop('disabled', false);
            
            $('#txt-customer-name').val(ucwords($('#name-search').val()));
            $('#labelcustomer').html(ucwords($('#name-search').val())+' '+$('#cell-search').val());
            $('#txt-customer-cell').val($('#cell-search').val());
            $('#txt-customer-co').val('');
            $('#txt-customer-display').val('');
            $('#txt-customer-loyalty').val('0.00');
            enable_careof();
            $('#div_careof').show();
            $('#div_careof_display').hide();
                        
            $('.visit-message').hide();
            $('#schedulerFunctionBtn').hide();
            $('#newcustomeradding').hide();
            
            if($("#divsearch").is(":visible")){
                back("#divsearch", "#divmain");
            } else {
                back("#multiplesearch", "#divmain");
            }
        });

        $(".numeric").keypress(function(e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });

        $('#btncancelservice').on('click', function() {
            var vsid = $(this).attr('visit_service_id');
            var vsname = $(this).attr('visit_service_name');
            swal({
                title: 'Remove Serivce',
                text: "Are you sure you want to remove (" + vsname + ")?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff5b5b !important',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes'
            }, function() {
                $.ajax({
                    //url: 'Scheduler_controller/cancelVisitService',
                    url: "<?php echo base_url() . 'Scheduler_controller/cancelVisitService'; ?>",
                    //data: 'visit_service_id=' +vsid,
                    data: {
                        visit_service_id: vsid
                    },
                    type: 'POST',
                    success: function(response) {
                        if (response === "success") {

                            $('#eventview').modal('hide');
                            $('#calendar').fullCalendar('removeEvents', vsid);
                            toastr.success('Service removed!', 'Done!');
                             $('#calendar').fullCalendar('refetchEvents');
                        } else if (response === "one_service") {
                            cancelVisit();
//                            swal({
//                                title: "please use 'CANCLE VISIT' option",
//                                text: "This is the only service in the visit.",
//                                type: "error",
//                                confirmButtonText: 'OK!'
//                            });
                        }
                    }
                });
            });
        });

        $('#visit-services-change-categories').on('change', function() {

            $('#visit-services-change').html("");

            var id_service_category = $(this).val();
            var service_category = $('#visit-services-change-categories option:selected').text();

            if (id_service_category !== "select") {

                $.ajax({
                    type: "POST",
                    //url: "Service_controller/getServicesByCategory",
                    url: "<?php echo base_url() . 'Service_controller/getServicesByCategory'; ?>",
                    //data: "id_service_category=" + id_service_category,
                    data: {
                        id_service_category: id_service_category
                    },
                    success: function(response) {

                        var data = $.parseJSON(response);
                       // //console.log(response);
                        chtml = "";

                        chtml += '<option value="select" selected>Select</option>';

                        for (x = 0; x < data.length; x++) {

                            var service_color = data[x]['service_color'];
                            service_color = service_color == "" ? "#3a87ad" : service_color;
                            var service_duration = data[x]['service_duration'];
                            service_duration = service_duration == "" ? "00:30:00" : service_duration;
                            var flag = data[x]['flag'];

                            chtml += '<option value=' + data[x]['id_business_services'] + ' data-servicecolor=' + service_color + ' data-serviceduration=' + service_duration + ' data-serviceflag=' + flag + '>' + data[x]['service_name'] + '</option>';

                        }

                        $("#visit-services-change").append(chtml);

                        if (service_category === "Hair Color" || service_category === "Hair color" || service_category === "hair color") {

                            $('#haircolordiv2').slideDown();

                        } else {

                            $('#haircolordiv2').slideUp('fast');

                            $('#color-type2').val('select');
                            $('#color-number2').val('select');
                            $('#color-duration2').val('0:00');
                            $('#color-cost2').val('');

                        }

                    }

                });

            }

        });

        $('#color-type').on('change', function() {

            $('#color-number').html("");

            var type_id = $(this).val();

            if (type_id !== "select") {

                $.ajax({
                    type: "POST",
                    //url: "Scheduler_controller/getColorNumbersByTypeId",
                    url: "<?php echo base_url() . 'Scheduler_controller/getColorNumbersByTypeId'; ?>",
                    //data: "type_id=" + type_id,
                    data: {
                        type_id: type_id
                    },
                    success: function(response) {

                        var data = $.parseJSON(response);

                        chtml = "";

                        chtml += '<option value="select" selected>Select</option>';

                        for (x = 0; x < data.length; x++) {

                            chtml += '<option value="' + data[x]['id'] + '">' + data[x]['number'] + '</option>';

                        }

                        $("#color-number").append(chtml);

                    }

                });

            }

        });

        $('#color-type2').on('change', function() {

            $('#color-number2').html("");

            var type_id = $(this).val();

            if (type_id !== "select") {

                $.ajax({
                    type: "POST",
                    //url: "Scheduler_controller/getColorNumbersByTypeId",
                    url: "<?php echo base_url() . 'Scheduler_controller/getColorNumbersByTypeId'; ?>",
                    //data: "type_id=" + type_id,
                    data: {
                        type_id: type_id
                    },
                    success: function(response) {

                        var data = $.parseJSON(response);

                        chtml = "";

                        chtml += '<option value="select" selected>Select</option>';

                        for (x = 0; x < data.length; x++) {

                            chtml += '<option value="' + data[x]['id'] + '">' + data[x]['number'] + '</option>';

                        }

                        $("#color-number2").append(chtml);

                    }

                });

            }

        });

    });

    function changecolor(){
        var visitid = $('#visit-id').val();
        $.ajax({
                //url: 'Scheduler_controller/cancelVisit',
                url: "<?php echo base_url() . 'Scheduler_controller/changeVisitColor'; ?>",
                //data: 'visitid=' +visitid,
                data: {
                    visit_id: visitid,
                    visit_color:$("#visit_color_picker").val()
                },
                type: 'POST',
                success: function(response) {
                    $('#eventview').modal('hide');
                    $('#calendar').fullCalendar('refetchEvents');
                }
            });
    }

    function cancelVisit() {
        var visitid = $('#visit-id').val();
        $("#eventview").modal('hide');
        swal({
                title: "Are you sure?",
                text: "Any advance on this Visit will also be canceled (Returned).Give Reason For Cancelling This Visit:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                inputPlaceholder: "reason for cancelling"
              }, function (inputValue) {
                if (inputValue === false) return false;
                if (inputValue === "") {
                  swal.showInputError("You need to write something!");
                  return false
                } 

            $.ajax({
                //url: 'Scheduler_controller/cancelVisit',
                url: "<?php echo base_url() . 'Scheduler_controller/cancelVisit'; ?>",
                //data: 'visitid=' +visitid,
                data: {
                    visitid: visitid, cancelreason: inputValue
                },
                type: 'POST',
                success: function(response) {

                    var data = $.parseJSON(response);

                    if (data.length > 0) {

                        for (var i = 0; data.length > i; i++) {

                            $('#calendar').fullCalendar('removeEvents', data[i].id_visit_services);

                        }

                        $('#eventview').modal('hide');

                        swal(
                            'Canceled!',
                            'Visit has been canceled.',
                            'success'
                            );
                        $('#calendar').fullCalendar('refetchEvents');
                    }

                }
            });

        });
    }

    function cancelVisitKeepAdv() {
        var visitid = $('#visit-id').val();
        $("#eventview").modal('hide');
        swal({
                title: "Are you sure?",
                text: "Give Reason For Cancelling This Visit:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                inputPlaceholder: "reason for cancelling"
              }, function (inputValue) {
                if (inputValue === false) return false;
                if (inputValue === "") {
                  swal.showInputError("You need to write something!");
                  return false
                } 

            $.ajax({
                //url: 'Scheduler_controller/cancelVisit',
                url: "<?php echo base_url() . 'Scheduler_controller/cancelVisitKeepAdv'; ?>",
                //data: 'visitid=' +visitid,
                data: {
                    visitid: visitid, cancelreason: inputValue
                },
                type: 'POST',
                success: function(response) {

                    var data = $.parseJSON(response);

                    if (data.length > 0) {

                        for (var i = 0; data.length > i; i++) {

                            $('#calendar').fullCalendar('removeEvents', data[i].id_visit_services);

                        }

                        $('#eventview').modal('hide');

                        swal(
                            'Canceled!',
                            'Visit has been canceled.',
                            'success'
                            );
                        $('#calendar').fullCalendar('refetchEvents');
                    }

                }
            });

        });
    }

    function checkStaffStatus(pid) {
        $.ajax({
            type: 'POST',
            //url: 'staff_controller/checkStaffStatus',
            url: "<?php echo base_url() . 'staff_controller/checkStaffStatus'; ?>",
            data: {id: pid},
            async: false,
            success: function(data) {
                $('#staffonlinestatus').val(data);
            }
        });
    }

    function timein() {
        var pid = $('.stafftimein').attr('staff_id');
        $.ajax({
            type: 'POST',
            //url: 'staff_controller/timein',
            url: "<?php echo base_url() . 'staff_controller/timein'; ?>",
            data: {id: pid},
            success: function(data) {
                var result = data.split("|");
                if (result[0] === "success") {
                    $('#staffstatus').html('Timed In');
                    $('#staffstatus').removeClass('label-danger');
                    $('#staffstatus').addClass('label-success');
                    $('.stafftimeout').show();
                    $('.stafftimein').hide();
                    toastr.success('Staff member is now present!', 'Great!');
                } else {
                    swal({
                        title: "Error",
                        text: result[1],
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
                }

            }
        });
    }

    function timeout() {
        var pid = $('.stafftimeout').attr('staff_id');
        $.ajax({
            type: 'POST',
            //url: 'staff_controller/timeout',
            url: "<?php echo base_url() . 'staff_controller/timeout'; ?>",
            data: {id: pid},
            success: function(data) {
                var result = data.split("|");
                if (result[0] === "success") {
                    $('#staffstatus').html('Timed Out');
                    $('#staffstatus').addClass('label-danger');
                    $('#staffstatus').removeClass('label-success');
                    $('.stafftimein').show();
                    $('.stafftimeout').hide();
                    toastr.success('Time out updated for Staff!', 'Done!');
                } else {
                    swal({
                        title: "Error",
                        text: result[1],
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
                }

            }
        });
    }

    function getNetAmountTotal() {
        var sum = 0;
        $('.netamount > b').each(function(index, value) {
            var netamount = parseFloat($(value).text());
            sum = sum + netamount;
        });
        return sum;
    }

    function getDiscountTotal() {
        var sum = 0;
        $('.discount > b').each(function(index, value) {
            var discount = parseFloat($(value).text());
            sum = sum + discount;
        });
        return sum;
    }

    function storeVTblValues() {
        var TableData = new Array();
        $('#visittbl tr').each(function(row, tr) {
            TableData[row] = {
                "customerid": $(tr).find('td:eq(0)').text()
                , "serviceid": $(tr).find('td:eq(1)').text()
                , "servicename": $(tr).find('td:eq(2)').text()
                , "staffid": $(tr).find('td:eq(3)').text()
                , "staff": $(tr).find('td:eq(4)').text()
                , "productid": $(tr).find('td:eq(5)').text()
                , "productname": $(tr).find('td:eq(6)').text()
                , "servicecolor": $(tr).find('td:eq(7)').text()
                , "serviceduration": $(tr).find('td:eq(8)').text()
            }
        });
        TableData.shift();  // first row will be empty - so remove
        return TableData;
    }

    function fillvisit(visitid) {
        $.ajax({
            type: 'POST',
            //url: 'visits_controller/getVisitbyid',
            url: "<?php echo base_url() . 'visits_controller/getVisitbyid'; ?>",
            data: {id_customer_visit: visitid},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                $("#visit-id").val(data['visits'][0]['id_customer_visits']);
                $("#visit-customerid").val(data['visits'][0]['customer_id']);
                $("#visit-customername").val(data['visits'][0]['customer_name']);
                $("#visit-customercell").val(data['visits'][0]['customer_cell']);
                $("#visit-customeremail").val(data['visits'][0]['customer_email']);
                //$("#visit-date").val(data['visits'][0]['visitdate']);
                var mhtml = "";
                for (var x = 0; x < data['services'].length; x++) {
                    mhtml += '<tr>';
                    mhtml += '<td style="display:none;">' + data['visits'][x]['customer_id'] + '</td>';
                    mhtml += "<td class='id'>" + data['services'][x]['service_id'] + "</td>";
                    mhtml += "<td>" + data['services'][x]['service_name'] + "</td>";
                    mhtml += "<td style='display:none;'>" + data['services'][x]['staff_id'] + '</td>';
                    mhtml += "<td>" + data['services'][x]['staff_name'] + '</td>';

                    var product_ids = "";
                    $(data['visits']).each(function(index, value) {
                        if (data['services'][x]['id_visit_services'] === value['visit_service_id']) {
                            product_ids += value['product_id'] + ' | ';
                        }
                    });

                    mhtml += '<td style="display:none;">' + product_ids + '</td>';

                    var product_names = "";
                    $(data['visits']).each(function(index, value) {
                        if (data['services'][x]['id_visit_services'] === value['visit_service_id']) {
                            if (value['product_name'] !== null) {
                                product_names += value['product_name'] + ' | ';
                            }
                        }
                    });

                    mhtml += '<td>' + product_names + '</td>';

                    mhtml += '<td><span class="label label-danger" onclick="removeservice(' + data['services'][x]['service_id'] + ')" style="cursor:pointer">x</span></td>';
                    mhtml += "</tr>";
                }
                $("#visit-service-list tbody").append(mhtml);
                //$("#btngeninvoice").show();
            }
        });
    }

    function clearappointment() {
        $("#appointment-customer-id").val('');
        $("#appointment-customer-name").val('');
        $("#appointment-remarks").val('');
    }

    function clearorder() {
        $("#order-customer-id").val('');
        $("#order-customer-name").val('');
        $("#order-id").val('');
        $("#order-customer-cell").val('');
        $("#order-customer-email").val('');

        $('#order-products > option').eq(0).attr('selected', 'selected');
        $("#order-product-list tbody").html("");
        $("#tbllastorders tbody").html('');
        $("#btngenorderinvoice").hide();
    }

    function clearvisit() {
        $("#visit-customer-id").val('');
        $("#visit-customer-name").val('');
        $("#visit-id-1").val('');
        $("#visit-customer-cell").val('');
        $("#visit-customer-email").val('');

        $('#visit-services > option').eq(0).attr('selected', 'selected');
        $("#visit-service-list tbody").html("");
        $("#tbllastvisits tbody").html('');
    }

    function removeservice(val) {
        $('#visit-service-list').find("td.id").each(function(index) {
            if ($(this).html() == val) {
                $(this).closest('tr').remove();
            }
        });
    }

    function getservicestochange() {
        $('#visit-services-change-categories').html();
        $.ajax({
            type: 'POST',
            data:{param:'none'},
            //url: 'service_controller/getServicesCategories',
            url: "<?php echo base_url() . 'service_controller/getServicesCategories'; ?>",
            success: function(response) {

                var data = $.parseJSON(response);

                chtml = "";

                chtml += '<option value="select" selected>Select</option>';

                for (x = 0; x < data.length; x++) {

                    chtml += '<option value=' + data[x]['id_service_category'] + ' >' + data[x]['service_category'] + '</option>';

                }
               // //console.log(chtml);
                $("#visit-services-change-categories").append(chtml);

            }
        });
    }

    function colortypes() {
        $('#color-type').html('');
        $.ajax({
            type: 'POST',
            data:{param:'none'},
            //url: 'Scheduler_controller/getColorTypes',
            url: "<?php echo base_url() . 'Scheduler_controller/getColorTypes'; ?>",
            success: function(response) {

                var data = $.parseJSON(response);

                chtml = "";

                chtml += '<option value="select" selected>Select</option>';

                for (x = 0; x < data.length; x++) {

                    chtml += '<option value=' + data[x]['id'] + ' >' + data[x]['type'] + '</option>';

                }



                $("#color-type").append(chtml);

            }
        });
    }

    function colortypeschange() {
        $('#color-type2').html('');
        $.ajax({
            type: 'POST',
            data:{param:'none'},
            //url: 'Scheduler_controller/getColorTypes',
            url: "<?php echo base_url() . 'Scheduler_controller/getColorTypes'; ?>",
            success: function(response) {

                var data = $.parseJSON(response);

                chtml = "";

                chtml += '<option value="select" selected>Select</option>';

                for (x = 0; x < data.length; x++) {

                    chtml += '<option value=' + data[x]['id'] + ' >' + data[x]['type'] + '</option>';

                }



                $("#color-type2").append(chtml);

            }
        });
    }

    function getservices(service_type_id, flag) {
        $('#visit-services-categories').html('');
        $('#visit-services-categories').html('<div class="fa fa-spin fa-spinner"></div>');
        $.ajax({
            type: 'POST',
            
            //url: 'service_controller/getServicesCategories',
            url: "<?php echo base_url() . 'service_controller/getServicesCategories'; ?>",
            data: {service_type_id: service_type_id, flag: flag},
            success: function(response) {

                var data = $.parseJSON(response);

                var chtml = "";
                
                chtml += '<input id="searchgetservices" class="form-control" type="text" style="width:80%"/>';
                
                chtml += '<ul class="servicelist m-t-10" id="getservices" >';

                for (x = 0; x < data.length; x++) {

                    var id = data[x]['id_service_category'];
                    var name = data[x]['service_category'];
                    var image = '<img src="<?php echo base_url() . "assets/images/category/"; ?>' + data[x]['service_category_image'] + '">';
                    var category_name = "'" + name.replace(/(['"])/g, "\\$1") + "'";

                    chtml += '<li data-service_category_id="' + id + ' " data-service_types_flag="' + flag + ' " onclick="get_category_services(' + id + ',\'' + flag + '\');">' + image + ' ' + name + '</li>';

                }

                chtml += '</ul>';
                $('#visit-services-categories').html('');
                $("#visit-services-categories").append(chtml);
                
                $("#getservices").searcher({
                        itemSelector: "li",
                        textSelector: "",
                        inputSelector: "#searchgetservices"
                });
            }
        });
    }

    function getservicestypes() {
        $('#visit-services-types').html('');
       
        $.ajax({
            type: 'POST',
            data:{param:'none'},
            //url: 'service_controller/getServicesTypes',
            url: "<?php echo base_url() . 'service_controller/getServicesTypes'; ?>",
            success: function(response) {

                var data = $.parseJSON(response);

                var chtml = "";
                chtml += '<input id="searchgetservicestypes" class="form-control" type="text" style="width:80%"/>';
                chtml += '<ul class="servicelist m-t-10" id="getservicestypes">';

                for (x = 0; x < data.length; x++) {

                    var id = data[x]['id_service_types'];
                    var name = data[x]['service_type'];
                    var flag = data[x]['flag'];
                    var image = '<img src="<?php echo base_url() . "assets/images/servicetype/"; ?>' + data[x]['service_type_image'] + '">';

                    chtml += '<li data-service_types_id="' + id + '" data-service_types_flag="' + flag + '" onclick="getservices(' + id + ' ,\'' + flag + '\');">' + image + ' ' + name + '</li>';

                }

                chtml += '</ul>';

                $("#visit-services-types").append(chtml);
                
                $("#getservicestypes").searcher({
                        itemSelector: "li",
                        textSelector: "",
                        inputSelector: "#searchgetservicestypes"
                });
            }
        });
        
        
        
        $(".nicescroll_service_types").niceScroll({cursoropacitymin: 1});
        //$(".nicescroll_service_types2").niceScroll({cursoropacitymin: 1});
        
    }

    function get_services(service_type_id, flag) {
        $('#visit-services-categories1').html('');
        $('#visit-services-categories1').html('<div class="fa fa-spin fa-spinner"></div>');
        ////console.log('getservices');
        $.ajax({
            type: 'POST',
            //url: 'service_controller/getServicesCategories',
            url: "<?php echo base_url() . 'service_controller/getServicesCategories'; ?>",
            data: {service_type_id: service_type_id, flag: flag},
            success: function(response) {

                var data = $.parseJSON(response);

                var chtml = "";
                chtml += '<input id="searchget_services" class="form-control" type="text" style="width:80%"/>';
                chtml += '<ul id="get_services" class="servicelist m-t-10">';

                for (x = 0; x < data.length; x++) {

                    var id = data[x]['id_service_category'];
                    var name = data[x]['service_category'];
                    var image = '<img src="<?php echo base_url() . "assets/images/category/"; ?>' + data[x]['service_category_image'] + '">';
                    var category_name = "'" + name.replace(/(['"])/g, "\\$1") + "'";

                    chtml += '<li data-service_category_id="' + id + '"  data-service_types_flag="' + flag + '" onclick="getcategory_services(' + id + ', \'' + flag + '\');">' + image + ' ' + name + '</li>';

                }

                chtml += '</ul>';
               
                $('#visit-services-categories1').html('');
                $("#visit-services-categories1").append(chtml);
                
                
                $("#get_services").searcher({
                        itemSelector: "li",
                        textSelector: "",
                        inputSelector: "#searchget_services"
                });

            }
        });
    }

    function get_services_types() {
        
        $('#visit-services-types1').html('');
        $.ajax({
            type: 'POST',
            data:{param:'none'},
            //url: 'service_controller/getServicesTypes',
            url: "<?php echo base_url() . 'service_controller/getServicesTypes'; ?>",
            success: function(response) {

                var data = $.parseJSON(response);

                var chtml = "";
                chtml += '<input id="searchget_services_types" class="form-control" type="text" style="width:80%"/>';
                chtml += '<ul id="get_services_types" class="servicelist m-t-10">';

                for (x = 0; x < data.length; x++) {

                    var id = data[x]['id_service_types'];
                    var name = data[x]['service_type'];
                    var flag = data[x]['flag'];
                    var image = '<img src="<?php echo base_url() . "assets/images/servicetype/"; ?>' + data[x]['service_type_image'] + '">';

                    chtml += '<li data-service_types_id="' + id + '"  data-service_types_flag="' + flag + '" onclick="get_services(' + id + ',\'' + flag + '\');">' + image + ' ' + name + '</li>';

                }

                chtml += '</ul>';
                ////console.log(chtml);
               
                $("#visit-services-types1").append(chtml);
                
                
                $("#get_services_types").searcher({
                        itemSelector: "li",
                        textSelector: "",
                        inputSelector: "#searchget_services_types"
                });
            }
             
        });
      
        $(".nicescroll2").niceScroll({cursoropacitymin: 1});
        $(".nicescroll_service_types2").niceScroll({cursoropacitymin: 1});
    }

   

    function removeservice(val) {
        $('#visit-service-list').find("td.id").each(function(index) {
            if ($(this).html() == val) {
                $(this).closest('tr').remove();
            }
        });
    }

    function getOpenVisits() {
        $.ajax({
            type: 'POST',
            data:{param:'none'},
            //url: 'visits_controller/get_visits',
            url: "<?php echo base_url() . 'visits_controller/get_visits'; ?>",
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                var mhtml = "";
                for (x = 0; x < data.length; x++) {
                    var mdate = new Date(data[x]['customer_visit_date']);
                    var visittime = mdate.getHours() + ":" + mdate.getMinutes();
                    var visitmonth = mdate.getMonth() + 1;
                    var visitdate = mdate.getDate() + "/" + visitmonth + "/" + mdate.getFullYear();
                    mhtml += ' <a href="javascript:void(0)" onclick="openVisit(' + data[x]['id_customer_visits'] + ',' + data[x]['id_customers'] + ')" >';
                    mhtml += '<div class="inbox-item">';
                    mhtml += ' <div class="inbox-item-img"><img src="<?php echo base_url(); ?>assets/images/users/' + data[x]['customer_image'] + '" class="img-circle" alt="' + data[x]['customer_name'] + '"></div>';
                    mhtml += ' <p class="inbox-item-author">' + data[x]['customer_name'] + '</p>';
//                            mhtml += '<p class="inbox-item-author"><span>Date: </span>' + data[x]['visitdate'] + '</p>';
                    mhtml += '<p class="inbox-item-author"><span>Time: </span>' + visittime + '</p>';
                    mhtml += '</div>';
                    mhtml += '</a>';
                }
                $("#beingserviced").html(mhtml);
            }
        });
    }

//    function createEvents() {
//        var date = $('#calendar').fullCalendar('getDate');
//        var start = date.format('YYYY-MM-DD');
//
//        $.ajax({
//            type: 'POST',
//            
//            //url: 'Scheduler_controller/getAllVisitsByDate',
//            url: "<?php echo base_url() . 'Scheduler_controller/getAllVisitsByDate'; ?>",
//            async: true,
//            data: {
//                start: start,
//                end: ''
//            },
//            success: function(response) {
//                if (response === 'empty') {
//                    return false;
//                }
//                var data = $.parseJSON(response);
//                if (data.length > 0) {
//
//                    var events = [];
//                    var max_id = "";
//
//                    for (var i = 0; data.length > i; i++) {
//
//                        var type = data[i].visit_status === 'invoiced' ? 'Invoiced' : 'Visit';
//                        var eventId = data[i].id_visit_services;
//                        var resourceId = data[i].staff_id;
//                        var title = data[i].customer_name + ' - ' + data[i].service_name + ' - ' + type;
//                        var bgColor = type === 'Invoiced' ? '#CCCCCC' : data[i].visit_color;
//                        var editable = type === 'Invoiced' ? false : true;
//                        var startDate = data[i].visit_service_start;
//                        var endDate = data[i].visit_service_end;
//
//                        events.push({
//                            id: eventId,
//                            resourceId: resourceId,
//                            editable: editable,
//                            title: title,
//                            backgroundColor: bgColor,
//                            borderColor: bgColor,
//                            start: startDate,
//                            end: endDate
//                        });
//
//                        max_id = eventId;
//
//                    }
//
//                    $('#calendar').fullCalendar('addEventSource', events);
//                    $('#max_visit_id').val(max_id);
//                }
//            }
//        });
//    }

    function newEvents(doblock) {
        var date = $('#calendar').fullCalendar('getDate');
        var start = date.format('YYYY-MM-DD');
        // console.log(date);
        $.ajax({
            type: 'POST',
            //url: 'Scheduler_controller/getAllNewVisits',
            url: "<?php echo base_url() . 'Scheduler_controller/getAllNewVisits'; ?>",
            async: true,
            data: {
                start: start,
                last_update_date: $('#last_update_date').val(),
                previous: '<?php echo $time->previous; ?>',
                doblock: doblock
            },
            success: function(response) {
                if (response === 'empty') {
                    return false;
                }
                var data = $.parseJSON(response);
                //console.log(data);
                var customervisits = [];
                if (data['visit_events'].length > 0) {
                    var update_date = "";
                    var doneevents = [];
                    var doneblock = [];
                    for (var k = 0; data['visit_events'].length > k; k++) {

                        for (var i = 0; data['visit_events'][k].length > i; i++) {
                           // //console.log(data['visit_events']);
                            var type = data['visit_events'][k][i].visit_status === 'invoiced' ? 'Invoiced' : 'Visit';
                            var eventId = data['visit_events'][k][i].id_visit_services+data['visit_events'][k][i].id_customer_visits;
                            var resourceId = data['visit_events'][k][i].staff_id;
                            var title = data['visit_events'][k][i].customer_name + ' - ' + data['visit_events'][k][i].service_category + ' - ' + data['visit_events'][k][i].service_name;
                            var bgColor = type === 'Invoiced' ? '#CCCCCC' : data['visit_events'][k][i].visit_color;
                            
                            var textColor = data['visit_events'][k][i].visit_color_type === 'Dark' ? (type === 'Invoiced' ? '#000000' : '#ffffff') : '#000000';
                            var editable = type === 'Invoiced' ? false : true;
                            var invoicedClass = type === 'Invoiced' ? 'event-invoiced' : '';
                            var startDate = data['visit_events'][k][i].visit_service_start;
                            var endDate = data['visit_events'][k][i].visit_service_end;
                            var visitserviceid = data['visit_events'][k][i].id_visit_services;
                            
                             var sharedClass = data['visit_events'][k][i].block_other  ;
                            var border = '#000';
                            if(sharedClass=='Yes' && parseInt(data['visit_events'][k][i].business_id) !== <?php echo $this->session->userdata('businessid');?> ){
                                 editable=false;
                                border = 'yellow';
                                bgColor='#fff';
                                textColor='Red';
                                title=" ("+ data['visit_events'][k][i].business_name.toUpperCase() +")-"+title;

                            }
                            
                            
                            var inservice="";
                            if(data['visit_events'][k][i].inservice=='Yes' && type !== 'Invoiced'){
                                if(textColor == "#000000"){
                                    border = 'red';
                                } else {border='yellow';}
                                inservice= 'cut';
                            }
                            
                            var requested="";
                            if(data['visit_events'][k][i].requested=='Yes' && type !== 'Invoiced'){

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
                            
                            
                            var render = true;
                            $.each(doneevents, function(index, value) {
                                if (value == eventId) {
                                    render = false;
                                }
                            });
                            if (render == true) {
                                $('#calendar').fullCalendar('removeEvents', eventId);
                            }
                            $('#calendar').fullCalendar('renderEvent', {
                                id: eventId,
                                resourceId: resourceId,
                                editable: editable,
                                title: title,
                                backgroundColor: bgColor,
                                textColor: textColor,
                                borderColor: border,
                                borderWidth: '2px',
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
                                requested: requested,
                                inservice: inservice,
                                visitserviceid: visitserviceid
                            },
                            true
                            );
                            doneevents.push(eventId);
                            if(typeof  data['visit_events'][k][i].most_update_date != 'undefined'){
                                update_date = data['visit_events'][k][i].most_update_date;
                            }
                            
                            

                        }
                       // console.log(update_date);
                        if(update_date!=''){
                            $('#last_update_date').val(update_date);
                        }
                    }
                    <?php if($this->session->userdata('role')!=="Reception" && $this->session->userdata('role')!=="Board"){?>
                        $('#totalvisits').html(data['service_count'] + ' &asymp; ' + data['service_forecast'] + ' &imof; Appointments = ' + data['visit_count']);
                    <?php } else { ?>
                        $('#totalvisits').html(data['service_count']  + ' &imof; Appointments = ' + data['visit_count']);
                    <?php } ?>
                   
                }else{
                    $('#totalvisits').html('');
                    $('#totalvisits').text(0);
                }
                if (data['block_events'].length > 0 && doblock!=="1") {
                    for (var i = 0; data['block_events'].length > i; i++) {
                       
                            
                        $('#calendar').fullCalendar('removeEvents', data['block_events'][i].block_time_event_id);
                        
                        $('#calendar').fullCalendar('renderEvent', {
                            id: data['block_events'][i].block_time_event_id,
                            resourceId: data['block_events'][i].staff_id,
                            editable: true,
                            title: 'Blocked: ' + data['block_events'][i].block_event_name,
                            backgroundColor: '#333',
                            borderColor: '#000',
                            textColor: '#fff',
                            className: 'block_event',
                            start: data['block_events'][i].start_time,
                            end: data['block_events'][i].end_time
                        },
                        true // make the event "stick"
                        );
                        
                    }
                }
            }
        });
    }

    function walkincustomer(){
        clearcustomerform();
        
        $("#txt-customer-id").val("1"); 
        $("#txt-customer-name").val("Walk-In"); 
        $("#labelcustomer").html("walk-In");
        
        $("#visit-customer-id").val("1"); 
        $("#visit-customer-name").val("Walk-In"); 
      
        openVisit();
      
        if($("#divsearch").is(":visible")){
            back("#divsearch", "#divvisit");
        } 
    }

    function addvisit() {
        $("#btnaddvisit").attr("disabled","disabled");
        
        var visit_id = $("#visit-id-1").val() !== "" ? $("#visit-id-1").val() : 0;
        var customer_id = $("#visit-customer-id").val();
        var customer_name = $("#visit-customer-name").val();
        var last_color_code = $('#last_color_code').val();
        var staff_id = localStorage.getItem('staff_id');
        var staff_name = localStorage.getItem('staff_name');
        var start = localStorage.getItem('start');
        var service_ids = [];
        var service_names = [];
        var product_ids = [];
        var product_service_ids = [];
        var product_names = [];
        var qty = [];
        var unit = [];
        var service_duration = [];
        var service_flag = [];
        var id_service_categories = [];
        var requested="No"; if($('#requested').is(':checked')){requested="Yes";}
        var promo="No"; if($('#promo').is(':checked')){promo="Yes";}
        var stricttime="N"; if($('#stricttime').is(':checked')){stricttime="Y";}

        $('input[name=id_business_services]:checked').each(function() {
            service_ids.push($(this).val());
            service_names.push($(this).attr('service_name'));
            service_duration.push($(this).attr('service_duration'));
            service_flag.push($(this).attr('flag'));
            id_service_categories.push($(this).attr('id_service_category'));
        });

        $('input[name=id_business_products]:checked').each(function() {
            product_ids.push($(this).val());
            product_service_ids.push($(this).attr('product_service_id'));
            product_names.push($(this).attr('product_name'));
            qty.push($(this).attr('qty'));
            unit.push($(this).attr('unit'));
        });

        if (service_ids.length === 0) {

            swal({
                title: "You have not selected any service",
                text: "Selection of a service is mandatory. Please select a service.",
                type: "error",
                confirmButtonText: 'OK!'
            });
            $("#btnaddvisit").removeAttr("disabled","disabled");
            return false;

        }

        $.ajax({
            type: "POST",
            //url: "Scheduler_controller/addvisits",
            url: "<?php echo base_url() . 'Scheduler_controller/addvisits'; ?>",
            data: {
                service_ids: service_ids.toString(),
                service_names: service_names.toString(),
                service_duration: service_duration.toString(),
                service_flag: service_flag.toString(),
                id_service_categories: id_service_categories,
                product_ids: product_ids,
                product_service_ids: product_service_ids,
                product_names: product_names,
                qty: qty,
                unit: unit,
                staff_id: staff_id,
                staff_name: staff_name,
                customer_id: customer_id,
                customer_name: customer_name,
                start: start,
                visit_id: visit_id,
                last_color_code: last_color_code,
                requested:requested,
                promo:promo,
                stricttime:stricttime
            },
            success: function(data) {
                var result = data.split("|");
                if (result[0] === "success") {
                    clearvisit();
                    toastr.success('Visit created!', 'Done!');
                    //newEvents();
                    $('#event-modal').modal('hide');

                    $('#calendar').fullCalendar('refetchEvents');

                } else if (result[0] === "already_exist") {
                    swal({
                        title: "Service already added!",
                        text: '',
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                } else {
                    swal({
                        title: "Error",
                        text: result[1],
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
                }
                $("#btnaddvisit").removeAttr("disabled","disabled");
            }
        });

    }

    function addloyaltyvisit(){
        var visit_id = $("#visit-id-1").val() !== "" ? $("#visit-id-1").val() : 0;
        var customer_id = $("#visit-customer-id").val();
        var customer_name = $("#visit-customer-name").val();
        var last_color_code = $('#last_color_code').val();
        var staff_id = localStorage.getItem('staff_id');
        var staff_name = localStorage.getItem('staff_name');
        var start = localStorage.getItem('start');
        var service_ids = [];
        var service_names = [];
        var product_ids = [];
        var product_service_ids = [];
        var product_names = [];
        var qty = [];
        var unit = [];
        var service_duration = [];
        var service_flag = [];
        var id_service_categories = [];

        service_ids.push($('#lservices :selected').attr('service_ids'));
        service_names.push($('#lservices :selected').attr('service_names'));
        service_duration.push($('#lservices :selected').attr('service_duration'));
        service_flag.push($('#lservices :selected').attr('service_flag'));
        id_service_categories.push($('#lservices :selected').attr('id_service_categories'));
        
        $.ajax({
            type: "POST",
            //url: "Scheduler_controller/addvisits",
            url: "<?php echo base_url() . 'Scheduler_controller/addvisits'; ?>",
            data: {
                service_ids: service_ids.toString(),
                service_names: service_names.toString(),
                service_duration: service_duration.toString(),
                service_flag: service_flag.toString(),
                id_service_categories: id_service_categories,
                product_ids: product_ids,
                product_service_ids: product_service_ids,
                product_names: product_names,
                qty: qty,
                unit: unit,
                staff_id: staff_id,
                staff_name: staff_name,
                customer_id: customer_id,
                customer_name: customer_name,
                start: start,
                visit_id: visit_id,
                last_color_code: last_color_code,
                loyalty_service: 'Y'
            },
            success: function(data) {
                var result = data.split("|");
                if (result[0] === "success") {
                    clearvisit();
                    toastr.success('Visit created!', 'Done!');
                    //newEvents();
                    $('#event-modal').modal('hide');

                    $('#calendar').fullCalendar('refetchEvents');

                } else if (result[0] === "already_exist") {
                    swal({
                        title: "Service already added!",
                        text: '',
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                } else {
                    swal({
                        title: "Error",
                        text: result[1],
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
                }
            }
        });
        
    }

    function updatevisit() {

        var visit_id = $("#visit-id").val() !== "" ? $("#visit-id").val() : 0;
        var customer_id = $("#visit-customerid").val();
        var customer_name = $("#visit-customername").val();
        var staff_id = localStorage.getItem('staff_id');
        var staff_name = localStorage.getItem('staff_name');
        var start = localStorage.getItem('start');
        var service_ids = [];
        var service_names = [];
        var product_ids = [];
        var product_service_ids = [];
        var product_names = [];
        var qty = [];
        var unit = [];
        var service_duration = [];
        var service_flag = [];
        var id_service_categories = [];

        $('input[name=idbusiness_services]:checked').each(function() {
            service_ids.push($(this).val());
            service_names.push($(this).attr('service_name'));
            service_duration.push($(this).attr('service_duration'));
            service_flag.push($(this).attr('flag'));
            id_service_categories.push($(this).attr('id_service_category'));
        });

        $('input[name=idbusiness_products]:checked').each(function() {
            product_ids.push($(this).val());
            product_service_ids.push($(this).attr('product_service_id'));
            product_names.push($(this).attr('product_name'));
            qty.push($(this).attr('qty'));
            unit.push($(this).attr('unit'));
        });

        if (service_ids.length === 0) {

            swal({
                title: "You have not selected any service",
                text: "Selection of a service is mandatory. Please select a service.",
                type: "error",
                confirmButtonText: 'OK!'
            });

            return false;

        }

        //var dataInfo = 'service_ids=' +service_ids+ '&service_names=' +service_names+ '&service_duration=' +service_duration+ '&product_ids=' +product_ids+ '&product_service_ids=' +product_service_ids+ '&product_names=' +product_names+ '&staff_id=' +staff_id+ '&staff_name=' +staff_name+ '&customer_id=' +customer_id+ '&customer_name=' +customer_name+ '&start=' +start+ '&visit_id=' +visit_id;

        $.ajax({
            type: "POST",
            //url: "Scheduler_controller/addvisits",
            url: "<?php echo base_url() . 'Scheduler_controller/addvisits'; ?>",
            //data: dataInfo,
            data: {
                service_ids: service_ids.toString(),
                service_names: service_names.toString(),
                service_duration: service_duration.toString(),
                service_flag: service_flag.toString(),
                id_service_categories: id_service_categories,
                product_ids: product_ids,
                product_service_ids: product_service_ids,
                product_names: product_names,
                qty: qty,
                unit: unit,
                staff_id: staff_id,
                staff_name: staff_name,
                customer_id: customer_id,
                customer_name: customer_name,
                start: start,
                visit_id: visit_id
            },
            success: function(data) {
                var result = data.split("|");
                if (result[0] === "success") {

                    //clearvisit();
                    toastr.success('Visit updated!', 'Done!');
                    //newEvents();
                    $('#eventview').modal('hide');

                    $('#calendar').fullCalendar('refetchEvents');

                } else if (result[0] === "already_exist") {
                    swal({
                        title: "Service already added!",
                        text: '',
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                } else {
                    swal({
                        title: "Error",
                        text: result[1],
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
                }
            }
        });

    }

    function addServiceRows() {

        var mhtml = "";
        var exists = 0;

        if ($('input[name=id_business_services]:checked').val() == undefined) {
            swal({
                title: "Service is not selected!",
                text: 'Please a service as its mandatory field.',
                type: "info",
                confirmButtonText: 'OK!'
            });
            return false;
        }

        if ($('input[name=id_business_services]:checked').val() != undefined) {

            $('#visit-service-list').find("td.id").each(function(index) {
                if ($(this).html() === $("input[name=id_business_services]:checked").val()) {
                    exists = 1;
                }
            });

            mhtml += '<tr>';
            mhtml += '<td style="display:none;">' + $("#visit-customer-id").val() + '</td>';
            mhtml += "<td class='id'>" + $("input[name=id_business_services]:checked").val() + "</td>";
            mhtml += "<td>" + $("input[name=id_business_services]:checked").attr('service_name') + "</td>";
            mhtml += "<td style='display:none;'>";
            $('#visit-staff').children('option:selected').each(function() {
                mhtml += " " + $(this).val();
            });
            mhtml += "</td>";
            mhtml += "<td>";
            $('#visit-staff').children('option:selected').each(function() {
                mhtml += " " + $(this).text();
            });
            mhtml += "</td>";

            mhtml += "<td style='display:none;'>";
            $('input[name=id_business_products]:checked').each(function() {
                mhtml += " " + $(this).val() + " |";
            });
            mhtml += '</td>';
            mhtml += '<td>';
            $('input[name=id_business_products]:checked').each(function() {
                mhtml += " " + $(this).attr('product_name') + " |";
            });
            mhtml += '</td>';

            mhtml += '<td><span class="label label-danger" onclick="removeservice(' + $("input[name=id_business_services]:checked").val() + ')" style="cursor:pointer">x</span></td>';
            mhtml += "</tr>";
        }
        if (exists == 0) {
            $("#visit-service-list tbody").append(mhtml);
        } else {
            $('input[product_service_id=' + $('input[name=id_business_services]:checked').val() + ']').prop('checked', false);
            swal({
                title: "Service already added!",
                text: 'If you want to change this service, please remove and add again.',
                type: "info",
                confirmButtonText: 'OK!'
            });

        }
    }

    function checkopenvisit(cid) {

        $.ajax({
            type: 'POST',
            //url: 'visits_controller/getVisitbyCid',
            url: "<?php echo base_url() . 'visits_controller/getVisitbyCid'; ?>",
            data: {customerid: cid},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {

                if (data.length > 0) {
                    clearvisit();
                    fillvisit(data[0]['id_customer_visits']);
                } else {
                    $("#visit-id-1").val('');
                }

            }
        });

    }

    function getinhouseproducts() {
        $('#visit-prod').children().remove();
        $("#visit-prod").select2("val", "");
        $.ajax({
            type: 'POST',
            data:{param:'none'},
            //url: 'product_controller/getinhouseproducts',
            url: "<?php echo base_url() . 'product_controller/getinhouseproducts'; ?>",
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                chtml = "";
                current_cat = "";
                last_cat = "";
                for (x = 0; x < data.length; x++) {
                    current_cat = data[x]['id_business_brands'];
                    if (current_cat !== last_cat) {
                        if (x === 0) {
                            chtml += '<optgroup label="' + data[x]['business_brand_name'] + '">';
                            chtml += '<option value=' + data[x]['id_business_products'] + '>' + data[x]['product'] + '</option>';
                        } else {
                            chtml += '</optgroup>';
                            chtml += '<optgroup label="' + data[x]['business_brand_name'] + '">';
                            chtml += '<option value=' + data[x]['id_business_products'] + '>' + data[x]['product'] + '</option>';
                        }
                    } else {
                        chtml += '<option value=' + data[x]['id_business_products'] + '>' + data[x]['product'] + '</option>';
                    }
                    last_cat = data[x]['id_business_brands'];
                }
                chtml += '</optgroup>';
                $("#visit-prod").append(chtml);
            }
        });
    }

    function getstaff() {
        $('#visit-staff').children().remove();
        $("#visit-staff").select2("val", "");

        $('#order-staff').children().remove();
        $("#order-staff").select2("val", "");

        $.ajax({
            type: 'POST',
            data:{param:'none'},
            //url: 'staff_controller/presentstaff',
            url: "<?php echo base_url() . 'staff_controller/presentstaff'; ?>",
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                mhtml = "";
                for (x = 0; x < data.length; x++) {
                    //if(data[x]['staff_available']==''){
                    $('#visit-staff').append('<option value=' + data[x]['id_staff'] + '>' + data[x]['staff_fullname'] + '</option>');
                    //}
                    $('#order-staff').append('<option value=' + data[x]['id_staff'] + '>' + data[x]['staff_fullname'] + '</option>');

                    //fill 
                    if (data[x]['staff_available'] != '') {
                        mhtml += '<a href="javascript:void(0);" onclick="staff_client(' + data[x]['staff_available'] + ')">';
                    }
                    mhtml += '<div class="inbox-item">';
                    if (data[x]['staff_image'] != "") {
                        mhtml += '<div class="inbox-item-img"><img src="<?php echo base_url(); ?>assets/images/staff/' + data[x]['staff_image'] + '" class="img-circle" alt="' + data[x]['staff_fullname'] + '"></div>';
                    }
                    if (data[x]['staff_available'] != '') {
                        mhtml += '<p class="inbox-item-author">' + data[x]['staff_fullname'] + ' <span class="text-danger">Busy</span></p>';
                    } else {
                        mhtml += '<p class="inbox-item-author">' + data[x]['staff_fullname'] + '</p>';
                    }
                    mhtml += '<p class="inbox-item-text">' + data[x]['staff_cell'] + '</p>';
                    mhtml += '<p class="inbox-item-date">' + data[x]['timein'] + '</p>';
                    mhtml += '</div>';
                    if (data[x]['staff_available'] != '') {
                        mhtml += '</a>';
                    }
                }
                $("#presentstaff").html(mhtml);
            }
        });
    }

    function visitExist(id) {

        $("#visit_services ul").remove();
        $("#visit_products ul").remove();

        $.ajax({
            //url: 'Visits_controller/getvisitdetails',
            url: "<?php echo base_url() . 'Visits_controller/getvisitdetails'; ?>",
            //data: 'visit_id=' +id,
            data: {
                visit_id: id
            },
            type: 'POST',
            success: function(response) {
                var data = $.parseJSON(response);
                localStorage.setItem('visit_services', JSON.stringify(data['services']));
                $("#visit-id").val(id);
                $("#visit-customerid").val($('#txt-customer-id').val());
                $("#visit-customername").val($('#txt-customer-name').val());
                $("#labelcustomer").html('');
                $("#visit-customercell").val($('#txt-customer-cell').val());
                $("#visit-customeremail").val($('#txt-customer-email').val());
                $('#visitcustomername').html($('#txt-customer-name').val());
                $("#labelcustomer").html($('#txt-customer-name').val()+' '+$('#txt-customer-cell').val());
                $('#visitcustomercell').html($('#txt-customer-cell').val());

                $('#event-modal').modal('hide');

                $('#alreadyvisitid > strong').html(id);

                $('#eventview').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });

            }
        });
    }

    function openVisit() {

        var customer_id = $('#txt-customer-id').val();

        if (customer_id !== '') {

//            $.ajax({
//                type: 'POST',
//                //url: 'visits_controller/getVisitbyCid',
//                url: "<?php echo base_url() . 'visits_controller/getVisitbyCid'; ?>",
//                data: {
//                    customer_id: customer_id
//                },
//                dataType: "json",
//                cache: false,
//                async: true,
//                success: function(response) {
                    //if(response.length > 0){
//                        var scheduler_date = localStorage.getItem('start_date');
//                        var visit_service_date = response[0].visit_service_start.split("T");
//                        if(scheduler_date !== visit_service_date[0]){
//                            $('#event-modal').modal('hide');
//                            $('#invoice_button_visit_id').val(response[0].id_customer_visits);
//                            $('#invoiceButton').modal({
//                                backdrop:'static',
//                                keyboard:false,
//                                show:true
//                            });
//                            return false;
//                        }
//                        visitExist(response[0].id_customer_visits);
                    //} else{

                    $(".nicescroll_2").niceScroll({cursoropacitymin: 1});
                    $(".nicescroll_service_types").niceScroll({cursoropacitymin: 1});
                    

                    $("#visit-customer-id").val($("#txt-customer-id").val());
                    $("#visit-customer-name").val($("#txt-customer-name").val());
                    $("#labelcustomer").html($("#txt-customer-name").val()+' '+$("#txt-customer-cell").val());
                    $("#visit-customer-cell").val($("#txt-customer-cell").val());
                    $("#visit-customer-email").val($("#txt-customer-email").val());

//                        if(localStorage.getItem('customer_id') !== localStorage.getItem('txt-customer-id')){
//                            $('#visit-services ul').remove();
//                            $('#visit-products ul').remove();
//                        }

                    $('#visit-services-categories').html('');
                    $('#visit-services ul').remove();
                    $('#visit-products ul').remove();

                    localStorage.setItem('txt-customer-id', $("#txt-customer-id").val());

                    $("#divmain").hide();
                    
                    if($("#modal-header-title").html()==="Retail"){
                        $("#divvisit").hide();
                        $("#retail-divorder").fadeIn();
                    } else {
                        $("#divvisit").fadeIn();
                    }

                    //}
//                }
//            });

        }

    }

    function closelistopenapp() {
        $("#existingappointment").modal('hide');
        $("#appointment-customer-id").val($("#txt-customer-id").val());
        $("#appointment-customer-name").val($("#txt-customer-name").val());
        $("#add-appointment-modal").slideDown();
    }

    function updatecustomer() {
        $.ajax({
            type: 'POST',
            //url: 'customer_controller/updatecustomer',
            url: "<?php echo base_url() . 'customer_controller/updatecustomer'; ?>",
            data: $("#updateform").serialize(),
            success: function(data) {
                var result = data.split("|");
                if (result[0] === "success") {
                    $("#con-close-modal").hide();
                    getbyid(result[1]);
                    toastr.success('Customer updated with more info!', 'Great!');
                } else {
                    swal({
                        title: "Error",
                        text: result[1],
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
                }

            }
        });
    }

    function hidemultisearch() {
        $("#multiplesearch").slideUp();
    }

    function showcustomerdetails() {
        back("#divmain", "#con-close-modal");
    }
    
    function CheckCustomer_Exist(){
        
    }

    function addnewcustomer() {
        var customer_name = $("#txt-customer-name").val();
        var customer_cell = $("#txt-customer-cell").val();
        var customer_careof = $("#txt-customer-co").text();
        var flag = false;
        
        if(customer_cell.length !== 11){
             swal({
                        title: "Cell Length",
                        text: 'use 11 digits for cell number',
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
                    return false;
        }
        
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>customer_controller/CheckCustomer_Exist',
            data: {customer_name: customer_name, customer_cell: customer_cell},
            async: false,
            success: function(data){
                var exist = data;
                var name = "name "+customer_name.toLowerCase();
                var cell = "cell "+customer_cell;
                if(exist === name){ 
                    swal({
                        title: "Alert",
                        text: "Customer name & Cell number already exists! Add another?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function(isConfirm){
                        if (isConfirm) {
                          sumbit_customer();
                        } else {
                           flag = true;
                        }
                    });
                    
                }else if(exist === cell && $('#txt-customer-co').val()==''){ 
                    swal({
                        title: "Alert",
                        text: "Cell number already exists! Do you want to see the customer?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function(isConfirm){
                        if (isConfirm) {
                          //sumbit_customer();
                          $("#name-search").val('');
                          $("#card-search").val('');
                          $("#cell-search").val($("#txt-customer-cell").val());
                          general_search("#btncell-search");
                        } else {
                           flag = true;
                        }
                    });
                   
                } else{
                    sumbit_customer();
                }
               
            }
        });

    }
    function sumbit_customer(){
            $.ajax({
            type: 'POST',
            //url: 'customer_controller/addnew',
            url: "<?php echo base_url() . 'customer_controller/addnew'; ?>",
            data: $("#customerform").serialize(),
            success: function(data) {
                var result = data.split("|");
                if (result[0] === "success") {
                    getbyid(result[1]);
                    // Display a success toast, with a title
                    toastr.success('New Customer Created!', 'Cool!');
                } else {

                    swal({
                        title: "Error",
                        text: result[1],
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
                }
            }
        });
    }
    function addeditcustomer() {
        if ($("#btnupdate").text() === "Add New") {
           
            $("#customer-color").html("");
            var customer_name = $("#txt-customer-name").val().trim();
            customer_name = customer_name.split(" ");
            
            if (customer_name.length > 1) {

                if ($("#txt-customer-name").val() === "" || $("#txt-customer-cell").val() === "") {
                    swal({
                        title: "Add Name and Cell Phone",
                        text: "You forgot to enter the NAME, CELL PHONE of the new customer. Let's start with putting in this mandatory information first.",
                        type: "warning",
                        confirmButtonText: 'OK!'
                    });
                } else {
                    addnewcustomer();
                }

            } else {

                swal({
                    title: "Please enter Customer's last name also!",
                    text: "",
                    type: "error",
                    confirmButtonText: 'OK!'
                });

            }
        } else if ($("#btnupdate").text() === "Update") {
            showcustomerdetails();
        }
    }

function addeditcustomer1() {
        if ($("#btnupdate1").text() === "Add New") {
           
            $("#customer-color").html("");
            var customer_name = $("#txt-customer-name").val().trim();
            customer_name = customer_name.split(" ");
            
            if (customer_name.length > 1) {

                if ($("#txt-customer-name").val() === "" || $("#txt-customer-cell").val() === "") {
                    swal({
                        title: "Add Name and Cell Phone",
                        text: "You forgot to enter the NAME, CELL PHONE of the new customer. Let's start with putting in this mandatory information first.",
                        type: "warning",
                        confirmButtonText: 'OK!'
                    });
                } else {
                    addnewcustomer();
                }

            } else {

                swal({
                    title: "Please enter Customer's last name also!",
                    text: "",
                    type: "error",
                    confirmButtonText: 'OK!'
                });

            }
        } else if ($("#btnupdate1").text() === "Update") {
            removeNiceScroll();
            $("#divvisit").hide();
            showcustomerdetails();
        }
    }


    function fillupdateform(data) {
        if (data[0]['customer_allergies'] != "" || data[0]['customer_alert'] != "") {
            $("#alert_text").html('<strong>Customer Alert! Allergic to :</strong> ' + data[0]['customer_allergies'] + ' | <strong>Other Alerts : </strong>' + data[0]['customer_alert']);
            $("#customer_alert").show();
        }
        var d2 = "";
        var d1 = "";
        if (data[0]['customer_anniversary'] !== "" && data[0]['customer_anniversary'] !== null) {
            var d2 = new Date(Date.parse(data[0]['customer_anniversary']));
            m = d2.getMonth() + 1;
            d1 = d2.getFullYear() + "/" + m + "/" + d2.getDate();
        }

        $("#detail-customer-id").val(data[0]['id_customers']);
        $("#detail-customer-name").val(data[0]['customer_name']);
        $("#detail-customer-cell").val(data[0]['customer_cell']);
        $("#detail-customer-card").val(data[0]['customer_card']);
        $("#detail-customer-gender").val(data[0]['customer_gender']);
        $("#detail-customer-email").val(data[0]['customer_email']);
        $("#detail-customer-address").val(data[0]['customer_address']);
        $("#detail-customer-bday").val(data[0]['customer_birthday']);
        $('#detail-customer-bmonth').val(data[0]['customer_birthmonth']);
        if (d1 !== "") {
            $('#detail-customer-wedding').val(d1);
        }
        $('#detail-customer-type').val(data[0]['customer_type']);
        $('#detail-customer-phone1').val(data[0]['customer_phone1']);
        $('#detail-customer-phone2').val(data[0]['customer_phone2']);
        $('#detail-customer-allergies').val(data[0]['customer_allergies']);
        $('#detail-customer-alert').val(data[0]['customer_alert']);
        $('#detail-customer-profession').val(data[0]['profession']);
        
        $('#detail-customer-careof').val(data[0]['customer_careof']);
        $("#detail-careof-label").html(data[0]['customer_careof']);
        enable_detailcareof();
//        $('#div_careof').hide();
//        $('#div_careof_display').show();


    }

    function clearall() {

        clearcustomerform();

        $('#name-search').val('');
        $('#cell-search').val('');
        $('#card-search').val('');
        $('#newcustomeradding').hide();

        $('#multiplesearch').hide();

    }

    function clearcustomerform() {
       
        if ($("#txt-customer-email").length > 0) {
            mfield = $("#txt-customer-email").parsley();
            window.ParsleyUI.removeError(mfield, 'required');
            window.ParsleyUI.removeError(mfield, 'email');
            $("#txt-customer-email").removeClass('parsley-error');
        }
        if ($("#detail-customer-email").length > 0) {
            mfield = $("#detail-customer-email").parsley();
            window.ParsleyUI.removeError(mfield, 'required');
            window.ParsleyUI.removeError(mfield, 'email');
            $("#detail-customer-email").removeClass('parsley-error');
        }

        //localStorage.setItem("customer_id", "");
        localStorage.setItem("customer_name", "");
        localStorage.setItem("customer_cell", "");
        localStorage.setItem("customer_email", "");

        //$('#name-search').val('');
        $("#txt-customer-id").val('');
        $("#txt-customer-name").val('');
        $("#labelcustomer").html('');
        $("#txt-customer-cell").val('');
        $("#txt-customer-email").val('');
        $("#txt-customer-address").val('');
        $("#txt-customer-profession").val('');
        
        $('#txt-customer-bday option:eq(0)').prop('selected', true);
        $('#txt-customer-bmonth option:eq(0)').prop('selected', true);
        $("#img-customer").attr('src', '<?php echo base_url(); ?>assets/images/users/avatar-1.jpg');
        $("#btnupdate").html("Add New");
        $("#imguploader").hide();
        $("#imgdisplay").show();
        $("#customer_alert").hide();
        
        $('#txt-customer-display').val('');
        $('#div_careof').show();
        enable_careof();
        $('#div_careof_display').hide();
        
        
    }

    function fillcustomerform(data,type) {

        removeNiceScroll();
        $('.visit-message').show();
        $('#schedulerFunctionBtn').show();

        clearcustomerform();
        var mhtml = '';
        
        ////console.log(data.length);
        if (data.length > 0 && type==='search') {    
            $(".nicescroll_1").niceScroll({cursoropacitymin: 1});
            ////console.log( data[0]['customer_name']);
            for (x = 0; x < data.length; x++) {
                ////console.log(data[x]['customer_name']);
                var flag=""; var color="";
                if(data[x]['customer_type']=="red"){flag="zmdi zmdi-flag txt-danger"; color="red";}
                else if(data[x]['customer_type']=="orange") {flag="ti-star";color="orange";}
                else if(data[x]['customer_type']=="green") {flag="zmdi zmdi-flag";color="green";}
                
                mhtml += '<a href="javascript:void(0)" onclick="getbyid(' + data[x]['id_customers'] + ');">';
                mhtml += '<div class="inbox-item">';
                mhtml += '<div class="inbox-item-img"><img src="<?php echo base_url(); ?>assets/images/users/' + data[x]['customer_image'] + '" class="img-circle" alt=""></div>';
                mhtml += '<p class="inbox-item-author">' + data[x]['customer_name'] + ' <i style="color:'+color+'; font-weight:bold;" class="'+flag+'"></i></p>';
                mhtml += '<p class="inbox-item-text">' + data[x]['customer_cell'] + '</p>';
                mhtml += '<p class="inbox-item-date">' + data[x]['customer_card'] + ' | '+  data[x]['customer_email'] + '</p>';
                mhtml += '</div>';
                mhtml += '</a>';
            }
            $("#customer_list").html(mhtml);
            $("#divmain").hide();
            $("#divsearch").hide();
            $("#multiplesearch").show();
            //back("#divsearch", "#multiplesearch");
            $('#newcustomeraddinglist').fadeIn();
            clearcustomerform();
        //} else if (data.length === 1 && type==='select') {
        } else if (type==='select') {

            
            var flag=""; var color="";
            if(data[0]['customer_type']=="red"){flag="zmdi zmdi-flag txt-danger"; color="red";}
            else if(data[0]['customer_type']=="orange") {flag="ti-star txt";color="orange";}
            else if(data[0]['customer_type']=="green") {flag="zmdi zmdi-flag";color="green";}
            
            $('#customer-color').html(' <i class="'+flag+'" style="color:'+color+';"></i>');
            
            $('#txt-customer-name').prop('readonly', true);
            $('#txt-customer-email').prop('readonly', true);
            $('#txt-customer-cell').prop('readonly', true);
            $('#txt-customer-address').prop('readonly', true);
            $('#txt-customer-bday').prop('disabled', true);
            $('#txt-customer-bmonth').prop('disabled', true);
            $('#txt-customer-gender').prop('disabled', true);
            $('#txt-loyalty-points').prop('readonly', true);
            
            $('#txt-customer-profession').prop('readonly', true);
            $('#txt-customer-profession').val(data[0]['profession']);
                        
            $('#txt-customer-co').val(data[0]['customer_careof']);
            $('#txt-customer-display').prop('readonly', true);
           // //console.log(data[0]['customer_careof']);
            $('#txt-customer-display').val(data[0]['customer_careof']);
            $('#div_careof').hide();
            $('#div_careof_display').show();
            
            $("#txt-customer-id").val(data[0]['id_customers']);
            $("#txt-customer-name").val(data[0]['customer_name']);
            $("#labelcustomer").html(data[0]['customer_name']+' '+data[0]['customer_cell']);
            
            $("#labelvouchercustomer").html(data[0]['customer_name']+' '+data[0]['customer_cell']);
            $("#voucher-customer-id").val(data[0]['id_customers']);
            $("#voucher-customer-name").val(data[0]['customer_name']);
            
            $("#labelretailcustomer").html(data[0]['customer_name']+' '+data[0]['customer_cell']);
            
            $("#txt-customer-cell").val(data[0]['customer_cell']);
            $("#txt-customer-gender").val(data[0]['customer_gender']);
           
            $("#txt-customer-loyalty").val(data[0]['customer_loyalty_points']);
            $("#txt-customer-email").val(data[0]['customer_email']);
            $("#txt-customer-address").val(data[0]['customer_address']);
            $("#txt-customer-bday").val(data[0]['customer_birthday']);
            //$('#txt-customer-bmonth option[value="' + data[0]['customer_birthmonth'] + '"]').attr("selected", "selected");
            $('#txt-customer-bmonth').val(data[0]['customer_birthmonth']);
            $("#img-customer").attr('src', '<?php echo base_url(); ?>assets/images/users/' + data[0]['customer_image']);
            $("#btnupdate").html("Update");
            $("#img-customer-file").val(data[0]['customer_image']);
            $("#imguploader").hide();
            $("#imgdisplay").show();

            $('#multiplesearch').hide();
            
            
             if($("#modal-header-title").html()==="Retail"){
                retail_openOrder(0,data[0]['id_customers']);
                 
                // retail_checkopenorder(data[0]['id_customers']);
                back("#divsearch", "#retail-divorder");

              //  $("#divvisit").hide();
              //  $("#retail-divorder").fadeIn();
            } else if($("#modal-header-title").html()==="Add Customer Visit") {
                openVisit();
                //back("#divsearch", "#divmain");
                back("#divsearch", "#divvisit");
            } else if($("#modal-header-title").html()==="Gift Voucher") {
                
                 back("#divsearch", "#gift-voucher");
            }
            
           
           if(parseFloat(data[0]['loyalty_points'])>0){
               $("#lcustomer").html(data[0]['customer_name']);
               $("#lpoints").html(data[0]['customer_loyalty_points']);  
               get_loyaltyservices(parseFloat(data[0]['customer_loyalty_points']));              
               
               $("#loyaltydiv").show();
           } else {$("#loyaltydiv").hide();}
            
            localStorage.setItem("customer_id", data[0]['id_customers']);
            localStorage.setItem("customer_name", data[0]['customer_name']);
            localStorage.setItem("customer_cell", data[0]['customer_cell']);
            localStorage.setItem("customer_email", data[0]['customer_email']);
            localStorage.setItem("loyalty_points", data[0]['customer_loyalty_points']);
            get_customerbalance(data[0]['id_customers']);
            fillupdateform(data);
            
        } else {
            $('#newcustomeradding').fadeIn();
            clearcustomerform();
        }
    }
    function get_loyaltyservices(loyaltypoints){
        $("#lservices").children().remove();
        $.ajax({
            type: 'POST',
            //url: 'customer_controller/searchid',
            url: "<?php echo base_url() . 'service_controller/get_loyaltyservices'; ?>",
            data: {loyalty_points: loyaltypoints},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                for (var x = 0; x < data.length; x++) {
                    $("#lservices").append("<option service_ids=" + data[x]['id_business_services'] + " service_names=" + data[x]['service_name'] + "  service_duration=" + data[x]['duration'] + "  service_flag='servicetype'  id_service_categories=" + data[x]['id_service_category'] + "  value='"+ data[x]['service_id'] +"'>"+ data[x]['service_name']+" "+ data[x]['service_desc']  +"</option>");
                }
            }
        });
    
    }
    function getbyid(customerid) {
        $.ajax({
            type: 'POST',
            //url: 'customer_controller/searchid',
            url: "<?php echo base_url() . 'customer_controller/searchid'; ?>",
            data: {id: customerid},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                fillcustomerform(data,'select');
                //$("#multiplesearch").slideUp();
            }
        });
        get_customerbalance(customerid);
    }

    function get_customerbalance(customerid) {
         var link="";
        $.ajax({
            type: 'POST',
            //url: 'customer_controller/customer_balance',
            url: "<?php echo base_url() . 'customer_controller/customer_balance'; ?>",
            data: {id: customerid},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                $('#balanceid').html('');
               
                if(data.length>0){
                    
                    for(x=0; x<data.length;x++){
                        if (data[x]['invoice_type'] == 'service') {
                            link += '<a class="btn btn-danger waves-effect waves-light m-l-5 m-b-5 btn-sm" target="_blank" href="<?php echo base_url('open_recovery_invoice'); ?>/' + data[x]['id_invoice'] + '/' + data[x]['visit_id'] + '">Rs. '+ data[x]['totalbalance'] +'</a>';
                        } else if (data[x]['invoice_type'] == 'sale') {
                            link += '<a class="btn btn-danger waves-effect waves-light m-l-5 m-b-5 btn-sm" target="_blank" href="<?php echo base_url('open_recovery_order_invoice'); ?>/' + data[x]['id_invoice'] + '/' + data[x]['visit_id'] + '">Rs. '+ data[x]['totalbalance'] +'</a>';
                        }
                    }
                    $('#balanceid').addClass('text-danger').html('Customer has balances of : ' + link);
                    
//                    if (data[0]['totalbalance'] != null && parseInt($('#txt-customer-id').val()) > 1) {
//                        var link;
//                        if (data[0]['invoice_type'] == 'service') {
//                            link = '<a class="btn btn-primary waves-effect waves-light m-b-5 btn-sm" target="_blank" href="<?php echo base_url('open_recovery_invoice'); ?>/' + data[0]['id_invoice'] + '/' + data[0]['visit_id'] + '">View</a></h3>';
//                            $('#balanceid').addClass('text-danger').html('Customer has balances of : Rs.' + data[0]['totalbalance'] + ' ' + link);
//                        } else if (data[0]['invoice_type'] == 'sale') {
//                            link = '<a class="btn btn-primary waves-effect waves-light m-b-5 btn-sm" target="_blank" href="<?php echo base_url('open_recovery_order_invoice'); ?>/' + data[0]['id_invoice'] + '/' + data[0]['visit_id'] + '">View</a></h3>';
//                            $('#balanceid').addClass('text-danger').html('Customer has balance of : Rs.' + data[0]['totalbalance'] + ' ' + link);
//                        }
//                    } else {
//                        $('#balanceid').html('');
//                    }
                } else {
                    $('#balanceid').html('');
                }
            }
        });
    }
    
    //This function is calling from calendar_js file line number:250 under scheduler click exist event
    function get_customerbalance_exist_event(customerid) {
    var link="";
        $.ajax({
            type: 'POST',
            //url: 'customer_controller/customer_balance',
            url: "<?php echo base_url() . 'customer_controller/customer_balance'; ?>",
            data: {id: customerid},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                $('#customerbalanceid').html('');
                
                if(data.length>0){
                    if (parseInt(customerid) > 1) {
                        for(x=0; x<data.length;x++){
                            
                            if (data[x]['invoice_type'] == 'service') {
                                link += '<a class="btn btn-danger waves-effect waves-light m-l-5 m-b-5 btn-sm" target="_blank" href="<?php echo base_url('open_recovery_invoice'); ?>/' + data[x]['id_invoice'] + '/' + data[x]['visit_id'] + '">Rs. '+ data[x]['totalbalance'] +'</a>';
                            } else if (data[x]['invoice_type'] == 'sale') {
                                link += '<a class="btn btn-danger waves-effect waves-light m-l-5 m-b-5 btn-sm" target="_blank" href="<?php echo base_url('open_recovery_order_invoice'); ?>/' + data[x]['id_invoice'] + '/' + data[x]['visit_id'] + '">Rs. '+ data[x]['totalbalance'] +'</a>';
                            }
                        }
                       
                        $('#customerbalanceid').addClass('text-danger').html('Customer has balances of : ' + link);
                    }
//                    if (data[0]['totalbalance'] !== null && parseInt(customerid) > 1) {
//                        var link;
//                        if (data[0]['invoice_type'] == 'service') {
//                            link = '<a class="btn btn-primary waves-effect waves-light m-b-5 btn-sm" target="_blank" href="<?php echo base_url('open_recovery_invoice'); ?>/' + data[0]['id_invoice'] + '/' + data[0]['visit_id'] + '">View</a></h3>';
//                            $('#customerbalanceid').addClass('text-danger').html('Customer has balance of : Rs.' + data[0]['totalbalance'] + ' ' + link);
//                        } else if (data[0]['invoice_type'] == 'sale') {
//                            link = '<a class="btn btn-primary waves-effect waves-light m-b-5 btn-sm" target="_blank" href="<?php echo base_url('open_recovery_order_invoice'); ?>/' + data[0]['id_invoice'] + '/' + data[0]['visit_id'] + '">View</a></h3>';
//                            $('#customerbalanceid').addClass('text-danger').html('Customer has balance of : Rs.' + data[0]['totalbalance'] + ' ' + link);
//                        }
//                    } else {
//                        $('#customerbalanceid').html('');
//                    }
                } else {
                    $('#customerbalanceid').html('');
                }
            }
        });
    }

    function openmain() {
        clearorder();
        clearvisit();
        clearappointment();
        if ($('#divvisit').is(':visible')) {
            $("#divvisit").slideUp();
        }
        if ($('#divorder').is(':visible')) {
            $("#divorder").slideUp();
        }
        $("#divmain").slideDown();
    }

    function fillBday() {
        for (x = 1; x <= 31; x++) {
            $("#txt-customer-bday").append('<option value=' + x + '>' + x + '</option>');
            $("#detail-customer-bday").append('<option value=' + x + '>' + x + '</option>');

        }
    }

    //This function is using in Add customer visit modal in account button...for customer_id from line number 167 file scheduler_modal.php...
    function get_customer_id_for_account(idcustomer) {
        return $.ajax({
            type: 'POST',
            data:{param:'none'},
            //url: 'customer_controller/get_customer_openvisit/'+idcustomer,
            url: "<?php echo base_url() . 'customer_controller/get_customer_openvisit/'; ?>" + idcustomer,
            async: false,
            success: function(data) {
                //console.log(data);
            }
        }).responseText;

    }

    function openAccount() {
        if(parseInt($('#visit-customerid').val()) > 1){
            var customer_id = $('#visit-customerid').val();
             <?php if( $this->session->userdata('role')=="Sh-Users"){ ?>
                window.open('<?php echo base_url();?>sh_customer_previous_visit/' + customer_id);
            <?php } else {?>
                 window.open('<?php echo base_url();?>customer_previous_visit/' + customer_id);
            <?php } ?>
        }
    }

    function previousdirect() {
        if(parseInt($('#txt-customer-id').val()) > 1){
            var customer_id = $('#txt-customer-id').val();
            <?php if( $this->session->userdata('role')=="Sh-Users"){ ?>
                window.open('<?php echo base_url();?>sh_customer_previous_visit/' + customer_id);
            <?php } else {?>
                 window.open('<?php echo base_url();?>customer_previous_visit/' + customer_id);
            <?php } ?>
        }

    }
    
    function halfday_off(tagged){
        full_halfdayoff(tagged);
    }
    
    function fullday_off(tagged){
        full_halfdayoff(tagged);
    }

    function full_halfdayoff(tagged) {
        var staff_id = $('.staffdayid').attr('staff_id');
        var block_calendar_date = $('.staffdayid').attr('block_calendar_date');
        var block_start_time = $('#block_start_time').text();
        var block_end_time = $('#block_end_time').text();
        $('#tagged').html('');
        $('#tagged').text(tagged);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('scheduler_controller/half_full_dayoff'); ?>',
            data: {
                staff_id: staff_id,
                tagged: tagged,
                block_calendar_date: block_calendar_date,
                block_start_time: block_start_time,
                block_end_time: block_end_time
            },
            success: function(data) {
                if (data) {
                    var result = data.split("|");
                    if (result[0] === 'Block' || result[0] === 'Event') {
                        swal({
                            title: 'Alert!',
                            text: 'Please remove all events from staff first!',
                            type: 'warning',
                            confirmButtonText: 'OK!'
                        });
                        return false;
                    }
                    
                    if(tagged === "fullday"){
                        $('#set_halffull_block').html('');
                        $('#set_halffull_block').text('Full Day Off');
                    }
                    if(tagged === "halfday"){
                        $('#set_halffull_block').html('');
                        $('#set_halffull_block').text('Half Day Off');
                    }
                    
                    $('#staffreporting').modal('hide');
                    getBlockingEvents();
                    $('#full_half_blocktime').modal('show');
                }
            }
        });
    }
    
    function saveFullBlockTime(){
        
        var block_calendar_date = $('.staffdayid').attr('block_calendar_date');
        var block_event_id = $('#set_blocking_events option:selected').val();
        var block_event_name = $('#set_blocking_events option:selected').text();
        var block_event_duration = $('#set_blocking_events option:selected').attr('duration');
        var blocking_remarks = $('#set_blocking_remarks').val();
        var staff_id = $('.staffdayid').attr('staff_id');
        var block_start_time = $('#block_start_time').text();
        var block_end_time = $('#block_end_time').text();
        var tagged = $('#tagged').text();
        if(block_event_id === 'select'){
            swal({
                title: "Please select a block event first.",
                text: '',
                type: 'error',
                confirmButtonText: 'OK!'
            });
            return false;
        }
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url("Scheduler_controller/half_fulltime_block"); ?>',
            data: {
                block_event_id:block_event_id,
                block_event_name:block_event_name,
                block_event_duration:block_event_duration,
                blocking_remarks:blocking_remarks,
                staff_id:staff_id,
                start:block_start_time,
                end:block_end_time,
                tagged: tagged,
                block_calendar_date: block_calendar_date
            },
            success: function(data) {
                if(data === 'success'){
                    $('#full_half_blocktime').modal('hide');
                    $('#calendar').fullCalendar('refetchEvents');
                    $('#set_blocking_remarks').val('');
                } else{
                    swal({
                        title: "Error! There is a error while blocking staff time.",
                        text: '',
                        type: 'error',
                        confirmButtonText: 'OK!'
                    });
                }
            }
        });
    }
    
    function reminder_message(tagged){
    
        var reminder = '';
        var customer_visit_id = $('#customer_visit_id_reminder').val();
        var customer_visit_service_id = $('#id_visit_service_reminder').val();
        var id_visit_service_staff = $("#id_visit_service_staff_reminder").val();
        if( $('#'+tagged).is(':checked') ){
            reminder = 'Y';
        }else{
            reminder = 'N';
        }
        
        //console.log(tagged);
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>scheduler_controller/reminder_message_update',
            data: {reminder: reminder, tagged: tagged, customer_visit_id: customer_visit_id, id_visit_services: customer_visit_service_id, id_visit_service_staff: id_visit_service_staff},
            success: function(data){
                var result = data.split('|');
                if(result[0] === 'success' && result[2] === 'Y'){
                    toastr.success('Reminder Added!', 'Done!');
                } else if(result[0] === 'success' && result[2] === 'N'){
                    toastr.success('Reminder Removed!', 'Done!');
                }
            }
        });
    }
    
    function newcustomerbtn_show_hide(a){
        if(a === ""){
            $('#newcustomeradding').css('display', 'none');
        }
    }
    
    function general_search(from){
     
        var name = $("#name-search").val();
        var cell = $("#cell-search").val();
        var card = $("#card-search").val();
        ////console.log(cell);
        $(from).html('<i class="fa fa-spin fa-spinner"></i>');
        $('#name-search').prop('readonly', true);
        $('#cell-search').prop('readonly', true);
        $('#card-search').prop('readonly', true);
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url() . 'customer_controller/generalsearch'; ?>",
                data: {customername: name, customercell: cell, customercard: card},
                dataType: "json",
                cache: false,
                async: true,
                success: function(data) {
                    if(data.length==1){
                        fillcustomerform(data,'select');
                    } else{
                         fillcustomerform(data,'search');
                    } 
                    $('#btnname-search').html('<i class="fa fa-tag"></i>');
                    $('#btncell-search').html('<i class="fa fa-phone"></i>');
                    $('#btncard-search').html('<i class="fa fa-credit-card"></i>');
                    $('#name-search').prop('readonly', false);
                    $('#cell-search').prop('readonly', false);
                    $('#card-search').prop('readonly', false);
                }
            });
        
    }
    
    function mark_inservice(){
    
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() . 'customer_controller/mark_inservice'; ?>",
            data: {visit_id: $("#visit-id").val()},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                
                toastr.success('Updated!', 'Done!');
                $('#eventview').modal('hide');
               
                //if(view.name === view_style){
                    newEvents();
                    customCalendarView();
                //}

                $('#last_update_date').val(data);
            }
        });
        
    }
    
    function add_remarks(){
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>visits_controller/add_visit_remarks",
            data: {visit_id: $("#visit-id").val(), visitremarks:$("#txtvisitremarks").val()},          
            success: function(data) {
               
                toastr.success('Updated!', 'Done!');
                $('#eventview').modal('hide');
               
                //if(view.name === view_style){
                    newEvents();
                    customCalendarView();
                //}

                $('#last_update_date').val(data);
            }
        });
    }
</script>
