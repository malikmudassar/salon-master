<?php

class Retaildashboard_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }
    
    function get_business_sales($year){        
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('year', $year);
        $query = $this->db->get('business_retail_sales');
        return $query->result();
    }
    
    function get_business_sale_year_month($month, $year){
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('month', $month);
        $this->db->where('year', $year);
        $query = $this->db->get('business_retail_sales');
                
        return $query->row();
    }
    
    function get_business_sale_years(){
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->group_by('year');
        $query = $this->db->get('business_retail_sales');
        return $query->result();
    }
    
    function get_this_month_year_sale($start, $end) {
        
        $this->db->select('SUM(paid_amount) as total_sale');
        $this->db->where('year(invoice_date) = date_format(\''.$start.'\',\'%Y\')');
        $this->db->where('month(invoice_date) = date_format(\''.$start.'\',\'%m\')');
        //$this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('invoice_type', 'sale');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        //$this->db->group_by('invoice_date');
        $query = $this->db->get('invoice');
        
        return $query->row();
    }
    
    function add_this_month_year_sale($data){
        $this->db->insert('business_retail_sales', $data);
        return $this->db->insert_id();
    }
    
    function update_this_month_year_sale($data, $id){
        $this->db->where('id_retail_sales', $id);
        $this->db->update('business_retail_sales', $data);
        return $this->db->affected_rows();
        
    }

    function get_todaysale() {
        $today = date('Y-m-d');
        $yesterday= date('Y-m-d', strtotime('yesterday'));
        $tommorrow= date('Y-m-d', strtotime('tommorrow'));
        
        $this->db->select('Date_Format(invoice_date, "%Y-%m-%d") "saleon",  sum(paid_amount) as "Total"');
        $this->db->where('invoice_date >=', $today);
        //$this->db->where('invoice_date <', $tommorrow);
       // $this->db->where("reference_invoice_number <>","bad debts");
        //$this->db->where("reference_invoice_number <>","");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('invoice_type', 'sale');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('Date_Format(invoice_date, "%Y-%m-%d")');
        $this->db->order_by('Date_Format(invoice_date, "%Y-%m-%d")');
        $query = $this->db->get('invoice');
       
        return $query->result_array();
    }
    
    function get_today_card(){
        $today = date('Y-m-d');
        
        $mode=array();
        $mode[0]='Card';$mode[1]='Mixed';
        
        $this->db->select('Date_Format(invoice_date, "%Y-%m-%d") "saleon",  sum(paid_card) as "Total"');
        $this->db->where('invoice_date >=', $today);
        //$this->db->where("reference_invoice_number <>","bad debts");
        //$this->db->where("reference_invoice_number <>","");
        $this->db->where('invoice_status', 'valid');
        $this->db->where_in('payment_mode', $mode);
        $this->db->where('invoice_type', 'sale');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by("date_format(invoice_date,'%Y-%m-%d')");
        $query = $this->db->get('invoice');
        
        return $query->result_array();
    }
    
    function get_today_cash(){
        $today = date('Y-m-d');
        $mode[0]='Cash';$mode[1]='Mixed';
        
        $this->db->select('Date_Format(invoice_date, "%Y-%m-%d") "saleon",  sum(paid_cash) as "Total"');
        $this->db->where('invoice_date >=', $today);
        //$this->db->where("reference_invoice_number <>","bad debts");
        //$this->db->where("reference_invoice_number <>","");
        $this->db->where('invoice_status', 'valid');
        $this->db->where_in('payment_mode', $mode);
        $this->db->where('invoice_type', 'sale');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by("date_format(invoice_date,'%Y-%m-%d')");
        $query = $this->db->get('invoice');
        
        return $query->result_array();
    }
    
    function get_today_voucher(){
        $today = date('Y-m-d');
        
        $this->db->select('Date_Format(invoice_date, "%Y-%m-%d") "saleon",  sum(paid_voucher) as "Total"');
        $this->db->where('invoice_date >=', $today);
        //$this->db->where("reference_invoice_number <>","bad debts");
        //$this->db->where("reference_invoice_number <>","");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('payment_mode', 'Voucher');
        $this->db->where('invoice_type', 'sale');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by("date_format(invoice_date,'%Y-%m-%d')");
        $query = $this->db->get('invoice');
        
        return $query->result_array();
    }
    
    function get_today_bank(){
        $today = date('Y-m-d');
        
        $this->db->select('Date_Format(invoice_date, "%Y-%m-%d") "saleon",  sum(paid_check) as "Total"');
        $this->db->where('invoice_date >=', $today);
        //$this->db->where("reference_invoice_number <>","bad debts");
        //$this->db->where("reference_invoice_number <>","");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('payment_mode', 'Check');
        $this->db->where('invoice_type', 'sale');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by("date_format(invoice_date,'%Y-%m-%d')");
        $query = $this->db->get('invoice');
        
        return $query->result_array();
    }
    
    
    
    function get_yesterdaysale() {
        $today = date('Y-m-d');
        $yesterday= date('Y-m-d', strtotime('yesterday'));
        $tommorrow= date('Y-m-d', strtotime('tommorrow'));
        
        $this->db->select('Date_Format(invoice_date, "%Y-%m-%d") "saleon",  sum(paid_amount) as "Total"');
        $this->db->where('invoice_date >=', $yesterday);
        $this->db->where('invoice_date <=', $today);
        //$this->db->where("reference_invoice_number <>","");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('invoice_type', 'sale');
        //$this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('Date_Format(invoice_date, "%Y-%m-%d")');
        $this->db->order_by('Date_Format(invoice_date, "%Y-%m-%d")');
        $query = $this->db->get('invoice');
       
        return $query->result_array();
    }
    
    function get_month($month, $year){
        $today = date('Y-m-d');
        
//        $this->db->select("date_format(invoice_date,'%M') as 'Month', sum(paid_amount) as 'Total' ");
//        $this->db->where('month(invoice_date) =', $month);
//        $this->db->where('year(invoice_date) =', $year);
//       // $this->db->where("reference_invoice_number <>","bad debts");
//        
//        $this->db->where('invoice_status', 'valid');
//        $this->db->where('invoice_type', 'sale');
//        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
//        $this->db->group_by("date_format(invoice_date,'%M')");
//        
//        $query = $this->db->get('invoice');
        
        
        
                $sql="SELECT date_format(invoice_date, '%M') as 'Month', 
                sum(paid_amount) as 'Total', 
                sum(paid_amount) paid, 
                sum(cctip) cctip,
                sum(paid_cash) cash, sum(paid_card) card, sum(paid_check) bank,
                sum(paid_cash) + sum(paid_card) + sum(paid_check) paymentmode   
                from invoice
                WHERE month(invoice_date)  = '".$month."' 
                AND year(invoice_date) = '".$year."' 
                AND invoice_status = 'valid' 
                And invoice_type='sale' 
                AND invoice.business_id =  '".$this->session->userdata('businessid')."' 
                GROUP BY month(invoice_date)";
        
                
        $query =$this->db->query($sql);
        
        return $query->result_array();
    }
    
    function get_month_card($month, $year){
        $today = date('Y-m-d');
        $mode=array();
        $mode[0]='Card';$mode[1]='Mixed';
        $this->db->select("date_format(invoice_date,'%M') as 'Month', sum(paid_card) as 'Total' ");
        $this->db->where('month(invoice_date) =', $month);
        $this->db->where('year(invoice_date) =', $year);
        //$this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_status', 'valid');
        $this->db->where_in('payment_mode', $mode);
        $this->db->where('invoice_type', 'sale');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by("date_format(invoice_date,'%M')");
        $query = $this->db->get('invoice');
        
        return $query->result_array();
    }
    
    function get_month_cash($month, $year){
        $today = date('Y-m-d');
        $mode=array();
        $mode[0]='Cash';$mode[1]='Mixed';
        $this->db->select("date_format(invoice_date,'%M') as 'Month', sum(paid_cash) as 'Total' ");
        $this->db->where('month(invoice_date) =', $month);
        $this->db->where('year(invoice_date) =', $year);
        //$this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_status', 'valid');
        $this->db->where_in('payment_mode', $mode);
        $this->db->where('invoice_type', 'sale');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by("date_format(invoice_date,'%M')");
        $query = $this->db->get('invoice');
        
        return $query->result_array();
    }
    
    function get_month_voucher($month, $year){
        $today = date('Y-m-d');
        
        $this->db->select("date_format(invoice_date,'%M') as 'Month', sum(paid_voucher) as 'Total' ");
        $this->db->where('month(invoice_date) =', $month);
        $this->db->where('year(invoice_date) =', $year);
        //$this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('payment_mode', 'Voucher');
        $this->db->where('invoice_type', 'sale');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by("date_format(invoice_date,'%M')");
        $query = $this->db->get('invoice');
        
        return $query->result_array();
    }
    
    function get_month_bank($month, $year){
        $today = date('Y-m-d');
        
        $this->db->select("date_format(invoice_date,'%M') as 'Month', sum(paid_check) as 'Total' ");
        $this->db->where('month(invoice_date) =', $month);
        $this->db->where('year(invoice_date) =', $year);
        //$this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('payment_mode', 'Bank');
        $this->db->where('invoice_type', 'sale');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by("date_format(invoice_date,'%M')");
        $query = $this->db->get('invoice');
        
        return $query->result_array();
    }
    
    function get_year($month, $year){
        $today = date('Y-m-d');
        
       $sql="SELECT year(invoice_date) as 'Year', sum(paid_amount) as 'Total' ,
                sum(paid_amount)
                FROM invoice                 
                WHERE year(invoice_date) = year('".$today."') 
                AND invoice_status = 'valid' 
                AND payment_mode != 'Voucher'
                and invoice_type = 'sale'
                AND invoice.business_id = '".$this->session->userdata('businessid')."' 
                GROUP BY year(invoice_date)";
        $query =$this->db->query($sql);
        return $query->result_array();
         
         
         
    }
    
    function get_monthly($month, $year){
        $today = date('Y-m-d');
        
        $this->db->select("date_format(invoice_date, '%M') as 'Month', sum(paid_amount) as 'Total' ");
        $this->db->where('year(invoice_date) =', $year);
        //$this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('invoice_type', 'sale');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by("date_format(invoice_date,'%M')");
        $this->db->order_by("date_format(invoice_date,'%M')");
        $query = $this->db->get('invoice');
        
         return $query->result_array();
    }
    
    function get_daily($month, $year){
        $today = date('Y-m-d');
        $this->db->select("date_format(invoice_date, '%d') as 'Day', sum(paid_amount) as 'Total' ");
        $this->db->where('year(invoice_date) =', $year);
        $this->db->where('month(invoice_date) = ', $month);
        //$this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('invoice_type', 'sale');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by("date_format(invoice_date,'%d')");
        $this->db->order_by("date_format(invoice_date,'%d')");
        $query = $this->db->get('invoice');
        
         return $query->result_array();
    }
    
    function get_month_commission($month, $year){
         $today = date('Y-m-d');
         
        $this->db->select("idpurchase_order, sum(grn_unit_price)*grn_qty_instock as 'purchases'");
        $this->db->join("goods_received_note grn", "grn.purchase_order_id = po.idpurchase_order");
        $this->db->join("grn_details grnd", "grn.grn_id = grnd.grn_id");
        $this->db->where('po.business_id', $this->session->userdata('businessid'));
        $this->db->where('year(grn_created_date) = ', $year);
        $this->db->where('month(grn_created_date) =', $month);
        $this->db->group_by("idpurchase_order");
        $query = $this->db->get('purchase_order po');
        
        return $query->result_array();
        
    }
    function top_4_clients($month, $year){
        $today = date($month.'-01-'.$year);
        $months=[];
        $years=[];
        $dp=new DatePeriod(date_create($today),DateInterval::createFromDateString('last month'),2);
        foreach($dp as $dt) {
            array_push($months, $dt->format("m"));
            array_push($years, $dt->format("Y"));
            
        }
        
        $this->db->select("customer_name, customer_cell, customer_email, CONCAT('Rs. ', FORMAT(sum(paid_amount), 2)) as 'Total', customer_id", True);
        $this->db->where("invoice_status='valid'");
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where_in('month(invoice_date)',$month);
        //$this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_type', 'sale');
        $this->db->where('invoice_status', 'valid');
        $this->db->where_in('year(invoice_date)', $year);
        $this->db->group_by("customer_name, customer_cell, customer_email");
        $this->db->order_by("sum(paid_amount) desc");
        $this->db->limit(20); 
        $query = $this->db->get('invoice');
      
        return $query->result_array();

    }
    
    function top_4_staff($month, $year){
        
//        $today = date('Y-m-d');
//        $month=date('m', strtotime($today));
//        $year=date('Y', strtotime($today));
        
        
        //select invoice_products.staff_name, count(invoice_products.product_name) 'Products', sum(ifnull(paid,0)) 'Total', round(sum(ifnull(paid,0))*0.05) 'Commission' from invoice join invoice_products on invoice_products.invoice_id = invoice.id_invoice join staff on staff.staff_fullname = invoice_products.staff_name where invoice.invoice_type = 'sale' and month(invoice_date)= '4' and year(invoice_date)= '2017' and ifnull(staff_name,'')!='' and invoice.invoice_status='valid' and ifnull(reference_invoice_number,'') = '' group by invoice_products.staff_name order by invoice_products.staff_name
        
        //select staff_services.staff_name, count(staff_services.product_name) 'Products', sum(ifnull(paid,0)) 'Total', round(sum(ifnull(paid,0))*0.05) 'Commission' from invoice join staff_services on staff_services.invoice_id = invoice.id_invoice left join staff on staff.id_staff = staff_services.staff_id where invoice.invoice_type = 'sale' and month(invoice_date)= '4' and year(invoice_date)= '2017' and ifnull(staff_name,'')!='' and invoice.invoice_status='valid' and reference_invoice_number <>'bad debts' group by staff_services.staff_name order by staff_services.staff_name
        
        
//        $select = "invoice_products.staff_name Staff, staff_image, sum(invoice_qty) as 'qty', format(sum(paid),2)  as 'Amount', sum(paid)";
//        
//        $this->db->select($select);
//        $this->db->join("invoice", "invoice.id_invoice = invoice_products.invoice_id");
//        $this->db->join("staff", "staff.staff_fullname = invoice_products.staff_name");
//        $this->db->where('month(invoice_date)',$month);
//        $this->db->where('year(invoice_date)', $year);
//      //  $this->db->not_like("invoice_products.staff_name", "|");
//        $this->db->where("ifnull(reference_invoice_number,'') = ''");
//      //  $this->db->where("reference_invoice_number <>","bad debts");
//        $this->db->where('invoice_type', 'sale');
//        $this->db->where('invoice_status', 'valid');
//        $this->db->group_by("staff_name, staff_image");
//        $this->db->order_by("5 desc");
//        $query = $this->db->get('invoice_products');
//        
//         return $query->result_array();
         
         
                 
        $sql="SELECT staff.staff_fullname Staff, 
            staff.staff_image, 
            sum(invoice_qty) as 'qty', 
            format(sum(paid), 2) as 'Amount', 
            ifnull(a.Recovery,0) 'Recovery', 
            format(ifnull(sum(paid) + ifnull(a.total,0),0),2) as 'Total',
            ifnull(sum(paid) + ifnull(a.total,0),0)
            FROM invoice_products 
            JOIN invoice ON invoice.id_invoice = invoice_products.invoice_id 
            JOIN staff ON staff.staff_fullname = invoice_products.staff_name
            left join (
                    SELECT staff_name, format(sum(ifnull(paid,0)), 2) as 'Recovery', sum(ifnull(paid,0)) as 'total',
                    sum(invoice_qty) as 'rec_count'
                    FROM invoice_products
                    JOIN invoice ON invoice.id_invoice = invoice_products.invoice_id 
                    JOIN staff ON staff.staff_fullname = invoice_products.staff_name
                    WHERE month(invoice_date) = '".$month."' AND year(invoice_date) = '".$year."' 
                    AND ifnull(reference_invoice_number,'') != '' 
                    AND invoice_type = 'sale' 
                    AND invoice_status = 'valid' 
                    AND invoice.business_id= ".$this->session->userdata('businessid')."
                    GROUP BY id_staff, staff_name, staff_image
            ) as a on a.staff_name = staff.staff_fullname
            WHERE month(invoice_date) = '".$month."' AND year(invoice_date) = '".$year."' 
            AND ifnull(reference_invoice_number,'') = '' 
            AND invoice_type = 'sale' 
            AND invoice_status = 'valid' 
            AND invoice.business_id= ".$this->session->userdata('businessid')."
            GROUP BY staff.staff_fullname, staff.staff_image
            ORDER BY 6 desc";
        
            //echo $sql;
        $query = $this->db->query($sql);
        
        return $query->result_array();
    }
    
   
     
    function grossing_services($month, $year){
        
        
        $sql="select invoice_products.product_name as 'name', sum(paid)/T.total*100 as 'y' , sum(paid) as 'paid'
                from invoice_products
                join invoice on invoice.id_invoice = invoice_products.invoice_id 
                and invoice.invoice_status = 'valid'
                and invoice.business_id=".$this->session->userdata('businessid')."
                and  month(invoice_product_date) = '".$month."'
                and  year(invoice_product_date) = '".$year."',
                (
                    select sum(subtotal) as 'total' 
                    from 
                        (
                        SELECT product_name, sum(paid) as subtotal 
                        FROM invoice_products
                        join invoice on invoice.id_invoice = invoice_products.invoice_id 
                        and invoice.invoice_status = 'valid'
                        and invoice.business_id=".$this->session->userdata('businessid')."
                        and  month(invoice_product_date) = '".$month."'
                        and  year(invoice_product_date) = '".$year."'
                        group by product_name
                        order by 2 desc
                        limit 10
                        ) as M
                    ) as T
                group by product_name
                order by 2 desc
                limit 10
                ";
       
        $query = $this->db->query($sql);        
        
        return $query->result_array();
        
    }
    
}
