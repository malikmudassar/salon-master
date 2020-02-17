<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Manage your SPA, PARLOR & SALON.">
        <meta name="author" content="Mexyon">

        <!-- App Favicon -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

        <!-- App title -->
        <title>Salonspk | </title>

        
         <!--calendar css-->
        <link href="<?php echo base_url(); ?>assets/plugins/fullcalendar/dist/fullcalendar.css" rel="stylesheet" />
        
        <!-- DataTables -->
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
        
        <!-- App CSS -->
        <link href="<?php echo base_url(); ?>assets/plugins/select2/dist/css/select2.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/plugins/select2/dist/css/select2-bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/plugins/fileuploads/css/dropify.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url();?>assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/plugins/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
         <!-- X-editable css -->
        <link type="text/css" href="<?php echo base_url(); ?>assets/plugins/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script href="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    </head>

    <body>

        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container">

                    <!-- LOGO -->
                    <div class="topbar-left">
                        <a href="<?php echo base_url(); ?>" class="logo"><span>Salons<span>pk</span></span></a>
                    </div>
                    <!-- End Logo container-->


                    <div class="menu-extras">

                        <ul class="nav navbar-nav navbar-right pull-right">
                            <li>
                                <form role="search" class="navbar-left app-search pull-left hidden-xs">
                                    <input type="text" placeholder="Search..." class="form-control">
                                    <a href="#"><i class="fa fa-search"></i></a>
                                </form>
                            </li>
                            <li>
                                <!-- Notification -->
                                <div class="notification-box">
                                    <ul class="list-inline m-b-0">
                                        <li>
                                            <a href="javascript:void(0);" class="right-bar-toggle">
                                                <i class="zmdi zmdi-notifications-none"></i>
                                            </a>
                                            <div class="noti-dot">
                                                <span class="dot"></span>
                                                <span class="pulse"></span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End Notification bar -->
                            </li>

                            <li class="dropdown user-box">
                                <a href="#" class="dropdown-toggle waves-effect waves-light profile " data-toggle="dropdown" aria-expanded="true">
                                    <img src="<?php echo base_url(); ?>assets/images/users/avatar-1.jpg" alt="user-img" class="img-circle user-img">
                                    <div class="user-status away"><i class="zmdi zmdi-dot-circle"></i></div>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0)"><i class="ti-user m-r-5"></i> Profile</a></li>
                                    
                                    <li><a href="javascript:void(0)"><i class="ti-lock m-r-5"></i> Lock screen</a></li>
                                    <li><a href="<?php echo base_url(); ?>logout"><i class="ti-power-off m-r-5"></i> Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="menu-item">
                            <!-- Mobile menu toggle-->
                            <a class="navbar-toggle">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </div>
                    </div>

                </div>
            </div>

            <div class="navbar-custom">
                <div class="container">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">
                            <?php if( $this->session->userdata('role')=="Admin"){?>
                            <li class="active">
                                <a href="<?php echo base_url(); ?>dashboard" class="active"><i class="zmdi zmdi-chart"></i> <span><?php echo $this->session->userdata('role'); ?> </span> </a>
                            </li>
                            <?php } ?>
                            <li>
                                <a href="<?php echo base_url(); ?>reception" class="active"><i class="zmdi zmdi-view-dashboard"></i> <span>Reception </span> </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>appointments" class="active"><i class="zmdi zmdi-alarm-check"></i> <span>Appointments </span> </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>birthdays" class="active"><i class="zmdi zmdi-phone-msg"></i> <span>Birthdays </span> </a>
                            </li>
                                                        <li>
                               <a href="<?php echo base_url(); ?>todayinvoices" class="active"><i class="zmdi zmdi-collection-text"></i> <span> Today's Invoices </span> </a>
                            </li>

                             <?php if($this->session->userdata('role')==="Admin") {?> 
                            
                           
                            <li class="has-submenu">
                                <a href="#"><i class="zmdi zmdi-airline-seat-recline-extra"></i> <span> My Business </span> </a>
                                <ul class="submenu megamenu">
                                    <li>
                                        <ul>
                                            <li><a href="<?php echo base_url(); ?>service_categories">Categories & Services</a></li>
                                            <li><a href="<?php echo base_url(); ?>service_list">All Services List</a></li>
                                            <li><a href="<?php echo base_url(); ?>supplier_list">Suppliers</a></li>
                                            <li><a href="<?php echo base_url(); ?>supplier_list">Customers</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul>
                                           <li><a href="<?php echo base_url(); ?>business_brands">Brands & Products</a></li>
                                           <li><a href="<?php echo base_url(); ?>product_list">All Products List</a></li>
                                           <li><a href="<?php echo base_url(); ?>staff_list">Staff</a></li>
                                           <li>
                                            <a href="<?php echo base_url(); ?>discount_config" >Discounts </a>
                                        </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            
                           
<!--                            <li class="has-submenu">
                                <a href="#"><i class="zmdi zmdi-money"></i><span> Accounts Setup </span> </a>
                                <ul class="submenu megamenu">
                                    <li>
                                        <ul>
                                           <li><a href="<?php echo base_url(); ?>service_list">Banks</a></li>
                                           <li><a href="<?php echo base_url(); ?>service_list">Credit Cards</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <ul>
                                           <li><a href="<?php echo base_url(); ?>service_list">Account Heads</a></li>
                                            <li><a href="<?php echo base_url(); ?>service_list">Taxes</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>-->
                                            
                            <li>
                                <a href="<?php echo base_url(); ?>reports" class="active"><i class="zmdi zmdi-view-dashboard"></i> <span>Reports </span> </a>
                            </li>
                             <?php } ?>
                        </ul>
                        <!-- End navigation menu  -->
                    </div>
                </div>
            </div>
        </header>
        <!-- End Navigation Bar-->

