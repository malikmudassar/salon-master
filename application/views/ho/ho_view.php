<style>
    .table thead tr th{
        border-top:2px solid #eee;
        border-bottom:2px solid #eee;
        background: #fcfcfc;
    }
    .table tfoot tr th{
        border-top:2px solid #eee;
        border-bottom:2px solid #eee;
        background: #fcfcfc;
    }
    a:hover{
        color:#000 !important;
    }
    
</style>
<div class="wrapper">
    <div class="container">
        <div class="row m-t-20">
            <div class="col-md-12">

                <div class="row">  
                    <div class="col-lg-6">
                        <div class="card-box">

                           

                            <h4 class="header-title m-t-0 m-b-30">Your are viewing: <?php echo $business[0]['business_name'];?></h4>
                            <?php if (isset($business[0]['ho']) && $business[0]['ho'] == 'Yes') { ?>
                                <p style="font-size:16px;">
                                    <a href="#" onclick="open_PBooking();" class="text-primary"><i class="ti-bookmark-alt "></i> Add Booking</a>
                                </p>
                                <p style="font-size:16px;">
                                    <a href="<?php echo base_url();?>ho_booking_list" class="text-warning"><i class="ti-bookmark-alt "></i> Bookings</a>
                                </p>
                            
                            <?php } else { ?>
                                <p style="font-size:16px;">
                                    <a href="#">Scheduler</a>
                                </p>                                
                            <?php } ?>
                                <p style="font-size:16px;">
                                <a href="<?php echo base_url();?>ho_booking_report" class="text-pink"><i class="ti-bookmark-alt "></i> Booking Listing</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card-box">

                            

                            <h4 class="header-title m-t-0 m-b-30">Settings: <?php echo $business[0]['business_name'];?></h4>
                            <?php if (isset($business[0]['ho']) && $business[0]['ho'] == 'Yes') { ?>
                            <p style="font-size:16px;">
                                <a href="<?php echo base_url();?>ho_package_types" class="text-default"><i class="ti-bookmark-alt "></i> Package Definitions</a>
                            </p>
                          
                            <?php } else { ?>
                                <p style="font-size:16px;">
                                    <a href="#">Scheduler</a>
                                </p>                                
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h3></h3>
            </div>
        </div>
        
    </div>
</div>

<script>

    function open_PBooking(){
            window.location.assign('<?php echo base_url();?>ho_booking');
        }
        
</script>