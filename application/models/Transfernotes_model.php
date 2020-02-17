<?php

class Transfernotes_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

//    function get_incoming_gtn_list() {
//        $startdate = $this->input->post('startdate', TRUE);
//        $enddate = $this->input->post('enddate', TRUE);
//
//        $store = $this->input->post('selectstore');
//        
//        //echo $store;
//         
//        $this->db->select('gtn_id, id_business_products, id_transfer_notes, 
//            DATE_FORMAT(transfer_date, "%d-%m-%Y %h:%i:%s") as transfer_date,
//        business_store, product, product_batch.batch_number, tranfer_out_qty, tranfer_in_qty, product_batch.id_batch, 
//        product_batch.store_id,  transfer_notes.created_by, product_batch.batch_amount price, 
//        round((product_batch.batch_amount*tranfer_in_qty),2) transferamount', false );
//        $this->db->join('product_batch','id_batch = transfer_notes.batch_id ');
//        $this->db->join('business_products','business_products.id_business_products = product_batch.product_id');
//        $this->db->join('business_stores','id_business_stores = product_batch.store_id');
//        
//        $this->db->where('transfer_notes.transfer_date >= ', $startdate.' 00:00:00');
//        $this->db->where('transfer_notes.transfer_date <= ', $enddate.' 23:59:59' );
//        if($store!=='All'){
//            $this->db->where('business_stores.id_business_stores', $store );
//        }
//        $this->db->order_by('1,3,4', 'desc');
//        $query = $this->db->get_compiled_select('transfer_notes');
//        echo $query; exit();
//        return $query->result_array();
//    }

    function get_gtn_withamount(){
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);

        $store = $this->input->post('selectstore');
        
        
        $sql = "SELECT id_gtn, sum(transfer_notes.tranfer_out_qty) tranfer_out_qty,
            sum(transfer_notes.tranfer_in_qty) tranfer_in_qty,
            DATE_FORMAT(transfer_date, '%d-%m-%Y %h:%i:%s') as transfer_date, 
           transfer_notes.created_by, 
           id_batch, batch_number, id_business_products, product, qty_per_unit, measure_unit, 
           id_business_stores, business_store, round(batch_amount,2) batch_amount,
           round(batch_amount*sum(transfer_notes.tranfer_out_qty),2) as 'Cost of Transferred Goods' 
           FROM transfer_notes join gtn on gtn.id_gtn = transfer_notes.gtn_id
            join product_batch on transfer_notes.batch_id = product_batch.id_batch
            join business_stores on business_stores.id_business_stores = product_batch.store_id 
           join business_products on business_products.id_business_products = product_batch.product_id
        where transfer_date >=  '". $startdate." 00:00:00'  
        and transfer_date <= '". $enddate." 00:00:00'  ";
        if($store!=="All"){
         $sql .= " and gtn.to_store = ".$store ." ";
        }
         $sql .= " group by  id_transfer_notes order by id_gtn, id_transfer_notes";
        
        $query = $this->db->query($sql);
        
        return $query->result_array();
        
    }
    
    function create_gtn($tostore){
        $this->db->set('gtn_date', date('Y-m-d H:s:i'));
        $this->db->set('created_by', $this->session->userdata('username'));
        $this->db->set('business_id', $this->session->userdata('businessid'));
        $this->db->set('to_store', $tostore);
        $this->db->insert('gtn');
        
        return $this->db->insert_id();
        
    }
    
    function createtransfernote($data){
        //var_dump($data);exit();
        $this->db->insert('transfer_notes', $data);
        
        return $this->db->insert_id();
    }
    


 
}
