<script>
    
    function opencc(){
        $("#mode").html('Card');
        $("#checkp").hide();
        $("#ccp").show();
        $('#ccno').val('')
        $('#checkno').val('')
    }
    
    function openbank(mode){
        $("#mode").html(mode);
        $("#checkp").show();
        $("#ccp").hide();
        $('#ccno').val('')
        $('#checkno').val('')
    }
    
    function opencash(){
        $("#mode").html('Cash');
        $("#checkp").hide();
        $("#ccp").hide();
        $('#ccno').val('')
        $('#checkno').val('')
    }
    
    function removeVoucherNiceScrollbars(){
        
        $(".nicescroll_4").getNiceScroll().remove();
        $(".nicescroll_5").getNiceScroll().remove();
        
    }
    
    function clearVoucher() {
        
        $('input[name=voucher-type]').prop('checked', false);
        $('#voucher-services-types').html('');
        $('#voucher-services-categories').html('');
        $('#voucher-services').html('');
        $('#voucher-valid-until').val('');
        $('#voucher-services-div').hide();
        
    }
    
    function generateGiftVoucher(){
        
        var customer_id = $('#voucher-customer-id').val();
        var is_type_checked = $('input[name=voucher-type]').is(":checked");
        var type = $('input[name=voucher-type]:checked').val();
        var valid_until = $('#voucher-valid-until').val();
        var price = $('#voucher-price').val();
        var voucher_number_option = $('#voucher-number-optional').val();
        var voucher_heading =  $('#voucher-heading').val();
        var service_ids = "";
        var service_names = "";
        var service_rate = 0;
        
        $('input[name=id_business_services_voucher]:checked').each(function () {
            service_ids += $(this).val() + '|';
            service_names += $(this).attr('service_name') + '|';
            //console.log($(this).attr('service_rate'));
            service_rate += parseInt($(this).attr('service_rate'));
        });
        
        
        
        service_ids = service_ids.slice(0, -1);
        service_names = service_names.slice(0, -1);
        
        if(is_type_checked === false){
            swal({
                title: "Select Voucher Type",
                text: 'You have forgotten to select voucher type. Let\'s select a voucher type first.',
                type: "error",
                confirmButtonText: 'OK!'
            }); return false;
        }
        if(type === 'amount'){
            if(valid_until === "" || price === "" || price === "0"){
                swal({
                    title: "Add Voucher Price and Valid Until",
                    text: 'You have forgotten to add voucher price & valid until fields. Let\'s add these fields.',
                    type: "error",
                    confirmButtonText: 'OK!'
                }); return false;
            }
        }
        if(type === 'service'){
            if(valid_until === "" || service_ids === ""){
                swal({
                    title: "Select Services and Valid Until",
                    text: 'You have forgot to select services & valid until fields. Let\'s add these fields.',
                    type: "error",
                    confirmButtonText: 'OK!'
                }); return false;
            }
            if($('#voucher-price').val()==="" || $('#voucher-price').val()===0){
                $('#voucher-price').val(service_rate);
                price = service_rate;
            }
        }
        
        var instrument_number;
        
        if($('#mode').html() === 'Card'){
            if($('#ccno').val() === ''){
                toastr.warning('Enter Card Number!', 'Instrument number is mandatory'); 
                return false;
            } else{
                instrument_number = $('#ccno').val();
            }
        } else if($('#mode').html() === 'Check' || $('#mode').html() === 'Loyalty'){
            if($('#checkno').val() === ''){
                toastr.warning('Enter Instrument Number!', 'Instrument number is mandatory'); 
                return false;
            } else{
                instrument_number = $('#checkno').val();
            }
        } else {
            instrument_number = '';
        }
        
        //var post_data = 'service_names=' +service_names+ '&service_ids=' +service_ids+ '&price=' +price+ '&type=' +type+ '&customer_id=' +customer_id+ '&valid_until=' +valid_until+ '&voucher_number_option=' +voucher_number_option;

        $.ajax({

            type: "POST",
            //url: "Scheduler_controller/updateVoucher",
            url: '<?php echo base_url().'Scheduler_controller/updateVoucher'; ?>',
            //data: post_data,
            data: {
                service_names:service_names,
                service_ids:service_ids,
                price:price,
                type:type,
                customer_id:customer_id,
                valid_until:valid_until,
                voucher_number_option:voucher_number_option,
                payment_mode:$('#mode').html(),
                instrument_number:instrument_number,
                voucher_heading:voucher_heading
            },

            success: function(response){
                
                var result = response.split('|');
                
                if(result[0] === 'success'){
                    
                    toastr.success('Gift Voucher Created', 'Done!');
                    
                    $('#voucherBtnPreview').attr('href', '<?php echo base_url(); ?>viewvoucher/'+result[1]);
                    $('#voucherBtnPreview').fadeIn();
                    $('#voucherNumber').html('Voucher # <span class="label label-pink" style="padding: 7px; font-size: 15px;">'+result[2]+'</span>');
                    $('#voucherNumber').css({
                        'visibility' : 'visible'
                    });
                    
                    $('#voucher-price-div').hide();
                    $('#voucher-price').val('');
                    $('#voucher-valid-until').val('');
                    $('#voucher-services-categories').html('');
                    $('#voucher-services').html('');
                    $('#voucher-services-div').hide();
                    $(".nicescroll_4").getNiceScroll().remove();
                    $(".nicescroll_5").getNiceScroll().remove();
                    $(".nicescroll_vtypes").getNiceScroll().remove();
                    $('input[name=voucher-type]').prop('checked', false);
                    opencash();
                    
                }
                if(result[0] === 'already_exist'){
                    swal({
                        title: "Voucher Number Already Exist",
                        text: 'Please type different voucher number or keep the voucher number field empty for automatic voucher number generate.',
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
                }
                
            }
                
        });
        
    }

    function giftVoucherForm(orderid) {
        
        var voucher_services_html = $('#voucher-services').text();
        
        if(voucher_services_html.length > 0){
            
            $(".nicescroll_5").niceScroll({ cursoropacitymin: 1 });
            
        }
        
        if (orderid !== 0) {
            
            $("#divmain").hide();
            
        } else if ($("#txt-customer-id").val() !== "") {
            
//            $("#voucher-customer-id").val($("#txt-customer-id").val());
//            $("#voucher-customer-name").val($("#txt-customer-name").val());
//            $("#voucher-customer-cell").val($("#txt-customer-cell").val());
//            $("#voucher-customer-email").val($("#txt-customer-email").val());
            
//            if(localStorage.getItem('customer_id') !== localStorage.getItem('txt-customer-id')){
//                clearVoucher();
//            }
            clearVoucher();
            localStorage.setItem('txt-customer-id', $("#txt-customer-id").val());
            
            $("#divmain").hide();
            
            $("#gift-voucher").fadeIn();
            
        }
        
    }
    
    function giftVoucherServicesTypes() {
        $('#voucher-services-types').html('');
        $.ajax({
            type: 'POST',
            //url: 'service_controller/getServicesTypes',
            url: '<?php echo base_url().'service_controller/getServicesTypes'; ?>',
            success: function(response) {
                
                var data = $.parseJSON(response);
                
                var chtml = "";
                
                chtml += '<ul>';
                
                for (x = 0; x < data.length; x++) {
                    
                    var id = data[x]['id_service_types'];
                    var name = data[x]['service_type'];
                    var image = '<img src="<?php echo base_url()."assets/images/servicetype/"; ?>'+data[x]['service_type_image']+'">';
                    
                    chtml += '<li data-service_types_id="'+id+'" onclick="giftVoucherServices('+id+',\''+data[x]['flag'] + '\');">'+image+' '+name+'</li>';
                    
                }
                
                chtml += '</ul>';
                $('#voucher-services-div').fadeIn();
                $("#voucher-services-types").append(chtml);
                
            }
        });
    }
    
    function giftVoucherServices(service_type_id, flag) {
        $('#voucher-services-categories').html('');
        $.ajax({
            type: 'POST',
            //url: 'service_controller/getServicesCategories',
            url: '<?php echo base_url().'service_controller/getServicesCategories'; ?>',
            data: { service_type_id : service_type_id, flag : flag },
            success: function(response) {
                
                var data = $.parseJSON(response);
                
                var chtml = "";
                
                chtml += '<ul>';
                
                for (x = 0; x < data.length; x++) {
                    
                    var id = data[x]['id_service_category'];
                    var name = data[x]['service_category'];
                    var image = '<img src="<?php echo base_url()."assets/images/category/"; ?>'+data[x]['service_category_image']+'">';
                    
                    chtml += '<li data-service_category_id="'+id+'" onclick="giftVoucherSubServices('+id+',\''+ data[x]['flag'] +'\');">'+image+' '+name+'</li>';
                    
                }
                
                chtml += '</ul>';
                
                $(".nicescroll_4").niceScroll({ cursoropacitymin: 1 });
                
                $("#voucher-services-categories").append(chtml);
                
            }
        });
    }
    
    function giftVoucherSubServices(id_service_category, flag){
        
        $('#voucher-services-categories ul [data-service_category_id]').css('background-color', '#fff');
        
        $('#voucher-services-categories ul [data-service_category_id="'+id_service_category+'"]').css('background-color', '#f2f2f2');
        
        $("#voucher-services > ul").hide();
        //$("#voucher-services span").remove();
        
        if($('#voucher-services').find('#'+id_service_category).length > 0){
            
            $('#voucher-services').find('#'+id_service_category).show();
            
        } else{
            
            $('#voucher-services > #fa-spinner').show();
            
            $.ajax({

                type: "POST",
                //url: "Service_controller/getServicesByCategory",
                url: '<?php echo base_url().'service_controller/getServicesByCategory'; ?>',
                //data: "id_service_category=" + id_service_category,
                data: {
                    id_service_category:id_service_category, flag: flag
                },
                
                success: function(response){

                    var data = $.parseJSON(response);

                    if(data.length > 0){
                        
                        $(".nicescroll_5").niceScroll({ cursoropacitymin: 1 });

                        chtml = "";

                        chtml += '<ul id="'+id_service_category+'">';

                        for (x = 0; x < data.length; x++) {

                            var id = data[x]['id_business_services'];
                            var name = data[x]['service_name'];
                            var rate = data[x]['service_rate'];

                            var checkbox = '<div class="checkbox checkbox-pink checkbox-circle"><input type="checkbox" value="'+id+'" name="id_business_services_voucher" service_name="'+name+'" service_rate="'+rate.replace(/\,/g, '')+'" id="'+id+'_business_services_voucher">';

                            var label = '<label style="font-weight: normal;" for="'+id+'_business_services_voucher">'+name+' - <small>'+rate.toLocaleString()+'</small></label></div>';

                            chtml += '<li data-id_business_services_voucher="'+id+'">'+checkbox+' '+label+'</li>';
                            
                        }

                        chtml += '</ul>';
                        
                        $('#voucher-services > #fa-spinner').hide();

                        $("#voucher-services").append(chtml);

                    } else{
                    
                        $('#voucher-services > #fa-spinner').hide();
                        
                        $(".nicescroll_5").niceScroll({ cursoropacitymin: 1 });

                        $("#voucher-services").append('<span style="color: red">No Services</span>');

                    }

                }

            });
            
        }
        
    }
    
    $(window).load(function(){
        
        $('input[name=voucher-type]').on('click', function(){
            
            if($(this).val() === 'service'){
                
               // $('#voucher-price-div').hide();
               $('#voucher-price-div').fadeIn();
                $('#voucher-price').val('');
                $(".nicescroll_vtypes").niceScroll({ cursoropacitymin: 1 });
                giftVoucherServicesTypes();
                //giftVoucherServices();
                
            } else{
                
                $('#voucher-services-categories').html('');
                $('#voucher-services').html('');
                $('#voucher-services-div').hide();
                $('#voucher-price-div').fadeIn();
                $(".nicescroll_4").getNiceScroll().remove();
                $(".nicescroll_5").getNiceScroll().remove();
                $(".nicescroll_vtypes").getNiceScroll().remove();
                
            }
            
           // console.log('valeu: ' + $(this).val());
        });
        
        $('#voucher-valid-until').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });
        
    });
    
    function selectallservices(){
        $('input[name=id_business_services_voucher]').each(function () {
            $(this).prop( "checked", true);
        });
    }

</script>