<?php

class Sales_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         
    }

    function salesreport_json() {
        $sql = 'SELECT distinct ind.staff as Staff, 
                i.gross_amount as SumofTotal, ind.service_name as Service, ind.service_type as Servicetype, ind.service_category as Servicecategory, i.customer_name as Customer, i.invoice_type as InvoiceType , date_format(i.invoice_date,"%M") as Month, date_format(i.invoice_date,"%d") as Day, 
                date_format(i.invoice_date,"%Y") as Year FROM invoice i 
                JOIN invoice_details ind ON ind.invoice_id = i.id_invoice where i.business_id='.$this->session->userdata('businessid').' GROUP BY SumofTotal 
                UNION ALL SELECT distinct ip.staff_name as Staff, 
                i.gross_amount as SumofTotal, ip.product_name as Service, "" as Servicetype, "" as Servicecategory, i.customer_name as Customer, i.invoice_type as InvoiceType, date_format(i.invoice_date,"%M") as Month, date_format(i.invoice_date,"%d") as Day, 
                date_format(i.invoice_date,"%Y") as Year FROM invoice i 
                JOIN invoice_products ip ON ip.invoice_id = i.id_invoice where i.business_id='.$this->session->userdata('businessid').' GROUP BY SumofTotal';

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function staff_sale($id_staff) {
        $id_staff = $this->db->escape_str($id_staff);
        $subquery = "SELECT distinct ss.invoice_id FROM staff_services ss WHERE ss.staff_id = $id_staff";
        $sql = "SELECT (SELECT DISTINCT staff_id FROM staff_services WHERE staff_id = $id_staff) as staff_id,SUM(i.paid_amount) as sub_total,date_format(i.invoice_date,'%b') as month FROM invoice i WHERE i.id_invoice in($subquery) group by month";
        $query = $this->db->query($sql);

        if ($query->result_array()) {
            return $query->result_array();
        } else {
            $sql = "SELECT 0 as staff_id, 0 as sub_total, '' as month";
            $query = $this->db->query($sql);
            return $query->result_array();
        }
    }

    function staff_sale_ajax($year, $id_staff) {
        //$id_staff = $this->db->escape_str($id_staff);
//        $subquery = "SELECT distinct ss.invoice_id FROM staff_services ss WHERE ss.staff_id = $id_staff";
//        $in = 'invp.id_invoice in(SELECT distinct ss.invoice_id FROM staff_services ss WHERE ss.staff_id = ' . $id_staff . ')';
//        $mjoin = 'date_format(invp.invoice_date, \'%m\') = CONVERT(SUBSTRING_INDEX(m.month,"-",-1),UNSIGNED INTEGER) and ' . $in . ' and invp.business_id = 1 and date_format(invp.invoice_date, \'%Y\') =\'' . $year . '\'';
//
//        $this->db->select("m.month, round(ifnull(sum(invp.paid_amount),0)) as 'data'");
//        $this->db->join('invoice invp', $mjoin, 'left');
//        $this->db->group_by('m.month, month(invp.invoice_date), year(invp.invoice_date)');
//        $this->db->order_by('m.id_months');
//        $query = $this->db->get_compiled_select('months m');
        
        
        $sql="SELECT m.month, round(ifnull(sum(invp.paid), 0)) as 'data' 
            FROM months m 
            LEFT JOIN 
            (select paid, invoice_date from invoice 
            join staff_services ss on ss.invoice_id = invoice.id_invoice 
            where ss.staff_id = ".$id_staff."
            and invoice.business_id = ".$this->session->userdata('businessid')."
            and Year(invoice_date) ='".$year."' 
            and invoice_status='valid'
            AND invoice_type = 'service'
            ) invp ON month(invp.invoice_date) = m.month
            GROUP BY m.month
            ORDER BY m.id_months";
        
        $query = $this->db->query($sql);
        return $query->result_array();
        
    }

    public function get_multiple_staff_sale($year, $id_staff) {

//        $in = 'invp.id_invoice in(SELECT distinct ss.invoice_id FROM staff_services ss WHERE ss.staff_id = ' . $id_staff . ')';
//        $mjoin = 'date_format(invp.invoice_date, \'%m\') = CONVERT(SUBSTRING_INDEX(m.month,"-",-1),UNSIGNED INTEGER) and ' . $in . ' and invp.business_id = 1 and date_format(invp.invoice_date, \'%Y\') =\'' . $year . '\'';
//
//        $this->db->select("m.month, round(ifnull(sum(invp.paid_amount),0)) as 'data'");
//        $this->db->join('invoice invp', $mjoin, 'left');
//        $this->db->group_by('m.month, month(invp.invoice_date), year(invp.invoice_date)');
//        $this->db->order_by('m.id_months');
//        $query = $this->db->get_compiled_select('months m');
//        echo $query;
//        return $query->result_array();
        
         $sql="SELECT m.month, round(ifnull(sum(invp.paid), 0)) as 'data' 
            FROM months m 
            LEFT JOIN 
            (select paid, invoice_date from invoice 
            join staff_services ss on ss.invoice_id = invoice.id_invoice 
            where ss.staff_id = ".$id_staff."
            and invoice.business_id = ".$this->session->userdata('businessid')."
            and Year(invoice_date) ='".$year."' 
            and invoice_status='valid'
            AND invoice_type = 'service'
            ) invp ON month(invp.invoice_date) = m.month
            GROUP BY m.month
            ORDER BY m.id_months";
        
        $query = $this->db->query($sql);
        return $query->result_array();
        
    }

    function retail_sales($product_name) {
        $this->db->select('*');
        $this->db->join('invoice_products invp', 'inv.id_invoice = invp.invoice_id');
        $this->db->where('inv.business_id', $this->session->userdata('businessid'));
        $this->db->where('invp.product_name', $product_name);
        $query = $this->db->get('invoice inv');

        return $query->result();
    }

    function get_product_sale_bydate($date, $product) {

        $this->db->select("sum(invp.paid) as 'data'");
        $this->db->join('invoice_products invp', 'inv.id_invoice = invp.invoice_id');
        $this->db->where('inv.business_id', $this->session->userdata('businessid'));
        $this->db->where('convert(invoice_date, date) = ', $date);
        $this->db->where('product_name = ', $product);
        $this->db->where('invoice_status = ', 'Valid');
        $this->db->group_by('product_name');
        $this->db->order_by('invoice_date, product_name');
        $query = $this->db->get('invoice inv');
        
        return $query->result();
    }

    function get_product_sale_byyear($year, $product) {

        // $product= urlencode($product);

//        $mjoin = 'date_format(invp.invoice_product_date, \'%m\') = m.month and product_name = \'' . $product . '\' and invp.business_id = 1 and date_format(invp.invoice_product_date, \'%Y\') =\'' . $year . '\'';
//
//        $this->db->select("m.month, round(ifnull(sum(invp.discounted_price),0)) as 'data'");
//        $this->db->join('invoice_products invp', $mjoin, 'left');
//        $this->db->group_by('m.month, month(invp.invoice_product_date), year(invp.invoice_product_date)');
//        $this->db->order_by('m.id_months');
//        $query = $this->db->get('months m');

        $sql="SELECT m.month, round(ifnull(sum(invp.paid), 0)) as 'data' 
                FROM months m 
                LEFT JOIN 
                (
                select paid, invoice_product_date
                from invoice join invoice_products ON invoice.id_invoice= invoice_products.invoice_id
                where product_name = '".$product."' 
                and invoice.business_id = ".$this->session->userdata('businessid')." 
                and invoice_status = 'Valid'
                and year(invoice_product_date) ='".$year."' 
                ) invp on month(invp.invoice_product_date) = m.month 
                GROUP BY m.month
                ORDER BY m.id_months";
        
        $query = $this->db->query($sql);      

        return $query->result();
    }

    function get_service_catgory() {//this function is used in sales_controller -> view -> service_chart_view...
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where('service_category_active', 'Yes');
        $query = $this->db->get('service_category');

        return $query->result_array();
    }

    function get_service() {//this function is using in sales_controller -> view -> service_chart_view...
        $this->db->select('*');
        $this->db->where('business_id', $this->session->userdata('businessid'));
        $this->db->where_in('service_category_id', $this->input->post('category_id'));
        $this->db->where('service_active', 'Yes');
        $query = $this->db->get('business_services');

        return $query->result_array();
    }

    public function getservice_chart_sale1($year) {///////Old function was usnig for service...Not using
        $this->db->select('ss.service_name as service, sum(i.paid_amount) AS PaidAmount,MONTH(i.invoice_date) AS month, date_format(i.invoice_date,"%b") AS monthname,YEAR(i.invoice_date) AS year');
        $this->db->join('invoice i', 'i.id_invoice = ss.invoice_id');
        $this->db->where('ss.business_id', $this->session->userdata('businessid'));
        $this->db->where('ss.service_name', $this->input->post('service_name'));
        $this->db->like('i.invoice_date', $year, 'after');
        $this->db->group_by('month');
        $query = $this->db->get('staff_services ss');

        return $query->result_array();
    }

    public function get_service_sale_year() {//This function is returning years...
        $this->db->distinct();
        $this->db->select('YEAR(i.invoice_date) AS year');
        $this->db->join('invoice i', 'i.id_invoice = ss.invoice_id');
        $this->db->where('ss.business_id', $this->session->userdata('businessid'));
        $this->db->where('ss.service_name', $this->input->post('service_name'));
        $query = $this->db->get('staff_services ss');

        return $query->result_array();
    }

    public function getservice_chart_sale($year) {///New function is using for service.....


        //$query = $this->db->query($sql);
        //New Query final
        $service_names='';
        $service_ids='';
        foreach( $this->input->post('service_name') as $sn){
            $service_names .= '"'.$sn.'",';            
        }
        
        foreach( $this->input->post('service_id') as $sid){
            $service_ids .= $sid.',';            
        }
        
        $service_names= rtrim($service_names, ',');
        $service_ids= rtrim($service_ids, ',');
        
        $service_categories='';
        foreach( $this->input->post('category_name') as $sc){
            $service_categories .= '"'.$sc.'",';
        }
        
        $service_categories= rtrim($service_categories, ',');
        

        $sql="SELECT m.month, ifnull(sum(invp.paid), 0) as 'data'
        FROM months m
        LEFT JOIN (
        select paid, staff_service_date, invoice.business_id 
        from staff_services join invoice on invoice.id_invoice = staff_services.invoice_id 
        and invoice.invoice_status = 'valid'
        and Year(staff_service_date) ='".$year."'
        and  service_id in (" . $service_ids . ")
        and invoice.business_id = " . $this->session->userdata('businessid') . "
        and ifnull(reference_invoice_number,'') = ''
        ) as invp 
        ON month(invp.staff_service_date) = m.month
        GROUP BY m.month
        ORDER BY m.id_months";
        //`service_category` in (". $service_categories .")  and
        //echo $sql; exit();
        
        $query = $this->db->query($sql);      

        return $query->result();
    }

    function get_service_sale_bydate($date, $service, $category_name) {

        $this->db->select("sum(invp.paid) as 'data'");
        $this->db->join('staff_services invp', 'inv.id_invoice = invp.invoice_id');
        $this->db->where('inv.business_id', $this->session->userdata('businessid'));
        $this->db->where('convert(invoice_date, date) = ', $date);
        $this->db->where('invoice_status = ', 'valid');
        $this->db->where('service_id = ', $service);
        $this->db->where('ifnull(inv.reference_invoice_number,"") = ', '');
        //$this->db->where('service_name = ', $service);
        //$this->db->where('service_category = ', $category_name);
        $this->db->order_by('invoice_date, service_name');
        $query = $this->db->get('invoice inv');
      //  echo $query;
        return $query->result();
    }

}
