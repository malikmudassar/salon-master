<div id="businessmodal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="pickbusiness" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="custom-width-modalLabel">Pick Business Instance</h4>
            </div>
            <div class="modal-body">

                <!-- Business -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                            <input type="hidden" id="oldstaffid">
                            <input type="hidden" id="oldstaffname">
                            <input type="hidden" id="replacementelement">
                            <input class="form-control m-b-10" id="searchbusinessdirect1">
                            <div id="pick-business-div" class="nicescroll_service_types visit-services-types services" style="height: 500px; overflow-y: scroll; outline: none;">
                                <ul  id='modalbusinesslist'>
                                    //<?php foreach ($b_list as $b) { ?>
                                    <li business_id='//<?php echo $b->id_business; ?>' >
                                        <!--<img src='//<?php echo base_url('assets/images/staff/'.$staff->staff_image); ?>' alt=''/>-->
                                        //<?php echo $b->business_name; ?>
                                    </li>
                                    //<?php } ?>
                                </ul>
                            </div>
                        </div>
                        <form id="openagain" action="<?php echo base_url('business_switch');?>" method="post"> 
                            <input type="hidden" name="csrf_test_name" id="openagain_csrf" value=""/>
                            <input type="hidden" name="id_business" id="id_business" value=""/>
                            <input type="hidden" name="business_name" id="business_name" value=""/>
                        </form>
                    </div>
                </div>
                <!-- End Business -->
            </div>
        </div> 
    </div>
</div>

<style>

    /* visit services types */
    .visit-services-types ul {
        list-style: none; padding: 0px;
    }
    .visit-services-types ul li {
        cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
    }
    .visit-services-types ul li img {
        height: 30px;
    }

    /* visit services */
    .visit-services-categories ul {
        list-style: none; padding: 0px;
    }
    .visit-services-categories ul li {
        cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
    }
    .visit-services-categories ul li img {
        height: 30px;
    }

    .visit-services ul {
        list-style: none; padding: 0px;
    }
    .visit-services ul li {
        cursor: pointer; border-bottom: 1px solid #f6f6f6; margin-bottom: 5px;
    }

</style>



<script>
$(document).ready(function () {
    $("#pick-business-div").searcher({
        itemSelector: "li",
        textSelector: "",
        inputSelector: "#searchbusinessdirect1"
    });
});
</script>