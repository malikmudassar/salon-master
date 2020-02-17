<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('report_model');
        $this->load->model('product_model');
        $this->load->model('service_model');
        $this->load->model('staff_model');
        $this->load->model('business_model');
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        }
        //storemanager,hr,reception...user serial
        checkroles(1, 1, 0);
    }

    public function reports() {
         if ($this->session->userdata('role') == '' || $this->session->userdata('role') == 'Sh-Users' ) {
             $this->load->view('login_view');
         }else{
            $data['nav'] = 'reports';
            $data['subnav'] = 'reports';

            $data['brands'] = $this->product_model->get_all_brands();
            $data['servicetypes'] = $this->service_model->get_services_types();
            $data['staff'] = $this->staff_model->all_staff();
            $data['business'] = $this->business_model->get_all_businesses();
            if($this->session->userdata('common_products')=='No'){
                 $data['stores'] = $this->product_model->get_business_stores();
            }else {
                $data['stores'] = $this->product_model->get_stores();
            } 
            $this->load->view('includes/header', $data);
            $this->load->view('report_view');
            $this->load->view('includes/footer');
         }
    }

    public function sales() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);

        //$data['rpt_name']="Cumulative Sale";
        $data = $this->report_model->allsales($startdate, $enddate);

        echo(json_encode($data));
    }

    public function msales() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);

        //$data['rpt_name']="Cumulative Sale";
        $data['sales'] = $this->report_model->monthly_sales($startdate, $enddate);
        $data['advance'] = $this->report_model->monthly_advances($startdate, $enddate);
        $data['voucher'] = $this->report_model->monthly_vouchers($startdate, $enddate);
        
        
        echo(json_encode($data));
    }

    public function product_usage_summary() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->report_model->product_usage_summary($startdate, $enddate);
        echo(json_encode($data));
    }

    public function product_usage_details() {
        $product_id = $this->input->post('product_id', TRUE);
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->report_model->product_usage_details($product_id, $startdate, $enddate);
        echo json_encode($data);
    }

    public function category_sales() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);

        //$data['rpt_name']="Cumulative Sale";
        $data = $this->report_model->category_sales($startdate, $enddate);

        echo(json_encode($data));
    }
    
    public function service_sales() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);

        //$data['rpt_name']="Cumulative Sale";
        $data = $this->report_model->service_sales($startdate, $enddate);

        echo(json_encode($data));
    }

    public function service_sale_details() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);

        $data = $this->report_model->service_sale_details($startdate, $enddate);

