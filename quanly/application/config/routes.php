<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  | example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  | http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  | $route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  | $route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  | $route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples: my-controller/index -> my_controller/index
  |   my-controller/my-method -> my_controller/my_method
 */
$route['default_controller'] = "layout";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['barcode'] = "layout/barcode";
$route['barcode/download'] = "products/download";
/*
 * MODULES USERS
  ======================================================================================================
 * ADMIN
 * ////////////////////////////////////////////////////////////////////////////////////////////////////
 * Thao tác tài khoản đăng nhập (admin)
 */
$route['admin'] = 'layout/index_admin';
$route['admin/logout'] = 'users/logout';
/*
 * Kiểm tra tồn tại username, email tài khoản update (admin - ajax)
 */
$route['admin/users/check_current_username_availablity'] = 'users/check_current_username_availablity';
$route['admin/users/check_current_email_availablity'] = 'users/check_current_email_availablity';
/*
 * Kiểm tra tồn tại username, email tài khoản add (admin - ajax)
 */
$route['admin/users/check_username_availablity'] = 'users/check_username_availablity';
$route['admin/users/check_email_availablity'] = 'users/check_email_availablity';
/*
 * Danh sách tài khoản (admin - phân trang)
 */
$route['admin/users'] = 'users/index';
$route['admin/users/(:num)'] = 'users/index/$1';
/*
 * Danh sách tài khoản đợi kích hoạt (admin - phân trang)
 */
$route['admin/users/user_waiting'] = 'users/user_waiting';
$route['admin/users/user_waiting/(:num)'] = 'users/user_waiting/$1';
/*
 * Kích hoạt thành viên (admin - ajax)
 */
$route['admin/users/active'] = 'users/active';
/*
 * Thêm, sửa tài khoản (admin - CU)
 */
$route['admin/users/user_add'] = 'users/admin_user_add';
$route['admin/users/user_add/(:num)'] = 'users/user_add/$1';
/*
 * Xóa tài khoản (D)
 */
$route['admin/users/delete'] = 'users/admin_delete';
/*
 * Nhóm thành viên tài khoản (admin)
 */
$route['admin/users/groups'] = 'users/groups/index';
/*
 * Nội quy thành viên (admin)
 */
$route['admin/users/siteterms'] = 'users/users_config/admin_siteterms';
/*
 * Cấu hình module tài khoản (admin)
 */
$route['admin/users/config'] = 'users/users_config/admin_config';
/*
 * Cấu hình sửa thông tài khoản của admin
 */
$route['admin/users/profile'] = 'users/admin_profile';
$route['admin/users/profile-edit'] = 'users/admin_profile_edit';
$route['profile'] = 'users/admin_profile';


/*
 * MODULES CART
  ======================================================================================================
 * ADMIN
/*
 * Danh sách đơn hàng (admin - phân trang)
 */
$route['admin/orders'] = "shops/orders/index";
$route['admin/orders/([0-9\-]+)'] = 'shops/orders/index/$1';
/*
 * Xem chi tiết đơn hàng (admin - R)
 */
$route['admin/orders/or_view/([0-9\-]+)'] = 'shops/orders/or_view/$1';

/*
 * Xóa đơn hàng (admin - D)
 */
$route['admin/orders/delete/([0-9\-]+)'] = "shops/orders/delete/$1";



/*
 * MODULES SHOPS
  ======================================================================================================
 * ADMIN
 * ////////////////////////////////////////////////////////////////////////////////////////////////////
 * Lấy alias (liên kết tĩnh) bằng ajax
 */
$route['admin/shops/alias'] = "layout/get_alias";
$route['admin/shops/cat/alias'] = "layout/get_alias";
/*
 * Kiểm tra tồn tại mã sản phẩm (admin - ajax)
 */
$route['admin/shops/check_current_product_code_availablity'] = 'shops/rows/check_current_product_code_availablity';
$route['admin/shops/check_product_code_availablity'] = 'shops/rows/check_product_code_availablity';
/*
 * Kiểm tra tồn tại liên kết tĩnh loại sản phẩm (admin - ajax)
 */
$route['admin/shops/cat/check_current_alias_availablity'] = 'shops/cat/check_current_alias_availablity';
$route['admin/shops/cat/check_alias_availablity'] = 'shops/cat/check_alias_availablity';
/*
 * Loại sản phẩm
 */
$route['admin/shops/cat/main'] = 'shops/cat/admin_main';
$route['admin/shops/cat/content'] = "shops/cat/admin_content";
$route['admin/shops/cat/content/([0-9\-]+)'] = 'shops/cat/admin_content/$1';
$route['admin/shops/cat'] = "shops/cat/admin_index";
$route['admin/shops/cat/delete/(:num)'] = 'shops/cat/admin_delete/$1';


/*
 * Danh sách sản phẩm (admin - phân trang)
 */
$route['admin/shops/items'] = 'shops/rows/admin_index';
$route['admin/shops/items/([0-9\-]+)'] = 'shops/rows/admin_index/$1';
/*
 * Thao tác sản phẩm (admin - CUD)
 */
$route['admin/shops/content'] = 'shops/rows/admin_content'; //thêm
$route['admin/shops/content/(:num)'] = 'shops/rows/admin_content/$1'; //sửa
$route['admin/shops/delete'] = "shops/rows/admin_delete"; //xóa
/*
 * Thực thi tùy chọn các sản phẩm
 */
$route['admin/shops/main'] = 'shops/rows/admin_main';

/*
 * Đơn vị sản phẩm (admin)
 */
$route['admin/shops/prounit'] = 'shops/units/index';
$route['admin/shops/prounit/delete'] = 'shops/units/delete';

/*
 * Đơn vị tiền tệ (admin)
 */
