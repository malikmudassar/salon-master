<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('order_model');
        if($this->session->userdata('role')==''){
            redirect('logout');
        }
    }
    
    function abandonedcarts(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1,0,1);

            $data['nav'] = 'invoice';
            $data['subnav'] = 'abandonedcarts';

            $data['orders'] = $this->order_model->get_open_orders();

    //        print_r($data['orders']); exit;

            $this->load->view('includes/header', $data);
            $this->load->view('open_order_list');
            $this->load->view('includes/footer');
        }
    }

    public function get_orders() {
        //get the posted values
        
        $data = $this->order_model->get_orders();
        echo(json_encode($data));
        
    }
        
    public function getOrderbyid($qtype=0){
        $orderid=$this->input->post('id_customer_order', TRUE);
        if($qtype==0){
            $data = $this->order_model->getopenorderbyid($orderid);
        } else {
            $data = $this->order_model->getorderbyid($orderid);
        }
        echo(json_encode($data));
    }
    
     public function getOrderbyCid(){
       $customer_id = $this->input->post('customerid', TRUE);
       $data = $this->order_model->getorderbycid($customer_id);
       echo(json_encode($data));
    }
    
    public function addorders(){
        
        $result=$this->order_model->add_order();
        echo "success|".$result;
    }
    
    public function updateorder(){
        
        $order_id = $this->input->post('orderid', TRUE);
        $order = $this->order_model->check_order_status($order_id);
        if($order->order_status === 'invoiced'){
            echo "invoiced"; exit;
        }
        
        $result=$this->order_model->update_order();
        echo "success|".$result;
    }
    
    public function getlast4orders($customerid){
        
        $data=$this->order_model->getlast4orders($customerid);
        echo(json_encode($data));
    }
    
}