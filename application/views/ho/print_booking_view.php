<style>
    .mouse-cursor{
        
    }
</style>  
<div class="wrapper">
            <div class="container">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">Advance Booking</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="pull-left">
                                        <h3 class="logo invoice-logo"><?php if(isset($business)){ echo "<img src='".base_url().'assets/images/business/'.$business[0]['business_logo']."' alt='".$business[0]['business_name']."' class='img-responsive' />";} else {echo 'SalonPK';}?></h3>
                                    </div>
                                    <div class="pull-right">
                                        <h4 class="img-">Booking # <br>
                                            <strong id="invoicenumber"><?php echo  date("Y").'-'.date("m").'-'; if(isset($visits[0]['id_customer_visits'])){ echo sprintf("%04s",$visits[0]['id_customer_visits']);}else{echo '00001';} ?></strong>
                                        </h4>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-left m-t-10">
                                            <input name="visitid" id="visitid" type="hidden" value="<?php echo $visits[0]['id_customer_visits']; ?>"/>
                                            <input name="customerid" id="customerid" type="hidden" value="<?php echo $visits[0]['id_customers']; ?>">
                                            <input name="customername" id="customername" type="hidden" value="<?php echo $visits[0]['customer_name']; ?>">
                                            
                                            <address>
                                              <strong><?php echo $visits[0]['customer_name']; ?></strong><br>
                                              <span ><abbr class="hidden-sm hidden-xs" title="Phone">P:</abbr> <?php echo $visits[0]['customer_cell']; ?></span><br>
                                              <span class="hidden-sm hidden-xs"><?php echo $visits[0]['customer_address']; ?></span><br>
                                              <span class="hidden-sm hidden-xs"><?php echo $visits[0]['customer_email']; ?></span>
                                            </address>
                                        </div>
                                        <div class="pull-right m-t-10">
                                            <p ><strong>Booking Date: </strong> <?php echo $visits[0]['booking_date']; ?></p>
                                            
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->

                                
                                <?php $exist_product = array(); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table m-t-10" id="tblservices">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Category</th>
                                                        <th>Visit Date</th>
                                                        <th>Advance</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   
                                                    
                                                    <?php $advancetotal=0;  foreach($visits as $v){ ?>
                                                    
                                                    <tr>
                                                        <td></td>
                                                        <td><?php echo $v['service_category'];?></td>
                                                        <td><?php echo $v['visit_date'];?></td>
                                                        <td><?php echo $v['advance_amount'];?></td>
                                                        
                                                    </tr>    
                                                    
                                                    <?php $advancetotal = $advancetotal+ (float)($v['advance_amount']); } ?>
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                     <div class="col-md-12">
                                         <div class="row">
                                            <div class="col-lg-9 col-md-9 hidden-sm hidden-xs"></div>
                                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                <?php $totalprice=0; foreach($category as $c){ $totalprice=$totalprice+(float)$c['Price']; }?>
                                                <h4 class="text-right text-success"><b>Total Price :</b>   Rs. <input id="txtsubtotal" class="form-inline" readonly="readonly" style="width: 80px; border: none;" value='<?php echo number_format((float)$totalprice, 2, ".", ",");?>'></h4>
                                                <h4 class="text-right text-success"><b>Total Advance :</b>   Rs. <input id="txtsubtotal" class="form-inline" readonly="readonly" style="width: 80px; border: none;" value='<?php echo number_format((float)$advancetotal, 2, ".", ",");?>'></h4>
                                                <hr>
                                                
                                                <h4 class="text-right text-danger">Balance Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly"  id="txtbalance"  name="txtbalance" value="<?php echo number_format(((float)$totalprice-(float)$advancetotal),2,".",",");?>"/></h4>
                                               
                                            </div>   
                                         </div>
                                     </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                       <div class="clearfix m-t-10">
                                            <h5 class="small text-inverse font-600">PAYMENT TERMS AND POLICIES</h5>
                                            <small>
                                                <?php if(isset($business[0]['booking_terms'])){echo $business[0]['booking_terms'];} else {echo $business[0]['payment_terms'];}?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="hidden-print">
                                    <div class="pull-right">
                                        <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light" id="btnprint"><i class="fa fa-print"></i></a>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- end row -->
               
<script>
    
 
   
    
   

</script>
