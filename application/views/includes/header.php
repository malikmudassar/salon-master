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
        <title>SkedWise</title>

        
         <!--calendar css-->
         <?php if(isset($calendar)){?>
        <link href="<?php echo base_url(); ?>assets/plugins/fullcalendar/dist/fullcalendar.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/plugins/fullcalendar/dist/scheduler.min.css" rel="stylesheet" />
         <?php } ?>
        <!-- DataTables -->
        <?php if(!isset($nodatatable)){ ?>
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <?php } ?>
        
        <!-- App CSS -->
        <link href="<?php echo base_url(); ?>assets/plugins/select2/dist/css/select2.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/plugins/select2/dist/css/select2-bootstrap.css" rel="stylesheet" type="text/css">
        

        
        <link href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-sweetalert/sweetalert-1/sweet-alert.css" rel="stylesheet" type="text/css">
        <!--<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-sweetalert/sweetalert-2/sweetalert2.min.css" rel="stylesheet" type="text/css">-->
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
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/plugins/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        
        
         <!-- X-editable css -->
        <!--<link type="text/css" href="<?php echo base_url(); ?>assets/plugins/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">-->
        
        <!--Morris Chart css -->
<!--        <link type="text/css" href="<?php echo base_url(); ?>assets/plugins/morris/morris.css" rel="stylesheet">-->

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <!-- Jquery-Ui -->
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
  
       
    </head>
   <?php 
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
   ?>
    <body>
        <style>
            
            .divider {
                height: 1px;
                margin: 9px 0;
                overflow: hidden;
                background-color: #e5e5e5;
            }
        </style>
        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container">

                    <!-- LOGO -->
                    <div class="topbar-left">
                       <!--<a href="<?php echo base_url(); ?>" class="logo"><span>SkedWise <span><?php echo $this->session->userdata('business');?></span></span></a>-->
                        <a href="<?php echo base_url(); ?>" class="logo"><img width="150" src="<?php echo base_url(); ?>/assets/images/skedwise.png" /><span class="hidden-xs">(<?php echo $this->session->userdata('business');?>)</span></a>
                       <input id="cook" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    </div>
                    <!-- End Logo container-->
                    <div class="menu-extras">

                        <ul class="nav navbar-nav navbar-right pull-right">
                            <li class="hidden">
                                <form role="search" class="navbar-left app-search pull-left hidden-xs">
                                    <input type="text" placeholder="Search..." class="form-control">
                                    <a href="#"><i class="fa fa-search"></i></a>
                                </form>
                            </li>
                            <?php if($this->session->userdata('b_switch')=='Yes' && $this->session->userdata('role')=="Admin" ){?>
                            <li>
                                <div role="search"  class="navbar-left app-search pull-left ">
                                    <button onclick="b_switch();" class="btn btn-sm btn-pink btn-trans waves-effect waves-light">
                                        switch
                                    </button>
                                </div>
                            </li>
                            <?php } else if($this->session->userdata('role')=="Super User" || $this->session->userdata('role')=="HO"){ ?>
                            <li>
                                <div role="search"  class="navbar-left app-search pull-left ">
                                    <button onclick="b_switch();" class="btn btn-sm btn-pink btn-trans waves-effect waves-light">
                                        switch
                                    </button>
                                </div>
                            </li>
                                
                            <?php } ?>
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
                                    <img src="<?php echo getUserProfileImage(); ?>" alt="user-img" class="img-circle user-img">
                                    <div class="user-status away"><i class="zmdi zmdi-dot-circle"></i></div>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo base_url(); ?>user_profile"><i class="ti-user m-r-5"></i> Profile</a></li>
                                    
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
            
            <?php if(isset($menu) && $menu === 'hidden'){} else{ ?>
            <div class="navbar-custom">
                <div class="container">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu clearfix">
                            <?php if( $this->session->userdata('role')=="Admin" || $this->session->userdata('role')=="Super User"){?>
                            <li <?php echo isset($nav) && $nav === 'dashboard' ? 'class="active"' : ''; ?>>
                                <a href="<?php echo base_url(); ?>dashboard"><i class="zmdi zmdi-chart"></i> <span> Dashboard </span> </a>
                            </li>
                            <?php } ?>
<!--                            <li>
                                <a href="<?php echo base_url(); ?>reception" class="active"><i class="zmdi zmdi-view-dashboard"></i> <span>Reception </span> </a>
                            </li>-->
                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Reception" || $this->session->userdata('role')==="Store Manager") {?>
                            <li <?php echo isset($nav) && $nav === 'scheduler' ? 'class="active"' : ''; ?>>
                                <a href="<?php echo base_url(); ?>scheduler"><i class="zmdi zmdi-calendar"></i> <span>Scheduler </span> </a>
                            </li>
                            <?php } else if($this->session->userdata('role')==="HO") {?>
                            <li <?php echo isset($nav) && $nav === 'ho_view' ? 'class="active"' : ''; ?>>
                                <a href="<?php echo base_url(); ?>ho_view"><i class="zmdi zmdi-calendar"></i> <span>Home </span> </a>
                            </li>
                            <?php } ?>
                            <!-- <li>
                                <a href="<?php echo base_url(); ?>appointments" class="active"><i class="zmdi zmdi-alarm-check"></i> <span>Appointments </span> </a>
                            </li> -->
                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User") {?> 
                            <!--<li>
                                <a href="<?php echo base_url(); ?>birthdays" class="active"><i class="zmdi zmdi-phone-msg"></i> <span>Birthdays </span> </a>
                            </li>-->
                            <?php } ?>
                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Reception" || $this->session->userdata('role')==="Store Manager") {?>
                            <li class="has-submenu <?php echo isset($nav) && $nav === 'invoice' ? 'active' : ''; ?>">
                                <a href="#"><i class="zmdi zmdi-collection-text"></i><span> Reception </span> </a>
                                <ul class="submenu megamenu">
                                    <li>
                                        <ul>
                                            <li <?php echo isset($subnav) && $subnav === 'todayinvoices' ? 'class="active"' : ''; ?>>
                                               <a href="<?php echo base_url(); ?>todayinvoices" class="active"> Today's Invoices </a>
                                            </li>
                                            <li <?php echo isset($subnav) && $subnav === 'todayvouchers' ? 'class="active"' : ''; ?>>
                                               <a href="<?php echo base_url(); ?>todayvouchers" class="active"> Today's Vouchers </a>
                                            </li>
                                            <li <?php echo isset($subnav) && $subnav === 'recoveryinvoices' ? 'class="active"' : ''; ?>>
                                               <a href="<?php echo base_url(); ?>recoveryinvoices" class="active"> Recovery Invoices </a>
                                            </li>
                                            <li <?php echo isset($subnav) && $subnav === 'abandonedcarts' ? 'class="active"' : ''; ?>>
                                               <a href="<?php echo base_url(); ?>abandonedcarts" class="active"> Abandoned Carts </a>
                                            </li>
                                            <li <?php echo isset($subnav) && $subnav === 'daily_expenses' ? 'class="active"' : ''; ?>>
                                               <a href="<?php echo base_url(); ?>daily_expenses" class="active"> Daily Expenses </a>
                                            </li>
                                            <li <?php echo isset($subnav) && $subnav === 'package_invoices' ? 'class="active"' : ''; ?>>
                                               <a href="<?php echo base_url(); ?>package_invoices" class="active"> Package Invoices </a>
                                            </li>
                                            <li <?php echo isset($subnav) && $subnav === 'appointments' ? 'class="active"' : ''; ?>>
                                               <a href="<?php echo base_url()."appointments";?>" class="active"> Appointments </a>
                                            </li>
                                            <li <?php echo isset($subnav) && $subnav === 'bookings' ? 'class="active"' : ''; ?>>
                                               <a href="<?php echo base_url(); ?>bookings" class="active"> Bookings </a>
                                            </li>
                                            <li <?php echo isset($subnav) && $subnav === 'dailysheet' ? 'class="active"' : ''; ?>>
                                               <a href="<?php echo base_url(); ?>todaydashboard" class="active"> Daily Sheet </a>
                                            </li>
                                            <li <?php echo isset($subnav) && $subnav === 'dailysummary' ? 'class="active"' : ''; ?>>
                                               <a href="<?php echo base_url(); ?>daily_summary" class="active"> Daily Summary </a>
                                            </li>
                                            
                                        </ul>
                                    </li>
                                    <li>
                                        <ul>
                                            <li <?php echo isset($subnav) && $subnav === 'pricelist' ? 'class="active"' : ''; ?>>
                                               <a href="<?php echo base_url(); ?>pricelist" class="active" target='_blank'> Price List </a>
                                            </li>
                                            <li <?php echo isset($subnav) && $subnav === 'productlist' ? 'class="active"' : ''; ?>>
                                               <a href="<?php echo base_url(); ?>all_products" class="active" > Product List </a>
                                            </li>
                                            <li <?php echo isset($subnav) && $subnav === 'Open Visits' ? 'class="active"' : ''; ?>>
                                               <a href="<?php echo base_url(); ?>openvisits" class="active" > Un Invoiced Visits</a>
                                            </li>
                                            <li <?php echo isset($subnav) && $subnav === 'dispatch' ? 'class="active"' : ''; ?>>
                                                <a href="<?php echo base_url(); ?>dispatch" >Dispatch</a>
                                            </li>
                                            <li <?php echo isset($subnav) && $subnav === 'dailysummary' ? 'class="active"' : ''; ?>>
                                               <a href="<?php echo base_url(); ?>pos_services_view" target="_blank" class="active"> POS-Services </a>
                                            </li>
                                            <!--<li <?php echo isset($subnav) && $subnav === 'dailysummary' ? 'class="active"' : ''; ?>>
                                               <a href="<?php echo base_url(); ?>pos_view" target="_blank" class="active"> POS-Retail </a>
                                            </li>-->
                                            <?php if($this->session->userdata('show_previous')=='Y' || $this->session->userdata('role')=='Admin' || $this->session->userdata('role')=='Super User' ){?>
                                          <!--  <li <?php echo isset($subnav) && $subnav === 'staffperformance' ? 'class="active"' : ''; ?>>
                                                <a href="<?php echo base_url(); ?>staffperformance" >Staff Performance</a>
                                            </li>-->
                                            <?php } ?>
                                            <!--<li <?php //echo isset($subnav) && $subnav === 'daily_sheet_by_category' ? 'class="active"' : ''; ?>>
                                                <a href="<?php //echo base_url(); ?>daily-sheet-by-category" >Daily Sheet By Category</a>
                                            </li>
                                            <li <?php //echo isset($subnav) && $subnav === 'daily_sheet_summary' ? 'class="active"' : ''; ?>>
                                                <a href="<?php //echo base_url(); ?>daily-sheet-summary" >Daily Sheet Summary</a>
                                            </li>-->
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            
                            <?php if(isset($scheduler_style[0]['pos_enabled']) && $scheduler_style[0]['pos_enabled']=="Yes" && $this->session->userdata('role')==="Reception"){ ?>
                                <li <?php echo isset($nav) && $nav === 'scheduler' ? 'class="active"' : ''; ?>>
                                    <a href="<?php echo base_url(); ?>pos_services_view" target="_blank"><i class="zmdi zmdi-money"></i> <span>POS </span> </a>
                                </li>
                               
                            <?php } ?>
                            
                            <li></li>
                            
                            
                            <?php } if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Store Manager" || $this->session->userdata('role')==="HR") {?> 
                            
                           
                            <li class="has-submenu <?php echo isset($nav) && $nav === 'my_business' ? 'active' : ''; ?>">
                                <a href="#"><i class="zmdi zmdi-airline-seat-recline-extra"></i> <span> My Business </span> </a>
                                <ul class="submenu megamenu">
                                    <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Store Manager") {?> 
                                    <li>
                                        <ul>
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Store Manager") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'servicetypes' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>servicetypes">Type, Category & Service</a></li>
                                            <!--<li><a href="<?php echo base_url(); ?>service_categories">Categories & Services</a></li>-->
                                            <?php } ?>
                                            
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Store Manager") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'servicelist' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>service_list">All Services List</a></li>
                                            <?php } ?>
                                            
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Store Manager") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'package_types' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>package/types">Deal Packages</a></li>
                                            <?php } ?>
                                            
                                           
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'customers' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>customer_list">Customers</a></li>
                                            <?php } ?>
                                            
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Store Manager") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'color_types' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>color_types">Color Types</a></li>
                                            <?php } ?>
                                            
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Store Manager") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'voucher_list' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>voucher_list">Voucher List</a></li>
                                            <?php } ?>
                                            
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'facial_record_list' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>facial_records">Facial records</a></li>
                                            <?php } ?>
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'unit_list' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>unit_list">Measurement Units</a></li>
                                            <?php } ?>
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'eyelashes_record' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>eyelashes_records">Eye lashes Record</a></li>
                                            <?php } ?>

                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" && $this->session->userdata('loyalty_enable')==="Y") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'smssender' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>smssender">Custom SMS </a></li>
                                            <li <?php echo isset($subnav) && $subnav === 'smslog' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>smslog">SMS Log </a></li>
                                            <?php }?>
                                        </ul>
                                    </li>
                                    <?php } ?>
                                    <li>
                                        <ul>
                                            
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Store Manager") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'business_brands' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>business_brands">Brands & Products</a></li>
                                            <?php } ?>
                                            <!--
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Store Manager") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'product_list' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>product_list/professional/0">Professional Products</a></li>
                                            <?php } ?>
                                            
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Store Manager") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'product_list_retail' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>product_list/retail/0">Retail Products</a></li>
                                            <?php } ?>                                            
                                            -->
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Store Manager") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'supplier_list' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>supplier_list">Suppliers</a></li>
                                            <?php } ?>
                                            
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="HR") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'staff' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>staff_list">Staff</a></li>
                                            <?php } ?>
                                            
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'discount' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>discount_config" >Discounts </a></li>
                                            <?php } ?>
                                            
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'business_timing' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>business_timing" >Business Timings </a></li>
                                            <?php } ?>
                                            
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Store Manager") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'color_record' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>color_records" >Color Records </a></li>
                                            <?php } ?>
                                            
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'time_block_reason' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>time_block_reason" >Time Block Reasons</a></li>
                                            <?php } ?>
                                            
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'business' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>business" >Business</a></li>
                                            <?php } ?>
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'loyaltyservices' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>loyalty_services">Loyalty Setting</a></li>
                                            <?php } ?>
                                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" && $this->session->userdata('loyalty_enable')==="Y") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'scheduled_tasks' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>scheduled_tasks">Scheduled Tasks</a></li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                             <?php } ?>
                            <?php if($this->session->userdata('programs')==='Yes' && $this->session->userdata('role')!=="Store Manager" && $this->session->userdata('role')!=="Feedback"){?>
                            
                           <li class="has-submenu <?php echo isset($nav) && $nav === 'Programs' ? 'active' : ''; ?>">
                                <a href="<?php echo base_url('programsdashboard'); ?>"><i class="zmdi zmdi-walk"></i> <span>Programs </span> </a>
                                
                                <ul class="submenu megamenu">
                                    <?php if($this->session->userdata('gym')==='Yes'){?>                              
                                    <li>
                                        <ul>
                                            <li><a href="<?php echo base_url(); ?>gymdashboard"><strong>GYM</strong></a></li>
                                            <li <?php echo isset($subnav) && $subnav === 'GymRegister' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>gymsearch" >Enroll A Client</a></li>
                                            <li <?php echo isset($subnav) && $subnav === 'ProgramMembers' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>program_members/1" >Gym Members</a></li>
                                            <li style="border-top: 1px solid #f7f7f7"  <?php echo  isset($subnav) && $subnav === 'GymPrograms' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>programs/1" >Gym Programs</a></li>
                                            
                                            
                                        </ul>
                                    </li>
                                     <?php } ?>
                                    <?php if($this->session->userdata('training')==='Yes'){?>
                                    <li>
                                        <ul>
                                            <li><a href="<?php echo base_url(); ?>trainingdashboard"><strong>Courses</strong></a></li>
                                            <li <?php echo isset($subnav) && $subnav === 'TrainingRegister' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>trainingsearch" >Enroll A Client</a></li>
                                            <li <?php echo isset($subnav) && $subnav === 'ProgramMembers' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>program_members/2" >Program Members</a></li>
                                            <li style="border-top: 1px solid #f7f7f7" <?php echo isset($subnav) && $subnav === 'TrainingPrograms' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>programs/2" >Training Programs</a></li>
                                            
                                        </ul>
                                    </li>
                                    <?php } ?>
                                    <?php if($this->session->userdata('recurring')==='Yes'){?>
                                    <li>
                                        <ul>
                                            <li><a href="<?php echo base_url(); ?>recurringdashboard"><strong>Recurring Payments</strong></a></li>
                                            <li <?php echo isset($subnav) && $subnav === 'RecurringRegister' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>recurringsearch" >Enroll A Client</a></li>
                                            <li <?php echo isset($subnav) && $subnav === 'ProgramMembers' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>program_members/3" >Program Members</a></li>
                                            <li style="border-top: 1px solid #f7f7f7" <?php echo isset($subnav) && $subnav === 'RecurringPrograms' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>programs/3" >Recurring Payment Plans</a></li>
                                            
                                        </ul>
                                    </li>
                                    <?php } ?>
                                </ul>        
                            </li>
                            <?php if($this->session->userdata('role')==="Trainer"){?> 
                                 <li <?php echo isset($nav) && $nav === 'scheduler' ? 'class="active"' : ''; ?>>
                                    <a target="_blank" href="<?php echo base_url('scheduler_view_only');?>"><i class="zmdi zmdi-calendar"></i> <span>Scheduler </span> </a>
                                </li>
                            <?php } ?>
                            <?php } ?>
                            <?php if($this->session->userdata('role')==="Store Manager" || $this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="HR" || $this->session->userdata('role')==="Accountant") {?>                
                            <li class="has-submenu <?php echo isset($nav) && $nav === 'reports' ? 'active' : ''; ?>">
                                <a href="#"><i class="zmdi zmdi-view-dashboard"></i> <span>Reports </span> </a>
                                <ul class="submenu">
                                    <li <?php echo isset($subnav) && $subnav === 'reports' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>reports" >Reports</a></li>
                                    <?php if($this->session->userdata('role')!=="Store Manager"){?>
                                    <li <?php echo isset($subnav) && $subnav === 'staff_sale' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>staff_sale" >Staff Chart </a></li>
                                    <li <?php echo isset($subnav) && $subnav === 'retail_charts' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>retail_charts" >Retail Charts</a></li>
                                    <li <?php echo isset($subnav) && $subnav === 'service_chart' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>service/chart" >Service Chart</a></li>
                                    <li class="divider"></li>
                                    <li <?php echo isset($subnav) && $subnav === 'marketing_report' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>marketing" >Monthly Staff Detail</a></li>
<!--                                <li <?php echo isset($subnav) && $subnav === 'petty_cash_report' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>petty-cash-report" >Petty Cash Report</a></li>
                                    <li <?php echo isset($subnav) && $subnav === 'retail_Transaction' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>retail-transaction" >Retail Transaction</a></li>
                                    <li <?php echo isset($subnav) && $subnav === 'retail_Transaction_By_Item' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>retail-transaction-by-item" >Retail Transaction By Item</a></li>
                                    <li <?php echo isset($subnav) && $subnav === 'service_By_Item' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>service-by-item" >Service By Item</a></li>
                                    <li <?php echo isset($subnav) && $subnav === 'service_By_Staff' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>service-by-staff" >Service By Staff</a></li>
                                    <!--<li <?php echo isset($subnav) && $subnav === 'marketing_summary' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>marketing-summary" >Monthly Staff Summary</a></li>-->
                                    <!--<li <?php echo isset($subnav) && $subnav === 'sales' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>sales" >Customized report</a></li>-->
                                    <?php } ?>
                                    
                                    
                                </ul>
                            </li>
                            
                            <?php } if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Store Manager" || $this->session->userdata('role')==="Accountant") {?>
                            <li class="has-submenu <?php echo isset($nav) && $nav === 'procurement' ? 'active' : ''; ?>">
                                <a href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Procurement </span> </a>
                                <ul class=" submenu">
                                    <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Store Manager" || $this->session->userdata('role')==="Accountant") {?>
                                        <li <?php echo isset($subnav) && $subnav === 'business_brands' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>business_brands">Brands & Products</a></li>
                                    <?php } ?>
                                    <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Store Manager" || $this->session->userdata('role')==="Accountant") {?>
                                        <li <?php echo isset($subnav) && $subnav === 'product_list' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>all_products">All Products List</a></li>
                                    <?php } ?>
                                    <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Store Manager" || $this->session->userdata('role')==="Accountant") {?>
                                        <li <?php echo isset($subnav) && $subnav === 'product_list' ? 'class="active"' : ''; ?>><a class="text-danger" href="<?php echo base_url(); ?>product_list/threshold/0">Low On Stock</a></li>
                                    <?php } ?>    
                                    <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Store Manager" || $this->session->userdata('role')==="Accountant") {?>
                                        <li <?php echo isset($subnav) && $subnav === 'product_list' ? 'class="active"' : ''; ?>><a class="text-danger" href="<?php echo base_url(); ?>product_list/expiring/0">About to Expire</a></li>
                                    <?php } ?>
                                    <?php if($this->session->userdata['common_products']=='Yes'){?>
                                        <?php if($this->session->userdata('ho')=='Yes' && $this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Store Manager" || $this->session->userdata('role')==="Accountant") {?>
                                            <li <?php echo isset($subnav) && $subnav === 'product_list' ? 'class="active"' : ''; ?>><a class="text-danger" href="<?php echo base_url(); ?>transfer">Inventory Transfer</a></li>
                                        <?php } ?>  
                                    <?php } ?>
                                    <li class="divider"></li>
                                    <li <?php echo isset($subnav) && $subnav === 'purchaseorder' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>purchase_orders" >Purchase Orders</a></li>
                                    <li <?php echo isset($subnav) && $subnav === 'transfer' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>transfer" >Transfer Notes</a></li>
                                    <li <?php echo isset($subnav) && $subnav === 'dispatch' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>dispatch" >Dispatch</a></li>
                                </ul>
                            </li>
                            
                            <?php }?>
                             <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User" || $this->session->userdata('role')==="Accountant") {?>                
                            <li class="has-submenu">
                                <a href="#"><i class="zmdi zmdi-money"></i><span> Accounting </span> </a>
                                <ul class="submenu megamenu">
                                    <li>
                                        <ul>
                                           <li <?php echo isset($subnav) && $subnav === 'accounting' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>coa">Chart of Accounts</a></li>                                           
                                        </ul>
                                        <ul>
                                            <li <?php echo isset($subnav) && $subnav === 'accounting' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>account_vouchers">Account Vouchers</a></li>
                                        </ul>
