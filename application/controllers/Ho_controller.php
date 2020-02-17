<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ho_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('pos_model');
        $this->load->model('business_model');
        $this->load->model('customer_model');
        $this->load->model('order_model');
        $this->load->model('invoice_model');
        $this->load->model('visits_model');
        $this->load->model('staff_model');
        $this->load->model('scheduler_model');
        $this->load->model('service_model');
        $this->load->model('ho_model');

        if ($this->session->userdata('role') == '') {
            redirect('logout');
        }
    }
    
    public function index() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            
            checkroles(0, 0, 1);

            $data['nav'] = 'ho_view';

            //$data['menu'] = 'hidden';
            
            $data['user_role'] = $this->session->userdata('role');
            $data['business'] = $this->business_model->getbusinessdetails();
            
            
            $this->load->view('includes/header', $data);
            $this->load->view('ho/ho_view');
            $this->load->view('includes/footer');
            
        }
    }
    
    public function period_booking_list(){
        
       if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {

                //storemanager,hr,reception...user serial
           checkroles(0,0,1);

           $data['nav'] = 'invoice';
           $data['subnav'] = 'appointments';

           $data['bookings'] = $this->ho_model->getbookings();
           $this->load->view('includes/header', $data);
           $this->load->view('ho/period_booking_list');
        $this->load->view('includes/footer');
        }
    }
    
    public function period_booking(){
        
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {

            $data['nav'] = 'scheduler';
            $data['scheduler_style'] = $this->business_model->getbusinessdetails();
            $data['user_role'] = $this->session->userdata('role');
           // $data['staff_list'] = $this->ho_model->staff_list();
            
            
            $this->load->view('includes/header', $data);
            $this->load->view('ho/period_booking');
            $this->load->view('includes/footer');    
        }
    }
    
    public function get_active_staff(){
        
        $data = $this->ho_model->get_active_staff();
        echo (json_encode($data));
        die;
        
    }
    
     public function get_package_types(){
        $data = $this->ho_model->get_package_types();
        echo (json_encode($data));
        die;
        
    }
    
    public function get_package_category(){
        
        $ptype = $this->input->post('package_type_id');
        
        $data = $this->ho_model->get_package_category($ptype);
        echo (json_encode($data));
        die;
        
    }
    
    public function create_booking(){

        $data=$this->ho_model->create_booking();
        echo($data);
        
    }
    
    public function print_booking($bookingid){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $data['nav'] = 'invoice';
            //Get Visits
            $data['visits']=$this->ho_model->getavisitsbybookingid($bookingid);

            $data['business']=$this->business_model->getbusinessdetails();
            $data['category'] = $this->ho_model->get_package_category($data['visits'][0]['id_package_type']);

            if($data['visits']){



                $data['menu'] = 'hidden';

                $this->load->view('includes/header', $data);
                $this->load->view('ho/print_booking_view');
                $this->load->view('includes/footer');

            } else{
                echo 'Booking not found!';
            }
        }
        
    }
    
    
    public function list_package_types(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'package_types';
            $data['packages_type'] = $this->ho_model->get_all_package_types();

            $this->load->view('includes/header', $data);
            $this->load->view('ho/settings/packages_type_view');
            $this->load->view('includes/footer');
        }
        
    }
    
    public function list_package_category($package_type_id){
       if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $data['nav'] = 'my_business';
            $data['subnav'] = 'package_types';
            $data['packages_category'] = $this->ho_model->get_package_category($package_type_id);

            $data['businesses'] = $this->business_model->get_all_businesses();
            $data['package_type_id']=$package_type_id;

            $this->load->view('includes/header', $data);
            $this->load->view('ho/settings/packages_category_view');
            $this->load->view('includes/footer');
        }
    }
    
    public function package_category_image() {
        $this->load->model('packages_model');
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
                redirect(base_url('ho_list_package_category' . '/' . $this->input->post('id_package_type_image')));
            }
        }
    }
    
    public function add_package_category() {
        $result = $this->ho_model->add_package_category();
        echo('success|' . $result);
    }
    
    public function edit_package_category(){
        $data = $this->ho_model->edit_package_category();
        echo (json_encode($data));
       
    }
    
     public function ho_list_package_services($package_type_id) {
         if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

             $this->load->model('packages_model');


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
    
     public function change_visit_services_date(){
    
        $visit_service_date = $this->input->post('visit_service_date'); 
        $visit_service_ids =  $this->input->post('visit_service_ids'); 
        $customer_visit_id = $this->input->post('customer_visit_id'); 
        
        foreach($visit_service_ids as $visit_service_id){
            
            $result = $this->ho_model->change_date($visit_service_date, $visit_service_id, $customer_visit_id);
            
        }
        echo "success|";
        exit;
    }
    
    function cancelBooking() {

        $bookingid = htmlspecialchars($this->input->post('bookingid', TRUE));

        $update = $this->ho_model->cancelBooking($bookingid);

        echo $update;
    }
    
    function period_booking_report($start=null, $end=null, $staff=null){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {

            if($start==null){
                $start=$this->input->post('start');
                $end=$this->input->post('end');
                $staff=$this->input->post('staff');
            }
           //storemanager,hr,reception...user serial
           checkroles(0,0,1);

           $data['nav'] = 'invoice';
           $data['subnav'] = 'appointments';

           
           if(null !==$this->input->post('staff', TRUE)){
                $data['selecteduser'] = $this->input->post('user', TRUE);
            } else {
                $data['selecteduser'] = "All";
            }
            
           $this->load->model('user_model');
           $data['users'] = $this->user_model->get_visible_users();
           $data['bookings'] = $this->ho_model->booking_report($start,$end,$staff);
           $data['start']=$start;
           $data['end']=$end;
           $this->load->view('includes/header', $data);
           $this->load->view('ho/period_booking_report');
           $this->load->view('includes/footer');
        }
    }
}