<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Models extends CI_Controller {

    public $user_permission;

    public function __construct() {
        parent::__construct();
        $this->load->library("MY_Output", '', 'nocache');
        $this->user_permission = $this->cuserdata->getPermission("models");
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

                $this->load->view('admin/models/index', $data);
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
                if (isset($_POST['model_name'])) {
                    $params = array(
                        'model_name' => $this->input->post('model_name'),
                        'model_brand' => $this->input->post('model_brand'),
                        'model_status' => $this->input->post('model_status')
                    );

                    $this->load->model("mmodels", "models");
                    if ($this->models->add($params)) {
                        redirect("admin/models", "refresh");
                    }
                } else {
                    $this->load->model("mbrands");
                    $data['brand'] = $this->mbrands->getData(array(
                            "where" => array("brand_status" => 1),
                            "limit" => NULL
                        ));
                    $this->load->view('admin/models/create',$data);
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
                $this->load->model("mmodels");

                if (isset($_POST['model_id'])) {
                    $params = array(
                        'data' => array(
                            'model_name' => $this->input->post('model_name'),
                            'model_brand' => $this->input->post('model_brand'),
                            'model_status' => $this->input->post('model_status')
                        ),
                        'model_id' => $this->input->post('model_id')
                    );

                    if ($this->mmodels->update($params)) {

                        $data['brand'] = $this->mbrands->getData(array(
                            "where" => array("brand_status" => 1),
                            "limit" => NULL
                        ));
                        $data['model'] = $this->mmodels->getData(array(
                            "where" => array("model_id" => $id),
                            "limit" => 1
                        ));
                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );

                        $this->load->view('admin/models/edit', $data);
                    }
                } else {

                    $data['brand'] = $this->mbrands->getData(array(
                        "where" => array("brand_status" => 1),
                        "limit" => NULL
                    ));
                    $data['model'] = $this->mmodels->getData(array(
                            "where" => array("model_id" => $id),
                            "limit" => 1
                        ));
                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/models/edit', $data);
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
                $this->load->model("mmodels");
                $this->mmodels->delete($id);
                redirect("admin/models", "refresh");
            }
        }
    }

}

?>
