<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contentcat extends CI_Controller {

    public $user_permission;

    public function __construct() {
        parent::__construct();
        $this->load->library("MY_Output", '', 'nocache');
        $this->user_permission = $this->cuserdata->getPermission("contentcat");
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

                $this->load->view('admin/contentcat/index', $data);
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
                if (isset($_POST['cat_name'])) {
                    $params = array(
                        'cat_name' => $this->input->post('cat_name'),
                        'cat_desc' => $this->input->post('cat_desc'),
                        'cat_parent' => $this->input->post('cat_parent'),
                        'cat_lang' => $this->input->post('cat_lang'),
                        'cat_status' => $this->input->post('cat_status')
                    );

                    $this->load->model("mcontentcat");
                    if ($this->mcontentcat->add($params)) {
                        redirect("admin/contentcat", "refresh");
                    }
                } else {
                    $this->load->model("mlanguage");
                    $data['lang'] = $this->mlanguage->getData(array(
                        "where" => array("lang_status" => 1)
                    ));
                    
                    $this->load->model("mcontentcat");
                    $data['parentcat'] = $this->mcontentcat->getData(array(
                        'where' => array('f.cat_status'=>1),
                        'limit' => NULL
                    ));
                    
                    $this->load->view('admin/contentcat/create',$data);
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
                $this->load->model("mcontentcat");
                $this->load->model("mlanguage");

                if (isset($_POST['cat_id'])) {
                    $params = array(
                        'data' => array(
                            'cat_name' => $this->input->post('cat_name'),
                            'cat_desc' => $this->input->post('cat_desc'),
                            'cat_parent' => $this->input->post('cat_parent'),
                            'cat_lang' => $this->input->post('cat_lang'),
                            'cat_status' => $this->input->post('cat_status')
                        ),
                        'cat_id' => $this->input->post('cat_id')
                    );

                    if ($this->mcontentcat->update($params)) {
                        $data['lang'] = $this->mlanguage->getData(array(
                            "where" => array("lang_status" => 1)
                        ));
                    
                        $data['cat'] = $this->mcontentcat->getData(array(
                            "where" => array("f.cat_id" => $id),
                            "limit" => 1
                        ));
                        
                        $data['parentcat'] = $this->mcontentcat->getData(array(
                            'where' => array('f.cat_status'=>1),
                            'limit' => NULL
                        ));
                        
                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );

                        $this->load->view('admin/contentcat/edit', $data);
                    }
                } else {
                    
                    $data['lang'] = $this->mlanguage->getData(array(
                        "where" => array("lang_status" => 1)
                    ));
                    
                    $data['cat'] = $this->mcontentcat->getData(array(
                        "where" => array("cat_id" => $id),
                        "limit" => 1
                    ));
                    
                    $data['parentcat'] = $this->mcontentcat->getData(array(
                            'where' => array('f.cat_status'=>1),
                            'limit' => NULL
                        ));
                    
                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/contentcat/edit', $data);
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
                $this->load->model("mcontentcat");
                $this->mcontentcat->delete($id);
                redirect("admin/contentcat", "refresh");
            }
        }
    }

}

?>
