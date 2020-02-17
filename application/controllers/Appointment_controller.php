<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('appointment_model');
        $this->load->model('staff_model');
        $this->load->model('service_model');
        $this->load->model('business_model');
        if($this->session->userdata('role')==''){
            redirect('logout');
        }
    }

    public function appointments() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(1,0,1);

           $data['nav'] = 'invoice';
           $data['subnav'] = 'appointments';

           $data['staffs'] = $this->staff_model->all_staff_list();
           $data['servicetypes'] = $this->service_model->get_services_types();
            $data['business']=$this->business_model->getbusinessdetails();

           //get the posted values
           $this->load->view('includes/header', $data);
           $this->load->view('appointments_list');
           $this->load->view('includes/footer');
           //$data = $this->appointment_model->get_appointments();
           //echo(json_encode($data));
        }
    }
    
    function todayappointments(){
        
        $data = $this->appointment_model->get_todayappointments();
        echo(json_encode($data));
        
    }
    
    function nextdayappointments(){
        
        $data = $this->appointment_model->get_nextdayappointments();
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
        
        $customerid=$this->input->post("appointment-customer-id", TRUE);
        
        if($customerid!=""){
            $result=$this->appointment_model->add_appointment();
            echo "success|".$result;
        } else {
            echo "error|Something went wrong! you tried to enter a new appointment but I dont have an existing customer selected. Please start over.";
        }
    }
  
    public function get_appointments() {
        
        $startdate='2010-01-01';
        $enddate='2060-01-01';
        
        if('' !==$this->input->post('startdate')){
            $startdate=$this->input->post('startdate');
            $enddate=$this->input->post('enddate');
        }
        $data = $this->appointment_model->get_range_appointments($startdate, $enddate);
        echo(json_encode($data));
        
    }

    public function get_appointment(){
        $id_customer_visit = $this->input->post('id_customer_visit');
        $data = $this->appointment_model->get_appointment($id_customer_visit);
        echo(json_encode($data));
        
    }
    
    public function show_appointments() {
        $data = $this->appointment_model->get_appointments_view();
        echo(json_encode($data));
    }
    
    public function bookings(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1,0,1);

            $data['nav'] = 'invoice';
            $data['subnav'] = 'appointments';

            $data['bookings'] = $this->appointment_model->getbookings();
            $this->load->view('includes/header', $data);
            $this->load->view('period_booking_list');
            $this->load->view('includes/footer');
        }
    }
    
    public function staffperformance(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(0,0,1);

           $data['nav'] = 'invoice';
           $data['subnav'] = 'staffperformance';
           $data['staffs'] = $this->staff_model->all_staff_list();
           $data['servicetypes'] = $this->service_model->get_services_types();
            $data['business']=$this->business_model->getbusinessdetails();

         
            $this->load->view('includes/header', $data);
            $this->load->view('staff_performance');
            $this->load->view('includes/footer');
        }
    }
    
    public function get_staffinvoices() {
        
        $startdate='2010-01-01';
        $enddate='2060-01-01';
        
        if('' !==$this->input->post('startdate')){
            $startdate=$this->input->post('startdate');
            $enddate=$this->input->post('enddate');
        }
        $data = $this->appointment_model->staff_performance($startdate, $enddate);
        echo(json_encode($data));
        
    }
}