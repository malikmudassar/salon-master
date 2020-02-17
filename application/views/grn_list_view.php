<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                
                <h4 class="page-title">GRN List</h4>
            </div>
        </div>
        <?php if ($this->session->flashdata('Success') && $this->session->flashdata('Success') != "") { ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Success!</strong> <?php echo $this->session->flashdata('Success'); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('Error') && $this->session->flashdata('Error') != "") { ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Error!</strong> <?php echo $this->session->flashdata('Error'); ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div id="maingrn_view" class="row " >
            <div class="col-md-6 col-xs-12">
                <div class="panel panel-default" style="min-height: 915px !important;">
                     <div class="panel-heading">
                        <h4>Purchase Order Details</h4>
                    </div> 
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title text-primary">Purchase Order # : <span id="po"> <?php echo $purchaseorder[0]['purchase_order_number'];?></span></h4>
                                <h5 >For Branch : <strong><?php echo $purchaseorder[0]['business_name'];?></strong></h5>
                                <input type='hidden' id="businessid" value='<?php echo $purchaseorder[0]['id_business'];?>'>
                                <div class="col-md-12 m-t-20 m-b-20">
                                    <table class="table">
                                        <tr style="font-weight: bold">
                                            <td>Supplier: </td><td class="text-pink"><?php echo $purchaseorder[0]['supplier_name'];?></td>
                                            <td>Dated: </td><td class="text-pink"><?php echo $purchaseorder[0]['d'];?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold">Contact Person: </td><td class="text-pink"><?php echo $purchaseorder[0]['contact_person'];?></td>
                                            <td style="font-weight: bold">Contact Number: </td><td class="text-pink"><?php echo $purchaseorder[0]['contact_number'].', '.$purchaseorder[0]['office_phone1'].' '.$purchaseorder[0]['office_phone2'];?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold">Office Address: </td><td class="text-pink"><?php echo $purchaseorder[0]['ho_address'];?></td>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                <form action="<?php echo base_url('purchaseorder_controller/purchase_order_status');?>" method="post">
                                                    <input type="hidden" id="csrf_po_status" name="csrf_test_name">
                                                    <input type="hidden" name="purchaseorder_id" value="<?php echo $purchaseorder[0]['idpurchase_order']; ?>">
                                                    
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <select class="form-control" name="order_status">
                                                                <option <?php if($purchaseorder[0]['status']=="Pending"){echo "selected='selected'";} ?> value="Pending">Pending</option>
                                                                <option <?php if($purchaseorder[0]['status']=="Received"){echo "selected='selected'";} ?> value="Received">Received</option>
                                                                <option <?php if($purchaseorder[0]['status']=="Paid"){echo "selected='selected'";} ?> value="Paid">Paid</option>

                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button type="submit" onclick="$('#csrf_po_status').val($('#cook').val());" class="btn btn-sm btn-pink">update</button>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                </form>
                                                
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                        <div class="row" id="po_details">
                             <div class="col-md-12">
                                <h4 class="text-primary">Ordered Quantities</h4>
                                <div class="table-responsive">
                                    <table class="table m-t-10" >
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Brand</th>
                                                <th>Item</th>
                                                <th>Ordered Qty</th>
                                                <th class="text-success">Received Qty</th>
                                                <th class="text-danger">Returned Qty</th>
                                                <th class="text-primary">Actual Receiving</th>
                                                 <th>Unit Price</th>
                                                <th>Total Price</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $subtotal = 0; $receivedtotal =0; $ordered=0; $returnedtotal=0;
                                            if (isset($purchaseorder_details)) {
                                                $x = 1;
                                                foreach ($purchaseorder_details as $product) {
                                                    $subtotal = $subtotal + ((float)$product['product_purchase_price'] * (float)$product['product_qty']);
                                                    $receivedtotal = $receivedtotal + (float)$product['received'];
                                                    $returnedtotal=$returnedtotal + $product['returned'];
                                                    $ordered=$ordered + (float)$product['product_qty'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $x; ?></td>
                                                        <td><?php echo $product['business_brand_name']; ?></td>
                                                        <td><?php echo $product['product'].' '.$product['category'].' '.$product['qty_per_unit'].' '.$product['measure_unit']; ?></td>
                                                        <td><?php echo $product['product_qty']; ?></td>
                                                        <td class="text-success"><strong><?php echo $product['received']; ?></strong></td>
                                                        <td class="text-danger"><strong><?php echo $product['returned']; ?></strong></td>
                                                        <td class="text-primary"><strong><?php echo $product['received']-$product['returned']; ?></strong></td>
                                                        <td><?php echo $product['product_purchase_price']; ?></td>
                                                        <td style="text-align:right">Rs.<span id="unitcost"><?php echo (float)$product['product_qty'] * (float)$product['product_purchase_price']; ?> </span></td>
                                                        
                                                    </tr>
                                                    <?php $x++;
                                                }?>
                                                    <tr style="font-weight: bold; "><td colspan="2">
                                                        <td >Totals:</td>
                                                        <td><?php echo $ordered; ?></td>
                                                        <td class="text-success"><?php echo $receivedtotal;?></td>
                                                        <td class="text-danger"> <?php echo $returnedtotal;?></td>
                                                        <td class="text-primary"><?php echo $receivedtotal-$returnedtotal;?></td>
                                                        <td></td>
                                                        <td style="text-align:right"><?php echo $subtotal;?></td>
                                                    </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                       
                    </div>
                </div>

            </div>
            <div class="col-md-6 col-xs-12">
                <div class="panel panel-default" style="min-height: 915px !important;">
                     <div class="panel-heading">
                        <h4>Goods Receive Notes</h4>
                    </div> 
                    <div class="panel-body">
                        <div class="row m-b-20">
                            <div class="col-md-12">
                                <div class="btn-group pull-right m-t-15">
                                    <a type="button" href="<?php echo base_url();?>good_recieved_note/<?php echo $purchaseorder[0]['idpurchase_order']; ?>"  class="btn btn-custom waves-effect waves-light create-grn" >Create GRN <span class="m-l-5"><i class="fa fa-plus"></i></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table m-t-30" id="tblreport">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>GRN#</th>
                                                <th>Brand</th>
                                                <th>Item</th>
                                                <th>Unit Price</th>
                                                <th>Received Qty</th>
                                                <th>Returned Qty</th>
                                                <th>Batch Number</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php if(isset($grns)){$totalgrncost=0; foreach ($grns as $grn){ ?>
                                            <tr>
                                                <td><?php echo $grn['grn_id'];?></td>
                                                <td><?php echo $grn['grn_number'];?></td>
                                                <td><?php echo $grn['business_brand_name'];?></td>
                                                <td><?php echo $grn['product'];?></td>
                                                <td><?php echo $grn['grn_unit_price'];?></td>
                                                <td><?php echo $grn['received'];?></td>
                                                <td><?php echo $grn['returned'];?></td>
                                                <?php $totalgrncost=$totalgrncost+((float)$grn['grn_unit_price']*((float) $grn['received']-$grn['returned']));?>
                                                <td><?php echo $grn['grn_batch_number'];?></td>
                                                <td><?php echo $grn['d'];?></td>
                                                <td>
                                                    <a type="button" href="<?php echo base_url();?>good_return_note/<?php echo $grn['grn_id']; ?>"  class="btn btn-danger waves-effect waves-light create-return m-r-5" >Return <span class="m-r-5"><i class="fa fa-minus"></i></span></a>
                                                    <a href="<?php echo base_url().'good_recieved_print/'.$grn['grn_id'];?>" target="_blank" class="btn btn-inverse waves-effect waves-light" id="btnprint" ><i class="fa fa-print"></i></a>
                                                </td>
                                            </tr>
                                            <?php }} ?>
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                        <!--grn end-->
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row margin-view">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <!---Payments--->
                        <div class="row" id="po_payments">
                            
                            <div class="col-md-12">
                                <div class="pull-left">
                                    <h4 class="text-primary">Payments</h4>
                                </div>
                                <div class="btn-group pull-right m-t-15">
                                    <a type="button" href="<?php echo base_url();?>supplier_payment/<?php echo $purchaseorder[0]['idpurchase_order']; ?>"  class="btn btn-sm btn-custom waves-effect waves-light" >Add Payment<span class="m-l-5"><i class="fa fa-plus"></i></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-md-12">                                
                                <div class="table-responsive">
                                    <table class="table m-t-10" >
                                        <thead>
                                            <tr>
                                                <th>Voucher #</th>
                                                <th>Supplier</th>
                                                <th>Paid Through</th>
                                                <th>Payment Date</th>
                                                <th style="text-align:right">Payment Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total_payment=0; foreach($payments as $payment){ ?>
                                            <tr>
                                                <td><?php echo $payment['id_account_vouchers']; ?></td>
                                                <td><?php echo $payment['business_partner_name']; ?></td>
                                                <td><?php echo $payment['payment_mode'].' '.$payment['instrument_number']; ?></td>
                                                <td><?php echo $payment['voucher_date']; ?></td>
                                                <td style="text-align:right">Rs.<?php echo $payment['credit']; ?></td>
                                                <td><form method="post" action="<?php echo base_url('accounting_controller/cancel_voucher');?>"><input type="hidden" name="return_path" value="grn_list/<?php echo $purchaseorder[0]['idpurchase_order'] ?>" ><input type="hidden" name="id_account_voucher" value="<?php echo $payment['id_account_vouchers'];?>"><input type="hidden" id="csrf_payment_remove" name="csrf_test_name"><button type="submit" onclick="$('#csrf_payment_remove').val($('#cook').val());" class="btn btn-xs btn-danger"><i class="fa fa-close"></i></button></form></td>
                                            </tr>
                                            <?php $total_payment=$total_payment+ $payment['credit'];} ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Total Payment</th>
                                                <th style="text-align:right"><?php echo $total_payment;?></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th class="text-danger">Payment Due (Received Qty)</th>
                                                <th class="text-danger" style="text-align:right"><?php echo $totalgrncost - $total_payment;?></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                             </div>
                        </div>
                        
                        <!---Payments End--->
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <!--Grn edit modal start-->
        <div id="editgrnmodal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editgrnmodal" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit GRN</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="unitprice" class="control-label">Unit price</label>
                                            <input class="form-control" name="unitprice" id="unitprice" />
                                        </div> 
                                    </div> 
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="receivedqty" class="control-label">Received qty</label>
                                            <input class="form-control numeric" name="receivedqty" id="receivedqty" />
                                        </div> 
                                    </div> 
                                </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="receivedinstockqty" class="control-label">Received instock qty</label>
                                            <input class="form-control numeric" name="receivedinstockqty" id="receivedinstockqty" />
                                            <input type="hidden" name="receivedinstock_orignal" id="receivedinstock_orignal" />
                                        </div> 
                                    </div> 
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="receivedinhouseqty" class="control-label">Received inhouse qty</label>
                                            <input class="form-control numeric" name="receivedinhouseqty" id="receivedinhouseqty" />
                                            <input type="hidden" name="receivedinhouse_orignal" id="receivedinhouse_orignal" />
                                        </div> 
                                    </div> 
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="grneditid" id="grneditid" />
                        <input type="hidden" name="grn_brand_id" id="grn_brand_id" />
                        <input type="hidden" name="grn_product_id" id="grn_product_id" />
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="update();" type="button" class="btn btn-custom waves-effect waves-light orderloader"><span>Save</span></button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--Grn edit modal end-->
       
        <script>

            $(document).ready(function() {
                $('#tblreport').DataTable({
                    dom: "Bfrtlip",
                    fixedHeader: {header: true},
                    buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                            extend: "excel",
                            className: "btn-sm"
                        }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
                    responsive: !0
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



            function edit_grn(grn_id, unitprice, received_qty, instock_qty, inhouse_qty, brand_id, product_id) {
                if (localStorage.getItem("orderstatus") !== "Delivered") {
                    $('#grneditid').val(grn_id);
                    $('#unitprice').val(unitprice);
                    $('#receivedqty').val(received_qty);
                    $('#receivedinstockqty').val(instock_qty);
                    $('#receivedinhouseqty').val(inhouse_qty);

                    $('#receivedinstock_orignal').val(instock_qty);
                    $('#receivedinhouse_orignal').val(inhouse_qty);

                    $('#grn_brand_id').val(brand_id);
                    $('#grn_product_id').val(product_id);

                    $("#editgrnmodal").modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                } else {
                    swal({
                        title: "Warning",
                        text: 'This GRN list successfully delivered, You are not able to change/update again!',
                        type: "warning",
                        confirmButtonText: 'OK!'
                    });
                }
            }

            function update() {
                if ($('#grneditid').val()) {
                    swal({
                        title: "Are you sure?",
                        text: "You want to change GRN!",
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
                                title: 'GRN Updated!!',
                                //text: 'Order status changed!',
                                type: 'success'
                            }, function() {
                                $.ajax({
                                    type: "POST",
                                    url: "purchaseorder_controller/updategrn",
                                    data: {
                                        grn_detail_id: $('#grneditid').val(),
                                        grn_unit_price: $('#unitprice').val(),
                                        grn_qty_received: $('#receivedqty').val(),
                                        grn_qty_instock: $('#receivedinstockqty').val(),
                                        grn_qty_inhouse: $('#receivedinhouseqty').val(),
                                        instock_orignal: $('#receivedinstock_orignal').val(),
                                        inhouse_orignal: $('#receivedinhouse_orignal').val(),
                                        purchaseorder_id: $('#selectorder option:selected').val(),
                                        grn_brand_id: $('#grn_brand_id').val(),
                                        grn_product_id: $('#grn_product_id').val()
                                    },
                                    success: function(data) {

                                        var result = data.split("|");
                                        if (result[0] === "success") {
                                            toastr.success('Grn updated!', 'Done!');
                                            location.reload();
                                        } else {
                                            swal({
                                                title: "Error",
                                                //text: result[1],
                                                type: "error",
                                                confirmButtonText: 'OK!'
                                            });
                                        }
                                    }
                                });
                            });

                        } else {
                            swal("Cancelled", "You didn't make any changes!", "error");
                            
                        }
                    });
                }
            }

        </script>