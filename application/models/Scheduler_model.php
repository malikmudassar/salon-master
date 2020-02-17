<?php

class Scheduler_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    /*
     * Developer: Tahir Khan Afridi
     * Work Started
     */

    function get_blocking_events() {
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('block_events');
        return $query->result();
    }

    function update_block_event($id, $data) {
        $where = array(
            'business_id' => $this->session->userdata('businessid'),
            'block_time_event_id' => $id
        );
        $this->db->where($where);
        $query = $this->db->update('block_staff_time', $data);
        return $query;
    }

    function get_staff_blocked_events($start, $end) {
        $this->db->select('*');
        $this->db->join('block_events be', 'bst.block_event_id = be.id_block_events');
        $this->db->where('bst.business_id', $this->session->userdata('businessid'));
        $this->db->where('bst.start_time >', $start);
        $this->db->where('bst.end_time <', $end);
        $query = $this->db->get('block_staff_time bst');
        return $query->result();
    }

    function remove_staff_block_time($block_time_event_id) {
        $this->db->where('block_time_event_id', $block_time_event_id);
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->delete('block_staff_time');
        return $query;
    }

    function check_block_time($staff_id, $start) {
        $start = str_replace('T', ' ', $start);
        $this->db->select("*");
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('staff_id', $staff_id);
        $this->db->where('CAST(start_time AS DATETIME) <=', $start);
        $this->db->where('CAST(end_time AS DATETIME) >', $start);
        $query = $this->db->get('block_staff_time');
        return $query->row();
    }

    function add_staff_block_time($data) {
        $this->db->insert('block_staff_time', $data);
        $insert_id = $this->db->insert_id();

        $this->db->where('id_staff_time_blocked', $insert_id);
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->update('block_staff_time', array('block_time_event_id' => 'b' . $insert_id));

        return $insert_id;
    }

    function get_total_net_amount($staff_name, $calendar_date) {

        $today = $calendar_date;

        $datetime = new DateTime($today);
        $datetime->modify('+1 day');

        $tomorrow = $datetime->format('Y-m-d H:i:s');

        $this->db->select('SUM(ind.price) AS netAmount, SUM(in.balance) AS totalBalance, SUM(in.discount) AS totalDiscount');
        $this->db->join('invoice_details ind', 'in.id_invoice = ind.invoice_id');
        $this->db->where('in.business_id', $this->session->userdata('businessid'));
        $this->db->where('in.invoice_status', 'valid');
        $this->db->where('in.invoice_type', 'service');
        $this->db->where('ind.staff', $staff_name);
        //$this->db->where('ind.service_category', $service_category_name);
        $this->db->where('in.invoice_date >', $today);
        $this->db->where('in.invoice_date <', $tomorrow);

        //$this->db->group_by('ind.staff');
        //$this->db->group_by('ind.service_category');

        $query = $this->db->get('invoice in');

        return $query->row();
    }

    function get_net_amount($service_name, $staff_name, $calendar_date) {

        $today = $calendar_date;

        $datetime = new DateTime($today);
        $datetime->modify('+1 day');

        $tomorrow = $datetime->format('Y-m-d H:i:s');

        $this->db->select('SUM(ind.discounted_price) AS netAmount, SUM(ind.discount) AS discountSum');
        $this->db->join('invoice_details ind', 'inv.id_invoice = ind.invoice_id');
        $this->db->where('inv.business_id', $this->session->userdata('businessid'));
        $this->db->where('inv.invoice_status', 'valid');
        $this->db->where('inv.invoice_type', 'service');
        //$this->db->where('ind.staff', $staff_name);
        $this->db->where('ind.service_name', $service_name);
        $this->db->where('inv.invoice_date >', $today);
        $this->db->where('inv.invoice_date <', $tomorrow);
        $this->db->like('ind.staff', $staff_name);

        $query = $this->db->get('invoice inv');

        return $query->row();
    }

    function single_service_count($service_name, $staff_id, $calendar_date) {
        $today = $calendar_date;

        $datetime = new DateTime($today);
        $datetime->modify('+1 day');

        $tomorrow = $datetime->format('Y-m-d H:i:s');

        $this->db->select('COUNT(id_staff_services) AS servicecount');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('service_name', $service_name);
        $this->db->where('staff_id', $staff_id);
        $this->db->where('staff_service_date >', $today);
        $this->db->where('staff_service_date <', $tomorrow);
        $this->db->where('visit_id !=', '');
        //$this->db->group_by('service_category');

        $query = $this->db->get('staff_services');

        return $query->row();
    }

    function provided_services_list($staff_id, $calendar_date) {

        $today = $calendar_date;

        $datetime = new DateTime($today);
        $datetime->modify('+1 day');

        $tomorrow = $datetime->format('Y-m-d H:i:s');

        $this->db->select("*");
        $this->db->where('staff_id', $staff_id);
        $this->db->where('staff_service_date >', $today);
        $this->db->where('staff_service_date <', $tomorrow);
        $this->db->where('visit_id !=', '');
        $this->db->group_by('service_name');
        $query = $this->db->get('staff_services');

        return $query->result();
    }

    function total_products_sold($staff_name, $calendar_date) {
        $today = $calendar_date;
        $datetime = new DateTime($today);
        $datetime->modify('+1 day');
        $tomorrow = $datetime->format('Y-m-d H:i:s');

        $this->db->select('SUM(invp.discounted_price) AS totalSale,count(invp.id_invoice_products) as retailcount');
        $this->db->join('invoice_products invp', 'inv.id_invoice = invp.invoice_id');
        $this->db->where('inv.business_id', $this->session->userdata('businessid'));
        $this->db->where('inv.invoice_status', 'valid');
        $this->db->where('inv.invoice_type', 'sale');
        $this->db->where('invp.staff_name', $staff_name);
        $this->db->where('inv.invoice_date >', $today);
        $this->db->where('inv.invoice_date <', $tomorrow);
        $query = $this->db->get('invoice inv');
        return $query->row();
    }

    function total_services_provided($staff_id, $calendar_date) {

        $today = $calendar_date;

        $datetime = new DateTime($today);
        $datetime->modify('+1 day');

        $tomorrow = $datetime->format('Y-m-d H:i:s');

        $this->db->select('COUNT(id_staff_services) AS totalservices');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('staff_id', $staff_id);
        $this->db->where('staff_service_date >', $today);
        $this->db->where('staff_service_date <', $tomorrow);
        $this->db->where('sale_type', 'service');

        $query = $this->db->get('staff_services');

        return $query->row();
    }

