        <div class="wrapper">
            <div class="container">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn-group pull-right m-t-15  m-r-10 ">
                            <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light hidden" data-toggle="dropdown" aria-expanded="false">Order status <span class="m-l-5"><i class="fa fa-first-order" aria-hidden="true"></i></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="javascript:void(0);" onclick="pending();">Pending</a></li>
                                <li><a href="javascript:void(0);" onclick="process();">Processing</a></li>
                                <li><a href="javascript:void(0);" onclick="deliver();">Delivered</a></li>
                            </ul>
                         </div>
                        <h4 class="page-title">Purchase Order</h4>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">

                            <div class="panel-body">
                                <div class="clearfix">
                                    <div class="pull-left">
                                        <h3 class="logo invoice-logo"><?php if(isset($business)){ echo "<img src='".base_url().'assets/images/business/'.$business[0]['business_logo']."' alt='".$business[0]['business_name']."' />";} else {echo 'SalonPK';}?></h3>
                                    </div>
                                    <div class="pull-right">
                                        <h4>Purchase Order # <br>
                                            <strong id="invoicenumber"><?php echo $purchaseorder[0]['purchase_order_number']; ?></strong>
                                        </h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="pull-left m-t-30">
                                            <address>
                                              <strong>Supplier </strong>: <?php echo $purchaseorder[0]['supplier_name']; ?><br>
                                              </address>
                                        </div>
                                        <div class="pull-right m-t-30">
                                            <p><strong>Date: </strong> <?php echo date('d-m-Y'); ?></p>
                                            <p id="modep"><strong>Order status: </strong> <span id="mode"><?php echo $purchaseorder[0]['status']; ?></span></p>
                                            <!--<p id="modep"><strong>Payment mode: </strong> <span id="mode">Cash</span></p>-->
                                            <p id="ccp" style="display:none;"><strong>C-Card #: </strong> <input class="numeric" style="width: 120px; border: none;" id="ccno"  name="ccno"/></p>
                                            <p id="checkp" style="display:none;"><strong>Check #: </strong> <input style="width: 120px; border: none;" id="checkno"  name="checkno"/></p>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="m-h-50"></div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table m-t-30" id="tblproducts">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Brand</th>
                                                        <th>Item</th>
                                                        <th>Qty.</th>
                                                        <th>Unit Price</th>
                                                        <th>Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $subtotal=0; if(isset($purchaseorder_detail)){
                                                        $x=1; 
                                                        foreach($purchaseorder_detail as $product){
                                                            $subtotal=$subtotal+($product['product_purchase_price']*$product['product_qty'])
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $x;?></td>
                                                            <td><?php echo $product['brand_name']; ?></td>
                                                            <td><?php echo $product['product_name']; ?></td>
                                                            <td><?php echo $product['product_qty']; ?></td>
                                                            <td><?php echo $product['product_purchase_price']; ?></td>
                                                            <td>Rs.<span id="unitcost"><?php echo $product['product_qty'] * $product['product_purchase_price']; ?> </span></td>
                                                        </tr>
                                                        <?php $x++;}} ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                                        <div class="clearfix m-t-40 hidden">
                                            <h5 class="small text-inverse font-600">PAYMENT TERMS AND POLICIES</h5>

                                            <small>
                                                <?php echo $business[0]['payment_terms'];?>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-6 col-md-offset-3">
                                        <p class="text-right "><b>Total:</b>   Rs. <input id="txtsubtotal" class="form-inline" readonly="readonly" style="width: 80px; border: none;" value='<?php echo number_format((float)$subtotal, 2, '.', '');?>'></p>
                                        <p class="text-right hidden">Discount:   Rs. <input class="numeric" id="txtdiscount" onchange="updatetotal();" class="form-inline " style="width: 80px; border: none;" value="0"/></p>
                                        <p class="text-right hidden">Gross Total:   Rs. <input id="txtgross" readonly="readonly" class="form-inline " style="width: 80px; border: none;"/></p>
                                        <div class="m-t-10 m-b-10 hidden" id="divtaxes" style="display:none">
                                        <?php if(isset($taxes)){$x=0;foreach ($taxes as $tax) {?>
                                            <p class="text-right hidden"><span id="txttaxname<?php echo $x; ?>" ><?php echo $tax['tax_name'].' '; ?></span><input class="numeric" class="taxperc" style="width: 20px; border: none;" readonly="readonly" id="taxperc<?php echo $x;?>" value="<?php if(isset($tax['tax_percentage']) ||$tax['tax_percentage']!=""){ echo $tax['tax_percentage'];}?>">% :  Rs. <input class="tax" readonly="readonly" class="form-inline " style="width: 80px; border: none;" value="0"/></p>
                                        <?php $x++;}}?>
                                        </div>
                                        <hr>
                                        <h3 class="text-right hidden">  Rs. <input class="numeric" style="width: 120px; border: none;" readonly="readonly" id="grandtotal"  name="grandtotal"/></h3>
                                        <h4 class="text-right hidden" >  Paid Rs. <input class="numeric" style="width: 120px; border: none;" onchange="updatetotal();" id="paid"  name="paid" value="0"/></h4>
                                        <h4 class="text-right hidden" style="color: red;">  Balance Rs. <input class="numeric" style="width: 120px; border: none;" readonly="readonly" id="balanceamount"  name="balanceamount" value="0"/></h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="hidden-print">
                                    <div class="pull-right">
                                        <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light" id="btnprint" ><i class="fa fa-print"></i></a>
                                        <a href="javascript:void(0);" onclick="createinvoice();" class="btn btn-primary waves-effect waves-light hidden" id="btnsubmit">Submit</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- end row -->

<script>
    var enabtax=false;
    
    $(document).ready(function(){
         $(".numeric").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
               return false;
           }
          });
        updatetotal();
        
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


    



    function process(){
        
        $("#mode").html('Processing');
    }
    function pending(){
        
        $("#mode").html('Pending');
    }
    function deliver(){
        
        $("#mode").html('Delivered');
    }
</script>