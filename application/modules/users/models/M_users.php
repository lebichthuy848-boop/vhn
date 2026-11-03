<?php

class M_users extends CI_Model {

    public $_table_name = 'users';
    public $_primary_key = 'userid';

    function __construst() {
        parent::__construst();
    }

    private function generate_where($args) {
        if (isset($args['full_name'])) {
            $this->db->or_like($this->_table_name . ".full_name", $args['full_name']);
        }
        if (isset($args['phone'])) {
            $this->db->or_like($this->_table_name . ".phone", $args['phone']);
        }
        if (isset($args['email'])) {
            $this->db->or_like($this->_table_name . ".email", $args['email']);
        }
        if (isset($args['active'])) {
            $this->db->where($this->_table_name . ".active", $args['active']);
        }
        if (isset($args['group_id'])) {
            $this->db->where('groups_users.group_id', $args['group_id']);
        }
        if (isset($args['admin_group_id'])) {
            $this->db->where('groups_users.group_id <=', $args['admin_group_id']);
        }
        if (isset($args['admin_userid'])) {
            $this->db->where($this->_table_name . '.userid !=', $args['admin_userid']);
        }
		
		if (isset($args['in_group_id'])) {
            $this->db->where_in('groups_users.group_id', $args['in_group_id']);
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
        $this->db->select($this->_table_name . '.*,' . 'groups_users.group_id, groups_users.group_id as role, groups.title as role_name');
        $this->db->from($this->_table_name);
        $this->db->join('groups_users', 'groups_users.userid = ' . $this->_table_name . '.userid', 'left');
        $this->db->join('groups', 'groups_users.group_id = ' . 'groups.group_id', 'left');

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
        $this->db->join('groups', 'groups_users.group_id = ' . 'groups.group_id', 'left');

        $this->generate_where($args);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get($id) {
        $this->db->select($this->_table_name . '.*,' . 'groups_users.group_id, groups_users.group_id as role, groups.title as role_name');
		$this->db->from($this->_table_name);
        $this->db->join('groups_users', 'groups_users.userid = ' . $this->_table_name . '.userid', 'left');
        $this->db->join('groups', 'groups_users.group_id = ' . 'groups.group_id', 'left');
        $this->db->where($this->_table_name . '.userid', $id);

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

    public function checkUser($data = array()) {
        if (!is_array($data) || empty($data)) {
            return NULL;
        }
        $this->db->select($this->_table_name . '.*,' . 'group_id');
        $this->db->from($this->_table_name);
        $this->db->join('groups_users', 'groups_users.userid = ' . $this->_table_name . '.userid', 'left');
        $this->db->where('oauth_provider', $data['oauth_provider']);
        $this->db->where('oauth_uid', $data['oauth_uid']);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return NULL;
        }
    }

    function validate_current_password($username, $current_password) {
        $this->db->where('username', $username);
        $this->db->where('password', $current_password);

        $query = $this->db->get($this->_table_name);

        return ($query->num_rows() == 1 ? TRUE : FALSE);
    }

    function validate_login($username, $password, $is_admin = FALSE) {
        $this->db->select($this->_table_name . '.*,' . 'group_id');
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $this->db->where('active', 1);
        if ($is_admin) {
            $this->db->where('group_id >', 3);
        }
        $this->db->from($this->_table_name);
        $this->db->join('groups_users', 'groups_users.userid = ' . $this->_table_name . '.userid', 'left');

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

    function get_by_activation_key($username, $code) {
		$this->db->where('username', $username);
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

        /*
         * SELECT * FROM `users` WHERE username='dvhung' OR email='lenhan10th@gmail.com'
         * 1 là đúng ngược lại là sai
         */

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

    function get_pagination_admin($filter = null, $groups_id = 0, $userid = 0, $perpage, $offset) {
        $this->db->select($this->_table_name . '.*,' . 'group_id');
        $this->db->from($this->_table_name);
        $this->db->join('groups_users', 'groups_users.userid = ' . $this->_table_name . '.userid', 'left');
        $this->db->where('groups_users.group_id <=', $groups_id);
        $this->db->where($this->_table_name . '.userid !=', $userid);

        //option filter
        if (isset($filter['usactive'])) {
            $this->db->where('active', $filter['usactive']);
        }

        if (isset($filter['method'])) {
            if (trim($filter['method']) != '') {
                if (isset($filter['q']) && trim($filter['q']) != '') {
                    $this->db->like($this->_table_name . '.' . $filter['method'], $filter['q']);
                }
            } else {
                if (isset($filter['q']) && trim($filter['q']) != '') {
                    $this->db->like($this->_table_name . '.userid', $filter['q']);
                    $this->db->or_like($this->_table_name . '.username', $filter['q']);
                    $this->db->or_like($this->_table_name . '.email', $filter['q']);
                    $this->db->or_like($this->_table_name . '.full_name', $filter['q']);
                }
            }
        } else {
            if (isset($filter['q']) && trim($filter['q']) != '') {
                $this->db->like($this->_table_name . '.userid', $filter['q']);
                $this->db->or_like($this->_table_name . '.username', $filter['q']);
                $this->db->or_like($this->_table_name . '.email', $filter['q']);
                $this->db->or_like($this->_table_name . '.full_name', $filter['q']);
            }
        }

        $this->db->limit($perpage, $offset);
        $records = $this->db->get();

        return $records->result_array();
    }

    function get_total_admin($filter = null, $groups_id = 0, $userid = 0) {
        $this->db->select();
        $this->db->from($this->_table_name);
        $this->db->join('groups_users', 'groups_users.userid = ' . $this->_table_name . '.userid', 'left');
        $this->db->where('groups_users.group_id <=', $groups_id);
        $this->db->where($this->_table_name . '.userid !=', $userid);

        //option filter
        if (isset($filter['usactive'])) {
            $this->db->where('active', $filter['usactive']);
        }

        if (isset($filter['method'])) {
            if (trim($filter['method']) != '') {
                if (isset($filter['q']) && trim($filter['q']) != '') {
                    $this->db->like($this->_table_name . '.' . $filter['method'], $filter['q']);
                }
            } else {
                if (isset($filter['q']) && trim($filter['q']) != '') {
                    $this->db->like($this->_table_name . '.userid', $filter['q']);
                    $this->db->or_like($this->_table_name . '.username', $filter['q']);
                    $this->db->or_like($this->_table_name . '.email', $filter['q']);
                    $this->db->or_like($this->_table_name . '.full_name', $filter['q']);
                }
            }
        } else {
            if (isset($filter['q']) && trim($filter['q']) != '') {
                $this->db->like($this->_table_name . '.userid', $filter['q']);
                $this->db->or_like($this->_table_name . '.username', $filter['q']);
                $this->db->or_like($this->_table_name . '.email', $filter['q']);
                $this->db->or_like($this->_table_name . '.full_name', $filter['q']);
            }
        }

        $records = $this->db->get();

        return $records->num_rows();
    }

}

/* End of file m_users.php */
    /* Location: ./application/modules/users/models/m_users.php */    