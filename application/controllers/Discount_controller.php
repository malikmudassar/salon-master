<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Discount_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('discount_model');
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        }
    }

    public function discount_config() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0,0,0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'discount';

            $data['discounts'] = $this->discount_model->getdiscounttypes();
            $data['dispass'] = $this->discount_model->discount_password_update();
            $this->load->view('includes/header', $data);
            $this->load->view('discount_config_view');
            $this->load->view('includes/footer');
        }
    }

    public function discount_update() {
        $result = $this->discount_model->discount_update();
        echo "success|" . $result;
    }

    public function create_new_user_discount_pass() {
        $result = $this->discount_model->create_new_user_discount_pass();
        if ($result == $this->input->post('txtusername', TRUE)) {
            echo $result;
            die;
        } else {
            echo "success";
            die;
        }
    }

    public function discount_password_set() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $data['dispass'] = $this->discount_model->discount_password_update();
            $this->load->view('includes/header');
            $this->load->view('discount_password_view', $data);
            $this->load->view('includes/footer');
        }
    }

    public function discount_password_update() {
        $result = $this->discount_model->discount_password_update();
        if ($result == $this->input->post('name', TRUE)) {
            echo $result;
            die;
        } else {
            echo "success";
            die;
        }
    }

}
