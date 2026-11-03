<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Orders extends Layout {

    function __construct() {
        parent::__construct();
        $this->load->model('m_shops_orders', 'M_shops_orders');
        $this->_data['breadcrumbs_module_name'] = 'Đơn đặt hàng';
    }

    function cart() {
		$this->_initialize();

        $this->_breadcrumbs[] = array(
            'url' => current_url(),
            'name' => 'Giỏ hàng'
        );
        $this->_data['breadcrumbs'] = $this->_breadcrumbs;

        $this->_data['title_seo'] = 'Giỏ hàng' . ' - ' . $this->_data['title_seo'];
        $this->_data['main_content'] = 'layout/site/pages/cart';
        $this->load->view('layout/site/layout', $this->_data);
    }

    function site_add($args) {
        return $this->M_shops_orders->add($args);
    }

    function or_view() {
		$this->_initialize_admin();
        $this->redirect_admin();
		
        $this->load->module('users');
        $this->_message_success = 'Xác nhận thanh toán thành công!';
        $this->_message_danger = 'Lỗi kỹ thuật, vui lòng kiểm tra lại!';
        $this->_message_warning = 'Đơn hàng này không tồn tại!';
        $this->_message_banned = 'Bạn không có quyền truy cập vào khu vực này!';
        if ($this->users->validate_admin_logged_in() == TRUE) {
            $post = $this->input->post();

            $this->_plugins_script_admin[] = array(
                'folder' => 'bootbox',
                'name' => 'bootbox'
            );
            $this->_plugins_script_admin[] = array(
                'folder' => 'jQuery-Plugin-To-Print-Any-Part-Of-Your-Page-Print',
                'name' => 'jQuery.print'
            );
            $this->set_plugins_admin();

            $this->_modules_script[] = array(
                'folder' => 'shops',
                'name' => 'admin-or-view'
            );
            $this->set_modules();

            $order_id = ($this->uri->segment(4) == '') ? 0 : $this->uri->segment(4); # Lấy id giỏ hàng
            $order = $this->get($order_id); //lấy thông tin giỏ hàng
            $this->_data['order'] = $order;

            $customer = modules::run('customers/get', $order["order_customer_id"]); // lấy thông tin khách hàng
            $this->_data['customer'] = $customer;

            $order_items = modules::run('shops/order_details/get_data_in_order_id', $order_id); // lấy các sản phẩm có id giỏ hàng

            $products = array();

            foreach ($order_items as $value) {
                $arr = modules::run('shops/rows/get', $value['product_id']); // lấy thông tin chi tiết các sản phẩm có trong giỏ hàng
                $arr['quantity'] = $value["quantity"];
                $arr['price_curent'] = $value["price"];
                $products[] = $arr;
            }
            $this->_data['products'] = $products;
            $this->_data['breadcrumbs_module_func'] = 'Xem đơn hàng';
            $this->_data['title'] = 'Xem đơn hàng' . ' ' . $order['order_code'] . ' - ' . $this->_data['title'] . ' Admin';

            if (!empty($post)) {
                if ($this->input->post('ajax') == '1') {
                    if ($this->input->post('get_data') == '1') {
                        $this->load->view('shops/admin/view_page_or_view', $this->_data);
                    } else {
                        $order_id = $this->input->post('order_id');
                        if ($order_id != 0) {
                            $data = array(
                                'transaction_status' => 4
                            );
                            if ($this->M_shops_orders->update($order_id, $data)) {
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
                    }
                } else {
                    $order_id = $this->input->post('order_id');
                    if ($order_id != 0) {
                        $data = array(
                            'transaction_status' => 4
                        );
                        if ($this->M_shops_order->update($order_id, $data)) {

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
                    redirect(get_admin_url('shops/or_view/' . $order_id));
                }
            } else {
                if (isset($order['order_viewed']) && $order['order_viewed'] != 1) {
                    $this->M_shops_orders->update($order['order_id'], array('order_viewed' => 1, 'view_time' => time()));
                }
                $this->_data['main_content'] = 'shops/admin/view_page_or_view';
                $this->load->view('layout/admin/view_layout', $this->_data);
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
                redirect(get_admin_url('orders'));
            }
        }
    }

    function site_html_or_view($order_id = 0) {
        $order = $this->get($order_id); //lấy thông tin giỏ hàng
        $this->_data['order'] = $order;

        $customer = modules::run('customers/get', $order["order_customer_id"]); // lấy thông tin khách hàng
        $this->_data['customer'] = $customer;

        $order_items = modules::run('shops/order_details/get_data_in_order_id', $order_id); // lấy các sản phẩm có id giỏ hàng

        $products = array();

        foreach ($order_items as $value) {
            $arr = modules::run('shops/rows/get', $value['product_id']); // lấy thông tin chi tiết các sản phẩm có trong giỏ hàng
            $arr['quantity'] = $value["quantity"];
            $arr['price_curent'] = $value["price"];
            $products[] = $arr;
        }
        $this->_data['products'] = $products;
        return $this->load->view('layout/site/partial/html-template-order', $this->_data, true);
    }

    function gets($args, $perpage = 5, $offset = -1) {
        return $this->M_shops_orders->gets($args, $perpage, $offset);
    }

    function counts($args) {
        return $this->M_shops_orders->counts($args);
    }

    function get($order_id) {
        return $this->M_shops_orders->get($order_id);
    }

    function check_order_code_availablity($order_code = '') {
        $this->load->model('m_shops_orders', 'M_shops_orders');
        return $this->M_shops_orders->check_order_code_availablity($order_code);
    }

    function default_args() {
        $order_by = array(
            'add_time' => 'DESC'
        );
        $args = array();
        $args['order_by'] = $order_by;

        return $args;
    }

    function num_rows_new() {
        $this->load->model('m_shops_orders', 'M_shops_orders');
        $args['order_viewed'] = 0;
        return $this->counts($args);
    }

    function index() {
		$this->_initialize_admin();
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
            'folder' => 'shops',
            'name' => 'admin-order'
        );
        $this->set_modules();

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $args = $this->default_args();

        if (isset($get['q']) && trim($get['q']) != '') {
            $args['order_code'] = $get['q'];
        }

        $total = $this->counts($args);
        $perpage = isset($get['per_page']) ? $get['per_page'] : $this->config->item('per_page');

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

        $config['next_link'] = $this->lang->line('next_page') . ' &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&larr; ' . $this->lang->line('prev_page');
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        $config['base_url'] = get_admin_url('orders');
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);  # Khởi tạo phân trang

        $pagination = $this->pagination->create_links(); # Tạo link phân trang
        $offset = ($this->uri->segment(3) == '') ? 0 : $this->uri->segment(3); # Lấy offset
        # Đẩy dữ liệu ra view
        $this->_data['rows'] = $this->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;

        $this->_data['breadcrumbs_module_func'] = 'Danh sách đơn đặt hàng';
        $this->_data['title'] = 'Đơn đặt hàng' . ' - ' . $this->_data['title'];
        $this->_data['main_content'] = 'shops/admin/view_page_order';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function update_transaction_status($order_id, $transaction_status) {
        $data = array(
            'transaction_status' => $transaction_status
        );

        return $this->M_shops_orders->update($order_id, $data);
    }

    function delete() {
        $this->_initialize_admin();
        $this->redirect_admin();
		
        $id = ($this->uri->segment(4) == '') ? 0 : $this->uri->segment(4);
        if ($id != 0) {
            $row = $this->get($id);
            if ($row['transaction_status'] == 0) {
                if ($this->M_shops_orders->delete($id)) {
                    modules::run('shops/order_details/admin_delete', $row["order_id"]); // xóa chi tiết đơn hàng
                    modules::run('customers/admin_delete', $row["order_customer_id"]); // xóa khách hàng
                    $notify_type = 'success';
                    $notify_content = "Đã xóa đơn đặt hàng!";
                } else {
                    $notify_type = 'danger';
                    $notify_content = " Đơn đặt hàng chưa được xóa!";
                }
            } else {
                $notify_type = 'danger';
                $notify_content = 'Không thể xóa đơn hàng này!';
            }
        } else {
            $notify_type = 'warning';
            $notify_content = " Đơn đặt hàng này không tồn tại!";
        }
        $this->set_notify_admin($notify_type, $notify_content);
        redirect(get_admin_url('orders'));
    }

    function get_num_all_data() {
        $args = $this->default_args();
        return $this->counts($args);
    }

    function get_num_new_data() {
        $args = $this->default_args();
        $args['order_viewed'] = 0;
        return $this->counts($args);
    }

    function get_data_in_customer_id($customer_id = 0) {
        $args = $this->default_args();
        $args['order_user_id'] = $customer_id;
        return $this->gets($args);
    }

}

/* End of file orders.php */
/* Location: ./application/modules/shops/controllers/orders.php */