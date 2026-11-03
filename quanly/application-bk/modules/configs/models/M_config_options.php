<?php

class M_config_options extends CI_Model {

    protected $table;

    public function __construct() {
        parent::__construct();
        $this->table = 'config_options';
    }

    public function gets($autoload = '') {
        $allow = array('yes', 'no');
        if (trim($autoload) != '' && !in_array($autoload, $allow)) {
            $autoload = 'yes';
        }
        $this->db->select();
        $this->db->from($this->table);
        if (trim($autoload) != '') {
            $this->db->where('autoload', $autoload);
        }
        $query = $this->db->get();

        return $query->result_array();
    }

    function get($id) {
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row_array();
    }
    
    function get_by_config_name($config_name) {
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where('config_name', $config_name);
        $query = $this->db->get();

        return $query->row_array();
    }
    
    public function add($args = array()) {
        if (empty($args)) {
            return 0;
        }
        $query = $this->db->insert($this->table, $args);

        $insert_id = $this->db->insert_id();

        return (isset($query)) ? $insert_id : 0;
    }
    
    function update($config_name, $args = array()) {
        if (empty($args)) {
            return FALSE;
        }
        $this->db->where('config_name', $config_name);
        $query = $this->db->update($this->table, $args);

        return (isset($query)) ? true : false;
    }

    function delete($config_name) {
        $this->db->where('config_name', $config_name);
        $query = $this->db->delete($this->table);

        return (isset($query)) ? true : false;
    }

}
