<!--<style>
    table thead tr th{
        border-top:2px solid #eee;
        border-bottom:2px solid #eee;
        background: #fcfcfc;
    }/*
    .table tfoot tr th{
        border-top:2px solid #eee;
        border-bottom:2px solid #eee;
        background: #fcfcfc;
    }*/
    .table-th{
        background: gray !important; 
        color: black !important;
    }
    @media print{
        .table-th{
            background: gray !important; 
            color: black !important;
        }
    }
</style>-->
<style type="text/css">

    table.customtble tbody tr td{
        padding: 0px 5px 0px 5px;
        border:1px solid #000;
    }
    table.customtble thead tr th, .table-th{
        padding: 0px 5px 0px 5px;
        border:1px solid #000;
        font-size: 14px;
        background: gray !important; 
        color: black !important;
    }
    @media print{
        table.customtble thead tr th, .table-th{
            font-size: 14px;
            background: gray !important; 
            color: black !important;
            -webkit-print-color-adjust: exact; 
        }
        table.customtble tbody tr td{
            font-size: 14px;
        }
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
                                    <form id="Sheet-Form" method="POST" action='<?php echo base_url(); ?>daily-sheet-by-category'>
                                        <input type="hidden" name="csrf_test_name" id="daily_sheet_csrf" value=""/>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-7">
                                                    <input type="date" autocomplete="off" class="form-control inline m-r-5" name="fromdate" id="datepicker-autoclose1" value="<?php echo $fromdate; ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type='submit' onclick="$('#daily_sheet_csrf').val($('#cook').val());" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-2 hidden-print m-t-20">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <!--<a class="btn btn-warning m-l-10" target="_blank" onclick="exportfunction();" href="javascript:void(0);" style="float:right">Export to Excel</a>-->
                                            <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light hidden-print pull-right" id="btnprint"><i class="fa fa-print"></i></a>
                                            <!--<a class="btn btn-warning m-l-10" onclick="tableToExcel('sheet1', 'ServicesByStaff');" href="javascript:void(0);" style="float:right">Export to Excel</a>-->
                                        </div>
                                    </div>
                                    <!--<a class="btn btn-warning m-l-10" onclick="tableToExcel('sheet1', 'Marketing Sheet')" style="float:right">Export to Excel</a>-->
<!--                                    <a class="btn btn-warning m-l-10" href="<?php //echo base_url('marketing_controller/marketing_excell'.'/'.$date);                                                                                                   ?>" style="float:right">Export to Excel</a>
                                    <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light hidden-print pull-right" id="btnprint"><i class="fa fa-print"></i></a>-->
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- end row -->

                        <div class="row">


                            <!--<table class="table table-striped table-bordered"  id='datatable-buttons1'>-->
                            <table border="1" style=" width: 100%;" cellspacing="0" id="datatable-buttons1" class="customtble">
                                <thead>
                                    <tr>
                                        <th class="table-th" colspan="2"><strong>Daily Work Sheet </th>
                                        <th class="text-right table-th">Date:</th>
                                        <th class="table-th"><strong><u><?php echo isset($fromdate) && !empty($fromdate) ? date('D d-M-Y', strtotime($fromdate)) : date('D d-M-Y'); ?></u></strong></th>
                                    </tr>

                                </thead>

                                <tbody>
                                    <?php
                                    if (isset($dailysheet) && !empty($dailysheet)) { $category = ""; $count = 1;
                                        foreach ($dailysheet as $row) {
                                            ?>
                                            <?php
                                            $total_price_cash = 0;$total_price_credit = 0;
                                                ?>
                                                <tr>
                                                    <th class="table-th" style="text-align: center;" colspan="4">
                                                        <?php echo $row['service_category']; ?>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th class="table-th">Worker Name</th>
                                                    <th class="table-th">Detail</th>
                                                    <th class="table-th">Amount</th>
                                                    <th class="table-th">Credit Card</th>
                                                </tr>
                                            <?php foreach($row['data'] as $data){ ?>
                                            <tr>
                                                <td><?php echo $data['staff']; ?></td>
                                                <td><?php echo $data['service_name']; ?></td>
                                                <td>
                                                    <?php if($data['payment_mode'] == "Cash"){ $total_price_cash += $data['paid']; echo $data['paid']; } ?>
                                                </td>
                                                <td>
                                                    <?php if($data['payment_mode'] == "Card"){ $total_price_credit += $data['paid']; echo $data['paid']; } ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="2" class="text-right">Total:</td>
                                                <td><?php echo $total_price_cash; ?></td>
                                                <td><?php echo $total_price_credit; ?></td>
                                            </tr>
                                                <?php
                                        }
                                    } else { ?> 
                                            <tr><td colspan="4">Data not found</td></tr>   
                                    <?php } ?>
                                </tbody>
                            </table>


                        </div>
                        <!-- end row -->
                    </div>
                </div>

                <script>
                    // $(document).ready(function(){

                    // });
                    //function tableToExcel(){
                    //exportDiv();
                    //var blob = b64toBlob('sheet1', "application/vnd.ms-excel");
                    //var blobUrl = URL.createObjectURL(blob);
                    //window.location = blobUrl;
                    //}
                    //    function b64toBlob(b64Data, contentType, sliceSize) {
                    //        contentType = contentType || '';
                    //        sliceSize = sliceSize || 512;
                    //
                    //        var byteCharacters = atob(b64Data);
                    //        var byteArrays = [];
                    //
                    //        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                    //            var slice = byteCharacters.slice(offset, offset + sliceSize);
                    //
                    //            var byteNumbers = new Array(slice.length);
                    //            for (var i = 0; i < slice.length; i++) {
                    //                byteNumbers[i] = slice.charCodeAt(i);
                    //            }
                    //
                    //            var byteArray = new Uint8Array(byteNumbers);
                    //
                    //            byteArrays.push(byteArray);
                    //        }
                    //
                    //        var blob = new Blob(byteArrays, {type: contentType});
                    //        return blob;
                    //    }
                    //                    $(document).ready(function () {
                    //                        var groupColumn = 1;
                    //                        $('#datatable-buttons').DataTable({
                    //                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    //                            //stateSave: true,
                    //                            dom: "Bfrtlip",
                    //                            buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans", footer: true}, {extend: "csv", className: "btn-sm btn-pink btn-trans", footer: true}, {
                    //                                    extend: "excel",
                    //                                    className: "btn-sm btn-warning btn-trans",
                    //                                    footer: true
                    //                                }, {extend: "pdf", className: "btn-sm btn-purple btn-trans", footer: true}],
                    //                            responsive: !0,
                    //            "columnDefs": [{
                    //                "targets": groupColumn,
                    //                   "visible": false,
                    //                   "searchable": false,
                    //            }],
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
                    //                        });
                    //                    });

                    //function exportDiv() {
                    //    //working on crome perfectly       
                    //        var dt = new Date();
                    //        var day = dt.getDate();
                    //        var month = dt.getMonth() + 1;
                    //        var year = dt.getFullYear();
                    //        var hour = dt.getHours();
                    //        var mins = dt.getMinutes();
                    //        var postfix = day + "." + month + "." + year + "_" + hour + "." + mins;
                    //        var a = document.createElement('a');
                    //        var data_type = 'data:application/vnd.ms-excel';
                    //        var table_div = document.getElementById('sheet1');
                    //        var table_html = table_div.outerHTML.replace(/ /g, '%20');
                    //        a.href = data_type + ', ' + table_html;
                    //        a.download = 'exported_table_' + postfix + '.xls';
                    //        a.click();
                    //        //e.preventDefault();
                    //
                    //}

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
                        var flag = "DailySheetByCategory";
                        //window.location.href = '<?php echo base_url(); ?>marketing_controller/ExportExcell/' + fromdate + '/' + fromdate + '/' + flag;
                    }
                </script>