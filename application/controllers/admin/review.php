<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Review extends CI_Controller {

    public $user_permission;

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->library("MY_Output", '', 'nocache');
        $this->user_permission = $this->cuserdata->getPermission("review");
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

                $this->load->view('admin/review/index', $data);
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
                if (isset($_POST['review_topic'])) {
                    $params = array(
                        'pro_id' => $this->input->post('pro_id'),
                        'review_topic' => $this->input->post('review_topic'),
                        'review_desc' => $this->input->post('review_desc'),
                        'review_create' => date("Y-m-d H:i:s"),
                        'mem_id' => $this->input->post('mem_id'),
                        'create_by' => $this->session->userdata('user_username'),
                        'review_status' => $this->input->post('review_status')
                    );

                    $this->load->model("mreview", "review");
                    if ($this->members->add($params)) {
                        redirect("admin/review", "refresh");
                    }
                } else {
                    $_SESSION['userfile'] = "reviews/";
                    $this->load->model("mproducts");
                    $data['type'] = $this->mproducts->getData(
                            array(
                                "where" => array("pro_status" => 1)
                            )
                    );
                    $this->load->view('admin/review/create', $data);
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
                $_SESSION['userfile'] = "reviews/";
                $this->load->model("mreview");

                if (isset($_POST['review_id'])) {
                    $params = array(
                        'data' => array(
                            'pro_id' => $this->input->post('pro_id'),
                            'review_topic' => $this->input->post('review_topic'),
                            'review_desc' => $this->input->post('review_desc'),
                            'mem_id' => $this->input->post('mem_id'),
                            'review_status' => $this->input->post('review_status')
                        ),
                        'review_id' => $this->input->post('review_id')
                    );

                    if ($this->mreview->update($params)) {

                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );

                        $this->load->view('admin/review/view', $data);
                    }
                } else {
                    
                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/review/edit', $data);
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
                $this->load->model("mreview");

                $data['member'] = $this->mreview->getData(array(
                    "where" => array("review_id" => $id),
                    "limit" => 1
                ));

                $data['alert'] = array(
                    'type' => NULL,
                    'message' => NULL
                );
                $this->load->view('admin/review/view', $data);
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
                $this->load->model("mreview");
                $this->mreview->delete($id);
                redirect("admin/review", "refresh");
            }
        }
    }

}

?>
