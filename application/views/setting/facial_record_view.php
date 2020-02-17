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
                <h4 class="page-title" >Facial Records</h4>
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
                                <th>Facial Name</th>
                                <th>Exfoliant</th>
                                <th>Mask</th>
                                <th>Cleanser</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Charge</th>
                                <th>Remarks</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (isset($facial_records)) {
                                foreach ($facial_records as $records) {
                                    ?>
                                    <tr>
                                        <td ><?php echo $records['id']; ?></td>
                                        <td><?php echo $records['customer']; ?></td>
                                        <td><?php echo $records['facial']; ?></td>
                                        <td><?php echo $records['exfoliant']; ?></td>
                                        <td><?php echo $records['mask']; ?></td>
                                        <td><?php echo $records['cleanser']; ?></td>
                                        <td><span class="label label-success"><?php echo $records['date']; ?></span></td>
                                        <td><span class="label label-warning"><?php echo $records['time']; ?></span></td>
                                        <td><?php echo $records['charge']; ?></td>
                                        <td><?php echo $records['remarks']; ?></td>
                                        <td class='noprint' > 
                                            
                                            <button id='btnedit' onclick="openupdate(<?php echo $records['id']; ?>);" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button> 
                                        </td>
                                    </tr>
                                <?php }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

        <!--Modals-->

        <!--Add Facial Modal-->
        <div id="addlist" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addlist" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="addlistForm" action="<?php echo base_url("service_controller/facial_record_add"); ?>" method="POST">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="custom-width-modalLabel">Add a Facial Record</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtcustomer" class="control-label">Customer</label>
                                                <select id="txtcustomer" name="txtcustomer" required class="form-control">
                                                    <option value=""></option>
                                                    <?php if (isset($customers)) {
                                                        foreach ($customers as $customer) { ?>
                                                            <option value="<?php echo $customer['id_customers']; ?>"><?php echo $customer['customer_name']; ?></option>
                                                        <?php }
                                                    } ?>
                                                </select>
                                            </div> 
                                        </div> 
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtdate" class="control-label">Date</label>
                                                <input type="text" class="form-control" placeholder="Date" id="txtdate" name="txtdate">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtexfoliant" class="control-label">Exfoliant</label>
                                                <input type="text" class="form-control" placeholder="Exfoliant" id="txtexfoliant" name="txtexfoliant">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtcleanser" class="control-label">Cleanser</label>
                                                <input type="text" class="form-control" placeholder="Cleanser" id="txtcleanser" name="txtcleanser">
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtcharge" class="control-label">Charge</label>
                                                <input type="text" class="form-control numeric" placeholder="Charge" id="txtcharge" name="txtcharge">
                                            </div> 
                                        </div> 
                                    </div>

                                    

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txttime" class="control-label">Duration (minutes)</label>
                                                <input type="text" class="form-control numeric" placeholder="Time" id="txttime" name="txttime">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtmask" class="control-label">Mask</label>
                                                <input type="text" class="form-control" placeholder="Mask" id="txtmask" name="txtmask">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtfacial" class="control-label">Facial name</label>
                                                <input type="text" class="form-control" placeholder="Flash" id="txtfacial" name="txtfacial">
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txtremarks" class="control-label">Remarks</label>
                                        <textarea id="txtremarks" name="txtremarks" class="form-control"></textarea>
                                    </div> 
                                </div> 
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-custom waves-effect waves-light">Save</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Facial Modal-->

        <!--Edit Service Category Modal-->
        <div id="edittype" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="edit$records" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editlistForm" action="<?php echo base_url("service_controller/facial_record_update"); ?>" method="POST">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="custom-width-modalLabel">Update a Facial Record</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txteditcustomer" class="control-label">Customer</label>
                                                <select id="txteditcustomer" name="txteditcustomer" required class="form-control">
                                                    <option value=""></option>
                                                    <?php if (isset($customers)) {
                                                        foreach ($customers as $customer) { ?>
                                                            <option value="<?php echo $customer['id_customers']; ?>"><?php echo $customer['customer_name']; ?></option>
                                                        <?php }
                                                    } ?>
                                                </select>
                                            </div> 
                                        </div> 
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txteditdate" class="control-label">Date</label>
                                                <input type="text" class="form-control" placeholder="Date" id="txteditdate" name="txteditdate">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txteditexfoliant" class="control-label">Exfoliant</label>
                                                <input type="text" class="form-control" placeholder="Exfoliant" id="txteditexfoliant" name="txteditexfoliant">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txteditmask" class="control-label">Mask</label>
                                                <input type="text" class="form-control" placeholder="Mask" id="txteditmask" name="txteditmask">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txteditcharge" class="control-label">Charge</label>
                                                <input type="text" class="form-control numeric" placeholder="Charge" id="txteditcharge" name="txteditcharge">
                                            </div> 
                                        </div> 
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtedittime" class="control-label">Duration (minutes)</label>
                                                <input type="text" class="form-control numeric" placeholder="Time" id="txtedittime" name="txtedittime">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txteditcleanser" class="control-label">Cleanser</label>
                                                <input type="text" class="form-control " placeholder="Cleasner" id="txteditcleanser" name="txteditcleanser">
                                            </div> 
                                        </div> 
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txteditfacial" class="control-label">Facial name</label>
                                                <input type="text" class="form-control" placeholder="Flash" id="txteditfacial" name="txteditfacial">
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
                            </div>
                                                        
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txteditremarks" class="control-label">Remarks</label>
                                        <textarea id="txteditremarks" name="txteditremarks" class="form-control"></textarea>
                                    </div> 
                                </div> 
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="idfacial_record" id="idfacial_record"  />
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-custom waves-effect waves-light">Save</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Edit Service Category Modal-->
        
        <!--Add Facial Modal-->
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
        <!--End Facial Modal-->


        <script>
            $(document).ready(function() {
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
                
                jQuery('#txtcustomeranniversary').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy/mm/dd'
                });


                $('#txtdate').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy-mm-dd'
                });
                
                $('#txteditdate').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy-mm-dd'
                });

                $("#txttime1").datetimepicker({
                    format: 'HH:mm:00',
                    enabledHours: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    allowInputToggle: true,
                    stepping: 15
                });
                
                $("#txtedittime11").datetimepicker({
                    format: 'HH:mm:00',
                    enabledHours: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    allowInputToggle: true,
                    stepping: 15
                });

                $("#txtcustomer").select2({
                    //maximumSelectionLength: 2
                    formatNoMatches: Not_Found
                });
                
                $("#txteditcustomer").select2({
                    //maximumSelectionLength: 2
                });

                $('#addlistForm').on('submit', function(e) {
                e.preventDefault();
                    var txtcustomer_id = $('#txtcustomer option:selected').val();
                    var txtcustomer = $('#txtcustomer option:selected').text()
                    
                    $.ajax({
                    url: $(this).attr('action') || window.location.pathname,
                    type: "POST",
                    data: {txtcustomer_id: txtcustomer_id, txtcustomer: txtcustomer, txttime: $('#txttime').val(), txtcharge: $('#txtcharge').val(), txtremarks: $('#txtremarks').val(), txtdate: $('#txtdate').val(), txtexfoliant: $('#txtexfoliant').val(), txtmask: $('#txtmask').val(), txtcleanser: $('#txtcleanser').val(), txtfacial: $('#txtfacial').val()},
                    success: function(data) {
                        var result = data.split("|");
                        if (result[0] === "success") {
                            toastr.success('Facial record added');
                            location.reload();
                        } 
                    },
                    error: function(jXHR, textStatus, errorThrown) {
                    
                    }
                    });
                });
                
                $('#editlistForm').on('submit', function(e) {
                e.preventDefault();
                    var txtcustomer_id = $('#txteditcustomer option:selected').val();
                    var txtcustomer = $('#txteditcustomer option:selected').text()
                    
                    $.ajax({
                    url: $(this).attr('action') || window.location.pathname,
                    type: "POST",
                    data: {idfacial_record: $('#idfacial_record').val(), txtcustomer_id: txtcustomer_id, txtcustomer: txtcustomer, txttime: $('#txtedittime').val(), txtcharge: $('#txteditcharge').val(), txtremarks: $('#txteditremarks').val(), txtdate: $('#txteditdate').val(), txtexfoliant: $('#txteditexfoliant').val(), txtmask: $('#txteditmask').val(), txtcleanser: $('#txteditcleanser').val(), txtfacial: $('#txteditfacial').val()},
                    success: function(data) {
                        //console.log(data);
                        var result = data.split("|");
                        if (result[0] === "success") {
                            toastr.success('Facial record updated');
                            location.reload();
                        } 
                    },
                    error: function(jXHR, textStatus, errorThrown) {
                    
                    }
                    });
                });
                
                $(".numeric").keypress(function(e) {
                    //if the letter is not digit then display error and don't type anything
                    if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                        return false;
                    }
                });

            });

            function openaddnew() {
                $("#addlist").modal('show');
            }
            
            function openupdate(id_facial_record) {

                
                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>service_controller/edit_facial_record',
                    data: {id_facial_record: id_facial_record},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        //$("#txteditcustomer").val(customer_id);
                        $('#txteditcustomer').select2('data', {id: data.customer_id, text: data.customer});

                        $("#txteditdate").val(data.date);
                        $("#txtedittime").val(data.time);
                        $("#txteditexfoliant").val(data.exfoliant);
                        $("#txteditmask").val(data.mask);
                        $("#txteditcleanser").val(data.cleanser);
                        $("#txteditremarks").val(data.remarks);
                        $("#txteditcharge").val(data.charge);
                        $("#txteditfacial").val(data.facial);

                        $('#idfacial_record').val(id_facial_record);

                        $("#edittype").modal('show');
                        
                    }
                });
            }
            
            function Not_Found(){
                var $not_found = '<div>Customer not found <a class="btn btn-primary btn-sm" href="#" onclick="return myClick()"><span class="sp">Add customer</span></a></div>';
                return $not_found;
            }
            
            function myClick(){
               $('.sp').html('<i class="fa fa-spin fa-spinner" aria-hidden="true"></i>');
            setTimeout(function(){
                
                $("#addlist").modal('hide');
                $('.select2-drop').css('display',"none");
            }, 1000);
            
            setTimeout(function(){
                //$('#addlist').addClass('fa fa-spinner');
                $("#addcustomer").modal('show');
            }, 1500);
                
            }
            
            function addnew() {
                if ($("#txtcustomername").val() !== "") {
                    $("#txtcustomername").val(ucwords($("#txtcustomername").val()));
                    var customer_name = $("#txtcustomername").val().trim();
                    customer_name = customer_name.split(" ");
                    
                    if(customer_name.length > 1){
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
                    } else{
                        swal({
                            title: "Please enter Customer's last name also!",
                            text: "",
                            type: "error",
                            confirmButtonText: 'OK!'
                        });
                    }
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