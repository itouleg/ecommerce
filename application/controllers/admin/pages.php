<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends CI_Controller {

    public $user_permission;

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->library("MY_Output", '', 'nocache');
        $this->user_permission = $this->cuserdata->getPermission("pages");
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

                $this->load->view('admin/pages/index', $data);
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
                if (isset($_POST['page_title'])) {
                    $params = array(
                        'page_title' => $this->input->post('page_title'),
                        'page_content' => $this->input->post('page_content'),
                        'page_tag' => $this->input->post('page_tag'),
                        'page_lang' => $this->input->post('page_lang'),
                        'page_create' => date("Y-m-d H:i:s"),
                        'page_status' => $this->input->post('page_status')
                    );

                    $this->load->model("mpages", "pages");
                    if ($this->pages->add($params)) {
                        redirect("admin/pages", "refresh");
                    }
                } else {
                    $_SESSION['userfile'] = "pages";
                    $this->load->model("mlanguage");
                    $data['lang'] = $this->mlanguage->getData(array(
                        "where" => array("lang_status" => 1)
                    ));
                    $this->load->view('admin/pages/create',$data);
                }
            }
        }
    }

    public function edit($id) {
        if (!$this->session->userdata('logged')) {
            redirect("admin/login", "refresh");
        } else {
            $_SESSION['userfile'] = "pages";
            
            if (!$this->user_permission['updatedata'] == 1) {
                $this->load->view('admin/accessdeny');
            } else {
                $this->load->model("mpages");
                $this->load->model("mlanguage");

                if (isset($_POST['page_id'])) {
                    $params = array(
                        'data' => array(
                            'page_title' => $this->input->post('page_title'),
                            'page_content' => $this->input->post('page_content'),
                            'page_tag' => $this->input->post('page_tag'),
                            'page_lang' => $this->input->post('page_lang'),
                            'page_status' => $this->input->post('page_status')
                        ),
                        'page_id' => $this->input->post('page_id')
                    );

                    if ($this->mpages->update($params)) {
                        $data['lang'] = $this->mlanguage->getData(array(
                            "where" => array("lang_status" => 1)
                        ));
                        $data['page'] = $this->mpages->getData(array(
                            "where" => array("page_id" => $id),
                            "limit" => 1
                        ));
                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );

                        $this->load->view('admin/pages/edit', $data);
                    }
                } else {
                    
                    $data['lang'] = $this->mlanguage->getData(array(
                        "where" => array("lang_status" => 1)
                    ));
                    
                    $data['page'] = $this->mpages->getData(array(
                        "where" => array("page_id" => $id),
                        "limit" => 1
                    ));
                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/pages/edit', $data);
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
                $this->load->model("mpages");

                $data['page'] = $this->mpages->getData(array(
                    "where" => array("page_id" => $id),
                    "limit" => 1
                ));
                $data['alert'] = array(
                    'type' => NULL,
                    'message' => NULL
                );
                $this->load->view('admin/pages/view', $data);
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
                $this->load->model("mpages");
                $this->mpages->delete($id);
                redirect("admin/pages", "refresh");
            }
        }
    }

}

?>
