<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('voucher_model');
        if($this->session->userdata('role')==''){
            redirect('logout');
        }
    }

    public function validateVoucher() {
        $voucherno = htmlspecialchars(trim($this->input->post('voucherno', TRUE)));
        $data = $this->voucher_model->validate_voucher($voucherno);
        echo json_encode($data);
    }
    
    public function updateRemainingAmount() {
        $voucherno = htmlspecialchars(trim($this->input->post('voucherno', TRUE)));
        $remaining = htmlspecialchars(trim($this->input->post('remaining', TRUE)));
        $remaining_services = htmlspecialchars(trim($this->input->post('remaining_services', TRUE)));
        $data = $this->voucher_model->update_remaining_amount($voucherno, $remaining, $remaining_services);
        if($data){
            echo 'success';
        }
    }
    
    //Voucher list view function....
    public function voucher_list() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1,0,0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'voucher_list';

            $data['voucher_list'] = $this->voucher_model->voucher_list();

            $this->load->view('includes/header', $data);
            $this->load->view('setting/voucher_list_view');
            $this->load->view('includes/footer');
        }
    }
    
    function todayvouchers(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1,0,1);

            $data['nav'] = 'invoice';
            $data['subnav'] = 'todayvouchers';

            $data['voucher_list']=$this->voucher_model->gettodayvouchers();
            $data['showdelete']="Yes";


            $this->load->view('includes/header', $data);
            $this->load->view('setting/voucher_list_view');
            $this->load->view('includes/footer');
        }
        
    }
    
    //Voucher update function....
    function voucher_update(){
        $result = $this->voucher_model->voucher_update();
        if($result){
            echo 'success';
            die;
        }
    }
    
    //Voucher delete function.....
    public function delete_voucher(){
        $id = $this->input->post('id');
        $result = $this->voucher_model->delete_voucher($id);
        echo "success|" . $result;
    }
    
}