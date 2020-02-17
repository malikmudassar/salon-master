<?php

class Report_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function allsales($startdate, $enddate, $sh=false) {

       // $date = strtotime("+ 1 days", strtotime($enddate));
       // $enddate = date("Y-m-d", $date);

        $this->db->select("date_format(visit_time, '%d-%m-%Y %H:%i') as 'visit', date_format(invoice_date,'%d-%m-%Y %H:%i') as 'Invoiced', id_invoice as invoice_id, invoice_type as 'Sale Type', sub_total as 'Sub Total', gross_amount as 'Gross', discount as 'Discount', tax_total as 'Taxes', net_amount as 'Net Amount', paid_amount as 'paid', invoice.advance_amount as 'advance', balance, discount_remarks, invoice.customer_name, invoice.reference_invoice_number as 'reference_number', invoice_status, cancelreason");
        //$this->db->join("customer_visits", "customer_visits.id_customer_visits = invoice.visit_id");
        //$this->db->join("visit_services", "customer_visits.id_customer_visits = visit_services.customer_visit_id");
        $this->db->where('invoice_date >=', $startdate.' 00:00');
        $this->db->where('invoice_date <=', $enddate.' 23:59');
        
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('invoice.invoice_seq > ', 0);
        }
        
        //$this->db->where('invoice_status', 'valid');
        //$this->db->where('reference_invoice_number <>', 'bad debts');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        //$this->db->group_by('id_invoice');
        $query = $this->db->get('invoice');
        //echo $query; exit();
        return $query->result_array();
    }

    function monthly_sales($startdate, $enddate, $sh=false) {

      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);

        $this->db->select("date_format(invoice_date,'%M') as 'Month', date_format(invoice_date,'%Y') as 'Year', round(sum(sub_total),2) as 'Sub Total', "
                . "round(sum(gross_amount),2) as 'Gross', round(sum(discount),2) as 'Discount', round(sum(tax_total),2) as 'Taxes', round(sum(net_amount),2) as 'Net Amount', round(sum(paid_amount),2) as 'paid', round(sum(balance),2) as 'balance'");
        $this->db->join("months","months.month = month(invoice_date)", "left");
        $this->db->where('invoice_date >=', $startdate." 00:00");
        $this->db->where('invoice_date <=', $enddate." 23:59");
        $this->db->where('invoice_status', 'valid');
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('invoice.invoice_seq > ', 0);
        }
        //$this->db->where('reference_invoice_number <>', 'bad debts');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('1,2');

        $query = $this->db->get('invoice');

        return $query->result_array();
    }

    function monthly_advances($startdate, $enddate, $sh=false) {

      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);

        $this->db->select("date_format(visit_advance.advance_date,'%M') as 'Month', date_format(visit_advance.advance_date,'%Y') as 'Year', ifnull(sum(visit_advance.advance_amount),0) as 'TotalAdvance'");
       
        $this->db->join("customer_visits", "customer_visits.id_customer_visits = visit_advance.customer_visit_id");
        
        $this->db->where('visit_advance.advance_date >=', $startdate." 00:00");
        $this->db->where('visit_advance.advance_date <=', $enddate." 23:59");
        $this->db->where('customer_visits.visit_status !=', 'canceled');
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('customer_visits.invoice_seq > ', 0);
        }
        //$this->db->where('reference_invoice_number <>', 'bad debts');
        $this->db->where('customer_visits.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('1,2');

        $query = $this->db->get('visit_advance');

        return $query->result_array();
    }
    
    function monthly_vouchers($startdate, $enddate, $sh=false) {

      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);

         $this->db->select("date_format(order_vouchers.voucher_date,'%M') as 'Month', date_format(order_vouchers.voucher_date,'%Y') as 'Year', ifnull(sum(order_vouchers.amount),0) as 'TotalVoucher'");
       
        
        
        $this->db->where('order_vouchers.voucher_date >=', $startdate." 00:00");
        $this->db->where('order_vouchers.voucher_date <=', $enddate." 23:59");
        
       
        $this->db->where('order_vouchers.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('1,2');

        $query = $this->db->get('order_vouchers');

        return $query->result_array();
    }
    
    function product_usage_details($product_id, $startdate, $enddate, $sh=false) {

      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);

        $this->db->select("inv.id_invoice, bp.category, service_name,  customer_name, product_name, product_qty, product_unit, date_format(invoice_date, '%d-%m-%Y') as 'Date'");
        $this->db->join('invoice_visit_products ivp', 'inv.id_invoice = ivp.invoice_id');
        $this->db->join('business_products bp', 'ivp.product_id = bp.id_business_products');
        $this->db->join('business_brands bb', 'bp.brand_id = bb.id_business_brands');
        $this->db->where('inv.invoice_date >=', $startdate." 00:00");
        $this->db->where('inv.invoice_date <=', $enddate." 23:59");
        $this->db->where('ivp.product_id', $product_id);
        $this->db->where('inv.invoice_status', 'valid');
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('invoice.invoice_seq > ', 0);
        }
        $this->db->where('inv.business_id', $this->session->userdata('businessid'));
        $this->db->where('inv.invoice_type=', 'service');
        $this->db->group_by('ivp.invoice_id');
        $query = $this->db->get('invoice inv');
        return $query->result_array();
    }

    function product_usage_summary($startdate, $enddate, $sh=false) {

       // $date = strtotime("+ 1 days", strtotime($enddate));
       // $enddate = date("Y-m-d", $date);

//        $this->db->select("inv.id_invoice, ivp.product_name, ivp.product_id, count(ivp.product_name) as product_count, sum(ivp.product_qty) as total_qty, ivp.product_unit, bp.unit_type as 'Container Type', bb.business_brand_name, bp.qty_per_unit as Container Qty, (sum(ivp.product_qty) / bp.qty_per_unit) as 'Container Used'");
//        $this->db->join('invoice_visit_products ivp', 'inv.id_invoice = ivp.invoice_id');
//        $this->db->join('business_products bp', 'ivp.product_id = bp.id_business_products');
//        $this->db->join('business_brands bb', 'bp.brand_id = bb.id_business_brands');
//        $this->db->where('inv.invoice_date >=', $startdate);
//        $this->db->where('inv.invoice_date <=', $enddate);
//        $this->db->where('inv.invoice_status', 'valid');
//        $this->db->where('inv.business_id', $this->session->userdata('businessid'));
//        $this->db->where('inv.invoice_type=', 'service');
//        $this->db->group_by('inv.id_invoice, ivp.product_name, ivp.product_id,ivp.product_unit, bp.unit_type , bb.business_brand_name, bp.qty_per_unit ');
//        $query = $this->db->get('invoice inv');
        
        
         $this->db->select("ivp.product_name, ivp.product_id, count(ivp.product_name) as product_count, sum(ivp.product_qty) as total_qty, "
                 . "ivp.product_unit, bp.category, bp.unit_type as 'Container Type', bb.business_brand_name, "
                 . "bp.qty_per_unit as Container Qty, "
                 . "(sum(ivp.product_qty) / bp.qty_per_unit) as 'Container Used'");
        $this->db->join('invoice_visit_products ivp', 'inv.id_invoice = ivp.invoice_id');
        $this->db->join('business_products bp', 'ivp.product_id = bp.id_business_products');
        $this->db->join('business_brands bb', 'bp.brand_id = bb.id_business_brands');
        $this->db->where('inv.invoice_date >=', $startdate." 00:00");
        $this->db->where('inv.invoice_date <=', $enddate." 23:59");
        $this->db->where('inv.invoice_status', 'valid');
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('inv.invoice_seq > ', 0);
        }
        $this->db->where('inv.business_id', $this->session->userdata('businessid'));
        $this->db->where('ifnull(inv.reference_invoice_number,"")=','');
        $this->db->where('inv.invoice_type=', 'service');
        $this->db->group_by('ivp.product_name, ivp.product_id, bb.business_brand_name');
        $query = $this->db->get('invoice inv');
        
        return $query->result_array();
    }

    function category_sales($startdate, $enddate, $sh=false) {
        

        
        $sql = "select  a.service_type, a.service_category, sum(a.price) price, round(sum(a.discount),2) discount, 
            round(sum(invoice.discount),2) invoicediscount,
        round(sum(a.discounted_price),2) discounted_price, sum(a.paid) paid, count(distinct(invoice_id)) services,
        round(sum(invoice.tax_total),2) as tax, round(sum(invoice.cc_charge),2) as cc_charge, round(sum(total_payable),2) total_payable
        from invoice 
        join(
            SELECT invoice_id, service_type, service_category, 
		price as price, discount as discount, 
		discounted_price as discounted_price, paid as paid
		FROM invoice_details
                where convert(invoice_detail_date, date)>='" . $startdate." 00:00" . "' 
                and convert(invoice_detail_date, date)<='" . $enddate." 23:59" . "' 
            ) as a on a.invoice_id = invoice.id_invoice
            where invoice.business_id = " . $this->session->userdata('businessid') . "
            and invoice.invoice_status ='valid' ";
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $sql .= " and invoice.invoice_seq > 0 ";
        }
        $sql .= "    and ifnull(reference_invoice_number,'') = ''
            group by service_type, service_category";
        
        
        
        $query = $this->db->query($sql);

        return $query->result_array();
        
    }
    
    function service_sales($startdate, $enddate, $sh=false) {



        $sql = "select count(a.invoice_id) as service_count, service_type, service_category, service_name,  sum(a.payable) payable, sum(a.discount) discount, sum(a.paid) paid, sum(a.price) price 
        from invoice i join
        (
        select invoice_id, service_type, 
        service_category, service_name, sum(price) as 'price',
        sum(discounted_price) as 'payable', sum(discount) as 'discount', sum(paid) as 'paid'
        from invoice_details ss 
        where convert(invoice_detail_date, date)>='" . $startdate." 00:00" . "' 
        and convert(invoice_detail_date, date)<='" . $enddate." 23:59" . "' 
        group by invoice_id, service_type, service_category, service_name 
        ) as a
        on a.invoice_id=i.id_invoice
        where i.invoice_status='valid' and ifnull(i.reference_invoice_number,'')='' and 
        i.business_id = " . $this->session->userdata('businessid') . " ";
         if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $sql .= " and i.invoice_seq > 0 ";
        }
        
        $sql .= "group by service_type, service_category, service_name";
       
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function service_sale_details($startdate, $enddate, $sh=false) {

       // $date = strtotime("+ 1 days", strtotime($enddate));
       // $enddate = date("Y-m-d", $date);
        
        $select=" id_invoice_details, id_invoice, invoice_details.service_type, invoice_details.service_category, 
                invoice_details.service_name, date_format(visit_time, '%d-%m-%Y %H:%i') as 'visited', 
                date_format(invoice_date, '%d-%m-%Y %H:%i') as 'invoiced', customer_name, 
                customer_cell, staff_name as 'staff', ifnull(invoice_details.discounted_price, 0), 
                ifnull(invoice.discount, 0) 'Invoice Discount', invoice_details.price, 
                ifnull(invoice_details.discount, 0) as 'Service Discount', 
                invoice_details.discounted_price as 'Net Amount', invoice_details.paid as 'paid', 
                balance as 'balance', ifnull(reference_invoice_number, '') as reference_number ";
        
        $this->db->select($select, FALSE);
        $this->db->join('invoice_details', 'invoice.id_invoice = invoice_details.invoice_id');
        $this->db->join('invoice_staff',  'invoice_details.id_invoice_details = invoice_staff.invoice_detail_id', FALSE,FALSE);
        $this->db->where('invoice_date >=', $startdate." 00:00");
        $this->db->where('invoice_date <=', $enddate." 23:59");
        $this->db->where('invoice_status', 'valid');
         if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('invoice_seq > ', 0);
        }
        
        //$this->db->where('reference_invoice_number <>', 'bad debts');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_type', 'service');
        
        if(null!==$this->input->post('service_type')&&$this->input->post('service_type')!=="All"){
            $this->db->where("invoice_details.service_type", $this->input->post('service_type')); 
        }        
        if(null!==$this->input->post('service_category') && $this->input->post('service_category')!==""){
            if($this->input->post('service_category')!=="All"){
                $this->db->where("invoice_details.service_category",$this->input->post('service_category')); 
            }
        } 
        if(null!==$this->input->post('id_business_services') && $this->input->post('id_business_services')>0){
            $this->db->where("invoice_details.service_id",$this->input->post('id_business_services')); 
        }
        if(null!==$this->input->post('staff_id') && $this->input->post('staff_id')>0){
            $this->db->where("staff_name", $this->input->post('staff_name')); 
        }
        
        
        //$this->db->group_by('id_invoice_details');
        //$this->db->order_by('service_type', 'service_category', 'service_name');
        $this->db->order_by('id_invoice, id_invoice_staff, id_invoice_details');
        $query = $this->db->get('invoice');
    
        
     //   echo $query; exit();
        return $query->result_array();
    }

    function staff_performance($startdate, $enddate, $sh=false) {

      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);

        $this->db->select("service_type, service_category, service_name, staff_name, date_format(invoice_date, '%d-%m-%Y') as 'Date', count(service_name) as service_count, sum(price) as price, sum(staff_services.discount) as discount_sum, sum(discounted_price) as price_sum, sum(paid) as paid");
        $this->db->join('staff_services', 'invoice.id_invoice = staff_services.invoice_id');
        $this->db->where('invoice_date >=', $startdate." 00:00");
        $this->db->where('invoice_date <=', $enddate." 23:59");
        $this->db->where('invoice_status', 'valid');
         if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('invoice_seq > ', 0);
        }
        
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        //$this->db->where('reference_invoice_number <>', 'bad debts');
        $this->db->where('ifnull(invoice.reference_invoice_number,"")=""');
        $this->db->where('invoice_type', 'service');
        $this->db->order_by('staff_name', 'service_type', 'service_category', 'service_name');
        $this->db->group_by('service_type');
        $this->db->group_by('service_category');
        $this->db->group_by('service_name');
        $this->db->group_by('staff_name');
        $query = $this->db->get('invoice');
       
        return $query->result_array();
    }

    function product_sales($startdate, $enddate, $sh=false) {
     //   $date = strtotime("+ 1 days", strtotime($enddate));
     //   $enddate = date("Y-m-d", $date);

//        $this->db->select("brand_name, product_name, sum(invoice_qty) as 'Quantity', sum(discounted_price) as 'Total Sale', "
//                . "sum(invoice_products.discount) as 'Discount Sum', price as 'Avg. Sale Price'");
//        $this->db->join('invoice_products', 'invoice_id = invoice.id_invoice');
//        $this->db->where('invoice_date >=', $startdate);
//        $this->db->where('invoice_date <=', $enddate);
//        $this->db->where('invoice_status', 'valid');
//        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
//        $this->db->where('invoice.invoice_type=', 'sale');
//        $this->db->group_by('product_name');
//        $this->db->order_by('brand_name', 'product_name');
//        $query = $this->db->get_compiled_select('invoice');
//        echo $query;
//        exit();

        $sql = "SELECT brand_name, product_name, ifnull(category,'') as 'category', sum(Quantity) as 'Quantity', 
        sum(a.Price) as 'Price', sum(a.Discount) as 'Discount', sum(a.paid) as 'Paid', i.balance
        from invoice i
        join 
        (
        select invoice_id, brand_name, product_name, category, sum(invoice_qty) as 'Quantity', 
        sum(ss.discounted_price) as 'Price', sum(ss.discount) as 'Discount',  sum(paid) as 'Paid'
        from invoice_products ss 
        where 
        convert(invoice_product_date, date)>='" . $startdate." 00:00" . "' and convert(invoice_product_date, date)<='" . $enddate." 23:59" . "' 
        group by invoice_id, brand_name,  product_name, category
        ) as a
        on a.invoice_id=i.id_invoice
        where convert(invoice_date, date)>='" . $startdate." 00:00" . "' and convert(invoice_date, date)<='" . $enddate." 23:59" . "' 
        and invoice_type='sale' 
        and ifnull(reference_invoice_number,'')=''
        and invoice_status='valid' and i.business_id = " . $this->session->userdata('businessid') . " ";
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $sql.=" and i.invoice_seq >  0 ";
        }
        
        $sql .= "group by brand_name, product_name, category";

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function product_sale_details($startdate, $enddate, $sh=false) {

       // $date = strtotime("+ 1 days", strtotime($enddate));
       // $enddate = date("Y-m-d", $date);

        $this->db->select("id_invoice, brand_name as 'Brand', product_name as 'Product', ifnull(category,'') as 'category', invoice_qty as 'Quantity', date_format(invoice_date, '%d-%m-%Y') as 'Date', invoice.customer_name as 'Customer', staff_name as 'Sold By', invoice_products.price, invoice_products.discount as 'Discount', invoice_products.discounted_price as 'Total', ifnull(invoice_products.paid,0) as 'Paid', invoice.reference_invoice_number as 'reference_number', ifnull(invoice.paid_amount, 0) as 'paid_amount'");
        $this->db->join('invoice_products', 'invoice_products.invoice_id = invoice.id_invoice');
        $this->db->where('invoice_date >=', $startdate." 00:00");
        $this->db->where('invoice_date <=', $enddate." 23:59");
        $this->db->where('invoice_status', 'valid');
        //$this->db->where('ifnull(invoice.reference_invoice_number,"")=""');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice.invoice_type=', 'sale');
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('invoice.invoice_seq > ', 0);
        }        
        //$this->db->where('reference_invoice_number <>', 'bad debts');
        $this->db->order_by('brand_name', 'product_name', 'category');

        $query = $this->db->get('invoice');
        
        return $query->result_array();
    }

    function invoices($startdate, $enddate, $sh=false) {

       // $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);

        $this->db->select('*,DATE_FORMAT(invoice_date, "%d-%m-%Y") as invoice_date');
        $this->db->join('discount_invoice_users', 'discount_invoice_users.invoiceid = invoice.id_invoice', 'left');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_date >=', $startdate." 00:00");
        $this->db->where('invoice_date <=', $enddate." 23:59");
        //$this->db->where('reference_invoice_number <>', 'bad debts');
        $this->db->where('invoice.invoice_status=', 'valid');
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('invoice_seq > ', 0);
        } 
        
        $query = $this->db->get('invoice');
      //  echo $query;exit();
        
        return $query->result_array();
    }
    
    function recoveries($startdate, $enddate, $sh=false) {

      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);

        $this->db->select('*,DATE_FORMAT(invoice_date, "%d-%m-%Y") as invoice_date');
        $this->db->join('discount_invoice_users', 'discount_invoice_users.invoiceid = invoice.id_invoice', 'left');
        
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_date >=', $startdate." 00:00");
        $this->db->where('invoice_date <=', $enddate." 23:59");
        //$this->db->where('reference_invoice_number <>', 'bad debts');
        $this->db->where('ifnull(reference_invoice_number,"") <>', '');
        $this->db->where('invoice.invoice_status=', 'valid');
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('invoice_seq > ', 0);
        } 
        $query = $this->db->get('invoice');

        return $query->result_array();
    }

    function cancelled_invoices($startdate, $enddate, $sh=false) {

      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);

        $this->db->select('*,DATE_FORMAT(invoice_date, "%d-%m-%Y") as invoice_date');
        $this->db->join('discount_invoice_users', 'discount_invoice_users.invoiceid = invoice.id_invoice', 'left');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_date >=', $startdate." 00:00");
        $this->db->where('invoice_date <=', $enddate." 23:59");
       // $this->db->where('reference_invoice_number <>', 'bad debts');
        $this->db->where('invoice.invoice_status=', 'cancelled');
        $query = $this->db->get('invoice');

        return $query->result_array();
    }

    function commission_details($staff_id, $startdate, $enddate, $sh=false) {

      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);

        $this->db->select("reference_invoice_number, staff_fullname, staff_id, service_type, service_category, staff_services.service_name, bs.commission_perc staff_commission, staff_services.paid, reference_invoice_number, "
                . "date_format(invoice_date,'%d-%m-%Y %H:%i') as staff_service_date, invoice_id, staff_services.discounted_price, date_format(customer_visits.customer_visit_date, '%d-%m-%Y %H:%i') as customer_visit_date");
        $this->db->join("business_services bs", " staff_services.service_id = bs.id_business_services");
        $this->db->join("invoice", " invoice.id_invoice = staff_services.invoice_id");
        $this->db->join("staff", "staff.id_staff = staff_services.staff_id");
        $this->db->join("customer_visits", "staff_services.visit_id = customer_visits.id_customer_visits");
        $this->db->where("invoice_status='valid'");
        $this->db->where('staff_services.business_id', $this->session->userdata('businessid'));
       // $this->db->where('reference_invoice_number <>', 'bad debts');
       // $this->db->where('ifnull(invoice.reference_invoice_number,"")=""');
        $this->db->where('invoice_date >=', $startdate." 00:00");
        $this->db->where('invoice_date <=', $enddate." 23:59");
        $this->db->where('staff_id', $staff_id);
        //$this->db->group_by("staff_id");
        $query = $this->db->get('staff_services');
        
        return $query->result_array();
    }
    function retail_commission_details($staff_id, $startdate, $enddate, $sh=false) {

      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);

        $this->db->select("reference_invoice_number, staff_fullname, staff_id, business_brand_name, 
                bp.product, bp.qty_per_unit, bp.measure_unit, invoice_products.invoice_qty,
                bp.commission commission, 
               invoice_products.paid, 
               date_format(invoice_date, '%d-%m-%Y %H:%i') as invoice_date, 
               invoice_id, invoice_products.discounted_price, round((invoice_products.discounted_price*bp.commission)/100,2) as staff_commission", false);
        $this->db->join("business_products bp", "invoice_products.product_id = bp.id_business_products ");
        $this->db->join("business_brands bb", "bb.id_business_brands = bp.brand_id");
        $this->db->join("invoice", "invoice.id_invoice = invoice_products.invoice_id");
        $this->db->join("staff", "staff.id_staff = invoice_products.staff_id");
        
        $this->db->where("invoice_status='valid'");
        $this->db->where('invoice_products.business_id', $this->session->userdata('businessid'));
       // $this->db->where('reference_invoice_number <>', 'bad debts');
       // $this->db->where('ifnull(invoice.reference_invoice_number,"")=""');
        $this->db->where('invoice_date >=', $startdate." 00:00");
        $this->db->where('invoice_date <=', $enddate." 23:59");
        $this->db->where('staff_id', $staff_id);
        //$this->db->group_by("staff_id");
        $query = $this->db->get('invoice_products');
       // echo $query; exit();
        
        return $query->result_array();
    }
    function commissions($startdate, $enddate, $sh=false) {

      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);


        $sql="SELECT staff.id_staff staff_id, 
                staff.staff_fullname staff_name, date_format(invoice_date, '%m'),  date_format(invoice_date, '%M') as 'Month', date_format(invoice_date, '%Y') as 'Year',
                staff.staff_image, 
                count(id_staff_services) as 'Total Services', 
                format(sum(paid), 2) as 'Amount', 
                ifnull(a.Recovery,0) 'Recovery', 
                format(ifnull(sum(paid) + ifnull(a.total,0),0),2) as 'Total',
                ifnull(sum(paid) + ifnull(a.total,0),0), avg(bs.commission_perc) commission_perc,
                format(ifnull(sum(paid) + ifnull(a.total,0),0) * avg(bs.commission_perc)/100,2) 'Commission'
                FROM staff_services 
                join business_services bs on bs.id_business_services = staff_services.service_id
                JOIN invoice ON invoice.id_invoice = `staff_services`.`invoice_id` 
                JOIN staff ON staff.id_staff = staff_services.staff_id 
                left join (
                        SELECT id_staff, format(sum(ifnull(paid,0)), 2) as 'Recovery', sum(ifnull(paid,0)) as 'total', avg(commission_perc) commission_perc,
                        count(id_staff_services) as 'rec_count', date_format(invoice_date, '%m') Month, date_format(invoice_date, '%Y') Year
                        FROM `staff_services` 
                        join business_services bs on bs.id_business_services = staff_services.service_id
                        JOIN `invoice` ON `invoice`.`id_invoice` = `staff_services`.`invoice_id` 
                        JOIN staff ON staff.id_staff = staff_services.staff_id 
                        WHERE invoice_date >= '". $startdate." 00:00"."' AND invoice_date <= '".$enddate." 23:59"."' 
                        AND `staff_name` NOT LIKE '%|%' ESCAPE '!' 
                        AND ifnull(reference_invoice_number,'') != '' 
                        AND `invoice_type` = 'service' 
                        AND `invoice_status` = 'valid' 
                        AND invoice.business_id= ".$this->session->userdata('businessid')."
                        GROUP BY id_staff, date_format(invoice_date, '%m'), date_format(invoice_date, '%Y')
                ) as a on a.id_staff = staff_services.staff_id and a.Month = month(invoice_date) and a.Year = year(invoice_date)
                WHERE invoice_date >= '".$startdate." 00:00"."' AND invoice_date <= '".$enddate." 23:59"."' 
                AND staff_services.staff_name NOT LIKE '%|%' ESCAPE '!' AND ifnull(reference_invoice_number,'') = '' 
                AND invoice_type = 'service' 
                AND invoice_status = 'valid' 
                AND invoice.business_id=".$this->session->userdata('businessid')."
                GROUP BY staff.id_staff, staff.staff_fullname, date_format(invoice_date, '%M'), date_format(invoice_date, '%Y')
                ORDER BY 3,8 desc";
         //echo $sql;
                
        $query = $this->db->query($sql);
        
        
        return $query->result_array();
    }

    function retailcommissions($startdate, $enddate, $sh=false) {

      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);


        $sql="SELECT staff.id_staff staff_id, staff.staff_fullname staff_name, 
            date_format(invoice_date, '%m'), 
            date_format(invoice_date, '%M') as 'Month', 
            date_format(invoice_date, '%Y') as 'Year', 
            staff.staff_image, sum(invoice_qty) as 'Total Products', format(sum(paid), 2) as 'Amount', 
            ifnull(a.Recovery,0) 'Recovery', format(ifnull(sum(paid) + ifnull(a.total,0),0),2) as 'Total', 
            ifnull(sum(paid) + ifnull(a.total,0),0), commission commission_perc, 
            format(ifnull(sum(paid) + ifnull(a.total,0),0) * avg(commission)/100,2) 'Commission' 
            FROM invoice_products 
            join business_products bp on bp.id_business_products = invoice_products.product_id 
            JOIN invoice ON invoice.id_invoice = invoice_products.invoice_id 
            JOIN staff ON staff.id_staff = invoice_products.staff_id
            left join ( 
                    SELECT id_staff, format(sum(ifnull(paid,0)), 2) as 'Recovery', 
                    sum(ifnull(paid,0)) as 'total', avg(commission) commission_perc, 
                    sum(invoice_qty) as 'rec_count', date_format(invoice_date, '%m') Month, 
                    date_format(invoice_date, '%Y') Year 
                    FROM invoice_products 
                    join business_products bp on bp.id_business_products = invoice_products.product_id 
                    JOIN `invoice` ON `invoice`.`id_invoice` = invoice_products.invoice_id  
                    JOIN staff ON staff.id_staff = invoice_products.staff_id
                    WHERE invoice_date >= '". $startdate." 00:00"."' AND invoice_date <= '".$enddate." 23:59"."' 
                    AND ifnull(reference_invoice_number,'') != '' 
                    AND `invoice_type` = 'sale' AND `invoice_status` = 'valid' 
                    AND invoice.business_id= ".$this->session->userdata('businessid')."
                    AND staff.business_id= ".$this->session->userdata('businessid')."
                    GROUP BY id_staff, date_format(invoice_date, '%m'), date_format(invoice_date, '%Y') 
            ) as a on a.id_staff = invoice_products.staff_id 
            and a.Month = month(invoice_date) 
            and a.Year = year(invoice_date) 
            WHERE invoice_date >= '". $startdate." 00:00"."' AND invoice_date <= '".$enddate." 23:59"."' 
            AND ifnull(reference_invoice_number,'') = '' 
            AND invoice_type = 'sale' AND invoice_status = 'valid' 
            AND invoice.business_id= ".$this->session->userdata('businessid')." AND staff.business_id= ".$this->session->userdata('businessid')."
            GROUP BY staff.id_staff, staff.staff_fullname, 
            date_format(invoice_date, '%M'), date_format(invoice_date, '%Y') 
            ORDER BY 3,8 desc";
         //echo $sql;
                
        $query = $this->db->query($sql);
        
        
        return $query->result_array();
    }
    
    function taxes($startdate, $enddate, $sh=false) {
      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);

        $this->db->select("date_format(invoice_date, '%M') as 'Month', date_format(invoice_date, '%Y') as 'Year', invoice_tax_name as 'Tax Type', sum(invoice_tax) as 'Total'");
        $this->db->join("invoice", " invoice.id_invoice = invoice_taxes.invoice_id");
        $this->db->where("invoice_status='valid'");
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('invoice_seq > ', 0);
        } 
        $this->db->where('invoice_taxes.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_date >=', $startdate." 00:00");
        $this->db->where('invoice_date <=', $enddate." 23:59");
        $this->db->group_by("date_format(invoice_date, '%M'), date_format(invoice_date, '%Y'), invoice_tax_name");
        $query = $this->db->get('invoice_taxes');

        return $query->result_array();
    }

    function attendance($startdate, $enddate, $sh=false) {
      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);
        $query = $this->db->query("
                select sa.id_staff_attendance,sa.business_id,sa.staff_id,
                st.staff_fullname,date_format(sa.time_in,'%h:%i:%s') as time_show,date_format(sa.time_out,'%h:%i:%s') as time_show_out,date_format(sa.time_in,'%Y-%m-%e') as time_in 
                from staff_attendance sa 
                join business b on b.id_business = sa.business_id 
                join staff st on st.id_staff = sa.staff_id 
                where sa.business_id = '" . $this->session->userdata('businessid') . "' 
                and sa.time_in between '$startdate%' 
                and '$enddate%' 
               
                order by sa.id_staff_attendance asc
                ");
       
        return $query->result_array();
    }

    function attendance_month_view($startdate, $enddate, $sh=false) {
        $year = date('Y');
        //$monthdays = date();
        $query = $this->db->query("SELECT sa.staff_id, st.staff_fullname,date_format(sa.time_in,'%b') as month,count(date_format(sa.time_in,'%M')) as present, DAY(LAST_DAY(sa.time_in)) as monthdays FROM staff_attendance sa join staff st on st.id_staff = sa.staff_id where sa.time_in like '$year%' group by sa.staff_id,month,st.staff_fullname");
        return $query->result_array();
    }

    function discount($startdate, $enddate, $sh=false) {
      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);
        $sql = "
            SELECT invoice_type, customer_name, name as 'by', invoice.created_by, concat(discount_remarks, ' ', remarks) as 'discount_remarks', date_format(invoice_date, '%d-%m-%Y') as 'Date', invoice_number, invoice_id, name, service_type, service_category, service_name, discount_type,
            invoice_details.price, invoice_details.discounted_price, 
            CASE 
            WHEN invoice_details.discount = 0 THEN invoice_details.price - invoice_details.discounted_price
            ELSE invoice_details.discount
            END as discount
            FROM invoice_details
            join invoice on invoice_details.invoice_id = invoice.id_invoice
            join discount_invoice_users on discount_invoice_users.invoiceid = invoice.id_invoice 
            where discounted_price < price
            and service_flag = 'servicetype'
            and invoice_date between '" . $startdate." 00:00" . "' and '" . $enddate." 23:59" . "' and 
                invoice.business_id = '" . $this->session->userdata('businessid') . "' and 
                invoice_status = 'valid'
                
              
                
                ";
        
        $query = $this->db->query($sql);
       
        return $query->result_array();
    }

    function voucher($startdate, $enddate, $sh=false) {
      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);
        $this->db->select("c.customer_name,v.id_order_vouchers,v.voucher_number,v.type,v.service_names,v.amount,date_format(v.voucher_date,'%d-%m-%Y') as date,date_format(v.valid_until,'%Y-%m-%d') as valid_date,v.voucher_status, v.remaining_amount, v.payment_mode, v.paid_cash, v.paid_card, v.paid_check ");
        $this->db->join('customers c', 'c.id_customers = v.customer_id');
        $this->db->where('v.voucher_date >=', $startdate." 00:00");
        $this->db->where('v.voucher_date <=', $enddate." 23:59");
        $this->db->where('v.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('order_vouchers v');
        return $query->result_array();
    }

    function bad_debts($startdate, $enddate, $sh=false) {
      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);
        
