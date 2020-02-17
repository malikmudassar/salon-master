<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('user_model');
    }

    function getUserDetails() {
        $user_id = $this->input->post('user_id', TRUE);
        $data['users'] = $this->user_model->get_user_details($user_id);
        $data['roles'] = $this->user_model->get_user_roles();
        $userpass = $data['users'];
        $this->session->set_userdata('userorignalpass', $userpass->user_password);
        echo json_encode($data);
    }

    public function getUser_roles() {
        $data['roles'] = $this->user_model->get_user_roles();
        echo json_encode($data);
    }

    function addUserDetails() {
        $user_name = $this->input->post('add_user_name', TRUE);
        $user_password = $this->input->post('add_user_password', TRUE);
        $user_cnf_password = $this->input->post('add_user_cnf_password', TRUE);
        $user_first_name = $this->input->post('add_user_first_name', TRUE);
        $user_last_name = $this->input->post('add_user_last_name', TRUE);
        $user_email = $this->input->post('add_user_email', TRUE);
        $user_cell = $this->input->post('add_user_cell', TRUE);
        $user_phone = $this->input->post('add_user_phone', TRUE);
        $user_address = $this->input->post('add_user_address', TRUE);
        $user_role = $this->input->post('add_user_role', TRUE);
        $user_status = $this->input->post('add_user_status', TRUE);
        $user_hidden = $this->input->post('add_user_hidden', TRUE);

        if(null == $user_hidden){$user_hidden='No';}
        
        $data = array(
            'user_name' => $user_name,
            'user_firstname' => $user_first_name,
            'user_lastname' => $user_last_name,
            'user_fullname' => $user_first_name . " " . $user_last_name,
            'user_email' => $user_email,
            'user_mobile' => $user_cell,
            'user_phone' => $user_phone,
            'user_address' => $user_address,
            'user_status' => $user_status,
            'user_hidden' => $user_hidden,
            'business_id' => $this->session->userdata('businessid')
        );

        if ($user_cnf_password !== "") {
            $data['user_password'] = md5($user_cnf_password);
            //$hash = $this->hash_password($user_cnf_password);            
            //$data['user_password'] =$hash;
        }
        
        $add = $this->user_model->add_user_details($data, $user_role);
        if ($add) {
            echo 'success';
            exit;
        }
    }

    function updateUserDetails() {
        $edit_user_id = $this->input->post('edit_user_id', TRUE);
        $user_name = $this->input->post('user_name', TRUE);
        $user_password = $this->input->post('user_password', TRUE);
        $user_new_password = $this->input->post('user_new_password', TRUE);
        $user_first_name = $this->input->post('user_first_name', TRUE);
        $user_last_name = $this->input->post('user_last_name', TRUE);
        $user_email = $this->input->post('user_email', TRUE);
        $user_cell = $this->input->post('user_cell', TRUE);
        $user_phone = $this->input->post('user_phone', TRUE);
        $user_address = $this->input->post('user_address', TRUE);
        $user_role = $this->input->post('user_role', TRUE);
        $user_status = $this->input->post('user_status', TRUE);
        $user_hidden = $this->input->post('edit_user_hidden', TRUE);

        $data = array(
            'user_name' => $user_name,
            'user_firstname' => $user_first_name,
            'user_lastname' => $user_last_name,
            'user_fullname' => $user_first_name . " " . $user_last_name,
            'user_email' => $user_email,
            'user_mobile' => $user_cell,
            'user_phone' => $user_phone,
            'user_address' => $user_address,
            'user_status' => $user_status,
            'user_hidden' => $user_hidden
        );

        if ($user_new_password !== "") {
            $data['user_password'] = md5($user_new_password);
            //$hash = $this->hash_password($user_new_password);
            //$data['user_password'] =$hash;
        } else {
            $data['user_password'] = $this->session->userdata('userorignalpass');
        }

        $update = $this->user_model->update_user_details($edit_user_id, $data, $user_role);
        if ($update) {
            echo 'success';
            exit;
        }
    }

    function users_list() {

        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {

            //storemanager,hr,reception...user serial
            checkroles(0, 0, 0);

            $data['nav'] = 'users';
            $data['subnav'] = 'users_list';

            $data['users'] = $this->user_model->get_users();
            $data['roles'] = $this->user_model->get_user_roles();
            $data['username']=$this->session->userdata('username');
    //        echo '<pre>';
    //        print_r($data['users']);
    //        echo '</pre>';
    //        exit;

            $this->load->view('includes/header', $data);
            $this->load->view('users_list');
            $this->load->view('includes/footer');
        }
    }

    public function user_profile() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $data['user_profile'] = $this->user_model->get_user_profile();
            $this->load->view('includes/header', $data);
            $this->load->view('user_profile');
            $this->load->view('includes/footer');
        }
    }

    public function updateUserpass() {
        $edit_user_id = $this->input->post('user_id', TRUE);
        $new_password = $this->input->post('new_password');
        $cnf_password = $this->input->post('cnf_password');
        $current_password = md5($this->input->post('current_password'));

        $currentdb_pass = $this->user_model->getUser_current_pass($edit_user_id, $current_password);

        if ($currentdb_pass && $current_password == $currentdb_pass->user_password) {
            //$hash = $this->hash_password($cnf_password);
            
            $data = array(
                'user_password' => md5($cnf_password),
                //'user_password' => $hash
            );
            $update = $this->user_model->update_Userpass($edit_user_id, $data);
            if ($update) {
                echo 'success';
                exit;
            }
        } else {
            echo 'error';
            exit;
        }
    }

    public function user_image() {
        if ($this->input->post('userid', TRUE) && $this->input->post('userid', TRUE) != "") {
            $image = "";
            if ($_FILES['user_image']['name'] && $_FILES['user_image']['name'] != "") {
                $image = $this->image_upload('images/users', 'user_image', 'gif|jpg|png');
                if ($image == FALSE) {
                    $this->session->set_flashdata('errorimage', 'The image dimension must be 128 X 128');
                    redirect(base_url('user_profile'));
                } else {
                    $image = $image;
                }
            } else {
                $image = ($this->input->post('org_image', TRUE) != "" ? $this->input->post('org_image', TRUE) : NULL);
            }

            $result = $this->user_model->updateuser_image($image);
            if ($result) {
                if ($this->session->userdata('role') == "Admin") {
                    redirect(base_url('users_list'));
                } else {
                    redirect(base_url('user_profile'));
                }
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

    private function hash_password($password){
        
        $options = [
            'cost' => 9,
            //'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
            'salt' => 'thisisoursillystringforsalt'
        ];
       // return password_hash($password, PASSWORD_BCRYPT, $options);
        //return $this->hash_password($password, PASSWORD_BCRYPT);
     }
    
    function login() {
        //get the posted values
        $username = $this->input->post("txt_username", TRUE);
        $password = $this->input->post("txt_password", TRUE);

        //set validations
        $this->form_validation->set_rules("txt_username", "Username", "trim|required");
        $this->form_validation->set_rules("txt_password", "Password", "trim|required");

        
        
        if ($this->form_validation->run() == FALSE) {
            //validation fails
            $this->user_model->add_failed_attempt($username,$this->input->ip_address());
            $this->load->view('login_view');
        } else {
            
           
            //validation succeeds
            if ($this->input->post('btn_login') == "Login") {
                //brute protect
               // $response = $this->user_model->getLoginStatus();
                $response['status']="safe";
                if($response['status']!=="safe"){
//                    $this->user_model->add_failed_attempt($username,$this->input->ip_address());
//                    echo $response['status'];
//                    exit();
                }
                
                //check if username and password is correct
               // $hash = $this->hash_password($password);
                
                $usr_result = $this->user_model->get_user($username, $password);
                
                //$usr_result = $this->user_model->get_user($username, $hash);
                
                //if (password_verify($password, $usr_result[0]['user_password'])==true) {
                
                    if (isset($usr_result) && sizeof($usr_result) > 0) { //active user record is present
                        //set the session variables
                        $sessiondata = array(
                            'userid' => $usr_result[0]['id_users'],
                            'username' => $username,
                            'fullname' => $usr_result[0]['user_fullname'],
                            'email' => $usr_result[0]['user_email'],
                            'roleid' => $usr_result[0]['id_roles'],
                            'role' => $usr_result[0]['role_name'],
                            'businessid' => $usr_result[0]['business_id'],
                            'business' => $usr_result[0]['business_name'],
                            'programs' => $usr_result[0]['programs'],
                            'gym' => $usr_result[0]['gym'],
                            'training' => $usr_result[0]['training'],
                            'recurring' => $usr_result[0]['recurring'],
                            'loyalty_enable' => $usr_result[0]['loyalty_enable'],
                            'hide_cell' => (isset($usr_result[0]['hide_cell'])) ? $usr_result[0]['hide_cell']: 'No',
                            'b_switch' => (isset($usr_result[0]['b_switch'])) ? $usr_result[0]['b_switch']: 'No',
                            'common_products' => (isset($usr_result[0]['common_products'])) ? $usr_result[0]['common_products']: 'No',
                            'ho' => (isset($usr_result[0]['ho'])) ? $usr_result[0]['ho']: 'No',
                            'show_previous' => (isset($usr_result[0]['rec_allow_prev'])) ? $usr_result[0]['rec_allow_prev']: 'N', 
                            'logged_in' => TRUE
                            
                        );
                        
                        $this->session->set_userdata($sessiondata);
                        // $myVar=$sessiondata;
                        // echo '<pre>';print_r($this->session->userdata);exit;
                        redirect('dashboard');
                    } else {
                        
                        $ip_addr = $this->input->ip_address();
                        
                        $status = $this->user_model->add_failed_attempt($username, $ip_addr);
                       
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username or password! '.$response['status'].'</div>');
                        redirect('login');
                    }
//                } else {
//                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid password!</div>');
//                    redirect('login');
//                }
                
                
            } else {
                redirect('login');
            }
        }
    }

    function logout() {

//        $sessiondata = array(
//            'username' => '',
//            'email' => '',
//            'role' => '',
//            'logged_in' => FALSE
//        );
//        $this->session->set_userdata($sessiondata);

        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('roleid');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('businessid');
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();

        redirect('login');
    }

}
