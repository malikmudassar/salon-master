<style>
    .icon {width:42px;}
     .item{text-align: right; font-size: 16px; padding-top:5px;}
    .headings {text-align: center; vertical-align: middle;}
    .next {margin-top:15px;}
    
    @media (max-width: 991px){
        .icon {width:32px;}
        .item{text-align: left;}
    }

</style>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <button type="button" onclick="location.assign('<?php echo base_url().'feedback/none/'.date('Y-m-d').'/service';?>');" class="btn btn-purple btn-rounded w-md waves-effect waves-light m-b-20">Back </button>
            </div>
            
        </div>
        <form method="Post" action="<?php echo base_url();?>feedback_controller/insert_feedback">
        <div class="row">
            
             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                 <div class="card-box">
                     <div class="row" >
                         <div class="row m-b-10">
                             <div class="col-md-12">
                                <h3>Please rate us on the following:</h3>
                                <input type="hidden" name="customerid" value="<?php echo $invoices[0]['customer_id'];?>">
                                <input type="hidden" name="invoiceid" value="<?php echo $invoices[0]['id_invoice'];?>">
                                <input type="hidden" name="visitid" value="<?php echo $invoices[0]['visit_id'];?>">
                             </div>
                         </div> 
                        <div class="row hidden-xs" >
                            <div class="col-md-2 col-sm-2 col-xs-2 headings"></div>
                            <div class="col-md-2 col-sm-2 col-xs-2 headings"><label class="control-label">Pathetic</label></div>
                            <div class="col-md-2 col-sm-2 col-xs-2 headings"><label class="control-label">Poor</label></div>
                            <div class="col-md-2 col-sm-2 col-xs-2 headings"><label class="control-label">Average</label></div>
                            <div class="col-md-2 col-sm-2 col-xs-2 headings"><label class="control-label">Good</label></div>
                            <div class="col-md-2 col-sm-2 col-xs-2 headings"><label class="control-label">Excellent</label></div>
                        </div>
                         <hr/>
                        <div class="row next" id="qos">
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <p class="item"  style="font-weight: bold; ">Quality of Service</p> <input type="hidden" id="txtqos" name="txtqos" />
                            </div>
                           <div class="col-md-2 col-sm-2 col-xs-2 headings">

                               <img onclick="select_this('qos','1');" class="icon icon-qos" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/angry_80x80.png' alt='pathetic' >
                           </div>
                           <div class="col-md-2 col-sm-2 col-xs-2 headings">

                               <img onclick="select_this('qos','2');"  class="icon icon-qos" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/sad-80x80.png' alt='poor' >
                           </div>
                            <div class="col-md-2 col-sm-2 col-xs-2 headings">
                                <img onclick="select_this('qos','3');"  class="icon icon-qos" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/puzzled80x80.png' alt='average' >
                           </div>
                           <div class="col-md-2 col-sm-2 col-xs-2 headings">
                               <img onclick="select_this('qos','4');"  class="icon icon-qos" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/happy-80x80.png' alt='good' >
                           </div>
                           <div class="col-md-2 col-sm-2 col-xs-2 headings">
                               <img onclick="select_this('qos','5');"  class="icon icon-qos" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/celebrity-80x80.png' alt='excellent' >
                           </div>
                        </div>
                         
                        <div class="row next" id="atmosphere">
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <p class="item"  style="font-weight: bold; ">Atmosphere</p> <input type="hidden" id="txtatmosphere" name="txtatmosphere" />
                            </div>
                           <div class="col-md-2 col-sm-2 col-xs-2 headings">

                               <img onclick="select_this('atmosphere','1');" class="icon icon-atmosphere" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/angry_80x80.png' alt='pathetic' >
                           </div>
                           <div class="col-md-2 col-sm-2 col-xs-2 headings">

                               <img onclick="select_this('atmosphere','2');"  class="icon icon-atmosphere" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/sad-80x80.png' alt='poor' >
                           </div>
                            <div class="col-md-2 col-sm-2 col-xs-2 headings">
                                <img onclick="select_this('atmosphere','3');"  class="icon icon-atmosphere" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/puzzled80x80.png' alt='average' >
                           </div>
                           <div class="col-md-2 col-sm-2 col-xs-2 headings">
                               <img onclick="select_this('atmosphere','4');"  class="icon icon-atmosphere" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/happy-80x80.png' alt='good' >
                           </div>
                           <div class="col-md-2 col-sm-2 col-xs-2 headings">
                               <img onclick="select_this('atmosphere','5');"  class="icon icon-atmosphere" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/celebrity-80x80.png' alt='excellent' >
                           </div>
                        </div>
                         
                        <div class="row next" id="experience">
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <p class="item"  style="font-weight: bold; ">Salon Experience</p> <input type="hidden" id="txtexperience" name="txtexperience" />
                            </div>
                           <div class="col-md-2 col-sm-2 col-xs-2 headings">

                               <img onclick="select_this('experience','1');" class="icon icon-experience" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/angry_80x80.png' alt='pathetic' >
                           </div>
                           <div class="col-md-2 col-sm-2 col-xs-2 headings">

                               <img onclick="select_this('experience','2');"  class="icon icon-experience" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/sad-80x80.png' alt='poor' >
                           </div>
                            <div class="col-md-2 col-sm-2 col-xs-2 headings">
                                <img onclick="select_this('experience','3');"  class="icon icon-experience" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/puzzled80x80.png' alt='average' >
                           </div>
                           <div class="col-md-2 col-sm-2 col-xs-2 headings">
                               <img onclick="select_this('experience','4');"  class="icon icon-experience" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/happy-80x80.png' alt='good' >
                           </div>
                           <div class="col-md-2 col-sm-2 col-xs-2 headings">
                               <img onclick="select_this('experience','5');"  class="icon icon-experience" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/celebrity-80x80.png' alt='excellent' >
                           </div>
                        </div>
                         
                        <div class="row next" id="vfm">
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <p class="item"  style="font-weight: bold; ">Value for Money</p> <input type="hidden" id="txtvfm" name="txtvfm" />
                            </div>
                           <div class="col-md-2 col-sm-2 col-xs-2 headings">

                               <img onclick="select_this('vfm','1');" class="icon icon-vfm" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/angry_80x80.png' alt='pathetic' >
                           </div>
                           <div class="col-md-2 col-sm-2 col-xs-2 headings">

                               <img onclick="select_this('vfm','2');"  class="icon icon-vfm" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/sad-80x80.png' alt='poor' >
                           </div>
                            <div class="col-md-2 col-sm-2 col-xs-2 headings">
                                <img onclick="select_this('vfm','3');"  class="icon icon-vfm" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/puzzled80x80.png' alt='average' >
                           </div>
                           <div class="col-md-2 col-sm-2 col-xs-2 headings">
                               <img onclick="select_this('vfm','4');"  class="icon icon-vfm" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/happy-80x80.png' alt='good' >
                           </div>
                           <div class="col-md-2 col-sm-2 col-xs-2 headings">
                               <img onclick="select_this('experience','5');"  class="icon icon-vfm" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/celebrity-80x80.png' alt='excellent' >
                           </div>
                        </div>
                    </div>
                     <hr/>
                     <div class="row m-t-20">
                         <div class="col-md-2">
                             <label class="control-label headings">Any Comments or Suggestions:</label>
                         </div>
                         <div class="col-md-10">
                             <textarea name="customer_comment" class="form-control"></textarea>
                         </div>
                     </div>
                 </div>
             </div>
        </div>
        
        <?php $serviceid= 0; foreach ($invoices as $invoice){ if($serviceid!==$invoice['id_invoice_details']){
            $serviceid=$invoice['id_invoice_details'];
            if($invoice['service_name']!==""){
            ?>
        <div class="row">
             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                 <div class="card-box">
                     <div class="row">
                         <div class="row m-b-10">
                             <div class="col-md-12">
                                 <input type="hidden" name="servicedetailid[]" value="<?php echo $invoice['id_invoice_details'];?>">
                                 <input type="hidden" name="serviceid[]" value="<?php echo $invoice['service_id'];?>">
                                 <input type="hidden" name="servicetype[]" value="<?php echo $invoice['service_type'];?>">
                                 <input type="hidden" name="servicecategory[]" value="<?php echo $invoice['service_category'];?>">
                                 <input type="hidden" name="servicename[]" value="<?php echo $invoice['service_name'];?>">
                                 <input type="hidden" name="staffid[]" value="<?php echo $invoice['staff_id'];?>">
                                 <input type="hidden" name="staff[]" value="<?php echo $invoice['staff'];?>">
                                 
                                 <h3>How pleased are you with your <span class="text-pink"> <?php echo $invoice['service_name'];?></span>?</h3>
                                 <h4>Performed by: <span class="text-pink"><?php echo $invoice['staff'];?></span></h4>
                             </div>
                         </div> 
                     </div>
                     
                     <hr/>
                    <div class="row next" id="expectation_<?php echo $invoice['id_invoice_details']?>">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <p class="item"  style="font-weight: bold; ">Did we meet your expectations?</p>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            <div class="radio radio-success">
                                <input value="Yes" id="expectation_<?php echo $invoice['id_invoice_details'];?>_yes" name="expectation_<?php echo $invoice['id_invoice_details'];?>[]" type="radio" checked="checked">
                                <label for="expectation_<?php echo $invoice['id_invoice_details'];?>_yes">
                                    Yes
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            <div class="radio radio-danger">
                                <input value="No" id="expectation_<?php echo $invoice['id_invoice_details'];?>_no" name="expectation_<?php echo $invoice['id_invoice_details'];?>[]" type="radio">
                                <label for="expectation_<?php echo $invoice['id_invoice_details'];?>_no">
                                    No
                                </label>
                            </div>
                        </div>
                         <div class="col-md-2 col-sm-2 col-xs-2 headings">
                             <div class="radio radio-default">
                                 <input value="Not Applicable" id="expectation_<?php echo $invoice['id_invoice_details'];?>_na" name="expectation_<?php echo $invoice['id_invoice_details'];?>[]" type="radio">
                                <label for="expectation_<?php echo $invoice['id_invoice_details'];?>_na">
                                    Not Applicable
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            
                        </div>
                    </div> 
                     
                    <div class="row next" id="skill_<?php echo $invoice['id_invoice_details']?>">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <p class="item"  style="font-weight: bold; ">How will you rate your stylist/ beautician on skills?</p> <input type="hidden" id="txtskill_<?php echo $invoice['id_invoice_details']?>" name="txtskill[]" value="0"/>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            <img onclick="select_this('skill_<?php echo $invoice['id_invoice_details']?>','1');" seq="1" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-skill skill1_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.3; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/star-yellow.png' alt='pathetic' >
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            <img onclick="select_this('skill_<?php echo $invoice['id_invoice_details']?>','2');" seq="2" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-skill skill2_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.3; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/star-yellow.png' alt='poor' >
                        </div>
                         <div class="col-md-2 col-sm-2 col-xs-2 headings">
                             <img onclick="select_this('skill_<?php echo $invoice['id_invoice_details']?>','3');" seq="3" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-skill skill3_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.3; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/star-yellow.png' alt='average' >
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            <img onclick="select_this('skill_<?php echo $invoice['id_invoice_details']?>','4');" seq="4" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-skill skill4_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.3; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/star-yellow.png' alt='good' >
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            <img onclick="select_this('skill_<?php echo $invoice['id_invoice_details']?>','5');" seq="5" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-skill skill5_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.3; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/star-yellow.png' alt='excellent' >
                        </div>
                    </div>  
                     
                    <div class="row next" id="hospitality_<?php echo $invoice['id_invoice_details']?>">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <p class="item"  style="font-weight: bold; ">How will you rate your stylist/ beautician on hospitality?</p> <input type="hidden" id="txthospitality_<?php echo $invoice['id_invoice_details']?>" name="txthospitality[]" value="0"/>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            <img onclick="select_this('hospitality_<?php echo $invoice['id_invoice_details']?>','1');" seq="1" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-hospitality hospitality1_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.3; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/star-yellow.png' alt='pathetic' >
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            <img onclick="select_this('hospitality_<?php echo $invoice['id_invoice_details']?>','2');" seq="2" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-hospitality hospitality2_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.3; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/star-yellow.png' alt='poor' >
                        </div>
                         <div class="col-md-2 col-sm-2 col-xs-2 headings">
                             <img onclick="select_this('hospitality_<?php echo $invoice['id_invoice_details']?>','3');" seq="3" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-hospitality hospitality3_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.3; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/star-yellow.png' alt='average' >
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            <img onclick="select_this('hospitality_<?php echo $invoice['id_invoice_details']?>','4');" seq="4" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-hospitality hospitality4_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.3; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/star-yellow.png' alt='good' >
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            <img onclick="select_this('hospitality_<?php echo $invoice['id_invoice_details']?>','5');" seq="5" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-hospitality hospitality5_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.3; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/star-yellow.png' alt='excellent' >
                        </div>
                    </div> 
                    
                    <div class="row next" id="knowledge_<?php echo $invoice['id_invoice_details']?>">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <p class="item"  style="font-weight: bold; ">How will you rate your stylist/ beautician on knowledge required for the job?</p> <input type="hidden" id="txtknowledge_<?php echo $invoice['id_invoice_details']?>" name="txtknowledge[]" value="0"/>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            <img onclick="select_this('knowledge_<?php echo $invoice['id_invoice_details']?>','1');" seq="1" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-knowledge knowledge1_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.3; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/star-yellow.png' alt='pathetic' >
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            <img onclick="select_this('knowledge_<?php echo $invoice['id_invoice_details']?>','2');" seq="2"  serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-knowledge knowledge2_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.3; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/star-yellow.png' alt='poor' >
                        </div>
                         <div class="col-md-2 col-sm-2 col-xs-2 headings">
                             <img onclick="select_this('knowledge_<?php echo $invoice['id_invoice_details']?>','3');" seq="3" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-knowledge knowledge3_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.3; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/star-yellow.png' alt='average' >
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            <img onclick="select_this('knowledge_<?php echo $invoice['id_invoice_details']?>','4');" seq="4" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-knowledge knowledge4_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.3; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/star-yellow.png' alt='good' >
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            <img onclick="select_this('knowledge_<?php echo $invoice['id_invoice_details']?>','5');" seq="5" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-knowledge knowledge5_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.3; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/star-yellow.png' alt='excellent' >
                        </div>
                    </div>  
                     
                    <div class="row next" id="information_<?php echo $invoice['id_invoice_details']?>">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <p class="item"  style="font-weight: bold; ">Did your stylist/ beautician give you adequate information on packages & pricing?</p>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            <div class="radio radio-success">
                                <input value="Yes" id="information_<?php echo $invoice['id_invoice_details'];?>_yes" name="information_<?php echo $invoice['id_invoice_details'];?>[]" type="radio" checked ="checked">
                                <label for="information_<?php echo $invoice['id_invoice_details'];?>_yes">
                                    Yes
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            <div class="radio radio-danger">
                                <input value="No" id="information_<?php echo $invoice['id_invoice_details'];?>_no" name="information_<?php echo $invoice['id_invoice_details'];?>[]" type="radio">
                                <label for="information_<?php echo $invoice['id_invoice_details'];?>_no">
                                    No
                                </label>
                            </div>
                        </div>
                         <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            <div class="radio radio-default">
                                <input value="Not Applicable" id="information_<?php echo $invoice['id_invoice_details'];?>_na" name="information_<?php echo $invoice['id_invoice_details'];?>[]" type="radio">
                                <label for="information_<?php echo $invoice['id_invoice_details'];?>_na">
                                    Not Applicable
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                           
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                           
                        </div>
                    </div>  
                    <div class="row next" id="satisfaction">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <p class="item"  style="font-weight: bold; ">Overall, how satisfied are you with your stylist / beautician?</p> <input type="hidden" id="txtsatisfaction_<?php echo $invoice['id_invoice_details']?>" name="txtsatisfaction[]" value="0"/>
                        </div>
                       <div class="col-md-2 col-sm-2 col-xs-2 headings">
                           <div class="row">
                               <div class="col-xs-12">
                                   Extremely Dissatisfied
                               </div>
                           </div>
                           <img onclick="select_this('satisfaction_<?php echo $invoice['id_invoice_details']?>','1');" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-satisfaction satisfaction1_<?php echo $invoice['id_invoice_details']?>" seq="1" serviceid="_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/angry_80x80.png' alt='extremely dissatisfied' > 
                       </div>
                       <div class="col-md-2 col-sm-2 col-xs-2 headings">
                           <div class="row">
                               <div class="col-xs-12">
                                   Somewhat Dissatisfied
                               </div>
                           </div>
                           <img onclick="select_this('satisfaction_<?php echo $invoice['id_invoice_details']?>','2');" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-satisfaction satisfaction2_<?php echo $invoice['id_invoice_details']?>" seq="2" serviceid="_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/sad-80x80.png' alt='somewhat dissatisfied' > 
                       </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 headings">
                            <div class="row">
                               <div class="col-xs-12">
                                   Moderately Satisfied
                               </div>
                           </div>
                            <img onclick="select_this('satisfaction_<?php echo $invoice['id_invoice_details']?>','3');" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-satisfaction satisfaction3_<?php echo $invoice['id_invoice_details']?>" seq="3" serviceid="_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/puzzled80x80.png' alt='moderatly satisfied' > 
                       </div>
                       <div class="col-md-2 col-sm-2 col-xs-2 headings">
                           <div class="row">
                               <div class="col-xs-12">
                                   Somewhat Satisfied
                               </div>
                           </div>
                           <img onclick="select_this('satisfaction_<?php echo $invoice['id_invoice_details']?>','4');" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-satisfaction satisfaction4_<?php echo $invoice['id_invoice_details']?>" seq="4" serviceid="_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/happy-80x80.png' alt='somewhat satisfied' > 
                       </div>
                       <div class="col-md-2 col-sm-2 col-xs-2 headings">
                           <div class="row">
                               <div class="col-xs-12">
                                   Extremely Satisfied
                               </div>
                           </div>
                           <img onclick="select_this('satisfaction_<?php echo $invoice['id_invoice_details']?>','5');" serviceid="_<?php echo $invoice['id_invoice_details']?>" class="icon icon-satisfaction satisfaction5_<?php echo $invoice['id_invoice_details']?>" seq="5" serviceid="_<?php echo $invoice['id_invoice_details']?>" style="opacity: 0.5; filter: alpha(opacity=50);" src='<?php echo base_url();?>assets/images/feedback/celebrity-80x80.png' alt='extremely satisfied' > 
                       </div>
                    </div> 
                     
                    <hr/>
                     <div class="row m-t-20">
                         <div class="col-md-2">
                             <label class="control-label headings" for="visit_comment">Any Comments or Suggestions about your <?php echo $invoice['service_name'];?>:</label>
                         </div>
                         <div class="col-md-10">
                             <textarea name="visit_comment[]" class="form-control"></textarea>
                         </div>
                     </div>
                     
                 </div>
             </div>
        </div>
            <?php }}} ?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                 <div class="card-box">
                     <div class="row">
                         <div class="col-md-12" style="text-align: right;">
                             <button type="submit" class="btn btn-pink">Submit</button>
                         </div>
                     </div>
                 </div>
                </div>
            </div>    
        </form>
    </div>
    
    <script>
        $(document).ready(function () {
           
           $(".icon-qos").mouseover(function(){
               $(this).css("opacity","1");
           });
           
           $(".icon-qos").mouseout(function(){
               if($(this).attr('selected')!=='selected'){
                 $(this).css("opacity","0.5");
               }
           });
           $(".icon-qos").click(function(){
               if($(this).attr('selected')!=='selected'){
                  $(".icon-qos").removeAttr("selected");
                  $(".icon-qos").css("opacity","0.5");
                  
                 $(this).attr("selected","selected");
                 $(this).css("opacity","1");
               }
           });
           
           $(".icon-atmosphere").mouseover(function(){
               $(this).css("opacity","1");
           });
           
           $(".icon-atmosphere").mouseout(function(){
               if($(this).attr('selected')!=='selected'){
                 $(this).css("opacity","0.5");
               }
           });
           $(".icon-atmosphere").click(function(){
               if($(this).attr('selected')!=='selected'){
                  $(".icon-atmosphere").removeAttr("selected");
                  $(".icon-atmosphere").css("opacity","0.5");
                  
                 $(this).attr("selected","selected");
                 $(this).css("opacity","1");
               }
           });
           
           $(".icon-experience").mouseover(function(){
               $(this).css("opacity","1");
           });
           
           $(".icon-experience").mouseout(function(){
               if($(this).attr('selected')!=='selected'){
                 $(this).css("opacity","0.5");
               }
           });
           $(".icon-experience").click(function(){
               if($(this).attr('selected')!=='selected'){
                  $(".icon-experience").removeAttr("selected");
                  $(".icon-experience").css("opacity","0.5");
                  
                 $(this).attr("selected","selected");
                 $(this).css("opacity","1");
               }
           });
           
           $(".icon-vfm").mouseover(function(){
               $(this).css("opacity","1");
           });
           
           $(".icon-vfm").mouseout(function(){
               if($(this).attr('selected')!=='selected'){
                 $(this).css("opacity","0.5");
               }
           });
           $(".icon-vfm").click(function(){
               if($(this).attr('selected')!=='selected'){
                  $(".icon-vfm").removeAttr("selected");
                  $(".icon-vfm").css("opacity","0.5");
                  
                 $(this).attr("selected","selected");
                 $(this).css("opacity","1");
               }
           });
           
           
           $(".icon-skill").mouseover(function(){
               var seq = $(this).attr("seq");
               var id =  $(this).attr("serviceid");
               for(x=1; x<=seq; x++){
                   var e = ".skill"+x+id;
                    $(e).css("opacity","1");
                }
           });           
           $(".icon-skill").mouseout(function(){
               var selected = false;
               var seq = 0;
               var id =  $(this).attr("serviceid");
               for(x=1; x<=5; x++){
                    var e = ".skill"+x+id;
                    $(e).css("opacity","0.3");
                    if($(e).attr('selected')=='selected'){
                        selected=true;
                        seq = $(e).attr("seq");
                    }
               }
               if(selected==true){
                    for(x=1; x<=seq; x++){
                       var e = ".skill"+x+id;
                       $(e).css("opacity","1");
                    }
               }
           });
           $(".icon-skill").click(function(){
                var seq = $(this).attr("seq");
                var id =  $(this).attr("serviceid");
                
                
                for(x=1; x<=5; x++){
                    var e = ".skill"+x+id;
                    $(e).removeAttr("selected");
                    $(e).css("opacity","0.3");
                }
                
                $(this).attr("selected","selected");
                                
                 for(x=1; x<=seq; x++){
                     var e = ".skill"+x+id;
                     $(e).css("opacity","1");
                }
           });
           
           $(".icon-hospitality").mouseover(function(){
               var seq = $(this).attr("seq");
               var id =  $(this).attr("serviceid");
               for(x=1; x<=seq; x++){
                   var e = ".hospitality"+x+id;
                    $(e).css("opacity","1");
                }
           });           
           $(".icon-hospitality").mouseout(function(){
               var selected = false;
               var seq = 0;
               var id =  $(this).attr("serviceid");
               for(x=1; x<=5; x++){
                    var e = ".hospitality"+x+id;
                    $(e).css("opacity","0.3");
                    if($(e).attr('selected')=='selected'){
                        selected=true;
                        seq = $(e).attr("seq");
                    }
               }
               if(selected==true){
                    for(x=1; x<=seq; x++){
                       var e = ".hospitality"+x+id;
                       $(e).css("opacity","1");
                    }
               }
           });
           $(".icon-hospitality").click(function(){
                var seq = $(this).attr("seq");
                var id =  $(this).attr("serviceid");
                
                
                for(x=1; x<=5; x++){
                    var e = ".hospitality"+x+id;
                    $(e).removeAttr("selected");
                    $(e).css("opacity","0.3");
                }
                
                $(this).attr("selected","selected");
                                
                 for(x=1; x<=seq; x++){
                     var e = ".hospitality"+x+id;
                     $(e).css("opacity","1");
                }
           });
           
           $(".icon-knowledge").mouseover(function(){
               var seq = $(this).attr("seq");
               var id =  $(this).attr("serviceid");
               for(x=1; x<=seq; x++){
                   var e = ".knowledge"+x+id;
                    $(e).css("opacity","1");
                }
           });           
           $(".icon-knowledge").mouseout(function(){
               var selected = false;
               var seq = 0;
               var id =  $(this).attr("serviceid");
               for(x=1; x<=5; x++){
                    var e = ".knowledge"+x+id;
                    $(e).css("opacity","0.3");
                    if($(e).attr('selected')=='selected'){
                        selected=true;
                        seq = $(e).attr("seq");
                    }
               }
               if(selected==true){
                    for(x=1; x<=seq; x++){
                       var e = ".knowledge"+x+id;
                       $(e).css("opacity","1");
                    }
               }
           });
           $(".icon-knowledge").click(function(){
                var seq = $(this).attr("seq");
                var id =  $(this).attr("serviceid");
                
                
                for(x=1; x<=5; x++){
                    var e = ".knowledge"+x+id;
                    $(e).removeAttr("selected");
                    $(e).css("opacity","0.3");
                }
                
                $(this).attr("selected","selected");
                                
                 for(x=1; x<=seq; x++){
                     var e = ".knowledge"+x+id;
                     $(e).css("opacity","1");
                }
           });
           
           
           $(".icon-satisfaction").mouseover(function(){
               var seq = $(this).attr("seq");
               var id =  $(this).attr("serviceid");
               var e = ".satisfaction"+seq+id;
               $(e).css("opacity","1");
           });
           
           $(".icon-satisfaction").mouseout(function(){
               var seq = $(this).attr("seq");
               var id =  $(this).attr("serviceid");
               var e = ".satisfaction"+seq+id;
               if($(e).attr('selected')!=='selected'){
                 $(e).css("opacity","0.5");
               }
           });
           $(".icon-satisfaction").click(function(){
               var seq = $(this).attr("seq");
               var id =  $(this).attr("serviceid");
               
               
               if($(this).attr('selected')!=='selected'){
                  for(x=1; x<=5; x++){
                      var e = ".satisfaction"+x+id;
                        $(e).removeAttr("selected");
                        $(e).css("opacity","0.5");
                  }
                 $(this).attr("selected","selected");
                 $(this).css("opacity","1");
               }
           });
           
           
           
        });
        
    
    function select_this(option, val){
     
        var element = "#txt"+option;
        
        if($(element).val()!==val){
            $(element).val(val);
            $(this).attr({selected:'selected'});
        }  
    }
    </script>