<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function get_api_url($url = '') {
    if(trim($url) == ''){
        $CI = &get_instance();
        $url = $CI->config->item('url', 'api');
    }
    return $url;
}

function get_api_headers() {
    $CI = &get_instance();
    return array(
        'domain' => $CI->config->item('domain', 'api'),
        'secret' => $CI->config->item('secret', 'api')
    );
}

function get_api_key() {
    $CI = &get_instance();
    return $CI->config->item('secret', 'api');
}

function curl_get($url, $data = NULL, $_gets = NULL) {
    $gets = '';
    if (is_array($_gets) && !empty($_gets)) {
        foreach ($_gets as $key => $value) {
            $gets .= $key . '=' . $value . '&';
        }
        $gets = '?' . trim($gets, '&');
    }
    $headers = array(
        'Content-Type:application/json',
        'X-API-KEY:' . get_api_key()
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url . $gets);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
    if (is_array($data) && !empty($data)) {
        $params = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    }
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    curl_close($ch);

    if (!$result) {
        die("Connection Failure");
    }
    return $result;
}

function curl_post($url, $data = NULL) {
    $headers = array(
        'Content-Type:application/json',
        'X-API-KEY:' . get_api_key()
    );
    $ch = curl_init($url);
    $params = json_encode($data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    if (!$result) {
        die("Connection Failure");
    }
    return $result;
}

if (!function_exists('current_full_url')) {
    function current_full_url() {
        $CI = &get_instance();
        $url = $CI->config->site_url($CI->uri->uri_string());
        return $_SERVER['QUERY_STRING'] ? $url . '?' . $_SERVER['QUERY_STRING'] : $url;
    }
}

/*
 * Importion: This is change page url admin
 */
if (!function_exists('get_admin_url')) {

    function get_admin_url($module_slug = '') {
        $html = '';
        $ci = & get_instance();
        $base_url = $ci->config->item('base_url');
        $html .= $base_url . 'admin';
        if (trim($module_slug) != '') {
            $html .= '/' . $module_slug;
        }

        return $html;
    }

}

if (!function_exists('add_css')) {

    function add_css($names = array()) {
        $html = '';
        $data = array();
        if (is_array($names) && !empty($names)) {
            foreach ($names as $value) {
                $data[] = '<link href="' . get_asset('css_path') . $value . '.css" type="text/css" rel="stylesheet" />';
            }
        }

        if (is_array($data) && !empty($data)) {
            $html = implode("\n\t\t", $data);
        }

        return $html;
    }

}

if (!function_exists('add_js')) {

    function add_js($names = array()) {
        $html = '';
        $data = array();
        if (is_array($names) && !empty($names)) {
            foreach ($names as $value) {
                $data[] = '<script type="text/javascript" src="' . get_asset('js_path') . $value . '.js"></script>';
            }
        }

        if (is_array($data) && !empty($data)) {
            $html = implode("\n\t\t", $data);
        }

        return $html;
    }

}

if (!function_exists('create_folder')) {

    function create_folder($path_folder = 'uploads/', $create_index_file = true) {
        if (!is_dir($path_folder)) {
            mkdir('./' . $path_folder, 0777, TRUE);
            if ($create_index_file) {
                $index_file = 'index.html';
                copy_file('uploads/' . $index_file, $path_folder . '/' . $index_file);
            }
        }
    }

}

if (!function_exists('copy_file')) {

    function copy_file($from_file, $to_file, $delete = false) {
        $file = FCPATH . $from_file;
        $newfile = FCPATH . $to_file;
        copy($file, $newfile);
        if ($delete) {
            @unlink($file);
        }
    }

}

if (!function_exists('active_link')) {

    function activate_menu($controller = '') {
        $CI = get_instance();
        $class = $CI->router->fetch_class(); //tra ve lop chua fuction hien tai
        return ($class == $controller) ? 'active' : '';
    }

}

if (!function_exists('is_home')) {

    function is_home() {
        $ci = & get_instance();
        if ($ci->uri->uri_string() == '') {
            return true;
        }

        return false;
    }

}

if (!function_exists('get_asset')) {

    function get_asset($folder = '') {
        $html = '';
        $ci = & get_instance();
        $base_url = $ci->config->item('base_url');
        $html .= $base_url;
        if (trim($folder) != '') {
            $html .= $ci->config->item($folder);
        }

        return $html;
    }

}

if (!function_exists('get_view_page')) {

    function get_view_page($view_page = '') {
        $data = array(
            'page_grid' => 'Lưới',
            'page_list' => 'Danh sách',
        );
        $html = '';
        if (isset($data[$view_page])) {
            $html .= $data[$view_page];
        }

        return $html;
    }

}

if (!function_exists('validate_file_exists')) {

    function validate_file_exists($file = '') {
        $bool = true;

        if (is_dir($file) || !file_exists(FCPATH . $file)) {
            $bool = false;
        }

        return $bool;
    }

}

if (!function_exists('get_image')) {

    function get_image($path_image = '', $path_default_image = 'uploads/no_image.png') {
        $html = $path_image;

        if (is_dir($path_image) || !file_exists(FCPATH . $path_image)) {
            $html = $path_default_image;
        }

        return base_url($html);
    }

}

if (!function_exists('get_media')) {

    function get_media($module_name = '', $image = '', $default_image = 'no_image.png', $str_format = '') {
        $folder = '';
        $ci = & get_instance();
        $modules_path = $ci->config->item('modules_path');
        if (trim($module_name) != '' && isset($modules_path[$module_name])) {
            $folder = $modules_path[$module_name];
        }
        $src = $image;
        $path_image = $folder . $image;
        if (is_dir($path_image) || !file_exists(FCPATH . $path_image)) {
            $src = $default_image;
        }
        if(trim($str_format) != ''){
            $src = $str_format . '-' . $src;
        }

        $temp_folder = rtrim($folder, '/');
        $temp_arr = explode('/', $temp_folder);
        $temp_arr_count = count($temp_arr);
        if($temp_arr_count > 2){
            unset($temp_arr[0]);
            $module_name = implode('/', $temp_arr);
        }

        return base_url('media' . '/' . $module_name . '/' . $src);
    }

}

if (!function_exists('filter_content')) {

    function filter_content($content = '') {
        $pattern = '(ckeditor\/kcfinder\/upload\/images)';
        return preg_replace($pattern, 'image' , $content);
    }

}

if (!function_exists('get_option_select')) {

    function get_option_select($data, $option_selected = '') {
        $html = '';
        foreach ($data as $key => $value) {
            $selected = '';
            if ($option_selected == $key) {
                $selected = ' selected="selected"';
            }
            $html .= "<option value='$key' $selected>" . $value . "</option>";
        }

        return $html;
    }

}

if (!function_exists('display_value_array')) {

    function display_value_array($data, $key = '') {
        $html = '';
        if (isset($data[$key])) {
            $html = $data[$key];
        }

        return $html;
    }

}

if (!function_exists('get_file_name_uploads_path')) {

    function get_file_name_uploads_path($path) {
        $ext = end(explode("/", $path));
        return $ext;
    }

}

if (!function_exists('get_module_path')) {

    function get_module_path($module_name = '') {
        $html = '';
        $ci = & get_instance();
        $modules_path = $ci->config->item('modules_path');
        if (trim($module_name) != '' && isset($modules_path[$module_name])) {
            $html = $modules_path[$module_name];
        }

        return $html;
    }

}

if (!function_exists('get_shops_thumbnais_default_size')) {

    function get_shops_thumbnais_default_size() {
        $html = '';
        $ci = & get_instance();
        $shops_thumbnais_sizes = $ci->config->item('shops_thumbnais_sizes');

        if (is_array($shops_thumbnais_sizes)) {
            $keys = array_keys($shops_thumbnais_sizes);
            if (isset($keys[0])) {
                $html = $keys[0];
            }
        }

        return $html;
    }

}

if (!function_exists('get_shops_thumbnais_sizes')) {

    function get_shops_thumbnais_sizes($key = '185x181') {
        $array = NULL;
        $ci = & get_instance();
        $shops_thumbnais_sizes = $ci->config->item('shops_thumbnais_sizes');
        if (trim($key) != '' && isset($shops_thumbnais_sizes[$key])) {
            $array = $shops_thumbnais_sizes[$key];
        }

        return $array;
    }

}

if (!function_exists('get_posts_thumbnais_sizes')) {

    function get_posts_thumbnais_sizes($key = '185x181') {
        $array = NULL;
        $ci = & get_instance();
        $posts_thumbnais_sizes = $ci->config->item('posts_thumbnais_sizes');
        if (trim($key) != '' && isset($posts_thumbnais_sizes[$key])) {
            $array = $posts_thumbnais_sizes[$key];
        }

        return $array;
    }

}

if (!function_exists('display_label')) {

    function display_label($content = '', $lable_type = 'success') {
        $html = '';
        $html .= "<span class='label label-$lable_type'>$content</span>";

        return $html;
    }

}

if (!function_exists('get_option_gender')) {

    function get_option_gender($option_selected = '') {
        $html = '';
        $ci = & get_instance();
        $ci->config->load('params');
        $genders = $ci->config->item('gender');
        foreach ($genders['data'] as $key => $value) {
            $selected = '';
            if ($option_selected == $key) {
                $selected = ' selected="selected"';
            }
            $html .= "<option value='$key' $selected>" . $value . "</option>";
        }

        return $html;
    }

}

if (!function_exists('get_gender')) {

    function get_gender($gender_key = '') {
        $html = '';
        $ci = & get_instance();
        $ci->config->load('params');
        $genders = $ci->config->item('gender');
        if (isset($genders['data'][$gender_key])) {
            $html .= $genders['data'][$gender_key];
        }

        return $html;
    }

}

if (!function_exists('number_format_en')) {
    /*
     * format number n000 to n,000.00
     */

    function number_format_en($number, $decimals = 2) {
        return number_format($number, $decimals, '.', ',');
    }

}

if (!function_exists('number_format_vi')) {
    /*
     * format number n000 to n.000,00
     */

    function number_format_vi($number, $decimals = 2) {
        return number_format($number, $decimals, ',', '.');
    }

}

if (!function_exists('number_format_normal')) {
    /*
     * format number n000 to n.000.00
     */

    function number_format_normal($number, $decimals = 2) {
        return number_format($number, $decimals, '.', '.');
    }

}

if (!function_exists('format_m_d_Y_strtotime')) {
    /*
     * convert date format m-d-Y or m/d/Y to Y-m-d
     */

    function format_m_d_Y_strtotime($str, $separator = '-') {
        $dates = explode($separator, $str);
        return $dates[2] . '-' . $dates[0] . '-' . $dates[1];
    }

}

if (!function_exists('format_d_m_Y_strtotime')) {
    /*
     * convert date format d-m-Y or d/m/Y to Y-m-d
     */

    function format_d_m_Y_strtotime($str, $separator = '-') {
        $dates = explode($separator, $str);
        return $dates[2] . '-' . $dates[1] . '-' . $dates[0];
    }

}

if (!function_exists('get_tag')) {

    function get_tag($tag, $xml) {
        preg_match_all('/<' . $tag . '>(.*)<\/' . $tag . '>$/imU', $xml, $match);
        return $match[1];
    }

}

if (!function_exists('get_rand_string')) {

    function get_rand_string($length = 11) {
        $str = '';
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }
        return $str;
    }

}

