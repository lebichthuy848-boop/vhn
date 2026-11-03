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
$route['404_override'] = 'errors/error404';
$route['translate_uri_dashes'] = FALSE;

/*
 * MODULES USERS
======================================================================================================
 */
$route['admin'] = 'layout/index_admin';
$route['admin/logout'] = 'users/logout';
/*
 * Kiểm tra tồn tại username, email tài khoản update (admin - ajax)
 */
$route['admin/users/check_current_username_availablity'] = 'users/check_current_username_availablity';
$route['admin/users/check_current_email_availablity'] = 'users/check_current_email_availablity';
$route['admin/users/check_username_availablity'] = 'users/check_username_availablity';
$route['admin/users/check_email_availablity'] = 'users/check_email_availablity';
$route['admin/users'] = 'users/index';
$route['admin/users/(:num)'] = 'users/index/$1';
$route['admin/users/content'] = 'users/admin_content';
$route['admin/users/content/(:num)'] = 'users/admin_content/$1';
$route['admin/users/delete'] = 'users/admin_delete';
$route['admin/users/profile'] = 'users/admin_profile';

/*
 * MODULES CONTACT
======================================================================================================
 */
$route['admin/contact'] = 'contact/admin_index';
$route['admin/contact/([0-9\-]+)'] = 'contact/admin_index/$1';
$route['admin/contact/view'] = 'contact/admin_view';
$route['admin/contact/delete'] = 'contact/admin_delete';
$route['admin/contact/main'] = 'contact/admin_main';

/*
 * MODULES ADVISORY
======================================================================================================
 */
$route['admin/advisory'] = 'advisory/admin_index';
$route['admin/advisory/([0-9\-]+)'] = 'advisory/admin_index/$1';
$route['admin/advisory/view'] = 'advisory/admin_view';
$route['admin/advisory/delete'] = 'advisory/admin_delete';
$route['admin/advisory/main'] = 'advisory/admin_main';

/*
 * MODULES POSTS
======================================================================================================
 * ADMIN
 * ////////////////////////////////////////////////////////////////////////////////////////////////////
 *
 * Kiểm tra tồn tại liên kết tĩnh chủ đề (admin - ajax)
 */
$route['admin/posts/cat/check_alias_availablity'] = 'posts/postcat/check_alias_availablity';
$route['admin/posts/cat/change-field'] = 'posts/postcat/admin_ajax_change_field';
$route['admin/posts/change-field'] = 'posts/admin_ajax_change_field';
/*
 * Chủ đề
 */
$route['admin/posts/cat'] = "posts/postcat/admin_index";
$route['admin/posts/cat/content'] = "posts/postcat/admin_content";
$route['admin/posts/cat/content/([0-9\-]+)'] = "posts/postcat/admin_content/$1";
$route['admin/posts/cat/main'] = 'posts/postcat/admin_main';
$route['admin/posts/cat/delete/(:num)'] = 'posts/postcat/admin_delete/$1';

/*
 * Bài viết
 */
$route['admin/posts'] = 'posts/posts/index_admin';
$route['admin/posts/(:num)'] = 'posts/posts/index_admin/$1';
$route['admin/posts/content'] = 'posts/posts/admin_content';
$route['admin/posts/content/(:num)'] = 'posts/posts/admin_content/$1';
$route['admin/posts/delete'] = 'posts/posts/admin_delete';
$route['admin/posts/main'] = 'posts/posts/admin_main';

/*
 * MODULES PAGES (trang tĩnh)
======================================================================================================
 */
$route['admin/pages'] = 'pages/index_admin';
$route['admin/pages/([0-9\-]+)'] = 'pages/index_admin/$1';
$route['admin/pages/content'] = 'pages/admin_content';
$route['admin/pages/content/(:num)'] = 'pages/admin_content/$1';
$route['admin/pages/delete'] = "pages/admin_delete";
$route['admin/pages/main'] = 'pages/admin_main';

/*
 * MODULES CONFIGS
======================================================================================================
 */
$route['admin/settings'] = 'configs/index';
$route['admin/settings/main'] = 'configs/main';

/*
 * MODULES MENU
======================================================================================================
 */
