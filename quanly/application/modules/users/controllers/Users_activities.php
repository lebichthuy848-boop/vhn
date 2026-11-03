<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Users_activities extends Layout {

    private $_module_slug = 'nhat-ky-he-thong';

    function __construct() {
        parent::__construct();
        $this->_data['module_slug'] = $this->_module_slug;

		$_breadcrumbs_admin[] = array(
			'url' => '',
			'name' => 'Nhật ký hệ thống',
			'image' => base_url('assets/Frest/app-assets/images/svg/ico/ico-trade.svg'),
		);
		$this->_data['breadcrumbs_admin'] = $_breadcrumbs_admin;
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
            $id = $this->input->post('id');
            $row = $this->get(array(
                'id' => $id
            ));
            if(!(is_array($row) && !empty($row))){
                $message['status'] = 'error';
                $message['content'] = null;
                $message['message'] = show_alert_danger('Nhật ký hệ thống không tồn tại!');
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
                $id = $row['order_id'];
                $output_voucher = $this->M_output_voucher->get($id);
                if($id == 0 || !(is_array($output_voucher) && !empty($output_voucher))){
                    $message['status'] = 'error';
                    $message['content'] = null;
                    $message['message'] = show_alert_success('Đơn hàng không tồn tại! Vui lòng kiểm tra lại!');
                    echo json_encode($message);
                    exit();
                }
                $data_output_voucher = array(
                    'status' => $status,
                    'modified' => $time
                );
                if ($this->M_output_voucher->update($id, $data_output_voucher)) {
                    $data_activities = array(
                        'status' => $status,
                        'verified' => $time,
                        'verify_by' => $verify_by
                    );
                    $this->M_users_activities->update(array('order_id' => $id), $data_activities);
                }

                if($status == 1){
                    $user_id = $row['user_id'];
                    $user = $this->M_users->get($user_id);
                    if(is_array($user) && !empty($user)){
                        $net_revenue = $this->get_net_revenue($user_id);

                        $ref_net_revenue = 0;
                        $ref_users = $this->M_users->gets(array(
                            'referred_by' => $user_id
                        ));
                        if(is_array($ref_users) && !empty($ref_users)){
                            $in_user_id = array_column($ref_users, 'userid');
                            $ref_net_revenue = $this->get_net_revenue($in_user_id);
                        }
                        $net_revenue += $ref_net_revenue;

                        $level = 'MEMBER';
                        if($net_revenue >= 5000000 && $net_revenue < 10000000){
                            $level = 'RESELLER';
                        }elseif($net_revenue >= 10000000 && $net_revenue < 20000000){
                            $level = 'DEALER';
                        }elseif($net_revenue >= 20000000){
                            $level = 'TRADER';
                        }
                        if($level != 'MEMBER' && $user['level'] != 'TRADER'){
                            $this->M_users->update($user_id, array('level' => $level));
                        }
                    }
                    $message['status'] = 'success';
                    $message['content'] = display_label('Khả dụng');
                    $message['message'] = show_alert_success('Xác nhận yêu cầu thành công!');
                }else{
                    $message['status'] = 'success';
                    $message['content'] = display_label('Đã hủy yêu cầu', 'danger');
                    $message['message'] = show_alert_success('Hủy đơn hàng thành công!');
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
        return $this->M_users_activities->counts($args);
    }

	function validate_exist($args) {
        $data = $this->get($args);

        if (is_array($data) && !empty($data)) {
            return TRUE;
        }

        return FALSE;
    }

    function get($args) {
        return $this->M_users_activities->get($args);
    }

    function gets($options = array()) {
		$default_args = $this->default_args();

		if (is_array($options) && !empty($options)) {
			$args = array_merge($default_args, $options);
		} else {
			$args = $default_args;
		}
        return $this->M_users_activities->gets($args);
    }

    function add($data = NULL) {
        if (empty($data)) {
            return 0;
        }
        return $this->M_users_activities->add($data);
    }

    function update($args, $data) {
        return $this->M_users_activities->update($args, $data);
    }

    function delete($args) {
        return $this->M_users_activities->delete($args);
    }

    function admin_index() {
        $this->_initialize_admin();
        $this->redirect_admin();

        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap4-dialog/css',
            'name' => 'bootstrap-dialog',
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap4-dialog/js',
            'name' => 'bootstrap-dialog',
        );
        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'users',
            'name' => 'admin-activities-items',
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
        $segment = 2;

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

        $this->_data['rows'] = $this->M_users_activities->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;

        $this->_data['title'] = 'Nhật ký hệ thống - ' . $this->_data['title'];
        $this->_data['main_content'] = 'users/admin/view_page_activities_index';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_main() {
        $this->_initialize_admin();
        $this->redirect_admin();
        $post = $this->input->post();
        if (!empty($post)) {
            $action = $this->input->post('action');
            if ($action == 'delete') {
                $this->_message_success = 'Đã xóa các nhật ký hệ thống được chọn!';
                $this->_message_warning = 'Bạn chưa chọn nhật ký hệ thống nào!';
                $ids = $this->input->post('idcheck');

                if (is_array($ids) && !empty($ids)) {
                    foreach ($ids as $id) {
                        $row = $this->get(array('id' => $id));
                        if (!empty($row) && $this->M_users_activities->delete(array('id' => $id))) {
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
                redirect(base_url($this->_module_slug . '/content'));
            }
        } else {
            redirect(base_url($this->_module_slug));
        }
    }

    function admin_delete() {
        $this->_initialize_admin();
        $this->redirect_admin();

        $this->_message_success = 'Đã xóa nhật ký hệ thống!';
        $this->_message_warning = 'Nhật ký hệ thống này không tồn tại!';
        $id = $this->input->get('id');
        if ($id != 0) {
            if ($this->M_users_activities->delete(array('id' => $id))) {
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
}
/* End of file Users_activities.php */
/* Location: ./application/modules/users/controllers/Users_activities.php */