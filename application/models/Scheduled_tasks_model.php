<?php

class Scheduled_tasks_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }

    function get_all_tasks(){
        
        $this->db->select('*');
       $this->db->where('status','enabled');
        $query = $this->db->get('scheduled_tasks');
        
        return $query->result_array();
        
        
    }
    
    public function get_scheduled_task($task_id){
        
        $this->db->select('*');
        $this->db->where('id_scheduled_tasks',$task_id);
        $query = $this->db->get('scheduled_tasks');
        
        return $query->result_array();
        
    }
    
    public function  get_task_fields($sql){
        
        $query = $this->db->query($sql);
        
        return $query->field_data();
    }
    
    public function run_query($sql){
        
        $query = $this->db->query($sql);        
        return $query->result_array();
        
    }
    
    function get_loyalty_text(){
        
        $this->db->select('msg');
        $this->db->where('task_name','LoyaltyText');
        $this->db->where('status',$this->session->userdata('businessid'));
        $query = $this->db->get('scheduled_tasks');
        return $query->row();
    }
    
}
