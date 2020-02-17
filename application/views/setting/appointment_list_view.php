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
                <h4 class="page-title" >All Appointments</h4>
            </div>
        </div>
        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <h4 class="header-title m-t-0 m-b-30">Selection:</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-12"> <label for="txtappointmentdate" class="control-label">Select Date</label></div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="yyyy/mm/dd" id="txtappointmentdate" name="txtappointmentdate">
                                                        <span class="input-group-addon bg-info b-0 text-white"><i class="ti-calendar"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>                                
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">Run Appointment</label></div>
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

                    <table id="tblreport" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th >Ready</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>Run Appointment</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

        <!--Modals-->


        <!--Edit Product Modal-->
        <div id="editbusinessproduct" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editbusinessproduct" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Product</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditbusinessproductid" class="control-label">ID</label>
                                    <input readonly="readonly" type="text" class="form-control" placeholder="Product ID" id="txteditbusinessproductid" name="txteditbusinessproductid">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditproduct" class="control-label">Product Name</label>
                                    <input type="text" class="form-control" placeholder="Product Name" id="txteditproduct" name="txteditproduct">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditsku" class="control-label">SKU</label>
                                    <input type="text" class="form-control" placeholder="SKU" id="txteditsku" name="txteditsku">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditprice" class="control-label">Price</label>
                                    <input type="text" class="form-control" placeholder="Price" id="txteditprice" name="txteditprice">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditpurchaseprice" class="control-label">Purchase Price</label>
                                    <input type="text" class="form-control" placeholder="Purchase Price" id="txteditpurchaseprice" name="txteditpurchaseprice">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditinstock" class="control-label">In Stock</label>
                                    <input type="text" class="form-control numeric" placeholder="In Stock" id="txteditinstock" name="txteditinstock">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditmeasurementunit" class="control-label">Measurement Unit</label>
                                    <input type="text" class="form-control" placeholder="Measurement Unit" id="txteditmeasurementunit" name="txteditmeasurementunit">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditproductactive" class="control-label">Active</label>
                                    <select class="form-control" id="txteditproductactive" name="txteditproductactive">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>

                                </div> 
                            </div> 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="update();" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Edit Product Modal-->

        <script>
            $(document).ready(function() {

                $('#tblreport').DataTable({
                    dom: "Bfrtip",
                    buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"},
                        {extend: "excel", className: "btn-sm btn-warning btn-trans"}, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}],
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

                jQuery('#txtappointmentdate').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy/mm/dd'
                });

            });


            function appointment_list(datetime) {
                $("#cog").show();
                $.ajax({
                    type: 'POST',
                    url: 'appointment_controller/show_appointments',
                    data: {date: datetime},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        //var data = JSON.stringify(data);
                        //console.log(data);
                        var hhtml = "<tr><th>Time</th><th>Customer</th><th>Service</th><th>Staff</th></tr>"

                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {

                            mhtml += '<tr>';
                            mhtml += '<td><span class="label label-info">' + data[x]['datetime'] + '</span></td>';
                            mhtml += '<td><span class="label label-primary">' + data[x]['customer_name'] + '</span></td>';
                            mhtml += '<td>' + data[x]['service_name'] + '</td>';
                            mhtml += '<td>' + data[x]['staff_names'] + '</td>';
                            mhtml += '</tr>';
                        }
                        //console.log(mhtml);
                        $("#tblreport").dataTable().fnDestroy();
                        $("#tblreport thead").html('');
                        $("#tblreport tbody").html('');
                        $("#tblreport thead").append(hhtml);
                        $("#tblreport tbody").append(mhtml);
                        
                        
                        $('#tblreport').DataTable({
                            dom: "Bfrtlip",
                            buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"}, {
                                    extend: "excel",
                                    className: "btn-sm btn-warning btn-trans"
                                }, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}, {extend: "print", className: "btn-sm btn-info btn-trans"}],
                            responsive: !0
                        });
                        $("#cog").hide();

                    }
                });
            }


            function runreport() {
                var datetime = $('#txtappointmentdate').val();
                if (datetime) {
                    appointment_list(datetime);
                }

            }


        </script>