$route['admin/shops/money'] = 'shops/money/index';
$route['admin/shops/money/delete'] = 'shops/money/delete';

/*
 * Danh sách hãng sản xuất (admin)
 */
$route['admin/shops/sources'] = 'shops/sources/index';

/*
 * Thao tác hãng sản xuất (admin - CRUD)
 */
$route['admin/shops/sources/(:num)'] = 'shops/sources/index/$1';
$route['admin/shops/sources/delete/(:num)'] = 'shops/sources/delete/$1';
/*
 * Cấu hình module giỏ hàng (admin)
 */
$route['admin/shops/config'] = 'shops/shops_config/admin_config';



/*
 * MODULES customers
  ======================================================================================================
 * ADMIN
 * ////////////////////////////////////////////////////////////////////////////////////////////////////
  /*
 * Danh sách khách hàng (admin - phân trang)
 */
$route['admin/customers'] = "customers/admin_index";
$route['admin/customers/([0-9\-]+)'] = "customers/admin_index/$1";


/*
 * MODULES CONFIGS
  ======================================================================================================
 * ADMIN
 * ////////////////////////////////////////////////////////////////////////////////////////////////////
 * Cấu hình chung, cấu hình site
 */
$route['admin/settings'] = 'configs/index';
$route['admin/settings/main'] = 'configs/main';


/*
 * MODULES GROUP (Nhóm Hàng)
  ======================================================================================================
 * ADMIN
 * ////////////////////////////////////////////////////////////////////////////////////////////////////
 * Thêm, xóa, sửa thông tin hỗ trợ
 */
$route['admin/group'] = 'group/admin_index'; // danh sách
$route['admin/group/(:num)'] = 'group/admin_index/$1'; // danh sách phân trang
$route['admin/group/content'] = 'group/admin_content'; //thêm
$route['admin/group/content/(:num)'] = 'group/admin_content/$1'; //sửa
$route['admin/group/delete'] = 'group/admin_delete'; //xóa (dùng get)
$route['admin/group/main'] = 'group/admin_main'; // danh sách


/*
 * MODULES CONSIGNMENT (Hàng Hóa)
  ======================================================================================================
 * ADMIN
 * ////////////////////////////////////////////////////////////////////////////////////////////////////
 * Thêm, xóa, sửa
 */
$route['admin/consignment'] = 'consignment/admin_index'; // danh sách
$route['admin/consignment/(:num)'] = 'consignment/admin_index/$1'; // danh sách phân trang
$route['admin/consignment/content'] = 'consignment/admin_content'; //thêm
$route['admin/consignment/content/(:num)'] = 'consignment/admin_content/$1'; //sửa
$route['admin/consignment/delete'] = 'consignment/admin_delete'; //xóa (dùng get)
$route['admin/consignment/main'] = 'consignment/admin_main'; // danh sách


/*
 * MODULES PROVIDER (Nhà Cung Cấp)
  ======================================================================================================
 * ADMIN
 * ////////////////////////////////////////////////////////////////////////////////////////////////////
 * Thêm, xóa, sửa
 */
$route['admin/provider'] = 'provider/admin_index'; // danh sách
$route['admin/provider/(:num)'] = 'provider/admin_index/$1'; // danh sách phân trang
$route['admin/provider/content'] = 'provider/admin_content'; //thêm
$route['admin/provider/content/(:num)'] = 'provider/admin_content/$1'; //sửa
$route['admin/provider/delete'] = 'provider/admin_delete'; //xóa (dùng get)
$route['admin/provider/main'] = 'provider/admin_main'; // danh sách

/*
 * MODULES EMPLOYEE (Nhân Viên)
  ======================================================================================================
 * ADMIN
 * ////////////////////////////////////////////////////////////////////////////////////////////////////
 * Thêm, xóa, sửa
 */
$route['admin/employee'] = 'employee/admin_index'; // danh sách
$route['admin/employee/(:num)'] = 'employee/admin_index/$1'; // danh sách phân trang
$route['admin/employee/content'] = 'employee/admin_content'; //thêm
$route['admin/employee/content/(:num)'] = 'employee/admin_content/$1'; //sửa
$route['admin/employee/delete'] = 'employee/admin_delete'; //xóa (dùng get)
$route['admin/employee/main'] = 'employee/admin_main'; // danh sách


/*
 * MODULES DELIVERY_NOTE (Phiếu Chuyển Kho)
  ======================================================================================================
 * ADMIN
 * ////////////////////////////////////////////////////////////////////////////////////////////////////
 * Thêm, xóa, sửa
 */
$route['admin/delivery-note'] = 'delivery_note/admin_index'; // danh sách
$route['admin/delivery-note/(:num)'] = 'delivery_note/admin_index/$1'; // danh sách phân trang
$route['admin/delivery-note/content'] = 'delivery_note/admin_content'; //thêm
$route['admin/delivery-note/content/(:num)'] = 'delivery_note/admin_content/$1'; //sửa
$route['admin/delivery-note/delete'] = 'delivery_note/admin_delete'; //xóa (dùng get)
$route['admin/delivery-note/main'] = 'delivery_note/admin_main'; // danh sách


/*
 * MODULES RECEIPT (Phiếu Chi Tiền)
  ======================================================================================================
 * ADMIN
 * ////////////////////////////////////////////////////////////////////////////////////////////////////
 * Thêm, xóa, sửa
 */
$route['admin/receipt'] = 'receipt/admin_index'; // danh sách
$route['admin/receipt/(:num)'] = 'receipt/admin_index/$1'; // danh sách phân trang
$route['admin/receipt/content'] = 'receipt/admin_content'; //thêm
$route['admin/receipt/content/(:num)'] = 'receipt/admin_content/$1'; //sửa
$route['admin/receipt/delete'] = 'receipt/admin_delete'; //xóa (dùng get)
$route['admin/receipt/main'] = 'receipt/admin_main'; // danh sách


