<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public $user_permission;


    public function __construct() {
        parent::__construct();
        $this->load->library("MY_Output", '', 'nocache');
        $this->user_permission = $this->cuserdata->getPermission("dashboard");
    }

    public function index() {
        $this->load->library("MY_Output", '', 'nocache');
        
        if (!$this->session->userdata('logged')) {
            //print_r($this->session->all_userdata());
            redirect("admin/login", "refresh");
        }else{
            
            if(!$this->user_permission['viewdata']==1)
            {
                $this->load->view('admin/accessdeny');
            }else{
                $this->load->library('metromenu','','metromenu');
                $data['metromenu'] = $this->metromenu;
                $this->load->view('admin/dashboard',$data);
            }
        }
    }

}

?>
