<style>
    .mouse-cursor{

    }
</style>  
<div class="wrapper">
    <div class="container" style="width: 100% !important">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="clearfix">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <?php $flag=""; 
                                            if($customer[0]['customer_type']==='red'){$flag="zmdi zmdi-flag txt-danger";} 
                                            if($customer[0]['customer_type']==='orange'){$flag="ti-star txt";} 
                                            if($customer[0]['customer_type']==='green'){$flag="zmdi zmdi-flag txt-success";} 
                                            ?>
                                            
                                            <h3 class="page-title">Customer : <?php echo isset($customer[0]['customer_name']) ? $customer[0]['customer_name'] : ""; ?><span id="customer_color"> <i style="color:<?php echo $customer[0]['customer_type'];?>" class="<?php echo $flag;?>"></i></span></h3>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <address>
                                                        <?php echo isset($customer[0]['customer_careof']) ? "<strong>Care Of</strong> ". $customer[0]['customer_careof']."<br>" : ""; ?>
                                                        <strong>Birthday</strong>
                                                        <?php echo isset($customer[0]['customer_birthday']) ? $customer[0]['customer_birthday'] : ""; ?>
                                                        <?php echo isset($customer[0]['customer_birthmonth']) ? $customer[0]['customer_birthmonth'] : ""; ?><br>
                                                        <strong>Anniversary</strong>
                                                        <?php echo isset($customer[0]['customer_anniversary']) ? $customer[0]['customer_anniversary'] : ""; ?><br>
                                                        <?php echo isset($customer[0]['customer_address']) ? $customer[0]['customer_address'] : ""; ?><br>
                                                        <abbr title="Phone">Cell     : </abbr> <?php echo isset($customer[0]['customer_cell']) ? $customer[0]['customer_cell'] : ""; ?></br>
                                                        <?php echo isset($customer[0]['customer_card']) ? "<abbr title='Customer Loyalty Cards'>Card/s:</abbr> ".$customer[0]['customer_card'] : ""; ?><br>
                                                         
                                                    </address>

                                                    <address>
                                                        <strong>Email</strong><br>
                                                        <a href="mailto:#"><?php echo isset($customer[0]['customer_email']) ? $customer[0]['customer_email'] : ""; ?></a>
                                                    </address>

                                                    <address>
                                                        <button id='btnedit' onclick="openupdate();" class="btn btn-icon waves-effect waves-light btn-info m-b-5 btn-sm"> <i class="fa fa-pencil"></i> Edit </button>
                                                    </address>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                   
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h3 class="page-title text-danger">Customer has balance of : 
                                                <?php if (isset($customerbalance)) { foreach($customerbalance as $cb){ ?>
                                                    <?php if ($cb['invoice_type'] == "service") { ?>
                                                        <a class="btn btn-danger m-l-5 waves-effect waves-light m-b-5 btn-sm" target="_blank" href="<?php echo base_url('open_recovery_invoice'); ?>/<?php echo $cb['id_invoice']; ?>/<?php echo $cb['visit_id']; ?>">Rs. <?php echo $cb['totalbalance'];?></a>
                                                    <?php } else if ($customerbalance[0]['invoice_type'] == "sale") { ?>
                                                        <a class="btn btn-danger waves-effect waves-light m-l-5 m-b-5 btn-sm" target="_blank" href="<?php echo base_url('open_recovery_order_invoice'); ?>/<?php echo $cb['id_invoice']; ?>/<?php echo $cb['visit_id']; ?>">Rs. <?php echo $cb['totalbalance'];?></a>
                                                    <?php } ?>
                                                <?php } } else { echo '0'; }   ?>
                                                </h3>
                                            </div>
                                        </div>
                                    

                                    <?php if ($business[0]['loyalty_enable'] === "Y") { ?>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h4 class="text-success">Total Loyalty Points : <?php if(isset($customer_loyalty) && sizeof($customer_loyalty)>0){ echo $customer_loyalty[0]['loyalty_points']; } else { echo 0;}?> </h4>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    
                                     
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h4 class="text-custom">Total Retained Amount : <?php if(isset($customer_loyalty) && sizeof($customer_loyalty)>0){ echo $customer_loyalty[0]['retained']; } else { echo 0;}?> </h4>
                                        </div>
                                    </div>
                                    

                                   
                                 </div>
                                    
                            

                        <!-- end row -->


                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="page-title">Previous Visits</h3>
                                           
                                <div class="">
                                    <?php if($novisits==='false'){?>
                                    <table class="table table-responsive m-t-10 table-bordered" id="tblservices">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Visit Date</th>
                                                <th>Days Ago</th>
                                                <th>Branch</th>
                                                <th>Staff Services</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                                <?php $count = 1; $idvisit=0; foreach ($visits as $visit) { ?>
                                                <?php if($idvisit!==$visit['id_customer_visits']){ $idvisit = $visit['id_customer_visits'];?>
                                                    <tr>
                                                        <td><?php echo $count++; ?></td>
                                                        <td><?php echo $visit['customer_visit_date']; ?></td>
                                                        <td><label class="label label-primary"><?php echo $visit['daysago']; ?></label></td>
                                                        <td><?php echo $visit['business_name']; ?></label></td>
                                                        <td>
                                                            <ul style="padding-left: 15px;">
                                                                <?php
                                                                if (isset($staff)) {
                                                                    foreach ($staff as $s) {
                                                                        if ($visit['id_customer_visits'] == $s['visit_id']) {
                                                                            ?>

                                                                            <li>
                                                                                <?php
                                                                                echo $s['service_type'] ." " .$s['service_category'] ." " . $s['service_name'] . " <span class='text-success'>" . $s['staff_fullname'] . "</span>";
                                                                                ?>

                                                                            </li>

                                                                        <?php } ?>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </ul>
                                                        </td>
        <!--                                                <td>
                                                            <ul style="padding-left: 15px;">
                                                        <?php
                                                        if (isset($visit_services)) {
                                                            foreach ($visit_services as $visit_service) {
                                                                if ($visit['id_customer_visits'] == $visit_service['customer_visit_id']) {
                                                                    ?>

                                                                                                                                                                                                    <li><?php echo $visit_service['service_name']; ?></li>

                                                                <?php } ?>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                            </ul>
                                                        </td>-->
        <!--                                                <td>
                                                            <ul style="padding-left: 15px;">
                                                        <?php
                                                        if (isset($product)) {
                                                            foreach ($product as $p) {
                                                                if ($visit['id_customer_visits'] == $p['customer_visit_id']) {
                                                                    ?>

                                                                                                                                                                                                    <li><?php echo $p['product_name']; ?></li>

                                                                <?php } ?>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                            </ul>
                                                        </td>-->
                                                    </tr>
                                                    <?php
                                                }}
                                             ?>
                                        </tbody>
                                    </table>
                                    
                                    <?php } else {?>
                                    <div style="text-align: center; ">
                                        <form method="post" action="<?php echo base_url();?>customer_controller/customer_previous_visit/<?php echo $customer[0]['id_customers'];?>/Yes/<?php echo $getinvoices;?>">
                                            <input name="csrf_test_name" id="csrf_visits" type="hidden">
                                            <h4 class="text-pink">There are <?php echo $novisits;?></h4>
                                            <button type="submit" onclick="$('#csrf_visits').val($('#cook').val());" class="btn btn-default">Show All</button>
                                        </form>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                 <h3 class="page-title">Previous Invoice</h3>
                                           
                                <div class="table-responsive">
                                    <?php if($noinvoices==='false'){?>
                                    <table class="table  m-t-10 table-bordered" id="tblinvoices">
                                        <thead>
                                            <tr>
                                                <th>Invoice#</th>
                                                <th>Visit Date</th>
                                                <th>Invoice Date</th>
                                                <th>Branch</th>
                                                <th>Type</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(isset($invoices)){
                                                foreach ($invoices as $invoice) {
                                                    ?>
                                                    <tr> 
                                                        <td><?php echo $invoice['invoice_number']; ?></td>
                                                        <td><?php echo $invoice['visit_date']; ?></td>
                                                        <td><label class="label label-pink"><?php echo $invoice['invoice_date']; ?></label></td>

                                                        <td><label class="label label-purple"><?php echo $invoice['payment_mode']; ?></label></td>
                                                        <td><?php echo $invoice['invoice_type']; ?></td>
                                                        <td><?php echo $invoice['sub_total']; ?></td>
                                                        <td><a target="_blank" href="<?php
                                                            if ($invoice['invoice_type'] == "service") {
                                                                echo base_url() . 'existinginvoice/' . $invoice['id_invoice'];
                                                            } elseif ($invoice['invoice_type'] == "sale") {
                                                                echo base_url() . 'existingorderinvoice/' . $invoice['id_invoice'];
                                                            }
                                                            ?>" class="btn btn-warning waves-effect waves-light"> <i class="fa fa-rocket m-r-5"></i> </a></td>
                                                    </tr>
                                                    <?php
                                                    }}
                                             ?>
                                        </tbody>
                                    </table>
                                    <?php } else {?>
                                    <div style="text-align: center; ">
                                        <form method="post" action="<?php echo base_url();?>customer_controller/customer_previous_visit/<?php echo $customer[0]['id_customers'];?>/<?php echo $getvisits;?>/Yes">
                                            <input name="csrf_test_name" id="csrf_invoices" type="hidden">
                                            <h4 class="text-pink">There are <?php echo $noinvoices;?></h4>
                                            <button type="submit" onclick="$('#csrf_invoices').val($('#cook').val());" class="btn btn-default">Show All</button>
                                        </form>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <h3 class="page-title">Colors Record</h3>
                                <hr>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-12 col-lg-12">
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th >ID</th>
                                                <th>Type</th>
                                                <th>Color</th>
                                                <th>Water Content</th>
                                                <th>Date</th>
                                                <th>Time (minutes)</th>
                                                <th>Days Ago</th>
                                                <?php if( $this->session->userdata('role')!=='Sh-Users'){?>
                                                <th>Charge</th>
                                                <?php } ?>
                                                <th>Remarks</th>
                                                <th>Recommendation</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            if (isset($color_records)) {
                                                foreach ($color_records as $records) {
                                                    if ($records['customer_id'] == $customer[0]['id_customers']) {
                                                        ?>
                                                        <tr>
                                                            <td ><?php echo $records['id']; ?></td>
                                                            <td><?php echo $records['color_type']; ?></td>
                                                            <td><?php echo $records['color_number']; ?></td>
                                                            <td><?php echo $records['water_content']; ?></td>
                                                            <td><?php echo $records['date']; ?></td>
                                                            <td><?php echo $records['time']; ?></td>
                                                            <td><span class="label label-primary"><?php echo $records['daysago']; ?></span></td>
                                                            <?php if( $this->session->userdata('role')!=='Sh-Users'){?>
                                                            <td><?php echo $records['charge']; ?></td>
                                                            <?php } ?>
                                                            <td><?php echo $records['remarks']; ?></td>
                                                            <td><?php echo $records['recommendation']; ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <h3 class="page-title">Facials</h3>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-12 col-lg-12">
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th >ID</th>
                                                <th>Facial Name</th>
                                                <th>Exfoliant</th>
                                                <th>Mask</th>
                                                <th>Cleanser</th>
                                                <th>Date</th>
                                                <th>Time (minutes)</th>
                                                <th>Days Ago</th>
                                                <?php if( $this->session->userdata('role')!=='Sh-Users'){?>
                                                <th>Charge</th>
                                                <?php } ?>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            if (isset($facial_records)) {
                                                foreach ($facial_records as $records) {
                                                    if ($records['customer_id'] == $customer[0]['id_customers']) {
                                                        ?>
                                                        <tr>
                                                            <td ><?php echo $records['id']; ?></td>
                                                            <td><?php echo $records['facial']; ?></td>
                                                            <td><?php echo $records['exfoliant']; ?></td>
                                                            <td><?php echo $records['mask']; ?></td>
                                                            <td><?php echo $records['cleanser']; ?></td>
                                                            <td><span class="label label-success"><?php echo $records['date']; ?></span></td>
                                                            <td><span class="label label-warning"><?php echo $records['time']; ?></span></td>
                                                            <td><span class="label label-primary"><?php echo $records['daysago']; ?></span></td>
                                                            <?php if( $this->session->userdata('role')!=='Sh-Users'){?>
                                                            <td><?php echo $records['charge']; ?></td>
                                                            <?php } ?>
                                                            <td><?php echo $records['remarks']; ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <h3 class="page-title">Eyelashes</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class=" table-responsive">


                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th >ID</th>
                                                <th>Customer</th>
                                                <th>Type</th>
                                                <th>Thickness</th>
                                                <th>Length</th>
                                                <th>Curl</th>
                                                <th>Full Set Refill</th>
                                                <th>Date</th>
                                                <th>Days Ago</th>
                                                <?php if( $this->session->userdata('role')!=='Sh-Users'){?>
                                                <th>Price</th>
                                                <?php } ?>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            if (isset($eyelashes)) {
                                                foreach ($eyelashes as $records) {
                                                    if ($records['customer_id'] == $customer[0]['id_customers']) {
                                                        ?>
                                                        <tr>
                                                            <td ><?php echo $records['id_eyelashes']; ?></td>
                                                            <td><?php echo $records['customer_name']; ?></td>
                                                            <td><?php echo $records['eyelash_type']; ?></td>
                                                            <td><?php echo $records['thickness']; ?></td>
                                                            <td><?php echo $records['length']; ?></td>
                                                            <td><?php echo $records['curl']; ?></td>
                                                            <td><?php echo $records['full_set_refill']; ?></td>
                                                            <td><span class="label label-pink"><?php echo $records['date']; ?></span></td>
                                                            <td><span class="label label-primary"><?php echo $records['daysago']; ?></span></td>
                                                            <?php if( $this->session->userdata('role')!=='Sh-Users'){?>
                                                            <td><?php echo $records['price']; ?></td>
                                                            <?php } ?>
                                                            <td><?php echo $records['remarks']; ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- end col -->
                        </div>

                        <hr>
                        <div class="hidden-print">
                            <div class="pull-right">
                                <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light" id="btnprint" style="display: none;"><i class="fa fa-print"></i></a>
                                <a href="javascript:void(0);" onclick="window.close();" class="btn btn-danger waves-effect waves-light" id="btnsubmit">Close</a>
                            </div>
                        </div>
                        </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- Update Customer -->
        <div class="modal fade none-border" id="editcustomer" tabindex="-1" role="dialog" aria-labelledby="Customers" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%;">
                <div class="modal-content" style="padding-bottom: 0px;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><strong id="modal-header-title"></strong> <span id="balanceid"></span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                                <div class="card-box">
                                    <div class="pull-right">
                                        <button class="btn btn-inverse btn-xs w-md m-b-5"><i class="glyphicon glyphicon-chevron-left"></i> Back</button>
                                    </div>
                                    <h4 class="header-title m-t-0 m-b-30">Update Customer Details:</h4>

                                    <form id="updateform">

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="detail-customer-name" class="control-label">Name</label>
                                                    <input type="text" class="form-control" id="detail-customer-name" name="detail-customer-name" placeholder="Name" value="<?php echo $customer[0]['customer_name'];?>">
                                                    <input type="hidden" class="form-control" id="detail-customer-id" name="detail-customer-id" value="<?php echo $customer[0]['id_customers'];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="detail-customer-cell" class="control-label">Cell Number</label>
                                                    <input type="text" class="form-control" id="detail-customer-cell" name="detail-customer-cell" placeholder="Cell Phone" value="<?php echo $customer[0]['customer_cell'];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="txtcustomergender" class="control-label">Gender</label>
                                                    <select tabindex="2" type="text" class="form-control numeric" placeholder="Gender" id="detail-customer-gender" name="detail-customer-gender" >
                                                        <option value="F" <?php if($customer[0]['customer_gender']=="F"){echo "selected='selected'";}?> >Female</option>
                                                        <option value="M" <?php if($customer[0]['customer_gender']=="M"){echo "selected='selected'";}?>>Male</option>                                                
                                                    </select>
                                                </div> 
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="detail-customer-card" class="control-label">Card Number</label>
                                                    <input type="text" class="form-control" id="detail-customer-card" name="detail-customer-card" placeholder="Card Number (Optional)" value="<?php echo $customer[0]['customer_card'];?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="detail-customer-phone1" class="control-label">Phone 1</label>
                                                    <input type="text" class="form-control" id="detail-customer-phone1" name="detail-customer-phone1"  placeholder="Phone 1" value="<?php echo $customer[0]['customer_phone1'];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="detail-customer-phone2" class="control-label">Phone 2</label>
                                                    <input type="text" class="form-control" id="detail-customer-phone2" name="detail-customer-phone2"  placeholder="Phone 2" value="<?php echo $customer[0]['customer_phone2'];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="detail-customer-type" class="control-label">Customer Type</label>
                                                    <select type="text" class="form-control" id="detail-customer-type" name="detail-customer-type" >
                                                        <option value=""></option>
                                                        <option value="orange" <?php if($customer[0]['customer_type']=="orange"){echo "selected='selected'";}?>><i style="color:orange" class="ti-star"></i> (Orange) High Priority Customer</option>
                                                        <option value="green" <?php if($customer[0]['customer_type']=="green"){echo "selected='selected'";}?>><i class="ti-face-smile"></i> (Green) Flagged Customer</option>
                                                        <option value="red" <?php if($customer[0]['customer_type']=="red"){echo "selected='selected'";}?>><i class="ti-hand-stop"></i> (Red) Flagged Customer</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="detail-customer-careof" class="control-label">Care Of (<span id="detail-careof-label"></span>)</label>
                                                    <input type="text" onchange="oncareofdetailchange();" class="form-control" id="detail-customer-careof" name="detail-customer-careof"  placeholder="Care Of" value="<?php echo $customer[0]['customer_careof'];?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="detail-customer-profession" class="control-label">Profession</label>
                                                    <input type="text" class="form-control"  id="detail-customer-profession" name="detail-customer-profession" placeholder="Profession"  value="<?php echo $customer[0]['profession'];?>">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="detail-customer-email" class="control-label">Email</label>
                                                    <input type="email" class="form-control email"  id="detail-customer-email" name="detail-customer-email" placeholder="Email" value="<?php echo $customer[0]['customer_email'];?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="detail-customer-address" class="control-label">Address</label>
                                                    <input type="text" class="form-control" id="detail-customer-address" name="detail-customer-address" placeholder="Address" value="<?php echo $customer[0]['customer_address'];?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row m-b-5">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="" class="control-label">Wedding Anniversary</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="yyyy/mm/dd" id="detail-customer-wedding" name="detail-customer-wedding" value="<?php echo $customer[0]['customer_anniversary'];?>">
                                                        <span class="input-group-addon bg-info b-0 text-white"><i class="ti-calendar"></i></span>
                                                    </div><!-- input-group -->
                                                </div>                                
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="detail-customer-bday" class="control-label">Birthday</label>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <select id="detail-customer-bday" name="detail-customer-bday" class="form-control" >
                                                                <?php for($x = 1; $x <= 31; $x++){ ?>
                                                                <option <?php if($x == $customer[0]['customer_birthday']){ echo 'selected="selected"';} ?> value="<?php echo $x;?>"><?php echo $x;?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select id="detail-customer-bmonth" name="detail-customer-bmonth" class="form-control">
                                                                <option value=""></option>
                                                                <option value="January" <?php if($customer[0]['customer_birthmonth']=="January"){echo "selected='selected'";} ?>>January</option>
                                                                <option value="February" <?php if($customer[0]['customer_birthmonth']=="February"){echo "selected='selected'";} ?>>February</option>
                                                                <option value="March" <?php if($customer[0]['customer_birthmonth']=="March"){echo "selected='selected'";} ?>>March</option>
                                                                <option value="April" <?php if($customer[0]['customer_birthmonth']=="April"){echo "selected='selected'";} ?>>April</option>
                                                                <option value="May" <?php if($customer[0]['customer_birthmonth']=="May"){echo "selected='selected'";} ?>>May</option>
                                                                <option value="June" <?php if($customer[0]['customer_birthmonth']=="June"){echo "selected='selected'";} ?>>June</option>
                                                                <option value="July" <?php if($customer[0]['customer_birthmonth']=="July"){echo "selected='selected'";} ?>>July</option>
                                                                <option value="August" <?php if($customer[0]['customer_birthmonth']=="August"){echo "selected='selected'";} ?>>August</option>
                                                                <option value="September" <?php if($customer[0]['customer_birthmonth']=="September"){echo "selected='selected'";} ?>>September</option>
                                                                <option value="October" <?php if($customer[0]['customer_birthmonth']=="October"){echo "selected='selected'";} ?>>October</option>
                                                                <option value="November" <?php if($customer[0]['customer_birthmonth']=="November"){echo "selected='selected'";} ?>>November</option>
                                                                <option value="December" <?php if($customer[0]['customer_birthmonth']=="December"){echo "selected='selected'";} ?>>December</option>
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
                                                    <input class="form-control" id="detail-customer-allergies" name="detail-customer-allergies" placeholder="Note down any allergies the customer may have" value="<?php echo $customer[0]['customer_allergies'] ?>"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group ">
                                                    <label for="detail-customer-alert" class="control-label text-warning">Custom Alert</label>
                                                    <input class="form-control" id="detail-customer-alert" name="detail-customer-alert" placeholder="Note down any other alerts you want to get when the customer visits . . ." value="<?php echo $customer[0]['customer_alert'] ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <button type="button" onclick="updatecustomer();" class="btn btn-info waves-effect waves-light pull-right">Save changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <div class="clearfix"></div>
                    </div>
                   
                </div>
            </div>
        </div>
        <!-- End Update Customer -->
                
        <div id="profileupdate" class="modal fade bs-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panelt panel-default">
                        <div class="panel-heading">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="panel-title">Update Profile</h3>
                            <p id="p1">
                                Please update customer profile <mark>Click</mark> on link <a target="_blank" href="<?php echo base_url('customer_list'); ?>"><strong>Customer</strong></a> to go Update.
                            </p>
                        </div>
                        <div class="panel-body" >
                            <span id="p2"></span>
                            <div class="btn-list">
                                <a class="btn btn-danger pull-right" data-dismiss="modal" class="close" href="javascript:void();" >Close</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.0/js.cookie.js"></script>
        <script>
                            $(document).ready(function() {
                               // fillBday();

                                $(".numeric").keypress(function(e) {
                                    //if the letter is not digit then display error and don't type anything
                                    if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                        return false;
                                    }
                                });

                                jQuery('#detail-customer-wedding').datepicker({
                                    autoclose: true,
                                    todayHighlight: true,
                                    format: 'yyyy/mm/dd'
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
                                $.fn.dataTable.moment('DD-MM-YYYY');
                                $("#tblservices").DataTable({
                                    "order": [[ 2, "asc" ]]
                                });
                                $.fn.dataTable.moment('DD-MM-YYYY');
                                $("#tblinvoices").DataTable({
                                   "order": [[ 2, "desc" ]]
                                });
                                

                            });

        function openupdate(){
            $("#editcustomer").modal('show');
            fillBday();
            enable_detailcareof();
        }

                         

        function updatecustomer() {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url() . 'customer_controller/updatecustomer'; ?>",
                data: $("#updateform").serialize(),
                success: function(data) {
                    var result = data.split("|");
                    if (result[0] === "success") {
                        toastr.success(data, 'Customer Updated');
                        location.reload();
                    }
                }
            });
        }

               
    function fillBday() {
        for (x = 1; x <= 31; x++) {
            $("#detail-customer-bday").append('<option value=' + x + '>' + x + '</option>');
        }
    }

                            
    function oncareofdetailchange(){
        var data = $("#detail-customer-careof").select2('data');

        if($("#detail-customer-cell").val()===""){
            $("#detail-customer-cell").val(data.customer_cell);
        }
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
        </script>
        <!-- end row -->
