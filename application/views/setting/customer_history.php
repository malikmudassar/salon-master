<style>
    .red{
        border-radius:20px; background: red; width: 20px; padding: 2px 8px;
    }
    .green{
        border-radius:20px; background: green; width: 20px; padding: 2px 8px;
    }
    .blue{
        border-radius:20px; background: #71b6f9; width: 20px; padding: 2px 8px;
    }
</style>
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                
                <h4 class="page-title">History</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="header-title m-t-0 m-b-30">Customer: <?php echo isset($customer[0]['customer_name']) ? $customer[0]['customer_name'] : ""; ?></h4>

                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Invoice ID</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Category</th>
                                <th>Services</th>
                                <th>Products</th>
                                <th>Staff</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customer_history as $history) { ?>
                                <tr>
                                    <td><?php echo $history['id_invoice']; ?></td>
                                    <td><span class="label label-info"><?php echo $history['invoice_date']; ?></span></td>
                                    <td><span class="label label-success"><?php echo $history['day']; ?></span></td>
                                    <td><?php echo $history['service_category']; ?></td>
                                    <td><?php echo $history['service_name']; ?></td>
                                    <td><?php echo $history['products']; ?></td>
                                    <td>
                                        <?php 
                                        $array = explode("|",$history['staff']);
                                        foreach ($array as $staff){
                                            echo $staff != "" ? $staff."," : "";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

        <!--Modals-->

        <!--Add Supplier Modal-->
        <div id="addcustomer" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addcustomer" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new Customer</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcustomername" class="control-label">Name</label>
                                            <input tabindex="1" type="text" class="form-control" placeholder="Customer Name" id="txtcustomername" name="txtcustomername">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcustomerphone1" class="control-label">Phone 1</label>
                                            <input tabindex="3" type="text" class="form-control numeric" placeholder="Customer Phone 1" id="txtcustomerphone1" name="txtcustomerphone1">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcustomertype" class="control-label">Type</label>
                                            <select tabindex="5" name="txtcustomertype" id="txtcustomertype" class="form-control">
                                                <option disabled selected value="">Select type</option>
                                                <option value="red">Red</option>
                                                <option value="green">Green</option>
                                                <option value="blue">Blue</option>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcustomercell" class="control-label">Cell</label>
                                            <input tabindex="2" type="text" class="form-control numeric" placeholder="Customer Cell" id="txtcustomercell" name="txtcustomercell">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcustomerphone2" class="control-label">Phone 2</label>
                                            <input tabindex="4" type="text" class="form-control numeric" placeholder="Customer Phone 2" id="txtcustomerphone2" name="txtcustomerphone2">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcustomeremail" class="control-label">Email</label>
                                            <input tabindex="6" type="email" class="form-control" placeholder="Customer Email" id="txtcustomeremail" name="txtcustomeremail">
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
                                            <label for="txtcustomeraddress" class="control-label">Address</label>
                                            <input tabindex="7" type="text" class="form-control " placeholder="Customer Address" id="txtcustomeraddress" name="txtcustomeraddress">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="row m-b-5">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="txtcustomeranniversary" class="control-label">Wedding Anniversary</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <input tabindex="8" type="text" class="form-control" placeholder="yyyy/mm/dd" id="txtcustomeranniversary" name="txtcustomeranniversary">
                                            <span class="input-group-addon bg-info b-0 text-white"><i class="ti-calendar"></i></span>
                                        </div><!-- input-group -->
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <label for="txtcustomerbirthday" class="control-label">Birthday</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select tabindex="9" id="txtcustomerbirthday" name="txtcustomerbirthday" class="form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-8">
                                        <select tabindex="10" id="txtcustomerbirthmonth" name="txtcustomerbirthmonth" class="form-control">
                                            <option value=""></option>
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcustomerallergies" class="control-label text-danger">Allergies Alert</label>
                                            <input tabindex="11" type="text" class="form-control " placeholder="Note down any allergies the customer may have" id="txtcustomerallergies" name="txtcustomerallergies">
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
                                            <label for="txtcustomeralert" class="control-label text-warning">Customer Alert</label>
                                            <input tabindex="12" type="text" class="form-control " placeholder="Note down any other alerts you want to get when the customer visits . . ." id="txtcustomeralert" name="txtcustomeralert">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button tabindex="13" onclick="addnew();" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Service Category Modal-->

        <!--Edit Supplier Modal-->
        <div id="editcustomer" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editsupplier" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Customer</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcustomername" class="control-label">Name</label>
                                            <input tabindex="1" type="text" class="form-control" placeholder="Customer Name" id="txteditcustomername" name="txteditcustomername">
                                        </div> 
                                    </div> 
                                </div>                               
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcustomerphone1" class="control-label">Phone 1</label>
                                            <input tabindex="3" type="text" class="form-control numeric" placeholder="Customer Phone 1" id="txteditcustomerphone1" name="txteditcustomerphone1">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcustomertype" class="control-label">Type</label>
                                            <select tabindex="5" name="txteditcustomertype" id="txteditcustomertype" class="form-control">
                                                <option disabled selected value="">Select type</option>
                                                <option value="red">Red</option>
                                                <option value="green">Green</option>
                                                <option value="blue">Blue</option>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcustomercell" class="control-label">Cell</label>
                                            <input tabindex="2" type="text" class="form-control numeric" placeholder="Customer Cell" id="txteditcustomercell" name="txteditcustomercell">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcustomerphone2" class="control-label">Phone 2</label>
                                            <input tabindex="4" type="text" class="form-control numeric" placeholder="Customer Phone 2" id="txteditcustomerphone2" name="txteditcustomerphone2">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcustomeremail" class="control-label">Email</label>
                                            <input tabindex="6" type="text" class="form-control" placeholder="Customer Email" id="txteditcustomeremail" name="txteditcustomeremail">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditcustomeraddress" class="control-label">Address</label>
                                    <input tabindex="7" type="text" class="form-control" placeholder="Address" id="txteditcustomeraddress" name="txteditcustomeraddress">
                                </div> 
                            </div> 
                        </div>
                        <div class="row m-b-5">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="txteditcustomeranniversary" class="control-label">Wedding Anniversary</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <input tabindex="8" type="text" class="form-control" placeholder="yyyy/mm/dd" id="txteditcustomeranniversary" name="txteditcustomeranniversary">
                                            <span class="input-group-addon bg-info b-0 text-white"><i class="ti-calendar"></i></span>
                                        </div><!-- input-group -->
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <label for="txteditcustomerbirthday" class="control-label">Birthday</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select tabindex="9" id="txteditcustomerbirthday" name="txteditcustomerbirthday" class="form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-8">
                                        <select tabindex="10" id="txteditcustomerbirthmonth" name="txteditcustomerbirthmonth" class="form-control">
                                            <option value=""></option>
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcustomerallergies" class="control-label text-danger">Allergies Alert</label>
                                            <input tabindex="11" type="text" class="form-control " placeholder="Note down any allergies the customer may have" id="txteditcustomerallergies" name="txteditcustomerallergies">
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
                                            <label for="txteditcustomeralert" class="control-label text-warning">Customer Alert</label>
                                            <input tabindex="12" type="text" class="form-control " placeholder="Note down any other alerts you want to get when the customer visits . . ." id="txteditcustomeralert" name="txteditcustomeralert">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <input tabindex="13" type="hidden" id="txteditcustomerid" name="txteditcustomerid">
                        <button onclick="update();" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Edit Service Category Modal-->

        <script type="text/javascript">
            $(document).ready(function() {
                fillBday();

                $('#datatable-buttons').DataTable({
                    dom: "Bfrtip",
                    buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"},
                        {extend: "excel", className: "btn-sm btn-warning btn-trans"}, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}],
                    responsive: !0,
                    "order": [[ 0, "desc" ]]
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

                jQuery('#txteditcustomeranniversary').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy/mm/dd'
                });

                jQuery('#txtcustomeranniversary').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy/mm/dd'
                });

                $(".numeric").keypress(function(e) {
                    //if the letter is not digit then display error and don't type anything
                    if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                        return false;
                    }
                });
            });

            function openupdate(id, name, cell, phone1, phone2, address, email, birthday, birthmonth, allergies, anniversay, allert, customertype) {

                $("#txteditcustomerid").val(id);
                $("#txteditcustomername").val(name);
                $("#txteditcustomercell").val(cell);
                $("#txteditcustomerphone1").val(phone1);
                $("#txteditcustomerphone2").val(phone2);
                $("#txteditcustomeraddress").val(address);
                $("#txteditcustomeremail").val(email);
                $("#txteditcustomerbirthday").val(birthday);
                $("#txteditcustomerbirthmonth").val(birthmonth);
                $("#txteditcustomerallergies").val(allergies);
                $("#txteditcustomeranniversary").val(anniversay);
                $("#txteditcustomeralert").val(allert);
                $("#txteditcustomertype").val(customertype);

                $("#editcustomer").modal('show');
            }
            function update() {
                if ($("#txteditcustomerid").val() !== "") {
                    $.ajax({
                        type: 'POST',
                        url: 'customer_controller/update_customer',
                        data: {id_customer: $("#txteditcustomerid").val(), customer_name: $("#txteditcustomername").val(), customer_cell: $("#txteditcustomercell").val(), customer_phone1: $("#txteditcustomerphone1").val(), customer_phone2: $("#txteditcustomerphone2").val(), customer_address: $("#txteditcustomeraddress").val(), customer_birthday: $("#txteditcustomerbirthday").val(), customer_birthmonth: $("#txteditcustomerbirthmonth").val(), customer_email: $("#txteditcustomeremail").val(), customer_anniversary: $("#txteditcustomeranniversary").val(), customer_allergies: $("#txteditcustomerallergies").val(), customer_alert: $("#txteditcustomeralert").val(), customer_type: $("#txteditcustomertype").val()},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Customer Updated');
                                location.reload();
                            }
                        }
                    });
                }
            }

            function openaddnew() {
                $("#addcustomer").modal('show');
            }
            function addnew() {
                if ($("#txtcustomername").val() !== "") {
                    $.ajax({
                        type: 'POST',
                        url: 'customer_controller/add_customer',
                        data: {customer_name: $("#txtcustomername").val(), customer_cell: $("#txtcustomercell").val(), customer_phone1: $("#txtcustomerphone1").val(), customer_phone2: $("#txtcustomerphone2").val(), customer_address: $("#txtcustomeraddress").val(), customer_birthday: $("#txtcustomerbirthday").val(), customer_birthmonth: $("#txtcustomerbirthmonth").val(), customer_email: $("#txtcustomeremail").val(), customer_anniversary: $("#txtcustomeranniversary").val(), customer_allergies: $("#txtcustomerallergies").val(), customer_alert: $("#txtcustomeralert").val(), customer_type: $("#txtcustomertype").val()},
                        success: function(data) {
                            console.log(data);
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'New Customer Added');
                                location.reload();
                            }
                        }
                    });
                }
            }

            function fillBday() {
                for (x = 1; x <= 31; x++) {
                    $("#txt-customer-bday").append('<option value=' + x + '>' + x + '</option>');
                    $("#txtcustomerbirthday").append('<option value=' + x + '>' + x + '</option>');
                    $("#txteditcustomerbirthday").append('<option value=' + x + '>' + x + '</option>');

                }
            }

        </script>
