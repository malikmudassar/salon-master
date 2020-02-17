<?php

class Product_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_unittypes(){
        $this->db->select("*");
      
        $query =$this->db->get("unit_type");
        
        return $query->result_array();
        
    }
    
    function get_stores(){
        
        $this->db->select("*");
        $this->db->join("business","business.id_business=business_stores.business_id");
        $query =$this->db->get("business_stores");
        
        return $query->result_array();
    }
    
    function get_business_stores(){
        
        $this->db->select("*");
        $this->db->join("business","business.id_business=business_stores.business_id");
        $this->db->where("id_business",$this->session->userdata('businessid'));
        $query =$this->db->get("business_stores");
        
        return $query->result_array();
    }
    
    function get_business_store(){
        
        $this->db->select("*");
        $this->db->where("business_id", $this->session->userdata('businessid'));
        $query =$this->db->get("business_stores");
        
        return $query->row();
    }
    
    function get_instock_products($show_inhouse) {
        
        $this->db->select("*, IFNULL(business_products.category, '') as mcategory");
        $this->db->join('business_brands', 'business_brands.id_business_brands = business_products.brand_id');
        $this->db->where('in_stock >', 0);
        if($show_inhouse=='Yes'){
            $this->db->or_where('inhouse_stock >', 0);
        }
        $this->db->where('business_product_active', 'Yes');
       // $this->db->where('professional', 'n');
        $this->db->where('business_products.business_id', $this->session->userdata('businessid'));
        $this->db->order_by('business_products.brand_id', 'ASC');
        $this->db->order_by('business_products.category', 'ASC');
        $query = $this->db->get('business_products');

        return $query->result_array();
    }
    
    function get_searched_products($show_inhouse, $showprofessional, $dispatch="", $business_id="", $store_id="") {
        //echo $business_id;exit();
        $phrase=  strtoupper( $this->input->get('productname'));
        $match = explode(' ',$phrase);
        
        $phrase =  str_replace(' ','%',$phrase);
        
        $business = $this->input->get('businessid');
        if(!null == $business && $business!==""){
            $business_id=$business;
        }
        
        $store = $this->input->get('storeid');
        if(!null == $store && $store!==""){
            $store_id=$store;
        }
        
        $sql="SELECT *, IFNULL(business_products.category, '') as mcategory, 
                ifnull(adj.addition,0) total,
                ifnull(f.qty_purchased,0) purchased,
                ifnull(g.transfer_in, 0) transferin,
                ifnull(g.transfer_out  , 0) transferout,
                ifnull(a.sold,0) sold,
                ifnull(b.used,0) used,
                ifnull(c.returned,0) returned,
                
                (ifnull(adj.addition,0) + ifnull(f.qty_purchased,0)+ ifnull(g.transfer_in, 0))-(ifnull(g.transfer_out  , 0) + ifnull(a.sold,0)+ifnull(b.used,0)+ifnull(c.returned,0)) as instock, 
                business_store,
                batch_number as batch,
                product_batch.id_batch as batch_id,
                ifnull(unit_type,'') unit_type, ifnull(measure_unit,'') measure_unit, ifnull(qty_per_unit,'') qty_per_unit,
                concat(id_business_products, ', ', (ifnull(adj.addition,0) + ifnull(f.qty_purchased,0)+ ifnull(g.transfer_in, 0))-(ifnull(g.transfer_out  , 0) + ifnull(a.sold,0)+ifnull(b.used,0)+ifnull(c.returned,0)), ', ', `product`, ', ', ifnull(category,''), ', ', ifnull(batch_number,''), ', ', ifnull(id_batch,0), ', ', ifnull(unit_type,''), ', ', ifnull(measure_unit,''), ', ', ifnull(qty_per_unit,'')) as 'id'
                FROM `business_products`
                JOIN `business_brands` ON `business_brands`.`id_business_brands` = `business_products`.`brand_id`
                join product_batch on product_batch.product_id = business_products.id_business_products
                join business_stores on business_stores.id_business_stores = product_batch.store_id  ";
                if($store_id!==""){
                    $sql.= " and business_stores.id_business_stores = ".$store_id." ";
                }
//                if($business_id!==""){
//                
//                        $sql.=" AND business_stores.business_id = " . $business_id . " ";
//                    }
                $sql.=" 
                    LEFT JOIN (
                        SELECT batch_id, product_id, sum(ifnull(adjustment_qty,0)) as 'addition'
                        from adjustment_notes
                        group by batch_id, product_id
                    ) as adj
                    on adj.product_id = business_products.id_business_products 
			and adj.batch_id=product_batch.id_batch 
                    left Join
                        (
                            SELECT batch_id,  product_batch.product_id, sum(invoice_qty) as sold FROM invoice_products
                            join invoice on invoice.id_invoice = invoice_products.invoice_id
                            join product_batch on product_batch.id_batch = invoice_products.batch_id
                            
                            and invoice_status = 'valid'
                            and reference_invoice_number = ''
                            and ifnull(batch_id,0) != 0";
                            //and invoice_products.business_id= ".$this->session->userdata('businessid')." ";
//                    if($this->session->userdata('common_products')=='No'){
//                        $sql.=" and invoice_products.business_id= ".$this->session->userdata('businessid')." ";
//                    } 
                    $sql.=" group by batch_id, product_id
			) as a
			on a.product_id = business_products.id_business_products 
			and a.batch_id=product_batch.id_batch
                    left join(
                            SELECT product_id, batch, batch_id, sum(ifnull(dispatch_qty,0)) as used 
                            FROM dispatch_notes
                            where status = 'Active'
                            and ifnull(batch_id,0) != 0 ";
//                            if($this->session->userdata('common_products')=='No'){
//                               $sql.= " and dispatch_notes.business_id = ".$this->session->userdata('businessid')." ";
//                            } 
                           $sql .=" group by product_id, batch, batch_id
			) as b
                        on b.product_id = business_products.id_business_products 
			and b.batch_id = product_batch.id_batch
                    left join(
                            SELECT product_id, batch_id, sum(ifnull(return_qty,0)) as returned
                            FROM return_notes
                            where return_status = 'Active' 
                            and ifnull(batch_id,0) != 0 ";
//                           if($this->session->userdata('common_products')=='No'){
//                                $sql.="  and return_notes.business_id = ".$this->session->userdata('businessid')." ";
//                           } 
                            $sql.=" group by product_id,  batch_id
                    ) as c
                    on c.product_id = business_products.id_business_products 
                    and c.batch_id = product_batch.id_batch   ";
       //Add transfer in / Out and purchased qty             
            $sql.=" left join(
			SELECT grn_product_id, grn_batch_id, sum(ifnull(grn_qty_received,0)) as qty_purchased
			FROM grn_details
                        join goods_received_note on goods_received_note.grn_id = grn_details.grn_id
                        join purchase_order on idpurchase_order = goods_received_note.purchase_order_id
			where grn_batch_id is not null 
                        and purchase_order.status!='Cancelled'";
//                        if($this->session->userdata('common_products')=='No'){
//                            $sql.="  and goods_received_note.business_id = ".$this->session->userdata('businessid')." ";
//                        } 
                $sql.=" group by grn_product_id, grn_batch_id
		) as f
		on f.grn_product_id = business_products.id_business_products
		and grn_batch_id= product_batch.id_batch
                left join(
			SELECT product_id, batch_id, sum(ifnull(tranfer_out_qty,0)) as transfer_out, sum(ifnull(tranfer_in_qty,0)) as transfer_in 
			FROM transfer_notes 
			where batch_id is not null
                        and transfer_notes.status='Active' ";
//                        if($this->session->userdata('common_products')=='No'){
//                            $sql.="  and transfer_notes.business_id = ".$this->session->userdata('businessid')." ";
//                        } 
		$sql.="	group by product_id, batch_id
		) as g
                on g.product_id = business_products.id_business_products
		and g.batch_id=product_batch.id_batch
            ";


            $sql.="    WHERE business_product_active = 'Yes' ";
            if($dispatch==="")    {
                //$sql.= " And (ifnull(batch_qty,0))- (ifnull(a.sold,0) + ifnull(b.used,0))  >= 1 ";
                $sql.= " AND (ifnull(adj.addition,0) + ifnull(f.qty_purchased,0)+ ifnull(g.transfer_in, 0))-(ifnull(g.transfer_out  , 0) + ifnull(a.sold,0)+ifnull(b.used,0)+ifnull(c.returned,0))   >= 1 ";
            }
            if($showprofessional=='No'){
                $sql.=" And professional = 'n' ";            
            }
