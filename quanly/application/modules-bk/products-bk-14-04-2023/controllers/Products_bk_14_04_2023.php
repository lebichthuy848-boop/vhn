<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Products extends Layout {

	private $_module_slug = 'san-pham';
	public $_path = '';

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->_path = get_module_path('products');
		$this->_data['breadcrumbs_module_name'] = 'Sản phẩm';
		$this->_data['module_slug'] = $this->_module_slug;
		$_breadcrumbs_admin[] = array(
			'url' => '',
			'name' => 'Sản phẩm',
			'image' => base_url('assets/Frest/app-assets/images/svg/ico/ico-product.svg'),
		);
		$this->_data['breadcrumbs_admin'] = $_breadcrumbs_admin;
	}

	private function _validate_access_role() {
		$this->validate_access_role('ROLE_GROUP_PRODUCT');
	}

	function default_args() {
		$order_by = array(
			'order' => 'DESC',
			'modified' => 'DESC',
			'name' => 'ASC',
		);
		$args = array();
		$args['order_by'] = $order_by;

		return $args;
	}

	function get($id) {
		return $this->M_products->get($id);
	}

	function counts($options = array()) {
		$default_args = $this->default_args();
		if (is_array($options) && !empty($options)) {
			$args = array_merge($default_args, $options);
		} else {
			$args = $default_args;
		}
		return $this->M_products->counts($args);
	}

	function gets($options = array()) {
		$default_args = $this->default_args();
		if (is_array($options) && !empty($options)) {
			$args = array_merge($default_args, $options);
		} else {
			$args = $default_args;
		}
		return $this->M_products->gets($args);
	}

	function get_max_order() {
		$args = $this->default_args();
		$order_by = array(
			'order' => 'DESC',
		);
		$args['order_by'] = $order_by;
		$perpage = 1;
		$offset = 0;
		$rows = $this->M_products->gets($args, $perpage, $offset);
		$max_order = isset($rows[0]['order']) ? $rows[0]['order'] : 0;

		return (int) $max_order;
	}

	function re_order() {
		$order_by = array(
			'order' => 'ASC',
		);
		$args['order_by'] = $order_by;
		$rows = $this->gets($args);
		if (is_array($rows) && !empty($rows)) {
			$i = 0;
			foreach ($rows as $value) {
				$i++;
				$data = array(
					'order' => $i,
				);
				$this->M_products->update($value['id'], $data);
			}
		}
	}

	function download(){
		$this->load->helper('download');
		$file = rawurldecode($this->input->get('file'));
		$data = file_get_contents($file);
		$file_name = basename($file);
		force_download($file_name, $data);
	}

	function get_current_quantity($id = 0, $warehouse_id = 0) {
		$total_quantity_purchase_voucher_import_warehouse = $total_quantity_purchase_voucher_transaction_warehouse_subtraction = $total_quantity_purchase_voucher_transaction_warehouse_addition = 0;

		$args_purchase_voucher_import_details = array(
			'product_id' => $id,
			'type' => 'import',
		);
    	if ($warehouse_id != 0) {
			$args_purchase_voucher_import_details['warehouse_id'] = $warehouse_id;
		}
    	$products_purchase_voucher_import_details = $this->M_purchase_voucher_details->gets($args_purchase_voucher_import_details);
    	if(is_array($products_purchase_voucher_import_details) && !empty($products_purchase_voucher_import_details)){
    		$total_quantity_purchase_voucher_import_warehouse = array_sum(array_column($products_purchase_voucher_import_details, 'quantity'));
    	}

    	$args_purchase_voucher_transaction_subtraction_details = array(
			'product_id' => $id,
			'type' => 'transaction',
		);
    	if ($warehouse_id != 0) {
			$args_purchase_voucher_transaction_subtraction_details['warehouse_id'] = $warehouse_id;
		}
    	$products_purchase_voucher_transaction_subtraction_details = $this->M_purchase_voucher_details->gets($args_purchase_voucher_transaction_subtraction_details);
    	if(is_array($products_purchase_voucher_transaction_subtraction_details) && !empty($products_purchase_voucher_transaction_subtraction_details)){
    		$total_quantity_purchase_voucher_transaction_warehouse_subtraction = array_sum(array_column($products_purchase_voucher_transaction_subtraction_details, 'quantity'));
    	}

    	$args_purchase_voucher_transaction_addition_details = array(
			'product_id' => $id,
			'type' => 'transaction',
		);
    	if ($warehouse_id != 0) {
			$args_purchase_voucher_transaction_addition_details['transaction_warehouse_id'] = $warehouse_id;
		}
    	$products_purchase_voucher_transaction_addition_details = $this->M_purchase_voucher_details->gets($args_purchase_voucher_transaction_addition_details);
    	if(is_array($products_purchase_voucher_transaction_addition_details) && !empty($products_purchase_voucher_transaction_addition_details)){
    		$total_quantity_purchase_voucher_transaction_warehouse_addition = array_sum(array_column($products_purchase_voucher_transaction_addition_details, 'quantity'));
    	}

    	$total_quantity_purchase_voucher = $total_quantity_purchase_voucher_import_warehouse - $total_quantity_purchase_voucher_transaction_warehouse_subtraction + $total_quantity_purchase_voucher_transaction_warehouse_addition;

    	$args_output_voucher_details = array(
			'product_id' => $id,
		);
		if ($warehouse_id != 0) {
			$args_output_voucher_details['warehouse_id'] = $warehouse_id;
		}
    	$products_output_voucher_details = $this->M_output_voucher_details->gets($args_output_voucher_details);
    	$total_quantity_output_voucher = 0;
    	if(is_array($products_output_voucher_details) && !empty($products_output_voucher_details)){
    		$total_quantity_output_voucher = array_sum(array_column($products_output_voucher_details, 'quantity'));
    	}

        return $total_quantity_purchase_voucher - $total_quantity_output_voucher;
	}

	function get_statistics($id = 0, $warehouse_id = 0, $options = array()) {
		$total_quantity_purchase_voucher_import_warehouse = $total_quantity_purchase_voucher_transaction_warehouse_subtraction = $total_quantity_purchase_voucher_transaction_warehouse_addition = 0;
		$total_monetized_purchase_voucher_import_warehouse = $total_monetized_purchase_voucher_transaction_warehouse_subtraction = $total_monetized_purchase_voucher_transaction_warehouse_addition = 0;

		$args_purchase_voucher_import_details = array(
			'product_id' => $id,
			'type' => 'import',
		);
    	if ($warehouse_id != 0) {
			$args_purchase_voucher_import_details['warehouse_id'] = $warehouse_id;
		}
    	$products_purchase_voucher_import_details = $this->M_purchase_voucher_details->gets($args_purchase_voucher_import_details);
    	if(is_array($products_purchase_voucher_import_details) && !empty($products_purchase_voucher_import_details)){
    		$total_quantity_purchase_voucher_import_warehouse = array_sum(array_column($products_purchase_voucher_import_details, 'quantity'));
    		$total_monetized_purchase_voucher_import_warehouse = array_sum(array_column($products_purchase_voucher_import_details, 'monetized'));
    	}

    	$args_purchase_voucher_transaction_subtraction_details = array(
			'product_id' => $id,
			'type' => 'transaction',
		);
    	if ($warehouse_id != 0) {
			$args_purchase_voucher_transaction_subtraction_details['warehouse_id'] = $warehouse_id;
		}
		if (isset($options['start_date_start'])) {
			$args_purchase_voucher_transaction_subtraction_details['start_date_start'] = $options['start_date_start'];
		}
		if (isset($options['start_date_end'])) {
			$args_purchase_voucher_transaction_subtraction_details['start_date_end'] = $options['start_date_end'];
		}
    	$products_purchase_voucher_transaction_subtraction_details = $this->M_purchase_voucher_details->gets($args_purchase_voucher_transaction_subtraction_details);
    	if(is_array($products_purchase_voucher_transaction_subtraction_details) && !empty($products_purchase_voucher_transaction_subtraction_details)){
    		$total_quantity_purchase_voucher_transaction_warehouse_subtraction = array_sum(array_column($products_purchase_voucher_transaction_subtraction_details, 'quantity'));
    		$total_monetized_purchase_voucher_transaction_warehouse_subtraction = array_sum(array_column($products_purchase_voucher_transaction_subtraction_details, 'monetized'));
    	}

    	$args_purchase_voucher_transaction_addition_details = array(
			'product_id' => $id,
			'type' => 'transaction',
		);
    	if ($warehouse_id != 0) {
			$args_purchase_voucher_transaction_addition_details['transaction_warehouse_id'] = $warehouse_id;
		}
		if (isset($options['start_date_start'])) {
			$args_purchase_voucher_transaction_addition_details['start_date_start'] = $options['start_date_start'];
		}
		if (isset($options['start_date_end'])) {
			$args_purchase_voucher_transaction_addition_details['start_date_end'] = $options['start_date_end'];
		}
    	$products_purchase_voucher_transaction_addition_details = $this->M_purchase_voucher_details->gets($args_purchase_voucher_transaction_addition_details);
    	if(is_array($products_purchase_voucher_transaction_addition_details) && !empty($products_purchase_voucher_transaction_addition_details)){
    		$total_quantity_purchase_voucher_transaction_warehouse_addition = array_sum(array_column($products_purchase_voucher_transaction_addition_details, 'quantity'));
    		$total_monetized_purchase_voucher_transaction_warehouse_addition = array_sum(array_column($products_purchase_voucher_transaction_addition_details, 'monetized'));
    	}

    	$total_quantity_purchase_voucher = $total_quantity_purchase_voucher_import_warehouse - $total_quantity_purchase_voucher_transaction_warehouse_subtraction + $total_quantity_purchase_voucher_transaction_warehouse_addition;
    	$total_monetized_purchase_voucher = $total_monetized_purchase_voucher_import_warehouse - $total_monetized_purchase_voucher_transaction_warehouse_subtraction + $total_monetized_purchase_voucher_transaction_warehouse_addition;

    	$args_output_voucher_details = array(
			'product_id' => $id,
		);
		if ($warehouse_id != 0) {
			$args_output_voucher_details['warehouse_id'] = $warehouse_id;
		}
		if (isset($options['start_date_start'])) {
			$args_output_voucher_details['start_date_start'] = $options['start_date_start'];
		}
		if (isset($options['start_date_end'])) {
			$args_output_voucher_details['start_date_end'] = $options['start_date_end'];
		}
    	$products_output_voucher_details = $this->M_output_voucher_details->gets($args_output_voucher_details);
    	$total_quantity_output_voucher_retail = 0;
    	$total_quantity_output_voucher_cost = 0;
    	$total_monetized_output_voucher_retail = 0;
    	$total_monetized_output_voucher_cost = 0;
    	if(is_array($products_output_voucher_details) && !empty($products_output_voucher_details)){
    		foreach ($products_output_voucher_details as $value) {
    			if($value['price_type'] == 'cost_price'){
    				$total_quantity_output_voucher_cost += $value['quantity'];
    				$total_monetized_output_voucher_cost += $value['monetized'];
	    		}else{
	    			$total_quantity_output_voucher_retail += $value['quantity'];
	    			$total_monetized_output_voucher_retail += $value['monetized'];
	    		}
    		}
    	}

        return array(
        	'import' => $total_quantity_purchase_voucher,
        	'import_monetized' => $total_monetized_purchase_voucher,
        	'export_retail' => $total_quantity_output_voucher_retail,
        	'export_cost' => $total_quantity_output_voucher_cost,
        	'export_retail_monetized' => $total_monetized_output_voucher_retail,
        	'export_cost_monetized' => $total_monetized_output_voucher_cost,
        	'inventory' => $total_quantity_purchase_voucher - ($total_quantity_output_voucher_cost + $total_quantity_output_voucher_retail)
        );
	}

	function check_quantity_availablity() {
		$post = $this->input->post();
		$this->_message_success = 'true';
		$this->_message_danger = 'false';

		if (!empty($post)) {
			$output_voucher_id = (int) $this->input->post('id');
			$product_id = (int) $this->input->post('product_id');
			//$warehouse_id = (int) $this->input->post('warehouse_id');
			$warehouse_id = 0;
			$quantity = (int) $this->input->post('quantity');
			$total = (int) ($this->get_current_quantity($product_id, $warehouse_id));

			if ($output_voucher_id != 0) {
				$data_output_voucher_detail = $this->M_output_voucher_details->get_by(
					array(
						'output_voucher_id' => $output_voucher_id,
						'product_id' => $product_id,
						//'warehouse_id' => $warehouse_id,
					)
				);
				if (isset($data_output_voucher_detail['quantity'])) {
					$total += (int) $data_output_voucher_detail['quantity'];
				}
			}
			$inventory = $total - $quantity;

			if ($this->input->post('ajax') == '1') {
				if ($inventory >= 0) {
					$this->_status = "success";
					$this->_message = $this->_message_success;
					$this->_content = array(
						'total' => $total,
						'inventory' => $inventory,
					);
				} else {
					$row = $this->get($product_id);
					$this->_status = "danger";
					$this->_message = $this->_message_danger;
					$this->_content = isset($row) ? $row : NULL;
				}

				$this->set_json_encode();
				$this->load->view('layout/json_data', $this->_data);
			} else {
				if ($inventory >= 0) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
		} else {
			redirect(base_url());
		}
	}

	function ajax_check_quantity_availablity() {
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
			$warehouse_id = (int) $this->input->post('warehouse_id');
			$quantity = (int) $this->input->post('quantity');
			$quantity_availablity = $this->get_current_quantity($id, $warehouse_id);

			if ($quantity_availablity >= $quantity) {
				$message['status'] = 'success';
				$message['content'] = $quantity_availablity;
				$message['message'] = 'Tải dữ liệu thành công!';
			} else {
				$message['status'] = 'danger';
				$message['content'] = null;
				$message['message'] = 'Số lượng vượt quá trong kho! Vui lòng kiểm tra lại!';
			}
		}
		echo json_encode($message);
		exit();
	}

	function check_code_availablity() {
		$post = $this->input->post();
		$this->_message_success = 'true';
		$this->_message_danger = 'false';

		if (!empty($post)) {
			$code = $this->input->post('code');
			$id = $this->input->post('id');
			if ($this->input->post('ajax') == '1') {
				if ($this->M_products->check_code_availablity($code, $id)) {
					$this->_status = "success";
					$this->_message = $this->_message_success;
				} else {
					$this->_status = "danger";
					$this->_message = $this->_message_danger;
				}

				$this->set_json_encode();
				$this->load->view('layout/json_data', $this->_data);
			} else {
				if ($this->M_products->check_code_availablity($code, $id)) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
		} else {
			redirect(base_url());
		}
	}

	function check_barcode_availablity() {
		$post = $this->input->post();
		$this->_message_success = 'true';
		$this->_message_danger = 'false';

		if (!empty($post)) {
			$barcode = $this->input->post('barcode');
			$id = $this->input->post('id');
			if ($this->input->post('ajax') == '1') {
				if ($this->M_products->check_barcode_availablity($barcode, $id)) {
					$this->_status = "success";
					$this->_message = $this->_message_success;
				} else {
					$this->_status = "danger";
					$this->_message = $this->_message_danger;
				}

				$this->set_json_encode();
				$this->load->view('layout/json_data', $this->_data);
			} else {
				if ($this->M_products->check_barcode_availablity($barcode, $id)) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
		} else {
			redirect(base_url());
		}
	}

	function ajax_admin_gets() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$message = array();
		$message['status'] = 'warning';
		$message['content'] = null;
		$message['message'] = 'Kiểm tra thông tin';

		$post = $this->input->post();
		if (!empty($post)) {
			$in_id = explode(',', $this->input->post('ids'));
			$data = $this->gets(array('in_id' => $in_id));
			$arrears = 0;

			$customer_id = (int) $this->input->post('customer_id');
			if ($customer_id != 0) {
				$customer = modules::run('customers/get', $customer_id);
				if (is_array($customer) && !empty($customer) && isset($customer['customer_type'])) {
					$customer['type'] = get_value_array($this->config->item('customer_type'), isset($customer['customer_type']) ? $customer['customer_type'] : 'KL');
					//tính nợ
					$paid = 0;
					$pays = modules::run('pay/gets', array('customer_id' => $customer_id));
					if(is_array($pays) && !empty($pays)){
					    $paid = array_sum(array_column($pays, 'amount'));
					}
					$output_voucher_pay_by_customer = modules::run('output_voucher/get_pay_by_customer', $customer_id);
					$arrears = $output_voucher_pay_by_customer['remainder'] - $paid;
				}
			}

			if (isset($customer) && is_array($customer) && !empty($customer)) {
				if (is_array($data) && !empty($data)) {
					foreach ($data as $key => $value) {
						$data[$key]['price'] = (isset($customer['customer_type']) && isset($value[get_value_array($this->config->item('customer_calculator'), $customer['customer_type'])])) ? $value[get_value_array($this->config->item('customer_calculator'), $customer['customer_type'])] : $value['retail_price'];
					}
				}
				$message['status'] = 'success';
				$message['content'] = array('data' => $data, 'customer' => (isset($customer) ? $customer : NULL), 'arrears' => $arrears);
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

			$price_type = 'retail_price';//$this->input->post('price_type');
			if(!in_array($price_type, array('retail_price', 'cost_price'))){
				//$price_type = 'unit_price';
			}

			if (is_array($data) && !empty($data)) {
				$in_warehouse_id = array(-1);
				$products_purchase_voucher_details = $this->M_purchase_voucher_details->gets(array(
					'product_id' => $id,
				));
				if (is_array($products_purchase_voucher_details) && !empty($products_purchase_voucher_details)) {
					$in_warehouse_id = array_unique(array_merge(array_column($products_purchase_voucher_details, 'warehouse_id'), array_column($products_purchase_voucher_details, 'transaction_warehouse_id')));
				}

				$warehouse = modules::run('purchase_voucher/warehouse/gets', array('in_id' => $in_warehouse_id));
				$partial = array();
				$partial['data'] = $warehouse;
				$data['warehouse'] = display_option_select($warehouse, 'id', 'name', 0);
				$data['warehouse_in_id'] = $in_warehouse_id;

				$data['price'] = $data[$price_type];
				$data['image'] = get_image(get_module_path('products') . $data['image'], get_module_path('products') . 'no-image-icon.png');
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

	public function decode_quantity($str_quantity = ''){
		$data = array();
		$arr_quantity = explode(" ", $str_quantity);
		if(is_array($arr_quantity) && !empty($arr_quantity)){
			foreach ($arr_quantity as $value) {
				$warehouse_quantity = explode("|", $value);
				if(isset($warehouse_quantity[0]) && isset($warehouse_quantity[1])){
					$data[] = array(
						'warehouse' => (int) $warehouse_quantity[0],
						'quantity' => (int) $warehouse_quantity[1]
					);
				}
			}
		}
		return $data;
	}

	function admin_export_excel() {
		$this->_initialize_admin();
		$this->_validate_access_role();
		$is_admin = false;
		if(isset($this->_data['role']) && in_array($this->_data['role'], array('ADMIN'))){
			$is_admin = true;
		}
		$this->load->library('excel');
		/*
			          $this->excel->setActiveSheetIndex(0);
			          $this->excel->getActiveSheet()->setTitle('test worksheet');
			          $this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');
			          $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
			          $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			          $this->excel->getActiveSheet()->mergeCells('A1:D1');
			          $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			         *
		*/

		$this->excel->getProperties()->setCreator("Admin")
			->setLastModifiedBy("Admin")
			->setTitle("Danh sách sản phẩm")
			->setSubject("Danh sách sản phẩm")
			->setDescription("Quản lý danh sách sản phẩm")
			->setKeywords("Quản lý danh sách sản phẩm")
			->setCategory("Sản phẩm");
		$this->excel->getActiveSheet()->setTitle('Danh sách sản phẩm');

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('A1', 'STT')
			->setCellValue('B1', 'ID')
			->setCellValue('C1', 'Tên sản phẩm')
			->setCellValue('D1', 'Mã sản phẩm')
			->setCellValue('E1', 'Loại sản phẩm')
			->setCellValue('F1', 'Quy cách')
			->setCellValue('G1', 'ĐVT')
			->setCellValue('H1', 'Số lượng');
		if($is_admin){
			$this->excel->setActiveSheetIndex(0)
				->setCellValue('I1', 'Giá nhập')
				->setCellValue('J1', 'Giá bán lẻ')
				->setCellValue('K1', 'Giá bán sỉ')
				->setCellValue('L1', 'Ngày cập nhật');
		}else{
			$this->excel->setActiveSheetIndex(0)
				->setCellValue('I1', 'Ngày cập nhật');
		}
		$args = $this->default_args();
		$args['deleted'] = 0;
		$rows = $this->M_products->gets($args);
		$i = 2;
		$order = 0;

		$warehouses = modules::run('purchase_voucher/warehouse/gets');
		foreach ($rows as $row) {
			$order++;
			$arr_quantity = array();
			$str_quantity = '';
			if(is_array($warehouses) && !empty($warehouses)){
				foreach ($warehouses as $warehouse) {
					$warehouse_id = $warehouse['id'];
					$statistics = $this->get_statistics($row['id'], $warehouse_id);
					$quantity = $statistics['import'];
					if($quantity > 0){
						$arr_quantity[] .= $warehouse_id . '|' . $quantity;
					}
				}
			}
			if(is_array($arr_quantity) && !empty($arr_quantity)){
				$str_quantity = implode(" ", $arr_quantity);
			}
			$this->excel->setActiveSheetIndex(0)
				->setCellValue('A' . $i, $order)
				->setCellValue('B' . $i, $row['id'])
				->setCellValue('C' . $i, $row['name'])
				->setCellValue('D' . $i, $row['code'])
				->setCellValue('E' . $i, $row['category_name'])
				->setCellValue('F' . $i, $row['specification'])
				->setCellValue('G' . $i, $row['unit'])
				->setCellValue('H' . $i, $str_quantity);
			if($is_admin){
				$this->excel->setActiveSheetIndex(0)
					->setCellValue('I' . $i, $row['unit_price'])
					->setCellValue('J' . $i, $row['retail_price'])
					->setCellValue('K' . $i, $row['cost_price'])
					->setCellValue('L' . $i, ($row['modified'] > 0 ? display_date($row['modified'], true) :  display_date($row['created'], true)));
			}else{
				$this->excel->setActiveSheetIndex(0)
					->setCellValue('I' . $i, ($row['modified'] > 0 ? display_date($row['modified'], true) : display_date($row['created'], true)));
			}
			$i++;
		}

		$filename = 'Danh-sach-san-pham_' . date('Y-m-d_H-i-s') . '.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save('php://output');
	}

	function ajax_admin_export_excel() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$message = array();
		$message['status'] = 'warning';
		$message['content'] = null;
		$message['message'] = 'Kiểm tra thông tin';

		$post = $this->input->post();
		if (!empty($post)) {
			$customer_id = (int) $this->input->post('customer_id');
			if ($customer_id != 0) {
				$customer = modules::run('customers/get', $customer_id);
			}
			if (isset($customer) && is_array($customer) && !empty($customer)) {
				$args = $this->default_args();
				$args['deleted'] = 0;
				$rows = $this->M_products->gets($args);
				if (is_array($rows) && !empty($rows)) {
					$this->load->library('excel');

					$this->excel->getProperties()->setCreator("Admin")
						->setLastModifiedBy("Admin")
						->setTitle("Báo giá sản phẩm")
						->setSubject("Báo giá sản phẩm")
						->setDescription("Danh sách báo giá sản phẩm")
						->setKeywords("Danh sách báo giá sản phẩm")
						->setCategory("Báo giá");
					$this->excel->getActiveSheet()->setTitle('Bảng báo giá sản phẩm');

					$this->excel->setActiveSheetIndex(0)
						->setCellValue('A1', 'STT')
						->setCellValue('B1', 'Tên')
						->setCellValue('C1', 'ĐVT')
						->setCellValue('D1', 'Giá')
						->setCellValue('E1', 'Quy cách');
					$i = 2;
					$order = 0;
					foreach ($rows as $row) {
						$order++;
						$price = (isset($customer['customer_type']) && isset($row[get_value_array($this->config->item('customer_calculator'), $customer['customer_type'])])) ? $row[get_value_array($this->config->item('customer_calculator'), $customer['customer_type'])] : $row['retail_price'];
						$this->excel->setActiveSheetIndex(0)
							->setCellValue('A' . $i, $order)
							->setCellValue('B' . $i, $row['name'])
							->setCellValue('C' . $i, $row['unit'])
							->setCellValue('D' . $i, $price)
							->setCellValue('E' . $i, $row['specification']);
						$i++;
					}

					ob_start();
					$filename = 'Bang-bao-gia_' . date('Y-m-d_H-i-s') . '.xls';
					header('Content-Type: application/vnd.ms-excel'); //mime type
					header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
					header('Cache-Control: max-age=0');
					$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
					$objWriter->save('php://output');

					$xlsData = ob_get_contents();
					ob_end_clean();

					$response = array(
						'status' => 'success',
						'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData),
						'file_name' => $filename,
					);

					die(json_encode($response));
				}
			} else {
				$message['status'] = 'danger';
				$message['content'] = null;
				$message['message'] = 'Có lỗi xảy ra! Vui lòng kiểm tra lại!';
				echo json_encode($message);
				exit();
			}
		} else {
			echo json_encode($message);
			exit();
		}
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

	function admin_import_excel() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$this->_plugins_css_admin[] = array(
			'folder' => 'bootstrap-fileinput/css',
			'name' => 'fileinput',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'bootstrap-fileinput/js',
			'name' => 'fileinput.min',
		);

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
		$this->_plugins_script_admin[] = array(
			'folder' => 'bootstrap-datepicker',
			'name' => 'app.editinfo',
		);

		$this->set_plugins_admin();

		$this->_modules_script[] = array(
			'folder' => 'products',
			'name' => 'admin-import',
		);
		$this->set_modules();

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

					/*
					$category = array_unique(array_column($data['values'], 'I'));
					$provider = array_unique(array_column($data['values'], 'K'));
                    echo "<pre>";
                    print_r($category);
                    print_r($data);
                    echo "</pre>";
                    die();
					*/

					$products_purchase_voucher = array();
					$is_error = FALSE;
					if (is_array($data['values']) && !empty($data['values'])) {
						$is_purchase_voucher = $this->input->post('is_purchase_voucher') ? TRUE : FALSE;
						if($is_purchase_voucher){
							$warehouse_id_default = (int)$this->input->post('warehouse_id');
							$provider_id_default = (int)$this->input->post('provider_id');
							$date = $this->input->post('date');
						}

						/*
						$provider = array_unique(array_column($data['values'], 'L'));
						$provider_add = array();
						if (is_array($provider) && !empty($provider)) {
							foreach ($provider as $value) {
								$provider_id = modules::run('provider/add', array(
									'name' => $value,
									'address' => '',
									'phone' => '',
									'email' => '',
									'created' => time(),
									'modified' => 0,
									'order' => modules::run('provider/get_max_order') + 1,
									'status' => 1,
								));
								if ($provider_id != 0) {
									$provider_add[$provider_id] = $value;
								}
							}
						}
						*/

						/*
						$category = array_unique(array_column($data['values'], 'E'));
						$category_add = array();
						if (is_array($category) && !empty($category)) {
							foreach ($category as $value) {
								$category_id = modules::run('category/add', array(
									'name' => $value,
									'created' => time(),
									'modified' => 0,
									'order' => modules::run('category/get_max_order') + 1,
									'status' => 1,
								));
								if ($category_id != 0) {
									$category_add[$category_id] = $value;
								}
							}
						}
						*/

						$this->M_products->truncate();
						$i = 0;
						// echo "<pre>";
						// print_r($data['values']);
						// echo "</pre>";
						// die();
						foreach ($data['values'] as $key => $value) {
							$name = (isset($value['C']) && $value['C'] != NULL) ? trim($value['C']) : '';
							if($name != ''){
								$i++;
								//category
								$category_id = 0;
								if(isset($value['E'])){
									$category_query = $value['E'];
									$category_row = modules::run('category/get_by', array('query' => $category_query));
									if(isset($category_row['id'])){
										$category_id = $category_row['id'];
									}else{
										$category_id = modules::run('category/add', array(
											'name' => $category_query,
											'order' => modules::run('category/get_max_order') + 1,
											'status' => 1,
											'created' => time(),
											'modified' => 0,
										));
									}
								}

								if($is_purchase_voucher){
									//provider
									$provider_id = $provider_id_default;
									/*
									if(isset($value['R'])){
										$provider_query = $value['R'];
										$provider_row = modules::run('provider/get_by', array('query' => $provider_query));
										if(isset($provider_row['id'])){
											$provider_id = $provider_row['id'];
										}else{
											$provider_id = modules::run('provider/add', array(
												'name' => $provider_query,
												'address' => '',
												'phone' => '',
												'email' => '',
												'order' => modules::run('provider/get_max_order') + 1,
												'status' => 1,
												'created' => time(),
												'modified' => 0,
											));
										}
									}
									*/
								}

								$name = (isset($value['C']) && $value['C'] != NULL) ? $value['C'] : '';
								$code = (isset($value['D']) && $value['D'] != NULL) ? $value['D'] : '';
								$data_row = array(
									//'category_id' => isset($value['M']) ? (int) array_search($value['M'], $category_add) : 0,
									'name' => $name,
									'code' => $code,
									'barcode' => $code,
									'category_id' =>  $category_id,
									'unit' => (isset($value['G']) && $value['G'] != NULL) ? $value['G'] : '',
									'origin' => '',
									'specification' => (isset($value['F']) && $value['F'] != NULL) ? $value['F'] : '',
									'quantity' => 0,
									'safety_margin' => 50,
									'unit_price' => isset($value['I']) ? (float) $value['I'] : 0,
									'retail_price' => isset($value['J']) ? (float) $value['J'] : 0,
									'cost_price' => isset($value['K']) ? (float) $value['K'] : 0,
									'note' => '',
									'EXP' => 0,
									'active' => 1,
									'deleted' => 0,
									'deleted_by' => 0,
									'order' => isset($value['A']) ? (int) $value['A'] : $this->get_max_order() + 1,
									'created' => (isset($value['L']) && $value['L'] != NULL) ? convert_str_to_date($value['L']) : time(),
									'modified' => 0,
								);

								if (isset($value['B']) && (int) $value['B'] != 0) {
									$data_row['id'] = (int) $value['B'];
								}
								$product_id = $this->M_products->add($data_row);
								if (!$product_id) {
									$is_error = TRUE;
								}else{
									$this->create_barcode_image($code, 0, $name);
									if($is_purchase_voucher){
										//lay chuoi so luong
										$str_quantity = isset($value['H']) ? $value['H'] : '';
										$arr_quantity = $this->decode_quantity($str_quantity);//danh sach so luong vao array
										if(is_array($arr_quantity) && !empty($arr_quantity)){
											foreach ($arr_quantity as $key_quantity => $value_quantity) {
												$warehouse_id = $value_quantity['warehouse'];
												$quantity = $value_quantity['quantity'];
												if(($warehouse_id != 0 || $warehouse_id_default != 0) && $quantity > 0){
													$products_purchase_voucher[] = array(
														'product_id' => $product_id,
														'warehouse_id' => $warehouse_id_default != 0 ? $warehouse_id_default : $warehouse_id,
														'quantity' => $quantity,
														'quantity_current' => 0,
														'unit_price' => $data_row['unit_price'],
														'unit_price_current' => 0,
														'provider_id' => $provider_id,
													);
												}
											}
										}
									}
								}
							}
						}
					}

					if(!$is_error && is_array($products_purchase_voucher) && !empty($products_purchase_voucher)){
						$warehouses = array_unique(array_column($products_purchase_voucher, 'warehouse_id'));
						if(is_array($warehouses) && !empty($warehouses)){
							$this->M_purchase_voucher->truncate();
							$this->M_purchase_voucher_details->truncate();
							foreach ($warehouses as $warehouse) {
								$data_purchase_voucher = array(
									'date' => (trim($date) != '') ? get_current_date($date) : 0,
									'note' => 'Nhập kho khi nhập sản phẩm',
								);
								$data_purchase_voucher['code'] = modules::run('purchase_voucher/get_code', 0);
								$data_purchase_voucher['admin_id'] = 1;
								$data_purchase_voucher['deleted'] = 0;
								$data_purchase_voucher['deleted_by'] = 0;
								$data_purchase_voucher['created'] = time();
								$data_purchase_voucher['modified'] = 0;
								$purchase_voucher_id = $this->M_purchase_voucher->add($data_purchase_voucher);

								if ($purchase_voucher_id != 0) {
									foreach ($products_purchase_voucher as $value) {
										if($value['warehouse_id'] == $warehouse){
											$data = $value;
											$data['purchase_voucher_id'] = $purchase_voucher_id;
											$data['monetized'] = $value['quantity'] * $data['unit_price'];
											if (!$this->M_purchase_voucher_details->add($data)) {
												$is_error = TRUE;
											}
										}
									}
								} else {
									$is_error = TRUE;
								}
							}
						}
					}

					if (!$is_error) {
						@unlink(FCPATH . $this->_path . $file);

						$notify_type = 'success';
						$notify_content = 'Dữ liệu sản phẩm đã nhập thành công!';
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
		$this->_data['category'] = modules::run('category/gets');
		$this->_data['warehouse'] = modules::run('purchase_voucher/warehouse/gets');
		$this->_data['provider'] = modules::run('provider/gets');

		$this->_data['title'] = 'Nhập dữ liệu sản phẩm - ' . $this->_data['title'];
		$this->_data['main_content'] = 'products/view_page_import';
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
			'folder' => 'products',
			'name' => 'print-barcode',
		);
		$this->_modules_script[] = array(
			'folder' => 'products',
			'name' => 'admin-print-barcode',
		);
		$this->set_modules();

		$args = $this->default_args();
		$args['deleted'] = 0;
		$args['role'] = 'CUSTOMER';
		if (in_array($this->_data['role'], array('SALES', 'AGENCY', 'DISTRIBUTOR', 'WHOLESALER'))) {
			$args['created_by'] = $this->_data['userid'];
		}
		$get = $this->input->get();
		$this->_data['get'] = $get;
		if(isset($get['ids']) && is_array($get['ids']) && !empty($get['ids'])){
			$args['in_id'] = $get['ids'];
		}
		$rows = $this->M_products->gets($args);
		//7c681a6b19ec26aca111d92ff20f92ac
		$this->_data['rows'] = $rows;

		$args = $this->default_args();
		$args['deleted'] = 0;
		$args['role'] = 'CUSTOMER';
		if (in_array($this->_data['role'], array('SALES', 'AGENCY', 'DISTRIBUTOR', 'WHOLESALER'))) {
			$args['created_by'] = $this->_data['userid'];
		}
		$this->_data['products'] = $this->gets($args);

		$this->_data['title'] = 'In barcode sản phẩm - ' . $this->_data['title'];
		$this->_data['main_content'] = 'products/view_page_print_barcode';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_report_export_excel() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$get = $this->input->get();
		$this->_data['get'] = $get;

		$args = $this->default_args();
		$args['deleted'] = 0;
		$args['role'] = 'CUSTOMER';

		$warehouse_id = 0;
		$product_ids = $not_in_product_ids = array();
		$args_purchase_voucher_details = array();
		if (isset($get['warehouse_id']) && (((int) $get['warehouse_id']) != 0)) {
			if ($get['warehouse_id'] != -1) {
				//echo 1; die;
				$warehouse_id = $get['warehouse_id'];
				$args_purchase_voucher_details['warehouse_id'] = $get['warehouse_id'];
				$purchase_voucher_details = $this->M_purchase_voucher_details->gets($args_purchase_voucher_details);
				if (is_array($purchase_voucher_details) && !empty($purchase_voucher_details)) {
					$product_ids = array_unique(array_column($purchase_voucher_details, 'product_id'));
				}
			} else {
				$purchase_voucher_details = $this->M_purchase_voucher_details->gets($args_purchase_voucher_details);
				if (is_array($purchase_voucher_details) && !empty($purchase_voucher_details)) {
					$not_in_product_ids = array_unique(array_column($purchase_voucher_details, 'product_id'));
				}
			}
		}

		/*$options = array();
		if (isset($get['fromday']) && trim($get['fromday']) != '' && isset($get['today']) && trim($get['today']) != '') {
			$options['start_date_start'] = get_start_date($get['fromday']);
			$options['start_date_end'] = get_end_date($get['today']);
		}*/

		if (isset($get['category_id']) && (((int) $get['category_id']) != 0)) {
			$args['category_id'] = $get['category_id'];
		}

		if (!empty($not_in_product_ids)) {
			$args['not_in_id'] = $not_in_product_ids;
		}

		if (isset($get['product_id']) && (((int) $get['product_id']) != 0)) {
			$args['in_id'] = array($get['product_id']);
		} elseif (!empty($product_ids)) {
			$args['in_id'] = $product_ids;
		}

		$rows = $this->M_products->gets($args);

		if (!is_array($rows) && empty($rows)) {
			$this->_module_slug = 'bao-cao/kho-hang';

			$notify_type = 'danger';
			$notify_content = 'Chưa có dữ liệu!';
			$this->set_notify_admin($notify_type, $notify_content);
			redirect(base_url($this->_module_slug));
		}

		$this->load->library('excel');

		$styleAlignmentCenter = array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		);

		$styleAlignmentRight = array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		);

		$styleAlignmentVerticalTop = array(
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
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
			->setTitle("Báo cáo theo kho hàng")
			->setSubject("Báo cáo theo kho hàng")
			->setDescription("Báo cáo theo kho hàng")
			->setKeywords("Báo cáo theo kho hàng")
			->setCategory("Báo cáo theo kho hàng");
		$this->excel->getActiveSheet()->setTitle('Báo cáo theo kho hàng');

		$this->excel->setActiveSheetIndex(0)->mergeCells('A1:A2');
		$this->excel->setActiveSheetIndex(0)->mergeCells('B1:B2');
		$this->excel->setActiveSheetIndex(0)->mergeCells('C1:C2');
		$this->excel->setActiveSheetIndex(0)->mergeCells('D1:D2');
		$this->excel->setActiveSheetIndex(0)->mergeCells('E1:E2');
		$this->excel->setActiveSheetIndex(0)->mergeCells('F1:F2');
		$this->excel->setActiveSheetIndex(0)->mergeCells('G1:G2');
		$this->excel->setActiveSheetIndex(0)->mergeCells('H1:K1');
		$this->excel->setActiveSheetIndex(0)->mergeCells('L1:L2');
		$this->excel->setActiveSheetIndex(0)->mergeCells('M1:M2');
		$this->excel->setActiveSheetIndex(0)->mergeCells('N1:N2');

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('A1', 'STT')
			->setCellValue('B1', 'Mã sản phẩm')
			->setCellValue('C1', 'Tên sản phẩm')
			->setCellValue('D1', 'Tồn đầu')
			->setCellValue('E1', 'Tổng giá trị')
			->setCellValue('F1', 'Nhập')
			->setCellValue('G1', 'Tổng giá trị')
			->setCellValue('H1', 'Xuất')
			->setCellValue('L1', 'Tổng giá trị')
			->setCellValue('M1', 'Tồn cuối')
			->setCellValue('N1', 'Tổng giá trị');

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('H2', 'Khách lẻ')
			->setCellValue('I2', 'Tổng giá trị')
			->setCellValue('J2', 'Khách sỉ')
			->setCellValue('K2', 'Tổng giá trị');

		$this->excel->getActiveSheet()->getStyle("A1:N2")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:N2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('A1:N2')->getFill()->getStartColor()->setARGB('ABB0B2');
		// Add some data
		$this->excel->getActiveSheet()->getStyle("A1:N2")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:N2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		//Header
		$this->excel->getActiveSheet()->getStyle('A1:N2')->getFont()->applyFromArray($styleHeader);

		//Alignment
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->applyFromArray($styleAlignmentCenter);
		$this->excel->getActiveSheet()->getStyle('D1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('E1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('H1')->getAlignment()->applyFromArray($styleAlignmentCenter);

		$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

		$i = 3;
		$order = 0;
		$total_voucher_unit_price_start = 0;
		$total_output_voucher_monetized = 0;
		$total_output_voucher_KL_monetized = 0;
		$total_output_voucher_KS_monetized = 0;
		$total_purchase_voucher_monetized = 0;
		$total_voucher_unit_price_end = 0;
		foreach ($rows as $row) {
			$items_output_voucher = $this->M_output_voucher_details->gets(array('product_id' => $row['id']));
			$items_purchase_voucher = $this->M_purchase_voucher_details->gets(array('product_id' => $row['id']));

			$voucher_quantity_start = 0;
			$voucher_unit_price_start = 0;
			$output_voucher_quantity = 0;
			$output_voucher_monetized = 0;
			$output_voucher_KL_quantity = 0;
			$output_voucher_KL_monetized = 0;
			$output_voucher_KS_quantity = 0;
			$output_voucher_KS_monetized = 0;
			$purchase_voucher_quantity = 0;
			$purchase_voucher_monetized = 0;
			$voucher_quantity_end = $row['quantity'];
			$voucher_unit_price_end = $row['quantity'] * $row['unit_price'];
			if (isset($items_output_voucher) && is_array($items_output_voucher) && !empty($items_output_voucher)) {
				foreach ($items_output_voucher as $value) {
					$output_voucher_quantity += $value['quantity'];
					$output_voucher_monetized += $value['monetized'];
					/*
					if ($value['customer_type'] == 'KL') {
						$output_voucher_KL_quantity += $value['quantity'];
						$output_voucher_KL_monetized += $value['monetized'];
					} elseif ($value['customer_type'] == 'KS') {
						$output_voucher_KS_quantity += $value['quantity'];
						$output_voucher_KS_monetized += $value['monetized'];
					}
					*/
					$output_voucher_KL_quantity += $value['quantity'];
					$output_voucher_KL_monetized += $value['monetized'];
				}
			}
			if (isset($items_purchase_voucher) && is_array($items_purchase_voucher) && !empty($items_purchase_voucher)) {
				$j = 0;
				foreach ($items_purchase_voucher as $value) {
					$j++;
					$purchase_voucher_quantity += $value['quantity'];
					$purchase_voucher_monetized += $value['monetized'];
					if ($j == 1) {
						$voucher_quantity_start = $value['quantity_current'];
						$voucher_unit_price_start = $voucher_unit_price_end;
					}
				}
			} else {
				$voucher_quantity_start = $voucher_quantity_end;
				$voucher_unit_price_start = $voucher_unit_price_end;
			}
			$total_voucher_unit_price_start += $voucher_unit_price_start;
			$total_purchase_voucher_monetized += $purchase_voucher_monetized;
			$total_output_voucher_monetized += $output_voucher_monetized;
			$total_output_voucher_KL_monetized += $output_voucher_KL_monetized;
			$total_output_voucher_KS_monetized += $output_voucher_KS_monetized;
			$total_voucher_unit_price_end += $voucher_unit_price_end;

			$this->excel->getActiveSheet()->getStyle('A' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('B' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('C' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('D' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('E' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('F' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('G' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('H' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('I' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('J' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('K' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('L' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('M' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('N' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

			$order++;
			$this->excel->setActiveSheetIndex(0)
				->setCellValue('A' . $i, $order)
				->setCellValue('B' . $i, $row['code'])
				->setCellValue('C' . $i, $row['name'])
				->setCellValue('D' . $i, formatRice($voucher_quantity_start))
				->setCellValue('E' . $i, formatRice($voucher_unit_price_start))
				->setCellValue('F' . $i, formatRice($purchase_voucher_quantity))
				->setCellValue('G' . $i, formatRice($purchase_voucher_monetized))
				->setCellValue('H' . $i, formatRice($output_voucher_KL_quantity))
				->setCellValue('I' . $i, formatRice($output_voucher_KL_monetized))
				->setCellValue('J' . $i, formatRice($output_voucher_KS_quantity))
				->setCellValue('K' . $i, formatRice($output_voucher_KS_monetized))
				->setCellValue('L' . $i, formatRice($output_voucher_monetized))
				->setCellValue('M' . $i, formatRice($voucher_quantity_end))
				->setCellValue('N' . $i, formatRice($voucher_unit_price_end))
			;

			//Highlight
			$this->excel->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('N' . $i)->applyFromArray($styleHighlight);

			//Alignment
			$this->excel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('D' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('E' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('F' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('G' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('H' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('I' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('J' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('K' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('L' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('M' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('N' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);

			$i++;
		}

		$this->excel->getActiveSheet()->getStyle('A' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('B' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('C' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('D' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('E' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('F' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('G' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('H' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('I' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('J' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('K' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('L' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('M' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('N' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('A' . $i, 'Tổng cộng')
			->setCellValue('E' . $i, formatRice($total_voucher_unit_price_start))
			->setCellValue('G' . $i, formatRice($total_purchase_voucher_monetized))
			->setCellValue('I' . $i, formatRice($total_output_voucher_KL_monetized))
			->setCellValue('K' . $i, formatRice($total_output_voucher_KS_monetized))
			->setCellValue('L' . $i, formatRice($total_output_voucher_monetized))
			->setCellValue('N' . $i, formatRice($total_voucher_unit_price_end));
		$this->excel->setActiveSheetIndex(0)->mergeCells('A' . $i . ':' . 'D' . $i);

		//Total
		$styleTotal = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'FF0000'),
			),
		);
		$this->excel->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('N' . $i)->applyFromArray($styleTotal);

		//Alignment
		$this->excel->getActiveSheet()->getStyle('E' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('G' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('I' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('K' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('L' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('N' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);

		$filename = 'Bao-cao-theo-kho-hang_' . date('Y-m-d_H-i-s') . '.xls';
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save('php://output');
	}

	function admin_report() {
		$this->_initialize_admin();
		$this->_validate_access_role();
		$this->load->library('form_validation');

		$this->_module_slug = 'bao-cao/kho-hang';
		$this->_data['module_slug'] = $this->_module_slug;
		$_breadcrumbs_admin[] = array(
			'url' => '',
			'name' => 'Báo cáo ( kho hàng )',
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

		$warehouse_id = 0;
		$product_ids = $not_in_product_ids = array();
		$args_purchase_voucher_details = array();
		if (isset($get['warehouse_id']) && (((int) $get['warehouse_id']) != 0)) {
			if ($get['warehouse_id'] != -1) {
				//echo 1; die;
				$warehouse_id = $get['warehouse_id'];
				$args_purchase_voucher_details['warehouse_id'] = $get['warehouse_id'];
				$purchase_voucher_details = $this->M_purchase_voucher_details->gets($args_purchase_voucher_details);
				if (is_array($purchase_voucher_details) && !empty($purchase_voucher_details)) {
					$product_ids = array_unique(array_column($purchase_voucher_details, 'product_id'));
				}
			} else {
				$purchase_voucher_details = $this->M_purchase_voucher_details->gets($args_purchase_voucher_details);
				if (is_array($purchase_voucher_details) && !empty($purchase_voucher_details)) {
					$not_in_product_ids = array_unique(array_column($purchase_voucher_details, 'product_id'));
				}
			}
		}

		/*
			echo "<pre>";
			print_r($product_ids);
			echo "</pre>";
			die;
		*/

		$warehouse = modules::run('purchase_voucher/warehouse/gets');
		$this->_data['warehouse'] = $warehouse;

		$args = $this->default_args();
		$args['deleted'] = 0;
		$args['role'] = 'CUSTOMER';

		$options = array();
		if (isset($get['fromday']) && trim($get['fromday']) != '' && isset($get['today']) && trim($get['today']) != '') {
			$options['start_date_start'] = get_start_date($get['fromday']);
			$options['start_date_end'] = get_end_date($get['today']);
		}

		if (isset($get['category_id']) && (((int) $get['category_id']) != 0)) {
			$args['category_id'] = $get['category_id'];
		}

		if (!empty($not_in_product_ids)) {
			$args['not_in_id'] = $not_in_product_ids;
		}

		if (isset($get['product_id']) && (((int) $get['product_id']) != 0)) {
			$args['in_id'] = array($get['product_id']);
		} elseif (!empty($product_ids)) {
			$args['in_id'] = $product_ids;
		}

		$total = $this->counts($args);
		$is_show_all = false;
		$perpage = 10;
		if(isset($get['per_page'])){
			if((int) $get['per_page'] != 0){
				$perpage = (int) $get['per_page'];
			}else{
				$is_show_all = true;
			}
		}
		$segment = 3;
		$rows = $this->M_products->gets($args);
		/*
		if (is_array($rows) && !empty($rows)) {
			foreach ($rows as $key => $value) {
				$items_output_voucher_retail_price_quantity = 0;
				$items_output_voucher_retail_price = $this->M_output_voucher_details->gets(array('product_id' => $value['id'], 'price_type' => 'retail_price'));
				if (is_array($items_output_voucher_retail_price) && !empty($items_output_voucher_retail_price)) {
					$items_output_voucher_retail_price_quantity = array_sum(array_column($items_output_voucher_retail_price, 'quantity'));
				}
				$items_output_voucher_cost_price = $this->M_output_voucher_details->gets(array('product_id' => $value['id'], 'price_type' => 'cost_price'));
				$rows[$key]['items_output_voucher'] = $this->M_output_voucher_details->gets(array('product_id' => $value['id']));
				$rows[$key]['items_purchase_voucher'] = $this->M_purchase_voucher_details->gets(array('product_id' => $value['id']));
			}
		}
		$this->calculator_report($rows);
		*/
		$total_purchase_voucher_monetized = 0;
	    $total_output_voucher_KL_monetized = 0;
		$total_output_voucher_KS_monetized = 0;
		$total_output_voucher_monetized = 0;
		$total_voucher_unit_price_end = 0;
		if (is_array($rows) && !empty($rows)) {
			foreach ($rows as $key => $value) {
				$statistics = $this->get_statistics($value['id'], $warehouse_id, $options);
				//$total_purchase_voucher_monetized += $statistics['import_monetized'];
				$total_purchase_voucher_monetized += $statistics['import'] * $value['unit_price'];
				$total_output_voucher_KL_monetized += $statistics['export_retail_monetized'];
				$total_output_voucher_KS_monetized += $statistics['export_cost_monetized'];
				$total_voucher_unit_price_end += $statistics['inventory'] * $value['unit_price'];
				// if($value['id'] == 7063){
				// 	echo "<pre>";
				// 	print_r($statistics);
				// 	echo "</pre>";
				// 	die();
				// }
			}
		}
		$total_output_voucher_monetized = $total_output_voucher_KL_monetized + $total_output_voucher_KS_monetized;
		$this->_data['global_total_purchase_voucher_monetized'] = $total_purchase_voucher_monetized;
		$this->_data['global_total_output_voucher_KL_monetized'] = $total_output_voucher_KL_monetized;
		$this->_data['global_total_output_voucher_KS_monetized'] = $total_output_voucher_KS_monetized;
		$this->_data['global_total_output_voucher_monetized'] = $total_output_voucher_monetized;
		$this->_data['global_total_voucher_unit_price_end'] = $total_voucher_unit_price_end;

		if($is_show_all){
			$rows = $this->M_products->gets($args);
		}else{
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

			$this->pagination->initialize($config); # Khởi tạo phân trang

			$pagination = $this->pagination->create_links(); # Tạo link phân trang
			$offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment); # Lấy offset
			$this->_data['current_page'] = (int) $offset;

			$this->_data['pagination'] = $pagination;
			$rows = $this->M_products->gets($args, $perpage, $offset);
		}
		if (is_array($rows) && !empty($rows)) {
			foreach ($rows as $key => $value) {
				$statistics = $this->get_statistics($value['id'], $warehouse_id, $options);
				$rows[$key]['import'] = $statistics['import'];
				$rows[$key]['import_monetized'] = $statistics['import_monetized'];
				$rows[$key]['export_retail'] = $statistics['export_retail'];
				$rows[$key]['export_cost'] = $statistics['export_cost'];
				$rows[$key]['export_retail_monetized'] = $statistics['export_retail_monetized'];
				$rows[$key]['export_cost_monetized'] = $statistics['export_cost_monetized'];
				$rows[$key]['inventory'] = $statistics['inventory'];
				//$rows[$key]['items_output_voucher'] = $this->M_output_voucher_details->gets(array('product_id' => $value['id']));
				//$rows[$key]['items_purchase_voucher'] = $this->M_purchase_voucher_details->gets(array('product_id' => $value['id']));
			}
		}
		$this->_data['rows'] = $rows;

		$this->_data['category'] = modules::run('category/gets');

		$args = $this->default_args();
		$args['deleted'] = 0;
		$this->_data['products'] = $this->gets($args);

		$this->_data['breadcrumbs_module_name'] = 'Báo cáo';
		$this->_data['breadcrumbs_module_func'] = 'Kho hàng';
		$this->_data['title'] = 'Báo cáo theo kho hàng';
		$this->_data['main_content'] = 'products/view_page_report';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function calculator_report($rows) {
		$j = 0;
		$total_voucher_unit_price_start = 0;
		$total_output_voucher_monetized = 0;
		$total_output_voucher_KL_monetized = 0;
		$total_output_voucher_KS_monetized = 0;
		$total_purchase_voucher_monetized = 0;
		$total_voucher_unit_price_end = 0;
		if (is_array($rows) && !empty($rows)) {
			foreach ($rows as $row) {
				$j++;

				$voucher_quantity_start = 0;
				$voucher_unit_price_start = 0;

				$output_voucher_quantity = 0;
				$output_voucher_monetized = 0;

				$output_voucher_KL_quantity = 0;
				$output_voucher_KL_monetized = 0;

				$output_voucher_KS_quantity = 0;
				$output_voucher_KS_monetized = 0;

				$purchase_voucher_quantity = 0;
				$purchase_voucher_monetized = 0;

				$voucher_quantity_end = $row['quantity'];
				$voucher_unit_price_end = $row['quantity'] * $row['unit_price'];

				if (isset($row['items_output_voucher']) && is_array($row['items_output_voucher']) && !empty($row['items_output_voucher'])) {
					foreach ($row['items_output_voucher'] as $value) {
						$output_voucher_quantity += $value['quantity'];
						$output_voucher_monetized += $value['monetized'];

						if ($value['price_type'] == 'retail_price') {
							$output_voucher_KL_quantity += $value['quantity'];
							$output_voucher_KL_monetized += $value['monetized'];
						} elseif ($value['price_type'] == 'cost_price') {
							$output_voucher_KS_quantity += $value['quantity'];
							$output_voucher_KS_monetized += $value['monetized'];
						}
					}
				}
				if (isset($row['items_purchase_voucher']) && is_array($row['items_purchase_voucher']) && !empty($row['items_purchase_voucher'])) {
					$i = 0;
					foreach ($row['items_purchase_voucher'] as $value) {
						$i++;
						$purchase_voucher_quantity += $value['quantity'];
						$purchase_voucher_monetized += $value['monetized'];

						if ($i == 1) {
							$voucher_quantity_start = $value['quantity_current'];
							$voucher_unit_price_start = $voucher_unit_price_end;
						}
					}
				} else {
					$voucher_quantity_start = $voucher_quantity_end;
					$voucher_unit_price_start = $voucher_unit_price_end;
				}
				$total_voucher_unit_price_start += $voucher_unit_price_start;
				$total_purchase_voucher_monetized += $purchase_voucher_monetized;
				$total_output_voucher_monetized += $output_voucher_monetized;
				$total_output_voucher_KL_monetized += $output_voucher_KL_monetized;
				$total_output_voucher_KS_monetized += $output_voucher_KS_monetized;
				$total_voucher_unit_price_end += $voucher_unit_price_end;
			}
		}
		$this->_data['global_total_voucher_unit_price_start'] = $total_voucher_unit_price_start;
		$this->_data['global_total_purchase_voucher_monetized'] = $total_purchase_voucher_monetized;
		$this->_data['global_total_output_voucher_KL_monetized'] = $total_output_voucher_KL_monetized;
		$this->_data['global_total_output_voucher_KS_monetized'] = $total_output_voucher_KS_monetized;
		$this->_data['global_total_output_voucher_monetized'] = $total_output_voucher_monetized;
		$this->_data['global_total_voucher_unit_price_end'] = $total_voucher_unit_price_end;
	}

	function admin_view_history() {
		$this->_initialize_admin();
		$this->_validate_access_role();
		$segment = 3;
		$id = (int) (($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment));
		if ($id == 0) {
			show_404();
		}
		$row = $this->get($id);
		if (!is_array($row) && empty($row)) {
			show_404();
		}

		$this->_module_slug = 'san-pham/xem-doi-gia';
		$this->_data['module_slug'] = $this->_module_slug;

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

		$args = array();
		$args['product_id'] = $row['id'];

		$total = $this->M_purchase_voucher_details->counts($args);
		$perpage = isset($get['per_page']) ? (int) $get['per_page'] : 10;
		$segment++;

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

		$this->_data['pagination'] = $pagination;
		$rows = $this->M_purchase_voucher_details->gets($args, $perpage, $offset);
		$this->_data['rows'] = $rows;
		$this->_data['row'] = $row;

		$this->_data['breadcrumbs_module_name'] = 'Sản phẩm';
		$this->_data['breadcrumbs_module_func'] = 'Lịch sử đổi giá';
		$this->_data['title'] = 'Xem lịch sử đổi giá';
		$this->_data['main_content'] = 'products/view_page_history';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_index() {
		//$this->output->delete_cache();
		$this->_initialize_admin();
		$this->_validate_access_role();

		$this->_plugins_css_admin[] = array(
			'folder' => 'bootstrap3-dialog/css',
			'name' => 'bootstrap-dialog',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'bootstrap3-dialog/js',
			'name' => 'bootstrap-dialog',
		);
		$this->set_plugins_admin();

		$this->_modules_script[] = array(
			'folder' => 'products',
			'name' => 'index',
		);
		$this->set_modules();

		$get = $this->input->get();
		$this->_data['get'] = $get;

		$args = $this->default_args();
		$args['deleted'] = 0;
		/*
		$rows = $this->M_products->gets($args);
        if(is_array($rows) && !empty($rows)){
            foreach ($rows as $value) {
                $this->create_barcode_image($value['barcode'], 0, $value['name']);
            }
        }
        die;
        */
		$args['role'] = 'CUSTOMER';
		if (in_array($this->_data['role'], array('SALES', 'AGENCY', 'DISTRIBUTOR', 'WHOLESALER'))) {
			$args['created_by'] = $this->_data['userid'];
		}

		if (isset($get['category_id']) && ((int) $get['category_id'] != 0)) {
			$args['category_id'] = $get['category_id'];
		}

		if (isset($get['q']) && trim($get['q']) != '') {
			$args['q'] = $get['q'];
		}
		$total = $this->counts($args);
		$this->_data['total_record'] = (int) $total;
		$perpage = isset($get['per_page']) ? (int) $get['per_page'] : 10;
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
			$config['base_url'] = base_url($this->_module_slug);
			$config['suffix'] = '?' . http_build_query($get, '', "&");
			$config['first_url'] = base_url($this->_module_slug . '?' . http_build_query($get, '', "&"));
			$config['uri_segment'] = $segment;
		} else {
			$config['base_url'] = base_url($this->_module_slug);
			$config['uri_segment'] = $segment;
		}

		$this->pagination->initialize($config); # Khởi tạo phân trang

		$pagination = $this->pagination->create_links(); # Tạo link phân trang
		$offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment); # Lấy offset
		$this->_data['current_page'] = (int) $offset;
		# Đẩy dữ liệu ra view
		$rows = $this->M_products->gets($args, $perpage, $offset);
		if (is_array($rows) && !empty($rows)) {
			$warehouse_id = 0;
			if (isset($get['warehouse_id']) && ((int) $get['warehouse_id'] != 0)) {
				$warehouse_id = (int) $get['warehouse_id'];
			}
			foreach ($rows as $key => $value) {
				$asc_desc = 'None';
				$products_purchase_voucher_details = $this->M_purchase_voucher_details->gets(array(
					'product_id' => $value['id'],
					'order_by' => array(
						'pvr.date' => 'DESC',
					),
				));
				if (isset($products_purchase_voucher_details[0]) && is_array($products_purchase_voucher_details[0]) && !empty($products_purchase_voucher_details[0])) {
					if ($value['unit_price'] < $products_purchase_voucher_details[0]['unit_price_current']) {
						$asc_desc = 'DESC';
					} elseif ($value['unit_price'] > $products_purchase_voucher_details[0]['unit_price_current']) {
						$asc_desc = 'ASC';
					}
				}
				$rows[$key]['asc_desc'] = $asc_desc;
				$rows[$key]['quantity'] = $this->get_current_quantity($value['id'], $warehouse_id);
			}
		}
		$this->_data['rows'] = $rows;
		$this->_data['pagination'] = $pagination;

		$this->_data['category'] = modules::run('category/gets');
		$this->_data['warehouse'] = modules::run('purchase_voucher/warehouse/gets');

		$this->_data['breadcrumbs_module_func'] = 'Danh sách sản phẩm';
		$this->_data['title'] = 'Danh sách sản phẩm';
		$this->_data['main_content'] = 'products/view_page_index';
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
			'name' => 'bootstrap-dialog',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'bootstrap3-dialog/js',
			'name' => 'bootstrap-dialog',
		);
		$this->set_plugins_admin();

		$this->_modules_script[] = array(
			'folder' => 'products',
			'name' => 'admin-items-trash',
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
			$config['base_url'] = base_url('products');
			$config['suffix'] = '?' . http_build_query($get, '', "&");
			$config['first_url'] = base_url('products' . '?' . http_build_query($get, '', "&"));
			$config['uri_segment'] = $segment;
		} else {
			$config['base_url'] = base_url('products');
			$config['uri_segment'] = $segment;
		}

		$this->pagination->initialize($config); # Khởi tạo phân trang

		$pagination = $this->pagination->create_links(); # Tạo link phân trang
		$offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment); # Lấy offset
		# Đẩy dữ liệu ra view
		$this->_data['rows'] = $this->M_products->gets($args, $perpage, $offset);
		$this->_data['pagination'] = $pagination;

		$this->_data['breadcrumbs_module_func'] = 'Danh sách sản phẩm';
		$this->_data['title'] = 'Danh sách sản phẩm';
		$this->_data['main_content'] = 'products/view_page_trash';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_delete() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$this->_message_success = 'Đã xóa sản phẩm!';
		$this->_message_warning = 'Sản phẩm này không tồn tại!';
		$id = (int) $this->input->get('id');
		$row = $this->get($id);
		if (is_array($row) && !empty($row)) {
			$is_used = false;
			$args_purchase_voucher_details = array(
				'product_id' => $id,
			);
			$products_purchase_voucher_details = $this->M_purchase_voucher_details->gets($args_purchase_voucher_details);
			if (is_array($products_purchase_voucher_details) && !empty($products_purchase_voucher_details)) {
				$is_used = true;
			}

			$args_output_voucher_details = array(
				'product_id' => $id,
			);
			$products_output_voucher_details = $this->M_output_voucher_details->gets($args_output_voucher_details);
			if (is_array($products_output_voucher_details) && !empty($products_output_voucher_details)) {
				$is_used = true;
			}
			if ($is_used) {
				$notify_type = 'danger';
				$notify_content = 'Sản phẩm này đang được sử dụng dữ liệu nên không thể xóa. Vui lòng xóa dữ liệu liên quan và thực hiện lại!';
				$this->set_notify_admin($notify_type, $notify_content);
				redirect(base_url($this->_module_slug));
			}
			if ($this->M_products->delete($id)) {
				@unlink(FCPATH . $this->_path . $row['image']);

				add_activities(array(
					'action' => NULL,
					'activity' => "Người dùng xóa sản phẩm #ID: $id",
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

		$this->_message_success = 'Đã xóa sản phẩm!';
		$this->_message_warning = 'Sản phẩm này không tồn tại!';
		$id = (int) $this->input->get('id');
		if ($id != 0) {
			$row = $this->get($id);
			if ($this->M_products->delete($id)) {
				@unlink(FCPATH . $this->_path . $row['image']);
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
		$this->_plugins_script_admin[] = array(
			'folder' => 'bootstrap-datepicker',
			'name' => 'app.editinfo',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'jquery-validation',
			'name' => 'jquery.validate',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'jquery-validation/localization',
			'name' => 'messages_vi',
		);

		$this->_plugins_css_admin[] = array(
			'folder' => 'chosen',
			'name' => 'chosen',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'chosen',
			'name' => 'chosen.jquery',
		);

		$this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-fileinput/css',
            'name' => 'fileinput'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-fileinput/js',
            'name' => 'fileinput.min'
        );

		$this->set_plugins_admin();

		$this->_modules_script[] = array(
			'folder' => 'products',
			'name' => 'admin-content',
		);
		$this->set_modules();

		$post = $this->input->post();
		if (!empty($post)) {
			$this->load->helper('language');
			$this->lang->load('form_validation', 'vietnamese');

			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('name', 'Sản phẩm', 'trim|required');
			$this->form_validation->set_rules('code', 'Mã sản phẩm', 'trim|required');
			$this->form_validation->set_rules('barcode', 'Barcode', 'trim|required');

			if ($this->form_validation->run($this)) {
				$text = $this->input->post('name');
				if ($this->input->post('id')) {
					$err = FALSE;
					$id = $this->input->post('id');
					$row_old = $this->get($id);
					if (!$this->admin_update($id)) {
						$err = TRUE;
					} else {
                        $this->_upload_images($id, 'image');
                    }

					if ($err === FALSE) {
						$row_new = $this->get($id);
						add_activities(array(
							'action' => NULL,
							'activity' => "Người dùng cập nhật sản phẩm #ID: $id",
							'data' => serialize(array('old' => $row_old, 'new' => $row_new)),
						));

						$barcode = $this->input->post('barcode');
						$this->create_barcode_image($barcode, 0, $text);
						$current_page = $this->input->post('current_page');
						$notify_type = 'success';
						$notify_content = 'Cập nhật sản phẩm thành công!';
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
                    } else {
                        $this->_upload_images($insert_id, 'image');
                    }

					if ($err === FALSE) {
						$row_new = $this->get($insert_id);
						add_activities(array(
							'action' => NULL,
							'activity' => "Người dùng thêm sản phẩm #ID: $insert_id",
							'data' => serialize(array('old' => NULL, 'new' => $row_new)),
						));

						$barcode = $this->input->post('barcode');
						$this->create_barcode_image($barcode, 0, $text);
						$notify_type = 'success';
						$notify_content = 'Sản phẩm đã được thêm!';
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

		$title = 'Thêm sản phẩm - ' . $this->_data['breadcrumbs_module_name']; // . ' - ' . $this->_data['title'];

		$id = ($this->uri->segment(3) == '') ? 0 : $this->uri->segment(3);
		if ($id != 0) {
			$this->_data['current_page'] = (int) $this->input->get('current_page');
			$row = $this->get($id);
			$this->_data['row'] = $row;
			$title = 'Cập nhật sản phẩm - ' . $this->_data['breadcrumbs_module_name']; // . ' - ' . $this->_data['title'];
		}
		$this->_data['category'] = modules::run('category/gets');

		$this->_data['title'] = $title;
		$this->_data['main_content'] = 'products/view_page_content';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_view() {
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

		$id = (int) (($this->uri->segment(3) == '') ? 0 : $this->uri->segment(3));
		if ($id == 0) {
			show_404();
		}
		$this->_data['current_page'] = (int) $this->input->get('current_page');
		$row = $this->get($id);
		$this->_data['row'] = $row;
		$this->_data['category'] = modules::run('category/gets');

		$this->_data['breadcrumbs_module_func'] = 'Xem sản phẩm';

		$this->_data['title'] = 'Xem sản phẩm - ' . $this->_data['breadcrumbs_module_name'];
		$this->_data['main_content'] = 'products/view_page_view';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function ajax_admin_add() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$EXP = $this->input->post('EXP');
		$data = array(
			'name' => $this->input->post('name'),
			'code' => $this->input->post('code'),
			'category_id' => $this->input->post('category_id') ? $this->input->post('category_id') : 0,
			'unit' => $this->input->post('unit'),
			'origin' => $this->input->post('origin'),
			'specification' => $this->input->post('specification'),
			'quantity' => 0,
			//'quantity' => filter_var($this->input->post('quantity'), FILTER_SANITIZE_NUMBER_INT),
			'safety_margin' => filter_var($this->input->post('safety_margin'), FILTER_SANITIZE_NUMBER_INT),
			'unit_price' => $this->input->post('unit_price'),
			'retail_price' => $this->input->post('retail_price'),
			'cost_price' => $this->input->post('cost_price'),
			'note' => $this->input->post('note'),
			'EXP' => (trim($EXP) != '') ? get_end_date($EXP) : 0,
			'active' => $this->input->post('active') ? 1 : 0,
			'deleted' => 0,
			'created' => time(),
			'modified' => 0,
			'order' => $this->get_max_order() + 1,
		);

		$message = array();

		$id = $this->M_products->add($data);
		if ($id != 0) {
			$products = $this->gets(array('deleted' => 0));

			$message['status'] = 'success';
			$message['content'] = $this->load->view('layout/site/partial/option', array('data' => $products, 'id' => $id), true);
			$message['message'] = '';
		} else {
			$message['status'] = 'error';
			$message['content'] = null;
			$message['message'] = '';
		}

		echo json_encode($message);
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
        $barcode_src = get_module_path('barcodes') . $barcode_text . '.png';
		save_image_from_url($barcode_url, $barcode_src);
		/*
		if(trim($text) != ''){
			$this->add_text_to_barcode($text, $barcode_src);
		}
		*/
		if($id != 0){
			$row = $this->get($id);
			if(isset($row['barcode']) && trim($row['barcode']) != ''){
				@unlink(FCPATH . get_module_path('barcodes') . $row['barcode']);
			}
		}
        return $barcode_url;
	}

	public function add_text_to_barcode($text = '', $barcode_src = ''){
        $this->load->library('image_lib');
        $config['source_image'] = './' . $barcode_src;
        $config['wm_text'] = $text;
        $config['wm_type'] = 'text';
        $config['wm_font_path'] = './assets/fonts/UTM Avo.ttf';
        $config['wm_font_size'] = 8;
        $config['wm_font_color'] = '000000';
        $config['wm_padding'] = '10';
        $config['wm_vrt_alignment'] = 'top';
        $config['wm_hor_alignment'] = 'left';

        $this->image_lib->initialize($config);
        if (!$this->image_lib->watermark()) {
        	return false;
            $this->image_lib->display_errors();
        } else {
            return true;
        }
	}

	function admin_add() {
		$EXP = $this->input->post('EXP');
		$data = array(
			'name' => $this->input->post('name'),
			'code' => $this->input->post('code'),
			'barcode' => $this->input->post('barcode'),
			'category_id' => $this->input->post('category_id') ? $this->input->post('category_id') : 0,
			'unit' => $this->input->post('unit'),
			'origin' => $this->input->post('origin'),
			'specification' => $this->input->post('specification'),
			'quantity' => 0,
			//'quantity' => filter_var($this->input->post('quantity'), FILTER_SANITIZE_NUMBER_INT),
			'safety_margin' => filter_var($this->input->post('safety_margin'), FILTER_SANITIZE_NUMBER_INT),
			'unit_price' => $this->input->post('unit_price'),
			'retail_price' => $this->input->post('retail_price'),
			'cost_price' => $this->input->post('cost_price'),
			'note' => $this->input->post('note'),
			'EXP' => (trim($EXP) != '') ? get_end_date($EXP) : 0,
			'active' => $this->input->post('active') ? 1 : 0,
			'deleted' => 0,
			'created' => time(),
			'modified' => 0,
			'order' => $this->get_max_order() + 1,
		);

		return $this->M_products->add($data);
	}

	function update($id, $data) {
		if (!is_array($data) || empty($data)) {
			return FALSE;
		}

		return $this->M_products->update($id, $data);
	}

	function admin_update($id) {
		$EXP = $this->input->post('EXP');
		$data = array(
			'name' => $this->input->post('name'),
			'code' => $this->input->post('code'),
			'barcode' => $this->input->post('barcode'),
			'category_id' => $this->input->post('category_id') ? $this->input->post('category_id') : 0,
			'unit' => $this->input->post('unit'),
			'origin' => $this->input->post('origin'),
			'specification' => $this->input->post('specification'),
			//'quantity' => filter_var($this->input->post('quantity'), FILTER_SANITIZE_NUMBER_INT),
			'safety_margin' => filter_var($this->input->post('safety_margin'), FILTER_SANITIZE_NUMBER_INT),
			'unit_price' => $this->input->post('unit_price'),
			'retail_price' => $this->input->post('retail_price'),
			'cost_price' => $this->input->post('cost_price'),
			'note' => $this->input->post('note'),
			'EXP' => (trim($EXP) != '') ? get_end_date($EXP) : 0,
			'active' => $this->input->post('active') ? 1 : 0,
			'modified' => time(),
		);

		return $this->M_products->update($id, $data);
	}

	function admin_main() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$post = $this->input->post();
		if (!empty($post)) {
			$action = $this->input->post('action');
			if ($action == 'delete') {
				$this->_message_success = 'Đã xóa các sản phẩm được chọn!';
				$this->_message_warning = 'Bạn chưa chọn sản phẩm nào!';
				$ids = $this->input->post('idcheck');

				if (is_array($ids) && !empty($ids)) {
					foreach ($ids as $id) {
						$row = $this->get($id);
						if ($this->M_products->delete($id)) {
							@unlink(FCPATH . $this->_path . $row['image']);
							$notify_type = 'success';
							$notify_content = $this->_message_success;
						} else {
							$notify_type = 'danger';
							$notify_content = $this->_message_danger;
						}
					}
					add_activity("Người dùng xóa các sản phẩm #ID: " . implode(', ', $ids));
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

	private function _upload_images($id, $input_name) {
        $row = $this->get($id);
        $info = modules::run('files/index', $input_name, $this->_path);
        if (isset($info['uploads'])) {
            $upload_images = $info['uploads'];
            if ($_FILES[$input_name]['size'] != 0) {
                foreach ($upload_images as $value) {
                    $file_name = $value['file_name'];
                    $data_images = array(
                        'image' => $file_name
                    );
                    $this->M_products->update($id, $data_images);
                }
                @unlink(FCPATH . $this->_path . $row['image']);
            }
        }
    }

}

/* End of file products.php */
/* Location: ./application/modules/products/controllers/products.php */