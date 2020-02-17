<style>
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
                <h4 class="page-title">Edit Invoice (<?php echo $invoice->invoice_number;?>):</h4>
            </div>
        </div>
        <?php if ($this->session->flashdata('Success') && $this->session->flashdata('Success') != ""){  ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong> <?php echo $this->session->flashdata('Success'); ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if ($this->session->flashdata('Error') && $this->session->flashdata('Error') != ""){  ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('Error'); ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="row" id="divselection">
            <div class="col-md-12">
                <div class="card-box ">
                    <h4 class="header-title m-t-0 m-b-30"></h4>
                    <form method="post" action="<?php echo base_url();?>superuser_controller/update_invoice">
                        <input type="hidden" name="csrf_test_name" id="invoice_csrf" value=""/>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">ID</label>
                                    <input class="form-control" readonly="readonly" name="id_invoice" value = "<?php echo $invoice->id_invoice;?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Invoice Date</label>
                                    <input class="form-control" name="invoice_date" value = "<?php echo $invoice->invoice_date;?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Invoice Number</label>
                                    <input class="form-control" readonly="readonly" name="invoice_number" value = "<?php echo $invoice->invoice_number;?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Invoice Type</label>
                                    <input class="form-control" readonly="readonly" name="invoice_type" value = "<?php echo $invoice->invoice_type;?>">
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-md-3">
                                    <label class="form-label">Invoice Status</label>
                                    <select class="form-control" name="invoice_status">
                                        <option <?php if($invoice->invoice_status=='valid'){echo "selected='selected'";}?> value="valid">valid</option>
                                        <option <?php if($invoice->invoice_status=='cancelled'){echo "selected='selected'";}?> value="cancelled">cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Customer ID</label>
                                    <input class="form-control" name="customer_id" value = "<?php echo $invoice->customer_id;?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Customer Name</label>
                                    <input class="form-control" name="customer_name" value = "<?php echo $invoice->customer_name;?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Customer Cell</label>
                                    <input class="form-control" name="customer_cell" value = "<?php echo $invoice->customer_cell;?>">
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-md-3">
                                    <label class="form-label">Invoice Reference (Recovery)</label>
                                    <input class="form-control" name="reference_invoice_number" value = "<?php echo $invoice->reference_invoice_number;?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Visit ID</label>
                                    <input readonly="readonly" class="form-control" name="visit_id" value = "<?php echo $invoice->visit_id;?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Visit Time</label>
                                    <input readonly="readonly" class="form-control" name="visit_time" value = "<?php echo $invoice->visit_time;?>">
                                </div>
                                
                            </div>
                            <hr>
                            <div class="row m-t-20">
                                <div class="col-md-12">
                                    <h3>Charges:</h3>
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-md-2">
                                    <label class="form-label">Sub Total</label>
                                    <input class="form-control" name="sub_total" value = "<?php echo $invoice->sub_total;?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Gross Amount</label>
                                    <input class="form-control" name="gross_amount" value = "<?php echo $invoice->gross_amount;?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Tax</label>
                                    <input class="form-control" name="tax_total" value = "<?php echo $invoice->tax_total;?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">CC Charge</label>
                                    <input class="form-control" name="cc_charge" value = "<?php echo $invoice->cc_charge;?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Discount</label>
                                    <input class="form-control" name="discount" value = "<?php echo $invoice->discount;?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">CC Tip</label>
                                    <input class="form-control" name="cctip" value = "<?php echo $invoice->cctip;?>">
                                </div>

                            </div>
                            <div class="row m-t-20">
                                <div class="col-md-2">
                                    <label class="form-label">Other Charges</label>
                                    <input class="form-control" name="other_charges" value = "<?php echo $invoice->other_charges;?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Net Amount</label>
                                    <input class="form-control" name="net_amount" value = "<?php echo $invoice->net_amount;?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Advance Amount</label>
                                    <input class="form-control" name="advance_amount" value = "<?php echo $invoice->advance_amount;?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Advance Instrument</label>
                                    <input class="form-control" name="advance_inst" value = "<?php echo $invoice->advance_inst;?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Total Payable</label>
                                    <input class="form-control" name="total_payable" value = "<?php echo $invoice->total_payable;?>">
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>
                            <hr>
                            <div class="row m-t-20">
                                <div class="col-md-12">
                                    <h3>Payment:</h3>
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-md-3">
                                    <label class="form-label">Retained Used</label>
                                    <select class="form-control" name="retained_used" >
                                        <option <?php if($invoice->retained_used=='Yes'){echo "selected='selected'";}?> value="Yes">Yes</option>
                                        <option <?php if($invoice->retained_used=='No'){echo "selected='selected'";}?> value="No">No</option>
                                    </select>
                                    
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Retained Amount Used</label>
                                    <input class="form-control" name="retained_amount_used" value = "<?php echo $invoice->retained_amount_used;?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Loyalty Amount Used</label>
                                    <input class="form-control" name="loyalty_used" value = "<?php echo $invoice->loyalty_used;?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Payment Mode</label>
                                    <select class="form-control" name="payment_mode" >
                                        <option <?php if($invoice->payment_mode=='Cash'){echo "selected='selected'";}?> value="Cash">Cash</option>
                                        <option <?php if($invoice->payment_mode=='Card'){echo "selected='selected'";}?> value="Card">Card</option>
                                        <option <?php if($invoice->payment_mode=='Mixed'){echo "selected='selected'";}?> value="Mixed">Mixed</option>
                                        <option <?php if($invoice->payment_mode=='Voucher'){echo "selected='selected'";}?> value="Voucher">Voucher</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row m-t-20">
                                
                                <div class="col-md-2">
                                    <label class="form-label text-success">Total Paid Amount</label>
                                    <input class="form-control" name="paid_amount" value = "<?php echo $invoice->paid_amount;?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Paid Cash</label>
                                    <input class="form-control" name="paid_cash" value = "<?php echo $invoice->paid_cash;?>">
                                </div>
                                 <div class="col-md-2">
                                    <label class="form-label">Paid Card</label>
                                    <input class="form-control" name="paid_card" value = "<?php echo $invoice->paid_card;?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Paid Check</label>
                                    <input class="form-control" name="paid_check" value = "<?php echo $invoice->paid_check;?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Paid Voucher</label>
                                    <input class="form-control" name="paid_voucher" value = "<?php echo $invoice->paid_voucher;?>">
                                </div>
                                 <div class="col-md-2">
                                    <label class="form-label text-danger">Balance</label>
                                    <input class="form-control" name="balance" value = "<?php echo $invoice->balance;?>">
                                </div>
                                
                            </div>
                            <hr>
                            <div class="row m-t-20">
                                <div class="col-md-12">
                                    <h3>Loyalty & Retained:</h3>
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <label class="form-label">Loyalty Earned</label>
                                    <input class="form-control" name="loyalty_earned" value = "<?php echo $invoice->loyalty_earned;?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Amount Retained (General Advance)</label>
                                    <input class="form-control" name="retained_amount" value = "<?php echo $invoice->retained_amount;?>">
                                </div>
                            </div>
                            
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <div class="btn-group pull-right m-t-15">
                                        <a href="<?php echo base_url();?>super_invoices" class="btn waves-effect waves-light btn-default m-t-20">Back</a>
                                        <button onclick="$('#invoice_csrf').val($('#cook').val());" class="btn waves-effect waves-light btn-pink m-t-20">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </div>
</div>

<script>
    $(document).ready(function() {

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