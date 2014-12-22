<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Controller extends CI_Controller {
    public $user_permission;

    public function __construct() {
        parent::__construct();
        $this->load->library("MY_Output", '', 'nocache');
        $this->user_permission = $this->cuserdata->getPermission("controller");
    }

    public function index() {
        if (!$this->session->userdata('logged')) {
            redirect("admin/login", "refresh");
        } else {
            
            if(!$this->user_permission['viewdata']==1)
            {
                $this->load->view('admin/accessdeny');
            }else{
                $this->load->library('metrogridview', '', 'gridview');
                $data['gridview'] = $this->gridview;
                $this->load->view('admin/controller/index', $data);
            }
        }
    }

    public function create() {
        if (!$this->session->userdata('logged')) {
            redirect("admin/login", "refresh");
        } else {
            if(!$this->user_permission['createdata']==1)
            {
                $this->load->view('admin/accessdeny');
            }else{
                if (isset($_POST['con_title'])) {
                    $params = array(
                        'con_title' => $this->input->post('con_title'),
                        'con_active' => $this->input->post('con_active'),
                        'con_url' => $this->input->post('con_url'),
                        'con_icon' => $this->input->post('con_icon'),
                        'con_class' => $this->input->post('con_class'),
                        'notification_active' => $this->input->post('notification_active'),
                        'notification_text' => $this->input->post('notification_text'),
                        'con_active' => $this->input->post('con_active'),
                        'con_order' => $this->input->post('con_order'),
                        'con_status' => $this->input->post('con_status'),
                        'con_parent' => ($this->input->post('con_parent') == "" ? NULL : $this->input->post('con_parent'))
                    );
                    $this->load->model("controllers");
                    if ($this->controllers->add($params)) {
                        redirect("admin/controller", "refresh");
                    }
                } else {
                    $data['parent'] = $this->controllers->getData(array(
                        "where" => array("con_class" => "dropdown")
                    ));

                    $this->load->view('admin/controller/create', $data);
                }
            }
        }
    }

    public function edit($id) {
        if (!$this->session->userdata('logged')) {
            redirect("admin/login", "refresh");
        } else {
            if(!$this->user_permission['updatedata']==1)
            {
                $this->load->view('admin/accessdeny');
            }else{
                $this->load->model("controllers");

                if (isset($_POST['con_title'])) {
                    $params = array(
                        'data' => array(
                            'con_title' => $this->input->post('con_title'),
                            'con_active' => $this->input->post('con_active'),
                            'con_url' => $this->input->post('con_url'),
                            'con_icon' => $this->input->post('con_icon'),
                            'con_class' => $this->input->post('con_class'),
                            'notification_active' => $this->input->post('notification_active'),
                            'notification_text' => $this->input->post('notification_text'),
                            'con_active' => $this->input->post('con_active'),
                            'con_order' => $this->input->post('con_order'),
                            'con_status' => $this->input->post('con_status'),
                            'con_parent' => ($this->input->post('con_parent') == "" ? NULL : $this->input->post('con_parent'))
                        ),
                        'con_id' => $this->input->post('con_id')
                    );

                    if ($this->controllers->update($params)) {
                        $data['con'] = $this->controllers->getData(array(
                            "where" => array("con_id" => $id),
                            "limit" => 1
                        ));
                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );
                        $data['parent'] = $this->controllers->getData(array(
                            "where" => array("con_class" => "dropdown")
                        ));
                        $this->load->view('admin/controller/edit', $data);
                    }
                } else {
                    $data['con'] = $this->controllers->getData(array(
                        "where" => array("con_id" => $id),
                        "limit" => 1
                    ));

                    $data['parent'] = $this->controllers->getData(array(
                        "where" => array("con_class" => "dropdown")
                    ));

                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/controller/edit', $data);
                }
            }
        }
    }

    public function delete($con_id) {
        if (!$this->session->userdata('logged')) {
            redirect("admin/login", "refresh");
        } else {
            if(!$this->user_permission['deletedata']==1)
            {
                $this->load->view('admin/accessdeny');
            }else{
                $this->load->model("controllers");
                $this->controllers->delete($con_id);
                redirect("admin/controller", "refresh");
            }
        }
    }

}

?>
