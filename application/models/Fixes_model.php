<?php

class Fixes_model extends CI_Model {

    function __construct() {

        // Call the Model constructor
        parent::__construct();
    }


    function get_invoices() {
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_status','valid');
        $query = $this->db->get('invoice');

        return $query->result_array();
    }

    function get_sale_invoices() {
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_status','valid');
        $this->db->where('invoice_type','sale');
        $query = $this->db->get('invoice');

        return $query->result_array();
    }
    
    function get_invoice_details($idinvoice) {
        $this->db->select('*');
        $this->db->where('invoice_id',$idinvoice);
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('invoice_details');

        return $query->result_array();
    }

    function update_invoice_details($data, $idinvoicedetails) {
        
        $this->db->set('paid',$data['paid']);
        $this->db->set('invoice_detail_date',$data['invoice_detail_date']);
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('id_invoice_details',$idinvoicedetails);
        $query = $this->db->update('invoice_details', $data);

        return $query;
    }

    function get_invoice_products($idinvoice) {
        $this->db->select('*');
        $this->db->where('invoice_id',$idinvoice);
        
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('invoice_products');

        return $query->result_array();
    }
    function update_invoice_products($data, $idinvoiceproducts) {
        
        $this->db->set('paid',$data['paid']);
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('id_invoice_products',$idinvoiceproducts);
        $query = $this->db->update('invoice_products', $data);

        return $query;
    }
    
    
    function fix_all_sales(){
        
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->delete('business_sales');
        
                
        $sql="insert into business_sales (business_id, month, year, total_sale) 
        (SELECT business_id, left(date_format(invoice_date, '%M'),3), 
        year(invoice_date), SUM(paid_amount) FROM `invoice` 
        WHERE `invoice_status` = 'valid'
	AND `business_id` = ".$this->session->userdata('businessid')." group by month(invoice_date), year(invoice_date) 
        order by year(invoice_date), month(invoice_date))";
        
        $query = $this->db->query($sql);
        
        return "updated";
    }
    
    function fix_services_sales(){
        
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->delete('business_services_sales');
        
                
        $sql="insert into business_services_sales (business_id, month, year, total_sale) 
        (SELECT business_id, left(date_format(invoice_date, '%M'),3), 
        year(invoice_date), SUM(paid_amount) FROM `invoice` 
        WHERE `invoice_status` = 'valid'
        AND `invoice_type` = 'service' 
	AND `business_id` = ".$this->session->userdata('businessid')." group by month(invoice_date), year(invoice_date) 
        order by year(invoice_date), month(invoice_date))";
        
        $query = $this->db->query($sql);
        
        return "updated";
    }
    
    function fix_retail_sales(){
        
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->delete('business_retail_sales');
        
                
        $sql="insert into business_retail_sales (business_id, month, year, total_sale) 
        (SELECT business_id, left(date_format(invoice_date, '%M'),3), 
        year(invoice_date), SUM(paid_amount) FROM `invoice` 
        WHERE `invoice_status` = 'valid'
        AND `invoice_type` = 'sale' 
	AND `business_id` = ".$this->session->userdata('businessid')." group by month(invoice_date), year(invoice_date) 
        order by year(invoice_date), month(invoice_date))";
        
        $query = $this->db->query($sql);
        
        return "updated";
    }
}
