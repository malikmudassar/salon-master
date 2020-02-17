<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">

                <h4 class="page-title">Un-Invoiced Visits:</h4>
            </div>
        </div>

          <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                    <table id="tblappointments" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Visit ID</th>
                                <th>Customer</th>
                                <th>Cell</th>
                                <th>Visit Start</th> 
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($visits as $visit){?>
                            <tr>
                                <td><?php echo $visit['id_customer_visits'];?></td>
                                <td customerid="<?php echo $visit['id_customers'];?>"><?php echo $visit['customer_name'];?></td>
                                <td><?php 
                                                if( $this->session->userdata('hide_cell') && $this->session->userdata('hide_cell') == "No"){
                                                    echo $visit['customer_cell'];
                                                } 
                                            ?>
                                    
                                    
                                    </td>
                                <td visitstart="<?php echo $visit['visit_service_start'];?>"><?php echo $visit['mDate'];?></td>
                                <td><form method="post" action="<?php echo base_url();?>welcome/scheduler"><input type="hidden" class="open_csrf" name="csrf_test_name" value=""><input name="defaultDate" type="hidden" value="<?php echo $visit['visit_service_start'];?>" /><button type="submit" onclick="$('.open_csrf').val($('#cook').val());" class="btn btn-icon waves-effect waves-light btn-info m-b-5">open</button></form></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Visit ID</th>
                                <th>Customer</th>
                                <th>Cell</th>
                                <th>Visit Start</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
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
