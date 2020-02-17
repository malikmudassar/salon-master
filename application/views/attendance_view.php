<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Attendance:</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>
                    <table id="tblattendance" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="width:10%"></th>
                                <th style="display:none">ID</th>
                                <th style="width:30%">Staff </th>
                                <th style="width:10%">Cell</th>
                                <th style="width:25%">Time In</th>
                                <th style="width:25%">Time Out</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($staff as $s) { ?>
                                <tr>
                                    <th><img class="img-circle thumb-lg img-thumbnail m-b-10" src="<?php echo base_url() . 'assets/images/staff/' . $s['staff_image']; ?>" alt="<?php echo $s['staff_fullname']; ?>"  /></th>
                                    <th style="display:none"><?php echo $s['id_staff']; ?></th>
                                    <th><?php echo $s['staff_fullname']; ?></th>
                                    <th><?php echo $s['staff_cell']; ?></th>
                                    <th><span id="stimein_<?php echo $s['id_staff'];?>"><?php
                                        if ($s['time_in'] !== "" && $s['time_in'] !== null) {
                                            echo $s['time_in'];
                                        } else {
                                            ?>
                                            <button class="btn btn-pink " onClick="$(this).attr('disabled','diabled'); timein('<?php echo $s['id_staff'];?>');">Time In</button>
                                        <?php } ?></span>
                                    </th>
                                    <th><span id="stimeout_<?php echo $s['id_staff'];?>"><?php
                                    if ($s['time_out'] !== "" && $s['time_out'] !== null) {
                                        echo $s['time_out'];
                                    } else if ($s['time_in'] !== "" && $s['time_in'] !== null) {
                                        ?>
                                        <button onClick="timeout('<?php echo $s['id_staff']; ?>')" class="btn btn-danger ">Time Out</button>
                                    <?php } ?>
                                        </span>
                                    </th>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

        <script>
            var startdate = '';
            var enddate = '';
            $(document).ready(function () {
                $('#tblattendance').DataTable({
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    stateSave: true,
                    dom: "Bfrtlip",
                    buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans", footer: true}, {
                            extend: "excel",
                            className: "btn-sm btn-warning btn-trans"
                        }, {extend: "pdf", className: "btn-sm btn-purple btn-trans", footer: true}
                        , {extend: "print", className: "btn-sm btn-primary btn-trans", footer: true}],
                    responsive: 0,
                    order: []
                });
            });
            
        function timein(id_staff){
             var t = "#stimein_"+id_staff;
             $(t).html('');
             $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url();?>staff_controller/timein',
                    data: {id: id_staff},
                    success: function(data) {
                        
                        var result = data.split("|");
                        if (result[0] === "success") {
                            toastr.success(data, 'Updated');
                            
                           $(t).html(result[1]);
                           
                            var to = "#stimeout_"+id_staff;
                            var btn= '<button onClick="timeout('+ id_staff +')" class="btn btn-danger ">Time Out</button>';
                            $(to).html(btn);
                        } 
                    }
                });
            
        }
        
        function timeout(id_staff){
            var t = "#stimeout_"+id_staff;
            $(t).html('');
             $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url();?>staff_controller/timeout',
                    data: {id: id_staff},
                    success: function(data) {
                        var result = data.split("|");
                        if (result[0] === "success") {
                            toastr.success(data, 'Updated');
                            
                           $(t).html(result[1]);
                           
                           
                           
                        } 
                    }
                });
            
        }
            
        </script>
