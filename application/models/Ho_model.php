<?php

class Ho_model extends CI_Model {

    function __construct() {

        // Call the Model constructor
        parent::__construct();
    }

    function get_package_types() {
        
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('service_type_active', 'yes');
        $this->db->order_by('order_id', 'ASC');
        $query = $this->db->get('package_type');
        
        
        return $query->result_array();
    }
    
    function staff_list($off_set=0, $limit=0) {
        $this->db->select('*');
        //$this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('staff_active', 'Y');
        $this->db->where('staff_scheduler', 'On');
        $this->db->order_by('staff_order', 'ASC');
        $this->db->offset($off_set);
        if($limit>0){
            $this->db->limit($limit);
        }
        $query = $this->db->get('staff');
       // echo $query; exit();
        return $query->result();
    }
    
    function get_active_staff(){
        $this->db->select('*');
        //$this->db->where('s.business_id', $this->session->userdata('businessid'));
        $this->db->where('s.staff_active', 'Y');
        $this->db->order_by('staff_fullname');
        $query = $this->db->get('staff s');

        return $query->result_array();
        
    }
    function get_package_category($ptype){
        
        $this->db->select('id_package_category, service_type, package_type_id,package_category.order_id,service_category, package_category.business_id, service_category_active, service_category_image, ifnull(sum(package_services.service_rate),0) as Price, package_category.order_id as cat_order_id, business_name, package_category.business_id ', false);
        $this->db->join('package_type','package_type.id_package_type = package_category.package_type_id');
        $this->db->join('package_services','package_services.package_category_id = package_category.id_package_category', 'left');
        $this->db->join('business','business.id_business= package_category.business_id');
        $this->db->where('package_type_id', $ptype);
        $this->db->where('service_category_active', 'Yes');
        //$this->db->where('business_id', $this->session->userdata('businessid'));
         $query = $this->db->group_by('id_package_category');
        $query = $this->db->get('package_category');
        return $query->result_array();
    }
    
