<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Currency extends CI_Controller {

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

                $this->load->view('admin/currency/index', $data);
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
                if (isset($_POST['currency_code'])) {
                    $params = array(
                        'currency_code' => $this->input->post('currency_code'),
                        'currency_name' => $this->input->post('currency_name'),
                        'currency_symbol' => $this->input->post('currency_symbol'),
                        'currency_buy' => $this->input->post('currency_buy'),
                        'currency_sell' => $this->input->post('currency_sell'),
                        'currency_status' => $this->input->post('currency_status')
                    );

                    $this->load->model("mcurrency");
                    if ($this->mcurrency->add($params)) {
                        redirect("admin/currency", "refresh");
                    }
                } else {
                    $this->load->view('admin/currency/create');
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
                $this->load->model("mcurrency");

                if (isset($_POST['currency_code'])) {
                    $params = array(
                        'data' => array(
                            'currency_code' => $this->input->post('currency_code'),
                            'currency_name' => $this->input->post('currency_name'),
                            'currency_symbol' => $this->input->post('currency_symbol'),
                            'currency_buy' => $this->input->post('currency_buy'),
                            'currency_sell' => $this->input->post('currency_sell'),
                            'currency_status' => $this->input->post('currency_status')
                        ),
                        'currency_id' => $this->input->post('currency_id')
                    );

                    if ($this->mcurrency->update($params)) {

                        $data['currency'] = $this->mcurrency->getData(array(
                            "where" => array("currency_id" => $id),
                            "limit" => 1
                        ));
                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );

                        $this->load->view('admin/currency/edit', $data);
                    }
                } else {

                    $data['currency'] = $this->mcurrency->getData(array(
                        "where" => array("currency_id" => $id),
                        "limit" => 1
                    ));
                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/currency/edit', $data);
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
                $this->load->model("mcurrency");
                $this->mcurrency->delete($id);
                redirect("admin/currency", "refresh");
            }
        }
    }

}

?>