$route['admin/menu'] = 'menu/admin_index';
$route['admin/menu/get_menu_position'] = 'menu/admin_get_menu_position';
$route['admin/menu/get_menu_type'] = 'menu/admin_get_menu_type';
$route['admin/menu/content'] = 'menu/admin_content';
$route['admin/menu/content/(:num)'] = 'menu/admin_content/$1';
$route['admin/menu/delete/(:num)'] = 'menu/admin_delete/$1';
$route['admin/menu/main'] = 'menu/admin_main';

/*
 * MODULES EMAILS
======================================================================================================
 */
$route['admin/emails'] = 'emails/emails_config/admin_config';
$route['admin/emails/logs/(:num)'] = 'emails/email_logs/admin_index/$1';
$route['admin/emails/logs'] = 'emails/email_logs/admin_index';

/*
 * MODULES QUẢN LÝ ẢNH
======================================================================================================
 */
$route['admin/images'] = 'images/admin_index';
$route['admin/images/(:num)'] = 'images/admin_index/$1';
$route['admin/images/content'] = 'images/admin_content';
$route['admin/images/content/(:num)'] = 'images/admin_content/$1';
$route['admin/images/delete'] = 'images/admin_delete';
$route['admin/images/main'] = 'images/admin_main';

/*
 * MODULES INFO
======================================================================================================
 */
$route['admin/info'] = 'info/admin_index';
$route['admin/info/(:num)'] = 'info/admin_index/$1';
$route['admin/info/content'] = 'info/admin_content';
$route['admin/info/content/(:num)'] = 'info/admin_content/$1';
$route['admin/info/delete'] = 'info/admin_delete';
$route['admin/info/main'] = 'info/admin_main';

/*
 * MODULES CART
======================================================================================================
 */
$route['admin/orders'] = "shops/orders/index";
$route['admin/orders/([0-9\-]+)'] = 'shops/orders/index/$1';
$route['admin/orders/or_view/([0-9\-]+)'] = 'shops/orders/or_view/$1';
$route['admin/orders/delete/([0-9\-]+)'] = "shops/orders/delete/$1";

/*
 * MODULES SHOPS
======================================================================================================
 */
/*
 * Lấy alias (liên kết tĩnh) bằng ajax
 */
$route['admin/shops/alias'] = "layout/get_alias";
$route['admin/shops/cat/alias'] = "layout/get_alias";
$route['admin/shops/get_price'] = "shops/rows/admin_get_price_ajax";
/*
 * Thay đổi hiển thị sản phẩm trang chủ (admin - ajax)
 */
$route['admin/shops/change-field'] = 'shops/rows/admin_ajax_change_field';
$route['admin/shops/upload-ajax'] = "shops/rows/ajax_upload";
$route['admin/shops/other/update-ajax'] = "shops/other/ajax_update";
$route['admin/shops/other/delete-ajax'] = "shops/other/ajax_delete";
/*
 * Thay đổi hiển thị loại sản phẩm trang chủ (admin - ajax)
 */
$route['admin/shops/cat/change-inhome'] = 'shops/cat/admin_ajax_change_inhome';
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
$route['admin/shops/cat/check_alias_en_availablity'] = 'shops/cat/check_alias_en_availablity';

/*
 * Danh mục sản phẩm
 */
$route['admin/shops/cat/main'] = 'shops/cat/admin_main';
$route['admin/shops/cat/content'] = "shops/cat/admin_content";
$route['admin/shops/cat/content/([0-9\-]+)'] = 'shops/cat/admin_content/$1';
$route['admin/shops/cat'] = "shops/cat/admin_index";
$route['admin/shops/cat/delete/(:num)'] = 'shops/cat/admin_delete/$1';

$route['admin/shops/items'] = 'shops/rows/admin_index';
$route['admin/shops/items/([0-9\-]+)'] = 'shops/rows/admin_index/$1';
$route['admin/shops/content'] = 'shops/rows/admin_content'; //thêm
$route['admin/shops/content/(:num)'] = 'shops/rows/admin_content/$1';
$route['admin/shops/delete'] = "shops/rows/admin_delete";
$route['admin/shops/main'] = 'shops/rows/admin_main';
$route['admin/shops/config'] = 'shops/shops_config/admin_config';

/*
 * Liên hệ sản phẩm
 */
