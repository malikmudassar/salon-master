<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_controller extends CI_Controller {
//SMS controller
    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('sms_model');
        $this->load->model('business_model');
        if($this->session->userdata('role')==''){
            redirect('logout');
        }
    }

    public function smssender() {
        checkroles(0,0,1);
        
        $data['nav'] = 'mybusiness';
        $data['subnav'] = 'smssender';

        $data['sms_text']=$this->sms_model->get_smstext();
        
        $this->load->view('includes/header', $data);
        $this->load->view('smssender');
        $this->load->view('includes/footer');
        
    }
    
    function get_customersbysearch(){
        
         //** get all table definitions **//
        $data['draw']= $this->input->post('draw');
        $data['$start'] = $this->input->post('start');
        $data['$length'] = $this->input->post('length');
        
        $data['customer_name']= $this->input->post('customer_name');
        $data['customer_gender']= $this->input->post('customer_gender');
        $data['customer_careof']= $this->input->post('customer_careof');
        $data['customer_cell']= $this->input->post('customer_cell');
        $data['visit_date_from']= $this->input->post('visit_date_from');
        $data['visit_date_to']= $this->input->post('visit_date_to');
        $data['customer_email']= $this->input->post('customer_email');
        $data['profession']= $this->input->post('profession');
        
        
        
        
        $total= $this->sms_model->get_countofcustomers();
        $data['data'] = $this->sms_model->get_customersbysearch();
        
//        for($x=0; $x<sizeof($data['data']);$x++){
//            $data['data'][$x]['button'] = "<button id=".$x." type='sumbit'>Add</button>";
//        }
        
        $filtered=  sizeof($data['data']);
        
        $data['recordsTotal'] = $total;
        $data['recordsFiltered'] = $total;
        
        echo(json_encode($data));
        
    }
    
    function open_sms_sender(){
        checkroles(0,0,1);
        
        $data['nav'] = 'mybusiness';
        $data['subnav'] = 'smssender';
        $data['menu'] = 'hidden';
        
        $data1['visit_id']=$this->input->post('visit_id'); 
        $data1['customer_name']=$this->input->post('customer_name'); 
        $data1['customer_cell']=$this->input->post('customer_cell');
        $data1['service_name']=$this->input->post('service_name');
        $data1['service_category']=$this->input->post('service_category');
        $data1['staff_name']=$this->input->post('staff_name');
        $data1['visit_service_start']=$this->input->post('visit_service_start');
        $date=date_create($this->input->post('visit_service_start'));
        $data1['visit_time']= $date->format('g:i A');
        $data1['visit_day']= $date->format('dS');
        $data1['visit_month']= $date->format('M');
        $data1['business']=$this->business_model->getbusinessdetails();
        
        $this->load->view('includes/header', $data);
        $this->load->view('smsshooter', $data1);
        $this->load->view('includes/footer');
    }
    
    
    function send_sms(){
        $using="SMSReminder";
        
        if(null!==$this->input->post('using')){
           $using=$this->input->post('using');
        }
        $sendsms = $this->sms_model->send_sms(utf8_encode(trim($this->input->post('msg'))), $this->input->post('customercell'), FALSE, $using, true, $this->session->userdata('businessid')); 
        
        $this->sms_model->update_status($this->input->post('visit_id'));
        
    }
    
    function smslog(){
        checkroles(0,0,1);
        $data['nav'] = 'mybusiness';
        $data['subnav'] = 'smslog';
       
        
        
        $this->load->view('includes/header',$data);
        $this->load->view('smslog');
        $this->load->view('includes/footer');
        
    }
    
    function  get_smslog(){
          //** get all table definitions **//
        $data['draw']= $this->input->post('draw');
        $data['$start'] = $this->input->post('start');
        $data['$length'] = $this->input->post('length');
        
        $data['msgdata']= $this->input->post('msgdata');
        $data['receiver']= $this->input->post('receiver');
        $data['senton']= $this->input->post('senton');
        $data['using']= $this->input->post('using');
                
        $total= $this->sms_model->get_countoflog();
        $data['data']=$this->sms_model->getsmslog();
        
        $filtered=  sizeof($data['data']);
        
        $data['recordsTotal'] = $total;
        $data['recordsFiltered'] = $total;
        
        echo(json_encode($data));
    }
            
    
    
}
