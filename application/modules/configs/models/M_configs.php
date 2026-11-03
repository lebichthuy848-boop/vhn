<?php

class M_configs extends CI_Model {

    public $_table_name = 'configs';

    function __construst() {
        parent::__construst();
    }

    function get_configs() {
        $this->db->select('*');
        $query = $this->db->get($this->_table_name);

        return $query->result_array();
    }
    
    function get($config_name = '') {
        $this->db->select('*');
        $this->db->where('config_name', $config_name);
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

    function update($config_name, $data = array()) {
        if (empty($data)) {
            return FALSE;
        }
        $this->db->where('config_name', $config_name);
        $query = $this->db->update($this->_table_name, $data);

        return (isset($query)) ? true : false;
    }

    function delete($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete($this->_table_name);

        return (isset($query)) ? true : false;
    }

}

/* End of file m_configs.php */
/* Location: ./application/modules/configs/models/m_configs.php */