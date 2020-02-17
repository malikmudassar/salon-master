<?php

class Loyaltyservices_model extends CI_Model {

    function __construct() {

        // Call the Model constructor
        parent::__construct();
    }

    function get_loyalty_services() {
        
        $this->db->select('*');
        $this->db->join('business_services', 'id_business_services = service_id');
        $this->db->where('loyalty_services.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('loyalty_services');

        return $query->result_array();
    }
    
      
    function add_loyaltyservice(){
        $data = array(
            'service_id' => $this->input->post('service_id', TRUE),
            'required_points' => $this->input->post('required_points', TRUE),
            'duration' => $this->input->post('duration', TRUE),
            'active' => $this->input->post('active', TRUE),
            'business_id' => $this->session->userdata('businessid'),
        );
         
       
        $this->db->insert('loyalty_services', $data);
        return $this->db->insert_id();
        
        
    }

    
    function get_edit_loyaltyservice($id){
        $this->db->select('*');
        $this->db->join("business_services bs","bs.id_business_services = ls.service_id");
        $this->db->where("id_loyalty_services = ", $id);
        $query = $this->db->get("loyalty_services ls");
        
        return $query->row();
        
    }
    
    function edit_loyaltyservice(){
         $data = array(
            'required_points' => $this->input->post('required_points', TRUE),
            'duration' => $this->input->post('duration', TRUE),
            'active' => $this->input->post('active', TRUE)
        );
         
       
        $this->db->where('id_loyalty_services', $this->input->post('id_loyalty_services'));
        $query = $this->db->update('loyalty_services', $data);

        return $query;
        
        
    }
    
    function update_business_timing($data) {

        $this->db->where('id_business', $this->session->userdata('businessid'));
        $query = $this->db->update('business', $data);

        return $query;
    }


    
    function getbusinessdetails() {

        $this->db->select('*');
        $this->db->where('business.id_business', $this->session->userdata('businessid'));
        $query = $this->db->get('business');

        return $query->result_array();
    }
    
    
    
    function getbusinesstaxes() {

        $this->db->select('*');
        $this->db->where('business_taxes.tax_active', 'Y');
        $this->db->where('business_taxes.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('business_taxes');

        return $query->result_array();
    }

    function get_time_block_reason() {
        $this->db->select('*');
        $this->db->where('block_events.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('block_events');

        return $query->result_array();
    }

    function add_blockevents($data) {
        $this->db->insert('block_events', $data);
        return $this->db->insert_id();
    }

    function edit_blockevents($data) {
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('id_block_events', $this->input->post('eventid'));
        $query = $this->db->update('block_events', $data);

        return $query;
    }

    function get_business_details() {
        $this->db->select('*');
        $this->db->where('business.id_business', $this->session->userdata('businessid'));
        $query = $this->db->get('business');

        return $query->result_array();
    }

    function edit_businessby_id() {
        $this->db->select('*');
        $this->db->where('business.id_business', $this->input->post('business_id'));
        $query = $this->db->get('business');

        return $query->row();
    }

    function business_update() {
        $this->db->where('id_business', $this->session->userdata('businessid'));
        $data = array(
            'business_name' => $this->input->post('business_name', TRUE),
            'business_address' => $this->input->post('business_address', TRUE),
            'business_area' => $this->input->post('business_area', TRUE),
            //'business_logo' => $this->input->post('business_logo', TRUE),
            'business_phone1' => $this->input->post('business_phone1', TRUE),
            'business_phone2' => $this->input->post('business_phone2', TRUE),
            'business_phone3' => $this->input->post('business_phone3', TRUE),
            'business_phone4' => $this->input->post('business_phone4', TRUE),
            'business_owner' => $this->input->post('business_owner', TRUE),
            'business_owner_contact' => $this->input->post('business_contact', TRUE),
            'payment_terms' => $this->input->post('payment_terms', TRUE),
            'business_opening_time' => $this->input->post('business_opening_time', TRUE),
            'business_closing_time' => $this->input->post('business_closing_time', TRUE),
            'scheduler_style' => $this->input->post('scheduler_style', TRUE),
            'tax_optional' => $this->input->post('tax_optional', TRUE),
            'rec_allow_prev' => $this->input->post('rec_allow_prev'),
            'staff_stats' => $this->input->post('staff_stats', TRUE)
        );
        $this->db->update('business', $data);
        return $this->db->affected_rows();
    }

    function business_logo_update($image) {
        $this->db->where('id_business', $this->session->userdata('businessid'));
        $data = array(
            'business_logo' => $image,
        );
        $this->db->update('business', $data);
        return $this->db->affected_rows();
    }

    function get_business_tax() {
        $this->db->select('*');
        $this->db->where('business_taxes.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('business_taxes');

        return $query->result_array();
    }

    function edit_business_Taxby_id() {
        $this->db->select('*');
        $this->db->where('business_taxes.id_business_taxes', $this->input->post('id_business_taxes'));
        $query = $this->db->get('business_taxes');

        return $query->row();
    }

    function business_taxes_update() {
        $this->db->where('id_business_taxes', $this->input->post('id_business_taxes', TRUE));
        $data = array(
            'tax_name' => $this->input->post('tax_name', TRUE),
            'tax_percentage' => $this->input->post('tax_percentage', TRUE),
            'tax_active' => $this->input->post('tax_active', TRUE),
        );
        $this->db->update('business_taxes', $data);
        return $this->db->affected_rows();
    }

    function business_taxes_add() {
        $data = array(
            'tax_name' => $this->input->post('tax_name', TRUE),
            'tax_percentage' => $this->input->post('tax_percentage', TRUE),
            'tax_active' => $this->input->post('tax_active', TRUE),
            'business_id' => $this->session->userdata('businessid'),
        );
        $this->db->insert('business_taxes', $data);
        return $this->db->insert_id();
    }
    
    function get_edit_blockevent(){
        $this->db->select('*');
        $this->db->where('be.business_id', $this->session->userdata('businessid'));
        $this->db->where('be.id_block_events', $this->input->post('id_block_events'));
        $query = $this->db->get('block_events be');

        return $query->row();
    }

}
