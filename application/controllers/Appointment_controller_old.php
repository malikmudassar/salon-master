<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('appointment_model');
        if($this->session->userdata('role')==''){
            redirect('logout');
        }
    }
    
    public function appointments() {
        //get the posted values
        
        $data = $this->appointment_model->get_appointments();
        echo(json_encode($data));
        
    }
    
    public function appointmentsbyid() {
        //get the posted values
        
        $data = $this->appointment_model->get_by_custid();
        echo(json_encode($data));
        
    }
    
    public function updateappstatus(){
        $data = $this->appointment_model->update_status();
        echo(json_encode($data));
    }
    
    public function addappointment(){
        
        $customerid=$this->input->post("appointment-customer-id");
        
        if($customerid!=""){
            $result=$this->appointment_model->add_appointment();
            echo "success|".$result;
        } else {
            echo "error|Something went wrong! you tried to enter a new appointment but I dont have an existing customer selected. Please start over.";
        }
    }
}