//        $this->db->select("id_invoice, invoice_number,invoice_type, paid_amount, balance, customer_name as customer, date_format(invoice_date,'%D') as 'Day', date_format(invoice_date,'%M') as 'Month', date_format(invoice_date,'%d-%m-%Y') as 'Date', invoice_type as 'Sale Type', sub_total as 'Sub Total', gross_amount as 'Gross', discount as 'Discount', tax_total as 'Taxes', net_amount as 'Net Amount'");
//        $this->db->where('invoice_date >=', $startdate." 00:00");
//        $this->db->where('invoice_date <=', $enddate." 23:59");
//        $this->db->where('invoice_status', 'valid');
//        $this->db->where('balance >', 0);
//        $this->db->where('is_recovery', 'No');
//        $this->db->where('ifnull(reference_invoice_number,"")', '');
//        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));

        $sql="SELECT id_invoice, invoice_number, invoice_type, paid_amount, balance, 
            customer_name as customer, date_format(invoice_date, '%D') as 'Day', 
            date_format(invoice_date, '%M') as 'Month', date_format(invoice_date, '%d-%m-%Y') as 'Date', 
            invoice_type as 'Sale Type', sub_total as 'Sub Total', gross_amount as 'Gross', discount as 'Discount', 
            tax_total as 'Taxes', net_amount as 'Net Amount' 
            FROM invoice 
            WHERE invoice_date >= '".$startdate." 00:00' AND invoice_date <= '".$startdate." 23:59' 
            AND invoice_status = 'valid' 
            AND invoice_number not in (
                    select reference_invoice_number from invoice
                    where `invoice_date` >= '".$startdate." 00:00'
                    and invoice_status='valid'
            ) AND balance >0 AND is_recovery = 'No' 
            AND `invoice`.`business_id` = ".$this->session->userdata('businessid');
        
       // echo $sql;
        $query = $this->db->query($sql);
        
        //echo $query;
        return $query->result_array();
    }

    function stock_status($startdate, $enddate, $sh=false) {
      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);

        $this->db->select('*');
        $this->db->join('business_brands', 'business_brands.id_business_brands = business_products.brand_id');
        $this->db->where('business_product_active', 'Yes');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $product = $this->db->get('business_products');
        $product = $product->result_array();

        $last_array = array();
        foreach ($product as $key => $value) {
            $this->db->select('sum(grn_qty_received) as Purchased');
            $this->db->join('goods_received_note', 'goods_received_note.grn_id = grn_details.grn_id');
            $this->db->where('grn_product_id', $value['id_business_products']);
            $this->db->where('grn_created_date >=', $startdate." 00:00");
            $this->db->where('grn_created_date <=', $enddate." 23:59");
            $query = $this->db->get('grn_details');
            $query = $query->row();

            $this->db->select('sum(invoice_qty) as Sold');
            $this->db->join('invoice','invoice.id_invoice = invoice_products.invoice_id');
            $this->db->where('product_name', $value['product']);
            $this->db->where('invoice_product_date >=', $startdate." 00:00");
            $this->db->where('invoice_product_date <=', $enddate." 23:59");
            $this->db->where('invoice_status =', "valid");
            $query1 = $this->db->get('invoice_products');
            $query1 = $query1->row();

            $last_array[] = array(
                'ID' => $value['id_business_products'],
                'brand' => $value['business_brand_name'],
                'product' => $value['product'],
                'instock' => $value['in_stock'],
                'inhouse' => $value['inhouse_stock'],
                'purchased' => $query->Purchased,
                'soldQty' => $query1->Sold
            );
        }
        return $last_array;
    }

    function expenses($startdate, $enddate, $sh=false) {

//        $this->db->select("*, date_format(voucher_date, '%d-%m-%Y') as 'Date'");
//        $this->db->where('voucher_date >=', $startdate);
//        $this->db->where('voucher_date <=', $enddate);
//        $this->db->where('voucher_status', 'Active');
//        $this->db->where('business_id', $this->session->userdata('businessid'));
//        $query = $this->db->get('account_vouchers');
//        return $query->result();
        
        $this->db->select('*,sum(debit) as expenses, DATE_FORMAT(av.created_on, "%d-%m-%Y") "Date", DATE_FORMAT(av.voucher_date, "%d-%m-%Y") "VDate"');
        $this->db->join('account_voucher_detail avd','av.id_account_vouchers = account_voucher_id');
        $this->db->join('account_heads ah', 'ah.id_account_heads = avd.account_head_id');
        $this->db->join('account_sub_types as', 'as.id_account_sub_types = ah.account_sub_type');
        $this->db->join('account_type at', 'at.id_account_type = as.account_type_id');
        
        $this->db->where('av.business_id', $this->session->userdata('businessid'));
        $this->db->where('av.voucher_date >= ', $startdate);
        $this->db->where('av.voucher_date <= ', $enddate);
        $this->db->where('at.account_type', 'Expenses');
        
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('ah.account_head', 'Office Expense');
        }
        
        
        $this->db->where('av.voucher_type', 1);
        $this->db->where('av.voucher_status =', 'Active');
        $this->db->group_by('av.id_account_vouchers');
        $this->db->order_by('av.created_on', 'desc');
        $query = $this->db->get('account_vouchers av');
       
         return $query->result();
    }

    function get_dispatch_details($startdate, $enddate, $sh=false){
        
        $sql="SELECT staff_fullname, 
                date_format(dispatch_notes.dispatch_date, '%d-%m-%Y') as 'Date', id_business_products,
                concat(business_brands.business_brand_name, ' ',business_products.product, ' ',ifnull(business_products.category,'')) as Product, 
                dispatch_notes.dispatch_qty as Qty, ifnull(dispatch_notes.dispatch_measure,0) as dispatch_measure, 
                ifnull(dispatch_notes.measure_unit,0) measure_unit, ifnull(business_products.qty_per_unit,0) as qty_per_unit,
                ifnull(dispatch_notes.dispatch_comment,'') dispatch_comment,
                round(product_batch.batch_amount,2) batch_amount,
                dispatch_notes.created_by as Created_by, 
                dispatch_notes.unit_type as UnitType, id_dispatch_note, dispatch_notes.visit_id,
                ifnull(customers.customer_name,'') as 'customer_name'
        FROM dispatch_notes
        join staff on staff.id_staff = dispatch_notes.dispatch_to_staff
        join business_products on business_products.id_business_products = dispatch_notes.product_id
        join business_brands on business_brands.id_business_brands = business_products.brand_id
        join product_batch on product_batch.id_batch=dispatch_notes.batch_id
        left join customer_visits on customer_visits.id_customer_visits = dispatch_notes.visit_id
        left join customers on customers.id_customers = customer_visits.customer_id
        where dispatch_date >='". $startdate." 00:00' and dispatch_date <='". $enddate." 23:59' and dispatch_notes.status='Active' and dispatch_notes.business_id = ".$this->session->userdata('businessid')." 
        order by id_dispatch_note desc";
         $query = $this->db->query($sql);
       
        return $query->result_array();
        
    }
    
    function get_dispatch_report($startdate, $enddate, $sh=false) {
      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);
        $sql = "staff_fullname, count(dn.product_id) as ProductCount, 
                date_format(dn.dispatch_date, '%d-%m-%Y') as 'Date', id_business_products,
                concat(bb.business_brand_name, ' ',bp.product, ' ',ifnull(bp.category,'')) as Product, 
                sum(dn.dispatch_qty) as Qty, ifnull(sum(dn.dispatch_measure),0) as dispatch_measure, 
                ifnull(dn.measure_unit,0) measure_unit, ifnull(bp.qty_per_unit,0) as qty_per_unit, ifnull(dn.dispatch_comment,'') dispatch_comment,
                round(pb.batch_amount,2) batch_amount,
                dn.created_by as Created_by, 
                dn.unit_type as UnitType, id_dispatch_note";
        $this->db->select($sql, FALSE);
        $this->db->join('product_batch pb', 'pb.id_batch = dn.batch_id');
        $this->db->join('business_products bp', 'bp.id_business_products = dn.product_id');
        $this->db->join('business_brands bb', 'bb.id_business_brands = bp.brand_id');
        $this->db->join('staff', 'staff.id_staff = dn.dispatch_to_staff');
        $this->db->where('dn.dispatch_date >=', $startdate." 00:00");
        $this->db->where('dn.dispatch_date <=', $enddate." 23:59");
        $this->db->where('dn.status', 'Active');
        $this->db->where('dn.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('staff_fullname'); 
        $this->db->group_by('Date');
        $this->db->group_by('product');
        $this->db->order_by('date', 'DESC');
        $query = $this->db->get('dispatch_notes dn');
       
        return $query->result();
    }
    
    function customer_profile($startdate, $enddate, $sh=false){
     //   $date = strtotime("+ 1 days", strtotime($enddate));
     //   $enddate = date("Y-m-d", $date);
        $sql="SELECT customers.customer_name, customers.customer_cell, ifnull(customers.customer_card,'') card, customers.customer_email, customers.customer_address, 
                date_format(customer_birthday,'%d-%m-%Y') customer_birthday, 
                date_format(customer_anniversary,'%d-%m-%Y') customer_anniversary, 
                customer_alert, customer_allergies, ifnull(i,0) invoices, 
                ifnull(purchases,0) Purchases, ifnull(discount,0) Discounts, ifnull(balance,0) balance ,
                ifnull(earned,0) earned, ifnull(used,0) used,
                ifnull(customer_loyalty_points,0) loyalty_points
                FROM customers 
                left join (
                        select customer_id, count(id_invoice) i, sum(ifnull(balance,0)) balance, sum(ifnull(paid_amount,0)) purchases, 
                        sum(ifnull(discount,0)) discount, sum(ifnull(loyalty_earned,0)) earned, sum(ifnull(loyalty_used,0)) used,
                        sum(ifnull(loyalty_earned,0))  - sum(ifnull(loyalty_used,0)) customer_loyalty_points
                        from invoice 
                        where invoice.business_id=1
                        and invoice_status='valid' 
                        and invoice_date >= '".$startdate." 00:00' 
                        AND invoice_date <= '".$enddate." 23:59' 
                        group by customer_id 
                ) as bal on bal.customer_id=customers.id_customers 
                where customers.business_id=".$this->session->userdata('businessid');
        
        $query = $this->db->query($sql);
        return $query->result_array();
        
    }
    function new_customers($startdate, $enddate, $sh=false){
        //$date = strtotime("+ 1 days", strtotime($enddate));
       // $enddate = date("Y-m-d", $date);
        
        $this->db->select("*, date_format(customer_anniversary, '%d-%m-%Y %h:%i') as 'anv', date_format(created_on, '%d-%m-%Y %h:%i') as 'created', month(created_on) as 'm'");
        $this->db->where('created_on >=', $startdate." 00:00");
        $this->db->where('created_on <=', $enddate." 23:59");
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->order_by('month(created_on)','Desc');
        $query = $this->db->get('customers');
        return $query->result();
    }
    
    function returning_customers($startdate, $enddate, $sh=false){
        
        $this->db->select("*, date_format(customer_anniversary, '%d-%m-%Y %h:%i') as 'anv', date_format(created_on, '%d-%m-%Y %h:%i') as 'created', month(created_on) as 'm'");
        $this->db->join('invoice','invoice.customer_id=customers.id_customers');
        $this->db->join('business','business.id_business=customers.business_id');
        $this->db->where('created_on <=', $startdate." 00:00");
        $this->db->where('invoice_date >=', $startdate." 00:00");
        $this->db->where('invoice_date <=', $enddate." 23:59");
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->order_by('month(invoice_date)','Desc');
        $query = $this->db->get('customers');
        return $query->result();
    
    }
    
    function payment_breakup($startdate, $enddate, $invoicetype='all', $sh=false){
         $sql="SELECT date_format(invoice_date, '%Y-%m-%d') workdate, 
            sum(ifnull(paid_cash,0)) + ifnull(vcash,0) + ifnull(acash,0) + sum(
            case When payment_mode='Cash' then ifnull(retained_amount,0) 
        	else 0 End)  
            - sum(ifnull(cctip,0))   
            cash, 
          	sum(ifnull(paid_card,0)) + ifnull(vcard,0) + ifnull(acard,0) + sum(
                case When payment_mode='Card' then ifnull(retained_amount,0) 
            	else 0 End)    
            card, 
            sum(ifnull(paid_check,0)) + ifnull(vcheck,0) + ifnull(acheck,0) 'check' ,
            ifnull(acash,0) acash, ifnull(acard,0) acard, ifnull(acheck,0) acheck, ifnull(vcash,0) vcash, ifnull(vcard,0) vcard, ifnull(vcheck,0) vcheck,
            sum(ifnull(paid_cash,0)) - sum(ifnull(cctip,0))  as 'cash_only',
            sum(ifnull(paid_card,0))  as 'card_only',
            sum(ifnull(paid_check,0))  as 'check_only'
            FROM invoice
            left join (
                    select date_format(voucher_date, '%Y-%m-%d') vdate, sum(paid_cash) vcash, sum(paid_card) vcard, sum(paid_check) vcheck 
                    FROM order_vouchers
                    where business_id=".$this->session->userdata('businessid')."	
                    and voucher_date >='".$startdate." 00:00'
                    and voucher_date <='".$enddate." 23:59' 
                    GROUP BY date_format(date_format(voucher_date, '%Y-%m-%d'), '%Y-%m-%d') 
            ) as v on vdate = date_format(invoice.invoice_date, '%Y-%m-%d')
            left join (
                    select date_format(visit_advance.advance_date, '%Y-%m-%d') cashdate, sum(visit_advance.advance_amount) acash
                    FROM visit_advance join customer_visits on customer_visits.id_customer_visits = visit_advance.customer_visit_id
                    where business_id=".$this->session->userdata('businessid')." 
                    and visit_advance.advance_mode = 'cash'	
                    and customer_visits.visit_status!='canceled'
                    and visit_advance.advance_date >='".$startdate." 00:00'
                    and visit_advance.advance_date <='".$enddate." 23:59' 
                    GROUP BY date_format(visit_advance.advance_date, '%Y-%m-%d')     
            ) as acash on cashdate = date_format(invoice_date, '%Y-%m-%d')
            left join (
                    select date_format(visit_advance.advance_date, '%Y-%m-%d') carddate, sum(visit_advance.advance_amount) acard
                    FROM visit_advance join customer_visits on customer_visits.id_customer_visits = visit_advance.customer_visit_id
                    where business_id=".$this->session->userdata('businessid')." 
                    and visit_advance.advance_mode = 'card' 
                    and customer_visits.visit_status!='canceled'
                    and visit_advance.advance_date >='".$startdate." 00:00'
                    and visit_advance.advance_date <='".$enddate." 23:59' 
                    GROUP BY date_format(visit_advance.advance_date, '%Y-%m-%d')     
            ) as acard on carddate = date_format(invoice_date, '%Y-%m-%d')
            left join (
                    select date_format(visit_advance.advance_date, '%Y-%m-%d') checkdate, sum(visit_advance.advance_amount) acheck
                    FROM visit_advance join customer_visits on customer_visits.id_customer_visits = visit_advance.customer_visit_id
                    where business_id=".$this->session->userdata('businessid')."
                    and visit_advance.advance_mode = 'check'
                    and customer_visits.visit_status!='canceled'
                    and visit_advance.advance_date >='".$startdate." 00:00'
                    and visit_advance.advance_date <='".$enddate." 23:59' 
                    GROUP BY date_format(visit_advance.advance_date, '%Y-%m-%d') 
            ) as acheck on checkdate = date_format(invoice_date, '%Y-%m-%d')
            where business_id=".$this->session->userdata('businessid')."
            and invoice_date >='".$startdate." 00:00'
            and invoice_date <='".$enddate." 23:59'
            and invoice_status = 'valid' ";
            if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
                $sql.="and invoice_seq > 0 ";
            } 
        if($invoicetype =="service"){
            $sql.="and invoice_type='service' ";
        } else if($invoicetype=="sale"){
            $sql.="and invoice_type='sale' ";            
        }   

        $sql.="group by date_format(invoice_date, '%Y-%m-%d');";
        //echo $sql; exit();
            $query = $this->db->query($sql);
            return $query->result_array();
        
    }
    
    function cash_register($today, $tomorrow){
         
       
        $business_id = $this->session->userdata('businessid');
        
        $sub_query1 = ""
                . "SELECT ifnull(SUM(balance),0) FROM invoice "
                . "WHERE "
                . "invoice_date > '". $today ."' AND invoice_date < '".$tomorrow."' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        $sub_query2 = ""
                . "SELECT ifnull(SUM(paid_amount),0) FROM invoice "
                . "WHERE reference_invoice_number != '' AND "
                . "invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        $sub_query3 = ""
                . "SELECT ifnull(SUM(net_amount),0) FROM invoice "
                . "WHERE invoice_type = 'service' AND reference_invoice_number = '' AND "
                . "invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        $sub_query4 = ""
                . "SELECT ifnull(SUM(net_amount),0) FROM invoice "
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

        
        $sub_query6 = ""
                ."select sum(carda + cardb + cardc) as 'Card' from (
                    SELECT ifnull(SUM(paid_card),0) as 'carda' 
                    FROM invoice WHERE payment_mode in ('Card','Mixed') AND invoice_date > '".$today."'
                    AND invoice_date < '".$tomorrow."' AND business_id = ".$business_id." AND invoice_status = 'valid' 
                    ) a, (
                    select ifnull(sum(advance_amount),0) as 'cardb' From customer_visits 
                    WHERE visit_status <> 'canceled' AND advance_date >= '".$today."'
                    AND advance_date < '".$tomorrow."' And advance_mode='card'                    
                    AND business_id = ".$business_id.") b, (
                    SELECT ifnull(SUM(retained_amount),0) as 'cardc' 
                    FROM invoice WHERE payment_mode = 'Card' AND invoice_date > '".$today."'
                    AND invoice_date < '".$tomorrow."' AND business_id = ".$business_id." AND invoice_status = 'valid'     
                    ) c
                    ";
       
        
        $sub_query7 = ""
                . "SELECT ifnull(SUM(paid_amount),0) FROM invoice "
                . "WHERE payment_mode = 'Check' AND "
                . "invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        $sub_query8 = ""
                . "SELECT ifnull(SUM(paid_amount),0) FROM invoice "
                . "WHERE payment_mode = 'Loyalty' AND "
                . "invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        $sub_query9 = ""
                . "SELECT ifnull(SUM(net_amount),0) FROM invoice "
                . "WHERE reference_invoice_number = ''  AND "
                . "invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        $sub_query10 = ""
                . "SELECT ifnull(SUM(paid_amount),0) FROM invoice "
                . "WHERE payment_mode = 'Voucher' AND "
                . "invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        //advance        
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
                . "SELECT ifnull(SUM(cctip),0) FROM invoice "
                . "WHERE invoice_date > '$today' AND invoice_date < '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";       
        
        $mode=array();
        $mode[0]='Cash'; $mode[1]='Mixed';
        
        $this->db->select("SUM(paid_cash) AS totalCash, date_format('".$today."','%d-%m-%Y') as 'passeddate', "
                . "($sub_query1) AS totalBalance, "
                . "($sub_query2) AS totalRecovery, "
                . "($sub_query3) AS totalService, "
                . "($sub_query4) AS totalRetail, "
                . "($sub_query5) AS Cash, "
                . "($sub_query6) AS Card, "
                . "($sub_query7) AS Checks, "
                . "($sub_query9) AS totalSale, "
                . "($sub_query10) AS totalVoucher, " 
                . "($sub_query11) AS totalAdvance, "
                . "($sub_query12) AS totalRetained, "
                . "($sub_query13) AS cctip "
                . "");
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_date >', $today);
        $this->db->where('invoice_date <', $tomorrow);
        $this->db->where('invoice_status', 'valid');
        $this->db->where_in('payment_mode', $mode);
        
        $query = $this->db->get('invoice');