$route['admin/shops/contact'] = 'shops/contact/admin_index';
$route['admin/shops/contact/([0-9\-]+)'] = 'shops/contact/admin_index/$1';
$route['admin/shops/contact/view'] = 'shops/contact/admin_view';
$route['admin/shops/contact/delete'] = 'shops/contact/admin_delete';
$route['admin/shops/contact/main'] = 'shops/contact/admin_main';

/*
 * Lọc sản phẩm
 */
$route['admin/shops/filter-get-ajax'] = "shops/filter/ajax_get";
$route['admin/shops/filter'] = "shops/filter/admin_index";
$route['admin/shops/filter/([0-9\-]+)'] = "shops/filter/admin_index/$1";
$route['admin/shops/filter/content'] = "shops/filter/admin_content";
$route['admin/shops/filter/content/([0-9\-]+)'] = "shops/filter/admin_content/$1";
$route['admin/shops/filter/delete'] = "shops/filter/admin_delete";
$route['admin/shops/filter/main'] = "shops/filter/admin_main";

/*
 * MODULES CUSTOMERS
======================================================================================================
 */
$route['admin/customers'] = "customers/admin_index";
$route['admin/customers/([0-9\-]+)'] = "customers/admin_index/$1";

/*
 * MODULES NEWSLETTER
======================================================================================================
 */
$route['admin/newsletter'] = 'newsletter/admin_index';
$route['admin/newsletter/(:num)'] = 'newsletter/admin_index/$1';
$route['admin/newsletter/content'] = 'newsletter/admin_content';
$route['admin/newsletter/content/(:num)'] = 'newsletter/admin_content/$1';
$route['admin/newsletter/delete'] = 'newsletter/admin_delete';
$route['admin/newsletter/main'] = 'newsletter/admin_main';

/*
 * MODULES SITEMAP
======================================================================================================
 */
$route['admin/sitemap'] = 'sitemap/admin_index';

/*
 * SITE
======================================================================================================
 */
$route['advisory-ajax'] = "advisory/index_ajax";
$route['newsletter'] = "newsletter/index";
$route['shops-contact-ajax'] = "shops/contact/index_ajax";

//ajax
$route['shops/cart/add_cart_item'] = "shops/cart/site_add_cart_item";
$route['shops/cart/show_cart'] = "shops/cart/show_cart";

$route['gio-hang'] = "shops/orders/cart";
$route['cap-nhat-gio-hang'] = "shops/cart/site_update_cart";
$route['gio-hang-cap-nhat-ajax'] = "shops/cart/site_update_cart_ajax";
$route['gio-hang-xoa-san-pham-ajax'] = "shops/cart/site_remove_cart_item_ajax";
$route['xoa-gio-hang'] = "shops/cart/site_remove_cart";
$route['xoa-san-pham-gio-hang'] = "shops/cart/site_remove_cart_item";

$route['thanh-toan'] = "shops/checkout/site_index";
$route['ket-qua-thanh-toan'] = "shops/checkout/site_order_success";

$route["danh-muc-san-pham/(:any)/(:num)"] = "shops/rows/site_items_in_listcatid/$1/$2";
$route["danh-muc-san-pham/(:any)"] = "shops/rows/site_items_in_listcatid/$1";

$route["loai-san-pham/(:any)/(:num)"] = "shops/rows/site_items_in_provider_id/$1/$2";
$route["loai-san-pham/(:any)"] = "shops/rows/site_items_in_provider_id/$1";

$route["tag/(:any)/(:num)"] = "shops/rows/site_items_tag/$1/$2";
$route["tag/(:any)"] = "shops/rows/site_items_tag/$1";

$route["dang-nhap"] = "users/site_login";

$route["san-pham/(:any)/(:any)"] = "shops/rows/site_details/$1/$2";
$route["san-pham/(:num)"] = "shops/rows/index/$1";
$route["san-pham"] = "shops/rows/index";

$route['search'] = "search/index";
$route['search/(:num)'] = "search/index/$1";

$route["tin-tuc"] = "posts/index";
$route["tin-tuc/([0-9\-]+)"] = "posts/index/$1";

$route["danh-muc-bai-viet/(:any)/(:num)"] = "posts/site_items_in_cat/$1/$2";
$route["danh-muc-bai-viet/(:any)"] = "posts/site_items_in_cat/$1";

$route["lien-he"] = "contact/contact/index";

$route["(:any)/(:any)"] = "posts/site_details/$1";
$route["(:any)"] = "pages/site_details/$1";