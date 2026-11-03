<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Users extends Layout {

	private $_remember_name = 'siteAuth';
	public $_users_path = '';

	function __construct() {
		parent::__construct();
		$this->load->model('users/m_groups_users', 'M_groups_users');
		$this->load->model('users/m_users', 'M_users');
		$this->_data['breadcrumbs_module_name'] = 'Tài khoản';
		$this->_users_path = get_module_path('users');
	}

	function default_args() {
		$order_by = array(
			'full_name' => 'ASC',
		);
		$args = array();
		$args['order_by'] = $order_by;

		return $args;
	}

	function gets($args) {
		$this->load->model('users/m_users', 'M_users');
		return $this->M_users->gets($args);
	}

	function counts($args) {
		$this->load->model('users/m_users', 'M_users');
		return $this->M_users->counts($args);
	}

	function get($id) {
		$this->load->model('users/m_users', 'M_users');
		return $this->M_users->get($id);
	}

	function gets_in_group($args) {
		$this->load->model('users/m_users', 'M_users');
		return $this->M_users->gets($args);
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

	function index() {
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
			'name' => 'admin-index',
		);
		$this->set_modules();

		$get = $this->input->get();
		$this->_data['get'] = $get;

		$session_data = $this->session->userdata('logged_in');
		$group_id = isset($session_data['group_id']) ? $session_data['group_id'] : 0;
		$userid = isset($session_data['userid']) ? $session_data['userid'] : 0;

		//$total = $this->M_users->get_total_admin($get, $group_id, $userid);
		//$perpage = isset($get['per_page']) ? $get['per_page'] : 5; /* Số bảng ghi muốn hiển thị trên một trang */
		$args = $this->default_args();
		if (isset($get['method']) && trim($get['q']) != '') {
			if ((trim($get['method']) != "") && in_array($get['method'], $allow_method)) {
				$args[$get['method']] = $get['q'];
			} else {
				foreach ($allow_method as $value) {
					$args[$value] = $get['q'];
				}
			}
		}
		$args['admin_group_id'] = $group_id;
		$args['admin_userid'] = $userid;

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
			$config['base_url'] = get_admin_url('users');
			$config['suffix'] = '?' . http_build_query($get, '', "&");
			$config['first_url'] = get_admin_url('users' . '?' . http_build_query($get, '', "&"));
			$config['uri_segment'] = $segment;
		} else {
			$config['base_url'] = get_admin_url('users');
			$config['uri_segment'] = $segment;
		}

		$this->pagination->initialize($config);
		$pagination = $this->pagination->create_links();
		$offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
		$this->_data['rows'] = $this->M_users->gets($args, $perpage, $offset);
		$this->_data['pagination'] = $pagination;

		$this->_data['breadcrumbs_module_func'] = 'Danh sách thành viên';
		$this->_data['title'] = 'Danh sách thành viên';
		$this->_data['main_content'] = 'users/admin/view_page_index';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_profile() {
		$this->_initialize_admin();
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
						$data['password'] = $this->__encrip_password($password);
					}
					if ($this->M_users->update($userid, $data)) {
						$logged_in_session = $this->session->userdata('logged_in');
						$logged_in_session['full_name'] = $this->input->post('full_name');
						$logged_in_session['username'] = $username;

						/*
							                         * upload avartar
						*/
						$input_name = 'photo';
						$info = modules::run('files/index', $input_name, $this->_users_path);
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
									@unlink(FCPATH . $this->_users_path . $current_photo['photo']);
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
					redirect(get_admin_url());
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

		$this->_data['main_content'] = 'users/admin/view_page_profile';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function redirect_administrator() {
		if (!isset($this->ROLE) || $this->ROLE != 'admin') {
			$notify_type = 'danger';
			$notify_content = $this->_message_banned;
			$this->set_notify_admin($notify_type, $notify_content);
			redirect(get_admin_url());
		}
	}

	function admin_content() {
		$this->_initialize_admin();
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
			$this->load->helper('language');
			$this->lang->load('form_validation', 'vietnamese');
			$this->lang->load('user', 'vietnamese');

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
					$current_photo = $this->get($userid);
					$data = array(
						'username' => $username,
						'email' => $this->input->post('email'),
						'full_name' => $this->input->post('full_name'),
						'phone' => $this->input->post('phone'),
						'address' => $this->input->post('address'),
						'gender' => $this->input->post('gender'),
						'view_mail' => ($this->input->post('view_mail') ? 1 : 0),
						'active' => 1,
						'commission' => filter_var($this->input->post('commission'), FILTER_SANITIZE_NUMBER_INT),
					);

					$password = $this->input->post('password');
					if (trim($password) != '') {
						$data['password'] = $this->__encrip_password($password);
					}
					if ($this->M_users->update($userid, $data)) {
						$data_groups_users = array(
							'group_id' => $this->input->post('role'),
						);
						$this->load->module('users/groups_users');
						$this->groups_users->update($userid, $data_groups_users);

						//users_permision_product
						$data_users_permision_product = array();
						$url = get_api_url() . 'api/api_permision_product_index';
						$data = array(
							'function' => 'gets',
							'user_id' => $userid,
						);
						$response = @json_decode(curl_get($url, $data), true);
						if(isset($response['status']) && $response['status'] == 'success'){
							$data_users_permision_product = $response['content'];
						}
						$data_products_current = (is_array($data_users_permision_product) && !empty($data_users_permision_product)) ? array_column($data_users_permision_product, 'product_id', 'id') : array(-1);

						$in_product_id = array_diff((array)$data_products_current, (array)$data_products);
						if(empty($in_product_id)){
							$in_product_id = array(-1);
						}
						$url = get_api_url() . 'api/api_permision_product_index';
						$data = array(
							'function' => 'delete',
							'user_id' => $userid,
							'in_product_id' => $in_product_id
						);
						$response = @json_decode(curl_get($url, $data), true);

						//users_link
						$data_users_link = array();
						$url = get_api_url() . 'api/api_link_index';
						$data = array(
							'function' => 'gets',
							'user_id' => $userid,
						);
						$response = @json_decode(curl_get($url, $data), true);
						if(isset($response['status']) && $response['status'] == 'success'){
							$data_users_link = $response['content'];
						}
						$data_products_current = (is_array($data_users_link) && !empty($data_users_link)) ? array_column($data_users_link, 'product_id', 'id') : array(-1);
						$in_product_id = array_diff((array)$data_products_current, (array)$data_products);
						if(empty($in_product_id)){
							$in_product_id = array(-1);
						}
						$url = get_api_url() . 'api/api_link_index';
						$data = array(
							'function' => 'delete',
							'user_id' => $userid,
							'in_product_id' => $in_product_id
						);
						$response = @json_decode(curl_get($url, $data), true);

						if(is_array($data_products) && !empty($data_products)){
							foreach($data_products as $key=>$value){
								if($value != 0){
									$arr_validate_exist = array(
										'user_id' => $userid,
										'product_id' => $value,
									);
									$url = get_api_url() . 'api/api_permision_product_index';
									$arr_validate_exist['function'] = 'get';
									$response = @json_decode(curl_get($url, $arr_validate_exist), true);
									if(isset($response['status']) && $response['status'] == 'success' && $response['content']){
										/*
										echo 'update: ';
										echo "<pre>";
										print_r($response);
										echo "</pre>";
										*/
										$arr_validate_exist['function'] = 'update';
										$arr_validate_exist['modified'] = time();
										$response = @json_decode(curl_get($url, $arr_validate_exist), true);
										/*
										echo 'update1: ';
										echo "<pre>";
										print_r($response);
										echo "</pre>";
										*/
									}else{
										$arr_validate_exist['function'] = 'add';
										$arr_validate_exist['created'] = time();
										$arr_validate_exist['modified'] = 0;
										$response = @json_decode(curl_get($url, $arr_validate_exist), true);
										/*
										echo '<br>add: ';
										// var_dump($url . '_add');
										// var_dump($arr_validate_exist);
										echo "<pre>";
										print_r($response);
										echo "</pre>";
										*/
									}
									unset($arr_validate_exist);

									//add user link
									$args_validate_exist = array(
										'user_id' => $userid,
										'product_id' => $value
									);
									$url = get_api_url() . 'api/api_link_index';
									$args_validate_exist['function'] = 'get';
									$response = @json_decode(curl_get($url, $args_validate_exist), true);
									if(isset($response['status']) && $response['status'] == 'success' && !$response['content']){
										$access_token = random_string('alnum', 30);
										// $validate_exist = false;
										// $url = get_api_url() . 'api/api_link_index';
										// $args_validate_exist['function'] = 'get';
										// while(modules::run('users/users_link/validate_exist', array('access_token' => $access_token))){
										// 	$access_token = random_string('alnum', 30);
										// }
										$url = get_api_url() . 'api/api_link_index';
										$args_validate_exist['access_token'] = $access_token;
										$args_validate_exist['function'] = 'add';
										$args_validate_exist['created'] = time();
										$response = @json_decode(curl_get($url, $args_validate_exist), true);
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
					redirect(get_admin_url('users'));
				} else {
					$username = $this->input->post('username');
					$data = array(
						'username' => $username,
						'password' => $this->__encrip_password($this->input->post('password')),
						'email' => $this->input->post('email'),
						'full_name' => $this->input->post('full_name'),
						'phone' => $this->input->post('phone'),
						'address' => $this->input->post('address'),
						'gender' => $this->input->post('gender'),
						'regdate' => time(),
						'view_mail' => ($this->input->post('view_mail') ? 1 : 0),
						'active' => 1,
						'commission' => filter_var($this->input->post('commission'), FILTER_SANITIZE_NUMBER_INT),
					);

					$userid = $this->M_users->add($data);
					if ($userid != 0) {
						$data_groups_users = array(
							'group_id' => $this->input->post('role'),
							'userid' => $userid,
						);
						$this->load->module('users/groups_users');
						$this->groups_users->add($data_groups_users);

						if(is_array($data_products) && !empty($data_products)){
							foreach($data_products as $key=>$value){
								if($value != 0){
									$arr_validate_exist = array(
										'user_id' => $userid,
										'product_id' => $value,
									);
									$url = get_api_url() . 'api/api_permision_product_index';
									$arr_validate_exist['function'] = 'get';
									$response = @json_decode(curl_get($url, $arr_validate_exist), true);
									if(isset($response['status']) && $response['status'] == 'success' && $response['content']){
										$arr_validate_exist['function'] = 'update';
										$arr_validate_exist['modified'] = time();
										$response = @json_decode(curl_get($url, $arr_validate_exist), true);
									}else{
										$arr_validate_exist['function'] = 'add';
										$arr_validate_exist['created'] = time();
										$arr_validate_exist['modified'] = 0;
										$response = @json_decode(curl_get($url, $arr_validate_exist), true);
									}
									unset($arr_validate_exist);

									//add user link
									$args_validate_exist = array(
										'user_id' => $userid,
										'product_id' => $value
									);
									$url = get_api_url() . 'api/api_link_index';
									$args_validate_exist['function'] = 'get';
									$response = @json_decode(curl_get($url, $args_validate_exist), true);
									if(isset($response['status']) && $response['status'] == 'success' && !$response['content']){
										$access_token = random_string('alnum', 30);
										// $validate_exist = false;
										// $url = get_api_url() . 'api/api_link_index';
										// $args_validate_exist['function'] = 'get';
										// while(modules::run('users/users_link/validate_exist', array('access_token' => $access_token))){
										// 	$access_token = random_string('alnum', 30);
										// }
										$url = get_api_url() . 'api/api_link_index';
										$args_validate_exist['access_token'] = $access_token;
										$args_validate_exist['function'] = 'add';
										$args_validate_exist['created'] = time();
										$response = @json_decode(curl_get($url, $args_validate_exist), true);
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
					redirect(get_admin_url('users'));
				}
			}
		}

		$this->_data['groups'] = modules::run('users/groups/gets');
		$userid = ($this->uri->segment(4) == '') ? 0 : (int) $this->uri->segment(4);
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

			$data_users_permision_product = array();
			$url = get_api_url() . 'api/api_permision_product_index';
			$data = array(
				'function' => 'gets',
				'user_id' => $userid,
			);
			$response = @json_decode(curl_get($url, $data), true);
			if(isset($response['status']) && $response['status'] == 'success'){
				$data_users_permision_product = $response['content'];
			}
			$data_userid['products'] = (is_array($data_users_permision_product) && !empty($data_users_permision_product)) ? array_column($data_users_permision_product, 'product_id', 'id') : NULL;

			$this->_data['row'] = $data_userid;
			$this->_data['breadcrumbs_module_func'] = 'Cập nhật tài khoản';
			$this->_data['title'] = 'Cập nhật tài khoản - ' . $this->_data['title'];
		} else {
			$this->_modules_script[] = array(
				'folder' => 'users',
				'name' => 'admin-add-validate',
			);
			$this->set_modules();

			$this->_data['breadcrumbs_module_func'] = 'Thêm tài khoản mới';
			$this->_data['title'] = 'Thêm tài khoản mới - ' . $this->_data['title'];
		}
		$this->_data['products'] = modules::run('shops/rows/gets');

		$this->_data['main_content'] = 'users/admin/view_page_content';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	private function __encrip_password($password) {
		return md5($password);
	}

	function site_register() {
		$this->_initialize();

		$this->deny_logged_in();

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
			'name' => 'register-validate',
		);
		$this->set_modules();

		$this->load->module('users/users_config');
		$users_configs = $this->users_config->get_configs_users();
		$this->_data['users_configs'] = $users_configs;

		//$this->load->module('captcha');

		$post = $this->input->post();

		if (!empty($post)) {
			$this->load->helper('language');
			$this->lang->load('form_validation', 'vietnamese');
			$this->lang->load('user', 'vietnamese');

			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('full_name', 'Họ tên', 'trim|required|min_length[5]|max_length[255]');
			$this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required|min_length[5]|max_length[255]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[255]');
			$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|min_length[6]|max_length[255]');

			if ($this->form_validation->run($this)) {
				$this->load->helper('string');
				$activation_key = $this->__encrip_password(random_string('unique'));
				$email = $this->input->post('email');

				$username = $this->input->post('username');
				$data = array(
					'username' => $username,
					'password' => $this->__encrip_password($this->input->post('password')),
					'email' => $email,
					'full_name' => $this->input->post('full_name'),
					'phone' => $this->input->post('phone'),
					'address' => $this->input->post('address'),
					'gender' => $this->input->post('gender'),
					'regdate' => time(),
					'birthday' => time(),
					'view_mail' => 0,
					'activation_key' => $activation_key,
					'active' => 0,
				);

				$userid = $this->M_users->add($data);

				if ($userid != 0) {
					$data_groups_users = array(
						'group_id' => 3,
						'userid' => $userid,
					);
					$this->M_groups_users->add($data_groups_users);

					$partial = array();
					$partial['data'] = $data;
					$data_sendmail = array(
						'sender_email' => get_first_element($this->_data['email']),
						'sender_name' => $this->_data['site_name'] . ' - ' . get_first_element($this->_data['email']),
						'receiver_email' => $email, //mail nhan thư
						'subject' => 'Xác nhận đăng ký thành viên',
						'message' => $this->load->view('layout/site/partial/html-template-verify-email-address', $partial, true),
					);
					modules::run('emails/send_mail', $data_sendmail);

					$data_sendmail = array(
						'sender_email' => $email,
						'sender_name' => $this->_data['site_name'] . ' - Đăng ký thành viên - ' . $email,
						'receiver_email' => $this->_data['email'], //mail nhan thư
						'subject' => 'Đăng ký thành viên mới',
						'message' => $this->load->view('layout/site/partial/html-template-notify-new-member', $partial, true),
					);
					modules::run('emails/send_mail', $data_sendmail);

					$notify_type = 'success';
					$notify_content = 'Đăng ký thành công! Vui lòng kiểm tra email, để kích hoạt thành viên và đăng nhập!';
					$this->set_notify($notify_type, $notify_content);
					redirect(site_url('dang-nhap'));
				} else {
					$notify_type = 'danger';
					$notify_content = 'Tài khoản chưa được tạo! Vui lòng đăng ký lại!';
					$this->set_notify($notify_type, $notify_content);
					redirect(site_url('dang-ky'));
				}
			}
		}

		$this->_breadcrumbs[] = array(
			'url' => site_url('dang-ky'),
			'name' => 'Đăng ký',
		);
		$this->_data['breadcrumbs'] = $this->_breadcrumbs;

		$this->_data['title_seo'] = 'Đăng ký' . ' - ' . $this->_data['title_seo'];
		$this->_data['main_content'] = 'layout/site/pages/register';
		$this->load->view('layout/site/layout', $this->_data);
	}

	function site_verify_email_address() {
		$this->_initialize();

		$this->deny_logged_in();

		if (!$this->input->get('u') || !$this->input->get('code')) {
			show_404();
		}
		$get = $this->input->get();

		$code = $this->input->get('code');
		$username = $this->input->get('u');
		$user = $this->M_users->get_by_activation_key($username, $code);
		if (empty($user)) {
			$notify_type = 'danger';
			$notify_content = 'Thành viên không tồn tại vui lòng đăng ký!';
			$this->set_notify($notify_type, $notify_content);
			redirect(site_url());
		} else {
			$data = array(
				'activation_key' => '',
				'active' => 1,
			);
			if ($this->M_users->update($user['userid'], $data)) {
				$notify_type = 'success';
				$notify_content = 'Xác nhận đăng ký thành công! Bạn có thể đăng nhập ngay bây giờ!';
				$this->set_notify($notify_type, $notify_content);
				redirect(site_url('dang-nhap'));
			} else {
				$notify_type = 'warning';
				$notify_content = 'Thành viên không tồn tại! Vui lòng kiểm tra lại!';
				$this->set_notify($notify_type, $notify_content);
				redirect(site_url());
			}
		}
		$this->_breadcrumbs[] = array(
			'url' => site_url('xac-nhan-thanh-vien') . '?' . http_build_query($get, '', "&"),
			'name' => 'Xác nhận đăng ký thành viên',
		);
		$this->_data['breadcrumbs'] = $this->_breadcrumbs;

		$this->_data['title'] = 'Xác nhận đăng ký thành viên - ' . $this->_data['title'];
		$this->_data['main_content'] = 'layout/site/pages/verify-email-address';
		$this->load->view('layout/site/layout', $this->_data);
	}

	function site_forget_password() {
		$this->_initialize();

		$this->deny_logged_in();

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
			'name' => 'forget-password-validate',
		);
		$this->set_modules();

		$post = $this->input->post();

		if (!empty($post)) {
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[255]');

			if ($this->form_validation->run($this)) {
				$email = $this->input->post('email');
				$user = $this->M_users->get_by_email($email);

				if (!empty($user)) {
					$this->load->helper('string');
					$data = array(
						'activation_key' => $this->__encrip_password(random_string('unique')),
					);
					if ($this->M_users->update($user['userid'], $data)) {
						$partial = array();
						$user['activation_key'] = $data['activation_key'];
						$partial['data'] = $user;
						$data_sendmail = array(
							'sender_email' => $this->_data['email'],
							'sender_name' => $this->_data['site_name'] . ' - ' . $this->_data['email'],
							'receiver_email' => $email, //mail nhan thư
							'subject' => 'Quên mật khẩu',
							'message' => $this->load->view('layout/site/partial/html-template-forget-password', $partial, true),
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
			'name' => 'Quên mật khẩu',
		);
		$this->_data['breadcrumbs'] = $this->_breadcrumbs;

		$this->_data['title'] = 'Quên mật khẩu - ' . $this->_data['title'];
		$this->_data['main_content'] = 'layout/site/pages/forget-password';
		$this->load->view('layout/site/layout', $this->_data);
	}

	function site_login_facebook_ajax() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$message = array();
		$message['status'] = 'warning';
		$message['content'] = null;
		$message['message'] = 'Kiểm tra thông tin';

		$access_token = $this->input->post('access_token');
		$url = "https://graph.facebook.com/me?fields=id,name,email,picture,link,gender,birthday,locale,last_name,first_name,cover&access_token=$access_token";
		$postData = array();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		$response = curl_exec($ch);

		curl_close($ch);

		$nested_object = json_decode($response);
		$userProfile = json_decode(json_encode($nested_object), true);
		//var_dump($userProfile);

		if (is_array($userProfile) && !empty($userProfile)) {
			// Preparing data for database insertion
			$data = array();
			$data['oauth_provider'] = 'facebook';
			$data['oauth_uid'] = $userProfile['id'];
			$data['email'] = (isset($userProfile['email']) && ($userProfile['email'] != NULL)) ? $userProfile['email'] : '';
			$data['gender'] = ($userProfile['gender'] == 'male') ? 'M' : 'F';
			$data['locale'] = $userProfile['locale'];
			$data['profile_url'] = 'https://www.facebook.com/' . $userProfile['id'];
			$data['picture_url'] = $userProfile['picture']['data']['url'];
			// Insert or update user data
			$isset_user = $this->M_users->checkUser($data);
			if (is_array($isset_user) && !empty($isset_user)) {
				$row = $isset_user;
				$sess_array = array(
					'userid' => $row['userid'],
					'username' => $row['username'],
					'full_name' => $row['full_name'],
					'photo' => $row['photo'],
					'group_id' => $row['group_id'],
				);
				$this->session->set_userdata('logged_in', $sess_array);
				$this->set_last_login($row['userid']);
				$this->set_last_ip($row['userid']);
				$this->set_last_agent($row['userid']);
				$this->M_users->update($row['userid'], array('modified' => time()));
			} else {
				$birthday_time = 0;
				if (isset($userProfile['birthday'])) {
					$birthday = explode('/', $userProfile['birthday']);
					if (isset($birthday[0]) && isset($birthday[1]) && isset($birthday[2])) {
						$birthday_time = strtotime($birthday[2] . "-" . $birthday[0] . "-" . $birthday[1]);
					}
				}

				$data['username'] = $data['email'];
				$data['password'] = '';
				$data['full_name'] = $userProfile['last_name'] . ' ' . $userProfile['first_name'];
				$data['phone'] = '';
				$data['address'] = '';
				$data['regdate'] = time();
				$data['birthday'] = $birthday_time;
				$data['view_mail'] = 0;
				$data['active'] = 1;
				$data['created'] = time();
				$data['modified'] = 0;

				$userid = $this->M_users->add($data);
				if ($userid != 0) {
					$data_groups_users = array(
						'group_id' => 3,
						'userid' => $userid,
					);
					$this->M_groups_users->add($data_groups_users);
				}

				$row = $this->M_users->get($userid);
				$sess_array = array(
					'userid' => $row['userid'],
					'username' => $row['username'],
					'full_name' => $row['full_name'],
					'photo' => $row['photo'],
					'group_id' => $row['group_id'],
				);
				$this->session->set_userdata('logged_in', $sess_array);
				$this->set_last_login($row['userid']);
				$this->set_last_ip($row['userid']);
				$this->set_last_agent($row['userid']);
			}

			$message['status'] = 'success';
			$message['content'] = array('redirect' => site_url());
			$message['message'] = 'success!';
		}
		echo json_encode($message);
		exit();
	}

	function site_forget_password_ajax() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		$this->_initialize();
		$message = array();
		$message['status'] = 'warning';
		$message['content'] = null;
		$message['message'] = 'Có lỗi xảy ra! Vui lòng thực hiện lại!';

		$post = $this->input->post();

		if (!empty($post)) {
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[255]');

			if ($this->form_validation->run($this)) {
				$email = $this->input->post('email');
				$user = $this->M_users->get_by_email($email);

				if (!empty($user)) {
					$this->load->helper('string');
					$data = array(
						'activation_key' => $this->__encrip_password(random_string('unique')),
					);
					if ($this->M_users->update($user['userid'], $data)) {
						$partial = array();
						$user['activation_key'] = $data['activation_key'];
						$partial['data'] = $user;
						$data_sendmail = array(
							'sender_email' => $this->_data['email'],
							'sender_name' => $this->_data['site_name'] . ' - ' . $this->_data['email'],
							'receiver_email' => $email, //mail nhan thư
							'subject' => 'Quên mật khẩu',
							'message' => $this->load->view('layout/site/partial/html-template-forget-password', $partial, true),
						);
						modules::run('emails/send_mail', $data_sendmail);

						$message['status'] = 'success';
						$message['content'] = null;
						$message['message'] = 'Bạn hãy xem mail để lấy lại mật khẩu!';
					} else {
						$message['status'] = 'danger';
						$message['content'] = null;
						$message['message'] = 'Có lỗi xảy ra vui lòng thực hiện lại!';
					}
				} else {
					$message['status'] = 'danger';
					$message['content'] = null;
					$message['message'] = 'Email không tồn tại!';
				}
			}
		}
		echo json_encode($message);
		exit();
	}

	function site_reset_password() {
		$this->_initialize();

		if (!$this->input->get('u') || !$this->input->get('code')) {
			show_404();
		}

		$code = $this->input->get('code');
		$username = $this->input->get('u');
		$user = $this->M_users->get_by_activation_key($username, $code);
		if (empty($user)) {
			redirect(site_url());
		}

		$post = $this->input->post();
		if (!empty($post)) {
			$this->load->helper('language');
			$this->lang->load('form_validation', 'vietnamese');
			$this->lang->load('user', 'vietnamese');

			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|min_length[6]|max_length[255]');
			$this->form_validation->set_rules('password_confirm', 'Nhập lại mật khẩu', 'trim|required|min_length[6]|max_length[255]');

			if ($this->form_validation->run($this)) {
				$pass = $this->input->post('password');
				$cpass = $this->input->post('password_confirm');
				if ($pass != $cpass) {
					$notify_type = 'danger';
					$notify_content = 'Mật khẩu xác nhận không đúng!!';
					$this->set_notify($notify_type, $notify_content);
					redirect(site_url('reset-mat-khau') . "?u=" . $username . "&code=" . $code);
				} else {
					$data = array(
						'password' => $this->__encrip_password($pass),
						'activation_key' => '',
					);
					if ($this->M_users->update($user['userid'], $data)) {
						$notify_type = 'success';
						$notify_content = 'Mật khẩu đã đổi thành công!<br><a href="' . site_url() . '">Về trang chủ</a>';
						$this->set_notify($notify_type, $notify_content);
						redirect(current_full_url());
					} else {
						$notify_type = 'danger';
						$notify_content = 'Mật khẩu chưa được đổi! Vui lòng thực hiện lại!';
						$this->set_notify($notify_type, $notify_content);
						redirect(site_url('reset-mat-khau') . "?u=" . $username . "&code=" . $code);
					}
				}
			}
		}
		$this->_data['code'] = $code;
		$this->_data['username'] = $username;
		$this->_breadcrumbs[] = array(
			'url' => current_full_url(),
			'name' => 'Mật khẩu mới',
		);
		$this->_data['breadcrumbs'] = $this->_breadcrumbs;

		$this->_data['title'] = 'Quên mật khẩu - ' . $this->_data['title'];
		$this->_data['main_content'] = 'layout/site/pages/reset-password';
		$this->load->view('layout/site/layout', $this->_data);
	}

	function site_change_password_ajax() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$message = array();
		$message['status'] = 'warning';
		$message['content'] = null;
		$message['message'] = 'Có lỗi xảy ra! Vui lòng thực hiện lại!';

		$post = $this->input->post();

		if (!empty($post)) {
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('current_password', 'Mật khẩu hiện tại', 'trim|required|min_length[6]');
			$this->form_validation->set_rules('password', 'Mật khẩu mới', 'trim|required|min_length[6]');
			$this->form_validation->set_rules('password_confirm', 'Nhập lại mật khẩu mới', 'trim|required|min_length[6]');

			if ($this->form_validation->run($this)) {
				if (!$this->is_current_password()) {
					$message['status'] = 'danger';
					$message['content'] = null;
					$message['message'] = 'Mật khẩu hiện tại không đúng!';
				} else {
					$password_confirm = $this->input->post('password_confirm');
					$password = $this->input->post('password');
					if ($password_confirm != $password) {
						$message['status'] = 'danger';
						$message['content'] = null;
						$message['message'] = 'Mật khẩu xác nhận không đúng!';
					} else {
						$password = $this->__encrip_password($password);
						$userid = $this->_data['userid'];
						$data = array(
							'password' => $password,
						);
						if ($this->M_users->update($userid, $data)) {
							$message['status'] = 'success';
							$message['content'] = null;
							$message['message'] = 'Mật khẩu đã đổi thành công!';
						} else {
							$message['status'] = 'danger';
							$message['content'] = null;
							$message['message'] = 'Mật khẩu chưa được đổi! Vui lòng thực hiện lại!';
						}
					}
				}
			}
		}
		echo json_encode($message);
		exit();
	}

	function site_register_ajax() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$this->_initialize();
		$message = array();
		$message['status'] = 'warning';
		$message['content'] = null;
		$message['message'] = 'Có lỗi xảy ra! Vui lòng thực hiện lại!';

		$post = $this->input->post();

		if (!empty($post)) {
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('full_name', 'Họ tên', 'trim|required|min_length[5]|max_length[255]');
			$this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required|min_length[5]|max_length[255]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[255]');
			$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|min_length[6]|max_length[255]');

			if ($this->form_validation->run($this)) {
				if (!$this->check_username_availablity()) {
					$message['status'] = 'danger';
					$message['content'] = null;
					$message['message'] = 'Tên đăng nhập này đã tồn tại. Vui lòng chọn tên khác!';
				} elseif (!$this->check_email_availablity()) {
					$message['status'] = 'danger';
					$message['content'] = null;
					$message['message'] = 'Email này đã có người sử dụng. Vui lòng nhập email khác!';
				} else {
					$this->load->helper('string');
					$activation_key = $this->__encrip_password(random_string('unique'));
					$email = $this->input->post('email');

					$username = $this->input->post('username');
					$data = array(
						'username' => $username,
						'password' => $this->__encrip_password($this->input->post('password')),
						'email' => $email,
						'full_name' => $this->input->post('full_name'),
						'phone' => '',
						'address' => '',
						'gender' => 'M',
						'regdate' => time(),
						'birthday' => time(),
						'view_mail' => 0,
						'activation_key' => $activation_key,
						'active' => 0,
					);

					$userid = $this->M_users->add($data);
					if ($userid != 0) {
						$data_groups_users = array(
							'group_id' => 3,
							'userid' => $userid,
						);
						$this->M_groups_users->add($data_groups_users);

						$partial = array();
						$partial['data'] = $data;
						$data_sendmail = array(
							// 'sender_email' => get_first_element($this->_data['email']),
							// 'sender_name' => $this->_data['site_name'] . ' - ' . get_first_element($this->_data['email']),
							'sender_email' => $this->_data['email'],
							'sender_name' => $this->_data['site_name'] . ' - ' . $this->_data['email'],
							'receiver_email' => $email, //mail nhan thư
							'subject' => 'Xác nhận đăng ký thành viên',
							'message' => $this->load->view('layout/site/partial/html-template-verify-email-address', $partial, true),
						);
						modules::run('emails/send_mail', $data_sendmail);

						$data_sendmail = array(
							'sender_email' => $email,
							'sender_name' => $this->_data['site_name'] . ' - Đăng ký thành viên - ' . $email,
							'receiver_email' => $this->_data['email'], //mail nhan thư
							'subject' => 'Đăng ký thành viên mới',
							'message' => $this->load->view('layout/site/partial/html-template-notify-new-member', $partial, true),
						);
						modules::run('emails/send_mail', $data_sendmail);

						$message['status'] = 'success';
						$message['content'] = null;
						$message['message'] = 'Đăng ký thành công! Mời bạn xác nhận email để kích hoạt và đăng nhập!';
					} else {
						$message['status'] = 'danger';
						$message['content'] = null;
						$message['message'] = 'Tài khoản chưa được tạo! Vui lòng đăng ký lại!';
					}
				}
			}
		}
		echo json_encode($message);
		exit();
	}

	function site_login_ajax() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$message = array();
		$message['status'] = 'warning';
		$message['content'] = null;
		$message['message'] = 'Có lỗi xảy ra! Vui lòng thực hiện lại!';

		$post = $this->input->post();

		if (!empty($post)) {
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required|min_length[3]|max_length[60]');
			$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|min_length[6]|max_length[60]');

			if ($this->form_validation->run($this)) {
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$encrip_password = $this->__encrip_password($password);

				$row = $this->M_users->validate_login($username, $encrip_password);

				if (!empty($row)) {
					$sess_array = array(
						'userid' => $row['userid'],
						'username' => $row['username'],
						'full_name' => $row['full_name'],
						'photo' => $row['photo'],
						'group_id' => $row['group_id'],
					);
					$this->session->set_userdata('logged_in', $sess_array);
					$this->set_last_login($row['userid']);
					$this->set_last_ip($row['userid']);
					$this->set_last_agent($row['userid']);
					$message['status'] = 'success';
					$message['content'] = array('data' => $row);
					$message['message'] = 'Đăng nhập thành công!';
				} else {
					$message['status'] = 'danger';
					$message['content'] = null;
					$message['message'] = 'Tên đăng nhập hoặc mật khẩu không đúng!';
				}
			}
		}
		echo json_encode($message);
		exit();
	}

	function site_login() {
		redirect(site_url());
		$this->_initialize();

		$this->deny_logged_in();

		/*
			         * Google login
		*/
		// Include the google api php libraries
		include_once APPPATH . "libraries/google-api-php-client/Google_Client.php";
		include_once APPPATH . "libraries/google-api-php-client/contrib/Google_Oauth2Service.php";

		// Google Project API Credentials
		$clientId = $this->config->item('app_id', 'google');
		$clientSecret = $this->config->item('app_secret', 'google');
		$redirectUrl = site_url($this->config->item('redirect_url', 'google'));

		// Google Client Configuration
		$gClient = new Google_Client();
		$gClient->setApplicationName($this->_data['title_seo']);
		$gClient->setClientId($clientId);
		$gClient->setClientSecret($clientSecret);
		$gClient->setRedirectUri($redirectUrl);
		$google_oauthV2 = new Google_Oauth2Service($gClient);

		if (isset($_REQUEST['code'])) {
			$gClient->authenticate();
			$this->session->set_userdata('token', $gClient->getAccessToken());
			redirect($redirectUrl);
		}

		$token = $this->session->userdata('token');
		if (!empty($token)) {
			$gClient->setAccessToken($token);
		}

		if ($gClient->getAccessToken()) {
			$userProfile = $google_oauthV2->userinfo->get();
			/* echo "<pre>";
				print_r($userProfile);
				echo "</pre>";
			*/
			// Preparing data for database insertion
			$data['oauth_provider'] = 'google';
			$data['oauth_uid'] = $userProfile['id'];
			$data['email'] = $userProfile['email'];
			$data['gender'] = isset($userProfile['gender']) ? ($userProfile['gender'] == 'male' ? 'M' : 'F') : 'N';
			$data['locale'] = $userProfile['locale'];
			$data['profile_url'] = isset($userProfile['link']) ? $userProfile['link'] : '';
			$data['picture_url'] = $userProfile['picture'];

			$isset_user = $this->M_users->checkUser($data);
			if (is_array($isset_user) && !empty($isset_user)) {
				$row = $isset_user;
				$sess_array = array(
					'userid' => $row['userid'],
					'username' => $row['username'],
					'full_name' => $row['full_name'],
					'photo' => $row['photo'],
					'group_id' => $row['group_id'],
				);
				$this->session->set_userdata('logged_in', $sess_array);
				$this->set_last_login($row['userid']);
				$this->set_last_ip($row['userid']);
				$this->set_last_agent($row['userid']);
				$this->M_users->update($row['userid'], array('modified' => time()));
				$this->redirect_after();
			} else {
				$data['username'] = '';
				$data['password'] = '';
				$data['full_name'] = $userProfile['family_name'] . ' ' . $userProfile['given_name'];
				$data['phone'] = '';
				$data['address'] = '';
				$data['regdate'] = time();
				$data['birthday'] = 0;
				$data['view_mail'] = 0;
				$data['active'] = 1;
				$data['created'] = time();
				$data['modified'] = 0;

				$userid = $this->M_users->add($data);
				if ($userid != 0) {
					$data_groups_users = array(
						'group_id' => 3,
						'userid' => $userid,
					);
					$this->M_groups_users->add($data_groups_users);
				}

				$row = $this->M_users->get($userid);
				$sess_array = array(
					'userid' => $row['userid'],
					'username' => $row['username'],
					'full_name' => $row['full_name'],
					'photo' => $row['photo'],
					'group_id' => $row['group_id'],
				);
				$this->session->set_userdata('logged_in', $sess_array);
				$this->set_last_login($row['userid']);
				$this->set_last_ip($row['userid']);
				$this->set_last_agent($row['userid']);
				$this->redirect_after();
			}
		} else {
			$this->_data['auth_gg_url'] = $gClient->createAuthUrl();
		}

		$this->load->model('users/m_users_config', 'M_users_config');
		$this->load->helper('language');
		$this->lang->load('form_validation', 'vietnamese');

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
			'name' => 'login-validate',
		);
		$this->set_modules();

		$post = $this->input->post();

		if (!empty($post)) {
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required|min_length[3]|max_length[60]');
			$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|min_length[6]|max_length[60]');

			if ($this->form_validation->run($this)) {
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$encrip_password = $this->__encrip_password($password);

				$row = $this->M_users->validate_login($username, $encrip_password);

				if (!empty($row)) {
					$sess_array = array(
						'userid' => $row['userid'],
						'username' => $row['username'],
						'full_name' => $row['full_name'],
						'photo' => $row['photo'],
						'group_id' => $row['group_id'],
					);
					$this->session->set_userdata('logged_in', $sess_array);
					$this->set_last_login($row['userid']);
					$this->set_last_ip($row['userid']);
					$this->set_last_agent($row['userid']);
					if ($this->input->get('redirect_page')) {
						$redirect_page = base64_decode($this->input->get('redirect_page'));
					} else {
						$redirect_page = base_url();
					}
					redirect($redirect_page);
				} else {
					$notify_type = 'danger';
					$notify_content = 'Tên đăng nhập hoặc mật khẩu không đúng!';
					$this->set_notify($notify_type, $notify_content);
				}
			}
		}

		$this->_breadcrumbs[] = array(
			'url' => base_url('dang-nhap'),
			'name' => 'Đăng nhập',
		);
		$this->set_breadcrumbs();

		$this->_data['title_seo'] = 'Đăng nhập' . ' - ' . $this->_data['title_seo'];
		$this->_data['main_content'] = 'layout/site/pages/login';
		$this->load->view('layout/site/layout', $this->_data);
	}

	function admin_index() {

		if ($this->validate_admin_logged_in()) {
			//die('dasdas');
			//modules::run('dashboard/index');
			$this->load->module('dashboard');
			$this->dashboard->index();
		} else {
			$this->_initialize_admin();

			$post = $this->input->post();
			if (!empty($post)) {
				$this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required');
				$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required');

				if ($this->form_validation->run($this)) {
					if ($this->validate_login()) {
						redirect(get_admin_url());
					} else {
						$this->_data['messing'] = 'Tên đăng nhập hoặc mật khẩu chưa đúng!';
					}
				}
			}
			$this->_data['title'] = 'Đăng nhập quản trị - ' . $this->_data['title_seo'];
			$this->load->view('admin/view_page_admin_login', $this->_data);
		}
	}

	function validate_current_password() {
		$username = $this->_data['username'];
		$current_password = $this->__encrip_password($this->input->post('current_password'));

		$result = $this->M_users->validate_current_password($username, $current_password);

		if (!$result) {
			$notify_type = 'danger';
			$notify_content = 'Mật khẩu hiện tại không đúng!';
			$this->set_notify($notify_type, $notify_content);
			$this->form_validation->set_message('validate_current_password', '%s không đúng!');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function is_current_password() {
		$username = $this->_data['username'];
		$current_password = $this->__encrip_password($this->input->post('current_password'));

		$result = $this->M_users->validate_current_password($username, $current_password);

		if (!$result) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function validate_login() {
		$username = $this->input->post('username');
		$password = $this->__encrip_password($this->input->post('password'));
		$is_admin = TRUE;

		$row = $this->M_users->validate_login($username, $password, $is_admin);

		if ($row) {
			$sess_array = array(
				'userid' => $row['userid'],
				'username' => $row['username'],
				'full_name' => $row['full_name'],
				'photo' => $row['photo'],
				'regdate' => $row['regdate'],
				'group_id' => $row['group_id'],
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
			if (isset($session_data['group_id']) && $session_data['group_id'] > 3) {
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
				redirect(site_url('dang-nhap') . '?redirect_page=' . base64_encode(current_full_url()));
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
		$this->session->sess_destroy();
		redirect(base_url());
	}

	function site_changepass() {
		$this->_initialize();

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
			$this->form_validation->set_rules('password', 'Mật khẩu mới', 'trim|required|min_length[6]');
			$this->form_validation->set_rules('password_confirm', 'Nhập lại mật khẩu mới', 'trim|required|min_length[6]');

			if ($this->form_validation->run($this)) {
				$password_confirm = $this->input->post('password_confirm');
				$password = $this->input->post('password');
				if ($password_confirm != $password) {
					$notify_type = 'danger';
					$notify_content = 'Mật khẩu xác nhận không đúng!!';
					$this->set_notify($notify_type, $notify_content);
					redirect(site_url('doi-mat-khau'));
				}

				$password = $this->__encrip_password($password);
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
				redirect(site_url('doi-mat-khau'));
			}
		}
		$this->_data['user'] = $this->M_users->get_by_username($this->_data['username']);

		$this->_breadcrumbs[] = array(
			'url' => site_url('doi-mat-khau'),
			'name' => 'Đổi mật khẩu',
		);
		$this->set_breadcrumbs();

		$this->_data['title_seo'] = 'Đổi mật khẩu - ' . $this->_data['title_seo'];
		$this->_data['main_content'] = 'layout/site/pages/changepass';
		$this->load->view('layout/site/layout', $this->_data);
	}

	function site_profile() {
		$this->_initialize();

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
			'name' => 'editinfo-validate',
		);
		$this->set_modules();

		$post = $this->input->post();

		if (!empty($post)) {
			//var_dump($this->input->post('birthday')); die;
			$this->load->helper('language');
			$this->lang->load('form_validation', 'vietnamese');
			$this->lang->load('user', 'vietnamese');
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('full_name', 'Họ tên', 'trim|required|min_length[6]');

			if ($this->form_validation->run($this)) {
				$userid = $this->_data['userid'];

				$data = array(
					'full_name' => $this->input->post('full_name'),
					'address' => $this->input->post('address'),
					'phone' => $this->input->post('phone'),
				);

				if ($this->M_users->update($userid, $data)) {
					$logged_in_session = $this->session->userdata('logged_in');
					$logged_in_session['full_name'] = $this->input->post('full_name');
					$this->session->set_userdata('logged_in', $logged_in_session);

					$notify_type = 'success';
					$notify_content = 'Cập nhật thông tin cá nhân thành công!';
					$this->set_notify($notify_type, $notify_content);
				} else {
					$notify_type = 'danger';
					$notify_content = 'Thông tin cá nhân chưa được đổi! Vui lòng thực hiện lại!';
					$this->set_notify($notify_type, $notify_content);
				}
				redirect(site_url('trang-ca-nhan'));
			}
		}
		$user = $this->M_users->get_by_username($this->_data['username']);
		$this->_data['user'] = $user;

		$customers = modules::run('customers/gets', array('user_id' => $user['userid']));
		$in_customer_id = array(-1);
		if(is_array($customers) && !empty($customers)){
			$in_customer_id = array_column($customers, 'customer_id');
		}
		$orders = modules::run('shops/orders/gets', array('in_customer_id' => $in_customer_id));
		$this->_data['orders'] = $orders;

		$this->_breadcrumbs[] = array(
			'url' => site_url('trang-ca-nhan'),
			'name' => 'Trang cá nhân',
		);
		$this->set_breadcrumbs();

		$this->_data['title_seo'] = 'Trang cá nhân - ' . $this->_data['title_seo'];
		$this->_data['main_content'] = 'layout/site/pages/profile';
		$this->load->view('layout/site/layout', $this->_data);
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
//dùng để kiểm tra username khi admin cập nhật thông tin cho user
		$this->load->model('users/m_users', 'M_users');
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
				$username = $this->input->
					post('username');
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
//dùng để kiểm tra email khi admin cập nhật thông tin cho user
		$this->load->model('users/m_users', 'M_users');
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
				$email = $this->
					input->post('email');
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
				$current_password = $this->__encrip_password($this->input->post('current_password'));
				$username = $this->_data['username'];
				if ($this->M_users->check_current_password_availablity($username, $current_password)) {
					$this->_status = "success";
					$this->_message = $this->_message_success;
				} else {
					$this->_status = "danger";
					$this->_message = $this->_message_danger;
				}$this->set_json_encode();
				$this->load->view('layout/json_data', $this->_data);
			} else {
				$current_password = $this->__encrip_password($this->input->post(
					'current_password'));
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
				$this->load->view('layout/json_data', $this->
						_data);
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
				$this->load->view(
					'layout/json_data', $this->_data);
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
		$this->_initialize_admin();
		$this->_message_success = 'Đã xóa tài khoản và dữ liệu liên quan!';
		$this->_message_warning = 'Tài khoản này không tồn tại!';
		if ($this->validate_admin_logged_in() == TRUE) {
			if ($this->input->post('ajax') == '1') {
				$id = $this->input->post('id');
				if ($id != 0) {
					$current_photo = $this->get($id);
					$this->load->module('users/groups_users');
					$group_id = $this->groups_users->get_group_id($id);
					if ($group_id['group_id'] < 4) {
						if ($this->M_users->delete($id)) {
							$this->groups_users->delete($id);
							if ($current_photo['photo'] != 'no_avatar.jpg') {
								@unlink(FCPATH . $this->_users_path . $current_photo['photo']);
							}
							$this->_status = "success";
							$this->_message = $this->_message_success;
						} else {
							$this->_status = "danger";
							$this->_message = $this->_message_danger;
						}
					} else {
						$this->_status = "danger";
						$this->_message = "Không được xóa tài khoản admin!";
					}
				} else {
					$this->_status = "warning";
					$this->_message = $this->_message_warning;
				}

				$this->set_json_encode();
				$this->load->view('layout/json_data', $this->_data);
			} else {
				$id = $this->input->get('id');
				if ($id != 0) {
					$current_photo = $this->get($id);
					$this->load->module('users/groups_users');
					$group_id = $this->groups_users->get_group_id($id);
					if ($group_id['group_id'] < 4) {
						if ($this->M_users->delete($id)) {
							$this->groups_users->delete($id);
							if ($current_photo['photo'] != 'no_avatar.jpg') {
								@unlink(FCPATH . $this->_users_path . $current_photo['photo']);
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
				redirect(get_admin_url('users'));
			}
		} else {
			if ($this->input->post('ajax') == '1') {
				$this->_status = "danger";
				$this->_message = $this->_message_banned;

				$this->set_json_encode();
				$this->load->view('layout/json_data', $this->_data);
			} else {
				$notify_type = 'danger';
				$notify_content = $this->_message_banned;
				$this->set_notify_admin($notify_type, $notify_content);
				redirect(get_admin_url('users'));
			}
		}
	}

}

/* End of file users.php */
/* Location: ./application/modules/users/controllers/users.php */