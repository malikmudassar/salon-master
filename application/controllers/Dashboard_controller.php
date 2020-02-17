<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('dashboard_model');
        $this->load->model('product_model');
        if($this->session->userdata('role')==''){
            redirect('logout');
        }
    }

    public function todayssale() {
        //get todays sale
        $data['Today'] = $this->dashboard_model->get_todaysale();
        
        //get yesterday sale
        $data['Yesterday'] = $this->dashboard_model->get_yesterdaysale();
                
         echo(json_encode($data)); 
        
    }
    public function yesterdaysale() {
        //get yesterday sale
        $data  = $this->dashboard_model->get_yesterdaysale();
        echo(json_encode($data)); 
        
    }
    
    public function monthsale() {
        //get the posted values
        
       // $data  = $this->dashboard_model->get_month();
        
        $data['invoice']  = $this->dashboard_model->m_invoice();
        $data['advance']  = $this->dashboard_model->m_advance();
        $data['voucher']  = $this->dashboard_model->m_voucher();
         
        echo(json_encode($data)); 
        
    }
    
    public function yearsale() {
        //get the posted values
        
        $data  = $this->dashboard_model->get_year();
        
         echo(json_encode($data)); 
        
    }
    
    public function monthlysale() {
        //get the posted values
        
        $data  = $this->dashboard_model->get_monthly();
        
         echo(json_encode($data)); 
        
    }
    
    public function dailysale() {
        //get the posted values
        
        $data  = $this->dashboard_model->get_daily();
        
         echo(json_encode($data)); 
        
    }
   public function get_month_commission(){
        $data  = $this->dashboard_model->get_month_commission();
        
         echo(json_encode($data)); 
       
   }
   
   public function top_4_clients(){
        $data  = $this->dashboard_model->top_4_clients();
        
         
        echo(json_encode($data)); 
       
   }
   public function top_4_staff(){
        $data  = $this->dashboard_model->top_4_staff();
        
         
        echo(json_encode($data)); 
       
   }
   
    public function uninvoiced(){
        $data  = $this->dashboard_model->uninvoiced();
        
         
        echo(json_encode($data)); 
       
   }
   
    public function grossing_services(){
        $data  = $this->dashboard_model->grossing_services();
          
        echo json_encode($data);
       
   }
   public function out_of_stock_count() {
       $data  = $this->product_model->out_of_stock_count();
         
       echo json_encode($data);
   }
   
   public function expiring_products_count() {
       $data  = $this->product_model->expiring_products_count();
         
       echo json_encode($data);
   }
   
   public function get_work_month(){
       $data  = $this->product_model->get_workmonth();
         
       echo json_encode($data);
   }
}