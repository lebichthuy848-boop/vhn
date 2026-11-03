<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';
class Filter_details extends Layout {
    function __construct() {
        parent::__construct();
        $this->load->model('shops/m_shops_filter_details', 'M_shops_filter_details');
    }

	function default_args() {
		$order_by = array(
			'created' => 'ASC',
			'modified' => 'DESC',
		);
		$args = array();
		$args['order_by'] = $order_by;

		return $args;
	}

	function validate_exist($options = array()) {
        $default_args = $this->default_args();

        if(is_array($options) && !empty($options)){
            $args = array_merge($default_args, $options);
        }else{
            $args = $default_args;
        }
        $data = $this->get($args);

        if (is_array($data) && !empty($data)) {
            return TRUE;
        }

        return FALSE;
    }

    function get($options = array()) {
        $default_args = $this->default_args();

        if(is_array($options) && !empty($options)){
            $args = array_merge($default_args, $options);
        }else{
            $args = $default_args;
        }
        return $this->M_shops_filter_details->get($args);
    }

    function gets($options = array()) {
		$default_args = $this->default_args();

		if(is_array($options) && !empty($options)){
			$args = array_merge($default_args, $options);
		}else{
			$args = $default_args;
		}

        return $this->M_shops_filter_details->gets($args);
    }

    function add($data = NULL) {
        if (empty($data)) {
            return 0;
        }
        return $this->M_shops_filter_details->add($data);
    }

    function update($args, $data) {
        return $this->M_shops_filter_details->update($args, $data);
    }

    function delete($args) {
        return $this->M_shops_filter_details->delete($args);
    }
}

/* End of file filter_details.php */
/* Location: ./application/modules/shops/controllers/filter_details.php */