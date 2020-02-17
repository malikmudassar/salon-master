<script>
    
    $(window).load(function(){
        
        $(".vertical-spin").TouchSpin({
            verticalbuttons: true,
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary",
            verticalupclass: 'ti-plus',
            verticaldownclass: 'ti-minus'
        });
        var vspinTrue = $(".vertical-spin").TouchSpin({
            verticalbuttons: true
        });
        if (vspinTrue) {
            $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
        }
        
//        $('#btngenorderinvoice').on('click', function(){
//            retail_updateorder();
//        });
        
    });
    
    function retail_updateorder(val='') {
         
        if ($("#order-id").val() === "") { //add new visit
            var TableData;
            TableData = retail_storeOTblValues();
            TableData = $.toJSON(TableData);
            if (TableData.length > 2) {
                $.ajax({
                    type: "POST",
                    //url: "order_controller/addorders",
                    url: '<?php echo base_url().'order_controller/addorders'; ?>',
                    //data: "orderdata=" + TableData.replace('&', '-'),
                    data: {
                        orderdata:TableData
                    },
                    success: function(data) {
                        var result = data.split("|");
                        if (result[0] === "success") {
                            $("#order-id").val(result[1]);
                            $('#btngenorderinvoice').show();
                            //retail_clearorder();
                            //retail_openOrder(result[1]);
                            
                           
                            if(val==''){
                                toastr.success('Order created!', 'Done!');                               
                            } else if (val=== 'reload'){
                                toastr.success('Order created!', 'Done!');
                                submitopendirectselect();
                            } else {
                                createinvoice();
                            }
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
            } else {
                swal({
                    title: "You have not added any Products",
                    text: 'Select Product and staff member providing that made the sale.',
                    type: "error",
                    confirmButtonText: 'OK!'
                });
            }
        } else { //update existing order
            var TableData;
            TableData = retail_storeOTblValues();
            TableData = $.toJSON(TableData);
            if (TableData.length > 2) {
                $.ajax({
                    type: "POST",
                    //url: "order_controller/updateorder",
                    url: '<?php echo base_url().'order_controller/updateorder'; ?>',
                    //data: "&orderdata=" + TableData + "&orderid=" + $("#order-id").val(),
                    data: {
                        orderdata:TableData,
                        orderid:$("#order-id").val()
                    },
                    success: function(data) {
                        if(data === 'invoiced'){
                            swal({
                                title: "Already Invoiced!",
                                text: 'This retail order is already invoiced.',
                                type: "error",
                                confirmButtonText: 'OK!'
                            });
                            return false;
                        }
                        var result = data.split("|");
                        if (result[0] === "success") {
                            //retail_clearorder();
                            //retail_openOrder(result[1]);
                            //$('#btngenorderinvoice').show();
                            
                            if(val==''){
                                toastr.success('Order updated!', 'Done!');                               
                            } else if (val=== 'reload'){
                                toastr.success('Order updated!', 'Done!');
                                location.reload();
                            } else {
                                createinvoice();
                            }
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
            } else {
                swal({
                    title: "You have not added any Products",
                    text: 'Select Product and staff member providing that made the sale.',
                    type: "error",
                    confirmButtonText: 'OK!'
                });
            }
        }
    }
    
    function retail_storeOTblValues(){
        var TableData = new Array();
        $('#ordertbl tr').each(function(row, tr) {
            TableData[row] = {
                "customerid": $(tr).find('td:eq(0)').text()
                , "productid": $(tr).find('td:eq(1)').text()
                , "productname": $(tr).find('td:eq(2)').text()
                , "category": $(tr).find('td:eq(3)').text()
                , "batch": $(tr).find('td:eq(4)').text()
                , "batch_id": $(tr).find('td:eq(4)').attr('batch_id')
                , "staffid": $(tr).find('td:eq(5)').text()
                , "staff": $(tr).find('td:eq(6)').text()
                , "qty": $(tr).find('td:eq(7)').text()
                , "stockfrom": $(tr).find('td:eq(7)').attr('stockfrom')
                
            }
        });
        TableData.shift();  // first row will be empty - so remove
        return TableData;
    }
    
    function retail_clearorder() {
        $('#order-customer-qty').val('1');
        $('#retail-order-staff').val('');
        //$("#order-customer-id").val('');
        //$("#order-customer-name").val('');
        $("#order-id").val('');
        //$("#order-customer-cell").val('');
        //$("#order-customer-email").val('');
        $('#order-products > option').eq(0).attr('selected', 'selected');
        $("#order-product-list tbody").html("");
        $("#tbllastorders tbody").html('');
        $("#btngenorderinvoice").hide();
        //$("#retail-divorder").hide();
    }
    
    
    
    function addOrderRows() {
        
        var stockfrom="in_stock";
        
        if ($("#order-customer-qty").val() === "" || $("#order-customer-qty").val() === "0" || $("#retail-order-products option:selected").val() === "select") {
            swal({
                title: "Product & Quantity Should not be empty!",
                text: 'Please select all the above options before proceeding.',
                type: "info",
                confirmButtonText: 'OK!'
            });
            return false;
        }
      
        r = $("#retail-order-products").val().split(',');
        var data = $("#retail-order-products").select2('data');
        
        var product_id = parseInt(data.id_business_products);
        var in_stock = parseInt(data.instock);
        var product_name = data.product;
        var category = data.category;
        var batch = data.batch_number;
        var batch_id = data.batch_id;
        var price = data.price;
        var unit_type =data.unit_type;
        var measure_unit=data.measure_unit;
        var qty_per_unit = data.qty_per_unit;
       
        var selected_qty = parseInt($("#order-customer-qty").val());
        
        if(parseInt(selected_qty)>in_stock ){
             swal({
                title: "Quantity cannot be more then available stock!",
                text: 'Please enter correct qty before proceeding.',
                type: "warning",
                confirmButtonText: 'OK!'
            });
            return false;
        } else {
            addOrderRow1(stockfrom, product_id, product_name, category, batch, batch_id, price, in_stock, unit_type, measure_unit, qty_per_unit);
        }

    }
    
    function addOrderRow1(stockfrom, product_id, product_name, category, batch, batch_id, price, in_stock, unit_type, measure_unit, qty_per_unit){
        var mhtml = "";
        
        var qty = parseInt($("#order-customer-qty").val());
        console.log('order add '+qty);
        if (parseInt(product_id) > 0) {

            var rowcount=0;
            var pTotalQty=0;
           
            var alreadyexist= retail_storeOTblValues();
            var ae = false;
            if(alreadyexist.length > 0){
                console.log(alreadyexist);
                $('#ordertbl tr').each(function(row, tr) {
                   // console.log($(tr).find('td:eq(1)').text() + ',' + $(tr).find('td:eq(4)').attr('batch_id'));
                    if($(tr).find('td:eq(1)').text()==product_id && $(tr).find('td:eq(4)').attr('batch_id')==batch_id){
                        pTotalQty = pTotalQty + parseInt($(tr).find('td:eq(7)').text()) + qty;
                        //console.log(pTotalQty); 
                        if(pTotalQty > in_stock){
                            swal({
                                title: "Quantity cannot be more then available stock!",
                                text: 'Please enter correct qty before proceeding.',
                                type: "warning",
                                confirmButtonText: 'OK!'
                            });
                            
                            ae=true;
                        } else {
                            qty=pTotalQty;
                            $(tr).find('td:eq(7)').text(qty);
                            //console.log('staff'+$('#retail-order-staff option:selected').val())
                            if($('#retail-order-staff option:selected').val()>0){
                                $(tr).find('td:eq(5)').text($('#retail-order-staff option:selected').val()); //staffid
                                $(tr).find('td:eq(6)').text($('#retail-order-staff option:selected').text()); //staff name
                            }
                            ae=true;
                        }    
                    }
                })
               
            }
            
            if(ae===true){
                return false;
            } else{
            
                mhtml += '<tr>';
                mhtml += '<td style="display:none;">' + $("#order-customer-id").val() + '</td>';
                //mhtml += "<td class='id' row='"+rowcount+"'>" + product_id + "</td>";
                mhtml += "<td class='id' row='"+rowcount+"'><input type='hidden' id='product_id' name='product_id' value='"+ product_id  +"'>" + product_id + "</td>";
                mhtml += "<td>" + product_name + "</td>";
                mhtml += "<td>" + category + "</td>";
                mhtml += "<td class='batchid' batch_id='"+batch_id+"'>" + batch + "</td>";
                mhtml += "<td style='display:none;'>";
                $('#retail-order-staff').children('option:selected').each(function() {
                    if($(this).val()!==""){
                        mhtml += $(this).val();
                    }
                });
                mhtml += "</td>";
                mhtml += "<td>";
                $('#retail-order-staff').children('option:selected').each(function() {
                    if($(this).val()!==""){
                        mhtml += $(this).text();
                    }
                });
                mhtml += "</td>";

                mhtml += '<td class="qty" stockfrom="'+ stockfrom +'">' + qty + '</td>';
                mhtml += '<td class="price">' + price + '</td>';
                //mhtml += '<td class="discount" style="display:none;"><input read type="text" onclick="single_discount_pass('+product_id+');" onblur="discount_by_product(0, '+product_id+');" class="numeric discount_by_product" name="discount_by_product" id="discount_by_product'+product_id+'" style="width: 80px; border: none;" value="0"></td>';
                //mhtml += '<td class="discountperc" style="display:none;"><input  onclick="single_discount_pass('+product_id+');" style="border:none; width: 40px;" onblur="javascript:perc_discount_product(0, '+product_id+');" class="numeric perc_discount_product" type="text" name="perc_discount_product" id="perc_discount_product'+product_id+'" placeholder="0"  /></td>';
                mhtml +='<td></td><td></td>';
                mhtml += '<td >Rs.<span class="combat" id="unitcost'+product_id+'">' + parseFloat(price)*parseFloat($("#order-customer-qty").val())  + '</span><input type="hidden" name="orignal_product_price" id="orignal_product_price'+product_id+'" value="' + parseFloat(price)*parseFloat($("#order-customer-qty").val())  + '"></td>'
                mhtml += '<td><span class="label label-danger" onclick="removebyrow(\'' + rowcount + '\');" style="cursor:pointer">x</span></td>';
                mhtml += "</tr>";
        
       
                $("#order-product-list tbody").append(mhtml);
                $("#order-customer-qty").val('1');
                $("#retail-order-staff").val('');
                //$('#retail-order-products').val('select');
            }
        }
    }
    
    function removebyrow(val) {
        //console.log(val);
        $('#order-product-list').find("td.id").each(function(index) {
        //    console.log($(this).attr("row"));
            if ($(this).attr("row") === val) {
                $(this).closest('tr').remove();
            }
        });
    }
    
    function removeproduct(val) {
        $('#order-product-list').find("td.id").each(function(index) {
            if ($(this).html() == val) {
                $(this).closest('tr').remove();
            }
        });
    }
    
    function retail_getstaff() {

        $('#retail-order-staff').html('<option></option>');

        $.ajax({
            type: 'POST',
            data:{param:'none'},
            //url: 'Scheduler_controller/getAllStaff',
            url: '<?php echo base_url().'Scheduler_controller/getAllStaff'; ?>',
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                for (x = 0; x < data.length; x++) {
                    if(data[x]['staff_active'] == "Y"){
                        $('#retail-order-staff').append('<option value=' + data[x]['id_staff'] + '>' + data[x]['staff_fullname'] + '</option>');
                    }
                }
            }
        });

    }
  
    function retail_getproducts() {
       // console.log($('#checkboxall').is(':checked'));
        var businessid=<?php echo $this->session->userdata('businessid');?>;
        if($('#checkboxall').is(':checked')){
            businessid="";
        }
        
        $("#retail-order-products").select2({
            ajax: {
              url: '<?php echo base_url().'product_controller/getproducts'; ?>',
              dataType: 'json',
              delay: 250,
              data: function (term, page) {
                  
                return {
                    productname: term, // search term
                    page_limit: 30, // page size
                    page: page, // page number
                    businessid: businessid
                };
              },
              results: function (data, page) {
                  
                    var more = (page * 30) < data.length;
                    return {results: data, more: more};
                }
              },
            escapeMarkup: function (m) { return m; }, // let our custom formatter work
            minimumInputLength: 1,
            formatResult: function (option) {
                return option.business_brand_name + ' - ' + option.product+ ' - ' + option.mcategory + ' ' + option.qty_per_unit + ' ' + option.measure_unit + ' - Batch: ' + option.batch + ' ('+ option.business_store +': ' + option.instock +') ';
            },
            formatSelection: function (option) {
                return option.business_brand_name + ' - ' + option.product+ ' - ' + option.mcategory + ' ' + option.qty_per_unit + ' ' + option.measure_unit + ' - Batch: ' + option.batch + ' ('+ option.business_store +': ' + option.instock+')' ;
            }
          });
        
    }
    
    function retail_openOrder(orderid, cid) {
        
        retail_getstaff();
        retail_getproducts();
        
        $('#order-customer-qty').val('1');
        
        if (orderid !== 0) {
            
            retail_fillorder(orderid);
            //retail_getbyid(cid);
            $("#divmain").hide();
            
        } else if ($("#txt-customer-id").val() !== "") {
            
            $("#order-customer-id").val($("#txt-customer-id").val());
            $("#order-customer-name").val($("#txt-customer-name").val());
            $("#order-customer-cell").val($("#txt-customer-cell").val());
            $("#order-customer-email").val($("#txt-customer-email").val());
            
            if(localStorage.getItem('customer_id') !== localStorage.getItem('txt-customer-id')){
                retail_clearorder();
            }
            
            localStorage.setItem('txt-customer-id', $("#txt-customer-id").val());
            
            retail_checkopenorder($("#txt-customer-id").val());
            $("#divmain").hide();
            $("#retail-divorder").fadeIn();
            
        }
        
    }

    function retail_fillorder(orderid, qtype) {
        var myurl;
        
        if (qtype === 1) {
            myurl = '<?php echo base_url().'Scheduler_controller/getOrderbyid/1'; ?>';
        } else {
            myurl = '<?php echo base_url().'Scheduler_controller/getOrderbyid'; ?>';
        }

        $.ajax({
            type: 'POST',
            url: myurl,
            data: {id_customer_order: orderid},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                if (qtype === 1) {
                    $("#order-id").val('');
                } else {
                    $("#order-id").val(data[0]['id_customer_order']);
                }
                $("#order-customer-id").val(data[0]['customer_id']);
                $("#order-customer-name").val(data[0]['customer_name']);
                $("#order-customer-cell").val(data[0]['customer_cell']);
                $("#order-customer-email").val(data[0]['customer_email']);
                mhtml = "";
                for (x = 0; x < data.length; x++) {
                    if(data[x]['staff_id'] !== null){
                        mhtml += '<tr>';
                        mhtml += '<td style="display:none;">' + data[x]['customer_id'] + '</td>';
                        mhtml += "<td class='id' row='"+x+"'>" + data[x]['product_id'] + "</td>";
                        mhtml += "<td>" + data[x]['product_name'] + "</td>";
                        mhtml += "<td>" + data[x]['category'] + "</td>";
                        mhtml += "<td class='batchid' batch_id='"+data[x]['batch_id']+"'>" + data[x]['batch'] + "</td>";
                        mhtml += "<td style='display:none;'>" + data[x]['staff_id'] + '</td>';
                        mhtml += "<td>" + data[x]['staff_name'] + '</td>';
                        mhtml += "<td stockfrom='"+ data[x]['stockfrom'] +"' >" + data[x]['qty'] + '</td>';
                        mhtml += "<td class='price' >" + data[x]['price'] + '</td>';
                        mhtml += '<td class="discount" style="display:none;"><input readonly type="text" onclick="single_discount_pass('+data[x]['product_id']+');" onkeyup="discount_by_product(0, '+data[x]['product_id']+');" class="numeric discount_by_product" name="discount_by_product" id="discount_by_product'+data[x]['product_id']+'" style="width: 80px; border: none;" value="0"></td>';
                        mhtml += '<td class="discountperc" style="display:none;"><input readonly onclick="single_discount_pass('+data[x]['product_id']+');" style="border:none; width: 40px;" onkeyup="javascript:perc_discount_product(0, '+data[x]['product_id']+');" class="numeric perc_discount_product" type="text" name="perc_discount_product" id="perc_discount_product'+data[x]['product_id']+'" placeholder="0"  /></td>';
                        mhtml += "<td class='totalprice'>" + parseFloat(data[x]['qty'])*parseFloat(data[x]['price']) + '</td>';
                        mhtml += '<td><span class="label label-danger" onclick="removebyrow(\'' + x + '\');" style="cursor:pointer">x</span></td>';
                        mhtml += "</tr>";
                    }
                }
                $("#order-product-list tbody").append(mhtml);
                $("#btngenorderinvoice").show();
                $('#retail-divorder').slideDown();
                
            }
        });
    }

    function retail_checkopenorder(cid) {
        retail_clearorder();
        $.ajax({
            type: 'POST',
            //url: 'order_controller/getOrderbyCid',
            url: '<?php echo base_url().'order_controller/getOrderbyCid'; ?>',
            data: {customerid: cid},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                if (data.length > 0) {
                    retail_fillorder(data[0]['id_customer_order']);
                } 
            }
        });
    }
    
</script>
