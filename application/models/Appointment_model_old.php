<?php

class Appointment_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }
    
    /*
     * Developer: Tahir Khan Afridi
     * Work Started
     */
    
    function getappointmentbycid(){
        $this->db->select('*');
        $this->db->where('customer_id =', $this->input->post('customerid'));
        $this->db->where('appointment_status =', 'open');
        $this->db->where('customer_appointments.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customer_appointments');
       
        return $query->result_array();
    }
    
    function getopenappointmentbyid($appointmentid){
        
        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = customer_appointments.customer_id');
        $this->db->join('appointment_services', 'appointment_services.customer_visit_id = customer_appointments.id_customer_appointments');
        $this->db->where('customer_visit_id =', $appointmentid);
        $this->db->where('appointment_status =', 'open');
        $this->db->where('customer_appointments.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customer_appointments');
       
        return $query->result_array();
    }
    
    function getappointmentbyid($appointmentid){
        
        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = customer_appointments.customer_id');
        $this->db->join('appointment_services', 'appointment_services.customer_visit_id = customer_appointments.id_customer_appointments');
        $this->db->where('customer_visit_id =', $appointmentid);
        $this->db->where('customer_appointments.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customer_appointments');
       
        return $query->result_array();
    }
    
    function updateAppointment($id, $data){
        
        $where = array(
            'business_id' => $this->session->userdata('businessid'),
            'id_appointment_services' => $id
        );
        
        $this->db->where($where);
        $query = $this->db->update('appointment_services', $data);
        
        return $query;
        
    }
    
    function getStaffDetails($id){
        
        $where = array(
            'business_id' => $this->session->userdata('businessid'),
            'id_staff' => $id,
        );        
        
        $this->db->select('*');
        $this->db->where($where);
        $query = $this->db->get('staff');
        
        return $query->row();
        
    }
    
    function getAppointmentDetails($id){
        
        $where = array(
            'ca.business_id' => $this->session->userdata('businessid'),
            'as.business_id' => $this->session->userdata('businessid'),
            'ca.appointment_status' => 'open',
            'as.id_appointment_services' => $id
        );        
        
        $this->db->select('*');
        $this->db->join('customer_appointments ca', 'as.customer_appointment_id = ca.id_customer_appointments');
        $this->db->join('customers c', 'ca.customer_id = c.id_customers');
        $this->db->join('business_services bs', 'bs.id_business_services = as.service_id');
        $this->db->where($where);
        $query = $this->db->get('appointment_services as');
        
        return $query->result_array();
        
    }
    
    function getOpenAppointments(){
        
        $where = array(
            'ca.business_id' => $this->session->userdata('businessid'),
            'as.business_id' => $this->session->userdata('businessid'),
            'ca.appointment_status' => 'open'
        );        
        
        $this->db->select('*');
        $this->db->join('customer_appointments ca', 'as.customer_appointment_id = ca.id_customer_appointments');
        $this->db->join('customers c', 'ca.customer_id = c.id_customers');
        $this->db->join('business_services bs', 'bs.id_business_services = as.service_id');
        $this->db->where($where);
        $query = $this->db->get('appointment_services as');
        
        return $query->result();
        
    }
    
    function checkDuplicateServices($customer_appointment_id){
        
        $this->db->select('service_id');
        $this->db->where(array('business_id' => $this->session->userdata('businessid'), 'customer_appointment_id' => $customer_appointment_id));
        $query = $this->db->get('appointment_services');
       
        $check = $query->result();
        if($check){
            $service_ids = array();
            
            foreach($check as $c){
                $service_ids[] = $c->service_id;
            }
            
            return $service_ids;
        }
        
    }
    
    function add_appointment($customer_id, $serviceInfo, $appointment_id){
        
        if($appointment_id == 0){
        
            $appointment = array(
                'business_id' => $this->session->userdata('businessid'),
                'customer_id' => $customer_id
            );

            $this->db->insert('customer_appointments', $appointment);
            $appointment_id = $this->db->insert_id();
        
        }
        
        $serviceInfo['customer_appointment_id'] = $appointment_id;
        $serviceInfo['business_id'] = $this->session->userdata('businessid');
            
        $this->db->insert('appointment_services', $serviceInfo);
        
        $appointment_sid = $this->db->insert_id();

        ///update staff status
        $staff_ids = explode('|', $serviceInfo['staff_ids']);

        $this->db->set('staff_available', $appointment_id);
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('time_out', null);
        $this->db->where('staff_available', '');
        $this->db->where_in('staff_id', $staff_ids);
        $this->db->update('staff_attendance');
        
        return $appointment_id."|".$appointment_sid;
       
    }
    
    function update_appointment_time($data, $appointmentid, $service_id, $appointment_sid){
        
        $this->db->where(
                array(
                    'customer_appointment_id' => $appointmentid,
                    'service_id' => $service_id,
                    'id_appointment_services' => $appointment_sid
                )
            );
        
        $this->db->update('appointment_services', $data);
        
    }
    
    function staff_list(){
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->order_by('staff_fullname', 'ASC');
        $query = $this->db->get('staff');
       
        return $query->result();
    }
    
    function staff_info($business_id, $staff_id){
        $this->db->select('*');
        $this->db->where(array(
            'business_id' => $business_id,
            'id_staff' => $staff_id
        ));
        $query = $this->db->get('staff');
       
        return $query->row();
    }
    
    function getOnlineStaff($business_id, $staff_id){
        $query = $this->db->query(""
                . "SELECT * FROM staff s "
                . "JOIN staff_attendance sa ON s.id_staff = sa.staff_id "
                . "WHERE s.business_id = $business_id AND "
                . "sa.business_id = $business_id AND "
                . "s.id_staff = $staff_id AND "
                . "sa.staff_id = $staff_id AND "
                . "sa.time_in BETWEEN NOW() AND sa.time_in "
                . "");
        return $query->row();
    }
    
    /*
     * Developer: Tahir Khan Afridi
     * Work End
     */
    
    function get_appointments() {
        $today = date('Y-m-d');
        $tomorrow= date('Y-m-d H:i:s', strtotime('tomorrow'));
        $this->db->select('*, DATE_FORMAT(visit_services.visit_service_start, "%Y-%m-%d")');
        $this->db->join('customer_visits', 'visit_services.customer_visit_id = customer_visits.id_customer_visits');
        $this->db->join('customers', 'customers.id_customers = customer_visits.customer_id');
        $this->db->where('visit_services.visit_service_start >', $tomorrow);
        //$this->db->where('servicedate >', $today);
        $this->db->where('visit_status =', 'open');
        $this->db->where('customer_visits.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('visit_services.customer_visit_id');
        $query = $this->db->get('visit_services');
       
        return $query->result_array();
    }
    
    function get_by_custid(){
        $today = date('Y-m-d');
        $this->db->select("*, DATE_FORMAT(appointment_date_time,'%b %d %Y') as 'appdate', DATE_FORMAT(appointment_date_time,'%h:%i %p') as 'apptime'");
        $this->db->join('customers', 'customers.id_customers = appointments.customer_id');
        $this->db->where('customer_id', $this->input->post('id'));
        $this->db->where('appointment_date_time >', $today);
        $this->db->where('appointment_status', 'open');
        $this->db->where('appointments.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('appointments');
       
        return $query->result_array();
        
    }
    
//    function add_appointment(){
//
//        $phpdate =  strtotime($this->input->post('appointment-date'));
//        $mysqldate = date('Y-m-d', $phpdate);
//        $date = new DateTime($mysqldate.' '.$this->input->post('appointment-time'));
//                
//        $appointmentdt= date_format($date,'Y-m-d H:i:s');;
//        $appointmentday=date_format($date,'D');;
//        $appointmentmonth=date_format($date,'F');
//        $appointmenthour=date_format($date,'g');
//        $appointmentmin=date_format($date,'i');
//        $appointmentyear=date_format($date,'Y');
//
//       // echo date_format($date,'i'); //$date;
//       // echo $mysqldate;
//        
//        $data = array(
//            'business_id' => $this->session->userdata('businessid'),
//            'customer_id' => $this->input->post('appointment-customer-id'),
//            'appointment_date_time' => $appointmentdt,
//            'appointment_day' => $appointmentday,
//            'appointment_month' => $appointmentmonth,
//            'appointment_hour' => $appointmenthour,
//            'appointment_minutes' => $appointmentmin,
//            'appointment_year' => $appointmentyear,
//            'appointment_remarks' => $this->input->post('appointment-remarks')
//        );
//
//        $this->db->insert('appointments', $data);
//        return $this->db->insert_id();
//    }
    
    function  update_status(){
        $data = array(
            'appointment_status' => $this->input->post('status')
        );
         $this->db->where('id_appointments', $this->input->post('id'));
        $this->db->update('appointments', $data);
        return $this->db->affected_rows();
    }
    
}
