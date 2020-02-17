<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fixes_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
       $this->load->model('fixes_model');
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        }
    }

    
    public function index(){
        
        $this->load->view('includes/header');
        $this->load->view('setting/fixes_view');
        $this->load->view('includes/footer');
        
    }
    
    public function fix_total_sales(){
        
        $result = $this->fixes_model->fix_all_sales();
        echo $result;
                
    }
    
    public function fix_services_sales(){
        
        $result = $this->fixes_model->fix_services_sales();
        echo $result;
                
    }
    
    public function fix_retail_sales(){
        
        $result = $this->fixes_model->fix_retail_sales();
        echo $result;
                
    }
    
    
    public function fix_invioce_details() {
        
        
        $invoices = $this->fixes_model->get_invoices();
                
        foreach ($invoices as $invoice){
             print_r($invoice['id_invoice']);
            $total_services=0;    
            $result = $this->fixes_model->get_invoice_details($invoice['id_invoice']);
//            foreach($result as $row){
//                $total_services++;
//            }
            
            foreach ($result as $row){
                if($invoice['net_amount']>0){
                    $rate=$row['discounted_price']*100/$invoice['net_amount'];
                }else {$rate=0;}
                $data = array(
                    'paid'=>($invoice['paid_amount']*$rate)/100,
                    'invoice_detail_date'=>$invoice['invoice_date']
                );
                
                $a = $this->fixes_model->update_invoice_details($data, $row['id_invoice_details']);
                echo '<pre>';
                print_r($a);
                echo '<pre>';
                
            }
        }

        $this->load->view('settings/fixes_view');
    
    }
    
    public function fix_invoice_products() {
        
        
        $invoices = $this->fixes_model->get_sale_invoices();
                
        foreach ($invoices as $invoice){
            print_r($invoice['id_invoice']);
            $total_services=0;    
            $result = $this->fixes_model->get_invoice_products($invoice['id_invoice']);
//            foreach($result as $row){
//                $total_services++;
//            }
            
            foreach ($result as $row){
                if($invoice['net_amount']>0){
                    $rate=$row['discounted_price']*100/$invoice['net_amount'];
                }else {$rate=0;}
                $data = array(
                    'paid'=>($invoice['paid_amount']*$rate)/100
                );
                
                $a = $this->fixes_model->update_invoice_products($data, $row['id_invoice_products']);
                echo '<pre>';
                print_r($a);
                echo '<pre>';
                
            }
        }

        $this->load->view('settings/fixes_view');
    
    }

}
