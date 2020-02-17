

<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">

                <h4 class="page-title">Reception</h4>
            </div>
        </div>

        <div class="row" id="divsearch">
            <div class="col-lg-12">
                <div id="searchpanel" class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">Search Customer:</h4>
                    <!--General Search Form
                    <div class="row">
                        <div class="col-lg-12 m-b-30">
                            
                            <div id="customersearchform">
                                <div class="input-group">
                                    <input type="text" id="customer-search" name="customer-search" class="form-control" placeholder="General Search">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn waves-effect waves-light btn-primary" id="btncustomer-search"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                     End General Search -->
                    <div class="row">
                        <div class="col-lg-4 m-b-30">
                            <!--Name Search Form-->
                            <div id="namesearchform">
                                <div class="input-group">
                                    <input type="text" id="name-search" name="name-search" class="form-control" placeholder="Name Search">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn waves-effect waves-light btn-pink" id="btnname-search"><i class="fa fa-tag"></i></button>
                                    </span>
                                </div>
                            </div>
                            <!--End Name Search -->
                        </div>
                        <div class="col-lg-4 m-b-30">
                            <!--Cell Phone Search Form-->
                            <div id="cellsearchform">
                                <div class="input-group">
                                    <input type="text" id="cell-search" name="cell-search" class="form-control" placeholder="Cell Phone Search">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn waves-effect waves-light btn-custom" id="btncell-search"><i class="fa fa-phone"></i></button>
                                    </span>
                                </div>
                            </div>
                            <!--End Name Search -->
                        </div>
                        <div class="col-lg-4 m-b-30">
                            <!--Email Search Form-->
                            <div id="emailsearchform">
                                <div class="input-group">
                                    <input type="email" id="email-search" name="email-search" class="form-control" placeholder="Email Search">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn waves-effect waves-light btn-purple" id="btnemail-search" ><i class="fa fa-envelope"></i></button>
                                    </span>
                                </div>
                            </div>
                            <!--End Name Search -->
                        </div>
                    </div>     
                </div> 
            </div>
        </div>
        <div id="multiplesearch" class="row" style="display:none;">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="dropdown pull-right open">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="true">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:void(0);" onclick="hidemultisearch()">Hide</a></li>
                        </ul>
                    </div>
                    <h4 class="header-title m-t-0 m-b-30">Searched Customers:</h4>
                    <div class="row">
                        <div id="customer_list" class="inbox-widget nicescroll" style="height: 315px; overflow: hidden; outline: none;" tabindex="5000">

                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="row" id="divmain" >
            <div class="col-lg-6">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">Customer Details:</h4>
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <form class="form-horizontal" role="form" id="customerform">
                                <div class="form-group has-feedback">
                                    <label class="col-sm-4 control-label">Reference #</label>
                                    <div class="col-sm-8">
                                        <input readonly="readonly" type="text" id="txt-customer-id" name="txt-customer-id" class="form-control" placeholder="Reference #">
                                        <!--<i class="fa fa-tag form-control-feedback l-h-34"></i>-->
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="col-sm-4 control-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="txt-customer-name" name="txt-customer-name" class="form-control" placeholder="Name">
                                        <!--<i class="fa fa-user form-control-feedback l-h-34"></i>-->
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="col-sm-4 control-label">Email</label>
                                    <div class="col-sm-8">
                                        <input type="email"  id="txt-customer-email" name="txt-customer-email" class="form-control" parsley-type="email" parsley-trigger="change" required placeholder="Email">
                                        <!--<i class="fa fa-envelope form-control-feedback l-h-34"></i>-->
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="col-sm-4 control-label">Cell</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="txt-customer-cell" name="txt-customer-cell" class="form-control" placeholder="Cell Phone">
                                        <!--<i class="fa fa-phone form-control-feedback l-h-34"></i>-->
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="col-sm-4 control-label">Address</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="txt-customer-address" name="txt-customer-address"  class="form-control" placeholder="Address">
                                        <!--<i class="fa fa-location-arrow form-control-feedback l-h-34"></i>-->
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-sm-4 control-label">Birthday</label>
                                    <div class="col-sm-3">
                                        <!--<input type="text" id="txt-customer-bday" name="txt-customer-bday" class="form-control" placeholder="Day">-->
                                        <select id="txt-customer-bday" name="txt-customer-bday" class="form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>

                                    <div class="col-sm-5">
                                        <select id="txt-customer-bmonth" name="txt-customer-bmonth" class="form-control">
                                            <option value=""></option>
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div style="display:none" class="col-lg-4 hidden-md hidden-sm hidden-xs">
                            <div id = "imgdisplay" style="display:block; text-align: center;">
                                <img src="<?php echo base_url(); ?>assets/images/users/avatar-1.jpg" id="img-customer" name="img-customer" alt="customer" style="width:100%"/>
                                <input id="img-customer-file" type="hidden" value="avatar-1.jpg"/>
                                <br/>
                                <button onclick="changepic();"  type="button" class="btn btn-sm btn waves-effect w-md waves-success m-b-5">Change</button>
                            </div>
                            <div id = "imguploader" style="display:none;">
                                <input id="img-uploader-customer" name="img-uploader-customer" data-height="300" type="file" class="dropify"  />
                            </div>
                        </div>

                    </div>

                    <div class="row p-20">
                        <div class="col-lg-12">
                            <button  id="btnclear" type="button" onclick="clearcustomerform();" class="btn btn-default waves-effect w-md m-b-5">Clear</button>
                            <button id="btnupdate" onclick="addeditcustomer();" type="button" class="btn btn-purple btn waves-effect waves-primary w-md m-b-5">Add New</button>
                            <button type="button" onclick="openAppointment();" class="btn btn-pink btn waves-effect w-md waves-info m-b-5">Appointments</button>
                            <button type="button" onclick="openVisit(0);" class="btn btn-warning btn waves-effect w-md waves-success m-b-5">Services</button>
                            <button type="button" onclick="openOrder(0);" class="btn btn-custom btn waves-effect w-md waves-success m-b-5">Products</button>
                            <button type="button" onclick="giftVoucherForm();" class="btn btn-success btn waves-effect w-md waves-success m-b-5">Generate Vouchers</button>
                            <button type="button" onclick="$('#verifyVoucherModal').modal({backdrop:'static',keyboard:false,show:true}); $('#voucherHtml').hide(); $('#voucherHtml').html('');" class="btn btn-success btn waves-effect w-md waves-success m-b-5">Verify Vouchers</button>
                            <button type="button" onclick="window.open('<?php echo base_url("customer_history") ?>/'+$('#txt-customer-id').val())" class="btn btn-info btn waves-effect w-md waves-success m-b-5 history-customer">History</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--BEING SERVICED-->
            <div class="col-lg-3">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">Being Serviced:</h4>
                    <div class="row">
                        <div id="beingserviced" class="inbox-widget nicescroll" style="height: 400px; overflow: hidden; outline: none;" tabindex="5000">

                        </div>
                    </div>
                </div>
            </div>
            <!--END BEING SERVICED-->
            <!--Staff-->
            <div class="col-lg-3">
                <div class="card-box">
                    <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:void(0)" onclick="getabsentstaff();">Time In</a></li>
                            <li><a href="javascript:void(0)" onclick="getpresentstaff();">Time Out</a></li>

                            <li class="divider"></li>
                            <li><a href="#">Staff List</a></li>
                        </ul>
                    </div>

                    <h4 class="header-title m-t-0 m-b-30">Who&apos;s In Today</h4>
                    <div class="row">
                        <div id="presentstaff" class="inbox-widget nicescroll" style="height: 360px; overflow: hidden; outline: none;" tabindex="5000">

                        </div>
                        <div style="text-align: right">
                            <button  type="button" onclick="getpresentstaff();" class="btn btn-danger btn waves-effect w-md waves-info m-b-5">Time Out</button>
                            <button  type="button" onclick="getabsentstaff();" class="btn btn-pink btn waves-effect w-md waves-info m-b-5">Time In</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--END Appointments-->

        </div>
        <!--Visit Service Form-->
        <div class="row" id="divvisit" style="display:none;">
            <div class="col-md-8">
                <!--<form id="visitform">-->
                <div class="card-box">
                    <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:void(0)" onclick="">View Search</a></li>
                            <li><a href="javascript:void(0)" onclick="">View Customer</a></li>

                            <li class="divider"></li>
                            <li><a href="#">Invoice</a></li>
                        </ul>
                    </div>

                    <h4 class="header-title m-t-0 m-b-30">Enter Customer Visit Details: <span id="visitcustomername"></span></h4>
                    <div id="customer_alert" class="row" style="display: none">
                        <div id="alert_text" class="alert alert-danger">
                            <strong>Customer Alert!</strong>
                        </div>
                    </div>
                    <div class="row hidden">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="visit-customer-name" class="control-label">Name</label>
                                <input readonly="readonly" type="text" class="form-control" id="visit-customer-name" name="visit-customer-name" placeholder="Name">
                                <input type="hidden" class="form-control" id="visit-customer-id" name="visit-customer-id">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="visit-customer-cell" class="control-label">Cell Number</label>
                                <input readonly="readyonly" type="text" class="form-control" id="visit-customer-cell" name="visit-customer-cell" placeholder="Cell Phone">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="visit-customer-email" class="control-label">Email</label>
                                <input readonly="readyonly" type="text" class="form-control" id="visit-customer-email" name="visit-customer-email" placeholder="Email">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                <label class="control-label">Services Categories</label>
                                <div id="visit-services-categories" class="nicescroll_2" style="height: 350px; overflow: hidden; outline: none;">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                <label for="visit-services" class="control-label">Select Services</label>
                                <div id="visit-services" class="nicescroll_3" style="height: 350px; overflow: hidden; outline: none;">
                                    <div style="display: none;" id="fa-spinner" class="fa fa-spin fa-spinner"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                <label for="visit-products" class="control-label">Select Products</label>
                                <div id="visit-products" class="nicescroll_products" style="height: 350px; overflow: hidden; outline: none;">
                                    <div style="display: none;" id="fa-spinner" class="fa fa-spin fa-spinner"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="visit-staff" class="control-label">Select Staff</label>
                                <select class="form-control" id="visit-staff" name="visit-staff"> 
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="visit-date" class="control-label">Date & Time (for appointment)</label>
                                <input type="text" class="form-control" id="visit-date" name="visit-date" value="<?php echo date('Y-m-d H:i:00'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-6'></div>
                        <div class='col-md-6'>
                            <button style='float:right' onclick='addServiceRows();' type='button' class='btn btn-sm btn-purple waves-effect '>Add Service <i class='ti-arrow-circle-down'></i></button>
                        </div>
                    </div>
                    <div class='row ' style="min-height: 150px;">
                        <div id='visit-service-list' class='col-md-12'>
                            <div class="table-responsive">
                                <table class="table" id="visittbl">
                                    <thead>
                                        <tr>
                                            <th style="display:none;">Customer ID</th>
                                            <th>#</th>
                                            <th>Service</th>
                                            <th style="display:none;">Staff ID</th>
                                            <th>Staff</th>
                                            <th style="display:none;">Product ID</th>
                                            <th>Product Used</th>
                                            <th>Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="text-align: right">
                        <form action="open_new_invoice" method="post" target="_blank">
                        <input type="hidden" class="form-control" id="visit-id" name="visit-id">
                        <div class="col-md-6" style="text-align:left">
                            <button id="btngeninvoice" style='display:none;' class="btn btn-pink waves-effect waves-light">Generate Invoice</button>
                        </div>
                        </form>
                        <div class="col-md-6" style="text-align: right">
                            <button type="button" onclick="openmain();" class="btn btn-default waves-effect" >Close</button>
                            <button type="button" onclick="updatevisit();" class="btn btn-info waves-effect waves-light">Save Changes</button>
                        </div>
                    </div>
                </div>
                <!--</form>-->
            </div>

            <div class="col-md-4">
                <div class="card-box">

                    <h4 class="header-title m-t-0 m-b-30">Previous Visits:</h4>
                    <div class="table-responsive nicescroll" id="tbllastvisits" style="height:370px;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Visit Date</th>
                                    <th>Service</th>
                                    <th>Staff</th>
                                    <th>Products</th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <!--End Visit Form-->

        <!--Products Sale Form-->
        <div class="row" id="divorder" style="display:none;">
            <div class="col-md-8">
                <!--<form id="visitform">-->
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">Create Customer Product Order</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="order-customer-name" class="control-label">Name</label>
                                <input readonly="readonly" type="text" class="form-control" id="order-customer-name" name="order-customer-name" placeholder="Name">
                                <input type="hidden" class="form-control" id="order-customer-id" name="order-customer-id">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="order-customer-cell" class="control-label">Cell Number</label>
                                <input readonly="readyonly" type="text" class="form-control" id="order-customer-cell" name="order-customer-cell" placeholder="Cell Phone">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="order-customer-email" class="control-label">Email</label>
                                <input readonly="readyonly" type="text" class="form-control" id="order-customer-email" name="order-customer-email" placeholder="Email">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="order-products" class="control-label">Select Product</label>
                                <select class='form-control' id="order-products" name="order-products" > 

                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="order-staff" class="control-label">Sold By</label>
                                <select class='form-control'  id="order-staff" name="order-staff"> 

                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="order-customer-qty" class="control-label">Qty.</label>
                                <!--<input type="text" class="form-control numeric" id="order-customer-qty" name="order-customer-qty" placeholder="Qty">-->

                                <input class="vertical-spin form-control numeric" type="text" id="order-customer-qty" name="order-customer-qty" >


                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-6'></div>
                        <div class='col-md-6'>
                            <button style='float:right' onclick='addOrderRows();' type='button' class='btn btn-sm btn-purple waves-effect '>Add Product <i class='ti-arrow-circle-down'></i></button>
                        </div>
                    </div>
                    <div class='row ' style="min-height: 150px;">
                        <div id='order-product-list' class='col-md-12'>
                            <div class="table-responsive">
                                <table class="table" id="ordertbl">
                                    <thead>
                                        <tr>
                                            <th style="display:none;">Customer ID</th>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th style="display:none;">Staff ID</th>
                                            <th>Sold By</th>
                                            <th>Qty.</th>
                                            <th>Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="text-align: right">
                        <form action="open_order_invoice" method="post" target="_blank">
                        <input type="hidden" class="form-control" id="order-id" name="order-id">
                        <div class="col-md-6" style="text-align:left">
                            <button id="btngenorderinvoice" style='display:none;' class="btn btn-pink waves-effect waves-light">Generate Invoice</button>
                        </div>
                        </form>
                        <div class="col-md-6" style="text-align: right">
                            <button type="button" onclick="openmain();" class="btn btn-default waves-effect" >Close</button>
                            <button type="button" onclick="updateorder();" class="btn btn-info waves-effect waves-light">Save Changes</button>
                        </div>
                    </div>
                </div>
                <!--</form>-->
            </div>

            <div class="col-md-4">
                <div class="card-box">

                    <h4 class="header-title m-t-0 m-b-30">Previous Orders:</h4>
                    <div class="table-responsive nicescroll" id="tbllastorders" style="height:370px;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order Date</th>
                                    <th>Product</th>
                                    <th>Qty.</th>
                                    <th>Sold by</th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>        

        <!--End Products Sale Form-->
        <!--End Page Content-->


        <!--Update Customer Model-->
        <div id="con-close-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Update Customer Details:</h4>
                    </div>
                    <form id="updateform">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="detail-customer-name" class="control-label">Name</label>
                                        <input type="text" class="form-control" id="detail-customer-name" name="detail-customer-name" placeholder="Name">
                                        <input type="hidden" class="form-control" id="detail-customer-id" name="detail-customer-id">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="detail-customer-cell" class="control-label">Cell Number</label>
                                        <input type="text" class="form-control" id="detail-customer-cell" name="detail-customer-cell" placeholder="Cell Phone">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="detail-customer-phone1" class="control-label">Phone 1</label>
                                        <input type="text" class="form-control" id="detail-customer-phone1" name="detail-customer-phone1"  placeholder="Phone 1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="detail-customer-phone2" class="control-label">Phone 2</label>
                                        <input type="text" class="form-control" id="detail-customer-phone2" name="detail-customer-phone2"  placeholder="Phone 2">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="detail-customer-email" class="control-label">Email</label>
                                        <input type="email" class="form-control email" parsley-trigger="change" id="detail-customer-email" name="detail-customer-email" placeholder="Email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="detail-customer-address" class="control-label">Address</label>
                                        <input type="text" class="form-control" id="detail-customer-address" name="detail-customer-address" placeholder="Address">
                                    </div>
                                </div>
                            </div>
                            <div class="row m-b-5">
                                <div class="col-md-6">m
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="" class="control-label">Wedding Anniversary</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="yyyy/mm/dd" id="detail-customer-wedding" name="detail-customer-wedding">
                                                <span class="input-group-addon bg-info b-0 text-white"><i class="ti-calendar"></i></span>
                                            </div><!-- input-group -->
                                        </div>
                                    </div>                                
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <label for="detail-customer-bday" class="control-label">Birthday</label>
                                        </div>
                                        <div class="col-lg-4">
                                            <select id="detail-customer-bday" name="detail-customer-bday" class="form-control">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <div class="col-lg-8">
                                            <select id="detail-customer-bmonth" name="detail-customer-bmonth" class="form-control">
                                                <option value=""></option>
                                                <option value="January">January</option>
                                                <option value="February">February</option>
                                                <option value="March">March</option>
                                                <option value="April">April</option>
                                                <option value="May">May</option>
                                                <option value="June">June</option>
                                                <option value="July">July</option>
                                                <option value="August">August</option>
                                                <option value="September">September</option>
                                                <option value="October">October</option>
                                                <option value="November">November</option>
                                                <option value="December">December</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label for="detail-customer-allergies" class="control-label text-danger">Allergies Alert</label>
                                        <input class="form-control" id="detail-customer-allergies" name="detail-customer-allergies" placeholder="Note down any allergies the customer may have" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label for="detail-customer-alert" class="control-label text-warning">Custom Alert</label>
                                        <input class="form-control" id="detail-customer-alert" name="detail-customer-alert" placeholder="Note down any other alerts you want to get when the customer visits . . ." />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                            <button type="button" onclick="updatecustomer();" class="btn btn-info waves-effect waves-light">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
        <!--End Update Customer Model-->
        
        <!--Voucher Model-->
        <div id="voucherModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="voucherModal" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Gift Voucher</h4>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-box">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <label class="control-label">Voucher Type</label>
                                            <div style="border: 1px solid #ddd; border-radius: 4px; padding: 8px;">
                                                <div class="radio radio-pink pull-left" style="margin: 0px;">
                                                    <input class="form-control" name="voucher-type" value="amount" type="radio">
                                                    <label>Amount</label>
                                                </div>
                                                <div class="radio radio-pink pull-right" style="margin: 0px;">
                                                    <input class="form-control" name="voucher-type" value="service" type="radio">
                                                    <label>Service</label>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <label class="control-label" for="voucher-valid-until">Valid Until</label>
                                                <input id="voucher-valid-until" name="voucher-valid-until" class="form-control" type="text" placeholder="Click here">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="voucher-number-optional">Voucher # <small>(optional)</small></label>
                                                <input id="voucher-number-optional" name="voucher-number-optional" class="form-control numeric" type="text" placeholder="optional">
                                            </div>

                                        </div>

                                        <div id="voucher-price-div" style="display: none;">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Voucher Price</label>
                                                    <input id="voucher-price" name="voucher-price" class="form-control numeric" type="text" placeholder="Amount">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="voucher-services-div" style="display: none;">
                                            <div class="col-md-4">
                                                <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                                    <label class="control-label">Services Categories</label>
                                                    <div id="voucher-services-categories" class="nicescroll_4" style="height: 190px; overflow: hidden; outline: none;">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                                    <label for="voucher-services" class="control-label">Select Services</label>
                                                    <div id="voucher-services" class="nicescroll_5" style="height: 190px; overflow: hidden; outline: none;">
                                                        <div style="display: none;" id="fa-spinner" class="fa fa-spin fa-spinner"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
