<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Output_voucher extends Layout {

	private $_module_slug = 'phieu-xuat';

	function __construct() {
		parent::__construct();
		$this->_data['module_slug'] = $this->_module_slug;
		$this->_data['breadcrumbs_module_name'] = 'Hóa đơn bán hàng';
		$_breadcrumbs_admin[] = array(
			'url' => '',
			'name' => 'Hóa đơn bán hàng',
			'image' => base_url('assets/Frest/app-assets/images/svg/ico/ico-output-product.svg'),
		);
		//$this->_data['breadcrumbs_admin'] = $_breadcrumbs_admin;
		$this->set_breadcrumbs_admin();
	}

	private function _validate_access_role() {
		$this->validate_access_role('ROLE_GROUP_OUTPUT_VOUCHER');
		// $this->_data['menus'] = $this->_load_menu();
	}

	function is_owned($user_id = 0, $id = 0){
		$row = $this->get($id);
		if(isset($row['created_by']) && $row['created_by'] == $user_id){
			return TRUE;
		}
		return FALSE;
	}

	function admin_confirm_ajax() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		$message = array();
		$message['status'] = 'error';
		$message['content'] = null;
		$message['message'] = 'Kiểm tra thông tin nhập';
		$post = $this->input->post();
		if (!empty($post)) {
			// $message['status'] = 'error';
			// $message['content'] = $post;
			// $message['message'] = show_alert_danger('Có lỗi xảy ra! Vui lòng thực hiện lại!');
			// echo json_encode($message);
			// exit();

			$time = time();
			$id = (int) $this->input->post('id');
			$row = $this->get($id);
			if (!(is_array($row) && !empty($row))) {
				$message['status'] = 'error';
				$message['content'] = null;
				$message['message'] = show_alert_danger('Đơn hàng không tồn tại!');
				echo json_encode($message);
				exit();
			}
			//update
			$status = (int) $this->input->post('status');
			$status_bool = ($status == 1);
			$status_name = ($status_bool ? 'Xác nhận' : 'Hủy');
			if ($row['status'] == 0) {
				if($status_bool){
					$customer_id = $row['customer_id'];
					$customer = modules::run('customers/get', $customer_id);		
					$arrears = isset($customer['arrears']) ? $customer['arrears'] : 0;
					$remainder = isset($row['remainder']) ? $row['remainder'] : 0;
					$this->M_customers->update($customer_id, array('arrears' => $arrears + $remainder));
				}

				$user_id = $verify_by = get_current_user_id();
				$data = array(
					'status' => $status,
					'modified' => $time,
				);
				if ($this->M_output_voucher->update($id, $data)) {
					//update hoa hồng
					$args = array(
						'order_id' => $id,
						'in_action' => array('SUB_BUY_ROOT', 'BUY'),
					);
					$data_commission = array(
						'note' => $status_name . ' hoa hồng mua hàng từ giao diện xem đơn hàng',
						'status' => $status,
						'verified' => $time,
						'verify_by' => $verify_by,
					);
					modules::run('users/users_commission/update', $args, $data_commission);
				}

				$message['status'] = 'success';
				$message['content'] = null;
				$message['message'] = show_alert_success($status_name . ' đơn hàng thành công!');
			} else {
				$message['status'] = 'error';
				$message['content'] = null;
				$message['message'] = show_alert_danger('Có lỗi xảy ra! Vui lòng thực hiện lại!');
			}
		}
		echo json_encode($message);
		exit();
	}

	function admin_change_order_status_ajax() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		$message = array();
		$message['status'] = 'error';
		$message['content'] = null;
		$message['message'] = 'Kiểm tra thông tin nhập';
		$post = $this->input->post();
		if (!empty($post)) {
			$user_id = get_current_user_id();
			if ($user_id == 0) {
				$message['status'] = 'error';
				$message['content'] = null;
				$message['message'] = show_alert_danger('Vui lòng đăng nhập để thực hiện chức năng này!');
				echo json_encode($message);
				exit();
			}

			$time = time();
			$id = (int) $this->input->post('id');
			$row = $this->get($id);
			if (!(is_array($row) && !empty($row))) {
				$message['status'] = 'error';
				$message['content'] = null;
				$message['message'] = show_alert_danger('Đơn hàng không tồn tại!');
				echo json_encode($message);
				exit();
			}
			//update
			$status = (int) $this->input->post('status');
			$data = array(
				'order_status' => $status,
				//'modified' => $time,
			);
			if ($this->M_output_voucher->update($id, $data)) {
				$message['status'] = 'success';
				$message['content'] = display_value_array($this->config->item('output_voucher_order_status_label'), $status);
				$message['message'] = show_alert_success('Thay đổi trạng thái thanh toán thành công!');
			} else {
				$message['status'] = 'error';
				$message['content'] = null;
				$message['message'] = show_alert_danger('Có lỗi xảy ra! Vui lòng thực hiện lại!');
			}
		}
		echo json_encode($message);
		exit();
	}

	function admin_change_delivery_status_ajax() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		$message = array();
		$message['status'] = 'error';
		$message['content'] = null;
		$message['message'] = 'Kiểm tra thông tin nhập';
		$post = $this->input->post();
		if (!empty($post)) {
			$user_id = get_current_user_id();
			if ($user_id == 0) {
				$message['status'] = 'error';
				$message['content'] = null;
				$message['message'] = show_alert_danger('Vui lòng đăng nhập để thực hiện chức năng này!');
				echo json_encode($message);
				exit();
			}

			$time = time();
			$id = (int) $this->input->post('id');
			$row = $this->get($id);
			if (!(is_array($row) && !empty($row))) {
				$message['status'] = 'error';
				$message['content'] = null;
				$message['message'] = show_alert_danger('Đơn hàng không tồn tại!');
				echo json_encode($message);
				exit();
			}
			//update
			$status = (int) $this->input->post('status');
			$data = array(
				'delivery_status' => $status,
				//'modified' => $time,
			);
			if ($this->M_output_voucher->update($id, $data)) {
				$message['status'] = 'success';
				$message['content'] = display_value_array($this->config->item('output_voucher_delivery_status_label'), $status);
				$message['message'] = show_alert_success('Thay đổi tình trạng giao hàng thành công!');
			} else {
				$message['status'] = 'error';
				$message['content'] = null;
				$message['message'] = show_alert_danger('Có lỗi xảy ra! Vui lòng thực hiện lại!');
			}
		}
		echo json_encode($message);
		exit();
	}

	function default_args() {
		$order_by = array(
			'code' => 'DESC',
		);
		$args = array();
		$args['order_by'] = $order_by;
		$args['status'] = 1;

		return $args;
	}

	function counts($args) {
		return $this->M_output_voucher->counts($args);
	}

	function get($id) {
		return $this->M_output_voucher->get($id);
	}

	function gets($options = array()) {
		$default_args = $this->default_args();
		if (is_array($options) && !empty($options)) {
			$args = array_merge($default_args, $options);
		} else {
			$args = $default_args;
		}
		return $this->M_output_voucher->gets($args);
	}

	function get_by($options = array()) {
		$default_args = $this->default_args();
		if (is_array($options) && !empty($options)) {
			$args = array_merge($default_args, $options);
		} else {
			$args = $default_args;
		}
		return $this->M_output_voucher->get_by($args);
	}

	function get_pay_by_customer($customer_id = 0) {
		$prepaid = $remainder = $indebtedness = 0;
		$default_args = $this->default_args();
		$args['customer_id'] = $customer_id;
		$output_voucher = $this->M_output_voucher->gets($args);
		if (is_array($output_voucher) && !empty($output_voucher)) {
			$prepaid = array_sum(array_column($output_voucher, 'prepaid'));
			$remainder = array_sum(array_column($output_voucher, 'remainder'));
			$indebtedness = array_sum(array_column($output_voucher, 'indebtedness'));
		}

		return array(
			'prepaid' => $prepaid,
			'remainder' => $remainder,
			'indebtedness' => $indebtedness,
		);
	}

	function get_amount_by_customer($customer_id = 0) {
		$amount = 0;
		$default_args = $this->default_args();
		$args['customer_id'] = $customer_id;
		$output_voucher = $this->M_output_voucher->gets($args);
		if (is_array($output_voucher) && !empty($output_voucher)) {
			$amount = array_sum(array_column($output_voucher, 'amount'));
		}

		return $amount;
	}

	function get_details($id) {
		return $this->M_output_voucher_details->get($id);
	}

	function admin_report_by_date_export_excel() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$args = $this->default_args();
		$args['deleted'] = 0;
		$rows = $this->M_output_voucher->gets($args);

		if (!is_array($rows) && empty($rows)) {
			$this->_module_slug = 'bao-cao/theo-ngay';

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
			->setTitle("Báo cáo theo ngày")
			->setSubject("Báo cáo theo ngày")
			->setDescription("Báo cáo theo ngày")
			->setKeywords("Báo cáo theo ngày")
			->setCategory("Báo cáo theo ngày");
		$this->excel->getActiveSheet()->setTitle('Báo cáo theo ngày');

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('A1', 'STT')
			->setCellValue('B1', 'Tên khách')
			->setCellValue('C1', 'Số phiếu')
			->setCellValue('D1', 'VAT')
			->setCellValue('E1', 'Mã sản phẩm')
			->setCellValue('F1', 'Tên sản phẩm')
			->setCellValue('G1', 'Đơn vị')
			->setCellValue('H1', 'Số lượng')
			->setCellValue('I1', 'Đơn giá')
			->setCellValue('J1', 'CK')
			->setCellValue('K1', 'Thành tiền')
			->setCellValue('L1', 'Lợi nhuận');

		$this->excel->getActiveSheet()->getStyle("A1:L1")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:L1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('A1:L1')->getFill()->getStartColor()->setARGB('FF0000');
		// Add some data
		$this->excel->getActiveSheet()->getStyle("A1:L1")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:L1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		//Header
		$this->excel->getActiveSheet()->getStyle('A1:L1')->getFont()->applyFromArray($styleHeader);

		//Alignment
		$this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray($styleAlignmentCenter);
		$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->applyFromArray($styleAlignmentCenter);
		$this->excel->getActiveSheet()->getStyle('H1')->getAlignment()->applyFromArray($styleAlignmentRight);

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

		$i = 2;
		$order = 0;
		$total_monetized = 0;
		$total_profit = 0;
		foreach ($rows as $row) {
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

			$order++;
			/*$this->excel->setActiveSheetIndex(0)
				->setCellValue('A' . $i, $order)
				->setCellValue('B' . $i, $row['customer_full_name'])
				->setCellValue('C' . $i, $row['code'])
				->setCellValue('D' . $i, isset($row['VAT']) ? '' : '')
				->setCellValue('E' . $i, isset($row['product_code']) ? '' : '')
				->setCellValue('F' . $i, isset($row['name']) ? '' : '')
				->setCellValue('G' . $i, isset($row['product_unit']) ? '' : '');*/

			$items = $this->get_details($row['id']);
			$count_items = count($items);
			if (is_array($items) && !empty($items)) {
				$j = 0;
				$curent = $i;
				foreach ($items as $value) {
					$j++;
					$monetized = 0;
					$discount = 0;
					$VAT = 0;
					if (isset($items) && is_array($items) && !empty($items)) {
						$arr_monetized = array_column($items, 'monetized');
						$arr_VAT = array_column($items, 'VAT');
						$count = (count($arr_monetized) > count($arr_VAT) ? count($arr_VAT) : count($arr_monetized));
						for ($k = 0; $k < $count; $k++) {
							$VAT += ($arr_VAT[$k] * $arr_monetized[$k] / 100);
						}

						$monetized = array_sum($arr_monetized);
						$discount = array_sum(array_column($items, 'discount'));
					}
					$sub_total_monetized = $monetized + $VAT - $discount;
					$total_monetized += $sub_total_monetized;
					$total_profit += $value['profit'];

					if ($j == 1) {
						$this->excel->setActiveSheetIndex(0)
							->setCellValue('A' . $i, $order)
							->setCellValue('B' . $i, $row['customer_full_name'] . ($i + $count_items))
							->setCellValue('C' . $i, $row['code'] . $i)
							->setCellValue('D' . $i, $value['VAT'])
							->setCellValue('E' . $i, $value['product_code'])
							->setCellValue('F' . $i, $value['name'])
							->setCellValue('G' . $i, $value['product_unit'])
							->setCellValue('H' . $i, $value['quantity'])
							->setCellValue('I' . $i, formatRice($value['unit_price']))
							->setCellValue('J' . $i, 0)
							->setCellValue('K' . $i, formatRice($sub_total_monetized))
							->setCellValue('L' . $i, formatRice($value['profit']));
						$this->excel->setActiveSheetIndex(0)->mergeCells('A' . $i . ':' . 'A' . ($i + $count_items - 1));
						$this->excel->setActiveSheetIndex(0)->mergeCells('B' . $i . ':' . 'B' . ($i + $count_items - 1));
						$this->excel->setActiveSheetIndex(0)->mergeCells('C' . $i . ':' . 'C' . ($i + $count_items - 1));
						$this->excel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->applyFromArray($styleAlignmentVerticalTop);
						$this->excel->getActiveSheet()->getStyle('B' . $i)->getAlignment()->applyFromArray($styleAlignmentVerticalTop);
						$this->excel->getActiveSheet()->getStyle('C' . $i)->getAlignment()->applyFromArray($styleAlignmentVerticalTop);

						//Highlight
						$this->excel->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleHighlight);
						$this->excel->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleHighlight);
					} else {
						$i++;
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
						$this->excel->setActiveSheetIndex(0)
							->setCellValue('D' . $i, $value['VAT'])
							->setCellValue('E' . $i, $value['product_code'])
							->setCellValue('F' . $i, $value['name'])
							->setCellValue('G' . $i, $value['product_unit'])
							->setCellValue('H' . $i, $value['quantity'])
							->setCellValue('I' . $i, formatRice($value['unit_price']))
							->setCellValue('J' . $i, 0)
							->setCellValue('K' . $i, formatRice($sub_total_monetized))
							->setCellValue('L' . $i, formatRice($value['profit']));
					}
					//Highlight
					$this->excel->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleHighlight);

					//Alignment
					$this->excel->getActiveSheet()->getStyle('H' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('I' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('J' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('K' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('L' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
				}
				//$this->excel->setActiveSheetIndex(0)->mergeCells('B' . $curent . ':' . 'B' . ($curent + $count_items));
			}

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

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('A' . $i, 'Tổng cộng')
			->setCellValue('K' . $i, formatRice($total_monetized))
			->setCellValue('L' . $i, formatRice($total_profit));
		$this->excel->setActiveSheetIndex(0)->mergeCells('A' . $i . ':' . 'J' . $i);

		//Total
		$styleTotal = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'FF0000'),
			),
		);
		$this->excel->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleTotal);

		//Alignment
		$this->excel->getActiveSheet()->getStyle('K' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('L' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);

		$filename = 'Bao-cao-theo-ngay_' . date('Y-m-d_H-i-s') . '.xlsx';
		header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}

	function admin_report_by_date() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$this->_module_slug = 'bao-cao/theo-ngay';
		$this->_data['module_slug'] = $this->_module_slug;
		$_breadcrumbs_admin[] = array(
			'url' => '',
			'name' => 'Báo cáo theo ngày',
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

		$this->_plugins_script_admin[] = array(
			'folder' => 'jQuery-Plugin-To-Print-Any-Part-Of-Your-Page-Print',
			'name' => 'jQuery.print',
		);

		$this->set_plugins_admin();

		$this->_modules_script[] = array(
			'folder' => 'output_voucher',
			'name' => 'admin-report-by-date',
		);
		$this->set_modules();

		$get = $this->input->get();
		$this->_data['get'] = $get;

		$this->load->library('calendar');

		$args = $this->default_args();
		$args['deleted'] = 0;

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

		if (!empty($not_in_product_ids)) {
			$args['not_in_id'] = $not_in_product_ids;
		}

		if (isset($get['product_id']) && (((int) $get['product_id']) != 0)) {
			$args['in_id'] = array($get['product_id']);
		} elseif (!empty($product_ids)) {
			$args['in_id'] = $product_ids;
		}

		//theo ngay
		if (isset($get['month']) && trim($get['month']) != '') {
			$time = strtotime("01-" . $get['month']);
		} else {
			$time = time();
		}
		$month_start = strtotime('first day of this month', $time);
		$month_end = strtotime('last day of this month', $time);

		$args['start_date_start'] = get_start_date(date('Y-m-d', $month_start));
		$args['start_date_end'] = get_end_date(date('Y-m-d', $month_end));

		$month = date('m', $time); // var_dump($month);
		$year = date('Y', $time); // var_dump($year);
		$total_days = $this->calendar->get_total_days($month, $year);
		$this->_data['total_days'] = $total_days;

		$data = array();

		for ($i = 1; $i <= $total_days; $i++) {
			$args['start_date_start'] = get_start_date(date('Y-m-d', $month_start));
			$args['start_date_end'] = get_end_date(date('Y-m-d', $month_start));
			//var_dump(date('Y-m-d H:i:s', $args['start_date_start']));
			//var_dump(date('Y-m-d H:i:s', $args['start_date_end']));
			//echo "<br>";

			$count_order = 0;
			$arr_quantity = 0;
			$arr_monetized = 0;
			$total_VAT = 0;
			$sub_total_monetized = 0;
			$sub_profit = 0;
			$total_monetized = 0;
			$total_remainder = 0;

			$rows = $this->M_output_voucher->gets($args);
			if (is_array($rows) && !empty($rows)) {
				$count_order = count($rows);
				foreach ($rows as $key => $row) {
					$VAT = $row['VAT'] / 100;
					$items = $this->get_details($row['id']);

					if (is_array($items) && !empty($items)) {
						$arr_quantity += array_sum(array_column($items, 'quantity'));
						$arr_monetized = (float) array_sum(array_column($items, 'monetized'));
						$arr_profit = (float) array_sum(array_column($items, 'profit'));
						$discount = $arr_monetized * $VAT;
						$sub_total_monetized += $arr_monetized;
						$sub_profit += $arr_profit;

						$total_VAT += $discount;
						$total_monetized += $arr_monetized + $discount;
					}
					//$total_remainder += (float) $row['remainder'];
				}
			}
			$data[$i]['count_order'] = $count_order;
			$data[$i]['quantity'] = $arr_quantity;
			$data[$i]['VAT'] = $total_VAT;
			$data[$i]['monetized'] = $sub_total_monetized;
			$data[$i]['profit'] = $sub_profit;
			$data[$i]['sub_total_monetized'] = $total_monetized;
			$data[$i]['remainder'] = $total_remainder;

			$month_start += 60 * 60 * 24;
		}
		/*
			echo "<pre>";
			print_r($data);
			echo "</pre>";
			die;
		*/

		$this->_data['rows'] = $data;

		$warehouse = modules::run('purchase_voucher/warehouse/gets');
		$this->_data['warehouse'] = $warehouse;

		$this->_data['breadcrumbs_module_name'] = 'Báo cáo';
		$this->_data['breadcrumbs_module_func'] = 'Theo ngày';
		$this->_data['title'] = 'Báo cáo theo ngày';
		$this->_data['main_content'] = 'output_voucher/admin/view_page_report_by_date';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_report_by_date_detail() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$this->_module_slug = 'bao-cao/theo-ngay';
		$this->_data['module_slug'] = $this->_module_slug;
		$this->_module_slug = 'bao-cao/theo-ngay-chi-tiet';

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
			'folder' => 'output_voucher',
			'name' => 'admin-report-by-date',
		);
		$this->set_modules();

		$get = $this->input->get();
		$this->_data['get'] = $get;

		$args = $this->default_args();
		$args['deleted'] = 0;

		//theo ngay
		if (isset($get['date']) && trim($get['date']) != '') {
			$args['start_date_start'] = get_start_date($get['date']);
			$args['start_date_end'] = get_end_date($get['date']);
		} else {
			show_404();
		}
		/*
			echo "<pre>";
			print_r($args);
			echo "</pre>";die;
		*/

		$total = $this->counts($args);
		$perpage = isset($get['per_page']) ? (int) $get['per_page'] : 10;
		$segment = 3;

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

		$this->pagination->initialize($config); # Khởi tạo phân trang

		$pagination = $this->pagination->create_links(); # Tạo link phân trang
		$offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment); # Lấy offset
		$this->_data['current_page'] = (int) $offset;

		$rows = $this->M_output_voucher->gets($args, $perpage, $offset);
		$this->_data['pagination'] = $pagination;

		if (is_array($rows) && !empty($rows)) {
			foreach ($rows as $key => $value) {
				$rows[$key]['items'] = $this->get_details($value['id']);
			}
		}
	
		/*echo "<pre>";
		print_r($rows);
		echo "</pre>";
		die();*/
	
		$this->_data['rows'] = $rows;

		$this->_data['breadcrumbs_module_name'] = 'Báo cáo';
		$this->_data['breadcrumbs_module_func'] = 'Theo ngày ' . $get['date'];
		$this->_data['title'] = 'Báo cáo theo ngày ' . $get['date'];
		$this->_data['main_content'] = 'output_voucher/admin/view_page_report_by_date_detail';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_report_by_product_export_excel() {
		$this->_initialize_admin();
		$this->_validate_access_role();
		$args = array();
		$rows = $this->M_output_voucher_details->gets($args);

		if (!is_array($rows) && empty($rows)) {
			$this->_module_slug = 'bao-cao/mat-hang';

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
			->setTitle("Báo cáo theo mặt hàng")
			->setSubject("Báo cáo theo mặt hàng")
			->setDescription("Báo cáo theo mặt hàng")
			->setKeywords("Báo cáo theo mặt hàng")
			->setCategory("Báo cáo theo mặt hàng");
		$this->excel->getActiveSheet()->setTitle('Báo cáo theo mặt hàng');

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('A1', 'STT')
			->setCellValue('B1', 'Ngày')
			->setCellValue('C1', 'Mã sản phẩm')
			->setCellValue('D1', 'Tên sản phẩm')
			->setCellValue('E1', 'Số lượng')
			->setCellValue('F1', 'Thành tiền')
			->setCellValue('G1', 'Lợi nhuận');

		$this->excel->getActiveSheet()->getStyle("A1:G1")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle('A1:G1')->getFill()->getStartColor()->setARGB('FF0000');
		// Add some data
		$this->excel->getActiveSheet()->getStyle("A1:G1")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1:G1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		//Header
		$this->excel->getActiveSheet()->getStyle('A1:G1')->getFont()->applyFromArray($styleHeader);

		//Alignment
		$this->excel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray($styleAlignmentCenter);
		$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->applyFromArray($styleAlignmentCenter);
		$this->excel->getActiveSheet()->getStyle('H1')->getAlignment()->applyFromArray($styleAlignmentRight);

		$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

		$i = 2;
		$order = 0;
		$total_monetized = 0;
		$total_profit = 0;
		foreach ($rows as $row) {
			$monetized = $row['monetized'];
			$discount = 0;//$row['discount'];
			$VAT = $row['VAT'] * $monetized / 100;

			$sub_total_monetized = $monetized + $VAT - $discount;
			$total_monetized += $sub_total_monetized;
			$total_profit += $row['profit'];
			$this->excel->getActiveSheet()->getStyle('A' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('B' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('C' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('D' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('E' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('F' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('G' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

			$order++;
			$this->excel->setActiveSheetIndex(0)
				->setCellValue('A' . $i, $order)
				->setCellValue('B' . $i, display_date($row['date']))
				->setCellValue('C' . $i, $row['product_code'])
				->setCellValue('D' . $i, $row['name'])
				->setCellValue('E' . $i, ($row['quantity'] . ' ' . $row['product_unit']))
				->setCellValue('F' . $i, formatRice($sub_total_monetized))
				->setCellValue('G' . $i, formatRice($row['profit']));

			//Highlight
			$this->excel->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleHighlight);

			//Alignment
			$this->excel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('B' . $i)->getAlignment()->applyFromArray($styleAlignmentCenter);
			$this->excel->getActiveSheet()->getStyle('F' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('G' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);

			$i++;
		}

		$this->excel->getActiveSheet()->getStyle('A' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('B' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('C' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('D' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('E' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('F' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('G' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('A' . $i, 'Tổng cộng')
			->setCellValue('F' . $i, formatRice($total_monetized))
			->setCellValue('G' . $i, formatRice($total_profit));
		$this->excel->setActiveSheetIndex(0)->mergeCells('A' . $i . ':' . 'E' . $i);

		//Total
		$styleTotal = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'FF0000'),
			),
		);
		$this->excel->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleTotal);

		//Alignment
		$this->excel->getActiveSheet()->getStyle('F' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('G' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);

		$filename = 'Bao-cao-theo-mat-hang_' . date('Y-m-d_H-i-s') . '.xlsx';
		header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}

	function admin_report_by_product() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$this->_module_slug = 'bao-cao/mat-hang';
		$this->_data['module_slug'] = $this->_module_slug;
		$_breadcrumbs_admin[] = array(
			'url' => '',
			'name' => 'Báo cáo theo mặt hàng',
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
			'folder' => 'output_voucher',
			'name' => 'admin-report-by-product',
		);
		$this->set_modules();

		$get = $this->input->get();
		$this->_data['get'] = $get;
		$args = array();

		//theo ngay
		if (isset($get['fromday']) && trim($get['fromday']) != '' && isset($get['today']) && trim($get['today']) != '') {
			$args['start_date_start'] = get_start_date($get['fromday']);
			$args['start_date_end'] = get_end_date($get['today']);
		}

		$args_products = modules::run('products/default_args');
		$args_products['deleted'] = 0;
		if (isset($get['category_id']) && (((int) $get['category_id']) != 0)) {
			$args['category_id'] = $get['category_id'];
			$args_products['category_id'] = $get['category_id'];
		}
		$this->_data['products'] = modules::run('products/gets', $args_products);

		if (isset($get['product_id']) && (((int) $get['product_id']) != 0)) {
			$args['product_id'] = $get['product_id'];
		}

		$total = $this->M_output_voucher_details->counts($args);
		$perpage = isset($get['per_page']) ? (int) $get['per_page'] : 10;
		$segment = 3;

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

		$this->pagination->initialize($config); # Khởi tạo phân trang

		$pagination = $this->pagination->create_links(); # Tạo link phân trang
		$offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment); # Lấy offset
		$this->_data['current_page'] = (int) $offset;

		$rows = $this->M_output_voucher_details->gets($args, $perpage, $offset);
		$this->_data['pagination'] = $pagination;
		$this->_data['rows'] = $rows;
		$this->_data['category'] = modules::run('category/gets');

		$this->_data['breadcrumbs_module_name'] = 'Báo cáo';
		$this->_data['breadcrumbs_module_func'] = 'Theo mặt hàng';
		$this->_data['title'] = 'Báo cáo theo mặt hàng';
		$this->_data['main_content'] = 'output_voucher/admin/view_page_report_by_product';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function cellsToMergeByColsRow($start = -1, $end = -1, $row = -1){
	    $merge = 'A1:A1';
	    if($start>=0 && $end>=0 && $row>=0){
	        $start = PHPExcel_Cell::stringFromColumnIndex($start);
	        $end = PHPExcel_Cell::stringFromColumnIndex($end);
	        $merge = "$start{$row}:$end{$row}";
	    }
	    return $merge;
	}

	function admin_export_excel() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$get = $this->input->get();
		$this->_data['get'] = $get;
		$args = $this->default_args();
		if(isset($args['status'])){
			unset($args['status']);
		}
		if(!(isset($this->_data['role']) && in_array($this->_data['role'], array('ADMIN')))){
			$args['created_by'] = get_current_user_id();
		}

		//theo ngay
		if (isset($get['fromday']) && trim($get['fromday']) != '') {
			$args['start_date_start'] = get_current_date($get['fromday']);
		}
		if (isset($get['today']) && trim($get['today']) != '') {
			$args['start_date_end'] = get_current_date($get['today']);
		}

		if (isset($get['customer_id']) && (int) $get['customer_id'] != 0) {
			$args['customer_id'] = (int) $get['customer_id'];
		}

		if (isset($get['is_indebted']) && (int) $get['is_indebted'] != -1) {
			$args['is_indebted'] = (int) $get['is_indebted'];
		}

		if (isset($get['status']) && trim($get['status']) != '') {
			$args['status'] = (int) $get['status'];
		}

		if (isset($get['order_status']) && trim($get['order_status']) != '') {
			$args['order_status'] = (int) $get['order_status'];
		}

		if (isset($get['q']) && trim($get['q']) != '') {
			$args['q'] = $get['q'];
		}
		$rows = $this->M_output_voucher->gets($args);

		if (!is_array($rows) && empty($rows)) {
			$this->_module_slug = 'bao-cao';

			$notify_type = 'danger';
			$notify_content = 'Chưa có dữ liệu!';
			$this->set_notify_admin($notify_type, $notify_content);
			redirect(base_url($this->_module_slug));
		}

		$this->load->library('excel');

		$glue = '|';
		$firstColumn = 'A';
		$lastColumn = 'J';
		$letterColumn = range($firstColumn, $lastColumn);
		$hideColumn = 'K';

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
			->setTitle("Danh sách hóa đơn bán hàng")
			->setSubject("Danh sách hóa đơn bán hàng")
			->setDescription("Danh sách hóa đơn bán hàng")
			->setKeywords("Danh sách hóa đơn bán hàng")
			->setCategory("Danh sách hóa đơn bán hàng");
		$this->excel->getActiveSheet()->setTitle('Danh sách hóa đơn bán hàng');

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('A1', 'STT')
			->setCellValue('B1', 'Mã hóa đơn')
			->setCellValue('C1', 'Khách hàng')
			->setCellValue('D1', 'Ngày xuất')
			->setCellValue('E1', 'Tình trạng')
			->setCellValue('F1', 'Trạng thái thanh toán')
			->setCellValue('G1', 'Tình trạng giao hàng')
			->setCellValue('H1', 'Tổng số tiền')
			->setCellValue('I1', 'Số tiền trả')
			->setCellValue('J1', 'Số tiền còn lại');

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
		$this->excel->getActiveSheet()->getStyle('E1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('F1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('G1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('H1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);

		foreach ($letterColumn as $column) {
			$this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
		}

		$i = 2;
		$order = 0;
		foreach ($rows as $row) {
			$order++;
			$this->excel->getActiveSheet()->getStyle('A' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('B' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('C' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('D' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('E' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('F' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('G' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('H' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			// $this->excel->getActiveSheet()->getStyle('I' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			// $this->excel->getActiveSheet()->getStyle('J' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

			$this->excel->setActiveSheetIndex(0)
				->setCellValue('A' . $i, $order)
				->setCellValue('B' . $i, $row['code'])
				->setCellValue('C' . $i, $row['customer_full_name'])
				->setCellValue('D' . $i, display_date($row['date']))
				->setCellValue('E' . $i, $row['status'] == 1 ? 'Đơn hàng thành công' : ($row['status'] == 0 ? 'Đã yêu cầu' : 'Đã hủy'))
				->setCellValue('F' . $i, display_value_array($this->config->item('output_voucher_order_status'), $row['order_status']))
				->setCellValue('G' . $i, display_value_array($this->config->item('output_voucher_delivery_status'), $row['delivery_status']))
				->setCellValue('H' . $i, $row['amount'])
				->setCellValue('I' . $i, $row['note_prepaid'])
				->setCellValue('J' . $i, $row['note_remainder']);

			$this->excel->getActiveSheet()->getStyle('G' . $i)->getNumberFormat()->setFormatCode($numberFormat);

			//Highlight
			$this->excel->getActiveSheet()->getStyle('S' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('V' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('W' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('X' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('Y' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('Z' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('AA' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('AB' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('AC' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('AD' . $i)->applyFromArray($styleHighlight);

			//Alignment
			$this->excel->getActiveSheet()->getStyle('D' . $i)->getAlignment()->applyFromArray($styleAlignmentCenter);
			$i++;
		}

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('A' . $i, 'Tổng cộng')
			->setCellValue('H' . $i, '=SUM(H2:H' . ($i -1) . ')');
		$this->excel->setActiveSheetIndex(0)->mergeCells('A' . $i . ':' . 'G' . $i);

		$this->excel->getActiveSheet()->getStyle("H$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);
		// $this->excel->getActiveSheet()->getStyle("AC$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);
		// $this->excel->getActiveSheet()->getStyle("AD$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);

		//Total
		$styleTotal = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'FF0000'),
			),
		);
		$this->excel->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleTotal);
		// $this->excel->getActiveSheet()->getStyle('AB' . $i)->applyFromArray($styleTotal);
		// $this->excel->getActiveSheet()->getStyle('AC' . $i)->applyFromArray($styleTotal);
		// $this->excel->getActiveSheet()->getStyle('AD' . $i)->applyFromArray($styleTotal);

		//Alignment
		// $this->excel->getActiveSheet()->getStyle('AA' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		// $this->excel->getActiveSheet()->getStyle('AB' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		// $this->excel->getActiveSheet()->getStyle('AC' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		// $this->excel->getActiveSheet()->getStyle('AD' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);

		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . ($i))->applyFromArray(
		    array(
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN,
		            )
		        )
		    )
		);

		$filename = 'Danh-sach-hoa-don-ban-hang_' . date('Y-m-d_H-i-s') . '.xlsx';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename='.$filename);
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$objWriter->save('php://output');
	}

	function admin_report_export_excel() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$get = $this->input->get();
		$this->_data['get'] = $get;
		$args = array();
		$order_by = array(
			'code' => 'DESC',
			'created' => 'DESC',
		);
		$args['order_by'] = $order_by;
		$args['order_by_custom'] = TRUE;

		//theo ngay
		if (isset($get['fromday']) && trim($get['fromday']) != '' && isset($get['today']) && trim($get['today']) != '') {
			$args['start_date_start'] = get_start_date($get['fromday']);
			$args['start_date_end'] = get_end_date($get['today']);
		}
		$rows = $this->M_output_voucher->gets($args);
		// $rows = $this->M_output_voucher->gets($args, 10, 0);

		if (!is_array($rows) && empty($rows)) {
			$this->_module_slug = 'bao-cao';

			$notify_type = 'danger';
			$notify_content = 'Chưa có dữ liệu!';
			$this->set_notify_admin($notify_type, $notify_content);
			redirect(base_url($this->_module_slug));
		}

		$this->load->library('excel');

		$glue = '|';
		$firstColumn = 'A';
		$lastColumn = 'AD';
		$letterColumn = range($firstColumn, 'Z');
		$hideColumn = 'AC';

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
			->setTitle("Báo cáo")
			->setSubject("Báo cáo")
			->setDescription("Báo cáo")
			->setKeywords("Báo cáo")
			->setCategory("Báo cáo");
		$this->excel->getActiveSheet()->setTitle('Báo cáo');

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('A1', 'STT')
			->setCellValue('B1', 'Mã hóa đơn')
			->setCellValue('C1', 'Thời gian tạo')
			->setCellValue('D1', 'Mã khách hàng')
			->setCellValue('E1', 'Tên khách hàng')
			->setCellValue('F1', 'Email')
			->setCellValue('G1', 'Điện thoại')
			->setCellValue('H1', 'Địa chỉ (Khách hàng)')
			->setCellValue('I1', 'Người bán')
			->setCellValue('J1', 'Kênh bán')
			->setCellValue('K1', 'Người tạo')
			->setCellValue('L1', 'Ghi chú')
			->setCellValue('M1', 'Tổng tiền hàng')
			->setCellValue('N1', 'Giảm giá hóa đơn')
			->setCellValue('O1', 'Khách cần trả')
			->setCellValue('P1', 'Trạng thái')
			->setCellValue('Q1', 'Trạng thái giao hàng')
			->setCellValue('R1', 'Mã hàng')
			->setCellValue('S1', 'Tên hàng')
			->setCellValue('T1', 'Thương hiệu')
			->setCellValue('U1', 'ĐVT')
			->setCellValue('V1', 'Số lượng')
			->setCellValue('W1', "Đơn giá\rbán lẻ")
			->setCellValue('X1', 'Giảm giá %')
			->setCellValue('Y1', 'Giảm giá')
			->setCellValue('Z1', "Giá bán\rđơn vị")
			->setCellValue('AA1', "Thành tiền\r(bao gồm VAT)")
			->setCellValue('AB1', '% VAT')
			->setCellValue('AC1', "Doanh thu\r(chưa VAT)")
			->setCellValue('AD1', 'VAT');

		$this->excel->getActiveSheet()->getStyle('W1')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('Z1')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('AA1')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('AC1')->getAlignment()->setWrapText(true);

		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFill()->getStartColor()->setARGB('FF0000');
		// Add some data
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		//Header
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFont()->applyFromArray($styleHeader);

		//Alignment
		$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->applyFromArray($styleAlignmentCenter);
		$this->excel->getActiveSheet()->getStyle('P1')->getAlignment()->applyFromArray($styleAlignmentCenter);

		$this->excel->getActiveSheet()->getStyle('G1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('M1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('N1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('O1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('V1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('W1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('X1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('Y1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('Z1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AA1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AB1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AC1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AD1')->getAlignment()->applyFromArray($styleAlignmentRight);

		//Highlight Header
		$fillHighlightHeader = '92d050';
		$this->excel->getActiveSheet()->getStyle('W1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('Z1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('AA1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('AB1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('AC1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('AD1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);

		foreach ($letterColumn as $column) {
			$this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
		}
		$this->excel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);

		$i = 2;
		$order = 0;
		foreach ($rows as $value) {
			$items = $this->get_details($value['id']);
			if (is_array($items) && !empty($items)) {
				$order++;
				$j = 0;
				$start = $i;
				$end = count($items) - 1;
				foreach ($items as $row) {
					$A = $row['unit_price'];
					$P1 = $row['price_discount_percent'];
					$G1 = $A * $P1 / 100;//$row['price_discount'];
					$Z1 = $A - $G1;

					$P2 = $value['discount_percent'];
					$G2 = $Z1 * $P2 / 100;
					$Z2 = $Z1 - $G2;

					// $P = $Z2 * 100 / $A;
					// $total_percent = (100 - $P) / 100;
					$total_discount = $A - $Z2;
					$total_percent = 0;
					if($A != 0){
						$total_percent = $total_discount * 100 / $A;
					}
					// if($j == 0){
						$this->excel->setActiveSheetIndex(0)
						->setCellValue('A' . $i, $order)
						->setCellValue('B' . $i, $value['code'])
						->setCellValue('C' . $i, display_date($value['date']))
						->setCellValue('D' . $i, $value['customer_code'])
						->setCellValue('E' . $i, $value['customer_full_name'])
						->setCellValue('F' . $i, $value['customer_email'])
						->setCellValue('G' . $i, $value['customer_phone'])
						->setCellValue('H' . $i, $value['customer_address'])
						->setCellValue('I' . $i, $value['full_name'])
						->setCellValue('J' . $i, '')
						->setCellValue('K' . $i, $value['full_name'])
						->setCellValue('L' . $i, $value['note'])
						->setCellValue('M' . $i, $value['amount'])
						->setCellValue('N' . $i, $value['discount'])
						->setCellValue('O' . $i, $value['monetized'])
						// ->setCellValue('F' . $i, display_value_array($this->config->item('output_voucher_order_status'), $row['order_status']))
						->setCellValue('P' . $i, display_value_array($this->config->item('output_voucher_status'), $value['status']))
						->setCellValue('Q' . $i, display_value_array($this->config->item('output_voucher_delivery_status'), $value['delivery_status']));
						$this->excel->getActiveSheet()->setCellValueExplicit('G' . $i, strval($value['customer_phone']), PHPExcel_Cell_DataType::TYPE_STRING);
					// }
					/*if($j == $end){
						$mergeColumns = range('A', 'Q');
						foreach ($mergeColumns as $column) {
							$this->excel->setActiveSheetIndex(0)->mergeCells($column . $start . ':' . $column . ($start + $end));
							$this->excel->setActiveSheetIndex(0)->getStyle($column . $start)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							$this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
						}
					}*/
					$this->excel->getActiveSheet()->getStyle('A' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('B' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('C' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('D' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('E' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('F' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('G' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

					$this->excel->setActiveSheetIndex(0)
						->setCellValue('R' . $i, $row['product_code'])
						->setCellValue('S' . $i, $row['product_name'])
						->setCellValue('T' . $i, $row['product_origin'])
						->setCellValue('U' . $i, $row['product_unit'])
						->setCellValue('V' . $i, $row['quantity'])
						->setCellValue('W' . $i, $A)
						->setCellValue('X' . $i, $total_percent / 100)
						// ->setCellValue('X' . $i, ($row['price_discount_percent']/100) + ($value['discount_percent'] * $row['price_discount_percent'])/(100 * 100))
						->setCellValue('Y' . $i, $total_discount)
						// ->setCellValue('Y' . $i, '=W' . $i . '*X' . $i)
						->setCellValue('Z' . $i, $Z2)
						// ->setCellValue('Z' . $i, '=W' . $i . '-Y'. $i)
						->setCellValue('AA' . $i, '=Z' . $i . '*V'. $i)
						->setCellValue('AB' . $i, $row['VAT']/100)
						->setCellValue('AC' . $i, '=AA' . $i . '/(1+AB'. $i .')')
						->setCellValue('AD' . $i, '=+AB' . $i . '*AC'. $i);

					$this->excel->getActiveSheet()->setCellValueExplicit('R' . $i, strval($row['product_code']), PHPExcel_Cell_DataType::TYPE_STRING);

					$this->excel->getActiveSheet()->getStyle('M' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('N' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('O' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('V' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('W' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('X' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
					$this->excel->getActiveSheet()->getStyle('Y' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('Z' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('AA' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('AB' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
					$this->excel->getActiveSheet()->getStyle('AC' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('AD' . $i)->getNumberFormat()->setFormatCode($numberFormat);

					//Highlight
					$this->excel->getActiveSheet()->getStyle('S' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('V' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('W' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('X' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('Y' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('Z' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('AA' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('AB' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('AC' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('AD' . $i)->applyFromArray($styleHighlight);

					//Alignment
					$this->excel->getActiveSheet()->getStyle('C' . $i)->getAlignment()->applyFromArray($styleAlignmentCenter);
					$this->excel->getActiveSheet()->getStyle('P' . $i)->getAlignment()->applyFromArray($styleAlignmentCenter);

					$this->excel->getActiveSheet()->getStyle('G' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('M' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('N' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('O' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('V' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('W' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('X' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('Y' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('Z' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('AA' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('AB' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('AC' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('AD' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$j++;
					$i++;
				}
			}
		}

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('A' . $i, 'Tổng cộng')
			->setCellValue('AA' . $i, '=SUM(AA2:AA' . ($i -1) . ')')
			->setCellValue('AC' . $i, '=SUM(AC2:AC' . ($i -1) . ')')
			->setCellValue('AD' . $i, '=SUM(AD2:AD' . ($i -1) . ')');
		$this->excel->setActiveSheetIndex(0)->mergeCells('A' . $i . ':' . 'Z' . $i);

		$this->excel->getActiveSheet()->getStyle("AA$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);
		$this->excel->getActiveSheet()->getStyle("AC$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);
		$this->excel->getActiveSheet()->getStyle("AD$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);

		//Total
		$styleTotal = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'FF0000'),
			),
		);
		$this->excel->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('AA' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('AB' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('AC' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('AD' . $i)->applyFromArray($styleTotal);

		//Alignment
		$this->excel->getActiveSheet()->getStyle('AA' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AB' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AC' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AD' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);

		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . ($i))->applyFromArray(
		    array(
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN,
		            )
		        )
		    )
		);

		$sheet = $this->excel->getActiveSheet();
		$cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(true);
		foreach($cellIterator as $cell) {
	        $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
		}

		//$this->excel->getActiveSheet()->getColumnDimension($hideColumn)->setVisible(false);

		$filename = 'Bao-cao_' . date('Y-m-d_H-i-s') . '.xlsx';
		header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}

	function admin_report_export_excel_15_02_2023() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$get = $this->input->get();
		$this->_data['get'] = $get;
		$args = array();
		$order_by = array(
			'code' => 'DESC',
			'created' => 'DESC',
		);
		$args['order_by'] = $order_by;
		$args['order_by_custom'] = TRUE;

		//theo ngay
		if (isset($get['fromday']) && trim($get['fromday']) != '' && isset($get['today']) && trim($get['today']) != '') {
			$args['start_date_start'] = get_start_date($get['fromday']);
			$args['start_date_end'] = get_end_date($get['today']);
		}
		$rows = $this->M_output_voucher->gets($args);

		if (!is_array($rows) && empty($rows)) {
			$this->_module_slug = 'bao-cao';

			$notify_type = 'danger';
			$notify_content = 'Chưa có dữ liệu!';
			$this->set_notify_admin($notify_type, $notify_content);
			redirect(base_url($this->_module_slug));
		}

		$this->load->library('excel');

		$glue = '|';
		$firstColumn = 'A';
		$lastColumn = 'AD';
		$letterColumn = range($firstColumn, 'Z');
		$hideColumn = 'AC';

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
			->setTitle("Báo cáo")
			->setSubject("Báo cáo")
			->setDescription("Báo cáo")
			->setKeywords("Báo cáo")
			->setCategory("Báo cáo");
		$this->excel->getActiveSheet()->setTitle('Báo cáo');

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('A1', 'STT')
			->setCellValue('B1', 'Mã hóa đơn')
			->setCellValue('C1', 'Thời gian tạo')
			->setCellValue('D1', 'Mã khách hàng')
			->setCellValue('E1', 'Tên khách hàng')
			->setCellValue('F1', 'Email')
			->setCellValue('G1', 'Điện thoại')
			->setCellValue('H1', 'Địa chỉ (Khách hàng)')
			->setCellValue('I1', 'Người bán')
			->setCellValue('J1', 'Kênh bán')
			->setCellValue('K1', 'Người tạo')
			->setCellValue('L1', 'Ghi chú')
			->setCellValue('M1', 'Tổng tiền hàng')
			->setCellValue('N1', 'Giảm giá hóa đơn')
			->setCellValue('O1', 'Khách cần trả')
			->setCellValue('P1', 'Trạng thái')
			->setCellValue('Q1', 'Trạng thái giao hàng')
			->setCellValue('R1', 'Mã hàng')
			->setCellValue('S1', 'Tên hàng')
			->setCellValue('T1', 'Thương hiệu')
			->setCellValue('U1', 'ĐVT')
			->setCellValue('V1', 'Số lượng')
			->setCellValue('W1', "Đơn giá\rbán lẻ")
			->setCellValue('X1', 'Giảm giá %')
			->setCellValue('Y1', 'Giảm giá')
			->setCellValue('Z1', "Giá bán\rđơn vị")
			->setCellValue('AA1', "Thành tiền\r(bao gồm VAT)")
			->setCellValue('AB1', '% VAT')
			->setCellValue('AC1', "Doanh thu\r(chưa VAT)")
			->setCellValue('AD1', 'VAT');

		$this->excel->getActiveSheet()->getStyle('W1')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('Z1')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('AA1')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('AC1')->getAlignment()->setWrapText(true);

		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFill()->getStartColor()->setARGB('FF0000');
		// Add some data
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		//Header
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFont()->applyFromArray($styleHeader);

		//Alignment
		$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->applyFromArray($styleAlignmentCenter);
		$this->excel->getActiveSheet()->getStyle('P1')->getAlignment()->applyFromArray($styleAlignmentCenter);

		$this->excel->getActiveSheet()->getStyle('G1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('M1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('N1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('O1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('V1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('W1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('X1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('Y1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('Z1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AA1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AB1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AC1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AD1')->getAlignment()->applyFromArray($styleAlignmentRight);

		//Highlight Header
		$fillHighlightHeader = '92d050';
		$this->excel->getActiveSheet()->getStyle('W1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('Z1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('AA1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('AB1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('AC1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('AD1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);

		foreach ($letterColumn as $column) {
			$this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
		}
		$this->excel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);

		$i = 2;
		$order = 0;
		foreach ($rows as $value) {
			$items = $this->get_details($value['id']);
			if (is_array($items) && !empty($items)) {
				$order++;
				$j = 0;
				$start = $i;
				$end = count($items) - 1;
				foreach ($items as $row) {
					$A = $row['unit_price'];
					$P1 = $row['price_discount_percent'];
					$G1 = $A * $P1 / 100;//$row['price_discount'];
					$Z1 = $A - $G1;

					$P2 = $value['discount_percent'];
					$G2 = $Z1 * $P2 / 100;
					$Z2 = $Z1 - $G2;

					// $P = $Z2 * 100 / $A;
					// $total_percent = (100 - $P) / 100;
					$total_discount = $A - $Z2;
					$total_percent = 0;
					if($A != 0){
						$total_percent = $total_discount * 100 / $A;
					}
					if($j == 0){
						$this->excel->setActiveSheetIndex(0)
						->setCellValue('A' . $i, $order)
						->setCellValue('B' . $i, $value['code'])
						->setCellValue('C' . $i, display_date($value['date']))
						->setCellValue('D' . $i, $value['customer_code'])
						->setCellValue('E' . $i, $value['customer_full_name'])
						->setCellValue('F' . $i, $value['customer_email'])
						->setCellValue('G' . $i, $value['customer_phone'])
						->setCellValue('H' . $i, $value['customer_address'])
						->setCellValue('I' . $i, $value['full_name'])
						->setCellValue('J' . $i, '')
						->setCellValue('K' . $i, $value['full_name'])
						->setCellValue('L' . $i, $value['note'])
						->setCellValue('M' . $i, $value['amount'])
						->setCellValue('N' . $i, $value['discount'])
						->setCellValue('O' . $i, $value['monetized'])
						// ->setCellValue('F' . $i, display_value_array($this->config->item('output_voucher_order_status'), $row['order_status']))
						->setCellValue('P' . $i, display_value_array($this->config->item('output_voucher_status'), $value['status']))
						->setCellValue('Q' . $i, display_value_array($this->config->item('output_voucher_delivery_status'), $value['delivery_status']));
						$this->excel->getActiveSheet()->setCellValueExplicit('G' . $i, strval($value['customer_phone']), PHPExcel_Cell_DataType::TYPE_STRING);
					}
					if($j == $end){
						$mergeColumns = range('A', 'Q');
						foreach ($mergeColumns as $column) {
							$this->excel->setActiveSheetIndex(0)->mergeCells($column . $start . ':' . $column . ($start + $end));
							$this->excel->setActiveSheetIndex(0)->getStyle($column . $start)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							$this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
						}
					}
					$this->excel->getActiveSheet()->getStyle('A' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('B' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('C' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('D' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('E' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('F' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('G' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

					$this->excel->setActiveSheetIndex(0)
						->setCellValue('R' . $i, $row['product_code'])
						->setCellValue('S' . $i, $row['product_name'])
						->setCellValue('T' . $i, $row['product_origin'])
						->setCellValue('U' . $i, $row['product_unit'])
						->setCellValue('V' . $i, $row['quantity'])
						->setCellValue('W' . $i, $A)
						->setCellValue('X' . $i, $total_percent / 100)
						// ->setCellValue('X' . $i, ($row['price_discount_percent']/100) + ($value['discount_percent'] * $row['price_discount_percent'])/(100 * 100))
						->setCellValue('Y' . $i, $total_discount)
						// ->setCellValue('Y' . $i, '=W' . $i . '*X' . $i)
						->setCellValue('Z' . $i, $Z2)
						// ->setCellValue('Z' . $i, '=W' . $i . '-Y'. $i)
						->setCellValue('AA' . $i, '=Z' . $i . '*V'. $i)
						->setCellValue('AB' . $i, $row['VAT']/100)
						->setCellValue('AC' . $i, '=AA' . $i . '/(1+AB'. $i .')')
						->setCellValue('AD' . $i, '=+AB' . $i . '*AC'. $i);

					$this->excel->getActiveSheet()->setCellValueExplicit('R' . $i, strval($row['product_code']), PHPExcel_Cell_DataType::TYPE_STRING);

					$this->excel->getActiveSheet()->getStyle('M' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('N' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('O' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('V' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('W' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('X' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
					$this->excel->getActiveSheet()->getStyle('Y' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('Z' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('AA' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('AB' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
					$this->excel->getActiveSheet()->getStyle('AC' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('AD' . $i)->getNumberFormat()->setFormatCode($numberFormat);

					//Highlight
					$this->excel->getActiveSheet()->getStyle('S' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('V' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('W' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('X' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('Y' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('Z' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('AA' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('AB' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('AC' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('AD' . $i)->applyFromArray($styleHighlight);

					//Alignment
					$this->excel->getActiveSheet()->getStyle('C' . $i)->getAlignment()->applyFromArray($styleAlignmentCenter);
					$this->excel->getActiveSheet()->getStyle('P' . $i)->getAlignment()->applyFromArray($styleAlignmentCenter);

					$this->excel->getActiveSheet()->getStyle('G' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('M' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('N' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('O' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('V' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('W' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('X' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('Y' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('Z' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('AA' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('AB' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('AC' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('AD' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$j++;
					$i++;
				}
			}
		}

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('A' . $i, 'Tổng cộng')
			->setCellValue('AA' . $i, '=SUM(AA2:AA' . ($i -1) . ')')
			->setCellValue('AC' . $i, '=SUM(AC2:AC' . ($i -1) . ')')
			->setCellValue('AD' . $i, '=SUM(AD2:AD' . ($i -1) . ')');
		$this->excel->setActiveSheetIndex(0)->mergeCells('A' . $i . ':' . 'Z' . $i);

		$this->excel->getActiveSheet()->getStyle("AA$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);
		$this->excel->getActiveSheet()->getStyle("AC$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);
		$this->excel->getActiveSheet()->getStyle("AD$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);

		//Total
		$styleTotal = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'FF0000'),
			),
		);
		$this->excel->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('AA' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('AB' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('AC' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('AD' . $i)->applyFromArray($styleTotal);

		//Alignment
		$this->excel->getActiveSheet()->getStyle('AA' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AB' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AC' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AD' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);

		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . ($i))->applyFromArray(
		    array(
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN,
		            )
		        )
		    )
		);

		$sheet = $this->excel->getActiveSheet();
		$cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(true);
		foreach($cellIterator as $cell) {
	        $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
		}

		//$this->excel->getActiveSheet()->getColumnDimension($hideColumn)->setVisible(false);

		$filename = 'Bao-cao_' . date('Y-m-d_H-i-s') . '.xlsx';
		header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}

	function admin_report_export_excel_bk2() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$get = $this->input->get();
		$this->_data['get'] = $get;
		$args = array();
		$order_by = array(
			'code' => 'DESC',
			'created' => 'DESC',
		);
		$args['order_by'] = $order_by;
		$args['order_by_custom'] = TRUE;

		//theo ngay
		if (isset($get['fromday']) && trim($get['fromday']) != '' && isset($get['today']) && trim($get['today']) != '') {
			$args['start_date_start'] = get_start_date($get['fromday']);
			$args['start_date_end'] = get_end_date($get['today']);
		}
		$rows = $this->M_output_voucher->gets($args);

		if (!is_array($rows) && empty($rows)) {
			$this->_module_slug = 'bao-cao';

			$notify_type = 'danger';
			$notify_content = 'Chưa có dữ liệu!';
			$this->set_notify_admin($notify_type, $notify_content);
			redirect(base_url($this->_module_slug));
		}

		$this->load->library('excel');

		$glue = '|';
		$firstColumn = 'A';
		$lastColumn = 'AF';
		$letterColumn = range($firstColumn, 'Z');
		$hideColumn = 'AG';

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
			->setTitle("Báo cáo")
			->setSubject("Báo cáo")
			->setDescription("Báo cáo")
			->setKeywords("Báo cáo")
			->setCategory("Báo cáo");
		$this->excel->getActiveSheet()->setTitle('Báo cáo');

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('A1', 'STT')
			->setCellValue('B1', 'Mã hóa đơn')
			->setCellValue('C1', 'Thời gian tạo')
			->setCellValue('D1', 'Mã khách hàng')
			->setCellValue('E1', 'Tên khách hàng')
			->setCellValue('F1', 'Email')
			->setCellValue('G1', 'Điện thoại')
			->setCellValue('H1', 'Địa chỉ (Khách hàng)')
			->setCellValue('I1', 'Người bán')
			->setCellValue('J1', 'Kênh bán')
			->setCellValue('K1', 'Người tạo')
			->setCellValue('L1', 'Ghi chú')
			->setCellValue('M1', 'Tổng tiền hàng')
			->setCellValue('N1', 'Giảm giá hóa đơn')
			->setCellValue('O1', 'Khách cần trả')
			->setCellValue('P1', 'Trạng thái')
			->setCellValue('Q1', 'Trạng thái giao hàng')
			->setCellValue('R1', 'Mã hàng')
			->setCellValue('S1', 'Tên hàng')
			->setCellValue('T1', 'Thương hiệu')
			->setCellValue('U1', 'ĐVT')
			->setCellValue('V1', 'Số lượng')
			->setCellValue('W1', "Đơn giá\rbán lẻ")
			->setCellValue('X1', 'Giảm giá %')
			->setCellValue('Y1', 'Giảm giá')
			->setCellValue('Z1', "Giá bán\rđơn vị")
			->setCellValue('AA1', "Thành tiền\r(bao gồm VAT)")
			->setCellValue('AB1', '% VAT')
			->setCellValue('AC1', "Doanh thu\r(chưa VAT)")
			->setCellValue('AD1', "CK tổng")
			->setCellValue('AE1', "Doanh thu sau CK\r(chưa VAT)")
			->setCellValue('AF1', 'VAT');

		$this->excel->getActiveSheet()->getStyle('W1')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('Z1')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('AA1')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('AC1')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('AE1')->getAlignment()->setWrapText(true);

		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFill()->getStartColor()->setARGB('FF0000');
		// Add some data
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		//Header
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFont()->applyFromArray($styleHeader);

		//Alignment
		$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->applyFromArray($styleAlignmentCenter);
		$this->excel->getActiveSheet()->getStyle('P1')->getAlignment()->applyFromArray($styleAlignmentCenter);

		$this->excel->getActiveSheet()->getStyle('G1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('M1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('N1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('O1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('V1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('W1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('X1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('Y1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('Z1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AA1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AB1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AC1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AD1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AE1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AF1')->getAlignment()->applyFromArray($styleAlignmentRight);

		//Highlight Header
		$fillHighlightHeader = '92d050';
		$this->excel->getActiveSheet()->getStyle('W1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('Z1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('AA1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('AB1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('AC1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('AD1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('AE1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('AF1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);

		foreach ($letterColumn as $column) {
			$this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
		}
		$this->excel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);

		$i = 2;
		$order = 0;
		foreach ($rows as $value) {
			$items = $this->get_details($value['id']);
			if (is_array($items) && !empty($items)) {
				$order++;
				$j = 0;
				$start = $i;
				$end = count($items) - 1;
				foreach ($items as $row) {
					if($j == 0){
						$this->excel->setActiveSheetIndex(0)
						->setCellValue('A' . $i, $order)
						->setCellValue('B' . $i, $value['code'])
						->setCellValue('C' . $i, display_date($value['date']))
						->setCellValue('D' . $i, $value['customer_code'])
						->setCellValue('E' . $i, $value['customer_full_name'])
						->setCellValue('F' . $i, $value['customer_email'])
						->setCellValue('G' . $i, $value['customer_phone'])
						->setCellValue('H' . $i, $value['customer_address'])
						->setCellValue('I' . $i, $value['full_name'])
						->setCellValue('J' . $i, '')
						->setCellValue('K' . $i, $value['full_name'])
						->setCellValue('L' . $i, $value['note'])
						->setCellValue('P' . $i, $value['status'] == 1 ? 'Hoàn thành' : ($value['status'] == 0 ? 'Đã yêu cầu' : 'Đã hủy'))
						->setCellValue('Q' . $i, $value['order_status'] == 1 ? 'Đã thanh toán' : 'Chưa thanh toán')
						->setCellValue('M' . $i, $value['amount'])
						->setCellValue('N' . $i, $value['discount'])
						->setCellValue('O' . $i, $value['monetized'])
						->setCellValue('AD' . $i, $value['discount_percent']/100);
						$this->excel->getActiveSheet()->setCellValueExplicit('G' . $i, strval($value['customer_phone']), PHPExcel_Cell_DataType::TYPE_STRING);
						$this->excel->getActiveSheet()->getStyle('AD' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
					}
					if($j == $end){
						$mergeColumns = range('A', 'Q');
						$mergeColumns[] = 'AD';
						foreach ($mergeColumns as $column) {
							$this->excel->setActiveSheetIndex(0)->mergeCells($column . $start . ':' . $column . ($start + $end));
							$this->excel->setActiveSheetIndex(0)->getStyle($column . $start)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
							$this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
						}
					}
					$this->excel->getActiveSheet()->getStyle('A' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('B' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('C' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('D' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('E' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('F' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$this->excel->getActiveSheet()->getStyle('G' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

					$this->excel->setActiveSheetIndex(0)
						->setCellValue('R' . $i, $row['product_code'])
						->setCellValue('S' . $i, $row['product_name'])
						->setCellValue('T' . $i, $row['product_origin'])
						->setCellValue('U' . $i, $row['product_unit'])
						->setCellValue('V' . $i, $row['quantity'])
						->setCellValue('W' . $i, $row['unit_price'])
						->setCellValue('X' . $i, $row['price_discount_percent']/100)
						->setCellValue('Y' . $i, $row['price_discount'])
						->setCellValue('Z' . $i, '=W' . $i . '*(1-X'. $i .')')
						->setCellValue('AA' . $i, $row['monetized'])
						->setCellValue('AB' . $i, $row['VAT']/100)
						->setCellValue('AC' . $i, '=AA' . $i . '/(1+AB'. $i .')')
						->setCellValue('AE' . $i, '=AC' . $i . '*(1-AD'. $start .')')
						->setCellValue('AF' . $i, '=+AB' . $i . '*AC'. $i);

					$this->excel->getActiveSheet()->setCellValueExplicit('R' . $i, strval($row['product_code']), PHPExcel_Cell_DataType::TYPE_STRING);

					$this->excel->getActiveSheet()->getStyle('M' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('N' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('O' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('V' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('W' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('X' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
					$this->excel->getActiveSheet()->getStyle('Y' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('Z' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('AA' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('AB' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
					$this->excel->getActiveSheet()->getStyle('AC' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('AE' . $i)->getNumberFormat()->setFormatCode($numberFormat);
					$this->excel->getActiveSheet()->getStyle('AF' . $i)->getNumberFormat()->setFormatCode($numberFormat);

					//Highlight
					$this->excel->getActiveSheet()->getStyle('S' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('V' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('W' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('X' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('Y' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('Z' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('AA' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('AB' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('AC' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('AD' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('AE' . $i)->applyFromArray($styleHighlight);
					$this->excel->getActiveSheet()->getStyle('AF' . $i)->applyFromArray($styleHighlight);

					//Alignment
					$this->excel->getActiveSheet()->getStyle('C' . $i)->getAlignment()->applyFromArray($styleAlignmentCenter);
					$this->excel->getActiveSheet()->getStyle('P' . $i)->getAlignment()->applyFromArray($styleAlignmentCenter);

					$this->excel->getActiveSheet()->getStyle('G' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('M' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('N' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('O' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('V' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('W' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('X' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('Y' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('Z' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('AA' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('AB' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('AC' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('AD' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('AE' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
					$this->excel->getActiveSheet()->getStyle('AF' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);

					$j++;
					$i++;
				}
			}
		}

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('A' . $i, 'Tổng cộng')
			->setCellValue('AA' . $i, '=SUM(AA2:AA' . ($i -1) . ')')
			->setCellValue('AC' . $i, '=SUM(AC2:AC' . ($i -1) . ')')
			->setCellValue('AE' . $i, '=SUM(AE2:AE' . ($i -1) . ')')
			->setCellValue('AF' . $i, '=SUM(AF2:AF' . ($i -1) . ')');
		$this->excel->setActiveSheetIndex(0)->mergeCells('A' . $i . ':' . 'Z' . $i);

		$this->excel->getActiveSheet()->getStyle("AA$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);
		$this->excel->getActiveSheet()->getStyle("AC$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);
		$this->excel->getActiveSheet()->getStyle("AE$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);
		$this->excel->getActiveSheet()->getStyle("AF$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);

		//Total
		$styleTotal = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'FF0000'),
			),
		);
		$this->excel->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('AA' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('AB' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('AC' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('AE' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('AF' . $i)->applyFromArray($styleTotal);

		//Alignment
		$this->excel->getActiveSheet()->getStyle('AA' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AB' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AC' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AE' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AF' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);

		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . ($i))->applyFromArray(
		    array(
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN,
		            )
		        )
		    )
		);

		$sheet = $this->excel->getActiveSheet();
		$cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(true);
		foreach($cellIterator as $cell) {
	        $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
		}

		// $this->excel->setActiveSheetIndex(0)->setCellValue('A1', 'Dataas d as as d sad as d as d asd saddsad asd asd sa d asd s ad sa d asd asd as dsa d asd sa dasd');
		// $this->excel->setActiveSheetIndex(0)->setCellValue('A2', 'Dataas d as as d sad as d as d asd saddsad asd asd sa d asd s ad sa d asd asd as dsa d asd sa dasd');
		// $this->excel->setActiveSheetIndex(0)->setCellValue('A3', 'Dataas d as as d sad as d as d asd saddsad asd asd sa d asd s ad sa d asd asd as dsa d asd sa dasd');
		// $this->excel->setActiveSheetIndex(0)->setCellValue('A4', 'Dataas d as as d sad as d as d asd saddsad asd asd sa d asd s ad sa d asd asd as dsa d asd sa dasd');
		// $this->excel->setActiveSheetIndex(0)->setCellValue('A5', 'Dataas d as as d sad as d as d asd saddsad asd asd sa d asd s ad sa d asd asd as dsa d asd sa dasd');
		// $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		// $this->excel->setActiveSheetIndex(0)->mergeCells('A1:A5');

		//$this->excel->getActiveSheet()->getColumnDimension($hideColumn)->setVisible(false);

		$filename = 'Bao-cao_' . date('Y-m-d_H-i-s') . '.xlsx';
		header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}

	function admin_report_export_excel_bk1() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$get = $this->input->get();
		$this->_data['get'] = $get;
		$args = array();
		$order_by = array(
			'ovr.code' => 'DESC',
			'created' => 'DESC',
		);
		$args['order_by'] = $order_by;
		$args['order_by_custom'] = TRUE;

		//theo ngay
		if (isset($get['fromday']) && trim($get['fromday']) != '' && isset($get['today']) && trim($get['today']) != '') {
			$args['start_date_start'] = get_start_date($get['fromday']);
			$args['start_date_end'] = get_end_date($get['today']);
		}
		$rows = $this->M_output_voucher_details->gets($args);

		if (!is_array($rows) && empty($rows)) {
			$this->_module_slug = 'bao-cao';

			$notify_type = 'danger';
			$notify_content = 'Chưa có dữ liệu!';
			$this->set_notify_admin($notify_type, $notify_content);
			redirect(base_url($this->_module_slug));
		}

		$this->load->library('excel');

		$glue = '|';
		$firstColumn = 'A';
		$lastColumn = 'AD';
		//$letterColumn = range($firstColumn, $lastColumn);
		$letterColumn = range($firstColumn, 'Z');
		//$hideColumn = chr(ord($lastColumn) + 1);
		$hideColumn = 'AE';

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
			->setTitle("Báo cáo")
			->setSubject("Báo cáo")
			->setDescription("Báo cáo")
			->setKeywords("Báo cáo")
			->setCategory("Báo cáo");
		$this->excel->getActiveSheet()->setTitle('Báo cáo');

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('A1', 'STT')
			->setCellValue('B1', 'Mã hóa đơn')
			->setCellValue('C1', 'Thời gian tạo')
			->setCellValue('D1', 'Mã khách hàng')
			->setCellValue('E1', 'Tên khách hàng')
			->setCellValue('F1', 'Email')
			->setCellValue('G1', 'Điện thoại')
			->setCellValue('H1', 'Địa chỉ (Khách hàng)')
			->setCellValue('I1', 'Người bán')
			->setCellValue('J1', 'Kênh bán')
			->setCellValue('K1', 'Người tạo')
			->setCellValue('L1', 'Ghi chú')
			->setCellValue('M1', 'Tổng tiền hàng')
			->setCellValue('N1', 'Giảm giá hóa đơn')
			->setCellValue('O1', 'Khách cần trả')
			->setCellValue('P1', 'Trạng thái')
			->setCellValue('Q1', 'Trạng thái giao hàng')
			->setCellValue('R1', 'Mã hàng')
			->setCellValue('S1', 'Tên hàng')
			->setCellValue('T1', 'Thương hiệu')
			->setCellValue('U1', 'ĐVT')
			->setCellValue('V1', 'Số lượng')
			->setCellValue('W1', "Đơn giá\rbán lẻ")
			->setCellValue('X1', 'Giảm giá %')
			->setCellValue('Y1', 'Giảm giá')
			->setCellValue('Z1', "Giá bán\rđơn vị")
			->setCellValue('AA1', "Thành tiền\r(bao gồm VAT)")
			->setCellValue('AB1', '% VAT')
			->setCellValue('AC1', "Doanh thu\r(chưa VAT)")
			->setCellValue('AD1', 'VAT');

		$this->excel->getActiveSheet()->getStyle('W1')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('Z1')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('AA1')->getAlignment()->setWrapText(true);
		$this->excel->getActiveSheet()->getStyle('AC1')->getAlignment()->setWrapText(true);

		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFill()->getStartColor()->setARGB('FFCC33');
		// Add some data
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		//Header
		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . "1")->getFont()->applyFromArray($styleHeader);

		//Alignment
		$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->applyFromArray($styleAlignmentCenter);
		$this->excel->getActiveSheet()->getStyle('P1')->getAlignment()->applyFromArray($styleAlignmentCenter);

		$this->excel->getActiveSheet()->getStyle('G1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('M1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('N1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('O1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('V1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('W1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('X1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('Y1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('Z1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AA1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AB1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AC1')->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AD1')->getAlignment()->applyFromArray($styleAlignmentRight);

		//Highlight Header
		$fillHighlightHeader = '92d050';
		$this->excel->getActiveSheet()->getStyle('W1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('Z1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('AA1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('AB1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('AC1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);
		$this->excel->getActiveSheet()->getStyle('AD1')->getFill()->getStartColor()->setARGB($fillHighlightHeader);

		foreach ($letterColumn as $column) {
			$this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
		}
		$this->excel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);

		$i = 2;
		$order = 0;
		$group_orders = array();
		$start = 0;
		$end = 0;
		foreach ($rows as $row) {
			$code = $row['code'];
			if(!empty($group_orders) && in_array($code, $group_orders)){
				$end++;
			}else{
				$group_orders[] = $code;
				$end = $start = $i;
			}
			$this->excel->getActiveSheet()->getStyle('A' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('B' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('C' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('D' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('E' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('F' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('G' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

			$order++;
			$this->excel->setActiveSheetIndex(0)
				->setCellValue('A' . $i, $order)
				->setCellValue('B' . $i, $row['code'])
				->setCellValue('C' . $i, display_date($row['date']))
				->setCellValue('D' . $i, $row['customer_code'])
				->setCellValue('E' . $i, $row['customer_full_name'])
				->setCellValue('F' . $i, $row['customer_email'])
				->setCellValue('G' . $i, $row['customer_phone'])
				->setCellValue('H' . $i, $row['customer_address'])
				->setCellValue('I' . $i, $row['full_name'])
				->setCellValue('J' . $i, '')
				->setCellValue('K' . $i, $row['full_name'])
				->setCellValue('L' . $i, $row['note'])
				->setCellValue('M' . $i, $row['unit_price'] * $row['quantity'])
				->setCellValue('N' . $i, $row['price_discount'])
				->setCellValue('O' . $i, $row['monetized'])
				->setCellValue('P' . $i, $row['status'] == 1 ? 'Hoàn thành' : ($row['status'] == 0 ? 'Đã yêu cầu' : 'Đã hủy'))
				->setCellValue('Q' . $i, '')
				->setCellValue('R' . $i, $row['product_code'])
				->setCellValue('S' . $i, $row['product_name'])
				->setCellValue('T' . $i, $row['product_origin'])
				->setCellValue('U' . $i, $row['product_unit'])
				->setCellValue('V' . $i, $row['quantity'])
				->setCellValue('W' . $i, $row['unit_price'])
				->setCellValue('X' . $i, $row['price_discount_percent'])
				->setCellValue('Y' . $i, $row['price_discount'])
				->setCellValue('Z' . $i, '=W' . $i . '-Y'. $i)
				->setCellValue('AA' . $i, $row['monetized'])
				->setCellValue('AB' . $i, $row['VAT']/100)
				->setCellValue('AC' . $i, '=AA' . $i . '/(1+AB'. $i .')')
				->setCellValue('AD' . $i, '=+AB' . $i . '*AC'. $i);

			$this->excel->getActiveSheet()->setCellValueExplicit('G' . $i, strval($row['customer_phone']), PHPExcel_Cell_DataType::TYPE_STRING);

			$this->excel->getActiveSheet()->getStyle('M' . $i)->getNumberFormat()->setFormatCode($numberFormat);
			$this->excel->getActiveSheet()->getStyle('N' . $i)->getNumberFormat()->setFormatCode($numberFormat);
			$this->excel->getActiveSheet()->getStyle('O' . $i)->getNumberFormat()->setFormatCode($numberFormat);
			$this->excel->getActiveSheet()->getStyle('V' . $i)->getNumberFormat()->setFormatCode($numberFormat);
			$this->excel->getActiveSheet()->getStyle('W' . $i)->getNumberFormat()->setFormatCode($numberFormat);
			$this->excel->getActiveSheet()->getStyle('X' . $i)->getNumberFormat()->setFormatCode($numberFormat);
			$this->excel->getActiveSheet()->getStyle('Y' . $i)->getNumberFormat()->setFormatCode($numberFormat);
			$this->excel->getActiveSheet()->getStyle('Z' . $i)->getNumberFormat()->setFormatCode($numberFormat);
			$this->excel->getActiveSheet()->getStyle('AA' . $i)->getNumberFormat()->setFormatCode($numberFormat);
			$this->excel->getActiveSheet()->getStyle('AB' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
			$this->excel->getActiveSheet()->getStyle('AC' . $i)->getNumberFormat()->setFormatCode($numberFormat);
			$this->excel->getActiveSheet()->getStyle('AD' . $i)->getNumberFormat()->setFormatCode($numberFormat);

			//Highlight
			$this->excel->getActiveSheet()->getStyle('S' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('V' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('W' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('X' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('Y' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('Z' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('AA' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('AB' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('AC' . $i)->applyFromArray($styleHighlight);
			$this->excel->getActiveSheet()->getStyle('AD' . $i)->applyFromArray($styleHighlight);

			//Alignment
			$this->excel->getActiveSheet()->getStyle('C' . $i)->getAlignment()->applyFromArray($styleAlignmentCenter);
			$this->excel->getActiveSheet()->getStyle('P' . $i)->getAlignment()->applyFromArray($styleAlignmentCenter);

			$this->excel->getActiveSheet()->getStyle('G' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('M' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('N' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('O' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('V' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('W' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('X' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('Y' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('Z' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('AA' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('AB' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('AC' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
			$this->excel->getActiveSheet()->getStyle('AD' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);

			$this->excel->setActiveSheetIndex(0)->mergeCells('B' . $start . ':' . 'B' . $end);
			//$this->excel->setActiveSheetIndex(0)->setCellValue('B' . $start, $code);

			$i++;
		}
		// $this->excel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, 10, "test");

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('A' . $i, 'Tổng cộng')
			->setCellValue('AA' . $i, '=SUM(AA2:AA' . ($i -1) . ')')
			->setCellValue('AC' . $i, '=SUM(AC2:AC' . ($i -1) . ')')
			->setCellValue('AD' . $i, '=SUM(AD2:AD' . ($i -1) . ')');
		$this->excel->setActiveSheetIndex(0)->mergeCells('A' . $i . ':' . 'Z' . $i);

		$this->excel->getActiveSheet()->getStyle("AA$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);
		$this->excel->getActiveSheet()->getStyle("AC$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);
		$this->excel->getActiveSheet()->getStyle("AD$i:" . $lastColumn . $i)->getNumberFormat()->setFormatCode($numberFormat);

		//Total
		$styleTotal = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'FF0000'),
			),
		);
		$this->excel->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('AA' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('AB' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('AC' . $i)->applyFromArray($styleTotal);
		$this->excel->getActiveSheet()->getStyle('AD' . $i)->applyFromArray($styleTotal);

		//Alignment
		$this->excel->getActiveSheet()->getStyle('AA' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AB' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AC' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);
		$this->excel->getActiveSheet()->getStyle('AD' . $i)->getAlignment()->applyFromArray($styleAlignmentRight);

		$this->excel->getActiveSheet()->getStyle($firstColumn . "1:" . $lastColumn . ($i))->applyFromArray(
		    array(
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN,
		            )
		        )
		    )
		);

		//$this->excel->getActiveSheet()->getColumnDimension($hideColumn)->setVisible(false);

		$filename = 'Bao-cao_' . date('Y-m-d_H-i-s') . '.xlsx';
		header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $objWriter->save('php://output');
	}

	function admin_report() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$this->_module_slug = 'bao-cao';
		$this->_data['module_slug'] = $this->_module_slug;
		$_breadcrumbs_admin[] = array(
			'url' => '',
			'name' => 'Báo cáo',
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
			'folder' => 'output_voucher',
			'name' => 'admin-report-by-product',
		);
		$this->set_modules();

		$get = $this->input->get();
		$this->_data['get'] = $get;
		$args = array();

		//theo ngay
		if (isset($get['fromday']) && trim($get['fromday']) != '' && isset($get['today']) && trim($get['today']) != '') {
			$args['start_date_start'] = get_start_date($get['fromday']);
			$args['start_date_end'] = get_end_date($get['today']);
		}

		$total = $this->M_output_voucher_details->counts($args);
		$this->_data['total_record'] = (int) $total;
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

		$this->pagination->initialize($config); # Khởi tạo phân trang

		$pagination = $this->pagination->create_links(); # Tạo link phân trang
		$offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment); # Lấy offset
		$this->_data['current_page'] = (int) $offset;

		$rows = $this->M_output_voucher_details->gets($args, $perpage, $offset);
		$this->_data['pagination'] = $pagination;
		$this->_data['rows'] = $rows;

		$this->_data['breadcrumbs_module_name'] = 'Báo cáo';
		$this->_data['breadcrumbs_module_func'] = '';
		$this->_data['title'] = 'Báo cáo';
		$this->_data['main_content'] = 'output_voucher/admin/view_page_report';
		$this->load->view('layout/admin/view_layout', $this->_data);
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

		$this->set_plugins_admin();

		$this->_modules_script[] = array(
			'folder' => 'output_voucher',
			'name' => 'admin-borrow',
		);
		$this->set_modules();

		$get = $this->input->get();
		$this->_data['get'] = $get;

		$args = $this->default_args();
		if(isset($args['status'])){
			unset($args['status']);
		}
		if(!(isset($this->_data['role']) && in_array($this->_data['role'], array('ADMIN')))){
			$args['created_by'] = get_current_user_id();
		}

		//theo ngay
		if (isset($get['fromday']) && trim($get['fromday']) != '') {
			$args['start_date_start'] = get_current_date($get['fromday']);
		}
		if (isset($get['today']) && trim($get['today']) != '') {
			$args['start_date_end'] = get_current_date($get['today']);
		}

		if (isset($get['customer_id']) && (int) $get['customer_id'] != 0) {
			$args['customer_id'] = (int) $get['customer_id'];
		}

		if (isset($get['is_indebted']) && (int) $get['is_indebted'] != -1) {
			$args['is_indebted'] = (int) $get['is_indebted'];
		}

		if (isset($get['status']) && trim($get['status']) != '') {
			$args['status'] = (int) $get['status'];
		}

		if (isset($get['order_status']) && trim($get['order_status']) != '') {
			$args['order_status'] = (int) $get['order_status'];
		}

		if (isset($get['q']) && trim($get['q']) != '') {
			$args['q'] = $get['q'];
		}		

		$total = $this->counts($args);
		$perpage = isset($get['per_page']) ? $get['per_page'] : $this->config->item('per_page');
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

		$rows = $this->M_output_voucher->gets($args, $perpage, $offset);
		$this->_data['pagination'] = $pagination;

		if (is_array($rows) && !empty($rows)) {
			foreach ($rows as $key => $value) {
				$rows[$key]['items'] = $this->get_details($value['id']);
			}
		}
		$this->_data['rows'] = $rows;

		$customers = modules::run('customers/gets');
		$this->_data['customers'] = $customers;

		$this->_data['title'] = 'Danh sách hóa đơn bán hàng - ' . $this->_data['title'];
		$this->_data['main_content'] = 'output_voucher/admin/view_page_index';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_index1() {
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

		$this->set_plugins_admin();

		$this->_modules_script[] = array(
			'folder' => 'output_voucher',
			'name' => 'admin-borrow',
		);
		$this->set_modules();

		$get = $this->input->get();
		$this->_data['get'] = $get;

		$args = $this->default_args();
		if(isset($args['status'])){
			unset($args['status']);
		}
		if(!(isset($this->_data['role']) && in_array($this->_data['role'], array('ADMIN')))){
			$args['created_by'] = get_current_user_id();
		}

		//theo ngay
		if (isset($get['fromday']) && trim($get['fromday']) != '') {
			$args['start_date_start'] = get_current_date($get['fromday']);
		}
		if (isset($get['today']) && trim($get['today']) != '') {
			$args['start_date_end'] = get_current_date($get['today']);
		}

		if (isset($get['customer_id']) && (int) $get['customer_id'] != 0) {
			$args['customer_id'] = (int) $get['customer_id'];
		}

		if (isset($get['q']) && trim($get['q']) != '') {
			$args['q'] = $get['q'];
		}

		$total = $this->counts($args);
		$perpage = isset($get['per_page']) ? $get['per_page'] : $this->config->item('per_page');
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

		$rows = $this->M_output_voucher->gets($args, $perpage, $offset);
		$this->_data['pagination'] = $pagination;

		if (is_array($rows) && !empty($rows)) {
			foreach ($rows as $key => $value) {
				$rows[$key]['items'] = $this->get_details($value['id']);
			}
		}
		$this->_data['rows'] = $rows;

		$customers = modules::run('customers/gets');
		$this->_data['customers'] = $customers;

		$this->_data['title'] = 'Danh sách hóa đơn bán hàng - ' . $this->_data['title'];
		$this->_data['main_content'] = 'output_voucher/admin/view_page_index';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_by_customer() {
		$this->_initialize_admin();
		$this->_validate_access_role();

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
			'folder' => 'output_voucher',
			'name' => 'admin-borrow',
		);
		$this->set_modules();

		$get = $this->input->get();
		$this->_data['get'] = $get;

		$args = $this->default_args();
		$args['customer_id'] = $id;
		$args['deleted'] = 0;

		if (isset($get['remainder']) && (int) ($get['remainder']) == 1) {
			$args['is_indebted'] = $get['remainder'];
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

		$total = $this->counts($args);
		$perpage = 10; //isset($get['per_page']) ? $get['per_page'] : $this->config->item('per_page');
		$segment = 3;

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

		$rows = $this->M_output_voucher->gets($args, $perpage, $offset);
		$this->_data['pagination'] = $pagination;
		$this->_data['rows'] = $rows;

		$this->_data['title'] = 'Danh sách đơn hàng - ' . $this->_data['title'];
		$this->_data['main_content'] = 'output_voucher/admin/view_page_customer';
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
			'folder' => 'output_voucher',
			'name' => 'admin-borrow-trash',
		);
		$this->set_modules();

		$this->_data['breadcrumbs_module_name'] = 'Thùng rác';
		$this->_module_slug = 'thung-rac/phieu-xuat';
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

		$this->_data['rows'] = $this->M_output_voucher->gets($args, $perpage, $offset);
		$this->_data['pagination'] = $pagination;

		$this->_data['title'] = 'Thùng rác - Danh sách hóa đơn bán hàng - ' . $this->_data['title'];
		$this->_data['main_content'] = 'output_voucher/admin/view_page_trash';
		$this->load->view('layout/admin/view_layout', $this->_data);
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
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('customer_id', 'Khách hàng', 'required');
			$this->form_validation->set_rules('date', 'Ngày nhập', 'required');

			if ($this->form_validation->run($this)) {
				$err = FALSE;
				$id = (int) $this->input->post('id');
				$user_id = get_current_user_id();

				$current_consignments = array();
				$consignments = array();
				$tblAppendGrid = 'tblAppendGrid_';
				$rowOrder = explode(',', $this->input->post($tblAppendGrid . 'rowOrder'));
				if (is_array($rowOrder) && !empty($rowOrder)) {
					foreach ($rowOrder as $i) {
						$profit = 0;
						$historical_cost = 0;
						$product_id = $this->input->post($tblAppendGrid . 'product_id' . '_' . $i);
						$product = modules::run('products/get', $product_id);
						$quantity = $this->input->post($tblAppendGrid . 'quantity' . '_' . $i);
						$unit_price = filter_var($this->input->post($tblAppendGrid . 'unit_price' . '_' . $i), FILTER_SANITIZE_NUMBER_FLOAT);
						if (isset($product['unit_price'])) {
							$historical_cost = $product['unit_price'];
							$profit = abs($historical_cost - $unit_price) * $quantity;
						}

						$consignments[] = array(
							'product_id' => $product_id,
							'warehouse_id' => $this->input->post('warehouse_id'),
							'quantity' => $quantity,
							'price_type' => $this->input->post($tblAppendGrid . 'price_type' . '_' . $i),
							'historical_cost' => $historical_cost,
							'unit_price' => $unit_price,
							'price_discount_percent' => $this->input->post($tblAppendGrid . 'price_discount_percent' . '_' . $i),
							// 'price_discount' => filter_var(numberFormatDecode($this->input->post($tblAppendGrid . 'price_discount' . '_' . $i)), FILTER_SANITIZE_NUMBER_FLOAT),
							'price_discount' => numberFormatDecode($this->input->post($tblAppendGrid . 'price_discount' . '_' . $i)),
							// 'monetized' => filter_var(numberFormatDecode($this->input->post($tblAppendGrid . 'monetized' . '_' . $i)), FILTER_SANITIZE_NUMBER_FLOAT),
							'monetized' => numberFormatDecode($this->input->post($tblAppendGrid . 'monetized' . '_' . $i)),
							'profit' => $profit,
							'VAT' => isset($product['category_VAT']) ? (float) $product['category_VAT'] : 0, //$this->input->post($tblAppendGrid . 'VAT' . '_' . $i)
						);
					}
					if (!empty($consignments)) {
						$time = time();
						$date = $this->input->post('date');
						$amount = array_sum(array_column($consignments, 'monetized'));
						$current_page = $this->input->post('current_page');
						$discount_percent = (float) $this->input->post('discount_percent');
						$discount = $amount * $discount_percent / 100;
						$monetized = $amount - $discount;

						$customer_id = $this->input->post('customer_id');
						$customer = modules::run('customers/get', $customer_id);

						$cash = filter_var($this->input->post('cash'), FILTER_SANITIZE_NUMBER_FLOAT);
						$change = filter_var($this->input->post('change'), FILTER_SANITIZE_NUMBER_FLOAT);
						$prepaid = filter_var($this->input->post('prepaid'), FILTER_SANITIZE_NUMBER_FLOAT);
						$remainder = filter_var($this->input->post('remainder'), FILTER_SANITIZE_NUMBER_FLOAT);

						$data_output_voucher = array(
							'amount' => $amount,
							'discount_percent' => $discount_percent,
							'discount' => $discount,
							'monetized' => $monetized,
							'warehouse_id' => $this->input->post('warehouse_id'),
							'customer_id' => $customer_id,
							'date' => (trim($date) != '') ? get_current_date($date) : $time,
							'VAT' => 0,
							'note' => $this->input->post('note'),
							'note_prepaid' => $this->input->post('note_prepaid'),
							'note_remainder' => $this->input->post('note_remainder'),
							'cash' => $cash,
							'change' => $change,
							'prepaid' => $prepaid,
							'remainder' => $remainder,
							'indebtedness' => $prepaid + $remainder,
						);

						if ($id != 0) {
							$data_output_voucher['modified'] = time();
							if (!$this->M_output_voucher->update($id, $data_output_voucher)) {
								$err = TRUE;
							} else {
								$current_data_output_voucher = $this->M_output_voucher_details->get($id);
								if (isset($current_data_output_voucher) && is_array($current_data_output_voucher) && !empty($current_data_output_voucher)) {
									$current_consignments = array_column($current_data_output_voucher, 'quantity', 'product_id');
								}
								$this->M_output_voucher_details->delete($id);
							}
							$output_voucher_id = $id;
						} else {
							$data_output_voucher['created_by'] = $user_id;
							$data_output_voucher['code'] = $this->get_code($id);
							$data_output_voucher['status'] = 0;
							$data_output_voucher['created'] = $time;
							$data_output_voucher['modified'] = 0;
							$output_voucher_id = $this->M_output_voucher->add($data_output_voucher);
						}

						if ($output_voucher_id != 0) {
							foreach ($consignments as $value) {
								$product = modules::run('products/get', $value['product_id']);
								// $total = (int) (isset($product['quantity']) ? $product['quantity'] : 0);
								// if (isset($current_consignments) && is_array($current_consignments) && !empty($current_consignments)) {
								// 	if (array_key_exists($value['product_id'], $current_consignments)) {
								// 		$total += $current_consignments[$value['product_id']];
								// 	}
								// }
								$data = array(
									'output_voucher_id' => $output_voucher_id,
									'product_id' => $value['product_id'],
									'product_name' => isset($product['name']) ? $product['name'] : NULL,
									'warehouse_id' => $value['warehouse_id'],
									'quantity' => $value['quantity'],
									'price_type' => $value['price_type'],
									'historical_cost' => $value['historical_cost'],
									'unit_price' => $value['unit_price'],
									'price_discount_percent' => $value['price_discount_percent'],
									'price_discount' => $value['price_discount'],
									'monetized' => $value['monetized'],
									'profit' => $value['profit'],
									'VAT' => $value['VAT'],
								);
								if (!$this->M_output_voucher_details->add($data)) {
									$err = TRUE;
								} else {
									// $this->M_products->update($value['product_id'], array(
									// 	'quantity' => $total - $value['quantity'],
									// 	'modified' => time(),
									// ));
								}
							}
						} else {
							$err = TRUE;
						}
					}

					if ($err === FALSE) {
						if($id != 0){
							add_activity("Người dùng cập nhật hóa đơn #ID: $output_voucher_id");
						}else{
							add_activity("Người dùng thêm hóa đơn #ID: $output_voucher_id");
						}
						$percent = 0;
						$ref_percent = 0;
						/*
						if($id == 0 && $output_voucher_id != 0){
							$action = 'BUY';
							$percent = 0;
							$value_cost = $amount;
							$value = $amount;
							$data_commission = array(
							    'order_id' => $output_voucher_id,
							    'user_id' => $user_id,
							    'extend_by' => NULL,
							    'action' => $action,
							    'payment' => 'PAY_CASH',
							    'value_cost' => $value_cost,
							    'percent' => $percent,
							    'value' => $value,
							    'message' => 'Người dùng mua hàng',
							    'status' => 0,
							    'created' => $time
							);
							modules::run('users/users_commission/add', $data_commission);

							$user = $this->M_users->get($user_id);
							$counts = $this->M_output_voucher->counts(array('created_by' => $user_id));
							$is_first = ($counts == 1) ? TRUE : FALSE;
							$level = isset($user['level']) ? $user['level'] : 'MEMBER';
							if($level == 'MEMBER'){
								$percent = $is_first ? 15 : 5;
							}elseif($level == 'RESELLER'){
								$percent = 20;
							}elseif($level == 'DEALER'){
								$percent = 25;
							}elseif($level == 'TRADER'){
								$percent = 30;
							}
							if($percent != 0){
								$action = 'SUB_BUY_MY';
								$value_cost = $amount;
								$value = $amount * $percent / 100;
								$data_commission = array(
								    'order_id' => $output_voucher_id,
								    'user_id' => $user_id,
								    'extend_by' => NULL,
								    'action' => $action,
								    'payment' => 'PAY_CASH',
								    'value_cost' => $value_cost,
								    'percent' => $percent,
								    'value' => $value,
								    'message' => 'Người dùng được hưởng phần trăm giảm giá do mua hàng ở cấp thành viên ' . $level,
								    'status' => 0,
								    'created' => $time
								);
								modules::run('users/users_commission/add', $data_commission);
							}

							$referred_by = isset($user['referred_by']) ? (int) $user['referred_by'] : 0;
							$ref = $this->M_users->get($referred_by);
							$ref_level = isset($ref['level']) ? $ref['level'] : 'MEMBER';
							if($ref_level == 'MEMBER'){
								$ref_percent = 0;
							}elseif($ref_level == 'RESELLER'){
								$ref_percent = 8;
							}elseif($ref_level == 'DEALER'){
								$ref_percent = 9;
							}elseif($ref_level == 'TRADER'){
								$ref_percent = 10;
							}
							if($ref_percent != 0){
								$action = 'SUB_BUY_ROOT';
								$value_cost = $amount;
								$value = $amount * $ref_percent / 100;
								$data_commission = array(
								    'order_id' => $output_voucher_id,
								    'user_id' => $referred_by,
								    'extend_by' => NULL,
								    'action' => $action,
								    'payment' => 'PAY_CASH',
								    'value_cost' => $value_cost,
								    'percent' => $ref_percent,
								    'value' => $value,
								    'message' => 'Người dùng được hưởng phần trăm trực tiếp khi cấp dưới mua hàng ở cấp thành viên ' . $ref_level,
								    'status' => 0,
								    'created' => $time
								);
								modules::run('users/users_commission/add', $data_commission);
							}
						}
						*/

						$message['status'] = 'success';
						$message['content'] = array(
							// 'percent' => $percent,
							// 'ref_percent' => $ref_percent,
							'data' => base_url($this->_module_slug . '/xem/' . $output_voucher_id)
						);
						$message['message'] = 'Hóa đơn bán hàng đã lưu!';
						echo json_encode($message);
						exit();

						//send mail
						/*$row = $this->get_info($output_voucher_id);
						if(is_array($row) && !empty($row)){
							$site_name = $this->_data['site_name'];
			                $subject = "HÓA ĐƠN BÁN HÀNG - " . $this->_data['site_name'];

			                $this->_data['row'] = $row;
			                $this->_data['customer'] = $customer;
			                $core_message = $this->load->view('layout/site/partial/html-template-output-voucher', $this->_data, true);
			                $data_sendmail = array(
			                    'sender_email' => $this->_data['email'],
			                    'sender_name' => $site_name,
			                    //'receiver_email' => array($customer['email'], $this->_data['email']),
			                    'receiver_email' => $this->_data['email'],
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
				} else {
					$message['status'] = 'error';
					$message['content'] = null;
					$message['message'] = 'Chưa chọn sản phẩm! Vui lòng chọn lại sản phẩm và thực hiện lại!';
					echo json_encode($message);
					exit();
				}
			}
		}
		echo json_encode($message);
		exit();
	}

	function get_code($id) {
		$code = $this->get_max_code();
		while (!$this->M_output_voucher->check_code_availablity($code, $id)) {
			$code = $this->get_max_code();
		}

		return $code;
	}

	function get_max_code() {
		$args = array();
		$order_by = array(
			'code' => 'DESC',
		);
		$args['order_by'] = $order_by;
		$rows = $this->M_output_voucher->gets($args, 1, 0);
		$code = isset($rows[0]['code']) ? intval(str_replace(OUTPUT_VOUCHER_PREFIX, "", $rows[0]['code'])) : 0;
		return OUTPUT_VOUCHER_PREFIX . str_pad($code + 1, OUTPUT_VOUCHER_LENGHT, "0", STR_PAD_LEFT);
	}

	function check_code_availablity() {
		$post = $this->input->post();
		$this->_message_success = 'true';
		$this->_message_danger = 'false';

		if (!empty($post)) {
			$code = $this->input->post('code');
			$id = $this->input->post('id');
			if ($this->input->post('ajax') == '1') {
				if ($this->M_output_voucher->check_code_availablity($code, $id)) {
					$this->_status = "success";
					$this->_message = $this->_message_success;
				} else {
					$this->_status = "danger";
					$this->_message = $this->_message_danger;
				}

				$this->set_json_encode();
				$this->load->view('layout/json_data', $this->_data);
			} else {
				if ($this->M_output_voucher->check_code_availablity($code, $id)) {
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
		$this->_initialize_admin();
		$this->_validate_access_role();

		//echo $this->_data['email']; die;
		// $data_sendmail = array(
		//     'sender_email' => $this->_data['email'],
		//     'sender_name' => 'tôi',
		//     'receiver_email' => $this->_data['email'],
		//     'subject' => 'Tài năng',
		//     'message' => 'học code'
		// );
		// modules::run('emails/send_mail', $data_sendmail); // gửi mail

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
			'folder' => 'output_voucher',
			'name' => 'admin-borrow-content',
		);
		$this->set_modules();

		$max_code = $this->get_max_code();
		$this->_data['max_code'] = $max_code;

		$order_by = array(
            'full_name' => 'ASC'
        );
        $args_customers['order_by_field'] = 'Khách lẻ';
        $args_customers['order_by'] = $order_by;
        $args_customers['deleted'] = 0;
  //       if(!(isset($this->_data['role']) && in_array($this->_data['role'], array('ADMIN')))){
		// 	$args_customers['created_by'] = get_current_user_id();
		// }
		$customers = modules::run('customers/gets',$args_customers);
		if (is_array($customers) && !empty($customers)) {
			foreach ($customers as $key => $value) {
				$customers[$key]['full_name'] = $value['full_name'] . (trim($value['phone']) != '' ? ' - ' . $value['phone'] : '');
			}
		}
		$this->_data['customers'] = $customers;
		$this->_data['category'] = modules::run('category/gets');
		//$this->_data['order_type'] = modules::run('output_voucher/order_type/gets');

		$is_admin = (isset($this->_data['role']) && in_array($this->_data['role'], array('ADMIN')));
		if (!$is_admin) {
			$user = modules::run('employee/get', get_current_user_id());
			if (is_array($user) && !empty($user)) {
				$warehouse_id = $user['warehouse_id'];
			}
		}

		$title = 'Hóa đơn bán hàng - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
		$user_id = get_current_user_id();
		$segment = 3;
		$id = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
		if($id > 0){
			if(!($this->is_owned($user_id, $id) || $this->is_admin())){
				redirect($this->_module_slug);
			}
		}
		$row = $this->get($id);
		if ($id != 0 && is_array($row) && !empty($row)) {
			if($row['status'] != 0){
				redirect(base_url($this->_module_slug));
			}
			$this->_data['current_page'] = (int) $this->input->get('current_page');
			$row['items'] = $this->M_output_voucher_details->get_data_in_output_voucher_id($row['id']);
			$this->_data['row'] = $row;
			$title = 'Cập nhật hóa đơn bán hàng - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];

			if (isset($row['warehouse_id'])) {
				$warehouse_id = $row['warehouse_id'];
			}
			if(isset($row['customer_id'])){
				$customer_id = $row['customer_id'];
				$paid = 0;
                $pays = modules::run('pay/gets', array('customer_id' => $customer_id));
                if(is_array($pays) && !empty($pays)){
                    $paid = array_sum(array_column($pays, 'amount'));
                }

                $output_voucher_pay_by_customer = modules::run('output_voucher/get_pay_by_customer', $customer_id);
                $this->_data['arrears'] = $output_voucher_pay_by_customer['remainder'] - $paid;
            }
		}
		if ($is_admin) {
			$warehouse = modules::run('purchase_voucher/warehouse/gets');
			$products = modules::run('products/gets', array('deleted' => 0));
			$employee = modules::run('employee/gets');
		} else {
			//$warehouse = modules::run('purchase_voucher/warehouse/gets', array('in_id' => array($warehouse_id)));
			$warehouse = modules::run('purchase_voucher/warehouse/gets');

			$in_products_id = array(-1);
			$products_purchase_voucher_import_details = $this->M_purchase_voucher_details->gets(array(
				'warehouse_id' => $warehouse_id,
				'type' => 'import',
			));
			if (is_array($products_purchase_voucher_import_details) && !empty($products_purchase_voucher_import_details)) {
				$in_products_id = array_unique(array_merge($in_products_id, array_column($products_purchase_voucher_import_details, 'product_id')));
			}

			$products_purchase_voucher_transaction_addition_details = $this->M_purchase_voucher_details->gets(array(
				'transaction_warehouse_id' => $warehouse_id,
				'type' => 'transaction',
			));
			if (is_array($products_purchase_voucher_transaction_addition_details) && !empty($products_purchase_voucher_transaction_addition_details)) {
				$in_products_id = array_unique(array_merge($in_products_id, array_column($products_purchase_voucher_transaction_addition_details, 'product_id')));
			}
			//$products = modules::run('products/gets', array('deleted' => 0, 'in_id' => $in_products_id));
			$products = modules::run('products/gets', array('deleted' => 0));

			$employee = modules::run('employee/gets', array('in_id' => array(get_current_user_id())));
		}
		$this->_data['products'] = $products;
		$this->_data['warehouse'] = $warehouse;
		$this->_data['employee'] = $employee;
		$this->_data['customer_types'] = modules::run('customer_types/gets');
        $this->_data['type_of_customer'] = modules::run('customers/type_of_customer/gets');

		//var_dump(get_access_role('ROLE_GROUP_OUTPUT_VOUCHER'));
		//var_dump(validate_access_role($this->_data['role'], 'ROLE_GROUP_OUTPUT_VOUCHER')); die();

		$this->_data['title'] = $title;
		$this->_data['main_content'] = 'output_voucher/admin/view_page_content';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_quotation() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$this->_module_slug = '';
		$this->_data['module_slug'] = $this->_module_slug;

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
			'folder' => 'output_voucher',
			'name' => 'admin-quotation',
		);
		$this->set_modules();

		$this->_data['customers'] = modules::run('customers/gets', array('deleted' => 0));
		$args = modules::run('products/default_args');
		$args['deleted'] = 0;
		$this->_data['products'] = modules::run('products/gets', $args);

		$this->_data['breadcrumbs_module_name'] = 'Báo giá';
		$this->_data['breadcrumbs_module_func'] = '';
		$this->_data['title'] = $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
		$this->_data['main_content'] = 'output_voucher/admin/view_page_quotation';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function get_info($id = 0) {
		if ($id != 0) {
			$row = $this->get($id);
			if (is_array($row) && !empty($row)) {
				$row['items'] = $this->M_output_voucher_details->get($row['id']);
			}
		} else {
			$row = null;
		}
		return $row;
	}

	function admin_view() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$this->_plugins_script_admin[] = array(
			'folder' => 'bootbox',
			'name' => 'bootbox',
		);

		$this->_plugins_script_admin[] = array(
			'folder' => 'jQuery-Plugin-To-Print-Any-Part-Of-Your-Page-Print',
			'name' => 'jQuery.print',
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

		$this->_modules_css[] = array(
			'folder' => 'output_voucher',
			'name' => 'admin-borrow-view',
		);
		$this->_modules_script[] = array(
			'folder' => 'output_voucher',
			'name' => 'admin-borrow-view',
		);
		$this->set_modules();

		$this->_data['customers'] = modules::run('customers/gets');
		$this->_data['employee'] = modules::run('employee/gets');
		$this->_data['products'] = modules::run('products/gets');

		$user_id = get_current_user_id();
		$segment = 3;
		$id = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
		// if(!($this->is_owned($user_id, $id) || $this->is_admin())){
		// 	redirect($this->_module_slug);
		// }
		$row = $this->get($id);
		if (!(is_array($row) && !empty($row))) {
			redirect($this->_module_slug);
		}
		$row['items'] = $this->M_output_voucher_details->get($row['id']);
		if(isset($row['customer_id'])){
			$customer_id = $row['customer_id'];
			$paid = 0;
            $pays = modules::run('pay/gets', array('customer_id' => $customer_id));
            if(is_array($pays) && !empty($pays)){
                $paid = array_sum(array_column($pays, 'amount'));
            }

            $output_voucher_pay_by_customer = modules::run('output_voucher/get_pay_by_customer', $customer_id);
            $this->_data['arrears'] = $output_voucher_pay_by_customer['remainder'] - $paid;
        }
        $this->_data['row'] = $row;

		$user = $this->M_users->get($user_id);
		$role = isset($user['role']) ? $user['role'] : NULL;
		$is_role_edit = FALSE;
		$is_role_comfirm = FALSE;
		if($role == 'ADMIN'){
			$is_role_edit = TRUE;
			$is_role_comfirm = TRUE;
		}elseif(isset($user_level_1['userid']) && $level == 'PRICE_LEVEL_1' && ($user_id == $user_level_1['userid'])){
			$is_role_comfirm = TRUE;
		}
		if($row['created_by'] == $user_id){
			$is_role_edit = TRUE;
		}
		$this->_data['is_role_edit'] = $is_role_edit;
		$this->_data['is_role_comfirm'] = $is_role_comfirm;

		$customer = modules::run('users/get', $row['customer_id']);
		$this->_data['customer'] = $customer;

		$this->_data['title'] = 'Xem hóa đơn bán hàng' . (isset($row['code']) && trim($row['code']) != '' ? ' ' . $row['code'] : '') . ' - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
		$this->_data['main_content'] = 'output_voucher/admin/view_page_view';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_delete() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$id = (int) $this->input->get('id');
		$row = $this->get($id);
		if ($id != 0 && !empty($row)) {
			//if ($this->M_output_voucher->update($id, array('deleted' => 1, 'deleted_by' => get_current_user_id()))) {
			if ($this->M_output_voucher->delete($id) && $this->M_output_voucher_details->delete($id)) {
				add_activity("Người dùng xóa hóa đơn #ID: $id!");
				$notify_type = 'success';
				$notify_content = "Đã xóa hóa đơn bán hàng!";
			} else {
				$notify_type = 'danger';
				$notify_content = "Chưa xóa hóa đơn bán hàng!";
			}
		} else {
			$notify_type = 'warning';
			$notify_content = "Hóa đơn bán hàng không tồn tại!";
		}
		$this->set_notify_admin($notify_type, $notify_content);
		redirect(base_url($this->_module_slug));
	}

	function admin_delete_trash() {
		$this->_initialize_admin();
		$this->_validate_access_role();

		$this->_module_slug = 'thung-rac/phieu-xuat';
		$id = (int) $this->input->get('id');
		$row = $this->get($id);
		if ($id != 0 && !empty($row)) {
			if ($this->M_output_voucher->delete($id)) {
				$this->M_output_voucher_details->delete($id);
				$notify_type = 'success';
				$notify_content = "Đã xóa hóa đơn bán hàng!";
			} else {
				$notify_type = 'danger';
				$notify_content = "Chưa xóa hóa đơn bán hàng!";
			}
		} else {
			$notify_type = 'warning';
			$notify_content = "Hóa đơn bán hàng không tồn tại!";
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
				$this->_message_success = 'Đã xóa các hóa đơn bán hàng được chọn!';
				$this->_message_warning = 'Bạn chưa chọn hóa đơn bán hàng nào!';
				$ids = $this->input->post('idcheck');

				if (is_array($ids) && !empty($ids)) {
					foreach ($ids as $id) {
						$row = $this->get($id);
						if ($this->M_output_voucher->delete($id)) {
							$this->M_output_voucher_details->delete($id);
							// if ($this->M_output_voucher->update($id, array('deleted' => 1, 'deleted_by' => get_current_user_id()))) {
							$notify_type = 'success';
							$notify_content = $this->_message_success;
						} else {
							$notify_type = 'danger';
							$notify_content = $this->_message_danger;
						}
					}
					add_activity("Người dùng xóa các hóa đơn #ID: " . implode(', ', $ids));
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
