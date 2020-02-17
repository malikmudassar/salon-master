<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('sales_model');
        $this->load->model("dashboard_model");
        $this->load->model("staff_model");
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        }
    }

    public function salesreport() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 1, 0);

            $data['nav'] = 'reports';
            $data['subnav'] = 'sales';

            $data['chart']='chart';
            $data['nodatatable']='nodatatable';
            $this->load->view('includes/header', $data);
            $this->load->view('sales_view');
            $this->load->view('includes/footer');
        }
    }

    public function salesreport_json() {
        $data = $this->sales_model->salesreport_json();
        echo json_encode($data);
    }

    public function staff_sale() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 1, 0);

            $data['nav'] = 'reports';
            $data['subnav'] = 'staff_sale';

            $staff = $this->staff_model->all_staff();

            //Now load time chart work stop from here to below.....
            $months = array(
                'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0,
                'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0,
                'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0
            );

            $html = "";

    //        foreach ($staff as $s) {
    //            if ($s['staff_active'] == 'Y') {
    //                $sales = $this->sales_model->staff_sale($s['id_staff']);
    //                // echo "<pre>";echo json_encode($sales);echo "</pre>";
    //                $staffname = $s['staff_fullname'];
    //                $html .= "{ name: '$staffname', ";
    //
    //                $html .= "data: [";
    //
    //                foreach ($sales as $sale) {
    //                    if ($sale['staff_id'] != 0) {
    //                        foreach ($months as $key => $value) {
    //                            if ($sale['month'] == $key) {
    //                                $months[$key] = $sale['sub_total'];
    //                            }
    //                        }
    //                    } else {
    //                        foreach ($months as $key => $value) {
    //                            $months[$key] = 0;
    //                        }
    //                    }
    //                }
    //
    //                foreach ($months as $m) {
    //                    $html .= $m . ",";
    //                }
    //
    //                $html .= "] ";
    //
    //                $html .= "},";
    //            }
    //        }
            //Now load time chart work stop from above to here.....
            //echo $html;exit;
            // die;
            $data['staff'] = $staff;
            $data['chart']='chart';
            $data['nodatatable']='nodatatable';
           // $data['sales'] = rtrim($html, ',');
            //echo "<pre>";echo $data['sales'];echo "</pre>";die;
            $this->load->view('includes/header', $data);
            $this->load->view('staff_sale_view');
            $this->load->view('includes/footer');
        }
    }

    public function staff_sale_graph() {
        //storemanager,hr,reception...user serial
        checkroles(0, 1, 0);

        $staff_id = $this->input->post('staff_id');
        $staff_name = $this->input->post('staff_name');
        $newdata = [];

        $years = date('Y');

        for ($x = 0; $x <= 3; $x++) {
            $data = [];
            $sales = $this->sales_model->staff_sale_ajax($years - $x, $staff_id);

            foreach ($sales as $sale) {
                array_push($data, (float) $sale['data']);
            }
            array_push($newdata, ['name' => $years - $x, 'data' => $data]);
        }
        echo json_encode($newdata);

        exit;
    }

    public function get_multiple_staff_sale() {
        //storemanager,hr,reception...user serial
        checkroles(0, 1, 0);

        $staff_id = $this->input->post('staff_ids');
        $staff_name = $this->input->post('staff_names');
        $year = $this->input->post('year');
        $newdata = [];

        for ($x = 0; $x < count($staff_id); $x++) {
            $data = [];
            $sales = $this->sales_model->get_multiple_staff_sale($year, $staff_id[$x]);

            foreach ($sales as $sale) {
                array_push($data, (float) $sale['data']);
            }
            array_push($newdata, ['name' => $staff_name[$x], 'data' => $data]);
        }
        echo json_encode($newdata);

        exit;
    }

    public function retail_charts() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 1, 0);

            $data['nav'] = 'reports';
            $data['subnav'] = 'retail_charts';

            //echo "<pre>";echo $data['sales'];echo "</pre>";die;
            $data['chart']='chart';
            $data['nodatatable']='nodatatable';
            $this->load->view('includes/header', $data);
            $this->load->view('retail_charts_view');
            $this->load->view('includes/footer');
        }
    }

    function get_product_sale() {

        $month = $this->input->post('month', TRUE);
        //$productid= $this->input->post('product_id', TRUE);
        $product_names = $this->input->post('product_names', TRUE);
        $newdata = [];
        $sale = [];

        $list = array();
        $month = $this->input->post('month', TRUE); //11;
        $year = $this->input->post('year', TRUE); //11;

        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month) {
                $list[] = date('Y-m-d', $time);
            }
        }
        foreach ($product_names as $product) {
            $x = 0;
            $sale = [];
            foreach ($list as $mDate) {
                $sales[$x] = $this->sales_model->get_product_sale_bydate($mDate, $product);
                if ($sales[$x]) {
                    foreach ($sales[$x] as $row) {
                        array_push($sale, intval($row->data));
                    }
                } else {
                    array_push($sale, 0);
                }
                $x++;
            }
            array_push($newdata, ['name' => $product, 'data' => $sale]);
        }
        echo json_encode($newdata);
    }

    function get_retail_comparison() {
        $productid = $this->input->post('product_id', TRUE);
        $product_name = $this->input->post('product_name', TRUE);
        $newdata = [];


        $years = date('Y');

        for ($x = 0; $x <= 3; $x++) {
            $data = [];
            $sales = $this->sales_model->get_product_sale_byyear($years - $x, $product_name);

            foreach ($sales as $sale) {
                array_push($data, (float) $sale->data);
            }
            array_push($newdata, ['name' => $years - $x, 'data' => $data]);
        }
        echo json_encode($newdata);
    }

    function get_retail_chart() {
        $start = $this->input->post('start', TRUE);
        $end = $this->input->post('end', TRUE);
        $type = $this->input->post('type', TRUE);
        $product_ids = $this->input->post('product_ids', TRUE);
        $product_names = $this->input->post('product_names', TRUE);

        $html = "";
        $x_axis = "";

        foreach ($product_names as $product_name) {
            $sales = $this->sales_model->retail_sales($product_name);
            $html .= "{name: '$product_name', ";
            $html .= "data: [";

            foreach ($sales as $sale) {
                if ($type === 'days') {
                    $x_axis .= date('d-M', strtotime($sale->invoice_product_date)) . ',';
                    //$dates[] = date('d-M', strtotime($sale->invoice_product_date));
                } else {
                    $x_axis .= date('M', strtotime($sale->invoice_product_date)) . ',';
                }
                $html .= intval($sale->discounted_price) . ",";
            }


            $html .= "]";
            $html .= "},";
        }

        $data['category'] = rtrim($x_axis, ',');
        $data['series'] = rtrim($html, ',');
        echo json_encode($data);
    }

    public function service_chart_view() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            //storemanager,hr,reception...user serial
            checkroles(0, 1, 0);

            $data['nav'] = 'reports';
            $data['subnav'] = 'service_chart';

            $staff = $this->staff_model->all_staff();
            $data['service_category'] = $this->sales_model->get_service_catgory();

            //echo "<pre>";echo $data['sales'];echo "</pre>";die;
            $data['chart']='chart';
            $data['nodatatable']='nodatatable';
            $this->load->view('includes/header', $data);
            $this->load->view('service_chart_view');
            $this->load->view('includes/footer');
        }
    }

    public function get_services() {
        $data['services'] = $this->sales_model->get_service();
        echo (json_encode($data));
        exit();
    }

    public function getservice_chart_sale1() {////Old funtion was using for service chart.............
        //$data['chart_sale'] = $this->sales_model->getservice_chart_sale();
        $years = $this->sales_model->get_service_sale_year();

        $months = array(
            'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0,
            'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0,
            'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0
        );

        $html = "";

        foreach ($years as $s) {

            $sales = $this->sales_model->getservice_chart_sale($s['year']);
            $yearname = $s['year'];
            $html .= "{ name: '$yearname', ";

            $html .= "data: [";

            foreach ($sales as $sale) {
                if ($sale['service']) {
                    foreach ($months as $key => $value) {
                        if ($sale['monthname'] == $key) {
                            $months[$key] = $sale['PaidAmount'];
                            //array_push($sale, intval($row->data));
                        }
                    }
                } else {
                    foreach ($months as $key => $value) {
                        $months[$key] = 0;
                        //array_push($sale, intval($row->data));
                    }
                }
            }

            foreach ($months as $m) {
                $html .= $m . ",";
            }

            $html .= "] ";

            $html .= "},";
        }

        //echo $html;exit;
        // die;
        $datasales = rtrim($html, ',');
        //array_push($newdata, ['name' => $product, 'data' => $sale]);

        echo (json_encode($datasales));
        exit();
    }

    function getservice_chart_sale() {

        //$productid = $this->input->post('product_id', TRUE);
        //$product_name = $this->input->post('product_name', TRUE);
        $newdata = [];

        $years = date('Y');

        for ($x = 0; $x <= 3; $x++) {
            $data = [];
            $sales = $this->sales_model->getservice_chart_sale($years - $x);

            foreach ($sales as $sale) {
                array_push($data, (float) $sale->data);
            }
            array_push($newdata, ['name' => $years - $x, 'data' => $data]);
        }
        echo json_encode($newdata);

        exit;

//        $newdata = [];
//        $years = $this->sales_model->get_service_sale_year();
//        $salepuch = array();
//        $months = array(
//            'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0,
//            'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0,
//            'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0
//        );
//        $array = array();
//        foreach ($years as $y) {
//            $sales = $this->sales_model->getservice_chart_sale($y['year']);
//            
//            foreach ($sales as $sale) {
//                foreach ($months as $key => $value) {
//                    if ($key === $sale['Month'] && $sale['Year'] === $y['year']) {
//                        //$array[$key] = $sale['paid'];
//                        $months[$key] = floatval($sale['paid']);
//                    } else {
//                       // $months[$key] = 0;
//                    }
//                }
//            }
//            foreach ($months as $key => $value) {
//                $array[] = $value;
//            }
//            array_push($newdata, ['name' => $y['year'], 'data' => $array]);print_r($array);
//            unset($array);
//        }
        //echo json_encode($newdata);
    }

    function get_multiple_service_sale() {

        $month = $this->input->post('month', TRUE);
        //$productid= $this->input->post('product_id', TRUE);
        $service_names = $this->input->post('service_names', TRUE);
        $service_ids = $this->input->post('service_ids', TRUE);

        $newdata = [];
        $sale = [];

        $list = array();
        $month = $this->input->post('month', TRUE); //11;
        $year = $this->input->post('year', TRUE);

        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month) {
                $list[] = date('Y-m-d', $time);
            }
        }
        foreach ($service_ids as $service) {
            $x = 0;
            $sale = [];
            foreach ($list as $mDate) {
                $sales[$x] = $this->sales_model->get_service_sale_bydate($mDate, $service, $this->input->post('category_name'));
                if ($sales[$x]) {
                    foreach ($sales[$x] as $row) {
                        array_push($sale, intval($row->data));
                    }
                } else {
                    array_push($sale, 0);
                }
                $x++;
            }
            array_push($newdata, ['name' => $service, 'data' => $sale]);
        }
        echo json_encode($newdata);
    }

}
