<?php

class M_services extends CI_Model {

    public $_table_name = 'services';

    public function __construst() {
        parent::__construst();
    }

    private function generate_where($args) {
        if (isset($args['start_date_start'])) {
            $this->db->where($this->_table_name . ".start_date >", $args['start_date_start']);
        }

        if (isset($args['start_date_end'])) {
            $this->db->where($this->_table_name . ".start_date <", $args['start_date_end']);
        }

        if (isset($args['type'])) {
            $this->db->where($this->_table_name . ".type", $args['type']);
        }

        if (isset($args['deleted'])) {
            $this->db->where($this->_table_name . ".deleted", $args['deleted']);
        }

        if (isset($args['returned'])) {
            $this->db->where($this->_table_name . ".returned", $args['returned']);
        }

        if (isset($args['fixed'])) {
            $this->db->where($this->_table_name . ".fixed", $args['fixed']);
        }

        if (isset($args['code']) && isset($args['customer'])) {
            $this->db->group_start();
            $this->db->like($this->_table_name . ".code", $args['code']);
            $this->db->or_like("ctms.full_name", $args['customer']);
            $this->db->group_end();
        } elseif (isset($args['code'])) {
            $this->db->like($this->_table_name . ".code", $args['code']);
        } elseif (isset($args['customer'])) {
            $this->db->like("ctms.full_name", $args['customer']);
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
        $allow_sort = array("DESC", "ASC");

        if (isset($args['order_by']) && is_array($args['order_by']) && !empty($args['order_by'])) {
            foreach ($args['order_by'] as $key => $value) {
                $sort = in_array($value, $allow_sort) ? $value : "DESC";
                $this->db->order_by($key, $sort);
            }
        }
    }

    public function gets($args, $perpage = 5, $offset = -1) {
        $this->db->select($this->_table_name . '.*, ctms.full_name');
        $this->db->from($this->_table_name);
        $this->db->join('customers AS ctms', $this->_table_name . '.customer_id = ctms.id', 'left');
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

    public function counts($args) {
        $this->db->select($this->_table_name . '.*, ctms.full_name');
        $this->db->from($this->_table_name);
        $this->db->join('customers AS ctms', $this->_table_name . '.customer_id = ctms.id', 'left');
        $this->generate_where($args);
        $this->generate_order_by($args);
        $this->generate_group_by($args);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get($id) {
        $this->db->select($this->_table_name . '.*, ctms.full_name, ctms.phone, ctms.address');
        $this->db->from($this->_table_name);
        $this->db->join('customers AS ctms', $this->_table_name . '.customer_id = ctms.id', 'left');
        $this->db->where($this->_table_name . '.id', $id);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function add($args = array()) {
        if (empty($args)) {
            return 0;
        }
        $query = $this->db->insert($this->_table_name, $args);

        $insert_id = $this->db->insert_id();

        return (isset($query)) ? $insert_id : 0;
    }

    public function update($id, $args) {
        if (empty($args)) {
            return false;
        }
        $this->db->where('id', $id);
        $query = $this->db->update($this->_table_name, $args);

        return (isset($query)) ? true : false;
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete($this->_table_name);

        return (isset($query)) ? true : false;
    }

    function check_code_availablity($type = '', $code = '', $id = 0) {
        if (trim($type) == '' || trim($code) == '') {
            return FALSE;
        }

        $this->db->select();
		$this->db->where('type', $type);

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

}

/* End of file m_services.php */
/* Location: ./application/modules/services/models/m_services.php */