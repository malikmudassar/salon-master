<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('customer_model');
        $this->load->model('visits_model');
        $this->load->model('colors_model');
        $this->load->model('service_model');
        $this->load->model('eyelashes_model');
        $this->load->model('invoice_model');
        $this->load->model('business_model');
    }
    
    function sendEmail(){
        $customerid = $this->input->post("customerid", TRUE);
        $result = $this->customer_model->get_byid($customerid);
        if(!empty($result[0]['customer_email'])){
            echo $result[0]['customer_email'];
        } else{
            echo 'empty';
        }
    }
    
    function updateCustomerEmail($customerid, $email){
        
        $this->customer_model->update_customer_info($customerid, array('customer_email' => $email));
    }
    
    function sendEmailDo(){
        
        $customerid = $this->input->post("customerid", TRUE);
        $email = $this->input->post("email", TRUE);
        $invoiceid = $this->input->post("invoiceid", TRUE);
        $default = $this->input->post("senddefault", TRUE);

        if($default === 'yes'){
            $this->updateCustomerEmail($customerid, $email);
        }
        
        $business = $this->business_model->getbusinessdetails();
        $body = $this->openinvoiceemailtemplate($invoiceid);

        $this->load->library('email');
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.mexyon.net';
        $config['smtp_user'] = $business[0]['business_email'];
        $config['smtp_pass'] = $business[0]['business_email_password'];
        $config['smtp_port'] = 25;
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);
        $this->email->from($business[0]['business_email'], $business[0]['business_name']);
        $this->email->to($email);
        $this->email->subject('Invoice Receipt');
        $this->email->message($body);
        $this->email->send();
        
    }
    
    function openinvoiceemailtemplate($invoiceid){
        
        $data['invoice']=$this->invoice_model->getinvoicebyid($invoiceid);
        
        if($data['invoice'][0]['reference_invoice_number'] !== ''){
            $invoiceno = $data['invoice'][0]['reference_invoice_number'];
            $invoice=$this->invoice_model->getinvoicebyno($invoiceno);
            $invoiceid = $invoice[0]['id_invoice'];
        }
        
        $data['invoicedetails'] = $this->invoice_model->getinvoicedetails($invoiceid);
        $data['business'] = $this->business_model->getbusinessdetails();
        $data['taxes']=$this->invoice_model->getinvocietaxes($invoiceid);
        
        $html = $this->load->view('exist_invoice_email_template', $data, TRUE);
        return $html;
    }

    public function search() {
        //get the posted values
        
        $customername = $this->input->post("customersearch", TRUE);
        $customername = $this->input->get("customername", TRUE);
        
        $data = $this->customer_model->get_customer($customername);

        echo(json_encode($data));
        //return  $data['customer'];
        //$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
    }

    public function searchname() {
        //get the posted values
        $customername = $this->input->post("customername", TRUE);
        
        $data = $this->customer_model->get_byname($customername);

        echo(json_encode($data));
    }
    
    public function searchnameforco() {
        //get the posted values
        $customername = $this->input->get("customername", TRUE);
        $data = $this->customer_model->get_bynameco($customername);

               echo(json_encode($data));
    }

    public function searchcell() {
        //get the posted values
        $customercell = $this->input->post("customercell", TRUE);

        $data = $this->customer_model->get_bycell($customercell);

               echo(json_encode($data));
    }
    
    public function searchcard() {
        //get the posted values
        $customercard = $this->input->post("customercard", TRUE);

        $data = $this->customer_model->get_bycard($customercard);

               echo(json_encode($data));
    }

    public function searchemail() {
        //get the posted values
        $customeremail = $this->input->post("customeremail", TRUE);

        $data = $this->customer_model->get_byemail($customeremail);

               echo(json_encode($data));
    }

    public function searchid() {
        //get the posted values
        $customerid = $this->input->post("id", TRUE);
        $data = $this->customer_model->get_byid($customerid);

            
        echo(json_encode($data));
    }

    public function addnew() {
        $customerid = $this->input->post('txt-customer-id', TRUE);
        if ($customerid == "") {
            $result = $this->customer_model->add_new_customer();
            echo "success|" . $result;
        } else {
            echo "error|Something went wrong! you initiated a new customer input but I already have an existing customer selected. Please start over.";
        }
    }

    public function updatecustomer() {
        $customerid = $this->input->post('detail-customer-id', TRUE);
        if ($customerid != "") {
            $result = $this->customer_model->update_customer();
            echo "success|" . $result;
        } else {
            echo "error|Something went wrong! you tried updating a customer but I dont have the customer id selected. Please start over.";
        }
    }

    public function getcustomeralerts() {
        
    }

    //Customer List view function....
    public function customer_list() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'customers';

            //$data['customers'] = $this->customer_model->get_customers();
            $data['customers'] = $this->customer_model->general_search('', '', '');
            $this->load->view('includes/header', $data);
            $this->load->view('setting/customer_list_view');
            $this->load->view('includes/footer');
        }
    }

    function getCustomerBirthdays() {
        $data['today_birthdays'] = $this->customer_model->get_customers_birthday_today();
        $data['tomorrow_birthdays'] = $this->customer_model->get_customers_birthday_tomorrow();
              
        echo json_encode($data);
    }

    //Customer Add by modal function....in list view file
    public function add_customer() {
        $result = $this->customer_model->add_new_customer_by_list();
        echo('success|' . $result);
    }

    //Customer Update by modal function....in list view file
    public function update_customer() {

        $result = $this->customer_model->update_customer_by_list();
        echo('success|' . $result);
    }

    public function customer_history($idcustomer = NULL) {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            if ($idcustomer && $idcustomer != NULL) {
                $data["customer_history"] = $this->customer_model->customer_history($idcustomer);
                $data["customer"] = $this->customer_model->get_byid($idcustomer);
                $this->load->view('includes/header');
                $this->load->view('setting/customer_history', $data);
                $this->load->view('includes/footer');
            }
        }
    }

    //Previous visit.....work start............
    //Using views files ---> event_view_modal,customer_previous_visit,visit_js,scheduler_modal
    //Using model files ---> customer_model,visits_model
    public function customer_previous_visit($customerid, $getvisits='No', $getinvoices='No') {//getbusinessdetails
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
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
                $visitcount=$this->customer_model->customer_visit_count($customerid);

            }
            if($getinvoices=="No"){
                $invoicecount=$this->customer_model->customer_invoice_count($customerid);
            }

            if($getvisits=='Yes' || $visitcount->count<=50){
                $data['visits'] = $this->customer_model->customer_all_visits($customerid);

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
                $data['invoices'] = $this->customer_model->get_invoice_visit($customerid);
                $data['noinvoices']= "false";
            } else{
                $data['noinvoices'] = $invoicecount->count ." previous invoices in the database.";
            }
            $data['color_records'] = $this->colors_model->get_customer_color_records($customerid);
            $data['facial_records'] = $this->service_model->get_customer_facial_records($customerid);
            $data['eyelashes'] = $this->eyelashes_model->get_customer_eyelashes_records($customerid);

            $data['customerbalance'] = $this->customer_model->customerbalance($customerid);

            $data['customer_loyalty'] = $this->customer_model->get_customer_loyalty($customerid);


            //echo "<pre>";print_r($data['staff']);echo "</pre>";die;
            $this->load->view('includes/header', $data);
            $this->load->view('customer_previous_visit');
            $this->load->view('includes/footer');
        }
    }

    //Previous visit.....work end............

    public function customer_balance() {
        if ($this->input->post('id', TRUE)) {
            $customerbalance = $this->customer_model->customerbalance($this->input->post('id', TRUE));
            echo (json_encode($customerbalance));
            die;
        }
    }

    public function customer_exist() {
        $customername = $this->input->post('customer_name', TRUE);
        $customercell = $this->input->post('customer_cell', TRUE);
        $customerexist = $this->customer_model->customer_exist($customername, $customercell);
        echo $customerexist;
        die;
    }
    
    public function customer_update_exist() {
        $customername = $this->input->post('customer_name', TRUE);
        $customercell = $this->input->post('customer_cell', TRUE);
        $customer_id = $this->input->post('customer_id', TRUE);
        $customerexist = $this->customer_model->customer_update_exist($customer_id, $customername, $customercell);
        echo $customerexist;
        die;
    }
    
    public function edit_customers(){
        $data = $this->customer_model->edit_customers();
        echo (json_encode($data));
        die;
    }
    
    function CheckCustomer_Exist(){
        $customername = $this->input->post('customer_name', TRUE);
        $customercell = $this->input->post('customer_cell', TRUE);
        $customerexist = $this->customer_model->CheckCustomer_Exist($customername, $customercell);
        echo $customerexist;
        die;
    }

    function generalsearch(){
        
        $customername = $this->input->post('customername', TRUE);
        $customercell = $this->input->post('customercell', TRUE);
        $customercard = $this->input->post('customercard', TRUE);
        
        $data = $this->customer_model->general_search($customername, $customercell, $customercard);

               
        echo(json_encode($data));
        
    }
    
    public function mark_inservice(){
        $visit_id=$this->input->post('visit_id');
        $data = $this->visits_model->mark_inservice($visit_id);
        echo (json_encode($data));
    }
}
