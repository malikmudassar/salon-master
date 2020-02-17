<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class=" pull-right m-t-15">
                    <button type="button"  onclick="openaddnew();" class="btn btn-custom waves-effect waves-light" >Add A Payment<span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                </div>
                <h4 class="page-title">Staff Account</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="<?php echo base_url() . 'assets/images/staff/'; ?><?php echo $details[0]['staff_image'] ? $details[0]['staff_image'] : "nu.png"; ?>" alt="staff"/>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 class="header-title m-t-0 m-b-10">Name : <?php echo $details[0]['staff_fullname']; ?></h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="header-title m-t-0 m-b-10">Cell : <?php echo $details[0]['staff_cell']; ?></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="header-title m-t-0 m-b-10">Phone 1 : <?php echo $details[0]['staff_phone1']; ?></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="header-title m-t-0 m-b-10">Phone 2 : <?php echo $details[0]['staff_phone2']; ?></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="header-title m-t-0 m-b-10">Address : <?php echo $details[0]['staff_phone2']; ?></h4>
                                </div>
                            </div>                            
                        </div>

                        <div class="col-md-4">

                            <div class="row">
                                <div class="col-md-12" >                            
                                    <h4 class="header-title m-t-10 m-b-10">Remuneration: <?php echo number_format($details[0]['staff_salary'], 2); ?> / month</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        <div class="row" >
            <div class="col-md-12 card-box" >
                <div class="row">
                    <div class="col-md-6 ">
                        <h4 class="header-title m-b-10 m-t-10">Paid Salaries & Commissions:</h4>
                        <table id="tblstaffsalary" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" >
                            <thead>
                                <tr>
                                    <th>Voucher ID</th>
                                    <th>Payment Date</th>
                                    <th>Remarks</th>
                                    <th>Mode</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Amount</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php $totalpayments=0; foreach ($salary as $sal) { ?>
                                    <tr>
                                        <td><?php echo $sal['id']; ?></td>
                                        <td><?php echo $sal['payment_date']; ?></td>
                                        <td><b><?php echo $sal['payment_remarks']; ?></b></td>
                                        <td><?php echo $sal['payment_mode']; ?></td>
                                        <td><?php echo $sal['payment_month']; ?></td>
                                        <td><?php echo $sal['payment_year']; ?></td>
                                        <td style="text-align: right"><b class="text-primary"><?php echo number_format($sal['payment_amount'],2); ?></b></td>
                                        
                                    </tr>
                                <?php $totalpayments+= $sal['payment_amount'];} ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="6" style="text-align: right">Total:</th>
                                    <th style="text-align: right"><b class="text-primary" ><?php echo number_format($totalpayments,2);?></b></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                     <div class="col-md-6">
                        <h4 class="header-title m-b-10 m-t-10">Loan:</h4>
                        <table id="tblstaffloans" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Voucher ID</th>
                                   <th>Payment Date</th>
                                    <th>Remarks</th>
                                    <th>Mode</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $totalpayments=0; foreach ($loan as $sal) { ?>
                                    <tr>
                                        <td><?php echo $sal['id']; ?></td>
                                        <td><?php echo $sal['payment_date']; ?></td>
                                        <td><b><?php echo $sal['payment_remarks']; ?></b></td>
                                        <td><?php echo $sal['payment_mode']; ?></td>
                                        <td><?php echo $sal['payment_month']; ?></td>
                                        <td><?php echo $sal['payment_year']; ?></td>
                                        <td style="text-align: right"><b class="text-primary"><?php echo number_format($sal['payment_amount'],2); ?></b></td>
                                        
                                    </tr>
                                <?php $totalpayments+= $sal['payment_amount'];} ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="6" style="text-align: right">Total:</th>
                                    <th style="text-align: right"><b class="text-primary" ><?php echo number_format($totalpayments,2);?></b></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                   
                </div>
            </div>

        </div>

       
    </div>
