
<div class="wrapper">
    <div class="container" style="width:100%">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <!--Start list selection section-->
                    <div class="row m-b-30">
                        <div class="col-lg-6">
                            <form method="Post" action="<?php echo base_url('sms_controller/send_sms');?>">
                            <input type="hidden" name="csrf_test_name" id="sms_csrf" value=""/>
                            <input type="hidden" name="using" id="using" value="CustomSMS"/>
                            <h4 class="header-title m-t-0 m-b-30">Send SMS:</h4>
                            
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Cell</label>
                                    <input class="form-control numeric" name="customercell" id="phone" />
                                </div>
                            </div>
                            <div id="newlistform " class="col-lg-12">
                               <div class="form-group">
                                    <label class="form-label">Message</label>
                                    <textarea name="msg" id="msg" class="form-control" maxlength="320" rows="2" placeholder="This text area has a limit of 320 chars."></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group text-right" >
                                    <button class="btn btn-warning" onclick="clearsmsmsg();">Clear</button>
                                    <button type="submit" onclick="$('#sms_csrf').val($('#cook').val());" class="btn btn-pink" onclick="sendsms();">Send</button>
                                </div>
                            </div>
                            </form>
                        </div>

                        <div class="col-lg-6">
                           <h4 class="header-title m-t-0 m-b-30">Pre-written Sentences:</h4>
                           <div class="col-lg-12">
                                <div class="form-group">
                                    <select style="height:180px;" onclick="addtosms();" multiple="multiple" class="form-control" name="smstext" id="smstext">
                                        <?php foreach($sms_text as $text){?>
                                        <option ><?php echo $text['sms_text']; ?></option>
                                        <?php }?>
                                    </select>
                                    <span class="font-13 text-muted">Click a sentence to append it to the SMS</span>
                                </div>
                                <div class="form-group text-right">
                                    <button class="btn btn-primary" onclick="addsmstext();">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End list selection section-->

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
                                            </selet>
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

    <script src="<?php echo base_url(); ?>assets/js/datatable.js"></script>

    <script>

        jQuery(document).ready(function () {
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



        function sendsms(){
            
             $.ajax({
                type: 'POST',
                url: "<?php echo base_url() . 'sms_controller/send_sms'; ?>",
                data:{message: $('#msg').val(), phone:$('#phone').val()},
                dataType: "xml",
                cache: false,
                async: true,
                success: function(data) {
                    alert(data);
                }
            });
        
        }

        function addtosms(){
            var newtext=$('textarea#msg').val() + ' ' + $('#smstext option:selected').text();
            console.log($('textarea#msg').val());
            console.log($('textarea#msg').val().length + $('#smstext option:selected').text().length);
            
            if($('textarea#msg').val().length + $('#smstext option:selected').text().length <= 160){
                $('textarea#msg').val('');
                $('textarea#msg').val(newtext);
            }
            
        }
        
        function clearsmsmsg(){
            $("#msg").val('');
        }
        function addtophone(phone, customer){
            if(phone.length===11){
                $('#phone').val(phone);
                $('textarea#msg').val("Hi "+customer+","+ $('textarea#msg').val());
            } else {
                swal("Cell Number Invalid!", "Customer's Cell number is invalid. Use admin panel to enter correct cell number!", "error");
            }
            
        }
    </script>