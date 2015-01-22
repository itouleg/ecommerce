<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employee extends CI_Controller {

    public $user_permission;

    public function __construct() {
        parent::__construct();
        $this->load->library("MY_Output", '', 'nocache');
        $this->user_permission = $this->cuserdata->getPermission("employee");
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

                $this->load->view('admin/employee/index', $data);
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
                if (isset($_POST['user_email'])) {
                    $params = array(
                        'dep_id' => $this->input->post('dep_id'),
                        'user_email' => $this->input->post('user_email'),
                        'user_photo' => $this->input->post('user_photo'),
                        'user_fullname' => $this->input->post('user_fullname'),
                        'user_username' => $this->input->post('user_username'),
                        'user_password' => md5($this->input->post('user_password')),
                        'user_mobile' => $this->input->post('user_mobile'),
                        'user_status' => $this->input->post('user_status')
                    );

                    $this->load->model("musers", "users");
                    if ($this->users->add($params)) {
                        redirect("admin/employee", "refresh");
                    }
                } else {
                    $this->load->model("mdepartments");
                    $data['department'] = $this->mdepartments->getData(
                            array(
                                "where" => array("dep_status" => 1, "dep_id != " => 1)
                            )
                    );
                    $this->load->view('admin/employee/create', $data);
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
                $this->load->model("mdepartments");
                $this->load->model("musers");

                if (isset($_POST['user_id'])) {
                    $params = array(
                        'data' => array(
                            'dep_id' => $this->input->post('dep_id'),
                            'user_email' => $this->input->post('user_email'),
                            'user_photo' => $this->input->post('user_photo'),
                            'user_fullname' => $this->input->post('user_fullname'),
                            'user_username' => $this->input->post('user_username'),
                            'user_mobile' => $this->input->post('user_mobile'),
                            'user_status' => $this->input->post('user_status')
                        ),
                        'user_id' => $this->input->post('user_id')
                    );

                    if ($this->input->post('user_password') != "") {
                        $params['data']['user_password'] = md5($this->input->post('user_password'));
                    }

                    if ($this->musers->update($params)) {
                        $data['user'] = $this->musers->getData(array(
                            "where" => array("user_id" => $id),
                            "limit" => 1
                        ));

                        $data['department'] = $this->mdepartments->getData(array(
                            "where" => array("dep_status" => 1, "dep_id !=" => 1)
                        ));

                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );

                        $this->load->view('admin/employee/view', $data);
                    }
                } else {
                    $data['user'] = $this->musers->getData(array(
                        "where" => array("user_id" => $id),
                        "limit" => 1
                    ));

                    $data['department'] = $this->mdepartments->getData(array(
                        "where" => array("dep_status" => 1, "dep_id !=" => 1)
                    ));
                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/employee/edit', $data);
                }
            }
        }
    }
    
    public function profile() {
        if (!$this->session->userdata('logged')) {
            redirect("admin/login", "refresh");
        } else {
            if (!$this->user_permission['updatedata'] == 1) {
                $this->load->view('admin/accessdeny');
            } else {
                $this->load->model("mdepartments");
                $this->load->model("musers");
                $userid = $this->session->userdata('logged');
                
                if (isset($_POST['user_username'])) {
                    $params = array(
                        'data' => array(
                            'dep_id' => $this->input->post('dep_id'),
                            'user_email' => $this->input->post('user_email'),
                            'user_photo' => $this->input->post('user_photo'),
                            'user_fullname' => $this->input->post('user_fullname'),
                            'user_username' => $this->input->post('user_username'),
                            'user_mobile' => $this->input->post('user_mobile'),
                            'user_status' => $this->input->post('user_status')
                        ),
                        'user_id' => $userid
                    );

                    if ($this->input->post('user_password') != "") {
                        $params['data']['user_password'] = md5($this->input->post('user_password'));
                    }

                    if ($this->musers->update($params)) {
                        $data['user'] = $this->musers->getData(array(
                            "where" => array("user_id" => $userid),
                            "limit" => 1
                        ));

                        $data['department'] = $this->mdepartments->getData(array(
                            "where" => array("dep_status" => 1)
                        ));

                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );

                        $this->load->view('admin/employee/profile', $data);
                    }
                } else {
                    $data['user'] = $this->musers->getData(array(
                        "where" => array("user_id" => $userid),
                        "limit" => 1
                    ));

                    $data['department'] = $this->mdepartments->getData(array(
                        "where" => array("dep_status" => 1)
                    ));
                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/employee/profile', $data);
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
                $this->load->model("mdepartments");
                $this->load->model("musers");

                $data['user'] = $this->musers->getData(array(
                    "where" => array("user_id" => $id),
                    "limit" => 1
                ));

                $data['alert'] = array(
                    'type' => NULL,
                    'message' => NULL
                );
                $this->load->view('admin/employee/view', $data);
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
                $this->load->model("musers");
                $this->musers->delete($id);
                redirect("admin/employee", "refresh");
            }
        }
    }

}

?>
