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
                <h4 class="page-title">Trial Balance (<?php echo $business[0]['business_name'];?>):</h4>
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
                                    <label class="control-label">Start Date</label>
                                </div>
                                <div class="col-lg-3">
                                    <label class="control-label">End Date</label>
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
                            <form method="post" action="<?php echo base_url();?>trial_balance">
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
                            <h4 class="header-title m-t-30 m-b-10">Trail Balance</h4>
                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                 <thead>
                                    <tr role="row" style="border-bottom: 1px solid #ddd;">
                                        <th>Account #</th>
                                        <th>Title</th>
                                        <th colspan="2" style="text-align: center;">Opening Balance</th>
                                        <th colspan="2" style="text-align: center;">Current Balance</th>
                                        <th colspan="2" style="text-align: center;">Net Balance</th>
                                    </tr>
                                    <tr role="row">
                                        <th colspan="2"></th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $tod=0;$toc=0;$tcd=0;$tcc=0;$tnd=0;$tnc=0; foreach($trial_data as $row){ $amount=0; $od=0;$oc=0;$cd=0;$cc=0;$nd=0;$nc=0; ?>
                                    <tr>
                                        
                                        <td><?php echo  $row['account_head_number']; ?></td>
                                        <td><?php echo  $row['account_head']; ?></td>
                                        
                                        <!--Opening Assets Expenses-->
                                        <?php if(isset($row['opening_asset']) && sizeof($row['opening_asset'])>0){ 
                                            if($row['opening_asset'][0]['balance'] && $row['opening_asset'][0]['balance']>0){?>
                                                <td class="text-right"><?php echo  number_format(abs($row['opening_asset'][0]['balance']),2); ?></td>
                                                <td class="text-right"><?php echo  number_format(0,2); ?></td>
                                                <?php $od= abs($row['opening_asset'][0]['balance']);?>
                                            <?php } else { ?>
                                                <td class="text-right"><?php echo  number_format(0,2); ?></td>
                                                <td class="text-right"><?php echo  number_format(abs($row['opening_asset'][0]['balance']),2); ?></td>
                                                <?php $oc= abs($row['opening_asset'][0]['balance']);?>
                                        <?php } 
                                        } else if(isset($row['opening_liability']) && sizeof($row['opening_liability'])>0){ 
                                            if($row['opening_liability'][0]['balance'] && $row['opening_liability'][0]['balance']<=0){?>
                                                <td class="text-right"><?php echo  number_format(abs($row['opening_liability'][0]['balance']),2); ?></td>
                                                <td class="text-right"><?php echo  number_format(0,2); ?></td>
                                                <?php $od= abs($row['opening_liability'][0]['balance']);?>
                                            <?php } else { ?>
                                                <td class="text-right"><?php echo  number_format(0,2); ?></td>
                                                <td class="text-right"><?php echo  number_format(abs($row['opening_liability'][0]['balance']),2); ?></td>
                                                <?php $oc= abs($row['opening_liability'][0]['balance']);?>
                                        <?php }
                                        
                                        } else {?>  
                                            <td class="text-right">0.00</td>
                                            <td class="text-right">0.00</td>
                                        <?php } ?>
                                        
                                        
                                        <!--Current Assets  Expenses-->
                                        <?php if(isset($row['current_asset']) && sizeof($row['current_asset'])>0){
                                            if($row['current_asset'][0]['balance'] && $row['current_asset'][0]['balance'] >0){?>
                                                <td class="text-right"><?php echo  number_format(abs($row['current_asset'][0]['balance']),2); ?></td>
                                                <td class="text-right"><?php echo  number_format(0,2); ?></td>
                                                <?php $cd= abs($row['current_asset'][0]['balance']);?>
                                            <?php } else { ?>
                                                <td class="text-right"><?php echo  number_format(0,2); ?></td>
                                                <td class="text-right"><?php echo  number_format(abs($row['current_asset'][0]['balance']),2); ?></td>
                                                <?php $cc= abs($row['current_asset'][0]['balance']);?>
                                            <?php } 
                                        
                                        } else if(isset($row['current_liability']) && sizeof($row['current_liability'])>0){
                                            if($row['current_liability'][0]['balance'] && $row['current_liability'][0]['balance']<=0){?>
                                                <td class="text-right"><?php echo  number_format(abs($row['current_liability'][0]['balance']),2); ?></td>
                                                <td class="text-right"><?php echo  number_format(0,2); ?></td>
                                                <?php $cd= abs($row['current_liability'][0]['balance']);?>
                                            <?php } else { ?>
                                                <td class="text-right"><?php echo  number_format(0,2); ?></td>
                                                <td class="text-right"><?php echo  number_format(abs($row['current_liability'][0]['balance']),2); ?></td>
                                                <?php $cc= abs($row['current_liability'][0]['balance']);?>
                                            <?php } 
                                        
                                        } else { ?>
                                            <td class="text-right">0.00</td>
                                            <td class="text-right">0.00</td>
                                        <?php } ?>
                                        
                                        
                                        <?php $amount = ($od+$cd) - ($oc+$cc); ?>
                                        
                                        <?php if($amount > 0){ ?>
                                        
                                            <td class="text-right"><?php echo  number_format(abs($amount),2); ?></td>
                                            <td class="text-right"><?php echo  number_format(0,2); ?></td>
                                            <?php $nd= abs($amount);?>
                                        <?php } else { ?>
                                            
                                            <td class="text-right"><?php echo  number_format(0,2); ?></td>
                                            <td class="text-right"><?php echo  number_format(abs($amount),2); ?></td>
                                            <?php $nc= abs($amount);?>
                                        <?php } ?>                             
                                    </tr>
                                <?php 
                                    $tod=$tod+$od;
                                    $toc=$toc+$oc;
                                    $tcd=$tcd+$cd;
                                    $tcc=$tcc+$cc;
                                    $tnd=$tnd+$nd;
                                    $tnc=$tnc+$nc;
                                    
                                        } ?>   
                                </tbody>
                                <tfoot>
                                   
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <th class="text-right"><?php echo  number_format($tod,2) ?></th>
                                        <th class="text-right"><?php echo  number_format($toc,2) ?></th>
                                        <th class="text-right"><?php echo  number_format($tcd,2) ?></th>
                                        <th class="text-right"><?php echo  number_format($tcc,2) ?></th>
                                        <th class="text-right"><?php echo  number_format($tnd,2) ?></th>
                                        <th class="text-right"><?php echo  number_format($tnc,2) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                            <br />
                            
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