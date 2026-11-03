<?php
class M_employee extends CI_Model {

    public $_table_name = 'users';

    public function __construst() {
        parent::__construst();
    }

    private function generate_where($args) {
        if (isset($args['q'])) {
            $this->db->group_start();
            $this->db->like($this->_table_name . ".full_name", $args['q']);
            $this->db->or_like($this->_table_name . ".username", $args['q']);
            $this->db->or_like($this->_table_name . ".phone", $args['q']);
            $this->db->or_like($this->_table_name . ".email", $args['q']);
            $this->db->group_end();
        }

        if (isset($args['role'])) {
            $this->db->where($this->_table_name . ".role", $args['role']);
        }

        if (isset($args['in_id'])) {
            $this->db->where_in($this->_table_name . ".userid", $args['in_id']);
        }

//        if (isset($args['deleted'])) {
//            $this->db->where($this->_table_name . ".deleted", $args['deleted']);
//        }
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
        $this->db->select($this->_table_name . '.*, type_of_departments.name as type_of_departments, employees.staff_card, employees.address, employees.phone, employees.grade');
        $this->db->from($this->_table_name);
		$this->db->join('employees', 'employees.user_id = ' . $this->_table_name . '.userid', 'left');
		$this->db->join('type_of_departments', 'type_of_departments.id = ' . $this->_table_name . '.id_type_of_departments', 'left');

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
        $this->db->select($this->_table_name . '.*, type_of_departments.name as type_of_departments, employees.staff_card, employees.address, employees.phone, employees.grade');
        $this->db->from($this->_table_name);
		$this->db->join('employees', 'employees.user_id = ' . $this->_table_name . '.userid', 'left');
		$this->db->join('type_of_departments', 'type_of_departments.id = ' . $this->_table_name . '.id_type_of_departments', 'left');
        $this->db->where($this->_table_name . '.userid', $id);

        $query = $this->db->get();

        return $query->row_array();
    }
	
	public function get_by_employee($user_id) {
        $this->db->select();
        $this->db->from("employees");
        $this->db->where('user_id', $user_id);

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
	
	public function add_by_employee($args = array()) {
        if (empty($args)) {
            return 0;
        }
        $query = $this->db->insert("employees", $args);

        $insert_id = $this->db->insert_id();

        return (isset($query)) ? $insert_id : 0;
    }

    public function update($id, $args) {
        if (empty($args)) {
            return false;
        }
        $this->db->where('userid', $id);
        $query = $this->db->update($this->_table_name, $args);

        return (isset($query)) ? true : false;
    }
	
	public function update_by_employee($user_id, $args) {
        if (empty($args)) {
            return false;
        }
        $this->db->where('user_id', $user_id);
        $query = $this->db->update("employees", $args);

        return (isset($query)) ? true : false;
    }

    public function delete($id) {
        $this->db->where('userid', $id);
        $query = $this->db->delete($this->_table_name);

        return (isset($query)) ? true : false;
    }

}

/* End of file m_employee.php */
/* Location: ./application/modules/employee/models/m_employee.php */