<div class="modal fade none-border" id="event-modal" tabindex="-1" role="dialog" aria-labelledby="Customers" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content" style="padding-bottom: 0px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong id="modal-header-title"></strong> <span id="balanceid"></span></h4>
            </div>
            <div class="modal-body">
                
                <div id="voucherbuttons" style="display: none; text-align: center;">
                    <button class="btn btn-pink waves-effect waves-light verifyvoucher">Verify</button>
                    <button class="btn btn-success waves-effect waves-light newvoucher">Create</button>
                </div>
                
                <!-- Search Box -->
                <div class="row" id="divsearch">
                    <div class="col-lg-12">
                        <div id="searchpanel" class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">Search Customer:</h4>
                            <div class="row">
                                <?php if(isset($scheduler_style) && $scheduler_style[0]['scheduler_input_search'] === "Y"){ ?>
                                <div class="col-lg-3 m-b-30">
                                    <!--Cell Phone Search Form-->
                                    <div id="cellsearchform">
                                        <div class="input-group">
                                            <input type="text" id="cell-search" name="cell-search" class="form-control numeric" placeholder="Cell Phone Search" onchange="newcustomerbtn_show_hide(this.value);">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn waves-effect waves-light btn-custom" id="btncell-search"><i class="fa fa-phone"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <!--End Cell Search -->
                                </div>
                                
                                <div class="col-lg-3 m-b-30">
                                    <!--Name Search Form-->
                                    <div id="namesearchform">
                                        <div class="input-group">
                                            <input type="text" id="name-search" name="name-search" class="form-control" placeholder="Name Search" onchange="newcustomerbtn_show_hide(this.value);">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn waves-effect waves-light btn-pink" id="btnname-search"><i class="fa fa-tag"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <!--End Name Search -->
                                </div>
                                <div class="col-lg-3 m-b-30">
                                    <!--Card Search Form-->
                                    <div id="cardsearchform">
                                        <div class="input-group">
                                            <input type="text" id="card-search" name="card-search" class="form-control numeric" placeholder="Card Search" onchange="newcustomerbtn_show_hide(this.value);">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn waves-effect waves-light btn-warning" id="btncard-search"><i class="fa fa-credit-card"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <!--End Card Search -->
                                </div>
                                <?php }else{ ?>
                                <div class="col-lg-3 m-b-30">
                                    <!--Name Search Form-->
                                    <div id="namesearchform">
                                        <div class="input-group">
                                            <input tabindex=0 type="text" id="name-search" name="name-search" class="form-control" placeholder="Name Search" onchange="newcustomerbtn_show_hide(this.value);">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn waves-effect waves-light btn-pink" id="btnname-search"><i class="fa fa-tag"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <!--End Name Search -->
                                </div>
                                <div class="col-lg-3 m-b-30">
                                    <!--Cell Phone Search Form-->
                                    <div id="cellsearchform">
                                        <div class="input-group">
                                            <input tabindex=1 type="text" id="cell-search" name="cell-search" class="form-control numeric" placeholder="Cell Phone Search" onchange="newcustomerbtn_show_hide(this.value);">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn waves-effect waves-light btn-custom" id="btncell-search"><i class="fa fa-phone"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <!--End Phone Search -->
                                </div>
                                <div class="col-lg-3 m-b-30">
                                    <!--Cell Phone Search Form-->
                                    <div id="cardsearchform">
                                        <div class="input-group">
                                            <input tabindex="2" type="text" id="card-search" name="card-search" class="form-control numeric" placeholder="Card Search" onchange="newcustomerbtn_show_hide(this.value);">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn waves-effect waves-light btn-warning" id="btncard-search"><i class="fa fa-credit-card"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <!--End Card Search -->
                                </div>
                                
                                <?php } ?>
                                <div class="col-lg-3 m-b-30">
                                    <span class="input-group-btn">
                                        <button onclick="clearall();" class="btn waves-effect waves-light btn-default">Clear</button>
                                        <button onclick="open_blocking_events();" style="margin-left: 20px;" class="btn waves-effect waves-light btn-success"><i class="glyphicon glyphicon-time"></i> Block Time</button>
                                    </span>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div align="center" id="newcustomeradding">
                                        <button type="submit" class="btn waves-effect waves-light btn-custom newcustomeradding"><i class="fa fa-plus"></i> Add Customer</button>
                                    </div>
                                </div>
                                <?php if(isset($scheduler_style[0]['walkin_enable'])){ 
                                    if($scheduler_style[0]['walkin_enable'] === "Y"){?>
                                <div class="col-lg-12 m-t-10">
                                    <div align="center" id="walkincustomer" >
                                        <button onclick='walkincustomer();' class="btn waves-effect waves-light btn-custom walkincustomer"><i class="fa fa-plus"></i> Walk-in Customer</button>
                                    </div>
                                </div>
                                <?php }} ?>
                            </div>     
                        </div> 
                    </div>
                </div>
                <!-- End Search Box -->

                <!-- Customer List -->
                <div id="multiplesearch" class="row" style="display:none;">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <div class="pull-right">
                                <button class="btn btn-inverse btn-xs w-md m-b-5" onclick="back('#multiplesearch', '#divsearch'); removeNiceScroll(); $('#cell-search').val(''); $('#name-search').val(''); $('#balanceid').html('');"><i class="glyphicon glyphicon-chevron-left"></i> Back</button>
                            </div>
                            <h4 class="header-title m-t-0 m-b-30">Searched Customers:</h4>
                            <div class="row">
                                <div id="customer_list" class="inbox-widget nicescroll_1" style="height: 250px; overflow: hidden; outline: none;" tabindex="5000">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 m-t-10">
                                    <div align="center" id="newcustomeraddinglist">
                                        <button type="submit" class="btn waves-effect waves-light btn-custom newcustomeradding"><i class="fa fa-plus"></i> Add Customer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Customer List -->
                
                <!-- Staff Block Time -->
                <div id="blocktime" class="row" style="display:none;">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <div class="pull-right">
                                <button onclick="back('#blocktime', '#divsearch'); $('#event-modal > div').width('90%'); $('#txt-customer-id').val(''); $('#cell-search').val(''); $('#name-search').val(''); $('#balanceid').html('');" class="btn btn-inverse btn-xs w-md m-b-5"><i class="glyphicon glyphicon-chevron-left"></i> Back</button>
                            </div>
                            <h4 class="header-title m-t-0 m-b-30"></h4>
                            <br>
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                   
                                    <div class="form-group">
                                        <label for="blocking_events" class="control-label">Block Events</label>
                                        <select id="blocking_events" class="form-control">

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="blocking_remarks" class="control-label">Remarks</label>
                                        <textarea rows="5" id="blocking_remarks" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div style="text-align: right; margin-top: 10px;">
                                        <button id="btn_block_allstaff"  type="button" onclick="saveBlockTimeAll();" class="btn btn-danger waves-effect waves-light">Block All</button>
                                        <button id="btn_block_selectedstaff" type="button" onclick="saveBlockTime();" class="btn btn-primary waves-effect waves-light">Block</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Staff Block Time -->
                
                <!-- Add/View Customer -->
                <div class="row" id="divmain" style="">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <div class="pull-right">
                                <button onclick="back('#divmain', '#divsearch'); $('#txt-customer-id').val(''); $('#cell-search').val(''); $('#name-search').val(''); $('#balanceid').html('');" class="btn btn-inverse btn-xs w-md m-b-5"><i class="glyphicon glyphicon-chevron-left"></i> Back</button>
                            </div>
                            <h4 class="header-title m-t-0 m-b-30">Customer Details:</h4>
                            <div id="customer_alert" class="row" style="display: none">
                                <div id="alert_text" class="alert alert-danger">
                                    <strong>Customer Alert!</strong>
                                </div>
                            </div>
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
                                            <label class="control-label">Name <span id="customer-color"></span></label>
                                            <input readonly="readonly" type="text" id="txt-customer-name" name="txt-customer-name" onblur="$(this).val(ucwords($(this).val()));" class="form-control" placeholder="Name">
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
                                    <div class="col-md-4">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">Profession</label>
                                            <input readonly="readonly" type="text" id="txt-customer-profession" name="txt-customer-profession"  class="form-control" placeholder="Profession">
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="div_careof" style="display:none">
                                        <div class="form-group">
                                            <label class="control-label">Care Of:</label>
                                            <input onchange="oncareofchange();"  type="hidden" id="txt-customer-co" name="txt-customer-co"  class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="div_careof_display" style="display:block">
                                        <div class="form-group">
                                            <label class="control-label">Care Of:</label>
                                            <input  type="text" id="txt-customer-display" name="txt-customer-display"  class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="txt-customer-gender" class="control-label">Gender</label>
                                            <select tabindex="2" type="text" class="form-control numeric" placeholder="Gender" id="txt-customer-gender" name="txt-customer-gender">
                                                <option value="F" selected="selected">Female</option>
                                                <option value="M">Male</option>
                                                
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="txt-customer-loyalty" class="control-label">Loyalty Points</label>
                                            <input readonly="readonly" type="text" id="txt-customer-loyalty" name="txt-customer-loyalty"  class="form-control" placeholder="0">
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
                                        <!--This anchor button function is using in (visit_js.php) file for open visit get from line number 1773-->
                                        <a href="javascript:void(0);" onclick="previousdirect();" class="btn btn-primary btn waves-effect w-md waves-success m-b-5 visit-message">Account</a>
                                        <button id="btnupdate" onclick="addeditcustomer();" type="button" class="btn btn-purple btn waves-effect waves-primary w-md m-b-5">Add New</button>
                                        <button id="schedulerFunctionBtn" type="button" onclick="" class="btn btn-warning btn waves-effect w-md waves-success m-b-5">None</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Add/View Customer -->
                
                <!-- Update Customer -->
                <div id="con-close-modal" style="display: none;">
                    <div class="col-md-12">
                        <div class="card-box">
                            <div class="pull-right">
                                <button onclick="back('#con-close-modal', '#divmain');" class="btn btn-inverse btn-xs w-md m-b-5"><i class="glyphicon glyphicon-chevron-left"></i> Back</button>
                            </div>
                            <h4 class="header-title m-t-0 m-b-30">Update Customer Details:</h4>
                                
                            <form id="updateform">

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="detail-customer-name" class="control-label">Name</label>
                                            <input type="text" class="form-control" id="detail-customer-name" name="detail-customer-name" placeholder="Name">
                                            <input type="hidden" class="form-control" id="detail-customer-id" name="detail-customer-id">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="detail-customer-cell" class="control-label">Cell Number</label>
                                            <input type="text" class="form-control" id="detail-customer-cell" name="detail-customer-cell" placeholder="Cell Phone">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="txtcustomergender" class="control-label">Gender</label>
                                            <select tabindex="2" type="text" class="form-control numeric" placeholder="Gender" id="detail-customer-gender" name="detail-customer-gender">
                                                <option value="F">Female</option>
                                                <option value="M">Male</option>                                                
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="detail-customer-card" class="control-label">Card Number</label>
                                            <input type="text" class="form-control" id="detail-customer-card" name="detail-customer-card" placeholder="Card Number (Optional)">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="detail-customer-phone1" class="control-label">Phone 1</label>
                                            <input type="text" class="form-control" id="detail-customer-phone1" name="detail-customer-phone1"  placeholder="Phone 1">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="detail-customer-phone2" class="control-label">Phone 2</label>
                                            <input type="text" class="form-control" id="detail-customer-phone2" name="detail-customer-phone2"  placeholder="Phone 2">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="detail-customer-type" class="control-label">Customer Type</label>
                                            <select type="text" class="form-control" id="detail-customer-type" name="detail-customer-type" >
                                                <option value=""></option>
                                                <option value="orange"><i style="color:orange" class="ti-star"></i> (Orange) High Priority Customer</option>
                                                <option value="green"><i class="zmdi zmdi-flag"></i> (Green) Flagged Customer</option>
                                                <option value="red"><i class="zmdi zmdi-flag"></i> (Red) Flagged Customer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="detail-customer-careof" class="control-label">Care Of (<span id="detail-careof-label"></span>)</label>
                                            <input type="text" onchange="oncareofdetailchange();" class="form-control" id="detail-customer-careof" name="detail-customer-careof"  placeholder="Care Of">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="detail-customer-profession" class="control-label">Profession</label>
                                            <input type="text" class="form-control"  id="detail-customer-profession" name="detail-customer-profession" placeholder="Profession">
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
                    <div class="clearfix"></div>
                </div>
                <!-- End Update Customer -->
                
                <!-- Services -->
                <div class="row" id="divvisit" style="display:none;">
                    <div class="col-md-12">
                        <div class="card-box">
                            <div class="pull-right">
                                <button onclick="if($('#visit-customer-id').val()=='1'){back('#divvisit', '#divsearch');}else{back('#divvisit', '#divmain');} removeNiceScroll();" class="btn btn-inverse btn-xs w-md m-b-5"><i class="glyphicon glyphicon-chevron-left"></i> Back</button>
                            </div>
                            <h4 class="header-title m-t-0 m-b-30">Enter Customer Visit Details - <label id="labelcustomer" class="text-success"></label></h4>
                             <div class="form-group m-l-10 form-inline">
                                <div class="checkbox checkbox-success inline">
                                    <input id="requested" type="checkbox">
                                    <label for="requested">
                                        Client Requested for Staff
                                    </label>
                                </div>
                                 <div class="checkbox checkbox-primary inline">
                                    <input id="promo" type="checkbox">
                                    <label for="promo">
                                        Promotion
                                    </label>
                                </div>
                                 <div class="checkbox checkbox-primary inline">
                                    <input id="stricttime" type="checkbox">
                                    <label for="stricttime">
                                        Strict Time
                                    </label>
                                </div>
                            </div>
                            <div class="row hidden">
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
                                <div class="col-md-3">
                                    <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                        <label class="control-label">New Services Types</label>
                                        <div id="visit-services-types" class="nicescroll_service_types visit-services-types services" style="height: 300px; overflow: hidden; outline: none;">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                        <label class="control-label">Services Categories</label>
                                        
                                        <div id="visit-services-categories" class="nicescroll_2 visit-services-categories services" style="height: 300px; overflow: hidden; outline: none;">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                        <label for="visit-services" class="control-label">Select Services</label>
                                        <input class="form-control m-b-10" id="searchservicedirect">
                                        <div id="visit-services" class="nicescroll_3 visit-services vservices" style="height: 300px; overflow: hidden; outline: none;">
                                            <div style="display: none;" id="fa-spinner" class="fa fa-spin fa-spinner"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                        <label for="visit-products" class="control-label">Select Products</label><button onclick="selectallproductsvisit()" class="pull-right btn btn-xs btn-primary waves-effect waves-light">All</button>
                                        <div id="visit-products" class="nicescroll_products visit-products services" style="height: 300px; overflow: hidden; outline: none;">
                                            <div style="display: none;" id="fa-spinner" class="fa fa-spin fa-spinner"></div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="visit-staff-id" id="visit-staff-id">
                                <input type="hidden" id="visit-staff" name="visit-staff">

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
                                <div class='col-md-12' >
                                    <input type="hidden" class="form-control" id="visit-id-1" name="visit-id-1">
                                    <div class="col-md-8" style="text-align:left;" >
                                        <!--Loyalty Display and Service Select -->
                                        <div style="<?php if(isset($scheduler_style[0]['s_loyalty'])){if($scheduler_style[0]['s_loyalty']=="N"){echo "display:none;";}} ?>">
                                        <div class="loyaltydisplay" id="loyaltydiv" >
                                            <div class='row'>
                                                <div class="col-md-4 col-sm-12"><h4 class='header-title text-success'><span id="lcustomer"></span>'s Loyalty Points: <span id='lpoints'></span> </h4></div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class='row'>
                                                        <div class="col-md-6 "><h4 class='header-title text-success'>Available Services:</h4></div>
                                                        <div class="col-md-6">
                                                            <select class="form-control" id='lservices'>
                                                               
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <button type="button" onclick="addloyaltyvisit();" class="btn btn-success waves-effect waves-light">Go</button>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="text-align: right">
                                         <button id="btnupdate1" onclick="addeditcustomer1();" type="button" class="btn btn-purple btn waves-effect waves-primary w-md">Update</button>
                                        <a href="javascript:void(0);" onclick="previousdirect();" class="btn btn-primary btn waves-effect w-md waves-success visit-message">Account</a>
                                        <button id="btnaddvisit" type="button" onclick="addvisit();" class="btn btn-info waves-effect waves-light">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Services -->
                
                <!-- Products -->
                <div class="row" id="retail-divorder" style="display:none;">
                    <div class="col-md-12">
                        <div class="card-box">
                            <div class="pull-right">
                                <button onclick="back('#retail-divorder', '#divmain');" class="btn btn-inverse btn-xs w-md m-b-5"><i class="glyphicon glyphicon-chevron-left"></i> Back</button>
                            </div>
                            <h4 class="header-title m-t-0 m-b-30">Create Customer Product Order - <label id="labelretailcustomer"></label></h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="order-customer-name" class="control-label">Name</label>
                                        <input readonly="readonly" type="text" class="form-control" id="order-customer-name" name="order-customer-name" placeholder="Name">
                                        <input type="hidden" class="form-control" id="order-customer-id" name="order-customer-id">

                                    </div>
                                </div>
                                <div class="col-md-4 hidden">
                                    <div class="form-group">
                                        <label for="order-customer-cell" class="control-label">Cell Number</label>
                                        <input readonly="readyonly" type="text" class="form-control" id="order-customer-cell" name="order-customer-cell" placeholder="Cell Phone">
                                    </div>
                                </div>
                                <div class="col-md-4 hidden">
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
                                        <input type="text" class='form-control' id="retail-order-products" name="order-products"  placeholder="Brand Product Category . . .">
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
                                        <input class="vertical-spin form-control numeric" type="text" id="order-customer-qty" name="order-customer-qty" value="0">
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
                                
                                <form action="<?php echo base_url();?>open_order_invoice" method="post" target="_blank">
                                    <input type="hidden" name="csrf_test_name" id="retail_modal_csrf" value=""/>
                                    <input type="hidden" class="form-control" id="order-id" name="order-id">
                                    <div class="col-md-6" style="text-align:left">
                                        <button id="btngenorderinvoice" onclick="$('#retail_modal_csrf').val($('#cook').val()); retail_updateorder();" style='display:none;' class="btn btn-pink waves-effect waves-light">Generate Invoice</button>
                                    </div>
                                </form>
                                <div class="col-md-6" style="text-align: right">
                                    <button type="button" onclick="retail_updateorder();" class="btn btn-info waves-effect waves-light">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>        
                <!-- End Products -->
                
                <!-- Gift Vouchers -->
                <div class="row" id="gift-voucher" style="display:none;">
                    <div class="col-md-12">
                        <div class="card-box">
                            <div class="pull-right">
                                <button onclick="back('#gift-voucher', '#divmain'); removeNiceScroll();" class="btn btn-inverse btn-xs w-md m-b-5"><i class="glyphicon glyphicon-chevron-left"></i> Back</button>
                            </div>
                            <h4 class="header-title m-t-0 m-b-30">Generate Customer Gift Voucher - <label id="labelvouchercustomer"></label> </h4>
                            <div class="row">
                                <div class="col-md-4 hidden">
                                    <div class="form-group">
                                        <label for="voucher-customer-name" class="control-label">Name</label>
                                        <input readonly="readonly" type="text" class="form-control" id="voucher-customer-name" name="voucher-customer-name" placeholder="Name">
                                        <input type="hidden" class="form-control" id="voucher-customer-id" name="voucher-customer-id">

                                    </div>
                                </div>
                                <div class="col-md-4 hidden">
                                    <div class="form-group">
                                        <label for="voucher-customer-cell" class="control-label">Cell Number</label>
                                        <input readonly="readyonly" type="text" class="form-control" id="voucher-customer-cell" name="voucher-customer-cell" placeholder="Cell Phone">
                                    </div>
                                </div>
                                <div class="col-md-4 hidden">
                                    <div class="form-group">
                                        <label for="voucher-customer-email" class="control-label">Email</label>
                                        <input readonly="readyonly" type="text" class="form-control" id="voucher-customer-email" name="voucher-customer-email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" for="voucher-valid-until">Valid Until</label>
                                        <input id="voucher-valid-until" name="voucher-valid-until" class="form-control" type="text" placeholder="Click here">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
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
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" for="voucher-number-optional">Voucher # <small>(optional)</small></label>
                                        <input id="voucher-number-optional" name="voucher-number-optional" class="form-control numeric" type="text" placeholder="optional">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Payment: <span id="mode">Cash</span></label>
                                        <div id="ccp" style="display:none;"><input placeholder="C-Card#" class="form-control numeric" id="ccno"  name="ccno"/></div>
                                        <div id="checkp" style="display:none;"><input placeholder="Instrument#" class="form-control numeric" id="checkno"  name="checkno"/></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row" id="voucher-price-div" style="display: none;">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Voucher Price</label>
                                                <input id="voucher-price" name="voucher-price" class="form-control numeric" type="text" placeholder="Amount">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="control-label">Printable Voucher Heading</label>
                                                <input id="voucher-heading" name="voucher-heading" class="form-control" type="text" placeholder="Use Package Name or other relevent printable info">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="voucher-services-div" style="display: none;">
                                        <div class="col-md-4">
                                            <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                                <label class="control-label">Services Types</label>
                                                <div id="voucher-services-types" class="nicescroll_vtypes voucher-services-types" style="height: 180px; overflow: hidden; outline: none;">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                                <label class="control-label">Services Categories</label>
                                                <div id="voucher-services-categories" class="nicescroll_4" style="height: 180px; overflow: hidden; outline: none;">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                                <label for="voucher-services" class="control-label">Select Services</label><button onclick="selectallservices()" class="pull-right btn btn-xs btn-primary waves-effect waves-light">All</button>
                                                <div id="voucher-services" class="nicescroll_5" style="height: 180px; overflow: hidden; outline: none;">
                                                    <div style="display: none;" id="fa-spinner" class="fa fa-spin fa-spinner"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="text-align: right">
                                    <span id="voucherNumber" style="visibility: hidden;"></span>
                                    <a href="" target="_blank" style="display: none;" id="voucherBtnPreview" class="btn btn-default waves-effect waves-light">Print Preview</a>
                                    <div class="btn-group m-r-10 dropup">
                                        <button type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Payment mode <span class="m-l-5"><i class="fa fa-money"></i></span></button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="javascript:void(0);" onclick="opencash();">Cash</a></li>
                                            <li><a href="javascript:void(0);" onclick="opencc();">Credit Card</a></li>
                                            <li><a href="javascript:void(0);" onclick="openbank('Check');">Check</a></li>
                                            <!--<li><a href="javascript:void(0);" onclick="openbalance('Balance');">Balance</a></li>-->
                                        </ul>
                                    </div>
                                    <button type="button" onclick="generateGiftVoucher();" id="voucherBtn" class="btn btn-info waves-effect waves-light">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>        
                <!-- End Gift Vouchers -->
                
            </div>
        </div>
    </div>
