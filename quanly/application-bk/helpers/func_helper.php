<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

if(!function_exists('pre')){
    function pre($data, $bool = false){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if($bool){
            die;
        }
    }
}

if(!function_exists('get_CI')){
    function get_CI(){
        $CI =& get_instance();
        
        return $CI;
    }
}

if (!function_exists('get_statistics')) {
	function get_statistics($product_id = 0, $warehouse_id = 0, $options = array()) {
		$CI = get_CI();
		
		$total_quantity_purchase_voucher_import_warehouse = $total_quantity_purchase_voucher_transaction_warehouse_subtraction = $total_quantity_purchase_voucher_transaction_warehouse_addition = 0;
		$total_monetized_purchase_voucher_import_warehouse = $total_monetized_purchase_voucher_transaction_warehouse_subtraction = $total_monetized_purchase_voucher_transaction_warehouse_addition = 0;

		$args_purchase_voucher_import_details = array(
			'product_id' => $product_id,
			'type' => 'import',
		);
    	if ($warehouse_id != 0) {
			$args_purchase_voucher_import_details['warehouse_id'] = $warehouse_id;
		}
    	$products_purchase_voucher_import_details = $CI->M_purchase_voucher_details->gets($args_purchase_voucher_import_details);
    	if(is_array($products_purchase_voucher_import_details) && !empty($products_purchase_voucher_import_details)){
    		$total_quantity_purchase_voucher_import_warehouse = array_sum(array_column($products_purchase_voucher_import_details, 'quantity'));
    		$total_monetized_purchase_voucher_import_warehouse = array_sum(array_column($products_purchase_voucher_import_details, 'monetized'));
    	}

    	$args_purchase_voucher_transaction_subtraction_details = array(
			'product_id' => $product_id,
			'type' => 'transaction',
		);
    	if ($warehouse_id != 0) {
			$args_purchase_voucher_transaction_subtraction_details['warehouse_id'] = $warehouse_id;
		}
		if (isset($options['start_date_start'])) {
			$args_purchase_voucher_transaction_subtraction_details['start_date_start'] = $options['start_date_start'];
		}
		if (isset($options['start_date_end'])) {
			$args_purchase_voucher_transaction_subtraction_details['start_date_end'] = $options['start_date_end'];
		}
    	$products_purchase_voucher_transaction_subtraction_details = $CI->M_purchase_voucher_details->gets($args_purchase_voucher_transaction_subtraction_details);
    	if(is_array($products_purchase_voucher_transaction_subtraction_details) && !empty($products_purchase_voucher_transaction_subtraction_details)){
    		$total_quantity_purchase_voucher_transaction_warehouse_subtraction = array_sum(array_column($products_purchase_voucher_transaction_subtraction_details, 'quantity'));
    		$total_monetized_purchase_voucher_transaction_warehouse_subtraction = array_sum(array_column($products_purchase_voucher_transaction_subtraction_details, 'monetized'));
    	}

    	$args_purchase_voucher_transaction_addition_details = array(
			'product_id' => $product_id,
			'type' => 'transaction',
		);
    	if ($warehouse_id != 0) {
			$args_purchase_voucher_transaction_addition_details['transaction_warehouse_id'] = $warehouse_id;
		}
		if (isset($options['start_date_start'])) {
			$args_purchase_voucher_transaction_addition_details['start_date_start'] = $options['start_date_start'];
		}
		if (isset($options['start_date_end'])) {
			$args_purchase_voucher_transaction_addition_details['start_date_end'] = $options['start_date_end'];
		}
    	$products_purchase_voucher_transaction_addition_details = $CI->M_purchase_voucher_details->gets($args_purchase_voucher_transaction_addition_details);
    	if(is_array($products_purchase_voucher_transaction_addition_details) && !empty($products_purchase_voucher_transaction_addition_details)){
    		$total_quantity_purchase_voucher_transaction_warehouse_addition = array_sum(array_column($products_purchase_voucher_transaction_addition_details, 'quantity'));
    		$total_monetized_purchase_voucher_transaction_warehouse_addition = array_sum(array_column($products_purchase_voucher_transaction_addition_details, 'monetized'));
    	}

    	$total_quantity_purchase_voucher = $total_quantity_purchase_voucher_import_warehouse - $total_quantity_purchase_voucher_transaction_warehouse_subtraction + $total_quantity_purchase_voucher_transaction_warehouse_addition;
    	$total_monetized_purchase_voucher = $total_monetized_purchase_voucher_import_warehouse - $total_monetized_purchase_voucher_transaction_warehouse_subtraction + $total_monetized_purchase_voucher_transaction_warehouse_addition;

    	$args_output_voucher_details = array(
			'product_id' => $product_id,
		);
		if ($warehouse_id != 0) {
			$args_output_voucher_details['warehouse_id'] = $warehouse_id;
		}
		if (isset($options['start_date_start'])) {
			$args_output_voucher_details['start_date_start'] = $options['start_date_start'];
		}
		if (isset($options['start_date_end'])) {
			$args_output_voucher_details['start_date_end'] = $options['start_date_end'];
		}
    	$products_output_voucher_details = $CI->M_output_voucher_details->gets($args_output_voucher_details);
    	$total_quantity_output_voucher_retail = 0;
    	$total_quantity_output_voucher_cost = 0;
    	$total_monetized_output_voucher_retail = 0;
    	$total_monetized_output_voucher_cost = 0;
    	if(is_array($products_output_voucher_details) && !empty($products_output_voucher_details)){
    		foreach ($products_output_voucher_details as $value) {
    			if($value['price_type'] == 'cost_price'){
    				$total_quantity_output_voucher_cost += $value['quantity'];
    				$total_monetized_output_voucher_cost += $value['monetized'];
	    		}else{
	    			$total_quantity_output_voucher_retail += $value['quantity'];
	    			$total_monetized_output_voucher_retail += $value['monetized'];
	    		}
    		}
    	}

        return array(
        	'import' => $total_quantity_purchase_voucher,
        	'import_monetized' => $total_monetized_purchase_voucher,
        	'export_retail' => $total_quantity_output_voucher_retail,
        	'export_cost' => $total_quantity_output_voucher_cost,
        	'export_retail_monetized' => $total_monetized_output_voucher_retail,
        	'export_cost_monetized' => $total_monetized_output_voucher_cost,
        	'inventory' => $total_quantity_purchase_voucher - ($total_quantity_output_voucher_cost + $total_quantity_output_voucher_retail)
        );
	}
}

