<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Users extends Layout {

	private $_remember_name = 'siteAuth';
	public $_path = '';
	private $_allowed_field = array('active', 'inhome', 'is_top');

	function __construct() {
		parent::__construct();
		$this->load->model('users/m_groups_users', 'M_groups_users');
		$this->_data['breadcrumbs_module_name'] = 'Tài khoản';
		$this->_path = get_module_path('users');
	}

	function ajax_get() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$message = array();
		$message['status'] = 'warning';
		$message['content'] = null;
		$message['message'] = 'Kiểm tra thông tin';

		if (!$this->session->userdata('logged_in')) {
			$message['status'] = 'danger';
			$message['content'] = null;
			$message['message'] = 'Vui lòng đăng nhập để thực hiện chưc năng này!';
			echo json_encode($message);
			exit();
		}

		$post = $this->input->post();
		if (!empty($post)) {
			$user_id = $this->_data['userid'];
			$row = $this->get($user_id);

			if (is_array($row) && !empty($row)) {
				$row['link_share'] = site_url('dang-ky') . '?ref=' . $row['username'];
				$message['status'] = 'success';
				$message['content'] = $row;
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

	function admin_ajax_change_field() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		$post = $this->input->post();
		if (!empty($post)) {
			$value = $this->input->post('value');
			$id = $this->input->post('id');
			$field = $this->input->post('field');
			$massage_success = $this->input->post('massage_success');
			$massage_warning = $this->input->post('massage_warning');
			$data = array(
				$field => $value,
			);
			if (!in_array($field, $this->_allowed_field)) {
				$notify_type = 'danger';
				$notify_content = 'Trường này không tồn tại!';
			} else if ($this->M_users->update($id, $data)) {
				if ($value == 1) {
					$notify_type = 'success';
					$notify_content = $massage_success;
				} else {
					$notify_type = 'warning';
					$notify_content = $massage_warning;
				}
			} else {
				$notify_type = 'danger';
				$notify_content = 'Dữ liệu chưa lưu!';
			}
			$this->set_notify_admin($notify_type, $notify_content);
			$this->load->view('layout/notify-ajax', NULL);
		} else {
			redirect(base_url());
		}
	}

	function gets_items_field($field = '', $number = 3) {
		if ((trim($field) == '') || !in_array($field, $this->_allowed_field)) {
			return null;
		}
		$args = $this->default_args();
		$args[$field] = 1;
		if ($number > 0) {
			$rows = $this->M_users->gets($args, $number, 0);
		} else {
			$rows = $this->M_users->gets($args);
		}

		return $rows;
	}

	function login_attempt($seconds) {
		$this->load->model('users/m_users_attempts', 'M_users_attempts');
		$ip = $_SERVER['REMOTE_ADDR'];
		$oldest = strtotime(date("Y-m-d H:i:s") . " - " . $seconds . " seconds");
		$oldest = date("Y-m-d H:i:s", $oldest);
		$remove = $this->M_users_attempts->delete(array('when' => $oldest));
		$data = array('ip' => $ip, 'when' => date("Y-m-d H:i:s"));
		$insert = $this->M_users_attempts->add($data);
	}

	function login_attempt_count() {
		$this->load->model('users/m_users_attempts', 'M_users_attempts');
		$ip = $_SERVER['REMOTE_ADDR'];
		return $this->M_users_attempts->counts(array('ip' => $ip));
	}

	function ajax_login_attempt_reset() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$message = array();
		$message['status'] = 'warning';
		$message['content'] = null;
		$message['message'] = 'Kiểm tra thông tin';

		$post = $this->input->post();
		if (!empty($post)) {
			$this->load->model('users/m_users_attempts', 'M_users_attempts');
			$ip = $this->input->post('ip');
			$bool = $this->M_users_attempts->delete(array('ip' => $ip));
			if ($bool) {
				$message['status'] = 'success';
				$message['content'] = null;
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

	function default_args() {
		$order_by = array(
			'userid' => 'DESC',
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
		return $this->M_users->gets($args);
	}

	function counts($options = array()) {
		$default_args = $this->default_args();

		if (is_array($options) && !empty($options)) {
			$args = array_merge($default_args, $options);
		} else {
			$args = $default_args;
		}
		return $this->M_users->counts($args);
	}

	function get($id) {
		return $this->M_users->get($id);
	}

	function get_by($options = array()) {
		$default_args = $this->default_args();

		if (is_array($options) && !empty($options)) {
			$args = array_merge($default_args, $options);
		} else {
			$args = $default_args;
		}
		return $this->M_users->get_by($args);
	}

	function get_num_all_data() {
		return $this->counts(array());
	}

	function get_num_new_data() {
		return $this->counts(array('active' => 0));
	}

	function set_last_login($userid) {
		$data = array('last_login' => time());
		return $this->M_users->update($userid, $data);
	}

	function set_last_ip($userid) {
		$data = array('last_ip' => $this->input->ip_address());
		return $this->M_users->update($userid, $data);
	}

	function set_last_agent($userid) {
		$this->load->library('user_agent');

		if ($this->agent->is_browser()) {
			$agent = $this->agent->browser() . ' ' . $this->agent->version();
		} elseif ($this->agent->is_robot()) {
			$agent = $this->agent->robot();
		} elseif ($this->agent->is_mobile()) {
			$agent = $this->agent->mobile();
		} else {
			$agent = 'Unidentified User Agent';
		}

		$data = array('last_agent' => $agent);

		return $this->M_users->update($userid, $data);
	}

	function admin_ref_setting() {
		$this->_initialize_admin();
		$this->redirect_admin();

		$segment = 5;
		$user_id = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
		$row = modules::run('users/get', $user_id);
		$this->_module_slug = 'users';
		$this->_data['module_slug'] = $this->_module_slug;
		if (!(is_array($row) && !empty($row))) {
			redirect(base_url($this->_module_slug));
		}
		$this->_data['row'] = $row;

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
			'folder' => 'users',
			'name' => 'admin-ref-setting',
		);
		$this->set_modules();

		$post = $this->input->post();
		if (!empty($post) && isset($post['referred_by'])) {
			$err = FALSE;
			$referred_by = $this->input->post('referred_by');
			$data = array(
				'referred_by' => $referred_by,
			);
			if (!$this->M_users->update($user_id, $data)) {
				$err = TRUE;
			}

			if ($err === FALSE) {
				$notify_type = 'success';
				$notify_content = 'Đã cài đặt người giới thiệu cho người dùng ' . $row['full_name'] . '!';
				$this->set_notify_admin($notify_type, $notify_content);

				redirect(base_url($this->_module_slug));
			} else {
				$notify_type = 'danger';
				$notify_content = 'Có lỗi xảy ra!';
				$this->set_notify_admin($notify_type, $notify_content);
			}
		}
		$this->_data['users'] = $this->gets(array(
			'role' => 'MEMBER',
			'not_in_id' => array($user_id),
		));

		$this->_data['title'] = 'Cài đặt người giới thiệu cho người dùng ' . $row['full_name'] . ' - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
		$this->_data['main_content'] = 'users/admin/view_page_ref_setting';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_profile() {
		$this->_initialize_admin();
		$this->redirect_admin();

		$this->_all_css_admin[] = array(
			'folder' => 'pages',
			'name' => 'page-user-profile',
		);
		$this->set_custom_all_admin();

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
			'folder' => 'bootstrap-fileinput/css',
			'name' => 'fileinput',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'bootstrap-fileinput/js',
			'name' => 'fileinput.min',
		);

		$this->set_plugins_admin();

		$user_id = $this->_data['userid'];
		$row = $this->get($user_id);
		$post = $this->input->post();
		if (!empty($post)) {
			$is_admin = FALSE;
			if(isset($row['role']) && $row['role'] == 'ADMIN'){
				$is_admin = TRUE;
			}
			$password = $this->input->post('password');
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('full_name', 'Họ tên', 'trim|required');
			if ($is_admin) {
				$this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required|min_length[5]|callback_check_current_username_availablity|min_length[2]|max_length[60]');
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_current_email_availablity');
			}
			if (trim($password) != '') {
				$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|alpha_numeric');
				$this->form_validation->set_rules('passconf', 'Lặp lại mật khẩu', 'trim|required|alpha_numeric|matches[password]');
			}
			if ($this->form_validation->run($this)) {
				$full_name = $this->input->post('full_name');
				$username = $this->input->post('username');
				$data = array(
					'full_name' => $full_name,
					'gender' => $this->input->post('gender'),
					'birthday' => strtotime($this->input->post('birthday')),
					'phone' => $this->input->post('phone'),
					'address' => $this->input->post('address'),
				);
				if ($is_admin) {
					$data['username'] = $username;
					$data['email'] = $this->input->post('email');
				}
				if (trim($password) != '') {
					$data['password'] = encrip_password($password);
				}
				if ($this->M_users->update($user_id, $data)) {
					$logged_in_session = $this->session->userdata('logged_in');
					$logged_in_session['full_name'] = $full_name;
					if ($is_admin) {
						$logged_in_session['username'] = $username;
					}

					$input_name = 'photo';
					$info = modules::run('files/index', $input_name, $this->_path);
					if (isset($info['uploads'])) {
						$upload_images = $info['uploads']; // thông tin ảnh upload
						if ($_FILES[$input_name]['size'] != 0) {
							foreach ($upload_images as $value) {
								$file_name = $value['file_name']; //tên ảnh
								$logged_in_session['photo'] = $file_name;
								$data_images = array(
									'photo' => $file_name,
								);
								$this->M_users->update($user_id, $data_images);
							}
							if ($row['photo'] != 'no_avatar.jpg') {
								@unlink(FCPATH . $this->_path . $row['photo']);
							}
						}
					}
					$this->session->set_userdata('logged_in', $logged_in_session);

					$notify_type = 'success';
					$notify_content = 'Thông tin tài khoản đã cập nhật!';
				} else {
					$notify_type = 'danger';
					$notify_content = 'Thông tin tài khoản chưa cập nhật!';
				}
				$this->set_notify_admin($notify_type, $notify_content);
				redirect(current_url());
			}
		}

		if ($user_id != 0) {
			$this->_data['row'] = $row;
			$this->_data['breadcrumbs_module_func'] = 'Thông tin tài khoản';
			$this->_data['title'] = 'Thông tin tài khoản - ' . $this->_data['title'];
		}
		$data_commission = get_commission_user($user_id);
        $this->_data['balance'] = $data_commission['balance'];
        $this->_data['total_commission_buy'] = $data_commission['total_commission_buy'];
        $this->_data['total_buy'] = $data_commission['total_buy'];

		$this->_data['main_content'] = 'users/admin/view_page_profile';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_profile_edit() {
		$this->redirect_admin();

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
			'folder' => 'bootstrap-fileinput/css',
			'name' => 'fileinput',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'bootstrap-fileinput/js',
			'name' => 'fileinput.min',
		);

		$this->set_plugins_admin();

		$post = $this->input->post();
		if (!empty($post)) {
			$this->load->helper('language');
			$this->lang->load('form_validation', 'vietnamese');
			$this->lang->load('user', 'vietnamese');

			if ($this->input->post('userid')) {
				$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
				$this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required|callback_check_current_username_availablity|min_length[2]|max_length[60]');
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_current_email_availablity');
				$this->form_validation->set_rules('password', 'Mật khẩu', 'matches[passconf]|alpha_numeric');
				$this->form_validation->set_rules('passconf', 'Lặp lại mật khẩu', 'alpha_numeric');
				$this->form_validation->set_rules('full_name', 'Họ tên', 'trim|required|min_length[3]|max_length[60]');
				if ($this->form_validation->run($this)) {
					$userid = $this->_data['userid'];
					$username = $this->input->post('username');
					$current_photo = $this->get($userid);
					$data = array(
						'username' => $username,
						'email' => $this->input->post('email'),
						'full_name' => $this->input->post('full_name'),
						'gender' => $this->input->post('gender'),
						'birthday' => strtotime($this->input->post('birthday')),
						'sig' => $this->input->post('sig'),
						'question' => $this->input->post('question'),
						'answer' => $this->input->post('answer'),
						'view_mail' => ($this->input->post('view_mail') ? 1 : 0),
					);
					$password = $this->input->post('password');
					if (trim($password) != '') {
						$data['password'] = encrip_password($password);
					}
					if ($this->M_users->update($userid, $data)) {
						$logged_in_session = $this->session->userdata('logged_in');
						$logged_in_session['full_name'] = $this->input->post('full_name');
						$logged_in_session['username'] = $username;

						$input_name = 'photo';
						$info = modules::run('files/index', $input_name, $this->_path);
						if (isset($info['uploads'])) {
							$upload_images = $info['uploads']; // thông tin ảnh upload
							if ($_FILES[$input_name]['size'] != 0) {
								foreach ($upload_images as $value) {
									$file_name = $value['file_name']; //tên ảnh
									$logged_in_session['photo'] = $file_name;
									$data_images = array(
										'photo' => $file_name,
									);
									$this->M_users->update($userid, $data_images);
								}
								if ($current_photo['photo'] != 'no_avatar.jpg') {
									@unlink(FCPATH . $this->_path . $current_photo['photo']);
								}
							}
						}
						$this->session->set_userdata('logged_in', $logged_in_session);

						$notify_type = 'success';
						$notify_content = 'Thông tin tài khoản đã cập nhật!';
					} else {
						$notify_type = 'danger';
						$notify_content = 'Thông tin tài khoản chưa cập nhật!';
					}
					$this->set_notify_admin($notify_type, $notify_content);
					redirect(current_url());
				}
			}
		}

		$groups = modules::run('users/groups/gets');
		$this->_data['groups'] = $groups;

		$userid = $this->_data['userid'];
		if ($userid != 0) {
			$this->_modules_script[] = array(
				'folder' => 'users',
				'name' => 'admin-edit-validate',
			);
			$this->set_modules();
			$data_userid = $this->get($userid);

			$this->load->module('users/groups_users');
			$group_id = $this->groups_users->get_group_id($userid);
			$data_userid['group_id'] = $group_id['group_id'];

			$this->_data['row'] = $data_userid;
			$this->_data['breadcrumbs_module_func'] = 'Cập nhật tài khoản';
			$this->_data['title'] = 'Cập nhật tài khoản - ' . $this->_data['title'];
		}

		$this->_data['main_content'] = 'users/admin/view_page_profile_edit';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

    function admin_content() {
        $this->_initialize_admin();
        $this->redirect_admin();

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
            'folder' => 'bootstrap-fileinput/css',
            'name' => 'fileinput'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-fileinput/js',
            'name' => 'fileinput.min'
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
            'folder' => 'chosen',
            'name' => 'apps'
        );

        $this->set_plugins_admin();

        $post = $this->input->post();
        if (!empty($post)) {
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required|callback_check_current_username_availablity|min_length[2]|max_length[60]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_current_email_availablity');
            $this->form_validation->set_rules('password', 'Mật khẩu', 'matches[passconf]|alpha_numeric');
            $this->form_validation->set_rules('passconf', 'Lặp lại mật khẩu', 'alpha_numeric');
            $this->form_validation->set_rules('full_name', 'Họ tên', 'trim|required|min_length[3]|max_length[60]');

            if ($this->form_validation->run($this)) {
                $data_products = $this->input->post('products');
                if ($this->input->post('userid')) {
                    $userid = $this->input->post('userid');
                    $username = $this->input->post('username');
                    $role = $this->input->post('role');
                    $data = array(
                        'username' => $username,
                        'email' => $this->input->post('email'),
                        'role' => $role,
                        'full_name' => $this->input->post('full_name'),
                        'phone' => $this->input->post('phone'),
                        'address' => $this->input->post('address'),
                        'gender' => $this->input->post('gender'),
                        'view_mail' => $this->input->post('view_mail') ? 1 : 0,
                        'active' => 1,
                        'commission' => filter_var($this->input->post('commission'), FILTER_SANITIZE_NUMBER_INT),
                    );
                    $password = $this->input->post('password');
                    if (trim($password) != '') {
                        $data['password'] = $this->__encrip_password($password);
                    }
                    if($role == 'PARTNER'){
                        $data['business_id'] = $this->input->post('business_id');
                        $data['VAT'] = $this->input->post('VAT');
                        $data['shops_name'] = $this->input->post('shops_name');
                        $data['iframe_map'] = $this->input->post('iframe_map');
                        $data['about'] = $this->input->post('about');
                        $data['province_id'] = $this->input->post('province_id');
                        $data['district_id'] = $this->input->post('district_id');
                        $data['commune_id'] = $this->input->post('commune_id');
                        $data['inhome'] = $this->input->post('inhome') ? 1 : 0;
                        $data['is_top'] = $this->input->post('is_top') ? 1 : 0;
                        $data['is_hot'] = $this->input->post('is_hot') ? 1 : 0;
                    }
                    if ($this->M_users->update($userid, $data)) {
                        $this->_upload_images($userid, 'identification');
                        if($role == 'PARTNER'){
                            $this->_upload_images($userid, 'image');
                            $this->_upload_slides($userid, 'slides');
                            $this->_upload_images($userid, 'image_big');
                        }

                        /*
                        $qr_field = $this->config->item('ledu_qr_field');
                        $qr_code = $this->input->post($qr_field);
                        if(trim($qr_code) != ''){
                            $this->load->library('ciqrcode');
                            $file_name = $qr_code . '.png';
                            $params['data'] = $qr_code;
                            $params['level'] = 'L';
                            $params['size'] = 3;
                            $params['savename'] = get_module_path('qr') . $file_name;
                            $this->ciqrcode->generate($params);
                        }
                        */

                        //users_permision_product
                        $data_users_permision_product = modules::run('users/users_permision_product/gets', array('user_id' => $userid));
                        $data_products_current = (is_array($data_users_permision_product) && !empty($data_users_permision_product)) ? array_column($data_users_permision_product, 'product_id', 'id') : array(-1);

                        $in_product_id = array_diff((array)$data_products_current, (array)$data_products);
                        if(empty($in_product_id)){
                            $in_product_id = array(-1);
                        }
                        modules::run('users/users_permision_product/delete', array('in_product_id' => $in_product_id));

                        //users_link
                        $data_users_link = modules::run('users/users_link/gets', array('user_id' => $userid));
                        $data_products_current = (is_array($data_users_link) && !empty($data_users_link)) ? array_column($data_users_link, 'product_id', 'id') : array(-1);
                        $in_product_id = array_diff((array)$data_products_current, (array)$data_products);
                        if(empty($in_product_id)){
                            $in_product_id = array(-1);
                        }
                        modules::run('users/users_link/delete', array('in_product_id' => $in_product_id));

                        if(is_array($data_products) && !empty($data_products)){
                            foreach($data_products as $key=>$value){
                                if($value != 0){
                                    $arr_validate_exist = array(
                                        'user_id' => $userid,
                                        'product_id' => $value,
                                    );
                                    if(modules::run('users/users_permision_product/get', $arr_validate_exist)){
                                        modules::run('users/users_permision_product/update', $arr_validate_exist, array(
                                            'modified' => time()
                                        ));
                                    }else{
                                        $arr_validate_exist['created'] = time();
                                        $arr_validate_exist['modified'] = 0;
                                        modules::run('users/users_permision_product/add', $arr_validate_exist);
                                    }
                                    unset($arr_validate_exist);

                                    //add user link
                                    $args_validate_exist = array(
                                        'user_id' => $userid,
                                        'product_id' => $value
                                    );
                                    $data_user_link = modules::run('users/users_link/get', $args_validate_exist);
                                    if (!(is_array($data_user_link) && !empty($data_user_link))) {
                                        $access_token = random_string('alnum', 30);
                                        while(modules::run('users/users_link/validate_exist', array('access_token' => $access_token))){
                                            $access_token = random_string('alnum', 30);
                                        }
                                        $time = time();
                                        $args_validate_exist['access_token'] = $access_token;
                                        $args_validate_exist['created'] = $time;
                                        modules::run('users/users_link/add', $args_validate_exist);
                                    }
                                    unset($args_validate_exist);
                                }
                            }
                        }

                        $notify_type = 'success';
                        $notify_content = 'Thông tin tài khoản đã cập nhật!';
                    } else {
                        $notify_type = 'danger';
                        $notify_content = 'Thông tin tài khoản chưa cập nhật!';
                    }
                    $this->set_notify_admin($notify_type, $notify_content);
                    redirect(base_url('users'));
                } else {
                    $username = $this->input->post('username');
                    $role = $this->input->post('role');
                    $refer_key = $this->__encrip_password(random_string('unique'));
                    $data = array(
                        'referred_by' => 0,
                        'referred_status' => 0,
                        'refer_key' => $refer_key,
                        'username' => $username,
                        'password' => $this->__encrip_password($this->input->post('password')),
                        'email' => $this->input->post('email'),
                        'full_name' => $this->input->post('full_name'),
                        'role' => $role,
                        'phone' => $this->input->post('phone'),
                        'address' => $this->input->post('address'),
                        'gender' => $this->input->post('gender'),
                        'regdate' => time(),
                        'view_mail' => $this->input->post('view_mail') ? 1 : 0,
                        'active' => 1,
                        'commission' => filter_var($this->input->post('commission'), FILTER_SANITIZE_NUMBER_INT)
                    );
                    if($role == 'PARTNER'){
                        $data['business_id'] = $this->input->post('business_id');
                        $data['VAT'] = $this->input->post('VAT');
                        $data['shops_name'] = $this->input->post('shops_name');
                        $data['iframe_map'] = $this->input->post('iframe_map');
                        $data['about'] = $this->input->post('about');
                        $data['province_id'] = $this->input->post('province_id');
                        $data['district_id'] = $this->input->post('district_id');
                        $data['commune_id'] = $this->input->post('commune_id');
                        $data['inhome'] = $this->input->post('inhome') ? 1 : 0;
                        $data['is_top'] = $this->input->post('is_top') ? 1 : 0;
                        $data['is_hot'] = $this->input->post('is_hot') ? 1 : 0;
                    }
                    /*
                    if($this->input->post('is_all_order')){
                        $data['is_all_order'] = 1;
                        $data['list_order'] = '';
                    }else{
                        $data['is_all_order'] = 0;
                        $data['list_order'] = implode(',', $this->input->post('list_order'));
                    }
                    */

                    $userid = $this->M_users->add($data);

                    if ($userid != 0) {
                        $this->_upload_images($userid, 'identification');
                        if($role == 'PARTNER'){
                            $this->_upload_images($userid, 'image');
                            $this->_upload_slides($userid, 'slides');
                            $this->_upload_images($userid, 'image_big');
                        }
                        /*
                        $qr_field = $this->config->item('ledu_qr_field');
                        $qr_code = $this->input->post($qr_field);
                        if(trim($qr_code) != ''){
                            $this->load->library('ciqrcode');
                            $file_name = $qr_code . '.png';
                            $params['data'] = $qr_code;
                            $params['level'] = 'L';
                            $params['size'] = 3;
                            $params['savename'] = get_module_path('qr') . $file_name;
                            $this->ciqrcode->generate($params);
                        }
                        */

                        if(is_array($data_products) && !empty($data_products)){
                            foreach($data_products as $key=>$value){
                                if($value != 0){
                                    $arr_validate_exist = array(
                                        'user_id' => $userid,
                                        'product_id' => $value,
                                    );
                                    if(modules::run('users/users_permision_product/get', $arr_validate_exist)){
                                        modules::run('users/users_permision_product/update', $arr_validate_exist, array(
                                            'modified' => time()
                                        ));
                                    }else{
                                        $arr_validate_exist['created'] = time();
                                        $arr_validate_exist['modified'] = 0;
                                        modules::run('users/users_permision_product/add', $arr_validate_exist);
                                    }
                                    unset($arr_validate_exist);

                                    //add user link
                                    $args_validate_exist = array(
                                        'user_id' => $userid,
                                        'product_id' => $value
                                    );
                                    $data_user_link = modules::run('users/users_link/get', $args_validate_exist);
                                    if (!(is_array($data_user_link) && !empty($data_user_link))) {
                                        $access_token = random_string('alnum', 30);
                                        while(modules::run('users/users_link/validate_exist', array('access_token' => $access_token))){
                                            $access_token = random_string('alnum', 30);
                                        }
                                        $time = time();
                                        $args_validate_exist['access_token'] = $access_token;
                                        $args_validate_exist['created'] = $time;
                                        modules::run('users/users_link/add', $args_validate_exist);
                                    }
                                    unset($args_validate_exist);
                                }
                            }
                        }

                        $notify_type = 'success';
                        $notify_content = 'Thành viên mới đã thêm!';
                    } else {
                        $notify_type = 'danger';
                        $notify_content = 'Chưa thêm thành viên!';
                    }
                    $this->set_notify_admin($notify_type, $notify_content);
                    redirect(base_url('users'));
                }
            }
        }

        $provinces = modules::run('provinces/provinces/gets');
        $districts = $communes = array();
        $userid = ($this->uri->segment(4) == '') ? 0 : (int) $this->uri->segment(4);
        if ($userid != 0) {
            $this->_modules_script[] = array(
                'folder' => 'users',
                'name' => 'admin-edit-validate'
            );
            $this->set_modules();
            $data_userid = $this->get($userid);

            $this->load->module('users/groups_users');
            $group_id = $this->groups_users->get_group_id($userid);
            $data_userid['group_id'] = $group_id['group_id'];

            $data_users_permision_product = modules::run('users/users_permision_product/gets', array('user_id' => $userid));
            $data_userid['products'] = (is_array($data_users_permision_product) && !empty($data_users_permision_product)) ? array_column($data_users_permision_product, 'product_id', 'id') : NULL;
            //var_dump($data_userid['products']); die;

            $row = $data_userid;
            $this->_data['row'] = $row;
            $this->_data['breadcrumbs_module_func'] = 'Cập nhật tài khoản';
            $this->_data['title'] = 'Cập nhật tài khoản - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
            if(isset($row['province_id'])){
                $districts = modules::run('provinces/districts/gets', array('pId' => $row['province_id']));
            }
            if(isset($row['district_id'])){
                $communes = modules::run('provinces/communes/gets', array('district_id' => $row['district_id']));
            }
        } else {
            $this->_modules_script[] = array(
                'folder' => 'users',
                'name' => 'admin-add-validate'
            );
            $this->set_modules();

            $this->_data['breadcrumbs_module_func'] = 'Thêm tài khoản mới';
            $this->_data['title'] = 'Thêm tài khoản mới - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
        }
        $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => base_url() . "ckeditor/", 'outPut' => true));
        $this->_data['products'] = modules::run('shops/rows/gets');
        $this->_data['users_business'] = modules::run('users/users_business/gets');
        $this->_data['provinces'] = $provinces;
        $this->_data['districts'] = $districts;
        $this->_data['communes'] = $communes;

        $this->_data['main_content'] = 'users/admin/view_page_content';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function index() {
        $this->_initialize_admin();
        $this->redirect_admin();
        //$this->redirect_administrator();
        /*
        $args = $this->default_args();
        $rows = $this->M_users->gets($args);
        if(is_array($rows) && !empty($rows)){
            // $qr_field = $this->config->item('ledu_qr_field');
            // $this->load->library('ciqrcode');
            foreach ($rows as $row) {
                // $group_id = $row['group_id'];
                // $role = 'MEMBER';
                // if($group_id == 6){
                //     $role = 'ADMIN';
                // }elseif ($group_id == 4) {
                //     $role = 'MARKETING';
                // }
                // $this->M_users->update($row['userid'], array('role' => $role));
                //@unlink(FCPATH . get_module_path('qr') . $row[$qr_field] . ".png");
                // $qr_code = $row[$qr_field];
                // if(trim($qr_code) != ''){
                //     $this->load->library('ciqrcode');
                //     $file_name = $qr_code . '.png';
                //     $params['data'] = $qr_code;
                //     $params['level'] = 'L';
                //     $params['size'] = 3;
                //     $params['savename'] = get_module_path('qr') . $file_name;
                //     $this->ciqrcode->generate($params);
                // }
            }
        }
        die;
        */
        
        /*
        $args = $this->default_args();
        $rows = $this->M_users->gets($args);
        if(is_array($rows) && !empty($rows)){
            $qr_field = 'username';
            $this->load->library('ciqrcode');
            foreach ($rows as $row) {
                $qr_code = $row[$qr_field];
                if(trim($qr_code) != ''){
                    $this->load->library('ciqrcode');
                    $file_name = $qr_code . '.png';
                    $params['data'] = site_url('dang-ky') . '?ref=' . $qr_code;
                    $params['level'] = 'L';
                    $params['size'] = 3;
                    $params['savename'] = get_module_path('qr_link') . $file_name;
                    $this->ciqrcode->generate($params);
                }
            }
        }
        die;
        */
        //echo get_balance_user(286); die;
        //echo get_balance_user(83); die;

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
            'folder' => 'users',
            'name' => 'admin-index'
        );
        $this->set_modules();

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $session_data = $this->session->userdata('logged_in');
        $group_id = isset($session_data['group_id']) ? $session_data['group_id'] : 0;
        $userid = isset($session_data['userid']) ? $session_data['userid'] : 0;

        $args = $this->default_args();
        if (isset($get['q']) && trim($get['q']) != '') {
            $args['q'] = $get['q'];
        }
        if (isset($get['role']) && trim($get['role']) != '') {
            $args['role'] = $get['role'];
        }
        if (isset($get['level']) && trim($get['level']) != '') {
            $args['level'] = $get['level'];
        }
        if (isset($get['business_id']) && trim($get['business_id']) != '') {
            $args['business_id'] = $get['business_id'];
        }
        $args['admin_group_id'] = $group_id;
        $args['admin_userid'] = $userid;
        // echo "<pre>";
        // print_r($args);
        // echo "</pre>";
        // die();

        $total = $this->counts($args);
        $perpage = isset($get['per_page']) ? $get['per_page'] : $this->config->item('per_page');
        $segment = 3;

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
            $config['base_url'] = base_url('users');
            $config['suffix'] = '?' . http_build_query($get, '', "&");
            $config['first_url'] = base_url('users' . '?' . http_build_query($get, '', "&"));
            $config['uri_segment'] = $segment;
        } else {
            $config['base_url'] = base_url('users');
            $config['uri_segment'] = $segment;
        }

        $this->pagination->initialize($config);  # Khởi tạo phân trang

        $pagination = $this->pagination->create_links(); # Tạo link phân trang
        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment); # Lấy offset
        $this->_data['pagination'] = $pagination;
        $rows = $this->M_users->gets($args, $perpage, $offset);
        // if(is_array($rows) && !empty($rows)){
        //  foreach($rows as $key => $value){
        //      $rows[$key]['referred_count_censor'] = $this->counts(array('referred_by' => $value['userid'], 'referred_status' => 0));
        //      $rows[$key]['referred_count_censorred'] = $this->counts(array('referred_by' => $value['userid'], 'referred_status' => 1));
        //  }
        // }
        $this->_data['rows'] = $rows;
        //var_dump($this->__encrip_password(random_string('unique')));
        /*
        * Fix refer_key all users
        $users = $this->M_users->gets(array());
        if(is_array($users) && !empty($users)){
            foreach($users as $value){
                if($value['refer_key'] == ''){
                    $refer_key = $this->__encrip_password(random_string('unique'));
                    $this->M_users->update($value['userid'], array('refer_key' => $refer_key));
                }
            }
        }
        */
        $this->_data['users_business'] = modules::run('users/users_business/gets');

        $this->_data['breadcrumbs_module_func'] = 'Danh sách thành viên';
        $this->_data['title'] = 'Danh sách thành viên';
        $this->_data['main_content'] = 'users/admin/view_page_index';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

	function admin_index() {
		if ($this->validate_user_logged_in()) {
			modules::run('dashboard');
		} else {
			$this->_data['title'] = 'Đăng nhập quản trị - ' . $this->_data['title'];

			$post = $this->input->post();

			if (!empty($post)) {
				$this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required');
				$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required');

				if ($this->form_validation->run($this)) {
					if ($this->validate_login()) {
						redirect(base_url());
					} else {
						$this->_data['messing'] = 'Tên đăng nhập hoặc mật khẩu chưa đúng!';
					}
				}
			}

			$this->load->view('admin/view_page_admin_login', $this->_data);
		}
	}

	function login() {
		$username = $this->input->post('username');
		$password = encrip_password($this->input->post('password'));

		$row = $this->M_users->login($username, $password);

		if ($row) {
			$sess_array = array(
				'userid' => $row['userid'],
				'username' => $row['username'],
				'full_name' => $row['full_name'],
				'photo' => $row['photo'],
				'regdate' => $row['regdate'],
				'role' => $row['role'],
				'have_add' => $row['have_add'],
				'have_edit' => $row['have_edit'],
				'have_delete' => $row['have_delete'],
			);
			$this->session->set_userdata('logged_in', $sess_array);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function login_by() {
		$this->_initialize_admin();
		$this->redirect_admin();
		if (!(isset($this->_data['role']) && in_array($this->_data['role'], array('ADMIN')))) {
			redirect(base_url());
		}
		$segment = 2;
		$user_id = ($this->uri->segment($segment) == '') ? 0 : (int) $this->uri->segment($segment);
		if ($user_id == 0) {
			$notify_type = 'danger';
			$notify_content = 'Người dùng không tồn tại! Vui lòng thực hiện lại!';
			$this->set_notify($notify_type, $notify_content);
			redirect(site_url('nhan-vien'));
		} elseif ($this->session->has_userdata('logged_in_by')) {
			$this->session->unset_userdata('logged_in_by');
		}
		$user = $this->M_users->get_by(array('user_id' => $user_id));

		if (is_array($user) && !empty($user)) {
			$sess_array = array(
				'userid' => $user['userid'],
				'username' => $user['username'],
				'full_name' => $user['full_name'],
				'photo' => $user['photo'],
				'regdate' => $user['regdate'],
				'role' => $user['role'],
				'have_add' => $user['have_add'],
				'have_edit' => $user['have_edit'],
				'have_delete' => $user['have_delete'],
			);
			$this->session->set_userdata('logged_in_by', $sess_array);
			redirect(base_url());
		} else {
			$notify_type = 'danger';
			$notify_content = 'Người dùng không tồn tại! Vui lòng thực hiện lại!';
			$this->set_notify($notify_type, $notify_content);
			redirect(site_url('nhan-vien'));
		}
	}

	function validate_current_password() {
		$username = $this->_data['username'];
		$current_password = encrip_password($this->input->post('current_password'));

		$result = $this->M_users->validate_current_password($username, $current_password);

		if (!$result) {
			$this->form_validation->set_message('validate_current_password', '%s không đúng!');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function validate_login() {
		$username = $this->input->post('username');
		$password = encrip_password($this->input->post('password'));

		$row = $this->M_users->validate_login($username, $password);

		if ($row) {
			$sess_array = array(
				'userid' => $row['userid'],
				'username' => $row['username'],
				'full_name' => $row['full_name'],
				'photo' => $row['photo'],
				'regdate' => $row['regdate'],
				'role' => $row['role'],
				'have_add' => $row['have_add'],
				'have_edit' => $row['have_edit'],
				'have_delete' => $row['have_delete'],
			);
			$this->session->set_userdata('logged_in', $sess_array);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function validate_admin_logged_in() {
		if (!$this->session->userdata('logged_in')) {
			return FALSE;
		} else {
			$session_data = $this->session->userdata('logged_in');
			if (isset($session_data['role']) && $session_data['role'] == 'ADMIN') {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}

	function validate_user_logged_in() {
		if (!$this->session->userdata('logged_in')) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function deny_logged_in() {
		if ($this->session->userdata('logged_in')) {
			redirect(base_url());
		}
	}

	function require_logged_in() {
		if (!$this->session->userdata('logged_in')) {
			if ($this->input->post('ajax') == '1') {
				$this->_status = "danger";
				$this->_message = "Bạn không có quyền truy cập vào trang này!";

				$this->set_json_encode();
				$this->load->view('layout/json_data', $this->_data);
				exit();
			} else {
				$notify_type = 'danger';
				$notify_content = 'Mời bạn đăng nhập để sử dụng chức năng này!';
				$this->set_notify($notify_type, $notify_content);
				redirect(base_url('login' . $this->_data['url_suffix']));
			}
		}
	}

	function require_admin_logged_in() {
		if (!$this->validate_admin_logged_in()) {
			if ($this->input->post('ajax') == '1') {
				$this->_status = "danger";
				$this->_message = "Bạn không có quyền truy cập vào trang này!";

				$this->set_json_encode();
				$this->load->view('layout/json_data', $this->_data);
				exit;
			} else {
				redirect(base_url());
			}
		}
	}

	function logout() {
		if ($this->session->has_userdata('logged_in_by')) {
			$this->session->unset_userdata('logged_in_by');
		} else {
			$this->session->sess_destroy();
		}
		redirect(base_url());
	}

	function site_changepass() {
		$this->require_logged_in();

		$this->_plugins_script[] = array(
			'folder' => 'jquery-validation',
			'name' => 'jquery.validate',
		);
		$this->_plugins_script[] = array(
			'folder' => 'jquery-validation/localization',
			'name' => 'messages_vi',
		);
		$this->set_plugins();

		$this->_modules_script[] = array(
			'folder' => 'users',
			'name' => 'changepass-validate',
		);
		$this->set_modules();

		$post = $this->input->post();

		if (!empty($post)) {
			$this->load->helper('language');
			$this->lang->load('form_validation', 'vietnamese');
			$this->lang->load('user', 'vietnamese');
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('current_password', 'Mật khẩu hiện tại', 'trim|required|min_length[6]|callback_validate_current_password');
			$this->form_validation->set_rules('password', 'Mật khẩu mới', 'trim|required|min_length[6]|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', 'Nhập lại mật khẩu mới', 'trim|required|min_length[6]');

			if ($this->form_validation->run($this)) {
				$password = encrip_password($this->input->post('password'));
				$userid = $this->_data['userid'];
				$data = array(
					'password' => $password,
				);

				if ($this->M_users->update($userid, $data)) {
					$notify_type = 'success';
					$notify_content = 'Mật khẩu đã đổi thành công!';
				} else {
					$notify_type = 'danger';
					$notify_content = 'Mật khẩu chưa được đổi! Vui lòng thực hiện lại!';
				}
				$this->set_notify($notify_type, $notify_content);
				redirect(base_url('users/changepass' . $this->_data['url_suffix']));
			}
		}

		$this->_breadcrumbs[] = array(
			'url' => base_url() . 'users/changepass' . $this->_data['url_suffix'],
			'name' => 'Đổi mật khẩu',
		);
		$this->_data['breadcrumbs'] = $this->_breadcrumbs;

		$this->_data['title'] = 'Đổi mật khẩu - ' . $this->_data['title'];
		$this->_data['main_content'] = 'layout/site/pages/changepass';
		$this->load->view('layout/site/layout', $this->_data);
	}

	function site_main() {
		$this->require_logged_in();

		$row = $this->M_users->get_by_username($this->_data['username']);
		$this->_data['row'] = $row;

		$this->_breadcrumbs[] = array(
			'url' => base_url('users/main' . $this->_data['url_suffix']),
			'name' => 'Thông tin thành viên',
		);
		$this->_data['breadcrumbs'] = $this->_breadcrumbs;

		$this->_data['title'] = 'Thông tin thành viên - ' . $this->_data['title'];
		$this->_data['main_content'] = 'layout/site/pages/account';
		$this->load->view('layout/site/layout', $this->_data);
	}

	function site_editinfo() {
		$this->require_logged_in();

		$this->_plugins_css[] = array(
			'folder' => 'bootstrap-datepicker/css',
			'name' => 'bootstrap-datepicker',
		);
		$this->_plugins_css[] = array(
			'folder' => 'bootstrap-datepicker/css',
			'name' => 'bootstrap-datepicker3',
		);
		$this->_plugins_script[] = array(
			'folder' => 'bootstrap-datepicker/js',
			'name' => 'bootstrap-datepicker',
		);
		$this->_plugins_script[] = array(
			'folder' => 'bootstrap-datepicker/locales',
			'name' => 'bootstrap-datepicker.vi.min',
		);
		$this->_plugins_script[] = array(
			'folder' => 'bootstrap-datepicker',
			'name' => 'app.editinfo',
		);
		$this->_plugins_script[] = array(
			'folder' => 'jquery-validation',
			'name' => 'jquery.validate',
		);
		$this->_plugins_script[] = array(
			'folder' => 'jquery-validation/localization',
			'name' => 'messages_vi',
		);
		$this->_plugins_css[] = array(
			'folder' => 'Jcrop/css',
			'name' => 'jquery.Jcrop.min',
		);
		$this->_plugins_script[] = array(
			'folder' => 'Jcrop/js',
			'name' => 'jquery.Jcrop.min',
		);
		$this->_plugins_script[] = array(
			'folder' => 'Jcrop/js',
			'name' => 'script',
		);
		$this->set_plugins();

		$this->_modules_script[] = array(
			'folder' => 'users',
			'name' => 'editinfo-validate',
		);
		$this->set_modules();

		$post = $this->input->post();

		if (!empty($post)) {
			$this->load->helper('language');
			$this->lang->load('form_validation', 'vietnamese');
			$this->lang->load('user', 'vietnamese');
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('full_name', 'Họ tên', 'trim|required|min_length[6]');

			if ($this->form_validation->run($this)) {
				$userid = $this->_data['userid'];
				$avatar = $this->input->post('avatar');
				$user = $this->get($userid);
				$ext = modules::run('files/__get_file_extension', $avatar);
				$photo = $user['username'] . '.' . $ext;

				$data = array(
					'email' => $this->input->post('email'),
					'full_name' => $this->input->post('full_name'),
					'gender' => $this->input->post('gender'),
					'photo' => $photo,
					'birthday' => strtotime($this->input->post('birthday')),
					'view_mail' => $this->input->post('view_mail'),
				);

				if ($this->M_users->update($userid, $data)) {
					$logged_in_session = $this->session->userdata('logged_in');
					$logged_in_session['full_name'] = $this->input->post('full_name');
					$this->session->set_userdata('logged_in', $logged_in_session);

					$file = FCPATH . 'assets/images/' . $avatar;
					$newfile = FCPATH . $this->_path . $photo;
					copy($file, $newfile);
					@unlink($file);

					$notify_type = 'success';
					$notify_content = 'Cập nhật thông tin thành viên thành công!';
					$this->set_notify($notify_type, $notify_content);
				} else {
					$notify_type = 'danger';
					$notify_content = 'Thông tin thành viên chưa được đổi! Vui lòng thực hiện lại!';
					$this->set_notify($notify_type, $notify_content);
				}
				redirect(base_url('users/editinfo' . $this->_data['url_suffix']));
			}
		}
		$this->_data['users'] = $this->M_users->get_by_username($this->_data['username']);

		$this->_breadcrumbs[] = array(
			'url' => base_url('users/editinfo' . $this->_data['url_suffix']),
			'name' => 'Cập nhật thông tin thành viên',
		);
		$this->_data['breadcrumbs'] = $this->_breadcrumbs;

		$this->_data['title'] = 'Cập nhật hồ sơ - ' . $this->_data['title'];
		$this->_data['main_content'] = 'layout/site/pages/editinfo';
		$this->load->view('layout/site/layout', $this->_data);
	}

    function site_register() {
    	$this->_initialize_admin();
    	$this->deny_logged_in();

        $post = $this->input->post();
        if (!empty($post)) {
            $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');
            $this->form_validation->set_rules('full_name', 'Họ tên', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required|alpha_numeric|callback_check_username_availablity|min_length[5]|max_length[32]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_email_availablity');
            $this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|min_length[6]');
            $this->form_validation->set_rules('passconf', 'Lặp lại mật khẩu', 'trim|required|min_length[6]|matches[password]');
			//$this->form_validation->set_rules('ref', 'Mã giới thiệu', 'trim|required|max_length[255]');

            if ($this->form_validation->run($this)) {
                $err = FALSE;
                $birthday = $this->input->post('birthday');
                $referred_by = 0;
                $ref = $this->input->post('ref');
                if(trim($ref) != ''){
                    $user_refer = $this->M_users->get_by(array('username' => $ref));
                    if(isset($user_refer['userid'])){
                        $referred_by = (int)$user_refer['userid'];
                    }
                }
                $refer_key = encrip_password(random_string('unique'));
                $activation_key = encrip_password(random_string('unique'));
                $data = array(
                    'referred_by' => $referred_by,
                    'referred_status' => 0,
                    'refer_key' => $refer_key,
                    'full_name' => $this->input->post('full_name'),
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'password' => md5($this->input->post('password')),
                    'role' => 'MEMBER',
                    'have_add' => 1,
                    'have_edit' => 1,
                    'have_delete' => 1,
                    'birthday' => (trim($birthday) != '') ? get_current_date($birthday) : 0,
                    'activation_key' => $activation_key,
                    'active' => 1,
                    'created' => time(),
                    'modified' => 0,
                );

                $insert_id = $this->M_users->add($data);
                if ($insert_id == 0) {
                    $err = TRUE;
                }

                if ($err === FALSE) {
                    $notify_type = 'success';
                    $notify_content = 'Đăng ký thành công! Chào mừng bạn đến với chúng tôi!';
                    $this->set_notify_admin($notify_type, $notify_content);

                    redirect(base_url($this->_module_slug));
                } else {
                    $notify_type = 'danger';
                    $notify_content = 'Có lỗi xảy ra!';
                    $this->set_notify_admin($notify_type, $notify_content);
                }
            }
        }
        $this->_data['ref'] = $this->input->get('ref');

        $this->_data['title'] = 'Đăng ký - ' . $this->_data['title'];
        $this->load->view('users/admin/view_page_admin_register', $this->_data);
    }

    function site_forget_password() {
		$this->_initialize_admin();
    	$this->deny_logged_in();

		$post = $this->input->post();
        if (!empty($post)) {
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[255]');

            if ($this->form_validation->run($this)) {
                $email = $this->input->post('email');
                $user = $this->M_users->get_by_email($email);

                if (!empty($user)) {
                    $data = array(
                        'activation_key' => $this->__encrip_password(random_string('unique'))
                    );
                    if ($this->M_users->update($user['userid'], $data)) {
                        $partial = array();
                        $user['activation_key'] = $data['activation_key'];
                        $partial['data'] = $user;
                        $data_sendmail = array(
                            'sender_email' => get_first_element($this->_data['email']),
                            'sender_name' => $this->_data['site_name'] . ' - ' . get_first_element($this->_data['email']),
                            'receiver_email' => $email, //mail nhan thư
                            'subject' => 'Quên mật khẩu',
                            'message' => $this->load->view('layout/site/partial/html-template-forget-password', $partial, true)
                        );
                        modules::run('emails/send_mail', $data_sendmail);

						$notify_type = 'success';
                        $notify_content = 'Bạn hãy xem mail để lấy lại mật khẩu!';
                        $this->set_notify($notify_type, $notify_content);
                    } else {
						$notify_type = 'danger';
                        $notify_content = 'Có lỗi xảy ra vui lòng thực hiện lại!';
                        $this->set_notify($notify_type, $notify_content);
                    }
                } else {
                    $notify_type = 'danger';
                    $notify_content = 'Email không tồn tại!';
                    $this->set_notify($notify_type, $notify_content);
                }
            }
        }

        $this->_breadcrumbs[] = array(
            'url' => site_url('quen-mat-khau'),
            'name' => 'Quên mật khẩu'
        );
        $this->_data['breadcrumbs'] = $this->_breadcrumbs;

        $this->_data['title'] = 'Quên mật khẩu - ' .  $this->_data['title'];
        $this->load->view('users/admin/view_page_admin_forgot_password', $this->_data);
    }

	function active() {
		$post = $this->input->post();
		if (!empty($post)) {
			$active = $this->input->post('active');
			if ($this->update_active($active)) {
				if ($active == 1) {
					$notify_type = 'success';
					$notify_content = 'Thành viên đã được kích hoạt!';
				} else {
					$notify_type = 'warning';
					$notify_content = 'Đã tắt kích hoạt thành viên!';
				}
			} else {
				$notify_type = 'danger';
				$notify_content = 'Dữ liệu chưa lưu!';
			}
			$this->set_notify_admin($notify_type, $notify_content);
			$this->load->view('users/admin/notify', NULL);
		} else {
			redirect(base_url());
		}
	}

	function check_current_username_availablity() {
		$post = $this->input->post();
		$this->_message_success = 'true';
		$this->_message_danger = 'false';

		if (!empty($post)) {
			if ($this->input->post('ajax') == '1') {
				$username = $this->input->post('username');
				$userid = $this->input->post('userid');
				if ($this->M_users->check_current_username_availablity($username, $userid)) {
					$this->_status = "success";
					$this->_message = $this->_message_success;
				} else {
					$this->_status = "danger";
					$this->_message = $this->_message_danger;
				}

				$this->set_json_encode();
				$this->load->view('layout/json_data', $this->_data);
			} else {
				$username = $this->input->post('username');
				$userid = $this->input->post('userid');
				if ($this->M_users->check_current_username_availablity($username, $userid)) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
		} else {
			redirect(base_url());
		}
	}

	function check_current_email_availablity() {
		$post = $this->input->post();
		$this->_message_success = 'true';
		$this->_message_danger = 'false';

		if (!empty($post)) {
			if ($this->input->post('ajax') == '1') {
				$email = $this->input->post('email');
				$userid = $this->input->post('userid');
				if ($this->M_users->check_current_email_availablity($email, $userid)) {
					$this->_status = "success";
					$this->_message = $this->_message_success;
				} else {
					$this->_status = "danger";
					$this->_message = $this->_message_danger;
				}

				$this->set_json_encode();
				$this->load->view('layout/json_data', $this->_data);
			} else {
				$email = $this->input->post('email');
				$userid = $this->input->post('userid');
				if ($this->M_users->check_current_email_availablity($email, $userid)) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
		} else {
			redirect(base_url());
		}
	}

	function check_current_password_availablity() {
		$post = $this->input->post();
		$this->_message_success = 'Mật khẩu hiện tại đúng!';
		$this->_message_danger = 'Mật khẩu hiện tại không đúng!';

		if (!empty($post)) {
			if ($this->input->post('ajax') == '1') {
				$current_password = encrip_password($this->input->post('current_password'));
				$username = $this->_data['username'];
				if ($this->M_users->check_current_password_availablity($username, $current_password)) {
					$this->_status = "success";
					$this->_message = $this->_message_success;
				} else {
					$this->_status = "danger";
					$this->_message = $this->_message_danger;
				}

				$this->set_json_encode();
				$this->load->view('layout/json_data', $this->_data);
			} else {
				$current_password = encrip_password($this->input->post('current_password'));
				$username = $this->_data['username'];
				if ($this->M_users->check_current_password_availablity($username, $current_password)) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
		} else {
			redirect(base_url());
		}
	}

	function check_username_availablity() {
		$post = $this->input->post();
		$this->_message_success = 'Bạn có thể sử dụng tên đăng nhập này!';
		$this->_message_danger = 'Tên đăng nhập này đã có người sử dụng!';

		if (!empty($post)) {
			if ($this->input->post('ajax') == '1') {
				$username = $this->input->post('username');
				if ($this->M_users->check_username_availablity($username)) {
					$this->_status = "success";
					$this->_message = $this->_message_success;
				} else {
					$this->_status = "danger";
					$this->_message = $this->_message_danger;
				}

				$this->set_json_encode();
				$this->load->view('layout/json_data', $this->_data);
			} else {
				$username = $this->input->post('username');
				if ($this->M_users->check_username_availablity($username)) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
		} else {
			redirect(base_url());
		}
	}

	function check_email_availablity() {
		$post = $this->input->post();
		$this->_message_success = 'Bạn có thể sử dụng email này!';
		$this->_message_danger = 'Email này đã có người sử dụng!';

		$username = isset($this->_data['username']) ? $this->_data['username'] : '';

		if (!empty($post)) {
			if ($this->input->post('ajax') == '1') {
				$email = $this->input->post('email');
				if ($this->M_users->check_email_availablity($email, $username)) {
					$this->_status = "success";
					$this->_message = $this->_message_success;
				} else {
					$this->_status = "danger";
					$this->_message = $this->_message_danger;
				}

				$this->set_json_encode();
				$this->load->view('layout/json_data', $this->_data);
			} else {
				$email = $this->input->post('email');
				if ($this->M_users->check_email_availablity($email)) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
		} else {
			redirect(base_url());
		}
	}

	function update_active($active = 1) {
		$userid = $this->input->post('userid');
		$data = array(
			'active' => $active,
		);
		return $this->M_users->update($userid, $data);
	}

	function admin_delete() {
		$this->_message_success = 'Đã xóa tài khoản và dữ liệu liên quan!';
		$this->_message_warning = 'Tài khoản này không tồn tại!';
		if ($this->validate_admin_logged_in() == TRUE) {
			$id = $this->input->get('id');
                if ($id != 0) {
                    $row = $this->get($id);
                    $this->load->module('users/groups_users');
                    $group_id = $this->groups_users->get_group_id($id);
                    if ($group_id['group_id'] < 4) {
                        if ($this->M_users->delete($id)) {
                            $this->groups_users->delete($id);
                            if ($row['photo'] != 'no_avatar.jpg') {
                                @unlink(FCPATH . $this->_path . $row['photo']);
                            }
                            $notify_type = 'success';
                            $notify_content = $this->_message_success;
                        } else {
                            $notify_type = 'danger';
                            $notify_content = $this->_message_danger;
                        }
                    } else {
                        $notify_type = "danger";
                        $notify_content = "Không được xóa tài khoản admin!";
                    }
                } else {
                    $notify_type = 'warning';
                    $notify_content = $this->_message_warning;
                }
                $this->set_notify_admin($notify_type, $notify_content);
                redirect(base_url('users'));
		} else {
			$notify_type = 'danger';
            $notify_content = $this->_message_banned;
            $this->set_notify_admin($notify_type, $notify_content);
            redirect(base_url('users'));
		}
	}

}
/* End of file Users.php */
/* Location: ./application/modules/users/controllers/Users.php */