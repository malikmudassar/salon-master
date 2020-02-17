<?php

class Purchaseorder_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function getPurchase_order_list() {
        $startdate = $this->input->post('startdate', TRUE);
        $enddate = $this->input->post('enddate', TRUE);

        $showall='No';
        
        $this->db->select('*');
        if($this->session->userdata('common_products')=='No'){
            $this->db->where('id_business', $this->session->userdata('businessid'));
        }
        $q = $this->db->get('business');
        $business= $q->result_array();
        foreach($business as $b){
        
            $showall=$b['multibranchpo'];
        }
        
        $this->db->select('idpurchase_order, purchase_order_number, business_supplier.supplier_name, total_purchase_pirce, purchase_order.status, purchase_order.created_by, DATE_FORMAT(order_date, "%d-%m-%Y") as order_date, sum(purchase_order_details.product_qty) as qty, business_name' );
        $this->db->join('purchase_order_details','purchase_order.idpurchase_order = purchase_order_details.purchase_order_id');
        $this->db->join('business_supplier','purchase_order.supplier_id = business_supplier.id_business_supplier');
        $this->db->join('business','purchase_order.business_id = business.id_business');
        
        if($showall =='No'){
        
            $this->db->where('purchase_order.business_id', $this->session->userdata('businessid'));
        
        }
        
        $this->db->where('purchase_order.created_on >= ', $startdate.' 00:00:00');
        $this->db->where('purchase_order.created_on <= ', $enddate.' 23:59:59' );
        $this->db->group_by('idpurchase_order, purchase_order_number, business_supplier.supplier_name, total_purchase_pirce, purchase_order.status, purchase_order.created_by, order_date');
        $this->db->order_by('created_on', 'desc');
        $query = $this->db->get('purchase_order');
        