//            if($show_inhouse=='No'){
//               $sql.="And ifnull(batch_in_stock,0)-ifnull(batch_used,0) > 0 ";            
//            } else {
//                $sql.="And (ifnull(batch_in_stock,0)-ifnull(batch_used,0)) + (ifnull(batch_in_house,0)-ifnull(batch_sold,0)) > 0 ";
//            }
            if($this->session->userdata('common_products')=='No'){
                $sql.="AND `business_products`.`business_id` = ".$this->session->userdata('businessid')." ";
            } 
            
            if($business_id!==""){
                $sql .= " and business_stores.business_id= " . $business_id. " ";
            }
            
            $sql .=" And (
                upper(concat(business_brand_name,' ', product,' ', IFNULL(business_products.category, '') )) LIKE '%".$phrase."%' 
                OR  upper(concat(product,' ', business_brand_name,' ', IFNULL(business_products.category, '') )) LIKE '%".$phrase."%' 
                OR  upper(concat(product,' ', IFNULL(business_products.category, '') ,' ', business_brand_name)) LIKE '%".$phrase."%' 
                OR  upper(concat(IFNULL(business_products.category, '') , ' ', product, ' ', business_brand_name)) LIKE '%".$phrase."%' 
                OR  upper(concat(business_brand_name, ' ', IFNULL(business_products.category, '') , ' ', product)) LIKE '%".$phrase."%' 
                OR  IFNULL(business_products.barcode_products, '') like '%".$phrase."%'
                OR  upper(id_business_products) LIKE '%".$phrase."%'    
                )
                ORDER BY `business_products`.`brand_id` ASC, `business_products`.`product` ASC, `business_products`.`category` ASC, expiry_date ASC
                ";
       
         //   echo $sql;
        $query = $this->db->query($sql);        
        
       
        return $query->result_array();
    }

    function get_inhouse_products() {

        $this->db->select("*");
        $this->db->join('business_brands', 'business_brands.id_business_brands = business_products.brand_id');
        //$this->db->where('inhouse_stock >', 0);
         if($this->session->userdata('common_products')=='Yes'){
        $this->db->where('business_products.business_id', $this->session->userdata('businessid'));
         }
        $query = $this->db->get('business_products');

        return $query->result_array();
    }

    function get_inhouse_products_by_service($service_id) {
        $this->db->select("*");
        $this->db->join('services_products sp', 'bp.id_business_products = sp.business_product_id');
        $this->db->where('sp.business_service_id', $service_id);
        //$this->db->where('bp.business_id', $this->session->userdata('businessid'));
        $query = $this->db->get('business_products bp');
        
        return $query->result();
    }

    function get_all_brands($active=null) {

        $this->db->select("*");
        if($this->session->userdata('common_products')=='No'){
            $this->db->where('business_brands.business_id', $this->session->userdata('businessid'));
        }
        if($active && $active=='yes'){
            $this->db->where('business_brands.business_brand_active', 'Yes');
        }
        $query = $this->db->get('business_brands');
        return $query->result_array();
    }

    //Brand call by supplier id......
    function get_all_brands_by_supplier($supplierid) {

        $this->db->select("*");
         if($this->session->userdata('common_products')=='Yes'){
        $this->db->where('business_brands.business_id', $this->session->userdata('businessid'));
         }
        $this->db->where('business_brands.supplier_id', $supplierid);
        $query = $this->db->get('business_brands');

        return $query->result_array();
    }

    function delete_brand() {

        $this->db->where('id_business_brands', $this->input->post('id_business_brands', TRUE));
        $this->db->delete('business_brands');
        return $this->db->affected_rows();
    }

    function update_brand() {

        $data = array(
            'business_brand_name' => $this->input->post('business_brand_name', TRUE),
            'business_brand_short' => $this->input->post('business_brand_short', TRUE),
            'business_brand_website' => $this->input->post('business_brand_website', TRUE),
            'business_brand_active' => $this->input->post('business_brand_active', TRUE)
        );

        $this->db->where('id_business_brands', $this->input->post('id_business_brands', TRUE));
        //$this->db->where('business_brands.business_id', $this->session->userdata('businessid'));
        $this->db->update('business_brands', $data);

        return $this->db->affected_rows();
    }

    function add_brand() {

        $data = array(
            'business_brand_name' => $this->input->post('business_brand_name', TRUE),
            'business_brand_short' => $this->input->post('business_brand_short', TRUE),
            'business_brand_website' => $this->input->post('business_brand_website', TRUE),
            'business_id' => $this->session->userdata('businessid')
        );

        $this->db->insert('business_brands', $data);
        return $this->db->insert_id();
    }

    function get_brand_byid($id) {
        $this->db->select('*');
        if($this->session->userdata('common_products')=='No'){
            $this->db->where('business_brands.business_id', $this->session->userdata('businessid', TRUE));
        }
        $this->db->where('id_business_brands=', $id);
        $query = $this->db->get('business_brands');
        return $query->result_array();
    }

    function get_all_products($scid = 0, $tagged = "", $active=null, $business_id="", $store_id="") {
        $sql='';
        if ($tagged && $tagged === "threshold") {
                $sql .= " select * from (";
        } 
        
        $sql .= "SELECT id_business_products, business_brand_name, business_products.business_id, brand_id, product,
            sku, price, purchase_price, unit_type, measure_unit, qty_per_unit, business_product_active, category, professional,
            product_threshold, barcode_products,
            ifnull(adj.addition, 0) as Qty,
            ifnull(f.qty_purchased,0) purchased,
            ifnull(g.transfer_in  , 0) transfer_in,
            ifnull(g.transfer_out  , 0) transfer_out,
            ifnull(a.sold,0) as sold,
            ifnull(b.used,0) as used,
            ifnull(c.returned,0) as returned,
            (ifnull(adj.addition, 0)+ ifnull(f.qty_purchased,0)+ ifnull(g.transfer_in  , 0)) - (ifnull(g.transfer_out  , 0) + ifnull(a.sold, 0) + ifnull(b.used, 0) + ifnull(c.returned, 0)) as total_stock 			
            FROM `business_products` 
            Join business_brands on business_brands.id_business_brands = business_products.brand_id 
            LEFT JOIN  `product_batch` `batches`  ON batches.`product_id` = `business_products`.`id_business_products` 
            
            LEFT Join (
                SELECT product_id,  sum(ifnull(adjustment_qty,0)) as addition
                from adjustment_notes
                group by  product_id
            ) as adj
            on adj.product_id = business_products.id_business_products
            LEFT Join (
                    SELECT invoice_products.product_id, sum(invoice_qty) as sold FROM invoice_products
                    join invoice on invoice.id_invoice = invoice_products.invoice_id
                    join product_batch on product_batch.id_batch = invoice_products.batch_id
                    join business_stores on business_stores.id_business_stores = product_batch.store_id
                    and invoice_status = 'valid'
                    and ifnull(reference_invoice_number,'') = ''
                    and ifnull(batch_id,0) != 0 ";
                    //and invoice_products.business_id=".$this->session->userdata('businessid')."";
//            if($this->session->userdata('common_products')=='No'){               
//                $sql.="and invoice_products.business_id= ".$this->session->userdata('businessid')." ";
//            } else if($business_id!==""){
//                $sql.="and invoice_products.business_id= ".$business_id." ";
//            }
            $sql.="         
                    group by  product_id
            ) as a
            on a.product_id = business_products.id_business_products 
            left join(
                    SELECT product_id,  sum(ifnull(dispatch_qty,0)) as used 
                    FROM dispatch_notes
                    where status = 'Active'
                    and ifnull(batch_id,0) != 0 ";
//            if($this->session->userdata('common_products')=='No'){
//                $sql.=" and dispatch_notes.business_id=".$this->session->userdata('businessid')." ";
//            } else if($business_id!==""){
//                $sql.=" and dispatch_notes.business_id=".$business_id." ";
//            }
            $sql.=" group by product_id
            ) as b
            on b.product_id = business_products.id_business_products 
            left join(
                    SELECT product_id, sum(ifnull(return_qty,0)) as returned
                    FROM return_notes
                    where return_status = 'Active'
                    and ifnull(batch_id,0) != 0 ";
//            if($this->session->userdata('common_products')=='No'){
//                $sql.=" and return_notes.business_id=".$this->session->userdata('businessid')." ";
//            } else if($business_id!==""){
//                $sql.=" and return_notes.business_id=".$business_id." ";
//            }
            $sql.=" group by product_id
            ) as c
            on c.product_id = business_products.id_business_products ";
            ///add transfer notes & purchase orders
        $sql.="left join(
			SELECT grn_product_id, grn_batch_id, sum(ifnull(grn_qty_received,0)) as qty_purchased
			FROM grn_details
			where IFNULL(grn_batch_id, 0) != 0
			group by grn_product_id
		) as f
		on f.grn_product_id = business_products.id_business_products
		
                left join(
			SELECT product_id, batch_id, sum(ifnull(tranfer_out_qty,0)) as transfer_out, sum(ifnull(tranfer_in_qty,0)) as transfer_in 
			FROM transfer_notes
			where batch_id is not null
                        and transfer_notes.status='Active' 
			group by product_id
		) as g
                on g.product_id = business_products.id_business_products
		
            ";
            
        ////final where clauses    
        $sql.=" WHERE 1=1 ";
            if($this->session->userdata('common_products')=='No'){
                $sql.=" AND `business_products`.`business_id` = '".$this->session->userdata('businessid')."' ";
            } else if($business_id!==""){
                $sql.=" AND `business_products`.`business_id` = '".$business_id."' ";
            }
            
            if ($scid && $scid !== "0") {
                $sql .=" AND  `brand_id` = '".$scid."'  ";
            }
            if($active and $active='yes'){
                $sql .=" AND `business_product_active` = 'Yes'  ";
            }
            if ($tagged && $tagged === "professional") {
                $sql .= " AND  business_products.professional = 'y' ";
            } else if ($tagged && $tagged === "retail") {
                $sql .= " AND business_products.professional = 'n' ";
            }         
            
            $sql .= "
            GROUP BY id_business_products, business_products.business_id, brand_id, product,
            sku, price, purchase_price, unit_type, measure_unit, qty_per_unit, business_product_active, category, professional,
            product_threshold
            ORDER BY `product`";
            
            if ($tagged && $tagged === "threshold") {
                $sql .= " ) as mainQ where mainQ.total_stock <= mainQ.product_threshold";
            }    
            
        if($tagged && $tagged=="expiring"){
            $sql = $this->get_expired_products();
        }    
