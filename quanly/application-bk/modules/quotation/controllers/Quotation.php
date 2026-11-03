<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Quotation extends Layout {

    private $_module_slug = 'bao-gia';

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->_data['module_slug'] = $this->_module_slug;
        $this->_data['breadcrumbs_module_name'] = 'Báo giá';
        $this->load->model('quotation/m_quotation', 'M_quotation');
        $this->load->model('quotation/m_quotation_details', 'M_quotation_details');
    }
	
	private function _validate_access_role(){
		$this->validate_access_role('ROLE_GROUP_QUOTATION');
	}

    function default_args() {
        $order_by = array(
            'code' => 'ASC'
        );
        $args = array();
        $args['order_by'] = $order_by;

        return $args;
    }

    function counts($args) {
        return $this->M_quotation->counts($args);
    }

    function get($id) {
        $this->load->model('quotation/m_quotation', 'M_quotation');
        return $this->M_quotation->get($id);
    }

    function gets($options = array()) {
        $this->load->model('quotation/m_quotation', 'M_quotation');
        $default_args = $this->default_args();
        if (is_array($options) && !empty($options)) {
            $args = array_merge($default_args, $options);
        } else {
            $args = $default_args;
        }
        return $this->M_quotation->gets($args);
    }

    function get_details($id) {
        $this->load->model('quotation/m_quotation_details', 'M_quotation_details');
        return $this->M_quotation_details->get($id);
    }

    function admin_report_by_date() {
        $this->redirect_admin();
        $this->load->model('purchase_voucher/m_purchase_voucher_details', 'M_purchase_voucher_details');
        $this->load->library('form_validation');

        $this->_module_slug = 'bao-cao/theo-ngay';
        $this->_data['module_slug'] = $this->_module_slug;

        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker3'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/js',
            'name' => 'bootstrap-datepicker'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/locales',
            'name' => 'bootstrap-datepicker.vi.min'
        );

        $this->_plugins_script_admin[] = array(
            'folder' => 'jQuery-Plugin-To-Print-Any-Part-Of-Your-Page-Print',
            'name' => 'jQuery.print'
        );

        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'quotation',
            'name' => 'admin-report-by-date'
        );
        $this->set_modules();

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $args = $this->default_args();
        $args['deleted'] = 0;

        //theo ngay
        if (isset($get['fromday']) && trim($get['fromday']) != '') {
            $args['start_date_start'] = get_start_date($get['fromday']);
            $args['start_date_end'] = get_end_date($get['fromday']);
        }

        $total = $this->counts($args);
        $perpage = isset($get['per_page']) ? (int) $get['per_page'] : 10;
        $segment = 2;

        $this->load->library('pagination');
        $config['total_rows'] = $total;
        $config['per_page'] = $perpage;
        $config['full_tag_open'] = '<ul class="pagination no-margin pull-right">';
        $config['full_tag_close'] = '</ul><!--pagination-->';

        $config['first_link'] = '&laquo;';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '&raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Trang trước &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&larr; Trang sau';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        if (!empty($get)) {
            $config['base_url'] = base_url($this->_module_slug);
            $config['suffix'] = '?' . http_build_query($get, '', "&");
            $config['first_url'] = base_url($this->_module_slug . '?' . http_build_query($get, '', "&"));
            $config['uri_segment'] = $segment;
        } else {
            $config['base_url'] = base_url($this->_module_slug);
            $config['uri_segment'] = $segment;
        }

        $this->pagination->initialize($config);  # Khởi tạo phân trang

        $pagination = $this->pagination->create_links(); # Tạo link phân trang
        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment); # Lấy offset
        $this->_data['current_page'] = (int) $offset;

        $rows = $this->M_quotation->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;

        foreach ($rows as $key => $value) {
            $rows[$key]['items'] = $this->get_details($value['id']);
        }
