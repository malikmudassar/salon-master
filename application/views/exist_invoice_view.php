        <div class="wrapper">
            <div class="container">
                <!-- Page-Title -->
                
                 <?php if($invoice[0]['balance'] > 0 && $invoice[0]['is_recovery']==='Yes'){?>
                <div class="row hidden-print" >
                    <div class="col-sm-12" >
                        <div class="alert alert-danger">
                            <h3 >
                                This Invoice has BALANCE pending for a SUM of : Rs. <?php echo number_format($invoice[0]['balance']);?>
                                <a class="btn btn-danger waves-effect waves-light m-b-5 btn-sm"  href="<?php echo base_url().'open_recovery_invoice/'.$invoice[0]['id_invoice'].'/'.$invoice[0]['visit_id']; ?>">Create Recovery Invoices?</a>
                            </h3>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
               <?php if($invoice[0]['remarks'] !==''){?>
               <div class="row hidden-print" >
                    <div class="col-sm-12" >
                        <div class="alert alert-warning">
                            <h3 >
                                <?php echo $invoice[0]['remarks'];?>
                            </h3>
                        </div>
                    </div>
                </div>     
                    
               <?php } ?>
                
                <?php if($invoice[0]['invoice_status'] !=='valid'){?>
               <div class="row hidden-print" >
                    <div class="col-sm-12" >
                        <div class="alert alert-warning">
                            <h3 >
                                <?php echo $invoice[0]['cancelreason'];?>
                            </h3>
                        </div>
                    </div>
                </div>     
                    
               <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding:10px !important;">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 pull-left">
                                        <div ><?php if(isset($business)){ echo "<img width='180px' src='".base_url().'assets/images/business/'.$business[0]['business_logo']."' alt='".$business[0]['business_name']."' class='img-responsive' />";} else {echo 'SkedWise';}?>
                                            <span ><?php if(isset($business)){ echo $business[0]['business_address'];} ?></span>
                                            <span ><?php if(isset($business)){ echo $business[0]['business_phone1'];} ?></span>
                                        </div>
                                    </div>
                                    <div class="<?php if(isset($business[0]['invoicenumber'])){if($business[0]['invoicenumber']=='No'){echo "hidden-sm hidden-xs";}} ?> pull-right" style="">
                                        <h4 >Invoice # <br>
                                            <strong id="invoicenumber"><?php echo $invoice[0]['invoice_number'];?></strong>
                                            <?php if($invoice[0]['reference_invoice_number']!==""){?>
                                            <br><?php echo $invoice[0]['reference_invoice_number'];?>
                                            <?php } ?>
                                            <?php if($invoice[0]['invoice_status'] !=='valid'){?>
                                            <br><h1 class="text-danger">CANCELLED</h1>
                                            <?php } ?>
                                        </h4>
                                        
                                    </div>
                                   <div class="pull-right <?php if(isset($business[0]['invoicenumber'])){if($business[0]['invoicenumber']=='No'){echo "hidden-sm hidden-xs";}} ?>">
                                        <span class="">Visit #:
                                            <?php if(isset($invoice[0]['visit_id'])){ echo sprintf("%04s", $invoice[0]['visit_id']);}else{echo '00001';} ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="row" style="color:#000 !important">
                                    <div class="col-md-12">
                                        
                                        <div class="pull-left m-t-10 " >
                                            <?php if($invoice[0]['invoice_seq']>0){?>
                                            <label>Receipt #: <?php echo $invoice[0]['invoice_seq']; ?></label>    
                                            <?php } ?>
                                            <input name="customerid" id="customerid" type="hidden" value="<?php echo $invoice[0]['customer_id']; ?>"/>
                                            <input name="txtinvoiceid" id="txtinvoiceid" type="hidden" value="<?php echo $invoice[0]['id_invoice']; ?>"/>
                                            <address>
                                              <strong><?php echo $invoice[0]['customer_name']; ?></strong><br>
                                              <span ><abbr class="hidden-sm hidden-xs" title="Phone">P:</abbr> <?php 
                                                    if( $this->session->userdata('hide_cell') && $this->session->userdata('hide_cell') == "No"){ 
                                                        echo $invoice[0]['customer_cell']; 
                                                    } 
                                              ?></span><br>
                                              <span class="hidden-sm hidden-xs"><?php echo $invoice[0]['customer_address']; ?></span><br>
                                              <span class="hidden-sm hidden-xs"><?php echo $invoice[0]['customer_email']; ?></span>
                                              <?php if($invoice[0]['discount_remarks']!==""){?><br><span class=""><?php echo $invoice[0]['discount_remarks']; ?></span><?php } ?>
                                            </address>
                                        </div>
                                        <div class="pull-right m-t-10">
                                            <p><strong><?php if($invoice[0]['reference_invoice_number']!==""){?>Recovery:<?php }else{?>Invoice Date:<?php } ?> </strong> <?php echo $invoice[0]['invoice_date']; ?></p>
                                            <p class="m-t-0" id="modep"><strong>Payment: </strong> <span id="mode"><?php echo $invoice[0]['payment_mode']; ?></span></p>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->
                                <div class="row" style="color:#000 !important">
                                    <div class="col-md-12">
                                        <div class="">
                                            <table class="table " id="tblservices" style="color:#000 !important">
                                                <thead style="color:#000 !important">
                                                    <tr ><th>#</th>
                                                    <th>Item</th>
                                                    <th>Description</th>                                                    
                                                    <th class="hidden-sm hidden-xs" <?php if(isset($business[0]['invoice_staff'])){if($business[0]['invoice_staff']==='Y'){}else{echo 'class="hidden-sm hidden-xs"';}} ?> >Staff</th>
                                                    <th class="hidden_md hidden-sm hidden-xs">Requested(staff)</th>
                                                    <th class="hidden_md hidden-sm hidden-xs">Products</th>
                                                    <th >Discount</th>
                                                    <th >Service Cost</th>
                                                    
                                                </tr>
                                                </thead>
                                                <tbody style="color:#000 !important">
                                                    <?php $x=1; if(isset($invoicedetails)){
                                                        foreach($invoicedetails as $invoicedetail){?>
                                                        <tr>
                                                            <td><?php echo $x;?></td>
                                                            <td><?php echo $invoicedetail['service_category']; ?></td>
                                                            <td><?php echo $invoicedetail['service_name']; ?></td>
                                                            
                                                            <td class="hidden-sm hidden-xs" 
                                                                <?php 
                                                                if(isset($business[0]['invoice_staff'])){if($business[0]['invoice_staff']!=='Y') {echo 'class="hidden-sm hidden-xs"';} } ?> >
                                                                    <?php foreach($invoicestaff as $invs){
                                                                       if($invs['invoice_detail_id']==$invoicedetail['id_invoice_details']) {
                                                                           echo $invs['staff_name'].'<br>';
                                                                       }
                                                                    }?>
                                                            </td>
                                                            <td class="hidden_md hidden-sm hidden-xs"><?php foreach($invoicestaff as $invs){
                                                                       if($invs['invoice_detail_id']==$invoicedetail['id_invoice_details']) {
                                                                           echo $invs['requested'].'<br>';
                                                                       }
                                                                    }?></td>
                                                            <td class="hidden_md hidden-sm hidden-xs"><?php echo str_replace('|','<br> ',$invoicedetail['products']); ?></td>
                                                            <td> <?php echo $invoicedetail['discount']; ?></td>
                                                             <?php if(isset($invoicedetail['service_flag'])){?>
                                                                <?php if($invoicedetail['service_flag']=='servicetype'){?>
                                                            <td ><span class="hidden-print">Rs.</span><span><?php echo $invoicedetail['price']-$invoicedetail['discount']; ?></span></td>
                                                                <?php } else { ?><td>Deal</td><?php }?>
                                                             <?php } else {?>
                                                                <td ><span class="hidden-print">Rs.</span><span><?php echo $invoicedetail['price']-$invoicedetail['discount']; ?></span></td>
                                                             <?php }?>
                                                        </tr>
                                                        <?php $x++;}} ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="color:#000 !important">
                                    <div class="col-md-6 col-lg-6 hidden-sm hidden-xs">
<!--                                        <div class="clearfix m-t-40">
                                            <h5 class="small text-inverse font-600">PAYMENT TERMS AND POLICIES</h5>

                                            <small>
                                                <?php echo $business[0]['payment_terms'];?>
                                            </small>
                                        </div>-->
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12 col-md-offset-3" style="color:#000 !important">
                                        <p class="text-right m-t-0"><b>Sub-total:  Rs. <?php echo $invoice[0]['sub_total'];?></b> </p>
                                        <p class="text-right m-t-0">Discount:   Rs. <?php echo $invoice[0]['discount'];?></p>
                                        <p class="text-right m-t-0">Other Charges:   Rs. <?php echo $invoice[0]['other_charges'];?></p>
                                        <?php if((Float)$invoice[0]['cctip']>0){?><p class="text-right m-t-0">Tip Charged on Card:   Rs. <?php echo $invoice[0]['cctip'];?></p><?php } ?>
                                        <p class="text-right m-t-0">Gross Total:   Rs. <?php echo $invoice[0]['gross_amount'];?></p>
                                        <div class="m-t-10 m-b-5" id="divtaxes" style="display: <?php echo count($taxes) > 0 ? 'block' : 'none'; ?>;">
                                        <?php if(isset($taxes)){$x=0;foreach ($taxes as $tax) {?>
                                            <p class="text-right m-t-0 m-b-5"><span><?php echo $tax['invoice_tax_name'].' '; ?></span> :  Rs. <?php echo $tax['invoice_tax'];?></p>
                                        <?php $x++;}}?>
                                        </div>
                                        <?php if($invoice[0]['cc_charge']>0){?>
                                            <p class="text-right m-t-0"><span>CC Fee:</span> :  Rs. <?php echo $invoice[0]['cc_charge'];?></p>
                                        <?php } ?>
                                        <hr>
                                        <p class="text-right m-t-0">  <b>Rs. <?php echo $invoice[0]['net_amount']+$invoice[0]['advance_amount']; ?></b></p>
                                        <?php if($invoice[0]['reference_invoice_number']!==''){?>
                                        <p class="text-right m-t-0">  <b>Recoverable <input class="numeric" style="text-align: right; width: 95px; border: none;" id="recoverable" readonly  name="recoverable" value="<?php echo ($invoice[0]['paid_amount'] + $invoice[0]['balance']); ?>"/></b></p>
                                        <?php } ?>
                                        <p class="text-right m-t-0" <?php if($invoice[0]['invoice_status'] !=='valid'){?> style="text-decoration: line-through;"<?php }?>>  <b>Paid Rs. <input class="numeric" style="text-align: right; width: 95px; border: none; <?php if($invoice[0]['invoice_status'] !=='valid'){?> text-decoration: line-through;<?php }?>" id="paid" readonly  name="paid" value="<?php echo ($invoice[0]['paid_amount'] + $invoice[0]['returnamount']); ?>"/></b></p>
                                        <?php if($invoice[0]['payment_mode']=="Mixed"){?>
                                        <p class="text-right m-t-0">  <b>Cash Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" id="paidcash" readonly  name="paidcash" value="<?php echo ($invoice[0]['paid_cash']); ?>"/></b></p>
                                        <p class="text-right m-t-0">  <b>Card Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" id="paidcard" readonly  name="paidcard" value="<?php echo ($invoice[0]['paid_card']); ?>"/></b></p>
                                        <?php } ?>
                                        <p class="text-right m-t-0">  Advance Payment <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly" id="advance_amount"  name="advance_amount" value="<?php echo $invoice[0]['advance_amount']; ?>"/></p>
                                        <p class="text-right m-t-0">  <?php if($invoice[0]['retained_amount'] > 0){echo 'Retained';}else {echo 'Return';} ?> Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly"  name="returnamount" value="<?php echo $invoice[0]['returnamount']; ?>"></p>
                                        <p class="text-right m-t-0">  Balance Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly" id="balanceamount"  name="balanceamount" value="<?php echo $invoice[0]['balance']; ?>"/></p>
                                        
                                    </div>
                                    <div style="font-size:11px; text-align: center">
                                        <?php if(isset($business[0]['fineprint']) && $business[0]['fineprint'] == 'Yes'){?>
                                        <?php echo $business[0]['payment_terms'];?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="hidden-print">

                                    <div class="pull-right">
                                        <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light" id="btnprint" ><i class="fa fa-print"></i></a>
                                    </div>
                                     <div class="pull-right">
                                        <a onclick="sendEmail(<?php echo $invoice[0]['customer_id']; ?>);" data-toggle="tooltip" data-placement="top" data-original-title="Email this" href="javascript:void(0);" class="btn btn-default waves-effect waves-light" id="btnprint"><i class="fa fa-envelope"></i></a>
                                    </div>                                   
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- end row -->
                
                <div class="modal fade none-border" id="eventview" tabindex="-1" role="dialog" aria-labelledby="Event View" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" onclick="$('#eventview').modal('hide');" aria-hidden="true">×</button>
                                <h4 class="modal-title">Send Email</h4>
                            </div>
                            <div class="modal-body">
                                <label class="" for="email">Customer Email</label>
                                <input class="form-control" type="email" id="email" placeholder="Enter Customer Email e.g. example@abc.com">
                                
                                <div class="pull-right">
                                    <label for="default" style="margin-top: 10px;">
                                        <input type="checkbox" id="default" checked="checked"> Default
                                    </label>
                                </div>
                                <div class="clearfix"></div>
                                
                                <hr>
                                
                                <div class="pull-right">
                                    <button onclick="sendEmailDo(<?php echo $invoice[0]['customer_id']; ?>);" class="btn btn-sm btn-primary">Send <i class="fa fa-send"></i></button>
                                </div>
                                
                                <div class="clearfix"></div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                
                <script>
                    function sendEmailDo(id){
                        var email = $('#email').val();
                        var invoiceid = $('#txtinvoiceid').val();
                        var senddefault = $('#default:checkbox:checked').val() === 'on' ? 'yes' : 'no';
                        
                        if(email === ""){
                            swal({
                                title: "Empty field found!",
                                text: "Email should not be empty.",
                                type: "error",
                                confirmButtonText: 'OK!'
                            });
                            return false;
                        }
                        $.ajax({
                            url: '<?php echo base_url().'Customer_controller/sendEmailDo'; ?>',
                            type: 'POST',
                            data: {
                                customerid : id,
                                email : email,
                                invoiceid : invoiceid,
                                senddefault : senddefault 
                            },
                            success: function(result){
                                $('#eventview').modal('hide');
                                toastr.success('Email sent!', 'Done!');
                            }
                        });
                    }
                    
                    function sendEmail(id){
                        $.ajax({
                            url: '<?php echo base_url().'Customer_controller/sendEmail'; ?>',
                            type: 'POST',
                            data: { customerid : id },
                            success: function(result){
                                
                                if(result === "empty"){
                                    $('#email').val('');
                                    $('#empty').val('yes');
                                } else{
                                    $('#email').val(result);
                                    $('#empty').val('no');
                                }
                                
                                $('#eventview').modal({
                                    backdrop:'static',
                                    keyboard:false,
                                    show:true
                                });
                                
                            }
                        });
                    }
                </script>