<script>

    function updatepaying(){
        $("#paid").val(parseFloat($("#cashpaid").val()) + parseFloat($("#cardpaid").val()));
        updatetotal();
    }
    function updatepayingcard(){
       
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



    function product_edit(serviceid) {
        if (serviceid && serviceid != 0) {
            var visit_id_customer = $('#visit_id_customer').val();
            $.ajax({
                type: 'POST',
                url: 'invoice_controller/invoice_service_product/' + serviceid + '/' + visit_id_customer,
                dataType: "json",
                cache: false,
                async: true,
                success: function (data) {
                    if (data) {
                        var service_products = data['service_products'];
                        var products = data['products'];
                        var services = data['services'];
                        $('#product1').html('');
                        $('#product2').html('');
                        $.each(service_products, function (i, v) {
                            $('#product1').append('<option value = ' + v["business_product_id"] + '>' + v["product"] + '</option>');
                        });
                        $.each(services, function (i, s) {
                            $.each(products, function (i, p) {
                                if (s['id_visit_services'] === p['visit_service_id'] && serviceid === p['service_id']) {
                                    if (p["product_id"] !== null) {
                                        $('#product2').append('<option selected value = ' + p["product_id"] + '>' + p["product_name"] + '</option>');
                                    }
                                    $("#vid").val(p['visit_service_id']);
                                }
                            });
                        });
                        $('#product-modal').modal('show');
                    }
                }
            });

        }
    }

    function product_update() {
        var product_id = [];
        var product_name = [];
        $('#product2 :selected').each(function (i, selected) {
            product_id[i] = $(selected).val();
            product_name[i] = $(selected).text();
        });
        $.ajax({
            type: 'POST',
            url: 'invoice_controller/invoice_service_product_update',
            data: {product_id: product_id, product_name: product_name, customer_visit_id: $('#visit_id_customer').val(), visit_service_id: $('#vid').val()},
            success: function (data) {
                if (data) {
                    toastr.success('Product Updated');
                    location.reload();
                }
            }
        });
    }


    function updateHairColorHistory() {

        var customer_visit_id = $('#visitid').val();
        var txtcustomer_id = $('#customerid').val();
        var txtcustomer = $('#customername').val()
        var txttype_id = $('#txttype option:selected').val();
        var txttype = $('#txttype option:selected').text();
        var txttypenumber = $('#txttypenumber').val();

        if (txtcustomer_id === "" || txttype_id === "") {

            swal({
                title: 'Select Customer & Color Type',
                text: 'Above both fields are mandatory and should not be empty!',
                type: 'error',
                confirmButtonText: 'OK!'
            });

        } else {

            $.ajax({
                url: 'Colors_controller/color_record_add',
                type: 'POST',
                data: {
                    customer_visit_id: customer_visit_id,
                    txtcustomer_id: txtcustomer_id,
                    txtcustomer: txtcustomer,
                    txttype_id: txttype_id,
                    txttype: txttype,
                    txttypenumber: txttypenumber,
                    txttime: $('#txttime').val(),
                    txtcharge: $('#txtcharge').val(),
                    txtremarks: $('#txtcolorremarks').val(),
                    txtrecommendation: $('#txtrecommendation').val(),
                    txtdate: $('#txtdate').val(),
                    water_content: $('#txtw_content').val()
                },
                success: function (data) {
                    var result = data.split("|");
                    if (result[0] === "success") {
                        toastr.success('Color record added');
                        $('#addlist').modal('hide');
                    }
                }
            });

            return false;

        }

    }
    
    function addeyelashrecord(){
        var txtvisitid = $('#visitid').val();
        var txtcustomer_id = $('#customerid').val();
        var txtcustomer = $('#customername').val()
        if($('#txteyelashlength').val()==""){return false;}
        if($('#txteyelashprice').val()==""){return false;}
         $.ajax({
                url: '<?php echo base_url();?>eyelashes_controller/add_eyelashes',
                type: 'POST',
                data: {
                   visitid: txtvisitid,
                   customer_id: txtcustomer_id,
                   customer_name:  txtcustomer,
                   eyelash_type: $('#txttypeoflashes option:selected').val(),
                   thickness: $('#txteyelashthickness option:selected').val(),
                   curl: $('#txteyelashcurl option:selected').val(),
                   length: $('#txteyelashlength').val(),
                   remarks: $('#txteyelashremarks').val(),
                   date: $('#txteyelashdate').val(),
                   fullsetrefill: $('input[name=txt_full_set_refill]:checked').val(),
                   price: $('#txteyelashprice').val()
                },
                success: function (data) {
                    var result = data.split("|");
                    if (result[0] === "success") {
                        toastr.success('Eyelashes record added');
                        $('#addeyelashrecord').modal('hide');
                    }
                }
            });

            return false;
    }
    
    function updateFacialRecord() {

        var txtvisitid = $('#visitid').val();
        var txtcustomer_id = $('#customerid').val();
        var txtcustomer = $('#customername').val()
        var txttime = $('#txtfacialtime').val();
        var txtcharge = $('#txtfacialcharge').val();
        var txtremarks = $('#txtfacialremarks').val();
        var txtdate = $('#txtfacialdate').val();
        var txtexfoliant  = $('#txtfacialexfoliant').val();
        var txtmask = $('#txtfacialmask').val();
        var txtcleanser = $('#txtfacialcleanser').val();
        var txtfacial = $('#txtfacial').val();
       
            $.ajax({
                url: '<?php echo base_url();?>service_controller/facial_record_add',
                type: 'POST',
                data: {
                   txtvisitid: txtvisitid,
                   txtcustomer_id: txtcustomer_id,
                   txtcustomer:  txtcustomer,
                   txttime:  txttime,
                   txtcharge: txtcharge,
                   txtremarks: txtremarks,
                   txtdate: txtdate,
                   txtexfoliant:  txtexfoliant,
                   txtmask: txtmask,
                   txtcleanser: txtcleanser,
                   txtfacial: txtfacial
                },
                success: function (data) {
                    var result = data.split("|");
                    if (result[0] === "success") {
                        toastr.success('Facial record added');
                        $('#addfacial').modal('hide');
                    }
                }
            });

            return false;

    }

    function enabletaxes(val) {
        if (val === 'yes') {
            enabtax = true;
            console.log('taxes');
            $("#divtaxes").slideDown();
            updatetotal();
        } else {
            enabtax = false;
            $("#divtaxes").slideUp();
            updatetotal();
        }
    }


    function opencc() {
        if ($("#ccp").is(":hidden")) {
            $("#ccp").slideDown();
        }
        if ($("#voucherp").is(":visible")) {
            $("#voucherp").slideUp();
        }
        if ($("#balance").is(":visible")) {
            $("#balance").slideUp();
        }
        if ($("#ccp").is(":visible")) {
            $("#checkp").slideUp();
        }
        if ($("#payingcash").is(":visible")) {
            $("#payingcash").slideUp();
        }
        if ($("#payingcard").is(":visible")) {
            $("#payingcard").slideUp();
        }

        if (parseFloat($("#cc_charge").val()) > 0) {
            $("#divcccharge").show();
            $("#txtcc_charge").val("0");
            //console.log('grandtotal : '+ parseFloat($("#grandtotal").val()) + " cc_charge : " + $("#cc_charge").val());
            var ccc = (parseFloat($("#grandtotal").val()) * parseFloat($("#cc_charge").val())) / 100;
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


    function opendc() {
        if ($("#ccp").is(":hidden")) {
            $("#ccp").slideDown();
        }
        if ($("#voucherp").is(":visible")) {
            $("#voucherp").slideUp();
        }
        if ($("#balance").is(":visible")) {
            $("#balance").slideUp();
        }
        if ($("#ccp").is(":visible")) {
            $("#checkp").slideUp();
        }
        if ($("#payingcash").is(":visible")) {
            $("#payingcash").slideUp();
        }
        if ($("#payingcard").is(":visible")) {
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

    function openvoucher(mode) {
        if ($("#voucherp").is(":hidden")) {
            $("#voucherp").slideDown();
            $('#paid').val('0');
        }
        if ($("#checkp").is(":visible")) {
            $("#checkp").slideUp();
        }
        if ($("#balance").is(":visible")) {
            $("#balance").slideUp();
        }
        if ($("#ccp").is(":visible")) {
            $("#ccp").slideUp();
        }
        if ($("#payingcash").is(":visible")) {
            $("#payingcash").slideUp();
        }
        if ($("#payingcard").is(":visible")) {
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

    function openbank(mode) {
        if ($("#checkp").is(":hidden")) {
            $("#checkp").slideDown();
        }
        if ($("#voucherp").is(":visible")) {
            $("#voucherp").slideUp();
        }
        if ($("#balance").is(":visible")) {
            $("#balance").slideUp();
        }
        if ($("#ccp").is(":visible")) {
            $("#ccp").slideUp();
        }
        if ($("#payingcash").is(":visible")) {
            $("#payingcash").slideUp();
        }
        if ($("#payingcard").is(":visible")) {
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

    function opencash() {

        if ($("#ccp").is(":visible")) {
            $("#ccp").slideUp();
        }
        if ($("#voucherp").is(":visible")) {
            $("#voucherp").slideUp();
        }
        if ($("#checkp").is(":visible")) {
            $("#checkp").slideUp();
        }
        if ($("#balance").is(":visible")) {
            $("#balance").slideUp();
        }
        if ($("#payingcash").is(":visible")) {
            $("#payingcash").slideUp();
        }
        if ($("#payingcard").is(":visible")) {
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

    function openmixed() {

        if ($("#payingcash").is(":hidden")) {
            $("#payingcash").slideDown();
        }
        if ($("#payingcard").is(":hidden")) {
            $("#payingcard").slideDown();
        }
        if ($("#ccp").is(":visible")) {
            $("#ccp").slideUp();
        }
        if ($("#voucherp").is(":visible")) {
            $("#voucherp").slideUp();
        }
        if ($("#checkp").is(":visible")) {
            $("#checkp").slideUp();
        }
        if ($("#balance").is(":visible")) {
            $("#balance").slideUp();
        }

        if (parseFloat($("#cc_charge").val()) > 0) {
            $("#divcccharge").show();
            $("#txtcc_charge").val("0");
            console.log('grandtotal : ' + parseFloat($("#grandtotal").val()) + " cc_charge : " + $("#cc_charge").val());
            var ccc = (parseFloat($("#cardpaid").val()) * parseInt($("#cc_charge").val())) / 100;
            $("#txtcc_charge").val(Math.round(ccc));

        }
        
        $("#cctip").show();
        $("#mode").html('Mixed');
        $("#cashpaid").val("0");
        $("#cardpaid").val("0");
        $("#paid").val("0");
        $("#paid").attr("disabled", "disabled");
        updatetotal();
    }

    function openbalance() {

        if ($("#voucherp").is(":visible")) {
            $("#voucherp").slideUp();
        }
        if ($("#ccp").is(":visible")) {
            $("#ccp").slideUp();
        }
        if ($("#checkp").is(":visible")) {
            $("#checkp").slideUp();
        }
        if ($("#balance").is(":hidden")) {
            $("#balance").slideDown();
        }
        if ($("#payingcash").is(":visible")) {
            $("#payingcash").slideUp();
        }
        if ($("#payingcard").is(":visible")) {
            $("#payingcard").slideUp();
        }

        $("#divcccharge").hide();
        $("#txtcc_charge").val("0");
        

        $("#cctip").hide();
        $("#mode").html('Balance');
        $("#paid").removeAttr("disabled");
        updatetotal();
    }

    function updateothercharges() {
        calcdiscount_perc();
    }

    function calcdiscount_perc() {
        if ($("#txtothercharges").val() == "") {
            $("#txtothercharges").val(0);
        }
        var result = 0;
        if ($("#txtdiscountperc").val() !== "" && $("#txtdiscountperc").val() > 0) {
            result = (parseInt($("#txtsubtotal").val()) + parseInt($("#txtothercharges").val())) * parseInt($("#txtdiscountperc").val());
            result = result / 100;
        }

        $("#txtdiscount").val(result);
        //updatetotal();
        //$("#paid").val($("#grandtotal").val());
        //$("#balanceamount").val(parseFloat($("#grandtotal").val()) - parseFloat($("#paid").val()));
        updatetotal();
    }

    function validateVouchers() {

        if ($('#voucherno').val() === "" || $('#voucherno').val() === "0") {
            swal({
                title: 'Empty Field',
                text: 'Please provide voucher number!',
                type: 'warning',
                confirmButtonText: 'OK!'
            });
            return false;
        } else {
            var voucherno = 'C' + $('#voucherno').val();

            $.ajax({
                type: 'POST',
                url: 'Voucher_controller/validateVoucher',
                data: {
                    voucherno: voucherno
                },
                success: function (response) {
                    var data = $.parseJSON(response);
                    if (data.length > 0) {
                        var html = '<table class="table">';
                        html += '<thead>';
                        html += '<tr><th colspan="3">Customer Details</th></tr>';
                        html += '</thead>';
                        html += '<tbody>';
                        html += '<tr><td>Customer Name</td><td>' + data[0]['customer_name'] + '</td></tr>';
                        html += '<tr><td>Customer Email</td><td>' + data[0]['customer_email'] + '</td></tr>';
                        html += '<tr><td>Customer Phone</td><td>' + data[0]['customer_cell'] + '</td></tr>';
                        html += '</tbody>';
                        html += '<thead>';
                        html += '<tr><th colspan="3">Voucher Details</th></tr>';
                        html += '</thead>';
                        html += '<tbody>';
                        html += '<tr><td>Type</td><td>' + data[0]['type'].toUpperCase() + '</td></tr>';
                        html += '<tr><td>Generated on</td><td>' + data[0]['voucher_date'] + '</td></tr>';
                        html += '<tr><td>Expire on</td><td>' + data[0]['valid_until'] + '</td></tr>';
                        html += '<tr><td>Voucher #</td><td>' + data[0]['voucher_number'] + '</td></tr>';

                        if (data[0]['type'] === 'amount') {
                            html += '<tr><td>Total Amount Rs.</td><td>' + data[0]['amount'] + '</td></tr>';
                            html += '<tr><td>Remaining Amount Rs.</td><td>' + data[0]['remaining_amount'] + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 11px;">(This amount will be apply to the invoice)</span></td></tr>';
                        }
                        if (data[0]['type'] === 'service') {
                            html += '<tr><td>Services: </td><td>' + data[0]['service_names'].replace(/\|/g, '<div style="border-bottom: 1px solid #eee;"></div>') + '</td></tr>';
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
                            backdrop: 'static',
                            keyboard: false,
                            show: true
                        });

                    } else {
                        swal({
                            title: 'Not Found / Expired',
                            text: 'The provided voucher number ' + voucherno + ' is not found or expired.',
                            type: 'error',
                            confirmButtonText: 'OK!'
                        });
                    }
                }
            });
        }

    }

    function applyVoucher() {

        var type = $('#voucherType').val();

        if (type === 'amount') {
            var remaining = parseInt($('#voucherRemainingAmount').val());
            var grandtotal = parseInt($('#grandtotal').val());
            if (remaining >= grandtotal) {
                $('#paid').val(grandtotal);
                $('#voucherRemainingAmount').val(parseInt(remaining) - parseInt(grandtotal));
            }
            if (remaining < grandtotal) {
                $('#paid').val(remaining);
                $('#voucherRemainingAmount').val('0');
            }
            updatetotal();
            $('#voucherModal').modal('hide');
        }
        if (type === 'service') {

            var sids = [];
            var remainingServiceIds = $('#voucherRemainingServices').val().split('|');

            $('input[name=service_ids]').each(function () {
                sids.push($(this).val());
            });

            var diff_ids = arrayDifference(remainingServiceIds, sids);
            var remainingservices = "";

            $.each(diff_ids, function (index, value) {
                remainingservices += value + "|";
            });

            remainingservices = remainingservices.slice(0, -1);

            $('#voucherRemainingServices').val(remainingservices);

            var remaining = parseInt($('#voucherRemainingAmount').val());
            var grandtotal = parseInt($('#grandtotal').val());
            if (remaining >= grandtotal) {
                $('#paid').val(grandtotal);
                $('#voucherRemainingAmount').val(parseInt(remaining) - parseInt(grandtotal));
            }
            if (remaining < grandtotal) {
                $('#paid').val(remaining);
                $('#voucherRemainingAmount').val('0');
            }
            updatetotal();
            $('#voucherModal').modal('hide');
        }

    }

    function updateVoucher() {

        var remaining = $('#voucherRemainingAmount').val();
        var remaining_services = $('#voucherRemainingServices').val();
        var voucherno = 'C' + $('#voucherno').val();

        $.ajax({
            type: 'POST',
            url: 'Voucher_controller/updateRemainingAmount',
            data: {
                voucherno: voucherno,
                remaining: remaining,
                remaining_services: remaining_services
            },
            success: function (response) {
                if (response === 'success') {
                    $('button:contains("Verify")').hide();
                    if (parseInt(remaining) > 0) {
                        var vmodal = $('#voucherModal');
                        var html = '<center><h5>Voucher # ' + voucherno + ' has remaining amount. Please print new slip for it.</h5>';
                        html += '<a onclick="hideVoucherModal();" href="<?php echo base_url(); ?>viewvoucher/' + $('#voucherno').val() + '" target="_blank"><i class="fa fa-print"></i> Print Preview</a></center>';
                        $('#voucherModalFooter').hide();
                        $('#voucherHtml').html(html);
                        vmodal.modal({
                            backdrop: 'static',
                            keyboard: false,
                            show: true
                        });
                    }
                    return true;
                } else {
                    return false;
                }
            }
        });

    }

    function hideVoucherModal() {
        $('#voucherModal').modal('hide');
    }

    function arrayDifference(array1, array2) {
        var difference = [];
        for (var i = 0; i < array1.length; i++) {
            if ($.inArray(array1[i], array2) == -1) {
                difference.push(array1[i]);
            }
        }
        return difference;
    }



    function single_discount_pass(idservices) {
        
        $("#discount_by_service" + idservices).on('click', function () {
            
            if ($(this).attr("readonly")) {
                $("#invoicepass").modal("show");
            }
        });

        $("#discount_by_service" + idservices).dblclick(function () {
            //if($(this).attr("readonly")){
            $("#invoicepass").modal("show");
            //}
        });


        $("#perc_discount_service" + idservices).on('click', function () {
            if ($(this).attr("readonly")) {
                $("#invoicepass").modal("show");
            }
        });

        $("#perc_discount_service" + idservices).dblclick(function () {
            //if($(this).attr("readonly")){
            $("#invoicepass").modal("show");
            //}
        });


    }

    function usecustomeradvance() {
        var customeradvance = parseFloat($("#customeradvance").val());
        var grandtotal = parseFloat($("#grandtotal").val());
        var visitadvance =parseFloat($("#txtadvance").val());
        var remainingadvance = 0;

        if (customeradvance >= grandtotal) {
            $("#txtadvance").val(grandtotal+visitadvance);
            remainingadvance = customeradvance - grandtotal;
            $("#remainingretained").val(remainingadvance);
            $("#retainedamountused").val(grandtotal);

            updatetotal();

            $("#btncustomeradvance").css('display', 'none');
            $("#txtcustomeradvance").html("Customer's Remaining Available Amount: " + remainingadvance);
            $("#retainedused").val('Yes');

        } else {
            $("#txtadvance").val(customeradvance+visitadvance);
            $("#remainingretained").val('0');
            $("#retainedamountused").val(customeradvance);

            updatetotal();

            $("#btncustomeradvance").css('display', 'none');
            $("#txtcustomeradvance").html("Customer's Remaining Available Amount: " + remainingadvance);
            $("#retainedused").val('Yes');
        }


    }

    function loyaltydiscount(lmode) {
        console.log(lmode);
        if (lmode == 'PercDiscount') {
            loyaltydiscount_perc();
        } else if (lmode == 'RupeeDiscount') {
            loyaltydiscount_rupee();
        }
    }

    function loyaltydiscount_rupee() {
        var loyaltyrate = parseFloat($("#loyaltyrate").val());
        var loyaltydiscount = 0;
        var loyaltypoints = parseFloat($("#loyaltypoints").val());
        loyaltydiscount = loyaltypoints * loyaltyrate;
        var loyaltyused = 0;
        if (loyaltydiscount > parseFloat($("#txtsubtotal").val())) {
            loyaltydiscount = parseFloat($("#txtsubtotal").val());
        }
        loyaltyused = loyaltydiscount / loyaltyrate;

        if (loyaltypoints >= 1) {
            if ($("#btnloyalty").hasClass('btn-success')) {
                $("#txtdiscount").val(loyaltydiscount);

                lu = parseFloat($("#txtdiscount").val()) / loyaltyrate;
                $("#loyaltyused").val(loyaltyused);

                var parcentage = (parseFloat($("#txtdiscount").val()) / parseFloat($('#txtsubtotal').val())) * 100;
                $('#txtdiscountperc').val(parcentage.toFixed(2));

                $("#discount_remarks").val('Loyalty Points used for discount - ' + $("#discount_remarks").val());
                $("#ddiscount_remarks").val($("#discount_remarks").val());
                $("#txtloyalty").html('Loyalty');

                $("#txtdiscount").attr('readonly', 'readonly');
                $("#btnloyalty").html('Remove Loyalty');
                $("#btnloyalty").removeClass('btn-success');
                $("#btnloyalty").addClass('btn-danger');


            } else {
                $("#loyaltyused").val('0');
                $("#txtdiscount").val('0');
                $("#txtdiscountperc").val('0');
                $("#txtdiscount").attr('readonly', 'readonly');
                var str = $("#discount_remarks").val();
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

    function loyaltydiscount_perc() {

        var loyaltydiscount = 0;
        var loyaltypoints = parseFloat($("#loyaltypoints").val());

        var loyaltyrate = 0;
        var loyaltyused = 0;

        if (loyaltypoints >= 50 && loyaltypoints < 70) {
            loyaltyrate = 5;
            loyaltyused = 50;
        } else if (loyaltypoints >= 70 && loyaltypoints < 170) {
            loyaltyrate = 7;
            loyaltyused = 70;
        } else if (loyaltypoints >= 170 && loyaltypoints < 250) {
            loyaltyrate = 10;
            loyaltyused = 170;
        } else if (loyaltypoints >= 250 && loyaltypoints < 350) {
            loyaltyrate = 16;
            loyaltyused = 250;
        } else if (loyaltypoints >= 350 && loyaltypoints < 500) {
            loyaltyrate = 20;
            loyaltyused = 350;
        } else if (loyaltypoints >= 500) {
            loyaltyrate = 20;
            loyaltyused = 500;
        } else {
            toastr.warning('Not Enough Points!', 'Percentage discount starts after 50 points'); return false;
        }

        loyaltydiscount = (parseFloat($("#txtsubtotal").val()) * loyaltyrate) / 100;

        if ($("#btnloyalty").hasClass('btn-success')) {
            $("#txtdiscount").val(loyaltydiscount);
            $('#txtdiscountperc').val(loyaltyrate);
            $("#loyaltyused").val(loyaltyused);

            $("#discount_remarks").val('Loyalty Points used for discount - ' + $("#discount_remarks").val());
            $("#ddiscount_remarks").val($("#discount_remarks").val());
            $("#txtloyalty").html('Loyalty');
            $("#txtdiscount").attr('readonly', 'readonly');
            $("#btnloyalty").html('Remove Loyalty');
            $("#btnloyalty").removeClass('btn-success');
            $("#btnloyalty").addClass('btn-danger');

        } else {
            $("#loyaltyused").val('0');
            $("#txtdiscount").val('0');
            $("#txtdiscountperc").val('0');
            $("#txtdiscount").attr('readonly', 'readonly');

            var str = $("#discount_remarks").val();
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