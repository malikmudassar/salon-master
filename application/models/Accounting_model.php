<?php

class Accounting_model extends CI_Model {

    function __construct() {

        // Call the Model constructor
        parent::__construct();
    }
    
    
    function get_account_voucher_type(){
        
        $this->db->select('*');
        $query = $this->db->get('account_voucher_type');

        return $query->result_array();
        
    }
    
    
    
    function get_account_business_partners(){
        
        $this->db->select('*');
        $query = $this->db->get('account_business_partner');

        return $query->result_array();
        
    }
    function get_account_category() {
        
        $this->db->select('*');
        $query = $this->db->get('account_category');

        return $query->result_array();
    }
    
    function get_account_types() {
        
        $this->db->select('*');
        $query = $this->db->get('account_type');

        return $query->result_array();
    }
    
    function get_account_subtypes($master_account_id = 0) {
        
        $this->db->select('*');
        if($master_account_id > 0){
            $this->db->where('account_type_id',$master_account_id);
        }
        $query = $this->db->get('account_sub_types');

        return $query->result_array();
    }
    
    function get_all_account_heads($account_type = null){
        
        $this->db->select("*, concat(at.account_type_number, '-',ast.account_sub_type_number ,'-', account_head_number) as account_number", False);
        $this->db->join("account_sub_types ast","ast.id_account_sub_types = account_heads.account_sub_type");
        $this->db->join("account_type at","at.id_account_type = ast.account_type_id");
        $this->db->join("account_category ac","ac.id_account_category = at.account_category_id");
        $this->db->where('account_heads.business_id', $this->session->userdata('businessid'));
        
        if($account_type!==null && is_string($account_type)){
            $this->db->where('account_heads.account_type', $account_type);
        }else if($account_type !== null && is_numeric($account_type)){
            $this->db->where('account_heads.account_sub_type', $account_type);
        }
        
        $query = $this->db->get('account_heads');

        return $query->result_array();
        
    }
    
    function get_all_till_account_heads(){
        
        $this->db->select("*, concat(at.account_type_number, '-',ast.account_sub_type_number ,'-', account_head_number) as account_number", False);
        $this->db->join("account_sub_types ast","ast.id_account_sub_types = account_heads.account_sub_type");
        $this->db->join("account_type at","at.id_account_type = ast.account_type_id");
        $this->db->join("account_category ac","ac.id_account_category = at.account_category_id");
        $this->db->where('account_heads.business_id', $this->session->userdata('businessid'));
        $this->db->where('account_heads.till_account', 'Yes');
    
        
        $query = $this->db->get('account_heads');

        return $query->result_array();
        
    }
    
    
    function get_all_account_heads_params($from_account=null,$to_account=null){
        
        $this->db->select("*, concat(at.account_type_number, '-',ast.account_sub_type_number ,'-', account_head_number) as account_number", False);
        $this->db->join("account_sub_types ast","ast.id_account_sub_types = account_heads.account_sub_type");
        $this->db->join("account_type at","at.id_account_type = ast.account_type_id");
        $this->db->join("account_category ac","ac.id_account_category = at.account_category_id");
        $this->db->where('account_heads.business_id', $this->session->userdata('businessid'));
        
        if(null!==$from_account && $from_account >0){
            $this->db->where('account_heads.id_account_heads >=', $from_account);
        }
        if(null!==$to_account && $to_account > 0){
            $this->db->where('account_heads.id_account_heads <=', $to_account);
        }
        
        $query = $this->db->get('account_heads');

        return $query->result_array();
        
    }
    
    function get_account_head($id){
        $this->db->select('*');
        $this->db->where('account_heads.id_account_heads', $id);
        $query = $this->db->get('account_heads');

        return $query->result_array();
        
    }
    
    function account_head_update(){
        
        $data = array(           
           'account_head' => $this->input->post('account_head', TRUE),
           'account_sub_type' => $this->input->post('account_head_type', TRUE),
           'account_head_number' => $this->input->post('account_head_number', TRUE),
            'account_type' => $this->input->post('account_type', TRUE)
        );
        $this->db->where('id_account_heads', $this->input->post('id_account_heads', TRUE));
        $this->db->update('account_heads', $data);
        return $this->db->affected_rows();
        
    }
    
    function account_head_insert(){
        
        $data = array(           
           'account_head' => $this->input->post('account_head', TRUE),
           'account_sub_type' => $this->input->post('account_head_type', TRUE),
           'account_head_number' => $this->input->post('account_head_number', TRUE),
           'account_type' => $this->input->post('account_type', TRUE),
           'business_id' => $this->session->userdata('businessid')
        );
        $this->db->insert('account_heads', $data);
        return $this->db->insert_id();
        
    }
    
    function get_voucher_types(){
        
        $this->db->select('*');
        $query = $this->db->get('account_voucher_type');
        
        return $query->result_array();
    }
    
