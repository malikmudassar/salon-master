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
</style>
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    <button type="button"  onclick="openaddnew();" class="btn btn-custom waves-effect waves-light" >Create Transfer Notes<span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                </div>
                <h4 class="page-title">Inventory Transfer notes:</h4>
            </div>
        </div>

        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <!--<h4 class="header-title m-t-0 m-b-30">Selection:</h4>-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="selectstores">Select Stores</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select class="form-control" id="selectstores">
                                                <?php if($this->session->userdata['common_products']=='Yes'){?>
                                                <option value="All">All</option>
                                                <?php } ?>
                                                <?php foreach($stores as $store){ ?>
                                                <option <?php if($store['id_business']==$this->session->userdata['businessid']){echo 'selected="selected"';}?> value="<?php echo $store['id_business_stores']?>"><?php echo $store['business_store'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">Select Dates</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <div id="reportrange" class="inner-addon left-addon">
                                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                <input style="background-color: white;" readonly class="form-control" type="text" name="range" id="range" />
                                                <input type="hidden" name="rangehidden" id="rangehidden" value="1" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">&nbsp;</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" > 
                                            <button type="button" onclick="runreport();" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><i id="cog" class="fa fa-spin fa-cog" style="display:none; font-size:26px;width: auto;margin-right: 10px;"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>
                    <table id="tblreport" class="table table-striped table-bordered dt-responsive nowrap record" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Ready</th>
                            </tr>
                        </thead>
                        <tbody>
                        <td>Run Report</td>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

        <!--Add Product Modal-->
        <div id="addpurchaseorder" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addpurchaseorder" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new Transfer Note</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="storefrom" class="control-label">From Store</label>
                                            <select onchange="openaddnew();" id="storefrom" name="storefrom" class="form-control" >
                                                <?php foreach ($stores as $store) { ?>
                                                     <option businessid="<?php echo $store['business_id'];?>" <?php if($store['business_id']==$this->session->userdata('businessid')){echo "selected='selected'";}?> value="<?php echo $store['id_business_stores']; ?>"><?php echo $store['business_store']; ?></option>
                                                <?php   } ?>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="storeto" class="control-label">To Store</label>
                                            <select id="storeto" name="storeto" class="form-control" >
                                                <?php foreach ($stores as $store) { ?>
                                                     <option value="<?php echo $store['id_business_stores']; ?>"><?php echo $store['business_store']; ?></option>
                                                <?php   } ?>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product" class="control-label">Products</label>
                                            <input type="text" class='form-control' id="product" name="product"  placeholder="Select Products" >
                                        </div> 
                                    </div> 
                                </div>
                            </div>

                            
                            
                        </div>
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <button style="float:right" onclick="addOrderRows();" type="button" class="btn btn-sm btn-purple waves-effect ">Add Product <i class="ti-arrow-circle-down"></i></button>
                            </div>
                        </div>
                        <div class='row ' style="min-height: 150px;">
                            <div id='order-product-list' class='col-md-12'>
                                <div class="table-responsive">
                                    <table class="table" id="ordertbl">
                                        <thead>
                                            <tr>
                                                <th style="display:none;">BatchID</th>
                                                <th>Batch#</th>
                                                <th>Product</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Available</th>
                                                <th class="text-custom">Qty</th>
                                                <th class="text-custom">Price</th>
                                                <th>Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="addnew();" type="button" class="btn btn-custom waves-effect waves-light orderloader"><span>Save</span></button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Product Modal-->

       

        <script type="text/javascript">

            var startdate = '';
            var enddate = '';
            $(document).ready(function() {
                $(".numeric").keypress(function (e) {
                    //if the letter is not digit then display error and don't type anything
                    if (e.which != 13 && e.which != 8 && e.which != 0  && e.which != 46 && (e.which < 48 || e.which > 57)) {
                       return false;
                   }
                  });
                //var cl = $('.daterangepicker').find('.ranges li:eq(6)').addClass('active')
                //console.log(cl);
            <?php
            //$month_ini = new DateTime("first day of last month");
            //$month_end = new DateTime("last day of last month");

            $query_date = date('Y-m-d');
            // First day of the month.
            $month_ini = date('Y-m-01', strtotime($query_date));
            // Last day of the month.
            $month_end = date('Y-m-t', strtotime($query_date));
            ?>
                var startmonth = '<?php echo date('F j, Y', strtotime($month_ini)); //->format('F j, Y');    ?>';
                var endmonth = '<?php echo date('F j, Y', strtotime($month_end)); //->format('F j, Y');    ?>';
                $('#reportrange input').val(startmonth + ' - ' + endmonth);
                transfer_notes('<?php echo $month_ini; //->format('Y-m-d');    ?>', '<?php echo $month_end; //->format('Y-m-d');    ?>');
                //$('[data-toggle="tooltip"]').tooltip();


                $('#tblreport').DataTable({
                    dom: "Bfrtlip",
                    buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                            extend: "excel",
                            className: "btn-sm"
                        }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
                    responsive: !0
                });

                //$('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

                $('#reportrange').daterangepicker({
                    //format: 'MM/DD/YYYY',
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment(),
                    minDate: '01/01/2012',
                    maxDate: '12/31/2099',
//                    dateLimit: {
//                        days: 60
//                    },
                    showDropdowns: true,
                    showWeekNumbers: true,
                    timePicker: false,
                    timePickerIncrement: 1,
                    timePicker12Hour: true,
                    ranges: {
                        'Today': [moment(), moment().add(1, 'days')],
                        'Yesterday': [moment().subtract(1, 'days'), moment()],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment().add(1, 'days')],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment().add(1, 'days')],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    opens: 'left',
                    drops: 'down',
                    buttonClasses: ['btn', 'btn-sm'],
                    applyClass: 'btn-success',
                    cancelClass: 'btn-default',
                    separator: ' to ',
                    locale: {
                        applyLabel: 'Submit',
                        cancelLabel: 'Cancel',
                        fromLabel: 'From',
                        toLabel: 'To',
                        customRangeLabel: 'Custom',
                        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                        firstDay: 1
                    }
                }, function(start, end, label) {
                    //console.log(start.toISOString(), end.toISOString(), label);
                    startdate = start;
                    enddate = end;
                    //$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    $('#reportrange input').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                });



                $(".vertical-spin").TouchSpin({
                    verticalbuttons: true,
                    buttondown_class: "btn btn-primary",
                    buttonup_class: "btn btn-primary",
                    verticalupclass: 'ti-plus',
                    verticaldownclass: 'ti-minus'
                });
                var vspinTrue = $(".vertical-spin").TouchSpin({
                    verticalbuttons: true
                });
                if (vspinTrue) {
                    $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
                }

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

                $("#product").select2({
                    allowClear: true
                });

               
                

            });
            //TableManageButtons.init();

            function runreport() {
                //var reportname = $('#selectreport').val();
                //console.log(reportname);
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
                //console.log(startdate);
               // console.log(startdate.format('YYYY-MM-DD') + ' ' + enddate.format('YYYY-MM-DD'));

                //if (reportname === 'transfer_notes') {
                transfer_notes();
                //}

            }

            function transfer_notes(start = null, end = null) {
                var startd = start ? start : startdate.format('YYYY-MM-DD');
                var endd = end ? end : enddate.format('YYYY-MM-DD');
                
                console.log('here' + $("#selectstores option:selected").val());
                
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'transfernotes_controller/get_incoming_gtn_list',
                    data: {startdate: startd, enddate: endd, selectstore: $("#selectstores option:selected").val()},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        //console.log(data);
                        var hhtml = "<tr><th>ID</th><th>Date</th><th>Store</th><th>Product</th><th>Batch</th><th>Transfer Out Qty</th><th>Transfer In Qty</th><th>Unit Cost</th><th>Amount</th><th>Created By</th></tr>";

                        var mhtml = "";
                        var fhtml = "";
                        var last_gtn_id = 0; var qty_in=0; transferamount=0;
                        for (x = 0; x < data.length; x++) {
                             mhtml += '<tr>';
                            if(last_gtn_id !== data[x]['id_gtn'] ){
                                
                                mhtml += '<td>' + data[x]['id_gtn'] + '</td>';
                                mhtml += '<td>' + data[x]['transfer_date'] + '</td>';
                                mhtml += '<td>From ' + data[x]['business_store'] + '</td>';
                                mhtml += '<td>' + data[x]['product'] + ' ' + data[x]['qty_per_unit'] + ' ' + data[x]['measure_unit'] + '</td>';
                                mhtml += '<td>' + data[x]['batch_number'] + '</td>';
                                mhtml += '<td>' + data[x]['tranfer_out_qty'] + '</td>';
                                mhtml += '<td>' + data[x]['tranfer_in_qty'] + '</td>';
                                qty_in = qty_in+parseFloat(data[x]['tranfer_in_qty']);
                                mhtml += '<td>' + data[x]['batch_amount'] + '</td>';
                                mhtml += '<td>' + data[x]['Cost of Transferred Goods'] + '</td>';
                                transferamount= transferamount+(parseFloat(data[x]['Cost of Transferred Goods']));
                                mhtml += '<td class="text-primary">' + data[x]['created_by'] + '</td>'; 
                            } else {
                               
                                mhtml += '<td style="border-bottom: 1px solid #888 "></td>';
                                mhtml += '<td style="border-bottom: 1px solid #888 "></td>';
                                mhtml += '<td style="border-bottom: 1px solid #888 ">To ' + data[x]['business_store'] + '</td>';
                                mhtml += '<td style="border-bottom: 1px solid #888 "></td>';
                                mhtml += '<td style="border-bottom: 1px solid #888 ">' + data[x]['batch_number'] + '</td>';
                                mhtml += '<td style="border-bottom: 1px solid #888 ">' + data[x]['tranfer_out_qty'] + '</td>';
                                mhtml += '<td style="border-bottom: 1px solid #888 ">' + data[x]['tranfer_in_qty'] + '</td>';
                                qty_in = qty_in+parseFloat(data[x]['tranfer_in_qty']);
                                mhtml += '<td style="border-bottom: 1px solid #888 ">' + data[x]['batch_amount'] + '</td>';
                                mhtml += '<td style="border-bottom: 1px solid #888 ">' + data[x]['Cost of Transferred Goods'] + '</td>';
                                transferamount= transferamount+(parseFloat(data[x]['Cost of Transferred Goods']));
                                mhtml += '<td style="border-bottom: 1px solid #888 " class="text-primary">' + data[x]['created_by'] + '</td>'; 
                            }
                           
                            mhtml += '</tr>';
                            last_gtn_id = data[x]['id_gtn'];
                        }
                        //console.log(mhtml);
                        fhtml="<tr><th></th><th></th><th></th><th></th><th></th><th></th><th>"+qty_in+"</th><th></th><th>"+transferamount+"</th><th></th></tr>";
                        
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport tfoot").html('');
                        
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        $("#tblreport tfoot").append(fhtml);

                        $('#tblreport').DataTable({
                            dom: "Bfrtlip",
                            fixedHeader: {header: true},
                            buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                                    extend: "excel",
                                    className: "btn-sm"
                                }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
                            responsive: !0,
                            stateSave: true,
                            ordering: false
                        });
                        $("#cog").hide();

                    }
                });
            }

            //This function is using to open purchaseorder_detail for GRN in new page url called good_recieved_note...
            function set_order(porderid) {
                var pordertext = $('#ponumber' + porderid).val();
                var orderstatus = $('#o_status' + porderid).val();
                localStorage.setItem("porderid", porderid);
                localStorage.setItem("pordertext", pordertext);
                localStorage.setItem("orderstatus", orderstatus);
            }


            //function supplier_brand(supplierid) {

            //}

            //function brand_product(brandid) {

            //}

           

            function openaddnew() {
                
                var element = $('#storefrom').find('option:selected'); 
                
                var businessid = element.attr("businessid"); 
                var storeid = element.val();
                console.log(storeid);
                 $("#product").select2({
                    ajax: {
                        url: '<?php echo base_url() . 'product_controller/getproducts'; ?>',
                        dataType: 'json',
                        delay: 250,
                        data: function (term, page) {

                            return {
                                productname: term, // search term
                                page_limit: 30, // page size
                                page: page, // page number
                                businessid: businessid,
                                storeid: storeid
                            };
                        },
                        results: function (data, page) {

                            var more = (page * 30) < data.length;
                            return {results: data, more: more};
                        }
                    },
                    escapeMarkup: function (m) {
                        return m;
                    }, // let our custom formatter work
                    minimumInputLength: 1,
                    formatResult: function (option) {
                        return option.business_brand_name + ' - ' + option.product + ' ' +option.qty_per_unit + ' ' + option.measure_unit + ' - ' + option.mcategory + ' - Batch: ' + option.batch + ' ('+ option.business_store +': ' + option.instock + ')';
                    },
                    formatSelection: function (option) {
                        return option.business_brand_name + ' - ' + option.product + ' ' +option.qty_per_unit + ' ' + option.measure_unit + ' - ' + option.mcategory + ' - Batch: ' + option.batch + ' ('+ option.business_store +': ' + option.instock + ')';
                    }
                });
                
                
                $("#addpurchaseorder").modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
            }

            function transfer_notes_edit(purchaseorder_id) {
                if (purchaseorder_id) {
                    console.log(purchaseorder_id);
                }
            }

            function addOrderRows() {
                 var rowcount=0;
                if ($("#product").val() === "") {
                    swal({
                        title: "Product Should not be empty!",
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                    return false;
                }
                var data = $("#product").select2('data');
        
                var product_id = parseInt(data.id_business_products);
                var in_stock = parseInt(data.instock);
                var product_name = data.product;
                var category = data.category;
                var batch = data.batch_number;
                var batch_id = data.batch_id;
                var price = data.price;
                var unit_type =data.unit_type;
                var measure_unit=data.measure_unit;
                var qty_per_unit = data.qty_per_unit;
                
                var mhtml = "";
                var exists;
                var count = 1;

                //if ($("#product option:selected").val() > 0) {

                $('#order-product-list').find("td.id").each(function(index) {
                    if ($(this).html() === batch_id) {
                        exists = 1;
                    }
                });

                mhtml += '<tr>';
                mhtml += "<td class='id' row='"+rowcount+"'>"+ batch_id + "</td>";
                mhtml += "<td productid='"+product_id+"'>" + product_name + "</td>";
                mhtml += "<td class='storefrom'>" + $('#storefrom option:selected').text() + "</td>";
                mhtml += "<td class='storeto' storeid='"+$('#storeto option:selected').val()+"' >" + $('#storeto option:selected').text() + "</td>";
                mhtml += "<td class='available' >"+  in_stock + "</td>";
                mhtml += "<td class='text-primary'><abbr title='Edit'><input type='number' style='border:none; width:50px' value = '1'  id='product_qty' name='product_qty' onkeyup='if(this.value>"+in_stock+"){this.value="+in_stock+"};')' ></abbr></td>";
                mhtml += '<td><span class="label label-danger" onclick="removeproduct(' + parseFloat(batch_id) + ')" style="cursor:pointer">x</span></td>';
                
                mhtml += "</tr>";
                //}
                if (exists !== 1) {
                    $("#order-product-list tbody").append(mhtml);
                } else {
                    swal({
                        title: "Product already added!",
                        text: 'If you want to change the qty, please do it in the table below.',
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                }
            }

            function removeproduct(val) {
               
                $('#order-product-list').find("td.id").each(function(index) {
                    
                    if ($(this).html() == val) {
                        $(this).closest('tr').remove();
                    }
                });
            }

            function addnew() {
                transfer_updateorder();
                //console.log(transfer_storeOTblValues());
            }

            function transfer_storeOTblValues() {
                var TableData = new Array();
                $('#ordertbl tr').each(function(row, tr) {
                    TableData[row] = {
                        "batch_id": $(tr).find('td:eq(0)').text()
                        , "batch_number": $(tr).find('td:eq(0)').text()
                        , "product_id": $(tr).find('td:eq(1)').attr('productid')
                        , "tostore": $(tr).find('td:eq(3)').attr('storeid')
                        , "available_qty": $(tr).find('td:eq(4)').text()
                        , "transfer_qty": $(tr).find('td:eq(5)').find('#product_qty').val()
                    }
                });
                TableData.shift();  // first row will be empty - so remove
                return TableData;
            }

            function transfer_updateorder() {
                //if ($("#order-id").val() === "") { //add new visit
                var TableData;
                TableData = transfer_storeOTblValues();
                TableData = $.toJSON(TableData);
                if (TableData.length > 2) {
                    $('.orderloader span').text('');
                    $('.orderloader span').addClass('fa fa-spin fa-spinner');
                    $.ajax({
                        type: "POST",
                        url: "product_controller/bulk_transfer_qty",
                        //data: "orderdata=" + TableData,
                        data: {orderdata: TableData},
                        success: function(data) {
                           
                            var result = data.split("|");
                            if (result[0] === "success") {
                                //$("#order-id").val(result[1]);
                                //$('#btngenorderinvoice').show();
                                //transfer_clearorder();
                                //transfer_openOrder(result[1]);
                                toastr.success('Transfer notes created!', 'Done!');
                                location.reload();
                            } else {
                                swal({
                                    title: "Error",
                                    //text: result[1],
                                    type: "error",
                                    confirmButtonText: 'OK!'
                                });
                            }
                        }
                    });
                } else {
                    swal({
                        title: "You have not added any Products",
                        //text: 'Select Product and staff member providing that made the sale.',
                        type: "warning",
                        confirmButtonText: 'OK!'
                    });
                }
//                } else { //update existing order
//                    var TableData;
//                    TableData = transfer_storeOTblValues();
//                    TableData = $.toJSON(TableData);
//                    if (TableData.length > 2) {
//                        $.ajax({
//                            type: "POST",
//                            url: "order_controller/updateorder",
//                            data: "&orderdata=" + TableData + "&orderid=" + $("#order-id").val(),
//                            success: function(data) {
//                                var result = data.split("|");
//                                if (result[0] === "success") {
//                                    //transfer_clearorder();
//                                    //transfer_openOrder(result[1]);
//                                    //$('#btngenorderinvoice').show();
//                                    toastr.success('Order Updated!', 'Done!');
//                                } else {
//                                    swal({
//                                        title: "Error",
//                                        text: result[1],
//                                        type: "error",
//                                        confirmButtonText: 'OK!'
//                                    });
//                                }
//                            }
//                        });
//                    } else {
//                        swal({
//                            title: "You have not added any Products",
//                            text: 'Select Product and staff member providing that made the sale.',
//                            type: "error",
//                            confirmButtonText: 'OK!'
//                        });
//                    }
//                }
            }

            //////////////////Edit Purchase order.....
            function edit_transfer_notes(purchaseorder_id) {
                //
                var order_status = $('#status' + purchaseorder_id).val();
                if (purchaseorder_id && order_status !== "Delivered") {
                    $('#edit_purchaseorder_id').val(purchaseorder_id);
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url("purchaseorder_controller/edit_purchaseorder"); ?>',
                        data: {purchaseorder_id: purchaseorder_id},
                        dataType: "json",
                        cache: false,
                        async: true,
                        success: function(data) {
                            var purchaseorder = data['edit_purchaseorder'];
                            var purchaseorder_detail = data['edit_purchaseorder_detail'];
                            $('#supplieredit').select2('data', {id: purchaseorder[0]['supplier_id'], text: purchaseorder[0]['supplier_name']});
                            $('#supplieredit').attr("disabled","disabled");
                            subpplierbrand($('#supplieredit').val());
                            //$('#brandedit').select2('data', {id: purchaseorder_detail[0]['brand_id'], text: purchaseorder_detail[0]['brand_name']});
                            //$('#productedit').select2('data', {id: purchaseorder_detail[0]['product_id'], text: purchaseorder_detail[0]['product_name']});
                            //$('#orderdateedit').val(purchaseorder[0]['order_date']);
                            var mhtml = "";
                            if (purchaseorder_detail.length > 0) {
                                for (var i = 0; i < purchaseorder_detail.length; i++) {
                                    mhtml += '<tr>';
                                    mhtml += '<td style="display:none;">' + purchaseorder_detail[i]['brand_id'] + '</td>';
                                    mhtml += "<td class='id'>" + purchaseorder_detail[i]['product_id'] + "</td>";
                                    mhtml += "<td>" + purchaseorder_detail[i]['brand_name'] + "</td>";
                                    mhtml += "<td>" + purchaseorder_detail[i]['product_name'] + "</td>";
                                    mhtml += "<td class='text-primary'><abbr title='Edit'><input type='number' style='border:none; width:70px'  id = 'product_price_edit' name = 'product_price_edit' value = " + purchaseorder_detail[i]['product_purchase_price'] + " /></abbr></td>";
                                    mhtml += "<td class='text-primary'><abbr title='Edit'><input type='number' style='border:none; width:50px' value='" + purchaseorder_detail[i]['product_qty'] + "' id='product_qty_edit' name='product_qty_edit' ></abbr></td>";
                                    mhtml += "<td style='display:none;'>" + purchaseorder[0]['supplier_id'] + "</td>";
                                    mhtml += "<td style='display:none;'>" + purchaseorder[0]['supplier_name'] + "</td>";
                                    mhtml += "<td style='display:none;'>" + purchaseorder[0]['order_date'] + "</td>";
                                    mhtml += '<td><span class="label label-danger" onclick="removeproduct_edit(' + purchaseorder_detail[i]['product_id'] + ')" style="cursor:pointer">x</span></td>';
                                    mhtml += "</tr>";
                                }
                                $("#edit-order-product-list tbody").html('');
                                $("#edit-order-product-list tbody").append(mhtml);
                            } else {
                            

                            }
                            $("#editpurchaseorder").modal({
                                backdrop: 'static',
                                keyboard: false,
                                show: true
                            });
                        }
                    });
                } else {
                    swal({
                        title: "Purchaseorder Delivered",
                        text:"This purchaseorder delivered you are not able to change/update again!",
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                    return false;
                }
            }
            
            //This function is calling from edit purchase order success function... 
            function subpplierbrand(supplierid){
             
                if (supplierid && supplierid !== "") {
                        $(".loader").fadeIn("slow");
                        $("#brandedit").select2('val', 'All');
                        $("#productedit").select2('val', 'All');
                        $("#productedit option").each(function() { //added a each loop here
                            //$(this).select2('val', '');
                            $(this).remove();
                        });
                        $.ajax({
                            type: 'POST',
                            //url: '<?php //echo base_url("purchaseorder_controller/supplier_brand");    ?>/' + supplierid,
                            url: '<?php echo base_url("purchaseorder_controller/supplier_brand"); ?>',
                            data: {supplierid: supplierid, businessid:$("#businessid option:selected").val()},
                            dataType: "json",
                            cache: false,
                            async: true,
                            success: function(data) {
                               
                                $('#brandedit').html('');
                                
                                var brand_edit = "";
                                if (data.length > 0) {
                                    for (var i = 0; i < data.length; i++) {
                                        //brand += '<option value = ' + data[i]['id_business_brands'] + '>' + data[i]['business_brand_name'] + '</option>';
                                        brand_edit += '<option value = ' + data[i]['id_business_brands'] + '>' + data[i]['business_brand_name'] + '</option>';
                                    }
                                    $('#brandedit').html(brand_edit);
                                } else {
                                    //$('#brand').append('<option value = ""></option>');
                                    $('#brandedit').append('<option value = ""></option>');
                                }
                            }
                        });
                        $(".loader").fadeOut("slow");
                    }
            }

            function editOrderRows() {

                if ($("#supplieredit").val() === "" || $("#brandedit").val() === "" || $("#productedit").val() === "" || $("#orderdateedit").val() === "") {
                    swal({
                        title: "Supplier/Brand/Product & Date Should not be empty!",
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                    return false;
                }

                var mhtml = "";
                var exists;
                var count = 1;

                //if ($("#product option:selected").val() > 0) {

                $('#edit-order-product-list').find("td.id").each(function(index) {
                    if ($(this).html() === $("#productedit option:selected").val()) {
                        exists = 1;
                    }
                });

                mhtml += '<tr>';
                mhtml += '<td style="display:none;">' + $("#brandedit").val() + '</td>';
                mhtml += "<td class='id'>" + $("#productedit option:selected").val() + "</td>";
                mhtml += "<td>" + $("#brandedit option:selected").text() + "</td>";
                mhtml += "<td>" + $("#productedit option:selected").text() + "</td>";
                mhtml += "<td class='text-primary'><abbr title='Edit'><input type='number' style='border:none; width:70px' id = 'product_price_edit' name = 'product_price_edit' value = " + $("#productedit option:selected").attr('product-price') + " /></abbr></td>";
                mhtml += "<td class='text-primary'><abbr title='Edit'><input type='number' style='border:none; width:50px' value = '1' type='text' id='product_qty_edit' name='product_qty_edit' ></abbr></td>";
                mhtml += "<td style='display:none;'>" + $("#supplieredit option:selected").val() + "</td>";
                mhtml += "<td style='display:none;'>" + $("#supplieredit option:selected").text() + "</td>";
                mhtml += "<td style='display:none;'>" + $("#orderdateedit").val() + "</td>";
                mhtml += '<td><span class="label label-danger" onclick="removeproduct_edit(' + $("#productedit option:selected").val() + ')" style="cursor:pointer">x</span></td>';
                mhtml += "</tr>";
                //}
                if (exists !== 1) {
                    $("#edit-order-product-list tbody").append(mhtml);
                } else {
                    swal({
                        title: "Product already added!",
                        text: 'If you want to change this product, please remove and add again.',
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                }
            }

            function removeproduct_edit(val) {
                $('#edit-order-product-list').find("td.id").each(function(index) {
                    if ($(this).html() == val) {
                        $(this).closest('tr').remove();
                    }
                });
            }

            function edit_transfer_storeOTblValues() {
                var TableData = new Array();
                $('#edit-ordertbl tr').each(function(row, tr) {
                    TableData[row] = {
                        "brandid": $(tr).find('td:eq(0)').text()
                        , "productid": $(tr).find('td:eq(1)').text()
                        , "brandname": $(tr).find('td:eq(2)').text()
                        , "productname": $(tr).find('td:eq(3)').text()
                        , "productprice": $(tr).find('td:eq(4)').find('#product_price_edit').val()
                        , "productqty": $(tr).find('td:eq(5)').find('#product_qty_edit').val()
                        , "supplierid": $(tr).find('td:eq(6)').text()
                        , "suppliername": $(tr).find('td:eq(7)').text()
                        , "orderdate": $(tr).find('td:eq(8)').text()

                    }
                });
                TableData.shift();  // first row will be empty - so remove
                return TableData;
            }

            function editnew() {
                edit_transfer_updateorder();
                //console.log(transfer_storeOTblValues());
            }

            function edit_transfer_updateorder() {
                //if ($("#order-id").val() === "") { //add new visit
                var TableData;
                TableData = edit_transfer_storeOTblValues();
                TableData = $.toJSON(TableData);
                if (TableData.length > 2) {
                    $('.orderloader span').text('');
                    $('.orderloader span').addClass('fa fa-spin fa-spinner');
                    $.ajax({
                        type: "POST",
                        url: "purchaseorder_controller/updatetransfer_notes",
                        //data: "orderdata=" + TableData,
                        data: {orderdata: TableData, purchaseorder_id: $('#edit_purchaseorder_id').val()},
                        success: function(data) {
                            console.log(data);
                            var result = data.split("|");
                            if (result[0] === "success") {
                                //$("#order-id").val(result[1]);
                                //$('#btngenorderinvoice').show();
                                //transfer_clearorder();
                                //transfer_openOrder(result[1]);
                                toastr.success('Order updated!', 'Done!');
                                location.reload();
                            } else {
                                swal({
                                    title: "Error",
                                    //text: result[1],
                                    type: "error",
                                    confirmButtonText: 'OK!'
                                });
                            }
                        }
                    });
                } else {
                    swal({
                        title: "You have not added any Products",
                        //text: 'Select Product and staff member providing that made the sale.',
                        type: "warning",
                        confirmButtonText: 'OK!'
                    });
                }
//                } else { //update existing order
//                    var TableData;
//                    TableData = transfer_storeOTblValues();
//                    TableData = $.toJSON(TableData);
//                    if (TableData.length > 2) {
//                        $.ajax({
//                            type: "POST",
//                            url: "order_controller/updateorder",
//                            data: "&orderdata=" + TableData + "&orderid=" + $("#order-id").val(),
//                            success: function(data) {
//                                var result = data.split("|");
//                                if (result[0] === "success") {
//                                    //transfer_clearorder();
//                                    //transfer_openOrder(result[1]);
//                                    //$('#btngenorderinvoice').show();
//                                    toastr.success('Order Updated!', 'Done!');
//                                } else {
//                                    swal({
//                                        title: "Error",
//                                        text: result[1],
//                                        type: "error",
//                                        confirmButtonText: 'OK!'
//                                    });
//                                }
//                            }
//                        });
//                    } else {
//                        swal({
//                            title: "You have not added any Products",
//                            text: 'Select Product and staff member providing that made the sale.',
//                            type: "error",
//                            confirmButtonText: 'OK!'
//                        });
//                    }
//                }
            }
            
            function brandeditchange(){
                    
                    var brandid = $('#brandedit').val();
                    console.log(brandid);
                    if (brandid && brandid !== "") {
                        $(".loader").fadeIn("slow");
                        $("#productedit").select2('val', 'All');
                        $.ajax({
                            type: 'POST',
                            //url: '<?php //echo base_url("purchaseorder_controller/brand_product");    ?>/' + brandid,
                            url: '<?php echo base_url("purchaseorder_controller/brand_product"); ?>',
                            data: {brandid: brandid, businessid: $("#businessid option:selected").val()},
                            dataType: "json",
                            cache: false,
                            async: true,
                            success: function(data) {
                                console.log(data);
                                //$('#product').html('');
                                $('#productedit').html('');
                                if (data.length > 0) {
                                    for (var i = 0; i < data.length; i++) {
                                        //$('#product').append('<option product-price = ' + data[i]['purchase_price'] + ' value = ' + data[i]['id_business_products'] + '>' + data[i]['product'] + '</option>');
                                        $('#productedit').append('<option product-price = ' + data[i]['purchase_price'] + ' value = ' + data[i]['id_business_products'] + '>' + data[i]['product'] + '</option>');
                                    }
                                } else {
                                    //$('#product').append('<option value = ""></option>');
                                    $('#productedit').append('<option value = ""></option>');
                                }
                            }
                        });
                        $(".loader").fadeOut("slow");
                    }
                }
         
        </script>
