<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['asset_path'] = 'assets/';
$config['css_path'] = 'assets/css/';
$config['js_path'] = 'assets/js/';
$config['img_path'] = 'assets/images/';
$config['xml_path'] = 'assets/xml/';
$config['upload_path'] = 'uploads/';
$config['temp_path'] = 'temps/';
$config['modules_path'] = array(
    'captcha' => 'uploads/captcha/',
    'users' => 'uploads/users/',
    'shops' => 'uploads/shops/',
    'posts' => 'uploads/posts/',
    'pages' => 'uploads/pages/',
    'images' => 'uploads/images/',
    'customers' => 'uploads/customers/',
    'products' => 'uploads/products/',
    'barcodes' => 'uploads/barcodes/',
);


/* End of file asset.php */