//        echo $query;
//        exit();
       
        return $query->row();
        
    }
    
    function get_cash_voucher($today, $tomorrow){
        

        $business_id = $this->session->userdata('businessid');
        
        $sub_query1 = ""
                . "SELECT SUM(amount) FROM order_vouchers "
                . "WHERE payment_mode = 'Cash'  AND "
                . "voucher_date > '$today' AND voucher_date < '$tomorrow' AND "
                . "business_id = $business_id";
        
        $sub_query2 = ""
                . "SELECT SUM(amount) FROM order_vouchers "
                . "WHERE payment_mode = 'Card' AND "
                . "voucher_date > '$today' AND voucher_date < '$tomorrow' AND "
                . "business_id = $business_id";
        
        $sub_query3 = ""
                . "SELECT SUM(amount) FROM order_vouchers "
                . "WHERE payment_mode = 'Check' AND "
                . "voucher_date > '$today' AND voucher_date < '$tomorrow' AND "
                . "business_id = $business_id";
        
        $this->db->select("SUM(amount) AS totalVoucherAmount, "
                . "($sub_query1) AS Cash, "
                . "($sub_query2) AS Card, "
                . "($sub_query3) AS Checks "
                . "");
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('voucher_date >', $today);
        $this->db->where('voucher_date <', $tomorrow);
        
        $query = $this->db->get('order_vouchers');
        return $query->row();
        
    }
    
    function get_today_expenses($today, $tomorrow){
        
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
        
        return $query->row();
    }
    
    function get_cash_register($today, $tomorrow){
                       
        $this->db->select('*, ifnull(sum((x5000 * 5000) + (x1000 * 1000) + (x500 * 500) + (x100 * 100) + (x50 * 50) + (x20 * 20) +(x10 * 10)+(x5 * 5)+(x1 * 1)),0) as "cash", difference as "diff" ', false);
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('cash_register_date =', $today);
        $query = $this->db->get('cash_register');
        return $query->row();
        
    }
    
    function get_yesterday_till_amount($today, $tomorrow){
        
        $yesterday="DATE_ADD('".$today."', INTERVAL -1 DAY)";
        
        $sql="SELECT ifnull(sum(till_amounts), 0) as 'till_amounts', 
        date_format('".$today."', '%d-%m-%Y') as 'passeddate' 
        FROM cash_register 
        WHERE business_id = ".$this->session->userdata('businessid')." 
        AND cash_register_date = DATE_ADD('".$today."', INTERVAL -1 DAY)";
       
        $query = $this->db->query($sql);
       
        return $query->row();
        
    }
    
    function gettomorrowfromserver($passeddate){
        $today = $passeddate; //->format('Y-m-d');
        
        $sql = "select DATE_ADD('".$today."', INTERVAL 1 DAY) as 'tomorrow'";
        $query = $this->db->query($sql);
        $result=$query->result();
        foreach ($result as $row){
            $tomorrow=$row->tomorrow;
        }
       
        return $tomorrow;
    }
    
    function cancelled_visits($startdate, $enddate, $sh=false) {

      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);
                
        $sql="select *, date_format(visit_service_start, \"%d-%m-%Y %H:%i:%s\") date from visit_services
        join customer_visits on visit_services.customer_visit_id = customer_visits.id_customer_visits 
        join customers on customers.id_customers = customer_visits.customer_id 
        join business_services bs on bs.id_business_services = visit_services.service_id
        join service_category sc on sc.id_service_category = bs.service_category_id
        where convert(visit_service_start, date) >=  '".$startdate." 00:00"."' AND convert(visit_service_start, date) <= '".$enddate." 23:59"."'      
        and visit_status = 'canceled' 
        and customer_visits.business_id=".$this->session->userdata('businessid');
        
        
        $sql="select staff_name, id_customer_visits, customer_name, customer_cell, date_format(customer_visit_date,'%d-%m-%Y') customer_visit_date, 
            date_format(visit_service_start,'%d-%m-%Y %H:%i:%s') visit_service_start, service_id, service_category,
             visit_services.service_name, service_rate, cancelreason, reminder_sms, reminder_call, reminder_email, service_desc, canceled_by
            from customer_visits 
            join customers on customers.id_customers = customer_visits.customer_id
            join visit_services on visit_services.customer_visit_id = customer_visits.id_customer_visits
            join visit_service_staffs on visit_service_staffs.visit_service_id = visit_services.id_visit_services 
            join business_services on business_services.id_business_services = visit_services.service_id
            join service_category on service_category.id_service_category = business_services.service_category_id
            where visit_status = 'canceled'
            and convert(visit_service_start, date) >=  '".$startdate." 00:00"."' AND convert(visit_service_start, date) <= '".$enddate." 23:59"."'
            and customer_visits.business_id = ".$this->session->userdata('businessid')."
            order by staff_name, id_customer_visits";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function open_visits($startdate, $enddate, $sh=false) {

      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);

