<?php

class Feedback_model extends CI_Model {

    function __construct() {

        // Call the Model constructor
        parent::__construct();
    }


    function get_invoices() {
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_status','valid');
        $query = $this->db->get('invoice');

        return $query->result_array();
    }
    
    function insert_feedback($data){
         
           $this->db->insert('feedback', $data);
           return $this->db->insert_id();
    }
    
    function insert_details($data){
        
            $this->db->insert('feedback_details', $data);
            return $this->db->insert_id();
    }
}