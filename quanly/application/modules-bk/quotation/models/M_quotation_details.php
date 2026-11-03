<?php

class M_quotation_details extends CI_Model {

    public $_table_name = 'quotation_details';

    function __construst() {
        parent::__construst();
    }

    private function generate_where($args) {
        if (isset($args['quotation_id'])) {
            $this->db->where($this->_table_name . ".quotation_id", $args['quotation_id']);
        }
        
        if (isset($args['product_id'])) {
            $this->db->where($this->_table_name . ".product_id", $args['product_id']);
        }

        if (isset($args['start_date_start'])) {
            $this->db->where("ovr.date >", $args['start_date_start']);
        }

        if (isset($args['start_date_end'])) {
            $this->db->where("ovr.date <", $args['start_date_end']);
        }

        if (isset($args['q'])) {
            $this->db->like("products.name", $args['q']);
        }

        if (isset($args['category_id'])) {
            $this->db->where("products.category_id", $args['category_id']);
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

    public function gets($args, $perpage = 5, $offset = -1) {
        $this->db->select($this->_table_name . '.*' . ', products.name, products.name as product_name, products.id as products_id, products.code as product_code, products.unit as product_unit, ovr.date, ovr.customer_type');
        $this->db->from($this->_table_name);
        $this->db->join('products', 'products.id = ' . $this->_table_name . '.product_id', 'left');
        $this->db->join('quotation as ovr', 'ovr.id = ' . $this->_table_name . '.quotation_id', 'left');

        $this->generate_where($args);
        $this->generate_order_by($args);
        if ($offset >= 0) {
            $this->db->limit($perpage, $offset);
        }
        $query = $this->db->get();

        return $query->result_array();
    }

    public function counts($args) {
        $this->db->select('*');
        $this->db->from($this->_table_name);
        $this->db->join('products', 'products.id = ' . $this->_table_name . '.product_id', 'left');
        $this->db->join('quotation as ovr', 'ovr.id = ' . $this->_table_name . '.quotation_id', 'left');

        $this->generate_where($args);

        $query = $this->db->get();

        return $query->num_rows();
    }

    function get_data_in_quotation_id($quotation_id = 0) {
        $this->db->select($this->_table_name . '.*' . ', products.name as product_name, products.id as product_id, products.unit as product_unit');
        $this->db->where($this->_table_name . '.quotation_id', $quotation_id);
        $this->db->join('products', 'products.id = ' . $this->_table_name . '.product_id', 'left');
        $query = $this->db->get($this->_table_name);

        return $query->result_array();
    }

    function get_detail($quotation_id = 0, $product_id = 0) {
        $this->db->select($this->_table_name . '.*' . ', products.name as product_name, products.id as product_id, products.unit as product_unit');
        $this->db->where($this->_table_name . '.quotation_id', $quotation_id);
        $this->db->where($this->_table_name . '.product_id', $product_id);
        $this->db->join('products', 'products.id = ' . $this->_table_name . '.product_id', 'left');
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

    function get($quotation_id = 0) {
        $this->db->select($this->_table_name . '.*' . ', products.name, products.name as product_name, products.id as products_id, products.code as product_code, products.unit as product_unit');
        $this->db->where($this->_table_name . '.quotation_id', $quotation_id);
        $this->db->join('products', 'products.id = ' . $this->_table_name . '.product_id', 'left');
        $query = $this->db->get($this->_table_name);

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

    public function update($quotation_id, $args) {
        if (empty($args)) {
            return false;
        }
        $this->db->where('quotation_id', $quotation_id);
        $query = $this->db->update($this->_table_name, $args);

        return (isset($query)) ? true : false;
    }

    function delete($quotation_id) {
        $this->db->where('quotation_id', $quotation_id);
        $query = $this->db->delete($this->_table_name);

        return (isset($query)) ? true : false;
    }

}

/* End of file m_quotation_details.php */
/* Location: ./application/modules/shops/models/m_shops_quotation_details.php */