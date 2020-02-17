<?php

class Tools_model extends CI_Model {

    function __construct() {
         // Call the Model constructor
        parent::__construct();
    }
    
    public function get_scheduled_tasks(){
        
        $this->db->select('*');
        $this->db->where('status','enabled');
        $query = $this->db->get('scheduled_tasks');
        
        return $query->result_array();
        
    }
    
    public function run_query($sql){
        
        $query = $this->db->query($sql);        
        return $query->result_array();
        
    }
    
    
  
}
