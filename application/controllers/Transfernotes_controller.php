<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transfernotes_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('transfernotes_model');
        $this->load->model('product_model');
        $this->load->model('supplier_model');
        $this->load->model('business_model');
        $this->load->model('accounting_model');
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        }
    }

    public function transfer_note_list() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1,0,0);

            $data['nav'] = 'procurement';
            $data['subnav'] = 'transfer';


            $data['business'] = $this->business_model->getbusinessdetails();
            $data['stores'] = $this->product_model->get_stores();

            $this->load->view('includes/header', $data);
            $this->load->view('transfer_list_view');
            $this->load->view('includes/footer');
        }
    }

    public function get_incoming_gtn_list() {
        $data = $this->transfernotes_model->get_gtn_withamount();
        echo (json_encode($data));        
    }
    
    public function business_suppliers(){
        $businessid = $this->input->post('businessid');
        $data = $this->purchaseorder_model->get_suppliers($businessid);
        echo (json_encode($data));
        
    }
    
    public function supplier_brand() {
        $supplierid = $this->input->post('supplierid');
        $businessid = $this->input->post('businessid');
        $data = $this->purchaseorder_model->get_supplier_brand($supplierid, $businessid);
        echo (json_encode($data));
        
    }

    public function brand_product() {
        $brandid = $this->input->post('brandid');
        $businessid = $this->input->post('businessid');
        
        $data = $this->purchaseorder_model->get_brand_product($brandid, $businessid);
        echo (json_encode($data));
        die;
    }

    public function addpurchase_orders() {
        $result = $this->purchaseorder_model->add_order();
        echo "success|" . $result;
        die;
    }

    public function purchase_order_detail_get($purchaseorder_id) {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $data['business'] = $this->business_model->getbusinessdetails();
            $data['purchaseorder'] = $this->purchaseorder_model->get_purchase_order_by_id($purchaseorder_id);
            $data['purchaseorder_detail'] = $this->purchaseorder_model->get_purchase_order_detail($purchaseorder_id);
            $this->load->view('includes/header', $data);
            $this->load->view('purchaseorder_detail_view');
            $this->load->view('includes/footer');
        }
    }

    //Good recieved note view function...
    public function grn_view($purchaseorder_id = 0) {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1,0,0);

            $data['nav'] = 'procurement';
            $data['subnav'] = 'good_recieved_note';
            $data['business'] = $this->business_model->getbusinessdetails();

            $data['grn_details'] = $this->purchaseorder_model->get_grn_for_create($purchaseorder_id);


            $data['purchaseorder'] = $this->purchaseorder_model->get_purchase_order_by_id($purchaseorder_id);

            $batchnos=[];

            foreach($data['grn_details'] as $p){
               array_push($batchnos, $this->purchaseorder_model->get_product_batches($p['product_id']));            
            }

            $data['batchnos']=$batchnos;

            $this->load->view('includes/header', $data);
            $this->load->view('good_recieved_note_view');
            $this->load->view('includes/footer');
        }
    }

    public function return_view($grn_id = 0){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1,0,0);

            $data['nav'] = 'procurement';
            $data['subnav'] = 'good_recive_note';
            $data['business'] = $this->business_model->getbusinessdetails();

            $data['grn_details'] = $this->purchaseorder_model->get_grn_by_id($grn_id);

    //        $batchnos=[];
    //        foreach($data['grn_details'] as $p){
    //           array_push($batchnos, $this->purchaseorder_model->get_product_batches($p['product_id']));            
    //        }

    //        $data['batchnos']=$batchnos;

            $this->load->view('includes/header', $data);
            $this->load->view('good_return_note_view');
            $this->load->view('includes/footer');
        }
    }
    
    //fetching purchase order detail for grn....
    public function purchaseorder_detail_grn() {
        $purchaseorder_id = $this->input->post('purchase_order_id');
        $data['purchaseorder_detail'] = $this->purchaseorder_model->get_purchase_order_detail($purchaseorder_id);
        $data['received_sum'] = $this->purchaseorder_model->get_grn_received_sum($purchaseorder_id);
        echo (json_encode($data));
    }

    public function grn_addupdate() {
        $result = $this->purchaseorder_model->grn_addupdate();
        echo "success|" . $result;
        
    }

    public function return_note_addupdate() {
        $result = $this->purchaseorder_model->return_note_addupdate();
        echo "success|" . $result;
        
    }
    
    
    public function purchase_order_status() {
        $po_status = $this->input->post('order_status', TRUE);
        $po_id=$this->input->post('purchaseorder_id', TRUE);
        if($po_status !==''){
            $result = $this->purchaseorder_model->purchase_order_status($po_status, $po_id);
        } else {$result=$po_id;}
        redirect(base_url().'grn_list/'.$result);
        
    }

    public function grn_list_view($purchaseorder_id = 0) {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1,0,0);

            $data['nav'] = 'procurement';
            $data['subnav'] = 'grn_list';
            //$data['purchaseorders'] = $this->purchaseorder_model->get_grn_purchase_orders();

            $data['grns'] = $this->purchaseorder_model->get_po_grns($purchaseorder_id);

            $data['purchaseorder'] = $this->purchaseorder_model->get_purchase_order_by_id($purchaseorder_id);
            $data['purchaseorder_details'] = $this->purchaseorder_model->get_purchase_order_detail($purchaseorder_id);

            $data['payments'] = $this->accounting_model->get_purchase_order_payments($purchaseorder_id);

            $this->load->view('includes/header', $data);
            $this->load->view('grn_list_view');
            $this->load->view('includes/footer');
        }
    }
    
    public function grn_list_detail() {
        $purchaseorder_id = $this->input->post('purchase_order_id');
        $data['grn_list_detail'] = $this->purchaseorder_model->get_grn_list_detail($purchaseorder_id);
        echo (json_encode($data));
    }
    
    public function edit_purchaseorder(){
        $purchaseorder_id = $this->input->post('purchaseorder_id');
        $data['edit_purchaseorder'] = $this->purchaseorder_model->edit_purchaseorder($purchaseorder_id);
        $data['edit_purchaseorder_detail'] = $this->purchaseorder_model->edit_purchaseorder_detail($purchaseorder_id);
        echo (json_encode($data));
        die;
    }
    
    public function updatepurchase_order(){
        $result = $this->purchaseorder_model->updatepurchase_orders();
        echo "success|" . $result;
        die;
    }
    
    public function updategrn(){
        $result = $this->purchaseorder_model->updategrn();
        echo "success|" . $result;
        die;
    }

}
