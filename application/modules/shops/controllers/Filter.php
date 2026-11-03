<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Filter extends Layout {

	private $_module_slug = 'shops/filter';

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('shops/m_shops_filter', 'M_shops_filter');
		$this->_data['module_slug'] = $this->_module_slug;
		$this->_data['breadcrumbs_module_name'] = 'Loại sản phẩm';
	}

	function ajax_get() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = 'Kiểm tra thông tin nhập';

        $post = $this->input->post();
        if (!empty($post)) {
            $id = $this->input->post('id');
            $row = modules::run('shops/cat/get', $id);
			$cat_filter = explode(',', $row['filter']);
			$in_filter_id = array(-1);
			if(is_array($cat_filter) && !empty($cat_filter)){
				$in_filter_id = $cat_filter;
			}
			$args_filter = array('in_id' => $in_filter_id);
			$filter = modules::run('shops/filter/gets', $args_filter);
			$message['status'] = 'success';
			$message['content'] = display_option_select($filter, 'id', 'name', 0);
			$message['message'] = 'Đã xử lý dữ liệu thành công!';
        }
        echo json_encode($message);
        exit();
    }

	function default_args() {
		$order_by = array(
			'order' => 'DESC',
			'name' => 'ASC',
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
		return $this->M_shops_filter->counts($args);
	}

	function gets($options = array()) {
		$default_args = $this->default_args();

		if (is_array($options) && !empty($options)) {
			$args = array_merge($default_args, $options);
		} else {
			$args = $default_args;
		}

		return $this->M_shops_filter->gets($args);
	}

	function get($id) {
		return $this->M_shops_filter->get($id);
	}

	function get_max_order() {
		$args = $this->default_args();
		$order_by = array(
			'order' => 'DESC',
		);
		$args['order_by'] = $order_by;
		$rows = $this->M_shops_filter->gets($args);
		$max_order = isset($rows[0]['order']) ? $rows[0]['order'] : 0;

		return (int) $max_order;
	}

	function re_order() {
		$args = $this->default_args();
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
				$this->M_shops_filter->update($value['id'], $data);
			}
		}
	}

	function site_details() {
		$this->_initialize();

        $segment = 3;
        $uri = explode("-", ($this->uri->segment($segment) == '') ? '' : $this->uri->segment($segment));
        if (count($uri) <= 1) {
            show_404();
        }
        $id = (int) end($uri);
        array_pop($uri);
        $alias = implode("-", $uri);
        if ($id == 0 || $alias == '') {
            show_404();
        }
        $row = $this->get($id);

        if (!empty($row)) {
            $title_seo = trim($row['title_seo']) != '' ? $row['title_seo'] : $row['title'];
            $keywords = $row['keywords'];
            $description = $row['description'];
            $other_seo = $row['other_seo'];
            $h1_seo = $row['h1_seo'];
            if (trim($title_seo) != '') {
                $this->_data['title_seo'] = $title_seo . ' - ' . $this->_data['title_seo'];
            }
            if (trim($keywords) != '') {
                $this->_data['keywords'] = $keywords;
            }
            if (trim($description) != '') {
                $this->_data['description'] = $description;
            }
            if (trim($other_seo) != '') {
                $this->_data['other_seo'] = $other_seo;
            }
            if (trim($h1_seo) != '') {
                $this->_data['h1_seo'] = $h1_seo;
            }
        } else {
            show_404();
        }
        $this->_data['row'] = $row;

        $this->_breadcrumbs[] = array(
            'url' => current_url(),
            'name' => $row['name']
        );
        $this->set_breadcrumbs();

        $this->_data['main_content'] = 'layout/site/pages/filter-shops';
        $this->load->view('layout/site/layout', $this->_data);
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
			'folder' => 'shops',
			'name' => 'admin-filter-items',
		);
		$this->set_modules();

		$get = $this->input->get();
		$this->_data['get'] = $get;

		$args = $this->default_args();
		$args['deleted'] = 0;

		if (isset($get['q']) && trim($get['q']) != '') {
			$args['q'] = $get['q'];
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

		$this->_data['rows'] = $this->M_shops_filter->gets($args, $perpage, $offset);
		$this->_data['pagination'] = $pagination;

		$this->_data['title'] = 'Danh sách loại sản phẩm - ' . $this->_data['title'];
		$this->_data['main_content'] = 'shops/admin/view_page_filter_index';
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

		$this->_plugins_css_admin[] = array(
			'folder' => 'bootstrap-fileinput/css',
			'name' => 'fileinput',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'bootstrap-fileinput/js',
			'name' => 'fileinput.min',
		);

		$this->set_plugins_admin();

		$this->_modules_script[] = array(
			'folder' => 'shops',
			'name' => 'admin-filter-validate',
		);
		$this->set_modules();

		$post = $this->input->post();
		if (!empty($post)) {
			$this->load->helper('language');
			$this->lang->load('form_validation', 'vietnamese');

			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('name', 'Nhập tên loại sản phẩm', 'trim|required|xss_clean');

			if ($this->form_validation->run($this)) {
				if ($this->input->post('id')) {
					//update
					$err = FALSE;
					$id = $this->input->post('id');
					if (!$this->admin_update($id)) {
						$err = TRUE;
					}

					if ($err === FALSE) {
						$notify_type = 'success';
						$notify_content = 'Cập nhật thông tin thành công!';
						$this->set_notify_admin($notify_type, $notify_content);

						redirect(get_admin_url($this->_module_slug));
					} else {
						$notify_type = 'danger';
						$notify_content = 'Có lỗi xảy ra!';
						$this->set_notify_admin($notify_type, $notify_content);
					}
				} else {
					//add
					$err = FALSE;
					$insert_id = $this->admin_add();
					if ($insert_id == 0) {
						$err = TRUE;
					}

					if ($err === FALSE) {
						$notify_type = 'success';
						$notify_content = 'Thông tin đã được thêm!';
						$this->set_notify_admin($notify_type, $notify_content);

						redirect(get_admin_url($this->_module_slug));
					} else {
						$notify_type = 'danger';
						$notify_content = 'Có lỗi xảy ra!';
						$this->set_notify_admin($notify_type, $notify_content);
					}
				}
			}
		}
		$this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => base_url() . "ckeditor/", 'outPut' => true));

		$title = 'Thêm thông tin - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
		$segment = 5;
		$id = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
		if ($id != 0) {
			$row = $this->get($id);
			$this->_data['row'] = $row;
			$title = 'Cập nhật thông tin - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
		}

		$this->_data['title'] = $title;
		$this->_data['main_content'] = 'shops/admin/view_page_filter_content';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_main() {
		$this->_initialize_admin();
		$this->redirect_admin();
		$post = $this->input->post();
		if (!empty($post)) {
			$action = $this->input->post('action');
			if ($action == 'update') {
				$this->_message_success = 'Đã cập nhật loại sản phẩm!';
				$this->_message_warning = 'Không có loại sản phẩm nào để cập nhật!';
				$ids = $this->input->post('ids');
				$orders = $this->input->post('order');
				$count = count($orders);
				if (!empty($ids) && !empty($orders)) {
					for ($i = 0; $i < $count; $i++) {
						$data = array(
							'order' => $orders[$i],
						);
						$id = $ids[$i];
						if ($this->M_shops_filter->update($id, $data)) {
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
			} elseif ($action == 'delete') {
				$this->_message_success = 'Đã xóa các loại sản phẩm được chọn!';
				$this->_message_warning = 'Bạn chưa chọn loại sản phẩm nào!';
				$ids = $this->input->post('idcheck');

				if (is_array($ids) && !empty($ids)) {
					foreach ($ids as $id) {
						$row = $this->get($id);
						if (!empty($row) && $this->M_shops_filter->delete($id)) {
							$notify_type = 'success';
							$notify_content = $this->_message_success;
						} else {
							$notify_type = 'danger';
							$notify_content = $this->_message_danger;
						}
					}
					$this->re_order();
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

	function admin_add() {
		$data = array(
			'name' => $this->input->post('name'),
			'alias' => $this->input->post('alias'),
			'content' => $this->input->post('content'),
			'title_seo' => $this->input->post('title_seo'),
            'description' => $this->input->post('description'),
            'keywords' => $this->input->post('keywords'),
            'other_seo' => $this->input->post('other_seo'),
            'h1_seo' => $this->input->post('h1_seo'),
			'order' => $this->get_max_order() + 1,
			'status' => 1,
			'created' => time(),
			'modified' => 0,
		);

		return $this->M_shops_filter->add($data);
	}

	function admin_update($id) {
		$data = array(
			'name' => $this->input->post('name'),
			'alias' => $this->input->post('alias'),
			'content' => $this->input->post('content'),
			'title_seo' => $this->input->post('title_seo'),
            'description' => $this->input->post('description'),
            'keywords' => $this->input->post('keywords'),
            'other_seo' => $this->input->post('other_seo'),
            'h1_seo' => $this->input->post('h1_seo'),
			'modified' => time(),
		);
		return $this->M_shops_filter->update($id, $data);
	}

	function admin_delete() {
		$this->_initialize_admin();
		$this->redirect_admin();

		$this->_message_success = 'Đã xóa thông tin!';
		$this->_message_warning = 'Thông tin này không tồn tại!';
		$id = $this->input->get('id');
		if ($id != 0) {
			if ($this->M_shops_filter->delete($id)) {
				$this->re_order();
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

/* End of file Filter.php */
/* Location: ./application/modules/shops/controllers/Filter.php */
