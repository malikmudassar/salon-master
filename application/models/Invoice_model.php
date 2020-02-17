<?php

class Invoice_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }
    
    function getPackageInvoices(){
        $customer = $this->input->post('customer');
        $type = $this->input->post('type');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        
        $this->db->select('*, DATE_FORMAT(invoice_date, "%d-%c-%Y") as invoice_date');
        $this->db->join('invoice_details invd', 'invd.invoice_id = inv.id_invoice');
        
        $this->db->where('inv.business_id', $this->session->userdata('businessid'));
        $this->db->where('inv.visit_time >', $start);
        $this->db->where('inv.visit_time <=', $end);
        if(!$type==""){
            $this->db->where('invd.service_type', $type);
        }
        if(!$customer==''){
            if(ctype_digit($customer)){
                $this->db->like('inv.customer_cell', $customer);
            } else{
                $this->db->like('inv.customer_name', $customer);
            }
        }
        $this->db->where('inv.invoice_status', 'valid');
        $this->db->where('inv.reference_invoice_number !=', 'bad debts');
        $this->db->order_by('inv.customer_name');
        $this->db->group_by('invd.invoice_id');
        $query = $this->db->get('invoice inv');
        return $query->result_array();
    }
    
    function getPackageTypes(){
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('service_type_active', 'Yes');
        $query = $this->db->get('package_type');
        return $query->result();
    }
    
    function markBadDebts(){
        
        $data = array(
            'remarks' => $this->input->post('remarks', TRUE),
            'is_recovery' => 'No'
            //'reference_invoice_number' => 'bad debts'
        );
        
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('id_invoice', $this->input->post('invoice_id', TRUE));
        
        $query = $this->db->update('invoice', $data);
        return $query;
        
    }
    
    function get_today_expenses(){
        
        $today = $this->input->post('calendar_date', TRUE);
        
        if(!isset($today) || empty($today)){
            $today = date('Y-m-d');
        }
        
        $this->db->select('sum(debit) as today_expenses');
        $this->db->join('account_voucher_detail','account_vouchers.id_account_vouchers = account_voucher_detail.account_voucher_id');
        $this->db->join('account_heads','account_voucher_detail.account_head_id=account_heads.id_account_heads');
        $this->db->join('account_sub_types','account_sub_types.id_account_sub_types=account_heads.account_sub_type');
        $this->db->where('account_vouchers.business_id', $this->session->userdata('businessid'));
        $this->db->where('account_vouchers.voucher_date', $today);
        $this->db->where('account_vouchers.voucher_status=', 'Active');
        //$this->db->where('account_sub_types.payment_mode=', 'Cash');
        $this->db->where('account_vouchers.voucher_type=', 1);
        $this->db->where('account_sub_types.id_account_sub_types=', 6);
        $this->db->where('lower(account_heads.account_head)=', 'office expense');//Office Expense
        //$this->db->where('lower(account_heads.account_head)=', 'cash');
        $query = $this->db->get('account_vouchers');
       // echo $query; exit();
        
        return $query->row();
        
    }
    
    function get_cash_register($t=null){
        
        $today = $this->input->post('calendar_date', TRUE);
        
        if(!isset($today) || empty($today)){
            if($t !== null ){
                $today = $t;
            } else {
                $today = date('Y-m-d');
            }
        }
       
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        //if(!empty($id_cash_register)){
        //    $this->db->where('id_cash_register', $id_cash_register);
        //} else{
            $this->db->where('cash_register_date', $today);
        //}
        $query = $this->db->get('cash_register');
        return $query->row();
        
    }
    
    function update_cash_register(){
        
        $data = array(
            'business_id' => $this->session->userdata('businessid'),
            'x5000' => $this->input->post('x5000', TRUE),
            'x1000' => $this->input->post('x1000', TRUE),
            'x500' => $this->input->post('x500', TRUE),
            'x100' => $this->input->post('x100', TRUE),
            'x50' => $this->input->post('x50', TRUE),
            'x20' => $this->input->post('x20', TRUE),
            'x10' => $this->input->post('x10', TRUE),
            'x5' => $this->input->post('x5', TRUE),
            'x1' => $this->input->post('x1', TRUE),
            
            'difference' => $this->input->post('totalDifference', TRUE),
            'daily_expense' => $this->input->post('daily_expense', TRUE),
            'remarks' => $this->input->post('remarks', TRUE),
            'till_amounts' => $this->input->post('till', TRUE),
            'cash_addition' => $this->input->post('cash_addition', TRUE)
        );
        
        $this->db->where('cash_register_date', date('Y-m-d'));
        $this->db->where('business_id', $this->session->userdata('businessid'));
        
        $query = $this->db->update('cash_register', $data);
        return $query;
        
    }
    
    function insert_cash_register(){
        $date = $this->input->post('calendar_date');
        
        $data = array(
            'business_id' => $this->session->userdata('businessid'),
            'x5000' => $this->input->post('x5000', TRUE),
            'x1000' => $this->input->post('x1000', TRUE),
            'x500' => $this->input->post('x500', TRUE),
            'x100' => $this->input->post('x100', TRUE),
            'x50' => $this->input->post('x50', TRUE),
            'x20' => $this->input->post('x20', TRUE),
            'x10' => $this->input->post('x10', TRUE),
            'x5' => $this->input->post('x5', TRUE),
            'x1' => $this->input->post('x1', TRUE),
            'remarks' => $this->input->post('remarks', TRUE),
            'cash_register_date' => $date,
            'till_amounts' => $this->input->post('till', TRUE),
            'cash_addition' => $this->input->post('cash_addition', TRUE)
        );
        
        $this->db->insert('cash_register', $data);
        return $this->db->insert_id();
        
    }
    
    function get_cash_voucher($t = null){
        
        $today = $this->input->post('calendar_date', TRUE);
        
        if(!isset($today) || empty($today)){
            if($t !== null ){
                $today = $t;
            } else {
                $today = date('Y-m-d');
            }
        }
        
        $business_id = $this->session->userdata('businessid');
        
        $sub_query1 = ""
                . "SELECT ifnull(SUM(amount),0) FROM order_vouchers "
                . "WHERE payment_mode = 'Cash'  AND "
                . "date_format(voucher_date, '%Y-%m-%d') = '$today' AND "
                . "business_id = $business_id";
        
        $sub_query2 = ""
                . "SELECT ifnull(SUM(amount),0) FROM order_vouchers "
                . "WHERE payment_mode = 'Card' AND "
                . "date_format(voucher_date, '%Y-%m-%d') = '$today' AND "
                . "business_id = $business_id";
        
        $sub_query3 = ""
                . "SELECT ifnull(SUM(amount),0) FROM order_vouchers "
                . "WHERE payment_mode = 'Check' AND "
                . "date_format(voucher_date, '%Y-%m-%d') = '$today' AND "
                . "business_id = $business_id";
        
        
        $this->db->select("ifnull(SUM(amount),0) AS totalVoucherAmount, "
                . "($sub_query1) AS Cash, "
                . "($sub_query2) AS Card, "
                . "($sub_query3) AS Checks "
                . "", False);
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('date_format(voucher_date,"%Y-%m-%d") =', $today);
        $query = $this->db->get('order_vouchers');
        //echo $query; exit();
        return $query->row();
        
    }
    
    function get_today_cash_info($t=null){
        
        $today = $this->input->post('calendar_date', TRUE);
       
        if(!isset($today) || empty($today)){
            if($t !== null ){
                $today = $t;
            } else {
                $today = date('Y-m-d');
            }
        }
        
        $datetime = new DateTime($today);
        $datetime->modify('+1 day');

        $tomorrow = $datetime->format('Y-m-d H:i:s');

        $business_id = $this->session->userdata('businessid');
        
        $sub_query1 = ""
                . "SELECT SUM(balance) FROM invoice "
                . "WHERE "
                . "invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        $sub_query2 = ""
                . "SELECT SUM(paid_amount) FROM invoice "
                . "WHERE reference_invoice_number != '' AND "
                . "invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        $sub_query3 = ""
                . "SELECT SUM(total_payable) FROM invoice "
                . "WHERE invoice_type = 'service'   AND reference_invoice_number = '' And "
                . "invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        $sub_query4 = ""
                . "SELECT SUM(total_payable) FROM invoice "
                . "WHERE invoice_type = 'sale' AND reference_invoice_number = '' AND "
                . "invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
       

        //Cash changing paid_amount to paid_cash
        $sub_query5 = ""
                ."select sum(ifnull(casha,0) + ifnull(cashb,0) + ifnull(cashc,0)) as 'Cash' from (
                    SELECT ifnull(SUM(paid_cash),0) as 'casha' 
                    FROM invoice WHERE payment_mode in ('Cash','Mixed') AND invoice_date > '".$today."'
                    AND invoice_date < '".$tomorrow."' AND business_id = ".$business_id." AND invoice_status = 'valid' 
                    ) a, (
                    select sum(ifnull(visit_advance.advance_amount,0)) as 'cashb' From visit_advance
                    join customer_visits on customer_visits.id_customer_visits = visit_advance.customer_visit_id 
                    WHERE visit_status <> 'canceled' AND visit_advance.advance_date >= '".$today."'
                    AND visit_advance.advance_date < '".$tomorrow."' And visit_advance.advance_mode='cash'                    
                    AND business_id = ".$business_id.") b, (
                    SELECT SUM(ifnull(retained_amount,0)) as 'cashc' 
                    FROM invoice WHERE payment_mode = 'Cash' AND invoice_date > '".$today."'
                    AND invoice_date < '".$tomorrow."' AND business_id = ".$business_id." AND invoice_status = 'valid'
                    ) c";

        //Card changing paid_amount to paid_card
        $sub_query6 = ""
                ."select sum(carda + cardb + cardc) as 'Card' from (
                    SELECT ifnull(SUM(paid_card),0) as 'carda' 
                    FROM invoice WHERE payment_mode in ('Card','Mixed') AND invoice_date > '".$today."'
                    AND invoice_date < '".$tomorrow."' AND business_id = ".$business_id." AND invoice_status = 'valid' 
                    ) a, (
                    select ifnull(sum(visit_advance.advance_amount),0) as 'cardb' From visit_advance
                    join customer_visits on customer_visits.id_customer_visits = visit_advance.customer_visit_id
                    WHERE visit_status <> 'canceled' AND visit_advance.advance_date >= '".$today."'
                    AND visit_advance.advance_date < '".$tomorrow."' And visit_advance.advance_mode='card'                    
                    AND business_id = ".$business_id.") b, (
                    SELECT ifnull(SUM(retained_amount),0) as 'cardc' 
                    FROM invoice WHERE payment_mode = 'Card' AND invoice_date > '".$today."'
                    AND invoice_date < '".$tomorrow."' AND business_id = ".$business_id." AND invoice_status = 'valid'     
                    ) c
                    ";
       
        //Check changing paid_amount to paid_check
        $sub_query7 = ""
                ."select sum(checka + checkb + checkc) as 'Check' from (
                    SELECT ifnull(SUM(paid_check),0) as 'checka' 
                    FROM invoice WHERE payment_mode = 'Check' AND invoice_date > '".$today."'
                    AND invoice_date < '".$tomorrow."' AND business_id = ".$business_id." AND invoice_status = 'valid' 
                    ) a, (
                    select ifnull(sum(visit_advance.advance_amount),0) as 'checkb' From visit_advance
                    join customer_visits on customer_visits.id_customer_visits = visit_advance.customer_visit_id
                    WHERE visit_status <> 'canceled' AND visit_advance.advance_date >= '".$today."'
                    AND visit_advance.advance_date < '".$tomorrow."' And visit_advance.advance_mode='check'                    
                    AND business_id = ".$business_id.") b, (
                    SELECT ifnull(SUM(retained_amount),0) as 'checkc' 
                    FROM invoice WHERE payment_mode = 'Check' AND invoice_date > '".$today."'
                    AND invoice_date < '".$tomorrow."' AND business_id = ".$business_id." AND invoice_status = 'valid'     
                    ) c
                    ";
        //advance adjusted
        $sub_query8 = ""
                . "SELECT SUM(advance_amount) FROM invoice "
                . "WHERE "
                . "invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        //Todays Sale
        $sub_query9 = ""
                . "SELECT SUM(gross_amount) FROM invoice "
                . "WHERE reference_invoice_number = ''  AND "
                . "invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        //totalVouchers changing paid_amount to paid_voucher
        $sub_query10 = ""
                . "SELECT SUM(paid_voucher) FROM invoice "
                . "WHERE payment_mode = 'Voucher' AND "
                . "invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        
        //totalAdvance from visit_advance
        $sub_query11 = ""
                . "SELECT SUM(visit_advance.advance_amount) FROM visit_advance join customer_visits on customer_visits.id_customer_visits = visit_advance.customer_visit_id "
                . "WHERE visit_status <> 'canceled' AND "
                . "visit_advance.advance_date >= '$today' AND visit_advance.advance_date < '$tomorrow' AND "
                . "business_id = $business_id";
        
        //retained amount
        $sub_query12 = "" 
                . "SELECT SUM(retained_amount) FROM invoice "
                . "WHERE invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        //cctip amount
        $sub_query13 = "" 
                . "SELECT SUM(cctip) FROM invoice "
                . "WHERE invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        //cctip amount
        $sub_query14 = "" 
                . "SELECT SUM(cc_charge) FROM invoice "
                . "WHERE invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        //extra amount
        $sub_query15 = "" 
                . "SELECT SUM(other_charges) FROM invoice "
                . "WHERE invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        //extra amount
        $sub_query16 = "" 
                . "SELECT SUM(tax_total) FROM invoice "
                . "WHERE invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        $this->db->select("SUM(paid_amount) AS totalCash, "
                . "($sub_query1) AS totalBalance, "
                . "($sub_query2) AS totalRecovery, "
                . "($sub_query3) AS totalService, "
                . "($sub_query4) AS totalRetail, "
               
                . "($sub_query5) AS Cash, "
                . "($sub_query6) AS Card, "
                . "($sub_query7) AS Checks, "
                . "($sub_query8) AS AdvAdj, "
                . "($sub_query9) AS totalSale, "
                . "($sub_query10) AS totalVoucher, "  
                
                . "($sub_query11) AS totalAdvance, "
                . "($sub_query12) AS totalRetained, "
                . "($sub_query13) AS totalCCTip, "
                . "($sub_query14) AS totalCCCharge, "
                . "($sub_query15) AS totalExtra, " 
                . "($sub_query16) AS totalTax "
                . "");
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_date >', $today);
        $this->db->where('invoice_date <', $tomorrow);
        $this->db->where('invoice_status', 'valid');
        $this->db->where('payment_mode', 'Cash');
        
        $query = $this->db->get('invoice');
        
        return $query->row();
        
    }
    
    function get_advance_breakup($t=null){
        $today = $this->input->post('calendar_date', TRUE);
       
        if(!isset($today) || empty($today)){
            if($t !== null ){
                $today = $t;
            } else {
                $today = date('Y-m-d');
            }
        }
        $sql="select CONCAT(id_customer_visits,id_visit_advance) id_customer_visits, customer_name, adv_mode advance_mode, adv_amount advance_amount, service_category, business_services.service_name, service_rate, advance_user
                from customer_visits
                join (
                        select id_visit_advance, customer_visit_id, sum(advance_amount) adv_amount, advance_mode adv_mode, advance_inst adv_inst, advance_date adv_date, advance_user
                        from visit_advance                        
                        where date_format(advance_date,'%Y-%m-%d') ='".$today."'
                        group by advance_mode, advance_inst, advance_date, id_visit_advance
                    ) va on customer_visits.id_customer_visits = va.customer_visit_id
            join visit_services on customer_visits.id_customer_visits = visit_services.customer_visit_id
            join customers on customers.id_customers = customer_visits.customer_id
            join business_services on business_services.id_business_services = visit_services.service_id
            join service_category on business_services.service_category_id = service_category.id_service_category
            where customer_visits.business_id = ".$this->session->userdata('businessid')."
            and customer_visits.visit_status != 'canceled'  group by CONCAT(id_customer_visits,id_visit_advance), service_category, business_services.service_name, service_rate";
            //echo $sql; exit();
            $query = $this->db->query($sql);
            
            return $query->result_array();
        
    }
    
    
    function get_voucher_breakup($t=null){
        $today = $this->input->post('calendar_date', TRUE);
       
        if(!isset($today) || empty($today)){
            if($t !== null ){
                $today = $t;
            } else {
                $today = date('Y-m-d');
            }
        }
        $sql="SELECT * , order_vouchers.created_by as created_by
        FROM order_vouchers
        join customers on customers.id_customers = order_vouchers.customer_id
        where order_vouchers.business_id = ".$this->session->userdata('businessid')."
        and date_format(voucher_date, '%Y-%m-%d') ='".$today."'";
            
            $query = $this->db->query($sql);
            
            return $query->result_array();
        
    }
    
    function get_yesterday_till_amount($t = null){
        
        
        $today = $this->input->post('calendar_date', TRUE);
        
        if(!isset($today) || empty($today)){
            if($t !== null ){
                $today = $t;
            } else {
                $today = date('Y-m-d');
            }
        }
        
        $datetime = new DateTime($today);
        $datetime->modify('-1 day');
        
        $yesterday = $datetime->format('Y-m-d');
        
        $this->db->select("ifnull(till_amounts,0) as till_amounts", False);
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('cash_register_date', $yesterday);
        
        $query = $this->db->get('cash_register');
        return $query->row();
        
    }

    function getnextinvoicenumber(){
        $this->db->select_max('id_invoice');
        if($this->session->userdata('common_products')=='No'){
            $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        }
        $query = $this->db->get('invoice');
        
        return $query->result_array();
        
    }
    
    function disount_invoice_user_insert($invoiceid) {
        $data = array(
            'userid' => $this->db->escape_str($this->input->post('uid')),
            'name' => $this->db->escape_str($this->input->post('uname')),
            'username' => $this->db->escape_str($this->input->post('uusername')),
            'email' => $this->db->escape_str($this->input->post('uemail')),
            'invoiceid' => $invoiceid
        );
        
        $result = $this->db->insert('discount_invoice_users', $data);
        return TRUE;
    }
    
    function update_invoice(){
        
        $business= $this->business_model->get_business_details();
        $taxperc= $this->business_model->get_tax_perc('service');
        
        $newloyaltypoints=0;
        
        $visitid=$this->input->post('visitid', TRUE);
        $service_ids=$this->input->post('serviceids', TRUE);
        $visit_service_ids=$this->input->post('visitserviceids', TRUE);
        $invoicenumber=$this->input->post('invoicenumber', TRUE);
        $invoicedate=$this->input->post('invoicedate', TRUE);
        
        
        $customerid=$this->input->post('customerid', TRUE);
        $subtotal=$this->input->post('subtotal', TRUE);
        
        $discount=$this->input->post('discount', TRUE);
        $discount_perc=$this->input->post('discount_perc', TRUE);
        
        $grosstotal=$this->input->post('grosstotal', TRUE);
        $paid=$this->input->post('paid', TRUE);
        
        $grandtotal=$this->input->post('grandtotal', TRUE);
        $totalpayable=$this->input->post('totalpayable', TRUE);
        
        $taxes=$this->input->post('taxes', TRUE);
        $taxtotal=$this->input->post('taxtotal', TRUE);
        $paymentmode=$this->input->post('mode', TRUE);
        $cashpaid=0;$cardpaid=0;$voucherpaid=0;$checkpaid=0;
        
        $cc_charge=$this->input->post('cc_charge', TRUE);
        $instrumentnumber=$this->input->post('instrument_number', TRUE);
        $balance=$this->input->post('balance', TRUE);
        $service_discount=$this->input->post('service_discount', TRUE);
        $discount_type=$this->input->post('discount_type', TRUE);
        $discounted_price=$this->input->post('discounted_price', TRUE);
        $returnamount=$this->input->post('returnamount', TRUE);
        $customer_advance=$this->input->post('customer_advance', TRUE);
        $retained_used=$this->input->post('retained_used', TRUE);
        $retained_amount_used=$this->input->post('retained_amount_used', TRUE);
        $remaining_retained=$this->input->post('remaining_retained', TRUE);
        $cctip = $this->input->post('cctip', TRUE);
        $advance_amount=$this->input->post('advance_amount',TRUE);
        $other_charges=$this->input->post('other_charges',TRUE);
        $serivce_flag=$this->input->post('service_flag',TRUE);
        $requested=$this->input->post('requested',TRUE);
      
        $totalpaid= ($advance_amount+$paid)-($cctip+$cc_charge);
        $paidnow=$paid-($cctip+$cc_charge);
        if($paymentmode=="Cash"){$cashpaid=$paid;}
        else if($paymentmode=="Card"){$cardpaid=$paid;}
        else if($paymentmode=="Check"){$checkpaid=$paid;}
        else if($paymentmode=="Voucher"){$voucherpaid=$paid;}
        else if($paymentmode=="Mixed"){
            $cashpaid=$this->input->post('cashpaid', TRUE);
            $cardpaid=$this->input->post('cardpaid', TRUE);
        } 
        
        //Loyalty
        $loyaltyused=$this->input->post('loyaltyused',TRUE);
        $loyaltyvalue=$this->input->post('loyaltyvalue',TRUE);
        $loyaltyenabled=$this->input->post('loyaltyenabled',TRUE);
        $sloyaltyenabled=$this->input->post('sloyaltyenabled',TRUE);
        
        if (in_array("packagetype", $serivce_flag)==false){
            if($loyaltyenabled=='Y' && $sloyaltyenabled=='Y') {
                $loyaltyearned=(Float)$totalpaid/ (Float)$loyaltyvalue;
            } else {
                $loyaltyearned=0;
            }
        } else {$loyaltyearned=0;}
        
        if($loyaltyearned < 0){$loyaltyearned=0;}
        
        
        //Get customer & visit
        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = customer_visits.customer_id');
        $this->db->where('customer_visits.id_customer_visits', $visitid);
        $this->db->where('customer_visits.business_id', $this->session->userdata('businessid'));
        $customervisits = $this->db->get('customer_visits');
        $customervisit = $customervisits->row();
        
                
        //Get visit details        
        $this->db->select('*, visit_service_products.visit_service_id AS product_visit_service_id');
        $this->db->join('business_services', 'business_services.id_business_services = visit_services.service_id');
        $this->db->join('service_category', 'service_category.id_service_category = business_services.service_category_id');
        $this->db->join('visit_service_products', 'visit_services.id_visit_services = visit_service_products.visit_service_id', 'left');
        //$this->db->join('visit_service_staffs', 'visit_services.id_visit_services = visit_service_staffs.visit_service_id');
        $this->db->where('visit_services.customer_visit_id', $visitid);
        $this->db->where('visit_services.business_id', $this->session->userdata('businessid'));
        $visitdetails = $this->db->get('visit_services');
        $visittime='';
        foreach ($visitdetails->result() as $vd){
            if($visittime==''){
                $visittime=$vd->visit_service_start;
            }
        }
        //Create invoice    
        $invoice_date=$invoicedate;
        
        $data = array(
            'customer_id'=>$customerid,
            'invoice_number'=>$invoicenumber,
            'business_id'=>$this->session->userdata('businessid'),
            'customer_name'=> $customervisit->customer_name,
            'customer_cell'=> $customervisit->customer_cell,
            'customer_email'=> $customervisit->customer_email,
            'customer_address'=> $customervisit->customer_address,
            'tax_total'=>$taxtotal,
            'paid_amount' => $paid,
            'paid_cash' => $cashpaid,
            'paid_card' => $cardpaid,
            'paid_voucher' => $voucherpaid,
            'paid_check' => $checkpaid,
            'discount' => $discount,
            'gross_amount' => $grosstotal,
            'net_amount' => $grandtotal,
            'visit_id' => $visitid,
            'sub_total' => $subtotal,
            'payment_mode'=>$paymentmode,
            'instrument_number'=>$instrumentnumber,
            'cc_charge'=>$cc_charge,
            'balance'=>$balance,
            'is_recovery' => $balance > 0 ? 'Yes' : 'No',
            'discount_remarks' => $this->input->post('discount_remarks'),
            'returnamount' => $returnamount,
            'loyalty_used'=> $loyaltyused,
            'visit_time'=> $visittime,
            'advance_amount'=>$advance_amount,
            'advance_inst'=>$customervisit->advance_inst,
            'other_charges'=>$other_charges,
            'invoice_date'=>$invoice_date,
            'retained_used'=>$retained_used,
            'retained_amount_used'=>$retained_amount_used,
            'retained_amount'=>$customer_advance==='true' ? $returnamount : 0,
            'cctip'=>$cctip,
            'loyalty_earned'=>$loyaltyearned,
            'total_payable'=>$totalpayable-($cctip+$cc_charge),
            'created_by' => $this->session->userdata('username'),
            'remarks' => $this->input->post('remarks', TRUE)
        );

        $this->db->insert('invoice', $data);
        $invoiceid =  $this->db->insert_id();
        
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
        //////////////////
        
        ///update customer advance
        if ($customer_advance==='true'){
            $newval=$returnamount + $remaining_retained;
        } else {
            $newval=$remaining_retained;
        }
        $this->db->set('customer_advance', $newval);
        $this->db->where('id_customers',$customerid);
        $this->db->update('customers');
        //////////
        
        $this->disount_invoice_user_insert($invoiceid);
       
        $update_service = array(
            'update_date' => date('Y-m-d H:i:s')
        );
        $this->db->where(array(
            'business_id' => $this->session->userdata('businessid'),
            'customer_visit_id' => $visitid
        ));
        $this->db->update('visit_services', $update_service);
        
        //Update Loyalty
        if($loyaltyenabled=='Y' && $sloyaltyenabled=='Y'){
            $this->db->select('loyalty_points');
            $this->db->where('id_customers =',$customerid);
            $existingpoint = $this->db->get('customers');
            $existingpoints = $existingpoint->result_array();
            
            $newloyaltypoints=(Float)$existingpoints[0]['loyalty_points'];
            if($loyaltyused>0){
                $newloyaltypoints= (Float)$existingpoints[0]['loyalty_points'] - $loyaltyused;
            }
            $calloyaltypoints=0;
            if($totalpaid>0){
                $calloyaltypoints = $totalpaid / $loyaltyvalue;
            }
            $newloyaltypoints=$newloyaltypoints+$calloyaltypoints;
            
            $this->db->where('id_customers = ', $customerid);
            $this->db->update('customers', array('loyalty_points'=>$newloyaltypoints));        
            
        }
        
        
        //Insert Invoice Products used
        foreach ($visitdetails->result() as $vd){
            if($vd->product_id){
                $data = array(
                    'business_id' => $this->session->userdata('businessid'),
                    'invoice_id' => $invoiceid,
                    'customer_visit_id' => $visitid,
                    'service_id' => $vd->service_id,
                    'service_name' => $vd->service_name,
                    'product_id' => $vd->product_id,
                    'product_name' => $vd->product_name,
                    'product_qty' => $vd->product_qty,
                    'product_unit' => $vd->product_unit
                );
                $this->db->insert('invoice_visit_products', $data);
            } else { //Insert all products in the invoice
                
                $this->db->select('*');
                $this->db->join('business_services','business_services.id_business_services = services_products.business_service_id');
                $this->db->join('business_products','business_products.id_business_products = services_products.business_product_id');
                $this->db->where('business_service_id',$vd->service_id);
                $allproducts = $this->db->get('services_products');
                foreach ($allproducts->result() as $ap){
                    $data = array(
                        'business_id' => $this->session->userdata('businessid'),
                        'invoice_id' => $invoiceid,
                        'customer_visit_id' => $visitid,
                        'service_id' => $vd->service_id,
                        'service_name' => $vd->service_name,
                        'product_id' => $ap->id_business_products,
                        'product_name' => $ap->product,
                        'product_qty' => $ap->usage_qty,
                        'product_unit' => $ap->measure_unit
                    );
                    $this->db->insert('invoice_visit_products', $data);
                }
            }
            
        }
        
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
        
        $k=0;
        
        foreach($visit_service_ids as $service_id){
            //Get visit services
            $this->db->select('*');
            $this->db->join('business_services bs', 'bs.id_business_services = vs.service_id');
            $this->db->where('vs.customer_visit_id', $visitid);
            $this->db->where('vs.id_visit_services', $service_id); //added
            $this->db->where('vs.business_id', $this->session->userdata('businessid'));
            $visit_services1 = $this->db->get('visit_services vs');

            //$total_services=$visit_services1->num_rows();

            $visit_services = $visit_services1->row();
        
        
       // foreach($visit_services as $service){
            
            //Get package type
            if($visit_services->service_flag === 'servicetype'){
                $this->db->select('*');
                $this->db->join('business_services', 'business_services.id_business_services = visit_services.service_id');
                $this->db->join('service_category', 'service_category.id_service_category = business_services.service_category_id');
                $this->db->join('service_type', 'service_type.id_service_types = service_category.service_type_id');
                $this->db->where('visit_services.customer_visit_id', $visitid);
                $this->db->where('visit_services.id_visit_services', $visit_services->id_visit_services);
                $this->db->where('visit_services.business_id', $this->session->userdata('businessid'));
                $servicetype1 = $this->db->get('visit_services');
                $servicetype2 = $servicetype1->row();
            } else{
                $this->db->select('*');
                $this->db->join('business_services', 'business_services.id_business_services = visit_services.service_id');
                $this->db->join('package_services', 'package_services.service_id = business_services.id_business_services');
                $this->db->join('package_category', 'package_category.id_package_category = package_services.package_category_id');
                $this->db->join('package_type', 'package_category.package_type_id = package_type.id_package_type');
                $this->db->where('visit_services.customer_visit_id', $visitid);
                $this->db->where('visit_services.id_visit_services', $visit_services->id_visit_services);
                $this->db->where('visit_services.business_id', $this->session->userdata('businessid'));
                $this->db->where('package_services.package_category_id', $visit_services->id_service_category); //added 1/9/2017 owais
                $servicetype1 = $this->db->get('visit_services');
                $servicetype2 = $servicetype1->row();
            }
            
            //Get visit service products        
            $this->db->select('*');
            $this->db->where('customer_visit_id', $visitid);
            $this->db->where('visit_service_id', $visit_services->id_visit_services);
            $vs_products = $this->db->get('visit_service_products');
            $products = "";
            foreach ($vs_products->result() as $vsp){
                $products .= $vsp->product_name."|";
            }
            
            //Get visit service staffs   
            $this->db->select('*');
            $this->db->where('customer_visit_id', $visitid);
            $this->db->where('visit_service_id', $visit_services->id_visit_services);
            $vs_staff = $this->db->get('visit_service_staffs');
            $staff_count = $vs_staff->num_rows();
            $staffs = "";
            
            
            ///Calculate commission and paid ratios
            //Service Weights
            if($subtotal > 0){ 
                $service_weight=($discounted_price[$k]*100)/$subtotal;
            } else{
                $service_weight = 0;
            }
            
            //Calculate Wieghted Price            
            $service_price = ($totalpayable-$cctip-$cc_charge)*$service_weight/100;
            if($service_price<0){$service_price*-1;}//keep it positive
            //Calculate Paid
            $service_paid = ($totalpaid)*$service_weight/100;
            if($service_paid<0){$service_paid*-1;}//keep it positive
            
            //Calculate Commission
            $commission = ($service_paid * $servicetype2->commission_perc) / 100;    
            $commission_ratio =$commission/$staff_count;
            
            $priceafterdiscount=round(floatval($servicetype2->service_rate) - floatval($service_discount[$k]),2);
            $taxonoriginalprice= round((floatval($servicetype2->service_rate) * $taxperc->tax_percentage)/100,2);
            //insert invoice details
            $services= array(
                'invoice_id' => $invoiceid,
                'business_id' => $this->session->userdata('businessid'),
                'service_id' => $servicetype2->id_business_services,
                'service_type' => $servicetype2->service_type,
                'service_category' => $servicetype2->service_category,
                'service_name' => $servicetype2->service_name,
                'staff' => '',
                'products' => $products,
                'price' => $servicetype2->service_rate,
                'discount' => $service_discount[$k],
                'discount_type' => $discount_type[$k],
                //'discounted_price' => $discounted_price[$k],
                //'discounted_price' => $service_price,
                'discounted_price' => $priceafterdiscount,
                'taxes' => $taxonoriginalprice,
                'paid'=>$service_paid,
                'detail_visit_date'=>$servicetype2->visit_service_start,
                'service_flag'=>$servicetype2->service_flag,
                'requested'=>$requested[$k]
            );
            $this->db->insert('invoice_details', $services);
            $invoice_detail_id=$this->db->insert_id();
            
            //insert invoice staff
            foreach($vs_staff->result() as $vss){
                $staffs .= $vss->staff_name."|";
                
                $services = array(
                    'invoice_id' => $invoiceid,
                    'invoice_detail_id' => $invoice_detail_id,
                    'business_id' => $this->session->userdata('businessid'),
                    'service_type' => $servicetype2->service_type,
                    'service_category' => $servicetype2->service_category,
                    'service_name' => $servicetype2->service_name,
                    'staff_name' => $vss->staff_name,
                    'staff_id' => $vss->staff_id,
                    'price' => $servicetype2->service_rate / $staff_count,
                    'discount' => $service_discount[$k] / $staff_count,
                    'discounted_price' => $priceafterdiscount/$staff_count,
                    'requested'=>$requested[$k]
                );
                $this->db->insert('invoice_staff', $services);
                
                //update commissions
                $staffservice = array(
                    'invoice_id' => $invoiceid,
                    'invoice_detail_id' => $invoice_detail_id,
                    'business_id' => $this->session->userdata('businessid'),
                    'visit_id' => $visitid,
                    'staff_id' => $vss->staff_id,
                    'service_id' => $servicetype2->id_business_services,
                    'staff_name' => $vss->staff_name,
                    'service_type' => $servicetype2->service_type,
                    'service_category' => $servicetype2->service_category,
                    'service_name' => $servicetype2->service_name,
                    'price' => $servicetype2->service_rate / $staff_count,
                    'discount' => $service_discount[$k] / $staff_count,
                    //'discounted_price' => $discounted_price[$k]/$staff_count,
                    'discounted_price' => $service_price/$staff_count,
                    'staff_commission' => $commission_ratio,
                    'paid' => $service_paid/ $staff_count,
                    'service_flag'=>$servicetype2->service_flag,
                    'requested'=>$requested[$k]
                );
                $this->db->insert('staff_services', $staffservice);
            }
           
            


            $k++;
        }
        //update customer visit (mark as invoiced)
        
        $this->db->set('visit_status', 'invoiced');
        $this->db->set('invoice_seq', $seq);
        $this->db->where('id_customer_visits', $visitid);
        $this->db->update('customer_visits');
        return $invoiceid.'|'.$loyaltyearned.'|'.$totalpayable;
    }
    
    function update_recovery_invoice(){
       
        $business= $this->business_model->get_business_details();
        
        $visitid = $this->input->post('visitid', TRUE);
        $visittime= $this->input->post('visit_time', TRUE);
        $invoicenumber = $this->input->post('invoicenumber', TRUE);
        $invoicedate = $this->input->post('invoicedate', TRUE);        
        
        $referenceinvoicenumber = $this->input->post('referenceinvoicenumber', TRUE);
        $recovery = $this->input->post('recovery', TRUE);
        $customerid = $this->input->post('customerid', TRUE);
        $subtotal = $this->input->post('subtotal', TRUE);
        $paid = $this->input->post('paid', TRUE);
        $discount = $this->input->post('discount', TRUE);
        $grosstotal = $this->input->post('grosstotal', TRUE);
        $grandtotal = $this->input->post('grandtotal', TRUE);
        $taxtotal = $this->input->post('taxtotal', TRUE);
        $paymentmode = $this->input->post('mode', TRUE);
        $cc_charge = $this->input->post('cc_charge', TRUE);
        $totalpayable = $this->input->post('total_payable', TRUE);
        $cashpaid=0;$cardpaid=0;$voucherpaid=0;$checkpaid=0;
        $advance = $this->input->post('advance'); //this is the already paid amount
        
        if($paymentmode=="Cash"){$cashpaid=$paid;}
        else if($paymentmode=="Card"){$cardpaid=$paid;}
        else if($paymentmode=="Check"){$checkpaid=$paid;}
        else if($paymentmode=="Voucher"){$voucherpaid=$paid;}
        else if($paymentmode=="Mixed"){
            $cashpaid=$this->input->post('cashpaid', TRUE);
            $cardpaid=$this->input->post('cardpaid', TRUE);
        } 
        
        $instrumentnumber = $this->input->post('instrument_number', TRUE);
        $balance = $this->input->post('balance', TRUE);
        $returnamount = $this->input->post('returnamount', TRUE);
        $old_invoice_id = $this->input->post('old_invoice_id', TRUE);
        $other_charges=$this->input->post('other_charges', TRUE);
        $discountremarks=$this->input->post('discount_remarks', TRUE);
        $discounted_price=$this->input->post('discounted_price', TRUE);
        $service_discount=$this->input->post('service_discount', TRUE);
        
        $totalpaid = $this->input->post('paid', TRUE); //no advance in recovery
                
        //Loyalty
        $loyaltyused=$this->input->post('loyaltyused',TRUE);
        $loyaltyvalue=$this->input->post('loyaltyvalue',TRUE);
        $loyaltyenabled=$this->input->post('loyaltyenabled',TRUE);
        $sloyaltyenabled=$this->input->post('sloyaltyenabled',TRUE);
        if($loyaltyenabled=='Y' && $sloyaltyenabled=='Y') {$loyaltyearned=(Float)$totalpaid/ (Float)$loyaltyvalue;}
        else {$loyaltyearned=0;}
        if($loyaltyearned < 0){$loyaltyearned=0;}
        
        //Get customer & visit
        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = customer_visits.customer_id');
        $this->db->where('customer_visits.id_customer_visits', $visitid);
        $this->db->where('customer_visits.business_id', $this->session->userdata('businessid'));
        $customervisits = $this->db->get('customer_visits');
        $customervisit = $customervisits->row();
       
        //Create invoice        
        $data = array(
            'customer_id' => $customerid,
            'invoice_number' => $invoicenumber,
            'invoice_date' => $invoicedate,
            'reference_invoice_number' => $referenceinvoicenumber,
            'is_recovery' => $recovery,
            'business_id' => $this->session->userdata('businessid'),
            'customer_name' => $customervisit->customer_name,
            'customer_cell' => $customervisit->customer_cell,
            'customer_email' => $customervisit->customer_email,
            'customer_address' => $customervisit->customer_address,
            'tax_total' => $taxtotal,
            'discount' => $discount,
            'gross_amount' => $grosstotal,
            'paid_amount' => $paid,
            'paid_cash' => $cashpaid,
            'paid_card' => $cardpaid,
            'paid_voucher' => $voucherpaid,
            'paid_check' => $checkpaid,
            'net_amount' => $grandtotal,
            'visit_id' => $visitid,
            'sub_total' => $subtotal,
            'payment_mode' => $paymentmode,
            'instrument_number' => $instrumentnumber,
            'cc_charge' => $cc_charge,
            'balance' => $balance,
            'returnamount' => $returnamount,
            'discount_remarks'=>$discountremarks,
            'loyalty_used'=> $loyaltyused,
            'visit_time'=> $visittime,
            'other_charges'=> $other_charges,
            'loyalty_earned'=>$loyaltyearned,
            'total_payable'=>$totalpayable
        );

        $this->db->insert('invoice', $data);
        $invoiceid =  $this->db->insert_id();
        
        //make sure invoice number is correct
        $today=date('Y-m-d');
        $seq=1;        
        $sql = "select max(invoice_seq)+1 as 'seq'
            from invoice where day(invoice_date)= day('".$today."') 
            and month(invoice_date)= month('".$today."') and year(invoice_date)= year('".$today."')";
        $query = $this->db->query($sql);
        $invoice_seq =  $query->row();
        if(isset($invoice_seq) && null !== $invoice_seq->seq){$seq=$invoice_seq->seq;}
        if($paymentmode!=='Card' && $paymentmode!=='Mixed' && $business[0]['sh_hide']=='Yes' && $customervisit->invoice_seq = 0){
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
        //////////////////
        
        
        
        //update previous invoice
        $this->db->set('is_recovery', 'No');
        //$this->db->set('reference_invoice_number',date('Y-m').'-'.$invoiceid);
        $this->db->where('invoice_number', $referenceinvoicenumber);
        $this->db->update('invoice');
        
        
         //Update Loyalty
        if($loyaltyenabled=='Y' && $sloyaltyenabled=='Y'){
            $this->db->select('loyalty_points');
            $this->db->where('id_customers =',$customerid);
            $existingpoint = $this->db->get('customers');
            $existingpoints = $existingpoint->result_array();
            
            $newloyaltypoints=0;
            $calloyaltypoints=0;
            if((Float)$paid>0){
                $calloyaltypoints = (Float)$paid / (Float)$loyaltyvalue;
            }
            $newloyaltypoints=(Float)$existingpoints[0]['loyalty_points']+$calloyaltypoints;
            
            $this->db->where('id_customers = ', $customerid);
            $this->db->update('customers', array('loyalty_points'=>$newloyaltypoints));        
            
        }
        
        
        // get staff_service details
//        $this->db->select('*');
//        $this->db->where('visit_id', $visitid);
//        $this->db->where('invoice_id', $old_invoice_id);
//        $this->db->where('business_id', $this->session->userdata('businessid'));
//        $query = $this->db->get('staff_services');

        $k=0;
        
        //Get visit services
        $this->db->select('*');
        $this->db->join('business_services bs', 'bs.id_business_services = vs.service_id');
        $this->db->where('vs.customer_visit_id', $visitid);
        $this->db->where('vs.business_id', $this->session->userdata('businessid'));
        $visit_services1 = $this->db->get('visit_services vs');
        
        $total_services=$visit_services1->num_rows();
        
        $visit_services = $visit_services1->result();
        
        
        foreach($visit_services as $service){
            
            //Get package type
            if($service->service_flag === 'servicetype'){
                $this->db->select('*');
                $this->db->join('business_services', 'business_services.id_business_services = visit_services.service_id');
                $this->db->join('service_category', 'service_category.id_service_category = business_services.service_category_id');
                $this->db->join('service_type', 'service_type.id_service_types = service_category.service_type_id');
                $this->db->where('visit_services.customer_visit_id', $visitid);
                $this->db->where('visit_services.id_visit_services', $service->id_visit_services);
                $this->db->where('visit_services.business_id', $this->session->userdata('businessid'));
                $servicetype1 = $this->db->get('visit_services');
                $servicetype2 = $servicetype1->row();
            } else{
                $this->db->select('*');
                $this->db->join('business_services', 'business_services.id_business_services = visit_services.service_id');
                $this->db->join('package_services', 'package_services.service_id = business_services.id_business_services');
                $this->db->join('package_category', 'package_category.id_package_category = package_services.package_category_id');
                $this->db->join('package_type', 'package_category.package_type_id = package_type.id_package_type');
                $this->db->where('visit_services.customer_visit_id', $visitid);
                $this->db->where('visit_services.id_visit_services', $service->id_visit_services);
                $this->db->where('visit_services.business_id', $this->session->userdata('businessid'));
                $this->db->where('package_services.package_category_id', $service->id_service_category); //added 1/9/2017 owais
                $servicetype1 = $this->db->get('visit_services');
                $servicetype2 = $servicetype1->row();
            }
            
          
            //Get visit service staffs   
            $this->db->select('*');
            $this->db->where('customer_visit_id', $visitid);
            $this->db->where('visit_service_id', $service->id_visit_services);
            $vs_staff = $this->db->get('visit_service_staffs');
            $staff_count = $vs_staff->num_rows();
            $staffs = "";
            
            ///Calculate commission and paid ratios
            //Service Weights
            if($subtotal > 0){ 
                $service_weight=($discounted_price[$k]*100)/$subtotal;
            } else{
                $service_weight = 0;
            }
            
            //Calculate Wieghted Price            
            $service_price = $totalpayable*$service_weight/100;
            
            //Calculate Paid
            $service_paid = $totalpaid *$service_weight/100; //using already paid amount
            
            //Calculate Commission
            
            $commission = ($service_paid * $servicetype2->commission_perc) / 100;    
            $commission_ratio =$commission/$staff_count;
            
            $services= array(
                'invoice_id' => $invoiceid,
                'business_id' => $this->session->userdata('businessid'),
                'service_id' => $servicetype2->id_business_services,
                'service_type' => $servicetype2->service_type,
                'service_category' => $servicetype2->service_category,
                'service_name' => $servicetype2->service_name,
                'staff' => '',                
                'price' => $servicetype2->service_rate,
                'discount' => $service_discount[$k],
                //'discounted_price' => $discounted_price[$k],
                'discounted_price' => $service_price,
                'paid'=>$service_paid,
                'detail_visit_date'=>$servicetype2->visit_service_start,
                'service_flag'=>$servicetype2->service_flag
            );
            $this->db->insert('invoice_details', $services);
            $invoice_detail_id=$this->db->insert_id();
            foreach($vs_staff->result() as $vss){
                $staffs .= $vss->staff_name."|";
                
                $services = array(
                    'invoice_id' => $invoiceid,                    
                    'business_id' => $this->session->userdata('businessid'),
                    'service_type' => $servicetype2->service_type,
                    'service_category' => $servicetype2->service_category,
                    'service_name' => $servicetype2->service_name,
                    //'service_id' => $service_type2->service_id,
                    'staff_name' => $vss->staff_name,
                    'price' => $servicetype2->service_rate / $staff_count,
                    'discount' => $service_discount[$k] / $staff_count,
                    'discounted_price' => $service_price/$staff_count
                );
                $this->db->insert('invoice_staff', $services);
                
                //update commissions
                $staffservice = array(
                    'invoice_id' => $invoiceid,
                    'invoice_detail_id' => $invoice_detail_id,
                    'business_id' => $this->session->userdata('businessid'),
                    'visit_id' => $visitid,
                    'staff_id' => $vss->staff_id,
                    'service_id' => $servicetype2->id_business_services,
                    'staff_name' => $vss->staff_name,
                    'service_type' => $servicetype2->service_type,
                    'service_category' => $servicetype2->service_category,
                    'service_name' => $servicetype2->service_name,
                    'price' => $servicetype2->service_rate / $staff_count,
                    'discount' => $service_discount[$k] / $staff_count,
                    //'discounted_price' => $discounted_price[$k]/$staff_count,
                    'discounted_price' => $service_price/$staff_count,
                    'staff_commission' => $commission_ratio,
                    'paid' => $service_paid/ $staff_count,
                    'service_flag'=>$servicetype2->service_flag
                );
                $this->db->insert('staff_services', $staffservice);
            }
           
            

            $k++;
        }
        return $invoiceid;
    }
    
    function update_recovery_order_invoice(){
        
        $business= $this->business_model->get_business_details();
        
        $orderid=$this->input->post('orderid', TRUE);
        $visittime=$this->input->post('visittime', TRUE);
        $invoicenumber=$this->input->post('invoicenumber', TRUE);
        $invoicedate=$this->input->post('invoicedate', TRUE);
        $referenceinvoicenumber = $this->input->post('referenceinvoicenumber', TRUE);
        
        $recovery = $this->input->post('recovery', TRUE);
        $customerid=$this->input->post('customerid', TRUE);
        
        $paid=$this->input->post('paid', TRUE);
        
        $subtotal=$this->input->post('subtotal', TRUE);
        $discount=$this->input->post('discount', TRUE);
        $grosstotal=$this->input->post('grosstotal', TRUE);
        $grandtotal=$this->input->post('grandtotal', TRUE);
        $taxes=$this->input->post('taxes', TRUE);
        $cc_charge=$this->input->post('cc_charge', TRUE);
        $taxtotal=$this->input->post('taxtotal', TRUE);

        $paymentmode=$this->input->post('mode', TRUE);
        $cashpaid=0;$cardpaid=0;$voucherpaid=0;$checkpaid=0;
        
        if($paymentmode=="Cash"){$cashpaid=$paid;}
        else if($paymentmode=="Card"){$cardpaid=$paid;}
        else if($paymentmode=="Check"){$checkpaid=$paid;}
        else if($paymentmode=="Voucher"){$voucherpaid=$paid;}
        else if($paymentmode=="Mixed"){
            $cashpaid=$this->input->post('cashpaid', TRUE);
            $cardpaid=$this->input->post('cardpaid', TRUE);
        } 
        
        $instrumentnumber=$this->input->post('instrument_number', TRUE);
        $balance=$this->input->post('balance');
        $totalpayable=$this->input->post('totalpayable');
        $returnamount=$this->input->post('returnamount');
        $old_invoice_id = $this->input->post('old_invoice_id', TRUE);
        
        $discounted_price=$this->input->post('discounted_price', TRUE);
        $customer_advance=$this->input->post('customer_advance', TRUE);
        
        $advance_amount=$this->input->post('advance_amount',TRUE);
        
        $other_charges=$this->input->post('other_charges',TRUE);
        
        $totalpaid= $this->input->post('paid', TRUE);
        
        //Loyalty
        $loyaltyused=$this->input->post('loyaltyused',TRUE);
        $loyaltyvalue=$this->input->post('loyaltyvalue',TRUE);
        $loyaltyenabled=$this->input->post('loyaltyenabled',TRUE);
        $rloyaltyenabled=$this->input->post('rloyaltyenabled',TRUE);
        if($loyaltyenabled=='Y' && $rloyaltyenabled=="Y") {$loyaltyearned=(Float)$totalpaid/ (Float)$loyaltyvalue;}
        else {$loyaltyearned=0;}
         if($loyaltyearned < 0){$loyaltyearned=0;}       
        
        //Get original invoice & customer
        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = invoice.customer_id');
        $this->db->where('invoice.id_invoice', $old_invoice_id);
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $customerinvoices = $this->db->get('invoice');
       
        $customerinvoice = $customerinvoices->row();
        
       
        //Create invoice        
        $data = array(
            'customer_id'=> $customerinvoice->customer_id,
            'invoice_number'=>$invoicenumber,
            'invoice_date' => $invoicedate,
            'reference_invoice_number' => $referenceinvoicenumber,
            'is_recovery' => $recovery,
            'business_id'=>$this->session->userdata('businessid'),
            'customer_name'=> $customerinvoice->customer_name,
            'customer_cell'=> $customerinvoice->customer_cell,
            'customer_email'=> $customerinvoice->customer_email,
            'customer_address'=> $customerinvoice->customer_address,
            'tax_total'=> $customerinvoice->tax_total,
            'paid_amount' => $paid,
            'paid_cash' => $cashpaid,
            'paid_card' => $cardpaid,
            'paid_voucher' => $voucherpaid,
            'paid_check' => $checkpaid,
            'discount' => $customerinvoice->discount,
            'gross_amount' => $customerinvoice->gross_amount,
            'total_payable'=>$customerinvoice->total_payable,
            'net_amount' => $grandtotal,
            'visit_id' => $customerinvoice->visit_id,
            'sub_total' => $customerinvoice->sub_total,
            'invoice_type'=>'sale',
            'payment_mode'=>$paymentmode,
            'instrument_number'=>$instrumentnumber,
            'cc_charge'=>$customerinvoice->cc_charge,
            'balance'=>$balance,
            'is_recovery' => $balance > 0 ? 'Yes' : 'No',
            'returnamount' => $returnamount,
            'visit_time' =>$customerinvoice->visit_time
        );

        $this->db->insert('invoice', $data);
        $invoiceid =  $this->db->insert_id();
        
        //make sure invoice number is correct
         $today=date('Y-m-d');
        $seq=1;        
        $sql = "select max(invoice_seq)+1 as 'seq'
            from invoice where day(invoice_date)= day('".$today."') 
            and month(invoice_date)= month('".$today."') and year(invoice_date)= year('".$today."')";
        $query = $this->db->query($sql);
        $invoice_seq =  $query->row();
        if(isset($invoice_seq) && null !== $invoice_seq->seq){$seq=$invoice_seq->seq;}
        if($paymentmode!=='Card' && $paymentmode!=='Mixed' && $business[0]['sh_hide']=='Yes' && $customerinvoice->invoice_seq = 0){
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
        //////////////////
        
        
        //update previous invoice
        $this->db->set('is_recovery', 'No');
        $this->db->where('id_invoice', $old_invoice_id);
        $this->db->update('invoice');
        
        
         //Get original invoice products
        $this->db->select('*');
        $this->db->join('business_products', 'business_products.id_business_products = invoice_products.product_id');
        $this->db->join('business_brands', 'business_brands.id_business_brands = business_products.brand_id');
        $this->db->where('invoice_products.invoice_id', $old_invoice_id);
        $this->db->where('invoice_products.business_id', $this->session->userdata('businessid'));
        $ip = $this->db->get('invoice_products');
        
        $invoiceproducts = $ip->result();
        
        
        foreach($invoiceproducts as $invoiceproduct){
                     
            //calculate weight of product price
            //Product Weights
            if($customerinvoice->sub_total > 0){ 
                $product_final_price = ($invoiceproduct->price - $invoiceproduct->discount)*$invoiceproduct->invoice_qty;
                $product_weight=($product_final_price  * 100)/$customerinvoice->sub_total;
            } else{
                $product_weight = 0;
            }
            
            //Calculate Wieghted Price            
            $product_price = ($customerinvoice->total_payable * $product_weight) / 100;
           
            //Calculate Paid
            $product_paid = $totalpaid * $product_weight/100;
           
            //Calculate Commission
            
            //update invoice products
            $products = array(
                'invoice_id' => $invoiceid,
                'business_id' => $this->session->userdata('businessid'),
                'staff_name' => $invoiceproduct->staff_name,
                'staff_id' => $invoiceproduct->staff_id,
                'product_id' => $invoiceproduct->product_id,
                'category' => $invoiceproduct->category,
                'batch_id' => $invoiceproduct->batch_id,
                'batch' => $invoiceproduct->batch,
                'brand_name' => $invoiceproduct->brand_name,
                'product_name' => $invoiceproduct->product_name,
                'price' => $invoiceproduct->price,
                'invoice_qty' => $invoiceproduct->invoice_qty,
                'discount' => $invoiceproduct->discount,
                'discounted_price' => $product_price,
                'paid' => $product_paid
            );
            $this->db->insert('invoice_products', $products);
            $invoice_detail_id=$this->db->insert_id();
        }
        // get staff_service details
        $this->db->select('*');
        $this->db->where('invoice_id', $old_invoice_id);
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('staff_services');
        $staffproducts = $query->result();
        
        $count = $query->num_rows();
        
        foreach($staffproducts as $staffproduct) {
            
            //calculate weight of product price
            //Product Weights
            if($customerinvoice->sub_total > 0){ 
                $product_final_price = ($staffproduct->price - $staffproduct->discount)*$staffproduct->qty;
                $product_weight=($product_final_price *100)/$customerinvoice->sub_total;
            } else{
                $product_weight = 0;
            }
            
            //Calculate Wieghted Price            
            $product_price = $customerinvoice->total_payable * $product_weight/100;
            
            //Calculate Paid
            $product_paid = $totalpaid * $product_weight/100;
            
            
            //update commissions
            $staffproducts = array(
                'invoice_id' => $invoiceid,
                'invoice_detail_id' => $invoice_detail_id,
                'business_id' => $this->session->userdata('businessid'),
                'order_id' => $staffproduct->order_id,
                'staff_id' => $staffproduct->staff_id,
                'staff_name' => $staffproduct->staff_name,
                'brand_name' => $staffproduct->brand_name,
                'product_name' => $staffproduct->product_name,
                'price' => $staffproduct->price,
                'sale_type' => 'sale',
                'qty' => $staffproduct->qty,
                'discount' => $staffproduct->discount,
                'discounted_price' => $product_price,
                'paid' => $product_paid
            );
            $this->db->insert('staff_services', $staffproducts);
        }
        
       
        
        
        return $invoiceid;
    }
    
    function update_order_invoice(){
        
        $business= $this->business_model->get_business_details();
        $taxperc= $this->business_model->get_tax_perc('sale');
       
        $newloyaltypoints=0;
        
        $orderid=$this->input->post('orderid', TRUE);
        $product_ids=$this->input->post('product_ids', TRUE);
       // $batch_ids=$this->input->post('batch_ids', TRUE);
       // $batches=$this->input->post('batches', TRUE);
        
        //$product_ids=$this->input->post('product_ids', TRUE);
        
        $invoicenumber=$this->input->post('invoicenumber', TRUE);
        $invoicedate=$this->input->post('invoicedate', TRUE);
        $customerid=$this->input->post('customerid', TRUE);
        $subtotal=$this->input->post('subtotal', TRUE);
        $paid=$this->input->post('paid', TRUE);
        $discount=$this->input->post('discount', TRUE);
        $discount_perc=$this->input->post('discount_perc', TRUE);
        
        $grosstotal=$this->input->post('grosstotal', TRUE);
        $grandtotal=$this->input->post('grandtotal', TRUE);
        $totalpayable=$this->input->post('totalpayable', TRUE);
        
        $taxes=$this->input->post('taxes', TRUE);
        $taxtotal=$this->input->post('taxtotal', TRUE);
        $cc_charge=$this->input->post('cc_charge', TRUE);
        $paymentmode=$this->input->post('mode', TRUE);
        $cashpaid=0;$cardpaid=0;$voucherpaid=0;$checkpaid=0;
                
        $instrumentnumber=$this->input->post('instrument_number', TRUE);
        $balance=$this->input->post('balance');
        $returnamount=$this->input->post('returnamount');
        $product_discount=$this->input->post('product_discount', TRUE);
        $discounted_price=$this->input->post('discounted_price', TRUE);
        
        $customer_advance=$this->input->post('customer_advance', TRUE);
        $retained_used=$this->input->post('retained_used', TRUE);
        $retained_amount_used=$this->input->post('retained_amount_used', TRUE);
        $remaining_retained=$this->input->post('remaining_retained', TRUE);
        
        $cctip = $this->input->post('cctip', TRUE);
        
        $advance_amount=$this->input->post('advance_amount',TRUE);
        
        $other_charges=$this->input->post('other_charges',TRUE);
        $serivce_flag=$this->input->post('service_flag',TRUE);
        
        $totalpaid= $advance_amount+$paid;
        $totalpaidnow= $paid-$cctip;
        
        if($paymentmode=="Cash"){$cashpaid=$paid;}
        else if($paymentmode=="Card"){$cardpaid=$paid;}
        else if($paymentmode=="Check"){$checkpaid=$paid;}
        else if($paymentmode=="Voucher"){$voucherpaid=$paid;}
        else if($paymentmode=="Mixed"){
            $cashpaid=$this->input->post('cashpaid', TRUE);
            $cardpaid=$this->input->post('cardpaid', TRUE);
        } 
         
        //Loyalty
        $loyaltyused=$this->input->post('loyaltyused',TRUE);
        $loyaltyvalue=$this->input->post('loyaltyvalue',TRUE);
        $loyaltyenabled=$this->input->post('loyaltyenabled',TRUE);
        $sloyaltyenabled=$this->input->post('sloyaltyenabled',TRUE);
        $rloyaltyenabled=$this->input->post('rloyaltyenabled',TRUE);
        
        if($loyaltyenabled=='Y' && $rloyaltyenabled=="Y") {$loyaltyearned=(Float)$totalpaid/ (Float)$loyaltyvalue;}
        else {$loyaltyearned=0;}
        if($loyaltyearned < 0){$loyaltyearned=0;}        
        //Get customer & order
        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = customer_orders.customer_id');
        $this->db->where('customer_orders.id_customer_order', $orderid);
        $this->db->where('customer_orders.business_id', $this->session->userdata('businessid'));
        $customerorders = $this->db->get('customer_orders');
       
        $customerorder = $customerorders->row();
        
        
        
        //Create invoice    
        $invoice_date=$invoicedate;
        $visittime=$invoicedate;
        $data = array(
            'customer_id'=>$customerid,
            'invoice_number'=>'999',
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
            'total_payable'=>$totalpayable,
            'created_by' => $this->session->userdata('username')
        );

        $this->db->insert('invoice', $data);
        $invoiceid =  $this->db->insert_id();
        
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
        //////////////////
        
         ///update customer advance
        if ($customer_advance==='true'){
            $newval=$returnamount + $remaining_retained;
        } else {
            $newval=$remaining_retained;
        }
        $this->db->set('customer_advance', $newval);
        $this->db->where('id_customers',$customerid);
        $this->db->update('customers');
        //////////
        
        //Update Loyalty
        if($loyaltyenabled=='Y' && $rloyaltyenabled=='Y'){
            $this->db->select('loyalty_points');
            $this->db->where('id_customers =',$customerid);
            $existingpoint = $this->db->get('customers');
            $existingpoints = $existingpoint->result_array();
            
            $newloyaltypoints=(Float)$existingpoints[0]['loyalty_points'];
            if($loyaltyused>0){
                $newloyaltypoints= (Float)$existingpoints[0]['loyalty_points'] - $loyaltyused;
            }
            $calloyaltypoints=0;
            if($totalpaid>0){
                $calloyaltypoints = $totalpaid / $loyaltyvalue;
            }
            $newloyaltypoints=$newloyaltypoints+$calloyaltypoints;
            
            $this->db->where('id_customers = ', $customerid);
            $this->db->update('customers', array('loyalty_points'=>$newloyaltypoints));        
            
        }
        /////
        $this->disount_invoice_user_insert($invoiceid);
        
        
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
        $k=0;
        //foreach ($orderproducts1 as $orderproduct)
        $b=0;
        
        //Get order products
        $this->db->select('*');
        $this->db->join('business_products', 'business_products.id_business_products = order_products.product_id');
        $this->db->join('business_brands', 'business_brands.id_business_brands = business_products.brand_id');
        $this->db->where('order_products.customer_order_id', $orderid);
        $this->db->where('order_products.business_id', $this->session->userdata('businessid'));
        $orderproducts = $this->db->get('order_products');
        
        //foreach($product_ids as $product_id)
        foreach($orderproducts->result() as $orderproduct)
        {
            //Get order products

            
            //calculate weight of product price
            //Product Weights
            if($subtotal > 0){ 
                $price_times_qty = $discounted_price[$k];
                $product_weight=($price_times_qty *100)/$subtotal;
            } else{
                $product_weight = 0;
            }
            
            //Calculate Wieghted Price            
            $product_price = $totalpayable*$product_weight/100;
            
            //Calculate Paid
            $product_paid = $totalpaid*$product_weight/100;
            
            //Calculate Commission
            
            $priceafterdiscount= round(floatval($orderproduct->price) - floatval($product_discount[$k]),2);
            $taxonoriginalprice= round((floatval($orderproduct->price) * $taxperc->tax_percentage)/100,2);
            
            if(isset($product_discount[$k])){
                $products= array(
                    'invoice_id'=>$invoiceid,
                    'business_id'=>$this->session->userdata('businessid'),
                    'brand_name'=>$orderproduct->business_brand_name,
                    'product_name'=>$orderproduct->product,
                    'staff_name'=>$orderproduct->staff_name,
                    'staff_id'=>$orderproduct->staff_id,
                    'invoice_qty'=>$orderproduct->qty,
                    'price'=>$orderproduct->price,
                    'discount'=>$product_discount[$k],
                    //'discounted_price'=>$discounted_price[$k],
                    'discounted_price'=>$priceafterdiscount,
                    'taxes'=>$taxonoriginalprice,
                    'paid'=>$product_paid,
                    'product_id'=>$orderproduct->product_id,
                    'category'=>$orderproduct->category,
                    'batch'=>$orderproduct->batch,
                    'batch_id'=>$orderproduct->batch_id
                );
                $this->db->insert('invoice_products', $products);
                $invoice_detail_id=$this->db->insert_id();
            }
            
            //insert staff sale
            $amount=$orderproduct->price*$orderproduct->qty;
            
            $staffsale=array(
                'invoice_id'=>$invoiceid,
                'invoice_detail_id' =>  $invoice_detail_id,
                'business_id'=>$this->session->userdata('businessid'),
                'order_id'=>$orderid,
                'staff_id'=>$orderproduct->staff_id,
                'staff_name'=>$orderproduct->staff_name,
                'brand_name'=>$orderproduct->business_brand_name,
                'product_name'=>$orderproduct->product,
                'price'=>$amount,
                'sale_type'=>'sale',
                'qty'=>$orderproduct->qty,
                'discount'=>$product_discount[$k],
                'discounted_price'=>$product_price,
                'paid'=>$product_paid
            );
            $this->db->insert('staff_services', $staffsale);                
            $k++;
        }
        
        //update customer order (mark as invoiced)
        $this->db->set('order_status', 'invoiced');
        $this->db->where('id_customer_order', $orderid);
        $this->db->update('customer_orders');
        return $invoiceid;
    }
    
    function getrecoveryinvoices($sh=false){
        $today = date('Y-m-d');
        
        $this->db->select('*,DATE_FORMAT(invoice_date, "%d-%m-%Y") as invoice_date, DATE_FORMAT(visit_time, "%d-%m-%Y %h:%i") as visit_time, DATE_FORMAT(visit_time, "%Y-%m-%d") as sked_date');
        //$this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->join('business', 'business.id_business=invoice.business_id');
        $this->db->where('invoice.balance >', 0);
        $this->db->where('invoice.is_recovery', 'Yes');
        $this->db->where('invoice.invoice_status=', 'valid');
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('invoice.invoice_seq > ', 0);
        }
        $query = $this->db->get('invoice');
        
        return $query->result_array();
    }
    
    function gettodayinvoices($feedback=null, $order='asc', $status='valid', $sh=false){
        
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d H:i:s', strtotime('tomorrow'));
        
        $this->db->select('*, DATE_FORMAT(invoice_date, "%d-%c-%Y") as invoice_date, DATE_FORMAT(visit_time, "%d-%c-%Y %H:%i") as visit_time');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_date >', $today);
        $this->db->where('invoice_date <', $tomorrow);
        if(null!==$feedback){
            $this->db->where('feedback_status', $feedback);
            
        }
        if($status=='valid'){
            $this->db->where('invoice_status', 'valid');
        }
        
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('invoice_seq >', 0);
        }
        
        $this->db->order_by('id_invoice '.$order.'');
        //$this->db->where('reference_invoice_number !=', 'bad debts');
        $query = $this->db->get('invoice');
        
        return $query->result_array();
    }
    
   
    
    function getinvoicedetailstaff($invoicedetailid){
                      
        $this->db->select('*');
        $this->db->where('invoice_detail_id', $invoicedetailid);
        $query = $this->db->get('invoice_staff');
        
        return $query->result_array();
        
    }
    
    function getdayinvoices($today=null, $order='asc', $feedback=null, $invoice_id=null, $type=null, $sh=false){
        
        //$today = date('Y-m-d');
        //$tomorrow = date('Y-m-d H:i:s', strtotime('tomorrow'));
        
        $this->db->select("invoice_seq, id_invoice, visit_id, invoice_type, customer_name, customer_id, invoice_staff.staff_id, invoice_staff.staff_name as staff, reference_invoice_number,
        concat(invoice_details.service_type, ' ', invoice_details.service_category, ' ', invoice_details.service_name) as service,
        invoice_details.service_name,  invoice_details.service_id, invoice_details.service_type, invoice_details.service_category,
        invoice.discount as 'invoice_discount', invoice.payment_mode,
        paid_amount, total_payable as gross_amount, retained_amount, invoice.balance, invoice.advance_amount, cctip, tax_total, cc_charge,
        invoice_details.id_invoice_details, invoice_details.price, invoice_details.paid as paid_details, invoice_details.discount, paid_amount, paid_cash, paid_card, paid_voucher, paid_check, 
        concat(invoice_products.brand_name, ' ', invoice_products.product_name, ' x ', invoice_products.invoice_qty) product_name, 
        invoice_qty, invoice_products.price product_price, invoice_products.staff_name product_staff, 
        invoice_products.discount product_discount, feedback_status,
        DATE_FORMAT(invoice_date, '%d-%c-%Y') as invoice_date, DATE_FORMAT(visit_time, '%H:%i') as visit_time, DATE_FORMAT(visit_time, '%d-%c-%Y') as visit_date, retained_amount_used, invoice.created_by", False);
        $this->db->join('invoice_details', 'invoice_details.invoice_id = invoice.id_invoice', 'left', false);
        $this->db->join('invoice_staff', 'invoice_staff.invoice_detail_id = invoice_details.id_invoice_details and invoice_staff.invoice_id=invoice.id_invoice','left', false);
        $this->db->join('invoice_products', 'invoice_products.invoice_id = invoice.id_invoice', 'left', false);
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_status', 'valid');
         if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('invoice.invoice_seq > ', 0);
        }
        
        
        //$this->db->where('invoice_type', 'service');
        //$this->db->where('reference_invoice_number', '');
        
        if(null!==$today){
            $this->db->where('date_format(invoice_date , "%Y-%m-%d") =', $today);
        }
        if(null!==$feedback){
            $this->db->where('feedback_status', $feedback);            
        }
        if(null!==$type){
            $this->db->where('invoice_type', $type);            
        }
        if(null!==$invoice_id){
            $this->db->where('id_invoice', $invoice_id);            
        }
        //$this->db->where('reference_invoice_number !=', 'bad debts');
        $this->db->order_by('id_invoice '.$order.'');
        $query = $this->db->get('invoice');
        //echo $query; exit();
              
        return $query->result_array();
    }
    
    function getmaxinvoice(){
        $this->db->select('max(id_invoice) as maxid',false);
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_status', 'valid');
        $query= $this->db->get('invoice');
        
        return $query->row();
    }

    
    
    function getappointmentsstaff($id_customer_visit, $id_visit_service){
        $this->db->select('staff_id, staff_name');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('customer_visit_id', $id_customer_visit);
        $this->db->where('visit_service_id', $id_visit_service);
        $query = $this->db->get('visit_service_staffs');
        return $query->result();
    }
    
    function getappointments($appointment_date){
        //$today = date('Y-m-d');
        $today = date('Y-m-d',strtotime($appointment_date));
        
        $this->db->select('*, DATE_FORMAT(visit_service_start, "%d-%m-%Y") as Date');
        $this->db->join('customers', 'customers.id_customers = customer_visits.customer_id');
        $this->db->join('visit_services', 'visit_services.customer_visit_id = customer_visits.id_customer_visits');
        $this->db->join('service_category', 'service_category.id_service_category = visit_services.id_service_category');
        $this->db->where('customer_visits.business_id', $this->session->userdata('businessid'));
        //$this->db->where('visit_services.visit_service_start >=', $today);
        $this->db->like('visit_services.visit_service_start', $today);
        $this->db->where('customer_visits.visit_status !=', 'canceled');
        $this->db->order_by('visit_services.visit_service_start', 'asc');
        $query = $this->db->get('customer_visits');
        
        return $query->result();
    }
    
    function getproductbyname($product_name){
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('product', $product_name);
        $query = $this->db->get('business_products');
        return $query->row();
    }
    
    
    function cancel_invoice_old(){
        $invoice_id = $this->input->post('invoiceid', TRUE);
        $visit_order_id = $this->input->post('visit_order_id', TRUE);
        $flag = $this->input->post('flag', TRUE);
        
        //Find original invoice using reference
        $this->db->select("ifnull(reference_invoice_number,'') reference_invoice_number, is_recovery, balance, paid_amount, visit_id, invoice_number, loyalty_used, customer_id");
        $this->db->where("id_invoice =", $invoice_id);
        $query = $this->db->get("invoice");
        $results=$query->result();
        
        $customer_id=0;
        $loyaltyused=0;
        $visitid='';
        $isrecovery='';
        $balance='';
        $paid_amount='';
        $invoice_number='';
        if(isset($results)){
            foreach($results as $result){
                $visitid=$result->visit_id;
                $reference_invoice_number =$result->reference_invoice_number;
                $is_recovery=$result->is_recovery;
                $balance=$result->balance;
                $paid_amount =$result->paid_amount;
                $invoice_number=$result->invoice_number;
                $customer_id=$result->customer_id;
                $loyaltyused=$result->loyalty_used;
            }
        }
        
        if($balance !== "" && (float)$balance > 0 && $is_recovery=="No"){
            return "Balance from this invoice has been recovered in a later invoice. Please Cancel the latest invoice first!"  ; 
            exit();
        }
    }
    
    
    function cancel_invoice(){
        
        $invoice_id = $this->input->post('invoiceid', TRUE);
        $visit_order_id = $this->input->post('visit_order_id', TRUE);
        $flag = $this->input->post('flag', TRUE);
        $reason = $this->input->post('reason', TRUE);
        //Find original invoice using reference
        $this->db->select("ifnull(reference_invoice_number,'') reference_invoice_number, balance, paid_amount, visit_id, invoice_number, loyalty_used, customer_id");
        $this->db->where("id_invoice =", $invoice_id);
        $query = $this->db->get("invoice");
        $results=$query->result();
        
        $customer_id=0;
        $loyaltyused=0;
        $visitid='';
        $isrecovery='';
        $balance='';
        $paid_amount='';
        $invoice_number='';
        if(isset($results)){
            foreach($results as $result){
                $visitid=$result->visit_id;
                $isrecovery=$result->reference_invoice_number;
                $balance=$result->balance;
                $paid_amount =$result->paid_amount;
                $invoice_number=$result->invoice_number;
                $customer_id=$result->customer_id;
                $loyaltyused=$result->loyalty_used;
            }
        }
      

        if($isrecovery && $isrecovery !== ''){
            // change selected invoice status
            $this->db->where('id_invoice', $invoice_id);
            $this->db->update('invoice', array('invoice_status' => 'cancelled'));

            //Find newer recovery invoice
            $this->db->select('id_invoice, invoice_number, reference_invoice_number, balance, is_recovery');
            $this->db->where('visit_id=', $visitid);
            $this->db->where('id_invoice <>', $invoice_id);
            $this->db->where('invoice_status=', 'valid');
            $this->db->order_by('id_invoice','DESC');
            $this->db->limit(1);
            $query=$this->db->get('invoice');
            $newer_invoices=$query->result();
            
            
            foreach($newer_invoices as $newer_invoice)
            {
                if ($newer_invoice->id_invoice > $invoice_id){
                    
                    $new_balance = (float)$newer_invoice->balance + (float)$paid_amount;
                     //add balance back to the latests invoice
                    $this->db->where('invoice_number=',$newer_invoice->invoice_number);
                    $this->db->update('invoice', array('balance' => $new_balance));
                    
                }else {
                    // change original invoice status
                    $this->db->where('invoice_number', $newer_invoice->invoice_number);
                    $this->db->update('invoice', array('is_recovery' => 'Yes'));
                }
            }
        } else {
      
        
            if($flag === 'service'){
                //check if there are any referencing invoices
                $this->db->select('id_invoice, invoice_number, balance');
                $this->db->where('ifnull(reference_invoice_number,"") <>', '');
                 $this->db->where('id_invoice <>', $invoice_id);
                $this->db->where('visit_id=', $visitid);
                $this->db->where('invoice_status=', 'valid');
                $this->db->order_by('id_invoice','DESC');
                $this->db->limit(1);
                $query=$this->db->get('invoice');

                $referencing_invoices =  $query->num_rows();
                $referencing_i = $query->result_array();
                if($referencing_invoices > 0){
                    $referencing_number=$referencing_i[0]['invoice_number'];
                    return "error|Balance from this invoice has been recovered in a later invoice ". $referencing_number.". Please Cancel the latest invoice first!";
                }   else {
                
                    
                    // change invoice status
                    $this->db->where('id_invoice', $invoice_id);
                    $this->db->update('invoice', array('invoice_status' => 'cancelled', 'cancelreason' => $reason, 'cancelled_by' => $this->session->userdata('username')));

                    // change customer visits status
                    $this->db->where('id_customer_visits', $visit_order_id);
                    $this->db->update('customer_visits', array('visit_status' => 'open'));
                    
                                       
                }             
                
                
            } else{
                //check if there are any referencing invoices
                $this->db->select('id_invoice, invoice_number, balance');
                $this->db->where('ifnull(reference_invoice_number,"") <>', '');
                 $this->db->where('id_invoice <>', $invoice_id);
                $this->db->where('visit_id=', $visitid);
                $this->db->where('invoice_status=', 'valid');
                $this->db->order_by('id_invoice','DESC');
                $this->db->limit(1);
                $query=$this->db->get('invoice');

                $referencing_invoices =  $query->num_rows();
                $referencing_i = $query->result_array();
                
                if($referencing_invoices > 0){
                    $referencing_number=$referencing_i[0]['invoice_number'];
                    return "error|Balance from this invoice has been recovered in a later invoice ". $referencing_number.". Please Cancel the latest invoice first!";
                }   else {
                    $details = $this->getinvoiceproducts($invoice_id);

                    $qty = $details[0]['invoice_qty'];
                    $product_name = $details[0]['product_name'];

                    $product = $this->getproductbyname($product_name);


                    // change invoice status
                    $this->db->where('id_invoice', $invoice_id);
                    $this->db->update('invoice', array('invoice_status' => 'cancelled', 'cancelreason' => $reason));

                    // change customer visits status
                    $this->db->where('id_customer_order', $visit_order_id);
                    $this->db->update('customer_orders', array('order_status' => 'open'));

                }
            }
        }
        
        return "success|".$this->db->affected_rows();
    }
    
    function getpackageinvoicebyids($invoice_ids){
        $this->db->select('*, sum(net_amount) as netTotal, sum(gross_amount) as grossTotal, sum(paid_amount) as paidTotal, sum(returnamount) as returnTotal, sum(balance) as balanceTotal');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where_in('id_invoice', $invoice_ids);
        $query = $this->db->get('invoice');
        return $query->result_array();
    }
    
    function check_invoice_recoverable($invoiceid){
        $this->db->select('is_recovery, customer_id, id_invoice');
        //$this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('id_invoice', $invoiceid);
        $query = $this->db->get('invoice');
        return $query->row();
    }
    
    function getinvoicebyid($invoiceid){
        $this->db->select('*,date_format(invoice_date,"%d-%m-%Y") as invoice_date');
        $this->db->join('customers', 'customers.id_customers = invoice.customer_id');
       // $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice.id_invoice=', $invoiceid);
        $query = $this->db->get('invoice');
        
        return $query->result_array();
    }
    
    function getinvoicebyno($invoiceno){
        $this->db->select('*,date_format(invoice_date,"%d-%m-%Y %H:%i") as invoice_date');
       // $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice.invoice_number=', $invoiceno);
        $query = $this->db->get('invoice');
        
        return $query->result_array();
    }
    
    function getpackageinvoicedetails($invoice_ids){
        $this->db->select('invoice_details.*');
        $this->db->join('invoice', 'invoice.id_invoice = invoice_details.invoice_id');
        $this->db->where('invoice_details.business_id', $this->session->userdata('businessid'));
        $this->db->where_in('invoice_id', $invoice_ids);
        $this->db->order_by('invoice.visit_time, invoice_details.invoice_detail_date');
        $query = $this->db->get('invoice_details');
        
        return $query->result_array();
    }
    
    function getinvoicedetails($invoiceid){
        $this->db->select('*');
        $this->db->where('invoice_details.invoice_id=', $invoiceid);
        $query = $this->db->get('invoice_details');
        
        return $query->result_array();
    }
    
    function getinvoicestaff($invoiceid){
        $this->db->select('*');
        $this->db->where('staff_services.invoice_id=', $invoiceid);
        $query = $this->db->get('staff_services');
        
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
        $this->db->join('visit_service_staffs', 'visit_services.id_visit_services = visit_service_staffs.visit_service_id');
        $this->db->where('customer_visits.visit_status','open');
        $this->db->where('visit_service_staffs.staff_id like',$cur_staffid);
        $this->db->where('customer_visits.id_customer_visits <>',$visitid);
        $this->db->where('visit_services.business_id', $this->session->userdata('businessid'));
        $this->db->order_by('id_customer_visits', 'DESC');
        $this->db->limit(1);
        $nextvisitnumber=$this->db->get('visit_services');

        foreach ($nextvisitnumber->result() as $row){
            
            $cur_visit_id = $row->id_customer_visits;
            
        }
       
        return $cur_visit_id;
        
    }
    
    function discount_login() {
        $username = $this->db->escape_str($this->input->post('discount_username', TRUE));
        $password = md5($this->db->escape_str($this->input->post('discount_password', TRUE)));
        
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('discount_password');
        
        return $query->row();
    }
    
    function invoice_service_product($serviceid){
        $this->db->select('sp.business_product_id, sp.business_service_id, bp.product, bp.id_business_products');
        $this->db->join('business_products bp', 'bp.id_business_products = sp.business_product_id');
        $this->db->where('sp.business_service_id', $serviceid);
        $result = $this->db->get('services_products sp');
        
        return $result->result_array();
    }
    
    function invoice_service_product_update(){
        $product_id = $this->input->post('product_id', TRUE) ? $this->input->post('product_id', TRUE) : NULL;
        $product_name = $this->input->post('product_name', TRUE) ? $this->input->post('product_name', TRUE) : NULL;
        
        $this->db->where('visit_service_id', $this->input->post('visit_service_id', TRUE));
        $this->db->where('customer_visit_id', $this->input->post('customer_visit_id', TRUE));
        $delete_visit_product = $this->db->delete('visit_service_products');
        $data = array();
        if ($delete_visit_product) {
            if ($product_id && $product_id != NULL) {
                for ($i = 0; $i < sizeof($product_id); $i++) {
                    $data[] = array(
                        'customer_visit_id' => $this->input->post('customer_visit_id', TRUE),
                        'visit_service_id' => $this->input->post('visit_service_id', TRUE),
                        'product_id' => $product_id[$i],
                        'product_name' => $product_name[$i],
                        'business_id' => $this->session->userdata('businessid')
                    );
                }
                $this->db->insert_batch('visit_service_products', $data);
                return $this->input->post('visit_service_id');
            } else {
                return $this->input->post('visit_service_id');
            }
        }
    }
    
    public function get_advance_byid($visitid){
        $this->db->select('sum(paid_amount) as "advance"');
        $this->db->where('visit_id', $visitid);
        $this->db->where('advance', 'true');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $result = $this->db->get('invoice');
        
        return $result->result_array();
    }

    public function invoice_balance($invoiceid){
        
        $this->db->select('balance');
        $this->db->where('id_invoice', $invoiceid);
        $this->db->where('is_recovery', 'Yes');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $result = $this->db->get('invoice');
        
        return $result->result_array();
        
    }
    
    public function invoice_sms_update($invoiceid, $sendsms){
        
        if($sendsms !== 'SMS Service is not setup!'){
            $pos= strpos($sendsms, '<?xml version="1.0" encoding="utf-8"?>');
            $myXMLData= substr($sendsms, $pos);
            $xml = simplexml_load_string($myXMLData);
            $this->db->set('sms_log', 'error:'.$xml->error.' status:'.$xml->status.' msg:'.$xml->msgdata.' receiver:'.$xml->receiver);
        } else {
            $this->db->set('sms_log', 'error:'.$sendsms);        
        }
        
        $this->db->where('id_invoice',$invoiceid);
        $this->db->update('invoice');
        
        return $invoiceid;
        
    }
    public function get_day_retail_count($sh=false){
        
        $today=$today = date('Y-m-d');
        
        $this->db->select("count(id_invoice) invoices",false);
        $this->db->where("date_format(invoice_date, '%Y-%m-%d')=",$today);
        $this->db->where("invoice_type =","sale");
        if($sh==true || $this->session->userdata('role')=='Sh-Users'){
             $this->db->where("invoice_seq >",0);
        }
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $result = $this->db->get('invoice');
        
        return $result->row();
    }
    
    public function get_day_services_count($sh=false){
        
        $today=$today = date('Y-m-d');
        
        $this->db->select("count(id_invoice) invoices",false);
        $this->db->where("date_format(invoice_date, '%Y-%m-%d')=",$today);
        $this->db->where("invoice_type =","service");
         if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('invoice.invoice_seq > ', 0);
        }
        
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $result = $this->db->get('invoice');
        
        return $result->row();
        
    }

   
    public function get_discounttypes(){
        
        $this->db->select("id_discount_reasons, discount_reason",false);
      
      //  $this->db->where('business_id', $this->session->userdata('businessid'));
        $result = $this->db->get('discount_reasons');
        return $result->result_array();
    }
    
    public function update_feedback($invoiceid, $status){
        
        $this->db->set('feedback_status',$status);
        $this->db->where('id_invoice',$invoiceid);
        $this->db->update('invoice');
        
        return $invoiceid;
        
    }
}
