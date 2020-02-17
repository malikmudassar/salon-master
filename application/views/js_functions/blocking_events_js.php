<script>
    
    function open_blocking_events(){
        getBlockingEvents();
        
        $('#btn_block_selectedstaff').html('Block ' + localStorage.getItem('staff_name'));
        $('#blocking_remarks').val('');
        back("#divsearch", "#blocktime");
    }
    
    function removeBlockStaffTime(){
        var block_time_event_id = $('#block-event-id').val();
        swal({
            title: 'Confirmation',
            text: "Are you sure you want to delete the block staff time event permanently?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff5b5b !important',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes'
        },function() {
            $.ajax({
                type: 'POST',
                //url: 'Scheduler_controller/removeStaffBlockTime',
                url: '<?php echo base_url().'Scheduler_controller/removeStaffBlockTime'; ?>',
                data: {
                    block_time_event_id:block_time_event_id
                },
                success: function(data) {
                    if(data === 'success'){
                        $('#block_staff_modal').modal('hide');
                        toastr.success('Block staff time event deleted!!', 'Done!');
                        $('#calendar').fullCalendar('refetchEvents');
                    } else{
                        swal({
                            title: "Error!.",
                            text: '',
                            type: 'error',
                            confirmButtonText: 'OK!'
                        });
                    }
                }
            });
        });
    }
    
    function saveBlockTime(){
        
        var block_event_id = $('#blocking_events option:selected').val();
        var block_event_name = $('#blocking_events option:selected').text();
        var block_event_duration = $('#blocking_events option:selected').attr('duration');
        var blocking_remarks = $('#blocking_remarks').val();
        var staff_id = localStorage.getItem('staff_id');
        var staff_name = localStorage.getItem('staff_name');
        var start = localStorage.getItem('start');
        
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
            //url: 'Scheduler_controller/addStaffBlockTime',
            url: '<?php echo base_url().'Scheduler_controller/addStaffBlockTime'; ?>',
            data: {
                block_event_id:block_event_id,
                block_event_name:block_event_name,
                block_event_duration:block_event_duration,
                blocking_remarks:blocking_remarks,
                staff_id:staff_id,
                staff_name:staff_name,
                start:start
            },
            success: function(data) {
                if(data === 'success'){
                    $('#event-modal').modal('hide');
                    $('#calendar').fullCalendar('refetchEvents');
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
    
    
    function saveBlockTimeAll(){
        
        var block_event_id = $('#blocking_events option:selected').val();
        var block_event_name = $('#blocking_events option:selected').text();
        var block_event_duration = $('#blocking_events option:selected').attr('duration');
        var blocking_remarks = $('#blocking_remarks').val();
        var staff_id = localStorage.getItem('staff_id');
        var staff_name = localStorage.getItem('staff_name');
        var start = localStorage.getItem('start');
        
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
            //url: 'Scheduler_controller/addStaffBlockTime',
            url: '<?php echo base_url().'Scheduler_controller/addStaffBlockTimeAll'; ?>',
            data: {
                block_event_id:block_event_id,
                block_event_name:block_event_name,
                block_event_duration:block_event_duration,
                blocking_remarks:blocking_remarks,
                staff_id:staff_id,
                staff_name:staff_name,
                start:start
            },
            success: function(data) {
                console.debug(data);
                if(data === 'success'){
                    $('#event-modal').modal('hide');
                    $('#calendar').fullCalendar('refetchEvents');
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
    
    
    function getBlockingEvents() {
        $('#event-modal > div').width('50%');
        $('#modal-header-title').html('Block Staff Time');
        $.ajax({
            type: 'POST',
            //url: 'Scheduler_controller/getBlockingEvents',
            url: '<?php echo base_url().'Scheduler_controller/getBlockingEvents'; ?>',
            data:{csrf:'passed'},
            dataType: 'json',
            cache: false,
            async: true,
            success: function(data) {
                var html = "";
                for (var x = 0; x < data.length; x++) {
                    html += '<option duration="'+data[x].block_event_duration+'" value="'+data[x].id_block_events+'">'+data[x].block_event_name+'</option>';
                }
                $('#blocking_events').html(html);
                $('#blocking_events').prepend('<option value="select" selected>Select</option>');
                
                $('#set_blocking_events').html(html);
                $('#set_blocking_events').prepend('<option value="select" selected>Select</option>');
            }
        });
    }
    
    $(window).load(function(){
        $('#xsdff').on('click', function(){
            
        });
    });
    
</script>