<script>
    function enabletaxes(val){
        if(val==='yes'){
            enabtax=true;
            $("#divtaxes").slideDown();
            updatetotal();
        } else {
            enabtax=false;
            $("#divtaxes").slideUp();
            updatetotal();
        }
    }


    function single_discount_pass(id){
        $("#discount_by_product"+id).on('click',function() {
            if($(this).attr("readonly")){
                $("#invoicepass").modal("show");
            }
        });
        
        $("#discount_by_product"+id).dblclick(function() {
            $("#invoicepass").modal("show");
        });
        
        $("#perc_discount_product"+id).on('click',function() {
            if($(this).attr("readonly")){
                $("#invoicepass").modal("show");
            }
        });
        
        $("#perc_discount_product"+id).dblclick(function() {
            $("#invoicepass").modal("show");
        });
    }
    
    
    function perc_discount_product(discount, idproducts){
    //todo    
        var inputname="#perc_discount_product"+idproducts;
        discount= $(inputname).val();

        console.log(discount);

        var orignal_unitcost = parseFloat($('#orignal_product_price'+idproducts).val());
        if(discount === ""){
            $('#unitcost'+idproducts).text(orignal_unitcost.toFixed(2));
            var temp='#discount_by_product'+idproducts;
            $(temp).val('');
            product_row_sum(); 
        }else{
            discount = (parseFloat(discount)*orignal_unitcost)/100; 
            var temp='#discount_by_product'+idproducts;
            $(temp).val(discount);
        }
        
        discount_by_product(discount, idproducts);
        
    }
    
    function discount_by_product(discount, idproducts){
        var inputname="#discount_by_product"+idproducts;
        discount= $(inputname).val();

        var orignal_unitcost = parseFloat($('#orignal_product_price'+idproducts).val());
       // console.log(discount);
       // console.log(orignal_unitcost);
        if(discount === ""){
            $('#unitcost'+idproducts).text(orignal_unitcost.toFixed(2));
            product_row_sum(); 
            var temp='#perc_discount_product'+idproducts;
            $(temp).val('');
        }else{
            discount = parseFloat(discount);
            var discount_rate = orignal_unitcost - discount;
            $('#unitcost'+idproducts).text(discount_rate.toFixed(2));
            product_row_sum();
            
            var perc_discount = (100*discount)/orignal_unitcost;
            var temp='#perc_discount_product'+idproducts;
            $(temp).val(perc_discount);
            
        }
        //calcdiscount_perc();
        updatetotal();
    }
    
    
    function updateothercharges(){
        calcdiscount_perc();
    }
    
    function calcdiscount_perc(){
        if($("#txtothercharges").val()==""){$("#txtothercharges").val(0);}
        var result=0;
        if($("#discount_in_percent").val() !== "" && $("#discount_in_percent").val()>0){
            result = (parseInt($("#txtsubtotal").val()) + parseInt($("#txtothercharges").val())) * parseInt($("#discount_in_percent").val());
            result=result/100;
        }
        
        $("#txtdiscount").val(result);
        //updatetotal();
        //$("#paid").val($("#grandtotal").val());
        //$("#balanceamount").val(parseFloat($("#grandtotal").val()) - parseFloat($("#paid").val()));
        updatetotal();
    }
    
    
    function percent_discount_calculation(){
        var discount_in_percent = parseFloat($('#discount_in_percent').val());
        var sub_total_rs = parseFloat($('#txtsubtotal').val());
        var new_rs = ((discount_in_percent / 100) * sub_total_rs);
        $('#txtdiscount').val(new_rs.toFixed(0));
//        updatetotal();
//        $('#paid').val($('#txtgross').val());
        updatetotal();
    }
    
    function rupee_discount_calculation(){
        var discount_in_rupee = parseFloat($('#txtdiscount').val());
        var sub_total_rs = parseFloat($('#txtsubtotal').val());
        
        var new_percent = (discount_in_rupee / sub_total_rs) * 100;
        
        $('#discount_in_percent').val(new_percent.toFixed(2));
        percent_discount_calculation();
        
    }

    function updatepaying(){
        
        $("#paid").val(parseFloat($("#cashpaid").val()) + parseFloat($("#cardpaid").val()));
        updatetotal();
    }
    
    function updatepayingcard(){
        console.log($("#cc_charge").val());
        if(parseFloat($("#cc_charge").val()) > 0){
            $("#divcccharge").show();
            $("#txtcc_charge").val("0");
            console.log('grandtotal : '+ parseFloat($("#grandtotal").val()) + " cc_charge : " + $("#cc_charge").val());
            var ccc= (parseFloat($("#cardpaid").val()) * parseFloat($("#cc_charge").val()))/100;
            $("#txtcc_charge").val(Math.round(ccc));
            $("#cardpaid").val(parseFloat($("#cardpaid").val()) + ccc);
        }
        
        $("#paid").val(parseFloat($("#cashpaid").val()) + parseFloat($("#cardpaid").val()));
        
        updatetotal();
    }
    
        function validateVouchers(){
        
        if($('#voucherno').val() === "" || $('#voucherno').val() === "0"){
            swal({
                title: 'Empty Field',
                text: 'Please provide voucher number!',
                type: 'warning',
                confirmButtonText: 'OK!'
            });
            return false;
        } else{
            var voucherno = 'C'+$('#voucherno').val();
            
            $.ajax({
                type: 'POST',
                url: 'Voucher_controller/validateVoucher',
                data: {
                    voucherno: voucherno
                },
                success: function(response) {
                    var data = $.parseJSON(response);
                    if(data.length > 0){
                        var html = '<table class="table">';
                            html += '<thead>';
                                html += '<tr><th colspan="3">Customer Details</th></tr>';
                            html += '</thead>';
                            html += '<tbody>';
                                html += '<tr><td>Customer Name</td><td>'+data[0]['customer_name']+'</td></tr>';
                                html += '<tr><td>Customer Email</td><td>'+data[0]['customer_email']+'</td></tr>';
                                html += '<tr><td>Customer Phone</td><td>'+data[0]['customer_cell']+'</td></tr>';
                            html += '</tbody>';
                            html += '<thead>';
                                html += '<tr><th colspan="3">Voucher Details</th></tr>';
                            html += '</thead>';
                            html += '<tbody>';
                                html += '<tr><td>Type</td><td>'+data[0]['type'].toUpperCase()+'</td></tr>';
                                html += '<tr><td>Generated on</td><td>'+data[0]['voucher_date']+'</td></tr>';
                                html += '<tr><td>Expire on</td><td>'+data[0]['valid_until']+'</td></tr>';
                                html += '<tr><td>Voucher #</td><td>'+data[0]['voucher_number']+'</td></tr>';
                                
                                if(data[0]['type'] === 'amount'){
                                    html += '<tr><td>Total Amount Rs.</td><td>'+data[0]['amount']+'</td></tr>';
                                    html += '<tr><td>Remaining Amount Rs.</td><td>'+data[0]['remaining_amount']+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 11px;">(This amount will be apply to the invoice)</span></td></tr>';
                                }
                                if(data[0]['type'] === 'service'){
                                    html += '<tr><td>Services: </td><td>'+data[0]['service_names'].replace(/\|/g, '<div style="border-bottom: 1px solid #eee;"></div>')+'</td></tr>';
                                }
                                
                                html += '<tr><td></td><td></td></tr>';
                            html += '</tbody>';
                        html += '</table>';
                        
                        $('#voucherType').val(data[0]['type']);
                        $('#voucherAmount').val(data[0]['amount']);
                        $('#voucherRemainingAmount').val(data[0]['remaining_amount']);
                        $('#voucherRemainingServices').val(data[0]['remaining_service_ids']);
                        $('#voucherHtml').html(html);
                        $('#voucherModal').modal({
                            backdrop:'static',
                            keyboard:false,
                            show:true
                        });
                        
                    } else{
                        swal({
                            title: 'Not Found / Expired',
                            text: 'The provided voucher number '+voucherno+' is not found or expired.',
                            type: 'error',
                            confirmButtonText: 'OK!'
                        });
                    }
                }
            });
        }
        
    }
    
    function applyVoucher(){
        
        var type = $('#voucherType').val();
        
        if(type === 'amount'){
            var remaining = parseInt($('#voucherRemainingAmount').val());
            var grandtotal = parseInt($('#grandtotal').val());
            if(remaining >= grandtotal){
                $('#paid').val(grandtotal);
                $('#voucherRemainingAmount').val(parseInt(remaining) - parseInt(grandtotal));
            }
            if(remaining < grandtotal){
                $('#paid').val(remaining);
                $('#voucherRemainingAmount').val('0');
            }
            updatetotal();
            $('#voucherModal').modal('hide');
        }
        if(type === 'service'){
            
            var sids = [];
            var remainingServiceIds = $('#voucherRemainingServices').val().split('|');
            
            $('input[name=service_ids]').each(function () {
                sids.push($(this).val());
            });
            
            var diff_ids = arrayDifference(remainingServiceIds, sids);
            var remainingservices = "";
            
            $.each(diff_ids, function( index, value ) {
                remainingservices += value+"|";
            });
            
            remainingservices = remainingservices.slice(0, -1);
            
            $('#voucherRemainingServices').val(remainingservices);
            
            var remaining = parseInt($('#voucherRemainingAmount').val());
            var grandtotal = parseInt($('#grandtotal').val());
            if(remaining >= grandtotal){
                $('#paid').val(grandtotal);
                $('#voucherRemainingAmount').val(parseInt(remaining) - parseInt(grandtotal));
            }
            if(remaining < grandtotal){
                $('#paid').val(remaining);
                $('#voucherRemainingAmount').val('0');
            }
            updatetotal();
            $('#voucherModal').modal('hide');
        }
        
    }
    
    function updateVoucher(){
        
        var remaining = $('#voucherRemainingAmount').val();
        var remaining_services = $('#voucherRemainingServices').val();
        var voucherno = 'C'+$('#voucherno').val();
        
        $.ajax({
            type: 'POST',
            url: 'Voucher_controller/updateRemainingAmount',
            data: {
                voucherno: voucherno,
                remaining: remaining,
                remaining_services: remaining_services
            },
            success: function(response) {
                if(response === 'success'){
                    $('button:contains("Verify")').hide();
                    if(parseInt(remaining) > 0){
                        var vmodal = $('#voucherModal');
                        var html = '<center><h5>Voucher # '+voucherno+' has remaining amount. Please print new slip for it.</h5>';
                        html += '<a onclick="hideVoucherModal();" href="<?php echo base_url(); ?>viewvoucher/'+$('#voucherno').val()+'" target="_blank"><i class="fa fa-print"></i> Print Preview</a></center>';
                        $('#voucherModalFooter').hide();
                        $('#voucherHtml').html(html);
                        vmodal.modal({
                            backdrop:'static',
                            keyboard:false,
                            show:true
                        });
                    }
                    return true;
                } else{
                    return false;
                }
            }
        });
        
    }
    
    function hideVoucherModal(){
        $('#voucherModal').modal('hide');
    }
    
    function opencc(){
        if($("#ccp").is(":hidden")){
            $("#ccp").slideDown();
        }
        if($("#voucherp").is(":visible")){
            $("#voucherp").slideUp();
        }
        if($("#balance").is(":visible")){
            $("#balance").slideUp();
        }
        if($("#ccp").is(":visible")){
            $("#checkp").slideUp();
        }
        if($("#payingcash").is(":visible")){
            $("#payingcash").slideUp();
        }
        if($("#payingcard").is(":visible")){
            $("#payingcard").slideUp();
        }

        if( parseFloat($("#cc_charge").val()) > 0){
            $("#divcccharge").show();
            $("#txtcc_charge").val("0");
            console.log('grandtotal : '+ parseFloat($("#grandtotal").val()) + " cc_charge : " + $("#cc_charge").val());
            var ccc= (parseFloat($("#grandtotal").val()) * parseFloat($("#cc_charge").val()))/100;
            $("#txtcc_charge").val(Math.round(ccc));
            
        }
        
        
        $("#cctip").show();
        $("#mode").html('Card');
        $("#paid").removeAttr("disabled");
        $("#cashpaid").val("0");
        $("#cardpaid").val("0");
        $("#paid").val("0");
        updatetotal();
    }
    function opendc(){
        if($("#ccp").is(":hidden")){
            $("#ccp").slideDown();
        }
        if($("#voucherp").is(":visible")){
            $("#voucherp").slideUp();
        }
        if($("#balance").is(":visible")){
            $("#balance").slideUp();
        }
        if($("#ccp").is(":visible")){
            $("#checkp").slideUp();
        }
        if($("#payingcash").is(":visible")){
            $("#payingcash").slideUp();
        }
        if($("#payingcard").is(":visible")){
            $("#payingcard").slideUp();
        }

        $("#divcccharge").hide();
        $("#txtcc_charge").val("0");
        
        
        $("#cctip").show();
        $("#mode").html('Card');
        $("#paid").removeAttr("disabled");
        $("#cashpaid").val("0");
        $("#cardpaid").val("0");
        $("#paid").val("0");
        updatetotal();
    }
    function openvoucher(mode){
        if($("#voucherp").is(":hidden")){
            $("#voucherp").slideDown();
            $('#paid').val('0');
        }
        if($("#checkp").is(":visible")){
            $("#checkp").slideUp();
        }
        if($("#balance").is(":visible")){
            $("#balance").slideUp();
        }
        if($("#ccp").is(":visible")){
            $("#ccp").slideUp();
        }
        if($("#payingcash").is(":visible")){
            $("#payingcash").slideUp();
        }
        if($("#payingcard").is(":visible")){
            $("#payingcard").slideUp();
        }
        
        $("#divcccharge").hide();
        $("#txtcc_charge").val("0");
        
        
        $("#cctip").hide();
        $("#mode").html(mode);
        $("#paid").removeAttr("disabled");
        $("#cashpaid").val("0");
        $("#cardpaid").val("0");
        $("#paid").val("0");
        updatetotal();
    }
    
    function openbank(mode){
        if($("#checkp").is(":hidden")){
            $("#checkp").slideDown();
        } 
        if($("#voucherp").is(":visible")){
            $("#voucherp").slideUp();
        }
        if($("#balance").is(":visible")){
            $("#balance").slideUp();
        }
        if($("#ccp").is(":visible")){
            $("#ccp").slideUp();
        }
        if($("#payingcash").is(":visible")){
            $("#payingcash").slideUp();
        }
        if($("#payingcard").is(":visible")){
            $("#payingcard").slideUp();
        }
        
        $("#divcccharge").hide();
        $("#txtcc_charge").val("0");
        
        
        $("#cctip").hide();
        $("#mode").html(mode);
        $("#paid").removeAttr("disabled");
        $("#cashpaid").val("0");
        $("#cardpaid").val("0");
        $("#paid").val("0");
        updatetotal();
    }
    
    function opencash(){
        
        if($("#ccp").is(":visible")){
            $("#ccp").slideUp();
        }
        if($("#voucherp").is(":visible")){
            $("#voucherp").slideUp();
        }
        if($("#checkp").is(":visible")){
            $("#checkp").slideUp();
        }
        if($("#balance").is(":visible")){
            $("#balance").slideUp();
        }
        if($("#payingcash").is(":visible")){
            $("#payingcash").slideUp();
        }
        if($("#payingcard").is(":visible")){
            $("#payingcard").slideUp();
        }
        
        $("#divcccharge").hide();
        $("#txtcc_charge").val("0");
       
       
        $("#cctip").hide();
        $("#mode").html('Cash');
        $("#paid").removeAttr("disabled");
        $("#cashpaid").val("0");
        $("#cardpaid").val("0");
        $("#paid").val("0");
        updatetotal();
    }
    
    function openmixed(){
        
        if($("#payingcash").is(":hidden")){
            $("#payingcash").slideDown();
        }
        if($("#payingcard").is(":hidden")){
            $("#payingcard").slideDown();
        }
        if($("#ccp").is(":visible")){
            $("#ccp").slideUp();
        }
        if($("#voucherp").is(":visible")){
            $("#voucherp").slideUp();
        }
        if($("#checkp").is(":visible")){
            $("#checkp").slideUp();
        }
        if($("#balance").is(":visible")){
            $("#balance").slideUp();
        }
        
        if(parseFloat($("#cc_charge").val()) > 0){
            $("#divcccharge").show();
            $("#txtcc_charge").val("0");
            console.log('grandtotal : '+ parseFloat($("#grandtotal").val()) + " cc_charge : " + $("#cc_charge").val());
            var ccc= (parseFloat($("#cardpaid").val()) * parseInt($("#cc_charge").val()))/100;
            $("#txtcc_charge").val(Math.round(ccc));
            
        }
        
        $("#cctip").show();
        $("#mode").html('Mixed');
        $("#cashpaid").val("0");
        $("#cardpaid").val("0");
        $("#paid").val("0");
        $("#paid").attr("disabled","disabled");
        updatetotal();
        
    }
    
    function openbalance(){
        
        if($("#voucherp").is(":visible")){
            $("#voucherp").slideUp();
        }
        if($("#ccp").is(":visible")){
            $("#ccp").slideUp();
        }
        if($("#checkp").is(":visible")){
            $("#checkp").slideUp();
        }        
        if($("#balance").is(":hidden")){
            $("#balance").slideDown();
        }
        if($("#payingcash").is(":visible")){
            $("#payingcash").slideUp();
        }
        if($("#payingcard").is(":visible")){
            $("#payingcard").slideUp();
        }
        
        $("#divcccharge").hide();
        $("#txtcc_charge").val("0");
        
        
        $("#cctip").hide();
        $("#mode").html('Balance');
        $("#paid").removeAttr("disabled");
        updatetotal();
    }
    

    function product_row_sum(){
        
        var theTotal = 0;
        $("table td:nth-child(10) .combat").each(function () {
            
            var val = $(this).text();//.replace(" ", "").replace(",-", "");
            theTotal += parseFloat(val);
        });

        $('#txtsubtotal').val(theTotal.toFixed(2));
    }
    

    function usecustomeradvance(){
        var customeradvance = parseFloat($("#customeradvance").val());
        var grandtotal = parseFloat($("#grandtotal").val());
        var remainingadvance =0;
        
        if(customeradvance >= grandtotal){
            $("#txtadvance").val(grandtotal);
            remainingadvance = customeradvance-grandtotal;
            $("#remainingretained").val(remainingadvance);
            $("#retainedamountused").val(grandtotal);
            
            updatetotal();
            
            $("#btncustomeradvance").css('display','none');
            $("#txtcustomeradvance").html("Customer's Remaining Available Amount: " + remainingadvance);
            $("#retainedused").val('Yes');
            
        } else {
            $("#txtadvance").val(customeradvance);
            $("#remainingretained").val('0');
            $("#retainedamountused").val(customeradvance);
            
            updatetotal();
            
            $("#btncustomeradvance").css('display','none');
            $("#txtcustomeradvance").html("Customer's Remaining Available Amount: " + remainingadvance);
            $("#retainedused").val('Yes');
        }
        
        
    }

    function loyaltydiscount(lmode){
        
        if (lmode=='PercDiscount'){
            loyaltydiscount_perc();
        } else if (lmode=='RupeeDiscount'){
            loyaltydiscount_rupee();
        }
    }

    function loyaltydiscount_rupee(){
        var loyaltyrate=parseFloat($("#loyaltyrate").val());
        var loyaltydiscount=0;
        var loyaltypoints= parseFloat($("#loyaltypoints").val());
        loyaltydiscount=loyaltypoints*loyaltyrate;
        var loyaltyused=0;
        if(loyaltydiscount > parseFloat($("#txtsubtotal").val())){
            loyaltydiscount=parseFloat($("#txtsubtotal").val());           
        } 
        loyaltyused=loyaltydiscount/loyaltyrate;
        
        if(loyaltypoints>=1){
            if($("#btnloyalty").hasClass('btn-success')){
                $("#txtdiscount").val(loyaltydiscount);
                
                lu = parseFloat($("#txtdiscount").val())/loyaltyrate;
                $("#loyaltyused").val(loyaltyused);
                
                var parcentage = (parseFloat($("#txtdiscount").val()) / parseFloat($('#txtsubtotal').val())) * 100;
                 $('#txtdiscountperc').val(parcentage.toFixed(2));
                 
                $("#discount_remarks").val('Loyalty Points used for discount - ' + $("#discount_remarks").val());
                $("#ddiscount_remarks").val($("#discount_remarks").val());
                $("#txtloyalty").html('Loyalty');

                $("#txtdiscount").attr('readonly','readonly');
                $("#btnloyalty").html('Remove Loyalty');
                $("#btnloyalty").removeClass('btn-success');
                $("#btnloyalty").addClass('btn-danger');


            } else {
                $("#loyaltyused").val('0');
                $("#txtdiscount").val('0');
                $("#txtdiscountperc").val('0');
                $("#txtdiscount").attr('readonly','readonly');
                var str=$("#discount_remarks").val();
                $("#discount_remarks").val(str.replace('Loyalty Points used for discount - ', ''));
                $("#ddiscount_remarks").val($("#discount_remarks").val());
                $("#txtloyalty").html('');

                $("#btnloyalty").html('Redeem Loyalty');
                $("#btnloyalty").removeClass('btn-danger');
                $("#btnloyalty").addClass('btn-success');

            }
            updatetotal();
        }
    }
    
    function loyaltydiscount_perc(){
        
        var loyaltydiscount=0;
        var loyaltypoints= parseFloat($("#loyaltypoints").val());
        
        var loyaltyrate= 0;
        var loyaltyused=0;
        
        if(loyaltypoints >= 50 && loyaltypoints < 70){
            loyaltyrate=5;
            loyaltyused=50;
        } else if (loyaltypoints >= 70 && loyaltypoints < 170){
            loyaltyrate=7;
            loyaltyused=70;
        } else if (loyaltypoints >= 170 && loyaltypoints < 250){
            loyaltyrate=10;
            loyaltyused=170;
        } else if (loyaltypoints >= 250 && loyaltypoints < 350){
            loyaltyrate=16;
            loyaltyused=250;
        } else if (loyaltypoints >= 350 && loyaltypoints < 500){
            loyaltyrate=20;
            loyaltyused=350;
        } else if (loyaltypoints >= 500){
            loyaltyrate=20;
            loyaltyused=500;
        }
        
        loyaltydiscount=(parseFloat($("#txtsubtotal").val())*loyaltyrate)/100;
        
        if($("#btnloyalty").hasClass('btn-success')){
            $("#txtdiscount").val(loyaltydiscount);
            $('#txtdiscountperc').val(loyaltyrate);
            $("#loyaltyused").val(loyaltyused);
            
            $("#discount_remarks").val('Loyalty Points used for discount - ' + $("#discount_remarks").val());
            $("#ddiscount_remarks").val($("#discount_remarks").val());
            $("#txtloyalty").html('Loyalty');
            $("#txtdiscount").attr('readonly','readonly');
            $("#btnloyalty").html('Remove Loyalty');
            $("#btnloyalty").removeClass('btn-success');
            $("#btnloyalty").addClass('btn-danger');
            
        } else {
            $("#loyaltyused").val('0');
            $("#txtdiscount").val('0');
            $("#txtdiscountperc").val('0');
            $("#txtdiscount").attr('readonly','readonly');
            
            var str=$("#discount_remarks").val();
            $("#discount_remarks").val(str.replace('Loyalty Points used for discount - ', ''));
            $("#ddiscount_remarks").val($("#discount_remarks").val());
            $("#txtloyalty").html('');

            $("#btnloyalty").html('Redeem Loyalty');
            $("#btnloyalty").removeClass('btn-danger');
            $("#btnloyalty").addClass('btn-success');
        }
        updatetotal();
    }
</script>