<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback_controller extends CI_Controller {

    public function __construct() {

        parent::__construct();

        // Your own constructor code

        $this->load->model('invoice_model');
        $this->load->model('feedback_model');

        if ($this->session->userdata('role') == '') {

            redirect('logout');
        }
    }
    
    public function index($status='none', $date=null) {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $today = date('Y-m-d');

            if(null !== $date){
               $today=$date;
               $data['date']=$today;
            }

            //$tomorrow = date('Y-m-d H:i:s', strtotime('tomorrow'));

           $data['status']= urldecode($status); 

            $data['invoices']=$this->invoice_model->getdayinvoices($today, 'desc', $data['status'],null);

            $this->load->view('includes/header',$data);
            $this->load->view('feedback/feedback_view');
            $this->load->view('includes/footer');
        }
    }
    
    public function feedback_form($invoice_id) {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
       
            $data['invoices']=$this->invoice_model->getdayinvoices(null, 'desc', null, $invoice_id);

            $this->load->view('includes/header',$data);
            $this->load->view('feedback/feedback_form');
            $this->load->view('includes/footer');
        }
        
    }
    
    
    public function insert_feedback() {
        //$today = date('Y-m-d');
        //$tomorrow = date('Y-m-d H:i:s', strtotime('tomorrow'));
      
       
       $data=array(
           'customer_id'=>$this->input->post('customerid'),
           'invoice_id'=>$this->input->post('invoiceid'),
           'visit_id'=>$this->input->post('visitid'),
           'business_id'=>$this->session->userdata('businessid'),
           'created_on'=> date('Y-m-d H:i:s'),
           'qos'=>$this->input->post('txtqos'),
           'atmosphere'=>$this->input->post('txtatmosphere'),
           'experience'=>$this->input->post('txtexperience'),
           'valueformoney'=>$this->input->post('txtvfm'),
           'recommendable'=>'',
           'comment'=>$this->input->post('customer_comment'),
       );
        
       $feedbackid = $this->feedback_model->insert_feedback($data);
       
       $servicedetailid=$this->input->post('servicedetailid');
       
       $index=0;
       foreach($servicedetailid as $sid){
           $exp="expectation_".$sid;
           $info = "information_".$sid;
          
           $data=array(
               'invoice_detail_id'=>$sid,
               'feedback_id'=>$feedbackid,
               'service_id'=>$this->input->post('serviceid')[$index],
               'service_type'=>$this->input->post('servicetype')[$index],
               'service_category'=>$this->input->post('servicetype')[$index],
               'service_name'=>$this->input->post('servicename')[$index],
               'staff'=>$this->input->post('staff')[$index],
               'staff_id'=>$this->input->post('staffid')[$index],
               
               'expectation'=> (isset($this->input->post($exp)[$index])) ? $this->input->post($exp)[0] : 'Yes',
               
               'skill'=>$this->input->post('txtskill')[$index],
               'knowledge'=>$this->input->post('txtknowledge')[$index],
               'hospitality'=>$this->input->post('txthospitality')[$index],
               
               'information_provided'=>(isset($this->input->post($info)[$index])) ? $this->input->post($info)[0] : 'Yes',
               'satisfaction'=>$this->input->post('txtsatisfaction')[$index],
               'comments'=>$this->input->post('visit_comment')[$index]
           );
           
           $this->feedback_model->insert_details($data);
           
           $index++;
       }
       
       $this->invoice_model->update_feedback($this->input->post('invoiceid'),'entered');
       
       redirect(base_url().'feedback/none/'.date('Y-m-d').'/service');
        
    }
}

