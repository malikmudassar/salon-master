<div class="wrapper">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="pull-left" >
                                <h3 class="logo invoice-logo"><?php if(isset($business)){ echo "<img src='".base_url().'assets/images/business/'.$business[0]['business_logo']."' alt='".$business[0]['business_name']."' class='img-responsive' />";} else {echo 'SkedWise';}?></h3>
                                <h3><?php echo $business[0]['business_name'];?></h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- end row -->

                        <div class="row">

                            <div class="col-lg-12" >
                                <strong class="pull-left">Daily Cash Register <?php echo $date; ?></strong>
                                <strong class="pull-right">Date: <?php echo isset($date) && !empty($date) ? date('d-m-Y', strtotime($date)) : date('d-m-Y'); ?></strong>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 ">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td colspan="2" >Yesterday's Till Amount</td>
                                            <td  style=" padding-top: 20px;">
                                                Rs. <strong id="yesterday_till">0.00</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="width:250px">Additional Opening Cash</td>
                                            <td style="width: 250px; padding-top: 20px;">
                                                Rs. <strong id="cash_addition">0.00</strong>
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
                                        <tr><td colspan="3"></td></tr>
                                        <tr>
                                            <td style="width: 250px;">Rs. 5000</td>
                                            <td ><input size="3" style="border: none;" readonly="" type="text" id="5000" value="0" class="input-sm"></td>
                                            <td>Rs. <span id="x5000">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td>Rs. 1000</td>
                                            <td><input size="3" style="border: none;" readonly="" type="text" id="1000" value="0" class="input-sm"></td>
                                            <td>Rs. <span id="x1000">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td>Rs. 500</td>
                                            <td><input size="3" style="border: none;" readonly="" type="text" id="500" value="0" class="input-sm"></td>
                                            <td>Rs. <span id="x500">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td>Rs. 100</td>
                                            <td><input size="3" style="border: none;" readonly="" type="text" id="100" value="0" class="input-sm"></td>
                                            <td>Rs. <span id="x100">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td>Rs. 50</td>
                                            <td><input size="3" style="border: none;" readonly="" type="text" id="50" value="0" class="input-sm"></td>
                                            <td>Rs. <span id="x50">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td>Rs. 20</td>
                                            <td><input size="3" style="border: none;" readonly="" type="text" id="20" value="0" class="input-sm"></td>
                                            <td>Rs. <span id="x20">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td>Rs. 10</td>
                                            <td><input size="3" style="border: none;" readonly="" type="text" id="10" value="0" class="input-sm"></td>
                                            <td>Rs. <span id="x10">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td>Rs. 5</td>
                                            <td><input size="3" style="border: none;" readonly="" type="text" id="5" value="0" class="input-sm"></td>
                                            <td>Rs. <span id="x5">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td>Rs. 1</td>
                                            <td><input size="3" style="border: none;" readonly="" type="text" id="1" value="0" class="input-sm"></td>
                                            <td>Rs. <span id="x1">0.00</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>You Have in Till</b></td>
                                            <td style="text-align: right">Rs. <strong id="totalSub">0.00</strong></td>
                                        </tr>

                                        <tr><td colspan="3"></td></tr>
                                        <tr>
                                            <td colspan="2"><strong >DIFFERENCE</strong></td>
                                            <td style="text-align:right"><strong>Rs. <span id="totalTillDifference"></span></strong>
                                        </tr>
                                       
                                        <tr>
                                            <td>Tomorrow's Till Amount</td>
                                            <td colspan="2" style="padding-top: 13px;">Rs. <strong id="today_till"></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-xs-12 col-sm-12 col-md-12 m-t-10">
                                   
                                <div class="form-group ">
                                    <label>Remarks</label>
                                    <p id="cashRemarks"></p>
                                </div>
                            </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
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
                                 <tr  class='hidden' id="trextra">
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
                        </div>
                        <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light hidden-print pull-right" id="btnprint"><i class="fa fa-print"></i></a>
                    </div>
                </div>

            </div>

        </div>
        <!-- end row -->
    </div>
