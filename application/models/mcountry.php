<?php

class Mcountry extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function count() {
        return $this->db->count_all('country');
    }

    function getData($params = NULL) {
        if (isset($params['limit']) && $params['limit'] != NULL) {
            $params['start'] = isset($params['start']) ? $params['start'] : 0;
            $params['limit'] = isset($params['limit']) ? $params['limit'] : 10;
        }

        $cols = "*";

        $this->db->select($cols);
        $this->db->from('country');

        if (isset($params['where'])) {
            $this->db->where($params['where']);
        }

        if (isset($params['groupby'])) {
            $this->db->group_by($params['groupby']);
        }

        if (isset($params['having'])) {
            $this->db->having($params['having']);
        }

        if (isset($params['orderby'])) {
            $params['orderby'] = implode(",", $params['orderby']);
            $this->db->order_by($params['orderby']);
        }
        if (isset($params['limit']) && $params['limit'] != NULL) {
            $this->db->limit($params['limit'], $params['start']);
        }
        $query = $this->db->get();

        if (isset($params['limit']) && $params['limit'] == 1) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    function changeStatus($id, $value) {
        $data = array(
            'country_status' => $value
        );

        $this->db->where('country_id', $id);
        return $this->db->update('country', $data);
    }

    function add($params) {
        $result = $this->db->insert('country', $params);
        return $result;
    }

    function delete($id) {
        return $this->db->delete('country', array('country_id' => $id));
    }

    function update($params) {
        $data = $params['data'];

        $this->db->where('country_id', $params['country_id']);
        $result = $this->db->update('country', $data);
        return $result;
    }

    function getMax() {
        $this->db->select_max('country_id');
        $query = $this->db->get('country');
        return $query->row_array();
    }

}

?>