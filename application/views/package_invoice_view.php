<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="pull-left">
                                <div>
                                    <?php if(isset($business)){ echo "<img width='180px' src='".base_url().'assets/images/business/'.$business[0]['business_logo']."' alt='".$business[0]['business_name']."' class='img-responsive' />";} else {echo 'SalonPK';}?>
                                    <span class="hidden-md hidden-lg"><?php if(isset($business)){ echo $business[0]['business_address'];} ?></span>
                                    <span class="hidden-md hidden-lg"><?php if(isset($business)){ echo $business[0]['business_phone1'];} ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="pull-left m-t-10 <?php if(isset($business[0]['showstaff'])){if($business[0]['showstaff']==='Y'){}else{echo 'class="hidden-sm hidden-xs"';}} ?> ">
                                    <address>
                                        <strong><?php echo $invoice[0]['customer_name']; ?></strong><br>
                                        
                                       <!-- <?php //echo $invoice[0]['customer_address']; ?><br>
                                        <?php //echo $invoice[0]['customer_email']; ?><br>
                                        <abbr title="Phone">P:</abbr> <?php //echo $invoice[0]['customer_cell']; ?>-->
                                    </address>
                                </div>
                                <div class="pull-right m-t-10">
                                    <h4>Invoice</h4>
                                    <p><strong>Invoice Date: </strong> <?php echo date('d-m-Y'); ?></p>
                                </div>
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="">
                                    <table class="table " id="tblservices">
                                        <thead>
                                            <tr><th>#</th>
                                            <th>Item</th>
                                            <th>Description</th>
                                            <th class="">Staff</th>
                                            <th class="">Appointment</th>
<!--                                            <th class="hidden-sm hidden-xs hidden">Products</th>
                                            <th class="hidden-sm hidden-xs hidden">Discount</th>
                                            <th class="hidden-sm hidden-xs hidden">Service Cost</th>-->

                                        </tr></thead>
                                        <tbody>
                                            <?php $x=1; if(isset($invoicedetails)){
                                                foreach($invoicedetails as $invoicedetail){ ?>
                                                <?php if($x===1){?> <tr><td colspan="4"><?php echo $invoicedetail['service_type'];;?></td></tr> <?php } ?>
                                                <tr>            
                                                    <td><?php echo $x;?></td>
                                                    <td><?php echo $invoicedetail['service_category']; ?></td>
                                                    <td><?php echo $invoicedetail['service_name']; ?></td>
                                                    <td class=""><?php echo str_replace('|','<br> ',$invoicedetail['staff']); ?></td>
                                                    <td><?php echo $invoicedetail['detail_visit_date']; ?></td>
<!--                                                <td class="hidden-sm hidden-xs hidden"><?php //echo str_replace('|','<br> ',$invoicedetail['products']); ?></td>
                                                    <td class="hidden-sm hidden-xs hidden">Rs.<span><?php //echo $invoicedetail['discount']; ?></span></td>
                                                    <td class="hidden">Rs.<span><?php //echo $invoicedetail['discounted_price']; ?></span></td>-->
                                                </tr>
                                                <?php $x++;}} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 hidden-sm hidden-xs">
<!--                                        <div class="clearfix m-t-40">
                                    <h5 class="small text-inverse font-600">PAYMENT TERMS AND POLICIES</h5>

                                    <small>
                                        <?php echo $business[0]['payment_terms'];?>
                                    </small>
                                </div>-->
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 col-md-offset-3">
                                <p class="text-right m-t-0 hidden">Gross Total:   Rs. <?php echo $invoice[0]['grossTotal'];?></p>
                                <hr>
                                <p class="text-right text-success m-t-0">  Rs. <?php echo $invoice[0]['netTotal']; ?></p>
                                <p class="text-right m-t-0">  Paid Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" id="paid" readonly  name="paid" value="<?php echo $invoice[0]['paidTotal']; ?>"/></p>
                                <p class="text-right text-primary m-t-0">  Return Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly"  name="returnamount" value="<?php echo $invoice[0]['returnTotal']; ?>"></p>
                                <p class="text-right text-danger m-t-0">  Balance Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly" id="balanceamount"  name="balanceamount" value="<?php echo $invoice[0]['balanceTotal']; ?>"/></p>
                            </div>
                        </div>
                        <hr>
                        <div class="hidden-print">
                            <div class="pull-right">
                                <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light" id="btnprint" ><i class="fa fa-print"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- end row -->