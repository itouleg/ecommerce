<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Banks extends CI_Controller {

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

                $this->load->view('admin/banks/index', $data);
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
                if (isset($_POST['bank_name'])) {
                    $params = array(
                        'bank_name' => $this->input->post('bank_name'),
                        'bank_branch' => $this->input->post('bank_branch'),
                        'bank_holder' => $this->input->post('bank_holder'),
                        'bank_accountno' => $this->input->post('bank_accountno'),
                        'bank_status' => $this->input->post('bank_status')
                    );

                    $this->load->model("mbanks", "banks");
                    if ($this->banks->add($params)) {
                        redirect("admin/banks", "refresh");
                    }
                } else {
                    $this->load->view('admin/banks/create');
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
                $this->load->model("mbanks");

                if (isset($_POST['bank_name'])) {
                    $params = array(
                        'data' => array(
                            'bank_name' => $this->input->post('bank_name'),
                            'bank_branch' => $this->input->post('bank_branch'),
                            'bank_holder' => $this->input->post('bank_holder'),
                            'bank_accountno' => $this->input->post('bank_accountno'),
                            'bank_status' => $this->input->post('bank_status')
                        ),
                        'bank_id' => $this->input->post('bank_id')
                    );

                    if ($this->mbanks->update($params)) {

                        $data['bank'] = $this->mbanks->getData(array(
                            "where" => array("bank_id" => $id),
                            "limit" => 1
                        ));
                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );

                        $this->load->view('admin/banks/edit', $data);
                    }
                } else {

                    $data['type'] = $this->mbanks->getData(array(
                        "where" => array("bank_id" => $id),
                        "limit" => 1
                    ));
                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/banks/edit', $data);
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
                $this->load->model("mbanks");
                $this->mbanks->delete($id);
                redirect("admin/banks", "refresh");
            }
        }
    }

}

?>