//        $i = 0;
//        foreach ($data as $row) {
//            $data[$i]['staff'] = rtrim(str_replace('|', ', ', $row['staff']), ', ');
//            $i++;
//        }

        echo(json_encode($data));
    }

    public function staff_performance() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);

        $data = $this->report_model->staff_performance($startdate, $enddate);

        echo(json_encode($data));
    }

    public function product_sales() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);

        //$data['rpt_name']="Cumulative Sale";
        $data = $this->report_model->product_sales($startdate, $enddate);

        echo(json_encode($data));
    }

    public function product_sale_details() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);

        $data = $this->report_model->product_sale_details($startdate, $enddate);

        echo(json_encode($data));
    }

    public function invoices() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);


        $data = $this->report_model->invoices($startdate, $enddate);

        echo(json_encode($data));
    }

    
    public function recoveries() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);


        $data = $this->report_model->recoveries($startdate, $enddate);

        echo(json_encode($data));
    }
    
    public function cancelled_invoices() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);


        $data = $this->report_model->cancelled_invoices($startdate, $enddate);

        echo(json_encode($data));
    }
    
    public function commission_details() {
        $staff_id = $this->input->post('staff_id', TRUE);
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);

        $data = $this->report_model->commission_details($staff_id, $startdate, $enddate);

        echo(json_encode($data));
    }
    
    
   
    public function commissions() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);

        $data = $this->report_model->commissions($startdate, $enddate);

        echo(json_encode($data));
    }

    public function retail_commission_details() {
        $staff_id = $this->input->post('staff_id', TRUE);
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);

        $data = $this->report_model->retail_commission_details($staff_id, $startdate, $enddate);

        echo(json_encode($data));
    }
    
    public function retailcommissions() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);

        $data = $this->report_model->retailcommissions($startdate, $enddate);

        echo(json_encode($data));
    }
    
    public function taxes() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);

        $data = $this->report_model->taxes($startdate, $enddate);

        echo(json_encode($data));
    }

    public function attendance() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $this->load->model('staff_model');

        $data['attendance'] = $this->report_model->attendance($startdate, $enddate);
        $data['staff'] = $this->staff_model->all_staff();
        $data['attendance_month_view'] = $this->report_model->attendance_month_view($startdate, $enddate);
        echo(json_encode($data));
    }

    public function discount() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);

        $data = $this->report_model->discount($startdate, $enddate);

        echo(json_encode($data));
    }

    public function voucher() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);

        $data = $this->report_model->voucher($startdate, $enddate);

        echo(json_encode($data));
    }

    public function bad_debts() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);

        $data = $this->report_model->bad_debts($startdate, $enddate);

        echo(json_encode($data));
    }

    public function stock_status() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $store_id= $this->input->post('store_id', TRUE);
        $data = $this->product_model->get_brand_date_stock("0", "0",$startdate, $enddate,$store_id,"");

        echo(json_encode($data));
    }
    
    public function stock_status_brand() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $brandid = $this->input->post('brandid', TRUE);
        
        $producttype = $this->input->post('producttype', TRUE);
        $store_id= $this->input->post('store_id', TRUE);
        $data = $this->product_model->get_brand_date_stock($brandid, $producttype, $startdate, $enddate,$store_id,"");
        
        echo(json_encode($data));
    }

    function expenses() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->report_model->expenses($startdate, $enddate);
        echo(json_encode($data));
    }

    public function dispatch_report() {

        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->report_model->get_dispatch_report($startdate, $enddate);
        echo(json_encode($data));
    }

    public function dispatch_details(){
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->report_model->get_dispatch_details($startdate, $enddate);
        echo(json_encode($data));
    }
    
    public function cancelled_visits(){
        
        
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->report_model->cancelled_visits($startdate, $enddate);
        echo(json_encode($data));
        
        
    }
    
    public function open_visits(){
        
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->report_model->open_visits($startdate, $enddate);
        echo(json_encode($data));
        
        
    }
    
    public function advance_collected(){
        
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->report_model->advance_collected($startdate, $enddate);
        echo(json_encode($data));
        
        
    }
    
    public function customer_profile(){
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->report_model->customer_profile($startdate, $enddate);
        
        //$this->load->model('customer_model');
        //$data = $this->customer_model->general_search('', '', '');
        echo(json_encode($data));
    }
    
    public function new_customers(){
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->report_model->new_customers($startdate, $enddate);
        echo(json_encode($data));
    }
    
    public function returning_customers(){
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->report_model->returning_customers($startdate, $enddate);
        echo(json_encode($data));
    }
    
    
    public function cash_register(){
        
        $this->load->model('invoice_model');
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate');
        
        $transactions=[];
        $denominations=[];
        $expenses=[];
        $vouchers=[];
        $yesterdaytill=[];
        
        $start=explode("-",$startdate);
        $end=explode("-",$enddate);
        
        $today=$startdate;
        
        while($today <= $enddate){
           
           $tomorrow=$this->report_model->gettomorrowfromserver($today);
           
           array_push($transactions, $this->report_model->cash_register($today, $tomorrow));
           array_push($denominations, $this->report_model->get_cash_register($today, $tomorrow));
           array_push($expenses, $this->report_model->get_today_expenses($today, $tomorrow));
           array_push($vouchers, $this->report_model->get_cash_voucher($today, $tomorrow));
           array_push($yesterdaytill, $this->report_model->get_yesterday_till_amount($today, $tomorrow));
                   
           $start=explode("-",$tomorrow);
           $today=$tomorrow;
        }
        $data['transactions']=$transactions;
        $data['denominations']=$denominations;
        $data['expenses']=$expenses;
        $data['vouchers']=$vouchers;
        $data['yesterdaytill']=$yesterdaytill;
//        $data = array_merge($transactions, $denominations);
        echo(json_encode($data));
    }
    
    
    public function payment_breakup(){
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->report_model->payment_breakup($startdate, $enddate);
        echo(json_encode($data));
    }
    
    public function payment_breakup_services(){
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->report_model->payment_breakup($startdate, $enddate,'service');
        echo(json_encode($data));
    }
    
    public function payment_breakup_sale(){
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->report_model->payment_breakup($startdate, $enddate,'sale');
        echo(json_encode($data));
    }
    public function staff_retail_sale_summary(){
        
        
         $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->report_model->staff_retail_sale_summary($startdate, $enddate);
        echo(json_encode($data));
        
    }
    
    public function receivables(){
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->report_model->receivables($startdate, $enddate);
        echo(json_encode($data));
        
    }
    
    public function recoveryinvoices(){
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->report_model->recoveryinvoices($startdate, $enddate);
        echo(json_encode($data));
        
    }
    
    public function loyaltyredemption(){
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $business_id = $this->input->post('business_id', TRUE);
        
        $data = $this->report_model->loyaltyredemption($startdate, $enddate, $business_id);
        echo(json_encode($data));
        
    }
    
    public function sharedcustomers(){
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $business_id = $this->input->post('business_id', TRUE);
        
        $data = $this->report_model->sharedcustomers($startdate, $enddate, $business_id);
        echo(json_encode($data));
        
    }
    
    public function careofcustomers(){
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->report_model->careofcustomers($startdate, $enddate);
        echo(json_encode($data));
        
    }

        public function requested(){
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $business_id = $this->input->post('business_id', TRUE);
        
        $data = $this->report_model->requested($startdate, $enddate, $business_id);
        echo(json_encode($data));
        
    }
    

}