</div>
<script>

    function oncareofchange(){
        var data = $("#txt-customer-co").select2('data');
        
        if($("#txt-customer-cell").val()===""){
            $("#txt-customer-cell").val(data.customer_cell);
        }
    }
    
    function oncareofdetailchange(){
        var data = $("#detail-customer-careof").select2('data');
        
        if($("#detail-customer-cell").val()===""){
            $("#detail-customer-cell").val(data.customer_cell);
        }
    }
    
    function enable_careof(){
       $("#txt-customer-co").select2({
            ajax: {
              url: '<?php echo base_url();?>customer_controller/searchnameforco',
              dataType: 'json',
              delay: 250,
              data: function (term, page) {
                  
                return {
                    customername: term, // search term
                    page_limit: 30, // page size
                    page: page // page number
                };
              },
              results: function (data, page) {
                 
                    var more = (page * 30) < data.length;
                    return {results: data, more: more};
                }
              },
            escapeMarkup: function (m) { return m; }, // let our custom formatter work
            minimumInputLength: 3,
            formatResult: function (option) {
               return option.customer_name+" | "+option.customer_cell ;
            },
            formatSelection: function (option) {
                
                return option.customer_name+" | "+option.customer_cell;
            }
          });
         
    }
    
    
    function enable_detailcareof(){
       $("#detail-customer-careof").select2({
            ajax: {
              url: '<?php echo base_url();?>customer_controller/searchnameforco',
              dataType: 'json',
              delay: 250,
              data: function (term, page) {
                  
                return {
                    customername: term, // search term
                    page_limit: 30, // page size
                    page: page // page number
                };
              },
              results: function (data, page) {
                  
                    var more = (page * 30) < data.length;
                    return {results: data, more: more};
                }
              },
            escapeMarkup: function (m) { return m; }, // let our custom formatter work
            minimumInputLength: 3,
            formatResult: function (option) {
               return option.customer_name ;
            },
            formatSelection: function (option) {
                return option.customer_name;
            }
          });
         
    }
    
   
    function selectallproductsvisit(){
        
        $('input[name=id_business_products]').each(function () {
           $(this).prop( "checked", true);
        });
    }
    
    $(document).ready(function() {
        $('#event-modal').on('shown.bs.modal', function (event) {
            $('#name-search').focus();
            
        }); 
        $("#name-search").keydown(function (e) {
            if ((e.metaKey || e.ctrlKey) && ( String.fromCharCode(e.which).toLowerCase() === 'c') ) {
                $('#cell-search').focus();
            }
        });
        
    });
</script>