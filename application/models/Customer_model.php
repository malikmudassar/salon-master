<?php

class Customer_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();

        if ($this->session->userdata('role') == '') {
            redirect('logout');
        }
    }

    function get_customer($match) {

        $this->db->select('*, id_customers as "id", "" as "customer_cell"');
        //$this->db->from('customers');
        $array = array('customer_name' => $match, 'customer_cell' => $match, 'customer_phone1' => $match, 'customer_card' => $match);
        $this->db->or_like($array);
        //$this->db->where('business_id', $this->session->userdata('businessid'));

        $query = $this->db->get('customers');
        
        return $query->result_array();
    }

    function get_byid($match) {

//        $this->db->select('*');
//        $this->db->where('id_customers', $match);
//        $this->db->where('business_id', $this->session->userdata('businessid'));
//        $query = $this->db->get('customers');

        if( $this->session->userdata('hide_cell') && $this->session->userdata('hide_cell') == "Yes"){
            $sql="select *, '' as 'customer_cell' ";
        } else {
            $sql="select * ";
        }
        $sql .= "
            from customers 
            left join ( 
                    select customer_id, ifnull(sum(loyalty_earned),0) 'earned', ifnull(sum(loyalty_used),0) 'used' ,
                    sum(ifnull(loyalty_earned,0)) - sum(ifnull(loyalty_used,0)) as 'customer_loyalty_points' 
                    from invoice 
                    where invoice_status='valid' group by customer_id 
            ) as a on a.customer_id = customers.id_customers 
            where 
             id_customers=".$match.";"; 
        
        $query=$this->db->query($sql);
        
        return $query->result_array();
    }
    
    function update_customer_info($id, $info){
        $this->db->where('id_customers', $id);
        $this->db->update('customers', $info);
    }
    
    function get_byname($match) {

        $this->db->select('*');
        $this->db->like('customer_name', $match);
        //$this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customers');

        return $query->result_array();
    }
     function get_bynameco($match) {

        $this->db->select('*, customer_name as "id"');
        $this->db->like('customer_name', $match);
        //$this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customers');

        return $query->result_array();
    }

    function get_bycell($match) {

        $this->db->select('*');
        $this->db->like('customer_cell', $match);
        //$this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customers');

        return $query->result_array();
    }
    
    function get_bycard($match) {

        $this->db->select('*');
        $this->db->like('customer_card', $match);
        //$this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customers');
        
        return $query->result_array();
    }

    function get_byemail($match) {

        $this->db->select('*');
        $this->db->like('customer_email', $match);
        //$this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customers');

        return $query->result_array();
    }

    function add_new_customer() {

        $data = array(
            'business_id' => $this->session->userdata('businessid'),
            'customer_name' => $this->input->post('txt-customer-name', TRUE),
            'customer_email' => $this->input->post('txt-customer-email', TRUE),
            'customer_cell' => $this->input->post('txt-customer-cell', TRUE),
            //'customer_gender' => $this->input->post('txt-customer-gender', TRUE),
            'customer_address' => $this->input->post('txt-customer-address', TRUE),
            'customer_birthday' => $this->input->post('txt-customer-bday', TRUE),
            'customer_birthmonth' => $this->input->post('txt-customer-bmonth', TRUE),
            'profession' => $this->input->post('txt-customer-profession', TRUE),
            'customer_careof' =>$this->input->post('txt-customer-co', TRUE),
            'customer_gender' =>$this->input->post('txt-customer-gender', TRUE),
            'created_by' => $this->session->userdata('username')
        );

        $this->db->insert('customers', $data);
        return $this->db->insert_id();
    }

    function update_customer() {

        $customerid = $this->input->post('detail-customer-id');

        //$phpdate = date("Y-m-d H:i:s",strtotime(str_replace('/','-',$this->input->post('detail-customer-wedding'))));
        $phpdate = strtotime($this->input->post('detail-customer-wedding'));
        $mysqldate = date('Y-m-d', $phpdate);
        if( $this->session->userdata('hide_cell') && $this->session->userdata('hide_cell') == "Yes"){
            $data = array(
                'business_id' => $this->session->userdata('businessid'),
                'customer_name' => $this->input->post('detail-customer-name', TRUE),
                'customer_email' => $this->input->post('detail-customer-email', TRUE),
               
                'customer_phone1' => $this->input->post('detail-customer-phone1', TRUE),
                'customer_phone2' => $this->input->post('detail-customer-phone2', TRUE),
                'customer_address' => $this->input->post('detail-customer-address', TRUE),
                'customer_birthday' => $this->input->post('detail-customer-bday', TRUE),
                'customer_birthmonth' => $this->input->post('detail-customer-bmonth', TRUE),
                'customer_anniversary' => $mysqldate,
                'customer_allergies' => $this->input->post('detail-customer-allergies', TRUE),
                'customer_alert' => $this->input->post('detail-customer-alert', TRUE),
                'profession' => $this->input->post('detail-customer-profession', TRUE),
                'customer_careof' => $this->input->post('detail-customer-careof', TRUE),
                'customer_gender' => $this->input->post('detail-customer-gender', TRUE),
                'customer_card' => $this->input->post('detail-customer-card', TRUE),
                'customer_type' => $this->input->post('detail-customer-type', TRUE)

            );
        } else {
            $data = array(
                'business_id' => $this->session->userdata('businessid'),
                'customer_name' => $this->input->post('detail-customer-name', TRUE),
                'customer_email' => $this->input->post('detail-customer-email', TRUE),
                'customer_cell' => $this->input->post('detail-customer-cell', TRUE),
                'customer_phone1' => $this->input->post('detail-customer-phone1', TRUE),
                'customer_phone2' => $this->input->post('detail-customer-phone2', TRUE),
                'customer_address' => $this->input->post('detail-customer-address', TRUE),
                'customer_birthday' => $this->input->post('detail-customer-bday', TRUE),
                'customer_birthmonth' => $this->input->post('detail-customer-bmonth', TRUE),
                'customer_anniversary' => $mysqldate,
                'customer_allergies' => $this->input->post('detail-customer-allergies', TRUE),
                'customer_alert' => $this->input->post('detail-customer-alert', TRUE),
                'profession' => $this->input->post('detail-customer-profession', TRUE),
                'customer_careof' => $this->input->post('detail-customer-careof', TRUE),
                'customer_gender' => $this->input->post('detail-customer-gender', TRUE),
                'customer_card' => $this->input->post('detail-customer-card', TRUE),
                'customer_type' => $this->input->post('detail-customer-type', TRUE)

            );
        }
        
        $this->db->where('id_customers', $customerid);
        $this->db->update('customers', $data);

        return $customerid;
    }

    //make a list of customer for current session business...in list view file...
    function get_customers() {
        $this->db->select('*');
        //$this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customers');

        return $query->result_array();
    }

    function get_customers_birthday_today() {
        $day = ltrim(date('d'), '0');
        $month = date('F');
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('customer_birthday', $day);
        $this->db->where('customer_birthmonth', $month);
        $query = $this->db->get('customers');
        return $query->result();
    }

    function get_customers_birthday_tomorrow() {
        $tomorrow = date('d', strtotime('tomorrow'));
        $tomorrow = ltrim($tomorrow, '0');
        $month = date('F');
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('customer_birthday', $tomorrow);
        $this->db->where('customer_birthmonth', $month);
        $query = $this->db->get('customers');
        return $query->result();
    }

    //Customer add function by modal..in list view file
    function add_new_customer_by_list() {

        $phpdate = strtotime($this->input->post('customer_anniversary'));
        $mysqldate = date('Y-m-d', $phpdate);

        $data = array(
            'business_id' => $this->session->userdata('businessid'),
            'customer_name' => $this->input->post('customer_name', TRUE),
            'customer_email' => $this->input->post('customer_email', TRUE),
            'customer_cell' => $this->input->post('customer_cell', TRUE),
            'customer_gender' => $this->input->post('customer_gender', TRUE),
            'customer_phone1' => $this->input->post('customer_phone1', TRUE),
            'customer_phone2' => $this->input->post('customer_phone2', TRUE),
            'customer_card' => $this->input->post('customer_card', TRUE),
            'customer_address' => $this->input->post('customer_address', TRUE),
            'customer_birthday' => $this->input->post('customer_birthday', TRUE),
            'customer_birthmonth' => $this->input->post('customer_birthmonth', TRUE),
            'customer_anniversary' => $mysqldate,
            'customer_allergies' => $this->input->post('customer_allergies', TRUE),
            'customer_alert' => $this->input->post('customer_alert', TRUE),
            'customer_type' => $this->input->post('customer_type', TRUE),
            'profession' => $this->input->post('profession', TRUE),
            'customer_careof' => $this->input->post('customer_careof', TRUE),
            'created_by' => $this->session->userdata('username')
        );

        $this->db->insert('customers', $data);
        return $this->db->insert_id();
    }

    //Customer update by modal function...in list view file...
    function update_customer_by_list() {

        $customerid = $this->input->post('id_customer');

        //$phpdate = date("Y-m-d H:i:s",strtotime(str_replace('/','-',$this->input->post('detail-customer-wedding'))));
        $phpdate = strtotime($this->input->post('customer_anniversary'));
        $mysqldate = date('Y-m-d', $phpdate);

        $data = array(
            'business_id' => $this->session->userdata('businessid'),
            'customer_name' => $this->input->post('customer_name', TRUE),
            'customer_email' => $this->input->post('customer_email', TRUE),
            'customer_cell' => $this->input->post('customer_cell', TRUE),
            'customer_gender' => $this->input->post('customer_gender', TRUE),
            'customer_phone1' => $this->input->post('customer_phone1', TRUE),
            'customer_phone2' => $this->input->post('customer_phone2', TRUE),
            'customer_card' => $this->input->post('customer_card', TRUE),
            'customer_address' => $this->input->post('customer_address', TRUE),
            'customer_birthday' => $this->input->post('customer_birthday', TRUE),
            'customer_birthmonth' => $this->input->post('customer_birthmonth', TRUE),
            'customer_anniversary' => $mysqldate,
            'customer_allergies' => $this->input->post('customer_allergies', TRUE),
            'customer_alert' => $this->input->post('customer_alert', TRUE),
            'customer_type' => $this->input->post('customer_type', TRUE),
            'profession' => $this->input->post('profession', TRUE),
            'customer_careof' => $this->input->post('customer_careof', TRUE)
        );

        // print_r($customerid);die;
        $this->db->where('id_customers', $customerid);
        $this->db->update('customers', $data);

        return $customerid;
    }

    function customer_history($idcustomer, $sh=false) {
        $this->db->select('i.id_invoice,date_format(i.invoice_date,"%d-%m-%Y") as invoice_date,date_format(i.invoice_date,"%a") as day,i.customer_name,i.customer_cell,ind.service_category,ind.service_name,ind.products,ind.staff');
        $this->db->join('invoice_details ind', 'ind.invoice_id = i.id_invoice');
        $this->db->where('i.customer_id', $idcustomer);
        $this->db->where('i.invoice_status', 'valid');
        //$this->db->where('i.business_id', $this->session->userdata('businessid'));
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
             $this->db->where('i.invoice_seq >', 0);
        }
        
        $this->db->order_by('i.id_invoice', 'DESC');
        $query = $this->db->get('invoice i');

        return $query->result_array();
    }

    //Previous visit.....work start............
    function customer_visit_count($idcustomer, $sh=false){
        
        $this->db->select('count(*) count',False);
        $this->db->join('invoice', 'cv.id_customer_visits = invoice.visit_id');
        $this->db->where('cv.customer_id', $idcustomer);
        $this->db->where('cv.visit_status', 'invoiced');
         $this->db->where('invoice.invoice_status', 'valid');
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
             $this->db->where('invoice.invoice_seq >', 0);
        }
        $query = $this->db->get('customer_visits cv');
        
        return $query->row();
    }
    
    function customer_all_visits($idcustomer, $sh=false) {

        $this->db->select('*,date_format(visit_service_start,"%d-%m-%Y") as customer_visit_date, datediff(now(), visit_service_start) as daysago',False);
        $this->db->join('visit_services', 'visit_services.customer_visit_id=cv.id_customer_visits');
        $this->db->join('invoice', 'cv.id_customer_visits = invoice.visit_id');
        $this->db->join('business', 'cv.business_id = business.id_business');
        $this->db->where('cv.customer_id', $idcustomer);
        $this->db->where('cv.visit_status', 'invoiced');
         $this->db->where('invoice.invoice_status', 'valid');
         if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
             $this->db->where('invoice.invoice_seq >', 0);
        }
       // $this->db->where('cv.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customer_visits cv');
        
        return $query->result_array();

        //print_r($visit_ids);die;
    }

    function customer_visit_services($visit_ids) {
        if ($visit_ids) {
            
            $this->db->select('*');
            $this->db->join('business_services','business_services.id_business_services = vs.service_id');
            $this->db->where('vs.service_flag', 'servicetype');
            $this->db->where_in('vs.customer_visit_id', $visit_ids);
            
            //$this->db->where('vs.business_id', $this->session->userdata('businessid'));
             
            
            $query = $this->db->get('visit_services vs');

            return $query->result_array();
        }
    }

    function get_visit_staff($visit_ids) {
        if ($visit_ids) {
            $this->db->distinct('ss.staff_id');
            $this->db->select('s.staff_fullname, vst.customer_visit_id as visit_id, vst.staff_id, bs.service_name, service_category, service_type');
            $this->db->join('visit_services vs', 'vs.id_visit_services = vst.visit_service_id');
            $this->db->join('customer_visits cv', 'cv.id_customer_visits = vst.customer_visit_id');
            $this->db->join('staff s', 'vst.staff_id = s.id_staff');
            $this->db->join('business_services bs', 'vs.service_id = bs.id_business_services');
            $this->db->join('service_category sc', 'bs.service_category_id = sc.id_service_category');
            $this->db->join('service_type st', 'st.id_service_types = sc.service_type_id');
            $this->db->where_in('vst.customer_visit_id', $visit_ids);
            $this->db->where_in('vs.service_flag', 'servicetype');
            //$this->db->where('vst.business_id', $this->session->userdata('businessid'));
            $this->db->where('cv.visit_status !=', 'canceled');
            
            $subQuery1 = $this->db->get_compiled_select('visit_service_staffs vst');
            
            $this->db->distinct('ss.staff_id');
            $this->db->select('s.staff_fullname, vst.customer_visit_id as visit_id, vst.staff_id, bs.service_name, service_category, service_type');
            $this->db->join('visit_services vs', 'vs.id_visit_services = vst.visit_service_id');
            $this->db->join('customer_visits cv', 'cv.id_customer_visits = vst.customer_visit_id');
            $this->db->join('staff s', 'vst.staff_id = s.id_staff');
            $this->db->join('package_services ps', 'vs.service_id = ps.service_id and vs.id_service_category = ps.package_category_id');
            $this->db->join('package_category pc', 'pc.id_package_category = ps.package_category_id');            
            $this->db->join('package_type st', 'st.id_package_type = pc.package_type_id');
            $this->db->join('business_services bs', 'vs.service_id = bs.id_business_services');
            $this->db->where_in('vst.customer_visit_id', $visit_ids);
            $this->db->where_in('vs.service_flag', 'packagetype');
            //$this->db->where('vst.business_id', $this->session->userdata('businessid'));
            $this->db->where('cv.visit_status !=', 'canceled');            
            $subQuery2 = $this->db->get_compiled_select('visit_service_staffs vst');
        //echo $subQuery2; exit();
            $query = $this->db->query("select * from (".$subQuery1." UNION ".$subQuery2.") as unionTable");
        
            
            
            return $query->result_array();
        }
    }

    function get_visit_product($visit_ids) {
        if ($visit_ids) {
            $this->db->distinct();
            $this->db->select('vsp.visit_service_id,vsp.customer_visit_id,vsp.product_id,vsp.product_name');
            $this->db->where_in('vsp.customer_visit_id', $visit_ids);
            //$this->db->where('vsp.business_id', $this->session->userdata('businessid'));

            $query = $this->db->get('visit_service_products vsp');

            return $query->result_array();
        }
    }

    function customer_invoice_count($idcustomer, $sh=false){
        
        $this->db->select('count(*) count');
        $this->db->where('invoice.customer_id', $idcustomer);
        $this->db->where('invoice.invoice_status', 'valid');
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('invoice.invoice_seq >', 0);
        }
        $query = $this->db->get('invoice');
        return $query->row();
    }
    
    function get_invoice_visit($idcustomer, $sh=false) {
        if ($idcustomer) {
            $this->db->distinct();
            $this->db->select('*,date_format(invoice_date,"%d-%m-%Y") as invoice_date, date_format(visit_time,"%d-%m-%Y") as visit_date');
            $this->db->where('invoice.customer_id', $idcustomer);
            $this->db->where('invoice.invoice_status', 'valid');
            $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
             if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
                 $this->db->where('invoice.invoice_seq >', 0);
             }
            $query = $this->db->get('invoice');

            return $query->result_array();
        }
    }

    function get_customer_openvisit($idcustomer) {
        $this->db->select('*');
        $this->db->where('cv.customer_id', $idcustomer);
        $this->db->where('cv.visit_status', 'open');
        $this->db->where('cv.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('customer_visits cv');

        return $query->result_array();
    }

    //Previous visit.....work end............

    function customerbalance($customerid, $sh=false) {
        //if ($customerid) {
            //$this->db->distinct();
            $this->db->select('ifnull(balance,0) as totalbalance, id_invoice, visit_id, invoice_type',false);
            $this->db->where('customer_id', $customerid);
            $this->db->where('balance >', 0);
            $this->db->where('is_recovery', 'Yes');
            $this->db->where('invoice_status', 'valid');
            if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
                $this->db->where('invoice_seq >', 0);
            }
           // $this->db->where('business_id', $this->session->userdata('businessid'));
           // $this->db->group_by('id_invoice, visit_id, invoice_type');
            $query = $this->db->get('invoice');

            return $query->result_array();
        //}
    }
    
    function get_customer_alerts($customerid){
        
            $this->db->select('id_customers, customer_allergies, customer_alert',false);
            $this->db->where('id_customers', $customerid);
//            $this->db->where('business_id', $this->session->userdata('businessid'));
            $query = $this->db->get('customers');

            return $query->result_array();        
        
    }
    
    
    function customer_exist($customername = NULL, $customercell = NULL) {
        if ($customername != NULL && $customercell != NULL) {
            $query = $this->db->query("SELECT customer_name, customer_cell FROM customers WHERE  customer_name LIKE '%$customername%' AND customer_cell = $customercell");

            $result = $query->row();
            if (isset($result->customer_name) && isset($result->customer_cell)) {
                return "name " . $result->customer_name;
                die;
            } else {
                $query = $this->db->query("SELECT customer_name, customer_cell FROM customers WHERE  customer_cell = $customercell");
                $result = $query->row();
                if (isset($result->customer_cell)) {
                    return "cell " . $result->customer_cell;
                    die;
                } else {
                    return "false";
                }
            }
        }
    }
    
    function customer_update_exist($customer_id, $customername = NULL, $customercell = NULL) {
        if ($customer_id && $customername != NULL && $customercell != NULL) {
            $query = $this->db->query("SELECT id_customers, customer_name, customer_cell FROM customers WHERE customer_name LIKE '%$customername%' AND customer_cell = $customercell AND id_customers != $customer_id");

            $result = $query->result();
            if (isset($result[0]->customer_name) && isset($result[0]->customer_cell)) {
                echo "name " . $result[0]->customer_name;
                die;
            } else {
                $query = $this->db->query("SELECT id_customers, customer_name, customer_cell FROM customers WHERE customer_cell = $customercell  AND id_customers != $customer_id");
                $result = $query->result();
                if (isset($result[0]->customer_cell)) {
                    echo "cell " . $result[0]->customer_cell;
                    die;
                } else {
                    return "false";
                }
            }
        }
    }
    
    function edit_customers(){
        $this->db->select('*');
        
        $this->db->where('c.id_customers', $this->input->post('id_customers'));
        $query = $this->db->get('customers c');

        return $query->row();
    }
    
    function CheckCustomer_Exist($customername = NULL, $customercell = NULL) {
        if ($customername != NULL && $customercell != NULL) {
            $query = $this->db->query("SELECT id_customers, customer_name, customer_cell FROM customers WHERE customer_name = '$customername' AND customer_cell = $customercell");

            $result = $query->row();
            if (isset($result->customer_name) && isset($result->customer_cell)) {
                return "name " . strtolower($result->customer_name);
                die;
            } else {
                $query = $this->db->query("SELECT id_customers, customer_name, customer_cell FROM  customers WHERE customer_cell = $customercell");
                $result = $query->row();
                if (isset($result->customer_cell)) {
                    return "cell " . $result->customer_cell;
                    die;
                } else {
                    return "false";
                }
            }
        }
    }
    
    function get_customer_loyalty($customer_id, $sh=false){
        $this->db->select("id_customers as customer_id, customers.customer_name, customers.customer_cell, sum(ifnull(loyalty_earned,0)) 'earned', sum(ifnull(loyalty_used,0)) 'used', sum(ifnull(loyalty_earned,0)) - sum(ifnull(loyalty_used,0)) 'loyalty_points', sum(ifnull(retained_amount,0)) - sum(ifnull(retained_amount_used,0)) 'retained'");
         if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
             $this->db->join('invoice','invoice.customer_id = customers.id_customers and invoice_status="valid" and invoice.invoice_seq > 0', 'left') ; 
        } else {
             $this->db->join('invoice','invoice.customer_id = customers.id_customers and invoice_status="valid"', 'left') ;
        }
               
        $this->db->where("id_customers =", $customer_id);
       
        $this->db->group_by('id_customers');
        $query = $this->db->get('customers');
       // echo $query; exit();        
        return $query->result_array();
    }

    function general_search($name='', $cell='', $card=''){
        //echo $cell; exit();
        if( $this->session->userdata('hide_cell') && $this->session->userdata('hide_cell') == "Yes"){
            $sql="select *, '' as 'customer_cell' ";
        } else {
            $sql="select * ";
        }
        $sql .= "
            from customers 
            left join ( 
                    select customer_id, ifnull(sum(loyalty_earned),0) 'earned', ifnull(sum(loyalty_used),0) 'used' ,
                    sum(ifnull(loyalty_earned,0)) - sum(ifnull(loyalty_used,0)) as 'customer_loyalty_points' 
                    from invoice 
                    where invoice_status='valid' group by customer_id 
            ) as a on a.customer_id = customers.id_customers 
            where id_customers > 0 ";
        if($name!==""){
            $sql.=" and customer_name like '%".$name."%' ";
        }
        if($cell!==""){
            $sql.=" and customer_cell like '%".$cell."%' ";
        }
        if($card!==""){
            $sql.=" and customer_card like '%".$card."%' ";
        }
        $sql.=" ;";
        
       //echo $sql; exit();
        
        $query=$this->db->query($sql);
        
        return $query->result_array();
        
    }
}
