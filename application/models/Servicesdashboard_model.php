<?php

class Servicesdashboard_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }
    
    function get_business_sales($year){        
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('year', $year);
        $query = $this->db->get('business_services_sales');
        return $query->result();
    }
    
    function get_business_sale_year_month($month, $year){
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('month', $month);
        $this->db->where('year', $year);
        $query = $this->db->get('business_services_sales');
                
        return $query->row();
    }
    
   
    
    function get_business_sale_years(){
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->group_by('year');
        $query = $this->db->get('business_services_sales');
        return $query->result();
    }
    
    function get_this_month_year_sale($start, $end) {
        
        $this->db->select('SUM(paid_amount) as total_sale');
        $this->db->where('year(invoice_date) = date_format(\''.$start.'\',\'%Y\')');
        $this->db->where('month(invoice_date) = date_format(\''.$start.'\',\'%m\')');
       // $this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('invoice_type', 'service');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        //$this->db->group_by('invoice_date');
        $query = $this->db->get('invoice');
        
        return $query->row();
    }
    
    function add_this_month_year_sale($data){
        $this->db->insert('business_services_sales', $data);
        return $this->db->insert_id();
    }

    function update_this_month_year_sale($data, $id){
        $this->db->where('id_services_sales', $id);
        $this->db->update('business_services_sales', $data);
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
        $this->db->where('invoice_status', 'valid');
        $this->db->where('invoice_type', 'service');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('Date_Format(invoice_date, "%Y-%m-%d")');
        $this->db->order_by('Date_Format(invoice_date, "%Y-%m-%d")');
        $query = $this->db->get('invoice');
       
        return $query->result_array();
    }
    
    function get_todaysale_cash() {
        $today = date('Y-m-d');
        $yesterday= date('Y-m-d', strtotime('yesterday'));
        $tommorrow= date('Y-m-d', strtotime('tommorrow'));
        $mode=array();
        $mode[0]='Cash';$mode[1]='Mixed';
        
        $this->db->select('Date_Format(invoice_date, "%Y-%m-%d") "saleon",  sum(paid_cash) as "Total"');
        $this->db->where('invoice_date >=', $today);
        //$this->db->where('invoice_date <', $tommorrow);
       // $this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('invoice_type', 'service');
        $this->db->where_in('payment_mode', $mode);
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('Date_Format(invoice_date, "%Y-%m-%d")');
        $this->db->order_by('Date_Format(invoice_date, "%Y-%m-%d")');
        $query = $this->db->get('invoice');
       
        return $query->result_array();
    }
    
    function get_todaysale_card() {
        $today = date('Y-m-d');
        $yesterday= date('Y-m-d', strtotime('yesterday'));
        $tommorrow= date('Y-m-d', strtotime('tommorrow'));
        $mode=array();
        $mode[0]='Card';$mode[1]='Mixed';
        
        $this->db->select('Date_Format(invoice_date, "%Y-%m-%d") "saleon",  sum(paid_card) as "Total"');
        $this->db->where('invoice_date >=', $today);
        //$this->db->where('invoice_date <', $tommorrow);
       // $this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('invoice_type', 'service');
        $this->db->where_in('payment_mode', $mode);
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('Date_Format(invoice_date, "%Y-%m-%d")');
        $this->db->order_by('Date_Format(invoice_date, "%Y-%m-%d")');
        $query = $this->db->get('invoice');
       
        return $query->result_array();
    }
    
    function get_todaysale_bank() {
        $today = date('Y-m-d');
        $yesterday= date('Y-m-d', strtotime('yesterday'));
        $tommorrow= date('Y-m-d', strtotime('tommorrow'));
        
        $this->db->select('Date_Format(invoice_date, "%Y-%m-%d") "saleon",  sum(paid_check) as "Total"');
        $this->db->where('invoice_date >=', $today);
        //$this->db->where('invoice_date <', $tommorrow);
        //$this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('invoice_type', 'service');
        $this->db->where('payment_mode', 'Check');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('Date_Format(invoice_date, "%Y-%m-%d")');
        $this->db->order_by('Date_Format(invoice_date, "%Y-%m-%d")');
        $query = $this->db->get('invoice');
       
        return $query->result_array();
    }
    
    function get_todaysale_voucher() {
        $today = date('Y-m-d');
        $yesterday= date('Y-m-d', strtotime('yesterday'));
        $tommorrow= date('Y-m-d', strtotime('tommorrow'));
        
        $this->db->select('Date_Format(invoice_date, "%Y-%m-%d") "saleon",  sum(paid_voucher) as "Total"');
        $this->db->where('invoice_date >=', $today);
        //$this->db->where('invoice_date <', $tommorrow);
        //$this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('invoice_type', 'service');
        $this->db->where('payment_mode', 'Voucher');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('Date_Format(invoice_date, "%Y-%m-%d")');
        $this->db->order_by('Date_Format(invoice_date, "%Y-%m-%d")');
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
        $this->db->where('invoice_status', 'valid');
        $this->db->where('invoice_type', 'service');
        //$this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('Date_Format(invoice_date, "%Y-%m-%d")');
        $this->db->order_by('Date_Format(invoice_date, "%Y-%m-%d")');
        $query = $this->db->get('invoice');
       
        return $query->result_array();
    }
    
    function get_month($month, $year){
        $today = date('Y-m-d');
        
//        $sql="SELECT date_format(invoice_date, '%M') as 'Month', 
//                sum(paid_amount) + sum(advance_amount) +ifnull(voucher_amount,0) as 'Total', 
//                sum(paid_amount) paid, 
//                sum(advance_amount) advance, 
//                voucher_amount voucher,
//                sum(cctip) cctip,
//                sum(paid_cash) cash, sum(paid_card) card, sum(paid_check) bank,
//                sum(paid_cash) + sum(paid_card) + sum(paid_check) paymentmode
//                FROM invoice left join ( 
//                        select sum(ifnull(amount,0)) voucher_amount, voucher_date 
//                        from order_vouchers WHERE month(voucher_date)  = '".$month."'  AND year(voucher_date) = '".$year."' 
//                        group by month(voucher_date) 
//                ) as vouchers on month(vouchers.voucher_date) = month(invoice.invoice_date) and year(vouchers.voucher_date) = year(invoice.invoice_date) 
//                WHERE month(invoice_date)  = '".$month."' 
//                AND year(invoice_date) = '".$year."' 
//                AND invoice_status = 'valid' 
//                And invoice_type='service' 
//                AND invoice.business_id =  '".$this->session->userdata('businessid')."' 
//                GROUP BY month(invoice_date)";
//        
        $sql = "SELECT 
            date_format(invoice_date, '%M') as 'Month', 
            sum(paid_amount)+ifnull(voucher_amount,0)+ifnull(a_amount,0) as 'Total' , sum(paid_amount), voucher_amount
            FROM invoice 
            left join (
                    select sum(ifnull(amount,0)) voucher_amount, voucher_date from order_vouchers where order_vouchers.business_id = '".$this->session->userdata('businessid')."'
                    and month(voucher_date)=month('".$today."') AND year(voucher_date) = year('".$today."')  group by month(voucher_date) 
            ) as vouchers on month(vouchers.voucher_date) = month(invoice.invoice_date)
            and year(vouchers.voucher_date) = year(invoice.invoice_date)
            left join (
                SELECT SUM(visit_advance.advance_amount) as a_amount, visit_advance.advance_date 
                FROM visit_advance join customer_visits on customer_visits.id_customer_visits = visit_advance.customer_visit_id
                WHERE visit_status <> 'canceled' AND 
                month(visit_advance.advance_date) = month('".$today."') AND year(visit_advance.advance_date) = year('".$today."') AND 
                business_id = ".$this->session->userdata('businessid')."
            ) as advance on month(advance.advance_date) = month(invoice.invoice_date)
            
            and year(vouchers.voucher_date) = year(invoice.invoice_date)
            WHERE month(invoice_date) = month('".$today."') 
            AND year(invoice_date) = year('".$today."') 
            AND invoice_status = 'valid' 
            AND payment_mode != 'Voucher'
            And invoice_type='service' 
            AND invoice.business_id = '".$this->session->userdata('businessid')."' 
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
        $this->db->where('invoice_type', 'service');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by("month(invoice_date), year(invoice_date)");
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
        $this->db->where('invoice_type', 'service');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by("month(invoice_date), year(invoice_date)");
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
        $this->db->where('invoice_type', 'service');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by("month(invoice_date), year(invoice_date)");
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
        $this->db->where('payment_mode', 'Check');
        $this->db->where('invoice_type', 'service');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by("month(invoice_date), year(invoice_date)");
        $query = $this->db->get('invoice');
        
        return $query->result_array();
    }
    
    
    function get_year($month, $year){
        $today = date('Y-m-d');
        
        $sql="SELECT year(invoice_date) as 'Year', sum(paid_amount)+ifnull(voucher_amount,0)+ifnull(a_amount,0) as 'Total' ,
                sum(paid_amount), voucher_amount, a_amount
                FROM invoice 
                left join (
                    select sum(ifnull(amount,0)) voucher_amount, voucher_date from order_vouchers 
                    where order_vouchers.business_id = '".$this->session->userdata('businessid')."'
                    and year(voucher_date) = year('".$today."')  group by year(voucher_date) 
                ) as vouchers on year(vouchers.voucher_date) = year(invoice.invoice_date)
                
                left join (
                    SELECT SUM(visit_advance.advance_amount) as a_amount, visit_advance.advance_date 
                    FROM visit_advance join customer_visits on customer_visits.id_customer_visits = visit_advance.customer_visit_id
                    WHERE visit_status <> 'canceled' AND 
                    year(visit_advance.advance_date) = year('".$today."') AND 
                    business_id = ".$this->session->userdata('businessid')."
                ) as advance on year(advance.advance_date) = year(invoice.invoice_date)
                WHERE year(invoice_date) = year('".$today."') 
                AND invoice_status = 'valid' 
                AND payment_mode != 'Voucher'
                and invoice_type = 'service'
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
        $this->db->where('invoice_type', 'service');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by("month(invoice_date), year(invoice_date)");
        $this->db->order_by("month(invoice_date)");
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
        $this->db->where('invoice_type', 'service');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by("date_format(invoice_date,'%d')");
        $this->db->order_by("date_format(invoice_date,'%d')");
        $query = $this->db->get('invoice');
        
         return $query->result_array();
    }
    
    function get_month_commission($month, $year){
         $today = date('Y-m-d');
        $this->db->select("date_format(staff_service_date, '%M') as 'Month', 
        date_format(staff_service_date, '%Y') as 'Year',
        sum(staff_commission) as 'Commission'");
        $this->db->join("invoice", " invoice.id_invoice = staff_services.invoice_id");
        $this->db->join("staff", "staff.id_staff = staff_services.staff_id");
        //$this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_type', 'service');
        $this->db->where('invoice_status', 'valid');
        $this->db->where('staff_services.business_id', $this->session->userdata('businessid'));
        $this->db->where('year(invoice_date) = ', $year);
        $this->db->where('month(invoice_date) =', $month);
        $this->db->group_by("date_format(staff_service_date, '%M'), date_format(staff_service_date, '%Y')");
        $this->db->order_by("3 desc");
        $query = $this->db->get('staff_services');
        
        
        
        return $query->result_array();
        
    }
    function top_4_clients($month, $year){
        $today = date('27-'.$month.'-'.$year);
        $months=[];
        $years=[];
        $done='';
        $dp=new DatePeriod(date_create($today),DateInterval::createFromDateString('last month'),2);
        foreach($dp as $dt) {
            
            array_push($months, $dt->format("m"));
            if($done !== $dt->format("Y")){
                array_push($years, $dt->format("Y"));
                $done=$dt->format("Y");
            }
        }
        
        $this->db->select("customer_name, customer_cell, customer_email, CONCAT('Rs. ', FORMAT(sum(paid_amount), 2)) as 'Total', customer_id", True);
        $this->db->where("invoice_status='valid'");
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where_in('month(invoice_date)',$month);
        //$this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_type', 'service');
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
        
//        $select = "staff_name Staff, staff_image, count(*) as 'Services', format(sum(paid),2)  as 'Amount', sum(paid)";
//        
//        $this->db->select($select);
//        $this->db->join("invoice", "invoice.id_invoice = staff_services.invoice_id");
//        $this->db->join("staff", "staff.id_staff = staff_services.staff_id");
//        $this->db->where('month(invoice_date)',$month);
//        $this->db->where('year(invoice_date)', $year);
//        $this->db->not_like("staff_name", "|");
//        $this->db->where("ifnull(reference_invoice_number,'') = ''");
//        //$this->db->where("reference_invoice_number <>","bad debts");
//        $this->db->where('invoice_type', 'service');
//        $this->db->where('invoice_status', 'valid');
//        $this->db->group_by("staff_name, staff_image");
//        $this->db->order_by("5 desc");
        
        $sql="SELECT staff.id_staff, 
                staff.staff_fullname Staff, 
                staff.staff_image, 
                count(id_staff_services) as 'Services', 
                format(sum(paid), 2) as 'Amount', 
                ifnull(a.Recovery,0) 'Recovery', 
                format(ifnull(sum(paid) + ifnull(a.total,0),0),2) as 'Total',
                ifnull(sum(paid) + ifnull(a.total,0),0)
                FROM staff_services 
                JOIN invoice ON invoice.id_invoice = `staff_services`.`invoice_id` 
                JOIN staff ON staff.id_staff = staff_services.staff_id 
                left join (
                        SELECT id_staff, format(sum(ifnull(paid,0)), 2) as 'Recovery', sum(ifnull(paid,0)) as 'total',
                        count(id_staff_services) as 'rec_count'
                        FROM `staff_services` 
                        JOIN `invoice` ON `invoice`.`id_invoice` = `staff_services`.`invoice_id` 
                        JOIN staff ON staff.id_staff = staff_services.staff_id 
                        WHERE month(invoice_date) = '".$month."' AND year(invoice_date) = '".$year."' 
                        AND `staff_name` NOT LIKE '%|%' ESCAPE '!' 
                        AND ifnull(reference_invoice_number,'') != '' 
                        AND `invoice_type` = 'service' 
                        AND `invoice_status` = 'valid' 
                        AND invoice.business_id= ".$this->session->userdata('businessid')."
                        GROUP BY id_staff
                ) as a on a.id_staff = staff.id_staff
                WHERE month(invoice_date) = '".$month."' AND year(invoice_date) = '".$year."' 
                AND staff_services.staff_name NOT LIKE '%|%' ESCAPE '!' AND ifnull(reference_invoice_number,'') = '' 
                AND invoice_type = 'service' 
                AND invoice_status = 'valid' 
                AND invoice.business_id=".$this->session->userdata('businessid')."
                GROUP BY staff.id_staff, staff.staff_fullname, staff.staff_image
                ORDER BY 8 desc";
       
                
        $query = $this->db->query($sql);
        
        return $query->result_array();
    }
    
   
     
    function grossing_services($month, $year){
        $sql="select invoice_details.service_category as 'name', sum(paid)/T.total*100 as 'y' , sum(paid), T.total as 'paid'
	from invoice_details 
	join invoice on invoice.id_invoice = invoice_details.invoice_id 
	and invoice.invoice_status = 'valid'
        and reference_invoice_number=''
        and invoice_details.service_category is not null
	and invoice.business_id=".$this->session->userdata('businessid')." 
	and  month(invoice_detail_date) = '".$month."'
	and  year(invoice_detail_date) = '".$year."',
        
	(
            select subtotal as 'total' 
            from 
                (
                SELECT service_category, sum(paid) as subtotal 
                FROM invoice_details
                join invoice on invoice.id_invoice = invoice_details.invoice_id 
                and invoice.invoice_status = 'valid' 
                and invoice_details.service_category is not null
                and invoice.business_id=".$this->session->userdata('businessid')."  
                and  month(invoice_date) = '".$month."'
                and  year(invoice_date) = '".$year."'	
                and reference_invoice_number=''     
                
                ) as M
            ) as T
	group by service_category
	order by 2 desc";
//      /  echo $sql;
        $query = $this->db->query($sql);        
        
        return $query->result_array();
        
    }
    
}
