<?php

class M_shops_order_details extends CI_Model {

    public $_table_name = 'shops_order_details';

    function __construst() {
        parent::__construst();
    }

    function get_total_quantity() {
        $this->db->select_sum('quantity');
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

    function get_total_quantity_in_product_id($product_id) {
        $this->db->select_sum('quantity');
        $this->db->where($this->_table_name . '.product_id', $product_id);
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

    function get_data_in_order_id($order_id = 0) {
        $this->db->select('*');
        $this->db->where($this->_table_name . '.order_id', $order_id);
        $query = $this->db->get($this->_table_name);

        return $query->result_array();
    }

    /**
     * @Function: get_best_seller()
     * @author LeVanNhan <lenhan10th@gmail.com>
     * @Parameters: $top number
     * @return array Description: get product best seller
     */
    function get_best_seller($top) {
        $this->db->select('product_id');
        $this->db->select_sum('quantity');
        $this->db->from($this->_table_name);
        $this->db->group_by('product_id');
        $this->db->order_by('quantity', 'DESC');
        $this->db->limit($top);
        $query = $this->db->get();
        
        //echo $this->db->last_query();

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

    function delete($order_id) {
        $this->db->where('order_id', $order_id);
        $query = $this->db->delete($this->_table_name);

        return (isset($query)) ? true : false;
    }
    
    function validate_product_id($product_id = 0) {
        $this->db->select();
        $this->db->from($this->_table_name);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

/* End of file m_shops_order_details.php */
/* Location: ./application/modules/shops/models/m_shops_order_details.php */