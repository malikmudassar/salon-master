<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Packages_controller extends CI_Controller {

    public function __construct() {

        parent::__construct();

        // Your own constructor code

        $this->load->model('service_model');
        $this->load->model('product_model');
        $this->load->model('customer_model');
        $this->load->model('packages_model');

        if ($this->session->userdata('role') == '') {

            redirect('logout');
        }
    }

    public function list_package_types() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'package_types';
            $data['packages_type'] = $this->packages_model->get_package_types();

            $this->load->view('includes/header', $data);
            $this->load->view('setting/packages_type_view');
            $this->load->view('includes/footer');
        }
    }

    public function add_package_type() {
        $result = $this->packages_model->add_package_type();
        echo('success|' . $result);
    }

    public function update_packages_type() {
        $result = $this->packages_model->update_packages_type();
        echo('success|' . $result);
    }

    public function package_type_image() {
        if ($this->input->post('id_package_type_image', TRUE) && $this->input->post('id_package_type_image', TRUE) != "") {
            $image = "";
            if ($_FILES['package_type_image']['name'] && $_FILES['package_type_image']['name'] != "") {
                $image = $this->image_upload('images/servicetype', 'package_type_image', 'gif|jpg|png');
                if ($image == FALSE) {
                    $this->session->set_flashdata('errorimage', 'The image dimension must be 128 X 128');
                    redirect(base_url('package/types'));
                } else {
                    $image = $image;
                }
            } else {
                $image = ($this->input->post('org_image', TRUE) != "" ? $this->input->post('org_image', TRUE) : NULL);
            }

            $result = $this->packages_model->package_type_image($image);
            if ($result) {
                redirect(base_url('package/types'));
            }
        }
    }

    public function list_package_category($package_type_id) {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'package_types';
            $data['packages_category'] = $this->packages_model->get_package_category($package_type_id);

            $this->load->view('includes/header', $data);
            $this->load->view('setting/packages_category_view');
            $this->load->view('includes/footer');
        }
    }

    public function add_package_category() {
        $result = $this->packages_model->add_package_category();
        echo('success|' . $result);
    }

    public function update_package_category() {
        $result = $this->packages_model->update_package_category();
        echo('success|' . $result);
    }

    public function package_category_image() {
        if ($this->input->post('id_package_cat_image', TRUE) && $this->input->post('id_package_cat_image', TRUE) != "") {
            $image = "";
            if ($_FILES['package_cat_image']['name'] && $_FILES['package_cat_image']['name'] != "") {
                $image = $this->image_upload('images/category', 'package_cat_image', 'gif|jpg|png');
                if ($image == FALSE) {
                    $this->session->set_flashdata('errorimage', 'The image dimension must be 128 X 128');
                    redirect(base_url('package/category' . '/' . $this->input->post('id_package_type_image')));
                } else {
                    $image = $image;
                }
            } else {
                $image = ($this->input->post('org_image', TRUE) != "" ? $this->input->post('org_image', TRUE) : NULL);
            }

            $result = $this->packages_model->package_category_image($image);
            if ($result) {
                redirect(base_url('package/category' . '/' . $this->input->post('id_package_type_image')));
            }
        }
    }

    public function list_package_service($package_type_id) {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'package_types';
            $data['packages_service'] = $this->packages_model->get_package_service($package_type_id);
            $data['business_service'] = $this->packages_model->get_business_service($data['packages_service'][0]['business_id']);
            $data['package_category'] = $this->packages_model->get_package_list_category();

            $this->load->view('includes/header', $data);
            $this->load->view('setting/packages_service_view');
            $this->load->view('includes/footer');
        }
    }

    public function add_package_service() {
        $result = $this->packages_model->add_package_service();
        echo('success|' . $result);
    }

    public function update_package_services() {
        $result = $this->packages_model->update_package_services();
        echo('success|' . $result);
    }

    public function delete_package_service() {
        $result = $this->packages_model->delete_package_service();
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

    public function order_function() {
        $id = $this->input->post('id');
        $orderid = $this->input->post('orderid');
        $type = $this->input->post('type');

        $result = $this->packages_model->update_order_function($id, $orderid, $type);
        echo('success|' . $result);
        die;
    }
    
    public function edit_package_type(){
        $data = $this->packages_model->edit_package_type();
        echo (json_encode($data));
        die;
    }
    
    public function edit_package_category(){
        $data = $this->packages_model->edit_package_category();
        echo (json_encode($data));
        die;
    }
    
    public function edit_package_service(){
        $data = $this->packages_model->edit_package_service();
        echo (json_encode($data));
        die;
    }

    public function duplicate_package_category(){
        
        $data = $this->packages_model->duplicate_package_service();
        echo ('success|'.$data);
       
    }
    
    public function duplicate_package_type(){
        
        $data = $this->packages_model->duplicate_package_cat_services();
        echo ('success|'.$data);
       
    }
    
}
