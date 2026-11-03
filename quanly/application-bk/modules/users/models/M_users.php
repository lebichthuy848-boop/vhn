<?php
class M_users extends CI_Model {

    public $_table_name = 'users';

    function __construst() {
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
        if (isset($args['not_in_id'])) {
            $this->db->where_not_in($this->_table_name . ".userid", $args['not_in_id']);
        }
        if (isset($args['in_id'])) {
            $this->db->where_in($this->_table_name . ".userid", $args['in_id']);
        }
        if (isset($args['user_id'])) {
            $this->db->where($this->_table_name . '.userid', $args['user_id']);
        }
        if (isset($args['username'])) {
            $this->db->where($this->_table_name . ".username", $args['username']);
        }
        if (isset($args['email'])) {
            $this->db->where($this->_table_name . ".email", $args['email']);
        }
        if (isset($args['activation_key'])) {
            $this->db->where($this->_table_name . ".activation_key", $args['activation_key']);
        }
        if (isset($args['active'])) {
            $this->db->where($this->_table_name . ".active", $args['active']);
        }
        if (isset($args['group_id'])) {
            $this->db->where('group_id', $args['group_id']);
        }
        if (isset($args['admin_group_id'])) {
            $this->db->where('group_id <=', $args['admin_group_id']);
        }
        if (isset($args['admin_userid'])) {
            $this->db->where($this->_table_name . '.userid !=', $args['admin_userid']);
        }
        if (isset($args['role'])) {
            $this->db->where($this->_table_name . ".role", $args['role']);
        }
        if (isset($args['in_role'])) {
            $this->db->where_in($this->_table_name . ".role", $args['in_role']);
        }
        if (isset($args['level'])) {
            $this->db->where($this->_table_name . ".level", $args['level']);
        }
        if (isset($args['refer_key'])) {
            $this->db->where($this->_table_name . '.refer_key', $args['refer_key']);
        }
        if (isset($args['referred_by'])) {
            $this->db->where($this->_table_name . '.referred_by', $args['referred_by']);
        }
        if (isset($args['referred_status'])) {
            $this->db->where($this->_table_name . '.referred_status', $args['referred_status']);
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
        $this->db->select($this->_table_name . '.*,' . 'group_id');
        $this->db->from($this->_table_name);
        $this->db->join('groups_users', 'groups_users.userid = ' . $this->_table_name . '.userid', 'left');

        $this->generate_where($args);
        $this->generate_order_by($args);
        if ($offset >= 0) {
            $this->db->limit($perpage, $offset);
        }
        $query = $this->db->get();

        return $query->result_array();
    }

    public function counts($args) {
        $this->db->select();
        $this->db->from($this->_table_name);
        $this->db->join('groups_users', 'groups_users.userid = ' . $this->_table_name . '.userid', 'left');

        $this->generate_where($args);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get($id) {
        $this->db->select();
        $this->db->from($this->_table_name);
        $this->db->where($this->_table_name . '.userid', $id);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function get_by($args) {
        $this->db->select($this->_table_name . '.*,' . 'group_id');
        $this->db->from($this->_table_name);
        $this->db->join('groups_users', 'groups_users.userid = ' . $this->_table_name . '.userid', 'left');

        $this->generate_where($args);
        $this->generate_order_by($args);
        $query = $this->db->get();

        return $query->row_array();
    }

    function get_in_groups_data($group_id = 0) {
        $records = $this->db->select($this->_table_name . '.*,' . 'group_id')
                ->where('group_id', $group_id)
                ->from($this->_table_name)
                ->join('groups_users', 'groups_users.userid = ' . $this->_table_name . '.userid', 'left')
                ->get()
                ->result_array();
        return $records;
    }

    function validate_current_password($username, $current_password) {
        $this->db->where('username', $username);
        $this->db->where('password', $current_password);

        $query = $this->db->get($this->_table_name);

        return ($query->num_rows() == 1 ? TRUE : FALSE);
    }

    function validate_login($username, $password) {
        $this->db->select($this->_table_name . '.*');
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $this->db->where('active', 1);
        $this->db->from($this->_table_name);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function get_by_username($username) {
        $this->db->where('username', $username);
        $query = $this->db->get($this->_table_name);
        return $query->row_array();
    }

    function get_by_email($email) {
        $this->db->where('email', $email);
        $query = $this->db->get($this->_table_name);
        return $query->row_array();
    }
    
    function get_by_activation_key($code) {
        $this->db->where('activation_key', $code);
        $query = $this->db->get($this->_table_name);
        return $query->row_array();
    }

    function add($data = array()) {
        if (empty($data)) {
            return 0;
        }
        $query = $this->db->insert($this->_table_name, $data);

        return (isset($query)) ? $this->db->insert_id() : 0;
    }

    function update($id, $data) {
        if (empty($data)) {
            return FALSE;
        }
        $this->db->where('userid', $id);
        $query = $this->db->update($this->_table_name, $data);

        return (isset($query)) ? true : false;
    }

    function delete($userid = 0) {
        $this->db->where('userid', $userid);
        $query = $this->db->delete($this->_table_name);

        return (isset($query)) ? true : false;
    }

    function check_current_password_availablity($username, $current_password) {
        if ((trim($current_password) == '') || (trim($username) == '')) {
            return false;
        }

        $this->db->select();
        $this->db->where('username', $username);
        $this->db->where('password', $current_password);
        $this->db->from($this->_table_name);

        $query = $this->db->get();

        if ($query->num_rows() != 1) {
            return false;
        } else {
            return true;
        }
    }

    function check_current_username_availablity($username, $userid = 0) {
        if (trim($username) == '') {
            return false;
        }

        $this->db->select();
        if ($userid != 0) {
            $this->db->where('userid', $userid);
            $this->db->or_where('username', $username);
        } else {
            $this->db->where('username', $username);
        }

        $this->db->from($this->_table_name);

        $query = $this->db->get();

        /*
         * SELECT * FROM `users` WHERE userid=1 OR email='lenhan10th@gmail.com'
         * 1 là đúng ngược lại là sai
         */

        if ($userid != 0) {
            if ($query->num_rows() == 1) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($query->num_rows() > 0) {
                return false;
            } else {
                return true;
            }
        }
    }

    function check_current_email_availablity($email, $userid = 0) {
        if (trim($email) == '') {
            return false;
        }

        $this->db->select();
        if ($userid != 0) {
            $this->db->where('userid', $userid);
            $this->db->or_where('email', $email);
        } else {
            $this->db->where('email', $email);
        }

        $this->db->from($this->_table_name);

        $query = $this->db->get();

        /*
         * SELECT * FROM `users` WHERE userid=1 OR email='lenhan10th@gmail.com'
         * 1 là đúng ngược lại là sai
         */

        if ($userid != 0) {
            if ($query->num_rows() == 1) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($query->num_rows() > 0) {
                return false;
            } else {
                return true;
            }
        }
    }

    function check_username_availablity($username) {
        if (trim($username) == '') {
            return false;
        }

        $this->db->select();
        $this->db->where('username', $username);
        $this->db->from($this->_table_name);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    function check_email_availablity($email, $username = '') {
        if (trim($email) == '') {
            return false;
        }

        $this->db->select();
        if (trim($username) != '') {
            $this->db->where('username', $username);
            $this->db->or_where('email', $email);
        } else {
            $this->db->where('email', $email);
        }

        $this->db->from($this->_table_name);

        $query = $this->db->get();

        if (trim($username) != '') {
            if ($query->num_rows() == 1) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($query->num_rows() > 0) {
                return false;
            } else {
                return true;
            }
        }
    }

}

/* End of file M_users.php */
/* Location: ./application/modules/users/models/M_users.php */