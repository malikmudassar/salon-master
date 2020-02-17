<?php

class Sqldates_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }

    function lastdaylastmonth() {

        $sql ="SELECT DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())) DAY);";
        $query=$this->db->query($sql);
        
        return $query->result_array();
    }
    
    function firstdaylastmonth() {

        $sql ="SELECT DATE_SUB(DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY), INTERVAL 1 MONTH);";
        $query=$this->db->query($sql);
        
        return $query->result_array();
    }
    
    function lastmonthyear() {

        $sql ="SELECT date_format(DATE_SUB(DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY), INTERVAL 1 MONTH), '%M') as 'MonthName',
            date_format(DATE_SUB(DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY), INTERVAL 1 MONTH), '%c') as 'Month',
            date_format(DATE_SUB(DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY), INTERVAL 1 MONTH), '%Y') as 'Year';";
        $query=$this->db->query($sql);
        
        return $query->result_array();
    }
    

}
