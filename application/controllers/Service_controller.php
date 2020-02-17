<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Service_controller extends CI_Controller {

    public function __construct() {

        parent::__construct();

        // Your own constructor code

        $this->load->model('service_model');
        $this->load->model('product_model');
        $this->load->model('customer_model');
        $this->load->model('business_model');
        if ($this->session->userdata('role') == '') {

            redirect('logout');
        }
    }

    /*
     * Developer: Tahir Khan Afridi
     * Work Started
     */

    function getServicesCategories() {

        $data = $this->service_model->get_services_categories();
        $x=0;
        foreach($data as $d){
            
            if(!file_exists('assets/images/category/'.$d->service_category_image) || empty($d->service_category_image)){
                $data[$x]->service_category_image = 'nu.jpg';
            }
            
            $x++;
        }
        echo json_encode($data);
    }

    function getServicesTypes() {

        $data = $this->service_model->get_services_types();
        $x=0;
        foreach($data as $d){
            
            if(!file_exists('assets/images/servicetype/'.$d->service_type_image) || empty($d->service_type_image)){
                $data[$x]->service_type_image = 'nu.jpg';
            }
            
            $x++;
        }
        echo json_encode($data);
    }

    function getServicesByCategory() {

        $id_service_category = htmlentities($this->input->post('id_service_category', TRUE));
        $flag =$this->input->post('flag');

        $data = $this->service_model->get_services_by_category($id_service_category, $flag);
        $i = 0;
        foreach ($data as $d) {
            $data[$i]->service_rate = number_format($d->service_rate);
            $i++;
        }
        echo json_encode($data);
    }

   

    public function services() {

        //get the posted values
        $data = $this->service_model->get_services();
        $data['business']=$this->business_model->getbusinessdetails();
        echo(json_encode($data));
    }

    public function set_service_categories($idservice_type) {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $data['nav'] = 'my_business';
            $data['subnav'] = 'servicetypes';

            if ($idservice_type && $idservice_type != "") {
                $data['idservice_type'] = $idservice_type;
                $data['service_type'] = $this->service_model->get_service_type_byid($idservice_type);
                $data['service_types'] = $this->service_model->getservice_type();
                $data['servicecategories'] = $this->service_model->getcategories_by_servicetype($idservice_type);
            } else {
                $data['servicecategories'] = $this->service_model->getservice_categories();
            }


            $this->load->view('includes/header', $data);

            $this->load->view('setting/servicecategories_view');

            $this->load->view('includes/footer');
        }
    }

    public function delete_category() {



        $result = $this->service_model->delete_category();

        echo('success|' . $result);
    }

    public function update_category() {



        $result = $this->service_model->update_category();

        echo('success|' . $result);
    }

    public function add_category() {



        $result = $this->service_model->add_category();

        echo('success|' . $result);
    }

    public function set_services($id_service_category) {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $data['nav'] = 'my_business';
            $data['subnav'] = 'servicetypes';

            //$scid = $this->input->post('id_service_category', TRUE);
            $scid = $id_service_category;

            $data['business']=$this->business_model->getbusinessdetails();

            $data['services'] = $this->service_model->get_all_services($scid);

            $data['service_category'] = $this->service_model->get_category_byid($scid);

            $data['productsbrand'] = $this->product_model->get_all_brands('yes');

            //$data['products'] = $this->product_model->get_product_list();

            //$data['services_products'] = $this->product_model->get_services_products();

            $data['category'] = $this->service_model->get_list_category();
            $this->load->view('includes/header', $data);
            $this->load->view('setting/services_view');
            $this->load->view('includes/footer');
        }
    }

    public function add_service() {



        $result = $this->service_model->add_service();

        echo('success|' . $result);
    }

    public function update_service() {



        $result = $this->service_model->update_service();

        echo('success|' . $result);
    }

    public function delete_service() {



        $result = $this->service_model->delete_service();

        echo('success|' . $result);
    }

    public function set_service_list() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1,0,0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'servicelist';

            $data['services'] = $this->service_model->get_service_list();

            $data['productsbrand'] = $this->product_model->get_all_brands('yes');

            //$data['products'] = $this->product_model->get_product_list();

            //$data['services_products'] = $this->product_model->get_services_products();

            $data['business']=$this->business_model->getbusinessdetails();
            $data['category'] = $this->service_model->get_list_category();
            $this->load->view('includes/header', $data);
            $this->load->view('setting/service_list_view');
            $this->load->view('includes/footer');
        }
    }

    public function set_service_type() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1,0,0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'servicetypes';

            $data['servicetype'] = $this->service_model->getservice_type();

            $this->load->view('includes/header', $data);
            $this->load->view('setting/service_type_view');
            $this->load->view('includes/footer');
        }
    }

    public function add_service_type() {

        $result = $this->service_model->add_service_type();

        echo('success|' . $result);
    }

    public function update_service_type() {

        $result = $this->service_model->update_service_type();

        echo('success|' . $result);
    }

    public function service_type_image() {
        if ($this->input->post('id_service_type_image', TRUE) && $this->input->post('id_service_type_image', TRUE) != "") {
            $image = "";
            if ($_FILES['service_type_image']['name'] && $_FILES['service_type_image']['name'] != "") {
                $image = $this->image_upload('images/servicetype', 'service_type_image', 'gif|jpg|png');
                if ($image == FALSE) {
                    $this->session->set_flashdata('errorimage', 'The image dimension must be 128 X 128');
                    redirect(base_url('servicetypes'));
                } else {
                    $image = $image;
                }
            } else {
                $image = ($this->input->post('org_image', TRUE) != "" ? $this->input->post('org_image', TRUE) : NULL);
            }

            $result = $this->service_model->service_type_image($image);
            if ($result) {
                redirect(base_url('servicetypes'));
            }
        }
    }

    public function category_image() {
        if ($this->input->post('id_service_category_image', TRUE) && $this->input->post('id_service_category_image', TRUE) != "") {
            $image = "";
            if ($_FILES['service_category_image']['name'] && $_FILES['service_category_image']['name'] != "") {
                $image = $this->image_upload('images/category', 'service_category_image', 'gif|jpg|png');
                if ($image == FALSE) {
                    $this->session->set_flashdata('errorimage', 'The image dimension must be 128 X 128');
                    redirect(base_url('service_categories'));
                } else {
                    $image = $image;
                }
            } else {
                $image = ($this->input->post('org_image', TRUE) != "" ? $this->input->post('org_image', TRUE) : NULL);
            }

            $result = $this->service_model->category_image($image);
            if ($result) {
                redirect(base_url('service_categories' . '/' . $this->input->post('id_service_type_image', TRUE)));
            }
        }
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

    public function facial_record_list() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0,0,0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'facial_record_list';

            $data['customers'] = $this->customer_model->get_customers();
            $data['facial_records'] = $this->service_model->get_facial_records();

            $this->load->view('includes/header', $data);
            $this->load->view('setting/facial_record_view');
            $this->load->view('includes/footer');
        }
    }

    function facial_record_add() {
        $result = $this->service_model->facial_record_add();
        echo('success|' . $result);
        die;
    }

    function facial_record_update() {
        $result = $this->service_model->facial_record_update();
        echo('success|' . $result);
        die;
    }

    public function order_function() {
        $id = $this->input->post('id');
        $orderid = $this->input->post('orderid');
        $type = $this->input->post('type');
        
        $result = $this->service_model->update_order_function($id, $orderid, $type);
        echo('success|' . $result);
        die;
    }
    
    public function edit_services(){
        $data['services'] = $this->service_model->edit_services();
        $data['services_products'] = $this->service_model->get_services_products_byid($this->input->post('id_business_services'));
        echo (json_encode($data));
        die;
    }
    
    public function edit_service_types(){
        $data = $this->service_model->edit_service_types();
        echo (json_encode($data));
        die;
    }
    
    public function edit_service_category(){
        $data = $this->service_model->edit_service_category();
        echo (json_encode($data));
        die;
    }
    
    public function edit_facial_record(){
        $data = $this->service_model->edit_facial_record();
        echo (json_encode($data));
        die;
    }
    public function get_package_types(){
        $data = $this->service_model->get_package_types();
        echo (json_encode($data));
        die;
        
    }
    public function get_package_category(){
        
        $ptype = $this->input->post('package_type_id');
        
        $data = $this->service_model->get_package_category($ptype);
        echo (json_encode($data));
        die;
        
    }
    public function get_loyaltyservices(){
        $data = $this->service_model->get_loyalty_serices($this->input->post('loyalty_points'));
        echo (json_encode($data));
        
    }
    public function search_loyaltyservices(){
        
        $data = $this->service_model->search_all_services($this->input->get('servicename'));
        echo (json_encode($data));
        
    }
    
    public function search_all_services(){
        
        $data = $this->service_model->search_all_services($this->input->get('servicename'));
        echo (json_encode($data));
        
    }
    
    public function getServiceProducts(){
        $serviceid = $this->input->post('serviceid');
        $data = $this->service_model->get_service_products($serviceid);
        echo (json_encode($data));
    }
    
    public function pricelist(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $data['nav'] = 'reception';
            $data['subnav'] = 'pricelist';

            $data['service_types'] = $this->service_model->get_services_types();
            $data['business'] =  $this->business_model->getbusinessdetails();
            $taxes=$this->business_model->getbusinesstaxes('service');
            $ttax=0;
            foreach ($taxes as $tax){
                $ttax=$ttax+$tax['tax_percentage'];
            }

            $data['taxes']=$ttax;

            $x=0;
            foreach($data['service_types'] as $d){

                if(!file_exists('assets/images/servicetype/'.$d->service_type_image) || empty($d->service_type_image)){
                    $data['service_types'][$x]->service_type_image = 'nu.jpg';
                }

                $x++;
            }

            $data['service_categories'] = $this->service_model->getservice_categories();
            $x=0;
            foreach($data['service_categories'] as $d){

                if(!file_exists('assets/images/servicetype/'.$d['service_category_image']) || empty($d['service_category_image'])){
                    $data['service_categories'][$x]['service_category_image'] = 'nu.jpg';
                }

                $x++;
            }

            $data['services'] = $this->service_model->get_services();

            $this->load->view('includes/header', $data);
            $this->load->view('pricelist_view');
            $this->load->view('includes/footer');
        }
    }
}
