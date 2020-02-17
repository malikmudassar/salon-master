<?php

class Expense_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_daily_expense_list($startdate, $enddate) {
        

        $this->db->select('*,DATE_FORMAT(av.created_on, "%d-%m-%Y") voucher_date');
        $this->db->join('account_voucher_detail avd','av.id_account_vouchers = account_voucher_id');
        $this->db->join('account_heads ah', 'ah.id_account_heads = avd.account_head_id');
        $this->db->where('av.business_id', $this->session->userdata('businessid'));
        $this->db->where('av.voucher_date >= ', $startdate);
        $this->db->where('av.voucher_date <= ', $enddate);
        $this->db->where('ah.account_type', 'Expense');
        $this->db->where('ah.account_head', 'office expense');
        $this->db->where('av.voucher_type', 1);
        $this->db->where('av.voucher_status =', 'Active');
        $this->db->order_by('av.created_on', 'desc');
        $query = $this->db->get('account_vouchers av');

        return $query->result_array();
    }

    
    function get_daily_petty_expense($startdate, $enddate) {
        

        $this->db->select('*,DATE_FORMAT(av.created_on, "%d-%m-%Y") voucher_date');
        $this->db->join('account_voucher_detail avd','av.id_account_vouchers = account_voucher_id');
        $this->db->join('account_heads ah', 'ah.id_account_heads = avd.account_head_id');
        $this->db->where('av.business_id', $this->session->userdata('businessid'));
        $this->db->where('av.voucher_date >= ', $startdate);
        $this->db->where('av.voucher_date <= ', $enddate);
        $this->db->where('ah.account_type', 'Expense');
        $this->db->where('ah.account_head', 'office expense');
        $this->db->where('av.voucher_type', 1);
        $this->db->where('av.voucher_status =', 'Active');
        $this->db->order_by('av.created_on', 'desc');
        $query = $this->db->get('account_vouchers av');

        return $query->result_array();
    }
    
    function account_voucher_cancelled() {
        $data = array(
            'voucher_status' => 'cancelled'
        );
        $this->db->where('id_account_vouchers', $this->input->post('id_account_voucher'));
        $result = $this->db->update('account_vouchers', $data);
        return $this->input->post('id_account_voucher');
    }

    function add_account_voucher() {
        $data = array(
            'description' => $this->input->post('description'),
            'voucher_amount' => $this->input->post('voucher_amount'),
            'voucher_status' => $this->input->post('voucher_status'),
            'voucher_date' => $this->input->post('voucher_date'),
            'created_by' => $this->session->userdata('username'),
            'business_id' => $this->session->userdata('businessid')
        );
        $this->db->insert('account_vouchers', $data);
        return $this->db->insert_id();
    }

    function get_account_voucher_by_id() {
        $this->db->select('*');
        $this->db->where('av.business_id', $this->session->userdata('businessid'));
        $this->db->where('av.id_account_vouchers', $this->input->post('id_account_vouchers'));
        $query = $this->db->get('account_vouchers av');

        return $query->row();
    }

    function update_account_voucher() {
        $data = array(
            'description' => $this->input->post('description'),
            'voucher_amount' => $this->input->post('voucher_amount'),
            'voucher_status' => $this->input->post('voucher_status'),
            'voucher_date' => $this->input->post('voucher_date'),
            'created_by' => $this->session->userdata('username')
        );
        $this->db->where('id_account_vouchers', $this->input->post('id_account_vouchers'));
        $this->db->update('account_vouchers', $data);
        return $this->input->post('id_account_vouchers');
    }

}
