<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';

$route['404_override'] = 'welcome/not_found';

$route['translate_uri_dashes'] = FALSE;
$route['login'] = 'welcome';
$route['business_switch'] = 'welcome/business_switch';

$route['users_list'] = 'user_controller/users_list';
$route['sh_users_list'] = 'sh_controller/sh_users_list';

$route['user_profile'] = 'user_controller/user_profile';
$route['userimage'] = 'user_controller/user_image';
$route['logout'] = 'user_controller/logout';
$route['dashboard'] = 'welcome/dashboard';
$route['sh_dashboard'] = 'sh_controller/sh_dashboard';
$route['servicesdashboard'] = 'servicesdashboard_controller/servicesdashboard';
$route['retaildashboard'] = 'retaildashboard_controller/retaildashboard';
$route['todaydashboard'] = 'today_dashboard_controller/index';
$route['sh_todaydashboard'] = 'sh_controller/todaydashboard';

$route['programsdashboard'] = 'program_dashboard_controller/index';
$route['gymdashboard'] = 'gym_dashboard_controller/index';
$route['trainingdashboard'] = 'training_dashboard_controller/index';

$route['daily_summary'] = 'dailysummary_controller/index';

$route['pos_view'] = 'pos_controller/index';
$route['sh_pos_view'] = 'sh_controller/sh_pos_view';
$route['pos_services_view'] = 'pos_controller/pos_services';
$route['sh_pos_services_view'] = 'sh_controller/sh_pos_services';

$route['pos_services_ss'] = 'pos_controller/pos_services_ss';
$route['pos_cancel_visit'] = 'pos_controller/cancelvisit';

$route['reception'] = 'welcome/reception';
$route['scheduler'] = 'welcome/scheduler';
$route['sh_scheduler'] = 'sh_controller/sh_scheduler';
$route['scheduler/(:any)'] = 'welcome/scheduler/$1';
$route['scheduler_view_only'] = 'welcome/scheduler_view_only';


$route['open_new_invoice'] = 'invoice_controller/open_new_invoice';
$route['new_return_invoice'] = 'returninvoice_controller/new_return_invoice';

$route['period_booking'] = 'welcome/period_booking';
$route['sh_period_booking'] = 'sh_controller/period_booking';

$route['print_booking/(:num)'] = 'invoice_controller/print_booking/$1';
$route['attendance'] = 'staff_controller/day_attendance';


$route['open_order_invoice'] = 'invoice_controller/open_order_invoice';
$route['todayinvoices'] = 'invoice_controller/todayinvoices';
$route['sh_todayinvoices'] = 'sh_controller/sh_todayinvoices';

$route['todayvouchers'] = 'voucher_controller/todayvouchers';


//$route['appointments/(:any)'] = 'invoice_controller/appointments/$1';
$route['appointments'] = 'appointment_controller/appointments';
$route['sh_appointments'] = 'sh_controller/appointments';

$route['bookings'] = 'appointment_controller/bookings';
$route['sh_bookings'] = 'sh_controller/bookings';

$route['staffperformance'] = 'appointment_controller/staffperformance';

$route['package_invoices'] = 'invoice_controller/package_invoices_list';
$route['open_package_invoice'] = 'invoice_controller/open_package_invoice';

$route['recoveryinvoices'] = 'invoice_controller/recoveryinvoices';
$route['sh_recoveryinvoices'] = 'sh_controller/sh_recoveryinvoices';

$route['existinginvoice/(:num)'] = 'invoice_controller/openinvoice/$1';
$route['viewvoucher/(:num)'] = 'scheduler_controller/openvoucher/$1';
$route['abandonedcarts'] = 'Order_controller/abandonedcarts';
$route['daily_expenses'] = 'expense_controller/daily_expense_list';
$route['sh_daily_expenses'] = 'sh_controller/daily_expense_list';

$route['open_recovery_invoice/(:num)/(:num)'] = 'invoice_controller/open_recovery_invoice/$1/$2';
$route['open_recovery_order_invoice/(:num)/(:num)'] = 'invoice_controller/open_recovery_order_invoice/$1/$2';

$route['cashregister/(:any)'] = 'invoice_controller/open_cash_register/$1';

$route['existingorderinvoice/(:num)'] = 'invoice_controller/openorderinvoice/$1';
///Settings///

$route['service_categories/(:num)']= 'service_controller/set_service_categories/$1';

$route['services/(:num)']= 'service_controller/set_services/$1';

$route['service_list']= 'service_controller/set_service_list';
$route['business_brands']= 'product_controller/set_business_brands';

$route['products']= 'product_controller/set_products';


$route['batches/(:num)']= 'product_controller/batches/$1';

