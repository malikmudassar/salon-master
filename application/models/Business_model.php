<?php

class Business_model extends CI_Model {

    function __construct() {

        // Call the Model constructor
        parent::__construct();
    }

    function get_all_businesses() {
        
        $this->db->select('*');
        //$this->db->where('id_business', $this->session->userdata('businessid'));
        $query = $this->db->get('business');

        return $query->result_array();
    }
    
    function get_business_timing() {
        
        //Adding shifts to scheduler
        
        
        $this->db->select('id_business, business_opening_time, business_closing_time, rec_allow_prev as previous');
        $this->db->where('id_business', $this->session->userdata('businessid'));
        $query = $this->db->get('business');

        return $query->row();
    }
    
        //Addings shifts
    function get_shift_timing(){
        
        $t=time();
        $today = date("H:s",$t);
        
        $this->db->select('id_business, id_shifts, shift_start as "business_opening_time", shift_end  as "business_closing_time", rec_allow_prev as previous');
        $this->db->join('business', 'business.id_business=shifts.business_id');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('STR_TO_DATE(shift_start, "%H:%i") <=', $today);
        $this->db->where('STR_TO_DATE(shift_end, "%H:%i") >=', $today);
        $query = $this->db->get('shifts');
        return $query->row();
    }

    function update_business_timing($data) {

        $this->db->where('id_business', $this->session->userdata('businessid'));
        $query = $this->db->update('business', $data);

        return $query;
    }

    function get_business_admins(){
        $this->db->select('*');
         
        $this->db->join('user_roles', 'user_roles.user_id = users.id_users');
        $this->db->join('roles', 'user_roles.role_id = roles.id_roles');
        $this->db->where('users.business_id', $this->session->userdata('businessid'));
        $this->db->where('roles.role_name', 'Admin');
        $query = $this->db->get('users');
        //echo $query; exit();
        return $query->result_array();
    }
    
    function getbusinessdetails() {

        $this->db->select('*');
        $this->db->where('business.id_business', $this->session->userdata('businessid'));
        $query = $this->db->get('business');

        return $query->result_array();
    }
    
    
    
    function getbusinesstaxes($type=null) {
        
        
        $this->db->select('*');
        $this->db->where('business_taxes.tax_active', 'Y');
        $this->db->where('business_taxes.business_id', $this->session->userdata('businessid'));
        if(null!==$type){
            $this->db->where('business_taxes.tax_invoice_type', $type);
        }
        $query = $this->db->get('business_taxes');

        return $query->result_array();
    }
    
    function get_tax_perc($type='service'){
        $this->db->select('sum(tax_percentage) as tax_percentage');
        $this->db->where('business_taxes.tax_active', 'Y');
        $this->db->where('business_taxes.business_id', $this->session->userdata('businessid'));
        $this->db->where('business_taxes.tax_invoice_type', $type);
        
        $query = $this->db->get('business_taxes');

        return $query->row();
        
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
            'show_professional' => $this->input->post('show_professional', TRUE),
            'tax_optional' => $this->input->post('tax_optional', TRUE),
            'rec_allow_prev' => $this->input->post('rec_allow_prev'),
            'staff_stats' => $this->input->post('staff_stats', TRUE),
            'scheduler_input_search' => $this->input->post('scheduler_input_search', TRUE),
            'show_cash_reg' => $this->input->post('show_cash_reg', TRUE),
            'cc_charge' => $this->input->post('cc_charge', TRUE),
            'walkin_enable' => $this->input->post('walkin_enable', TRUE),
            'force_extra_record' => $this->input->post('force_extra_record', TRUE),
            'allow_stock_update' => $this->input->post('allow_stock_update', TRUE),
            'allow_price_update' => $this->input->post('allow_price_update', TRUE)
            
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
            'tax_invoice_type' => $this->input->post('tax_invoice_type', TRUE),
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
            'tax_invoice_type' => $this->input->post('tax_invoice_type', TRUE),
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