    function get_all_account_vouchers(){
        
        $startdate = $this->input->post('startdate'); 
        $enddate = $this->input->post('enddate');
        $voucher_type = $this->input->post('voucher_type');
        if(null !== $this->input->post('dateselected') && $this->input->post('dateselected')!==""){
            $date_selected = $this->input->post('dateselected');
        } else {
            $date_selected = "Voucher";
        }
        
        if($startdate==""){
            $startdate= date('Y-m-d');
        }
        if($enddate==""){
            $enddate= date('Y-m-d');
        }
        
        
        $sql = "SELECT id_account_vouchers, description, account_voucher_type, 
                avd.cost_center as cost_center_name, business_partner_name, date_format(voucher_date,'%d-%m-%Y %h:%i') voucher_date, 
                date_format(created_on,'%d-%m-%Y %h:%i') created_on, av.created_by,
                account_head_number, account_head, debit, credit
                FROM account_vouchers av
                join account_voucher_type avt on avt.id_account_voucher_type = av.voucher_type
                join account_voucher_detail avd on avd.account_voucher_id = av.id_account_vouchers
                join account_heads ah on ah.id_account_heads = avd.account_head_id
                where voucher_status= 'Active' ";
        
        
                if($date_selected=="Voucher"){
                    if($startdate && $startdate!==""){
                        $sql .= " and voucher_date>='".$startdate."' ";
                    }
                    if($enddate && $enddate!==""){
                        $sql .= " and voucher_date<='".$enddate."' ";
                    }
                } else if ($date_selected=="Create"){
                    if($startdate && $startdate!==""){
                        $sql .= " and voucher_date>='".$startdate."' ";
                    }
                    if($enddate && $enddate!==""){
                        $sql .= " and voucher_date<='".$enddate."' ";
                    }
                    
                }
                $sql .= " and av.business_id=".$this->session->userdata('businessid');
                if($voucher_type && $voucher_type>0){
                    $sql .= " and av.voucher_type='".$voucher_type."' ";
                }
//                $sql .= " group by id_account_vouchers, description, account_voucher_type, 
//                cost_center_name, business_partner_name, voucher_date, av.created_by
//                order by id_account_vouchers";
                $sql .= " order by id_account_vouchers"; 
                
  //              echo $sql; 
        $query=$this->db->query($sql);
        return $query->result_array();
    }
    
    function get_all_vouchers_created(){
        
        $startdate = $this->input->post('startdate'); 
        $enddate = $this->input->post('enddate');
        $voucher_type = $this->input->post('voucher_type');
        
        if($startdate==""){
            $startdate= date('Y-m-d');
        }
        if($enddate==""){
            $enddate= date('Y-m-d');
        }
        
        
        $sql = "SELECT id_account_vouchers, description, account_voucher_type, 
                avd.cost_center as cost_center_name, business_partner_name, date_format(voucher_date,'%d-%m-%Y %h:%i') voucher_date, 
                date_format(created_on,'%d-%m-%Y %h:%i') created_on, av.created_by,
                account_head_number, account_head, debit, credit
                FROM account_vouchers av
                join account_voucher_type avt on avt.id_account_voucher_type = av.voucher_type
                join account_voucher_detail avd on avd.account_voucher_id = av.id_account_vouchers
                join account_heads ah on ah.id_account_heads = avd.account_head_id
                where voucher_status= 'Active' ";
                if($startdate && $startdate!==""){
                    $sql .= " and created_on>='".$startdate."' ";
                }
                if($enddate && $enddate!==""){
                    $sql .= " and created_on<='".$enddate."' ";
                }
                $sql .= " and av.business_id=".$this->session->userdata('businessid');
                if($voucher_type && $voucher_type>0){
                    $sql .= " and av.voucher_type='".$voucher_type."' ";
                }
//                $sql .= " group by id_account_vouchers, description, account_voucher_type, 
//                cost_center_name, business_partner_name, voucher_date, av.created_by
//                order by id_account_vouchers";
                $sql .= " order by id_account_vouchers"; 
        $query=$this->db->query($sql);
        return $query->result_array();
        
    }
    