$route['product_list/(:any)/(:any)']= 'product_controller/set_product_list/$1/$2';
$route['all_products']= 'product_controller/all_product_list';
$route['sh_all_products']= 'sh_controller/sh_all_product_list';

$route['supplier_list'] = 'supplier_controller/supplier_list';

$route['supplier'] = 'supplier_controller/supplier';
$route['customer_list'] = 'customer_controller/customer_list';
$route['staff_list'] = 'staff_controller/staff_list';

$route['staff_account/(:num)'] = 'staff_controller/staff_account/$1';

//Reports

$route['reports'] = 'report_controller/reports';
$route['sh_reports'] = 'sh_controller/sh_reports';

$route['discount_config'] = 'discount_controller/discount_config';
$route['business_timing'] = 'welcome/business_timing';
$route['staffimage'] = 'staff_controller/image_staff';
//$route['appointments'] = 'appointment_controller/get_appointments';
$route['categoryimage'] = 'service_controller/category_image';
$route['color_types'] = 'colors_controller/color_type_list';
$route['color_number'] = 'colors_controller/color_number';

$route['business'] = 'business_controller/business_view';
$route['business/logo/update'] = 'business_controller/business_logo_update';

$route['business/tax'] = 'business_controller/business_tax_view';

$route['staff_status'] = 'staff_controller/staff_status';

$route['voucher_list'] = 'voucher_controller/voucher_list';
$route['delete_voucher'] = 'voucher_controller/delete_voucher';

$route['customer_history/(:num)'] = 'customer_controller/customer_history/$1';
$route['sales'] = 'sales_controller/salesreport';

$route['customer_previous_visit/(:num)'] = 'customer_controller/customer_previous_visit/$1';
$route['sh_customer_previous_visit/(:num)'] = 'sh_controller/customer_previous_visit/$1';

$route['staff_sale'] = 'sales_controller/staff_sale';
$route['retail_charts'] = 'sales_controller/retail_charts';
$route['service_charts'] = 'sales_controller/service_charts';

$route['color_records'] = 'colors_controller/color_record_list';

$route['servicetypes'] = 'service_controller/set_service_type';
$route['servicetypeimage'] = 'service_controller/service_type_image';

$route['facial_records'] = 'service_controller/facial_record_list';

$route['eyelashes_records'] = 'eyelashes_controller/eyelashes_record_list';

$route['purchase_orders'] = 'purchaseorder_controller/purchase_order_list';
$route['purchase_order_details/(:num)'] = 'purchaseorder_controller/purchase_order_detail_get/$1';
$route['grn_list/(:num)'] = 'purchaseorder_controller/grn_list_view/$1';


$route['good_recieved_note/(:num)'] = 'purchaseorder_controller/grn_view/$1';
$route['good_recieved_print/(:num)'] = 'purchaseorder_controller/grn_print/$1';
$route['good_return_note/(:num)']= 'purchaseorder_controller/return_view/$1';

$route['transfer'] = 'transfernotes_controller/transfer_note_list';

$route['time_block_reason'] = 'welcome/time_block_reason';

$route['loyalty_services'] = 'loyaltyservices_controller/loyaltyservices_view';

$route['unit_list'] = 'unit_controller/unit_list';

$route['package/types'] = 'packages_controller/list_package_types';
$route['package/type/image'] = 'packages_controller/package_type_image';
$route['package/category/(:num)'] = 'packages_controller/list_package_category/$1';
$route['package/category/image'] = 'packages_controller/package_category_image';

$route['package/service/(:num)'] = 'packages_controller/list_package_service/$1';

$route['dispatch']= 'dispatch_controller/dispatch_list_view';

$route['service/chart']= 'sales_controller/service_chart_view';

$route['service_loyalty']= 'loyalty_controller/service_loyatly';

$route['smssender']= 'sms_controller/smssender';
$route['smslog']= 'sms_controller/smslog';



//$route['mobile']= 'Mobileapp_controller/login';

$route['pricelist']= 'service_controller/pricelist';
$route['sh_pricelist']= 'sh_controller/sh_pricelist';
$route['openvisits']= 'visits_controller/open_visits';
$route['open_sms_sender']= 'sms_controller/open_sms_sender';

$route['scheduled_tasks']= 'scheduled_tasks_controller/scheduled_tasks';

$route['test_tasks']= 'tools/get_scheduled_tasks';

/*---------Accounting----------*/

$route['coa']= 'accounting_controller/coa';
$route['account_vouchers']= 'accounting_controller/account_vouchers';
$route['payments']= 'accounting_controller/payments';
$route['supplier_payment/(:num)']= 'accounting_controller/supplier_payment/$1';
$route['statement']= 'accounting_controller/statement';
$route['general_ledger']= 'accounting_controller/general_ledger';
$route['trial_balance']= 'accounting_controller/trial_balacne';
$route['balacne_sheet']= 'accounting_controller/balacne_sheet';
$route['profit_loss']= 'accounting_controller/profit_loss';

