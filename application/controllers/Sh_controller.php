<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sh_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('sh_model');
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
        $this->load->model('colors_model');
        $this->load->model('eyelashes_model');
        $this->load->model('accounting_model');
        $this->load->model('supplier_model');
        $this->load->model('appointment_model');
        $this->load->model('expense_model');
        $this->load->model('product_model');
        $this->load->model('user_model');
        
        
        
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        }
    }
    
    ///Dashboard////
    public function sh_dashboard() {
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        } else {
            
            
            $data['chart']='chart';
        $data['nodatatable']='nodatatable';
        
            // business_sale data inserting
            $month = date('M', strtotime('first day of previous month'));
            $year = date('Y', strtotime('first day of previous month'));

                $result = $this->sh_model->get_business_sale_year_month($month, $year);

                if ($result) {
                    
                } else {
                    $start = date('Y-m-d', strtotime('first day of previous month'));
                    $end = date('Y-m-d', strtotime('last day of previous month'));
                    $result = $this->sh_model->get_this_month_year_sale($start, $end);
                    $data = array(
                        'business_id' => $this->session->userdata('businessid'),
                        'month' => date('M', strtotime($start)),
                        'year' => date('Y', strtotime($start)),
                        'total_sale' => empty($result->total_sale) ? 0 : $result->total_sale
                    );
                    $result = $this->sh_model->add_this_month_year_sale($data);
                }

                // business_sale chart drawing
                $years = $this->sh_model->get_business_sale_years();

                $html = "";

                foreach ($years as $y) {

                    $months = array(
                        $y->year => array(
                            'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0,
                            'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0,
                            'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0
                        )
                    );

                    $sales = $this->sh_model->get_business_sales($y->year);

                    $html .= "{ name: '$y->year', ";
                    $html .= "data: [";

                    foreach ($sales as $sale) {
                        foreach ($months[$y->year] as $key => $value) {
                            if ($sale->month == $key) {
                                $months[$y->year][$key] = $sale->total_sale;
                            }
                        }
                    }

                    foreach ($months[$y->year] as $m) {
                        $html .= $m . ",";
                    }

                    $html .= "] ";

                    $html .= "},";
                }

                $data['sales'] = rtrim($html, ',');
                
               //get work week
               $workweek = $this->sh_model->get_workweek();
               
               
               $data['days'] =[];
               $x=0;
               foreach($workweek as $ww){
                   
                   $data['days'][$x] = $ww['day'];        
                   $data['Customers'][$x] = (float)$ww['Customers'];
                   $data['Services'][$x] = (float)$ww['Services'];
                   $data['Revenue'][$x] = (float)$ww['Revenue'];
                   $data['Balance'][$x] = (float)$ww['Balance'];
                  
                   $x++;
                   
                }
                
               //get work month
               $workweek = $this->sh_model->get_workmonth();
               
               
               $data['mdays'] =[];
               $x=0;
               foreach($workweek as $ww){
                   
                   $data['mdays'][$x] = $ww['day'];        
                   $data['mCustomers'][$x] = (float)$ww['Customers'];
                   $data['mServices'][$x] = (float)$ww['Services'];
                   $data['mRevenue'][$x] = (float)$ww['Revenue'];
                   $data['mBalance'][$x] = (float)$ww['Balance'];
                   
                   $x++;
                   
                }
                
                $this->load->view('includes/sh_header', $data);
                $this->load->view('shadow/sh_dashboard');
                $this->load->view('includes/footer');
            }
            
        
    }
    
    public function todayssale() {
        //get todays sale
        $data['Today'] = $this->sh_model->get_todaysale();
        
        //get yesterday sale
        $data['Yesterday'] = $this->sh_model->get_yesterdaysale();
                
         echo(json_encode($data)); 
        
    }
    public function yesterdaysale() {
        //get yesterday sale
        $data  = $this->sh_model->get_yesterdaysale();
        echo(json_encode($data)); 
        
    }
    
    public function monthsale() {
        //get the posted values
        
       // $data  = $this->dashboard_model->get_month();
        
        $data['invoice']  = $this->sh_model->m_invoice();
     
         
        echo(json_encode($data)); 
        
    }

     public function yearsale() {
        //get the posted values
        
        $data  = $this->sh_model->get_year();
        
         echo(json_encode($data)); 
        
    }
    
    public function monthlysale() {
        //get the posted values
        
        $data  = $this->sh_model->get_monthly();
        
         echo(json_encode($data)); 
        
    }
    
     public function dailysale() {
        //get the posted values
        
        $data  = $this->sh_model->get_daily();
        
         echo(json_encode($data)); 
        
    }
     public function get_month_commission(){
        $data  = $this->sh_model->get_month_commission();
        
         echo(json_encode($data)); 
       
   }
   
   public function top_4_staff(){
        $data  = $this->sh_model->top_4_staff();
         
        echo(json_encode($data)); 
       
   }
   
      public function top_4_clients(){
        $data  = $this->sh_model->top_4_clients();
        
         
        echo(json_encode($data)); 
       
   }
   
    public function grossing_services(){
        $data  = $this->sh_model->grossing_services();
          
        echo json_encode($data);
       
   }
   ///Dashboard///
   
   //Customer///
    public function customer_previous_visit($customerid, $getvisits='No', $getinvoices='No') {//getbusinessdetails

        //storemanager,hr,reception...user serial
        checkroles(0, 0, 1);

        $visit_ids = array();
        $data['menu'] = 'hidden';
        $visitcount=0;
        $invoicecount=0;
        
        
        $data['getvisits']=$getvisits;
        $data['getinvoices']=$getinvoices;
        $data['customer'] = $this->customer_model->get_byid($customerid);
        $data['business'] = $this->business_model->getbusinessdetails();
        
        if($getvisits=="No"){
            $visitcount=$this->customer_model->customer_visit_count($customerid, true);
            
        }
        if($getinvoices=="No"){
            $invoicecount=$this->customer_model->customer_invoice_count($customerid, true);
        }
        
        if($getvisits=='Yes' || $visitcount->count<=50){
            $data['visits'] = $this->customer_model->customer_all_visits($customerid, true);

            foreach ($data['visits'] as $visitid) {
                $visit_ids[] = $visitid['id_customer_visits'];
            }

            $data['visit_services'] = $this->customer_model->customer_visit_services($visit_ids);
            $data['staff'] = $this->customer_model->get_visit_staff($visit_ids);
            $data['product'] = $this->customer_model->get_visit_product($visit_ids);
            
            $data['novisits'] = "false";
            
        } else {
            $data['novisits'] = $visitcount->count ." previous visits in the database.";
            
        }    
        
        if($getinvoices=='Yes' || $invoicecount->count<=50){    
            $data['invoices'] = $this->customer_model->get_invoice_visit($customerid, true);
            $data['noinvoices']= "false";
        } else{
            $data['noinvoices'] = $invoicecount->count ." previous invoices in the database.";
        }
        $data['color_records'] = $this->colors_model->get_customer_color_records($customerid, true);
        $data['facial_records'] = $this->service_model->get_customer_facial_records($customerid, true);
        $data['eyelashes'] = $this->eyelashes_model->get_customer_eyelashes_records($customerid, true);

        $data['customerbalance'] = $this->customer_model->customerbalance($customerid, true);
        
        $data['customer_loyalty'] = $this->customer_model->get_customer_loyalty($customerid);
        
        
        //echo "<pre>";print_r($data['staff']);echo "</pre>";die;
        $this->load->view('includes/header', $data);
        $this->load->view('customer_previous_visit');
        $this->load->view('includes/footer');
    }
 ///////Customer////
   
