<?php

class Colors_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function color_type_list() {
        $this->db->select('*');
        $this->db->where('color_types.business_id', $this->session->userdata('businessid'));
        $this->db->order_by('order_id','ASC');
        $query = $this->db->get('color_types');

        return $query->result_array();
    }

    function add_color_type() {

        $data = array(
            'type' => $this->input->post('type', TRUE),
            'order_id' => $this->input->post('orderid', TRUE),
            'business_id' => $this->session->userdata('businessid')
        );

        $this->db->insert('color_types', $data);
        return $this->db->insert_id();
    }

    function update_color_type() {

        $data = array(
            'type' => $this->input->post('type', TRUE),
            'status' => $this->input->post('status', TRUE)
        );

        $this->db->where('id', $this->input->post('id_type', TRUE));
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->update('color_types', $data);

        return $this->db->affected_rows();
    }

    function get_all_color_number($type_id) {
        $this->db->select('*');
        $this->db->where('color_number.business_id', $this->session->userdata('businessid'));
        $this->db->where('type_id=', $type_id);
        $query = $this->db->get('color_number');

        return $query->result_array();
    }

    function add_color_number() {

        $data = array(
            'number' => $this->input->post('color_number', TRUE),
            'type_id' => $this->input->post('type_id', TRUE),
            'business_id' => $this->session->userdata('businessid')
        );

        $this->db->insert('color_number', $data);
        return $this->db->insert_id();
    }

    function update_color_number() {

        $data = array(
            'number' => $this->input->post('color_number', TRUE),
            'status' => $this->input->post('status', TRUE),
            'business_id' => $this->session->userdata('businessid')
        );

        $this->db->where('id', $this->input->post('id_number', TRUE));
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->update('color_number', $data);

        return $this->db->affected_rows();
    }

    function get_color_type_byid($id) {
        $this->db->select('*');
        $this->db->where('color_types.business_id', $this->session->userdata('businessid'));
        $this->db->where('id=', $id);
        $query = $this->db->get('color_types');
        
        
        return $query->result_array();
    }

    function get_color_records() {
        $this->db->select('*,DATE_FORMAT(date, "%d-%c-%Y") as date, datediff(now(), date) as daysago', False);
        $this->db->where('color_records.business_id', $this->session->userdata('businessid'));
        $this->db->order_by('id desc');
        $query = $this->db->get('color_records');
        
        return $query->result_array();
    }
    
    
    function get_customer_color_records($customer_id, $sh=false) {
        $this->db->select('*,DATE_FORMAT(date, "%d-%c-%Y") as date, datediff(now(), date) as daysago', False);
        $this->db->where('color_records.business_id', $this->session->userdata('businessid'));
        $this->db->where('color_records.customer_id', $customer_id);
        $this->db->order_by('daysago asc');
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->limit(5);
        }
        $query = $this->db->get('color_records');
        
        return $query->result_array();
    }
    
    function get_color_record($visit_id) {
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('customer_visit_id', $visit_id);
        $query = $this->db->get('color_records');
        return $query->result_array();
    }
    
    function get_facial_records($visit_id) {
        $this->db->select('*,DATE_FORMAT(date, "%d-%c-%Y") as date');
        $this->db->where('visit_id', $visit_id);
        $this->db->where('facial_records.business_id', $this->session->userdata('businessid'));
        $this->db->order_by('id desc');
        $query = $this->db->get('facial_records');

        return $query->result_array();
    }
    
    function get_eyelash_records($visit_id) {
        $this->db->select('*,DATE_FORMAT(created_date, "%d-%c-%Y") as date');
        $this->db->where('visit_id', $visit_id);
        $this->db->where('eyelashes_record.business_id', $this->session->userdata('businessid'));
        $this->db->order_by('id_eyelashes desc');
        $query = $this->db->get('eyelashes_record');

        return $query->result_array();
    }
    
    
    function color_record_add() {

        $data = array(
            'customer_visit_id' => $this->input->post('customer_visit_id', TRUE),
            'customer_id' => $this->input->post('txtcustomer_id', TRUE),
            'customer' => $this->input->post('txtcustomer', TRUE),
            'color_type_id' => $this->input->post('txttype_id', TRUE),
            'color_type' => $this->input->post('txttype', TRUE),
            //'color_number_id' => $this->input->post('txttypenumber_id'),
            'color_number' => $this->input->post('txttypenumber', TRUE),
            'time' => $this->input->post('txttime', TRUE),
            'charge' => $this->input->post('txtcharge', TRUE),
            'remarks' => $this->input->post('txtremarks', TRUE),
            'recommendation' => $this->input->post('txtrecommendation', TRUE),
            'date' => $this->input->post('txtdate', TRUE),
            'water_content' => $this->input->post('water_content', TRUE),
            'business_id' => $this->session->userdata('businessid')
        );
        
        $this->db->insert('color_records', $data);
        return $this->db->insert_id();
    }
    
    function edit_color_record(){
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('id', $this->input->post('id', TRUE));
        $query = $this->db->get('color_records');
        return $query->row();
    }
            
    function color_record_update(){
        
        $data = array(
            'customer_id' => $this->input->post('txtcustomer_id', TRUE),
            'customer' => $this->input->post('txtcustomer', TRUE),
            'color_type_id' => $this->input->post('txttype_id', TRUE),
            'color_type' => $this->input->post('txttype', TRUE),
            //'color_number_id' => $this->input->post('txttypenumber_id'),
            'color_number' => $this->input->post('txttypenumber', TRUE),
            'time' => $this->input->post('txttime', TRUE),
            'charge' => $this->input->post('txtcharge', TRUE),
            'remarks' => $this->input->post('txtremarks', TRUE),
            'recommendation' => $this->input->post('txtrecommendation', TRUE),
            'date' => $this->input->post('txtdate', TRUE),
            'water_content' => $this->input->post('water_content', TRUE),
            'business_id' => $this->session->userdata('businessid')
        );
       // print_r($data);die;
        $this->db->where('id', $this->input->post('idcolor_record', TRUE));
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->update('color_records', $data);
        
        return $this->db->affected_rows();
    }
    
    function edit_color_types(){
        $this->db->select('*');
        $this->db->where('ct.business_id', $this->session->userdata('businessid'));
        $this->db->where('ct.id', $this->input->post('id_color_type'));
        $query = $this->db->get('color_types ct');

        return $query->row();
    }
    
    function edit_color_number(){
        $this->db->select('*');
        $this->db->where('cn.business_id', $this->session->userdata('businessid'));
        $this->db->where('cn.id', $this->input->post('id_color_number'));
        $query = $this->db->get('color_number cn');

        return $query->row();
    }
    
    function get_WaterContent(){
        $this->db->select('*');
        $query = $this->db->get_where('water_content', array('business_id' => $this->session->userdata('businessid')));
        return $query->result_array();
    }

}
