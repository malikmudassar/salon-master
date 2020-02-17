

<div class="wrapper">
<div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn-group pull-right m-t-15">
                            <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Settings <span class="m-l-5"><i class="fa fa-cog"></i></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </div>
                        <h4 class="page-title">Calendar</h4>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">

                        <div class="row">
                            <div class="col-md-3 hidden">
                                <div class="widget">
                                    <div class="widget-body">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <a href="#" data-toggle="modal" data-target="#add-category" class="btn btn-lg btn-success btn-block waves-effect waves-light">
                                                    <i class="fa fa-plus"></i> Create New
                                                </a>
                                                <div id="external-events" class="m-t-20 fc-event-container">
                                                    <br>
                                                    <p>Drag and drop your event or click in the calendar</p>
                                                    <div class="external-event bg-primary fc-event" data-class="bg-primary">
                                                        <i class="fa fa-move"></i>New Theme Release
                                                    </div>
                                                    <div class="external-event bg-pink fc-event" data-class="bg-pink">
                                                        <i class="fa fa-move"></i>My Event
                                                    </div>
                                                    <div class="external-event bg-warning fc-event" data-class="bg-warning">
                                                        <i class="fa fa-move"></i>Meet manager
                                                    </div>
                                                    <div class="external-event bg-purple fc-event" data-class="bg-purple">
                                                        <i class="fa fa-move"></i>Create New theme
                                                    </div>
                                                </div>

                                                <!-- checkbox -->
                                                <div class="checkbox m-t-40">
                                                    <input id="drop-remove" type="checkbox">
                                                    <label for="drop-remove">
                                                        Remove after drop
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-md-12">
                                <div class="card-box">
                                    <div id="calUpperDiv">
                                        <div id="calendar" style=""></div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>  <!-- end row -->
                        
                        <!--Event View Model-->
                        <div class="modal fade none-border" id="eventview" tabindex="-1" role="dialog" aria-labelledby="Event View" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title" id="eventview-heading">Visit details: </h4>
                                    </div>
                                    <div class="modal-body">
                                        <dl class="dl-horizontal">
                                            <dt>Customer</dt>
                                            <dd id="eventcustomer"></dd>
                                            <dt>Staff</dt>
                                            <dd id="eventstaff"></dd>
                                            <dt>Service</dt>
                                            <dd id="eventservice"></dd>
                                            <dt>Start Time</dt>
                                            <dd id="eventstart"></dd>
                                            <dt>End Time</dt>
                                            <dd id="eventend"></dd>
                                        </dl>
