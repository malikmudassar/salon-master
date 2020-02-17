<style>
    .table thead tr th{
        border-top:2px solid #eee;
        border-bottom:2px solid #eee;
        background: #fcfcfc;
    }
    .table tfoot tr th{
        border-top:2px solid #eee;
        border-bottom:2px solid #eee;
        background: #fcfcfc;
    }
</style>
<div class="wrapper">
    <div class="container-full">
        <div class="row m-t-20">
            <div class="col-md-12">
                <div class="panel panel-default m-t-20">
                    <div class="panel-body">
                        <div class="row">
                            <div class="pull-left" >
                                <h3 class="logo invoice-logo"><?php
                                    if (isset($business)) {
                                        echo "<img src='" . base_url() . 'assets/images/business/' . $business[0]['business_logo'] . "' alt='" . $business[0]['business_name'] . "' class='img-responsive' />";
                                    } else {
                                        echo 'SkedWise';
                                    }
                                    ?></h3>
                            </div>
                            <div class="pull-right m-t-20" >
                                <div class="col-md-6 hidden-print m-t-20">
                                    <form method="POST" action='<?php echo base_url(); ?>marketing'>
                                        <input type="hidden" name="csrf_test_name" id="daily_sheet_csrf" value=""/>
                                        <div class="col-md-10">
                                            <input type="month" autocomplete="off" class="form-control inline m-r-5" name="calendar_date" id="datepicker-autoclose1">
                                        </div>
                                        <div class="col-md-2">
                                            <button type='submit' onclick="$('#daily_sheet_csrf').val($('#cook').val());" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6 hidden-print m-t-20">
                                    <!--<a class="btn btn-warning m-l-10" onclick="tableToExcel('sheet1', 'Marketing Sheet')" style="float:right">Export to Excel</a>-->
<!--                                    <a class="btn btn-warning m-l-10" href="<?php //echo base_url('marketing_controller/marketing_excell'.'/'.$date); ?>" style="float:right">Export to Excel</a>
                                    <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light hidden-print pull-right" id="btnprint"><i class="fa fa-print"></i></a>-->
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <table class="table m-t-10"  id='sheet1'>
                                <tr>
                                    <td colspan="4"><strong>Marketing Sheet <u> <?php echo isset($date) && !empty($date) ? date('M-Y', strtotime($date)) : date('M-Y'); ?></u></strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <table class="table table-striped table-bordered"  id='datatable-buttons'>
                                            <thead>
