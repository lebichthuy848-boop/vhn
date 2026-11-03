<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Users_notification extends Layout {

    private $_module_slug = 'notification';

    function __construct() {
        parent::__construct();
        $this->_data['module_slug'] = $this->_module_slug;
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
            $err = FALSE;
            $id = $this->input->post('id');
            $row = $this->get(array(
                'id' => $id
            ));
            if(!(is_array($row) && !empty($row))){
                $message['status'] = 'error';
                $message['content'] = null;
                $message['message'] = show_alert_danger('Thông báo không tồn tại!');
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
                if($status == 1){
                    if(in_array($row['action'], array('BUY_PACKAGE'))){
                        $args_package = array(
                            'order_id' => $row['order_id'],
                            'in_action' => array('SUB_BUY_PACKAGE_ROOT', 'SUB_BUY_PACKAGE', 'SYSTEM_PACKAGE'),
                            'extend_by' => $row['user_id']
                        );
                        $this->update($args_package, $data);
                        $this->M_users->update($row['user_id'], array(
                            'level' => $row['order_id']
                        ));

                        $package_name = lcfirst(display_value_array($this->config->item($row['order_id'], 'users_modules_package_info'), 'name'));
                        $value = formatRice($row['value_cost']);
                        $this->load->model('users/m_users_notification', 'M_users_notification');
                        $action = 'USER_BUY_PACKAGE';
                        $data_notification = array(
                            'actor_id' => $verify_by,
                            'notifier_id' => $row['user_id'],
                            'action' => $action,
                            'object_id' => $row['id'],
                            'title' => 'Mua gói thành viên',
                            'description' => "Người dùng mua " . $package_name . " với giá " . $value . "đ",
                            'message' => "Hệ thống xác nhận bạn đã mua " . $package_name . " với giá " . $value . "đ",
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
                            $title = "Thông báo mua gói thành viên";
                            $body = "Mua " . $package_name . " với giá " . $value . "đ";
                            $notification_options = array(
                                'title' => $title,
                                'body' => $body,
                            );
                            $notification_data = array(
                                "title" => $title,
                                "message" => $body,
                                "image" => "https://ledu.vn/media/images/slide-le-du1.png",
                                "action" => "USER_BUY_PACKAGE",
                                "action_destination" => $notification_id
                            );
                            $push_notification = push_notification($registration_ids, $notification_options, $notification_data);
                        }

                        $subs = $this->gets(array(
                            'order_id' => $row['order_id'],
                            'in_action' => array('SUB_BUY_PACKAGE_ROOT', 'SUB_BUY_PACKAGE'),
                            'extend_by' => $row['user_id']
                        ));
                        if(is_array($subs) && !empty($subs)){
                            foreach ($subs as $sub) {
                                $type = '';
                                if($sub['action'] == 'SUB_BUY_PACKAGE_ROOT'){
                                    $type = 'trực tiếp ';
                                }
                                $value = formatRice($sub['value']);
                                $value_cost = formatRice($sub['value_cost']);
                                $percent = $sub['percent'];
                                $action = 'USER_COMMISSION_BUY_PACKAGE';
                                $data_notification = array(
                                    'actor_id' => $verify_by,
                                    'notifier_id' => $sub['user_id'],
                                    'action' => $action,
                                    'object_id' => $sub['id'],
                                    'title' => "Hưởng hoa hồng " . $type . "từ thành viên mua gói",
                                    'description' => "Người dùng hưởng hoa hồng " . $type . $percent . "%(" . $value . "đ) từ thành viên mua " . $package_name . " với giá " . $value_cost . "đ",
                                    'message' => "Bạn đã hưởng hoa hồng " . $type . $percent . "%(" . $value . "đ) từ thành viên mua " . $package_name . " với giá " . $value_cost . "đ",
                                    'history' => NULL,
                                    'status' => -1,
                                    'created' => $time
                                );
                                $notification_id = $this->M_users_notification->add($data_notification);

                                //push notification
                                $args_fcm_register = array(
                                    'user_id' => $sub['user_id'],
                                    'order_by' => array(
                                        'id' => 'DESC'
                                    )
                                );
                                $fcm_register = $this->M_users_fcm_register->get_by($args_fcm_register);
                                if(isset($fcm_register['token'])){
                                    $registration_ids = array(
                                        $fcm_register['token']
                                    );
                                    $title = "Thông báo hưởng hoa hồng " . $type . "từ thành viên mua gói";
                                    $body = "Hưởng hoa hồng " . $type . $percent . "%(" . $value . "đ) từ thành viên mua " . $package_name . " với giá " . $value_cost . "đ";
                                    $notification_options = array(
                                        'title' => $title,
                                        'body' => $body,
                                    );
                                    $notification_data = array(
                                        "title" => $title,
                                        "message" => $body,
                                        "image" => "https://ledu.vn/media/images/slide-le-du1.png",
                                        "action" => "USER_COMMISSION_BUY_PACKAGE",
                                        "action_destination" => $notification_id
                                    );
                                    $push_notification = push_notification($registration_ids, $notification_options, $notification_data);
                                }
                            }
                        }
                    }elseif(in_array($row['action'], array('PAY_IN'))){
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
                    }elseif(in_array($row['action'], array('WITHDRAWAL'))){
                        $user_id = $row['user_id'];
                        $user = modules::run('users/get', $user_id);
                        $role = isset($user['role']) ? $user['role'] : '';
                        if($role == 'MEMBER'){
                            $pay_in = modules::run('users/users_notification/get_total_value', array(
                                'user_id' => $user_id,
                                'status' => 1,
                                'in_action' => array('PAY_IN')
                            ));

                            $withdrawal = modules::run('users/users_notification/get_total_value', array(
                                'user_id' => $user_id,
                                'status' => 1,
                                'in_action' => array('WITHDRAWAL'),
                                'not_in_id' => $row['id'],
                            ));

                            $total_notification_package = modules::run('users/users_notification/get_total_value', array(
                                'user_id' => $user_id,
                                'status' => 1,
                                'in_action' => array('SUB_BUY_PACKAGE', 'SUB_BUY_PACKAGE_ROOT')
                            ));

                            $total_notification_buy = modules::run('users/users_notification/get_total_value', array(
                                'user_id' => $user_id,
                                'status' => 1,
                                'in_action' => array('SUB_BUY', 'SUB_BUY_ROOT')
                            ));

                            $total_buy = modules::run('users/users_notification/get_total_value', array(
                                'user_id' => $user_id,
                                'status' => 1,
                                'in_action' => array('BUY')
                            ));

                            $total_buy_credit_card =  modules::run('users/users_notification/get_total_value', array(
                                'user_id' => $user_id,
                                'status' => 1,
                                'in_action' => array('BUY'),
                                'payment' => 'CREDIT_CARD',
                            ));

                            $total_buy_system = modules::run('users/users_notification/get_total_value', array(
                                'user_id' => $user_id,
                                'status' => 1,
                                'in_action' => array('BUY_SYSTEM')
                            ));

                            $balance = $pay_in + $total_notification_package + $total_notification_buy - abs($total_buy_credit_card) - abs($total_buy_system) - abs($withdrawal);
                            $amount = $row['value_cost'];
                            if($balance < $amount){
                                $args = array(
                                    'id' => $id
                                );
                                $data = array(
                                    'status' => 0,
                                    'verified' => 0,
                                    'verify_by' => NULL
                                );
                                $this->update($args, $data);
                                $message['status'] = 'error';
                                $message['content'] = null;
                                $message['message'] = show_alert_danger('Số dư tài khoản không đủ điều kiện thực hiện thông báo!');
                                echo json_encode($message);
                                exit();
                            }
                        }elseif ($role == 'PARTNER') {
                            $withdrawal = $this->get_total_value(array(
                                'user_id' => $user_id,
                                'status' => 1,
                                'in_action' => array('WITHDRAWAL'),
                                'not_in_id' => $row['id'],
                            ));

                            $total_sell_credit_card =  modules::run('users/users_notification/get_total_value', array(
                                'user_id' => $user_id,
                                'status' => 1,
                                'in_action' => array('SELL'),
                                'payment' => 'CREDIT_CARD',
                            ));
                            $balance = abs($total_sell_credit_card) - abs($withdrawal);
                            $amount = $row['value_cost'];
                            if($balance < $amount){
                                $args = array(
                                    'id' => $id
                                );
                                $data = array(
                                    'status' => 0,
                                    'verified' => 0,
                                    'verify_by' => NULL
                                );
                                $this->update($args, $data);
                                $message['status'] = 'error';
                                $message['content'] = null;
                                $message['message'] = show_alert_danger('Số dư tài khoản không đủ điều kiện thực hiện thông báo!');
                                echo json_encode($message);
                                exit();
                            }
                        }else{
                            echo json_encode($message);
                            exit();
                        }
                    }
                    $message['status'] = 'success';
                    $message['content'] = display_label('Khả dụng');
                    $message['message'] = show_alert_success('Xác nhận yêu cầu thành công!');
                }else{
                    $message['status'] = 'success';
                    $message['content'] = display_label('Đã hủy yêu cầu', 'danger');
                    $message['message'] = show_alert_success('Hủy yêu cầu thành công!');
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

    function ajax_get_user_by_role() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = 'Kiểm tra lại dữ liệu';

        $post = $this->input->post();
        if (!empty($post)) {
            $role = $this->input->post('role');
            $users = modules::run('users/gets', array('role' => $role));
            $user_id = isset($users[0]['userid']) ? $users[0]['userid'] : 0;
            $token = $this->get_token($user_id);
            $message['status'] = 'success';
            $message['content'] = array(
                'users' => display_option_select($users, 'userid', 'full_name', $user_id),
                'token' => $token
            );
            $message['message'] = 'Tải dữ liệu thành công!';
        }
        echo json_encode($message);
        exit();
    }

    function ajax_get_token() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = 'Kiểm tra lại dữ liệu';

        $post = $this->input->post();
        if (!empty($post)) {
            $user_id = $this->input->post('user_id');
            $token = $this->get_token($user_id);
            $message['status'] = 'success';
            $message['content'] = $token;
            $message['message'] = 'Tải dữ liệu thành công!';
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
        return $this->M_users_notification->counts($args);
    }

	function validate_exist($args) {
        $data = $this->get($args);

        if (is_array($data) && !empty($data)) {
            return TRUE;
        }

        return FALSE;
    }

    function get($args) {
        return $this->M_users_notification->get($args);
    }

    function gets($options = array()) {
		$default_args = $this->default_args();

		if (is_array($options) && !empty($options)) {
			$args = array_merge($default_args, $options);
		} else {
			$args = $default_args;
		}
        return $this->M_users_notification->gets($args);
    }

    function get_token($user_id = 0) {
        $token = '';
        if($user_id != 0){
            $this->load->model('users/m_users_fcm_register', 'M_users_fcm_register');
            $args_fcm_register = array(
                'user_id' => $user_id,
                'order_by' => array(
                    'id' => 'DESC'
                )
            );
            $fcm_register = $this->M_users_fcm_register->get_by($args_fcm_register);
            if(isset($fcm_register['token'])){
                $token = $fcm_register['token'];
            }
        }
        return $token;
    }

    function add($data = NULL) {
        if (empty($data)) {
            return 0;
        }
        return $this->M_users_notification->add($data);
    }

    function update($args, $data) {
        return $this->M_users_notification->update($args, $data);
    }

    function delete($args) {
        return $this->M_users_notification->delete($args);
    }

    function admin_index() {
        $this->_initialize_admin();
        $this->redirect_admin();
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
            'name' => 'admin-notification-items',
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
            $config['base_url'] = get_admin_url($this->_module_slug);
            $config['suffix'] = '?' . http_build_query($get, '', "&");
            $config['first_url'] = get_admin_url($this->_module_slug . '?' . http_build_query($get, '', "&"));
            $config['uri_segment'] = $segment;
        } else {
            $config['base_url'] = get_admin_url($this->_module_slug);
            $config['uri_segment'] = $segment;
        }

        $this->pagination->initialize($config);

        $pagination = $this->pagination->create_links();
        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);

        $this->_data['rows'] = $this->M_users_notification->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;

        $this->_data['title'] = 'Thông báo - ' . $this->_data['title'];
        $this->_data['main_content'] = 'users/admin/view_page_notification_index';
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
            'name' => 'admin-content-notification-validate',
        );
        $this->set_modules();

        $post = $this->input->post();
        if (!empty($post)) {
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('user_id', 'Chọn thành viên', 'trim|required');
            $this->form_validation->set_rules('title', 'Nhập tiêu đề thông báo', 'trim|required');
            $this->form_validation->set_rules('message', 'Nhập nội dung thông báo', 'trim|required');

            if ($this->form_validation->run($this)) {
                $verify_by = $this->_data['userid'];
                $role = $this->input->post('role');
                $user_id = $this->input->post('user_id');
	            $token = $this->input->post('token');
                $title = $this->input->post('title');
                $body = $message = $this->input->post('message');
                $time = time();

                $this->load->model('users/m_users_notification', 'M_users_notification');
                $action = 'DEFAULT';
                $data_notification = array(
                    'actor_id' => $verify_by,
                    'notifier_id' => $user_id,
                    'action' => $action,
                    'object_id' => NULL,
                    'title' => $title,
                    'description' => $message,
                    'message' => $message,
                    'history' => NULL,
                    'status' => -1,
                    'created' => $time
                );
                $notification_id = $this->M_users_notification->add($data_notification);

                if($notification_id != 0){
                    $notify_type = 'success';
                    $notify_content = 'Gửi thông báo thành công!';
                    $this->set_notify_admin($notify_type, $notify_content);
                    //push notification
                    if(trim($token) == ''){
                        $token = $this->get_token($user_id);
                    }
                    if(trim($token) != ''){
                        $registration_ids = array(
                            $token
                        );
                        $notification_options = array(
                            'title' => $title,
                            'body' => $body,
                        );
                        $notification_data = array(
                            "title" => $title,
                            "message" => $body,
                            "image" => "https://ledu.vn/media/images/slide-le-du1.png",
                            "action" => "DEFAULT",
                            "action_destination" => $notification_id
                        );
                        if($role == 'MEMBER'){
                            $push_notification = push_notification($registration_ids, $notification_options, $notification_data);
                        }else{
                            $push_notification = push_notification_partner($registration_ids, $notification_options, $notification_data);
                        }
                        $push_notification = (array)json_decode($push_notification);
                        if($push_notification['status'] != 'success'){
                            $this->M_users_notification->delete(array('id' => $notification_id));
                            $notify_type = 'danger';
                            $notify_content = 'Có lỗi xảy ra! Thông báo chưa được gửi!';
                            $this->set_notify_admin($notify_type, $notify_content);
                        }
                    }
                } else {
                    $notify_type = 'danger';
                    $notify_content = 'Lỗi gửi thông báo!';
                    $this->set_notify_admin($notify_type, $notify_content);
                }
            }
        }
        $users = modules::run('users/gets', array('role' => 'MEMBER'));
        $user_id = isset($users[0]['userid']) ? $users[0]['userid'] : 0;
        $token = $this->get_token($user_id);
        $this->_data['users'] = $users;
        $this->_data['token'] = $token;

        $this->_data['title'] = 'Gửi thông báo - ' . $this->_data['title'];
        $this->_data['main_content'] = 'users/admin/view_page_notification_content';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_main() {
        $this->_initialize_admin();
        $this->redirect_admin();
        $post = $this->input->post();
        if (!empty($post)) {
            $action = $this->input->post('action');
            if ($action == 'delete') {
                $this->_message_success = 'Đã xóa các thông báo được chọn!';
                $this->_message_warning = 'Bạn chưa chọn thông báo nào!';
                $ids = $this->input->post('idcheck');

                if (is_array($ids) && !empty($ids)) {
                    foreach ($ids as $id) {
                        $row = $this->get(array('id' => $id));
                        if (!empty($row) && $this->M_users_notification->delete(array('id' => $id))) {
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
                redirect(get_admin_url($this->_module_slug));
            } elseif ($action == 'content') {
                redirect(get_admin_url($this->_module_slug . '/content'));
            }
        } else {
            redirect(get_admin_url($this->_module_slug));
        }
    }

    function admin_delete() {
        $this->_initialize_admin();
        $this->redirect_admin();

        $this->_message_success = 'Đã xóa thông báo!';
        $this->_message_warning = 'Thông báo này không tồn tại!';
        $id = $this->input->get('id');
        if ($id != 0) {
            if ($this->M_users_notification->delete(array('id' => $id))) {
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
        redirect(get_admin_url($this->_module_slug));
    }
}
/* End of file Users_notification.php */
/* Location: ./application/modules/users/controllers/Users_notification.php */