<?php

class Dailysummary_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }

    function get_services($date) {
        
        $sql="SELECT count(*) as services, sum(total_payable) as amount
                FROM invoice
                where date_format(invoice_date,'%Y-%m-%d') = '".$date."' 
                 and invoice_status='valid' and reference_invoice_number=''
                and business_id=".$this->session->userdata('businessid')
                ." and invoice_type='service'";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_retail($date) {
        
        $sql="SELECT count(*) as retail, sum(total_payable) as amount
                FROM invoice
                where date_format(invoice_date,'%Y-%m-%d') = '".$date."' 
                 and invoice_status='valid'
                and business_id=".$this->session->userdata('businessid')
                ." and invoice_type='sale'";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_voucher($date) {
        
        $sql="SELECT count(*) as vouchers, sum(paid_cash+paid_card+paid_check) as amount
                FROM order_vouchers
                where date_format(voucher_date,'%Y-%m-%d') = '".$date."'                 
                and business_id=".$this->session->userdata('businessid').";";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    
    function get_loyalty_discounts($date) {
        
        $sql="SELECT count(*) as count, sum(discount) as amount
            FROM invoice
            where date_format(invoice_date,'%Y-%m-%d') = '".$date."' 
            and invoice_status='valid'
            and business_id=".$this->session->userdata('businessid')." and loyalty_used>0";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_redemptions($date){
        
        $sql="SELECT 'Normal' as type, count(*) as count, ifnull(sum(invoice_details.discount),0) as amount
            FROM invoice_details
            join invoice on invoice.id_invoice=invoice_details.invoice_id
            where date_format(invoice_date,'%Y-%m-%d') = '".$date."' 
            and invoice_status='valid'
            and invoice_details.business_id=".$this->session->userdata('businessid')."
            and discount_type='Normal'
            union  
            SELECT 'Promotion' as type, count(*) as count, ifnull(sum(invoice_details.discount),0) as amount
            FROM invoice_details
            join invoice on invoice.id_invoice=invoice_details.invoice_id
            where date_format(invoice_date,'%Y-%m-%d') = '".$date."' 
            and invoice_status='valid'
            and invoice_details.business_id=".$this->session->userdata('businessid')."
            and discount_type='Promotion'
            union 
            SELECT 'Birthday' as type, count(*) as count, ifnull(sum(invoice_details.discount),0) as amount
            FROM invoice_details
            join invoice on invoice.id_invoice=invoice_details.invoice_id
            where date_format(invoice_date,'%Y-%m-%d') = '".$date."' 
            and invoice_status='valid'
            and invoice_details.business_id=".$this->session->userdata('businessid')."
            and discount_type='Birthday'
            union 
            SELECT 'New Customer' as type, count(*) as count, ifnull(sum(invoice_details.discount),0) as amount
            FROM invoice_details
            join invoice on invoice.id_invoice=invoice_details.invoice_id
            where date_format(invoice_date,'%Y-%m-%d') = '".$date."' 
            and invoice_status='valid'
            and invoice_details.business_id=".$this->session->userdata('businessid')."
            and discount_type='New Customer'
            union 
            SELECT 'Lapse' as type, count(*) as count, ifnull(sum(invoice_details.discount),0) as amount
            FROM invoice_details
            join invoice on invoice.id_invoice=invoice_details.invoice_id
            where date_format(invoice_date,'%Y-%m-%d') = '".$date."' 
            and invoice_status='valid'
            and invoice_details.business_id=".$this->session->userdata('businessid')."
            and discount_type='Lapse'"    
                ;
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function get_newcustomers($date){
        
          $sql="select count(*) as 'NewCustomers'
            from customers 
            where date_format(created_on,'%Y-%m-%d') = '".$date."' 
            and business_id=".$this->session->userdata('businessid');
        
        $query = $this->db->query($sql);
        return $query->result_array();
        
    }
    
    function get_returningcustomers($date){
        
          $sql="select count(distinct customer_id) as 'Returning'
                from customers 
                join invoice on invoice.customer_id = customers.id_customers
                where date_format(created_on,'%Y-%m-%d') != '".$date."' 
                and date_format(invoice_date,'%Y-%m-%d') = '".$date."' 
                and customers.business_id = ".$this->session->userdata('businessid');
        
        $query = $this->db->query($sql);
        return $query->result_array();
        
    }
    function get_customers_to_date($date){
        
        $sql="select count(*) as 'Customers'
        from customers 
        where created_on <= '".$date."'
        and business_id = ".$this->session->userdata('businessid');

        $query = $this->db->query($sql);
        return $query->result_array();
        
    }
    
    function get_male_customers($date){
        $sql="select count(*) as 'Male'
        from customers 
        where created_on <= '".$date."'
        and business_id = ".$this->session->userdata('businessid')."
        and customer_gender = 'M'";

        $query = $this->db->query($sql);
        return $query->result_array();
        
    }
    
    function get_female_customers($date){
        $sql="select count(*) as 'Female'
        from customers 
        where created_on <= '".$date."'
        and business_id = ".$this->session->userdata('businessid')."
        and customer_gender = 'F'";

        $query = $this->db->query($sql);
        return $query->result_array();
        
    }
    
}
