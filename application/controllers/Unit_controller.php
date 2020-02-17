<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('unit_model');
        if($this->session->userdata('role')==''){
            redirect('logout');
        }
    }

        
    public function unit_list(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0,0,0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'unit_list';

            $data['measure_unit'] = $this->unit_model->get_all_measure_units();


            $this->load->view('includes/header', $data);
            $this->load->view('setting/unit_view');
            $this->load->view('includes/footer');
        }
        
    }
    
    public function add_unit(){
        $result = $this->unit_model->add_unit();
        echo('success|'.$result);
    }
    
    public function update_unit(){
        $result = $this->unit_model->update_unit();
        echo('success|'.$result);
    }
    
    public function edit_unit(){
        $data = $this->unit_model->edit_unit();
        echo (json_encode($data));
        die;
    }
    
    
}