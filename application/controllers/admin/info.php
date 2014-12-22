<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Info extends CI_Controller {
    public $user_permission;

    public function __construct() {
        parent::__construct();
        $this->load->library("MY_Output", '', 'nocache');
        $this->user_permission = $this->cuserdata->getPermission("info");
    }

    public function index() {
        if (!$this->session->userdata('logged')) {
            redirect("admin/login", "refresh");
        } else {
            if (!$this->user_permission['viewdata'] == 1) {
                $this->load->view('admin/accessdeny');
            } else {
                $this->load->view('admin/info/index');
            }
        }
    }

}

?>
