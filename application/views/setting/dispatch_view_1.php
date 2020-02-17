<style type="text/css">
    @media print
    {
        .noprint {display:none;}
    }
</style>
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    <button type="button"  onclick="openaddnew();" class="btn btn-custom waves-effect waves-light" >Add <span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                </div>
                <h4 class="page-title" >Dispatch List</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">

                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Staff</th>
                                <th>Product</th>
                                <th>Dispatch Qty</th>
                                <th>Unit Type</th>
                                <th>Dispatch Date</th>
                                <th>Status</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (isset($dispatch_list)) {
                                foreach ($dispatch_list as $list) {
                                    ?>
                                    <tr>
                                        <td><?php echo $list['id_dispatch_note']; ?></td>
                                        <td><?php echo $list['staff_fullname']; ?></td>
                                        <td><?php echo $list['product']; ?></td>
                                        <td><?php echo $list['dispatch_qty']; ?></td>
                                        <td><?php echo $list['unit_type']; ?></td>
                                        <td><?php echo $list['dispatch_date']; ?></td>
                                        <td><?php echo $list['status']; ?></td>
                                        <td class='noprint'> <button id='btnedit<?php echo $list['id_dispatch_note']; ?>' <?php
                                            if ($list['status'] === "Cancelled") {
                                                echo "disabled";
                                            }
                                            ?> <?php //if ($list['status'] !== "Cancelled") { ?> onclick="cancel_dispatch(<?php echo $list['id_dispatch_note']; ?>, <?php echo $list['id_business_products']; ?>);" <?php //} ?> class="btn btn-icon waves-effect waves-light btn-info m-b-5">  Cancel </button>  </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

        <!--Modals-->

        <!--Add Service  Modal-->
        <div id="addservice" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addservice" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new Dispatch</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="addstaff" class="control-label">Staff Name</label>
                                            <select id="addstaff" name="addstaff" class="form-control">
                                                <?php
                                                if (isset($staff)) {
                                                    foreach ($staff as $st) {
                                                        ?>
                                                        <option value="<?php echo $st['id_staff']; ?>"><?php echo $st['staff_fullname']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="adddate" class="control-label">Date</label>
                                            <input type="text" class="form-control" placeholder="Date" id="adddate" name="adddate">
                                        </div> 
                                    </div> 
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="addunitqty" class="control-label">Unit Qty</label>
                                            <input type="text" class="form-control numeric" placeholder="Dispatch Qty" id="addunitqty" name="addunitqty" onkeyup="unit_amount_cal();">
                                        </div> 
                                    </div> 
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="addproduct" class="control-label">Product Name</label>
                                            <select id="addproduct" name="addproduct" class="form-control" onchange="unitadd();
                                                    amount_cal();">
                                                        <?php
                                                        if (isset($product)) {
                                                            foreach ($product as $p) {
                                                                ?>
                                                        <option unittype="<?php echo $p['unit_type']; ?>" value="<?php echo $p['id_business_products']; ?>"><?php echo $p['product']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="addunittype" class="control-label">Unit Type</label>
                                            <input readonly type="text" class="form-control" placeholder="Unit Type" id="addunittype" name="addunittype">
                                            <input type="hidden" name="addremainqty" id="addremainqty" />
                                            <input type="hidden" name="addinhouse" id="addinhouse" />
                                        </div> 
                                    </div> 
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="addmeasureqty" class="control-label">Measurement Qty</label>
                                            <input type="text" class="form-control" placeholder="Measurement Qty" id="addmeasureqty" name="addmeasureqty" onkeyup="amount_cal();" >
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
                                                <th style="display:none;">Satff ID</th>
                                                <th>#</th>
                                                <th>Staff</th>
                                                <th>Product</th>
                                                <th>Unit Type</th>
                                                <th>Unit Qty</th>
                                                <th>Measure Qty</th>
                                                <th>Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                            <button onclick="addnew();" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
            <!--End Add Service  Modal-->

            <script>
                $(document).ready(function() {
                    unitadd();
                    $('#datatable-buttons').DataTable({
                        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        stateSave: true,
                        dom: "Bfrtlip",
                        buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"}, {
                                extend: "excel",
                                className: "btn-sm btn-warning btn-trans"
                            }, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}],
                        responsive: !0,
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

                    $(".numeric").keypress(function(e) {
                        //if the letter is not digit then display error and don't type anything
                        if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                            return false;
                        }
                    });

                    $("#addstaff").select2({
                        //maximumSelectionLength: 2
                        //formatNoMatches: Not_Found
                    });

                    $("#addproduct").select2({
                        //maximumSelectionLength: 2
                        //formatNoMatches: Not_Found
                    });

                    $('#adddate').datepicker({
                        autoclose: true,
                        todayHighlight: true,
                        format: 'yyyy-mm-dd'
                    });



                });

                function unit_amount_cal() {
                    var unit_amount = $('#addunitqty').val();
                    if (unit_amount && unit_amount > 0) {
                        var product_id = $('#addproduct option:selected').val();
                        var measure_amount = $('#addmeasureqty').val('');
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url(); ?>dispatch_controller/dispatch_unit_amount_cal',
                            dataType: "json",
                            cache: false,
                            async: true,
                            data: {
                                product_id: product_id,
                                //unit_amount: unit_amount
                            },
                            success: function(data) {
                                if (parseInt(unit_amount) <= data.inhouse_stock) {
                                    $('#addunitqty').val(unit_amount);
                                } else {
                                    $('#addunitqty').val('');
                                    swal({
                                        title: 'Alert',
                                        text: 'Unit Qty can not be greater than Inhouse stock!',
                                        type: 'warning',
                                        confirmButtonText: 'OK!'
                                    });
                                }

                            }
                        });
                    } else {
                        $('#addunitqty').val('');
                    }
                }

                function amount_cal() {
                    var amount = $('#addmeasureqty').val();
                    if (amount) {
                        var product_id = $('#addproduct option:selected').val();
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url(); ?>dispatch_controller/dispatch_measure_amount_cal',
                            dataType: "json",
                            cache: false,
                            async: true,
                            data: {
                                product_id: product_id,
                                measure_amount: amount
                            },
                            success: function(data) {
                                if (data) {
                                    $('#addunitqty').val(data.used_qty);
                                    $('#addremainqty').val(data.remain_qty);
                                    $('#addinhouse').val(data.inhouse_qty);
                                }

                            }
                        });
                    }
                }

                function unitadd() {
                    var unit_type = $('#addproduct option:selected').attr('unittype');
                    $('#addunittype').val(unit_type);
                }


                function cancel_dispatch(dispatch_note_id, product_id) {

                    //Warning Message
                    swal({
                        title: "Are you sure?",
                        text: "This action will be cancelled this dispatch!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: 'btn-warning',
                        confirmButtonText: "Yes, cancel it!",
                        closeOnConfirm: true
                    }, function() {
                        $.ajax({
                            type: 'POST',
                            url: 'dispatch_controller/cancel_dispatch',
                            data: {dispatch_note_id: dispatch_note_id, product_id: product_id},
                            success: function(data) {

                                var result = data.split("|");

                                if (result[0] === "success") {
                                    swal("Cancelled!", "Dispatch has been cancelled.", "success");
                                    location.reload();
                                } else {
                                    swal("Error!", "Dispatch was not cancelled!.", "error");
                                }
                            }
                        });
                    });
                }

                function openaddnew() {
                    $("#addservice").modal('show');
                }
                function addnew() {
                    var TableData;
                    TableData = retail_storeOTblValues();
                    TableData = $.toJSON(TableData);
                    if (TableData.length > 2) {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url(); ?>dispatch_controller/add_dispatch',
                            data: {
                                products: TableData,
                                dispatch_date: $('#adddate').val()
                            },
                            success: function(data) {
                                var result = data.split("|");
                                if (result[0] === "success") {
                                    toastr.success(data, 'New Dispatch Added');
                                    location.reload();
                                }
                            }
                        });
                    } else {
                        swal({
                            title: 'Required',
                            text: 'Please provide required fields',
                            type: 'warning',
                            confirmButtonText: 'OK!'
                        });
                    }
                }

                function addOrderRows() {

                    if ($("#addstaff").val() === "" || $("#addproduct").val() === "" || $("#addunitqty").val() === "" || $("#adddate").val() === "") {
                        swal({
                            title: "Staff/Product/Qty Unit & Date Should not be empty!",
                            type: "info",
                            confirmButtonText: 'OK!'
                        });
                        return false;
                    }

                    var mhtml = "";
                    var exists;
                    var count = 1;


                    $('#order-product-list').find("td.id").each(function(index) {
                        if ($(this).html() === $("#addproduct option:selected").val()) {
                            exists = 1;
                        }
                    });
                    mhtml += '<tr>';
                    mhtml += '<td style="display:none;">' + $("#addstaff").val() + '</td>';
                    mhtml += "<td class='id'>" + $("#addproduct option:selected").val() + "</td>";
                    mhtml += "<td>" + $("#addstaff option:selected").text() + "</td>";
                    mhtml += "<td>" + $("#addproduct option:selected").text() + "</td>";
                    mhtml += "<td>" + $("#addunittype").val() + "</td>";
                    mhtml += "<td >" + $("#addunitqty").val() + "</td>";
                    mhtml += "<td >" + $("#addmeasureqty").val() + "</td>";
                    mhtml += '<td><span class="label label-danger" onclick="removeproduct(' + $("#addproduct option:selected").val() + ')" style="cursor:pointer">x</span></td>';
                    mhtml += "</tr>";

                    if (exists !== 1) {
                        $("#addunitqty").val('');
                        $("#addmeasureqty").val('');
                        $("#order-product-list tbody").append(mhtml);
                    } else {
                        swal({
                            title: "Product already added!",
                            text: 'If you want to change this product, please remove and add again.',
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

                function retail_storeOTblValues() {
                    var TableData = new Array();
                    $('#ordertbl tr').each(function(row, tr) {
                        TableData[row] = {
                            "staffid": $(tr).find('td:eq(0)').text()
                            , "productid": $(tr).find('td:eq(1)').text()
                            , "unit_type": $(tr).find('td:eq(4)').text()
                            , "addunitqty": $(tr).find('td:eq(5)').text()
                            , "addmeasureqty": $(tr).find('td:eq(6)').text()

                        }
                    });
                    TableData.shift();  // first row will be empty - so remove
                    return TableData;
                }

            </script>