<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Membertypes extends CI_Controller {

    public $user_permission;

    public function __construct() {
        parent::__construct();
        $this->load->library("MY_Output", '', 'nocache');
        $this->user_permission = $this->cuserdata->getPermission("membertypes");
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

                $this->load->view('admin/membertypes/index', $data);
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
                if (isset($_POST['type_name'])) {
                    $params = array(
                        'type_name' => $this->input->post('type_name'),
                        'type_status' => $this->input->post('type_status')
                    );

                    $this->load->model("mmembertypes", "type");
                    if ($this->type->add($params)) {
                        redirect("admin/membertypes", "refresh");
                    }
                } else {
                    $this->load->view('admin/membertypes/create');
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
                $this->load->model("mmembertypes");

                if (isset($_POST['type_id'])) {
                    $params = array(
                        'data' => array(
                            'type_name' => $this->input->post('type_name'),
                            'type_status' => $this->input->post('type_status')
                        ),
                        'type_id' => $this->input->post('type_id')
                    );

                    if ($this->mmembertypes->update($params)) {

                        $data['type'] = $this->mmembertypes->getData(array(
                            "where" => array("type_id" => $id),
                            "limit" => 1
                        ));
                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );

                        $this->load->view('admin/membertypes/edit', $data);
                    }
                } else {

                    $data['type'] = $this->mmembertypes->getData(array(
                        "where" => array("type_id" => $id),
                        "limit" => 1
                    ));
                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/membertypes/edit', $data);
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
                $this->load->model("mmembertypes");
                $this->mmembertypes->delete($id);
                redirect("admin/membertypes", "refresh");
            }
        }
    }

}

?>