/*
 * MODULES STORE ISUED VOUCHER (Đơn Hàng Bán)
  ======================================================================================================
 * ADMIN
 * ////////////////////////////////////////////////////////////////////////////////////////////////////
 * Thêm, xóa, sửa
 */
$route['admin/store-isued-voucher'] = 'store_isued_voucher/admin_index'; // danh sách
$route['admin/store-isued-voucher/(:num)'] = 'store_isued_voucher/admin_index/$1'; // danh sách phân trang
$route['admin/store-isued-voucher/content'] = 'store_isued_voucher/admin_content'; //thêm
$route['admin/store-isued-voucher/content/(:num)'] = 'store_isued_voucher/admin_content/$1'; //sửa
$route['admin/store-isued-voucher/delete'] = 'store_isued_voucher/admin_delete'; //xóa (dùng get)
$route['admin/store-isued-voucher/main'] = 'store_isued_voucher/admin_main'; // danh sách

/*
 * MODULES STORE RECEIVED VOUCHER (Đơn Hàng Nhập)
  ======================================================================================================
 * ADMIN
 * ////////////////////////////////////////////////////////////////////////////////////////////////////
 * Thêm, xóa, sửa
 */
$route['admin/store-received-voucher/get_calculator_ajax'] = 'store_received_voucher/ajax_get_calculator';
$route['admin/store-received-voucher/get_consignment_ajax'] = 'store_received_voucher/ajax_get_consignment';
$route['admin/store-received-voucher/get_provider_ajax'] = 'store_received_voucher/ajax_get_provider';
$route['admin/sell_buy/get_customer_ajax'] = 'sell_buy/ajax_get_customer';

$route['admin/store-received-voucher'] = 'store_received_voucher/admin_index'; // danh sách
$route['admin/store-received-voucher/(:num)'] = 'store_received_voucher/admin_index/$1'; // danh sách phân trang
$route['admin/store-received-voucher/content'] = 'store_received_voucher/admin_content'; //thêm
$route['admin/store-received-voucher/content/(:num)'] = 'store_received_voucher/admin_content/$1'; //sửa
$route['admin/store-received-voucher/delete'] = 'store_received_voucher/admin_delete'; //xóa (dùng get)
$route['admin/store-received-voucher/main'] = 'store_received_voucher/admin_main'; // danh sách


$route['admin/report/buy'] = 'dashboard/report_buy'; //bán hàng
$route['admin/report/sell'] = 'dashboard/report_sell'; //mua hàng
$route['admin/report/import-export-inventories'] = 'dashboard/report_import_export_inventories'; //mua hàng

$route['admin/sell-buy/buy'] = 'dashboard/buy'; //bán hàng
$route['admin/sell-buy/sell'] = 'dashboard/sell'; //mua hàng
$route['admin/sell-buy/stock-translocation'] = 'sell_buy/admin_stock_translocation'; //chuyển kho
$route['admin/sell-buy/receipts-and-expenses'] = 'sell_buy/admin_receipts_and_expenses'; //thu chi

/*
 * Mua
 */
$route['admin/sell-buy/buy/store-received-voucher'] = 'sell_buy/admin_store_received_voucher'; //Tạo phiếu nhập hàng
$route['admin/sell-buy/buy/return-provider'] = 'sell_buy/admin_return_provider'; //Trả lại nhà cung cấp

/*
 * Bán
 */
$route['admin/sell-buy/sell/retail'] = 'sell_buy/admin_retail'; //Bán lẻ
$route['admin/sell-buy/sell/wholesale'] = 'sell_buy/admin_wholesale'; //Bán sỉ
$route['admin/sell-buy/sell/return-customer'] = 'sell_buy/admin_return_customer'; //Khách hàng trả lại
$route['admin/sell-buy/sell/create-view-quotation'] = 'sell_buy/admin_create_view_quotation'; //Tạo xem bảng báo giá

/*
 * Báo cáo
 */
/*
 * Bán
 */
$route['admin/report/create_excel_file'] = 'report/create_excel_file'; //Đơn hàng bán/trả hàng
$route['admin/report/sell/order-sell-return'] = 'report/admin_order_sell_return'; //Đơn hàng bán/trả hàng
$route['admin/report/sell/products-bestsellers'] = 'report/admin_products_bestsellers'; //Sản phẩm bán chạy

/*
 * Mua
 */
$route['admin/report/buy'] = 'report/admin_buy'; //Mua

/*
 * Nhập - xuất - tồn
 */
$route['admin/report/import-export-inventories/translocation'] = 'report/admin_translocation'; //Chi tiết hàng chuyển
$route['admin/report/import-export-inventories/import'] = 'report/admin_import'; //Chi tiết hàng nhập
$route['admin/report/import-export-inventories/export'] = 'report/admin_export'; //Chi tiết hàng xuất
$route['admin/report/import-export-inventories/inventories'] = 'report/admin_inventories'; //Báo cáo tồn kho

$route['captcha'] = "captcha/index";
$route['captcha/refresh'] = "captcha/index";

$route['newsletter'] = "newsletter/index";

/*
 * MODULES USERS
  ======================================================================================================
 * FRONT-END
 * ////////////////////////////////////////////////////////////////////////////////////////////////////
 * Thao tác thành viên
 */
$route['forget-password'] = "users/site_forget_password";
$route['reset-password'] = "users/site_reset_password";
$route['register'] = "users/site_register";
$route['login'] = "users/site_login";
$route['login-by/(:num)'] = 'users/login_by/$1';
$route['logout'] = "users/logout";

