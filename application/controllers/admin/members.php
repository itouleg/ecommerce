<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Members extends CI_Controller {

    public $user_permission;

    public function __construct() {
        parent::__construct();
        $this->load->library("MY_Output", '', 'nocache');
        $this->user_permission = $this->cuserdata->getPermission("members");
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

                $this->load->view('admin/members/index', $data);
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
                if (isset($_POST['mem_email'])) {
                    $params = array(
                        'type_id' => $this->input->post('type_id'),
                        'mem_email' => $this->input->post('mem_email'),
                        'mem_fullname' => $this->input->post('mem_fullname'),
                        'mem_nickname' => $this->input->post('mem_nickname'),
                        'mem_username' => $this->input->post('mem_username'),
                        'mem_password' => md5($this->input->post('mem_password')),
                        'mem_mobile' => $this->input->post('mem_mobile'),
                        'mem_address' => $this->input->post('mem_address'),
                        'mem_province' => $this->input->post('mem_province'),
                        'mem_district' => $this->input->post('mem_district'),
                        'mem_subdistrict' => $this->input->post('mem_subdistrict'),
                        'mem_zip' => $this->input->post('mem_zip'),
                        'mem_photo' => $this->input->post('mem_photo'),
                        'mem_status' => $this->input->post('mem_status')
                    );

                    $this->load->model("mmembers", "members");
                    if ($this->members->add($params)) {
                        redirect("admin/members", "refresh");
                    }
                } else {
                    $this->load->model("mmembertypes");
                    $data['type'] = $this->mmembertypes->getData(
                            array(
                                "where" => array("type_status" => 1)
                            )
                    );
                    $this->load->view('admin/members/create', $data);
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
                $this->load->model("mmembers");

                if (isset($_POST['mem_id'])) {
                    $params = array(
                        'data' => array(
                            'type_id' => $this->input->post('type_id'),
                            'mem_email' => $this->input->post('mem_email'),
                            'mem_fullname' => $this->input->post('mem_fullname'),
                            'mem_nickname' => $this->input->post('mem_nickname'),
                            'mem_username' => $this->input->post('mem_username'),
                            'mem_mobile' => $this->input->post('mem_mobile'),
                            'mem_address' => $this->input->post('mem_address'),
                            'mem_province' => $this->input->post('mem_province'),
                            'mem_district' => $this->input->post('mem_district'),
                            'mem_subdistrict' => $this->input->post('mem_subdistrict'),
                            'mem_zip' => $this->input->post('mem_zip'),
                            'mem_photo' => $this->input->post('mem_photo'),
                            'mem_status' => $this->input->post('mem_status')
                        ),
                        'mem_id' => $this->input->post('mem_id')
                    );

                    if ($this->input->post('mem_password') != "") {
                        $params['data']['mem_password'] = md5($this->input->post('mem_password'));
                    }

                    if ($this->mmembers->update($params)) {
                        $data['member'] = $this->mmembers->getData(array(
                            "where" => array("mem_id" => $id),
                            "limit" => 1
                        ));

                        $data['type'] = $this->mmembertypes->getData(array(
                            "where" => array("type_status" => 1)
                        ));

                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );

                        $this->load->view('admin/members/view', $data);
                    }
                } else {
                    $data['member'] = $this->mmembers->getData(array(
                        "where" => array("mem_id" => $id),
                        "limit" => 1
                    ));

                    $data['type'] = $this->mmembertypes->getData(array(
                        "where" => array("type_status" => 1)
                    ));
                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/members/edit', $data);
                }
            }
        }
    }

    public function view($id) {
        if (!$this->session->userdata('logged')) {
            redirect("admin/login", "refresh");
        } else {
            if (!$this->user_permission['viewdata'] == 1) {
                $this->load->view('admin/accessdeny');
            } else {
                $this->load->model("mmembers");

                $data['member'] = $this->mmembers->getData(array(
                    "where" => array("mem_id" => $id),
                    "limit" => 1
                ));

                $data['alert'] = array(
                    'type' => NULL,
                    'message' => NULL
                );
                $this->load->view('admin/members/view', $data);
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
                $this->load->model("mmembers");
                $this->mmembers->delete($id);
                redirect("admin/members", "refresh");
            }
        }
    }

}

?>
