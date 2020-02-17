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
                    <form method="get" action="<?php echo base_url(); ?>accounting_controller/paymentadd">
                        <input type="hidden" name="payment_add_csrf" id="voucher_add_csrf" value=""/>
                        <button type="submit" onclick="$('#payment_add_csrf').val($('#cook').val());" class="btn btn-custom waves-effect waves-light" >Add Payment Voucher <span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                    </form>
                </div>
                <h4 class="page-title">Payments (<?php echo $business[0]['business_name'];?>):</h4>
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
                                    <label class="control-label">Date Range</label>
                                </div>
                                <div class="col-lg-4">
                                    <label class="control-label">Supplier</label>
                                </div>
                                <div class="col-lg-2"></div>    
                            </div>
                        </div>
                        <div class="row">
                            <form method="post" action="<?php echo base_url();?>payments">
                                <input type="hidden" name="csrf_test_name" id="payments_csrf" value=""/>
                                <div class="col-lg-3">
                                    <input style="background-color: white;" readonly class="form-control" type="text" name="startdate" id="startdate" value="<?php if(isset($startdate)){echo $startdate;}?>"/>                                
                                </div>
                                <div class="col-lg-3">
                                    <input style="background-color: white;" readonly class="form-control" type="text" name="enddate" id="enddate" value="<?php if(isset($enddate)){echo $enddate;}?>"/>
                                </div>
                                <div class="col-lg-4">
                                    <select class="form-control" id="supplier" name="supplier">
                                        <option value="">All</option>
                                        <?php foreach($suppliers as $supplier){ ?>
                                        <option value="<?php echo $supplier['id_business_supplier']; ?>"><?php echo $supplier['supplier_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-2"><button type="submit" onclick="$('#payments_csrf').val($('#cook').val());" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button></div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="header-title m-t-30 m-b-10">Vouchers:</h4>
                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Voucher ID</th>
                                        <th>Desc</th>
                                        <th>Type</th>
                                        <th>Business Partner</th>
                                        <th>Date</th>
                                        <th>Created By</th>
                                        <th>Cost Center</th>
                                        <th>Account#</th>
                                        <th>Account</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $last=""; $debit=0; $credit=0; foreach($payments as $account_head){ ?>
                                    <tr>
                                        <?php  if($last!==$account_head['id_account_vouchers']){?>
                                            <td style="border-top:1px solid #000"><?php echo $account_head['id_account_vouchers']; ?></td>
                                            <td style="border-top:1px solid #000"><?php echo $account_head['description']; ?></td>
                                            <td style="border-top:1px solid #000"><?php echo $account_head['account_voucher_type']; ?></td>
                                            <td style="border-top:1px solid #000"><?php echo $account_head['business_partner_name']; ?></td>
                                            <td style="border-top:1px solid #000"><?php echo $account_head['voucher_date']; ?></td>
                                            <td style="border-top:1px solid #000"><?php echo $account_head['created_by']; ?></td>
                                            <td style="border-top:1px solid #000"><?php echo $account_head['cost_center_name']; ?></td>
                                            <td style="border-top:1px solid #000" class="text-info"><?php echo $account_head['account_head_number']; ?></td>
                                            <td style="border-top:1px solid #000" class="text-info"><?php echo $account_head['account_head']; ?></td>
                                            <td style="border-top:1px solid #000; text-align: right; font-weight: bold;" class="text-success"><?php if($account_head['debit']>0) echo $account_head['debit']; $debit=$debit+$account_head['debit']; ?></td>
                                            <td style="border-top:1px solid #000; text-align: right; font-weight: bold;" class="text-success"><?php if($account_head['credit']>0)echo $account_head['credit']; $credit=$credit+$account_head['credit'];?></td>
                                            <td style="border-top:1px solid #000" class='noprint'> 
                                                <form method="post" action="<?php echo base_url(); ?>accounting_controller/accountvoucheredit">
                                                    <input type="hidden" name="id_account_vouchers" id="account_voucher_<?php echo $account_head['id_account_vouchers']; ?>" value="<?php echo $account_head['id_account_vouchers']; ?>">
                                                    <input type="hidden" name="csrf_test_name" id="account_voucher_edit_csrf_<?php echo $account_head['id_account_vouchers'];?>" value=""/>
                                                    <button type="submit" onclick="$('#account_voucher_edit_csrf_<?php echo $account_head['id_account_vouchers'];?>').val($('#cook').val());" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button>  
                                                </form>
                                            </td>
                                        <?php } else { ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td ><?php echo $account_head['cost_center_name']; ?></td>
                                            <td class="text-info"><?php echo $account_head['account_head_number']; ?></td>
                                            <td class="text-info"><?php echo $account_head['account_head']; ?></td>
                                            <td class="text-success" style="text-align: right; font-weight: bold;"><?php if($account_head['debit']>0) echo $account_head['debit']; $debit=$debit+$account_head['debit'];?></td>
                                            <td class="text-success" style="text-align: right; font-weight: bold;"><?php if($account_head['credit']>0) echo $account_head['credit']; $credit=$credit+$account_head['credit'];?></td>
                                            <td></td>
                                        <?php } $last=$account_head['id_account_vouchers'];?>
                                    </tr>
                                    <?php }?>
                                </tbody>
                                <tfoot>
                                    <td colspan="9" style="text-align: right; font-weight: bold;">Total</td>
                                    <td style="text-align: right; font-weight: bold;"><?php echo $debit; ?></td>
                                    <td style="text-align: right; font-weight: bold;"><?php echo $credit; ?></td>
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
        payments_list();

    }

    function payments_list(start = null, end = null) {
        var startd = start ? start : startdate.format('YYYY-MM-DD');
        var endd = end ? end : enddate.format('YYYY-MM-DD');
        $("#cog").show();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>accounting_controller/payments',
            data: {startdate: startd, enddate: endd, supplier: $('#supplier').val()},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                var today = new Date('<?php echo date('Y,m,d'); ?>');

                var hhtml = "<tr><th>ID</th><th>Description</th><th>Cost Center</th><th>Business Partner</th><th>Date</th><th>Created By</th><th>Debit</th><th>credit</th><th class='hidden-print noprint'>Action</th></tr>"

                var mhtml = "";
                for (x = 0; x < data.length; x++) {
                    var myd=data[x]['voucher_date'].split("-");
                    var vdate=new Date(myd[2]+','+myd[1]+','+myd[0]);

                    mhtml += '<tr>';
                    mhtml += '<td>' + data[x]['id_account_vouchers']  +'</td>';
                    mhtml += '<td>' + data[x]['description'] + '</td>';
                    mhtml += '<td>' + data[x]['cost_center_name'] + '</td>';
                    mhtml += '<td>' + data[x]['business_partner_name'] + '</td>';
                    mhtml += '<td>' + data[x]['voucher_date'] + '</td>';
                    mhtml += '<td>' + data[x]['created_by'] + '</td>';
                    mhtml += '<td>' + data[x]['debit'] + '</td>';
                    mhtml += '<td>' + data[x]['credit'] + '</td>';
                    mhtml += '<td class="hidden-print noprint"><button style="display:none" id="voucher_acount_id" onclick="editvoucher('+ data[x]['id_account_vouchers'] +');" class="btn btn-icon waves-effect waves-light btn-warning m-b-5"><i class="fa fa-pencil"></i></button>\n\
                <button '+ (vdate < today ? 'style="display:none;"' : '')+' id="voucher_acount_id" onclick="account_voucher_remove('+ data[x]['id_account_vouchers'] +');" class="btn btn-icon waves-effect waves-light btn-danger m-b-5"><i class="fa fa-trash"></i></button></td>';
                    mhtml += '</tr>';
                }
                //console.log(mhtml);
                $("#datatable-buttons").dataTable().fnDestroy();
                $("#datatable-buttons thead").html('');
                $("#datatable-buttons tbody").html('');
                $("#datatable-buttons thead").append(hhtml);
                $("#datatable-buttons tbody").append(mhtml);
                $("#datatable-buttons tfoot").html('');

                $('#datatable-buttons').DataTable({
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

</script>