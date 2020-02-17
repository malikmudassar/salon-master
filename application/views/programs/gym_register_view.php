<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Enroll Gym Customer:</h4>
            </div>
        </div>
        <?php if ($this->session->flashdata('Success') && $this->session->flashdata('Success') != "") { ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Success!</strong> <?php echo $this->session->flashdata('Success'); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('Error') && $this->session->flashdata('Error') != "") { ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Error!</strong> <?php echo $this->session->flashdata('Error'); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <h4 class="header-title m-t-0 m-b-30"></h4>
                    <form method="post" action="<?php echo base_url(); ?>gym_controller/enroll_customer">
                        <input type="hidden" name="csrf_test_name" id="gym_customer_csrf" value=""/>
                        <div class="form-group">
                             <div class="divider"></div>
                             <div class="row">
                                <div class="col-lg-12">
                                    <h3 class="title text-primary"><strong>Customer Details:</strong></h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="txtcustomername" class="control-label"><span class='text-pink'>*</span> Name</label>
                                        <input type="hidden" class="form-control" placeholder="Customer ID" id="txtcustomerid" name="txtcustomerid" value="<?php if(isset($customer)){ echo $customer[0]['id_customers'];}?>">
                                        <input tabindex="1" type="text" class="form-control" placeholder="Customer Name" id="txtcustomername" name="txtcustomername" value="<?php if(isset($customer)){ echo $customer[0]['customer_name'];}?>" required="required">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcustomercell" class="control-label"><span class='text-pink'>*</span> Cell</label>
                                            <input tabindex="2" type="text" class="form-control numeric" placeholder="Customer Cell" id="txtcustomercell" name="txtcustomercell" value="<?php if(isset($customer)){ echo $customer[0]['customer_cell'];}?>" requried='required'>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="txtcustomerphone1" class="control-label">Phone 1</label>
                                        <input tabindex="3" type="text" class="form-control numeric" placeholder="Customer Phone 1" id="txtcustomerphone1" name="txtcustomerphone1" value="<?php if(isset($customer)){ echo $customer[0]['customer_phone1'];}?>">
                                    </div>                                    
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="txtcustomerphone2" class="control-label">Phone 2</label>
                                        <input tabindex="4" type="text" class="form-control numeric" placeholder="Customer Phone 2" id="txtcustomerphone2" name="txtcustomerphone2" value="<?php if(isset($customer)){ echo $customer[0]['customer_phone2'];}?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="txtcustomergender" class="control-label">Gender</label>
                                        <select tabindex="2" type="text" class="form-control numeric" placeholder="Gender" id="txtcustomergender" name="txtcustomergender" >
                                            <option value="F" <?php if(isset($customer) && $customer[0]['customer_gender']==="F"){ echo "selected";}?>>Female</option>
                                            <option value="M" <?php if(isset($customer) && $customer[0]['customer_gender']==="M"){ echo "selected";}?>>Male</option>
                                        </select>
                                    </div> 
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="txtcustomertype" class="control-label">Type</label>
                                        <select tabindex="5" name="txtcustomertype" id="txtcustomertype" class="form-control">
                                           
                                            <option value=""></option>
                                            <option value="orange" <?php if(isset($customer) && $customer[0]['customer_type']=="orange"){echo "selected='selected'";}?>><i style="color:orange" class="ti-star"></i> (Orange) High Priority Customer</option>
                                            <option value="green" <?php if(isset($customer) && $customer[0]['customer_type']=="green"){echo "selected='selected'";}?>><i class="ti-face-smile"></i> (Green) General Customer</option>
                                            <option value="red" <?php if(isset($customer) && $customer[0]['customer_type']=="red"){echo "selected='selected'";}?>><i class="ti-hand-stop"></i> (Red) Flagged Customer</option>
                                                    
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="txtcustomercard" class="control-label">Card #</label>
                                        <input tabindex="4" type="text" class="form-control numeric" placeholder="Customer Card#" id="txtcustomercard" name="txtcustomercard" value="<?php if(isset($customer)){ echo $customer[0]['customer_card'];}?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="txtcustomerprofession" class="control-label">Profession</label>
                                        <input tabindex="6" type="text" class="form-control" placeholder="Customer Profession" id="txtcustomerprofession" name="txtcustomerprofession" value="<?php if(isset($customer)){ echo $customer[0]['profession'];}?>">
                                    </div> 
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="txtcustomeremail" class="control-label">Email</label>
                                        <input tabindex="7" type="email" class="form-control " placeholder="Customer Email" id="txtcustomeremail" name="txtcustomeremail" value="<?php if(isset($customer)){ echo $customer[0]['customer_email'];}?>">
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="txtcustomeraddress" class="control-label">Address</label>
                                        <input tabindex="8" type="text" class="form-control " placeholder="Customer Address" id="txtcustomeraddress" name="txtcustomeraddress" value="<?php if(isset($customer)){ echo $customer[0]['customer_address'];}?>">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="txtcustomeranniversary" class="control-label">Wedding Anniversary</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <input tabindex="9" type="text" class="form-control" placeholder="yyyy/mm/dd" id="txtcustomeranniversary" name="txtcustomeranniversary" value="<?php if(isset($customer)){ echo $customer[0]['customer_anniversary'];}?>">
                                                <span class="input-group-addon bg-info b-0 text-white"><i class="ti-calendar"></i></span>
                                            </div><!-- input-group -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3">
                                     <div class="form-group">
                                        <div class="col-lg-12">
                                            <label for="txtcustomerbirthday" class="control-label">Birthday</label>
                                        </div>
                                        <div class="col-lg-4">
                                            <select tabindex="10" id="txtcustomerbirthday" name="txtcustomerbirthday" class="form-control">
                                                <option value=""></option>
                                                <?php $x=1; while($x <= 31) {?>
                                                    <option value='<?php echo $x;?>' <?php if(isset($customer) && $customer[0]['customer_birthday']==$x){echo "selected='selected'";}?>><?php echo $x;?></option>                                                    
                                                <?php $x++; } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-8">
                                            <select tabindex="11" id="txtcustomerbirthmonth" name="txtcustomerbirthmonth" class="form-control">
                                                <option value=""></option>
                                                <option value="January" <?php if(isset($customer) && $customer[0]['customer_birthmonth']=="January"){echo "selected='selected'";}?>>January</option>
                                                <option value="February" <?php if(isset($customer) && $customer[0]['customer_birthmonth']=="February"){echo "selected='selected'";}?>>February</option>
                                                <option value="March" <?php if(isset($customer) && $customer[0]['customer_birthmonth']=="March"){echo "selected='selected'";}?>>March</option>
                                                <option value="April" <?php if(isset($customer) && $customer[0]['customer_birthmonth']=="April"){echo "selected='selected'";}?>>April</option>
                                                <option value="May" <?php if(isset($customer) && $customer[0]['customer_birthmonth']=="May"){echo "selected='selected'";}?>>May</option>
                                                <option value="June" <?php if(isset($customer) && $customer[0]['customer_birthmonth']=="June"){echo "selected='selected'";}?>>June</option>
                                                <option value="July" <?php if(isset($customer) && $customer[0]['customer_birthmonth']=="July"){echo "selected='selected'";}?>>July</option>
                                                <option value="August" <?php if(isset($customer) && $customer[0]['customer_birthmonth']=="August"){echo "selected='selected'";}?>>August</option>
                                                <option value="September" <?php if(isset($customer) && $customer[0]['customer_birthmonth']=="September"){echo "selected='selected'";}?>>September</option>
                                                <option value="October" <?php if(isset($customer) && $customer[0]['customer_birthmonth']=="October"){echo "selected='selected'";}?>>October</option>
                                                <option value="November" <?php if(isset($customer) && $customer[0]['customer_birthmonth']=="November"){echo "selected='selected'";}?>>November</option>
                                                <option value="December" <?php if(isset($customer) && $customer[0]['customer_birthmonth']=="December"){echo "selected='selected'";}?>>December</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="txtcustomerallergies" class="control-label text-danger">Allergies Alert</label>
                                        <input tabindex="12" type="text" class="form-control " placeholder="Note down any allergies the customer may have" id="txtcustomerallergies" name="txtcustomerallergies" value="<?php if(isset($customer)){ echo $customer[0]['customer_allergies'];}?>">
                                    </div> 
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="txtcustomeralert" class="control-label text-warning">Customer Alert</label>
                                        <input tabindex="13" type="text" class="form-control " placeholder="Note down any other alerts you want to get when the customer visits . . ." id="txtcustomeralert" name="txtcustomeralert" value="<?php if(isset($customer)){ echo $customer[0]['customer_alert'];}?>">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    
                                </div>
                            </div>
                            <!----Gym Items--->
                             <div class="divider"></div>
                             <div class="row">
                                <div class="col-lg-12">
                                    <h3 class="title text-primary"><strong>Gym Related Info:</strong></h3>
                                </div>
                            </div>
                            <div class="row m-t-20 m-b-20">
                                <div class="col-lg-12">
                                   <h4 class="title txt-primary" ><strong style='border-bottom: #808080 solid 1px '>Basic Info:</strong></h4>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="txtemergencyperson" class="control-label "><span class="text-pink">*</span> Emergency Contact Person</label>
                                        <input tabindex="14" type="text" class="form-control" placeholder="Emergency Contact Person" id="txtemergencynumber" name="txtemergencyperson" required="required" value="<?php if(isset($customer)){ echo $customer[0]['emergency_contact_person'];}?>">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="txtemergencynumber" class="control-label "><span class="text-pink">*</span> Emergency Contact Number</label>
                                        <input tabindex="15" type="text" class="form-control numeric" placeholder="Emergency Contact Number" id="txtemergencynumber" name="txtemergencynumber" required="required" value="<?php if(isset($customer)){ echo $customer[0]['emergency_contact_number'];}?>">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="txtage" class="control-label ">Age</label>
                                        <input tabindex="16" type="text" class="form-control numeric" placeholder="Age" id="txtage" name="txtage" value="<?php if(isset($customer)){ echo $customer[0]['age'];}?>">
                                    </div>
                                </div>
                               
                           
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="txtheight" class="control-label">Height</label>
                                        <input tabindex="17" type="text" class="form-control decimal" placeholder="Height" id="txtheight" name="txtheight" value="<?php if(isset($customer)){ echo $customer[0]['height'];}?>">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="txtbmi" class="control-label ">BMI</label>
                                        <input tabindex="18" type="text" class="form-control decimal" placeholder="Body Mass Index" id="txtbmi" name="txtbmi" value="<?php if(isset($customer)){ echo $customer[0]['bmi'];}?>">
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="row m-t-20 m-b-20">
                                <div class="col-lg-12">
                                   <h4 class="title txt-primary" ><strong style='border-bottom: #808080 solid 1px '>Customer's Current Status:</strong></h4>
                                </div>
                            </div>
                             
                            <div class="row">
                                 <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="txtweight" class="control-label ">Weight</label>
                                        <input tabindex="19" type="text" class="form-control decimal" placeholder="Current Weight" id="txtweight" name="txtweight">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="txtarms" class="control-label">Arms</label>
                                        <input tabindex="21" type="text" class="form-control decimal" placeholder="Current Arms" id="txtarms" name="txtarms">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="txtthighs" class="control-label">Thighs</label>
                                        <input tabindex="22" type="text" class="form-control decimal" placeholder="Current Thighs" id="txtthighs" name="txtthighs">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="txthips" class="control-label">Hips</label>
                                        <input tabindex="23" type="text" class="form-control decimal" placeholder="Current Hips" id="txthips" name="txthips">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="txtchest" class="control-label">Chest</label>
                                        <input tabindex="24" type="text" class="form-control decimal" placeholder="Current Chest" id="txtchest" name="txtchest">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="txtwaist" class="control-label">Waist</label>
                                        <input tabindex="25" type="text" class="form-control decimal" placeholder="Current Waist" id="txtwaist" name="txtwaist">
                                    </div>
                                </div>
                            </div>
                            <!--current-->
                            
                            <div class="row m-t-20 m-b-20">
                                <div class="col-lg-12">
                                    <h4 class="title txt-primary" ><strong style='border-bottom: #808080 solid 1px '>Customer's Goals:</strong></h4>
                                </div>
                            </div>
                             
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="txtweightgoal" class="control-label ">Weight </label>
                                        <input tabindex="20" type="text" class="form-control decimal" placeholder="Weight Goal" id="txtage" name="txtweightgoal">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="txtarmsgoal" class="control-label">Arms</label>
                                        <input tabindex="21" type="text" class="form-control decimal" placeholder="Arms Goal" id="txtarmsgoal" name="txtarmsgoal">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="txtthighsgoal" class="control-label">Thighs</label>
                                        <input tabindex="22" type="text" class="form-control decimal" placeholder="Thighs Goal" id="txtthighsgoal" name="txtthighsgoal">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="txthipsgoal" class="control-label">Hips</label>
                                        <input tabindex="23" type="text" class="form-control decimal" placeholder="Hips Goal" id="txthipsgoal" name="txthipsgoal">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="txtchestgoal" class="control-label">Chest</label>
                                        <input tabindex="24" type="text" class="form-control decimal" placeholder="Chest Goal" id="txtchestgoal" name="txtchestgoal">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="txtwaistgoal" class="control-label">Waist</label>
                                        <input tabindex="25" type="text" class="form-control decimal" placeholder="Waist Goal" id="txtwaistgoal" name="txtwaistgoal">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row m-t-20 m-b-20">
                                <div class="col-lg-12">
                                   <h4 class="title txt-primary" ><strong style='border-bottom: #808080 solid 1px '>Program Enrollment:</strong></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="txtprograms" class="control-label">Program</label>                                    
                                    <select tabindex="26" id="txtprograms" name="txtprograms" class="form-control" onchange="getprogramsessions();" required="required">
                                        <option></option>
                                        <?php foreach($programs as $program){ ?>
                                        <option value="<?php echo $program['id_programs']; ?>"><?php echo $program['program']; ?></option>
                                        <?php } ?>
                                    </select>                                    
                                </div>
                                <div class="col-lg-3">
                                    <label for="txtprogramsessions" class="control-label">Session</label>
                                    <select tabindex="27" id="txtprogramsessions" name="txtprogramsessions" class="form-control" required="required">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <div class="col-sm-12">
                                        <label for="txtstartdate" class="control-label">Will Start On</label>
                                    </div>
                                    <div class="input-group">
                                        <input tabindex="28" type="text" class="form-control" placeholder="yyyy/mm/dd" id="txtstartdate" name="txtstartdate" required="required">
                                        <span class="input-group-addon bg-info b-0 text-white"><i class="ti-calendar"></i></span>
                                    </div><!-- input-group -->
                                </div>
                                <div class="col-lg-3"></div>

                            </div>
                            
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <div class="btn-group pull-right m-t-15">
                                        <a href="<?php echo base_url(); ?>coa" class="btn waves-effect waves-light btn-default m-t-20">Back</a>
                                        <button onclick="$('#gym_customer_csrf').val($('#cook').val());" class="btn waves-effect waves-light btn-pink m-t-20">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </div>
</div>

<script>
    $(document).ready(function () {

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

        $("#txtcustomeranniversary").datepicker({
            default: today,
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });

        $("#txtstartdate").datepicker({
            default: today,
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });

        $(".numeric").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
        $(".decimal").keypress(function(e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 13 && e.which != 8 && e.which != 0  && e.which != 46 && (e.which < 48 || e.which > 57) ) {
                
                return false;
            }
        });
    });

    function getprogramsessions(){
         $("#txtprogramsessions").html('<option></option>');
         
         $.ajax({
            type: 'POST',
            url: "<?php echo base_url() . 'programs_controller/get_active_sessions'; ?>",
            data: {programid: $("#txtprograms option:selected").val()},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
               
                var mhtml = '';
                for (x = 0; x < data.length; x++) {
                    mhtml='<option value="'+ data[x]['id_program_sessions'] +'">'+ data[x]['start'] +' - ' + data[x]['end'] + '</option>'
                }
                
                $("#txtprogramsessions").append(mhtml);
            }
        });
    }

</script>