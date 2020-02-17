<script>
    
    function back(selector1, selector2){
        $(selector1).hide();
        $(selector2).fadeIn();
    }
    
    function next(selector1, selector2){
        $(selector2).hide();
        $(selector1).fadeIn();
    }
    

    function services_height() {
        var height = $(window).height();
        var thirtypc = (50 * height) / 100;
        thirtypc = parseInt(thirtypc) + 'px';
        $(".services").css('height',thirtypc);
        
        var height = $(window).height();
        var smallerpc = (44 * height) / 100;
        smallerpc = parseInt(smallerpc) + 'px';
        $(".vservices").css('height',smallerpc);
    }
    
    function hideOpenDivs(){
        
        $('#event-modal > div').width('90%');
        
       // if($('#txt-customer-id').val() === "" || parseInt($('#txt-customer-id').val()) === 1){
            
            $("#name-search").val("");
            $("#cell-search").val("");
            $("#card-search").val("");
            $("#balanceid").html("");
            $("#requested").prop("checked","");
            
            $("#divmain").hide();
            $("#divsearch").fadeIn();
            $('#multiplesearch').hide();
            $("#divvisit").hide();
            $('#blocktime').hide();
            $('#newcustomeradding').hide();
            $('#con-close-modal').hide();
            $('#retail-divorder').hide();
            $('#gift-voucher').hide();
            $('#voucherbuttons').hide();
            $('#event-modal > div').addClass('modal-lg');
                            
       // } else {
            
//            $("#divmain").fadeIn();
//            $("#divsearch").hide();
//            $("#divvisit").hide();
//            $('#newcustomeradding').hide();
//            $('#blocktime').hide();
//            $("#divvisit").hide();
//            $('#con-close-modal').hide();
//            $('#retail-divorder').hide();
//            $('#gift-voucher').hide();
//            $('#voucherbuttons').hide();
//            $('#event-modal > div').addClass('modal-lg');
//            
//        }
        
        localStorage.setItem('staff_id', '');
        localStorage.setItem('staff_name', '');
        
    }
    
    function removeNiceScroll(){
        $(".nicescroll_1").getNiceScroll().remove();
        $(".nicescroll_2").getNiceScroll().remove();
        $(".nicescroll_3").getNiceScroll().remove();
        $(".nicescroll_4").getNiceScroll().remove();
        $(".nicescroll_5").getNiceScroll().remove();
        $(".nicescroll_service_types").getNiceScroll().remove();
        $(".nicescroll2").getNiceScroll().remove();
        $(".nicescroll3").getNiceScroll().remove();
        $(".nicescroll_products").getNiceScroll().remove();
        $(".nicescrollproducts").getNiceScroll().remove();
        $(".nicescroll_vtypes").getNiceScroll().remove();
        $(".nicescroll_service_types2").getNiceScroll().remove();
        
        
    }
    
    function get_category_services(id_service_category, flag){
        
        $('#visit-services-categories ul [data-service_category_id]').css('background-color', '#fff');
        
        $('#visit-services-categories ul [data-service_category_id="'+id_service_category+'"]').css('background-color', '#f2f2f2');
        
        $("#visit-services > ul").hide();
       
        var exists = false;
       
       
        if($('#visit-services').find('#'+id_service_category).length > 0){
            var test = '#'+id_service_category;
            //console.log($(test).attr('service_flag'));
            if($(test).attr('service_flag')==flag){
                exists=true;
            }    
        }        
        if(exists === true){        
            
                 $('#visit-services').find('#'+id_service_category).show();
            
            } else{

                $('#visit-services > #fa-spinner').show();

                $.ajax({

                    type: "POST",
                    //url: "Service_controller/getServicesByCategory",
                    url: "<?php echo base_url().'Service_controller/getServicesByCategory'; ?>",
                    //data: "id_service_category=" + id_service_category,
                    data: {
                        id_service_category:id_service_category,
                        flag: flag
                    },
                    success: function(response){

                        var data = $.parseJSON(response);

                        if(data.length > 0){

                            $(".nicescroll_3").niceScroll({ cursoropacitymin: 1 });

                            var chtml = "";

                            chtml += '<ul id="'+id_service_category+'" service_flag="'+data[0]['flag']+'">';

                            for (x = 0; x < data.length; x++) {

                                var id = data[x]['id_business_services'];
                                var name = data[x]['service_name'];
                                var rate = data[x]['service_rate'];
                                var service_flag = data[x]['flag'];
                                var checked = 'checked="checked"'; //Owais testing select all for packages
                                if(service_flag==="servicetype"){checked="";}//Owais testing select all for packages
                                var checkbox = '<div class="checkbox checkbox-pink checkbox-circle"><input type="checkbox" '+checked+' onclick="get_service_products('+id+');" service_name="'+name+'" service_duration="'+data[x]['service_duration']+'" value="'+id+'" name="id_business_services" flag="'+service_flag+'" id_service_category="'+id_service_category+'" id="'+id+'_business_services">';

                                var label = '<label style="font-weight: normal;" for="'+id+'_business_services">'+name+' - <small>'+rate.toLocaleString()+'</small></label></div>';

                                chtml += '<li data-id_business_services="'+id+'">'+checkbox+' '+label+'</li>';

                            }

                            chtml += '</ul>';

                            $('#visit-services > #fa-spinner').hide();

                            $("#visit-services").append(chtml);
                            var thisid="#"+id_service_category;
                            $(thisid).searcher({
                                    itemSelector: "li",
                                    textSelector: "",
                                    inputSelector: "#searchservicedirect"
                            });

                        } else{

                            $('#visit-services > #fa-spinner').hide();

                            $("#visit-services").append('<ul id="'+id_service_category+'"><li><span style="color: red">No Services</span></li></li>');

                        }

                    }

                });

            }
        
        
    }
    
    function get_service_products(service_id){
    
        if($('input[id='+service_id+'_business_services]:checked').length == '0'){
            $('input[product_service_id='+service_id+']').prop('checked', false);
        }
    
        $("#visit-products > ul").hide();
        
        if($('#visit-products').find('#'+service_id).length > 0){
            
            $('#visit-products').find('#'+service_id).show();
            
        } else{
            
            $('#visit-products > #fa-spinner').show();
            
            $.ajax({

                type: "POST",
                //url: "Product_controller/getProductsByService",
                url: "<?php echo base_url().'Product_controller/getProductsByService'; ?>",
                //data: "service_id=" + service_id,
                data: {
                    service_id:service_id
                },
                success: function(response){

                    var data = $.parseJSON(response);

                    if(data.length > 0){
                        
                        $(".nicescroll_products").niceScroll({ cursoropacitymin: 1 });

                        var chtml = "";

                        chtml += '<ul id="'+service_id+'">';

                        for (var x = 0; x < data.length; x++) {

                            var id = data[x]['id_business_products'];
                            var name = data[x]['product'];
                            var qty = data[x]['usage_qty'];
                            var unit = data[x]['measure_unit'];
                            //var checked = x === 0 ? 'checked' : '';
                            var checked = 'checked = "checked"'; 
                            var checkbox = '<div class="checkbox checkbox-pink checkbox-circle"><input type="checkbox" '+checked+' unit="'+unit+'" qty="'+qty+'" product_service_id="'+service_id+'" product_name="'+name+'" value="'+id+'" name="id_business_products" id="'+id+'_business_products">';

                            var label = '<label style="font-weight: normal;" for="'+id+'_business_products">'+name+'</label></div>';

                            chtml += '<li data-id_business_products="'+id+'">'+checkbox+' '+label+'</li>';

                        }

                        chtml += '</ul>';
                        
                        $('#visit-products > #fa-spinner').hide();

                        $("#visit-products").append(chtml);

                    } else{
                    
                        $('#visit-products > #fa-spinner').hide();

                        $("#visit-products").append('<ul id="'+service_id+'"><li><span style="color: red">No Products</span></li></li>');

                    }

                }

            });
            
        }
        
    }
    
    function getcategory_services(id_service_category, flag){
        
        $('#visit_services_categories ul [data-service_category_id]').css('background-color', '#fff');
        
        $('#visit_services_categories ul [data-service_category_id="'+id_service_category+'"]').css('background-color', '#f2f2f2');
        
        $("#visit_services > ul").hide();
        
        if($('#visit_services').find('#'+id_service_category).length > 0){
            
            $('#visit_services').find('#'+id_service_category).show();
            
        } else{
            
            $('#visit_services > #fa-spinner').show();
            
            $.ajax({

                type: "POST",
                //url: "Service_controller/getServicesByCategory",
                url: "<?php echo base_url().'Service_controller/getServicesByCategory'; ?>",
                //data: "id_service_category=" + id_service_category,
                data: {
                    id_service_category:id_service_category,
                    flag:flag
                },
                success: function(response){

                    var data = $.parseJSON(response);

                    if(data.length > 0){
                        
                        $(".nicescroll3").niceScroll({ cursoropacitymin: 1 });
                        
                        var services = $.parseJSON(localStorage.getItem('visit_services'));
                        //console.log(services);
                        var chtml = "";
                        
                        chtml += '<ul id="'+id_service_category+'">';
                        
                        var check;

                        //for (x = 0; x < data.length; x++) {
                        $.each(data, function(index1, value1){
                            
                            $.each(services, function(index2, value2){
                                if(value1['id_business_services'] == value2['service_id']){
                                    //return false;
                                    //console.log('id_business_services: '+value1['id_business_services']+' | service_id: '+value2['service_id']);
                                    check = true; // was false to hide already selected services
                                    return false;
                                } else{
                                    check = true;
                                    return true;
                                }
                            });
                            
                            if(check){
                                var id = value1['id_business_services'];
                                var name = value1['service_name'];
                                var rate = value1['service_rate'];
                                var service_flag= value1['flag'];
                                var checked = 'checked = "checked"'; //owais testing check all for package services
                                if(service_flag==='servicetype'){checked='';}
                                var checkbox = '<div class="checkbox checkbox-pink checkbox-circle"><input type="checkbox" '+checked+' onclick="getservice_products('+id+');" service_name="'+name+'" service_duration="'+value1['service_duration']+'" value="'+id+'" name="idbusiness_services" flag="'+service_flag+'" id_service_category="'+id_service_category+'" id="'+id+'business_services">';

                                var label = '<label style="font-weight: normal;" for="'+id+'business_services">'+name+' - <small>'+rate+'</small></label></div>';

                                chtml += '<li data-id_business_services="'+id+'">'+checkbox+' '+label+'</li>';
                            }
                            
                        });

                        chtml += '</ul>';
                        
                        $('#visit_services > #fa-spinner').hide();

                        $("#visit_services").append(chtml);
                       
                        var thisid="#"+id_service_category;
                        $(thisid).searcher({
                                itemSelector: "li",
                                textSelector: "",
                                inputSelector: "#searchservicedirect1"
                        });
                        

                    } else{
                    
                        $('#visit_services > #fa-spinner').hide();

                        $("#visit_services").append('<ul id="'+id_service_category+'"><li><span style="color: red">No Services</span></li></li>');

                    }

                }

            });
            
        }
        
    }
    
    function getservice_products(service_id){
    
        if($('input[id='+service_id+'_business_services]:checked').length == '0'){
            $('input[product_service_id='+service_id+']').prop('checked', false);
        }
        var flag = $('input[id='+service_id+'business_services]').attr('flag');
        $("#visit_products > ul").hide();
        
        if($('#visit_products').find('#'+service_id).length > 0){
            
            $('#visit_products').find('#'+service_id).show();
            
        } else{
            
            $('#visit_products > #fa-spinner').show();
            
            $.ajax({

                type: "POST",
                //url: "Product_controller/getProductsByService",
                url: "<?php echo base_url().'Product_controller/getProductsByService'; ?>",
                //data: "service_id=" + service_id,
                data: {
                    service_id:service_id
                },
                success: function(response){

                    var data = $.parseJSON(response);

                    if(data.length > 0){
                        
                        $(".nicescrollproducts").niceScroll({ cursoropacitymin: 1 });

                        var chtml = "";

                        chtml += '<ul id="'+service_id+'">';

                        for (var x = 0; x < data.length; x++) {

                            var id = data[x]['id_business_products'];
                            var name = data[x]['product'];
                            var qty = data[x]['usage_qty'];
                            var unit = data[x]['measure_unit'];
                            //var checked = x === 0 ? 'checked' : ''; Owais Testing all checked
                            var checked='checked="checked"'; //Owais Testing all checked
                            if(flag==="servicetype"){
                                //checked = x === 0 ? 'checked' : '';
                                
                            } //Owais Testing all checked
                            
                            var checkbox = '<div class="checkbox checkbox-pink checkbox-circle"><input type="checkbox" '+checked+' unit="'+unit+'" qty="'+qty+'" product_service_id="'+service_id+'" product_name="'+name+'" value="'+id+'" name="idbusiness_products" id="'+id+'business_products">';

                            var label = '<label style="font-weight: normal;" for="'+id+'business_products">'+name+'</label></div>';

                            chtml += '<li data-id_business_products="'+id+'">'+checkbox+' '+label+'</li>';

                        }

                        chtml += '</ul>';
                        
                        $('#visit_products > #fa-spinner').hide();

                        $("#visit_products").append(chtml);

                    } else{
                    
                        $('#visit_products > #fa-spinner').hide();

                        $("#visit_products").append('<ul id="'+service_id+'"><li><span style="color: red">No Products</span></li></li>');

                    }

                }

            });
            
        }
        
    }
    
    function open_gift_voucher(){
        
        hideOpenDivs();
        
        $('#divmain').hide();
        $('#divsearch').hide();
        $('#voucherbuttons').show();
        
        
        removeNiceScroll();
        
        $('#event-modal > div').removeClass('modal-lg');
        
        $('#event-modal').modal({
            backdrop:'static',
            keyboard:false,
            show:true
        });
        $('#cell-search').focus();
        $('#modal-header-title').html('Gift Voucher');
        $('#schedulerFunctionBtn').html('Gift Voucher');
        $("#schedulerFunctionBtn").attr('onclick', 'giftVoucherForm(0);');
        
    }
    
    function open_retail(){
        
        hideOpenDivs();
        
        removeNiceScroll();
        
        $('#event-modal').modal({
            backdrop:'static',
            keyboard:false,
            show:true
        });
        $('#cell-search').focus();
        $('#modal-header-title').html('Retail');
        $('#schedulerFunctionBtn').html('Products');
        $("#schedulerFunctionBtn").attr('onclick', 'retail_openOrder(0)');
        
    }
    
    function open_PBooking(){
        window.location.assign('<?php echo base_url();?>period_booking');
    }
    
    function open_services(staff_id, staff_name){
        hideOpenDivs();
        removeNiceScroll();
        
        localStorage.setItem('staff_id', staff_id);
        localStorage.setItem('staff_name', staff_name);
        $('#modal-header-title').html('Add Customer Visit');
        $('#schedulerFunctionBtn').html('Services');
        $("#schedulerFunctionBtn").attr('onclick', 'openVisit()');
        $("#name-search").focus();
        $('#event-modal').modal({
            backdrop:'static',
            keyboard:false,
            show:true
        });
        
    }
    
    function removeZero(click){
        if(click.val() === "0"){
            click.val('');
        }
    }
    
    function addZero(click){
        if(click.val() === ""){
            click.val('0');
        }
    }
    
    function saveCashRegister(){
        
        var moment = $('#calendar').fullCalendar('getDate');
        var calendar_date = moment.format('YYYY-MM-DD');
        
        $.ajax({
            type: "POST",
            //url: "Invoice_controller/updateCashRegister",
            url: "<?php echo base_url().'Invoice_controller/updateCashRegister'; ?>",
            data: {
                x5000 : $('#5000').val(),
                x1000 : $('#1000').val(),
                x500 : $('#500').val(),
                x100 : $('#100').val(),
                x50 : $('#50').val(),
                x20 : $('#20').val(),
                x10 : $('#10').val(),
                x5 : $('#5').val(),
                x1 : $('#1').val(),
                totalDifference: $('#totalDifference').html(),
                daily_expense: $('#totalExpenses').html(),
                remarks : $('#cashRemarks').val(),
                till: $('#today_till').val(),
                cash_addition: $('#cash_addition').val(),
                calendar_date: calendar_date
            },
            success: function(response){
                var data = response.split('|');
                if(data[0] === 'success'){
                    toastr.success('Cash register saved!', 'Done!');
                    $('#cashregister').attr('href', '<?php echo base_url('cashregister'); ?>/'+calendar_date);
                    $('#cashregister').fadeIn();
                } else{
                    swal({
                        title: "Not Allowed!",
                        text: 'You CANNOT UPDATE a PREVIOUS DAY CASH REGISTER ENTRY!',
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
                    $('#cashregister').attr('href', '<?php echo base_url('cashregister'); ?>/'+calendar_date);
                    //$('#cashregister').attr('href', 'javascript:void(0);');
                }
            }
        });
        
    }
    
    function updateCashRegister(click){
        
        if(click.val() === ""){
            return false;
        }
        
        var x5000 = parseInt($('#5000').val()) * parseInt($('#5000').attr('id'));
        $('#x5000').html(parseFloat(x5000).toFixed(2));
        var x1000 = parseInt($('#1000').val()) * parseInt($('#1000').attr('id'));
        $('#x1000').html(parseFloat(x1000).toFixed(2));
        var x500 = parseInt($('#500').val()) * parseInt($('#500').attr('id'));
        $('#x500').html(parseFloat(x500).toFixed(2));
        var x100 = parseInt($('#100').val()) * parseInt($('#100').attr('id'));
        $('#x100').html(parseFloat(x100).toFixed(2));
        var x50 = parseInt($('#50').val()) * parseInt($('#50').attr('id'));
        $('#x50').html(parseFloat(x50).toFixed(2));
        var x20 = parseInt($('#20').val()) * parseInt($('#20').attr('id'));
        $('#x20').html(parseFloat(x20).toFixed(2));
        var x10 = parseInt($('#10').val()) * parseInt($('#10').attr('id'));
        $('#x10').html(parseFloat(x10).toFixed(2));
        var x5 = parseInt($('#5').val()) * parseInt($('#5').attr('id'));
        $('#x5').html(parseFloat(x5).toFixed(2));
        var x1 = parseInt($('#1').val()) * parseInt($('#1').attr('id'));
        $('#x1').html(parseFloat(x1).toFixed(2));
        
//        var total_sum = x5000 + x1000 + x500 + x100 + x50 + x20 + x10 + parseInt($('#yesterday_till').text());
        var total_sum = x5000 + x1000 + x500 + x100 + x50 + x20 + x10 + x5 + x1;
        
        $('#totalSub').html(parseFloat(total_sum).toFixed(2));
        
        var cash_addition= parseInt($('#cash_addition').val());
        var yesterday_till = parseInt($('#yesterday_till').text());
        var opening_balance = cash_addition + yesterday_till;
        var totalSub = parseInt($('#totalSub').html());
        
        $("#totalOpening").text(parseFloat(opening_balance).toFixed(2));
        
        var totalCash = parseInt($('#totalCash').html());
        
        var totalGrand = totalCash + opening_balance;
        $("#totalGrand").text(totalGrand.toFixed(2));
        
        var totalDifference = totalSub - totalGrand;
        var totalTillDifference = totalSub - totalGrand;
        
        if(totalDifference === 0){
            $('#totalDifference').css('color', '#797979');
            $('#difference').css('color', '#797979');
            
            $('#totalDifference').html(parseFloat(totalDifference).toFixed(2));
            
        } else if(totalDifference > 0){
            $('#totalDifference').css('color', 'green');
            $('#difference').css('color', 'green');
            $('#totalDifference').html(parseFloat(totalDifference).toFixed(2));
        } else{
            $('#totalDifference').css('color', 'red');
            $('#difference').css('color', 'red');
            $('#totalDifference').html(parseFloat(totalDifference).toFixed(2));
        }
        
        if(totalTillDifference === 0){
            $('#totalTillDifference').css('color', '#797979');
            $('#difference').css('color', '#797979');
            $('#totalTillDifference').html(parseFloat(totalTillDifference).toFixed(2));
            
        } else if(totalTillDifference > 0){
            $('#totalTillDifference').css('color', 'green');
            $('#difference').css('color', 'green');
            $('#totalTillDifference').html(parseFloat(totalTillDifference).toFixed(2));
        } else{
            $('#totalTillDifference').css('color', 'red');
            $('#difference').css('color', 'red');
            $('#totalTillDifference').html(parseFloat(totalTillDifference).toFixed(2));
        }
        
        
    }
    
    $(window).load(function(){
        
        services_height();
        $(window).bind('resize', services_height);
        
        $("#searchservicedirect").keyup(function( event ) {
            if ( event.which == 13 ) {
               event.preventDefault();
               //findservice($(this).val());
            } 
        });
        $("#searchservicedirect1").keyup(function( event ) {
            if ( event.which == 13 ) {
               event.preventDefault();
               //findservice($(this).val());
            }
        });
       
       
       
        
        localStorage.setItem('txt-customer-id', '');        // Customer Details Reset/Keep
        
        $('#btnRetail').on('click', function(){
            open_retail();
        });
        
        $('#btnPBooking').on('click', function(){
            open_PBooking();
        });
        
        $('#btnGiftVoucher').on('click', function(){
            open_gift_voucher();
        });
        
        $('.newvoucher').on('click', function(){
            $('#event-modal > div').addClass('modal-lg');
            $('#divsearch').show();
            $('#voucherbuttons').hide();
        });
        
        $('.verifyvoucher').on('click', function(){
            
            $('#event-modal').modal('hide');
            $('#voucherbuttons').hide();
            
            $('#voucherHtml').hide();
            $('#voucherHtml').html('');
            
            $('#verifyVoucherModal').modal({
                backdrop:'static',
                keyboard:false,
                show:true
            });
            
        });
        
        $('#btnCashRegister').on('click', function(){
            
            $('#today_till').val('');
            
            var moment = $('#calendar').fullCalendar('getDate');
            var calendar_date = moment.format('YYYY-MM-DD');
            var cashRegDate = moment.format('DD-MM-YYYY');
            
           
//            if(today !== calendar_date && $("#userrole").val()==="Reception" ){
//                return;
//            }
            
            $.ajax({
                type: "POST",
                //url: "Invoice_controller/getTodayCashInfo",
                url: "<?php echo base_url().'Invoice_controller/getTodayCashInfo'; ?>",
                data: {
                    calendar_date : calendar_date,
                    show_previous: $("#show_previous").val()
                },
                success: function(response){
                
                if(response==="Not Allowed"){return;}
                
                $("#cashRegDate").html(cashRegDate);
                    
                var result = $.parseJSON(response);
                var data = result.invoice;
                var data2 = result.cash_register;
                var data3 = result.voucher;
                var data4 = result.till;
                var data5 = result.today_expenses;

                
                var totalCash = data.totalCash !== null ? data.totalCash : 0;
                var totalSale = data.totalSale !== null ? data.totalSale : 0;
                        
                var totalService = data.totalService !== null ? data.totalService : 0;
                var totalRetail = data.totalRetail !== null ? data.totalRetail : 0;
                var totalVoucher = data3.totalVoucherAmount !== null ? data3.totalVoucherAmount : 0;
                var totalAdvance = data.totalAdvance !== null ? data.totalAdvance : 0;
                var todaytotalsale = parseFloat(totalService) + parseFloat(totalRetail) + parseFloat(totalVoucher) + parseFloat(totalAdvance);
                
                $('#totalSale').html(parseFloat(todaytotalsale).toFixed(2));
                
                var advadj = data.AdvAdj !== null ? data.AdvAdj : 0;
                
                var totalRecovery = data.totalRecovery !== null ? data.totalRecovery : 0;
                var totalBalance = data.totalBalance !== null ? data.totalBalance : 0;
                var totalRetained = data.totalRetained !== null ? data.totalRetained : 0;
                var totalCCTips = data.totalCCTip !== null ? data.totalCCTip : 0;
                var totalCCFee = data.totalCCCharge !== null ? data.totalCCCharge : 0;
                var totalExtra = data.totalExtra !== null ? data.totalExtra : 0;
                var totalTax = data.totalTax !== null ? data.totalTax : 0;
                
                var totalExpense = data5.today_expenses !== null ? data5.today_expenses : 0;
                
                //var todaytransaction = ((parseFloat(todaytotalsale) + parseFloat(totalRecovery)) - (parseFloat(advadj)+parseFloat(totalBalance)+parseFloat(totalCCFee)+parseFloat(totalCCTips)+parseFloat(totalExtra)+parseFloat(totalTax)));
                var todaytransaction = ((parseFloat(todaytotalsale) + parseFloat(totalRecovery) +parseFloat(totalCCFee)+parseFloat(totalCCTips)) - (parseFloat(advadj)+parseFloat(totalBalance)));
                //$('#totalTransaction').html((parseFloat(totalSale)+parseFloat(totalAdvance)+parseFloat(totalRecovery)+parseFloat(totalRetained))-(parseFloat(totalBalance)+parseFloat(totalExpense)+parseFloat(totalCCTips)));
                $('#totalTransaction').html(parseFloat(todaytransaction).toFixed(2));
                
                var Cash = data.Cash !== null ? data.Cash : 0;
                var Card = data.Card !== null ? data.Card : 0;
                var Checks = data.Checks !== null ? data.Checks : 0;
                var Loyalty = data.Loyalty !== null ? data.Loyalty : 0;
                var Voucher = data.totalVoucher !== null ? data.totalVoucher : 0;

                var totalVoucherCash = data3.Cash !== null ? data3.Cash : 0;
                var totalVoucherCard = data3.Card !== null ? data3.Card : 0;
                var totalVoucherChecks = data3.Checks !== null ? data3.Checks : 0;


                if(data2 !== null){
                    $('#cash_addition').val(data2.cash_addition);
                    $('#5000').val(data2.x5000);
                    $('#1000').val(data2.x1000);
                    $('#500').val(data2.x500);
                    $('#100').val(data2.x100);
                    $('#50').val(data2.x50);
                    $('#20').val(data2.x20);
                    $('#10').val(data2.x10);
                    $('#5').val(data2.x5);
                    $('#1').val(data2.x1);
                    $('#today_till').val(data2.till_amounts);
                    //$('#totalDifference').html(data2.difference);
                    $('#cashRemarks').html(data2.remarks);
                    $('#cashregister').attr('href', '<?php echo base_url('cashregister'); ?>/'+calendar_date);
                    
                     if(data2.register_status == 'closed'){
                         console.log(data2.register_status);
                    $(".autodisable").attr('disabled','disabled');
                    }
                } else{
                    $('#cash_addition').val('0.00');
                    $('#5000').val('0');
                    $('#1000').val('0');
                    $('#500').val('0');
                    $('#100').val('0');
                    $('#50').val('0');
                    $('#20').val('0');
                    $('#10').val('0');
                    $('#5').val('0');
                    $('#1').val('0');
                    $('#today_till').val('');
                    $('#cashRemarks').html('');
                    $('#cashregister').attr('href', 'javascript:void(0);');
                    
                }
                
               
                
                if(data4 !== null){
                    $('#yesterday_till').html(data4.till_amounts);
                }else {$('#yesterday_till').html('0.00')};
                
                
                
               // var calCash=parseFloat(parseInt(Cash) + parseInt(totalVoucherCash)).toFixed(2);
                var calCash=parseFloat(parseInt(Cash) + parseInt(totalVoucherCash)).toFixed(2);
                //totalCash = parseFloat(calCash - parseInt(totalExpense)).toFixed(2);
                totalCash = calCash - (parseInt(totalExpense)+parseInt(totalCCTips));
                totalSale = parseFloat(parseInt(totalSale) + parseInt(totalVoucher)).toFixed(2);

                var paymentCash = (parseFloat(parseInt(Cash) + parseInt(totalVoucherCash)).toFixed(2));
                var paymentCard = (parseFloat(parseInt(Card) + parseInt(totalVoucherCard)).toFixed(2));
                var paymentChecks = (parseFloat(parseInt(Checks) + parseInt(totalVoucherChecks)).toFixed(2));

                $('#totalCash').html(parseFloat(totalCash).toFixed(2));
                $('#totalCash1').html(parseFloat(totalCash).toFixed(2));
                
                $('#totalVoucherSold').html(parseFloat(totalVoucher).toFixed(2));
                $('#totalAdvanceAdjusted').html(parseFloat(advadj).toFixed(2));
                $('#totalBalance').html(parseFloat(totalBalance).toFixed(2));
                $('#totalRecovery').html(parseFloat(totalRecovery).toFixed(2));
                $('#totalRetained').html(parseFloat(totalRetained).toFixed(2));
                $('#totalRetained1').html(parseFloat(totalRetained).toFixed(2));
                
                if(parseFloat(totalRetained)===0){$('#trretained').hide();} else {$('#trretained').show();}
                $('#totalCCTips').html(parseFloat(totalCCTips).toFixed(2));
                $('#totalCCTips1').html(parseFloat(totalCCTips).toFixed(2));
                
                if(parseFloat(totalCCTips)===0){$('#trcctips').hide();} else {$('#trcctips').show();}
                
                $('#totalCCFee').html(parseFloat(totalCCFee).toFixed(2));
                if(parseFloat(totalCCFee)===0){$('#trccfee').hide();} else {$('#trccfee').show();}
                
                $('#totalAdvance').html(parseFloat(totalAdvance).toFixed(2));
                $('#totalService').html(parseFloat(totalService).toFixed(2));
                $('#totalRetail').html(parseFloat(totalRetail).toFixed(2));
                $('#totalExpenses').html(parseFloat(totalExpense).toFixed(2));
                $('#totalExpenses1').html(parseFloat(totalExpense).toFixed(2));
                
                $('#Cash').html(parseFloat(paymentCash).toFixed(2));
                $('#Cash1').html(parseFloat(paymentCash).toFixed(2));
                $('#Card').html(parseFloat(paymentCard).toFixed(2));
                $('#Checks').html(parseFloat(paymentChecks).toFixed(2));
                $('#Loyalty').html(parseFloat(Loyalty).toFixed(2));
                $('#totalVoucher').html(parseFloat(Voucher).toFixed(2));
                $('#totalExtra').html(parseFloat(totalExtra).toFixed(2));
                $('#totalTax').html(parseFloat(totalTax).toFixed(2));
                //$('#totalTransaction').html((parseFloat(totalSale)+parseFloat(totalAdvance)+parseFloat(totalRecovery))-(parseFloat(totalBalance)+parseFloat(totalExpense)));
                
                $("#totalpayments").html(parseFloat(parseFloat(paymentCard)+parseFloat(paymentCash)+parseFloat(paymentChecks)+parseFloat(Voucher)).toFixed(2));
                updateCashRegister($('#5000'));

                $('#cash_register_modal').modal({
                    backdrop:'static',
                    keyboard:false,
                    show:true
                });
                }
            });
            
        });
        
    });
    
    
</script>