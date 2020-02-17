        <div class="wrapper">
            <div class="container">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        
                        <h4 class="page-title">Services Price List</h4>
                    </div>
                </div>
                
                 <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                        <label class="control-label">Types</label>
                                        <div id="service-types" class="service-types nicescroll_services" style="height: 500px; overflow: hidden; outline: none;">
                                            
                                            <ul class="servicelist m-t-10" id="servicestypes">
                                                <?php foreach($service_types as $st){?>
                                                <li data-service_type_id="<?php echo $st->id_service_types; ?>" data-types-flag="<?php echo $st->flag; ?>" onclick="getcategories('<?php echo $st->id_service_types; ?>' ,'<?php echo $st->flag;?>');"><img src="<?php echo base_url()."assets/images/servicetype/".$st->service_type_image; ?>"/><?php echo ' '.$st->service_type; ?></li>
                                                <?php } ?>                                                                                                
                                            </ul>                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                        <label class="control-label">Categories</label>
                                        <div id="service-category" class="service-category nicescroll_services" style="outline: none;">
                                            
                                            <ul class="servicelist m-t-10" id="servicecategory">
                                                <?php foreach($service_categories as $sc){ if($sc['service_category_active']=="Yes"){?>
                                                <li style="display:none;" data-service-type-id="<?php echo $sc['service_type_id']; ?>" data-service_category_id="<?php echo $sc['id_service_category']; ?>" data-category-flag="<?php echo $sc['flag']; ?>"  onclick="getservices('<?php echo $sc['id_service_category']; ?>','<?php echo $sc['flag']; ?>');"><img src="<?php echo base_url()."assets/images/servicetype/".$sc['service_category_image']; ?>"/><?php echo ' '.$sc['service_category']; ?></li>
                                                <?php }} ?>                                                                                                
                                            </ul>    
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                                        <label class="control-label">Services</label>
                                        <div id="services" class="" style="outline: none;">
                                            
                                            <ul class="servicelist m-t-10" id="servicelist">
                                                <?php foreach($services as $service){ ?>
                                                <?php if($business[0]['tax_optional']=="No"){
                                                    $servicerate = round((float)(($service['service_rate']*$taxes)/100)+(float)$service['service_rate']);
                                                    ?>
                                                    <li style="display:none; border-bottom:1px solid #f6f6f6; line-height: 25px;" data-service-category-id="<?php echo $service['id_service_category']; ?>" data-service="<?php echo $service['id_business_services']; ?>" data-service-flag="<?php echo $service['flag']; ?>" ><?php echo '<span style="float:left; font-weight:bold; ">'.$service['service_name'].' </span> <span style="padding-left:2px;" class="small"> with '.$taxes.'% tax </span><span style="float:right; font-weight:bold" class="text-pink">Rs. '.$servicerate.'</span>'; ?></li>
                                                <?php } else {?>
                                                    <li style="display:none; border-bottom:1px solid #f6f6f6; line-height: 25px;" data-service-category-id="<?php echo $service['id_service_category']; ?>" data-service="<?php echo $service['id_business_services']; ?>" data-service-flag="<?php echo $service['flag']; ?>" ><?php echo '<span style="float:left; font-weight:bold; ">'.$service['service_name'].' </span> <span style="float:right; font-weight:bold" class="text-pink">Rs. '.$service['service_rate'].'</span>'; ?></li>
                                                <?php } } ?>                                                                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                 </div>
            </div>
<style>
        /* visit services types */
        .service-types ul {
            list-style: none; padding: 0px;
        }
        .service-types ul li {
            cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
        }
        .service-types ul li img {
            height: 30px;
        }

        /* visit services */
        .service-category ul {
            list-style: none; padding: 0px;
        }
        .service-category ul li {
            cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
        }
        .service-category ul li img {
            height: 30px;
        }

        .services ul {
            list-style: none; padding: 0px;
        }
        .services ul li {
            cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
        }

        .products ul {
            list-style: none; padding: 0px;
        }
        .products ul li {
            cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
        }
</style>            
<script>
    $(document).ready(function() {
        
        
        $(".nicescroll_services").niceScroll({cursoropacitymin: 1});
        
    });
    
    function getcategories(id_service_types, flag){
        $.each($('#servicecategory li'), function (index, value){
            $(this).hide();
        });
        
        $.each($('#servicecategory li'), function (index, value) { 
            
            if($(this).attr('data-service-type-id')===id_service_types && $(this).attr('data-category-flag')===flag){
                $(this).show();
            }
             
        });
        
        
        $(".nicescroll_services").niceScroll({cursoropacitymin: 1});
    }
    
    function getservices(id_service_category, flag){
        $.each($('#services li'), function (index, value){
            $(this).hide();
        });
        
        $.each($('#services li'), function (index, value) { 
            
            if($(this).attr('data-service-category-id')===id_service_category && $(this).attr('data-service-flag')===flag){
                $(this).show();
            }
             
        });
       
        
        $(".nicescroll_services").niceScroll({cursoropacitymin: 1});
    }
</script>