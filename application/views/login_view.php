<!DOCTYPE html>
<html>
    
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Manage your SPA, Parlour and Salon.">
        <meta name="author" content="Mexyon">

        <!-- App Favicon -->
        <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico">

        <!-- App title -->
        <title>SkedWise </title>

        <!-- App CSS -->
        <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script href="<?php echo base_url();?>assets/js/modernizr.min.js"></script>
        
    </head>
    <body>
        <!--login-->
        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
            <div class="text-center">
                <a href="index-2.html" class="logo" ><span style="font-size:40px !important;">Manage <span style="font-size:40px !important;">Your</span></span></a>
                
                <h5 class="text-muted m-t-0 font-600">SPA / PARLOR / SALON</h5>
            </div>
        	<div class="m-t-40 card-box">
                <div class="text-center">
                    <h4 class="text-uppercase font-bold m-b-0">Sign In</h4>
                    <?php echo $this->session->flashdata('msg'); ?>
                    <?php print_r($this->session->userdata);?>
                </div>
                <div class="panel-body">
                    <?php 
                    $attributes = array("class" => "form-horizontal", "id" => "loginform", "name" => "loginform");
                    echo form_open("user_controller/login", $attributes);?>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" id="txt_username" name="txt_username"  type="text" required="" placeholder="Username">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" id="txt_password" name="txt_password"  type="password" required="" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <div class="checkbox checkbox-custom">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup">
                                        Remember me <?php echo md5('12345');?>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="form-group text-center m-t-30">
                            <div class="col-xs-12">
                                <!--<button class="btn btn-custom btn-bordred btn-block waves-effect waves-light" type="submit">Log In</button>-->
                                <input id="btn_login" name="btn_login" type="submit" class="btn btn-custom btn-bordred btn-block waves-effect waves-light" value="Login" />
                            </div>
                        </div>

                        <div class="form-group m-t-30 m-b-0">
                            <div class="col-sm-12">
                                <a href="page-recoverpw.html" class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
          
                    </form>

                </div>
            </div>
            <!-- end card-box-->

            <div class="row">
                <div class="col-sm-12 text-center">
                    <p class="text-muted">Don't have an account? <a href="page-register.html" class="text-primary m-l-5"><b>Sign Up</b></a></p>
                </div>
            </div>
            
        </div>
        <!-- end wrapper page -->
        

        
    	<script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script href="<?php echo base_url();?>assets/js/jquery.min.js"></script>
        <script href="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
        <script href="<?php echo base_url();?>assets/js/detect.js"></script>
        <script href="<?php echo base_url();?>assets/js/fastclick.js"></script>
        <script href="<?php echo base_url();?>assets/js/jquery.slimscroll.js"></script>
        <script href="<?php echo base_url();?>assets/js/jquery.blockUI.js"></script>
        <script href="<?php echo base_url();?>assets/js/waves.js"></script>
        <script href="<?php echo base_url();?>assets/js/wow.min.js"></script>
        <script href="<?php echo base_url();?>assets/js/jquery.nicescroll.js"></script>
        <script href="<?php echo base_url();?>assets/js/jquery.scrollTo.min.js"></script>

        <!-- App js -->
        <script href="<?php echo base_url();?>assets/js/jquery.core.js"></script>
        <script href="<?php echo base_url();?>assets/js/jquery.app.js"></script>
	
	</body>

</html>