<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Customers extends Layout {

    private $_module_slug = 'khach-hang';
    public $_path = '';

    function __construct() {
        parent::__construct();
        $this->_path = get_module_path('customers');
        $this->_data['breadcrumbs_module_name'] = 'Khách hàng';
        $this->_data['module_slug'] = $this->_module_slug;
		$_breadcrumbs_admin[] = array(
			'url' => '',
			'name' => 'Khách hàng',
			'image' => base_url('assets/Frest/app-assets/images/svg/ico/ico-customer.svg'),
		);
		$this->_data['breadcrumbs_admin'] = $_breadcrumbs_admin;
    }

	private function _validate_access_role(){
		$this->validate_access_role('ROLE_GROUP_CUSTOMER');
	}

    function is_owned($user_id = 0, $id = 0){
        $row = $this->get($id);
        if(isset($row['created_by']) && $row['created_by'] == $user_id){
            return TRUE;
        }
        return FALSE;
    }

    function default_args() {
        $order_by = array(
            'full_name' => 'ASC',
        );
        $args = array();
        $args['order_by'] = $order_by;

        return $args;
    }

    function gets($options = array()) {
        $default_args = $this->default_args();
        if (is_array($options) && !empty($options)) {
            $args = array_merge($default_args, $options);
        } else {
            $args = $default_args;
        }
        return $this->M_customers->gets($args);
    }

    function counts($options = array()) {
        $default_args = $this->default_args();
        if (is_array($options) && !empty($options)) {
            $args = array_merge($default_args, $options);
        } else {
            $args = $default_args;
        }
        return $this->M_customers->counts($args);
    }

    function get($id) {
        return $this->M_customers->get($id);
    }

    function ajax_admin_get() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = 'Kiểm tra thông tin';

        $post = $this->input->post();
        if (!empty($post)) {
            $id = $this->input->post('id');
            $data = $this->get($id);

            if (is_array($data) && !empty($data)) {
				if (isset($data['customer_type'])) {
                    $data['type'] = get_value_array($this->config->item('customer_type'), isset($data['customer_type']) ? $data['customer_type'] : 'KL');
                }
                //tính nợ
                /*
                $customer_id = $id;
                $paid = 0;
                $pays = modules::run('pay/gets', array('customer_id' => $customer_id));
                if(is_array($pays) && !empty($pays)){
                    $paid = array_sum(array_column($pays, 'amount'));
                }
                $output_voucher_pay_by_customer = modules::run('output_voucher/get_pay_by_customer', $customer_id);
                $data['arrears'] = $output_voucher_pay_by_customer['remainder'] - $paid;
                */

                $message['status'] = 'success';
                $message['content'] = $data;
                $message['message'] = 'Tải dữ liệu thành công!';
            } else {
                $message['status'] = 'danger';
                $message['content'] = null;
                $message['message'] = 'Có lỗi xảy ra! Vui lòng kiểm tra lại!';
            }
        }
        echo json_encode($message);
        exit();
    }

    function get_arrears_ajax() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = 'Kiểm tra thông tin';

        $post = $this->input->post();
        if (!empty($post)) {
            $id = $this->input->post('id');
            $data = $this->get($id);

            if (is_array($data) && !empty($data)) {
                $message['status'] = 'success';
                $message['content'] = $this->get_arrears($id);
                $message['message'] = 'Tải dữ liệu thành công!';
            } else {
                $message['status'] = 'danger';
                $message['content'] = null;
                $message['message'] = 'Có lỗi xảy ra! Vui lòng kiểm tra lại!';
            }
        }
        echo json_encode($message);
        exit();
    }

    function get_arrears($customer_id = 0) {
        $paid = 0;
        $pays = modules::run('pay/gets', array('customer_id' => $customer_id));
        if(is_array($pays) && !empty($pays)){
            $paid = array_sum(array_column($pays, 'amount'));
        }
        $output_voucher_pay_by_customer = modules::run('output_voucher/get_pay_by_customer', $customer_id);
        return $output_voucher_pay_by_customer['remainder'] - $paid;
    }

	function admin_report() {
		$this->_initialize_admin();
        $this->_validate_access_role();

		$this->_module_slug = 'bao-cao/khach-hang';
		$this->_data['module_slug'] = $this->_module_slug;
		$_breadcrumbs_admin[] = array(
			'url' => '',
			'name' => 'Báo cáo khách hàng',
			'image' => base_url('assets/Frest/app-assets/images/svg/ico/ico-report.svg'),
		);
		$this->_data['breadcrumbs_admin'] = $_breadcrumbs_admin;

		$this->_plugins_css_admin[] = array(
			'folder' => 'bootstrap-datepicker/css',
			'name' => 'bootstrap-datepicker',
		);
		$this->_plugins_css_admin[] = array(
			'folder' => 'bootstrap-datepicker/css',
			'name' => 'bootstrap-datepicker3',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'bootstrap-datepicker/js',
			'name' => 'bootstrap-datepicker',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'bootstrap-datepicker/locales',
			'name' => 'bootstrap-datepicker.vi.min',
		);

		$this->_plugins_css_admin[] = array(
			'folder' => 'chosen',
			'name' => 'chosen',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'chosen',
			'name' => 'chosen.jquery',
		);

		$this->_plugins_script_admin[] = array(
			'folder' => 'jQuery-Plugin-To-Print-Any-Part-Of-Your-Page-Print',
			'name' => 'jQuery.print',
		);

		$this->set_plugins_admin();

		$this->_modules_script[] = array(
			'folder' => 'products',
			'name' => 'admin-report',
		);
		$this->set_modules();

		$get = $this->input->get();
		$this->_data['get'] = $get;

		$args = $this->default_args();
		$args['deleted'] = 0;

		if (isset($get['customer_type_id']) && ((int) $get['customer_type_id']) != 0) {
			$args['id_type_of_customer'] = $get['customer_type_id'];
		}

		if (isset($get['q']) && trim($get['q']) != '') {
            $args['q'] = $get['q'];
        }

		$total = $this->counts($args);
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

		$this->pagination->initialize($config);

		$pagination = $this->pagination->create_links();
		$offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment); # Lấy offset
		$this->_data['current_page'] = (int) $offset;

		$this->_data['pagination'] = $pagination;
		$rows = $this->M_customers->gets($args, $perpage, $offset);
		if(is_array($rows) && !empty($rows)){
			foreach ($rows as $key => $value) {
				$output_voucher = modules::run('output_voucher/gets', array('customer_id' => $value['id']));
				$output_voucher_ids = (is_array($output_voucher) && !empty($output_voucher)) ? array_column($output_voucher, 'id') : array(-1);
				$items_output_voucher = $this->M_output_voucher_details->gets(array('in_output_voucher_id' => $output_voucher_ids));
				$total_quantity = 0;
				$total_monetized = 0;
				if(is_array($items_output_voucher) && !empty($items_output_voucher)){
					$total_quantity = array_sum(array_column($items_output_voucher, 'quantity'));
					$total_monetized = array_sum(array_column($items_output_voucher, 'monetized'));
				}
				$rows[$key]['total_quantity'] = $total_quantity;
				$rows[$key]['total_monetized'] = $total_monetized;

                $paid = 0;
                $pays = modules::run('pay/gets', array('customer_id' => $value['id']));
                if(is_array($pays) && !empty($pays)){
                    $paid = array_sum(array_column($pays, 'amount'));
                }
                $output_voucher_pay_by_customer = modules::run('output_voucher/get_pay_by_customer', $value['id']);
                $rows[$key]['prepaid'] = $output_voucher_pay_by_customer['prepaid'];
                $rows[$key]['paid'] = $paid;
                $rows[$key]['remainder'] = $output_voucher_pay_by_customer['remainder'];
                $rows[$key]['indebtedness'] = $output_voucher_pay_by_customer['indebtedness'];
            }
        }
		$this->_data['rows'] = $rows;
		/*
		echo "<pre>";
		print_r($rows);
		echo "</pre>";
		die;
		*/

		$this->_data['customer_types'] = modules::run('customer_types/gets');
        $this->_data['type_of_customer'] = modules::run('customers/type_of_customer/gets');

		$this->_data['breadcrumbs_module_name'] = 'Báo cáo';
		$this->_data['breadcrumbs_module_func'] = 'Khách hàng';
		$this->_data['title'] = 'Báo cáo theo khách hàng';
		$this->_data['main_content'] = 'customers/view_page_report';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

    function admin_print_barcode() {
        $this->_initialize_admin();
        $this->_validate_access_role();

        $this->_plugins_css_admin[] = array(
            'folder' => 'chosen',
            'name' => 'chosen',
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'chosen',
            'name' => 'chosen.jquery',
        );
        $this->set_plugins_admin();

        $this->_modules_css[] = array(
            'folder' => 'customers',
            'name' => 'print-barcode',
        );
        $this->_modules_script[] = array(
            'folder' => 'customers',
            'name' => 'admin-print-barcode',
        );
        $this->set_modules();

        $args = $this->default_args();
        $args['deleted'] = 0;
        if(in_array($this->_data['role'], array('SALES'))){
            $args['created_by'] = $this->_data['userid'];
        }
        $get = $this->input->get();
        $this->_data['get'] = $get;
        if(isset($get['ids']) && is_array($get['ids']) && !empty($get['ids'])){
            $args['in_id'] = $get['ids'];
        }
        $rows = $this->gets($args);
        $this->_data['rows'] = $rows;

        $args = $this->default_args();
        $args['deleted'] = 0;
        if(in_array($this->_data['role'], array('SALES'))){
            $args['created_by'] = $this->_data['userid'];
        }
        $this->_data['customers'] = $this->gets($args);

        $this->_data['title'] = 'In barcode khách hàng - ' . $this->_data['title'];
        $this->_data['main_content'] = 'customers/view_page_print_barcode';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_export_excel() {
        $this->_initialize_admin();
        $this->_validate_access_role();
        $is_admin = false;
        if(isset($this->_data['role']) && in_array($this->_data['role'], array('ADMIN'))){
            $is_admin = true;
        }
        $this->load->library('excel');
        $this->excel->getProperties()->setCreator("Admin")
            ->setLastModifiedBy("Admin")
            ->setTitle("Danh sách khách hàng")
            ->setSubject("Danh sách khách hàng")
            ->setDescription("Quản lý danh sách khách hàng")
            ->setKeywords("Quản lý danh sách khách hàng")
            ->setCategory("Khách hàng");
        $this->excel->getActiveSheet()->setTitle('Danh sách khách hàng');

        $args = $this->default_args();
        if($is_admin){
            $this->excel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'STT')
                ->setCellValue('B1', 'ID')
                ->setCellValue('C1', 'Khách hàng')
                ->setCellValue('D1', 'Mã khách hàng')
                ->setCellValue('E1', 'Điện thoại')
                ->setCellValue('F1', 'Email')
                ->setCellValue('G1', 'Loại khách hàng')
                ->setCellValue('H1', 'Loại giá')
                ->setCellValue('I1', 'Chiết khấu(%)')
                ->setCellValue('J1', 'Kích hoạt')
                ->setCellValue('K1', 'Địa chỉ')
                ->setCellValue('L1', 'Khu vực')
                ->setCellValue('M1', 'Thành phố')
                ->setCellValue('N1', 'Ghi chú')
                ->setCellValue('O1', 'Người tạo')
                ->setCellValue('P1', 'Thêm')
                ->setCellValue('Q1', 'Cập nhật');
        }else{
            $args['deleted'] = 0;
            $this->excel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'STT')
                ->setCellValue('B1', 'ID')
                ->setCellValue('C1', 'Khách hàng')
                ->setCellValue('D1', 'Mã khách hàng')
                ->setCellValue('E1', 'Điện thoại')
                ->setCellValue('F1', 'Email')
                ->setCellValue('G1', 'Địa chỉ')
                ->setCellValue('H1', 'Khu vực')
                ->setCellValue('I1', 'Thành phố')
                ->setCellValue('J1', 'Ghi chú')
                ->setCellValue('K1', 'Cập nhật');
        }

        if(in_array($this->_data['role'], array('SALES'))){
            $args['created_by'] = $this->_data['userid'];
        }
        $rows = $this->M_customers->gets($args);
        $i = 2;
        $order = 0;
        if (is_array($rows) && !empty($rows)) {
            if($is_admin){
                foreach ($rows as $row) {
                    $order++;
                    $this->excel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $i, $order)
                        ->setCellValue('B' . $i, $row['id'])
                        ->setCellValue('C' . $i, $row['full_name'])
                        ->setCellValue('D' . $i, strval($row['customer_code']))
                        ->setCellValue('E' . $i, strval($row['phone']))
                        ->setCellValue('F' . $i, $row['email'])
                        ->setCellValue('G' . $i, $row['id_type_of_customer'])
                        ->setCellValue('H' . $i, $row['customer_type'])
                        ->setCellValue('I' . $i, 0)
                        ->setCellValue('J' . $i, $row['active'])
                        ->setCellValue('K' . $i, $row['address'])
                        ->setCellValue('L' . $i, $row['area'])
                        ->setCellValue('M' . $i, $row['city'])
                        ->setCellValue('N' . $i, $row['note'])
                        ->setCellValue('O' . $i, $row['created_by'])
                        ->setCellValue('P' . $i, ($row['created'] > 0 ? display_date($row['created'], true) : ''))
                        ->setCellValue('Q' . $i, ($row['modified'] > 0 ? display_date($row['modified'], true) : ''));
                    $this->excel->getActiveSheet()->setCellValueExplicit('D' . $i, strval($row['customer_code']), PHPExcel_Cell_DataType::TYPE_STRING);
                    $this->excel->getActiveSheet()->setCellValueExplicit('E' . $i, strval($row['phone']), PHPExcel_Cell_DataType::TYPE_STRING);
                    $i++;
                }
            }else{
                foreach ($rows as $row) {
                    $order++;
                    $this->excel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $i, $order)
                        ->setCellValue('B' . $i, $row['id'])
                        ->setCellValue('C' . $i, $row['full_name'])
                        ->setCellValue('D' . $i, strval($row['customer_code']))
                        ->setCellValue('E' . $i, strval($row['phone']))
                        ->setCellValue('F' . $i, $row['email'])
                        ->setCellValue('G' . $i, $row['address'])
                        ->setCellValue('H' . $i, $row['area'])
                        ->setCellValue('I' . $i, $row['city'])
                        ->setCellValue('J' . $i, $row['note'])
                        ->setCellValue('K' . $i, ($row['modified'] > 0 ? display_date($row['modified'], true) : display_date($row['created'], true)));
                    $this->excel->getActiveSheet()->setCellValueExplicit('D' . $i, strval($row['customer_code']), PHPExcel_Cell_DataType::TYPE_STRING);
                    $this->excel->getActiveSheet()->setCellValueExplicit('E' . $i, strval($row['phone']), PHPExcel_Cell_DataType::TYPE_STRING);
                    $i++;
                }
            }
        }
        // $range = 'D2' . ':E'.($i-1);
        // $this->excel->getActiveSheet()
        //     ->getStyle($range)
        //     ->getNumberFormat()
        //     ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        // https://stackoverflow.com/questions/9635178/how-to-get-phpexcel-to-keep-leading-0s-in-phone-numbers

        $filename = 'Danh-sach-khach-hang_' . date('Y-m-d_h-i-s') . '.xls';
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save('php://output');
    }

    function admin_import_excel() {
        $this->_initialize_admin();
        $this->_validate_access_role();

        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-fileinput/css',
            'name' => 'fileinput'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-fileinput/js',
            'name' => 'fileinput.min'
        );

        $this->set_plugins_admin();

        $post = $this->input->post();
        if (!empty($post)) {
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('token', 'Don\'t kack to site', 'trim|required');
            if ($this->form_validation->run($this)) {
                $input_name = 'file';
                $file = $this->_upload_files($input_name, $this->_path, array('allowed_types' => 'xls|xlsx'));

                if (trim($file) != '') {
                    $this->load->library('excel');
                    $header = array();
                    $data = array();
                    $rows = array();

                    $objPHPExcel = PHPExcel_IOFactory::load('./' . $this->_path . $file);
                    $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                    foreach ($cell_collection as $cell) {
                        $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                        $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                        $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                        if ($row == 1) {
                            $header[$row][$column] = $data_value;
                        } else {
                            $rows[$row][$column] = $data_value;
                        }
                    }

                    $data['header'] = $header;
                    $data['values'] = $rows;

                    $is_error = FALSE;
                    if (is_array($data['values']) && !empty($data['values'])) {
                        $this->M_customers->truncate();
                        foreach ($data['values'] as $value) {
                            $full_name = (isset($value['C']) && $value['C'] != NULL) ? trim($value['C']) : '';
                            $phone = (isset($value['E']) && $value['E'] != NULL) ? $value['E'] : '';
                            $customer_code = (isset($value['D']) && $value['D'] != NULL) ? $value['D'] : $phone;
                            $email = (isset($value['F']) && $value['F'] != NULL) ? $value['F'] : '';
                            if($full_name != ''){
                                $data_row = array(
                                    'full_name' => $full_name,
                                    'customer_code' => $customer_code,
                                    'phone' => $phone,
                                    'email' => $email,
                                    'id_type_of_customer' => (isset($value['G']) && $value['G'] != NULL) ? (int)$value['G'] : 0,
                                    'customer_type' => (isset($value['H']) && $value['H'] != NULL) ? (int)$value['H'] : 0,
                                    'discount' => (isset($value['I']) && $value['I'] != NULL) ? (float)$value['I'] : 0,
                                    'active' => (isset($value['J']) && $value['J'] != NULL) ? (int)$value['J'] : 0,
                                    'address' => (isset($value['K']) && $value['K'] != NULL) ? $value['K'] : '',
                                    'area' => (isset($value['L']) && $value['L'] != NULL) ? $value['L'] : '',
                                    'city' => (isset($value['M']) && $value['M'] != NULL) ? $value['M'] : '',
                                    'note' => (isset($value['N']) && $value['N'] != NULL) ? $value['N'] : '',
                                    'created_by' => (isset($value['O']) && $value['O'] != NULL) ? (int)$value['O'] : 0,
                                    'deleted' => (isset($value['P']) && $value['P'] != NULL) ? (int)$value['P'] : 0,
                                    'deleted_by' => (isset($value['Q']) && $value['Q'] != NULL) ? (int)$value['Q'] : 0,
                                    'add_time' => (isset($value['R']) && $value['R'] != NULL) ? convert_str_to_date($value['R']) : time(),
                                    'edit_time' => (isset($value['S']) && $value['S'] != NULL) ? convert_str_to_date($value['S']) : 0,
                                );

                                if (isset($value['B']) && (int) $value['B'] != 0) {
                                    $data_row['id'] = (int) $value['B'];
                                }
                                if (!$this->M_customers->add($data_row)) {
                                    $is_error = TRUE;
                                }elseif(trim($customer_code) != ''){
                                    $this->create_barcode_image($customer_code, 0, $full_name);
                                }
                            }
                        }
                    }

                    if (!$is_error) {
                        @unlink(FCPATH . $this->_path . $file);

                        $notify_type = 'success';
                        $notify_content = 'Dữ liệu khách hàng đã nhập thành công!';
                        $this->set_notify_admin($notify_type, $notify_content);
                        redirect(base_url($this->_module_slug));
                    } else {
                        $notify_type = 'danger';
                        $notify_content = 'Có lỗi xảy ra! Vui lòng kiểm tra lại!';
                        $this->set_notify_admin($notify_type, $notify_content);
                    }
                }
            }
        }

        $this->_data['title'] = 'Nhập dữ liệu khách hàng - ' . $this->_data['title'];
        $this->_data['main_content'] = 'customers/view_page_import';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function _upload_files($input_name = 'file', $upload_path = '', $options = array('allowed_types' => 'gif|jpg|png|jpeg')) {
        $filename = '';
        $info = modules::run('files/index', $input_name, $upload_path, $options);
        if (isset($info['uploads'])) {
            $upload_images = $info['uploads']; // thông tin ảnh upload
            if ($_FILES[$input_name]['size'] != 0) {
                foreach ($upload_images as $value) {
                    $filename = $value['file_name'];
                }
            }
        }

        return $filename;
    }

    function admin_remainder() {
        $this->_initialize_admin();
        $this->_validate_access_role();

        $this->_data['module_slug'] = $this->_module_slug = 'cong-no-khach-hang';
        // $str = '16:16:48 21/02/2019';
        // $date = convert_str_to_date($str);
        // echo $date;
        // echo "<br>" . date('H:i:s d/m/Y', $date);
        // die;

        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker',
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker3',
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/js',
            'name' => 'bootstrap-datepicker',
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/locales',
            'name' => 'bootstrap-datepicker.vi.min',
        );

        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap4-dialog/css',
            'name' => 'bootstrap-dialog',
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap4-dialog/js',
            'name' => 'bootstrap-dialog',
        );
        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'customers',
            'name' => 'admin-remainder'
        );
        $this->set_modules();

        $get = $this->input->get();
        $this->_data['get'] = $get;
        $allow_method = array(
            'full_name',
            'address',
            'phone',
        );

        $args = $this->default_args();
        $args['has_arrears'] = 0;
        /*if(!(isset($this->_data['role']) && in_array($this->_data['role'], array('ADMIN')))){
            $args['created_by'] = $this->_data['userid'];
        }*/
        if (isset($get['q']) && trim($get['q']) != '') {
            $args['q'] = $get['q'];
        }

        //theo ngay
        if (isset($get['fromday']) && trim($get['fromday']) != '') {
            $args['start_date_start'] = get_current_date($get['fromday']);
        }
        if (isset($get['today']) && trim($get['today']) != '') {
            $args['start_date_end'] = get_current_date($get['today']);
        }

        $total = $this->counts($args);
        $perpage = isset($get['per_page']) ? (int) $get['per_page'] : 10;
        $segment = 2;

        $this->load->library('pagination');
        $config['total_rows'] = $total;
        $config['per_page'] = $perpage;
        $config['full_tag_open'] = '<ul class="pagination no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';

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
        $rows = $this->M_customers->gets($args, $perpage, $offset);
        if(is_array($rows) && !empty($rows)){
            foreach ($rows as $key => $value) {
                $customer_id = $value['id'];
                $arrears = $value['arrears'];

                $paid = 0;
                $pays = modules::run('pay/gets', array('customer_id' => $customer_id));
                if(is_array($pays) && !empty($pays)){
                    $paid = array_sum(array_column($pays, 'amount'));
                }

                $output_voucher_pay_by_customer = modules::run('output_voucher/get_pay_by_customer', $customer_id);
                $remainder = $output_voucher_pay_by_customer['remainder'];
                $rows[$key]['paid'] = $paid;
                $rows[$key]['remainder'] = $remainder;
                $rows[$key]['total'] = $arrears + $paid - $remainder;
            }
        }
        $this->_data['rows'] = $rows;
        $this->_data['pagination'] = $pagination;

        $this->_data['breadcrumbs_module_func'] = 'Công nợ khách hàng';
        $this->_data['title'] = 'Công nợ khách hàng';
        $this->_data['main_content'] = 'customers/view_page_remainder';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_remainder_export_excel() {
        $this->_initialize_admin();
        $this->_validate_access_role();

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $args = $this->default_args();
        $args['has_arrears'] = 0;
        /*if(!(isset($this->_data['role']) && in_array($this->_data['role'], array('ADMIN')))){
            $args['created_by'] = $this->_data['userid'];
        }*/
        if (isset($get['q']) && trim($get['q']) != '') {
            $args['q'] = $get['q'];
        }

        //theo ngay
        if (isset($get['fromday']) && trim($get['fromday']) != '') {
            $args['start_date_start'] = get_current_date($get['fromday']);
        }
        if (isset($get['today']) && trim($get['today']) != '') {
            $args['start_date_end'] = get_current_date($get['today']);
        }
        $rows = $this->M_customers->gets($args);
        if (!is_array($rows) && empty($rows)) {
            $this->_module_slug = 'cong-no-khach-hang';

            $notify_type = 'danger';
            $notify_content = 'Chưa có dữ liệu!';
            $this->set_notify_admin($notify_type, $notify_content);
            redirect(base_url($this->_module_slug));
        }
        
        $this->load->library('excel');

        $glue = '|';
        $firstColumn = 'A';
        $lastColumn = 'F';
        $letterColumn = range($firstColumn, $lastColumn);
        $hideColumn = 'G';

        $numberFormat = '#,##0';

        $styleAlignmentCenter = array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        );

        $styleAlignmentRight = array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        );

        $styleHeader = array(
            'name' => 'Arial',
            'bold' => true,
            'color' => array(
                'rgb' => 'FFFFFF',
            ),
        );

        $styleHighlight = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '3582F4'),
            ),
        );

        $this->excel->getProperties()->setCreator("Admin")
            ->setLastModifiedBy("Admin")
            ->setTitle("Danh sách công nợ khách hàng")
            ->setSubject("Danh sách công nợ khách hàng")
            ->setDescription("Danh sách công nợ khách hàng")
            ->setKeywords("Danh sách công nợ khách hàng")
            ->setCategory("Danh sách công nợ khách hàng");
        $this->excel->getActiveSheet()->setTitle('Danh sách công nợ khách hàng');

        $this->excel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'STT')
            ->setCellValue('B1', 'Tên KH')
            ->setCellValue('C1', 'Tên công ty')
            ->setCellValue('D1', 'Nợ phát sinh')
            ->setCellValue('E1', 'Đã trả')
            ->setCellValue('F1', 'Nợ cuối kỳ');

        $this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFill()->getStartColor()->setARGB('FF0000');
        // Add some data
        $this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        //Header
        $this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFont()->applyFromArray($styleHeader);

        //Alignment
        $this->excel->getActiveSheet()->getStyle('D1')->getAlignment()->applyFromArray($styleAlignmentCenter);

        //Highlight Header
        $fillHighlightHeader = '92d050';
        $this->excel->getActiveSheet()->getStyle('G1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);

        foreach ($letterColumn as $column) {
            $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }

        $i = 2;
        $order = 0;
        foreach ($rows as $row) {
            $order++;
            $customer_id = $row['id'];
            $arrears = $row['arrears'];

            $paid = 0;
            $pays = modules::run('pay/gets', array('customer_id' => $customer_id));
            if(is_array($pays) && !empty($pays)){
                $paid = array_sum(array_column($pays, 'amount'));
            }

            $output_voucher_pay_by_customer = modules::run('output_voucher/get_pay_by_customer', $customer_id);
            $remainder = $output_voucher_pay_by_customer['remainder'];
            $row['paid'] = $paid;
            $row['remainder'] = $remainder;
            $row['total'] = $arrears + $paid - $remainder;

            // $this->excel->getActiveSheet()->getStyle('A' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            // $this->excel->getActiveSheet()->getStyle('B' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            // $this->excel->getActiveSheet()->getStyle('C' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            // $this->excel->getActiveSheet()->getStyle('D' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            // $this->excel->getActiveSheet()->getStyle('E' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            // $this->excel->getActiveSheet()->getStyle('F' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $this->excel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $order)
                ->setCellValue('B' . $i, $row['full_name'])
                ->setCellValue('C' . $i, $row['company'])
                ->setCellValue('D' . $i, abs($row['remainder']))
                ->setCellValue('E' . $i, abs($row['paid']))
                ->setCellValue('F' . $i, abs($row['arrears']));

            $this->excel->getActiveSheet()->getStyle('D' . $i)->getNumberFormat()->setFormatCode($numberFormat);
            $this->excel->getActiveSheet()->getStyle('E' . $i)->getNumberFormat()->setFormatCode($numberFormat);
            $this->excel->getActiveSheet()->getStyle('F' . $i)->getNumberFormat()->setFormatCode($numberFormat);

            //Highlight
            $this->excel->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleHighlight);
            $this->excel->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleHighlight);
            $this->excel->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleHighlight);

            $i++;
        }

        // $this->excel->setActiveSheetIndex(0)
        //     ->setCellValue('A' . $i, 'Tổng cộng')
        //     ->setCellValue('G' . $i, '=SUM(G2:G' . ($i -1) . ')');
        //     // ->setCellValue('AC' . $i, '=SUM(AC2:AC' . ($i -1) . ')')
        //     // ->setCellValue('AD' . $i, '=SUM(AD2:AD' . ($i -1) . ')');
        // $this->excel->setActiveSheetIndex(0)->mergeCells('A' . $i . ':' . 'F' . $i);

        // $this->excel->getActiveSheet()->getStyle("G$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);
        // $this->excel->getActiveSheet()->getStyle("AC$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);
        // $this->excel->getActiveSheet()->getStyle("AD$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);

        //Total
        // $styleTotal = array(
        //     'font' => array(
        //         'bold' => true,
        //         'color' => array('rgb' => 'FF0000'),
        //     ),
        // );
        // $this->excel->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleTotal);
        // $this->excel->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleTotal);
        // $this->excel->getActiveSheet()->getStyle('AB' . $i)->applyFromArray($styleTotal);
        // $this->excel->getActiveSheet()->getStyle('AC' . $i)->applyFromArray($styleTotal);
        // $this->excel->getActiveSheet()->getStyle('AD' . $i)->applyFromArray($styleTotal);

        //Alignment
        // $this->excel->getActiveSheet()->getStyle('AA' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
        // $this->excel->getActiveSheet()->getStyle('AB' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
        // $this->excel->getActiveSheet()->getStyle('AC' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
        // $this->excel->getActiveSheet()->getStyle('AD' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);

        $this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . ($i - 1))->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                    )
                )
            )
        );

        $filename = 'Danh-sach-cong-no-khach-hang_' . date('Y-m-d_H-i-s') . '.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->setPreCalculateFormulas(true);
        $objWriter->save('php://output');
    }

    function admin_index() {
        $this->_initialize_admin();
        $this->_validate_access_role();
		// $str = '16:16:48 21/02/2019';
		// $date = convert_str_to_date($str);
		// echo $date;
		// echo "<br>" . date('H:i:s d/m/Y', $date);
		// die;

        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap4-dialog/css',
            'name' => 'bootstrap-dialog',
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap4-dialog/js',
            'name' => 'bootstrap-dialog',
        );
        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'customers',
            'name' => 'admin-items'
        );
        $this->set_modules();

        $get = $this->input->get();
        $this->_data['get'] = $get;
        $allow_method = array(
            'full_name',
            'address',
            'phone',
        );

        $args = $this->default_args();
        /*if(!(isset($this->_data['role']) && in_array($this->_data['role'], array('ADMIN')))){
            $args['created_by'] = $this->_data['userid'];
        }*/
        if (isset($get['q']) && trim($get['q']) != '') {
            $args['q'] = $get['q'];
        }

        $total = $this->counts($args);
        $perpage = isset($get['per_page']) ? (int) $get['per_page'] : 10;
        $segment = 2;
        // echo $total; die;

        $this->load->library('pagination');
        $config['total_rows'] = $total;
        $config['per_page'] = $perpage;
        $config['full_tag_open'] = '<ul class="pagination no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';

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
        $this->_data['pagination'] = $pagination;

        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment); # Lấy offset
        $this->_data['current_page'] = (int) $offset;
        $rows = $this->M_customers->gets($args, $perpage, $offset);
        if(is_array($rows) && !empty($rows)){
            foreach ($rows as $key => $value) {
                $customer_id = $value['id'];
                $rows[$key]['amount'] = modules::run('output_voucher/get_amount_by_customer', $customer_id);

                $paid = 0;
                $pays = modules::run('pay/gets', array('customer_id' => $customer_id));
                if(is_array($pays) && !empty($pays)){
                    $paid = array_sum(array_column($pays, 'amount'));
                }

                $output_voucher_pay_by_customer = modules::run('output_voucher/get_pay_by_customer', $customer_id);
                $rows[$key]['arrears'] = $output_voucher_pay_by_customer['remainder'] - $paid;
            }
        }
        $this->_data['rows'] = $rows;
        
        $this->_data['breadcrumbs_module_func'] = 'Danh sách khách hàng';
        $this->_data['title'] = 'Danh sách khách hàng';
        $this->_data['main_content'] = 'customers/view_page_index';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_trash() {
		$this->_initialize_admin();
        $this->_validate_access_role();

        $this->_data['breadcrumbs_module_name'] = 'Thùng rác';
        $this->_module_slug = 'thung-rac/khach-hang';
        $this->_data['module_slug'] = $this->_module_slug;

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
            'folder' => 'customers',
            'name' => 'admin-items-trash'
        );
        $this->set_modules();

        $get = $this->input->get();
        $this->_data['get'] = $get;
        $allow_method = array(
            'full_name',
            'email',
            'phone',
        );

        $args = $this->default_args();
        $args['deleted'] = 1;

        $args['role'] = 'CUSTOMER';
        if (isset($get['method']) && trim($get['q']) != '') {
            if ((trim($get['method']) != "") && in_array($get['method'], $allow_method)) {
                $args[$get['method']] = $get['q'];
            } else {
                foreach ($allow_method as $value) {
                    $args[$value] = $get['q'];
                }
            }
        }
        $total = $this->counts($args);
        $perpage = 10; // isset($get['per_page']) ? $get['per_page'] : $this->config->item('per_page');
        $segment = 2;

        $this->load->library('pagination'); # Tải bộ thư viện Pagination Class của CodeIgniter
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
            $config['base_url'] = base_url('customers');
            $config['suffix'] = '?' . http_build_query($get, '', "&");
            $config['first_url'] = base_url('customers' . '?' . http_build_query($get, '', "&"));
            $config['uri_segment'] = $segment;
        } else {
            $config['base_url'] = base_url('customers');
            $config['uri_segment'] = $segment;
        }

        $this->pagination->initialize($config);  # Khởi tạo phân trang

        $pagination = $this->pagination->create_links(); # Tạo link phân trang
        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment); # Lấy offset
        $this->_data['rows'] = $this->M_customers->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;

        $this->_data['breadcrumbs_module_func'] = 'Danh sách khách hàng';
        $this->_data['title'] = 'Danh sách khách hàng';
        $this->_data['main_content'] = 'customers/view_page_trash';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_delete() {
        $this->_initialize_admin();
        $this->_validate_access_role();
        $this->_message_success = 'Đã xóa khách hàng!';
        $this->_message_warning = 'Khách hàng này không tồn tại!';
        $id = (int) $this->input->get('id');
        $row = $this->get($id);
        if ($id != 0 && !empty($row)) {
            $user_id = (int) $this->_data['userid'];
            if(!($this->is_owned($user_id, $id) || $this->is_admin())){
                redirect(base_url($this->_module_slug));
            }
            $output_voucher = modules::run('output_voucher/gets', array('customer_id' => $id));
            if(is_array($output_voucher) && !empty($output_voucher)){
                $notify_type = 'danger';
                $notify_content = "Khách hàng này đang có đơn hàng nên không được xóa!";
                $this->set_notify_admin($notify_type, $notify_content);
                redirect(base_url($this->_module_slug));
            }
            if ($this->M_customers->delete($id)) {
                add_activities(array(
                    'action' => NULL,
                    'activity' => "Người dùng xóa khách hàng #ID: $id",
                    'data' => serialize(array('old' => $row, 'new' => NULL)),
                ));

                $notify_type = 'success';
                $notify_content = $this->_message_success;
            } else {
                $notify_type = 'danger';
                $notify_content = $this->_message_danger;
            }
        } else {
            $notify_type = 'warning';
            $notify_content = $this->_message_warning;
        }
        $this->set_notify_admin($notify_type, $notify_content);
        redirect(base_url($this->_module_slug));
    }

    function admin_delete_trash() {
        $this->_initialize_admin();
        $this->_validate_access_role();

        $this->_data['breadcrumbs_module_name'] = 'Thùng rác';
        $this->_module_slug = 'thung-rac/khach-hang';
        $this->_data['module_slug'] = $this->_module_slug;

        $this->_message_success = 'Đã xóa khách hàng!';
        $this->_message_warning = 'Khách hàng này không tồn tại!';
        $id = (int) $this->input->get('id');
        if ($id != 0) {
            if ($this->M_customers->delete($id)) {
                $notify_type = 'success';
                $notify_content = $this->_message_success;
            } else {
                $notify_type = 'danger';
                $notify_content = $this->_message_danger;
            }
        } else {
            $notify_type = 'warning';
            $notify_content = $this->_message_warning;
        }
        $this->set_notify_admin($notify_type, $notify_content);
        redirect(base_url($this->_module_slug));
    }

    function admin_content() {
		$this->_initialize_admin();
        $this->_validate_access_role();
		$this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker'
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

		$this->_vendor_css_admin[] = array(
            'folder' => 'pickers/pickadate',
            'name' => 'pickadate'
        );
		$this->_vendor_script_admin[] = array(
            'folder' => 'pickers/pickadate',
            'name' => 'picker'
        );
		$this->_vendor_script_admin[] = array(
            'folder' => 'pickers/pickadate',
            'name' => 'picker.date'
        );
		$this->_vendor_script_admin[] = array(
            'folder' => 'pickers/pickadate',
            'name' => 'legacy'
        );

        $this->set_plugins_admin();
        $this->set_vendor_admin();

        $post = $this->input->post();
        if (!empty($post)) {
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('full_name', 'Khách hàng', 'trim|required');

            if ($this->form_validation->run($this)) {
                if ($this->input->post('id')) {
                    $err = FALSE;
                    $id = $this->input->post('id');
                    $row_old = $this->get($id);
                    if (!$this->admin_update($id)) {
                        $err = TRUE;
                    }

                    if ($err === FALSE) {
                        $row_new = $this->get($id);
                        add_activities(array(
                            'action' => NULL,
                            'activity' => "Người dùng cập nhật khách hàng #ID: $id",
                            'data' => serialize(array('old' => $row_old, 'new' => $row_new)),
                        ));

                        $current_page = $this->input->post('current_page');
                        $notify_type = 'success';
                        $notify_content = 'Cập nhật khách hàng thành công!';
                        $this->set_notify_admin($notify_type, $notify_content);
                        redirect(base_url((isset($current_page) && $current_page > 0) ? ($this->_module_slug . '/' . $current_page) : $this->_module_slug));
                    } else {
                        $notify_type = 'danger';
                        $notify_content = 'Có lỗi xảy ra!';
                        $this->set_notify_admin($notify_type, $notify_content);
                    }
                } else {
                    $err = FALSE;
                    $insert_id = $this->admin_add();
                    if ($insert_id == 0) {
                        $err = TRUE;
                    }

                    if ($err === FALSE) {
                        $row_new = $this->get($insert_id);
                        add_activities(array(
                            'action' => NULL,
                            'activity' => "Người dùng thêm khách hàng #ID: $insert_id",
                            'data' => serialize(array('old' => NULL, 'new' => $row_new)),
                        ));

                        $notify_type = 'success';
                        $notify_content = 'Khách hàng đã được thêm!';
                        $this->set_notify_admin($notify_type, $notify_content);
                        redirect(base_url($this->_module_slug));
                    } else {
                        $notify_type = 'danger';
                        $notify_content = 'Có lỗi xảy ra!';
                        $this->set_notify_admin($notify_type, $notify_content);
                    }
                }
            }
        }

        $title = 'Thêm khách hàng - ' . $this->_data['breadcrumbs_module_name']; // . ' - ' . $this->_data['title'];
        $user_id = (int) $this->_data['userid'];
        $segment = 3;
        $id = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
        if($id > 0){
            if(!($this->is_owned($user_id, $id) || $this->is_admin())){
                redirect($this->_module_slug);
            }
        }
        $row = $this->get($id);
        if (is_array($row) && !empty($row)) {
            $this->_data['current_page'] = (int) $this->input->get('current_page');
            $this->_data['row'] = $row;
            $title = 'Cập nhật khách hàng - ' . $this->_data['breadcrumbs_module_name']; // . ' - ' . $this->_data['title'];
        }
        $this->_data['type_of_customer'] = modules::run('customers/type_of_customer/gets');

        $this->_data['title'] = $title . ' - ' . $this->_data['title'];;
        $this->_data['main_content'] = 'customers/view_page_content';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_view() {
		$this->_initialize_admin();
        $this->_validate_access_role();
        $this->_plugins_css_admin[] = array(
            'folder' => 'chosen',
            'name' => 'chosen'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'chosen',
            'name' => 'chosen.jquery'
        );
        $this->set_plugins_admin();

        $user_id = (int) $this->_data['userid'];
        $segment = 3;
        $id = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
        if ($id <= 0) {
            show_404();
        }
        if(!($this->is_owned($user_id, $id) || $this->is_admin())){
            redirect($this->_module_slug);
        }
        $row = $this->get($id);
        if (!(is_array($row) && !empty($row))) {
            redirect($this->_module_slug);
        }
        $this->_data['row'] = $row;
        $this->_data['customer_types'] = modules::run('customer_types/gets');
		$this->_data['type_of_customer'] = modules::run('customers/type_of_customer/gets');

        $this->_data['title'] = 'Xem khách hàng - ' . $this->_data['breadcrumbs_module_name'];
        $this->_data['main_content'] = 'customers/view_page_view';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function ajax_admin_add() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $full_name = $this->input->post('full_name');
        $customer_code = $this->input->post('customer_code');
        $this->create_barcode_image($customer_code, 0, $full_name);
        $data = array(
            'full_name' => $full_name,
            'company' => $this->input->post('company'),
            'customer_types_id' => 0,//$this->input->post('customer_types_id') ? $this->input->post('customer_types_id') : 0,
            'customer_type' => $this->input->post('customer_type') ? $this->input->post('customer_type') : 'KL',
            'customer_code' => $customer_code,
            'discount' => $this->input->post('discount'),
            'area' => $this->input->post('area'),
            'city' => $this->input->post('city'),
            'address' => $this->input->post('address'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'note' => $this->input->post('note'),
            'active' => $this->input->post('active') ? 1 : 0,
            'add_time' => time(),
            'edit_time' => 0
        );

        $message = array();

		$id = $this->M_customers->add($data);
        if ($id != 0) {
            $customers = $this->gets(array('deleted' => 0));

            $message['status'] = 'success';
            $message['content'] = $this->load->view('layout/site/partial/customer', array('customers' => $customers, 'id' => $id), true);
            $message['message'] = '';
        } else {
            $message['status'] = 'error';
            $message['content'] = null;
            $message['message'] = '';
        }

        echo json_encode($message);
    }

    function admin_add() {
        $full_name = $this->input->post('full_name');
        $customer_code = $this->input->post('customer_code');
        $this->create_barcode_image($customer_code, 0, $full_name);
        $birthday = $this->input->post('birthday');
        $data = array(
            'created_by' => $this->_data['userid'],
            'full_name' => $full_name,
            'company' => $this->input->post('company'),
            'id_type_of_customer' => $this->input->post('id_type_of_customer'),
            'taxcode' => $this->input->post('taxcode'),
            'id_card' => $this->input->post('id_card'),
            'customer_code' => $customer_code,
            'area' => $this->input->post('area'),
			'city' => $this->input->post('city'),
            'address' => $this->input->post('address'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'birthday' => (trim($birthday) != '') ? get_current_date($birthday) : 0,
            'gender' => $this->input->post('gender'),
            'note' => $this->input->post('note'),
            'active' => $this->input->post('active') ? 1 : 0,
            'created' => time(),
            'modified' => 0
        );

        return $this->M_customers->add($data);
    }

    function admin_update($id) {
        $full_name = $this->input->post('full_name');
        $customer_code = $this->input->post('customer_code');
        $this->create_barcode_image($customer_code, $id, $full_name);
        $birthday = $this->input->post('birthday');
        $data = array(
            'full_name' => $full_name,
            'company' => $this->input->post('company'),
            'id_type_of_customer' => $this->input->post('id_type_of_customer'),
            'taxcode' => $this->input->post('taxcode'),
            'id_card' => $this->input->post('id_card'),
            'customer_code' => $customer_code,
            'area' => $this->input->post('area'),
			'city' => $this->input->post('city'),
            'address' => $this->input->post('address'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'birthday' => (trim($birthday) != '') ? get_current_date($birthday) : 0,
            'gender' => $this->input->post('gender'),
            'note' => $this->input->post('note'),
            'active' => $this->input->post('active') ? 1 : 0,
            'modified' => time()
        );

        return $this->M_customers->update($id, $data);
    }

    function admin_main() {
        $this->_initialize_admin();
        $this->_validate_access_role();

        $post = $this->input->post();
        if (!empty($post)) {
            $action = $this->input->post('action');
            if ($action == 'delete') {
                $this->_message_success = 'Đã xóa các khách hàng được chọn!';
                $this->_message_warning = 'Bạn chưa chọn khách hàng nào!';
                $ids = $this->input->post('idcheck');

                if (is_array($ids) && !empty($ids)) {
                    $user_id = (int) $this->_data['userid'];
                    $is_admin = $this->is_admin();
                    foreach ($ids as $id) {
                        if(!($this->is_owned($user_id, $id) || $is_admin)){
                            redirect(base_url($this->_module_slug));
                        }
                        $output_voucher = modules::run('output_voucher/gets', array('customer_id' => $id));
                        if(is_array($output_voucher) && !empty($output_voucher)){
                            $notify_type = 'danger';
                            $notify_content = "Khách hàng này đang có đơn hàng nên không được xóa!";
                            $this->set_notify_admin($notify_type, $notify_content);
                            redirect(base_url($this->_module_slug));
                        }
                        if ($this->M_customers->delete($id)) {
                            $notify_type = 'success';
                            $notify_content = $this->_message_success;
                        } else {
                            $notify_type = 'danger';
                            $notify_content = $this->_message_danger;
                        }
                    }
                    add_activity("Người dùng xóa các khách hàng #ID: " . implode(', ', $ids));
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

    function download(){
        $this->load->helper('download');
        $file = $this->input->get('file');
        $data = file_get_contents(base_url($this->_path . $file));
        force_download($file, $data);
    }

    function create_barcode_image($barcode_text = '', $id = 0, $text = '') {
        $barcode_args = array(
            'text' => $barcode_text,
            'codetype' => 'code128',
            'orientation' => 'horizontal',
            'size' => '20',
            'print'=> 'true',
            'name'=> $text,
        );
        $barcode_url = site_url('barcode') . '?' . http_build_query($barcode_args, '', "&");
        $barcode_src = $this->_path . $barcode_text . '.png';
        save_image_from_url($barcode_url, $barcode_src);
        if($id != 0){
            $row = $this->get($id);
            if(isset($row['customer_code']) && trim($row['customer_code']) != ''){
                @unlink(FCPATH . $this->_path . $row['customer_code']);
            }
        }
        return $barcode_url;
    }
}
/* End of file Customers.php */
/* Location: ./application/modules/customers/controllers/Customers.php */