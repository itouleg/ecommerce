<?php

class Mmodels extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function count() {
        return $this->db->count_all('models');
    }

    function getData($params = NULL) {
        if (isset($params['limit']) && $params['limit'] != NULL) {
            $params['start'] = isset($params['start']) ? $params['start'] : 0;
            $params['limit'] = isset($params['limit']) ? $params['limit'] : 10;
        }

        $cols = "*";

        $this->db->select($cols);
        $this->db->from('models');
        $this->db->join("brands","brand_id = model_brand");

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
            'model_status' => $value
        );

        $this->db->where('model_id', $id);
        return $this->db->update('models', $data);
    }

    function add($params) {
        $result = $this->db->insert('models', $params);
        return $result;
    }

    function delete($id) {
        return $this->db->delete('models', array('model_id' => $id));
    }

    function update($params) {
        $data = $params['data'];

        $this->db->where('model_id', $params['model_id']);
        $result = $this->db->update('models', $data);
        return $result;
    }

    function getMax() {
        $this->db->select_max('model_id');
        $query = $this->db->get('models');
        return $query->row_array();
    }

}

?>