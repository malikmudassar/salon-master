<?php

class Sms_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }

    
    function get_sms_cred($business_id=1){
        
        $this->db->select('*');
        $this->db->where('status','valid');
        $this->db->where('business_id', $business_id);
        $query = $this->db->get('sms_cred');
               
        
        return $query->result_array();
    }
    
    function get_countofcustomers(){
        
        $result=0;
        
        $this->db->select('count(*) as count');
        ///Where
        $this->db->where('customers.business_id', $this->session->userdata('businessid'));
        //$this->db->where('length(customers.customer_cell) =', 11);
       ///Where
        if(null !== $this->input->post('customer_name') && $this->input->post('customer_name')!==''){
            $this->db->like('customers.customer_name', $this->input->post('customer_name'));
        }
        if(null !== $this->input->post('customer_cell') && $this->input->post('customer_cell')!==''){
            $this->db->like('customers.customer_cell', $this->input->post('customer_cell'));
        }
        if(null !== $this->input->post('customer_gender') && $this->input->post('customer_gender')!==''){
            $this->db->like('customers.customer_gender', $this->input->post('customer_gender'));
        }
        if(null !== $this->input->post('customer_careof') && $this->input->post('customer_careof')!==''){
            $this->db->like('customers.customer_careof', $this->input->post('customer_careof'));
        }
        if(null !== $this->input->post('customer_email') && $this->input->post('customer_email')!==''){
            $this->db->like('customers.customer_email', $this->input->post('customer_email'));
        }
        if(null !== $this->input->post('profession') && $this->input->post('profession')!==''){
            $this->db->like('customers.profession', $this->input->post('profession'));
        }
        $query = $this->db->get('customers');
       
        foreach ($query->result() as $row){
            $result=$row->count;
        }
        return $result;
        
    }
    
    function get_customersbysearch() {

        $today = date('Y-m-d');
        $tomorrow= date('Y-m-d H:i:s', strtotime('tomorrow'));
        
        
        //** get all table definitions **//
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        
        if (Null!==$this->input->post('order')) {
            $order = $this->input->post('order');
            $columns = $this->input->post('columns');
            $orderby = $columns[$order[0]['column']]['data'];
            $orderdir = $order[0]['dir'];
        } else {
            $orderby = 'id_customers';
            $orderdir = 'asc';
        }
        //openupdate
        
        $this->db->select('id_customers, customer_name customer_name, concat("<span style=\'cursor:pointer;\' class=\'text-primary\' onclick=\"addtophone(\'", customers.customer_cell ,"\',\'", customers.customer_name,"\');\">",customers.customer_name,"</span>") name, customers.customer_careof, customer_gender, '
                . 'concat("<span style=\'cursor:pointer;\' class=\'text-primary\' onclick=\"addtophone(\'", customers.customer_cell ,"\',\'", customers.customer_name,"\');\">",customers.customer_cell,"</span>") customer_cell, customer_email, customer_address, profession, concat("<span style=\'cursor:pointer;\' class=\'text-primary\' onclick=\"openupdate(\'", customers.id_customers ,"\');\">","<button class=\'btn btn-sm btn-primary\'>edit</button>","</span>") type', False);
        
                   
        $this->db->where('customers.business_id', $this->session->userdata('businessid'));
        //$this->db->where('length(customers.customer_cell) =', 11);
        
        ///Where
        if(null !== $this->input->post('customer_name') && $this->input->post('customer_name')!==''){
            $this->db->like('customers.customer_name', $this->input->post('customer_name'));
        }
        if(null !== $this->input->post('customer_cell') && $this->input->post('customer_cell')!==''){
            $this->db->like('customers.customer_cell', $this->input->post('customer_cell'));
        }
        if(null !== $this->input->post('customer_gender') && $this->input->post('customer_gender')!==''){
            $this->db->like('customers.customer_gender', $this->input->post('customer_gender'));
        }
        if(null !== $this->input->post('customer_careof') && $this->input->post('customer_careof')!==''){
            $this->db->like('customers.customer_careof', $this->input->post('customer_careof'));
        }
        if(null !== $this->input->post('customer_email') && $this->input->post('customer_email')!==''){
            $this->db->like('customers.customer_email', $this->input->post('customer_email'));
        }
        if(null !== $this->input->post('profession') && $this->input->post('profession')!==''){
            $this->db->like('customers.profession', $this->input->post('profession'));
        }
        
        
        if(Null!==$this->input->post('order')){
            $this->db->order_by($orderby, $orderdir);
        }
        
        if($length>-1){
           $this->db->limit($length);
        }
        if($start>0){
            $this->db->offset($start);
        }
        
        $query = $this->db->get('customers');
        
        return $query->result_array();
    }

    
    function httpRequest($url)
    {
       
        $args;
        $pattern = "/http...([0-9a-zA-Z-.]*).([0-9]*).(.*)/";
        preg_match($pattern,$url,$args);
        $in = "";
        $fp = fsockopen("$args[1]", $args[2], $errno, $errstr, 30);
        if (!$fp)
        {
           return("$errstr ($errno)");
        }
        else
        {
            $out = "GET /$args[3] HTTP/1.1\r\n";
            $out .= "Host: $args[1]:$args[2]\r\n";
            $out .= "User-agent: PHP Web SMS client\r\n";
            $out .= "Accept: */*\r\n";
            $out .= "Connection: Close\r\n\r\n";

            fwrite($fp, $out);
            while (!feof($fp))
            {
               $in.=fgets($fp, 128);
            }
        }
        fclose($fp);
        return($in);
    } 
    
    function send_sms($msg, $phone, $debug=false, $using="SMSReminder", $echo=true , $business_id=1)
    {
        if ($msg == '' || $phone == '' || strlen($phone)!==11){

            echo('Invalid phone or message!');

        } else {
        
            $username='';
            $password='';   
            $smsurl='';

            $sms_cred = $this->sms_model->get_sms_cred($business_id);

            if($sms_cred){
                $username   = $sms_cred[0]['username']; 
                $password   = $sms_cred[0]['password'];
                $smsurl     = "http://".$sms_cred[0]['domain'].":80/api/?"; // change smsdomain.com to your provider; 
                
                //$smsurl = "http://sms.mexyon.org/api_sms/api.php?key=".$sms_cred[0]['domain'];
                //YOURAPIKEY&receiver=MOBILENUMBER&sender=MASKING&msgdata=TEXT
                
                $url  = 'username='.$username;
                $url  .= '&password='.$password;
                $url  .= '&receiver='.urlencode($phone);
                $url  .= '&msgdata='.urlencode($msg);
                
                
//                $url  .= '&receiver='.urlencode($phone);
//                $url  .= '&sender='.urlencode($username);
//                $url  .= '&msgdata='.urlencode($msg);
                $urltouse =  $smsurl.$url;
                //echo $urltouse; 
                //exit();
                if($debug)
                {
                    echo "Request: <br>$urltouse<br><br>";
                }
                //Open the URL to send the message
                //$response =  $this->httpRequest($urltouse);
                
                //Open the URL to send the message
                $response = file_get_contents($urltouse); //beego
                //$response = $this->url_get_contents($urltouse);
               // 
              
               if ($debug)
                {
                    echo "Response: <br><pre>".
                    str_replace(array("<",">"),array("<",">"),$response).
                    "</pre><br>";
                }
                //Update sms_log Table
                $updated = $this->update_smslog($response, $using, $msg, $echo, $business_id);
                
                
               
            } else {
                echo('SMS Service is not setup!');
            }
        }
    }
