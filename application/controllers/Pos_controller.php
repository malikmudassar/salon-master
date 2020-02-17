<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pos_controller extends CI_Controller {

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
        $this->load->model('sms_model');

        if ($this->session->userdata('role') == '') {
            redirect('logout');
        }
    }

    public function index() {
        if ($this->session->userdata('role') == '' || $this->session->userdata('role') == 'Sh-Users' ) {
            redirect('logout');
        } else {
            
            checkroles(0, 0, 1);

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
            
            
            $this->load->view('includes/header', $data);
            $this->load->view('pos_view');
            $this->load->view('includes/footer');
        }
    }

    function pos_services() {
        //exit();
        if ($this->session->userdata('role') == '' || $this->session->userdata('role')=='Sh-Users') {
            redirect('logout');
        } else {
            checkroles(0, 0, 1);

            $data['nav'] = 'pos_view';

            $data['menu'] = 'hidden';
            
            $data['nodatatable']='nodatatable';
        
//            if(null!==$this->input->post('id_customer_visit')){
//                if($this->input->post('id_customer_visit')!==''){
//                    $data['id_customer_visit']=$this->input->post('id_customer_visit');
//                }
//            }
//            
//            if(null!==$this->input->post('customerid')){
//                 if($this->input->post('customerid')!==''){
//                    $data['id_customer']=$this->input->post('customerid');
//                 }
//            }
            
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

            $data['totalinvoices'] = $this->invoice_model->get_day_services_count();
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

    function get_open_visit(){
        $data['visits'] = $this->visits_model->open_visit_list();
        $data['inservice'] = $this->visits_model->inservice_visit_list();
        echo json_encode($data);
    }
    
    function get_customer_visit(){
        
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
        echo json_encode($data);
    }
    
    function pos_services_ss() {
        //exit();
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        } else {
            checkroles(0, 0, 1);

            $data['nav'] = 'pos_view';

            $data['menu'] = 'hidden';
            
            if(null!==$this->input->post('id_customer_visit')){
                if($this->input->post('id_customer_visit')!==''){
                    $data['id_customer_visit']=$this->input->post('id_customer_visit');
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

            $data['totalinvoices'] = $this->invoice_model->get_day_services_count();
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
            
            

            $this->load->view('includes/header', $data);
            $this->load->view('pos_services_ss');
            $this->load->view('includes/footer');
        }
    }
    
    function get_customer_details() {

        $customer_id = $this->input->post('customer_id');

        //Get Balance
        $data['balance'] = $this->customer_model->customerbalance($customer_id);
        $data['customer_points'] = $this->customer_model->get_customer_loyalty($customer_id);
        $data['customer_alerts'] = $this->customer_model->get_customer_alerts($customer_id);

        echo json_encode($data);
    }

    function get_color_for_visit() {

        $today = date('Y-m-d\TH:i:s');

        $data['last_color_code'] = $this->pos_model->get_color_for_visit($today);
    }

    public function addvisits() {

        $visit_id = htmlspecialchars($this->input->post('visit_id', TRUE));
        $customer_id = htmlspecialchars($this->input->post('customer_id', TRUE));
        $customer_name = htmlspecialchars($this->input->post('customer_name', TRUE));
        $last_color_code = htmlspecialchars($this->input->post('last_color_code', TRUE));
        $start = htmlspecialchars($this->input->post('start', TRUE));
        $advance_remarks= htmlspecialchars($this->input->post('advance_remarks', TRUE));

        $services = $this->input->post('services');
        $products = $this->input->post('products');
        $staff = $this->input->post('staff');

        $customer_visit_id = $this->pos_model->add_visit($customer_id, $visit_id, $last_color_code, $start, $advance_remarks);

        $result = $this->pos_model->add_visit_services($customer_visit_id, $customer_id, $customer_name, $services, $products, $staff, $start);

        echo "success|" . $customer_visit_id;
    }

    public function updatevisitpos() {

        $visit_id = htmlspecialchars($this->input->post('visit_id', TRUE));
        $customer_id = htmlspecialchars($this->input->post('customer_id', TRUE));
        $customer_name = htmlspecialchars($this->input->post('customer_name', TRUE));
        $last_color_code = htmlspecialchars($this->input->post('last_color_code', TRUE));
        $start = htmlspecialchars($this->input->post('start', TRUE));
        $advance_remarks= htmlspecialchars($this->input->post('advance_remarks', TRUE));
        
        $services = $this->input->post('services');
        $products = $this->input->post('products');

        $staff = $this->input->post('staff');

        $advances = $this->visits_model->getopenvisitadvancebyid($visit_id);
        
        $delete = $this->pos_model->removeVisit($visit_id);


        $customer_visit_id = $this->pos_model->add_visit($customer_id, 0, $last_color_code, $start, $advance_remarks);

        $result = $this->pos_model->add_visit_services($customer_visit_id, $customer_id, $customer_name, $services, $products, $staff, $start);

        if(sizeof($advances)>0){
            $result = $this->pos_model->move_advance($visit_id, $customer_visit_id);
        }
        
        echo "success|" . $customer_visit_id;
    }

    function getVisitbyid() {

        $visitid = htmlspecialchars($this->input->post('id_customer_visit', TRUE));

        $data['visits'] = $this->visits_model->getopenvisitbyid($visitid);
        $data['services'] = $this->visits_model->getvisitservices($visitid);
        $data['staffs'] = $this->visits_model->getvisitstaffs($visitid);
        $data['advances'] = $this->visits_model->getopenvisitadvancebyid($visitid);
        $data['visitserviceproducts'] = $this->visits_model->getvisitserviceproducts($visitid);
        $data['discount_types'] = $this->invoice_model->get_discounttypes();

        $data['serviceproducts'] = array();
        foreach ($data['services'] as $service) {
           array_push($data['serviceproducts'], $this->service_model->get_services_products_byid($service['id_business_services']));
        }

        echo(json_encode($data));
    }

    function createinvoice() {
       $visitid = $this->input->post('visitid');
       
       $data['visit']=$this->visits_model->getopenvisitbyid($visitid);
       if(!$data['visit']){
           
           echo 'error|This visit is alreday Invoiced from another terminal. Refresh Page!';
           exit();
           
       } 
        
       $customer_phone = $this->input->post('customercell');
       
       //verify retained_amount_usage
       $verification = $this->customer_model->get_customer_loyalty($this->input->post('customerid'));
       
       
       if(sizeof($verification)>0){
            
            if((float)$verification[0]['retained'] <  ((float)$this->input->post('retained_amount_used') + (float)$this->input->post('remaining_retained'))){
                echo 'error|Another Invoice used the customer advance. Refresh Page!';
                exit();
            }
      
            if((float)$verification[0]['loyalty_points'] <  (float)$this->input->post('loyaltyused')){
                echo 'error|Loyalty points already used in some other invoice. Refresh Page!';
                exit();
            }   
       }
        
        
        $services = $this->input->post('services');
        $staff = $this->input->post('staff');
        $products = $this->input->post('products');
        $taxes = $this->input->post('taxes');
        
        

        $invoicenumber = $this->input->post('invoicenumber');
        $invoicedate = $this->input->post('invoicedate');
        $customerid = $this->input->post('customerid');
        $customername = $this->input->post('customername');
        $customercell = $this->input->post('customercell');
        $customeraddress = $this->input->post('customeraddress');
        $customeremail = $this->input->post('customeremail');
        $subtotal = $this->input->post('subtotal');

        $loyaltyused = $this->input->post('loyaltyused');

        $grosstotal = $this->input->post('grosstotal');
        $paid = $this->input->post('paid');
        $paymentmode = $this->input->post('paymentmode');
        $cashpaid=0;$cardpaid=0;$voucherpaid=0;$checkpaid=0;
        if($paymentmode=="Cash"){$cashpaid=$paid;}
        else if($paymentmode=="Card"){$cardpaid=$paid;}
        else if($paymentmode=="Check"){$checkpaid=$paid;}
        else if($paymentmode=="Voucher"){$voucherpaid=$paid;}
        else if($paymentmode=="Mixed"){
            $cashpaid=$this->input->post('cashpaid', TRUE);
            $cardpaid=$this->input->post('cardpaid', TRUE);
        } 
        $grandtotal = $this->input->post('grandtotal');
        $totalpayable = $this->input->post('totalpayable');
        
        $taxtotal = $this->input->post('taxtotal');

        $instrumentnumber = $this->input->post('instrument_number');
        $balance = $this->input->post('balance');

        $uid = $this->input->post('uid');
        $uname = $this->input->post('uname');
        $uusername = $this->input->post('uusername');
        $uemail = $this->input->post('uemail');

        $discount = $this->input->post('discount');
        $discountremarks = $this->input->post('discount_remarks');
        $returnamount = $this->input->post('returnamount');
        $advance_amount = $this->input->post('advance_amount');
        $other_charges = $this->input->post('other_charges');
        $keepadv = $this->input->post('keepadv');
        $retained_used = $this->input->post('retained_used');
        $retained_amount_used = $this->input->post('retained_amount_used');
        $remaining_retained = $this->input->post('remaining_retained');
        $cctip = $this->input->post('cctip');
        $cc_charge = $this->input->post('cc_charge');
        $remarks = $this->input->post('remarks');
        $visitdate= $this->input->post('visitdate');
        $visittime= $this->input->post('visittime');
        
        $business = $this->business_model->getbusinessdetails();

        //Loyalty
        $totalpaid= ($advance_amount+$paid)-($cctip+$cc_charge);
        $paidnow=$paid-($cctip+$cc_charge);
        $loyaltyearned=0;
        if($business[0]['loyalty_enable']=='Y' && $business[0]['s_loyalty']=="Y" && (Float)$totalpaid>0) {
            $loyaltyearned=(Float)$totalpaid/ (Float)$business[0]['l_point_value'];
        } 
        if($loyaltyearned < 0){$loyaltyearned=0;}
        //var_dump($services); exit();
        ///Create Invoice Record
        //$invoice_number, $invoice_date, $customer_id,$customer_name, $customer_cell, $customeraddress, $customeremail, $subtotal,$paid,$returnamount,$discount,$grosstotal,$balance,$taxtotal,$grandtotal,$visitid,$paymentmode,$instrumentnumber,$remarks,$discountremarks,$loyaltyused, $visittime, $advance_amount, $other_charges, $retained_used, $customer_advance,$cctip,$loyaltyearned,$retained_amount_used,$cashpaid,$cardpaid,$voucherpaid,$checkpaid,$cc_charge,$totalpayable, $remaining_retained
        $invoiceid = $this->pos_model->insert_invoice($invoicenumber, $invoicedate, $customerid, $customername, $customercell, $customeraddress, $customeremail, $subtotal, $paid, $returnamount, $discount, $grosstotal, $balance, $taxtotal,$grandtotal,$visitid,$paymentmode, $instrumentnumber, $remarks, $discountremarks, $loyaltyused, $visittime, $advance_amount, $other_charges, $retained_used, $keepadv, $cctip, $loyaltyearned, $retained_amount_used, $cashpaid, $cardpaid, $voucherpaid, $checkpaid, $cc_charge, $totalpayable, $remaining_retained, $visitdate);
        
        
        ///Make sure invoice number is correct
        $seq = $this->pos_model->updateinvoicenumber($invoiceid, $paymentmode);
        //////////////////
        
        
        ///Update Customer Advance
        $a = $this->pos_model->updatecustomeradvance($customerid, $keepadv, $remaining_retained, $returnamount);
        //////////
        
        
        //insert invoice taxes
        if(isset($taxes)){
            foreach($taxes as $tax){
               $this->pos_model->insert_invoice_taxes($invoiceid,$tax['taxname'], $tax['tax']);
            }
        }
        
        //insert products
        if(isset($products)){
            foreach($products as $product){
                $this->pos_model->insert_invoice_products($invoiceid, $visitid, $product['service_id'], $product['service_name'], $product['product_id'], $product['product_name'], $product['qty'], $product['unit']);
            }
        }
        
        ///Do Services
        foreach ($services as $service) {
            $staff_count=0;
            foreach ($staff as $s) {
                if($s['row_id']==$service['row_id']){
                    $staff_count++;
                }
            }
            ///Calculate commission and paid ratios
            //Service Weights
            if($subtotal > 0){ 
                $service_weight=($service['unitcost']*100)/$subtotal;
            } else{
                $service_weight = 0;
            }
            //Calculate Wieghted Price            
            $service_price = ($totalpayable-$cctip-$cc_charge)*$service_weight/100;
            if($service_price<0){$service_price*-1;}//keep it positive
            //Calculate Paid
            $service_paid = ($totalpaid)*$service_weight/100;
            if($service_paid<0){$service_paid*-1;}//keep it positive
            
            
            //Calculate Commission
            $commission = ($service_paid * $service['commission']) / 100;    
            $commission_ratio =$commission/$staff_count;
            
            
            
            $invoice_detail_id = $this->pos_model->insert_invoice_details($service['row_id'], $invoiceid, $service_paid, $service['service_type'], $service['service_category'],  $service['service_id'], $service['service_name'], $service['service_duration'], $service['service_flag'], $service['id_service_category'], $service['discount'], $service['discount_type'], $service['unitcost'], $service['originalservicerate'], $service['visit_service_start']);
            
            foreach ($staff as $s) {
                if($s['row_id']==$service['row_id']){
                    
                    $invoice_staff = $this->pos_model->insert_invoice_staff($s['row_id'], $invoiceid, $service['service_type'], $service['service_category'],  $service['service_name'], $service['originalservicerate'],  $service['discount'], $service['unitcost'], $s['requested'], $s['staff_id'], $s['staff_name'], $staff_count, $s['staff_share'], $invoice_detail_id);
                    
                    $staff_services = $this->pos_model->insert_invoice_staff_services($s['row_id'], $invoiceid, $invoice_detail_id, $visitid, $s['staff_id'], $s['service_id'], $s['staff_name'], $service['service_type'], $service['service_category'], $service['service_name'], $s['staff_share'], $service['discount'], $service['commission'], $service_paid, $service['service_flag'], $s['requested'], $staff_count, $service['originalservicerate'], $s['staff_share'], $service_price);
                }
            }
        }
        
        $this->pos_model->update_visit_status($visitid,$seq);
        $this->session->unset_userdata('discount_session');
        
        ///Send Loyalty SMS
        if($business[0]['loyalty_sms']=='Yes' && sizeof($verification)>0){
            $this->load->model('scheduled_tasks_model');
            $loyalty_text = $this->scheduled_tasks_model->get_loyalty_text();
            
            $newloyaltypoints = $verification[0]['loyalty_points'];
            $customername= $verification[0]['customer_name'];
            
            
            $msg='Hi '.$customername.', Thank you for visiting '.$business[0]['business_name'].'. ';
            if($business[0]['loyalty_enable']=='Y'){
                if((Int)$loyaltyearned>0 && (Int)$invoiceid>0 && strlen($customer_phone)==11 && $business[0]['show_points']=='Yes'){
                   $newloyaltypoints =  (float)$newloyaltypoints+(float)$loyaltyearned;
                   $msg=$msg.' You have earned '. $loyaltyearned .' points today. Your total points available are '.$newloyaltypoints.'. ';
                } else if((Int)$loyaltyearned>0 && (Int)$invoiceid>0 && strlen($customer_phone)==11 && $business[0]['show_amount']=='Yes'){
                   
                   $msg=$msg.' You total bill amount is '. $totalpayable .'. ';
                }              
            }
           if($loyalty_text!==null && $loyalty_text!==''){
                $msg=$msg.$loyalty_text->msg;
            }
            //$sendsms = $this->send_sms('Hi '.$customername.', Thank you for visiting '.$business[0]['business_name'].'. Your earned Loyalty Points are '.$newloyaltypoints.'. Hoping to see you soon.', $customer_phone); 
            $sendsms = $this->sms_model->send_sms(utf8_encode(trim($msg)), $customer_phone, false, 'LoyaltySMS', false, $business[0]['id_business']); 
            //$updatelog = $this->invoice_model->invoice_sms_update($invoiceid[0], $sendsms);
        }
        
        if($business[0]['admin_notifications']==='Yes' && (Int)$invoiceid > 0){
            $admins = $this->business_model->get_business_admins();
            
            $thisInvoice = $this->invoice_model->getinvoicebyid($invoiceid);
            
            $msg='Invoice#: '.$thisInvoice[0]['id_invoice'].'\n Time: '.$thisInvoice[0]['invoice_date'].'\n Customer: '.$thisInvoice[0]['customer_name'];
            $msg=$msg.'\n Payable: '.number_format($thisInvoice[0]['net_amount']);
            if($thisInvoice[0]['payment_mode']=='Cash'){$msg=$msg.'\n Cash: '.number_format($thisInvoice[0]['paid_cash']);}
            if($thisInvoice[0]['payment_mode']=='Card'){$msg=$msg.'\n Card: '.number_format($thisInvoice[0]['paid_card']);}
            if($thisInvoice[0]['payment_mode']=='Check'){$msg=$msg.'\n Check: '.number_format($thisInvoice[0]['paid_check']);}
            if($thisInvoice[0]['payment_mode']=='Vocher'){$msg=$msg.'\n Voucher: '.number_format($thisInvoice[0]['paid_voucher']);}
            if((int)$thisInvoice[0]['balance']>0){$msg=$msg.'\n Balance: '.number_format($thisInvoice[0]['balance']);}
            
            foreach ($admins as $admin){
                
                if(strlen($admin['user_mobile'])===11){
                    
                    $sendsms = $this->sms_model->send_sms(utf8_encode(trim($msg)), $admin['user_mobile'], false, 'AdminSMS', false); 
                }
                
            }
        }
        ///////////
        
        echo "success|".$invoiceid;
    }

    
    function cancelvisit(){
        
        $visitid = htmlspecialchars($this->input->post('visitid', TRUE));
        $cancelled_by = htmlspecialchars($this->input->post('cancelled_by', TRUE));
        $cancelreason=htmlspecialchars($this->input->post('cancelreason', TRUE));
        

        $update = $this->pos_model->cancelVisit($visitid, $cancelled_by, $cancelreason);

        redirect('pos_services_view');
        
    }
    
    function createorderinvoice(){
        exit();
        
        $orderid=$this->input->post('orderid', TRUE);
        
        $invoicenumber=$this->input->post('invoicenumber', TRUE);
        $invoicedate=$this->input->post('invoicedate', TRUE);
        $customerid=$this->input->post('customerid', TRUE);
        $customercell=$this->input->post('customercell', TRUE);
        $customername=$this->input->post('customername', TRUE);
        $customeremail=$this->input->post('customeremail', TRUE);
        $customeraddress=$this->input->post('customeraddress', TRUE);
        
        $subtotal=$this->input->post('subtotal', TRUE);
        $paid=$this->input->post('paid', TRUE);
        $discount=$this->input->post('discount', TRUE);
        $discount_perc=$this->input->post('discount_perc', TRUE);
        
        $grosstotal=$this->input->post('grosstotal', TRUE);
        $grandtotal=$this->input->post('grandtotal', TRUE);
        $totalpayable=$this->input->post('totalpayable', TRUE);
        
        $taxes=$this->input->post('taxes', TRUE);
        $taxtotal=$this->input->post('taxtotal', TRUE);
        $cc_charge=$this->input->post('cc_charge', TRUE);
        $paymentmode=$this->input->post('mode', TRUE);
        $cashpaid=0;$cardpaid=0;$voucherpaid=0;$checkpaid=0;
                
        $instrumentnumber=$this->input->post('instrument_number', TRUE);
        $balance=$this->input->post('balance');
        $returnamount=$this->input->post('returnamount');
        $product_discount=$this->input->post('product_discount', TRUE);
        $discounted_price=$this->input->post('discounted_price', TRUE);
        
        $keepadv=$this->input->post('keepadv', TRUE);
        $retained_used=$this->input->post('retained_used', TRUE);
        $retained_amount_used=$this->input->post('retained_amount_used', TRUE);
        $remaining_retained=$this->input->post('remaining_retained', TRUE);
        
        $cctip = $this->input->post('cctip', TRUE);
        
        $advance_amount=$this->input->post('advance_amount',TRUE);
        
        $other_charges=$this->input->post('other_charges',TRUE);
        
        $totalpaid= $advance_amount+$paid;
        $totalpaidnow= $paid-$cctip;
        
        if($paymentmode=="Cash"){$cashpaid=$paid;}
        else if($paymentmode=="Card"){$cardpaid=$paid;}
        else if($paymentmode=="Check"){$checkpaid=$paid;}
        else if($paymentmode=="Voucher"){$voucherpaid=$paid;}
        else if($paymentmode=="Mixed"){
            $cashpaid=$this->input->post('cashpaid', TRUE);
            $cardpaid=$this->input->post('cardpaid', TRUE);
        } 
        
        //Loyalty
        $loyaltyused=$this->input->post('loyaltyused',TRUE);
        $loyaltyvalue=$this->input->post('loyaltyvalue',TRUE);
        $loyaltyenabled=$this->input->post('loyaltyenabled',TRUE);
        $rloyaltyenabled=$this->input->post('sloyaltyenabled',TRUE);
        if($loyaltyenabled=='Y') {$loyaltyearned=(Float)$totalpaid/ (Float)$loyaltyvalue;}
        else {$loyaltyearned=0;}
        if($loyaltyearned < 0){$loyaltyearned=0;}
        $invoiceid = $this->pos_model->insert_order_invoice($invoicenumber, $invoicedate, $customerid, $customername, $customercell, $customeraddress, $customeremail, $subtotal, $paid, $returnamount, $discount, $grosstotal, $balance, $taxtotal,$grandtotal,$orderid,$paymentmode, $instrumentnumber, $remarks, $discountremarks, $loyaltyused, $visittime, $advance_amount, $other_charges, $retained_used, $keepadv, $cctip, $loyaltyearned, $retained_amount_used, $cashpaid, $cardpaid, $voucherpaid, $checkpaid, $cc_charge, $totalpayable, $remaining_retained, $visitdate);
        
    }
}