//sitemap
$route['sitemap'] = "sitemap/admin_add";
$route['rss'] = "rss/vn";
$route['rss/rss-xml'] = "rss/write_xml";

$route['blog-post/(:any)'] = "posts/ajax_site_load_more_item_in_cat/$1";
$route['posts-cat-ajax/(:any)'] = "posts/ajax_site_load_more_item_in_cat/$1";

$route['compare/add/(:any)'] = "shops/rows/site_add_compare/$1";
$route['compare/delete/(:any)'] = "shops/rows/site_delete_compare/$1";
$route['compare/(:any)'] = "shops/rows/site_compare/$1";

$route['abc'] = "shops/rows/abc";
$route['abc/(:any)'] = "shops/rows/abc/$1";

$route['checkout'] = "shops/checkout/site_index";
$route['checkout/(:any)'] = "shops/checkout/site_index/$1";
/*
 * Sửa thông tin thành viên
 */
$route['users/main'] = "users/site_main";
$route['users/editinfo'] = "users/site_editinfo";
$route['users/changepass'] = "users/site_changepass";
$route['users/check_current_password_availablity'] = 'users/check_current_password_availablity';
/*
 * Kiểm tra tồn tại username, email tài khoản update (admin - ajax)
 */
$route['users/check_current_username_availablity'] = 'users/check_current_username_availablity';
$route['users/check_current_email_availablity'] = 'users/check_current_email_availablity';
/*
 * Kiểm tra tồn tại username, email tài khoản add (admin - ajax)
 */
$route['users/check_username_availablity'] = 'users/check_username_availablity';
$route['users/check_email_availablity'] = 'users/check_email_availablity';

$route['files/crop_image_ajax'] = "files/crop";
$route['files/upload_ajax'] = "files/upload_ajax";


/*
 * MODULES SHOPS
  ======================================================================================================
 * FRONT-END
 * ////////////////////////////////////////////////////////////////////////////////////////////////////
 * Tìm kiếm sản phẩm (phân trang)
 */
//$route['search'] = "shops/rows/site_search";
//$route['search/(:num)'] = "shops/rows/site_search/$1";

$route['search'] = "search/index";
$route['search/(:num)'] = "search/index/$1";
/*
 * Rating
 */
$route['shops/rating/add'] = "shops/rating/site_add";
/*
 * Lấy html đơn hàng để gửi mail
 */
$route['shops/get-html-payment'] = "shops/orders/site_html_payment";

/*
 * Tìm kiếm sản phẩm nâng cao (phân trang)
 */
$route['shops/advanced_search'] = "shops/rows/site_advanced_search";
$route['shops/advanced_search/(:num)'] = "shops/rows/site_advanced_search/$1";

/*
 * Danh sách sản phẩm yêu thích
 */
$route['wishlist'] = "shops/rows/site_rows_likes";
$route['wishlist/(:num)'] = "shops/rows/site_rows_likes/$1";
/*
 * Thao tác sản phẩm yêu thích (CD)
 */
$route['shops/like'] = "shops/likes/add";
$route['shops/like/delete'] = "shops/likes/delete";
/*
 * Giỏ hàng
 */
$route['shops/cart'] = "shops/orders/cart";

/*
 * Lịch sử đặt hàng
 */
$route['order-history'] = "shops/order/order_history";
$route['order-history/(:num)'] = "shops/order/order_history/$1";
/*
 * Xóa sản phẩm khỏi giỏ hàng (ajax)
 */
$route['shops/cart/remove-item'] = "shops/cart/site_remove_cart_item";
$route['shops/cart/remove'] = "shops/cart/site_remove_cart";

/*
 * Hiển thị giỏ hàng (ajax)
 */
$route['shops/cart/show_cart_page'] = "shops/cart/show_cart_page";
/*
 * Cập nhật giỏ hàng (ajax)
 */
$route['shops/cart/update'] = "shops/cart/site_update_cart";
/*
 * Thêm sản phẩm vào giỏ hàng (ajax)
 */
$route['shops/cart/add_cart_item'] = "shops/cart/site_add_cart_item";
/*
 * Hiển thị giỏ hàng mini (góc trên phải) 
 */
$route['shops/cart/show_cart'] = "shops/cart/show_cart";
/*
 * Gửi đơn đặt hàng
 */
$route['shops/orders/add'] = "shops/orders/add";
/*
 * Danh sách đơn đặt hàng (phân trang)
 */
$route['shops/payment'] = "shops/orders/site_payment";

/*
 * Danh sách các sản phẩm
 */
$route['shops'] = "shops/index";
$route['shops/([0-9\-]+)'] = "shops/index/$1";

/*
 * Danh sách sản phẩm theo chủ đề (phân trang)
 */
//$route['shops/(:any)/(:num)'] = "shops/rows/site_items_in_listcatid/$1/$2"; //theo danh sách phân trang
//$route['shops/(:any)/(:any)'] = "shops/rows/site_details/$1/$2"; //chi tiết
//$route['shops/(:any)'] = "shops/rows/site_items_in_listcatid/$1"; //theo danh sách

/*
 * sitemap
 */
$route['sitemap\.xml'] = "sitemap/sitemap_view";

/*
 * MODULES TAGS
  ======================================================================================================
 * ADMIN
 * ////////////////////////////////////////////////////////////////////////////////////////////////////
 * Tim tags
 */
$route['tag'] = 'tags/tags/index';
$route['tag/(:any)'] = 'tags/tags/index/$1';



/*
 * Dynamic router
 */
$route['ajax_read_number_to_text'] = 'layout/ajax_admin_read_number_to_text'; //doc so sang chu
$route['purchase_voucher/check_borrow_code_availablity'] = 'purchase_voucher/check_code_availablity';
$route['purchase_voucher/check_borrow_code_format'] = 'purchase_voucher/check_code_format';
$route['output_voucher/check_borrow_code_availablity'] = 'output_voucher/check_code_availablity';
$route['output_voucher/check_borrow_code_format'] = 'output_voucher/check_code_format';

