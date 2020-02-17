<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dailysummary_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('dailysummary_model');
        $this->load->model('business_model');
        if($this->session->userdata('role')==''){
            redirect('logout');
        }
    }

    public function index() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(0,0,1);

            $data['nav'] = 'invoice';
            $data['subnav'] = 'dailysummary';

            $date=$this->input->post('calendar_date', TRUE);
            if(!isset($date) || empty($date)){
                 $date = date('Y-m-d');
            }

            $data['date'] = $date;        
            $data['business']=$this->business_model->getbusinessdetails();

            $data['service_transactions']= $this->dailysummary_model->get_services($date);
            $data['retail_transactions']= $this->dailysummary_model->get_retail($date);
            $data['voucher_transactions']= $this->dailysummary_model->get_voucher($date);
            $data['loyalty_discounts']= $this->dailysummary_model->get_loyalty_discounts($date);
            $data['redemptions']= $this->dailysummary_model->get_redemptions($date);
            $data['new_customers']= $this->dailysummary_model->get_newcustomers($date);
            $data['returning_customers']= $this->dailysummary_model->get_returningcustomers($date);
            $data['customerstodate']= $this->dailysummary_model->get_customers_to_date($date);
            $data['male']= $this->dailysummary_model->get_male_customers($date);
            $data['female']= $this->dailysummary_model->get_female_customers($date);

            //get the posted values
            $this->load->view('includes/header',$data);
            $this->load->view('daily_summary');
            $this->load->view('includes/footer');
            //$data = $this->appointment_model->get_appointments();
            //echo(json_encode($data));
        }
    }
    
    
}