    public function create_booking(){
        
         //add new customer_visit
        $booking = array(
            'business_id'=>$this->session->userdata('businessid'),
            'customer_id'=>$this->input->post('customer_id'),
            'package_id'=>$this->input->post('package_id')
        );
        $this->db->insert('bookings', $booking);
        $booking_id = $this->db->insert_id();
        
        
        
        // Unescape the string values in the JSON array
        $tableData = stripcslashes($this->input->post('tabledata', TRUE));
        
        // Decode the JSON array
        $tableData = json_decode($tableData,TRUE);
        //var_dump($tableData);echo('<br>');
        // now $tableData can be accessed like a PHP array
        // echo $tableData[0]['category'];
        //exit();
        $data = [];
        //process the table data
        foreach($tableData as $row){
            ///create visit for each package category row         
            $visit = array(
                'business_id' => $row['businessid'],
                'customer_id' => $this->input->post('customer_id'),
                'customer_visit_date' => date('Y-m-d H:i:s', strtotime($row['day'].' '.$row['hour'])),
                'visit_color' => $this->input->post('visit_color'),
                'visit_color_type' => $this->input->post('visit_color_type'),
                'advance_comment' => $row['remarks'],
                'referring_staff' => $this->input->post('referring_staff'),
                //'customer_visit_date'=>date('Y-m-d H:i:s'),
                   'created_by'=>$this->session->userdata('username')
               // 'advance' => $this->input->post('advance'),
               // 'advance_amount' => $this->input->post('advance_amount'),
               // 'advance_mode' => $this->input->post('advance_mode'),
               // 'advance_inst' => $this->input->post('advance_inst'),
               // 'advance_date' => date('Y-m-d H:i:s'),
               // 'advance_comment' => $this->input->post('visit_remarks')
            );
            $this->db->insert('customer_visits', $visit);
            $visit_id = $this->db->insert_id();
            //Add visit to booking
            $booking_visit = array(
                'booking_id'=>$booking_id,
                'visit_id'=>$visit_id,
                'category_id'=>$row['category_id']
            );
            $this->db->insert('booking_visits', $booking_visit);
           // $booking_id = $this->db->insert_id();
            
            
            ////Add visit services
            $id_package_type = $this->input->post('package_type_id');
            
            $this->db->select('*');
            $this->db->join('business_services', 'business_services.id_business_services=package_services.service_id');
            $this->db->where('package_category_id', $row['category_id']);
            $this->db->where('package_services_active', "Yes");
            //$this->db->where('business_id', $this->session->userdata('businessid'));
            $visit_services=$this->db->get('package_services');
            
            $service_flag="packagetype";
            $start = date('Y-m-d\TH:i:s', strtotime($row['day'].' '.$row['hour']));
            
            $i = 0; $lastduration=0; $newtime='';
            foreach($visit_services->result() as $vs){
                //get service start time
                if($i>0){ 
                    
                    $durCal =  explode(':',$lastduration);
                    $HoursInMin=0;
                    if(intval($durCal[0]) > 0){$HoursInMin = intval($durCal[0])*60;}
                    $newduration = $HoursInMin + $durCal[1]; 
                    $newduration = date_interval_create_from_date_string($newduration.' minutes');
                    $newstart=date_create($newtime);
                    $newtime=date_add($newstart, $newduration);
                    $newtime=date_format($newtime,"c");
                    $d=  explode('+', (string)$newtime);
                    $newtime=$d[0];
                    $lastduration=$vs->service_duration;
                } else {
                   $newtime=$start;
                   $lastduration=$vs->service_duration;
                }
               //print_r($newtime);echo('<br>');
               // service start time in $newtime
               
               $data = array(
                    'business_id' => $row['businessid'],
                    'customer_visit_id' => $visit_id,
                    'service_id' => $vs->service_id,
                    'service_name' => $vs->service_name,
                    'service_flag' => $service_flag,
                    'id_service_category' => $vs->package_category_id,
                    'visit_service_start' => $newtime, //$start
                    'update_date' => date('Y-m-d H:i:s')
                );
               
                $this->db->insert('visit_services', $data);
                $id_visit_services = $this->db->insert_id();
                
                //check shared staff
                $block_other='No';
                    
                $this->db->select('staff_shared');
                $this->db->where('id_staff=',$row['staffid']);
                $query = $this->db->get('staff');
                $blockstaff = $query->row();

                if (isset($blockstaff))
                { $block_other =  $blockstaff->staff_shared; }
                
                //insert service staff 
                $staff = array(
                    'business_id' => $row['businessid'],
                    'customer_visit_id' => $visit_id,
                    'visit_service_id' => $id_visit_services,
                    'staff_id' => $row['staffid'],
                    'staff_name' => $row['staffname'],
                    'block_other'=>$block_other
                );
                $this->db->insert('visit_service_staffs', $staff);
               
               //insert service products
                
                $this->db->select('*');
                $this->db->join('business_products', 'business_products.id_business_products = services_products.business_product_id');
                $this->db->where('business_service_id', $vs->service_id);
                //$this->db->where('business_id', $this->session->userdata('businessid'));
                $service_products=$this->db->get('services_products');
                
                foreach($service_products->result() as $sp){
                    $products = array(
                        'business_id' => $row['businessid'],
                        'customer_visit_id' => $visit_id,
                        'visit_service_id' => $vs->service_id,
                        'product_id' => $sp->business_product_id,
                        'product_name' => $sp->product,
                        'product_qty' => $sp->usage_qty,
                        'product_unit' => $sp->measure_unit
                     );
                     $this->db->insert('visit_service_products', $products);
                   // print_r($products);echo('<br>');
                     
                     
                    
                }
                $i++;
            }
             ///add advance
            $adv=array(
                'customer_visit_id' => $visit_id,
                'advance_amount' => $row['advance'],
                'advance_mode' => $row['mode'],
                'advance_inst' => $row['instrument'],
                'advance_date' => date('Y-m-d H:i:s', strtotime($row['advance_date'].' '.date("H:i:s", time()))),
                'advance_user' => $this->session->userdata('username')
            );
            $this->db->insert('visit_advance', $adv);
        }
        
        return "success|".$booking_id ;
        
    }
    
    
    public function getbookings(){
        $today = date('Y-m-d');
        
//        $query1 = $this->db->query($sql="SELECT 
//            `id_customer_visits` `visit_id`, 
//            `service_type`, 
//            `service_category`, 
//            `customer_name`, 
//            `customer_cell`, 
//            `customer_email`, 
//            va.advance_amount, 
//            customer_visits.advance_mode, 
//            date_format(visit_service_start, '%d-%c-%Y %h:%i %p') as visit_date,
//            customer_visits.customer_visit_date as 'date' 
//            FROM `customer_visits` 
//            JOIN `visit_services` ON `customer_visits`.`id_customer_visits` = `visit_services`.`customer_visit_id` 
//            JOIN `package_category` `pc` ON `pc`.`id_package_category` = `visit_services`.`id_service_category` 
//            JOIN `package_type` `pt` ON `pt`.`id_package_type` = `pc`.`package_type_id` 
//            JOIN `customers` ON `customers`.`id_customers` = `customer_visits`.`customer_id` 
//            JOIN (
//            select id_customer_visits customer_visit_id,  sum(visit_advance.advance_amount) advance_amount
//            from customer_visits
//            JOIN visit_advance ON customer_visits.id_customer_visits = visit_advance .customer_visit_id 
//            group by id_customer_visits
//            ) va ON customer_visits.id_customer_visits = va.customer_visit_id 
//            WHERE `visit_status` = 'open' 
//            AND `service_flag` = 'packagetype' 
//            AND `visit_service_start` >= '".$today."' 
//           
//            GROUP BY `id_customer_visits`,
//            `customer_name`, `customer_cell`, 
//            `customer_email`, customer_visits.advance_mode
//            ");
        
        $query = $this->db->query("SELECT *, a.advance_amount as advance_amount, date_format(customer_visit_date, '%d-%c-%Y %h:%i %p') as visit_date FROM bookings
                join booking_visits bv on bv.booking_id = bookings.id_bookings
                join customer_visits cv on cv.id_customer_visits = bv.visit_id
                join customers on customers.id_customers =bookings.customer_id
                join package_type pt on pt.id_package_type = bookings.package_id
                join package_category pc on pt.id_package_type = pc.package_type_id 
                and bv.category_id= pc.id_package_category
                join (
                        select customer_visit_id, sum(advance_amount) as advance_amount
                        from visit_advance
                        group by customer_visit_id
                ) as a on a.customer_visit_id=cv.id_customer_visits
                WHERE `visit_status` = 'open'                
                order by id_bookings, customer_visit_date desc
               ");
        //AND `customer_visit_date` >= '".$today."'  //Needs to be added to where clause
        return $query->result_array();
    }
    
    
    function getavisitsbybookingid($bookingid){
        
        $query = $this->db->query("SELECT *, date_format(customer_visit_date, '%d-%c-%Y %h:%i %p') as visit_date  FROM bookings
        join booking_visits  on booking_visits.booking_id = bookings.id_bookings
        join customer_visits  on customer_visits.id_customer_visits = booking_visits.visit_id
        join customers on customers.id_customers = customer_visits.customer_id
        join package_type on package_type.id_package_type = bookings.package_id
        join package_category on package_type.id_package_type = package_category.package_type_id and booking_visits.category_id= package_category.id_package_category
        join (
                select customer_visit_id, sum(advance_amount) as advance_amount
                from visit_advance
                group by customer_visit_id
        ) as a on a.customer_visit_id=customer_visits.id_customer_visits
        where bookings.id_bookings=".$bookingid."");
        
        return $query->result_array();
    }
    
    
    ////settings
    function get_all_package_types() {
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->order_by('order_id', 'ASC');
        $query = $this->db->get('package_type');

        return $query->result_array();
    }
    
    function add_package_type() {
        $this->db->insert('package_type', array(
            'service_type' => $this->input->post('service_type'),
            'service_type_active' => $this->input->post('service_type_active'),
            'business_id' => $this->session->userdata('businessid'),
            'order_id' => 1
        ));

        return $this->db->insert_id();
    }

    function update_packages_type() {
        $this->db->where('id_package_type', $this->input->post('id_package_type'));
        $this->db->update('package_type', array(
            'service_type' => $this->input->post('service_type'),
            'service_type_active' => $this->input->post('service_type_active'),
        ));

        return $this->db->affected_rows();
    }

    function add_package_category() {
        $this->db->insert('package_category', array(
            'service_category' => $this->input->post('service_category'),
            'service_category_active' => $this->input->post('service_category_active'),
            'package_type_id' => $this->input->post('package_type_id'),
            'business_id' => $this->input->post('business_id'),
            'order_id' => 1
        ));

        return $this->db->insert_id();
    }

    function update_package_category() {
        $this->db->where('id_package_category', $this->input->post('id_package_category'));
        $this->db->update('package_category', array(
            'service_category' => $this->input->post('service_category'),
            'service_category_active' => $this->input->post('service_category_active')
        ));

        return $this->db->affected_rows();
    }
    function edit_package_category(){
        $this->db->select('*');
       
        $this->db->where('pc.id_package_category', $this->input->post('id_package_category'));
        $query = $this->db->get('package_category pc');

        return $query->row();
    }
    
   public function change_date($date, $visit_service_id, $customer_visit_id){
        
               
        $this->db->select("substr(visit_service_start, LOCATE('T',visit_service_start), length(visit_service_start)) as vss", False);
        $this->db->select("substr(visit_service_end, LOCATE('T',visit_service_end), length(visit_service_end)) as vse", False);
        $this->db->where('id_visit_services=', $visit_service_id);
        $query=$this->db->get('visit_services');
        
        $row = $query->row();
        
        if($row->vse !== ''){
            $data = array(
                'visit_service_start' => $date.$row->vss,                
                'visit_service_end' => $date.$row->vse
            );
        } else {
            
            $data = array(
                'visit_service_start' => $date.$row->vss
            );
        }
        
        $this->db->where('id_visit_services=', $visit_service_id);
        $query=$this->db->update('visit_services', $data);
        
        $data = array(
                'customer_visit_date' => $date.$row->vss
            );
        $this->db->where('id_customer_visits=', $customer_visit_id);
        $query=$this->db->update('customer_visits', $data);
        
        
        return $this->db->affected_rows();
   
    }
    
    function cancelBooking($bookingid, $cancelreason='') {
        
        $this->db->select('id_customer_visits');
        $this->db->join('booking_visits','id_customer_visits = visit_id');
        $this->db->where('booking_id=', $bookingid);
        $query = $this->db->get('customer_visits');
        $visits =  $query->result_array();
        
        $canceledby=$this->session->userdata('username');
        
        if($cancelreason==''){            
            $cancelreason=$this->input->post('cancelreason');            
        }
        
        foreach($visits as $visit){
            $where = array(

                'id_customer_visits' => $visit['id_customer_visits']
            );

            $this->db->where($where);
            $query = $this->db->update('customer_visits', array('visit_status' => 'canceled', 'cancelreason' => $cancelreason, 'canceled_by' => $this->session->userdata('username')));
        }
        return $bookingid;
    }
    
    function booking_report($start, $end, $staff){
       if($start==null){
            $start= date('Y-m-d');
        }
        
        $sql = "SELECT id_bookings, customer_name, customer_cell, 
                date_format(booking_date,'%d-%m-%Y %h:%i') booking_date, date_format(customer_visit_date,'%d-%m-%Y %h:%i') visit_date, 
                referring_staff, package_category.service_category, sum(package_services.service_rate) as 'Total'
                , adv.advance advance, customer_visits.created_by, visit_status
                FROM booking_visits
                join bookings on bookings.id_bookings= booking_visits.booking_id
                join customer_visits on customer_visits.id_customer_visits = booking_visits.visit_id
                join visit_services on visit_services.customer_visit_id = customer_visits.id_customer_visits
                join package_services on package_services.service_id = visit_services.service_id 
                and visit_services.id_service_category=package_services.package_category_id
                join package_category on package_category.id_package_category = package_services.package_category_id
                join business_services on visit_services.service_id = business_services.id_business_services
                join customers on customers.id_customers = bookings.customer_id
                left join (
                        select customer_visit_id, ifnull(sum(advance_amount),0) advance
                        from visit_advance group by customer_visit_id
                ) as adv on adv.customer_visit_id = customer_visits.id_customer_visits
                where 1=1 ";
        if($staff!==null && $staff!=='All'){
        $sql.=" and customer_visits.created_by = '".$staff."' ";
        }
        if($start!==null){
        $sql.=" and bookings.booking_date >='".$start." 23:59:59' ";
           }
        if($end!==null){
        $sql.=" and bookings.booking_date <='".$end." 23:59:59' ";
        }
        $sql.="  group by booking_id";
        
       // echo $sql; exit();
        $query = $this->db->query($sql);
        return $query->result_array();
        
    }
}