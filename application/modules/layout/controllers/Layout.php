<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
class Layout extends MX_Controller {
	protected $_data = array();
	protected $_status = '';
	protected $_message = '';
	protected $_message_success = '';
	protected $_message_warning = '';
	protected $_message_danger = 'Rất tiếc! Có lỗi kỹ thuật!';
	protected $_message_banned = 'Không có quyền truy cập vào khu vực này!';
	protected $_breadcrumbs = array();
	protected $_breadcrumbs_admin = array();
	protected $_add_css = array();
	protected $_add_js = array();
	protected $_plugins_css = array();
	protected $_plugins_script = array();
	protected $_plugins_css_admin = array();
	protected $_plugins_script_admin = array();
	protected $_modules_css = array();
	protected $_modules_script = array();

	function __construct() {
		parent::__construct();
	}

	public function _initialize_global($configs) {
		$this->config->set_item('url_posts_cat', modules::run('menu/menu_type/get_values_type', 'post_categories'));
		$this->config->set_item('url_posts_rows', modules::run('menu/menu_type/get_values_type', 'posts'));
		$this->config->set_item('url_contact', modules::run('menu/menu_type/get_values_type', 'contact'));
		$this->config->set_item('url_shops_cat', modules::run('menu/menu_type/get_values_type', 'categories'));
		$this->config->set_item('url_shops_rows', modules::run('menu/menu_type/get_values_type', 'products'));

		$parse = parse_url(base_url());
		$this->_data['host'] = $parse['host'];

		$this->_data['site_name'] = $configs['site_name'];
		$this->_data['title'] = $configs['site_name'];
		$this->_data['title_seo'] = $configs['title_seo'];
		$this->_data['other_seo'] = $configs['other_seo'];
		$this->_data['h1_seo'] = $configs['h1_seo'];
		$this->_data['h2_seo'] = $configs['h2_seo'];
		$this->_data['description'] = $configs['site_description'];
		$this->_data['keywords'] = $configs['site_keywords'];
		$this->_data['site_icon'] = $configs['site_icon'];
		$this->_data['email'] = $configs['site_email'];
	}

	public function _initialize_user() {
		$this->_data['logged_in'] = FALSE;
		if ($this->session->has_userdata('logged_in')) {
			$this->_data['logged_in'] = TRUE;
			$session_data = $this->session->userdata('logged_in');
			$this->_data['userid'] = $session_data['userid'];
			$this->_data['username'] = $session_data['username'];
			$this->_data['full_name'] = $session_data['full_name'];
			$this->_data['photo'] = $session_data['photo'];
			$this->_data['regdate'] = isset($session_data['regdate']) ? $session_data['regdate'] : '';
		}
	}

