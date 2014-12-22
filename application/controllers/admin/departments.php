<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Departments extends CI_Controller {

    public $user_permission;

    public function __construct() {
        parent::__construct();
        $this->load->library("MY_Output", '', 'nocache');
        $this->user_permission = $this->cuserdata->getPermission("departments");
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

                $this->load->view('admin/departments/index', $data);
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
                if (isset($_POST['dep_name'])) {
                    $params = array(
                        'dep_name' => $this->input->post('dep_name'),
                        'dep_desc' => $this->input->post('dep_desc'),
                        'dep_status' => $this->input->post('dep_status')
                    );

                    $this->load->model("mdepartments", "dep");
                    if ($this->dep->add($params)) {
                        if (isset($_POST['con_id'])) {
                            $depart = $this->dep->getMax();
                            $depid = $depart['dep_id'];
                            $this->load->model("mpermissions", "per");
                            $controller = $_POST['con_id'];
                            foreach ($controller as $conid) {
                                $view = isset($_POST['view_' . $conid]) ? 1 : 0;
                                $create = isset($_POST['create_' . $conid]) ? 1 : 0;
                                $update = isset($_POST['edit_' . $conid]) ? 1 : 0;
                                $delete = isset($_POST['delete_' . $conid]) ? 1 : 0;

                                $this->per->add(array(
                                    "dep_id" => $depid,
                                    "con_id" => $conid,
                                    "viewdata" => $view,
                                    "createdata" => $create,
                                    "updatedata" => $update,
                                    "deletedata" => $delete
                                ));
                            }
                        }
                        redirect("admin/departments", "refresh");
                    }
                } else {
                    $this->load->model("controllers");
                    $data['controller'] = $this->controllers->getData(
                            array(
                                "where" => "con_status = 1 and (con_class IS NULL or con_class='')"
                            )
                    );
                    $this->load->view('admin/departments/create', $data);
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
                $this->load->model("mpermissions");
                $this->load->model("controllers");

                if (isset($_POST['dep_id'])) {
                    $params = array(
                        'data' => array(
                            'dep_name' => $this->input->post('dep_name'),
                            'dep_desc' => $this->input->post('dep_desc'),
                            'dep_status' => $this->input->post('dep_status')
                        ),
                        'dep_id' => $this->input->post('dep_id')
                    );

                    if ($this->mdepartments->update($params)) {
                        if (isset($_POST['con_id'])) {
                            $this->load->model("mpermissions", "per");
                            $this->per->delete($this->input->post('dep_id'));
                            $controller = $_POST['con_id'];
                            foreach ($controller as $conid) {
                                $view = isset($_POST['view_' . $conid]) ? 1 : 0;
                                $create = isset($_POST['create_' . $conid]) ? 1 : 0;
                                $update = isset($_POST['edit_' . $conid]) ? 1 : 0;
                                $delete = isset($_POST['delete_' . $conid]) ? 1 : 0;

                                $this->per->add(array(
                                    "dep_id" => $this->input->post('dep_id'),
                                    "con_id" => $conid,
                                    "viewdata" => $view,
                                    "createdata" => $create,
                                    "updatedata" => $update,
                                    "deletedata" => $delete
                                ));
                            }
                        }

                        $data['dep'] = $this->mdepartments->getData(array(
                            "where" => array("dep_id" => $id),
                            "limit" => 1
                        ));
                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );


                        $data['permission'] = $this->mpermissions->getData(
                                array(
                                    "where" => array("dep_id" => $id)
                                )
                        );


                        $data['controller'] = $this->controllers->getData(
                                array(
                                    "where" => "con_status = 1 and (con_class IS NULL or con_class='')"
                                )
                        );

                        $this->load->view('admin/departments/view', $data);
                    }
                } else {
                    $data['controller'] = $this->controllers->getData(
                            array(
                                "where" => "con_status = 1 and (con_class IS NULL or con_class='')"
                            )
                    );

                    $data['permission'] = $this->mpermissions->getData(
                            array(
                                "where" => array("dep_id" => $id)
                            )
                    );

                    $data['dep'] = $this->mdepartments->getData(array(
                        "where" => array("dep_id" => $id),
                        "limit" => 1
                    ));
                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/departments/edit', $data);
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
                $this->load->model("mpermissions");
                $this->load->model("controllers");

                $data['controller'] = $this->controllers->getData(
                        array(
                            "where" => "con_status = 1 and (con_class IS NULL or con_class='')"
                        )
                );

                $data['permission'] = $this->mpermissions->getData(
                        array(
                            "where" => array("dep_id" => $id)
                        )
                );

                $data['dep'] = $this->mdepartments->getData(array(
                    "where" => array("dep_id" => $id),
                    "limit" => 1
                ));
                $data['alert'] = array(
                    'type' => NULL,
                    'message' => NULL
                );
                $this->load->view('admin/departments/view', $data);
            }
        }
    }

    public function delete($dep_id) {
        if (!$this->session->userdata('logged')) {
            redirect("admin/login", "refresh");
        } else {
            if (!$this->user_permission['deletedata'] == 1) {
                $this->load->view('admin/accessdeny');
            } else {
                $this->load->model("mdepartments");
                $this->mdepartments->delete($dep_id);
                redirect("admin/departments", "refresh");
            }
        }
    }

}

?>
