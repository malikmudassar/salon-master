<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datetimepicker/js/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Business Timing Settings:</h4>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-sm-2 col-md-3"></div>
                        <div class="col-sm-4 col-md-3">
                            <div class="p-20">
                                <input type="hidden" id="s" value="<?php echo $time->business_opening_time; ?>">
                                <input type="hidden" id="e" value="<?php echo $time->business_closing_time; ?>">
                                <h5><b>Opening Time</b></h5>
                                <input type="text" class="form-control" name="start" id="start" value="<?php echo $time->business_opening_time; ?>" placeholder="example 09:00">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3">
                            <div class="p-20">
                                <h5><b>Closing Time</b></h5>
                                <input type="text" class="form-control" name="end" id="end" value="<?php echo $time->business_closing_time; ?>" placeholder="example 20:00">
                                <div class="m-t-20 pull-right"> 
                                    <button id="update" onclick="update_business_time();" type="button" class="btn btn-custom waves-effect waves-light w-md m-b-5">Update</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-3"></div>
                    </div><!-- end row -->
                </div>
            </div><!-- end col -->
        </div>
    </div>

    <script>
        $(document).ready(function() {
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
            
            $("#start").datetimepicker({
                format: 'HH:mm',
                allowInputToggle: true
            });
            $("#end").datetimepicker({
                format: 'HH:mm',
                allowInputToggle: true
            });
        });

        function update_business_time() {
            
            var start_time = $("#start").val();
            var end_time = $("#end").val();
            
            if(start_time === "" || end_time === ""){
                return false;
            }
            
            if($('#s').val() === start_time && $('#e').val() === end_time){
                return false;
            }
            
            $('#update').html('<i class="fa fa-spinner fa-spin"></i>');
            $('#update').addClass('disabled');

            $.ajax({
                
                type: 'POST',
                url: 'Welcome/update_business_timing',
                data: 'start=' +start_time+ '&end=' +end_time,
                
                success: function(response) {
                    
                    if(response === 'success'){
                        
                        toastr.success(response, 'Business Time Updated');
                        
                        $('#update').html('Update');
                        $('#update').removeClass('disabled');
                        
                        $("#s").val(start_time);
                        $("#e").val(end_time);
                        
                    }
                    
                }
                
            });
            
        }
    </script>