if (!function_exists('is_bot')) {

    function is_bot() {
        /* This function will check whether the visitor is a search engine robot */

        $botlist = array("Teoma", "alexa", "froogle", "Gigabot", "inktomi",
            "looksmart", "URL_Spider_SQL", "Firefly", "NationalDirectory",
            "Ask Jeeves", "TECNOSEEK", "InfoSeek", "WebFindBot", "girafabot",
            "crawler", "www.galaxy.com", "Googlebot", "Scooter", "Slurp",
            "msnbot", "appie", "FAST", "WebBug", "Spade", "ZyBorg", "rabaz",
            "Baiduspider", "Feedfetcher-Google", "TechnoratiSnoop", "Rankivabot",
            "Mediapartners-Google", "Sogou web spider", "WebAlta Crawler", "TweetmemeBot",
            "Butterfly", "Twitturls", "Me.dium", "Twiceler");

        foreach ($botlist as $bot) {
            if (strpos($_SERVER['HTTP_USER_AGENT'], $bot) !== false)
                return true; // Is a bot
        }

        return false; // Not a bot
    }

}

if (!function_exists('str_remove_unicode_space')) {

    function str_remove_unicode_space($str = '', $removeSpace = false) {
        $result = "";

//Loại bỏ dấu tiếng việt
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach ($unicode as $nonUnicode => $uni) {
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }

//Xóa khoảng trắng
        if ($removeSpace == true) {
            $arr = explode(" ", $str);
            foreach ($arr as $k => $v) {
                $result .= $v;
            }
        } else {
            $result = $str;
        }

        return $result;
    }

}


