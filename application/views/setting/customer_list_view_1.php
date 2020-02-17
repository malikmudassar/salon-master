<style>
    .red{
        border-radius:20px; background: red; width: 20px; padding: 2px 8px;
    }
    .green{
        border-radius:20px; background: rgb(49, 224, 49); width: 20px; padding: 2px 8px;
    }
    .orange{
        border-radius:20px; background: orange; width: 20px; padding: 2px 8px;
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
                <h4 class="page-title">Customers</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Customer ID</th>
                                <th>Customer Name</th>
                                <th>Loyalty Card</th>
                                <th>Loyalty Earned</th>
                                <th>Loyalty Used</th>
                                <th>Available Points</th>
                                <th>Care Of</th>                                
                                <th>Cell</th>                                
                                <th>Email</th>
                                <th>Address</th>
                                <th>Profession</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers as $customer) { ?>
                                <tr>
                                    <td><?php echo $customer['id_customers']; ?></td>
                                    <td><?php echo $customer['customer_name']; ?></td>
                                    <td><?php echo $customer['customer_card']; ?></td>
                                    <td><?php echo $customer['earned']; ?></td>
                                    <td><?php echo $customer['used']; ?></td>
                                    <td><?php echo $customer['customer_loyalty_points']; ?></td>
                                    <td><?php echo $customer['customer_careof']; ?></td>
                                    <td><?php echo $customer['customer_cell']; ?></td>
                                   
                                    <td><?php echo $customer['customer_email']; ?></td>
                                    <td><?php echo $customer['customer_address']; ?></td>
                                    <td><?php echo $customer['profession']; ?></td>
                                    <td><span class="<?php echo $customer['customer_type']; ?>" >&nbsp;</span></td>
                                    <td class='noprint'> 
                                        <input type="hidden" id="customername<?php echo $customer['id_customers']; ?>" value="<?php echo $customer['customer_name']; ?>">
                                        <button id='btnedit' onclick='openupdate(<?php echo $customer['id_customers']; ?>);' class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button>  
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

        <!--Add Customer Modal-->
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
                                                <option value=""></option>
                                                <option value="orange">Orange</option>
                                                <option value="green">Green</option>
                                                <option value="red">Red</option>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtcustomercell" class="control-label">Cell</label>
                                            <input tabindex="2" type="text" class="form-control numeric" placeholder="Customer Cell" id="txtcustomercell" name="txtcustomercell">
                                        </div> 
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtcustomergender" class="control-label">Gender</label>
                                            <select tabindex="2" type="text" class="form-control numeric" placeholder="Gender" id="txtcustomergender" name="txtcustomergender">
                                                <option value="F">Female</option>
                                                <option value="M">Male</option>
                                                
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtcustomerphone2" class="control-label">Phone 2</label>
                                            <input tabindex="4" type="text" class="form-control numeric" placeholder="Customer Phone 2" id="txtcustomerphone2" name="txtcustomerphone2">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtcustomercard" class="control-label">Card #</label>
                                            <input tabindex="4" type="text" class="form-control numeric" placeholder="Customer Card#" id="txtcustomercard" name="txtcustomercard">
                                        </div>
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcustomerprofession" class="control-label">Profession</label>
                                            <input tabindex="6" type="text" class="form-control" placeholder="Customer Profession" id="txtcustomerprofession" name="txtcustomerprofession">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtcustomeremail" class="control-label">Email</label>
                                            <input tabindex="7" type="email" class="form-control " placeholder="Customer Email" id="txtcustomeremail" name="txtcustomeremail">
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtcustomercareof" class="control-label">Care of (<span id="labeladdcustomercareof"></span>)</label>
                                            <input tabindex="7" onchange="onaddcareofchange();" type="text" class="form-control" placeholder="Care Of" id="txtcustomercareof" name="txtcustomercareof">
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
                                            <input tabindex="8" type="text" class="form-control " placeholder="Customer Address" id="txtcustomeraddress" name="txtcustomeraddress">
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
                                            <input tabindex="9" type="text" class="form-control" placeholder="yyyy/mm/dd" id="txtcustomeranniversary" name="txtcustomeranniversary">
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
                                        <select tabindex="10" id="txtcustomerbirthday" name="txtcustomerbirthday" class="form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-8">
                                        <select tabindex="11" id="txtcustomerbirthmonth" name="txtcustomerbirthmonth" class="form-control">
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
                                            <input tabindex="12" type="text" class="form-control " placeholder="Note down any allergies the customer may have" id="txtcustomerallergies" name="txtcustomerallergies">
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
                                            <input tabindex="13" type="text" class="form-control " placeholder="Note down any other alerts you want to get when the customer visits . . ." id="txtcustomeralert" name="txtcustomeralert">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button tabindex="14" onclick="addnew();" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Service Category Modal-->

        <!--Edit Customer Modal-->
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
                                                <option value=""></option>
                                                <option value="orange">Orange</option>
                                                <option value="green">Green</option>
                                                <option value="red">Red</option>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txteditcustomercell" class="control-label">Cell</label>
                                            <input tabindex="2" type="text" class="form-control numeric" placeholder="Customer Cell" id="txteditcustomercell" name="txteditcustomercell">
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txteditcustomergender" class="control-label">Gender</label>
                                            <select tabindex="2" type="text" class="form-control numeric" placeholder="Gender" id="txteditcustomergender" name="txteditcustomergender">
                                                <option value="F">Female</option>
                                                <option value="M">Male</option>
                                                
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row">
                                   
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txteditcustomerphone2" class="control-label">Phone 2</label>
                                            <input tabindex="4" type="text" class="form-control numeric" placeholder="Customer Phone 2" id="txteditcustomerphone2" name="txteditcustomerphone2">
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txteditcustomercard" class="control-label">Card #</label>
                                            <input tabindex="4" type="text" class="form-control numeric" placeholder="Customer Card#" id="txteditcustomercard" name="txteditcustomercard">
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcustomerprofession" class="control-label">Profession</label>
                                            <input tabindex="6" type="text" class="form-control" placeholder="Customer Profession" id="txteditcustomerprofession" name="txteditcustomerprofession">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txteditcustomeremail" class="control-label">Email</label>
                                    <input tabindex="7" type="text" class="form-control" placeholder="Email" id="txteditcustomeremail" name="txteditcustomeremail">
                                </div> 
                            </div> 
                             
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txteditcustomercareof" class="control-label">Care of (<span id="labelcustomercareof"></span>)</label>
                                    <input tabindex="7" onchange="oncareofchange();" type="text" class="form-control" placeholder="Care Of" id="txteditcustomercareof" name="txteditcustomercareof">
                                </div> 
                            </div> 
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditcustomeraddress" class="control-label">Address</label>
                                    <input tabindex="8" type="text" class="form-control" placeholder="Address" id="txteditcustomeraddress" name="txteditcustomeraddress">
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
                                            <input tabindex="9" type="text" class="form-control" placeholder="yyyy/mm/dd" id="txteditcustomeranniversary" name="txteditcustomeranniversary">
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
                                        <select tabindex="10" id="txteditcustomerbirthday" name="txteditcustomerbirthday" class="form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-8">
                                        <select tabindex="11" id="txteditcustomerbirthmonth" name="txteditcustomerbirthmonth" class="form-control">
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
                                            <input tabindex="12" type="text" class="form-control " placeholder="Note down any allergies the customer may have" id="txteditcustomerallergies" name="txteditcustomerallergies">
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
                                            <input tabindex="13" type="text" class="form-control " placeholder="Note down any other alerts you want to get when the customer visits . . ." id="txteditcustomeralert" name="txteditcustomeralert">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <input tabindex="14" type="hidden" id="txteditcustomerid" name="txteditcustomerid">
                        <button onclick="update();" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Edit Service Category Modal-->

        <script type="text/javascript">
            $(document).ready(function() {

                $('#addcustomer').on('shown.bs.modal', function() {
                    $('#txtcustomername').focus();
                });
                $('#editcustomer').on('shown.bs.modal', function() {
                    $('#txteditcustomername').focus();
                });

                fillBday();

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

            function openupdate(id_customers) {
                //var name = $('#customername' + id).val();
                //console.log($(this));
                
                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>customer_controller/edit_customers',
                    data: {id_customers: id_customers},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        
                        $("#txteditcustomerid").val(id_customers);
                        $("#txteditcustomername").val(data.customer_name);
                        $("#txteditcustomercell").val(data.customer_cell);
                        $("#txteditcustomergender").val(data.customer_gender);
                        $("#txteditcustomerphone1").val(data.customer_phone1);
                        $("#txteditcustomerphone2").val(data.customer_phone2);
                        $("#txteditcustomercard").val(data.customer_card);
                        $("#txteditcustomeraddress").val(data.customer_address);
                        $("#txteditcustomeremail").val(data.customer_email);
                        $("#labelcustomercareof").html(data.customer_careof);
                        enable_detailcareof();
                        $("#txteditcustomerbirthday").val(data.customer_birthday);
                        $("#txteditcustomerbirthmonth").val(data.customer_birthmonth);
                        $("#txteditcustomerallergies").val(data.customer_allergies);
                        $("#txteditcustomeranniversary").val(data.customer_anniversary);
                        $("#txteditcustomeralert").val(data.customer_alert);
                        $("#txteditcustomertype").val(data.customer_type);
                        $('#txteditcustomerprofession').val(data.profession);

                        $("#editcustomer").modal('show');
                        
                    }
                });
            }

            function update() {
                customer_submit_update();

            }
            
            function customer_submit_update(){
                $.ajax({
                    type: 'POST',
                    url: 'customer_controller/update_customer',
                    data: {id_customer: $("#txteditcustomerid").val(), 
                        customer_name: $("#txteditcustomername").val(), 
                        customer_cell: $("#txteditcustomercell").val(), 
                        customer_gender: $("#txteditcustomergender").val(), 
                        customer_phone1: $("#txteditcustomerphone1").val(), 
                        customer_phone2: $("#txteditcustomerphone2").val(), 
                        customer_card: $("#txteditcustomercard").val(), 
                        customer_address: $("#txteditcustomeraddress").val(), customer_birthday: $("#txteditcustomerbirthday").val(), customer_birthmonth: $("#txteditcustomerbirthmonth").val(), customer_email: $("#txteditcustomeremail").val(), customer_careof:$("#txteditcustomercareof").val(), customer_anniversary: $("#txteditcustomeranniversary").val(), customer_allergies: $("#txteditcustomerallergies").val(), customer_alert: $("#txteditcustomeralert").val(), customer_type: $("#txteditcustomertype").val(), profession: $('#txteditcustomerprofession').val()},
                    success: function(data) {
                        var result = data.split("|");
                        if (result[0] === "success") {
                            toastr.success(data, 'Customer Updated');
                            location.reload();
                        }
                    }
                });
            }
            
            function oncareofchange(){
                var data = $("#txteditcustomercareof").select2('data');

                if($("#txteditcustomercell").val()===""){
                    $("#txteditcustomercell").val(data.customer_cell);
                }
            }

            function onaddcareofchange(){
                var data = $("#txtcustomercareof").select2('data');

                if($("#txtcustomercell").val()===""){
                    $("#txtcustomercell").val(data.customer_cell);
                }
            }    
            function enable_detailcareof(){
            $("#txteditcustomercareof").select2({
                 ajax: {
                   url: '<?php echo base_url();?>customer_controller/searchnameforco',
                   dataType: 'json',
                   delay: 250,
                   data: function (term, page) {

                     return {
                         customername: term, // search term
                         page_limit: 30, // page size
                         page: page // page number
                     };
                   },
                   results: function (data, page) {

                         var more = (page * 30) < data.length;
                         return {results: data, more: more};
                     }
                   },
                 escapeMarkup: function (m) { return m; }, // let our custom formatter work
                 minimumInputLength: 3,
                 formatResult: function (option) {
                    return option.customer_name ;
                 },
                 formatSelection: function (option) {
                     return option.customer_name;
                 }
               });

         }
         function enable_addcareof(){
            $("#txtcustomercareof").select2({
                 ajax: {
                   url: '<?php echo base_url();?>customer_controller/searchnameforco',
                   dataType: 'json',
                   delay: 250,
                   data: function (term, page) {

                     return {
                         customername: term, // search term
                         page_limit: 30, // page size
                         page: page // page number
                     };
                   },
                   results: function (data, page) {

                         var more = (page * 30) < data.length;
                         return {results: data, more: more};
                     }
                   },
                 escapeMarkup: function (m) { return m; }, // let our custom formatter work
                 minimumInputLength: 3,
                 formatResult: function (option) {
                    return option.customer_name ;
                 },
                 formatSelection: function (option) {
                     return option.customer_name;
                 }
               });

         }
            function openaddnew() {
                enable_addcareof();
                $("#addcustomer").modal('show');
                
            }
            function addnew() {
                if ($("#txtcustomername").val() !== "") {
                    $("#txtcustomername").val(ucwords($("#txtcustomername").val()));
                    var customer_name = $("#txtcustomername").val().trim();
                    customer_name = customer_name.split(" ");
                    var existvalue = 0;
                    if (customer_name.length > 1) {
                        var customer_name = $("#txtcustomername").val();
                        var customer_cell = $("#txtcustomercell").val();
                        customer_cell = customer_cell || null;
                        if (customer_exist(customer_name, customer_cell)) {
                            var exist = customer_exist(customer_name, customer_cell);
                            var name = "name "+customer_name;
                            var cell = "cell "+customer_cell;
                            if(exist === name){
                                swal({
                                    title: "Customer Name and cell number already exists!",
                                    text: "Add another ?",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Yes",
                                    cancelButtonText: "No",
                                    closeOnConfirm: true,
                                    closeOnCancel: true
                                  },
                                  function(isConfirm){
                                      if (isConfirm) {
                                        customer_submit();
                                      } else {
                                          $("#addcustomer").modal('hide');
                                          $("#addcustomer input").val('');
                                        //swal("Cancelled", "Your imaginary file is safe :)", "error");
                                      }
                                  });
                            }else if(exist === cell){
                                swal({
                                    title: "Cell number already exists!",
                                    text: "",
                                    type: "error",
                                    confirmButtonText: 'OK!'
                                });
                                swal({
                                    title: "Cell number already exists!",
                                    text: "Add another ?",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Yes",
                                    cancelButtonText: "No",
                                    closeOnConfirm: true,
                                    closeOnCancel: true
                                  },
                                  function(isConfirm){
                                      if (isConfirm) {
                                        customer_submit();
                                      } else {
                                          $("#addcustomer").modal('hide');
                                          $("#addcustomer input").val('');
                                        //swal("Cancelled", "Your imaginary file is safe :)", "error");
                                      }
                                  });
                            }else{
                                customer_submit();
                            }
                        }else{
                            customer_submit();
                        }
                    } else {
                        swal({
                            title: "Please enter Customer's last name also!",
                            text: "",
                            type: "error",
                            confirmButtonText: 'OK!'
                        });
                    }
                }
            }

            function customer_exist(name,cell) {
                cell = cell || null;
                var res;
                $.ajax({
                    type: 'POST',
                    url: 'customer_controller/customer_exist',
                    data: {customer_name: name, customer_cell: cell},
                    async: false,
                    success: function(response) {
                        res = response;
                    }
                });
                return res;
            }
            
            function customer_update_exist(customer_id, name, cell) {
                cell = cell || null;
                var res;
                $.ajax({
                    type: 'POST',
                    url: 'customer_controller/customer_update_exist',
                    data: {customer_name: name, customer_cell: cell, customer_id: customer_id},
                    async: false,
                    success: function(response) {
                        res = response;
                    }
                });
                return res;
            }
            
            function customer_submit(){
                $.ajax({
                    type: 'POST',
                    url: 'customer_controller/add_customer',
                    data: {customer_name: $("#txtcustomername").val(), 
                        customer_cell: $("#txtcustomercell").val(), 
                        customer_gender: $("#txtcustomergender").val(), 
                        customer_phone1: $("#txtcustomerphone1").val(), 
                        customer_phone2: $("#txtcustomerphone2").val(), 
                        customer_card: $("#txtcustomercard").val(), 
                        customer_address: $("#txtcustomeraddress").val(), customer_birthday: $("#txtcustomerbirthday").val(), customer_birthmonth: $("#txtcustomerbirthmonth").val(), 
                        customer_email: $("#txtcustomeremail").val(), customer_careof:$("#txtcustomercareof").val(), customer_anniversary: $("#txtcustomeranniversary").val(), customer_allergies: $("#txtcustomerallergies").val(), customer_alert: $("#txtcustomeralert").val(), customer_type: $("#txtcustomertype").val(), profession: $('#txtcustomerprofession').val()},
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
            
            function fillBday() {
                for (x = 1; x <= 31; x++) {
                    $("#txt-customer-bday").append('<option value=' + x + '>' + x + '</option>');
                    $("#txtcustomerbirthday").append('<option value=' + x + '>' + x + '</option>');
                    $("#txteditcustomerbirthday").append('<option value=' + x + '>' + x + '</option>');

                }
            }



        </script>