    function get_all_account_vouchers_opening_balance(){
        
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
      
        if($from_account==""){
            $from_account= 1;
        }
        if($to_account==""){
            $to_account= 1;
        }
        if($from_account ==0 and $to_account==0){
            $sql = "SELECT * from account_heads where business_id=".$this->session->userdata('businessid').";";
        }else{
            $sql = "SELECT * from account_heads  where business_id=".$this->session->userdata('businessid')." and id_account_heads >=$from_account and id_account_heads <=$to_account ";
        }
        $query = $this->db->query($sql);
        
        $accounts =  $query->result_array();
        $data = array();
        foreach($accounts as $account):
        
            $sql = "SELECT id_account_vouchers, description, account_voucher_type, 
                    avd.cost_center as cost_center_name, business_partner_name, date_format(voucher_date,'%d-%m-%Y %h:%i') voucher_date, 
                    av.created_by,
                    account_head_number, account_head, ifnull(sum(ifnull(Debit,0))-sum(ifnull(Credit,0)),0) as 'opening'
                    FROM account_vouchers av
                    join account_voucher_type avt on avt.id_account_voucher_type = av.voucher_type
                    join account_voucher_detail avd on avd.account_voucher_id = av.id_account_vouchers
                    join account_heads ah on ah.id_account_heads = avd.account_head_id
                    
                    where voucher_status= 'Active' ";
                    if($startdate && $startdate!==""){
                        $sql .= " and voucher_date<'".$startdate."' ";
                    }
                    $sql .= " and av.business_id=".$this->session->userdata('businessid');
                    $sql .= " and avd.account_head_id='".$account['id_account_heads']."' ";
                    $sql .= " order by id_account_vouchers"; 
            
            $query=$this->db->query($sql);
            $openingBalance = $query->result_array();
            foreach($openingBalance as $detail):
                    $sql = "SELECT id_account_vouchers, description, account_voucher_type, 
                    avd.cost_center as cost_center_name, business_partner_name, date_format(voucher_date,'%d-%m-%Y %h:%i') voucher_date,
                    av.created_by,
                    account_head_number, account_head, debit, credit, at.account_type as 'account_type'                    
                    FROM account_vouchers av
                    join account_voucher_type avt on avt.id_account_voucher_type = av.voucher_type
                    join account_voucher_detail avd on avd.account_voucher_id = av.id_account_vouchers
                    join account_heads ah on ah.id_account_heads = avd.account_head_id
                    join account_sub_types ast on ah.account_sub_type = ast.id_account_sub_types
                    join account_type at on at.id_account_type = ast.account_type_id
                    where voucher_status= 'Active' ";
                    if($startdate && $startdate!==""){
                        $sql .= " and voucher_date>='".$startdate."' ";
                    }
                    if($enddate && $enddate!==""){
                        $sql .= " and voucher_date<='".$enddate."' ";
                    }
                    $sql .= " and av.business_id=".$this->session->userdata('businessid');
                    $sql .= " and avd.account_head_id='".$account['id_account_heads']."' ";
                    $sql .= " order by id_account_vouchers"; 
                
                $query = $this->db->query($sql);
                $details =  $query->result_array();
                if($detail['opening'] > 0){
                    $opening = $detail['opening'];
                }else{
                    $opening = 0;
                }
                $acc = $account['account_head_number']. '|' .  $account['account_head'];
                
                $data[$acc]['opening_balance'] = [$opening];
                $data[$acc]['details'] = $details;
                
            endforeach;    
        endforeach;
        return $data;
    }
    public function getOpening_balance_asset($startdate,$account_id){
        $sql = "SELECT ah.account_head,
            ifnull(sum(debit)- sum(credit),0) as 'balance'
            FROM account_vouchers av
            join account_voucher_type avt on avt.id_account_voucher_type = av.voucher_type
            join account_voucher_detail avd on avd.account_voucher_id = av.id_account_vouchers
            join account_heads ah on ah.id_account_heads = avd.account_head_id
            join account_sub_types ast on ast.id_account_sub_types = ah.account_sub_type
            join account_type at on at.id_account_type = ast.account_type_id
            where voucher_status= 'Active' ";

            if($startdate && $startdate!==""){
                $sql .= " and voucher_date<'".$startdate."' ";
            }
            $sql .= " and av.business_id=".$this->session->userdata('businessid');
            $sql .= " and avd.account_head_id='".$account_id."' ";
            $sql .= " group by ah.id_account_heads,ah.account_head"; 
                    
        $query=$this->db->query($sql);
        return $query->result_array();
    }
   
    public function getOpening_balance_liability($startdate,$account_id){
        $sql = "SELECT ah.account_head,
            ifnull(sum(credit)- sum(debit),0) as 'balance'
            FROM account_vouchers av
            join account_voucher_type avt on avt.id_account_voucher_type = av.voucher_type
            join account_voucher_detail avd on avd.account_voucher_id = av.id_account_vouchers
            join account_heads ah on ah.id_account_heads = avd.account_head_id
            join account_sub_types ast on ast.id_account_sub_types = ah.account_sub_type
            join account_type at on at.id_account_type = ast.account_type_id
            where voucher_status= 'Active' ";

            if($startdate && $startdate!==""){
                $sql .= " and voucher_date<'".$startdate."' ";
            }
            $sql .= " and av.business_id=".$this->session->userdata('businessid');
            $sql .= " and avd.account_head_id='".$account_id."' ";
            $sql .= " group by ah.id_account_heads,ah.account_head"; 
                    
        $query=$this->db->query($sql);
        return $query->result_array();
    }
    