if (!function_exists('str_standardize')) {

    function str_standardize($str = '') {
        $str = trim($str); // xóa tất cả các khoảng trắng còn thừa ở đầu và cuối chuỗi
        $str = preg_replace('/\s(?=\s)/', '', $str); // Thay thế nhiều khoảng trắng liên tiếp nhau trong chuỗi = 1 khoảng trắng duy nhất   
        $str = preg_replace('/[\n\r\t]/', ' ', $str); // Thay thế những kí tự đặc biệt: xuống dòng, tab = khoảng trắng

        return $str;
    }

}

if (!function_exists('replace_special_url')) {

    function replace_special_url($str = '') {
        $pattern = '/[^\w\d\s]/';
//$str = str_remove_unicode_space($str);
        $str = preg_replace($pattern, "-", $str);
        $str = str_replace(" ", "-", $str);
        $str = preg_replace('/\-(?=\-)/', '', $str);

        return $str;
    }

}

if (!function_exists('show_alert_success')) {

    function show_alert_success($str = '') {
        $html = '';
        if (trim($str) != '') {
            $html .= '
              <div class="alert alert-dismissable alert-success">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <strong>' . $str . '</strong>
              </div>';
        }
        return $html;
    }

}

if (!function_exists('show_alert_danger')) {

    function show_alert_danger($str = '') {
        $html = '';
        if (trim($str) != '') {
            $html .= '
              <div class="alert alert-dismissable alert-danger">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <strong>' . $str . '</strong>
              </div>';
        }
        return $html;
    }

}