	public function _initialize() {
		$configs = $this->get_configs();
		$this->_initialize_global($configs);

		$shops_cat = modules::run('shops/cat/gets');
		$this->_data['shops_cat_list'] = $shops_cat['data_list']; //mang chua quan he cha con
		$this->_data['shops_cat_data'] = $shops_cat['data_input']; // mang chua du lieu tat ca cat (có link)
		$this->_data['shops_cat_input'] = $shops_cat['data_input']; // mang chua du lieu tat ca cat (không link chi co gia tri va ten de dung cho input)

		$this->_data['postcat_list'] = modules::run('posts/postcat/get_menu_list');
		$this->_data['postcat_data'] = modules::run('posts/postcat/get_data');
		$this->_data['postcat_input'] = modules::run('posts/postcat/get_input');

		$main = 'Main';
		$this->_data['menu_main_list'] = modules::run('menu/get_menu_list', $main);
		$this->_data['menu_main_data'] = modules::run('menu/get_data', $main);
		$this->_data['menu_main_input'] = modules::run('menu/get_input', $main);

		$bottom = 'Bottom';
		$this->_data['menu_bottom_list'] = modules::run('menu/get_menu_list', $bottom);
		$this->_data['menu_bottom_data'] = modules::run('menu/get_data', $bottom);
		$this->_data['menu_bottom_input'] = modules::run('menu/get_input', $bottom);

		$introdue = 'Introdue';
		$this->_data['menu_introdue_list'] = modules::run('menu/get_menu_list', $introdue);
		$this->_data['menu_introdue_data'] = modules::run('menu/get_data', $introdue);
		$this->_data['menu_introdue_input'] = modules::run('menu/get_input', $introdue);

		$this->_breadcrumbs[] = array(
			'url' => base_url(),
			'name' => 'Trang chủ',
		);
		$this->set_breadcrumbs();

		$this->_data['site_image'] = $configs['site_image'];
		$this->_data['image'] = base_url(get_module_path('logo') . $this->_data['site_image']);
		$this->_data['analytics_UA_code'] = $configs['analytics_UA_code'];
		$this->_data['display_copyright_developer'] = $configs['display_copyright_developer'];

		$this->_data['site_hotline'] = $configs['site_hotline'];
		$this->_data['site_address'] = $configs['site_address'];
		$this->_data['site_phone'] = $configs['site_phone'];

		$this->_data['favicon'] = $configs['favicon'];
		$this->_data['site_logo'] = $configs['site_logo'];
		$this->_data['site_logo_footer'] = $configs['site_logo_footer'];

		$this->_data['fb_page'] = $configs['fb_page'];
		$this->_data['iframe_map'] = $configs['iframe_map'];
		$this->_data['site_content_contact'] = $configs['site_content_contact'];
		$this->_data['iframe_video'] = $configs['iframe_video'];

		$this->_data['facebook_fanpage'] = $configs['facebook_fanpage'];
		$this->_data['google_plus'] = $configs['google_plus'];
		$this->_data['youtube_page'] = $configs['youtube_page'];
		$this->_data['twitter_page'] = $configs['twitter_page'];
		$this->_data['skype_page'] = $configs['skype_page'];
		$this->_data['linkedin_page'] = $configs['linkedin_page'];

		$this->_load_menu_main();
		$this->_load_category_product();
		$this->_load_category_search();

		//search
		$this->_data['q'] = $this->input->get('q');

		$this->_modules_script[] = array(
			'folder' => 'shops',
			'name' => 'cart',
		);

		$this->_modules_script[] = array(
			'folder' => 'newsletter',
			'name' => 'newsletter',
		);

		$cat_shop_none = modules::run('images/get_images_position', 'cat_shop', 'none');
		$this->_data['cat_shop_none'] = $cat_shop_none;

		$baner_home_none = modules::run('images/get_images_position', 'baner_home', 'none');
		$this->_data['baner_home_none'] = $baner_home_none;

		//Avarta Member none
		$avarta_member_none = modules::run('images/get_images_position', 'avarta_member', 'none');
		$this->_data['avarta_member_none'] = $avarta_member_none;

		//OBM
		$obm_none = modules::run('images/get_images_position', 'obm', 'none');
		$this->_data['obm_none'] = $obm_none;

		//introdues none
		$introdues_none = modules::run('images/get_images_position', 'introdues', 'none');
		$this->_data['introdues_none'] = $introdues_none;

		// Activate Pages
		$activate_pages = modules::run('images/get_images_position', 'activate_pages', 'none');
		$this->_data['activate_pages'] = $activate_pages;

		//hotline
		$info_hotline_none = modules::run('info/get_info_position', 'hotline', 'none', TRUE);
		$this->_data['info_hotline_none'] = $info_hotline_none;

		//Welcome
		$info_name_company_none = modules::run('info/get_info_position', 'name_company', 'none', TRUE);
		$this->_data['info_name_company_none'] = $info_name_company_none;

		//Contact Map
		$info_contact_map_none = modules::run('info/get_info_position', 'contact_map', 'none', TRUE);
		$this->_data['info_contact_map_none'] = $info_contact_map_none;

		//Contact Footer
		$info_contact_footer_none = modules::run('info/get_info_position', 'contact_footer', 'none', TRUE);
		$this->_data['info_contact_footer_none'] = $info_contact_footer_none;

		//Hotline Header Top
		$info_hotline_header_none = modules::run('info/get_info_position', 'hotline_header', 'none', TRUE);
		$this->_data['info_hotline_header_none'] = $info_hotline_header_none;

		//Introdues
		$info_introdues_none = modules::run('info/get_info_position', 'introdues', 'none', TRUE);
		$this->_data['info_introdues_none'] = $info_introdues_none;

		//info
		$info_all_none = modules::run('info/get_info_position', 'all', 'none', TRUE);
		$this->_data['info_all_none'] = $info_all_none;

		//copyright
		$info_copyright_none = modules::run('info/get_info_position', 'copyright', 'none', TRUE);
		$this->_data['info_copyright_none'] = $info_copyright_none;

		//Contact
		$info_contact_none = modules::run('info/get_info_position', 'contact', 'none', TRUE);
		$this->_data['info_contact_none'] = $info_contact_none;

		//Address
		$info_address_none = modules::run('info/get_info_position', 'address', 'none', TRUE);
		$this->_data['info_address_none'] = $info_address_none;

		//TimeWork
		$info_timework_none = modules::run('info/get_info_position', 'timework', 'none', TRUE);
		$this->_data['info_timework_none'] = $info_timework_none;

		//Call Us
		$info_call_us_none = modules::run('info/get_info_position', 'call_us', 'none', TRUE);
		$this->_data['info_call_us_none'] = $info_call_us_none;

		//Certify
		$info_certify_none = modules::run('info/get_info_position', 'certify', 'none', TRUE);
		$this->_data['info_certify_none'] = $info_certify_none;

		//Partner
		$info_partner_none = modules::run('info/get_info_position', 'partner', 'none', TRUE);
		$this->_data['info_partner_none'] = $info_partner_none;

		//Address North
		$info_address_north_none = modules::run('info/get_info_position', 'address_north', 'none', TRUE);
		$this->_data['info_address_north_none'] = $info_address_north_none;

		//Address Central
		$info_address_central_none = modules::run('info/get_info_position', 'address_central', 'none', TRUE);
		$this->_data['info_address_central_none'] = $info_address_central_none;

		//Address South
		$info_address_south_none = modules::run('info/get_info_position', 'address_south', 'none', TRUE);
		$this->_data['info_address_south_none'] = $info_address_south_none;

		//Introdues
		$info_introdues_none = modules::run('info/get_info_position', 'introdues', 'none', TRUE);
		$this->_data['info_introdues_none'] = $info_introdues_none;

		//Bannerbottom
		$bannerbottom_none = modules::run('images/get_images_position', 'bannerbottom', 'none');
		$this->_data['bannerbottom_none'] = $bannerbottom_none;

		//Partner
		$partner_none = modules::run('images/get_images_position', 'partner', 'none');
		$this->_data['partner_none'] = $partner_none;

		//Service
		$service_none = modules::run('images/get_images_position', 'service', 'none');
		$this->_data['service_none'] = $service_none;

		//Advertise
		$advertise_none = modules::run('images/get_images_position', 'advertise', 'none');
		$this->_data['advertise_none'] = $advertise_none;

		//Support Online
		$support_online_none = modules::run('images/get_images_position', 'support_online', 'none');
		$this->_data['support_online_none'] = $support_online_none;

		//posts news
		$posts_news = modules::run('posts/gets_item_field', 'is_news', 0);
		$partial = array();
		$partial['data'] = $posts_news;
		$this->_data['posts_news'] = $this->load->view('layout/site/partial/post_news', $partial, true);

		//posts home
		// $posts_home = modules::run('posts/gets_item_field', 'inhome', 0);
		// $partial = array();
		// $partial['data'] = $posts_home;
		// $this->_data['posts_home'] = $this->load->view('layout/site/partial/post_home', $partial, true);

		//hotline none
		//$hotline_none = modules::run('images/get_images_position', 'hotline', 'none');
		//$this->_data['hotline_none'] = isset($hotline_none[0]) ? $hotline_none[0] : NULL;
		if (!is_home()) {
			//posts featured
			$posts_featured = modules::run('posts/gets_item_field', 'is_featured', 0);
			$partial = array();
			$partial['data'] = $posts_featured;
			$this->_data['posts_featured'] = $this->load->view('layout/site/partial/post_featured', $partial, true);

		}

		//set all css, js, plugins
		$this->add_css();
		$this->add_js();
		$this->set_plugins();
		$this->set_modules();
	}

