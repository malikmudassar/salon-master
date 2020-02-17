<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clinical_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('business_model');
        $this->load->model('clinical_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        }
    }

    public function clinic_form($customer_id = null) {
        $this->form_validation->set_rules('name', 'Name', 'required');
        if($this->input->post('input_type') == "update"){$this->form_validation->set_rules('email', 'Email', 'required|valid_email');}else{$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[clinical_info.email]');}
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('permanent_address', 'Permanent Address', 'required');
        $this->form_validation->set_rules('age', 'Age', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('emergency_name', 'Emergency Name', 'required');
        $this->form_validation->set_rules('emergency_contact_number', 'Contact Number', 'required');
        $this->form_validation->set_rules('relation_with_patient', 'Relation With Patient', 'required');
        $this->form_validation->set_rules('patient_representative', 'Patient Representative', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('representative_contact_number', 'Representative Contact Number', 'required');
        if ($this->form_validation->run() == FALSE) {
            checkroles(0, 0, 1);

            //$data['nav'] = 'reports';
            //$data['subnav'] = 'marketing_report';

            $data['business'] = $this->business_model->getbusinessdetails();
            $data['customer'] = $this->clinical_model->getCustomer($customer_id);
            $data['clinical_info'] = $this->clinical_model->getClinicInfo($customer_id);
            
            $this->load->view('includes/header', $data);
            $this->load->view('clinical/clinical_form');
            $this->load->view('includes/footer');
        } else {
            $result = $this->clinical_model->clinic_form_submit();
            $this->session->set_flashdata('form-submit', 'You have successfully submitted!');
            redirect(base_url('clinical-form') . '/' . $this->input->post('customer_id'));
        }
    }

}
