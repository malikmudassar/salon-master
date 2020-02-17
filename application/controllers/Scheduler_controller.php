<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Scheduler_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('scheduler_model');
        $this->load->model('business_model');
        $this->load->model('visits_model');
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        }
    }

    
    public function getBlockingEvents() {
        $data = $this->scheduler_model->get_blocking_events();
        echo json_encode($data);
    }

    public function updateBlockEvent() {

        $block_time_event_id = htmlspecialchars($this->input->post('block_time_event_id', TRUE));
        $staff_id = htmlspecialchars($this->input->post('staff_id', TRUE));
        $start = htmlspecialchars($this->input->post('start', TRUE));
        $end = htmlspecialchars($this->input->post('end', TRUE));
        $staff = $this->scheduler_model->getStaff($staff_id);
        $staff_name = $staff->staff_fullname;

        $data = array(
            'staff_id' => $staff_id,
            'staff_name' => $staff_name,
            'start_time' => $start,
            'end_time' => $end
        );

        $update = $this->scheduler_model->update_block_event($block_time_event_id, $data);

        if ($update) {
            echo "success";
        }
    }

    public function addStaffBlockTime() {

        $block_event_id = $this->input->post('block_event_id', TRUE);
        $block_event_name = $this->input->post('block_event_name', TRUE);
        $block_event_duration = $this->input->post('block_event_duration', TRUE);
        $blocking_remarks = $this->input->post('blocking_remarks', TRUE);
        $staff_id = $this->input->post('staff_id', TRUE);
        $staff_name = $this->input->post('staff_name', TRUE);
        $start = $this->input->post('start', TRUE);

        $data['business'] = $this->business_model->get_business_details();
        
        $business_closing_time = $data['business'][0]['business_closing_time'];
        
        $duration = strtotime($block_event_duration) - strtotime('TODAY');

        //$end = date('Y-m-d\TH:i:s', strtotime($start) + $duration);
        
        $end=date('Y-m-d\TH:i:s', strtotime($business_closing_time));
        
        if(strtotime($start) + $duration < strtotime($business_closing_time)){
            $end = date('Y-m-d\TH:i:s', strtotime($start) + $duration);
        }   
        

        $data = array(
            'business_id' => $this->session->userdata('businessid'),
            'block_event_id' => $block_event_id,
            'staff_id' => $staff_id,
            'staff_name' => $staff_name,
            'start_time' => $start,
            'end_time' => $end,
            'remarks' => $blocking_remarks
        );

        $this->scheduler_model->add_staff_block_time($data);

        echo "success";
    }
    
    public function addStaffBlockTimeAll() {

        $block_event_id = $this->input->post('block_event_id', TRUE);
        $block_event_name = $this->input->post('block_event_name', TRUE);
        $block_event_duration = $this->input->post('block_event_duration', TRUE);
        $blocking_remarks = $this->input->post('blocking_remarks', TRUE);
        $staff_id = $this->input->post('staff_id', TRUE);
        $staff_name = $this->input->post('staff_name', TRUE);
        $start = $this->input->post('start', TRUE);

        $data['business'] = $this->business_model->get_business_details();
        
        $business_closing_time = $data['business'][0]['business_closing_time'];
        
        $duration = strtotime($block_event_duration) - strtotime('TODAY');

        //$end = date('Y-m-d\TH:i:s', strtotime($start) + $duration);
        
        
        $end=date('Y-m-d\TH:i:s', strtotime($business_closing_time));
        
        if(strtotime($start) + $duration < strtotime($business_closing_time)){
            $end = date('Y-m-d\TH:i:s', strtotime($start) + $duration);
        }   
        
        $this->load->model('staff_model'); 

        $activestaffs = $this->staff_model->get_active_staff();
            foreach($activestaffs as $activestaff){
            $data = array(
                'business_id' => $this->session->userdata('businessid'),
                'block_event_id' => $block_event_id,
                'staff_id' => $activestaff['id_staff'],
                'staff_name' => $activestaff['staff_fullname'],
                'start_time' => $start,
                'end_time' => $end,
                'remarks' => $blocking_remarks
            );
           $this->scheduler_model->add_staff_block_time($data);
         // var_dump($data); print_r('</br>');
        }
        echo "success";
    }
    
    

    function removeStaffBlockTime() {
        $block_time_event_id = $this->input->post('block_time_event_id', TRUE);
        $result = $this->scheduler_model->remove_staff_block_time($block_time_event_id);
        if ($result) {
            echo "success";
            exit;
        }
    }

    function checkBlockTime() {
        $start = $this->input->post('start', TRUE);
        $staff_id = $this->input->post('staff_id', TRUE);
        $result = $this->scheduler_model->check_block_time($staff_id, $start);
        if ($result) {
            echo 'success';
            exit;
        }
    }

    function getStaffDetails() {
        
        $staff_id= $this->input->post('staff_id');
        $event_id= $this->input->post('event_id');
        
        $staff = $this->scheduler_model->getStaffDetails($staff_id, $event_id);
        echo json_encode($staff);
    }

    function singleServiceCount($service_name, $staff_id, $calendar_date) {
        $data = $this->scheduler_model->single_service_count($service_name, $staff_id, $calendar_date);
        if ($data->servicecount > 0) {
            return "<b>" . $data->servicecount . "</b>";
        } else {
            return 0;
        }
    }

    function getTotalNetAmount($staff_name, $calendar_date) {

        $data = $this->scheduler_model->get_total_net_amount($staff_name, $calendar_date);

        if ($data->netAmount > 0) {
            return "<b>" . $data->netAmount . "</b>";
        } else {
            return 0;
        }
    }

    function getTotalBalance($staff_name, $calendar_date) {

        $data = $this->scheduler_model->get_total_net_amount($staff_name, $calendar_date);

        if ($data->totalBalance > 0) {
            return "<b>" . $data->totalBalance . "</b>";
        } else {
            return 0;
        }
    }

    function getTotalDiscount($staff_name, $calendar_date) {

        $data = $this->scheduler_model->get_total_net_amount($staff_name, $calendar_date);

        if ($data->totalDiscount > 0) {
            return "<b>" . $data->totalDiscount . "</b>";
        } else {
            return 0;
        }
    }

    function getNetAmount($service_name, $staff_name, $calendar_date) {

        $data = $this->scheduler_model->get_net_amount($service_name, $staff_name, $calendar_date);

        if ($data->netAmount > 0) {
            return "<b>" . $data->netAmount . "</b>";
        } else {
            return 0;
        }
    }

    function getBalance($service_name, $staff_name, $calendar_date) {

        $data = $this->scheduler_model->get_net_amount($service_name, $staff_name, $calendar_date);

        if ($data->balanceSum > 0) {
            return "<b>" . $data->balanceSum . "</b>";
        } else {
            return 0;
        }
    }

    function getDiscount($service_name, $staff_name, $calendar_date) {

        $data = $this->scheduler_model->get_net_amount($service_name, $staff_name, $calendar_date);

        if ($data->discountSum > 0) {
            return "<b>" . $data->discountSum . "</b>";
        } else {
            return 0;
        }
    }

    function staffreporting() {
        $staff_id = htmlentities($this->input->post('staff_id', TRUE));
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $staff = $this->scheduler_model->staff_details($staff_id);
            echo $staff->staff_fullname;;
        } else {
            
            $calendar_date = htmlentities($this->input->post('calendar_date', TRUE));

            $staff = $this->scheduler_model->staff_details($staff_id);
            //$services = $this->scheduler_model->total_services_provided($staff_id, $calendar_date);
            $products = $this->scheduler_model->total_products_sold($staff->staff_fullname, $calendar_date);
            //$providedServicesList = $this->scheduler_model->provided_services_list($staff_id, $calendar_date);

            $providedServicesList = $this->scheduler_model->staff_day_services($staff_id, $calendar_date);
            $recoveriesList = $this->scheduler_model->staff_day_recoveries($staff_id, $calendar_date);

            $html = "<table class='table table-condensed table-bordered table-hover'>";
            $html .= "<thead>";
            $html .= "<tr>";
            $html .= "<th>Service</th>";
            $html .= "<th>Count</th>";
            //$html .= "<th>Price</th>";
            //$html .= "<th>Discount</th>";
            //$html .= "<th>Revenue Share</th>";
            $html .= "</tr>";
            $html .= "</thead>";
            $html .= "<tbody>";

            $totalservices=0;
            $totaldiscountedprice=0;
            $totaldiscount=0;
            $totalshare=0;
            foreach ($providedServicesList as $service) {

                $html .= "<tr>";
                $html .= "<td>" . $service->service_category ."-".$service->service_name . "</td>";
                $html .= "<td>" . $service->count . "</td>";
                //$html .= "<td class='netamount'>" . $service->discounted_price . "</td>";
                //$html .= "<td class='discount text-danger'>" . $service->discount . "</td>";
                //$html .= "<td class='share text-success'>" . $service->revenue_share . "</td>";
                $html .= "</tr>";
                $totalservices = $totalservices+ $service->count;
                //$totaldiscountedprice = $totaldiscountedprice+ $service->discounted_price;
                //$totaldiscount = $totaldiscount+ $service->discount;
                //$totalshare = $totalshare+ $service->revenue_share;

            }

             $html .= "<tr style='background: #f4f8fb;'>";
            $html .= "<td><b>Totals</b></td>";
            //$html .= "<td><b>" . $services->totalservices . "</b></td>";
            $html .= "<td><b>" . $totalservices . "</b></td>";
            //$html .= "<td id='totalNetAmount'></td>";
           // $html .= "<td id='totalDiscount' class='text-danger'></td>";
           // $html .= "<td id='totalShare' class='text-success'></td>";
            $html .= "</tr>";

            $html .= "<tr><td colspan=4><b>Recoveries</b></td></tr>";
            $totalrecovery=0;
            $recoveryservices=0;
            foreach ($recoveriesList as $service) {
                if(floatval($service->revenue_share)>0){
                    $html .= "<tr>";
                    $html .= "<td>" . $service->service_category ."-".$service->service_name . "</td>";
                    $html .= "<td>" . $service->count . "</td>";
                    //$html .= "<td class='netamount'>" . $service->discounted_price . "</td>";
                   // $html .= "<td class='discount text-danger'>Recovery</td>";
                   // $html .= "<td class='share text-success'>" . $service->revenue_share . "</td>";
                    $html .= "</tr>";
                    $recoveryservices = $recoveryservices+ $service->count;
                    //$totaldiscountedprice = $totaldiscountedprice+ $service->discounted_price;
                    //$totaldiscount = $totaldiscount+ $service->discount;
                    $totalrecovery = $totalrecovery+ $service->revenue_share;
                }
            }

            $html .= "<tr style='background: #f4f8fb;'>";
            $html .= "<td><b>Totals</b></td>";
            //$html .= "<td><b>" . $totalservices . "</b></td>";
            $html .= "<td><b>".$recoveryservices."</b></td>";
            //$html .= "<td id='totalNetAmount'></td>";
           // $html .= "<td id='totalDiscount' class='text-danger'></td>";
           // $html .= "<td id='totalrecovery' class='text-success'><b>".$totalrecovery."</b></td>";
            $html .= "</tr>";

            $html .= "</tbody>";

            $html .= "</table>";

            $html .= "<p>Total Retail: Rs. <b>" . (!empty($products->retailcount) ? $products->retailcount : 0) . "<b><p>";

            $staff_name = $staff->staff_fullname;
            $staff_image = base_url() . "assets/images/staff/" . $staff->staff_image;


            //echo $staff_name . "|" . $staff_image . "|" . $services->totalservices . "|" . $html;
            echo $staff_name . "|" . $staff_image . "|" . $totalservices . "|" . $html . "|" . number_format($totaldiscountedprice) . "|" . number_format($totaldiscount) . "|" . number_format($totalshare)  ;
    
        }
    }

    function updateVoucher() {

        $voucher_number_option = 'C' . htmlspecialchars($this->input->post('voucher_number_option', TRUE));

        $num_rows = $this->scheduler_model->check_voucher_number($voucher_number_option);

        if ($num_rows === 0) {

            $result = $this->scheduler_model->insert_voucher();
            if ($result) {
                echo 'success|' . $result;
            }
        } else {
            echo 'already_exist';
        }
    }

    function openvoucher($voucher_id) {
        //$invoiceid=$this->input->post('invoiceid');

        $data['nav'] = 'my_business';
        $data['subnav'] = 'voucher_list';
        $data['menu'] = 'hidden';
        
        //Get the voucher details
        $data['voucher'] = $this->scheduler_model->getvoucherbyid($voucher_id);

        $ids = explode('|', $data['voucher']->service_ids);

        //Get the voucher services
        $data['services'] = $this->scheduler_model->getvoucherservices($ids);

        $data['business'] = $this->business_model->getbusinessdetails();

        $this->load->view('includes/header', $data);
        $this->load->view('voucher_print_view');
        $this->load->view('includes/footer');
    }

    function getColorNumbersByTypeId() {

        $type_id = htmlentities($this->input->post('type_id', TRUE));

        $data = $this->scheduler_model->get_color_numbers_by_type_id($type_id);
        echo json_encode($data);
    }

    public function getColorTypes() {

        $data = $this->scheduler_model->getcolortypes();
        echo json_encode($data);
    }

    function cancelVisit() {

        $visitid = htmlspecialchars($this->input->post('visitid', TRUE));

        //$info = $this->scheduler_model->getVisitDetails($visit_service_id);

        $update = $this->scheduler_model->cancelVisit($visitid);

        if ($update) {

            $services = $this->scheduler_model->allVisitServices($visitid);

            echo json_encode($services);
        }
    }

    function cancelVisitKeepAdv() {

        $visitid = htmlspecialchars($this->input->post('visitid', TRUE));

        //$info = $this->scheduler_model->getVisitDetails($visit_service_id);

        $update = $this->scheduler_model->cancelVisitKeepAdv($visitid);

        if ($update) {

            $services = $this->scheduler_model->allVisitServices($visitid);

            echo json_encode($services);
        }
    }
    
    function cancelVisitService() {

        $visit_service_id = htmlspecialchars($this->input->post('visit_service_id', TRUE));

        $info = $this->scheduler_model->getVisitDetails($visit_service_id);

        $total_services = count($this->scheduler_model->allVisitServices($info[0]['customer_visit_id']));

        if ($total_services > 1) {

            $result = $this->scheduler_model->removeVisitService($visit_service_id);

            if ($result) {
                echo "success";
            }
        } else {
            echo "one_service";
        }
    }

    public function getOrderbyid($qtype = 0) {

        $orderid = $this->input->post('id_customer_order', TRUE);

        if ($qtype == 0) {
            $data = $this->scheduler_model->getopenorderbyid($orderid);
        } else {
            $data = $this->scheduler_model->getorderbyid($orderid);
        }
        echo json_encode($data);
    }

    public function getvisitdetails() {

        $visit_service_id = htmlspecialchars($this->input->post('visit_service_id', TRUE));
        $data['visit'] = $this->scheduler_model->getVisitDetails($visit_service_id);
        $customer_visit_id = $data['visit'][0]['id_customer_visits'];
        $data['services'] = $this->scheduler_model->getServicesByVisitId($customer_visit_id);
        $this->load->model('visits_model');
        $data['advances'] = $this->visits_model->getopenvisitadvancebyid($customer_visit_id);
        //print_r($data['visit']); exit;
        echo json_encode($data);
    }

    public function getvisitinvoiceid() {

        $visit_service_id = htmlspecialchars($this->input->post('visit_service_id', TRUE));
        $data = $this->scheduler_model->getVisitInvoiceId($visit_service_id);
        if (!empty($data->id_invoice)) {
            echo 'success|' . $data->id_invoice;
        }
    }

    function add_visit_service_staffs() {
        $staff_ids = $this->input->post('staff_ids', TRUE);
        $staff_names = $this->input->post('staff_names', TRUE);
        $visit_service_id = $this->input->post('visit_service_id', TRUE);
        $visit_id = $this->input->post('visit_id', TRUE);
        $duplicates = $this->scheduler_model->check_visit_services_staff($staff_ids, $visit_service_id);
        if($duplicates){
            echo 'duplicates|' . json_encode($duplicates);
        } else{
            $result = $this->scheduler_model->add_visit_services_staff($staff_ids, $staff_names, $visit_id, $visit_service_id);
            if ($result) {
                echo 'success|' . $result;
            }
        }
        
    }

    function active_staff_list() {
        $data = $this->scheduler_model->staff_list();
        echo json_encode($data);
    }

    public function updatevisit() {

        $id_visit_services = htmlspecialchars($this->input->post('id_visit_services', TRUE));
        $old_staff_id = htmlspecialchars($this->input->post('old_staff_id', TRUE));
        $staff_id = htmlspecialchars($this->input->post('staff_id', TRUE));
        $start = htmlspecialchars($this->input->post('start', TRUE));
        $end = htmlspecialchars($this->input->post('end', TRUE));

        $staff = $this->scheduler_model->getStaff($staff_id);

        $staffData = array(
            'staff_id' => $staff_id,
            'staff_name' => $staff->staff_fullname
        );

        $serviceData = array(
            'visit_service_start' => $start,
            'visit_service_end' => $end,
            'update_date' => date('Y-m-d H:i:s')
        );

        $update = $this->scheduler_model->updateVisit($id_visit_services, $old_staff_id, $staffData, $serviceData);

        if ($update) {
            $data = $this->scheduler_model->getMaxVisitServiceId(date('Y-m-d', strtotime($start)));
            echo "success|" . $data->update_date;
        }
    }

    public function updateVisitService() {

        $vsid = stripcslashes($this->input->post('vsid', TRUE));
        $service_id = stripcslashes($this->input->post('service_id', TRUE));
        $service_name = stripcslashes($this->input->post('service_name', TRUE));
        $service_category = htmlspecialchars($this->input->post('service_category', TRUE));

        $data = array(
            'service_id' => $service_id,
            'service_name' => $service_name
        );

        $service = $this->scheduler_model->getVisitId($vsid);

        if ($service_category === "Hair Color" || $service_category === "Hair color" || $service_category === "hair color") {

            $service_visit_id = $vsid;

            $color_type_id = htmlspecialchars($this->input->post('color_type_id', TRUE));
            $color_type_name = htmlspecialchars($this->input->post('color_type_name', TRUE));
            $color_no_id = htmlspecialchars($this->input->post('color_no_id', TRUE));
            $color_no_name = htmlspecialchars($this->input->post('color_no_name', TRUE));
            $color_duration = htmlspecialchars($this->input->post('color_duration', TRUE));
            $color_cost = htmlspecialchars($this->input->post('color_cost', TRUE));

            $serviceInfo = array(
                'service_id' => $service_id,
                'service_name' => $service_name,
                'color_type_id' => $color_type_id,
                'color_type_name' => $color_type_name,
                'color_no_id' => $color_no_id,
                'color_no_name' => $color_no_name,
                'color_duration' => $color_duration,
                'color_cost' => $color_cost
            );

            $check = $this->scheduler_model->check_services_extra($service_visit_id);

            if ($check) {

                $this->scheduler_model->update_services_extra($service_visit_id, $serviceInfo);
            } else {

                $customer_visit_id = $service->customer_visit_id;
                $service_visit_id = $vsid;

                $customer_id = htmlspecialchars($this->input->post('customer_id', TRUE));
                $customer_name = htmlspecialchars($this->input->post('customer_name', TRUE));
                $staff_id = htmlspecialchars($this->input->post('staff_id', TRUE));
                $staff_name = htmlspecialchars($this->input->post('staff_name', TRUE));
                $color_type_id = htmlspecialchars($this->input->post('color_type_id', TRUE));
                $color_type_name = htmlspecialchars($this->input->post('color_type_name', TRUE));
                $color_no_id = htmlspecialchars($this->input->post('color_no_id', TRUE));
                $color_no_name = htmlspecialchars($this->input->post('color_no_name', TRUE));
                $color_duration = htmlspecialchars($this->input->post('color_duration', TRUE));
                $color_cost = htmlspecialchars($this->input->post('color_cost', TRUE));

                $serviceInfo = array(
                    'visit_services_id' => $service_visit_id,
                    'business_id' => $this->session->userdata('businessid'),
                    'customer_visit_id' => $customer_visit_id,
                    'customer_id' => $customer_id,
                    'customer_name' => $customer_name,
                    'staff_id' => $staff_id,
                    'staff_name' => $staff_name,
                    'service_id' => $service_id,
                    'service_name' => $service_name,
                    'color_type_id' => $color_type_id,
                    'color_type_name' => $color_type_name,
                    'color_no_id' => $color_no_id,
                    'color_no_name' => $color_no_name,
                    'color_duration' => $color_duration,
                    'color_cost' => $color_cost
                );

                $this->scheduler_model->add_services_extra($serviceInfo);
            }
        } else {

            $service_ids = $this->scheduler_model->checkDuplicateServices($service->customer_visit_id);

            if ($service_ids) {
                if (in_array($service_id, $service_ids)) {
                    echo 'already_exist';
                    exit;
                }
            }

            $this->scheduler_model->remove_services_extra($vsid);
        }

        $update = $this->scheduler_model->update_visit_service($data, $vsid);

        if ($update) {

            echo "success";
        }
    }

    public function addvisits() {
        
        
        $visit_id = htmlspecialchars($this->input->post('visit_id', TRUE));
        $customer_id = htmlspecialchars($this->input->post('customer_id', TRUE));
        $last_color_code = htmlspecialchars($this->input->post('last_color_code', TRUE));
        $start = htmlspecialchars($this->input->post('start', TRUE));
        
        //$business = $this->business_model->get_business_timing();
                
        $customer_visit_id = $this->scheduler_model->add_visit($customer_id, $visit_id, $last_color_code, $start);

        $result = $this->scheduler_model->add_visit_services($customer_visit_id);

//        $services = $this->scheduler_model->getOpenVisitServicesById($customer_visit_id);

//        $i = 0;
//        foreach ($services as $service) {
//            $duration = strtotime($service->service_duration) - strtotime('TODAY');
//            $services[$i]->visit_service_end = empty($service->visit_service_end) ? date('Y-m-d\TH:i:s', strtotime($service->visit_service_start) + $duration) : $service->visit_service_end;
//            $i++;
//        }

        echo "success|" . $customer_visit_id;
    }

    public function updatevisitpos(){
        
        $visit_id = htmlspecialchars($this->input->post('visit_id', TRUE));
        $customer_id = htmlspecialchars($this->input->post('customer_id', TRUE));
        $last_color_code = htmlspecialchars($this->input->post('last_color_code', TRUE));
        $start = htmlspecialchars($this->input->post('start', TRUE));
        
        
        $delete = $this->scheduler_model->cancelVisit($visit_id);
        
                
        $customer_visit_id = $this->scheduler_model->add_visit($customer_id, 0, $last_color_code, $start);

        $result = $this->scheduler_model->add_visit_services($customer_visit_id);

        echo "success|" . $customer_visit_id;
    }
    
    
    function changeVisitColor(){
        
        $visit_id = htmlspecialchars($this->input->post('visit_id', TRUE));
        $visit_color = htmlspecialchars($this->input->post('visit_color', TRUE));
        
        $result = $this->scheduler_model->change_visit_color($visit_id, $visit_color);
        
        echo "success|" . $result;
    }
    
    function getAllVisits() {
        $openvisits = $this->scheduler_model->getOpenVisitsAfterAdd();

//        $i = 0;
//        foreach ($openvisits as $visit) {
//            $duration = strtotime($visit['service_duration']) - strtotime('TODAY');
//            $openvisits[$i]['visit_service_end'] = empty($visit['visit_service_end']) ? date('Y-m-d\TH:i:s', strtotime($visit['visit_service_start']) + $duration) : $visit['visit_service_end'];
//            $i++;
//        }

        echo json_encode($openvisits);
    }

    function getAllVisitsByDate() {
        $start = htmlspecialchars($this->input->post('start', TRUE));
        $end = htmlspecialchars($this->input->post('end', TRUE));
        $previous = htmlspecialchars($this->input->post('previous', TRUE));
        $today = date('Y-m-d');

        if ($this->session->userdata('role') !== "Admin") {
            if ($previous === "N") {
                if ($today <= $start) {
                    $start = $start;
                } else {
                    $start = $today;
                }
            }
        }
        //echo $start.'----'.$end; exit;

        if ($end === "") {
            $end = date('Y-m-d', strtotime($start . '+1 day'));
        }

        $sh=false;
        if ($this->session->userdata('role') == "Sh-Users") {
            $sh=true;
        }
        $openvisits = $this->scheduler_model->getOpenVisitsByDate($start, $end, $sh);

        //print_r($openvisits); exit;

        $k = 0;
//        foreach ($openvisits as $openvisit) {
//            $i = 0;
//            foreach ($openvisit as $visit) {
//                if ($visit['service_duration'] === '00:00:00') {
//                    $visit['service_duration'] = '00:30:00';
//                }
//                $duration = strtotime($visit['service_duration']) - strtotime('TODAY');
//                $openvisits[$k][$i]['visit_service_end'] = empty($visit['visit_service_end']) ? date('Y-m-d\TH:i:s', strtotime($visit['visit_service_start']) + $duration) : $visit['visit_service_end'];
//                $i++;
//            }
//            $k++;
//        }

        $data['block_events'] = $this->scheduler_model->get_staff_blocked_events($start, $end);
        $data['visit_events'] = $openvisits;
        $data['visit_count'] = $this->scheduler_model->visitCount($start, $end);
        $forcasted = $this->scheduler_model->serviceCount($start, $end);
        
        
        
        if(null !== $forcasted){
            $data['service_count'] = $forcasted->total;
            $data['service_forecast'] = $forcasted->forecast;
        } else {
            $data['service_count'] = 0;
            $data['service_forecast'] = 0;
        }
        
        $data['visit_last_color'] = $this->scheduler_model->getLastVisitColor($start, $end);



        echo json_encode($data);
    }

    function getAllNewVisits() {
        $start = htmlspecialchars($this->input->post('start', TRUE));
        $previous = htmlspecialchars($this->input->post('previous', TRUE));
        $last_update_date = $this->input->post('last_update_date', TRUE);
        $today = date('Y-m-d');

        if ($this->session->userdata('role') !== "Admin") {
            if ($previous === "N") {
                if ($today <= $start) {
                    $start = $start;
                } else {
                    $start = $today;
                }
            }
        }

        $openvisits = $this->scheduler_model->getOpenNewVisits($start, $last_update_date);

//        $k = 0;
//        foreach ($openvisits as $openvisit) {
//            $i = 0;
//            foreach ($openvisit as $visit) {
//                if ($visit['service_duration'] === '00:00:00') {
//                    $visit['service_duration'] = '00:30:00';
//                }
//                $duration = strtotime($visit['service_duration']) - strtotime('TODAY');
//                $openvisits[$k][$i]['visit_service_end'] = empty($visit['visit_service_end']) ? date('Y-m-d\TH:i:s', strtotime($visit['visit_service_start']) + $duration) : $visit['visit_service_end'];
//                $i++;
//            }
//            $k++;
//        }

        $tomorrow = date('Y-m-d', strtotime($start . '+1 day'));
        //echo $this->input->post('doblock'); exit(); 
        if($this->input->post('doblock') ==1){
            $data['block_events'] = "";
            
        }else {
            $data['block_events'] = $this->scheduler_model->get_staff_blocked_events($start, $tomorrow);
        }
        $data['visit_events'] = $openvisits;
        $forcasted = $this->scheduler_model->serviceCount($start, $tomorrow);
        if(null !== $forcasted){
            $data['service_count'] = $forcasted->total;
            $data['service_forecast'] = $forcasted->forecast;
        } else {
            $data['service_count'] = 0;
            $data['service_forecast'] = 0;
        }
        $data['visit_count']=$this->scheduler_model->visitCount($start, $tomorrow);

        echo json_encode($data);
    }

    function getMaxVisitServiceId() {
        $start = htmlspecialchars($this->input->post('start', TRUE));
        $data = $this->scheduler_model->getMaxVisitServiceId($start);
        echo $data->update_date;
    }

    public function updateVisitTime() {
        $visit_sid = stripcslashes($this->input->post('visit_sid', TRUE));
        $visitid = stripcslashes($this->input->post('visitid', TRUE));
        $service_id = stripcslashes($$this->input->post('service_id', TRUE));
        $start = stripcslashes($this->input->post('start', TRUE));
        $end = stripcslashes($this->input->post('end', TRUE));

        $data = array(
            'visit_service_start' => $start,
            'visit_service_end' => $end
        );

        if ($visitid === "") {
            $result = $this->scheduler_model->update_visit_service($data, $visit_sid);
        } else {
            $result = $this->scheduler_model->update_visit_time($data, $visitid, $service_id, $visit_sid);
        }

        if ($result) {
            echo "success";
        } else {
            echo "error";
        }
    }

    public function getStaffImages() {
        $staff_id = $this->input->post('staff_id', TRUE);
        $staff = $this->scheduler_model->staff_info($this->session->userdata('businessid'), $staff_id);
        $img_path = base_url() . 'assets/images/staff/';
        $staff_image = file_exists('assets/images/staff/' . $staff->staff_image) ? $img_path . $staff->staff_image : $img_path . "no-image.png";
        echo $staff_image;
    }

    function getAllStaff() {

        $data = $this->scheduler_model->get_all_staff();
        echo json_encode($data);
    }

    

    public function half_full_dayoff() {
        $data = array();

        $event_staffby_id = $this->scheduler_model->get_eventstaff_by_id();
        if ($event_staffby_id && $event_staffby_id !== NULL) {
            echo "Event|" . $event_staffby_id->visit_status;
            exit();
        }

        $block_staffby_id = $this->scheduler_model->get_blockstaff_by_id();
        if ($block_staffby_id && $block_staffby_id !== NULL) {
            echo "Block|" . $block_staffby_id->start_time . '|' . $block_staffby_id->end_time;
            exit();
        }

        $blocktime = 1;
        echo ($blocktime);
    }

    public function half_fulltime_block() {
        $block_event_id = $this->input->post('block_event_id', TRUE);
        $block_event_name = $this->input->post('block_event_name', TRUE);
        $block_event_duration = $this->input->post('block_event_duration', TRUE);
        $blocking_remarks = $this->input->post('blocking_remarks', TRUE);
        $staff_id = $this->input->post('staff_id', TRUE);
        $staff_name = $this->scheduler_model->get_staffname($staff_id);
        $tagged = $this->input->post('tagged', TRUE);
        $block_calendar_date = $this->input->post('block_calendar_date');

        $start;
        $end;

        if ($tagged && $tagged === "fullday") {
            $start = $this->input->post('start', TRUE);
            $start = $block_calendar_date . 'T' . $start;

            $end = $this->input->post('end', TRUE);
            $end = $block_calendar_date . 'T' . $end;
        }

        if ($tagged && $tagged === "halfday") {
            $start = $this->input->post('start', TRUE);
            $start = explode(':', $start);
            $start = $start[0];

            //calculation for end time;
            $end = $this->input->post('end', TRUE);
            $end = explode(':', $end);
            $end = $end[0];

            $half_day = $end - $start;
            $endtime = $half_day / 2;
            $end = $endtime + $start;
            $end = round($end);
            $end = $end . ':00:00';
            $end = $block_calendar_date . 'T' . $end;

            $start = $block_calendar_date . 'T' . $this->input->post('start', TRUE);
        }

        $data = array(
            'business_id' => $this->session->userdata('businessid'),
            'block_event_id' => $block_event_id,
            'staff_id' => $staff_id,
            'staff_name' => $staff_name,
            'start_time' => $start,
            'end_time' => $end,
            'remarks' => $blocking_remarks
        );

        $this->scheduler_model->add_staff_block_time($data);

        echo "success";
    }
    
    public function reminder_message_update(){
        $data = $this->scheduler_model->reminder_message_update();
        if($data){
            echo "success|".$data."|".$this->input->post('reminder');
            exit;
        }
    }

    public function change_date(){
        
        if($this->input->post('cd_type')=="service"){
            $this->change_single_date();
        } else {
            $mydate= $this->input->post('cd_calenderDate'); 
            $mydate= date_format(date_create($mydate),'m/d/Y');        

            $visitid=$this->input->post('cd_visit_id');

            $visit_service_ids = $this->visits_model->getvisitserviceids($visitid);
            //var_dump($visit_service_ids); exit();
            //$visit_service_id = $this->input->post('cd_visit_service_id');
            $newdate=  $this->input->post('new_date');

            foreach($visit_service_ids as $visit_service_id){        
                $result = $this->scheduler_model->change_date($newdate, $visit_service_id["id_visit_services"]);
            }

            $this->session->set_flashdata('defaultDate', $mydate);
            redirect('scheduler');           
        }
    }
    public function change_single_date(){
       // echo $this->input->post('cd_visit_service_id');
       // exit();
        $mydate= $this->input->post('cd_calenderDate'); 
        $mydate= date_format(date_create($mydate),'m/d/Y');        
        
        $visit_service_id = $this->input->post('cd_visit_service_id');
        $newdate=  $this->input->post('new_date');
        
        $result = $this->scheduler_model->change_date($newdate, $visit_service_id);
        
        $this->session->set_flashdata('defaultDate', $mydate);
        redirect('scheduler');           
        
    }
    
    public function change_visit_services_date(){
    
        $visit_service_date = $this->input->post('visit_service_date'); 
        $visit_service_ids =  $this->input->post('visit_service_ids'); 
        
        
        foreach($visit_service_ids as $visit_service_id){
            
            $result = $this->scheduler_model->change_date($visit_service_date, $visit_service_id);
            
        }
        echo "success|";
        exit;
    }
    
    public function change_staff(){
        $mydate= $this->input->post('cs_calenderDate'); 
        $mydate= date_format(date_create($mydate),'m/d/Y');
        
        $visit_service_staff_id=$this->input->post('cs_visit_service_staff_id');
        $newstaff=  $this->input->post('new_staff');
        
        $result = $this->scheduler_model->change_staff($newstaff, $visit_service_staff_id);
        
            $this->session->set_flashdata('defaultDate',$mydate);
            redirect('scheduler');    
        
    }
    
}
