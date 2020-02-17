<?php

class Staff_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_present_staff() {
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d H:i:s', strtotime('tomorrow'));

        $this->db->select("*, DATE_FORMAT(time_in,'%h:%i %p') as 'timein'");
        $this->db->join('staff', 'staff.id_staff = staff_attendance.staff_id');
        $this->db->where('staff.staff_active =', 'Y');
        $this->db->where("ifnull(staff_attendance.time_out,'')=''");
        $this->db->where('staff_attendance.time_in >', $today);
        $this->db->where('staff_attendance.time_in <', $tomorrow);
        $this->db->where('staff_attendance.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('staff_attendance');

        return $query->result_array();
    }

    function get_available_staff() {
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d H:i:s', strtotime('tomorrow'));

        $this->db->select("*, DATE_FORMAT(time_in,'%h:%i %p') as 'timein'");
        $this->db->join('staff', 'staff.id_staff = staff_attendance.staff_id');
        $this->db->where("ifnull(staff_attendance.time_out,'')=''");
        $this->db->where('staff_attendance.time_in >', $today);
        $this->db->where('staff_attendance.time_in <', $tomorrow);
        $this->db->where('staff_attendance.business_id', $this->session->userdata('businessid'));
        $this->db->where('staff_attendance.staff_available', '');
        $query = $this->db->get('staff_attendance');

        return $query->result_array();
    }

    function get_absent_staff() {

        $today = date('Y-m-d');
        $ids = [];
        $this->db->select('staff_id');
        $this->db->where('time_in >', $today);
        $this->db->where("ifnull(time_out,'')=''");
        $this->db->where('staff_attendance.business_id', $this->session->userdata('businessid'));
        $query1 = $this->db->get('staff_attendance');

        foreach ($query1->result() as $row) {
            array_push($ids, $row->staff_id);
        }

        $this->db->select('*');
        if (sizeof($ids) > 0) {
            $this->db->where_not_in("id_staff", $ids);
            $this->db->where('staff.staff_active =', 'Y');
        }
        $query = $this->db->get('staff');

        return $query->result_array();
    }

    function check_staff_status() {

        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d H:i:s', strtotime('tomorrow'));
        $statff_id = $this->input->post('id', TRUE);

        $this->db->select("time_out");
       // $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('staff_id', $statff_id);
        $this->db->where('time_in >', $today);
        $this->db->where('time_in <', $tomorrow);
        $this->db->where('staff_available', '');

        $query = $this->db->get('staff_attendance');
        return $query->row();
    }

    function update_timein() {

        $mySQLDate = date('Y-m-d H:i:s');
        $mySQLTime = date('H:i:s');
        
        $data = array(
            'business_id' => $this->session->userdata('businessid'),
            'staff_id' => $this->input->post('id', TRUE),
            'time_in' => $mySQLDate
        );

        $this->db->insert('staff_attendance', $data);
        return $mySQLTime;
    }

    function update_timeout() {
        $today = date('Y-m-d');
        $mySQLDate = date('Y-m-d H:i:s');
        $mySQLTime = date('H:i:s');
        
        $data = array(
            'time_out' => $mySQLDate
        );

        $this->db->set($data);
        $this->db->where('date_format(staff_attendance.time_in, "%Y-%m-%d") =', $today);
        $this->db->where('staff_id', $this->input->post('id', TRUE));
        $this->db->where("ifnull(time_out,'')=''");
      //  $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->update('staff_attendance');
        
        return $mySQLTime;
        
    }

    function all_staff() {
        
        $this->db->select("*");
        $this->db->where("staff.business_id", $this->session->userdata('businessid'));
        $this->db->order_by('staff_order', 'Asc');
        $query = $this->db->get('staff');
        return $query->result_array();
    }

    function all_staff_list(){
        $where = "(staff.business_id=". $this->session->userdata('businessid') ." OR staff.staff_shared = 'Yes') ";
        $this->db->select("*");
        $this->db->where($where);
        $this->db->order_by('staff_active, staff_fullname', 'Asc');
        $query = $this->db->get('staff');
        return $query->result_array();
    }
    
