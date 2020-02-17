<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Retaildashboard_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('retaildashboard_model');
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        }
    }

    public function retaildashboard() {
        
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            // business_sale data inserting
            $previousmonth = date('M', strtotime('first day of previous month'));
            $previousyear = date('Y', strtotime('first day of previous month'));

            $month = date('M', strtotime('first day of this month'));
            $year = date('Y', strtotime('first day of this month'));

            $result = $this->retaildashboard_model->get_business_sale_year_month($month, $year);

            if ($result) {
                //update for this month
                $start = date('Y-m-d', strtotime('first day of this month'));
                $end = date('Y-m-d', strtotime('last day of this month'));
                $thismonth = $this->retaildashboard_model->get_this_month_year_sale($start, $end);
                $data = array(
                    'business_id' => $this->session->userdata('businessid'),
                    'month' => date('M', strtotime($start)),
                    'year' => date('Y', strtotime($start)),
                    'total_sale' => empty($thismonth->total_sale) ? 0 : $thismonth->total_sale
                );
                $id = $result->id_retail_sales;
                $thisdone = $this->retaildashboard_model->update_this_month_year_sale($data, $id);

            } else {
                //update for previous month
                $start = date('Y-m-d', strtotime('first day of previous month'));
                $end = date('Y-m-d', strtotime('last day of previous month'));

                $result = $this->retaildashboard_model->get_business_sale_year_month($previousmonth, $previousyear);

                $previous = $this->retaildashboard_model->get_this_month_year_sale($start, $end);
                $data = array(
                    'business_id' => $this->session->userdata('businessid'),
                    'month' => date('M', strtotime($start)),
                    'year' => date('Y', strtotime($start)),
                    'total_sale' => empty($previous->total_sale) ? 0 : $previous->total_sale
                );
                $id = $result->id_retail_sales;
                $previousdone = $this->retaildashboard_model->update_this_month_year_sale($data, $id);


                //add new for this month
                $start = date('Y-m-d', strtotime('first day of this month'));
                $end = date('Y-m-d', strtotime('last day of this month'));
                $result = $this->retaildashboard_model->get_this_month_year_sale($start, $end);
                $data = array(
                    'business_id' => $this->session->userdata('businessid'),
                    'month' => date('M', strtotime($start)),
                    'year' => date('Y', strtotime($start)),
                    'total_sale' => empty($result->total_sale) ? 0 : $result->total_sale
                );
                $result = $this->retaildashboard_model->add_this_month_year_sale($data);
            }

            // business_sale chart drawing
            $years = $this->retaildashboard_model->get_business_sale_years();

            $html = "";

            foreach ($years as $y) {

                $months = array(
                    $y->year => array(
                        'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0,
                        'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0,
                        'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0
                    )
                );

                $sales = $this->retaildashboard_model->get_business_sales($y->year);

                $html .= "{ name: '$y->year', ";
                $html .= "data: [";

                foreach ($sales as $sale) {
                    foreach ($months[$y->year] as $key => $value) {
                        if ($sale->month == $key) {
                            $months[$y->year][$key] = $sale->total_sale;
                        }
                    }
                }

                foreach ($months[$y->year] as $m) {
                    $html .= $m . ",";
                }

                $html .= "] ";

                $html .= "},";
            }

            $data['sales'] = rtrim($html, ',');
            $data['chart']='chart';
            $data['nodatatable']='nodatatable';
            $this->load->view('includes/header', $data);
            $this->load->view('retail_dashboard');
            $this->load->view('includes/footer');
        }
    }

    public function todayssale() {
        //get the posted values

        $data = $this->retaildashboard_model->get_todaysale();

        echo(json_encode($data));
    }

    public function yesterdaysale() {
        //get the posted values
        $month=$this->input->post('month');
        $year=$this->input->post('year');
        $data = $this->retaildashboard_model->get_yesterdaysale();

        echo(json_encode($data));
    }

    public function monthsale() {
        //get the posted values
        $month=$this->input->post('month');
        $year=$this->input->post('year');
        $data = $this->retaildashboard_model->get_month($month, $year);

        echo(json_encode($data));
    }

    public function yearsale() {
        //get the posted values
        $month=$this->input->post('month');
        $year=$this->input->post('year');
        $data = $this->retaildashboard_model->get_year($month, $year);

        echo(json_encode($data));
    }

    public function monthlysale() {
        //get the posted values
        $month=$this->input->post('month');
        $year=$this->input->post('year');
        $data = $this->retaildashboard_model->get_monthly($month, $year);

        echo(json_encode($data));
    }

    public function dailysale() {
        //get the posted values
        $month=$this->input->post('month');
        $year=$this->input->post('year');
        $data = $this->retaildashboard_model->get_daily($month, $year);

        echo(json_encode($data));
    }

    public function get_month_commission() {
        
        $month=$this->input->post('month');
        $year=$this->input->post('year');
        $data = $this->retaildashboard_model->get_month_commission($month, $year);

        echo(json_encode($data));
    }

    public function top_4_clients() {
        $month=$this->input->post('month');
        $year=$this->input->post('year');
        $data = $this->retaildashboard_model->top_4_clients($month, $year);

        echo(json_encode($data));
    }

    public function top_4_staff() {
        $month=$this->input->post('month');
        $year=$this->input->post('year');
        $data = $this->retaildashboard_model->top_4_staff($month, $year);
        echo(json_encode($data));
    }



    public function grossing_services() {
        $month=$this->input->post('month');
        $year=$this->input->post('year');
        
        $data = $this->retaildashboard_model->grossing_services($month, $year);

        echo json_encode($data);
    }

    public function get_months_breakup(){
        
        $month=$this->input->post('month');
        $year=$this->input->post('year');
        
        
        $data['cash'] = $this->retaildashboard_model->get_month_cash($month, $year);
        $data['card'] = $this->retaildashboard_model->get_month_card($month, $year);
        $data['bank'] = $this->retaildashboard_model->get_month_bank($month, $year);
        $data['voucher'] = $this->retaildashboard_model->get_month_voucher($month, $year);
        
        echo(json_encode($data));
        
    }
    
    public function get_today_breakup(){
        
      
        $data['cash'] = $this->retaildashboard_model->get_today_cash();
        $data['card'] = $this->retaildashboard_model->get_today_card();
        $data['bank'] = $this->retaildashboard_model->get_today_bank();
        $data['voucher'] = $this->retaildashboard_model->get_today_voucher();
        
        echo(json_encode($data));
        
    }
    
    
}