//        echo "<pre>";
//        print_r($rows);
//        echo "</pre>";
//        die();
        $this->_data['rows'] = $rows;

        $this->_data['breadcrumbs_module_name'] = 'Báo cáo';
        $this->_data['breadcrumbs_module_func'] = 'Theo ngày';
        $this->_data['title'] = 'Báo cáo theo ngày';
        $this->_data['main_content'] = 'quotation/admin/view_page_report_by_date';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_report_by_product() {
        $this->redirect_admin();
        $this->load->model('quotation/m_quotation_details', 'M_quotation_details');
        $this->load->library('form_validation');

        $this->_module_slug = 'bao-cao/mat-hang';
        $this->_data['module_slug'] = $this->_module_slug;

        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker3'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/js',
            'name' => 'bootstrap-datepicker'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/locales',
            'name' => 'bootstrap-datepicker.vi.min'
        );

        $this->_plugins_css_admin[] = array(
            'folder' => 'chosen',
            'name' => 'chosen'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'chosen',
            'name' => 'chosen.jquery'
        );

        $this->_plugins_script_admin[] = array(
            'folder' => 'jQuery-Plugin-To-Print-Any-Part-Of-Your-Page-Print',
            'name' => 'jQuery.print'
        );

        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'quotation',
            'name' => 'admin-report-by-product'
        );
        $this->set_modules();

        $get = $this->input->get();
        $this->_data['get'] = $get;

        //$args = $this->default_args();
        //$args['deleted'] = 0;
        $args = array();

        //theo ngay
        if (isset($get['fromday']) && trim($get['fromday']) != '' && isset($get['today']) && trim($get['today']) != '') {
            $args['start_date_start'] = get_start_date($get['fromday']);
            $args['start_date_end'] = get_end_date($get['today']);
        }

        if (isset($get['category_id']) && (((int) $get['category_id']) != 0)) {
            $args['category_id'] = $get['category_id'];
        }

        if (isset($get['product_id']) && (((int) $get['product_id']) != 0)) {
            $args['product_id'] = array($get['product_id']);
        }

        $total = $this->M_quotation_details->counts($args);
        $perpage = isset($get['per_page']) ? (int) $get['per_page'] : 10;
        $segment = 3;

        $this->load->library('pagination');
        $config['total_rows'] = $total;
        $config['per_page'] = $perpage;
        $config['full_tag_open'] = '<ul class="pagination no-margin pull-right">';
        $config['full_tag_close'] = '</ul><!--pagination-->';

        $config['first_link'] = '&laquo;';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '&raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Trang trước &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&larr; Trang sau';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        if (!empty($get)) {
            $config['base_url'] = base_url($this->_module_slug);
            $config['suffix'] = '?' . http_build_query($get, '', "&");
            $config['first_url'] = base_url($this->_module_slug . '?' . http_build_query($get, '', "&"));
            $config['uri_segment'] = $segment;
        } else {
            $config['base_url'] = base_url($this->_module_slug);
            $config['uri_segment'] = $segment;
        }

        $this->pagination->initialize($config);  # Khởi tạo phân trang

        $pagination = $this->pagination->create_links(); # Tạo link phân trang
        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment); # Lấy offset
        $this->_data['current_page'] = (int) $offset;

        $rows = $this->M_quotation_details->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;

