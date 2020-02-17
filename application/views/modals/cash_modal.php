<div class="modal fade none-border" id="cash_register_modal" tabindex="-1" role="dialog" aria-labelledby="Cash Register" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Cash Register For <span id="cashRegDate"><?php echo date('d-m-Y'); ?></span></h4>
                <input type="hidden" id='dbformatdate'>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    
                    <center><strong>Daily Cash Count</strong></center>
                    
                    <br>
                    
                    <div class="col-lg-6">
                        <table class="table table-bordered">
                            <tbody>
                                 <tr>
                                    <td colspan="2" style="width: 100px;">Yesterday's Till Amount</td>
                                    
                                    <td style="width: 100px; padding-top: 20px;">
                                        Rs. <span id="yesterday_till">0.00</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="width: 100px; ">Additional Opening Cash (if any)</td>
                                    <td style="width: 100px;text-align: right; ">
                                        <input onblur="addZero($(this));" onfocus="removeZero($(this));"  onkeyup="updateCashRegister($(this));" class="form-control numeric input-sm autodisable" id="cash_addition" value="0.00"/>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Total Opening Balance</b></td>
                                    <td style="text-align: right">Rs. <strong id="totalOpening">0.00</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2" >Cash Received (from invoices)</td>
                                    <td >Rs. <span id="totalCash1">0.00</span></td>
                                </tr>
                                
                                <tr >
                                    <td colspan="2"><b>You Should Have</b></td>
                                    <td style="text-align: right">Rs. <strong id="totalGrand">0.00</strong></td>
                                </tr>
                                <tr><td colspan="3"></td></tr>
                                <tr>
                                    <td style="width: 100px;">Rs. 5000</td>
                                    <td style="width: 100px;"><input type="text" onblur="addZero($(this));" onfocus="removeZero($(this));" onkeyup="updateCashRegister($(this));" id="5000" value="0" class="form-control numeric input-sm autodisable"></td>
                                    <td>Rs. <span id="x5000">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>Rs. 1000</td>
                                    <td><input type="text" onblur="addZero($(this));" onfocus="removeZero($(this));" onkeyup="updateCashRegister($(this));" id="1000" value="0" class="form-control numeric input-sm autodisable"></td>
                                    <td>Rs. <span id="x1000">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>Rs. 500</td>
                                    <td><input type="text" onblur="addZero($(this));" onfocus="removeZero($(this));" onkeyup="updateCashRegister($(this));" id="500" value="0" class="form-control numeric input-sm autodisable"></td>
                                    <td>Rs. <span id="x500">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>Rs. 100</td>
                                    <td><input type="text" onblur="addZero($(this));" onfocus="removeZero($(this));" onkeyup="updateCashRegister($(this));" id="100" value="0" class="form-control numeric input-sm autodisable"></td>
                                    <td>Rs. <span id="x100">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>Rs. 50</td>
                                    <td><input type="text" onblur="addZero($(this));" onfocus="removeZero($(this));" onkeyup="updateCashRegister($(this));" id="50" value="0" class="form-control numeric input-sm autodisable"></td>
                                    <td>Rs. <span id="x50">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>Rs. 20</td>
                                    <td><input type="text" onblur="addZero($(this));" onfocus="removeZero($(this));" onkeyup="updateCashRegister($(this));" id="20" value="0" class="form-control numeric input-sm autodisable"></td>
                                    <td>Rs. <span id="x20">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>Rs. 10</td>
                                    <td><input type="text" onblur="addZero($(this));" onfocus="removeZero($(this));" onkeyup="updateCashRegister($(this));" id="10" value="0" class="form-control numeric input-sm autodisable"></td>
                                    <td>Rs. <span id="x10">0.00</span></td>
                                </tr>
                               <tr>
                                    <td>Rs. 5</td>
                                    <td><input type="text" onblur="addZero($(this));" onfocus="removeZero($(this));" onkeyup="updateCashRegister($(this));" id="5" value="0" class="form-control numeric input-sm autodisable"></td>
                                    <td>Rs. <span id="x5">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>Rs. 1</td>
                                    <td><input type="text" onblur="addZero($(this));" onfocus="removeZero($(this));" onkeyup="updateCashRegister($(this));" id="1" value="0" class="form-control numeric input-sm autodisable"></td>
                                    <td>Rs. <span id="x1">0.00</span></td>
                                </tr>
                                
                                
                                <tr>
                                    <td colspan="2"><b>You Have in Till</b></td>
                                    <td style="text-align: right">Rs. <strong id="totalSub">0.00</strong></td>
                                </tr>
                               
                                <tr><td colspan="3"></td></tr>
                                
                                <tr>
                                    <td colspan="2"><strong id="difference">DIFFERENCE</strong></td>
                                    <td style="text-align:right"><strong><span id="totalTillDifference"></span></strong>
                                </tr>
                                <tr>
                                    <td colspan="2"  >Tomorrow's Till Amount</td>
                                    <td style="padding-top: 13px;"><input style=" font-weight: bold;" type="text" id="today_till" class="form-control numeric input-sm autodisable" placeholder="Rs. 0"></td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div class="col-lg-12 m-t-20">
