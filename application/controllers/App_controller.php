<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class App_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('app_model');
        if($this->session->userdata('role')==''){
            redirect('logout');
        }
    }

    public function get_reservation_requests($status) {
                
        $data['requests'] = $this->app_model->get_reservation_requests($status);
        
        echo(json_encode($data));
        
    }
    
    
    
    
}