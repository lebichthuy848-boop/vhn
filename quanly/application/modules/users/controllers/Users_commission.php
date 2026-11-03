<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Users_commission extends Layout {

    private $_module_slug = 'giao-dich';

    function __construct() {
        parent::__construct();
        $this->_data['module_slug'] = $this->_module_slug;
				$_breadcrumbs_admin[] = array(
					'url' => '',
					'name' => 'Giao dịch',
					'image' => base_url('assets/Frest/app-assets/images/svg/ico/ico-trade.svg'),
				);
				$this->_data['breadcrumbs_admin'] = $_breadcrumbs_admin;
    }

    function ajax_change_status() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = show_alert_warning('Kiểm tra lại dữ liệu');

        $post = $this->input->post();
        if (!empty($post)) {
            $this->_initialize_admin();
            $id = $this->input->post('id');
            $row = $this->get(array(
                'id' => $id
            ));
            if(!(is_array($row) && !empty($row))){
                $message['status'] = 'error';
                $message['content'] = null;
                $message['message'] = show_alert_danger('Giao dịch không tồn tại!');
                echo json_encode($message);
                exit();
            }
            $status = (int)$this->input->post('status');
            $verify_by = $this->_data['userid'];
            $time = time();
            $args = array(
                'id' => $id
            );
            $data = array(
                'status' => $status,
                'verified' => $time,
                'verify_by' => $verify_by
            );
            $bool = $this->update($args, $data);
            if ($bool) {
                $id = $row['order_id'];
                $output_voucher = $this->M_output_voucher->get($id);
                if($id == 0 || !(is_array($output_voucher) && !empty($output_voucher))){
                    $message['status'] = 'error';
                    $message['content'] = null;
                    $message['message'] = show_alert_success('Đơn hàng không tồn tại! Vui lòng kiểm tra lại!');
                    echo json_encode($message);
                    exit();
                }
                $data_output_voucher = array(
                    'status' => $status,
                    'modified' => $time
                );
                if ($this->M_output_voucher->update($id, $data_output_voucher)) {
                    $data_commission = array(
                        'status' => $status,
                        'verified' => $time,
                        'verify_by' => $verify_by
                    );
                    $this->M_users_commission->update(array('order_id' => $id), $data_commission);
                }

                if($status == 1){
                    $user_id = $row['user_id'];
                    $user = $this->M_users->get($user_id);
                    if(is_array($user) && !empty($user)){
                        $net_revenue = $this->get_net_revenue($user_id);

                        $ref_net_revenue = 0;
                        $ref_users = $this->M_users->gets(array(
                            'referred_by' => $user_id
                        ));
                        if(is_array($ref_users) && !empty($ref_users)){
                            $in_user_id = array_column($ref_users, 'userid');
                            $ref_net_revenue = $this->get_net_revenue($in_user_id);
                        }
                        $net_revenue += $ref_net_revenue;

                        $level = 'MEMBER';
                        if($net_revenue >= 5000000 && $net_revenue < 10000000){
                            $level = 'RESELLER';
                        }elseif($net_revenue >= 10000000 && $net_revenue < 20000000){
                            $level = 'DEALER';
                        }elseif($net_revenue >= 20000000){
                            $level = 'TRADER';
                        }
                        if($level != 'MEMBER' && $user['level'] != 'TRADER'){
                            $this->M_users->update($user_id, array('level' => $level));
                        }
                    }
                    $message['status'] = 'success';
                    $message['content'] = display_label('Khả dụng');
                    $message['message'] = show_alert_success('Xác nhận yêu cầu thành công!');
                }else{
                    $message['status'] = 'success';
                    $message['content'] = display_label('Đã hủy yêu cầu', 'danger');
                    $message['message'] = show_alert_success('Hủy đơn hàng thành công!');
                }
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
			'status' => 'ASC',
            'created' => 'DESC'
		);
		$args = array();
		$args['order_by'] = $order_by;

		return $args;
	}

    function counts($options = array()) {
        $default_args = $this->default_args();

        if (is_array($options) && !empty($options)) {
            $args = array_merge($default_args, $options);
        } else {
            $args = $default_args;
        }
        return $this->M_users_commission->counts($args);
    }

	function validate_exist($args) {
        $data = $this->get($args);

        if (is_array($data) && !empty($data)) {
            return TRUE;
        }

        return FALSE;
    }

    function get($args) {
        return $this->M_users_commission->get($args);
    }

    function gets($options = array()) {
		$default_args = $this->default_args();

		if (is_array($options) && !empty($options)) {
			$args = array_merge($default_args, $options);
		} else {
			$args = $default_args;
		}
        return $this->M_users_commission->gets($args);
    }

    function get_total_value($options = array()) {
        $value = 0;
        $default_args = $this->default_args();

        if (is_array($options) && !empty($options)) {
            $args = array_merge($default_args, $options);
        } else {
            $args = $default_args;
        }
        return $this->M_users_commission->get_total_value($args);
    }

    function get_commission_user($in_user_id = 0) {
        $total_commission_buy = $this->M_users_commission->get_total(array(
            'in_user_id' => $in_user_id,
            'status' => 1,
            'in_action' => array('SUB_BUY_MY', 'SUB_BUY_ROOT')
        ));

        $total_buy = $this->M_users_commission->get_total(array(
            'in_user_id' => $in_user_id,
            'status' => 1,
            'in_action' => array('BUY')
        ));

        $balance =  $total_commission_buy + $total_buy;

        return array(
            'total_commission_buy' => abs($total_commission_buy),
            'total_buy' => abs($total_buy),
            'balance' => abs($balance),
        );
    }

    function get_balance($in_user_id = 0) {
        $data = $this->get_commission_user($in_user_id);
        return $data['balance'];
    }

    function get_net_revenue($in_user_id = 0) {
        $data = $this->get_commission_user($in_user_id);
        return $data['total_buy'];
    }

    function add($data = NULL) {
        if (empty($data)) {
            return 0;
        }
        return $this->M_users_commission->add($data);
    }

    function update($args, $data) {
        return $this->M_users_commission->update($args, $data);
    }

    function delete($args) {
        return $this->M_users_commission->delete($args);
    }

    function admin_index() {
        $this->_initialize_admin();
        $this->redirect_admin();

        // $user_id = 31;
        // echo get_balance($user_id);
        // echo "<br/>" . get_net_revenue($user_id);
        // die;

        // $user_id = 31;
        // echo $this->get_balance($user_id);
        // echo "<br/>" . get_balance($user_id);
        // $ref_users = $this->M_users->gets(array(
        //     'referred_by' => $user_id
        // ));
        // if(is_array($ref_users) && !empty($ref_users)){
        //     $in_user_id = array_column($ref_users, 'userid');
        //     echo "<pre>";
        //     print_r($in_user_id);
        //     echo "</pre>";
        //     die();
        // }
        // die;

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
            'folder' => 'users',
            'name' => 'admin-commission-items',
        );
        $this->set_modules();

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $args = $this->default_args();
        $order_by = array(
            'id' => 'DESC',
            // 'status' => 'ASC',
            // 'created' => 'DESC'
        );
        $args['order_by'] = $order_by;

        if (isset($get['q']) && trim($get['q']) != '') {
            $args['q'] = $get['q'];
        }

        $total = $this->counts($args);
        $perpage = 50;
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

        $this->_data['rows'] = $this->M_users_commission->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;

        $this->_data['title'] = 'Hệ thống giao dịch - ' . $this->_data['title'];
        $this->_data['main_content'] = 'users/admin/view_page_commission_index';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_content() {
        $this->_initialize_admin();
        $this->redirect_admin();

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
            'folder' => 'users',
            'name' => 'admin-content-commission-validate',
        );
        $this->set_modules();

        $post = $this->input->post();
        if (!empty($post)) {
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('user_id', 'Chọn thành viên', 'trim|required');
            $this->form_validation->set_rules('amount', 'Nhập số tiền cần nạp', 'trim|required');

            if ($this->form_validation->run($this)) {
                $err = FALSE;
                $user_id = $this->input->post('user_id');
	            $amount = filter_var($this->input->post('amount'), FILTER_SANITIZE_NUMBER_INT);
	            $action = 'PAY_IN';
	            $value_cost = $amount;
	            $percent = 0;
	            $value = $amount;
	            $message = $this->input->post('message');
	            $verify_by = isset($this->_data['userid']) ? $this->_data['userid'] : NULL;
                $time = time();
	            $data = array(
	                'order_id' => NULL,
	                'user_id' => $user_id,
	                'extend_by' => NULL,
	                'action' => $action,
	                'value_cost' => $value_cost,
	                'percent' => $percent,
	                'value' => $value,
	                'message' => $message,
	                'status' => 1,
	                'created' => $time,
	                'verified' => $time,
					'verify_by' => $verify_by
	            );

                $insert_id = $this->add($data);
                if ($insert_id == 0) {
                    $err = TRUE;
                }

                if ($err === FALSE) {
                    $row = $this->get(array(
                        'id' => $insert_id
                    ));
                    if(is_array($row) && !empty($row)){
                        $value = formatRice($row['value_cost']);
                        $this->load->model('users/m_users_notification', 'M_users_notification');
                        $action = 'USER_PAY_IN';
                        $data_notification = array(
                            'actor_id' => $verify_by,
                            'notifier_id' => $row['user_id'],
                            'action' => $action,
                            'object_id' => $row['id'],
                            'title' => 'Nạp tiền vào tài khoản',
                            'description' => "Nạp tiền thành công, tài khoản của bạn được +" . $value . "đ vào ví",
                            'message' => "Hệ thống xác nhận bạn đã nạp " . $value . " vào ví tài khoản",
                            'history' => NULL,
                            'status' => -1,
                            'created' => $time
                        );
                        $notification_id = $this->M_users_notification->add($data_notification);

                        //push notification
                        $this->load->model('users/m_users_fcm_register', 'M_users_fcm_register');
                        $args_fcm_register = array(
                            'user_id' => $row['user_id'],
                            'order_by' => array(
                                'id' => 'DESC'
                            )
                        );
                        $fcm_register = $this->M_users_fcm_register->get_by($args_fcm_register);
                        if(isset($fcm_register['token'])){
                            $registration_ids = array(
                                $fcm_register['token']
                            );
                            $title = "Thông báo nạp tiền vào tài khoản";
                            $body = "Nạp tiền thành công, tài khoản của bạn được +" . $value . "đ";
                            $notification_options = array(
                                'title' => $title,
                                'body' => $body,
                            );
                            $notification_data = array(
                                "title" => $title,
                                "message" => $body,
                                "image" => "https://ledu.vn/media/images/slide-le-du1.png",
                                "action" => "BUY",
                                "action_destination" => $notification_id
                            );
                            $push_notification = push_notification($registration_ids, $notification_options, $notification_data);
                        }
                    }

                    $notify_type = 'success';
                    $notify_content = 'Nạp tiền cho thành viên thành công!';
                    $this->set_notify_admin($notify_type, $notify_content);

                    redirect(base_url($this->_module_slug));
                } else {
                    $notify_type = 'danger';
                    $notify_content = 'Có lỗi xảy ra!';
                    $this->set_notify_admin($notify_type, $notify_content);
                }
            }
        }
        $this->_data['users'] = modules::run('users/gets', array('role' => 'MEMBER'));

        $this->_data['title'] = 'Nạp tiền vào tài khoản - ' . $this->_data['title'];
        $this->_data['main_content'] = 'users/admin/view_page_commission_content';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_main() {
        $this->_initialize_admin();
        $this->redirect_admin();
        $post = $this->input->post();
        if (!empty($post)) {
            $action = $this->input->post('action');
            if ($action == 'delete') {
                $this->_message_success = 'Đã xóa các giao dịch được chọn!';
                $this->_message_warning = 'Bạn chưa chọn giao dịch nào!';
                $ids = $this->input->post('idcheck');

                if (is_array($ids) && !empty($ids)) {
                    foreach ($ids as $id) {
                        $row = $this->get(array('id' => $id));
                        if (!empty($row) && $this->M_users_commission->delete(array('id' => $id))) {
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
                redirect(base_url($this->_module_slug . '/content'));
            }
        } else {
            redirect(base_url($this->_module_slug));
        }
    }

    function admin_delete() {
        $this->_initialize_admin();
        $this->redirect_admin();

        $this->_message_success = 'Đã xóa giao dịch!';
        $this->_message_warning = 'Giao dịch này không tồn tại!';
        $id = $this->input->get('id');
        if ($id != 0) {
            if ($this->M_users_commission->delete(array('id' => $id))) {
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
}
/* End of file Users_commission.php */
/* Location: ./application/modules/users/controllers/Users_commission.php */