    function add_staff() {
        $data = array(
            'business_id' => $this->session->userdata('businessid'),
            'staff_firstname' => $this->input->post('staff_firstname', TRUE),
            'staff_lastname' => $this->input->post('staff_lastname', TRUE),
            'staff_fullname' => $this->input->post('staff_fullname', TRUE),
            'staff_cell' => $this->input->post('staff_cell', TRUE),
            'staff_phone1' => $this->input->post('staff_phone1', TRUE),
            'staff_phone2' => $this->input->post('staff_phone2', TRUE),
            'staff_address' => $this->input->post('staff_address', TRUE),
            'staff_eid' => $this->input->post('staff_eid', TRUE),
            'staff_email' => $this->input->post('staff_email', TRUE),
            'staff_salary' => $this->input->post('staff_salary', TRUE)
        );
        // print_r($data);die;
        $this->db->insert('staff', $data);
        return $this->db->insert_id();
    }

    function update_staff() {
        $data = array(
            'business_id' => $this->session->userdata('businessid'),
            'staff_firstname' => $this->input->post('staff_firstname', TRUE),
            'staff_lastname' => $this->input->post('staff_lastname', TRUE),
            'staff_fullname' => $this->input->post('staff_fullname', TRUE),
            'staff_cell' => $this->input->post('staff_cell', TRUE),
            'staff_phone1' => $this->input->post('staff_phone1', TRUE),
            'staff_phone2' => $this->input->post('staff_phone2', TRUE),
            'staff_address' => $this->input->post('staff_address', TRUE),
            'staff_eid' => $this->input->post('staff_eid', TRUE),
            'staff_email' => $this->input->post('staff_email', TRUE),
            'staff_salary' => $this->input->post('staff_salary', TRUE)
        );
        //print_r($data);die;
        $this->db->set($data);
        $this->db->where('id_staff', $this->input->post('id_staff', TRUE));
        $this->db->update('staff');
        return $this->input->post('id_staff', TRUE);
    }

    function update_staff_scheduler() {
                
        $data = array(
            'staff_scheduler' => $this->input->post('staff_scheduler', TRUE)
        );
        
        $this->db->set($data);
        $this->db->where('id_staff', $this->input->post('id_staff', TRUE));
        $this->db->update('staff');
        return $this->input->post('id_staff', TRUE);
    }
    
    function staff_status() {
        $data = array(
            'staff_active' => $this->input->post('staffactive', TRUE),
            'staff_comment' => $this->input->post('staff_comment', TRUE)
        );
        $this->db->set($data);
        $this->db->where('id_staff', $this->input->post('id_staff_status', TRUE));
        $this->db->update('staff');
        return $this->input->post('id_staff_status', TRUE);
    }

    function image_staff($image = NULL) {
        $data = array(
            'staff_image' => $image ? $image : NULL
        );
        //print_r($data);die;
        $this->db->set($data);
        $this->db->where('id_staff', $this->input->post('id_image_staff', TRUE));
        $this->db->update('staff');
        return $this->input->post('id_image_staff', TRUE);
    }

    function update_order_function($id, $orderid) {

        $data = array(
            'staff_order' => $orderid
        );
        $this->db->where('staff.id_staff', $id);
        $this->db->where('staff.business_id', $this->session->userdata('businessid'));
        $this->db->update('staff', $data);
        return $id;
    }

    function changelistorder1() {
        $staff_orderid = $this->input->post('staff_order', TRUE);
        $staff_orderid = explode(',', $staff_orderid);
        $count = 1;
        print_r($staff_orderid);
        die;
        $data = array();
        for ($i = 0; $i <= sizeof($staff_orderid); $i++) {

            $data[] = array(
                'staff_order' => $count,
                'staff_id' => $staff_orderid[$i]
            );

//            $this->db->where('staff.id_staff', $staff_orderid[$i]);
//            $this->db->where('staff.business_id', $this->session->userdata('businessid'));
//            $this->db->update('staff', $data);
            $count++;
        }
        print_r($data);
        die;

        return TRUE;
    }

