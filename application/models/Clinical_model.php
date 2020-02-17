<?php

class Clinical_model extends CI_Model {

    function __construct() {

        // Call the Model constructor
        parent::__construct();
    }

    function clinic_form_submit() {
        $data = [
            'alergy' => $this->input->post('alergy'),
            'alergy_desc' => $this->input->post('alergy_desc'),
            'under_treatment' => $this->input->post('under_treatment'),
            'under_treatment_desc' => $this->input->post('under_treatment_desc'),
            'religion' => $this->input->post('religion'),
            'prefix' => $this->input->post('prefix'),
            'gender' => $this->input->post('gender'),
            'date_of_birth' => $this->input->post('date_of_birth'),
            'age' => $this->input->post('age'),
            'nationality' => $this->input->post('nationality'),
            'nic_number' => $this->input->post('nic_number'),
            'marital_status' => $this->input->post('marital_status'),
            'permanent_address' => $this->input->post('permanent_address'),
            'temporary_address' => $this->input->post('temporary_address'),
            'postal_code' => $this->input->post('postal_code'),
            'city' => $this->input->post('city'),
            'province' => $this->input->post('province'),
            'tel' => $this->input->post('tel'),
            'mobile' => $this->input->post('mobile'),
            'email' => $this->input->post('email'),
            'emergency_name' => $this->input->post('emergency_name'),
            'emergency_contact_number' => $this->input->post('emergency_contact_number'),
            'relation_with_patient' => $this->input->post('relation_with_patient'),
            'relation_with_patient_outside' => $this->input->post('relation_with_patient_outside'),
            'hear_about_us' => $this->input->post('hear_about_us_other') && $this->input->post('hear_about_us_other') !== "" ? $this->input->post('hear_about_us_other') : $this->input->post('hear_about_us'),
            'city_outside_patient' => $this->input->post('city_outside_patient_other') && $this->input->post('city_outside_patient_other') !== "" ? $this->input->post('city_outside_patient_other') : $this->input->post('city_outside_patient'),
            'patient_representative' => $this->input->post('patient_representative'),
            'representative_contact_number' => $this->input->post('representative_contact_number')
        ]; //echo "<pre>";print_r($data);exit;

        $this->db->where('clinical_info.customer_id', $this->input->post('customer_id'));
        $query = $this->db->get('clinical_info');
        if ($query->row_array() && !empty($query->row_array())) {
            $this->db->where('clinical_info.customer_id', $this->input->post('customer_id'));
            $result = $this->db->update('clinical_info', $data);
        } else {
            $data['name'] = $this->input->post('name');
            $data['customer_id'] = $this->input->post('customer_id');
            $result = $this->db->insert('clinical_info', $data);
        }

        if ($result) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    function getCustomer($customer_id = null) {
        $this->db->select('*');
        $this->db->where(['id_customers' => $customer_id, 'business_id', $this->session->userdata('businessid')]);
        $query = $this->db->get('customers');
        return $query->row_array();
    }

    function getClinicInfo($customer_id = null) {
        $this->db->select('*');
        $this->db->where('clinical_info.customer_id', $customer_id);
        $query = $this->db->get('clinical_info');
        return $query->row_array();
    }

}