if (!function_exists('show_alert_warning')) {

    function show_alert_warning($str = '') {
        $html = '';
        if (trim($str) != '') {
            $html .= '
              <div class="alert alert-dismissable alert-warning">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <h4>' . $str . '</h4>
              </div>';
        }
        return $html;
    }

}

if (!function_exists('display_date')) {

    function display_date($timestamp = 0) {
        $html = '';
        $html .= date('H:s d/m/Y', $timestamp);

        return $html;
    }

}

if (!function_exists('get_day_of_week_vi')) {

    function get_day_of_week_vi($strtotime = 0) {
        $day = date('w', $strtotime);
        switch ($day) {
            case 0:
                $thu = "Chủ nhật";
                break;
            case 1:
                $thu = "Thứ hai";
                break;
            case 2:
                $thu = "Thứ ba";
                break;
            case 3:
                $thu = "Thứ tư";
                break;
            case 4:
                $thu = "Thứ năm";
                break;
            case 5:
                $thu = "Thứ sáu";
                break;
            case 6:
                $thu = "Thứ bảy";
                break;
            default: $thu = "";
                break;
        }
        return $thu;
    }

}

if (!function_exists('php_truncate')) {

    function php_truncate($text, $length) {
        $length = abs((int) $length);
        if (mb_strlen($text, 'UTF-8') > $length) {
            $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
        }
        return($text);
    }

}

