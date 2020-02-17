<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Programs_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        
        $this->load->model('business_model');
        $this->load->model('programs_model');
        $this->load->model('customer_model');
        $this->load->model('staff_model');
        if ($this->session->userdata('role') === 'Reception' || $this->session->userdata('role') === 'Admin' || $this->session->userdata('role') === 'Super User' || $this->session->userdata('role') === 'Accountant' || $this->session->userdata('role') === 'Trainer') {
        
            
        } else {
            redirect('logout');
        }
    }

    
    public function programs($program_type){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
        
            //storemanager,hr,reception...user serial
           checkroles(0, 0, 0);

           $data['nav'] = 'Programs';
           $data['subnav'] = 'TrainingPrograms';

           $data['business'] = $this->business_model->getbusinessdetails();
           $data['program_type']= $this->programs_model->get_program_type($program_type);
           $data['programs']= $this->programs_model->get_programs_by_type($program_type);

           $this->load->view('includes/header', $data);
           $this->load->view('programs/programs');
           $this->load->view('includes/footer');
        }
        
    }
    
    public function programadd($program_type){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'Programs';
            $data['subnav'] = 'TrainingPrograms';

            $data['business'] = $this->business_model->getbusinessdetails();
            $data['program_type']= $this->programs_model->get_program_type($program_type);


            $this->load->view('includes/header', $data);
            $this->load->view('programs/program_add');
            $this->load->view('includes/footer');
        }
        
    }
    
    public function insert_program(){
        
        $result = $this->programs_model->insert_program();
            
        if($result>0){
            $this->session->set_flashdata('Success', 'Program Added!');
        } else {
            $this->session->set_flashdata('Error', 'Something went wrong!');
        }
        
       redirect('programs/'.$this->input->post('program_type_id'));
        
    }
    
    
    public function programedit($programid){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'Programs';
            $data['subnav'] = 'TrainingPrograms';

            $data['business'] = $this->business_model->getbusinessdetails();
            $data['program']= $this->programs_model->get_program_by_id($programid);
            $data['program_types']= $this->programs_model->get_program_types(); 

            $this->load->view('includes/header', $data);
            $this->load->view('programs/program_edit');
            $this->load->view('includes/footer');
        }
        
    }
    
    public function update_program(){
        
        $result = $this->programs_model->update_program();
            
        if($result>0){
            $this->session->set_flashdata('Success', 'Program Updated!');
        } else {
            $this->session->set_flashdata('Error', 'Something went wrong!');
        }
        
       redirect('programedit/'.$this->input->post('id_programs'));
        
    }

    public function programsession($programid){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'Programs';
            $data['subnav'] = 'TrainingPrograms';

            $data['business'] = $this->business_model->getbusinessdetails();
            $data['programsessions']= $this->programs_model->get_program_sessions($programid);


            $this->load->view('includes/header', $data);
            $this->load->view('programs/program_sessions');
            $this->load->view('includes/footer');
        }
        
    }
    
     public function programsessionadd($programid){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'Programs';
            $data['subnav'] = 'TrainingPrograms';

            $data['business'] = $this->business_model->getbusinessdetails();
            $data['program']= $this->programs_model->get_program_by_id($programid);

            $this->load->view('includes/header', $data);
            $this->load->view('programs/program_session_add');
            $this->load->view('includes/footer');
        }
    }
    
    public function insert_program_session(){
        
        $result = $this->programs_model->insert_program_session();
            
        if($result>0){
            $this->session->set_flashdata('Success', 'Program Session Added!');
        } else {
            $this->session->set_flashdata('Error', 'Something went wrong!');
        }
        
       redirect('programsession/'.$this->input->post('program_id'));
        
    }
    
    public function programsessionedit($programsessionid){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'Programs';
            $data['subnav'] = 'TrainingPrograms';

            $data['business'] = $this->business_model->getbusinessdetails();
            $data['program']= $this->programs_model->get_program_session_id($programsessionid);

            $this->load->view('includes/header', $data);
            $this->load->view('programs/program_session_edit');
            $this->load->view('includes/footer');
        }
        
    }
    
    public function update_program_session(){
        
        $result = $this->programs_model->update_program_session();
            
        if($result>0){
            $this->session->set_flashdata('Success', 'Program Updated!');
        } else {
            $this->session->set_flashdata('Error', 'Something went wrong!');
        }
        
       redirect('programsessionedit/'.$this->input->post('id_program_sessions'));
        
    }
    
    public function get_active_programs() {

        
        if(null == $this->input->post('programtypeid')){
            $programtypeid=0;
        } else {
            $programtypeid=$this->input->post('programtypeid');
        }
        
        $data = $this->programs_model->get_active_programs($programtypeid);
        echo(json_encode($data));
    }
    
    public function get_active_sessions() {
       
        $data = $this->programs_model->get_active_sessions($this->input->post('programid'));
        echo(json_encode($data));
        
    }
    
    public function print_enrollment($enrollment_id){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $data['nav'] = 'Programs';
            $data['subnav'] = 'ProgramMembers';

            $data['business'] = $this->business_model->getbusinessdetails();
            $data['program_enrollment'] = $this->programs_model->get_enrollment_payments($enrollment_id);
            $data['program_schedule']= $this->programs_model->get_program_session_classes($data['program_enrollment'][0]['id_program_sessions']);

            $this->load->view('includes/header', $data);
            $this->load->view('programs/print_enrollment_view');
            $this->load->view('includes/footer');
        }
        
    }
    
    public function print_invoice($enrollment_id){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $data['nav'] = 'Programs';
            $data['subnav'] = 'ProgramMembers';

            $data['business'] = $this->business_model->getbusinessdetails();
            $data['program_enrollment'] = $this->programs_model->get_enrollment_payments($enrollment_id);
            $data['program_schedule']= $this->programs_model->get_program_session_classes($data['program_enrollment'][0]['id_program_sessions']);

            $this->load->view('includes/header', $data);
            $this->load->view('programs/print_invoice_view');
            $this->load->view('includes/footer');
        }
        
    }
    
    
    public function print_due_invoice($enrollment_id){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $data['nav'] = 'Programs';
            $data['subnav'] = 'ProgramMembers';

            $data['business'] = $this->business_model->getbusinessdetails();
            $data['program_enrollment'] = $this->programs_model->get_enrollment_payments($enrollment_id);
            $data['program_schedule']= $this->programs_model->get_program_session_classes($data['program_enrollment'][0]['id_program_sessions']);

            $this->load->view('includes/header', $data);
            $this->load->view('programs/print_due_invoice');
            $this->load->view('includes/footer');
        }
    }
    
    public function add_payment(){
        $payment=$this->input->post('txtTotalPayment');
        $enrollment_id=$this->input->post('txtenrollmentid');
        
        //echo $enrollment_id.' '.$payment; exit();
        $payment_id = $this->programs_model->addpayment();
        
        
        if($payment_id >=1){
            $this->session->set_flashdata('Success', 'Payment Added!');
        } else {
            $this->session->set_flashdata('Error', 'Could Not Insert New Payment! Check your input please.');
        }
        
        redirect('print_program_invoice/'.$enrollment_id);
        
    }
   
    
    public function program_members($program_type=null){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            if($program_type==null){$this->input->post('programtypes');}

            $data['nav'] = 'Programs';
            $data['subnav'] = 'ProgramMembers';

            $data['business'] = $this->business_model->getbusinessdetails();

            if(null !== $this->input->post('programtypes')){$program_type=$this->input->post('programtypes');}
            if(null !== $this->input->post('activeprograms')){$data['selected_program']=$this->input->post('activeprograms');}
            if(null !==$this->input->post('activeprogramsessions')){$data['selected_session']=$this->input->post('activeprogramsessions');}

            $data['program_types'] = $this->programs_model->get_program_types();
            $data['program_type']=$program_type;
            $data['program_members'] = $this->programs_model->get_program_members($program_type);

            $this->load->view('includes/header', $data);
            $this->load->view('programs/program_members_view');
            $this->load->view('includes/footer');       
        }
        
    }
    
    public function programsessionclasses($programsessionid){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'Programs';
            $data['subnav'] = 'TrainingPrograms';

            $data['business'] = $this->business_model->getbusinessdetails();
            $data['programsession']= $this->programs_model->get_program_session_id($programsessionid);
            $data['programsessionclasses']= $this->programs_model->get_program_session_classes($programsessionid);


            $this->load->view('includes/header', $data);
            $this->load->view('programs/program_session_classes');
            $this->load->view('includes/footer');
        }
        
    }
    
    public function programsessionclassadd($programsessionid){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
           checkroles(0, 0, 0);

           $data['nav'] = 'Programs';
           $data['subnav'] = 'TrainingPrograms';

           $data['business'] = $this->business_model->getbusinessdetails();
           $data['instructors'] = $this->staff_model->get_active_staff();
           $data['programsession']= $this->programs_model->get_program_session_id($programsessionid);

           $this->load->view('includes/header', $data);
           $this->load->view('programs/program_session_class_add');
           $this->load->view('includes/footer');
        }
        
        
    }
    
    public function insert_program_session_class(){
        
        $result = $this->programs_model->insert_program_session_class();
            
        if($result>0){
            $this->session->set_flashdata('Success', 'Class Added!');
        } else {
            $this->session->set_flashdata('Error', 'Something went wrong!');
        }
        
       redirect('programsessionclasses/'.$this->input->post('program_session_id'));
        
    }
}
