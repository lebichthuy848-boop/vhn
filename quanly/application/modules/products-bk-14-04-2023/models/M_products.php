<?php
class M_products extends CI_Model {

    public $_table_name = 'products';

    function __construst() {
        parent::__construst();
    }

    private function generate_where($args) {
        if (isset($args['q'])) {
            $this->db->group_start();
            $this->db->like($this->_table_name . ".name", $args['q']);
            $this->db->or_like($this->_table_name . ".code", $args['q']);
            $this->db->group_end();
        }

        if (isset($args['category_id'])) {
            $this->db->where($this->_table_name . ".category_id", $args['category_id']);
        }

        if (isset($args['in_id'])) {
            $this->db->where_in($this->_table_name . ".id", $args['in_id']);
        }

		/*
        if (isset($args['start_date_start'])) {
            $this->db->where("ovr.date >", $args['start_date_start']);
        }

        if (isset($args['start_date_end'])) {
            $this->db->where("ovr.date <", $args['start_date_end']);
        }
        */

        if (isset($args['deleted'])) {
            $this->db->where($this->_table_name . ".deleted", $args['deleted']);
        }

        if (isset($args['not_in_id'])) {
            $this->db->where_not_in($this->_table_name . ".id", $args['not_in_id']);
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

    public function gets($args, $perpage = 5, $offset = -1) {
        $this->db->select($this->_table_name . '.*, ctm_types.name as category_name, ctm_types.VAT as category_VAT');
        $this->db->from($this->_table_name);
        $this->db->join('category AS ctm_types', $this->_table_name . '.category_id = ctm_types.id', 'left');

        $this->generate_where($args);
        $this->generate_order_by($args);
        if ($offset >= 0) {
            $this->db->limit($perpage, $offset);
        }
        $query = $this->db->get();

        return $query->result_array();
    }

    public function counts($args) {
        $this->db->select($this->_table_name . '.*');
        $this->db->from($this->_table_name);

        $this->generate_where($args);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get($id) {
        $this->db->select($this->_table_name . '.*, ctm_types.name as category_name, ctm_types.VAT as category_VAT');
        $this->db->from($this->_table_name);
        $this->db->join('category AS ctm_types', $this->_table_name . '.category_id = ctm_types.id', 'left');
        $this->db->where($this->_table_name . '.id', $id);

        $query = $this->db->get();

        return $query->row_array();
    }

    function add($data = array()) {
        if (empty($data)) {
            return 0;
        }
        $query = $this->db->insert($this->_table_name, $data);

        return isset($query) ? $this->db->insert_id() : 0;
    }

    function update($id, $data) {
        if (empty($data)) {
            return FALSE;
        }
        $this->db->where('id', $id);
        $query = $this->db->update($this->_table_name, $data);

        return isset($query) ? true : false;
    }

    function delete($id = 0) {
        $this->db->where('id', $id);
        $query = $this->db->delete($this->_table_name);

        return isset($query) ? true : false;
    }

    function truncate() {
        $query = $this->db->truncate($this->_table_name);

        return isset($query) ? true : false;
    }

    function check_code_availablity($code = '', $id = 0) {
        if (trim($code) == '') {
            return FALSE;
        }

        $this->db->select();

        if ($id != 0) {
            $this->db->group_start();
            $this->db->where('id', $id);
            $this->db->or_where('code', $code);
            $this->db->group_end();
        } else {
            $this->db->where('code', $code);
        }

        $this->db->from($this->_table_name);
        $query = $this->db->get();
        if ($id != 0) {
            if ($query->num_rows() == 1) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($query->num_rows() > 0) {
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    function check_barcode_availablity($barcode = '', $id = 0) {
        if (trim($barcode) == '') {
            return FALSE;
        }

        $this->db->select();

        if ($id != 0) {
            $this->db->group_start();
            $this->db->where('id', $id);
            $this->db->or_where('barcode', $barcode);
            $this->db->group_end();
        } else {
            $this->db->where('barcode', $barcode);
        }

        $this->db->from($this->_table_name);
        $query = $this->db->get();
        if ($id != 0) {
            if ($query->num_rows() == 1) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($query->num_rows() > 0) {
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }
}
/* End of file M_products.php */
/* Location: ./application/modules/products/models/M_products.php */