<!--                                                <tr>
                                                    <th colspan='7'><strong>Invoice Details</strong></th>
                                                </tr>-->
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Invoice</th>
                                                    <th>Staff Name</th>
                                                    <th>Customer</th>
                                                    <th>Service / Product</th>
                                                    <th>SERVICE / PRODUCT / ADVANCE / RECOVERY</th>
                                                    <th>Payment Mode</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if(isset($invoices) && !empty($invoices)){
                                                    $invoice_detail_id = 0;
                                                    foreach ($invoices as $invoice) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php if($invoice['reference_invoice_number']!==''){echo '<span class="text-danger"> Recovery '.$invoice['visit_date'];}else {echo $invoice['invoice_date'];}?>
                                                            </td>
                                                            <td>
                                                                <?php if ($invoice['invoice_type'] == 'service') {?>
                                                                <?php echo '<a target="_blank" href="'.base_url().'existinginvoice/'. $invoice['id_invoice'] .'"><span class="text-danger"> '.$invoice['id_invoice'];?>
                                                                <?php } else { ?>
                                                                <?php echo '<a target="_blank" href="'.base_url().'existingorderinvoice/'. $invoice['id_invoice'] .'"><span class="text-danger"> '.$invoice['id_invoice'];?>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                if ($invoice['invoice_type'] == 'service') {
                                                                    if ($invoice_detail_id !== $invoice['id_invoice_details']){
                                                                        echo $invoice['staff']; 
                                                                    } else {
                                                                        echo $invoice['staff'].' (supporting)'; 
                                                                    }
                                                                } else { 
                                                                    echo $invoice['product_staff'];
                                                                } 
                                                                ?>
                                                            </td>
                                                            <td><b><?php echo $invoice['customer_name']; ?></b></td>
                                                            <td><b><?php echo $invoice['invoice_type']; ?></b></td>
                                                            <td>
                                                                <?php if ($invoice['invoice_type'] == 'service') { ?>
                                                                    <?php echo $invoice['service']; ?>
                                                                <?php } else { ?>
                                                                    <?php echo $invoice['product_name']; ?>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?php echo $invoice['payment_mode']; ?></td>
                                                            <td style="text-align: right;">
                                                                <strong>
                                                                    <?php 
                                                                    if ($invoice['invoice_type'] == 'service') { 
                                                                        if ($invoice_detail_id !== $invoice['id_invoice_details']){
                                                                            echo number_format($invoice['paid_details'], 2); 
                                                                        } else { 
                                                                            //echo number_format($invoice['paid_details'], 2);  
                                                                        }
                                                                    } else {
                                                                        echo number_format($invoice['paid_details'], 2); 
                                                                    }
                                                                    ?>
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $invoice_detail_id=$invoice['id_invoice_details'];
                                                    }
                                                    
                                                    if(isset($advances) && !empty($advances)){
                                                    ?>
                                                        
                                                    <?php $idadvance=0;
                                                    foreach ($advances as $advance){
                                                        if($idadvance!==$advance['id_visit_advance']){
                                                    ?>
                                                        
                                                        <tr>
                                                            <td><?php echo $advance['advance_date']; ?></td>
                                                            <td><?php echo $advance['id_visit_advance']; ?></td>
                                                            <td>Advance</td>
                                                            <td><strong><?php echo $advance['customer_name']; ?></strong></td>
                                                            <td>Appointment</td>
                                                            <td><?php echo $advance['service_category'].' '.$advance['service_name'].' Rs. '.$advance['service_rate']; ?></td>
                                                            <td><?php echo $advance['advance_mode']; ?></td>
                                                            <td style="text-align: right;"><strong><?php echo number_format($advance['advance_amount'], 2); ?></strong></td>
                                                        </tr>
                                                        <?php $idadvance=$advance['id_visit_advance'];}
                                                        }
                                                    }
                                                }else{
                                                ?>
                                                        <tr>
                                                            <td >No Data to show</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>     
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>

                                            </tfoot>
                                        </table>
                                    </td>
                                    <td>

                                    </td>
                                </tr>

                            </table>
                        </div>
                        <!-- end row -->
                    </div>
                </div>

<script>
    $(document).ready(function(){
//        $('#datepicker-autoclose').datepicker({
//            autoclose: true,
//                todayHighlight: true,
//                format: 'yyyy-mm-dd'
//        });

        $('#datatable-buttons').DataTable({
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    stateSave: true,
                    dom: "Bfrtlip",
                    buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"}, {
                            extend: "excel",
                            className: "btn-sm btn-warning btn-trans"
                        }, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}],
                    responsive: !0
                });
    
    });
//    var tableToExcel = (function () {
//    //  application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
//    var uri = 'data:application/vnd.ms-excel;base64,', template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
//    , base64 = function (s) {return window.btoa(unescape(encodeURIComponent(s))) }
//    ,format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p];}) }
//    return function (table, name) {
//    if (!table.nodeType) table = document.getElementById(table)
//    var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }
//    var link = document.createElement("a");
//
//    var d = new Date();
//    var datestring = ("0" + d.getDate()).slice(-2) + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" +
//    d.getFullYear() + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2);
//
//    link.download = ctx.worksheet + ' ' + datestring;
//    link.href = uri + base64(format(template, ctx));
//    link.click();
//    //window.location.href = uri + base64(format(template, ctx))
//    }
//})()

</script>