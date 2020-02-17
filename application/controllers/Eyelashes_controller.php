<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Eyelashes_controller extends CI_Controller {

    public function __construct() {

        parent::__construct();

        // Your own constructor code

        $this->load->model('customer_model');
        $this->load->model('eyelashes_model');

        if ($this->session->userdata('role') == '') {

            redirect('logout');
        }
    }

    public function eyelashes_record_list() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'eyelashes_record';

            $data['eyelashes'] = $this->eyelashes_model->get_eyelashes_record();
            $data['customers'] = $this->customer_model->get_customers();
            $data['eyelashtypes'] = $this->eyelashes_model->eyelash_type_list();

            $this->load->view('includes/header', $data);

            $this->load->view('setting/eyelashes_record_view');

            $this->load->view('includes/footer');
        }
    }

    public function add_eyelashes() {
        $result = $this->eyelashes_model->add_eyelashes();
        echo('success|' . $result);
    }

    public function edit_eyelashes_record() {
        $result = $this->eyelashes_model->edit_eyelashes_record();
        echo (json_encode($result));
        exit;
    }

    public function update_eyelashes() {
        $result = $this->eyelashes_model->update_eyelashes();
        echo('success|' . $result);
    }

}
