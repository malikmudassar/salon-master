<div class="modal fade none-border" id="retailmodal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong>Retail</strong></h4>
            </div>
            <div class="modal-body">
                <div class="row" id="retail-divsearch">
                    <div class="col-lg-12">
                        <div id="retail-searchpanel" class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">Search Customer:</h4>
                            <div class="row">
                                <div class="col-lg-6 m-b-30">
                                    <!--Name Search Form-->
                                    <div id="retail-namesearchform">
                                        <div class="input-group">
                                            <input type="text" id="retail-name-search" name="name-search" class="form-control" placeholder="Name Search">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn waves-effect waves-light btn-pink" id="retail-btnname-search"><i class="fa fa-tag"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <!--End Name Search -->
                                </div>
                                <div class="col-lg-6 m-b-30">
                                    <!--Cell Phone Search Form-->
                                    <div id="retail-cellsearchform">
                                        <div class="input-group">
                                            <input type="text" id="retail-cell-search" name="cell-search" class="form-control numeric" placeholder="Cell Phone Search">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn waves-effect waves-light btn-custom" id="retail-btncell-search"><i class="fa fa-phone"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <!--End Name Search -->
                                </div>
                                <div class="col-lg-12">
                                    <div align="center" id="retail-newcustomeradding">
                                        <button type="submit" class="btn waves-effect waves-light btn-custom newcustomeradding"><i class="fa fa-plus"></i> Add Customer</button>
                                    </div>
                                </div>
                            </div>     
                        </div> 
                    </div>
                </div>

                <div id="retail-multiplesearch" class="row" style="display:none;">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <div class="dropdown pull-right open">
                                <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="true">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="javascript:void(0);" onclick="retail_hidemultisearch()">Hide</a></li>
                                </ul>
                            </div>
                            <h4 class="header-title m-t-0 m-b-30">Searched Customers:</h4>
                            <div class="row">
                                <div id="retail-customer_list" class="inbox-widget nicescroll" style="height: 315px; overflow: hidden; outline: none;" tabindex="5000">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="retail-con-close-modal" style="display: none;">
                    <div class="col-md-12">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">Update Customer Details:</h4>
                            <form id="retail-updateform">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="retail-detail-customer-name" class="control-label">Name</label>
                                                <input type="text" class="form-control" id="retail-detail-customer-name" name="detail-customer-name" placeholder="Name">
                                                <input type="hidden" class="form-control" id="retail-detail-customer-id" name="detail-customer-id">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="retail-detail-customer-cell" class="control-label">Cell Number</label>
                                                <input type="text" class="form-control" id="retail-detail-customer-cell" name="detail-customer-cell" placeholder="Cell Phone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="retail-detail-customer-phone1" class="control-label">Phone 1</label>
                                                <input type="text" class="form-control" id="retail-detail-customer-phone1" name="detail-customer-phone1"  placeholder="Phone 1">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="retail-detail-customer-phone2" class="control-label">Phone 2</label>
                                                <input type="text" class="form-control" id="retail-detail-customer-phone2" name="detail-customer-phone2"  placeholder="Phone 2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="retail-detail-customer-email" class="control-label">Email</label>
                                                <input type="email" class="form-control email"  id="retail-detail-customer-email" name="detail-customer-email" placeholder="Email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="retail-detail-customer-address" class="control-label">Address</label>
                                                <input type="text" class="form-control" id="retail-detail-customer-address" name="detail-customer-address" placeholder="Address">
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
                                                        <input type="text" class="form-control" placeholder="yyyy/mm/dd" id="retail-detail-customer-wedding" name="detail-customer-wedding">
                                                        <span class="input-group-addon bg-info b-0 text-white"><i class="ti-calendar"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>                                
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <label for="retail-detail-customer-bday" class="control-label">Birthday</label>
                                                </div>
                                                <div class="col-lg-4">
                                                    <select id="retail-detail-customer-bday" name="detail-customer-bday" class="form-control">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-8">
                                                    <select id="retail-detail-customer-bmonth" name="detail-customer-bmonth" class="form-control">
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
                                                <label for="retail-detail-customer-allergies" class="control-label text-danger">Allergies Alert</label>
                                                <input class="form-control" id="retail-detail-customer-allergies" name="detail-customer-allergies" placeholder="Note down any allergies the customer may have" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group ">
                                                <label for="retail-detail-customer-alert" class="control-label text-warning">Custom Alert</label>
                                                <input class="form-control" id="retail-detail-customer-alert" name="detail-customer-alert" placeholder="Note down any other alerts you want to get when the customer visits . . ." />
                                            </div>
                                        </div>
                                    </div>
                                <button type="button" class="btn btn-default waves-effect" onclick="javascript: $('#retail-con-close-modal').slideUp(); $('#retail-divmain').slideDown();">Close</button>
                                <button type="button" onclick="retail_updatecustomer();" class="btn btn-info waves-effect waves-light">Save changes</button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!--Products Sale Form-->
                <div class="row" id="retail-divorder" style="display:none;">
                    <div class="col-md-12">
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
                                        <label for="retail-order-products" class="control-label">Select Product</label>
                                        <input type="text" class='form-control' id="retail-order-products" name="order-products"  placeholder="Select Products">
                                        <!--<select class='form-control' id="retail-order-products" name="order-products" > </select>-->
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="checkboxall" class="control-label">?</label>
                                    <div class="checkbox checkbox-success">
                                        <input onchange="retail_getproducts();" id="checkboxall" type="checkbox">
                                        <label for="checkboxall">
                                            Show All Stores
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="retail-order-staff" class="control-label">Sold By</label>
                                        <select class='form-control'  id="retail-order-staff" name="order-staff"> 
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="order-customer-qty" class="control-label">Qty.</label>
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
                                                    <th>Category</th>
                                                    <th>Batch</th>
                                                    <th style="display:none;">Staff ID</th>
                                                    <th>Sold By</th>
                                                    <th>Qty.</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
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
                                
                                <form action="<?php echo base_url().'open_order_invoice'; ?>" method="post" target="_blank">
                                    <input type="hidden" class="form-control" id="order-id" name="order-id">
                                    <input type="hidden" name="csrf_test_name" id="retail_modal_csrf" value=""/>
                                    <div class="col-md-6" style="text-align:left">
                                        
                                        <button onclick="$('#retail_modal_csrf').val($('#cook').val()); retail_updateorder();" id="btngenorderinvoice" style='display:none;' class="btn btn-pink waves-effect waves-light">Generate Invoice</button>
                                    </div>
                                </form>
                                <div class="col-md-6" style="text-align: right">
                                    <button type="button" onclick="retail_openmain();" class="btn btn-default waves-effect" >Close</button>
                                    <button type="button" onclick="retail_updateorder();" class="btn btn-info waves-effect waves-light">Save Changes</button>
                                </div>
                            </div>
                        </div>
                        <!--</form>-->
                    </div>
                </div>        
                <!--End Products Sale Form-->

                <div class="row" id="retail-divmain">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">Customer Details:</h4>
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-1">
                                    <form class="form-horizontal" role="form" id="retail-customerform">
                                        <div class="form-group has-feedback">
                                            <label class="col-sm-4 control-label">Reference #</label>
                                            <div class="col-sm-8">
                                                <input readonly="readonly" type="text" id="retail-txt-customer-id" name="txt-customer-id" class="form-control" placeholder="Reference #">
                                                <!--<i class="fa fa-tag form-control-feedback l-h-34"></i>-->
                                            </div>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label class="col-sm-4 control-label">Name<span id="retail-customer-color"></span></label>
                                            <div class="col-sm-8">
                                                <input type="text" id="retail-txt-customer-name" name="txt-customer-name" class="form-control" placeholder="Name">
                                                <!--<i class="fa fa-user form-control-feedback l-h-34"></i>-->
                                            </div>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label class="col-sm-4 control-label">Email</label>
                                            <div class="col-sm-8">
                                                <input type="email"  id="retail-txt-customer-email" name="txt-customer-email" class="form-control" parsley-type="email" parsley-trigger="change" required placeholder="Email">
                                                <!--<i class="fa fa-envelope form-control-feedback l-h-34"></i>-->
                                            </div>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label class="col-sm-4 control-label">Cell</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="retail-txt-customer-cell" name="txt-customer-cell" class="form-control numeric" placeholder="Cell Phone">
                                                <!--<i class="fa fa-phone form-control-feedback l-h-34"></i>-->
                                            </div>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label class="col-sm-4 control-label">Address</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="retail-txt-customer-address" name="txt-customer-address"  class="form-control" placeholder="Address">
                                                <!--<i class="fa fa-location-arrow form-control-feedback l-h-34"></i>-->
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4 control-label">Birthday</label>
                                            <div class="col-sm-3">
                                                <select id="retail-txt-customer-bday" name="txt-customer-bday" class="form-control">
                                                    <option value=""></option>
                                                </select>
                                            </div>

                                            <div class="col-sm-5">
                                                <select id="retail-txt-customer-bmonth" name="txt-customer-bmonth" class="form-control">
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
                            </div>

                            <div class="row p-20">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <button  id="btnclear" type="button" onclick="retail_clearcustomerform();" class="btn btn-default waves-effect w-md m-b-5">Clear</button>
                                    <button id="retail-btnupdate" onclick="retail_addeditcustomer();" type="button" class="btn btn-purple btn waves-effect waves-primary w-md m-b-5">Add New</button>
                                    <button type="button" onclick="retail_openOrder(0);" class="btn btn-custom btn waves-effect w-md waves-success m-b-5">Products</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>