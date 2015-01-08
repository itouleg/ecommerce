<?php

class Mmenus extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function count() {
        return $this->db->count_all('menus');
    }

    function getData($params = NULL) {
        if (isset($params['limit']) && $params['limit'] != NULL) {
            $params['start'] = isset($params['start']) ? $params['start'] : 0;
            $params['limit'] = isset($params['limit']) ? $params['limit'] : 10;
        }

        $cols = "f.menu_id,f.menu_order,f.menu_title,f.menu_title_en,f.menu_link,f.menu_linktype,f.menu_type,f.menu_params,f.menu_parent,f.menu_status,IFNULL(s.menu_id,'') as parent_id,IFNULL(s.menu_title,'') as parent_title,IFNULL(s.menu_title_en,'') as parent_title_en";

        $this->db->select($cols,false);
        $this->db->from('menus as f');
        $this->db->join("menus as s","s.menu_id = f.menu_parent","left");

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
            'menu_status' => $value
        );

        $this->db->where('menu_id', $id);
        return $this->db->update('menus', $data);
    }

    function add($params) {
        $depResult = $this->db->insert('menus', $params);
        return $depResult;
    }

    function delete($id) {
        return $this->db->delete('menus', array('menu_id' => $id));
    }

    function update($params) {
        $data = $params['data'];

        $this->db->where('menu_id', $params['menu_id']);
        $depResult = $this->db->update('menus', $data);
        return $depResult;
    }

    function getMax() {
        $this->db->select_max('menu_id');
        $query = $this->db->get('menus');
        return $query->row_array();
    }

}

?>