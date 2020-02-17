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
                <h4 class="page-title" >Eye Lashes Records</h4>
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
                                <th>Type</th>
                                <th>Thickness</th>
                                <th>Length</th>
                                <th>Curl</th>
                                <th>Full Set Refill</th>
                                <th>Date</th>
                                <th>Price</th>
                                <th>Remarks</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (isset($eyelashes)) {
                                foreach ($eyelashes as $records) {
                                    ?>
                                    <tr>
                                        <td ><?php echo $records['id_eyelashes']; ?></td>
                                        <td><?php echo $records['customer_name']; ?></td>
                                        <td><?php echo $records['eyelash_type']; ?></td>
                                        <td><?php echo $records['thickness']; ?></td>
                                        <td><?php echo $records['length']; ?></td>
                                        <td><?php echo $records['curl']; ?></td>
                                        <td><?php echo $records['full_set_refill']; ?></td>
                                        <td><?php echo $records['date']; ?></td>
                                        <td><?php echo $records['price']; ?></td>
                                        <td><?php echo $records['remarks']; ?></td>
                                        <td class='noprint' > 

                                            <button id='btnedit' onclick="openupdate(<?php echo $records['id_eyelashes']; ?>);" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button> 
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

        <!--Modals-->

        <!--Add Add eye Modal-->
        <div id="addlist" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addlist" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="addlistForm" action="<?php echo base_url("eyelashes_controller/add_eyelashes"); ?>" method="POST">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="custom-width-modalLabel">Add a Eyelashes Record</h4>
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
                                                    <?php
                                                    if (isset($customers)) {
                                                        foreach ($customers as $customer) {
                                                            ?>
                                                            <option value="<?php echo $customer['id_customers']; ?>"><?php echo $customer['customer_name']; ?></option>
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
                                                <label for="txtthickness" class="control-label">Thickness</label>
                                                <select id="txtthickness" name="txtthickness" class="form-control">
                                                    <option value="0.10">0.10</option>
                                                    <option value="0.15">0.15</option>
                                                    <option value="0.25">0.25</option>
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
                                                <label for="txtprice" class="control-label">Price</label>
                                                <input type="text" class="form-control" placeholder="Price" id="txtprice" name="txtprice">
                                            </div> 
                                        </div> 
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txttypeoflashes" class="control-label">Type of Lashes</label>
                                                <select name="txttypeoflashes" id="txttypeoflashes" class="form-control">
                                                    <option value=""></option>
                                                    <?php foreach($eyelashtypes as $eyelashtype){?>
                                                        <option value="<?php echo $eyelashtype['eyelash_type']; ?>"><?php echo $eyelashtype['eyelash_type']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div> 
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtlength" class="control-label">Length</label>
                                                <select name="txtlength" multiple="multiple" id="txtlength" class="form-control">
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                    
                                                </select>
                                            </div> 
                                        </div> 
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtcurl" class="control-label">Curl</label>
                                                <select id="txtcurl" name="txtcurl" class="form-control">
                                                    <option value="J">J</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                </select>
                                            </div> 
                                        </div> 
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="row">&nbsp;</div>
                                                <div class="row">&nbsp;</div>
                                                <label class="radio-inline">
                                                    <input type="radio" value="Full set" name="txt_full_set_refill" id="txt_full_set_refill"> Full set
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" value="Refill" name="txt_full_set_refill" id="txt_full_set_refill"> Refill
                                                </label>
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
        <!--End EyeLash Modal-->

        <!--Edit EyeLash Modal-->
        <div id="edittype" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="edit$records" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editlistForm" action="<?php echo base_url("eyelashes_controller/update_eyelashes"); ?>" method="POST">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="custom-width-modalLabel">Update a Eyelashes Record</h4>
                        </div>
                        <div class="modal-body">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="txteditcustomer" class="control-label">Customer</label>
                                                    <input id="txteditcustomer" name="txteditcustomer" required class="form-control">
                                                    <input type="hidden" id="txteditcustomerid" name="txteditcustomerid" required class="form-control">
                                                </div> 
                                            </div> 
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="txtedittypeoflashes" class="control-label">Type of Lashes</label>
                                                    <select name="txtedittypeoflashes" id="txtedittypeoflashes" class="form-control">
                                                        <option value=""></option>
                                                        <?php foreach($eyelashtypes as $eyelashtype){?>
                                                            <option value="<?php echo $eyelashtype['eyelash_type']; ?>"><?php echo $eyelashtype['eyelash_type']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div> 
                                            </div> 
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="txteditthickness" class="control-label">Thickness</label>
                                                    <select id="txteditthickness" name="txteditthickness" class="form-control">
                                                        <option value="0.10">0.10</option>
                                                        <option value="0.15">0.15</option>
                                                        <option value="0.25">0.25</option>
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


                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="txteditlength" class="control-label">Length</label>
                                                    <!--<input name="txteditlength" id="txteditlength" class="form-control" />-->
                                                    <select name="txteditlength" id="txteditlength" multiple="multiple" class="form-control">
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                    </select>
                                                </div> 
                                            </div> 
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="txteditcurl" class="control-label">Curl</label>
                                                    <select id="txteditcurl" name="txteditcurl" class="form-control">
                                                        <option value="J">J</option>
                                                        <option value="B">B</option>
                                                        <option value="C">C</option>
                                                        <option value="D">D</option>
                                                    </select>
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
                                                    <div class="row">&nbsp;</div>
                                                    <div class="row">&nbsp;</div>
                                                    <label class="radio-inline">
                                                        <input type="radio" value="Full set" name="txt_edit_full_set_refill" id="txt_edit_full_set_refill"> Full set
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" value="Refill" name="txt_edit_full_set_refill" id="txt_edit_full_set_refill"> Refill
                                                    </label>
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
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="ideyelashes_record" id="ideyelashes_record"  />
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
               
                $("#txtlength").select2();
                $("#txteditlength").select2();
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

                $("#txtcustomer").select2({
                    //maximumSelectionLength: 2
                    formatNoMatches: Not_Found
                });

               

                $('#addlistForm').on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: $(this).attr('action') || window.location.pathname,
                        type: "POST",
                        data: {
                            customer_id: $('#txtcustomer option:selected').val(),
                            customer_name: $('#txtcustomer option:selected').text(),
                            eyelash_type: $('#txttypeoflashes').val(),
                            thickness: $('#txtthickness option:selected').val(),
                            curl: $('#txtcurl option:selected').val(),
                            length: $('#txtlength').val(),
                            remarks: $('#txtremarks').val(),
                            date: $('#txtdate').val(),
                            price: $('#txtprice').val(),
                            fullsetrefill: $('input[name=txt_full_set_refill]:checked').val()
                        },
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success('Eyelashes record added');
                                location.reload();
                            }
                        },
                        error: function(jXHR, textStatus, errorThrown) {

                        }
                    });
                });

                $('#editlistForm').on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: $(this).attr('action') || window.location.pathname,
                        type: "POST",
                        data: {
                            id_eyelashes: $('#ideyelashes_record').val(),
                            customer_id: $('#txteditcustomerid').val(),
                            customer_name: $('#txteditcustomer').val(),
                            eyelash_type: $('#txtedittypeoflashes').val(),
                            thickness: $('#txteditthickness option:selected').val(),
                            curl: $('#txteditcurl option:selected').val(),
                            length: $('#txteditlength').val(),
                            remarks: $('#txteditremarks').val(),
                            date: $('#txteditdate').val(),
                            price: $('#txteditprice').val(),
                            fullsetrefill: $('input[name=txt_edit_full_set_refill]:checked').val()
                        },
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success('Eyelashes record updated');
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

            function openupdate(id) {
               // $("#txteditlength").select2();
                $.ajax({
                    type: 'POST',
                    url: 'eyelashes_controller/edit_eyelashes_record',
                    data: {id_eyelashes: id},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        $('#txteditcustomerid').val(data.customer_id);
                        $('#txteditcustomer').val(data.customer_name);
                        $("#txteditdate").val(data.date);
                        $("#txtedittypeoflashes").val(data.eyelash_type);
                        $("#txteditthickness").val(data.thickness);
                        
                        var x=data.length.split(',');
                        
                        console.log(x);
                        $("#txteditlength").select2('val', x);
        
                        $("#txteditcurl").val(data.curl);
                        $("#txteditremarks").val(data.remarks);
                        
                        $('input:radio[name=txt_edit_full_set_refill]').prop('checked', false);
                        
                        var $radios = $('input:radio[name=txt_edit_full_set_refill]');
                        if ($radios.is(':checked') === false) {
                            $radios.filter('[value="' + data.full_set_refill + '"]').prop('checked', true);
                        }
                        //}, 1000);

                        $('#ideyelashes_record').val(id);

                        $("#edittype").modal('show');
                    }
                });
            }

            function Not_Found() {
                var $not_found = '<div>Customer not found <a class="btn btn-primary btn-sm" href="#" onclick="return myClick()"><span class="sp">Add customer</span></a></div>';
                return $not_found;
            }

            function myClick() {
                $('.sp').html('<i class="fa fa-spin fa-spinner" aria-hidden="true"></i>');
                setTimeout(function() {

                    $("#addlist").modal('hide');
                    $('.select2-drop').css('display', "none");
                }, 1000);

                setTimeout(function() {
                    //$('#addlist').addClass('fa fa-spinner');
                    $("#addcustomer").modal('show');
                }, 1500);

            }

           
          

        </script>