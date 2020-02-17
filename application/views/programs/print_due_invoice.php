<style>
        .table1{}
        .table1 td{
            border-top: none !important;
            padding:1px 8px 1px 8px !important;
        }
</style>  
<div class="wrapper">
            <div class="container">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">Payments <?php echo $program_enrollment[0]['customer_name']; ?> </h4>
                    </div>
                </div>
                <?php if ($this->session->flashdata('Success') && $this->session->flashdata('Success') != "") { ?>
                    <div class="row hidden-print">
                        <div class="col-sm-12">
                            <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Success!</strong> <?php echo $this->session->flashdata('Success'); ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('Error') && $this->session->flashdata('Error') != "") { ?>
                    <div class="row hidden-print">
                        <div class="col-sm-12">
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Error!</strong> <?php echo $this->session->flashdata('Error'); ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="pull-left">
                                        <h3 class="logo invoice-logo"><?php if(isset($business)){ if(isset($business[0]['business_logo1'])){echo "<img src='".base_url().'assets/images/business/'.$business[0]['business_logo1']."' alt='".$business[0]['business_name']."' class='img-responsive' />";}else{echo "<img src='".base_url().'assets/images/business/'.$business[0]['business_logo']."' alt='".$business[0]['business_name']."' class='img-responsive' />"; }} else {echo 'SalonPK';}?></h3>
                                    </div>
                                    <div class="pull-right">
                                        
                                        <table class="table table1" style="border:none !important;">
                                            <tr>
                                                <td style="border-right:1px solid #f7f7f7; color:#797979; text-align: right; vertical-align: bottom;">Date</td>
                                                <td style="color: #000; font: normal normal 16px/16px arial, serif; vertical-align: middle;"><?php echo date("jS \of F Y"); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border-right:1px solid #f7f7f7; color:#797979; text-align: right">Subcription ID</td>
                                                <td style="color:#000;"><?php if(isset($program_enrollment)){ echo sprintf("%04s",$program_enrollment[0]['id_program_enrollment']);}else{echo '00001';} ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border-right:1px solid #f7f7f7; color:#797979; text-align: right">Contact</td>
                                                <td style="color:#000;">Billing Dept.</td>
                                            </tr>
                                            <tr>
                                                <td style="border-right:1px solid #f7f7f7; color:#797979; text-align: right"></td>
                                                <td style="color:#000;"><?php if(isset($business)){ echo $business[0]['business_email'];}?></td>
                                            </tr>
                                            <tr>
                                                <td style="border-right:1px solid #f7f7f7; color:#797979; text-align: right"></td>
                                                <td style="color:#000;"><?php if(isset($business)){ echo $business[0]['business_phone2'];}?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                
                                <div class="row m-t-40">
                                   
                                        <div class="col-xs-6">

                                        </div>
                                        <div class="col-xs-6">
                                            <span style="color: #000; font: normal normal 16px/40px Roboto, serif;  text-transform: uppercase;"><?php echo $program_enrollment[0]['customer_name']; ?></span><br>
                                            <span style="color: #000; font: normal normal 16px/20px Roboto, serif;  "><?php echo $program_enrollment[0]['customer_address']; ?></span><br>
                                            <span style="color: #000; font: normal normal 12px/40px Roboto, serif;  text-transform: uppercase;"><?php echo $program_enrollment[0]['customer_cell']; ?></span><br>
                                            
                                            <br>
                                        </div>
                                   
                                </div>
                                
                          
                                <div class="row">
                                    <div class="col-md-12">
                                       <span style="font: normal bold 22px/30px arial, serif; color:#000">INVOICE</span>
                                   </div>
                                </div>
                                <div class="row" style=" color:#000;">
                                    <div class="col-md-12">
                                        <p><?php echo $program_enrollment[0]['customer_name'];?>, </p>
                                        <p>Following are your due payment/s : </p>
                                        <div class="table">
                                            <table class="table m-t-10" id="tblservices" style="border-bottom:#f7f7f7 1px solid">
                                                <thead style="color:#000 !important">
                                                    <tr>
                                                        <th class="hidden-xs">#</th>
                                                        <th>Due Date</th>
                                                        <th >Item</th>
                                                        <th >Payment Month</th>
                                                        <th >Branches</th>
                                                        <th >Total Amount Due</th>
                                                       
                                                    </tr>
                                                </thead>
                                                <tbody style="color:#000 !important">
                                                    <?php $x=1; $paid_amount_sum=0; foreach($program_enrollment as $pe){?>
                                                    <tr id="idtr">
                                                            <td class="hidden-xs"><?php echo $x;?></td>
                                                            <td ><?php echo $pe['f_payment_date']; ?></td>
                                                            <td style="text-align: right;"><?php echo number_format($pe['paid_cash']); ?></td>
                                                            <td style="text-align: right;">
                                                                <?php echo number_format($pe['paid_card']); ?>
                                                            </td >
                                                            <td style="text-align: right;"><?php echo number_format($pe['paid_check']); ?></td>
                                                            
                                                            <td style="text-align: right;"><?php if($pe['paid_amount']!==null){echo number_format($pe['paid_amount']); $paid_amount_sum=$paid_amount_sum + $pe['paid_amount'];} else {echo '0';} ?></td>
                                                           
                                                        </tr>
                                                        
                                                    <?php $x++; } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-20" style="color:#000 !important">
                                    <div class="col-xs-8" >
                                        <table class="table1">
                                            <tr>
                                                <td><strong>Course Information:</strong></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><?php echo $program_enrollment[0]['program'];?> : <?php echo $program_enrollment[0]['session_name'];?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">From <?php echo $program_enrollment[0]['f_program_session_start'];?> to <?php echo $program_enrollment[0]['f_program_session_end'];?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-xs-4 " style="color:#000 !important; ">
                                        
                                        <?php $remaining_amount=$program_enrollment[0]['program_price'] - $paid_amount_sum;?>
                                        <table class="table1" style="float:right; font-weight: bold; border:#f7f7f7 solid 1px;">
                                            <tr>
                                                <td style="border:#f7f7f7 solid 1px;" class="text-right m-t-0 ">Amount Paid</td>
                                                <td style="border:#f7f7f7 solid 1px;" class="text-right m-t-0 "><?php echo number_format($paid_amount_sum);?></td>
                                            </tr>
                                            <?php if($remaining_amount>0){?>
                                            <tr>
                                                <td class="text-right m-t-0 " style="border:#f7f7f7 solid 1px;">Balance</td>
                                                <td class="text-right m-t-0 " style="border:#f7f7f7 solid 1px;"><?php echo number_format($remaining_amount);?></td>
                                            </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <p style="padding-left:10px;">Schedule : 
                                            <?php foreach($program_schedule as $days){?>
                                            <?php echo '<b>'.$days['weekdays'].'</b> '.$days['start'].'-'.$days['end'].' | ';?>
                                            <?php } ?>
                                        </p>
                                    </div>
                                </div>
                                <br>
                                <div class="hidden-print">
                                    <div class="pull-right">
                                        <a type="submit" href="<?php echo base_url().'print_enrollment/'.$program_enrollment[0]['id_program_enrollment'] ;?>" class="btn btn-primary waves-effect waves-light" id="btnenrollment"><i class="fa fa-file"></i> Form</a>
                                        <a type="button" data-toggle="modal" data-target="#addpaymentmodal" class="btn btn-success waves-effect waves-light" id="btnpayment"><i class="fa fa-dollar"></i> Add Payment</a>
                                        <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light" id="btnprint"><i class="fa fa-print"></i></a>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- end row -->
        <!--Add Payment Modal-->
        <div id="addpaymentmodal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addpayment" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="addPaymentForm" action="<?php echo base_url("programs_controller/add_payment"); ?>" method="POST">
                        <input type="hidden" name="csrf_test_name" id="payment_csrf" value=""/>
                        <input type="hidden" name="txtenrollmentid" id="txt_enrollment_id" value="<?php echo $program_enrollment[0]['id_program_enrollment'];?>"/>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="custom-width-modalLabel">Add A Payment</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h2>Remaining Amount: <?php echo number_format($remaining_amount,2);?></h2>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txtPaymentDate" class="control-label">Payment Date:</label>
                                        <input id="txtPaymentDate" name="txtPaymentDate" class="form-control" required="required">
                                    </div> 
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txtPaidCash" class="control-label">Paid Cash</label>
                                        <input onchange="calcTotal();" id="txtPaidCash" name="txtPaidCash" class="form-control" value="0.00">
                                    </div> 
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txtPaidCard" class="control-label">Paid Card</label>
                                        <input onchange="calcTotal();" id="txtPaidCard" name="txtPaidCard" class="form-control" value="0.00">
                                    </div> 
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txtPaidCheck" class="control-label">Paid Check</label>
                                        <input onchange="calcTotal();" id="txtPaidCheck" name="txtPaidCheck" class="form-control" value="0.00">
                                    </div> 
                                </div> 
                            </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txtTotalPayment" class="control-label">Total Payment</label>
                                        <input id="txtTotalPayment" name="txtTotalPayment" class="form-control" value="0.00">
                                    </div> 
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txtforthemonth" class="control-label">For Th Month</label>
                                        <select class="form-control" id="forthemonth" name="forthemonth">
                                            <option <?php if(date('F')=='January'){echo "selected='selected'";} ?> value="January">January</option>
                                            <option <?php if(date('F')=='February'){echo "selected='selected'";} ?> value="February">February</option>
                                            <option <?php if(date('F')=='March'){echo "selected='selected'";} ?> value="March">March</option>
                                            <option <?php if(date('F')=='April'){echo "selected='selected'";} ?> value="April">April</option>
                                            <option <?php if(date('F')=='May'){echo "selected='selected'";} ?> value="May">May</option>
                                            <option <?php if(date('F')=='June'){echo "selected='selected'";} ?> value="June">June</option>
                                            <option <?php if(date('F')=='July'){echo "selected='selected'";} ?> value="July">July</option>
                                            <option <?php if(date('F')=='August'){echo "selected='selected'";} ?> value="August">August</option>
                                            <option <?php if(date('F')=='September'){echo "selected='selected'";} ?> value="September">September</option>
                                            <option <?php if(date('F')=='October'){echo "selected='selected'";} ?> value="October">October</option>
                                            <option <?php if(date('F')=='November'){echo "selected='selected'";} ?> value="November">November</option>
                                            <option <?php if(date('F')=='December'){echo "selected='selected'";} ?> value="December">December</option>                                            
                                        </select>
                                    </div> 
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txtfortheyear" class="control-label">Year</label>
                                        <select class="form-control" id="fortheyear" name="fortheyear">
                                            <?php $x=4; $y=date('Y'); for($x<=0; $x--;){ ?>
                                            <option <?php if($y-$x == $y){ echo "selected='selected'";}?> value="<?php echo $y-$x;?>"><?php echo $y-$x;?></option>
                                             <?php } ?>
                                        </select>
                                    </div> 
                                </div> 
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                            <button type="submit" onclick="$('#payment_csrf').val($('#cook').val());" class="btn btn-custom waves-effect waves-light">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<script>
    
 
    $('document').ready(function(){
        $("#txtPaymentDate").datepicker({
            default: today,
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });

    }); 
    
    function calcTotal(){
        var total = parseFloat($("#txtPaidCash").val()) + parseFloat($("#txtPaidCard").val()) + parseFloat($("#txtPaidCheck").val());
        $('#txtTotalPayment').val(total);
        
    }
   

</script>
