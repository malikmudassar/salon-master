<div class="modal fade none-border" id="eventview" tabindex="-1" role="dialog" aria-labelledby="Event View" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 98%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="$('#calendar').fullCalendar('refetchEvents'); $('#eventview').modal('hide');" aria-hidden="true">×</button>
                <h4 class="modal-title" id="eventview-heading">Visit details: <strong id="visitcustomername"></strong> <span id="visitcustomertype"></span> <span id="customerbalanceid"></span></h4><br>
                <h4 id="visitcustomercell"></h4>
                <span>visit #:</span><span name="modal_visit_id" id="modal_visit_id"></span>
            </div>
            <div class="modal-body">
                
                <div id="customer_alert_exist" class="row" style="display: none;">
                    <div id="alert_text_exist" class="alert alert-danger">
                        <strong>Customer Alert!</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3" id="reminder_alert">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Reminders Sent:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <span class="checkbox checkbox-pink checkbox-inline">
                                    <input type="checkbox" name="reminder_stricttime" id="reminder_stricttime" value="" onclick="reminder_message('reminder_stricttime');" /> 
                                    <label for="reminder_stricttime" class="">
                                        StrictTime
                                    </label>
                                </span>
                                <span class="checkbox checkbox-pink checkbox-inline">
                                    <input type="checkbox" name="reminder_requested" id="reminder_requested" value="" onclick="reminder_message('reminder_requested');" /> 
                                    <label for="reminder_requested" class="">
                                        Requested
                                    </label>
                                </span>
                                <span class="checkbox checkbox-pink checkbox-inline">
                                    <input type="checkbox" name="reminder_sms" id="reminder_sms" value="" onclick="reminder_message('reminder_sms');" /> 
                                    <label for="reminder_sms" class="">
                                        SMS
                                    </label>
                                </span>
                                 <span class="checkbox checkbox-pink checkbox-inline">
                                    <input type="checkbox" name="reminder_call" id="reminder_call" value="" onclick="reminder_message('reminder_call');" />                                    
                                    <label for="reminder_call">
                                        CALL
                                    </label>
                                </span>
                                 <span class="checkbox checkbox-pink checkbox-inline">
                                    <input type="checkbox" name="reminder_email" id="reminder_email" value="" onclick="reminder_message('reminder_email');" /> 
                                    <label for="reminder_email">
                                        EMAIL
                                    </label>
                                </span>
                                <span class="checkbox checkbox-pink checkbox-inline">
                                    <input type="checkbox" name="reminder_promo" id="reminder_promo" value="" onclick="reminder_message('reminder_promo');" /> 
                                    <label for="reminder_promo" class="">
                                        PROMO
                                    </label>
                                </span>
                                <input type="hidden" name="customer_visit_id_reminder" id="customer_visit_id_reminder" />
                                <input type="hidden" name="id_visit_service_reminder" id="id_visit_service_reminder" />
                                <input type="hidden" name="id_visit_service_staff_reminder" id="id_visit_service_staff_reminder" />
                            </div>
                        </div>
                        <div class="row m-t-20">
                             <div class="col-md-6 ">
                                <div data-color-format="rgb" data-color="rgb(255, 146, 180)" class="colorpicker-default input-group ">
                                    <input id="visit_color_picker" type="text" readonly="readonly" value="" class="form-control">
                                    <span class="input-group-btn add-on">
                                        <button class="btn btn-white" type="button">
                                            <i style="background-color: rgb(124, 66, 84);margin-top: 2px;"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <a href="javascript:void(0);" onclick="changecolor();" class="btn btn-custom waves-effect waves-light ">Change</a>
                            </div>
                        </div>
                         <div class="row m-t-20">
                             <div class="col-md-12 ">
                                 <label for="txtvisitremarks">Remarks:</label>
                                 <textarea row="5" class="form-control" id="txtvisitremarks" name="txtvisitremarks"></textarea>
                             </div>
                             
                         </div>
                        <div class="row m-t-5">
                            <div class="col-md-6 "></div>
                            <div class="col-md-6" style="text-align: right">
                                <button onclick="add_remarks();" class="btn btn-sm btn-custom waves-effect waves-light pull-right">Add Remark</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" id="visit_block_btns" >
                        <div class="row m-t-8">
                            <div class='m-t-10'> <!--date change-->
                                <div class='row'>
                                    <form method="POST" action="<?php echo base_url('scheduler_controller/change_date');?>" id="dateChangeForm">
                                        <input type="hidden" name="csrf_test_name" id="cd_csrf" value=""/>
                                        <input type="hidden" name="cd_visit_service_id" id="cd_visit_service_id">
                                        <input type="hidden" name="cd_visit_id" id="cd_visit_id">
                                        <input type="hidden" name="cd_type" id="cd_type">
                                        <input name="cd_calenderDate" type="hidden" class="calenderDate">
                                        <div class='col-md-3' style="text-align: right">
                                            <input id='change_date' name="new_date" class='form-control' required="required"/>
                                        </div>
                                        <div class='col-md-3' style="text-align: left">    
                                            <button type="submit" onclick="$('#cd_csrf').val($('#cook').val()); $('#cd_type').val('visit'); $('.calenderDate').val($('#calendar').fullCalendar('getDate'));" class='btn btn-purple waves-effects waves-purple'>Move Visit</button>
                                            <button type="submit" onclick="$('#cd_csrf').val($('#cook').val()); $('#cd_type').val('service'); $('.calenderDate').val($('#calendar').fullCalendar('getDate'));" class='btn btn-purple waves-effects waves-purple'>Service</button>
                                        </div>
                                    </form>
                                    <form method="POST" action="<?php echo base_url('scheduler_controller/change_staff');?>" id="staffChangeForm">
                                        <input type="hidden" name="csrf_test_name" id="cs_csrf" value=""/>
                                        <input type="hidden" name="cs_visit_service_staff_id" id="cs_visit_service_staff_id" >
                                        <input name="cs_calenderDate" type="hidden" class="calenderDate">
                                        <div class='col-md-3' style="text-align: right">
                                            <select id='change_staff' name="new_staff" class='form-control' required="required" /></select>
                                        </div>
                                        <div class='col-md-3' style="text-align: left">
                                            <button type="submit" onclick="$('#cs_csrf').val($('#cook').val()); $('.calenderDate').val($('#calendar').fullCalendar('getDate'));" class='btn btn-purple waves-effects waves-purple'>Switch Staff</button>
                                        </div>
                                    </form>
                                </div>
                                
                                
                            </div>
                            <hr>
                                <form action="<?php echo base_url('open_new_invoice'); ?>" id="invoiceForm" method="post" target="_blank">
                                    <input type="hidden" id="visit-id" name="visit-id"/>
                                    <input type="hidden" name="csrf_test_name" id="event_view_csrf" value=""/>
                                    <div>    
                                        <button type="button" onclick="$('#visit_block_btns').hide(); $('#advance_block').hide(); $('#reminder_alert').hide(); $('#visit_block1').fadeIn();" class="btn btn-success" id="btnaddmoreservices"><i class="ti-shopping-cart-full"></i> Add More Services</button>
                                        <button type="button" onclick="$('#visit_block_btns').hide(); $('#advance_block').hide(); $('#reminder_alert').hide(); $('#visit_block2').fadeIn();" class="btn btn-custom" id="btnaddadditionalstaff"><i class="ti-user"></i> Add Additional Staff</button>
                                        <button type="button" onclick="$('#event_view_csrf').val($('#cook').val()); generateInvoice(); " style="" class="btn btn-pink waves-effect waves-light" id="btngenerateinvoice"><i class="ti-money"></i>Generate Invoice</button>
                                    </div> 
                                    <div class="m-t-10">
                                        <button type="button" class="btn btn-danger btn-trans waves-effect" visit_service_id="" visit_service_name="" id="btncancelservice"><i class="ti-share-alt"></i> Remove this Service</button>
                                        <button type="button" class="btn btn-pink btn-trans waves-effect" onclick="cancelVisitKeepAdv();" id="btncancelvisitkeepadv"><i class="ti-close"></i> Cancel Visit (keep advance)</button>
                                        <button type="button" class="btn btn-danger waves-effect" onclick="cancelVisit();" id="btncancelvisit"><i class="ti-close"></i> Cancel Visit</button>
                                    </div>
                                    <div class="m-t-10">
                                        <a href="javascript:void(0);" onclick="openAccount();" class="btn btn-primary waves-effect waves-light">Customer Account</a>
                                    </div>
                                   
                                </form>    
                            <?php if($scheduler_style[0]['loyalty_enable']=='Y'){?>
                                <div class="m-t-10">
                                    <form method="post" target="_blank" action="<?php echo base_url('open_sms_sender'); ?>">
                                        <input type="hidden" name="csrf_test_name" class="reminder_csrf" value=""/>
                                        <input type="hidden" name="visit_id" id="sms_visit_id" value="">
                                        <input type="hidden" name="staff_name" id="sms_staff_name" value="">
                                        <input type="hidden" name="visit_service_start" id="sms_visit_service_start" value="">
                                        <input type="hidden" name="service_category" id="sms_service_category" value="">
                                        <input type="hidden" name="service_name" id="sms_service_name" value="">
                                        <input type="hidden" name="customer_name" id="sms_customer_name" value="'">
                                        <input type="hidden" name="customer_cell" id="sms_customer_cell" value="">                                    
                                        <button type="submit" onclick="$('.reminder_csrf').val($('#cook').val()); window.reload;" class="btn btn-icon waves-effect waves-light btn-warning m-b-5"><i class="ti-comment"></i> SMS</button>
                                    </form>
                                    
                                </div>
                            <?php } ?>
                                
                            <div class="m-t-10">
                                <a href="javascript:void(0);" onclick="mark_inservice();" class="btn btn-icon btn-info waves-effect waves-light btn-trans m-b-5"><i class="ti-check-box"></i> Mark as "In-Service"</a>
                            </div>
                            
                            
                        </div>
                    </div>
                    <div class="col-md-3" id="advance_block">
                        <div>
                            <table id="adv_table" class="table table-stripped">
                                <tbody>
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                        <div>
                            Enter Advance Comment:
                        </div>
                        <div class="input-group">
                            <input class="form-control" name="advance_comment" id="advance_comment"  />
                        </div>
                        <div>
                            Enter Advance Amount:
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">Rs. </span>
                            <input class="form-control numeric" name="advance_amount" id="advance_amount" style="text-align: right;" />
                        </div>
                        <div id="advance_inst_div" style="display:none;" class="input-group">
                             <span class="input-group-addon">CC#.</span>
                            <input class="form-control numeric" name="advance_inst" id="advance_inst" style="text-align: right; " />
                        </div>
                        <div class="form-group">
                            <select class="form-control" onchange="showhideinst();" id="advance_mode" name = "advance_mode">
                                <option value="cash">Cash</option>
                                <option value="card">Credit Card</option>
                                <option value="card">Debit Card</option>
                                <option value="check">Bank</option>
                            </select>
                        </div>
                        <button type="button" onclick="printadvance();"  class="btn btn-default waves-effect waves-light pull-right m-l-5"><i class="fa fa-print"></i></button>
                        <button type="button" onclick="saveadvance();"  class="btn btn-custom waves-effect waves-light pull-right">Save</button>

                    </div>
                </div>
                <div id="visit_block1" style="display: none;">
                    <button type="button" onclick="$('#visit_block1').hide(); $('#visit_block_btns').fadeIn(); $('#advance_block').fadeIn(); $('#reminder_alert').fadeIn();" class="btn btn-inverse btn-xs pull-right"><i class="glyphicon glyphicon-chevron-left"></i> Back</button><br>
                    <p id="alreadyvisitid" class="text-info" align="center">
                        An un-invoiced visit already exists for this customer! Visit ID: <strong></strong>
                    </p>

                    <div class="row hidden">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="visit-customername" class="control-label">Name</label>
                                <input readonly="readonly" type="text" class="form-control" id="visit-customername" name="visit-customername" placeholder="Name">
                                <input type="hidden" class="form-control" id="visit-customerid" name="visit-customerid">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="visit-customercell" class="control-label">Cell Number</label>
                                <input readonly="readyonly" type="text" class="form-control" id="visit-customercell" name="visit-customercell" placeholder="Cell Phone">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="visit-customeremail" class="control-label">Email</label>
                                <input readonly="readyonly" type="text" class="form-control" id="visit-customeremail" name="visit-customeremail" placeholder="Email">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <input type="hidden">
                        <div class="col-md-3">
                            <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                <label class="control-label">Services Types</label>
                                <div id="visit-services-types1" class="nicescroll_service_types2 visit-services-types services" style="height: 200px; overflow: hidden; outline: none;">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                <label class="control-label">Services Categories</label>
                                <div id="visit-services-categories1" class="nicescroll2 visit-services-categories services" style="height: 200px; overflow: hidden; outline: none;">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                <label for="visit_services" class="control-label">Select Services</label><button style="display:none" onclick="selectallservicesevent()" class="pull-right btn btn-xs btn-primary waves-effect waves-light">All</button>
                                <input class="form-control m-b-10" id="searchservicedirect1">
                                <div id="visit_services" name="visit_services" class="nicescroll3 visit-services vservices" style="height: 200px; overflow: hidden; outline: none;">
                                    <div style="display: none;" id="fa-spinner" class="fa fa-spin fa-spinner"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;"><button onclick="selectallproductsevent()" class="pull-right btn btn-xs btn-primary waves-effect waves-light">All</button>
                                <label for="visit_products" class="control-label">Select Products</label>
                                <div id="visit_products" name="visit_products"  class="nicescrollproducts visit-products services" style="height: 200px; overflow: hidden; outline: none;">
                                    <div style="display: none;" id="fa-spinner" class="fa fa-spin fa-spinner"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row" style="">
                                <div class="col-md-8">

                                </div>
                                <div class="col-md-4" align="right">
                                    <button type="button" onclick="generateInvoice();" style="" class="btn btn-pink waves-effect waves-light">Generate Invoice</button>
                                    <button type="button" onclick="updatevisit();" class="btn btn-info waves-effect waves-light">Save Changes</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="visit_block2" style="display: none;">
                    <button type="button" onclick="$('#visit_block2').hide(); $('#visit_block_btns').fadeIn(); $('#advance_block').fadeIn(); $('#reminder_alert').fadeIn();" class="btn btn-inverse btn-xs pull-right"><i class="glyphicon glyphicon-chevron-left"></i> Back</button><br>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-6">
                            <input type="hidden" id="staff_visit_service_id">
                            <select id="additional_staff" name="additional_staff" multiple>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" onclick="addAdditionalStaff();" class="btn btn-info">Add</button>
                        </div>
                        <div class="col-md-2"></div>
                    </div><br>
                </div>
                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script>
    
    
    ///Owais testing select all option in Events m0dal
    function selectallservicesevent(){
        
        $('input[name=idbusiness_services]').each(function () {
            $(this).prop( "checked", true);
        });
    }
    function selectallproductsevent(){
        
        $('input[name=idbusiness_products]').each(function () {
           $(this).prop( "checked", true);
        });
    }
    
    
</script>