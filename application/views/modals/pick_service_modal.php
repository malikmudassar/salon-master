<div id="pickservice" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="pickservice" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-md"  >
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Pick Service</h4>
                    </div>
                    <div class="modal-body">
        
                <!-- Services -->
                <div class="row">
                    <div class="col-md-12">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                        <div id="visit-services-types" class="nicescroll_service_types visit-services-types services" style="height: 500px; overflow-y: scroll; outline: none;">
                                            <ul>
                                            <?php foreach($type_list as $type){ ?>
                                                <!--<li class="text-pink"><strong onclick='$("#category<?php echo $type['id_service_types'];?>").toggle(); $("#visit-services-types").niceScroll().resize();'><img src="<?php if(null!==$type['service_type_image'] && $type['service_type_image']!==""){ echo base_url('assets/images/servicetype/'.$type['service_type_image']);} else {echo base_url('assets/images/servicetype/nu.jpg');} ?>"> <?php echo $type['service_type']; ?> <i class="fa fa-play" style="font-size: 6px;"></i></strong>--> 
                                                <li class="text-pink"><strong onclick='$("#category<?php echo $type['id_service_types'];?>").toggle(); $("#visit-services-types").niceScroll().resize();'> <?php echo $type['service_type']; ?> <i class="fa fa-play" style="font-size: 6px;"></i></strong> 
                                                <ul style="display: none; padding-left: 20px;" id='category<?php echo $type['id_service_types'];?>'>
                                                    <?php foreach($category_list as $category){ ?>
                                                        <?php if($category['service_type_id']==$type['id_service_types']){?>
                                                        <!--<li class="text-pink"><span  onclick='$("#service<?php echo $category['id_service_category'];?>").toggle(); $("#visit-services-types").niceScroll().resize();'><img src="<?php if(null!==$category['service_category_image'] && $category['service_category_image']!==""){ echo base_url('assets/images/category/'.$category['service_category_image']);} else {echo base_url('assets/images/servicetype/nu.jpg');} ?>"> <?php echo $category['service_category'];?> <i class="fa fa-play" style="font-size: 6px;"></i></span>-->
                                                            <li class="text-pink"><span  onclick='$("#service<?php echo $category['id_service_category'];?>").toggle(); $("#visit-services-types").niceScroll().resize();'><?php echo $category['service_category'];?> <i class="fa fa-play" style="font-size: 6px;"></i></span>
                                                            <ul style="padding-left: 20px; display:none;" id="service<?php echo $category['id_service_category'];?>">
                                                                <?php foreach($services_list as $service){?>
                                                                <?php if($category['id_service_category']==$service['service_category_id']){?>
                                                                    <li onclick="$('#visit-services').select2().val('<?php echo $service['id_business_services'].'-'.$category['id_service_category'];; ?>').trigger('change'); $('#pickservice').modal('hide');" style="color:#808080" service_id="<?php echo $service['id_business_services']; ?>" ><?php echo $service['service_name'];?><span style="float:right;"><?php echo $service['service_rate']; ?></span></li>
                                                                <?php } ?>
                                                                <?php } ?>
                                                            </ul>
                                                        </li> <!--category End-->
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </li> <!--Type End-->
                                                </ul>
                                            <?php } ?>
                                               
                                            <?php foreach($package_type_list as $type){ ?>
                                                <!--<li class="text-pink"><strong onclick='$("#pcategory<?php echo $type['id_package_type'];?>").toggle(); $("#visit-services-types").niceScroll().resize();'><img src="<?php if(null!==$type['service_type_image'] && $type['service_type_image']!==""){ echo base_url('assets/images/servicetype/'.$type['service_type_image']);} else {echo base_url('assets/images/servicetype/nu.jpg');} ?>"> <?php echo $type['service_type']; ?> <i class="fa fa-play" style="font-size: 6px;"></i></strong>--> 
                                                <li class="text-pink"><strong onclick='$("#pcategory<?php echo $type['id_package_type'];?>").toggle(); $("#visit-services-types").niceScroll().resize();'><?php echo $type['service_type']; ?> <i class="fa fa-play" style="font-size: 6px;"></i></strong> 
                                                <ul style="display: none; padding-left: 20px;" id='pcategory<?php echo $type['id_package_type'];?>'>
                                                    <?php foreach($package_category_list as $category){ ?>
                                                        <?php if($category['package_type_id']==$type['id_package_type']){?>
                                                        <!--<li class="text-pink"><span  onclick='$("#pservice<?php echo $category['id_package_category'];?>").toggle(); $("#visit-services-types").niceScroll().resize();'><img src="<?php if(null!==$category['service_category_image'] && $category['service_category_image']!==""){ echo base_url('assets/images/category/'.$category['service_category_image']);} else {echo base_url('assets/images/servicetype/nu.jpg');} ?>"> <?php echo $category['service_category'];?> <i class="fa fa-play" style="font-size: 6px;"></i></span>-->
                                                        <li class="text-pink"><span  onclick='$("#pservice<?php echo $category['id_package_category'];?>").toggle(); $("#visit-services-types").niceScroll().resize();'> <?php echo $category['service_category'];?> <i class="fa fa-play" style="font-size: 6px;"></i></span>    
                                                            <ul style="padding-left: 20px; display:none;" id="pservice<?php echo $category['id_package_category'];?>">
                                                                <?php foreach($package_services_list as $service){?>
                                                                <?php if($category['id_package_category']==$service['package_category_id']){?>
                                                                    <li onclick="$('#visit-services').select2().val('<?php echo $service['id_business_services'].'-'.$category['id_package_category'];; ?>').trigger('change'); $('#pickservice').modal('hide');" style="color:#808080" service_id="<?php echo $service['id_package_services']; ?>" ><?php echo $service['service_name'];?><span style="float:right;"><?php echo $service['package_service_rate']; ?></span></li>
                                                                <?php } ?>
                                                                <?php } ?>
                                                            </ul>
                                                        </li> <!--category End-->
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </li> <!--Type End-->
                                                </ul>
                                            <?php } ?>    
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                

                            </div>
                           
                        
                    </div>
                </div>
                <!-- End Services -->
                    </div>
                </div> 
            </div>
        </div>

<style>
    
        /* visit services types */
        .visit-services-types ul {
            list-style: none; padding: 10px 0px;
        }
        .visit-services-types ul li {
            padding: 10px 0px; cursor: pointer; border-bottom: 1px solid #f6f6f6; 
        }
        .visit-services-types ul li img {
            height: 30px;
        }

        /* visit services */
        .visit-services-categories ul {
            list-style: none; padding: 10px 0px;
        }
        .visit-services-categories ul li {
            padding: 10px 0px; cursor: pointer; border-bottom: 1px solid #f6f6f6; 
        }
        .visit-services-categories ul li img {
            height: 30px;
        }

        .visit-services ul {
            list-style: none; padding: 10px 0px;
        }
        .visit-services ul li {
            padding: 10px 0px; cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
        }

        .visit-products ul {
            list-style: none; padding: 0px;
        }
        .visit-products ul li {
            cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
        }

</style>

<script>

   $(document).ready(function(){
       $('#visit-services-types').niceScroll({cursoropacitymin: 1, autohidemode:false});
       
       
   });
   
</script>