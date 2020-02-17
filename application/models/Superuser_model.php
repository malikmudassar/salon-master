<?php

class Superuser_model extends CI_Model {

    function __construct() {

        // Call the Model constructor
        parent::__construct();
    }
    
    function getsupervisordayinvoices($today){
        
        //$today = date('Y-m-d');
        //$tomorrow = date('Y-m-d H:i:s', strtotime('tomorrow'));
        
        $this->db->select("*", False);
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('date_format(invoice_date , "%Y-%m-%d") =', $today);
        $query = $this->db->get('invoice');
              
        return $query->result_array();
    }
    
    function get_invoice_for_edit($id){
        
        $this->db->select("*");
        $this->db->where('invoice.id_invoice', $id);
        $query = $this->db->get('invoice');
             
        return $query->row();
    }
    
    function update_super_invoice(){
       
        $this->db->where('id_invoice', $this->input->post('id_invoice'));
        $data = array(
            'invoice_date' => $this->input->post('invoice_date', TRUE),
            'invoice_number' => $this->input->post('invoice_number', TRUE),
            'invoice_type' => $this->input->post('invoice_type', TRUE),
            'invoice_status' => $this->input->post('invoice_status', TRUE),
            'customer_id' => $this->input->post('customer_id', TRUE),
            'customer_name' => $this->input->post('customer_name', TRUE),
            'customer_cell' => $this->input->post('customer_cell', TRUE),
            'reference_invoice_number' => $this->input->post('reference_invoice_number', TRUE),
            'visit_id' => $this->input->post('visit_id', TRUE),
            'visit_time' => $this->input->post('visit_time', TRUE),
            'sub_total' => $this->input->post('sub_total', TRUE),
            'gross_amount' => $this->input->post('gross_amount', TRUE),
            'tax_total' => $this->input->post('tax_total', TRUE),
            'cc_charge' => $this->input->post('cc_charge', TRUE),
            'discount' => $this->input->post('discount'),
            'cctip' => $this->input->post('cctip', TRUE),
            'other_charges' => $this->input->post('other_charges', TRUE),
            'cc_charge' => $this->input->post('cc_charge', TRUE),
            'net_amount' => $this->input->post('net_amount', TRUE),
            'advance_amount' => $this->input->post('advance_amount', TRUE),            
            'advance_inst' => $this->input->post('advance_inst', TRUE),
            'total_payable' => $this->input->post('total_payable', TRUE),
            'retained_used' => $this->input->post('retained_used'),
            'retained_amount_used' => $this->input->post('retained_amount_used', TRUE),
            'loyalty_used' => $this->input->post('loyalty_used', TRUE),
            'payment_mode' => $this->input->post('payment_mode', TRUE),
            'paid_amount' => $this->input->post('paid_amount', TRUE),
            'paid_cash' => $this->input->post('paid_cash', TRUE),
            'paid_card' => $this->input->post('paid_card', TRUE),
            'paid_check' => $this->input->post('paid_check', TRUE),
            'paid_voucher' => $this->input->post('paid_voucher', TRUE),
            'balance' => $this->input->post('balance'),
            'returnamount' => $this->input->post('returnamount', TRUE),
            'loyalty_earned' => $this->input->post('loyalty_earned', TRUE),
            'retained_amount' => $this->input->post('retained_amount', TRUE)
        );
        $this->db->update('invoice', $data);
        return $this->db->affected_rows();
        
    }

    
     function getsupervisordayvisits($today){
        
        $this->db->select("*, sum(visit_advance.advance_amount) advance_amount, date_format(visit_services.visit_service_start, '%Y-%m-%d %H:%i:%s') as 'visitdate'", False);
        $this->db->join("visit_services", "visit_services.customer_visit_id = customer_visits.id_customer_visits");
        $this->db->join("customers", "customer_visits.customer_id=customers.id_customers");
        $this->db->join("visit_advance", "visit_advance.customer_visit_id=customer_visits.id_customer_visits","left");
        $this->db->where('customer_visits.business_id', $this->session->userdata('businessid'));
        $this->db->where('date_format(visit_services.visit_service_start, "%Y-%m-%d") =', $today);
        $this->db->group_by("id_customer_visits");
        $query = $this->db->get('customer_visits');
              
        return $query->result_array();
    }
    
    
    function get_visit_for_edit($id){
        
        $this->db->select("*");
        $this->db->join("customers", "customer_visits.customer_id=customers.id_customers");
        $this->db->where('customer_visits.id_customer_visits', $id);
        $query = $this->db->get('customer_visits');
             
        return $query->row();
    }
    
    function update_super_visit(){
      
        $this->db->where('id_customer_visits', $this->input->post('id_customer_visits'));
        $data = array(
            'customer_id'  => $this->input->post('customer_id', TRUE),
            
            'visit_status' => $this->input->post('visit_status', TRUE),
            'advance_amount' => $this->input->post('advance_amount', TRUE),
            'advance_date' => $this->input->post('advance_date', TRUE),
            'advance_mode' => $this->input->post('advance_mode', TRUE),
            'advance_inst' => $this->input->post('advance_inst', TRUE)
        );
        $this->db->update('customer_visits', $data);
        return $this->db->affected_rows();
        
        
    }
    function update_super_advance(){
         $this->db->where('id_visit_advance', $this->input->post('id_visit_advance'));
        $data = array(
            
            'advance_amount' => $this->input->post('advance_amount', TRUE),
            'advance_date' => $this->input->post('advance_date', TRUE),
            'advance_mode' => $this->input->post('advance_mode', TRUE),
            'advance_inst' => $this->input->post('advance_inst', TRUE),
            'advance_remarks' => $this->input->post('advance_remarks', TRUE),
            'advance_cc_charge' => $this->input->post('advance_cc_charge', TRUE),
        );
        $this->db->update('visit_advance', $data);
        return $this->db->affected_rows();
        
    }
}
