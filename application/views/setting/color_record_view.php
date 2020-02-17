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
                <h4 class="page-title" >Color Records</h4>
            </div>


        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">

                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th >Color Record</th>
                                <th>Customer ID</th>
                                <th>Customer</th>
                                <th>Type</th>
                                <th>Color</th>
                                <th>Water Content</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Charge</th>
                                <th>Remarks</th>
                                <th>Recommendation</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (isset($color_records)) {
                                foreach ($color_records as $records) {
                                    ?>
                                    <tr>
                                        <td ><?php echo $records['id']; ?></td>
                                        <td><?php echo $records['customer_id']; ?></td>
                                        <td><?php echo $records['customer']; ?></td>
                                        <td><?php echo $records['color_type']; ?></td>
                                        <td><?php echo $records['color_number']; ?></td>
                                        <td><?php echo $records['water_content']; ?></td>
                                        <td><?php echo $records['date']; ?></td>
                                        <td><?php echo $records['time']; ?></td>
                                        <td><?php echo $records['charge']; ?></td>
                                        <td><?php echo $records['remarks']; ?></td>
                                        <td><?php echo $records['recommendation']; ?></td>
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

        <!--Add Service Category Modal-->
        <div id="addlist" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addlist" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="addlistForm" action="<?php echo base_url("colors_controller/color_record_add"); ?>" method="POST">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="custom-width-modalLabel">Add a Color Record</h4>
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
                                                <label for="txttype" class="control-label">Color Type</label>
                                                <select id="txttype" name="txttype" required class="form-control">
                                                    <option value=""></option>
                                                    <?php
                                                    if (isset($color_type_list)) {
                                                        foreach ($color_type_list as $color_type) {
                                                            if ($color_type['status'] == "Yes") {
                                                                ?>
                                                                <option value="<?php echo $color_type['id']; ?>"><?php echo $color_type['type']; ?></option>
                                                            <?php }
                                                        }
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
                                                <label for="txtw_content" class="control-label">Water Content</label>
                                                <select class="form-control" name="txtw_content" id="txtw_content">
                                                    <?php foreach ($WaterContent as $content){ ?>
                                                    <option value="<?php echo $content['content']; ?>"><?php echo $content['content']; ?></option>
                                                    <?php } ?>
                                                </select>
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
                                                <label for="txttypenumber" class="control-label">Color</label>
                                                <input class="form-control" type="text" name="txttypenumber" id="txttypenumber" />
                                            </div> 
                                        </div> 
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txttime" class="control-label">Duration (in minutes)</label>
                                                <input type="text" class="form-control numeric" placeholder="Time" id="txttime" name="txttime">
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txtrecommendation" class="control-label">Recommendation</label>
                                        <textarea id="txtrecommendation" name="txtrecommendation" class="form-control"></textarea>
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
        <!--End Service Category Modal-->

        <!--Edit Color Modal-->
        <div id="edittype" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="edit$records" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editlistForm" action="<?php echo base_url("colors_controller/color_record_update"); ?>" method="POST">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="custom-width-modalLabel">Update a Color Record</h4>
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
                                                <label for="txtedittype" class="control-label">Color Type</label>
                                                <select id="txtedittype" name="txtedittype" required class="form-control">
                                                    <option value=""></option>
                                                    <?php
                                                    if (isset($color_type_list)) {
                                                        foreach ($color_type_list as $color_type) {
                                                            if ($color_type['status'] == "Yes") {
                                                                ?>
                                                                <option value="<?php echo $color_type['id']; ?>"><?php echo $color_type['type']; ?></option>
                                                            <?php }
                                                        }
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
                                                <label for="txteditw_content" class="control-label">Water Content</label>
                                                <select class="form-control" name="txteditw_content" id="txteditw_content">
                                                    <?php foreach ($WaterContent as $content){ ?>
                                                    <option value="<?php echo $content['content']; ?>"><?php echo $content['content']; ?></option>
                                                    <?php } ?>
                                                </select>
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
                                                <label for="txtedittypenumber" class="control-label">Color Number</label>
                                                <input class="form-control" type="text" name="txtedittypenumber" id="txtedittypenumber" />
                                            </div> 
                                        </div> 
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtedittime" class="control-label">Duration (in minutes)</label>
                                                <input type="text" class="form-control numeric" placeholder="Time" id="txtedittime" name="txtedittime">
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txteditrecommendation" class="control-label">Recommendation</label>
                                        <textarea id="txteditrecommendation" name="txteditrecommendation" class="form-control"></textarea>
                                    </div> 
                                </div> 
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="idcolor_record" id="idcolor_record"  />
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-custom waves-effect waves-light">Save</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Edit Service Category Modal-->
        
      


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
                //$('txtcharge').mask('00/00/0000', {'translation': {0: {pattern: /[0-9*]/}}});
               // $("#txtcharge").mask("99 999999");
                //$('#txtcharge').maskMoney({prefix:'RS ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
                //$("#txteditcharge").maskMoney({prefix:'RS ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
                //$("#txteditcharge").mask("99999");
                //$('#txttime').mask('99 aaa');//AAA 000-S0S
                //$('#txtedittime').mask('99 aaa');

//                $('#order-staff').children('option:selected').each(function() {
//                        mhtml += $(this).val();
//                    });
//                    
//                $('#order-staff').children().remove();
//                $("#order-staff").select2("val", "");

            $('#addlistForm').on('submit', function(e) {
                e.preventDefault();
                    var txtcustomer_id = $('#txtcustomer option:selected').val();
                    var txtcustomer = $('#txtcustomer option:selected').text()
                    var txttype_id = $('#txttype option:selected').val();
                    var txttype = $('#txttype option:selected').text();
                    //var txttypenumber_id = $('#txttypenumber option:selected').val();
                    var txttypenumber = $('#txttypenumber').val();
                    $.ajax({
                    url: $(this).attr('action') || window.location.pathname,
                    type: "POST",
                    data: {txtcustomer_id: txtcustomer_id, txtcustomer: txtcustomer, txttype_id: txttype_id, txttype: txttype, txttypenumber: txttypenumber, txttime: $('#txttime').val(), txtcharge: $('#txtcharge').val(), txtremarks: $('#txtremarks').val(), txtrecommendation: $('#txtrecommendation').val(), txtdate: $('#txtdate').val(), water_content: $('#txtw_content').val()},
                    //data: 'txtcustomer_id='+txtcustomer_id+'&txtcustomer='+txtcustomer+'&txttype_id='+txttype_id+'&txttype='+txttype+'&txttypenumber='+txttypenumber+'&txttime='+$('#txttime').val()+'&txtcharge='+$('#txtcharge').val()+'&txtremarks='+$('#txtremarks').val()+'&txtdate='+$('#txtdate').val(),
                    success: function(data) {
                        var result = data.split("|");
                        if (result[0] === "success") {
                            toastr.success('Color record added');
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
                    var txttype_id = $('#txtedittype option:selected').val();
                    var txttype = $('#txtedittype option:selected').text();
                    //var txttypenumber_id = $('#txtedittypenumber option:selected').val();
                    var txttypenumber = $('#txtedittypenumber').val();
                    
                    $.ajax({
                    url: $(this).attr('action') || window.location.pathname,
                    type: "POST",
                    data: {idcolor_record: $('#idcolor_record').val(), txtcustomer_id: txtcustomer_id, txtcustomer: txtcustomer, txttype_id: txttype_id, txttype: txttype, txttypenumber: txttypenumber, txttime: $('#txtedittime').val(), txtcharge: $('#txteditcharge').val(), txtremarks: $('#txteditremarks').val(), txtrecommendation: $('#txteditrecommendation').val(), txtdate: $('#txteditdate').val(), water_content: $('#txteditw_content').val()},
                    //data:  'idcolor_record='+$('#idcolor_record').val()+'&txtcustomer_id='+txtcustomer_id+'&txtcustomer='+txtcustomer+'&txttype_id='+txttype_id+'&txttype='+txttype+'&txttypenumber='+txttypenumber+'&txttime='+$('#txtedittime').val()+'&txtcharge='+$('#txteditcharge').val()+'&txtremarks='+$('#txteditremarks').val()+'&txtdate='+$('#txteditdate').val(),
                    success: function(data) {
                        //console.log(data);
                        var result = data.split("|");
                        if (result[0] === "success") {
                            toastr.success('Color record updated');
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

//            function color_type(idtype) {
//                if (idtype && idtype != '') {
//                    $('#txttypenumber').html('');
//                    $('#txtedittypenumber').html('');
//                    $.ajax({
//                        type: 'POST',
//                        url: 'colors_controller/get_color_number_id/' + idtype,
//                        dataType: "json",
//                        cache: false,
//                        async: true,
//                        success: function(data) {
//                            for (var i = 0; i < data.length; i++) {
//                                //$('#txttypenumber').append('<option value = ' + data[i]['id'] + '>' + data[i]['number'] + '</option>');
//                                //$('#txtedittypenumber').append('<option value = ' + data[i]['id'] + '>' + data[i]['number'] + '</option>');
//                            }
//
//                        }
//                    });
//                }
//            }

            

            function openaddnew() {
                $("#addlist").modal('show');
            }
            
            function openupdate(id) {
                
                $.ajax({
                    type: 'POST',
                    url: 'colors_controller/edit_color_record',
                    data: {id: id},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        $("#txteditcustomer").val(data.customer);
                        $('#txteditcustomer').select2('data', {id: data.customer_id, text: data.customer});
                        $("#txtedittype").val(data.color_type_id);
                        $("#txtedittypenumber").val(data.color_number);
                        $("#txteditdate").val(data.date);
                        $("#txtedittime").val(data.time);
                        $("#txteditremarks").val(data.remarks);
                        $("#txteditcharge").val(data.charge);
                        $("#txteditw_content").val(data.water_content);

                        $('#idcolor_record').val(id);

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
                                    title: "Customer & cell number already exists!",
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
                                        //swal("Deleted!", "Your imaginary file has been deleted.", "success");
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
                                        //swal("Deleted!", "Your imaginary file has been deleted.", "success");
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
            
            function customer_submit(){
                $.ajax({
                    type: 'POST',
                    url: 'customer_controller/add_customer',
                    data: {customer_name: $("#txtcustomername").val(), customer_cell: $("#txtcustomercell").val(), customer_phone1: $("#txtcustomerphone1").val(), customer_phone2: $("#txtcustomerphone2").val(), customer_address: $("#txtcustomeraddress").val(), customer_birthday: $("#txtcustomerbirthday").val(), customer_birthmonth: $("#txtcustomerbirthmonth").val(), customer_email: $("#txtcustomeremail").val(), customer_anniversary: $("#txtcustomeranniversary").val(), customer_allergies: $("#txtcustomerallergies").val(), customer_alert: $("#txtcustomeralert").val(), customer_type: $("#txtcustomertype").val(), profession: $('#txtcustomerprofession').val()},
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