//        foreach ($rows as $key => $value) {
//            $rows[$key]['items'] = $this->get_details($value['id']);
//        }
//        echo "<pre>";
//        print_r($rows);
//        echo "</pre>";
//        die();
        $this->_data['rows'] = $rows;

        $this->_data['category'] = modules::run('category/gets');
        $args = modules::run('products/default_args');
        $args['deleted'] = 0;
        $this->_data['products'] = modules::run('products/gets', $args);

        $this->_data['breadcrumbs_module_name'] = 'Báo cáo';
        $this->_data['breadcrumbs_module_func'] = 'Theo mặt hàng';
        $this->_data['title'] = 'Báo cáo theo mặt hàng';
        $this->_data['main_content'] = 'quotation/admin/view_page_report_by_product';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_index() {
        $this->_validate_access_role();
		
        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker3'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/js',
            'name' => 'bootstrap-datepicker'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/locales',
            'name' => 'bootstrap-datepicker.vi.min'
        );

        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap3-dialog/css',
            'name' => 'bootstrap-dialog'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap3-dialog/js',
            'name' => 'bootstrap-dialog'
        );

        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'quotation',
            'name' => 'admin-borrow'
        );
        $this->set_modules();

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $args = $this->default_args();
        $args['deleted'] = 0;
		if(in_array($this->_data['role'], array('SALES', 'AGENCY', 'DISTRIBUTOR', 'WHOLESALER'))){
			$args['admin_id'] = $this->_data['userid'];
		}

        //theo ngay
        if (isset($get['fromday']) && trim($get['fromday']) != '') {
            $args['start_date_start'] = get_current_date($get['fromday']);
        }
        if (isset($get['today']) && trim($get['today']) != '') {
            $args['start_date_end'] = get_current_date($get['today']);
        }

        if (isset($get['code']) && trim($get['code']) != '') {
            $args['code'] = $get['code'];
        }

        if (isset($get['full_name']) && trim($get['full_name']) != '') {
            $args['full_name'] = $get['full_name'];
        }

        $total = $this->counts($args);
        $perpage = isset($get['per_page']) ? $get['per_page'] : $this->config->item('per_page');
        $segment = 2;

        $this->load->library('pagination');
        $config['total_rows'] = $total;
        $config['per_page'] = $perpage;
        $config['full_tag_open'] = '<ul class="pagination no-margin pull-right">';
        $config['full_tag_close'] = '</ul><!--pagination-->';

        $config['first_link'] = '&laquo;';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '&raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Trang trước &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&larr; Trang sau';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        if (!empty($get)) {
            $config['base_url'] = base_url($this->_module_slug);
            $config['suffix'] = '?' . http_build_query($get, '', "&");
            $config['first_url'] = base_url($this->_module_slug . '?' . http_build_query($get, '', "&"));
            $config['uri_segment'] = $segment;
        } else {
            $config['base_url'] = base_url($this->_module_slug);
            $config['uri_segment'] = $segment;
        }

        $this->pagination->initialize($config);

        $pagination = $this->pagination->create_links();
        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
        $this->_data['current_page'] = (int) $offset;

        $rows = $this->M_quotation->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;

        foreach ($rows as $key => $value) {
            $rows[$key]['items'] = $this->get_details($value['id']);
        }
        $this->_data['rows'] = $rows;

        $this->_data['title'] = 'Danh sách báo giá - ' . $this->_data['title'];
        $this->_data['main_content'] = 'quotation/admin/view_page_index';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_by_customer() {
        $this->redirect_admin();
        $id = (int) (($this->uri->segment(3) == '') ? 0 : $this->uri->segment(3));
        if ($id == 0) {
            show_404();
        }
        $customer = modules::run('customers/get', $id);
        if (!is_array($customer) || empty($customer)) {
            show_404();
        }
        $this->_data['breadcrumbs_module_name'] = 'Đơn hàng';
        $this->_data['breadcrumbs_module_func'] = $customer['full_name'];
        $this->_module_slug = 'khach-hang/don-hang/' . $id;
        $this->_data['module_slug'] = $this->_module_slug;

        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker3'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/js',
            'name' => 'bootstrap-datepicker'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/locales',
            'name' => 'bootstrap-datepicker.vi.min'
        );

        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap3-dialog/css',
            'name' => 'bootstrap-dialog'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap3-dialog/js',
            'name' => 'bootstrap-dialog'
        );

        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'quotation',
            'name' => 'admin-borrow'
        );
        $this->set_modules();

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $args = $this->default_args();
        $args['customer_id'] = $id;
        $args['deleted'] = 0;

        //theo ngay
        if (isset($get['fromday']) && trim($get['fromday']) != '') {
            $args['start_date_start'] = get_current_date($get['fromday']);
        }
        if (isset($get['today']) && trim($get['today']) != '') {
            $args['start_date_end'] = get_current_date($get['today']);
        }

        if (isset($get['code']) && trim($get['code']) != '') {
            $args['code'] = $get['code'];
        }

        $total = $this->counts($args);
        $perpage = 2; //isset($get['per_page']) ? $get['per_page'] : $this->config->item('per_page');
        $segment = 3;

        $this->load->library('pagination');
        $config['total_rows'] = $total;
        $config['per_page'] = $perpage;
        $config['full_tag_open'] = '<ul class="pagination no-margin pull-right">';
        $config['full_tag_close'] = '</ul><!--pagination-->';

        $config['first_link'] = '&laquo;';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '&raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Trang trước &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&larr; Trang sau';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        $segment++;
        if (!empty($get)) {
            $config['base_url'] = base_url($this->_module_slug);
            $config['suffix'] = '?' . http_build_query($get, '', "&");
            $config['first_url'] = base_url($this->_module_slug . '?' . http_build_query($get, '', "&"));
            $config['uri_segment'] = $segment;
        } else {
            $config['base_url'] = base_url($this->_module_slug);
            $config['uri_segment'] = $segment;
        }

        $this->pagination->initialize($config);

        $pagination = $this->pagination->create_links();
        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
        $this->_data['current_page'] = (int) $offset;

        $rows = $this->M_quotation->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;

        foreach ($rows as $key => $value) {
            $rows[$key]['items'] = $this->get_details($value['id']);
        }
        $this->_data['rows'] = $rows;

        $this->_data['title'] = 'Danh sách đơn hàng - ' . $this->_data['title'];
        $this->_data['main_content'] = 'quotation/admin/view_page_customer';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_trash() {
        $this->_validate_access_role();
		
        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker3'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/js',
            'name' => 'bootstrap-datepicker'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/locales',
            'name' => 'bootstrap-datepicker.vi.min'
        );

        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap3-dialog/css',
            'name' => 'bootstrap-dialog'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap3-dialog/js',
            'name' => 'bootstrap-dialog'
        );

        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'quotation',
            'name' => 'admin-borrow-trash'
        );
        $this->set_modules();

        $this->_data['breadcrumbs_module_name'] = 'Thùng rác';
        $this->_module_slug = 'thung-rac/bao-gia';
        $this->_data['module_slug'] = $this->_module_slug;

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $args = $this->default_args();
        $args['type'] = 'borrow';
        $args['deleted'] = 1;

        //theo ngay
        if (isset($get['fromday']) && trim($get['fromday']) != '') {
            $args['start_date_start'] = get_current_date($get['fromday']);
        }
        if (isset($get['today']) && trim($get['today']) != '') {
            $args['start_date_end'] = get_current_date($get['today']);
        }

        if (isset($get['q']) && trim($get['q']) != '') {
            $args['code'] = $get['q'];
        }
        if (isset($get['returned']) && trim($get['returned']) != -1) {
            $args['returned'] = $get['returned'];
        }

        $total = $this->counts($args);
        $perpage = isset($get['per_page']) ? $get['per_page'] : $this->config->item('per_page');
        $segment = 3;

        $this->load->library('pagination');
        $config['total_rows'] = $total;
        $config['per_page'] = $perpage;
        $config['full_tag_open'] = '<ul class="pagination no-margin pull-right">';
        $config['full_tag_close'] = '</ul><!--pagination-->';

        $config['first_link'] = '&laquo;';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '&raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Trang trước &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&larr; Trang sau';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        if (!empty($get)) {
            $config['base_url'] = base_url($this->_module_slug);
            $config['suffix'] = '?' . http_build_query($get, '', "&");
            $config['first_url'] = base_url($this->_module_slug . '?' . http_build_query($get, '', "&"));
            $config['uri_segment'] = $segment;
        } else {
            $config['base_url'] = base_url($this->_module_slug);
            $config['uri_segment'] = $segment;
        }

        $this->pagination->initialize($config);

        $pagination = $this->pagination->create_links();
        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);

        $this->_data['rows'] = $this->M_quotation->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;

        $this->_data['title'] = 'Thùng rác - Danh sách báo giá - ' . $this->_data['title'];
        $this->_data['main_content'] = 'quotation/admin/view_page_trash';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_content_ajax() {
		if (!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}
		
        $post = $this->input->post();
        if (!empty($post)) {
            $this->load->helper('language');
            $this->lang->load('form_validation', 'vietnamese');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('date', 'Ngày xuất', 'required');
            $message = array();
            $message['status'] = 'error';
            $message['content'] = null;
            $message['message'] = 'Kiểm tra thông tin nhập';

            if ($this->form_validation->run($this)) {
				$this->load->model('products/m_products', 'M_products');
				$err = FALSE;
				$id = (int) $this->input->post('id');

				$current_consignments = array();
				$consignments = array();
				$tblAppendGrid = 'tblAppendGrid_';
				$rowOrder = explode(',', $this->input->post($tblAppendGrid . 'rowOrder'));
				if(is_array($rowOrder) && !empty($rowOrder)){
					foreach ($rowOrder as $i) {
						//profit
						$profit = 0;
						$product_id = $this->input->post($tblAppendGrid . 'product_id' . '_' . $i);
						$product = modules::run('products/get', $product_id);
						$quantity = $this->input->post($tblAppendGrid . 'quantity' . '_' . $i);
						$unit_price = filter_var($this->input->post($tblAppendGrid . 'unit_price' . '_' . $i), FILTER_SANITIZE_NUMBER_FLOAT);
						if (isset($product['unit_price'])) {
							$profit = abs($product['unit_price'] - $unit_price) * $quantity;
						}

						$consignments[] = array(
							'product_id' => $product_id,
							'quantity' => $quantity,
							'unit_price' => $unit_price,
							'monetized' => filter_var($this->input->post($tblAppendGrid . 'monetized' . '_' . $i), FILTER_SANITIZE_NUMBER_FLOAT),
							'profit' => $profit,
							'discount' => $this->input->post($tblAppendGrid . 'discount' . '_' . $i),
							'VAT' => 0//$this->input->post($tblAppendGrid . 'VAT' . '_' . $i)
						);
                    }
                    if (!empty($consignments)) {
                        $current_page = $this->input->post('current_page');
                        $date = $this->input->post('date');

                        $customer_id = $this->input->post('customer_id');
                        $customer = modules::run('customers/get', $customer_id);

                        $data_quotation = array(
                            'code' => $this->get_code($id),//input->post('code'),
                            'id_type_of_quote' => $this->input->post('id_type_of_quote'),
                            'employee_id' => $this->input->post('employee_id'),
                            'customer_id' => $customer_id,
                            'customer_type' => isset($customer['customer_type']) ? $customer['customer_type'] : 'KL',
                            'date' => (trim($date) != '') ? get_current_date($date) : 0,
                            'VAT' => 10,//filter_var($this->input->post('VAT'), FILTER_SANITIZE_NUMBER_FLOAT),
                            'note' => $this->input->post('note')
                        );

                        if ($id != 0) {
                            $data_quotation['modified'] = time();
                            if (!$this->M_quotation->update($id, $data_quotation)) {
                                $err = TRUE;
                            } else {
                                $current_data_quotation = $this->M_quotation_details->get($id);
                                if (isset($current_data_quotation) && is_array($current_data_quotation) && !empty($current_data_quotation)) {
                                    $current_consignments = array_column($current_data_quotation, 'quantity', 'product_id');
                                }
                                $this->M_quotation_details->delete($id);
                            }
                            $quotation_id = $id;
                        } else {
                            $data_quotation['admin_id'] = 1;
                            $data_quotation['deleted'] = 0;
                            $data_quotation['deleted_by'] = 0;
                            $data_quotation['created'] = time();
                            $data_quotation['modified'] = 0;
                            $quotation_id = $this->M_quotation->add($data_quotation);
                        }

                        if ($quotation_id != 0) {
                            foreach ($consignments as $value) {
                                $product = modules::run('products/get', $value['product_id']);
                                $total = (int) (isset($product['quantity']) ? $product['quantity'] : 0);
                                if (isset($current_consignments) && is_array($current_consignments) && !empty($current_consignments)) {
                                    if (array_key_exists($value['product_id'], $current_consignments)) {
                                        $total += $current_consignments[$value['product_id']];
                                    }
                                }
                                $data = array(
                                    'quotation_id' => $quotation_id,
                                    'product_id' => $value['product_id'],
                                    'quantity' => $value['quantity'],
                                    'unit_price' => $value['unit_price'],
                                    'monetized' => $value['monetized'],
                                    'profit' => $value['profit'],
                                    'discount' => $value['discount'],
                                    'VAT' => $value['VAT']
                                );
                                if (!$this->M_quotation_details->add($data)) {
                                    $err = TRUE;
                                } else {
                                    $this->M_products->update($value['product_id'], array(
                                        'quantity' => $total - $value['quantity'],
                                        'modified' => time()
                                    ));
                                }
                            }
                        } else {
                            $err = TRUE;
                        }
                    }

                    if ($err === FALSE) {
                        $message['status'] = 'success';
                        $message['content'] = array('data' => (isset($quotation_id) && $quotation_id > 0) ? base_url($this->_module_slug . '/xem/' . $quotation_id) : base_url($this->_module_slug));
                        $message['message'] = 'Báo giá đã lưu!';
                    } else {
                        $message['status'] = 'error';
                        $message['content'] = null;
                        $message['message'] = 'Có lỗi xảy ra! Vui lòng thực hiện lại!';
                    }
				} else {
					$message['status'] = 'error';
					$message['content'] = null;
					$message['message'] = 'Chưa chọn sản phẩm! Vui lòng chọn lại sản phẩm và thực hiện lại!';
				}
            }
            echo json_encode($message);
        }
    }

    function admin_quotation_ajax() {

        $post = $this->input->post();
        if (!empty($post)) {
            $message = array();
            $message['status'] = 'error';
            $message['content'] = null;
            $message['message'] = 'Kiểm tra thông tin nhập';
            $this->load->model('products/m_products', 'M_products');
            $err = FALSE;

            $row = array();
            $consignments = array();
            $count = $this->input->post('count');
            $tblAppendGrid = 'tblAppendGrid_';
            for ($i = 1; $i <= $count; $i++) {
                //profit
                $profit = 0;
                $product_id = $this->input->post($tblAppendGrid . 'product_id' . '_' . $i);
                $product = modules::run('products/get', $product_id);
                $quantity = $this->input->post($tblAppendGrid . 'quantity' . '_' . $i);
                $unit_price = filter_var($this->input->post($tblAppendGrid . 'unit_price' . '_' . $i), FILTER_SANITIZE_NUMBER_FLOAT);
                if (isset($product['unit_price'])) {
                    $profit = abs($product['unit_price'] - $unit_price) * $quantity;
                }

                $consignments[] = array(
                    'product_name' => $product['name'],
                    'product_unit' => $product['unit'],
                    'quantity' => $quantity,
                    'unit_price' => $unit_price,
                    'monetized' => filter_var($this->input->post($tblAppendGrid . 'monetized' . '_' . $i), FILTER_SANITIZE_NUMBER_FLOAT),
                    'profit' => $profit,
                    'discount' => $this->input->post($tblAppendGrid . 'discount' . '_' . $i)
                );
            }
            if (!empty($consignments)) {
                $date = $this->input->post('date');

                $customer_id = $this->input->post('customer_id');
                $customer = modules::run('customers/get', $customer_id);

                $row = array(
                    //'employee_id' => $this->input->post('employee_id'),
                    'customer' => $customer,
                    'customer_type' => isset($customer['customer_type']) ? $customer['customer_type'] : 'KL',
                    'date' => (trim($date) != '') ? get_current_date($date) : 0,
                    'VAT' => filter_var($this->input->post('VAT'), FILTER_SANITIZE_NUMBER_FLOAT),
                    'note' => $this->input->post('note')
                );
                foreach ($consignments as $value) {
                    $data = array(
                        'product_name' => $value['product_name'],
                        'product_unit' => $value['product_unit'],
                        'quantity' => $value['quantity'],
                        'unit_price' => $value['unit_price'],
                        'monetized' => $value['monetized'],
                        'profit' => $value['profit'],
                        'discount' => $value['discount']
                    );
                    $row['items'][] = $data;
                }
            } else {
                $err = TRUE;
            }

            if ($err === FALSE) {
                $message['status'] = 'success';
                $message['content'] = array('data' => $this->load->view('quotation/admin/view_content_print', array('row' => $row), true));
                $message['message'] = 'Báo giá đã tạo!';
            } else {
                $message['status'] = 'error';
                $message['content'] = null;
                $message['message'] = 'Có lỗi xảy ra! Vui lòng thực hiện lại!';
            }
            echo json_encode($message);
        }
    }
	
	function get_code($id) {
		$this->load->model('quotation/m_quotation', 'M_quotation');
        $code = $this->get_max_code();
		while (!$this->M_quotation->check_code_availablity($code, $id)) {
			$code = $this->get_max_code();
		}
		
		return $code;
    }

    function get_max_code() {
        $args = $this->default_args();
        $order_by = array(
            'code' => 'DESC'
        );
        $args['order_by'] = $order_by;
        $rows = $this->M_quotation->gets($args, 1, 0);
        $code = (int) (isset($rows[0]['code']) ? filter_var($rows[0]['code'], FILTER_SANITIZE_NUMBER_INT) : 0) + 1;
        return OUTPUT_VOUCHER_PREFIX . str_pad($code, OUTPUT_VOUCHER_LENGHT, "0", STR_PAD_LEFT);
    }

    function check_code_availablity() {
        $this->load->model('quotation/m_quotation', 'M_quotation');
        $post = $this->input->post();
        $this->_message_success = 'true';
        $this->_message_danger = 'false';

        if (!empty($post)) {
            $code = $this->input->post('code');
            $id = $this->input->post('id');
            if ($this->input->post('ajax') == '1') {
                if ($this->M_quotation->check_code_availablity($code, $id)) {
                    $this->_status = "success";
                    $this->_message = $this->_message_success;
                } else {
                    $this->_status = "danger";
                    $this->_message = $this->_message_danger;
                }

                $this->set_json_encode();
                $this->load->view('layout/json_data', $this->_data);
            } else {
                if ($this->M_quotation->check_code_availablity($code, $id)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        } else {
            redirect(base_url());
        }
    }

    function check_code_format() {
        $post = $this->input->post();
        $this->_message_success = 'true';
        $this->_message_danger = 'false';

        if (!empty($post)) {
            if ($this->input->post('ajax') == '1') {
                $code = $this->input->post('code');
                if ($this->is_code_format($code)) {
                    $this->_status = "success";
                    $this->_message = $this->_message_success;
                } else {
                    $this->_status = "danger";
                    $this->_message = $this->_message_danger;
                }

                $this->set_json_encode();
                $this->load->view('layout/json_data', $this->_data);
            } else {
                $code = $this->input->post('code');
                if ($this->is_code_format($code)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        } else {
            redirect(base_url());
        }
    }

    function is_code_format($code = '') {
        $result = preg_match("/" . OUTPUT_VOUCHER_PREFIX . "[0-9]{" . OUTPUT_VOUCHER_LENGHT . "," . OUTPUT_VOUCHER_LENGHT . "}$/", $code);
        return ($result == 1) ? TRUE : FALSE;
    }

    function admin_content() {
        $this->_validate_access_role();
		
        $this->_plugins_css_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery-ui.structure.min'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery-ui.theme.min'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery-ui-1.11.1.min'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery.appendGrid-1.6.2'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery.appendGrid-1.6.2'
        );


        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker3'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/js',
            'name' => 'bootstrap-datepicker'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/locales',
            'name' => 'bootstrap-datepicker.vi.min'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker',
            'name' => 'app.editinfo'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery-validation',
            'name' => 'jquery.validate'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery-validation/localization',
            'name' => 'messages_vi'
        );

        $this->_plugins_css_admin[] = array(
            'folder' => 'chosen',
            'name' => 'chosen'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'chosen',
            'name' => 'chosen.jquery'
        );

        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'quotation',
            'name' => 'admin-borrow-content'
        );
        $this->set_modules();

        $max_code = $this->get_max_code();
        $this->_data['max_code'] = $max_code;

        $this->_data['customers'] = modules::run('customers/gets', array('deleted' => 0));
        $this->_data['employee'] = modules::run('employee/gets');
        $this->_data['category'] = modules::run('category/gets');
        $this->_data['products'] = modules::run('products/gets', array('deleted' => 0));

        $title = 'Báo giá - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
        $id = ($this->uri->segment(3) == '') ? 0 : $this->uri->segment(3);
        if ($id != 0) {
            $this->_data['current_page'] = (int) $this->input->get('current_page');
            $row = $this->get($id);
            $row['items'] = $this->M_quotation_details->get_data_in_quotation_id($row['id']);
            $this->_data['row'] = $row;

            $title = 'Cập nhật báo giá - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
        }
		
		$this->_data['type_of_quote'] = modules::run('quotation/type_of_quote/gets');

        $this->_data['title'] = $title;
        $this->_data['main_content'] = 'quotation/admin/view_page_content';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_quotation() {
        $this->_validate_access_role();

        $this->_module_slug = '';
        $this->_data['module_slug'] = $this->_module_slug;

        $this->_plugins_css_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery-ui.structure.min'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery-ui.theme.min'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery-ui-1.11.1.min'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery.appendGrid-1.6.2'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery.appendGrid-1.6.2'
        );


        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker3'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/js',
            'name' => 'bootstrap-datepicker'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/locales',
            'name' => 'bootstrap-datepicker.vi.min'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker',
            'name' => 'app.editinfo'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery-validation',
            'name' => 'jquery.validate'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery-validation/localization',
            'name' => 'messages_vi'
        );

        $this->_plugins_css_admin[] = array(
            'folder' => 'chosen',
            'name' => 'chosen'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'chosen',
            'name' => 'chosen.jquery'
        );

        $this->_plugins_script_admin[] = array(
            'folder' => 'jQuery-Plugin-To-Print-Any-Part-Of-Your-Page-Print',
            'name' => 'jQuery.print'
        );

        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'quotation',
            'name' => 'admin-quotation'
        );
        $this->set_modules();

        $this->_data['customers'] = modules::run('customers/gets', array('deleted' => 0));
        $args = modules::run('products/default_args');
        $args['deleted'] = 0;
        $this->_data['products'] = modules::run('products/gets', $args);
		
        $this->_data['type_of_quote'] = modules::run('quotation/type_of_quote/gets');

        $this->_data['breadcrumbs_module_name'] = 'Báo giá';
        $this->_data['breadcrumbs_module_func'] = '';
        $this->_data['title'] = $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
        $this->_data['main_content'] = 'quotation/admin/view_page_quotation';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_view() {
        $this->_validate_access_role();
		
        $this->_plugins_css_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery-ui.structure.min'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery-ui.theme.min'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery-ui-1.11.1.min'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery.appendGrid-1.6.2'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery.appendGrid-1.6.2'
        );


        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker3'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/js',
            'name' => 'bootstrap-datepicker'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/locales',
            'name' => 'bootstrap-datepicker.vi.min'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker',
            'name' => 'app.editinfo'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery-validation',
            'name' => 'jquery.validate'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery-validation/localization',
            'name' => 'messages_vi'
        );

        $this->_plugins_css_admin[] = array(
            'folder' => 'chosen',
            'name' => 'chosen'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'chosen',
            'name' => 'chosen.jquery'
        );

        $this->_plugins_script_admin[] = array(
            'folder' => 'jQuery-Plugin-To-Print-Any-Part-Of-Your-Page-Print',
            'name' => 'jQuery.print'
        );

        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'quotation',
            'name' => 'admin-borrow-view'
        );
        $this->set_modules();

        $this->_data['customers'] = modules::run('customers/gets');
        $this->_data['employee'] = modules::run('employee/gets');
        $this->_data['products'] = modules::run('products/gets');

        $id = ($this->uri->segment(3) == '') ? 0 : $this->uri->segment(3);
        if ($id != 0) {
            $row = $this->get($id);
            if (!is_array($row) || empty($row)) {
                redirect($this->_module_slug);
            }

            $row['items'] = $this->M_quotation_details->get($row['id']);
            $this->_data['row'] = $row;

            $title = 'Xem báo giá' . (isset($row['code']) && trim($row['code']) != '' ? ' ' . $row['code'] : '') . ' - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
        } else {
            redirect($this->_module_slug);
        }
