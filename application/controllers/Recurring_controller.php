<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Recurring_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        
        $this->load->model('business_model');
        $this->load->model('programs_model');
        $this->load->model('customer_model');
        if ($this->session->userdata('role') === 'Reception' || $this->session->userdata('role') === 'Admin' || $this->session->userdata('role') === 'Super User' || $this->session->userdata('role') === 'Accountant'|| $this->session->userdata('role') === 'Trainer') {
        
            
        } else {
            redirect('logout');
        }
    }

    public function recurringsearch() {

        //storemanager,hr,reception...user serial
        checkroles(0, 0, 0);

        $data['nav'] = 'Programs';
        $data['subnav'] = 'RecurringRegister';

        $data['scheduler_style'] = $this->business_model->getbusinessdetails();
        
        $data['program_type'] = 'recurringregister';
        $data['program'] = 'Recurring Payments';
        
        $this->load->view('includes/header', $data);
        $this->load->view('programs/select_customer_view');
        $this->load->view('includes/footer');
    }
    
    public function recurringregister($customer_id) {

        
        if($customer_id > 1){
            $data['customer'] = $this->customer_model->get_byid($customer_id);
        } 
        //storemanager,hr,reception...user serial
        checkroles(0, 0, 0);

        $data['nav'] = 'Programs';
        $data['subnav'] = 'RecurringRegister';

        $data['scheduler_style'] = $this->business_model->getbusinessdetails();
        $data['programs'] = $this->programs_model->get_active_programs(3);
        
        $this->load->view('includes/header', $data);
        $this->load->view('programs/recurring_register_view');
        $this->load->view('includes/footer');
            
    }
    
    public function enroll_customer(){
        
  
        $customerid = $this->input->post('txtcustomerid');
        $customername= $this->input->post('txtcustomername');
        $customercell=$this->input->post('txtcustomercell');
        $customerphone1=$this->input->post('txtcustomerphone1');
        $customerphone2=$this->input->post('txtcustomerphone2');
        $customergender=$this->input->post('txtcustomergender');
        $customertype=$this->input->post('txtcustomertype');
        $customercard=$this->input->post('txtcustomercard');
        $customerprofession=$this->input->post('txtcustomerprofession');
        $customeremail=$this->input->post('txtcustomeremail');
        $customeraddress=$this->input->post('txtcustomeraddress');
        $customeranniversay=$this->input->post('txtcustomeranniversary');
        $customerbirthday=$this->input->post('txtcustomerbirthday');
        $customerbirthmonth=$this->input->post('txtcustomerbirthmonth');
        $customerallergies=$this->input->post('txtcustomerallergies');
        $customeralert=$this->input->post('txtcustomeralert');
        
        
        $noofbranches=$this->input->post('txtbranches');
        $agreeddiscount=$this->input->post('txtagreeddiscount');
        
        $programid=$this->input->post('txtprograms');
        $programsessionid=$this->input->post('txtprogramsessions');
        $startdate=$this->input->post('txtstartdate');
        
        //////Work with customer first///////////
        $data = array(
                'customer_name' => $customername,
                'customer_email' => $customeremail,
                'customer_cell' => $customercell,
                'customer_address' => $customeraddress,
                'customer_phone1' => $customerphone1,
                'customer_phone2' => $customerphone2,
                'customer_birthday' => $customerbirthday,
                'customer_birthmonth' => $customerbirthmonth,
                'customer_anniversary' => $customeranniversay,
                'customer_allergies' => $customerallergies,
                'customer_alert' => $customeralert,
                'customer_type' => $customertype,
                'profession' => $customerprofession,
                'customer_gender' => $customergender,
                'customer_card' => $customercard

            );
        
        if($customerid>1){ //Update the existing customer
            
            $this->db->where('id_customers', $customerid);
            $this->db->update('customers', $data);
            
            
        } else { //Insert new customer & get new customer id
            
            $this->db->insert('customers', $data);
            $customerid = $this->db->insert_id();            
            
        }

        //////////Now Enroll Customer in Program////////////////
        
        if ($customerid<=1){
            // Set flash data 
            $this->session->set_flashdata('Error', 'Could Not Insert New Customer! Check your input please.');
            redirect('recurringregister/'.$customerid);
        } else {
            
            
            $data = array(
                'program_session_id' => $programsessionid,
                'start_date' => $startdate,
                'customer_id' => $customerid,
                'noofbranches' => $noofbranches,
                'agreeddiscount' => $agreeddiscount                    
            );
            
            $this->db->insert('program_enrollment', $data);
            $enrollmentid = $this->db->insert_id();     
        }
        
        redirect('print_enrollment/'.$enrollmentid);

    }
    
    
    
}
