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
                                <div class="col-md-10 hidden-print m-t-20">
                                    <form method="POST" action='<?php echo base_url(); ?>petty-cash-report'>
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
                                <div class="col-md-6 hidden-print m-t-20">
                                    <!--<a class="btn btn-warning m-l-10" onclick="tableToExcel('sheet1', 'Marketing Sheet')" style="float:right">Export to Excel</a>-->
<!--                                    <a class="btn btn-warning m-l-10" href="<?php //echo base_url('marketing_controller/marketing_excell'.'/'.$date);     ?>" style="float:right">Export to Excel</a>
                                    <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light hidden-print pull-right" id="btnprint"><i class="fa fa-print"></i></a>-->
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <table class="table m-t-10"  id='sheet1'>
                                <tr>
                                    <td colspan="4"><strong>Petty Cash <u> From: <?php echo isset($fromdate) && !empty($fromdate) ? date('D d-M-Y', strtotime($fromdate)) : date('D d-M-Y'); ?> To <?php echo isset($todate) && !empty($todate) ? date('D d-M-Y', strtotime($todate)) : date('D d-M-Y'); ?></u></strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <table class="table table-striped table-bordered"  id='datatable-buttons'>
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Created By</th>
                                                    <th>Account Head</th>
                                                    <th>Expense</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (isset($pettycash)) {
                                                    foreach ($pettycash as $row) { ?>
                                                        <tr>
                                                            <td><?php echo $row['voucher_date'] ?></td>
                                                            <td><?php echo $row['voucher_time'] ?></td>
                                                            <td><?php echo $row['created_by'] ?></td>
                                                            <td><?php echo $row['account_head'] ?></td>
                                                            <td><?php echo $row['description'] ?></td>
                                                            <td><?php echo $row['voucher_amount'] ?></td>
                                                        </tr>
                                                        <?php }
                                                    } ?>
                                            </tbody>
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


</script>