$route['cau-hinh'] = 'configs/index';
$route['cau-hinh/email'] = 'emails/emails_config/admin_config';

$route['phieu-nhap/get-detail-ajax'] = 'purchase_voucher/admin_detail_ajax';
$route['phieu-nhap/confirm-ajax'] = 'purchase_voucher/admin_confirm_ajax';

$route['phieu-nhap/get-info-customer-ajax'] = 'purchase_voucher/ajax_get_customer'; //thêm
$route['phieu-nhap/get-end-date-ajax'] = 'purchase_voucher/ajax_get_enddate'; //thêm
$route['phieu-nhap/them-ajax'] = 'purchase_voucher/admin_content_ajax'; //thêm
$route['phieu-nhap/chuyen-kho-ajax'] = 'purchase_voucher/admin_transaction_warehouse_ajax'; //thêm
$route['phieu-nhap/nhap-hang-loat'] = 'purchase_voucher/admin_import';
$route['phieu-nhap'] = 'purchase_voucher/admin_index'; // danh sách
$route['phieu-nhap/(:num)'] = 'purchase_voucher/admin_index/$1'; // danh sách phân trang
$route['phieu-nhap/them'] = 'purchase_voucher/admin_content'; //thêm
$route['phieu-nhap/them/(:num)'] = 'purchase_voucher/admin_content/$1'; //sửa
$route['phieu-nhap/xem/(:num)'] = 'purchase_voucher/admin_view/$1'; //xem
$route['phieu-nhap/cap-nhat'] = 'purchase_voucher/admin_main'; //thêm
$route['phieu-nhap/xoa'] = 'purchase_voucher/admin_delete'; //xóa (dùng get)
$route['phieu-nhap/chuyen-kho'] = 'purchase_voucher/admin_transaction_warehouse'; //thêm
$route['phieu-nhap/chuyen-kho/(:num)'] = 'purchase_voucher/admin_transaction_warehouse/$1'; //sửa

$route['phieu-nhap/loai-kho-hang'] = 'purchase_voucher/warehouse/admin_index'; // danh sách
$route['phieu-nhap/loai-kho-hang/(:num)'] = 'purchase_voucher/warehouse/admin_index/$1'; // danh sách phân trang
$route['phieu-nhap/loai-kho-hang/them'] = 'purchase_voucher/warehouse/admin_content'; //thêm
$route['phieu-nhap/loai-kho-hang/them/(:num)'] = 'purchase_voucher/warehouse/admin_content/$1'; //sửa
$route['phieu-nhap/loai-kho-hang/cap-nhat'] = 'purchase_voucher/warehouse/admin_main'; //thêm
$route['phieu-nhap/loai-kho-hang/xoa'] = 'purchase_voucher/warehouse/admin_delete'; //xóa (dùng get)
$route['phieu-nhap/loai-kho-hang/xem/(:num)'] = 'purchase_voucher/warehouse/admin_view/$1';


$route['phieu-xuat/get-detail-ajax'] = 'output_voucher/admin_detail_ajax';
$route['phieu-xuat/confirm-ajax'] = 'output_voucher/admin_confirm_ajax';
$route['phieu-xuat/change-order-status-ajax'] = 'output_voucher/admin_change_order_status_ajax';
$route['phieu-xuat/change-delivery-status-ajax'] = 'output_voucher/admin_change_delivery_status_ajax';

$route['phieu-xuat/get-info-customer-ajax'] = 'output_voucher/ajax_get_customer'; //thêm
$route['phieu-xuat/get-end-date-ajax'] = 'output_voucher/ajax_get_enddate'; //thêm
$route['phieu-xuat/them-ajax'] = 'output_voucher/admin_content_ajax'; //thêm
$route['phieu-xuat'] = 'output_voucher/admin_index'; // danh sách
$route['phieu-xuat/(:num)'] = 'output_voucher/admin_index/$1'; // danh sách phân trang
$route['phieu-xuat/them'] = 'output_voucher/admin_content'; //thêm
$route['phieu-xuat/them/(:num)'] = 'output_voucher/admin_content/$1'; //sửa
$route['phieu-xuat/xem/(:num)'] = 'output_voucher/admin_view/$1'; //xem
$route['phieu-xuat/cap-nhat'] = 'output_voucher/admin_main'; //thêm
$route['phieu-xuat/xoa'] = 'output_voucher/admin_delete'; //xóa (dùng get)
$route['phieu-xuat/xuat'] = 'output_voucher/admin_export_excel';

$route['phieu-xuat/loai-don-hang'] = 'output_voucher/order_type/admin_index'; // danh sách
$route['phieu-xuat/loai-don-hang/(:num)'] = 'output_voucher/order_type/admin_index/$1'; // danh sách phân trang
$route['phieu-xuat/loai-don-hang/them'] = 'output_voucher/order_type/admin_content'; //thêm
$route['phieu-xuat/loai-don-hang/them/(:num)'] = 'output_voucher/order_type/admin_content/$1'; //sửa
$route['phieu-xuat/loai-don-hang/cap-nhat'] = 'output_voucher/order_type/admin_main'; //thêm
$route['phieu-xuat/loai-don-hang/xoa'] = 'output_voucher/order_type/admin_delete'; //xóa (dùng get)
$route['phieu-xuat/loai-don-hang/xem/(:num)'] = 'output_voucher/order_type/admin_view/$1';

