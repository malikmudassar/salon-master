<style>
    .table thead tr th{
        border-top:2px solid #eee;
        border-bottom:2px solid #eee;
        background: #fcfcfc;
    }
     .table tfoot tr th{
        border-top:2px solid #eee;
        border-bottom:2px solid #eee;
        background: #fcfcfc;
    }
</style>
<div class="wrapper">
    <div class="container-full">
        <div class="row m-t-20">
            <div class="col-md-12">
                <div class="panel panel-default m-t-20">
                    <div class="panel-body">
                        
                        <?php if(isset($business[0]['show_cash_reg']) && $business[0]['show_cash_reg']=='No' && $this->session->userdata('role')=="Reception"){ ?>
                        
                        <div class="row">
                            <div col-md-12>
                                <h1>Nothing to Show</h1>
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="row">
                            <div class="pull-left" >
                                <h3 class="logo invoice-logo"><?php if(isset($business[0]['business_logo'])){ echo "<img src='".base_url().'assets/images/business/'.$business[0]['business_logo']."' alt='".$business[0]['business_name']."' class='img-responsive' />";} else {echo 'SkedWise';}?></h3>
                                
                            </div>
                            <div class="pull-right m-t-20" >
                                <div class="col-md-8 hidden-print m-t-20">
                                    <?php if($this->session->userdata('show_previous')=='Y' || $this->session->userdata('role')=='Admin' || $this->session->userdata('role')=='Super User' || $this->session->userdata('role')=='Sh-Users' ){?>
                                    <?php if($this->session->userdata('role')=='Sh-Users'){ ?>
                                    <form method="POST" action='<?php echo base_url();?>sh_controller/todaydashboard'>
                                    <?php } else {?>    
                                    <form method="POST" action='<?php echo base_url();?>today_dashboard_controller/index'>
                                    <?php } ?>
                                        <input type="hidden" name="csrf_test_name" id="daily_sheet_csrf" value=""/>
                                        <div class="col-md-4">
                                            <?php if($this->session->userdata('role')!=='Sh-Users'){ ?>
                                            <select class="form-control inline m-r-5"  name="user" id="user">
                                                <option value="All">All</option>
                                                <?php foreach($users as $user){ ?>
                                                <option <?php if($selecteduser == $user['user_name']){ echo "selected: selected";} ?> value="<?php echo $user['user_name']; ?>"><?php echo $user['user_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-4">
                                            
                                            <input type="text" class="form-control inline m-r-5"  placeholder="mm/dd/yyyy" name="calendar_date" id="datepicker-autoclose">
                                            
                                        </div>
                                        <div class="col-md-4">
                                            <button type='submit' onclick="$('#daily_sheet_csrf').val($('#cook').val());" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button>
                                        </div>
                                    </form>
                                    <?php } ?>
                                </div>
                                <div class="col-md-4 hidden-print m-t-20">
                                    <a class="btn btn-warning m-l-10" onclick="tableToExcel('sheet1', 'Daily Sheet')" style="float:right">Export to Excel</a>
                                    <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light hidden-print pull-right" id="btnprint"><i class="fa fa-print"></i></a>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <table class="table m-t-10"  id='sheet1'>
                                <tr>
                                    <td colspan="4"><strong>Daily Sheet <u> <?php echo isset($date) && !empty($date) ? date('d-m-Y', strtotime($date)) : date('d-m-Y'); ?></u> <span><?php echo $business[0]['business_name'];?></span></strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        
                                         <table class="table" border="1" id='tblInvoices'>
                                            <thead>
                                                <tr>
                                                    <th colspan='17'><strong>Invoice Details</strong></th>
                                                </tr>
                                                <tr>
                                                    <th>Inv.ID</th>
                                                    <th>Visit Time</th>
                                                    <th>Customer</th>
                                                    <th>By</th>
                                                    <th>Cash</th>
                                                    <th>Card</th>
                                                    <th>Voucher</th>
                                                    <th>Check</th>
                                                    <th>Gross Sale</th>
                                                    <th>Discount</th>
                                                    <th>Retained</th>
                                                    <th>Balance</th>
                                                    <th>Adv.Adj.</th>
                                                    <!--<th>Ret.Adj.</th>-->
                                                    <th>CC.Tip</th>
                                                    <th>Tax</th>
                                                    <th>CC.Fee</th>
                                                    <th>Payments Received</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $last_id_invoice_detail=0;  $id=0; $cash=0; $card=0; $voucher=0; $check=0; $inv_discount=0; $paid=0;$retained=0; $balance=0;$gross=0; $advanceAdj=0;$recovery=0;$cctip=0; $tax=0;$cccharge=0; $cashretained=0; $retained_adj=0;
                                                foreach ($invoices as $invoice){ ?>
                                                <?php if($selecteduser == $invoice['created_by'] || $selecteduser=="All"){ if($id !== $invoice['id_invoice']){ ?>
                                                    <tr >
                                                        <td><b><?php echo $invoice['invoice_seq'].'/'. $invoice['id_invoice']; ?></b></td>
                                                        <td><b><?php if($invoice['reference_invoice_number']!==''){echo '<span class="text-danger"> Recovery '.$invoice['visit_date'];}else {echo $invoice['visit_time'];}?></b></td>
                                                        <td><b><?php echo $invoice['customer_name']; ?></b></td>
                                                        <td><b><?php echo $invoice['created_by']; ?></b></td>
                                                        <td><b><?php echo number_format($invoice['paid_cash'],2); ?></b></td>
                                                        <td><b><?php echo number_format($invoice['paid_card'],2); ?></b></td>
                                                        <td><b><?php echo number_format($invoice['paid_voucher'],2); ?></b></td>
                                                        <td><b><?php echo number_format($invoice['paid_check'],2); ?></b></td>
                                                        <td style="text-align: right;"><b><?php if($invoice['reference_invoice_number']==''){echo number_format($invoice['gross_amount'],2);} ?></b></td>
                                                        <td><b><?php if($invoice['reference_invoice_number']==''){echo number_format($invoice['invoice_discount'],2);} ?></b></td>
                                                        <td><b><?php echo number_format($invoice['retained_amount'],2); ?></b></td>
                                                        <td><b><?php if($invoice['reference_invoice_number']==''){echo number_format($invoice['balance'],2);} ?></b></td>
                                                        <td><b><?php if($invoice['reference_invoice_number']==''){echo number_format($invoice['advance_amount'],2);} ?></b></td>
                                                        <!--<td><b><?php // if($invoice['reference_invoice_number']==''){echo number_format($invoice['retained_amount_used'],2);} ?></b></td>-->
                                                        <td><b><?php if($invoice['reference_invoice_number']==''){echo number_format($invoice['cctip'],2);} ?></b></td>
                                                        <td><b><?php if($invoice['reference_invoice_number']==''){echo number_format($invoice['tax_total'],2);} ?></b></td>
                                                        <td><b><?php if($invoice['reference_invoice_number']==''){echo number_format($invoice['cc_charge'],2);} ?></b></td>
                                                        <td style='text-align: right;'><b><?php echo number_format($invoice['paid_amount'],2); ?></b></td>
                                                    </tr>
                                                <?php 
                                                    $paid=$paid+ $invoice['paid_amount']; $cash= $cash+ $invoice['paid_cash'];
                                                    $card=$card+ $invoice['paid_card']; $voucher=$voucher+ $invoice['paid_voucher']; 
                                                    $check = $check + $invoice['paid_check'];
                                                    $tax = $tax + $invoice['tax_total'];
                                                    $cccharge = $cccharge + $invoice['cc_charge'];
                                                    if($invoice['paid_cash']>0){$cashretained = $cashretained + $invoice['retained_amount'];}
                                                    if($invoice['reference_invoice_number']==''){$gross = $gross + $invoice['gross_amount'];}
                                                    if($invoice['reference_invoice_number']==''){$inv_discount=$inv_discount + $invoice['invoice_discount'];}
                                                    $retained=$retained+$invoice['retained_amount'];
                                                    if($invoice['reference_invoice_number']==''){$balance=$balance + $invoice['balance'];}
                                                    if($invoice['reference_invoice_number']==''){$advanceAdj=$advanceAdj + $invoice['advance_amount'];}
                                                    if($invoice['reference_invoice_number']==''){$cctip=$cctip + $invoice['cctip'];}
//                                                    if($invoice['reference_invoice_number']==''){$retained_adj=$retained_adj + $invoice['retained_amount_used'];}
                                                    
                                                }?>
                                                <tr>
                                                    <?php if($invoice['invoice_type']=='service'){?>
                                                        <?php if($last_id_invoice_detail !== $invoice['id_invoice_details']){?>
                                                        <td colspan="3" style="text-align: right;"> <?php echo $invoice['staff']; ?></td>
                                                        <td colspan="5" style="text-align: right; "><?php echo $invoice['service']; ?></td>
                                                        <td style='text-align: left;'><?php echo number_format($invoice['price'],2); ?></td>
                                                        <td><?php echo number_format($invoice['discount'],2); ?></td>
                                                        <td colspan="6"></td>
                                                        <!--<td style='text-align: left;'><?php// echo number_format($invoice['price'] -  $invoice['discount'],2); ?></td>-->
                                                        <!--changing to paid of invoice details--> 
                                                        <td style='text-align: left;'><?php echo number_format($invoice['paid_details'],2); ?></td>
                                                        <?php } else { ?>
                                                        <td colspan="3" style="text-align: right;"> <?php echo $invoice['staff']; ?></td>
                                                        <td colspan="5" style="text-align: right; "><?php echo $invoice['service']; ?></td>
                                                        <td style='text-align: left;'></td>
                                                        <td></td>
                                                        <td colspan="6"></td>
                                                        <!--<td style='text-align: left;'><?php //echo number_format($invoice['price'] -  $invoice['discount'],2); ?></td>-->
                                                        <!--changing to paid of invoice details--> 
                                                        <td style='text-align: left;'></td>
                                                        
                                                        <?php } $last_id_invoice_detail = $invoice['id_invoice_details'];?>
                                                    <?php } else { ?>
                                                        <td colspan="3" style="text-align: right;"> <?php echo $invoice['product_staff']; ?></td>
                                                        <td colspan="5" style="text-align: right; "><?php echo $invoice['product_name']; ?></td>
                                                        <td style='text-align: left;'><?php echo number_format($invoice['product_price'],2); ?></td>
                                                        <td><?php echo number_format($invoice['product_discount'],2); ?></td>
                                                        <td colspan="6"></td>
                                                        <td style='text-align: left;'><?php echo number_format($invoice['product_price'] -  $invoice['product_discount'],2); ?></td>
                                                    <?php } ?>
                                                </tr>
                                                <?php $id=$invoice['id_invoice']; $inv_discount=$inv_discount + $invoice['discount']; }}?>
                                                
                                                <?php  $advid=0; $advcash=0; $advcard=0; $advcheck=0;$advtotal=0;
                                                foreach ($advances as $advance){ 
                                                    if($selecteduser == $advance['advance_user'] || $selecteduser=="All"){
                                                    if($advid !==$advance['id_customer_visits']){ ?>
                                                        <tr>
                                                            <td></td>
                                                            <td><b>Advance</b></td>
                                                            <td><b><?php echo $advance['customer_name']; ?></b></td>
                                                            <td><b><?php echo $advance['advance_user']; ?></b></td>
                                                            <td><b><?php if($advance['advance_mode']=="cash"){ echo $advance['advance_amount']; $advcash=$advcash+$advance['advance_amount'];}  else {echo "0.00";}?></b></td>
                                                            <td><b><?php if($advance['advance_mode']=="card"){ echo $advance['advance_amount']; $advcard=$advcard+$advance['advance_amount'];}  else {echo "0.00";}?></b></td>
                                                            <td></td>
                                                            <td><b><?php if($advance['advance_mode']=="check"){ echo $advance['advance_amount']; $advcheck=$advcheck+$advance['advance_amount'];}  else {echo "0.00";}?></b></td>
                                                            <td style="text-align: right;"><b><?php echo $advance['advance_amount']; $gross = $gross +  $advance['advance_amount'];?></b></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td style="text-align: right;"><b><?php echo $advance['advance_amount']; $paid=$paid + $advance['advance_amount'];?></b></td>
                                                        </tr>
                                                         <tr>
                                                            <td colspan="3"></td>
                                                            <td colspan="5" style='text-align:right;'><?php echo $advance['service_category'].' '.$advance['service_name'].' Rs. '.$advance['service_rate']; ?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td colspan="6"></td>
                                                            <td></td>
                                                        </tr>
                                                    <?php $advtotal=$advtotal + $advance['advance_amount'];} else { ?>
                                                        <tr>
                                                            <td colspan="3"></td>
                                                            <td colspan="5" style='text-align:right;'><?php echo $advance['service_category'].' '.$advance['service_name'].' Rs. '.$advance['service_rate']; ?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td colspan="6"></td>
                                                            <td></td>
                                                        </tr>
                                                <?php }}?>
                                                <?php $advid = $advance['id_customer_visits'];
                                                } ?>
                                                
                                                        
                                                <?php  $vouchercash=0; $vouchercard=0; $vouchercheck=0; $vouchertotal=0;
                                                foreach ($vouchers as $v){ 
                                                    if($selecteduser == $invoice['created_by'] || $selecteduser=="All"){
                                                    ?>
                                                        <tr>
                                                            <td></td>
                                                            <td><b>Voucher: <?php echo $v['voucher_number'] ?></b></td>
                                                            <td><b><?php echo $v['customer_name']; ?></b></td>
                                                            <td><b><?php echo $v['created_by']; ?></b></td> <!-- Here-->
                                                            <td><b><?php echo $v['paid_cash']; $vouchercash=$vouchercash+$v['paid_cash']; ?></b></td>
                                                            <td><b><?php echo $v['paid_card'];  $vouchercard=$vouchercard+$v['paid_card']; ?></b></td>
                                                            <td></td>
                                                            <td><b><?php echo $v['paid_check']; $vouchercheck=$vouchercheck+$v['paid_check']; ?></b></td>
                                                            <td style="text-align: right;"><b><?php echo $v['amount']; $gross=$gross+$v['amount']; ?></b></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td style="text-align:right"><b><?php echo $v['amount']; $paid=$paid+$v['amount'];?></b></td>
                                                        </tr>
                                                    
                                                <?php } }?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td> <!-- Here-->
                                                    <td><b>Cash</b></td>
                                                    <td><b>Card</b></td>
                                                    <td><b>Voucher</b></td>
                                                    <td><b>Check</b></td>
                                                    <td><b>Gross Sale</b></td>
                                                    <td><b>Discount</b></td>
                                                    <td><b>Retained</b></td>
                                                    <td><b>Balance</b></td>
                                                    <td><b>Adv.Adj.</b></td>
                                                    <!--<td><b>Ret.Adj.</b></td>-->
                                                    <td><b>CC.Tip</b></td>
                                                    <td><b>Tax</b></td>
                                                    <td><b>CC.Fee</b></td>
                                                    <td><b>Payments Received</b></td>

                                                </tr>
                                                
                                            </tbody>
                                            <tfoot>
                                                 <tr>
                                                    <th></th>
                                                    <th><b>Invoice Breakup:</b></th>
                                                    <th></th>
                                                    <th></th> <!-- Here-->
                                                    <th style="text-align: right;" ><b><?php echo number_format($cash,2);?></b></th>
                                                    <th style="text-align: right;" ><b><?php echo number_format($card,2);?></b></th>
                                                    <th style="text-align: right;" ><b><?php echo number_format($voucher,2);?></b></th>
                                                    <th style="text-align: right;" ><b><?php echo number_format($check,2);?></b></th>
                                                    <th style="text-align: right;" ><b><?php echo number_format($gross,2);?></b></th>
                                                    <th style="text-align: right;" ><b><?php echo number_format($inv_discount,2);?></b></th>
                                                    <th style="text-align: right;" ><b><?php echo number_format($retained,2);?></b></th>
                                                    <th style="text-align: right;" ><b><?php echo number_format($balance,2);?></b></th>
                                                    <th style="text-align: right;" ><b><?php echo number_format($advanceAdj,2);?></b></th>
                                                    <!--<th style="text-align: right;" ><b><?php echo number_format($retained_adj,2);?></b></th>-->
                                                    <th style="text-align: right;" ><b><?php echo number_format($cctip,2);?></b></th>
                                                    <th style="text-align: right;" ><b><?php echo number_format($tax,2);?></b></th>
                                                    <th style="text-align: right;" ><b><?php echo number_format($cccharge,2);?></b></th>
                                                    <th style="text-align: right;" ><b><?php echo number_format($paid,2);?></b></th>
                                                </tr>
                                                <?php if($this->session->userdata('role')!=="Sh-Users"){ ?>
                                                <tr>
                                                    <th></th>
                                                    <th  ><b>Advance Breakup:</b></th>
                                                    <th  ></th>
                                                    <th></th> <!-- Here-->
                                                    <th style="text-align: right;" ><b><?php echo number_format($advcash,2);?></b></th>
                                                    <th style="text-align: right;" ><b><?php echo number_format($advcard,2);?></b></th>
                                                    <th style="text-align: right;" ><b></b></th>
                                                    <th style="text-align: right;" ><b><?php echo number_format($advcheck,2);?></b></th>
                                                    <th style="text-align: right;" ><b></b></th>
                                                    <th style="text-align: right;" ><b></b></th>
                                                    <th style="text-align: right;" ><b></b></th>
                                                    <th style="text-align: right;" ><b></b></th>
                                                    <th style="text-align: right;" ><b></b></th>
                                                    <th style="text-align: right;" ><b></b></th>
                                                    <th style="text-align: right;" ><b></b></th>
                                                    <th style="text-align: right;" ><b></b></th>
                                                    <th style="text-align: right;" ><b><?php echo number_format($advtotal,2);?></b></th>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th  ><b>Vouchers Breakup:</b></th>
                                                    <th  ></th>
                                                    <th></th> <!-- Here-->
                                                    <th style="text-align: right;" ><b><?php echo number_format($vouchercash,2);?></b></th>
                                                    <th style="text-align: right;" ><b><?php echo number_format($vouchercard,2);?></b></th>
                                                    <th style="text-align: right;" ><b></b></th>
                                                    <th style="text-align: right;" ><b><?php echo number_format($vouchercheck,2);?></b></th>
                                                    <th style="text-align: right;" ><b><?php echo number_format($vouchertotal,2);?></b></th>
                                                    <th style="text-align: right;" ><b></b></th>
                                                    <th style="text-align: right;" ><b></b></th>
                                                    <th style="text-align: right;" ><b></b></th>
                                                    <th style="text-align: right;" ><b></b></th>
                                                    <th style="text-align: right;" ><b></b></th>
                                                    <th style="text-align: right;" ><b></b></th>
                                                    <th style="text-align: right;" ><b></b></th>
                                                    <th style="text-align: right;" ><b><?php echo number_format($vouchertotal,2);?></b></th>
                                                </tr>
                                                <?php }?>
                                                 <tr>
                                                    <th></th>
                                                    <th style=" color: brown;"><b>Total :</b></th>
                                                    <th style="text-align: right; color: brown"  ></th>
                                                    <th></th> <!-- Here-->
                                                    <th style="text-align: right; color: brown" ><b><?php $totalcash=$cash + $vouchercash + $advcash; echo number_format($totalcash,2); ?></b></th>
                                                    <th style="text-align: right; color: brown" ><b><?php $totalcard=$card + $vouchercard + $advcard; echo number_format($totalcard,2);?></b></th>
                                                    <th style="text-align: right; color: brown" ><b><?php  echo number_format($voucher,2); ?></b></th>
                                                    <th style="text-align: right; color: brown" ><b><?php $totalvoucher=$check + $vouchercheck + $advcheck; echo number_format($totalvoucher,2);?></b></th>
                                                    <th style="text-align: right; color: brown" ><b><?php echo number_format($gross,2);?></b></th>
                                                    <th style="text-align: right; color: brown" ><b></b></th>
                                                    <th style="text-align: right; color: brown" ><b></b></th>
                                                    <th style="text-align: right;" ><b></b></th>
                                                    <th style="text-align: right; color: brown" ><b></b></th>
                                                    <th style="text-align: right; color: brown" ><b></b></th>
                                                    <th style="text-align: right; color: brown" ><b><?php echo number_format($tax,2);?></b></th>
                                                    <th style="text-align: right; color: brown" ><b><?php echo number_format($cccharge,2);?></b></b></th>
                                                    <th style="text-align: right; color: brown" ><b><?php echo number_format($paid,2);?></b></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </td>
                                    <td>
                                        <?php if($selecteduser=="All"){?>
                                        <table class="table" border="1" name='expenses'>
                                            <thead>
                                                <tr><th colspan="3"> <strong class="pull-left">Payments-Petty Cash</strong></th>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Desc</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $petty_expenses=0; foreach ($expenses as $expense){ ?>
                                                <tr>
                                                    <td><?php echo $expense['account_head']; ?></td>
                                                    <td><?php echo $expense['description']; ?></td>
                                                    <td style="text-align:right;"><?php echo number_format($expense['debit'],2); ?></td>
                                                    <?php $petty_expenses= $petty_expenses+$expense['debit']; } ?>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <th>Total:</th>
                                                <th></th>
                                                <th style="text-align:right;"><?php echo number_format($petty_expenses,2);?></th>
                                            </tfoot>
                                        </table>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr><td colspan="4">&nbsp;</td></tr>
                                <tr>
                                    <td> <!--/*cash reconciliation*/-->
                                        <?php if($selecteduser=="All"){?>
                                        <table border="1" class='table table-bordered'>
                                            <tr><td colspan="2"><b><u>Cash Reconciliation:</u></b></td></tr>
                                            <tr>
                                                <td>Today's Cash Received: </td><td style="text-align:right;"><?php echo number_format($totalcash,2);?></td>
                                            </tr>
                                            <tr>
                                                <td>Add: Cash Retained: </td><td style="text-align:right;"><?php echo number_format($cashretained,2);?></td>
                                            </tr>
<!--                                            <tr>
                                                <td>Less: Credit Card </td><td style="text-align:right;"><?php echo number_format($card + $advances->Card ,2);?></td>
                                            </tr>
                                            <tr>
                                                <td>Less: Checks </td><td style="text-align:right;"><?php echo number_format($check + $advances->Checks,2);?></td>
                                            </tr>
                                            <tr>
                                                <td>Less: Vouchers </td><td style="text-align:right;"><?php echo number_format($voucher,2);?></td>
                                            </tr>
                                            <tr>
                                                <td>Less: Dues / Receivable </td><td style="text-align:right;"><?php echo number_format($balance,2);?></td>
                                            </tr>
                                            <tr>
                                                <td>Less: Advance Adjusted </td><td style="text-align:right;"><?php echo number_format($advanceAdj,2);?></td>
                                            </tr>-->
                                            <tr>
                                                <td>Less: Card Tips </td><td style="text-align:right;"><?php echo number_format($cctip,2);?></td>
                                            </tr>
                                            <tr>
                                                <td>Less: Petty Cash Payments</td><td style="text-align:right;"><?php echo number_format($petty_expenses,2);?></td>
                                            </tr>
<!--                                            <tr>
                                                <td>Add: Advance Received </td><td style="text-align:right;"><?php echo number_format($cashInfo->totalRetained + $cashInfo->totalAdvance,2); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Add: Old Balance Received (Recovery)</td><td style="text-align:right;"><?php if(isset($cashInfo->totalRecovery)){ echo number_format($cashInfo->totalRecovery,2); $recovery=$cashInfo->totalRecovery;} else {echo "0.00";}?></td>
                                            </tr>-->
                                            <tr>
                                                <!--<td><b>Cash in Hand:</b></td><td style="text-align:right;"><b><?php $cih = $gross-($card+$check+$voucher+$balance+$advanceAdj+$cctip+$petty_expenses); $cih=$cih+$cashInfo->totalRetained + $cashInfo->totalAdvance + $recovery; echo number_format($cih,2);?>  </b></td>-->
                                                <td><b>Cash in Hand:</b></td><td style="text-align:right;"><b>
                                                    <?php $cih = ($totalcash + $cashretained) - ($petty_expenses + $cctip);
                                                    echo number_format($cih,2);?>  
                                                    </b>
                                                </td>
                                            </tr>
                                        </table>
                                        <?php } ?>
                                    </td>
                                    <td> <!--/*cash ledger*/-->
                                        <?php if($selecteduser=="All"){?>
                                         <table border="1" class='table table-bordered'>
                                             <?php $pcbal=0; $pcreimbur=0;?>
                                            <tr><td colspan="2"><b><u>Cash Ledger:</u></b></td></tr>
                                            <tr>
                                                <td>Petty Cash Balance C/F: </td><td style="text-align:right;"><?php if(isset($yesterdaytill)){echo number_format($yesterdaytill->till_amounts,2); $pcbal=$yesterdaytill->till_amounts;} else { echo '0.00';}?></td>
                                            </tr>
                                            <tr>
                                                <td>Additional Morning Cash: </td><td style="text-align:right;"><?php if(isset($cashregister)){echo number_format($cashregister->cash_addition,2); $pcbal=$pcbal + $cashregister->cash_addition;} else { echo '0.00';}?></td>
                                            </tr>
                                            <tr>
                                                <td>Today Cash Receipt </td><td style="text-align:right;"><?php echo number_format($cih,2);?></td>
                                            </tr>
                                           
                                            <tr>
                                                <td></td><td style="text-align:right;"></td>
                                            </tr>
                                            <tr>
                                                <td></td><td style="text-align:right;"></td>
                                            </tr>
                                            <tr>
                                                <td></td><td></td>
                                            </tr>
                                            <tr>
                                                <td><b>Total:</b></td><td style="text-align:right;"><b><?php echo number_format(($cih+$pcbal)-$pcreimbur,2); ?></b></td>
                                            </tr>
                                        </table>
                                        <?php } ?>
                                    </td>
                                     <?php if($this->session->userdata('role')!=="Sh-Users"){ ?>
                                    <td>
                                        <?php $denominationcash=0;?>
                                        <?php if($selecteduser=="All"){?>
                                        <table border="1" class="table table-bordered" name='cashregister'>
                                            <tbody>
                                                <tr><td colspan="3"><b><u>Denominations:</u></b></td></tr>
                                                <tr>
                                                    <td style="width: 100px;">Opening Till Amount</td>
                                                    <td colspan="2" style=" padding-top: 20px; text_align:right;">
                                                        Rs. <strong ><?php if(isset($pcbal)){echo number_format($pcbal,2);} else { echo '0.00';}?></strong>
                                                    </td>
                                                </tr>
                                                <?php if(isset($cashregister)){?>
                                                <tr>
                                                    <td style="width: 100px;">Rs. 5000</td>
                                                    <td>x <?php echo $cashregister->x5000;?></td>
                                                    <td style="text-align:right"><?php echo number_format(5000* $cashregister->x5000,2); $denominationcash=$denominationcash+ (5000* $cashregister->x5000); ?>  </td>
                                                </tr>
                                                <tr>
                                                    <td>Rs. 1000</td>
                                                    <td>x <?php echo $cashregister->x1000;?></td>
                                                    <td style="text-align:right"><?php echo number_format(1000* $cashregister->x1000,2); $denominationcash=$denominationcash+ (1000* $cashregister->x1000);?>  </td>
                                                </tr>
                                                <tr>
                                                    <td>Rs. 500</td>
                                                    <td>x <?php echo $cashregister->x500;?></td>
                                                    <td style="text-align:right"><?php echo number_format(500* $cashregister->x500,2); $denominationcash=$denominationcash+ (500* $cashregister->x500);?>  </td>
                                                </tr>
                                                <tr>
                                                    <td>Rs. 100</td>
                                                    <td>x <?php echo $cashregister->x100;?></td>
                                                    <td style="text-align:right"><?php echo number_format(100* $cashregister->x100,2); $denominationcash=$denominationcash+ (100* $cashregister->x100);?>  </td>
                                                </tr>
                                                <tr>
                                                    <td>Rs. 50</td>
                                                    <td>x <?php echo $cashregister->x50;?></td>
                                                    <td style="text-align:right"><?php echo number_format(50* $cashregister->x50,2); $denominationcash=$denominationcash+ (50* $cashregister->x50);?>  </td>
                                                </tr>
                                                <tr>
                                                    <td>Rs. 20</td>
                                                    <td>x <?php echo $cashregister->x20;?></td>
                                                    <td style="text-align:right"><?php echo number_format(20* $cashregister->x20,2); $denominationcash=$denominationcash+ (20* $cashregister->x20);?>  </td>
                                                </tr>
                                                <tr>
                                                    <td>Rs. 10</td>
                                                    <td>x <?php echo $cashregister->x10;?></td>
                                                    <td style="text-align:right"><?php echo number_format(10* $cashregister->x10,2); $denominationcash=$denominationcash+ (10* $cashregister->x10);?>  </td>
                                                </tr>
                                                <tr>
                                                    <td>Rs. 5</td>
                                                    <td>x <?php echo $cashregister->x5;?></td>
                                                    <td style="text-align:right"><?php echo number_format(5* $cashregister->x5,2); $denominationcash=$denominationcash+ (5* $cashregister->x5);?>  </td>
                                                </tr>
                                                <tr>
                                                    <td>Rs. 1</td>
                                                    <td>x <?php echo $cashregister->x1;?></td>
                                                    <td style="text-align:right"><?php echo number_format(1* $cashregister->x1,2); $denominationcash=$denominationcash+ (1* $cashregister->x1);?>  </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><b>Denomination total</b></td>
                                                    <td style="text-align:right"><strong ><?php echo number_format($denominationcash,2); ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Tomorrow's Till Amount</td>
                                                    <td colspan="2" style="padding-top: 13px;">Rs. <strong ><?php echo number_format($cashregister->till_amounts,2);?></strong></td>
                                                </tr>
                                                <?php }?>
                                            </tbody>
                                        </table>
                                        <?php } ?>
                                    </td>
                                     <?php } ?>
                                    <td></td>
                                    
                                </tr>
                        </table>
                    </div>
                    <!-- end row -->
                        <?php }?>
                    
    </div>
</div>

<script>
    $(document).ready(function(){   
         $('#datepicker-autoclose').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            });
    });

     var tableToExcel = (function () {
          //  application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
            var uri = 'data:application/vnd.ms-excel;base64,'
              , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
              , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
              , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
            return function (table, name) {
                if (!table.nodeType) table = document.getElementById(table)
                var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }
                var link = document.createElement("a");
                
                var d = new Date();
                var datestring = ("0" + d.getDate()).slice(-2) + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" +
                d.getFullYear() + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2);
    
                link.download = ctx.worksheet + ' ' + datestring;
                link.href = uri + base64(format(template, ctx));
                link.click();
                //window.location.href = uri + base64(format(template, ctx))
            }
        })()
        
</script>