<!--                                        <ul>
                                            <li <?php echo isset($subnav) && $subnav === 'accounting' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>statement">Statement</a></li>
                                        </ul>-->
                                        <ul>
                                            <li <?php echo isset($subnav) && $subnav === 'accounting' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>general_ledger">General Ledger</a></li>
                                        </ul>
                                        <ul>
                                            <li <?php echo isset($subnav) && $subnav === 'accounting' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>trial_balance">Trial Balance</a></li>
                                        </ul>
                                        <ul>
                                            <li <?php echo isset($subnav) && $subnav === 'accounting' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>balacne_sheet">Balance Sheet</a></li>
                                        </ul>
                                        <ul>
                                            <li <?php echo isset($subnav) && $subnav === 'accounting' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>profit_loss">Profit & loss Statement</a></li>
                                        </ul>
                                        <ul>
                                            <li <?php echo isset($subnav) && $subnav === 'accounting' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>cashregister_listing">Cash Register posting</a></li>
                                        </ul>
                                    </li>
                                    
                                </ul>
                            </li>
                            <?php } ?>    
                            
                                
                            <?php if($this->session->userdata('role')==="Admin" || $this->session->userdata('role')=="Super User") {?>
                            <li class="has-submenu <?php echo isset($nav) && $nav === 'users' ? 'active' : ''; ?>">
                                <a href="#"><i class="fa fa-user" aria-hidden="true"></i> <span>Administration</span> </a>
                                <ul class=" submenu">
                                    <li <?php echo isset($subnav) && $subnav === 'users_list' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>users_list">User Management</a></li>
                                    
                                </ul>
                            </li>
                            <?php } if($this->session->userdata('role')==="Super User") {?>
                            <li class="has-submenu <?php echo isset($nav) && $nav === 'users' ? 'active' : ''; ?>">
                                <a href="#"><i class="ti-medall" aria-hidden="true"></i> <span>Super User</span> </a>
                                <ul class=" submenu">
                                    <li <?php echo isset($subnav) && $subnav === 'Supervise Invoices' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>super_invoices">Supervise Invoices</a></li>
                                    <li <?php echo isset($subnav) && $subnav === 'Supervise Visits' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>super_visits">Supervise Visits</a></li>
                                    <!--<li <?php echo isset($subnav) && $subnav === 'customersuper' ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>coa">Supervise Customers</a></li>-->
                                </ul>
                            </li>
                            <?php } ?>
                        </ul>
                        <!-- End navigation menu  -->
                    </div>
                </div>
            </div>
            <?php } ?>
        </header>
        <!-- End Navigation Bar-->
  <script>
        $(document).ready(function() {
            $.ajaxSetup({
              beforeSend: function(xhr, settings) {
                  if (settings.type == 'POST' || settings.type == 'PUT' || settings.type == 'DELETE') {
                      function getCookie(name) {
                          var cookieValue = null;
                          if (document.cookie && document.cookie != '') {
                              var cookies = document.cookie.split(';');
                              for (var i = 0; i < cookies.length; i++) {
                                  var cookie = jQuery.trim(cookies[i]);
                                  // Does this cookie string begin with the name we want?
                                  if (cookie.substring(0, name.length + 1) == (name + '=')) {
                                      cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                                      break;
                                  }
                              }
                          }
                          return cookieValue;
                      }
                      
                      //if (!(/^http:.*/.test(settings.url) || /^https:.*/.test(settings.url))) {
                          // Only send the token to relative URLs i.e. locally.
                           xhr.setRequestHeader("X-Csrf-Token", getCookie('csrf_cookie_name'));
                           $("#cook").val(getCookie('csrf_cookie_name'));                       
                           var data = settings.data;

                           var extra = 'csrf_test_name='+$("#cook").val()+"&";
                           if(typeof data != 'undefined' && data.length>0){                           
                              
                              settings.data = extra+data;                           
                           } else {
                              
                              //var csrf={'csrf_test_name':$("#cook").val()};
                              settings.data='csrf_test_name='+$("#cook").val(); 
                              //settings.data=$.param(settings.data,false);
                           }
                      //}
                  }
              },
              complete: function() {
                  function getCookie(name) {
                          var cookieValue = null;
                          if (document.cookie && document.cookie != '') {
                              var cookies = document.cookie.split(';');
                              for (var i = 0; i < cookies.length; i++) {
                                  var cookie = jQuery.trim(cookies[i]);
                                  // Does this cookie string begin with the name we want?
                                  if (cookie.substring(0, name.length + 1) == (name + '=')) {
                                      cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                                      break;
                                  }
                              }
                          }
                          return cookieValue;
                      }                      
                      //if (!(/^http:.*/.test(settings.url) || /^https:.*/.test(settings.url))) {
                          // Only send the token to relative URLs i.e. locally.
                           
                           $("#cook").val(getCookie('csrf_cookie_name'));                       
                          
                      //}
              }
           });
        });
  </script>
