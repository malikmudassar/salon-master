<?php

class App_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }

    function get_reservation_requests($status) {
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d H:i:s', strtotime('tomorrow'));
                
        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = reservation_requests.customer_id');
        if($status !== "All"){
            $this->db->where('status', $status);
        }
        $this->db->where('reservation_requests.business_id', $this->session->userdata('businessid'));
        $this->db->order_by('request_service_start', 'ASC');
        $query = $this->db->get('reservation_requests');
       
        return $query->result_array();
    }
    

}
