<?php
class Tools extends CI_Controller {

     public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('business_model');
        $this->load->model('tools_model');
        $this->load->model('sms_model');
    }
    
     
    public function get_scheduled_tasks(){
        
        $business_id=1;
        $st = $this->tools_model->get_scheduled_tasks();
        //echo 'do it bro';
        foreach ($st as $task){
            //echo $task['task_name'];
            if (strtolower(substr($task['s_query'],0,6))==="select"){
                $resultset = $this->tools_model->run_query($task['s_query']);
                $customer_cell='';
                foreach($resultset as $row){
                    if($row['customer_cell']!==$customer_cell){
                        //echo 'sending  to ' . $row['customer_name'];
                         $msg=str_replace('$name$', $row['customer_name'], $task['msg']);
                         $business_id=1;
                         if(isset($row['visit_date']) && null!==$row['visit_date'] ){

                             $date=date_create($row['visit_date']);
                             $visit_time= $date->format('g:i A');
                             $visit_day= $date->format('dS');
                             $visit_month= $date->format('M');

                             $final_date = $visit_day.' of '.$visit_month.' at '.strtolower($visit_time);

                             $msg=str_replace('$date$', $final_date, $msg);
                         } else { $msg=str_replace('$date$', date('d-m-Y'), $msg);}


                         if(isset($row['service_name']) && null!==$row['service_name']){
                             $msg=str_replace('$service$', $row['service_name'], $msg);
                         } else { $msg=str_replace('$service$', ' ', $msg);}


                         if(isset($row['business']) && null!==$row['business']){
                             $msg=str_replace('$business$', $row['business'], $msg);
                         } else { $msg=str_replace('$business$', ' ', $msg);}
                         
                         if(isset($row['id_business']) && null!==$row['id_business']){
                             $business_id=$row['id_business'];
                         } else { $business_id=1;}
                                                  
                         if(isset($row['contact']) && null!==$row['contact']){
                             $msg=str_replace('$contact$', $row['contact'], $msg);
                         } else { $msg=str_replace('$contact$', ' ', $msg);}

                         $this->sms_model->send_sms($msg, $row['customer_cell'], false, 'ScheduledTask', false, $business_id);
                         //echo ($msg." , ". $row['customer_cell']);

                         $customer_cell=$row['customer_cell'];

                         if(isset($row['update_status']) && null!==$row['update_status']){
                             if(isset($row['visit_id']) && null!==$row['visit_id'])
                             $this->sms_model->update_status($row['visit_id']);
                         }
                    }
                }
            }
        }
        
    }
    
  
    
}