<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gym_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        
        $this->load->model('business_model');
        $this->load->model('programs_model');
        $this->load->model('customer_model');
        if ($this->session->userdata('role') === 'Reception' || $this->session->userdata('role') === 'Admin' || $this->session->userdata('role') === 'Super User' || $this->session->userdata('role') === 'Accountant' || $this->session->userdata('role') === 'Trainer') {
        
            
        } else {
            redirect('logout');
        }
    }

    public function gymsearch() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'Programs';
            $data['subnav'] = 'GymRegister';

            $data['scheduler_style'] = $this->business_model->getbusinessdetails();
            $data['program_type'] = 'gymregister';
            $data['program'] = 'Gym';

            $this->load->view('includes/header', $data);
            $this->load->view('programs/select_customer_view');
            $this->load->view('includes/footer');
        }
    }
    
    public function gymregister($customer_id) {

        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            if($customer_id > 1){
                $data['customer'] = $this->customer_model->get_byid($customer_id);
            } 
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'Programs';
            $data['subnav'] = 'GymRegister';

            $data['scheduler_style'] = $this->business_model->getbusinessdetails();
            $data['programs'] = $this->programs_model->get_active_programs(1);

            $this->load->view('includes/header', $data);
            $this->load->view('programs/gym_register_view');
            $this->load->view('includes/footer');
        }
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
        $emergencyperson=$this->input->post('txtemergencyperson');
        $emergencynumber=$this->input->post('txtemergencynumber');
        $age=$this->input->post('txtage');
        $height=$this->input->post('txtheight');
        $bmi=$this->input->post('txtbmi');
        
        $weight=$this->input->post('txtweight');
        $arms=$this->input->post('txtarms');
        $thighs=$this->input->post('txtthighs');
        $hips=$this->input->post('txthips');
        $chest=$this->input->post('txtchest');
        $waist=$this->input->post('txtwaist');
        $weightgoal=$this->input->post('txtweightgoal');
        $armsgoal=$this->input->post('txtarmsgoal');
        $thighsgoal=$this->input->post('txtthighsgoal');
        $hipsgoal=$this->input->post('txthipsgoal');
        $chestgoal=$this->input->post('txtchestgoal');
        $waistgoal=$this->input->post('txtwaistgoal');
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
                'customer_card' => $customercard,
                'emergency_contact_person' => $emergencyperson,
                'emergency_contact_number' => $emergencynumber,
                'age' => $age,
                'height' => $height,
                'bmi' => $bmi
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
            $this->gymregister($customerid);
        } else {
            
            
            $data = array(
                'program_session_id' => $programsessionid,
                'start_date' => $startdate,
                'customer_id' => $customerid,
                'current_weight' => $weight,
                'current_arms' => $arms,
                'current_thighs' => $thighs,
                'current_hips' => $hips,
                'current_chest' => $chest,
                'current_waist' => $waist,
                'weight_goal' => $weightgoal,
                'arms_goal' => $armsgoal,
                'thighs_goal' => $thighsgoal,
                'hips_goal' => $hipsgoal,
                'chest_goal' => $chestgoal,
                'waist_goal' => $waistgoal
                    
            );
            $this->db->insert('program_enrollment', $data);
            $enrollmentid = $this->db->insert_id();     
        }
        redirect('print_enrollment/'.$enrollmentid);
    }
    
    
    
}
