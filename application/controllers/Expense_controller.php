<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Expense_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('expense_model');
        $this->load->model('accounting_model');
        $this->load->model('supplier_model');
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        }
    }

    public function daily_expense_list() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1, 0, 1);

            $data['nav'] = 'invoice';
            $data['subnav'] = 'daily_expenses';

            $data['expense_accounts']=$this->accounting_model->get_all_till_account_heads('Expense');
            $data['cash_account']=$this->accounting_model->get_all_account_heads('Cash');
            $data['suppliers']=$this->supplier_model->get_suppliers();

            $this->load->view('includes/header', $data);
            $this->load->view('daily_expense_view');
            $this->load->view('includes/footer');
        }
    }

    public function daily_expense_list_get() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);
        $data = $this->expense_model->get_daily_expense_list($startdate, $enddate);
        echo (json_encode($data));
        die;
    }

    public function account_voucher_cancelled() {
        $data = $this->accounting_model->cancel_voucher($this->input->post('id_account_voucher'));
        echo "success|" . $data;
        die;
    }

    public function add_account_voucher() {
        
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
            'business_partner_name'=>$this->input->post('business_partner_name', TRUE),
            'voucher_type'=>$this->input->post('voucher_type', TRUE),
            'payment_mode'=>$this->input->post('payment_mode', TRUE),
            'bank_name'=>$bank_name

        );
        
        
        $result = $this->expense_model->add_account_voucher($data, $debit_accounts, $credit_accounts);
        echo "success|" . $result;
        
    }

    public function edit_account_voucher() {
        $data = $this->expense_model->get_account_voucher_by_id();
        echo (json_encode($data));
        die;
    }
    
    public function update_account_voucher(){
        $result = $this->expense_model->update_account_voucher();
        echo "success|" . $result;
        die;
    }

}
