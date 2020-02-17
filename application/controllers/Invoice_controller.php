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
    
    function nice_print_r($array){
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
    
    function get_package_invoices(){
        $data = $this->invoice_model->getPackageInvoices();
        echo json_encode($data);
    }
    
    function package_invoices_list(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1,0,1);

            if(isset($_POST['invoice_ids'])){
                foreach ($_POST['invoice_ids'] as $row){
                    echo $row."---";
                }
                exit;
                //print_r($_POST['invoice_ids']); exit;
            }

            $data['nav'] = 'invoice';
            $data['subnav'] = 'package_invoices';

            $data['packages'] = $this->invoice_model->getPackageTypes();

            $this->load->view('includes/header', $data);
            $this->load->view('package_invoice_list');
            $this->load->view('includes/footer');
        }
        
    }   
    
    function open_package_invoice(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1,0,1);

            $data['nav'] = 'invoice';
            $data['subnav'] = 'package_invoices';
            $data['menu'] = 'hidden';

            if(isset($_POST['invoice_ids'])){

                $invoice_ids = $this->input->post('invoice_ids', TRUE);

                $data['invoice'] = $this->invoice_model->getpackageinvoicebyids($invoice_ids);

                $data['invoicedetails'] = $this->invoice_model->getpackageinvoicedetails($invoice_ids);
                //$this->nice_print_r($data['invoicedetails']); exit;
                $data['business']=$this->business_model->getbusinessdetails();

                $this->load->view('includes/header', $data);
                $this->load->view('package_invoice_view');
                $this->load->view('includes/footer');

            } else{

                echo 'Please select one ore more invoices.';

            }
        }
    } 
    
    function mark_bad_debts(){
        
        $result = $this->invoice_model->markBadDebts();
        if($result){
            echo "success";
        }
        
    }
    
    function updateCashRegister(){
        $today = date('Y-m-d');
        
        
        $result = $this->invoice_model->get_cash_register();
       
        if($result && $today != $this->input->post('calendar_date', TRUE)){
            //don't update previous days!!! 
            //$update = $this->invoice_model->update_cash_register();
            //if($update){
            //    echo 'success'; exit;
            //} else{
                echo 'error'; exit;
            //}
        } else if($result && $today == $this->input->post('calendar_date', TRUE)){
            $update = $this->invoice_model->update_cash_register();
            if($update){
                echo 'success'; exit;
            } else{
                echo 'error'; exit;
            }
        } else{
            $insert = $this->invoice_model->insert_cash_register();
            if($insert){
                echo 'success'; exit;
            } else{
                echo 'error'; exit;
            }
        }
        
    }
    
    function open_cash_register($date){
        
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $data['menu'] = 'hidden';
            $data['date'] = $date;

            $data['business']=$this->business_model->getbusinessdetails();


            $data['nodatatable']='nodatatable';

            $this->load->view('includes/header', $data);
            $this->load->view('cashregister_view');
            $this->load->view('includes/footer');
        }
    }
    
    function getTodayCashInfo(){
        $today=$this->input->post('calendar_date', TRUE);
        $show_previous = $this->input->post('show_previous', TRUE);
        
        if($this->session->userdata('role')== "Reception" && $show_previous=="N" && $today !== date('Y-m-d')){
            echo json_encode("Not Allowed");
            return;
        }
        
        $data['invoice'] = $this->invoice_model->get_today_cash_info();
        $data['till'] = $this->invoice_model->get_yesterday_till_amount($today);
        $data['cash_register'] = $this->invoice_model->get_cash_register();
        $data['today_expenses'] = $this->invoice_model->get_today_expenses();
        $data['voucher'] = $this->invoice_model->get_cash_voucher();
        
        //print_r($data['voucher']); exit;
        
        $date = $this->input->post('calendar_date', TRUE);
        
        $data['today'] = 'no';
        
        if($date === date('Y-m-d')){
            $data['today'] = 'yes';
        }
        
        echo json_encode($data);
        
    }
    
    function open_recovery_invoice($invoiceid, $visitid){
       
        $data['nodatatable']='nodatatable';
        //storemanager,hr,reception...user serial
        checkroles(1,0,1);
        
        $check_invoice = $this->invoice_model->check_invoice_recoverable($invoiceid);
        
        if($check_invoice->is_recovery === 'No'){
            redirect(base_url('existinginvoice/'.$invoiceid));
        }
        
        $data['nav'] = 'invoice';
        $data['subnav'] = 'recoveryinvoices';
        $data['menu'] = 'hidden';
        
        //Get the visit
        $data['visit']=$this->visits_model->getinvoicedvisitbyid($visitid);
        $data['visitid']=$visitid;
        //$this->nice_print_r($data['visit']); exit;
        
        $ids=[];
        foreach($data['visit'] as $service){
            array_push($ids, $service['service_id']);
        }
        
        //Get all services
        $data['services']=$this->visits_model->getvisitservices($visitid);
        
        //Get next invoive number
        $data['invoiceno']=$this->invoice_model->getnextinvoicenumber();
        
        $data['customer'] = $this->customer_model->get_byid($check_invoice->customer_id);
        
        $data['business']=$this->business_model->getbusinessdetails();
        $data['taxes']=$this->business_model->getbusinesstaxes('service');
        
        // get invoice details
        $data['invoice']=$this->invoice_model->getinvoicebyid($invoiceid);
        $data['invoicedetails']=$this->invoice_model->getinvoicedetails($invoiceid);
        $data['invoicestaff']=$this->invoice_model->getinvoicestaff($invoiceid);
        
//        $this->nice_print_r($data['invoice']); exit;
        
        $this->load->view('includes/header', $data);
        $this->load->view('invoice_recovery_view');
        $this->load->view('includes/footer');
    }
    
    function open_recovery_order_invoice($invoiceid, $orderid){
        $data['nodatatable']='nodatatable';
         //storemanager,hr,reception...user serial
        checkroles(1,0,1);
        
        $check_invoice = $this->invoice_model->check_invoice_recoverable($invoiceid);
        
        if($check_invoice->is_recovery === 'No'){
            redirect(base_url('existingorderinvoice/'.$invoiceid));
        }
        
        $data['nav'] = 'invoice';
        $data['subnav'] = 'recoveryinvoices';
        
        //$data['order'] = $this->order_model->getinvoicedorderbyid($orderid);
        
        //$ids=[];
        //foreach($data['order'] as $product){
        //    array_push($ids, $product['product_id']);
        //}

        //Get all products
        //$data['products']=$this->order_model->getorderproducts($ids, $orderid);

        //Get next invoice number
        $data['invoiceno']=$this->invoice_model->getnextinvoicenumber();

        $data['business']=$this->business_model->getbusinessdetails();
        $data['taxes']=$this->business_model->getbusinesstaxes('sale');
        
        // get invoice details
        $data['invoice']=$this->invoice_model->getinvoicebyid($invoiceid);
        $data['products']=$this->invoice_model->getinvoiceproducts($invoiceid);
        
        $data['menu'] = 'hidden';

        $this->load->view('includes/header', $data);
        $this->load->view('order_invoice_recovery_view');
        $this->load->view('includes/footer');
    }

    function open_new_invoice(){
        $data['nodatatable']='nodatatable';
       
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
            $data['taxes']=$this->business_model->getbusinesstaxes('service');

            $data['menu'] = 'hidden';
            
            $data['WaterContent'] = $this->colors_model->get_WaterContent();
           
            $data['discount_types'] = $this->invoice_model->get_discounttypes();
            
            $this->load->view('includes/header', $data);
            $this->load->view('invoice_view');
            $this->load->view('includes/footer');
            
        } else{
            echo 'Invoice already generated for this Visit';
        }
    }

    function openinvoice($invoiceid){
        //$invoiceid=$this->input->post('invoiceid');
        $data['nodatatable']='nodatatable';
        
        $data['nav'] = 'invoice';
        $data['subnav'] = 'todayinvoices';
        
        $data['menu'] = 'hidden';
       
        //Get the invoice and pass as visit
        $data['invoice']=$this->invoice_model->getinvoicebyid($invoiceid);
        
        //print_r($data['invoice']); exit;
        
        if($data['invoice'][0]['reference_invoice_number'] !== ''){
            $invoiceno = $data['invoice'][0]['reference_invoice_number'];
            $invoice=$this->invoice_model->getinvoicebyno($invoiceno);
            $invoiceid = $invoice[0]['id_invoice'];
        }
        
        //Get all details and pass as services
        $data['invoicedetails']=$this->invoice_model->getinvoicedetails($invoiceid);
        $data['invoicestaff']=$this->invoice_model->getinvoicestaff($invoiceid);
               
        $data['business']=$this->business_model->getbusinessdetails();
        $data['taxes']=$this->invoice_model->getinvocietaxes($invoiceid);
        
        $this->load->view('includes/header', $data);
        $this->load->view('exist_invoice_view');
        $this->load->view('includes/footer');
        
    }
    
    function openinvoiceemailtemplate($invoiceid){
        //$invoiceid=$this->input->post('invoiceid');
        $data['nodatatable']='nodatatable';
        
        $data['nav'] = 'invoice';
        $data['subnav'] = 'todayinvoices';
        
        $data['menu'] = 'hidden';
       
        //Get the invoice and pass as visit
        $data['invoice']=$this->invoice_model->getinvoicebyid($invoiceid);
        
        //print_r($data['invoice']); exit;
        
        if($data['invoice'][0]['reference_invoice_number'] !== ''){
            $invoiceno = $data['invoice'][0]['reference_invoice_number'];
            $invoice=$this->invoice_model->getinvoicebyno($invoiceno);
            $invoiceid = $invoice[0]['id_invoice'];
        }
        
        //Get all details and pass as services
        $data['invoicedetails']=$this->invoice_model->getinvoicedetails($invoiceid);
        
               
        $data['business']=$this->business_model->getbusinessdetails();
        $data['taxes']=$this->invoice_model->getinvocietaxes($invoiceid);
        
        //$this->load->view('includes/header', $data);
        $this->load->view('exist_invoice_email_template', $data);
        //$this->load->view('includes/footer');
        
    }
    
    function updaterecoveryinvoice(){
        $result = $this->invoice_model->update_recovery_invoice();
        echo "success|".$result;
    }
    
    function updaterecoveryorderinvoice(){
        $result = $this->invoice_model->update_recovery_order_invoice();
        echo "success|".$result;
    }
    
    function updateinvoice(){
      //exit();
       $customer_phone = $this->input->post('customercell');
       
       //verify retained_amount_usage
       $verification = $this->customer_model->get_customer_loyalty($this->input->post('customerid'));
       $this->load->model('scheduled_tasks_model');
       $loyalty_text = $this->scheduled_tasks_model->get_loyalty_text();
       
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
       
       $invoice=$this->invoice_model->update_invoice();
       $this->session->unset_userdata('discount_session');
      
       $invoiceid= explode("|", $invoice);
       
        $business=$this->business_model->getbusinessdetails();
       
        $verification = $this->customer_model->get_customer_loyalty($this->input->post('customerid'));
        
        if($business[0]['loyalty_sms']=='Yes' && sizeof($verification)>0){
            
            $newloyaltypoints = $verification[0]['loyalty_points'];
            $customername= $verification[0]['customer_name'];
            
            
            $msg='Hi '.$customername.', Thank you for visiting '.$business[0]['business_name'].'. ';
            if($business[0]['loyalty_enable']=='Y'){
                if((Int)$invoiceid[0]>0 && (Int)$invoiceid[1]>0 && strlen($customer_phone)==11 && $business[0]['show_points']=='Yes'){
                   //$newloyaltypoints =  (float)$newloyaltypoints+(float)$invoiceid[1];
                   $msg=$msg.' You have earned '. $invoiceid[1] .' points today. Your total points available are '. $newloyaltypoints.'. ';
                } 
                if((Int)$invoiceid[0]>0 && (Int)$invoiceid[2]>0 && strlen($customer_phone)==11 && $business[0]['show_amount']=='Yes'){
                   //$newloyaltypoints =  (float)$newloyaltypoints+(float)$invoiceid[1];
                   $msg=$msg.' Your total bill amount is '. $invoiceid[2] .'. ';
                }              
            }
           if($loyalty_text!==null && $loyalty_text!==''){
                $msg=$msg.$loyalty_text->msg;
            }
            //echo utf8_encode(trim($msg)), $customer_phone, false, 'LoyaltySMS', false, $business[0]['id_business'];
            //exit();
            
            //$sendsms = $this->send_sms('Hi '.$customername.', Thank you for visiting '.$business[0]['business_name'].'. Your earned Loyalty Points are '.$newloyaltypoints.'. Hoping to see you soon.', $customer_phone); 
            $sendsms = $this->sms_model->send_sms(utf8_encode(trim($msg)), $customer_phone, false, 'LoyaltySMS', false, $business[0]['id_business']); 
            //$updatelog = $this->invoice_model->invoice_sms_update($invoiceid[0], $sendsms);
        }
        
        if($business[0]['admin_notifications']==='Yes' && (Int)$invoiceid[0] > 0){
            $admins = $this->business_model->get_business_admins();
            
            $thisInvoice = $this->invoice_model->getinvoicebyid($invoiceid[0]);
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
        echo "success|".$invoiceid[0];
        
    }
    
    function cancelinvoice(){
    
        $result=$this->invoice_model->cancel_invoice();
        
       // if($result == "success"){
            echo $result;
       // } else {
       //     echo "error|"."Balance from this invoice has a been recovered in a later invoice. Please Cancel the latest invoice first!";
       // }
    }
    
    function recoveryinvoices(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1,0,1);

            $data['nav'] = 'invoice';
            $data['subnav'] = 'recoveryinvoices';

            $data['invoices']=$this->invoice_model->getrecoveryinvoices();

            $this->load->view('includes/header', $data);
            $this->load->view('invoice_recovery');
            $this->load->view('includes/footer');
        }
        
    } 

    function todayinvoices(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1,0,1);

            $data['nav'] = 'invoice';
            $data['subnav'] = 'todayinvoices';

            $data['invoices']=$this->invoice_model->gettodayinvoices(null, 'asc', 'all');

            $this->load->view('includes/header', $data);
            $this->load->view('invoice_list');
            $this->load->view('includes/footer');
        }
    }
    
    
    
    function appointments($appointment_date = NULL){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1,0,1);

            $data['nav'] = 'invoice';
            $data['subnav'] = 'appointments';

            $data['rows'] = $this->invoice_model->getappointments($appointment_date);

            $i=0;
            foreach($data['rows'] as $row){
                $result = $this->invoice_model->getappointmentsstaff($row->id_customer_visits, $row->id_visit_services);
                $staff_ids = "";
                $staff_names = "";
                foreach($result as $res){
                    $staff_ids .= $res->staff_id."|";
                    $staff_names .= $res->staff_name."|";
                }
                $data['rows'][$i]->staff_ids = rtrim($staff_ids, '|');
                $data['rows'][$i]->staff_names = rtrim($staff_names, '|');
                $i++;
            }

            //$this->nice_print_r($data['rows']); exit;
            $data['date'] = $appointment_date;
            $this->load->view('includes/header', $data);
            $this->load->view('appointments_list');
            $this->load->view('includes/footer');
        }
    }
    
    function open_order_invoice(){
        $data['nodatatable']='nodatatable';
        
        $orderid=$this->input->post('order-id', TRUE);

        //Get the order
        $data['order'] = $this->order_model->getopenorderbyid($orderid);
        if($data['order']){
            $ids=[];
            foreach($data['order'] as $product){
                array_push($ids, $product['product_id']);
            }

            //Get all products
            $data['products']=$this->order_model->getorderproducts($ids, $orderid);

            //Get Balance
            $data['balance'] = $this->customer_model->customerbalance($data['order'][0]['customer_id']);
            $data['customer_points'] = $this->customer_model->get_customer_loyalty($data['order'][0]['customer_id']);
            
            
            //Get next invoice number
            $data['invoiceno']=$this->invoice_model->getnextinvoicenumber();

            $data['business']=$this->business_model->getbusinessdetails();
            $data['taxes']=$this->business_model->getbusinesstaxes('sale');

            $data['menu'] = 'hidden';

            $this->load->view('includes/header', $data);
            $this->load->view('order_invoice_view');
            $this->load->view('includes/footer');
        } else{
            
            $invoiceid=  $this->order_model->getinvoicedorderbyid($orderid);
            
            redirect(base_url()."existingorderinvoice/".$invoiceid[0]['id_invoice']);
        }
    }
   
    function openorderinvoice($invoiceid){
        //$invoiceid=$this->input->post('invoiceid');
       
        $data['nodatatable']='nodatatable';
        
        //Get the invoice and pass as visit
        $data['invoice']=$this->invoice_model->getinvoicebyid($invoiceid);
        
        if($data['invoice'][0]['reference_invoice_number'] !== ''){
            $invoiceno = $data['invoice'][0]['reference_invoice_number'];
            $invoice=$this->invoice_model->getinvoicebyno($invoiceno);
            $invoiceid = $invoice[0]['id_invoice'];
        }
        
        //Get all details and pass as products
        $data['invoiceproducts']=$this->invoice_model->getinvoiceproducts($invoiceid);
        
               
        $data['business']=$this->business_model->getbusinessdetails('sale');
        $data['taxes']=$this->invoice_model->getinvocietaxes($invoiceid);
        
        $data['menu'] = 'hidden';
        
        $this->load->view('includes/header', $data);
        $this->load->view('exist_order_invoice_view');
        $this->load->view('includes/footer');
        
    }
    
    function updateorderinvoice(){
        $orderid=$this->input->post('orderid', TRUE);

        //Get the order
        $data['order'] = $this->order_model->getopenorderbyid($orderid);
        if(!$data['order']){
            echo 'error|This order has already been invoice. Refresh Page!';
           exit();
            
        }
        $verification = $this->customer_model->get_customer_loyalty($this->input->post('customerid'));
        
        if((float)$verification[0]['retained'] <  ((float)$this->input->post('retained_amount_used') + (float)$this->input->post('remaining_retained'))){
           echo 'error|Another Invoice used the customer advance. Refresh Page!';
           exit();
       }
       
       if((float)$verification[0]['loyalty_points'] <  (float)$this->input->post('loyaltyused')){
           echo 'error|Loyalty points already used in some other invoice. Refresh Page!';
           exit();
       }   
        
        
        $result = $this->invoice_model->update_order_invoice();

        
        
        echo "success|".$result."|".$this->input->post('customerid');
    }
    
    function discount_login() {
        $result = $this->invoice_model->discount_login();
        if ($result) {
            echo json_encode($result);
            die;
        }else{
            echo "error";
            die;
        }
    }
    
    function invoice_service_product($serviceid,$visit_id){
        $data['service_products'] = $this->invoice_model->invoice_service_product($serviceid);
        $data['products'] = $this->visits_model->getopenvisitbyid($visit_id);
        $data['services']=$this->visits_model->getvisitservices($visit_id);
        echo(json_encode($data));
    }
    
    function invoice_service_product_update(){
        $result = $this->invoice_model->invoice_service_product_update();
        if($result) echo "success";
    }
   
    function print_booking($visitid){
        $data['nodatatable']='nodatatable';
        $data['nav'] = 'invoice';

        //Get the visit
        $data['visit']=$this->visits_model->getadvancevisitbyid($visitid);
        
        
        if($data['visit']){
            
            $data['staffs']=$this->visits_model->getvisitstaffs($visitid);

            $data['color_record'] = $this->colors_model->get_color_record($visitid);
            
            if(count($data['color_record']) > 0){
                $data['color_record'] = FALSE;
            } else{
                $data['color_record'] = TRUE;
            }
        
            
            //$this->nice_print_r($data['visit']); 
            $data['customer'] = $this->customer_model->get_byid($data['visit'][0]['customer_id']);

            $data['balance'] = $this->customer_model->customerbalance($data['visit'][0]['customer_id']);
            
            $data['color_type_list'] = $this->colors_model->color_type_list();
            //Get all services
            $data['services']=$this->visits_model->getvisitservices($visitid);

            $data['package']=$this->visits_model->getpackagedays($visitid);
            
            $data['business']=$this->business_model->getbusinessdetails();
            
             $data['advances'] = $this->visits_model->getopenvisitadvancebyid($visitid);   
             
            $data['menu'] = 'hidden';
            
            $this->load->view('includes/header', $data);
            $this->load->view('print_booking_view');
            $this->load->view('includes/footer');
            
        } else{
            echo 'Booking not found!';
        }
        
    }
    
    public function print_advance($visitid){
        $data['nav'] = 'invoice';
        $data['nodatatable']='nodatatable';

        //Get the visit
        $data['visit']=$this->visits_model->getadvancevisitbyid($visitid);
        
        if($data['visit']){
            
            $data['staffs']=$this->visits_model->getvisitstaffs($visitid);
            
            //$this->nice_print_r($data['visit']); 
            $data['customer'] = $this->customer_model->get_byid($data['visit'][0]['customer_id']);
            $data['balance'] = $this->customer_model->customerbalance($data['visit'][0]['customer_id']);
            //Get all services
            $data['services']=$this->visits_model->getvisitservices($visitid);
            $data['business']=$this->business_model->getbusinessdetails();
            $data['advances'] = $this->visits_model->getopenvisitadvancebyid($visitid);   
            
            $data['menu'] = 'hidden';
            
            $this->load->view('includes/header', $data);
            $this->load->view('print_advance_view');
            $this->load->view('includes/footer');
            
        } else{
            echo 'Advance not booked!';
        }
    }

    function getmaxinvoice(){
        
        $result = $this->invoice_model->getmaxinvoice();

        echo json_encode($result);
        
    }
    
    function httpRequest($url)
    {
       
        $args;
        $pattern = "/http...([0-9a-zA-Z-.]*).([0-9]*).(.*)/";
        preg_match($pattern,$url,$args);
        $in = "";
        $fp = fsockopen("$args[1]", $args[2], $errno, $errstr, 30);
        if (!$fp)
        {
           return("$errstr ($errno)");
        }
        else
        {
            $out = "GET /$args[3] HTTP/1.1\r\n";
            $out .= "Host: $args[1]:$args[2]\r\n";
            $out .= "User-agent: PHP Web SMS client\r\n";
            $out .= "Accept: */*\r\n";
            $out .= "Connection: Close\r\n\r\n";

            fwrite($fp, $out);
            while (!feof($fp))
            {
               $in.=fgets($fp, 128);
            }
        }
        fclose($fp);
        return($in);
    } 
    
    function send_sms($msg, $phone, $debug=false)
    {
        $username='';
        $password='';   
        $smsurl='';

        $this->load->model('sms_model');    
        $sms_cred = $this->sms_model->get_sms_cred();
        
        if(!$sms_cred==Null){
            $username   = $sms_cred[0]['username']; 
            $password   = $sms_cred[0]['password'];
            $smsurl     = "http://".$sms_cred[0]['domain'].":80/api/?"; // change smsdomain.com to your provided; 

            $url  = 'username='.$username;
            $url  .= '&password='.$password;
            $url  .= '&receiver='.urlencode($phone);
            $url  .= '&msgdata='.urlencode($msg);
            $urltouse =  $smsurl.$url;
           
            //Open the URL to send the message
              $response =  $this->httpRequest($urltouse);
             return $response;    
        } else {
            return 'SMS Service is not setup!';
        }
    }
    
}