//        $sql="select *, date_format(visit_service_start, \"%d-%m-%Y %H:%i:%s\") date from visit_services
//        join customer_visits on visit_services.customer_visit_id = customer_visits.id_customer_visits 
//        join customers on customers.id_customers = customer_visits.customer_id 
//        join business_services bs on bs.id_business_services = visit_services.service_id
//        join service_category sc on sc.id_service_category = bs.service_category_id
//        where convert(visit_service_start, date) >=  '".$startdate." 00:00"."' AND convert(visit_service_start, date) <= '".$enddate." 23:59"."'      
//        and visit_status = 'open' 
//        and customer_visits.business_id=".$this->session->userdata('businessid')." group by id_customer_visits";
        
        
        $sql= "select 
                id_customer_visits, date_format(customer_visit_date, '%d-%m-%Y') as date,
                customer_id , customer_name, customer_cell, date_format(visit_service_start, \"%d-%m-%Y %H:%i:%s\") visit_service_start,
                service_type, service_category, service_name, service_flag, reminder_sms, reminder_call, reminder_email, staff_name
                from customer_visits 
                join customers on customers.id_customers = customer_visits.customer_id
                join visit_services on visit_services.customer_visit_id = customer_visits.id_customer_visits
                join visit_service_staffs on visit_service_staffs.visit_service_id = visit_services.id_visit_services
                and convert(visit_service_start, date) >=  '".$startdate." 00:00"."' AND convert(visit_service_start, date) <= '".$enddate." 23:59"."'
                join service_category on service_category.id_service_category=visit_services.id_service_category
                join  service_type on service_type.id_service_types = service_category.service_type_id
                where visit_status='open' and service_flag='servicetype' 
                and customer_visits.business_id=".$this->session->userdata('businessid')." ";
            
        if(null!==$this->input->post('id_service_type') && $this->input->post('id_service_type')>0){
            $sql.=" and service_category.service_type_id = ".$this->input->post('id_service_type'); 
        }        
        if(null!==$this->input->post('id_service_category') && $this->input->post('id_service_category')>0){
            $sql.=" and service_category.id_service_category = ".$this->input->post('id_service_category'); 
        } 
        if(null!==$this->input->post('id_business_services') && $this->input->post('id_business_services')>0){
            $sql.=" and visit_services.service_id = ".$this->input->post('id_business_services'); 
        }
        if(null!==$this->input->post('staff_id') && $this->input->post('staff_id')>0){
            $sql.=" and visit_service_staffs.staff_id = ".$this->input->post('staff_id'); 
        }
        $sql.= " group by id_visit_services union
                select 
                id_customer_visits, date_format(customer_visit_date, '%d-%m-%Y') as date,
                customer_id , customer_name, customer_cell, date_format(visit_service_start, \"%d-%m-%Y %H:%i:%s\") visit_service_start,
                package_type.service_type collate utf8_general_ci as 'service_type', package_category.service_category collate utf8_general_ci as 'service_category', visit_services.service_name, service_flag,
                reminder_sms, reminder_call, reminder_email, staff_name
                from customer_visits 
                join customers on customers.id_customers = customer_visits.customer_id
                join visit_services on visit_services.customer_visit_id = customer_visits.id_customer_visits
                join visit_service_staffs on visit_service_staffs.visit_service_id = visit_services.id_visit_services
                and convert(visit_service_start, date) >=  '".$startdate." 00:00"."' AND convert(visit_service_start, date) <= '".$enddate." 23:59"."'
                join package_category on package_category.id_package_category = visit_services.id_service_category
                join package_type on package_type.id_package_type = package_category.package_type_id
                where visit_status='open' and service_flag='packagetype'
                and customer_visits.business_id=".$this->session->userdata('businessid')." ";
            
        if(null!==$this->input->post('id_service_type') && $this->input->post('id_service_type')>0){
            $sql.=" and package_category.package_type_id = ".$this->input->post('id_service_type'); 
        }        
        if(null!==$this->input->post('id_service_category') && $this->input->post('id_service_category')>0){
            $sql.=" and package_category.id_package_category = ".$this->input->post('id_service_category'); 
        }
        if(null!==$this->input->post('id_business_services') && $this->input->post('id_business_services')>0){
            $sql.=" and visit_services.service_id = ".$this->input->post('id_business_services'); 
        }
        if(null!==$this->input->post('staff_id') && $this->input->post('staff_id')>0){
            $sql.=" and visit_service_staffs.staff_id = ".$this->input->post('staff_id'); 
        }
        $sql.= " group by id_visit_services order by 6,2;";
                
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function advance_collected($startdate, $enddate, $sh=false) {

        //$date = strtotime("+ 1 days", strtotime($enddate));
        //$enddate = date("Y-m-d", $date);

//        $sql="select *, date_format(visit_service_start, \"%d-%m-%Y %H:%i:%s\") date from visit_services
//        join customer_visits on visit_services.customer_visit_id = customer_visits.id_customer_visits 
//        join customers on customers.id_customers = customer_visits.customer_id 
//        join business_services bs on bs.id_business_services = visit_services.service_id
//        join service_category sc on sc.id_service_category = bs.service_category_id
//        where convert(visit_service_start, date) >=  '".$startdate."' AND convert(visit_service_start, date) <= '".$enddate."'      
//        and visit_status = 'open' 
//        and customer_visits.business_id=".$this->session->userdata('businessid')." group by id_customer_visits";
//        
        
       $sql="SELECT id_visit_advance, service_flag, id_customer_visits, date_format(va.advance_date, '%d-%m-%Y %H:%i:%s') advance_date, customer_name, service_type, service_category, date_format(visit_service_start, '%d-%m-%Y %H:%i:%s') visitdate, va.advance_amount, va.advance_mode, va.advance_inst, customer_cell, visit_status 
        FROM visit_advance va
        join customer_visits cv on va.customer_visit_id = cv.id_customer_visits 
        join visit_services vs on vs.customer_visit_id = cv.id_customer_visits 
        join customers on customers.id_customers = cv.customer_id 
        join business_services bs on bs.id_business_services = vs.service_id 
        join package_services ps on ps.service_id = vs.service_id 
        join package_category pc on pc.id_package_category = ps.package_category_id and pc.id_package_category = vs.id_service_category
        join package_type pt on pt.id_package_type = pc.package_type_id 
        where va.advance_date >= '".$startdate.' 00:00'."' AND convert(va.advance_date, date) <= '".$enddate.' 23:59'."'    
        and visit_status <> 'canceled' and service_flag='packagetype' 
        and cv.business_id=".$this->session->userdata('businessid')." group by id_visit_advance 
       union
       SELECT id_visit_advance,service_flag, id_customer_visits, 
        date_format(va.advance_date, '%d-%m-%Y %H:%i:%s') advance_date, customer_name, 
        service_type, service_category, date_format(visit_service_start, '%d-%m-%Y %H:%i:%s') visitdate, 
        va.advance_amount, va.advance_mode, va.advance_inst, customer_cell, visit_status 
        FROM visit_advance va  
        join customer_visits cv on va.customer_visit_id = cv.id_customer_visits 
        join visit_services vs on vs.customer_visit_id = cv.id_customer_visits 
        join customers on customers.id_customers = cv.customer_id 
        join business_services bs on bs.id_business_services = vs.service_id 
        join service_category sc on sc.id_service_category = bs.service_category_id 
        join service_type st on st.id_service_types = sc.service_type_id 
        where va.advance_date >= '".$startdate.' 00:00'."' AND convert(va.advance_date, date) <= '".$enddate.' 23:59'."'    
        and visit_status <> 'canceled'
        and service_flag='servicetype' 
        and cv.business_id=".$this->session->userdata('businessid')." group by id_visit_advance
        ";       
      
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function staff_retail_sale_summary($startdate, $enddate, $sh=false){
        

        
        $sql="SELECT staff.id_staff, staff.staff_fullname staff_name, 
            staff.staff_image, 
            sum(invoice_qty) as 'Quantity', 
            count(invoice_products.product_name) 'Products',
            format(sum(paid), 2) as 'Amount', 
            ifnull(a.Recovery,0) 'Recovery', 
            format(ifnull(sum(paid) + ifnull(a.total,0),0),2) as 'Total',
            ifnull(sum(paid) + ifnull(a.total,0),0),
            sum(ifnull(paid,0))*0.01 'Commission' 
            FROM invoice_products 
            JOIN invoice ON invoice.id_invoice = invoice_products.invoice_id 
            JOIN staff ON staff.staff_fullname = invoice_products.staff_name
            left join (
                    SELECT staff.id_staff, staff_name, format(sum(ifnull(paid,0)), 2) as 'Recovery', sum(ifnull(paid,0)) as 'total',
                    sum(invoice_qty) as 'rec_count'
                    FROM invoice_products
                    JOIN invoice ON invoice.id_invoice = invoice_products.invoice_id 
                    JOIN staff ON staff.staff_fullname = invoice_products.staff_name
                    WHERE invoice_date >= '".$startdate." 00:00' AND invoice_date <= '".$enddate." 23:59' 
                    AND ifnull(reference_invoice_number,'') != '' 
                    AND invoice_type = 'sale' 
                    AND invoice_status = 'valid' ";
                    if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
                        $sql.=" and invoice_seq > 0 ";
                    }
                    $sql.=" AND invoice.business_id= ".$this->session->userdata('businessid')."
                    AND staff.business_id= ".$this->session->userdata('businessid')."
                    GROUP BY id_staff, staff_name, staff_image
            ) as a on a.staff_name = staff.staff_fullname
            WHERE invoice_date >= '".$startdate.' 00:00'."' AND invoice_date <= '".$enddate.' 23:59'."' 
            AND ifnull(reference_invoice_number,'') = '' 
            AND invoice_type = 'sale' 
            AND invoice_status = 'valid' ";
        
            if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
                $sql.=" and invoice_seq > 0 ";
            }        

            $sql.=" AND invoice.business_id= ".$this->session->userdata('businessid')."
            AND staff.business_id= ".$this->session->userdata('businessid')."
            GROUP BY staff.id_staff, staff.staff_fullname, staff.staff_image
            ORDER BY 6 desc";
        
        $query = $this->db->query($sql);
        return $query->result_array();
        
    }

    function receivables($startdate, $enddate, $sh=false){
        
        $sql="select customer_visits.id_customer_visits, customers.customer_name, 'service' customer_cell, date_format(visit_services.visit_service_start, '%d-%m-%Y') mDate, 
            sum(business_services.service_rate) price, a.advance,
            sum(business_services.service_rate) - a.advance as receivables
            from customer_visits 
            join visit_services on visit_services.customer_visit_id = customer_visits.id_customer_visits
            join customers on customers.id_customers=customer_visits.customer_id
            join business_services on business_services.id_business_services = visit_services.service_id
            join (
                select visit_advance.customer_visit_id, sum(ifnull(advance_amount,0)) advance from visit_advance 
                group by customer_visit_id
            ) a on a.customer_visit_id = customer_visits.id_customer_visits
            where customer_visits.visit_status='open' and customer_visits.business_id= ".$this->session->userdata('businessid')."
			and visit_services.service_flag='servicetype'
            and convert(visit_services.visit_service_start, date) >= '".$startdate.' 00:00'."'
            and convert(visit_services.visit_service_start, date) <= '".$enddate.' 23:59'."'
            group by customer_visits.id_customer_visits

            union
            select customer_visits.id_customer_visits, customers.customer_name, 'package' customer_cell, date_format(visit_services.visit_service_start, '%d-%m-%Y') mDate, 
            sum(business_services.service_rate) price, a.advance,
            sum(business_services.service_rate) - a.advance as receivables
            from customer_visits 
            join visit_services on visit_services.customer_visit_id = customer_visits.id_customer_visits
            join customers on customers.id_customers=customer_visits.customer_id
            join package_services as business_services on business_services.service_id = visit_services.service_id and business_services.package_category_id =visit_services.id_service_category
            join (
                select visit_advance.customer_visit_id, sum(ifnull(advance_amount,0)) advance from visit_advance 
                group by customer_visit_id
            ) a on a.customer_visit_id = customer_visits.id_customer_visits
            where customer_visits.visit_status='open' and customer_visits.business_id= ".$this->session->userdata('businessid')."
			and visit_services.service_flag='packagetype'
            and convert(visit_services.visit_service_start, date) >= '".$startdate.' 00:00'."'
            and convert(visit_services.visit_service_start, date) <= '".$enddate.' 23:59'."'
            group by customer_visits.id_customer_visits";
      
        $query = $this->db->query($sql);
        return $query->result_array();
        
    }

    function recoveryinvoices($startdate, $enddate, $sh=false){
        
        
        $this->db->select('*,DATE_FORMAT(invoice_date, "%d-%m-%Y") as invoice_date, DATE_FORMAT(visit_time, "%d-%m-%Y %h:%i") as visit_time, DATE_FORMAT(visit_time, "%Y-%m-%d") as sked_date');
        $this->db->join('business','business.id_business = invoice.business_id');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice.balance >', 0);
        $this->db->where('invoice.is_recovery', 'Yes');
        $this->db->where('invoice.invoice_status=', 'valid');
      //  $this->db->where('invoice_date >= ', $startdate.' 00:00');
      //  $this->db->where('invoice_date <= ', $enddate.' 23:59'); 
        $query = $this->db->get('invoice');
        
        return $query->result_array();
    }
    
    function loyaltyredemption($startdate, $enddate, $business_id=null){
        
        
        $this->db->select('*, loyalty_used, DATE_FORMAT(invoice_date, "%d-%m-%Y") as invoice_date, DATE_FORMAT(visit_time, "%d-%m-%Y %h:%i") as visit_time, DATE_FORMAT(visit_time, "%Y-%m-%d") as sked_date');
        $this->db->join('business','business.id_business = invoice.business_id');
        //$this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice.loyalty_used >', 0);
        $this->db->where('invoice.invoice_status=', 'valid');
        
        if($business_id !== null and $business_id >0){
            $this->db->where('id_business = ', $business_id);
        }
        
        $this->db->where('invoice_date >= ', $startdate.' 00:00');
        $this->db->where('invoice_date <= ', $enddate.' 23:59'); 
        $query = $this->db->get('invoice');
        
        return $query->result_array();
    }
    
    function sharedcustomers($startdate, $enddate, $business_id=null){
        
        
        $this->db->select('*, loyalty_used, DATE_FORMAT(invoice_date, "%d-%m-%Y") as invoice_date, DATE_FORMAT(visit_time, "%d-%m-%Y %h:%i") as visit_time, DATE_FORMAT(visit_time, "%Y-%m-%d") as sked_date');
        $this->db->join('customers','customers.id_customers = invoice.customer_id');
        $this->db->join('business','business.id_business = customers.business_id', 'left');
        
        
        $this->db->where('invoice.invoice_status=', 'valid');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('customers.business_id !=', $this->session->userdata('businessid'));
        if($business_id != null && $business_id>0){
            $this->db->where('customers.business_id =',$business_id); 
        }
        $this->db->where('invoice_date >= ', $startdate.' 00:00');
        $this->db->where('invoice_date <= ', $enddate.' 23:59'); 
        $query = $this->db->get('invoice');
        //echo $query; exit();
        return $query->result_array();
    }
    
    
    
    function careofcustomers($startdate, $enddate, $business_id=null){
        
        
        $this->db->select("*, date_format(customer_anniversary, '%d-%m-%Y %h:%i') as 'anv', date_format(created_on, '%d-%m-%Y %h:%i') as 'created', month(created_on) as 'm'");
        //$this->db->where('created_on >=', $startdate." 00:00");
        //$this->db->where('created_on <=', $enddate." 23:59");
        $this->db->where('ifnull(customer_careof,"") !=','');
        //$this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->order_by('month(created_on)','Desc');
        $query = $this->db->get('customers');
        return $query->result();
    }
    
    
    function requested($startdate, $enddate, $business_id=null, $sh=false){
        
        $this->db->select('*,DATE_FORMAT(invoice_date, "%d-%m-%Y") as invoice_date');
        $this->db->join('invoice_staff', 'invoice_staff.invoice_id = invoice.id_invoice');
        $this->db->join('discount_invoice_users', 'discount_invoice_users.invoiceid = invoice.id_invoice', 'left');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_date >=', $startdate." 00:00");
        $this->db->where('invoice_date <=', $enddate." 23:59");
        $this->db->where('invoice.invoice_status=', 'valid');
        
         if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('invoice_seq > ', 0);
        }
        $this->db->where('invoice_staff.requested=', 'Yes');
        
        $query = $this->db->get('invoice');
        return $query->result_array();
    }
    function repeated_customers($startdate, $enddate, $sh=false){
        
        /*Repeated Customers needs more work*/
        $sql="SELECT *, date_format(invoice_date,'%d-%m-%Y %H:%i:%s') invoice_date, date_format(visit_time,'%d-%m-%Y %H:%i:%s') visit_date,'Clients of January 2019' as 'Month' 
                FROM invoice
                where invoice_date >= '".$startdate." 00:00:00' and invoice_date <='".$enddate." 23:59:59'
                and business_id=".$this->session->userdata('businessid')."  
                and customer_id in 
                (
                        select customer_id from invoice 
                        where invoice_date > '".$startdate." 00:00:00'
                        and business_id=1 
                )
                order by customer_id, invoice_date;";
        
        $query = $this->db->query($sql);
        return $query->result_array();
        
    }
    
    
    function non_returning_customers($startdate, $enddate, $days, $servicecategory){
        $sql="select distinct customers.customer_name, customers.customer_cell,
            invoice.invoice_date as date, invoice_details.service_name, invoice_details.staff 
            FROM invoice join customers on customers.id_customers = invoice.customer_id 
            join business on business.id_business = invoice.business_id 
            join invoice_details on invoice_details.invoice_id = invoice.id_invoice 
            where DATEDIFF(now(), visit_time) <= ". $days ." and upper(service_category) = '".$servicecategory."' 
            and invoice.invoice_status = 'valid' 
            and invoice.business_id=".$this->session->userdata('businessid')."  
            and customers.id_customers not in (
                select id_customers 
                FROM invoice join customers on customers.id_customers = invoice.customer_id 
                join invoice_details on invoice_details.invoice_id = invoice.id_invoice 
                where DATEDIFF(now(), visit_time) > ". $days ." and upper(service_category) = '".$servicecategory."' 
                and invoice.invoice_status = 'valid' and invoice.business_id=".$this->session->userdata('businessid').")
            order by 1, 2";
        
        $query = $this->db->query($sql);
        return $query->result_array();
        
    }
}
