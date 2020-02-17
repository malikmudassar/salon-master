<?php

class Marketing_model extends CI_Model {

    function __construct() {

        // Call the Model constructor
        parent::__construct();
    }

    function getmarketingsheet($today) {

        //$today = date('Y-m-d');
        //$tomorrow = date('Y-m-d H:i:s', strtotime('tomorrow'));

        $this->db->select("invoice.payment_mode, id_invoice, invoice_type, customer_name, invoice_products.staff_name as staff, 
        reference_invoice_number,
        concat(invoice_details.service_type, ' ', invoice_details.service_category, ' ', invoice_details.service_name) as service, 
        invoice.discount as 'invoice_discount',
        paid_amount, total_payable as gross_amount, retained_amount, invoice.balance, invoice.advance_amount, cctip, tax_total, cc_charge,
        invoice_staff.price, invoice_staff.discount, paid_amount, paid_cash, paid_card, paid_voucher, paid_check, 
        concat(invoice_products.brand_name, ' ', invoice_products.product_name, ' x ', invoice_products.invoice_qty) product_name, 
        invoice_qty, invoice_products.price product_price, invoice_products.staff_name product_staff, 
        invoice_products.discount product_discount,
        DATE_FORMAT(invoice_date, '%d-%c-%Y') as invoice_date, DATE_FORMAT(visit_time, '%H:%i') as visit_time, DATE_FORMAT(visit_time, '%d-%m-%Y') as visit_date, retained_amount_used", False);
        //$this->db->join('invoice_details', 'invoice_details.invoice_id = invoice.id_invoice', 'left', false);
        $this->db->join('invoice_details', 'invoice_details.invoice_id = invoice.id_invoice', 'left', false);
        $this->db->join('invoice_staff', 'invoice_staff.invoice_detail_id = invoice_details.id_invoice_details and invoice_staff.invoice_id=invoice.id_invoice', 'left', false);
        $this->db->join('invoice_products', 'invoice_products.invoice_id = invoice.id_invoice', 'left', false);
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_status', 'valid');

        $this->db->where('date_format(invoice_date , "%Y-%m") =', $today);

        //$this->db->where('reference_invoice_number !=', 'bad debts');
        $query = $this->db->get('invoice');
        //echo $query; exit();

        return $query->result_array();
    }

    function getservicedayinvoices($today) {

        //$today = date('Y-m-d');
        //$tomorrow = date('Y-m-d H:i:s', strtotime('tomorrow'));

        $this->db->select("id_invoice, invoice_type, customer_name, invoice_staff.staff_name as staff, reference_invoice_number,
        concat(invoice_details.service_type, ' ', invoice_details.service_category, ' ', invoice_details.service_name) as service, 
        invoice.discount as 'invoice_discount', invoice.payment_mode,
        paid_amount, total_payable as gross_amount, retained_amount, invoice.balance, invoice.advance_amount, cctip, tax_total, cc_charge,
        invoice_details.id_invoice_details, invoice_details.price, invoice_details.paid as paid_details, 
        invoice_details.discount, paid_amount, paid_cash, paid_card, paid_voucher, paid_check, 
        '' as product_name, 
        '' as invoice_qty, '' as product_price, '' as product_staff, 
        '' as product_discount,
        DATE_FORMAT(invoice_date, '%d-%c-%Y') as invoice_date, DATE_FORMAT(visit_time, '%H:%i') as visit_time, DATE_FORMAT(visit_time, '%d-%m-%Y') as visit_date, retained_amount_used", False);
        $this->db->join('invoice_details', 'invoice_details.invoice_id = invoice.id_invoice', 'left', false);
        $this->db->join('invoice_staff', 'invoice_staff.invoice_detail_id = invoice_details.id_invoice_details and invoice_staff.invoice_id=invoice.id_invoice', 'left', false);

        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_status', 'valid');
        $this->db->where('invoice_type', 'service');
        //$this->db->where('reference_invoice_number', '');
        $this->db->where('date_format(invoice_date , "%Y-%m") =', $today);
        //$this->db->where('reference_invoice_number !=', 'bad debts');
        $query = $this->db->get('invoice');
        // echo $query; exit();

        return $query->result_array();
    }

    function getproductdayinvoices($today) {

        //$today = date('Y-m-d');
        //$tomorrow = date('Y-m-d H:i:s', strtotime('tomorrow'));

        $this->db->select("id_invoice, invoice_type, customer_name, invoice_products.staff_name as staff, reference_invoice_number,
       '' as service, 
        invoice.discount as 'invoice_discount', invoice.payment_mode,
        paid_amount, total_payable as gross_amount, retained_amount, invoice.balance, invoice.advance_amount, cctip, tax_total, cc_charge,
        '' id_invoice_details, invoice_products.price, invoice_products.paid as paid_details, invoice_products.discount, 
        paid_amount, paid_cash, paid_card, paid_voucher, paid_check, 
        concat(invoice_products.brand_name, ' ', invoice_products.product_name, ' x ', invoice_products.invoice_qty) product_name, 
        invoice_qty, invoice_products.price product_price, invoice_products.staff_name product_staff, 
        invoice_products.discount product_discount,
        DATE_FORMAT(invoice_date, '%d-%c-%Y') as invoice_date, DATE_FORMAT(visit_time, '%H:%i') as visit_time, 
        DATE_FORMAT(visit_time, '%d-%m-%Y') as visit_date, retained_amount_used", False);
        $this->db->join('invoice_products', 'invoice_products.invoice_id = invoice.id_invoice', false);
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_status', 'valid');
        $this->db->where('invoice_type', 'sale');
        //$this->db->where('reference_invoice_number', '');
        $this->db->where('date_format(invoice_date , "%Y-%m") =', $today);
        //$this->db->where('reference_invoice_number !=', 'bad debts');
        $query = $this->db->get('invoice');
        //echo $query; exit();

        return $query->result_array();
    }

    //Currently this query is not using
    function getmarketingsummary2($today) {
        //$today = date('Y-m-d');
        //$tomorrow = date('Y-m-d H:i:s', strtotime('tomorrow'));

        $this->db->select("invoice.payment_mode, id_invoice, invoice_type, customer_name, invoice_staff.staff_name as staff, 
        reference_invoice_number,
        concat(invoice_details.service_type, ' ', invoice_details.service_category, ' ', invoice_details.service_name) as service, 
        invoice.discount as 'invoice_discount',
        paid_amount, total_payable as gross_amount, retained_amount, invoice.balance, invoice.advance_amount, cctip, tax_total, cc_charge,
        sum(invoice_staff.price) as price, sum(invoice_staff.discount) as discount, paid_amount, paid_cash, paid_card, paid_voucher, paid_check, 
        concat(invoice_products.brand_name, ' ', invoice_products.product_name, ' x ', invoice_products.invoice_qty) product_name, 
        invoice_qty, sum(invoice_products.price) as product_price, invoice_products.staff_name product_staff, 
        sum(invoice_products.discount) as product_discount,
        DATE_FORMAT(invoice_date, '%d-%c-%Y') as invoice_date, DATE_FORMAT(visit_time, '%H:%i') as visit_time, DATE_FORMAT(visit_time, '%d-%m-%Y') as visit_date, retained_amount_used", False);
        //$this->db->join('invoice_details', 'invoice_details.invoice_id = invoice.id_invoice', 'left', false);
        $this->db->join('invoice_details', 'invoice_details.invoice_id = invoice.id_invoice', 'left', false);
        $this->db->join('invoice_staff', 'invoice_staff.invoice_detail_id = invoice_details.id_invoice_details and invoice_staff.invoice_id=invoice.id_invoice', 'left', false);
        $this->db->join('invoice_products', 'invoice_products.invoice_id = invoice.id_invoice', 'left', false);
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_status', 'valid');

        $this->db->where('date_format(invoice_date , "%Y-%m") =', $today);
        $this->db->group_by('invoice_staff.staff_name');
        $this->db->group_by('invoice_products.staff_name');

        //$this->db->where('reference_invoice_number !=', 'bad debts');
        $query = $this->db->get('invoice');
        //echo $query; exit();

        return $query->result_array();
    }

    //This query is using for marketing staff summary
    function getmarketingsummary($date) {
        $service = "(SELECT (SUM(IF(invoice_staff.price,invoice_staff.price,0))-SUM(IF(invoice_staff.discount,invoice_staff.discount,0))) as price FROM invoice 
        JOIN invoice_details ON invoice.id_invoice = invoice_details.invoice_id 
        JOIN invoice_staff ON invoice_details.id_invoice_details = invoice_staff.invoice_detail_id AND invoice_staff.invoice_id = invoice.id_invoice 
        WHERE invoice_staff.staff_name = staff.staff_fullname AND date_format(invoice_date , '%Y-%m') = '$date' AND invoice.invoice_type = 'service' 
        AND invoice.business_id = " . $this->session->userdata('businessid') . " AND invoice.invoice_status = 'valid')";
        $product = "(SELECT (SUM(IF(invoice_products.price,invoice_products.price,0))-SUM(IF(invoice_products.discount,invoice_products.discount,0))) as price FROM invoice 
        JOIN invoice_products ON invoice_products.invoice_id = invoice.id_invoice 
        WHERE invoice_products.staff_name = staff.staff_fullname AND date_format(invoice_date , '%Y-%m') = '$date' AND invoice.invoice_type = 'sale' 
        AND invoice.business_id = " . $this->session->userdata('businessid') . " AND invoice.invoice_status = 'valid')";
        $sql = "SELECT staff.staff_fullname, $service as service_price, $product as product_price FROM staff WHERE staff.staff_active = 'Y'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_advance_breakup($t = null) {
        $today = $this->input->post('calendar_date', TRUE);

        if (!isset($today) || empty($today)) {
            if ($t !== null) {
                $today = $t;
            } else {
                $today = date('Y-m-d');
            }
        }
        $sql = "select id_visit_advance, date_format(va.advance_date,'%Y-%m-%d') as advance_date, CONCAT(id_customer_visits,id_visit_advance) id_customer_visits, customer_name, adv_mode advance_mode, adv_amount advance_amount, service_category, business_services.service_name, service_rate
                from customer_visits
                join (
                        select id_visit_advance, visit_advance.advance_date, customer_visit_id, sum(advance_amount) adv_amount, advance_mode adv_mode, advance_inst adv_inst, advance_date adv_date
                        from visit_advance 
                        where date_format(advance_date,'%Y-%m') ='" . $today . "'
                        group by advance_mode, advance_inst, advance_date, id_visit_advance
                    ) va on customer_visits.id_customer_visits = va.customer_visit_id
            join visit_services on customer_visits.id_customer_visits = visit_services.customer_visit_id
            join customers on customers.id_customers = customer_visits.customer_id
            join business_services on business_services.id_business_services = visit_services.service_id
            join service_category on business_services.service_category_id = service_category.id_service_category
            where customer_visits.business_id = " . $this->session->userdata('businessid') . "
            and customer_visits.visit_status != 'canceled' and advance='true' 
            group by CONCAT(id_customer_visits,id_visit_advance), service_category, business_services.service_name, service_rate";
        //echo $sql; exit();
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function pettycashreport($startdate, $enddate) {
        $this->db->select('*,DATE_FORMAT(av.created_on, "%d-%m-%Y") voucher_date,DATE_FORMAT(av.created_on, "%H:%i:%s") voucher_time');
        $this->db->join('account_voucher_detail avd', 'av.id_account_vouchers = account_voucher_id');
        $this->db->join('account_heads ah', 'ah.id_account_heads = avd.account_head_id');
        $this->db->where('av.business_id', $this->session->userdata('businessid'));
        $this->db->where('av.voucher_date >= ', $startdate);
        $this->db->where('av.voucher_date <= ', $enddate);
        $this->db->where('ah.account_type', 'Expense');
        $this->db->where('ah.account_head', 'office expense');
        $this->db->where('av.voucher_type', 1);
        $this->db->where('av.voucher_status =', 'Active');
        $this->db->order_by('av.created_on', 'desc');
        $query = $this->db->get('account_vouchers av');

        return $query->result_array();
    }

    function retailTransaction($startdate, $enddate) {
        $this->db->select('business_brands.id_business_brands, business_brands.business_brand_name');
        $this->db->where([
            'business_brands.business_id' => $this->session->userdata('businessid'),
            'business_brands.business_brand_active' => 'Yes'
        ]);
        $query = $this->db->get('business_brands');
        $brands = $query->result_array();

        $data = [];
        if (isset($brands) && !empty($brands)) {
            foreach ($brands as $row) {
                $where = [
                    'i.business_id' => $this->session->userdata('businessid'),
                    'i.invoice_date >= ' => $startdate,
                    'i.invoice_date <= ' => $enddate,
                    'i.invoice_status' => 'valid',
                    'i.balance' => 0,
                    'bp.brand_id' => $row['id_business_brands']
                ];
                //$subquery = "select paid from invoice_products join invoice on invoice.id_invoice = invoice_products.invoice_id where invoice.invoice_number = i.invoice_number";
                $this->db->select('DATE_FORMAT(i.invoice_date, "%d-%m-%Y") as invoice_date, ip.id_invoice_products, bp.product as product_name, ip.product_id, ip.price, ip.discount, ip.paid, gd.grn_unit_price as purchase_price, gd.grn_batch_number as batch_number, gd.grn_batch_id as batch_id, bp.measure_unit, bp.qty_per_unit, ip.brand_name, i.reference_invoice_number');
                $this->db->join('invoice_products ip', 'ip.invoice_id = i.id_invoice');
                $this->db->join('business_products bp', 'bp.id_business_products = ip.product_id');
                $this->db->join('grn_details gd', 'gd.grn_product_id = bp.id_business_products AND ip.batch_id = gd.grn_batch_id');
                $this->db->where($where);
                $query = $this->db->get('invoice i');
                $data[] = ['brand_name' => $row['business_brand_name'], 'data' => $query->result_array()];
            }
            return $data;
        }
    }

    function retailTransactionByItem($startdate, $enddate) {
        $this->db->select('business_brands.id_business_brands, business_brands.business_brand_name');
        $this->db->where([
            'business_brands.business_id' => $this->session->userdata('businessid'),
            'business_brands.business_brand_active' => 'Yes'
        ]);
        $query = $this->db->get('business_brands');
        $brands = $query->result_array();

        $data = [];
        if (isset($brands) && !empty($brands)) {
            foreach ($brands as $row) {
                $where = [
                    'i.business_id' => $this->session->userdata('businessid'),
                    'i.invoice_date >= ' => $startdate,
                    'i.invoice_date <= ' => $enddate,
                    'i.invoice_status' => 'valid',
                    'i.balance' => 0,
                    'bp.brand_id' => $row['id_business_brands']
                ];
                //$subquery = "select paid from invoice_products join invoice on invoice.id_invoice = invoice_products.invoice_id where invoice.invoice_number = i.invoice_number";
                $this->db->select('DATE_FORMAT(i.invoice_date, "%d-%m-%Y") as invoice_date, ip.id_invoice_products, bp.product as product_name, bp.barcode_products, COUNT(ip.product_id) as sold, SUM(ip.price) as price, SUM(ip.discount) as discount, SUM(ip.paid) as paid, SUM(gd.grn_unit_price) as purchase_price, gd.grn_batch_number as batch_number, gd.grn_batch_id as batch_id, bp.measure_unit, bp.qty_per_unit, ip.brand_name, i.reference_invoice_number');
                $this->db->join('invoice_products ip', 'ip.invoice_id = i.id_invoice');
                $this->db->join('business_products bp', 'bp.id_business_products = ip.product_id');
                $this->db->join('grn_details gd', 'gd.grn_product_id = bp.id_business_products AND ip.batch_id = gd.grn_batch_id');
                $this->db->where($where);
                $this->db->group_by('ip.product_id');
                $query = $this->db->get('invoice i');
                $data[] = ['brand_name' => $row['business_brand_name'], 'data' => $query->result_array()];
            }
            return $data;
        }
    }

    function getBrands($startdate, $enddate) {
        $this->db->select('*');
        $this->db->join('(select distinct brand_name from invoice_products join invoice i on i.id_invoice = invoice_products.invoice_id where i.business_id = ' . $this->session->userdata('businessid') . ' and i.invoice_status = "valid" and i.invoice_date >= "' . $startdate . '" and i.invoice_date <= "' . $enddate . '") ip', 'ip.brand_name = business_brands.business_brand_name');
        $this->db->where([
            'business_brands.business_id' => $this->session->userdata('businessid'),
            'business_brands.business_brand_active' => 'Yes'
        ]);
        $query = $this->db->get('business_brands');
        return $query->result_array();
    }

    function service_sale_details($startdate, $enddate) {
        //echo $startdate.'---'.$enddate;exit;
        // $date = strtotime("+ 1 days", strtotime($enddate));
        // $enddate = date("Y-m-d", $date);

        $select = "COUNT(invoice_details.service_id) as sold, service_category, invoice_details.service_name, SUM(ifnull(invoice_details.price,0)) as price, SUM(ifnull(invoice_details.discount,0)) as 'service_discount', SUM(ifnull(invoice.balance,0)) as 'balance', SUM(invoice_details.discounted_price) as discounted_price, SUM(invoice_details.paid) as paid";

        $this->db->select($select, FALSE);
        $this->db->join('invoice_details', 'invoice.id_invoice = invoice_details.invoice_id');
        //$this->db->join('(select invoice_id, staff_name, service_name from invoice_staff)  a', 'a.invoice_id=invoice_details.invoice_id and a.service_name collate utf8_general_ci = invoice_details.service_name', FALSE, FALSE);
        $this->db->where('invoice_date >=', $startdate . " 00:00");
        $this->db->where('invoice_date <=', $enddate . " 23:59");
        $this->db->where('invoice_status', 'valid');
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_type', 'service');
        //$this->db->where('invoice.balance', 0);

        $this->db->group_by('invoice_details.service_id');
        $this->db->order_by('service_type', 'service_category', 'service_name');

        $query = $this->db->get('invoice');

        return $query->result_array();
    }

    function service_by_staff($startdate, $enddate) {
        //echo $startdate.'---'.$enddate;exit;
        // $date = strtotime("+ 1 days", strtotime($enddate));
        // $enddate = date("Y-m-d", $date);

        $this->db->select('staff.id_staff, staff.staff_fullname');
        $this->db->where(['staff.business_id' => $this->session->userdata('businessid'), 'staff.staff_active' => 'Y']);
        $query = $this->db->get('staff');

        $staff = $query->result_array();
        $data = [];
        if (isset($staff) && !empty($staff)) {
            foreach ($staff as $row) {
                $select = "COUNT(invoice_details.service_id) as sold, service_category, invoice_details.service_name, SUM(ifnull(invoice_details.price,0)) as price, SUM(ifnull(invoice_details.discount,0)) as 'service_discount', SUM(ifnull(invoice.balance,0)) as 'balance', SUM(ifnull(invoice_details.discounted_price,0)) as 'discounted_price', SUM(ifnull(invoice_details.paid,0)) as 'paid'";
                $this->db->select($select, FALSE);
                $this->db->join('invoice_details', 'invoice.id_invoice = invoice_details.invoice_id');
                $this->db->join('(select invoice_id, staff_name, service_name from invoice_staff)  a', 'a.invoice_id=invoice_details.invoice_id and a.service_name collate utf8_general_ci = invoice_details.service_name', FALSE, FALSE);
                $this->db->where('invoice_date >=', $startdate . " 00:00");
                $this->db->where('invoice_date <=', $enddate . " 23:59");
                $this->db->where('invoice_status', 'valid');
                $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
                $this->db->where('invoice_type', 'service');
                $this->db->where('a.staff_name', $row['staff_fullname']);
                $this->db->group_by('invoice_details.service_id');
                $this->db->order_by('service_type', 'service_category', 'service_name');

                $query = $this->db->get('invoice');

                $result = $query->result_array();
                $data[] = ['staff_name' => $row['staff_fullname'], 'data' => $result];
            }
            return $data;
        }
    }

    function daily_sheet_by_category($startdate, $enddate) {

        // $date = strtotime("+ 1 days", strtotime($enddate));
        // $enddate = date("Y-m-d", $date);

        $this->db->select('service_category.id_service_category, service_category.service_category');
        $this->db->where(['service_category.business_id' => $this->session->userdata('businessid'), 'service_category.service_category_active' => 'Yes']);
        $query = $this->db->get('service_category');

        $staff = $query->result_array();
        $data = [];
        if (isset($staff) && !empty($staff)) {
            foreach ($staff as $row) {
                $select = "invoice.payment_mode, id_invoice_details, id_invoice, invoice_details.service_name, 
                date_format(invoice_date, '%d-%m-%Y %H:%i') as 'invoiced', staff_name as 'staff', ifnull(invoice_details.discounted_price,0) as 'discounted_price', ifnull(invoice.discount,0) 'Invoice Discount', 
                invoice_details.price, ifnull(invoice_details.discount,0) as 'Service Discount', 
                invoice_details.paid as 'paid', balance as 'balance', ifnull(reference_invoice_number,'') as reference_number";

                $this->db->select($select, FALSE);
                $this->db->join('invoice_details', 'invoice.id_invoice = invoice_details.invoice_id');
                $this->db->join('(select invoice_id, staff_name, service_name from invoice_staff)  a', 'a.invoice_id=invoice_details.invoice_id and a.service_name collate utf8_general_ci = invoice_details.service_name', FALSE, FALSE);
                $this->db->where('invoice_date >=', $startdate . " 00:00");
                $this->db->where('invoice_date <=', $enddate . " 23:59");
                $this->db->where('invoice_status', 'valid');
                $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
                $this->db->where('invoice_type', 'service');
                $this->db->where('invoice_details.service_category', $row['service_category']);

                $this->db->group_by('id_invoice_details');
                $this->db->order_by('service_type', 'service_category', 'service_name');

                $query = $this->db->get('invoice');

                $result = $query->result_array();
                $data[] = ['service_category' => $row['service_category'], 'data' => $result];
            }
            return $data;
        }
    }
    
    //This query is in development mode for dupilex template
    function getServiceCashDetails($today){
        $this->db->select('invoice.id_invoice,SUM(invoice_details.paid) as paid,invoice_details.service_type,SUM(invoice.paid_cash) as paid_cash,SUM(invoice.paid_card) as paid_card, invoice.payment_mode, SUM(invoice.paid_amount) as paid_amount');
        $this->db->join('invoice_details', 'invoice_details.invoice_id = invoice.id_invoice', '', false);
        //$this->db->join('service_type', 'service_type.service_type = invoice_details.service_type collate utf8_general_ci', 'LEFT', FALSE);
        $this->db->where('invoice.business_id', $this->session->userdata('businessid'));
        $this->db->where('invoice_status', 'valid');
        $this->db->where('date_format(invoice_date , "%Y-%m-%d") =', $today);
        $this->db->where_in('invoice.payment_mode', ['Cash', 'Mixed']);
        $this->db->where('invoice_type', 'service');
        $this->db->group_by('invoice_details.service_type');
        $query = $this->db->get('invoice');
        //echo $query; exit();
              
        return $query->result_array();
    }
    
    //This query is in development mode for dupilex template
    function get_today_cash_info($t = null) {
        $today = $this->input->post('calendar_date', TRUE);
        if (!isset($today) || empty($today)) {
            if ($t !== null) {
                $today = $t;
            } else {
                $today = date('Y-m-d');
            }
        }
        $datetime = new DateTime($today);
        $datetime->modify('+1 day');
        $tomorrow = $datetime->format('Y-m-d H:i:s');
        $business_id = $this->session->userdata('businessid');
        //Cash changing paid_amount to paid_cash as service cash
        $sub_query1 = "SELECT ifnull(SUM(paid_cash),0) as 'casha' 
                    FROM invoice WHERE payment_mode in ('Cash','Mixed') AND invoice_date > '" . $today . "'
                    AND invoice_date < '" . $tomorrow . "' AND business_id = " . $business_id . " AND invoice_status = 'valid' and invoice_type = 'service'";

        //Card changing paid_amount to paid_card as service card
        $sub_query2 = "SELECT ifnull(SUM(paid_card),0) as 'carda' 
                    FROM invoice WHERE payment_mode in ('Card','Mixed') AND invoice_date > '" . $today . "'
                    AND invoice_date < '" . $tomorrow . "' AND business_id = " . $business_id . " AND invoice_status = 'valid' and invoice_type = 'service'";
        
        //Cash changing paid_amount to paid_cash as product cash
        $sub_query3 = "SELECT ifnull(SUM(paid_cash),0) as 'casha' 
                    FROM invoice WHERE payment_mode in ('Cash','Mixed') AND invoice_date > '" . $today . "'
                    AND invoice_date < '" . $tomorrow . "' AND business_id = " . $business_id . " AND invoice_status = 'valid' and invoice_type = 'sale'";

        //Card changing paid_amount to paid_card as product card
        $sub_query4 = "SELECT ifnull(SUM(paid_card),0) as 'carda' 
                    FROM invoice WHERE payment_mode in ('Card','Mixed') AND invoice_date > '" . $today . "'
                    AND invoice_date < '" . $tomorrow . "' AND business_id = " . $business_id . " AND invoice_status = 'valid' and invoice_type = 'sale'";

        $this->db->select(" "
                . "($sub_query1) AS ServiceCash, "
                . "($sub_query2) AS ServiceCard, "
                . "($sub_query3) AS ProductCash, "
                . "($sub_query4) AS ProductCard, "
                . "");
        $query = $this->db->get('invoice');

        return $query->row_array();
    }

}
