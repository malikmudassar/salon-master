<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    <button type="button" style="display:none;" id="createpassbtn" class="btn btn-custom waves-effect waves-light" >Create<span class="m-l-5"><i class=" fa fa-plus"></i></span></button>
                    <button type="button" id="dispassbtn" class="btn btn-danger waves-effect waves-light" ><span class="txtbtn">List Discount Password User</span> <span class="m-l-5"><i id="icon" class="fa fa-list"></i></span></button>

                </div>
                <h4 class="page-title" >Configuration:</h4>
            </div>
        </div>

        <?php foreach ($discounts as $discount) { ?>
            <div class="row disconf">
                <div class="col-sm-12">
                    <div class="card-box">
                        <h4 class="header-title m-t-0 m-b-30">Discount Type <?php echo $discount['id_business_discounts']; ?>:</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="p-20">
                                    <h5><b>Discount Type</b></h5>
                                    <span name="id_business_discount1" id="id_business_discount1"><?php echo $discount['discount_def']; ?></span>


                                </div>
                            </div><!-- end col -->

                            <div class="col-md-6">
                                <div class="p-20">
                                    <h5><b>Discount Rate %</b></h5>
                                    <input type="text" class="form-control numeric" maxlength="5" name="discount_rate" id="discount_rate<?php echo $discount['id_business_discounts']; ?>" value="<?php echo $discount['discount_rate']; ?>">
                                    <?php if (isset($discount['discount_visits']) && $discount['discount_visits'] !== "") { ?>
                                        <div class="m-t-20">
                                            <h5><b>On Visits</b></h5>
                                            <input type="text" class="form-control" maxlength="25" name="discount_visits" id="discount_visits<?php echo $discount['id_business_discounts']; ?>" value="<?php echo $discount['discount_visits']; ?>">
                                        </div>
                                    <?php } ?>

                                    <?php if (isset($discount['discount_purchase']) && $discount['discount_purchase'] !== "") { ?>
                                        <div class="m-t-20">
                                            <h5><b>On Purchase of</b></h5>
                                            <input type="text" class="form-control" maxlength="25" name="discount_purchase" id="discount_purchase<?php echo $discount['id_business_discounts']; ?>" value="<?php echo $discount['discount_purchase']; ?>">
                                        </div>
                                    <?php } ?>

                                    <?php if (isset($discount['discount_period']) && $discount['discount_period'] !== "") { ?>
                                        <div class="m-t-20">
                                            <h5><b>Within Period (Days)</b></h5>
                                            <input type="text" class="form-control" maxlength="25" name="discount_period" id="discount_period<?php echo $discount['id_business_discounts']; ?>" value="<?php echo $discount['discount_period']; ?>">
                                        </div>
                                    <?php } ?>

                                    <div class="m-t-20">
                                        <h5><b>Active</b></h5>
                                        <select class="form-control" maxlength="25" name="discount_active" id="discount_active<?php echo $discount['id_business_discounts']; ?>">
                                            <option value="Y" <?php
                                            if ($discount['discount_active'] === 'Y') {
                                                echo 'selected';
                                            };
                                            ?>>Yes</option>
                                            <option value="N" <?php
                                            if ($discount['discount_active'] === 'N') {
                                                echo 'selected';
                                            };
                                            ?>>No</option>
                                        </select> 
                                    </div>
                                    <div class="m-t-20"> 
                                        <button onclick="discount_update('<?php echo $discount['id_business_discounts']; ?>')" type="button" class="btn btn-custom waves-effect waves-light w-md m-b-5">Save</button>
                                    </div>
                                </div>
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div>
                </div><!-- end col -->
            </div>
        <?php } ?>

        <!--Discount Password start-->
        <?php if (isset($dispass)) { ?>
            <?php foreach ($dispass as $pass) { ?>
                <div class="row dispassrow" id="dispassrow" style="display:none;">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">Discount User: <?php echo $pass->name; ?></h4>

                            <form id="discForm<?php echo $pass->id; ?>" action="<?php echo base_url('discount_controller/discount_password_update'); ?>" method="POST">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="p-20">
                                            <h5><b>Note!</b></h5>
                                            <span>Make sure before change password must remember new password.</span>
                                        </div>
                                    </div><!-- end col -->

                                    <div class="col-md-6">
                                        <div class="p-20">
                                            <h5><b>Name</b></h5>
                                            <input required type="text" class="form-control" maxlength="10" name="user" id="user<?php echo $pass->id; ?>" value="<?php echo $pass->name ? $pass->name : ""; ?>">

                                            <div class="m-t-20">
                                                <h5><b>Email</b></h5>
                                                <input type="email" class="form-control"  name="email" id="email<?php echo $pass->id; ?>" value="<?php echo $pass->email ? $pass->email : ""; ?>">
                                            </div>

                                            <div class="m-t-20">
                                                <h5><b>Username</b></h5>
                                                <input required type="text" class="form-control" maxlength="10" name="name" id="name<?php echo $pass->id; ?>" value="<?php echo $pass->username ? $pass->username : ""; ?>">
                                                <span id="user-message<?php echo $pass->id; ?>" class="text-danger user-message"></span>
                                            </div>

                                            <div class="m-t-20">
                                                <h5><b>Current Password</b></h5>
                                                <input required type="password" class="form-control" maxlength="10" name="current_password" id="current_password<?php echo $pass->id; ?>">
                                            </div>

                                            <div class="m-t-20">
                                                <h5><b>New Password</b></h5>
                                                <input required type="password" class="form-control" maxlength="10" name="new_password" id="new_password<?php echo $pass->id; ?>">
                                            </div>

                                            <div class="m-t-20">
                                                <h5><b>Confirm Password</b></h5>
                                                <input required type="password" class="form-control" maxlength="10" name="confirm_password" id="confirm_password<?php echo $pass->id; ?>">
                                                <span id='message<?php echo $pass->id; ?>'></span>
                                            </div>

                                            <div class="m-t-20"> 
                                                <button id="editbutton<?php echo $pass->id; ?>" type="submit" class="btn btn-custom waves-effect waves-light w-md m-b-5 ">Save</button>
                                                <input type="hidden" name="passid" id="passid" value="<?php echo $pass->id; ?>" />
                                            </div>
                                        </div>
                                    </div><!-- end col -->


                                </div><!-- end row -->

                            </form>


                        </div>
                    </div><!-- end col -->
                </div>
            <?php } ?>
        <?php } ?>
        <!--Discount password end-->


    </div>

    <!--Create start-->
    <div id="addcreate" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addcreate" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addnewForm" action="<?php echo base_url('discount_controller/create_new_user_discount_pass'); ?>" method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new User Invoice</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txtname" class="control-label">Name</label>
                                    <input required type="text" class="form-control" placeholder="Name" id="txtname" name="txtname">
                                </div>
                                <div class="form-group">
                                    <label for="txtemail" class="control-label">Email</label>
                                    <input type="email" class="form-control" placeholder="Email" id="txtemail" name="txtemail">
                                </div>
                                <div class="form-group">
                                    <label for="txtusername" class="control-label">Username</label>
                                    <input required type="text" class="form-control" placeholder="Username" id="txtusername" name="txtusername">
                                    <span class="text-danger user-message"></span>
                                </div>
                                <div class="form-group">
                                    <label for="txtpass" class="control-label">Password</label>
                                    <input required type="password" class="form-control" placeholder="Password" id="txtpass" name="txtpass">
                                </div>
                                <div class="form-group">
                                    <label for="txtcnfpass" class="control-label">Confirm Password</label>
                                    <input required type="password" class="form-control" placeholder="Confirm assword" id="txtcnfpass" name="txtcnfpass">
                                    <span id='txtmessage'></span>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button id="savebtn" type="submit" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!--Create end-->

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

            //Add user invoice pass start..
            $("#txtemail").blur(function(e) {
                e.preventDefault();
                var email = $('#txtemail').val();
                var parts = email.split('@');
                var user = parts[0];
                var username = user.replace(/[^a-z\d]+/ig, '');
                $("#txtusername").val(username);
            });

            $('#txtcnfpass').on('keyup', function() {
                if ($(this).val() == $('#txtpass').val()) {
                    $('#txtmessage').html('matching').css('color', 'green');
                } else
                    $('#txtmessage').html('not matching').css('color', 'red');
            });
            //Add user invoice pass end..

            $("#dispassbtn").click(function() {
                $(".dispassrow").slideToggle(500);
                $(".disconf").slideToggle(500);
                $("#createpassbtn").slideToggle(500);
                if ($("#icon").attr("class") == "fa fa-percent") {
                    $("#icon").attr("class", "fa fa-list");
                    $("#dispassbtn .txtbtn").html('');
                    $("#dispassbtn .txtbtn").html('List Discount Password User');
                } else {
                    $("#icon").attr("class", "fa fa-percent");
                    $("#dispassbtn .txtbtn").html('');
                    $("#dispassbtn .txtbtn").html('Discount Types');
                }
            });

            $("#createpassbtn").click(function() {
                $("#addcreate").modal('show');
            });

            <?php foreach ($dispass as $pass) { ?>
                $('#email<?php echo $pass->id; ?>').blur(function(e) {
                    e.preventDefault();
                    var $value = $('#email<?php echo $pass->id; ?>').val();
                    var $username = createUserName($value);
                    $("#name<?php echo $pass->id; ?>").val($username);
                });

                var createUserName = function(value) {
                    var parts = value.split('@');
                    var user = parts[0];
                    var username = user.replace(/[^a-z\d]+/ig, '');
                    return username;
                };

                $('#confirm_password<?php echo $pass->id; ?>').on('keyup', function() {
                    if ($(this).val() == $('#new_password<?php echo $pass->id; ?>').val()) {
                        $('#message<?php echo $pass->id; ?>').html('matching').css('color', 'green');
                    } else
                        $('#message<?php echo $pass->id; ?>').html('not matching').css('color', 'red');
                });

                $('#discForm<?php echo $pass->id; ?>').on('submit', function(e) {
                    e.preventDefault();

                    if ($("#new_password<?php echo $pass->id; ?>").val() != $("#confirm_password<?php echo $pass->id; ?>").val()) {
                        $('#message<?php echo $pass->id; ?>').html('not matching').css('color', 'red');
                        // return false;
                    } else {
                        $.ajax({
                            url: $(this).attr('action') || window.location.pathname,
                            type: "POST",
                            data: $(this).serialize(),
                            success: function(data) {
                                if (data == "success") {
                                    toastr.success('Discount Password Updated!');
                                    $("#current_password<?php echo $pass->id; ?>").val('');
                                    $("#new_password<?php echo $pass->id; ?>").val('');
                                    $("#confirm_password<?php echo $pass->id; ?>").val('');
                                    location.reload();
                                } else if (data == $("#name<?php echo $pass->id; ?>").val()) {
                                    $('#user-message<?php echo $pass->id; ?>').text('');
                                    $('#user-message<?php echo $pass->id; ?>').text('Username already exist!');
                                } else {
                                    toastr.error('Wrong Password!');
                                }
                            },
                            error: function(jXHR, textStatus, errorThrown) {
                                alert(errorThrown);
                            }
                        });
                    }


                });
            <?php } ?>

            //Submit form for adding new user ivoice pass start.. 
            $('#addnewForm').on('submit', function(e) {
                e.preventDefault();
                if ($('#txtcnfpass').val() != $('#txtpass').val()) {
                    $('#txtmessage').html('not matching').css('color', 'red');
                } else {
                    $.ajax({
                        url: $(this).attr('action') || window.location.pathname,
                        type: "POST",
                        data: $(this).serialize(),
                        success: function(data) {
                            if (data == "success") {
                                toastr.success('Successfully added!');
                                location.reload();
                            } else if (data == $("#txtusername").val()) {
                                $('.user-message').text('');
                                $('.user-message').text('Username already exist!');
                            } else {
                                toastr.error('Something went wrong!');
                            }
                        },
                        error: function(jXHR, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                }
            });
            //Submit form for adding new user ivoice pass end..

        });

        function discount_update(id) {
            if (id) {
                var discount_rate = $("#discount_rate" + id).val();
                var discount_visits = $("#discount_visits" + id).val();
                var discount_purchase = $("#discount_purchase" + id).val();
                var discount_period = $("#discount_period" + id).val();
                var discount_active = $("#discount_active" + id).val();
                //console.log(discount_rate + '---' + discount_visits + '---' + discount_purchase + '---' + discount_period + '---' + discount_active);
                $.ajax({
                    type: 'POST',
                    url: 'discount_controller/discount_update',
                    data: {id_business_discounts: id, discount_rate: discount_rate, discount_visits: discount_visits, discount_purchase: discount_purchase, discount_period: discount_period, discount_active: discount_active},
                    success: function(data) {
                        var result = data.split("|");
                        console.log(result);
                        if (result[0] === "success") {
                            toastr.success(data, 'Discount Updated');
                            location.reload();
                        }
                    }
                });
            }
        }
    </script>