	public function _initialize_admin() {
		$configs = $this->get_configs();
		$this->_initialize_global($configs);
		$this->_initialize_user();

		$this->_data['breadcrumbs_module_name'] = '';
		$this->_data['breadcrumbs_module_func'] = '';

		$this->_breadcrumbs_admin[] = array(
			'url' => '',
			'name' => '<i class="fa fa-dashboard"></i> Admin',
		);
		$this->set_breadcrumbs_admin();

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
		//set all css, js, plugins
		$this->set_plugins_admin();
		$this->set_modules();

		$this->_data['num_rows_contact'] = modules::run('contact/num_rows_new');
		$this->_data['num_rows_order'] = modules::run('shops/orders/num_rows_new');

		$this->_data['menu_admin_active'] = ($this->uri->segment(2) == '') ? '' : $this->uri->segment(2);
	}

	public function _load_category_product($parent = 0) {
		$data_category_product = modules::run('shops/cat/gets_data', array('parent' => $parent));
		$column = 3;
		$html_category_product = '';
		if (is_array($data_category_product) && !empty($data_category_product)) {
			foreach ($data_category_product as $key => $value) {
				$is_second = FALSE;
				$data_category_product_1 = modules::run('shops/cat/gets_data', array('parent' => $key));
				if (is_array($data_category_product_1) && !empty($data_category_product_1)) {
					$is_second = TRUE;
				}
				$html_category_product .= '<li><a' . ($is_second ? ' class="ipad-lans"' : '') . ' href="' . $value['lurl'] . '">' . $value['lname'] . ($is_second ? ' <i class="fa fa-angle-right" aria-hidden="true"></i>' : '') . '</a>';
				if ($is_second) {
					$count_data_category_product_1 = count($data_category_product_1);
					$items_row = floor($count_data_category_product_1 / $column); //so item it nhat tren mot co
					$items_residual = $count_data_category_product_1 % $column; //0,1 hoac 2
					if ($items_residual == 0) {
						$start = 0;
						$length = $items_row * 1;
						$data_category_product_1_1 = array_slice($data_category_product_1, $start, $length, TRUE);
						$start = $items_row * 1;
						$length = $items_row * 1;
						$data_category_product_1_2 = array_slice($data_category_product_1, $start, $length, TRUE);
						$start = $items_row * 2;
						$length = $count_data_category_product_1 - 1;
						$data_category_product_1_3 = array_slice($data_category_product_1, $start, $length, TRUE);
					} elseif ($items_residual == 1) {
						$start = 0;
						$length = $items_row * 1 + 1;
						$data_category_product_1_1 = array_slice($data_category_product_1, $start, $length, TRUE);
						$start = $items_row * 1 + 1;
						$length = $items_row * 1;
						$data_category_product_1_2 = array_slice($data_category_product_1, $start, $length, TRUE);
						$start = $items_row * 2 + 1;
						$length = $count_data_category_product_1 - 1;
						$data_category_product_1_3 = array_slice($data_category_product_1, $start, $length, TRUE);
					} else {
						$start = 0;
						$length = $items_row * 1 + 1;
						$data_category_product_1_1 = array_slice($data_category_product_1, $start, $length, TRUE);
						$start = $items_row * 1 + 1;
						$length = $items_row * 1 + 1;
						$data_category_product_1_2 = array_slice($data_category_product_1, $start, $length, TRUE);
						$start = $items_row * 2 + 2;
						$length = $count_data_category_product_1 - 1;
						$data_category_product_1_3 = array_slice($data_category_product_1, $start, $length, TRUE);
					}
					/*
						var_dump($items_row);
						var_dump($items_residual);
						var_dump($data_category_product_1);
						var_dump($data_category_product_1_1);
						var_dump($data_category_product_1_2);
						var_dump($data_category_product_1_3);
					*/
					$html_category_product .= '<div class="wsmenu-submenu-sub" id="scroll-bar">';
					if (is_array($data_category_product_1_1) && !empty($data_category_product_1_1)) {
						$html_category_product .= '<ul class="col-lg-3 col-sm-3 link-list">';
						foreach ($data_category_product_1_1 as $key1 => $value1) {
							$html_category_product .= '<li><a href="' . $value1['lurl'] . '"><i class="fa fa-square"></i>' . $value1['lname'] . '</a></li>';
						}
						$html_category_product .= '</ul>';
					}
					if (is_array($data_category_product_1_2) && !empty($data_category_product_1_2)) {
						$html_category_product .= '<ul class="col-lg-3 col-sm-3 link-list">';
						foreach ($data_category_product_1_2 as $key1 => $value1) {
							$html_category_product .= '<li><a href="' . $value1['lurl'] . '"><i class="fa fa-square"></i>' . $value1['lname'] . '</a></li>';
						}
						$html_category_product .= '</ul>';
					}
					if (is_array($data_category_product_1_3) && !empty($data_category_product_1_3)) {
						$html_category_product .= '<ul class="col-lg-3 col-sm-3 link-list">';
						foreach ($data_category_product_1_3 as $key1 => $value1) {
							$html_category_product .= '<li><a href="' . $value1['lurl'] . '"><i class="fa fa-square"></i>' . $value1['lname'] . '</a></li>';
						}
						$html_category_product .= '</ul>';
					}
					$html_category_product .= '</div>';
				}
				$html_category_product .= "</li>";
			}
		}
		$this->_data['html_category_product'] = $html_category_product;
		//var_dump($html_category_product); die;
	}

