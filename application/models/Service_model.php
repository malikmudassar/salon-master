<?php

class Service_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_services_categories() {
        $service_type_id = $this->input->post('service_type_id', TRUE);
        $service_type_flag = $this->input->post('flag', TRUE);
        
        if($service_type_flag==="packagetype"){
            $this->db->select('*, id_package_category as id_service_category, "packagetype" as "flag"');
           // $this->db->where('business_id', $this->session->userdata('businessid'));
            $this->db->where('service_category_active', 'Yes');
            $this->db->where('package_type_id', $service_type_id);
            $this->db->order_by('order_id', 'ASC');
            $query = $this->db->get('package_category');            
        } else {
            $this->db->select('*, "servicetype" as "flag"');
           // $this->db->where('business_id', $this->session->userdata('businessid'));
            $this->db->where('service_category_active', 'Yes');
            $this->db->where('service_type_id', $service_type_id);
            //$this->db->order_by('id_service_category', 'ASC');
            $this->db->order_by('order_id', 'ASC');
            $query = $this->db->get('service_category');
        }
        return $query->result();
    }

    function get_services_types() {
        
        $this->db->select('id_service_types, business_id, service_type, service_type_image, service_type_active, order_id, "servicetype" as "flag"');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('service_type_active', 'Yes');
        
        $subQuery1 = $this->db->get_compiled_select('service_type');
        
        
        $this->db->select('id_package_type as "id_service_types", business_id, service_type, service_type_image, service_type_active, order_id, "packagetype" as "flag"');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('service_type_active', 'Yes');
        
        $subQuery2 = $this->db->get_compiled_select('package_type');
        
        $query = $this->db->query("select * from (".$subQuery1." UNION ".$subQuery2.") as unionTable order by flag desc, order_id asc");
        
        //$this->db->from("($subQuery1 UNION $subQuery2)");
        //$this->db->get();
        
        return $query->result();
    }

    function get_services_by_category($id_service_category, $flag) {

        if($flag==="packagetype"){
            $this->db->select('*, package_category_id as "service_category_id", "packagetype" as "flag"');
            $this->db->join('package_services', 'business_services.id_business_services = package_services.service_id');
            //$this->db->where('business_id', $this->session->userdata('businessid'));
            $this->db->where('package_category_id', $id_service_category);
            $this->db->where('service_active', 'Yes');
            //$this->db->order_by('id_business_services', 'ASC');
            $this->db->order_by('order_id', 'ASC');
        } else {
            $this->db->select('*, "servicetype" as "flag"');
            //$this->db->where('business_id', $this->session->userdata('businessid'));
            $this->db->where('service_category_id', $id_service_category);
            $this->db->where('service_active', 'Yes');
            //$this->db->order_by('id_business_services', 'ASC');
            $this->db->order_by('order_id', 'ASC');
        }
        $query = $this->db->get('business_services');
        
        return $query->result();
    }

  
    function get_services() {

        $this->db->select('id_business_services, id_service_category, service_category, service_name, service_desc, service_rate, service_color, service_duration, business_services.order_id, "servicetype" flag');
        $this->db->join('service_category', 'service_category.id_service_category =  business_services.service_category_id');
        $this->db->where('business_services.business_id', $this->session->userdata('businessid'));
        $this->db->where('business_services.service_active=', 'Yes');
        $subQuery1 = $this->db->get_compiled_select('business_services');
        
        $this->db->select('id_business_services, package_category_id as id_service_category, package_category.service_category as service_category, service_name, service_desc, package_services.service_rate, service_color, service_duration, business_services.order_id, "packagetype" flag');
        $this->db->join('package_services', 'package_services.service_id =  business_services.id_business_services');
        $this->db->join('package_category', 'package_category.id_package_category =  package_services.package_category_id');
        $this->db->where('business_services.business_id', $this->session->userdata('businessid'));
        $this->db->where('package_services.package_services_active=', 'Yes');
        $subQuery2 = $this->db->get_compiled_select('business_services');

        $query = $this->db->query("select * from (".$subQuery1." UNION ".$subQuery2.") as unionTable order by order_id asc");
        
        return $query->result_array();
    }

    function getservice_categories() {

        $this->db->select('id_service_category, service_type_id, order_id, service_category, business_id, service_category_active, service_category_image, \'servicetype\' flag', false);
        $this->db->where('service_category.business_id', $this->session->userdata('businessid'));
        //$this->db->order_by('id_service_category', 'ASC');
        $subQuery1 = $this->db->get_compiled_select('service_category');

        
        $this->db->select('id_package_category id_service_category, package_type_id service_type_id, order_id, service_category, business_id, service_category_active, service_category_image, \'packagetype\' flag', false);
        $this->db->where('package_category.business_id', $this->session->userdata('businessid'));
        //$this->db->order_by('id_package_category', 'ASC');
        $subQuery2 = $this->db->get_compiled_select('package_category');
        
        $query = $this->db->query("select * from (".$subQuery1." UNION ".$subQuery2.") as unionTable order by order_id asc");
        
        return $query->result_array();
    }

    function delete_category() {

        $this->db->where('id_service_category', $this->input->post('id_service_category', TRUE));
        $this->db->delete('service_category');
        return $this->db->affected_rows();
    }

    function update_category() {

        $data = array(
            'service_category' => $this->input->post('service_category', TRUE),
            'service_type_id' => $this->input->post('service_type_id', TRUE),
            'service_category_active' => $this->input->post('service_category_active', TRUE)
        );

        $this->db->where('id_service_category', $this->input->post('id_service_category', TRUE));
        //$this->db->where('service_category.business_id', $this->session->userdata('businessid'));
        $this->db->update('service_category', $data);

        return $this->db->affected_rows();
    }

    function add_category() {

        $data = array(
            'service_category' => $this->input->post('service_category', TRUE),
            'service_type_id' => $this->input->post('service_type_id', TRUE),
            'business_id' => $this->session->userdata('businessid')
        );

        $this->db->insert('service_category', $data);
        return $this->db->insert_id();
    }

    function get_category_byid($id) {
        $this->db->select('*');
        //$this->db->where('service_category.business_id', $this->session->userdata('businessid'));
        $this->db->where('id_service_category=', $id);
        $query = $this->db->get('service_category');

        return $query->result_array();
    }

    function get_all_services($scid) {
        $this->db->select('*');
        //$this->db->where('business_services.business_id', $this->session->userdata('businessid'));
        $this->db->where('service_category_id=', $scid);
        $this->db->order_by('order_id', 'ASC');
        $query = $this->db->get('business_services');

        return $query->result_array();
    }

    function add_service() {

        $data = array(
            'service_category_id' => $this->input->post('service_category_id', TRUE),
            'service_name' => $this->input->post('service_name', TRUE),
            'service_desc' => $this->input->post('service_desc', TRUE),
            'business_id' => $this->session->userdata('businessid'),
            'service_rate' => $this->input->post('service_rate', TRUE),
            'commission_perc' => $this->input->post('commission_perc', TRUE) ? $this->input->post('commission_perc', TRUE) : 0,
            'service_color' => $this->input->post('service_color', TRUE),
            'service_duration' => $this->input->post('service_duration', TRUE)
        );

        $this->db->insert('business_services', $data);
        $insert_id = $this->db->insert_id();
        $this->services_products_insert($insert_id);

        return $insert_id;
    }

    function services_products_insert($idservice) {
        // Unescape the string values in the JSON array
        $tableData = stripcslashes($this->input->post('products', TRUE));

        // Decode the JSON array
        $tableData = json_decode($tableData, TRUE);

        $data = [];

        foreach ($tableData as $row) {

            $data = array(
                'business_product_id' => $row['productid'],
                'business_service_id' => $idservice,
                'usage_qty' => $row['usageqty'],
                'status' => $row['status'],
            );

            $this->db->insert('services_products', $data);
        }

        return $idservice;
    }

    function update_service() {

        $data = array(
            'service_name' => $this->input->post('service_name', TRUE),
            'service_desc' => $this->input->post('service_desc', TRUE),
            'service_rate' => $this->input->post('service_rate', TRUE),
            'commission_perc' => $this->input->post('commission_perc', TRUE),
            'service_active' => $this->input->post('service_active', TRUE),
            'service_color' => $this->input->post('service_color', TRUE),
            'service_duration' => $this->input->post('service_duration', TRUE),
            'service_category_id' => $this->input->post('service_category_id', TRUE)
        );



        $this->db->where('id_business_services', $this->input->post('id_business_services', TRUE));
        //$this->db->where('business_services.business_id', $this->session->userdata('businessid'));
        $this->db->update('business_services', $data);

        $this->services_products_update($this->input->post('id_business_services', TRUE), $this->input->post('products', TRUE));

        return $this->db->affected_rows();
    }

    //This function is using for bridge table of service and product like one service has many products..update
    function services_products_update($idservice, $products = NULL) {
        $this->db->where('business_service_id', $idservice);
        $delete_service_product = $this->db->delete('services_products');
        $data = array();
        if ($delete_service_product) {
            if ($products && count((json_decode($products, TRUE))) != 0) {
                $productData = stripcslashes($products);
                // Decode the JSON array
                $productData = json_decode($productData, TRUE);

                for ($i = 0; $i < sizeof($productData); $i++) {
                    $data[] = array(
                        'business_product_id' => $productData[$i]['productid'],
                        'business_service_id' => $idservice,
                        'usage_qty' => $productData[$i]['usageqty'],
                        'status' => $productData[$i]['status'],
                    );
                }
                $this->db->insert_batch('services_products', $data);
                return $idservice;
            } else {
                return $idservice;
            }
        }
    }

    function delete_service() {
        $this->db->where('id_business_services', $this->input->post('id_business_services', TRUE));
        //$this->db->where('business_services.business_id', $this->session->userdata('businessid'));
        $this->db->delete('business_services');
        return $this->db->affected_rows();
    }

    function get_service_list() {
        $this->db->select('*');
        $this->db->join('service_category', 'service_category.id_service_category =  business_services.service_category_id');
        $this->db->where('business_services.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('business_services');

        return $query->result_array();
    }

    function getservice_type() {

        $this->db->select('*');
        $this->db->where('service_type.business_id', $this->session->userdata('businessid'));
        //$this->db->order_by('id_service_types', 'ASC');
        $this->db->order_by('order_id', 'ASC');
        $query = $this->db->get('service_type');

        return $query->result_array();
    }

    function add_service_type() {

        $data = array(
            'service_type' => $this->input->post('service_type', TRUE),
            'business_id' => $this->session->userdata('businessid')
        );

        $this->db->insert('service_type', $data);
        return $this->db->insert_id();
    }

    function update_service_type() {

        $data = array(
            'service_type' => $this->input->post('service_type', TRUE),
            'service_type_active' => $this->input->post('service_type_active', TRUE)
        );

        $this->db->where('id_service_types', $this->input->post('id_service_types', TRUE));
        //$this->db->where('service_type.business_id', $this->session->userdata('businessid'));
        $this->db->update('service_type', $data);

        return $this->db->affected_rows();
    }

    function service_type_image($image = NULL) {
        $data = array(
            'service_type_image' => $image ? $image : NULL
        );
        //print_r($data);die;
        $this->db->set($data);
        $this->db->where('id_service_types', $this->input->post('id_service_type_image', TRUE));
        $this->db->update('service_type');
        return $this->input->post('id_service_type_image');
    }

    function category_image($image = NULL) {
        $data = array(
            'service_category_image' => $image ? $image : NULL
        );
        //print_r($data);die;
        $this->db->set($data);
        $this->db->where('id_service_category', $this->input->post('id_service_category_image', TRUE));
        $this->db->update('service_category');
        return $this->input->post('id_service_category_image');
    }

    function getcategories_by_servicetype($idservice_type) {

        $this->db->select('*');
        $this->db->where('service_category.service_type_id', $idservice_type);
        //$this->db->where('service_category.business_id', $this->session->userdata('businessid'));
        //$this->db->order_by('id_service_category', 'ASC');
        $this->db->order_by('order_id', 'ASC');
        $query = $this->db->get('service_category');

        return $query->result_array();
    }

    function get_service_type_byid($idservice_type) {
        $this->db->select('*');
        $this->db->where('service_type.id_service_types', $idservice_type);
        //$this->db->where('service_type.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('service_type');

        return $query->row();
    }

    function get_facial_records() {
        $this->db->select('*,DATE_FORMAT(date, "%d-%c-%Y") as date');
        $this->db->where('facial_records.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('facial_records');

        return $query->result_array();
    }
    
    function get_customer_facial_records($customer_id, $sh=false) {
        $this->db->select('*,DATE_FORMAT(date, "%d-%c-%Y") as date, datediff(now(), date) as daysago', False);
        $this->db->where('facial_records.business_id', $this->session->userdata('businessid'));
        $this->db->where('facial_records.customer_id', $customer_id);
        $this->db->order_by('daysago asc');
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->limit(5);
        }
        $query = $this->db->get('facial_records');

        return $query->result_array();
    }

    function facial_record_add() {
        
        $data = array(
            'customer_id' => $this->input->post('txtcustomer_id', TRUE),
            'customer' => $this->input->post('txtcustomer', TRUE),
            'time' => $this->input->post('txttime', TRUE),
            'charge' => $this->input->post('txtcharge', TRUE),
            'remarks' => $this->input->post('txtremarks', TRUE),
            'date' => $this->input->post('txtdate', TRUE),
            'exfoliant' => $this->input->post('txtexfoliant', TRUE),
            'mask' => $this->input->post('txtmask', TRUE),
            'cleanser' => $this->input->post('txtcleanser', TRUE),
            'facial' => $this->input->post('txtfacial', TRUE),
            'business_id' => $this->session->userdata('businessid'),
            'visit_id' => $this->input->post('txtvisitid', TRUE)
        );
        
        $this->db->insert('facial_records', $data);
        return $this->db->insert_id();
    }

    function facial_record_update() {
        //echo $this->input->post('txttypenumber', TRUE);die;
        $data = array(
            'customer_id' => $this->input->post('txtcustomer_id', TRUE),
            'customer' => $this->input->post('txtcustomer', TRUE),
            'time' => $this->input->post('txttime', TRUE),
            'charge' => $this->input->post('txtcharge', TRUE),
            'remarks' => $this->input->post('txtremarks', TRUE),
            'date' => $this->input->post('txtdate', TRUE),
            'exfoliant' => $this->input->post('txtexfoliant', TRUE),
            'mask' => $this->input->post('txtmask', TRUE),
            'cleanser' => $this->input->post('txtcleanser', TRUE),
            'facial' => $this->input->post('txtfacial', TRUE),
            'business_id' => $this->session->userdata('businessid')
        );
        // print_r($data);die;
        $this->db->where('id', $this->input->post('idfacial_record', TRUE));
        //$this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->update('facial_records', $data);

        return $this->db->affected_rows();
    }

    function update_order_function($id, $orderid, $type) {
        if ($id && $orderid && $type == "servicetype") {
            $data = array(
                'order_id' => $orderid
            );
            $this->db->where('service_type.id_service_types', $id);
          //  $this->db->where('service_type.business_id', $this->session->userdata('businessid'));
            $this->db->update('service_type', $data);
            return $id;
        }
        if ($id && $orderid && $type == "servicecategory") {
            $data = array(
                'order_id' => $orderid
            );
            $this->db->where('service_category.id_service_category', $id);
            //$this->db->where('service_category.business_id', $this->session->userdata('businessid'));
            $this->db->update('service_category', $data);
            return $id;
        }
        if ($id && $orderid && $type == "services") {
            $data = array(
                'order_id' => $orderid
            );
            $this->db->where('business_services.id_business_services', $id);
            //$this->db->where('business_services.business_id', $this->session->userdata('businessid'));
            $this->db->update('business_services', $data);
            return $id;
        }
        if ($id && $orderid && $type == "colortype") {
            $data = array(
                'order_id' => $orderid
            );
            $this->db->where('color_types.id', $id);
            //$this->db->where('color_types.business_id', $this->session->userdata('businessid'));
            $this->db->update('color_types', $data);
            return $id;
        }
    }
    
    function get_list_category(){
        $this->db->select('sc.id_service_category, st.service_type, sc.service_category');
        $this->db->join('service_type st','st.id_service_types = sc.service_type_id');
        $this->db->where('sc.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('service_category sc');

        return $query->result_array();
    }
    
    function edit_services(){
        $this->db->select('*');
       // $this->db->where('bs.business_id', $this->session->userdata('businessid'));
        $this->db->where('bs.id_business_services', $this->input->post('id_business_services'));
        $query = $this->db->get('business_services bs');

        return $query->row();
    }
    
    function get_services_products_byid($service_id) {
        $this->db->select('*');
        $this->db->join('business_products bp','sp.business_product_id = bp.id_business_products');
        $this->db->where('sp.business_service_id', $service_id);
        $query = $this->db->get('services_products sp');

        return $query->result_array();
    }
    
    function edit_service_types(){
        $this->db->select('*');
        //$this->db->where('st.business_id', $this->session->userdata('businessid'));
        $this->db->where('st.id_service_types', $this->input->post('id_service_types'));
        $query = $this->db->get('service_type st');

        return $query->row();
    }
    
    function edit_service_category(){
        $this->db->select('*');
        //$this->db->where('sc.business_id', $this->session->userdata('businessid'));
        $this->db->where('sc.id_service_category', $this->input->post('id_service_category'));
        $query = $this->db->get('service_category sc');

        return $query->row();
    }
    
    function edit_facial_record(){
        $this->db->select('*');
        //$this->db->where('fr.business_id', $this->session->userdata('businessid'));
        $this->db->where('fr.id', $this->input->post('id_facial_record'));
        $query = $this->db->get('facial_records fr');

        return $query->row();
    }
    function get_package_types(){
        
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('service_type_active', 'Yes');
        $query = $this->db->get('package_type');
        
        return $query->result();
        
    }
    function get_package_category($ptype){
        
        $this->db->select('*');
        $this->db->where('package_type_id', $ptype);
        $this->db->where('service_category_active', 'Yes');
        //$this->db->where('business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('package_category');
        return $query->result();
    }
    
    function get_loyalty_serices($loyaltypoints){
        
        $this->db->select('*');
        $this->db->join("business_services bs", "bs.id_business_services = loyalty_services.service_id");
        $this->db->join("service_category sc", "sc.id_service_category = bs.service_category_id");
        $this->db->join("service_type st", "st.id_service_types = sc.service_type_id");
        $this->db->where('required_points <=', $loyaltypoints);
        $this->db->where('loyalty_services.active', 'Y');
        $this->db->where('loyalty_services.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('loyalty_services');

        return $query->result();
        
    }
    
    function get_loyalty_rate($serviceid){
        
        $this->db->select('*');
        $this->db->where('loyalty_services.service_id =', $serviceid);
        $query = $this->db->get('loyalty_services');
        return $query->result_array();
        
    }
    
    
    function get_active_types(){
                
        $this->db->select('*', FALSE);
        $this->db->where('service_type_active','Yes');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->order_by('order_id');
        $query = $this->db->get('service_type');

        return $query->result_array();
    }
    
    function get_active_package_types(){
                
        $this->db->select('*', FALSE);
        $this->db->where('service_type_active','Yes');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->order_by('order_id');
        $query = $this->db->get('package_type');

        return $query->result_array();
    }
    
    
    function get_active_categories(){
                
        $this->db->select('*', FALSE);
        $this->db->where('service_category_active','Yes');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->order_by('order_id');
        $query = $this->db->get('service_category');

        return $query->result_array();
    }
    
    function get_active_package_categories(){
                
        $this->db->select('*', FALSE);
        $this->db->where('service_category_active','Yes');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->order_by('order_id');
        $query = $this->db->get('package_category');

        return $query->result_array();
    }
    
    function get_active_services(){
                
        $this->db->select('*, concat(service_name, " ", service_desc) as "id", "servicetype" as "flag"', FALSE);
        $this->db->where('service_active','Yes');
        $this->db->where('bs.business_id', $this->session->userdata('businessid'));
        $this->db->order_by('bs.order_id');
        $query = $this->db->get('business_services bs');

        return $query->result_array();
    }
    
    function get_active_package_services(){
                
        $this->db->select('*, package_services.service_rate as "package_service_rate", concat(service_name, " ", service_desc) as "id", "packagetype" as "flag"', FALSE);
        $this->db->join('package_services', 'bs.id_business_services = package_services.service_id'); 
        $this->db->where('service_active','Yes');
        $this->db->where('package_services_active','Yes');
        $this->db->where('bs.business_id', $this->session->userdata('businessid'));
        $this->db->order_by('bs.order_id');
        $query = $this->db->get('business_services bs');

        return $query->result_array();
    }
    
    function search_all_services($match){
                
        $this->db->select('*, concat(service_name, " ", service_desc) as "id", "servicetype" as "flag"', FALSE);
        $this->db->join("service_category sc", "sc.id_service_category = bs.service_category_id");
        $this->db->join("service_type st", "st.id_service_types = sc.service_type_id");
        $this->db->like('service_name', $match);
        $this->db->or_like('service_desc', $match);
        $this->db->or_like('service_category', $match);
        $this->db->or_like('service_type', $match);
        $this->db->or_like('id_business_services', $match);
        $this->db->where('service_active','Yes');
        $this->db->where('bs.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('business_services bs');
        
        return $query->result_array();
    }
    
    function get_service_products($serviceid){
        
        $this->db->select('*');
        $this->db->join('business_services bs', 'sp.business_service_id = bs.id_business_services');
        $this->db->join('business_products bp', 'bp.id_business_products = sp.business_product_id');
        //$this->db->where('bs.business_id =', $this->session->userdata('businessid'));
        $this->db->where('sp.business_service_id =',$serviceid);
        $this->db->where('sp.status =','Y');
        $query = $this->db->get('services_products sp');
        return $query->result_array();
        
    }
   
}
