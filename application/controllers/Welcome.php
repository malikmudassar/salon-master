<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('user_model');
        $this->load->model('scheduler_model');
        $this->load->model('business_model');
        $this->load->model('dashboard_model');
    }

    public function index() {
        if ($this->session->userdata('role') == '' || $this->session->userdata('role') == 'Sh-Users') {
            
            $this->load->view('login_view');
        } else {
            $this->dashboard();
        }
    }

    
    function not_found(){
        if ($this->session->userdata('role') == '' || $this->session->userdata('role') == 'Sh-Users') {
            $this->load->view('login_view');
        } else {
            
            $data['nav'] = 'dashboard';
            
            $data['user_role'] = $this->session->userdata('role');
            
            
            $this->load->view('includes/header', $data);
            $this->load->view('not_found');
            $this->load->view('includes/footer');
        }
        
    }
    
    
    
    function switch_b(){
        if ($this->session->userdata('b_switch') && $this->session->userdata('b_switch') == 'Yes') {
            $b_list = $this->business_model->get_all_businesses();
            
            echo(json_encode($b_list)); 
            
        }
    }
    
    function business_switch(){
        
        $this->session->unset_userdata('business_id');
        $this->session->unset_userdata('business_name');
        
        $newdata=array(
            'businessid' => $this->input->post('id_business'),
            'business' => $this->input->post('business_name')
        );
        
        $this->session->set_userdata($newdata);
        
       $this->dashboard();
    }
    
    function check_business_sales($month, $year) {
        
    }

    public function dashboard() {
        $data['chart']='chart';
        $data['nodatatable']='nodatatable';
        $sessionData=Array
        (
            'userid' => 1,
            'username' => 'queens',
            'fullname' => 'Queens Salon',
            'email' => 'queens@yopmail.com',
            'roleid' => 1,
            'role' => 'Admin',
            'businessid' => 1,
            'business' => 'Queens Defence',
            'programs' => 'Yes',
            'gym' => 'Yes',
            'training' => 'Yes',
            'recurring' => 'Yes',
            'loyalty_enable' => 'Y',
            'hide_cell' => 'Yes',
            'b_switch' => 'Yes',
            'common_products' => 'No',
            'ho' => 'No',
            'show_previous' => 'Y',
            'logged_in' => 1
        );
        $this->session->set_userdata($sessionData);
        if ($this->session->userdata('role') == '') {
            $this->load->view('login_view');
        } else {
            //programsdashboard
            $data['nav'] = 'dashboard';
            if ($this->session->userdata('role') == 'HR') {
                redirect(base_url('staff_list'));
            } else if ($this->session->userdata('role') == 'Store Manager') {
                redirect(base_url('business_brands'));
            } else if ($this->session->userdata('role') == 'Reception') {
                redirect(base_url('scheduler'));
                //$this->scheduler();
            } else if ($this->session->userdata('role') == 'Board') {
                redirect(base_url('scheduler_view_only'));
                //$this->scheduler();
            } else if ($this->session->userdata('role') == 'Trainer') {
                redirect(base_url('programsdashboard'));
                //$this->scheduler();
            } else if ($this->session->userdata('role') == 'POS') {
                redirect(base_url('pos_view'));
                //$this->scheduler();
            } else if ($this->session->userdata('role') == 'HO') {
                redirect(base_url('ho_view'));
                //$this->scheduler();
            } else if($this->session->userdata('role') == 'Feedback'){
                $today= date('Y-m-d');
                redirect(base_url().'feedback/none/'.$today.'/service');
            } else if($this->session->userdata('role') == 'Sh-Users'){
                redirect(base_url().'sh_dashboard');
            } else {

                // business_sale data inserting
                $month = date('M', strtotime('first day of previous month'));
                $year = date('Y', strtotime('first day of previous month'));

                $result = $this->dashboard_model->get_business_sale_year_month($month, $year);

                if ($result) {
                    
                } else {
                    $start = date('Y-m-d', strtotime('first day of previous month'));
                    $end = date('Y-m-d', strtotime('last day of previous month'));
                    $result = $this->dashboard_model->get_this_month_year_sale($start, $end);
                    $data = array(
                        'business_id' => $this->session->userdata('businessid'),
                        'month' => date('M', strtotime($start)),
                        'year' => date('Y', strtotime($start)),
                        'total_sale' => empty($result->total_sale) ? 0 : $result->total_sale
                    );
                    $result = $this->dashboard_model->add_this_month_year_sale($data);
                }

                // business_sale chart drawing
                $years = $this->dashboard_model->get_business_sale_years();

                $html = "";

                foreach ($years as $y) {

                    $months = array(
                        $y->year => array(
                            'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0,
                            'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0,
                            'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0
                        )
                    );

                    $sales = $this->dashboard_model->get_business_sales($y->year);

                    $html .= "{ name: '$y->year', ";
                    $html .= "data: [";

                    foreach ($sales as $sale) {
                        foreach ($months[$y->year] as $key => $value) {
                            if ($sale->month == $key) {
                                $months[$y->year][$key] = $sale->total_sale;
                            }
                        }
                    }

                    foreach ($months[$y->year] as $m) {
                        $html .= $m . ",";
                    }

                    $html .= "] ";

                    $html .= "},";
                }

                $data['sales'] = rtrim($html, ',');
                
               //get work week
               $workweek = $this->dashboard_model->get_workweek();
               
               
               $data['days'] =[];
               $x=0;
               foreach($workweek as $ww){
                   
                   $data['days'][$x] = $ww['day'];        
                   $data['Customers'][$x] = (float)$ww['Customers'];
                   $data['Services'][$x] = (float)$ww['Services'];
                   $data['Revenue'][$x] = (float)$ww['Revenue'];
                   $data['Balance'][$x] = (float)$ww['Balance'];
                   $data['Advance'][$x] = (float)$ww['Advance'];
                   $x++;
                   
                }
                
               //get work month
               $workweek = $this->dashboard_model->get_workmonth();
               
               
               $data['mdays'] =[];
               $x=0;
               foreach($workweek as $ww){
                   
                   $data['mdays'][$x] = $ww['day'];        
                   $data['mCustomers'][$x] = (float)$ww['Customers'];
                   $data['mServices'][$x] = (float)$ww['Services'];
                   $data['mRevenue'][$x] = (float)$ww['Revenue'];
                   $data['mBalance'][$x] = (float)$ww['Balance'];
                   $data['mAdvance'][$x] = (float)$ww['Advance'];
                   $x++;
                   
                }
                
                $this->load->view('includes/header', $data);
                $this->load->view('dashboard');
                $this->load->view('includes/footer');
            }
        }
    }


    public function reception() {
        if ($this->session->userdata('role') == '' || $this->session->userdata('role') == 'Sh-Users') {
            redirect('logout');
        } else {

            $this->load->view('includes/header');
            $this->load->view('reception');
            $this->load->view('includes/footer');
        }
    }

    public function scheduler($defaulDate = "") {
        
        $data['calendar']='calendar';
        $data['nodatatable']='nodatatable';
        
        if ($this->session->userdata('role') == '' || $this->session->userdata('role') == 'Sh-Users') {
            redirect('logout');
        } else {

            if ($this->session->userdata('role') == 'HR') {
                redirect(base_url('staff_list'));
            }

            $data['nav'] = 'scheduler';
            
            $data['scheduler_style'] = $this->business_model->getbusinessdetails();
            
            $limit=30;
            if(null!==$this->input->post('off_set')){
                $off_set=$this->input->post('off_set');
            }else {
                $off_set = 0;
            }
            //Adding shifts to scheduler
            if(null!==$data['scheduler_style'][0]['shifts'] && $data['scheduler_style'][0]['shifts']==='Y'){
                $data['time'] = $this->business_model->get_shift_timing();
                $staff_count = $this->scheduler_model->staff_shift_count($data['time']->id_shifts);
                $data['pages']= ceil($staff_count->staff_count/$limit);
                $data['limit']= $limit; 
                $data['off_set']= $off_set; 
                $data['staff_count']=$staff_count->staff_count; 
                $data['staff_list'] = $this->scheduler_model->staff_shift_list($data['time']->id_shifts, $off_set, $limit);
            } else {
                $data['time'] = $this->business_model->get_business_timing();
                $staff_count = $this->scheduler_model->staff_count();
                $data['pages']= ceil($staff_count->staff_count/$limit); 
                $data['limit']= $limit; 
                $data['off_set']= $off_set;
                $data['staff_count']=$staff_count->staff_count; 
                $data['staff_list'] = $this->scheduler_model->staff_list($off_set, $limit);
            }
            
            /////
            $data['user_role'] = $this->session->userdata('role');
            
            $resourceList = "";

            foreach ($data['staff_list'] as $staff) {

                $resourceList .= '{id: ' . $staff->id_staff . ', ';

                $img_path = 'assets/images/staff/';
                $staff_image = file_exists('assets/images/staff/' . $staff->staff_image) ? $img_path . $staff->staff_image : $img_path . "no-image.png";

                $resourceList .= 'title: "' . $staff->staff_fullname . '",';
                $resourceList .= 'staff_shared: "' . $staff->staff_shared . '"},';
            }


            $events = "";

            $data['resources'] = rtrim($resourceList, ',');
            $data['events'] = rtrim($events, ',');
            

            if(null!==$this->session->flashdata('defaultDate')){
                $data['defaultDate'] = $this->session->flashdata('defaultDate');
            }else{
                $data['defaultDate'] = $this->input->post('defaultDate');
            }

            $this->load->view('includes/header', $data);
            $this->load->view('scheduler_view');
            $this->load->view('includes/footer');
        }
    }

    function business_timing() {

        //storemanager,hr,reception...user serial
        checkroles(0, 0, 0);

        $data['nav'] = 'my_business';
        $data['subnav'] = 'business_timing';

        if ($this->session->userdata('role') == '' || $this->session->userdata('role') == 'Sh-Users') {
            redirect('logout');
        } else {

            $data['time'] = $this->business_model->get_business_timing();

            $this->load->view('includes/header', $data);
            $this->load->view('setting/business_timing');
            $this->load->view('includes/footer');
        }
    }

    function update_business_timing() {

        $start = htmlentities(trim($this->input->post('start', TRUE)));
        $end = htmlentities(trim($this->input->post('end', TRUE)));

        $data = array(
            'business_opening_time' => $start,
            'business_closing_time' => $end
        );

        $update = $this->business_model->update_business_timing($data);

        if ($update) {
            echo 'success';
        }
    }

    public function time_block_reason() {

        //storemanager,hr,reception...user serial
        checkroles(0, 0, 0);

        $data['nav'] = 'my_business';
        $data['subnav'] = 'time_block_reason';
        $data['timebockreason'] = $this->business_model->get_time_block_reason();
        $this->load->view('includes/header', $data);
        $this->load->view('setting/time_block_reason_view');
        $this->load->view('includes/footer');
    }

    public function add_blockevent() {

        $data = array(
            'business_id' => $this->session->userdata('businessid'),
            'block_event_name' => $this->input->post('blockeventname'),
            'block_event_duration' => $this->input->post('duration'),
            'block_event_desc' => $this->input->post('description')
        );

        $insert = $this->business_model->add_blockevents($data);

        if ($insert) {
            echo 'success';
        }
    }

    public function edit_blockevent() {

        $data = array(
            'block_event_name' => $this->input->post('blockeventname'),
            'block_event_duration' => $this->input->post('duration'),
            'block_event_desc' => $this->input->post('description')
        );

        $update = $this->business_model->edit_blockevents($data);

        if ($update) {
            echo 'success';
        }
    }

    public function get_edit_blockevent() {
        $data = $this->business_model->get_edit_blockevent();

       
         echo (json_encode($data)); 
        die;
    }

    public function scheduler_view_only($defaulDate = "") {
        
        $data['calendar']='calendar';
        $data['nodatatable']='nodatatable';
        
        if ($this->session->userdata('role') == '' || $this->session->userdata('role') == 'Sh-Users') {
            redirect('logout');
        } else {
            $data['menu'] = 'hidden';
            if ($this->session->userdata('role') == 'Store Manager') {
                redirect(base_url('servicetypes'));
            }
            if ($this->session->userdata('role') == 'HR') {
                redirect(base_url('staff_list'));
            }

            $data['nav'] = 'scheduler';

            $data['time'] = $this->business_model->get_business_timing();

            $data['scheduler_style'] = $this->business_model->getbusinessdetails();
            $data['user_role'] = $this->session->userdata('role');

            $data['staff_list'] = $this->scheduler_model->staff_list();
            $resourceList = "";

            foreach ($data['staff_list'] as $staff) {

                $resourceList .= '{id: ' . $staff->id_staff . ', ';

                $img_path = 'assets/images/staff/';
                $staff_image = file_exists('assets/images/staff/' . $staff->staff_image) ? $img_path . $staff->staff_image : $img_path . "no-image.png";

                $resourceList .= 'title: "' . $staff->staff_fullname . '"},';
            }


            $events = "";


            $data['resources'] = rtrim($resourceList, ',');
            $data['events'] = rtrim($events, ',');

            $data['defaultDate'] = $defaulDate;

            //echo $defaulDate; exit;
            $this->load->view('includes/header', $data);
            $this->load->view('scheduler_view_only');
            $this->load->view('includes/footer');        
        }
    }
    
   
    function period_booking(){
        if ($this->session->userdata('role') == '' || $this->session->userdata('role') == 'Sh-Users') {
            redirect('logout');
        } else {

            $data['nav'] = 'scheduler';
            $data['scheduler_style'] = $this->business_model->getbusinessdetails();
            $data['user_role'] = $this->session->userdata('role');
            $data['staff_list'] = $this->scheduler_model->staff_list();
            
            
            $this->load->view('includes/header', $data);
            $this->load->view('period_booking');
            $this->load->view('includes/footer');    
        }
    }

    
    
   function update_csrf(){
        $csrf['csrf_name'] = $this->security->get_csrf_token_name();
        $csrf['csrf_hash'] = $this->security->get_csrf_hash();
        echo(json_encode($csrf));
   }
    
}
