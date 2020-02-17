<div class="modal fade none-border" id="block_staff_modal" tabindex="-1" role="dialog" aria-labelledby="block_staff_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title">Block Staff Time</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <input type="hidden" id="block-event-id">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td style="width: 130px;">Staff Name</td>
                                    <td><strong id="block-staff"></strong></td>
                                </tr>
                                <tr>
                                    <td>Block Reason</td>
                                    <td><strong id="block-reason"></strong></td>
                                </tr>
                                <tr>
                                    <td>Block Start Time</td>
                                    <td><strong id="block-starttime"></strong></td>
                                </tr>
                                <tr>
                                    <td>Block End Time</td>
                                    <td><strong id="block-endtime"></strong></td>
                                </tr>
                                <tr>
                                    <td>Remarks</td>
                                    <td><strong id="block-remarks"></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-12">
                        <div style="text-align: right; margin-top: 10px;">
                            <button type="button" onclick="removeBlockStaffTime();" class="btn btn-danger waves-effect waves-light"><i class="glyphicon glyphicon-remove"></i> Delete</button>
                            <button type="button" class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
