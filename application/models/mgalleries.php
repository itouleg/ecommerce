<?php

class Mgalleries extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function count() {
        return $this->db->count_all('galleries');
    }

    function getData($params = NULL) {
        if (isset($params['limit']) && $params['limit'] != NULL) {
            $params['start'] = isset($params['start']) ? $params['start'] : 0;
            $params['limit'] = isset($params['limit']) ? $params['limit'] : 10;
        }

        $cols = "*";

        $this->db->select($cols);
        $this->db->from('galleries');

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
    
    function getPhotoData($params = NULL) {
        if (isset($params['limit']) && $params['limit'] != NULL) {
            $params['start'] = isset($params['start']) ? $params['start'] : 0;
            $params['limit'] = isset($params['limit']) ? $params['limit'] : 10;
        }

        $cols = "*";

        $this->db->select($cols);
        $this->db->from('gallery_photo');

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
            'gall_status' => $value
        );

        $this->db->where('gall_id', $id);
        return $this->db->update('galleries', $data);
    }

    function add($params) {
        $result = $this->db->insert('galleries', $params);
        return $result;
    }
    
    function addPhoto($params) {
        $result = $this->db->insert('gallery_photo', $params);
        return $result; 
    }

    function delete($id) {
        return $this->db->delete('galleries', array('gall_id' => $id));
    }
    
    function deleteAllPhoto($gall_id) {
        return $this->db->delete('gallery_photo', array('photo_gallid' => $gall_id));
    }
    
    function deletePhoto($photo_id,$gall_id) {
        return $this->db->delete('gallery_photo', array('photo_gallid' => $gall_id,'photo_id'=>$photo_id));
    }

    function update($params) {
        $data = $params['data'];

        $this->db->where('gall_id', $params['gall_id']);
        $result = $this->db->update('galleries', $data);
        return $result;
    }

    function getMax() {
        $this->db->select_max('gall_id');
        $query = $this->db->get('galleries');
        return $query->row_array();
    }
    
    function getMaxPhoto($gallid) {
        $this->db->select_max('photo_id');
        $this->db->where('photo_gallid', $gallid);
        $query = $this->db->get('gallery_photo');
        return $query->row_array();
    }

}

?>