

<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">

                </div>
                <h4 class="page-title">Program Members (<?php echo $business[0]['business_name'];?>):</h4>
            </div>
        </div>

        
             <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <h4 class="header-title m-t-0 m-b-30">Filters:</h4>
                    <form action="<?php echo base_url();?>program_members" method="post">
                        <input type="hidden" name="csrf_test_name" id="members_csrf" value=""/>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">Select Program Type:</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <select onchange="get_active_programs();" class="form-control" id="programtypes" name="programtypes">
                                                <option >All</option>
                                                <?php foreach ($program_types as $pt) { ?>
                                                    <option <?php if($program_type===$pt['id_program_types']){echo 'selected="selected"';}?> value="<?php echo $pt['id_program_types']; ?>"><?php echo $pt['program_type']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">Select Program:</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <select onchange="get_active_sessions();" class="form-control" id="activeprograms" name="activeprograms">
                                                <option value="">All</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">Select Program Session:</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"> 
                                            <select class="form-control" id="activeprogramsessions" name="activeprogramsessions" >
                                                <option value="">All</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="col-lg-2">
                                    <div class="row">
                                        <div class="col-lg-12"> <label class="control-label">Get Members</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" > 
                                            <button onclick="$('#members_csrf').val($('#cook').val());"  type="submit" class="btn btn-pink btn-bordred waves-effect w-md waves-light m-b-5">Run</button>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><i id="cog" class="fa fa-spin fa-cog" style="display:none; font-size:26px;width: auto;margin-right: 10px;"></i></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <h4 class="header-title m-t-0 m-b-30"></h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Customer Cell</th>
                                        <th>Program Type</th>
                                        <th>Program</th>
                                        <th>Session</th>
                                        <th>Enrolled On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($program_members as $pm){ ?>
                                    <tr>
                                        <td>
                                            <?php echo $pm['customer_name'];?>
                                        </td>
                                        <td>
                                            <?php echo $pm['customer_cell'];?>
                                        </td>
                                        <td>
                                            <?php echo $pm['program_type'];?>
                                        </td>
                                        <td>
                                            <?php echo $pm['program'];?>
                                        </td>                                        
                                        <td>
                                            <?php echo $pm['session_name'];?>
                                        </td>
                                        <td>
                                            <?php echo $pm['start_date'];?>
                                        </td>                                        
                                        <td class='noprint'> 
                                            <a href="<?php echo base_url(); ?>print_enrollment/<?php echo $pm['id_program_enrollment']; ?>" class="btn btn-icon waves-effect waves-light btn-warning m-b-5"> <i class="fa fa-file"></i> Form</a>  
                                            <?php if($pm['program_type']=='Recurring Payments'){?>
                                                <a href="<?php echo base_url(); ?>print_due_invoice/<?php echo $pm['id_program_enrollment']; ?>" class="btn btn-icon waves-effect waves-light btn-success m-b-5"> <i class="fa fa-dollar"></i> Invoice</a>  
                                            <?php } else {?>
                                                <a href="<?php echo base_url(); ?>print_program_invoice/<?php echo $pm['id_program_enrollment']; ?>" class="btn btn-icon waves-effect waves-light btn-success m-b-5"> <i class="fa fa-dollar"></i> Invoice</a>  
                                            <?php } ?>    
                                        </td>           
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
    
    $('document').ready(function(){
       
       get_active_programs(<?php echo $program_type; ?>);
       get_active_sessions(<?php if(isset($selected_program)){echo $selected_program; }?>);
       
       
       $('#datatable-buttons').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "stateSave": true,
                "dom": "Bfrtlip",
                "buttons": [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"}, {
                        extend: "excel",
                        className: "btn-sm btn-warning btn-trans"
                    }, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}],
                "responsive": !0,
		"order": [[ 1, 'asc' ]],
		"displayLength": 25
		
            });
    });
    
    function get_active_programs(val){
        console.log(val);
        if(val==="" || typeof val === 'undefined'){val=$("#programtypes option:selected").val();}
        
        $("#activeprograms").html('<option></option>');
         
         $.ajax({
            type: 'POST',
            url: "<?php echo base_url() . 'programs_controller/get_active_programs'; ?>",
            data: {programtypeid: val},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
               
                var mhtml = '';
                for (x = 0; x < data.length; x++) {
                    mhtml+='<option value="'+ data[x]['id_programs'] +'">'+ data[x]['program'] + '</option>';
                }
                
                $("#activeprograms").append(mhtml);
            }
        });
    
    }
    function get_active_sessions(val){
    
        if(val==="" || typeof val === 'undefined'){val=$("#activeprograms option:selected").val();}
        
        $("#activeprogramsessions").html('<option></option>');
         
         
         
         $.ajax({
            type: 'POST',
            url: "<?php echo base_url() . 'programs_controller/get_active_sessions'; ?>",
            data: {programid: val},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
               
                var mhtml = '';
                for (x = 0; x < data.length; x++) {
                    mhtml='<option value="'+ data[x]['id_program_sessions'] +'">' + data[x]['session_name'] + ' / ' + data[x]['start'] +' - ' + data[x]['end'] + '</option>'
                }
                
                $("#activeprogramsessions").append(mhtml);
            }
        });
        
    }
    
</script>