    function changelistorder() {
        $staff_orderid = $this->input->post('staff_order', TRUE);
        $staff_orderid = explode(',', $staff_orderid);
        
        $updateArray = array();

        for ($x = 0; $x < sizeof($staff_orderid); $x++) {

            $updateArray[] = array(
                'id_staff' => $staff_orderid[$x],
                'staff_order' => $x+1
            );
        }
        $this->db->update_batch('staff', $updateArray, 'id_staff');
        return TRUE;
    }
    
    function edit_staff(){
        $this->db->select('*');
        $this->db->where('s.business_id', $this->session->userdata('businessid'));
        $this->db->where('s.id_staff', $this->input->post('id_staff'));
        $query = $this->db->get('staff s');

        return $query->row();
    }
    
    function get_active_staff(){
        $where="(s.business_id =". $this->session->userdata('businessid')." OR s.staff_shared='Yes')";
        
        $this->db->select('*');
        $this->db->where($where);
        $this->db->where('s.staff_active', 'Y');
        $this->db->order_by('staff_fullname');
        $query = $this->db->get('staff s');

        return $query->result_array();
        
    }
    
    function calculate_commissions($month){
        
        $this->db->select("staff_fullname staff_name, staff_id, date_format(staff_service_date, '%M') as 'Month', 
                    date_format(staff_service_date, '%Y') as 'Year', sum(staff_commission) as 'Commission', 
                    count(service_name) as 'Total Services'");
        $this->db->join("invoice", " invoice.id_invoice = staff_services.invoice_id");
        $this->db->join("staff", "staff.id_staff = staff_services.staff_id");
        $this->db->where("invoice_status='valid'");
        $this->db->where('reference_invoice_number <>', 'bad debts');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('month(staff_service_date)=', $month);
        $this->db->where('ifnull(staff_name,"") <>', '');
        $this->db->group_by("staff_fullname, staff_id,
            date_format(staff_service_date, '%M'),
            date_format(staff_service_date, '%Y') ");
        $query = $this->db->get('staff_services');

        return $query->result_array();
    }
    
    public function check_salary_record($staff_id, $month, $year){
        
        $this->db->select("*");
        $this->db->where("staff_id", $staff_id);
        $this->db->where("payment_month", $month);
        $this->db->where("payment_year", $year);
        $this->db->where("payment_type", "Salary");
        $query = $this->db->get("staff_payments");
        
        return $query->result_array();
    }
    public function check_commission_record($staff_id, $month, $year){
        
        $this->db->select("*");
            $this->db->where("staff_id", $staff_id);
            $this->db->where("payment_month", $month);
            $this->db->where("payment_year", $year);
            $this->db->where("payment_type", "Commission");
            $query = $this->db->get("staff_payments");
             return $query->result_array();
    }


    public function update_salaries($data){
                
        $this->db->insert('staff_payments', $data);
        return $this->db->insert_id();
    }
    
   
    
    public function add_payment(){
        
        $data = array(
            'created_by' => $this->session->userdata('businessid'),
            'staff_id' => $this->input->post('staff_id'),
            'staff_name' => $this->input->post('staff_name'),
            'payment_amount' => $this->input->post('payment_amount'),
            'payment_type' => $this->input->post('payment_type'),
            'payment_mode' =>  $this->input->post('payment_mode'),
            'payment_remarks' => $this->input->post('payment_remarks'),
            'payment_date' => $this->input->post('payment_date'),
            'payment_month' => $this->input->post('payment_month'),
            'payment_year' => $this->input->post('payment_year'),
            'bank_account_id'=> $this->input->post('bank_account_id'),
            'deduction_amount'=>$this->input->post('deduction_amount')
        );

        $this->db->insert('staff_payments', $data);
        return $this->db->insert_id();
        
    }
    
    public function staff_salary($staffid){
        
//        $sql="SELECT *, date_format(payment_date, '%d-%m-%Y') as 'payment_date'
//            FROM staff_payments 
//            WHERE staff_id = '".$staffid."' 
//            AND (payment_type = 'Salary' OR `payment_type` like '%Deduction%')
//            ORDER BY payment_date";
        
        $sql="select av.id_account_vouchers id, date_format(voucher_date, '%d-%m-%Y') as 'payment_date', date_format(voucher_date,'%M') payment_month, 
            year(voucher_date) 'payment_year',
            av.payment_mode, '' as 'deduction_amount',
            avd.debit as payment_amount, av.description as 'payment_remarks'
            from account_vouchers av
            join account_voucher_detail avd on av.id_account_vouchers = avd.account_voucher_id
            where av.business_partner_id=".$staffid ." 
            and avd.account_head_id=32    
            group by av.id_account_vouchers order by voucher_date desc";
        
        $query=$this->db->query($sql);
        
        return $query->result_array();
        
        
    }
    
    public function staff_commission($staffid){
        
//        $this->db->select("*, date_format(payment_date,'%d-%m-%Y') as 'payment_date'");
//        $this->db->where("staff_id =",$staffid);
//        $this->db->where("payment_type =","Commission");
//        $this->db->order_by("payment_date");
//        $query = $this->db->get("staff_payments");
        
        $sql="select av.id_account_vouchers id, date_format(voucher_date, '%d-%m-%Y') as 'payment_date', date_format(voucher_date,'%M') payment_month, 
            year(voucher_date) 'payment_year',
            av.payment_mode, '' as 'deduction_amount',
            avd.debit as payment_amount, av.description as 'payment_remarks'
            from account_vouchers av
            join account_voucher_detail avd on av.id_account_vouchers = avd.account_voucher_id
            where av.business_partner_id=".$staffid ." 
            and avd.account_head_id=4    
            group by av.id_account_vouchers order by voucher_date desc";
        
        $query=$this->db->query($sql);
        
        return $query->result_array();
        
    }
    
    public function staff_otherpayments($staffid){
        
        $payment_types = array('Salary', 'Commission', 'Loan');
        
        $this->db->select("*, date_format(payment_date,'%d-%m-%Y') as 'payment_date'");
        $this->db->where("staff_id =",$staffid);
        $this->db->where_not_in("payment_type", $payment_types);
        //$this->db->where("payment_mode =","Addition");
        $this->db->order_by("payment_date");
        $query = $this->db->get("staff_payments");
        
        return $query->result_array();
        
    }
    
    public function staff_loan($staffid){
        
         $sql="select av.id_account_vouchers id, date_format(voucher_date, '%d-%m-%Y') as 'payment_date', date_format(voucher_date,'%M') payment_month, 
            year(voucher_date) 'payment_year',
            av.payment_mode, '' as 'deduction_amount',
            avd.debit as payment_amount, av.description as 'payment_remarks'
            from account_vouchers av
            join account_voucher_detail avd on av.id_account_vouchers = avd.account_voucher_id
            where av.business_partner_id=".$staffid ." 
            and avd.account_head_id=4    
            group by av.id_account_vouchers order by voucher_date desc";
        
        $query=$this->db->query($sql);
        
        return $query->result_array();
        
    }

    public function staff_loantaken($staffid){
        
        $this->db->select("ifnull(sum(payment_amount),0) as 'amount'");
        $this->db->where("staff_id =",$staffid);
        $this->db->where("payment_type =","Loan");
        $this->db->where("payment_amount >",0);
        $this->db->order_by("payment_date");
        $query = $this->db->get("staff_payments");
        
        return $query->result_array();
        
    }
    
    public function staff_loanreturned($staffid){
        
        $this->db->select("ifnull(sum(payment_amount),0) as 'amount'");
        $this->db->where("staff_id =",$staffid);
        $this->db->where("payment_type =","Loan");
        $this->db->where("payment_amount <",0);
        $this->db->order_by("payment_date");
        $query = $this->db->get("staff_payments");
        
        return $query->result_array();
        
    }
    
    public function staff_loanpending($staffid){
        
        $this->db->select("ifnull(sum(payment_amount),0) as 'amount'");
        $this->db->where("staff_id =",$staffid);
        $this->db->where("payment_type =","Loan");
        $this->db->order_by("payment_date");
        $query = $this->db->get("staff_payments");
        
        return $query->result_array();
        
    }
    
    
    function staff_details( $staff_id){
        $this->db->select('*');
        $this->db->where('s.business_id', $this->session->userdata('businessid'));
        $this->db->where('s.id_staff', $staff_id);
        $query = $this->db->get('staff s');

        return $query->result_array();
    }
    
    
    function searchpayments($staffid, $month, $year){
        
//        $this->db->select("*, date_format(payment_date, '%d-%m-%Y') as payment_date");
//        $this->db->where("payment_month =", $this->input->post('payment_month'));
//        $this->db->where("payment_year =", $this->input->post('payment_year'));
//        $this->db->where("staff_id", $this->input->post('staff_id'));
//        $query = $this->db->get("staff_payments");
        
        $sql="select date_format(voucher_date, '%d-%m-%Y') as 'payment_date', date_format(voucher_date,'%M') payment_month, 
            year(voucher_date) 'payment_year',
            av.payment_mode, '' as 'deduction_amount',
            avd.debit as payment_amount, av.description as 'payment_remarks', business_partner_name as staff_name,
            s.staff_eid staff_number
            from account_vouchers av
            join account_voucher_detail avd on av.id_account_vouchers = avd.account_voucher_id
            join staff s on av.business_partner_id = s.id_staff
            where av.business_partner_id=".$staffid ." 
            and avd.account_head_id in(4,32)
            and month(voucher_date)='".$month."'
            and year(voucher_date)='".$year."'
            group by av.id_account_vouchers order by voucher_date desc";
        
        
       $query=$this->db->query($sql);
        
        return $query->result_array();
        
    }
    
    public function day_attendance(){
        $today=date('Y-m-d');
        $sql="SELECT staff_image, id_staff, staff_fullname, staff_cell, date_format(time_in,'%H:%i:%s') time_in, date_format(time_out,'%H:%i:%s') time_out
            FROM staff
            left join staff_attendance on staff_attendance.staff_id= staff.id_staff 
            and date_format(time_in,'%Y-%m-%d')='".$today."'
            where staff.staff_active='Y'
            and staff.business_id=".$this->session->userdata('businessid')."
            order by staff_order";
        
        $query=$this->db->query($sql);
        return $query->result_array();
        
    }
    
    public function get_scheduler_staff(){
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('staff_scheduler', 'On');
        $this->db->order_by('staff_fullname', 'ASC');
        $query = $this->db->get('staff');

        return $query->result();
    }
    
    public function get_staff_payment_types(){
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('payment_type_active', 'Yes');
        $query = $this->db->get('staff_payment_types');
        return $query->result_array();
    }

    function searchnameforstaff($match) {
        $this->db->select('*, staff_fullname as id');
        $this->db->like('staff_fullname', $match);
        $query = $this->db->get("staff");

        return $query->result_array();
    }    
    
    function get_staff_payments($payment_type, $startdate, $enddate){
              
        $sql="SELECT month(payment_date), ifnull(sum(payment_amount),0) 'total' FROM 
            staff_payments
            where payment_date >= '".$startdate."' 
            and payment_date <= '".$enddate."' ";
        if($payment_type==='Other'){
            $sql.= "and payment_type not in ('Commission','Salary') ";
        }else {
            $sql.= "and payment_type='".$payment_type."' ";
        }
        //$sql .= " group by month(payment_date);";
        
        $query =$this->db->query($sql);
        
        return $query->result_array();
        
        
    }

}
