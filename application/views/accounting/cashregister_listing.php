<style>
    /* enable absolute positioning */
    .inner-addon { 
        position: relative; 
    }

    /* style icon */
    .inner-addon .glyphicon {
        position: absolute;
        padding: 10px;
        pointvaler-events: none;
    }

    /* align icon */
    .left-addon .glyphicon  { left:  0px;}
    .right-addon .glyphicon { right: 0px;}

    /* add padding  */
    .left-addon input  { padding-left:  30px; }
    .right-addon input { padding-right: 30px; }

    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('<?php echo base_url(); ?>assets/images/page-loader-1.gif') 50% 50% no-repeat ;
        display: none;
    }


    table.dataTable tr.group td{font-weight:bold;background-color:#e0e0e0}
    
     table.dataTable tr.group,
        tr.group:hover {
            background-color: #ddd !important;
        }
    
</style>

<div class="wrapper">
    <div class="container-full">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    
                </div>
                <h4 class="page-title">Cash Registers Status (<?php echo $business[0]['business_name'];?>):</h4>
            </div>
        </div>

        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <h4 class="header-title m-t-0 m-b-10">Filters:</h4>
                    <div class="row m-b-10" id="div-filters">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="control-label">Select Ending date of the week</label>
                                </div>
                                <div class="col-lg-4">
                                    <label class="control-label">Voucher Type</label>
                                </div>
                                <div class="col-lg-2"></div>    
                            </div>
                        </div>
                        <div class="row">
                            <form method="post" action="<?php echo base_url();?>cashregister_listing">
                                <input type="hidden" name="csrf_test_name" id="cash_register_csrf" value=""/>
<!--                                <div class="col-lg-3">
                                    <input style="background-color: white;" readonly class="form-control" type="text" name="startdate" id="startdate" value="<?php if(isset($startdate)){echo $startdate;}?>"/>                                
                                </div>-->
                                <div class="col-lg-6">
                                    <input style="background-color: white;" readonly class="form-control" type="text" name="enddate" id="enddate" value="<?php if(isset($enddate)){echo $enddate;}?>"/>
                                </div>
                                <div class="col-lg-4">
                                    <select class="form-control" id="cashregister_status" name="cashregister_status">
                                        <option value="">All</option>
                                        
                                        <option <?php if(isset($selectedstatus)){if($selectedstatus== 'open'){echo " selected='selected' ";}}?> value="open">Open</option>
                                        <option <?php if(isset($selectedstatus)){if($selectedstatus== 'closed'){echo " selected='selected' ";}}?> value="closed">Closed</option>
                                    </select>
                                </div>
                                <div class="col-lg-2"><button type="submit" onclick="$('#cash_register_csrf').val($('#cook').val());" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button></div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="header-title m-t-30 m-b-10">Cash Resister Entries:</h4>
                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>WorkDate</th>
                                        <th>Status</th>
                                        <th>Total Sale</th>
                                        <th>+ Advance</th>
                                        <th>+ Recovery</th>
                                        <th>+ Retained</th>
                                        <th>- Balance</th>
                                        <th>- Expense</th>
                                        
                                        <th>Yesterday's Till</th>
                                        <th>Additional Amount</th>
                                        <th>Tomorrow's Till</th>
                                        <th>Cash Invoices</th>
                                        <th>Card Invoices</th>
                                        <th>Cash In Hand</th>
                                        <th>Difference</th>
                                        <th>Remarks</th>
                                        
                                        <th></th>
                                <tbody>
                                    </tr>
                                </thead>
                                    <?php $index=0; foreach($transactions as $transaction){ 
                                        
                                        $totalCash = $transaction->totalCash ;
                                        $totalSale = $transaction->totalSale ;
                                        $totalBalance = $transaction->totalBalance ;
                                        $totalRecovery = $transaction->totalRecovery ;
                                        $totalAdvance = $transaction->totalAdvance ;
                                        $totalService = $transaction->totalService;
                                        $totalRetail = $transaction->totalRetail;
                                        $totalExpense = $expenses[$index]->today_expenses;

                                        $totalVoucher = $vouchers[$index]->totalVoucherAmount ;
                                        $Cash = floatval($transaction->Cash) - floatval($transaction->cctip);
                                        $Card = $transaction->Card ;
                                        $Checks = $transaction->Checks ;

                                        $Voucher = $transaction->totalVoucher;

                                        $totalVoucherCash = $vouchers[$index]->Cash;
                                        $totalVoucherCard = $vouchers[$index]->Card;
                                        $totalVoucherChecks = $vouchers[$index]->Checks;
                                        $yestertill = $yesterdaytill[$index]->till_amounts;
                                        $totaltillamounts = $denominations[$index]->till_amounts;
                                        $additionalamount= $denominations[$index]->cash_addition ;
                                        $totalRetained= $transaction->totalRetained;
                                        $calCash=floatval(intval($Cash) + intval($totalVoucherCash) );
                                        $totalCash = floatval($calCash - intval($totalExpense)) ;
                                        $totalSale = floatval(intval($totalSale) + intval($totalVoucher)) ;

                                        $cashInHand= $denominations[$index]->cash;
                                        $difference= $denominations[$index]->diff ;

                                        $diff=((floatval(intval($cashInHand) - intval($yestertill) - intval($additionalamount)) - intval($totalCash)) );

                                        $paymentCash = (floatval(intval($Cash) + intval($totalVoucherCash)) );
                                        $paymentCard = (floatval(intval($Card) + intval($totalVoucherCard)) );
                                        $paymentChecks = (floatval(intval($Checks) + intval($totalVoucherChecks)) );

                                        $totalTransaction=floatval((floatval($totalSale)+floatval($totalAdvance)+floatval($totalRecovery)+floatval($totalRetained))-(floatval($totalBalance)+floatval($totalExpense))) ;
                                ?>
                                    <tr>
                                       
                                            <td style="border-top:1px solid #000"><?php echo $transaction->passeddate; ?></td>
                                            <td style="border-top:1px solid #000"><?php echo $denominations[$index]->register_status; ?></td>
                                            <td style="border-top:1px solid #000"><?php echo $totalSale; ?></td>
                                            <td style="border-top:1px solid #000"><?php echo $totalAdvance; ?></td>
                                            <td style="border-top:1px solid #000"><?php echo $totalRecovery; ?></td>
                                            <td style="border-top:1px solid #000"><?php echo $totalRetained; ?></td>
                                            <td style="border-top:1px solid #000"><?php echo $totalBalance; ?></td>
                                            <td style="border-top:1px solid #000"><?php echo $totalExpense; ?></td>
                                            <td style="border-top:1px solid #000" class="text-info"><?php echo $yestertill; ?></td>
                                            <td style="border-top:1px solid #000" class="text-info"><?php echo $additionalamount; ?></td>
                                            <td style="border-top:1px solid #000" class="text-info"><?php echo $totaltillamounts; ?></td>
                                            <td style="border-top:1px solid #000"><?php echo $paymentCash; ?></td>
                                            <td style="border-top:1px solid #000"><?php echo $paymentCard; ?></td>
                                            <td style="border-top:1px solid #000"><?php echo $cashInHand; ?></td>
                                            <td style="border-top:1px solid #000"><?php echo $diff; ?></td>
                                            <td style="border-top:1px solid #000"><?php echo $denominations[$index]->remarks; ?></td>
                                            
                                            
                                            <td style="border-top:1px solid #000" class='noprintval'> 
                                         
                                            </td>
                                        
                                            
                                    </tr>
                                    <?php $index++; }?>
                                </tbody>
                                <tfoot>
                                    <td colspan="15" style="text-align: right; font-weight: bold;">Total</td>
                                    
                                    <td></td>
                                </tfoot>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>

<script>
    $(document).ready(function() {
        
        $("#startdate").datepicker({autoclose:true, format:'yyyy-mm-dd'});
        $("#enddate").datepicker({autoclose:true, format:'yyyy-mm-dd'});


        $('#datatable-buttons').DataTable({
            lengthMenu: [[25, 50, -1], [25, 50, "All"]],
            stateSave: true,
            dom: "Bfrtlip",
            ordering:false,
            buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"}, {
                    extend: "excel",
                    className: "btn-sm btn-warning btn-trans"
                }, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}],
            responsive: !0
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

        $(".numeric").keypress(function(e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    });




</script>