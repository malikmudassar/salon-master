<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('invoice_model');
        $this->load->model('visits_model');
        $this->load->model('order_model');
        $this->load->model('business_model');
        $this->load->model('customer_model');
        $this->load->model('colors_model');
        $this->load->model('product_model');
        $this->load->model('sms_model');
        if($this->session->userdata('role')==''){
            redirect('logout');
        }
    }
    
    
    function new_return_invoice(){
        
       
        $data['nav'] = 'invoice';
        
        $visitid=$this->input->post('visit-id', TRUE);

        //Get the visit
        $data['visit']=$this->visits_model->getopenvisitbyid($visitid);
        
        
        if($data['visit']){
            
            $data['staffs']=$this->visits_model->getvisitstaffs($visitid);
            $data['products']=$this->visits_model->getvisitserviceproducts($visitid);
                        
            $data['color_record'] = $this->colors_model->get_color_record($visitid);
            
            if(count($data['color_record']) > 0){
                $data['color_record'] = FALSE;
            } else{
                $data['color_record'] = TRUE;
            }
        
            $data['facial_record'] = $this->colors_model->get_facial_records($visitid);
            
            if(count($data['facial_record']) > 0){
                $data['facial_record'] = FALSE;
            } else{
                $data['facial_record'] = TRUE;
            }
            $this->load->model('eyelashes_model');
            $data['eyelashes_record'] = $this->eyelashes_model->get_eyelashes_records($visitid);
            
            if(count($data['eyelashes_record']) > 0){
                $data['eyelashes_record'] = FALSE;
            } else{
                $data['eyelashes_record'] = TRUE;
            }
            
            
            //$this->nice_print_r($data['visit']); 
            $data['customer'] = $this->customer_model->get_byid($data['visit'][0]['customer_id']);
            $data['customer_points'] = $this->customer_model->get_customer_loyalty($data['visit'][0]['customer_id']);
            
            $data['balance'] = $this->customer_model->customerbalance($data['visit'][0]['customer_id']);
            $data['advances'] = $this->visits_model->getopenvisitadvancesumbyid($visitid);
            $data['advance_comments'] = $this->visits_model->getopenvisitadvancecommentsbyid($visitid);
            $data['color_type_list'] = $this->colors_model->color_type_list();
            $data['eyelashtypes'] = $this->eyelashes_model->eyelash_type_list();
            
            
            //Get all services
            $data['services']=$this->visits_model->getvisitservices($visitid);

            if($data['services'][0]['loyalty_service']==="Y"){
                $this->load->model('service_model');
                $data['loyalty_service']= $this->service_model->get_loyalty_rate($data['services'][0]['id_business_services']);               
            }
            
            //Get next invoive number
            $data['invoiceno']=$this->invoice_model->getnextinvoicenumber();

            $data['business']=$this->business_model->getbusinessdetails();
            $data['taxes']=$this->business_model->getbusinesstaxes();

            $data['menu'] = 'hidden';
            
            $data['WaterContent'] = $this->colors_model->get_WaterContent();
           
            $data['discount_types'] = $this->invoice_model->get_discounttypes();
            
            $this->load->view('includes/header', $data);
            $this->load->view('returninvoice_view');
            $this->load->view('includes/footer');
            
        } else{
            echo 'Invoice already generated for this Visit';
        }
    }
}