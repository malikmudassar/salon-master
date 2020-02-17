<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Superuser_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('superuser_model');
        $this->load->model('invoice_model');
        $this->load->model('voucher_model');
        $this->load->model('expense_model');
        $this->load->model('business_model');
        $this->load->model('visits_model');
        if($this->session->userdata('role')!=='Super User'){
            redirect('logout');
        }
    }

    public function supervise_invoices() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(0,0,1);

            $date=$this->input->post('calendar_date', TRUE);

            if(!isset($date) || empty($date)){
                 $date = date('Y-m-d');
            }

            $data['nav'] = 'Super';
            $data['subnav'] = 'Supervise Invoices';

            //get the posted values
            $data['date'] = $date;        
            $data['business']=$this->business_model->getbusinessdetails();
            $data['invoices'] = $this->superuser_model->getsupervisordayinvoices($date);


            $this->load->view('includes/header', $data);
            $this->load->view('superuser/supervise_invoices');
            $this->load->view('includes/footer');
        }
        
    }
    
    public function open_edit_invoice(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(0,0,1);

            $data['nav'] = 'Super';
            $data['subnav'] = 'Supervise Invoices';

            //get the posted values

            $data['business']=$this->business_model->getbusinessdetails();
            $data['invoice'] = $this->superuser_model->get_invoice_for_edit($this->input->post('id_invoice'));


            $this->load->view('includes/header', $data);
            $this->load->view('superuser/supervise_invoice_edit');
            $this->load->view('includes/footer');
        }
        
    }
    
    public function update_invoice(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
        
            $result = $this->superuser_model->update_super_invoice();

            if($result && $result>0){
                $this->session->set_flashdata('Success', 'Invoice successfully updated!');
            } else {
                $this->session->set_flashdata('Error', 'Invoice was not updated!');
            }

            checkroles(0,0,1);

            $data['nav'] = 'Super';
            $data['subnav'] = 'Supervise Invoices';

            //get the posted values

            $data['business']=$this->business_model->getbusinessdetails();
            $data['invoice'] = $this->superuser_model->get_invoice_for_edit($this->input->post('id_invoice'));


            $this->load->view('includes/header', $data);
            $this->load->view('superuser/supervise_invoice_edit');
            $this->load->view('includes/footer');
        
        }
    }
 
    
    public function supervise_visits() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(0,0,1);

            $date=$this->input->post('calendar_date', TRUE);

            if(!isset($date) || empty($date)){
                $date = date('Y-m-d');
            }

            $data['nav'] = 'Super';
            $data['subnav'] = 'Supervise Invoices';

            //get the posted values
            $data['date'] = $date;        
            $data['business']=$this->business_model->getbusinessdetails();
            $data['visits'] = $this->superuser_model->getsupervisordayvisits($date);


            $this->load->view('includes/header', $data);
            $this->load->view('superuser/supervise_visits');
            $this->load->view('includes/footer');
        }
        
    }
    
    public function open_edit_visit(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(0,0,1);

            $data['nav'] = 'Super';
            $data['subnav'] = 'Supervise Visits';

            //get the posted values

            $data['business']=$this->business_model->getbusinessdetails();
            $data['visit'] = $this->superuser_model->get_visit_for_edit($this->input->post('id_customer_visits'));
            $data['advances'] = $this->visits_model->getopenvisitadvancebyid($this->input->post('id_customer_visits'));

            $this->load->view('includes/header', $data);
            $this->load->view('superuser/supervise_visit_edit');
            $this->load->view('includes/footer');
        }
        
    }
    
    public function update_visit(){
        
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $result = $this->superuser_model->update_super_visit();

            if($result && $result>0){
                $this->session->set_flashdata('Success', 'Visit successfully updated!');
            } else {
                $this->session->set_flashdata('Error', 'Visit was not updated!');
            }

            checkroles(0,0,1);

            $data['nav'] = 'Super';
            $data['subnav'] = 'Supervise Visits';

            //get the posted values

            $data['business']=$this->business_model->getbusinessdetails();
            $data['visit'] = $this->superuser_model->get_visit_for_edit($this->input->post('id_customer_visits'));
             $data['advances'] = $this->visits_model->getopenvisitadvancebyid($this->input->post('id_customer_visits'));

            $this->load->view('includes/header', $data);
            $this->load->view('superuser/supervise_visit_edit');
            $this->load->view('includes/footer');
        }
        
    }
    
    function edit_advance(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $result = $this->superuser_model->update_super_advance();

            if($result && $result>0){
                $this->session->set_flashdata('Success', 'Advance successfully updated!');
            } else {
                $this->session->set_flashdata('Error', 'Advance was not updated!');
            }

            checkroles(0,0,1);

            $data['nav'] = 'Super';
            $data['subnav'] = 'Supervise Visits';

            //get the posted values

            $data['business']=$this->business_model->getbusinessdetails();
            $data['visit'] = $this->superuser_model->get_visit_for_edit($this->input->post('id_customer_visits'));
             $data['advances'] = $this->visits_model->getopenvisitadvancebyid($this->input->post('id_customer_visits'));

            $this->load->view('includes/header', $data);
            $this->load->view('superuser/supervise_visit_edit');
            $this->load->view('includes/footer');
        }
    }
}