<!--                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>-->
                        <span id="voucherNumber" style="display: none;"></span>
                        <a href="" target="_blank" style="display: none;" id="voucherBtnPreview" class="btn btn-default waves-effect waves-light">Print Preview</a>
                        <button type="button" onclick="generateGiftVoucher();" class="btn btn-custom waves-effect waves-light">Generate Voucher</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Voucher Model-->
        
       

        <!--Add Appointment Model-->
        <div id="add-appointment-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="Appointment" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Add Customer Appointment:</h4>
                    </div>
                    <form id="addappointment">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="appointment-customer-id" class="control-label">Reference#</label>
                                        <input type="text" readonly="readonly" class="form-control" id="appointment-customer-id" name="appointment-customer-id" placeholder="Reference #">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="appointment-customer-name" class="control-label">Name</label>
                                        <input type="text" class="form-control" readonly="readonly" id="appointment-customer-name" name="appointment-customer-name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="appointment-date" class="control-label">Pick Date</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="yyyy/mm/dd" id="appointment-date" name="appointment-date">
                                                <span class="input-group-addon bg-pink b-0 text-white"><i class="ti-calendar"></i></span>
                                            </div><!-- input-group -->
                                        </div>
                                        <div class="col-md-6 ">
                                            <label for="appointment-time" class="control-label">Pick Time</label>
                                            <div class="input-group" >
                                                <div class="bootstrap-timepicker" >
                                                    <input id="appointment-time" name="appointment-time" type="text" class="form-control" style="position:relative; z-index: 99999999 !important;">
                                                </div>
                                                <span class="input-group-addon bg-pink b-0 text-white"><i class="glyphicon glyphicon-time"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 ">
                                            <label for="appointment-remarks" class="control-label">Remarks</label>
                                            <input id="appointment-remarks" name="appointment-remarks" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                            <button type="button" onclick="addappointment();" class="btn btn-pink waves-effect waves-light">Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!--End Add Appointment Model-->
        <!--Existing Appointment Model-->
        <div id="existingappointment" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="existingappointmentLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Customer has existing open appointments</h4>
                    </div>
                    <div class="modal-body">

                        <div class="inbox-widget nicescroll" id="custexistapp" style="height: 315px; overflow: hidden; outline: none;" tabindex="5000">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="closelistopenapp();" type="button" class="btn btn-custom waves-effect waves-light">Add Another</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Existing Appointment Model-->
        <!--Absent Staff Model-->
        <div id="absentstaffmodal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="absentstaffmodal" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Click on Staff to enter Time-In</h4>
                    </div>
                    <div class="modal-body">

                        <div class="inbox-widget nicescroll" id="absentstaff" style="height: 315px; overflow: hidden; outline: none;" tabindex="5000">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Absent Staff Model-->
        <script>

            $(function() {
                $("#searchpanel input").keypress(function(e) {
                    if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
                        var mvar = "#btn" + $(this).attr('id');

                        $(mvar).trigger('click');

                        return false;
                    } else {
                        return true;
                    }
                });
            });

            $(document).ready(function() {
                $(".history-customer").css("display","none");
                fillBday();
                //getAppointments();
                getstaff();
                //getservices();
                getcategories()
                getOpenVisits();

                $(".numeric").keypress(function(e) {
                    //if the letter is not digit then display error and don't type anything
                    if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                        return false;
                    }
                });

                //Bootstrap-TouchSpin
                $(".vertical-spin").TouchSpin({
                    verticalbuttons: true,
                    buttondown_class: "btn btn-primary",
                    buttonup_class: "btn btn-primary",
                    verticalupclass: 'ti-plus',
                    verticaldownclass: 'ti-minus'
                });
                var vspinTrue = $(".vertical-spin").TouchSpin({
                    verticalbuttons: true
                });
                if (vspinTrue) {
                    $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
                }


                jQuery('#detail-customer-wedding').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy/mm/dd'
                });

                jQuery('#appointment-date').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy/mm/dd'

                });

                jQuery('#appointment-time').timepicker({
                    showMeridian: true,
                    minuteStep: 15
                });

                //products select2 start
                $("#visit-prod").select2({
                    //maximumSelectionLength: 2
                });
                $("#order-products").select2({
                    //maximumSelectionLength: 2
                });

