<div id="staffreporting" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="staffreportingLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <input type="hidden" id="staffonlinestatus">
                <h4 class="modal-title" id="staff-header"></h4>
            </div>
            <div class="modal-body">
                <div>
                    <div id="staffattendancebuttons" style="text-align: right;">
                        <span id="block_start_time" class="hidden"><?php echo $time->business_opening_time; ?>:00</span>
                        <span id="block_end_time" class="hidden"><?php echo $time->business_closing_time; ?>:00</span>
                        <span id="tagged" class="hidden"></span>
                        <a href="javascript:void(0);" block_calendar_date id="halfday" staff_id onclick="halfday_off('halfday');" class="btn btn-primary waves-effect w-md m-b-5 staffdayid">Half Day Off</a>
                        <a href="javascript:void(0);" block_calendar_date id="fullday" staff_id onclick="fullday_off('fullday');" class="btn btn-danger waves-effect w-md m-b-5 staffdayid">Full Day Off</a>
                        <!--<button style="display: none;" type="button" staff_id="" onclick="timeout();" class="btn btn-danger waves-effect w-md m-b-5 stafftimeout">Time Out</button>-->
                        <!--<button type="button" staff_id="" onclick="timein();" class="btn btn-success waves-effect w-md m-b-5 stafftimein">Time In</button>-->
                    </div>
                    <br>
                    <div id="totalcats" <?php if(isset($scheduler_style) && $scheduler_style[0]['staff_stats']=="N" && $user_role!=="Admin"){ echo 'style="display:none"';} ?> >

                    </div>
                </div>

                <div class="clearfix"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Staff Block Time -->
<div id="full_half_blocktime" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="full_half_blocktime" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <input type="hidden" id="staffonlinestatus">
                <h4 class="modal-title" id="set_halffull_block">Block Staff Time</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <div class="pull-right">
                                <!--<button class="btn btn-inverse btn-xs w-md m-b-5"><i class="glyphicon glyphicon-chevron-left"></i> Back</button>-->
                            </div>
                            <h4 class="header-title m-t-0 m-b-30"></h4>
                            <br>
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="form-group">
                                        <label for="set_blocking_events" class="control-label">Block Events</label>
                                        <select id="set_blocking_events" class="form-control">

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="set_blocking_remarks" class="control-label">Remarks</label>
                                        <textarea rows="5" id="set_blocking_remarks" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div style="text-align: right; margin-top: 10px;">
                                        <button type="button" onclick="saveFullBlockTime();" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- End Staff Block Time -->
