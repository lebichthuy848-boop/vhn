<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Warehouse_transaction extends Layout {

    private $_module_slug = 'phieu-nhap/chuyen-kho';

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->_data['module_slug'] = $this->_module_slug;
        $this->_data['breadcrumbs_module_name'] = 'Phiếu nhập';
    }

	private function _validate_access_role(){
		$this->validate_access_role('ROLE_GROUP_WAREHOUSE_TRANSACTION');
	}

    function default_args() {
        $order_by = array(
            'code' => 'ASC'
        );
        $args = array();
        $args['order_by'] = $order_by;
        $args['type'] = 'transaction';

        return $args;
    }

    function counts($args) {
        return $this->M_purchase_voucher->counts($args);
    }

    function get($id) {
        return $this->M_purchase_voucher->get($id);
    }

    function gets() {
        $args = $this->default_args();
        $this->load->model('purchase_voucher/m_purchase_voucher', 'M_purchase_voucher');
        return $this->M_purchase_voucher->gets($args);
    }

    function get_details($id) {
        return $this->M_purchase_voucher_details->get($id);
    }

    function admin_index() {
        $this->_initialize_admin();
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
            'folder' => 'purchase_voucher',
            'name' => 'admin-borrow'
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
        if(is_array($rows) && !empty($rows)){
            foreach ($rows as $key => $value) {
                $rows[$key]['items'] = $this->get_details($value['id']);
            }
        }
        $this->_data['rows'] = $rows;

        $this->_data['title'] = 'Danh sách chuyển kho - ' . $this->_data['title'];
        $this->_data['main_content'] = 'purchase_voucher/admin/view_page_index';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_trash() {
        $this->_initialize_admin();
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
            'folder' => 'purchase_voucher',
            'name' => 'admin-borrow-trash'
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

        $post = $this->input->post();
        if (!empty($post)) {
            $this->load->helper('language');
            $this->lang->load('form_validation', 'vietnamese');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('date', 'Ngày nhập', 'required');
            $message = array();
            $message['status'] = 'error';
            $message['content'] = null;
            $message['message'] = 'Kiểm tra thông tin nhập';

            if ($this->form_validation->run($this)) {
                $err = FALSE;
                $id = (int) $this->input->post('id');

                $current_consignments = array();
                $consignments = array();
                $tblAppendGrid = 'tblAppendGrid_';
                $rowOrder = explode(',', $this->input->post($tblAppendGrid . 'rowOrder'));
                if(is_array($rowOrder) && !empty($rowOrder)){
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
                            'transaction_warehouse_id' => $this->input->post($tblAppendGrid . 'transaction_warehouse_id' . '_' . $i),
                            'quantity' => $this->input->post($tblAppendGrid . 'quantity' . '_' . $i),
                            'quantity_current' => $quantity_current,
                            'unit_price' => filter_var($this->input->post($tblAppendGrid . 'unit_price' . '_' . $i), FILTER_SANITIZE_NUMBER_FLOAT),
                            'unit_price_current' => $unit_price_current,
                            'monetized' => filter_var($this->input->post($tblAppendGrid . 'monetized' . '_' . $i), FILTER_SANITIZE_NUMBER_FLOAT),
                            'provider_id' => $this->input->post($tblAppendGrid . 'provider_id' . '_' . $i)
                        );
                    }
                    if (!empty($consignments)) {
                        $current_page = $this->input->post('current_page');
                        $date = $this->input->post('date');

                        $data_purchase_voucher = array(
                            'type' => 'transaction',
                            'date' => (trim($date) != '') ? get_current_date($date) : 0,
                            'note' => $this->input->post('note')
                        );

                        if ($id != 0) {
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
                                    'transaction_warehouse_id' => $value['transaction_warehouse_id'],
                                    'quantity' => $value['quantity'],
                                    'quantity_current' => $value['quantity_current'],
                                    'unit_price' => $value['unit_price'],
                                    'unit_price_current' => $value['unit_price_current'],
                                    'monetized' => $value['monetized'],
                                    'provider_id' => $value['provider_id']
                                );
                                if (!$this->M_purchase_voucher_details->add($data)) {
                                    $err = TRUE;
                                } else {
                                    $this->M_products->update($value['product_id'], array(
                                        'unit_price' => $value['unit_price'],
                                        'quantity' => $total + $value['quantity'],
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
                        $message['content'] = array('data' => base_url($this->_module_slug . '/xem/' . $purchase_voucher_id));
                        $message['message'] = 'Phiếu nhập đã lưu!';
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

    function admin_content_ajax() {
		if (!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

        $post = $this->input->post();
        if (!empty($post)) {
            $this->load->helper('language');
            $this->lang->load('form_validation', 'vietnamese');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('date', 'Ngày nhập', 'required');
            $message = array();
            $message['status'] = 'error';
            $message['content'] = null;
            $message['message'] = 'Kiểm tra thông tin nhập';

            if ($this->form_validation->run($this)) {
				$err = FALSE;
				$id = (int) $this->input->post('id');

				$current_consignments = array();
				$consignments = array();
				$tblAppendGrid = 'tblAppendGrid_';
				$rowOrder = explode(',', $this->input->post($tblAppendGrid . 'rowOrder'));
				if(is_array($rowOrder) && !empty($rowOrder)){
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
							'provider_id' => $this->input->post($tblAppendGrid . 'provider_id' . '_' . $i)
                        );
                    }
                    if (!empty($consignments)) {
                        $current_page = $this->input->post('current_page');
                        $date = $this->input->post('date');

                        $data_purchase_voucher = array(
                            'date' => (trim($date) != '') ? get_current_date($date) : 0,                            
                            'note' => $this->input->post('note')
                        );

                        if ($id != 0) {
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
									'provider_id' => $value['provider_id']
                                );
                                if (!$this->M_purchase_voucher_details->add($data)) {
                                    $err = TRUE;
                                } else {
                                    $this->M_products->update($value['product_id'], array(
                                        'unit_price' => $value['unit_price'],
                                        'quantity' => $total + $value['quantity'],
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
                        $message['content'] = array('data' => base_url($this->_module_slug . '/xem/' . $purchase_voucher_id));
                        $message['message'] = 'Phiếu nhập đã lưu!';
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

	function get_code($id) {
        $code = $this->get_max_code();
		while (!$this->M_purchase_voucher->check_code_availablity($code, $id)) {
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
        $rows = $this->M_purchase_voucher->gets($args, 1, 0);
        $code = (int) (isset($rows[0]['code']) ? filter_var($rows[0]['code'], FILTER_SANITIZE_NUMBER_INT) : 0) + 1;
        return PURCHASE_VOUCHER_PREFIX . str_pad($code, PURCHASE_VOUCHER_LENGHT, "0", STR_PAD_LEFT);
    }

    function check_code_availablity() {
        $post = $this->input->post();
        $this->_message_success = 'true';
        $this->_message_danger = 'false';

        if (!empty($post)) {
            $code = $this->input->post('code');
            $id = $this->input->post('id');
            if ($this->input->post('ajax') == '1') {
                if ($this->M_purchase_voucher->check_code_availablity($code, $id)) {
                    $this->_status = "success";
                    $this->_message = $this->_message_success;
                } else {
                    $this->_status = "danger";
                    $this->_message = $this->_message_danger;
                }

                $this->set_json_encode();
                $this->load->view('layout/json_data', $this->_data);
            } else {
                if ($this->M_purchase_voucher->check_code_availablity($code, $id)) {
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
        $result = preg_match("/" . PURCHASE_VOUCHER_PREFIX . "[0-9]{" . PURCHASE_VOUCHER_LENGHT . "," . PURCHASE_VOUCHER_LENGHT . "}$/", $code);
        return ($result == 1) ? TRUE : FALSE;
    }

    function admin_content() {
        $this->_initialize_admin();
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
            'folder' => 'purchase_voucher',
            'name' => 'admin-borrow-content'
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

            $title = 'Cập nhật phiếu chuyển kho - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
        }

        $this->_data['title'] = $title;
        $this->_data['main_content'] = 'purchase_voucher/admin/view_page_content';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_transaction_warehouse() {
        $this->_initialize_admin();
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
            'folder' => 'purchase_voucher',
            'name' => 'admin-transaction-warehouse'
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
        $this->_data['main_content'] = 'purchase_voucher/admin/view_page_transaction_warehouse_content';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_view() {
        $this->_initialize_admin();
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
            'folder' => 'purchase_voucher',
            'name' => 'admin-borrow-view'
        );
        $this->set_modules();

        //$this->_data['provider'] = modules::run('provider/gets');
        //$this->_data['products'] = modules::run('products/gets');

        $id = ($this->uri->segment(3) == '') ? 0 : $this->uri->segment(3);
        if ($id != 0) {
            $row = $this->get($id);
            if (!is_array($row) || empty($row)) {
                redirect($this->_module_slug);
            }

            $row['items'] = $this->M_purchase_voucher_details->get_data_in_purchase_voucher_id($row['id']);
            $this->_data['row'] = $row;

            $title = 'Xem phiếu nhập' . (isset($row['code']) && trim($row['code']) != '' ? ' ' . $row['code'] : '') . ' - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
        } else {
            redirect($this->_module_slug);
        }

        $this->_data['title'] = $title;
        $this->_data['main_content'] = 'purchase_voucher/admin/view_page_view';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_delete() {
        $this->_initialize_admin();
        $this->_validate_access_role();

        $id = (int) $this->input->get('id');
        $row = $this->get($id);
        if ($id != 0 && !empty($row)) {
            if ($this->M_purchase_voucher->update($id, array('deleted' => 1, 'deleted_by' => $this->_data['userid']))) {
                $notify_type = 'success';
                $notify_content = "Đã xóa phiếu chuyển kho!";
            } else {
                $notify_type = 'danger';
                $notify_content = "Chưa xóa phiếu chuyển kho!";
            }
        } else {
            $notify_type = 'warning';
            $notify_content = "Phiếu chuyển kho không tồn tại!";
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
                $notify_content = "Đã xóa phiếu chuyển kho!";
            } else {
                $notify_type = 'danger';
                $notify_content = "Chưa xóa phiếu chuyển kho!";
            }
        } else {
            $notify_type = 'warning';
            $notify_content = "Phiếu chuyển kho không tồn tại!";
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
                $this->_message_success = 'Đã xóa các phiếu chuyển kho được chọn!';
                $this->_message_warning = 'Bạn chưa chọn phiếu chuyển kho nào!';
                $ids = $this->input->post('idcheck');

                if (is_array($ids) && !empty($ids)) {
                    foreach ($ids as $id) {
                        $row = $this->get($id);
                        if ($this->M_purchase_voucher->update($id, array('deleted' => 1, 'deleted_by' => $this->_data['userid']))) {
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

/* End of file Warehouse_transaction.php */
/* Location: ./application/modules/purchase_voucher/controllers/Warehouse_transaction.php */