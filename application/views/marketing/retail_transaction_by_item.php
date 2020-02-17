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
                                <div class="col-md-9 hidden-print m-t-20">
                                    <form method="POST" action='<?php echo base_url(); ?>retail-transaction-by-item'>
                                        <input type="hidden" name="csrf_test_name" id="daily_sheet_csrf" value=""/>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-5">
                                                    <label>From</label>

                                                </div>
                                                <div class="col-md-5">
                                                    <label>To</label>

                                                </div>
                                                <div class="col-md-2">
                                                    <label>Run</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-5">

                                                    <input type="date" autocomplete="off" class="form-control inline m-r-5" name="fromdate" id="datepicker-autoclose1" value="<?php echo $fromdate; ?>">
                                                </div>
                                                <div class="col-md-5">

                                                    <input type="date" autocomplete="off" class="form-control inline m-r-5" name="todate" id="datepicker-autoclose1" value="<?php echo $todate; ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type='submit' onclick="$('#daily_sheet_csrf').val($('#cook').val());" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-3 hidden-print m-t-20">
                                    <div class="row">
                                        <div class="col-md-12"><label>&nbsp;</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="btn btn-warning m-l-10" target="_blank" onclick="exportfunction();" href="javascript:void(0);" style="float:right">Export to Excel</a>
                                            <!--<a class="btn btn-warning m-l-10" onclick="tableToExcel('sheet1', 'retailByItem')" style="float:right">Export to Excel</a>-->
                                        </div>
                                    </div>
