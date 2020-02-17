

<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    <form method="post" action="<?php echo base_url(); ?>programsessionclassadd/<?php echo $programsession[0]['id_program_sessions'];?>">
                        <input type="hidden" name="csrf_test_name" id="programs_add_csrf" value=""/>
                        <button type="submit" onclick="$('#programs_add_csrf').val($('#cook').val());" class="btn btn-custom waves-effect waves-light" >Add New Class<span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                    </form>
                </div>
                <h4 class="page-title">Class Schedule (<?php echo $programsession[0]['program'].'-'.$programsession[0]['session_name'];?>):</h4>
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
                                        <th>Class ID</th>
                                        <th>Instructor</th>
                                        <th>Room</th>
                                        <th>Weekday</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($programsessionclasses as $programsession){ ?>
                                    <tr>
                                        <td><?php echo $programsession['id_program_session_classes']; ?></td>
                                        <td><?php echo $programsession['staff_fullname']; ?></td>
                                        <td><?php echo $programsession['classroom']; ?></td>
                                        <td><?php echo $programsession['weekdays']; ?></td>
                                        <td><?php echo $programsession['class_start']; ?></td>
                                        <td><?php echo $programsession['class_end']; ?></td>
                                        <td class='noprint'> 
                                            <form method="post" action="<?php echo base_url(); ?>programs_controller/programsessionclassedit/<?php echo $programsession['id_program_session_classes'];?>">
                                                <input type="hidden" name="csrf_test_name" id="programsession_edit_csrf_<?php echo $programsession['id_program_session_classes'];?>" value=""/>
                                                <button type="submit" onclick="$('#programsession_edit_csrf_<?php echo $programsession['id_program_session_classes'];?>').val($('#cook').val());" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button>  
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
		"order": [[ 0, 'asc' ]],
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