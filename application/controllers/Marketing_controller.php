<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Marketing_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('marketing_model');
        //$this->load->model('today_dashboard_model');
        $this->load->model('invoice_model');
        $this->load->model('voucher_model');
        $this->load->model('expense_model');
        $this->load->model('business_model');
        $this->load->model('report_model');
        if ($this->session->userdata('role') == '') {
            redirect('logout');
        }
    }

    public function index() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(0, 0, 1);

            $data['nav'] = 'reports';
            $data['subnav'] = 'marketing_report';
            $date = $this->input->post('calendar_date', TRUE);

            if (!isset($date) || empty($date)) {
                $date = date('Y-m');
            }

            //get the posted values
            $data['date'] = $date;
            $data['business'] = $this->business_model->getbusinessdetails();
            //$data['invoices'] = $this->invoice_model->getdayinvoices($date);
            //$data['vouchers'] = $this->voucher_model->getdayvouchers($date);
            //$data['expenses'] = $this->expense_model->get_daily_expense_list($date, $date);
            //$data['cashInfo'] = $this->invoice_model->get_today_cash_info($date);
            //$data['cashregister'] = $this->invoice_model->get_cash_register($date);
            //$data['yesterdaytill'] = $this->invoice_model->get_yesterday_till_amount($date);
            //$data['vouchersale'] = $this->invoice_model->get_cash_voucher($date);
            //$data['vouchers'] = $this->invoice_model->get_voucher_breakup($date);
            $data['advances'] = $this->marketing_model->get_advance_breakup($date);

            $data['invoiceservices'] = $this->marketing_model->getservicedayinvoices($date);

            $data['invoiceproducts'] = $this->marketing_model->getproductdayinvoices($date);

            $data['invoices'] = array_merge($data['invoiceservices'], $data['invoiceproducts']);

            //echo "<pre>";print_r($data['advances']);exit;

            $this->load->view('includes/header', $data);
            $this->load->view('marketing/monthly_staff_detail');
            $this->load->view('includes/footer');
            //$data = $this->appointment_model->get_appointments();
            //echo(json_encode($data));
        }
    }

    public function marketing_summary() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(0, 0, 1);

            $data['nav'] = 'reports';
            $data['subnav'] = 'marketing_summary';
            $date = $this->input->post('calendar_date', TRUE);

            if (!isset($date) || empty($date)) {
                $date = date('Y-m');
            }

            //get the posted values
            $data['date'] = $date;
            $data['business'] = $this->business_model->getbusinessdetails();
            $data['invoices'] = $this->marketing_model->getmarketingsummary($date);

    //        echo "<pre>";
    //        print_r($data['invoices']);
    //        exit;

            $this->load->view('includes/header', $data);
            $this->load->view('marketing/monthly_staff_summary');
            $this->load->view('includes/footer');
        }
    }

    public function pettycashresport() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(0, 0, 1);

            $data['nav'] = 'reports';
            $data['subnav'] = 'petty_cash_report';
            $fromdate = $this->input->post('fromdate', TRUE);
            $todate = $this->input->post('todate', TRUE);

            if ((!isset($fromdate) || empty($fromdate)) && (!isset($todate) || empty($todate))) {
                $fromdate = date('Y-m-d');
                $todate = date('Y-m-d');
                $todate = new DateTime($todate);
                $todate->modify('+1 day');
                $todate = $todate->format('Y-m-d');
            }

            //get the posted values
            $data['fromdate'] = $fromdate;
            $data['todate'] = $todate;
            $data['business'] = $this->business_model->getbusinessdetails();
            $data['pettycash'] = $this->marketing_model->pettycashreport($fromdate, $todate);
            //echo "<pre>";print_r($data['pettycash']);exit;
            $this->load->view('includes/header', $data);
            $this->load->view('marketing/petty_cash_report');
            $this->load->view('includes/footer');
        }
    }

    public function retailTransaction() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(0, 0, 1);

            $data['nav'] = 'reports';
            $data['subnav'] = 'retail_Transaction';
            $fromdate = $this->input->post('fromdate', TRUE);
            $todate = $this->input->post('todate', TRUE);

            if ((!isset($fromdate) || empty($fromdate)) && (!isset($todate) || empty($todate))) {
                $fromdate = date('Y-m-d');
                $todate = date('Y-m-d');
                $todate = new DateTime($todate);
                $todate->modify('+1 day');
                $todate = $todate->format('Y-m-d');
            }

            //get the posted values
            $data['fromdate'] = $fromdate;
            $data['todate'] = $todate;
            $data['business'] = $this->business_model->getbusinessdetails();
            $data['retailTransaction'] = $this->marketing_model->retailTransaction($fromdate, $todate);
            //$data['brands'] = $this->marketing_model->getBrands($fromdate, $todate);
            //echo "<pre>";print_r($data['retailTransaction']);exit;
            $this->load->view('includes/header', $data);
            $this->load->view('marketing/retail_transaction');
            $this->load->view('includes/footer');
        }
    }

    //each item/product count sum like summary
    public function retailTransactionByItem() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(0, 0, 1);

            $data['nav'] = 'reports';
            $data['subnav'] = 'retail_Transaction_By_Item';
            $fromdate = $this->input->post('fromdate', TRUE);
            $todate = $this->input->post('todate', TRUE);

            if ((!isset($fromdate) || empty($fromdate)) && (!isset($todate) || empty($todate))) {
                $fromdate = date('Y-m-d');
                $todate = date('Y-m-d');
                $todate = new DateTime($todate);
                $todate->modify('+1 day');
                $todate = $todate->format('Y-m-d');
            }

            //get the posted values
            $data['fromdate'] = $fromdate;
            $data['todate'] = $todate;
            $data['business'] = $this->business_model->getbusinessdetails();
            $data['retailTransaction'] = $this->marketing_model->retailTransactionByItem($fromdate, $todate);
            //echo "<pre>";print_r($data['retailTransaction']);exit;
            $this->load->view('includes/header', $data);
            $this->load->view('marketing/retail_transaction_by_item');
            $this->load->view('includes/footer');
        }
    }

    public function serviceByItem() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(0, 0, 1);

            $data['nav'] = 'reports';
            $data['subnav'] = 'service_By_Item';
            $fromdate = $this->input->post('fromdate', TRUE);
            $todate = $this->input->post('todate', TRUE);

            if ((!isset($fromdate) || empty($fromdate)) && (!isset($todate) || empty($todate))) {
                $fromdate = date('Y-m-d');
                $todate = date('Y-m-d');
                $todate = new DateTime($todate);
                $todate->modify('+1 day');
                $todate = $todate->format('Y-m-d');
            }

            //get the posted values
            $data['fromdate'] = $fromdate;
            $data['todate'] = $todate;
            $data['business'] = $this->business_model->getbusinessdetails();
            $data['serviceByItem'] = $this->marketing_model->service_sale_details($fromdate, $todate);
            //echo "<pre>";print_r($data['serviceByItem']);exit;
            $this->load->view('includes/header', $data);
            $this->load->view('marketing/service_by_item');
            $this->load->view('includes/footer');
        }
    }

    public function serviceByStaff() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(0, 0, 1);

            $data['nav'] = 'reports';
            $data['subnav'] = 'service_By_Staff';
            $fromdate = $this->input->post('fromdate', TRUE);
            $todate = $this->input->post('todate', TRUE);

            if ((!isset($fromdate) || empty($fromdate)) && (!isset($todate) || empty($todate))) {
                $fromdate = date('Y-m-d');
                $todate = date('Y-m-d');
                $todate = new DateTime($todate);
                $todate->modify('+1 day');
                $todate = $todate->format('Y-m-d');
            }

            //get the posted values
            $data['fromdate'] = $fromdate;
            $data['todate'] = $todate;
            $data['business'] = $this->business_model->getbusinessdetails();
            $data['serviceByStaff'] = $this->marketing_model->service_by_staff($fromdate, $todate);
            //echo "<pre>";print_r($data['serviceByStaff']);exit;
            $this->load->view('includes/header', $data);
            $this->load->view('marketing/service_by_staff');
            $this->load->view('includes/footer');
        }
    }
    
    public function daily_sheet_by_category() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(0, 0, 1);

            $data['nav'] = 'invoice';
            $data['subnav'] = 'daily_sheet_by_category';
            $fromdate = $this->input->post('fromdate', TRUE);

            if (!isset($fromdate) || empty($fromdate)) {
                $fromdate = date('Y-m-d');
            }

            //get the posted values
            $data['fromdate'] = $fromdate;
            $data['business'] = $this->business_model->getbusinessdetails();
            $data['dailysheet'] = $this->marketing_model->daily_sheet_by_category($fromdate, $fromdate);
            ////echo count($data['dailysheet']);exit;
            //echo "<pre>";print_r($data['dailysheet']);exit;
            $this->load->view('includes/header', $data);
            $this->load->view('marketing/daily_sheet_by_category');
            $this->load->view('includes/footer');
        }
    }
    
    public function daily_sheet_summary() {
        if($this->session->userdata('role')=='' || $this->session->userdata('role')=='Sh-Users'){
            $this->load->view('login_view');
        } else {
            checkroles(0, 0, 1);

            $data['nav'] = 'invoice';
            $data['subnav'] = 'daily_sheet_summary';
            $date = $this->input->post('fromdate', TRUE);

            if (!isset($date) || empty($date)) {
                $date = date('Y-m-d');
            }

            //get the posted values
            $data['fromdate'] = $date;
            $data['business'] = $this->business_model->getbusinessdetails();
            //$data['dailysheet'] = $this->marketing_model->getdayinvoices($date);
            $data['serviceCash'] = $this->marketing_model->getServiceCashDetails($date);
            echo "<pre>";print_r($data['serviceCash']);exit;
            //$data['vouchers'] = $this->voucher_model->getdayvouchers($date);
            $data['expenses'] = $this->expense_model->get_daily_expense_list($date, $date);

            $data['cashInfo'] = $this->marketing_model->get_today_cash_info($date);
            //secho "<pre>";print_r($data['cashInfo']);exit;
    //        $data['cashregister'] = $this->invoice_model->get_cash_register($date);
    //        $data['yesterdaytill'] = $this->invoice_model->get_yesterday_till_amount($date);
    //        $data['vouchersale'] = $this->invoice_model->get_cash_voucher($date);
            //$data['vouchers'] = $this->invoice_model->get_voucher_breakup($date);
            //echo "<pre>";print_r($data['vouchers']);exit;
    //        $data['advances'] = $this->invoice_model->get_advance_breakup($date);
            ////echo count($data['dailysheet']);exit;
            //echo "<pre>";print_r($data['dailysheet']);exit;
            $this->load->view('includes/header', $data);
            $this->load->view('marketing/daily_sheet_summary');
            $this->load->view('includes/footer');
        }
    }

    //This function is not using but this function will work for CSV
    public function exportCsv($fromdate, $todate, $flag = false) {
        $serviceByStaff = $this->marketing_model->service_by_staff($fromdate, $todate);
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"test" . ".csv\"");
        header("Pragma: no-cache");
        header("Content-Transfer-Encoding: UTF-8");
        header("Expires: 0");

        $handle = fopen('php://output', 'w');
        $output = "";
        if (isset($serviceByStaff) && !empty($serviceByStaff)) {
            $grand_total_sold = 0;
            $grand_total_revenue = 0;
            fputcsv($handle, ['Services', 'Category', 'Sold', 'Price']);
            foreach ($serviceByStaff as $row) {
                fputcsv($handle, [mb_strtoupper($row['staff_name'])]);
                if (isset($row['data']) && !empty($row['data'])) {
                    $total_sold = 0;
                    $total_revenue = 0;
                    foreach ($row['data'] as $data) {
                        $total_sold += $data['sold'];
                        $grand_total_sold += $total_sold;
                        $total_revenue += $data['price'];
                        $grand_total_revenue += $total_revenue;
                        fputcsv($handle, [$data['service_name'], $data['service_category'], number_format($data['sold'], 2), number_format($data['price'], 2)]);
                    }
                    fputcsv($handle, ['', 'Total: ', number_format($total_sold, 2), number_format($total_revenue, 2)]);
                } else {

                    fputcsv($handle, ['Services not found for ' . mb_strtoupper($row['staff_name'])]);
                }
            }
            fputcsv($handle, ['', 'Grand Total: ', $grand_total_sold, $grand_total_revenue]);
        }

        fclose($handle);
    }

    //This function is using for excell export
    public function ExportExcell($fromdate, $todate, $flag = Null) {

        if ($flag == "ServiceByStaff") {
            $fileName = 'ServiceByStaffFrom' . date('dmy', strtotime($fromdate)) . 'TO' . date('dmy', strtotime($todate)) . '.xlsx';
            //$fileName = 'data.xlsx';
            // load excel library
            $serviceByStaff = $this->marketing_model->service_by_staff($fromdate, $todate);
            $this->load->library('excel');
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            foreach (range('A', 'D') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                        ->setAutoSize(true);
            }

            // set Header
            $objPHPExcel->getActiveSheet()->SetCellValue("A1", "SERVICES BY STAFF")->mergeCells("A1:D1");
            $objPHPExcel->getActiveSheet()->SetCellValue("A2", "FROM: " . date('D d-M-Y', strtotime($fromdate)) . " TO: " . date('D d-M-Y', strtotime($todate)))->mergeCells("A2:D2");
            $objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Services');
            $objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Category');
            $objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Sold');
            $objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Revenue');
            $from = "A1"; // or any value
            $to = "D3"; // or any value
            $objPHPExcel->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);
            // set Row
            $rowCount = 4;
            $Grand_total_price = 0;
            $Grand_total_sold = 0;
            foreach ($serviceByStaff as $row) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row['staff_name'])->getStyle('A' . $rowCount)->getFont()->setBold(true);
                $rowCount++;
                $total_price = 0;
                $total_sold = 0;
                if (isset($row['data']) && !empty($row['data'])) {
                    foreach ($row['data'] as $data) {
                        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $data['service_name']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $data['service_category']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, number_format($data['sold'], 2));
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, number_format($data['price'], 2));
                        $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $rowCount++;
                        $total_sold += $data['sold'];
                        $total_price += $data['price'];
                    }
                } else {
                    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'Services not found for: ' . $row['staff_name']);
                    $rowCount++;
                }
                $Grand_total_price += $total_sold;
                $Grand_total_sold += $total_price;
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Total: ')->getStyle('B' . $rowCount)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, number_format($total_sold, 2))->getStyle('C' . $rowCount)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, number_format($total_price, 2))->getStyle('D' . $rowCount)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $rowCount++;
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Grand Total: ')->getStyle('B' . $rowCount)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, number_format($Grand_total_price, 2))->getStyle('C' . $rowCount)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, number_format($Grand_total_sold, 2))->getStyle('D' . $rowCount)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            //$objWriter->save(ROOT_UPLOAD_IMPORT_PATH . $fileName);
            $objWriter->save($fileName);
            // download file
            header("Content-Type: application/vnd.ms-excel");
            redirect(base_url() . $fileName);
        } else if ($flag == "RetailTransactionByItem") {
            //$data['retailTransaction'] = $this->marketing_model->retailTransactionByItem($fromdate, $todate);
            $fileName = 'RetailTransactionByItemFrom' . date('dmy', strtotime($fromdate)) . 'TO' . date('dmy', strtotime($todate)) . '.xlsx';
            //$fileName = 'data.xlsx';
            // load excel library
            $result = $this->marketing_model->retailTransactionByItem($fromdate, $todate);
            $this->load->library('excel');
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            foreach (range('A', 'F') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                        ->setAutoSize(true);
            }

            // set Header
            $objPHPExcel->getActiveSheet()->SetCellValue("A1", "RETAIL TRANSACTION BY ITEM")->mergeCells("A1:F1");
            $objPHPExcel->getActiveSheet()->SetCellValue("A2", "FROM: " . date('D d-M-Y', strtotime($fromdate)) . " TO: " . date('D d-M-Y', strtotime($todate)))->mergeCells("A2:F2");
            $objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Barcode');
            $objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Description');
            $objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Size');
            $objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Sold');
            $objPHPExcel->getActiveSheet()->SetCellValue('E3', 'Total');
            $objPHPExcel->getActiveSheet()->SetCellValue('F3', 'Profit');
            $from = "A1"; // or any value
            $to = "F3"; // or any value
            $objPHPExcel->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);
            // set Row
            $rowCount = 4;
            $grand_total_amount = 0;
            $grand_total_profit = 0;
            foreach ($result as $row) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row['brand_name'])->getStyle('A' . $rowCount)->getFont()->setBold(true);
                $rowCount++;
                if (isset($row['data']) && !empty($row['data'])) {
                    foreach ($row['data'] as $data) {
                        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $data['barcode_products']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $data['product_name']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $data['qty_per_unit'] . '' . $data['measure_unit']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, number_format($data['sold'], 2));
                        $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, number_format($data['price'], 2));
                        $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, number_format($data['price'] - $data['purchase_price'], 2));
                        $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $rowCount++;
                        $grand_total_amount += $data['price'];
                        $grand_total_profit += $data['price'] - $data['purchase_price'];
                    }
                } else {
                    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'Services not found for: ' . $row['brand_name']);
                    $rowCount++;
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, 'Grand Total: ')->getStyle('D' . $rowCount)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, number_format($grand_total_amount, 2))->getStyle('E' . $rowCount)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, number_format($grand_total_profit, 2))->getStyle('F' . $rowCount)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            //$objWriter->save(ROOT_UPLOAD_IMPORT_PATH . $fileName);
            $objWriter->save($fileName);
            // download file
            header("Content-Type: application/vnd.ms-excel");
            redirect(base_url() . $fileName);
        } else if ($flag == "RetailTransaction") {
            $fileName = 'RetailTransactionFrom' . date('dmy', strtotime($fromdate)) . 'TO' . date('dmy', strtotime($todate)) . '.xlsx';
            //$fileName = 'data.xlsx';
            // load excel library
            $result = $this->marketing_model->retailTransaction($fromdate, $todate);
            $this->load->library('excel');
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            foreach (range('A', 'F') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                        ->setAutoSize(true);
            }

            // set Header
            $objPHPExcel->getActiveSheet()->SetCellValue("A1", "RETAIL TRANSACTION")->mergeCells("A1:F1");
            $objPHPExcel->getActiveSheet()->SetCellValue("A2", "FROM: " . date('D d-M-Y', strtotime($fromdate)) . " TO: " . date('D d-M-Y', strtotime($todate)))->mergeCells("A2:F2");
            $objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Date');
            $objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Description');
            $objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Size');
            $objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Discount');
            $objPHPExcel->getActiveSheet()->SetCellValue('E3', 'Amount');
            $objPHPExcel->getActiveSheet()->SetCellValue('F3', 'Profit');
            $from = "A1"; // or any value
            $to = "F3"; // or any value
            $objPHPExcel->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);
            // set Row
            $rowCount = 4;
            $grand_total_discount = 0;
            $grand_total_amount = 0;
            $grand_total_profit = 0;
            foreach ($result as $row) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row['brand_name'])->getStyle('A' . $rowCount)->getFont()->setBold(true);
                $rowCount++;
                if (isset($row['data']) && !empty($row['data'])) {
                    $total_discount = 0;
                    $total_amount = 0;
                    $total_profit = 0;
                    foreach ($row['data'] as $data) {
                        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $data['invoice_date']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $data['product_name']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $data['qty_per_unit'] . '' . $data['measure_unit']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, number_format($data['discount'], 2));
                        $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, number_format($data['price'], 2));
                        $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, number_format($data['price'] - $data['purchase_price'], 2));
                        $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $rowCount++;
                        $total_discount += $data['discount'];
                        $total_amount += $data['price'];
                        $total_profit += $data['price'] - $data['purchase_price'];
                    }
                    $grand_total_amount += $total_amount;
                    $grand_total_discount += $total_discount;
                    $grand_total_profit += $total_profit;
                    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Total: ')->getStyle('C' . $rowCount)->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, number_format($total_discount, 2))->getStyle('D' . $rowCount)->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, number_format($total_amount, 2))->getStyle('E' . $rowCount)->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, number_format($total_profit, 2))->getStyle('F' . $rowCount)->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $rowCount++;
                } else {
                    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'Product not found for: ' . $row['brand_name']);
                    $rowCount++;
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Grand Total: ')->getStyle('C' . $rowCount)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, number_format($grand_total_discount, 2))->getStyle('D' . $rowCount)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, number_format($grand_total_amount, 2))->getStyle('E' . $rowCount)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, number_format($grand_total_profit, 2))->getStyle('F' . $rowCount)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            //$objWriter->save(ROOT_UPLOAD_IMPORT_PATH . $fileName);
            $objWriter->save($fileName);
            // download file
            header("Content-Type: application/vnd.ms-excel");
            redirect(base_url() . $fileName);
        }
        //header("Content-Type: application/vnd.ms-excel");
        //redirect(HTTP_UPLOAD_IMPORT_PATH . $fileName);
    }

}
