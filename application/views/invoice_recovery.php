        <div class="wrapper">
            <div class="container">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        
                        <h4 class="page-title">Recovery Invoices</h4>
                    </div>
                </div>
                
                 <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                            <table id="tblinvoice" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Invoice #</th>
                                        <th>VisitTime</th>
                                        <th>Invoice Date</th>
                                        <th>Customer</th>
                                        <th>Cell</th>
                                        <th>Balance</th>
                                        <th>Sub Total</th>
                                        <th>Advance</th>
                                        <th>Discount</th>
                                        <th>Gross Amount</th>
                                        <th>Taxes</th>
                                        <th>Net Amount</th>
                                        <th>Type</th>
                                        <th>Payment Mode</th>
                                        
                                        <th>Instrument</th>
                                        <th>Branch</th>
                                        <th>Remarks</th>
                                        <th>Recover</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($invoices as $invoice){?>
                                    <tr invoice_id="<?php echo $invoice['id_invoice']; ?>">
                                        <td><?php echo $invoice['id_invoice']; ?></td>
                                        <td>#<?php echo $invoice['invoice_number']; ?></td>
                                        <td><?php echo $invoice['visit_time']; ?></td>
                                        <td><?php echo $invoice['invoice_date']; ?></td>
                                        <td class="text-custom"><?php echo $invoice['customer_name']; ?></td>
                                        <td class="text-custom">
                                            <?php 
                                                if( $this->session->userdata('hide_cell') && $this->session->userdata('hide_cell') == "No"){
                                                    echo $invoice['customer_cell']; 
                                                } 
                                            ?>
                                        
                                        </td>
                                        <td class="text-danger"><?php echo $invoice['balance']; ?></td>
                                        <td><?php echo $invoice['sub_total']; ?></td>
                                        <td><?php echo $invoice['advance_amount']; ?></td>
                                        <td><?php echo $invoice['discount']; ?></td>
                                        <td><?php echo $invoice['gross_amount']; ?></td>
                                        <td><?php echo $invoice['tax_total']; ?></td>
                                        <td><?php echo $invoice['net_amount']; ?></td>
                                        <td><?php echo $invoice['invoice_type']; ?></td>
                                        <td><?php echo $invoice['payment_mode']; ?></td>
                                        <td><?php echo $invoice['instrument_number']; ?></td>
                                        <td><?php echo $invoice['business_name']; ?></td>
                                        <td><?php echo $invoice['remarks']; ?></td>
                                        <td>
                                            <a target="_blank" href="<?php if($invoice['invoice_type']=="service"){
                                                echo base_url().'open_recovery_invoice/'.$invoice['id_invoice'].'/'.$invoice['visit_id']; 
                                            } elseif($invoice['invoice_type']=="sale") {
                                                echo base_url().'open_recovery_order_invoice/'.$invoice['id_invoice'].'/'.$invoice['visit_id']; 
                                            } ?>" class="btn btn-xs btn-default btn-bordred waves-effect waves-light m-b-5"> <span>Recover</span> </a>
                                            <a href="javascript:void(0);" onclick="openBadDebts(<?php echo $invoice['id_invoice']; ?>);" class="btn btn-bordred btn-xs btn-default waves-effect waves-light m-b-5"> <span>Bad Debts</span> </a>
                                        </td>
                                        <td>
                                            <a target="_blank" href="<?php if($invoice['invoice_type']=="service"){
                                                echo base_url().'existinginvoice/'.$invoice['id_invoice']; 
                                            } elseif($invoice['invoice_type']=="sale") {
                                                echo base_url().'existingorderinvoice/'.$invoice['id_invoice']; 
                                            } ?>" class="btn btn-xs btn-warning waves-effect waves-light m-b-5"> <i class="fa fa-rocket m-r-5"></i> <span>Open</span> </a>
                                        </td>
                                    </tr>
                                    
                                    <?php } ?>
                                </tbody>
                                <?php
                        $balance = 0;
                        $netamount = 0;
                        foreach ($invoices as $total) {

                            $balance+=$total['balance'];
                            $netamount+=$total['net_amount'];
                        }
                        ?>
                        <tfoot>
                            <tr>
                                <td colspan="6" class="text-right"><strong>Total</strong></td>
                                <td colspan="6" class="text-danger"><?php echo $balance ? number_format($balance) : 0; ?></td>
                                <td><?php echo $netamount ? number_format($netamount) : 0; ?></td>
                                <td colspan="4"></td>
                                

                            </tr>
                        </tfoot>
                            </table>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->
                
                <div class="modal fade none-border" id="bad_debts_modal" tabindex="-1" role="dialog" aria-labelledby="Cash Register" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Bad Debts Remarks</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="bad_debts_remarks">Remarks</label>
                                    <input type="hidden" id="invoice_id_bad_debts">
                                    <textarea id="bad_debts_remarks" class="form-control"></textarea>
                                </div>
                                <div class="form-group" style="text-align: right;">
                                    <button class="btn btn-sm btn-primary waves-effect waves-light" id="mark_bad_debts">Mark Bad Debts</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                
                
    <script type="text/javascript">
        
        function openBadDebts(invoice_id){
            $('#invoice_id_bad_debts').val(invoice_id);
            $('#bad_debts_modal').modal({
                backdrop:'static',
                keyboard:false,
                show:true
            });
        }
        
        $(document).ready(function() {
            
            $('#mark_bad_debts').on('click', function(){
                
                var invoice_id = $('#invoice_id_bad_debts').val();
                var remarks = $('#bad_debts_remarks').val();
                
                $.ajax({
                    type: 'POST',
                    url: 'Invoice_controller/mark_bad_debts',
                    data: { invoice_id:invoice_id, remarks:remarks },
                    success: function(data) {
                        if(data === 'success'){
                            $('tr[invoice_id='+invoice_id+']').remove().fadeOut();
                            $('#bad_debts_modal').modal('hide');
                            toastr.success('Invoice marked as bad debts!', 'Done!');
                        }
                    } 
                });
                
            });
            
            $.fn.dataTable.moment('DD-MM-YYYY');
            $('#tblinvoice').DataTable({
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                stateSave: true,
                fixedHeader: {header: true},
                dom: "Bfrtlip",
                    buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"}, {
                            extend: "excel",
                            className: "btn-sm btn-warning btn-trans"
                        }, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}],
                    responsive: !0
                    
            });

        } );
        //TableManageButtons.init();
        
        function cancelinvoice(invoiceid, visitid){
            //Warning Message
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this invoice!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-warning',
                confirmButtonText: "Yes, remove it!",
                closeOnConfirm: true
            }, function (){
                $.ajax({
                    type: 'POST',
                    url: 'invoice_controller/cancelinvoice',
                    data: {invoiceid: invoiceid, visitid:visitid},
                    success: function(data) {
                        var result = data.split("|");
                        if (result[0] === "success") {
                            swal("Deleted!", "Your invoice has been removed.", "success");
                            location.reload();
                        } else {
                            swal("Error!", "Invoice was not removed!.", "error");
                        }
                    } 
                });
            });
        }

        function openinvoice(invoiceid){
            $.ajax({
                    type: 'POST',
                    url: 'invoice_controller/openinvoice',
                    data: {invoiceid: invoiceid},
                    success: function(data) {
                        
                    }
                });
        }
          
    </script>
