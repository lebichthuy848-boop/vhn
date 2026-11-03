<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Employee extends Layout {

    private $_module_slug = 'nhan-vien';

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('employee/m_employee', 'M_employee');
        $this->_data['module_slug'] = $this->_module_slug;
        $this->_data['breadcrumbs_module_name'] = 'Nhân Viên';
		$_breadcrumbs_admin[] = array(
			'url' => '',
			'name' => 'Nhân Viên',
			'image' => base_url('assets/Frest/app-assets/images/svg/ico/ico-employee.svg'),
		);
		$this->_data['breadcrumbs_admin'] = $_breadcrumbs_admin;
    }

	private function _validate_access_role(){
		$this->validate_access_role('ROLE_GROUP_EMPLOYEE');
	}

    function default_args() {
        $order_by = array(
            'full_name' => 'ASC'
        );
        $args = array();
        $args['order_by'] = $order_by;

        return $args;
    }

    function counts($args) {
        return $this->M_employee->counts($args);
    }

    function get($id) {
        $this->load->model('employee/m_employee', 'M_employee');
        return $this->M_employee->get($id);
    }

    function gets($options = array()) {
        $default_args = $this->default_args();
        if (is_array($options) && !empty($options)) {
            $args = array_merge($default_args, $options);
        } else {
            $args = $default_args;
        }
        $this->load->model('employee/m_employee', 'M_employee');
        return $this->M_employee->gets($args);
    }

    function admin_index() {
        $this->_initialize_admin();
        $this->_validate_access_role();

        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap4-dialog/css',
            'name' => 'bootstrap-dialog'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap4-dialog/js',
            'name' => 'bootstrap-dialog'
        );
        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'employee',
            'name' => 'admin-items'
        );
        $this->set_modules();

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $is_admin = FALSE;
        if(isset($this->_data['role']) && $this->_data['role'] == 'ADMIN'){
            $is_admin = TRUE;
        }

        $args = $this->default_args();
        $args['deleted'] = 0;
        if (!$is_admin) {
            $args['role'] = 'SALE_EMPLOYEE';
        }
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
        $this->_data['pagination'] = $pagination;

        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
        $this->_data['rows'] = $this->M_employee->gets($args, $perpage, $offset);

        $this->_data['title'] = 'Nhân viên - ' . $this->_data['title'];
        $this->_data['main_content'] = 'employee/admin/view_page_index';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_add() {
		$birthday = $this->input->post('birthday');
        $data = array(
            'full_name' => $this->input->post('full_name'),
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'role' => $this->input->post('role'),
            'level' => $this->input->post('level'),
			'have_add' => $this->input->post('have_add') ? 1 : 0,
            'have_edit' => $this->input->post('have_edit') ? 1 : 0,
            'have_delete' => $this->input->post('have_delete') ? 1 : 0,
            'password' => md5($this->input->post('password')),
			'birthday' => (trim($birthday) != '') ? get_current_date($birthday) : 0,
            'active' => 1,
            'regdate' => time(),
            'created' => time(),
            'modified' => 0,
        );

        return $this->M_employee->add($data);
    }

    function admin_update($id) {
		$birthday = $this->input->post('birthday');
        $data = array(
            'full_name' => $this->input->post('full_name'),
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'role' => $this->input->post('role'),
            'level' => $this->input->post('level'),
			'have_add' => $this->input->post('have_add') ? 1 : 0,
            'have_edit' => $this->input->post('have_edit') ? 1 : 0,
            'have_delete' => $this->input->post('have_delete') ? 1 : 0,
			'birthday' => (trim($birthday) != '') ? get_current_date($birthday) : 0,
            'modified' => 0,
        );
        if ($this->input->post('password') != '') {
            $data['password'] = md5($this->input->post('password'));
        }
        return $this->M_employee->update($id, $data);
    }

    function user_update($id) {
        $data = array(
            'full_name' => $this->input->post('full_name'),
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password'))
        );
        return $this->M_employee->update($id, $data);
    }

    function admin_delete() {
		$this->_initialize_admin();
        $this->_validate_access_role();

        $this->_message_success = 'Đã xóa thông tin!';
        $this->_message_warning = 'Thông tin này không tồn tại!';
		if ($this->input->post('ajax') == '1') {
			$id = $this->input->post('id');
			if ($id != 0) {
				if ($this->M_employee->delete($id)) {
                    add_activity('Xóa người dùng!');
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
				if ($this->M_employee->delete($id)) {
                    add_activity('Xóa người dùng!');
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

    function admin_main() {
        $this->_initialize_admin();
        $this->_validate_access_role();

        $post = $this->input->post();
        if (!empty($post)) {
            $action = $this->input->post('action');
            if ($action == 'delete') {
                $this->_message_success = 'Đã xóa các nhân viên được chọn!';
                $this->_message_warning = 'Bạn chưa chọn nhân viên nào!';
                $ids = $this->input->post('idcheck');

                if (is_array($ids) && !empty($ids)) {
                    foreach ($ids as $id) {
                        $row = $this->get($id);
                        if (!empty($row) && $this->M_employee->delete($id)) {
                            $notify_type = 'success';
                            $notify_content = $this->_message_success;
                        } else {
                            $notify_type = 'danger';
                            $notify_content = $this->_message_danger;
                        }
                    }
                    add_activity('Xóa nhiều người dùng!');
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
        $this->_initialize_admin();
        $this->_validate_access_role();

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
            'folder' => 'employee',
            'name' => 'admin-content-validate'
        );
        $this->set_modules();

        $post = $this->input->post();
        if (!empty($post)) {
            $this->load->helper('language');
            $this->lang->load('form_validation', 'vietnamese');

            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('full_name', 'Tên nhân viên', 'trim|required');
            $this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');

            if ($this->form_validation->run($this)) {
                if ($this->input->post('id')) {//update
                    $err = FALSE;
                    $id = $this->input->post('id');
                    if (!$this->admin_update($id)) {
                        $err = TRUE;
                    }else{
						$row_employee = $this->M_employee->get_by_employee($id);
						if(is_array($row_employee) && !empty($row_employee)){
							$this->M_employee->update_by_employee($id, array(
								'staff_card' => $this->input->post('staff_card'),
								'address' => $this->input->post('address'),
								'phone' => $this->input->post('phone'),
								'grade' => $this->input->post('grade'),
							));
						}else{
							$this->M_employee->add_by_employee(array(
								'user_id' => $id,
								'staff_card' => $this->input->post('staff_card'),
								'address' => $this->input->post('address'),
								'phone' => $this->input->post('phone'),
								'grade' => $this->input->post('grade'),
							));
						}
					}

                    if ($err === FALSE) {
                        add_activity("Cập nhật thông tin người dùng #ID: $id!");

                        $notify_type = 'success';
                        $notify_content = 'Cập nhật thông tin thành công!';
                        $this->set_notify_admin($notify_type, $notify_content);

                        redirect(base_url($this->_module_slug));
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
                    }else{
						$this->M_employee->add_by_employee(array(
							'user_id' => $insert_id,
							'staff_card' => $this->input->post('staff_card'),
							'address' => $this->input->post('address'),
							'phone' => $this->input->post('phone'),
							'grade' => $this->input->post('grade'),
						));
					}

                    if ($err === FALSE) {
                        $row_new = $this->get($insert_id);
                        add_activities(array(
                            'action' => NULL,
                            'activity' => "Người dùng thêm người dùng #ID: $insert_id",
                            'data' => serialize(array('old' => NULL, 'new' => $row_new)),
                        ));

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
            $row = $this->get($id);

            $this->_data['row'] = $row;
            $title = 'Cập nhật thông tin - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
        }

        // $order_by = array(
        //     'order' => 'ASC',
        // );
        // $args = array();
        // $args['order_by'] = $order_by;
        // $args['status'] = 1;
        // $args['parent_id'] = 0;
        // $this->_data['access_menus'] = $this->M_menu->gets($args);

        $this->_data['type_of_departments'] = modules::run('employee/type_of_departments/gets');
		$this->_data['warehouse'] = modules::run('purchase_voucher/warehouse/gets');

        if(isset($this->_data['role']) && $this->_data['role'] == 'HR'){
            $this->config->set_item('role',array(
                'SALE_EMPLOYEE' => 'Nhân viên Sale',
            ));
        }

        $this->_data['title'] = $title;
        $this->_data['main_content'] = 'employee/admin/view_page_content';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

}

/* End of file Employee.php */
/* Location: ./application/modules/employee/controllers/Employee.php */