<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Purchase_voucher extends Layout {

	private $_module_slug = 'phieu-nhap';

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->_data['module_slug'] = $this->_module_slug;
		$this->_data['breadcrumbs_module_name'] = 'Phiếu nhập';
		$_breadcrumbs_admin[] = array(
			'url' => '',
			'name' => 'Phiếu nhập',
			'image' => base_url('assets/Frest/app-assets/images/svg/ico/ico-input-product.svg'),
		);
		$this->_data['breadcrumbs_admin'] = $_breadcrumbs_admin;
	}

	private function _validate_access_role() {
		$this->validate_access_role('ROLE_GROUP_PURCHASE_VOUCHER');
	}

	function default_args() {
		$order_by = array(
			'code' => 'DESC',
		);
		$args = array();
		$args['order_by'] = $order_by;
		$args['type'] = 'import';

		return $args;
	}

	function counts($options = array()) {
        $default_args = $this->default_args();

        if (is_array($options) && !empty($options)) {
            $args = array_merge($default_args, $options);
        } else {
            $args = $default_args;
        }
		return $this->M_purchase_voucher->counts($args);
	}

	function get($id) {
		$this->load->model('purchase_voucher/m_purchase_voucher', 'M_purchase_voucher');
		return $this->M_purchase_voucher->get($id);
	}

	function gets($options = array()) {
        $default_args = $this->default_args();

        if (is_array($options) && !empty($options)) {
            $args = array_merge($default_args, $options);
        } else {
            $args = $default_args;
        }
		return $this->M_purchase_voucher->gets($args);
	}

	function get_details($id) {
		$this->load->model('purchase_voucher/m_purchase_voucher_details', 'M_purchase_voucher_details');
		return $this->M_purchase_voucher_details->get($id);
	}

	function admin_index() {
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

		$this->_plugins_css_admin[] = array(
			'folder' => 'bootstrap4-dialog/css',
			'name' => 'bootstrap-dialog',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'bootstrap4-dialog/js',
			'name' => 'bootstrap-dialog',
		);

		$this->_vendor_css_admin[] = array(
			'folder' => 'forms/select',
			'name' => 'select2.min',
		);
		$this->_vendor_css_admin[] = array(
			'folder' => 'pickers/pickadate',
			'name' => 'pickadate',
		);

		$this->_vendor_script_admin[] = array(
			'folder' => 'forms/select',
			'name' => 'select2.full.min',
		);
		$this->_vendor_script_admin[] = array(
			'folder' => 'pickers/pickadate',
			'name' => 'picker',
		);
		$this->_vendor_script_admin[] = array(
			'folder' => 'pickers/pickadate',
			'name' => 'picker.date',
		);
		$this->_vendor_script_admin[] = array(
			'folder' => 'pickers/pickadate',
			'name' => 'legacy',
		);
		$this->set_vendor_admin();

		$this->set_plugins_admin();

		$this->_modules_script[] = array(
			'folder' => 'purchase_voucher',
			'name' => 'admin-borrow',
		);
		$this->set_modules();

		$get = $this->input->get();
		$this->_data['get'] = $get;

		$args = $this->default_args();
		$args['deleted'] = 0;

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

        $title = 'Danh sách phiếu nhập';
        if (isset($get['type']) && in_array($get['type'], array_keys($this->config->item('purchase_voucher_type')))) {
            $args['type'] = $get['type'];
            if($get['type'] == 'transaction'){
                $title = 'Danh sách phiếu chuyển kho';
            }
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

		$this->_data['pagination'] = $pagination;

		$rows = $this->M_purchase_voucher->gets($args, $perpage, $offset);
		if (is_array($rows) && !empty($rows)) {
			foreach ($rows as $key => $value) {
				$rows[$key]['items'] = $this->get_details($value['id']);
			}
		}
		$this->_data['rows'] = $rows;

		$this->_data['title'] = $title  . ' - ' . $this->_data['title'];
		$this->_data['main_content'] = 'purchase_voucher/admin/view_page_index';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_trash() {
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
			'folder' => 'purchase_voucher',
			'name' => 'admin-borrow-trash',
		);
		$this->set_modules();

		$this->_data['breadcrumbs_module_name'] = 'Thùng rác';
		$this->_module_slug = 'thung-rac/muon-hang';
		$this->_data['module_slug'] = $this->_module_slug;

		$get = $this->input->get();
		$this->_data['get'] = $get;

		$args = $this->default_args();
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

		$this->_data['rows'] = $this->M_purchase_voucher->gets($args, $perpage, $offset);
		$this->_data['pagination'] = $pagination;

		$this->_data['title'] = 'Thùng rác - Danh sách mượn hàng - ' . $this->_data['title'];
		$this->_data['main_content'] = 'purchase_voucher/admin/view_page_trash';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_transaction_warehouse_ajax() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		$message = array();
		$message['status'] = 'error';
		$message['content'] = null;
		$message['message'] = 'Kiểm tra thông tin nhập';

		if(!$this->logged_in()){
			$message['status'] = 'error';
			$message['content'] = null;
			$message['message'] = 'Vui lòng đăng nhập để thực hiện chức năng này!';
			echo json_encode($message);
			exit();
		}

		$post = $this->input->post();
		if (!empty($post)) {
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('date', 'Ngày nhập', 'required');

			if ($this->form_validation->run($this)) {
				$err = FALSE;
				$id = (int) $this->input->post('id');

				$current_consignments = array();
				$consignments = array();
				$tblAppendGrid = 'tblAppendGrid_';
				$rowOrder = explode(',', $this->input->post($tblAppendGrid . 'rowOrder'));

				if (isset($rowOrder[0]) && trim($rowOrder[0]) == "") {
					$message['status'] = 'error';
					$message['content'] = $rowOrder;
					$message['message'] = 'Chưa chọn sản phẩm! Vui lòng chọn lại sản phẩm và thực hiện lại!';
					echo json_encode($message);
					exit();
				}
				foreach ($rowOrder as $i) {
					$product_id = $this->input->post($tblAppendGrid . 'product_id' . '_' . $i);
					$product = modules::run('products/get', $product_id);
					$quantity_current = 0;
					$unit_price_current = 0;
					$quantity = $this->input->post($tblAppendGrid . 'quantity' . '_' . $i);
					$unit_price = filter_var($this->input->post($tblAppendGrid . 'unit_price' . '_' . $i), FILTER_SANITIZE_NUMBER_FLOAT);
					if (isset($product['quantity'])) {
						$quantity_current = $product['quantity'];
					}
					if (isset($product['unit_price'])) {
						$unit_price_current = $product['unit_price'];
					}
					$consignments[] = array(
						'product_id' => $product_id,
						'warehouse_id' => $this->input->post($tblAppendGrid . 'warehouse_id' . '_' . $i),
						'transaction_warehouse_id' => $this->input->post($tblAppendGrid . 'transaction_warehouse_id' . '_' . $i),
						'quantity' => $quantity,
						'quantity_current' => $quantity_current,
						'unit_price' => $unit_price,
						'unit_price_current' => $unit_price_current,
						'monetized' => $quantity * $unit_price,
						'provider_id' => $this->input->post($tblAppendGrid . 'provider_id' . '_' . $i),
					);
				}
				if (!empty($consignments)) {
					$current_page = $this->input->post('current_page');
					$date = $this->input->post('date');

					$data_purchase_voucher = array(
						'type' => 'transaction',
						'date' => (trim($date) != '') ? get_current_date($date) : 0,
						'note' => $this->input->post('note'),
					);

					if ($id != 0) {
						$row_old = $this->get($id);
						if (isset($row_old['id'])) {
							$row_old['items'] = $this->M_purchase_voucher_details->get_data_in_purchase_voucher_id($row_old['id']);
						}

						$data_purchase_voucher['modified'] = time();
						if (!$this->M_purchase_voucher->update($id, $data_purchase_voucher)) {
							$err = TRUE;
						} else {
							$current_data_output_voucher = $this->M_purchase_voucher_details->get($id);
							if (isset($current_data_output_voucher) && is_array($current_data_output_voucher) && !empty($current_data_output_voucher)) {
								$current_consignments = array_column($current_data_output_voucher, 'quantity', 'product_id');
							}
							$this->M_purchase_voucher_details->delete($id);
						}
						$purchase_voucher_id = $id;
					} else {
						$data_purchase_voucher['code'] = $this->get_code($id, 'transaction');
						$data_purchase_voucher['admin_id'] = 1;
						$data_purchase_voucher['deleted'] = 0;
						$data_purchase_voucher['deleted_by'] = 0;
						$data_purchase_voucher['created'] = time();
						$data_purchase_voucher['modified'] = 0;
						$purchase_voucher_id = $this->M_purchase_voucher->add($data_purchase_voucher);
					}

					if ($purchase_voucher_id != 0) {
						foreach ($consignments as $value) {
							$product = modules::run('products/get', $value['product_id']);
							$total = (int) (isset($product['quantity']) ? $product['quantity'] : 0);
							if (isset($current_consignments) && is_array($current_consignments) && !empty($current_consignments)) {
								if (array_key_exists($value['product_id'], $current_consignments)) {
									$total -= $current_consignments[$value['product_id']];
								}
							}
							$data = array(
								'purchase_voucher_id' => $purchase_voucher_id,
								'product_id' => $value['product_id'],
								'warehouse_id' => $value['warehouse_id'],
								'transaction_warehouse_id' => $value['transaction_warehouse_id'],
								'quantity' => $value['quantity'],
								'quantity_current' => $value['quantity_current'],
								'unit_price' => $value['unit_price'],
								'unit_price_current' => $value['unit_price_current'],
								'monetized' => $value['monetized'],
								'provider_id' => $value['provider_id'],
							);
							if (!$this->M_purchase_voucher_details->add($data)) {
								$err = TRUE;
							} else {
								$this->M_products->update($value['product_id'], array(
									'unit_price' => $value['unit_price'],
									'quantity' => $total + $value['quantity'],
									'modified' => time(),
								));
							}
						}
					} else {
						$err = TRUE;
					}
				}

				if ($err === FALSE) {
					$row_new = $this->get($purchase_voucher_id);
					if (isset($row_new['id'])) {
						$row_new['items'] = $this->M_purchase_voucher_details->get_data_in_purchase_voucher_id($row_new['id']);
					}

					if($id != 0){
						add_activities(array(
							'action' => NULL,
							'activity' => "Người dùng cập nhật chuyển kho #ID: $purchase_voucher_id",
							'data' => serialize(array('old' => $row_old, 'new' => $row_new)),
						));
					}else{
						add_activities(array(
							'action' => NULL,
							'activity' => "Người dùng thêm chuyển kho #ID: $purchase_voucher_id",
							'data' => serialize(array('old' => NULL, 'new' => $row_new)),
						));
					}

					$message['status'] = 'success';
					$message['content'] = array('data' => base_url($this->_module_slug . '/xem/' . $purchase_voucher_id));
					$message['message'] = 'Phiếu chuyển kho đã lưu!';
					echo json_encode($message);
					exit();
				} else {
					$message['status'] = 'error';
					$message['content'] = null;
					$message['message'] = 'Có lỗi xảy ra! Vui lòng thực hiện lại!';
					echo json_encode($message);
					exit();
				}
			}
		}
		echo json_encode($message);
		exit();
	}

	function admin_content_ajax() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		$message = array();
		$message['status'] = 'error';
		$message['content'] = null;
		$message['message'] = 'Kiểm tra thông tin nhập';

		if(!$this->logged_in()){
			$message['status'] = 'error';
			$message['content'] = null;
			$message['message'] = 'Vui lòng đăng nhập để thực hiện chức năng này!';
			echo json_encode($message);
			exit();
		}

		$post = $this->input->post();
		if (!empty($post)) {
			$this->load->helper('language');
			$this->lang->load('form_validation', 'vietnamese');
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('date', 'Ngày nhập', 'required');

			if ($this->form_validation->run($this)) {
				$err = FALSE;
				$id = (int) $this->input->post('id');

				$current_consignments = array();
				$consignments = array();
				$tblAppendGrid = 'tblAppendGrid_';
				$rowOrder = explode(',', $this->input->post($tblAppendGrid . 'rowOrder'));

				// if (!(is_array($rowOrder) && !empty($rowOrder))) {
				if (isset($rowOrder[0]) && trim($rowOrder[0]) == "") {
					$message['status'] = 'error';
					$message['content'] = $rowOrder;
					$message['message'] = 'Chưa chọn sản phẩm! Vui lòng chọn lại sản phẩm và thực hiện lại!';
					echo json_encode($message);
					exit();
				}
				foreach ($rowOrder as $i) {
					$product_id = $this->input->post($tblAppendGrid . 'product_id' . '_' . $i);
					$product = modules::run('products/get', $product_id);
					$quantity_current = 0;
					$unit_price_current = 0;
					if (isset($product['quantity'])) {
						$quantity_current = $product['quantity'];
					}
					if (isset($product['unit_price'])) {
						$unit_price_current = $product['unit_price'];
					}
					$consignments[] = array(
						'product_id' => $product_id,
						'warehouse_id' => $this->input->post($tblAppendGrid . 'warehouse_id' . '_' . $i),
						'quantity' => $this->input->post($tblAppendGrid . 'quantity' . '_' . $i),
						'quantity_current' => $quantity_current,
						'unit_price' => filter_var($this->input->post($tblAppendGrid . 'unit_price' . '_' . $i), FILTER_SANITIZE_NUMBER_FLOAT),
						'unit_price_current' => $unit_price_current,
						'monetized' => filter_var($this->input->post($tblAppendGrid . 'monetized' . '_' . $i), FILTER_SANITIZE_NUMBER_FLOAT),
						'provider_id' => $this->input->post($tblAppendGrid . 'provider_id' . '_' . $i),
					);
				}
				if (!empty($consignments)) {
					$current_page = $this->input->post('current_page');
					$date = $this->input->post('date');

					$data_purchase_voucher = array(
						'date' => (trim($date) != '') ? get_current_date($date) : 0,
						'note' => $this->input->post('note'),
					);

					if ($id != 0) {
						$row_old = $this->get($id);
						if (isset($row_old['id'])) {
							$row_old['items'] = $this->M_purchase_voucher_details->get_data_in_purchase_voucher_id($row_old['id']);
						}

						$data_purchase_voucher['modified'] = time();
						if (!$this->M_purchase_voucher->update($id, $data_purchase_voucher)) {
							$err = TRUE;
						} else {
							$current_data_output_voucher = $this->M_purchase_voucher_details->get($id);
							if (isset($current_data_output_voucher) && is_array($current_data_output_voucher) && !empty($current_data_output_voucher)) {
								$current_consignments = array_column($current_data_output_voucher, 'quantity', 'product_id');
							}
							$this->M_purchase_voucher_details->delete($id);
						}
						$purchase_voucher_id = $id;
					} else {
						$data_purchase_voucher['code'] = $this->get_code($id);
						$data_purchase_voucher['admin_id'] = 1;
						$data_purchase_voucher['deleted'] = 0;
						$data_purchase_voucher['deleted_by'] = 0;
						$data_purchase_voucher['created'] = time();
						$data_purchase_voucher['modified'] = 0;
						$purchase_voucher_id = $this->M_purchase_voucher->add($data_purchase_voucher);
					}

					if ($purchase_voucher_id != 0) {
						foreach ($consignments as $value) {
							$product = modules::run('products/get', $value['product_id']);
							$total = (int) (isset($product['quantity']) ? $product['quantity'] : 0);
							if (isset($current_consignments) && is_array($current_consignments) && !empty($current_consignments)) {
								if (array_key_exists($value['product_id'], $current_consignments)) {
									$total -= $current_consignments[$value['product_id']];
								}
							}
							$data = array(
								'purchase_voucher_id' => $purchase_voucher_id,
								'product_id' => $value['product_id'],
								'warehouse_id' => $value['warehouse_id'],
								'quantity' => $value['quantity'],
								'quantity_current' => $value['quantity_current'],
								'unit_price' => $value['unit_price'],
								'unit_price_current' => $value['unit_price_current'],
								'monetized' => $value['monetized'],
								'provider_id' => $value['provider_id'],
							);
							if (!$this->M_purchase_voucher_details->add($data)) {
								$err = TRUE;
							} else {
								$this->M_products->update($value['product_id'], array(
									'unit_price' => $value['unit_price'],
									'quantity' => $total + $value['quantity'],
									'modified' => time(),
								));
							}
						}
					} else {
						$err = TRUE;
					}
				}

				if ($err === FALSE) {
					$row_new = $this->get($purchase_voucher_id);
					if (isset($row_new['id'])) {
						$row_new['items'] = $this->M_purchase_voucher_details->get_data_in_purchase_voucher_id($row_new['id']);
					}

					if($id != 0){
						add_activities(array(
							'action' => NULL,
							'activity' => "Người dùng cập nhật nhập hàng #ID: $purchase_voucher_id",
							'data' => serialize(array('old' => $row_old, 'new' => $row_new)),
						));
					}else{
						add_activities(array(
							'action' => NULL,
							'activity' => "Người dùng thêm nhập hàng #ID: $purchase_voucher_id",
							'data' => serialize(array('old' => NULL, 'new' => $row_new)),
						));
					}
					$message['status'] = 'success';
					$message['content'] = array('data' => base_url($this->_module_slug . '/xem/' . $purchase_voucher_id));
					$message['message'] = 'Phiếu nhập đã lưu!';
					echo json_encode($message);
					exit();
					//send mail
					/*$row = $this->get_info($purchase_voucher_id);
					if(is_array($row) && !empty($row)){
						$site_name = $this->_data['site_name'];
		                $subject = "Thông tin mua hàng - " . $this->_data['site_name'];

		                $core_message = $this->load->view('layout/site/partial/html-template-purchase-voucher', $this->_data, true);
		                $data_sendmail = array(
		                    'sender_email' => $this->_data['email'],
		                    'sender_name' => $site_name,
		                    'receiver_email' => array($customer_agrs['email'], $this->_data['email']),
		                    'subject' => $subject,
		                    'message' => $core_message
		                );
		                modules::run('emails/send_mail', $data_sendmail); // gửi mail
					}*/
				} else {
					$message['status'] = 'error';
					$message['content'] = null;
					$message['message'] = 'Có lỗi xảy ra! Vui lòng thực hiện lại!';
					echo json_encode($message);
					exit();
				}
			}
			echo json_encode($message);
			exit();
		}
	}

	function get_code($id, $type = 'import') {
		$this->load->model('purchase_voucher/m_purchase_voucher', 'M_purchase_voucher');
		$code = $this->get_max_code($type);
		while (!$this->M_purchase_voucher->check_code_availablity($code, $id, $type)) {
			$code = $this->get_max_code($type);
		}

		return $code;
	}

	function get_max_code($type = 'import') {
		$args = $this->default_args();
		$order_by = array(
			'code' => 'DESC',
		);
		$args['order_by'] = $order_by;
		$args['type'] = $type;
		$rows = $this->M_purchase_voucher->gets($args, 1, 0);
		$code = (int) (isset($rows[0]['code']) ? filter_var($rows[0]['code'], FILTER_SANITIZE_NUMBER_INT) : 0) + 1;
		if ($type == 'transaction') {
			return WAREHOUSE_TRANSACTION_PREFIX . str_pad($code, WAREHOUSE_TRANSACTION_LENGHT, "0", STR_PAD_LEFT);
		} else {
			return PURCHASE_VOUCHER_PREFIX . str_pad($code, PURCHASE_VOUCHER_LENGHT, "0", STR_PAD_LEFT);
		}
	}

	function check_code_availablity($type = 'import') {
		$this->load->model('purchase_voucher/m_purchase_voucher', 'M_purchase_voucher');
		$post = $this->input->post();
		$this->_message_success = 'true';
		$this->_message_danger = 'false';

		if (!empty($post)) {
			$code = $this->input->post('code');
			$id = $this->input->post('id');
			if ($this->input->post('ajax') == '1') {
				if ($this->M_purchase_voucher->check_code_availablity($code, $id, $type)) {
					$this->_status = "success";
					$this->_message = $this->_message_success;
				} else {
					$this->_status = "danger";
					$this->_message = $this->_message_danger;
				}

				$this->set_json_encode();
				$this->load->view('layout/json_data', $this->_data);
			} else {
				if ($this->M_purchase_voucher->check_code_availablity($code, $id, $type)) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
		} else {
			redirect(base_url());
		}
	}

	function check_code_format($type = 'import') {
		$post = $this->input->post();
		$this->_message_success = 'true';
		$this->_message_danger = 'false';

		if (!empty($post)) {
			if ($this->input->post('ajax') == '1') {
				$code = $this->input->post('code');
				if ($this->is_code_format($code, $type)) {
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
				if ($this->is_code_format($code, $type)) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
		} else {
			redirect(base_url());
		}
	}

	function is_code_format($code = '', $type = 'import') {
		if ($type == 'transaction') {
			$result = preg_match("/" . WAREHOUSE_TRANSACTION_PREFIX . "[0-9]{" . WAREHOUSE_TRANSACTION_LENGHT . "," . WAREHOUSE_TRANSACTION_LENGHT . "}$/", $code);
		} else {
			$result = preg_match("/" . PURCHASE_VOUCHER_PREFIX . "[0-9]{" . PURCHASE_VOUCHER_LENGHT . "," . PURCHASE_VOUCHER_LENGHT . "}$/", $code);
		}
		return ($result == 1) ? TRUE : FALSE;
	}

	function admin_content() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$this->_plugins_css_admin[] = array(
			'folder' => 'jquery.appendGrid',
			'name' => 'jquery-ui.structure.min',
		);
		$this->_plugins_css_admin[] = array(
			'folder' => 'jquery.appendGrid',
			'name' => 'jquery-ui.theme.min',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'jquery.appendGrid',
			'name' => 'jquery-ui-1.11.1.min',
		);
		$this->_plugins_css_admin[] = array(
			'folder' => 'jquery.appendGrid',
			'name' => 'jquery.appendGrid-1.6.2',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'jquery.appendGrid',
			'name' => 'jquery.appendGrid-1.6.2',
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
		$this->_plugins_script_admin[] = array(
			'folder' => 'jquery-validation',
			'name' => 'jquery.validate',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'jquery-validation/localization',
			'name' => 'messages_vi',
		);

		$this->_plugins_script_admin[] = array(
			'folder' => 'jquery-mask',
			'name' => 'jquery.mask',
		);

		$this->_plugins_css_admin[] = array(
			'folder' => 'chosen',
			'name' => 'chosen',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'chosen',
			'name' => 'chosen.jquery',
		);

		$this->set_plugins_admin();

		$this->_modules_script[] = array(
			'folder' => 'purchase_voucher',
			'name' => 'admin-borrow-content',
		);
		$this->set_modules();

		$max_code = $this->get_max_code();
		$this->_data['max_code'] = $max_code;

		$this->_data['provider'] = modules::run('provider/gets');
		$this->_data['category'] = modules::run('category/gets');
		$this->_data['products'] = modules::run('products/gets', array('deleted' => 0));
		$this->_data['warehouse'] = modules::run('purchase_voucher/warehouse/gets');

		$title = 'Phiếu nhập - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
		$id = ($this->uri->segment(3) == '') ? 0 : $this->uri->segment(3);
		if ($id != 0) {
			$this->_data['current_page'] = (int) $this->input->get('current_page');
			$row = $this->get($id);
			$row['items'] = $this->M_purchase_voucher_details->get_data_in_purchase_voucher_id($row['id']);
			$this->_data['row'] = $row;

			$title = 'Cập nhật phiếu nhập - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
		}

		$this->_data['title'] = $title;
		$this->_data['main_content'] = 'purchase_voucher/admin/view_page_content';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}


	function admin_import() {
		//die('asdasd');
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

		$this->set_plugins_admin();

		$this->_modules_script[] = array(
			'folder' => 'purchase_voucher',
			'name' => 'admin-import',
		);
		$this->set_modules();

		$post = $this->input->post();
		if (!empty($post)) {
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('token', 'Don\'t kack to site', 'trim|required');
			$this->form_validation->set_rules('date', 'Ngày nhập', 'required');
			if ($this->form_validation->run($this)) {
				$err = FALSE;
				$quantity = (int) $this->input->post('quantity');
				$warehouse_id = (int) $this->input->post('warehouse_id');
				$provider_id = (int) $this->input->post('provider_id');
				$date = $this->input->post('date');

				$products = modules::run('products/gets', array('deleted' => 0));
				// echo "<pre>";
				// print_r($post);
				// echo "</pre>";
				// die();
				if (is_array($products) && !empty($products)) {
					$data_purchase_voucher = array(
						'date' => (trim($date) != '') ? get_current_date($date) : 0,
						'note' => $this->input->post('note'),
					);
					$data_purchase_voucher['code'] = $this->get_code(0);
					$data_purchase_voucher['admin_id'] = 1;
					$data_purchase_voucher['deleted'] = 0;
					$data_purchase_voucher['deleted_by'] = 0;
					$data_purchase_voucher['created'] = time();
					$data_purchase_voucher['modified'] = 0;
					$purchase_voucher_id = $this->M_purchase_voucher->add($data_purchase_voucher);

					if ($purchase_voucher_id != 0) {
						foreach ($products as $value) {
							$data = array(
								'purchase_voucher_id' => $purchase_voucher_id,
								'product_id' => $value['id'],
								'warehouse_id' => $warehouse_id,
								'quantity' => $quantity,
								'quantity_current' => 0,
								'unit_price' => $value['unit_price'],
								'unit_price_current' => 0,
								'monetized' => $quantity * $value['unit_price'],
								'provider_id' => $provider_id,
							);
							if (!$this->M_purchase_voucher_details->add($data)) {
								$err = TRUE;
							}
						}
					} else {
						$err = TRUE;
					}
				}
				if (!$err) {
					$notify_type = 'success';
					$notify_content = 'Nhập kho hàng loạt sản phẩm thành công!';
					$this->set_notify_admin($notify_type, $notify_content);
					redirect(base_url($this->_module_slug));
				} else {
					$notify_type = 'danger';
					$notify_content = 'Có lỗi xảy ra! Vui lòng kiểm tra lại!';
					$this->set_notify_admin($notify_type, $notify_content);
				}
			}
		}
		$this->_data['provider'] = modules::run('provider/gets');
		$this->_data['warehouse'] = modules::run('purchase_voucher/warehouse/gets');

		$this->_data['title'] = 'Nhập kho hàng loạt sản phẩm - ' . $this->_data['title'];
		$this->_data['main_content'] = 'purchase_voucher/admin/view_page_import';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_transaction_warehouse() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$_breadcrumbs_admin[] = array(
			'url' => '',
			'name' => 'Chuyển kho',
			'image' => base_url('assets/Frest/app-assets/images/svg/ico/ico-input-product.svg'),
		);
		$this->_data['breadcrumbs_admin'] = $_breadcrumbs_admin;

		$this->_plugins_css_admin[] = array(
			'folder' => 'jquery.appendGrid',
			'name' => 'jquery-ui.structure.min',
		);
		$this->_plugins_css_admin[] = array(
			'folder' => 'jquery.appendGrid',
			'name' => 'jquery-ui.theme.min',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'jquery.appendGrid',
			'name' => 'jquery-ui-1.11.1.min',
		);
		$this->_plugins_css_admin[] = array(
			'folder' => 'jquery.appendGrid',
			'name' => 'jquery.appendGrid-1.6.2',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'jquery.appendGrid',
			'name' => 'jquery.appendGrid-1.6.2',
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

		$this->set_plugins_admin();

		$this->_modules_script[] = array(
			'folder' => 'purchase_voucher',
			'name' => 'admin-transaction-warehouse',
		);
		$this->set_modules();

		$max_code = $this->get_max_code('transaction');
		$this->_data['max_code'] = $max_code;

		$this->_data['provider'] = modules::run('provider/gets');
		$this->_data['category'] = modules::run('category/gets');
		$this->_data['products'] = modules::run('products/gets', array('deleted' => 0));
		$this->_data['warehouse'] = modules::run('purchase_voucher/warehouse/gets');

		$title = 'Phiếu chuyển kho - Nhập hàng - ' . $this->_data['title'];
		$id = ($this->uri->segment(3) == '') ? 0 : $this->uri->segment(3);
		if ($id != 0) {
			$this->_data['current_page'] = (int) $this->input->get('current_page');
			$row = $this->get($id);
			$row['items'] = $this->M_purchase_voucher_details->get_data_in_purchase_voucher_id($row['id']);
			$this->_data['row'] = $row;

			$title = 'Cập nhật phiếu chuyển kho - Nhập hàng - ' . $this->_data['title'];
		}

		$this->_data['title'] = $title;
		$this->_data['main_content'] = 'purchase_voucher/admin/view_page_transaction_warehouse_content';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function get_info($id = 0) {
		if ($id != 0) {
			$row = $this->get($id);
			if (is_array($row) && !empty($row)) {
				$row['items'] = $this->M_purchase_voucher_details->get_data_in_purchase_voucher_id($row['id']);
			}
		} else {
			$row = null;
		}
		return $row;
	}

	function admin_view() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$this->_plugins_css_admin[] = array(
			'folder' => 'jquery.appendGrid',
			'name' => 'jquery-ui.structure.min',
		);
		$this->_plugins_css_admin[] = array(
			'folder' => 'jquery.appendGrid',
			'name' => 'jquery-ui.theme.min',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'jquery.appendGrid',
			'name' => 'jquery-ui-1.11.1.min',
		);
		$this->_plugins_css_admin[] = array(
			'folder' => 'jquery.appendGrid',
			'name' => 'jquery.appendGrid-1.6.2',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'jquery.appendGrid',
			'name' => 'jquery.appendGrid-1.6.2',
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

		$this->_plugins_script_admin[] = array(
			'folder' => 'jQuery-Plugin-To-Print-Any-Part-Of-Your-Page-Print',
			'name' => 'jQuery.print',
		);

		$this->set_plugins_admin();

		$this->_modules_script[] = array(
			'folder' => 'purchase_voucher',
			'name' => 'admin-borrow-view',
		);
		$this->set_modules();

		//$this->_data['provider'] = modules::run('provider/gets');
		//$this->_data['products'] = modules::run('products/gets');

		$title = 'Xem phiếu nhập';
		$main_content = 'view_page_view';
		$id = ($this->uri->segment(3) == '') ? 0 : $this->uri->segment(3);
		if ($id != 0) {
			$row = $this->get($id);
			if (!(is_array($row) && !empty($row))) {
				redirect($this->_module_slug);
			}

			$row['items'] = $this->M_purchase_voucher_details->get_data_in_purchase_voucher_id($row['id']);
			$this->_data['row'] = $row;
			if (isset($row['type']) && $row['type'] == 'transaction') {
				$title = 'Xem phiếu chuyển kho';
				$main_content = 'view_page_transaction_warehouse_view';
			}
			$title .= (isset($row['code']) && trim($row['code']) != '' ? ' ' . $row['code'] : '') . ' - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
		} else {
			redirect($this->_module_slug);
		}

		$this->_data['title'] = $title;
		$this->_data['main_content'] = 'purchase_voucher/admin/' . $main_content;
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_delete() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$id = (int) $this->input->get('id');
		$row = $this->get($id);
		if ($id != 0 && !empty($row)) {
			if ($this->M_purchase_voucher->delete($id)) {
				$row['items'] = $this->M_purchase_voucher_details->get_data_in_purchase_voucher_id($row['id']);
				add_activities(array(
					'action' => NULL,
					'activity' => "Người dùng xóa nhập hàng #ID: $id",
					'data' => serialize(array('old' => $row, 'new' => NULL)),
				));
				$this->M_purchase_voucher_details->delete($id);
				//if ($this->M_purchase_voucher->update($id, array('deleted' => 1, 'deleted_by' => $this->_data['userid']))) {
				$notify_type = 'success';
				$notify_content = "Đã xóa nhập hàng!";
			} else {
				$notify_type = 'danger';
				$notify_content = "Chưa xóa nhập hàng!";
			}
		} else {
			$notify_type = 'warning';
			$notify_content = "Nhập hàng không tồn tại!";
		}
		$this->set_notify_admin($notify_type, $notify_content);
		redirect(base_url($this->_module_slug));
	}

	function admin_delete_trash() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$this->_module_slug = 'thung-rac/muon-hang';
		$id = (int) $this->input->get('id');
		$row = $this->get($id);
		if ($id != 0 && !empty($row)) {
			if ($this->M_purchase_voucher->delete($id)) {
				$this->M_purchase_voucher_details->delete($id);
				$notify_type = 'success';
				$notify_content = "Đã xóa nhập hàng!";
			} else {
				$notify_type = 'danger';
				$notify_content = "Chưa xóa nhập hàng!";
			}
		} else {
			$notify_type = 'warning';
			$notify_content = "Nhập hàng không tồn tại!";
		}
		$this->set_notify_admin($notify_type, $notify_content);
		redirect(base_url($this->_module_slug));
	}

	function admin_main() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$post = $this->input->post();
		if (!empty($post)) {
			$action = $this->input->post('action');
			if ($action == 'delete') {
				$this->_message_success = 'Đã xóa các nhập hàng được chọn!';
				$this->_message_warning = 'Bạn chưa chọn nhập hàng nào!';
				$ids = $this->input->post('idcheck');

				if (is_array($ids) && !empty($ids)) {
					foreach ($ids as $id) {
						$row = $this->get($id);
						if ($this->M_purchase_voucher->delete($id)) {
							$this->M_purchase_voucher_details->delete($id);
							//if ($this->M_purchase_voucher->update($id, array('deleted' => 1, 'deleted_by' => $this->_data['userid']))) {
							$notify_type = 'success';
							$notify_content = $this->_message_success;
						} else {
							$notify_type = 'danger';
							$notify_content = $this->_message_danger;
						}
					}
					add_activity("Người dùng xóa các nhập hàng #ID: " . implode(', ', $ids));
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
