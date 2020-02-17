<div id="staffmodal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="pickservice" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="custom-width-modalLabel">Pick Staff</h4>
            </div>
            <div class="modal-body">

                <!-- Staff -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" style="border: 1px solid #eaeaea; padding: 10px;">
                            <input type="hidden" id="oldstaffid">
                            <input type="hidden" id="oldstaffname">
                            <input type="hidden" id="replacementelement">
                            <input class="form-control m-b-10" id="searchstaffdirect1">
                            <div id="pick-staff-div" class="nicescroll_service_types visit-services-types services" style="height: 500px; overflow-y: scroll; outline: none;">
                                <ul  id='modalstafflist'>
                                    <?php foreach ($staff_list as $staff) { ?>
                                    <li staffid='<?php echo $staff->id_staff; ?>' onclick="pickstaff(<?php echo $staff->id_staff;?>,'<?php echo $staff->staff_fullname;?>')" >
                                        <!--<img src='<?php echo base_url('assets/images/staff/'.$staff->staff_image); ?>' alt=''/>-->
                                        <?php echo $staff->staff_fullname; ?>
                                    </li>
                                    <?php } ?>
                                </ul>
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
    $("#pick-staff-div").searcher({
        itemSelector: "li",
        textSelector: "",
        inputSelector: "#searchstaffdirect1"
    });
});
</script>