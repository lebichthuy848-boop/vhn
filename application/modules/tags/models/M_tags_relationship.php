<?php

class M_tags_relationship extends CI_Model {

	public $_table_name = 'tags_relationship';
	public $_default_module = 'post';
	private $_allow_module = array('post', 'shop');

	function __construst() {
		parent::__construst();
	}

	private function generate_where($args) {
		if (isset($args['tag_id'])) {
			$this->db->where($this->_table_name . ".tag_id", $args['tag_id']);
		}

		if (isset($args['object_id'])) {
			$this->db->where($this->_table_name . ".object_id", $args['object_id']);
		}

		if (isset($args['module'])) {
			$this->db->where($this->_table_name . ".module", $args['module']);
		}
	}

	private function generate_order_by($args) {
		$allow_sort = array("DESC", "ASC");

		if (isset($args['order_by']) && is_array($args['order_by']) && !empty($args['order_by'])) {
			foreach ($args['order_by'] as $key => $value) {
				$sort = in_array($value, $allow_sort) ? $value : "DESC";
				$this->db->order_by($this->_table_name . '.' . $key, $sort);
			}
		}
	}

	public function gets($args) {
		$this->db->select('*');
		$this->db->from($this->_table_name);

		$this->generate_where($args);
		$this->generate_order_by($args);
		$query = $this->db->get();

		return $query->result_array();
	}

	private function _get_module($module = '') {
		$default_module = $this->_default_module;
		if ((trim($module) != '') && in_array($module, $this->_allow_module)) {
			$default_module = $module;
		}
		return $default_module;
	}

	function validate_exist_tag_id($tag_id) {
		$this->db->select();
		$this->db->where($this->_table_name . '.tag_id', $tag_id);
		$query = $this->db->get($this->_table_name);

		return $query->result_array();
	}

	function validate_exist($object_id, $tag_id, $module = '') {
		$this->db->select();
		$this->db->where($this->_table_name . '.object_id', $object_id);
		$this->db->where($this->_table_name . '.tag_id', $tag_id);
		$this->db->where($this->_table_name . '.module', $this->_get_module($module));
		$query = $this->db->get($this->_table_name);

		return $query->row_array();
	}

	function get_data($object_id, $tag_id, $module = '') {
		$this->db->select();
		$this->db->where($this->_table_name . '.object_id', $object_id);
		$this->db->where($this->_table_name . '.tag_id', $tag_id);
		$this->db->where($this->_table_name . '.module', $this->_get_module($module));
		$query = $this->db->get($this->_table_name);

		return $query->row_array();
	}

	public function update($object_id, $tag_id, $data, $module = '') {
		if (empty($data)) {
			return FALSE;
		}
		$this->db->where($this->_table_name . '.object_id', $object_id);
		$this->db->where($this->_table_name . '.tag_id', $tag_id);
		$this->db->where($this->_table_name . '.module', $this->_get_module($module));
		$query = $this->db->update($this->_table_name, $data);

		return (isset($query)) ? true : false;
	}

	function get_price($object_id, $tag_id, $module = '') {
		$this->db->select('*');
		$this->db->where($this->_table_name . '.object_id', $object_id);
		$this->db->where($this->_table_name . '.tag_id', $tag_id);
		$this->db->where($this->_table_name . '.module', $this->_get_module($module));
		$query = $this->db->get($this->_table_name);

		return $query->row_array();
	}

	function get_data_by_object_id($object_id, $module = '') {
		$this->db->select();
		$this->db->from($this->_table_name);
		$this->db->join('tags', 'tags.id = ' . $this->_table_name . '.tag_id', 'left');
		$this->db->where($this->_table_name . '.object_id', $object_id);
		$this->db->where($this->_table_name . '.module', $this->_get_module($module));
		$query = $this->db->get();

		return $query->result_array();
	}

	function add($data = array()) {
		if (empty($data)) {
			return 0;
		}
		$query = $this->db->insert($this->_table_name, $data);
		$insert_id = $this->db->insert_id();
		return (isset($query)) ? $insert_id : 0;
	}

	function admin_delete_by_object_id($object_id, $module = '') {
		$this->db->where('object_id', $object_id);
		$this->db->where($this->_table_name . '.module', $this->_get_module($module));
		$query = $this->db->delete($this->_table_name);

		return (isset($query)) ? true : false;
	}

}

/* End of file m_tags_relationship.php */
/* Location: ./application/modules/tags/models/m_tags_relationship.php */