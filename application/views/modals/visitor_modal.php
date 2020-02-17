<div class="modal fade none-border" id="event-modal" tabindex="-1" role="dialog" aria-labelledby="Customers" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong>Add Customer Visit</strong></h4>
            </div>
            <div class="modal-body">
                
                <div class="row" id="divsearch">
                    <div class="col-lg-12">
                        <div id="searchpanel" class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">Search Customer:</h4>
                            <div class="row">
                                <div class="col-lg-5 m-b-30">
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
                                <div class="col-lg-2 m-b-30">
                                    <span class="input-group-btn">
                                        <button style="margin-left: 30px;" onclick="clearall();" class="btn waves-effect waves-light btn-default">Clear</button>
                                    </span>
                                </div>
                                <div class="col-lg-5 m-b-30">
                                    <!--Cell Phone Search Form-->
                                    <div id="cellsearchform">
                                        <div class="input-group">
                                            <input type="text" id="cell-search" name="cell-search" class="form-control numeric" placeholder="Cell Phone Search">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn waves-effect waves-light btn-custom" id="btncell-search"><i class="fa fa-phone"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <!--End Name Search -->
                                </div>
                                <div class="col-lg-12">
                                    <div align="center" id="newcustomeradding">
                                        <button type="submit" class="btn waves-effect waves-light btn-custom newcustomeradding"><i class="fa fa-plus"></i> Add Customer</button>
                                    </div>
                                </div>
                            </div>     
                        </div> 
                    </div>
                </div>

                <div id="multiplesearch" class="row" style="display:none;">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <div class="pull-right">
                                <button class="btn btn-inverse btn-xs w-md m-b-5" onclick="back('#multiplesearch', '#divsearch');"><i class="glyphicon glyphicon-chevron-left"></i> Back</button>
                            </div>
                            <h4 class="header-title m-t-0 m-b-30">Searched Customers:</h4>
                            <div class="row">
                                <div id="customer_list" class="inbox-widget nicescroll_1" style="height: 250px; overflow: hidden; outline: none;" tabindex="5000">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div align="center" id="newcustomeraddinglist">
                                        <button type="submit" class="btn waves-effect waves-light btn-custom newcustomeradding"><i class="fa fa-plus"></i> Add Customer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Update Customer -->
                <div id="con-close-modal" style="display: none;">
                    <div class="col-md-12">
                        <div class="card-box">
                            <div class="pull-right">
                                <button onclick="back('#con-close-modal', '#divmain');" class="btn btn-inverse btn-xs w-md m-b-5"><i class="glyphicon glyphicon-chevron-left"></i> Back</button>
                            </div>
                            <h4 class="header-title m-t-0 m-b-30">Update Customer Details:</h4>
                            <div>
                                <form id="updateform">
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
                                                <label for="" class="control-label">Wedding Anniversary</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="yyyy/mm/dd" id="detail-customer-wedding" name="detail-customer-wedding">
                                                    <span class="input-group-addon bg-info b-0 text-white"><i class="ti-calendar"></i></span>
                                                </div><!-- input-group -->
                                            </div>                                
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="detail-customer-bday" class="control-label">Birthday</label>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <select id="detail-customer-bday" name="detail-customer-bday" class="form-control">
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-8">
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
                                    <button type="button" onclick="updatecustomer();" class="btn btn-info waves-effect waves-light pull-right">Save changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Update Customer -->

                <div class="row" id="divmain" style="">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <div class="pull-right">
                                <button onclick="back('#divmain', '#divsearch');" class="btn btn-inverse btn-xs w-md m-b-5"><i class="glyphicon glyphicon-chevron-left"></i> Back</button>
                            </div>
                            <h4 class="header-title m-t-0 m-b-30">Customer Details:</h4>
                            <form role="form" id="customerform">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">Reference #</label>
                                            <input readonly="readonly" type="text" id="txt-customer-id" name="txt-customer-id" class="form-control" placeholder="Reference #">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">Name<span id="customer-color"></span></label>
                                            <input readonly="readonly" type="text" id="txt-customer-name" name="txt-customer-name" class="form-control" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">Email</label>
                                            <input readonly="readonly" type="email"  id="txt-customer-email" name="txt-customer-email" class="form-control" parsley-type="email" parsley-trigger="change" required placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">Cell</label>
                                            <input readonly="readonly" type="text" id="txt-customer-cell" name="txt-customer-cell" class="form-control numeric" placeholder="Cell Phone">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">Address</label>
                                            <input readonly="readonly" type="text" id="txt-customer-address" name="txt-customer-address"  class="form-control" placeholder="Address">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label class="control-label">Birthday</label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <select disabled="disabled" id="txt-customer-bday" name="txt-customer-bday" class="form-control">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                <div class="col-md-8">
                                                    <select disabled="disabled" id="txt-customer-bmonth" name="txt-customer-bmonth" class="form-control">
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
                            </form>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-sm-12">
                                    <div class="pull-right">
                                        <button id="btnupdate" onclick="addeditcustomer();" type="button" class="btn btn-purple btn waves-effect waves-primary w-md m-b-5">Add New</button>
                                        <button type="button" onclick="openVisit(0);" class="btn btn-warning btn waves-effect w-md waves-success m-b-5">Services</button>
                                    </div>
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
                                <div class="pull-right">
                                    <button onclick="back('#divvisit', '#divmain');" class="btn btn-inverse btn-xs w-md m-b-5"><i class="glyphicon glyphicon-chevron-left"></i> Back</button>
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
                                            <input readonly="readonly" type="text" class="form-control" id="visit-customer-name" name="visit-customer-name" placeholder="Name">
                                            <input type="hidden" id="visit-customer-id" name="visit-customer-id">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input readonly="readyonly" type="text" class="form-control" id="visit-customer-cell" name="visit-customer-cell" placeholder="Cell Phone">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input readonly="readyonly" type="text" class="form-control" id="visit-customer-email" name="visit-customer-email" placeholder="Email">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                            <label class="control-label">Services Categories</label>
                                            <div id="visit-services-categories" class="nicescroll_2" style="height: 200px; overflow: hidden; outline: none;">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                            <label for="visit-services" class="control-label">Select Services</label>
                                            <div id="visit-services" class="nicescroll_3" style="height: 200px; overflow: hidden; outline: none;">
                                                <div style="display: none;" id="fa-spinner" class="fa fa-spin fa-spinner"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="visit-staff-id" id="visit-staff-id">
                                    <input type="hidden" id="visit-staff" name="visit-staff">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="visit-prod" class="control-label">Products Used</label>
                                            <select multiple="multiple" id="visit-prod" name="visit-prod"> 

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12" id="haircolordiv" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="color-type" class="control-label">Types</label>
                                                    <select class="form-control" id="color-type" name="color-type" > 
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="color-number" class="control-label">Numbers</label>
                                                    <select class="form-control" id="color-number" name="color-number" > 
                                                        <option value="select">Select</option>
                                                        <option value="1">021</option>
                                                        <option value="2">022</option>
                                                        <option value="3">023</option>
                                                        <option value="4">024</option>
                                                        <option value="5">025</option>
                                                        <option value="6">026</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="color-duration" class="control-label">Time Applied</label>
                                                    <input type="text" id="color-duration" name="color-duration" class="form-control" style="position:relative; z-index: 99999999 !important;">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="color-cost" class="control-label">Cost</label>
                                                    <input type="text" id="color-cost" name="color-cost" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="text-align: right">
                                    <input type="hidden" class="form-control" id="visit-id-1" name="visit-id-1">
                                    <div class="col-md-6" style="text-align:left"></div>
                                    <div class="col-md-6" style="text-align: right">
                                        <button type="button" onclick="updatevisit();" class="btn btn-info waves-effect waves-light">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        <!--</form>-->
                    </div>
                </div>
                <!--End Visit Form-->
                
            </div>
        </div>
    </div>
</div>