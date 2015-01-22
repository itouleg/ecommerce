<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Shippingrates extends CI_Controller {

    public $user_permission;

    public function __construct() {
        parent::__construct();
        $this->load->library("MY_Output", '', 'nocache');
        $this->user_permission = $this->cuserdata->getPermission("banks");
    }

    public function index() {
        if (!$this->session->userdata('logged')) {
            redirect("admin/login", "refresh");
        } else {
            if (!$this->user_permission['viewdata'] == 1) {
                $this->load->view('admin/accessdeny');
            } else {
                $this->load->library('metrogridview', '', 'gridview');
                $data['gridview'] = $this->gridview;

                $this->load->view('admin/shippingrates/index', $data);
            }
        }
    }

    public function create() {
        if (!$this->session->userdata('logged')) {
            redirect("admin/login", "refresh");
        } else {
            if (!$this->user_permission['createdata'] == 1) {
                $this->load->view('admin/accessdeny');
            } else {
                if (isset($_POST['ship_price'])) {
                    $params = array(
                        'ship_price' => $this->input->post('ship_price'),
                        'ship_from' => $this->input->post('ship_from'),
                        'ship_to' => $this->input->post('ship_to'),
                        'ship_type' => $this->input->post('ship_type'),
                        'ship_by' => $this->input->post('ship_by'),
                        'ship_weightfrom' => $this->input->post('ship_weightfrom'),
                        'ship_weightto' => $this->input->post('ship_weightto'),
                        'ship_price' => $this->input->post('ship_price'),
                        'ship_price_yuan' => $this->input->post('ship_price_yuan'),
                        'ship_status' => $this->input->post('ship_status')
                    );

                    $this->load->model("mshippingrate");
                    if ($this->mshippingrate->add($params)) {
                        redirect("admin/shippingrates", "refresh");
                    }
                } else {
                    $this->load->model("mcountry");
                    $this->load->model("mmasstype");
                    $this->load->model("mmassby");
                    
                    $data['country'] = $this->mcountry->getData(array(
                        "where" => array("country_status" => 1),
                        "limit" => NULL
                    ));
                    
                    $data['masstype'] = $this->mmasstype->getData(array(
                        "where" => array("mass_status" => 1),
                        "limit" => NULL
                    ));
                    
                    $data['massby'] = $this->mmassby->getData(array(
                        "where" => array("massby_status" => 1),
                        "limit" => NULL
                    ));
                    
                    $this->load->view('admin/shippingrates/create',$data);
                }
            }
        }
    }

    public function edit($id) {
        if (!$this->session->userdata('logged')) {
            redirect("admin/login", "refresh");
        } else {
            if (!$this->user_permission['updatedata'] == 1) {
                $this->load->view('admin/accessdeny');
            } else {
                $this->load->model("mshippingrate");
                $this->load->model("mcountry");
                $this->load->model("mmasstype");
                $this->load->model("mmassby");

                if (isset($_POST['ship_id'])) {
                    $params = array(
                        'data' => array(
                            'ship_price' => $this->input->post('ship_price'),
                            'ship_from' => $this->input->post('ship_from'),
                            'ship_to' => $this->input->post('ship_to'),
                            'ship_type' => $this->input->post('ship_type'),
                            'ship_by' => $this->input->post('ship_by'),
                            'ship_weightfrom' => $this->input->post('ship_weightfrom'),
                            'ship_weightto' => $this->input->post('ship_weightto'),
                            'ship_price' => $this->input->post('ship_price'),
                            'ship_price_yuan' => $this->input->post('ship_price_yuan'),
                            'ship_status' => $this->input->post('ship_status')
                        ),
                        'ship_id' => $this->input->post('ship_id')
                    );

                    if ($this->mshippingrate->update($params)) {

                        $data['country'] = $this->mcountry->getData(array(
                            "where" => array("country_status" => 1),
                            "limit" => NULL
                        ));

                        $data['masstype'] = $this->mmasstype->getData(array(
                            "where" => array("mass_status" => 1),
                            "limit" => NULL
                        ));

                        $data['massby'] = $this->mmassby->getData(array(
                            "where" => array("massby_status" => 1),
                            "limit" => NULL
                        ));

                        $data['shipping'] = $this->mshippingrate->getData(array(
                            "where" => array("ship_id" => $id),
                            "limit" => 1
                        ));
                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );

                        $this->load->view('admin/shippingrates/edit', $data);
                    }
                } else {
                    
                    $data['country'] = $this->mcountry->getData(array(
                        "where" => array("country_status" => 1),
                        "limit" => NULL
                    ));
                    
                    $data['masstype'] = $this->mmasstype->getData(array(
                        "where" => array("mass_status" => 1),
                        "limit" => NULL
                    ));
                    
                    $data['massby'] = $this->mmassby->getData(array(
                        "where" => array("massby_status" => 1),
                        "limit" => NULL
                    ));

                    $data['shipping'] = $this->mshippingrate->getData(array(
                        "where" => array("ship_id" => $id),
                        "limit" => 1
                    ));
                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/shippingrates/edit', $data);
                }
            }
        }
    }

    public function delete($id) {
        if (!$this->session->userdata('logged')) {
            redirect("admin/login", "refresh");
        } else {
            if (!$this->user_permission['deletedata'] == 1) {
                $this->load->view('admin/accessdeny');
            } else {
                $this->load->model("mshippingrate");
                $this->mshippingrate->delete($id);
                redirect("admin/shippingrates", "refresh");
            }
        }
    }

}

?>
