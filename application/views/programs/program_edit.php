<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Edit <?php echo $program[0]['program']; ?> :</h4>
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
                    <form method="post" action="<?php echo base_url();?>programs_controller/update_program">
                        <input type="hidden" name="csrf_test_name" id="program_add_csrf" value=""/>
                        <input type="hidden" class="form-control" name="id_programs" value = "<?php echo $program[0]['id_programs'];?>">
                        <div class="form-group">
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <label class="form-label">Program Name</label>
                                    <input class="form-control" name="program_name" value = "<?php echo $program[0]['program'];?>">
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <label class="form-label">Program Type</label>
                                    <select class="form-control" type="text" name="program_type_id" id="program_type_id">
                                        <?php foreach($program_types as $program_type){?>
                                        <option <?php if($program_type['id_program_types']==$program[0]['id_program_types']){echo 'selected="selected"';}?> value="<?php echo $program_type['id_program_types'] ?>"><?php echo $program_type['program_type'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            
                            <div class="row m-t-20">
                               <div class="col-md-6">
                                    <label class="form-label">Duration</label>
                                    <input class="form-control" name="program_duration" value = "<?php echo $program[0]['program_duration'];?>">
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <label class="form-label">Price</label>
                                    <input class="form-control" name="program_price" value = "<?php echo $program[0]['program_price'];?>">
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" name="program_active">
                                        <option <?php if($program[0]['program_active']=='Yes'){echo 'selected="selected"';} ?> value="Yes">Active</option>
                                        <option <?php if($program[0]['program_active']=='No'){echo 'selected="selected"';} ?> value="No">InActive</option>

                                    </select>
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <div class="btn-group pull-right m-t-15">
                                        <a href="<?php echo base_url();?>programs/<?php echo $program[0]['id_program_types']; ?>" class="btn waves-effect waves-light btn-default m-t-20">Back</a>
                                        <button onclick="$('#program_add_csrf').val($('#cook').val());" class="btn waves-effect waves-light btn-pink m-t-20">Save</button>
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