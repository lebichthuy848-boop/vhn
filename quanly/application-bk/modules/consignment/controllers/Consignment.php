<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Consignment extends Layout {

    private $_module_slug = 'thiet-bi';

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('consignment/m_consignment', 'M_consignment');
        $this->_data['module_slug'] = $this->_module_slug;
        $this->_data['breadcrumbs_module_name'] = 'Thiết bị';
    }

    function default_args() {
        $order_by = array(
            'name' => 'ASC',
            'add_time' => 'ASC',
            'edit_time' => 'ASC'
        );
        $args = array();
        $args['order_by'] = $order_by;

        return $args;
    }

    function counts($args) {
        return $this->M_consignment->counts($args);
    }

    function get($id) {
        $this->load->model('consignment/m_consignment', 'M_consignment');
        return $this->M_consignment->get($id);
    }

    function gets($args = array()) {
        $order_by = array(
            'name' => 'ASC',
            'add_time' => 'ASC',
            'edit_time' => 'ASC'
        );
        $args['order_by'] = $order_by;
        $this->load->model('consignment/m_consignment', 'M_consignment');
        return $this->M_consignment->gets($args);
    }

    function admin_index() {
        $this->redirect_admin();

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
            'folder' => 'consignment',
            'name' => 'admin-items'
        );
        $this->set_modules();

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $args = $this->default_args();
        $args['deleted'] = 0;

        if (isset($get['q']) && trim($get['q']) != '') {
            $args['name'] = $get['q'];
        }

        $total = $this->counts($args);
        $perpage = isset($get['per_page']) ? $get['per_page'] : $this->config->item('per_page');
        $segment = 2;

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

        $this->_data['rows'] = $this->M_consignment->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;

        $this->_data['title'] = 'Danh sách thiết bị - ' . $this->_data['title'];
        $this->_data['main_content'] = 'consignment/admin/view_page_index';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_trash() {
        $this->redirect_admin();
        $this->_data['breadcrumbs_module_name'] = 'Thùng rác';
        $this->_module_slug = 'thung-rac/thiet-bi';
        $this->_data['module_slug'] = $this->_module_slug;

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
            'folder' => 'consignment',
            'name' => 'admin-items-trash'
        );
        $this->set_modules();

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $args = $this->default_args();
        $args['deleted'] = 1;

        if (isset($get['q']) && trim($get['q']) != '') {
            $args['name'] = $get['q'];
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

        $this->_data['rows'] = $this->M_consignment->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;

        $this->_data['title'] = 'Danh sách thiết bị - ' . $this->_data['title'];
        $this->_data['main_content'] = 'consignment/admin/view_page_trash';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_add() {
        $data = array(
            'name' => $this->input->post('name'),
            'code' => $this->input->post('code'),
            'unit' => $this->input->post('unit'),
            'add_time' => time(),
            'edit_time' => 0
        );

        return $this->M_consignment->add($data);
    }

    function admin_update($id) {
        $data = array(
            'name' => $this->input->post('name'),
            'code' => $this->input->post('code'),
            'unit' => $this->input->post('unit'),
            'edit_time' => time()
        );
        return $this->M_consignment->update($id, $data);
    }

    function admin_delete() {
        $this->load->module('users');

        $this->_message_success = 'Đã xóa thông tin!';
        $this->_message_warning = 'Thông tin này không tồn tại!';
        if ($this->users->validate_admin_logged_in() == TRUE) {
            if ($this->input->post('ajax') == '1') {
                $id = $this->input->post('id');
                if ($id != 0) {
                    if ($this->M_consignment->update($id, array('deleted' => 1, 'deleted_by' => $this->_data['userid']))) {
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
                    if ($this->M_consignment->update($id, array('deleted' => 1, 'deleted_by' => $this->_data['userid']))) {
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
                redirect(base_url($this->_module_slug));
            }
        }
    }

    function admin_delete_trash() {
        $this->load->module('users');
        $this->_module_slug = 'thung-rac/thiet-bi';
        $this->_data['module_slug'] = $this->_module_slug;

        $this->_message_success = 'Đã xóa thông tin!';
        $this->_message_warning = 'Thông tin này không tồn tại!';
        if ($this->users->validate_admin_logged_in() == TRUE) {
            if ($this->input->post('ajax') == '1') {
                $id = $this->input->post('id');
                if ($id != 0) {
                    if ($this->M_consignment->delete($id)) {
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
                    if ($this->M_consignment->delete($id)) {
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
                redirect(base_url($this->_module_slug));
            }
        }
    }

    function admin_main() {
        $this->redirect_admin();
        $post = $this->input->post();
        if (!empty($post)) {
            $action = $this->input->post('action');
            if ($action == 'delete') {
                $this->_message_success = 'Đã xóa các thiết bị được chọn!';
                $this->_message_warning = 'Bạn chưa chọn thiết bị nào!';
                $ids = $this->input->post('idcheck');

                if (is_array($ids) && !empty($ids)) {
                    foreach ($ids as $id) {
                        $row = $this->get($id);
                        if (!empty($row) && $this->M_consignment->update($id, array('deleted' => 1, 'deleted_by' => $this->_data['userid']))) {
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
                redirect(base_url($this->_module_slug . '/them'));
            }
        } else {
            redirect(get_admin_url($this->_module_slug));
        }
    }

    function admin_content() {
        $this->redirect_admin();

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

        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'consignment',
            'name' => 'admin-content-validate'
        );
        $this->set_modules();

        $post = $this->input->post();
        if (!empty($post)) {
            $this->load->helper('language');
            $this->lang->load('form_validation', 'vietnamese');

            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('name', 'Nhập tên thiết bị', 'trim|required');

            if ($this->form_validation->run($this)) {
                if ($this->input->post('id')) {//update
                    $err = FALSE;
                    $id = $this->input->post('id');
                    if (!$this->admin_update($id)) {
                        $err = TRUE;
                    }

                    if ($err === FALSE) {
                        $current_page = $this->input->post('current_page');
                        $notify_type = 'success';
                        $notify_content = 'Cập nhật thông tin thành công!';
                        $this->set_notify_admin($notify_type, $notify_content);
                        redirect(base_url((isset($current_page) && $current_page > 0) ? ($this->_module_slug . '/' . $current_page) : $this->_module_slug));
                    } else {
                        $notify_type = 'danger';
                        $notify_content = 'Có lỗi xảy ra!';
                        $this->set_notify_admin($notify_type, $notify_content);
                    }
                } else {//add
                    $err = FALSE;
                    $insert_id = $this->admin_add();
                    if ($insert_id == 0) {
                        $err = TRUE;
                    }

                    if ($err === FALSE) {
                        $notify_type = 'success';
                        $notify_content = 'Thông tin đã được thêm!';
                        $this->set_notify_admin($notify_type, $notify_content);

                        redirect(base_url($this->_module_slug));
                    } else {
                        $notify_type = 'danger';
                        $notify_content = 'Có lỗi xảy ra!';
                        $this->set_notify_admin($notify_type, $notify_content);
                    }
                }
            }
        }

        $title = 'Thêm thông tin - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];

        $id = ($this->uri->segment(3) == '') ? 0 : $this->uri->segment(3);
        if ($id != 0) {
            $this->_data['current_page'] = (int) $this->input->get('current_page');
            $row = $this->get($id);
            $this->_data['row'] = $row;
            $title = 'Cập nhật thông tin - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
        }

        $this->_data['title'] = $title;
        $this->_data['main_content'] = 'consignment/admin/view_page_content';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

}

/* End of file consignment.php */
/* Location: ./application/modules/consignment/controllers/consignment.php */