if (!function_exists('time_ago')) {
	function time_ago($time_ago = 0){
	    //$time_ago = strtotime($time_ago);
	    $cur_time   = time();
	    $time_elapsed   = $cur_time - $time_ago;
	    $seconds    = $time_elapsed ;
	    $minutes    = round($time_elapsed / 60 );
	    $hours      = round($time_elapsed / 3600);
	    $days       = round($time_elapsed / 86400 );
	    $weeks      = round($time_elapsed / 604800);
	    $months     = round($time_elapsed / 2600640 );
	    $years      = round($time_elapsed / 31207680 );
	    // Seconds
	    if($seconds <= 60){
	        return "just now";
	    }
	    //Minutes
	    else if($minutes <=60){
	        if($minutes==1){
	            //return "one minute ago";
	            return "một phút trước";
	        }
	        else{
	            //return "$minutes minutes ago";
	            return "$minutes phút trước";
	        }
	    }
	    //Hours
	    else if($hours <=24){
	        if($hours==1){
	            //return "an hour ago";
	            return "một giờ trước";
	        }else{
	            //return "$hours hrs ago";
	            return "$hours giờ trước";
	        }
	    }
	    //Days
	    else if($days <= 7){
	        if($days==1){
	            //return "yesterday";
	            return "hôm qua";
	        }else{
	            //return "$days days ago";
	            return "$days ngày trước";
	        }
	    }
	    //Weeks
	    else if($weeks <= 4.3){
	        if($weeks==1){
	            //return "a week ago";
	            return "một tuần trước";
	        }else{
	            //return "$weeks weeks ago";
	            return "$weeks tuần trước";
	        }
	    }
	    //Months
	    else if($months <=12){
	        if($months==1){
	            //return "a month ago";
	            return "một tháng trước";
	        }else{
	            //return "$months months ago";
	            return "$months tháng trước";
	        }
	    }
	    //Years
	    else{
	        if($years==1){
	            //return "one year ago";
	            return "một năm trước";
	        }else{
	            //return "$years years ago";
	            return "$years năm trước";
	        }
	    }
	}
}

if (!function_exists('get_current_user')) {
	function get_current_user(){
		$ci = &get_instance();
		$data = NULL;
		if ($ci->session->has_userdata('logged_in')) {
			$session_data = $ci->session->userdata('logged_in');
            $data['userid'] = (int) $session_data['userid'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['photo'] = $session_data['photo'];
			$data['regdate'] = isset($session_data['regdate']) ? $session_data['regdate'] : '';
			$data['role'] = $session_data['role'];
			$data['have_add'] = $session_data['have_add'];
			$data['have_edit'] = $session_data['have_edit'];
			$data['have_delete'] = $session_data['have_delete'];

			if (trim($data['photo']) != '' && remote_file_exists($data['photo'])) {
				$data['avatar'] = $data['photo'];
			} else {
				$data['avatar'] = 'no_avatar.jpg';
			}
		}

		if ($ci->session->has_userdata('logged_in_by')) {
            $session_data = $ci->session->userdata('logged_in_by');
            $data['userid'] = (int) $session_data['userid'];
			$data['username'] = $session_data['username'];
			$data['full_name'] = $session_data['full_name'];
			$data['photo'] = $session_data['photo'];
			$data['regdate'] = isset($session_data['regdate']) ? $session_data['regdate'] : '';
			$data['role'] = $session_data['role'];
			$data['have_add'] = $session_data['have_add'];
			$data['have_edit'] = $session_data['have_edit'];
			$data['have_delete'] = $session_data['have_delete'];

			if (trim($data['photo']) != '' && remote_file_exists($data['photo'])) {
				$data['avatar'] = $data['photo'];
			} else {
				$data['avatar'] = 'no_avatar.jpg';
			}
        }
        return $data;
    }
}

if (!function_exists('get_current_user_id')) {
	function get_current_user_id(){
		$ci = &get_instance();
		$user_id = 0;
		if ($ci->session->has_userdata('logged_in')) {
			$session_data = $ci->session->userdata('logged_in');
			$user_id = (int) $session_data['userid'];
		}

		if ($ci->session->has_userdata('logged_in_by')) {
            $session_data = $ci->session->userdata('logged_in_by');
            $user_id = (int) $session_data['userid'];
        }
        return $user_id;
    }
}

if (!function_exists('add_activity')) {
	function add_activity($activity = ''){
		if($activity == ''){
			return;
		}
		$ci = &get_instance();
		$user_id = get_current_user_id();
		if($user_id == 0){
			return;
		}
		$data = array(
			'user_id' => $user_id,
			'activity' => $activity,
			'ip' => $ci->input->ip_address(),
			'status' => 1,
			'created' => time(),
		);
		$ci->M_users_activities->add($data);
	}
}

if (!function_exists('add_activities')) {
	function add_activities($data = NULL){
		if(!$data){
			return;
		}
		$ci = &get_instance();
		$user_id = get_current_user_id();
		if($user_id == 0){
			return;
		}
		if(!(isset($data['activity']) && trim($data['activity']) != '')){
			return;
		}
		$data['user_id'] = $user_id;
		$data['ip'] = $ci->input->ip_address();
		$data['status'] = 1;
		$data['created'] = time();
		$ci->M_users_activities->add($data);
	}
}

if (!function_exists('get_commission_user')) {
	function get_commission_user($in_user_id = 0) {
		$ci = &get_instance();

        $total_commission_buy = $ci->M_users_commission->get_total(array(
            'in_user_id' => $in_user_id,
            'status' => 1,
            'in_action' => array('SUB_BUY_MY', 'SUB_BUY_ROOT')
        ));

        $total_buy = $ci->M_users_commission->get_total(array(
            'in_user_id' => $in_user_id,
            'status' => 1,
            'in_action' => array('BUY')
        ));

        $balance =  $total_commission_buy + $total_buy;

        return array(
        	'total_commission_buy' => abs($total_commission_buy),
        	'total_buy' => abs($total_buy),
        	'balance' => abs($balance),
        );
	}
}

if (!function_exists('get_balance')) {
	function get_balance($in_user_id = 0) {
		$data = get_commission_user($in_user_id);
        return $data['balance'];
	}
}

if (!function_exists('get_net_revenue')) {
	function get_net_revenue($in_user_id = 0) {
		$data = get_commission_user($in_user_id);
        return $data['total_buy'];
	}
}

if (!function_exists('convert_number_to_words')) {
	function convert_number_to_words($number) {
		$hyphen = ' ';
		$conjunction = '  ';
		$separator = ' ';
		$negative = 'âm ';
		$decimal = ' phẩy ';
		$dictionary = array(
			0 => 'không',
			1 => 'một',
			2 => 'hai',
			3 => 'ba',
			4 => 'bốn',
			5 => 'năm',
			6 => 'sáu',
			7 => 'bảy',
			8 => 'tám',
			9 => 'chín',
			10 => 'mười',
			11 => 'mười một',
			12 => 'mười hai',
			13 => 'mười ba',
			14 => 'mười bốn',
			15 => 'mười năm',
			16 => 'mười sáu',
			17 => 'mười bảy',
			18 => 'mười tám',
			19 => 'mười chín',
			20 => 'hai mươi',
			30 => 'ba mươi',
			40 => 'bốn mươi',
			50 => 'năm mươi',
			60 => 'sáu mươi',
			70 => 'bảy mươi',
			80 => 'tám mươi',
			90 => 'chín mươi',
			100 => 'trăm',
			1000 => 'nghìn',
			1000000 => 'triệu',
			1000000000 => 'tỷ',
			1000000000000 => 'nghìn tỷ',
			1000000000000000 => 'nghìn triệu triệu',
			1000000000000000000 => 'tỷ tỷ',
		);
		if (!is_numeric($number)) {
			return false;
		}
		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			// overflow
			trigger_error(
				'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
				E_USER_WARNING
			);
			return false;
		}
		if ($number < 0) {
			return $negative . convert_number_to_words(abs($number));
		}
		$string = $fraction = null;
		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}
		switch (true) {
		case $number < 21:
			$string = $dictionary[$number];
			break;
		case $number < 100:
			$tens = ((int) ($number / 10)) * 10;
			$units = $number % 10;
			$string = $dictionary[$tens];
			if ($units) {
				$string .= $hyphen . $dictionary[$units];
			}
			break;
		case $number < 1000:
			$hundreds = $number / 100;
			$remainder = $number % 100;
			$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
			if ($remainder) {
				$string .= $conjunction . convert_number_to_words($remainder);
			}
			break;
		default:
			$baseUnit = pow(1000, floor(log($number, 1000)));
			$numBaseUnits = (int) ($number / $baseUnit);
			$remainder = $number % $baseUnit;
			$string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
			if ($remainder) {
				$string .= $remainder < 100 ? $conjunction : $separator;
				$string .= convert_number_to_words($remainder);
			}
			break;
		}
		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}
		return $string;
	}
}

