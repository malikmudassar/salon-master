        <div class="wrapper">
            <div class="container">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn-group pull-right m-t-15">
                            <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Taxes <span class="m-l-5"><i class="fa fa-cog"></i></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="javascript:void(0);" onclick="enabletaxes('yes');">Enable Taxes</a></li>
                                <li><a href="javascript:void(0);" onclick="enabletaxes('no');">Disable Taxes</a></li>
                                
                            </ul>
                        </div>
                        <h4 class="page-title">Invoice</h4>
                    </div>
                    <?php if(isset($balance)){ if(sizeof($balance)>0){?>
                    <div class="row hidden-print" >
                        <div class="col-sm-12" >
                            <div class="alert alert-danger">
                                <h3 >
                                    There are BALANCES pending for  : 
                                    <?php foreach($balance as $b){ ?>
                                        <?php if($b['invoice_type']=="service"){ ?>
                                            <a class="btn btn-danger waves-effect waves-light m-l-5 m-b-5 btn-sm"  href="<?php echo base_url().'open_recovery_invoice/'.$b['id_invoice'].'/'.$b['visit_id']; ?>">Rs. <?php echo number_format($b['totalbalance']);?></a>
                                        <?php } else {?>
                                            <a class="btn btn-danger waves-effect waves-light m-l-5 m-b-5 btn-sm"  href="<?php echo base_url().'open_recovery_order_invoice/'.$b['id_invoice'].'/'.$b['visit_id']; ?>">Rs. <?php echo number_format($b['totalbalance']);?></a>
                                        <?php } ?>
                                    <?php } ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <?php } }?>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <h4>Invoice</h4>
                            </div> -->
                            <div class="panel-body">
                                <div class="clearfix">
                                    <div class="pull-left">
                                        <h3 class="logo invoice-logo"><?php if(isset($business)){ echo "<img src='".base_url().'assets/images/business/'.$business[0]['business_logo']."' alt='".$business[0]['business_name']."' />";} else {echo 'SalonPK';}?></h3>
                                        
                                    </div>
                                    <div class="pull-right">
                                        <h4>Invoice # <br>
                                            <strong id="invoicenumber"><?php echo  date("Y").'-'.date("m").'-'; if(isset($invoiceno)){ echo sprintf("%04s",$invoiceno[0]['id_invoice']+1);}else{echo '00001';} ?></strong>
                                        </h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="pull-left m-t-10">
                                            <input name="orderid" id="orderid"  type="hidden" value="<?php echo $order[0]['id_customer_order']; ?>"/>
                                            <input name="customerid" id="customerid" type="hidden"  value="<?php echo $order[0]['id_customers']; ?>"/>
                                            <input name="customername" id="customername" type="hidden"  value="<?php echo $order[0]['customer_name']; ?>">
                                            <input name="customercell" id="customercell" type="hidden"  value="<?php echo $order[0]['customer_cell']; ?>">
                                                                                        
                                            <input name="txtinvoiceid" id="txtinvoiceid" type="hidden"  value=""/>
                                            
                                            <input name="loyaltypoints" id="loyaltypoints"  type="hidden" value="<?php if(isset($customer_points)&& sizeof($customer_points)>0){ echo $customer_points[0]['loyalty_points']; } else {echo 0;}?>"/>
                                            <input name="loyaltyused" id="loyaltyused" type="hidden"  value="0"/>
                                                                                        
                                            <input name="loyaltyrate" id="loyaltyrate"  type="hidden" value="<?php echo $business[0]['l_point_discount']; ?>"/>
                                            <input name="loyaltyvalue" id="loyaltyvalue" type="hidden"  value="<?php echo $business[0]['l_point_value']; ?>"/>
                                            <input name="loyaltyenabled" id="loyaltyenabled"  type="hidden" value="<?php echo $business[0]['r_loyalty_enable']; ?>"/>
                                            <input name="sloyaltyenabled" id="sloyaltyenabled"  type="hidden" value="<?php echo $business[0]['s_loyalty']; ?>"/>
                                            <input name="rloyaltyenabled" id="rloyaltyenabled" type="hidden" value="<?php echo $business[0]['r_loyalty_enable']; ?>"/>
                                            <input name="loyaltymode" id="loyaltymode" type="hidden"  value="<?php echo $business[0]['loyalty_mode']; ?>"/>
                                            
                                            <input name="customeradvance" id="customeradvance" type="hidden"  value="<?php if(isset($customer_points)&& sizeof($customer_points)>0){echo $customer_points[0]['retained'];} else { echo 0;} ?>"/>
                                            <input name="retainedused" id="retainedused"  type="hidden" value="No"/>
                                            <input name="retainedamountused" id="retainedamountused" type="hidden" value="0"/>
                                            <input name="remainingretained" id="remainingretained" type="hidden"  value="<?php if(isset($customer_points)&& sizeof($customer_points)>0){echo $customer_points[0]['retained']; } else {echo 0;}?>"/>
                                            <input name="discount_pw" id="discount_pw" type="hidden" value="<?php if(isset($business[0]['discount_pw'])){ echo $business[0]['discount_pw'];}else{echo "Y";} ?>" >
                                            
                                            <address>
                                              <strong><?php echo $order[0]['customer_name']; ?></strong><br>
                                              <?php echo $order[0]['customer_address']; ?><br>
                                              <?php echo $order[0]['customer_email']; ?><br>
                                              <abbr title="Phone">P:</abbr> <?php 
                                                    if( $this->session->userdata('hide_cell') && $this->session->userdata('hide_cell') == "No"){ 
                                                        echo $order[0]['customer_cell']; 
                                                    } 
                                              ?>
                                              </address>
                                        </div>
                                        <div class="pull-right m-t-10">
                                            <p><strong>Invoice Date: </strong> <span id="invoice_date"><?php echo date('Y-m-d H:i:s'); ?></span></p>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->

                             
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table m-t-10" id="tblproducts">
                                                <thead>
                                                    <tr>
                                                        <th class="hidden-print">#</th>
                                                        <th class="hidden-print">Brand</th>
                                                        <th>Item</th>
                                                        <th class="hidden-print">Batch</th>
                                                        <th class="hidden-print">Sold by</th>
                                                        <th>Qty.</th>
                                                        <th class="hidden-print">Unit Price</th>
                                                        <th class="hidden-print">Discount(Rs)</th>
                                                        <th class="hidden-print">Discount(%)</th>
                                                        <th>Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $subtotal=0; if(isset($products)){
                                                        $x=1; 
                                                        foreach($products as $product){
                                                            $subtotal=$subtotal+($product['price']*$product['qty'])
                                                        ?>
                                                        <tr id="idtr">
                                                            <td class="hidden-print"><input type="hidden" id="product_id" name="product_id" value="<?php echo $product['id_business_products'];?>"><?php echo $x;?></td>
                                                            <td class="hidden-print"><?php echo $product['business_brand_name']; ?></td>
                                                            <td><?php echo $product['product'].' '.$product['category']; ?></td>
                                                            <td class="hidden-print">
                                                                <input type="hidden" id="batch_id" name="batch_id" value="<?php echo $product['batch_id'];?>">
                                                                <input type="hidden" id="batch" name="batch" value="<?php echo $product['batch'];?>">
                                                                <?php echo $product['batch']; ?>
                                                            </td>
                                                            <td class="hidden-print"><?php echo $product['staff_name']; ?></td>
                                                            <td><?php echo $product['qty']; ?></td>
                                                            <td class="hidden-print"><?php echo $product['price']; ?></td>
                                                            <td class="hidden-print">
                                                                <input readonly type="text" onclick="single_discount_pass(<?php echo $product['product_id']; ?>);" onkeyup="discount_by_product(this.value, <?php echo $product['product_id']; ?>);" class="numeric discount_by_product" name="discount_by_product" id="discount_by_product<?php echo $product['product_id']; ?>" style="width: 80px; border: none;" value="0">
                                                            </td>
                                                            <td class="hidden-print">
                                                                <input readonly onclick="single_discount_pass('<?php echo $product['product_id']; ?>');" style="border:none; width: 40px;" onkeyup="javascript:perc_discount_product(this.value, '<?php echo $product['product_id']; ?>');" class="numeric perc_discount_product" type="text" name="perc_discount_product" id="perc_discount_product<?php echo $product['product_id']; ?>" placeholder="0"  />
                                                            </td>
                                                            <td >Rs.<span class="combat" id="unitcost<?php echo $product['product_id']; ?>"><?php echo $product['qty'] * $product['price']; ?></span><input type="hidden" name="orignal_product_price" id="orignal_product_price<?php echo $product['product_id']; ?>" value="<?php echo $product['qty'] * $product['price']; ?>"></td>
                                                        </tr>
                                                        <?php $x++;}} ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6 hidden-sm hidden-xs">
                                        <div class="clearfix m-t-40">
                                            <h5 class="text-inverse font-600">Remarks:</h5>
                                            <textarea id="txtremarks" class="form-control" ></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12 col-md-offset-3">
                                        <p class="text-right"><b>Taxable-total: </b>   Rs. <input id="txt_org_subtotal" class="form-inline" readonly="readonly" style="width: 80px; border: none;" value='<?php echo number_format((float)$subtotal, 2, '.', '');?>'></p>
                                        <p class="text-right"><b>After Product Discount: </b>   Rs. <input id="txtsubtotal" class="form-inline" readonly="readonly" style="width: 80px; border: none;" value='<?php echo number_format((float)$subtotal, 2, '.', '');?>'></p>
                                        
                                        <p class="text-right">Discount %: <input readonly class="numeric" onchange="calcdiscount_perc();" id="discount_in_percent" class="form-inline " style="width: 80px; border: none;" value="0"/></p>
                                        <p class="text-right">Discount <span id="txtloyalty"></span> Rs.: <input readonly class="numeric"  id="txtdiscount" class="form-inline " style="width: 80px; border: none;" value="0"/></p>
                                        
                                        <p class="text-right">Other Charges Rs.: <input class="numeric" onchange="updateothercharges()" id="txtothercharges" class="form-inline " style="width: 80px; border: none;" value="0"/></p>
                                        <p class="text-right text-danger" id="cctip" style="display:none;">C-Card Tip Rs.: <input class="numeric" onchange="updateothercharges()" id="txtcctip" name="cctip" class="form-inline " style="width: 80px; border: none;" value="0"/></p>
                                        
                                        <p class="text-right">Gross Total:   Rs. <input id="txtgross" readonly="readonly" class="form-inline " style="width: 80px; border: none;"/></p>
                                        <div class="m-t-10 m-b-10" id="divtaxes" style="display:none">
                                        <?php if(isset($taxes)){$x=0;foreach ($taxes as $tax) {?>
                                            <p class="text-right"><span id="txttaxname<?php echo $x; ?>" ><?php echo $tax['tax_name'].' '; ?></span><input class="numeric" class="taxperc" style="width: 20px; border: none;" readonly="readonly" id="taxperc<?php echo $x;?>" value="<?php if(isset($tax['tax_percentage']) ||$tax['tax_percentage']!=""){ echo $tax['tax_percentage'];}?>">% :  Rs. <input class="tax" readonly="readonly" class="form-inline " style="width: 80px; border: none;" value="0"/></p>
                                        <?php $x++;}}?>
                                        </div>
                                        
                                        <div class="m-t-10 m-b-10" id="divcccharge" style="display:none">

                                            <p class="text-right">
                                                <span >CC Fee @ <?php echo $business[0]['cc_charge'].' '; ?>%</span> :  Rs. 
                                                <input class="cccharge" id="txtcc_charge" name="txtcc_charge" readonly="readonly" class="form-inline " style="width: 80px; border: none;" value="0" />
                                            </p>
                                            
                                        </div>
                                        <input id="cc_charge" type="hidden" value="<?php echo $business[0]['cc_charge'];?>">
                                        <p class="text-right">Total Payable Amount:   Rs. <input id="txttotalpayable" readonly="readonly" class="form-inline " style="width: 80px; border: none;"/></p>
                                        <hr>
                                        
                                        <h3 class="text-right text-success">  Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly" id="grandtotal"  name="grandtotal"/></h3>
                                        <h4 class="text-right">Paying Now Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" onchange="updatetotal();" onclick="$(this).select();" id="paid"  name="paid" value="0"/></h4>
                                        <h4 id="payingcash" class="text-right" style="display:none;" >Cash Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" onchange="updatepaying();" onclick="$(this).select();" id="cashpaid"  name="cashpaid" value="0"/></h4>
                                        <h4 id="payingcard" class="text-right" style="display:none;">Card Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" onchange="updatepayingcard();" onclick="$(this).select();" id="cardpaid"  name="cardpaid" value="0"/></h4>
                                        <h4 class="text-right text-custom">Advance Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly"  id="txtadvance"  name="txtadvance" value="0"/></h4>
                                        <h4 class="text-right text-primary"><input id="keepadv" type="checkbox" > <span>Retain?</span> Return Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly" id="returnamount"  name="returnamount" value="0"></h4>
                                        <h4 class="text-right text-danger">  Balance Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly" id="balanceamount"  name="balanceamount" value="0"></h4>
                                        <hr>
                                        <div class="text-right hidden-print">
                                            
                                            <p id="modep"><strong>Payment Mode: </strong><abbr> <span id="mode">Cash</span></abbr></p>
                                            <p id="ccp" style="display:none;"><abbr title="Bank Instrument"> <strong>C-Card#: </strong><abbr> <input class="numeric" style="width: 120px; border: none;" id="ccno"  name="ccno"/></abbr></p>
                                            <p id="checkp" style="display:none;"><abbr title="Bank Instrument"> <strong>Instrument#: </strong><input class="numeric" style="width: 120px; border: none;" id="checkno"  name="checkno"/></abbr></p>
                                            <p id="voucherp" style="display:none;">
                                                <abbr title="Voucher"> <strong>Voucher#: C</strong> 
                                                <input class="numeric" style="width: 100px; border: none;" id="voucherno" name="voucherno">
                                                <button class="btn btn-success btn-xs" onclick="validateVouchers();">Verify</button>
                                                </abbr>
                                            </p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="hidden-print">
                                    <div class="pull-left">
                                        <?php if(isset($customer_points)&& sizeof($customer_points)>0){if((float)$customer_points[0]['retained']>0){ ?>
                                        <span name="txtcustomeradvance" style="<?php if(isset($customer_points)&& sizeof($customer_points)>0){if((Float)$customer_points[0]['retained']<=0){ echo 'display:none;'; }} else {echo 'display:none';}?> font-weight: bold;" class="text-custom" id="txtcustomeradvance">Customer's Retained Amount Available: <?php if(isset($customer_points)&& sizeof($customer_points)>0){echo $customer_points[0]['retained'];}else {echo 0;} ?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        <a style='<?php if(isset($customer_points)&& sizeof($customer_points)>0){if((Float)$customer_points[0]['retained']<=0){ echo 'display:none;'; }}else{echo 'display:none';}?>' href="javascript:void(0);" onclick="usecustomeradvance();" class="btn btn-custom waves-effect waves-light" id="btncustomeradvance">Use</a>
                                        <?php } }?>
                                    </div>
                                    <div class="pull-right">
                                        <span   name="txtloyaltypoints" style="<?php if($business[0]['loyalty_enable']==='N'){ echo 'display:none;'; }?> font-weight: bold;" class="text-success" id="txtloyaltypoints">Customer's Loyalty Points: <?php if(isset($customer_points)&& sizeof($customer_points)>0){echo $customer_points[0]['loyalty_points'];}else{echo 0;} ?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        <a style='<?php if($business[0]['loyalty_enable']==='N'){ echo 'display:none;'; }?>' href="javascript:void(0);" onclick="loyaltydiscount('<?php echo $business[0]['loyalty_mode'];?>')" class="btn btn-success waves-effect waves-light" id="btnloyalty">Redeem Loyalty</a>
                                        <div class="btn-group m-r-10 dropup">
                                            <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Payment mode <span class="m-l-5"><i class="fa fa-money"></i></span></button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="javascript:void(0);" onclick="opencash();">Cash</a></li>
                                                <li><a href="javascript:void(0);" onclick="opencc();">Credit Card</a></li>
                                                <?php if($business[0]['cc_charge']>0){ ?>
                                                <li><a href="javascript:void(0);" onclick="opendc();">Debit Card</a></li>
                                                <?php } ?>
                                                <li><a href="javascript:void(0);" onclick="openbank('Check');">Check</a></li>
                                                <li><a href="javascript:void(0);" onclick="openvoucher('Voucher');">Voucher</a></li>
                                                <li><a href="javascript:void(0);" onclick="openmixed('Mixed');">Mixed</a></li>
                                            </ul>
                                        </div>
                                        <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light" id="btnprint"><i class="fa fa-print"></i></a>
                                        <a href="javascript:void(0);" onclick="createinvoice();" class="btn btn-primary disabled waves-effect waves-light" id="btnsubmit">Submit</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- end row -->
                
                <!--invoice password start-->
                <div id="invoicepass" class="modal fade in" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="invoicepass" aria-hidden="true" style="display: none;">
                    <form id="discountForm" action="<?php echo base_url('invoice_controller/discount_login'); ?>" method="POST" enctype="multipart/form-data">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
                                    <h4 class="modal-title" id="custom-width-modalLabel">Invoice Discount Password</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Remarks</label>
                                                        <input type="text" name="discount_remarks" id="discount_remarks" class="form-control" />
                                                    </div> 
                                                </div> 
                                                
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Username</label>
                                                        <input required type="text" name="discount_username" id="discount_username" class="form-control" />
                                                    </div> 
                                                </div> 
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <input required type="password" name="discount_password" id="discount_password" class="form-control" />
                                                    </div> 
                                                </div> 
                                            </div>

                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <span id="pass_message"></span>
                                        <button type="button" class="btn btn-default waves-effect modal_close" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-custom waves-effect waves-light cont">Continue</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div>
                    </form>
                </div>
                <!--invoice password end-->
                
                <!--Voucher Model-->
                <div id="voucherModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="voucherModal" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Voucher Information</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" id="voucherType">
                                        <input type="hidden" id="voucherAmount">
                                        <input type="hidden" id="voucherRemainingAmount">
                                        <input type="hidden" id="voucherRemainingServices">
                                        <div class="" id="voucherHtml">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" id="voucherModalFooter">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="button" onclick="applyVoucher();" class="btn btn-custom waves-effect waves-light">Apply</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <!--End Voucher Model-->
                
                <input type="hidden" name="uid" id="uid" />
                <input type="hidden" name="uname" id="uname" />
                <input type="hidden" name="uusername" id="uusername" />
                <input type="hidden" name="uemail" id="uemail" />
                <input type="hidden" name="ddiscount_remarks" id="ddiscount_remarks" />

                <?php include 'js_functions/order_invoice_js.php'; ?>
