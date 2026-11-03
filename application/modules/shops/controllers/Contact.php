<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Contact extends Layout {
    private $_module_slug = 'shops/contact';

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->_data['module_slug'] = $this->_module_slug;
        $this->load->model('shops/m_shops_contact', 'M_shops_contact');
        $this->_data['breadcrumbs_module_name'] = 'Liên hệ';
    }

    function default_args() {
        $order_by = array(
            'is_view' => 'ASC',
            'add_time' => 'DESC',
        );
        $args = array();
        $args['order_by'] = $order_by;

        return $args;
    }

    function gets($args) {
        $this->load->model('shops/m_shops_contact', 'M_shops_contact');
        return $this->M_shops_contact->gets($args);
    }

    function counts($args) {
        $this->load->model('shops/m_shops_contact', 'M_shops_contact');
        return $this->M_shops_contact->counts($args);
    }

    function get($id) {
        $this->load->model('shops/m_shops_contact', 'M_shops_contact');
        return $this->M_shops_contact->get($id);
    }

    function index_ajax() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		$message = array();
		$message['status'] = 'warning';
		$message['content'] = null;
		$message['message'] = 'Kiểm tra thông tin nhập!';

        $post = $this->input->post();
        if (!empty($post)) {
            $this->form_validation->set_rules('full_name', 'Họ tên', 'trim|required|max_length[60]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[60]');

            if ($this->form_validation->run($this)) {
                $product_id = $this->input->post('product_id');
				$row = modules::run('shops/rows/get', $product_id);

                $data['product_id'] = $product_id;
                $data['full_name'] = $this->input->post('full_name');
                $data['email'] = $this->input->post('email');
                $data['phone'] = $this->input->post('phone');
                $data['subject'] = $this->input->post('subject');
                $data['message'] = $this->input->post('message');
                $data['add_time'] = time();
                $data['is_view'] = 0;
                $data['view_time'] = 0;

                if ($this->M_shops_contact->add($data)) {
                    $this->_initialize();
					$data['site_name'] = $this->_data['site_name'];
					$data['message'] = $this->load->view('layout/site/partial/html-template-contact-product', array('data' => $data), true);
                    $data_sendmail = array(
                        'sender_email' => $data['email'],
                        'sender_name' => $data['full_name'] . ' - ' . $data['email'],
                        'receiver_email' => array($this->_data['email'], $data['email']), //mail nhan thư
                        'subject' => 'Liên hệ',
                        'message' => $data['message']
                    );
                    modules::run('emails/send_mail', $data_sendmail);

                    $message['status'] = 'success';
					$message['content'] = $data;
					$message['message'] = 'Cám ơn bạn đã gửi liên hệ tới chúng tôi!';
                } else {
					$message['status'] = 'error';
					$message['content'] = null;
					$message['message'] = 'Liên hệ chưa được gửi! Vui lòng thực hiện lại!';
                }
            } else {
				$message['status'] = 'error';
				$message['content'] = null;
				$message['message'] = 'Dữ liệu không hợp lệ! Vui lòng nhập lại dữ liệu thực hiện lại!';
			}
        }
        echo json_encode($message);
		exit();
    }

    function admin_main() {
        $this->_initialize_admin();
        $this->redirect_admin();

        $post = $this->input->post();
        if (!empty($post)) {
            $action = $this->input->post('action');
            if ($action == 'delete') {
                $this->_message_success = 'Đã xóa các liên hệ được chọn!';
                $this->_message_warning = 'Bạn chưa chọn liên hệ nào!';
                $ids = $this->input->post('idcheck');
                if (is_array($ids) && !empty($ids)) {
                    foreach ($ids as $id) {
                        if ($this->M_shops_contact->delete($id)) {
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
            } else{
                redirect(get_admin_url($this->_module_slug));
            }
        } else {
            redirect(get_admin_url($this->_module_slug));
        }
    }

    function admin_index() {
        $this->_initialize_admin();
        $this->redirect_admin();

        $args = $this->default_args();
        $total = $this->counts($args);
        $perpage = $this->config->item('per_page');
        $segment = 3;

        $this->load->library('pagination');

        $config['total_rows'] = $total;
        $config['per_page'] = $perpage;
        $config['full_tag_open'] = '<ul class="pagination">';
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

        $config['base_url'] = get_admin_url($this->_module_slug);
        $config['uri_segment'] = $segment;
        $this->pagination->initialize($config);

        $pagination = $this->pagination->create_links();
        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);

        $this->_data['rows'] = $this->M_shops_contact->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;
        $this->_data['title'] = 'Liên hệ - Sản phẩm - ' . $this->_data['title'];
        $this->_data['breadcrumbs'] = $this->_breadcrumbs;

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
			'folder' => 'shops',
			'name' => 'admin-contact-items'
		);
		$this->set_modules();
		$this->_data['main_content'] = 'shops/admin/view_page_contact_index';
		$this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_view() {
        $this->_initialize_admin();
        $this->redirect_admin();

        $id = $this->input->get('id');
        if ($id != 0) {
            $this->_data['breadcrumbs_module_func'] = 'Xem liên hệ';
            $row = $this->get($id);

            if ($row == NULL) {
                $this->redirect_admin();
            }

            if ($row['is_view'] == 0) {
                $data = array(
                    'is_view' => 1,
					'view_time' => time(),
                );
                $this->M_shops_contact->update($id, $data);
            }

			if(isset($row['product_id'])){
				$row['product'] = modules::run('shops/rows/get', $row['product_id']);
			}

            $this->_data['row'] = $row;
            $this->_data['title'] = 'Liên hệ - ' . $this->_data['title'];
            $this->_data['main_content'] = 'shops/admin/view_page_contact_detail';
            $this->load->view('layout/admin/view_layout', $this->_data);
        } else {
            redirect(get_admin_url($this->_module_slug));
        }
    }

    function admin_delete() {
        $this->_initialize_admin();
        $this->redirect_admin();
        $this->load->module('users');

        $this->_message_success = 'Đã xóa liên hệ!';
        $this->_message_danger = 'Rất tiếc! Có lỗi kỹ thuật!';
        $this->_message_warning = 'Liên hệ không tồn tại!';
        $this->_message_banned = 'Không có quyền truy cập vào khu vực này!';
        if ($this->users->validate_admin_logged_in() == TRUE) {
            if ($this->input->post('ajax') == '1') {
                $id = $this->input->post('id');
                if ($id != 0) {
                    if ($this->M_shops_contact->delete($id)) {
                        $this->_status = "success";
                        $this->_message = $this->_message_success;
                    } else {
                        $this->_status = "danger";
                        $this->_message = $this->_message_danger;
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
                    if ($this->M_shops_contact->delete($id)) {
                        $this->set_message_success();
                    } else {
                        $this->set_message_danger();
                    }
                } else {
                    $this->set_message_warning();
                }
                redirect(get_admin_url($this->_module_slug));
            }
        } else {
            if ($this->input->post('ajax') == '1') {
                $this->_status = "danger";
                $this->_message = $this->_message_banned;

                $this->set_json_encode();
                $this->load->view('layout/json_data', $this->_data);
            } else {
                $this->set_message_banned();
                redirect(get_admin_url($this->_module_slug));
            }
        }
    }

}

/* End of file contact.php */
/* Location: ./application/modules/shops/controllers/contact.php */