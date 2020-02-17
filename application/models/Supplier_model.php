<?php

class Supplier_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }

    function get_suppliers() {
        $today = date('Y-m-d');
        $tomorrow= date('Y-m-d H:i:s', strtotime('tomorrow'));
        
        $this->db->select('*');
        if($this->session->userdata('common_products')=='No'){
             $this->db->where('business_supplier.business_id', $this->session->userdata('businessid'));
        }
        $query = $this->db->get('business_supplier');
       
        return $query->result_array();
    }

    function add_supplier(){
         $data = array(
            'supplier_name'=> $this->input->post('supplier_name', TRUE),
            'contact_person' => $this->input->post('contact_person', TRUE),
            'contact_number' => $this->input->post('contact_number', TRUE),
            'business_id'=> $this->session->userdata('businessid', TRUE),
            'office_phone1'=> $this->input->post('office_phone1', TRUE),
            'office_phone2'=> $this->input->post('office_phone2', TRUE),
            'email'=> $this->input->post('email', TRUE),
            'ho_address'=> $this->input->post('ho_address', TRUE),     
            'website'=> $this->input->post('website', TRUE)
        );
        
        $this->db->insert('business_supplier', $data);
        $inserted_id = $this->db->insert_id();
        $this->supplier_brand($inserted_id);
        return $inserted_id;
    }
    
    function supplier_brand($supplierid){
        $brands = $this->input->post('brand');
        if ($brands && $brands != "") {
            $data = array();
            for ($i = 0; $i < sizeof($brands); $i++) {
                $data[] = array(
                    'brand_id' => $brands[$i],
                    'supplier_id' => $supplierid
                );
            }
            $this->db->insert_batch('supplier_brand', $data);
            return TRUE;
        } else {
            return TRUE;
        }
    }
    
    function get_supplier_brand(){
        $this->db->select('*');
        $query = $this->db->get('supplier_brand');

        return $query->result_array();
    }
            
    function update_supplier(){
        
         $data=array(
            'supplier_name'=> $this->input->post('supplier_name', TRUE),
            'contact_person' => $this->input->post('contact_person', TRUE),
            'contact_number' => $this->input->post('contact_number', TRUE),
            'business_id'=> $this->session->userdata('businessid', TRUE),
            'office_phone1'=> $this->input->post('office_phone1', TRUE),
            'office_phone2'=> $this->input->post('office_phone2', TRUE),
            'email'=> $this->input->post('email', TRUE),
            'ho_address'=> $this->input->post('ho_address', TRUE),     
            'website'=> $this->input->post('website', TRUE)
         );
         
         
       
        $this->db->where('id_business_supplier', $this->input->post('id_business_supplier', TRUE));
       // $this->db->where('business_supplier.business_id', $this->session->userdata('businessid'));
        $this->db->update('business_supplier', $data);
        $this->supplier_brand_update($this->input->post('id_business_supplier', TRUE),$this->input->post('brand', TRUE));
        return $this->db->affected_rows();
    }
    
    function supplier_brand_update($supplierid,$brand = NULL){
        $this->db->where('supplier_id', $supplierid);
        $delete_service_product = $this->db->delete('supplier_brand');
        $data = array();
        if ($delete_service_product) {
            if ($brand && $brand != NULL) {
                for ($i = 0; $i < sizeof($brand); $i++) {
                    $data[] = array(
                        'brand_id' => $brand[$i],
                        'supplier_id' => $supplierid
                    );
                }
                $this->db->insert_batch('supplier_brand', $data);
                return $supplierid;
            } else {
                return $supplierid;
            }
        }
    }
            
    function get_supplierby_id($supplierid){
        $this->db->select('bs.id_business_supplier,bs.supplier_name');
        //$this->db->where('bs.business_id', $this->session->userdata('businessid'));
        $this->db->where('bs.id_business_supplier',$supplierid);
        $query = $this->db->get('business_supplier bs');
       
        return $query->result_array();
    }
    
    function edit_supplier(){
        $this->db->select('*');
        //$this->db->where('bs.business_id', $this->session->userdata('businessid'));
        $this->db->where('bs.id_business_supplier', $this->input->post('id_business_supplier'));
        $query = $this->db->get('business_supplier bs');

        return $query->row();
    }
    
    function get_supplier_brand_byid() {
        $this->db->select('*');
        $this->db->join('business_brands bb','bb.id_business_brands = sb.brand_id');
        $this->db->where('sb.supplier_id', $this->input->post('id_business_supplier'));
        $query = $this->db->get('supplier_brand sb');

        return $query->result_array();
    }
    
    
    function searchnameforsupplier($match) {
        $this->db->select('*, supplier_name as id');
        $this->db->like('supplier_name', $match);
        $this->db->or_like('contact_person', $match);
        $query = $this->db->get("business_supplier");

        return $query->result_array();
    }
    
}
