        <div class="wrapper">
            <div class="container">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
<!--                        <div class="btn-group pull-right m-t-15">
                            <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Taxes <span class="m-l-5"><i class="fa fa-cog"></i></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="javascript:void(0);" onclick="enabletaxes('yes');">Enable Taxes</a></li>
                                <li><a href="javascript:void(0);" onclick="enabletaxes('no');">Disable Taxes</a></li>
                                
                            </ul>
                        </div>-->
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
                                            <strong id="invoicereference"><?php echo $invoice[0]['invoice_number']; ?></strong>
                                        </h5>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="pull-left m-t-30">
                                            <input name="orderid" id="orderid" type="hidden" value="<?php echo $invoice[0]['visit_id']; ?>"/>
                                            <input name="customerid" id="customerid" type="hidden" value="<?php echo $invoice[0]['id_customers']; ?>"/>
                                            <input name="txtinvoiceid" id="txtinvoiceid" type="hidden" value=""/>
                                            <input name="txtvisittime" id="txtvisittime" type="hidden" value="<?php echo $invoice[0]['visit_time']; ?>"/>
                                            <address>
                                              <strong><?php echo $invoice[0]['customer_name']; ?></strong><br>
                                              <?php echo $invoice[0]['customer_address']; ?><br>
                                              <?php echo $invoice[0]['customer_email']; ?><br>
                                              <abbr title="Phone">P:</abbr><?php 
                                                    if( $this->session->userdata('hide_cell') && $this->session->userdata('hide_cell') == "No"){ 
                                                        echo $invoice[0]['customer_cell']; 
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
                                            <table class="table m-t-30" id="tblproducts">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Brand</th>
                                                        <th>Item</th>
                                                        <th>Sold by</th>
                                                        <th>Qty.</th>
                                                        <th>Unit Price</th>
                                                        <th>Discount</th>
                                                        <th>Final Price</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $subtotal=0; if(isset($products)){$x=1;
                                                        foreach($products as $product){
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $x;?></td>
                                                            <td><?php echo $product['brand_name']; ?></td>
                                                            <td><?php echo $product['product_name']; ?></td>
                                                            <td><?php echo $product['staff_name']; ?></td>
                                                            <td><?php echo $product['invoice_qty']; ?></td>
                                                            <td><?php echo $product['price']; ?></td>
                                                            <td><?php echo $product['discount']; ?></td>
                                                            <td>Rs.<span id="unitcost"><?php echo ($product['price']-$product['discount'])*$product['invoice_qty']; ?> </span></td>
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
                                $gross_rs = $invoice[0]['gross_amount'];
                                $tax_rs = $invoice[0]['tax_total'];
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
                                        <div class="m-t-10 m-b-10" id="divcccharge" <?php if($invoice[0]['cc_charge']>0){}else{echo 'Style="display:none;"';} ?>>

                                            <p class="text-right">
                                                <span >CC Fee @ <?php echo $business[0]['cc_charge'].' '; ?>%</span> :  Rs. 
                                                <input class="cccharge" id="txtcc_charge" name="txtcc_charge" readonly="readonly" class="form-inline " style="width: 80px; border: none;" value="<?php echo $invoice[0]['cc_charge']; ?>" />
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
                                                <li><a href="javascript:void(0);" onclick="openmixed('Mixed');">Mixed</a></li>
                                            </ul>
                                        </div>
                                        <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light" id="btnprint" style="display: none;"><i class="fa fa-print"></i></a>
                                        <a href="javascript:void(0);" onclick="createinvoice();" class="btn btn-primary waves-effect waves-light" id="btnsubmit">Submit</a>
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
    
    function enabletaxes(val){
        if(val==='yes'){
            enabtax=true;
            console.log('here');
            $("#divtaxes").slideDown();
            updatetotal();
        } else {
            enabtax=false;
            $("#divtaxes").slideUp();
            updatetotal();
        }
    }
       
    function updatetotal(){
        
//        if($('#txtdiscount').val()===""){$('#txtdiscount').val('0');}
//       
//        var grosstotal=(parseFloat($("#txtsubtotal").val()) +parseFloat($("#txtothercharges").val())) - parseFloat($("#txtdiscount").val());
//        
//        $("#txtgross").val(grosstotal);
//        
//        var nettax = parseInt($('#taxrs').val(), 10);
//
//        $("#grandtotal").val(grosstotal + nettax + parseFloat($("#txtcc_charge").val()));
        
        var pay_now = parseInt($('#pnid').val());
        
        if($("#pnid").val() === "0" || $("#pnid").val() === ""){
            //$("#paid").val(grosstotal + nettax + pay_now);
            $("#balanceamount").val(parseFloat($("#balance_rs").val()));
            $("#pnid").val(0);
        } else {
            //$("#paid").val(parseInt($("#paid_rs").val()) + pay_now);
            $("#balanceamount").val(parseInt($("#balance_rs").val())- pay_now);
        }
        
        var new_paid = parseInt($('#paid').val()) + parseInt($('#pnid').val());
        
        if(pay_now > parseInt($('#balance_rs').val())){
            $('#returnamount').val(pay_now - (parseInt($('#balance_rs').val())));
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
           
            var ccc= (parseFloat($("#cardpaid").val()) * parseInt($("#cc_charge").val()))/100;
            $("#txtcc_charge").val(Math.round(ccc));
            $("#cardpaid").val(parseFloat($("#cardpaid").val()) + ccc);
        }
        
        $("#pnid").val(parseFloat($("#cashpaid").val()) + parseFloat($("#cardpaid").val()));
        
        updatetotal();
    }

    function createinvoice(){
        
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
        } else if($("#mode").html()==="Check"){ 
            if($("#checkno").val()===""){ toastr.warning('Enter Check Number!', 'Instrument number is mandatory'); return false;}else{instrument_number=$("#checkno").val();}
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
            url: '<?php echo base_url(); ?>invoice_controller/updaterecoveryorderinvoice',
            data: {
                orderid : $("#orderid").val(),
                paid : parseInt($('#pnid').val()) - parseInt($('#returnamount').val()),
                cashpaid: parseInt($("#cashpaid").val()),
                cardpaid: parseInt($("#cardpaid").val()),
                invoicenumber : $("#invoicenumber").html(),
                invoicedate : $("#invoice_date").html(),
                referenceinvoicenumber: $("#invoicereference").html(),
                recovery: recovery_status,
                customerid : $("#customerid").val(),
                subtotal : $("#txtsubtotal").val(),
                discount : $("#txtdiscount").val(),
                grosstotal : $("#txtgross").val(),
                grandtotal : $("#grandtotal").val(),
                taxes : taxarray,
                taxtotal : taxtotal,
                mode : $("#mode").html(),
                instrument_number : instrument_number,
                balance : $('#balanceamount').val(),
                returnamount : $('#returnamount').val(),
                old_invoice_id: $('#old_invoice_id').val(),
                visittime: $("#txtvisittime").val(),
                cc_charge: $("#txtcc_charge").val(),
                totalpayable: $("#txttotalpayable").val()
            },
            success: function(data) {
                var result = data.split("|");
                if (result[0] === "success") {
                    $("#txtinvoiceid").val(result[1]);
                    //$("#btnprint").show();
                    //$("#btnsubmit").hide();
                    toastr.success('New Invoice Added!', 'Print the invoice');
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
           
            var ccc= (parseFloat($("#grandtotal").val()) * parseInt($("#cc_charge").val()))/100;
            $("#txtcc_charge").val(Math.round(ccc));
            
        }
        updatetotal();
        
        $("#cctip").show();
        $("#mode").html('Card');
       // $("#paid").removeAttr("disabled");
        $("#cashpaid").val("0");
        $("#cardpaid").val("0");
      //  $("#paid").val("0");
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
      //  $("#paid").removeAttr("disabled");
        $("#cashpaid").val("0");
        $("#cardpaid").val("0");
     //   $("#paid").val("0");
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
      //  $("#paid").removeAttr("disabled");
        $("#cashpaid").val("0");
        $("#cardpaid").val("0");
      //  $("#paid").val("0");
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
     //   $("#paid").val("0");
      //  $("#paid").attr("disabled","disabled");
        
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
      //  $("#paid").removeAttr("disabled");
    }
    
</script>