<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('supplier_model');
        $this->load->model('product_model');
        if($this->session->userdata('role')==''){
            redirect('logout');
        }
    }

    public function supplier_list() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1,0,0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'supplier_list';

            $data['suppliers'] = $this->supplier_model->get_suppliers();
            $data['brands'] = $this->product_model->get_all_brands();
            $data['supplier_brand'] = $this->supplier_model->get_supplier_brand();

            $this->load->view('includes/header', $data);
            $this->load->view('setting/supplier_list_view');
            $this->load->view('includes/footer');
        }
    }
    public function add_supplier(){
                
        $result = $this->supplier_model->add_supplier();
        echo('success|'.$result);
        
    }
    
    public function update_supplier(){
                
        $result = $this->supplier_model->update_supplier();
        echo('success|'.$result);
        
    }
    
    public function edit_supplier(){
        $data['supplier'] = $this->supplier_model->edit_supplier();
        $data['supplier_brand'] = $this->supplier_model->get_supplier_brand_byid();
        echo (json_encode($data));
        die;
    }
    
    public function searchnameforsupplier(){
        
        $suppliername = $this->input->get("suppliername", TRUE);
        $data = $this->supplier_model->searchnameforsupplier($suppliername);

        echo(json_encode($data));
        
    }
}