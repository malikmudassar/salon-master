<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dispatch_controller extends CI_Controller {

    public function __construct() {

        parent::__construct();

        // Your own constructor code

        $this->load->model('dispatch_model');
        $this->load->model('product_model');
        $this->load->model('visits_model');
        

        if ($this->session->userdata('role') == '') {

            redirect('logout');
        }
    }

    public function dispatch_list_view() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $data['nav'] = 'procurement';
            $data['subnav'] = 'dispatch';

            //echo $this->input->post('showoutofstock');

            //exit();
            $data['showoutofstock']="No";
            if(null!==$this->input->post('showoutofstock') && $this->input->post('showoutofstock')=="on"){
                $data['showoutofstock']="Yes";
            }

            //$data['dispatch_list'] = $this->dispatch_model->get_dispatch_list();
            $data['staff'] = $this->dispatch_model->get_staff();
            //$data['product'] = $this->dispatch_model->get_product();
            $data['todayvisits']=$this->visits_model->get_valid_visits();


            $this->load->view('includes/header', $data);
            $this->load->view('setting/dispatch_view');
            $this->load->view('includes/footer');
        }
    }

    
    public function getproducts() {

        $showoutofstock="No";
        $showinhouse="Yes";
        $showprofessional="Yes";
        
        if(null!==$this->input->get('showoutofstock')){
            $showoutofstock=$this->input->get('showoutofstock');
        }
               
        if($showoutofstock!=="Yes"){
            $data = $this->product_model->get_searched_products($showinhouse, $showprofessional,"",$this->session->userdata('businessid')); // to hide 0 qty products
        } else {
            $data = $this->product_model->get_searched_products($showinhouse, $showprofessional, "dispatch",$this->session->userdata('businessid'));
        }
        
        echo(json_encode($data));
    }
    
    
    public function add_dispatch() {
        $data = $this->dispatch_model->add_dispatch();
        echo "success|" . $data;
        exit();
    }

    public function dispatch_measure_amount_cal() {
        $data = $this->dispatch_model->dispatch_measure_amount_cal();
        if ($data !== "") {
            echo (json_encode($data));
            exit();
        }
    }
    
    public function dispatch_unit_amount_cal() {
        $data = $this->dispatch_model->dispatch_unit_amount_cal();
        if ($data !== "") {
            echo (json_encode($data));
            exit();
        }
    }

    public function cancel_dispatch() {
        $data = $this->dispatch_model->cancel_dispatch();
        echo "success|" . $data;
        exit();
    }

    public function check_history(){
        
        $data=$this->dispatch_model->check_history();
       
        echo(json_encode($data));
    }
}
