<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Accounting_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('accounting_model');
        $this->load->model('business_model');
        $this->load->model('supplier_model');
        $this->load->model('purchaseorder_model');
        $this->load->model('report_model');
       
    }

    public function coa() {
        if ($this->session->userdata('role') === '' || $this->session->userdata('role') === 'Sh-Users') {
            $this->load->view('login_view');  
             
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'accounting';
            $data['subnav'] = 'accounting';

            $data['business'] = $this->business_model->get_business_details();

            $data['account_heads'] = $this->accounting_model->get_all_account_heads();


            $this->load->view('includes/header', $data);
            $this->load->view('accounting/coa_view');
            $this->load->view('includes/footer');
        }
    }

    function accountheadedit(){
        if ($this->session->userdata('role') === '' || $this->session->userdata('role') === 'Sh-Users') {
            $this->load->view('login_view');  
             
        } else {
            $account_head_id=$this->input->post('id_account_head');

            $data['account_sub_types']=$this->accounting_model->get_account_subtypes();
            $data['account_head']=$this->accounting_model->get_account_head($account_head_id);

            $this->load->view('includes/header', $data);
            $this->load->view('accounting/account_head_edit');
            $this->load->view('includes/footer');
        }
    }
    
    function update_account_head(){
        if ($this->session->userdata('role') === '' || $this->session->userdata('role') === 'Sh-Users') {
            $this->load->view('login_view');  
             
        } else {
            $result = $this->accounting_model->account_head_update();
            if($result && $result>0){
                $this->session->set_flashdata('Success', 'Record successfully updated!');
            } else {
                $this->session->set_flashdata('Error', 'Record not updated!');
            }
            $account_head_id=$this->input->post('id_account_heads');
            $data['account_sub_types']=$this->accounting_model->get_account_subtypes();
            $data['account_head']=$this->accounting_model->get_account_head($account_head_id);

            $this->load->view('includes/header', $data);
            $this->load->view('accounting/account_head_edit');
            $this->load->view('includes/footer');
        }
    }
    
    function accountheadadd(){
        if ($this->session->userdata('role') === '' || $this->session->userdata('role') === 'Sh-Users') {
            $this->load->view('login_view');  
             
        } else {
            $data['account_sub_types']=$this->accounting_model->get_account_subtypes();

            $this->load->view('includes/header', $data);
            $this->load->view('accounting/account_head_add');
            $this->load->view('includes/footer');
        }
    }
    
    function insert_account_head(){
        if ($this->session->userdata('role') === '' || $this->session->userdata('role') === 'Sh-Users') {
            $this->load->view('login_view');  
             
        } else {
            $account_head_id = $this->accounting_model->account_head_insert();
            if($account_head_id && $account_head_id>0){
                $this->session->set_flashdata('Success', 'Account Head successfully added!');
            } else {
                $this->session->set_flashdata('Error', 'Account Head not added!');
            }

            $data['account_sub_types']=$this->accounting_model->get_account_subtypes();
            $data['account_head']=$this->accounting_model->get_account_head($account_head_id);

            $this->load->view('includes/header', $data);
            $this->load->view('accounting/account_head_edit');
            $this->load->view('includes/footer');
        }
    }
    
    

    public function account_vouchers() {

        if ($this->session->userdata('role') === '' || $this->session->userdata('role') === 'Sh-Users') {
            $this->load->view('login_view');  
             
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'accounting';
            $data['subnav'] = 'accounting';

            $data['business'] = $this->business_model->get_business_details();
            $data['voucher_types'] = $this->accounting_model->get_voucher_types();
            $data['account_vouchers'] = $this->accounting_model->get_all_account_vouchers();

            if(null !== $this->input->post('startdate')){
                $data['startdate'] = $this->input->post('startdate'); 
            }else {$data['startdate'] ='';}
            if(null !==  $this->input->post('enddate')){
                $data['enddate'] = $this->input->post('enddate');
            }else {$data['enddate'] ='';}
            if(null !==  $this->input->post('voucher_type')){
                $data['voucher_type'] = $this->input->post('voucher_type');
            } else {$data['voucher_type'] ='';}
            $this->load->view('includes/header', $data);
            $this->load->view('accounting/account_vouchers_list');
            $this->load->view('includes/footer');
        }
        
    }
    
    public function general_ledger(){
        if ($this->session->userdata('role') === '' || $this->session->userdata('role') === 'Sh-Users') {
            $this->load->view('login_view');  
             
        } else {
            //storemanager,hr,reception...user serial
             checkroles(0, 0, 0);

             $data['nav'] = 'accounting';
             $data['subnav'] = 'accounting';

             if(null !== $this->input->post('startdate')){
                 $data['startdate'] = $this->input->post('startdate'); 
             }else {$data['startdate'] ='';}
             if(null !==  $this->input->post('enddate')){
                 $data['enddate'] = $this->input->post('enddate');
             }else {$data['enddate'] ='';}
             if(null !==  $this->input->post('voucher_type')){
                 $data['voucher_type'] = $this->input->post('voucher_type');
             } else {$data['voucher_type'] ='';}
               if(null !== $this->input->post('from_accounts')){
                 $data['from_account'] = $this->input->post('from_accounts'); 
             }else {$data['fromaccount'] ='';}

             if(null !== $this->input->post('to_accounts')){
                 $data['to_account'] = $this->input->post('to_accounts'); 
             }else {$data['to_account'] ='';}

             $data['business'] = $this->business_model->get_business_details();
             $data['account_heads'] = $this->accounting_model->get_all_account_heads();
             if(null !== $this->input->post('startdate')){

                 $data['voucher_types'] = $this->accounting_model->get_voucher_types();
                 $data['account_vouchers'] = $this->accounting_model->get_all_account_vouchers_opening_balance();

             } else {

                 $data['voucher_types'] = [];
                 $data['account_vouchers'] = [];

             }


             $this->load->view('includes/header', $data);
             $this->load->view('accounting/general_ledger');
             $this->load->view('includes/footer');
        }
        
    }
    
    public function trial_balacne(){
        if ($this->session->userdata('role') === '' || $this->session->userdata('role') === 'Sh-Users') {
            $this->load->view('login_view');  
             
        } else {
            //storemanager,hr,reception...user serial
              checkroles(0, 0, 0);

              $startdate = $this->input->post('startdate'); 
              $enddate = $this->input->post('enddate');
              $voucher_type = $this->input->post('voucher_type');

              $from_account = $this->input->post('from_accounts');
              $to_account = $this->input->post('to_accounts');

              if($startdate==""){
                  $startdate= date('Y-m-d');
              }
              if($enddate==""){
                  $enddate= date('Y-m-d');
              }

              $data['nav'] = 'accounting';
              $data['subnav'] = 'accounting';

              $data['business'] = $this->business_model->get_business_details();
              $data['voucher_types'] = $this->accounting_model->get_voucher_types();
              $data['account_heads'] = $this->accounting_model->get_all_account_heads();
              $data['get_accounts'] = $this->accounting_model->get_all_account_heads_params($from_account,$to_account);
              $data['trial_data'] = array();


              foreach($data['get_accounts'] as $accounts){
                  $opening_Asset = [];
                  $opening_Liability = [];
                  $current_Asset = [];
                  $current_Liability = [];

                  if($accounts['account_type']=="Assets"||$accounts['account_type']=="Expenses"){            
                      $data['openingBalanceAsset'] = $this->accounting_model->getOpening_balance_asset($startdate,$accounts['id_account_heads']);
                      $opening_Asset = array('opening_asset'=>$data['openingBalanceAsset']);
                  } else {
                      $data['openingBalanceLiability'] = $this->accounting_model->getOpening_balance_liability($startdate,$accounts['id_account_heads']);
                      $opening_Liability = array('opening_liability'=>$data['openingBalanceLiability']);
                  }

                  if($accounts['account_type']=="Assets"||$accounts['account_type']=="Expenses"){            
                      $data['currentBalanceAsset'] = $this->accounting_model->getCurrent_balance_asset($startdate,$enddate,$accounts['id_account_heads']);
                      $current_Asset = array('current_asset'=>$data['currentBalanceAsset']);
                  } else {
                     $data['currentBalanceLiability'] = $this->accounting_model->getCurrent_balance_liability($startdate,$enddate,$accounts['id_account_heads']);
                     $current_Liability = array('current_liability'=>$data['currentBalanceLiability']);
                  }


                  array_push($data['trial_data'], array_merge($accounts,$opening_Asset,$opening_Liability,$current_Asset,$current_Liability)); 

              }

              if(null !== $this->input->post('startdate')){
                  $data['startdate'] = $this->input->post('startdate'); 
              }else {$data['startdate'] ='';}
              if(null !==  $this->input->post('enddate')){
                  $data['enddate'] = $this->input->post('enddate');
              }else {$data['enddate'] ='';}
              if(null !==  $this->input->post('voucher_type')){
                  $data['voucher_type'] = $this->input->post('voucher_type');
              } else {$data['voucher_type'] ='';}
                if(null !== $this->input->post('from_accounts')){
                  $data['from_account'] = $this->input->post('from_accounts'); 
              }else {$data['fromaccount'] ='';}

              if(null !== $this->input->post('to_accounts')){
                  $data['to_account'] = $this->input->post('to_accounts'); 
              }else {$data['to_account'] ='';}

              $this->load->view('includes/header', $data);
              $this->load->view('accounting/trial_balance');
              $this->load->view('includes/footer');
        }
        
    }
    
    public function balacne_sheet(){
        if ($this->session->userdata('role') === '' || $this->session->userdata('role') === 'Sh-Users') {
            $this->load->view('login_view');  
             
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $startdate = $this->input->post('startdate'); 
            $enddate = $this->input->post('enddate');
            $voucher_type = $this->input->post('voucher_type');

            $from_account = $this->input->post('from_accounts');
            $to_account = $this->input->post('to_accounts');

            if($from_account == ""){
                $from_account = 1;
            }
            if($to_account == ""){
                $to_account = 1;
            }

            if($startdate==""){
                $startdate= date('Y-m-d');
            }
            if($enddate==""){
                $enddate= date('Y-m-d');
            }

            $data['nav'] = 'accounting';
            $data['subnav'] = 'accounting';

            $data['business'] = $this->business_model->get_business_details();
            $data['voucher_types'] = $this->accounting_model->get_voucher_types();
            $data['account_heads'] = $this->accounting_model->get_all_account_heads();
            $data['account_type'] = $this->accounting_model->get_account_types();
            $data['invoice'] = $this->accounting_model->get_cash_info($startdate,$enddate);
            $data['voucher'] = $this->accounting_model->get_cash_voucher($startdate,$enddate);


            foreach($data['account_type'] as $ma){
                $data['account_sub_type'] = $this->accounting_model->get_account_subtypes($ma['id_account_type']);
                foreach($data['account_sub_type'] as $row){
                    $id = intval($row['id_account_sub_types']);
                    $data['accounts'] = $this->accounting_model->get_all_account_heads($id);
                        foreach($data['accounts'] as $acc){
                            $data['blanace_sheet_assets'] = $this->accounting_model->balanceSheet($startdate,$enddate,$acc['id_account_heads'],$ma['trail_balance_type']);
                            $data['balanceSheet'][$ma['account_type']][$row['account_sub_type']][$acc['account_head']] = $data['blanace_sheet_assets'];
                        }
                }
            }

            if(null !== $this->input->post('startdate')){
                $data['startdate'] = $this->input->post('startdate'); 
            }else {$data['startdate'] ='';}
            if(null !==  $this->input->post('enddate')){
                $data['enddate'] = $this->input->post('enddate');
            }else {$data['enddate'] ='';}
            if(null !==  $this->input->post('voucher_type')){
                $data['voucher_type'] = $this->input->post('voucher_type');
            } else {$data['voucher_type'] ='';}
              if(null !== $this->input->post('from_accounts')){
                $data['from_account'] = $this->input->post('from_accounts'); 
            }else {$data['fromaccount'] ='';}

            if(null !== $this->input->post('to_accounts')){
                $data['to_account'] = $this->input->post('to_accounts'); 
            }else {$data['to_account'] ='';}

            $this->load->view('includes/header', $data);
            $this->load->view('accounting/balance_sheet');
            $this->load->view('includes/footer');
        }
        
    }
    
    public function profit_loss(){
        if ($this->session->userdata('role') === '' || $this->session->userdata('role') === 'Sh-Users') {
            $this->load->view('login_view');  
             
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $startdate = $this->input->post('startdate'); 
            $enddate = $this->input->post('enddate');
            $voucher_type = $this->input->post('voucher_type');

            $from_account = $this->input->post('from_accounts');
            $to_account = $this->input->post('to_accounts');

            if($from_account == ""){
                $from_account = 1;
            }
            if($to_account == ""){
                $to_account = 1;
            }

            if($startdate==""){
                $startdate= date('Y-m-d');
            }
            if($enddate==""){
                $enddate= date('Y-m-d');
            }

            $data['nav'] = 'accounting';
            $data['subnav'] = 'accounting';

            $data['business'] = $this->business_model->get_business_details();
            $data['voucher_types'] = $this->accounting_model->get_voucher_types();
            $data['account_heads'] = $this->accounting_model->get_all_account_heads();
            $data['account_type'] = $this->accounting_model->get_account_types();
            $data['invoice'] = $this->accounting_model->get_cash_info($startdate,$enddate);
            $data['voucher'] = $this->accounting_model->get_cash_voucher($startdate,$enddate);

           // echo "<pre>";
          //  print_r($data['voucher']);
          //  exit();

            foreach($data['account_type'] as $ma){
                $data['account_sub_type'] = $this->accounting_model->get_account_subtypes($ma['id_account_type']);
                foreach($data['account_sub_type'] as $row){
                    $id = intval($row['id_account_sub_types']);
                    $data['accounts'] = $this->accounting_model->get_all_account_heads($id);
                        foreach($data['accounts'] as $acc){
                            $data['pl'] = $this->accounting_model->profit_and_loss($startdate,$enddate,$acc['id_account_heads'],$ma['trail_balance_type'],$ma['account_type']);
                            $data['profit_loss'][$ma['account_type']][$row['account_sub_type']][$acc['account_head']] = $data['pl'];
                        }
                }
            }

            if(null !== $this->input->post('startdate')){
                $data['startdate'] = $this->input->post('startdate'); 
            }else {$data['startdate'] ='';}
            if(null !==  $this->input->post('enddate')){
                $data['enddate'] = $this->input->post('enddate');
            }else {$data['enddate'] ='';}
            if(null !==  $this->input->post('voucher_type')){
                $data['voucher_type'] = $this->input->post('voucher_type');
            } else {$data['voucher_type'] ='';}
              if(null !== $this->input->post('from_accounts')){
                $data['from_account'] = $this->input->post('from_accounts'); 
            }else {$data['fromaccount'] ='';}

            if(null !== $this->input->post('to_accounts')){
                $data['to_account'] = $this->input->post('to_accounts'); 
            }else {$data['to_account'] ='';}

            $this->load->view('includes/header', $data);
            $this->load->view('accounting/profit_loss');
            $this->load->view('includes/footer');
        }
        
    }
    
    public function get_vouchers(){
  
            //ajax
            $data = $this->accounting_model->get_all_account_vouchers();
            echo (json_encode($data));
    
        
    }
    public function get_vouchers_created(){
        
            //ajax
            $data = $this->accounting_model->get_all_vouchers_created();
            echo (json_encode($data));
        
    }
    
    public function accountvoucheradd(){
        if ($this->session->userdata('role') === '' || $this->session->userdata('role') === 'Sh-Users') {
            $this->load->view('login_view');  
             
        } else {
            //open add page   
           checkroles(0, 0, 0);

           $data['nav'] = 'accounting';
           $data['subnav'] = 'accounting';

           $data['business'] = $this->business_model->get_business_details();
           $data['account_voucher_types'] = $this->accounting_model->get_account_voucher_type();
           $data['account_business_partners'] = $this->accounting_model->get_account_business_partners();
           $data['bank_accounts'] = $this->accounting_model->get_bank_accounts();
           $data['account_heads'] = $this->accounting_model->get_all_account_heads();
           $data['cost_center_types'] = $this->accounting_model->get_cost_center_types();

           $this->load->view('includes/header', $data);
           $this->load->view('accounting/account_voucher_add');
           $this->load->view('includes/footer');  
        }
        
    }
    
    
    function insert_account_voucher(){
      
            $debit_accounts=$this->input->post('debit_accounts', TRUE);
            $credit_accounts=$this->input->post('credit_accounts', TRUE);
            $bank_name='';
            if(null!==$this->input->post('bank_accounts')){$bank_name=$this->input->post('bank_accounts');}
            $data = array( 
                'business_id' => $this->session->userdata('businessid'),
                'description' => $this->input->post('description', TRUE),
                'voucher_date' => $this->input->post('voucher_date', TRUE),
                'voucher_amount' => $this->input->post('voucher_amount', TRUE),
                'voucher_status' => 'Active',
                'created_by' => $this->session->userdata('username'),
                'cost_center'=>$this->input->post('cost_center', TRUE),
                'cost_center_name'=>$this->input->post('cost_center_name', TRUE),
                'business_partner'=>$this->input->post('business_partner', TRUE),
                'business_partner_id'=>$this->input->post('business_partner_id', TRUE),
                'business_partner_name'=>$this->input->post('business_partner_name', TRUE),
                'voucher_type'=>$this->input->post('voucher_type', TRUE),
                'payment_mode'=>$this->input->post('payment_mode', TRUE),
                'bank_name'=>$bank_name

            );

            $result = $this->accounting_model->add_account_voucher($data, $debit_accounts, $credit_accounts);
            if($result && $result>0){
                echo "success|" . $result;
            } else {
                echo "error|" . $result;
            }
        
    }
    
    function create_account_voucher(){
        
            $result = $this->accounting_model->create_account_voucher();
            if($result && $result>0){
                echo "success|" . $result;
            } else {
                echo "error|" . $result;
            }
        
        
    }
    
    function payments(){
        if ($this->session->userdata('role') === '' || $this->session->userdata('role') === 'Sh-Users') {
            $this->load->view('login_view');  
             
        } else {

            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'reception';
            $data['subnav'] = 'reception';

            $data['business'] = $this->business_model->get_business_details();
            $data['suppliers'] = $this->supplier_model->get_suppliers();
            $data['payments'] = $this->accounting_model->get_payments();

            if(null !== $this->input->post('startdate')){
                $data['startdate'] = $this->input->post('startdate'); 
            }else {$data['startdate'] ='';}
            if(null !==  $this->input->post('enddate')){
                $data['enddate'] = $this->input->post('enddate');
            }else {$data['enddate'] ='';}
            if(null !==  $this->input->post('voucher_type')){
                $data['voucher_type'] = $this->input->post('voucher_type');
            } else {$data['voucher_type'] ='';}
            $this->load->view('includes/header', $data);
            $this->load->view('accounting/payments');
            $this->load->view('includes/footer');
        }
    }
    
    function statement(){
        if ($this->session->userdata('role') === '' || $this->session->userdata('role') === 'Sh-Users') {
            $this->load->view('login_view');  
             
        } else {
    
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'accounting';
            $data['subnav'] = 'accounting';

            $startdate=$this->input->post('startdate', TRUE);
            $enddate=$this->input->post('enddate', TRUE);

            if(!isset($startdate) || empty($startdate)){
                 $startdate = date('Y-m-01');
            }

            if(!isset($enddate) || empty($enddate)){
                 $enddate = date('Y-m-d');
            }

            //get the posted values
            $data['startdatetxt'] = date("d-M-Y", strtotime($startdate));
            $data['enddatetxt'] = date("d-M-Y", strtotime($enddate));
            $data['startdate'] = $startdate;
            $data['enddate'] = $enddate;


             $this->load->model('staff_model');

            $data['business'] = $this->business_model->get_business_details();
            $data['serviceincome'] = $this->accounting_model->get_month_services($startdate, $enddate);
            $data['retailincome'] = $this->accounting_model->get_month_sales($startdate, $enddate);

            $data['advancereceived'] = $this->accounting_model->get_month_advance($startdate, $enddate);

            $data['paymentvouchers'] = $this->accounting_model->getstatementpayments($startdate, $enddate,1);
            $data['receivevouchers'] = $this->accounting_model->getstatementpayments($startdate, $enddate,2);

            $data['salaries'] = $this->staff_model->get_staff_payments('Salary', $startdate, $enddate);
            $data['commissions'] = $this->staff_model->get_staff_payments('Commission',$startdate, $enddate);
            $data['otherstaffpayments'] = $this->staff_model->get_staff_payments('Other',$startdate, $enddate);

            $this->load->view('includes/header', $data);
            $this->load->view('accounting/statement');
            $this->load->view('includes/footer');
        }
        
    }
    
    function supplier_payment($po_id){
         if ($this->session->userdata('role') === '' || $this->session->userdata('role') === 'Sh-Users') {
            $this->load->view('login_view');  
             
        } else {
            $data['business'] = $this->business_model->get_business_details();


            $data['bank_accounts'] = $this->accounting_model->get_bank_accounts();
            $data['cost_center_types'] = $this->accounting_model->get_cost_center_types();
            $data['purchase_order'] = $this->purchaseorder_model->get_purchase_order_by_id($po_id);

            $this->load->view('includes/header', $data);
            $this->load->view('accounting/supplier_payment');
            $this->load->view('includes/footer');
        }
        
    }
    function insert_po_payment(){
         if ($this->session->userdata('role') === '' || $this->session->userdata('role') === 'Sh-Users') {
            $this->load->view('login_view');  
             
        } else {
            $result=$this->accounting_model->insert_po_payment();

            if($result && $result>0){
                $this->session->set_flashdata('Success', 'Record successfully updated!');
            } else {
                $this->session->set_flashdata('Error', 'Record not updated!');
            }

            redirect('grn_list/'.$this->input->post('txtpurchaseorderid'));
        }
    }
    
    function cancel_voucher(){
         if ($this->session->userdata('role') === '' || $this->session->userdata('role') === 'Sh-Users') {
            $this->load->view('login_view');  
             
        } else {
            $result = $this->accounting_model->cancel_voucher($this->input->post('id_account_voucher'));

            if($result && $result>0){
                $this->session->set_flashdata('Success', 'Record successfully updated!');
            } else {
                $this->session->set_flashdata('Error', 'Record not updated!');
            }

            $data['business'] = $this->business_model->get_business_details();

            $data['return_path']=$this->input->post('return_path');

            $this->load->view('includes/header', $data);
            $this->load->view('accounting/result_view');
            $this->load->view('includes/footer');
        }
        
    }
    
    function cashregister_listing(){
         if ($this->session->userdata('role') === '' || $this->session->userdata('role') === 'Sh-Users') {
            $this->load->view('login_view');  
             
        } else {
    //       $startdate = $this->input->post('startdate', TRUE);
    //       $enddate = $this->input->post('enddate');

   //        if(null!==$this->input->post('startdate')){
   //            $startdate=$this->input->post('startdate');
   //        } else {$startdate =date('Y-m-01');}

          // echo $this->input->post('enddate');exit();
           if(null!==$this->input->post('enddate')){
               $enddate=$this->input->post('enddate');
           } else {$enddate = date('Y-m-d');;}

           $date = DateTime::createFromFormat('Y-m-d',$enddate);

           $startdate = $date->modify("-7 days");
       //    echo $startdate->format("Y-m-d");
       //    exit();
           //storemanager,hr,reception...user serial
           checkroles(0, 0, 0);

           $data['nav'] = 'accounting';
           $data['subnav'] = 'accounting';

           $data['business'] = $this->business_model->get_business_details();


           $transactions=[];
           $denominations=[];
           $expenses=[];
           $vouchers=[];
           $yesterdaytill=[];


           $today=$startdate->format('Y-m-d');
          // echo $today;exit();
           while($today <= $enddate){

              $tomorrow=$this->report_model->gettomorrowfromserver($today);

              array_push($transactions, $this->report_model->cash_register($today, $tomorrow));
              array_push($denominations, $this->report_model->get_cash_register($today, $tomorrow));
              array_push($expenses, $this->report_model->get_today_expenses($today, $tomorrow));
              array_push($vouchers, $this->report_model->get_cash_voucher($today, $tomorrow));
              array_push($yesterdaytill, $this->report_model->get_yesterday_till_amount($today, $tomorrow));


              $today=$tomorrow;
           }
           $data['transactions']=$transactions;
           $data['denominations']=$denominations;
           $data['expenses']=$expenses;
           $data['vouchers']=$vouchers;
           $data['yesterdaytill']=$yesterdaytill;
           $data['selectedstatus']=$this->input->post('selectedstatus');

           $data['cashregisters'] = $this->report_model->cash_register($today, $tomorrow);        

           $this->load->view('includes/header', $data);
           $this->load->view('accounting/cashregister_listing');
           $this->load->view('includes/footer');
        }
        
    }
}