/////Scheduler///////
    public function sh_scheduler($defaulDate = "") {
        
        $data['calendar']='calendar';
        $data['nodatatable']='nodatatable';
        
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        } else {

            if ($this->session->userdata('role') == 'HR') {
                redirect(base_url('staff_list'));
            }

            $data['nav'] = 'scheduler';
            
            $data['scheduler_style'] = $this->business_model->getbusinessdetails();
            
            $limit=30;
            if(null!==$this->input->post('off_set')){
                $off_set=$this->input->post('off_set');
            }else {
                $off_set = 0;
            }
            //Adding shifts to scheduler
            if(null!==$data['scheduler_style'][0]['shifts'] && $data['scheduler_style'][0]['shifts']==='Y'){
                $data['time'] = $this->business_model->get_shift_timing();
                $staff_count = $this->scheduler_model->staff_shift_count($data['time']->id_shifts);
                $data['pages']= ceil($staff_count->staff_count/$limit);
                $data['limit']= $limit; 
                $data['off_set']= $off_set; 
                $data['staff_count']=$staff_count->staff_count; 
                $data['staff_list'] = $this->scheduler_model->staff_shift_list($data['time']->id_shifts, $off_set, $limit);
            } else {
                $data['time'] = $this->business_model->get_business_timing();
                $staff_count = $this->scheduler_model->staff_count();
                $data['pages']= ceil($staff_count->staff_count/$limit); 
                $data['limit']= $limit; 
                $data['off_set']= $off_set;
                $data['staff_count']=$staff_count->staff_count; 
                $data['staff_list'] = $this->scheduler_model->staff_list($off_set, $limit);
            }
            
            /////
            $data['user_role'] = $this->session->userdata('role');
            
            $resourceList = "";

            foreach ($data['staff_list'] as $staff) {

                $resourceList .= '{id: ' . $staff->id_staff . ', ';

                $img_path = 'assets/images/staff/';
                $staff_image = file_exists('assets/images/staff/' . $staff->staff_image) ? $img_path . $staff->staff_image : $img_path . "no-image.png";

                $resourceList .= 'title: "' . $staff->staff_fullname . '",';
                $resourceList .= 'staff_shared: "' . $staff->staff_shared . '"},';
            }


            $events = "";

            $data['resources'] = rtrim($resourceList, ',');
            $data['events'] = rtrim($events, ',');
            

            if(null!==$this->session->flashdata('defaultDate')){
                $data['defaultDate'] = $this->session->flashdata('defaultDate');
            }else{
                $data['defaultDate'] = $this->input->post('defaultDate');
            }

            $this->load->view('includes/sh_header', $data);
            $this->load->view('scheduler_view');
            $this->load->view('includes/footer');
        }
    }    
    
    function sh_todayinvoices(){
        
        //storemanager,hr,reception...user serial
        //checkroles(1,0,1);
        
        $data['nav'] = 'invoice';
        $data['subnav'] = 'todayinvoices';
        
        $data['invoices']=$this->invoice_model->gettodayinvoices(null, 'asc', 'all', true);
        
        $this->load->view('includes/sh_header', $data);
        $this->load->view('invoice_list');
        $this->load->view('includes/footer');
        
    }
    
    function sh_recoveryinvoices(){
        
        //storemanager,hr,reception...user serial
        checkroles(1,0,1);
        
        $data['nav'] = 'invoice';
        $data['subnav'] = 'recoveryinvoices';
        
        $data['invoices']=$this->invoice_model->getrecoveryinvoices(true);
        
        $this->load->view('includes/sh_header', $data);
        $this->load->view('invoice_recovery');
        $this->load->view('includes/footer');
        
    } 
    
    public function daily_expense_list() {

        //storemanager,hr,reception...user serial
      

        $data['nav'] = 'invoice';
        $data['subnav'] = 'daily_expenses';
        
        $data['expense_accounts']=$this->accounting_model->get_all_till_account_heads('Expense');
        $data['cash_account']=$this->accounting_model->get_all_account_heads('Cash');
        $data['suppliers']=$this->supplier_model->get_suppliers();
        
        $this->load->view('includes/sh_header', $data);
        $this->load->view('daily_expense_view');
        $this->load->view('includes/footer');
    }
    
     public function appointments() {
               
        $data['nav'] = 'invoice';
        $data['subnav'] = 'appointments';
        
        $data['staffs'] = $this->staff_model->all_staff_list();
        $data['servicetypes'] = $this->service_model->get_services_types();
         $data['business']=$this->business_model->getbusinessdetails();
        
        //get the posted values
        $this->load->view('includes/sh_header' , $data);
        $this->load->view('appointments_list');
        $this->load->view('includes/footer');
        
    }
    
     public function bookings(){
    
        $data['nav'] = 'invoice';
        $data['subnav'] = 'appointments';
        
        $data['bookings'] = $this->appointment_model->getbookings();
        $this->load->view('includes/sh_header', $data);
        $this->load->view('period_booking_list');
        $this->load->view('includes/footer');
    }
    
    function period_booking(){
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        } else {

            $data['nav'] = 'scheduler';
            $data['scheduler_style'] = $this->business_model->getbusinessdetails();
            $data['user_role'] = $this->session->userdata('role');
            $data['staff_list'] = $this->scheduler_model->staff_list();
            
            
            $this->load->view('includes/sh_header', $data);
            $this->load->view('period_booking');
            $this->load->view('includes/footer');    
        }
    }
    
    function todaydashboard(){
       
        $data['nav'] = 'invoice';
        $data['subnav'] = 'daily_sheet';
        $date=$this->input->post('calendar_date', TRUE);
        
        if(!isset($date) || empty($date)){
             $date = date('Y-m-d');
        }
        
        //get the posted values
        $data['date'] = $date;        
        $data['business']=$this->business_model->getbusinessdetails();
        $data['invoices'] = $this->invoice_model->getdayinvoices($date);
        $data['vouchersale'] = [];
        $data['vouchers'] = [];
        $data['advances'] = [];
        //$data['vouchers'] = $this->voucher_model->getdayvouchers($date);
        $data['expenses'] = $this->expense_model->get_daily_expense_list($date, $date);
        $data['cashInfo'] = $this->invoice_model->get_today_cash_info($date);
        $data['cashregister'] = $this->invoice_model->get_cash_register($date);
        $data['yesterdaytill'] = $this->invoice_model->get_yesterday_till_amount($date);
        if(null !==$this->input->post('user', TRUE)){
            $data['selecteduser'] = $this->input->post('user', TRUE);
        } else {
            $data['selecteduser'] = "All";
        }
        
        $this->load->model('user_model');
        $data['users'] = $this->user_model->get_visible_users();
        
        $this->load->view('includes/sh_header', $data);
        $this->load->view('today_dashboard');
        $this->load->view('includes/footer');
        //$data = $this->appointment_model->get_appointments();
        //echo(json_encode($data));
    }
    
    public function sh_pricelist(){
        
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
        
        $this->load->view('includes/sh_header', $data);

        $this->load->view('pricelist_view');

        $this->load->view('includes/footer');
        
    }
    
     public function sh_all_product_list(){
        
        checkroles(1, 1, 1);

        $data['nav'] = 'my_business';
        
        $data['business'] = $this->business_model->getbusinessdetails();
        $data['brands'] = $this->product_model->get_all_brands();
        $data['measurement_unit'] = $this->product_model->get_measurement_unit();
        $data['subnav'] = 'product_list';
           // $data['products'] = $this->product_model->get_all_products($brandid,$tagged);
            $data['title']='All Products';
            $data['unit_types']=$this->product_model->get_unittypes();
            
            $this->load->view('includes/sh_header', $data);
            $this->load->view('setting/products_view_server');
            $this->load->view('includes/footer');
    }
    
    public function sh_pos_services(){
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        } else {
            checkroles(0, 0, 1);

            $data['nav'] = 'pos_view';
            $data['menu'] = 'hidden';            
            $data['nodatatable']='nodatatable';     
            
            $data['user_role'] = $this->session->userdata('role');
            $data['userid'] = $this->session->userdata('userid');
            $data['username'] = $this->session->userdata('fullname');

            $data['business'] = $this->business_model->getbusinessdetails();
            $data['taxes'] = $this->business_model->getbusinesstaxes('service');

            $data['staff_list'] = $this->scheduler_model->staff_list();

            $data['visits'] = $this->visits_model->open_visit_list();
            $data['inservice'] = $this->visits_model->inservice_visit_list();

            $data['type_list'] = $this->service_model->get_active_types();
            $data['category_list'] = $this->service_model->get_active_categories();
            $data['services_list'] = $this->service_model->get_active_services();

            $data['package_type_list'] = $this->service_model->get_active_package_types();
            $data['package_category_list'] = $this->service_model->get_active_package_categories();
            $data['package_services_list'] = $this->service_model->get_active_package_services();

            $data['totalinvoices'] = $this->invoice_model->get_day_services_count(true);
            // $data['visit_last_color'] = $this->scheduler_model->getLastVisitColor($start, $end);
            //Adding shifts to scheduler
            if (null !== $data['business'][0]['shifts'] && $data['business'][0]['shifts'] === 'Y') {
                $data['time'] = $this->business_model->get_shift_timing();
            } else {
                $data['time'] = $this->business_model->get_business_timing();
            }
            
            /////Server side data////
             if(null!==$this->input->post('id_customer_visit')){
                if($this->input->post('id_customer_visit')!==''){
                    $data['id_customer_visit']=$this->input->post('id_customer_visit');
                }
                $visitid = htmlspecialchars($this->input->post('id_customer_visit', TRUE));
                
                $data['openvisit'] = $this->visits_model->getopenvisitbyid($visitid);
                $data['openvisitservices'] = $this->visits_model->getvisitservices($visitid);
                $data['openvisitstaffs'] = $this->visits_model->getvisitstaffs($visitid);
                $data['openvisitadvances'] = $this->visits_model->getopenvisitadvancebyid($visitid);
                $data['openvisitserviceproducts'] = $this->visits_model->getvisitserviceproducts($visitid);

                $data['serviceproducts'] = array();
                foreach ($data['openvisitservices'] as $service) {
                   array_push($data['serviceproducts'], $this->service_model->get_services_products_byid($service['id_business_services']));
                }
                
            }
            
            if(null!==$this->input->post('customerid')){
                 if($this->input->post('customerid')!==''){
                    $data['id_customer']=$this->input->post('customerid');
                 }
            }
            //////////////
            
            $data['discount_types'] = $this->invoice_model->get_discounttypes();

            $this->load->view('includes/header', $data);
            $this->load->view('pos_services_view');
            $this->load->view('includes/footer');
        }
    }
    
    public function sh_pos_view(){

            $data['nav'] = 'pos_view';

            $data['menu'] = 'hidden';
            
            
            $data['nodatatable']='nodatatable';
            
            if(null!==$this->input->post('id_customer_order')){
                if($this->input->post('id_customer_order')!==''){
                    $data['id_customer_order']=$this->input->post('id_customer_order');
                }
                
            }
            
            if(null!==$this->input->post('customerid')){
                if($this->input->post('customerid')!==''){
                    $data['id_customer']=$this->input->post('customerid');
                }
            }
            
            $data['user_role'] = $this->session->userdata('role');
            $data['userid'] = $this->session->userdata('userid');
            $data['username'] = $this->session->userdata('fullname');

            $data['business'] = $this->business_model->getbusinessdetails();
            $data['taxes'] = $this->business_model->getbusinesstaxes('sale');

            $data['staff_list'] = $this->scheduler_model->staff_list();

            $data['orders'] = $this->order_model->get_open_orders();

            $data['totalinvoices'] = $this->invoice_model->get_day_retail_count();
            
            
            $this->load->view('includes/sh_header', $data);
            $this->load->view('pos_view');
            $this->load->view('includes/footer');
    }
    
     public function sh_reports() {
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
        $this->load->view('includes/sh_header', $data);
        $this->load->view('sh_report_view');
        $this->load->view('includes/footer');
    }
    
    
    function sh_users_list() {


        $data['nav'] = 'users';
        $data['subnav'] = 'users_list';

        $data['users'] = $this->user_model->get_users(true);
        $data['roles'] = $this->user_model->get_user_roles(true);
        $data['username']=$this->session->userdata('username');

        $this->load->view('includes/sh_header', $data);
        $this->load->view('users_list');
        $this->load->view('includes/footer');
    }
}