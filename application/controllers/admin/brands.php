<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Brands extends CI_Controller {

    public $user_permission;

    public function __construct() {
        parent::__construct();
        $this->load->library("MY_Output", '', 'nocache');
        $this->user_permission = $this->cuserdata->getPermission("brands");
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

                $this->load->view('admin/brands/index', $data);
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
                if (isset($_POST['brand_name'])) {
                    $params = array(
                        'brand_name' => $this->input->post('brand_name'),
                        'brand_status' => $this->input->post('brand_status')
                    );

                    $this->load->model("mbrands", "brands");
                    if ($this->brands->add($params)) {
                        redirect("admin/brands", "refresh");
                    }
                } else {
                    $this->load->view('admin/brands/create');
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
                $this->load->model("mbrands");

                if (isset($_POST['brand_id'])) {
                    $params = array(
                        'data' => array(
                            'brand_name' => $this->input->post('brand_name'),
                            'brand_status' => $this->input->post('brand_status')
                        ),
                        'brand_id' => $this->input->post('brand_id')
                    );

                    if ($this->mbrands->update($params)) {

                        $data['brand'] = $this->mbrands->getData(array(
                            "where" => array("brand_id" => $id),
                            "limit" => 1
                        ));
                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );

                        $this->load->view('admin/brands/edit', $data);
                    }
                } else {

                    $data['brand'] = $this->mbrands->getData(array(
                        "where" => array("brand_id" => $id),
                        "limit" => 1
                    ));
                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/brands/edit', $data);
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
                $this->load->model("mbrands");
                $this->mbrands->delete($id);
                redirect("admin/brands", "refresh");
            }
        }
    }

}

?>
