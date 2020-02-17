<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Colors_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('colors_model');
        $this->load->model('customer_model');
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        }
    }

    public function color_type_list() {
        
        //storemanager,hr,reception...user serial
        checkroles(1,0,0);
        
        $data['nav'] = 'my_business';
        $data['subnav'] = 'color_types';

        $data['color_type_list'] = $this->colors_model->color_type_list();

        $this->load->view('includes/header', $data);
        $this->load->view('setting/color_types_view');
        $this->load->view('includes/footer');
    }

    public function add_color_type() {

        $result = $this->colors_model->add_color_type();
        echo('success|' . $result);
    }

    public function update_color_type() {

        $result = $this->colors_model->update_color_type();
        echo('success|' . $result);
    }

    public function color_number() {
        
        //storemanager,hr,reception...user serial
        checkroles(1,0,0);
        
        $data['nav'] = 'my_business';
        $data['subnav'] = 'color_types';
        $scid = $this->input->post('id_types', TRUE);
        
        $data['color_numbers'] = $this->colors_model->get_all_color_number($scid);
        $data['color_type'] = $this->colors_model->get_color_type_byid($scid);

        $this->load->view('includes/header', $data);
        $this->load->view('setting/color_type_number_view');
        $this->load->view('includes/footer');
    }

    public function add_color_number() {

        $result = $this->colors_model->add_color_number();
        echo('success|' . $result);
    }

    public function update_color_number() {

        $result = $this->colors_model->update_color_number();
        echo('success|' . $result);
    }

    public function color_record_list() {
        
        //storemanager,hr,reception...user serial
        checkroles(1,0,0);
        
        $data['nav'] = 'my_business';
        $data['subnav'] = 'color_record';
        
        $data['customers'] = $this->customer_model->get_customers();
        $data['color_type_list'] = $this->colors_model->color_type_list();

        $data['color_records'] = $this->colors_model->get_color_records();
        
        $data['WaterContent'] = $this->colors_model->get_WaterContent();

        $this->load->view('includes/header', $data);
        $this->load->view('setting/color_record_view');
        $this->load->view('includes/footer');
    }
    
    public function edit_color_record() {
        $data = $this->colors_model->edit_color_record();
        echo (json_encode($data));
        die;
    } 

    public function get_color_number_id($idtype) {
        $data = $this->colors_model->get_all_color_number($idtype);
        echo (json_encode($data));
        die;
    }

    function color_record_add() {
        $result = $this->colors_model->color_record_add();
        echo('success|' . $result);
        die;
    }
    
    function color_record_update() {
        $result = $this->colors_model->color_record_update();
        echo('success|' . $result);
        die;
    }
    
    public function edit_color_types(){
        $data = $this->colors_model->edit_color_types();
        echo (json_encode($data));
        die;
    }
    
    public function edit_color_number(){
        $data = $this->colors_model->edit_color_number();
        echo (json_encode($data));
        die;
    }

}