<!--                                    <a class="btn btn-warning m-l-10" href="<?php //echo base_url('marketing_controller/marketing_excell'.'/'.$date);                                              ?>" style="float:right">Export to Excel</a>
                                    <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light hidden-print pull-right" id="btnprint"><i class="fa fa-print"></i></a>-->
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <table class="table m-t-10 table-bordered"  id='sheet1'>
                                <tr>
                                    <td colspan="7"><strong>Retail Transaction By Item </strong></td>
                                </tr>
                                <tr>
                                    <td colspan="7"><strong><u> From: <?php echo isset($fromdate) && !empty($fromdate) ? date('D d-M-Y', strtotime($fromdate)) : date('D d-M-Y'); ?> To <?php echo isset($todate) && !empty($todate) ? date('D d-M-Y', strtotime($todate)) : date('D d-M-Y'); ?></u></strong></td>
                                </tr>
                                <tr>
                                    <td colspan="7">
                                        <table class="table table-striped table-bordered"  id='datatable-buttons1'>
                                            <thead>
                                                <tr>
                                                    <th>Barcode</th>
                                                    <th>Description</th>
                                                    <th>Size</th>
                                                    <th>Sold</th>
                                                    <th>Total</th>
                                                    <th>Profit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($retailTransaction) && !empty($retailTransaction)) {
                                                    $grand_total_amount = 0;
                                                    $grand_total_profit = 0;
                                                    foreach ($retailTransaction as $data) {
                                                        ?>
                                                        <tr>
                                                            <td><strong><?php echo mb_strtoupper($data['brand_name']); ?></strong></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <?php
                                                        if (isset($data['data']) && !empty($data['data'])) {
                                                            $total_amount = 0;
                                                            $total_profit = 0;
                                                            foreach ($data['data'] as $row) {
                                                                ?>

                                                                <tr>
                                                                    <td><?php echo $row['barcode_products']; ?></td>
                                                                    <td>
                                                                        <?php echo $row['product_name']; ?>
                                                                        <span class="text-primary">
                                                                            <?php //if($row['reference_invoice_number'] != ""){echo "<br>". $row['reference_invoice_number']; }   ?>
                                                                        </span>
                                                                    </td>
                                                                    <td><?php echo $row['qty_per_unit'] . '' . $row['measure_unit']; ?></td>
                                                                    <td><?php echo $row['sold']; ?></td>
                                                                    <td class="text-right">
                                                                        <?php
                                                                        $grand_total_amount += $row['price'];
                                                                        echo number_format($row['price'], 2);
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <?php if ($row['price'] - $row['purchase_price'] > 0) { ?>
                                                                            <span class="text-primary"><?php
                                                                                $grand_total_profit += $row['price'] - $row['purchase_price'];
                                                                                echo number_format($row['price'] - $row['purchase_price'], 2);
                                                                                ?></span>
                                                                        <?php } else { ?>
                                                                            <span class="text-danger"><?php
                                                                                    $grand_total_profit += $row['price'] - $row['purchase_price'];
                                                                                echo number_format($row['price'] - $row['purchase_price'], 2);
                                                                                ?></span>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            //$grand_total_amount += $total_amount;
                                                            //$grand_total_profit += $total_profit;
                                                            ?>

                                                            <?php
                                                        } else {
                                                            ?>
                                                            <tr>
                                                                <td>Product not found for <strong><?php echo mb_strtoupper($data['brand_name']); ?></strong></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right"><strong>Grand Total: </strong></td>
                                                        <td class="text-right"><strong><?php echo number_format($grand_total_amount, 2); ?></strong></td>
                                                        <td class="text-right"><strong><?php echo number_format($grand_total_profit, 2); ?></strong></td>
                                                    </tr>
                                                </tfoot>
<?php } ?>
                                        </table>
                                    </td>
                                </tr>

                            </table>
                        </div>
                        <!-- end row -->
                    </div>
                </div>

                <script>
                    $(document).ready(function () {
                        var groupColumn = 1;
                        $('#datatable-buttons').DataTable({

                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            aoColumns: [{"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}],
                            //stateSave: true,
                            dom: "Bfrtlip",
                            buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans", footer: true}, {extend: "csv", className: "btn-sm btn-pink btn-trans", footer: true}, {
                                    extend: "excel",
                                    className: "btn-sm btn-warning btn-trans",
                                    footer: true
                                }, {extend: "pdf", className: "btn-sm btn-purple btn-trans", footer: true}],
                            responsive: !0,
                            //            "columnDefs": [{
                            //                "targets": groupColumn,
                            //                   "visible": false,
                            //                    "searchable": fals e,
                            //             }],
                            //            "drawCallback": function (settings) {
                            //                var api = this.api();
                            //                var rows = api.rows({
                            //                    page: 'current'
                            //                }).nodes();
                            //                var last = null;
                            //                api.column(groupColumn, {
                            //                    page: 'current'
                            //                }).data().each(function (group, i) {
                            //                    if (last !== group) {
                            //                        $(rows).eq(i).before('<tr class="group"><td colspan="7">' + group + '</td></tr>');
                            //                        last = group;
                            //                    }
                            //                });
                            //            },
                            //            exportOptions: {
                            //                    // Any other settings used
                            //                    grouped_array_index: ['<tr class="group"><td colspan="7"></td></tr>'],
                            //             }
                        });
                    });
//                    var tableToExcel = (function () {
//                        //  application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
//                        var uri = 'data:application/vnd.ms-excel;base64,', template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
//                                , base64 = function (s) {
//                                    return window.btoa(unescape(encodeURIComponent(s)))
//                                }
//                        , format = function (s, c) {
//                            return s.replace(/{(\w+)}/g, function (m, p) {
//                                return c[p];
//                            })
//                        }
//                        return function (table, name) {
//                            if (!table.nodeType)
//                                table = document.getElementById(table)
//                            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
//                            var link = document.createElement("a");
//
//                            var d = new Date();
//                            var datestring = ("0" + d.getDate()).slice(-2) + "-" + ("0" + (d.getMonth() + 1)).slice(-2) + "-" +
//                                    d.getFullYear() + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2);
//
//                            link.download = ctx.worksheet + ' ' + datestring;
//                            link.href = uri + base64(format(template, ctx));
//                            link.click();
//                            //window.location.href = uri + base64(format(template, ctx))
//                        }
//                    })()
                    
                    function exportfunction() {
                        var fromdate = $('input[name=fromdate]').val();
                        var todate = $('input[name=todate]').val();
                        var flag = "RetailTransactionByItem";
                        window.location.href = '<?php echo base_url(); ?>marketing_controller/ExportExcell/' + fromdate + '/' + todate + '/' + flag;
                    }

                </script>