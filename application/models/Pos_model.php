<?php

class Pos_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function getProducts() {
        $this->db->select('*');
        $query = $this->db->get('business_products');
        return $query->result_array();
    }
    
    function getProductDetail($id) {
        //echo $id; exit;
        $this->db->select('*');
        $this->db->where('id_business_products' , $id);
        $query = $this->db->get('business_products');
        return $query->row();
    }

    function add_visit($customer_id, $visit_id, $last_color_code, $start, $advance_remarks) {
        
        if ($visit_id == 0) {
            //$color = explode('|', $this->get_color_for_visit($last_color_code));
            $color = explode('|', $this->get_color_for_visit($start));
            
         
            $visit = array(
                'business_id' => $this->session->userdata('businessid'),
                'customer_visit_date' => date('Y-m-d H:i:s'),
                'customer_id' => $customer_id,
                'visit_color' => $color[0],
                'visit_color_type' => $color[1],
                'advance_comment' => $advance_remarks,
                'customer_visit_date'=>date('Y-m-d H:i:s'),
                'created_by'=>$this->session->userdata('username')
            );
            $this->db->insert('customer_visits', $visit);
            $visit_id = $this->db->insert_id();
            return $visit_id;
        } else {
            return $visit_id;
        }
        
    } 
    
    function get_color_for_visit($start){
       $today=explode('T',$start);
      
       $sql="
           select visit_color_code, visit_color_type from customer_visit_colors where visit_color_code not in(
            SELECT distinct(visit_color) 
            FROM customer_visits
            join visit_services on customer_visits.id_customer_visits = visit_services.customer_visit_id
            where date_format(visit_services.visit_service_start,'%Y-%m-%d') = '".$today[0]."'
            and visit_status != 'cancelled' and customer_visits.business_id = ".$this->session->userdata('businessid')." order by id_visit_colors desc
            ) Limit 1";
        $query = $this->db->query($sql);        
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->visit_color_code.'|'.$row->visit_color_type;
        } else {
            //return the first color
            $this->db->select('visit_color_code, visit_color_type');
            //$this->db->where('business_id', $this->session->userdata('businessid'));
            $this->db->limit(1);
            $query = $this->db->get('customer_visit_colors');
            $row = $query->row();
            return $row->visit_color_code.'|'.$row->visit_color_type;
            
        }
        
    }
    
    function add_visit_services($customer_visit_id, $customer_id, $customer_name, $services, $products, $staff, $start) {
        
        $this->db->select('id_business, business_opening_time, business_closing_time, rec_allow_prev as previous');
        $this->db->where('id_business', $this->session->userdata('businessid'));
        $query = $this->db->get('business');
        $business=$query->row();
     
        $business_end_time = date("H:i:s",strtotime($business->business_closing_time.":00")) ;
        
        $i = 0; $lastduration=0; $newtime='';
        
        foreach ($services as $service) {
            
            if($i>0){ 
                
                $durCal =  explode(':',$lastduration);
                
                $HoursInMin=0;
                if(intval($durCal[0]) > 0){$HoursInMin = intval($durCal)*60; }
                $newduration = $HoursInMin + $durCal[1];
                $newduration = date_interval_create_from_date_string($newduration.' minutes');
                $newstart=date_create($newtime);
                $newtime=date_add($newstart, $newduration);
                $newtime=date_format($newtime,"c");
                $d=  explode('+', (string)$newtime);
                $newtime=$d[0];
                //check business closing time
                $thisstart=  explode('T', $newtime);
                if($thisstart[1]>=$business_end_time){$newtime=$start;}
                 
                //check if duration is present
                if($service['service_duration']=="00:00:00"){$lastduration="00:15:00";}
                else {$lastduration=$service['service_duration'];}
            } else {
                $newtime=$start;
                $lastduration=$service['service_duration'];
            }
            
//            print_r($newtime);echo('<br>');
//            print_r($lastduration);echo('<br>');
//            print_r($business_end_time);echo('<br>');
            
            
            if($this->input->post('loyalty_service')){
                $data = array(
                    'business_id' => $this->session->userdata('businessid'),
                    'customer_visit_id' => $customer_visit_id,
                    'service_id' => $service['service_id'],
                    'service_name' => $service['service_name'],
                    'service_flag' => $service['service_flag'],
                    'id_service_category' => $service['id_service_category'],
                    'visit_service_start' => $newtime, //$start
                    'update_date' => date('Y-m-d H:i:s'),
                    'loyalty_service' => $this->input->post('loyalty_service')
                );
            } else {
                $data = array(
                    'business_id' => $this->session->userdata('businessid'),
                    'customer_visit_id' => $customer_visit_id,
                    'service_id' => $service['service_id'],
                    'service_name' => $service['service_name'],
                    'service_flag' => $service['service_flag'],
                    'id_service_category' => $service['id_service_category'],
                    'visit_service_start' => $newtime, //$start
                    'update_date' => date('Y-m-d H:i:s')
                );
            }
            
            $this->db->insert('visit_services', $data);
            $id_visit_services = $this->db->insert_id();
            
            //Multiple Staff
            foreach($staff as $s){
                if($s['row_id']===$service['row_id']){
                    $block_other='No';
                    
                    $this->db->select('staff_shared');
                    $this->db->where('id_staff=',$s['staff_id']);
                    $query = $this->db->get('staff');
                    $blockstaff = $query->row();

                    if (isset($blockstaff))
                    { $block_other =  $blockstaff->staff_shared; }
                    
                    $data = array(
                        'business_id' => $this->session->userdata('businessid'),
                        'customer_visit_id' => $customer_visit_id,
                        'visit_service_id' => $id_visit_services,
                        'staff_id' => $s['staff_id'],
                        'staff_name' => $s['staff_name'],
                        'requested' => $s['requested'],
                        'block_other' => $block_other
                    );
                //var_dump($data);
                $this->db->insert('visit_service_staffs', $data);
                }                
            }
            
            
            //Multiple Products
            if($products !==null){
                foreach($products as $product){
                    if($product['row_id']===$service['row_id']){
                        $data = array(
                            'business_id' => $this->session->userdata('businessid'),
                            'customer_visit_id' => $customer_visit_id,
                            'visit_service_id' => $id_visit_services,
                            'product_id' => $product['product_id'],
                            'product_name' => $product['product_name'],
                            'product_qty' => $product['qty'],
                            'product_unit' => $product['unit']
                        );
                        $this->db->insert('visit_service_products', $data);
                    }
                }
            }
            $i++;
        }        
        return $customer_visit_id;
    }
 
    function move_advance($from_visit_id, $to_visit_id){
        
       $this->db->where('customer_visit_id', $from_visit_id);
       $this->db->update('visit_advance', array('customer_visit_id'=>$to_visit_id));
       
       return $this->db->affected_rows();
       
    }
    
    function removeVisit($visit_id){
    
        $this->db->where('customer_visit_id', $visit_id);
        $this->db->delete('visit_service_products');
        
        $this->db->where('customer_visit_id', $visit_id);
        $this->db->delete('visit_service_staffs');
        
        $this->db->where('customer_visit_id', $visit_id);
        $this->db->delete('visit_services');
        
        $this->db->where('customer_visit_id', $visit_id);
        $this->db->delete('visit_services_extras');
        
        $this->db->where('id_customer_visits', $visit_id);
        $this->db->delete('customer_visits');
        
        
    }
    
    function insert_invoice($invoice_number, $invoice_date, $customer_id, $customername, $customercell, $customeraddress, $customeremail, $subtotal,$paid,$returnamount,$discount,$grosstotal,$balance,$taxtotal,$grandtotal,$visitid,$paymentmode,$instrumentnumber,$remarks,$discountremarks,$loyaltyused, $visittime, $advance_amount, $other_charges, $retained_used, $keepadv, $cctip,$loyaltyearned,$retained_amount_used,$cashpaid,$cardpaid,$voucherpaid,$checkpaid,$cc_charge,$totalpayable, $remaining_retained, $visitdate) {
        
        $data = array(
            'invoice_number'=>$invoice_number,
            'invoice_date'=>$invoice_date,
            'customer_id'=>$customer_id,
            'business_id'=>$this->session->userdata('businessid'),
            'customer_name'=>$customername,
            'customer_cell'=>$customercell,
            'customer_address'=> $customeraddress,
            'customer_email'=> $customeremail,
            'sub_total'=>$subtotal,
            'paid_amount' => $paid,
            'returnamount' => $returnamount,
            'discount' => $discount,
            'gross_amount' => $grosstotal,
            'balance'=>$balance,
            'tax_total'=>$taxtotal,
            'net_amount' => $grandtotal,
            'visit_id' => $visitid,
            'invoice_status'=>'valid',
            'payment_mode'=>$paymentmode,
            'instrument_number'=>$instrumentnumber,
            'is_recovery' => $balance > 0 ? 'Yes' : 'No',
            'remarks'=>$remarks,
            'discount_remarks'=>$discountremarks,
            'loyalty_used'=> $loyaltyused,
            'visit_time'=> $visitdate.' '.$visittime,
            'advance_amount'=>$advance_amount,
            'other_charges'=>$other_charges,
            'retained_used'=>$retained_used,
            'retained_amount'=>$keepadv==='true' ? $returnamount : 0,
            'cctip'=>$cctip,
            'loyalty_earned'=>$loyaltyearned,
            'retained_amount_used'=>$retained_amount_used,
            'paid_cash' => $cashpaid,
            'paid_card' => $cardpaid,
            'paid_voucher' => $voucherpaid,
            'paid_check' => $checkpaid,
            'cc_charge'=>$cc_charge,
            'total_payable'=>$totalpayable,
            'created_by' => $this->session->userdata('username')
        );
        
        $this->db->insert('invoice',$data);
        
        return $this->db->insert_id();
        
    }
    
    function insert_invoice_details($row_id, $invoiceid, $service_paid, $service_type, $service_category, $service_id, $service_name, $service_duration, $service_flag, $id_service_category, $discount, $discount_type, $unitcost, $originalservicerate, $visit_service_start){
        
        $taxperc= $this->business_model->get_tax_perc('service');
        $taxonoriginalprice= round((floatval($originalservicerate) * $taxperc->tax_percentage)/100,2);
        
        $servicesdetails= array(
            'invoice_id' => $invoiceid,
            'business_id' => $this->session->userdata('businessid'),
            'service_id' => $service_id,
            'service_type' => $service_type,
            'service_category' => $service_category,
            'service_name' => $service_name,
            'price' => $originalservicerate,
            'discount' => $discount,
            'discount_type' => $discount_type,
            'discounted_price' => $unitcost,
            'taxes' => $taxonoriginalprice,            
            'paid' => $service_paid,
            'detail_visit_date' => str_replace('T',' ',$visit_service_start),
            'service_flag' => $service_flag
        );
        $this->db->insert('invoice_details', $servicesdetails);
        
        return $this->db->insert_id();
        
    }
    
    function insert_invoice_staff($row_id, $invoiceid, $service_type, $service_category, $service_name, $price, $discount, $discounted_price, $requested, $staff_id, $staff_name, $staff_count, $staff_share, $invoice_detail_id){
        //echo $requested; exit();
        
        $staff = array(
            'invoice_id' => $invoiceid,
            'invoice_detail_id' => $invoice_detail_id,
            'business_id' => $this->session->userdata('businessid'),
            'service_type' => $service_type,
            'service_category' => $service_category,
            'service_name' => $service_name,
            'staff_name' => $staff_name,
            'staff_id' => $staff_id,
            'price' => $price / $staff_count,
            'discount' => ($discount == '')? 0 : $discount / $staff_count,
            'discounted_price' => $discounted_price / $staff_count,
            'requested' => $requested,
            'staff_share' => $staff_share
        );
        $this->db->insert('invoice_staff', $staff);
        
    }
    
    function insert_invoice_staff_services($row_id, $invoiceid, $invoice_detail_id, $visitid, $staff_id, $service_id, $staff_name, $service_type, $service_category, $service_name, $staff_price, $staff_discount, $staff_commission, $paid, $service_flag, $requested, $staff_count, $unitcost, $staff_share, $service_price){
        //update commissions
        
        if($service_price>0){
            $staff_paid = round(($staff_share*$paid)/$service_price);
        } else {$staff_paid=0;}
        
                $staffservice = array(
                    'invoice_id' => $invoiceid,
                    'invoice_detail_id' => $invoice_detail_id,
                    'business_id' => $this->session->userdata('businessid'),
                    'visit_id' => $visitid,
                    'staff_id' => $staff_id,
                    'service_id' => $service_id,
                    'staff_name' => $staff_name,
                    'service_type' => $service_type,
                    'service_category' => $service_category,
                    'service_name' => $service_name,
                    'price' => $unitcost/$staff_count,
                    'discount' => ($staff_discount == '')? 0 :  $staff_discount/$staff_count,
                    'discounted_price' => $staff_price,
                    'staff_commission' => $staff_commission,
                    'paid' => $staff_paid,
                    'service_flag'=>$service_flag,
                    'requested'=>$requested,
                    'staff_share'=>$staff_share
                );
                $this->db->insert('staff_services', $staffservice);
    }
    
    function updateinvoicenumber($invoiceid,$paymentmode='Cash'){
         $business= $this->business_model->get_business_details();
        //make sure invoice number is correct
        $today=date('Y-m-d');
        
        $seq=1;        
        $sql = "select max(invoice_seq)+1 as 'seq'
            from invoice where day(invoice_date)= day('".$today."') 
            and month(invoice_date)= month('".$today."') and year(invoice_date)= year('".$today."')";
        $query = $this->db->query($sql);
        $invoice_seq =  $query->row();
        if(isset($invoice_seq) && null !== $invoice_seq->seq){$seq=$invoice_seq->seq;}
        if($paymentmode!=='Card' && $paymentmode!=='Mixed' && $business[0]['sh_hide']=='Yes'){
            $seq=0;
        }
            
        $update_invoice = array(
            'invoice_number' => date('Y-m').'-'.$invoiceid,
            'invoice_seq' => $seq
        );            
        $this->db->where(array(
            'business_id' => $this->session->userdata('businessid'),
            'id_invoice' => $invoiceid
        ));
        $this->db->update('invoice', $update_invoice);
        
        return $seq;
    }
    
    function insert_invoice_taxes($invoiceid,$taxname, $tax){
        
        $data=array(
            'invoice_id'=>$invoiceid,
            'business_id'=>$this->session->userdata('businessid'),
            'invoice_tax_name'=>$taxname,
            'invoice_tax'=>$tax
        );
        $this->db->insert('invoice_taxes', $data);
        
    }
    
    function insert_invoice_products($invoiceid, $visitid, $serviceid, $servicename, $id_business_products, $product, $usage_qty, $measure_unit){
        
        $data = array(
            'business_id' => $this->session->userdata('businessid'),
            'invoice_id' => $invoiceid,
            'customer_visit_id' => $visitid,
            'service_id' => $serviceid,
            'service_name' => $servicename,
            'product_id' => $id_business_products,
            'product_name' => $product,
            'product_qty' => $usage_qty,
            'product_unit' => $measure_unit
        );
        $this->db->insert('invoice_visit_products', $data);
        
    }
    
    function update_visit_status($visitid, $seq=0){
        
        $this->db->set('visit_status', 'invoiced');
        $this->db->set('invoice_seq', $seq);
        $this->db->where('id_customer_visits', $visitid);
        $this->db->update('customer_visits');
        
    }
    
    function updatecustomeradvance($customerid, $keepadv, $remaining_retained, $returnamount){
        if ($keepadv==='true'){
            $newval=$returnamount + $remaining_retained;
        } else {
            $newval=$remaining_retained;
        }
        $this->db->set('customer_advance', $newval);
        $this->db->where('id_customers',$customerid);
        $this->db->update('customers');
        
        return $this->db->affected_rows();
    }
 
    
    function insert_order_invoice(){
        
        //Create invoice    
        $invoice_date=$invoicedate;
        $visittime=$invoicedate;
        $data = array(
            'customer_id'=>$customerid,
            'invoice_number'=>$invoicenumber,
            'business_id'=>$this->session->userdata('businessid'),
            'customer_name'=> $customerorder->customer_name,
            'customer_cell'=> $customerorder->customer_cell,
            'customer_email'=> $customerorder->customer_email,
            'customer_address'=> $customerorder->customer_address,
            'tax_total'=>$taxtotal,
            'paid_amount' => $paid,
            'paid_amount' => $paid,
            'paid_cash' => $cashpaid,
            'paid_card' => $cardpaid,
            'paid_voucher' => $voucherpaid,
            'paid_check' => $checkpaid,
            'discount' => $discount,
            'gross_amount' => $grosstotal,
            'net_amount' => $grandtotal,
            'visit_id' => $orderid,
            'visit_time' => $visittime,
            'sub_total' => $subtotal,
            'invoice_type'=>'sale',
            'payment_mode'=>$paymentmode,
            'instrument_number'=>$instrumentnumber,
            'cc_charge'=>$cc_charge,
            'balance'=>$balance,
            'is_recovery' => $balance > 0 ? 'Yes' : 'No',
            'returnamount' => $returnamount,
            'discount_remarks' => $this->input->post('discount_remarks'),
            'returnamount' => $returnamount,
            'loyalty_used'=> $loyaltyused,
            'advance_amount'=>$advance_amount,
            'other_charges'=>$other_charges,
            'invoice_date'=>$invoice_date,
            'retained_used'=>$retained_used,
            'retained_amount_used'=>$retained_amount_used,
            'retained_amount'=>$customer_advance==='true' ? $returnamount : 0,
            'cctip'=>$cctip,
            'loyalty_earned'=>$loyaltyearned,
            'total_payable'=>$totalpayable
        );

        $this->db->insert('invoice', $data);
        $invoiceid =  $this->db->insert_id();
        
        
    }
    function cancelVisit($customer_visit_id, $cancelled_by, $cancelreason=''){
        
        if($cancelreason==''){
            $cancelreason=$this->input->post('cancelreason');
        }
        $where = array(
            'business_id' => $this->session->userdata('businessid'),
            'id_customer_visits' => $customer_visit_id,
        );

        $this->db->where($where);
        $query = $this->db->update('customer_visits', array('visit_status' => 'canceled', 'cancelreason' => $cancelreason, 'canceled_by' => $this->session->userdata('username')));

        return $query;
    }
}