//    function url_get_contents ( $url ) {
//        if ( ! function_exists( 'curl_init' ) ) {
//            die( 'The cURL library is not installed.' );
//        }
//        $ch = curl_init();
//        curl_setopt( $ch, CURLOPT_URL, $url );
//        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
//        $output = curl_exec( $ch );
//        curl_close( $ch );
//        echo $output;
//        return $output;
//    }
    function update_smslog($response, $using="SMSReminder", $msg, $echo=true, $businessid=1){
        $pos=528;
        $today= date('Y-m-d H:m');
        //var_dump( $response );
        //$xml= json_decode($response);
       //echo $response;
        
        if($response !== 'SMS Service is not setup!' ){
            
            //$myXMLData= substr($response, $pos);
           
            $xml = simplexml_load_string($response);
            //echo $xml->errorno;
          
            //$xml= json_decode($response);
          
            
            $responseaction = $xml->errorno;
            
           
            
            if(intval($responseaction)==0){
                $this->db->set('errorno', $xml->errorno);
                $this->db->set('status', $xml->status);
                $this->db->set('msgdata', $msg);
                //$this->db->set('receiver', $xml->receivers->reciever);
                  foreach($xml->children() as $child) {
                        foreach($child as $key => $value) {
                            $this->db->set('receiver',$value);

                        }
                    }

                $this->db->set('senton', $today);

                if($echo == true){
                    echo('Message Sent').'<br/>';
                   // echo($xml->response->errorno).'<br/>';
                    echo($xml->status).'<br/>';
                    echo($msg).'<br/>';
                   // echo($xml->receivers->receiver).'<br/>';
                    foreach($xml->children() as $child) {
                        foreach($child as $key => $value) {
                            echo("[".$key ."] ".$value . "<br />");

                        }
                    }
                }

                $this->db->set('using', $using);
                $this->db->set('business_id', $businessid);

                $this->db->insert('sms_log');
                return $this->db->insert_id();
            } else { //Error returned
                
                $this->db->set('errorno', $xml->errorno);
                $this->db->set('status', $xml->description);
                $this->db->set('msgdata', $msg);
                //$this->db->set('receiver', $xml->response->numberlist[0]->number);
                $this->db->set('senton', $today);

                if($echo == true){
                    echo('Error Received').'<br/>';
                    echo($xml->response->errorno).'<br/>';
                    echo($xml->description).'<br/>';
                    //echo( $msg ).'<br/>';
                    //echo($xml->response->numberlist[0]->number).'<br/>';
                }

                $this->db->set('using', $using);
                $this->db->set('business_id', $this->session->userdata('businessid'));

                $this->db->insert('sms_log');
                return $this->db->insert_id();
            }
        } else {
            return 0;
        }
        
        
    } 

    function get_smstext(){
        
        $this->db->select('*');
        $query = $this->db->get('sms_text');
        
        return $query->result_array();
    }
 
    function getsmslog(){
        $today = date('Y-m-d');
        $tomorrow= date('Y-m-d H:i:s', strtotime('tomorrow'));
        
        
        //** get all table definitions **//
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        
        if (Null!==$this->input->post('order')) {
            $order = $this->input->post('order');
            $columns = $this->input->post('columns');
            $orderby = $columns[$order[0]['column']]['data'];
            $orderdir = $order[0]['dir'];
        } else {
            $orderby = 'id_sms_log';
            $orderdir = 'asc';
        }
        
        $this->db->select("id_sms_log,msgdata, replace(receiver,'92','0') as receiver, senton, using, '' as type", TRUE);
        $this->db->where('business_id', $this->session->userdata('businessid'));
        ///Where
        if(null !== $this->input->post('msgdata') && $this->input->post('msgdata')!==''){
            $this->db->like('msgdata', $this->input->post('msgdata'));
        }
        if(null !== $this->input->post('receiver') && $this->input->post('receiver')!==''){
            $this->db->like('receiver', $this->input->post('receiver'));
        }
        if(null !== $this->input->post('senton') && $this->input->post('senton')!==''){
            $this->db->like('senton', $this->input->post('senton'));
        }
        if(null !== $this->input->post('using') && $this->input->post('using')!==''){
            $this->db->like('using', $this->input->post('using'));
        }
        
        
        if(Null!==$this->input->post('order')){
            $this->db->order_by($orderby, $orderdir);
        }
        
        if($length>-1){
           $this->db->limit($length);
        }
        if($start>0){
            $this->db->offset($start);
        }
        
        
        $query = $this->db->get('sms_log');
        
        
       
        return $query->result_array();
    }
    
    function get_countoflog(){
        $this->db->select('count(*) as count');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        ///Where
        if(null !== $this->input->post('msgdata') && $this->input->post('msgdata')!==''){
            $this->db->like('msgdata', $this->input->post('msgdata'));
        }
        if(null !== $this->input->post('receiver') && $this->input->post('receiver')!==''){
            $this->db->like('receiver', $this->input->post('receiver'));
        }
        if(null !== $this->input->post('senton') && $this->input->post('senton')!==''){
            $this->db->like('senton', $this->input->post('senton'));
        }
        if(null !== $this->input->post('using') && $this->input->post('using')!==''){
            $this->db->like('using', $this->input->post('using'));
        }
        
        
        $query = $this->db->get('sms_log');
       foreach ($query->result() as $row){
            $result=$row->count;
        }
        return $result;
    }

    function  update_status($visit_id){
         $data = array(
            'reminder_sms' => 'Y'
        );
        //print_r($data);exit;
        $this->db->where('id_customer_visits', $visit_id);
        $this->db->update('customer_visits', $data);
        return $this->db->affected_rows();
    }
    
}
