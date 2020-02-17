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
                <h4 class="page-title" >All Vouchers</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">

                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th >ID</th>
                                <th>Customer</th>
                                <th>Voucher</th>
                                <th>Type</th>
                                <th>Services</th>
                                <th>Amount</th>
                                <th>Remaining amount</th>
                                <th>Created on</th>
                                <th>Valid</th>
                                <th>Status</th>
                                <th class="noprint">View</th>
                                <th class='noprint' style="width: 80px;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (isset($voucher_list)) {
                                foreach ($voucher_list as $voucher) {
                                    ?>
                                    <tr>
                                        <td><?php echo $voucher['id_order_vouchers']; ?></td>
                                        <td><?php echo $voucher['customer_name']; ?></td>
                                        <td><?php echo $voucher['voucher_number']; ?></td>
                                        <td><?php echo $voucher['type']; ?></td>
                                        <td>
                                            <?php
                                            if ($voucher['type'] == "service") {
                                                foreach (explode("|", $voucher['service_names']) as $service) {
                                                    echo $service . ",<br>";
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $voucher['amount']; ?></td>
                                        <td><?php echo $voucher['remaining_amount'] != 0 ? $voucher['remaining_amount'] : ""; ?></td>
                                        <td><?php echo $voucher['date']; ?></td>
                                        <td><?php echo date('Y-m-d',strtotime($voucher['valid_date'])) > date('Y-m-d',  time()) ? "<span class='label label-info'>".$voucher['valid_date']." Valid</span>" : "<span class='label label-danger'>".$voucher['valid_date']." Expired</span>"; ?></td>
                                        <td><span class="label <?php if($voucher['voucher_status'] == "open"){ ?>label-success<?php } ?><?php if($voucher['voucher_status'] == "close"){ ?>label-inverse<?php } ?>"><?php echo $voucher['voucher_status']; ?></span></td>
                                        <td class='noprint'>
                                            <a target="_blank" class="btn btn-primary" href="<?php echo base_url('viewvoucher') . "/" . $voucher['id_order_vouchers']; ?>"><span class="fa fa-print"></span></a>
                                        </td>
                                        <td class='noprint' > 
                                            <button id='btnedit' onclick="javascript:openedit('<?php echo $voucher['id_order_vouchers']; ?>', '<?php echo $voucher['customer_name']; ?>', '<?php echo date('Y-m-d', strtotime($voucher['valid_date'])); ?>', '<?php echo $voucher['type']; ?>');" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-pencil"></i> </button>
                                            <button id='btndlt' onclick="javascript:delete_voucher('<?php echo $voucher['id_order_vouchers']; ?>');" class="btn btn-icon waves-effect waves-light btn-danger m-b-5"> <i class="fa fa-trash-o"></i> </button>
                                        </td>
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

        <!--Modals start-->
        <div id="editvoucher" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editvoucher" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="updateForm" action="<?php echo base_url('voucher_controller/voucher_update'); ?>" method="POST">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="custom-width-modalLabel">Edit Voucher</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtcustomername" class="control-label">Customer Name</label>
                                                <input readonly type="text" class="form-control" placeholder="Customer Name" id="txtcustomername" name="txtcustomername" tabindex=1>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label" for="voucher-valid-until">Valid Until</label>
                                                <input required id="voucher-valid-until" name="voucher-valid-until" class="form-control" type="text" tabindex=2>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtservicetype" class="control-label">Type</label>
                                                <input readonly type="text" class="form-control" placeholder="Service Type" id="txtservicetype" name="txtservicetype" tabindex=3>
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="txtvoucherid" id="txtvoucherid" />
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal" tabindex=11>Close</button>
                            <button onclick="voucher_update();" type="submit" class="btn btn-custom waves-effect waves-light" tabindex=10><span id="icon-spinner">Save</span></button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--Modals end-->
        <script>
            $(document).ready(function() {

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

                $('#voucher-valid-until').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy-mm-dd'
                });

                $('#updateForm').on('submit', function(e) {
                    e.preventDefault();

                    $('#icon-spinner').text('');
                    $('#icon-spinner').attr('class', 'fa fa-spin fa-spinner');
                    $('#icon-spinner').attr('aria-hidden', 'true');

                    $.ajax({
                        url: $(this).attr('action') || window.location.pathname,
                        type: "POST",
                        data: 'id_order_vouchers=' + $('#txtvoucherid').val() + '&valid_until=' + $('#voucher-valid-until').val(),
                        success: function(data) {
                            if (data == "success") {
                                toastr.success('Successfully Updated!');
                                location.reload();
                            } else {
                                toastr.error('Something went wrong!');
                            }
                        },
                        error: function(jXHR, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                });

            });

            function openedit(id, customer, valid, type) {
                $('#txtvoucherid').val(id);
                $('#txtcustomername').val(customer);
                $('#txtservicetype').val(type);
                $('#voucher-valid-until').val(valid);
                $("#editvoucher").modal("show");
            }

            function delete_voucher(id) {

                //Warning Message
                swal({
                    title: "Are you sure?",
                    text: "This action will remove Voucher!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn-warning',
                    confirmButtonText: "Yes, remove it!",
                    closeOnConfirm: true
                }, function() {
                    $.ajax({
                        type: 'POST',
                        //url: '<?php echo base_url() . 'delete_voucher' ?>/' + id,
                        url: '<?php echo base_url() . 'delete_voucher' ?>',
                        data: {id: id},
                        success: function(data) {
                            var result = data.split("|");

                            if (result[0] === "success") {
                                swal("Deleted!", "Voucher has been removed.", "success");
                                location.reload();
                            } else {
                                swal("Error!", "Voucher was not removed!.", "error");
                            }
                        }
                    });
                });
            }

        </script>
        
        