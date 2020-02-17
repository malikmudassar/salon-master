<style>
    .table thead tr th{
        border-top:2px solid #eee;
        border-bottom:2px solid #eee;
        background: #fcfcfc;
    }
    .table tfoot tr th{
        border-top:2px solid #eee;
        border-bottom:2px solid #eee;
        background: #fcfcfc;
    }
</style>
<div class="wrapper">
    <div class="container-full">
        <div class="row m-t-20">
            <div class="col-md-12">
                <div class="panel panel-default m-t-20">
                    <div class="panel-body">
                        <div class="row">
                            <div class="pull-left" >
                                <h3 class="logo invoice-logo"><?php
                                    if (isset($business)) {
                                        echo "<img src='" . base_url() . 'assets/images/business/' . $business[0]['business_logo'] . "' alt='" . $business[0]['business_name'] . "' class='img-responsive' />";
                                    } else {
                                        echo 'SkedWise';
                                    }
                                    ?></h3>
                            </div>
                            <div class="m-t-20" >
                                <div class="col-md-10 hidden-print m-t-20">
                                    
                                </div>

                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <span class="text-success "><?php echo $this->session->flashdata('form-submit'); ?></span>
                                <span class="text-danger "><?php echo validation_errors(); ?></span>
                            </div>
                        </div>
                        <!-- end row -->

                        <?php echo form_open(base_url() . 'clinical-form/' . $customer['id_customers'], ['method' => 'POST', 'id' => 'FormSubmit']); ?>
                        <input type="hidden" name="csrf_test_name" id="daily_sheet_csrf" value=""/>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table m-t-10"  id='sheet1'>
                                <tr>
                                    <td colspan="4"><strong>Aspiration Form </strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table">
                                                    <tr>
                                                        <td colspan="6" class="bg-inverse">
                                                            <strong class="text-white">Personal Information</strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label>Do you have any history of allergy ? (Drugs/Food/Others)</label>
                                                        </td>
                                                        <td colspan="2">
                                                            <input <?php echo set_value('alergy') == "No" || (isset($clinical_info['alergy']) && $clinical_info['alergy'] == "No") ? "checked" : ""; ?> type="radio" name="alergy" id="alergy" value="No" /> No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input <?php echo set_value('alergy') == "Yes" || (isset($clinical_info['alergy']) && $clinical_info['alergy'] == "Yes") ? "checked" : ""; ?> type="radio" name="alergy" id="alergy" value="Yes" /> Yes (Please Specify) <input type="text" name="alergy_desc" value="<?php echo set_value('alergy_desc') ? set_value('alergy_desc') : $clinical_info['alergy_desc']; ?>" />
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="">Are you under any sort of medical treatment currently ?</label>
                                                        </td>
                                                        <td colspan="2">
                                                            <input <?php echo set_value('under_treatment') == "No" || (isset($clinical_info['under_treatment']) && $clinical_info['under_treatment'] == "No") ? "checked" : ""; ?> type="radio" name="under_treatment" id="under_treatment" value="No" /> No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input <?php echo set_value('under_treatment') == "Yes" || (isset($clinical_info['under_treatment']) && $clinical_info['under_treatment'] == "Yes") ? "checked" : ""; ?> type="radio" name="under_treatment" id="under_treatment" value="Yes" /> Yes (Please Specify) <input type="text" name="under_treatment_desc" value="<?php echo set_value('under_treatment_desc') ? set_value('under_treatment_desc') : $clinical_info['under_treatment_desc']; ?>" />
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="prefix">Salutation: (Mr./Mrs./Ms.)</label>
                                                        </td>
                                                        <td>
                                                            <select name="prefix" id="prefix">
                                                                <option <?php echo set_value('prefix') == "Mr" || (isset($clinical_info['prefix']) && $clinical_info['prefix'] == "Mr") ? "selected" : ""; ?> value="Mr">Mr</option>
                                                                <option <?php echo set_value('prefix') == "Mrs" || (isset($clinical_info['prefix']) && $clinical_info['prefix'] == "Mrs") ? "selected" : ""; ?> value="Mrs">Mrs</option>
                                                                <option <?php echo set_value('prefix') == "Ms" || (isset($clinical_info['prefix']) && $clinical_info['prefix'] == "Ms") ? "selected" : ""; ?> value="Ms">Ms</option>
                                                            </select>
                                                        </td>
                                                        <td><label for="name">Name:</label></td>
                                                        <td><input readonly value="<?php echo set_value('name') !== "" ? set_value('name') : $customer['customer_name']; ?>" name="name" id="name" type="text" style="width: 100%;" /><input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer['id_customers'] ?>" /></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="gender">Gender <span class="text-danger">*</span>:</label>
                                                        </td>
                                                        <td>
                                                            <input <?php echo set_value('gender') == "Male" || (isset($clinical_info['gender']) && $clinical_info['gender'] == "Male") ? "checked" : ""; ?> name="gender" id="gender" type="radio" value="Male" /> Male <input <?php echo set_value('gender') == "Female" || (isset($clinical_info['gender']) && $clinical_info['gender'] == "Female") ? "checked" : ""; ?> name="gender" id="gender" type="radio" value="Female" /> Female
                                                            <span class="text-danger"><?php echo form_error('gender'); ?></span>
                                                        </td>
                                                        <td>
                                                            <label for="date_of_birth">Date of Birth:</label>
                                                        </td>
                                                        <td>
                                                            <input value="<?php echo set_value('date_of_birth') ? set_value('date_of_birth') : $clinical_info['date_of_birth']; ?>" name="date_of_birth" id="date_of_birth" type="text" style="width: 100%;" />
                                                        </td>
                                                        <td>
                                                            <label for="age">Age <span class="text-danger">*</span>:</label>
                                                        </td>
                                                        <td>
                                                            <input value="<?php echo set_value('age') ? set_value('age') : $clinical_info['age']; ?>" name="age" id="age" type="text" style="width: 100%;" />
                                                            <span class="text-danger"><?php echo form_error('age'); ?></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="nationality">Nationality:</label>
                                                        </td>
                                                        <td>
                                                            <input value="<?php echo set_value('nationality') ? set_value('nationality') : $clinical_info['nationality']; ?>" name="nationality" id="nationality" type="text" style="width: 100%;" />
                                                        </td>
                                                        <td>
                                                            <label for="nic_number">National ID Card Number:</label>
                                                        </td>
                                                        <td>
                                                            <input maxlength="15" value="<?php echo set_value('nic_number') ? set_value('nic_number') : $clinical_info['nic_number']; ?>" name="nic_number" id="nic_number" type="text" style="width: 100%;" />
                                                        </td>
                                                        <td>
                                                            <label for="religion">Religion:</label>
                                                        </td>
                                                        <td>
                                                            <input value="<?php echo set_value('religion') ? set_value('religion') : $clinical_info['religion']; ?>" name="religion" id="religion" type="text" style="width: 100%;" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="martal_status">Marital Status:</label>
                                                        </td>
                                                        <td>
                                                            <select name="marital_status" id="marital_status">
                                                                <option <?php echo set_value('marital_status') == "single" || (isset($clinical_info['marital_status']) && $clinical_info['marital_status'] == "single") ? "selected" : ""; ?> value="single">Single</option>
                                                                <option <?php echo set_value('marital_status') == "married" || (isset($clinical_info['marital_status']) && $clinical_info['marital_status'] == "married") ? "selected" : ""; ?> value="married">Married</option>
                                                                <option <?php echo set_value('marital_status') == "divorced" || (isset($clinical_info['marital_status']) && $clinical_info['marital_status'] == "divorced") ? "selected" : ""; ?> value="divorced">Divorced</option>
                                                                <option <?php echo set_value('marital_status') == "widow" || (isset($clinical_info['marital_status']) && $clinical_info['marital_status'] == "widow") ? "selected" : ""; ?> value="widow">Widow</option>
                                                            </select>
                                                        </td>
                                                        <td>

                                                        </td>
                                                        <td>

                                                        </td>
                                                        <td>

                                                        </td>
                                                        <td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="bg-inverse">
                                                            <strong class="text-white">Contact Information</strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="permanent_address">Postal Address (Permanent) <span class="text-danger">*</span>:</label>
                                                        </td>
                                                        <td colspan="2">
                                                            <input value="<?php echo set_value('permanent_address') ? set_value('permanent_address') : $clinical_info['permanent_address']; ?>" name="permanent_address" id="permanent_address" type="text" style="width: 100%;" />
                                                            <span class="text-danger"><?php echo form_error('permanent_address'); ?></span>
                                                        </td>
                                                        <td>

                                                        </td>
                                                        <td>

                                                        </td>
                                                        <td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="temporary_address">Postal Address (Temporary):</label>
                                                        </td>
                                                        <td colspan="2">
                                                            <input value="<?php echo set_value('temporary_address') ? set_value('temporary_address') : $clinical_info['temporary_address']; ?>" name="temporary_address" id="temporary_address" type="text" style="width: 100%;" />
                                                        </td>
                                                        <td>

                                                        </td>
                                                        <td>

                                                        </td>
                                                        <td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="postal_code">Postal Code:</label>
                                                        </td>
                                                        <td>
                                                            <input value="<?php echo set_value('postal_code') ? set_value('postal_code') : $clinical_info['postal_code']; ?>" name="postal_code" id="postal_code" type="text" style="width: 100%;" />
                                                        </td>
                                                        <td>
                                                            <label for="city">City <span class="text-danger">*</span>:</label>
                                                        </td>
                                                        <td>
                                                            <input value="<?php echo set_value('city') ? set_value('city') : $clinical_info['city']; ?>" name="city" id="city" type="text" />
                                                            <span class="text-danger"><?php echo form_error('city'); ?></span>
                                                        </td>
                                                        <td>
                                                            <label for="province">Province:</label>
                                                        </td>
                                                        <td>
                                                            <input value="<?php echo set_value('province') ? set_value('province') : $clinical_info['province']; ?>" name="province" id="province" type="text" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="tel">Tel:</label>
                                                        </td>
                                                        <td>
                                                            <input value="<?php echo set_value('tel') ? set_value('tel') : $clinical_info['tel']; ?>" name="tel" class="numeric" maxlength="11" id="tel" type="text" style="width: 100%;" />
                                                        </td>
                                                        <td>
                                                            <label for="mobile">Mobile <span class="text-danger">*</span>:</label>
                                                        </td>
                                                        <td>
                                                            <input value="<?php echo set_value('mobile') ? set_value('mobile') : $clinical_info['mobile']; ?>" class="numeric" maxlength="11" name="mobile" id="mobile" type="text" />
                                                            <span class="text-danger"><?php echo form_error('mobile'); ?></span>
                                                        </td>
                                                        <td>
                                                            <label for="email">Email Address <span class="text-danger">*</span>:</label>
                                                        </td>
                                                        <td>
                                                            <input value="<?php echo set_value('email') ? set_value('email') : $clinical_info['email']; ?>" name="email" id="email" type="email" />
                                                            <span class="text-danger"><?php echo form_error('email'); ?></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="emergency_name">Emergency Name  <span class="text-danger">*</span>:</label>
                                                        </td>
                                                        <td>
                                                            <input value="<?php echo set_value('emergency_name') ? set_value('emergency_name') : $clinical_info['emergency_name']; ?>" name="emergency_name" id="emergency_name" type="text" style="width: 100%;" />
                                                            <span class="text-danger"><?php echo form_error('emergency_name'); ?></span>
                                                        </td>
                                                        <td>
                                                            <label for="emergency_contact_number">Contact Number <span class="text-danger">*</span>:</label>
                                                        </td>
                                                        <td>
                                                            <input class="numeric" value="<?php echo set_value('emergency_contact_number') ? set_value('emergency_contact_number') : $clinical_info['emergency_contact_number']; ?>" name="emergency_contact_number" id="emergency_contact_number" type="text" style="width: 100%;" />
                                                            <span class="text-danger"><?php echo form_error('emergency_contact_number'); ?></span>
                                                        </td>
                                                        <td>
                                                            <label for="relation_with_patient">Relationship with Patient <span class="text-danger">*</span>:</label>
                                                        </td>
                                                        <td>
                                                            <input value="<?php echo set_value('relation_with_patient') ? set_value('relation_with_patient') : $clinical_info['relation_with_patient']; ?>" name="relation_with_patient" id="relation_with_patient" type="text" />
                                                            <span class="text-danger"><?php echo form_error('relation_with_patient'); ?></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" class="bg-inverse">
                                                            <strong class="text-white">How did you hear about us</strong>
                                                        </td>
                                                    </tr>
                                                    <tr id="hearid">
                                                        <?php
                                                            $FriendsFamily = "";$SocialMedia = "";$MedicalConsultant = "";$OtherHear = "";
                                                            if(set_value('hear_about_us') == "Friends/Family" || $clinical_info['hear_about_us'] == "Friends/Family"){$FriendsFamily = "checked";}
                                                            else if(set_value('hear_about_us') == "Social Media" || $clinical_info['hear_about_us'] == "Social Media"){$SocialMedia = "checked";}
                                                            else if(set_value('hear_about_us') == "Medical Consultant" || $clinical_info['hear_about_us'] == "Medical Consultant"){$MedicalConsultant = "checked";}
                                                            else{$OtherHear = set_value('hear_about_us_other') ? set_value('hear_about_us_other') : $clinical_info['hear_about_us'];}
                                                        ?>
                                                        <td>
                                                            Friends/Family: <input <?php echo $FriendsFamily; ?> name="hear_about_us" id="hear_about_us" class="hear_about_us" type="radio" value="Friends/Family"/>
                                                        </td>
                                                        <td>
                                                            Social Media: <input <?php echo $SocialMedia; ?> name="hear_about_us" id="hear_about_us" class="hear_about_us" type="radio" value="Social Media" />
                                                        </td>
                                                        <td>
                                                            Medical Consultant: <input <?php echo $MedicalConsultant; ?> name="hear_about_us" id="hear_about_us" class="hear_about_us" type="radio" value="Medical Consultant" />
                                                        </td>
                                                        <td colspan="2">
                                                            Other: <input onchange="InputCheck(this.value, 'hear_about_us');" name="hear_about_us_other" id="hear_about_us_other" type="text" value="<?php echo $OtherHear; ?>" />
                                                        </td>
                                                        <td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" >
                                                            <strong style="color: black;">For patients who live outside karachi only: </strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <?php
                                                            $Medical = "";$Tourism = "";$Business = "";$OtherCity = "";
                                                            if(set_value('city_outside_patient') == "Friends/Family" || $clinical_info['city_outside_patient'] == "Medical"){$Medical = "checked";}
                                                            else if(set_value('city_outside_patient') == "Social Media" || $clinical_info['city_outside_patient'] == "Tourism"){$Tourism = "checked";}
                                                            else if(set_value('city_outside_patient') == "Medical Consultant" || $clinical_info['city_outside_patient'] == "Business"){$Business = "checked";}
                                                            else{$OtherCity = set_value('city_outside_patient_other') ? set_value('city_outside_patient_other') : $clinical_info['city_outside_patient'];}
                                                        ?>
                                                        <td>
                                                            <label for="city_outside_patient">What best describe the purpose of your visit to karachi ?</label> 
                                                        </td>
                                                        <td>
                                                            <label for="">Medical:</label> <input <?php echo $Medical; ?> name="city_outside_patient" id="city_outside_patient" class="city_outside_patient" type="radio" value="Medical" />
                                                        </td>
                                                        <td>
                                                            <label for="">Tourism:</label> <input <?php echo $Tourism; ?> name="city_outside_patient" id="city_outside_patient" class="city_outside_patient" type="radio" value="Tourism" />
                                                        </td>
                                                        <td>
                                                            <label for="">Business:</label> <input <?php echo $Business; ?> name="city_outside_patient" id="city_outside_patient" class="city_outside_patient" type="radio" value="Business" />
                                                        </td>
                                                        <td colspan="2">
                                                            <label for="">Other:</label> <input onchange="InputCheck(this.value, 'city_outside_patient');" name="city_outside_patient_other" id="city_outside_patient_other" type="text" value="<?php echo $OtherCity; ?>" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="patient_representative">Patient Representative <span class="text-danger">*</span>:</label>
                                                        </td>
                                                        <td colspan="2">
                                                            <input value="<?php echo set_value('patient_representative') ? set_value('patient_representative') : $clinical_info['patient_representative']; ?>" name="patient_representative" id="patient_representative" type="text" style="width: 100%;" />
                                                            <span class="text-danger"><?php echo form_error('patient_representative'); ?></span>
                                                        </td>
                                                        <td colspan="2">

                                                        </td>
                                                        <td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="representative_contact_number">Representative's Contact Number <span class="text-danger">*</span>:</label>
                                                        </td>
                                                        <td >
                                                            <input value="<?php echo set_value('representative_contact_number') ? set_value('representative_contact_number') : $clinical_info['representative_contact_number']; ?>" name="representative_contact_number" id="representative_contact_number" type="text" style="width: 100%;" />
                                                            <span class="text-danger"><?php echo form_error('representative_contact_number'); ?></span>
                                                        </td>
                                                        <td></td>
                                                        <td colspan="2">

                                                        </td>
                                                        <td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>

                                                        </td>
                                                        <td >

                                                        </td>
                                                        <td></td>
                                                        <td colspan="2">

                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="input_type" id="input_type" value="<?php echo $clinical_info['customer_id'] ? "update" : "insert" ?>" />
                                                            <input id="submitbutton" type="submit" onclick="$('#daily_sheet_csrf').val($('#cook').val());" name="submit" value="Submit" class="btn btn-primary btn-sm" />
                                                            <input type="reset" name="reset" class="btn btn-danger btn-sm" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>

                                        </div>


                                    </td>
                                </tr>

                            </table>
                            </div>
                        </div>
                        </form>
                        <!-- end row -->
                    </div>
                </div>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
                <script>
                    $(document).ready(function(){
                        $('.city_outside_patient').click(function(){
                            if($('.city_outside_patient').is(':checked')){
                                $('#city_outside_patient_other').val('');
                            }
                        });
                        $('.hear_about_us').click(function(){
                            if($('.hear_about_us').is(':checked')){
                                $('#hear_about_us_other').val('');
                            }
                        });
                        $('#nic_number').mask('99999-9999999-9',{numericInput:true});
                        $(".numeric").keypress(function (e) {
                            //if the letter is not digit then display error and don't type anything
                            if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                return false;
                            }
                        });
                        $("#date_of_birth").datepicker({
                            default: today,
                            autoclose: true,
                            todayHighlight: true,
                            format: 'yyyy-mm-dd'
                        });
                        
                    });
                    function InputCheck(val,classname){
                        if(val.length > 3){
                            $('.'+classname).prop('checked', false);

                        }
                    } 
                </script>