if (!function_exists('formatRiceVND')) {

    function formatRiceVND($price = 0) {
        $symbol = ' VND';
        $symbol_thousand = '.';
        $decimal_place = 0;
        $number = number_format($price, $decimal_place, '', $symbol_thousand);
        return $number . $symbol;
    }

}

if (!function_exists('formatRice')) {

    function formatRice($price = 0) {
        $symbol_thousand = '.';
        $decimal_place = 0;
        $number = number_format($price, $decimal_place, '', $symbol_thousand);
        return $number;
    }

}

if (!function_exists('alias')) {

    function alias($str = '', $removeSpace = false) {
        $result = "";

//Loại bỏ dấu tiếng việt
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach ($unicode as $nonUnicode => $uni) {
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }

//Xóa khoảng trắng
        if ($removeSpace == true) {
            $arr = explode(" ", $str);
            foreach ($arr as $k => $v)
                $result .= $v;
        } else {
            $result = $str;
        }

        $pattern = '/[^\w\d\s]/';
        $str = $result;
        $str = preg_replace($pattern, "-", $str);
        $result = str_replace(" ", "-", $str);

//$str = str_only_character($str);
//return $str;


        $character = '-';
        $str = $result;
        $result = '';

        $arr_Temps = explode($character, $str);
        foreach ($arr_Temps as $key => $value) {
            if ($value == '') {
                unset($arr_Temps[$key]);
            }
        }

        $end = count($arr_Temps) - 1;
        $i = 0;

        foreach ($arr_Temps as $key => $value) {
            if ($value != '') {
                $result .= $value;
                if ($i != $end) {
                    $result .= $character;
                }
            }
            $i++;
        }

        return $result;
    }

}

if (!function_exists('get_product_discounts')) {

    function get_product_discounts($product_price = 0, $product_sales_price = 0) {
        return ($product_sales_price > 0 ? $product_sales_price : $product_price);
    }

}

if (!function_exists('get_promotion_price')) {

	function get_promotion_price($product_price = 0, $product_promotion_price = 0) {
		if($product_promotion_price > 0 && $product_promotion_price < $product_price){
			$price = $product_promotion_price;
		}else{
			$price = $product_price;
		}
		return $price;
	}

}

if (!function_exists('convert_to_lowercase')) {
	function convert_to_lowercase($word = '') {
		return mb_strtolower($word, 'UTF-8');
	}
}

if (!function_exists('convert_to_uppercase')) {
	function convert_to_uppercase($word = '') {
		return mb_strtoupper($word, 'UTF-8');
	}
}

if (!function_exists('display_option_select')) {

    function display_option_select($data, $option_value = 'id', $option_name = 'name', $option_selected = 0) {
        $html = '';

        if (is_array($data) && !empty($data)) {
            foreach ($data as $value) {
                $selected = '';
                if (is_array($option_selected) && in_array($value[$option_value], $option_selected)) {
                    $selected = ' selected="selected"';
                } elseif ($value[$option_value] == $option_selected) {
                    $selected = ' selected="selected"';
                }
                $html .= "\n";
                $html .= '<option' . $selected . ' value="' . $value[$option_value] . '"' . '>' . $value[$option_name] . '</option>';
            }
        }

        return $html;
    }

}

function parse_id_cart($str_id = '', $all = false) {
    $str = explode('_', $str_id);
    if ($all) {
        $data = array();
        $data['product_id'] = isset($str[0]) ? (int) $str[0] : 0;
        $data['unit_id'] = isset($str[1]) ? (int) $str[1] : 0;
    } else {
        $data = 0;
        if (isset($str[0])) {
            $data = (int) $str[0];
        }
    }

    return $data;
}

//Lê Văn Nhàn
/* End of file master_helper.php */
/* Location: ./application/helpers/master_helper.php */