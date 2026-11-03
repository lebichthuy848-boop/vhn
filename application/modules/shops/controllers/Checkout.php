<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Checkout extends Layout {

    function __construct() {
        parent::__construct();
        $this->_data['breadcrumbs_module_name'] = 'Giỏ hàng';
    }

    function site_index() {
		$this->_initialize();
		
        if (!$this->cart->contents()) {
            redirect(base_url());
        }
        $this->_breadcrumbs[] = array(
            'url' => site_url('thanh-toan'),
            'name' => 'Thanh toán'
        );
        $this->set_breadcrumbs();

        $this->_data['row'] = NULL;		
		$this->_initialize_user();
        if ($this->session->has_userdata('logged_in')) {
            $this->_data['row'] = $this->M_users->get_by_username($this->_data['username']);
        }

        $this->_data['title_seo'] = 'Thanh toán' . ' - ' . $this->_data['title_seo'];
        $this->_data['main_content'] = 'layout/site/pages/checkout';
        $this->load->view('layout/site/layout', $this->_data);
    }

    function site_order_success() {
		$this->_initialize();
		
        $this->_message_success = 'Thanh toán đơn hàng thành công!';
        $this->_message_warning = 'Có lỗi xảy ra vui lòng thanh toán lại hoặc liên hệ admin!';
        $error = FALSE;

        $post = $this->input->post();
        if (empty($post)) {
            $error = TRUE;
            redirect(base_url());
        }

        if (!$this->cart->contents()) {
            $error = TRUE;
            redirect(site_url('gio-hang'));
        } else {
            $cart = $this->cart->contents();
            $order_total = $this->cart->total();
        }

        if ($error == FALSE) {
            $customer_agrs = array(
                'full_name' => $this->input->post('full_name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'user_id' => 0,
                'post_ip' => $this->input->ip_address(),
                'add_time' => time(),
            );
            $customer_id = modules::run('customers/site_add', $customer_agrs); // thêm khách hàng

            $order_code = $this->get_max_code();
            if (!modules::run('shops/orders/check_order_code_availablity', $order_code)) {
                $order_code = $this->get_max_code();
            }
            $order_agrs = array(
                'order_code' => $order_code,
                'order_email' => $this->input->post('email'),
                'order_customer_id' => $customer_id,
                'order_amount' => $order_total,
                'order_shipping' => 0,
                'order_note' => $this->input->post('order_note'),
                'delivery_method' => $this->input->post('delivery_method'),
                'forms_of_payment' => $this->input->post('forms_of_payment'),
                'admin_id' => 0,
                'order_viewed' => 0,
                'post_ip' => $this->input->ip_address(),
                'add_time' => time(),
                'expiry_time' => time() + 3600 * 24 * 3, //3 ngày
                'transaction_status' => 0,
            );
            $order_id = modules::run('shops/orders/site_add', $order_agrs); // thêm đơn hàng

            if ($order_id != 0) {
                // Thêm các sản phẩm trong giỏ hàng vào database
                foreach ($cart as $items) {
                    $order_detail_agrs = array(
                        'order_id' => $order_id,
                        'product_id' => $items['id'],
                        'quantity' => $items['qty'],
                        'price' => $items['price']
                    );
                    modules::run('shops/order_details/site_add', $order_detail_agrs); // thêm chi tiết đơn hàng
                }

                $site_name = $this->_data['site_name'];
                $subject = "Thông tin mua hàng - " . $this->_data['site_name'];

                $core_message = modules::run('shops/orders/site_html_or_view', $order_id);
                $message = $core_message;
                $data_sendmail = array(
                    'sender_email' => $this->_data['email'],
                    'sender_name' => $site_name,
                    'receiver_email' => array($customer_agrs['email'], $this->_data['email']),
                    'subject' => $subject,
                    'message' => $message
                );
                modules::run('emails/send_mail', $data_sendmail); // gửi mail
            }
            //unset session cart
            $this->cart->destroy();

            $notify_type = 'success';
            $notify_content = $this->_message_success . ' Mã đơn hàng của bạn là: ' . '<strong>' . $order_agrs['order_code'] . '</strong>';
            $this->set_notify($notify_type, $notify_content);
        } else {
            $notify_type = 'warning';
            $notify_content = $this->_message_warning;
            $this->set_notify($notify_type, $notify_content);
        }

        $this->_breadcrumbs[] = array(
            'url' => site_url('ket-qua-thanh-toan'),
            'name' => 'Kết quả thanh toán'
        );
        $this->set_breadcrumbs();

        $this->_data['title_seo'] = 'Kết quả thanh toán' . ' - ' . $this->_data['title_seo'];
        $this->_data['main_content'] = 'layout/site/pages/checkout-result';
        $this->load->view('layout/site/layout', $this->_data);
    }

    function get_max_code() {
        $order_by = array(
            'order_code' => 'DESC'
        );
        $args['order_by'] = $order_by;
        $rows = modules::run('shops/orders/gets', $args, 1, 0);
        $code = (int) (isset($rows[0]['order_code']) ? filter_var($rows[0]['order_code'], FILTER_SANITIZE_NUMBER_INT) : 0) + 1;
        return ORDER_CODE_PREFIX . str_pad($code, ORDER_CODE_LENGHT, "0", STR_PAD_LEFT);
    }

}

/* End of file checkout.php */
/* Location: ./application/modules/shops/controllers/checkout.php */
