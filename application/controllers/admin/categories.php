<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categories extends CI_Controller {

    public $user_permission;

    public function __construct() {
        parent::__construct();
        $this->load->library("MY_Output", '', 'nocache');
        $this->user_permission = $this->cuserdata->getPermission("categories");
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

                $this->load->view('admin/categories/index', $data);
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
                    if($this->input->post('cat_parent')=="")
                    {
                        $params = array(
                            'cat_name' => $this->input->post('cat_name'),
                            'cat_name_en' => $this->input->post('cat_name_en'),
                            'cat_status' => $this->input->post('cat_status')
                        );
                    }else{
                        $params = array(
                            'cat_name' => $this->input->post('cat_name'),
                            'cat_name_en' => $this->input->post('cat_name_en'),
                            'cat_parent' => $this->input->post('cat_parent'),
                            'cat_status' => $this->input->post('cat_status')
                        );
                    }

                    $this->load->model("mcategories");
                    if ($this->mcategories->add($params)) {
                        redirect("admin/categories", "refresh");
                    }
                } else {
                    $this->load->model("mcategories");
                    $data['parentcat'] = $this->mcategories->getData(array(
                        'where' => array('f.cat_status'=>1),
                        'limit' => NULL
                    ));
                    
                    $this->load->view('admin/categories/create',$data);
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
                $this->load->model("mcategories");

                if (isset($_POST['cat_id'])) {
                    $params = array(
                        'data' => array(
                            'cat_name' => $this->input->post('cat_name'),
                            'cat_name_en' => $this->input->post('cat_name_en'),
                            'cat_parent' => $this->input->post('cat_parent'),
                            'cat_status' => $this->input->post('cat_status')
                        ),
                        'cat_id' => $this->input->post('cat_id')
                    );

                    if ($this->mcategories->update($params)) {
                    
                        $data['cat'] = $this->mcategories->getData(array(
                            "where" => array("f.cat_id" => $id),
                            "limit" => 1
                        ));
                        
                        $data['parentcat'] = $this->mcategories->getData(array(
                            'where' => array('f.cat_status'=>1,'f.cat_id !='=>$id),
                            'limit' => NULL
                        ));
                        
                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );

                        $this->load->view('admin/categories/edit', $data);
                    }
                } else {
                    
                    $data['cat'] = $this->mcategories->getData(array(
                        "where" => array("f.cat_id" => $id),
                        "limit" => 1
                    ));
                    
                    $data['parentcat'] = $this->mcategories->getData(array(
                            'where' => array('f.cat_status'=>1,'f.cat_id !='=>$id),
                            'limit' => NULL
                        ));
                    
                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/categories/edit', $data);
                }
            }
        }
    }
    
    public function updateorder() {
        if (!$this->session->userdata('logged')) {
            redirect("admin/login", "refresh");
        } else {
            $this->load->model("mcategories");
            
            $params = array(
                'data' => array(
                    'cat_order' => $this->input->post('cat_order'),
                ),
                'cat_id' => $this->input->post('cat_id')
            );
            if($this->mcategories->update($params))
            {
                $data = array("status"=>true);
                echo json_encode($data);
            }else{
                $data = array("status"=>false);
                echo json_encode($data);
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
                $this->load->model("mcategories");
                $this->mcategories->delete($id);
                redirect("admin/categories", "refresh");
            }
        }
    }

}

?>
