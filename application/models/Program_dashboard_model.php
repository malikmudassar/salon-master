<?php

class Program_dashboard_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }
    
    function get_business_sales($year){        
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('year', $year);
        $query = $this->db->get('business_sales');
        
        return $query->result();
    }
    
    function get_business_sale_year_month($month, $year){
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('month', $month);
        $this->db->where('year', $year);
        $query = $this->db->get('business_sales');
        
        return $query->row();
    }
    
    function get_business_sale_years(){
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->group_by('year');
        $query = $this->db->get('business_sales');
        return $query->result();
    }
    
    function get_this_month_year_sale($start, $end) {
        
        $this->db->select('SUM(paid_amount) as total_sale');
        $this->db->where('year(invoice_date) = date_format(\''.$start.'\',\'%Y\')');
        $this->db->where('month(invoice_date) = date_format(\''.$start.'\',\'%m\')');
       // $this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        //$this->db->group_by('invoice_date');
        $query = $this->db->get('invoice');
      

        return $query->row();
    }
    
    function add_this_month_year_sale($data){
        $this->db->insert('business_sales', $data);
        return $this->db->insert_id();
    }

    function get_todaysale() {
        $today = date('Y-m-d');
        $yesterday= date('Y-m-d', strtotime('yesterday'));
        $tommorrow= date('Y-m-d', strtotime('tommorrow'));
        
//        $this->db->select('Date_Format(invoice_date, "%Y-%m-%d") "saleon",  sum(paid_amount) as "Total"');
//        $this->db->where('invoice_date >=', $today);
//        //$this->db->where('invoice_date <', $tommorrow);
//        //$this->db->where("reference_invoice_number <>","bad debts");
//        $this->db->where('invoice_status', 'valid');
//        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
//        $this->db->group_by('Date_Format(invoice_date, "%Y-%m-%d")');
//        $this->db->order_by('Date_Format(invoice_date, "%Y-%m-%d")');
//        $query = $this->db->get_compiled_select('invoice');
       
        $sql="SELECT Date_Format(invoice_date, '%Y-%m-%d') 'saleon', sum(total_payable)+ifnull(voucher_amount,0)+ifnull(a_amount,0) as 'Total',
            ifnull(voucher_amount,0) 
            FROM invoice 
            left join (
                select sum(ifnull(amount,0)) voucher_amount, voucher_date from order_vouchers where 
                voucher_date >= '".$today."' 
                and order_vouchers.business_id = '".$this->session->userdata('businessid')."'
                group by date_format(voucher_date, '%Y-%m-%d') 
            ) as vouchers on date_format(vouchers.voucher_date, '%Y-%m-%d') = date_format(invoice.invoice_date, '%Y-%m-%d')
            
            left join (
                SELECT SUM(visit_advance.advance_amount) as a_amount, visit_advance.advance_date 
                FROM visit_advance join customer_visits on customer_visits.id_customer_visits = visit_advance.customer_visit_id
                WHERE visit_status <> 'canceled' AND 
                visit_advance.advance_date >= '".$today."'  AND 
                business_id = ".$this->session->userdata('businessid')."
            ) as advance on month(advance.advance_date) = month(invoice.invoice_date)

            WHERE invoice_date >= '".$today."' 
            AND invoice_status = 'valid' 
            AND invoice.business_id = '".$this->session->userdata('businessid')."' 
            GROUP BY Date_Format(invoice_date, '%Y-%m-%d') 
            ORDER BY Date_Format(invoice_date, '%Y-%m-%d')";
       
        $query =$this->db->query($sql);
        
        return $query->result_array();
    }
    function get_yesterdaysale() {
        $today = date('Y-m-d');
        $yesterday= date('Y-m-d', strtotime('yesterday'));
        $tommorrow= date('Y-m-d', strtotime('tommorrow'));
        
        $this->db->select('Date_Format(invoice_date, "%Y-%m-%d") "saleon",  sum(total_payable) as "Total"');
        $this->db->where('invoice_date >=', $yesterday);
        $this->db->where('invoice_date <=', $today);
        $this->db->where('invoice_status', 'valid');
       // $this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('Date_Format(invoice_date, "%Y-%m-%d")');
        $this->db->order_by('Date_Format(invoice_date, "%Y-%m-%d")');
        $query = $this->db->get('invoice');
       
        return $query->result_array();
    }
    
    function get_month(){
        $today = date('Y-m-d');
//        
//        $this->db->select("date_format(invoice_date,'%M') as 'Month', sum(paid_amount) as 'Total' ");
//        $this->db->where('month(invoice_date) = date_format(\''.$today.'\',\'%m\')');
//        $this->db->where('year(invoice_date) = date_format(\''.$today.'\',\'%Y\')');
//       // $this->db->where("reference_invoice_number <>","bad debts");
//        $this->db->where('invoice_status', 'valid');
//        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
//        $this->db->group_by("date_format(invoice_date,'%M')");
        
        $sql="SELECT 
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
            AND invoice.business_id = '".$this->session->userdata('businessid')."' 
            GROUP BY month(invoice_date)";
                
        $query =$this->db->query($sql);
        
        return $query->result_array();
         
    }
    
    function get_year(){
        $today = date('Y-m-d');
        
//        $this->db->select("date_format(invoice_date,'%Y') as 'Year', sum(paid_amount) as 'Total' ");
//        $this->db->where('year(invoice_date) =  date_format(\''.$today.'\',\'%Y\')');
//      //  $this->db->where("reference_invoice_number <>","bad debts");
//        $this->db->where('invoice_status', 'valid');
//        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
//        $this->db->group_by("date_format(invoice_date,'%Y')");
//        $query = $this->db->get_compiled_select('invoice');

        
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
                AND invoice.business_id = '".$this->session->userdata('businessid')."' 
                GROUP BY year(invoice_date)";
        $query =$this->db->query($sql);
        return $query->result_array();
    }
    
    function get_monthly(){
        $today = date('Y-m-d');
        
        $this->db->select("date_format(invoice_date, '%M') as 'Month', sum(paid_amount) as 'Total' ");
        $this->db->where('year(invoice_date) =  date_format(\''.$today.'\',\'%Y\')');
       // $this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by("date_format(invoice_date,'%M')");
        $this->db->order_by("date_format(invoice_date,'%M')");
        $query = $this->db->get('invoice');
        
         return $query->result_array();
    }
    
    function get_daily(){
        $today = date('Y-m-d');
        $this->db->select("date_format(invoice_date, '%d') as 'Day', sum(paid_amount) as 'Total' ");
        $this->db->where('year(invoice_date) =  date_format(\''.$today.'\',\'%Y\')');
        $this->db->where('month(invoice_date) =  date_format(\''.$today.'\',\'%m\')');
       // $this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->group_by("date_format(invoice_date,'%d')");
        $this->db->order_by("date_format(invoice_date,'%d')");
        $query = $this->db->get('invoice');
        
         return $query->result_array();
    }
    
    function get_month_commission(){
         $today = date('Y-m-d');
        $this->db->select("date_format(staff_service_date, '%M') as 'Month', 
        date_format(staff_service_date, '%Y') as 'Year',
        sum(staff_commission) as 'Commission'");
        $this->db->join("invoice", " invoice.id_invoice = staff_services.invoice_id");
        $this->db->join("staff", "staff.id_staff = staff_services.staff_id");
      //  $this->db->where("reference_invoice_number <>","bad debts");
        $this->db->where('invoice_type', 'service');
        $this->db->where('invoice_status', 'valid');
        $this->db->where('staff_services.business_id', $this->session->userdata('businessid'));
        $this->db->where('year(invoice_date) =  date_format(\''.$today.'\',\'%Y\')');
        $this->db->where('month(invoice_date) =  date_format(\''.$today.'\',\'%m\')');
        $this->db->group_by("date_format(staff_service_date, '%M'), date_format(staff_service_date, '%Y')");
        $this->db->order_by("3 desc");
        $query = $this->db->get('staff_services');
        
        
        
        return $query->result_array();
        
    }
    function top_4_clients(){
        $today = date('Y-m-d');
        $months=[];
        $years=[];
        $dp=new DatePeriod(date_create(),DateInterval::createFromDateString('last month'),2);
        foreach($dp as $dt) {
            array_push($months, $dt->format("m"));
            array_push($years, $dt->format("Y"));
            
        }

//        for ($x=0; $x<=2; $x++){
//            $months[$x] = date('m', strtotime('-'.$x.' month'));
//        }
        
        $this->db->select("customer_name, customer_cell, customer_email, CONCAT('Rs. ', FORMAT(sum(paid_amount), 2)) as 'Total', customer_id", True);
        $this->db->where("invoice_status='valid'");
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where_in('month(invoice_date)',$months);
        //$this->db->where("reference_invoice_number <>","bad debts");
        //$this->db->where('invoice_type', 'service');
        $this->db->where('invoice_status', 'valid');
        $this->db->where_in('year(invoice_date)',$years);
        $this->db->group_by("customer_name, customer_cell, customer_email");
        $this->db->order_by("sum(paid_amount) desc");
        $this->db->limit(20); 
        $query = $this->db->get('invoice');

       
        return $query->result_array();

    }
    
    function top_4_staff(){
        
        $today = date('Y-m-d');
        $month=date('m', strtotime($today));
        $year=date('Y', strtotime($today));
//        
//        $select = "staff_name Staff, staff_image, count(*) as 'Services', format(sum(paid),2)  as 'Amount', sum(paid)";
//        
//        $this->db->select($select);
//        $this->db->join("invoice", "invoice.id_invoice = staff_services.invoice_id");
//        $this->db->join("staff", "staff.id_staff = staff_services.staff_id");
//        $this->db->where('month(invoice_date)',$month);
//        $this->db->where('year(invoice_date)', $year);
//        $this->db->not_like("staff_name", "|");
//        $this->db->where("ifnull(reference_invoice_number,'') = ''");
//       // $this->db->where("reference_invoice_number <>","bad debts");
//        $this->db->where('invoice_type', 'service');
//        $this->db->where('invoice_status', 'valid');
//        $this->db->group_by("staff_name, staff_image");
//        $this->db->order_by("5 desc");
//        $this->db->limit(12);
//        $query = $this->db->get('staff_services');
//        
//         return $query->result_array();
        
        
                $sql="SELECT staff.id_staff, 
                staff.staff_fullname Staff, 
                staff.staff_image, 
                count(id_staff_services)  as 'Services', 
                format(sum(paid), 2) as 'Paid', 
                ifnull(a.Recovery,0) 'Recovery', 
                format(ifnull(sum(paid) + ifnull(a.total,0),0),2) as 'Amount',
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
                        GROUP BY id_staff, staff_name, staff_image
                ) as a on a.id_staff = staff.id_staff
                WHERE month(invoice_date) = '".$month."' AND year(invoice_date) = '".$year."' 
                AND staff_services.staff_name NOT LIKE '%|%' ESCAPE '!' 
                AND ifnull(reference_invoice_number,'') = '' 
                AND invoice_type = 'service' 
                AND invoice_status = 'valid' 
                AND invoice.business_id=".$this->session->userdata('businessid')."
                GROUP BY staff_services.staff_name, staff.staff_image
                ORDER BY 8 desc";
        
                
        $query = $this->db->query($sql);
        
        return $query->result_array();
        
        
    }
    
    function uninvoiced(){
        //$tommorrow= date('Y-m-d', strtotime('tommorrow'));
        $today = date('Y-m-d');
        
        $sql = "select id_customer_visits, date_format(convert(replace(visit_service_start, \"T\", \" \"), datetime), \"%d-%m-%Y %H:%i:%s\") as customer_visit_date, customer_name, count(id_visit_services) services, date_format(convert(replace(visit_service_start,'T',' '),datetime),'%Y-%m-%d') date1,
        Case
	When convert(visit_service_start, datetime)>='".$today."' then 'text-info'
	Else 'text-danger' 
        End
        as 'color'
        from customer_visits
        join customers on customers.id_customers = customer_visits.customer_id
        join visit_services on visit_services.customer_visit_id = customer_visits.id_customer_visits
        where visit_status = 'open' and customer_visits.business_id=".$this->session->userdata('businessid')."
        group by  id_customer_visits, customer_visit_date, customer_name order by 5";
        
        $query = $this->db->query($sql);
                
        return $query->result_array();
    }
     
    function grossing_services(){
        $today = date('Y-m-d');
        $month=date('m', strtotime($today));
        $year=date('Y', strtotime($today));
        
        $sql="select concat(invoice_details.service_name,' ',invoice_details.service_category) as 'name', sum(paid)/T.total*100 as 'y' , sum(paid) as 'paid'
                from invoice_details 
                join invoice on invoice.id_invoice = invoice_details.invoice_id 
                and invoice.invoice_status = 'valid'
                and  month(invoice_detail_date) = '".$month."'
                and  year(invoice_detail_date) = '".$year."'
                and invoice_details.business_id= ".$this->session->userdata('businessid').",
                (
                    select sum(subtotal) as 'total' 
                    from 
                        (
                        SELECT service_name, sum(paid) as subtotal 
                        FROM invoice_details
                        join invoice on invoice.id_invoice = invoice_details.invoice_id 
                        and invoice.invoice_status = 'valid'
                        and  month(invoice_detail_date) = '".$month."'
                        and  year(invoice_detail_date) = '".$year."'
                        and ifnull(reference_invoice_number,'') = '' 
                        and invoice_details.business_id= ".$this->session->userdata('businessid')."
                        group by service_name
                        order by 2 desc
                        limit 5
                        ) as M
                    ) as T
                group by service_name
                order by 2 desc
                limit 5
                ";
       
        $query = $this->db->query($sql);        
        
        return $query->result_array();
        
    }

    function get_workweek(){
        $today=date('Y-m-d'); 
        $sql = "select date_format(day, '%a %D') day, customers 'Customers', services 'Services',
        ifnull(paid_amount,0)+ifnull(vouchers.voucher_amount,0) 'Revenue', ifnull(balance,0) 'Balance', 
	ifnull(visit_advance,0) 'Advance', ifnull(paid_amount,0), ifnull(vouchers.voucher_amount,0)
        from
        (SELECT '".$today."' AS day
           UNION SELECT '".$today."' - INTERVAL 1 DAY
           UNION SELECT '".$today."' - INTERVAL 2 DAY
           UNION SELECT '".$today."' - INTERVAL 3 DAY
           UNION SELECT '".$today."' - INTERVAL 4 DAY
           UNION SELECT '".$today."' - INTERVAL 5 DAY
           UNION SELECT '".$today."' - INTERVAL 6 DAY
        ) as week
        left join (
                select date_format(invoice_date, '%Y-%m-%d') invoice_date,
                ifnull(sum(paid_amount),0) paid_amount, ifnull(sum(balance),0) as balance
                from invoice 
                where invoice_status = 'valid'
                and business_id = ".$this->session->userdata('businessid')."
                group by date_format(invoice_date, '%Y-%m-%d') 		
            ) as invoice on date_format(invoice.invoice_date, '%Y-%m-%d') = week.day 
        left join (
                select date_format(invoice_detail_date, '%Y-%m-%d') as invoice_detail_date
		from invoice_details
                where business_id = ".$this->session->userdata('businessid')."
                group by date_format(invoice_detail_date, '%Y-%m-%d')
            ) as invoice_d on date_format(invoice_detail_date, '%Y-%m-%d') = week.day 
        left join (
                select date_format(visit_advance.advance_date, '%Y-%m-%d') vdate, sum(ifnull(visit_advance.advance_amount,0)) 'visit_advance' 
                from visit_advance join customer_visits on visit_advance.customer_visit_id = customer_visits.id_customer_visits where visit_status != 'canceled'
                and business_id = ".$this->session->userdata('businessid')."
                group by vdate			
            ) as visits on visits.vdate = week.day
        left join (
                select date_format(visit_service_start, '%Y-%m-%d') vsdate, count(service_id) 'services', 
                count(distinct customer_visit_id) customers
                from visit_services join customer_visits 
                on customer_visits.id_customer_visits = visit_services.customer_visit_id
                where visit_status != 'canceled'
                and visit_services.business_id = ".$this->session->userdata('businessid')."
                group by vsdate			
            ) as services on services.vsdate = week.day
        left join (
                select sum(ifnull(amount,0)) voucher_amount, date_format(voucher_date, '%Y-%m-%d') voucherdate 
                from order_vouchers
                where business_id = ".$this->session->userdata('businessid')."
                group by  date_format(voucher_date, '%Y-%m-%d')		
            ) as vouchers on vouchers.voucherdate = week.day
        group by day";
        
        $query = $this->db->query($sql);        
        
        return $query->result_array();
    }
    
}
