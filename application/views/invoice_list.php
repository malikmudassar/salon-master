<style>
     tr.strikethrough > td {text-decoration:line-through !important; color:red;} 
</style>
<div class="wrapper">
            <div class="container">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        
                        <h4 class="page-title">Invoices</h4>
                    </div>
                </div>
                
                 <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                            <table id="tblinvoice" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Day Seq.</th>
                                        <!--<th>Invoice ID</th>-->
                                        <th>Invoice #</th>
                                        <th>Invoice Date</th>
                                        <th>VisitDate</th>
                                        <th>Customer</th>                                        
                                        <th>Customer Cell</th>
                                        <th>Status</th>
                                        <th>Type</th>
                                        <th>Recovery</th>
                                        <th>Balance</th>
                                        <th>Paid Amount</th>
                                        <th>Advance</th>
                                        <th>Sub Total</th>
                                        <th>Other Charges</th>
                                        <th>Discount</th>
                                        <th>Gross Amount</th>
                                        <th>Taxes</th>
                                        <th>Net Amount</th>
                                        <th>Payment Mode</th>
                                        <th>Instrument</th>                                        
                                        <th>Discount Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $balance = 0;
                                        $netamount = 0;
                                        $grossamount = 0;
                                        $subtotal = 0;
                                        $discount = 0;
                                        $taxes = 0;
                                        $paidamount = 0;
                                    ?>
                                    <?php foreach ($invoices as $invoice){?>
                                    
                                    <tr class="<?php if($invoice['invoice_status']!=='valid'){echo 'strikethrough';}?>">
                                        <td><?php echo $invoice['invoice_seq']; ?></td>
                                        <!--<td><?php echo $invoice['id_invoice']; ?></td>-->
                                        <td><?php echo $invoice['invoice_number']; ?></td>
                                        <td><?php echo $invoice['invoice_date']; ?></td>
                                        <td><?php echo $invoice['visit_time']; ?></td>
                                        <td class="text-custom"><?php echo $invoice['customer_name']; ?></td>
                                        <td>
                                            
                                            <?php 
                                                if( $this->session->userdata('hide_cell') && $this->session->userdata('hide_cell') == "No"){
                                                    echo $invoice['customer_cell']; 
                                                } 
                                            ?>
                                        
                                        
                                        </td>
                                        <td><?php echo $invoice['invoice_status']; ?></td>
                                        <td><?php echo $invoice['invoice_type']; ?></td>
                                        <td><?php echo $invoice['reference_invoice_number'] !== "" ? "<label class='label label-info'>Recovery</label>" : ""; ?></td>
                                        <td class="text-danger"><?php echo $invoice['balance']; if($invoice['invoice_status']=='valid'){$balance+=$invoice['balance'];}?></td>
                                        <td><?php echo $invoice['paid_amount']; if($invoice['invoice_status']=='valid'){$paidamount += $invoice['paid_amount'];}?></td>
                                        <td><?php echo $invoice['advance_amount']; ?></td>
                                        <td><?php echo $invoice['sub_total']; if($invoice['invoice_status']=='valid'){$subtotal += $invoice['sub_total'];}?></td>
                                        <td><?php echo $invoice['other_charges']; ?></td>
                                        <td><?php echo $invoice['discount']; if($invoice['invoice_status']=='valid'){$discount += $invoice['discount'];}?></td>
                                        <td><?php echo $invoice['gross_amount']; if($invoice['invoice_status']=='valid'){$grossamount += $invoice['gross_amount'];}?></td>
                                        <td><?php echo $invoice['tax_total']; if($invoice['invoice_status']=='valid'){$taxes += $invoice['tax_total'];}?></td>
                                        <td><?php echo $invoice['net_amount']; if($invoice['invoice_status']=='valid'){$netamount+=$invoice['net_amount'];}?></td>
                                        <td><?php echo $invoice['payment_mode']; ?></td>
                                        <td><?php echo $invoice['instrument_number']; ?></td>
                                        
                                        <td><?php echo $invoice['discount_remarks']; ?></td>
                                        <td>
                                            <a target="_blank" href="<?php if($invoice['invoice_type']=="service"){echo base_url().'existinginvoice/'.$invoice['id_invoice']; } elseif($invoice['invoice_type']=="sale") {echo base_url().'existingorderinvoice/'.$invoice['id_invoice']; } ?>" class="btn btn-warning waves-effect waves-light m-b-5"> <i class="fa fa-rocket m-r-5"></i> <span>Open</span> </a>
                                            <?php
                                            $visit_order_id = $invoice['visit_id'];
                                            $flag = '';
                                            if($invoice['invoice_type'] === "service"){
                                                $flag = 'service';
                                            } else{
                                                $flag = 'retail';
                                            }
                                            ?>
                                            <button onclick="cancelinvoice(<?php echo $invoice['id_invoice']; ?>, <?php echo $visit_order_id; ?>, '<?php echo $flag; ?>');" class="btn btn-icon waves-effect waves-light btn-danger m-b-5"> <i class="fa fa-remove"></i> </button>
                                        </td>
                                    </tr>
                                    
                                    <?php } ?>
                                </tbody>
                                
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                 <td></td> 
                                  <td></td>
                                <td></td>
                                <td><?php //echo $subtotal ? $subtotal : 0; ?></td>
                                <td><?php //echo $discount ? $discount : 0; ?></td>
                                <td class="text-right"><strong>Total:</strong></td>
                                <td><?php echo $paidamount ? $paidamount : 0; ?></td>
                                <td><?php //echo $balance ? $balance : 0; ?></td>
                                
                                
                                <td ><?php //echo $grossamount ? $grossamount : 0; ?></td>
                                <td><?php //echo $taxes ? $taxes : 0; ?></td>
                                <td><?php //echo $netamount ? $netamount : 0; ?></td>
                               
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                            </table>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->
                
                
                
    <script type="text/javascript">
        $(document).ready(function() {

            $('#tblinvoice').DataTable({
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                stateSave: true,
                fixedHeader: {header: true},
                dom: "Bfrtlip",
                    buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans", footer: true}, {
                            extend: "excel",
                            className: "btn-sm btn-warning btn-trans"
                        }, {extend: "pdf", className: "btn-sm btn-purple btn-trans", footer: true}
                    , {extend: "print", className: "btn-sm btn-primary btn-trans", footer: true}],
                    responsive: !0,
                    //"scrollX": true,
            });

        } );
        //TableManageButtons.init();
        
        function cancelinvoice(invoiceid, visit_order_id, flag){
            //Warning Message

            swal({
                title: "Are you sure?",
                text: "Give Reason For Cancelling This Invoice:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                inputPlaceholder: "reason for cancelling"
              }, function (inputValue) {
                if (inputValue === false) return false;
                if (inputValue === "") {
                  swal.showInputError("You need to write something!");
                  return false
                } 
                    $.ajax({
                        type: 'POST',
                        url: 'invoice_controller/cancelinvoice',
                        data: {
                            invoiceid : invoiceid,
                            visit_order_id : visit_order_id,
                            flag : flag,
                            reason : inputValue
                        },
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                swal("Deleted!", "Your invoice has been removed.", "success");
                                location.reload();
                            } else {
                                swal("Info!", "Invoice was not removed!. "+result[1] , "error");
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