    public function getCurrent_balance_asset($startdate,$enddate,$account_id){
        $sql = "SELECT ah.account_head,
            ifnull(sum(debit)- sum(credit),0) as 'balance'
            FROM account_vouchers av
            join account_voucher_type avt on avt.id_account_voucher_type = av.voucher_type
            join account_voucher_detail avd on avd.account_voucher_id = av.id_account_vouchers
            join account_heads ah on ah.id_account_heads = avd.account_head_id
            join account_sub_types ast on ast.id_account_sub_types = ah.account_sub_type
            join account_type at on at.id_account_type = ast.account_type_id
            where voucher_status= 'Active' ";

            if($startdate && $startdate!==""){
                        $sql .= " and voucher_date>='".$startdate."' ";
                    }
            if($enddate && $enddate!==""){
                $sql .= " and voucher_date<='".$enddate."' ";
            }
            $sql .= " and av.business_id=".$this->session->userdata('businessid');
            $sql .= " and avd.account_head_id='".$account_id."' ";
            $sql .= " group by ah.id_account_heads,ah.account_head"; 
                    
        $query=$this->db->query($sql);
        return $query->result_array();
    }
    public function getCurrent_balance_liability($startdate,$enddate,$account_id){
        $sql = "SELECT ah.account_head,
            ifnull(sum(credit)-sum(debit),0) as 'balance'
            FROM account_vouchers av
            join account_voucher_type avt on avt.id_account_voucher_type = av.voucher_type
            join account_voucher_detail avd on avd.account_voucher_id = av.id_account_vouchers
            join account_heads ah on ah.id_account_heads = avd.account_head_id
            join account_sub_types ast on ast.id_account_sub_types = ah.account_sub_type
            join account_type at on at.id_account_type = ast.account_type_id
            where voucher_status= 'Active' ";

            if($startdate && $startdate!==""){
                        $sql .= " and voucher_date>='".$startdate."' ";
                    }
            if($enddate && $enddate!==""){
                $sql .= " and voucher_date<='".$enddate."' ";
            }
            $sql .= " and av.business_id=".$this->session->userdata('businessid');
            $sql .= " and avd.account_head_id='".$account_id."' ";
            $sql .= " group by ah.id_account_heads,ah.account_head"; 
                    
        $query=$this->db->query($sql);
        return $query->result_array();
    }
    public function balanceSheet($startdate,$enddate,$account_id,$type){
        
        if($type === 'Debit'){
            $sql = "SELECT 
            ifnull(sum(debit)-sum(credit),0) as 'balance'
            FROM account_vouchers av
            join account_voucher_type avt on avt.id_account_voucher_type = av.voucher_type
            join account_voucher_detail avd on avd.account_voucher_id = av.id_account_vouchers
            join account_heads ah on ah.id_account_heads = avd.account_head_id
            join account_sub_types ast on ast.id_account_sub_types = ah.account_sub_type
            join account_type at on at.id_account_type = ast.account_type_id
            where voucher_status= 'Active'  and at.trail_balance_type ='Debit'";
        }else{
            $sql = "SELECT 
            ifnull(sum(credit)-sum(debit),0) as 'balance'
            FROM account_vouchers av
            join account_voucher_type avt on avt.id_account_voucher_type = av.voucher_type
            join account_voucher_detail avd on avd.account_voucher_id = av.id_account_vouchers
            join account_heads ah on ah.id_account_heads = avd.account_head_id
            join account_sub_types ast on ast.id_account_sub_types = ah.account_sub_type
            join account_type at on at.id_account_type = ast.account_type_id
            where voucher_status= 'Active'  and at.trail_balance_type ='Credit'";
        }
            if($startdate && $startdate!==""){
                $sql .= " and voucher_date>='".$startdate."' ";
            }
            if($enddate && $enddate!==""){
                $sql .= " and voucher_date<='".$enddate."' ";
            }
            
            $sql .= " and av.business_id=".$this->session->userdata('businessid');
            $sql .= " and avd.account_head_id='".$account_id."' ";
           // $sql .= " group by ah.id_account_heads,ah.account_head"; 
                    
        $query=$this->db->query($sql);
        return $query->result_array();
        
    }
    
    public function profit_and_loss($startdate,$enddate,$account_id,$type,$account_type){
        
        if($account_type === 'Revenue'){
            $sql = "SELECT 
            ifnull(sum(credit)-sum(debit),0) as 'amount'
            FROM account_vouchers av
            join account_voucher_type avt on avt.id_account_voucher_type = av.voucher_type
            join account_voucher_detail avd on avd.account_voucher_id = av.id_account_vouchers
            join account_heads ah on ah.id_account_heads = avd.account_head_id
            join account_sub_types ast on ast.id_account_sub_types = ah.account_sub_type
            join account_type at on at.id_account_type = ast.account_type_id
            where voucher_status= 'Active'  and at.trail_balance_type ='Credit'";
        }elseif($account_type === 'Expenses'){
            $sql = "SELECT 
            ifnull(sum(debit)-sum(credit),0) as 'amount'
            FROM account_vouchers av
            join account_voucher_type avt on avt.id_account_voucher_type = av.voucher_type
            join account_voucher_detail avd on avd.account_voucher_id = av.id_account_vouchers
            join account_heads ah on ah.id_account_heads = avd.account_head_id
            join account_sub_types ast on ast.id_account_sub_types = ah.account_sub_type
            join account_type at on at.id_account_type = ast.account_type_id
            where voucher_status= 'Active'  and at.trail_balance_type ='Debit'";
        }else{
            $sql = "SELECT 
            ifnull(sum(debit)-sum(credit),0) as 'amount'
            FROM account_vouchers av
            join account_voucher_type avt on avt.id_account_voucher_type = av.voucher_type
            join account_voucher_detail avd on avd.account_voucher_id = av.id_account_vouchers
            join account_heads ah on ah.id_account_heads = avd.account_head_id
            join account_sub_types ast on ast.id_account_sub_types = ah.account_sub_type
            join account_type at on at.id_account_type = ast.account_type_id
            where voucher_status= 'Active'  and at.trail_balance_type ='Credit'";
        }
        
        if($startdate && $startdate!==""){
            $sql .= " and voucher_date>='".$startdate."' ";
        }
        if($enddate && $enddate!==""){
            $sql .= " and voucher_date<='".$enddate."' ";
        }
            
        $sql .= " and av.business_id=".$this->session->userdata('businessid');
        $sql .= " and avd.account_head_id='".$account_id."' ";
        
                    
        $query=$this->db->query($sql);
        return $query->result_array();
        
    }
    
    function get_account_voucher($id){
        
        $this->db->select('*');
        $this->db->join('account_voucher_detail','id_account_vouchers = account_voucher_id');
        $this->db->join('account_heads', 'account_head_id = id_account_heads');
        $query=$this->db->get('account_vouchers');
        
        return $query->result_array();
        
    }
  