<!--                            <div style="text-align: center;">
                              <b>Denominations - (Yesterday Till + Additional cash + Cash in Hand): Rs. <span id="totalTillDifference"></span></b>
                              
                            </div>-->
<!--                             <div style="text-align: center;">
                                 <b>Difference:</b> Rs. <strong id="totalDifference"></strong> &nbsp &nbsp &nbsp &nbsp &nbsp
                               <b>Including Yesterday's Till: Rs. <span id="totalTillDifference"></span></b>
                            </div>-->
                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea class="form-control autodisable" id="cashRemarks"></textarea>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="col-lg-6">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Services</td>
                                    <td>Rs. <span id="totalService">0.00</span></td>
                                </tr>
                                <tr >
                                    <td >Products</td>
                                    <td >Rs. <span id="totalRetail">0.00</span></td>
                                </tr>
                                <tr >
                                    <td >Vouchers</td>
                                    <td >Rs. <span id="totalVoucherSold">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>Advance for Services</td>
                                    <td>Rs. <span id="totalAdvance">0.00</span></td>
                                </tr>  
                                <tr>
                                    <td><b>Today's Gross Sale</b></td>
                                    <td style="text-align: right"><b>Rs. <span id="totalSale">0.00</span></b></td>
                                </tr>
                               <tr>
                                    <td>(Less) Balances Generated</td>
                                    <td>- Rs. <span id="totalBalance">0.00</span></td>
                                </tr>
                                <tr >
                                    <td>(Less) Advance Adjusted</td>
                                    <td>- Rs. <span id="totalAdvanceAdjusted">0.00</span></td>
                                </tr>
                                <tr>
                                <td>(Add) Recovery Received</td>
                                    <td>+ Rs. <span id="totalRecovery">0.00</span></td>
                                </tr>

                                
                                <tr id="trcctips">
                                    <td>(Add) CC Tips</td>
                                    <td>+ Rs. <span id="totalCCTips">0.00</span></td>
                                </tr> 
                                <tr id="trccfee">
                                    <td>(Add) CC Fee</td>
                                    <td>+ Rs. <span id="totalCCFee">0.00</span></td>
                                </tr> 
                               
                                <tr>
                                    <td><b>Today's Net Sale</b></td>
                                    <td style="text-align: right"><b>Rs. <span id="totalTransaction">0.00</span></b></td>
                                </tr>
                                 <tr class='hidden' id="trextra">
                                    <td>Extra Charges</td>
                                    <td >Rs. <span id="totalExtra">0.00</span></td>
                                </tr> 
                                <tr class='hidden' id="trtax">
                                    <td>Tax</td>
                                    <td>Rs. <span id="totalTax">0.00</span></td>
                                </tr> 
                                <tr>
                                    <td>Adv. Amount Retained </td>
                                    <td>Rs. <span id="totalRetained">0.00</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Break up of Payments Received:</b></td>
                                </tr>

                                <tr>
                                    <td>Card</td>
                                    <td>Rs. <span id="Card">0.00</span></td>
                                </tr>
                               <tr>
                                    <td>Check</td>
                                    <td>Rs. <span id="Checks">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>Voucher</td>
                                    <td>Rs. <span id="totalVoucher">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>Cash</td>
                                    <td>Rs. <span id="Cash">0.00</span></td>
                                </tr>
                                <tr>
                                    <td><b>Total Payments</b></td>
                                    <td style="text-align: right"><b>Rs. <span id="totalpayments">0.00</span></b></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Cash Reconciliation:</b></td>
                                </tr>
                                <tr>
                                    <td>Cash</td>
                                    <td>Rs. <span id="Cash1">0.00</span></td>
                                </tr>

                                
                                <tr>
                                    <td>Less: Petty Cash Expense</td>
                                    <td>-Rs. <span id="totalExpenses1">0.00</span></td>
                                </tr>
                                <tr>
                                    <td>Less: CC Tips</td>
                                    <td>-Rs. <span id="totalCCTips1">0.00</span></td>
                                </tr>
                                <tr>
                                    <td ><b>Cash Received</b></td>
                                    <td style="text-align: right"><b>Rs. <strong id="totalCash">0.00</strong></b></td>
                                </tr>
                               
                                
                            </tbody>
                        </table>
                    </div>
                    
                    
                    
                    <div class="col-lg-12">
                        <div style="text-align: right; margin-top: 10px;">
                            <a target="_blank" id="cashregister" href="javascript:void(0);" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print"></i> Print</a>
                            <button type="button" onclick="saveCashRegister();" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>
