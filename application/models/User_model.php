<?php

class User_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        
        
        
    }

    // array of throttle settings. # failed_attempts => response
    private static $default_throttle_settings = [
                    2 => 2, 			//delay in seconds
                    4 => 4, 			//delay in seconds
                    6 => 'captcha'	//captcha
    ];

    //time frame to use when retrieving the number of recent failed logins from database
    private static $time_frame_minutes = 10;
    
    function get_user_details($user_id) {
        $this->db->select('*');
        $this->db->join('user_roles', 'users.id_users = user_roles.user_id');
        $this->db->join('roles', 'roles.id_roles = user_roles.role_id');
        $this->db->where('users.id_users', $user_id);
        $query = $this->db->get('users');
        return $query->row();
    }

    function get_user_roles($sh=false) {
        $this->db->select('*');
         if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('roles.role_name ', 'Sh-Users'); 
        }
        $query = $this->db->get('roles');
        return $query->result();
    }

    function add_user_details($data, $user_role) {
        $this->db->insert('users', $data);
        $insertid = $this->db->insert_id();

        $data = array(
            'user_id' => $insertid,
            'role_id' => $user_role
        );
        $this->db->insert('user_roles', $data);
        return $insertid;
    }

    function update_user_details($id, $data, $user_role) {
        $this->db->where('id_users', $id);
        $query = $this->db->update('users', $data);

        $data = array(
            'role_id' => $user_role
        );
        $this->db->where('user_id', $id);
        $query1 = $this->db->update('user_roles', $data);

        return $query1;
    }

    function get_users($sh=false) {
        
        $role_id = $this->session->userdata('roleid');
        $user_role = $this->session->userdata('role');
        
        $this->db->select('*');
        $this->db->join('business', 'users.business_id = business.id_business');
        $this->db->join('user_roles', 'users.id_users = user_roles.user_id');
        $this->db->join('roles', 'roles.id_roles = user_roles.role_id');
        if($role_id !== '1' && $user_role !=='Super User' ){
            $this->db->where('user_roles.role_id !=',1); 
        }
        
        if($sh==true ||  $this->session->userdata('role')=="Sh-Users"){
            $this->db->where('roles.role_name ', 'Sh-Users'); 
        }
        
        $this->db->where('users.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('users');
        return $query->result();
    }

    //get the username & password from tbl_usrs
    function get_user($usr, $pwd) {
       // echo $pwd;
        $this->db->select('*');
        $this->db->join('user_roles', 'users.id_users = user_roles.user_id');
        $this->db->join('roles', 'roles.id_roles = user_roles.role_id');
        $this->db->join('business', 'business.id_business = users.business_id');
        //$query = $this->db->get_where('users', array('user_name' => $usr, 'user_password' => md5($pwd), 'user_status'=>'Active'));
        $this->db->where('user_name',$usr);
        $this->db->where('user_password', md5($pwd));
        $this->db->where('user_status', 'Active');
        $query = $this->db->get('users');
        //echo '<pre>';
        //print_r($query); exit();
        return $query->result_array();
    }

    function add_failed_attempt($user_id, $ip_addr){
        //get current timestamp
        $timestamp = date('Y-m-d H:i:s');
         $data = array(
             'user_id' => $user_id,
             //'ip_address' => inet_ntop($ip_addr),
             'attempted_at' => $timestamp
         );
        $query = $this->db->insert('failed_login_attempts', $data);
        
        //return $this->input->post('updated', TRUE);
    }
    
    function getLoginStatus($options = null){
        //setup response array
        $response_array = array(
                'status' => 'safe',
                'message' => null
        );
        
        //attempt to retrieve latest failed login attempts
        $stmt = null;
        $latest_failed_logins = null;
        $row = null;
        $latest_failed_attempt_datetime = null;
        
        $this->db->select('*, MAX(attempted_at) AS attempted');
        $query = $this->db->get('failed_login_attempts');
        
        $latest_failed_logins = $query->num_rows();
        $row =  $query->row();
        var_dump($row);
        if(sizeof($row)>0){
        //get latest attempt's timestamp
            $latest_failed_attempt_datetime = (int) date('U', strtotime($row->attempted_at));
        } else {
             $response_array['status']='safe';
             return $response_array;
            exit();
        }
        //get local var of throttle settings. check if options parameter set
        if($options == null){
                $throttle_settings = self::$default_throttle_settings;
        }else{
                //use options passed in
                $throttle_settings = $options;
        }
        //grab first throttle limit from key
        reset($throttle_settings);
        $first_throttle_limit = key($throttle_settings);
        
        
        //get all failed attempst within time frame
        $this->db->select('*');
        $this->db->where('attempted_at >', 'DATE_SUB(NOW(), INTERVAL '.self::$time_frame_minutes.' MINUTE)');
        $query = $this->db->get('failed_login_attempts');
        
        
        $number_recent_failed = $query->num_rows();
        //reverse order of settings, for iteration
        krsort($throttle_settings);
        //if number of failed attempts is >= the minimum threshold in throttle_settings, react
        if($number_recent_failed >= $first_throttle_limit ){			
                //it's been decided the # of failed logins is troublesome. time to react accordingly, by checking throttle_settings
                foreach ($throttle_settings as $attempts => $delay) {
                        if ($number_recent_failed > $attempts) {
                                // we need to throttle based on delay
                                if (is_numeric($delay)) {
                                        //find the time of the next allowed login
                                        $next_login_minimum_time = $latest_failed_attempt_datetime + $delay;

                                        //if the next allowed login time is in the future, calculate the remaining delay
                                        if(time() < $next_login_minimum_time){
                                                $remaining_delay = $next_login_minimum_time - time();
                                                // add status to response array
                                                $response_array['status'] = 'delay';
                                                $response_array['message'] = $remaining_delay;
                                        }else{
                                                // delay has been passed, safe to login
                                                $response_array['status'] = 'safe';
                                        }
                                        //$remaining_delay = $delay - (time() - $latest_failed_attempt_datetime); //correct
                                        //echo 'You must wait ' . $remaining_delay . ' seconds before your next login attempt';


                                } else {
                                        // add status to response array
                                        $response_array['status'] = 'captcha';
                                }
                                break;
                        }
                }  

        }
       
        return $response_array;
    }
    
    
    function get_user_profile() {
        $usrid = $this->session->userdata('userid');
        $roleid = $this->session->userdata('roleid');
        $this->db->select('*');
        $this->db->join('user_roles', 'users.id_users = user_roles.user_id');
        $this->db->join('roles', 'roles.id_roles = user_roles.role_id');
        $this->db->where('users.id_users', $usrid);
        $this->db->where('roles.id_roles', $roleid);
        $query = $this->db->get('users');
        return $query->row();
    }

    function getUser_current_pass($edit_user_id, $current_password) {
        $this->db->select('users.user_password');
        $this->db->where('users.id_users', $edit_user_id);
        $this->db->where('users.user_password', $current_password);
        $query = $this->db->get('users');
        return $query->row();
    }
    
    function get_profile_image($userid) {
        $this->db->select('user_image');
        $this->db->where('id_users', $userid);
        $query = $this->db->get('users');
        return $query->row();
    }

    function update_Userpass($edit_user_id, $data) {
        $this->db->where('id_users', $edit_user_id);
        $query = $this->db->update('users', $data);

        return $edit_user_id;
    }

    function updateuser_image($image = NULL) {
        $data = array(
            'user_image' => $image ? $image : NULL
        );
        $this->db->where('id_users', $this->input->post('userid', TRUE));
        $query = $this->db->update('users', $data);

        return $this->input->post('userid', TRUE);
    }

    function login() {
        
    }

    function get_active_users(){
        
        $this->db->select('user_name');
        $this->db->join('user_roles','user_roles.user_id = users.id_users');
        $this->db->join('roles','user_roles.role_id= roles.id_roles');
        $this->db->where('user_status', 'Active');
        $query = $this->db->get('users');
        return $query->result_array();
        
    }
    function get_visible_users(){
        
        $this->db->select('user_name');
        $this->db->join('user_roles','user_roles.user_id = users.id_users');
        $this->db->join('roles','user_roles.role_id= roles.id_roles');
        $this->db->where('user_status', 'Active');
        $this->db->where('user_hidden', 'No');
        $query = $this->db->get('users');
        return $query->result_array();
        
    }
    
}
