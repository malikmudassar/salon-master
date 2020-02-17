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
                                    echo 'SalonPK';
                                } ?></h3>
                            </div>
                            <div class="pull-right">
                                <h4 >GRN # <br>
                                    <strong id="grnnumber"><?php echo $grn_details[0]['grn_id']; ?></strong>
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
                                    </address>
                                </div>
                                <div class="pull-right m-t-10">
                                    <p><strong>Date: </strong> <?php echo $grn_details[0]['grn_date_print']; ?></p>
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
                                                <th >#</th>
                                                <th>For Branch</th>
                                                <th>Brand</th>
                                                <th>Item</th>
                                                <th>Batch #</th>
                                                <th>Expiry Date</th>
                                                <th>Unit Price</th>
                                                <th >Received Qty</th>
                                                
                                                <th>Total <span >GRN Value</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $subtotal = 0; $recieved=0; $ordered=0; $recieving_now=0;
                                            if (isset($grn_details)) {
                                                $x = 1;
                                                foreach ($grn_details as $product) {
                                                    $subtotal = $subtotal + ($product['grn_unit_price'] * $product['grn_qty_received']);
                                                    $recieved+=$product['grn_qty_received']; 
                                                    //$ordered= $ordered + Intval($product['product_qty']); 
                                                    ?>
                                                    <tr>
                                                        <td ><?php echo $x; ?></td>
                                                        <td><?php echo $product['business_name']; ?></td>
                                                        <td style="display:none"><?php echo $product['grn_product_id']; ?></td>
                                                        <td style="display:none"><?php echo $product['brand_id']; ?></td>
                                                        <td style="display:none"><?php echo $product['business_id']; ?></td>
                                                        <td><?php echo $product['business_brand_name']; ?></td>                                                        
                                                        <td><?php echo $product['product']; ?></td>
                                                        <td><?php echo $product['grn_batch_number']; ?></td>
                                                        <td><?php echo $product['expiry_date']; ?></td>
                                                        <td><?php echo $product['grn_unit_price']; ?></td>
                                                        
                                                        <td class="text-custom" style="font-weight: bold;">
                                                            <?php echo $product['grn_qty_received'];?>
                                                        </td>
                                                        <td>Rs.<span class="grn_value"><?php echo $product['grn_qty_received'] * $product['grn_unit_price']; ?></span></td>
                                                        
                                                    </tr>
                                                    <?php $x++;
                                                } ?>
                                                    <tr>
                                                        <td></td><td colspan="5"><td ></td>
                                                        <td><strong><?php echo $recieved;?></strong></td>
                                                        <td><strong><?php echo $subtotal;?></strong></td>
                                                        
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
                                
                                <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light" id="btnprint" ><i class="fa fa-print"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- end row -->

        