    function add_account_voucher($data, $debit_accounts, $credit_accounts){
        
        
        $this->db->insert('account_vouchers', $data);
        $voucher_id =  $this->db->insert_id();
        
        
        foreach($debit_accounts as $debit){
            $a = explode("|", $debit);
            $data_detail=array(
                'account_voucher_id' => $voucher_id,
                'account_head_id' => $a[0],
                'debit' => $a[1],
                'credit' => 0
            );
             $this->db->insert('account_voucher_detail', $data_detail);
        }
        foreach($credit_accounts as $credit){
            $a = explode("|", $credit);
            $data_detail=array(
                'account_voucher_id' => $voucher_id,
                'account_head_id' => $a[0],
                'debit' => 0,
                'credit' => $a[1]
            );
            $this->db->insert('account_voucher_detail', $data_detail);
        }
        return $voucher_id;
    }
    
    public function create_account_voucher(){
                   
        parse_str($this->input->post('voucherdata', TRUE), $voucher_data);
        $bank_name='';
        if(null!==$this->input->post('bank_accounts')){$bank_name=$this->input->post('bank_accounts');}
        
       
        $data = array( 
            'business_id' => $this->session->userdata('businessid'),
            'description' => $voucher_data['description'],
            'voucher_date' => $voucher_data['account_voucher_date'],
            'voucher_amount' => $voucher_data['amount'],
            'voucher_status' => 'Active',
            'created_by' => $this->session->userdata('username'),
            'cost_center'=> $voucher_data['cost_center_type'],
            'cost_center_name'=> $voucher_data['cost_center'],
            'business_partner'=> $voucher_data['business_partner_type'],
            'business_partner_id'=> $this->input->post('business_partner_id'),
            'business_partner_name'=> $voucher_data['business_partner'],
            'voucher_type'=> $voucher_data['account_voucher_type'],
            'bank_name'=> $bank_name,
            'payment_mode'=> $voucher_data['voucher_payment_mode']
        );
        
        $this->db->insert('account_vouchers', $data);
        $voucher_id =  $this->db->insert_id();
       
        // Unescape the string values in the JSON array
        $tableData = stripcslashes($this->input->post('voucherdetails', TRUE));
         // Decode the JSON array
        $tableData = json_decode($tableData,TRUE);
        
        foreach($tableData as $row){
           if($row['account_head']!==""){
                $data = array(
                    'account_voucher_id' => $voucher_id,
                    'account_head_id' => $row['account_head'],
                    'debit' => $row['debit'],
                    'credit' => $row['credit'],
                    'cost_center' => $row['cost_center'],
                    'cost_center_type' => $row['cost_center_type'],
                    'instrument_number' => $row['instrument_number'],
                    'detail_remarks' => $row['remarks'],
                    'payment_mode' => $row['payment_mode']
                );
                $this->db->insert('account_voucher_detail', $data);
           }
        }
        return $voucher_id;
        
    }
    
    public function get_bank_accounts(){
        
        $this->db->select("*");
        $this->db->where("account_type=","Bank");
        $this->db->where("business_id",$this->session->userdata('businessid'));
        $query=$this->db->get("account_heads");
        return $query->result_array();
        
        
    }
    public function get_cost_center_types(){
        
        $this->db->select("*");
        $query=$this->db->get("account_cost_center");
        return $query->result_array();
        
        
    }
    public function get_payments(){
        $startdate = $this->input->post('startdate'); 
        $enddate = $this->input->post('enddate');
        $supplier = $this->input->post('supplier');
        
        if($startdate==""){
            $startdate= date('Y-m-d');
        }
        if($enddate==""){
            $enddate= date('Y-m-d');
        }
        $sql = "SELECT id_account_vouchers, description, account_voucher_type, 
                avd.cost_center as cost_center_name, business_partner_name, date_format(voucher_date,'%d-%m-%Y %h:%i') voucher_date, av.created_by,
                account_head_number, account_head, debit, credit
                FROM account_vouchers av
                join account_voucher_type avt on avt.id_account_voucher_type = av.voucher_type
                join account_voucher_detail avd on avd.account_voucher_id = av.id_account_vouchers
                join account_heads ah on ah.id_account_heads = avd.account_head_id
                where voucher_status= 'Active' ";
                if($startdate && $startdate!==""){
                    $sql .= " and voucher_date>='".$startdate."' ";
                }
                if($enddate && $enddate!==""){
                    $sql .= " and voucher_date<='".$enddate."' ";
                }
                if($supplier !== ""){
                    $sql .= " and business_partner_id='".$supplier."' ";
                }
                
                $sql .= " and av.business_id=".$this->session->userdata('businessid');
                $sql .= " and av.voucher_type=1 ";
                $sql .= " order by id_account_vouchers"; 
        $query=$this->db->query($sql);
        return $query->result_array();
        
    }
    
