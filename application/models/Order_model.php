<?php

class Order_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }

    function get_orders() {
        $today = date('Y-m-d');
        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = customer_orders.customer_id');
       // $this->db->where('customer_visit_date >', $today);
        $this->db->where('order_status =', 'open');
        $this->db->where('customer_orders.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customer_orders');
       
        return $query->result_array();
    }
    
    function get_open_orders(){
        $this->db->select('*, date_format(customer_order_date,"%d-%m-%Y %H:%i") as "mDate"');
        $this->db->join('customers', 'customers.id_customers = customer_orders.customer_id');
        $this->db->join('order_products', 'customer_orders.id_customer_order = order_products.customer_order_id');
        $this->db->join('business_products', 'order_products.product_id = business_products.id_business_products');
        $this->db->join('business_brands', 'business_products.brand_id = business_brands.id_business_brands');
        $this->db->where('order_status', 'open');
        $this->db->where('customer_orders.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('customer_orders.id_customer_order');
        $query = $this->db->get('customer_orders');
        return $query->result_array();
    }
    
    function add_order(){
        // Unescape the string values in the JSON array
        $tableData = stripcslashes($_POST['orderdata']);

        // Decode the JSON array
        $tableData = json_decode($tableData,TRUE);

        // now $tableData can be accessed like a PHP array
        // echo $tableData[0]['servicename'];
        
        //add new customer_visit
         $order = array(
            'business_id' => $this->session->userdata('businessid'),
            'customer_id' => $tableData[0]['customerid']
        );
        $this->db->insert('customer_orders', $order);
        $order_id = $this->db->insert_id();
        
        $data = [];
        
        foreach($tableData as $row){
           
            $data = array(
                'business_id' => $this->session->userdata('businessid'),
                'customer_order_id' => $order_id,
                'product_id' => $row['productid'],
                'product_name' => $row['productname'],
                'category' => $row['category'],
                'staff_id' => $row['staffid'],
                'staff_name' => $row['staff'],
                'qty' => $row['qty'],
                'stockfrom' => $row['stockfrom'],
                'batch' => $row['batch'],
                'batch_id' => $row['batch_id']
            );
            
            $this->db->insert('order_products', $data);
            
           
        }
        return $order_id;
       
    }
    
    function check_order_status($order_id){
        $this->db->select('*');
        $this->db->where('id_customer_order', $order_id);
       // $this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customer_orders');
        return $query->row();
    }
    
    function update_order(){
        $customerid="";
        
         // Unescape the string values in the JSON array
        $tableData = stripcslashes($_POST['orderdata']);

        // Decode the JSON array
        $tableData = json_decode($tableData,TRUE);
        
        
        // now $tableData can be accessed like a PHP array
        //echo $tableData[0]['servicename'];
        //echo $this->input->post('visitid');
        
        //update customer_order_products
        $this->db->where('customer_order_id', $this->input->post('orderid', TRUE));
        $this->db->delete('order_products');
        
        foreach($tableData as $row){
            $customerid = $row['customerid'];
            $data = array(
                'business_id' => $this->session->userdata('businessid'),
                'customer_order_id' => $this->input->post('orderid', TRUE),
                'product_id' => $row['productid'],
                'product_name' => $row['productname'],
                'category' => $row['category'],
                'staff_id' => $row['staffid'],
                'staff_name' => $row['staff'],
                'qty' => $row['qty'],
                'stockfrom' => $row['stockfrom'],
                'batch'=> $row['batch'],
                'batch_id'=> $row['batch_id']
            );
            
            $this->db->insert('order_products', $data);
           
        }
        
        if($customerid !==""){
            
            $this->db->where('id_customer_order', $this->input->post('orderid', TRUE));
            $this->db->update('customer_orders', array('customer_id' => $customerid));
            
        }
        
        return $this->input->post('orderid');
    }
    
    function getopenorderbyid($orderid){
        
        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = customer_orders.customer_id');
        $this->db->join('order_products', 'order_products.customer_order_id = customer_orders.id_customer_order');
        $this->db->where('customer_order_id =', $orderid);
        $this->db->where('order_status =', 'open');
        if($this->session->userdata('common_products')=='No'){
            $this->db->where('customer_orders.business_id', $this->session->userdata('businessid'));
        }
        $query = $this->db->get('customer_orders');
       
        return $query->result_array();
    }
    
    function getinvoicedorderbyid($orderid){
        
        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = customer_orders.customer_id');
        $this->db->join('order_products', 'order_products.customer_order_id = customer_orders.id_customer_order');
        $this->db->where('customer_order_id =', $orderid);
        $this->db->where('order_status =', 'invoiced');
        if($this->session->userdata('common_products')=='No'){
        $this->db->where('customer_orders.business_id', $this->session->userdata('businessid'));
        }
        $query = $this->db->get('customer_orders');
       
        return $query->result_array();
    }
    
    function getorderbyid($orderid){
        
        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = customer_orders.customer_id');
        $this->db->join('order_products', 'order_products.customer_order_id = customer_orders.id_customer_order');
        $this->db->where('order_products.customer_order_id =', $orderid);
        if($this->session->userdata('common_products')=='No'){
        $this->db->where('customer_orders.business_id', $this->session->userdata('businessid'));
        }
        $query = $this->db->get('customer_orders');
       
        return $query->result_array();
    }
    
    function getorderbycid($customer_id){
        $this->db->select('*');
        $this->db->where('customer_id =', $customer_id);
        $this->db->where('order_status =', 'open');
        if($this->session->userdata('common_products')=='No'){
        $this->db->where('customer_orders.business_id', $this->session->userdata('businessid'));
        }
        $query = $this->db->get('customer_orders');
       
        return $query->result_array();
    }
    
    function getorderproducts($ids, $orderid){
 
        $this->db->select('*');
        $this->db->join('business_brands', 'business_brands.id_business_brands = business_products.brand_id');
        $this->db->join('order_products', 'order_products.product_id = business_products.id_business_products');
        $this->db->where_in('id_business_products', $ids);
        $this->db->where('order_products.customer_order_id', $orderid);
        if($this->session->userdata('common_products')=='No'){
            $this->db->where('business_products.business_id', $this->session->userdata('businessid'));
        }
        $query = $this->db->get('business_products');
        
        return $query->result_array();
    }
    
    function getlast4orders($customerid){
        $this->db->select('*, date_format(customer_order_date,"%d-%m-%Y") as order_date');
        $this->db->join('order_products', 'order_products.customer_order_id = customer_orders.id_customer_order');
        if($this->session->userdata('common_products')=='No'){
        $this->db->where('customer_orders.business_id', $this->session->userdata('businessid'));
        }
        $this->db->where('order_status =', 'invoiced');
        $this->db->where('customer_orders.customer_id', $customerid);
        $this->db->order_by('customer_orders.id_customer_order DESC, product_id ASC');
        $query = $this->db->get('customer_orders');
                
        return $query->result_array();
    }
    
}
