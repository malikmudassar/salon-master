<div class="wrapper" style="margin-top:60px;">
    <div class="container" style="width: 100% !important">
        <!-- Page-Title -->
        <div class="row hidden-print">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15 clear-fix">
                    <?php  if($this->session->userdata('role')!=='Sh-Users'){?>
                    <form style="display:inline-block" id="retailform" method="Post" action="<?php echo base_url();?>pos_view">
                    <?php } else { ?>
                    <form style="display:inline-block" id="retailform" method="Post" action="<?php echo base_url();?>sh_pos_view">    
                    <?php } ?>
                        <input type="hidden" name="csrf_test_name" id="retailform_csrf" value=""/>
                        <input id="retailcustomer" name="customerid" type="hidden"/>
                        <button type="button" onclick="$('#retailform_csrf').val($('#cook').val()); submitretailform();" class="btn btn-warning waves-effect waves-light ">Retail</button>
                    </form>  
                    
                    <?php  if($this->session->userdata('role')!=='Sh-Users'){?>
                    <button id="btnPBooking" class="btn btn-default waves-effect waves-light" style="display:<?php if (isset($scheduler_style[0]['period_booking'])) {if ($scheduler_style[0]['period_booking'] === 'Y') {echo "inline";} else {echo "none";}} else {echo "none";} ?>">Booking</button>
                    <div class="btn-group m-l-5 pull-right">
                        <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Taxes <span class="m-l-5"><i class="fa fa-cog"></i></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:void(0);" onclick="enabletaxes('yes');">Enable Taxes</a></li>
                            <li><a href="javascript:void(0);" onclick="enabletaxes('no');">Disable Taxes</a></li>

                        </ul>
                    </div>
                    <?php } ?>
                </div>
                <?php if (isset($totalinvoices)){?>
                    <h4 class="page-title">Invoices Created: <span id="totalvisits" class="page-title"><?php echo $totalinvoices->invoices; ?></span></h4>
                <?php } else { ?>
                    <h4 class="page-title">Point of Sale (Services): </h4>
                <?php } ?>
            </div>
        </div>
        <!--End Page Title-->

        <div class="row">
            <div class="col-md-12" id="printbill">
                <div class="card-box">
                    
                    <div class="row hidden-lg hidden-md">
                        <div class="pull-left">
                            <h3 class="logo invoice-logo"><?php if(isset($business)){ echo "<img src='".base_url().'assets/images/business/'.$business[0]['business_logo']."' alt='".$business[0]['business_name']."' class='img-responsive' />";} else {echo 'SalonPK';}?></h3>
                        </div>
                        <div class="pull-right">
                            <h4 class="img-">Visit # <br>
                                <strong id="invoicenumber"><?php echo  date("Y").'-'.date("m").'-'; if(isset($invoiceno)){ echo sprintf("%04s",$invoiceno[0]['id_invoice']+1);}else{echo '00001';} ?></strong>
                            </h4>
                        </div>
                    </div>
                    
                    <div class="row" > <!--style="border:1px solid #e3e3e3; border-radius: 4px;"-->
                        <div class="col-md-12">
                            <div class="col-md-4 m-t-10">
                                <p><b>Agent ID:</b><span id="agentid"> <?php echo $userid; ?><span><b class="m-l-10">   Agent Name: </b> <span id="agent_name"><?php echo $username; ?></span></p> 
                                <p><b>Customer: <label class="text-primary" id='label-customer-name'></label></b></p>
                                <p><button id="btnedit"  type="button" onclick='openupdate();' style="display:none;" class="btn btn-sm btn-pink" >Edit</button><button id="btnaccount"  type="button" onclick='openAccount();' style="display:none;" class="btn btn-sm btn-primary m-l-10" >Account</button></p>
                                <p><b>Visit ID: <input style="border:none;" name="visitid" id="visitid" type="text" readonly="readonly" value=""/><label id="lblinservice"></label></b></p>
                                <p><b>Visit Date: <input style="border:none;" name="visitdate" id="visitdate" type="text" readonly="readonly" value=""/></b></p>
                            </div>
                            <div class="col-md-4 m-t-10 hidden-print" id="CurrentActionDiv" style="border:1px solid #f7f7f7; background: #797979 ;padding:25px 10px !important">
                                <input type="hidden" id="last_update_date">
                                <input type="hidden" id="new_update_date">
                                <input type="hidden" id="last_color_code">

                                <form id="opendirectselect" action="<?php base_url('pos_services');?>" method="post">
                                    <input type="hidden" name="csrf_test_name" id="opendirectform_csrf" value=""/>
                                    <input name="customerid" id="customerid" type="hidden" value="">
                                </form>
                                <input name="customername" id="customername" type="hidden" value="">
                                <input name="customercell" id="customercell" type="hidden" value="">
                                <input name="customeremail" id="customeremail" type="hidden" value="">
                                <input name="customeraddress" id="customeraddress" type="hidden" value="">
                                
                                <input name="txtinvoiceid" id="txtinvoiceid" type="hidden" value=""/>
                                

                                <input name="loyaltyused" id="loyaltyused" type="hidden" value="0"/>

                                <input name="loyaltyrate" id="loyaltyrate" type="hidden" value="<?php echo $business[0]['l_point_discount']; ?>"/>
                                <input name="loyaltyvalue" id="loyaltyvalue" type="hidden" value="<?php echo $business[0]['l_point_value']; ?>"/>
                                <input name="loyaltyenabled" id="loyaltyenabled" type="hidden" value="<?php echo $business[0]['loyalty_enable']; ?>"/>
                                <input name="sloyaltyenabled" id="sloyaltyenabled" type="hidden" value="<?php echo $business[0]['s_loyalty']; ?>"/>
                                <input name="loyaltymode" id="loyaltymode" type="hidden" value="<?php echo $business[0]['loyalty_mode']; ?>"/>

                                <input name="customeradvance" id="customeradvance" type="hidden" value="0"/>
                                <input name="retainedused" id="retainedused" type="hidden" value="No"/>
                                <input name="retainedamountused" id="retainedamountused" type="hidden" value="0"/>
                                <input name="remainingretained" id="remainingretained" type="hidden" value="0"/>
                                <input name="discount_pw" id="discount_pw" type="hidden" value="<?php if(isset($business[0]['discount_pw'])){ echo $business[0]['discount_pw'];}else{echo "Y";} ?>" >
                                
                                <i id="CurrentActionIcon" style="font-size:75px; color:#fff; " class="fa fa-hourglass-1"></i>
                                <span id="CurrentAction" style="font-size:21px; color:#fff; padding-left: 20px;" >Search Customer . . . </span>
                                
                            </div>
                            
                            <div class="col-md-4 m-t-10 hidden-print" style="text-align: right;">
                                <p><strong>Invoice Date: </strong><span id="invoicedate"> <?php echo date('d-m-Y'); ?></span></p>
                                
                                <form id="inservicevisitform" action="<?php base_url('pos_services');?>" method="post">
                                    <input type="hidden" name="csrf_test_name" id="inservicevisitform_csrf" value=""/>
                                    <div class="form-group row" style="float:right; display:inline-block">
                                        <div class="col-md-8 col-sm-8">
                                            <select id="inservicevisits" onchange="$('#id_customer_visit1').val($(this).val());" class="form-control text-success" style="width: 250px;">
                                                <option customerid="0" value='0'>Clients Being Serviced</option>
                                                <?php foreach($inservice as $visit){?>
                                                <option customerid="<?php echo $visit['id_customers'];?>" value="<?php echo $visit['id_customer_visits']; ?>"><?php echo $visit['mDate']; ?> <?php echo $visit['customer_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <input type ="hidden" id="id_customer_visit1" name="id_customer_visit">
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <button type="button" onclick="submitinvoicevisit();" class="btn btn-success btn-icon"><i class="ti ti-spray"></i> Get</button>
                                        </div>
                                    </div>
                                </form>
                                
                                <form id="openvisitform" action="<?php base_url('pos_services');?>" method="post">
                                    <input type="hidden" name="csrf_test_name" id="openvisitform_csrf" value=""/>
                                    <div class="form-group row" style="float:right; display:inline-block">
                                        <div class="col-md-8 col-sm-8">
                                            <select id="openvisits" onchange="$('#id_customer_visit').val($(this).val());" class="form-control" style="width: 250px;">
                                                <option customerid="0" value='0'>All Appointments</option>
                                                <?php foreach($visits as $visit){?>
                                                <option customerid="<?php echo $visit['id_customers'];?>" value="<?php echo $visit['id_customer_visits']; ?>"><?php echo $visit['mDate']; ?> <?php echo $visit['customer_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <input type ="hidden" id="id_customer_visit" name="id_customer_visit">
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <button type="button" onclick="submitopenvisit();" class="btn btn-primary btn-icon"><i class="ti ti-calendar"></i> Get</button>
                                        </div>
                                    </div>
                                </form>
                                
                                <form id="openfresh" action="<?php base_url('pos_services');?>" method="post"> 
                                    <input type="hidden" name="csrf_test_name" id="openfresh_csrf" value=""/>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!--Balances and Advance comments-->
                    <div class="row hidden-print" id="customerbalancediv" style="display: none;">
                        <div class="col-sm-12" >
                            <div class="alert alert-danger">
                                <h3 >
                                    There are BALANCES pending for <span id="customerbalance"></span>
                                    
                                </h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row hidden-print" id="customeralertdiv" style="display: none;">
                        <div class="col-sm-12" >
                            <div class="alert alert-info">
                                <h4 >
                                    <span id="customeralert"></span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row hidden-print" id="visitalertdiv" style="display: none;">
                        <div class="col-sm-12" >
                            <div class="alert alert-info">
                                <h4 >
                                    <span id="visitalert"></span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <!--Balances End-->
                    
                    <!--Search-->
                    <div class="row m-t-10 hidden-print" style="border:1px solid #e3e3e3; border-radius: 4px; background:#fcfcfc; ">
                        <div class="col-md-12">
                            <div class="row m-t-10" style="padding:10px;">        
                                <div class="col-md-2 col-sm-10">
                                    <div class="form-group ">
                                        <input  type="text" id="txt-customer-search" name="txt-customer-search" onkeypress="update_addnew();" onchange='on_customer_change();' placeholder="Select Customer"  class="form-control" >
                                    </div>
                                </div>

                                <div class="col-md-1 col-sm-2">
                                    <div class="form-group ">
                                        <button  id="btnaddcustomer" type="button" onclick="openaddnew();" class="btn btn-pink btn-sm m-t-5" >Add</button>
                                    </div>
                                </div>


                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <!--<input type="text" class='form-control' onchange="on_service_change();" id="visit-services" name="visit-services"  placeholder="Select Service . . . . . . . . . ." >-->

                                        <select id="visit-services" name="visit-services" class='form-control' onchange="on_service_change();" placeholder="Select Service . . . ."  >

                                            <?php foreach($type_list as $type){ ?>
                                            <optgroup label='<?php echo $type['service_type']; ?>'>
                                            </optgroup>
                                                <?php foreach($category_list as $category){if($category['service_type_id']==$type['id_service_types']){?>
                                                <optgroup label='<?php echo $category['service_category'];?>'>
                                                    <?php foreach($services_list as $service){ if($category['id_service_category']==$service['service_category_id']){?>
                                                    <option service_rate="<?php echo $service['service_rate']?>" service_type="<?php echo $type['service_type'];?>" service_category="<?php echo $category['service_category']; ?>" service_name="<?php echo $service['service_name']; ?>" service_duration="<?php echo $service['service_duration']; ?>" flag="<?php echo $service['flag']; ?>" id_service_category="<?php echo $service['service_category_id']; ?>" id_business_services="<?php echo $service['id_business_services']; ?>" value="<?php echo $service['id_business_services'].'-'.$category['id_service_category']; ?>">
                                                        <?php echo $service['service_name'];?><span style="float:right;"> <?php echo $service['service_rate']; ?></span>
                                                    </option>
                                                    <?php }} ?>
                                                </optgroup>
                                                <?php }} ?>                                        
                                            <?php } ?>
                                            <?php foreach($package_type_list as $type){ ?>
                                            <optgroup label='<?php echo $type['service_type']; ?>'>
                                            </optgroup>
                                                <?php foreach($package_category_list as $category){if($category['package_type_id']==$type['id_package_type']){?>
                                                <optgroup label='<?php echo $category['service_category'];?>'>
                                                    <?php foreach($package_services_list as $service){ if($category['id_package_category']==$service['package_category_id']){?>
                                                    <option service_rate="<?php echo $service['package_service_rate']?>" service_type="<?php echo $type['service_type'];?>"  service_category="<?php echo $category['service_category']; ?>" service_name="<?php echo $service['service_name']; ?>" service_duration="<?php echo $service['service_duration']; ?>" flag="<?php echo $service['flag']; ?>" id_service_category="<?php echo $service['package_category_id']; ?>" id_business_services="<?php echo $service['id_business_services']; ?>" value="<?php echo $service['id_business_services'].'-'.$category['id_package_category']; ?>">
                                                        <?php echo $service['service_name'];?> <?php echo $service['service_rate']; ?>
                                                    </option>
                                                    <?php }} ?>
                                                </optgroup>
                                                <?php }} ?>                                        
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
<!--                                <div class="col-md-1 col-sm-2">
                                    <div class="form-group ">
                                        <button id="btnpickservice" type="button" onclick="openservicesmodal();" class="btn btn-pink btn-sm m-t-5" >Pick</button>
                                    </div>
                                </div>-->

                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group ">
                                        <select class='form-control' onchange="on_staff_change();"  placeholder="Select Staff" multiple="multiple" id="visit-staff" name="visit-staff[]" > 
                                            <?php foreach ($staff_list as $staff) { ?>
                                            <option value="<?php echo $staff->id_staff; ?>"><?php echo $staff->staff_fullname; ?></option>
                                            <?php } ?>
                                        </select>                                
                                    </div>
                               </div>
                                <div class="col-md-1 col-sm-12">
                                    <div class="input-group">
                                        <div class="bootstrap-timepicker">
                                            <input id="visit-time" onchange='onVisitTimeChange();' data-date-format="HH:mm" data-date-useseconds="false" type="text" class="form-control">
                                        </div>
                                        <!--<span class="input-group-addon bg-primary b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>-->
                                    </div>
                               </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="input-group">
                                        <input type="text" onchange='onVisitDateChange();' class="form-control" placeholder="mm/dd/yyyy" id="visit-date">
                                        <!--<span class="input-group-addon bg-primary b-0 text-white"><i class="ti-calendar"></i></span>-->
                                    </div>
                               </div>                        
                                <div class="col-md-1 col-sm-12">
                                        <button onclick='$(this).hide(); visit_mode(); getserviceproducts(); $(".discount").show(); $(".discountperc").show();  updatetotal();'  type='button' id="btn-add" class='btn btn-sm btn-purple waves-effect m-t-5'>Add <i class='ti-arrow-circle-down'></i></button>
                                </div>
                            </div>

                        </div>
                       
                    </div>
                    
                    <!--Search End-->
                    <!--Visit Details-->
                    <div class="row">  
                       <div class="col-md-12"     
                            <!--Table-->
                           <div class="row">
                                <div id='customer-visit-list' class="col-md-12">
                                    <div class="">
                                        <table class="table m-t-10" id="tblservices">
                                            <thead>
                                                <tr>
                                                    <th >#</th>
                                                    <th class="hidden-print">Item</th>
                                                    <th>Description</th>
                                                    <th><span class="hidden-print">Requested /</span> Staff <span class="hidden-print">/ Share</span></th>
                                                    <th class="hidden-print">Products</th>
                                                    <th class="hidden-print">Discount(Rs.)</th>
                                                    <th class="hidden-print">Discount(%)</th>
                                                    <th class="hidden-print">Discount(Type)</th>
                                                    <th>Service Cost</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <!--Table End-->
                            <!--Sub Total-->

                            <div class="row">
                                <!--invoice-->
                                <div class="col-md-6 col-lg-6 hidden-sm hidden-xs">
                                    <div class="row hidden-print">
                                        <div class="col-md-12">
                                            <h4>Remarks:</h4>
                                            <div class="form-group">
                                                <textarea row="5" class="form-control" id="txtinvoiceremarks" name="txtinvoiceremarks"></textarea>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row hidden-print" style="text-align:right">
                                        <form id="cancelvisitform" method="Post" action="<?php echo base_url('pos_cancel_visit');?>">
                                            <input type="hidden" name="csrf_test_name" id="cancelvisitform_csrf" value=""/>
                                            <div class="col-md-12 form-group" >
                                                <button style="display:none;" id="btncancelvisit" type="button" onclick="submitcancelvisit();" class="btn btn-danger ">Cancel Visit</button>
                                                <input id="cancelvisitid" name="visitid" type="hidden">
                                                <input id="cancelled_by" name="cancelled_by" type="hidden">
                                                <input id="cancelreason" name="cancelreason" type="hidden">
                                                <a style="display:none;" id="btninservice" href="javascript:void(0);" onclick="mark_inservice();" class="btn btn-icon btn-info waves-effect waves-light btn-trans"><i class="ti-check-box"></i> Mark as "In-Service"</a>
                                            </div>
                                        </form>
                                        <div class="m-t-10">
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 " >
                                    <hr/>
                                    <p class="text-right"><b>Total Before Discount:</b>   Rs. <input id="txt_org_subtotal" class="form-inline" readonly="readonly" style="text-align: right; width: 80px; border: none;" value='0'></p>
                                    <p class="text-right"><b>After Service Discounts:</b>   Rs. <input id="txtsubtotal" class="form-inline" readonly="readonly" style="text-align: right; width: 80px; border: none;" value='0'></p>
                                    <div id="invoicingdiv" style="display:none;" >
                                        <p class="text-right hidden-print">Discount %: <input readonly class="numeric" id="txtdiscountperc" onchange="calcdiscount_perc();" class="form-inline " style="text-align: right;width: 80px; border: none;" value="0"/></p>
                                        <p class="text-right hidden-print">Discount <span id="txtloyalty"></span> Rs.: <input readonly class="numeric" id="txtdiscount" onchange="updatetotal();" class="form-inline " style="text-align: right;width: 80px; border: none;" value="0"/></p>

                                        <p class="text-right">Other Charges Rs.: <input class="numeric" onchange="updateothercharges()" id="txtothercharges" class="form-inline " style="text-align: right;width: 80px; border: none;" value="0"/></p>
                                        <p class="text-right text-danger" id="cctip" style="display:none;">C-Card Tip Rs.: <input class="numeric" onchange="updateothercharges()" id="txtcctip" name="cctip" class="form-inline " style="text-align: right;width: 80px; border: none;" value="0"/></p>
                                        <p class="text-right">Gross Total:   Rs. <input id="txtgross" readonly="readonly" class="form-inline " style="text-align: right;width: 80px; border: none;"/></p>
                                        <div class="m-t-10 m-b-10 " id="divtaxes" style="display:none;">
                                            <?php if(isset($taxes)){$x=0;foreach ($taxes as $tax) {?>
                                                <p class="text-right"><span id="txttaxname<?php echo $x; ?>" ><?php echo $tax['tax_name'].' '; ?></span><input class="numeric" class="taxperc" style="text-align: right;width: 20px; border: none;" readonly="readonly" id="taxperc<?php echo $x;?>" value="<?php if(isset($tax['tax_percentage']) ||$tax['tax_percentage']!=""){ echo $tax['tax_percentage'];}?>">% :  Rs. <input class="tax" readonly="readonly" class="form-inline " style="width: 80px; border: none; text-align: right;" value="0"/></p>
                                            <?php $x++;}}?>                                            
                                        </div>
                                        <div class="m-t-10 m-b-10" id="divcccharge" style="display:none">
                                            <p class="text-right">
                                                <span >CC Fee @ <?php echo $business[0]['cc_charge'].' '; ?>%</span> :  Rs. 
                                                <input class="cccharge" id="txtcc_charge" name="txtcc_charge" readonly="readonly" class="form-inline " style="text-align: right;width: 80px; border: none;" value="0" />
                                            </p>
                                        </div>
                                        <input id="cc_charge" type="hidden" value="<?php echo $business[0]['cc_charge'];?>">
                                        <p class="text-right">Total Payable Amount:   Rs. <input id="txttotalpayable" readonly="readonly" class="form-inline " style="text-align: right; width: 80px; border: none;"/></p>
                                        <hr>

                                        <h4 class="text-right text-custom "><button onclick='showadvancemodal();' class='btn btn-pink btn-sm hidden-print' id='btnadvance'>Add</button>  Advance Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly"  id="txtadvance"  name="txtadvance" value="0"/></h4>
                                        <h3 class="text-right text-success">  Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly" id="grandtotal"  name="grandtotal"/></h3>

                                        <h4 class="text-right hidden-print">Paying Now Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" onchange="updatetotal();" onclick="$(this).select();" id="paid"  name="paid" value="0"/></h4>
                                        <h4 id="payingcash" class="text-right  hidden-print" style="display:none;" >Cash Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" onchange="updatepaying();" onclick="$(this).select();" id="cashpaid"  name="cashpaid" value="0"/></h4>
                                        <h4 id="payingcard" class="text-right  hidden-print" style="display:none;">Card Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" onchange="updatepayingcard();" onclick="$(this).select();" id="cardpaid"  name="cardpaid" value="0"/></h4>


                                        <h4 class="text-right text-primary hidden-print"><input id="keepadv" type="checkbox"> <span>Retain?</span> Return Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly" id="returnamount"  name="returnamount" value="0"></h4>
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
                                <hr/>
                            </div>
                            <div id="buttonsdiv" class="row hidden-print m-t-20">
                                <div class="pull-left">
                                   <span name="txtcustomeradvance" style="display:none; font-weight: bold;" class="text-custom" id="txtcustomeradvance"> </span>
                                   <a style='display:none;' href="javascript:void(0);" onclick="usecustomeradvance();" class="btn btn-custom waves-effect waves-light" id="btncustomeradvance">Use</a>
                                </div>
                                <div class="pull-right">
                                    <span   name="txtloyaltypoints" style="display:none; font-weight: bold;" class="text-success" id="txtloyaltypoints">Customer's Loyalty Points: <input name="loyaltypoints" id="loyaltypoints" style="width: 80px; border: none;"  type="text" readonly="readonly" value="0"/></span>
                                    <a style='display:none;' href="javascript:void(0);" onclick="loyaltydiscount('<?php echo $business[0]['loyalty_mode']; ?>')" class="btn btn-success waves-effect waves-light" id="btnloyalty">Redeem Loyalty</a>
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
                                    <button type="button" id="btnvisit" onclick="checkformforupdate(); " class="btn btn-custom waves-effect waves-light">Save Visit Changes</button>
                                    
                                    <a href="javascript:void(0);" onclick="createinvoice('invoice');"  class="btn btn-pink waves-effect waves-light" id="btninvoice" >Invoice</a>
                                </div>
                            </div>
                            <!--invoice End-->
                        </div>
                        
                    </div>
                    <!--Visit Details End-->
            
            
                    <div id="calendarOverlay" style="display: none; position: absolute; top: 320px; left: 20px; z-index: 5; background: #fff; opacity: 0.6; text-align: center;">
                            <img style="height: 50px; margin-top: 100px;" src="<?php echo base_url() . 'assets/images/spin-pink.gif'; ?>">
                    </div>
            </div> <!--cardbox row-->     
         </div> <!--Print Bill-->
        </div><!--End Row-->
    </div><!--End Container-->
</div><!--End Wrapper-->
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
                    </div>
                    <div class="modal-footer">
                        <button onclick="updateHairColorHistory();" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Color Record Modal-->
        
        
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
                                            <input tabindex="1" type="text" class="form-control" placeholder="Customer Name" id="txtcustomername" name="txtcustomername" onblur="$(this).val(ucwords($(this).val()));">
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
        <div id="editcustomer" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editsupplier" aria-hidden="true" style="display: none;">
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
        
         <!--Staff List Modal-->
        
        <!--Staff List Modal-->
        <?php //include 'modals/pick_service_modal.php'; ?>
        <!---pick service modal-->
        <?php include 'modals/pick_staff_modal.php'; ?>
        <!-- Pick service modal-->
        
        <!---pick service modal-->
        <?php include 'modals/advance_modal.php'; ?>
        <!-- Pick service modal-->
        
        
        <input type="hidden" name="uid" id="uid" />
        <input type="hidden" name="uname" id="uname" />
        <input type="hidden" name="uusername" id="uusername" />
        <input type="hidden" name="uemail" id="uemail" />
        <input type="hidden" name="ddiscount_remarks" id="ddiscount_remarks" />

<?php include 'js_functions/general_js.php'; ?>
<?php //include 'js_functions/visit_js.php'; ?>
<?php include 'js_functions/service_invoice_js.php'; ?>

<script>

    $(document).on('keydown', function(e) {
//        //console.log(e.which);
            if (e.which == 113 || e.which == 46) { //F2 or Delete
                $('#visit-services').select2('close');
                $("#paid").val("");
                $("#paid").focus();
            }
            if(e.which==27){
                //getopen_visits();
                submitopenfresh();
            }
        });
        
    var enabtax=false;
    $(document).ready(function () {
        
        $("#btnprint").hide(); 
        $("#btninvoice").hide(); 
        $("#btnpaymentmode").hide();
        $("#btnvisit").show();
        
       <?php if($business[0]['tax_optional'] === 'No'){ ?>
            enabletaxes('yes');
        <?php } ?>
        var opentime ='<?php $to = explode(':', $business[0]['business_opening_time']); echo $to[0];?>';
        var closetime ='<?php $tc = explode(':', $business[0]['business_closing_time']); echo $tc[0];?>';
        customer_select();
        //getservices();
        fillBday();
        
        $('#visit-time').timepicker({
            showMeridian: false                
            , maxHours: closetime
            , minuteStep: 15
            ,showInputs: true
        }).on('changeTime.timepicker', function(e) {
            if(e.time.hours < opentime){
                $(this).timepicker('setTime', opentime + ":00");
            }
        });
                
                
        $('#visit-date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
        
        $('#visit-date').datepicker('update', new Date());
        
        //$("#txt-customer-search").val("Walk-In");
        $('#visit-services').select2({placeholder:'Select a Service ................'});

       // $("#txt-customer-search").select2("open");
        //$('#visit-services').select2('open');

        $('#visit-staff').select2(); //testing speed
        
        $('#openvisits').select2();
        $('#inservicevisits').select2();
        
//        $("#visit-staff").keydown(function (e) {
//            if (e.which === 13) {
//                $("#btn-add").focus();
//            }
//        });

        $("#btn-add").focusin(function () {
            $("#btn-add").removeClass("btn-purple");
            $("#btn-add").addClass("btn-pink");
        });

        $("#paid").focusout(function () {
            if($("#paid").val()==""){ $("#paid").val("0");}
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
                        ////console.log(data);

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
            $('#txtdiscountperc').val(parcentage);
            //$("#paid").val($("#grandtotal").val());
            $("#balanceamount").val(parseFloat($("#grandtotal").val()) - parseFloat($("#paid").val()));
            updatetotal();
            
        });    
    
        $('#keepadv').click(function(){
            if(parseInt($("#returnamount").val()) <= 0){
                $(this).prop('checked',false)
            }
        });
        
    });


    $(window).load(function(){
        var id_customer_visit = <?php if(isset($id_customer_visit)){echo "'". $id_customer_visit . "'";}else{echo '0';}?>;
        if(id_customer_visit>0){openVisit(id_customer_visit);} else {  $("#txt-customer-search").select2("open");}
        
        var id_customer = <?php if(isset($id_customer)){echo "'". $id_customer . "'";}else{echo '0';}?>;
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
                //console.log(data);
                 
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
                ////console.log(data);
                
                $("#label-customer-name").html(data[0]['customer_name']);
                $("#customername").val(data[0]['customer_name']);
                $("#customerid").val(data[0]['id_customers']);
                $("#customercell").val(data[0]['customer_cell']);
                $("#customeraddress").val(data[0]['customer_address']);
                $("#customeremail").val(data[0]['customer_email']);

                var date = new Date();
                var myhour = (date.getHours()<10?'0':'') + date.getHours(); // 10
                var mymin = (date.getMinutes()<10?'0':'') + date.getMinutes();
                $('#visit-time').timepicker('setTime', myhour + ":"+mymin);

                $('#visit-date').datepicker("update", date);

                if(parseInt(data[0]['id_customers']) > 1){
                    $("#btnedit").slideDown();
                    $("#btnaccount").slideDown();
                } else {
                    $("#btnedit").slideUp();
                    $("#btnaccount").slideUp();
                }

                //get_customer_details(data.id_customers);

                checkopenvisit(data[0]['id_customers']);
               

            }
        });
    }

    function customer_select(){
            $("#txt-customer-search").select2({
            placeholder: "Select Customer",
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
    
        var data = $("#txt-customer-search").select2('data');
        ////console.log(data);
        $("#label-customer-name").html(data.customer_name);
        $("#customername").val(data.customer_name);
        $("#customerid").val(data.id_customers);
        $("#customercell").val(data.customer_cell);
        $("#customeraddress").val(data.customer_address);
        $("#customeremail").val(data.customer_email);
        
        var date = new Date();
        var myhour = (date.getHours()<10?'0':'') + date.getHours(); // 10
        var mymin = (date.getMinutes()<10?'0':'') + date.getMinutes();
        $('#visit-time').timepicker('setTime', myhour + ":"+mymin);
        
        $('#visit-date').datepicker("update", date);
        
        if(parseInt(data.id_customers) > 1){
            $("#btnedit").slideDown();
            $("#btnaccount").slideDown();
        } else {
            $("#btnedit").slideUp();
            $("#btnaccount").slideUp();
        }
        
        //get_customer_details(data.id_customers);
        
        checkopenvisit(data.id_customers);
        
        //$(".tdcustomerid").html(data.id_customers);
        
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
                var balance=bal.balance;
                var customer_points=bal.customer_points;
                var customer_alerts=bal.customer_alerts;
                
                
                if(balance.length>0){
                    var bhtml="";
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
                $("#customername").val(customer_points[0]['customer_name']);
                $("#customercell").val(customer_points[0]['customer_cell']);
                $("#customeraddress").val(customer_points[0]['customer_address']);
                $("#customeremail").val(customer_points[0]['customer_email']);
                
            }
        });
        hideCalendarOverlay();
    }
    
    function getservices(){
        $("#visit-services").select2({
            ajax: {
                url: '<?php echo base_url() . 'service_controller/search_all_services'; ?>',
                dataType: 'json',
                delay: 250,
                data: function (term, page) {

                    return {
                        servicename: term, // search term
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
            minimumInputLength: 1,
            formatResult: function (option) {
                return option.id_business_services + ' - ' + option.service_type + ' - ' + option.service_category + ' - ' + option.service_name + ' Rs. ' + option.service_rate;
            },
            formatSelection: function (option) {
                return option.id_business_services + ' - ' + option.service_type + ' - ' + option.service_category + ' - ' + option.service_name + ' Rs. ' + option.service_rate;
            }
        });
    }
    
    function on_service_change() {
        //console.log('service_change');
        $('#visit-staff').select2('open');
        //$('#visit-staff').focus();
        if($("#visitid").val()!==""){
            visit_mode();
        }
    }
   
    function on_staff_change() {
        //console.log('staff_change');
       $("#visit-staff").select2('close');
      // $('#visit-staff').focus();
       //$("#btn-add").click();
        if($("#visitid").val()!==""){
            visit_mode();
        }
       
    }
   
    
    
    function onVisitTimeChange(){
        //console.log('visit time change');
        $('#visit-time').select2('open');
        if($("#visitid").val()!==""){
            visit_mode();
        }
        
    }
    
    function onVisitDateChange(){
        //console.log('visit date change');
        $('#visit-date').select2('open');
        if($("#visitid").val()!==""){
            visit_mode();
        }
    }
    
    
    //////////////Add Services//////////////
    
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
        $("#txtinvoiceremarks").val('');
        ////////////////
        
        $("#visitid").val('');
        $("#visitdate").val('');
        $("#customername").val('');
        $("#customercell").val('');
        $("#customeraddress").val('');
        $("#customeremail").val('');

        $("#customerid").val("");
        $("#txt-customer-search").val("");
        
        $("#customerbalance").val("");
        $("#customerbalancediv").hide();
        $("#customeralert").val("");
        $("#customeralertdiv").hide();
        
        
        $("#customer-visit-list tbody").html("");
        getopen_visits();
    }
    

    
   
    ////////////////////////////////////////
    
    
    //////////////Fill Visit/////////////////
    function submitopenvisit(){
        $("#openvisitform_csrf").val($('#cook').val());
        //$("#openvisitform").submit();
        
        $.ajax({
            type: 'POST',
            //url: 'customer_controller/updatecustomer',
            url: "<?php echo base_url() . 'pos_controller/get_customer_visit'; ?>",
            data: $("#openvisitform").serialize(),
            dataType: "json",
            success: function(data) {
                
                 var id_customer_visit = data['id_customer_visit'];
                
                if(id_customer_visit>0){openVisit(id_customer_visit);} else {  $("#txt-customer-search").select2("open");}
                
            },
            error: function(){
                swal({
                        title: "Error",
                        text: result[1],
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
            }
        });
    }
    
    function submitinvoicevisit(){
        $("#inservicevisitform_csrf").val($('#cook').val());
        //$("#inservicevisitform").submit();
        
        
        $.ajax({
            type: 'POST',
            //url: 'customer_controller/updatecustomer',
            url: "<?php echo base_url() . 'pos_controller/get_customer_visit'; ?>",
            data: $("#inservicevisitform").serialize(),
            dataType: "json",
            success: function(data) {
                
                 var id_customer_visit = data['id_customer_visit'];
                
                if(id_customer_visit>0){openVisit(id_customer_visit);} else {  $("#txt-customer-search").select2("open");}
                
            },
            error: function(){
                swal({
                        title: "Error",
                        text: result[1],
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
            }
        });
        
    }
    
    
    
    
    function submitopenfresh(){
        
        $('#openfresh_csrf').val($('#cook').val());
        //$("#openfresh").submit();
        clearForm();
        
        $("#label-customer-name").html('');
        $("#customername").val('');
        $("#customerid").val('0');
        $("#customercell").val('');
        $("#customeraddress").val('');
        $("#customeremail").val('');
        $("#btn")
        
        new_search_mode();
        
        $("txt-customer-search").removeAttr('disabled');
        
        $("#visitid").val('');
        $("#visitdate").val('');
        $("#txtsubtotal").val("0");
        $("#btnaccount").hide();
        $("#btnedit").hide();
        $('#visit-date').datepicker('update', new Date());
        //$("#txt-customer-search").select2("open");
    }
    function submitopendirectselect(){
        $("#opendirectform_csrf").val($('#cook').val());
        $("#opendirectselect").submit();
    }    
    
    function submitretailform(){
        $("#retailcustomer").val($("#customerid").val());
        $("#retailform").submit();
        
    }
    
    function submitcancelvisit(){
        $("#cancelvisitform_csrf").val($('#cook').val());
        if($("#visitid").val()==""){return false;}
        swal({
            title: "Are you sure?",
            text: "Give Reason For Cancelling This Visit:",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            inputPlaceholder: "reason for cancelling"
            }, function (inputValue) {
              if (inputValue === false) return false;
              if (inputValue === "") {
                  swal.showInputError("You need to write something!");
                  return false;
              } 
              $("#cancelvisitid").val($("#visitid").val());
              $("#cancelled_by").val($("#agent_name").html());
              $("#cancelreason").val(inputValue);
              $("#cancelvisitform").submit();
            });
            getopen_visits();
    }
    
    function openVisit(visitid){
        
       // if($("#openvisits option:selected").val()=="0"){return false;}
        clearForm();
        //$("#txt-customer-search").select2("val", "");
        
        //visitid = $("#openvisits option:selected").val();

        
        //$('#openvisits').val('0').trigger('change');
        
        //$("#CurrentAction").html('Invoicing Customer Visit . . .');
        //console.log("opening invoice for visit: "+visitid);
        fill_visit(visitid);
        
        
    }
    
    function fill_visit(visitid){
        showCalendarOverlay();
        var myurl;
        
        myurl = '<?php echo base_url().'pos_controller/getVisitbyid'; ?>';

        $.ajax({
            type: 'POST',
            url: myurl,
            data: {id_customer_visit: visitid},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
               // console.log(data);
                //$("#txt-customer-search").select2("val", data[0]['customer_name']);
                var mhtml = "";
                var rowcount=1;
                var visit=data.visits;
                var staffs=data.staffs;
                var services=data.services;
                var visitserviceproducts=data.visitserviceproducts;
                var serviceproducts = data.serviceproducts;
                var advances=data.advances;
                var discount_types=data.discount_types;
                
                var totaladvance=0; var ahtml=""; var fhtml="";
                if(advances.length>0){
                    for (x = 0; x < advances.length; x++) {
                        ahtml +='<tr><td>Adv.</td><td>'+ advances[x].date +'</td><td style="text-align:right;">'+ advances[x].advance_amount +'</td></tr>';
                        totaladvance= totaladvance+parseFloat(advances[x].advance_amount);
                    }
                    $("#adv_table tbody").html(ahtml);
                    fhtml +='<tr><td></td><td style="font-weight:bold;">Total Advance:</td><td style="font-weight:bold; text-align:right;">'+ totaladvance.toFixed(2) +'</td></tr>';
                    $("#adv_table tfoot").html(fhtml);
                }else{
                    $("#adv_table tbody").html('');
                    $("#adv_table tfoot").html('');
                }
                
                $("#visitid").val(visit[0].id_customer_visits);
                $("#customerid").val(visit[0].customer_id);
                $("#customername").val(visit[0].customer_name);
                $("#customercell").val(visit[0].customer_cell);
                $("#customeraddress").val(visit[0].customer_address);
                $("#customeremail").val(visit[0].customer_email);
                $("#txtinvoiceremarks").val(visit[0].advance_comment);
                if(visit[0].inservice=="Yes"){
                    $("#lblinservice").html("In-Service");
                } else {
                    $("#lblinservice").html("");
                }
//                
//                if(visit[0].advance_comment !== "" && visit[0].advance_comment !== null){
//                   
//                    $("#visitalert").html(visit[0].advance_comment);
//                    $("#visitalertdiv").show();
//
//                }else{
//                    $("#visitalertdiv").hide();
//                }
//                
                
                for (x = 0; x < services.length; x++) {
                    if(x==0){
                        ////console.log(services[x].visit_service_start);
                        var dt= services[x].visit_service_start.split("T");
                        ////console.log(dt[0]);
                       // //console.log(dt[1]);
                        $("#visit-date").val(dt[0]);
                        $("#visit-time").val(dt[1]);
                        $("#visitdate").val(dt[0]+' '+dt[1]);
                    }
                    mhtml += '<tr class="service_row">';
                    mhtml += '<td class="id" row_id="'+rowcount+'">'+ rowcount +'</td>';
                    mhtml += '<td row_id='+rowcount+' class="tdservicecategory hidden-print">' + services[x].service_category + '</td>';
                    
                    mhtml += '<td><input type="hidden" id="service_ids" name="service_ids" row_id='+rowcount+' id_visit_services=' + services[x].id_visit_services + ' service_type="'+services[x].service_type +'" service_category="'+services[x].service_category+'"  service_name="'+ services[x].service_name +'" service_duration="'+ services[x].service_duration +'" flag="' + services[x].service_flag +'" id_service_category="'+ services[x].id_service_category+'" visit_service_start="'+ services[x].visit_service_start +'" commission="'+ services[x].commission_perc +'" value="'+services[x].id_business_services +'">';
                    mhtml += services[x].service_name + '</td>';
                    
                    mhtml += '<td>';        
                    var servicestaff=[];
                    var index=0;
                    for(y=0; y < staffs.length;y++){
                        if(services[x].id_visit_services == staffs[y].visit_service_id){
                           var checked='';
                           if(staffs[y].requested=="Yes"){checked=' checked="checked" ';} 
                           mhtml += '<div class="checkbox checkbox-primary" id="staff_' + rowcount + '_' + services[x].id_business_services +  '_' + staffs[y]['staff_id'] + '_staff"><input class="hidden-print" row_id='+rowcount+' service_id='+services[x].id_business_services+' staff_id=' + staffs[y].staff_id + ' staff_name="' + staffs[y]['staff_name'] + '" id="requested_' + rowcount + '_' + services[x].id_business_services +  '_' + staffs[y]['staff_id'] +'" type="checkbox" name="requested" '+ checked +'/><label ondblclick="changestaff('+rowcount + ',' + services[x].id_business_services + ',' + services[x].staff_id + ');" id="requested_' + rowcount + '_' + services[x].id_business_services +  '_' + staffs[y]['staff_id'] + '_label">' + staffs[y].staff_name + '</label>';
                           if(index>0){
                               mhtml += '<span class="label label-pink m-l-5" onclick="removeadditionalstaff(\'staff_' + rowcount + '_' + services[x].id_business_services +  '_' + staffs[y]['staff_id'] + '_staff\');" style="cursor:pointer">x</span>';
                           }
                           mhtml += ' <input class="form-control staffshare hidden-print" onchange="calcstaffshare(\''+rowcount+ '\', \'' + services[x].service_rate + '\', \'' + staffs[y].staff_id + '\', \'staffshare_'+ rowcount +'_'+ services[x].id_business_services +'_'+staffs[y].staff_id+ '\')" style="width:80px; height:18px; ;display:inline; float:right; text-align:right;" id="staffshare_'+ rowcount +'_'+ services[x].id_business_services +'_'+staffs[y].staff_id+'" name="staff_share" row_id='+ rowcount +' service_id='+ services[x].id_business_services +' staff_id='+staffs[y].staff_id +' servicerate='+services[x].service_rate+' value=""></div>';
                           console.log(index);
                           servicestaff.push(staffs[y].staff_id);
                           index++;
                        }
                    }
                    
                    mhtml += '</td>';
                    
                    mhtml += '<td class="hidden-print">';
                    
                    /////Products
                    mhtml += '<select multiple="multiple" style="border:none;" class="serviceproducts" id="serviceproducts_'+rowcount+'_'+data['id_business_services']+'" name="id_business_products">';
                    var selected = '';
                    if(serviceproducts.length>0){
                        $.each(serviceproducts, function(i, serviceproduct) {                            
                            $.each(serviceproduct, function(i, product) {
                                selected = '';
                                if(product.business_service_id == services[x].id_business_services){
                                    
                                    $.each(visitserviceproducts, function (index, vsp){
                                       
                                        
                                        if(vsp.visit_service_id == services[x].id_visit_services && vsp.product_id==product.id_business_products){                                            
                                            selected = 'selected="selected"';
//                                             //console.log('product '+  product.product);
//                                            //console.log('visit service id ' + vsp.visit_service_id);
//                                            //console.log('service visit id '+  services[x].id_visit_services);
                                        } 
                                    });
                                    mhtml += '<option row_id='+ rowcount +' service_id='+services[x].id_business_services+' service_name="'+services[x].service_name+'" product_service_id="'+ product.id_services_products + '" unit="'+ product.measure_unit+'" qty="'+ product.usage_qty+'" product_name="'+ product.product +'" value="'+ product.id_business_products + '" ' + selected + ' >'+ product.product +'</option>';
                                }           
                            });
                        });
                    }
                            
                           
                    //mhtml += '<option row_id='+ rowcount +' service_id='+services[x].id_business_services+' service_name="'+services[x].service_name+'" product_service_id="'+ serviceproduct.id_services_products + '" unit="'+ serviceproduct.measure_unit+'" qty="'+ serviceproduct.usage_qty+'" product_name="'+ serviceproduct.product +'" value="'+ serviceproduct.id_business_products + '" ' + selected + ' >'+ serviceproduct.product +'</option>';
                                     
                    mhtml += '</select>';
                        
                    mhtml += '</td>';
                    if(services[x].loyalty_service =='N'){
                        mhtml += '<td class="discount discountshow hidden-print"><div class="col-lg-12"><div class="form-inline">';
                        mhtml += '<input row_id='+rowcount+' service_id='+ services[x].id_business_services +'  readonly ondblclick="$(\'#invoicepass\').modal(\'show\');" onclick="enable_discount_pass('+rowcount + ', ' + services[x].id_business_services + ')" style="border:none; width: 40px;" onblur="javascript:discount_by_service(0, '+rowcount + ', ' + services[x].id_business_services + ');" class="numeric discount_by_service discount" type="text" name="discount_by_service" id="discount_by_service_' +rowcount+'_'+ services[x].id_business_services + '" placeholder="0"  />';
                        mhtml += '</div></div></td>';
                        mhtml += '<td class="discountperc discountshow hidden-print"><div class="col-lg-12"><div class="form-inline">';
                        mhtml += '<input row_id='+rowcount+' service_id='+ services[x].id_business_services +'  readonly ondblclick="$(\'#invoicepass\').modal(\'show\');" onclick="enable_discount_pass('+rowcount + ', '+ services[x].id_business_services + ');" style="border:none; width: 40px;" onblur="javascript:perc_discount_service(0, '+rowcount + ', '+ services[x].id_business_services +');" class="numeric perc_discount_service discount" type="text" name="perc_discount_service" id="perc_discount_service_' +rowcount+'_'+ services[x].id_business_services+'" placeholder="0"  />';
                        mhtml += '</div></div></td>';
                        mhtml += '<td class="discountshow hidden-print"><div class="col-lg-12"><div class="form-inline">';
                        mhtml += '<select class="form-control" name="discount_type" row_id='+rowcount+' service_id='+ services[x].id_business_services +'  id="discount_type_'+rowcount+'_'+ services[x].id_business_services+'">';
                        mhtml += '<option id=""></option>';//<option id="Normal">Normal</option><option id="Promotion">Promotion</option><option id="Promotion">Lapse</option><option id="Birthday">Birthday</option><option id="New Customer">New Customer</option>';
                        
                        for(y=0; y < discount_types.length;y++){
                            mhtml += '<option id="'+discount_types[y]['discount_reason']+'">'+discount_types[y]['discount_reason']+'</option>';
                        }
                        mhtml += '</select></div></div></td>';
                        mhtml += '<td >Rs.<span class="combat" name="unitcost" row_id='+rowcount+' service_id='+ services[x].id_business_services +' id="unitcost_'+rowcount+'_'+services[x].id_business_services+'">'+services[x].service_rate+'</span><input type="hidden" class="orignal_service_rate"  name="orignal_service_rate" row_id='+rowcount+' service_id='+ services[x].id_business_services +'  id="orignal_service_rate_'+rowcount+'_'+services[x].id_business_services+'" value="'+services[x].service_rate+'" />';
                        mhtml += '</td>';
                    } else { 
                        mhtml += '<td class="hidden-print"></td><td class="hidden-print"></td><td class="hidden-print"></td>';
                        mhtml += '<td >Rs.<span class="combat" name="unitcost" id="unitcost_'+rowcount+'_'+services[x].id_business_services+'">0.00</span><input class="orignal_service_rate" type="hidden" name="orignal_service_rate" row_id='+rowcount+' service_id='+ services[x].id_business_services +' id="orignal_service_rate'+services[x].id_business_services+'" value="0.00" /></td>';
                    }                    

                    mhtml += '<td class="hidden-print"><span class="label label-danger" onclick="removebyrow(\'' + rowcount + '\');" style="cursor:pointer">x</span></td>';
                    mhtml += "</tr>";
                    rowcount++;
                }
                $("select.serviceproducts").select2('destroy');
                $("#customer-visit-list tbody").append(mhtml);
                $("#txtadvance").val(totaladvance);
                $("select.serviceproducts").select2();
                
                get_customer_details(visit[0].customer_id);
                staffshare();
                service_row_sum();
                updatetotal();
                //enable_discount_pass();
                
                invoice_mode();
                
                hideCalendarOverlay();
            }
        });
        //$("#txt-customer-search").trigger('change.select2');
    }
    function new_visit_mode(){
        //console.log('show new visit');
        
        $("#btncancelvisit").hide();
        $("#btninservice").hide();
        $("#btn-add").show();
        $("#txtloyaltypoints").hide();
        $("#loyaltypoints").hide();
        $("#btnloyalty").hide();
        $("#txtcustomeradvance").hide();
        $("#btncustomeradvance").hide();
        $("#btnpaymentmode").hide();
        $("#lblinservice").html('');
        //$("btnaddcustomer").attr('disabled','disabled');
        //$("txt-customer-search").attr('disabled','disabled');
        
        $("#btnprint").hide(); 
        $("#btninvoice").hide(); 
        $("#btnvisit").show();
        
        
        
        $('#invoicingdiv').slideUp();
        $(".discountshow").html('');
        $(".staffshare").hide();
        
        $("#CurrentAction").html('Creating New Visit . . .');
        $("#CurrentActionDiv").css('background','#ff8acc');
        
        $("#CurrentActionIcon").removeClass('fa-hourglass-1');
        $("#CurrentActionIcon").removeClass('fa-dollar');
        $("#CurrentActionIcon").removeClass('fa-calendar');
        $("#CurrentActionIcon").addClass('fa-calendar-check-o');
        
    }
    
    function new_search_mode(){
        //console.log('show new search');
        
        $("#btncancelvisit").hide();
        $("#btninservice").hide();
        $("#btn-add").show();
        $("#txtloyaltypoints").hide();
        $("#loyaltypoints").hide();
        $("#btnloyalty").hide();
        $("#txtcustomeradvance").hide();
        $("#btncustomeradvance").hide();
        $("#btnpaymentmode").hide();
        $("#lblinservice").html('');
        $("btnaddcustomer").removeAttr('disabled');
        $("txt-customer-search").removeAttr('disabled');
        //console.log('removed');
        
        $("#btnprint").hide(); 
        $('#btninvoice').removeClass('disabled');
        $('#btninvoice').html('Invoice');
        $("#paid").val('0');
        $("#returnamount").val('0');
        $("#balanceamount").val('0');
        $('#keepadv').prop('checked',false);
        
         $("#btninvoice").hide();
        $("#btnvisit").show();       
        
        
        $('#invoicingdiv').slideUp();
        $(".discountshow").html('');
        $(".staffshare").hide();
        
        $("#CurrentAction").html('Search Customer . .');
        $("#CurrentActionDiv").css('background','#797979');
        
        
        $("#CurrentActionIcon").removeClass('fa-dollar');
        $("#CurrentActionIcon").removeClass('fa-calendar');
        $("#CurrentActionIcon").removeClass('fa-calendar-check-o');
        $("#CurrentActionIcon").addClass('fa-hourglass-1');
    }
    
    function visit_mode(){
        //console.log('show visit');
        
        $("#btncancelvisit").hide();
        $("#btninservice").hide();
        $("#btn-add").show();
        $("#txtloyaltypoints").hide();
        $("#loyaltypoints").hide();
        $("#btnloyalty").hide();
        $("#txtcustomeradvance").hide();
        $("#btncustomeradvance").hide();
        $("#btnpaymentmode").hide();
        $("#lblinservice").html('');
        //$("btnaddcustomer").attr('disabled','disabled');
        //$("txt-customer-search").attr('disabled','disabled');
        
        $("#btnloyalty").hide();
        $("#btncustomeradvance").hide();
        
        $("#btnprint").hide(); 
        $("#btninvoice").hide(); 
        $("#btnvisit").show();
        
        $('#invoicingdiv').slideUp();
        $(".discountshow").html('');
        $(".staffshare").hide();
        
        $("#CurrentAction").html('Editing Customer Visit . . .');
        $("#CurrentActionDiv").css('background','#f9c851');
        
        $("#CurrentActionIcon").removeClass('fa-dollar');
        $("#CurrentActionIcon").removeClass('fa-hourglass-1');
        $("#CurrentActionIcon").removeClass('fa-calendar-check-o');
        $("#CurrentActionIcon").addClass('fa-calendar');        
        
    }
    
    ////////////////////////////////////////////
    
    
    ////////////Invoice Operations ///////////////
    function invoice_mode(){
        //console.log('show invoice');
        
        $("#btncancelvisit").show();
        if($("#lblinservice").html()!=="In-Service"){
            $("#btninservice").show();
        } else {
            $("#btninservice").hide();
        }
        $("#btnprint").show(); 
        
      //  $("#btnprint").hide(); 
        $('#btninvoice').removeClass('disabled');
        $('#btninvoice').html('Invoice');
        $("#paid").val('0');
        $("#returnamount").val('0');
       // $("#balanceamount").val('0');
        $('#keepadv').prop('checked',false);
        
        
        $("#btninvoice").show(); 
        $("#btnpaymentmode").show();
        $("#btnvisit").hide();
        
        //$("btnaddcustomer").attr('disabled','disabled');
        //$("txt-customer-search").attr('disabled','disabled');
        
        
        $('#invoicingdiv').slideDown();

        $("#btnloyalty").show();
        $("#btncustomeradvance").show();
        

        $(".discount").show(); $(".discountperc").show(); 
        $("#paid").focus();
        $("#CurrentAction").html('Invoicing Customer Visit . . .');
        $("#CurrentActionDiv").css('background-color','#10c469');
        
        $("#CurrentActionIcon").removeClass('fa-calendar-check-o');
        $("#CurrentActionIcon").removeClass('fa-calendar');
        $("#CurrentActionIcon").removeClass('fa-hourglass-1');
        $("#CurrentActionIcon").addClass('fa-dollar');
    }
    
    function calcstaffshare(row_id, price, staff_id,item){
        //console.log(row_id);
        $.each($(".service_row"), function(){
            //console.log('attr row id ' + $(this).find('.id').attr('row_id'));
            if($(this).find('.id').attr('row_id')===row_id){
                price = parseFloat($(this).find('.combat').html());
                 //console.log(price);
            }
        });
       
        
        if(parseInt($('#'+item).val())>parseInt(price)){
          $('#'+item).val(price); 
        }
        
        
        price = price-$('#'+item).val(); 
        
        $.each($(".service_row"), function(){
            
            var servicestaff=0;
            $.each($(this).find('.staffshare'), function(){
                servicestaff++;
            });
            $.each($(this).find('.staffshare'), function(){
                if($(this).attr('row_id')===row_id){
                    
                    if($(this).attr('staff_id')!==staff_id){
                        $(this).val(price/(servicestaff-1));
                        //console.log($(this).val());
                    }

                } else {
                  //  $(this).val(price/servicestaff);
                }
            });
        });  
    }
    
    function staffshare(){
        
        $.each($(".service_row"), function(){
            
            var servicestaff=0;
            $.each($(this).find('.staffshare'), function(){
                
                servicestaff++;
                
            });
            $(this).find('.staffshare').val(parseFloat($(this).find('.combat').html())/servicestaff);
        });  
    }
    
    function updatetotal(){
        
        if($('#txtdiscount').val()===""){$('#txtdiscount').val('0');}
        if($('#txtothercharges').val()===""){$('#txtothercharges').val('0');}
       
        var orggrosstotal = parseFloat($("#txt_org_subtotal").val()) +  parseFloat($("#txtothercharges").val());
        var grosstotal=(parseFloat($("#txtsubtotal").val()) +  parseFloat($("#txtothercharges").val()) + parseFloat($("#txtcctip").val()) - parseFloat($("#txtdiscount").val()));
        
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
        //$('#btninvoice').hide();
        if ($('#grandtotal').val() == ""){
            swal({
                title: 'Please Wait . . .',
                text: "Calculating Amounts!",
                type: 'info',
                showCancelButton: false,
                confirmButtonColor: '#ff5b5b !important',
                confirmButtonText: 'Ok'
            });
            $("#btnprint").show(); 
            $('#btninvoice').show();
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
            $("#btnprint").show(); 
            $('#btninvoice').show();
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
            $("#btnprint").show(); 
            $('#btninvoice').show();
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
            $("#btnprint").show(); 
            $('#btninvoice').show();
            return false;
        }
        
        
        if($('#paid').val() === ''){
            $("#btnprint").show(); 
            $('#btninvoice').show();
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
                    $("#btnprint").show(); 
                    $('#btninvoice').show();
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
        
        $('#btninvoice').addClass('disabled');
        $('#btninvoice').html('<i class="fa fa-spin fa-spinner"></i> Please wait');
        
        /////new arrays////
        var services=[];
        var products=[];
        var staff=[];
       
        $('input[name=service_ids]').each(function(index, service) {
           
            var service_discount=''; var service_discount_type=''; var unit_cost=''; var orignal_service_rate='';
            $('input[name=discount_by_service]').each(function() {
                if($(this).attr('row_id')==$(service).attr('row_id')){
                    service_discount=$(this).val();
                }
            });
            
            $('select[name=discount_type]').each(function() {
                if($(this).attr('row_id')==$(service).attr('row_id')){
                    service_discount_type=$(this).find('option:selected').val();
                }
            });
            
            
            $('span[name=unitcost]').each(function() {
                if($(this).attr('row_id')==$(service).attr('row_id')){
                    unit_cost=$(this).html();
                    ////console.log($this.text());
                }
            });
            
            $('input[name=orignal_service_rate]').each(function() {
                if($(this).attr('row_id')==$(service).attr('row_id')){
                    orignal_service_rate=$(this).val();
                }
            });
            services.push({row_id:$(service).attr('row_id'), service_id:$(service).val(), service_type:$(service).attr('service_type'), service_category:$(service).attr('service_category'), service_name:$(service).attr('service_name'), service_duration:$(service).attr('service_duration'), service_flag:$(service).attr('flag'), id_service_category: $(service).attr('id_service_category'), discount:service_discount, discount_type:service_discount_type, unitcost:unit_cost, originalservicerate: orignal_service_rate, commission: $(service).attr('commission'), visit_service_start: $(service).attr('visit_service_start')});
        });
        
        $('select[name=id_business_products]').each(function() {
            $(this).find('option:selected').each(function(index,element){
                products.push({row_id : $(this).attr('row_id'), product_id: $(this).val(), service_id: $(this).attr('service_id'), service_name: $(this).attr('service_name'), product_name: $(this).attr('product_name'), qty : $(this).attr('qty'), unit : $(this).attr('unit')});
            });
        });
        $('input[name=requested]').each(function(x) {
                        
            if($(this).is(":checked")){
                staff.push({row_id : $(this).attr('row_id'), staff_id:$(this).attr('staff_id'), staff_name: $(this).attr('staff_name'), service_id:$(this).attr('service_id'), requested:"Yes", staff_share:$('#staffshare_'+ $(this).attr('row_id') +'_'+ $(this).attr('service_id') +'_'+$(this).attr('staff_id')).val()});
            } else {
                staff.push({row_id : $(this).attr('row_id'), staff_id:$(this).attr('staff_id'), staff_name: $(this).attr('staff_name'), service_id:$(this).attr('service_id'), requested:"No", staff_share:$('#staffshare_'+ $(this).attr('row_id') +'_'+ $(this).attr('service_id') +'_'+$(this).attr('staff_id')).val()});
            }
        });

        ///new arrays end///
          

        var taxtotal=0;
        var instrument_number="";

        if($("#mode").html()==="Card"){
            if($("#ccno").val()===""){ 
                toastr.warning('Enter Card Number!', 'Instrument number is mandatory'); 
                $('#btninvoice').removeClass('disabled');
                $('#btninvoice').html('Invoice');
                return false;
            }else{
                instrument_number=$("#ccno").val();
            }
        } else if($("#mode").html()==="Check" || $("#mode").html()==="Loyalty"){ 
            if($("#checkno").val()===""){ 
                toastr.warning('Enter Instrument Number!', 'Instrument number is mandatory'); 
                $('#btninvoice').removeClass('disabled');
                $('#btninvoice').html('Invoice');
                return false;
            }else{instrument_number=$("#checkno").val();}
        } else if($("#mode").html()==="Voucher"){
            if($("#voucherno").val()==="" || $("#voucherno").val()==="0"){
                toastr.warning('Enter Voucher Number!', 'Voucher number is mandatory'); 
                $('#btninvoice').removeClass('disabled');
                $('#btninvoice').html('Invoice');
                return false;
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

        
        var myDate = new Date();
        var invoicedate =myDate.getFullYear() + '-' + (myDate.getMonth()<10?'0':'') + (myDate.getMonth()+1) + '-' + (myDate.getDate()<10?'0':'') + myDate.getDate() + ' ' + (myDate.getHours()<10?'0':'') + myDate.getHours() + ':' + (myDate.getMinutes()<10?'0':'') + myDate.getMinutes() + ':' + (myDate.getSeconds()<10?'0':'') + myDate.getSeconds();
        //console.log(invoicedate);
        $.ajax({
            type: 'POST',
            url: 'pos_controller/createinvoice',
            data: {
                visitid: $("#visitid").val(),
                services: services,
                products:products,
                staff:staff,
                
                invoicenumber:'999',
                invoicedate: invoicedate,
                customerid:$("#customerid").val(),
                customername:$("#customername").val(),
                customercell:$("#customercell").val(),
                customeraddress: $("#customeraddress").val(),
                customeremail:$("#customeremail").val(),
                subtotal:$("#txtsubtotal").val(),
                
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
                paymentmode:$("#mode").html(),
                
                uid: $('#uid').val(),
                uname: $('#uname').val(),
                uusername: $('#uusername').val(),
                uemail: $('#uemail').val(),
                
                discount: $('#txtdiscount').val(),
                discount_remarks: $("#ddiscount_remarks").val(),
                returnamount: $('#returnamount').val(),
                advance_amount:$('#txtadvance').val(),                
                other_charges: $('#txtothercharges').val(),
                keepadv: $("#keepadv").prop('checked'),
                retained_used: $("#retainedused").val(),
                retained_amount_used: $("#retainedamountused").val(),
                remaining_retained: $("#remainingretained").val(),
                cctip: $("#txtcctip").val(),
                cc_charge: $("#txtcc_charge").val(),
                remarks:$("#txtinvoiceremarks").val(),
                visitdate:$('#visit-date').val(),
                visittime:$('#visit-time').val(),
                customeradvance:$('#customeradvance').val()
                
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
                    var myWindow = window.open("<?php echo base_url(); ?>existinginvoice/"+ result[1], "_blank");
                    //submitopendirectselect();
                    //submitopenfresh();
                    customer_direct_select($("#customerid").val());
                    
                } else {
                    swal({
                        title: "Error",
                        text: result[1],
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
                      $('#btninvoice').addClass('disabled');
                    $('#btninvoice').html('Invoice');
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
        var orgTotal = 0;
        $("table td:nth-child(9) .combat").each(function () {
            var val = $(this).text();//.replace(" ", "").replace(",-", "");
            theTotal += parseFloat(val);
        });
        
        $('table td:nth-child(9) .orignal_service_rate').each(function() {
            //var val = $(this).val();//.replace(" ", "").replace(",-", "");
            orgTotal += parseFloat($(this).val());
        });

        $('#txtsubtotal').val(theTotal.toFixed(2));
        $('#txt_org_subtotal').val(orgTotal.toFixed(2));
    }


    function perc_discount_service(discount, row_id, idservices) {
        var temp = "#perc_discount_service_"+row_id+'_'+idservices;
        discount=$(temp).val();
        //todo    
        var orignal_unitcost = parseFloat($('#orignal_service_rate_'+row_id+'_' + idservices).val());
        if (discount === "") {
            $('#unitcost_'+row_id+'_' + idservices).text(orignal_unitcost.toFixed(2));
            var temp = '#discount_by_service_' +row_id+'_'+ idservices;
            $(temp).val('');
            service_row_sum();
        } else {
            discount = (parseFloat(discount) * orignal_unitcost) / 100;
            var temp = '#discount_by_service_'+row_id+'_' + idservices;
            $(temp).val(discount);
        }


        discount_by_service(discount, row_id, idservices);

    }
    function discount_by_service(discount, row_id, idservices) {
        var temp = "#discount_by_service_"+row_id+'_'+idservices;
        discount=$(temp).val();
        
        var orignal_unitcost = parseFloat($('#orignal_service_rate_'+row_id+'_' + idservices).val());
        // //console.log(discount);
        // //console.log(orignal_unitcost);
        if (discount === "") {
            $('#unitcost_'+row_id +'_'+ idservices).text(orignal_unitcost.toFixed(2));
            service_row_sum();
            var temp = '#perc_discount_service_'+row_id+'_' + idservices;
            $(temp).val('');
        } else {
            discount = parseFloat(discount);
            var discount_rate = orignal_unitcost - discount;
            $('#unitcost_'+row_id +'_' + idservices).text(discount_rate.toFixed(2));
            service_row_sum();

            var perc_discount = (100 * discount) / orignal_unitcost;
            var temp = '#perc_discount_service_'+row_id+'_'+  idservices;
            $(temp).val(perc_discount);

        }
        //calcdiscount_perc();
        updatetotal();
        var x = '#discount_type_'+row_id+'_'+ idservices;
        $(x).val('Normal');
        staffshare();
    }
    
    
    
    //////////////////Visit Operations/////////////////////
    function getvisitlastcolor(){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'pos_controller/get_color_for_visit'; ?>",
            data:{visit_color: 'color'},
            success: function(data) {
                if(data.length>0){
                    $('#last_color_code').val(data[0].visit_last_color);
                }
            }
        });
    }
    
    
    
    function checkformforupdate(){
        
        if($("#visit-date").val() == '' || $("#visit-time").val()==''){
            
             swal({
                title: "You have not selected the date and time",
                text: "Selection of a date and time is mandatory.",
                type: "error",
                confirmButtonText: 'OK!'
            });
            hideCalendarOverlay();
            return false;
            
        }
        
        if($("#visitid").val()!==""){
            //update
            //console.log('update');
            updatevisitpos();
            
        } else {
            //add
            //console.log('add');
            addvisitpos();
        }
    }
    
    function addvisitpos() {
        
        if($('#customerid').val()==""){
            
            $("#txt-customer-search").select2("open");
            //$("txt-customer-search").select2('focus');
            
            return false;
        }
        
        
        
        
        showCalendarOverlay();
        getvisitlastcolor();

        var visit_id = $("#visitid").val() !== "" ? $("#visitid").val() : 0;
        var customer_id = $("#customerid").val();
        var customer_name = $("#customername").val();
        var last_color_code = $('#last_color_code').val();
        
        var myDate = new Date($("#visit-date").val() + ' ' + $("#visit-time").val());
        var myhour = (myDate.getHours()<10?'0':'') + myDate.getHours(); // 10
        var mymin = (myDate.getMinutes()<10?'0':'') + myDate.getMinutes();
        var start = $('#visit-date').val() +'T'+ myhour+':'+mymin+':00'; //2017-07-20T10:45:00
        var services=[];
        var products=[];
        var requested=[];
               
        
        
        $('input[name=service_ids]').each(function() {
            services.push({row_id:$(this).attr('row_id'), service_id:$(this).val(), service_name:$(this).attr('service_name'), service_duration:$(this).attr('service_duration'), service_flag:$(this).attr('flag'), id_service_category: $(this).attr('id_service_category')});
        });
        
        $('select[name=id_business_products]').each(function() {
            $(this).find('option:selected').each(function(index,element){
                products.push({row_id : $(this).attr('row_id'), service_id: $(this).attr('service_id'),  service_name: $(this).attr('service_name'), product_id: $(this).val(), product_name: $(this).attr('product_name'), qty : $(this).attr('qty'), unit : $(this).attr('unit')});
            });
        });
        $('input[name=requested]').each(function(x) {
            if($(this).is(":checked")){
                requested.push({row_id : $(this).attr('row_id'), staff_id:$(this).attr('staff_id'), staff_name: $(this).attr('staff_name'), service_id:$(this).attr('service_id'), requested:"Yes"});
            } else {
                requested.push({row_id : $(this).attr('row_id'), staff_id:$(this).attr('staff_id'), staff_name: $(this).attr('staff_name'), service_id:$(this).attr('service_id'), requested:"No"});
            }
        });
      
        if (services.length === 0) {

            swal({
                title: "You have not selected any service",
                text: "Selection of a service is mandatory. Please select a service.",
                type: "error",
                confirmButtonText: 'OK!'
            });
            hideCalendarOverlay();
            return false;

        }
        
        
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'pos_controller/addvisits'; ?>",
            data: {
                
                services:services,
                products: products,
                staff: requested,
                customer_id: customer_id,
                customer_name: customer_name,
                start: start,
                visit_id: visit_id,
                last_color_code: last_color_code,
                advance_remarks: $("#txtinvoiceremarks").val()
            },
            success: function(data) {
                var result = data.split("|");
                if (result[0] === "success") {
                   toastr.success('Visit created!', 'Done!');
                   //$('#openvisits').select2().val(result[1]).trigger('change');
                   $('#id_customer_visit').val(result[1]);
                   //submitopenvisit();
                   //return false;
                   clearForm();
                   $("#CurrentAction").html('Invoice or Edit Customer Visit . . .');
                   fill_visit(result[1]);
                   $('#invoicingdiv').slideDown();
                   $("#btninvoice").show(); $("#btnpaymentmode").show();
                   $("#btnvisit").hide();
                   if($("#loyaltyenabled").val()=="Y"){$("#btnloyalty").show();}
                   hideCalendarOverlay();
                   
                } else if (result[0] === "already_exist") {
                    swal({
                        title: "Service already added!",
                        text: '',
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
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

    }

  

    function updatevisitpos() {

        showCalendarOverlay();
        if($('#customerid').val()==""){
            
            $("#txt-customer-search").select2("open");
            //$("txt-customer-search").select2('focus');
            hideCalendarOverlay();
            return false;
            
        }
        
        getvisitlastcolor();

        var visit_id = $("#visitid").val() !== "" ? $("#visitid").val() : 0;
        var customer_id = $("#customerid").val();
        var customer_name = $("#customername").val();
        var last_color_code = $('#last_color_code').val();
        
        var myDate = new Date($("#visit-date").val() + ' ' + $("#visit-time").val());
        var myhour = (myDate.getHours()<10?'0':'') + myDate.getHours(); // 10
        var mymin = (myDate.getMinutes()<10?'0':'') + myDate.getMinutes();
        var start = $('#visit-date').val() +'T'+ myhour+':'+mymin+':00'; //2017-07-20T10:45:00
        var services=[];
        var products=[];
        var requested=[];
               
        $('input[name=service_ids]').each(function() {
            services.push({row_id:$(this).attr('row_id'), service_id:$(this).val(), service_name:$(this).attr('service_name'), service_duration:$(this).attr('service_duration'), service_flag:$(this).attr('flag'), id_service_category: $(this).attr('id_service_category')});
        });
        
        $('select[name=id_business_products]').each(function() {
            $(this).find('option:selected').each(function(index,element){
                products.push({row_id : $(this).attr('row_id'), service_id: $(this).attr('service_id'),  service_name: $(this).attr('service_name'), product_id: $(this).val(), product_name: $(this).attr('product_name'), qty : $(this).attr('qty'), unit : $(this).attr('unit')});
            });
        });
        $('input[name=requested]').each(function(x) {
            if($(this).is(":checked")){
                requested.push({row_id : $(this).attr('row_id'), staff_id:$(this).attr('staff_id'), staff_name: $(this).attr('staff_name'), service_id:$(this).attr('service_id'), requested:"Yes"});
            } else {
                requested.push({row_id : $(this).attr('row_id'), staff_id:$(this).attr('staff_id'), staff_name: $(this).attr('staff_name'), service_id:$(this).attr('service_id'), requested:"No"});
            }
        });

//        //console.log(services);
//        //console.log(products); 
//        //console.log(requested);
//        return false;
//        

        if (services.length === 0) {

            swal({
                title: "You have not selected any service",
                text: "Selection of a service is mandatory. Please select a service.",
                type: "error",
                confirmButtonText: 'OK!'
            });
            hideCalendarOverlay();
            return false;

        }
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'pos_controller/updatevisitpos'; ?>",
            data: {
                services:services,
                products: products,
                staff: requested,
                customer_id: customer_id,
                customer_name: customer_name,
                start: start,
                visit_id: visit_id,
                last_color_code: last_color_code,
                advance_remarks:$("#txtinvoiceremarks").val()
            },
            success: function(data) {
                var result = data.split("|");
                if (result[0] === "success") {
                    toastr.success('Visit created!', 'Done!');
                   $('#id_customer_visit').val(result[1]);
                   submitopenvisit();
                   return false;
//                    clearForm();
//                    toastr.success('Visit updated!', 'Done!');
//                    $("#CurrentAction").html('Invoicing Customer Visit . . .');
//                    fill_visit(result[1]);
//                    $("#btninvoice").show(); $("#btnpaymentmode").show();
//                    $("#btnvisit").hide();
//                    if($("#loyaltyenabled").val()=="Y"){$("#btnloyalty").show();}
//                    $('#invoicingdiv').slideDown();

                } else if (result[0] === "already_exist") {
                    swal({
                        title: "Service already added!",
                        text: '',
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
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

    }
    
    function removebyrow(val) {
        visit_mode();
        $('#customer-visit-list').find("td.id").each(function(index) {
            if ($(this).attr("row_id") === val) {
                $(this).closest('tr').remove();
            }
        });
        
    }
    
    function addServiceRows(service_products) {
       
        var mhtml = "";
        var exists = 0;
        var data="";
        
        var data= {};
        $("#visit-services option:selected").each(function (){            
            $.each(this.attributes, function(){
                if(this.specified) {
                    
                    data[this.name]= this.value;
                    ////console.log(service[this.name]);
                  }
            })            
        });
        //data = $("#visit-services").select2('data');
        ////console.log(data);
        var rowcount=1;
        $('#customer-visit-list tbody>tr').each(function(index) {
            rowcount++;
        });        
                    //service_category service_name service_duration flag id_service_category id_business_services
        mhtml += '<tr>';
        mhtml += '<td class="id" row_id="'+rowcount+'">'+ rowcount +'</td>';
        mhtml += '<td class="tdservicecategory">' + data['service_category'] + '</td>';
        //service            
        mhtml += '<td><input type="hidden" name="service_ids"  row_id='+ rowcount +' service_type="'+data['service_type']+'" service_category="'+data['service_category']+'" service_name="'+data['service_name']+'" service_duration="'+data['service_duration']+'" flag="'+data['flag']+'" id_service_category="'+data['id_service_category']+'" visit_service_start="" value="'+data['id_business_services'] +'">';
        mhtml += '<input type="hidden" name="visit_service_ids" row_id='+ rowcount +' value="">';
        mhtml += data['service_name'] + '</td>';
        
        ///staff-addnew
        mhtml += '<td style="">';
        var index=0;
            $('#visit-staff').children('option:selected').each(function() {
                mhtml += '<input style="display:none" name="" row_id='+ rowcount +' service_id='+ data['id_business_services'] +' staff_name="'+ $(this).text() +'" value="' + $(this).val() + '"/>';
                mhtml += '<div id="staff_' + rowcount + '_' + data['id_business_services'] +  '_' + $(this).val() + '_staff" class="checkbox checkbox-primary"><input id="staff_ids' + rowcount + '_' + $(this).val() + '" type="checkbox" name="requested" row_id='+ rowcount +' service_id='+ data['id_business_services'] +' staff_id=' + $(this).val() + ' staff_name="'+ $(this).text() +'"  /><label for="staff_ids' + rowcount + '_' + $(this).val() + '">'+$(this).text() + '</label>';
                if(index>0){
                    mhtml += '<span class="label label-pink m-l-5" onclick="removeadditionalstaff(\'staff_' + rowcount + '_' + data['id_business_services'] +  '_' + $(this).val() + '_staff\');" style="cursor:pointer">x</span>';
                }
                mhtml += '</div>';
                index++;
            });
        mhtml += "</td>";
       
        ////
        
        ///Products//
        mhtml += '<td >';
        mhtml += '<select multiple="multiple" style="border:none;" class="serviceproducts" id="serviceproducts_'+rowcount+'_'+data['id_business_services']+'" name="id_business_products">';
            $.each(service_products, function(index){
                var selected = "";
                if(index==0){selected='selected="selected" ';} 
                mhtml += '<option row_id='+ rowcount +' service_id='+data['id_business_services']+' service_name='+data['service_name']+' product_service_id="'+ service_products[index].id_services_products + '" unit="'+service_products[index].measure_unit+'" qty="'+service_products[index].usage_qty+'" product_name="'+ service_products[index].product +'" value="'+ service_products[index].id_business_products +'" '+ selected +'>'+ service_products[index].product +'</option>';
            });
        mhtml += '</select>';
            
        mhtml += '</td>';
        
        /// Creating new visit No Discount option
//
//        mhtml += '<td class="discount"><div class="col-lg-12"><div class="form-inline">';
//        var readonly = true; if($("#discount_pw")=='N'){readonly=false;}
//        if(readonly ==false){
//            mhtml += '<input onclick="single_discount_pass(' + data['id_business_services'] + ')" style="border:none; width: 40px;" onkeyup="javascript:discount_by_service(0, ' + data['id_business_services'] + ');" class="numeric discount_by_service" type="text" name="discount_by_service" id="discount_by_service' + data['id_business_services'] + '" placeholder="0"  />';
//        } else {
//            mhtml += '<input readonly onclick="single_discount_pass(' + data['id_business_services'] + ')" style="border:none; width: 40px;" onkeyup="javascript:discount_by_service(0, ' + data['id_business_services'] + ');" class="numeric discount_by_service" type="text" name="discount_by_service" id="discount_by_service' + data['id_business_services'] + '" placeholder="0"  />';
//        }
//        mhtml += '</div></div></td>';
//        if(readonly ==false){
//            mhtml += '<td class="discountperc"><div class="col-lg-12"><div class="form-inline">';
//        } else {
//            mhtml += '<td readonly class="discountperc"><div class="col-lg-12"><div class="form-inline">';
//        }
//        mhtml += '<input onclick="single_discount_pass('+ data['id_business_services'] + ');" style="border:none; width: 40px;" onkeyup="javascript:perc_discount_service(0, '+ data['id_business_services'] +');" class="numeric perc_discount_service" type="text" name="perc_discount_service" id="perc_discount_service'+ data['id_business_services']+'" placeholder="0"  />';
//        mhtml += '</div></div></td>';
//        mhtml += '<td><div class="col-lg-12"><div class="form-inline">';
//        mhtml += '<select class="form-control" name="discount_type" id="discount_type_'+ data['id_business_services']+'">';
//        mhtml += '<option id=""></option><option id="Normal">Normal</option><option id="Promotion">Promotion</option><option id="Promotion">Lapse</option><option id="Birthday">Birthday</option><option id="New Customer">New Customer</option>';
//        mhtml += '</select></div></div></td>';
        ////
        
        mhtml += '<td></td><td></td><td></td>';
        mhtml += '<td >Rs.<span class="combat" id="unitcost_'+rowcount+'_'+data['id_business_services']+' row_id='+ rowcount +' service_id='+data['id_business_services']+' ">'+data['service_rate']+'</span><input type="hidden" class="orignal_service_rate" name="orignal_service_rate" id="orignal_service_rate'+data['id_business_services']+'" value="'+data['service_rate']+'" />';
        mhtml += '</td>';

        mhtml += '<td><span class="label label-danger" onclick="removebyrow(\'' + rowcount + '\');" style="cursor:pointer">x</span></td>';
        mhtml += "</tr>";
        rowcount++;

        if (exists == 0) {
            $("select.serviceproducts").select2('destroy');
            $("#customer-visit-list tbody").append(mhtml);
            $(".serviceproducts").select2();
            service_row_sum();
            updatetotal();
        } else {
            
            swal({
                title: "Service already added!",
                text: 'If you want to change this service, please remove and add again.',
                type: "info",
                confirmButtonText: 'OK!'
            });

        }
    }

    function getserviceproducts(){
        
        var service= {};
        $("#visit-services option:selected").each(function (){            
            $.each(this.attributes, function(){
                if(this.specified) {
                    service[this.name]= this.value;
                  }
            });
        });
               
        var staff = $("#visit-staff option:selected").val();
        if (service == null) {
            swal({
                title: "Service is not selected!",
                text: 'Please select a service and staff to continue.',
                type: "info",
                confirmButtonText: 'OK!'
            });
            $("#btn-add").show();
            return false;
        }
        
        if (staff==null) {
            swal({
                title: "Staff is not selected!",
                text: 'Please select a service and staff to continue.',
                type: "info",
                confirmButtonText: 'OK!'
            });
            
            $("#btn-add").show();
            return false;
        }
        
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() . 'service_controller/getServiceProducts'; ?>",
            data: {serviceid: service['id_business_services']},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                addServiceRows(data);
                $('#visit-staff').val(null).trigger('change');
                $("#visit-services").select2("open");
                $("#btn-add").show();
            }
        });
    }


    function checkopenvisit(cid) {
        
        clearForm();
        
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() . 'visits_controller/getPassedVisitbyCid'; ?>",
            data: {customer_id: cid},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                
                if (data.length > 0) {
                    //$("#CurrentAction").html('Invoicing Customer Visit . . .');
                    fill_visit(data[0]['id_customer_visits']);
                    invoice_mode();
                } else {
                    new_visit_mode();
                    $("#visitid").val('');
                    $("#visitdate").val('');
                    get_customer_details(cid);
                   // $("#visit-services").select2('open');
                    
                }
            }
        });

    }
    
    
    
    ///////////////////////////////////////////////////////
    
    
    
        /////////////////EDIT CUSTOMER/////////////////////
    function openupdate() {
        //var name = $('#customername' + id).val();
        
        id_customers = $("#customerid").val();
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
    
    
    
    function openservicesmodal(){
        
        $("#pickservice").modal({backdrop:'static',
                                keyboard:false,
                                show:true});
        $('#visit-services-types').niceScroll().resize();
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
                        }else if(exist === cell && $('#txtcustomercareof').val()==''){
                            swal({
                                title: "Cell number already exists!",
                                text: "",
                                type: "error",
                                confirmButtonText: 'OK!'
                            });
//                            swal({
//                                title: "Cell number already exists!",
//                                text: "Add another ?",
//                                type: "warning",
//                                showCancelButton: true,
//                               // confirmButtonClass: "btn-danger",
//                               // confirmButtonText: "Yes",
//                               // cancelButtonText: "No",
//                               // closeOnConfirm: true,
//                                closeOnCancel: true
//                              }
//                              ,
//                              function(isConfirm){
//                                  if (isConfirm) {
//                                     //$("#addcustomer").modal('hide');
//                                    //customer_submit();
//                                  } else {
//                                      $("#addcustomer").modal('hide');
//                                      $("#addcustomer input").val('');
//                                    //swal("Cancelled", "Your imaginary file is safe :)", "error");
//                                  }
//                              });
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
                    //console.log(data);
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
            <?php if($this->session->userdata('role')=="Sh-Users"){?>
                window.open('sh_customer_previous_visit/' + customer_id);
            <?php } else { ?>
                window.open('customer_previous_visit/' + customer_id);
            <?php } ?>
        }
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
    
    function hideCalendarOverlay(){
        $('#calendarOverlay').css({
            'display' : 'none'
        });
    }
    //////////////////////////////////////////////////////////////////
    
    function enable_discount_pass(row_id, service_id){
        
        if($('#discount_by_service_'+row_id+'_'+service_id).attr("readonly") && $("#btnloyalty").hasClass('btn-success')){
            if($("#discount_pw").val()=="Y"){
                $("#invoicepass").modal("show");
            } else {
                
                    $("#txtdiscount").attr("readonly",false);
                    $("#txtdiscountperc").attr("readonly",false);
                    $(".discount").attr("readonly",false);
                
                $(".discount_by_service").attr("readonly",false);
                $(".perc_discount_service").attr("readonly",false);
            }
        }   
    }
    
   
    
    function showadvancemodal(){
        $("#cc_charge_setting").val($("#cc_charge").val())
        $("#advancemodal").modal("show")
    }
    
    
    function advancemodalclose(){
        var visitid=$('#visitid').val();
            clearForm();
            fill_visit(visitid);
    }
    
    
    function changestaff(row_id, services_id, staff_id){
        
        var oldstaffid = $('#requested_'+row_id+'_'+services_id+'_'+staff_id).attr('staff_id');
        var oldstaffname = $('#requested_'+row_id+'_'+services_id+'_'+staff_id).attr('staff_name');
        var replacementelement = '#requested_'+row_id+'_'+services_id+'_'+staff_id;
        
        $("#oldstaffid").val(oldstaffid);
        $("#oldstaffname").val(oldstaffname);
        $("#replacementelement").val(replacementelement);

        $("#staffmodal").modal('show');
    }
    
    function pickstaff(staff_id, staff_name){
        visit_mode();
        var replacementelement = $("#replacementelement").val();
        
        var oldstaffid = $("#oldstaffid").val();
        var oldstaffname = $("#oldstaffname").val();
        
             
        $(replacementelement).attr('staff_id', staff_id);
        $(replacementelement).attr('staff_name', staff_name);
        
        var r = replacementelement.split("_");
        
        $(replacementelement).attr('id', 'requested_'+r[1]+'_'+r[2]+'_'+staff_id);
        $('#staffshare_'+r[1]+'_'+r[2]+'_'+r[3]).attr('staff_id', staff_id); 
        var s=$('#staffshare_'+r[1]+'_'+r[2]+'_'+r[3]).attr('onchange').split(',');
        var func=s[3].split('_');
        $('#staffshare_'+r[1]+'_'+r[2]+'_'+r[3]).attr('onchange', s[0]+','+s[1]+',\''+staff_id+'\','+ func[0] +'_'+ func[1] + '_' + func[2]+'_'+staff_id+'\')');
        $('#staffshare_'+r[1]+'_'+r[2]+'_'+r[3]).attr('id', 'staffshare_'+r[1]+'_'+r[2]+'_'+staff_id);
        
        $(replacementelement+'_label').html(staff_name);
        
        var l = $(replacementelement+'_label').attr('ondblclick').split(',');
        $(replacementelement+'_label').attr('ondblclick',l[0]+','+l[1]+','+staff_id+')');
        $(replacementelement+'_label').attr('id','requested_'+r[1]+'_'+r[2]+'_'+staff_id+'_'+'label');
        
        $('#staffmodal').modal('hide');
    }
    
    
    function getopen_visits(){
        $.ajax({
                type: 'POST',
                url: 'pos_controller/get_open_visit',
                data: {source:'pos'},
                dataType: "json",
                cache: false,
                async: true,
                success: function(data) {
                    
                    var openvisits=data.visits;
                    var inservice=data.inservice;
                    var htmlvisits='';
                    if(openvisits.length>0){
                        $("#openvisits").select2('val','');
                        $("#openvisits").html('');
                        $("#openvisits").append('<option customerid="0" value="0">All Appointments</option>');
                        for(x=0; x<openvisits.length;x++){
                            $("#openvisits").append('<option customerid="'+ openvisits[x]['id_customers'] +'" value="' + openvisits[x]['id_customer_visits'] +'">' + openvisits[x]['mDate']+ ' ' + openvisits[x]['customer_name'] + '</option>');
                        }
                        $('#openvisits').val(0).trigger('change');
                    } else {
                        $("#openvisits").select2('val','');
                        $("#openvisits").html('');
                        $("#openvisits").append('<option customerid="0" value="0">All Appointments</option>');
                        $('#openvisits').val(0).trigger('change');
                    }
                    
                    if(inservice.length>0){
                        $("#inservicevisits").select2('val','');
                        $("#inservicevisits").html('');
                        $("#inservicevisits").append('<option customerid="0" value="0">Clients Being Serviced</option>');
                        for(x=0; x<inservice.length;x++){
                            $("#inservicevisits").append('<option customerid="'+ inservice[x]['id_customers'] +'" value="' + inservice[x]['id_customer_visits'] +'">' + inservice[x]['mDate']+ ' ' + inservice[x]['customer_name'] + '</option>');
                        }
                        $('#inservicevisits').val(0).trigger('change');
                    } else {
                        $("#inservicevisits").select2('val','');
                        $("#inservicevisits").html('');
                        $("#inservicevisits").append('<option customerid="0" value="0">Clients Being Serviced</option>');
                        $('#inservicevisits').val(0).trigger('change');
                    }
                }
            });
    }
    function removeadditionalstaff(id){
        visit_mode();
        id="#"+id;
        $(id).remove();
        staffshare();
    }
    
        function mark_inservice(){
    
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() . 'customer_controller/mark_inservice'; ?>",
            data: {visit_id: $("#visitid").val()},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                
                toastr.success('Marked as in-service!', 'Done!');
                $("#lblinservice").html('In-Service');
                $("#btninservice").hide();
            }
        });
        
    }
</script>