$route['pay/check_quantity_availablity'] = 'pay/check_quantity_availablity';
$route['cong-no-khach-hang'] = 'customers/admin_remainder';
$route['cong-no-khach-hang/(:num)'] = 'customers/admin_remainder/$1';
$route['cong-no-khach-hang/xuat'] = 'customers/admin_remainder_export_excel';
$route['cong-no-khach-hang/lich-su-tra-tien-no'] = 'pay/admin_index';
$route['cong-no-khach-hang/lich-su-tra-tien-no/(:num)'] = 'pay/admin_index/$1';

$route['tra-tien-no'] = 'pay/admin_index';
$route['tra-tien-no/(:num)'] = 'pay/admin_index/$1';
$route['tra-tien-no/them'] = 'pay/admin_content';
$route['tra-tien-no/them/(:num)'] = 'pay/admin_content/$1';
$route['tra-tien-no/cap-nhat'] = 'pay/admin_main';
$route['tra-tien-no/xoa'] = 'pay/admin_delete';
$route['tra-tien-no/xem/(:num)'] = 'pay/admin_view/$1';

//$route['bao-gia'] = 'output_voucher/admin_quotation';
//$route['bao-gia-ajax'] = 'output_voucher/admin_quotation_ajax'; //thêm

$route['bao-gia/get-info-customer-ajax'] = 'quotation/ajax_get_customer'; //thêm
$route['bao-gia/get-end-date-ajax'] = 'quotation/ajax_get_enddate'; //thêm
$route['bao-gia/them-ajax'] = 'quotation/admin_content_ajax'; //thêm
$route['bao-gia'] = 'quotation/admin_index'; // danh sách
$route['bao-gia/(:num)'] = 'quotation/admin_index/$1'; // danh sách phân trang
$route['bao-gia/them'] = 'quotation/admin_content'; //thêm
$route['bao-gia/them/(:num)'] = 'quotation/admin_content/$1'; //sửa
$route['bao-gia/xem/(:num)'] = 'quotation/admin_view/$1'; //xem
$route['bao-gia/cap-nhat'] = 'quotation/admin_main'; //thêm
$route['bao-gia/xoa'] = 'quotation/admin_delete'; //xóa (dùng get)

$route['bao-gia/loai-bao-gia'] = 'quotation/type_of_quote/admin_index'; // danh sách
$route['bao-gia/loai-bao-gia/(:num)'] = 'quotation/type_of_quote/admin_index/$1'; // danh sách phân trang
$route['bao-gia/loai-bao-gia/them'] = 'quotation/type_of_quote/admin_content'; //thêm
$route['bao-gia/loai-bao-gia/them/(:num)'] = 'quotation/type_of_quote/admin_content/$1'; //sửa
$route['bao-gia/loai-bao-gia/cap-nhat'] = 'quotation/type_of_quote/admin_main'; //thêm
$route['bao-gia/loai-bao-gia/xoa'] = 'quotation/type_of_quote/admin_delete'; //xóa (dùng get)
$route['bao-gia/loai-bao-gia/xem/(:num)'] = 'quotation/type_of_quote/admin_view/$1';

$route['nhom-quyen'] = 'users/users_groups/admin_index';
$route['nhom-quyen/(:num)'] = 'users/users_groups/admin_index/$1';
$route['nhom-quyen/them'] = 'users/users_groups/admin_content';
$route['nhom-quyen/them/(:num)'] = 'users/users_groups/admin_content/$1';
$route['nhom-quyen/cap-nhat'] = 'users/users_groups/admin_main';
$route['nhom-quyen/xoa'] = 'users/users_groups/admin_delete';

$route['nhan-vien'] = 'employee/admin_index'; // danh sách
$route['nhan-vien/(:num)'] = 'employee/admin_index/$1'; // danh sách phân trang
$route['nhan-vien/them'] = 'employee/admin_content'; //thêm
$route['nhan-vien/them/(:num)'] = 'employee/admin_content/$1'; //sửa
$route['nhan-vien/cap-nhat'] = 'employee/admin_main'; //thêm
$route['nhan-vien/xoa'] = 'employee/admin_delete'; //xóa (dùng get)

$route['nhan-vien/loai-phong-ban'] = 'employee/type_of_departments/admin_index'; // danh sách
$route['nhan-vien/loai-phong-ban/(:num)'] = 'employee/type_of_departments/admin_index/$1'; // danh sách phân trang
$route['nhan-vien/loai-phong-ban/them'] = 'employee/type_of_departments/admin_content'; //thêm
$route['nhan-vien/loai-phong-ban/them/(:num)'] = 'employee/type_of_departments/admin_content/$1'; //sửa
$route['nhan-vien/loai-phong-ban/cap-nhat'] = 'employee/type_of_departments/admin_main'; //thêm
$route['nhan-vien/loai-phong-ban/xoa'] = 'employee/type_of_departments/admin_delete'; //xóa (dùng get)
$route['nhan-vien/loai-phong-ban/xem/(:num)'] = 'employee/type_of_departments/admin_view/$1';

$route['customers/ajax_admin_add'] = 'customers/ajax_admin_add'; //thêm
$route['customers/ajax_admin_get'] = 'customers/ajax_admin_get'; //get
$route['customers/get-arrears-ajax'] = 'customers/get_arrears_ajax'; //get
$route['khach-hang'] = 'customers/admin_index'; // danh sách
$route['khach-hang/(:num)'] = 'customers/admin_index/$1'; // danh sách phân trang
$route['khach-hang/them'] = 'customers/admin_content'; //thêm
$route['khach-hang/them/(:num)'] = 'customers/admin_content/$1'; //sửa
$route['khach-hang/cap-nhat'] = 'customers/admin_main'; //thêm
$route['khach-hang/xem/(:num)'] = 'customers/admin_view/$1'; //xem
$route['khach-hang/xoa'] = 'customers/admin_delete'; //xóa (dùng get)
$route['khach-hang/nhap'] = 'customers/admin_import_excel';
$route['khach-hang/xuat'] = 'customers/admin_export_excel';
$route['khach-hang/don-hang/(:num)/(:num)'] = 'output_voucher/admin_by_customer/$1/$2'; // danh sách
$route['khach-hang/don-hang/(:num)'] = 'output_voucher/admin_by_customer/$1'; // danh sách
$route['khach-hang/in-barcode'] = 'customers/admin_print_barcode';

