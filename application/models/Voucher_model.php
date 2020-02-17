<?php

class Voucher_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function validate_voucher($voucherno) {
        $now = date('Y-m-d H:i:s');
        $this->db->select("*");
        $this->db->join('customers c', 'ov.customer_id = c.id_customers');
        $this->db->where('ov.voucher_number', $voucherno);
        $this->db->where('ov.voucher_status', 'open');
        $this->db->where('ov.valid_until > ', $now);
        $this->db->where('ov.remaining_amount > ', 0);
       // $this->db->where('ov.business_id', $this->session->userdata('businessid'));
       // $this->db->where('c.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('order_vouchers ov');
        return $query->result();
    }

    function update_remaining_amount($voucherno, $remaining, $remaining_services) {
        $this->db->where('voucher_number', $voucherno);
        $query = $this->db->update('order_vouchers', array(
            'remaining_amount' => $remaining,
            'remaining_service_ids' => $remaining_services,
            'voucher_status' => $remaining > 0 ? 'open' : 'closed'
        ));
        return $query;
    }

    //Voucher List view function.....
    function voucher_list() {
        $this->db->select("c.customer_name,v.id_order_vouchers,v.voucher_number,v.type,v.service_names,v.amount,date_format(v.voucher_date,'%d-%m-%Y') as date,date_format(v.valid_until,'%d-%m-%Y') as valid_date,v.voucher_status,v.remaining_amount");
        $this->db->join('customers c', 'c.id_customers = v.customer_id');
        $this->db->where('v.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('order_vouchers v');
        return $query->result_array();
    }

    
     function gettodayvouchers(){
        
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d H:i:s', strtotime('tomorrow'));
        $this->db->select("c.customer_name,v.id_order_vouchers,v.voucher_number,v.type,v.service_names,v.amount,date_format(v.voucher_date,'%d-%m-%Y') as date,date_format(v.valid_until,'%d-%m-%Y') as valid_date,v.voucher_status,v.remaining_amount");
        $this->db->join('customers c', 'c.id_customers = v.customer_id');
        $this->db->where('v.business_id', $this->session->userdata('businessid'));
        $this->db->where('v.voucher_date >', $today);
        $this->db->where('v.voucher_date <', $tomorrow);
        $query = $this->db->get('order_vouchers v');
        
        return $query->result_array();
    }
    
    
    function getdayvouchers($today){
        
        $tomorrow = date('Y-m-d H:i:s', strtotime('tomorrow'));
        $this->db->select("c.customer_name,v.id_order_vouchers,v.voucher_number,v.type,v.service_names,v.amount,date_format(v.voucher_date,'%d-%m-%Y') as date,date_format(v.valid_until,'%d-%m-%Y') as valid_date,v.voucher_status,v.remaining_amount");
        $this->db->join('customers c', 'c.id_customers = v.customer_id');
        $this->db->where('v.business_id', $this->session->userdata('businessid'));
        $this->db->where('date_format(v.voucher_date,"%Y-%m-%d") =', $today, False);
        
        $query = $this->db->get('order_vouchers v');
        
        return $query->result_array();
    }
    
    
    //Voucher update function....
    function voucher_update() {
        $data = array(
            'valid_until' => $this->input->post('valid_until', TRUE) . ' 23:59:59'
        );
        
        $this->db->where('id_order_vouchers', $this->input->post('id_order_vouchers', TRUE));
        $query = $this->db->update('order_vouchers', $data);
        return $query;
    }

    //Voucher delete view function...
    function delete_voucher($id) {
        $this->db->where('id_order_vouchers', $id);
        $result = $this->db->delete('order_vouchers');
        if ($result) {
            return TRUE;
        }
    }

}
