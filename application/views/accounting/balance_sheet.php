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
<?php
    //echo "<pre>";
    //print_r($balanceSheet);
    //exit();
?>
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
                <h4 class="page-title">Balance Sheet (<?php echo $business[0]['business_name'];?>):</h4>
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
                                
                                <div class="col-lg-6">
                                    <label class="control-label">End Date Range</label>
                                </div>
<!--                                <div class="col-lg-4">
                                    <label class="control-label">Account Range</label>
                                </div>-->
                                <div class="col-lg-2"></div>    
                            </div>
                        </div>
                        <div class="row">
                            <form method="post" action="<?php echo base_url();?>balacne_sheet">
                                
                                <input type="hidden" name="csrf_test_name" id="accounting_voucher_csrf" value=""/>
                                <div class="col-lg-3">
                                    <input style="background-color: white;" required readonly class="form-control" type="text" name="startdate" id="startdate" value="<?php if(isset($startdate)){echo $startdate;}?>"/>                                
                                </div>
                                <div class="col-lg-3">
                                    <input style="background-color: white;" required readonly class="form-control" type="text" name="enddate" id="enddate" value="<?php if(isset($enddate)){echo $enddate;}?>"/>
                                </div>
                                
                                <div class="col-lg-2 hidden">
                                    <select class="form-control" id="fromAccount" name="from_accounts">
                                        
                                        <option value="0">All</option>
                                        <?php foreach($account_heads as $ba){?>
                                        <option <?php if(isset($from_account)){if($from_account== $ba['id_account_heads']){echo " selected='selected' ";}}?> value="<?php echo $ba['id_account_heads'];?>"><?php echo $ba['account_head'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="col-lg-2 hidden">
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
                         <div class="col-md-12">
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th class="text-center">ASSETS</th>
                                    <th class="text-center">EQUITIES</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <tr>
                                        <td>
                                        <?php $total_assets =0; foreach($balanceSheet['Assets'] as $ma_index=>$ma_value): ?> 
                                        <table class="table table-bordered table-condensed">
                                            <tbody>
                                                <tr><td colspan="3"><strong><i><?php echo  $ma_index ?></i></strong></td></tr>
                                            <?php $total=0; foreach($ma_value as $index=>$value): ?>    
                                                <tr>
                                                    <td style="width:80%;"><?php echo  $index ?></td>
                                                    <td style="width:20%;"><?php echo  $value[0]['balance'] < 0 ? "(".abs($value[0]['balance']).")" : $value[0]['balance'] ?></td>
                                                    <?php $total += $value[0]['balance']; ?>
                                                    <?php $total_assets += $value[0]['balance']; ?>
                                               </tr>
                                            <?php endforeach; ?> 
                                                <tfoot>
                                                <th>Total:</th>
                                                <th><?php echo  number_format(abs($total),2) ?></th>
                                                </tfoot> 
                                            </tbody>
                                            </table>
                                            <?php endforeach; ?>  
                                        </td>
                                    <td>
                                        <?php $total_equits=0; foreach($balanceSheet['Liabilities'] as $ma_index=>$ma_value): ?> 
                                        <table class="table table-bordered table-condensed">
                                            <tbody>
                                                <tr><td colspan="3"><strong><i><?php echo  $ma_index ?></i></strong></td></tr>
                                            <?php $total=0; foreach($ma_value as $index=>$value): ?>    
                                                <tr>
                                                    <td style="width:80%;"><?php echo  $index ?></td>
                                                    <td style="width:20%;"><?php echo  $value[0]['balance'] < 0 ? "(".abs($value[0]['balance']).")" : $value[0]['balance'] ?></td>
                                                    <?php $total += $value[0]['balance']; ?>
                                                    <?php $total_equits += $value[0]['balance']; ?>
                                               </tr>
                                            <?php endforeach; ?> 
                                                <tfoot>
                                                <th>Total:</th>
                                                <th><?php if($total < 0){ echo "(".abs($total).")"; } else {echo number_format($total,2);} ?></th>
                                                </tfoot> 
                                            </tbody>
                                        </table>
                                        <?php endforeach; ?>  
                                        
                                        
                                        
                                        <?php $total_invoice_income=0; foreach($invoice as $index=>$value): ?>  
                                            <?php if($index !== 'totalPaid'): ?>
                                                <?php $total_invoice_income += $value; ?>
                                            <?php endif; ?> 
                                        <?php endforeach; ?> 
                                        
                                        <?php $total_voucher_income=0; foreach($voucher as $index=>$value): ?>  
                                               <?php if($index !== 'totalVoucherAmount'): ?>
                                                   <?php $total_voucher_income += $value; ?>
                                              <?php endif; ?> 
                                        <?php endforeach; ?> 
                                               
                                               
                                        
                                         <?php foreach($balanceSheet['Capital'] as $ma_index=>$ma_value): ?> 
                                        <table class="table table-bordered table-condensed">
                                            <tbody>
                                                <tr><td colspan="3"><strong><i><?php echo  $ma_index ?></i></strong></td></tr>
                                            <?php $total=0; foreach($ma_value as $index=>$value): ?>    
                                                <tr>
                                                   <?php if($index === 'Income Summary'): ?> 
                                                    
                                                    <td style="width:80%;"><?php echo  $index ?></td>
                                                    <td style="width:20%;"><?php echo  $total_invoice_income + $total_voucher_income ?></td>
                                                    <?php $total += $total_invoice_income + $total_voucher_income; ?>
                                                    <?php $total_equits += $total_invoice_income + $total_voucher_income; ?>
                                                    
                                                    
                                                    <?php else: ?> 
                                                    
                                                    <td style="width:80%;"><?php echo  $index ?></td>
                                                    <td style="width:20%;"><?php echo  $value[0]['balance'] < 0 ? "(".abs($value[0]['balance']).")" : $value[0]['balance'] ?></td>
                                                    <?php $total += $value[0]['balance']; ?>
                                                    <?php $total_equits += $value[0]['balance']; ?>
                                                    
                                                   <?php endif; ?> 
                                               </tr>
                                            <?php endforeach; ?> 
                                                <tfoot>
                                                <th>Total:</th>
                                                <th><?php echo  number_format(abs($total),2) ?></th>
                                                </tfoot> 
                                            </tbody>
                                        </table>
                                        <?php endforeach; ?>  
                                        
                                   </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>
                                        <div class="pull-left">Total Assets</div>
                                        <div class="pull-right"><?php echo number_format(abs($total_assets), 2); ?></div>
                                    </th>
                                    <th>
                                        <div class="pull-left">Total Equities</div>
                                        <div class="pull-right" id="total_equities"><?php echo  number_format(abs($total_equits), 2) ?></div>
                                    </th>
                                </tr>
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