	public function _load_category_search() {
		$search_param = 'all';
		$get = $this->input->get();
		if (isset($get['search_param']) && $get['search_param'] != 'all') {
			$search_param = $get['search_param'];
		}
		$data_category_search = modules::run('shops/cat/gets_data', array('parent' => 0));
		$html_category_search = '';
		if (is_array($data_category_search) && !empty($data_category_search)) {
			foreach ($data_category_search as $key => $value) {
				$html_category_search .= '<li><a href="#' . $value['lid'] . '">' . $value['lname'] . '</a></li>';
			}
		}
		$this->_data['html_category_search'] = $html_category_search;
	}

	function _load_menu_main() {
		$main = 'Main';
		$data_menu_main = modules::run('menu/gets', $main, 0);
		$html_menu_main = '';
		if (is_array($data_menu_main) && !empty($data_menu_main)) {
			foreach ($data_menu_main as $key => $value) {
				$html_menu_main .= "<li><a" . ($value['lurl'] == current_url() ? " class=\"active\"" : '') . " href=\"" . $value['lurl'] . "\">" . $value['lname'] . "</a></li>";
			}
		}

		/*
			$main = 'Main';
			$data_menu_main = modules::run('menu/gets', $main, 0);
			$html_menu_main = '';
			$html_menu_main_mobile = '';
			if (is_array($data_menu_main) && !empty($data_menu_main)) {
				foreach ($data_menu_main as $key => $value) {
					$is_second = FALSE;
					$data_menu_main_1 = modules::run('menu/gets', $main, $key);
					if (is_array($data_menu_main_1) && !empty($data_menu_main_1)) {
						$is_second = TRUE;
					}
					$html_menu_main .= '<li class="menu-item' . (($value['lurl'] == current_url()) ? ' active' : '') . ($is_second ? ' menu-item-has-children has-sub narrow' : '') . '"><a href="' . $value['lurl'] . '"' . (($value['lurl'] == current_url()) ? ' class="current"' : ''). '>' . $value['lname'] . '</a>';
					$html_menu_main_mobile .= '<li class="menu-item' . (($value['lurl'] == current_url()) ? ' active' : '') . ($is_second ? ' menu-item-has-children has-sub' : '') . '"><a href="' . $value['lurl'] . '">' . $value['lname'] . '</a>';
					if ($is_second) {
						$html_menu_main .= '<div class="popup">';
							$html_menu_main .= '<div class="inner">';
								$html_menu_main .= '<ul class="sub-menu">';

						$html_menu_main_mobile .= '<span class="arrow"></span>';
						$html_menu_main_mobile .= '<ul class="sub-menu">';
						foreach ($data_menu_main_1 as $key1 => $value1) {
							$is_third = FALSE;
							$data_menu_main_2 = modules::run('menu/gets', $main, $key1);
							if (is_array($data_menu_main_2) && !empty($data_menu_main_2)) {
								$is_third = TRUE;
							}
							$html_menu_main .= '<li class="menu-item' . ($is_third ? ' menu-item-has-children' : '') . '"><a href="' . $value1['lurl'] . '">' . $value1['lname'] . '</a>';

							$html_menu_main_mobile .= '<li class="menu-item"><a href="' . $value1['lurl'] . '">' . $value1['lname'] . '</a>';

							if ($is_third) {
								$html_menu_main .= '<ul class="sub-menu">';

								$html_menu_main_mobile .= '<span class="arrow"></span>';
								$html_menu_main_mobile .= '<ul class="sub-menu">';
								foreach ($data_menu_main_2 as $value2) {
									$html_menu_main .= '<li class="menu-item"><a href="' . $value2['lurl'] . '">' . $value2['lname'] . '</a></li>';
									$html_menu_main_mobile .= '<li class="menu-item"><a href="' . $value2['lurl'] . '">' . $value2['lname'] . '</a></li>';
								}
								$html_menu_main .= '</ul>';

								$html_menu_main_mobile .= '</ul>';
							}
							$html_menu_main .= '</li>';
							$html_menu_main_mobile .= '</li>';
						}
								$html_menu_main .= '</ul>';
							$html_menu_main .= '</div>';
						$html_menu_main .= '</div>';
						$html_menu_main_mobile .= '</ul>';
					}
					$html_menu_main .= "</li>";
					$html_menu_main_mobile .= "</li>";
				}
			}
		*/
		$this->_data['html_menu_main'] = $html_menu_main;
	}