<!--                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Customer</th>
                                                    <th>Staff</th>
                                                    <th>Service</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td id="eventcustomer"></td>
                                                    <td id="eventstaff"></td>
                                                    <td id="eventservice"></td>
                                                    <td id="eventstart"></td>
                                                    <td id="eventend"></td>
                                                </tr>
                                            </tbody>
                                        </table>-->
                                    </div>
                                    <div class="modal-footer">
                                        <div style="text-align: right">
                                            <?php echo form_open('open_new_invoice'); ?>
                                            <input type="hidden" class="form-control" id="visit-id" name="visit-id">
                                                <div class="col-md-6" style="text-align:left">
                                                    <button id="btngeninvoice" style="" class="btn btn-pink waves-effect waves-light">Generate Invoice</button>
                                                </div>
                                            </form>
                                        </div>
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div>
                        <!--END Event View Model-->

                        <!-- BEGIN MODAL -->
                        <div class="modal fade none-border" id="event-modal" tabindex="-1" role="dialog" aria-labelledby="Customers" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><strong>Add New Event</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row" id="divsearch">
                                            <div class="col-lg-12">
                                                <div id="searchpanel" class="card-box">
                                                    <h4 class="header-title m-t-0 m-b-30">Search Customer:</h4>
                                                    <div class="row">
                                                        <div class="col-lg-6 m-b-30">
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
                                                        <div class="col-lg-6 m-b-30">
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
                                        
                                        <!--Add Appointment Model-->
                                        <div class="row" id="add-appointment-modal" style="display: none;">
                                            <div class="col-md-12">
                                                <div class="card-box">
                                                    <h4 class="header-title m-t-0 m-b-30">Add Customer Appointment:</h4>
                                                    <form id="addappointment">
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
                                                                    <div class="row">
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
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-12 ">
                                                                            <label for="appointment-remarks" class="control-label">Remarks</label>
                                                                            <input id="appointment-remarks" name="appointment-remarks" type="text" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-default waves-effect" onclick="javascript: $('#add-appointment-modal').slideUp(); $('#divmain').slideDown();">Close</button>
                                                        <button type="button" onclick="addappointment();" class="btn btn-pink waves-effect waves-light">Save</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End Add Appointment Model-->
                                        
                                        <!--Update Customer Model-->
                                        <div id="con-close-modal" style="display: none;">
                                            <div class="col-md-12">
                                                <div class="card-box">
                                                    <h4 class="header-title m-t-0 m-b-30">Update Customer Details:</h4>
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
                                                                        <input type="email" class="form-control email"  id="detail-customer-email" name="detail-customer-email" placeholder="Email">
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
                                                                <div class="col-md-6">
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
                                                        <button type="button" class="btn btn-default waves-effect" onclick="javascript: $('#con-close-modal').slideUp(); $('#divmain').slideDown();">Close</button>
                                                        <button type="button" onclick="updatecustomer();" class="btn btn-info waves-effect waves-light">Save changes</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End Update Customer Model-->
                                        
                                        <div class="row" id="divmain" style="">
                                            <div class="col-lg-12">
                                                <div class="card-box">
                                                    <h4 class="header-title m-t-0 m-b-30">Customer Details:</h4>
                                                    <div class="row">
                                                        <div class="col-sm-8 col-sm-offset-1">
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
                                                        <div class="col-sm-8 col-sm-offset-2">
                                                            <button  id="btnclear" type="button" onclick="clearcustomerform();" class="btn btn-default waves-effect w-md m-b-5">Clear</button>
                                                            <button id="btnupdate" onclick="addeditcustomer();" type="button" class="btn btn-purple btn waves-effect waves-primary w-md m-b-5">Add New</button>
<!--                                                            <button type="button" onclick="openAppointment();" class="btn btn-pink btn waves-effect w-md waves-info m-b-5">Appointments</button>-->
                                                            <button type="button" onclick="openVisit(0);" class="btn btn-warning btn waves-effect w-md waves-success m-b-5">Services</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!--Visit Service Form-->
                                        <div class="row" id="divvisit" style="display:none;">
                                            <div class="col-md-12">
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

                                                        <h4 class="header-title m-t-0 m-b-30">Enter Customer Visit Details</h4>
                                                        <div id="customer_alert" class="row" style="display: none">
                                                            <div id="alert_text" class="alert alert-danger">
                                                                <strong>Customer Alert!</strong>
                                                            </div>
                                                        </div>
                                                        <div class="row">
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
                                                                <div class="form-group">
                                                                    <label for="visit-services" class="control-label">Select Services</label>
                                                                    <select class='form-control' id="visit-services" name="visit-services" > 

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="visit-staff" class="control-label">Selected Staff</label>
                                                                    <input type="hidden" name="visit-staff-id" id="visit-staff-id">
                                                                    <input readonly="readonly" type="text" class="form-control" id="visit-staff" name="visit-staff">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="visit-prod" class="control-label">Products Used</label>
                                                                    <select multiple="multiple" id="visit-prod" name="visit-prod"> 

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" style="text-align: right">
                                                            <input type="hidden" class="form-control" id="visit-id-1" name="visit-id-1">
                                                            <div class="col-md-6" style="text-align:left"></div>
                                                            <div class="col-md-6" style="text-align: right">
                                                                <button type="button" onclick="openmain();" class="btn btn-default waves-effect" >Close</button>
                                                                <button type="button" onclick="updatevisit();" class="btn btn-info waves-effect waves-light">Save Changes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!--</form>-->
                                            </div>
                                        </div>
                                        <!--End Visit Form-->
                                        
                                    <div class="modal-footer">