</div>
<!--Payments Modal Start-->
<div id="paymentsmodal" class="modal fade in " tabindex="-1" role="dialog" aria-labelledby="paymentsmodal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <div class="modal-title">
                    <div class="col-md-12">
                        <h4 class="modal-title" id="custom-width-modalLabel">Add Payments: </h4>
                    </div>

                </div>
            </div>
            <form id="paymentform">
                <div class="modal-body">
                    <div class="row m-b-10">
                        <div class="col-sm-12">
                            <div class="hidden">
                                <input id="staff_id" name="staff_id" value="<?php echo $details[0]['id_staff']; ?>">
                                <input id="staff_name" name="staff_name" value="<?php echo $details[0]['staff_fullname']; ?>">
                                <input id="staff_salary" name="staff_salary" value="<?php echo $details[0]['staff_salary']; ?>">
                            </div>
                            <div class="row m-b-10">
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback ">
                                        <label class="col-sm-4 control-label">Payment Type</label>
                                        <div class="col-sm-8 ">
                                            <select type="text" onchange="payment_type_change();" id="payment_type" name="payment_type" class="form-control" >
                                                <?php foreach ($payment_types as $payment_type){ ?>
                                                <option pmode="<?php echo $payment_type['payment_mode'];?>" value="<?php echo $payment_type['payment_type']; ?>"><?php echo $payment_type['payment_type'];?></option>
                                                <?php } ?>
                                            </select>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-b-10">
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-4 control-label">Mode</label>
                                        <div class="col-sm-8">
                                            <select type="text" onchange="modechange();" id="payment-mode" name="payment_mode" class="form-control" />
                                            <option value="cash">Cash</option>
                                            <option value="Bank">Bank</option>
                                            </select>    
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <?php if(isset($bank_accounts)){?>
                             <div class="row m-b-10"  id="bankaccount_div">
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback ">
                                        <label class="col-sm-4 control-label" for="bank_account">From Account</label>
                                        <div class="col-sm-8 ">
                                            <select type="text" id="bank_account" name="bank_account_id" class="form-control" >
                                                <?php foreach ($bank_accounts as $bank_account){ ?>
                                                <option value="<?php echo $bank_account['id_account_heads']; ?>"><?php echo $bank_account['account_head_number']."-".$bank_account['account_head'];?></option>
                                                <?php } ?>
                                            </select>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            
                            <!--Salary-->
                            <div class="row m-b-10" id="salary_div">
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-4 control-label">Salary</label>
                                        <div class="col-sm-8">
                                            <input type="number" disabled="disabled" id="salary-amount" name="salary_amount" class="form-control" value="<?php echo $details[0]['staff_salary']; ?>" />
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <!--Deduction-->
                            <div class="row m-b-10" id="deduction_div" >
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-4 control-label text-danger">Deductions</label>
                                        <div class="col-sm-8">
                                            <input type="number" onchange="checkdeduction();" id="deduction-amount" name="deduction_amount" class="form-control text-danger" value="0" />
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <!--Amount-->
                            <div class="row m-b-10">
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-4 control-label">Amount</label>
                                        <div class="col-sm-8">
                                            <input type="number" readonly="readonly" onchange="checkamount();" id="payment-amount" name="payment_amount" class="form-control" value="<?php echo $details[0]['staff_salary']; ?>" />
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            
                            <div class="row m-b-10">
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-4 control-label">Payment Date</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="yyyy-mm-dd" id="payment_date" name="payment_date">
                                                <span class="input-group-addon bg-info b-0 text-white"><i class="ti-calendar"></i></span>
                                            </div><!-- input-group -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-b-10">
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-4 control-label">For the Month</label>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <select class="form-control col-md-4" id="payment_month" name="payment_month">
                                                    <?php $month = $lastmonthyear[0]['Month']; ?>
                                                    <option value="January" <?php
                                                    if ($month === '1') {
                                                        echo "selected";
                                                    }
                                                    ?> >January</option>
                                                    <option value="February" <?php
                                                    if ($month === '2') {
                                                        echo "selected";
                                                    }
                                                    ?>>February</option>
                                                    <option value="March" <?php
                                                            if ($month === '3') {
                                                                echo "selected";
                                                            }
                                                            ?>>March</option>
                                                    <option value="April" <?php
                                                    if ($month === '4') {
                                                        echo "selected";
                                                    }
                                                    ?>>April</option>
                                                    <option value="May" <?php
                                                    if ($month === '5') {
                                                        echo "selected";
                                                    }
                                                    ?>>May</option>
                                                    <option value="June" <?php
                                                            if ($month === '6') {
                                                                echo "selected";
                                                            }
                                                            ?>>June</option>
                                                    <option value="July" <?php
                                                    if ($month === '7') {
                                                        echo "selected";
                                                    }
                                                    ?>>July</option>
                                                    <option value="August" <?php
                                                    if ($month === '8') {
                                                        echo "selected";
                                                    }
                                                    ?>>August</option>
                                                    <option value="September" <?php
                                                    if ($month === '9') {
                                                        echo "selected";
                                                    }
                                                    ?>>September</option>
                                                    <option value="October" <?php
                                                    if ($month === '10') {
                                                        echo "selected";
                                                    }
                                                    ?>>October</option>
                                                    <option value="November" <?php
                                                    if ($month === '11') {
                                                        echo "selected";
                                                    }
                                                    ?>>November</option>
                                                    <option value="December" <?php
                                                    if ($month === '12') {
                                                        echo "selected";
                                                    }
                                                    ?>>December</option>
                                                </select>
                                            </div><!-- input-group -->
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <select class="form-control col-md-4" id="payment_year" name="payment_year">
                                                    <?php $year=$lastmonthyear[0]['Year']; for($x=1; $x<=4; $x++){?>
                                                    <option value="<?php echo $year;?>" <?php if($year===$lastmonthyear[0]['Year']){ echo "selected";} ?>><?php echo $year;?></option>
                                                    <?php $year=$year-1; }?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row m-b-10">
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-4 control-label">Remarks</label>
                                        <div class="col-sm-8">
                                            <textarea id="payment_remarks" name="payment_remarks" class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div> 
                            </div>

                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" onclick="updatepayment();" class="btn btn-info waves-effect waves-light">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Payments Modal End-->
<script>

    $(document).ready(function () {

        jQuery.extend( jQuery.fn.dataTableExt.oSort, {
            "formatted-num-pre": function ( a ) {
                a = (a === "-" || a === "") ? 0 : a.replace( /[^\d\-\.]/g, "" );
                return parseFloat( a );
            },

            "formatted-num-asc": function ( a, b ) {
                return a - b;
            },

            "formatted-num-desc": function ( a, b ) {
                return b - a;
            }
        } );
        
        jQuery('#payment_date').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
            
        });

        jQuery('#payment_date').datepicker("update", new Date());
       

        $('#tblstaffsalary').DataTable({
            dom: "Bfrtlip",
            fixedHeader: {header: true},
            buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                    extend: "excel",
                    className: "btn-sm"
                }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
            responsive: !0
        });

        $('#tblstaffloans').DataTable({
            dom: "Bfrtlip",
            fixedHeader: {header: true},
            buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                    extend: "excel",
                    className: "btn-sm"
                }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
            responsive: !0
        });

    });

    function openaddnew() {

        $("#paymentsmodal").modal('show');
    }


    function updatepayment() {
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>staff_controller/add_payment',
            data: $("#paymentform").serialize(),
            success: function (data) {
                var result = data.split("|");
                if (result[0] === "success") {
                    addnewaccountvoucher();
                    $("#paymentsmodal").modal("hide");
                    toastr.success('Payment added!', 'Great!');
                    
                    //location.reload();
                } else {
                    swal({
                        title: "Error",
                        text: result[1],
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
                }

            }
        });
        
        
        
    }
    
    
    function addnewaccountvoucher(){
                
                var debit_amounts='';
                if($("#payment_type option:selected").val()==='Loan'){
                    debit_amounts='4|'+ $('#payment-amount').val();
                } else {
                    debit_amounts='32|'+ $('#payment-amount').val();
                }   
                var credit_amounts='';
                if($("#payment-mode option:selected").val()==='Bank'){ 
                    credit_amounts = $('#bank_account').val()+'|'+ $('#payment-amount').val();
                } else {
                    credit_amounts = '2|'+ $('#payment-amount').val();
                }
                
                var discription = ''; 
                if(parseInt($('#payment-amount').val())>=0){
                    discription = $("#payment_type option:selected").val() + ' paid to ' + $('#staff_name').val() + ', for the month of '+ $("#payment_month").val() + ' with deduction of '+$("#deduction-amount").val()+'. '+$("#payment_remarks").val();
                } else {
                    discription = $("#payment_type option:selected").val() + ' returned by ' + $('#staff_name').val() + ', in the month of '+ $("#payment_month").val() + ' with deduction of '+$("#deduction-amount").val()+'. '+$("#payment_remarks").val();
                }
                var debit_accounts=[];
                var credit_accounts=[];
                debit_accounts.push(debit_amounts);
                credit_accounts.push(credit_amounts);
                
               
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url();?>accounting_controller/insert_account_voucher',
                    data: {
                        description: discription,
                        voucher_amount: $('#payment-amount').val(),                        
                        voucher_date: $('#payment_date').val(),
                        business_partner:3,
                        business_partner_id: $("#staff_id").val(),
                        business_partner_name: $("#staff_name").val(),
                        cost_center:1,
                        cost_center_name:'Outlet',
                        debit_accounts: debit_accounts,
                        credit_accounts: credit_accounts,
                        voucher_type: 1,
                        payment_mode: $("#payment-mode").val()
                        
                    },
                    success: function(data){
                        toastr.success('Account Voucher Added!', 'Done!');
                        location.reload();
                    }
                });
            }
    
    function payment_type_change(){
            $("#payment-amount").val("");
            
            if($("#payment_type option:selected").val() == "Salary" && $("#staff_salary").val()!==""){
                $("#payment-amount").val($("#staff_salary").val());
                $("#payment-amount").attr('readonly','readonly');
                $("#salary_div").show();
                $("#deduction_div").show();
                $("#deduction-amount").val("0");
            
            } else {
                $("#payment-amount").val("");                
                $("#payment-amount").removeAttr('readonly','readonly');
                $("#salary_div").hide();
                $("#deduction_div").hide();
                $("#deduction-amount").val("0");
            }
            
        }
    
    function checkdeduction(){
        
        $("#payment-amount").val(parseInt($("#salary-amount").val())- parseInt($("#deduction-amount").val()));
        
    }
    function modechange(){
        if($("#payment-mode option:selected").val()== "Bank"){
            $("#bankaccount_div").show();
        } else {
            $("#bankaccount_div").hide();
        }
    }
        
</script>