	function _init_fancybox() {
		$this->_plugins_css_admin[] = array(
			'folder' => 'fancy-box/source',
			'name' => 'jquery.fancybox',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'fancy-box/source',
			'name' => 'jquery.fancybox',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'fancy-box/source',
			'name' => 'jquery.fancybox.pack',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'fancy-box/lib',
			'name' => 'jquery.mousewheel-3.0.6.pack',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'fancy-box',
			'name' => 'jquery-apps',
		);
		$this->set_plugins_admin();
	}

	function index_admin() {
		$this->load->module('users');
		$this->users->admin_index();
	}

	protected function set_breadcrumbs() {
		$this->_data['breadcrumbs'] = $this->_breadcrumbs;
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

	protected function set_modules() {
		$this->_data['modules_css'] = $this->_modules_css;
		$this->_data['modules_script'] = $this->_modules_script;
	}

	protected function add_css() {
		$this->_data['add_css'] = $this->_add_css;
	}

	protected function add_js() {
		$this->_data['add_js'] = $this->_add_js;
	}

	protected function get_configs() {
		$configs = $this->M_configs->get_configs();
		return $this->set_configs($configs);
	}

	private function set_configs($data) {
		$configs = array();
		if (is_array($data) && !empty($data)) {
			foreach ($data as $value) {
				$configs[$value['config_name']] = $value['config_value'];
			}
		}
		return $configs;
	}

	function index() {
		$this->_initialize();

		//slideshow none
		$slideshow_none = modules::run('images/get_images_position', 'slideshow', 'none');
		$this->_data['slideshow_none'] = $slideshow_none;

		//slideshow store none
		$slideshow_store_none = modules::run('images/get_images_position', 'slideshow_store', 'none');
		$this->_data['slideshow_store_none'] = $slideshow_store_none;

		//research none
		$research_none = modules::run('images/get_images_position', 'research', 'none');
		$this->_data['research_none'] = $research_none;

		//brands none
		$brands_none = modules::run('images/get_images_position', 'brands', 'none');
		$this->_data['brands_none'] = $brands_none;

		//postcat home
		$postcat_home = modules::run('posts/postcat/gets_inhome', 0);
		if (is_array($postcat_home) && !empty($postcat_home)) {
			foreach ($postcat_home as $key => $value) {
				$postcat_home[$key]['items'] = modules::run('posts/get_items_in_cat_id', $value['id'], 0);
			}
		}
		$partial = array();
		$partial['data'] = $postcat_home;
		$this->_data['postcat_home'] = $this->load->view('layout/site/partial/postcat_home', $partial, true);

		$products_home = modules::run('shops/cat/gets_inhome', 0);
		$partial = array();
		$partial['data'] = $products_home;
		$this->_data['products_home'] = $this->load->view('layout/site/partial/product_home', $partial, true);

		$this->_data['main_content'] = 'layout/site/pages/main';
		$this->load->view('site/layout', $this->_data);
	}

	protected function logged_in() {
		if ($this->session->userdata('logged_in')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	protected function redirect_register() {
		if (!$this->logged_in()) {
			redirect(site_url('register'));
		}
	}

	protected function redirect_login() {
		if (!$this->logged_in()) {
			redirect(site_url('login'));
		}
	}

	protected function redirect_admin() {
		if (!$this->session->userdata('logged_in')) {
			redirect(get_admin_url());
		} else {
			$access_role = $this->access_role();
			if ($access_role < 4) {
				redirect(base_url());
			}
		}
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

/* End of file layout.php */
/* Location: ./application/modules/layout/controllers/layout.php */