    function getstatementpayments($startdate, $enddate, $vouchertype){
        
        $sql="SELECT sum(debit) 'payments' 
            FROM account_vouchers
            join account_voucher_detail on account_voucher_detail.account_voucher_id = account_vouchers.id_account_vouchers
            where voucher_type = ".$vouchertype."
            and voucher_date >= '".$startdate."' 
            and voucher_date <= '".$enddate."' 
            and business_id=".$this->session->userdata('businessid')." 
            order by id_account_vouchers desc";
        
        
        $query =$this->db->query($sql);
        
        return $query->result_array();
    }
    
    
    
    
    function get_month_services($startdate, $enddate){
        //WHERE voucher_date  >= '".$startdate."' AND voucher_date <= '".$enddate."'
        $sql="SELECT  
            sum(paid_amount)  as 'Total', 
            sum(paid_amount) Paid, 
            sum(advance_amount) advance, 
            ifnull(voucher_amount,0) voucher,
            ifnull(sum(cctip),0) cctip,
            sum(paid_cash) cash, sum(paid_card) card, sum(paid_check) bank, sum(paid_voucher) voucher_pay,
            sum(paid_cash) + sum(paid_card) + sum(paid_check) + sum(paid_voucher) paymentmodetotal
            FROM invoice left join ( 
                    select sum(ifnull(amount,0)) voucher_amount, voucher_date from order_vouchers 
                    where order_vouchers.business_id = '".$this->session->userdata('businessid')."'
                    and voucher_date  >= '".$startdate."' AND voucher_date <= '".$enddate."'  group by year(voucher_date) 
            ) as vouchers on month(vouchers.voucher_date) = month(invoice.invoice_date) 
            and year(vouchers.voucher_date) = year(invoice.invoice_date) 
            WHERE invoice_date  >= '".$startdate."'
            AND invoice_date <= '".$enddate."'
            AND invoice_status = 'valid' 
            And invoice_type='service' 
            AND invoice.business_id = '".$this->session->userdata('businessid')."' ;";
                
        
                
        $query =$this->db->query($sql);
        
        return $query->result_array();
        
    }
    
    
    function get_month_sales($startdate, $enddate){
        //WHERE month(voucher_date)  >= '".$startdate."'  AND year(voucher_date) <= '".$enddate."' 
        $sql="SELECT date_format(invoice_date, '%M') as 'Month', 
                sum(paid_amount) + sum(advance_amount) + ifnull(voucher_amount,0) as 'Total', 
                sum(paid_amount) Paid, 
                sum(advance_amount) advance, 
                voucher_amount voucher,
                sum(cctip) cctip,
                sum(paid_cash) cash, sum(paid_card) card, sum(paid_check) bank,
                sum(paid_cash) + sum(paid_card) + sum(paid_check) paymentmode
                FROM invoice left join ( 
                    select sum(ifnull(amount,0)) voucher_amount, voucher_date from order_vouchers 
                    where order_vouchers.business_id = '".$this->session->userdata('businessid')."'
                    and month(voucher_date)  >= '".$startdate."'  AND year(voucher_date) <= '".$enddate."'  group by year(voucher_date) 
                ) as vouchers on month(vouchers.voucher_date) = month(invoice.invoice_date) and year(vouchers.voucher_date) = year(invoice.invoice_date) 
                WHERE invoice_date  >= '".$startdate."' 
                AND invoice_date <= '".$enddate."' 
                AND invoice_status = 'valid' 
                And invoice_type='sale' 
                AND invoice.business_id =  '".$this->session->userdata('businessid')."' ;";
                
        
                
        $query =$this->db->query($sql);
        
        return $query->result_array();
        
    }
    
    function get_month_advance($startdate, $enddate){
        
        $sql="select sum(visit_advance.advance_amount) advance from visit_advance
            join customer_visits on customer_visits.id_customer_visits = visit_advance.customer_visit_id
            where visit_advance.advance_date >= '".$startdate."' 
            and visit_advance.advance_date <= '".$enddate."' 
            and customer_visits.visit_status !='canceled'
            AND customer_visits.business_id = '".$this->session->userdata('businessid')."' ;";
                
        
                
        $query =$this->db->query($sql);
        
        return $query->result_array();
        
    }
    
    function get_purchase_order_payments($purchase_order_id){
        
         $sql = "SELECT id_account_vouchers, description, account_voucher_type, 
                avd.cost_center as cost_center_name, business_partner_name, 
                date_format(voucher_date,'%d-%m-%Y %h:%i') voucher_date, av.created_by,
                account_head_number, account_head, debit, credit, avd.payment_mode, avd.instrument_number
                FROM account_vouchers av
                join account_voucher_type avt on avt.id_account_voucher_type = av.voucher_type
                join account_voucher_detail avd on avd.account_voucher_id = av.id_account_vouchers
                join account_heads ah on ah.id_account_heads = avd.account_head_id
                where voucher_status= 'Active' ";
                
                if($purchase_order_id !== ""){
                    $sql .= " and purchase_order_id='".$purchase_order_id."' ";
                }
                
                $sql .= " and av.business_id=".$this->session->userdata('businessid');
                $sql .= " and avd.credit > 0 ";
                $sql .= " order by id_account_vouchers"; 
               
        $query=$this->db->query($sql);
        return $query->result_array();
        
    }

