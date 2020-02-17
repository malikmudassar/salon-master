<style>
    table.dataTable tr.group td{font-weight:bold;background-color:#e0e0e0}

    table.dataTable tr.group,
    tr.group:hover {
        background-color: #ddd !important;
    }

</style>

<div class="wrapper">
    <div class="container-full">

        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box m-t-20">
                    <!-- Page-Title -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="pull-left" >
                                        <h3 class="logo invoice-logo"><?php if (isset($business)) {
                                            echo "<img src='" . base_url() . 'assets/images/business/' . $business[0]['business_logo'] . "' alt='" . $business[0]['business_name'] . "' class='img-responsive' />";
                                        } else {
                                            echo 'SkedWise';
                                        } ?></h3>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class=" m-t-20" >
                                        <div class="col-md-6 hidden-print m-t-20">
                                            <form method="POST" action='<?php echo base_url(); ?>super_visits'>
                                                <input type="hidden" name="csrf_test_name" id="supervise_visit_csrf" value=""/>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control inline m-r-5"  placeholder="mm/dd/yyyy" name="calendar_date" id="datepicker-autoclose">
                                                </div>
                                                <div class="col-md-3">
                                                    <button type='submit' onclick="$('#supervise_visit_csrf').val($('#cook').val());" class="btn btn-pink btn-bordred waves-effect waves-light m-b-5">Run</button>
                                                </div>
                                            </form>
                                        </div>

                                        
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Visits Created On : <?php echo $date;?></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="datatable-buttons" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Visit ID</th>
                                        <th>Visit Date</th>
                                        <th>Customer ID</th>
                                        <th>Customer Name</th>
                                        <th>Status</th>
                                        <th>Advance</th>
                                        <th>Advance Mode</th>
                                        <th>Advance Date</th>
                                        <th>Comment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($visits as $visit) { ?>
                                    <tr>
                                        <td class='noprint'> 
                                            <form method="POST" action="<?php echo base_url(); ?>super_edit_visit" >
                                                <input type="hidden" name="id_customer_visits" id="id_customer_visits_<?php echo $visit['id_customer_visits']; ?>" value="<?php echo $visit['id_customer_visits']; ?>">
                                                <input type="hidden" name="csrf_test_name" id="<?php echo $visit['id_customer_visits'];?>" value="0"/>
                                                <button onclick="$('#<?php echo $visit['id_customer_visits'];?>').val($('#cook').val());" class="btn btn-icon waves-effect waves-light btn-warning m-b-5"> <i class="fa fa-pencil"></i> </button>  
                                            </form>
                                        </td>
                                        <td><?php echo $visit['id_customer_visits']; ?></td>
                                        <td><?php echo $visit['visitdate']; ?></td>
                                        <td><?php echo $visit['customer_id']; ?></td>
                                        <td><?php echo $visit['customer_name']; ?></td>
                                        <td <?php if($visit['visit_status']=='canceled'){echo 'class="text-danger"';}else if($visit['visit_status']=='invoiced'){echo 'class="text-success"';} ?>><strong><?php echo $visit['visit_status']; ?></strong></td>
                                        <td><?php echo $visit['advance_amount']; ?></td>
                                        <td><?php echo $visit['advance_mode']; ?></td>
                                        <td><?php echo $visit['advance_date']; ?></td>
                                        <td><?php echo $visit['advance_comment']; ?></td>
                                        
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>

<script>
    $(document).ready(function () {

        $('#datepicker-autoclose').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });


       $('#datatable-buttons').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "stateSave": true,
            "dom": "Bfrtlip",
            "buttons": [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"}, {
                    extend: "excel",
                    className: "btn-sm btn-warning btn-trans"
                }, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}],
            "responsive": !0
            });
        

        

        toastr.options = {
            "closeButton": true,
            "debug": true,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-bottom-center",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        $(".numeric").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    });

</script>