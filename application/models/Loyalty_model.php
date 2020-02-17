<?php

class Loyalty_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();         
    }

    function get_service_loyalty() {
        
        $this->db->select('*');
        $this->db->join('business_services', 'business_services.id_business_services = service_loyalty.service_id');
        $this->db->join('service_category sc', 'sc.id_service_category = business_services.service_category_id');
        $this->db->join('service_type st', 'st.id_service_types = sc.service_type_id');
        $this->db->where('active', 'yes');
        $this->db->where('service_loyalty.business_id', $this->session->userdata('businessid'));
        $this->db->order_by('id_service_loyalty', 'Desc');
        $query = $this->db->get('service_loyalty');
       
        return $query->result_array();
    }
    
    
}
