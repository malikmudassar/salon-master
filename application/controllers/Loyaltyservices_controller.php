<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Loyaltyservices_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('business_model');
        $this->load->model('loyaltyservices_model');
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        }
    }

    public function Loyaltyservices_view() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'loyaltyservices';

            $data['business'] = $this->business_model->get_business_details();
            $data['loyalty_services'] = $this->loyaltyservices_model->get_loyalty_services();

            $this->load->view('includes/header', $data);
            $this->load->view('setting/loyalty_services');
            $this->load->view('includes/footer');
        }
    }

    public function add_loyaltyservice(){
        
        $result = $this->loyaltyservices_model->add_loyaltyservice();
        echo "success|".$result;
        
    }

    public function get_edit_loyaltyservice(){
        
        $data = $this->loyaltyservices_model->get_edit_loyaltyservice($this->input->post('id_loyalty_services'));
         echo (json_encode($data));  
        
    }

    public function edit_loyaltyservice() {
        $result = $this->loyaltyservices_model->edit_loyaltyservice();
        echo('success|' . $result);
       
    }

    public function business_update() {

        $result = $this->business_model->business_update();
        echo('success|' . $result);
    }

    public function business_logo_update() {
        if ($this->input->post('business_id_logo', TRUE) && $this->input->post('business_id_logo', TRUE) != "") {
            $image = "";
            if ($_FILES['business_logo']['name'] && $_FILES['business_logo']['name'] != "") {
                $image = $this->image_upload('images/business', 'business_logo', 'gif|jpg|png', 210, 89);
                if ($image == FALSE) {
                    $this->session->set_flashdata('errorimage', 'The image dimension must be 210 X 89');
                    redirect(base_url('business'));
                } else {
                    $image = $image;
                }
            } else {
                $image = ($this->input->post('org_image', TRUE) != "" ? $this->input->post('org_image', TRUE) : NULL);
            }

            $result = $this->business_model->business_logo_update($image);
            if ($result) {
                redirect(base_url('business'));
            }
        }
    }

    public function business_tax_view() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'business';

            $data['business_tax'] = $this->business_model->get_business_tax();

            $this->load->view('includes/header', $data);
            $this->load->view('setting/business_tax_view');
            $this->load->view('includes/footer');
        }
    }

    public function edit_business_Taxby_id() {
        $result = $this->business_model->edit_business_Taxby_id();
        echo (json_encode($result));
        die;
    }
    
    public function business_taxes_update() {

        $result = $this->business_model->business_taxes_update();
        echo('success|' . $result);
    }
    
    public function business_taxes_add() {

        $result = $this->business_model->business_taxes_add();
        echo('success|' . $result);
    }

    function image_upload($folder = NULL, $image = NULL, $type = NULL, $width = NULL, $height = NULL, $encrypt = NULL) {
        $config['upload_path'] = 'assets/' . $folder . '/';
        $config['allowed_types'] = $type;
        $config['max_size'] = '2048';

        if ($width != NULL && $height != NULL) {
            $config['max_width'] = $width;
            $config['max_height'] = $height;
        }
        if ($encrypt != NULL) {
            $config['encrypt_name'] = TRUE;
        }

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($image)) {
            return FALSE;
        } else {
            return $this->upload->data('file_name');
        }
    }

}
