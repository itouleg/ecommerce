<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller {

    public function index() {
        //$this->load->library("MY_Output", '', 'nocache');
        $this->load->view('front/main');
    }

}

?>