//                $("#visit-staff").select2({
//                    //maximumSelectionLength: 2
//                });
                $("#order-staff").select2({
                    //maximumSelectionLength: 2
                });

                $('#detail-customer-email').on('blur', function() {
                    $('#detail-customer-email').parsley().validate();
                });
                $('#txt-customer-email').on('blur', function() {
                    $('#txt-customer-email').parsley().validate();
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

                $('.dropify').dropify({
                    messages: {
                        'default': 'Drag and drop a file here or click',
                        'replace': 'Drag and drop or click to replace',
                        'remove': 'Remove',
                        'error': 'Ooops, something wrong appended.'
                    },
                    error: {
                        'fileSize': 'The file size is too big (1M max).'
                    }
                });

                ///Customer Search Script....
                $("#btncustomer-search").on('click', function() {

                    var mid = $("#customer-search").val();
                    $.ajax({
                        type: 'POST',
                        url: 'customer_controller/search',
                        data: {customersearch: mid},
                        dataType: "json",
                        cache: false,
                        async: true,
                        success: function(data) {
                            fillcustomerform(data);
                        }
                    });

                });

                $("#btnname-search").on('click', function() {
                    var mid = $("#name-search").val();
                    $.ajax({
                        type: 'POST',
                        url: 'customer_controller/searchname',
                        data: {customername: mid},
                        dataType: "json",
                        cache: false,
                        async: true,
                        success: function(data) {
                            fillcustomerform(data);
                            //$(".history-customer").css("display","block");
                        }
                    });

                });

                $("#btncell-search").on('click', function() {
                    var mid = $("#cell-search").val();
                    $.ajax({
                        type: 'POST',
                        url: 'customer_controller/searchcell',
                        data: {customercell: mid},
                        dataType: "json",
                        cache: false,
                        async: true,
                        success: function(data) {
                            fillcustomerform(data);
                        }
                    });

                });
                $("#btnemail-search").on('click', function() {
                    var mid = $("#email-search").val();
                    $.ajax({
                        type: 'POST',
                        url: 'customer_controller/searchemail',
                        data: {customeremail: mid},
                        dataType: "json",
                        cache: false,
                        async: true,
                        success: function(data) {
                            fillcustomerform(data);
                        }
                    });

                });



            });

            function fillcustomerform(data) {
                clearcustomerform();

                var mhtml = '';
                if (data.length > 1) {
                    for (x = 0; x < data.length; x++) {
                        mhtml += '<a href="javascript:void(0)" onclick="getbyid(' + data[x]['id_customers'] + ');">';
                        mhtml += '<div class="inbox-item">';
                        mhtml += '<div class="inbox-item-img"><img src="<?php echo base_url(); ?>assets/images/users/' + data[x]['customer_image'] + '" class="img-circle" alt=""></div>';
                        mhtml += '<p class="inbox-item-author">' + data[x]['customer_name'] + '</p>';
                        mhtml += '<p class="inbox-item-text">' + data[x]['customer_cell'] + '</p>';
                        mhtml += '<p class="inbox-item-date">' + data[x]['customer_email'] + '</p>';
                        mhtml += '</div>';
                        mhtml += '</a>';
                    }
                    $("#customer_list").html(mhtml);
                    $("#multiplesearch").slideDown();
                } else if (data.length === 1) {
                    $("#txt-customer-id").val(data[0]['id_customers']);
                    $("#txt-customer-name").val(data[0]['customer_name']);
                    $("#txt-customer-cell").val(data[0]['customer_cell']);
                    $("#txt-customer-email").val(data[0]['customer_email']);
                    $("#txt-customer-address").val(data[0]['customer_address']);
                    $("#txt-customer-bday").val(data[0]['customer_birthday']);
                    //$('#txt-customer-bmonth option[value="' + data[0]['customer_birthmonth'] + '"]').attr("selected", "selected");
                    $('#txt-customer-bmonth').val(data[0]['customer_birthmonth']);
                    $("#img-customer").attr('src', '<?php echo base_url(); ?>assets/images/users/' + data[0]['customer_image']);
                    $("#btnupdate").html("Update");
                    $("#img-customer-file").val(data[0]['customer_image']);
                    $("#imguploader").hide();
                    $("#imgdisplay").show();
                    fillupdateform(data);
                } else {
                    clearcustomerform();
                }
            }

            function checkopenvisit(cid) {
                $.ajax({
                    type: 'POST',
                    url: 'visits_controller/getVisitbyCid',
                    data: {customer_id: cid},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {

                        if (data.length > 0) {
                            clearvisit();
                            fillvisit(data[0]['id_customer_visits']);
                        }
                    }
                });
            }

            function fillupdateform(data) {
//                if($("#customer_alert")){
//                    swal({
//                        title: "Customer Alert",
//                        text: "Please be advissed. This customer is allergic to<br/>"+ data[0]['customer_allergies'],
//                        type: "info",
//                        confirmButtonText: 'OK!'
//                    });
//                }
                if (data[0]['customer_allergies'] != "" || data[0]['customer_alert'] != "") {
                    $("#alert_text").html('<strong>Customer Alert! Allergic to :</strong> ' + data[0]['customer_allergies'] + ' | <strong>Other Alerts : </strong>' + data[0]['customer_alert']);
                    $("#customer_alert").show();
                }
                var d2 = "";
                var d1 = "";
                if (data[0]['customer_anniversary'] !== "" && data[0]['customer_anniversary'] !== null) {
                    var d2 = new Date(Date.parse(data[0]['customer_anniversary']));
                    m = d2.getMonth() + 1;
                    d1 = d2.getFullYear() + "/" + m + "/" + d2.getDate();
                }

                $("#detail-customer-id").val(data[0]['id_customers']);
                $("#detail-customer-name").val(data[0]['customer_name']);
                $("#detail-customer-cell").val(data[0]['customer_cell']);
                $("#detail-customer-email").val(data[0]['customer_email']);
                $("#detail-customer-address").val(data[0]['customer_address']);
                $("#detail-customer-bday").val(data[0]['customer_birthday']);
                $('#detail-customer-bmonth').val(data[0]['customer_birthmonth']);
                if (d1 !== "") {
                    $('#detail-customer-wedding').val(d1);
                }
                $('#detail-customer-phone1').val(data[0]['customer_phone1']);
                $('#detail-customer-phone2').val(data[0]['customer_phone2']);
                $('#detail-customer-allergies').val(data[0]['customer_allergies']);
                $('#detail-customer-alert').val(data[0]['customer_alert']);
            }

            //function getAppointments() {
            
                

