<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Scheduled Tasks:</h4>
            </div>
        </div>

        <div class="row" <?php if ($business[0]['loyalty_enable'] == 'Y') {echo "style='display:none;'";} ?>>
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="header-title m-t-0 m-b-30">This Feature Is Not Enabled On Your Instance.</h4>
                    <p class="text-pink" style="font-size: 24px;">
                        "Scheduled Tasks" is a feature of the <a href="http://www.skedwise.com/features/loyalty" target="_blank">SkedWise Loyalty Program Addon.</a>
                    </p>
                    <p>
                        To activate this feature please contact the Mexyon Sales & Support Team.
                    </p>
                </div>
            </div>
        </div>

        <div class="row" <?php if ($business[0]['loyalty_enable'] == 'N') { echo "style='display:none;'";} ?>>
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="header-title m-t-0 m-b-30"></h4>
                    <form action="<?php echo base_url(); ?>scheduled_tasks" method="post">
                        <input type="hidden" name="csrf_test_name" id="st_csrf" value=""/>
                        <div class="row m-b-20">
                            <div class="col-md-6">
                                <div class="col-md-4" style="text-align: right;">
                                    <label>These Tasks are scheduled on your instance for automatically sending SMS messages to clients:</label>
                                </div>
                                <div class="col-md-4">
                                    <select id="task" name="task" class="form-control">
                                    <?php foreach ($tasks as $t) { ?>
                                            <option <?php if (isset($task) && sizeof($task) > 0) {
                                            if ($t['id_scheduled_tasks'] == $task[0]['id_scheduled_tasks']) {
                                                echo 'selected="selected"';
                                            }
                                        } ?> value="<?php echo $t['id_scheduled_tasks']; ?>"><?php echo $t['task_name']; ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" onclick="$('#st_csrf').val($('#cook').val());"  class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button>
                                    <p><small>Click the Run button after selecting a scheduled task to see the list of customers that match this criteria today.</small></p>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Message: </strong><?php if (isset($task) && sizeof($task) > 0) {
    echo $task[0]['msg'];
} ?></p>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tblappointments" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>

                                    <tr>
                                        <?php foreach ($task_fields as $fields) { ?>
                                            <th><?php echo $fields->name; ?></th>                                        
                                    <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
<?php foreach ($sql_result as $customer) { ?>
                                        <tr>
    <?php foreach ($task_fields as $fields) { ?>
                                                <td><?php echo $customer[$fields->name]; ?></td>
    <?php } ?>

                                        </tr>
<?php } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
    </div>


    <script>

        $(document).ready(function () {

            $('#tblappointments').DataTable({
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                //stateSave: true,
                dom: "Bfrtlip",
                buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans", footer: true}, {
                        extend: "excel",
                        className: "btn-sm btn-warning btn-trans"
                    }, {extend: "pdf", className: "btn-sm btn-purple btn-trans", footer: true}
                    , {extend: "print", className: "btn-sm btn-primary btn-trans", footer: true}],
                responsive: !0,
                order: []
                        //"scrollX": true,
            });



        });







    </script>
