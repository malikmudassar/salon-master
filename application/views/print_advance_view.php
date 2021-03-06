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
                                            <strong id="invoicenumber"><?php echo  date("Y").'-'.date("m").'-'; if(isset($visit[0]['id_customer_visits'])){ echo sprintf("%04s",$visit[0]['id_customer_visits']);}else{echo '00001';} ?></strong>
                                        </h4>
                                    </div>
                                </div>
                               
                                <div class="row" style="color:#000 !important">
                                    <div class="col-md-12">
                                        <div class="pull-left m-t-10">
                                            <input name="visitid" id="visitid" type="hidden" value="<?php echo $visit[0]['id_customer_visits']; ?>"/>
                                            <input name="customerid" id="customerid" type="hidden" value="<?php echo $visit[0]['id_customers']; ?>">
                                            <input name="customername" id="customername" type="hidden" value="<?php echo $visit[0]['customer_name']; ?>">
                                            
                                            <address>
                                              <strong><?php echo $visit[0]['customer_name']; ?></strong><br>
                                              <span ><abbr class="hidden-sm hidden-xs" title="Phone">P:</abbr> <?php echo $visit[0]['customer_cell']; ?></span><br>
                                              <span class="hidden-sm hidden-xs"><?php echo $visit[0]['customer_address']; ?></span><br>
                                              <span class="hidden-sm hidden-xs"><?php echo $visit[0]['customer_email']; ?></span>
                                            </address>
                                        </div>
                                        <div class="pull-right m-t-10">
                                            <p ><strong>Date: </strong> <?php echo $advances[sizeof($advances)-1]['advance_date']; ?></p>
                                            <p id="modep"><strong>Payment: </strong> <span id="mode"><?php echo $advances[sizeof($advances)-1]['advance_mode']; ?></span></p>

                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table">
                                            <table class="table m-t-10" id="tblservices">
                                                <thead style="color:#000 !important">
                                                    <tr>
                                                        <th class="hidden-xs">#</th>
                                                        <th>Category</th>
                                                        <th>Description</th>
                                                        <th>Visit Time</th>
                                                        <th class="hidden-xs">Staff</th>
                                                        <th>Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="color:#000 !important">
                                                    <?php
                                                        $subtotal=0; 
                                                        if(isset($services)){
                                                       $i=0;
                                                        foreach($services as $service){
                                                            $subtotal=$subtotal+$service['service_rate'];
                                                             $i++;
                                                        }
                                                    } ?>
                                                    
                                                    <?php 
                                                        if(isset($services)){  $x=1; 
                                                            foreach($services as $service){
                                                                ?>
                                                    
                                                    <tr id="idtr">
                                                            <td class="hidden-xs"><?php echo $x;?></td>
                                                            <td><?php echo $service['service_category']; ?></td>
                                                            <td>
                                                                <input type="hidden" name="service_ids" value="<?php echo $service['id_business_services']; ?>">
                                                                <?php echo $service['service_name']; ?>
                                                            </td>
                                                            <td><?php echo $service['vdate']; ?></td>
                                                            <td class="hidden-xs">
                                                                <?php
                                                                $staff_names = '';
                                                                foreach($staffs as $staff){
                                                                    if($service['id_visit_services'] === $staff['visit_service_id']){
                                                                        $staff_names .= $staff['staff_name']."<br>";
                                                                    }
                                                                }
                                                                echo $staff_names;
                                                                ?>
                                                            </td>
                                                             <?php if(isset($service['service_flag'])){?>
                                                                <?php if($service['service_flag']=='servicetype'){?>
                                                                    <td >Rs.<span><?php echo $service['service_rate']; ?></span></td>
                                                                <?php } else { ?><td>Deal</td><?php }?>
                                                             <?php } else {?>
                                                                <td >Rs.<span><?php echo $service['service_rate']; ?></span></td>
                                                             <?php }?>
                                                           
                                                        </tr>
                                                        <?php $x++; $i++;}} ?>
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="color:#000 !important">
                                     <div class="col-md-12">
                                         <div class="row">
                                            <div class="col-lg-9 col-md-9 hidden-sm hidden-xs"></div>
                                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                <h4 class="text-right"><b>Total: Rs. <input id="txtsubtotal" class="form-inline" readonly="readonly" style="width: 80px; border: none;" value='<?php echo number_format((float)$subtotal, 2, ".", ",");?>'></b></h4>
                                                <hr>
                                                <?php $tot_adv=0; $x=1; foreach($advances as $adv){?>
                                                <p class="text-right m-t-0" <?php if($x==sizeof($advances)){echo "style='font-weight:bold;'";}?> >Adv. on <?php echo $adv['date']; ?> <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly"  id="txtadvance"  name="txtadvance" value="<?php echo number_format((float)$adv['advance_amount'],2,".",","); $tot_adv=$tot_adv+$adv['advance_amount'];?>"/></p>
                                                <?php $x++;} ?>
                                                <hr>
                                                <h4 class="text-right ">Total Advance Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly"  id="txtadvance"  name="txtadvance" value="<?php echo number_format((float)$tot_adv,2,".",",");?>"/></h4>
                                                
                                                <?php if($visit[0]['visit_status'] === "open"){?>
                                                <h4 class="text-right ">Balance Rs. <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly"  id="txtbalance"  name="txtbalance" value="<?php echo number_format(((float)$subtotal-(float)$tot_adv),2,".",",");?>"/></h4>
                                                <?php } else { ?>
                                                <h4 class="text-right ">Status : <input class="numeric" style="text-align: right; width: 95px; border: none;" readonly="readonly"  id="txtbalance"  name="txtbalance" value="<?php echo $visit[0]['visit_status'] ; ?>"/></h4>
                                                <?php  } ?>
                                            </div>   
                                         </div>
                                     </div>
                                </div>
                                <div class="row" style="color:#000 !important">
                                    
                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                       <div class="clearfix m-t-10">
                                            <h5 class="small text-inverse font-600">PAYMENT TERMS AND POLICIES</h5>

                                            <small>
                                                <?php echo $business[0]['payment_terms'];?>
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