<!--                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-success save-event waves-effect waves-light">Create event</button>
                                        <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Delete</button>-->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Add Category -->
                        <div class="modal fade none-border" id="add-category">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><strong>Add a category </strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="control-label">Category Name</label>
                                                    <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name"/>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label">Choose Category Color</label>
                                                    <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color">
                                                        <option value="success">Success</option>
                                                        <option value="danger">Danger</option>
                                                        <option value="info">Info</option>
                                                        <option value="pink">Pink</option>
                                                        <option value="primary">Primary</option>
                                                        <option value="warning">Warning</option>
                                                        <option value="inverse">Inverse</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END MODAL -->
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
                    </div>
                    <!-- end col-12 -->
                </div> <!-- end row -->

</div>
    
<style>
    .fc-time-grid .fc-slats td{ height: 50px; }
    .fc th.fc-widget-header{ padding: 0 4px; }
</style>
    
<script>
    
    function storeVTblValues(){
        var TableData = new Array();
        $('#visittbl tr').each(function(row, tr){
            TableData[row]={
                "customerid" : $(tr).find('td:eq(0)').text()
                , "serviceid" : $(tr).find('td:eq(1)').text()
                , "servicename" :$(tr).find('td:eq(2)').text()
                , "staffid" :$(tr).find('td:eq(3)').text()
                , "staff" : $(tr).find('td:eq(4)').text()
                , "productid" : $(tr).find('td:eq(5)').text()
                , "productname" : $(tr).find('td:eq(6)').text()
                , "servicecolor" : $(tr).find('td:eq(7)').text()
                , "serviceduration" : $(tr).find('td:eq(8)').text()
            }    
        }); 
        TableData.shift();  // first row will be empty - so remove
        return TableData;
    }
    
    function clearappointment(){
        $("#appointment-customer-id").val('');
        $("#appointment-customer-name").val('');
        $("#appointment-remarks").val('');
    }
    
    function clearorder(){
        console.log('ordercleared');
        $("#order-customer-id").val('');
        $("#order-customer-name").val('');
        $("#order-id").val('');
        $("#order-customer-cell").val('');
        $("#order-customer-email").val('');

        $('#order-products > option').eq(0).attr('selected','selected');
        $("#order-product-list tbody").html("");
        $("#tbllastorders tbody").html('');
        $("#btngenorderinvoice").hide();
    }
    
    function clearvisit(){
        $("#visit-customer-id").val('');
        $("#visit-customer-name").val('');
        $("#visit-id-1").val('');
        $("#visit-customer-cell").val('');
        $("#visit-customer-email").val('');

        $('#visit-services > option').eq(0).attr('selected','selected');
        $("#visit-service-list tbody").html("");
        $("#tbllastvisits tbody").html('');
        $("#btngeninvoice").hide();
    }
    
    function removeservice(val) {
        $('#visit-service-list').find("td.id").each(function(index) {
            if ($(this).html() == val) {
                $(this).closest('tr').remove();
            }
        });
    }
    
    function getservices() {
        $('#visit-services').children().remove();
        $.ajax({
            type: 'POST',
            url: 'service_controller/services',
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                chtml = "";
                current_cat = "";
                last_cat = "";
                for (x = 0; x < data.length; x++) {
                    current_cat = data[x]['id_service_category'];
                    if (current_cat !== last_cat) {
                        if (x === 0) {
                            chtml += '<optgroup label="' + data[x]['service_category'] + '">';
                            chtml += '<option value=' + data[x]['id_business_services'] + ' data-servicecolor=' + data[x]['service_color'] + ' data-serviceduration=' + data[x]['service_duration'] + '>' + data[x]['service_name'] + '</option>';
                        } else {
                            chtml += '</optgroup>';
                            chtml += '<optgroup label="' + data[x]['service_category'] + '">';
                            chtml += '<option value=' + data[x]['id_business_services'] + ' data-servicecolor=' + data[x]['service_color'] + ' data-serviceduration=' + data[x]['service_duration'] + '>' + data[x]['service_name'] + '</option>';
                        }
                    } else {
                        chtml += '<option value=' + data[x]['id_business_services'] + ' data-servicecolor=' + data[x]['service_color'] + ' data-serviceduration=' + data[x]['service_duration'] + '>' + data[x]['service_name'] + '</option>';
                    }
                    last_cat = data[x]['id_service_category'];
                }
                chtml += '</optgroup>';
                $("#visit-services").append(chtml);

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
    
    function getOpenVisits(){
        $.ajax({
            type: 'POST',
            url: 'visits_controller/get_visits',
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                var mhtml="";
                for (x = 0; x < data.length; x++) {
                    var mdate = new Date(data[x]['customer_visit_date']);
                    var visittime = mdate.getHours() + ":" + mdate.getMinutes();
                    var visitmonth = mdate.getMonth() + 1;
                    var visitdate = mdate.getDate() + "/" + visitmonth + "/" + mdate.getFullYear();
                    mhtml += ' <a href="javascript:void(0)" onclick="openVisit(' + data[x]['id_customer_visits']+','+ data[x]['id_customers'] + ')" >';
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
    
    function setServiceTime(duration){
        var t1 = localStorage.getItem('time');
        var t2 = duration;
        t1 = t1.split(':');
        t2 = t2.split(':');
        var mins;
        var hrs;
        var secs = '00';
        mins = Number(t1[1]) + Number(t2[1]);
        minhrs = Math.floor(parseInt(mins / 60));
        hrs = Number(t1[0]) + Number(t2[0]) + minhrs;
        mins = mins % 60;
        mins = mins < 10 ? '0'+mins : mins;
        hrs = hrs < 10 ? '0'+hrs : hrs;
        var newtime = hrs + ':' + mins + ':' + secs;
        return newtime;
    }
    
    function createEvents(service_id, service_duration, service_color, visitid, visit_sid){
        
        var newtime = setServiceTime(service_duration);

        localStorage.setItem('time', newtime);

        console.log('New Time: ' + newtime);

        var newstart = localStorage.getItem('start');
        var newend = localStorage.getItem('date') + "T" + newtime;
        var staffid = localStorage.getItem('staff_id');

        localStorage.setItem('start', newend);

        $.ajax({
            type: "POST",
            url: "Scheduler_controller/updateVisitTime",
            data: "visitid=" + visitid + "&service_id=" + service_id + "&start=" + newstart + "&end=" + newend + "&visit_sid=" + visit_sid,
            success: function(data){
                if (data === "success") {
                    return true;
                } else{
                    return false;
                }
            }
        });

        $('#calendar').fullCalendar('renderEvent',{
            //console.log(item.serviceduration);
            id: visit_sid,
            title: localStorage.getItem('customer_name')+" - visit",
            backgroundColor: service_color,
            start: newstart,
            end: newend,
            resourceId: staffid
        },
        true // make the event "stick"
        );
    }
    
    function updatevisit(){
        
        var visit_id = $("#visit-id-1").val() != "" ? $("#visit-id-1").val() : 0;
        var service_id = $("#visit-services option:selected").val();
        var service_name = $("#visit-services option:selected").text();
        var service_color = $("#visit-services option:selected").attr('data-servicecolor');
        var service_duration = $("#visit-services option:selected").attr('data-serviceduration');
        var staff_id = $('#visit-staff-id').val();
        var staff_name = $('#visit-staff').val();
        var customer_id = $("#visit-customer-id").val();
        var product_names = "";
        var product_ids = "";
        var visit_sid;
        
        $('#visit-prod optgroup').children('option:selected').each(function() {
            product_names += " " + $(this).text() + "|";
        });
        
        $('#visit-prod optgroup').children('option:selected').each(function() {
            product_ids += " " + $(this).val() + "|";
        });

        var dataInfo = 'service_id=' +service_id+ '&service_name=' +service_name+ '&staff_id=' +staff_id+ '&staff_name=' +staff_name+ '&customer_id=' +customer_id+ '&visit_id=' +visit_id+ '&product_ids=' +product_ids+ '&product_names=' +product_names;

        $.ajax({
            type: "POST",
            url: "Scheduler_controller/addvisits",
            data: dataInfo,
            success: function(data){
                var result = data.split("|");
                if (result[0] === "success") {
                    //$("#visit-id").val(result[1]);
                    clearvisit();
                    openVisit(result[1]);
                    toastr.success('Visit created!', 'Done!');
                    //getOpenVisits();
                    
                    visit_sid = result[2];

                    createEvents(service_id, service_duration, service_color, result[1], visit_sid);

                    $('#event-modal').modal('hide');

                } else if (result[0] === "already_exist") {
                    swal({
                        title: "Service already added!",
                        text: '',
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
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
    
    function getlast4visits(){
        if($("#visit-customer-id").val() !== ""){
            $("#tbllastvisits tbody").html('');
            $.ajax({
                type: 'POST',
                url: 'visits_controller/getlast4visits/'+$("#visit-customer-id").val(),
                dataType: "json",
                cache: false,
                async: true,
                success: function(data) {
                var mhtml="";
                    for (x = 0; x < data.length; x++) {
                        mhtml+='<tr onclick="fillvisit('+ data[x]['id_customer_visits'] + ',1)">';
                        mhtml+='<td><span class="label label-pink">'+ data[x]['id_customer_visits'] +'</span></td>';
                        mhtml+='<td>'+ data[x]['visit_date'] +'</td>';
                        mhtml+='<td>'+ data[x]['service_name'] +'</td>';
                        mhtml+='<td>'+ data[x]['staff_names'] +'</td>';
                        mhtml+='<td>'+ data[x]['product_names'] +'</td>';
                        mhtml+='</tr>';
                    }
                    $("#tbllastvisits tbody").append(mhtml);
                }
            });
        }
    }
    
    function fillvisit(visitid,qtype){
        var myurl
        if(qtype == 1){
            myurl= 'visits_controller/getVisitbyid/1';
        } else {
            myurl= 'visits_controller/getVisitbyid';
        }

        $.ajax({
            type: 'POST',
            url: myurl,
            data:{id_customer_visit: visitid},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                //console.log(data);
                if(qtype == 1){
                    $("#visit-id-1").val('');
                } else {
                    $("#visit-id-1").val(data[0]['id_customer_visits']);
                }
                $("#visit-customer-id").val(data[0]['customer_id']);
                $("#visit-customer-name").val(data[0]['customer_name']);
                $("#visit-customer-cell").val(data[0]['customer_cell']);
                $("#visit-customer-email").val(data[0]['customer_email']);
                
                $("#btngeninvoice").show();
            }
        });
    }
    
    function checkopenvisit(cid){
        $.ajax({
           type: 'POST',
           url: 'visits_controller/getVisitbyCid',
           data: {customerid: cid},
           dataType: "json",
           cache: false,
           async: true,
           success: function(data) {

               if(data.length>0){
                   clearvisit();
                   fillvisit(data[0]['id_customer_visits']);
               }   
           }
       });
   }
    
    function getinhouseproducts(){
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
                    if(data[x]['staff_available']!=''){
                        mhtml += '<a href="javascript:void(0);" onclick="staff_client(' + data[x]['staff_available'] + ')">';
                    }
                    mhtml += '<div class="inbox-item">';
                    if(data[x]['staff_image']!=""){
                        mhtml += '<div class="inbox-item-img"><img src="<?php echo base_url(); ?>assets/images/staff/' + data[x]['staff_image'] + '" class="img-circle" alt="' + data[x]['staff_fullname'] + '"></div>';
                    }
                    if(data[x]['staff_available']!=''){
                        mhtml += '<p class="inbox-item-author">' + data[x]['staff_fullname'] + ' <span class="text-danger">Busy</span></p>';
                    } else {
                        mhtml += '<p class="inbox-item-author">' + data[x]['staff_fullname'] + '</p>';
                    }
                    mhtml += '<p class="inbox-item-text">' + data[x]['staff_cell'] + '</p>';
                    mhtml += '<p class="inbox-item-date">' + data[x]['timein'] + '</p>';
                    mhtml += '</div>';
                    if(data[x]['staff_available']!=''){
                        mhtml += '</a>';
                    }
                }
                $("#presentstaff").html(mhtml);
            }
        });
    }
    
    function openVisit(visitid, cid) {
        //getstaff();
        getinhouseproducts();
        if(visitid !== 0){
            fillvisit(visitid);
            getbyid(cid);
            $("#divmain").slideUp();
            $("#divvisit").slideDown();
        }else if ($("#txt-customer-id").val() != "") {
            //console.log('customer name: '+$("#txt-customer-name").val());
            $("#visit-customer-id").val($("#txt-customer-id").val());
            $("#visit-customer-name").val($("#txt-customer-name").val());
            $("#visit-customer-cell").val($("#txt-customer-cell").val());
            $("#visit-customer-email").val($("#txt-customer-email").val());
            checkopenvisit($("#txt-customer-id").val());
            $("#divmain").slideUp();
            $("#divvisit").slideDown();
        }
        //getlast4visits();
    }
    
    function closelistopenapp() {
        $("#existingappointment").modal('hide');
        $("#appointment-customer-id").val($("#txt-customer-id").val());
        $("#appointment-customer-name").val($("#txt-customer-name").val());
        $("#add-appointment-modal").slideDown();
    }
    
    function openAppointment() {
        if ($("#txt-customer-id").val() !== "") {
            $('#divmain').slideUp();
            $.ajax({
                type: 'POST',
                url: 'scheduler_controller/appointmentsbyid',
                data: {id: $("#txt-customer-id").val()},
                dataType: "json",
                cache: false,
                async: true,
                success: function(data) {
                    var mhtml = '';
                    if (data.length == 0) {
                        $("#appointment-customer-id").val($("#txt-customer-id").val());
                        $("#appointment-customer-name").val($("#txt-customer-name").val());
                        $("#add-appointment-modal").slideDown();
                    } else {
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
        $("#divmain").slideUp();
        $('#add-appointment-modal').slideUp();
        $("#con-close-modal").slideDown();
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
    
    function addeditcustomer() {
        if ($("#btnupdate").text() === "Add New") {
            if ($("#txt-customer-name").val() === "" || $("#txt-customer-cell").val() === "") {
                swal({
                    title: "Add Name and Cell Phone",
                    text: "You forgot to enter the NAME, CELL PHONE and EMAIL of the new customer. Let's start with putting in this mandatory information first.",
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
    
    function fillupdateform(data) {
        if(data[0]['customer_allergies']!="" || data[0]['customer_alert']!=""){
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
        
    function clearcustomerform() {
        if($("#txt-customer-email").length > 0){
            mfield = $("#txt-customer-email").parsley();
            window.ParsleyUI.removeError(mfield, 'required');
            window.ParsleyUI.removeError(mfield, 'email');
            $("#txt-customer-email").removeClass('parsley-error');
        }
        if($("#detail-customer-email").length > 0){
            mfield = $("#detail-customer-email").parsley();
            window.ParsleyUI.removeError(mfield, 'required');
            window.ParsleyUI.removeError(mfield, 'email');
            $("#detail-customer-email").removeClass('parsley-error');
        }
        
        localStorage.setItem("customer_id", "");
        localStorage.setItem("customer_name", "");
        localStorage.setItem("customer_cell", "");
        localStorage.setItem("customer_email", "");
        
        //$('#name-search').val('');
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

    function fillcustomerform(data) {
        clearcustomerform();
        $("#con-close-modal").slideUp();
        $("#divmain").slideUp();
        $("#divvisit").slideUp();
        $('#add-appointment-modal').slideUp();
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
            $("#divmain").slideDown();
            
            localStorage.setItem("customer_id", data[0]['id_customers']);
            localStorage.setItem("customer_name", data[0]['customer_name']);
            localStorage.setItem("customer_cell", data[0]['customer_cell']);
            localStorage.setItem("customer_email", data[0]['customer_email']);
            
            fillupdateform(data);
        } else {
            clearcustomerform();
        }
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
            }
        });
    }
    
    function openmain(){
        clearorder();
        clearvisit();
        clearappointment();
        if($('#divvisit').is(':visible')){
            $("#divvisit").slideUp();
        }
        if($('#divorder').is(':visible')){
            $("#divorder").slideUp();
        }
        $("#divmain").slideDown();
    }
    
    function fillBday() {
        for (x = 1; x <= 31; x++) {
            $("#txt-customer-bday").append('<option value=' + x + '>' + x + '</option>');
            $("#detail-customer-bday").append('<option value=' + x + '>' + x + '</option>');

        }
    }

    $(document).ready(function() {
        
        fillBday();
        getAppointments();
        getstaff();
        getservices();
        getOpenVisits();
        
        $('#detail-customer-wedding').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy/mm/dd'
        });
        
//        $("#visit-staff").select2({
//            //maximumSelectionLength: 2
//        });
        
        $("#visit-prod").select2({
            //maximumSelectionLength: 2
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
        
        

        var calendar = $('#calendar').fullCalendar({
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            defaultView: 'agendaDay',
            slotDuration: '00:15:00', /* If we want to split day time each 15minutes */
            minTime: '08:00:00',
            maxTime: '24:00:00',
            editable: true,
            allDaySlot: false,
            selectable: true,
            eventLimit: true, // allow "more" link when too many events
            
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'agendaDay,agendaWeek'
            },
            
            resourceRender: function(resourceObj, labelTds, bodyTds) {
                $.ajax({
                    url: '<?php echo base_url().'Scheduler_controller/getStaffImages'; ?>',
                    data: 'staff_id='+resourceObj.id,
                    type: 'POST',
                    success: function(response){
                        //var base_url = '<?php echo base_url(); ?>';
                        labelTds.css({
                            
                            'background-image':'url('+response+')',
                            'background-color':'#fff',
                            'background-size':'80px 80px',
                            'background-repeat':'no-repeat',
                            'height':'190px',
                            'color':'#808080',
                            'background-position':'center'
                        });
                    }
                    
                });
            },
            
            resourceColumns: [
                {
                    id: 9,
                    labelText: 'First Name',
                    field: 'fname',
                    width: '500px'
                }
            ],

            resources: [
                <?php echo $resources; ?>
            ],
            
            events: [
                <?php echo $events; ?>
            ],
            
            eventClick: function(calEvent, jsEvent, view) {
                
                //if(view.name === 'agendaDay'){
                    
                    $.ajax({
                        url: 'Scheduler_controller/getvisitdetails',
                        data: 'visit_service_id=' +calEvent.id,
                        type: 'POST',
                        success: function(response){

                            var data = $.parseJSON(response);

                            $('#eventcustomer').html('');
                            $('#eventstaff').html('');
                            $('#eventservice').html('');
                            $('#eventstart').html('');
                            $('#eventend').html('');
                            
                            var startdt = data[0].visit_service_start;
                            startdt = startdt.split("T");
                            
                            var startdate = startdt[0].replace(/-/g, '/');
                            var starttime = startdt[1];
                            
                            var enddt = data[0].visit_service_end;
                            enddt = enddt.split("T");
                            
                            var enddate = enddt[0].replace(/-/g, '/');
                            var endtime = enddt[1];

                            $('#eventcustomer').html(data[0].customer_name);
                            $('#eventstaff').html(data[0].staff_names);
                            $('#eventservice').html(data[0].service_name);
                            $('#eventstart').html(startdate+ " - " +starttime);
                            $('#eventend').html(enddate+ " - " +endtime);
                            $('#visit-id').val(data[0].customer_visit_id);

                            $('#eventview').modal('show');

                        }
                    });
                    
                //}

            },
            
            eventResize: function(event, delta, revertFunc) {
                
                $.ajax({
                    url: 'Scheduler_controller/updatevisit',
                    data: 'id_visit_services=' +event.id+ '&staff_id=' +event.resourceId+ '&start=' +event.start.format()+ '&end=' +event.end.format(),
                    type: 'POST',
                    success: function(response){

                        if(response == 'success'){
                            
                            toastr.success('Visit timing resized!', 'Done!');
                            
                        } else {
                            
                            swal({
                                title: "eventResize Error",
                                text: response,
                                type: "error",
                                confirmButtonText: 'OK!'
                            });
                            
                        }

                    }
                });
                
            },
            
            eventDrop: function(event, delta, revertFunc) {
                
                $.ajax({
                    url: 'Scheduler_controller/updatevisit',
                    data: 'id_visit_services=' +event.id+ '&staff_id=' +event.resourceId+ '&start=' +event.start.format()+ '&end=' +event.end.format(),
                    type: 'POST',
                    success: function(response){

                        if(response == 'success'){
                            
                            toastr.success('Visit staff changed!', 'Done!');
                            
                        } else {
                            
                            swal({
                                title: "eventDrop Error",
                                text: response,
                                type: "error",
                                confirmButtonText: 'OK!'
                            });
                            
                        }

                    }
                });
                
//                console.log(
//                    "Event Title: " + event.title + " ==== " +
//                    "Event Start: " + event.start.format() + " ==== " +
//                    "Event End: " + event.end.format() + " ==== " +
//                    "Resource ID: " + event.resourceId
//                );
                
            },
            
            select: function(start, end, jsEvent, view, resource) {
                
                $('#name-search').val('');
                $('#cell-search').val('');
                $("#divmain").slideDown();
                $("#divvisit").hide();
                $("#multiplesearch").hide();
                $("#con-close-modal").hide();
                $("#add-appointment-modal").hide();
                
                clearcustomerform();
                
                localStorage.setItem("staff_id", "");
                localStorage.setItem("staff_name", "");
                localStorage.setItem("start", "");
                localStorage.setItem("end", "");
                localStorage.setItem("year", "");
                localStorage.setItem("month", "");
                localStorage.setItem("day", "");
                localStorage.setItem("hours", "");
                localStorage.setItem("minutes", "");
                localStorage.setItem("seconds", "");
                localStorage.setItem("time", "");
                
                localStorage.setItem("staff_id", resource.id);
                localStorage.setItem("staff_name", resource.title);
                localStorage.setItem("start", start.format());
                localStorage.setItem("end", end.format());
                localStorage.setItem("date", start.format('YYYY-MM-DD'));
                localStorage.setItem("year", start.format('YYYY'));
                localStorage.setItem("month", start.format('MMMM'));
                localStorage.setItem("day", start.format('dddd'));
                localStorage.setItem("hours", start.format('hh'));
                localStorage.setItem("minutes", start.format('mm'));
                localStorage.setItem("seconds", start.format('ss'));
                localStorage.setItem("time", start.format('hh:mm:ss'));
                
                if(view.name === 'agendaDay'){
                    
                    $('#visit-staff').val(localStorage.getItem('staff_name'));
                    $('#visit-staff-id').val(localStorage.getItem('staff_id'));
                    $('#event-modal').modal('show');
                    
                }

            },
            
            /*
            dayClick: function(date, jsEvent, view, resource) {
                
                console.log(
                    'dayClick',
                    date.format(),
                    resource ? resource.id : '(no resource)'
                );
        
            }
            */
           
        });
        
        <?php if(count($staff_list) > 13){ ?>
        $('#calUpperDiv').css(
            {
                'overflow' : 'hidden',
                'overflow-x' : 'scroll'
            }
        );
        $('.fc-view-container').css(
            {
                'min-width' : '1500px'
            }
        );
        <?php } ?>

    });

</script>