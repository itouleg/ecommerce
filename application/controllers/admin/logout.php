<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logout extends CI_Controller {

    public function index() {
        $newdata = array(
            'user_id' => NULL,
            'username' => NULL,
            'fullname' => NULL,
            'dep_id' => NULL,
            'permission' => NULL,
            'logged' => NULL
        );

        $this->session->unset_userdata($newdata);
        //$this->session->sess_destroy();
        
        redirect("admin/login", "refresh");
    }

}

?>