$route['khach-hang/loai-khach-hang'] = 'customers/type_of_customer/admin_index'; // danh sách
$route['khach-hang/loai-khach-hang/(:num)'] = 'customers/type_of_customer/admin_index/$1'; // danh sách phân trang
$route['khach-hang/loai-khach-hang/them'] = 'customers/type_of_customer/admin_content'; //thêm
$route['khach-hang/loai-khach-hang/them/(:num)'] = 'customers/type_of_customer/admin_content/$1'; //sửa
$route['khach-hang/loai-khach-hang/cap-nhat'] = 'customers/type_of_customer/admin_main'; //thêm
$route['khach-hang/loai-khach-hang/xoa'] = 'customers/type_of_customer/admin_delete'; //xóa (dùng get)
$route['khach-hang/loai-khach-hang/xem/(:num)'] = 'customers/type_of_customer/admin_view/$1';

$route['thung-rac/thiet-bi'] = 'consignment/admin_trash'; // danh sách
$route['thung-rac/thiet-bi/xoa'] = 'consignment/admin_delete_trash'; //xóa (dùng get)
$route['thung-rac/khach-hang'] = 'customers/admin_trash'; // danh sách
$route['thung-rac/khach-hang/xoa'] = 'customers/admin_delete_trash'; //xóa (dùng get)
$route['thung-rac/muon-hang'] = 'services/services_borrow/admin_trash'; // danh sách
$route['thung-rac/muon-hang/xoa'] = 'services/services_borrow/admin_delete_trash'; //xóa (dùng get)
$route['thung-rac/sua-chua-bao-hanh'] = 'services/services_maintenance/admin_trash'; // danh sách
$route['thung-rac/sua-chua-bao-hanh/xoa'] = 'services/services_maintenance/admin_delete_trash'; //xóa (dùng get)

$route['customer_types/ajax_admin_add'] = 'customer_types/ajax_admin_add'; //thêm
$route['loai-khach-hang'] = 'customer_types/admin_index'; // danh sách
$route['loai-khach-hang/(:num)'] = 'customer_types/admin_index/$1'; // danh sách phân trang
$route['loai-khach-hang/them'] = 'customer_types/admin_content'; //thêm
$route['loai-khach-hang/them/(:num)'] = 'customer_types/admin_content/$1'; //sửa
$route['loai-khach-hang/cap-nhat'] = 'customer_types/admin_main'; //thêm
$route['loai-khach-hang/xoa'] = 'customer_types/admin_delete'; //xóa (dùng get)

//nha cung cap
$route['provider/ajax_admin_add'] = 'provider/ajax_admin_add'; //thêm
$route['nha-cung-cap'] = 'provider/admin_index'; // danh sách
$route['nha-cung-cap/(:num)'] = 'provider/admin_index/$1'; // danh sách phân trang
$route['nha-cung-cap/them'] = 'provider/admin_content'; //thêm
$route['nha-cung-cap/them/(:num)'] = 'provider/admin_content/$1'; //sửa
$route['nha-cung-cap/cap-nhat'] = 'provider/admin_main'; //thêm
$route['nha-cung-cap/xoa'] = 'provider/admin_delete'; //xóa (dùng get)
$route['nha-cung-cap/xem/(:num)'] = 'provider/admin_view/$1';

$route['nha-cung-cap/loai-nha-cung-cap'] = 'provider/supplier_type/admin_index'; // danh sách
$route['nha-cung-cap/loai-nha-cung-cap/(:num)'] = 'provider/supplier_type/admin_index/$1'; // danh sách phân trang
$route['nha-cung-cap/loai-nha-cung-cap/them'] = 'provider/supplier_type/admin_content'; //thêm
$route['nha-cung-cap/loai-nha-cung-cap/them/(:num)'] = 'provider/supplier_type/admin_content/$1'; //sửa
$route['nha-cung-cap/loai-nha-cung-cap/cap-nhat'] = 'provider/supplier_type/admin_main'; //thêm
$route['nha-cung-cap/loai-nha-cung-cap/xoa'] = 'provider/supplier_type/admin_delete'; //xóa (dùng get)
$route['nha-cung-cap/loai-nha-cung-cap/xem/(:num)'] = 'provider/supplier_type/admin_view/$1';

//khach hang
$route['products/get-details-ajax'] = 'products/get_details_ajax';
$route['products/validate-quantity-ajax'] = 'products/validate_quantity_ajax';

