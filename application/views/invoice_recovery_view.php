        <div class="wrapper">
            <div class="container">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">Recovery Invoice</h4>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <h4>Invoice</h4>
                            </div> -->
                            <input type="hidden" id="old_invoice_id" value="<?php echo $invoice[0]['id_invoice']; ?>">
                            <div class="panel-body">
                                <div class="clearfix">
                                    <div class="pull-left">
                                        <h3 class="logo invoice-logo"><?php if(isset($business)){ echo "<img src='".base_url().'assets/images/business/'.$business[0]['business_logo']."' alt='".$business[0]['business_name']."' />";} else {echo 'SalonPK';}?></h3>
                                    </div>
                                    <div class="pull-right">
                                        <h4>Invoice # <br>
                                            <strong id="invoicenumber"><?php echo  date("Y").'-'.date("m").'-'; if(isset($invoiceno)){ echo sprintf("%04s",$invoiceno[0]['id_invoice']+1);}else{echo '00001';} ?></strong>
                                        </h4>
                                        <h5>Reference Invoice # <br>
                                            <a href="<?php if($invoice[0]['invoice_type']=='service'){echo base_url().'existinginvoice/'.$invoice[0]['id_invoice'];}else {echo base_url().'existingorderinvoice/'.$invoice[0]['id_invoice'];} ?>" target="_blank" ><strong id="invoicereference"><?php echo $invoice[0]['invoice_number']; ?></strong></a>
                                        <br>
                                            <strong id="oldinvoicedate"><?php echo $invoice[0]['invoice_date']; ?></strong>
                                        </h5>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="pull-left m-t-30">
                                            <input name="visitid" id="visitid" type="hidden" value="<?php echo $visitid; ?>"/>
                                            <input name="visittime" id="visittime" type="hidden" value="<?php echo $invoice[0]['visit_time']; ?>"/>
                                            <input name="customerid" id="customerid" type="hidden" value="<?php echo $customer[0]['id_customers']; ?>"/>
                                            <input name="txtinvoiceid" id="txtinvoiceid" type="hidden" value=""/>
                                            <input name="loyaltypoints" id="loyaltypoints" type="hidden" value="<?php echo $customer[0]['loyalty_points']; ?>"/>
                                            <input name="loyaltyused" id="loyaltyused" type="hidden" value="0"/>
                                            <input name="loyaltyrate" id="loyaltyrate" type="hidden" value="<?php echo $business[0]['l_point_discount']; ?>"/>
                                            <input name="loyaltyvalue" id="loyaltyvalue" type="hidden" value="<?php echo $business[0]['l_point_value']; ?>"/>
                                            <input name="loyaltyenabled" id="loyaltyenabled" type="hidden" value="<?php echo $business[0]['loyalty_enable']; ?>"/>                                            
                                            <input name="ddiscount_remarks" id="ddiscount_remarks" type="hidden" value=""/>
                                            <input name="discount_remarks" id="discount_remarks" type="hidden" value=""/>
                                            <address>
                                              <strong><?php echo $customer[0]['customer_name']; ?></strong><br>
                                              <?php echo $customer[0]['customer_address']; ?><br>
                                              <?php echo $customer[0]['customer_email']; ?><br>
                                              <abbr title="Phone">P:</abbr> <?php 
                                                    if( $this->session->userdata('hide_cell') && $this->session->userdata('hide_cell') == "No"){ 
                                                        echo $customer[0]['customer_cell']; 
                                                    } 
                                              ?>
                                              </address>
                                        </div>
                                        <div class="pull-right m-t-30">
                                            <p><strong>Invoice Date: </strong> <span id="invoice_date"><?php echo date('Y-m-d H:i:s'); ?></span></p>
                                            <p class="m-t-10"><strong>Service Status: </strong> <span class="label label-pink">Provided</span></p>
                                            
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="m-h-50"></div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table m-t-30" id="tblservices">
                                                <thead>
                                                    <tr><th>#</th>
                                                    <th>Item</th>
                                                    <th>Description</th>
                                                    <th>Staff</th>
                                                    <th>Products</th>
                                                    <th>Discount</th>
                                                    <th>Service Cost</th>
                                                    
                                                </tr></thead>
                                                <tbody>
                                                    <?php $x=1; if(isset($invoicedetails)){
                                                        foreach($invoicedetails as $invoicedetail){?>
                                                        <tr>
                                                            <td><?php echo $x;?></td>
                                                            <td><?php echo $invoicedetail['service_category']; ?></td>
                                                            <td>
                                                                
                                                                <?php echo $invoicedetail['service_name']; ?>
                                                            </td>
                                                            <td <?php 
                                                                if(isset($business[0]['invoice_staff'])){if($business[0]['invoice_staff']==='Y'){}else {echo 'class="hidden-sm hidden-xs"';}} ?> >
                                                                    <?php foreach($invoicestaff as $invs){
                                                                       if($invs['invoice_detail_id']==$invoicedetail['id_invoice_details']) {
                                                                           echo $invs['staff_name'].'<br>';
                                                                       }
                                                                    }?>
                                                            </td>
                                                            
                                                            <td><?php echo str_replace('|','<br> ',$invoicedetail['products']); ?></td>
                                                            <td >Rs.<span><?php echo $invoicedetail['discount']; ?></span></td>
                                                            <input style="display:none;border:none; width: 40px;" class="numeric discount_by_service" type="text" name="discount_by_service" id="discount_by_service<?php echo $invoicedetail['service_name']; ?>" placeholder="0" value="<?php echo $invoicedetail['discount']; ?>" />
                                                            <td >Rs.<span class="combat" id="unitcost<?php echo $invoicedetail['service_name']; ?>"><?php echo $invoicedetail['price']-$invoicedetail['discount']; ?></span><input type="hidden" name="orignal_service_rate" id="orignal_service_rate<?php echo $invoicedetail['service_name']; ?>" value="<?php echo $invoicedetail['price']-$invoicedetail['discount']; ?>" /></td>
                                                        </tr>
                                                        <?php $x++;}} ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php
                                $sub_total = $invoice[0]['sub_total'];
                                $balance_rs = $invoice[0]['balance'];
                                $discount_rs = $invoice[0]['discount'];
                                $discount_percentage = ($discount_rs / $sub_total) * 100;
                                $other_charges=$invoice[0]['other_charges'] ;
                                $gross_rs = ($sub_total + $other_charges) - $discount_rs;
                                $tax_rs = $invoice[0]['tax_total'];
                                //$grand_rs = $gross_rs + $tax_rs;
                                //$paid_rs = $invoice[0]['net_amount'] - $tax_rs - $balance_rs;
                                
                                $grand_rs = $gross_rs + $tax_rs+ $invoice[0]['cc_charge'];
                                $paid_rs = $invoice[0]['paid_amount']+$invoice[0]['advance_amount'];
                                
                                $total_payable=$invoice[0]['total_payable'];
                                ?>
                                
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="clearfix m-t-40">
                                            <h5 class="small text-inverse font-600">PAYMENT TERMS AND POLICIES</h5>

                                            <small>
                                                <?php echo $business[0]['payment_terms'];?>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-6 col-md-offset-3">
                                        <p class="text-right"><b>Sub-total:</b>   Rs. <input id="txtsubtotal" class="form-inline" readonly="readonly" style="width: 80px; border: none;" value='<?php echo $sub_total; ?>'></p>
                                        <p class="text-right">Discount: <input readonly="readonly" id="txtdiscountperc" class="form-inline" style="width: 20px; border: none;" value="<?php echo $discount_percentage; ?>">%   Rs. <input readonly="readonly" id="txtdiscount" class="form-inline" style="width: 80px; border: none;" value="<?php echo $discount_rs; ?>"/></p>
                                        <p class="text-right">Other Charges Rs.: <input class="numeric"  id="txtothercharges" class="form-inline " style="width: 80px; border: none;" value="<?php echo $other_charges; ?>"/></p>
                                        <p class="text-right">Gross Total:   Rs. <input id="txtgross" readonly="readonly" class="form-inline " style="width: 80px; border: none;" value="<?php echo $gross_rs; ?>"></p>
                                        <p class="text-right">Tax Total: Rs. <input id="taxrs" readonly="readonly" class="form-inline " style="width: 80px; border: none;" value="<?php echo $tax_rs; ?>"></p>
                                        <p class="text-right">CC Charge: Rs.<input readonly="readonly" class="form-inline " style="width: 80px; border: none;" value="<?php echo $invoice[0]['cc_charge']; ?>" /></p>
                                        <div class="m-t-10 m-b-10" id="divcccharge" style="display:none">

                                            <p class="text-right text-danger">
                                                <span >CC Fee @ <?php echo $business[0]['cc_charge'].' '; ?>%</span> :  Rs. 
                                                <input class="cccharge" id="txtcc_charge" name="txtcc_charge" readonly="readonly" class="form-inline " style="width: 80px; border: none;" value="0" />
                                            </p>
                                            
                                        </div>
                                        <input id="cc_charge" type="hidden" value="<?php echo $business[0]['cc_charge'];?>">    
                                        <p class="text-right">Total Payable Amount:   Rs. <input id="txttotalpayable" readonly="readonly" class="form-inline " style="width: 80px; border: none;" value="<?php echo $total_payable; ?>" /></p>
                                        <hr>
                                        <h3 class="text-right text-success">  Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly" id="grandtotal"  name="grandtotal" value="<?php echo $grand_rs; ?>"></h3>
                                        <h4 class="text-right">  Paid Rs. <input readonly="readonly" style="text-align: right; width: 95px; border: none;" id="paid"  name="paid" value="<?php echo $paid_rs; ?>"><input type="hidden" id="paid_rs" value="<?php echo $paid_rs; ?>"></h4>
                                        <h4 class="text-right text-danger">  Balance Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly" id="balanceamount" name="balanceamount" value="<?php echo $balance_rs; ?>"><input type="hidden" id="balance_rs" value="<?php echo $balance_rs; ?>"></h4>
                                        <hr/>
                                        <h4 class="text-right">  Pay Now Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" onchange="updatetotal();" onclick="$(this).select();" id="pnid"  name="pnid" value="0"></h4>
                                        <h4 id="payingcash" class="text-right" style="display:none;" >Cash Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" onchange="updatepaying();" onclick="$(this).select();" id="cashpaid"  name="cashpaid" value="0"/></h4>
                                        <h4 id="payingcard" class="text-right" style="display:none;">Card Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" onchange="updatepayingcard();" onclick="$(this).select();" id="cardpaid"  name="cardpaid" value="0"/></h4>

                                        <h4 class="text-right text-primary">  Return Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly" id="returnamount"  name="returnamount" value="0"></h4>
                                        
                                    </div>
                                </div>
                                <hr>
                                <div class="text-right hidden-print">
                                    <p id="modep"><strong>Payment mode: </strong> <span id="mode">Cash</span></p>
                                    <p id="ccp" style="display:none;"><strong>C-Card #: </strong> <input class="numeric" style="width: 120px; border: none;" id="ccno"  name="ccno"/></p>
                                    <p id="checkp" style="display:none;"><strong>Instrument #: </strong> <input class="numeric" style="width: 120px; border: none;" id="checkno"  name="checkno"/></p>
                                    <p id="voucherp" style="display:none;">
                                        <strong>Voucher #: C</strong> 
                                        <input class="numeric" style="width: 100px; border: none;" id="voucherno" name="voucherno">
                                        <button class="btn btn-success btn-xs" onclick="validateVouchers();">Verify</button>
                                    </p>
                                </div>
                                
                                <div class="hidden-print">
                                    <div class="pull-right">
                                       
                                        <div class="btn-group m-r-10 dropup">
                                            
                                            <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Payment mode <span class="m-l-5"><i class="fa fa-money"></i></span></button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="javascript:void(0);" onclick="opencash();">Cash</a></li>
                                                <li><a href="javascript:void(0);" onclick="opencc();">Credit Card</a></li>
                                                
                                                <li><a href="javascript:void(0);" onclick="opendc();">Debit Card</a></li>
                                                
                                                <li><a href="javascript:void(0);" onclick="openbank('Check');">Check</a></li>
                                                <!--<li><a href="javascript:void(0);" onclick="openvoucher('Voucher');">Voucher</a></li>-->
                                                <li><a href="javascript:void(0);" onclick="openmixed('Mixed');">Mixed</a></li>
                                                <!--<li><a href="javascript:void(0);" onclick="openbalance('Balance');">Balance</a></li>-->
                                            </ul>
                                         </div>
                                        <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light" id="btnprint" style="display: none;"><i class="fa fa-print"></i></a>
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
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <input required type="password" name="discount_password" id="discount_password" class="form-control" />
                                                    </div> 
                                                </div> 
                                            </div>

                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect modal_close" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-custom waves-effect waves-light ">Continue</button>
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
<script>
    var enabtax=false;
    
    $(document).ready(function(){
         $(".numeric").keypress(function (e) {
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
        <?php if(!$this->session->userdata('discount_session')){ ?>
            $("#txtdiscountperc").keypress(function() {
                $("#invoicepass").modal("show");
            });
            
            $("#txtdiscount").keypress(function() {
                $("#invoicepass").modal("show");
            });
            
        <?php } ?>    
        $(".modal_close").click(function() {
            <?php $this->session->unset_userdata('discount_session'); ?>
            location.reload();
        });
        
                    
        $('#discountForm').on('submit', function(e) {

        e.preventDefault();
            $.ajax({
            url: $(this).attr('action') || window.location.pathname,
            type: "POST",
            data: $(this).serialize(),
            success: function(data) {
                if (data === "success"){
                    //$("#invoicepass").modal("hide");
                    location.reload();
                } 
            },
            error: function(jXHR, textStatus, errorThrown) {
            alert(errorThrown);
            }
            });
        });
 

       $("#txtdiscount").change(function(){
            $("#paid").val($("#grandtotal").val());
            $("#balanceamount").val(parseFloat($("#grandtotal").val()) - parseFloat($("#paid").val()));
        });
        $('#btnsubmit').removeClass('disabled');
    });   
    
    function enabletaxes(val){
        if(val==='yes'){
            enabtax=true;
            //console.log('here');
            $("#divtaxes").slideDown();
            updatetotal();
        } else {
            enabtax=false;
            $("#divtaxes").slideUp();
            updatetotal();
        }
    }
       
    function updatetotal(){
        
        if($('#txtdiscount').val()===""){$('#txtdiscount').val('0');}
       
        var grosstotal=(parseFloat($("#txtsubtotal").val()) +parseFloat($("#txtothercharges").val())) - parseFloat($("#txtdiscount").val());
        
        $("#txtgross").val(grosstotal);
        
        var nettax = parseInt($('#taxrs').val(), 10);

        $("#grandtotal").val(grosstotal + nettax + parseFloat($("#txtcc_charge").val()));
        
        var pay_now = parseInt($('#pnid').val());
        
        if($("#pnid").val() === "0" || $("#pnid").val() === ""){
            //$("#paid").val(grosstotal + nettax + pay_now);
            $("#balanceamount").val(parseFloat($("#balance_rs").val()) + parseFloat($("#txtcc_charge").val()));
            $("#pnid").val(0);
        } else {
            //$("#paid").val(parseInt($("#paid_rs").val()) + pay_now);
            $("#balanceamount").val((parseInt($("#balance_rs").val())+ parseFloat($("#txtcc_charge").val()) - pay_now));
        }
        
        var new_paid = parseInt($('#paid').val()) + parseInt($('#pnid').val());
        
        if(pay_now > parseInt($('#balance_rs').val())+ parseFloat($("#txtcc_charge").val())){
            $('#returnamount').val(pay_now - (parseInt($('#balance_rs').val()) + parseFloat($("#txtcc_charge").val())));
            $("#balanceamount").val(0);
        } else{
            $("#returnamount").val(0);
        }
        
        
    }
    
    function updatepaying(){
        
        $("#pnid").val(parseFloat($("#cashpaid").val()) + parseFloat($("#cardpaid").val()));
        updatetotal();
    }
    
    function updatepayingcard(){
        if(parseFloat($("#cc_charge").val()) > 0){
            $("#divcccharge").show();
            $("#txtcc_charge").val("0");
            console.log('grandtotal : '+ parseFloat($("#grandtotal").val()) + " cc_charge : " + $("#cc_charge").val());
            var ccc= (parseFloat($("#cardpaid").val()) * parseInt($("#cc_charge").val()))/100;
            $("#txtcc_charge").val(Math.round(ccc));
            $("#cardpaid").val(parseFloat($("#cardpaid").val()) + ccc);
        }
        
        $("#pnid").val(parseFloat($("#cashpaid").val()) + parseFloat($("#cardpaid").val()));
        
        updatetotal();
    }
    
    function createinvoice(){
        
       var totalServices = $('input[name=discount_by_service]').length;

        var service_discount = [];
        $('input[name=discount_by_service]').each(function(x) {
            var discount = $(this).val() === "" ? 0 : $(this).val();
            service_discount.push(parseFloat(discount));
        });

        var discounted_price = [];
        $('input[name=orignal_service_rate]').each(function(x) {
            discounted_price.push(parseFloat($(this).val()));
        });

        
//        for(var x = 0; x < totalServices; x++){
//
//            var totalDiscount = parseFloat($('#txtdiscountperc').val());
//            totalDiscount = totalDiscount / 100;
//
//            var sale_price = discounted_price[x] * (1 - totalDiscount);
//
//            service_discount[x] += discounted_price[x] - sale_price;
//            discounted_price[x] = sale_price;
//
//        }

        var taxtotal=0;
        var instrument_number="";
        
        var recovery_status;
        
        if($('#pnid').val() === '0' || $('#pnid').val() === ''){
            return false;
        }
        
        if(parseInt($('#balanceamount').val()) > 0){
            recovery_status = "Yes";
        } else{
            recovery_status = "No";
        }
        
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
        
        $('#btnsubmit').addClass('disabled');
        $('#btnsubmit').html('<i class="fa fa-spin fa-spinner"></i> Please wait');
    
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>invoice_controller/updaterecoveryinvoice',
            data: {
                visitid: $("#visitid").val(),
                invoicenumber: $("#invoicenumber").html(),
                invoicedate: $("#invoice_date").html(),
                referenceinvoicenumber: $("#invoicereference").html(),
                recovery: recovery_status,
                customerid: $("#customerid").val(),
                subtotal: $("#txtsubtotal").val(),
                discount: $("#txtdiscount").val(),
                loyaltyenabled:$("#loyaltyenabled").val(),
                loyaltyused:$("#loyaltyused").val(),
                loyaltyrate:$("#loyaltyrate").val(),
                loyaltyvalue:$("#loyaltyvalue").val(),
                grosstotal: $("#txtgross").val(),
                paid: parseInt($('#pnid').val()) - parseInt($('#returnamount').val()),
                cashpaid: parseInt($("#cashpaid").val()),
                cardpaid: parseInt($("#cardpaid").val()),
                grandtotal: $("#grandtotal").val(),
                taxtotal: parseInt($('#taxrs').val()),
                mode: $("#mode").html(),
                instrument_number: instrument_number,
                balance: $('#balanceamount').val(),
                returnamount: $('#returnamount').val(),
                old_invoice_id: $('#old_invoice_id').val(),
                discount_remarks: $("#ddiscount_remarks").val(),
                discounted_price: discounted_price,
                service_discount: service_discount,
                visit_time: $("#visittime").val(),
                other_charges:$("#txtothercharges").val(),
                cc_charge: $("#txtcc_charge").val(),
                total_payable: $("#txttotalpayable").val(),
                advance: $("#paid").val()
            },
            success: function(data) {
                var result = data.split("|");
                if (result[0] === "success") {
                    $("#txtinvoiceid").val(result[1]);
                    //$("#btnprint").show();
                    //$("#btnsubmit").hide();
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
    }
    
    function opencc(){
        if($("#ccp").is(":hidden")){
            $("#ccp").slideDown();
        }
        if($("#voucherp").is(":visible")){
            $("#voucherp").slideUp();
        }
        if($("#balance").is(":visible")){
            $("#balance").slideUp();
        }
        if($("#ccp").is(":visible")){
            $("#checkp").slideUp();
        }
        if($("#payingcash").is(":visible")){
            $("#payingcash").slideUp();
        }
        if($("#payingcard").is(":visible")){
            $("#payingcard").slideUp();
        }

        if( parseFloat($("#cc_charge").val()) > 0){
            $("#divcccharge").show();
            $("#txtcc_charge").val("0");
            console.log(parseInt($("#cc_charge").val()));
            var ccc= ((parseInt($("#grandtotal").val()) - parseInt($("#paid").val())) * parseInt($("#cc_charge").val()))/100;
            console.log(ccc);
            $("#txtcc_charge").val(Math.round(ccc));
            
        }
        updatetotal();
        
        $("#cctip").show();
        $("#mode").html('Card');
     //   $("#paid").removeAttr("disabled");
        $("#cashpaid").val("0");
        $("#cardpaid").val("0");
     //   $("#paid").val("0");
    }
    function opendc(){
        if($("#ccp").is(":hidden")){
            $("#ccp").slideDown();
        }
        if($("#voucherp").is(":visible")){
            $("#voucherp").slideUp();
        }
        if($("#balance").is(":visible")){
            $("#balance").slideUp();
        }
        if($("#ccp").is(":visible")){
            $("#checkp").slideUp();
        }
        if($("#payingcash").is(":visible")){
            $("#payingcash").slideUp();
        }
        if($("#payingcard").is(":visible")){
            $("#payingcard").slideUp();
        }

        $("#divcccharge").hide();
        $("#txtcc_charge").val("0");
        updatetotal();
        
        $("#cctip").show();
        $("#mode").html('Card');
      //  $("#paid").removeAttr("disabled");
        $("#cashpaid").val("0");
        $("#cardpaid").val("0");
      //  $("#paid").val("0");
    }
    function openvoucher(mode){
        if($("#voucherp").is(":hidden")){
            $("#voucherp").slideDown();
            $('#paid').val('0');
        }
        if($("#checkp").is(":visible")){
            $("#checkp").slideUp();
        }
        if($("#balance").is(":visible")){
            $("#balance").slideUp();
        }
        if($("#ccp").is(":visible")){
            $("#ccp").slideUp();
        }
        if($("#payingcash").is(":visible")){
            $("#payingcash").slideUp();
        }
        if($("#payingcard").is(":visible")){
            $("#payingcard").slideUp();
        }
        
        $("#divcccharge").hide();
        $("#txtcc_charge").val("0");
        updatetotal();
        
        $("#cctip").hide();
        $("#mode").html(mode);
      //  $("#paid").removeAttr("disabled");
        $("#cashpaid").val("0");
        $("#cardpaid").val("0");
      //  $("#paid").val("0");
    }
    
    function openbank(mode){
        if($("#checkp").is(":hidden")){
            $("#checkp").slideDown();
        } 
        if($("#voucherp").is(":visible")){
            $("#voucherp").slideUp();
        }
        if($("#balance").is(":visible")){
            $("#balance").slideUp();
        }
        if($("#ccp").is(":visible")){
            $("#ccp").slideUp();
        }
        if($("#payingcash").is(":visible")){
            $("#payingcash").slideUp();
        }
        if($("#payingcard").is(":visible")){
            $("#payingcard").slideUp();
        }
        
        $("#divcccharge").hide();
        $("#txtcc_charge").val("0");
        updatetotal();
        
        $("#cctip").hide();
        $("#mode").html(mode);
       // $("#paid").removeAttr("disabled");
        $("#cashpaid").val("0");
        $("#cardpaid").val("0");
       // $("#paid").val("0");
    }
    
    function opencash(){
        
        if($("#ccp").is(":visible")){
            $("#ccp").slideUp();
        }
        if($("#voucherp").is(":visible")){
            $("#voucherp").slideUp();
        }
        if($("#checkp").is(":visible")){
            $("#checkp").slideUp();
        }
        if($("#balance").is(":visible")){
            $("#balance").slideUp();
        }
        if($("#payingcash").is(":visible")){
            $("#payingcash").slideUp();
        }
        if($("#payingcard").is(":visible")){
            $("#payingcard").slideUp();
        }
        
        $("#divcccharge").hide();
        $("#txtcc_charge").val("0");
       updatetotal();
       
        $("#cctip").hide();
        $("#mode").html('Cash');
        //$("#paid").removeAttr("disabled");
        $("#cashpaid").val("0");
        $("#cardpaid").val("0");
        //$("#paid").val("0");
    }
    
    function openmixed(){
        
        if($("#payingcash").is(":hidden")){
            $("#payingcash").slideDown();
        }
        if($("#payingcard").is(":hidden")){
            $("#payingcard").slideDown();
        }
        if($("#ccp").is(":visible")){
            $("#ccp").slideUp();
        }
        if($("#voucherp").is(":visible")){
            $("#voucherp").slideUp();
        }
        if($("#checkp").is(":visible")){
            $("#checkp").slideUp();
        }
        if($("#balance").is(":visible")){
            $("#balance").slideUp();
        }
        
        if(parseFloat($("#cc_charge").val()) > 0){
            $("#divcccharge").show();
            $("#txtcc_charge").val("0");
           
            var ccc= (parseFloat($("#cardpaid").val()) * parseInt($("#cc_charge").val()))/100;
            $("#txtcc_charge").val(Math.round(ccc));
            
        }
        updatetotal();
        $("#cctip").show();
        $("#mode").html('Mixed');
        $("#cashpaid").val("0");
        $("#cardpaid").val("0");
       // $("#paid").val("0");
       // $("#paid").attr("disabled","disabled");
        
    }
    
    function openbalance(){
        
        if($("#voucherp").is(":visible")){
            $("#voucherp").slideUp();
        }
        if($("#ccp").is(":visible")){
            $("#ccp").slideUp();
        }
        if($("#checkp").is(":visible")){
            $("#checkp").slideUp();
        }        
        if($("#balance").is(":hidden")){
            $("#balance").slideDown();
        }
        if($("#payingcash").is(":visible")){
            $("#payingcash").slideUp();
        }
        if($("#payingcard").is(":visible")){
            $("#payingcard").slideUp();
        }
        
        $("#divcccharge").hide();
        $("#txtcc_charge").val("0");
        updatetotal();
        
        $("#cctip").hide();
        $("#mode").html('Balance');
       // $("#paid").removeAttr("disabled");
    }
    
    
    function calcdiscount_perc(){
        var result=0;
        if($("#txtdiscountperc").val() !== "" && $("#txtdiscountperc").val()>0){
            result = parseInt($("#txtsubtotal").val())*parseInt($("#txtdiscountperc").val());
            result=result/100;
        }
        
        $("#txtdiscount").val(result);
        updatetotal();
        $("#paid").val($("#grandtotal").val());
        $("#balanceamount").val(parseFloat($("#grandtotal").val()) - parseFloat($("#paid").val()));
    }
    
    function validateVouchers(){
        
        if($('#voucherno').val() === "" || $('#voucherno').val() === "0"){
            return false;
        } else{
            var voucherno = 'C'+$('#voucherno').val();
            
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>Voucher_controller/validateVoucher',
                data: {
                    voucherno: voucherno
                },
                success: function(response) {
                    var data = $.parseJSON(response);
                    if(data.length > 0){
                        
                        if(data[0]['type'] === 'service'){
                            swal({
                                title: 'Not Allowed',
                                text: 'Voucher Type [Service] Not Allowed in Recovery Invoices',
                                type: 'error',
                                confirmButtonText: 'OK!'
                            });
                            return false;
                        }
                        
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
                                html += '<tr><td>Total Amount Rs.</td><td>'+data[0]['amount']+'</td></tr>';
                                html += '<tr><td>Remaining Amount Rs.</td><td>'+data[0]['remaining_amount']+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 11px;">(This amount will be apply to the invoice)</span></td></tr>';
                                html += '<tr><td></td><td></td></tr>';
                            html += '</tbody>';
                        html += '</table>';
                        
                        $('#voucherType').val(data[0]['type']);
                        $('#voucherAmount').val(data[0]['amount']);
                        $('#voucherRemainingAmount').val(data[0]['remaining_amount']);
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
        
        if($('#voucherAmount').val() === "" || $('#voucherAmount').val() === "0" || $('#voucherRemainingAmount').val() === "" || $('#voucherRemainingAmount').val() === "0"){
            return false;
        } else{
            
            var remaining = parseInt($('#voucherRemainingAmount').val());
            //var grandtotal = parseInt($('#grandtotal').val());
            var balance = parseInt($('#balanceamount').val());
            //var type = $('#voucherType').val();
            
            if(remaining >= balance){
                $('#pnid').val(balance);
                $('#voucherRemainingAmount').val(remaining - balance);
            }
            if(remaining < balance){
                $('#pnid').val(remaining);
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
            url: '<?php echo base_url(); ?>Voucher_controller/updateRemainingAmount',
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
    
    
</script>