//                $.ajax({
//                    type: 'POST',
//                    url: 'appointment_controller/appointments',
//                    data: '',
//                    dataType: "json",
//                    cache: false,
//                    async: true,
//                    success: function(data) {
//
//                        var mhtml = '';
//                        if (data.length === 0) {
//                            mhtml = '<li class="list-group-item"> <a href="#" class="user-list-item"><div class="icon bg-warning"><i class="zmdi zmdi-account"></i></div><div class="user-desc"><span class="name">No Appointments</span><span class="desc">for the day</span><span class="time">0:00</span></div></a></li>';
//                        } else {
//                            for (x = 0; x < data.length; x++) {
//
//                                mhtml += '<li class="list-group-item"><a href="javascript:void(0)" onclick="getbyid(' + data[x]['customer_id'] + ')" class="user-list-item">';
//                                mhtml += '<div class="icon bg-pink"><i class="zmdi zmdi-account"></i></div>';
//                                mhtml += '</div><div class="user-desc"><span class="name">' + data[x]['customer_name'] + '</span>';
//                                mhtml += '<span class="desc">' + data[x]['appointment_remarks'] + '</span>';
//                                mhtml += '<span class="time">' + data[x]['appointment_date_time'] + '</span></div></a></li>';
//
//                            }
//                        }
//                        $("#mAppointments").html(mhtml);
//                    }
//                });
            //}

            function closelistopenapp() {
                $("#existingappointment").modal('hide');
                $("#appointment-customer-id").val($("#txt-customer-id").val());
                $("#appointment-customer-name").val($("#txt-customer-name").val());
                $("#add-appointment-modal").modal("show");

            }

            function openAppointment() {
                if ($("#txt-customer-id").val() !== "") {
                    $.ajax({
                        type: 'POST',
                        url: 'appointment_controller/appointmentsbyid',
                        data: {id: $("#txt-customer-id").val()},
                        dataType: "json",
                        cache: false,
                        async: true,
                        success: function(data) {

                            var mhtml = '';
                            if (data.length === 0) {
                                $("#appointment-customer-id").val($("#txt-customer-id").val());
                                $("#appointment-customer-name").val($("#txt-customer-name").val());
                                $("#add-appointment-modal").modal("show");
                            } else {
                                
                                console.log('count: '+data.length);

                                for (x = 0; x < data.length; x++) {

                                    var mdate = new Date(data[x]['appointment_date_time']);
                                    var apptime = mdate.getHours() + ":" + mdate.getMinutes();
                                    var appmonth = mdate.getMonth() + 1;
                                    var appdate = mdate.getDate() + "/" + appmonth + "/" + mdate.getFullYear();
                                    //mhtml += ' <a href="javascript:void(0)" onclick="getbyid(' + data[x]['customer_id'] + ')" >';
                                    mhtml += '<div class="inbox-item">';
                                    mhtml += ' <div class="inbox-item-img"><img src="<?php echo base_url(); ?>assets/images/users/' + data[x]['customer_image'] + '" class="img-circle" alt="' + data[x]['customer_name'] + '"></div>';
                                    mhtml += ' <p class="inbox-item-author">' + data[x]['customer_name'] + '</p>';
                                    mhtml += '<p class="inbox-item-text">' + data[x]['appointment_remarks'] + '...</p>';
                                    mhtml += '<p class="inbox-item-date"><a href="javascript:void(0);"  onclick="updateappointment(' + data[x]['id_appointments'] + ',\'close\');" class="badge badge-pink white ">Convert Visit</a> <a href="javascript:void(0);" onclick="updateappointment(' + data[x]['id_appointments'] + ',\'cancel\');" class="badge badge-danger white ">Cancel</a></p>';
                                    mhtml += '<p class="inbox-item-author"><span>Date: </span>' + data[x]['appdate'] + '</p>';
                                    mhtml += '<p class="inbox-item-author"><span>Time: </span>' + data[x]['apptime'] + '</p>';
                                    mhtml += '</div>';
                                    //mhtml += '</a>';

                                }

                                $("#custexistapp").html(mhtml);
                                $("#existingappointment").modal('show');
                            }

                        }
                    });
                }
            }

            function updateappointment(aid, astatus) {

                $.ajax({
                    type: 'POST',
                    url: 'appointment_controller/updateappstatus',
                    data: {id: aid, status: astatus},
                    success: function(data) {
                        $("#existingappointment").modal('hide');
                        getAppointments();
                        toastr.success(data, 'Appointment Updated');
                    }
                });
            }

            function  addappointment() {
                $.ajax({
                    type: 'POST',
                    url: 'appointment_controller/addappointment',
                    data: $("#addappointment").serialize(),
                    success: function(data) {

                        var result = data.split("|");
                        if (result[0] === "success") {
                            $("#add-appointment-modal").modal("hide");
                            getAppointments();
                            // Display a success toast, with a title
                            toastr.success('New Appointment Added!', 'Cool!');
                        } else {

                            swal({
                                title: "Error",
                                text: result[1],
                                type: "error",
                                confirmButtonText: 'OK!'
                            });
                        }
                    }
                });

            }

            function getOpenVisits() {

                $.ajax({
                    type: 'POST',
                    url: 'visits_controller/get_visits',
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        var mhtml = "";
                        for (x = 0; x < data.length; x++) {

                            var mdate = new Date(data[x]['customer_visit_date']);
                            var visittime = mdate.getHours() + ":" + mdate.getMinutes();
                            var visitmonth = mdate.getMonth() + 1;
                            var visitdate = mdate.getDate() + "/" + visitmonth + "/" + mdate.getFullYear();
                            mhtml += ' <a href="javascript:void(0)" onclick="openVisit(' + data[x]['id_customer_visits'] + ',' + data[x]['id_customers'] + ')" >';
                            mhtml += '<div class="inbox-item">';
                            mhtml += ' <div class="inbox-item-img"><img src="<?php echo base_url(); ?>assets/images/users/' + data[x]['customer_image'] + '" class="img-circle" alt="' + data[x]['customer_name'] + '"></div>';
                            mhtml += ' <p class="inbox-item-author">' + data[x]['customer_name'] + '</p>';
//                            mhtml += '<p class="inbox-item-author"><span>Date: </span>' + data[x]['visitdate'] + '</p>';
                            mhtml += '<p class="inbox-item-author"><span>Time: </span>' + visittime + '</p>';
                            mhtml += '</div>';
                            mhtml += '</a>';

                        }

                        $("#beingserviced").html(mhtml);

                    }
                });
            }

            function getbyid(customerid) {
                $.ajax({
                    type: 'POST',
                    url: 'customer_controller/searchid',
                    data: {id: customerid},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        fillcustomerform(data);
                        $("#multiplesearch").slideUp();
                        $(".history-customer").css("display","block");
                    }
                });
            }

            function hidemultisearch() {
                $("#multiplesearch").slideUp();
            }

            function fillBday() {
                for (x = 1; x <= 31; x++) {
                    $("#txt-customer-bday").append('<option value=' + x + '>' + x + '</option>');
                    $("#detail-customer-bday").append('<option value=' + x + '>' + x + '</option>');

                }
            }

            function changepic() {

                if ($("#txt-customer-id").val() === "" && $("#txt-customer-name").val() === "") {
                    // swal("Ooops! Let's Add Customer Name First.", "You forgot to enter the NAME, CELL PHONE and EMAIL address of the new customer. Let's start with putting in this mandatory information first.")
                    swal({
                        title: "Ooops! Let's Add Customer Name First.",
                        text: "You forgot to enter the NAME, CELLPHONE and EMAIL address of the new customer. Let's start with putting in this mandatory information first.",
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                } else {
                    $("#imguploader").show();
                    $("#imgdisplay").hide();
                }
            }


            function addeditcustomer() {

                if ($("#btnupdate").text() === "Add New") {
                    if ($("#txt-customer-name").val() === "" || $("#txt-customer-cell").val() === "") {
                        swal({
                            title: "Add Name  and Cell Phone",
                            text: "You forgot to enter the NAME, CELL PHONE  of the new customer. Let's start with putting in this mandatory information first.",
                            type: "warning",
                            confirmButtonText: 'OK!'
                        });
                    } else {
                        addnewcustomer();
                    }
                } else if ($("#btnupdate").text() === "Update") {
                    showcustomerdetails();

                }
            }

            function addnewcustomer() {
                $.ajax({
                    type: 'POST',
                    url: 'customer_controller/addnew',
                    data: $("#customerform").serialize(),
                    success: function(data) {
                        var result = data.split("|");
                        if (result[0] === "success") {
                            getbyid(result[1]);
                            // Display a success toast, with a title
                            toastr.success('New Customer Created!', 'Cool!');
                        } else {

                            swal({
                                title: "Error",
                                text: result[1],
                                type: "error",
                                confirmButtonText: 'OK!'
                            });
                        }
                    }
                });
            }

            function updatecustomer() {

                $.ajax({
                    type: 'POST',
                    url: 'customer_controller/updatecustomer',
                    data: $("#updateform").serialize(),
                    success: function(data) {
                        var result = data.split("|");
                        if (result[0] === "success") {
                            getbyid(result[1]);
                            $("#con-close-modal").modal("hide");
                            toastr.success('Customer updated with more info!', 'Great!');
                        } else {
                            swal({
                                title: "Error",
                                text: result[1],
                                type: "error",
                                confirmButtonText: 'OK!'
                            });
                        }

                    }
                });
            }

            function showcustomerdetails() {
                $("#con-close-modal").modal("show");
            }


            function openmain() {
                clearorder();
                clearvisit();
                clearappointment();
                if ($('#divvisit').is(':visible')) {
                    $("#divvisit").slideUp();
                }
                if ($('#divorder').is(':visible')) {
                    $("#divorder").slideUp();
                }

                $("#divmain").slideDown();

            }
            function getstaff() {
                $('#visit-staff').children().remove();
                $("#visit-staff").select2("val", "");

                $('#order-staff').children().remove();
                $("#order-staff").select2("val", "");


                $.ajax({
                    type: 'POST',
                    url: 'staff_controller/presentstaff',
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            //if(data[x]['staff_available']==''){
                            $('#visit-staff').append('<option value=' + data[x]['id_staff'] + '>' + data[x]['staff_fullname'] + '</option>');
                            //}
                            $('#order-staff').append('<option value=' + data[x]['id_staff'] + '>' + data[x]['staff_fullname'] + '</option>');

                            //fill 
                            if (data[x]['staff_available'] != '') {
                                mhtml += '<a href="javascript:void(0);" onclick="staff_client(' + data[x]['staff_available'] + ')">';
                            }
                            mhtml += '<div class="inbox-item">';
                            if (data[x]['staff_image'] != "") {
                                mhtml += '<div class="inbox-item-img"><img src="<?php echo base_url(); ?>assets/images/staff/' + data[x]['staff_image'] + '" class="img-circle" alt="' + data[x]['staff_fullname'] + '"></div>';
                            }
                            if (data[x]['staff_available'] != '') {
                                mhtml += '<p class="inbox-item-author">' + data[x]['staff_fullname'] + ' <span class="text-danger">Busy</span></p>';
                            } else {
                                mhtml += '<p class="inbox-item-author">' + data[x]['staff_fullname'] + '</p>';
                            }
                            mhtml += '<p class="inbox-item-text">' + data[x]['staff_cell'] + '</p>';
                            mhtml += '<p class="inbox-item-date">' + data[x]['timein'] + '</p>';
                            mhtml += '</div>';
                            if (data[x]['staff_available'] != '') {
                                mhtml += '</a>';
                            }
                        }
                        $("#presentstaff").html(mhtml);
                    }
                });

            }


            function getabsentstaff() {
                $.ajax({
                    type: 'POST',
                    url: 'staff_controller/absentstaff',
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        if (data.length > 0) {
                            mhtml = "";
                            for (x = 0; x < data.length; x++) {
                                //mhtml+='<a href="'+data[x]['id_staff']+'">';
                                mhtml += '<div class="inbox-item">';
                                if (data[x]['staff_image'] != "") {
                                    mhtml += '<div class="inbox-item-img"><img src="<?php echo base_url(); ?>assets/images/staff/' + data[x]['staff_image'] + '" class="img-circle" alt="' + data[x]['staff_fullname'] + '"></div>';
                                }
                                mhtml += '<p class="inbox-item-author">' + data[x]['staff_fullname'] + '</p>';
                                mhtml += '<p class="inbox-item-text">' + data[x]['staff_cell'] + '</p>';
                                mhtml += '<p class="inbox-item-date"><span style="cursor:pointer;" onclick="timein(' + data[x]['id_staff'] + ');" class="label label-warning">Time In</span></p>';
                                mhtml += '</div>';
                                //mhtml+='</a>';
                            }
                            $("#absentstaff").html(mhtml);
                            $("#absentstaffmodal").modal('show');
                        } else {
                            swal({
                                title: "Sweet!",
                                text: "Every one is already in.",
                                imageUrl: "<?php echo base_url(); ?>assets/plugins/bootstrap-sweetalert/thumbs-up.jpg"
                            });
                        }
                    }
                });

            }

            function getpresentstaff() {
                $.ajax({
                    type: 'POST',
                    url: 'staff_controller/presentstaff',
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        if (data.length > 0) {
                            mhtml = "";
                            for (x = 0; x < data.length; x++) {
                                //mhtml+='<a href="'+data[x]['id_staff']+'">';
                                mhtml += '<div class="inbox-item">';
                                if (data[x]['staff_image'] != "") {
                                    mhtml += '<div class="inbox-item-img"><img src="<?php echo base_url(); ?>assets/images/staff/' + data[x]['staff_image'] + '" class="img-circle" alt="' + data[x]['staff_fullname'] + '"></div>';
                                }
                                mhtml += '<p class="inbox-item-author">' + data[x]['staff_fullname'] + '</p>';
                                mhtml += '<p class="inbox-item-text">' + data[x]['staff_cell'] + '</p>';
                                mhtml += '<p class="inbox-item-date"><span style="cursor:pointer;" onclick="timeout(' + data[x]['id_staff'] + ');" class="label label-danger">Time Out</span></p>';
                                mhtml += '</div>';
                                //mhtml+='</a>';
                            }
                            $("#absentstaff").html(mhtml);
                            $("#absentstaffmodal").modal('show');
                        } else {
                            swal({
                                title: "Sweet!",
                                text: "Every one is already in.",
                                imageUrl: "<?php echo base_url(); ?>assets/plugins/bootstrap-sweetalert/thumbs-up.jpg"
                            });
                        }
                    }
                });
            }

            function timein(pid) {
                $.ajax({
                    type: 'POST',
                    url: 'staff_controller/timein',
                    data: {id: pid},
                    success: function(data) {
                        var result = data.split("|");
                        if (result[0] === "success") {
                            getstaff();
                            $("#absentstaffmodal").modal("hide");
                            toastr.success('Staff member is now present!', 'Great!');

                        } else {
                            swal({
                                title: "Error",
                                text: result[1],
                                type: "error",
                                confirmButtonText: 'OK!'
                            });
                        }

                    }
                });
            }
            function timeout(pid) {
                $.ajax({
                    type: 'POST',
                    url: 'staff_controller/timeout',
                    data: {id: pid},
                    success: function(data) {
                        var result = data.split("|");
                        if (result[0] === "success") {
                            getstaff();
                            $("#absentstaffmodal").modal("hide");
                            toastr.success('Time out updated for Staff!', 'Done!');

                        } else {
                            swal({
                                title: "Error",
                                text: result[1],
                                type: "error",
                                confirmButtonText: 'OK!'
                            });
                        }

                    }
                });
            }
            
            function getcategories() {
                $('#visit-services-categories').html('');
                $.ajax({
                    type: 'POST',
                    url: 'service_controller/getServicesCategories',
                    success: function(response) {
                        
                        $(".nicescroll_2").niceScroll({ cursoropacitymin: 1 });

                        var data = $.parseJSON(response);

                        var chtml = "";

                        chtml += '<ul>';

                        for (x = 0; x < data.length; x++) {

                            var id = data[x]['id_service_category'];
                            var name = data[x]['service_category'];
                            var image = '<img src="<?php echo base_url()."assets/images/category/"; ?>'+data[x]['service_category_image']+'">';
                            var category_name = "'"+name.replace(/(['"])/g, "\\$1")+"'";

                            chtml += '<li data-service_category_id="'+id+'" onclick="get_category_services('+id+');">'+image+' '+name+'</li>';

                        }

                        chtml += '</ul>';

                        $("#visit-services-categories").append(chtml);

                    }
                });
            }

            function get_category_services(id_service_category){
        
                $('#visit-services-categories ul [data-service_category_id]').css('background-color', '#fff');

                $('#visit-services-categories ul [data-service_category_id="'+id_service_category+'"]').css('background-color', '#f2f2f2');

                $("#visit-services > ul").hide();

                if($('#visit-services').find('#'+id_service_category).length > 0){

                    $('#visit-services').find('#'+id_service_category).show();

                } else{

                    $('#visit-services > #fa-spinner').show();

                    $.ajax({

                        type: "POST",
                        url: "Service_controller/getServicesByCategory",
                        data: "id_service_category=" + id_service_category,

                        success: function(response){

                            var data = $.parseJSON(response);

                            if(data.length > 0){

                                $(".nicescroll_3").niceScroll({ cursoropacitymin: 1 });

                                var chtml = "";

                                chtml += '<ul id="'+id_service_category+'">';

                                for (x = 0; x < data.length; x++) {

                                    var id = data[x]['id_business_services'];
                                    var name = data[x]['service_name'];
                                    var rate = data[x]['service_rate'];

                                    var checkbox = '<div class="radio radio-pink radio-circle"><input type="radio" onclick="get_service_products('+id+');" service_name="'+name+'" service_duration="'+data[x]['service_duration']+'" value="'+id+'" name="id_business_services" id="'+id+'_business_services">';

                                    var label = '<label style="font-weight: normal;" for="'+id+'_business_services">'+name+'<br><span style="font-size:12px;">(Rate: '+rate+')</span></label></div>';

                                    chtml += '<li data-id_business_services="'+id+'">'+checkbox+' '+label+'</li>';

                                }

                                chtml += '</ul>';

                                $('#visit-services > #fa-spinner').hide();

                                $("#visit-services").append(chtml);

                            } else{

                                $('#visit-services > #fa-spinner').hide();

                                $("#visit-services").append('<ul id="'+id_service_category+'"><li><span style="color: red">No Services</span></li></li>');

                            }

                        }

                    });

                }

            }
            
            function get_service_products(service_id){
                
                $('input[name=id_business_products]').prop('checked', false);
    
                $("#visit-products > ul").hide();

                if($('#visit-products').find('#'+service_id).length > 0){

                    $('#visit-products').find('#'+service_id).show();

                } else{

                    $('#visit-products > #fa-spinner').show();

                    $.ajax({

                        type: "POST",
                        url: "Product_controller/getProductsByService",
                        data: "service_id=" + service_id,

                        success: function(response){

                            var data = $.parseJSON(response);

                            if(data.length > 0){

                                $(".nicescroll_products").niceScroll({ cursoropacitymin: 1 });

                                var chtml = "";

                                chtml += '<ul id="'+service_id+'">';

                                for (x = 0; x < data.length; x++) {

                                    var id = data[x]['id_business_products'];
                                    var name = data[x]['product'];

                                    var checkbox = '<div class="checkbox checkbox-pink checkbox-circle"><input type="checkbox" product_service_id="'+service_id+'" product_name="'+name+'" value="'+id+'" name="id_business_products" id="'+id+'_business_products">';

                                    var label = '<label style="font-weight: normal;" for="'+id+'_business_products">'+name+'</label></div>';

                                    chtml += '<li data-id_business_products="'+id+'">'+checkbox+' '+label+'</li>';

                                }

                                chtml += '</ul>';

                                $('#visit-products > #fa-spinner').hide();

                                $("#visit-products").append(chtml);

                            } else{

                                $('#visit-products > #fa-spinner').hide();

                                $("#visit-products").append('<ul id="'+service_id+'"><li><span style="color: red">No Products</span></li></li>');

                            }

                        }

                    });

                }

            }

            function openVisit(visitid, cid) {
            
                $("#visit-services > ul").remove();
                $("#visit-products > ul").remove();

                getstaff();
                //getinhouseproducts();
                if (visitid !== 0) {
                    fillvisit(visitid);
                    getbyid(cid);
                    $("#divmain").slideUp();
                    $("#divvisit").slideDown();
                } else if ($("#txt-customer-id").val() !== "") {
                    //console.log('cid: '+$("#txt-customer-id").val());
                    $("#visit-customer-id").val($("#txt-customer-id").val());
                    $("#visit-customer-name").val($("#txt-customer-name").val());
                    $("#visitcustomername").html($("#txt-customer-name").val());
                    $("#visit-customer-cell").val($("#txt-customer-cell").val());
                    $("#visit-customer-email").val($("#txt-customer-email").val());
                    checkopenvisit($("#txt-customer-id").val());
                    $("#divmain").slideUp();
                    $("#divvisit").slideDown();
                }
                getlast4visits();
                // console.log($("#txt-customer-id").val());
//               if($("#customer_alert").is(':visible')){
//                    swal({
//                        title: "Customer Alert",
//                        text: 'Please Read Text In Red!',
//                        type: "warning",
//                        confirmButtonText: 'OK!'
//                    });
//                }
            }

            function fillvisit(visitid, qtype) {
                //console.log('vid: '+visitid);
                var myurl;
                if (qtype === 1) {
                    myurl = 'visits_controller/getVisitbyid/1';
                } else {
                    myurl = 'visits_controller/getVisitbyid';
                }

                $.ajax({
                    type: 'POST',
                    url: myurl,
                    data: {id_customer_visit: visitid},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        
                        //console.log(data);
                        
                        if (qtype === 1) {
                            $("#visit-id").val('');
                        } else {
                            $("#visit-id").val(data['visits'][0]['id_customer_visits']);
                        }
                        $("#visit-customer-id").val(data['visits'][0]['customer_id']);
                        $("#visit-customer-name").val(data['visits'][0]['customer_name']);
                        $("#visitcustomername").html(data['visits'][0]['customer_name']);
                        $("#visit-customer-cell").val(data['visits'][0]['customer_cell']);
                        $("#visit-customer-email").val(data['visits'][0]['customer_email']);
                        $("#visit-date").val(data['visits'][0]['visitdate']);
                        var mhtml = "";
                        for (var x = 0; x < data['services'].length; x++) {
                            mhtml += '<tr>';
                            mhtml += '<td style="display:none;">' + data['visits'][x]['customer_id'] + '</td>';
                            mhtml += "<td class='id'>" + data['services'][x]['service_id'] + "</td>";
                            mhtml += "<td>" + data['services'][x]['service_name'] + "</td>";
                            mhtml += "<td style='display:none;'>" + data['services'][x]['staff_id'] + '</td>';
                            mhtml += "<td>" + data['services'][x]['staff_name'] + '</td>';
                            
                            var product_ids = "";
                            $(data['visits']).each(function (index, value) {
                                if(data['services'][x]['id_visit_services'] === value['visit_service_id']){
                                    product_ids += value['product_id'] + ' | ';
                                }
                            });
                            
                            mhtml += '<td style="display:none;">'+product_ids+'</td>';
                            
                            var product_names = "";
                            $(data['visits']).each(function (index, value) {
                                if(data['services'][x]['id_visit_services'] === value['visit_service_id']){
                                    if(value['product_name'] !== null){
                                        product_names += value['product_name'] + ' | ';
                                    }
                                }
                            });
                            
                            mhtml += '<td>'+product_names+'</td>';
                            
                            mhtml += '<td><span class="label label-danger" onclick="removeservice(' + data['services'][x]['service_id'] + ')" style="cursor:pointer">x</span></td>';
                            mhtml += "</tr>";
                        }
                        $("#visit-service-list tbody").append(mhtml);
                        $("#btngeninvoice").show();
                    }
                });
            }


            function addServiceRows() {

                var mhtml = "";
                var exists = 0;
                
                if($('input[name=id_business_services]:checked').val() == undefined){
                    swal({
                        title: "Service is not selected!",
                        text: 'Please select a service as its mandatory field.',
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                    return false;
                }
                
                if($('#visit-staff').children('option:selected').val() == undefined){
                    swal({
                        title: "Staff is not selected!",
                        text: 'Please select a staff as its mandatory field.',
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                    return false;
                }
                
                if ($('input[name=id_business_services]:checked').val() != undefined) {

                    $('#visit-service-list').find("td.id").each(function(index) {
                        if ($(this).html() === $("input[name=id_business_services]:checked").val()) {
                            exists = 1;
                        }
                    });

                    mhtml += '<tr>';
                    mhtml += '<td style="display:none;">' + $("#visit-customer-id").val() + '</td>';
                    mhtml += "<td class='id'>" + $("input[name=id_business_services]:checked").val() + "</td>";
                    mhtml += "<td>" + $("input[name=id_business_services]:checked").attr('service_name') + "</td>";
                    mhtml += "<td style='display:none;'>";
                    $('#visit-staff').children('option:selected').each(function() {
                        mhtml += " " + $(this).val();
                    });
                    mhtml += "</td>";
                    mhtml += "<td>";
                    $('#visit-staff').children('option:selected').each(function() {
                        mhtml += " " + $(this).text();
                    });
                    mhtml += "</td>";

                    mhtml += "<td style='display:none;'>";
                    $('input[name=id_business_products]:checked').each(function() {
                        mhtml += " " + $(this).val() + " |";
                    });
                    mhtml += '</td>';
                    mhtml += '<td>';
                    $('input[name=id_business_products]:checked').each(function() {
                        mhtml += " " + $(this).attr('product_name') + " |";
                    });
                    mhtml += '</td>';

                    mhtml += '<td><span class="label label-danger" onclick="removeservice(' + $("input[name=id_business_services]:checked").val() + ')" style="cursor:pointer">x</span></td>';
                    mhtml += "</tr>";
                }
                if (exists == 0) {
                    $("#visit-service-list tbody").append(mhtml);
                } else {
                    $('input[product_service_id='+$('input[name=id_business_services]:checked').val()+']').prop('checked', false);
                    swal({
                        title: "Service already added!",
                        text: 'If you want to change this service, please remove and add again.',
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                    
                }
            }


            function getinhouseproducts() {
                $('#visit-prod').children().remove();
                $("#visit-prod").select2("val", "");

                $.ajax({
                    type: 'POST',
                    url: 'product_controller/getinhouseproducts',
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        chtml = "";
                        current_cat = "";
                        last_cat = "";
                        for (x = 0; x < data.length; x++) {
                            current_cat = data[x]['id_business_brands'];
                            if (current_cat !== last_cat) {
                                if (x === 0) {
                                    chtml += '<optgroup label="' + data[x]['business_brand_name'] + '">';
                                    chtml += '<option value=' + data[x]['id_business_products'] + '>' + data[x]['product'] + '</option>';
                                } else {
                                    chtml += '</optgroup>';
                                    chtml += '<optgroup label="' + data[x]['business_brand_name'] + '">';
                                    chtml += '<option value=' + data[x]['id_business_products'] + '>' + data[x]['product'] + '</option>';
                                }
                            } else {
                                chtml += '<option value=' + data[x]['id_business_products'] + '>' + data[x]['product'] + '</option>';
                            }
                            last_cat = data[x]['id_business_brands'];
                        }
                        chtml += '</optgroup>';
                        $("#visit-prod").append(chtml);
                    }
                });

            }

            function getproducts() {

                $('#order-products').children().remove();
                $("#order-products").select2("val", "");

                $.ajax({
                    type: 'POST',
                    url: 'product_controller/getproducts',
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        chtml = "";
                        current_cat = "";
                        last_cat = "";
                        for (x = 0; x < data.length; x++) {
                            current_cat = data[x]['id_business_brands'];
                            if (current_cat !== last_cat) {
                                if (x === 0) {
                                    chtml += '<optgroup label="' + data[x]['business_brand_name'] + '">';
                                    chtml += '<option value=' + data[x]['id_business_products'] + '>' + data[x]['product'] + '</option>';
                                } else {
                                    chtml += '</optgroup>';
                                    chtml += '<optgroup label="' + data[x]['business_brand_name'] + '">';
                                    chtml += '<option value=' + data[x]['id_business_products'] + '>' + data[x]['product'] + '</option>';
                                }
                            } else {
                                chtml += '<option value=' + data[x]['id_business_products'] + '>' + data[x]['product'] + '</option>';
                            }
                            last_cat = data[x]['id_business_brands'];
                        }
                        chtml += '</optgroup>';

                        $("#order-products").append(chtml);

                    }
                });
            }
            function removeservice(val) {
                $('#visit-service-list').find("td.id").each(function(index) {

                    if ($(this).html() == val) {
                        $(this).closest('tr').remove();
                    }
                });
            }


            function updatevisit() {
                var visit_date = $('#visit-date').val();
                if ($("#visit-id").val() === "") { //add new visit
                    var TableData;
                    TableData = storeVTblValues()
                    TableData = $.toJSON(TableData);
                    
                    //console.log(TableData); return false;

                    if (TableData.length > 2) {
                        $.ajax({
                            type: "POST",
                            url: "visits_controller/addvisits",
                            data: "visitdata=" + TableData + "&visit-date="+visit_date,
                            success: function(data) {
                                var result = data.split("|");
                                if (result[0] === "success") {
                                    //$("#visit-id").val(result[1]);
                                    clearvisit();
                                    openVisit(result[1]);
                                    toastr.success('Visit created!', 'Done!');
                                    getOpenVisits();
                                } else {
                                    swal({
                                        title: "Error",
                                        text: result[1],
                                        type: "error",
                                        confirmButtonText: 'OK!'
                                    });
                                }
                            }
                        });
                    } else {
                        swal({
                            title: "You have not added any Services",
                            text: 'Select service and staff member providing that service. Optionally you can also add products being used.',
                            type: "error",
                            confirmButtonText: 'OK!'
                        });
                    }
                } else { //update existing visit
                    var TableData;
                    TableData = storeVTblValues()
                    TableData = $.toJSON(TableData);
                    if (TableData.length > 2) {
                        $.ajax({
                            type: "POST",
                            url: "visits_controller/updatevisit",
                            data: "visitdata=" + TableData + "&visitid=" + $("#visit-id").val() + "&visit-date="+visit_date,
                            success: function(data) {
                                var result = data.split("|");
                                if (result[0] === "success") {
                                    //$("#visit-id").val(result[1]);
                                    clearvisit();
                                    openVisit(result[1]);
                                    toastr.success('Visit Updated!', 'Done!');
                                    getOpenVisits();
                                } else {
                                    swal({
                                        title: "Error",
                                        text: result[1],
                                        type: "error",
                                        confirmButtonText: 'OK!'
                                    });
                                }
                            }
                        });
                    } else {
                        swal({
                            title: "You have not added any Services",
                            text: 'Select service and staff member providing that service. Optionally you can also add products being used.',
                            type: "error",
                            confirmButtonText: 'OK!'
                        });
                    }
                }
            }

            function storeVTblValues()
            {
                var TableData = new Array();

                $('#visittbl tr').each(function(row, tr) {
                    TableData[row] = {
                        "customerid": $(tr).find('td:eq(0)').text()
                        , "serviceid": $(tr).find('td:eq(1)').text()
                        , "servicename": $(tr).find('td:eq(2)').text()
                        , "staffid": $(tr).find('td:eq(3)').text()
                        , "staff": $(tr).find('td:eq(4)').text()
                        , "productid": $(tr).find('td:eq(5)').text()
                        , "productname": $(tr).find('td:eq(6)').text()
                    }
                });
                TableData.shift();  // first row will be empty - so remove
                return TableData;
            }


            //Clear Forms
            function clearcustomerform() {
                mfield = $("#txt-customer-email").parsley();
                window.ParsleyUI.removeError(mfield, 'required');
                window.ParsleyUI.removeError(mfield, 'email');
                $("#txt-customer-email").removeClass('parsley-error');

                mfield = $("#detail-customer-email").parsley();
                window.ParsleyUI.removeError(mfield, 'required');
                window.ParsleyUI.removeError(mfield, 'email');
                $("#detail-customer-email").removeClass('parsley-error');

                $("#txt-customer-id").val('');
                $("#txt-customer-name").val('');
                $("#txt-customer-cell").val('');
                $("#txt-customer-email").val('');
                $("#txt-customer-address").val('');
                $('#txt-customer-bday option:eq(0)').prop('selected', true);
                $('#txt-customer-bmonth option:eq(0)').prop('selected', true);
                $("#img-customer").attr('src', '<?php echo base_url(); ?>assets/images/users/avatar-1.jpg');
                $("#btnupdate").html("Add New");
                $("#imguploader").hide();
                $("#imgdisplay").show();
                $("#customer_alert").hide();
            }

            function clearappointment() {
                $("#appointment-customer-id").val('');
                $("#appointment-customer-name").val('');
                $("#appointment-remarks").val('');
            }

            function clearvisit() {
                $("#visit-customer-id").val('');
                $("#visit-customer-name").val('');
                $("#visit-id").val('');
                $("#visit-customer-cell").val('');
                $("#visit-customer-email").val('');
                $("#visitcustomername").html('');

                $('#visit-services > option').eq(0).attr('selected', 'selected');
                $("#visit-service-list tbody").html("");
                $("#tbllastvisits tbody").html('');
                $("#btngeninvoice").hide();
            }

            function clearorder() {
                console.log('ordercleared');
                $("#order-customer-id").val('');
                $("#order-customer-name").val('');
                $("#order-id").val('');
                $("#order-customer-cell").val('');
                $("#order-customer-email").val('');

                $('#order-products > option').eq(0).attr('selected', 'selected');
                $("#order-product-list tbody").html("");
                $("#tbllastorders tbody").html('');
                $("#btngenorderinvoice").hide();
            }

            function getlast4visits() {
                if ($("#visit-customer-id").val() !== "") {
                    $("#tbllastvisits tbody").html('');
                    $.ajax({
                        type: 'POST',
                        url: 'visits_controller/getlast4visits/' + $("#visit-customer-id").val(),
                        dataType: "json",
                        cache: false,
                        async: true,
                        success: function(data) {

                            var mhtml = "";
                            for (x = 0; x < data.length; x++) {

                                mhtml += '<tr onclick="fillvisit(' + data[x]['id_customer_visits'] + ',1)">';
                                mhtml += '<td><span class="label label-pink">' + data[x]['id_customer_visits'] + '</span></td>';
                                mhtml += '<td>' + data[x]['visit_date'] + '</td>';
                                mhtml += '<td>' + data[x]['service_name'] + '</td>';
                                mhtml += '<td>' + data[x]['staff_names'] + '</td>';
                                mhtml += '<td>' + data[x]['product_names'] + '</td>';
                                mhtml += '</tr>';
                            }

                            $("#tbllastvisits tbody").append(mhtml);

                        }
                    });
                }
            }

            function openOrder(orderid, cid) {
                getstaff();
                getproducts();
                if (orderid !== 0) {
                    fillorder(orderid);
                    getbyid(cid);
                    $("#divmain").slideUp();
                    $("#divorder").slideDown();
                } else if ($("#txt-customer-id").val() != "") {

                    $("#order-customer-id").val($("#txt-customer-id").val());
                    $("#order-customer-name").val($("#txt-customer-name").val());
                    $("#order-customer-cell").val($("#txt-customer-cell").val());
                    $("#order-customer-email").val($("#txt-customer-email").val());
                    checkopenorder($("#txt-customer-id").val());
                    $("#divmain").slideUp();
                    $("#divorder").slideDown();
                }
                getlast4orders();
            }

            function fillorder(orderid, qtype) {
                var myurl
                if (qtype == 1) {
                    myurl = 'order_controller/getOrderbyid/1';
                } else {
                    myurl = 'order_controller/getOrderbyid';
                }

                $.ajax({
                    type: 'POST',
                    url: myurl,
                    data: {id_customer_order: orderid},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        if (qtype == 1) {
                            $("#order-id").val('');
                        } else {
                            $("#order-id").val(data[0]['id_customer_order']);
                        }
                        $("#order-customer-id").val(data[0]['customer_id']);
                        $("#order-customer-name").val(data[0]['customer_name']);
                        $("#order-customer-cell").val(data[0]['customer_cell']);
                        $("#order-customer-email").val(data[0]['customer_email']);
                        mhtml = "";
                        for (x = 0; x < data.length; x++) {
                            mhtml += '<tr>';
                            mhtml += '<td style="display:none;">' + data[x]['customer_id'] + '</td>';
                            mhtml += "<td class='id'>" + data[x]['product_id'] + "</td>";
                            mhtml += "<td>" + data[x]['product_name'] + "</td>";
                            mhtml += "<td style='display:none;'>" + data[x]['staff_id'] + '</td>';
                            mhtml += "<td>" + data[x]['staff_name'] + '</td>';
                            mhtml += "<td>" + data[x]['qty'] + '</td>';
                            mhtml += '<td><span class="label label-danger" onclick="removeproduct(' + data[x]['product_id'] + ')" style="cursor:pointer">x</span></td>';
                            mhtml += "</tr>";
                        }
                        $("#order-product-list tbody").append(mhtml);
                        $("#btngenorderinvoice").show();
                    }
                });
            }

            function checkopenorder(cid) {
                $.ajax({
                    type: 'POST',
                    url: 'order_controller/getOrderbyCid',
                    data: {customerid: cid},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {

                        if (data.length > 0) {
                            clearorder();
                            fillorder(data[0]['id_customer_order']);
                        }
                    }
                });
            }

            function getlast4orders() {
                if ($("#order-customer-id").val() !== "") {
                    $("#tbllastorders tbody").html('');
                    $.ajax({
                        type: 'POST',
                        url: 'order_controller/getlast4orders/' + $("#order-customer-id").val(),
                        dataType: "json",
                        cache: false,
                        async: true,
                        success: function(data) {

                            var mhtml = "";
                            for (x = 0; x < data.length; x++) {

                                mhtml += '<tr onclick="fillorder(' + data[x]['id_customer_order'] + ',1)">';
                                mhtml += '<td><span class="label label-pink">' + data[x]['id_customer_order'] + '</span></td>';
                                mhtml += '<td>' + data[x]['order_date'] + '</td>';
                                mhtml += '<td>' + data[x]['product_name'] + '</td>';
                                mhtml += '<td>' + data[x]['qty'] + '</td>';
                                mhtml += '<td>' + data[x]['staff_name'] + '</td>';

                                mhtml += '</tr>';
                            }

                            $("#tbllastorders tbody").append(mhtml);

                        }
                    });
                }
            }

            function addOrderRows() {
                console.log($("#order-products option:selected").val());
                if ($("#order-customer-qty").val() == "") {
                    return false;
                }
                mhtml = "";
                var exists = 0;
                if ($("#order-products option:selected").val() > 0) {

                    $('#order-product-list').find("td.id").each(function(index) {
                        if ($(this).html() === $("#order-products option:selected").val()) {
                            exists = 1;
                        }
                    });

                    mhtml += '<tr>';
                    mhtml += '<td style="display:none;">' + $("#order-customer-id").val() + '</td>';
                    mhtml += "<td class='id'>" + $("#order-products option:selected").val() + "</td>";
                    mhtml += "<td>" + $("#order-products option:selected").text() + "</td>";
                    mhtml += "<td style='display:none;'>";
                    $('#order-staff').children('option:selected').each(function() {
                        mhtml += $(this).val();
                    });
                    mhtml += "</td>";
                    mhtml += "<td>";
                    $('#order-staff').children('option:selected').each(function() {
                        mhtml += $(this).text();
                    });
                    mhtml += "</td>";

                    mhtml += '<td>' + $("#order-customer-qty").val() + '</td>';
                    mhtml += '<td><span class="label label-danger" onclick="removeproduct(' + $("#order-products option:selected").val() + ')" style="cursor:pointer">x</span></td>';
                    mhtml += "</tr>";
                }
                if (exists == 0) {
                    $("#order-product-list tbody").append(mhtml);
                } else {
                    swal({
                        title: "Product already added!",
                        text: 'If you want to change this product, please remove and add again.',
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                }
            }

            function removeproduct(val) {
                $('#order-product-list').find("td.id").each(function(index) {

                    if ($(this).html() == val) {
                        $(this).closest('tr').remove();
                    }
                });
            }


            function updateorder() {
                if ($("#order-id").val() == "") { //add new visit
                    var TableData;
                    TableData = storeOTblValues()
                    TableData = $.toJSON(TableData);

                    if (TableData.length > 2) {
                        $.ajax({
                            type: "POST",
                            url: "order_controller/addorders",
                            data: "orderdata=" + TableData,
                            success: function(data) {
                                var result = data.split("|");
                                if (result[0] === "success") {
                                    //$("#visit-id").val(result[1]);
                                    clearorder();
                                    openOrder(result[1]);
                                    toastr.success('Order created!', 'Done!');
                                    //getOpenOrders();
                                } else {
                                    swal({
                                        title: "Error",
                                        text: result[1],
                                        type: "error",
                                        confirmButtonText: 'OK!'
                                    });
                                }
                            }
                        });
                    } else {
                        swal({
                            title: "You have not added any Products",
                            text: 'Select Product and staff member providing that made the sale.',
                            type: "error",
                            confirmButtonText: 'OK!'
                        });
                    }
                } else { //update existing order
                    var TableData;
                    TableData = storeOTblValues();
                    TableData = $.toJSON(TableData);

                    $.ajax({
                        type: "POST",
                        url: "order_controller/updateorder",
                        data: "&orderdata=" + TableData + "&orderid=" + $("#order-id").val(),
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                //$("#visit-id").val(result[1]);
                                clearorder();
                                openOrder(result[1]);
                                toastr.success('Order Updated!', 'Done!');
                                //getOpenOrders();
                            } else {
                                swal({
                                    title: "Error",
                                    text: result[1],
                                    type: "error",
                                    confirmButtonText: 'OK!'
                                });
                            }
                        }
                    });
                }
            }

            function storeOTblValues()
            {
                var TableData = new Array();

                $('#ordertbl tr').each(function(row, tr) {
                    TableData[row] = {
                        "customerid": $(tr).find('td:eq(0)').text()
                        , "productid": $(tr).find('td:eq(1)').text()
                        , "productname": $(tr).find('td:eq(2)').text()
                        , "staffid": $(tr).find('td:eq(3)').text()
                        , "staff": $(tr).find('td:eq(4)').text()
                        , "qty": $(tr).find('td:eq(5)').text()

                    }
                });
                TableData.shift();  // first row will be empty - so remove
                return TableData;
            }

            function staff_client(vid) {
                $.ajax({
                    type: 'POST',
                    url: 'visits_controller/getstaffclient',
                    data: {visitid: vid},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data) {
                        swal({
                            title: "Busy with " + data[0]['customer_name'] + " since " + data[0]['since'],
                            text: '',
                            type: "info",
                            confirmButtonText: 'OK!'
                        });
                    }
                });
            }
            
            
            function giftVoucherForm() {

                if ($("#txt-customer-id").val() !== "") {
                    
                    $('#voucherModal').modal('show');
                    
                    //$(".nicescroll_4").niceScroll({ cursoropacitymin: 1 });

                    var voucher_services_html = $('#voucher-services').text();

                    if(voucher_services_html.length > 0){

                        //$(".nicescroll_5").niceScroll({ cursoropacitymin: 1 });

                    }

                }

            }
            
            function giftVoucherServices() {
                $('#voucher-services-categories').html('');
                $.ajax({
                    type: 'POST',
                    url: 'service_controller/getServicesCategories',
                    success: function(response) {

                        var data = $.parseJSON(response);

                        chtml = "";

                        chtml += '<ul>';

                        for (x = 0; x < data.length; x++) {

                            var id = data[x]['id_service_category'];
                            var name = data[x]['service_category'];
                            var image = '<img src="<?php echo base_url()."assets/images/category/"; ?>'+data[x]['service_category_image']+'">';
                            var category_name = "'"+name.replace(/(['"])/g, "\\$1")+"'";

                            chtml += '<li data-service_category_id="'+id+'" onclick="giftVoucherSubServices('+id+', '+category_name+');">'+image+' '+name+'</li>';

                        }

                        chtml += '</ul>';

                        $(".nicescroll_4").niceScroll({ cursoropacitymin: 1 });
                        $('#voucher-services-div').fadeIn();
                        $("#voucher-services-categories").append(chtml);

                    }
                });
            }

            function giftVoucherSubServices(id_service_category, name_service_category){

                $('#voucher-services-categories ul [data-service_category_id]').css('background-color', '#fff');

                $('#voucher-services-categories ul [data-service_category_id="'+id_service_category+'"]').css('background-color', '#f2f2f2');

                $("#voucher-services > ul").hide();
                $("#voucher-services span").remove();

                if($('#voucher-services').find('#'+id_service_category).length > 0){

                    $('#voucher-services').find('#'+id_service_category).show();

                } else{

                    $('#voucher-services > #fa-spinner').show();

                    $.ajax({

                        type: "POST",
                        url: "Service_controller/getServicesByCategory",
                        data: "id_service_category=" + id_service_category,

                        success: function(response){

                            var data = $.parseJSON(response);

                            if(data.length > 0){

                                $(".nicescroll_5").niceScroll({ cursoropacitymin: 1 });

                                chtml = "";

                                chtml += '<ul id="'+id_service_category+'">';

                                for (x = 0; x < data.length; x++) {

                                    var id = data[x]['id_business_services'];
                                    var name = data[x]['service_name'];
                                    var rate = data[x]['service_rate'];

                                    var checkbox = '<div class="checkbox checkbox-pink checkbox-circle"><input type="checkbox" value="'+id+'" name="id_business_services" service_name="'+name+'" service_rate="'+rate+'" id="'+id+'_business_services">';

                                    var label = '<label style="font-weight: normal;" for="'+id+'_business_services">'+name+'<br><span style="font-size:12px;">(Rate: '+rate+')<span></label></div>';

                                    chtml += '<li data-id_business_services="'+id+'">'+checkbox+' '+label+'</li>';

                                }

                                chtml += '</ul>';

                                $('#voucher-services > #fa-spinner').hide();

                                $("#voucher-services").append(chtml);

                            } else{

                                $('#voucher-services > #fa-spinner').hide();

                                $(".nicescroll_5").niceScroll({ cursoropacitymin: 1 });

                                $("#voucher-services").append('<span style="color: red">No Services</span>');

                            }

                        }

                    });

                }

            }
            
            function generateGiftVoucher(){
        
                var customer_id = $('#txt-customer-id').val();
                var is_type_checked = $('input[name=voucher-type]').is(":checked");
                var type = $('input[name=voucher-type]:checked').val();
                var valid_until = $('#voucher-valid-until').val();
                var price = $('#voucher-price').val();
                var voucher_number_option = $('#voucher-number-optional').val();
        
                var service_ids = "";
                var service_names = "";
                var service_rate = 0;

                $('input[name=id_business_services]:checked').each(function () {
                    service_ids += $(this).val() + '|';
                    service_names += $(this).attr('service_name') + '|';

                    service_rate += Number($(this).attr('service_rate'));
                });
        
                service_ids = service_ids.slice(0, -1);
                service_names = service_names.slice(0, -1);

                if(is_type_checked === false){
                    swal({
                        title: "Select Voucher Type",
                        text: 'You have forgot to select voucher type. Let\'s select a voucher type first.',
                        type: "error",
                        confirmButtonText: 'OK!'
                    }); return false;
                }
                if(type === 'amount'){
                    if(valid_until === "" || price === "" || price === "0"){
                        swal({
                            title: "Add Voucher Price and Valid Until",
                            text: 'You have forgot to add voucher price & valid until fields. Let\'s add these fields.',
                            type: "error",
                            confirmButtonText: 'OK!'
                        }); return false;
                    }
                }
                if(type === 'service'){
                    if(valid_until === "" || service_ids === ""){
                        swal({
                            title: "Select Services and Valid Until",
                            text: 'You have forgot to select services & valid until fields. Let\'s add these fields.',
                            type: "error",
                            confirmButtonText: 'OK!'
                        }); return false;
                    }
                    price = service_rate;
                }
        
                var post_data = 'service_names=' +service_names+ '&service_ids=' +service_ids+ '&price=' +price+ '&type=' +type+ '&customer_id=' +customer_id+ '&valid_until=' +valid_until+ '&voucher_number_option=' +voucher_number_option;

                $.ajax({

                    type: "POST",
                    url: "Scheduler_controller/updateVoucher",
                    data: post_data,

                    success: function(response){

                        var result = response.split('|');

                        if(result[0] === 'success'){

                            toastr.success('Gift Voucher Created', 'Done!');

                            $('#voucherBtnPreview').attr('href', '<?php echo base_url(); ?>viewvoucher/'+result[1]);
                            $('#voucherBtnPreview').fadeIn();
                            $('#voucherNumber').html('Voucher # <span class="label label-pink" style="padding: 7px; font-size: 15px;">'+result[2]+'</span>');
                            $('#voucherNumber').fadeIn();

                            $('#voucher-price-div').hide();
                            $('#voucher-price').val('');
                            $('#voucher-valid-until').val('');
                            $('#voucher-services-categories').html('');
                            $('#voucher-services').html('');
                            $('#voucher-services-div').hide();
                            $(".nicescroll_4").getNiceScroll().remove();
                            $(".nicescroll_5").getNiceScroll().remove();
                            $('input[name=voucher-type]').prop('checked', false);

                        }
                        if(result[0] === 'already_exist'){
                            swal({
                                title: "Voucher Number Already Exist",
                                text: 'Please type different voucher number or keep the voucher number field empty for automatic voucher number generate.',
                                type: "error",
                                confirmButtonText: 'OK!'
                            });
                        }

                    }

                });
        
            }

            $(document).ready(function(){

                $('input[name=voucher-type]').on('click', function(){

                    if($(this).val() === 'service'){

                        $('#voucher-price-div').hide();
                        $('#voucher-price').val('');
                        giftVoucherServices();

                    } else{

                        $('#voucher-services-categories').html('');
                        $('#voucher-services').html('');
                        $('#voucher-services-div').hide();
                        $('#voucher-price-div').fadeIn();
                        $(".nicescroll_4").getNiceScroll().remove();
                        $(".nicescroll_5").getNiceScroll().remove();

                    }

                    console.log('valeu: ' + $(this).val());
                });

                $('#voucher-valid-until').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy-mm-dd'
                });
                
                $('#visit-date').datetimepicker({
                    format: 'Y-MM-DD HH:mm:00',
                    useCurrent: true,
                    showClose: true
                });

            });


        </script>
        
<style>

    /* visit services */
    #visit-services-categories ul {
        list-style: none; padding: 0px;
    }
    #visit-services-categories ul li {
        cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
    }
    #visit-services-categories ul li img {
        height: 30px;
    }
    
    #visit-services ul {
        list-style: none; padding: 0px;
    }
    #visit-services ul li {
        cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
    }
    
    #visit-products ul {
        list-style: none; padding: 0px;
    }
    #visit-products ul li {
        cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
    }
    
    
    /* gift voucher services */
    #voucher-services-categories ul {
        list-style: none; padding: 0px;
    }
    #voucher-services-categories ul li {
        cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
    }
    #voucher-services-categories ul li img {
        height: 30px;
    }
    
    #voucher-services ul {
        list-style: none; padding: 0px;
    }
    #voucher-services ul li {
        cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
    }
    
</style>