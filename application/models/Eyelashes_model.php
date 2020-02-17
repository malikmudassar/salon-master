<?php

class Eyelashes_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_eyelashes_record() {
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->order_by('id_eyelashes', 'DESC');
        $query = $this->db->get('eyelashes_record');

        return $query->result_array();
    }

    function eyelash_type_list(){
        
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->order_by('id_eyelash_types', 'DESC');
        $query = $this->db->get('eyelash_types');

        return $query->result_array();
        
    }
    
    function get_eyelashes_records($visit_id) {
        $this->db->select('*,DATE_FORMAT(date, "%d-%c-%Y") as date');
        $this->db->where('visit_id', $visit_id);
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('eyelashes_record');

        return $query->result_array();
    }
    
    function get_customer_eyelashes_records($customer_id, $sh=false) {
        $this->db->select('*,DATE_FORMAT(date, "%d-%c-%Y") as date, datediff(now(), date) as daysago', False);
        $this->db->where('customer_id', $customer_id);
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->order_by('daysago asc');
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->limit(5);
        }
        $query = $this->db->get('eyelashes_record');

        return $query->result_array();
    }
    
    function edit_eyelashes_record() {
        $this->db->select('*');
        $this->db->where('eyelashes_record.business_id', $this->session->userdata('businessid'));
        $this->db->where('eyelashes_record.id_eyelashes', $this->input->post('id_eyelashes', TRUE));
        $query = $this->db->get('eyelashes_record');

        return $query->row();
    }

    function update_eyelashes() {
        $lengths=$this->input->post('length', TRUE);
        $selectedlengths="";
        foreach($lengths as $length){
            if($selectedlengths!==""){$selectedlengths=$selectedlengths.",";}
            $selectedlengths=$selectedlengths.$length;
        }
        $data = array(
            'customer_id' => $this->input->post('customer_id', TRUE),
            'customer_name' => $this->input->post('customer_name', TRUE),
            'eyelash_type' => $this->input->post('eyelash_type', TRUE),
            'thickness' => $this->input->post('thickness', TRUE),
            'length' => $selectedlengths,
            'curl' => $this->input->post('curl', TRUE),
            'date' => $this->input->post('date', TRUE),
            'price' => $this->input->post('price', TRUE),
            'full_set_refill' => $this->input->post('fullsetrefill', TRUE),
            'remarks' => $this->input->post('remarks', TRUE)
        );
        
        $this->db->where('eyelashes_record.id_eyelashes', $this->input->post('id_eyelashes', TRUE));
        $this->db->where('eyelashes_record.business_id', $this->session->userdata('businessid'));
        $this->db->update('eyelashes_record', $data);
        
        return $this->db->affected_rows();
    }

    function add_eyelashes() {
        $lengths=$this->input->post('length', TRUE);
        $selectedlengths="";
        foreach($lengths as $length){
            if($selectedlengths!==""){$selectedlengths=$selectedlengths.",";}
            $selectedlengths=$selectedlengths.$length;
        }
        
        $data = array(
            'customer_id' => $this->input->post('customer_id', TRUE),
            'customer_name' => $this->input->post('customer_name', TRUE),
            'eyelash_type' => $this->input->post('eyelash_type', TRUE),
            'thickness' => $this->input->post('thickness', TRUE),
            'length' => $selectedlengths,
            'curl' => $this->input->post('curl', TRUE),
            'date' => $this->input->post('date', TRUE),
            'full_set_refill' => $this->input->post('fullsetrefill', TRUE),
            'remarks' => $this->input->post('remarks', TRUE),
            'visit_id' => $this->input->post('visitid', TRUE),
            'price' => $this->input->post('price', TRUE),
            'business_id' => $this->session->userdata('businessid')
        );
        
        $this->db->insert('eyelashes_record', $data);
        return $this->db->insert_id();
    }

}
