<?php

class Musers extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function count() {
        return $this->db->count_all('users');
    }

    function getData($params = NULL) {
        if (isset($params['limit']) && $params['limit'] != NULL) {
            $params['start'] = isset($params['start']) ? $params['start'] : 0;
            $params['limit'] = isset($params['limit']) ? $params['limit'] : 10;
        }

        $cols = "*";

        $this->db->select($cols);
        $this->db->from('users');
        $this->db->join("departments","departments.dep_id = users.dep_id");

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
            'user_status' => $value
        );

        $this->db->where('user_id', $id);
        return $this->db->update('users', $data);
    }

    function add($params) {
        $depResult = $this->db->insert('users', $params);
        return $depResult;
    }

    function delete($id) {
        return $this->db->delete('users', array('user_id' => $id));
    }

    function update($params) {
        $data = $params['data'];

        $this->db->where('user_id', $params['user_id']);
        $depResult = $this->db->update('users', $data);
        return $depResult;
    }

    function getMax() {
        $this->db->select_max('user_id');
        $query = $this->db->get('users');
        return $query->row_array();
    }

}

?>