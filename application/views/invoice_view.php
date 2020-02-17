<style>
    .mouse-cursor{
        
    }
</style>  
<div class="wrapper">
            <div class="container">
                <!-- Page-Title -->
                <div class="row hidden-print">
                    <div class="col-sm-12">
                        <div class="btn-group pull-right m-t-15">
                            <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Taxes <span class="m-l-5"><i class="fa fa-cog"></i></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="javascript:void(0);" onclick="enabletaxes('yes');">Enable Taxes</a></li>
                                <li><a href="javascript:void(0);" onclick="enabletaxes('no');">Disable Taxes</a></li>
                                
                            </ul>
                        </div>
                        <h4 class="page-title">Invoice </h4>
                    </div>
                    <?php if(isset($balance)){ if(sizeof($balance)>0 ){?>
                    <div class="row hidden-print" >
                        <div class="col-sm-12" >
                            <div class="alert alert-danger">
                                <h3 >
                                    There are BALANCES pending for <?php echo $visit[0]['customer_name'];?> : 
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
                    <?php if(isset($advance_comments)){if(sizeof($advance_comments)>0 ){ foreach($advance_comments as $ac){?>
                    <?php if(isset($ac['advance_remarks']) && $ac['advance_remarks']!==""){?>
                    <div class="row hidden-print" >
                        <div class="col-sm-12" >
                            <div class="alert alert-info" >
                                <h4 >
                                    <?php echo $ac['advance_remarks'];?>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <?php }}} }?>
                    <?php if(isset($visit[0]['advance_comment']) && $visit[0]['advance_comment']!==null){
                       ?>
                        <div class="row hidden-print">
                            <div class="col-sm-12" >
                                <div class="alert alert-warning"  style="color:#000 !important">
                                   
                                        <?php echo $visit[0]['advance_comment'];?>
                                    
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="pull-left">
                                        <h3 class="logo invoice-logo"><?php if(isset($business)){ echo "<img src='".base_url().'assets/images/business/'.$business[0]['business_logo']."' alt='".$business[0]['business_name']."' class='img-responsive' />";} else {echo 'SalonPK';}?></h3>
                                    </div>
                                    <div class="pull-right">
                                        <h4 class="img-">Visit # <br>
                                            <strong id="invoicenumber"><?php echo  date("Y").'-'.date("m").'-'; if(isset($visit[0]['id_customer_visits'])){ echo sprintf("%04s", $visit[0]['id_customer_visits']);}else{echo '00001';} ?></strong>
                                        </h4>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-left m-t-10">
                                            <input name="visitid" id="visitid" type="hidden" value="<?php echo $visit[0]['id_customer_visits']; ?>"/>
                                            
                                            <input name="customerid" id="customerid" type="hidden" value="<?php echo $visit[0]['id_customers']; ?>">
                                            <input name="customername" id="customername" type="hidden" value="<?php echo $visit[0]['customer_name']; ?>">
                                            <input name="customercell" id="customercell" type="hidden" value="<?php echo $visit[0]['customer_cell']; ?>">
                                            
                                            <input name="txtinvoiceid" id="txtinvoiceid" type="hidden" value=""/>
                                            <input name="loyaltypoints" id="loyaltypoints" type="hidden" value="<?php if(isset($customer_points)&& sizeof($customer_points)>0){ echo $customer_points[0]['loyalty_points'];} else {echo '0';} ?>"/>
                                            
                                            <?php if($services[0]['loyalty_service']=='Y' && $visit[0]['id_customers']>1) {?>
                                            Loyalty Customer Free Service : Points used <input name="loyaltyused" id="loyaltyused" readonly="readonly" style="border:none" value="<?php echo $loyalty_service[0]['required_points']; ?>"/>
                                            <?php } else { ?>
                                                <input name="loyaltyused" id="loyaltyused" type="hidden" value="0"/>
                                            <?php } ?>
                                            
                                            <input name="loyaltyrate" id="loyaltyrate" type="hidden" value="<?php echo $business[0]['l_point_discount']; ?>"/>
                                            <input name="loyaltyvalue" id="loyaltyvalue" type="hidden" value="<?php echo $business[0]['l_point_value']; ?>"/>
                                            <input name="loyaltyenabled" id="loyaltyenabled" type="hidden" value="<?php echo $business[0]['loyalty_enable']; ?>"/>
                                            <input name="sloyaltyenabled" id="sloyaltyenabled" type="hidden" value="<?php echo $business[0]['s_loyalty']; ?>"/>
                                            <input name="rloyaltyenabled" id="rloyaltyenabled" type="hidden" value="<?php echo $business[0]['r_loyalty_enable']; ?>"/>
                                            <input name="loyaltymode" id="loyaltymode" type="hidden" value="<?php echo $business[0]['loyalty_mode']; ?>"/>
                                            
                                            <input name="customeradvance" id="customeradvance" type="hidden" value="<?php if(isset($customer_points)&& sizeof($customer_points)>0){  echo $customer_points[0]['retained']; } else {echo '0';} ?>"/>
                                            <input name="retainedused" id="retainedused" type="hidden" value="No"/>
                                            <input name="retainedamountused" id="retainedamountused" type="hidden" value="0"/>
                                            <input name="remainingretained" id="remainingretained" type="hidden" value="<?php if(isset($customer_points)&& sizeof($customer_points)>0){  echo $customer_points[0]['retained']; } else {echo '0';} ?>"/>
                                            <input name="discount_pw" id="discount_pw" type="hidden" value="<?php if(isset($business[0]['discount_pw'])){ echo $business[0]['discount_pw'];}else{echo "Y";} ?>" >
                                            
                                            <address>
                                              <strong><?php echo $visit[0]['customer_name']; ?></strong><br>
                                              <?php echo $visit[0]['customer_address']; ?><br>
                                              <?php echo $visit[0]['customer_email']; ?><br>
                                              <abbr title="Phone">P:</abbr> <?php 
                                                    if( $this->session->userdata('hide_cell') && $this->session->userdata('hide_cell') == "No"){ 
                                                        echo $visit[0]['customer_cell']; 
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

                                
                                <?php $exist_product = array(); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="">
                                            <table class="table m-t-10" id="tblservices">
                                                <thead>
                                                    <tr>
                                                        <th class="hidden-print">#</th>
                                                        <th class="hidden-print">Item</th>
                                                        <th>Description</th>
                                                        <th>Staff</th>
                                                        <th class="hidden-print">Requested</th>
                                                        <th class="hidden-print">Products</th>
                                                        <th>Discount(Rs)</th>
                                                        <th class="hidden-print">Discount(%)</th>
                                                        <th class="hidden-print">Discount(Type)</th>
                                                        <th>Service Cost</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $subtotal=0; if(isset($services)){
                                                        $x=1; $i=0;
                                                        foreach($services as $service){
                                                            $subtotal=$subtotal+$service['service_rate'];
                                                        ?>
                                                    <tr id="idtr">
                                                            <td class="hidden-print"><?php echo $x;?></td>
                                                            <td class="hidden-print"><?php echo $service['service_category']; ?></td>
                                                            <td>
                                                                <input type="hidden" name="service_ids" value="<?php echo $service['id_business_services']; ?>">
                                                                <input type="hidden" name="visit_service_ids" value="<?php echo $service['id_visit_services']; ?>">
                                                                <input type="hidden" name="service_flag" value="<?php echo $service['service_flag']; ?>">
                                                                <?php echo $service['service_name']; ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $staff_names = ''; $requested='No';
                                                                
                                                                foreach($staffs as $staff){
                                                                    if($service['id_visit_services'] === $staff['visit_service_id']){
                                                                        $staff_names .= $staff['staff_name']."<br>";
                                                                    }
                                                                    if($staff['requested'] === 'Yes'){$requested='Yes';} 
                                                                }
                                                                echo $staff_names;
                                                                ?>
                                                            </td>
                                                            <td class="hidden-print">
                                                                <input type="checkbox" name="requested" class="checkbox checkbox-primary" <?php if($requested==='Yes'){echo 'checked="checked"';}?>  /> 
                                                            </td>
                                                            <td class="hidden-print" onclick="product_edit('<?php echo $service['id_business_services']."_".$x; ?>');" style="cursor: pointer;" id="<?php echo $service['id_business_services']."_".$x; ?>">
                                                                <?php
                                                                $product_names = '';
                                                                foreach($products as $product){
                                                                    if($service['id_visit_services'] === $product['visit_service_id']){
                                                                        $product_names .= $product['product_name']."<br>";
                                                                    }
                                                                }
                                                                echo $product_names;
                                                                ?>
                                                            </td>
                                                            <?php if($service['loyalty_service']=='N'){?>
                                                            <td>
                                                                <div class="col-lg-12">
                                                                    <div class="form-inline">
                                                                        <input  onclick="single_discount_pass('<?php echo $service['id_business_services']; ?>');" style="border:none; width: 60px;" onkeyup="javascript:discount_by_service(this.value, '<?php echo $service['id_business_services']."_".$x; ?>');" class="numeric discount_by_service" type="text" name="discount_by_service" id="discount_by_service<?php echo $service['id_business_services']."_".$x; ?>" placeholder="0" readonly="readonly"  />                                                                    
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="hidden-print">
                                                                <div class="col-lg-12">
                                                                    <div class="form-inline">
                                                                        <input  onclick="single_discount_pass('<?php echo $service['id_business_services']; ?>');" style="border:none; width: 40px;" onblur="javascript:perc_discount_service(this.value, '<?php echo $service['id_business_services']."_".$x; ?>');" class="numeric perc_discount_service" type="text" name="perc_discount_service" id="perc_discount_service<?php echo $service['id_business_services']."_".$x; ?>" placeholder="0" readonly="readonly" />
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="hidden-print">
                                                                <div class="col-lg-12">
                                                                    <div class="form-inline">
                                                                        <select class="form-control" name="discount_type" id="discount_type_<?php echo $service['id_business_services']."_".$x; ?>">
                                                                            <option id=""></option>
                                                                            <?php if(sizeof($discount_types)>1){?>
                                                                                <?php foreach($discount_types as $dt){ ?>
                                                                                <option id="<?php echo $dt['discount_reason']; ?>"><?php echo $dt['discount_reason']; ?></option>
                                                                                <?php } ?>
                                                                            <?php }else { ?>
                                                                            <option id="Normal">Normal</option>
                                                                            <option id="Promotion">Promotion</option>
                                                                            <option id="Promotion">Lapse</option>
                                                                            <option id="Birthday">Birthday</option>
                                                                            <option id="New Customer">New Customer</option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td >Rs.<span class="combat" id="unitcost<?php echo $service['id_business_services']."_".$x; ?>"><?php echo $service['service_rate']; ?></span><input type="hidden" name="orignal_service_rate" id="orignal_service_rate<?php echo $service['id_business_services']."_".$x; ?>" value="<?php echo $service['service_rate']; ?>" />
                                                            </td>
                                                            <?php } else { ?>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td >Rs.<span class="combat" id="unitcost<?php echo $service['id_business_services']."_".$x; ?>">0.00</span><input type="hidden" name="orignal_service_rate" id="orignal_service_rate<?php echo $service['id_business_services']."_".$x; ?>" value="0.00" /></td>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php $x++; $i++;}} ?>

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
                                        <p class="text-right"><b>Total Before Discount:</b>   Rs.<input id="txt_org_subtotal" class="form-inline" readonly="readonly" style="width: 80px; border: none;" value='<?php echo number_format((float)$subtotal, 2, '.', '');?>'>
                                        <?php if($service['loyalty_service']=='N'){?>
                                        <p class="text-right"><b>After Service Discounts:</b>   Rs. <input id="txtsubtotal" class="form-inline" readonly="readonly" style="width: 80px; border: none;" value='<?php echo number_format((float)$subtotal, 2, '.', '');?>'></p>
                                        <p class="text-right">Discount %: <input readonly class="numeric" id="txtdiscountperc" onchange="calcdiscount_perc();" class="form-inline " style="width: 80px; border: none;" value="0"/></p>
                                        <p class="text-right">Discount <span id="txtloyalty"></span> Rs.: <input readonly class="numeric" id="txtdiscount" onchange="updatetotal();" class="form-inline " style="width: 80px; border: none;" value="0"/></p>
                                        <?php } else { ?>
                                        <p class="text-right"><b>After Service Discount:</b>   Rs. <input id="txtsubtotal" class="form-inline" readonly="readonly" style="width: 80px; border: none;" value='0.00'></p>
                                        <p class="text-right">Discount %: <input readonly class="numeric" id="txtdiscountperc" class="form-inline " style="width: 80px; border: none;" value="0"/></p>
                                        <p class="text-right">Discount <span id="txtloyalty"></span> Rs.: <input readonly class="numeric" id="txtdiscount" class="form-inline " style="width: 80px; border: none;" value="0"/></p>
                                        <?php } ?>
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
                                                <input class="cccharge" id="txtcc_charge" name="txtcc_charge"  class="form-inline " style="width: 80px; border: none;" value="0" />
                                            </p>
                                            
                                        </div>
                                        <input id="cc_charge" type="hidden" value="<?php echo $business[0]['cc_charge'];?>">
                                        <p class="text-right">Total Payable Amount:   Rs. <input id="txttotalpayable" readonly="readonly" class="form-inline " style="width: 80px; border: none;"/></p>
                                        <hr>
                                        
                                        <h4 class="text-right text-custom">Advance Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly"  id="txtadvance"  name="txtadvance" value="<?php echo number_format((float)$advances[0]['advance_amount'], 2, '.', '');?>"/></h4>
                                        <h3 class="text-right text-success">  Rs. <input class="numeric" style="text-align: right; width: 100px; border: none;" readonly="readonly" id="grandtotal"  name="grandtotal"/></h3>
                                        
                                        <h4 class="text-right hidden-print">Paying Now Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" onchange="updatetotal();" onclick="$(this).select();" id="paid"  name="paid" value="0"/></h4>
                                        <h4 id="payingcash" class="text-right hidden-print" style="display:none;">Cash Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" onchange="updatepaying();" onclick="$(this).select();" id="cashpaid"  name="cashpaid" value="0"/></h4>
                                        <h4 id="payingcard" class="text-right hidden-print" style="display:none;">Card Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" onchange="updatepayingcard();" onclick="$(this).select();" id="cardpaid"  name="cardpaid" value="0"/></h4>
                                        
                                        
                                        <h4 class="text-right text-primary hidden-print"><input id="keepadv" type="checkbox" <?php if($visit[0]['id_customers']<=1){ echo 'disabled="disabled"';} ?>> <span>Retain?</span> Return Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly" id="returnamount"  name="returnamount" value="0"></h4>
                                        <h4 class="text-right text-danger hidden-print">  Balance Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly" id="balanceamount"  name="balanceamount" value="0"></h4>
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
                                        <?php if((float)$visit[0]['advance_amount']<=0 && $visit[0]['id_customers']>1){ ?>
                                        <span name="txtcustomeradvance" style="<?php if(isset($customer_points) && sizeof($customer_points)>0){ if((Float)$customer_points[0]['retained']<=0){ echo 'display:none;'; }}else {echo 'display:none';}?> font-weight: bold;" class="text-custom" id="txtcustomeradvance">Customer's Retained Amount Available: <?php if(isset($customer_points)&& sizeof($customer_points)>0){ echo $customer_points[0]['retained'];} else {echo '0';} ?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        <a style='<?php if(isset($customer_points)&& sizeof($customer_points)>0){if((Float)$customer_points[0]['retained']<=0){ echo 'display:none;'; }}else{echo 'display:none';}?>' href="javascript:void(0);" onclick="usecustomeradvance();" class="btn btn-custom waves-effect waves-light" id="btncustomeradvance">Use</a>
                                        <?php } ?>
                                    </div>
                                    <div class="pull-right">
                                        <?php if($visit[0]['id_customers']>1){ ?>
                                            <span   name="txtloyaltypoints" style="<?php if($business[0]['loyalty_enable']==='N'){ echo 'display:none;'; }?> font-weight: bold;" class="text-success" id="txtloyaltypoints">Customer's Loyalty Points: <?php if(isset($customer_points)&& sizeof($customer_points)>0){echo $customer_points[0]['loyalty_points'];}else {echo 0;} ?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                            <a style='<?php if($business[0]['loyalty_enable']==='N' || $services[0]['loyalty_service']=='Y'){ echo 'display:none;'; }?>' href="javascript:void(0);" onclick="loyaltydiscount('<?php echo $business[0]['loyalty_mode'];?>')" class="btn btn-success waves-effect waves-light" id="btnloyalty">Redeem Loyalty</a>
                                        <?php } ?>
                                        <div class="btn-group m-r-10 dropup">
                                            <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Payment mode <span class="m-l-5"><i class="fa fa-money"></i></span></button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="javascript:void(0);" onclick="opencash();">Cash</a></li>
                                                <li><a href="javascript:void(0);" onclick="opencc();">Credit Card</a></li>
                                                
                                                <li><a href="javascript:void(0);" onclick="opendc();">Debit Card</a></li>
                                                
                                                <li><a href="javascript:void(0);" onclick="openbank('Check');">Check</a></li>
                                                <li><a href="javascript:void(0);" onclick="openvoucher('Voucher');">Voucher</a></li>
                                                <li><a href="javascript:void(0);" onclick="openmixed('Mixed');">Mixed</a></li>
                                                <!--<li><a href="javascript:void(0);" onclick="openbalance('Balance');">Balance</a></li>-->
                                            </ul>
                                        </div>
                                        <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light" id="btnprint" ><i class="fa fa-print"></i></a>
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
                
                  <!--Add Product Modal-->
        <div id="product-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="product-modal" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Product Update</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product1" class="control-label">Products</label>
                                            <select id="product1" name="product1" class="form-control" multiple></select>
                                            <span class="text-danger selectexist"></span>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product2" class="control-label">&nbsp;</label>
                                            <select id="product2" name="product2[]" class="form-control" multiple></select>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="vid" id="vid" />
                        <input type="hidden" name="visit_id_customer" id="visit_id_customer" value="<?php echo $this->input->post('visit-id'); ?>" />
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="product_update();" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Product Modal-->
        
        <!--Add Color Record Modal-->
        <div id="addlist" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addlist" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
<!--                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a Color Record</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txttype" class="control-label">Color Type</label>
                                            <select id="txttype" name="txttype" class="form-control">
                                                <option value=""></option>
                                                <?php
                                                if (isset($color_type_list)) {
                                                    foreach ($color_type_list as $color_type) {
                                                        if ($color_type['status'] == "Yes") {
                                                            ?>
                                                            <option value="<?php echo $color_type['id']; ?>"><?php echo $color_type['type']; ?></option>
                                                        <?php }
                                                    }
                                                } ?>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtdate" class="control-label">Date</label>
                                            <input type="text" class="form-control" placeholder="Date" id="txtdate" name="txtdate">
                                        </div> 
                                    </div> 
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txttime" class="control-label">Duration (in minutes)</label>
                                            <input type="text" class="form-control numeric" placeholder="Time" id="txttime" name="txttime">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcharge" class="control-label">Charge</label>
                                            <input type="text" class="form-control numeric" placeholder="Charge" id="txtcharge" name="txtcharge">
                                        </div> 
                                    </div> 
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txttypenumber" class="control-label">Color</label>
                                            <input class="form-control" type="text" name="txttypenumber" id="txttypenumber" />
                                        </div> 
                                    </div> 
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtw_content" class="control-label">Water Content</label>
                                            <select class="form-control" name="txtw_content" id="txtw_content">
                                                <?php foreach ($WaterContent as $content){ ?>
                                                    <option value="<?php echo $content['content']; ?>"><?php echo $content['content']; ?></option>
                                                    <?php } ?>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txtcolorremarks" class="control-label">Remarks</label>
                                    <textarea id="txtcolorremarks" name="txtcolorremarks" class="form-control"></textarea>
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txtrecommendation" class="control-label">Recommendation</label>
                                    <textarea id="txtrecommendation" name="txtrecommendation" class="form-control"></textarea>
                                </div> 
                            </div> 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button onclick="updateHairColorHistory();" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Color Record Modal-->

        <!--Add Facial Modal-->
        <div id="addfacial" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addfacial" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    
                        <div class="modal-header">
                            <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
                            <h4 class="modal-title" id="custom-width-modalLabel">Add a Facial Record</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtdate" class="control-label">Date</label>
                                                <input type="text" readonly="readonly" class="form-control" value="<?php echo date('Y-m-d'); ?>" placeholder="Date" name="txtfacialdate" id="txtfacialdate">
                                            </div> 
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtexfoliant" class="control-label">Exfoliant</label>
                                                <input type="text" class="form-control" placeholder="Exfoliant" id="txtfacialexfoliant" name="txtfacialexfoliant">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtcleanser" class="control-label">Cleanser</label>
                                                <input type="text" class="form-control" placeholder="Cleanser" id="txtfacialcleanser" name="txtfacialcleanser">
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtcharge" class="control-label">Charge</label>
                                                <input type="text" class="form-control numeric" placeholder="Charge" id="txtfacialcharge" name="txtfacialcharge">
                                            </div> 
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txttime" class="control-label">Duration (minutes)</label>
                                                <input type="text" class="form-control numeric" placeholder="Time" id="txtfacialtime" name="txtfacialtime">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtmask" class="control-label">Mask</label>
                                                <input type="text" class="form-control" placeholder="Mask" id="txtfacialmask" name="txtfacialmask">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtfacial" class="control-label">Facial name</label>
                                                <input type="text" class="form-control" placeholder="Flash" id="txtfacial" name="txtfacial">
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txtfacialremarks" class="control-label">Remarks</label>
                                        <textarea id="txtfacialremarks" name="txtfacialremarks" class="form-control"></textarea>
                                    </div> 
                                </div> 
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!--<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>-->
                            <button type="button" onclick="updateFacialRecord();" class="btn btn-custom waves-effect waves-light">Save</button>
                        </div>
                   
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Facial Modal-->
        <!--Add Add eyelash Modal-->
        <div id="addeyelashrecord" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addeyelashrecord" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="addlistForm" action="<?php echo base_url("eyelashes_controller/add_eyelashes"); ?>" method="POST">
                        <div class="modal-header">
                            <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
                            <h4 class="modal-title" id="custom-width-modalLabel">Add a Eyelashes Record</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txttypeoflashes" class="control-label">Type of Lashes</label>
                                                <select name="txttypeoflashes" id="txttypeoflashes" class="form-control">
                                                    <option value=""></option>
                                                    <?php foreach($eyelashtypes as $eyelashtype){?>
                                                        <option value="<?php echo $eyelashtype['eyelash_type']; ?>"><?php echo $eyelashtype['eyelash_type']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div> 
                                        </div> 
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txteyelashthickness" class="control-label">Thickness</label>
                                                <select name="txteyelashthickness" id="txteyelashthickness" class="form-control">
                                                    <option value=""></option>
                                                    <option value="0.02">0.02</option>
                                                    <option value="0.04">0.04</option>
                                                    <option value="0.07">0.07</option>
                                                    <option value="0.10">0.10</option>
                                                    <option value="0.15">0.15</option>
                                                    <option value="0.20">0.20</option>
                                                    <option value="0.25">0.25</option>
                                                </select>
                                            </div> 
                                        </div> 
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txteyelashdate" class="control-label">Date</label>
                                                <input type="text" class="form-control" placeholder="Date" value="<?php echo date('Y-m-d'); ?>" readonly="readonly" id="txteyelashdate" name="txteyelashdate">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txteyelashdate" class="control-label">Price</label>
                                                <input type="text" class="form-control" placeholder="Price" value=""  id="txteyelashprice" name="txteyelashprice">
                                            </div> 
                                        </div> 
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txteyelashlength" class="control-label">Length</label>
                                                <!--<input name="txteyelashlength" required id="txteyelashlength" class="form-control multinumeric" />-->
                                                <select name="txteyelashlength" id="txteyelashlength" multiple="multiple" class="form-control">
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                </select>
                                            </div> 
                                        </div> 
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txteyelashcurl"  class="control-label">Curl</label>
                                                <select name="txteyelashcurl" required id="txteyelashcurl" class="form-control">
                                                    <option value=""></option>
                                                    <option value="C" selected="selected">C</option>
                                                    <option value="J">J</option>
                                                    <option value="B">B</option>
                                                    <option value="D">D</option>
                                                </select>
                                            </div> 
                                        </div> 
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="row"></div>
                                                <div class="row">&nbsp;</div>
                                                <label class="radio-inline">
                                                    <input type="radio" checked="checked" value="Full set" name="txt_full_set_refill" id="txt_full_set_refill1"> Full set
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" value="Refill" name="txt_full_set_refill" id="txt_full_set_refill2"> Refill
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" value="Removal" name="txt_full_set_refill" id="txt_full_set_refill3"> Removal
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" value="Fix" name="txt_full_set_refill" id="txt_full_set_refill4"> Fix
                                                </label>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txteyelashremarks" class="control-label">Remarks</label>
                                        <textarea id="txteyelashremarks" name="txteyelashremarks" class="form-control"></textarea>
                                    </div> 
                                </div> 
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!--<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>-->
                            <button type="button" onclick="addeyelashrecord();" class="btn btn-custom waves-effect waves-light">Save</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End EyeLash Modal-->
                <input type="hidden" name="uid" id="uid" />
                <input type="hidden" name="uname" id="uname" />
                <input type="hidden" name="uusername" id="uusername" />
                <input type="hidden" name="uemail" id="uemail" />
                <input type="hidden" name="ddiscount_remarks" id="ddiscount_remarks" value="<?php if($services[0]['loyalty_service']=='Y'){echo "Loyalty Points Used to Avail Free Service";} else {echo "";} ?>" />

<?php include 'js_functions/service_invoice_js.php'; ?>                
<script>
    var enabtax=false;
    
    $(document).ready(function(){
        $("#txteyelashlength").select2();
        
        
        <?php if($business[0]['tax_optional'] === 'No'){ ?>
            enabletaxes('yes');
        <?php } ?>
        
        <?php if($color_record === TRUE &&  $business[0]['force_extra_record']=='Y'){ foreach($services as $service){ ?>
            <?php if($service['service_type'] === 'Hair Color'){ ?>
                $('#addlist').modal({
                    backdrop:'static',
                    keyboard:false,
                    show:true
                });
            <?php } ?>
        <?php } } ?>
            
            
        <?php if($facial_record === TRUE &&  $business[0]['force_extra_record']=='Y'){ foreach($services as $service){ ?>
            <?php if(stripos($service['service_type'], "facial") > -1 || stripos($service['service_category'], "facial") > -1 || stripos($service['service_name'], "facial") > -1 ){ ?>
                $("#txtfacial").val('<?php echo $service['service_name'];?>');
                $("#txtfacialcharge").val('<?php echo $service['service_rate'];?>');
                $("#txtfacialtime").val('<?php echo $service['service_duration'];?>');
                
                $('#addfacial').modal({
                    backdrop:'static',
                    keyboard:false,
                    show:true
                });
            <?php } ?>
        <?php } } ?>    
            
        <?php if($eyelashes_record === TRUE &&  $business[0]['force_extra_record']=='Y'){ foreach($services as $service){ ?>
            <?php if(stripos($service['service_type'], "eyelahes") > -1 || stripos($service['service_category'], "eyelashes") > -1 || stripos($service['service_name'], "eyelashes") > -1 ){ ?>
                
                $("#txteyelashprice").val('<?php echo $service['service_rate'];?>');
                
                $('#addeyelashrecord').modal({
                    backdrop:'static',
                    keyboard:false,
                    show:true
                });
            <?php } ?>
        <?php } } ?>        
        
         $("#txtdate").datepicker({
            default: today,
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        }).datepicker('setDate', new Date());
   
        $("#txtcustomer").select2();
        $('#txtcustomer').select2('data', {id: $('#customerid').val(), text: $('#customername').val()});
        
        //Two Select box for services insert moving....
        $('#product1').on('change', function() {
            var val1 = $("#product1 option:selected").val();
            var txt1 = $("#product1 option:selected").text();


            $('#product2 option').each(function() {
                if($(this).attr('value') == val1){
                    alert("already exist!");die;
                }
            });

            $('#product2').append('<option selected value="'+val1+'">'+txt1+'</opiton>');

        });

        $('#product2').on('click', function() {
            $("#product2 option:selected").remove();
            $('#product2').find('option').prop('selected',true);
        });
        //end two select box..
               
        $(".numeric").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 13 && e.which != 8 && e.which != 0  && e.which != 46 && (e.which < 48 || e.which > 57)) {
               return false;
           }
        });
        $(".multinumeric").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 13 && e.which != 8 && e.which != 0  && e.which != 46 && e.which != 44 && (e.which < 48 || e.which > 57)) {
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
            $(".discount_by_service").on('click',function() {                
                if($(this).attr("readonly") && $("#btnloyalty").hasClass('btn-success')){
                    if($("#discount_pw").val()=="Y"){
                        $("#invoicepass").modal("show");
                    } else {
                        if($("#btnloyalty").hasClass('btn-success')){
                            $("#txtdiscount").attr("readonly",false);
                            $("#txtdiscountperc").attr("readonly",false);
                        }
                        $(".discount_by_service").attr("readonly",false);
                        $(".perc_discount_service").attr("readonly",false);
                    }
                }
            });
            
            $(".perc_discount_service").on('click',function() {                
                if($(this).attr("readonly") && $("#btnloyalty").hasClass('btn-success')){
                    if($("#discount_pw").val()=="Y"){
                        $("#invoicepass").modal("show");
                    } else {
                        if($("#btnloyalty").hasClass('btn-success')){
                            $("#txtdiscount").attr("readonly",false);
                            $("#txtdiscountperc").attr("readonly",false);
                        }
                        $(".discount_by_service").attr("readonly",false);
                        $(".perc_discount_service").attr("readonly",false);
                    }
                }
            });
                
            $("#txtdiscountperc").on('click',function() {                
                if($(this).attr("readonly") && $("#btnloyalty").hasClass('btn-success')){
                    if($("#discount_pw").val()=="Y"){
                        $("#invoicepass").modal("show");
                    } else {
                        if($("#btnloyalty").hasClass('btn-success')){
                            $("#txtdiscount").attr("readonly",false);
                            $("#txtdiscountperc").attr("readonly",false);
                        }
                        $(".discount_by_service").attr("readonly",false);
                        $(".perc_discount_service").attr("readonly",false);
                    }
                }
            });
            
            $("#txtdiscount").on('click',function() {
                if($(this).attr("readonly") && $("#btnloyalty").hasClass('btn-success')){
                    if($("#discount_pw").val()=="Y"){
                        $("#invoicepass").modal("show");
                    } else {
                        if($("#btnloyalty").hasClass('btn-success')){
                            $("#txtdiscount").attr("readonly",false);
                            $("#txtdiscountperc").attr("readonly",false);
                        }
                        $(".discount_by_service").attr("readonly",false);
                        $(".perc_discount_service").attr("readonly",false);
                    }
                }
            });
            
            $("#txtdiscountperc").dblclick(function() {
                if($("#btnloyalty").hasClass('btn-success')){
                    if($("#discount_pw").val()=="Y"){
                        $("#invoicepass").modal("show");
                    } else {
                        if($("#btnloyalty").hasClass('btn-success')){
                            $("#txtdiscount").attr("readonly",false);
                            $("#txtdiscountperc").attr("readonly",false);
                        }
                        $(".discount_by_service").attr("readonly",false);
                        $(".perc_discount_service").attr("readonly",false);
                    }
                }
            });
            
            $("#txtdiscount").dblclick(function() {
                if($("#btnloyalty").hasClass('btn-success')){
                    if($("#discount_pw").val()=="Y"){
                        $("#invoicepass").modal("show");
                    } else {
                        if($("#btnloyalty").hasClass('btn-success')){
                            $("#txtdiscount").attr("readonly",false);
                            $("#txtdiscountperc").attr("readonly",false);
                        }
                        $(".discount_by_service").attr("readonly",false);
                        $(".perc_discount_service").attr("readonly",false);
                    }
                }
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
                if (data !== "error"){
                    //console.log(data);
                    
                    $("#uid").val(data['id']);
                    $("#uname").val(data['name']);
                    $("#uusername").val(data['username']);
                    $("#uemail").val(data['email']);
                    $("#ddiscount_remarks").val($("#discount_remarks").val());
                    
                    $("#discount_username").val('');
                    $("#discount_password").val('');
                    $("#discount_remarks").val('');
                    if($("#btnloyalty").hasClass('btn-success')){
                        $("#txtdiscount").attr("readonly",false);
                        $("#txtdiscountperc").attr("readonly",false);
                    }
                    $(".discount_by_service").attr("readonly",false);
                    $(".perc_discount_service").attr("readonly",false);
                    
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
 

        $("#txtdiscount").change(function(){
            if($('#txtothercharges').val()===""){$('#txtothercharges').val(0);}
            var subtotalextra = parseFloat($('#txtsubtotal').val())+parseFloat($('#txtothercharges').val());
            var parcentage = (parseFloat($(this).val()) / subtotalextra) * 100;
            $('#txtdiscountperc').val(parcentage.toFixed(2));
            //$("#paid").val($("#grandtotal").val());
            $("#balanceamount").val(parseFloat($("#grandtotal").val()) - parseFloat($("#paid").val()));
            updatetotal();
            
        });
        
        $('#txtcc_charge').change(function(){
            updatetotal();
        });
        
        
        $('#txtdate').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
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
                var thistax=orggrosstotal*parseFloat($("#taxperc"+index).val())/100;
                $(this).val(thistax.toFixed(2));
                taxarray.push($(this).val());
            });
            for(x=0; x<taxarray.length;x++){
                nettax=nettax + parseFloat(taxarray[x]);
            }
        }
        var totalpayable=grosstotal + nettax + parseFloat($("#txtcc_charge").val());
        $("#txttotalpayable").val(totalpayable.toFixed(2));
        
        var grandtotal = (grosstotal + nettax + parseFloat($("#txtcc_charge").val())) - (parseFloat($("#txtadvance").val()));
        $("#grandtotal").val(grandtotal.toFixed(2));
        
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
        
        
        if ($('#grandtotal').val() == ""){
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
        
        if (parseInt($('#grandtotal').val()) <= 0 && parseInt($('#paid').val())-parseInt($('#txtadvance').val()) > 0){
            swal({
                title: 'Please Wait . . .',
                text: "Grand Total cannot be less then Paid Amount!",
                type: 'info',
                showCancelButton: false,
                confirmButtonColor: '#ff5b5b !important',
                confirmButtonText: 'Ok'
            });
            return false;
        }
        
        if ((parseInt($('#paid').val()) + parseInt($('#txtadvance').val())) - parseInt($('#returnamount').val()) < 0){
            swal({
                title: 'Please Wait . . .',
                text: "Paid minus return amount cannot be less then zero!",
                type: 'info',
                showCancelButton: false,
                confirmButtonColor: '#ff5b5b !important',
                confirmButtonText: 'Ok'
            });
            return false;
        }
        
        if($('#customerid').val() <= 1 && parseInt($('#paid').val()) < parseInt($('#grandtotal').val())){
            swal({
                title: 'Walk In Customer',
                text: "No Balances Allowed!",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#ff5b5b !important',
                confirmButtonText: 'Ok'
            });
            return false;
        }
        
        
        if($('#paid').val() === ''){
            return false;
        }
        
        if(parseInt($('#paid').val()) === 0 && parseInt($('#grandtotal').val()) > 0){
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
        } else if (parseInt($('#paid').val()) >= 0){
            create_new_invoice();   
        }
    }
    
    function create_new_invoice(){
        var totalServices = $('input[name=discount_by_service]').length;

        var service_discount = [];
        $('input[name=discount_by_service]').each(function(x) {
            var discount = $(this).val() === "" ? 0 : $(this).val();
            service_discount.push(parseFloat(discount));
        });
        
        var discount_type = [];
        $('select[name=discount_type]').each(function(x) {
            discount_type.push($(this).val());
        });

        var discounted_price = [];
        $('input[name=orignal_service_rate]').each(function(x) {
            discounted_price.push(parseFloat($(this).val()) - parseFloat(service_discount[x]));
        });
        
        var service_ids=[];
        $('input[name=service_ids]').each(function(x) {
            service_ids.push($(this).val());
        });
        
        
        var visit_service_ids=[];
        $('input[name=visit_service_ids]').each(function(x) {
            visit_service_ids.push($(this).val());
        });
        
        
        var service_flag=[];
        $('input[name=service_flag]').each(function(x) {
            service_flag.push($(this).val());
        });
        
        var requested=[];
        $('input[name=requested]').each(function(x) {
            if($(this).is(":checked")){
                requested.push("Yes");
            } else {
                requested.push("No");
            }
        });
//        
//        for(var x = 0; x < totalServices; x++){
//
//            var totalDiscount = parseFloat($('#txtdiscountperc').val());
//            totalDiscount = totalDiscount / 100;
//
//            var sale_price = discounted_price[x] * (1 - totalDiscount);
//
//            service_discount[x] = discounted_price[x] - sale_price;
//            discounted_price[x] = sale_price;
//
//        }

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
            url: 'invoice_controller/updateinvoice',
            data: {
                visitid: $("#visitid").val(),
                serviceids: service_ids,
                visitserviceids: visit_service_ids,
                service_flag: service_flag,
                invoicenumber:$("#invoicenumber").html(),
                invoicedate:$("#invoice_date").html(),
                customerid:$("#customerid").val(),
                customercell:$("#customercell").val(),
                subtotal:$("#txtsubtotal").val(),
                discount:$("#txtdiscount").val(),
                discount_perc:$('#txtdiscountperc').val(),
                
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
                service_discount: service_discount,
                discount_type: discount_type,
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
                requested: requested,
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
                    
                    window.location.href = '<?php echo base_url(); ?>existinginvoice/' + result[1];
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
        $("#txtdiscountperc").attr("readonly",true);
        $(".discount_by_service").attr("readonly",true);
        $(".perc_discount_service").attr("readonly",true);
        
    }
    
    function service_row_sum(){
        var theTotal = 0;
        $("table td:nth-child(10) .combat").each(function () {
            var val = $(this).text();//.replace(" ", "").replace(",-", "");
            theTotal += parseFloat(val);
        });

        $('#txtsubtotal').val(theTotal.toFixed(2));
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

    function perc_discount_service(discount, idservices) {
        //todo    
        if(discount==0){return false;}
        var orignal_unitcost = parseFloat($('#orignal_service_rate' + idservices).val());
        if (discount === "") {
            $('#unitcost' + idservices).text(orignal_unitcost.toFixed(2));
            var temp = '#discount_by_service' + idservices;
            $(temp).val('');
            service_row_sum();
        } else {
            discount = (parseFloat(discount) * orignal_unitcost) / 100;
            discount = discount.toFixed(2);
            var temp = '#discount_by_service' + idservices;
            $(temp).val(discount);
        }


        discount_by_service(parseFloat(discount), idservices);

    }
    function discount_by_service(discount, idservices) {
        var orignal_unitcost = parseFloat($('#orignal_service_rate' + idservices).val());
        // console.log(discount);
        // console.log(orignal_unitcost);
        if (discount === "") {
            $('#unitcost' + idservices).text(orignal_unitcost.toFixed(2));
            service_row_sum();
            var temp = '#perc_discount_service' + idservices;
            $(temp).val('');
        } else {
            discount = parseFloat(discount);
            var discount_rate = orignal_unitcost - discount;
            $('#unitcost' + idservices).text(discount_rate.toFixed(2));
            service_row_sum();

            var perc_discount = (100 * discount) / orignal_unitcost;
            perc_discount = perc_discount.toFixed(2);
            var temp = '#perc_discount_service' + idservices;
            $(temp).val(perc_discount);

        }
        //calcdiscount_perc();
        updatetotal();
        var x = '#discount_type_' + idservices;
        $(x).val('Normal');
    }
</script>
