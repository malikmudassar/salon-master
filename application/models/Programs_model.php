<?php

class Programs_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }

    function get_program_by_id($programid){
        
        $this->db->select('*');
        $this->db->join('program_types', 'program_types.id_program_types = programs.program_type_id');
        $this->db->where('id_programs',$programid);
        $query = $this->db->get('programs');

        return $query->result_array();
        
    }
    
    function get_programs_by_type($programtypeid){
        
        $this->db->select('*');
        $this->db->join('program_types', 'program_types.id_program_types = programs.program_type_id');
        $this->db->where('program_type_id',$programtypeid);
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('programs');

        return $query->result_array();
        
    }
    
    function get_program_types(){
        $this->db->select('*');
        $query = $this->db->get('program_types');

        return $query->result_array();
        
    }
    function get_program_type($programtypeid){
        
        $this->db->select('*');
        $this->db->where('id_program_types',$programtypeid);
        $query = $this->db->get('program_types');

        return $query->result_array();
        
    }
    
    
    function get_active_programs($programtypeid){
        
        $this->db->select('*');
        $this->db->where('program_active',"Yes");
        if($programtypeid>0){
            $this->db->where('program_type_id',$programtypeid);
        }
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('programs');
        
        return $query->result_array();
        
    }
    
    
    function get_active_sessions($programid){
        
        $this->db->select('*, date_format(program_session_start,"%d %b %Y") start, date_format(program_session_end,"%d %b %Y") end');
        $this->db->where('program_id',$programid);
       // $this->db->where('program_session_end >', '2018-01-19');
        $query = $this->db->get('program_sessions');

        return $query->result_array();
        
    }
    
     function get_program_sessions($programid){
        
        $this->db->select('*, date_format(program_session_start,"%d %b %Y") start, date_format(program_session_end,"%d %b %Y") end');
        $this->db->join('program_sessions','program_sessions.program_id=programs.id_programs','left');
        $this->db->where('id_programs',$programid);
        $query = $this->db->get('programs');

        return $query->result_array();
    }
    
    function get_program_session_id($programsessionid){
        
        $this->db->select('*');
        $this->db->join('programs','program_sessions.program_id=programs.id_programs');
        $this->db->where('id_program_sessions',$programsessionid);
        $query = $this->db->get('program_sessions');
     
         return $query->result_array();
    }
    
    
    function get_enrollment($programsessionid){
        
        $this->db->select('*');
        $this->db->join('programs','programs.id_programs = program_sessions.id_program_sessions');
        $this->db->join('program_types','program_types.id_program_types = programs.program_type_id');
        $this->db->join('customers','program_sessions.customer_id = customer.id_customers');
        $this->db->where('id_program_sessions',$programsessionid);
        $query = $this->db->get('program_sessions');

        return $query->result_array();
        
        
    }
    
    function get_enrollment_schedule($programentrollmentid){
        
        
        
    }
    
    function get_enrollment_payments($programentrollmentid){
        
        $this->db->select('*, date_format(invoice_date, "%d/%m/%Y") f_payment_date, date_format(start_date, "%d-%m-%Y") f_start_date, date_format(program_session_start,"%W %D %M") f_program_session_start, date_format(program_session_end,"%W %D %M") f_program_session_end');
        $this->db->join('program_sessions','program_enrollment.program_session_id = program_sessions.id_program_sessions');
        $this->db->join('programs','programs.id_programs = program_sessions.program_id');
        $this->db->join('program_types','program_types.id_program_types = programs.program_type_id');
        $this->db->join('customers','program_enrollment.customer_id = customers.id_customers');
        $this->db->join('program_invoices','program_invoices.program_enrollment_id = program_enrollment.id_program_enrollment','left');
        $this->db->where('id_program_enrollment',$programentrollmentid);
        $query = $this->db->get('program_enrollment');
        
        return $query->result_array();
        
        
    }
    
    function addpayment(){
        
        $data = array(
            'program_enrollment_id' =>  $this->input->post('txtenrollmentid'),
            'invoice_date'=>$this->input->post('txtPaymentDate'),
            'paid_amount'=>$this->input->post('txtTotalPayment'),
            'paid_cash'=>$this->input->post('txtPaidCash'),
            'paid_card'=>$this->input->post('txtPaidCard'),
            'paid_check'=>$this->input->post('txtPaidCheck'),
            );
        
        
        $this->db->insert('program_invoices', $data);
        return $this->db->insert_id();
        
    }
    
    function get_program_members($program_type="All"){
        
        $this->db->select('*');
        $this->db->join('program_types','program_types.id_program_types = programs.program_type_id');
        $this->db->join('program_sessions','program_sessions.program_id = programs.id_programs');
        $this->db->join('program_enrollment','program_enrollment.program_session_id = program_sessions.id_program_sessions');
        $this->db->join('customers','program_enrollment.customer_id = customers.id_customers');
        
        if($program_type!=="All"){
            $this->db->where('id_program_types',$program_type);
        }
        $this->db->where('program_active','Yes');
        $this->db->where('programs.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('programs');
     
        return $query->result_array();
        
    }
    
    
    function insert_program(){
        
         $data = array(
                
                'program' => $this->input->post('program_name'),
                'program_duration' => $this->input->post('program_duration'),
                'program_price' => $this->input->post('program_price'),
                'program_type_id' => $this->input->post('program_type_id'),
                'business_id' => $this->session->userdata('businessid'),
                'program_active' => $this->input->post('program_active')
            );
            
         $this->db->insert('programs', $data);
         return $this->db->insert_id();
        
    }
    function update_program(){
        $data = array(                
                'program' => $this->input->post('program_name'),
                'program_duration' => $this->input->post('program_duration'),
                'program_price' => $this->input->post('program_price'),
                'program_type_id' => $this->input->post('program_type_id'),
                'business_id' => $this->session->userdata('businessid'),
                'program_active' => $this->input->post('program_active')
            );
         $this->db->where('id_programs',$this->input->post('id_programs')) ;  
         $this->db->update('programs', $data);
         return $this->db->affected_rows();
    }
    function insert_program_session(){
        
         $data = array(
                'program_id' => $this->input->post('program_id'),
                'session_name' => $this->input->post('session_name'),
                'program_session_start' => $this->input->post('program_session_start'),
                'program_session_end' => $this->input->post('program_session_end')
               
            );
            
         $this->db->insert('program_sessions', $data);
         return $this->db->insert_id();
        
    }
    
    function update_program_session(){
        $data = array(                
                'session_name' => $this->input->post('session_name'),
                'program_session_start' => $this->input->post('program_session_start'),
                'program_session_end' => $this->input->post('program_session_end')
            );
         $this->db->where('id_program_sessions',$this->input->post('id_program_sessions')) ;  
         $this->db->update('program_sessions', $data);
         return $this->db->affected_rows();
    }
    
    function get_program_session_classes($programsessionid){
        
        $this->db->select('*, date_format(class_start,"%H:%s") start, date_format(class_end,"%H:%s") end');
        $this->db->join('program_sessions','program_sessions.id_program_sessions = program_session_classes.program_session_id');
        $this->db->join('programs','programs.id_programs = program_sessions.program_id');
        $this->db->join('staff','program_session_classes.instructor = staff.id_staff');
        $this->db->where('program_session_id',$programsessionid);
        $query = $this->db->get('program_session_classes');
        
        return $query->result_array();
        
    }
    
    function insert_program_session_class(){
        
        $data = array(
                'program_session_id' => $this->input->post('program_session_id'),
                'weekdays' => $this->input->post('weekday'),
                'class_start' => $this->input->post('class_start'),
                'class_end' => $this->input->post('class_end'),
                'instructor' => $this->input->post('instructor'),
                'classroom' => $this->input->post('classroom'),
            );
            
         $this->db->insert('program_session_classes', $data);
         return $this->db->insert_id();
    }
}