</div>

<script>
    $(document).ready(function(){
        getCashRegister();
    });
    function getCashRegister(){
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>Invoice_controller/getTodayCashInfo",
            data: {
                calendar_date : '<?php echo $date; ?>'
            },
            success: function(response){
                var result = $.parseJSON(response);
                var data = result.invoice;
                var data2 = result.cash_register;
                var data3 = result.voucher;
                var data4 = result.till;
                var data5 = result.today_expenses;

                
                var totalCash = data.totalCash !== null ? data.totalCash : 0;
                var totalSale = data.totalSale !== null ? data.totalSale : 0;
                        
                var totalService = data.totalService !== null ? data.totalService : 0;
                var totalRetail = data.totalRetail !== null ? data.totalRetail : 0;
                var totalVoucher = data3.totalVoucherAmount !== null ? data3.totalVoucherAmount : 0;
                var totalAdvance = data.totalAdvance !== null ? data.totalAdvance : 0;
                
                var todaytotalsale = parseFloat(totalService) + parseFloat(totalRetail) + parseFloat(totalVoucher) + parseFloat(totalAdvance);
                
                $('#totalSale').html(parseFloat(todaytotalsale).toFixed(2));
                
                var advadj = data.AdvAdj !== null ? data.AdvAdj : 0;
                
                var totalRecovery = data.totalRecovery !== null ? data.totalRecovery : 0;
                var totalBalance = data.totalBalance !== null ? data.totalBalance : 0;
                var totalRetained = data.totalRetained !== null ? data.totalRetained : 0;
                var totalCCTips = data.totalCCTip !== null ? data.totalCCTip : 0;
                var totalCCFee = data.totalCCCharge !== null ? data.totalCCCharge : 0;
                var totalExpense = data5.today_expenses !== null ? data5.today_expenses : 0;
                 var totalExtra = data.totalExtra !== null ? data.totalExtra : 0;
                var totalTax = data.totalTax !== null ? data.totalTax : 0;
                
                //var todaytransaction = ((parseFloat(todaytotalsale) + parseFloat(totalRecovery)) - (parseFloat(advadj)+parseFloat(totalBalance)))-(totalCCTips);
                var todaytransaction = ((parseFloat(todaytotalsale) + parseFloat(totalRecovery) +parseFloat(totalCCFee)+parseFloat(totalCCTips)) - (parseFloat(advadj)+parseFloat(totalBalance)));
                //$('#totalTransaction').html((parseFloat(totalSale)+parseFloat(totalAdvance)+parseFloat(totalRecovery)+parseFloat(totalRetained))-(parseFloat(totalBalance)+parseFloat(totalExpense)+parseFloat(totalCCTips)));
                $('#totalTransaction').html(parseFloat(todaytransaction).toFixed(2));
                
                var Cash = data.Cash !== null ? data.Cash : 0;
                var Card = data.Card !== null ? data.Card : 0;
                var Checks = data.Checks !== null ? data.Checks : 0;
                var Loyalty = data.Loyalty !== null ? data.Loyalty : 0;
                var Voucher = data.totalVoucher !== null ? data.totalVoucher : 0;

                var totalVoucherCash = data3.Cash !== null ? data3.Cash : 0;
                var totalVoucherCard = data3.Card !== null ? data3.Card : 0;
                var totalVoucherChecks = data3.Checks !== null ? data3.Checks : 0;
                

                if(data2 !== null){
                    $('#cash_addition').html(data2.cash_addition);
                    $('#5000').val(data2.x5000);
                    $('#1000').val(data2.x1000);
                    $('#500').val(data2.x500);
                    $('#100').val(data2.x100);
                    $('#50').val(data2.x50);
                    $('#20').val(data2.x20);
                    $('#10').val(data2.x10);
                    $('#5').val(data2.x5);
                    $('#1').val(data2.x1);
                    $('#today_till').html(data2.till_amounts);
                    //$('#totalDifference').html(data2.difference);
                    $('#cashRemarks').html(data2.remarks);
                } else{
                    $('#cashregister').attr('href', 'javascript:void(0);');
                }

                if(data4 !== null){
                    $('#yesterday_till').html(data4.till_amounts);
                }else {$('#yesterday_till').html('0.00')};

               // var calCash=parseFloat(parseInt(Cash) + parseInt(totalVoucherCash)).toFixed(2);
                var calCash=parseFloat(parseInt(Cash) + parseInt(totalVoucherCash)).toFixed(2);
                //totalCash = parseFloat(calCash - parseInt(totalExpense)).toFixed(2);
                totalCash = parseFloat(calCash - parseInt(totalExpense) - parseInt(totalCCTips)).toFixed(2);
                totalSale = parseFloat(parseInt(totalSale) + parseInt(totalVoucher)).toFixed(2);

                var paymentCash = (parseFloat(parseInt(Cash) + parseInt(totalVoucherCash)).toFixed(2));
                var paymentCard = (parseFloat(parseInt(Card) + parseInt(totalVoucherCard)).toFixed(2));
                var paymentChecks = (parseFloat(parseInt(Checks) + parseInt(totalVoucherChecks)).toFixed(2));

                $('#totalCash').html(parseFloat(totalCash).toFixed(2));
                $('#totalCash1').html(parseFloat(totalCash).toFixed(2));
                
                $('#totalVoucherSold').html(parseFloat(totalVoucher).toFixed(2));
                $('#totalAdvanceAdjusted').html(parseFloat(advadj).toFixed(2));
                $('#totalBalance').html(parseFloat(totalBalance).toFixed(2));
                $('#totalRecovery').html(parseFloat(totalRecovery).toFixed(2));
                $('#totalRetained').html(parseFloat(totalRetained).toFixed(2));
                $('#totalRetained1').html(parseFloat(totalRetained).toFixed(2));
                
                if(parseFloat(totalRetained)===0){$('#trretained').hide();} else {$('#trretained').show();}
                $('#totalCCTips').html(parseFloat(totalCCTips).toFixed(2));
                $('#totalCCTips1').html(parseFloat(totalCCTips).toFixed(2));
                
                if(parseFloat(totalCCTips)===0){$('#trcctips').hide();} else {$('#trcctips').show();}
                
                $('#totalCCFee').html(parseFloat(totalCCFee).toFixed(2));
                if(parseFloat(totalCCFee)===0){$('#trccfee').hide();} else {$('#trccfee').show();}
                
                $('#totalAdvance').html(parseFloat(totalAdvance).toFixed(2));
                $('#totalService').html(parseFloat(totalService).toFixed(2));
                $('#totalRetail').html(parseFloat(totalRetail).toFixed(2));
                $('#totalExpenses').html(parseFloat(totalExpense).toFixed(2));
                $('#totalExpenses1').html(parseFloat(totalExpense).toFixed(2));
                
                $('#Cash').html(parseFloat(paymentCash).toFixed(2));
                $('#Cash1').html(parseFloat(paymentCash).toFixed(2));
                $('#Card').html(parseFloat(paymentCard).toFixed(2));
                $('#Checks').html(parseFloat(paymentChecks).toFixed(2));
                $('#Loyalty').html(parseFloat(Loyalty).toFixed(2));
                $('#totalVoucher').html(parseFloat(Voucher).toFixed(2));
                 $('#totalExtra').html(parseFloat(totalExtra).toFixed(2));
                $('#totalTax').html(parseFloat(totalTax).toFixed(2));
                //$('#totalTransaction').html((parseFloat(totalSale)+parseFloat(totalAdvance)+parseFloat(totalRecovery))-(parseFloat(totalBalance)+parseFloat(totalExpense)));
                
                $("#totalpayments").html(parseFloat(parseFloat(paymentCard)+parseFloat(paymentCash)+parseFloat(paymentChecks)+parseFloat(Voucher)).toFixed(2));
                
                updateCashRegister($('#5000'));

                $('#cash_register_modal').modal({
                    backdrop:'static',
                    keyboard:false,
                    show:true
                });
            }
        });
    }
    function updateCashRegister(click){
        
        if(click.val() === ""){
            return false;
        }
        
        var x5000 = parseInt($('#5000').val()) * parseInt($('#5000').attr('id'));
        $('#x5000').html(parseFloat(x5000).toFixed(2));
        var x1000 = parseInt($('#1000').val()) * parseInt($('#1000').attr('id'));
        $('#x1000').html(parseFloat(x1000).toFixed(2));
        var x500 = parseInt($('#500').val()) * parseInt($('#500').attr('id'));
        $('#x500').html(parseFloat(x500).toFixed(2));
        var x100 = parseInt($('#100').val()) * parseInt($('#100').attr('id'));
        $('#x100').html(parseFloat(x100).toFixed(2));
        var x50 = parseInt($('#50').val()) * parseInt($('#50').attr('id'));
        $('#x50').html(parseFloat(x50).toFixed(2));
        var x20 = parseInt($('#20').val()) * parseInt($('#20').attr('id'));
        $('#x20').html(parseFloat(x20).toFixed(2));
        var x10 = parseInt($('#10').val()) * parseInt($('#10').attr('id'));
        $('#x10').html(parseFloat(x10).toFixed(2));
        var x5 = parseInt($('#5').val()) * parseInt($('#5').attr('id'));
        $('#x5').html(parseFloat(x5).toFixed(2));
        var x1 = parseInt($('#1').val()) * parseInt($('#1').attr('id'));
        $('#x1').html(parseFloat(x1).toFixed(2));
        
        var total_sum = x5000 + x1000 + x500 + x100 + x50 + x20 + x10 + x5 +x1;
        
        $('#totalSub').html(parseFloat(total_sum).toFixed(2));
        
        var cash_addition= parseInt($('#cash_addition').text());
        var yesterday_till = parseInt($('#yesterday_till').text());
        var opening_balance = cash_addition + yesterday_till;
        var totalSub = parseInt($('#totalSub').html());
        
        $("#totalOpening").text(parseFloat(opening_balance).toFixed(2));
        
        var totalCash = parseInt($('#totalCash').html());
        
        
        var totalGrand = totalCash + opening_balance;
        $("#totalGrand").text(totalGrand.toFixed(2));
        
        var totalDifference = totalSub - totalGrand;
        var totalTillDifference = totalSub - totalGrand;
        
        if(totalDifference === 0){
            $('#totalDifference').css('color', '#797979');
            $('#totalDifference').html(parseFloat(totalDifference).toFixed(2));
        } else if(totalDifference > 0){
            $('#totalDifference').css('color', 'green');
            $('#totalDifference').html(parseFloat(totalDifference).toFixed(2));
        } else{
            $('#totalDifference').css('color', 'red');
            $('#totalDifference').html(parseFloat(totalDifference).toFixed(2));
        }
        
         if(totalTillDifference === 0){
            $('#totalTillDifference').css('color', '#797979');
            $('#totalTillDifference').html(parseFloat(totalTillDifference).toFixed(2));
            
        } else if(totalTillDifference > 0){
            $('#totalTillDifference').css('color', 'green');
            $('#totalTillDifference').html(parseFloat(totalTillDifference).toFixed(2));
        } else{
            $('#totalTillDifference').css('color', 'red');
            $('#totalTillDifference').html(parseFloat(totalTillDifference).toFixed(2));
        }
        
    }
</script>