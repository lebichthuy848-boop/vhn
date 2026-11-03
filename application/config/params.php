<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['api'] = array(
	'url' => 'https://ledu.vn/',
	'domain' => 'vhngroup.vn',
	'secret' => 'wHc2NcdK16JFVyrcZYH4MBbc2rE77BEO',
);
$config['facebook'] = array(
    'app_id' => '124350198151002',
    'app_secret' => '5aa3c4ceea848e3a9bc9bec1d41525a0'
);
$config['site_per_page'] = array(
    'posts' => 12,
);
$config['user_role'] = array(
	'USER' => 'USER',
	'AMIN' => 'ADMIN',
);
$config['user_level'] = array(
	'MEMBER' => 'Member',
	'RESELLER' => 'Reseller',
	'DEALER' => 'Dealer',
	'TRADER' => 'Trader',
);
$config['toolbar'] = array(
	'full' => array(
		array('Source', 'Undo', 'Redo', '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat'),
		array('Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'),
		array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'),
		array('JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'),
		array('Link', 'Unlink'),
		array('Image', 'Table', 'HorizontalRule'),
		array('Styles', 'Format', 'Font', 'FontSize'),
		array('TextColor', 'BGColor')
	),
	'mini' => array(
		array('Bold', 'Italic', 'Underline', 'Strike'),
		array('Link', 'Unlink'),
		array('Styles', 'Format', 'Font', 'FontSize'),
		array('TextColor', 'BGColor')
	),
);
$config['per_page'] = 9;
$config['gender'] = array(
    'default' => 'N',
    'data' => array(
        "N" => "N/A",
        "M" => "Nam",
        "F" => "Nữ",
    )
);
$config['oauth_provider'] = array(
	'system' => 'Hệ thống',
	'google' => 'Google',
	'facebook' => 'Facebook',
);
$config['delivery_method'] = array(
    '1' => 'Giao tận nhà',
    '2' => 'Khách nhận hàng tại công ty',
);
/*
$config['forms_of_payment'] = array(
    '1' => 'Thanh toán tiền mặt',
    '2' => 'Chuyển khoản',
);
*/
$config['forms_of_payment'] = array(
    'cod' => array(
		'title' => 'Thanh toán tiền mặt khi nhận hàng',
		'info' => 'Thanh toán trực tiếp cho người vận chuyển, ngay sau khi nhận được hàng'
	),
    'bacs' => array(
		'title' => 'Chuyển khoản ngân hàng',
		'info' => 'Thực hiện thanh toán vào ngay tài khoản ngân hàng của chúng tôi. Thông tin về tài khoản ngân hàng sẽ hiển thị khi bạn hoàn tất đơn hàng.'
	),
	'cheque' => array(
		'title' => 'Thanh toán tại cửa hàng',
		'info' => '28A Đường số 60, P. Thảo Điền, Q.2, Tp. HCM.'
	),
);
$config['email_type'] = array(
    'post' => 'Tin tức',
    'page' => 'Trang tĩnh',
    'contact' => 'Liên hệ',
);
$config['images_modules'] = array(
	'slideshow' => 'Slide show',
	'slideshow_store' => 'Slide show Trang Store',
  'avarta_member' => 'Ảnh đại diện thành viên',
  'obm' => 'Original Brand Manufacturing',
  'procedure_obm' => 'Quy trình tư vấn OBM',
	'research' => 'Nghiên cứu',
	'brands' => 'Thương hiệu',
	'brands_block' => 'Thương hiệu chi tiết',
	'pages_abouts_block' => 'Giới thiệu chi tiết',
	'pages_partner_block' => 'Giới thiệu chi tiết - Đối tác',
	'build_brands' => 'Xây dựng thương hiệu',
	'activate_pages' => 'Đại diện hoạt động',
  'introdues' => 'Giới thiệu',
	'bannerbottom' => 'Banner Bottom',
	'partner' => 'Đối tác',
	'service' => 'Dịch vụ',
	'advertise' => 'Quảng cáo',
	'support_online' => 'Hổ trợ trực tuyến',
);
$config['info_modules'] = array(
  'name_company' => 'Tên công ty',
  'contact_map' => 'Thông tin liên hệ bản đồ liên hệ',
  'value_core' => 'Giá trị cốt lõi',
  'hotline_header' => 'Hotline Header Top',
  'introdues' => 'Giới thiệu',
  'hotline' => 'Hotline',
  'address' => 'Địa chỉ',
  'timework' => 'Thời gian làm việc',
  'call_us' => 'Gọi điện cho chúng tôi',
  'copyright' => 'Copyright',
  'contact' => 'Liên hệ',
  'contact_footer' => 'Liên hệ footer',
  'certify' => 'Chứng nhận',
  'partner' => 'Đối tác',
  'introdues' => 'Giới thiệu về chúng tôi',
  'address_north' => 'Chi nhánh Miền Bắc',
  'address_central' => 'Chi nhánh Miền Trung',
  'address_south' => 'Chi nhánh Miền Nam',
);
$config['menu_modules'] = array(
	'Main' => 'Menu chính',
	'Top' => 'Menu store',
);
$config['posts_modules_cat_type'] = array(
	'NEWS' => 'Tin tức',
	'SERVICE' => 'Dịch vụ',
	'KNOWLEDGE' => 'Kiến thức',
	'APPLICATION' => 'Ứng dụng',
	'SOLUTION' => 'Giải pháp phục hồi và bảo vệ bề mặt',
);
$config['shops_modules_cat_sort'] = array(
	'items' => array(
	    'manual' => 'Featured',
	    'best-selling' => 'Best Selling',
	    'title-ascending' => 'Alphabetically, A-Z',
	    'title-descending' => 'Alphabetically, Z-A',
	    'price-ascending' => 'Price, low to high',
	    'price-descending' => 'Price, high to low',
	    'created-descending' => 'Date, new to old',
	    'created-ascending' => 'Date, old to new',
	),
	'default' => 'best-selling'
);

$config['pages_modules_type'] = array(
	'default' => 'Mặc định',
	'brands' => 'Thương hiệu',
	'abouts' => 'Giới thiệu',
	'obm' => 'Original Brand Manufacturing'
);
$config['stock_status'] = array(
    'instock' => 'Còn hàng',
    'outofstock' => 'Hết hàng',
    'onbackorder' => 'Chờ hàng'
);
$config['stock_status_display'] = array(
    'instock' => '<div class="stock in-stock"><i class="far fa-check-circle"></i> Còn hàng</div>',
    'outofstock' => '<div class="stock out-stock"><i class="far fa-times-circle"></i> Hết hàng</div>',
    'onbackorder' => '<div class="stock wait-stock"><i class="far fa-clock"></i> Đang chờ</div>'
);
