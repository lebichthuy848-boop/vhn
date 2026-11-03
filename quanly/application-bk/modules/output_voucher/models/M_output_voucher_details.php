<?php
class M_output_voucher_details extends CI_Model {

    public $_table_name = 'output_voucher_details';

    function __construst() {
        parent::__construst();
    }

    private function generate_where($args) {
        if (isset($args['q'])) {
            $this->db->like("products.name", $args['q']);
        }

        if (isset($args['output_voucher_id'])) {
            $this->db->where($this->_table_name . ".output_voucher_id", $args['output_voucher_id']);
        }

		if (isset($args['in_output_voucher_id'])) {
            $this->db->where_in($this->_table_name . ".output_voucher_id", $args['in_output_voucher_id']);
        }

        if (isset($args['product_id'])) {
            $this->db->where($this->_table_name . ".product_id", $args['product_id']);
        }

        if (isset($args['in_product_id'])) {
            $this->db->where_in($this->_table_name . ".product_id", $args['in_product_id']);
        }

        if (isset($args['start_date_start']) && isset($args['start_date_end'])) {
            $this->db->group_start();
            $this->db->where("ovr.date >=", $args['start_date_start']);
            $this->db->where("ovr.date <=", $args['start_date_end']);
            $this->db->group_end();
        }elseif (isset($args['start_date_start'])) {
            $this->db->where("ovr.date >=", $args['start_date_start']);
        }elseif (isset($args['start_date_end'])) {
            $this->db->where("ovr.date <=", $args['start_date_end']);
        }

        if (isset($args['warehouse_id'])) {
            $this->db->where($this->_table_name . ".warehouse_id", $args['warehouse_id']);
        }

        if (isset($args['status'])) {
            $this->db->where("ovr.status", $args['status']);
        }

        if (isset($args['deleted'])) {
            $this->db->where("ovr.deleted", $args['deleted']);
        }

        if (isset($args['not_name'])) {
            $this->db->where("products.name !=", $args['not_name']);
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
                if(isset($args['order_by_custom'])){
                    $this->db->order_by($key, $sort);
                }else{
                    $this->db->order_by($this->_table_name . '.' . $key, $sort);
                }
            }
        }
    }

    function gets($args, $perpage = 5, $offset = -1) {
        $this->db->select($this->_table_name . '.*' . ', products.name, products.name as product_name_current_current, products.name as product_name, products.code as product_code, products.unit as product_unit, products.origin as product_origin, ovr.date, ovr.code, ovr.created, ovr.note, ovr.status, u.full_name as full_name, ctm.full_name as customer_full_name, ctm.customer_code as customer_code, ctm.email as customer_email, ctm.phone as customer_phone, ctm.address as customer_address, warehouse.name as warehouse_name');
        $this->db->from($this->_table_name);
        $this->db->join('products', 'products.id = ' . $this->_table_name . '.product_id', 'left');
        $this->db->join('warehouse', 'warehouse.id = ' . $this->_table_name . '.warehouse_id', 'left');
        $this->db->join('output_voucher as ovr', 'ovr.id = ' . $this->_table_name . '.output_voucher_id', 'left');
        $this->db->join('users as u', 'u.userid = ovr.created_by', 'left');
        $this->db->join('customers as ctm', 'ovr.customer_id = ctm.id', 'left');

        $this->generate_where($args);
        $this->generate_order_by($args);
        if ($offset >= 0) {
            $this->db->limit($perpage, $offset);
        }
        $query = $this->db->get();

        return $query->result_array();
    }

    function counts($args) {
        $this->db->select('*');
        $this->db->from($this->_table_name);
        $this->db->join('products', 'products.id = ' . $this->_table_name . '.product_id', 'left');
        $this->db->join('warehouse', 'warehouse.id = ' . $this->_table_name . '.warehouse_id', 'left');
        $this->db->join('output_voucher as ovr', 'ovr.id = ' . $this->_table_name . '.output_voucher_id', 'left');
        $this->db->join('customers as ctm', 'ovr.customer_id = ctm.id', 'left');

        $this->generate_where($args);

        $query = $this->db->get();

        return $query->num_rows();
    }

    function get_data_in_output_voucher_id($output_voucher_id = 0) {
        $this->db->select($this->_table_name . '.*' . ', products.name as product_name_current, products.unit as product_unit, products.image as image');
        $this->db->where($this->_table_name . '.output_voucher_id', $output_voucher_id);
        $this->db->join('products', 'products.id = ' . $this->_table_name . '.product_id', 'left');
        $query = $this->db->get($this->_table_name);

        return $query->result_array();
    }

    function get_detail($output_voucher_id = 0, $product_id = 0) {
        $this->db->select($this->_table_name . '.*' . ', products.name as product_name_current_current, products.unit as product_unit');
        $this->db->where($this->_table_name . '.output_voucher_id', $output_voucher_id);
        $this->db->where($this->_table_name . '.product_id', $product_id);
        $this->db->join('products', 'products.id = ' . $this->_table_name . '.product_id', 'left');
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

    function get($output_voucher_id = 0) {
        $this->db->select($this->_table_name . '.*' . ', products.name, products.name as product_name_current, products.code as product_code, products.unit as product_unit, products.origin as product_origin, warehouse.name as warehouse_name');
        $this->db->where($this->_table_name . '.output_voucher_id', $output_voucher_id);
        $this->db->join('products', 'products.id = ' . $this->_table_name . '.product_id', 'left');
        $this->db->join('warehouse', 'warehouse.id = ' . $this->_table_name . '.warehouse_id', 'left');
        $query = $this->db->get($this->_table_name);
        return $query->result_array();
    }

    function get_by($args) {
        $this->db->select($this->_table_name . '.*' . ', products.name, products.name as product_name_current, products.code as product_code, products.unit as product_unit, ovr.date, ctm.full_name as full_name, warehouse.name as warehouse_name');
        $this->db->from($this->_table_name);
        $this->db->join('products', 'products.id = ' . $this->_table_name . '.product_id', 'left');
        $this->db->join('warehouse', 'warehouse.id = ' . $this->_table_name . '.warehouse_id', 'left');
        $this->db->join('output_voucher as ovr', 'ovr.id = ' . $this->_table_name . '.output_voucher_id', 'left');
        $this->db->join('customers as ctm', 'ovr.customer_id = ctm.id', 'left');

        $this->generate_where($args);
        $this->generate_order_by($args);
        $query = $this->db->get();

        return $query->row_array();
    }

    function get_total($args) {
        $this->db->select('SUM(' . $this->_table_name . '.profit) AS total_profit, SUM(' . $this->_table_name . '.profit) AS total_profit, SUM(' . $this->_table_name . '.profit) AS total_profit', FALSE);
        $this->db->from($this->_table_name);
        $this->db->join('products', 'products.id = ' . $this->_table_name . '.product_id', 'left');
        $this->db->join('warehouse', 'warehouse.id = ' . $this->_table_name . '.warehouse_id', 'left');
        $this->db->join('output_voucher as ovr', 'ovr.id = ' . $this->_table_name . '.output_voucher_id', 'left');
        $this->db->join('customers as ctm', 'ovr.customer_id = ctm.id', 'left');

        $this->generate_where($args);
        $this->generate_order_by($args);
        $query = $this->db->get();

        return $query->row_array();
    }

    function get_products_bestseller($args, $perpage = 5, $offset = -1) {
        $this->db->select('products.id, products.name, SUM(' . $this->_table_name . '.quantity) AS total_quantity', FALSE);
        $this->db->from($this->_table_name);
        $this->db->join('products', 'products.id = ' . $this->_table_name . '.product_id', 'left');
        $this->db->join('output_voucher as ovr', 'ovr.id = ' . $this->_table_name . '.output_voucher_id', 'left');

        $this->generate_where($args);
        $this->db->group_by($this->_table_name . '.product_id');
        $this->db->order_by('total_quantity', 'DESC');
        if ($offset >= 0) {
            $this->db->limit($perpage, $offset);
        }
        $query = $this->db->get();
        //echo $this->db->last_query(); die;

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

    function update($output_voucher_id, $args) {
        if (empty($args)) {
            return false;
        }
        $this->db->where('output_voucher_id', $output_voucher_id);
        $query = $this->db->update($this->_table_name, $args);

        return isset($query) ? true : false;
    }

    function delete($output_voucher_id) {
        $this->db->where('output_voucher_id', $output_voucher_id);
        $query = $this->db->delete($this->_table_name);

        return isset($query) ? true : false;
    }

    function truncate() {
        $query = $this->db->truncate($this->_table_name);

        return isset($query) ? true : false;
    }
}
/* End of file M_output_voucher_details.php */
/* Location: ./application/modules/output_voucher/models/M_output_voucher_details.php */