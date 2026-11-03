<?php
class M_output_voucher extends CI_Model {

    public $_table_name = 'output_voucher';

    public function __construst() {
        parent::__construst();
    }

    private function generate_where($args) {
        if (isset($args['q'])) {
            $this->db->group_start();
            $this->db->like($this->_table_name . ".code", $args['q']);
            $this->db->or_like("ctms.full_name", $args['q']);
            $this->db->group_end();
        }

        if (isset($args['created_by'])) {
            $this->db->where($this->_table_name . ".created_by", $args['created_by']);
        }

        if (isset($args['start_date_start']) && isset($args['start_date_end'])) {
            $this->db->group_start();
            $this->db->where($this->_table_name . ".date >=", $args['start_date_start']);
            $this->db->where($this->_table_name . ".date <=", $args['start_date_end']);
            $this->db->group_end();
        }elseif (isset($args['start_date_start'])) {
            $this->db->where($this->_table_name . ".date >=", $args['start_date_start']);
        }elseif (isset($args['start_date_end'])) {
            $this->db->where($this->_table_name . ".date <=", $args['start_date_end']);
        }

        if (isset($args['deleted'])) {
            $this->db->where($this->_table_name . ".deleted", $args['deleted']);
        }

        if (isset($args['is_indebted'])) {
            if($args['is_indebted'] == 1){
                $this->db->where($this->_table_name . ".remainder >", 0);
            }elseif($args['is_indebted'] == 0){
                $this->db->where($this->_table_name . ".remainder", 0);
            }
        }

		if (isset($args['customer_id'])) {
            $this->db->where($this->_table_name . ".customer_id", $args['customer_id']);
        }

        if (isset($args['status'])) {
            $this->db->where($this->_table_name . ".status", $args['status']);
        }

        if (isset($args['order_status'])) {
            $this->db->where($this->_table_name . ".order_status", $args['order_status']);
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
        $this->db->select($this->_table_name . '.*, ctms.full_name as customer_full_name, ctms.customer_code as customer_code, ctms.address as customer_address, ctms.phone as customer_phone, ctms.email as customer_email, employee.full_name as employee_full_name, employee.full_name as full_name');
        $this->db->from($this->_table_name);
        $this->db->join('customers AS ctms', $this->_table_name . '.customer_id = ctms.id', 'left');
        $this->db->join('users AS employee', $this->_table_name . '.created_by = employee.userid', 'left');

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
        $this->db->select('*');
        $this->db->from($this->_table_name);
        $this->db->join('customers AS ctms', $this->_table_name . '.customer_id = ctms.id', 'left');
        $this->generate_where($args);
        $this->generate_order_by($args);
        $this->generate_group_by($args);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get($id) {
        $this->db->select($this->_table_name . '.*, ctms.full_name as customer_full_name, ctms.address as customer_address, ctms.phone as customer_phone, ctms.email as customer_email, users.full_name as user_full_name, warehouse.store as warehouse_store, warehouse.address as warehouse_address, warehouse.phone as warehouse_phone, ctms_type.name as customer_type_name');
        $this->db->from($this->_table_name);
        $this->db->join('customers AS ctms', $this->_table_name . '.customer_id = ctms.id', 'left');
        $this->db->join('type_of_customer AS ctms_type', 'ctms.id_type_of_customer = ctms_type.id', 'left');
        $this->db->join('users', $this->_table_name . '.created_by = users.userid', 'left');
        $this->db->join('warehouse', $this->_table_name . '.warehouse_id = warehouse.id', 'left');
        $this->db->where($this->_table_name . '.id', $id);

        $query = $this->db->get();

        return $query->row_array();
    }

	public function get_by($args) {
        $this->db->select($this->_table_name . '.*, ctms.full_name as customer_full_name, ctms.address as customer_address, ctms.phone as customer_phone, ctms.email as customer_email, , ctms.customer_type as customer_type, ctms_type.name as customer_type_name');
        $this->db->from($this->_table_name);
        $this->db->join('customers AS ctms', $this->_table_name . '.customer_id = ctms.id', 'left');
        $this->db->join('type_of_customer AS ctms_type', 'ctms.id_type_of_customer = ctms_type.id', 'left');

        $this->generate_where($args);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function get_total($args) {
        $this->db->select_sum('amount');
        $this->db->from($this->_table_name);

        $this->generate_where($args);

        $query = $this->db->get();

        $row = $query->row_array();
        //echo $this->db->last_query(); die;
        return isset($row['amount']) ? $row['amount'] : 0;
    }

    public function get_monetized($args) {
        $this->db->select_sum('monetized');
        $this->db->from($this->_table_name);

        $this->generate_where($args);

        $query = $this->db->get();

        $row = $query->row_array();
        //echo $this->db->last_query(); die;
        return isset($row['monetized']) ? $row['monetized'] : 0;
    }

    function gets_group_year() {
        $sql = "SELECT
                   YEAR(FROM_UNIXTIME(`created`)) AS 'YEAR'
                FROM
                    `output_voucher`
                WHERE
                    `status` = 1
                GROUP BY YEAR(FROM_UNIXTIME(`created`))
                ORDER BY `created` DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function add($args = array()) {
        if (empty($args)) {
            return 0;
        }
        $query = $this->db->insert($this->_table_name, $args);

        $insert_id = $this->db->insert_id();

        return isset($query) ? $insert_id : 0;
    }

    public function update($id, $args) {
        if (empty($args)) {
            return false;
        }
        $this->db->where('id', $id);
        $query = $this->db->update($this->_table_name, $args);

        return isset($query) ? true : false;
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete($this->_table_name);

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

    function truncate() {
        $query = $this->db->truncate($this->_table_name);

        return isset($query) ? true : false;
    }
}

/* End of file M_output_voucher.php */
/* Location: ./application/modules/output_voucher/models/M_output_voucher.php */