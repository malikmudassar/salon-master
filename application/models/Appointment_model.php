<?php

class Appointment_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }

    function get_appointments() {
        $today = date('Y-m-d');
        $tomorrow= date('Y-m-d H:i:s', strtotime('tomorrow'));
        
        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = appointments.customer_id');
        $this->db->where('appointment_date_time >', $today);
        $this->db->where('appointment_date_time <', $tomorrow);
        $this->db->where('appointment_status', 'open');
        $this->db->where('appointments.business_id', $this->session->userdata('businessid'));
        $this->db->order_by('appointment_date_time', 'ASC');
        $query = $this->db->get('appointments');
       
        return $query->result_array();
    }
    
    function get_todayappointments() {
        $today = date('Y-m-d');
        $tomorrow= date('Y-m-d H:i:s', strtotime('tomorrow'));
        
        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = appointments.customer_id');
        $this->db->where('appointment_date_time >', $today);
        $this->db->where('appointment_date_time <', $tomorrow);
        $this->db->where('appointment_status', 'open');
        $this->db->where('appointments.business_id', $this->session->userdata('businessid'));
        $this->db->order_by('appointment_date_time', 'ASC');
        $query = $this->db->get('appointments');
       
        return $query->result_array();
    }
    
    function get_nextdayappointments() {
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d H:i:s', strtotime('tomorrow'));
        $aftertomorrow= date('Y-m-d H:i:s', strtotime('+1 day', strtotime($tomorrow)));
        
        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = appointments.customer_id');
        $this->db->where('appointment_date_time >', $tomorrow);
        $this->db->where('appointment_date_time <', $aftertomorrow);
        $this->db->where('appointment_status', 'open');
        $this->db->where('appointments.business_id', $this->session->userdata('businessid'));
        $this->db->order_by('appointment_date_time', 'ASC');
        $query = $this->db->get('appointments');
       
        return $query->result_array();
    }
    
    function get_by_custid(){
        $this->db->select("*, DATE_FORMAT(appointment_date_time,'%b %d %Y') as 'appdate', DATE_FORMAT(appointment_date_time,'%h:%i %p') as 'apptime'");
        $this->db->join('customers', 'customers.id_customers = appointments.customer_id');
        $this->db->where('customer_id', $this->input->post('id', TRUE));
        $this->db->where('appointment_status', 'open');
        $this->db->where('appointments.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('appointments');
       
        return $query->result_array();
        
    }
    
    function add_appointment(){

        $phpdate =  strtotime($this->input->post('appointment-date', TRUE));
        $mysqldate = date('Y-m-d', $phpdate);
        $date = new DateTime($mysqldate.' '.$this->input->post('appointment-time', TRUE));
                
        $appointmentdt= date_format($date,'Y-m-d H:i:s');;
        $appointmentday=date_format($date,'D');;
        $appointmentmonth=date_format($date,'F');
        $appointmenthour=date_format($date,'g');
        $appointmentmin=date_format($date,'i');
        $appointmentyear=date_format($date,'Y');

       // echo date_format($date,'i'); //$date;
       // echo $mysqldate;
        
        $data = array(
            'business_id' => $this->session->userdata('businessid'),
            'customer_id' => $this->input->post('appointment-customer-id', TRUE),
            'appointment_date_time' => $appointmentdt,
            'appointment_day' => $appointmentday,
            'appointment_month' => $appointmentmonth,
            'appointment_hour' => $appointmenthour,
            'appointment_minutes' => $appointmentmin,
            'appointment_year' => $appointmentyear,
            'appointment_remarks' => $this->input->post('appointment-remarks', TRUE)
        );

        $this->db->insert('appointments', $data);
        return $this->db->insert_id();
    }
    
    function  update_status(){
        $data = array(
            'appointment_status' => $this->input->post('status', TRUE)
        );
        $this->db->where('id_appointments', $this->input->post('id', TRUE));
        $this->db->update('appointments', $data);
        return $this->db->affected_rows();
    }

    public function get_appointments_view() {
        $datetime = date('Y-m-d', strtotime($this->input->post('date', TRUE)));
        $query = $this->db->query("SELECT c.id_customers, c.customer_name,vs.service_name,vs.staff_names,date_format(a.appointment_date_time,'%D-%M-%Y %h:%i:%s %p') as datetime FROM appointments a 
            join customers c on c.id_customers = a.customer_id 
            join customer_visits cv on cv.customer_id = c.id_customers 
            join visit_services vs on vs.customer_visit_id = cv.id_customer_visits
            where a.appointment_date_time like '" . $datetime . "%' and a.appointment_status = 'open' 
            and cv.visit_status = 'open' group by c.id_customers");
        return $query->result_array();
    }
    
    public function get_range_appointments($startdate, $enddate) {
       
        $sql= "select 
                id_customer_visits, date_format(customer_visit_date, '%d-%m-%Y') as date, date_format(convert(replace(visit_service_start,'T',' '),datetime),'%Y-%m-%d') date1,
                customer_id , customer_name, customer_cell, date_format(visit_service_start, \"%d-%m-%Y %H:%i:%s\") visit_service_start,
                service_type, service_category, service_name, service_flag, reminder_sms, reminder_call, reminder_email, staff_name, business_name
                from customer_visits 
                join customers on customers.id_customers = customer_visits.customer_id
                join visit_services on visit_services.customer_visit_id = customer_visits.id_customer_visits
                join visit_service_staffs on visit_service_staffs.visit_service_id = visit_services.id_visit_services  
                join business on customer_visits.business_id = business.id_business 
                and convert(visit_service_start, date) >=  '".$startdate." 00:00"."' AND convert(visit_service_start, date) <= '".$enddate." 23:59"."'
                join service_category on service_category.id_service_category=visit_services.id_service_category
                join  service_type on service_type.id_service_types = service_category.service_type_id
                where visit_status='open' and service_flag='servicetype' 
                and (customer_visits.business_id=".$this->session->userdata('businessid')." OR visit_service_staffs.block_other='Yes') ";
            
        if(null!==$this->input->post('id_service_type') && $this->input->post('id_service_type')>0){
            $sql.=" and service_category.service_type_id = ".$this->input->post('id_service_type'); 
        }        
        if(null!==$this->input->post('id_service_category') && $this->input->post('id_service_category')>0){
            $sql.=" and service_category.id_service_category = ".$this->input->post('id_service_category'); 
        } 
        if(null!==$this->input->post('id_business_services') && $this->input->post('id_business_services')>0){
            $sql.=" and visit_services.service_id = ".$this->input->post('id_business_services'); 
        }
        if($this->input->post('customer')!==""){        
            $sql .= " and customers.customer_name like '%".$this->input->post('customer')."%' ";
        }
        if($this->input->post('cell')!==""){        
            $sql .= " and customers.customer_cell like '%".$this->input->post('cell')."%' ";
        }
        if(null!==$this->input->post('staff_id') && $this->input->post('staff_id')>0){
            $sql.=" and visit_service_staffs.staff_id = ".$this->input->post('staff_id'); 
        }
        
        $sql.= " group by id_visit_services union
                select 
                id_customer_visits, date_format(customer_visit_date, '%d-%m-%Y') as date, date_format(convert(replace(visit_service_start,'T',' '),datetime),'%Y-%m-%d') date1,
                customer_id , customer_name, customer_cell, date_format(visit_service_start, \"%d-%m-%Y %H:%i:%s\") visit_service_start,
                package_type.service_type collate utf8_general_ci as 'service_type', package_category.service_category collate utf8_general_ci as 'service_category', visit_services.service_name, service_flag,
                reminder_sms, reminder_call, reminder_email, staff_name, business_name
                from customer_visits 
                join customers on customers.id_customers = customer_visits.customer_id
                join visit_services on visit_services.customer_visit_id = customer_visits.id_customer_visits
                join visit_service_staffs on visit_service_staffs.visit_service_id = visit_services.id_visit_services
                join business on customer_visits.business_id = business.id_business 
                and convert(visit_service_start, date) >=  '".$startdate." 00:00"."' AND convert(visit_service_start, date) <= '".$enddate." 23:59"."'
                join package_category on package_category.id_package_category = visit_services.id_service_category
                join package_type on package_type.id_package_type = package_category.package_type_id
                where visit_status='open' and service_flag='packagetype'
                and (customer_visits.business_id=".$this->session->userdata('businessid')." OR visit_service_staffs.block_other='Yes') ";
            
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
        if($this->input->post('customer')!==""){        
            $sql .= " and customers.customer_name like '%".$this->input->post('customer')."%' ";
        }
        if($this->input->post('cell')!==""){        
            $sql .= " and customers.customer_cell like '%".$this->input->post('cell')."%' ";
        }
        $sql.= " group by id_visit_services order by 6,2;";
                
        
        $query = $this->db->query($sql);

        return $query->result_array();
    }
    
    public function getbookings(){
        $today = date('Y-m-d');
        
        $query = $this->db->query($sql="SELECT 
            `id_customer_visits` `visit_id`, 
            `service_type`, 
            `service_category`, 
            `customer_name`, 
            `customer_cell`, 
            `customer_email`, 
            va.advance_amount, 
            customer_visits.advance_mode, 
            date_format(visit_service_start, '%d-%c-%Y %h:%i %p') as visit_date,
            customer_visits.customer_visit_date as 'date' 
            FROM `customer_visits` 
            JOIN `visit_services` ON `customer_visits`.`id_customer_visits` = `visit_services`.`customer_visit_id` 
            JOIN `package_category` `pc` ON `pc`.`id_package_category` = `visit_services`.`id_service_category` 
            JOIN `package_type` `pt` ON `pt`.`id_package_type` = `pc`.`package_type_id` 
            JOIN `customers` ON `customers`.`id_customers` = `customer_visits`.`customer_id` 
            JOIN (
            select id_customer_visits customer_visit_id,  sum(visit_advance.advance_amount) advance_amount
            from customer_visits
            JOIN visit_advance ON customer_visits.id_customer_visits = visit_advance .customer_visit_id 
            group by id_customer_visits
            ) va ON customer_visits.id_customer_visits = va.customer_visit_id 
            WHERE `visit_status` = 'open' 
            AND `service_flag` = 'packagetype' 
            AND `visit_service_start` >= '".$today."' 
            AND `customer_visits`.`business_id` = '".$this->session->userdata('businessid')."' 
            GROUP BY `id_customer_visits`,
            `customer_name`, `customer_cell`, 
            `customer_email`, customer_visits.advance_mode
            ");
        
        return $query->result_array();
    }
    
    public function get_appointment($id_customer_visits){
        
        $sql= "select 
                id_customer_visits, date_format(customer_visit_date, '%d-%m-%Y') as date, date_format(convert(replace(visit_service_start,'T',' '),datetime),'%Y-%m-%d') date1,
                customer_id , customer_name, customer_cell, date_format(visit_service_start, \"%d-%m-%Y %h:%i:%s\") visit_service_start,
                service_type, service_category, service_name, service_flag, reminder_sms, reminder_call, reminder_email, staff_name, id_visit_services
                from customer_visits 
                join customers on customers.id_customers = customer_visits.customer_id
                join visit_services on visit_services.customer_visit_id = customer_visits.id_customer_visits
                join visit_service_staffs on visit_service_staffs.visit_service_id = visit_services.id_visit_services
                join service_category on service_category.id_service_category=visit_services.id_service_category
                join  service_type on service_type.id_service_types = service_category.service_type_id
                where visit_status='open' and service_flag='servicetype' 
                and id_customer_visits='". $id_customer_visits ."' ";
        $sql.= " group by id_visit_services union
                select 
                id_customer_visits, date_format(customer_visit_date, '%d-%m-%Y') as date, date_format(convert(replace(visit_service_start,'T',' '),datetime),'%Y-%m-%d') date1,
                customer_id , customer_name, customer_cell, date_format(visit_service_start, \"%d-%m-%Y %h:%i:%s\") visit_service_start,
                package_type.service_type collate utf8_general_ci as 'service_type', package_category.service_category collate utf8_general_ci as 'service_category', visit_services.service_name, service_flag,
                reminder_sms, reminder_call, reminder_email, staff_name, id_visit_services
                from customer_visits 
                join customers on customers.id_customers = customer_visits.customer_id
                join visit_services on visit_services.customer_visit_id = customer_visits.id_customer_visits
                join visit_service_staffs on visit_service_staffs.visit_service_id = visit_services.id_visit_services
                join package_category on package_category.id_package_category = visit_services.id_service_category
                join package_type on package_type.id_package_type = package_category.package_type_id
                where visit_status='open' and service_flag='packagetype' and id_customer_visits='". $id_customer_visits ."' ";
            
        
        $sql.= " group by id_visit_services order by 7,2;";
                
       
        $query = $this->db->query($sql);

        return $query->result_array();
        
    }
    
    
    function staff_performance($startdate, $enddate) {

      //  $date = strtotime("+ 1 days", strtotime($enddate));
      //  $enddate = date("Y-m-d", $date);

        $this->db->select("service_type, service_category, service_name, staff_name, date_format(invoice_date, '%d-%m-%Y') as 'Date', count(service_name) as service_count, sum(price) as price, sum(staff_services.discount) as discount_sum, sum(discounted_price) as price_sum, sum(paid) as paid");
        $this->db->join('staff_services', 'invoice.id_invoice = staff_services.invoice_id');
        $this->db->where('invoice_date >=', $startdate." 00:00");
        $this->db->where('invoice_date <=', $enddate." 23:59");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        //$this->db->where('reference_invoice_number <>', 'bad debts');
        $this->db->where('ifnull(invoice.reference_invoice_number,"")=""');
        $this->db->where('invoice_type', 'service');
        
        if(null!==$this->input->post('service_type') && $this->input->post('service_type')!=='' && $this->input->post('service_type')!=='All'){
            $this->db->where("service_type = ",$this->input->post('service_type')); 
        }        
        if(null!==$this->input->post('service_category') && $this->input->post('service_category')!=='' && $this->input->post('service_category')!=='All'){
            $this->db->where("service_category = ",$this->input->post('service_category')); 
        }
        if(null!==$this->input->post('service_name') && $this->input->post('service_name')!=='' && $this->input->post('service_name')!=='All'){
            $this->db->where("service_name = ", $this->input->post('service_name')); 
        }
        if(null!==$this->input->post('staff_id') && $this->input->post('staff_id')>0){
            $this->db->where("staff_services.staff_id = ".$this->input->post('staff_id')); 
        }
        if($this->input->post('customer')!==""){        
            $this->db->like("invoice.customer_name", $this->input->post('customer'));
        }
        
        
        $this->db->order_by('staff_name', 'service_type', 'service_category', 'service_name');
        $this->db->group_by('service_type');
        $this->db->group_by('service_category');
        $this->db->group_by('service_name');
        $this->db->group_by('staff_name');
        $query = $this->db->get('invoice');
       
        return $query->result_array();
    }
}
