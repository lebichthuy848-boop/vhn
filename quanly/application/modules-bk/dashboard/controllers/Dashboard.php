<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Dashboard extends Layout {

    function __construct() {
        parent::__construct();
        $this->_data['breadcrumbs_module_name'] = 'Bảng điều khiển';
				//$this->_data['breadcrumbs_admin'] = $this->_breadcrumbs_admin;
    }

    function index() {
        $args_services_maintenance = modules::run('services/services_maintenance/default_args');
        $count_services_maintenance = modules::run('services/services_maintenance/counts', $args_services_maintenance);
        $this->_data['count_services_maintenance'] = $count_services_maintenance;

        $args_services_borrow = modules::run('services/services_borrow/default_args');
        $count_services_borrow = modules::run('services/services_borrow/counts', $args_services_borrow);
        $this->_data['count_services_borrow'] = $count_services_borrow;

        $args_consignment = modules::run('consignment/default_args');
        $count_consignment = modules::run('consignment/counts', $args_consignment);
        $this->_data['count_consignment'] = $count_consignment;

        $args_customers = modules::run('customers/default_args');
        $count_customers = modules::run('customers/counts', $args_customers);
        $this->_data['count_customers'] = $count_customers;

				$this->_breadcrumbs_admin[] = array(
					'url' => '',
					'name' => 'Bảng điều khiển',
					'image' => base_url('assets/Frest/app-assets/images/logo/logo.png'),
				);
				$this->set_breadcrumbs_admin();

        $this->_data['title'] = 'Bảng điều khiển - ' . $this->_data['title'];
        $this->_data['main_content'] = 'dashboard/view_page_index';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

}
