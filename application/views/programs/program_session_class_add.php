<style>
    .datepicker {top:150px !important;}
</style>

<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Add Class to <?php echo $programsession[0]['session_name']; ?> :</h4>
            </div>
        </div>
        <?php if ($this->session->flashdata('Success') && $this->session->flashdata('Success') != ""){  ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong> <?php echo $this->session->flashdata('Success'); ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if ($this->session->flashdata('Error') && $this->session->flashdata('Error') != ""){  ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('Error'); ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <h4 class="header-title m-t-0 m-b-30"></h4>
                    <form method="post" action="<?php echo base_url();?>programs_controller/insert_program_session_class">
                        <input type="hidden" name="csrf_test_name" id="program_session_class_add_csrf" value=""/>
                        <input type="hidden" name="program_session_id" id="program_id" value="<?php echo $programsession[0]['id_program_sessions'] ?>"/>
                        <div class="form-group">
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <label class="form-label">WeekDay</label>
                                    <select input class="form-control" name="weekday" value = "">
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                        <option value="Sunday">Sunday</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row m-t-20">
                               <div class="col-md-6">
                                   <label class="form-label">Class Start</label>
                                    <div class="input-group">
                                        
                                        <div class="bootstrap-timepicker">
                                            <input name="class_start" id="class_start" data-date-format="HH:mm" data-date-useseconds="false" type="text" class="form-control">
                                        </div>
                                        <span class="input-group-addon bg-primary b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <label class="form-label">Class End</label>
                                    <div class="input-group">
                                        
                                        <div class="bootstrap-timepicker">
                                            <input name="class_end" id="class_end" data-date-format="HH:mm" data-date-useseconds="false" type="text" class="form-control">
                                        </div>
                                        <span class="input-group-addon bg-primary b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <label class="form-label">Instructor</label>
                                    <select class="form-control" name="instructor" id="instructor">
                                        <?php foreach($instructors as $instructor){?>
                                        <option value="<?php echo $instructor['id_staff'];?>"><?php echo $instructor['staff_fullname'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <label class="form-label">Class Room</label>
                                    <input class="form-control" name="classroom" id="classroom" value = "">
                                </div>
                            </div>
                            
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <div class="btn-group pull-right m-t-15">
                                        <a href="<?php echo base_url();?>programsessionclasses/<?php echo $programsession[0]['id_program_sessions']; ?>" class="btn waves-effect waves-light btn-default m-t-20">Back</a>
                                        <button type="submit" onclick="$('#program_session_class_add_csrf').val($('#cook').val());" class="btn waves-effect waves-light btn-pink m-t-20">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </div>
</div>

<script>
    $(document).ready(function() {
        
        $('#class_start').timepicker({
                showMeridian: false                
               , minuteStep: 15               
            });
            
        $('#class_end').timepicker({
           showMeridian: false                
          , minuteStep: 15               
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