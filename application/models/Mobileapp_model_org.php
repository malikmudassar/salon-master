<?php

class Mobileapp_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function checkMobileNumber($cell){
        $resp = $this->db->query("SELECT * FROM customers WHERE customer_cell=".$cell);
        if($resp->num_rows()>0){
            $row = $resp->result_array();
            return $this->printResponse("true","Number Registerd","user",$row);
        }else{
            return $this->printResponse("false","No User Found with this Cell Number");
        }
    }
    
    public function login($r){
       
        $resp = $this->db->query("SELECT * FROM customers WHERE customer_cell='".$r['cellNumber']
                ."' AND password='".$r['password']."'");
        if($resp->num_rows()>0){
            $row = $resp->result_array();
            return $this->printResponse("true","Login Succesfull","user",$row);
        }else{
            return $this->printResponse("false","Invalid Password");
        }
    }
    
    public function getStaff(){
        $this->db->select("*");
        $this->db->where('staff_active',"Y");
        $this->db->where('staff_scheduler',"On");
        $this->db->order_by('staff_order', 'ASC');
        $resp = $this->db->get('staff');
        return $resp->result_array();
    }
    
    public function getTimmings(){
        $this->db->select("business_opening_time,business_closing_time");
        $resp = $this->db->get('business');
        return $resp->result_array();
    }
    
    public function getRes($row){
        $customerId = $row['customerId'];
        $status = $row['status'];
        //print_r($row);exit;
        if($status=="pending"){    
            $where = " where rs.customer_id = $customerId AND (rs.status = 'pending' OR rs.status='approved') AND rs.is_package_type = 0 AND str_to_date(requested_date,'%m-%d-%Y') >= CURDATE() order by rs.date DESC)";
            $where2 = " where rs.customer_id = $customerId AND (rs.status = 'pending' OR rs.status='verified') AND rs.is_package_type = 1 AND str_to_date(requested_date,'%m-%d-%Y') >= CURDATE() order by rs.date DESC)";
        }else{
            $where = " where rs.customer_id = $customerId AND rs.status = '".$status."' AND rs.is_package_type = 0 order by rs.date DESC)";
            $where2 = " where rs.customer_id = $customerId AND rs.status = '".$status."' AND rs.is_package_type = 1 order by rs.date DESC)";
        }
        $qry = "(select rs.res_req_id,service_id,service_name,service_category_id, bs.service_duration,bs.service_rate,st.service_type,sc.service_category,
        rs.requested_date,rs.start_time,rs.end_time,rs.date,rs.status,s.staff_fullname
        from reservation_requests rs 
        join service_type st on st.id_service_types = rs.service_type_id
        join service_category sc on sc.id_service_category = rs.cat_id
        join business_services bs on bs.id_business_services = rs.service_id
        left join staff s on s.id_staff = rs.staff_id".$where. 
        " UNION
        (Select rs.res_req_id,service_id,service_name,service_category_id, bs.service_duration,bs.service_rate,pt.service_type,pc.service_category,
        rs.requested_date,rs.start_time,rs.end_time,rs.date,rs.status,s.staff_fullname
        from reservation_requests rs 
        join package_type pt on pt.id_package_type = rs.service_type_id
        join package_category pc on pc.id_package_category = rs.cat_id
        join business_services bs on bs.id_business_services = rs.service_id 
        left join staff s on s.id_staff = rs.staff_id".$where2;
        //echo $qry;
        $resp = $this->db->query($qry);
        if($resp->num_rows()>0){
            $row = $resp->result_array();
            return $this->printResponse("true","Bookings Found","Bookings",$row);
        }else{
            return $this->printResponse("false","Bookings Not Found");
        }
    }
    
    public function getServices($flag){
        if($flag=="packagetype"){
            $qry = "Select id_package_type as 'id_service_types', business_id, service_type, service_type_image, order_id, service_type_active, 'packagetype' as 'flag'
        from package_type
        where business_id = 1 AND service_type_active = 'Yes'";
        }else{
            $qry = "Select id_service_types, business_id, service_type, service_type_image, service_type_active, order_id, 'servicetype' as 'flag'
            from service_type
            where business_id = 1 AND service_type_active = 'Yes'";
        }
        $resp = $this->db->query($qry);
        $data = $resp->result_array();
        //print_r($data);exit;
        if($data){
            $all = array();
            $arr = array();
            foreach($data as $r){
                $service = array();
                    if($flag=="packagetype"){
                        $qry = "Select service_category,id_package_category as id_service_category
                        from package_category
                        join package_type on package_type.id_package_type = package_category.package_type_id
                        where package_category.business_id = 1 AND service_category_active = 'yes' AND package_type_id=".$r['id_service_types']
                        ." order by package_type.order_id, package_category.order_id asc";
                        $res = $this->db->query($qry);
                        $serviceTypes = $res->result_array();
                    }else{
                        $qry = "Select service_category,id_service_category
                        from service_category
                        join service_type on service_type.id_service_types = service_category.service_type_id
                        WHERE service_category.business_id = 1 AND service_category_active = 'Yes' AND service_type_id=".$r['id_service_types']
                        ." ORDER BY service_type.order_id, service_category.order_id asc";
                        $res = $this->db->query($qry);
                        $serviceTypes = $res->result_array();
                    }
                foreach($serviceTypes as $s){
                    if($flag=="packagetype"){
                        $d = $this->getServ($flag, $s['id_service_category']);
                    }else{
                        $d = $this->getServ($flag, $s['id_service_category']);
                    }
                    $s['service_type'] = $r['service_type'];
                    $s['id_service_types'] = $r['id_service_types'];
                    $s['services'] = $d;
                    $arr[] = $s;
                }
            }
            if($flag=="packagetype"){
                return array("AllPackages"=>$arr);
            }else{
                return array("AllServices"=>$arr);
            }
        }
    }
    
    public function getServ($flag,$id){
        if($flag == "packagetype"){
            $qry = "select service_id,service_name,service_category_id,
                id_package_services,bs.service_duration,bs.service_rate
                from business_services bs
                join package_services ps on bs.id_business_services = ps.service_id
                join package_category pc on ps.package_category_id = pc.id_package_category
                where bs.business_id = 1 AND package_category_id = $id AND service_active='Yes' and service_category_active='Yes'
                order by pc.order_id asc";
            $res = $this->db->query($qry);
            $data = $res->result_array();
            return $data;
        }else{
            $qry = "select service_name,service_rate,service_duration,id_business_services as 'service_id' 
                from business_services bs
                join service_category on service_category.id_service_category = bs.service_category_id
                where bs.business_id = 1
                AND service_category_id = $id AND service_active='Yes' and service_category_active='Yes'
                order by service_category.order_id ASC";
            $res = $this->db->query($qry);
            $data = $res->result_array();
            return $data;
        }
    }
    
    public function registerMe($params){
        if(isset($params['customerName'])){
            $cName = isset($params['customerName']) ? $params['customerName']:null;
            $cell = isset($params['customerCell']) ? $params['customerCell']:null;
            $passwrod = isset($params['password']) ? $params['password']:null;
            $idCustomer = isset($params['idCustomers']) ? $params['idCustomers']:null;
            $row = array("customer_name"=>$cName,"customer_cell"=>$cell);
        }
        if($cName && $cell){
            $qry = "SELECT * FROM customers WHERE customer_cell=".$cell;
            $r = $this->db->query($qry);
            if($r->num_rows()>0){
                $r = array(array("status"=>array("false","string"),
                    "message"=>array("user Already Exists",'string')),
                    'struct');
                return $r;
            }else{
                $this->db->insert('customers',$row);
                $id = $this->db->insert_id();
                $r = array(array("status"=>array("true","string"),
                    "message"=>array("Register Sucessful",'string'),
                    "id_customers"=>array($id,"string")),
                    'struct');
                return $r;
            }
        }else{
            $r = array(array("status"=>array("false","string"),
                    "message"=>array("Failed to Insert")),
                    'struct');
                return $r;
        }
        
    }
    
    public function sendSMS($row){
        $query = "Select customer_cell,pin_code FROM customers where id_customers=".$row['idCustomers'];
        $res = $this->db->query($query);
        if($res->num_rows()>0){
            $res = $res->result_array();
            $res = $res[0];
            if($res['pin_code']){
                $mobile = $res['customer_cell'];
                $pincode = $res['pin_code'];
                $message = $row["appName"]." pin is: $pincode";
                return $this->send_sms($message, $mobile);
            }else{
                $pin = rand(1000, 5000);
                $mobile = $res['customer_cell'];
                $qry = "UPDATE customers SET pin_code=".$pin." WHERE id_customers=".$row['idCustomers'];
                $u = $this->db->query($qry);
                if($u == 1){
                    $message = $row["appName"]." pin is: ".$pin;
                    return $this->send_sms($message, $mobile);
                }
            }
        }
    }
    
    public function send_sms($msg, $phone,$print=null, $debug = false) {
        if ($msg == '' || $phone == '' || strlen($phone) !== 11) {
            echo('Invalid phone or message!');
        } else {
            $username = 'mexyon01';
            $password = '123456';
            $smsurl = "http://sms.dotklick.com:80/api/?"; // change smsdomain.com to your provided; 
            $url = 'username=' . $username;
            $url .= '&password=' . $password;
            $url .= '&receiver=' . urlencode($phone);
            $url .= '&msgdata=' . urlencode($msg);
            $urltouse = $smsurl . $url;
            $response = $this->httpRequest($urltouse);
            if ($debug) {
                echo "Request: <br>$urltouse<br><br>";
            }
            if($print){

            }else{
               if (strpos($response, '<errorno>') !== false) {
                  return $this->printResponse("true","SMS Sent Successful");
               }else{
                   return $this->printResponse("false","Failed to Send SMS");
               }
            }
        }
    }      

    public function httpRequest($url) {
        $args;
        $pattern = "/http...([0-9a-zA-Z-.]*).([0-9]*).(.*)/";
        preg_match($pattern, $url, $args);
        $in = "";
        $fp = fsockopen("$args[1]", $args[2], $errno, $errstr, 30);
        if (!$fp) {
            return("$errstr ($errno)");
        } else {
            $out = "GET /$args[3] HTTP/1.1\r\n";
            $out .= "Host: $args[1]:$args[2]\r\n";
            $out .= "User-agent: PHP Web SMS client\r\n";
            $out .= "Accept: */*\r\n";
            $out .= "Connection: Close\r\n\r\n";
            fwrite($fp, $out);
            while (!feof($fp)) {
                $in.=fgets($fp, 128);
            }
        }
        fclose($fp);
        return($in);
    }
    
    public function printResponse($status,$msg,$key=null,$data=null){
        if($key && $data){
            if(is_array($data)){
                $arr = array();
                foreach($data as $k=>$r){
                    $arr[] = $this->getFormat($r);
                }
                $r = array(array(
                "status"=>array($status,"string"),
                "message"=>array($msg,"string"),
                "$key"=>array($arr,'array')),
                'struct');
            }else{
                $r = array(array(
                "status"=>array($status,"string"),
                "message"=>array($msg,"string"),
                "$key"=>$this->getFormat($data)),
                'struct');
            }
        }else{
            $r = array(array(
            "status"=>array($status,"string"),
            "message"=>array($msg,"string")),'struct');
        }
        return $r;
    }
    
    public function setPassword($r){
        $qry = "UPDATE customers SET password=".$r['password']." WHERE id_customers=".$r['idCustomers'];
        $resp = $this->db->query($qry);
        if($resp){
            $row = $this->db->query("SELECT * FROM customers WHERE id_customers=".$r['idCustomers']);
            $res = $row->result_array();
            return $this->printResponse("true","Password Set","user",$res);
        }else{
            return $this->printResponse("false", "Password Failed");
        }
    }
    
    public function verifySMS($r){
        $qry = "SELECT * FROM customers WHERE pin_code=".
                $r['pinCode']." AND id_customers=".$r['idCustomers'];
        $row = $this->db->query($qry);
        if($row->num_rows()>0){
            
            $qry = "UPDATE customers SET is_verified=1 WHERE id_customers=".$r['idCustomers'];
            $r = $this->db->query($qry);
            if($r==1){
                $res = $row->result_array();
                return $this->printResponse("true","verified","user",$res);
            }else{
                return $this->printResponse("false", "Verification Failed");
            }
            
        }else{
            return $this->printResponse("false", "Invalid Pin Code");
        }
    }
    
    public function getFormat($r){
        $arr = array();
        foreach($r as $key => $val){
            if(!is_array($val)){
                if(strcmp(gettype($val), "NULL")!=0)
                $arr[$key] = array($val,"string");
            }
        }
        return array($arr,'struct');
    }
    
    public function getFormat2($r){
        $arr = array();
        foreach($r as $key => $val){
            
            if(!is_array($val)){
                if(strcmp(gettype($val), "NULL")!=0)
                $arr[$key] = array($val,"string");
            }
        }
        //print_r($arr);
        return array($arr,'struct');
    }
    
    public function makeReservation($d){
        foreach($d as $r){
            $cartId = isset($r['cartId']) ? $r['cartId'] : null;
            $serviceTypeId = isset($r['serviceTypeId']) ? $r['serviceTypeId'] : null;
            $catId = isset($r['catId']) ? $r['catId'] : null;
            $serviceId = isset($r['serviceId']) ? $r['serviceId'] : null;
            $customerId = isset($r['customerId']) ? $r['customerId'] : null;
            $staffId = isset($r['staffId']) ? $r['staffId'] : null;
            $requestDate = isset($r['requestDate']) ? $r['requestDate'] : null;
            $reqTimeStart = isset($r['reqTimeStart']) ? $r['reqTimeStart'] : null;
            $reqTimeEnd = isset($r['reqTimeEnd']) ? $r['reqTimeEnd'] : null;
            $isPackageType = isset($r['isPackageType']) ? $r['isPackageType'] : null;
             /*`res_req_id`, `service_type_id`, `cat_id`, `service_id`, `customer_id`, 
             * `staff_id`, `date`, `status`, `is_package_type`, `requested_date`, `start_time`, `end_time`*/
            if($isPackageType){
                $isPackageType = 1;
            }else{
                $isPackageType = 0;
            }
            $row = array("service_type_id"=>$serviceTypeId,"cat_id"=>$catId,"service_id"=>$serviceId,
            "customer_id"=>$customerId,"staff_id"=>$staffId,"is_package_type"=>$isPackageType,
            "requested_date"=>$requestDate,"start_time"=>$reqTimeStart,"end_time"=>$reqTimeEnd,
                "status"=>"pending"
                    );
            if($this->checkValid($row)){
                $b = $this->db->insert('reservation_requests', $row);
                if($this->db->affected_rows() > 0){
                    continue;
                }else{
                    return $this->printResponse("false","Some Request Not Made");
                }
            }else{
                return $this->printResponse("false","Parameters Error");
            }
        }
        return $this->printResponse("true","Requests Made");
    }
    
    public function checkValid($arr){
        foreach($arr as $key => $val){
            if(!isset($val)){
                return false;
            }
        }
        return true;
    }
    
    public function getDailyTips($dtId=null){
        if($dtId){
            $qry = "SELECT * from daily_tips where active=1 AND dt_id = ".$dtId;
        }else{
            $qry = "SELECT * from daily_tips where active=1 order by created_on DESC";
        }
        $res = $this->db->query($qry);
        if($res->num_rows()>0){
            $row = $res->result_array();
            return $this->printResponse("true","Daily Tips Found","DailyTip",$row);
        }else{
            return $this->printResponse("false","No Daily Tips Found");
        }
    }
    
    public function getOffers($dtId=null){
        if($dtId){
            $qry = "SELECT * from offers where active=1 AND offer_id = ".$dtId;
        }else{
            $qry = "SELECT * from offers where active=1 order by created_on DESC";
        }
        $res = $this->db->query($qry);
        if($res->num_rows()>0){
            $row = $res->result_array();
            return $this->printResponse("true","Offer Found","Offers",$row);
        }else{
            return $this->printResponse("false","No Offers Found");
        }
    }
    
    public function getLoyalityPoints($custId=null){
        $this->db->select("id_customers as customer_id, customers.customer_name, customers.customer_cell, sum(ifnull(loyalty_earned,0)) 'earned', sum(ifnull(loyalty_used,0)) 'used', sum(ifnull(loyalty_earned,0)) - sum(ifnull(loyalty_used,0)) 'loyalty_points', sum(ifnull(retained_amount,0)) - sum(ifnull(retained_amount_used,0)) 'retained'");
        $this->db->join('invoice','invoice.customer_id = customers.id_customers and invoice_status="valid"', 'left') ;
        $this->db->where("id_customers =", $custId);
        $this->db->group_by('id_customers');
        $query= $this->db->get('customers');
        return $query->result_array();
    }
    
    public function getService($points){
        $qry = "Select * from loyalty_services JOIN business_services bs on bs.id_business_services = loyalty_services.service_id 
                JOIN service_category sc on sc.id_service_category = bs.service_category_id 
                JOIN service_type st on st.id_service_types = sc.service_type_id 
                WHERE required_points <=$points AND loyalty_services.active = 'Y'";
        $row = $this->db->query($qry);
        if($row->num_rows()>0){
            return $row->result_array();
        }
        return array();
    }
    
    public function getGallery(){
        $qry = "Select g.gallery_id, gallery_name, status,gallery_date,img_path from galleries g
        LEFT JOIN images i on i.gallery_id = g.gallery_id
        WHERE g.status = 1
        group by g.gallery_id";
        $res = $this->db->query($qry);
        if($res->num_rows()>0){
            $row = $res->result_array();
            return $this->printResponse("true","Galleries Found","galleries",$row);
        }else{
            return $this->printResponse("false","Galleries Not Found");
        }
    }
    
    public function getImages($id){
        $qry = "Select * FROM images WHERE img_status=1 AND gallery_id=".$id;
        $res = $this->db->query($qry);
        if($res->num_rows()>0){
            $row = $res->result_array();
            return $this->printResponse("true","Images Found","images",$row);
        }else{
            return $this->printResponse("false","Images Not Found");
        }
    }
    
    public function getPackages(){
        $qry = "SELECT * FROM package_type WHERE service_type_active='Yes'";
        $res = $this->db->query($qry);
        if($res->num_rows()>0){
            $rr = $res->result_array();
            $arr = array();
            foreach($rr as $r){
                $arr = array();
                $qry = "Select service_category,id_package_category as id_service_category
                            from package_category
                            where business_id = 1 AND service_category_active = 'yes' AND package_type_id=".$r['id_package_type']
                            ." order by order_id asc";
                $res = $this->db->query($qry);
                $serviceTypes = $res->result_array();
                foreach($serviceTypes as $s){
                    $d = $this->getServ("packagetype", $s['id_service_category']);
                    $s['service_type'] = $r['service_type'];
                    $s['id_package_type'] = $r['id_package_type'];
                    $s['services'] = $d;
                    $arr[] = $s;
                }
                if(count($arr)>0){
                    $r['categories'] = $arr;
                    $ar[] = $r;
                }
            }
            //echo json_encode(array("packages"=>$ar));exit;
            $num = 0;
            for($i=0;$i<count($ar);$i++){
                $a[] = $this->getFormat($ar[$i]);
                $b=array();
                for($j=0;$j<count($ar[$i]['categories']);$j++){
                    $b[] = $this->getFormat($ar[$i]['categories'][$j]);
                    $e=array();
                    for($k=0;$k<count($ar[$i]['categories'][$j]['services']);$k++){
                        if(is_array($ar[$i]['categories'][$j]['services'][$k])){
                            $e[] = $this->getFormat($ar[$i]['categories'][$j]["services"][$k]);
                            //print_r($this->getFormat($ar[$i]['categories'][$j]["services"][$k]));exit;
                        }
                    }
                    $b[$j][0]["services"] = array($e,'array');
                }
                $a[$i][0]["categories"] = array($b,'array');
                //$all["packages"] = array($a,'array');
                //return array($all,'struct');
            }
            //print_r($a);exit;
            $all = array("packages"=>array($a,'array'));
            //echo json_encode(array($all,'struct'));exit;
            //$all["packages"] = array($a,'array');
            //echo json_encode($all);exit;
            return array(array("status"=>array("true",'string'),
                "message"=>array("Packages found",'string'),
                "packages"=>array($a,'array')),'struct');
        }else{
            return $this->printResponse("false","No Packages Found");
        }
    }
    
    public function getPackageById($cId,$status){
        if($status=="pending"){
            $where = " WHERE service_type_active='Yes' AND (rq.status='pending' OR rq.status='approved') AND rq.is_package_type = 1 AND rq.customer_id=$cId";
        }else{
            $where = " WHERE service_type_active='Yes' AND rq.status='$status' AND rq.is_package_type = 1 AND rq.customer_id=$cId";
        }
        $qry = "SELECT *,rq.status FROM package_type pt
        JOIN reservation_requests rq on rq.service_type_id = pt.id_package_type"
        .$where;
        $res = $this->db->query($qry);
        if($res->num_rows()>0){
            $rr = $res->result_array();
            $arr = array();
            foreach($rr as $r){
                $arr = array();
                $qry = "Select service_category,id_package_category as id_service_category
                            from package_category
                            where business_id = 1 AND service_category_active = 'yes' AND package_type_id=".$r['id_package_type']
                            ." order by order_id asc";
                $res = $this->db->query($qry);
                $serviceTypes = $res->result_array();
                foreach($serviceTypes as $s){
                    $d = $this->getServ("packagetype", $s['id_service_category']);
                    $s['service_type'] = $r['service_type'];
                    $s['id_package_type'] = $r['id_package_type'];
                    $s['services'] = $d;
                    $arr[] = $s;
                }
                $r['categories'] = $arr;
                $ar[] = $r;
            }
            //echo json_encode(array("reqPackages"=>$ar));exit;
            $num = 0;
            for($i=0;$i<count($ar);$i++){
                $a[] = $this->getFormat($ar[$i]);
                $b=array();
                for($j=0;$j<count($ar[$i]['categories']);$j++){
                    $b[] = $this->getFormat($ar[$i]['categories'][$j]);
                    $e=array();
                    for($k=0;$k<count($ar[$i]['categories'][$j]['services']);$k++){
                        if(is_array($ar[$i]['categories'][$j]['services'][$k])){
                            $e[] = $this->getFormat($ar[$i]['categories'][$j]["services"][$k]);
                            //print_r($this->getFormat($ar[$i]['categories'][$j]["services"][$k]));exit;
                        }
                    }
                    $b[$j][0]["services"] = array($e,'array');
                }
                $a[$i][0]["categories"] = array($b,'array');
                //$all["packages"] = array($a,'array');
                //return array($all,'struct');
            }
            //print_r($a);exit;
            $all = array("packages"=>array($a,'array'));
            //echo json_encode(array($all,'struct'));exit;
            //$all["packages"] = array($a,'array');
            //echo json_encode($all);exit;
            return array(array("status"=>array("true",'string'),
                "message"=>array("Packages found",'string'),
                "reqPackages"=>array($a,'array')),'struct');
        }else{
            return $this->printResponse("false","No Packages Found");
        }
    }
    
    public function makePackageReservation($p){
        if(isset($p['customerId'])){
            $serviceTypeId = isset($p['serviceTypeId']) ? $p['serviceTypeId'] : null;
            $customerId = isset($p['customerId']) ? $p['customerId'] : null;
            $isPackageType = isset($p['isPackageType']) ? $p['isPackageType'] : null;
            $reqDate = isset($p['requestedDate']) ? $p['requestedDate'] : null;
            $startTime = isset($p['requestTime']) ? $p['requestTime'] : null;
        }
        if($serviceTypeId && $customerId && $isPackageType && $reqDate 
                && $startTime){
            $arr = array("service_type_id"=>$serviceTypeId,
                "customer_id"=>$customerId,"is_package_type"=>$isPackageType,
                "requested_date"=>$reqDate,"start_time"=>$startTime,"status"=>"pending");
            //print_r($arr);exit;
            $this->db->insert('reservation_requests',$arr);
            $id = $this->db->insert_id();
            if($id>0){
                return array(
                    array("message"=>array('Reservation Received','string'),
                        "status"=>array('true','string'),
                        "RequestId"=>array($id,'string'),
                    ),'struct');
            }else{
                return $this->printResponse("false","Reservation Failed");
            }
        }else{
            return $this->printResponse("false","Params Missing");
        }
    }
    
    public function getBrands(){
        $this->db->select("*");
        $this->db->where('business_brands.business_id', "1");
        $res = $this->db->get('business_brands');
        if($res->num_rows()>0){
            $r = $res->result_array();
            return $this->printResponse("true","Record Found","Brands",$r);
        }else{
            return $this->printResponse("false","No any Record");
        }
    }
    
    public function pushProdCart($prods){
        $data = json_decode($prods,true);
        //print_r($data);exit;
        if($data){
            $arr = array("customer_id"=>$data[0]['customerId'],
                    "business_id"=>1,"order_status"=>"open");
                $r = $this->db->insert('customer_orders',$arr);
                $orderId = $this->db->insert_id();
            foreach($data as $r){
                $ar = array("business_id"=>1,"customer_order_id"=>$orderId,
                    "business_brand_id"=>null,"product_id"=>$r['product_id'],
                    "product_name"=>$r['product_name'],"qty"=>$r['qty'],
                "staff_id"=>null,"staff_name"=>"app","category"=>null,
                    "stockfrom"=>"in_stock","batch"=>"","batch_id"=>0);
                $i = $this->db->insert("order_products",$ar);
            }
            return $this->printResponse("true","We have received your order.");
        }else{
            return $this->printResponse("false", "No data Received");
        }
    }
    
    public function getLocation(){
         $this->db->select("lat,long");
        $resp = $this->db->get('business');
        //echo json_encode(array("status"=>"true","message"=>"found","location"=>$resp->result_array()));
        if($resp){
            $row = $resp->result_array();
            $arr = array(
                array(
                "status"=>array("true","string"),
                "message"=>array("location Found","string"),
                "lat"=>array($row[0]['lat'],"string"),
                "long"=>array($row[0]['long'],"string")),'struct');
            return $arr;
        }
    }
    
    public function updateFCMToken($row){
        $res = $this->db->query("UPDATE customers SET fcm_id='".$row['fcmid']."' WHERE id_customers=".$row['idCustomers']);
        return $this->printResponse("true","Registration Successfull");
    }
    
    public function orderHistory($row){
        if($row){
            $qry = "Select *,
            (select sum(purchase_price * op.qty) as price from order_products op
            join business_products bp on bp.id_business_products = op.product_id
            where bp.id_business_products = op.product_id and customer_order_id = co.id_customer_order) as 'total'
            from customer_orders co
            where co.customer_id=".$row['customerId'];
            $res = $this->db->query($qry);
            if($res->num_rows()>0){
                $i=0;
                $r = $res->result_array();
                $main = array();
                for($i=0;$i<count($r);$i++){
                    $qry = "SELECT * FROM order_products where customer_order_id=".$r[$i]['id_customer_order'];
                    $result = $this->db->query($qry);
                    if($result->num_rows()>0){
                        $j=0;
                        $arr = $result->result_array();
                        $od = array();
                        for($j=0;$j<count($arr);$j++){
                            $od[] = $this->getFormat2($arr[$j]);
                        }
                    }   
                    $order = $this->getFormat($r[$i]);
                    if(count($od)>0){
                        $order[0]['order_details'] = array($od,'array');
                    }else{
                        $order[0]['order_details'] = null;
                    }
                    $main[] = $order;
                }
                $ar = array(array("orders"=>array($main,'array'),
                            "status"=>array("true","string")),
                            'struct');
                    return $ar;
            }else{
                return $this->printResponse("false","No any Record");
            }
        }
    }
    
    public function updateProfile($params){
        if(isset($params['id_customers'])){
            $custEmail = isset($params['customer_email']) ? $params['customer_email']:null;
            $birthDay = isset($params['birth_day']) ? $params['birth_day']:null;
            $birthMonth = isset($params['birth_month']) ? $params['birth_month']:null;
            $anniversary = isset($params['anniversary']) ? $params['anniversary']:null;
            $idCustomers = isset($params['id_customers']) ? $params['id_customers']:null;
            $customerName = isset($params['name']) ? $params['name']:null;
            if($idCustomers){
                $val = array();
                if($custEmail){$val['customer_email']=$custEmail;}
                if($birthDay){$val['customer_birthday']=$birthDay;}
                if($birthMonth){$val['customer_birthmonth']=$birthMonth;}
                if($anniversary){$val['customer_anniversary']=$anniversary;}        
                if($customerName){$val['customer_name'] = $customerName;}
                $this->db->where('id_customers',$idCustomers);
                if( $this->db->update('customers',$val)){
                    $r = $this->db->query("SELECT * FROM customers WHERE id_customers=".$idCustomers);
                    if($r->num_rows()>0){
                        $resp = $r->result_array();
                        return $this->printResponse("true","Profile Updated","user",$resp);
                    }
                }else{
                    return $this->printResponse("false","failed to update");
                }
            }else{
                return $this->printResponse("false","No data received");
            }
        }else{
            return $this->printResponse("false","failed to update");
        }
    }
    
    
    public function changePassword($params){
        if(isset($params['id_customers'])){
            $password = isset($params['password']) ? $params['password']:null;
            $idCustomers = isset($params['id_customers']) ? $params['id_customers']:null;
            if($idCustomers){
                $val = array();
                if($password){$val['password']=$password;}
                $this->db->where('id_customers',$idCustomers);
                if( $this->db->update('customers',$val)){
                    $r = $this->db->query("SELECT * FROM customers WHERE id_customers=".$idCustomers);
                    if($r->num_rows()>0){
                        $resp = $r->result_array();
                        return $this->printResponse("true","Password Changed","user",$resp);
                    }
                }else{
                    return $this->printResponse("false","failed to change Password");
                }
            }else{
                return $this->printResponse("false","No data received");
            }
        }else{
            return $this->printResponse("false","failed to update");
        }
    }
    
    
}