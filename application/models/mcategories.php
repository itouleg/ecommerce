<?php

class Mcategories extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function count() {
        return $this->db->count_all('categories');
    }

    function getData($params = NULL) {
        if (isset($params['limit']) && $params['limit'] != NULL) {
            $params['start'] = isset($params['start']) ? $params['start'] : 0;
            $params['limit'] = isset($params['limit']) ? $params['limit'] : 10;
        }

        $cols = "f.cat_id,f.cat_name,f.cat_name_en,f.cat_parent,f.cat_order,f.cat_status,IFNULL(s.cat_id,'') as parent_id,IFNULL(s.cat_name,'') as parent_name,,IFNULL(s.cat_name_en,'') as parent_name_en";

        $this->db->select($cols,false);
        $this->db->from('categories as f');
        $this->db->join("categories as s","s.cat_id = f.cat_parent","left");

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
        return $this->db->update('categories', $data);
    }

    function add($params) {
        $depResult = $this->db->insert('categories', $params);
        return $depResult;
    }

    function delete($id) {
        return $this->db->delete('categories', array('cat_id' => $id));
    }

    function update($params) {
        $data = $params['data'];

        $this->db->where('cat_id', $params['cat_id']);
        $depResult = $this->db->update('categories', $data);
        return $depResult;
    }

    function getMax() {
        $this->db->select_max('cat_id');
        $query = $this->db->get('categories');
        return $query->row_array();
    }

}

?>