    public function insert_po_payment(){
         
        $data = array( 
            'business_id' => $this->session->userdata('businessid'),
            'description' => $this->input->post('description'),
            'voucher_date' => $this->input->post('account_voucher_date'),
            'voucher_amount' => $this->input->post('txtpaymentamount'),
            'voucher_status' => 'Active',
            'created_by' => $this->session->userdata('username'),
            'cost_center'=> $this->input->post('cost_center_type'),
            'cost_center_name'=> $this->input->post('cost_center'),
            'business_partner'=> 2,
            'business_partner_name'=> $this->input->post('business_partner'),
            'business_partner_id'=> $this->input->post('business_partner_id'),
            'voucher_type'=> 1,
            'purchase_order_id'=>$this->input->post('txtpurchaseorderid'),
            'payment_mode'=>$this->input->post('voucher_payment_mode')
        );
        
        $this->db->insert('account_vouchers', $data);
        $voucher_id =  $this->db->insert_id();
       
        //Debit Supplies//
         $ac_head=2;
        if($this->input->post('voucher_payment_mode')!=='Cash'){$ac_head=$this->input->post('bank_accounts');}
        $data = array(
            'account_voucher_id' => $voucher_id,
            'account_head_id' => 29,
            'debit' => $this->input->post('txtpaymentamount'),
            'credit' => 0,
            'cost_center_type'=> $this->input->post('cost_center_type'),
            'cost_center'=> $this->input->post('cost_center'),
            'instrument_number' => $this->input->post('instrument_number'),
            'payment_mode'=>$this->input->post('voucher_payment_mode')
        );
        $this->db->insert('account_voucher_detail', $data);
       
        //Credit Bank//
        $data = array(
            'account_voucher_id' => $voucher_id,
            'account_head_id' => $ac_head,
            'debit' => 0,
            'credit' => $this->input->post('txtpaymentamount'),
            'cost_center_type'=> $this->input->post('cost_center_type'),
            'cost_center'=> $this->input->post('cost_center'),
            'instrument_number' => $this->input->post('instrument_number'),
            'payment_mode'=>$this->input->post('voucher_payment_mode')
        );
        $this->db->insert('account_voucher_detail', $data);
        
        return $voucher_id;
        
    }
    
    public function insert_supplier_payable(){
         
        $data = array( 
            'business_id' => $this->session->userdata('businessid'),
            'description' => $this->input->post('description'),
            'voucher_date' => $this->input->post('account_voucher_date'),
            'voucher_amount' => $this->input->post('txtpaymentamount'),
            'voucher_status' => 'Active',
            'created_by' => $this->session->userdata('username'),
            'cost_center'=> $this->input->post('cost_center_type'),
            'cost_center_name'=> $this->input->post('cost_center'),
            'business_partner'=> 2,
            'business_partner_name'=> $this->input->post('business_partner'),
            'business_partner_id'=> $this->input-post('business_partner_id'),
            'payment_mode' => $this->input->post('voucher_payment_mode'),
            'voucher_type'=> 3
        );
        
        $this->db->insert('account_vouchers', $data);
        $voucher_id =  $this->db->insert_id();
       
        //Supplies increase Asset Debit//
        
        $data = array(
            'account_voucher_id' => $voucher_id,
            'debit' => $this->input->post('txtpaymentamount'),
            'credit' => 0,
            'cost_center'=> $this->input->post('cost_center_type'),
            'cost_center_name'=> $this->input->post('cost_center'),
            'instrument_number' => $this->input->post('instrument_number'),
            'payment_mode' => $this->input->post('voucher_payment_mode'),
            'account_head_id' => $ac_head
        );
        $this->db->insert('account_voucher_detail', $data);
       
        //Accounts Payable increase liability Credit//
        $data = array(
            'account_voucher_id' => $voucher_id,
            'account_head_id' => 11,
            'debit' => $this->input->post('txtpaymentamount'),
            'credit' => 0,
            'cost_center'=> $this->input->post('cost_center_type'),
            'cost_center_name'=> $this->input->post('cost_center'),
            'instrument_number' => $this->input->post('instrument_number')
        );
        $this->db->insert('account_voucher_detail', $data);
        
        return $voucher_id;
        
    }
    
    function cancel_voucher($voucher_id){
        
        $this->db->set('voucher_status','cancelled');
        $this->db->where('id_account_vouchers', $voucher_id);
        $this->db->update('account_vouchers');
        
        return $this->db->affected_rows();
        
    }
    
