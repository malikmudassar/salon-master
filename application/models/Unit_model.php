<?php

class Unit_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }

    function get_all_measure_units() {
       
        $this->db->select("*");
        $this->db->where('measurement_units.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('measurement_units');
       
        return $query->result_array();
    }
    
    
    function update_unit(){
        
        $data=array(
          'm_unit' => strtolower($this->input->post('m_unit', TRUE)),
        );
        
        $this->db->where('id_measurement_unit', $this->input->post('id_measurement_unit', TRUE));
        $this->db->where('measurement_units.business_id', $this->session->userdata('businessid'));
        $this->db->update('measurement_units', $data);
        
        return $this->db->affected_rows();
    }
    
    function add_unit(){
        
        $data = array(
            'm_unit' => strtolower($this->input->post('m_unit', TRUE)),
            'business_id' => $this->session->userdata('businessid'),
        );
        
        $this->db->insert('measurement_units', $data);
        return $this->db->insert_id();
        
    }
    
    function edit_unit(){
        $this->db->select('*');
        $this->db->where('mu.business_id', $this->session->userdata('businessid'));
        $this->db->where('mu.id_measurement_unit', $this->input->post('id_measurement_unit'));
        $query = $this->db->get('measurement_units mu');

        return $query->row();
    }
    
}
