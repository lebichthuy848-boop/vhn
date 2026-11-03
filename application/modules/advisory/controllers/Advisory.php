<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Advisory extends Layout {

    private $_module_slug = 'advisory';

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->_data['module_slug'] = $this->_module_slug;
        $this->load->model('advisory/m_advisory', 'M_advisory');
        $this->_data['breadcrumbs_module_name'] = 'Tư vấn';
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
        $this->load->model('advisory/m_advisory', 'M_advisory');
        return $this->M_advisory->gets($args);
    }

    function counts($args) {
        $this->load->model('advisory/m_advisory', 'M_advisory');
        return $this->M_advisory->counts($args);
    }

    function get($id) {
        $this->load->model('advisory/m_advisory', 'M_advisory');
        return $this->M_advisory->get($id);
    }

    function index() {
		$this->_initialize();

        $this->_plugins_script[] = array(
            'folder' => 'jquery-validation',
            'name' => 'jquery.validate'
        );
        $this->_plugins_script[] = array(
            'folder' => 'jquery-validation/localization',
            'name' => 'messages_vi'
        );
        $this->set_plugins();

        $this->_modules_script[] = array(
            'folder' => 'advisory',
            'name' => 'advisory-validate'
        );
        $this->set_modules();

        $post = $this->input->post();

        if (!empty($post)) {
            $this->load->helper('language');
            $this->lang->load('form_validation', 'vietnamese');

            $this->form_validation->set_error_delimiters('<p class="required">', '</p>');
            $this->form_validation->set_rules('full_name', 'Họ tên', 'trim|required|max_length[60]');
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|max_length[60]');
            $this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|required');

            if ($this->form_validation->run($this)) {
                $data['full_name'] = $this->input->post('full_name');
                $data['email'] = $this->input->post('email');
                $data['company'] = $this->input->post('company');
                $data['phone'] = $this->input->post('phone');
                $data['address'] = $this->input->post('address');
                $data['need'] = $this->input->post('need');
                $data['category'] = $this->input->post('category');
                $data['uses'] = $this->input->post('uses');
                $data['capacity'] = $this->input->post('capacity');
                $data['note'] = $this->input->post('note');
                $data['price'] = $this->input->post('price');
                $data['message'] = $this->input->post('message');
                $data['execution_time'] = $this->input->post('execution_time');
                $data['add_time'] = time();
                $data['is_view'] = 0;
                $data['view_time'] = 0;

                if ($this->M_advisory->add($data)) {
					$data['site_name'] = $this->_data['site_name'];
					$data['message'] = $this->load->view('layout/site/partial/html-template-advisory', array('data' => $data), true);
                    $data_sendmail = array(
                        'sender_email' => $data['email'],
                        'sender_name' => $data['full_name'] . ' - ' . $data['email'],
                        'receiver_email' => $this->_data['email'], //mail nhan thư
                        'subject' => 'Tư vấn',
                        'message' => $data['message']
                    );
                    modules::run('emails/send_mail', $data_sendmail);

                    $notify_type = 'success';
                    $notify_content = 'Cám ơn bạn đã gửi tư vấn tới chúng tôi!';
                } else {
                    $notify_type = 'danger';
                    $notify_content = 'Tư vấn chưa được gửi! Vui lòng thực hiện lại!';
                }

                $this->set_notify($notify_type, $notify_content);
                redirect(current_url());
            }
        }

        $this->_breadcrumbs[] = array(
            'url' => current_url(),
            'name' => 'Tư vấn'
        );
        $this->set_breadcrumbs();

        $this->_data['title_seo'] = 'Tư vấn' . ' - ' . $this->_data['title_seo'];
        $this->_data['main_content'] = 'layout/site/pages/advisory';
        $this->load->view('layout/site/layout', $this->_data);
    }

    function index_ajax() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $this->_initialize();

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = 'Kiểm tra thông tin nhập';

        $post = $this->input->post();
        if (!empty($post)) {
            $this->form_validation->set_error_delimiters('<p class="required">', '</p>');
            $this->form_validation->set_rules('full_name', 'Họ tên', 'trim|required|max_length[60]');
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|max_length[60]');
            $this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|required');

            if ($this->form_validation->run($this)) {
                $data['full_name'] = $this->input->post('full_name');
                $data['email'] = $this->input->post('email');
                $data['company'] = $this->input->post('company');
                $data['phone'] = $this->input->post('phone');
                $data['address'] = $this->input->post('address');
                $data['need'] = $this->input->post('need');
                $data['category'] = $this->input->post('category');
                $data['uses'] = $this->input->post('uses');
                $data['capacity'] = $this->input->post('capacity');
                $data['note'] = $this->input->post('note');
                $data['price'] = $this->input->post('price');
                $data['message'] = $this->input->post('message');
                $data['execution_time'] = $this->input->post('execution_time');
                $data['add_time'] = time();
                $data['is_view'] = 0;
                $data['view_time'] = 0;

                if ($this->M_advisory->add($data)) {
                    $data['site_name'] = $this->_data['site_name'];
                    $data['message'] = $this->load->view('layout/site/partial/html-template-advisory', array('data' => $data), true);
                    $data_sendmail = array(
                        'sender_email' => $data['email'],
                        'sender_name' => $data['full_name'] . ' - ' . $data['email'],
                        'receiver_email' => $this->_data['email'], //mail nhan thư
                        'subject' => 'Tư vấn',
                        'message' => $data['message']
                    );
                    modules::run('emails/send_mail', $data_sendmail);
                    $message['status'] = 'success';
                    $message['content'] = $data;
                    $message['message'] = 'Cám ơn bạn đã gửi tư vấn tới chúng tôi!';
                } else {
                    $message['status'] = 'danger';
                    $message['content'] = null;
                    $message['message'] = 'Tư vấn chưa được gửi! Vui lòng thực hiện lại!';
                }
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
                $this->_message_success = 'Đã xóa các tư vấn được chọn!';
                $this->_message_warning = 'Bạn chưa chọn tư vấn nào!';
                $ids = $this->input->post('idcheck');
                if (is_array($ids) && !empty($ids)) {
                    foreach ($ids as $id) {
                        if ($this->M_advisory->delete($id)) {
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

        $config['base_url'] = get_admin_url('advisory');
        $config['uri_segment'] = $segment;
        $this->pagination->initialize($config);

        $pagination = $this->pagination->create_links();
        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);

        $this->_data['rows'] = $this->M_advisory->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;
        $this->_data['title'] = 'Tư vấn - ' . $this->_data['title'];
        $this->_data['breadcrumbs'] = $this->_breadcrumbs;

        if ($this->input->post('ajax') == 1) {
            $this->load->view('advisory/admin/view_index', $this->_data);
        } else {
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
                'folder' => 'advisory',
                'name' => 'advisory-delete'
            );
            $this->set_modules();
            $this->_data['main_content'] = 'advisory/admin/view_page_index';
            $this->load->view('layout/admin/view_layout', $this->_data);
        }
    }

    function admin_view() {
		$this->_initialize_admin();
        $this->redirect_admin();

        $id = $this->input->get('id');
        if ($id != 0) {
            $this->_data['breadcrumbs_module_func'] = 'Xem tư vấn';
            $row = $this->get($id);

            if ($row == NULL) {
                $this->redirect_admin();
            }

            if ($row['is_view'] == 0) {
                $data = array(
                    'is_view' => 1,
                    'view_time' => time(),
                );
                if ($this->M_advisory->update($id, $data)) {
                    $this->_data['num_rows_advisory'] = $this->num_rows_new();
                }
            }

            $this->_data['row'] = $row;
            $this->_data['title'] = 'Tư vấn - ' . $this->_data['title'];
            $this->_data['main_content'] = 'advisory/admin/view_page_detail';
            $this->load->view('layout/admin/view_layout', $this->_data);
        } else {
            redirect(get_admin_url($this->_module_slug));
        }
    }

    function num_rows_new() {
        $args['is_view'] = 0;
        return $this->counts($args);
    }

    function admin_delete() {
        $this->_initialize_admin();
        $this->redirect_admin();

        $this->_message_success = 'Đã xóa tư vấn!';
        $this->_message_danger = 'Rất tiếc! Có lỗi kỹ thuật!';
        $this->_message_warning = 'Tư vấn không tồn tại!';

		$id = $this->input->get('id');
		if ($id != 0) {
			if ($this->M_advisory->delete($id)) {
				$this->set_message_success();
			} else {
				$this->set_message_danger();
			}
		} else {
			$this->set_message_warning();
		}
		redirect(get_admin_url($this->_module_slug));
    }

}

/* End of file advisory.php */
/* Location: ./application/modules/advisory/controllers/advisory.php */
