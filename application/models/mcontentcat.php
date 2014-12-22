<?php

class Mcontentcat extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function count() {
        return $this->db->count_all('content_categories');
    }

    function getData($params = NULL) {
        if (isset($params['limit']) && $params['limit'] != NULL) {
            $params['start'] = isset($params['start']) ? $params['start'] : 0;
            $params['limit'] = isset($params['limit']) ? $params['limit'] : 10;
        }

        $cols = "f.cat_id,f.cat_name,f.cat_desc,f.cat_lang,f.cat_parent,f.cat_status,s.cat_id,s.cat_name";

        $this->db->select($cols);
        $this->db->from('content_categories as f');
        $this->db->join("content_categories as s","s.cat_id = f.cat_parent","left");

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
            'cat_status' => $value
        );

        $this->db->where('cat_id', $id);
        return $this->db->update('content_categories', $data);
    }

    function add($params) {
        $depResult = $this->db->insert('content_categories', $params);
        return $depResult;
    }

    function delete($id) {
        return $this->db->delete('content_categories', array('cat_id' => $id));
    }

    function update($params) {
        $data = $params['data'];

        $this->db->where('cat_id', $params['cat_id']);
        $depResult = $this->db->update('content_categories', $data);
        return $depResult;
    }

    function getMax() {
        $this->db->select_max('cat_id');
        $query = $this->db->get('content_categories');
        return $query->row_array();
    }

}

?>