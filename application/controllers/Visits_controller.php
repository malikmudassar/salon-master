<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Visits_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('visits_model');
        if($this->session->userdata('role')==''){
            redirect('logout');
        }
    }

    public function get_visits() {
        //get the posted values
        
        $data = $this->visits_model->get_visits();
        //print_r($data); exit;
        echo(json_encode($data));
        
    }
        
    public function getVisitbyid($qtype=0){
        $visitid=$this->input->post('id_customer_visit', TRUE);
        if($qtype==0){
            $data['services'] = $this->visits_model->getvisitservices($visitid);
            $data['staffs']=$this->visits_model->getvisitstaffs($visitid);
            $data['visits'] = $this->visits_model->getopenvisitbyid($visitid);
            $data['advances'] = $this->visits_model->getopenvisitadvancebyid($visitid);
        } else {
            $data = $this->visits_model->getvisitbyid($visitid);
        }
        echo(json_encode($data));
    }
    
    function getvisitdetails(){
        
        $visit_id = htmlspecialchars($this->input->post('visit_id', TRUE));
        $data['services'] = $this->visits_model->getServicesByVisitId($visit_id);
        echo json_encode($data);
        
    }
    
     public function getVisitbyCid(){
        $data = $this->visits_model->getvisitbycid();
        echo(json_encode($data));
    }
    
    public function getPassedVisitbyCid(){
        $data = $this->visits_model->getpassedvisitbycid();
        echo(json_encode($data));        
    }
    
    
    public function updatevisit(){
        exit();
        $result=$this->visits_model->update_visit();
        echo "success|".$result;
    }
    
    public function getlast4visits($customerid){
        
        $data=$this->visits_model->getlast4visits($customerid);
        echo(json_encode($data));
    }
 
    
    public function getstaffclient(){
        $staffid=$this->input->post('visitid', TRUE);
        $data=$this->visits_model->getstaffclient($staffid);
        echo(json_encode($data));
    }
 
    public function add_visit_advance() {
    
        $data=$this->visits_model->update_advance();
        echo(json_encode($data));
        
    }
    public function remove_advance() {
    
        $data=$this->visits_model->remove_advance();
        echo($data);
        
    }
    
    public function create_booking(){

        $data=$this->visits_model->create_booking();
        echo($data);
        
    }
     public function check_visit(){
        $visitid=$this->input->post('visit_id');
        $data=$this->visits_model->getopenvisitbyid($visitid);
        echo(json_encode($data));
    }
    
    public function open_visits() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $data['visits']=$this->visits_model->open_visit_list();


            $this->load->view('includes/header', $data);
            $this->load->view('open_visits');
            $this->load->view('includes/footer');
        }
        
    }
    public function reminder_message_update(){
        $data = $this->visits_model->reminder_message_update();
        if($data){
            echo "success|".$data;
            exit;
        }
    }
    public function add_visit_remarks(){
        $visitid=$this->input->post('visit_id');
        $visitremarks=$this->input->post('visitremarks');
        
        $data = $this->visits_model->add_visit_remarks($visitid, $visitremarks);
        if($data){
            echo "success|".$data;
            exit;
        }
        
    }
}