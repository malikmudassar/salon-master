<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    <button id="openaddnew" type="submit" class="btn btn-custom waves-effect waves-light" >Create User <span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                </div>
                <h4 class="page-title">Users List:</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>
                    <table id="tblinvoice" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="hidden">User ID</th>
                                <th>Image</th>
                                <th>Belongs to</th>
                                <th>Role</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Mobile #</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user){ $print=true; ?>
                            <?php 
                            if($user->user_name === 'mexyon' && $username!=="mexyon") {    
                                $print=false;
                            } else if($user->role_name==="Super User" && $this->session->userdata('role')!=="Super User" && $this->session->userdata('username') !== 'mexyon'){
                                $print=false;
                            } else if(isset($user->user_hidden) && $user->user_hidden==='Yes'){
                                if($this->session->userdata('role')==="Super User"){
                                    $print=true;
                                } else if($this->session->userdata('username') === 'mexyon'){
                                    $print=true;
                                } else { $print=false;}
                            } 
                            if($print === true){?>
                                    <tr>
                                        <td class="hidden"><?php echo $user->id_users; ?></td>
                                        <td>
                                            <img style="cursor: pointer; cursor: hand;" onclick="upload_image('<?php echo $user->id_users; ?>', '<?php echo $user->user_image; ?>');" width="50" height="50" src="<?php echo base_url(); ?>assets/images/users/<?php echo $user->user_image ? $user->user_image : "avatar-1.jpg"; ?>" />
                                        </td>
                                        <td><?php echo $user->business_name; ?></td>
                                        <td><?php echo $user->role_name; ?></td>
                                        <td><?php echo $user->user_name; ?></td>
                                        <td><?php echo $user->user_fullname; ?></td>
                                        <td><?php echo $user->user_email; ?></td>
                                        <td><?php echo $user->user_mobile; ?></td>
                                        <td><span class="label label-<?php echo $user->user_status === 'Active' ? 'success' : 'danger'; ?>"><?php echo $user->user_status; ?></span></td>
                                        <td><button type="button" user_id="<?php echo $user->id_users; ?>" class="btn btn-warning btn btn-xs waves-effect w-md waves-success m-b-5 editUser"><i class="fa fa-pencil"></i> Edit</button></td>
                                    </tr>
                            <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

        <!--User Add modal start-->
        <div class="modal fade none-border" id="userAddModal" tabindex="-1" role="dialog" aria-labelledby="userAddModal" aria-hidden="true">
            <div class="modal-dialog " >
                <div class="modal-content">
                    <form id="addform">
                        <div class="modal-header">
                            <button type="button" class="close" onclick="$('#userAddModal').modal('hide'); " aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="eventview-heading">Add New User <strong id="visitcustomername"></strong></h4>
                        </div>
                        <div class="modal-body">
                            <!-- Update Customer -->
                            <div id="con-close-modal">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="add_user_first_name" class="control-label">First Name</label>
                                                        <input type="text" class="form-control" id="add_user_first_name" name="add_user_first_name" placeholder="First Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="add_user_name" class="control-label">Username</label>
                                                        <input type="text" class="form-control" id="add_user_name" name="add_user_name" placeholder="Username">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="add_user_cell" class="control-label">Cell #</label>
                                                        <input type="text" class="form-control" id="add_user_cell" name="add_user_cell" placeholder="Cell #">
                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="add_user_last_name" class="control-label">Last Name</label>
                                                        <input type="text" class="form-control" id="add_user_last_name" name="add_user_last_name" placeholder="Last Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="add_user_email" class="control-label">Email</label>
                                                        <input type="email" class="form-control email" id="add_user_email" name="add_user_email" placeholder="Email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="add_user_phone" class="control-label">Phone #</label>
                                                        <input type="text" class="form-control" id="add_user_phone" name="add_user_phone" placeholder="Phone #">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="add_user_address" class="control-label">Address</label>
                                                <input type="text" class="form-control" id="add_user_address" name="add_user_address" placeholder="Address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h4 class="page-title">Privacy & Status</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="">
                                            <div class="list list-group">
                                                <div class="list-group-item">

                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="add_user_status" class="control-label">Status</label>
                                                                        <select class="form-control" id="add_user_status" name="add_user_status">
                                                                            <option value="Active">Active</option>
                                                                            <option value="Inactive">Inactive</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="add_user_role" class="control-label">Roles</label>
                                                                        <select class="form-control" id="add_user_role" name="add_user_role">
                                                                            <?php foreach($roles as $ur){ ?>
                                                                            <?php if ($this->session->userdata('role')!=="Super User" && $ur->role_name !=="Super User"){?>
                                                                            <option value="<?php echo $ur->id_roles; ?>"><?php echo $ur->role_name; ?></option>
                                                                            <?php } else if ($this->session->userdata('role')==="Super User" && $ur->role_name ==="Super User"){ ?>
                                                                            <option value="<?php echo $ur->id_roles; ?>"><?php echo $ur->role_name; ?></option>
                                                                            <?php }else if ($this->session->userdata('username') === 'mexyon' && $ur->role_name ==="Super User"){ ?>
                                                                            <option value="<?php echo $ur->id_roles; ?>"><?php echo $ur->role_name; ?></option>
                                                                            <?php }} ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="add_user_password" class="control-label">Password</label>
                                                                        <input type="password" placeholder="Password" class="form-control" id="add_user_password" name="add_user_password" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="add_user_cnf_password" class="control-label">Confirm Password</label>
                                                                        <input type="password" class="form-control" id="add_user_cnf_password" name="add_user_cnf_password" placeholder="Confirm Password">
                                                                        <span id='pass_message'></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if($username==='mexyon'){?>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="add_user_hidden" class="control-label">Hidden</label>
                                                                        <select id='add_user_hidden' name='add_user_hidden' class="form-control">
                                                                            <option value='No'>No</option>
                                                                            <option value='Yes'>Yes</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <!-- End Update Customer -->
                        </div>
                        <div class="modal-footer">
                            <button onclick="$('#userAddModal').modal('hide');" type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                            <button id="addbtn" type="submit" class="btn btn-info waves-effect waves-light pull-right">Save changes</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--User Add modal end-->

        <div class="modal fade none-border" id="userEditModal" tabindex="-1" role="dialog" aria-labelledby="userEditModal" aria-hidden="true">
            <div class="modal-dialog " >
                <div class="modal-content">
                    <form id="updateform">
                        <div class="modal-header">
                            <button type="button" class="close" onclick="$('#userEditModal').modal('hide');" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="eventview-heading">Edit User Details: <strong id="visitcustomername"></strong></h4>
                        </div>
                        <div class="modal-body">
                            <!-- Update Customer -->
                            <div id="con-close-modal">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="user_first_name" class="control-label">First Name</label>
                                                        <input type="text" class="form-control" id="user_first_name" name="user_first_name" placeholder="First Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="user_name" class="control-label">Username</label>
                                                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Username">
                                                        <input type="hidden" id="edit_user_id" name="edit_user_id">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="user_cell" class="control-label">Cell #</label>
                                                        <input type="text" class="form-control" id="user_cell" name="user_cell" placeholder="Cell #">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="user_last_name" class="control-label">Last Name</label>
                                                        <input type="text" class="form-control" id="user_last_name" name="user_last_name" placeholder="Last Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="user_email" class="control-label">Email</label>
                                                        <input type="email" class="form-control email" id="user_email" name="user_email" placeholder="Email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="user_phone" class="control-label">Phone #</label>
                                                        <input type="text" class="form-control" id="user_phone" name="user_phone" placeholder="Phone #">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="user_address" class="control-label">Address</label>
                                                <input type="text" class="form-control" id="user_address" name="user_address" placeholder="Address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h4 class="page-title">Privacy & Status</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="list list-group">
                                            <div class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="user_status" class="control-label">Status</label>
                                                            <select class="form-control" id="user_status" name="user_status">
                                                                <option value="Active">Active</option>
                                                                <option value="Inactive">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="user_role" class="control-label">Roles</label>
                                                            <select class="form-control" id="user_role" name="user_role">
                                                                <?php foreach($roles as $ur){ ?>
                                                                            <?php if ($this->session->userdata('role')!=="Super User" && $ur->role_name !=="Super User"){?>
                                                                            <option value="<?php echo $ur->id_roles; ?>"><?php echo $ur->role_name; ?></option>
                                                                            <?php } else if ($this->session->userdata('role')==="Super User" && $ur->role_name ==="Super User"){ ?>
                                                                            <option value="<?php echo $ur->id_roles; ?>"><?php echo $ur->role_name; ?></option>
                                                                            <?php }else if ($this->session->userdata('username') === 'mexyon' && $ur->role_name ==="Super User"){ ?>
                                                                            <option value="<?php echo $ur->id_roles; ?>"><?php echo $ur->role_name; ?></option>
                                                                            <?php }} ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="user_password" class="control-label">Password</label>
                                                            <input readonly="true" type="password" class="form-control" id="user_password" name="user_password" value="password">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="user_new_password" class="control-label">New Password</label>
                                                            <input type="password" class="form-control" id="user_new_password" name="user_new_password" placeholder="New Password">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if($username==='mexyon'){?>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="edit_user_hidden" class="control-label">Hidden</label>
                                                                        <select id='edit_user_hidden' name='edit_user_hidden' class="form-control">
                                                                            <option value='No'>No</option>
                                                                            <option value='Yes'>Yes</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <!-- End Update Customer -->
                        </div>
                        <div class="modal-footer">
                            <button onclick="$('#userEditModal').modal('hide'); ?>';" type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                            <button id="editbtn" type="submit" class="btn btn-info waves-effect waves-light pull-right">Save changes</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

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

                $('#updateform').on('submit', function() {
                    if ($('#user_first_name').val() !== "" && $('#user_last_name').val() !== "" && $('#user_name').val() !== "") {
                        $('#editbtn').html('');
                        $('#editbtn').html('<span class="fa fa-spin fa-spinner"></span>');
                        $.ajax({
                            type: 'POST',
                            url: 'User_controller/updateUserDetails',
                            data: $('#updateform').serialize(),
                            success: function(response) {
                                if (response === "success") {
                                    toastr.success('User successfully updated!', 'Done!');
                                    setTimeout(function() {
                                        $('#userEditModal').modal('hide');
                                        window.location.href = '<?php echo base_url('users_list'); ?>';
                                    }, 3000);

                                } else {
                                    swal({
                                        title: 'Error! User not updated',
                                        text: '',
                                        type: 'error',
                                        confirmButtonText: 'OK!'
                                    });
                                }
                            }
                        });
                    } else {
                        swal({
                            title: 'Required',
                            text: 'Please Provide First/Last & User Name',
                            type: 'warning',
                            confirmButtonText: 'OK!'
                        });
                    }
                    return false;
                });

                $('.editUser').on('click', function() {

                    var user_id = $(this).attr('user_id');
                    if (user_id === "") {
                        return false;
                    }
                    var ths = $(this);
                    ths.addClass('disabled');
                    ths.attr('user_id', '');
                    ths.html('<i class="fa fa-spin fa-spinner"></i>');

                    $.ajax({
                        type: 'POST',
                        url: 'User_controller/getUserDetails',
                        data: {user_id: user_id},
                        success: function(response) {

                            var data = $.parseJSON(response);
                            console.log(data['users'].role_name);
                            $('#edit_user_id').val(data['users'].id_users);
                            $('#user_name').val(data['users'].user_name);
                            $('#user_first_name').val(data['users'].user_firstname);
                            $('#user_last_name').val(data['users'].user_lastname);
                            $('#user_email').val(data['users'].user_email);
                            $('#user_cell').val(data['users'].user_mobile);
                            $('#user_phone').val(data['users'].user_phone);
                            $('#user_address').val(data['users'].user_address);
                            $('#user_status').val(data['users'].user_status).change();
                            $('#user_new_password').val('');
                            $('#edit_user_hidden').val(data['users'].user_hidden);
                           
                            //$("#user_role").val(data['users'].role_name).attr("selected","selected");
                            //$("#user_role option:selected").attr("selected", "selected");
                            $('select[name="user_role"]').find('option:contains("'+data['users'].role_name+'")').attr("selected",true);
//                            var roles = "";
//                            for (var x = 0; x < data['roles'].length; x++) {
//                                if(data['roles'][x].role_name!=='Super User'){
//                                    var selected = data['users'].role_id === data['roles'][x].id_roles ? 'selected' : '';
//                                    roles += '<option ' + selected + ' value="' + data['roles'][x].id_roles + '">' + data['roles'][x].role_name + '</option>';
//                                }
//                            }
//
//                            $('#user_role').html(roles);

                            $('#userEditModal').modal({
                                backdrop: 'static',
                                keyboard: false,
                                show: true
                            });

                            ths.attr('user_id', user_id);
                            ths.html('<i class="fa fa-pencil"></i> Edit');
                            ths.removeClass('disabled');
                        }
                    });
                });

                $('#openaddnew').on('click', function() {
                    $('#add_user_name').val('');
                    $('#add_user_password').val('');
                    $('#add_user_cnf_password').val('');
//                    $.ajax({
//                        type: 'POST',
//                        url: 'User_controller/getUser_roles',
//                        data:{'param':'none'},
//                        dataType: "json",
//                        cache: false,
//                        async: true,
//                        success: function(data) {
//                            var userrole = data['roles'];
//                            var roles = "";
//                            for (var x = 0; x < userrole.length; x++) {
//                                if(userrole[x]['role_name']!=='Super User'){
//                                    roles += '<option value=' + userrole[x]['id_roles'] + '>' + userrole[x]['role_name'] + '</option>';
//                                }
//                            }
//                            $('#add_user_role').html(roles);
//                        }
//                    });


                    $('#userAddModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                });

                $('#addform').on('submit', function() {
                    if ($('#add_user_first_name').val() !== "" && $('#add_user_last_name').val() !== "" && $('#add_user_name').val() !== "") {
                        if ($('#add_user_cnf_password').val() !== $('#add_user_password').val()) {
                            $('#pass_message').html('not matching').css('color', 'red');
                            return false;
                        } else if ($('#add_user_password').val() !== "" && $('#add_user_cnf_password').val() !== "") {
                            $('#pass_message').html('matching').css('color', 'green');
                        }
                        $('#addbtn').html('');
                        $('#addbtn').html('<span class="fa fa-spin fa-spinner"></span>');
                        $.ajax({
                            type: 'POST',
                            url: 'User_controller/addUserDetails',
                            data: $('#addform').serialize(),
                            success: function(response) {
                                if (response === "success") {
                                    toastr.success('User successfully Added!', 'Done!');
                                    setTimeout(function() {
                                        $('#userAddModal').modal('hide');
                                        window.location.href = '<?php echo base_url('users_list'); ?>';
                                    }, 3000);
                                } else {
                                    swal({
                                        title: 'Error! User not Added',
                                        text: '',
                                        type: 'error',
                                        confirmButtonText: 'OK!'
                                    });
                                }
                            }
                        });

                    } else {
                        swal({
                            title: 'Required',
                            text: 'Please Provide First/Last & User Name',
                            type: 'warning',
                            confirmButtonText: 'OK!'
                        });
                    }

                    return false;
                });

                $('#add_user_cnf_password').on('keyup', function() {
                    if ($(this).val() == $('#add_user_password').val()) {
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