    function get_cash_info($startdate,$enddate,$t=null){
        
        $today = $startdate." 00:00";
        $tomorrow = $enddate." 23:59";

        $business_id = $this->session->userdata('businessid');
        
        //balances
        $sub_query1 = ""
                . "SELECT SUM(balance) FROM invoice "
                . "WHERE "
                . "invoice_date >= '$today' AND invoice_date <= '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        //paid amount
        $sub_query2 = ""
                . "SELECT SUM(paid_amount) FROM invoice "
                . "WHERE reference_invoice_number != '' AND "
                . "invoice_date >= '$today' AND invoice_date <= '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        //total sale payable services
        $sub_query3 = ""
                . "SELECT SUM(total_payable) FROM invoice "
                . "WHERE invoice_type = 'service'   AND reference_invoice_number = '' And "
                . "invoice_date >= '$today' AND invoice_date <= '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        //total sale payable retail
        $sub_query4 = ""
                . "SELECT SUM(total_payable) FROM invoice "
                . "WHERE invoice_type = 'sale' AND reference_invoice_number = '' AND "
                . "invoice_date >= '$today' AND invoice_date <= '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
       

        //Paid cash
        //use in accounts
        $sub_query5 = ""
                ."
                    SELECT ifnull(SUM(paid_cash),0) as 'Cash' 
                    FROM invoice WHERE payment_mode in ('Cash','Mixed') AND invoice_date >= '".$today."'
                    AND invoice_date <= '".$tomorrow."' AND business_id = ".$business_id." AND invoice_status = 'valid' 
                    ";
        
        //Card changing paid_amount to paid_card
        //use in accounts
        $sub_query6 = ""
                ."SELECT ifnull(SUM(paid_card),0) as 'Card' 
                    FROM invoice WHERE payment_mode in ('Card','Mixed') AND invoice_date >= '".$today."'
                    AND invoice_date <= '".$tomorrow."' AND business_id = ".$business_id." AND invoice_status = 'valid' 
                    ";
       
        //Check changing paid_amount to paid_check
        //use in accounts
        $sub_query7 = ""
                ."SELECT ifnull(SUM(paid_check),0) as 'Check' 
                    FROM invoice WHERE payment_mode = 'Check' AND invoice_date >= '".$today."'
                    AND invoice_date <= '".$tomorrow."' AND business_id = ".$business_id." AND invoice_status = 'valid' 
                    ";
        //advance adjusted
        $sub_query8 = ""
                . "SELECT SUM(advance_amount) FROM invoice "
                . "WHERE "
                . "invoice_date >= '$today' AND invoice_date <= '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        //Todays Sale
        $sub_query9 = ""
                . "SELECT SUM(gross_amount) FROM invoice "
                . "WHERE reference_invoice_number = ''  AND "
                . "invoice_date >= '$today' AND invoice_date <= '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        //totalVouchers changing paid_amount to paid_voucher
        
        $sub_query10 = ""
                . "SELECT SUM(paid_voucher) FROM invoice "
                . "WHERE payment_mode = 'Voucher' AND "
                . "invoice_date >= '$today' AND invoice_date <= '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        //totalAdvance from visit_advance
        //use in accounts
        $sub_query11 = ""
                . "SELECT SUM(visit_advance.advance_amount) FROM visit_advance join customer_visits on customer_visits.id_customer_visits = visit_advance.customer_visit_id "
                . "WHERE visit_status <> 'canceled' AND "
                . "visit_advance.advance_date >= '$today' AND visit_advance.advance_date <= '$tomorrow' AND "
                . "business_id = $business_id";
        
        //retained amount
        $sub_query12 = "" 
                . "SELECT SUM(retained_amount) FROM invoice "
                . "WHERE invoice_date >= '$today' AND invoice_date <= '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        //cctip amount
        $sub_query13 = "" 
                . "SELECT SUM(cctip) FROM invoice "
                . "WHERE invoice_date >= '$today' AND invoice_date <= '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        //cctip amount
        $sub_query14 = "" 
                . "SELECT SUM(cc_charge) FROM invoice "
                . "WHERE invoice_date >= '$today' AND invoice_date <= '$tomorrow' AND "
                . "business_id = $business_id AND invoice_status = 'valid'";
        
        $this->db->select("SUM(paid_amount) AS totalPaid, "
                . "($sub_query5) AS Cash, "
                . "($sub_query6) AS Card, "
                . "($sub_query7) AS Checks, "
                . "($sub_query11) AS Advance "
                . "");
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_date >=', $today);
        $this->db->where('invoice_date <=', $tomorrow);
        $this->db->where('invoice_status', 'valid');
        $this->db->where('payment_mode', 'Cash');
        
        $query = $this->db->get('invoice');
       
       
        return $query->row();
        
    }
    
    function get_cash_voucher($startdate,$enddate,$t = null){

        $business_id = $this->session->userdata('businessid');
        $today = $startdate;
        $tomorrow = $enddate;
        
        
        $sub_query1 = ""
                . "SELECT ifnull(SUM(amount),0) FROM order_vouchers "
                . "WHERE payment_mode = 'Cash'  AND "
                . "date_format(voucher_date, '%Y-%m-%d') >= '$today' AND "
                . "date_format(voucher_date, '%Y-%m-%d') <= '$tomorrow' AND "
                . "business_id = $business_id";
        
        $sub_query2 = ""
                . "SELECT ifnull(SUM(amount),0) FROM order_vouchers "
                . "WHERE payment_mode = 'Card' AND "
                . "date_format(voucher_date, '%Y-%m-%d') >= '$today' AND "
                . "date_format(voucher_date, '%Y-%m-%d') <= '$tomorrow' AND "
                . "business_id = $business_id";
        
        $sub_query3 = ""
                . "SELECT ifnull(SUM(amount),0) FROM order_vouchers "
                . "WHERE payment_mode = 'Check' AND "
                . "date_format(voucher_date, '%Y-%m-%d') >= '$today' AND "
                . "date_format(voucher_date, '%Y-%m-%d') <= '$tomorrow' AND "
                . "business_id = $business_id";
        
        
        $this->db->select("ifnull(SUM(amount),0) AS totalVoucherAmount, "
                . "($sub_query1) AS Cash, "
                . "($sub_query2) AS Card, "
                . "($sub_query3) AS Checks "
                . "", False);
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('date_format(voucher_date,"%Y-%m-%d") >=', $today);
        $this->db->where('date_format(voucher_date,"%Y-%m-%d") <=', $tomorrow);
        $query = $this->db->get('order_vouchers');
       // echo $query; exit();
        return $query->row();
        
    }
    
}


