<?php

class Visits_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }

    function get_valid_visits(){
        
        $today = date('Y-m-d');
        $tomorrow= date('Y-m-d H:i:s', strtotime('tomorrow'));
        $this->db->select('*, date_format(visit_service_start, "%d-%m-%Y %H:%i") as mDate', false);
        $this->db->join('customer_visits', 'visit_services.customer_visit_id = customer_visits.id_customer_visits');
        $this->db->join('customers', 'customers.id_customers = customer_visits.customer_id');
        $this->db->where('visit_services.visit_service_start <', $tomorrow);
        $this->db->where('visit_services.visit_service_start >', $today);
        $this->db->where('visit_status <>', 'canceled');
        $this->db->where('customer_visits.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('visit_services.customer_visit_id');
        $query = $this->db->get('visit_services');
       
        return $query->result_array();
        
    }
    
    function get_visits() {
        $today = date('Y-m-d');
        $tomorrow= date('Y-m-d H:i:s', strtotime('tomorrow'));
        $this->db->select('*, date_format(visit_service_start, "%d-%m-%Y %H:%i") as mDate', false);
        $this->db->join('customer_visits', 'visit_services.customer_visit_id = customer_visits.id_customer_visits');
        $this->db->join('customers', 'customers.id_customers = customer_visits.customer_id');
        $this->db->where('visit_services.visit_service_start <', $tomorrow);
        $this->db->where('visit_services.visit_service_start >', $today);
        $this->db->where('visit_status =', 'open');
        $this->db->where('customer_visits.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('visit_services.customer_visit_id');
        $query = $this->db->get('visit_services');
       
        return $query->result_array();
    }
    
    
    function get_open_visits() {
        echo $this->session->userdata('businessid'); exit();
        $this->db->select('*, date_format(visit_service_start, "%d-%m-%Y %H:%i") as mDate', false);
        $this->db->join('customer_visits', 'visit_services.customer_visit_id = customer_visits.id_customer_visits');
        $this->db->join('customers', 'customers.id_customers = customer_visits.customer_id');
        $this->db->where('visit_status =', 'open');
        $this->db->where('customer_visits.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('visit_services.customer_visit_id');
        $this->db->order_by('date(visit_service_start)', 'desc', false);
        $query = $this->db->get('visit_services');
      
        return $query->result_array();
    }
    
    
    function open_visit_list() {
        $today=date('Y-m-d');
        
       
           $sql="SELECT id_customer_visits, id_customers, customer_name, customer_cell, visit_service_start, date_format(visit_service_start, '%d-%m-%Y %H:%i') as mDate 
                FROM customer_visits 
                JOIN visit_services ON visit_services.customer_visit_id = customer_visits.id_customer_visits 
                JOIN customers ON customers.id_customers = customer_visits.customer_id 
                WHERE visit_status = 'open' AND customer_visits.business_id = '".$this->session->userdata('businessid')."'
                and date(visit_service_start) <= '".$today."'
                group by id_customer_visits
                ORDER BY date(visit_service_start) DESC";
       
        
      
        $query=$this->db->query($sql);
        
        return $query->result_array();
    }
    
    function inservice_visit_list() {
        $today=date('Y-m-d');
        
        $sql="SELECT id_customer_visits, id_customers, customer_name, customer_cell, visit_service_start, date_format(visit_service_start, '%d-%m-%Y %H:%i') as mDate 
                FROM customer_visits 
                JOIN visit_services ON visit_services.customer_visit_id = customer_visits.id_customer_visits 
                JOIN customers ON customers.id_customers = customer_visits.customer_id 
                WHERE visit_status = 'open' AND customer_visits.business_id = '".$this->session->userdata('businessid')."'
                and inservice = 'Yes'
                group by id_customer_visits
                ORDER BY date(visit_service_start) DESC";
     
        
      
        $query=$this->db->query($sql);
        
        return $query->result_array();
    }
    
    function check_color($colorcode){
        $this->db->select('*');
        $this->db->where('visit_color', $colorcode);
        $this->db->where('visit_status', 'open');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customer_visits');
        return $query->row();
    }
    
    function update_visit(){
         // Unescape the string values in the JSON array
        $tableData = stripcslashes($this->input->post('visitdata', TRUE));
        $visitdate = stripslashes($this->input->post('visit-date', TRUE));

        // Decode the JSON array
        $tableData = json_decode($tableData,TRUE);
        
        // now $tableData can be accessed like a PHP array
        //echo $tableData[0]['servicename'];
        //echo $this->input->post('visitid');
        
        $visit_id = $this->input->post('visitid', TRUE);
        
        //update customer_visit
        
        $this->db->where('customer_visit_id', $visit_id);
        $this->db->delete('visit_services');
        
        $this->db->where('customer_visit_id', $visit_id);
        $this->db->delete('visit_service_staffs');
        
        $this->db->where('customer_visit_id', $visit_id);
        $this->db->delete('visit_service_products');
        
        // current date and time for the services
        $service_start_date_time = date('Y-m-d\TH:i:s', strtotime($visitdate));
        
        foreach($tableData as $row){
            
            $data = array(
                'business_id' => $this->session->userdata('businessid'),
                'customer_visit_id' => $visit_id,
                'service_id' => $row['serviceid'],
                'service_name' => $row['servicename'],
                'visit_service_start' => $service_start_date_time
            );
            
            $this->db->insert('visit_services', $data);
            
            $id_visit_services = $this->db->insert_id();
            
            $staff = array(
                'business_id' => $this->session->userdata('businessid'),
                'customer_visit_id' => $visit_id,
                'visit_service_id' => $id_visit_services,
                'staff_id' => $row['staffid'],
                'staff_name' => $row['staff']
            );
            $this->db->insert('visit_service_staffs', $staff);
            
            $product_ids = explode('|', $row['productid']);
            $product_names = explode('|', $row['productname']);
            
            $k = 0;
            foreach($product_ids as $product_id){
                if($product_id > 0 && !empty($product_id)){
                    $products = array(
                        'business_id' => $this->session->userdata('businessid'),
                        'customer_visit_id' => $visit_id,
                        'visit_service_id' => $id_visit_services,
                        'product_id' => $product_id,
                        'product_name' => $product_names[$k]
                    );
                    $this->db->insert('visit_service_products', $products);
                }
                $k++;
            }
           
            ///update staff status
            $this->db->set('staff_available', $visit_id);
            $this->db->where('business_id', $this->session->userdata('businessid'));
            $this->db->where('time_out', null);
            $this->db->where('staff_available', '');
            $this->db->where('staff_id', $row['staffid']);
            $this->db->update('staff_attendance');

        }
        
        return $visit_id;
    }
    
    function getinvoicedvisitbyid($visitid){
        
        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = customer_visits.customer_id');
        $this->db->join('visit_services', 'visit_services.customer_visit_id = customer_visits.id_customer_visits');
        $this->db->join('visit_service_products', 'visit_services.id_visit_services = visit_service_products.visit_service_id', 'left');
        $this->db->join('visit_service_staffs', 'visit_services.id_visit_services = visit_service_staffs.visit_service_id');
        $this->db->where('visit_services.customer_visit_id =', $visitid);
        $this->db->where('visit_status =', 'invoiced');
        //$this->db->where('customer_visits.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customer_visits');
       
        return $query->result_array();
    }
    
    function getopenvisitbyid($visitid){
        
        $this->db->select('*, DATE_FORMAT(vs.visit_service_start, "%Y-%m-%d %k:%i:%s") AS visitdate, DATE_FORMAT(cv.advance_date, "%d-%m-%Y %k:%i") AS advance_date, DATE_FORMAT(cv.advance_date, "%Y-%m-%d") AS check_date');
        $this->db->join('customers c', 'cv.customer_id = c.id_customers');
        $this->db->join('visit_services vs', 'vs.customer_visit_id = cv.id_customer_visits');
        $this->db->join('business_services bs', 'vs.service_id = bs.id_business_services');
        $this->db->join('service_category sc', 'bs.service_category_id = sc.id_service_category');
        $this->db->join('visit_service_products vsp', 'vs.id_visit_services = vsp.visit_service_id', 'left');
        $this->db->join('visit_service_staffs vss', 'vs.id_visit_services = vss.visit_service_id', 'left');
        $this->db->where('vs.customer_visit_id', $visitid);
        $this->db->where('cv.visit_status', 'open');
        $this->db->where('cv.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('vs.id_visit_services');
        $query = $this->db->get('customer_visits cv');
        //echo $query; exit();
        return $query->result_array();
    }
    function getopenvisitadvancebyid($visitid){
        
        $this->db->select('*, date_format(advance_date, "%d-%m-%Y %h:%i") as date', false);
        $this->db->where('customer_visit_id',$visitid);
        $query = $this->db->get('visit_advance');
        
        return $query->result_array();
        
    }
    function getopenvisitadvancesumbyid($visitid){
        
        $this->db->select('sum(advance_amount) as advance_amount', false);
        $this->db->where('customer_visit_id',$visitid);
        $query = $this->db->get('visit_advance');
        
        return $query->result_array();
        
    }
    
    function getopenvisitadvancecommentsbyid($visitid){
        
        $this->db->select('advance_remarks', false);
        $this->db->where('customer_visit_id',$visitid);
        $query = $this->db->get('visit_advance');
        
        return $query->result_array();
        
    }
    
    function getadvancevisitbyid($visitid){
        
        $this->db->select('*, DATE_FORMAT(vs.visit_service_start, "%Y-%m-%d %k:%i:%s") AS visitdate, DATE_FORMAT(cv.advance_date, "%d-%m-%Y %k:%i") AS advance_date');
        $this->db->join('customers c', 'cv.customer_id = c.id_customers');
        $this->db->join('visit_services vs', 'vs.customer_visit_id = cv.id_customer_visits');
        $this->db->join('business_services bs', 'vs.service_id = bs.id_business_services');
        $this->db->join('service_category sc', 'bs.service_category_id = sc.id_service_category');
        $this->db->join('visit_service_products vsp', 'vs.id_visit_services = vsp.visit_service_id', 'left');
        $this->db->join('visit_service_staffs vss', 'vs.id_visit_services = vss.visit_service_id');
        $this->db->where('vs.customer_visit_id', $visitid);
        //$this->db->where('cv.advance', 'true');
        $this->db->where('cv.visit_status <>', 'canceled');
        //$this->db->where('cv.business_id', $this->session->userdata('businessid'));
        $this->db->group_by('vsp.product_name');
        $query = $this->db->get('customer_visits cv');
        
        return $query->result_array();
    }
    
    
    function getvisitbyid($visitid){
        
        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = customer_visits.customer_id');
        $this->db->join('visit_services', 'visit_services.customer_visit_id = customer_visits.id_customer_visits');
        $this->db->where('customer_visit_id =', $visitid);
        $this->db->where('customer_visits.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customer_visits');
        return $query->result_array();
    }
    
    function getServicesByVisitId($id){
        
        $where = array(
            'business_id' => $this->session->userdata('businessid'),
            'customer_visit_id' => $id
        );
        
        $this->db->select('*');
        $this->db->where($where);
        $query = $this->db->get('visit_services');
        
        return $query->result_array();
        
    }
    
    function getvisitbycid(){
        $this->db->select('*');
        $this->db->join('visit_services', 'customer_visits.id_customer_visits = visit_services.customer_visit_id');
        $this->db->where('customer_visits.customer_id', $this->input->post('customer_id', TRUE));
        $this->db->where('customer_visits.visit_status', 'open');
        $this->db->where('customer_visits.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customer_visits');
        
        return $query->result_array();
    }
    
    function getpassedvisitbycid(){
        $today = date('Y-m-d');
        $this->db->select('*');
        $this->db->join('visit_services', 'customer_visits.id_customer_visits = visit_services.customer_visit_id');
        $this->db->where('customer_visits.customer_id', $this->input->post('customer_id', TRUE));
        $this->db->where('customer_visits.visit_status', 'open');
        $this->db->where('date(visit_services.visit_service_start) <=', $today);
        $this->db->where('customer_visits.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customer_visits');
        
        return $query->result_array();
    }
    
    function getvisitstaffs($visitid){
        $this->db->select('*');
        $this->db->where('customer_visit_id', $visitid);
        $query = $this->db->get('visit_service_staffs');
        return $query->result_array();
    }
    
    function getvisitserviceproducts($visitid){
        $this->db->select('*');
        $this->db->join('business_products','id_business_products = product_id');
        $this->db->where('customer_visit_id', $visitid);
        $query = $this->db->get('visit_service_products');
        return $query->result_array();
    }
    
    function getvisitservices($visitid){
 
        $this->db->select('id_visit_services, vs.business_id, vs.customer_visit_id, vs.service_id, vs.service_name, visit_service_start, date_format(visit_service_start,"%d-%m-%Y %H:%s") as "vdate", '
                . 'visit_service_end, update_date, service_flag, vs.id_service_category, id_business_services, service_category_id, '
                . 'service_desc, created_date, service_rate, service_active, commission_perc, '
                . 'service_color, service_duration, '
                . 'service_type_id, service_category, service_category_active, '
                . 'service_category_image, id_service_types, service_type, service_type_image, '
                . 'service_type_active, id_visit_service_staffs, visit_service_id, staff_id, staff_name, loyalty_service');
        $this->db->join('business_services bs', 'vs.service_id = bs.id_business_services');
        $this->db->join('service_category sc', 'sc.id_service_category = bs.service_category_id');
        $this->db->join('service_type st', 'sc.service_type_id = st.id_service_types');
        $this->db->join('visit_service_staffs ssf', 'vs.id_visit_services = ssf.visit_service_id');
        $this->db->where('vs.customer_visit_id', $visitid);
        //$this->db->where('vs.business_id', $this->session->userdata('businessid'));
        $this->db->where('vs.service_flag', 'servicetype');
        $this->db->group_by('ssf.visit_service_id');
        $subQuery1 = $this->db->get_compiled_select('visit_services vs');
        
        
        $this->db->select('id_visit_services, vs.business_id, vs.customer_visit_id, vs.service_id, vs.service_name, visit_service_start, date_format(visit_service_start,"%d-%m-%Y %H:%s") as "vdate", '
                . 'visit_service_end, update_date, service_flag, vs.id_service_category as "id_service_category", id_business_services, '
                . 'pc.id_package_category as "service_category_id", service_desc, created_date, '
                . 'ps.service_rate as  "service_rate", service_active, commission_perc, service_color, service_duration, '
                . 'pc.package_type_id as "service_type_id", service_category, '
                . 'service_category_active, service_category_image, id_package_type as "id_service_types", service_type, '
                . 'service_type_image, service_type_active, id_visit_service_staffs, visit_service_id, staff_id, staff_name, loyalty_service');
        $this->db->join('business_services bs', 'vs.service_id = bs.id_business_services');
        $this->db->join('package_services ps', 'vs.service_id = ps.service_id and vs.id_service_category=ps.package_category_id');
        $this->db->join('package_category pc', 'pc.id_package_category = ps.package_category_id');
        $this->db->join('package_type pt', 'pc.package_type_id = pt.id_package_type');
        $this->db->join('visit_service_staffs ssf', 'vs.id_visit_services = ssf.visit_service_id');
        $this->db->where('vs.customer_visit_id', $visitid);
       // $this->db->where('vs.business_id', $this->session->userdata('businessid'));
        $this->db->where('vs.service_flag', 'packagetype');        
        $this->db->group_by('ssf.visit_service_id');
        $subQuery2 = $this->db->get_compiled_select('visit_services vs');
        
        //echo $subQuery1;
        //echo $subQuery2; 
        $query = $this->db->query("select * from (".$subQuery1." UNION ".$subQuery2.") as unionTable order by visit_service_start");
        
        return $query->result_array();
    }
    
    function getlast4visits($customerid){
        $this->db->select('*, date_format(customer_visit_date,"%d-%m-%Y") as visit_date');
        $this->db->join('visit_services', 'visit_services.customer_visit_id = customer_visits.id_customer_visits');
        $this->db->where('customer_visits.business_id', $this->session->userdata('businessid'));
        $this->db->where('visit_status =', 'invoiced');
        $this->db->where('customer_visits.customer_id', $customerid);
        $this->db->order_by('customer_visits.id_customer_visits DESC, service_id ASC');
        $this->db->limit(4);
        $query = $this->db->get('customer_visits');
                
        return $query->result_array();
    }
    
    function getstaffclient($visitid){
        $this->db->select('customer_name, date_format(customer_visit_date,"%h:%i:%s") as "since", service_name');
        $this->db->join('customers', 'customers.id_customers = customer_visits.customer_id');
        $this->db->join('visit_services', 'visit_services.customer_visit_id = customer_visits.id_customer_visits');
        $this->db->where('customer_visits.business_id', $this->session->userdata('businessid'));
        $this->db->where('visit_status =', 'open');
        $this->db->where('id_customer_visits', $visitid);
        
        $query = $this->db->get('customer_visits');
        
        
        return $query->result_array();
    }
    
    
    function update_advance(){
        
        $today = date('Y-m-d H:i');
        
        $visitid=$this->input->post('visit_id', TRUE);
        $amount=$this->input->post('advance_amount', TRUE);
        $mode=$this->input->post('advance_mode', TRUE);
        $inst=$this->input->post('advance_inst', TRUE);
        $comment=$this->input->post('advance_comment', TRUE);
        
        
       // if ((float)$amount>0){
            $this->db->set('advance_amount', $amount);
            $this->db->set('customer_visit_id', $visitid);
            $this->db->set('advance_mode', $mode);
            $this->db->set('advance_date', $today);
            $this->db->set('advance_inst', $inst);
            $this->db->set('advance_remarks', $comment);
            $this->db->set('advance_user', $this->session->userdata('username'));
            if(null!==$this->input->post('advance_cc_charge')){
                $this->db->set('advance_cc_charge', $this->input->post('advance_cc_charge'));
            }
            
            $this->db->insert('visit_advance');
        //}
        
        
        ////update visit
        
        $this->db->set('advance', 'true');            
        $this->db->where('id_customer_visits', $visitid);
        //$this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->update('customer_visits');
        
        
        
        return $visitid;
        
    }
    
    function update_advance_old(){
        
        $today = date('Y-m-d H:i');
        
        $visitid=$this->input->post('visit_id', TRUE);
        $amount=$this->input->post('advance_amount', TRUE);
        $mode=$this->input->post('advance_mode', TRUE);
        $inst=$this->input->post('advance_inst', TRUE);
        $comment=$this->input->post('advance_comment', TRUE);
        
        $this->db->set('advance_amount', $amount);
        if ((float)$amount>0){
            $this->db->set('advance', 'true');
            $this->db->set('advance_mode', $mode);
            $this->db->set('advance_date', $today);
            $this->db->set('advance_inst', $inst);
            $this->db->set('advance_comment', $comment);
        }
        $this->db->where('id_customer_visits', $visitid);
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->update('customer_visits');
        
        return $visitid;
        
    } 
    
    
    function remove_advance(){
        
        $today = date('Y-m-d');
        
        $advanceid=$this->input->post('advance_id', TRUE);
    //    $visitid=$this->input->post('visit_id', TRUE);
        
        $this->db->select('*, date_format(advance_date, "%Y-%m-%d") as advdate');
        $this->db->where('id_visit_advance',$advanceid);
      //  $this->db->where('customer_visit_id',$visitid);
        $query = $this->db->get('visit_advance');
       
        $result=$query->row();
        
        if(isset($result->advdate)){
            if($result->advdate == $today){
                $this->db->where('id_visit_advance', $advanceid);
                $this->db->set('advance_amount',0);
             //   $this->db->where('customer_visit_id', $visitid);
                $this->db->update('visit_advance');

                echo 'Advance removed!';
            } else {
                echo 'Advances booked on previous dates can not be removed!';
            }
        } else {
            echo "Advance does not exist!";
        }
        
       
        
    } 
    
    public function create_booking(){
        
         //add new customer_visit
        $visit = array(
            'business_id' => $this->session->userdata('businessid'),
            'customer_id' => $this->input->post('customer_id'),
            'customer_visit_date' => date('Y-m-d H:i:s'),
            'visit_color' => $this->input->post('visit_color'),
            'visit_color_type' => $this->input->post('visit_color_type'),
            'advance' => $this->input->post('advance'),
            'advance_amount' => $this->input->post('advance_amount'),
            'advance_mode' => $this->input->post('advance_mode'),
            'advance_inst' => $this->input->post('advance_inst'),
            'advance_date' => date('Y-m-d H:i:s'),
            'advance_comment' => $this->input->post('visit_remarks'),
            'customer_visit_date'=>date('Y-m-d H:i:s'),
            'created_by'=>$this->session->userdata('username')
        );
        $this->db->insert('customer_visits', $visit);
        $visit_id = $this->db->insert_id();
        
        
        // Unescape the string values in the JSON array
        $tableData = stripcslashes($this->input->post('tabledata', TRUE));
        
        // Decode the JSON array
        $tableData = json_decode($tableData,TRUE);
        //print_r($tableData);echo('<br>');
        // now $tableData can be accessed like a PHP array
        // echo $tableData[0]['category'];
        
        $data = [];
        //process the table data
        foreach($tableData as $row){
            
            $id_package_type=$this->input->post('package_type_id');
            
            $this->db->select('*');
            $this->db->join('business_services', 'business_services.id_business_services=package_services.service_id');
            $this->db->where('package_category_id', $row['category_id']);
            $this->db->where('package_services_active', "Yes");
            $this->db->where('business_id', $this->session->userdata('businessid'));
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
                    'business_id' => $this->session->userdata('businessid'),
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
                    'business_id' => $this->session->userdata('businessid'),
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
                $this->db->where('business_id', $this->session->userdata('businessid'));
                $service_products=$this->db->get('services_products');
                
                foreach($service_products->result() as $sp){
                    $products = array(
                        'business_id' => $this->session->userdata('businessid'),
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
        }
        
        ///add advance
        $adv=array(
            'customer_visit_id' => $visit_id,
            'advance_amount' => $this->input->post('advance_amount'),
            'advance_mode' => $this->input->post('advance_mode'),
            'advance_inst' => $this->input->post('advance_inst'),
            'advance_date' => date('Y-m-d H:i:s'),
            'advance_user' => $this->session->userdata('username')
        );
        $this->db->insert('visit_advance', $adv);
        
        return "success|".$visit_id;
        
    }
    
    public function getpackagedays($visitid){
        
        $this->db->select("id_service_category, service_category, date_format(visit_service_start, '%W, %D %M %Y %h:%i %p') as visit_date");
        $this->db->join("package_category pc", "pc.id_package_category = visit_services.id_service_category");
        $this->db->where("customer_visit_id=",$visitid);
        $this->db->group_by("id_service_category, service_category");
        $query = $this->db->get('visit_services');
       
        return $query->result_array();

    }
    function reminder_message_update(){
        
        
        $data = array(
            'reminder_sms' => $this->input->post('reminder_sms'),
            'reminder_email' => $this->input->post('reminder_email'),
            'reminder_call' => $this->input->post('reminder_call')
        );
        //print_r($data);exit;
        $this->db->where('id_customer_visits', $this->input->post('customer_visit_id'));
        $this->db->update('customer_visits', $data);
        return $this->db->affected_rows();
    }
    
    function mark_inservice($visitid){
        $today = date('Y-m-d H:i:s');
        
        $data = array(
            'inservice' => 'Yes',
            'inservice_time' => $today
        );
        $this->db->where('id_customer_visits', $visitid);
        $this->db->update('customer_visits', $data);
        
        
        $data1 = array(
            'update_date' => $today
        );
        $this->db->where('customer_visit_id', $visitid);
        $this->db->update('visit_services', $data1);
        
        return $today;
        
    }
    
    function add_visit_remarks($visitid, $visitremarks){
        
        $data = array(
            'advance_comment' =>   $visitremarks          
        );
        $this->db->where('id_customer_visits', $visitid);
        $this->db->update('customer_visits', $data);
        return $this->db->affected_rows();
    }
    
    function getvisitserviceids($visitid){
        
        $this->db->select('id_visit_services');        
        $this->db->where('customer_visit_id', $visitid);
        $query = $this->db->get('visit_services');
        return $query->result_array();
        
    }
}
