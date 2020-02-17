<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Today_dashboard_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('today_dashboard_model');
        $this->load->model('invoice_model');
        $this->load->model('voucher_model');
        $this->load->model('expense_model');
        $this->load->model('business_model');
        
        if($this->session->userdata('role')==''){
            redirect('logout');
        }
    }

    public function index() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(1,0,1);

            $data['nav'] = 'invoice';
            $data['subnav'] = 'daily_sheet';
            $date=$this->input->post('calendar_date', TRUE);

            if(!isset($date) || empty($date)){
                 $date = date('Y-m-d');
            }

            //get the posted values
            $data['date'] = $date;        
            $data['business']=$this->business_model->getbusinessdetails();
            $data['invoices'] = $this->invoice_model->getdayinvoices($date);
            $data['vouchersale'] = $this->invoice_model->get_cash_voucher($date);
            $data['vouchers'] = $this->invoice_model->get_voucher_breakup($date);
            $data['advances'] = $this->invoice_model->get_advance_breakup($date);
            //$data['vouchers'] = $this->voucher_model->getdayvouchers($date);
            $data['expenses'] = $this->expense_model->get_daily_expense_list($date, $date);
            $data['cashInfo'] = $this->invoice_model->get_today_cash_info($date);
            $data['cashregister'] = $this->invoice_model->get_cash_register($date);
            $data['yesterdaytill'] = $this->invoice_model->get_yesterday_till_amount($date);
            if(null !==$this->input->post('user', TRUE)){
                $data['selecteduser'] = $this->input->post('user', TRUE);
            } else {
                $data['selecteduser'] = "All";
            }

            $this->load->model('user_model');
            $data['users'] = $this->user_model->get_visible_users();

            $this->load->view('includes/header', $data);
            $this->load->view('today_dashboard');
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
        
        $startdate='';
        $enddate='';
        
        if(null !==$this->input->post('startdate')){
            $startdate=$this->input->post('startdate');
            $enddate=$this->input->post('enddate');
        }
        $data = $this->appointment_model->get_range_appointments($startdate, $enddate);
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
}