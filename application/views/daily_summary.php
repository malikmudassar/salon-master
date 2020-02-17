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
    <div class="container">
        <div class="row m-t-20">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="pull-left" >
                                <h3 class="logo invoice-logo"><?php if(isset($business)){ echo "<img src='".base_url().'assets/images/business/'.$business[0]['business_logo']."' alt='".$business[0]['business_name']."' class='img-responsive' />";} else {echo 'SkedWise';}?></h3>
                            </div>
                            <div class="pull-right m-t-20" >
                                <div class="col-md-6 hidden-print m-t-20">
                                    <?php if($this->session->userdata('show_previous')=='Y' || $this->session->userdata('role')=='Admin' || $this->session->userdata('role')=='Super User' ){?>
                                    <form method="POST" action='<?php echo base_url();?>dailysummary_controller/index'>
                                        <input type="hidden" name="csrf_test_name" id="daily_summary_csrf" value=""/>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control inline m-r-5"  placeholder="mm/dd/yyyy" name="calendar_date" id="datepicker-autoclose">
                                        </div>
                                        <div class="col-md-3">
                                            <button type='submit' onclick="$('#daily_summary_csrf').val($('#cook').val());" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button>
                                        </div>
                                    </form>
                                    <?php } ?>
                                </div>
                                <div class="col-md-6 hidden-print m-t-20">
                                    <a class="btn btn-warning m-l-10" onclick="tableToExcel('sheet1', 'Daily Summary')" style="float:right">Export to Excel</a>
                                    <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light hidden-print pull-right" id="btnprint"><i class="fa fa-print"></i></a>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table m-t-10"  id='sheet1'>
                                    <tr>
                                        <td colspan="5"><strong>Daily Summary <u> <?php echo isset($date) && !empty($date) ? date('d-m-Y', strtotime($date)) : date('d-m-Y'); ?></u></strong></td>
                                    </tr>
                                    <!--transactions-->
                                    <tr>
                                        <td><strong>1.</strong></td>
                                        <td><strong>Transactions:</strong></td>
                                        <td></td>
                                        <td style="text-align: right;">Count</td>
                                        <td style="text-align: right;">Amount</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>Services:</td>
                                        <td style="text-align: right;"><?php echo $service_transactions[0]['services']; ?></td>
                                        <td style="text-align: right;"><?php echo number_format($service_transactions[0]['amount'],2); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>Retail:</td>
                                        <td style="text-align: right;"><?php echo $retail_transactions[0]['retail']; ?></td>
                                        <td style="text-align: right;"><?php echo number_format($retail_transactions[0]['amount'],2); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>Voucher:</td>
                                        <td style="text-align: right;"><?php echo $voucher_transactions[0]['vouchers']; ?></td>
                                        <td style="text-align: right;"><?php echo number_format($voucher_transactions[0]['amount'],2); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td><strong>Total: </strong></td>
                                        <td style="text-align: right;"><strong><?php echo $service_transactions[0]['services'] + $retail_transactions[0]['retail']+ $voucher_transactions[0]['vouchers']; ?></strong></td>
                                        <td style="text-align: right;"><strong><?php echo number_format($service_transactions[0]['amount'] + $retail_transactions[0]['amount']+ $voucher_transactions[0]['amount'],2); ?></strong></td>
                                    </tr>
                                    <!--Redemption-->
                                    <tr>
                                        <td><strong>2.</strong></td>
                                        <td><strong>Redemption:</strong></td>
                                        <td></td>
                                        <td style="text-align: right;">Count</td>
                                        <td style="text-align: right;">Amount</td>
                                    </tr>
                                    <tr>
                                        <?php  $totalcount=0; $totalamount=0;?>
                                        <td colspan="2"></td>
                                        <td>Loyalty:</td>
                                        <td style="text-align: right;"><?php echo $loyalty_discounts[0]['count']; ?></td>
                                        <td style="text-align: right;"><?php echo number_format($loyalty_discounts[0]['amount'],2); ?></td>
                                         <?php  $totalamount=$totalamount+$loyalty_discounts[0]['amount']; $totalcount=$totalcount+$loyalty_discounts[0]['count']; ?>
                                    </tr>
                                    <?php
                                    foreach($redemptions as $redemption){?>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td><?php echo $redemption['type']; ?></td>
                                        <td style="text-align: right;"><?php echo $redemption['count']; ?></td>
                                        <td style="text-align: right;"><?php echo number_format($redemption['amount'],2); ?></td>
                                    </tr>
                                    <?php  $totalamount=$totalamount+$redemption['amount']; $totalcount=$totalcount+$redemption['count'];} ?>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td><strong>Total:</strong></td>
                                        <td style="text-align: right;"><strong><?php echo $totalcount; ?></strong></td>
                                        <td style="text-align: right;"><strong><?php echo number_format($totalamount,2); ?></strong></td>
                                    </tr>
                                    <!--New Sign Ups-->
                                    <tr>
                                        <td><strong>3.</strong></td>
                                        <td><strong>New Sign Ups:</strong></td>
                                        <td></td>
                                        <td style="text-align: right;"><strong><?php echo $new_customers[0]['NewCustomers']; ?></strong></td>
                                        <td></td>
                                    </tr>
                                    <!--New Sign Ups-->
                                    <tr>
                                        <td><strong>4.</strong></td>
                                        <td><strong>Returning:</strong></td>
                                        <td></td>
                                        <td style="text-align: right;"><strong><?php echo $returning_customers[0]['Returning']; ?></strong></td>
                                        <td></td>
                                    </tr>
                                     <!--Customers To Date-->
                                    <tr>
                                        <td><strong>5.</strong></td>
                                        <td><strong>Customers to Date:</strong></td>
                                        <td></td>
                                        <td style="text-align: right;"><strong><?php echo $customerstodate[0]['Customers']; ?></strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>Male:</td>
                                        <td style="text-align: right;"><?php echo $male[0]['Male']; ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>Female:</td>
                                        <td style="text-align: right;"><?php echo $female[0]['Female']; ?></td>
                                        <td></td>
                                    </tr>
                                    
                                </table>
                            </div>
                    </div>
                    <!-- end row -->
    </div>
</div>

<script>
    $(document).ready(function(){   
         $('#datepicker-autoclose').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            });
    });

     var tableToExcel = (function () {
          //  application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
            var uri = 'data:application/vnd.ms-excel;base64,'
              , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
              , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
              , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
            return function (table, name) {
                if (!table.nodeType) table = document.getElementById(table)
                var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }
                var link = document.createElement("a");
                
                var d = new Date();
                var datestring = ("0" + d.getDate()).slice(-2) + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" +
                d.getFullYear() + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2);
    
                link.download = ctx.worksheet + ' ' + datestring;
                link.href = uri + base64(format(template, ctx));
                link.click();
                //window.location.href = uri + base64(format(template, ctx))
            }
        })()
        
</script>