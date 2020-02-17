<style>
    .datepicker{top:250px !important;}
</style>
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Good Return Note</h4>
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
                                    echo 'SalonPK';
                                } ?></h3>
                            </div>
                            <div class="pull-right">
                                <h4 >GRN # <br>
                                    <strong id="grnnumber">
                                        <strong id="ordernumber"><?php echo $grn_details[0]['grn_number']; ?></strong>
                                        <input type="hidden" id="grn_id" name ="grn_id" value="<?php echo $grn_details[0]['grn_id']; ?>" />
                                    </strong>
                                </h4>
                                <h4>PurchaseOrder # <br>
                                    <strong id="ordernumber"><?php echo $grn_details[0]['purchase_order_number']; ?></strong>
                                    <input type="hidden" id="po_id" name ="po_id" value="<?php echo $grn_details[0]['idpurchase_order']; ?>" />
                                </h4>
                            </div>
                        
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left m-t-10">
                                    <address>
                                        <strong>Supplier </strong>: <span id="suppliername"><?php echo $grn_details[0]['supplier_name']; ?></span><br>
                                        <strong>Address </strong>: <span class="address"><?php echo $grn_details[0]['ho_address']; ?></span><br>
                                        <strong>Contact </strong>: <span class="contact_number"><?php echo $grn_details[0]['contact_number']; ?></span><br>
                                        <strong>Branch </strong>: <span><?php echo $grn_details[0]['business_name']; ?></span> <input type="hidden" id="businessid" value="<?php echo $grn_details[0]['id_business']; ?>" /><br>
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
                                                <th>Brand</th>
                                                <th>Item</th>
                                                <th>Batch #</th>
                                                <th>Unit Price</th>
                                                <th class="hidden-print">GRN Qty</th>
                                                <th>GRN Value</th>
                                                <th class="text-danger">Return</th>
                                                <th>Total <span class="hidden-print">Returned Goods Value</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $subtotal = 0;
                                            if (isset($grn_details)) {
                                                $x = 1;
                                                foreach ($grn_details as $product) {
                                                    $subtotal = $subtotal + ($product['grn_unit_price'] * $product['grn_qty_received'])
                                                    ?>
                                                    <tr>
                                                        <td class="hidden-print"><?php echo $x; ?></td>
                                                        <td style="display:none"><?php echo $product['grn_product_id']; ?></td>
                                                        <td style="display:none"><?php echo $product['grn_brand_id']; ?></td>
                                                        <td><?php echo $product['business_brand_name']; ?></td>                                                        
                                                        <td><?php echo $product['product']; ?></td>
                                                        <td batch_id="<?php echo $product['grn_batch_id']; ?>"><?php echo $product['grn_batch_number']; ?></td>
                                                        <td id="grn_product_price_<?php echo $product['grn_product_id']; ?>"><?php echo $product['grn_unit_price']; ?></td>
                                                        <td class="hidden-print"><?php echo $product['grn_qty_received']; ?></td>
                                                        <td>Rs.<span class="po_cost"><?php echo $product['grn_qty_received'] * $product['grn_unit_price']; ?> </span></td>
                                                        <td class="text-danger" style="font-weight: bold;">
                                                            <input class="text-danger" style = "border:none; width: 70px" type= "number" min="0" max="<?php echo (float)$product['grn_qty_received']; ?>" onKeyUp="if(this.value><?php echo (float)$product['grn_qty_received']; ?>){this.value='<?php echo (float)$product['grn_qty_received']; ?>';}else if(this.value<0 || this.value==''){this.value='0';}" onchange="update_grn_product_value(<?php echo $product['grn_product_id']; ?>);" name="return_qty" id= "return_qty_<?php echo $product['grn_product_id']; ?>" value = "0" />
                                                        </td>
                                                        <td>Rs.<span class="grn_value"><input readonly="readonly" value="0" id="grn_product_value_<?php echo $product['grn_product_id']; ?>" style = "border:none; width: 70px"  name="grn_product_value_<?php echo $product['grn_product_id']; ?>"/></span></td>
                                                    </tr>
                                                    <?php $x++;
                                                } ?>
                                                    <tr>
                                                        <td class="hidden-print"></td><td colspan="4"><td class="hidden-print"></td><td><strong><input readonly="readonly" id="total_po_value" style = "border:none; width: 70px"  name="total_po_value" value="<?php echo $subtotal;?>" /></strong></td>
                                                        <td><strong><input class="text-danger" readonly="readonly" id="total_receiving" style = "border:none; width: 50px"  name="total_receiving" value="0" /></strong></td>
                                                        <td><strong><input  readonly="readonly" id="total_grn_value" style = "border:none; width: 70px"  name="total_grn_value" value="0" /></strong></td>
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
                                <a href="javascript:void(0);" onclick="addupdate_returnnote();" class="btn btn-primary waves-effect waves-light " id="btnsubmit">Submit</a>
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

               
            });

          
            function addupdate_returnnote() {
                if($('#total_receiving').val()=="0"){
                    swal({
                        title: "Info",
                        text: 'You should add the "Returned" quantities!',
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
                        text: "You want to Create the Return Note!",
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
                                url: "<?php echo base_url(); ?>purchaseorder_controller/return_note_addupdate",
                                data: {orderdata: TableData, purchaseorder_id: $('#po_id').val(), grn_id: $('#grn_id').val(), suppliername: $('#suppliername').html(), businessid: $('#businessid').val()},
                                success: function(data) {
                                    console.log(data);
                                    var result = data.split("|");
                                    if (result[0] === "success") {
                                        toastr.success('Return Note Created!', 'Done!');
                                        
                                        $("#btnsubmit").hide();
                                        $("#btnprint").show();

                                    } else {
                                        swal({
                                            title: "Error",
                                            text: 'Return Note not created!',
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
                        
                        "productid": $(tr).find('td:eq(1)').text()
                        , "brandid": $(tr).find('td:eq(2)').text()
                        , "brandname": $(tr).find('td:eq(3)').text()
                        , "productname": $(tr).find('td:eq(4)').text()
                        , "grnbatchnumber": $(tr).find('td:eq(5)').text()
                        , "grnbatchid": $(tr).find('td:eq(5)').attr('batch_id')
                        , "productunitprice": $(tr).find('td:eq(6)').text()
                        , "grnproductqty": $(tr).find('td:eq(7)').text()
                        , "returnQty": $(tr).find('td:eq(9)').find('input[name=return_qty]').val()
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

            var temp = "#return_qty_"+pid;
            newval=parseFloat($(temp).val()) * parseFloat($("#grn_product_price_"+pid).html());
            
            $("#grn_product_value_"+pid).val(newval);
            
            update_grn_total();    
        }
        
        function update_grn_total(){
            var theTotal = 0;
            var TotalReturn = 0;
            $("table td:nth-child(11) input").each(function () {
                console.log($(this).val());
                var val = $(this).val();
                theTotal += parseFloat(val);
            });
            
            $("table td:nth-child(10) input").each(function () {
                var val = $(this).val();
                TotalReturn += parseFloat(val);
            });

            $('#total_grn_value').val(theTotal.toFixed(2));
            $('#total_receiving').val(TotalReturn);
            
            $('#txtsubtotal').val(theTotal.toFixed(2));
        
        }
        

        </script>