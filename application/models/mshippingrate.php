<?php

class Mshippingrate extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function count() {
        return $this->db->count_all('shipping_rate');
    }

    function getData($params = NULL) {
        if (isset($params['limit']) && $params['limit'] != NULL) {
            $params['start'] = isset($params['start']) ? $params['start'] : 0;
            $params['limit'] = isset($params['limit']) ? $params['limit'] : 10;
        }

        $cols = "ship_id,ship_from,ship_to,ship_type,ship_by,ship_weightfrom,ship_weightto,ship_price,ship_price_yuan,ship_status,"
                . "f.country_id as ship_fromid,"
                . "f.country_name as ship_fromname,"
                . "t.country_id as ship_toid,"
                . "t.country_name as ship_toname,"
                . "mass_id,"
                . "mass_name,"
                . "massby_id,"
                . "massby_name";

        $this->db->select($cols);
        $this->db->from('shipping_rate');
        $this->db->join("country as f","f.country_id = shipping_rate.ship_from");
        $this->db->join("country as t","t.country_id = shipping_rate.ship_to");
        $this->db->join("masstype","masstype.mass_id = shipping_rate.ship_type");
        $this->db->join("massby","massby.massby_id = shipping_rate.ship_by");

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
            'ship_status' => $value
        );

        $this->db->where('ship_id', $id);
        return $this->db->update('shipping_rate', $data);
    }

    function add($params) {
        $depResult = $this->db->insert('shipping_rate', $params);
        return $depResult;
    }

    function delete($id) {
        return $this->db->delete('shipping_rate', array('ship_id' => $id));
    }

    function update($params) {
        $data = $params['data'];

        $this->db->where('ship_id', $params['ship_id']);
        $depResult = $this->db->update('shipping_rate', $data);
        return $depResult;
    }

    function getMax() {
        $this->db->select_max('ship_id');
        $query = $this->db->get('shipping_rate');
        return $query->row_array();
    }

}

?>