        return $query->result_array();
    }

    function get_suppliers($businessid){
        
        $this->db->select('*');
        $this->db->join('business', 'business.id_business = business_supplier.business_id');
        
        $this->db->where('business_supplier.business_id', $businessid);
        $query = $this->db->get('business_supplier');

        return $query->result_array();
    }
    function get_supplier_brand($supplierid, $business_id) {
        $this->db->select('*');
        $this->db->join('supplier_brand sp', 'sp.brand_id = bb.id_business_brands');
        
        $this->db->where('bb.business_brand_active', 'Yes');
        if($this->session->userdata('common_products')=='No'){
            $this->db->where('bb.business_id', $business_id);
        }
        $this->db->where('sp.supplier_id', $supplierid);
        $query = $this->db->get('business_brands bb');
       
        return $query->result_array();
    }

    function get_brand_product($brandid, $business_id) {
        $this->db->select('*');
        if($this->session->userdata('common_products')=='No'){
            $this->db->where('business_products.business_id', $business_id);
        }
        $this->db->where('business_products.business_product_active', 'Yes');
        $this->db->where('business_products.brand_id', $brandid);
        $query = $this->db->get('business_products');
     
        return $query->result_array();
    }

    function add_order() {
        // Unescape the string values in the JSON array
        $tableData = stripcslashes($_POST['orderdata']);

        // Decode the JSON array
        $tableData = json_decode($tableData, TRUE);

        // now $tableData can be accessed like a PHP array
         
        //add new customer_visit
        $total_qty = 0;
        $total_price = 0;
        foreach ($tableData as $row1) {
            $total_price += $row1['productprice'] * $row1['productqty'];
            $total_qty += $row1['productqty'];
        }
        $businessid = $this->session->userdata('businessid');
        if(null!==$tableData[0]['businessid']){
            $businessid=$tableData[0]['businessid'];
        } 
        
        $order = array(
            'business_id' => $businessid,
            'supplier_id' => $tableData[0]['supplierid'],
            'supplier_name' => $tableData[0]['suppliername'],
            'status' => 'Pending',
            'total_purchase_pirce' => $total_price,
            'product_total_qty' => $total_qty,
            'order_date' => $tableData[0]['orderdate'],
            'created_by' => $this->session->userdata('username')
        );
        $this->db->insert('purchase_order', $order);
        $order_id = $this->db->insert_id();

        $data = [];

        foreach ($tableData as $row) {

            $data = array(
                'purchase_order_id' => $order_id,
                'brand_id' => $row['brandid'],
                'brand_name' => $row['brandname'],
                'product_id' => $row['productid'],
                'product_name' => $row['productname'],
                'product_purchase_price' => $row['productprice'],
                'product_qty' => $row['productqty']
            );

            $this->db->insert('purchase_order_details', $data);
        }

        $data = array(
            'purchase_order_number' => 'PO-' . date('Y-m') . '-00' . $order_id
        );
        $this->db->where('idpurchase_order', $order_id);
        $this->db->update('purchase_order', $data);

        return $order_id;
    }

    function get_purchase_order_by_id($purchaseorder_id) {
        $this->db->select('*, date_format(order_date,"%d-%m-%Y") as d, bs.supplier_name');
        $this->db->join('business_supplier bs','bs.id_business_supplier = purchase_order.supplier_id');
        $this->db->join('business','business.id_business = purchase_order.business_id');
        $this->db->where('purchase_order.idpurchase_order', $purchaseorder_id);
        $query = $this->db->get('purchase_order');
        
       
        
        return $query->result_array();
    }

    function get_purchase_orders() {
        $this->db->select('*');
        $this->db->where('status', 'pending');
        $this->db->or_where('status', 'partial');
        $query = $this->db->get('purchase_order');

        return $query->result_array();
    }

    function get_purchase_order_detail($purchaseorder_id) {
//        $this->db->select('*');
//        $this->db->join('business_products bp','bp.id_business_products = purchase_order_details.product_id');
//        $this->db->join('business_brands bb','bb.id_business_brands = bp.brand_id');
//        $this->db->where('purchase_order_details.purchase_order_id', $purchaseorder_id);
//        $this->db->order_by('purchase_order_details.product_id');
//        $query = $this->db->get_compiled_select('purchase_order_details');
//        echo $query;exit();
        

        $sql="SELECT * 
                FROM purchase_order_details 
                JOIN business_products bp ON bp.id_business_products = purchase_order_details.product_id
                JOIN business_brands bb ON bb.id_business_brands = bp.brand_id 
                LEFT JOIN (

                        select grn_product_id, ifnull(sum(grn_qty_received),0) as received, grn_unit_price,
                        ifnull(sum(returned),0) returned 
                        FROM goods_received_note as grn 
                        JOIN grn_details gd ON gd.grn_id = grn.grn_id 
                        left JOIN 
                                (
                                select grn_id, product_id, ifnull(sum(return_qty),0) as returned 
                                from return_notes group by product_id
                                )  as b on b.grn_id = gd.grn_id and b.product_id=gd.grn_product_id

                        where grn.purchase_order_id = '".$purchaseorder_id."'
                        group by grn_product_id


                ) a on purchase_order_details.product_id = a.grn_product_id
                WHERE purchase_order_details.purchase_order_id = '".$purchaseorder_id."' 
                ORDER BY purchase_order_details.product_id";
        
        $query = $this->db->query($sql);
        
        return $query->result_array();
    }

    //This function is using for already received qty in Good received Note
    public function get_grn_received_sum($purchaseorder_id) {
        $this->db->select('gd.grn_product_id, sum(gd.grn_qty_received) as received_sum');
        $this->db->join('grn_details gd', 'gd.grn_id = grn.grn_id');
        $this->db->where('grn.purchase_order_id', $purchaseorder_id);
        $this->db->group_by('gd.grn_product_id');
        $this->db->order_by('gd.grn_product_id');
        $query = $this->db->get('goods_received_note grn');
        if ($query->result_array()) {
            return $query->result_array();
        } else {
            $this->db->select('0 as received_sum');
            $query = $this->db->get('goods_received_note grn');
            return $query->result_array();
        }
    }

    function update_order() {
        // Unescape the string values in the JSON array
        $tableData = stripcslashes($_POST['orderdata']);

        // Decode the JSON array
        $tableData = json_decode($tableData, TRUE);

        // now $tableData can be accessed like a PHP array
        //echo $tableData[0]['servicename'];
        //echo $this->input->post('visitid');
        //update customer_visit

        $this->db->where('customer_order_id', $this->input->post('orderid', TRUE));
        $this->db->delete('order_products');

        foreach ($tableData as $row) {

            $data = array(
                'business_id' => $this->session->userdata('businessid'),
                'customer_order_id' => $this->input->post('orderid', TRUE),
                'product_id' => $row['productid'],
                'product_name' => $row['productname'],
                'staff_id' => $row['staffid'],
                'staff_name' => $row['staff'],
                'qty' => $row['qty']
            );

            $this->db->insert('order_products', $data);
        }
        return $this->input->post('orderid');
    }

    function grn_addupdate() {
        //exit();
        // Unescape the string values in the JSON array
        $tableData = stripcslashes($_POST['orderdata']);

        // Decode the JSON array
        $tableData = json_decode($tableData, TRUE);

        // now $tableData can be accessed like a PHP array
        // echo $tableData[0]['servicename'];
        //add new customer_visit
        
        $businessid = $this->session->userdata('businessid');
        $store = $this->product_model->get_business_store();
        if(!null == $store){
            $storeid=$store->id_business_stores;
        }
        if(null!==$tableData[0]['businessid']){
            $businessid=$tableData[0]['businessid'];
        } 
        
        
        $order = array(
            'business_id' => $businessid,
            'grn_vendor_name' => $this->input->post('suppliername'),
            'purchase_order_id' => $this->input->post('purchaseorder_id'),
            'created_by' => $this->session->userdata('username')
        );
        
        
        
        $this->db->insert('goods_received_note', $order);
        $order_id = $this->db->insert_id();
       
        
        $GRN_number = $this->update_grn_number($order_id);

        $data = [];

        foreach ($tableData as $row) {
            if((float)$row['receivedQty'] > 0){//work only if recevied > 0
            //
            //
                
                
                
                //handle batches
                $batch_id = 0;
                if(isset($row['grnbatchid'])){ $batch_id= $row['grnbatchid'];}
                if($row['grnbatchnumber']==""){ //create new batch
                    $my_batch='0001';
                    $sql="SELECT LPAD(max(CAST(batch_number AS UNSIGNED))+1,4,0) as m FROM product_batch where product_id=". $row['productid'];
                    $query = $this->db->query($sql);
                    $max_batch=$query->row(); 
                    if ($max_batch && $max_batch->m!==null){$my_batch=$max_batch->m;}
                    $futureDate=$row['expiry_date'];
                    if($row['expiry_date']==""){
                        $futureDate=date('Y-m-d', strtotime('+1 year'));
                    }

                    $this->db->set('product_id', $row['productid']);
                    $this->db->set('batch_number', $my_batch);
                    $this->db->set('batch_date', date("Y-m-d"));
                    $this->db->set('expiry_date', $futureDate);
                    $this->db->set('store_id', $storeid);
                    $this->db->set('batch_amount', $row['productunitprice']);
                    //New scenario where grn count is used to get the purchased qty
                  //  $this->db->set('batch_qty', (float)$row['receivedQty']);                
                    $this->db->insert('product_batch');
                    
                    $batch_id = $this->db->insert_id();
                    
                    
                    //insert GRN Details
                    if($row['grnbatchnumber']==''){$grn_batch_number=$my_batch;}else{$grn_batch_number=$row['grnbatchnumber'];}

                    $data = array(
                        'grn_id' => $order_id,
                        'grn_brand_id' => $row['brandid'],
                        'grn_product_id' => $row['productid'],
                        'grn_brand_name' => $row['brandname'],
                        'grn_product_name' => $row['productname'],
                        'grn_unit_price' => $row['productunitprice'],
                        'grn_qty_received' => $row['receivedQty'],
                        'grn_batch_number' => $grn_batch_number,
                        'grn_batch_id' => $batch_id
                    );
                    $this->db->insert('grn_details', $data);
                    
                    
                } else { 
                    //insert GRN Details
                    if($row['grnbatchnumber']==''){$grn_batch_number=$my_batch;}else{$grn_batch_number=$row['grnbatchnumber'];}

                    $data = array(
                        'grn_id' => $order_id,
                        'grn_brand_id' => $row['brandid'],
                        'grn_product_id' => $row['productid'],
                        'grn_brand_name' => $row['brandname'],
                        'grn_product_name' => $row['productname'],
                        'grn_unit_price' => $row['productunitprice'],
                        'grn_qty_received' => $row['receivedQty'],
                        'grn_batch_number' => $grn_batch_number,
                        'grn_batch_id' => $batch_id
                    );
                    $this->db->insert('grn_details', $data);
                    
                    //update existing batch
                    //New scenario where grn count is used to get the purchased qty
                    $this->db->select('grn_batch_id, round(sum(grn_unit_price*grn_qty_received)/sum(grn_qty_received),2) as avg_unit_cost', false);
                    $this->db->where('grn_batch_id', $batch_id);
                    $this->db->group_by('grn_batch_id');
                    $q = $this->db->get('grn_details');

                    $all_grn=$q->row();
                    if($all_grn){
                        $grn_unit_cost=$all_grn->avg_unit_cost;
                    }else {
                        $grn_unit_cost=0;            
                    }

                    $this->db->select('batch_id, round(sum(unit_price*adjustment_qty)/sum(adjustment_qty),2) as avg_unit_cost', false);
                    $this->db->where('batch_id', $batch_id);
                    $this->db->where('adjustment_qty >', 0);
                    $this->db->group_by('batch_id');
                    $z = $this->db->get('adjustment_notes');

                    $all_adjustments=$z->row();
                    if($all_adjustments){
                        $adjustment_unit_cost=$all_adjustments->avg_unit_cost;
                    }else {
                        $adjustment_unit_cost=0;            
                    }



                    if($grn_unit_cost>0 && $adjustment_unit_cost>0){
                        $final_unit_cost= ($grn_unit_cost+$adjustment_unit_cost)/2;
                    } else {
                        $final_unit_cost= $grn_unit_cost+$adjustment_unit_cost;
                    }

                    $this->db->set('batch_amount', $final_unit_cost);  
                    $this->db->where('id_batch=',$batch_id);
                    $this->db->update('product_batch');

                }

                
           
            }
        }
        if($this->input->post('ordered_qty')==$this->input->post('received_qty')+$this->input->post('received_now')){
           $po = $this->purchase_order_status('Received',$this->input->post('purchaseorder_id'));
        }
        
        
        
        
        
        return 'success|'.$GRN_number;
    }

    
    function return_note_addupdate(){
        //exit();
        // Unescape the string values in the JSON array
        $tableData = stripcslashes($_POST['orderdata']);

        // Decode the JSON array
        $tableData = json_decode($tableData, TRUE);
        $data = [];
        
        foreach ($tableData as $row) {
             
             if($row['returnQty']>0){
                 
                 //update batch
               // $this->db->set('batch_qty ', 'batch_qty-'.(float)$row['returnQty'], false);                
               // $this->db->where('id_batch=',$row['grnbatchid']);
               
               // $this->db->update('product_batch');
                 
                
                //create return note                
                $data=array(
                    'return_date' => date('Y-m-d'),
                    'batch_id' => $row['grnbatchid'],
                    'product_id' => $row['productid'],
                    'user_id' => $this->session->userdata('userid'),
                    'business_id' => $this->input->post('businessid'),
                    'grn_id' => $this->input->post('grn_id'),
                    'return_qty' => $row['returnQty']
                );
                
               
                $this->db->insert('return_notes', $data);
                
             }
             
         }
        
        
    }
    
    
    function purchnaseorder_qty_update($poid, $bid, $pid, $rqty, $instock, $inhouse) {
        $this->db->select('sum(product_received_qty) as rqty');
        $this->db->where('purchase_order_id', $poid);
        $this->db->where('brand_id', $bid);
        $this->db->where('product_id', $pid);
        $query = $this->db->get('purchase_order_details');

        $result = $query->result_array();
        //$qtyreceived = $rqty + $result[0]['rqty'];
        $qtyreceived = $rqty;

        $data = array(
            'product_received_qty' => $qtyreceived,
            'product_instock_qty' => $instock,
            'product_inhouse_qty' => $inhouse
        );
        $this->db->where('purchase_order_id', $poid);
        $this->db->where('brand_id', $bid);
        $this->db->where('product_id', $pid);
        $this->db->update('purchase_order_details', $data);

        return $this->input->post('purchaseorder_id', TRUE);
    }

    //This function is updating instock inhouse in business_product table
    function grn_product_instock_inhouse_update($poid, $bid, $pid, $in_stock, $inhouse_stock) {
        $this->db->select('in_stock, inhouse_stock');
        $this->db->where('brand_id', $bid);
        $this->db->where('id_business_products', $pid);
        $query = $this->db->get('business_products');

        $result = $query->result_array();
        $instock_exist = $in_stock + $result[0]['in_stock'];
        $inhouse_stock_exist = $inhouse_stock + $result[0]['inhouse_stock'];

        $data = array(
            'in_stock' => $instock_exist,
            'inhouse_stock' => $inhouse_stock_exist
        );
        $this->db->where('brand_id', $bid);
        $this->db->where('id_business_products', $pid);
        $this->db->update('business_products', $data);

        return $poid;
    }

    function purchase_order_status($status, $poid) {
        $data = array(
            'status' => $status
        );
        $this->db->where('idpurchase_order', $poid);
        $this->db->update('purchase_order', $data);

        return $this->input->post('purchaseorder_id', TRUE);
    }

    function update_grn_number($last_insert_id) {
        $this->db->select('*');
        $query = $this->db->get('goods_received_note');
        $number_rows = $query->num_rows();

        $grn_number = 'GRN' . date('Yd') . $last_insert_id . '' . $number_rows . '';
        $data = array(
            'grn_number' => $grn_number
        );
        $this->db->where('grn_id', $last_insert_id);
        $this->db->update('goods_received_note', $data);
        return $grn_number;
    }

    function get_grn_purchase_orders() {
        $this->db->select('*');
        //$this->db->where('status', 'Delivered');
        //$this->db->or_where('status', 'partial');
        $query = $this->db->get('purchase_order');

        return $query->result_array();
    }

    function get_po_grns($purchaseorder_id) {
        
        $this->db->select('grn.grn_id, gd.grn_detail_id, grn_number, date_format(grn_created_date,"%d-%m-%Y %h:%i") d, '
                . 'bb.business_brand_name, product, grn_unit_price, grn_batch_number, '
                . 'grn_qty_received as received, ifnull(sum(return_qty),0) as returned',false);
        $this->db->join('grn_details gd', 'gd.grn_id = grn.grn_id');
        $this->db->join('business_products bp', 'gd.grn_product_id = bp.id_business_products');
        $this->db->join('business_brands bb', 'bp.brand_id = bb.id_business_brands');
        $this->db->join('return_notes rn', 'grn.grn_id = rn.grn_id and rn.product_id = gd.grn_product_id and rn.batch_id = gd.grn_batch_id', 'left');
        $this->db->where('grn.purchase_order_id', $purchaseorder_id);
        $this->db->group_by('grn_id, gd.grn_detail_id');
        $query = $this->db->get('goods_received_note as grn');
        
       //echo $query; exit(); 
       // $query = $this->db->query($sql);
        
        return $query->result_array();
    }
    
    
    
    
    function get_grn_for_create($purchaseorder_id){

        
        $sql="SELECT * , ifnull(a.received,0) as received_qty
                FROM purchase_order_details 
                JOIN business_products bp ON bp.id_business_products = purchase_order_details.product_id
                JOIN business_brands bb ON bb.id_business_brands = bp.brand_id
                JOIN purchase_order po on po.idpurchase_order = purchase_order_details.purchase_order_id
                JOIN business on business.id_business = po.business_id
                LEFT JOIN (

                        select grn_product_id, ifnull(sum(grn_qty_received),0) as received, 
                        returned 
                        FROM goods_received_note as grn 
                        JOIN grn_details gd ON gd.grn_id = grn.grn_id 
                        left JOIN 
                                (
                                select grn_id, product_id, ifnull(sum(return_qty),0) as returned 
                                from return_notes group by product_id
                                )  as b on b.grn_id = gd.grn_id and b.product_id=gd.grn_product_id

                        where grn.purchase_order_id = '".$purchaseorder_id."'
                        group by grn_product_id


                ) a on purchase_order_details.product_id = a.grn_product_id
                WHERE purchase_order_details.purchase_order_id = '".$purchaseorder_id."' 
                ORDER BY purchase_order_details.product_id";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_grn_by_id($grn_id){
        
        $this->db->select('b.business_name, b.id_business, business_supplier.supplier_name, business_supplier.contact_number, business_supplier.ho_address, 
                        po.idpurchase_order, po.purchase_order_number, grn.grn_number, 
                        grn_detail_id, grn.grn_id, bp.product, bb.business_brand_name, grn_qty_received, 
                        grn_unit_price, grn_batch_number, grn_batch_id, date_format(grn_created_date,"%y-%m-%d") as grn_date,
                        date_format(grn_created_date,"%d-%m-%Y") as grn_date_print,
                        date_format(expiry_date,"%d-%m-%Y") as expiry_date,
                        grn_brand_id, grn_product_id');
        $this->db->join('product_batch pb', 'pb.id_batch = gd.grn_batch_id');
        $this->db->join('business_products bp', 'bp.id_business_products = gd.grn_product_id');
        $this->db->join('business_brands bb', 'bb.id_business_brands = gd.grn_brand_id');
        $this->db->join('goods_received_note grn', 'grn.grn_id=gd.grn_id');
        $this->db->join('purchase_order po', 'po.idpurchase_order = grn.purchase_order_id');
        $this->db->join('business b', 'b.id_business = po.business_id');
        $this->db->join('business_supplier', 'po.supplier_id = business_supplier.id_business_supplier');
        $this->db->where('gd.grn_id=', $grn_id);
        $query=$this->db->get('grn_details gd');
        
        return $query->result_array();
        
    }
    
    function get_grn_list_detail($purchaseorder_id) {
        $this->db->select('grn_number, grn.created_by as username, gd.grn_detail_id,  '
                . 'gd.grn_brand_id, gd.grn_product_id, gd.grn_brand_name, gd.grn_product_name, '
                . 'gd.grn_qty_received, gd.grn_unit_price, gd.grn_batch_number, DATE_FORMAT(grn.grn_created_date, "%d-%m-%Y") as grn_created_date, '
                . 'grn.created_by');
        $this->db->join('grn_details gd', 'gd.grn_id = grn.grn_id');
        $this->db->where('grn.purchase_order_id', $purchaseorder_id);
        $query = $this->db->get('goods_received_note as grn');

        return $query->result_array();
    }

    function edit_purchaseorder($purchaseorder_id) {
        $this->db->select('po.idpurchase_order, po.supplier_id, po.supplier_name, po.order_date');
        $this->db->where('po.idpurchase_order', $purchaseorder_id);
        $query = $this->db->get('purchase_order po');

        return $query->result_array();
    }

    function edit_purchaseorder_detail($purchaseorder_id) {
        $this->db->select('pod.brand_id,pod.brand_name,pod.product_id,pod.product_name,pod.product_purchase_price,product_qty');
        $this->db->where('pod.purchase_order_id', $purchaseorder_id);
        $query = $this->db->get('purchase_order_details pod');

        return $query->result_array();
    }

    function updatepurchase_orders() {
        $this->db->where('purchase_order_id', $this->input->post('purchaseorder_id', TRUE));
        $result = $this->db->delete('purchase_order_details');
        if ($result) {
            // Unescape the string values in the JSON array
            $tableData = stripcslashes($this->input->post('orderdata', TRUE));

            // Decode the JSON array
            $tableData = json_decode($tableData, TRUE);

            // now $tableData can be accessed like a PHP array
            // echo $tableData[0]['servicename'];
            //add new customer_visit
            $total_qty = 0;
            $total_price = 0;
            foreach ($tableData as $row1) {
                $total_price += $row1['productprice'] * $row1['productqty'];
                $total_qty += $row1['productqty'];
            }
            $order = array(
                'business_id' => $this->session->userdata('businessid'),
                'supplier_id' => $tableData[0]['supplierid'],
                'supplier_name' => $tableData[0]['suppliername'],
                'total_purchase_pirce' => $total_price,
                'product_total_qty' => $total_qty,
                'order_date' => $tableData[0]['orderdate'],
                'created_by' => $this->session->userdata('username')
            );
            $this->db->where('idpurchase_order', $this->input->post('purchaseorder_id', TRUE));
            $this->db->update('purchase_order', $order);
            $order_id = $this->input->post('purchaseorder_id', TRUE);

            $data = [];

            foreach ($tableData as $row) {

                $data = array(
                    'purchase_order_id' => $order_id,
                    'brand_id' => $row['brandid'],
                    'brand_name' => $row['brandname'],
                    'product_id' => $row['productid'],
                    'product_name' => $row['productname'],
                    'product_purchase_price' => $row['productprice'],
                    'product_qty' => $row['productqty']
                );

                $this->db->insert('purchase_order_details', $data);
            }

            return $order_id;
        }
    }

    function updategrn() {

        //Fetch instock inhouse from business product table....
        $this->db->select('in_stock, inhouse_stock');
        $this->db->where('id_business_products', $this->input->post('grn_product_id'));
        $this->db->where('brand_id', $this->input->post('grn_brand_id'));
        $query = $this->db->get('business_products');

        $result = $query->row();

        $instock_qty = $result->in_stock; //exist instock qty
        $inhouse_qty = $result->inhouse_stock; //exist inhouse qty

        $new_instock = $instock_qty - $this->input->post('instock_orignal'); //exist instock - with grn instock 
        $new_inhouse = $inhouse_qty - $this->input->post('inhouse_orignal'); //exist inhouse - with grn inhouse

        $new_instock = $new_instock + $this->input->post('grn_qty_instock'); //add new instock qty
        $new_inhouse = $new_inhouse + $this->input->post('grn_qty_inhouse'); //add inhouse qty
        //Update instock inhouse in business product table...
        $data = array(
            'in_stock' => $new_instock,
            'inhouse_stock' => $new_inhouse,
        );

        $this->db->where('id_business_products', $this->input->post('grn_product_id'));
        $this->db->where('brand_id', $this->input->post('grn_brand_id'));
        $this->db->update('business_products', $data);

        $data = array(
            'grn_unit_price' => $this->input->post('grn_unit_price'),
            'grn_qty_received' => $this->input->post('grn_qty_received'),
            'grn_qty_instock' => $this->input->post('grn_qty_instock'),
            'grn_qty_inhouse' => $this->input->post('grn_qty_inhouse')
        );

        $this->db->where('grn_detail_id', $this->input->post('grn_detail_id'));
        $this->db->update('grn_details', $data);

        return $this->input->post('grn_detail_id');
    }
    function get_product_batches($product_id){
        $this->db->select('*');
        $this->db->join('business_stores','business_stores.id_business_stores = product_batch.store_id');
        $this->db->where('product_id = ', $product_id);
        $query = $this->db->get('product_batch');
        
        return $query->result_array();
        
    }
}
