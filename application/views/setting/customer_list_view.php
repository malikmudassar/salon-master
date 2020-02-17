
<div class="wrapper">
    <div class="container" style="width:100%">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                   
                    <!--Start list Table-->
                    <div class="row m-b-30">
                        <h4 class="header-title m-t-0 m-b-30">Customers:</h4>
                        <div class="table-container">
                            <div class="table-actions-wrapper ">
                                
                            </div>

                            <table id="loadedlist" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="2%">ID</th>
                                        <th width="10%">Customer Name</th>
                                        <th width="5%">Gender</th>
                                        <th width="8%">Care Of</th>
                                        <th width="10%">Cell</th>
                                        <th width="10%">Email</th>
                                        <th width="10%">Address</th>
                                        <th width="10%">Profession</th>
                                        <th width="10%"></th>
                                        
                                    </tr>
                                    <tr role="row" class="filter">
                                        
                                        <td width="2%"></td>
                                        <td width="10%">
                                            <input type="text" class="form-control form-filter input-sm" name="customer_name">
                                        </td>
                                        <td width="5%">
                                            <select type="text" class="form-control form-filter input-sm" name="customer_gender" id="customer_gender">
                                                <option value="">All</option>
                                                <option value="F">Female</option>
                                                <option value="M">Male</option>
                                            </select>
                                        </td>
                                        <td width="8%">
                                            <input type="text" class="form-control form-filter input-sm" name="customer_careof">
                                        </td>
                                        <td width="10%">
                                            <input type="text" class="form-control form-filter input-sm" name="customer_cell">
                                        </td>
                                        
                                        <td width="10%">
                                            <input type="text" class="form-control form-filter input-sm" id="po_supplier" name="customer_email">
                                        </td>
                                        <td width="10%"></td>
                                        <td width="10%">
                                            <input name="profession" class="form-control form-filter input-sm">
                                        </td>
                                       

                                        <td width="15%">
                                            <div class="margin-bottom-5">
                                                <button class="btn btn-sm teal-500 filter-submit margin-bottom"><i class="icon-magnifier"></i> Search</button>
                                            </div>
                                            <button class="btn btn-sm orange-500 filter-cancel"><i class="icon-refresh"></i> Reset</button>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--End list Table-->

                </div>
            </div>
        </div> 
    </div>
    
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
        <!--End Edit Customer Modal-->
    
    <script src="<?php echo base_url(); ?>assets/js/datatable.js"></script>

    <script>

        jQuery(document).ready(function () {
            $('#editcustomer').on('shown.bs.modal', function() {
                    $('#txteditcustomername').focus();
                });

                fillBday();
            
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
            
            customerlist.init();
            $('textarea#msg').maxlength({
                
                alwaysShow: true,
                warningClass: "label label-success",
                limitReachedClass: "label label-danger",
                separator: ' out of ',
                preText: 'You typed ',
                postText: ' chars available.',
                validate: true
            
            });
            
            $(".numeric").keypress(function(e) {
                //if the letter is not digit then display error and don't type anything
                if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });
        });

        var customerlist = function () {
          var initPickers = function () {
            //init date pickers
                $('.date-picker').datepicker({
                    autoclose: true
                });
            }

            var handleCustomers = function () {
                var grid = new Datatable();

                grid.init({
                    src: $("#loadedlist"),
                    onSuccess: function (grid) {
                        // execute some code after table records loaded
                    },
                    onError: function (grid) {
                        // execute some code on network or other general error  
                    },
                    loadingMessage: 'Loading...',
                    dataTable: {// here you can define a typical datatable settings from http://datatables.net/usage/options 
                        // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                        // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: js/datatable.js). 
                        // So when dropdowns used the scrollable div should be removed. 
                        "dom": "<'row'<'col-md-8 col-sm-12'li><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-12 col-sm-12'><'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'p><'col-md-12 col-sm-12'i>>",
                        "lengthMenu": [
                            [10, 20, 50, 100, 150, -1],
                            [10, 20, 50, 100, 150, "All"] // change per page values here
                        ],
                        "pageLength": 10, // default record count per page
                        "pagingType": "full_numbers",
                        "stateSave":"true",
                        "ajax": {
                            "url": "<?php echo base_url(); ?>sms_controller/get_customersbysearch" // ajax source
                        },
                        "order": [
                            [1, "desc"]
                        ], // set first column as a default sort by asc
                        "columns": [
                           
                            {"data": "id_customers"},
                            {"data": "customer_name"},
                            {"data": "customer_gender"},
                            {"data": "customer_careof"},
                            {"data": "customer_cell"},
                            {"data": "customer_email"},
                            {"data": "customer_address"},
                            {"data": "profession"},
                            {"data": "type"}
                        ],
                        "columnDefs": [{"sortable": false, "targets": 3}]

                    }
                });


                // handle group actionsubmit button click
                grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
                    e.preventDefault();
                    var action = $(".table-group-action-input", grid.getTableWrapper());
                    if (action.val() !== "" && grid.getSelectedRowsCount() > 0) {
                        grid.setAjaxParam("customActionType", "group_action");
                        grid.setAjaxParam("customActionName", action.val());
                        grid.setAjaxParam("id", grid.getSelectedRows());
                        grid.getDataTable().ajax.reload();
                        grid.clearAjaxParams();
                    } else if (action.val() == "") {
                        swal({
                            title: "Please select an action",
                            text: "",
                            type: "warning",
                            confirmButtonText: 'OK!'
                        });
                        
                    } else if (grid.getSelectedRowsCount() === 0) {
                         swal({
                            title: "No record selected",
                            text: "",
                            type: "danger",
                            confirmButtonText: 'OK!'
                        });
                    }
                });
            }
            return {
                //main function to initiate the module
                init: function () {

                    initPickers();
                    handleCustomers();
                }

            };

        }();


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
            
            
        function fillBday() {
                for (x = 1; x <= 31; x++) {
                    $("#txt-customer-bday").append('<option value=' + x + '>' + x + '</option>');
                    $("#txtcustomerbirthday").append('<option value=' + x + '>' + x + '</option>');
                    $("#txteditcustomerbirthday").append('<option value=' + x + '>' + x + '</option>');

                }
            }
    </script>