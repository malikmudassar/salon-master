<style>
    .datepicker{top:250px !important;}
</style>
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Good Received Note</h4>
            </div>
        </div>

       <div id="maingrn_view" class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="clearfix">
                            <div class="pull-left">
                                <h3 class="logo invoice-logo"><?php if (isset($business)) {
                                    echo "<img src='" . base_url() . 'assets/images/business/' . $business[0]['business_logo'] . "' alt='" . $business[0]['business_name'] . "' />";
                                } else {
                                    echo 'Skedwise';
                                } ?></h3>
                            </div>
                            <div class="pull-right">
                                <h4 >GRN # <br>
                                    <strong id="grnnumber"></strong>
                                </h4>
                                <h4>PurchaseOrder # <br>
                                    <strong id="ordernumber"><?php echo $purchaseorder[0]['purchase_order_number']; ?></strong>
                                    <input type="hidden" id="po_id" name ="po_id" value="<?php echo $purchaseorder[0]['idpurchase_order']; ?>" />
                                </h4>
                            </div>
                        
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left m-t-10">
                                    <address>
                                        <strong>Supplier </strong>: <span id="suppliername"><?php echo $purchaseorder[0]['supplier_name']; ?></span><br>
                                        <strong>Address </strong>: <span class="address"><?php echo $purchaseorder[0]['ho_address']; ?></span><br>
                                        <strong>Contact </strong>: <span class="contact_number"><?php echo $purchaseorder[0]['contact_number']; ?></span><br>
                                    </address>
                                </div>
                                <div class="pull-right m-t-10">
                                    <p><strong>Date: </strong> <?php echo date('d-m-Y'); ?></p>
                                </div>
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->

                        <!--<div class="m-h-10"></div>-->

                        <div class="row">
                            <div class="col-md-12">
                                
                                <div >
                                    <table class="table  m-t-5" id="tbl_po_products">
                                        <thead>
                                            <tr>
                                                <th class="hidden-print">#</th>
                                                <th>For Branch</th>
                                                <th>Brand</th>
                                                <th>Item</th>
                                                <th>Batch #</th>
                                                <th>Expiry Date</th>
                                                <th>Unit Price</th>
                                                <th class="hidden-print">Ordered Qty</th>
                                                <th>PO Value</th>
                                                <th class="hidden-print">Already Received</th>
                                                <th>Receiving <span class="hidden-print">Now</span></th>
                                                <th>Total <span class="hidden-print">GRN Value</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $subtotal = 0; $recieved=0; $ordered=0; $recieving_now=0;
                                            if (isset($grn_details)) {
                                                $x = 1;
                                                foreach ($grn_details as $product) {
                                                    $subtotal = $subtotal + ($product['product_purchase_price'] * $product['product_qty']);
                                                    $recieved+=$product['received_qty']-$product['returned']; 
                                                    $ordered= $ordered + Intval($product['product_qty']); 
                                                    ?>
                                                    <tr>
                                                        <td class="hidden-print"><?php echo $x; ?></td>
                                                        <td><?php echo $product['business_name']; ?></td>
                                                        <td style="display:none"><?php echo $product['product_id']; ?></td>
                                                        <td style="display:none"><?php echo $product['brand_id']; ?></td>
                                                        <td style="display:none"><?php echo $product['business_id']; ?></td>
                                                        <td><?php echo $product['brand_name']; ?></td>                                                        
                                                        <td><?php echo $product['product_name']; ?></td>
                                                        <td>
                                                            <select onchange='update_expiry(<?php echo $product['product_id'];?>)' class='text-custom' id="grn_batch_number_<?php echo $product['product_id'];?>" name='grn_batch_number' style="border:none; width: 60px" >
                                                                <option expiry=''></option>
                                                                <?php foreach($batchnos as $batch){ ?>
                                                                    <?php foreach($batch as $b){ ?>
                                                                        <?php if(isset($b) && $b['product_id']==$product['product_id']){?>
                                                                            <option expiry='<?php echo $b['expiry_date'];?>' batch_id="<?php echo $b['id_batch']; ?>"> <?php echo $b['batch_number'].' '.$b['business_store']; ?></option>
                                                                        <?php } ?>    
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                        <td><input class='text-custom expiry' id="expiry_date_<?php echo $product['product_id'];?>" name='expiry_date' style="border:none; width: 80px" value='' /></td>
                                                        <td><input type="number" class='text-custom' style='border:none; width:70px' onchange="update_grn_product_value(<?php echo $product['product_id']; ?>);" onKeyUp="if(this.value==''){this.value='0';}" name="grn_product_price" id="grn_product_price_<?php echo $product['product_id']; ?>" value="<?php echo $product['product_purchase_price']; ?>"/></td>
                                                        <td class="hidden-print"><input type="hidden" id="grn_product_qty_<?php echo $product['product_id']; ?>" value="<?php echo $product['product_qty']; ?>"/><?php echo $product['product_qty']; ?></td>
                                                        <td>Rs.<span class="po_cost"><?php echo $product['product_qty'] * $product['product_purchase_price']; ?> </span></td>
                                                        <td class="hidden-print"><?php echo $product['received_qty']-$product['returned']; ?></td>
                                                        <td class="text-custom" style="font-weight: bold;">
                                                            <input style = "border:none; width: 70px" type= "number" min="0" max="<?php echo (float)$product['product_qty']-((float)$product['received']-$product['returned']); ?>" onKeyUp="if(this.value><?php echo (float)$product['product_qty']-((float)$product['received']-$product['returned']); ?>){this.value='<?php echo (float)$product['product_qty']-(float)$product['received']; ?>';}else if(this.value<0 || this.value==''){this.value='0';}" onchange="update_grn_product_value(<?php echo $product['product_id']; ?>);" name="received_qty" id= "received_qty_<?php echo $product['product_id']; ?>" value = "0" />
                                                        </td>
                                                        <td>Rs.<span class="grn_value"><input readonly="readonly" value="0" id="grn_product_value_<?php echo $product['product_id']; ?>" style = "border:none; width: 70px"  name="grn_product_value_<?php echo $product['product_id']; ?>"/></span></td>
                                                        
                                                    </tr>
                                                    <?php $x++;
                                                } ?>
                                                    <tr>
                                                        <td class="hidden-print"></td><td colspan="5"><td class="hidden-print"></td><td><strong><input readonly="readonly" id="total_po_qty" style = "border:none; width: 70px"  name="total_po_qty" value="<?php echo $ordered;?>" /></strong></td>
                                                        <td><strong><input readonly="readonly" id="total_po_value" style = "border:none; width: 70px"  name="total_po_value" value="<?php echo $subtotal;?>" /></strong></td>
                                                        <td class="hidden-print"><input readonly="readonly" id="total_received_qty" style = "border:none; width: 70px"  name="total_received_qty" value="<?php echo $recieved;?>" /></td><td><strong><input readonly="readonly" id="total_receiving" style = "border:none; width: 50px"  name="total_receiving" value="0" /></strong></td>
                                                        <td><strong><input readonly="readonly" id="total_grn_value" style = "border:none; width: 70px"  name="total_grn_value" value="0" /></strong></td>
                                                    </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                      
                        <hr>
                        <div class="hidden-print">
                            <div class="pull-right">
                                <a href="javascript:void(0);" onclick="addupdate_grn();" class="btn btn-primary waves-effect waves-light " id="btnsubmit">Submit</a>
                                <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light" id="btnprint" ><i class="fa fa-print"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- end row -->

        <script>

            $(document).ready(function() {
                
                $('.expiry').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy-mm-dd'
                });
                
                $(".numeric").keypress(function(e) {
                    //if the letter is not digit then display error and don't type anything
                    if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                        return false;
                    }
                });
                //updatetotal();

                toastr.options = {
                    "closeButton": true,
                    "debug": true,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-bottom-center",
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }

                $("#selectorder").select2({
                    //maximumSelectionLength: 2
                    //formatNoMatches: Not_Found
                });

            });

            function process() {

                $("#mode").html('Processing');
            }
            function pending() {

                $("#mode").html('Pending');
            }
            function deliver() {

                $("#mode").html('Delivered');
            }
         

            function addupdate_grn() {
                if($('#total_receiving').val()=="0"){
                    swal({
                        title: "Info",
                        text: 'You should add the "Receiving Now" quantities!',
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                    return false;
                }
                
                var TableData;
                TableData = retail_storeOTblValues();
                TableData = $.toJSON(TableData);
                
                if (TableData.length > 2) {
                   
                    swal({
                        title: "Are you sure?",
                        text: "You want to add GRN!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: 'Yes, I am sure!',
                        cancelButtonText: "No, cancel it!",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function(isConfirm) {
                        if(isConfirm){
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>purchaseorder_controller/grn_addupdate",
                                data: {orderdata: TableData, 
                                        purchaseorder_id: $('#po_id').val(), 
                                        purchaseorder_number: $('#ordernumber').html(), 
                                        suppliername: $('#suppliername').html(), 
                                        order_status: $('#orderstatus option:selected').val(),
                                        received_qty: $("#total_received_qty").val(),
                                        ordered_qty: $("#total_po_qty").val(),                                        
                                        received_now: $('#total_receiving').val(),
                                        description: 'Payable For PO# '+$('#ordernumber').html()+" Against GRN # "
                                    },
                                success: function(data) {
                                    console.log(data);
                                    var result = data.split("|");
                                    if (result[0] === "success") {
                                        toastr.success('Grn created!', 'Done!');
                                        $("#grnnumber").html(result[2]);
                                        $("#btnsubmit").hide();
                                        $("#btnprint").show();

                                    } else {
                                        swal({
                                            title: "Error",
                                            text: 'GRN not created!',
                                            type: "error",
                                            confirmButtonText: 'OK!'
                                        });
                                    }
                                }
                            });
                        }
                    })
                } else {
                    swal({
                        title: "Something went wrong kindly check your GRN",
                        //text: 'Select Product and staff member providing that made the sale.',
                        type: "warning",
                        confirmButtonText: 'OK!'
                    });
                }
            }

            function retail_storeOTblValues() {
                var TableData = new Array();
                $('#tbl_po_products tr').each(function(row, tr) {
                    TableData[row] = {
                        "productid": $(tr).find('td:eq(2)').text()
                        , "brandid": $(tr).find('td:eq(3)').text()
                        , "businessid": $(tr).find('td:eq(4)').text()
                        , "brandname": $(tr).find('td:eq(5)').text()
                        , "productname": $(tr).find('td:eq(6)').text()
                        , "grnbatchnumber": $(tr).find('td:eq(7)').find('select[name=grn_batch_number]').val()
                        , "grnbatchid": $(tr).find('td:eq(7)').find('select[name=grn_batch_number] option:selected').attr('batch_id')
                        , "expiry_date": $(tr).find('td:eq(8)').find('input[name=expiry_date]').val()
                        , "productunitprice": $(tr).find('td:eq(9)').find('input[name=grn_product_price]').val()
                        , "receivedQty": $(tr).find('td:eq(13)').find('input[name=received_qty]').val()
                                //, "suppliername": $(tr).find('td:eq(11)').text()
                       

                    }
                });
                TableData.shift();  // first row will be empty - so remove
                TableData.pop();  // last row will be empty - so remove
                return TableData;
            }

            function orderstatus(order_value) {
                return false;
                var purchaseorder_id = $('#selectorder option:selected').val();
                if (order_value) {
                    swal({
                        title: "Are you sure?",
                        text: "You want to change the order status!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: 'Yes, I am sure!',
                        cancelButtonText: "No, cancel it!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            swal({
                                title: 'Order status changed!!',
                                //text: 'Order status changed!',
                                type: 'success'
                            }, function() {
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo base_url(); ?>purchaseorder_controller/purchase_order_status",
                                    data: {purchaseorder_id: purchaseorder_id, order_status: order_value},
                                    success: function(data) {
                                        var result = data.split("|");
                                        if (result[0] === "success") {
                                            //toastr.success('Order status changed!', 'Done!');
                                            window.location.href = '<?php echo base_url('purchase_orders'); ?>';
                                        } else {
                                            swal({
                                                title: "Warning",
                                                type: "warning",
                                                confirmButtonText: 'OK!'
                                            });
                                        }
                                    }
                                });
                            });

                        } else {
                            swal("Cancelled", "Your current order status is saved!", "error");
                            setTimeout(function() {
                                $('#orderstatus').val($('#selectorder option:selected').attr('order-status'));
                            }, 1000);
                        }
                    });
                }
            }
            
        function update_grn_product_value(pid){

            var temp = "#received_qty_"+pid;
            newval=parseFloat($(temp).val()) * parseFloat($("#grn_product_price_"+pid).val());

            
            $("#grn_product_value_"+pid).val(newval);
            
            update_grn_total();    
        }
        
        function update_grn_total(){
            var theTotal = 0;
            var TotalRec = 0;
            $("table td:nth-child(15) input").each(function () {
                var val = $(this).val();
                theTotal += parseFloat(val);
            });
            
            $("table td:nth-child(14) input").each(function () {
                var val = $(this).val();
                TotalRec += parseFloat(val);
            });

            $('#total_grn_value').val(theTotal.toFixed(2));
            $('#total_receiving').val(TotalRec);
            
            $('#txtsubtotal').val(theTotal.toFixed(2));
            
        }
        
        function update_expiry(product_id){
            temp = "#grn_batch_number_"+product_id;
            $('#expiry_date_'+product_id).val($(temp +' option:selected').attr('expiry'));
        }
        </script>