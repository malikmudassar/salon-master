<style>
    /* enable absolute positioning */
    .inner-addon { 
        position: relative; 
    }

    /* style icon */
    .inner-addon .glyphicon {
        position: absolute;
        padding: 10px;
        pointer-events: none;
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
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    <form method="get" action="<?php echo base_url(); ?>accounting_controller/accountvoucheradd">
                        <input type="hidden" name="voucher_add_csrf" id="voucher_add_csrf" value=""/>
<!--                        <button type="submit" onclick="$('#voucher_add_csrf').val($('#cook').val());" class="btn btn-custom waves-effect waves-light" >Add Account Voucher <span class="m-l-5"><i class="fa fa-plus"></i></span></button>-->
                    </form>
                </div>
                <h4 class="page-title">General Ledger (<?php echo $business[0]['business_name'];?>):</h4>
            </div>
        </div>

        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <h4 class="header-title m-t-0 m-b-10">Filters:</h4>
                    <div class="row m-b-10" id="div-filters">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label class="control-label">Start Date Range</label>
                                </div>
                                <div class="col-lg-3">
                                    <label class="control-label">End Date Range</label>
                                </div>
                                <div class="col-lg-2">
                                    <label class="control-label">Start Account Range</label>
                                </div>
                                
                                <div class="col-lg-3">
                                    <label class="control-label">End Account Range</label>
                                </div>
                                
                                <div class="col-lg-2"></div>    
                            </div>
                        </div>
                        <div class="row">
                            <form method="post" action="<?php echo base_url();?>general_ledger">
                                <input type="hidden" name="csrf_test_name" id="accounting_voucher_csrf" value=""/>
                                <div class="col-lg-3">
                                    <input style="background-color: white;" required readonly class="form-control" type="text" name="startdate" id="startdate" value="<?php if(isset($startdate)){echo $startdate;}?>"/>                                
                                </div>
                                <div class="col-lg-3">
                                    <input style="background-color: white;" required readonly class="form-control" type="text" name="enddate" id="enddate" value="<?php if(isset($enddate)){echo $enddate;}?>"/>
                                </div>
                                
                                <div class="col-lg-2">
                                    <select class="form-control" id="fromAccount" name="from_accounts">
                                        
                                        <option value="0">All</option>
                                        <?php foreach($account_heads as $ba){?>
                                        <option <?php if(isset($from_account)){if($from_account== $ba['id_account_heads']){echo " selected='selected' ";}}?> value="<?php echo $ba['id_account_heads'];?>"><?php echo $ba['account_head'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="col-lg-2">
                                    <select class="form-control" id="toAccount" name="to_accounts">
                                        
                                        <option value="0">All</option>
                                        <?php foreach($account_heads as $ba){?>
                                        <option <?php if(isset($to_account)){if($to_account== $ba['id_account_heads']){echo " selected='selected' ";}}?> value="<?php echo $ba['id_account_heads'];?>"><?php echo $ba['account_head'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                
                                <div class="col-lg-4 hidden">
                                    <select class="form-control" id="voucher_type" name="voucher_type">
                                        <option value="">All</option>
                                        <?php foreach($voucher_types as $vt){ ?>
                                        <option <?php if(isset($voucher_type)){if($voucher_type== $vt['id_account_voucher_type']){echo " selected='selected' ";}}?> value="<?php echo $vt['id_account_voucher_type']; ?>"><?php echo $vt['account_voucher_type']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="col-lg-2"><button type="submit" onclick="$('#accounting_voucher_csrf').val($('#cook').val());" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button></div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="header-title m-t-30 m-b-10">General Ledger:</h4>
                            <?php if(sizeof($account_vouchers) == 0){echo '<table class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%"><tr><th>Voucher ID</th><th>Desc</th><th>Type</th><th>Business Partner</th><tr><tbody><tr><th colspan="4">Waiting . . . .</th></tr></tbody></table>'; } else { foreach($account_vouchers as $index=>$value): $tbalance=0; $openingbalance=0;?> 
                            
                            <?php $tempAcc = explode('|',$index); ?>
                            <div class="col-md-12 col-xs-6" style="font-weight: bold;background-color: lightgray;color:black;">Account Number: <?php echo  $tempAcc[0] ?>  &nbsp;&nbsp;&nbsp; Account Title: <?php echo  $tempAcc[1] ?>   <span class="pull-right">Opening Balance :   <?php echo number_format($value['opening_balance'][0]); ?></span> </div>
                            <?php $openingbalance=$value['opening_balance'][0];?>
                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            
                                <thead>
                                    <tr>
                                        <th>Voucher ID</th>
                                        <th>Desc.</th>
                                        <th>Type</th>
                                        <th>Business Partner</th>
                                        <th>Date</th>
                                        <th>Created By</th>
                                        <th>Cost Center</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php  $balance=0; $d = 0;$c=0; $last_desc="";$last_type="";$last_bus="";$last_date="";$last_user=""; $debit=0; $credit=0; foreach($value['details'] as $account_head){ ?>
                                    <tr>
                                        
                                            <td style="border-top:1px solid #000"><?php echo $account_head['id_account_vouchers']; ?></td>
                                            <?php  if($last_desc!==$account_head['description']):?>
                                                <td style="border-top:1px solid #000"><?php echo $account_head['description']; ?></td>
                                            <?php else: ?>
                                                <td></td>
                                            <?php endif; $last_desc=$account_head['description']; ?>
                                                
                                            <?php  if($last_type!==$account_head['account_voucher_type']):?>
                                            <td style="border-top:1px solid #000"><?php echo $account_head['account_voucher_type']; ?></td>
                                             <?php else: ?>
                                                <td></td>
                                            <?php endif; $last_type=$account_head['account_voucher_type']; ?>
                                            
                                            <?php  if($last_bus!==$account_head['business_partner_name']):?>
                                            <td style="border-top:1px solid #000"><?php echo $account_head['business_partner_name']; ?></td>
                                             <?php else: ?>
                                                <td></td>
                                            <?php endif; $last_bus=$account_head['business_partner_name']; ?>
                                            
                                            <?php  if($last_date!==$account_head['voucher_date']):?>
                                            <td style="border-top:1px solid #000"><?php echo $account_head['voucher_date']; ?></td>
                                             <?php else: ?>
                                                <td></td>
                                            <?php endif; $last_date=$account_head['voucher_date']; ?>
                                            
                                              
                                            <?php  if($last_user!==$account_head['created_by']):?>
                                            <td style="border-top:1px solid #000"><?php echo $account_head['created_by']; ?></td>
                                             <?php else: ?>
                                                <td></td>
                                            <?php endif; $last_user=$account_head['created_by']; ?>
                                            
                                            <td style="border-top:1px solid #000"><?php echo $account_head['cost_center_name']; ?></td>
                                            <td style="border-top:1px solid #000; text-align: right; font-weight: bold;" class="text-success"><?php if($account_head['debit']>0) echo $account_head['debit']; $debit=$debit+$account_head['debit']; ?></td>
                                            <td style="border-top:1px solid #000; text-align: right; font-weight: bold;" class="text-success"><?php if($account_head['credit']>0)echo $account_head['credit']; $credit=$credit+$account_head['credit'];?></td>
                                            
                                            <?php 
                                                $d = $account_head['debit'];
                                                $c = $account_head['credit'];
                                                if($account_head['account_type']=='Assets' || $account_head['account_type']=='Expenses'){
                                                    $balance = $d - $c;
                                                } else {
                                                    $balance = $c - $d;
                                                    
                                                }
                                                $tbalance=$tbalance+$balance;
                                            ?>
                                            
                                            <td style="border-top:1px solid #000;text-align: right; font-weight: bold;" class='noprint'> 
                                               <?php echo  number_format($balance,2); ?>
                                            </td>
                                        
                                    </tr>
                                    <?php }?>
                                   
                                </tbody>
                                <tfoot>
                                    <td colspan="7" style="text-align: right; font-weight: bold;">Summary</td>
                                    <td style="text-align: right; font-weight: bold;"><?php echo $debit; ?></td>
                                    <td style="text-align: right; font-weight: bold;"><?php echo $credit; ?></td>
                                    <td style="text-align: right; font-weight: bold;"><?php echo   number_format($openingbalance + $tbalance,2); ?></td>
                                </tfoot>
                            </table>
                            <br />
                            <?php endforeach; }?> 
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#fromAccount").select2();
        $("#toAccount").select2();
        
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



    function runreport() {
        
        if ($('#rangehidden').val() != 0) {
            $("#cog").show();
            setTimeout(function() {
                $("#cog").hide();
            }, 500);

            if (startdate == "" || enddate == "") {
                return false;
            } else {
                $('#rangehidden').val(0);
            }

        }
        if (startdate == "" || enddate == "") {
            swal({
                title: "Select Date Range",
                text: "Please select a date Range",
                type: "warning",
                confirmButtonText: 'OK!'
            });
            return false;
        }
        
        console.log(startdate.format('YYYY-MM-DD') + ' ' + enddate.format('YYYY-MM-DD'));
        voucher_list();

    }



</script>