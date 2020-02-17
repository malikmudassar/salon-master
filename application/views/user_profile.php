<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col-sm-12"><div class="card-box">
                    <div class="btn-group pull-right m-t-15">

                        <img style="cursor: pointer; cursor: hand;" onclick="upload_image('<?php echo $user_profile->id_users; ?>', '<?php echo $user_profile->user_image; ?>');" width="50" height="50" src="<?php echo base_url(); ?>assets/images/users/<?php echo $user_profile->user_image ? $user_profile->user_image : "avatar-1.jpg"; ?>" />
                    </div>
                    <button id="openaddnew" type="button" class="btn btn-custom waves-effect waves-light hidden" >Create User <span class="m-l-5"><i class="fa fa-plus"></i></span></button>

                    <h4 class="page-title">Profile: <small><?php echo $this->session->userdata('role'); ?></small></h4> </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="header-title m-t-0 m-b-30">Personal Information</h4>
                    <form id="addform">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="add_user_name" class="control-label">Username</label>
                                    <input readonly type="text" class="form-control" id="add_user_name" name="add_user_name" placeholder="Username" value="<?php echo $user_profile->user_name; ?>">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="add_user_first_name" class="control-label">First Name</label>
                                    <input readonly type="text" class="form-control" id="add_user_first_name" name="add_user_first_name" placeholder="First Name" value="<?php echo $user_profile->user_firstname; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="add_user_last_name" class="control-label">Last Name</label>
                                    <input readonly type="text" class="form-control" id="add_user_last_name" name="add_user_last_name" placeholder="Last Name" value="<?php echo $user_profile->user_lastname; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="add_user_email" class="control-label">Email</label>
                                    <input readonly type="email" class="form-control email" id="add_user_email" name="add_user_email" placeholder="Email" value="<?php echo $user_profile->user_email; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="add_user_cell" class="control-label">Cell #</label>
                                    <input readonly type="text" class="form-control" id="add_user_cell" name="add_user_cell" placeholder="Cell #" value="<?php echo $user_profile->user_mobile; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="add_user_phone" class="control-label">Phone #</label>
                                    <input readonly type="text" class="form-control" id="add_user_phone" name="add_user_phone" placeholder="Phone #" value="<?php echo $user_profile->user_phone; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="add_user_address" class="control-label">Address</label>
                                    <input readonly type="text" class="form-control" id="add_user_address" name="add_user_address" placeholder="Address" value="<?php echo $user_profile->user_address; ?>">
                                </div>
                            </div>

                        </div>
                        <div class="row">&nbsp;</div>
                        <h4 class="header-title m-t-0 m-b-30">Privacy</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="current_password" class="control-label">Current </label>
                                    <input type="password" placeholder="Password" class="form-control" id="current_password" name="current_password" value="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="new_password" class="control-label">New </label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password">

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cnf_password" class="control-label">Confirm </label>
                                    <input type="password" class="form-control" id="cnf_password" name="cnf_password" placeholder="Confirm Password">
                                    <span id='pass_message'></span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_profile->id_users; ?>" />
                        <button type="submit" class="btn btn-info waves-effect waves-light pull-right">Save changes</button>

                    </form>


                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

        <!--start upload image-->
        <div id="addtypeimage" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addtypeimage" aria-hidden="true" style="display: none;">
            <form action="<?php echo base_url('userimage'); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="custom-width-modalLabel">Add User Image</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div id="msg">
                                                    <img id="img" width="100px;" src="" />
                                                </div>
                                                <label for="service_type_image" class="control-label">User Image</label>
                                                <input class="form-control" type="file" id="user_image" name="user_image" />
                                                <input type="hidden" name="org_image" id="org_image" />
                                                <input type="hidden" name="userid" id="userid" />
                                            </div> 
                                        </div> 
                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-custom waves-effect waves-light">Save</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </form>
        </div>
        <!--end upload image-->

        <script>
            $(document).ready(function() {

                $('#tblinvoice').DataTable({
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    stateSave: true,
                    fixedHeader: {header: true},
                    dom: "Bfrtlip",
                    buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"}, {
                            extend: "excel",
                            className: "btn-sm btn-warning btn-trans"
                        }, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}],
                    responsive: !0
                });

                $('#addform').on('submit', function() {
                    if ($('#cnf_password').val() !== $('#new_password').val()) {
                        $('#pass_message').html('not matching').css('color', 'red');
                    } else {
                        $('#pass_message').html('matching').css('color', 'green');
                        $.ajax({
                            type: 'POST',
                            url: 'User_controller/updateUserpass',
                            //data: $('#addform').serialize(),
                            data: {new_password: $('#new_password').val(), cnf_password: $('#cnf_password').val(), current_password: $('#current_password').val(), user_id: $('#user_id').val()},
                            success: function(response) {

                                if (response === "success") {
                                    toastr.success('Password successfully Updated!', 'Done!');
                                    $('#new_password').val('');
                                    $('#cnf_password').val('');
                                    $('#current_password').val('');
                                    $('#pass_message').text('');
                                } else {
                                    swal({
                                        title: 'Error! Password not Update',
                                        text: 'Please check the current password is correct ?',
                                        type: 'error',
                                        confirmButtonText: 'OK!'
                                    });
                                }
                            }
                        });
                    }
                    return false;
                });

                $('#cnf_password').on('keyup', function() {
                    if ($(this).val() == $('#new_password').val()) {
                        $('#pass_message').html('matching').css('color', 'green');
                    } else
                        $('#pass_message').html('not matching').css('color', 'red');
                });//1px solid #E3E3E3


            });

            function upload_image(userid, image) {
                image = image || null;
                if (userid && userid != null) {
                    $("#org_image").val('');
                    $("#userid").val('');
                    $("#userid").val(userid);
                    if (image && image != null) {
                        $("#org_image").val(image);
                        $("#msg #img").attr('src', 'assets/images/users/' + image);
                    } else {
                        $("#msg #img").attr('src', 'assets/images/users/avatar-1.jpg');
                    }
                    $("#addtypeimage").modal("show");
                }
            }
        </script>

        <?php
        include 'js_functions/retail_js.php';
        