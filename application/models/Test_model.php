<?php

class Test_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }

    function test() {
        $today = date('Y-m-d');
        $tomorrow= date('Y-m-d H:i:s', strtotime('tomorrow'));
        
        
        // Loading second db and running query.
        $CI = &get_instance();
        //setting the second parameter to TRUE (Boolean) the function will return the database object.
        $this->gs = $CI->load->database('gs', TRUE);
        
        $this->gs->select('*');
        $query = $this->gs->get('pages');
       
        return $query->result_array();
    }
    
   
    
}
