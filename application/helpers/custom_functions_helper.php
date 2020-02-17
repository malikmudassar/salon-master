<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('getUserProfileImage')){
    function getUserProfileImage(){
        $CI = & get_instance();
        $CI->load->model('user_model');
        $userid = $CI->session->userdata('userid');
        $data = $CI->user_model->get_profile_image($userid);
        
        if(!empty($data->user_image)){
            if(file_exists('assets/images/users'.'/'.$data->user_image)){
                return base_url('assets/images/users').'/'.$data->user_image;
            } else{
                return base_url('assets/images/users/avatar-1.jpg');
            }
        } else{
            return base_url('assets/images/users/avatar-1.jpg');
        }
    }
}

if(!function_exists('generateColorCode')){
    function generateColorCode(){
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
        return strtoupper($color);
    }
}

if(!function_exists('ColorDarken')){
    function ColorDarken($color, $dif=20){

        $color = str_replace('#', '', $color);
        if (strlen($color) != 6){ return '000000'; }
        $rgb = '';

        for ($x=0;$x<3;$x++){
            $c = hexdec(substr($color,(2*$x),2)) - $dif;
            $c = ($c < 0) ? 0 : dechex($c);
            $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
        }

        return '#'.$rgb;
    }
}

if(!function_exists('randomColor')){
    function randomColor($minVal = 0, $maxVal = 255){
        
        $CI = & get_instance();

        // Make sure the parameters will result in valid colours
        $minVal = $minVal < 0 || $minVal > 255 ? 0 : $minVal;
        $maxVal = $maxVal < 0 || $maxVal > 255 ? 255 : $maxVal;

        // Generate 3 values
        $r = mt_rand($minVal, $maxVal);
        $g = mt_rand($minVal, $maxVal);
        $b = mt_rand($minVal, $maxVal);

        // Return a hex colour ID string
        $code = ColorDarken(sprintf('#%02X%02X%02X', $r/2, $g/2, $b/2));
        $data = $CI->visits_model->check_color($code);
        
        if($code === $data->visit_color){
            return randomColor(0,100);
        } else{
            return $code;
        }

    }
}

if(!function_exists('checkroles')){
    function checkroles($user1,$user2,$user3){
//        if($user1 == 0){
//            $CI = & get_instance();
//            if($CI->session->userdata('role') == 'Store Manager'){
//                redirect(base_url('servicetypes'));
//            }
//        }
        
        if($user2 == 0){
            $CI = & get_instance();
            if($CI->session->userdata('role') == 'HR'){
                redirect(base_url('staff_list'));
            }
        }
        
        if($user3 == 0){
            $CI = & get_instance();
            if($CI->session->userdata('role') == 'Reception'){
                redirect(base_url('scheduler'));
            }
        }
        
    }
}