if (!function_exists('encrip_password')) {
	function encrip_password($password = '') {
        return md5($password);
    }
}

if (!function_exists('get_first_element')) {
	function get_first_element($data = '') {
		$str = $data;
		if (is_array($data) && !empty($data)) {
			$str = reset($data);
		}
		return $str;
	}
}

if (!function_exists('current_full_url')) {
	function current_full_url() {
		$CI = &get_instance();
		$url = $CI->config->site_url($CI->uri->uri_string());
		return $_SERVER['QUERY_STRING'] ? $url . '?' . $_SERVER['QUERY_STRING'] : $url;
	}
}

if (!function_exists('save_image_from_url')) {
	function save_image_from_url($url_to_image = '', $my_save_dir = 'uploads/1.png') {
		$ch = curl_init($url_to_image);
		$fp = fopen($my_save_dir, 'wb');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
	}
}

if (!function_exists('get_asset')) {

	function get_asset($folder = '') {
		$html = '';
		$ci = &get_instance();
		$base_url = $ci->config->item('base_url');
		$html .= $base_url;
		if (trim($folder) != '') {
			$html .= $ci->config->item($folder);
		}

		return $html;
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

if (!function_exists('group_assoc')) {

	function group_assoc($array, $key) {
		$return = array();
		foreach ($array as $v) {
			$return[$v[$key]][] = $v;
		}
		return $return;
	}

}

if (!function_exists('read_number_to_text')) {

	function read_number_to_text($number = 0) {
		$dictionnaryNumbers = array(
			0 => "không",
			1 => "một",
			2 => "hai",
			3 => "ba",
			4 => "bốn",
			5 => "năm",
			6 => "sáu",
			7 => "bẩy",
			8 => "tám",
			9 => "chín",
		);

		$dictionnaryUnits = array(
			// 0 => "tỷ",
			// 1 => "triệu",
			// 2 => "nghìn",
			// 3 => "đồng",
			0 => "nghìn",
			1 => "tỷ",
			2 => "triệu",
			3 => "nghìn",
			4 => "đồng",
		);
		return readNumber12Digits($number, $dictionnaryUnits, $dictionnaryNumbers);
	}

}

if (!function_exists('readNumber3Digits')) {

	function readNumber3Digits($number, $dictionnaryNumber, $readFull = true) {

		// 01 - LẤY CHỮ SỐ HÀNG TRĂM, HÀNG CHỤC, HÀNG ĐƠN VỊ
		$number = strval($number);
		$number = str_pad($number, 3, 0, STR_PAD_LEFT);
		$digit_0 = substr($number, 2, 1);
		$digit_00 = substr($number, 1, 1);
		$digit_000 = substr($number, 0, 1);

		// 02 - HÀNG TRĂM
		$str_000 = $dictionnaryNumber[$digit_000] . " trăm ";

		// 03 - HÀNG CHỤC
		$str_00 = $dictionnaryNumber[$digit_00] . " mươi ";
		if ($digit_00 == 0) {
			$str_00 = " linh ";
		}

		if ($digit_00 == 1) {
			$str_00 = " mười ";
		}

		// 04 - HÀNG ĐƠN VỊ
		$str_0 = $dictionnaryNumber[$digit_0];
		if ($digit_00 > 1 && $digit_0 == 1) {
			$str_0 = " mốt ";
		}

		if ($digit_00 > 0 && $digit_0 == 5) {
			$str_0 = " lăm ";
		}

		if ($digit_00 == 0 && $digit_0 == 0) {
			$str_0 = "";
			$str_00 = "";
		}

		if ($digit_0 == 0) {
			$str_0 = "";
		}

		if ($readFull == false) {
			if ($digit_000 == 0) {
				$str_000 = "";
			}

			if ($digit_000 == 0 && $digit_00 == 0) {
				$str_00 = "";
			}

		}

		$result = $str_000 . $str_00 . $str_0;

		return $result;
	}

}

if (!function_exists('formatString')) {

	function formatString($str, $type = null) {
		// Dua tat ca cac ky tu ve dang chu thuong
		$str = strtolower($str);

		// Loai bo khoang trang dau va cuoi chuoi
		$str = trim($str);

		// Loai bo khoang trang du thua giua cac tu

		$array = explode(" ", $str);
		foreach ($array as $key => $value) {
			if (trim($value) == null) {
				unset($array[$key]);
				continue;
			}

			// Xu ly cho danh tu
			if ($type == "danh-tu") {
				$array[$key] = ucfirst($value);
			}
		}

		$result = implode(" ", $array);

		// Chuyen ky tu dau tien thanh chu hoa
		$result = ucfirst($result);

		return $result;
	}

}

if (!function_exists('readNumber12Digits')) {

	function readNumber12Digits($number, $dictionnaryUnits, $dictionnaryNumbers) {
		$number = strval($number);
		$number = str_pad($number, 15, 0, STR_PAD_LEFT);
		$arrNumber = str_split($number, 3);

		if (is_array($arrNumber) && !empty($arrNumber)) {
			foreach ($arrNumber as $key => $value) {
				if ($value != "000") {
					$index = $key;
					break;
				}
			}
			foreach ($arrNumber as $key => $value) {
				if (isset($index) && $key >= $index) {
					$readFull = true;
					if ($key >= $index) {
						$readFull = false;
					}

					$result[$key] = readNumber3Digits($value, $dictionnaryNumbers, $readFull) . " " . (isset($dictionnaryUnits[$key]) ? $dictionnaryUnits[$key] : '');
				}
			}
		}
		if (isset($result)) {
			$result = implode(" ", $result);
			$result = formatString($result);

			// $result = str_replace("không đồng", "đồng", $result);
			// $result = str_replace("không trăm đồng", "đồng", $result);
			// $result = str_replace("không nghìn đồng", "đồng", $result);
			// $result = str_replace("không trăm nghìn đồng", "đồng", $result);
			$result = str_replace("triệu nghìn đồng", "triệu đồng", $result);
			$result = str_replace("tỷ triệu đồng", "tỷ đồng", $result);
		} else {
			$result = "Không đồng";
		}
		return $result;
	}

}

/*
 * Importion: This is change get access role
 */
if (!function_exists('get_access_role')) {

	function get_access_role($define = '') {
		$arr = array();
		if (trim($define) != '') {
			$ci = &get_instance();
			$arr = $ci->config->item($define, 'role_access');
		}

		return $arr;
	}

}

if (!function_exists('validate_access_role')) {

	function validate_access_role($role = '', $define = '') {
		$bool = FALSE;
		if (trim($role) != '' && trim($define) != '' && in_array($role, get_access_role($define))) {
			$bool = TRUE;
		}

		return $bool;
	}

}

if (!function_exists('redirect_validate_access_role')) {

	function redirect_validate_access_role($role = '', $define = '') {
		if (!validate_access_role($role, $define)) {
			redirect(base_url());
		}
	}

}

/*
 * Importion: This is change page url admin
 */
if (!function_exists('get_admin_url')) {

	function get_admin_url($module_slug = '') {
		$html = '';
		$ci = &get_instance();
		$base_url = $ci->config->item('base_url');
		$html .= $base_url . 'admin';
		if (trim($module_slug) != '') {
			$html .= '/' . $module_slug;
		}

		return $html;
	}

}

if (!function_exists('remove_special_string_textarea')) {

	function remove_special_string_textarea($string = '') {
		return preg_replace("/\r|\n/", "", $string);
	}

}

if (!function_exists('get_start_date')) {

	function get_start_date($str_date) {
		$date = parse_date($str_date) . " 00:00:00";

		return strtotime($date);
	}

}

if (!function_exists('get_end_date')) {

	function get_end_date($str_date) {
		$date = parse_date($str_date) . " 23:59:59";

		return strtotime($date);
	}

}

if (!function_exists('get_current_date')) {

	function get_current_date($str_date) {
		$date = parse_date($str_date) . " " . date('H:i:s');
		return strtotime($date);
	}

}

if (!function_exists('convert_str_to_date')) {

	function convert_str_to_date($str = '') {
		$timestamp = time();
		$arr_str = explode(' ', $str);
		if(isset($arr_str[0]) && $arr_str[1]){
			$timestamp = strtotime(parse_date($arr_str[1], '/') . " " . $arr_str[0]);
		}

		return $timestamp;
	}

}

if (!function_exists('parse_date')) {

	function parse_date($str_date, $separator = '-') {
		$dates = explode($separator, $str_date);
		$str_date = $dates[2] . "-" . $dates[1] . "-" . $dates[0];

		return $str_date;
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

if (!function_exists('get_option_per_page')) {

    function get_option_per_page($option_selected = '') {
        $ci = &get_instance();
        $html = '';
        $data = range($ci->config->item('item', 'admin_list'), $ci->config->item('total', 'admin_list'), $ci->config->item('item', 'admin_list'));
        foreach ($data as $value) {
            $selected = '';
            if ($option_selected == $value) {
                $selected = ' selected="selected"';
            }
            $html .= "<option value='$value' $selected>" . $value . "</option>";
        }

        return $html;
    }

}

function display_table_cat($parentId, $ctgLists, $ctgData, $depth) {
	$char = '&brvbar;&rarr;';
	$html = '';

	if (isset($ctgLists[$parentId])) {
		foreach ($ctgLists[$parentId] as $childId) {
			if ($parentId == 0) {
				$tab = '';
			} else if (isset($ctgLists[$childId])) {
				$tab = str_repeat($char, $depth);
			} else {
				$tab = str_repeat($char, $depth);
			}

			$html .= '<tr>
                        <td class="text-center" style="width: 120px;">
                            <input class="text-right form-control" name="order[]" type="text" value="' . $ctgData[$childId]['order'] . '">
                            <input class="text-right form-control" name="ids[]" type="hidden" value="' . $ctgData[$childId]['lurl'] . '">
                        </td>
                        <td>
                            <strong>' . $tab . $ctgData[$childId]['lname'] . '</strong>
                        </td>
                        <td class="text-center">
                            <em class="fa fa-edit fa-lg">&nbsp;</em> <a href="' . get_admin_url('shops/cat/content/' . $ctgData[$childId]['lurl']) . '" class="">Sửa</a>
                            &nbsp;-&nbsp;
                            <em class="fa fa-trash-o fa-lg">&nbsp;</em> <a title="Xóa" href="' . get_admin_url('shops/cat/delete/' . $ctgData[$childId]['lurl']) . '" class="delete_bootbox">Xóa</a>
                        </td>
                    </tr>';
			$html .= display_table_cat($childId, $ctgLists, $ctgData, $depth + 1);
		}
	}

	return $html;
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
		$ci = &get_instance();
		$modules_path = $ci->config->item('modules_path');
		if (trim($module_name) != '' && isset($modules_path[$module_name])) {
			$html = $modules_path[$module_name];
		}

		return $html;
	}

}

if (!function_exists('get_menutype')) {

	function get_menutype($menu_type, $option_selected = 0) {

		$html = '';
		foreach ($menu_type as $value) {
			$selected = '';
			if ($value["id"] == $option_selected) {
				$selected = ' selected="selected"';
			}
			$html .= "<option value='" . $value['id'] . "' $selected>" . $value["name"] . "</option>";
		}

		return $html;
	}

}

if (!function_exists('display_label')) {

	function display_label($content = '', $lable_type = 'success') {
		$html = '';
		$html .= "<span class='badge badge-$lable_type'>$content</span>";

		return $html;
	}

}

if (!function_exists('get_option_select')) {

	function get_option_select($data, $option_selected = '') {
		$html = '';
		foreach ($data as $key => $value) {
			$selected = '';
            if (strcmp($option_selected, $key) === 0){
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
				$html .= '<option' . $selected . ' value="' . $value[$option_value] . '"' . '>';
				if (is_array($option_name) && !empty($option_name)) {
					$data_name = array();
					foreach ($option_name as $name) {
						if (isset($value[$name]) && trim($value[$name]) != '') {
							$data_name[] = $value[$name];
						}
					}
					$html .= implode(' - ', $data_name);
				} else {
					$html .= $value[$option_name];
				}
				$html .= '</option>';
			}
		}

		return $html;
	}
}

if (!function_exists('get_input_radio_inline')) {

	function get_input_radio_inline($data, $name = 'radio', $input_checked = '') {
		$html = '';
		foreach ($data as $key => $value) {
			$checked = '';
			if ($input_checked == $key) {
				$checked = ' checked="checked"';
			}
			$html .= "<label class=\"radio-inline\"><input type=\"radio\" name=\"$name\" value='$key' $checked>$value</label>";
		}

		return $html;
	}

}

if (!function_exists('get_value_array')) {

	function get_value_array($data, $key) {
		$html = isset($data[$key]) ? $data[$key] : '';
		return $html;
	}

}

if (!function_exists('get_option_gender')) {

	function get_option_gender($option_selected = '') {
		$html = '';
		$ci = &get_instance();
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
		$ci = &get_instance();
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

if (!function_exists('get_children')) {

	function get_children($parentId, $ctgLists, $ctgData) {
		$children = array();

		if (isset($ctgLists[$parentId])) {
			foreach ($ctgLists[$parentId] as $childId) {
				$children[] = $childId;
				$children = array_merge($children, get_children($childId, $ctgLists, $ctgData));
			}
		}

		return $children;
	}

}

if (!function_exists('get_num_children')) {

	function get_num_children($parentId, $ctgLists, $ctgData) {
		$children = array();

		if (isset($ctgLists[$parentId])) {
			foreach ($ctgLists[$parentId] as $childId) {
				$children[] = $childId;
				$children = array_merge($children, get_num_children($childId, $ctgLists, $ctgData));
			}
		}

		return $children;
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
			if (strpos($_SERVER['HTTP_USER_AGENT'], $bot) !== false) {
				return true;
			}
			// Is a bot
		}

		return false; // Not a bot
	}

}

if (!function_exists('remote_file_exists')) {

	function remote_file_exists($url) {
		$curl = curl_init($url);

//don't fetch the actual page, you only want to check the connection is ok
		curl_setopt($curl, CURLOPT_NOBODY, true);

//do request
		$result = curl_exec($curl);

		$ret = false;

//if request did not fail
		if ($result !== false) {
//if request was ok, check response code
			$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

			if ($statusCode == 200) {
				$ret = true;
			}
		}

		curl_close($curl);

		return $ret;
	}

}

if (!function_exists('menu_left')) {

	function menu_left($parentId, $ctgLists, $ctgData) {
		$html = ''; // stores and returns the html code with Menu lists
		// if parent item with child IDs in ctgLists
		if (isset($ctgLists[$parentId])) {
			if ($parentId == 0) {
				$class_ul = ' class="dropdown-menu"';
			} else {
				$class_ul = ' class="dropdown-submenu"';
			}
			if ($parentId != 0) {
				$html = "<ul $class_ul>"; // open UL
			}
// traverses the array with child IDs of current parent, and adds them in LI tags, with their data from $ctgData
			foreach ($ctgLists[$parentId] as $childId) {
// define CSS class in anchors, useful to be used in CSS style to design the menu
				if ($parentId == 0) {
					if (isset($ctgLists[$childId])) {
						$more = ' <i class="fa fa-caret-down"></i>';
					} else {
						$more = '';
					}
					$clsl = ' class="dropdown"'; // class for anchors in main /first categories
				} else if (isset($ctgLists[$childId])) {
					$more = '';
					$clsl = ' class=""'; // class for anchors in main /first categories
				} else {
//$clsl = ' class="dropdown"';       // class for anchors in main /first categories
					$more = '';
					$clsl = ''; // class for anchors in main /first categories
				}

// open LI
				$html .= '<li' . $clsl . '><a tabindex="-1" href="' . $ctgData[$childId]['lurl'] . '" title="' . $ctgData[$childId]['lname'] . '">' . $ctgData[$childId]['lname'] . $more . '</a>';

				$html .= menu_left($childId, $ctgLists, $ctgData); // re-calls the function to find parent with child-items recursively

				$html .= '</li>'; // close LI
			}
			if ($parentId != 0) {
				$html .= '</ul>'; // close UL
			}
		}

		return $html;
	}

}

if (!function_exists('menu_top')) {

	function menu_top($parentId, $ctgLists, $ctgData) {
		$html = '';
		if (isset($ctgLists[$parentId])) {
			if ($parentId == 0) {
				$class_ul = '';
			} else {
				$class_ul = '';
			}
			if ($parentId != 0) {
				$html = "<nav $class_ul>"; // open UL
			}
// traverses the array with child IDs of current parent, and adds them in LI tags, with their data from $ctgData
			foreach ($ctgLists[$parentId] as $childId) {
// define CSS class in anchors, useful to be used in CSS style to design the menu
				if ($parentId == 0) {
					if (isset($ctgLists[$childId])) {
						$more = '';
					} else {
						$more = '';
					}
					$clsl = ' class=""'; // class for anchors in main /first categories
					$clsa = ' class="" data-toggle=""'; // class for anchors in main /first categories
				} else if (isset($ctgLists[$childId])) {
					$more = '';
					$clsl = ' class=""'; // class for anchors in main /first categories
					$clsa = ' class=""'; // class for anchors in lists with childs
				} else {
//$clsl = ' class="dropdown"';       // class for anchors in main /first categories
					$more = '';
					$clsl = ''; // class for anchors in main /first categories
					$clsa = '';
				}

// open LI
				$html .= ' <a href="' . $ctgData[$childId]['lurl'] . '" title="' . $ctgData[$childId]['lname'] . '"' . '>' . $ctgData[$childId]['lname'];

				$html .= menu_top($childId, $ctgLists, $ctgData); // re-calls the function to find parent with child-items recursively

				$html .= '</a> <span class="vert-div">|</span>'; // close LI
			}
			if ($parentId != 0) {
				$html .= '</nav>'; // close UL
			}
		}

		return $html;
	}

}

if (!function_exists('menu_main')) {

	function menu_main($parentId, $ctgLists, $ctgData) {
		$html = ''; // stores and returns the html code with Menu lists
		// if parent item with child IDs in ctgLists
		if (isset($ctgLists[$parentId])) {
			if ($parentId == 0) {
				$class_ul = ' class="nav navbar-nav navbar-right"';
			} else {
				$class_ul = ' class="level1"';
			}
			if ($parentId != 0) {
				$html = "<ul $class_ul>"; // open UL
			}
// traverses the array with child IDs of current parent, and adds them in LI tags, with their data from $ctgData
			foreach ($ctgLists[$parentId] as $childId) {
// define CSS class in anchors, useful to be used in CSS style to design the menu
				if ($parentId == 0) {
					if (isset($ctgLists[$childId])) {
						$more = ' <i class="fa fa-caret-down"></i>';
					} else {
						$more = '';
					}
					$clsl = ' class="level0 parent drop-menu"'; // class for anchors in main /first categories
					$clsa = ''; // class for anchors in main /first categories
				} else if (isset($ctgLists[$childId])) {
					$more = '';
					$clsl = ' class="level1"'; // class for anchors in main /first categories
					$clsa = ''; // class for anchors in lists with childs
				} else {
//$clsl = ' class="dropdown"';       // class for anchors in main /first categories
					$more = '';
					$clsl = ''; // class for anchors in main /first categories
					$clsa = '';
				}

// open LI
				$html .= '<li' . $clsl . '><a href="' . $ctgData[$childId]['lurl'] . '" title="' . $ctgData[$childId]['lname'] . '"' . $clsa . '><span>' . $ctgData[$childId]['lname'] . '</span>' . $more . '</a>';

				$html .= menu_main($childId, $ctgLists, $ctgData); // re-calls the function to find parent with child-items recursively

				$html .= '</li>'; // close LI
			}
			if ($parentId != 0) {
				$html .= '</ul>'; // close UL
			}
		}

		return $html;
	}

}

if (!function_exists('menu_mobile')) {

	function menu_mobile($parentId, $ctgLists, $ctgData) {
		$html = ''; // stores and returns the html code with Menu lists
		if (isset($ctgLists[$parentId])) {
			if ($parentId == 0) {
				$class_ul = ' class="level1"';
			} else {
				$class_ul = ' class=""';
			}
			if ($parentId != 0) {
				$html = "<ul $class_ul>"; // open UL
			}
// traverses the array with child IDs of current parent, and adds them in LI tags, with their data from $ctgData
			foreach ($ctgLists[$parentId] as $childId) {
// define CSS class in anchors, useful to be used in CSS style to design the menu
				if ($parentId == 0) {
					if (isset($ctgLists[$childId])) {
						$more = ' <i class="fa fa-caret-down"></i>';
					} else {
						$more = '';
					}
					$clsl = ' class="level0 parent drop-menu"'; // class for anchors in main /first categories
					$clsa = ''; // class for anchors in main /first categories
				} else if (isset($ctgLists[$childId])) {
					$more = '';
					$clsl = ' class="level1 parent drop-menu"'; // class for anchors in main /first categories
					$clsa = ''; // class for anchors in lists with childs
				} else {
//$clsl = ' class="dropdown"';       // class for anchors in main /first categories
					$more = '';
					$clsl = ''; // class for anchors in main /first categories
					$clsa = '';
				}

// open LI
				$html .= '<li' . $clsl . '><a href="' . $ctgData[$childId]['lurl'] . '" title="' . $ctgData[$childId]['lname'] . '"' . $clsa . '><span>' . $ctgData[$childId]['lname'] . '</span>' . $more . '</a>';

				$html .= menu_main($childId, $ctgLists, $ctgData); // re-calls the function to find parent with child-items recursively

				$html .= '</li>'; // close LI
			}
			if ($parentId != 0) {
				$html .= '</ul>'; // close UL
			}
		}

		return $html;
	}

}

if (!function_exists('menu_bottom')) {

	function menu_bottom($parentId, $ctgLists, $ctgData) {
		$html = ''; // stores and returns the html code with Menu lists
		// if parent item with child IDs in ctgLists
		if (isset($ctgLists[$parentId])) {
			if ($parentId == 0) {
				$class_ul = ' class="nav navbar-nav navbar-right"';
			} else {
				$class_ul = ' class="links"';
			}
			if ($parentId != 0) {
				$html = "<ul $class_ul>"; // open UL
			}
// traverses the array with child IDs of current parent, and adds them in LI tags, with their data from $ctgData
			foreach ($ctgLists[$parentId] as $childId) {
// define CSS class in anchors, useful to be used in CSS style to design the menu
				if ($parentId == 0) {
					if (isset($ctgLists[$childId])) {
						$more = ' <i class="fa fa-caret-down"></i>';
					} else {
						$more = '';
					}
					$clsl = ' class="level0 parent drop-menu"'; // class for anchors in main /first categories
					$clsa = ''; // class for anchors in main /first categories
				} else if (isset($ctgLists[$childId])) {
					$more = '';
					$clsl = ' class="first"'; // class for anchors in main /first categories
					$clsa = ''; // class for anchors in lists with childs
				} else {
//$clsl = ' class="dropdown"';       // class for anchors in main /first categories
					$more = '';
					$clsl = 'last'; // class for anchors in main /first categories
					$clsa = '';
				}

// open LI
				$html .= '<li><a href="' . $ctgData[$childId]['lurl'] . '" title="' . $ctgData[$childId]['lname'] . '"' . $clsa . '>' . $ctgData[$childId]['lname'] . '</a>';

				$html .= menu_bottom($childId, $ctgLists, $ctgData); // re-calls the function to find parent with child-items recursively

				$html .= '</li>'; // close LI
			}
			if ($parentId != 0) {
				$html .= '</ul>'; // close UL
			}
		}

		return $html;
	}

}

if (!function_exists('multilevelMenu')) {

	function multilevelMenu($parentId, $ctgLists, $ctgData) {
		$html = ''; // stores and returns the html code with Menu lists
		// if parent item with child IDs in ctgLists
		if (isset($ctgLists[$parentId])) {
			if ($parentId == 0) {
				$class_ul = ' class="nav navbar-nav navbar-right"';
			} else {
				$class_ul = ' class="dropdown-menu"';
			}
			if ($parentId != 0) {
				$html = "<ul $class_ul>"; // open UL
			}
// traverses the array with child IDs of current parent, and adds them in LI tags, with their data from $ctgData
			foreach ($ctgLists[$parentId] as $childId) {
// define CSS class in anchors, useful to be used in CSS style to design the menu
				if ($parentId == 0) {
					if (isset($ctgLists[$childId])) {
						$more = ' <i class="fa fa-caret-down"></i>';
					} else {
						$more = '';
					}
					$clsl = ' class="dropdown"'; // class for anchors in main /first categories
					$clsa = ' class="dropdown-toggle" data-toggle="dropdown"'; // class for anchors in main /first categories
				} else if (isset($ctgLists[$childId])) {
					$more = '';
					$clsl = ' class=""'; // class for anchors in main /first categories
					$clsa = ' class="dropdown-toggle" data-toggle="dropdown"'; // class for anchors in lists with childs
				} else {
//$clsl = ' class="dropdown"';       // class for anchors in main /first categories
					$more = '';
					$clsl = ''; // class for anchors in main /first categories
					$clsa = '';
				}

// open LI
				$html .= '<li' . $clsl . '><a tabindex="-1" href="' . $ctgData[$childId]['lurl'] . '" title="' . $ctgData[$childId]['lname'] . '"' . $clsa . '>' . $ctgData[$childId]['lname'] . $more . '</a>';

				$html .= multilevelMenu($childId, $ctgLists, $ctgData); // re-calls the function to find parent with child-items recursively

				$html .= '</li>'; // close LI
			}
			if ($parentId != 0) {
				$html .= '</ul>'; // close UL
			}
		}

		return $html;
	}

}

if (!function_exists('multilevelOption')) {

	function multilevelOption($parentId, $ctgLists, $ctgData, $depth, $catid) {
		$char = '&brvbar;&rarr;';
		$html = '';

		if (isset($ctgLists[$parentId])) {
			foreach ($ctgLists[$parentId] as $childId) {
				if ($parentId == 0) {
					$tab = '';
				} else if (isset($ctgLists[$childId])) {
					$tab = str_repeat($char, $depth);
				} else {
					$tab = str_repeat($char, $depth);
				}

				$radio_checked = '';
				if ($ctgData[$childId]['lurl'] === $catid) {
					$radio_checked = ' selected="selected"';
				}

				$html .= "\n";
				$html .= '<option' . $radio_checked . ' value="' . $ctgData[$childId]['lurl'] . '" title="' . $ctgData[$childId]['lname'] . '"' . '>' . $tab . $ctgData[$childId]['lname'] . '</option>';
				$html .= multilevelOption($childId, $ctgLists, $ctgData, $depth + 1, $catid);
			}
		}

		return $html;
	}

}
if (!function_exists('multilevelOptionParentid')) {

	function multilevelOptionParentid($parentId, $ctgLists, $ctgData, $depth, $catid, $pid) {
		$char = '&brvbar;&rarr;';
		$html = '';

		if (isset($ctgLists[$parentId])) {
			foreach ($ctgLists[$parentId] as $childId) {
				if ($parentId == 0) {
					$tab = '';
				} else if (isset($ctgLists[$childId])) {
					$tab = str_repeat($char, $depth);
				} else {
					$tab = str_repeat($char, $depth);
				}

				$selected = '';
				if ($ctgData[$childId]['lurl'] === $pid) {
					$selected = ' selected="selected"';
				}

				if ($ctgData[$childId]['lurl'] != $catid) {
					$html .= "\n";
					$html .= '<option' . $selected . ' value="' . $ctgData[$childId]['lurl'] . '"' . '>' . $tab . $ctgData[$childId]['lname'] . '</option>';
					$html .= multilevelOptionParentid($childId, $ctgLists, $ctgData, $depth + 1, $catid, $pid);
				}
			}
		}

		return $html;
	}

}

if (!function_exists('multilevelCheckbox')) {

	function multilevelCheckbox($parentId, $ctgLists, $ctgData, $depth, $checkedLists, $catid) {
		$char = "&nbsp;";
		$html = '';

		if (isset($ctgLists[$parentId])) {
			foreach ($ctgLists[$parentId] as $childId) {
				if ($parentId == 0) {
					$tab = '';
				} else if (isset($ctgLists[$childId])) {
					$tab = str_repeat($char, $depth * 6);
				} else {
					$tab = str_repeat($char, $depth * 6);
				}

				$checked = '';
				if (in_array($ctgData[$childId]['lurl'], $checkedLists)) {
					$checked = ' checked="checked"';
				}

				$radio_checked = '';
				if ($ctgData[$childId]['lurl'] === $catid) {
					$radio_checked = ' checked="checked"';
				}

				$html .= "\n";
				$html .= "<tr>";
				$html .= '<td>' . $tab . '<input type="checkbox"' . $checked . ' value="' . $ctgData[$childId]['lurl'] . '" name="catids[]" />' . $char . $ctgData[$childId]['lname'] . '</td>';
				$html .= '<td><input id="catright_' . $ctgData[$childId]['lurl'] . '" style=" display: none;" type="radio" name="catid" title="Chủ đề chính cho bài viết"' . $radio_checked . ' value="' . $ctgData[$childId]['lurl'] . '" /></td>';
				$html .= "</tr>";
				$html .= multilevelCheckbox($childId, $ctgLists, $ctgData, $depth + 1, $checkedLists, $catid);
			}
		}

		return $html;
	}

}

if (!function_exists('multilevelSelectbox')) {

	function multilevelSelectbox($parentId, $ctgLists, $ctgData, $depth, $catid) {
		$char = '&brvbar;&rarr;';
		$html = '';

		if (isset($ctgLists[$parentId])) {
			foreach ($ctgLists[$parentId] as $childId) {
				if ($parentId == 0) {
					$tab = '';
				} else if (isset($ctgLists[$childId])) {
					$tab = str_repeat($char, $depth * 1);
				} else {
					$tab = str_repeat($char, $depth * 1);
				}

				$selected = '';
				if ($ctgData[$childId]['lurl'] === $catid) {
					$selected = ' selected="selected"';
				}
				$html .= "\n";
				$html .= '<option' . $selected . ' value="' . $ctgData[$childId]['lurl'] . '"' . '>' . $tab . $ctgData[$childId]['lname'] . '</option>';
				$html .= multilevelSelectbox($childId, $ctgLists, $ctgData, $depth + 1, $catid);
			}
		}

		return $html;
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

	function display_date($timestamp = 0, $is_full = false) {
		$html = '';
		if($is_full){
			$html .= date('H:i:s d/m/Y', $timestamp);
		}else{
			$html .= date('H:i d/m/Y', $timestamp);
		}

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
		default:$thu = "";
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
		return ($text);
	}

}

if (!function_exists('format_number')) {

	function format_number($price = 0) {
		$symbol_thousand = '.';
		$decimal_place = 0;
		$number = number_format($price, $decimal_place, '', $symbol_thousand);
		return $number;
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
		$symbol_thousand = ',';
		$decimal_place = 0;
		$number = number_format($price, $decimal_place, '', $symbol_thousand);
		return $number;
	}

}

if (!function_exists('format_rice_en')) {

	function format_rice_en($price = 0) {
		$symbol_thousand = ',';
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
			foreach ($arr as $k => $v) {
				$result .= $v;
			}

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

	function get_product_discounts($product_price = 0, $product_discounts = 0) {
		$price = $product_price * (1 - ($product_discounts / 100));
		$price = round($price);
		return round($price, -3);
	}

}

if (!function_exists('price_discounts')) {

	function price_discounts($product_price = 0, $product_discounts = 0) {
		$price = $product_price * (1 - ($product_discounts / 100));
		$price = round($price);
		return round($price, -3);
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

if (!function_exists('numberFormatDecode')) {
	function numberFormatDecode($num = '') {
	    return str_replace(',', '', strval($num));
	}
}

if (!function_exists('numberFormatEncode')) {
	function numberFormatEncode($num = 0) {
	    return number_format($num, 1, '.', '');
	}
}

//Lê Văn Nhàn
/* End of file func_helper.php */
/* Location: ./application/helpers/func_helper.php */