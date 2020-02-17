<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            
            <h4 class="page-title">SMS Shooter </h4>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <form method="Post" action="<?php echo base_url('sms_controller/send_sms');?>">
                    <input type="hidden" name="csrf_test_name" id="sms_csrf" value=""/>
                    <div class="panel-body">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Customer Name</label>
                                    <div class="col-md-10">
                                        <input readonly="readonly" type="text" class="form-control" id="customername" name="customername" value="<?php if(isset($customer_name)){ echo $customer_name;}else {echo 'not set';} ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-5">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Customer Cell</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="customercell" name="customercell" value="<?php echo $customer_cell; ?>">
                                        <input type="hidden" name="debug" value="true">
                                        <input type="hidden" name="visit_id" value="<?php echo $visit_id;?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-5">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">SMS Text:</label>
                                    <textarea rows="5" id="msg" name="msg" class="form-control">Dear <?php echo $customer_name;?>,
This is a reminder for your <?php echo $service_category;?> appointment on the <?php echo $visit_day; ?> of <?php echo $visit_month; ?> at <?php echo strtolower($visit_time); ?> sharp.
Please do not reply to this text. To reschedule, call us on <?php echo $business[0]['business_phone1'];?>.
Regards,
<?php echo $business[0]['business_name'];?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="panel-footer text-right">
                        <button type="submit" onclick="$('#sms_csrf').val($('#cook').val());" class="btn btn-info waves-effect waves-light ">Send SMS</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
