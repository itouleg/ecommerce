<?php

class Mcurrency extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function count() {
        return $this->db->count_all('currency');
    }

    function getData($params = NULL) {
        if (isset($params['limit']) && $params['limit'] != NULL) {
            $params['start'] = isset($params['start']) ? $params['start'] : 0;
            $params['limit'] = isset($params['limit']) ? $params['limit'] : 10;
        }

        $cols = "*";

        $this->db->select($cols);
        $this->db->from('currency');

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
            'currency_status' => $value
        );

        $this->db->where('currency_id', $id);
        return $this->db->update('currency', $data);
    }

    function add($params) {
        $result = $this->db->insert('currency', $params);
        return $result;
    }

    function delete($id) {
        return $this->db->delete('currency', array('currency_id' => $id));
    }

    function update($params) {
        $data = $params['data'];

        $this->db->where('currency_id', $params['currency_id']);
        $result = $this->db->update('currency', $data);
        return $result;
    }

    function getMax() {
        $this->db->select_max('currency_id');
        $query = $this->db->get('currency');
        return $query->row_array();
    }

}

?>