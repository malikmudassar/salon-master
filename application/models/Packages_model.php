<?php

class Packages_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_package_types() {
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

    function get_package_category($package_type_id) {
        $this->db->select('*, pc.order_id as cat_order_id'); //This query is fetching data from both table using join...
        $this->db->join('package_type pt', 'pt.id_package_type = pc.package_type_id');
        $this->db->where('pc.business_id', $this->session->userdata('businessid'));
        $this->db->where('pc.package_type_id', $package_type_id);
        $this->db->order_by('pc.order_id', 'ASC');
        $query = $this->db->get('package_category pc');

        if ($query->result_array()) {
            return $query->result_array();
        } else {
            $this->db->select('*'); //This query is fetching data from package_type table using if data not exist in package category...
            $this->db->where('pt.business_id', $this->session->userdata('businessid'));
            $this->db->where('pt.id_package_type', $package_type_id);
            $query = $this->db->get('package_type pt');
            return $query->result_array();
        }
    }

    function add_package_category() {
        $this->db->insert('package_category', array(
            'service_category' => $this->input->post('service_category'),
            'service_category_active' => $this->input->post('service_category_active'),
            'package_type_id' => $this->input->post('package_type_id'),
            'business_id' => $this->session->userdata('businessid'),
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

    function get_package_service($package_cat_id) {
        $this->db->select('*, ps.service_rate as package_service_rate'); //This query is fetching data from both table using join...
        $this->db->join('package_category pc', 'pc.id_package_category = ps.package_category_id');
        $this->db->join('business_services bs', 'bs.id_business_services = ps.service_id');
        $this->db->where('ps.package_category_id', $package_cat_id);
        $query = $this->db->get('package_services ps');

        if ($query->result_array()) {
            return $query->result_array();
        } else {
            $this->db->select('*'); //This query is fetching data from package_category table using if data not exist in package service...
            //$this->db->where('pc.business_id', $this->session->userdata('businessid'));
            $this->db->where('pc.id_package_category', $package_cat_id);
            $query = $this->db->get('package_category pc');
            return $query->result_array();
        }
    }

    function add_package_service() {
        // Unescape the string values in the JSON array
        $tableData = stripcslashes($_POST['orderdata']);

        // Decode the JSON array
        $tableData = json_decode($tableData, TRUE);

        // now $tableData can be accessed like a PHP array
        // echo $tableData[0]['servicename'];
        //add new customer_visit

        $data = [];

        foreach ($tableData as $row) {

            $data = array(
                'service_id' => $row['service_id'],
                'service_rate' => $row['service_rate'],
                'package_category_id' => $this->input->post('package_category_id')
            );

            $this->db->insert('package_services', $data);
        }

        return $this->db->insert_id();
    }

    function delete_package_service() {
        $this->db->where('id_package_services', $this->input->post('id_package_services'));
        $this->db->delete('package_services');
        return $this->input->post('id_package_services');
    }

    function get_business_service($businessid=null) {
        if($businessid==null){
            $businessid=$this->session->userdata('businessid');
        }
        
        $this->db->select('*');
        $this->db->join('service_category sc', 'sc.id_service_category = bs.service_category_id');
        $this->db->join('service_type st', 'st.id_service_types = sc.service_type_id');
        $this->db->where('service_active', 'Yes');
        $this->db->where('bs.business_id', $businessid);
        $query = $this->db->get('business_services bs');
        return $query->result_array();
    }

    function package_type_image($image = NULL) {
        $data = array(
            'service_type_image' => $image ? $image : NULL
        );
        $this->db->set($data);
        $this->db->where('id_package_type', $this->input->post('id_package_type_image', TRUE));
        $this->db->update('package_type');
        return $this->input->post('id_package_type_image');
    }

    function package_category_image($image = NULL) {
        $data = array(
            'service_category_image' => $image ? $image : NULL
        );
        //print_r($data);die;
        $this->db->set($data);
        $this->db->where('id_package_category', $this->input->post('id_package_cat_image', TRUE));
        $this->db->update('package_category');
        return $this->input->post('id_package_cat_image');
    }

    function update_order_function($id, $orderid, $type) {
        if ($id && $orderid && $type == "packagetype") {
            $data = array(
                'order_id' => $orderid
            );
            $this->db->where('package_type.id_package_type', $id);
            $this->db->where('package_type.business_id', $this->session->userdata('businessid'));
            $this->db->update('package_type', $data);
            return $id;
        }
        if ($id && $orderid && $type == "packagecat") {
            $data = array(
                'order_id' => $orderid
            );
            $this->db->where('package_category.id_package_category', $id);
            $this->db->where('package_category.business_id', $this->session->userdata('businessid'));
            $this->db->update('package_category', $data);
            return $id;
        }
    }

    function get_package_list_category() {
        $this->db->select('*, pc.service_category as package_category, pt.service_type as package_type');
        $this->db->join('package_type pt', 'pt.id_package_type = pc.package_type_id');
        $this->db->where('pc.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('package_category pc');

        return $query->result_array();
    }

    function update_package_services() {
        $this->db->where('id_package_services', $this->input->post('id_package_services'));
        $this->db->update('package_services', array(
            'package_category_id' => $this->input->post('package_category_id'),
            'service_rate' => $this->input->post('service_rate')
        ));

        return $this->db->affected_rows();
    }
    
    function edit_package_type(){
        $this->db->select('*');
        $this->db->where('pt.business_id', $this->session->userdata('businessid'));
        $this->db->where('pt.id_package_type', $this->input->post('id_package_type'));
        $query = $this->db->get('package_type pt');

        return $query->row();
    }
    
    function edit_package_category(){
        $this->db->select('*');
        $this->db->where('pc.business_id', $this->session->userdata('businessid'));
        $this->db->where('pc.id_package_category', $this->input->post('id_package_category'));
        $query = $this->db->get('package_category pc');

        return $query->row();
    }
    
    function edit_package_service(){
        $this->db->select('*');
        $this->db->where('ps.id_package_services', $this->input->post('id_package_services'));
        $query = $this->db->get('package_services ps');

        return $query->row();
    }
    
    function duplicate_package_service(){
        //select original category
        $this->db->select('*');
        $this->db->where('pg.id_package_category', $this->input->post('id_package_category'));
        $query = $this->db->get('package_category pg');
        $org_category=$query->row();
        ///add new category
        $this->db->insert('package_category', array(
            'service_category' => $this->input->post('service_category'),
            'service_category_active' => $org_category->service_category_active,
            'package_type_id' => $org_category->package_type_id,
            'business_id' => $org_category->business_id,
            'order_id' => $org_category->order_id
        ));

        $new_cat_id = $this->db->insert_id();
        
        ///get services of original category
        $this->db->select('*');
        $this->db->where('ps.package_category_id', $this->input->post('id_package_category'));
        $package_services = $this->db->get('package_services ps');
        
        //insert services in new category
        $x=0;
        foreach($package_services->result() as $ps){
            
            $data = array(
                'service_id' => $ps->service_id,
                'package_category_id' => $new_cat_id,
                'package_services_active' => $ps->package_services_active,
                'service_rate' => $ps->service_rate
            );
            $this->db->insert('package_services', $data);
            $x++;
        }
        
        return $x;
    }
    
    function duplicate_package_cat_services(){
        
        //select original type
        $this->db->select('*');
        $this->db->where('pt.id_package_type', $this->input->post('id_package_type'));
        $query = $this->db->get('package_type pt');
        $org_type=$query->row();
        ///add new type
        $this->db->insert('package_type', array(
            'service_type' => $this->input->post('package_type'),
            'service_type_image' => $org_type->service_type_image,
            'service_type_active' => $org_type->service_type_active,
            'business_id' => $org_type->business_id,
            'order_id' => $org_type->order_id
        ));

        $new_type_id = $this->db->insert_id();
 
        
        ///get categories of original type
        $this->db->select('*');
        $this->db->where('pc.package_type_id', $this->input->post('id_package_type'));
        $package_categories = $this->db->get('package_category pc');
        
        //insert categories in new type
        $totalcat=0;
        $totalservices=0;
        foreach($package_categories->result() as $pc){
            
            $data = array(
                'package_type_id' => $new_type_id,
                'order_id' => $pc->order_id,
                'service_category' => $pc->service_category,
                'business_id' => $pc->business_id,
                'service_category_active' => $pc->service_category_active,
                'service_category_image' => $pc->service_category_image
            );
            $this->db->insert('package_category', $data);
            
            $new_cat_id= $this->db->insert_id();
            $totalcat++;
            
            ///get services of original category
            $this->db->select('*');
            $this->db->where('ps.package_category_id', $pc->id_package_category);
            $package_services = $this->db->get('package_services ps');
            
            //insert services in new category
            foreach($package_services->result() as $ps){

                $data = array(
                    'service_id' => $ps->service_id,
                    'package_category_id' => $new_cat_id,
                    'package_services_active' => $ps->package_services_active,
                    'service_rate' => $ps->service_rate
                );
                $this->db->insert('package_services', $data);
                $totalservices++;
            }
            
        }

        return $totalcat."|".$totalservices;
    }
    
}
