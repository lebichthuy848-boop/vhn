<?php

class M_purchase_voucher_details extends CI_Model {

	public $_table_name = 'purchase_voucher_details';

	function __construst() {
		parent::__construst();
	}

	private function generate_where($args) {
		if (isset($args['q'])) {
			$this->db->group_start();
            $this->db->like("products.name", $args['q']);
			$this->db->group_end();
		}

		if (isset($args['provider_id'])) {
			$this->db->where($this->_table_name . ".provider_id", $args['provider_id']);
		}

		if (isset($args['in_provider_id'])) {
			$this->db->where_in($this->_table_name . ".provider_id", $args['in_provider_id']);
		}

		if (isset($args['product_id'])) {
			$this->db->where($this->_table_name . ".product_id", $args['product_id']);
		}

		if (isset($args['start_date_start'])) {
			$this->db->where("pvr.date >=", $args['start_date_start']);
		}

		if (isset($args['start_date_end'])) {
			$this->db->where("pvr.date <=", $args['start_date_end']);
		}

		if (isset($args['type'])) {
			$this->db->where("pvr.type", $args['type']);
		}

		if (isset($args['warehouse_id'])) {
			$this->db->where($this->_table_name . ".warehouse_id", $args['warehouse_id']);
		}

		if (isset($args['transaction_warehouse_id'])) {
			$this->db->where($this->_table_name . ".transaction_warehouse_id", $args['transaction_warehouse_id']);
		}

		if (isset($args['category_id'])) {
			$this->db->where("products.category_id", $args['category_id']);
		}
	}

	private function generate_group_by($args) {
		if (isset($args['group_by']) && is_array($args['group_by']) && !empty($args['group_by'])) {
			foreach ($args['group_by'] as $value) {
				$this->db->group_by($value);
			}
		}
	}

	private function generate_order_by($args) {
		$allow_sort = array("DESC", "ASC", "RANDOM");

		if (isset($args['order_by']) && is_array($args['order_by']) && !empty($args['order_by'])) {
			foreach ($args['order_by'] as $key => $value) {
				$sort = in_array($value, $allow_sort) ? $value : "DESC";
				$this->db->order_by($key, $sort);
			}
		}
	}

	function gets($args, $perpage = 5, $offset = -1) {
		$this->db->select($this->_table_name . '.*' . ', products.name, products.name as product_name, products.id as products_id, products.code as product_code, products.unit as product_unit, pvr.date, pvr.code');
		$this->db->from($this->_table_name);
		$this->db->join('products', 'products.id = ' . $this->_table_name . '.product_id', 'left');
		$this->db->join('purchase_voucher as pvr', 'pvr.id = ' . $this->_table_name . '.purchase_voucher_id', 'left');
		$this->generate_where($args);
		$this->generate_order_by($args);
		$this->generate_group_by($args);
		if ($offset >= 0) {
			$this->db->limit($perpage, $offset);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();

		return $query->result_array();
	}

	function counts($args) {
		$this->db->select('*');
		$this->db->from($this->_table_name);
		$this->db->join('products', 'products.id = ' . $this->_table_name . '.product_id', 'left');
		$this->db->join('purchase_voucher as pvr', 'pvr.id = ' . $this->_table_name . '.purchase_voucher_id', 'left');
		$this->generate_where($args);
		$this->generate_order_by($args);
		$this->generate_group_by($args);

		$query = $this->db->get();

		return $query->num_rows();
	}

	function gets_data($args, $perpage = 5, $offset = -1) {
		$this->db->select($this->_table_name . '.*' . ', products.name, products.name as product_name, products.id as products_id, products.code as product_code, products.unit as product_unit, pvr.date, pvr.code');
		$this->db->from($this->_table_name);
		$this->db->join('products', 'products.id = ' . $this->_table_name . '.product_id', 'left');
		$this->db->join('purchase_voucher as pvr', 'pvr.id = ' . $this->_table_name . '.purchase_voucher_id', 'left');
		$this->generate_where($args);
		$this->generate_order_by($args);
		$this->generate_group_by($args);
		// if ($offset >= 0) {
		// 	$this->db->limit($perpage, $offset);
		// }
		$query = $this->db->get();
		echo $this->db->last_query();

		return $query->result_array();
	}

	function get_data_in_purchase_voucher_id($purchase_voucher_id = 0) {
		$this->db->select($this->_table_name . '.*' . ', products.name as product_name, products.id as product_id, products.unit as product_unit, provider.name as provider_name, warehouse.name as warehouse_name, transaction_warehouse.name as transaction_warehouse_name');
		$this->db->from($this->_table_name);
		$this->db->join('products', 'products.id = ' . $this->_table_name . '.product_id', 'left');
		$this->db->join('provider', 'provider.id = ' . $this->_table_name . '.provider_id', 'left');
		$this->db->join('warehouse', 'warehouse.id = ' . $this->_table_name . '.warehouse_id', 'left');
		$this->db->join('warehouse as transaction_warehouse', 'transaction_warehouse.id = ' . $this->_table_name . '.transaction_warehouse_id', 'left');
		$this->db->where($this->_table_name . '.purchase_voucher_id', $purchase_voucher_id);
		$query = $this->db->get();

		return $query->result_array();
	}

	function get($purchase_voucher_id = 0) {
		$this->db->select($this->_table_name . '.*' . ', products.name as product_name, products.id as product_id, products.unit as product_unit');
		$this->db->from($this->_table_name);
		$this->db->join('products', 'products.id = ' . $this->_table_name . '.product_id', 'left');
		$this->db->where($this->_table_name . '.purchase_voucher_id', $purchase_voucher_id);
		$query = $this->db->get();

		return $query->result_array();
	}

	function add($data = array()) {
		if (empty($data)) {
			return 0;
		}
		$query = $this->db->insert($this->_table_name, $data);
		$insert_id = $this->db->insert_id();
		return isset($query) ? $insert_id : 0;
	}

	function update($purchase_voucher_id, $args) {
		if (empty($args)) {
			return false;
		}
		$this->db->where('purchase_voucher_id', $purchase_voucher_id);
		$query = $this->db->update($this->_table_name, $args);

		return isset($query) ? true : false;
	}

	function delete($purchase_voucher_id) {
		$this->db->where('purchase_voucher_id', $purchase_voucher_id);
		$query = $this->db->delete($this->_table_name);

		return isset($query) ? true : false;
	}

	function truncate() {
        $query = $this->db->truncate($this->_table_name);

        return isset($query) ? true : false;
    }
}

/* End of file M_purchase_voucher_details.php */
/* Location: ./application/modules/purchase_voucher/models/M_shops_purchase_voucher_details.php */