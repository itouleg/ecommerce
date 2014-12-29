<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contents extends CI_Controller {

    public $user_permission;

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->library("MY_Output", '', 'nocache');
        $this->user_permission = $this->cuserdata->getPermission("contents");
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

                $this->load->view('admin/contents/index', $data);
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
                if (isset($_POST['con_title'])) {
                    $params = array(
                        'con_catid' => $this->input->post('con_catid'),
                        'con_title' => $this->input->post('con_title'),
                        'con_content' => $this->input->post('con_content'),
                        'con_tag' => $this->input->post('con_tag'),
                        'con_lang' => $this->input->post('con_lang'),
                        'con_create' => date("Y-m-d H:i:s"),
                        'con_status' => $this->input->post('con_status')
                    );

                    $this->load->model("mcontents", "contents");
                    if ($this->contents->add($params)) {
                        redirect("admin/contents", "refresh");
                    }
                } else {
                    $_SESSION['userfile'] = "contents";
                    $this->load->model("mlanguage");
                    $this->load->model("mcontentcat");
                    
                    $data['lang'] = $this->mlanguage->getData(array(
                        "where" => array("lang_status" => 1)
                    ));
                    $data['cat'] = $this->mcontentcat->getData(array(
                        "where" => array("f.cat_status" => 1),
                        "limit" => NULL
                    ));
                    $this->load->view('admin/contents/create',$data);
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
                $this->load->model("mcontentcat");
                $this->load->model("mcontents");
                $this->load->model("mlanguage");

                if (isset($_POST['con_id'])) {
                    $params = array(
                        'data' => array(
                            'con_catid' => $this->input->post('con_catid'),
                            'con_title' => $this->input->post('con_title'),
                            'con_content' => $this->input->post('con_content'),
                            'con_tag' => $this->input->post('con_tag'),
                            'con_lang' => $this->input->post('con_lang'),
                            'con_status' => $this->input->post('con_status')
                        ),
                        'con_id' => $this->input->post('con_id')
                    );

                    if ($this->mcontents->update($params)) {
                        $data['lang'] = $this->mlanguage->getData(array(
                            "where" => array("lang_status" => 1)
                        ));
                        $data['content'] = $this->mcontents->getData(array(
                            "where" => array("con_id" => $id),
                            "limit" => 1
                        ));
                        $data['cat'] = $this->mcontentcat->getData(array(
                            "where" => array("f.cat_status" => 1),
                            "limit" => NULL
                        ));
                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );

                        $this->load->view('admin/contents/edit', $data);
                    }
                } else {
                    $data['cat'] = $this->mcontentcat->getData(array(
                        "where" => array("f.cat_status" => 1),
                        "limit" => NULL
                    ));
                    $data['lang'] = $this->mlanguage->getData(array(
                        "where" => array("lang_status" => 1)
                    ));
                    
                    $data['content'] = $this->mcontents->getData(array(
                        "where" => array("con_id" => $id),
                        "limit" => 1
                    ));
                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/contents/edit', $data);
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
                $this->load->model("mcontents");

                $data['content'] = $this->mcontents->getData(array(
                    "where" => array("con_id" => $id),
                    "limit" => 1
                ));
                $data['alert'] = array(
                    'type' => NULL,
                    'message' => NULL
                );
                $this->load->view('admin/contents/view', $data);
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
                $this->load->model("mcontents");
                $this->mcontents->delete($id);
                redirect("admin/contents", "refresh");
            }
        }
    }

}

?>
