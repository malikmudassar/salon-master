<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Mobileapp_controller extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->library('xmlrpc');
        $this->load->library('xmlrpcs');
        $this->load->model('MobileApp_model');
        $this->load->model('Product_model');
        $this->load->library('session');
        $config['functions']['checkMobileNumber'] = array('function' => 'MobileApp_controller.checkMobileNumber');
        $config['functions']['setPassword'] = array('function' => 'MobileApp_controller.setPassword');
        $config['functions']['login'] = array('function' => 'MobileApp_controller.login');
        $config['functions']['getStaff'] = array('function' => 'MobileApp_controller.getStaff');
        $config['functions']['getTimmings'] = array('function' => 'MobileApp_controller.getTimmings');
        $config['functions']['getRes'] = array('function' => 'MobileApp_controller.getReservations');
        $config['functions']['getServices'] = array('function' => 'MobileApp_controller.getAllServices');
        $config['functions']['regMe'] = array('function' => 'MobileApp_controller.registerMe');
        $config['functions']['sendSMS'] = array('function' => 'MobileApp_controller.sendSMS');
        $config['functions']['verifySMS'] = array('function' => 'MobileApp_controller.verifySMS');
        $config['functions']['resRequest'] = array('function' => 'MobileApp_controller.resRequest');
        $config['functions']['getDailyTips'] = array('function' => 'MobileApp_controller.getDailyTips');
        $config['functions']['Offers'] = array('function' => 'MobileApp_controller.Offers');
        $config['functions']['getLoyalityPoints'] = array('function' => 'MobileApp_controller.getLoyalityPoints');
        $config['functions']['Gallery'] = array('function' => 'MobileApp_controller.getGallery');
        $config['functions']['images'] = array('function' => 'MobileApp_controller.getImages');
        $config['functions']['packages'] = array('function' => 'MobileApp_controller.getPackages');
        $config['functions']['reqPackage'] = array('function' => 'MobileApp_controller.reqPackage');
        $config['functions']['getPackageById'] = array('function' => 'MobileApp_controller.getPackageById');
        $config['functions']['updateProfile'] = array('function' => 'MobileApp_controller.updateProfile');
        $config['functions']['getBrands'] = array('function' => 'MobileApp_controller.getBrands');
        $config['functions']['getProducts'] = array('function' => 'MobileApp_controller.getProducts');
        $config['functions']['pushProdCart'] = array('function' => 'MobileApp_controller.pushProdCart');
        $config['functions']['getLocation'] = array('function' => 'MobileApp_controller.getLocation');
        $config['functions']['updateFCMToken'] = array('function' => 'MobileApp_controller.updateFCMToken');
        $config['functions']['orderHistory'] = array('function' => 'MobileApp_controller.orderHistory');
        $config['functions']['changePassword'] = array('function' => 'MobileApp_controller.changePassword');
        
        $this->xmlrpcs->initialize($config);
        $config['object'] = $this;
        $this->xmlrpcs->serve();
    }
    
    public function checkMobileNumber($req){
        $params = $req->output_parameters();
        if(isset($params[0]['cellNumber'])){
            $resp = null;
            if(isset($params[0]['cellNumber'])){
                $resp = $this->MobileApp_model->checkMobileNumber($params[0]["cellNumber"]);
            }
        }else{
            $row = json_decode($params[0],true);
            $resp = $this->MobileApp_model->checkMobileNumber($row["cellNumber"]);
        }
        if($resp){
            return $this->xmlrpc->send_response($resp);
        }else{
            return $this->xmlrpc->send_error_message('100', 'Invalid Access');
        }
    }
    
    public function login($req){
        $params = $req->output_parameters();
        if(isset($params[0]['cellNumber'])){
            $resp = null;
            $resp = $this->MobileApp_model->login($params[0]);
        }else{
            $row = json_decode($params[0],true);
            $resp = $this->MobileApp_model->login($row);
        }
        if($resp){
            return $this->xmlrpc->send_response($resp);
        }else{
            return $this->xmlrpc->send_error_message('100', 'Invalid Access');
        }
    }
    
    public function getStaff(){
        $resp = $this->MobileApp_model->getStaff();
        $arr = array();
        foreach($resp as $r){
            $arr[] = $this->getFormat($r);
        }
        $resp = array($arr,'array');
        if($resp){
            return $this->xmlrpc->send_response($resp);
        }else{
            $r = array(array("status"=>array("false"=>"string")));
            return $this->xmlrpc->send_error_message('100', 'Invalid Access');
        }
    }
    
    public function getTimmings(){
        $resp = $this->MobileApp_model->getTimmings();
        if($resp){
            $startTime = new DateTime($resp[0]['business_opening_time'].":00");
            $endTime = new DateTime($resp[0]['business_closing_time'].":00");
            $arr = array();
            $arr[] =  array("time"=>$startTime->format('h:i A'));
            while($startTime < $endTime){
                $startTime->add(new DateInterval('PT15M'));
                $arr[] =  array("time"=>$startTime->format('h:i A'));
            }
            $final = array();
            foreach($arr as $r){
                $final[] = $this->getFormat($r);
            }
            $resp = array($final,'array');
            return $this->xmlrpc->send_response($resp);
        }else{
            $r = array(array("status"=>array("false"=>"string")));
            return $this->xmlrpc->send_error_message('100', 'Invalid Access');
        }
    }
    
    public function getReservations($req){
        $params = $req->output_parameters();
        if(isset($params)){
            $resp = null;
            if(isset($params[0]['customerId'])){
                $resp = $this->MobileApp_model->getRes($params[0]);
            }else{
                $row = json_decode($params[0],true);
                $resp = $this->MobileApp_model->getRes($row);
            }
            if($resp){
                return $this->xmlrpc->send_response($resp);
            }else{
                return $this->xmlrpc->send_error_message('100', 'Invalid Access');
            }   
        }
    }
    
    public function getDailyTips($req){
        $params = $req->output_parameters();
        if(isset($params)){
            $resp = null;
            if(isset($params[0]['dtId'])){
                $resp = $this->MobileApp_model->getDailyTips($params[0]["dtId"]);
            }else{
                $resp = $this->MobileApp_model->getDailyTips($params[0]);
            }
            if($resp){
                return $this->xmlrpc->send_response($resp);
            }else{
                return $this->xmlrpc->send_error_message('100', 'Invalid Access');
            }   
        }  
    }
    
    public function Offers($req){
        $params = $req->output_parameters();
        if(isset($params)){
            $resp = null;
            if(isset($params[0]['dtId'])){
                $resp = $this->MobileApp_model->getOffers($params[0]["dtId"]);
            }else{
                $resp = $this->MobileApp_model->getOffers($params[0]);
            }
            if($resp){
                return $this->xmlrpc->send_response($resp);
            }else{
                return $this->xmlrpc->send_error_message('100', 'Invalid Access');
            }   
        }  
    }
    
    public function getLoyalityPoints($req){
        $params = $req->output_parameters();
        if(isset($params)){
            $resp = null;
            if(isset($params[0]['customerId'])){
                $resp = $this->MobileApp_model->getLoyalityPoints($params[0]["customerId"]);
                //echo json_encode($resp);exit;
            }else{
                $resp = $this->MobileApp_model->getLoyalityPoints($params[0]);
            }
            if($resp){
                $r = $this->getFormat($resp[0]);
                $arr = array(array("status"=>array("true","string"),
                    "message"=>array("record fournd","string"),
                    "loyaltyPoints"=>$r),'struct');
                return $this->xmlrpc->send_response($arr);
            }else{
                return $this->xmlrpc->send_error_message('100', 'Invalid Access');
            }   
        }  
    }
    
    public function getAllServices($req){
        $params = $req->output_parameters();
        if(isset($params)){
            $resp = null;
            if(isset($params[0]['flag'])){
                $flag = $params[0]['flag'];
                $resp = $this->MobileApp_model->getServices($flag);
            }else{
                $flag = $params[0];
                //print_r($flag);exit;
                $resp = $this->MobileApp_model->getServices($flag);
            }
            if($resp){
                if($flag=="servicetype"){
                    $arr = array();
                    foreach($resp['AllServices'] as $val){
                        if(is_array($val)){
                            $arr[] = $this->getFormat2($val);
                        }
                    }
                    $ar = array(
                        array("AllServices"=>array($arr,'array'),
                            "status"=>array("true","string")),
                            'struct');
                    return $this->xmlrpc->send_response($ar);
                }else{
                    $arr = array();
                    foreach($resp['AllPackages'] as $val){
                        if(is_array($val)){
                            $arr[] = $this->getFormat2($val);
                        }
                    }
                    $ar = array(
                        array("AllPackages"=>array($arr,'array'),
                            "status"=>array("true","string")),
                            'struct');
                    return $this->xmlrpc->send_response($ar);
                }
            }else{
                $r = array(array("status"=>array("false"=>"string")));
                return $this->xmlrpc->send_error_message('100', 'Invalid Access');
            }   
        }
    }
    
    public function registerMe($req){
        $params = $req->output_parameters();
        if(isset($params)){
            $resp = null;
            if(isset($params[0]['customerName'])){
                $resp = $this->MobileApp_model->registerMe($params[0]);
            }else{
                $p = json_decode($params[0],true);
                $resp = $this->MobileApp_model->registerMe($p);
            }
            if($resp){
                return $this->xmlrpc->send_response($resp);
            }
        }else{
            $r = array(array("status"=>array("false","string"),
                        "message"=>array("No Parameter Passed",'string'),
                        "id_customers"=>array("null","string")),
                        'struct');
            return $this->xmlrpc->send_response($r);
        }
    }
    
    public function sendSMS($req){
        $params = $req->output_parameters();
        if(isset($params)){
            $resp = null;
            if(isset($params[0]['idCustomers'])){
                $resp = $this->MobileApp_model->sendSMS($params[0]);
            }else{
                $row = json_decode($params[0],true);
                $resp = $this->MobileApp_model->sendSMS($row);
            }
            if($resp){
                return $this->xmlrpc->send_response($resp);
            }
        }
    }
    
    public function verifySMS($req){
        $params = $req->output_parameters();
        if(isset($params)){
            $resp = null;
            if(isset($params[0]['idCustomers'])){
                $resp = $this->MobileApp_model->verifySMS($params[0]);
            }else{
                $r = json_decode($params[0],true);
                $resp = $this->MobileApp_model->verifySMS($r);
            }
            if($resp){
                return $this->xmlrpc->send_response($resp);
            }
        }
    }
    
    public function setPassword($req){
        $params = $req->output_parameters();
        if(isset($params)){
            $resp = null;
            if(isset($params[0]['idCustomers'])){
                $resp = $this->MobileApp_model->setPassword($params[0]);
            }else{
                $r = json_decode($params[0],true);
                $resp = $this->MobileApp_model->setPassword($r);
            }
            if($resp){
                return $this->xmlrpc->send_response($resp);
            }
        }
    }
    
    public function getArray($val){
        return array($val,"string");
    }
    
    public function checkValid($arr){
        foreach($arr as $key => $val){
            if(!isset($val)){
                $json =  array("status"=>"false","Message"=>$key." Parameter missing");
                $this->xmlrpc->send_error_message('100', 'Invalid Access');
                exit;
            }
        }
        return true;
    }
    
    public function xml($posts){
        header('Content-type: text/xml');
        echo '<?xml version="1.0" encoding="UTF-8"?>
            <methodResponse>
                <params>
                    <param>
                        <value>
                            <struct>';
        foreach($posts as $index => $post) {
            if(is_array($post)) {
                foreach($post as $key => $value) {
                    if(is_array($value)) {
                        foreach($value as $tag => $val) {
                            echo '<member>
                        <name>'.$tag.'</name><value><string>'.$val.'</string></value>
                    </member>';
                        }
                    }else{
                        echo '<member>
                        <name>'.$key.'</name><value><string>'.$value.'</string></value>
                        </member>';
                    }
                }
            }else{
                echo '<member>
                    <name>'.$index.'</name><value><string>'.$post.'</string></value>
                </member>';
            }
        }
        echo '</struct>
                </value>
            </param>
            </params>
            </methodResponse>';
    }
    
    public function getFormat($r){
        $arr = array();
        foreach($r as $key => $val){
            if(is_array($val)){
                //$arr[$key] = array($this->getFormatArray($val),'array');
            }else{
                if(strcmp(gettype($val), "NULL")!=0)
                $arr[$key] = array($val,"string");
            }
        }
        //echo json_encode($arr);
        return array($arr,'struct');
    }
    
    public function getFormat2($r){
        $arr = array();
        foreach($r as $key => $val){
            if(is_array($val)){
                $a = array();
                foreach($val as $r){
                    $a[] = $this->getFormat($r);
                }
                if(count($a)>0){
                    $arr[$key] = array($a,'array');
                }else{
                    $arr[$key] = null;
                }
            }else{
                if(strcmp(gettype($val), "NULL")!=0)
                $arr[$key] = array($val,"string");
            }
        }
        return array($arr,'struct');
    }
    
    public function resRequest($req){
        $params = $req->output_parameters();
        if(isset($params)){
            $resp = null;
            if(isset($params[0]['cartId'])){
                $resp = $this->MobileApp_model->makeReservation($params);
            }else{
                //mobile
                $d = json_decode($params[0],true);
                $resp = $this->MobileApp_model->makeReservation($d);
            }
            if($resp){
                return $this->xmlrpc->send_response($resp);
            }
        }
    }
    
    public function getGallery(){
        $resp = $resp = $this->MobileApp_model->getGallery();
        if($resp){
            return $this->xmlrpc->send_response($resp);
        }else{
            return $this->xmlrpc->send_error("101","Invalid Access");
        }
    }
    
    public function getImages($req){
        $p = $req->output_parameters();
        if(isset($p[0]['galleryId'])){
            $id = $p[0]['galleryId'];
            $resp = $resp = $this->MobileApp_model->getImages($id);    
        }else{
            $id = $p[0];
            $resp = $resp = $this->MobileApp_model->getImages($id);    
        }
        if($resp){
            return $this->xmlrpc->send_response($resp);
        }else{
            return $this->xmlrpc->send_error("101","Invalid Access");
        }
    }
    
    public function getPackageById($req){
        $p = $req->output_parameters();
        if(isset($p[0]['customerId'])){
            $res = $this->MobileApp_model->getPackageById($p[0]['customerId'],
                    $p[0]['status']);  
        }else{
            $res = $this->MobileApp_model->getPackageById($p[0],$p[1]);  
        }
        if($res){
            return $this->xmlrpc->send_response($res);
        }else{
            return $this->xmlrpc->send_error("101","Invalid Accesss");
        }
    }
    
    public function getPackages($req){
        
        $res = $this->MobileApp_model->getPackages();  
        if($res){
            return $this->xmlrpc->send_response($res);
        }else{
            return $this->xmlrpc->send_error("101","Invalid Accesss");
        }
    }
    
    public function reqPackage($req){
        $params = $req->output_parameters();
        if(isset($params)){
            $resp = null;
            if(isset($params[0]['customerId'])){
                $resp = $this->MobileApp_model->makePackageReservation($params[0]);
            }else{
                //mobile
                $d = json_decode($params[0],true);
                $resp = $this->MobileApp_model->makePackageReservation($d);
            }
            if($resp){
                return $this->xmlrpc->send_response($resp);
            }
        }
    }
    
    public function getBrands(){
        $this->session->set_userdata('businessid', 1 );
        $r = $this->Product_model->get_all_brands();
        if($r){
            $d = $this->MobileApp_model->printResponse("true","record Found",
                    "Brands",$r);
            return $this->xmlrpc->send_response($d);
        }else{
            return $this->xmlrpc->send_error("101","Not valid");
        }
    }
    
    public function getProducts($req){
        $this->session->set_userdata('businessid', 1 );
        $params = $req->output_parameters();
        if(isset($params)){
            if(isset($params[0]['brandId'])){
                $data = $this->Product_model->get_all_products($params[0]['brandId'],"retail");
                $r = $this->MobileApp_model->printResponse("true","Record Found","Products",$data);
            }else{
                $data = $this->Product_model->get_all_products($params[0],"retail");
                $r = $this->MobileApp_model->printResponse("true","Record Found","Products",$data);
            }
            if($r){
                return $this->xmlrpc->send_response($r);
            }else{
                return $this->xmlrpc->send_error("101","Invalid Access");
            }
        }
    }
    
    public function pushProdCart($req){
        $params = $req->output_parameters();
        if(isset($params)){
            if(isset($params[0]['brandId'])){
                $r = $this->MobileApp_model->pushProdCart($params[0]);
            }else{
                $r = $this->MobileApp_model->pushProdCart($params[0]);
            }
            if($r){
                return $this->xmlrpc->send_response($r);
            }else{
                return $this->xmlrpc->send_error("101","Invalid Access");
            }
        }
    }
    
    public function getLocation($req){
        $r = $this->MobileApp_model->getLocation();
        //print_r($r);exit;
        if($r){
            return $this->xmlrpc->send_response($r);
        }else{
            return $this->xmlrpc->send_error("101","Invalid Access");
        }
    }
    
    public function updateFCMToken($req){
        $params = $req->output_parameters();
        if(isset($params)){
            if(isset($params[0]['idCustomers'])){
                $r = $this->MobileApp_model->updateFCMToken($params[0]);
            }else{
                $json = json_decode($params[0],true);
                $r = $this->MobileApp_model->updateFCMToken($json);
            }
            if($r){
                return $this->xmlrpc->send_response($r);
            }else{
                return $this->xmlrpc->send_error("101","Invalid Access");
            }
        }
    }
    
    public function orderHistory($req){
        $params = $req->output_parameters();
        if(isset($params)){
            if(isset($params[0]['customerId'])){
                $r = $this->MobileApp_model->orderHistory($params[0]);
            }else{
                $p = json_decode($params[0],true);
                $r = $this->MobileApp_model->orderHistory($p);
            }
            if($r){
                return $this->xmlrpc->send_response($r);
            }else{
                return $this->xmlrpc->send_error("101","Invalid Access");
            }
        }
    }
    
    public function updateProfile($req){
         $params = $req->output_parameters();
        if(isset($params)){
            $resp = null;
            if(isset($params[0]['id_customers'])){
                $resp = $this->MobileApp_model->updateProfile($params[0]);
            }else{
                $p = json_decode($params[0],true);
                $resp = $this->MobileApp_model->updateProfile($p);
            }
            if($resp){
                return $this->xmlrpc->send_response($resp);
            }
        }else{
            //return $this->xmlrpc->send_response($r);
        }
    }
    
    public function changePassword($req){
         $params = $req->output_parameters();
        if(isset($params)){
            $resp = null;
            if(isset($params[0]['id_customers'])){
                $resp = $this->MobileApp_model->changePassword($params[0]);
            }else{
                $p = json_decode($params[0],true);
                $resp = $this->MobileApp_model->changePassword($p);
            }
            if($resp){
                return $this->xmlrpc->send_response($resp);
            }
        }else{
            //return $this->xmlrpc->send_response($r);
        }
    }
    
}