$route['products/check_quantity_availablity'] = 'products/check_quantity_availablity';
$route['products/check-quantity-availablity-ajax'] = 'products/ajax_check_quantity_availablity';
$route['products/check_code_availablity'] = 'products/check_code_availablity';
$route['products/check_barcode_availablity'] = 'products/check_barcode_availablity';
$route['products/ajax_admin_add'] = 'products/ajax_admin_add'; //thêm
$route['products/ajax_get'] = 'products/ajax_admin_get';
$route['products/ajax_gets'] = 'products/ajax_admin_gets';
$route['products/ajax_export_excel'] = 'products/ajax_admin_export_excel'; //xuat du lieu ajax
$route['san-pham'] = 'products/admin_index'; // danh sách
$route['san-pham/(:num)'] = 'products/admin_index/$1'; // danh sách phân trang
$route['san-pham/them'] = 'products/admin_content'; //thêm
$route['san-pham/them/(:num)'] = 'products/admin_content/$1'; //sửa
$route['san-pham/cap-nhat'] = 'products/admin_main'; //thêm
$route['san-pham/xem/(:num)'] = 'products/admin_view/$1'; //xem
$route['san-pham/xoa'] = 'products/admin_delete'; //xóa (dùng get)
$route['san-pham/nhap'] = 'products/admin_import_excel';
$route['san-pham/xuat'] = 'products/admin_export_excel';
$route['san-pham/xem-doi-gia/(:num)/(:num)'] = 'products/admin_view_history/$1/$2'; //xem gia phan trang
$route['san-pham/xem-doi-gia/(:num)'] = 'products/admin_view_history/$1'; //xem gia
$route['san-pham/in-barcode'] = 'products/admin_print_barcode';
//don vi het han
$route['san-pham/don-vi'] = 'products/unit/admin_index';
$route['san-pham/don-vi/(:num)'] = 'products/unit/admin_index/$1';
$route['san-pham/don-vi/them'] = 'products/unit/admin_content';
$route['san-pham/don-vi/them/(:num)'] = 'products/unit/admin_content/$1';
$route['san-pham/don-vi/cap-nhat'] = 'products/unit/admin_main';
$route['san-pham/don-vi/xoa'] = 'products/unit/admin_delete';
$route['san-pham/don-vi/xem/(:num)'] = 'products/unit/admin_view/$1';
//loai san pham
$route['category/ajax_admin_add'] = 'category/ajax_admin_add'; //thêm
$route['loai-san-pham'] = 'category/admin_index'; // danh sách
$route['loai-san-pham/(:num)'] = 'category/admin_index/$1'; // danh sách phân trang
$route['loai-san-pham/them'] = 'category/admin_content'; //thêm
$route['loai-san-pham/them/(:num)'] = 'category/admin_content/$1'; //sửa
$route['loai-san-pham/cap-nhat'] = 'category/admin_main'; //thêm
$route['loai-san-pham/xoa'] = 'category/admin_delete'; //xóa (dùng get)

//giao dich
$route['commission/change-status-ajax'] = "users/users_commission/ajax_change_status";
$route['giao-dich'] = 'users/users_commission/admin_index';
$route['giao-dich/(:num)'] = 'users/users_commission/admin_index/$1';
$route['giao-dich/them'] = "users/users_commission/admin_content";
$route['giao-dich/xoa'] = "users/users_commission/admin_delete";
$route['giao-dich/cap-nhat'] = "users/users_commission/admin_main";

//nhat ky he thong
$route['activities/change-status-ajax'] = "users/users_activities/ajax_change_status";
$route['nhat-ky-he-thong'] = 'users/users_activities/admin_index';
$route['nhat-ky-he-thong/(:num)'] = 'users/users_activities/admin_index/$1';
$route['nhat-ky-he-thong/xoa'] = "users/users_activities/admin_delete";

//bao cao
$route['bao-cao'] = 'output_voucher/admin_report';
$route['bao-cao/(:num)'] = 'output_voucher/admin_report/$1';
$route['bao-cao/xuat'] = 'output_voucher/admin_report_export_excel';
$route['bao-cao/nha-cung-cap'] = 'provider/admin_report';
$route['bao-cao/nha-cung-cap/(:num)'] = 'provider/admin_report/$1';
$route['bao-cao/nha-cung-cap/xuat'] = 'provider/admin_report_export_excel';
$route['bao-cao/nha-cung-cap-chi-tiet'] = 'provider/admin_report_details';
$route['bao-cao/nha-cung-cap-chi-tiet/(:num)'] = 'provider/admin_report_details/$1';
$route['bao-cao/kho-hang'] = 'products/admin_report';
$route['bao-cao/kho-hang/(:num)'] = 'products/admin_report/$1';
$route['bao-cao/kho-hang/xuat'] = 'products/admin_report_export_excel';
$route['bao-cao/theo-ngay'] = 'output_voucher/admin_report_by_date';
$route['bao-cao/theo-ngay/(:num)'] = 'output_voucher/admin_report_by_date/$1';
$route['bao-cao/theo-ngay-chi-tiet'] = 'output_voucher/admin_report_by_date_detail';
$route['bao-cao/theo-ngay-chi-tiet/(:num)'] = 'output_voucher/admin_report_by_date_detail/$1';
$route['bao-cao/theo-ngay/xuat'] = 'output_voucher/admin_report_by_date_export_excel';
$route['bao-cao/mat-hang'] = 'output_voucher/admin_report_by_product';
$route['bao-cao/mat-hang/(:num)'] = 'output_voucher/admin_report_by_product/$1';
$route['bao-cao/mat-hang/xuat'] = 'output_voucher/admin_report_by_product_export_excel';
$route['bao-cao/khach-hang'] = 'customers/admin_report';
$route['bao-cao/khach-hang/(:num)'] = 'customers/admin_report/$1';
$route['bao-cao/khach-hang/xuat'] = 'customers/admin_report_export_excel';

$route['users/check_username_availablity'] = 'users/check_username_availablity';
$route['users/check_email_availablity'] = 'users/check_email_availablity';
$route['users/get-ajax'] = 'users/ajax_get';
$route['dang-ky'] = 'users/site_register';
$route['quen-mat-khau'] = 'users/site_forget_password';
/*
$route['bao-cao/khach-hang'] = 'output_voucher/admin_report_by_customer';
$route['bao-cao/khach-hang/(:num)'] = 'output_voucher/admin_report_by_customer/$1';
$route['bao-cao/khach-hang/xuat'] = 'output_voucher/admin_report_by_customer_export_excel';
*/