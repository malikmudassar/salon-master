<?php
class Scheduled_tasks_controller extends CI_Controller {

     public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('business_model');
        $this->load->model('tools_model');
        $this->load->model('sms_model');

        $this->load->model('scheduled_tasks_model');
        
        if ($this->session->userdata('role') == '') {

            redirect('logout');
        }
        
    }
    
     
    public function scheduled_tasks($task_id=0){
        
        if(null!==$this->input->post('task')){$task_id=$this->input->post('task');}
        else {$task_id=0;}
        
        $data['nav'] = 'my_business';
        $data['subnav'] = 'scheduled_tasks';
        
        $data['business'] = $this->business_model->getbusinessdetails();
        $data['tasks'] = $this->scheduled_tasks_model->get_all_tasks();
        $data['task'] = $this->scheduled_tasks_model->get_scheduled_task($task_id);
        
        
        if(sizeof($data['task'])>0){
            $data['sql_result']=$this->scheduled_tasks_model->run_query($data['task'][0]['s_query']);  
            $data['task_fields'] = $this->scheduled_tasks_model->get_task_fields($data['task'][0]['s_query']);
        } else {
            $data['sql_result']=[];            
            $data['task_fields']=[];            
        }
        
        $this->load->view('includes/header', $data);

        $this->load->view('setting/scheduled_tasks');

        $this->load->view('includes/footer');
        
        
    }
    
   
    
}