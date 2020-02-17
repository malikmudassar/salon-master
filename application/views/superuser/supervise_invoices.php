<style>
    table.dataTable tr.group td{font-weight:bold;background-color:#e0e0e0}

    table.dataTable tr.group,
    tr.group:hover {
        background-color: #ddd !important;
    }

</style>

<div class="wrapper">
    <div class="container-full">

        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box m-t-20">
                    <!-- Page-Title -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="pull-left" >
                                        <h3 class="logo invoice-logo"><?php if (isset($business)) {
                                            echo "<img src='" . base_url() . 'assets/images/business/' . $business[0]['business_logo'] . "' alt='" . $business[0]['business_name'] . "' class='img-responsive' />";
                                        } else {
                                            echo 'SkedWise';
                                        } ?></h3>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class=" m-t-20" >
                                        <div class="col-md-6 hidden-print m-t-20">
                                            <form method="POST" action='<?php echo base_url(); ?>super_invoices'>
                                                <input type="hidden" name="csrf_test_name" id="supervise_invoice_csrf" value=""/>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control inline m-r-5"  placeholder="mm/dd/yyyy" name="calendar_date" id="datepicker-autoclose">
                                                </div>
                                                <div class="col-md-3">
                                                    <button type='submit' onclick="$('#supervise_invoice_csrf').val($('#cook').val());" class="btn btn-pink btn-bordred waves-effect waves-light m-b-5">Run</button>
                                                </div>
                                            </form>
                                        </div>

                                        
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Invoices Created On : <?php echo $date;?></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="datatable-buttons" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Invoice ID</th>
                                        <th>Visit ID</th>
                                        <th>Invoice Number</th>
                                        <th>Reference Number</th>
                                        <th>Invoice Type</th>
                                        <th>Customer ID</th>
                                        <th>Customer Name</th>
                                        <th>Visit Time</th>
                                        
                                        <th>Invoice Date</th>
                                        <th>Status</th>
                                        <th>Net Total</th>
                                        <th>Total Payable</th>
                                        <th>Paid</th>
                                        <th>Balance</th>
                                        <th>Mode</th>
                                        <th>Cash</th>
                                        <th>Card</th>
                                        <th>Check</th>
                                        <th>Voucher</th>
                                        

                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($invoices as $invoice) { ?>
                                    <tr>
                                        <td class='noprint'> 
                                            <form method="POST" action="<?php echo base_url(); ?>super_edit_invoice" >
                                                <input type="hidden" name="id_invoice" id="id_invoice_<?php echo $invoice['id_invoice']; ?>" value="<?php echo $invoice['id_invoice']; ?>">
                                                <input type="hidden" name="csrf_test_name" id="<?php echo $invoice['id_invoice'];?>" value="0"/>
                                                <button onclick="$('#<?php echo $invoice['id_invoice'];?>').val($('#cook').val());" class="btn btn-icon waves-effect waves-light btn-warning m-b-5"> <i class="fa fa-pencil"></i> </button>  
                                            </form>
                                        </td>
                                        <td><?php echo $invoice['id_invoice']; ?></td>
                                        <td><strong><?php echo $invoice['visit_id']; ?></strong></td>
                                        <td><?php echo $invoice['invoice_number']; ?></td>
                                        <td class="text-danger"><?php echo $invoice['reference_invoice_number']; if($invoice['reference_invoice_number']!==''){echo ' Recovery ';} ?></td>
                                        <td><?php echo $invoice['invoice_type']; ?></td>
                                        <td><?php echo $invoice['customer_id']; ?></td>
                                        <td><?php echo $invoice['customer_name']; ?></td>
                                        <td><?php echo $invoice['visit_time']; ?></td>
                                        
                                        <td><?php echo $invoice['invoice_date']; ?></td>
                                        <td class="<?php if($invoice['invoice_status']=='valid'){echo 'text-info';}else {echo 'text-danger';}?>"><strong><?php echo $invoice['invoice_status']; ?></strong></td>
                                        <td class="text-success"><?php echo $invoice['net_amount']; ?></td>
                                        <td class="text-success"><?php echo $invoice['total_payable']; ?></td>
                                        <td><strong><?php echo $invoice['paid_amount']; ?></strong></td>
                                        <td class="text-danger"><strong><?php echo $invoice['balance']; ?></strong></td>
                                        <td><?php echo $invoice['payment_mode']; ?></td>
                                        <td><?php echo $invoice['paid_cash']; ?></td>
                                        <td><?php echo $invoice['paid_card']; ?></td>
                                        <td><?php echo $invoice['paid_check']; ?></td>
                                        <td><?php echo $invoice['paid_voucher']; ?></td>
                                        
                                        
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>

<script>
    $(document).ready(function () {

        $('#datepicker-autoclose').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });


       $('#datatable-buttons').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "stateSave": true,
            "dom": "Bfrtlip",
            "buttons": [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"}, {
                    extend: "excel",
                    className: "btn-sm btn-warning btn-trans"
                }, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}],
            "responsive": !0
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

        $(".numeric").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    });

</script>