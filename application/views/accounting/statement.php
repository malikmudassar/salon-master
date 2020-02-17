<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                
                <h4 class="page-title">Statement(<?php echo $business[0]['business_name'];?>):</h4>
            </div>
        </div>

        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <div class="row hidden-print">
                        <div class="col-md-12">
                            
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-lg-8">
                            <div class="row m-t-15">
                                <div class="col-md-12 col-xs-12">
                                    <div class="pull-left">
                                        <h3 class="logo invoice-logo"><?php if(isset($business)){ echo "<img src='".base_url().'assets/images/business/'.$business[0]['business_logo']."' alt='".$business[0]['business_name']."' class='img-responsive' />";} else {echo 'SalonPK';}?></h3>
                                    </div>
                                    <div class="btn-group pull-right hidden-print m-t-20">
                                        <form method="POST" action='<?php echo base_url();?>/accounting_controller/statement'>
                                            <input type="hidden" name="csrf_test_name" id="statement_csrf" value=""/>
                                            <div class="col-md-3 pull-right">
                                                <button type='submit' onclick="$('#statement_csrf').val($('#cook').val());" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button>
                                            </div>
                                            <div class="col-md-3 pull-right">
                                                <input style="background-color: white;" readonly class="form-control" type="text" name="enddate" id="enddate" value="<?php if(isset($enddate)){echo $enddate;}?>"/>
                                            </div>
                                            
                                            <div class="col-md-3 pull-right" >
                                                <input style="background-color: white;" readonly class="form-control" type="text" name="startdate" id="startdate" value="<?php if(isset($startdate)){echo $startdate;}?>"/>                                
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12">
                                    <h4 class="header-title m-t-30 m-b-10">Statement from <?php echo $startdatetxt; ?> to <?php echo $enddatetxt; ?> :</h4>
                                </div>
                            </div>
                           <!---Revenue-->
                           <div class="row">
                               <div class="col-md-12 col-xs-12 "><h4>Revenue:</h4></div>
                           </div>
                           
                           <div class="row">
                               
                                    <div class="col-md-4 col-xs-4">Services Income</div>
                                    <div class="col-md-4 col-xs-4 text-right"><?php echo number_format($serviceincome[0]['Paid'],2); ?></div>
                                    <div class="col-md-4 col-xs-4 text-right"></div>                                    
                               
                           </div>
                           <div class="row">
                               
                                    <div class="col-md-4 col-xs-4">Retail Income</div>
                                    <div class="col-md-4 col-xs-4 text-right"><?php echo number_format($retailincome[0]['Paid'],2); ?></div>
                                    <div class="col-md-4 col-xs-4 text-right"></div>                                    
                               
                           </div>
                           <div class="row">
                               
                                    <div class="col-md-4 col-xs-4">Vouchers (Sold) Income</div>
                                    <div class="col-md-4 col-xs-4 text-right"><?php echo number_format($serviceincome[0]['voucher'],2); ?></div>
                                    <div class="col-md-4 col-xs-4 text-right"></div>                                    
                               
                           </div>
                           <div class="row">
                               
                                    <div class="col-md-4 col-xs-4">Service Advance Income</div>
                                    <div class="col-md-4 col-xs-4 text-right"><?php echo number_format($advancereceived[0]['advance'],2); ?></div>
                                    <div class="col-md-4 col-xs-4 text-right"></div>                                    
                               
                           </div>
                           <div class="row">
                              
                                    <div class="col-md-4 col-xs-4">Other Income</div>
                                    <div class="col-md-4 col-xs-4 text-right"><?php echo number_format($receivevouchers[0]['payments'],2); ?></div>
                                    <div class="col-md-4 col-xs-4 text-right"></div>                                    
                               
                               
                           </div>
                           
                           
                           <div class="row">
                                <div class="col-md-12" style="border-top:#808080 1px solid;"></div>
                            </div>
                           <div class="row">
                               
                                   <div class="col-md-4 col-xs-4"><strong>Total Income</strong></div>
                                    <div class="col-md-4 col-xs-4 text-right"></div>                    
                                    <div class="col-md-4 col-xs-4 text-right"><strong><?php echo number_format($serviceincome[0]['Paid'] + $retailincome[0]['Paid'] + $advancereceived[0]['advance'] + $serviceincome[0]['voucher'] + $receivevouchers[0]['payments'],2); ?></strong></div>
                               
                           </div>
                           <!---Revenue End-->
                           <!---Expenses-->
                           <div class="row">
                               <div class="col-md-12"><h4>Expenses:</h4></div>
                           </div>
                           
                           <div class="row">
                               
                                    <div class="col-md-4 col-xs-4">Cost of Goods Sold</div>
                                    <div class="col-md-4 col-xs-4 text-right"><?php echo number_format($paymentvouchers[0]['payments'],2); ?></div>
                                    <div class="col-md-4 col-xs-4 text-right"></div>                                    
                               
                           </div>
                           
                           <div class="row">
                              
                                    <div class="col-md-4 col-xs-4">Credit Card Tips</div>
                                    <div class="col-md-4 col-xs-4 text-right"><?php echo number_format($serviceincome[0]['cctip']+$retailincome[0]['cctip'],2); ?></div>
                                    <div class="col-md-4 col-xs-4 text-right"></div>                                    
                               
                           </div>
                           
                           <div class="row">
                               
                                    <div class="col-md-4 col-xs-4">Salaries</div>
                                    <div class="col-md-4 col-xs-4 text-right"><?php echo number_format($salaries[0]['total'],2); ?></div>
                                    <div class="col-md-4 col-xs-4 text-right"></div>                                    
                               
                           </div>
                           <div class="row">
                               
                                    <div class="col-md-4 col-xs-4">Staff Commissions</div>
                                    <div class="col-md-4 col-xs-4 text-right"><?php echo number_format($commissions[0]['total'],2); ?></div>
                                    <div class="col-md-4 col-xs-4 text-right"></div>                                    
                               
                           </div>
                           <div class="row">
                               
                                    <div class="col-md-4 col-xs-4">Other Staff Benefits</div>
                                    <div class="col-md-4 col-xs-4 text-right"><?php echo number_format($otherstaffpayments[0]['total'],2); ?></div>
                                    <div class="col-md-4 col-xs-4 text-right"></div>                                    
                               
                           </div>
                           <div class="row">
                                 <div class="col-md-12" style="border-top:#808080 1px solid;"></div>
                             </div>
                           <div class="row">
                              
                                   <div class="col-md-4 col-xs-4"><strong>Total Expenses</strong></div>
                                    <div class="col-md-4 col-xs-4 text-right"></div>                    
                                    <div class="col-md-4 col-xs-4 text-right"><strong>(<?php echo number_format($paymentvouchers[0]['payments'] + $serviceincome[0]['cctip']+$retailincome[0]['cctip'] +$commissions[0]['total']+$salaries[0]['total']+$otherstaffpayments[0]['total'] ,2); ?></strong>)</div>
                               
                           </div>
                           <!--Expenses End-->
                           <!---Expenses-->
                           <div class="row m-t-20">
                               <div class="col-md-12"><h4>Profit:</h4></div>
                           </div>
                           <div class="row ">
                               
                                   <?php 
                                    $income=$serviceincome[0]['Paid'] + $retailincome[0]['Paid']+$advancereceived[0]['advance']+$serviceincome[0]['voucher']+$receivevouchers[0]['payments'];
                                    $expenses=$paymentvouchers[0]['payments'] + $serviceincome[0]['cctip']+$retailincome[0]['cctip'] +$commissions[0]['total']+$salaries[0]['total']+$otherstaffpayments[0]['total'];
                                   ?>
                                   <div class="col-md-4 col-xs-4"><strong>Gross Profit Before Taxes</strong></div>
                                   <div class="col-md-4 col-xs-4 text-right"></div>                    
                                   <div class="col-md-4 col-xs-4 text-right"><strong><?php echo number_format($income-$expenses,2); ?></strong></div>
                               
                           </div>
                           <div class="row hidden-print m-t-20">
                               <div class="col-md-12 text-right">
                                   <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light" id="btnprint" ><i class="fa fa-print"></i></a>
                               </div>
                           </div>
                        </div>
                        
                         <div class="col-md-2"></div>
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