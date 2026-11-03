<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Services_maintenance extends Layout {

    private $_module_slug = 'sua-chua-bao-hanh';

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->_data['module_slug'] = $this->_module_slug;
        $this->_data['breadcrumbs_module_name'] = 'Sửa chữa bảo hành';
        $this->load->model('services/m_services', 'M_services');
        $this->load->model('services/m_services_details', 'M_services_details');
    }

    function default_args() {
        $order_by = array(
            'end_date' => 'ASC'
        );
        $args = array();
        $args['type'] = 'maintenance';
        $args['order_by'] = $order_by;

        return $args;
    }

    function counts($args) {
        return $this->M_services->counts($args);
    }

    function get($id) {
        $this->load->model('services/m_services', 'M_services');
        return $this->M_services->get($id);
    }

    function gets() {
        $args = $this->default_args();
        $this->load->model('services/m_services', 'M_services');
        return $this->M_services->gets($args);
    }

    function get_details($id) {
        $this->load->model('services/m_services_details', 'M_services_details');
        return $this->M_services_details->get($id);
    }

    function admin_index() {
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
            'folder' => 'services',
            'name' => 'admin-maintenance'
        );
        $this->set_modules();

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $args = $this->default_args();
        $args['type'] = 'maintenance';
        $args['deleted'] = 0;

        //theo ngay
        if (isset($get['fromday']) && trim($get['fromday']) != '') {
            $args['start_date_start'] = get_current_date($get['fromday']);
        }
        if (isset($get['today']) && trim($get['today']) != '') {
            $args['start_date_end'] = get_current_date($get['today']);
        }

        if (isset($get['q']) && trim($get['q']) != '') {
            $args['code'] = $get['q'];
        }

        if (isset($get['fixed']) && trim($get['fixed']) != -1) {
            $args['fixed'] = $get['fixed'];
        }

        if (isset($get['returned']) && trim($get['returned']) != -1) {
            $args['returned'] = $get['returned'];
        }

        if (isset($get['customer']) && trim($get['customer']) != '') {
            $args['customer'] = $get['customer'];
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

        $rows = $this->M_services->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;

        foreach ($rows as $key => $value) {
            $rows[$key]['items'] = $this->get_details($value['id']);
        }
        $this->_data['rows'] = $rows;

        $this->_data['title'] = 'Danh sách sửa chữa bảo hành - ' . $this->_data['title'];
        $this->_data['main_content'] = 'services/admin/view_page_maintenance';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_trash() {
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
            'folder' => 'services',
            'name' => 'admin-maintenance-trash'
        );
        $this->set_modules();

        $this->_data['breadcrumbs_module_name'] = 'Thùng rác';
        $this->_module_slug = 'thung-rac/sua-chua-bao-hanh';
        $this->_data['module_slug'] = $this->_module_slug;

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $args = $this->default_args();
        $args['type'] = 'maintenance';
        $args['deleted'] = 1;

        //theo ngay
        if (isset($get['fromday']) && trim($get['fromday']) != '') {
            $args['start_date_start'] = get_current_date($get['fromday']);
        }
        if (isset($get['today']) && trim($get['today']) != '') {
            $args['start_date_end'] = get_current_date($get['today']);
        }

        if (isset($get['q']) && trim($get['q']) != '') {
            $args['code'] = $get['q'];
        }

        if (isset($get['fixed']) && trim($get['fixed']) != -1) {
            $args['fixed'] = $get['fixed'];
        }

        if (isset($get['returned']) && trim($get['returned']) != -1) {
            $args['returned'] = $get['returned'];
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

        $this->_data['rows'] = $this->M_services->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;

        $this->_data['title'] = 'Thùng rác - Danh sách sửa chữa bảo hành - ' . $this->_data['title'];
        $this->_data['main_content'] = 'services/admin/view_page_maintenance_trash';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_content_ajax() {
        $post = $this->input->post();
        if (!empty($post)) {
            $this->load->helper('language');
            $this->lang->load('form_validation', 'vietnamese');
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('code', 'Số phiếu', 'required');
            $message = array();
            $message['status'] = 'error';
            $message['content'] = null;
            $message['message'] = 'Kiểm tra thông tin nhập';

            if ($this->form_validation->run($this)) {
                if ($this->check_code_availablity()) {
                    $err = FALSE;
                    $consignments = array();
                    $id = (int) $this->input->post('id');
                    $count = $this->input->post('count');
                    $tblAppendGrid = 'tblAppendGrid_';

                    for ($i = 1; $i <= $count; $i++) {
                        $consignments[] = array(
                            'consignment_id' => $this->input->post($tblAppendGrid . 'consignment_id' . '_' . $i),
                            'quantity' => $this->input->post($tblAppendGrid . 'quantity' . '_' . $i),
                            'returned' => $this->input->post($tblAppendGrid . 'returned' . '_' . $i),
                            'status' => remove_special_string_textarea($this->input->post($tblAppendGrid . 'status' . '_' . $i)),
                            'note' => remove_special_string_textarea($this->input->post($tblAppendGrid . 'note' . '_' . $i)),
                            'fee' => $this->input->post($tblAppendGrid . 'fee' . '_' . $i),
                        );
                    }
                    if (!empty($consignments)) {
                        $current_page = $this->input->post('current_page');
                        $start_date = $this->input->post('start_date');
                        $end_date = $this->input->post('end_date');
                        $data_services = array(
                            'type' => 'maintenance',
                            'code' => $this->input->post('code'),
                            'customer_id' => $this->input->post('customer_id'),
                            'returned' => $this->input->post('returned'),
                            'fixed' => $this->input->post('fixed'),
                            'start_date' => (trim($start_date) != '') ? get_current_date($start_date) : 0,
                            'end_date' => (trim($end_date) != '') ? get_current_date($end_date) : 0,
                        );

                        if ($id != 0) {
                            if (!$this->M_services->update($id, $data_services)) {
                                $err = TRUE;
                            } else {
                                $this->M_services_details->delete($id);
                            }
                            $services_id = $id;
                        } else {
                            $data_services['admin_id'] = 1;
                            $data_services['deleted'] = 0;
                            $data_services['deleted_by'] = 0;
                            $data_services['add_time'] = time();
                            $services_id = $this->M_services->add($data_services);
                        }

                        if ($services_id != 0) {
                            foreach ($consignments as $value) {
                                $data = array(
                                    'services_id' => $services_id,
                                    'consignment_id' => $value['consignment_id'],
                                    'quantity' => $value['quantity'],
                                    'returned' => $value['returned'],
                                    'status' => remove_special_string_textarea($value['status']),
                                    'note' => remove_special_string_textarea($value['note']),
                                    'fee' => $value['fee']
                                );
                                if (!$this->M_services_details->add($data)) {
                                    $err = TRUE;
                                }
                            }
                        } else {
                            $err = TRUE;
                        }
                    }

                    if ($err === FALSE) {
                        $message['status'] = 'success';
                        $message['content'] = array('data' => (isset($current_page) && $current_page > 0) ? base_url($this->_module_slug . '/' . $current_page) : base_url($this->_module_slug));
                        $message['message'] = 'Phiếu sửa chữa bảo hành đã lưu!';
                    } else {
                        $message['status'] = 'error';
                        $message['content'] = null;
                        $message['message'] = 'Có lỗi xảy ra! Vui lòng thực hiện lại!';
                    }
                } else {
                    $message['status'] = 'error';
                    $message['content'] = null;
                    $message['message'] = 'Mã sửa chữa bảo hành đã tồn tại!';
                }
            }
            echo json_encode($message);
        }
    }

    function get_max_code() {
        $args = $this->default_args();
        $order_by = array(
            'code' => 'DESC'
        );
        $args['order_by'] = $order_by;
        $rows = $this->M_services->gets($args, 1, 0);
        $code = (int) (isset($rows[0]['code']) ? filter_var($rows[0]['code'], FILTER_SANITIZE_NUMBER_INT) : 0) + 1;
        return MAINTENANCE_PREFIX . str_pad($code, MAINTENANCE_LENGHT, "0", STR_PAD_LEFT);
    }

    function check_code_availablity() {
        $this->load->model('services/m_services', 'M_services');
        $post = $this->input->post();
        $this->_message_success = 'true';
        $this->_message_danger = 'false';

        if (!empty($post)) {
            $type = 'maintenance';
            $code = $this->input->post('code');
            $id = $this->input->post('id');
            if ($this->input->post('ajax') == '1') {
                if ($this->M_services->check_code_availablity($type, $code, $id)) {
                    $this->_status = "success";
                    $this->_message = $this->_message_success;
                } else {
                    $this->_status = "danger";
                    $this->_message = $this->_message_danger;
                }

                $this->set_json_encode();
                $this->load->view('layout/json_data', $this->_data);
            } else {
                if ($this->M_services->check_code_availablity($type, $code, $id)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        } else {
            redirect(base_url());
        }
    }

    function check_code_format() {
        $post = $this->input->post();
        $this->_message_success = 'true';
        $this->_message_danger = 'false';

        if (!empty($post)) {
            if ($this->input->post('ajax') == '1') {
                $code = $this->input->post('code');
                if ($this->is_code_format($code)) {
                    $this->_status = "success";
                    $this->_message = $this->_message_success;
                } else {
                    $this->_status = "danger";
                    $this->_message = $this->_message_danger;
                }

                $this->set_json_encode();
                $this->load->view('layout/json_data', $this->_data);
            } else {
                $code = $this->input->post('code');
                if ($this->is_code_format($code)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        } else {
            redirect(base_url());
        }
    }

    function is_code_format($code = '') {
        $result = preg_match("/" . MAINTENANCE_PREFIX . "[0-9]{" . MAINTENANCE_LENGHT . "," . MAINTENANCE_LENGHT . "}$/", $code);
        return ($result == 1) ? TRUE : FALSE;
    }

    function admin_content() {
        $this->redirect_admin();
        $this->_plugins_css_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery-ui.structure.min'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery-ui.theme.min'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery-ui-1.11.1.min'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery.appendGrid-1.6.2'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery.appendGrid-1.6.2'
        );


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
            'folder' => 'chosen',
            'name' => 'chosen'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'chosen',
            'name' => 'chosen.jquery'
        );

        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'services',
            'name' => 'admin-maintenance-content'
        );
        $this->set_modules();

        $max_code = $this->get_max_code();
        $this->_data['max_code'] = $max_code;

        $customers_kl = modules::run('customers/gets', array('deleted' => 0));
        $customer_kl = array();
        foreach ($customers_kl as $value) {
            $customer_kl[$value['id']] = $value['full_name'];
        }
        $this->_data['customer_kl'] = $customer_kl;

        $consignments = modules::run('consignment/gets', array('deleted' => 0));
        $this->_data['consignments'] = $consignments;

        $title = 'Phiếu sửa chữa bảo hành - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];

        $id = ($this->uri->segment(3) == '') ? 0 : $this->uri->segment(3);
        if ($id != 0) {
            $this->_data['current_page'] = (int) $this->input->get('current_page');
            $row = $this->get($id);
            $row['items'] = $this->M_services_details->get_data_in_services_id($row ['id']);
            $this->_data['row'] = $row;

            $title = 'Cập nhật phiếu sửa chữa bảo hành - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
        }
        $this->_data['customer_types'] = modules::run('customer_types/gets');
        $this->_data['freight'] = modules::run('freight/gets');
        
        $this->_data['title'] = $title;       
        $this->_data['main_content'] = 'services/admin/view_page_maintenance_content';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_view() {
        $this->redirect_admin();
        $this->_plugins_css_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery-ui.structure.min'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery-ui.theme.min'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery-ui-1.11.1.min'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery.appendGrid-1.6.2'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery.appendGrid',
            'name' => 'jquery.appendGrid-1.6.2'
        );


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
            'folder' => 'chosen',
            'name' => 'chosen'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'chosen',
            'name' => 'chosen.jquery'
        );

        $this->_plugins_script_admin[] = array(
            'folder' => 'jQuery-Plugin-To-Print-Any-Part-Of-Your-Page-Print',
            'name' => 'jQuery.print'
        );

        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'services',
            'name' => 'admin-maintenance-view'
        );
        $this->set_modules();

        $customers_kl = modules::run('customers/gets', array('type' => 'kl'));
        $customer_kl = array();
        foreach ($customers_kl as $value) {
            $customer_kl[$value['id']] = $value['full_name'];
        }
        $this->_data['customer_kl'] = $customer_kl;

        $consignments = modules::run('consignment/gets');
        $this->_data['consignments'] = $consignments;

        $id = ($this->uri->segment(3) == '') ? 0 : $this->uri->segment(3);
        if ($id != 0) {
            $row = $this->get($id);
            if (!is_array($row) || empty($row)) {
                redirect($this->_module_slug);
            }

            $row['items'] = $this->M_services_details->get_data_in_services_id($row['id']);
            $this->_data['row'] = $row;

            $title = 'Xem phiếu sửa chữa bảo hành' . (isset($row['code']) && trim($row['code']) != '' ? ' ' . $row['code'] : '') . ' - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
        } else {
            redirect($this->_module_slug);
        }
        $this->_data['title'] = $title;

        $this->_data['main_content'] = 'services/admin/view_page_maintenance_view';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_delete() {
        $this->redirect_admin();
        $id = (int) $this->input->get('id');
        $row = $this->get($id);
        if ($id != 0 && !empty($row)) {
            if ($this->M_services->update($id, array('deleted' => 1, 'deleted_by' => $this->_data['userid']))) {
                $notify_type = 'success';
                $notify_content = "Đã xóa phiếu sửa chữa bảo hành!";
            } else {
                $notify_type = 'danger';
                $notify_content = "Chưa xóa phiếu sửa chữa bảo hành!";
            }
        } else {
            $notify_type = 'warning';
            $notify_content = "Phiếu sửa chữa bảo hành không tồn tại!";
        }
        $this->set_notify_admin($notify_type, $notify_content);
        redirect(base_url($this->_module_slug));
    }

    function admin_delete_trash() {
        $this->redirect_admin();
        $this->_module_slug = 'thung-rac/muon-hang';
        $id = (int) $this->input->get('id');
        $row = $this->get($id);
        if ($id != 0 && !empty($row)) {
            if ($this->M_services->delete($id)) {
                $this->M_services_details->delete($id);
                $notify_type = 'success';
                $notify_content = "Đã xóa phiếu sửa chữa bảo hành!";
            } else {
                $notify_type = 'danger';
                $notify_content = "Chưa xóa phiếu sửa chữa bảo hành!";
            }
        } else {
            $notify_type = 'warning';
            $notify_content = "Phiếu sửa chữa bảo hành không tồn tại!";
        }
        $this->set_notify_admin($notify_type, $notify_content);
        redirect(base_url($this->_module_slug));
    }

    function admin_main() {
        $this->redirect_admin();
        $post = $this->input->post();
        if (!empty($post)) {
            $action = $this->input->post('action');
            if ($action == 'delete') {
                $this->_message_success = 'Đã xóa các phiếu sửa chữa bảo hành được chọn!';
                $this->_message_warning = 'Bạn chưa chọn phiếu sửa chữa bảo  hành nào!';
                $ids = $this->input->post('idcheck');

                if (is_array($ids) && !empty($ids)) {
                    foreach ($ids as $id) {
                        $row = $this->get($id);
                        if ($this->M_services->update($id, array('deleted' => 1, 'deleted_by' => $this->_data['userid']))) {
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

    function ajax_get_customer() {
        $id = (int) $this->input->post('id');
        $customer = modules::run('customers/get', $id);

        $message = array();
        $message['status'] = 'error';
        $message['content'] = null;
        $message['message'] = '';

        if ($id != 0 && !empty($customer)) {
            $message['status'] = 'success';

            $message['content'] = array('data' => $customer);
            $message['message'] = '';
        }
        echo json_encode($message);
    }

    function ajax_get_enddate() {
        $message = array();
        $end_date = get_current_date($this->input->post('start_date'));
        if ($end_date > 0) {
            $message['status'] = 'success';
            $message['content'] = array('data' => date('d/m/Y', $end_date));
            $message['message'] = '';
        } else {
            $message['status'] = 'error';
            $message['content'] = null;
            $message['message'] = '';
        }
        echo json_encode($message);
    }

}

/* End of file store_received_voucher.php */
/* Location: ./application/modules/store_received_voucher/controllers/store_received_voucher.php */
