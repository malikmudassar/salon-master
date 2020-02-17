<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('staff_model');
        $this->load->model('business_model');
        $this->load->model('accounting_model');
       
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        }
    }

    public function getschedulerstaff(){
        
        $data = $this->staff_model->get_scheduler_staff();
        echo(json_encode($data));
        
    }
    
    public function presentstaff() {
        //get the posted values

        $data = $this->staff_model->get_present_staff();
        echo(json_encode($data));
    }

    public function availablestaff() {
        //get the posted values

        $data = $this->staff_model->get_available_staff();
        echo(json_encode($data));
    }

    public function absentstaff() {
        //get the posted values

        $data = $this->staff_model->get_absent_staff();
        echo(json_encode($data));
    }

    public function checkStaffStatus() {

        $result = $this->staff_model->check_staff_status();
        if ($result && is_null($result->time_out)) {
            echo 'online';
        } else {
            echo 'offline';
        }
    }

    public function timein() {
        //get the posted values

        $result = $this->staff_model->update_timein();
        echo "success|" . $result;
    }

    public function timeout() {
        //get the posted values

        $result = $this->staff_model->update_timeout();
        echo "success|" . $result;
    }

    public function staff_list() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1, 1, 0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'staff';

            $data['staffs'] = $this->staff_model->all_staff();
            $data['business'] = $this->business_model->getbusinessdetails();

            $startdate= date("Y-n-j", strtotime("first day of previous month"));
            $enddate= date("Y-n-j", strtotime("last day of previous month"));
            $this->load->model('report_model');
            $data['commissions']=$this->report_model->commissions($startdate, $enddate);
            $data['lastmonthyear']=  $this->sqldates_model->lastmonthyear();

            $data['bank_accounts'] = $this->accounting_model->get_bank_accounts();

            $this->load->view('includes/header', $data);
            $this->load->view('setting/staff_list_view');
            $this->load->view('includes/footer');
        }
    }
    
    public function get_commissions(){
        
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        
        $startdate=  $year."-".$month."-1";
        $enddate= $year."-".$month."-31";
        $this->load->model('report_model');
        $data=$this->report_model->commissions($startdate, $enddate);
        
        echo json_encode($data);
        
    }

    public function add_staff() {
        $result = $this->staff_model->add_staff();
        echo "success|" . $result;
    }

    public function update_staff() {
        $result = $this->staff_model->update_staff();
        echo "success|" . $result;
    }

    public function update_staff_scheduler() {
        $result = $this->staff_model->update_staff_scheduler();
        echo "success|" . $result;
    }
    
    function staff_status() {
        $result = $this->staff_model->staff_status();
        echo "success";
        
    }

    public function image_staff() {
        if ($this->input->post('id_image_staff', TRUE) && $this->input->post('id_image_staff', TRUE) != "") {
            $image = "";
            if ($_FILES['staff_image']['name'] && $_FILES['staff_image']['name'] != "") {
                $image = $this->image_upload('images/staff', 'staff_image', 'gif|jpg|png');
                if ($image == FALSE) {
                    $this->session->set_flashdata('errorimage', 'The image dimension must be 128 X 128');
                    redirect($this->session->userdata('tips_tricks_edit_url'));
                } else {
                    $image = $image;
                }
            } else {
                $image = ($this->input->post('org_image', TRUE) != "" ? $this->input->post('org_image', TRUE) : NULL);
            }

            $result = $this->staff_model->image_staff($image);
            if ($result) {
                redirect(base_url('staff_list'));
            }
        }
    }

    function image_upload($folder = NULL, $image = NULL, $type = NULL, $width = NULL, $height = NULL, $encrypt = NULL) {
        $config['upload_path'] = 'assets/' . $folder . '/';
        $config['allowed_types'] = $type;
        $config['max_size'] = '2048';

        if ($width != NULL && $height != NULL) {
            $config['max_width'] = $width;
            $config['max_height'] = $height;
        }
        if ($encrypt != NULL) {
            $config['encrypt_name'] = TRUE;
        }

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($image)) {
            return FALSE;
        } else {
            return $this->upload->data('file_name');
        }
    }

    public function order_function() {
        $id = $this->input->post('id');
        $orderid = $this->input->post('orderid');

        $result = $this->staff_model->update_order_function($id, $orderid);
        echo('success|' . $result);
        die;
    }

    public function changelistorder() {
        $result = $this->staff_model->changelistorder();
        echo('success|' . 1);
        die;
    }
    
    public function edit_staff(){
        $data = $this->staff_model->edit_staff();
        echo (json_encode($data));
        die;
    }

    
    public function get_active_staff(){
        
        $data = $this->staff_model->get_active_staff();
        echo (json_encode($data));
        die;
        
    }
    
    public function updatesalaries(){
         // Unescape the string values in the JSON array
        $tableData = stripcslashes($this->input->post('salarydata'));

        // Decode the JSON array
        $tableData = json_decode($tableData,TRUE);
        // now $tableData can be accessed like a PHP array
        
        $data = [];
        $count=0;
        $date=date("Y-m-d H:i:s");
        
        $count=0;
        foreach($tableData as $row){
            $check_existing = $this->staff_model->check_salary_record($row['staff_id'],$this->input->post('month'),$this->input->post('year'));
            //echo var_dump($check_existing); exit();
            if(sizeOf($check_existing)>0 && $check_existing[0]['staff_id']==$row['staff_id']){
                //do nothing as salary already exists
            } else {
                if($row['payment_amount']>0){
                    $datasalary = array(
                        'created_by' => $this->session->userdata('businessid'),
                        'staff_id' => $row['staff_id'],
                        'staff_name' => $row['staff_name'],
                        'payment_amount' => $row['payment_amount'],
                        'payment_type' => $row['payment_type'],
                        'payment_mode' =>  $this->input->post('salarymode'),
                        'payment_remarks' => $row['payment_remarks'],
                        'payment_date' => $date,
                        'payment_month' => $this->input->post('month'),
                        'payment_year' => $this->input->post('year')
                    );
                    $result=$this->staff_model->update_salaries($datasalary);

                    ///add account vouchers
                    $debit_amounts='32|'. $row['payment_amount'];
                    if($row['payment_amount']==='Bank'){ 
                        $credit_amounts = $row['bank_accounts'].'|'. $row['payment_amount'];
                    } else {
                        $credit_amounts = '2|'. $row['payment_amount'];
                    }

                    $debit_accounts=[];
                    $credit_accounts=[];
                    array_push($debit_accounts, $debit_amounts);
                    array_push($credit_accounts, $credit_amounts);

                    $bank_name='';
                    if(null!==$this->input->post('bank_accounts')){$bank_name=$this->input->post('bank_accounts');}

                    $discription = 'Salary paid to ' . $row['staff_name'] . ', for the month of '. $this->input->post('month').' '.$this->input->post('year');

                    $data = array( 
                        'business_id' => $this->session->userdata('businessid'),
                        'description' => $discription,
                        'voucher_date' => $date,
                        'voucher_amount' => $row['payment_amount'],
                        'voucher_status' => 'Active',
                        'created_by' => $this->session->userdata('username'),
                        'cost_center'=>1,
                        'cost_center_name'=>'Outlet',
                        'business_partner'=>3,
                        'business_partner_id'=>$row['staff_id'],
                        'business_partner_name'=>$row['staff_name'],
                        'voucher_type'=>1,
                        'payment_mode'=>$this->input->post('salarymode'),
                        'bank_name'=>$bank_name

                    );

                    $result = $this->accounting_model->add_account_voucher($data, $debit_accounts, $credit_accounts);


                    $count++;
                }
            }
            
        }
        
        echo "success|".$count;
        
    }
    
    public function updatecommissions(){
        
         // Unescape the string values in the JSON array
        $tableData = stripcslashes($this->input->post('commissionsdata'));

        // Decode the JSON array
        $tableData = json_decode($tableData,TRUE);
        // now $tableData can be accessed like a PHP array
        
        $data = [];
        $count=0;
        $date=date("Y-m-d H:i:s");
        
        $count=0;
        foreach($tableData as $row){
            $check_existing = $this->staff_model->check_commission_record($row['staff_id'],$this->input->post('month'),$this->input->post('year'));
            //echo sizeOf($check_existing); exit();
            if(sizeOf($check_existing)>0 && $check_existing[0]['staff_id']==$row['staff_id']){
                //do nothing as salary already exists
            } else {
                $datacommission = array(
                    'created_by' => $this->session->userdata('businessid'),
                    'staff_id' => $row['staff_id'],
                    'staff_name' => $row['staff_name'],
                    'payment_amount' => $row['payment_amount'],
                    'payment_type' => $row['payment_type'],
                    'payment_mode' =>  $this->input->post('paymentmode'),
                    'payment_remarks' => $row['payment_remarks'],
                    'payment_date' => $date,
                    'payment_month' => $this->input->post('month'),
                    'payment_year' => $this->input->post('year')
                );
                $result=$this->staff_model->update_salaries($datacommission);
                
                ///add account vouchers
                $debit_amounts='32|'. $row['payment_amount'];
                if($row['payment_amount']==='Bank'){ 
                    $credit_amounts = $row['bank_accounts'].'|'. $row['payment_amount'];
                } else {
                    $credit_amounts = '2|'. $row['payment_amount'];
                }
                
                $debit_accounts=[];
                $credit_accounts=[];
                array_push($debit_accounts, $debit_amounts);
                array_push($credit_accounts, $credit_amounts);
                
                $bank_name='';
                if(null!==$this->input->post('bank_accounts')){$bank_name=$this->input->post('bank_accounts');}
                
                $discription = 'Commission paid to ' . $row['staff_name'] . ', for the month of '. $this->input->post('month').' '.$this->input->post('year');
                
                $data = array( 
                    'business_id' => $this->session->userdata('businessid'),
                    'description' => $discription,
                    'voucher_date' => $date,
                    'voucher_amount' => $row['payment_amount'],
                    'voucher_status' => 'Active',
                    'created_by' => $this->session->userdata('username'),
                    'cost_center'=>1,
                    'cost_center_name'=>'Outlet',
                    'business_partner'=>3,
                    'business_partner_id'=>$row['staff_id'],
                    'business_partner_name'=>$row['staff_name'],
                    'voucher_type'=>1,
                    'payment_mode'=>$this->input->post('paymentmode'),
                    'bank_name'=>$bank_name

                );

                $result = $this->accounting_model->add_account_voucher($data, $debit_accounts, $credit_accounts);
                
                
                $count++;
            }
            
        }
        
        echo "success|".$count;
        
       
    }
    
    public function add_payment(){
        
        $result=$this->staff_model->add_payment();
        echo "success|".$result;
        
    }
    
    public function staff_account($staffid){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
           checkroles(1, 1, 0);

           $data['nav'] = 'my_business';
           $data['subnav'] = 'staff';

           $data['details'] = $this->staff_model->staff_details($staffid);

           $data['salary'] = $this->staff_model->staff_salary($staffid);
           $data['loan'] = $this->staff_model->staff_loan($staffid);

           $data['payment_types'] = $this->staff_model->get_staff_payment_types();

           $data['bank_accounts'] = $this->accounting_model->get_bank_accounts();

           $data['business'] = $this->business_model->getbusinessdetails();
           $data['lastmonthyear']=  $this->sqldates_model->lastmonthyear();

           $this->load->view('includes/header', $data);
           $this->load->view('setting/staff_account');
           $this->load->view('includes/footer');
        }
        
    }
    
    public function paymentslips(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $data['business'] = $this->business_model->getbusinessdetails();
            $data['lastmonthyear']=  $this->sqldates_model->lastmonthyear();
            $data['staff']= $this->staff_model->get_active_staff();
            $this->load->view('includes/header', $data);
            $this->load->view('setting/print_payment_slips');
            $this->load->view('includes/footer');
        }
    }
    
    public function searchpayments(){
        
        $data = $this->staff_model->searchpayments($this->input->post('staff_id'), $this->input->post('payment_month'), $this->input->post('payment_year'));
        echo (json_encode($data));
    }

    public function day_attendance(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {    
            //$data['business'] = $this->business_model->getbusinessdetails();

            $data['staff']= $this->staff_model->day_attendance();
            $this->load->view('includes/header', $data);
            $this->load->view('attendance_view');
            $this->load->view('includes/footer');
        }
        
    }
    
    public function searchnameforstaff(){
        
        $staffname = $this->input->get("staffname", TRUE);
        $data = $this->staff_model->searchnameforstaff($staffname);

        echo(json_encode($data));
        
    }
    
 }