//    function total_services_provided($staff_id){
//        
//        $where = array(
//            'vs.business_id' => $this->session->userdata('businessid'),
//            'cv.business_id' => $this->session->userdata('businessid'),
//            'cv.visit_status' => 'invoiced',
//            'vs.staff_ids' => $staff_id
//        );
//        
//        $this->db->select('vs.staff_names, COUNT(vs.staff_ids) as totalservices');
//        $this->db->join('customer_visits cv', 'vs.customer_visit_id = cv.id_customer_visits');
//        $this->db->where($where);
//        $query = $this->db->get('visit_services vs');
//        
//        return $query->row();
//        
//    }

    function staff_details($staff_id) {

        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('id_staff', $staff_id);
        $query = $this->db->get('staff');

        return $query->row();
    }

    function getvoucherbyid($voucher_id) {
        $this->db->select('*, date_format(voucher_date,"%d-%m-%Y") as formatted_voucher_date, date_format(valid_until,"%d-%m-%Y") as formatted_valid_until');
        $this->db->join('customers c', 'ov.customer_id = c.id_customers');
       // $this->db->where('ov.business_id', $this->session->userdata('businessid'));
        $this->db->where('ov.id_order_vouchers', $voucher_id);
        $query = $this->db->get('order_vouchers ov');

        return $query->row();
    }

    function getvoucherservices($ids) {

        $this->db->select('*');
        $this->db->join('service_category sc', 'sc.id_service_category = bs.service_category_id');
        $this->db->where_in('bs.id_business_services', $ids);
        $this->db->where('bs.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('business_services bs');

        return $query->result();
    }

    function check_voucher_number($voucherno) {
        $this->db->select("*");
        $this->db->where('voucher_number', $voucherno);
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('order_vouchers');
        return $query->num_rows();
    }

    function insert_voucher() {

        
        $customer_id = htmlspecialchars($this->input->post('customer_id', TRUE));
        $type = htmlspecialchars($this->input->post('type', TRUE));
        $price = htmlspecialchars($this->input->post('price', TRUE));
        $valid_until = htmlspecialchars($this->input->post('valid_until', TRUE));
        $voucher_number = htmlspecialchars($this->input->post('voucher_number_option', TRUE));
        $service_ids = htmlspecialchars($this->input->post('service_ids', TRUE));
        $service_names = htmlspecialchars($this->input->post('service_names', TRUE));
        $payment_mode = htmlspecialchars($this->input->post('payment_mode', TRUE));
        $instrument_number = htmlspecialchars($this->input->post('instrument_number', TRUE));
        $voucher_date = date('Y-m-d H:i:s');
        $voucher_heading=htmlspecialchars($this->input->post('voucher_heading', TRUE));
        
        $paid_cash=0; $paid_card=0; $paid_check=0;
        
        if($payment_mode=="Cash"){
            $paid_cash=$price;
        } else if($payment_mode=="Card"){
            $paid_card=$price;
        } else if($payment_mode=="Check"){
            $paid_check=$price;
        }
        
        

        $data = array(
            'business_id' => $this->session->userdata('businessid'),
            'customer_id' => $customer_id,
            'voucher_number' => 'C'.$voucher_number,
            'type' => $type,
            'amount' => $price,
            'remaining_amount' => $price,
            'service_ids' => $service_ids,
            'service_names' => $service_names,
            'remaining_service_ids' => $service_ids,
            'voucher_date' => $voucher_date,
            'valid_until' => $valid_until . ' 23:59:59',
            'payment_mode' => $payment_mode,
            'instrument_number' => $instrument_number,
            'voucher_heading' => $voucher_heading,
            'paid_cash' => $paid_cash,
            'paid_card' => $paid_card,
            'paid_check' => $paid_check,
            'created_by' => $this->session->userdata('username')
        );

        $this->db->insert('order_vouchers', $data);
        
        $voucher_id = $this->db->insert_id();
        
        if (empty($voucher_number)) {
           $this->db->set('voucher_number','C'.$voucher_id);
           $this->db->where('id_order_vouchers',$voucher_id);
           $this->db->update('order_vouchers');
            
           $voucher_number='C'.$voucher_id;
        }
        
        return $voucher_id . '|' . $voucher_number;
    }

    function get_all_staff() {

        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->order_by('id_staff', 'ASC');
        $query = $this->db->get('staff');

        return $query->result();
    }

    function get_color_numbers_by_type_id($type_id) {

        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('type_id', $type_id);
        $this->db->where('status', 'Yes');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('color_number');

        return $query->result();
    }

    function getcolortypes() {

        $where = array(
            'business_id' => $this->session->userdata('businessid'),
            'status' => 'Yes'
        );

        $this->db->select('*');
        $this->db->where($where);
        $query = $this->db->get('color_types');

        return $query->result();
    }

    function getopenorderbyid($orderid) {

        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = customer_orders.customer_id');
        $this->db->join('order_products', 'order_products.customer_order_id = customer_orders.id_customer_order', 'left');
        $this->db->join('business_products', 'business_products.id_business_products = order_products.product_id');
        $this->db->where('id_customer_order =', $orderid);
        $this->db->where('order_status =', 'open');
        $this->db->where('customer_orders.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customer_orders');
        return $query->result_array();
    }

    function getorderbyid($orderid) {

        $this->db->select('*');
        $this->db->join('customers', 'customers.id_customers = customer_orders.customer_id');
        $this->db->join('order_products', 'order_products.customer_order_id = customer_orders.id_customer_order');
        $this->db->join('business_products', 'business_products.id_business_products = order_products.product_id');
        $this->db->where('order_products.customer_order_id =', $orderid);
        $this->db->where('customer_orders.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customer_orders');
        return $query->result_array();
    }

    function getVisitId($service_id) {

        $where = array(
            'business_id' => $this->session->userdata('businessid'),
            'id_visit_services' => $service_id,
        );

        $this->db->select('*');
        $this->db->where($where);
        $query = $this->db->get('visit_services');

        return $query->row();
    }

    function cancelVisit($customer_visit_id, $cancelreason='') {
        $canceledby=$this->session->userdata('username');
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
    
    function cancelVisitKeepAdv($customer_visit_id, $cancelreason='') {
        $canceledby=$this->session->userdata('username');
        if($cancelreason==''){            
            $cancelreason=$this->input->post('cancelreason');            
        }
        $where = array(
            'business_id' => $this->session->userdata('businessid'),
            'id_customer_visits' => $customer_visit_id,
        );

        $this->db->where($where);
        $query = $this->db->update('customer_visits', array('visit_status' => 'AdvKeptcanceled', 'cancelreason' => $cancelreason, 'canceled_by' => $this->session->userdata('username')));

        return $query;
    }

    function allVisitServices($customer_visit_id) {

        $where = array(
            'business_id' => $this->session->userdata('businessid'),
            'customer_visit_id' => $customer_visit_id,
        );

        $this->db->select('*');
        $this->db->where($where);
        $query = $this->db->get('visit_services');

        return $query->result();
    }

    function removeVisitService($id) {
        $this->db->where('id_visit_services', $id);
        $query = $this->db->delete('visit_services');
        return $query;
    }

    function updateVisit($id, $old_staff_id, $staffData, $serviceData) {
        
       // var_dump($serviceData);
       // exit();
        
        $where = array(
            'business_id' => $this->session->userdata('businessid'),
            'visit_service_id' => $id,
            'staff_id' => $old_staff_id
        );

        $this->db->where($where);
        $query = $this->db->update('visit_service_staffs', $staffData);

        $where = array(
            'business_id' => $this->session->userdata('businessid'),
            'id_visit_services' => $id
        );

        $this->db->where($where);
        $query = $this->db->update('visit_services', $serviceData);

        return $query;
    }

    function getStaff($id) {


        $this->db->select('*');
        $this->db->where('s.id_staff' , $id);
        $query = $this->db->get('staff s');

        return $query->row();
    }

    function getStaffDetails($staff_id, $event_id) {

       

        $this->db->select('*');
        $this->db->join('block_staff_time bst', 's.id_staff = bst.staff_id');
        $this->db->where('bst.id_staff_time_blocked' , $event_id);
        $query = $this->db->get('staff s');
       
        return $query->row();
    }

    function getVisitDetails($id) {
        
        if($this->session->userdata('hide_cell') && $this->session->userdata('hide_cell')=="Yes"){
            $this->db->select('*, "" as customer_cell');
        }else {
            $this->db->select('*');
        }
        
        
        $this->db->join('customer_visits cv', 'vs.customer_visit_id = cv.id_customer_visits');
        $this->db->join('customers c', 'cv.customer_id = c.id_customers');
        $this->db->join('business_services bs', 'bs.id_business_services = vs.service_id');
        $this->db->join('service_category sc', 'bs.service_category_id = sc.id_service_category');
        $this->db->join('visit_service_staffs vss', 'vs.id_visit_services = vss.visit_service_id');
        $this->db->where('vs.id_visit_services', $id);
        $query = $this->db->get('visit_services vs');

        return $query->result_array();
    }

    function getVisitInvoiceId($id) {

        $where = array(
            
            'inv.invoice_status' => 'valid',
            'vs.id_visit_services' => $id,
            'inv.invoice_type' => 'service'
        );

        $this->db->select('inv.id_invoice');
        $this->db->join('invoice inv', 'vs.customer_visit_id = inv.visit_id');
        $this->db->where($where);
        $query = $this->db->get('visit_services vs');

        return $query->row();
    }

    function getServicesByVisitId($id) {


        $this->db->select('*');
        $this->db->where('customer_visit_id' , $id);
        $query = $this->db->get('visit_services');

        return $query->result_array();
    }

    function getOpenVisitsAfterAdd() {

        $where = array(
            'vs.business_id' => $this->session->userdata('businessid'),
            'cv.visit_status' => 'open'
        );

        $this->db->select("*", false);
        $this->db->select("CASE
	WHEN visit_service_end = '' THEN concat(substr(visit_service_start, 1, instr(visit_service_start,'T')), addtime(substr(visit_service_start, instr(visit_service_start,'T')+1,10), service_duration)) 
        WHEN visit_service_end IS NULL THEN concat(substr(visit_service_start, 1, instr(visit_service_start,'T')), addtime(substr(visit_service_start, instr(visit_service_start,'T')+1,10), service_duration)) 
	WHEN visit_service_end = visit_service_start THEN concat(substr(visit_service_start, 1, instr(visit_service_start,'T')), addtime(substr(visit_service_start, instr(visit_service_start,'T')+1,10), service_duration))  ELSE visit_service_end
        END as 'visit_service_end'", false);
        $this->db->join('customer_visits cv', 'vs.customer_visit_id = cv.id_customer_visits');
        $this->db->join('customers c', 'cv.customer_id = c.id_customers');
        $this->db->join('visit_service_staffs vss', 'vs.id_visit_services = vss.visit_service_id');
        $this->db->join('business_services bs', 'bs.id_business_services = vs.service_id');
        $this->db->where('vs.business_id', $this->session->userdata('businessid'));
        $this->db->where('cv.visit_status !=', 'cancelled');
        $this->db->order_by('id_visit_services');
        $query = $this->db->get('visit_services vs');
        //echo $query; exit();
        return $query->result_array();
    }
    
    function getLastVisitColor($start, $end) {

        //Get visit services
        $this->db->select('visit_color');
        $this->db->join('customer_visits cv', 'vs.customer_visit_id = cv.id_customer_visits');
        $this->db->where('vs.business_id', $this->session->userdata('businessid'));
        $this->db->where('vs.visit_service_start >', $start);
        $this->db->where('vs.visit_service_start <', $end);
        $this->db->where('cv.visit_status !=', 'canceled');
        $this->db->order_by('cv.id_customer_visits', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('visit_services vs');
        $row = $query->row();   
        
        if($row){
            return $row->visit_color;
        } else{
            return "#641E16";
        }
    }
    
    function visitCount($start, $end) {

        //Get visits 
        $this->db->select('id_customer_visits');
        $this->db->join('customer_visits cv', 'vs.customer_visit_id = cv.id_customer_visits');
        $this->db->where('vs.business_id', $this->session->userdata('businessid'));
        $this->db->where('vs.visit_service_start >', $start);
        $this->db->where('vs.visit_service_start <', $end);
        $this->db->where('cv.visit_status !=', 'canceled');
        $this->db->where('cv.visit_status !=', 'AdvKeptcanceled');
        $this->db->group_by('id_customer_visits');
        
        $query = $this->db->get('visit_services vs');
        return $query->num_rows();
        
    }

    function serviceCount($start, $end) {

        //Get visit services
        $this->db->select('count(id_visit_services) as total, sum(service_rate) as forecast');
        $this->db->join('customer_visits cv', 'vs.customer_visit_id = cv.id_customer_visits');
        $this->db->join('business_services', 'vs.service_id=business_services.id_business_services');
        $this->db->where('vs.business_id', $this->session->userdata('businessid'));
        $this->db->where('vs.visit_service_start >', $start);
        $this->db->where('vs.visit_service_start <', $end);
        $this->db->where('cv.visit_status !=', 'canceled');
        $this->db->where('cv.visit_status !=', 'AdvKeptcanceled');
        //$this->db->group_by('id_customer_visits');
        $this->db->group_by('vs.business_id');
        $query = $this->db->get('visit_services vs');
       
        return $query->row();
    }
    
    function getOpenVisitsByDate($start, $end, $sh=false) {

        //Get visit services

        $array1 = array();
        $array2 = array();


                $where =  "(vs.business_id = ". $this->session->userdata('businessid')." OR vss.block_other = 'Yes') ";
                    
                
                $this->db->select("*,(SELECT MAX(update_date) FROM visit_services) AS most_update_date", false);
                $this->db->select("CASE
                WHEN visit_service_end = '' THEN concat(substr(visit_service_start, 1, instr(visit_service_start,'T')), addtime(substr(visit_service_start, instr(visit_service_start,'T')+1,10), service_duration)) 
                WHEN visit_service_end IS NULL THEN concat(substr(visit_service_start, 1, instr(visit_service_start,'T')), addtime(substr(visit_service_start, instr(visit_service_start,'T')+1,10), service_duration)) 
                WHEN visit_service_end = visit_service_start THEN concat(substr(visit_service_start, 1, instr(visit_service_start,'T')), addtime(substr(visit_service_start, instr(visit_service_start,'T')+1,10), service_duration))  ELSE visit_service_end
                END as 'visit_service_end'", false);
                $this->db->join('customer_visits cv', 'vs.customer_visit_id = cv.id_customer_visits');
                $this->db->join('customers c', 'cv.customer_id = c.id_customers');
                $this->db->join('visit_service_staffs vss', 'vs.id_visit_services = vss.visit_service_id');
                $this->db->join('business_services bs', 'bs.id_business_services = vs.service_id');
                $this->db->join('service_category sc', 'bs.service_category_id = sc.id_service_category');
                $this->db->join('business b', 'b.id_business = cv.business_id');
                $this->db->where($where);
                $this->db->where('vs.visit_service_start >', $start);
                $this->db->where('vs.visit_service_start <', $end);
                $this->db->where('cv.visit_status !=', 'canceled');
                $this->db->where('cv.visit_status !=', 'AdvKeptcanceled');
                if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
                    $filter = "(`cv`.`visit_status` = 'open' OR `cv`.`invoice_seq` >0 )";
                    $this->db->where($filter);                    
                }
                $this->db->where('service_flag','servicetype');
//                $this->db->where('vs.id_visit_services', $row->id_visit_services);
                $this->db->order_by('id_visit_services');
                $query = $this->db->get('visit_services vs');
               
              
                $array1[] = $query->result_array();

                $this->db->select("*", false);
                $this->db->select("CASE
                WHEN visit_service_end = '' THEN concat(substr(visit_service_start, 1, instr(visit_service_start,'T')), addtime(substr(visit_service_start, instr(visit_service_start,'T')+1,10), service_duration)) 
                WHEN visit_service_end IS NULL THEN concat(substr(visit_service_start, 1, instr(visit_service_start,'T')), addtime(substr(visit_service_start, instr(visit_service_start,'T')+1,10), service_duration)) 
                WHEN visit_service_end = visit_service_start THEN concat(substr(visit_service_start, 1, instr(visit_service_start,'T')), addtime(substr(visit_service_start, instr(visit_service_start,'T')+1,10), service_duration))  ELSE visit_service_end
                END as 'visit_service_end'", false);
                $this->db->join('customer_visits cv', 'vs.customer_visit_id = cv.id_customer_visits');
                $this->db->join('customers c', 'cv.customer_id = c.id_customers');
                $this->db->join('visit_service_staffs vss', 'vs.id_visit_services = vss.visit_service_id');
                $this->db->join('package_services ps', 'ps.service_id = vs.service_id and ps.package_category_id=vs.id_service_category');
                $this->db->join('business_services bs', 'bs.id_business_services = ps.service_id');
                $this->db->join('package_category pc', 'pc.id_package_category = ps.package_category_id');
                $this->db->join('business b', 'b.id_business = cv.business_id');
                $this->db->where($where);
//                $this->db->where('pc.id_package_category =', $row->id_service_category);
                $this->db->where('vs.visit_service_start >', $start);
                $this->db->where('vs.visit_service_start <', $end);
                $this->db->where('cv.visit_status !=', 'canceled');
                $this->db->where('cv.visit_status !=', 'AdvKeptcanceled');
                $this->db->where('service_flag !=','servicetype');
                if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
                    $filter = "(`cv`.`visit_status` = 'open' OR `cv`.`invoice_seq` >0 )";
                    $this->db->where($filter);                    
                }
//                $this->db->where('vs.id_visit_services', $row->id_visit_services);
                $this->db->order_by('id_visit_services');
                $query = $this->db->get('visit_services vs');
                
                $array2[] = $query->result_array();


        $array_merged = array_merge($array1, $array2);

        return $array_merged;
    }

    function getOpenNewVisits($start, $last_update_date, $sh=false) {

        $tomorrow = date('Y-m-d', strtotime($start . '+1 day'));


        $array1 = array();
        $array2 = array();

                $where =  "(vs.business_id = ". $this->session->userdata('businessid')." OR vss.block_other = 'Yes') ";
                
                $this->db->select("*, (SELECT MAX(update_date) FROM visit_services) AS most_update_date", false);
                $this->db->select("CASE
                WHEN visit_service_end = '' THEN concat(substr(visit_service_start, 1, instr(visit_service_start,'T')), addtime(substr(visit_service_start, instr(visit_service_start,'T')+1,10), service_duration)) 
                WHEN visit_service_end IS NULL THEN concat(substr(visit_service_start, 1, instr(visit_service_start,'T')), addtime(substr(visit_service_start, instr(visit_service_start,'T')+1,10), service_duration)) 
                WHEN visit_service_end = visit_service_start THEN concat(substr(visit_service_start, 1, instr(visit_service_start,'T')), addtime(substr(visit_service_start, instr(visit_service_start,'T')+1,10), service_duration))  ELSE visit_service_end
                END as 'visit_service_end'", false);
                $this->db->join('customer_visits cv', 'vs.customer_visit_id = cv.id_customer_visits');
                $this->db->join('customers c', 'cv.customer_id = c.id_customers');
                $this->db->join('visit_service_staffs vss', 'vs.id_visit_services = vss.visit_service_id');
                $this->db->join('business_services bs', 'bs.id_business_services = vs.service_id');
                $this->db->join('service_category sc', 'bs.service_category_id = sc.id_service_category');
                $this->db->where($where);
                $this->db->where('vs.visit_service_start >', $start);
                $this->db->where('vs.visit_service_start <', $tomorrow);
                if($last_update_date!==''){
                    $this->db->where('vs.update_date >', $last_update_date);
                }
                $this->db->where("cv.visit_status != 'canceled'");
                $this->db->where('cv.visit_status !=', 'AdvKeptcanceled');
                $this->db->where('service_flag','servicetype');
                if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
                    $this->db->where('cv.visit_status =', 'open');
                    $this->db->or_where('cv.invoice_seq >', 0);
                }
//                $this->db->where('vs.id_visit_services', $row->id_visit_services);
                $this->db->order_by('id_visit_services');
                $query = $this->db->get('visit_services vs');
               //echo $query; exit();
                $array1[] = $query->result_array();

                $this->db->select("*, (SELECT MAX(update_date) FROM visit_services) AS most_update_date", false);
                $this->db->select("CASE
                WHEN visit_service_end = '' THEN concat(substr(visit_service_start, 1, instr(visit_service_start,'T')), addtime(substr(visit_service_start, instr(visit_service_start,'T')+1,10), service_duration)) 
                WHEN visit_service_end IS NULL THEN concat(substr(visit_service_start, 1, instr(visit_service_start,'T')), addtime(substr(visit_service_start, instr(visit_service_start,'T')+1,10), service_duration)) 
                WHEN visit_service_end = visit_service_start THEN concat(substr(visit_service_start, 1, instr(visit_service_start,'T')), addtime(substr(visit_service_start, instr(visit_service_start,'T')+1,10), service_duration))  ELSE visit_service_end
                END as 'visit_service_end'", false);
                $this->db->join('customer_visits cv', 'vs.customer_visit_id = cv.id_customer_visits');
                $this->db->join('customers c', 'cv.customer_id = c.id_customers');
                $this->db->join('visit_service_staffs vss', 'vs.id_visit_services = vss.visit_service_id');
                $this->db->join('package_services ps', 'ps.service_id = vs.service_id and ps.package_category_id=vs.id_service_category');
                $this->db->join('business_services bs', 'bs.id_business_services = ps.service_id');
                $this->db->join('package_category pc', 'pc.id_package_category = ps.package_category_id');
                $this->db->where($where);
                $this->db->where('vs.visit_service_start >', $start);
                $this->db->where('vs.visit_service_start <', $tomorrow);
                if($last_update_date!==''){
                    $this->db->where('vs.update_date >', $last_update_date);
                }
                $this->db->where('cv.visit_status !=', 'canceled');
                $this->db->where('cv.visit_status !=', 'AdvKeptcanceled');
                $this->db->where('service_flag !=','servicetype');
                if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
                    $this->db->where('cv.visit_status =', 'open');
                    $this->db->or_where('cv.invoice_seq >', 0);
                }
//                $this->db->where('vs.id_visit_services', $row->id_visit_services);
                $this->db->order_by('id_visit_services');
                $query = $this->db->get('visit_services vs');
                
                $array2[] = $query->result_array();


        $array_merged = array_merge($array1, $array2);

        return $array_merged;
    }

    function getMaxVisitServiceId($start) {

        $tomorrow = date('Y-m-d', strtotime($start . '+1 day'));

        $where = array(
            
            'vs.business_id' => $this->session->userdata('businessid')
        );

        $this->db->select_max('update_date');
        $this->db->join('customer_visits cv', 'vs.customer_visit_id = cv.id_customer_visits');
        $this->db->where($where);
        $this->db->where('vs.visit_service_start >', $start);
        $this->db->where('vs.visit_service_start <', $tomorrow);
        $this->db->where("cv.visit_status='open'");
        $query = $this->db->get('visit_services vs');

        return $query->row();
    }

    function getOpenVisitServicesById($id) {
        $where = array(
            
            'vs.business_id' => $this->session->userdata('businessid')
            
        );
        $this->db->select('*');
        $this->db->join('customer_visits cv', 'vs.customer_visit_id = cv.id_customer_visits');
        $this->db->join('business_services bs', 'bs.id_business_services = vs.service_id');
        $this->db->where($where);
        $query = $this->db->get('visit_services vs');

        return $query->result();
    }

    function getOpenVisits() {

      

        $this->db->select('*');
        $this->db->join('customer_visits cv', 'vs.customer_visit_id = cv.id_customer_visits');
        $this->db->join('customers c', 'cv.customer_id = c.id_customers');
        $this->db->join('visit_service_staffs vss', 'vs.id_visit_services = vss.visit_service_id');
//        $this->db->join('business_services bs', 'bs.id_business_services = vs.service_id');
//        $this->db->where($where);
        $this->db->or_where('cv.visit_status!=', 'invoiced');
        $this->db->where('vs.business_id =', $this->session->userdata('businessid'));
        
        $query = $this->db->get('visit_services vs');

        return $query->result();
    }

    function checkDuplicateServices($customer_visit_id) {

        $this->db->select('service_id');
        $this->db->where('customer_visit_id', $customer_visit_id);
        $query = $this->db->get('visit_services');

        $check = $query->result();
        if ($check) {
            $service_ids = array();

            foreach ($check as $c) {
                $service_ids[] = $c->service_id;
            }

            return $service_ids;
        }
    }
    
    function check_visit_services_staff($staff_ids, $visit_service_id){
        $this->db->select('staff_name');
        $this->db->where('visit_service_id', $visit_service_id);
        $this->db->where_in('staff_id', $staff_ids);
        $query = $this->db->get('visit_service_staffs');
        return $query->result();
    }

    function add_visit_services_staff($staff_ids, $staff_names, $visit_id, $visit_service_id) {
        $i = 0;
        $data = array();
        foreach ($staff_ids as $staff_id) {
            $data[] = array(
                'business_id' => $this->session->userdata('businessid'),
                'customer_visit_id' => $visit_id,
                'visit_service_id' => $visit_service_id,
                'staff_id' => $staff_id,
                'staff_name' => $staff_names[$i]
            );
            $i++;
        }

        $this->db->insert_batch('visit_service_staffs', $data);
        $last_id = $this->db->insert_id();
        
        $this->db->where('id_visit_services', $visit_service_id);
        $this->db->update('visit_services', array('update_date' => date('Y-m-d H:i:s')));
        
        return $last_id;
    }
    
    
    function change_visit_color($visit_id, $visit_color){

        $this->db->where('id_customer_visits', $visit_id);
        $this->db->update('customer_visits', array('visit_color' => $visit_color));
        
        return $visit_id;
        
    }
    
    //function get_color_for_visit($last_color_code){
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

    function add_visit($customer_id, $visit_id, $last_color_code, $start) {

        if ($visit_id == 0) {
            //$color = explode('|', $this->get_color_for_visit($last_color_code));
            $color = explode('|', $this->get_color_for_visit($start));
            
            $visit = array(
                'business_id' => $this->session->userdata('businessid'),
                'customer_id' => $customer_id,
                'visit_color' => $color[0],
                'visit_color_type' => $color[1],
                'reminder_stricttime'=>htmlspecialchars($this->input->post('stricttime', TRUE)),
                'customer_visit_date'=>date('Y-m-d H:i:s'),
                'created_by'=>$this->session->userdata('username')
            );
            $this->db->insert('customer_visits', $visit);
            $visit_id = $this->db->insert_id();
            return $visit_id;
        } else {
            return $visit_id;
        }



//        $serviceInfo['customer_visit_id'] = $visit_id;
//        $serviceInfo['business_id'] = $this->session->userdata('businessid');
//            
//        $this->db->insert('visit_services', $serviceInfo);
//        
//        $visit_sid = $this->db->insert_id();
        ///update staff status
//        $staff_ids = explode('|', $serviceInfo['staff_ids']);
//
//        $this->db->set('staff_available', $visit_id);
//        $this->db->where('business_id', $this->session->userdata('businessid'));
//        $this->db->where('time_out', null);
//        $this->db->where('staff_available', '');
//        $this->db->where_in('staff_id', $staff_ids);
//        $this->db->update('staff_attendance');
//        return $visit_id."|".$visit_sid;
    }

    function add_visit_services($customer_visit_id) {

        $this->db->select('id_business, business_opening_time, business_closing_time, rec_allow_prev as previous');
        $this->db->where('id_business', $this->session->userdata('businessid'));
        $query = $this->db->get('business');
        $business=$query->row();
        
        $business_end_time = date("H:i:s",strtotime($business->business_closing_time.":00")) ;
        
        $customer_id = htmlspecialchars($this->input->post('customer_id', TRUE));
        $customer_name = htmlspecialchars($this->input->post('customer_name', TRUE));
        
        $staff_id = htmlspecialchars($this->input->post('staff_id', TRUE));
        $staff_name = htmlspecialchars($this->input->post('staff_name', TRUE));
        $start = htmlspecialchars($this->input->post('start', TRUE));
        $requested=htmlspecialchars($this->input->post('requested', TRUE));
        $promo=htmlspecialchars($this->input->post('promo', TRUE));
        
        
        $service_ids = explode(',', $this->input->post('service_ids', TRUE));
        $service_names = explode(',', $this->input->post('service_names', TRUE));
        $service_duration = explode(',', $this->input->post('service_duration', TRUE));
        $service_flags = explode(',', $this->input->post('service_flag', TRUE));
        $id_service_categories = $this->input->post('id_service_categories', TRUE);

        $product_ids = $this->input->post('product_ids', TRUE);
        $product_service_ids = $this->input->post('product_service_ids', TRUE);
        $product_names = $this->input->post('product_names', TRUE);
        $qty = $this->input->post('qty', TRUE);
        $unit = $this->input->post('unit', TRUE);

        $i = 0; $lastduration=0; $newtime='';
        foreach ($service_ids as $service_id) {
            
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
                if($service_duration[$i]=="00:00:00"){$lastduration="00:15:00";}
                else {$lastduration=$service_duration[$i];}
            } else {
                $newtime=$start;
                $lastduration=$service_duration[$i];
            }
            
            
//            print_r($newtime);echo('<br>');
//            print_r($lastduration);echo('<br>');
//            print_r($business_end_time);echo('<br>');
            
            if($this->input->post('loyalty_service')){
                $data = array(
                    'business_id' => $this->session->userdata('businessid'),
                    'customer_visit_id' => $customer_visit_id,
                    'service_id' => $service_id,
                    'service_name' => $service_names[$i],
                    'service_flag' => $service_flags[$i],
                    'id_service_category' => $id_service_categories[$i],
                    'visit_service_start' => $newtime, //$start
                    'update_date' => date('Y-m-d H:i:s'),
                    'loyalty_service' => $this->input->post('loyalty_service'),
                    'promo'=>$this->input->post('promo')
                );
            } else {
                $data = array(
                    'business_id' => $this->session->userdata('businessid'),
                    'customer_visit_id' => $customer_visit_id,
                    'service_id' => $service_id,
                    'service_name' => $service_names[$i],
                    'service_flag' => $service_flags[$i],
                    'id_service_category' => $id_service_categories[$i],
                    'visit_service_start' => $newtime, //$start
                    'update_date' => date('Y-m-d H:i:s'),
                    'promo'=>$this->input->post('promo')
                );
            }
            
            $this->db->insert('visit_services', $data);
            $id_visit_services = $this->db->insert_id();
            
            //multiple staff
            
            $s= explode(',',$staff_id);
            $sn= explode(',',$staff_name);
            $r= explode(',',$requested);
            for($x=0; $x< sizeof($s); $x++){
                $block_other='No';
                    
                $this->db->select('staff_shared');
                $this->db->where('id_staff=',$s[$x]);
                $query = $this->db->get('staff');
                $blockstaff = $query->row();

                if (isset($blockstaff))
                { $block_other =  $blockstaff->staff_shared; }
                
                $staff = array(
                    'business_id' => $this->session->userdata('businessid'),
                    'customer_visit_id' => $customer_visit_id,
                    'visit_service_id' => $id_visit_services,
                    'staff_id' => $s[$x],
                    'staff_name' => $sn[$x],
                    'requested' => $r[$x],
                    'block_other' => $block_other
                );
                
                $this->db->insert('visit_service_staffs', $staff);
            }
            //
            $k = 0;

            if ($product_ids) {
                foreach ($product_ids as $product_id) {
                    if ($product_service_ids[$k] == $service_id) {
                        $products = array(
                            'business_id' => $this->session->userdata('businessid'),
                            'customer_visit_id' => $customer_visit_id,
                            'visit_service_id' => $id_visit_services,
                            'product_id' => $product_id,
                            'product_name' => $product_names[$k],
                            'product_qty' => $qty[$k],
                            'product_unit' => $unit[$k]
                        );
                        $this->db->insert('visit_service_products', $products);
                    }
                    $k++;
                }
            }

            $i++;
        }

        //$data = $this->getMaxVisitServiceId(date('Y-m-d', strtotime($start)));

        return $this->db->insert_id();
    }

    function add_visit_staff($customer_visit_id) {
        
        $staff_id = htmlspecialchars($_POST['staff_id']);
        $staff_name = htmlspecialchars($_POST['staff_name']);

        $data = array();

        $i = 0;
        foreach ($service_ids as $service_id) {
            $data[] = array(
                'business_id' => $this->session->userdata('businessid'),
                'customer_visit_id' => $customer_visit_id,
                'service_id' => $service_id,
                'service_name' => $service_names[$i],
                'staff_ids' => $staff_id,
                'staff_names' => $staff_name,
                'visit_service_start' => $start
            );
            $i++;
        }

        $this->db->insert_batch('visit_service_staffs', $data);

        return $this->db->insert_id();
    }

    function check_services_extra($service_visit_id) {


        $this->db->select('visit_services_id');
        $this->db->where('visit_services_id', $service_visit_id);
        $query = $this->db->get('visit_services_extras');

        if ($query->num_rows() > 0) {
            return $query->row();
        }
    }

    function remove_services_extra($service_visit_id) {
       

        $this->db->select('visit_services_id');
        $this->db->where('visit_services_id', $service_visit_id);
        $query = $this->db->get('visit_services_extras');

        if ($query->num_rows() > 0) {

            $this->db->where('visit_services_id', $service_visit_id);
            $query = $this->db->delete('visit_services_extras');
            return $query;
        }
    }

    function update_services_extra($service_visit_id, $data) {

        
        $this->db->where('visit_services_id', $service_visit_id);
        $query = $this->db->update('visit_services_extras', $data);
        return $query;
    }

    function add_services_extra($data) {

        $this->db->insert('visit_services_extras', $data);
        return $this->db->insert_id();
    }

    function update_visit_time($data, $visitid, $service_id, $visit_sid) {

        $this->db->where(
                array(
                    'customer_visit_id' => $visitid,
                    'service_id' => $service_id,
                    'id_visit_services' => $visit_sid
                )
        );

        $this->db->update('visit_services', $data);
    }

    function update_visit_service($data, $visit_service_id) {

        $this->db->where('id_visit_services' , $visit_service_id);
        $query = $this->db->update('visit_services', $data);

        return $query;
    }

    
    function staff_count(){
        
        $where="(business_id = ".$this->session->userdata('businessid')." OR staff.staff_shared = 'Yes')";
        
        $this->db->select('count(*) staff_count');
        $this->db->where($where);
        $this->db->where('staff_active', 'Y');
        $this->db->where('staff_scheduler', 'On');
        
        $query = $this->db->get('staff');

        return $query->row();
    }
    
    function staff_shift_count($shiftid){
        $where="(business_id = ".$this->session->userdata('businessid')." OR staff.staff_shared = 'Yes')";
        
        $this->db->select('count(*) staff_count');
        $this->db->join('shift_staff', 'shift_staff.staff_id = staff.id_staff');
        $this->db->where('shift_id', $shiftid);
        $this->db->where($where);
        $this->db->where('staff_active', 'Y');
        $this->db->where('staff_scheduler', 'On');
        $query = $this->db->get('staff');

        return $query->row();
    }
    
    function staff_list($off_set=0, $limit=0) {
        $where="(business_id = ".$this->session->userdata('businessid')." OR staff.staff_shared = 'Yes')";
        
        $this->db->select('*');
        $this->db->where($where);
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
    
    function staff_shift_list($shiftid, $off_set=0, $limit=0) {
        $where="(business_id = ".$this->session->userdata('businessid')." OR staff.staff_shared = 'Yes')";
        $this->db->select('*');
        $this->db->join('shift_staff', 'shift_staff.staff_id = staff.id_staff');
        $this->db->where($where);
        $this->db->where('shift_id', $shiftid);        
        $this->db->where('staff_active', 'Y');
        $this->db->where('staff_scheduler', 'On');
        $this->db->order_by('staff_order', 'ASC');
        $this->db->offset($off_set);
        if($limit>0){
            $this->db->limit($limit);
        }
        $query = $this->db->get('staff');

        return $query->result();
    }
    

    function staff_info($business_id, $staff_id) {
        $this->db->select('*');
        $this->db->where('id_staff' , $staff_id);
        $query = $this->db->get('staff');

        return $query->row();
    }

    function getOnlineStaff($business_id, $staff_id) {
        $query = $this->db->query(""
                . "SELECT * FROM staff s "
                . "JOIN staff_attendance sa ON s.id_staff = sa.staff_id "
                . " where (business_id = ".$this->session->userdata('businessid')." OR staff.staff_shared = 'Yes') "
                . "s.id_staff = $staff_id AND "
                . "sa.staff_id = $staff_id AND "
                . "sa.time_in BETWEEN NOW() AND sa.time_in "
                . "");
        return $query->row();
    }


    function get_blockstaff_by_id() {
        
        
        $this->db->select('*');
        $this->db->where('staff_id', $this->input->post('staff_id'));
        $this->db->like('start_time', $this->input->post('block_calendar_date'), 'after');
        $query = $this->db->get('block_staff_time');
        return $query->row();
    }

    function get_eventstaff_by_id() {
        
        $this->db->select('*');
        $this->db->join('visit_services vs', 'vs.customer_visit_id = cv.id_customer_visits ');
        $this->db->join('visit_service_staffs vss', 'vss.customer_visit_id = cv.id_customer_visits ');
        $this->db->where('vss.staff_id', $this->input->post('staff_id'));
        $this->db->where('cv.visit_status <>', 'canceled');

        if ($this->input->post('tagged') && $this->input->post('tagged') === "fullday") {
            
            $this->db->where("date_format(vs.visit_service_start,'%Y-%m-%d') = '".$this->input->post('block_calendar_date')."'");
            
        } else if ($this->input->post('tagged') && $this->input->post('tagged') === "halfday") {
            
            $block_calendar_date = $this->input->post('block_calendar_date');
            $start = $this->input->post('block_start_time', TRUE);
            $start = explode(':', $start);
            $start = $start[0];

            //calculation for end time;
            $end = $this->input->post('block_end_time', TRUE);
            $end = explode(':', $end);
            $end = $end[0];

            $half_day = $end - $start;
            $endtime = $half_day / 2;
            $end = $endtime + $start;
            $end = round($end);
            $end = $end.':00:00';
            //$end = $block_calendar_date.'T'.$end;
             
            $this->db->where("date_format(vs.visit_service_start,'%H:%i:%s') <= '".$end."'");
            $this->db->where("date_format(vs.visit_service_start,'%Y-%m-%d') = '".$block_calendar_date."'");
        }
        
        $query = $this->db->get('customer_visits cv');
       
        return $query->row();
    }

    function get_staffname($staff_id) {
        $this->db->select('*');
        $this->db->where('id_staff', $staff_id);
        $query = $this->db->get('staff');
        $query = $query->row();
        return $query->staff_fullname;
    }
    
    function reminder_message_update(){
        $reminder = $this->input->post('reminder');//value Y|N
        $tagged = $this->input->post('tagged');//Column Name like reminder_sms|reminder_call|reminder_email
        
        if($tagged == "reminder_requested"){ //handle requested seperately and update the visit_service_staffs
            $requested = "No";
            if($this->input->post('reminder')=="Y"){$requested="Yes";}
            $data = array(
                'requested' => $requested
            );
            $this->db->where('id_visit_service_staffs', $this->input->post('id_visit_service_staff'));
            $this->db->update('visit_service_staffs', $data);
            return $this->db->affected_rows();
            
            
        } else if ($tagged == "reminder_promo"){
            $promo = "No";
            if($this->input->post('reminder')=="Y"){$promo="Yes";}
            $data = array(
                'promo' => $promo
            );
            $this->db->where('id_visit_services', $this->input->post('id_visit_services'));
            $this->db->update('visit_services', $data);
            return $this->db->affected_rows();
            
        } else {
        
            $data = array(
                $tagged => $reminder
            );
            //print_r($data);exit;
            $this->db->where('id_customer_visits', $this->input->post('customer_visit_id'));
            $this->db->update('customer_visits', $data);
            return $this->db->affected_rows();
        }
    }

    function staff_day_services($staff_id, $calendar_date){
        
        $today = $calendar_date;
        $datetime = new DateTime($today);
        $datetime->modify('+1 day');
        $tomorrow = $datetime->format('Y-m-d H:i:s');
                
        $sql = "SELECT staff_id, staff_name, staff_services.service_name, staff_services.service_category, count(id_staff_services) count, 
           sum(staff_services.discounted_price) discounted_price, sum(staff_services.discount) discount, sum(staff_services.paid) 'revenue_share'
           FROM staff_services
           join invoice on invoice.id_invoice = staff_services.invoice_id
           where visit_time  >= '".$today."' 
           and visit_time  < '".$tomorrow."' 
           and staff_id = ".$staff_id." 
           and invoice_status='valid'
           and ifnull(reference_invoice_number,'') = ''
           and staff_services.sale_type='service'
           group by staff_id, staff_name, service_name, service_category
           order by 5 desc;";
       
        $query = $this->db->query($sql);
                
        return $query->result();
        
        
    }
    
    
    function staff_day_recoveries($staff_id, $calendar_date){
        
        $today = $calendar_date;
        $datetime = new DateTime($today);
        $datetime->modify('+1 day');
        $tomorrow = $datetime->format('Y-m-d H:i:s');
                
        $sql = "SELECT staff_id, staff_name, staff_services.service_name, staff_services.service_category, count(id_staff_services) count, 
           sum(staff_services.discounted_price) discounted_price, sum(staff_services.discount) discount, sum(paid) 'revenue_share'
           FROM staff_services
           join invoice on invoice.id_invoice = staff_services.invoice_id
           where invoice_date  >= '".$today."' 
           and invoice_date  < '".$tomorrow."' 
           and staff_id = ".$staff_id." 
           and invoice_status='valid'
           and ifnull(reference_invoice_number,'') <> ''
           and staff_services.sale_type='service'
           group by staff_id, staff_name, service_name, service_category
           order by 5 desc;";
        
        $query = $this->db->query($sql);
                
        return $query->result();
        
        
    }

    public function change_date($date, $visit_service_id){
        
        
               
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
        
        return $this->db->affected_rows();
   
    }
    
    public function change_staff($staff, $visit_service_staff_id){
        
        $this->db->select("id_staff, staff_fullname", False);
        $this->db->where('id_staff=', $staff);
        $query=$this->db->get('staff');
        
        $row = $query->row();
        
        
        $data = array(
            'staff_id' => $row->id_staff,
            'staff_name' => $row->staff_fullname
        );
        
        $this->db->where('id_visit_service_staffs=', $visit_service_staff_id);
        $query=$this->db->update('visit_service_staffs', $data);
        
        return $this->db->affected_rows();
   
    }
}
