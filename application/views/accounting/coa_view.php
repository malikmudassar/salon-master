<style>
    table.dataTable tr.group td{font-weight:bold;background-color:#e0e0e0}
    
     table.dataTable tr.group,
        tr.group:hover {
            background-color: #ddd !important;
        }
    
</style>

<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    <form method="post" action="<?php echo base_url(); ?>accounting_controller/accountheadadd">
                        <input type="hidden" name="csrf_test_name" id="accounts_add_csrf" value=""/>
                        <button type="submit" onclick="$('#accounts_add_csrf').val($('#cook').val());" class="btn btn-custom waves-effect waves-light" >Add Account Head<span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                    </form>
                </div>
                <h4 class="page-title">Chart of Accounts (<?php echo $business[0]['business_name'];?>):</h4>
            </div>
        </div>

        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <h4 class="header-title m-t-0 m-b-30"></h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Account Sub Type</th>
                                        <th>Account Number</th>
                                        <th>Account Type</th>
                                        <th>Account Head</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($account_heads as $account_head){ ?>
                                    <tr>
                                        <td><?php echo $account_head['account_sub_type']; ?></td>
                                        <td><?php echo $account_head['account_number']; ?></td>
                                        <td><?php echo $account_head['account_type']; ?></td>
                                        <td><?php echo $account_head['account_head']; ?></td>
                                        <td class='noprint'> 
                                            <form method="post" action="<?php echo base_url(); ?>accounting_controller/accountheadedit">
                                                <input type="hidden" name="id_account_head" id="account_head_<?php echo $account_head['id_account_heads']; ?>" value="<?php echo $account_head['id_account_heads']; ?>">
                                                <input type="hidden" name="csrf_test_name" id="accounts_edit_csrf_<?php echo $account_head['id_account_heads'];?>" value=""/>
                                                <button type="submit" onclick="$('#accounts_edit_csrf_<?php echo $account_head['id_account_heads'];?>').val($('#cook').val());" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button>  
                                            </form>
                                        </td>
                                        
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>

<script>
    $(document).ready(function() {
        var table =$('#datatable-buttons').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "stateSave": true,
                "dom": "Bfrtlip",
                "buttons": [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"}, {
                        extend: "excel",
                        className: "btn-sm btn-warning btn-trans"
                    }, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}],
                "responsive": !0,
                "columnDefs": [
                    { "visible": false, "targets": 2 }
		],
		"order": [[ 2, 'asc' ]],
		"displayLength": 25,
		"drawCallback": function (settings) {
                    var api = this.api();
                    var rows = api.rows({page:'current'}).nodes();
                    var last=null;

                    api.column(2, {page:'current'} ).data().each( function ( group, i ) {
                        if ( last !== group ) {
                            $(rows).eq( i ).before(
                                '<tr class="group"><td colspan="4">'+group+'</td></tr>'
                            );

                            last = group;
                        }
                    });
		}
            });

            // Order by the grouping
	$('#datatable-buttons tbody').on( 'click', 'tr.group', function () {
		var currentOrder = table.order()[0];
		if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
                    table.order( [ 2, 'desc' ] ).draw();
		}
		else {
                    table.order( [ 2, 'asc' ] ).draw();
		}
	} );
        
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

        $(".numeric").keypress(function(e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    });

</script>