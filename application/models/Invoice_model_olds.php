<?php

class Invoice_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }

    function getnextinvoicenumber(){
        $this->db->select_max('id_invoice');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('invoice');
        
        return $query->result_array();
        
    }
  

    function update_invoice(){
        
        $visitid=$this->input->post('visitid');
        $invoicenumber=$this->input->post('invoicenumber');
        $customerid=$this->input->post('customerid');
        $subtotal=$this->input->post('subtotal');
        $discount=$this->input->post('discount');
        $grosstotal=$this->input->post('grosstotal');
        $grandtotal=$this->input->post('grandtotal');
        $taxes=$this->input->post('taxes');
        $taxtotal=$this->input->post('taxtotal');
        $paymentmode=$this->input->post('mode');
        $instrumentnumber=$this->input->post('instrument_number');
        $balance=$this->input->post('balance');
                
        //Get customer & visit
        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = customer_visits.customer_id');
        $this->db->where('customer_visits.id_customer_visits', $visitid);
        $this->db->where('customer_visits.business_id', $this->session->userdata('businessid'));
        $customervisits = $this->db->get('customer_visits');
        $customervisit = $customervisits->row();
        
        //Get visit details        
        $this->db->select('*');
        $this->db->join('business_services', 'business_services.id_business_services = visit_services.service_id');
        $this->db->join('service_category', 'service_category.id_service_category = business_services.service_category_id');
        $this->db->where('visit_services.customer_visit_id', $visitid);
        $this->db->where('visit_services.business_id', $this->session->userdata('businessid'));
        $visitdetails = $this->db->get('visit_services');
        
        //Create invoice        
        $data = array(
            'customer_id'=>$customerid,
            'invoice_number'=>$invoicenumber,
            'business_id'=>$this->session->userdata('businessid'),
            'customer_name'=> $customervisit->customer_name,
            'customer_cell'=> $customervisit->customer_cell,
            'customer_email'=> $customervisit->customer_email,
            'customer_address'=> $customervisit->customer_address,
            'tax_total'=>$taxtotal,
            'discount' => $discount,
            'gross_amount' => $grosstotal,
            'net_amount' => $grandtotal,
            'visit_id' => $visitid,
            'sub_total' => $subtotal,
            'payment_mode'=>$paymentmode,
            'instrument_number'=>$instrumentnumber,
            'balance'=>$balance
        );

        $this->db->insert('invoice', $data);
        $invoiceid =  $this->db->insert_id();
        
        //insert invoice taxes
        if(isset($taxes)){
            foreach($taxes as $tax){
                $data=array(
                    'invoice_id'=>$invoiceid,
                    'business_id'=>$this->session->userdata('businessid'),
                    'invoice_tax_name'=>$tax['taxname'],
                    'invoice_tax'=>$tax['tax']
                );
                $this->db->insert('invoice_taxes', $data);
            }
        }
        
        //insert invoice details
        foreach ($visitdetails->result() as $visitdetail)
        {
            $services= array(
                'invoice_id'=>$invoiceid,
                'business_id'=>$this->session->userdata('businessid'),
                'service_category'=>$visitdetail->service_category,
                'service_name'=>$visitdetail->service_name,
                'staff'=>$visitdetail->staff_names,
                'products'=>$visitdetail->product_names,
                'price'=>$visitdetail->service_rate
            );
            $this->db->insert('invoice_details', $services);
            
            //insert staff services
            $staffids=explode('|',$visitdetail->staff_ids);        
            $x=0;
            for($x=0; $x<sizeof($staffids)-1;$x++){
               // echo $x.'=>'.$staffids[$x].' , ';
                $commissiont=$visitdetail->service_rate / $visitdetail->service_rate;
                $commission=$commissiont * 100;
                $staffservice=array(
                    'invoice_id'=>$invoiceid,
                    'business_id'=>$this->session->userdata('businessid'),
                    'visit_id'=>$visitid,
                    'staff_id'=>$staffids[$x],
                    'service_category'=>$visitdetail->service_category,
                    'service_name'=>$visitdetail->service_name,
                    'price'=>$visitdetail->service_rate,
                    'staff_commission'=>$commission
                );
                $this->db->insert('staff_services', $staffservice); 
                
                ///update staff status
                
                $cur_visit_id=0;
                $cur_staffid='% '.trim($staffids[$x]).' |%' ;
                
                $cur_visit_id = $this->nextvisitreturn($cur_staffid, $visitid);
                               
                if($cur_visit_id > 0){
                    $this->db->set('staff_available', $cur_visit_id);
                    $this->db->where('business_id', $this->session->userdata('businessid'));
                    $this->db->where('time_out', null);
                    //$this->db->where('staff_available<>', '');
                    $this->db->where('staff_id', trim($staffids[$x]));
                    $this->db->update('staff_attendance');
                } else {
                    $this->db->set('staff_available', '');
                    $this->db->where('business_id', $this->session->userdata('businessid'));
                    $this->db->where('time_out', null);
                    $this->db->where('staff_available<>', '');
                    $this->db->where('staff_id', trim($staffids[$x]));
                    $this->db->update('staff_attendance');
                }
                
//                $this->db->set('staff_available', '');
//                $this->db->where('business_id', $this->session->userdata('businessid'));
//                $this->db->where('time_out', null);
//                $this->db->where('staff_available<>', '');
//                $this->db->where('staff_id', $staffids[$x]);
//                $this->db->update('staff_attendance');
                
            }
            
            //insert invoice products
//            $productids=explode('|',$visitdetail->product_names);        
//            $x=0;
//            for($x=0; $x<sizeof($productids)-1;$x++){
//               // echo $x.'=>'.$productids[$x].' , ';
//                $serviceproduct=array(
//                    'invoice_id'=>$invoiceid,
//                    'business_id'=>$this->session->userdata('businessid'),
//                    'visit_id'=>$visitid,
//                    'staff_names'=>$visitdetail->staff_names,
//                    'product_name'=>$productids[$x]
//                    
//                );
//                $this->db->insert('invoice_products', $serviceproduct);                
//            }
            
        }
        
        //update customer visit (mark as invoiced)
        $this->db->set('visit_status', 'invoiced');
        $this->db->where('id_customer_visits', $visitid);
        $this->db->update('customer_visits');
        return $invoiceid;
    }
    
    
    function update_order_invoice(){
                
        $orderid=$this->input->post('orderid');
        $invoicenumber=$this->input->post('invoicenumber');
        $customerid=$this->input->post('customerid');
        $subtotal=$this->input->post('subtotal');
        $discount=$this->input->post('discount');
        $grosstotal=$this->input->post('grosstotal');
        $grandtotal=$this->input->post('grandtotal');
        $taxes=$this->input->post('taxes');
        $taxtotal=$this->input->post('taxtotal');
        $paymentmode=$this->input->post('mode');
        $instrumentnumber=$this->input->post('instrument_number');
        $balance=$this->input->post('balance');
        
        //Get customer & order
        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = customer_orders.customer_id');
        $this->db->where('customer_orders.id_customer_order', $orderid);
        $this->db->where('customer_orders.business_id', $this->session->userdata('businessid'));
        $customerorders = $this->db->get('customer_orders');
       
        $customerorder = $customerorders->row();
        
        //Get order products
        $this->db->select('*');
        $this->db->join('business_products', 'business_products.id_business_products = order_products.product_id');
        $this->db->join('business_brands', 'business_brands.id_business_brands = business_products.brand_id');
        $this->db->where('order_products.customer_order_id', $orderid);
        $this->db->where('order_products.business_id', $this->session->userdata('businessid'));
        $orderproducts = $this->db->get('order_products');
        
        //Create invoice        
        $data = array(
            'customer_id'=>$customerid,
            'invoice_number'=>$invoicenumber,
            'business_id'=>$this->session->userdata('businessid'),
            'customer_name'=> $customerorder->customer_name,
            'customer_cell'=> $customerorder->customer_cell,
            'customer_email'=> $customerorder->customer_email,
            'customer_address'=> $customerorder->customer_address,
            'tax_total'=>$taxtotal,
            'discount' => $discount,
            'gross_amount' => $grosstotal,
            'net_amount' => $grandtotal,
            'visit_id' => $orderid,
            'sub_total' => $subtotal,
            'invoice_type'=>'sale',
            'payment_mode'=>$paymentmode,
            'instrument_number'=>$instrumentnumber,
            'balance'=>$balance
        );

        $this->db->insert('invoice', $data);
        $invoiceid =  $this->db->insert_id();
        
        //insert invoice taxes
        if(isset($taxes)){
            foreach($taxes as $tax){
                $data=array(
                    'invoice_id'=>$invoiceid,
                    'business_id'=>$this->session->userdata('businessid'),
                    'invoice_tax_name'=>$tax['taxname'],
                    'invoice_tax'=>$tax['tax']
                );
                $this->db->insert('invoice_taxes', $data);
            }
        }
        
        //insert invoice products
        foreach ($orderproducts->result() as $orderproduct)
        {
            $products= array(
                'invoice_id'=>$invoiceid,
                'business_id'=>$this->session->userdata('businessid'),
                'brand_name'=>$orderproduct->business_brand_name,
                'product_name'=>$orderproduct->product,
                'staff_name'=>$orderproduct->staff_name,
                'invoice_qty'=>$orderproduct->qty,
                'price'=>$orderproduct->price
            );
            $this->db->insert('invoice_products', $products);
            
            //insert staff sale
            $amount=$orderproduct->price*$orderproduct->qty;
            
            $staffsale=array(
                'invoice_id'=>$invoiceid,
                'business_id'=>$this->session->userdata('businessid'),
                'order_id'=>$orderid,
                'staff_id'=>$orderproduct->staff_id,
                'brand_name'=>$orderproduct->business_brand_name,
                'product_name'=>$orderproduct->product,
                'price'=>$amount,
                'sale_type'=>'sale',
                'qty'=>$orderproduct->qty
            );
            $this->db->insert('staff_services', $staffsale);                
            
        }
        
        //update customer order (mark as invoiced)
        $this->db->set('order_status', 'invoiced');
        $this->db->where('id_customer_order', $orderid);
        $this->db->update('customer_orders');
        return $invoiceid;
    }
    
    
    function gettodayinvoices(){
        $today = date('Y-m-d');
        
        $this->db->select('*');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice.invoice_date>', $today);
        $this->db->where('invoice.invoice_status=', 'valid');
        $query = $this->db->get('invoice');
        
        return $query->result_array();
    }
    
    function cancel_invoice(){
        
        $this->db->set('invoice_status', 'cancelled');
        $this->db->where('id_invoice', $this->input->post('invoiceid'));
        $this->db->update('invoice');
        
        if($this->input->post('visitid')!==null && $this->input->post('visitid')!==''){
            $this->db->set('visit_status', 'open');
            $this->db->where('id_customer_visits', $this->input->post('visitid'));
            $this->db->update('customer_visits');
        }
        return $this->db->affected_rows();
    }
    
    function getinvoicebyid($invoiceid){
        $this->db->select('*');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice.id_invoice=', $invoiceid);
        $query = $this->db->get('invoice');
        
        return $query->result_array();
    }
    
    function getinvoicedetails($invoiceid){
        $this->db->select('*');
        $this->db->where('invoice_details.invoice_id=', $invoiceid);
        $query = $this->db->get('invoice_details');
        
        return $query->result_array();
    }
    
    function getinvoiceproducts($invoiceid){
        $this->db->select('*');
        $this->db->where('invoice_products.invoice_id=', $invoiceid);
        $query = $this->db->get('invoice_products');
        
        return $query->result_array();
    }
    
    
    function getinvocietaxes($invoiceid){
        $this->db->select('*');
        $this->db->where('invoice_taxes.invoice_id=', $invoiceid);
        $query = $this->db->get('invoice_taxes');
        
        return $query->result_array();
    }
    
    function nextvisitreturn($cur_staffid, $visitid){
        
        $cur_visit_id=0;
        
        $this->db->select('id_customer_visits');
        $this->db->join('customer_visits', 'customer_visits.id_customer_visits= visit_services.customer_visit_id');
        $this->db->where('customer_visits.visit_status','open');
        $this->db->where('visit_services.staff_ids like',$cur_staffid);
        $this->db->where('customer_visits.id_customer_visits <>',$visitid);
        $this->db->order_by('id_customer_visits', 'DESC');
        $this->db->limit(1);
        $nextvisitnumber=$this->db->get('visit_services');

        foreach ($nextvisitnumber->result() as $row){
            
            $cur_visit_id = $row->id_customer_visits;
            
        }
       
        return $cur_visit_id;
        
    }

    function discount_login() {
        $password = md5($this->db->escape_str($this->input->post('discount_password')));
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('password', $password);
        $query = $this->db->get('discount_password');

        return $query->result_array();
    }
    
}
