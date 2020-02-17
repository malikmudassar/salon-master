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
</style>
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    <button type="button"  onclick="openaddnew();" class="btn btn-custom waves-effect waves-light" >Create New <span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                </div>
                <h4 class="page-title">Petty Cash Expenses:</h4>
            </div>
        </div>

        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <!--<h4 class="header-title m-t-0 m-b-30">Selection:</h4>-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">&nbsp;</div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">Select Dates</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <div id="reportrange" class="inner-addon left-addon">
                                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                <input style="background-color: white;" readonly class="form-control" type="text" name="range" id="range" />
                                                <input type="hidden" name="rangehidden" id="rangehidden" value="1" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">&nbsp;</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" > 
                                            <button type="button" onclick="runreport();" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><i id="cog" class="fa fa-spin fa-cog" style="display:none; font-size:26px;width: auto;margin-right: 10px;"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>
                    <table id="tblreport" class="table table-striped table-bordered dt-responsive nowrap record" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Ready</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td>Run Orders</td>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

        <!--Add Product Modal-->
        <div id="addvoucher" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addvoucher" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new Expense Voucher</h4>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="addamount" class="control-label">Amount</label>
                                            <input class="form-control" name="addamount" id="addamount" />
                                        </div> 
                                    </div> 
                                </div>
                                
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="adddate" class="control-label">Date</label>
                                            <input type="text" class="form-control" placeholder="Date" id="adddate" name="adddate">
                                        </div> 
                                    </div> 
                                </div>

                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="adddescription" class="control-label">Description</label>
                                    <textarea class="form-control" name="adddescription" id="adddescription"></textarea>
                                </div> 
                            </div> 
                        </div>
                         <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="debit_account_head" class="control-label">Expense Type</label>
                                    <select name="debit_account_head" id="debit_account_head" class="form-control">
                                        <?php foreach($expense_accounts as $ah){ 
                                         
                                                ?>
                                        
                                        <option value="<?php echo $ah['id_account_heads']; ?>"><?php echo $ah['account_head']; ?></option>
                                        
                                        <?php 
                                        
                                       
                                        
                                            }?>
                                    </select>
                                </div>
                            </div>
                             <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="credit_account_head" class="control-label">Incurred From</label>
                                    <select name="credit_account_head" id="credit_account_head" class="form-control">
                                       <?php foreach($cash_account as $ah){ ?>
                                        <option value="<?php echo $ah['id_account_heads']; ?>"><?php echo $ah['account_head']; ?></option>
                                       <?php }?>
                                    </select>
                                </div>
                            </div>
                             <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="supplier" class="control-label text-danger">Supplier</label>
                                    <select name="supplier" id="supplier" class="form-control">
                                        <?php foreach($suppliers as $supplier){ ?>
                                        <option <?php if(strtolower($supplier['supplier_name']) =='other'){echo 'selected="selected" ';} echo ' value="'.$supplier['id_business_supplier'].'"'; ?>><?php echo $supplier['supplier_name'].' '.$supplier['contact_person']; ?></option>
                                       <?php }?>
                                    </select>
                                </div>
                            </div>
                         </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="addnew();" type="button" class="btn btn-custom waves-effect waves-light orderloader"><span>Save</span></button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Product Modal-->
        
        <!--Edit Account Voucher Start-->
        <div id="editvoucher" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editvoucher" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit a Voucher</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="editdescription" class="control-label">Description</label>
                                    <textarea class="form-control" name="editdescription" id="editdescription"></textarea>
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="editamount" class="control-label">Amount</label>
                                            <input class="form-control" name="editamount" id="editamount" />
                                        </div> 
                                    </div> 
                                </div>
                                
                                <div class="row hidden">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="editstatus" class="control-label">Status</label>
                                            <select name="editstatus" id="editstatus" class="form-control">
                                                <option value="Active">Active</option>
                                                <option value="InProcess">In Process</option>
                                                <option value="Cancelled">Cancelled</option>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="editdate" class="control-label">Date</label>
                                            <input type="text" class="form-control" placeholder="Date" id="editdate" name="editdate">
                                        </div> 
                                    </div> 
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="editaccountvoucherid" id="editaccountvoucherid" />
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="updatevoucher();" type="button" class="btn btn-custom waves-effect waves-light orderloader"><span>Save</span></button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--Edit Account Voucher End-->

        <script type="text/javascript">

            var startdate = '';
            var enddate = '';
            $(document).ready(function() {
                //var cl = $('.daterangepicker').find('.ranges li:eq(6)').addClass('active')
                //console.log(cl);
                <?php
                //$month_ini = new DateTime("first day of last month");
                //$month_end = new DateTime("last day of last month");

                $query_date = date('Y-m-d');
                // First day of the month.
                $month_ini = date('Y-m-d', strtotime($query_date));
                // Last day of the month.
                $month_end = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m"), date("d")+1, date("Y")));
                ?>
                var startmonth = '<?php echo date('F j, Y', strtotime($month_ini)); //->format('F j, Y');    ?>';
                var endmonth = '<?php echo date('F j, Y', strtotime($month_end)); //->format('F j, Y');    ?>';
                $('#reportrange input').val(startmonth + ' - ' + endmonth);
                voucher_list('<?php echo $month_ini; //->format('Y-m-d');    ?>', '<?php echo $month_end; //->format('Y-m-d');    ?>');
                //$('[data-toggle="tooltip"]').tooltip();


                $('#tblreport').DataTable({
                    dom: "Bfrtlip",
                    buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                            extend: "excel",
                            className: "btn-sm"
                        }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
                    responsive: !0
                });

                //$('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

                $('#reportrange').daterangepicker({
                    //format: 'MM/DD/YYYY',
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment(),
                    minDate: '01/01/2012',
                    maxDate: '12/31/2020',
//                    dateLimit: {
//                        days: 60
//                    },
                    showDropdowns: true,
                    showWeekNumbers: true,
                    timePicker: false,
                    timePickerIncrement: 1,
                    timePicker12Hour: true,
                    ranges: {
                        'Today': [moment(), moment().add(1, 'days')],
                        'Yesterday': [moment().subtract(1, 'days'), moment()],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment().add(1, 'days')],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment().add(1, 'days')],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    opens: 'left',
                    drops: 'down',
                    buttonClasses: ['btn', 'btn-sm'],
                    applyClass: 'btn-success',
                    cancelClass: 'btn-default',
                    separator: ' to ',
                    locale: {
                        applyLabel: 'Submit',
                        cancelLabel: 'Cancel',
                        fromLabel: 'From',
                        toLabel: 'To',
                        customRangeLabel: 'Custom',
                        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                        firstDay: 1
                    }
                }, function(start, end, label) {
                    console.log(start.toISOString(), end.toISOString(), label);
                    startdate = start;
                    enddate = end;
                    //$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    $('#reportrange input').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                });



                $(".vertical-spin").TouchSpin({
                    verticalbuttons: true,
                    buttondown_class: "btn btn-primary",
                    buttonup_class: "btn btn-primary",
                    verticalupclass: 'ti-plus',
                    verticaldownclass: 'ti-minus'
                });
                var vspinTrue = $(".vertical-spin").TouchSpin({
                    verticalbuttons: true
                });
                if (vspinTrue) {
                    $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
                }

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

                $('#adddate').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy-mm-dd'
                });

                $('#editdate').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy-mm-dd'
                });

            });
            //TableManageButtons.init();

            function runreport() {
                //var reportname = $('#selectreport').val();
                //console.log(reportname);
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
                //console.log(startdate);
                console.log(startdate.format('YYYY-MM-DD') + ' ' + enddate.format('YYYY-MM-DD'));

                //if (reportname === 'purchase_order') {
                voucher_list();
                //}

            }

            function voucher_list(start = null, end = null) {
                var startd = start ? start : startdate.format('YYYY-MM-DD');
                var endd = end ? end : enddate.format('YYYY-MM-DD');
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'expense_controller/daily_expense_list_get',
                    data: {startdate: startd, enddate: endd},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        var today = new Date('<?php echo date('Y,m,d'); ?>');
                        
                        var hhtml = "<tr><th>ID</th><th>Description</th><th>Account</th><th>Expense Amount</th><th>Expense status</th><th>Expense Date</th><th>Created by</th><th class='hidden-print noprint'>Action</th></tr>"
                        var totalexp=0;
                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            
                            totalexp=totalexp+parseFloat(data[x]['debit']);
                            var myd=data[x]['voucher_date'].split("-");
                            var vdate=new Date(myd[2]+','+myd[1]+','+myd[0]);
                            
                            mhtml += '<tr>';
                            mhtml += '<td>' + data[x]['id_account_vouchers']  +'</td>';
                            mhtml += '<td>' + data[x]['description'] + '</td>';
                            mhtml += '<td>' + data[x]['account_head'] + '</td>';
                            mhtml += '<td style="text-align:right; ">' + data[x]['debit'] + '</td>';
                            mhtml += '<td>' + data[x]['voucher_status'] + '</td>';
                            mhtml += '<td>' + data[x]['voucher_date'] + '</td>';
                            mhtml += '<td>' + data[x]['created_by'] + '</td>';
                            mhtml += '<td class="hidden-print noprint"><button style="display:none" id="voucher_acount_id" onclick="editvoucher('+ data[x]['id_account_vouchers'] +');" class="btn btn-icon waves-effect waves-light btn-warning m-b-5"><i class="fa fa-pencil"></i></button>\n\
                            <button '+ (vdate < today ? 'style="display:none;"' : '')+' id="voucher_acount_id" onclick="account_voucher_remove('+ data[x]['id_account_vouchers'] +');" class="btn btn-icon waves-effect waves-light btn-danger m-b-5"><i class="fa fa-trash"></i></button></td>';
                            mhtml += '</tr>';
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").html('<tr><td colspan="3" style="text-align:right; font-weight:bold">Total</td><td style="text-align:right; font-weight:bold">'+totalexp+'</td><td colspan="4"></td></tr>');

                        $('#tblreport').DataTable({
                            dom: "Bfrtlip",
                            fixedHeader: {header: true},
                            buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                                    extend: "excel",
                                    className: "btn-sm"
                                }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
                            responsive: !0
                        });
                        $("#cog").hide();

                    }
                });
            }
            
            function account_voucher_remove(id_account_voucher){
                if(id_account_voucher){
                    swal({
                        title: "Are you sure?",
                        text: "You want to remove this voucher!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: 'btn-warning',
                        confirmButtonText: "Yes, remove it!",
                        closeOnConfirm: true
                    }, function (){
                        $.ajax({
                            type: 'POST',
                            url: 'expense_controller/account_voucher_cancelled',
                            data: {id_account_voucher: id_account_voucher},
                            success: function(data) {
                                var result = data.split("|");

                                if (result[0] === "success") {
                                    swal("Deleted!", "Voucher has been removed.", "success");
                                    location.reload();
                                } else {
                                    swal("Error!", "Voucher was not removed!.", "error");
                                }
                            } 
                        });
                    });
                }
            }


            function openaddnew() {
                $("#addvoucher").modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
            }
            
            function addnew(){
                
                
                
                var debit_amounts=$("#debit_account_head").val() +'|'+ $('#addamount').val();
                var credit_amounts=$("#credit_account_head").val() +'|'+ $('#addamount').val();
                var debit_accounts=[];
                var credit_accounts=[];
                debit_accounts.push(debit_amounts);
                credit_accounts.push(credit_amounts);
                
               
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url();?>accounting_controller/insert_account_voucher',
                    data: {
                        description: $('#adddescription').val(),
                        voucher_amount: $('#addamount').val(),
                        
                        voucher_date: $('#adddate').val(),
                        business_partner:2,
                        business_partner_id: $("#supplier option:selected").val(),
                        business_partner_name: $("#supplier option:selected").text(),
                        cost_center:1,
                        cost_center_name:'Outlet',
                        debit_accounts: debit_accounts,
                        credit_accounts: credit_accounts,
                        voucher_type: 1,
                        payment_mode: 'Cash'
                        
                    },
                    success: function(data){
                        var result = data.split("|");
                        if (result[0] === "success") {
                            toastr.success('Account Voucher Added!', 'Done!');
                            location.reload();
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
            
            function editvoucher(idaccountvoucher){
                $('#editaccountvoucherid').val(idaccountvoucher);
                if(idaccountvoucher){
                    $.ajax({
                    type: 'POST',
                    url: 'expense_controller/edit_account_voucher',
                    data: {id_account_vouchers: idaccountvoucher},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        $('#editdescription').val(data.description);
                        $('#editamount').val(data.voucher_amount);
                        $('#editstatus').val(data.voucher_status);
                        $('#editdate').val(data.voucher_date);
                        $("#editvoucher").modal({
                            backdrop: 'static',
                            keyboard: false,
                            show: true
                        });
                    }
                });
                }
            }
            
            function updatevoucher(){
                $.ajax({
                    type: 'POST',
                    url: 'expense_controller/update_account_voucher',
                    data: {
                        id_account_vouchers: $('#editaccountvoucherid').val(), 
                        description: $('#editdescription').val(),
                        voucher_amount: $('#editamount').val(),
                        voucher_status: $('#editstatus').val(),
                        voucher_date: $('#editdate').val()
                    },
                    success: function(data){
                        toastr.success('Account Voucher Updated!', 'Done!');
                        location.reload();
                    }
                });
            }

        </script>
