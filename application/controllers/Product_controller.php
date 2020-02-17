<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('product_model');
         $this->load->model('transfernotes_model');
        
        $this->load->model('service_model');
        $this->load->model('supplier_model');
        $this->load->model('business_model');
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        }
    }

    public function getproducts($businessid="", $storeid="") {
        //get the posted values
        $showinhouse="No";
        $showprofessional="No";
        
        
        $business = $this->business_model->getbusinessdetails();
//
        if($this->session->userdata('common_products')=='No'){
            $businessid=$this->session->userdata('businessid');
            
        }
        
        if($business[0]['show_professional']=='Yes'){
            $showprofessional="Yes";            
        }
        //$data = $this->product_model->get_instock_products($showinhouse);
        $data = $this->product_model->get_searched_products($showinhouse, $showprofessional,"",$businessid, $storeid);

        echo(json_encode($data));
    }

    public function getinhouseproducts() {
        //get the posted values
        $business = $this->business_model->getbusinessdetails();
        $data = $this->product_model->get_inhouse_products();
        echo(json_encode($data));
    }

    public function getProductsByService() {
        $service_id = htmlspecialchars($this->input->post('service_id', TRUE));
        $data = $this->product_model->get_inhouse_products_by_service($service_id);
        echo(json_encode($data));
    }

    public function set_business_brands() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1, 0, 0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'business_brands';

            $data['brands'] = $this->product_model->get_all_brands();


            $this->load->view('includes/header', $data);
            $this->load->view('setting/brands_view');
            $this->load->view('includes/footer');
        }
    }

    public function add_brand() {
        $result = $this->product_model->add_brand();
        echo('success|' . $result);
    }

    public function update_brand() {
        $result = $this->product_model->update_brand();
        echo('success|' . $result);
    }

    public function delete_brand() {

        $result = $this->product_model->delete_brand();
        echo('success|' . $result);
    }

    public function set_products() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            $data['nav'] = 'my_business';
            $data['subnav'] = 'business_brands';

            $data['business'] = $this->business_model->getbusinessdetails();
            $scid = $this->input->post('id_business_brands', TRUE);
            $data['products'] = $this->product_model->get_all_products($scid);
            $data['business_brands'] = $this->product_model->get_brand_byid($scid);
            $data['brands'] = $this->product_model->get_all_brands();
            $data['servicecategories'] = $this->service_model->getservice_categories();
            $data['unit_types']=$this->product_model->get_unittypes();

            $data['measurement_unit'] = $this->product_model->get_measurement_unit();

            $this->load->view('includes/header', $data);
            $this->load->view('setting/products_view');
            $this->load->view('includes/footer');
        }
    }

    public function add_product() {

        $result = $this->product_model->add_product();
        echo('success|' . $result);
    }

    public function update_product() {

        $result = $this->product_model->update_product();
        echo('success|' . $result);
    }

    public function delete_product() {

        $result = $this->product_model->delete_product();
        echo('success|' . $result);
    }


    
    public function set_product_list($tagged, $brandid=0) {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1, 0, 0);

            $data['nav'] = 'my_business';

            $data['business'] = $this->business_model->getbusinessdetails();
            $data['brands'] = $this->product_model->get_all_brands();
            $data['measurement_unit'] = $this->product_model->get_measurement_unit();
            if($brandid>0){
                $data['business_brands'] =$this->product_model->get_brand_byid($brandid);
            }
            if ($tagged && $tagged === "professional") {
                $data['subnav'] = 'product_list';
                $data['products'] = $this->product_model->get_all_products($brandid,$tagged);
                $data['title']='Professional Products';
                $data['unit_types']=$this->product_model->get_unittypes();

                $this->load->view('includes/header', $data);
                $this->load->view('setting/products_view');
                $this->load->view('includes/footer');
            } else if ($tagged && $tagged === "retail") {
                $data['subnav'] = 'product_list_retail';
                $data['products'] = $this->product_model->get_all_products($brandid,$tagged);
                $data['title']='Retail Products';
                $data['unit_types']=$this->product_model->get_unittypes();

                $this->load->view('includes/header', $data);
                $this->load->view('setting/products_view');
                $this->load->view('includes/footer');
            } else if ($tagged && $tagged === "threshold") {
                $data['subnav'] = 'product_list_retail';
                $data['products'] = $this->product_model->get_all_products($brandid,$tagged);
                $data['title']='Products Low In Stock';
                $data['unit_types']=$this->product_model->get_unittypes();

                $this->load->view('includes/header', $data);
                $this->load->view('setting/products_view');
                $this->load->view('includes/footer');
            } else if ($tagged && $tagged === "expiring") {
                $data['subnav'] = 'product_list_retail';
                $data['products'] = $this->product_model->get_all_products($brandid,$tagged);
                $data['title']='Products With Batches that are Expired or will Expire soon';
                $data['unit_types']=$this->product_model->get_unittypes();

                $this->load->view('includes/header', $data);
                $this->load->view('setting/products_view');
                $this->load->view('includes/footer');
            } else {
                $data['subnav'] = 'product_list';
                $data['products'] = $this->product_model->get_all_products($brandid,$tagged);
                $data['title']='All Products';
                $data['unit_types']=$this->product_model->get_unittypes();

                $this->load->view('includes/header', $data);
                $this->load->view('setting/products_view');
                $this->load->view('includes/footer');
            }
        }
    }

    
        
    public function all_product_list(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(1, 1, 1);

            $data['nav'] = 'my_business';

            $data['business'] = $this->business_model->getbusinessdetails();
            $data['brands'] = $this->product_model->get_all_brands();
            $data['measurement_unit'] = $this->product_model->get_measurement_unit();
            $data['subnav'] = 'product_list';
               // $data['products'] = $this->product_model->get_all_products($brandid,$tagged);
                $data['title']='All Products';
                $data['unit_types']=$this->product_model->get_unittypes();

                $this->load->view('includes/header', $data);
                $this->load->view('setting/products_view_server');
                $this->load->view('includes/footer');
        }
    }
    function get_productsbysearch(){
        
         //** get all table definitions **//
        $data['draw']= $this->input->post('draw');
        $data['$start'] = $this->input->post('start');
        $data['$length'] = $this->input->post('length');
        
        $data['brand']= $this->input->post('brand');
        $data['product']= $this->input->post('product');
        $data['category']= $this->input->post('category');
        $data['professoinal']= $this->input->post('professional');
        $data['business_product_active']= $this->input->post('business_product_active');
        $data['sku']= $this->input->post('sku');
        
        
        
        
        $total= $this->product_model->get_countofproducts();
        $data['data'] = $this->product_model->get_productsbysearch();
        
//        for($x=0; $x<sizeof($data['data']);$x++){
//            $data['data'][$x]['button'] = "<button id=".$x." type='sumbit'>Add</button>";
//        }
        
        $filtered=  sizeof($data['data']);
        
        $data['recordsTotal'] = $total;
        $data['recordsFiltered'] = $total;
        
        echo(json_encode($data));
        
    }
    
    
    public function add_listproduct() {
        $result = $this->product_model->add_listproduct();
        echo('success|' . $result);
    }

    public function update_listproduct() {
        $result = $this->product_model->update_listproduct();
        echo('success|' . $result);
    }
    
    public function edit_brand(){
        $data = $this->product_model->edit_brand();
        echo (json_encode($data));
        die;
    }
    
    public function edit_product(){
        $data = $this->product_model->edit_product();
        echo (json_encode($data));
        die;
    }
    
    public function get_brands(){
        $data = $this->product_model->get_all_brands();
        echo (json_encode($data));
    }
    
    public function get_all_products(){
        $brandid=$this->input->post('brand_id', TRUE);
        $data = $this->product_model->get_all_products($brandid,'all','yes');
        echo (json_encode($data));
    }

    public function batches($product_id){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(1, 0, 0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'business_brands';

            $data['business'] = $this->business_model->getbusinessdetails();
             if($this->session->userdata('common_products')=='No'){
                 $data['stores'] = $this->product_model->get_business_stores();
             }else {
                $data['stores'] = $this->product_model->get_stores();
             }
            $data['batches'] = $this->product_model->get_all_batches($product_id);

            $this->load->view('includes/header', $data);
            $this->load->view('setting/batches_view');
            $this->load->view('includes/footer');
        }
        
    }
    
    public function check_batch_number() {
        $productid = $this->input->post('product_id', TRUE);
        $batch_number= $this->input->post('batch_number', TRUE);
        
        $data = $this->product_model->check_batch_number($productid, $batch_number);
        echo (json_encode($data));
        
    }
    
    public function add_batch(){

        $result  = $this->product_model->add_batch();
        
        if((float)$this->input->post('batch_qty')>0){
            $data = array(
                'batch_id' => $result,
                'product_id' => $this->input->post('product_id', TRUE),
                'adjustment_qty' => $this->input->post('batch_qty', TRUE),
                'adjustment_date' => date('Y-m-d H:i:s'),
                'adjustment_remarks' => 'Openging Qty',
                'unit_price' => $this->input->post('unit_price', TRUE),
                'created_by' => $this->session->userdata('username'),
                'created_on' => date('Y-m-d H:i:s')
            );
            
           $this->product_model->add_adjustment_note($data);
        }
        
        
        echo('success|' . $result);
        
    }
    
    public function open_edit_batch(){
        
        $data = $this->product_model->open_edit_batch();
        echo (json_encode($data));
        
    }
    
    public function update_batch(){
        
        $adjustments = $this->input->post('adjustments');
        
        
        $adjustments = stripcslashes($adjustments);
        // Decode the JSON array
        $adjustments = json_decode($adjustments, TRUE);
       
        $result  = $this->product_model->update_batch();
        
        //if(sizeof($adjustments)>0){
        for ($i = 0; $i < sizeof($adjustments); $i++) {
            $data = array(
                'batch_id' => $this->input->post('batch_id'),
                'product_id' => $this->input->post('product_id'),
                'adjustment_qty' => $adjustments[$i]['adjustment_qty'],
                'unit_price' => $adjustments[$i]['unit_price'],
                'adjustment_remarks' => $adjustments[$i]['remarks'],
                'adjustment_date' => date('Y-m-d H:i:s'),
                'created_on' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('username')

            );
            $this->product_model->add_adjustment_note($data); 
        }
                       
        //}
        
        echo('success|' . $result);
        
    }

    public function get_next_batchno(){
        
        $data = $this->product_model->get_next_batchno();
        echo (json_encode($data));
        
        
    }
    
    public function bulk_transfer_qty(){
        // exit();
         // Unescape the string values in the JSON array
        $tableData = stripcslashes($_POST['orderdata']);

        // Decode the JSON array
        $tableData = json_decode($tableData, TRUE);
        
         foreach ($tableData as $row) {
             $this->transfer_qty($row['batch_id'],$row['tostore'],$row['transfer_qty']);
         }
        
        
    }
    
    public function transfer_qty($frombatch="", $tostore="", $transfer_Qty=""){
       
        if($frombatch==""){
            $frombatch=$this->input->post('frombatch');
        }
        if($tostore==""){
            $tostore=$this->input->post('tostore');
        }
        if($transfer_Qty==""){
            $transfer_Qty=$this->input->post('transfer_qty');
        }
      
        
        $batch = $this->product_model->getbatch($frombatch);
        
        $datetime =date("Y-m-d H:i:s");
        //$date = $datetime->format('Y-m-d H:i:s');
        //add a gtn and getid
        $gtn_id = $this->transfernotes_model->create_gtn($tostore);
        
        
        $transferout = array(
            'gtn_id' => $gtn_id,
            'business_id' => $this->session->userdata('businessid'),
            'product_id' => $batch->product_id,
            'tranfer_out_qty'=> $transfer_Qty,
            'tranfer_in_qty' => 0,
            'transfer_date' => $datetime,
            'created_by' => $this->session->userdata('username'),
            'batch' => $batch->batch_number,
            'batch_id' => $batch->id_batch
        );
        $newtransferout=$this->transfernotes_model->createtransfernote($transferout);
        
        ///create new batch in transferto store and get newbatchid
        $newbatchno= $this->product_model->get_next_batchno($batch->product_id);
        $newbatch=array(
            'batch_number' => $newbatchno->new_number,
            'product_id' => $batch->product_id,
            'batch_date' => $datetime,
            'expiry_date' => $batch->expiry_date,
            'batch_qty' => 0,
            'store_id' => $tostore,
            'batch_amount' => $batch->batch_amount
        );
        $newbatchid=$this->product_model->add_batch($newbatch);
        
        
        $transferin = array(
            'gtn_id' => $gtn_id,
            'business_id' => $this->session->userdata('businessid'),
            'product_id' => $batch->product_id,
            'tranfer_out_qty'=> 0,
            'tranfer_in_qty' => $transfer_Qty,
            'transfer_date' => $datetime,
            'created_by' => $this->session->userdata('username'),
            'batch' => $newbatchno->new_number,
            'batch_id' => $newbatchid
        );
        $newtransferin=$this->transfernotes_model->createtransfernote($transferin);
        
        echo 'success|'.$newbatchid;
        
        
    }
    
    function product_notes(){
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(1, 0, 0);

            $data['nav'] = 'my_business';
            $data['subnav'] = 'business_brands';

            $data['notes'] = $this->product_model->get_all_notes($this->input->post('id_business_products'));


            $this->load->view('includes/header', $data);
            $this->load->view('setting/product_notes');
            $this->load->view('includes/footer');
        
        }
    }
    
    
}
