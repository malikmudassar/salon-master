<div class="wrapper" style="margin-top:60px;">
    <div class="container" style="width: 100% !important">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15 clear-fix">
                    
                    <!--<button id="btnGiftVoucher" onclick="open_gift_voucher();" class="btn btn-pink waves-effect waves-light">Voucher</button>-->
                    <?php  if($this->session->userdata('role')!=='Sh-Users'){?>
                    <form style="display:inline-block" id="serviceform" method="Post" action="<?php echo base_url();?>pos_services_view">
                     <?php } else { ?>
                    <form style="display:inline-block" id="serviceform" method="Post" action="<?php echo base_url();?>sh_pos_services_view">
                    <?php } ?>
                        <input id="servicecustomer" name="customerid" type="hidden"/>
                        <button type="button" onclick="submitserviceform();" class="btn btn-warning waves-effect waves-light">Services</button>
                    </form>
                        <?php  if($this->session->userdata('role')!=='Sh-Users'){?>
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light m-l-10" data-toggle="dropdown" aria-expanded="false">Taxes <span class="m-l-5"><i class="fa fa-cog"></i></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:void(0);" onclick="enabletaxes('yes');">Enable Taxes</a></li>
                            <li><a href="javascript:void(0);" onclick="enabletaxes('no');">Disable Taxes</a></li>

                        </ul>
                    </div>
                        <?php } ?>
                </div>
                <?php if (isset($totalinvoices)){?>
                    <h4 class="page-title">Total Invoices (Retail): <span id="totalvisits" class="page-title"><?php echo $totalinvoices->invoices; ?></span></h4>
                <?php } else { ?>
                    <h4 class="page-title">Point of Sale (Retail): </h4>
                <?php } ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" id="printbill">
                <div class="card-box">
                    <div class="row">
                        <div class="col-md-12">
                             <div class="col-md-4 m-t-10">
                                <p><b>Agent ID:</b> <?php echo $userid; ?><b class="m-l-10">   Agent Name: </b> <?php echo $username; ?></p> 
                                <p><b>Customer: <label class="text-primary" id='label-customer-name'></label></b></p>
                                <p><button id="btnedit"  type="button" onclick='openupdate();' style="display:none;" class="btn btn-sm btn-pink" >Edit</button><button id="btnaccount"  type="button" onclick='openAccount();' style="display:none;" class="btn btn-sm btn-primary m-l-10" >Account</button></p>
                            </div>
                            <div class="col-md-4  m-t-10" id="CurrentActionDiv" style="border:1px solid #f7f7f7; background: #797979 ;padding:25px 10px !important"">
                            
                                <input type="hidden" id="order-id" name="order-id">
                                <input name="orderid" id="orderid"  type="hidden"/>

                                <form id="opendirectselect" action="<?php base_url('pos_services');?>" method="post"> 
                                    <input  type="hidden" id="customerid" name="customerid"  class="form-control" value="<?php if(isset($customer_id)){echo $customer_id;} else {echo "1";}?>">
                                </form>

                                <input type="hidden" class="form-control" id="order-customer-id" name="order-customer-id" value="<?php if(isset($customer_id)){echo $customer_id;} else {echo "1";}?>">
                                <input  type="hidden" id="txt-customer-name" name="txt-customer-name"  class="form-control" value="">
                                <input name="customername" id="customername" type="hidden" value="">
                                <input name="customercell" id="customercell" type="hidden" value="">
                                <input name="customeremail" id="customeremail" type="hidden" value="">
                                <input name="customeraddress" id="customeraddress" type="hidden" value="">

                                <input name="loyaltyused" id="loyaltyused" type="hidden"  value="0"/>
                                <input name="loyaltyrate" id="loyaltyrate"  type="hidden" value="<?php echo $business[0]['l_point_discount']; ?>"/>
                                <input name="loyaltyvalue" id="loyaltyvalue" type="hidden"  value="<?php echo $business[0]['l_point_value']; ?>"/>
                                <input name="loyaltyenabled" id="loyaltyenabled"  type="hidden" value="<?php echo $business[0]['loyalty_enable']; ?>"/>
                                <input name="rloyaltyenabled" id="rloyaltyenabled" type="hidden" value="<?php echo $business[0]['r_loyalty_enable']; ?>"/>
                                <input name="sloyaltyenabled" id="sloyaltyenabled"  type="hidden" value="<?php echo $business[0]['s_loyalty']; ?>"/>
                                <input name="loyaltymode" id="loyaltymode" type="hidden"  value="<?php echo $business[0]['loyalty_mode']; ?>"/>

                                <input name="customeradvance" id="customeradvance" type="hidden"  value="0"/>
                                <input name="retainedused" id="retainedused"  type="hidden" value="No"/>
                                <input name="retainedamountused" id="retainedamountused" type="hidden" value="0"/>
                                <input name="remainingretained" id="remainingretained" type="hidden"  value="0"/>
                                
                                <i id="CurrentActionIcon" style="font-size:75px; color:#fff; " class="ti-spray"></i>
                                <span id="CurrentAction" style="font-size:21px; color:#fff; padding-left: 20px;" >Retail Desk (Search Customer) . . . </span>
                                
                                
                            </div>
                            <div class="col-md-4 m-t-10" style="text-align: right;">

                                <p><strong>Invoice Date: </strong> <span id="invoice_date"><?php echo date('Y-m-d H:i:s'); ?></span></p>
                                
                                <form id="openorderform" action="<?php base_url('pos_view');?>" method="post"> 
                                    <div class="form-group row" style="float:right; display:inline-block">
                                        <div class="col-md-10 col-sm-10">
                                            <select id="ordersonhold" onchange="$('#id_customer_order').val($(this).val());" class="form-control" style="width: 250px;">
                                                <option>Orders on hold</option>
                                                <?php foreach($orders as $order){?>
                                                <option customerid="<?php echo $order['id_customers'];?>" value="<?php echo $order['id_customer_order']; ?>"><?php echo $order['mDate']; ?> <?php echo $order['customer_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <input type ="hidden" id="id_customer_order" name="id_customer_order">
                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                            <button type="button" onclick="submitopenorder();"  class="btn btn-primary ">go</button>
                                        </div>
                                    </div>
                                </form>
                                <form id="openfresh" action="<?php base_url('pos_view');?>" method="post"> 
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <!--Search-->
                    <div class="row m-t-10" style="border:1px solid #e3e3e3; border-radius: 4px; background:#fcfcfc;">
                        <div class="col-md-12">
                            <div class="row m-t-10" >        
                                <div class="col-md-2 col-sm-10">
                                    <div class="form-group ">
                                        <input  type="text" id="txt-customer-search"  <?php if(isset($id_customer_order) || isset($id_customer)){echo 'disabled="disabled"';} ?> name="txt-customer-search" onchange='on_customer_change();' placeholder="Change Customer"  class="form-control" style='min-width:250px;' >
                                    </div>
                                </div>
                                
                                <div class="col-md-1 col-sm-2">
                                    <button id="btnaddcustomer"  <?php if(isset($id_customer_order) || isset($id_customer)){echo 'disabled="disabled"';} ?> type="button" onclick="openaddnew();" class="btn btn-pink btn-sm m-t-5" >Add</button>
                                </div>
                                    
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group" >
                                        <input type="text" class='form-control' onchange="on_product_change();" id="retail-order-products" name="retail-order-products"  placeholder="Select Products" >
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-2">
                                    <div class="checkbox checkbox-success">
                                        <input onchange="retail_getproducts();" id="checkboxall" type="checkbox">
                                        <label for="checkboxall">
                                            Show All Stores
                                        </label>
                                    </div>
                                </div>   
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group ">
                                        <select class='form-control' onchange="on_staff_change();"  placeholder="Select Staff" id="retail-order-staff" name="retail-order-staff[]" >
                                            <option value="">Sold By . . .</option>
                                            <?php foreach ($staff_list as $staff) { ?>
                                            <option value="<?php echo $staff->id_staff; ?>"><?php echo $staff->staff_fullname; ?></option>
                                            <?php } ?>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-4" style="text-align:right; "><label for="order-customer-qty">Qty.</label></div>
                                <div class="col-md-1 col-sm-8">
                                    <div class="form-group " >
                                        <input style="min-width:50px; max-width:90px;" class="form-control numeric" type="numeric" id="order-customer-qty" name="order-customer-qty" value="1" >
                                    </div>
                                </div>
                                    
                                <div class="col-md-1 col-sm-12">
                                    <button onclick='order_mode(); addOrderRows(); $(".discount").show(); $(".discountperc").show(); $("#retail-order-products").select2("open"); updatetotal();'  type='button' id="btn-add" class='btn btn-sm btn-purple waves-effect m-l-10 m-t-5'>Add Product <i class='ti-arrow-circle-down'></i></button>
                                </div>

                                <div style="display:block" class="form-group ">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!--end row-->
                    <div class="row m-t-10">
                        <div class="col-sm-12" id="customerbalancediv" style="display:none;">
                            <div class="alert alert-danger">
                                <h3 >
                                    There are BALANCES pending for a SUM of : Rs. <span id="customerbalance"></span>
                                    <!--<a class="btn btn-danger waves-effect waves-light m-b-5 btn-sm"  href="#">Create Recovery Invoices?</a>-->
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="row m-t-30" style="min-height: 150px;">
                        <div id='order-product-list' class='col-md-12'>
                            <div class="table-responsive">
                                <table class="table" id="ordertbl">
                                    <thead>
                                        <tr>
                                            <th style="display:none;">Customer ID</th>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th>Category</th>
                                            <th>Batch</th>
                                            <th style="display:none;">Staff ID</th>
                                            <th>Sold By</th>
                                            <th>Qty.</th>
                                            <th>Price</th>
                                            <th>Discount(Rs)</th>
                                            <th>Discount(%)</th>
                                            <th>Total</th>
                                            <th>Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                        <!--Table End-->
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                              <p><span class=""><strong>ShortCuts:</strong> <ul><li>F2:  Paying</li><li>Esc:  New</li><li>?: Create Order</li><li>=: Invoice</li></ul> <p>          
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <p class="text-right m-b-0"><b>Sub-total:</b>   Rs. <input id="txtsubtotal" class="form-inline" readonly="readonly" style="width: 80px; border: none;" value='0'></p>
                            <div id="invoicingdiv" style="display:none;" >
                                <p class="text-right m-b-0">Discount %: <input readonly class="numeric" onchange="calcdiscount_perc();" id="discount_in_percent" class="form-inline " style="width: 80px; border: none;" value="0"/></p>
                                <p class="text-right m-b-0">Discount <span id="txtloyalty"></span> Rs.: <input readonly class="numeric" onchange="updatetotal();"  id="txtdiscount" class="form-inline " style="width: 80px; border: none;" value="0"/></p>

                                <p class="text-right m-b-0">Other Charges Rs.: <input class="numeric" onchange="updateothercharges()" id="txtothercharges" class="form-inline " style="width: 80px; border: none;" value="0"/></p>
                                <p class="text-right text-danger m-b-0" id="cctip" style="display:none;">C-Card Tip Rs.: <input class="numeric" onchange="updateothercharges()" id="txtcctip" name="cctip" class="form-inline " style="width: 80px; border: none;" value="0"/></p>

                                <p class="text-right m-b-0">Gross Total:   Rs. <input id="txtgross" readonly="readonly" class="form-inline " style="width: 80px; border: none;"/></p>
                                <div class="m-b-0" id="divtaxes" style="display:none">
                                    <?php if (isset($taxes)) {$x = 0;foreach ($taxes as $tax) { ?>
                                        <p class="text-right"><span id="txttaxname<?php echo $x; ?>" ><?php echo $tax['tax_name'] . ' '; ?></span><input class="numeric" class="taxperc" style="width: 20px; border: none;" readonly="readonly" id="taxperc<?php echo $x; ?>" value="<?php if (isset($tax['tax_percentage']) || $tax['tax_percentage'] != "") {echo $tax['tax_percentage'];} ?>">% :  Rs. <input class="tax" readonly="readonly" class="form-inline " style="width: 80px; border: none;" value="0"/></p>
                                    <?php $x++; }} ?>
                                </div>

                                <div class="m-b-0" id="divcccharge" style="display:none">

                                    <p class="text-right">
                                        <span >CC Fee @ <?php echo $business[0]['cc_charge'] . ' '; ?>%</span> :  Rs. 
                                        <input class="cccharge" id="txtcc_charge" name="txtcc_charge" readonly="readonly" class="form-inline " style="width: 80px; border: none;" value="0" />
                                    </p>

                                </div>
                                <input id="cc_charge" type="hidden" value="<?php echo $business[0]['cc_charge']; ?>">
                                <p class="text-right">Total Payable Amount:   Rs. <input id="txttotalpayable" readonly="readonly" class="form-inline " style="width: 80px; border: none;"/></p>
                                <hr>

                                <h3 class="text-right text-success m-t-0 m-b-0">  Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly" id="grandtotal"  name="grandtotal"/></h3>
                                <h4 class="text-right m-t-0 m-b-0">Paying Now Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" onchange="updatetotal();" onclick="$(this).select();" id="paid"  name="paid" value="0"/></h4>
                                <h4 id="payingcash" class="text-right m-t-0 m-b-0" style="display:none;" >Cash Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" onchange="updatepaying();" onclick="$(this).select();" id="cashpaid"  name="cashpaid" value="0"/></h4>
                                <h4 id="payingcard" class="text-right m-t-0 m-b-0" style="display:none;">Card Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" onchange="updatepayingcard();" onclick="$(this).select();" id="cardpaid"  name="cardpaid" value="0"/></h4>
                                <h4 class="text-right text-custom m-t-0 m-b-0">Advance Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly"  id="txtadvance"  name="txtadvance" value="0"/></h4>
                                <h4 class="text-right text-primary m-t-0 m-b-0"><input id="keepadv" type="checkbox" > <span>Retain?</span> Return Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly" id="returnamount"  name="returnamount" value="0"></h4>
                                <h4 class="text-right text-danger m-t-0 m-b-0">  Balance Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly" id="balanceamount"  name="balanceamount" value="0"></h4>
                                <hr>
                                <div class="text-right">

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
                    </div>
                    <hr>
                    <div class="row hidden-print">

                        <div class=" pull-left">
                           <span name="txtcustomeradvance" style="display:none; font-weight: bold;" class="text-custom" id="txtcustomeradvance"> </span>
                           <a style='display:none;' href="javascript:void(0);" onclick="usecustomeradvance();" class="btn btn-custom waves-effect waves-light" id="btncustomeradvance">Use</a>
                        </div>
                        <div class="pull-right">
                            <span   name="txtloyaltypoints" style="<?php if ($business[0]['r_loyalty_enable'] === 'N') {echo 'display:none;';} ?> font-weight: bold;" class="text-success" id="txtloyaltypoints">Customer's Loyalty Points: <input name="loyaltypoints" id="loyaltypoints" style="width: 80px; border: none;"  type="text" readonly="readonly" value="0"/></span>
                            <a style='<?php if ($business[0]['r_loyalty_enable'] === 'N') {echo 'display:none;';} ?>' href="javascript:void(0);" onclick="loyaltydiscount('<?php echo $business[0]['loyalty_mode']; ?>')" class="btn btn-success waves-effect waves-light" id="btnloyalty">Redeem Loyalty</a>
                            <div class="btn-group m-r-10 dropup">
                                <button id="btnpaymentmode" type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Payment mode <span class="m-l-5"><i class="fa fa-money"></i></span></button>
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
                            <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light" id="btnprint" style="display: none;"><i class="fa fa-print"></i></a>
                            <button id='btnorder' type="button" onclick="retail_updateorder('reload'); " class="btn btn-cyan waves-effect waves-light">Save Order</button>
                            <a href="javascript:void(0);" onclick="createinvoice();"  class="btn btn-pink waves-effect waves-light" id="btninvoice">Invoice</a>
                        </div>

                    </div>
                    <!--invoice End-->
                    
                
                </div>
            </div>
            <!-- end row -->

            <div class="clearfix"></div>
        </div>
    </div>

</div> <!-- end wrapper -->

<!--Cash View Model-->
        <?php include 'modals/cash_modal.php'; ?>
        <!--END Cash View Model-->
        <!--modals-->
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

        <!--Voucher Modal-->
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

         <!--Add Customer Modal-->
        <div id="addcustomer" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addcustomer" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new Customer</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcustomername" class="control-label">Name</label>
                                            <input tabindex="1" type="text" class="form-control" placeholder="Customer Name" id="txtcustomername" name="txtcustomername">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcustomerphone1" class="control-label">Phone 1</label>
                                            <input tabindex="3" type="text" class="form-control numeric" placeholder="Customer Phone 1" id="txtcustomerphone1" name="txtcustomerphone1">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcustomertype" class="control-label">Type</label>
                                            <select tabindex="5" name="txtcustomertype" id="txtcustomertype" class="form-control">
                                                <option value=""></option>
                                                <option value="orange">Orange</option>
                                                <option value="green">Green</option>
                                                <option value="red">Red</option>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtcustomercell" class="control-label">Cell</label>
                                            <input tabindex="2" type="text" class="form-control numeric" placeholder="Customer Cell" id="txtcustomercell" name="txtcustomercell">
                                        </div> 
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtcustomergender" class="control-label">Gender</label>
                                            <select tabindex="2" type="text" class="form-control numeric" placeholder="Gender" id="txtcustomergender" name="txtcustomergender">
                                                <option value="F">Female</option>
                                                <option value="M">Male</option>
                                                
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtcustomerphone2" class="control-label">Phone 2</label>
                                            <input tabindex="4" type="text" class="form-control numeric" placeholder="Customer Phone 2" id="txtcustomerphone2" name="txtcustomerphone2">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtcustomercard" class="control-label">Card #</label>
                                            <input tabindex="4" type="text" class="form-control numeric" placeholder="Customer Card#" id="txtcustomercard" name="txtcustomercard">
                                        </div>
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcustomerprofession" class="control-label">Profession</label>
                                            <input tabindex="6" type="text" class="form-control" placeholder="Customer Profession" id="txtcustomerprofession" name="txtcustomerprofession">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtcustomeremail" class="control-label">Email</label>
                                            <input tabindex="7" type="email" class="form-control " placeholder="Customer Email" id="txtcustomeremail" name="txtcustomeremail">
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtcustomercareof" class="control-label">Care of (<span id="labeladdcustomercareof"></span>)</label>
                                            <input tabindex="7" onchange="onaddcareofchange();" type="text" class="form-control" placeholder="Care Of" id="txtcustomercareof" name="txtcustomercareof">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcustomeraddress" class="control-label">Address</label>
                                            <input tabindex="8" type="text" class="form-control " placeholder="Customer Address" id="txtcustomeraddress" name="txtcustomeraddress">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="row m-b-5">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="txtcustomeranniversary" class="control-label">Wedding Anniversary</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <input tabindex="9" type="text" class="form-control" placeholder="yyyy/mm/dd" id="txtcustomeranniversary" name="txtcustomeranniversary">
                                            <span class="input-group-addon bg-info b-0 text-white"><i class="ti-calendar"></i></span>
                                        </div><!-- input-group -->
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <label for="txtcustomerbirthday" class="control-label">Birthday</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select tabindex="10" id="txtcustomerbirthday" name="txtcustomerbirthday" class="form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-8">
                                        <select tabindex="11" id="txtcustomerbirthmonth" name="txtcustomerbirthmonth" class="form-control">
                                            <option value=""></option>
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcustomerallergies" class="control-label text-danger">Allergies Alert</label>
                                            <input tabindex="12" type="text" class="form-control " placeholder="Note down any allergies the customer may have" id="txtcustomerallergies" name="txtcustomerallergies">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcustomeralert" class="control-label text-warning">Customer Alert</label>
                                            <input tabindex="13" type="text" class="form-control " placeholder="Note down any other alerts you want to get when the customer visits . . ." id="txtcustomeralert" name="txtcustomeralert">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button tabindex="14" onclick="addnew();" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Add Customer Modal-->

        <!--Edit Customer Modal-->
        <div id="editcustomer" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editcustomer" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Customer</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcustomername" class="control-label">Name</label>
                                            <input tabindex="1" type="text" class="form-control" placeholder="Customer Name" id="txteditcustomername" name="txteditcustomername">
                                        </div> 
                                    </div> 
                                </div>                               
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcustomerphone1" class="control-label">Phone 1</label>
                                            <input tabindex="3" type="text" class="form-control numeric" placeholder="Customer Phone 1" id="txteditcustomerphone1" name="txteditcustomerphone1">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcustomertype" class="control-label">Type</label>
                                            <select tabindex="5" name="txteditcustomertype" id="txteditcustomertype" class="form-control">
                                                <option value=""></option>
                                                <option value="orange">Orange</option>
                                                <option value="green">Green</option>
                                                <option value="red">Red</option>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txteditcustomercell" class="control-label">Cell</label>
                                            <input tabindex="2" type="text" class="form-control numeric" placeholder="Customer Cell" id="txteditcustomercell" name="txteditcustomercell">
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txteditcustomergender" class="control-label">Gender</label>
                                            <select tabindex="2" type="text" class="form-control numeric" placeholder="Gender" id="txteditcustomergender" name="txteditcustomergender">
                                                <option value="F">Female</option>
                                                <option value="M">Male</option>
                                                
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row">
                                   
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txteditcustomerphone2" class="control-label">Phone 2</label>
                                            <input tabindex="4" type="text" class="form-control numeric" placeholder="Customer Phone 2" id="txteditcustomerphone2" name="txteditcustomerphone2">
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txteditcustomercard" class="control-label">Card #</label>
                                            <input tabindex="4" type="text" class="form-control numeric" placeholder="Customer Card#" id="txteditcustomercard" name="txteditcustomercard">
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcustomerprofession" class="control-label">Profession</label>
                                            <input tabindex="6" type="text" class="form-control" placeholder="Customer Profession" id="txteditcustomerprofession" name="txteditcustomerprofession">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txteditcustomeremail" class="control-label">Email</label>
                                    <input tabindex="7" type="text" class="form-control" placeholder="Email" id="txteditcustomeremail" name="txteditcustomeremail">
                                </div> 
                            </div> 
                             
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txteditcustomercareof" class="control-label">Care of (<span id="labelcustomercareof"></span>)</label>
                                    <input tabindex="7" onchange="oncareofchange();" type="text" class="form-control" placeholder="Care Of" id="txteditcustomercareof" name="txteditcustomercareof">
                                </div> 
                            </div> 
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditcustomeraddress" class="control-label">Address</label>
                                    <input tabindex="8" type="text" class="form-control" placeholder="Address" id="txteditcustomeraddress" name="txteditcustomeraddress">
                                </div> 
                            </div> 
                        </div>
                        <div class="row m-b-5">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="txteditcustomeranniversary" class="control-label">Wedding Anniversary</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <input tabindex="9" type="text" class="form-control" placeholder="yyyy/mm/dd" id="txteditcustomeranniversary" name="txteditcustomeranniversary">
                                            <span class="input-group-addon bg-info b-0 text-white"><i class="ti-calendar"></i></span>
                                        </div><!-- input-group -->
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <label for="txteditcustomerbirthday" class="control-label">Birthday</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select tabindex="10" id="txteditcustomerbirthday" name="txteditcustomerbirthday" class="form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-8">
                                        <select tabindex="11" id="txteditcustomerbirthmonth" name="txteditcustomerbirthmonth" class="form-control">
                                            <option value=""></option>
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcustomerallergies" class="control-label text-danger">Allergies Alert</label>
                                            <input tabindex="12" type="text" class="form-control " placeholder="Note down any allergies the customer may have" id="txteditcustomerallergies" name="txteditcustomerallergies">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcustomeralert" class="control-label text-warning">Customer Alert</label>
                                            <input tabindex="13" type="text" class="form-control " placeholder="Note down any other alerts you want to get when the customer visits . . ." id="txteditcustomeralert" name="txteditcustomeralert">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <input tabindex="14" type="hidden" id="txteditcustomerid" name="txteditcustomerid">
                        <button onclick="update();" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Edit Customer Modal-->

        
        

<input type="hidden" name="uid" id="uid" />
<input type="hidden" name="uname" id="uname" />
<input type="hidden" name="uusername" id="uusername" />
<input type="hidden" name="uemail" id="uemail" />
<input type="hidden" name="ddiscount_remarks" id="ddiscount_remarks" />


<?php include 'js_functions/general_js.php'; ?>
<?php include 'js_functions/retail_js.php'; ?>
<?php include 'js_functions/order_invoice_js.php'; ?>
<script>
    $(document).on('keydown', function(e) {
        //console.log(e.which);
            if (e.which == 113 || e.which == 46) { //F2 or Delete
                $('#retail-order-products').select2('close');
                $("#paid").val("");
                $("#paid").focus();
            }
            if (e.which == 191) { //?
                $('#retail-order-products').select2('close');
                $("#btnorder").click();
                return false;
            }
            if (e.which == 187) { //=
                $('#retail-order-products').select2('close');
                if($("#btninvoice").is(":visible")){
                    $("#btninvoice").click();
                    return false;                
                }
            }
            if(e.which==27){
                 submitopenfresh();
            }
        });
    var enabtax=false;
    $(document).ready(function () {

        customer_select();
        retail_getproducts();
        fillBday();
        
        $("#btninvoice").hide(); 
        $("#btnpaymentmode").hide();
        $("#btnorder").show();
        
        $('#addcustomer').on('shown.bs.modal', function() {
            $('#txtcustomername').focus();
        });
        $('#editcustomer').on('shown.bs.modal', function() {
            $('#txteditcustomername').focus();
        });
        
        
        //$("#txt-customer-search").select2('open');
        //$('#retail-order-products').select2('open');
        $('#retail-order-staff').select2();


        $("#order-customer-qty").focus(function () {
            $(this).select();
        });
 
        $("#paid").focusout(function () {
            if($("#paid").val()==""){ $("#paid").val("0");}
        });

        $("#order-customer-qty").keydown(function (e) {
            if (e.which === 13) {
                $("#btn-add").focus();
            }
        });
        
        $("#btnorder").focusin(function () {
            $("#btn-add").removeClass("btn-cyan");
            $("#btn-add").addClass("btn-pink");
        });
       
        
        $("#btnorder").click(function () {
            $("#btn-add").removeClass("btn-pink");
            $("#btn-add").addClass("btn-cyan");
        });
        
        $("#btn-add").focusin(function () {
            $("#btn-add").removeClass("btn-purple");
            $("#btn-add").addClass("btn-pink");
        });
        $("#btn-add").click(function () {
            $("#btn-add").removeClass("btn-pink");
            $("#btn-add").addClass("btn-purple");
        });

        $(".numeric").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 13 && e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
        
        $("#s2id_autogen1_search").keyup(function (e) {
           //console.log(e.which);
           if((e.which < 48 || e.which > 57) && (e.which < 95 || e.which > 106)){
                $("#txtcustomername").val($("#s2id_autogen1_search").val());
           } else {
               $("#txtcustomercell").val($("#s2id_autogen1_search").val());
                
           }
        });
        
        $('#addcustomer').on('hidden.bs.modal', function () {
            // do something…
            $("#txtcustomername").val("");
            $("#txtcustomercell").val("");
        });
        
        <?php if($business[0]['tax_optional'] === 'No'){ ?>
            enabletaxes('yes');
        <?php } ?>
        
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
                $("#invoicepass").modal("show");
            });
            
            $("#txtdiscount").dblclick(function() {
               $("#invoicepass").modal("show");
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


    $(window).load(function(){
        
        var id_customer_order = <?php if(isset($id_customer_order)){echo "'". $id_customer_order . "'";}else{echo '0';}?>;
        //console.log('order:' + id_customer_order);
        if(id_customer_order>0){openOrder(id_customer_order);} else {  $("#txt-customer-search").select2("open");}
        
        var id_customer = <?php if(isset($id_customer)){echo "'". $id_customer . "'";}else{echo '0';}?>;
        //console.log('customer' + id_customer);
        if(id_customer>0){customer_direct_select(id_customer);} else {  $("#txt-customer-search").select2("open");}
        
    });


     function customer_direct_select(id_customer){
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>customer_controller/searchid',
            data: {id:id_customer},
            dataType: "json",
            cache: false,
            async: true,
            success: function (data) {
               
                 
                $("#CurrentAction").html('Customer Search . . .');
                //refresh things
                $("#customeradvance").val("0");
                $("#remainingretained").val("0");
                $("#retainedused").val("No");
                $("#retainedamountused").val("0");
                $("#txtcustomeradvance").html("0");
                $("#loyaltypoints").val("0");
                $("#txtcustomeradvance").hide();
                $("#btncustomeradvance").hide();
                $("#customerbalancediv").hide();
                $("#customer-visit-list tbody").html("");
                ////////////////
                //console.log(data);
                
                $("#label-customer-name").html(data[0]['customer_name']);
                $("#customername").val(data[0]['customer_name']);
                $("#customerid").val(data[0]['id_customers']);
                $("#servicecustomer").val(data[0]['id_customers']);
                
                $("#order-customer-id").val(data[0]['id_customers']);
                
                $("#customercell").val(data[0]['customer_cell']);
                $("#customeraddress").val(data[0]['customer_address']);
                $("#customeremail").val(data[0]['customer_email']);

              

                if(parseInt(data[0]['id_customers']) > 1){
                    $("#btnedit").slideDown();
                    $("#btnaccount").slideDown();
                } else {
                    $("#btnedit").slideUp();
                    $("#btnaccount").slideUp();
                }
                console.log('customer ' +data[0]['id_customers']);
                checkopenorder(data[0]['id_customers']);
                //get_customer_details(data[0]['id_customers']);
        
                $(".tdcustomerid").html(data[0]['id_customers']);

                //checkopenvisit(data[0]['id_customers']);
               

            }
        });
    }


    function customer_select() {
        $("#txt-customer-search").select2({
            placeholder: "Change Customer",
            initSelection: function(element, callback) {},
            ajax: {
                url: '<?php echo base_url(); ?>customer_controller/search',
                dataType: 'json',
                delay: 250,
                data: function (term, page) {

                    return {
                        customername: term, // search term
                        page_limit: 30, // page size
                        page: page // page number
                    };
                },
                results: function (data, page) {

                    var more = (page * 30) < data.length;
                    return {results: data, more: more};
                }
            },
            escapeMarkup: function (m) {
                return m;
            }, // let our custom formatter work
            minimumInputLength: 3,
            formatResult: function (option) {
                return option.customer_name + "  " + option.customer_cell;
            },
            formatSelection: function (option) {

                return option.customer_name + "  " + option.customer_cell;
            }
        });
        
    }

    function on_customer_change() {
    
        //refresh things
        new_order_mode();
        $("#customeradvance").val("0");
        $("#remainingretained").val("0");
        $("#retainedused").val("No");
        $("#retainedamountused").val("0");
        $("#txtcustomeradvance").html("0");
        $("#loyaltypoints").val("0");
        $("#txtcustomeradvance").hide();
        $("#btncustomeradvance").hide();
        $("#customerbalancediv").hide();
       // $("#order-product-list tbody").html("");
        ////////////////
    
        var data = $("#txt-customer-search").select2('data');
        $("#label-customer-name").html(data.customer_name);
        $("#txt-customer-name").val(data.customer_name);
        $("#customerid").val(data.id_customers);
        $("#servicecustomer").val(data.id_customers);
        
        $("#order-customer-id").val(data.id_customers);
        $("#retail-order-products").select2('open');
        $("#customername").val(data.customer_name);
        $("#order-customer-id").val(data.id_customers);
        $("#customercell").val(data.customer_cell);
        $("#customeraddress").val(data.customer_address);
        $("#customeremail").val(data.customer_email);
        if(parseInt(data.id_customers) > 1){
            $("#btnedit").slideDown();
            $("#btnaccount").slideDown();
        } else {
            $("#btnedit").slideUp();
            $("#btnaccount").slideUp();
        }
        
        get_customer_details(data.id_customers);
        
        $(".tdcustomerid").html(data.id_customers);
       
    }


    function retail_getproducts() {
        var businessid=<?php echo $this->session->userdata('businessid');?>;
        if($('#checkboxall').is(':checked')){
            businessid="";
        }
        $("#retail-order-products").select2({
            ajax: {
                url: '<?php echo base_url() . 'product_controller/getproducts'; ?>',
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
            escapeMarkup: function (m) {
                return m;
            }, // let our custom formatter work
            minimumInputLength: 1,
            formatResult: function (option) {
                return option.business_brand_name + ' - ' + option.product + ' ' +option.qty_per_unit + ' ' + option.measure_unit + ' - ' + option.mcategory + ' - Batch: ' + option.batch + ' ('+ option.business_store +': ' + option.instock + ')';
            },
            formatSelection: function (option) {
                return option.business_brand_name + ' - ' + option.product + ' ' +option.qty_per_unit + ' ' + option.measure_unit + ' - ' + option.mcategory + ' - Batch: ' + option.batch + ' ('+ option.business_store +': ' + option.instock + ')';
            }
        });

    }

    function on_product_change() {
        //$('#retail-order-staff').focus();
        $('#retail-order-staff').select2('open');
    }

  

    function on_staff_change() {
        $("#order-customer-qty").val("1");
        $("#order-customer-qty").focus();
    }

    function service_row_sum() {
        var theTotal = 0;
        $("#ordertbl td:nth-child(12) .combat").each(function () {
//            console.log($(this).text());
            var val = $(this).text();//.replace(" ", "").replace(",-", "");
            theTotal += parseFloat(val);
        });

        $('#txtsubtotal').val(theTotal.toFixed(2));
        
    }
    
    function updatetotal() {
        console.log('run total');
        service_row_sum();
        
        if($('#txtdiscount').val()===""){$('#txtdiscount').val('0');}
        if($('#txtothercharges').val()===""){$('#txtothercharges').val('0');}
        
        var grosstotal=(parseFloat($("#txtsubtotal").val()) +  parseFloat($("#txtothercharges").val()) + parseFloat($("#txtcctip").val()) - parseFloat($("#txtdiscount").val()));
        
        $("#txtgross").val(grosstotal);
        
        
        var nettax= 0;
        if(enabtax===true){
            var taxarray = [];
            $( ".tax" ).each(function(index) {
                $(this).val(grosstotal*parseFloat($("#taxperc"+index).val())/100);
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
        
        var product_ids = [];
        $('input[name=product_id]').each(function(x) {
            product_ids.push($(this).val());
        });
        
        var discounted_price = [];
        $('input[name=orignal_product_price]').each(function(x) {
            discounted_price.push((parseFloat($(this).val()) - parseFloat(product_discount[x])));
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
        
        $('#btninvoice').addClass('disabled');
        $('#btninvoice').html('<i class="fa fa-spin fa-spinner"></i> Please wait');
    
        $.ajax({
            type: 'POST',
            url: 'invoice_controller/updateorderinvoice',
            data: {
                orderid: $("#orderid").val(),
                product_ids: product_ids,
                
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
                keepadv: $("#keepadv").prop('checked'),
                retained_used: $("#retainedused").val(),
                retained_amount_used: $("#retainedamountused").val(),
                remaining_retained: $("#remainingretained").val(),
                cctip: $("#txtcctip").val(),
                loyalty_sms: '<?php echo $business[0]['loyalty_sms'];?>',
                cc_charge: $("#txtcc_charge").val()
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
                    var myWindow = window.open("<?php echo base_url(); ?>existingorderinvoice/" + result[1], "_blank");
                   // submitopendirectselect();
                    submitopenfresh();
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
    
    function get_customer_details(id_customers){
        showCalendarOverlay();
        //refresh things
        $("#editcustomer").hide();
        $("#customeradvance").val("0");
        $("#remainingretained").val("0");
        $("#retainedused").val("No");
        $("#retainedamountused").val("0");
        $("#txtcustomeradvance").html("0");
        $("#loyaltypoints").val("0");
        $("#txtcustomeradvance").hide();
        $("#btncustomeradvance").hide();
        $("#customerbalancediv").hide();
        
        ////////////////
    
        $.ajax({
            type: 'POST',
            //url: 'Scheduler_controller/getAllStaff',
            url: '<?php echo base_url() . 'pos_controller/get_customer_details'; ?>',
            data: {customer_id:id_customers},
            dataType: "json",
            cache: false,
            async: true,
            success: function (bal) {
                console.log(bal);
                var balance=bal.balance;
                var customer_points=bal.customer_points;
                var customer_alerts=bal.customer_alerts;
                
                
                if(balance.length>0){
                    var bhtml=""
                    $.each(balance, function(i, val){
                        if(val['invoice_type']=='service'){
                            bhtml+='<a target="_blank" class="btn btn-danger waves-effect waves-light m-l-5 m-b-5 btn-sm"  href="<?php echo base_url();?>open_recovery_invoice/'+ val['id_invoice'] + '/' + val['visit_id'] + '">Rs. ' + val['totalbalance'] + '</a>';
                        } else {
                            bhtml+='<a target="_blank" class="btn btn-danger waves-effect waves-light m-l-5 m-b-5 btn-sm"  href="<?php echo base_url();?>open_recovery_order_invoice/'+ val['id_invoice'] + '/' + val['visit_id'] + '">Rs. ' + val['totalbalance'] + '</a>';
                        }
                    });
                    
                    $("#customerbalance").html(bhtml);
                    $("#customerbalancediv").show();
                    
                }else{
                    $("#customerbalancediv").hide();
                }
                
                if(customer_alerts.length > 0){
                    if (customer_alerts[0]['customer_alert'] !== "" || customer_alerts[0]['customer_alert'] !== "" ) {
                        $("#customeralert").html(customer_alerts[0]['customer_allergies'] + '<br>' + customer_alerts[0]['customer_alert']);
                        $("#customeralertdiv").show();
                    }
                }else{
                    $("#customeralertdiv").hide();
                }
                
                
                if(customer_points.length>0 && $("#loyaltyenabled").val()=="Y"){
                    if (parseInt(customer_points[0]['retained']) > 0 && parseInt(id_customers) > 1) {
                        $("#customeradvance").val(customer_points[0]['retained']);
                        $("#remainingretained").val(customer_points[0]['retained']);
                        $("#retainedused").val("No");
                        $("#retainedamountused").val("0");
                        
                        $("#txtcustomeradvance").html("Customer's Remaining Available Amount: "+customer_points[0]['retained']);
                        $("#txtcustomeradvance").show();
                        $("#btncustomeradvance").show();
                        
                    } else {
                        $("#txtcustomeradvance").hide();
                        $("#btncustomeradvance").hide();
                    }
                    
                    if (parseInt(customer_points[0]['loyalty_points']) > 0 && parseInt(id_customers) > 1) {
                        $("#loyaltypoints").val(customer_points[0]['loyalty_points']);
                        $("#txtloyaltypoints").show();
                        $("#loyaltypoints").show();
                        $("#btnloyalty").show();
                    } else {
                        $("#txtloyaltypoints").hide();
                        $("#loyaltypoints").hide();
                        $("#btnloyalty").hide();
                    }
                    
                }else {
                    $("#txtloyaltypoints").hide();
                    $("#loyaltypoints").hide();
                    $("#btnloyalty").hide();
                    $("#txtcustomeradvance").hide();
                    $("#btncustomeradvance").hide();
                }
                
                $("#label-customer-name").html(customer_points[0]['customer_name']);
                
                $("#customerid").val(customer_points[0]['customer_id']);
                $("#servicecustomer").val(customer_points[0]['customer_id']);
                
                $("#order-customer-id").val(customer_points[0]['customer_id']);
                
                $("#customername").val(customer_points[0]['customer_name']);
                $("#customercell").val(customer_points[0]['customer_cell']);
                $("#customeraddress").val(customer_points[0]['customer_address']);
                $("#customeremail").val(customer_points[0]['customer_email']);
                
            }
        });
        
    }
    
    
    function checkopenorder(cid) {
        
        clearForm();
        
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() . 'order_controller/getOrderbyCid'; ?>",
            data: {customerid: cid},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                console.log(data);
                if (data.length > 0) {
                    
                    fill_order(data[0]['id_customer_order']);
                    invoice_mode();
                } else {
                    new_order_mode();
                    $("#visitid").val('');
                    $("#visitdate").val('');
                    get_customer_details(cid);
                   // $("#visit-services").select2('open');
                    
                }
            }
        });

    }
    
    
    function openOrder(order_id){
   
        clearForm();
        //$("#txt-customer-search").select2("val", "");
        
        fill_order(order_id);
        invoice_mode();
        $(".discount").show(); $(".discountperc").show(); 
        //$("#retail-order-products").select2('open');
    }
    
    function fill_order(orderid){
        var myurl;
        
        myurl = '<?php echo base_url().'Scheduler_controller/getOrderbyid'; ?>';

        $.ajax({
            type: 'POST',
            url: myurl,
            data: {id_customer_order: orderid},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                $("#order-id").val(data[0]['id_customer_order']);
                $("#orderid").val(data[0]['id_customer_order']);
                //$("#txt-customer-search").select2("val", data[0]['customer_name']);
                mhtml = "";
                
                
                $("#customerid").val(data[0].customer_id);
                $("#servicecustomer").val(data[0].customer_id);
                
                $("#order-customer-id").val(data[0].customer_id);
                
                $("#customername").val(data[0].customer_name);
                $("#customercell").val(data[0].customer_cell);
                $("#customeraddress").val(data[0].customer_address);
                $("#customeremail").val(data[0].customer_email);
                
                var rowcount=1;
                for (x = 0; x < data.length; x++) {
                    
                    mhtml += '<tr >';
                    mhtml += '<td class="tdcustomerid" style="display:none;">' + data[x]['customer_id'] + '</td>';
                    mhtml += "<td class='id' row='"+rowcount+"'><input type='hidden' id='product_id' name='product_id' value='"+ data[x]['product_id']  +"'>" + data[x]['product_id'] + "</td>";
                    mhtml += "<td>" + data[x]['product_name'] + "</td>";
                    mhtml += "<td>" + data[x]['category'] + "</td>";
                    mhtml += "<td class='batchid' batch_id='"+data[x]['batch_id']+"'>" + data[x]['batch'] + "</td>";
                    mhtml += "<td style='display:none;'>" + data[x]['staff_id'] + '</td>';
                    mhtml += "<td>" + data[x]['staff_name'] + '</td>';
                    mhtml += '<td class="qty" stockfrom="">' + data[x]['qty'] + '</td>';
                    mhtml += '<td class="price">' + data[x]['price'] + '</td>';
                    mhtml += '<td class="discount" ><input  type="text" onclick="single_discount_pass('+data[x]['product_id']+');" onblur="discount_by_product(0, '+data[x]['product_id']+');" class="numeric discount_by_product" name="discount_by_product" id="discount_by_product'+data[x]['product_id']+'" style="width: 80px; border: none;" value="0"></td>';
                    mhtml += '<td class="discountperc"><input  onclick="single_discount_pass('+data[x]['product_id']+');" style="border:none; width: 40px;" onblur="javascript:perc_discount_product(0, '+data[x]['product_id']+');" class="numeric perc_discount_product" type="text" name="perc_discount_product" id="perc_discount_product'+data[x]['product_id']+'" placeholder="0"  /></td>';
                    mhtml += '<td >Rs.<span class="combat" id="unitcost'+data[x]['product_id']+'">' + parseFloat(data[x]['qty'])*parseFloat(data[x]['price'])  + '</span><input type="hidden" name="orignal_product_price" id="orignal_product_price'+data[x]['product_id']+'" value="' + parseFloat(data[x]['qty'])*parseFloat(data[x]['price'])  + '"></td>'
                    mhtml += '<td><span class="label label-danger" onclick="order_mode(); removebyrow(\'' + rowcount + '\');" style="cursor:pointer">x</span></td>';
                    mhtml += "</tr>";
                    rowcount++;
                }
                $("#order-product-list tbody").append(mhtml);
                get_customer_details(data[0].customer_id);
                invoice_mode();
                updatetotal();
            }
        });
        //$("#txt-customer-search").trigger('change.select2');
    }
    
    function clearForm(){
         
        //refresh things
        $("#customeradvance").val("0");
        $("#remainingretained").val("0");
        $("#retainedused").val("No");
        $("#retainedamountused").val("0");
        $("#txtcustomeradvance").html("0");
        $("#loyaltypoints").val("0");
        $("#txtcustomeradvance").hide();
        $("#btncustomeradvance").hide();
        $("#label-customer-name").html('');
        
        ////////////////
        
        $("#order-id").val('');
        $("#orderid").val('');
        $("#customername").val('');
        $("#customername").val('');
        $("#customercell").val('');
        $("#customeraddress").val('');
        $("#customeremail").val('');

        $("#customerid").val("");
        $("#order-customer-id").val('');
        $("#servicecustomer").val('');
        
        $("#txt-customer-name").val("");
        $("#customerbalancediv").hide();
        
        
        $("#order-product-list tbody").html("");
        
    }
    
    
    /////////////////EDIT CUSTOMER/////////////////////
    function openupdate() {
        //var name = $('#customername' + id).val();
        
        var id_customers = $("#customerid").val();
        if(id_customers == "1"){
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>customer_controller/edit_customers',
            data: {id_customers: id_customers},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data){

                $("#txteditcustomerid").val(id_customers);
                $("#txteditcustomername").val(data.customer_name);
                <?php 
                    if( $this->session->userdata('hide_cell') && $this->session->userdata('hide_cell') == "No"){ 
                ?>
                        $("#txteditcustomercell").val(data.customer_cell);
                <?php 
                    } 
                ?>
                $("#txteditcustomergender").val(data.customer_gender);
                $("#txteditcustomerphone1").val(data.customer_phone1);
                $("#txteditcustomerphone2").val(data.customer_phone2);
                $("#txteditcustomercard").val(data.customer_card);
                $("#txteditcustomeraddress").val(data.customer_address);
                $("#txteditcustomeremail").val(data.customer_email);
                $("#labelcustomercareof").html(data.customer_careof);
                enable_detailcareof();
                $("#txteditcustomerbirthday").val(data.customer_birthday);
                $("#txteditcustomerbirthmonth").val(data.customer_birthmonth);
                $("#txteditcustomerallergies").val(data.customer_allergies);
                $("#txteditcustomeranniversary").val(data.customer_anniversary);
                $("#txteditcustomeralert").val(data.customer_alert);
                $("#txteditcustomertype").val(data.customer_type);
                $('#txteditcustomerprofession').val(data.profession);

                $("#editcustomer").modal('show');

            }
        });
    }
    
    function customer_submit_update(){
        $.ajax({
            type: 'POST',
            url: 'customer_controller/update_customer',
            data: {id_customer: $("#txteditcustomerid").val(), 
                customer_name: $("#txteditcustomername").val(), 
                customer_cell: $("#txteditcustomercell").val(), 
                customer_gender: $("#txteditcustomergender").val(), 
                customer_phone1: $("#txteditcustomerphone1").val(), 
                customer_phone2: $("#txteditcustomerphone2").val(), 
                customer_card: $("#txteditcustomercard").val(), 
                customer_address: $("#txteditcustomeraddress").val(), customer_birthday: $("#txteditcustomerbirthday").val(), customer_birthmonth: $("#txteditcustomerbirthmonth").val(), customer_email: $("#txteditcustomeremail").val(), customer_careof:$("#txteditcustomercareof").val(), customer_anniversary: $("#txteditcustomeranniversary").val(), customer_allergies: $("#txteditcustomerallergies").val(), customer_alert: $("#txteditcustomeralert").val(), customer_type: $("#txteditcustomertype").val(), profession: $('#txteditcustomerprofession').val()},
            success: function(data) {
                var result = data.split("|");
                if (result[0] === "success") {
                    toastr.success(data, 'Customer Updated');
                    location.reload();
                }
            }
        });
    }
            
            function oncareofchange(){
                var data = $("#txteditcustomercareof").select2('data');

                if($("#txteditcustomercell").val()===""){
                    $("#txteditcustomercell").val(data.customer_cell);
                }
            }

            function onaddcareofchange(){
                var data = $("#txtcustomercareof").select2('data');

                if($("#txtcustomercell").val()===""){
                    $("#txtcustomercell").val(data.customer_cell);
                }
            }    
            function enable_detailcareof(){
            $("#txteditcustomercareof").select2({
                 ajax: {
                   url: '<?php echo base_url();?>customer_controller/searchnameforco',
                   dataType: 'json',
                   delay: 250,
                   data: function (term, page) {

                     return {
                         customername: term, // search term
                         page_limit: 30, // page size
                         page: page // page number
                     };
                   },
                   results: function (data, page) {

                         var more = (page * 30) < data.length;
                         return {results: data, more: more};
                     }
                   },
                 escapeMarkup: function (m) { return m; }, // let our custom formatter work
                 minimumInputLength: 3,
                 formatResult: function (option) {
                    return option.customer_name ;
                 },
                 formatSelection: function (option) {
                     return option.customer_name;
                 }
               });

         }
         
         function update(){
                $.ajax({
                    type: 'POST',
                    url: 'customer_controller/update_customer',
                    data: {id_customer: $("#txteditcustomerid").val(), 
                        customer_name: $("#txteditcustomername").val(), 
                        customer_cell: $("#txteditcustomercell").val(), 
                        customer_gender: $("#txteditcustomergender").val(), 
                        customer_phone1: $("#txteditcustomerphone1").val(), 
                        customer_phone2: $("#txteditcustomerphone2").val(), 
                        customer_card: $("#txteditcustomercard").val(), 
                        customer_address: $("#txteditcustomeraddress").val(), customer_birthday: $("#txteditcustomerbirthday").val(), customer_birthmonth: $("#txteditcustomerbirthmonth").val(), customer_email: $("#txteditcustomeremail").val(), customer_careof:$("#txteditcustomercareof").val(), customer_anniversary: $("#txteditcustomeranniversary").val(), customer_allergies: $("#txteditcustomerallergies").val(), customer_alert: $("#txteditcustomeralert").val(), customer_type: $("#txteditcustomertype").val(), profession: $('#txteditcustomerprofession').val()},
                    success: function(data) {
                        var result = data.split("|");
                        if (result[0] === "success") {
                            toastr.success(data, 'Customer Updated');
                            location.reload();
                        }
                    }
                });
            }
    
    /////////////////ADD CUSTOMER/////////////////////
    
    function enable_addcareof(){
        $("#txtcustomercareof").select2({
             ajax: {
               url: '<?php echo base_url();?>customer_controller/searchnameforco',
               dataType: 'json',
               delay: 250,
               data: function (term, page) {

                 return {
                     customername: term, // search term
                     page_limit: 30, // page size
                     page: page // page number
                 };
               },
               results: function (data, page) {

                     var more = (page * 30) < data.length;
                     return {results: data, more: more};
                 }
               },
             escapeMarkup: function (m) { return m; }, // let our custom formatter work
             minimumInputLength: 3,
             formatResult: function (option) {
                return option.customer_name ;
             },
             formatSelection: function (option) {
                 return option.customer_name;
             }
           });

     }
    function openaddnew() {
    
                //$("#txtcustomername").val("");
        $("#txtcustomerphone1").val("");
        $("#txtcustomertype").val("");
        //$("#txtcustomercell").val("");
        $("#txtcustomergender").val("");
        $("#txtcustomerphone2").val("");
        $("#txtcustomercard").val("");
        $("#txtcustomerprofession").val("");
        $("#txtcustomeremail").val("");
        $("#txtcustomeraddress").val("");
        $("#txtcustomeranniversary").val("");
        $("#txtcustomerbirthday").val("");
        $("#txtcustomerallergies").val("");
        $("#txtcustomeralert").val("");
        
        enable_addcareof();
        $("#addcustomer").modal('show');
    }
        function addnew() {
            if ($("#txtcustomername").val() !== "" && $("#txtcustomercell").val() !== "") {
                $("#txtcustomername").val(ucwords($("#txtcustomername").val()));
                var customer_name = $("#txtcustomername").val().trim();
                customer_name = customer_name.split(" ");
                var existvalue = 0;
                if (customer_name.length > 1) {
                    var customer_name = $("#txtcustomername").val();
                    var customer_cell = $("#txtcustomercell").val();
                    
                     if(customer_cell.length !== 11){
                            swal({
                                title: "Cell Length",
                                text: 'use 11 digits for cell number',
                                type: "error",
                                confirmButtonText: 'OK!'
                            });
                            return false;
                       }
                    
                    customer_cell = customer_cell || null;
                    if (customer_exist(customer_name, customer_cell)) {
                        var exist = customer_exist(customer_name, customer_cell);
                        var name = "name "+customer_name;
                        var cell = "cell "+customer_cell;
                        if(exist === name){
                            swal({
                                title: "Customer Name and cell number already exists!",
                                text: "Add another ?",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "Yes",
                                cancelButtonText: "No",
                                closeOnConfirm: true,
                                closeOnCancel: true
                              },
                              function(isConfirm){
                                  if (isConfirm) {
                                    customer_submit();
                                  } else {
                                      $("#addcustomer").modal('hide');
                                      $("#addcustomer input").val('');
                                    //swal("Cancelled", "Your imaginary file is safe :)", "error");
                                  }
                              });
                        }else if(exist === cell){
                            swal({
                                title: "Cell number already exists!",
                                text: "",
                                type: "error",
                                confirmButtonText: 'OK!'
                            });
                            swal({
                                title: "Cell number already exists!",
                                text: "Add another ?",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "Yes",
                                cancelButtonText: "No",
                                closeOnConfirm: true,
                                closeOnCancel: true
                              },
                              function(isConfirm){
                                  if (isConfirm) {
                                    customer_submit();
                                  } else {
                                      $("#addcustomer").modal('hide');
                                      $("#addcustomer input").val('');
                                    //swal("Cancelled", "Your imaginary file is safe :)", "error");
                                  }
                              });
                        }else{
                            customer_submit();
                        }
                    }else{
                        customer_submit();
                    }
                } else {
                    swal({
                        title: "Please enter Customer's last name also!",
                        text: "",
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
                }
            } else {
                swal({
                        title: "Please enter Customer's Name and Cell!",
                        text: "Name and Cell Number are mandatory Fields",
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
                
            }
        }

        function customer_exist(name,cell) {
            cell = cell || null;
            var res;
            $.ajax({
                type: 'POST',
                url: 'customer_controller/customer_exist',
                data: {customer_name: name, customer_cell: cell},
                async: false,
                success: function(response) {
                    res = response;
                }
            });
            return res;
        }

        function customer_update_exist(customer_id, name, cell) {
            cell = cell || null;
            var res;
            $.ajax({
                type: 'POST',
                url: 'customer_controller/customer_update_exist',
                data: {customer_name: name, customer_cell: cell, customer_id: customer_id},
                async: false,
                success: function(response) {
                    res = response;
                }
            });
            return res;
        }

        function customer_submit(){
            $.ajax({
                type: 'POST',
                url: 'customer_controller/add_customer',
                data: {customer_name: $("#txtcustomername").val(), 
                    customer_cell: $("#txtcustomercell").val(), 
                    customer_gender: $("#txtcustomergender").val(), 
                    customer_phone1: $("#txtcustomerphone1").val(), 
                    customer_phone2: $("#txtcustomerphone2").val(), 
                    customer_card: $("#txtcustomercard").val(), 
                    customer_address: $("#txtcustomeraddress").val(), customer_birthday: $("#txtcustomerbirthday").val(), customer_birthmonth: $("#txtcustomerbirthmonth").val(), 
                    customer_email: $("#txtcustomeremail").val(), customer_careof:$("#txtcustomercareof").val(), customer_anniversary: $("#txtcustomeranniversary").val(), customer_allergies: $("#txtcustomerallergies").val(), customer_alert: $("#txtcustomeralert").val(), customer_type: $("#txtcustomertype").val(), profession: $('#txtcustomerprofession').val()},
                success: function(data) {
                    console.log(data);
                    var result = data.split("|");
                    if (result[0] === "success") {
                        toastr.success(data, 'New Customer Added at ID '+ result[1]);
                        get_customer_details(result[1]);
                        $('#btnedit').show();
                        $('#btnacccount').show();
                        $('#addcustomer').modal('hide');
                    }
                }
            });
        }

        function fillBday() {
            for (x = 1; x <= 31; x++) {
                $("#txt-customer-bday").append('<option value=' + x + '>' + x + '</option>');
                $("#txtcustomerbirthday").append('<option value=' + x + '>' + x + '</option>');
                $("#txteditcustomerbirthday").append('<option value=' + x + '>' + x + '</option>');

            }
        }

    function openAccount() {
        if(parseInt($('#customerid').val()) > 1){
            var customer_id = $('#customerid').val();
            window.open('customer_previous_visit/' + customer_id);
        }
    }
    
    
    
    ////////Voucher Payments/////////
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
    /////////////Gift Voucher//////////////
    function open_gift_voucher(){
            
        $('#event-modal > div').removeClass('modal-lg');
        
        $('#event-modal').modal({
            backdrop:'static',
            keyboard:false,
            show:true
        });
        
        $('#modal-header-title').html('Gift Voucher');
        $('#schedulerFunctionBtn').html('Gift Voucher');
        $("#schedulerFunctionBtn").attr('onclick', 'giftVoucherForm(0);');
        
    }

    ////////////////Submit Forms

    function submitopenorder(){
        $("#openorderform").submit();
    }
    
    function submitopenfresh(){
        $("#openfresh").submit();
    }
    
    function submitopendirectselect(){
        $("#opendirectselect").submit();
    }    
    
    function submitserviceform(){
        if($("#customerid").val()!==''){
            $("#servicecustomer").val($("#customerid").val());
        }
        $("#serviceform").submit();
    }

    /////////////////

    function new_order_mode(){
        //console.log('show new visit');
        $("#btn-add").show();
        $("#txtloyaltypoints").hide();
        $("#loyaltypoints").hide();
        $("#btnloyalty").hide();
        $("#txtcustomeradvance").hide();
        $("#btncustomeradvance").hide();
        $("#btnpaymentmode").hide();
        
        $("btnaddcustomer").attr('disabled','disabled');
        $("txt-customer-search").attr('disabled','disabled');
        
        $("#btninvoice").hide(); 
        $("#btnorder").show();
        
        $('#invoicingdiv').slideUp();
        $(".discountshow").html('');
        $(".staffshare").hide();
        
        $("#CurrentAction").html('Creating New Order . . .');
        $("#CurrentActionDiv").css('background','#ff8acc');
        
        $("#CurrentActionIcon").removeClass('ti-spray');
        $("#CurrentActionIcon").removeClass('ti-money');
        $("#CurrentActionIcon").removeClass('ti-shopping-cart-full');
        $("#CurrentActionIcon").addClass('ti-shopping-cart');
        
    }
    
    function order_mode(){
        console.log('show visit');
        $("#btn-add").show();
        $("#txtloyaltypoints").hide();
        $("#loyaltypoints").hide();
        $("#btnloyalty").hide();
        $("#txtcustomeradvance").hide();
        $("#btncustomeradvance").hide();
        $("#btnpaymentmode").hide();
        
        $("btnaddcustomer").attr('disabled','disabled');
        $("txt-customer-search").attr('disabled','disabled');
        
        
        $("#btninvoice").hide(); 
        $("#btnorder").show();
        
        $('#invoicingdiv').slideUp();
        $(".discountshow").html('');
        $(".staffshare").hide();
        
        $("#CurrentAction").html('Editing Customer Order . . .');
        $("#CurrentActionDiv").css('background','#f9c851');
        
        $("#CurrentActionIcon").removeClass('ti-money');
        $("#CurrentActionIcon").removeClass('ti-spray');
        $("#CurrentActionIcon").removeClass('ti-shopping-cart');
        $("#CurrentActionIcon").addClass('ti-shopping-cart-full');        
        
    }
    
    ////////////////////////////////////////////
    
    
    ////////////Invoice Operations ///////////////
    function invoice_mode(){
        console.log('show invoice');
        
        
        $("#btninvoice").show(); 
        $("#btnpaymentmode").show();
        $("#btnorder").hide();
        
        $("btnaddcustomer").attr('disabled','disabled');
        $("txt-customer-search").attr('disabled','disabled');
        
        
        $('#invoicingdiv').slideDown();

        $(".discount").show(); $(".discountperc").show(); 
        $("#paid").focus();
        $("#CurrentAction").html('Invoicing Customer Order . . .');
        $("#CurrentActionDiv").css('background-color','#10c469');
        
        $("#CurrentActionIcon").removeClass('ti-shopping-cart-full');
        $("#CurrentActionIcon").removeClass('ti-shopping-cart');
        $("#CurrentActionIcon").removeClass('ti-spray');
        $("#CurrentActionIcon").addClass('ti-money');
    }

    function showCalendarOverlay(){
        var h = $('#printbill').height();
        var w = $('#printbill').width();
        $('#calendarOverlay').css({
            'width' : w + 16,
            'height' : h
        });
        $('#calendarOverlay').show();
    }
   

</script>