//        echo "<pre>";
//        print_r($this->_data['row']);
//        echo "</pre>";
//        die();

        $this->_data['title'] = $title;
        $this->_data['main_content'] = 'quotation/admin/view_page_view';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_delete() {
        $this->_validate_access_role();
		
        $id = (int) $this->input->get('id');
        $row = $this->get($id);
        if ($id != 0 && !empty($row)) {
            if ($this->M_quotation->update($id, array('deleted' => 1, 'deleted_by' => $this->_data['userid']))) {
                $notify_type = 'success';
                $notify_content = "Đã xóa báo giá!";
            } else {
                $notify_type = 'danger';
                $notify_content = "Chưa xóa báo giá!";
            }
        } else {
            $notify_type = 'warning';
            $notify_content = "Báo giá không tồn tại!";
        }
        $this->set_notify_admin($notify_type, $notify_content);
        redirect(base_url($this->_module_slug));
    }

    function admin_delete_trash() {
        $this->_validate_access_role();
		
        $this->_module_slug = 'thung-rac/bao-gia';
        $id = (int) $this->input->get('id');
        $row = $this->get($id);
        if ($id != 0 && !empty($row)) {
            if ($this->M_quotation->delete($id)) {
                $this->M_quotation_details->delete($id);
                $notify_type = 'success';
                $notify_content = "Đã xóa báo giá!";
            } else {
                $notify_type = 'danger';
                $notify_content = "Chưa xóa báo giá!";
            }
        } else {
            $notify_type = 'warning';
            $notify_content = "Báo giá không tồn tại!";
        }
        $this->set_notify_admin($notify_type, $notify_content);
        redirect(base_url($this->_module_slug));
    }

    function admin_main() {
        $this->_validate_access_role();
		
        $post = $this->input->post();
        if (!empty($post)) {
            $action = $this->input->post('action');
            if ($action == 'delete') {
                $this->_message_success = 'Đã xóa các báo giá được chọn!';
                $this->_message_warning = 'Bạn chưa chọn báo giá nào!';
                $ids = $this->input->post('idcheck');

                if (is_array($ids) && !empty($ids)) {
                    foreach ($ids as $id) {
                        $row = $this->get($id);
                        if ($this->M_quotation->update($id, array('deleted' => 1, 'deleted_by' => $this->_data['userid']))) {
                            $notify_type = 'success';
                            $notify_content = $this->_message_success;
                        } else {
                            $notify_type = 'danger';
                            $notify_content = $this->_message_danger;
                        }
                    }
                } else {
                    $notify_type = 'warning';
                    $notify_content = $this->_message_warning;
                }
                $this->set_notify_admin($notify_type, $notify_content);
                redirect(base_url($this->_module_slug));
            } elseif ($action == 'content') {
                redirect(base_url($this->_module_slug . '/them'));
            }
        } else {
            redirect(get_admin_url($this->_module_slug));
        }
    }

    function ajax_get_customer() {
        $id = (int) $this->input->post('id');
        $customer = modules::run('customers/get', $id);

        $message = array();
        $message['status'] = 'error';
        $message['content'] = null;
        $message['message'] = '';

        if ($id != 0 && !empty($customer)) {
            $message['status'] = 'success';
            $message['content'] = array('data' => $customer);
            $message['message'] = '';
        }
        echo json_encode($message);
    }

    function ajax_get_enddate() {
        $message = array();
        $end_date = get_current_date($this->input->post('start_date'));
        if ($end_date > 0) {
            $message['status'] = 'success';
            $message['content'] = array('data' => date('d/m/Y', $end_date));
            $message['message'] = '';
        } else {
            $message['status'] = 'error';
            $message['content'] = null;
            $message['message'] = '';
        }
        echo json_encode($message);
    }

}

/* End of file store_received_voucher.php */
    /* Location: ./application/modules/store_received_voucher/controllers/store_received_voucher.php */
    