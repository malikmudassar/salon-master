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
                    <form method="post" action="<?php echo base_url(); ?>programadd/<?php echo $program_type[0]['id_program_types'];?>">
                        <input type="hidden" name="csrf_test_name" id="programs_edit_csrf" value=""/>
                        <button type="submit" onclick="$('#programs_edit_csrf').val($('#cook').val());" class="btn btn-custom waves-effect waves-light" >Add New Program<span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                    </form>
                </div>
                <h4 class="page-title"><?php echo $program_type[0]['program_type'];?> Programs (<?php echo $business[0]['business_name'];?>):</h4>
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
                                        <th>Program ID</th>
                                        <th>Program Name</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($programs as $program){ ?>
                                    <tr>
                                        <td><?php echo $program['id_programs']; ?></td>
                                        <td><?php echo $program['program']; ?></td>
                                        <td><?php echo $program['program_duration']; ?></td>
                                        <td><?php echo $program['program_active']; ?></td>
                                        <td class='noprint'> 
                                            <form method="post" action="<?php echo base_url(); ?>programedit/<?php echo $program['id_programs'];?>">
                                                <input type="hidden" name="csrf_test_name" id="programs_edit_csrf_<?php echo $program['id_programs'];?>" value=""/>
                                                <button type="submit" onclick="$('#programs_edit_csrf_<?php echo $program['id_programs'];?>').val($('#cook').val());" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button>  
                                            </form>
                                            <form method="post" action="<?php echo base_url(); ?>programsession/<?php echo $program['id_programs'];?>">
                                                <input type="hidden" name="csrf_test_name" id="program_session_csrf_<?php echo $program['id_programs'];?>" value=""/>
                                                <button type="submit" onclick="$('#program_session_csrf_<?php echo $program['id_programs'];?>').val($('#cook').val());" class="btn btn-icon waves-effect waves-light btn-warning m-b-5"> <i class="fa fa-table"></i> Sessions</button>
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
        $('#datatable-buttons').DataTable({
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
		"displayLength": 25
		
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

        $(".numeric").keypress(function(e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    });

</script>