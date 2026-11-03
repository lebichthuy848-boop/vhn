<?php

class M_services_details extends CI_Model {

    public $_table_name = 'services_details';

    function __construst() {
        parent::__construst();
    }

    function get_data_in_services_id($services_id = 0) {
        $this->db->select($this->_table_name . '.*' . ',consignment.code');
        $this->db->where($this->_table_name . '.services_id', $services_id);
        $this->db->join('consignment', 'consignment.id = ' . $this->_table_name . '.consignment_id', 'left');
        $query = $this->db->get($this->_table_name);

        return $query->result_array();
    }

    function get($services_id = 0) {
        $this->db->select($this->_table_name . '.quantity,' . $this->_table_name . '.returned' . ', consignment.name, consignment.code');
        $this->db->where($this->_table_name . '.services_id', $services_id);
        $this->db->join('consignment', 'consignment.id = ' . $this->_table_name . '.consignment_id', 'left');
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

    public function update($services_id, $args) {
        if (empty($args)) {
            return false;
        }
        $this->db->where('services_id', $services_id);
        $query = $this->db->update($this->_table_name, $args);

        return (isset($query)) ? true : false;
    }

    function delete($services_id) {
        $this->db->where('services_id', $services_id);
        $query = $this->db->delete($this->_table_name);

        return (isset($query)) ? true : false;
    }

}

/* End of file m_services_details.php */
/* Location: ./application/modules/shops/models/m_shops_services_details.php */