//            echo $sql;exit();
        $query=$this->db->query($sql);
     
        return $query->result_array();
    }
   
    function get_expired_products($business_id=""){
        //work on this
        $sql = "SELECT id_business_products, business_brand_name, business_products.business_id, brand_id, product, sku, 
                price, purchase_price, unit_type, measure_unit, qty_per_unit, business_product_active, category, expiry_date,
                professional, product_threshold, id_batch, barcode_products,
                ifnull(adj.addition, 0) as Qty, 
                ifnull(f.qty_purchased,0) purchased,
            ifnull(g.transfer_in  , 0) transfer_in,
            ifnull(g.transfer_out  , 0) transfer_out,
                ifnull(a.sold,0) as sold, 
                ifnull(b.used,0) as used, 
                ifnull(c.returned,0) as returned, 
                sum((ifnull(adj.addition, 0) + ifnull(f.qty_purchased,0) + ifnull(g.transfer_in,0)) - ( ifnull(g.transfer_out,0) + ifnull(a.sold, 0) + ifnull(b.used, 0) + ifnull(c.returned, 0))) as total_stock 
                FROM `business_products` 
                Join business_brands on business_brands.id_business_brands = business_products.brand_id 
                JOIN
                        (select product_id,expiry_date, sum(ifnull(batch_qty,0)) as batch_qty, id_batch
                        from `product_batch` `pb` 
                        join business_stores on business_stores.id_business_stores=pb.store_id
                        where round(datediff(expiry_date, now())/30) < 3 "; 
                        if($this->session->userdata('common_products')=='No'){        
                            $sql.=" and business_stores.business_id=".$this->session->userdata('businessid')." ";
                        } else if ($business_id!==""){
                            $sql.=" and business_stores.business_id=".$business_id." ";
                        }
                $sql.=" group by product_id, id_batch) as batches 
                ON batches.`product_id` = `business_products`.`id_business_products` 
                LEFT JOIN (
                        SELECT batch_id, product_id, sum(ifnull(adjustment_qty,0)) as 'addition'
                        from adjustment_notes
                        group by batch_id, product_id
                    ) as adj
                    on adj.product_id = batches.product_id
			and adj.batch_id=batches.id_batch 
                left Join 
                        (SELECT product_id, sum(invoice_qty) as sold, batch_id
                        FROM invoice_products 
                        join invoice on invoice.id_invoice = invoice_products.invoice_id 
                        and invoice_status = 'valid' 
                        and ifnull(reference_invoice_number,'') = '' and 
                        ifnull(batch_id,0) != 0 ";
//                if($this->session->userdata('common_products')=='No'){        
//                    $sql.=" and invoice_products.business_id=".$this->session->userdata('businessid')." ";
//                } else if ($business_id!==""){
//                    $sql.=" and invoice_products.business_id=".$business_id." ";
//                }
                $sql.="group by product_id, batch_id) as a 
                on a.batch_id = batches.id_batch and a.product_id=batches.product_id 
                left join
                        (SELECT product_id, sum(ifnull(dispatch_qty,0)) as used, batch_id
                        FROM dispatch_notes 
                        where status = 'Active' and ifnull(batch_id,0) != 0 ";
//                if($this->session->userdata('common_products')=='No'){
//                    $sql.=" and dispatch_notes.business_id=".$this->session->userdata('businessid')." ";
//                } else if($business_id!==""){
//                     $sql.=" and dispatch_notes.business_id=".$business_id." ";
//                }
                $sql.=" group by product_id, batch_id) as b 
                on b.batch_id= batches.id_batch and b.product_id=batches.product_id 
                left join
                        (SELECT product_id, sum(ifnull(return_qty,0)) as returned , batch_id
                        FROM return_notes where return_status = 'Active' and ifnull(batch_id,0) != 0 ";
//                if($this->session->userdata('common_products')=='No'){
//                    $sql.=" and return_notes.business_id=".$this->session->userdata('businessid')." ";
//                } else if($business_id!==""){
//                    $sql.=" and return_notes.business_id=".$business_id." ";
//                }
                $sql.=" group by product_id, batch_id) as c 
                on c.batch_id= batches.id_batch and c.product_id=batches.product_id ";
                 ///add transfer notes & purchase orders
                $sql.="left join(
                                SELECT grn_product_id, grn_batch_id, sum(ifnull(grn_qty_received,0)) as qty_purchased
                                FROM grn_details
                                where grn_batch_id is not null
                                group by grn_product_id, grn_batch_id
                        ) as f
                        on f.grn_batch_id = batches.id_batch and grn_product_id=batches.product_id

                        left join(
                                SELECT product_id, batch_id, sum(ifnull(tranfer_out_qty,0)) as transfer_out, sum(ifnull(tranfer_in_qty,0)) as transfer_in 
                                FROM transfer_notes
                                where batch_id is not null
                                and transfer_notes.status='Active' 
                                group by product_id, batch_id
                        ) as g
                        on g.batch_id = batches.id_batch and g.product_id=batches.product_id

                    ";
                $sql.=" WHERE 
                 `business_product_active` = 'Yes' ";
                if($this->session->userdata('common_products')=='No'){
                    $sql.= " And `business_products`.`business_id` = '".$this->session->userdata('businessid')."' ";
                } else if($business_id!==""){
                    $sql.= " And `business_products`.`business_id` = '".$business_id."' ";
                }
                $sql.=" and round(datediff(expiry_date, now())/30) < 3 
                and (ifnull(adj.addition, 0) + ifnull(f.qty_purchased,0) + ifnull(g.transfer_in,0)) - (ifnull(g.transfer_out,0) + ifnull(a.sold, 0) + ifnull(b.used, 0) + ifnull(c.returned, 0)) >0
                GROUP BY id_business_products
                ORDER BY `product`";
        return $sql; 
    }
    
    function get_brand_date_stock($brandid, $producttype, $startdate, $enddate, $store_id, $business_id){
        
       
        
       $sql = " SELECT business_products.id_business_products, business_brand_name, brand_id, concat(product,' ', qty_per_unit, ' ', measure_unit) as product,
        sku, price, purchase_price, unit_type, measure_unit, qty_per_unit, business_product_active, category, professional,
        product_threshold, barcode_products,batches.store_id,
        batches.id_batch, round(avg(batches.batch_amount),2) batch_amount,
        sum(ifnull(old_batches.brought_forward, 0)) as BF,
        sum(ifnull(f.qty_purchased,0)) as purchased,
        sum(ifnull(g.transfer_in,0)) transfer_in,
        sum(ifnull(g.transfer_out,0)) transfer_out,
        sum(ifnull(adj.addition, 0)) as Qty,
        sum(ifnull(a.sold,0)) as sold,
        sum(ifnull(b.used,0)) as used,
        sum(ifnull(c.returned,0)) as returned,
        sum((ifnull(old_batches.brought_forward, 0) + ifnull(adj.addition, 0) + ifnull(f.qty_purchased,0) + ifnull(g.transfer_in,0)) - (ifnull(g.transfer_out,0) + ifnull(a.sold, 0) + ifnull(b.used, 0) + ifnull(c.returned, 0))) as total_stock ,
        round( avg(batches.batch_amount) * sum((ifnull(old_batches.brought_forward, 0) + ifnull(adj.addition, 0) + ifnull(f.qty_purchased,0) + ifnull(g.transfer_in,0)) - (ifnull(g.transfer_out,0) + ifnull(a.sold, 0) + ifnull(b.used, 0) + ifnull(c.returned, 0))),2) as stock_value
        FROM `business_products` 
        Join business_brands on business_brands.id_business_brands = business_products.brand_id ";
       if($brandid!=="0"){
            $sql.=" and business_products.brand_id=".$brandid." ";
       }
        if($producttype !== "0"){
            $sql.=" and professional = '".$producttype."' ";
        }
        $sql.= " JOIN product_batch as batches on batches.`product_id` = `business_products`.`id_business_products` ";
        if($store_id!==""){
            $sql.= " and batches.store_id = ".$store_id." ";
        }
//        $sql.=" JOIN (
//                select product_id, store_id, id_batch batch_id, sum(ifnull(batch_qty,0)) as batch_qty 
//                from`product_batch` `pb` 
//                where date_format(batch_date,'%Y-%m-%d') >= '".$startdate."' and date_format(batch_date,'%Y-%m-%d')  <= '".$enddate."'  
//                group by product_id, id_batch
//                ) as batches 
//                ON batches.`product_id` = `business_products`.`id_business_products` ";
        ///brought forward
        $sql .= " LEFT JOIN (
               	SELECT id_business_products, store_id, bfbatches.id_batch,
                sum((ifnull(bfadj.addition,0) + ifnull(f.qty_purchased,0) + ifnull(g.transfer_in,0)) - (ifnull(g.transfer_out,0) + ifnull(a.sold, 0) + ifnull(b.used, 0) + ifnull(c.returned, 0))) as brought_forward
                FROM `business_products` 
                Join business_brands on business_brands.id_business_brands = business_products.brand_id ";
                if($brandid!=="0"){
                    $sql.=" and business_products.brand_id=".$brandid." ";
                }
                if($producttype !== "0"){
                    $sql.="and professional = '".$producttype."' ";
                }
         $sql.= " JOIN product_batch as bfbatches on bfbatches.`product_id` = `business_products`.`id_business_products` ";
         if($store_id!==""){
            $sql.= " and bfbatches.store_id = ".$store_id." ";
        }
//         $sql .=" JOIN (
//                        select store_id, product_id, id_batch batch_id, sum(ifnull(batch_qty,0)) as batch_qty 
//                        from`product_batch` `pb` 
//                        where date_format(batch_date,'%Y-%m-%d') < '".$startdate."' 
//                        group by product_id, id_batch
//                        ) as bfbatches 
//                        ON bfbatches.`product_id` = `business_products`.`id_business_products` ";
         $sql .="  
                LEFT Join (
                        SELECT batch_id, sum(ifnull(adjustment_qty,0)) as 'addition'
                        FROM adjustment_notes
                        Where date_format(adjustment_date,'%Y-%m-%d') < '".$startdate."'
                        group by batch_id
                        ) as bfadj
                        on bfadj.batch_id = bfbatches.id_batch
                LEFT Join (
                        SELECT product_id, batch_id, sum(invoice_qty) as sold FROM invoice_products
                        join invoice on invoice.id_invoice = invoice_products.invoice_id
                        and invoice_status = 'valid'
                        and ifnull(reference_invoice_number,'') = ''
                        and ifnull(batch_id,0) != 0
                        and date_format(invoice_date,'%Y-%m-%d') < '".$startdate."'
                        group by  product_id, batch_id
                        ) as a
                        on a.product_id = business_products.id_business_products
                        and a.batch_id = bfbatches.id_batch
                left join(
                        SELECT product_id, batch_id, sum(ifnull(dispatch_qty,0)) as used 
                        FROM dispatch_notes
                        where status = 'Active'
                        and date_format(dispatch_date,'%Y-%m-%d') < '".$startdate."' 
                        and ifnull(batch_id,0) != 0
                        group by product_id, batch_id
                        ) as b
                        on b.product_id = business_products.id_business_products 
                        and b.batch_id = bfbatches.id_batch
                left join(
                        SELECT product_id, batch_id, sum(ifnull(return_qty,0)) as returned
                        FROM return_notes
                        where return_status = 'Active'
                        and date_format(return_date,'%Y-%m-%d') < '".$startdate."'
                        and ifnull(batch_id,0) != 0
                        group by product_id, batch_id
                        ) as c
                        on c.product_id = business_products.id_business_products
                        and c.batch_id = bfbatches.id_batch ";
                ///add transfer notes & purchase orders
                $sql.="left join(
                                SELECT grn_product_id, grn_batch_id batch_id, sum(ifnull(grn_qty_received,0)) as qty_purchased
                                FROM grn_details
                                join goods_received_note on goods_received_note.grn_id = grn_details.grn_id
                                where grn_batch_id is not null
                                and  date_format(grn_created_date,'%Y-%m-%d') < '".$startdate."' 
                                group by grn_product_id, grn_batch_id
                        ) as f
                        on f.grn_product_id = business_products.id_business_products
                        and f.batch_id = bfbatches.id_batch
                        left join(
                                SELECT product_id, batch_id, sum(ifnull(tranfer_out_qty,0)) as transfer_out, sum(ifnull(tranfer_in_qty,0)) as transfer_in 
                                FROM transfer_notes
                                where batch_id is not null
                                and transfer_notes.status='Active' 
                                and  date_format(transfer_date,'%Y-%m-%d') < '".$startdate."' 
                                group by product_id, batch_id
                        ) as g
                        on g.product_id = business_products.id_business_products
                        and g.batch_id = bfbatches.id_batch
                    ";
                $sql.=" WHERE `business_product_active` = 'Yes' ";
            if($this->session->userdata('common_products')=='No'){
                $sql.=" AND  `business_products`.`business_id` = ".$this->session->userdata('businessid')." ";
            } else if($business_id!==""){
                    $sql.= " And `business_products`.`business_id` = '".$business_id."' ";
            }
            
            
            $sql.="  GROUP BY id_business_products, bfbatches.id_batch
                ) as old_batches 
                ON old_batches.`id_business_products` = `business_products`.`id_business_products` 
                and old_batches.id_batch=batches.id_batch
        
        LEFT Join (
                SELECT batch_id, sum(ifnull(adjustment_qty,0)) as 'addition' 
                FROM adjustment_notes
                Where date_format(adjustment_date,'%Y-%m-%d') >= '".$startdate."' and date_format(adjustment_date,'%Y-%m-%d')  <= '".$enddate."'  
                group by batch_id
                ) as adj
                on adj.batch_id = batches.id_batch
        LEFT Join (
                SELECT product_id, batch_id, sum(invoice_qty) as sold FROM invoice_products
                join invoice on invoice.id_invoice = invoice_products.invoice_id
                and invoice_status = 'valid'
                and ifnull(reference_invoice_number,'') = ''
                and ifnull(batch_id,0) != 0
                and date_format(invoice_date,'%Y-%m-%d') >= '".$startdate."' and date_format(invoice_date,'%Y-%m-%d')  <= '".$enddate."'  
                group by  product_id, batch_id
            ) as a
            on a.product_id = business_products.id_business_products 
            and a.batch_id = batches.id_batch
        left join(
                SELECT product_id, batch_id,  sum(ifnull(dispatch_qty,0)) as used 
                FROM dispatch_notes
                where status = 'Active'
                and date_format(dispatch_date,'%Y-%m-%d') >= '".$startdate."' and date_format(dispatch_date,'%Y-%m-%d')  <= '".$enddate."'  
                and ifnull(batch_id,0) != 0
                group by product_id, batch_id
            ) as b
            on b.product_id = business_products.id_business_products 
            and b.batch_id = batches.id_batch
        left join(
                SELECT product_id, batch_id, sum(ifnull(return_qty,0)) as returned
                FROM return_notes
                where return_status = 'Active'
                and date_format(return_date,'%Y-%m-%d') >= '".$startdate."' and date_format(return_date,'%Y-%m-%d')  <= '".$enddate."'  
                and ifnull(batch_id,0) != 0
                group by product_id, batch_id
            ) as c
        on c.product_id = business_products.id_business_products
        and c.batch_id = batches.id_batch ";
        ///add transfer notes & purchase orders
        $sql.="left join(
                        SELECT grn_product_id, grn_batch_id batch_id, sum(ifnull(grn_qty_received,0)) as qty_purchased
                        FROM grn_details
                        join goods_received_note on goods_received_note.grn_id = grn_details.grn_id
                        where grn_batch_id is not null
                        and  date_format(grn_created_date,'%Y-%m-%d') >= '".$startdate."' and date_format(grn_created_date,'%Y-%m-%d')  <= '".$enddate."'  
                        group by grn_product_id, batch_id
                ) as f
                on f.grn_product_id = business_products.id_business_products
                and f.batch_id = batches.id_batch
                left join(
                        SELECT product_id, batch_id, sum(ifnull(tranfer_out_qty,0)) as transfer_out, sum(ifnull(tranfer_in_qty,0)) as transfer_in 
                        FROM transfer_notes
                        where batch_id is not null
                        and transfer_notes.status='Active' 
                        and  date_format(transfer_date,'%Y-%m-%d') >= '".$startdate."' and date_format(transfer_date,'%Y-%m-%d')  <= '".$enddate."'   
                        group by product_id, batch_id
                ) as g
                on g.product_id = business_products.id_business_products
                and g.batch_id = batches.id_batch
            ";
        $sql.= " WHERE `business_product_active` = 'Yes' ";
        if($this->session->userdata('common_products')=='No'){
            $sql.=" AND `business_products`.`business_id` = ".$this->session->userdata('businessid')." ";
        }else if($business_id!==""){
            $sql.= " And `business_products`.`business_id` = '".$business_id."' ";
        }
         
            
        $sql.=" 
        GROUP BY id_business_products
        ORDER BY `id_business_products`";
        //echo $sql; exit();
       $query=$this->db->query($sql);
     
        return $query->result_array();
        
    }
    
    function get_services_products() {
        $this->db->select('*');
        $query = $this->db->get('services_products');

        return $query->result_array();
    }

    function add_product() {

       
        
        $data = array(
            'brand_id' => $this->input->post('brand_id', TRUE),
            'category' => $this->input->post('category', TRUE),
            'product' => str_replace("&", "-", trim($this->input->post('product', TRUE))),
            'sku' => $this->input->post('sku', TRUE),
            'commission' => $this->input->post('commission', TRUE),
            'barcode_products' => $this->input->post('barcode', TRUE),
            'price' => $this->input->post('price', TRUE),
            'purchase_price' => $this->input->post('purchase_price', TRUE),
            'measure_unit' => $this->input->post('measurement_unit', TRUE),
            'unit_type' => $this->input->post('unit_type', TRUE),
            'qty_per_unit' => $this->input->post('qty_per_unit', TRUE),
            'professional' => $this->input->post('professional', TRUE),
            'business_id' => $this->session->userdata('businessid'),
            'product_threshold'=> $this->input->post('threshold', TRUE)
        );

        $this->db->insert('business_products', $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    function update_product() {
        
        $data = array(
            'brand_id' => $this->input->post('brand_id', TRUE),
            'category' => $this->input->post('category', TRUE),
            'product' => str_replace("&", "-", trim($this->input->post('product', TRUE))),
            'sku' => $this->input->post('sku', TRUE),
            'commission' => $this->input->post('commission', TRUE),
            'barcode_products' => $this->input->post('barcode', TRUE),
            'price' => $this->input->post('price', TRUE),
            'purchase_price' => $this->input->post('purchase_price', TRUE),
            'measure_unit' => $this->input->post('measurement_unit', TRUE),
            'unit_type' => $this->input->post('unit_type', TRUE),
            'qty_per_unit' => $this->input->post('qty_per_unit', TRUE),
            'professional' => $this->input->post('professional', TRUE),
            'business_product_active' => $this->input->post('business_product_active', TRUE),
            'product_threshold'=> $this->input->post('threshold', TRUE)
        );

        $this->db->where('id_business_products', $this->input->post('id_business_products', TRUE));
       // $this->db->where('business_products.business_id', $this->session->userdata('businessid'));
        $this->db->update('business_products', $data);


        return $this->db->affected_rows();
    }

    function update_product_stock($product_id, $stock, $stockfrom, $batch) {
        
        $data='batch_sold+'.$stock;
        
        $this->db->set('batch_sold', $data);
        $this->db->where('product_id', $product_id);
        $this->db->where('batch_number', $batch);
        $this->db->update('product_batch');
        
        return $this->db->affected_rows();
    }

    function delete_product() {
        $this->db->where('id_business_products', $this->input->post('id_business_products', TRUE));
        $this->db->where('business_products.business_id', $this->session->userdata('businessid', TRUE));
        $this->db->delete('business_products');
        return $this->db->affected_rows();
    }
    
    function get_product_list($tagged = "") {
        
            $sql = "SELECT id_business_products, business_id, brand_id, product,
            sku, price, purchase_price, unit_type, measure_unit, qty_per_unit, business_product_active, category, professional,
            product_threshold, barcode_products,
            sum(ifnull(adj.addition, 0)) as Qty,
            ifnull(a.sold,0) as sold,
            ifnull(b.used,0) as used,
            ifnull(c.returned,0) as returned,
            sum(ifnull(adj.addition, 0)+ ifnull(g.transfer_in,0) +f.qty_purchased) - (ifnull(a.sold, 0) + ifnull(g.transfer_out,0)+ ifnull(b.used, 0) + ifnull(c.returned, 0)) as total_stock 
            FROM `business_products` 
            LEFT JOIN `product_batch` `pb` ON `pb`.`product_id` = `business_products`.`id_business_products` 
            LEFT join(
                    SELECT batch_id, sum(adjustment_qty) as addition FROM adjustment_notes
                    group by batch_id
            ) as adj
            on adj.batch_id = product_batch.id_batch
            LEFT Join (
                    SELECT product_id, batch_id, sum(invoice_qty) as sold FROM invoice_products
                    join invoice on invoice.id_invoice = invoice_products.invoice_id
                    and invoice_status = 'valid'
                    and ifnull(reference_invoice_number,'') = ''
                    and batch_id is not null
                    group by  product_id
            ) as a
            on a.product_id = business_products.id_business_products 
            and a.batch_id = pb.batch_id
            left join(
                    SELECT product_id, batch, batch_id, sum(ifnull(dispatch_qty,0)) as used 
                    FROM dispatch_notes
                    where status = 'Active'
                    and batch_id is not null
                    group by product_id, batch, batch_id
            ) as b
            on b.product_id = business_products.id_business_products 
            and b.batch_id = pb.batch_id
            left join(
                    SELECT product_id, batch_id, sum(ifnull(return_qty,0)) as returned
                    FROM return_notes
                    where return_status = 'Active'
                    and batch_id is not null
                    group by product_id,  batch_id
            ) as c
            on c.product_id = business_products.id_business_products 
            and .batch_id=pb.batch_id
            ";
             //Add transfer in / Out and purchased qty             
            $sql.=" left join(
			SELECT grn_product_id, grn_batch_id, sum(ifnull(grn_qty_received,0)) as qty_purchased
			FROM grn_details
                        join goods_received_note on goods_received_note.grn_id = grn_details.grn_id
                        join purchase_order on idpurchase_order = goods_received_note.purchase_order_id
			where grn_batch_id is not null 
                        and purchase_order.status!='Cancelled'
			group by grn_product_id, grn_batch_id
		) as f
		on f.grn_product_id = business_products.id_business_products
		and grn_batch_id= pb.id_batch
                left join(
			SELECT product_id, batch_id, sum(ifnull(tranfer_out_qty,0)) as transfer_out, sum(ifnull(tranfer_in_qty,0)) as transfer_in 
			FROM transfer_notes 
			where batch_id is not null
                        and transfer_notes.status='Active' 
			group by product_id, batch_id
		) as g
                on g.product_id = business_products.id_business_products
		and g.batch_id=pb.id_batch
            ";
            
            $sql.=" WHERE `business_product_active` = 'Yes'  ";
            
            if($this->session->userdata('common_products')=='No'){
               $sql.=" AND `business_products`.`business_id` = '".$this->session->userdata('businessid')."' ";
            }
            if ($tagged && $tagged === "professional") {
                $sql .= " and business_products.professional = 'y' ";
            } else if ($tagged && $tagged === "retail") {
                $sql .= "and business_products.professional = 'n' ";
            }
            $sql .= "GROUP BY id_business_products, business_id, brand_id, product,
            sku, price, purchase_price, unit_type, measure_unit, qty_per_unit, business_product_active, category, professional,
            product_threshold
            ORDER BY `product`";
        
        $query=$this->db->query($sql);
     
        return $query->result_array();
        
        
//        $this->db->select('*');
//        $this->db->join('business_brands', 'business_brands.id_business_brands = business_products.brand_id');
//        $this->db->where('business_products.business_id', $this->session->userdata('businessid'));
//
//        $query = $this->db->get('business_products');
//
//        return $query->result_array();
    }

    function add_listproduct() {//inhouse_stock......in_stock 'in_stock' => 
        $data = array(
            'brand_id' => $this->input->post('brand_id', TRUE),
            'category' => $this->input->post('category', TRUE),
            'product' => str_replace("&", "-", trim($this->input->post('product', TRUE))),
            'sku' => $this->input->post('sku', TRUE),
            'price' => $this->input->post('price', TRUE),
            'purchase_price' => $this->input->post('purchase_price', TRUE),
            'measure_unit' => $this->input->post('measurement_unit', TRUE),
            'qty_per_unit' => $this->input->post('qty_per_unit', TRUE),
            'unit_type' => $this->input->post('unit_type', TRUE),
            'professional' => $this->input->post('professional', TRUE),
            'business_id' => $this->session->userdata('businessid')
        );

        if ($this->input->post('in_retail', TRUE)) {//Instock
            $data['in_stock'] = $this->input->post('in_stock', TRUE) ? $this->input->post('in_stock', TRUE) : 0;
        } else if ($this->input->post('inhouse_professional', TRUE)) {//Inhouse stock
            $data['inhouse_stock'] = $this->input->post('inhouse_stock', TRUE) ? $this->input->post('inhouse_stock', TRUE) : 0;
        }


        $this->db->insert('business_products', $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    function update_listproduct() {
        $data = array(
            'brand_id' => $this->input->post('brand_id', TRUE),
            'category' => $this->input->post('category', TRUE),
            'product' => str_replace("&", "-", trim($this->input->post('product', TRUE))),
            'sku' => $this->input->post('sku', TRUE),
            'price' => $this->input->post('price', TRUE),
            'purchase_price' => $this->input->post('purchase_price', TRUE),
            'professional' => $this->input->post('professional', TRUE),
            'measure_unit' => $this->input->post('measurement_unit', TRUE),
            'qty_per_unit' => $this->input->post('qty_per_unit', TRUE),
            'unit_type' => $this->input->post('unit_type', TRUE),
            'business_product_active' => $this->input->post('business_product_active', TRUE)
        );

        if ($this->input->post('in_retail', TRUE)) {//In stock
            $data['in_stock'] = $this->input->post('in_stock', TRUE) ? $this->input->post('in_stock', TRUE) : 0;
        } else if ($this->input->post('inhouse_professional', TRUE)) {//In_house stock
            $data['inhouse_stock'] = $this->input->post('inhouse_stock', TRUE) ? $this->input->post('inhouse_stock', TRUE) : 0;
        }


        $this->db->where('id_business_products', $this->input->post('id_business_products', TRUE));
       // $this->db->where('business_products.business_id', $this->session->userdata('businessid'));
        $this->db->update('business_products', $data);


        return $this->db->affected_rows();
    }

    function get_measurement_unit() {
        $this->db->select('mu.id_measurement_unit, mu.m_unit');
        if($this->session->userdata('common_products')=="No"){
            $this->db->where('mu.business_id', $this->session->userdata('businessid'));
        }
        $result = $this->db->get('measurement_units mu');

        return $result->result_array();
    }
    
    function edit_brand(){
        $this->db->select('*');
        
        //    $this->db->where('bb.business_id', $this->session->userdata('businessid'));
        
        $this->db->where('bb.id_business_brands', $this->input->post('id_business_brands'));
        $query = $this->db->get('business_brands bb');

        return $query->row();
    }
    
    function edit_product(){
        $this->db->select('*');
        //$this->db->where('bp.business_id', $this->session->userdata('businessid'));
        
            $this->db->where('bp.id_business_products', $this->input->post('id_business_products'));
        
        $query = $this->db->get('business_products bp');

        return $query->row();
    }

    function get_all_batches($id, $business_id=""){
        
        $sql="SELECT *, 
        ifnull(e.addition, 0) as manualQty,
        ifnull(e.qty_purchased, 0) as purchasedQty,
        ifnull(e.transfer_in, 0) as transfer_in,
        ifnull(e.transfer_out, 0) as transfer_out,
        ifnull(e.sold,0) as sold,
        ifnull(e.used,0) as used,
        ifnull(e.returned,0) as returned,
        (ifnull(e.addition, 0) + ifnull(e.qty_purchased, 0) + ifnull(e.transfer_in, 0)) - (ifnull(e.transfer_out, 0) + ifnull(e.sold, 0) + ifnull(e.used, 0) + ifnull(e.returned, 0)) as total_stock,
        date_format(expiry_date, '%d-%m-%Y') as 'batch_expiry', 
        round(datediff(expiry_date, now())/30) as expiry,
        date_format(batch_date, '%d-%m-%Y') as 'bdate' , batch_amount
        FROM business_products
        LEFT JOIN
        (
         select id_batch, batch_number, batch_date, expiry_date, batch_qty, qty_purchased,
         product_batch.product_id, business_store, transfer_in, transfer_out,
         sold, used, returned, batch_amount, addition
         from 
	 product_batch 
                LEFT join business_stores on business_stores.id_business_stores = product_batch.store_id
                
                LEFT join(
                        SELECT batch_id, sum(adjustment_qty) as addition FROM adjustment_notes
                        group by batch_id
                ) as adj
                on adj.batch_id = product_batch.id_batch
		LEFT Join (
			SELECT batch_id, product_id, sum(invoice_qty) as sold FROM invoice_products
			join invoice on invoice.id_invoice = invoice_products.invoice_id
			and invoice_status = 'valid'
                        and ifnull(reference_invoice_number,'') = ''
			and batch_id is not null
			group by batch_id, product_id
		) as a
		on a.product_id = product_batch.product_id 
		and a.batch_id=product_batch.id_batch
		left join(
			SELECT product_id, batch, batch_id, sum(ifnull(dispatch_qty,0)) as used 
			FROM dispatch_notes
			where status = 'Active'
			and batch_id is not null
			group by product_id, batch, batch_id
		) as b
		on b.product_id = product_batch.product_id
		and b.batch_id = product_batch.id_batch
		left join(
			SELECT product_id, batch_id, sum(ifnull(return_qty,0)) as returned
			FROM return_notes
			where return_status = 'Active'
			and batch_id is not null
			group by product_id,  batch_id
		) as c
		on c.product_id = product_batch.product_id
		and c.batch_id = product_batch.id_batch
                left join(
			SELECT grn_product_id, grn_batch_id, sum(ifnull(grn_qty_received,0)) as qty_purchased
			FROM grn_details
			where grn_batch_id is not null
			group by grn_product_id,  grn_batch_id
		) as d
		on d.grn_product_id = product_batch.product_id
		and d.grn_batch_id = product_batch.id_batch
                left join(
			SELECT product_id, batch_id, sum(ifnull(tranfer_out_qty,0)) as transfer_out, sum(ifnull(tranfer_in_qty,0)) as transfer_in 
			FROM transfer_notes
			where batch_id is not null 
                        and transfer_notes.status='Active' 
			group by product_id, batch_id
		) as f
                on f.product_id = product_batch.product_id
		and f.batch_id = product_batch.id_batch
        ) as e ON e.product_id = business_products.id_business_products WHERE ";
        if($this->session->userdata('common_products')=='No'){
        $sql.="  business_products.business_id = ".$this->session->userdata('businessid')." And ";
        }
        $sql.=" id_business_products = '".$id."'
        order by expiry";
        
        
        $query= $this->db->query($sql);
         
        return $query->result_array();
        
    }
    
    function check_batch_number($id, $batch){
        $this->db->select('*');
        $this->db->where('pb.product_id', $id);
        $this->db->where('pb.batch_number', $batch);
        $query = $this->db->get('product_batch pb');

        return $query->row();
    }
    
    function add_batch($data=null){
        if($data==null){       
            $data = array(
                'batch_number' => $this->input->post('batch_number', TRUE),
                'product_id' => $this->input->post('product_id', TRUE),
                'batch_date' => $this->input->post('batch_date', TRUE),
                'expiry_date' => $this->input->post('batch_expiry', TRUE),
                'batch_qty' => $this->input->post('batch_qty', TRUE),
                'store_id' => $this->input->post('store_id', TRUE),
                'batch_amount' => $this->input->post('unit_price', TRUE)
            );
        }
        $this->db->insert('product_batch', $data);
        
        return $this->db->insert_id();
        
    }
    
    function open_edit_batch(){
        
        $this->db->select('*');
        $this->db->join('business_stores','business_stores.id_business_stores=pb.store_id');
        $this->db->where('pb.id_batch', $this->input->post('id_batch'));
        $query = $this->db->get('product_batch pb');

        return $query->row();
        
    }
    
    function update_batch(){
        
        $data = array(
            'batch_number' => $this->input->post('batch_number', TRUE),
            'product_id' => $this->input->post('product_id', TRUE),
            'batch_date' => $this->input->post('batch_date', TRUE),
            'expiry_date' => $this->input->post('batch_expiry', TRUE),
            'batch_qty' => $this->input->post('batch_qty', TRUE)

        );
        $this->db->where('id_batch', $this->input->post('batch_id', TRUE));
        $this->db->update('product_batch', $data);

        return $this->input->post('batch_id', TRUE);
        
    }

    function get_next_batchno($Product_id=null){
        if($Product_id==null){
         $Product_id= $this->input->post('product_id');
        }
        $this->db->select('LPAD(batch_number,4,"0") as batch_number, LPAD(batch_number + 1,4,"0") as new_number',false);
        $this->db->where('product_id', $Product_id);
        $this->db->order_by('batch_number desc');
        $this->db->limit(1);
        $query=$this->db->get('product_batch');
        
         return $query->row();
    }
    
    
    function out_of_stock_count(){
        
        
        
        $sql ="select count(*) as thresholdcount from 
            (
            select id_business_products, 
            (ifnull(adj.addition, 0) + ifnull(f.qty_purchased,0) + ifnull(g.transfer_in,0)) - ( ifnull(g.transfer_out,0) + ifnull(a.sold, 0) + ifnull(b.used, 0) + ifnull(c.returned, 0)) as total_stock ,
            ifnull(product_threshold,0) as product_threshold
            from business_products 
            JOIN `business_brands` ON `business_brands`.`id_business_brands` = `business_products`.`brand_id` 
            left join product_batch on product_batch.product_id = business_products.id_business_products 
            LEFT JOIN (
                        SELECT batch_id, product_id, sum(ifnull(adjustment_qty,0)) as 'addition'
                        from adjustment_notes
                        group by batch_id, product_id
                    ) as adj
                    on adj.product_id = business_products.id_business_products 
			and adj.batch_id=product_batch.id_batch 
            left Join( 
		SELECT product_id, batch_id, sum(invoice_qty) as sold 
		FROM invoice_products join invoice on invoice.id_invoice = invoice_products.invoice_id 
		and invoice_status = 'valid' and batch_id is not null 
                and ifnull(reference_invoice_number,'') = ''
		group by product_id , batch_id
            ) as a on a.product_id = business_products.id_business_products  
            left join( 
                SELECT product_id, batch, batch_id, sum(ifnull(dispatch_qty,0)) as used 
                FROM dispatch_notes where status = 'Active' and batch_id is not null group by product_id, batch, batch_id 
                ) as b on b.product_id = business_products.id_business_products and b.batch_id = product_batch.id_batch 
            left join( SELECT product_id, batch_id, sum(ifnull(return_qty,0)) as returned
                FROM return_notes where return_status = 'Active' and batch_id is not null group by product_id, batch_id 
                ) as c on 
                c.product_id = business_products.id_business_products 
                and c.batch_id = product_batch.id_batch 
            
            left join(
			SELECT grn_product_id, grn_batch_id, sum(ifnull(grn_qty_received,0)) as qty_purchased
			FROM grn_details
			where grn_batch_id is not null
			group by grn_product_id,  grn_batch_id
		) as f
		on f.grn_product_id = business_products.id_business_products 
		and f.grn_batch_id = product_batch.id_batch
            left join(
			SELECT product_id, batch_id, sum(ifnull(tranfer_out_qty,0)) as transfer_out, sum(ifnull(tranfer_in_qty,0)) as transfer_in 
			FROM transfer_notes
			where batch_id is not null 
                        and transfer_notes.status='Active' 
			group by product_id, batch_id
		) as g
                on g.product_id = business_products.id_business_products 
		and g.batch_id = product_batch.id_batch
                
            WHERE `business_product_active` = 'Yes' ";
                if($this->session->userdata('common_products')=='No'){
                    $sql.=" and business_products.business_id=".$this->session->userdata('businessid')." ";
                }
                $sql.=" group by id_business_products, product_threshold
            ) as z where z.total_stock <= product_threshold;";

        $query=$this->db->query($sql);
        return $query->result_array();
        
        
    }
    
    function expiring_products_count() {
        
        $businessid="";
        if($this->session->userdata('common_products')=='No'){
            $businessid=$this->session->userdata('businessid');
        }
        
        $sql="select count(*) 'expiring'
            from ( ";
        $sql.=$this->get_expired_products($businessid);
        $sql.=" ) as z ; "; 
        //echo $sql; exit();
        $query=$this->db->query($sql);
        return $query->result_array();
    }

    
     function get_countofproducts(){
        
        $result=0;
        
        $this->db->select('count(*) as count');
        ///Where
        if($this->session->userdata('common_products')=='No'){
            $this->db->where('business_products.business_id', $this->session->userdata('businessid'));
        }
        //$this->db->where('length(customers.customer_cell) =', 11);
       ///Where
        if(null !== $this->input->post('brand') && $this->input->post('brand')!==''){
            $this->db->like('business_products.brand_id', $this->input->post('brand'));
        }
        if(null !== $this->input->post('product') && $this->input->post('product')!==''){
            $this->db->like('business_products.product', $this->input->post('product'));
        }
        if(null !== $this->input->post('category') && $this->input->post('category')!==''){
            $this->db->like('business_products.category', $this->input->post('category'));
        }
        if(null !== $this->input->post('professional') && $this->input->post('professional')!==''){
            $this->db->like('business_products.professional', $this->input->post('professional'));
        }
        if(null !== $this->input->post('business_product_active') && $this->input->post('business_product_active')!==''){
            $this->db->like('business_products.business_product_active', $this->input->post('business_product_active'));
        }
        if(null !== $this->input->post('sku') && $this->input->post('sku')!==''){
            $this->db->like('business_products.sku', $this->input->post('sku'));
        }
       if(null !== $this->input->post('barcode_products') && $this->input->post('barcode_products')!==''){
            $this->db->like('business_products.barcode_products', $this->input->post('barcode_products'));
        }
        $query = $this->db->get('business_products');
       
        foreach ($query->result() as $row){
            $result=$row->count;
        }
        return $result;
        
    }
    
    function get_productsbysearch() {

        $data['brand']= $this->input->post('brand');
        $data['product']= $this->input->post('product');
        $data['category']= $this->input->post('category');
        $data['professional']= $this->input->post('professional');
        $data['business_product_active']= $this->input->post('business_product_active');
        $data['sku']= $this->input->post('sku');
        
        
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
            $orderby = 'id_business_products';
            $orderdir = 'asc';
        }
        //openupdate
        
        $this->db->select('id_business_products, business_brand_name, product, category, case when professional="y" then "Professional" else "Retail" end as professional, price, purchase_price, "" total_stock, product_threshold, unit_type, measure_unit, qty_per_unit, business_product_active, sku, barcode_products,  "" as action', false);

        if($this->session->userdata('common_products')=='Yes'){
            $this->db->join('business_brands', 'business_brands.id_business_brands = business_products.brand_id ', false);           
        } else {
            $this->db->join('business_brands', 'business_brands.id_business_brands = business_products.brand_id and business_brands.business_id='.$this->session->userdata('businessid').'', false);           
        }
        
        if($this->session->userdata('common_products')=='No'){
            $this->db->where('business_products.business_id', $this->session->userdata('businessid'));
        }
        //$this->db->where('length(customers.customer_cell) =', 11);
        
        ///Where
        if(null !== $this->input->post('brand') && $this->input->post('brand')!==''){
            $this->db->where('business_products.brand_id', $this->input->post('brand'));
        }
        if(null !== $this->input->post('product') && $this->input->post('product')!==''){
            $this->db->like('business_products.product', $this->input->post('product'));
        }
        if(null !== $this->input->post('category') && $this->input->post('category')!==''){
            $this->db->like('business_products.category', $this->input->post('category'));
        }
        if(null !== $this->input->post('professional') && $this->input->post('professional')!==''){
            $this->db->like('business_products.professional', $this->input->post('professional'));
        }
        if(null !== $this->input->post('business_product_active') && $this->input->post('business_product_active')!==''){
            $this->db->like('business_products.business_product_active', $this->input->post('business_product_active'));
        }
        if(null !== $this->input->post('sku') && $this->input->post('sku')!==''){
            $this->db->like('business_products.sku', $this->input->post('sku'));
        }
        if(null !== $this->input->post('barcode_products') && $this->input->post('barcode_products')!==''){
            $this->db->like('business_products.barcode_products', $this->input->post('barcode_products'));
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
        
        $query = $this->db->get('business_products');
      //  echo $query; exit();
        return $query->result_array();
    }
    
    
    function getbatch($batchid){
        $this->db->select('*');
        $this->db->where('id_batch',$batchid);
        $query=$this->db->get('product_batch');
        
        return $query->row();
    }
    
    function add_adjustment_note($data){
        
        
        $this->db->insert('adjustment_notes', $data);
        
        $result=$this->db->insert_id();
        
        //update existing batch
        //New scenario where grn count is used to get the purchased qty
        $batch_id=$data['batch_id'];
        
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

        
        return $result;
        

    }
 
    function get_all_notes($productid){
        
        $sql = "select * from business_products
                left join (select * from grn_details
                where grn_product_id = $productid) as grn
                        on grn.grn_product_id= business_products.id_business_products
                left join (select * from dispatch_notes
                 where product_id=$productid) as dispatch_notes
                        on dispatch_notes.product_id= business_products.id_business_products
                left join (select * from adjustment_notes
                where product_id=$productid) as adjustment_notes
                        on adjustment_notes.product_id= business_products.id_business_products
                left join (select * from transfer_notes 
                where product_id=$productid) as transfer_notes
                        on transfer_notes.product_id= business_products.id_business_products
                where business_products.id_business_products =$productid";
        
        $query=$this->db->query($sql);
        return $query->result_array();
        
        
    }
    
}