$route['insert_po_payment']= 'accounting_controller/insert_po_payment';

$route['cashregister_listing']= 'accounting_controller/cashregister_listing';

$route['mobile']= 'Mobileapp_controller/login';

/*--------Super User --------------*/

$route['super_invoices']= 'superuser_controller/supervise_invoices';
$route['super_edit_invoice']= 'superuser_controller/open_edit_invoice';

$route['super_visits']= 'superuser_controller/supervise_visits';
$route['super_edit_visit']= 'superuser_controller/open_edit_visit';


/*----------Fixes --------------------*/
$route['fixes']= 'fixes_controller/index';
$route['fixes/staffservices']= 'fixes_controller/fix_staff_services';
$route['fixes/businessyearsales']= 'fixes_controller/fix_business_year_sales';



/*------------Gym------------------*/
$route['gymsearch']= 'gym_controller/gymsearch';
$route['gymregister/(:num)']= 'gym_controller/gymregister/$1';

/*------------Trainings------------------*/
$route['trainingsearch']= 'training_controller/trainingsearch';
$route['trainingregister/(:num)']= 'training_controller/trainingregister/$1';

/*------------Recurring Payments------------------*/
$route['recurringsearch']= 'recurring_controller/recurringsearch';
$route['recurringregister/(:num)']= 'recurring_controller/recurringregister/$1';



/*------------Programs------------*/
$route['programs/(:num)']= 'programs_controller/programs/$1';
$route['programadd/(:num)']='programs_controller/programadd/$1';
$route['programedit/(:num)']='programs_controller/programedit/$1';

$route['programsession/(:num)']= 'programs_controller/programsession/$1';
$route['programsessionadd/(:num)']= 'programs_controller/programsessionadd/$1';
$route['programsessionedit/(:num)']= 'programs_controller/programsessionedit/$1';

$route['programsessionclasses/(:num)']= 'programs_controller/programsessionclasses/$1';
$route['programsessionclassadd/(:num)']= 'programs_controller/programsessionclassadd/$1';
$route['programsessionclassedit/(:num)']= 'programs_controller/programsessionclassedit/$1';

$route['print_enrollment/(:num)']= 'programs_controller/print_enrollment/$1';
$route['print_program_invoice/(:num)']= 'programs_controller/print_invoice/$1';
$route['print_due_invoice/(:num)']= 'programs_controller/print_due_invoice/$1';

$route['program_add_payment/(:num)']= 'programs_controller/add_payment/$1';
$route['program_members/(:any)']= 'programs_controller/program_members/$1';
$route['program_members']= 'programs_controller/program_members';

/*------------Marketing Report------------*/
$route['marketing'] = 'marketing_controller/index';
$route['marketing-summary'] = 'marketing_controller/marketing_summary';

$route['petty-cash-report'] = 'marketing_controller/pettycashresport';
$route['retail-transaction'] = 'marketing_controller/retailTransaction';
$route['retail-transaction-by-item'] = 'marketing_controller/retailTransactionByItem';
$route['service-by-item'] = 'marketing_controller/serviceByItem';
$route['service-by-staff'] = 'marketing_controller/serviceByStaff';

$route['clinical-form/(:num)'] = 'clinical_controller/clinic_form/$1';

/*------------New Reports by dupilex------------*/
$route['daily-sheet-by-category'] = 'marketing_controller/daily_sheet_by_category';
$route['daily-sheet-summary'] = 'marketing_controller/daily_sheet_summary';


/*-----------Head Office -----------------------*/
$route['ho_view'] = 'ho_controller/index';
$route['ho_booking_list'] = 'ho_controller/period_booking_list';
$route['ho_booking_report'] = 'ho_controller/period_booking_report';

$route['ho_booking'] = 'ho_controller/period_booking';
$route['ho_print_booking/(:num)'] = 'ho_controller/print_booking/$1';
$route['ho_package_types'] = 'ho_controller/list_package_types';
$route['ho_package_types/image'] = 'ho_controller/package_type_image';

$route['ho_list_package_category/(:num)'] = 'ho_controller/list_package_category/$1';
$route['ho_list_package_category/image'] = 'ho_controller/package_category_image';

$route['ho_list_package_services/(:num)'] = 'ho_controller/ho_list_package_services/$1';
$route['ho_list_package_services/image'] = 'ho_controller/ho_package_service_image';


/*-------------Feed Back-----------------------*/
$route['feedback/(:any)/(:any)/(:any)']='feedback_controller/index/$1/$2/$3';
$route['feedback_form/(:num)']='feedback_controller/feedback_form/$1';