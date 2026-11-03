<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

$config['per_page'] = 10;
$config['admin_list'] = array(
	'item' => 10,
	'total' => 100,
);
$config['author_page'] = 'profile';
$config['customer_type'] = array(
	'KL' => 'Khách lẻ',
	'KS' => 'Khách sỉ',
);
$config['customer_calculator'] = array(
	'KL' => 'retail_price',
	'KS' => 'cost_price',
);
$config['price_type'] = array(
	'retail_price' => 'Giá lẻ',
	'cost_price' => 'Giá sỉ',
);
$config['role'] = array(
	'ACCOUNTANT' => 'Kế toán',
	'SALE_ADMIN' => 'Sale Admin',
	'SALE_EMPLOYEE' => 'Nhân viên Sale',
	'SALE_MANAGER' => 'Trưởng phòng Sale',
	'HR' => 'Quản lý nhân sự',
	'WAREHOUSE_EMPLOYEE_AND_WAREHOUSE_ACCOUNTANT' => 'Nhân viên kho và kế toán kho',
	'ADMIN' => 'Ban quản trị',
);
$config['role_label'] = array(
	'ACCOUNTANT' => 'warning',
	'SALE_ADMIN' => 'info',
	'SALE_EMPLOYEE' => 'default',
	'SALE_MANAGER' => 'primary',
	'HR' => 'warning',
	'WAREHOUSE_EMPLOYEE_AND_WAREHOUSE_ACCOUNTANT' => 'warning',
    'ADMIN' => 'danger',
);
$config['role_access'] = array(
	'ROLE_GROUP_WAREHOUSE_TRANSACTION' => array('ADMIN', 'ACCOUNTANT', 'SALE_MANAGER', 'WAREHOUSE_EMPLOYEE_AND_WAREHOUSE_ACCOUNTANT'),
	'ROLE_GROUP_PURCHASE_VOUCHER' => array('ADMIN'),
	'ROLE_GROUP_OUTPUT_VOUCHER' => array('ADMIN', 'ACCOUNTANT', 'SALE_ADMIN', 'SALE_EMPLOYEE', 'SALE_MANAGER'),
	'ROLE_GROUP_PAY' => array('ADMIN', 'ACCOUNTANT'),
	'ROLE_GROUP_QUOTATION' => array('ADMIN', 'MEMBER'),
	'ROLE_GROUP_PROVIDER' => array('ADMIN', 'ACCOUNTANT', 'SALE_ADMIN', 'SALE_EMPLOYEE', 'SALE_MANAGER', 'WAREHOUSE_EMPLOYEE_AND_WAREHOUSE_ACCOUNTANT'),
	'ROLE_GROUP_EMPLOYEE' => array('ADMIN', 'HR'),
	'ROLE_GROUP_CUSTOMER' => array('ADMIN', 'ACCOUNTANT', 'SALE_ADMIN', 'SALE_EMPLOYEE', 'SALE_MANAGER'),
	'ROLE_GROUP_PRODUCT' => array('ADMIN', 'ACCOUNTANT', 'WAREHOUSE_EMPLOYEE_AND_WAREHOUSE_ACCOUNTANT'),
	'ROLE_GROUP_REPORT' => array('ADMIN'),
	'ROLE_GROUP_CONFIG' => array('ADMIN'),
);
$config['level'] = array(
	'MEMBER' => 'Thành viên',
	'RESELLER' => 'Đại lý',
	'DEALER' => 'Nhà phân phối',
	'TRADER' => 'Doanh nghiệp',
);
$config['level_label'] = array(
	'MEMBER' => 'default',
	'RESELLER' => 'info',
	'DEALER' => 'primary',
	'TRADER' => 'warning',
);
$config['purchase_voucher_type'] = array(
	'import' => 'Nhập kho',
	'transaction' => 'Chuyển kho',
);
$config['output_voucher_indebted'] = array(
	'0' => 'Đã trả',
	'1' => 'Còn nợ',
);
$config['output_voucher_status'] = array(
	'0' => 'Đã yêu cầu',
	'1' => 'Đơn hàng thành công',
	'-1' => 'Đã hủy',
);
$config['output_voucher_order_status'] = array(
	'0' => 'Chưa thanh toán',
	'1' => 'Đã thanh toán',
);
$config['output_voucher_order_status_label'] = array(
	'0' => 'default',
	'1' => 'success',
);
$config['output_voucher_delivery_status'] = array(
	'0' => 'Hàng đã sẵn sàng',
	'1' => 'Hàng đang trên đường',
	'2' => 'Hàng đã giao',
	'-1' => 'Đơn hàng hủy',
);
$config['output_voucher_delivery_status_label'] = array(
	'0' => 'default',
	'1' => 'info',
	'2' => 'success',
	'-1' => 'danger',
);
$config['gender'] = array(
	'default' => 'N',
	'data' => array(
		"N" => "N/A",
		"M" => "Nam",
		"F" => "Nữ",
	),
);
$config['default_avatar'] = 'no_avatar.jpg';
$config['date_unit'] = array(
    'day' => 'Ngày',
    // 'week' => 'Tuần',
    'month' => 'Tháng',
    'year' => 'Năm',
);
$config['date_unit_type'] = array(
    'day' => 'success',
    // 'week' => 'primary',
    'month' => 'info',
    // 'year' => 'default',
    'year' => 'primary',
);
$config['users_modules_commission'] = array(
	'BUY' => 'Mua hàng',
	'SUB_BUY_MY' => 'Nhận phần trăm từ mua hàng',
	'SUB_BUY_ROOT' => 'Nhận phần trăm trực tiếp từ cấp dưới mua hàng',
);
$config['users_modules_commission_label'] = array(
	'BUY' => 'danger',
	'SUB_BUY_MY' => 'success',
	'SUB_BUY_ROOT' => 'success',
);
$config['users_modules_notification'] = array(
	'USER_BUY' => 'Thành viên mua hàng',
	'USER_COMMISSION_BUY' => 'Nhận phần trăm từ hoa hồng mua hàng',
	'USER_COMMISSION' => 'Nhận phần trăm từ cấp dưới mua hàng',
	'USER_BUY_PACKAGE' => 'Thành viên mua gói',
	'USER_COMMISSION_BUY_PACKAGE' => 'Nhận phần trăm hoa hồng từ mua thẻ thành viên',
	'USER_SELL' => 'Đối tác bán hàng',
	'USER_PAY_IN' => 'Nạp tiền vào tài khoản',
	'USER_COMMISSION_BUY_REFERRED_PARTNER' => 'Nhận phần trăm từ đối tác giới thiệu bán hàng',
);
$config['users_modules_notification_label'] = array(
	'USER_BUY' => 'danger',
	'USER_COMMISSION_BUY' => 'success',
	'USER_COMMISSION' => 'success',
	'USER_BUY_PACKAGE' => 'danger',
	'USER_COMMISSION_BUY_PACKAGE' => 'success',
	'USER_SELL' => 'info',
	'USER_PAY_IN' => 'primary',
	'USER_COMMISSION_BUY_REFERRED_PARTNER' => 'success',
);