
<div class="wrapper">
    <div class="container" style="width:100%">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <!--Start list Table-->
                    <div class="row m-b-30">
                        <h4 class="header-title m-t-0 m-b-30">SMS Log:</h4>
                        <div class="table-container">
                            <div class="table-actions-wrapper ">
                                
                            </div>

                            <table id="loadedlist" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="30%">SMS Message</th>
                                        <th width="10%">Receiver</th>
                                        <th width="20%">Date Sent</th>
                                        <th width="20%">Using</th>
                                        <th width="15%"></th>
                                    </tr>
                                    <tr role="row" class="filter">
                                        <td width="2%"></td>
                                        <td width="10%">
                                            <input type="text" class="form-control form-filter input-sm" name="msgdata">
                                        </td>
                                        <td width="5%">
                                            <input type="text" class="form-control form-filter input-sm" name="receiver" id="receiver"/>
                                        </td>
                                        <td width="8%">
                                            <input type="text" class="form-control form-filter input-sm date-picker" name="senton">
                                        </td>
                                        <td width="10%">
                                            <input name="using" class="form-control form-filter input-sm"/>
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
         loglist.init();
         
       
          
    });
   
    
        var loglist = function () {
          var initPickers = function () {
            //init date pickers
                $('.date-picker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy-mm-dd'
                });
            }

            var handleLog = function () {
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
                            "url": "<?php echo base_url(); ?>sms_controller/get_smslog" // ajax source
                        },
                        "order": [
                            [3, "desc"]
                        ], // set first column as a default sort by asc
                        "columns": [
                           
                            {"data": "id_sms_log"},
                            {"data": "msgdata"},
                            {"data": "receiver"},
                            {"data": "senton"},
                            {"data": "using"},
                            {"data": "type"}
                        ],
                        "columnDefs": [{"sortable": false, "targets": 5}, {className: "cellnumber", "targets": [ 2 ]}],
//                        "initComplete": function(settings, json) {
//                            
//                            
//                            jQuery('.smsresend').click(function(e){
//                                var clickedCell= $(e.target).closest('tr').find('.cellnumber').text();
//                                console.log(clickedCell);
//                            });
//                        }
                        "rowCallback": function( row, data, index ) {
                            
                            $('td:eq(5)', row).html( '<form method="Post" action="<?php echo base_url('sms_controller/send_sms'); ?>"><input type="hidden" name="csrf_test_name" id="sms_csrf" value="' + $('#cook').val() + '"/><input type="hidden" name="customercell" value="'+ data.receiver +'"/><input type="hidden" name="msg" value="'+ data.msgdata +'"/><input type="hidden" name="debug" value="true"> <button class="btn btn-pink">Resend</button></form>' );
                            
                          }
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
                    handleLog();
                     
                    
                }

            };

        }();


        


</script>