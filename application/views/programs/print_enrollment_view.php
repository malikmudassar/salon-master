<style>
        .table1{}
        .table1 td{
            border-top: none !important;
            padding:1px 8px 1px 8px !important;
        }
</style>  
<div class="wrapper">
            <div class="container">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">Program Enrollment </h4>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="pull-left">
                                        <h3 class="logo invoice-logo"><?php if(isset($business)){ if(isset($business[0]['business_logo1'])){echo "<img src='".base_url().'assets/images/business/'.$business[0]['business_logo1']."' alt='".$business[0]['business_name']."' class='img-responsive' />";}else{echo "<img src='".base_url().'assets/images/business/'.$business[0]['business_logo']."' alt='".$business[0]['business_name']."' class='img-responsive' />"; }} else {echo 'SkedWise';}?></h3>
                                    </div>
                                    <div class="pull-right">
                                        
                                        <table class="table table1" style="border:none !important;">
                                            <tr>
                                                <td style="border-right:1px solid #f7f7f7; color:#797979; text-align: right; vertical-align: bottom;">Date</td>
                                                <td style="color: #000; font: normal normal 16px/16px arial, serif; vertical-align: middle;"><?php if(isset($program_enrollment)){ echo $program_enrollment[0]['f_start_date'];} ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border-right:1px solid #f7f7f7; color:#797979; text-align: right">Student</td>
                                                <td style="color:#000;"><?php if(isset($program_enrollment)){ echo sprintf("%04s",$program_enrollment[0]['id_program_enrollment']);}else{echo '00001';} ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border-right:1px solid #f7f7f7; color:#797979; text-align: right">Contact</td>
                                                <td style="color:#000;">Academy Manager</td>
                                            </tr>
                                            <tr>
                                                <td style="border-right:1px solid #f7f7f7; color:#797979; text-align: right"></td>
                                                <td style="color:#000;"><?php if(isset($business)){ echo $business[0]['business_email'];}?></td>
                                            </tr>
                                            <tr>
                                                <td style="border-right:1px solid #f7f7f7; color:#797979; text-align: right"></td>
                                                <td style="color:#000;"><?php if(isset($business)){ echo $business[0]['business_phone2'];}?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                
                                <div class="row">
                                    <div class="col-md-12 m-t-40">
                                        <div class="pull-left">

                                        </div>
                                        <div class="pull-right">
                                            <span style="color: #000; font: normal normal 16px/16px arial, serif;  text-transform: uppercase;"><?php echo $program_enrollment[0]['customer_name']; ?></span><br>
                                            <span style="color: #000; font: normal normal 16px/16px arial, serif;  text-transform: uppercase;"><?php echo $program_enrollment[0]['customer_address']; ?></span><br>
                                            <span style="color: #000; font: normal normal 16px/16px arial, serif;  text-transform: uppercase;"><?php echo $program_enrollment[0]['customer_cell']; ?></span><br>
                                            
                                            
                                            <br>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row" style="color:#000 !important">
                                    <div class="col-md-12 m-t-10">
                                        <span style="font: normal bold 22px/40px arial, serif">ENROLLMENT DETAILS</span>
                                    </div>
                                    <div class="col-md-3 ">
                                        <input name="programsessionid" id="programsessionid" type="hidden" value="<?php echo $program_enrollment[0]['id_program_sessions']; ?>"/>
                                        <input name="customerid" id="customerid" type="hidden" value="<?php echo $program_enrollment[0]['id_customers']; ?>">
                                        <input name="customername" id="customername" type="hidden" value="<?php echo $program_enrollment[0]['customer_name']; ?>">
                                        
                                        
                                        <table class="table table1 m-t-20">
                                            <tr>
                                                <td>Enrolled On</td>
                                                <td><strong><?php if(isset($program_enrollment)){ echo $program_enrollment[0]['f_start_date'];} ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>Session</td>
                                                <td><strong><?php if(isset($program_enrollment)){ echo $program_enrollment[0]['session_name'];} ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>Age</td>
                                                <td><strong><?php if(isset($program_enrollment)){ echo $program_enrollment[0]['age'];} ?></strong></td>
                                            </tr>
                                            <?php if(isset($program_enrollment) && isset($program_enrollment[0]['height'])){ ?>
                                            <tr>
                                                <td>Height</td>
                                                <td><strong><?php echo $program_enrollment[0]['height']; ?></strong></td>
                                            </tr>
                                            <?php } ?>
                                            <?php if(isset($program_enrollment) && isset($program_enrollment[0]['bmi'])){ ?>
                                            <tr>
                                                <td>BMI</td>
                                                <td><strong><?php echo $program_enrollment[0]['bmi']; ?></strong></td>
                                            </tr>
                                            <?php } ?>
                                            <?php if(isset($program_enrollment) && isset($program_enrollment[0]['education'])){ ?>
                                            <tr>
                                                <td>Last Level of Education</td>
                                                <td><strong><?php if(isset($program_enrollment)){ echo $program_enrollment[0]['education'];} ?></strong></td>
                                            </tr>
                                            <?php } ?>
                                            <?php if(isset($program_enrollment) && isset($program_enrollment[0]['beuatyeducation'])){ ?>
                                            <tr>
                                                <td>Beauty Eduction</td>
                                                <td><strong><?php if(isset($program_enrollment)){ echo $program_enrollment[0]['beuatyeducation'];} ?></strong></td>
                                            </tr>
                                            <?php } ?>
                                         
                                        </table>
                                    </div>
                                    <div class="col-md-9 m-t-20">
                                        <p>Program Name    : <strong><?php echo $program_enrollment[0]['program_type']; ?> - <?php echo $program_enrollment[0]['program']; ?></strong><br/>
                                           Session Duration: <strong><?php echo $program_enrollment[0]['f_program_session_start']; ?> To <?php echo $program_enrollment[0]['f_program_session_end']; ?></strong>
                                           
                                        </p>
                                        <?php if($program_enrollment[0]['id_program_types']==1){?>
                                        <table id="gym_table" class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th colspan="4">
                                                       Current Body Measurements and Goals: 
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <tr>
                                                    <td colspan="2">
                                                        <strong>Current:</strong>
                                                    </td>
                                                    <td colspan="2">
                                                        <strong>Goal:</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Weight:</td>
                                                    <td><?php echo $program_enrollment[0]['current_weight']; ?></td>
                                                    <td>Weight:</td>
                                                    <td><?php echo $program_enrollment[0]['weight_goal']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Waist:</td>
                                                    <td><?php echo $program_enrollment[0]['current_waist']; ?></td>
                                                    <td>Waist:</td>
                                                    <td><?php echo $program_enrollment[0]['waist_goal']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Arms:</td>
                                                    <td><?php echo $program_enrollment[0]['current_arms']; ?></td>
                                                    <td>Arms:</td>
                                                    <td><?php echo $program_enrollment[0]['arms_goal']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Thighs:</td>
                                                    <td><?php echo $program_enrollment[0]['current_thighs']; ?></td>
                                                    <td>Thighs:</td>
                                                    <td><?php echo $program_enrollment[0]['thighs_goal']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Hips:</td>
                                                    <td><?php echo $program_enrollment[0]['current_hips']; ?></td>
                                                    <td>Hips:</td>
                                                    <td><?php echo $program_enrollment[0]['hips_goal']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Chest:</td>
                                                    <td><?php echo $program_enrollment[0]['current_chest']; ?></td>
                                                    <td>Chest:</td>
                                                    <td><?php echo $program_enrollment[0]['chest_goal']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?php } elseif($program_enrollment[0]['id_program_types']==2) { ?>
                                        <table id="gym_table" class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">
                                                       Current Level and Goals: 
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <tr>
                                                    <td width="25%">Previous Beauty Education:</td>
                                                    <td><?php echo $program_enrollment[0]['beautyeducation']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Previous Beauty Experience:</td>
                                                    <td><?php echo $program_enrollment[0]['beautyexperience']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Goals:</td>
                                                    <td><?php echo $program_enrollment[0]['goals']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?php } ?>
                                    </div>
                                </div><!-- end row -->
                                <div class="row">
                                    <div class="col-xs-12" >
                                        <p style="padding-left:10px;">Schedule : 
                                            <?php foreach($program_schedule as $days){?>
                                            <?php echo '<b>'.$days['weekdays'].'</b> '.$days['start'].'-'.$days['end'].' | ';?>
                                            <?php } ?>
                                        </p>
                                    </div>
                                </div>
                                <br>
                              
                                <hr>
                                <div class="hidden-print">
                                    <div class="pull-right">
                                        
                                        <a type="submit" href="<?php echo base_url().'print_program_invoice/'.$program_enrollment[0]['id_program_enrollment'] ;?>" class="btn btn-primary waves-effect waves-light" id="btnpayment"><i class="fa fa-dollar"></i> Payments</a>
                                        <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light" id="btnprint"><i class="fa fa-print"></i></a>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- end row -->
    