<div class="wrapper">
<div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn-group pull-right m-t-15">
                            <button id="btnRetail" class="btn btn-custom waves-effect waves-light">Retail</button>
                            <button style="display: none;" type="button" class="btn btn-custom dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Settings <span class="m-l-5"><i class="fa fa-cog"></i></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </div>
                        <h4 class="page-title">Calendar</h4>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">

                        <div class="row">
                            <div class="col-md-3 hidden">
                                <div class="widget">
                                    <div class="widget-body">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <a href="#" data-toggle="modal" data-target="#add-category" class="btn btn-lg btn-success btn-block waves-effect waves-light">
                                                    <i class="fa fa-plus"></i> Create New
                                                </a>
                                                <div id="external-events" class="m-t-20 fc-event-container">
                                                    <br>
                                                    <p>Drag and drop your event or click in the calendar</p>
                                                    <div class="external-event bg-primary fc-event" data-class="bg-primary">
                                                        <i class="fa fa-move"></i>New Theme Release
                                                    </div>
                                                    <div class="external-event bg-pink fc-event" data-class="bg-pink">
                                                        <i class="fa fa-move"></i>My Event
                                                    </div>
                                                    <div class="external-event bg-warning fc-event" data-class="bg-warning">
                                                        <i class="fa fa-move"></i>Meet manager
                                                    </div>
                                                    <div class="external-event bg-purple fc-event" data-class="bg-purple">
                                                        <i class="fa fa-move"></i>Create New theme
                                                    </div>
                                                </div>

                                                <!-- checkbox -->
                                                <div class="checkbox m-t-40">
                                                    <input id="drop-remove" type="checkbox">
                                                    <label for="drop-remove">
                                                        Remove after drop
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-md-12">
                                <div class="card-box">
                                    <div id="calUpperDiv">
<!--                                        <input type="hidden" name="calendar_date" value="<?php //echo date('Y-m-d'); ?>">-->
                                        <div id="calendar" style=""></div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>  <!-- end row -->
                        
                        <!--Event View Model-->
                        <?php include 'modals/event_view_modal.php'; ?>
                        <!--END Event View Model-->

                        <!-- VISITOR MODAL -->
                        <?php include 'modals/visitor_modal.php'; ?>
                        <!-- END VISITOR MODAL -->
                        
                        <!--Retail Model-->
                        <?php include 'modals/retail_modal.php'; ?>
                        <!--End Retail Model-->
                        
                        <!--Staff Reporting Model-->
                        <?php include 'modals/staff_reporting_modal.php'; ?>
                        <!--End Staff Reporting Model-->
                        
                    </div>
                    <!-- end col-12 -->
                </div> <!-- end row -->

</div>
    
<?php

$hours = array();

for($i=10; $i < 20; $i++){
    $hours[] = $i.":00:00";
}
//print_r($hours);
?>
    
<style>
/*    .fc-time-grid .fc-slats td{ height: 50px; }*/
    .fc th.fc-widget-header{ padding: 0 4px; }
    
    .fc-time-grid .fc-slats tr{
        background: #ccc; color: #000;
    }
    
    .fc-time-grid .fc-slats .fc-minor{
        background: transparent;
    }
    
    <?php foreach($hours as $hour){ ?>
    .fc-time-grid .fc-slats tr[data-time|='<?php echo $hour; ?>']{
        border-top: 3px solid #908f8f;
    }
    <?php } ?>
    
    .fc-time-grid .fc-slats tr > td {
        
    }
    .fc-time-grid .fc-slats .fc-minor > td {

    }
    
</style>

<script>
    var page = 'scheduler';
</script>


<?php include 'js_functions/calendar_js.php'; ?>

<?php include 'js_functions/visit_js.php'; ?>

<?php include 'js_functions/retail_js.php';