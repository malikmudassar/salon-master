<?php

class Dispatch_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_dispatch_list() {

        $this->db->select('*');
        $this->db->join('business_products bp', 'bp.id_business_products =  d.product_id');
        $this->db->join('staff s', 's.id_staff =  d.dispatch_to_staff');
        $this->db->where('d.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('dispatch_notes d');

        return $query->result_array();
    }

    function get_staff() {

        $this->db->select('s.id_staff, s.staff_fullname');
        $this->db->where('s.business_id', $this->session->userdata('businessid'));
        $this->db->where('s.staff_active', 'Y');
        $this->db->order_by('s.staff_fullname', 'ASC');
        $query = $this->db->get('staff s');

        return $query->result_array();
    }

    function get_product() {

        $this->db->select('bp.id_business_products, bp.product, bp.unit_type');
        $this->db->where('bp.business_id', $this->session->userdata('businessid'));
        //$this->db->where('bp.inhouse_stock >', 0);
        $this->db->where('bp.qty_per_unit >', 0);
        $this->db->where('bp.business_product_active', 'Yes');
        $this->db->order_by('bp.product', 'ASC');
        $query = $this->db->get('business_products bp');

        return $query->result_array();
    }

    function dispatch_measure_amount_cal() {
        if ($this->input->post('product_id', TRUE)) {
            $measure_amount = $this->input->post('measure_amount');
            $this->db->select('*');
            $this->db->where('id_business_products', $this->input->post('product_id', TRUE));
            $product = $this->db->get('business_products');
            $product = $product->row();
            if (!empty($product)) {
                $inhouse = $product->inhouse_stock;
                $qty_per_unit = $product->qty_per_unit;
                if ($qty_per_unit && $qty_per_unit > 0) {
                    if ($measure_amount) {// <= $qty_per_unit
                        $measure_fraction = $measure_amount / $qty_per_unit;
                        $remain_inhouse = $inhouse - $measure_fraction;
                        $used_unit_amount = $inhouse - $remain_inhouse;
                        return array(
                            'remain_qty' => round($remain_inhouse, 2),
                            'used_qty' => round($used_unit_amount, 2),
                            'inhouse_qty' => $inhouse
                        );
                    }
                }
            }
        }
    }

    function dispatch_unit_amount_cal() {
        if ($this->input->post('product_id', TRUE)) {
            $this->db->select('*');
            $this->db->where('id_business_products', $this->input->post('product_id', TRUE));
            $product = $this->db->get('business_products');
            $product = $product->row();
            return $product;
        }
    }

    function add_dispatch() {
         
        if($this->input->post('dispatch_unit')!=='' && (float)$this->input->post('dispatch_unit') > 0)  {
            $dispatch_unit = (float)$this->input->post('dispatch_unit');
        } else {
            $dispatch_unit = (float)$this->input->post('dispatch_measure') / (float)$this->input->post('qty_per_unit');
        }
        
        $data = array(
            'product_id'=> $this->input->post('product_id'),
            'dispatch_to_staff' => $this->input->post('dispatch_to_staff'),
            'dispatch_qty' => $dispatch_unit,
            'dispatch_measure' => $this->input->post('dispatch_measure'),
            'unit_type' => $this->input->post('unit_type'),
            'measure_unit' => $this->input->post('measure_unit'),
            'dispatch_date' => $this->input->post('dispatch_date'),
            'batch' => $this->input->post('batch'),
            'batch_id' => $this->input->post('batch_id'),
            'business_id' => $this->session->userdata('businessid'),
            'created_by' => $this->session->userdata('username'),
            'dispatch_comment'=> $this->input->post('dispatch_comment'),
            'visit_id'=> $this->input->post('visit_id')
        );
        
        $this->db->insert('dispatch_notes', $data);
        
        return $dispatch_unit;
    }

    function cancel_dispatch() {
        
        $this->db->select('dispatch_qty');
        $this->db->where('id_dispatch_note', $this->input->post('dispatch_note_id', TRUE));
        
        $query=$this->db->get('dispatch_notes');
        $row = $query->row();
        
        $this->db->where('id_dispatch_note', $this->input->post('dispatch_note_id', TRUE));
        $this->db->update('dispatch_notes', array('status' => 'Cancelled'));

        return $row->dispatch_qty;
    }
    
    function check_history(){
        
        $this->db->select('*, date_format(dispatch_date, "%d-%m-%Y %h:%i") as d');
        $this->db->join('business_products bp', 'bp.id_business_products =  d.product_id');
        $this->db->join('business_brands bb', 'bp.brand_id=  bb.id_business_brands');
        $this->db->join('staff s', 's.id_staff =  d.dispatch_to_staff');
        $this->db->where('d.business_id', $this->session->userdata('businessid'));
        $this->db->where('d.status','Active');
        $this->db->where('d.product_id',$this->input->post('product_id'));
        $query = $this->db->get('dispatch_notes d');

        //echo $query;exit();
        
        return $query->result_array();
        
    }

}
