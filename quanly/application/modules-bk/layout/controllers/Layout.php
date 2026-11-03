<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Layout extends MX_Controller {

	public $_data = array();
	public $language;
	public $_toolbar_full = array(
		array('Source', 'Undo', 'Redo', '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat'),
		array('Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'),
		array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'),
		array('JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'),
		array('Link', 'Unlink'),
		array('Image', 'Table', 'HorizontalRule'),
		array('Styles', 'Format', 'Font', 'FontSize'),
		array('TextColor', 'BGColor'),
	);
	public $_toolbar_mini = array(
		array('Bold', 'Italic', 'Underline', 'Strike'),
		array('Link', 'Unlink'),
		array('Styles', 'Format', 'Font', 'FontSize'),
		array('TextColor', 'BGColor'),
	);
	protected $_status = '';
	protected $_message = '';
	protected $_content = NULL;
	protected $_message_success = '';
	protected $_message_warning = '';
	protected $_message_danger = 'Rất tiếc! Có lỗi kỹ thuật!';
	protected $_message_banned = 'Không có quyền truy cập vào khu vực này!';
	protected $_breadcrumbs = array();
	protected $_breadcrumbs_admin = array();
	protected $_externals = array();
	protected $_externals_admin = array();
	protected $_auto_load_css = array();
	protected $_auto_load_js = array();
	protected $_auto_load_css_admin = array();
	protected $_auto_load_js_admin = array();
	protected $_any_css = array();
	protected $_all_css = array();
	protected $_all_script = array();
	protected $_plugins_css = array();
	protected $_plugins_script = array();
	protected $_all_css_admin = array();
	protected $_all_script_admin = array();
	protected $_vendor_css_admin = array();
	protected $_vendor_script_admin = array();
	protected $_plugins_css_admin = array();
	protected $_plugins_script_admin = array();
	protected $_modules_css = array();
	protected $_modules_script = array();

	function __construct() {
		parent::__construct();
		/*

		$configs = $this->get_configs();
		$this->_breadcrumbs[] = array(
			'url' => base_url(),
			'name' => '<i class="glyphicon glyphicon-home"></i>',
		);
		$this->_data['breadcrumbs'] = $this->_breadcrumbs;

		$this->_breadcrumbs_admin[] = array(
			'url' => '',
			'name' => 'Admin',
			'image' => base_url('assets/Frest/app-assets/images/logo/logo.png'),
		);
		$this->set_breadcrumbs_admin();

		$this->_data['toolbar_full'] = $this->_toolbar_full;
		$this->_data['toolbar_mini'] = $this->_toolbar_mini;

		$parse = parse_url(base_url());
		$this->_data['site_name'] = $configs['site_name'];
		$this->_data['title'] = $configs['site_name'];
		$this->_data['email'] = $configs['site_email'];
		$this->_data['phone'] = $configs['site_phone'];
		$this->_data['store'] = $configs['site_store'];
		$this->_data['address'] = $configs['site_address'];

		$this->_data['host'] = $parse['host'];
		$this->_data['breadcrumbs_module_name'] = '';
		$this->_data['breadcrumbs_module_func'] = '';
		$this->_data['logged_in'] = FALSE;

		//search
		$this->_data['q'] = $this->input->get('q');

		$this->_data['externals'] = $this->_externals;

		//auto load
		$this->_auto_load_css[] = array(
			'folder' => 'bootstrap-back-to-top/css',
			'name' => 'bootstrap-back-to-top',
		);
		$this->_auto_load_js[] = array(
			'folder' => 'bootstrap-back-to-top/css',
			'name' => 'bootstrap-back-to-top',
		);

		//set all css, js, plugins
		$this->_data['all_css'] = $this->_all_css;
		$this->_data['all_script'] = $this->_all_script;
		$this->set_plugins();

		//set all css, js, plugins in admin
		$this->_plugins_css_admin[] = array(
			'folder' => 'iCheck',
			'name' => 'all',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'iCheck',
			'name' => 'icheck',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'iCheck',
			'name' => 'app.icheck',
		);

		$this->_data['vendor_css_admin'] = $this->_vendor_css_admin;
		$this->_data['vendor_script_admin'] = $this->_vendor_script_admin;
		$this->_data['all_css_admin'] = $this->_all_css_admin;
		$this->_data['all_script_admin'] = $this->_all_script_admin;
		$this->set_plugins_admin();
		$this->set_modules();
		$this->set_any();

		//active menu
		$segment = 1;
		$this->_data['menu_admin_active'] = ($this->uri->segment($segment) == '') ? '' : $this->uri->segment($segment);
		$segment = 2;
		$this->_data['menu_sub_admin_active'] = ($this->uri->segment($segment) == '') ? '' : $this->uri->segment($segment);

		if ($this->session->has_userdata('logged_in')) {
			$this->_data['logged_in'] = TRUE;
			$session_data = $this->session->userdata('logged_in');
			$this->_data['userid'] = $session_data['userid'];
			$this->_data['username'] = $session_data['username'];
			$this->_data['full_name'] = $session_data['full_name'];
			$this->_data['photo'] = $session_data['photo'];
			$this->_data['regdate'] = isset($session_data['regdate']) ? $session_data['regdate'] : '';
			$this->_data['role'] = $session_data['role'];
			$this->_data['have_add'] = $session_data['have_add'];
			$this->_data['have_edit'] = $session_data['have_edit'];
			$this->_data['have_delete'] = $session_data['have_delete'];

			if (trim($this->_data['photo']) != '' && remote_file_exists($this->_data['photo'])) {
				$this->_data['avatar'] = $this->_data['photo'];
			} else {
				$this->_data['avatar'] = 'no_avatar.jpg';
			}
		}

		if ($this->session->has_userdata('logged_in_by')) {
			$this->_data['logged_in'] = TRUE;
            $session_data = $this->session->userdata('logged_in_by');
            $this->_data['userid'] = $session_data['userid'];
			$this->_data['username'] = $session_data['username'];
			$this->_data['full_name'] = $session_data['full_name'];
			$this->_data['photo'] = $session_data['photo'];
			$this->_data['regdate'] = isset($session_data['regdate']) ? $session_data['regdate'] : '';
			$this->_data['role'] = $session_data['role'];
			$this->_data['have_add'] = $session_data['have_add'];
			$this->_data['have_edit'] = $session_data['have_edit'];
			$this->_data['have_delete'] = $session_data['have_delete'];

			if (trim($this->_data['photo']) != '' && remote_file_exists($this->_data['photo'])) {
				$this->_data['avatar'] = $this->_data['photo'];
			} else {
				$this->_data['avatar'] = 'no_avatar.jpg';
			}
		}

		$this->_data['menus'] = $this->_load_menu();

		if(isset($this->_data['logged_in']) && $this->_data['logged_in']){
			$user_id = 83;
			$notification_counts = $this->M_users_notification->counts(array(
				'notifier_id' => $user_id,
				'status' => -1,
			));
			$this->_data['notification_counts'] = $notification_counts;

			$notifications = $this->M_users_notification->gets(array(
				'notifier_id' => $user_id,
				'order_by' => array(
		            'created' => 'DESC'
				)
			), 5, 0);
			$this->_data['notifications'] = $notifications;
			//echo time() - 25*3600; die;
		}
		*/
	}

	public function _load_menu(){
		$order_by = array(
            'order' => 'ASC',
        );
        $args = array();
        $args['order_by'] = $order_by;
        $args['status'] = 1;
        $args['parent_id'] = 0;
		$rows = $this->M_menu->gets($args);
		if(is_array($rows) && !empty($rows)){
			foreach ($rows as $key => $value) {
				$args['parent_id'] = $value['id'];
				$rows[$key]['childs'] = $this->M_menu->gets($args);
			}
		}
		// echo "<pre>";
		// print_r($rows);
		// echo "</pre>";
		// die();
		return $rows;
	}

	public function _initialize_global($configs) {
		$parse = parse_url(base_url());
		$this->_data['host'] = $parse['host'];

		$this->_data['site_name'] = $configs['site_name'];
		$this->_data['title'] = $configs['site_name'];
		$this->_data['email'] = $configs['site_email'];
		$this->_data['phone'] = $configs['site_phone'];
		$this->_data['store'] = $configs['site_store'];
		$this->_data['address'] = $configs['site_address'];
		$this->_data['breadcrumbs_module_name'] = '';
		$this->_data['breadcrumbs_module_func'] = '';
		$this->_initialize_user();
		//$this->_data['menus'] = $this->_load_menu();
	}

	public function _initialize_user(){
		$this->_data['logged_in'] = FALSE;
		if ($this->session->has_userdata('logged_in')) {
			$this->_data['logged_in'] = TRUE;
			$session_data = $this->session->userdata('logged_in');
			$this->_data['userid'] = $session_data['userid'];
			$this->_data['username'] = $session_data['username'];
			$this->_data['full_name'] = $session_data['full_name'];
			$this->_data['photo'] = $session_data['photo'];
			$this->_data['regdate'] = isset($session_data['regdate']) ? $session_data['regdate'] : '';
			$this->_data['role'] = $session_data['role'];
			$this->_data['have_add'] = $session_data['have_add'];
			$this->_data['have_edit'] = $session_data['have_edit'];
			$this->_data['have_delete'] = $session_data['have_delete'];

			// if (trim($this->_data['photo']) != '' && remote_file_exists($this->_data['photo'])) {
			if (trim($this->_data['photo']) != '') {
				$this->_data['avatar'] = $this->_data['photo'];
			} else {
				$this->_data['avatar'] = 'no_avatar.jpg';
			}
		}

		if ($this->session->has_userdata('logged_in_by')) {
			$this->_data['logged_in'] = TRUE;
            $session_data = $this->session->userdata('logged_in_by');
            $this->_data['userid'] = $session_data['userid'];
			$this->_data['username'] = $session_data['username'];
			$this->_data['full_name'] = $session_data['full_name'];
			$this->_data['photo'] = $session_data['photo'];
			$this->_data['regdate'] = isset($session_data['regdate']) ? $session_data['regdate'] : '';
			$this->_data['role'] = $session_data['role'];
			$this->_data['have_add'] = $session_data['have_add'];
			$this->_data['have_edit'] = $session_data['have_edit'];
			$this->_data['have_delete'] = $session_data['have_delete'];

			// if (trim($this->_data['photo']) != '' && remote_file_exists($this->_data['photo'])) {
			if (trim($this->_data['photo']) != '') {
				$this->_data['avatar'] = $this->_data['photo'];
			} else {
				$this->_data['avatar'] = 'no_avatar.jpg';
			}
		}

		if($this->_data['logged_in']){
			$user_id = $this->_data['userid'];
			$notification_counts = $this->M_users_notification->counts(array(
				'notifier_id' => $user_id,
				'status' => -1,
			));
			$this->_data['notification_counts'] = $notification_counts;

			$notifications = $this->M_users_notification->gets(array(
				'notifier_id' => $user_id,
				'order_by' => array(
		            'created' => 'DESC'
				)
			), 5, 0);
			$this->_data['notifications'] = $notifications;
		}
	}

	public function _initialize(){
		$configs = $this->get_configs();
		$this->_initialize_global($configs);

		//set all css, js, plugins
		$this->add_css();
		$this->add_js();
		$this->set_plugins();
		$this->set_modules();
	}

	public function _initialize_admin(){
		$configs = $this->get_configs();
		$this->_initialize_global($configs);

		$this->_breadcrumbs_admin[] = array(
			'url' => '',
			'name' => 'Admin',
			'image' => base_url('assets/Frest/app-assets/images/logo/logo.png'),
		);
		$this->set_breadcrumbs_admin();

		//set all css, js, plugins in admin
		$this->_plugins_css_admin[] = array(
			'folder' => 'iCheck',
			'name' => 'all',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'iCheck',
			'name' => 'icheck',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'iCheck',
			'name' => 'app.icheck',
		);

		$this->_data['vendor_css_admin'] = $this->_vendor_css_admin;
		$this->_data['vendor_script_admin'] = $this->_vendor_script_admin;
		$this->_data['all_css_admin'] = $this->_all_css_admin;
		$this->_data['all_script_admin'] = $this->_all_script_admin;
		$this->set_plugins_admin();

		$this->_data['modules_css'] = $this->_modules_css;
		$this->_data['modules_script'] = $this->_modules_script;
		$this->set_modules();

		$this->set_plugins_admin();
		$this->set_modules();

		//active menu
		$segment = 1;
		$this->_data['menu_admin_active'] = ($this->uri->segment($segment) == '') ? '' : $this->uri->segment($segment);
		$segment = 2;
		$this->_data['menu_sub_admin_active'] = ($this->uri->segment($segment) == '') ? '' : $this->uri->segment($segment);
	}

    public function barcode(){
        /*
        $args = array(
            'text'=>'123456',
            'codetype'=>'code128',
            'orientation'=>'horizontal',
            'size'=>20,
            'print'=>true
        );
        */
        $filepath = (isset($_GET["filepath"]) ? $_GET["filepath"] : "");
        $text = (isset($_GET["text"]) ? $_GET["text"] : "0");
        $size = (isset($_GET["size"]) ? $_GET["size"] : "20");
        $orientation = (isset($_GET["orientation"]) ? $_GET["orientation"] : "horizontal");
        $code_type = (isset($_GET["codetype"]) ? $_GET["codetype"] : "code128");
        $print = (isset($_GET["print"]) && $_GET["print"] == 'true' ? true : false);
        $sizefactor = (isset($_GET["sizefactor"]) ? $_GET["sizefactor"] : "1");
        $name = (isset($_GET["name"]) ? $_GET["name"] : "");

        // This function call can be copied into your project and can be made from anywhere in your code
        barcode($filepath, $text, $size, $orientation, $code_type, $print, $sizefactor, $name);
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

	function index() {
		$this->_initialize_admin();
		if ($this->session->userdata('logged_in')) {
			$this->_vendor_css_admin[] = array(
				'folder' => 'charts',
				'name' => 'apexcharts',
			);
			$this->_vendor_css_admin[] = array(
				'folder' => 'extensions',
				'name' => 'dragula.min',
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
				'folder' => 'charts',
				'name' => 'apexcharts.min',
			);
			$this->_vendor_script_admin[] = array(
				'folder' => 'extensions',
				'name' => 'dragula.min',
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

			$this->_all_css_admin[] = array(
				'folder' => 'pages',
				'name' => 'dashboard-analytics',
			);
			$this->set_custom_all_admin();

			$this->_plugins_script_admin[] = array(
				'folder' => 'dashboard-analytics',
				'name' => 'dashboard',
			);
			$this->set_plugins_admin();
			/*
            $barcode_text = 'abc123456' . rand(1000, 9999);
            $barcode_args = array(
                'text' => $barcode_text,
                'codetype' => 'code128',
                'orientation' => 'horizontal',
                'size' => '20',
                'print'=> 'true'
            );
            $barcode_url = site_url('barcode') . '?' . http_build_query($barcode_args, '', "&");
            $barcode_src = 'uploads/barcodes/' . rand(5, 15) . '.png';
			save_image_from_url($barcode_url, $barcode_src);
            $this->_data['barcode_url'] = $barcode_url;
            */

			$time = time();
			$args_services_maintenance = modules::run('services/services_maintenance/default_args');
			$count_services_maintenance = modules::run('services/services_maintenance/counts', $args_services_maintenance);
			$this->_data['count_services_maintenance'] = $count_services_maintenance;

			$args_services_borrow = modules::run('services/services_borrow/default_args');
			$count_services_borrow = modules::run('services/services_borrow/counts', $args_services_borrow);
			$this->_data['count_services_borrow'] = $count_services_borrow;

			$args_consignment = modules::run('consignment/default_args');
			$count_consignment = modules::run('consignment/counts', $args_consignment);
			$this->_data['count_consignment'] = $count_consignment;

			$args_customers = modules::run('customers/default_args');
			$args_customers['birthday_start'] = get_start_date(date('Y-m-d'));
			$args_customers['birthday_end'] = get_end_date(date('Y-m-d'));
			$count_birthday_customers = modules::run('customers/counts', $args_customers);
			$this->_data['count_birthday_customers'] = $count_birthday_customers;

			$is_admin = (isset($this->_data['role']) && in_array($this->_data['role'], array('ADMIN')));
			$user_id = isset($this->_data['userid']) ? (int) $this->_data['userid'] : 0;
			// var_dump($user_id); die;
			$args_output_voucher = modules::run('output_voucher/default_args');
			if (!$is_admin) {
				$args_output_voucher['created_by'] = $user_id;
			}
			$args_output_voucher['deleted'] = 0;
			$args_output_voucher['status'] = 1;
			$count_output_voucher = modules::run('output_voucher/counts', $args_output_voucher);
			$this->_data['count_output_voucher'] = $count_output_voucher;

			$amount_output_voucher = $this->M_output_voucher->get_total($args_output_voucher);
			$this->_data['amount_output_voucher'] = $amount_output_voucher;

			//doanh thu tháng này
			$month_start = strtotime('first day of this month');
			$month_end = strtotime('last day of this month');
			$args_output_voucher['start_date_start'] = get_start_date(date('Y-m-d', $month_start));
			$args_output_voucher['start_date_end'] = get_end_date(date('Y-m-d', $month_end));
			// echo "<pre>";
			// print_r($args_output_voucher);
			// echo "</pre>";
			// die();
			$amount_this_month_output_voucher = $this->M_output_voucher->get_total($args_output_voucher);
			// echo date('d/m/Y H:i:s', $args_output_voucher['start_date_start']);
			// echo "<br/>" . date('d/m/Y H:i:s', $args_output_voucher['start_date_end']);
			// echo "<br/>" . $amount_this_month_output_voucher;
			// echo "<br/>----------------------------";

			//doanh thu tháng trước
			$month_start = strtotime('first day of last month');
			$month_end = strtotime('last day of last month');
			$args_output_voucher['start_date_start'] = get_start_date(date('Y-m-d', $month_start));
			$args_output_voucher['start_date_end'] = get_end_date(date('Y-m-d', $month_end));
			$amount_last_month_output_voucher = $this->M_output_voucher->get_total($args_output_voucher);
			// echo "<br/>" . date('d/m/Y H:i:s', $args_output_voucher['start_date_start']);
			// echo "<br/>" . date('d/m/Y H:i:s', $args_output_voucher['start_date_end']);
			// echo "<br/>" . $amount_last_month_output_voucher;
			// die;
			$this->_data['compared_to_the_same_period_last_month_output_voucher'] = $amount_last_month_output_voucher == 0 ? 100 : ($amount_this_month_output_voucher / $amount_last_month_output_voucher) * 100;

			//hoạt động hôm qua
			$month_start = strtotime('-1 day');
			$month_end = strtotime('-1 day');
			$args_output_voucher['start_date_start'] = get_start_date(date('Y-m-d', $month_start));
			$args_output_voucher['start_date_end'] = get_end_date(date('Y-m-d', $month_end));
			$activities_lastday = $this->M_output_voucher->gets($args_output_voucher);

			//hoạt động hôm nay
			$month_start = $time;
			$month_end = $time;
			$args_output_voucher['start_date_start'] = get_start_date(date('Y-m-d', $month_start));
			$args_output_voucher['start_date_end'] = get_end_date(date('Y-m-d', $month_end));
			$activities_today = $this->M_output_voucher->gets($args_output_voucher);

			$activities = array();
			if(is_array($activities_lastday) && !empty($activities_lastday)){
				$activities[] = array(
					'title' => 'HÔM QUA',
					'items' => $activities_lastday,
				);
			}
			if(is_array($activities_today) && !empty($activities_today)){
				$activities[] = array(
					'title' => 'HÔM NAY',
					'items' => $activities_today,
				);
			}
			$this->_data['activities'] = $activities;

			$years = array();
	        //$groups_year = $this->M_users_commission->gets_group_year();
	        $groups_year = $this->M_output_voucher->gets_group_year();
	        if(is_array($groups_year)){
	            $years = array_unique(array_column($groups_year, 'YEAR', 'YEAR'));
	        }

	        $max = 0;
	        $months = range(1, 12);
	        $charts = array();
	        if(is_array($years) && !empty($years)){
	        	foreach ($years as $year) {
	        		$chart = array();
	        		foreach ($months as $month) {
	        		    $month_year = $month . "-" . $year;
	        		    $time = strtotime("01-" . $month_year);
	        		    $month_start = strtotime('first day of this month', $time);
	        		    $month_end = strtotime('last day of this month', $time);
	        		    $start_date = get_start_date(date('Y-m-d', $month_start));
	        		    $end_date = get_end_date(date('Y-m-d', $month_end));
	        		    /*
	        		    $args_commission = array(
	        		        'in_action' => array('BUY'),
	        		        'status' => 1,
	        		        //'user_id' => $user_id,
	        		        'start_date_start' => $start_date,
	        		        'start_date_end' => $end_date,
	        		    );
	        		    if (!$is_admin) {
							$args_commission['user_id'] = $user_id;
						}
	        		    $balance = (int) $this->M_users_commission->get_total($args_commission);
	        		    */

	        		    $args_output_voucher = array(
	        		        'deleted' => 0,
	        		        'status' => 1,
	        		        'start_date_start' => $start_date,
	        		        'start_date_end' => $end_date,
	        		    );
	        		    if (!$is_admin) {
							$args_output_voucher['created_by'] = $user_id;
						}
	        		    $balance = (int) $this->M_output_voucher->get_monetized($args_output_voucher);
	        		    $chart[] = $balance;
	        		    if($max < $balance){
	        		    	$max = $balance;
	        		    }
	        		}
	        		$charts[$year] = $chart;
	        	}
	        }
			array_walk($months, function(&$value, $key) {
				$value = 'Tháng ' . $value;
			});
			/*
			$months = array_map(function($value) {
				return 'Tháng ' . $value;
			}, $months);
			*/
	        $this->_data['max'] = $max;
	        $this->_data['months'] = $months;
	        $this->_data['charts'] = $charts;

		    //top 10 sp ban nhieu nhat thang nay
		    $time = time();
		    $month_start = strtotime('first day of this month', $time);
		    $month_end = strtotime('last day of this month', $time);
		    $start_date = get_start_date(date('Y-m-d', $month_start));
		    $end_date = get_end_date(date('Y-m-d', $month_end));
		    // echo date('Y-m-d H:i:s', $start_date);
		    // echo "<br>" . date('Y-m-d H:i:s', $end_date);
		    // die;
	        $args_products_bestseller = array(
	        	'not_name' => '',
	        	'deleted' => 0,
	        	'status' => 1,
	        	'start_date_start' => $start_date,
	        	'start_date_end' => $end_date,
	        );
	        $products_bestseller = $this->M_output_voucher_details->get_products_bestseller($args_products_bestseller, 10, 0);
	        // echo "<pre>";
	        // print_r($products_bestseller);
	        // echo "</pre>";
	        // die();
	        $this->_data['products_bestseller'] = $products_bestseller;

			$_breadcrumbs_admin[] = array(
				'url' => '',
				'name' => 'Bảng điều khiển',
				'image' => base_url('assets/Frest/app-assets/images/svg/ico/ico-dashboard.svg'),
			);
			$this->set_breadcrumbs_admin();

			$this->_data['breadcrumbs_module_name'] = 'Bảng điều khiển';
			$this->_data['title'] = 'Bảng điều khiển - ' . $this->_data['title'];
			$this->_data['main_content'] = 'dashboard/view_page_index';
			$this->load->view('layout/admin/view_layout', $this->_data);
		} else {
			$post = $this->input->post();
			if (!empty($post)) {
				$this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');
				$this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required');
                $this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required');
                if ($this->form_validation->run($this)) {
                	if ($this->validate_login()) {
                		/*
                		$session_data = NULL;
                		if ($this->session->has_userdata('logged_in')) {
                			$session_data = $this->session->userdata('logged_in');
                		}
                		if ($this->session->has_userdata('logged_in_by')) {
                			$session_data = $this->session->userdata('logged_in_by');
                		}
                		$user_id = isset($session_data['userid']) ? $session_data['userid'] : 0;
                		$data_activities = array(
                			'user_id' => $user_id,
                			'activity' => 'Người dùng đăng nhập hệ thống thành công!',
                			'ip' => $this->input->ip_address(),
                			'status' => 1,
                			'created' => time(),
                		);
                		$this->M_users_activities->add($data_activities);
                		*/
                		add_activity('Người dùng đăng nhập hệ thống');
                		redirect(base_url());
					}else{
						$notify_type = 'danger';
						$notify_content = 'Tên đăng nhập hoặc mật khẩu chưa đúng!';
						$this->set_notify_admin($notify_type, $notify_content);
					}
				}
			}
			$this->load->view('users/admin/view_page_admin_login', $this->_data);
		}
	}

	function index_admin() {
		$this->load->module('users');
		$this->users->admin_index();
	}

	function ajax_admin_read_number_to_text() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$message = array();
		$message['status'] = 'warning';
		$message['content'] = null;
		$message['message'] = 'Kiểm tra thông tin';

		$post = $this->input->post();
		if (!empty($post)) {
			$number = (float) $this->input->post('number');
			$message['status'] = 'success';
			$message['content'] = ''; //read_number_to_text($number);
			$message['message'] = 'Tải dữ liệu thành công!';
		}
		echo json_encode($message);
		exit();
	}

	protected function set_breadcrumbs_admin() {
		$this->_data['breadcrumbs_admin'] = $this->_breadcrumbs_admin;
	}

	protected function set_plugins() {
		$this->_data['plugins_css'] = $this->_plugins_css;
		$this->_data['plugins_script'] = $this->_plugins_script;
	}

	protected function set_plugins_admin() {
		$this->_data['plugins_css_admin'] = $this->_plugins_css_admin;
		$this->_data['plugins_script_admin'] = $this->_plugins_script_admin;
	}

	protected function set_custom_all_admin() {
		$this->_data['all_css_admin'] = $this->_all_css_admin;
		$this->_data['all_script_admin'] = $this->_all_script_admin;
	}

	protected function set_vendor_admin() {
		$this->_data['vendor_css_admin'] = $this->_vendor_css_admin;
		$this->_data['vendor_script_admin'] = $this->_vendor_script_admin;
	}

	protected function set_modules() {
		$this->_data['modules_css'] = $this->_modules_css;
		$this->_data['modules_script'] = $this->_modules_script;
	}

	protected function set_any() {
		$this->_data['any_css'] = $this->_any_css;
	}

	protected function get_configs() {
		$configs = $this->M_configs->get_configs();
		return $this->set_configs($configs);
	}

	private function set_configs($data) {
		$configs = array();
		if(is_array($data) && !empty($data)){
			$configs = array_column($data, 'config_value', 'config_name');
			// foreach ($data as $value) {
			// 	$configs[$value['config_name']] = $value['config_value'];
			// }
		}
		return $configs;
	}

	protected function is_admin() {
		if ($this->session->has_userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			if(isset($session_data['role']) && $session_data['role'] == 'ADMIN'){
				return TRUE;
			}
		}
		return FALSE;
	}

	protected function logged_in() {
		if ($this->session->userdata('logged_in') || $this->session->userdata('logged_in_by')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	protected function redirect_admin() {
		if (!$this->logged_in()) {
			redirect(base_url());
		}
	}

	protected function validate_access_role($role_group = '') {
		$this->redirect_admin();
		redirect_validate_access_role($this->_data['role'], $role_group);
	}

	protected function access_role() {
		$this->load->model('users/m_groups_users', 'M_groups_users');
		$userid = isset($this->_data['userid']) ? $this->_data['userid'] : 0;
		$result = $this->M_groups_users->get_group_id($userid);
		return isset($result['group_id']) ? (int) $result['group_id'] : 2;
	}

	protected function set_notify($notify_type, $notify_content) {
		//set notify
		$sess_array = array(
			'notify_type' => $notify_type,
			'notify_content' => $notify_content,
		);
		$this->session->set_userdata('notify_current', $sess_array);
	}

	protected function set_notify_admin($notify_type, $notify_content) {
		//set notify
		$sess_array = array(
			'notify_type' => $notify_type,
			'notify_content' => $notify_content,
		);
		$this->session->set_userdata('notify_current_admin', $sess_array);
	}

	protected function set_message_success() {
		$sess_array = array(
			'notify_type' => 'success',
			'notify_content' => $this->_message_success,
		);
		$this->session->set_userdata('notify_current_admin', $sess_array);
	}

	protected function set_message_warning() {
		$sess_array = array(
			'notify_type' => 'warning',
			'notify_content' => $this->_message_warning,
		);
		$this->session->set_userdata('notify_current_admin', $sess_array);
	}

	protected function set_message_danger() {
		$sess_array = array(
			'notify_type' => 'danger',
			'notify_content' => $this->_message_danger,
		);
		$this->session->set_userdata('notify_current_admin', $sess_array);
	}

	protected function set_message_banned() {
		$sess_array = array(
			'notify_type' => 'danger',
			'notify_content' => $this->_message_banned,
		);
		$this->session->set_userdata('notify_current_admin', $sess_array);
	}

	protected function set_json_encode() {
		$this->_data['json_encode'] = array(
			'status' => $this->_status,
			'message' => $this->_message,
			'content' => $this->_content,
		);
	}

	function get_alias() {
		$str = $this->input->post('title');
		$this->_data['str'] = $str;
		$this->load->view('layout/admin/view_alias', $this->_data);
	}

	protected function show_message() {
		$this->_data['box'] = array(
			'status' => $this->input->post('status'),
			'message' => $this->input->post('message'),
		);
		$this->load->view('layout/message', $this->_data);
	}

	function load_language() {
		$this->load->helper('language');
		$this->lang->load('admin', $this->language);
		$this->lang->load('site', $this->language);
	}

	function set_current_url($url) {
		$this->session->set_userdata('url', base64_encode($url));
	}

	function redirect_after() {
		if ($this->session->userdata('url')) {
			$url = base64_decode($this->session->userdata('url'));
			$this->session->unset_userdata('url');
		} else {
			$url = base_url();
		}
		redirect($url);
	}

}

/* End of file Layout.php */
/* Location: ./application/modules/layout/controllers/Layout.php */