<script>
    var enabtax=false;
    
    $(document).ready(function(){
        
        $(".numeric").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 13 && e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                return false;
           }
        });
        
        <?php if($business[0]['tax_optional'] === 'No'){ ?>
            enabletaxes('yes');
        <?php } ?>
          
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
        
        $("#txtdiscount").change(function(){
            if($('#txtothercharges').val()===""){$('#txtothercharges').val(0);}
            var subtotalextra = parseFloat($('#txtsubtotal').val())+parseFloat($('#txtothercharges').val());
            var parcentage = (parseFloat($(this).val()) / subtotalextra) * 100;
            $('#discount_in_percent').val(parcentage.toFixed(2));
            //$("#paid").val($("#grandtotal").val());
            $("#balanceamount").val(parseFloat($("#grandtotal").val()) - parseFloat($("#paid").val()));
            updatetotal();
            
        });
        

        
            $("#discount_in_percent").on('click',function() {
                if($(this).attr("readonly")){
                    if($("#discount_pw").val()=="Y"){
                        $("#invoicepass").modal("show");
                    } else {
                        if($("#btnloyalty").hasClass('btn-success')){
                            $("#txtdiscount").attr("readonly",false);
                            $("#discount_in_percent").attr("readonly",false);
                        }
                        $(".discount_by_product").attr("readonly",false);
                        $(".perc_discount_product").attr("readonly",false);
                    }
                }
            });
            
            $("#txtdiscount").on('click',function() {
                if($(this).attr("readonly")){
                    if($("#discount_pw").val()=="Y"){
                       $("#invoicepass").modal("show");
                    } else {
                        if($("#btnloyalty").hasClass('btn-success')){
                            $("#txtdiscount").attr("readonly",false);
                            $("#discount_in_percent").attr("readonly",false);
                        }
                        $(".discount_by_product").attr("readonly",false);
                        $(".perc_discount_product").attr("readonly",false);
                    }
                }
            });
            
            $("#discount_in_percent").dblclick(function() {
                //if($(this).attr("readonly")){
                    $("#invoicepass").modal("show");
                //}
            });
            
            $("#txtdiscount").dblclick(function() {
                //if($(this).attr("readonly")){
                    $("#invoicepass").modal("show");
                //}
            });
            
            $('#discountForm').on('submit', function(e) {
            
                e.preventDefault();
        
                $.ajax({
                url: $(this).attr('action') || window.location.pathname,
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                cache: false,
                async: true,
                success: function(data) {
                    if (data != "error"){
                        //console.log(data);

                        $("#uid").val(data['id']);
                        $("#uname").val(data['name']);
                        $("#uusername").val(data['username']);
                        $("#uemail").val(data['email']);
                        $("#ddiscount_remarks").val($("#discount_remarks").val());

                        $("#discount_username").val('');
                        $("#discount_password").val('');
                        $("#discount_remarks").val('');
                        $("#txtdiscount").attr("readonly",false);
                        $("#discount_in_percent").attr("readonly",false);
                        $(".discount_by_product").attr("readonly",false);
                        $(".perc_discount_product").attr("readonly",false);

                        $("#invoicepass").modal("hide");
                    } else{
                        //$("#pass_message").text('Please provide valid username/password!');
                        //$("#pass_message").fadeOut(1000);
                    }
                },
                error: function(jXHR, textStatus, errorThrown) {
                //alert(errorThrown);
                $("#pass_message").text('Invalid username/password!');
                $("#pass_message").fadeIn(3000);
                $("#pass_message").fadeOut(3000);
                }
                });
            });
            
            
        $('#keepadv').click(function(){
            
            if(parseInt($("#returnamount").val()) <= 0){
                $(this).prop('checked',false)
            }
        });
    });   
    
       
    function updatetotal(){
        
        if($('#txtdiscount').val()===""){$('#txtdiscount').val('0');}
        if($('#txtothercharges').val()===""){$('#txtothercharges').val('0');}
        
        var grosstotal=(parseFloat($("#txtsubtotal").val()) +  parseFloat($("#txtothercharges").val()) + parseFloat($("#txtcctip").val()) - parseFloat($("#txtdiscount").val()));
        var orggrosstotal = parseFloat($("#txt_org_subtotal").val()) +  parseFloat($("#txtothercharges").val());
        
        $("#txtgross").val(grosstotal);
        
        
        var nettax= 0;
        if(enabtax===true){
            var taxarray = [];
            $( ".tax" ).each(function(index) {
                $(this).val(orggrosstotal*parseFloat($("#taxperc"+index).val())/100);
                taxarray.push($(this).val());
            });
            for(x=0; x<taxarray.length;x++){
                nettax=nettax + parseFloat(taxarray[x]);
            }
        }
        
        //$("#grandtotal").val((grosstotal + nettax) - parseFloat($("#txtadvance").val()));
        $("#txttotalpayable").val(grosstotal + nettax + parseFloat($("#txtcc_charge").val()));
        $("#grandtotal").val((grosstotal + nettax + parseFloat($("#txtcc_charge").val())) - (parseFloat($("#txtadvance").val())));
        
        if($("#paid").val() === "0" || $("#paid").val() === ""){
            $("#balanceamount").val(grosstotal + nettax);
            $("#paid").val(0);
        } else {
            $("#balanceamount").val(grosstotal - parseFloat($("#paid").val()));
        }
        
         if(parseInt($('#paid').val()) > parseInt($('#grandtotal').val())){
            $('#returnamount').val(parseInt($('#paid').val()) - parseInt($('#grandtotal').val()));
            $("#balanceamount").val(0);
        } else{
            $("#returnamount").val(0);
            $('#balanceamount').val(parseInt($('#grandtotal').val()) - parseInt($('#paid').val()));
        }
        $('#btnsubmit').removeClass('disabled');
    }
    

    
    function createinvoice(){
        if($('#paid').val() === ''){
            return false;
        }
        
        
        if (parseInt($('#grandtotal').val()) <= 0 && parseInt($('#paid').val()) > 0){
            swal({
                title: 'Please Wait . . .',
                text: "Calculating Amounts!",
                type: 'info',
                showCancelButton: false,
                confirmButtonColor: '#ff5b5b !important',
                confirmButtonText: 'Ok'
            });
            return false;
        }
        
        
        if(parseInt($('#paid').val()) === 0){
            swal({
                title: '0 Paid Now?',
                text: "Total Amount will be Balanced!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff5b5b !important',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes'
            }, function(e) {
                
                if(e===false){
                    return false;
                } else if (e===true){
                    create_new_invoice();
                }
            });
        } else if (parseInt($('#paid').val()) > 0){
            create_new_invoice();   
        }
    }

    function create_new_invoice(){
        
        var totalProducts = $('input[name=discount_by_product]').length;
        
        var product_discount = [];
        $('input[name=discount_by_product]').each(function(x) {
            var discount = $(this).val() === "" ? 0 : $(this).val();
            product_discount.push(parseFloat(discount));
        });
        
        var discounted_price = [];
        $('input[name=orignal_product_price]').each(function(x) {
            discounted_price.push((parseFloat($(this).val()) - parseFloat(product_discount[x])));
        });
        
        var product_ids = [];
        $('input[name=product_id]').each(function(x) {
            product_ids.push($(this).val());
        });
        
        var batch_ids = [];
        $('input[name=batch_id]').each(function(x) {
            batch_ids.push($(this).val());
        });
        
        var batches = [];
        $('input[name=batch]').each(function(x) {
            batches.push($(this).val());
        });
        
        var taxtotal=0;
        var instrument_number="";
        
        if($("#mode").html()==="Card"){
            if($("#ccno").val()===""){ toastr.warning('Enter Card Number!', 'Instrument number is mandatory'); return false;}else{instrument_number=$("#ccno").val();}
        } else if($("#mode").html()==="Check" || $("#mode").html()==="Loyalty"){ 
            if($("#checkno").val()===""){ toastr.warning('Enter Instrument Number!', 'Instrument number is mandatory'); return false;}else{instrument_number=$("#checkno").val();}
        } else if($("#mode").html()==="Voucher"){
            if($("#voucherno").val()==="" || $("#voucherno").val()==="0"){
                toastr.warning('Enter Voucher Number!', 'Voucher number is mandatory'); return false;
            } else{
                instrument_number='C'+$("#voucherno").val();
            }
        } else {
            instrument_number="";
        }
        
        if(enabtax===true){
            var taxarray = [];
            $( ".tax" ).each(function(index) {
                var taxname="#txttaxname"+index;
                taxarray.push({taxname: $(taxname).html(), tax: $(this).val()});
                taxtotal = taxtotal + parseFloat($(this).val());
            });
        }
        
        $('#btnsubmit').addClass('disabled');
        $('#btnsubmit').html('<i class="fa fa-spin fa-spinner"></i> Please wait');
    
        $.ajax({
            type: 'POST',
            url: 'invoice_controller/updateorderinvoice',
            data: {
                orderid: $("#orderid").val(),
                product_ids: product_ids,
                batch_ids: batch_ids,
                batches: batches,
                invoicenumber:$("#invoicenumber").html(),
                invoicedate:$("#invoice_date").html(),
                customerid:$("#customerid").val(),
                customercell:$("#customercell").val(),
                subtotal:$("#txtsubtotal").val(),
                discount:$("#txtdiscount").val(),
                discount_perc: $('#discount_in_percent').val(),
                
                loyaltyenabled:$("#loyaltyenabled").val(),
                sloyaltyenabled:$("#sloyaltyenabled").val(),
                rloyaltyenabled:$("#rloyaltyenabled").val(),
                loyaltyused:$("#loyaltyused").val(),
                loyaltyrate:$("#loyaltyrate").val(),
                loyaltyvalue:$("#loyaltyvalue").val(),
                
                grosstotal:$("#txtgross").val(),
                paid:parseInt($('#paid').val()) - parseInt($('#returnamount').val()),
                cashpaid: parseInt($("#cashpaid").val()),
                cardpaid: parseInt($("#cardpaid").val()),                
                grandtotal:$("#grandtotal").val(),
                totalpayable:$("#txttotalpayable").val(),
                
                taxes:taxarray, 
                taxtotal:taxtotal,
                mode: $("#mode").html(),
                instrument_number: instrument_number,
                balance: $('#balanceamount').val(),
                
                uid: $('#uid').val(),
                uname: $('#uname').val(),
                uusername: $('#uusername').val(),
                uemail: $('#uemail').val(),
                
                discount_remarks: $("#ddiscount_remarks").val(),
                returnamount: $('#returnamount').val(),
                product_discount: product_discount,
                discounted_price: discounted_price,
                advance_amount:$('#txtadvance').val(),                
                other_charges: $('#txtothercharges').val(),
                customer_advance: $("#keepadv").prop('checked'),
                retained_used: $("#retainedused").val(),
                retained_amount_used: $("#retainedamountused").val(),
                remaining_retained: $("#remainingretained").val(),
                cctip: $("#txtcctip").val(),
                loyalty_sms: '<?php echo $business[0]['loyalty_sms'];?>',
                cc_charge: $("#txtcc_charge").val(),
                remarks: $("#txtremarks").val()
            },
            success: function(data) {
                var result = data.split("|");
                if (result[0] === "success") {
                    $("#txtinvoiceid").val(result[1]);
                    toastr.success('New Invoice Added!', 'Print the invoice');
                     if($("#mode").html() === "Voucher"){
                        if($("#voucherno").val() !== ""){
                            updateVoucher();
                        }
                    }
                    window.location.href = '<?php echo base_url(); ?>existingorderinvoice/' + result[1];
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
        
        $("#txtdiscount").attr("readonly",true);
        $("#discount_in_percent").attr("readonly",true);
        $(".discount_by_product").attr("readonly",true);
        $(".perc_discount_product").attr("readonly",true);
        
        
    }
    


    function sendsms(){
        $.ajax({
           type: 'POST',
           url: "<?php echo base_url() . 'sms_controller/send_sms'; ?>",
           data:{message: $('#msg').val(), phone:$('#phone').val()},
           dataType: "xml",
           cache: false,
           async: true,
           success: function(data) {
               alert(data);
           }
       });
   }


</script>