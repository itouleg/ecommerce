<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index() {
        if ($this->session->userdata('logged')) {
            redirect("admin/dashboard", "refresh");
        } else {
            $this->load->library("MY_Output", '', 'nocache');
            $this->load->view('admin/login');
        }
    }

    public function signin() {
        $this->load->model("musers");
        $this->load->model("mpermissions");
        $this->load->model("controllers");

        if (isset($_POST['username'])) {
            $userdata = $this->musers->getData(array(
                'where' => array(
                    'user_username' => $this->input->post('username'),
                    'user_password' => md5($this->input->post('password')),
                    'user_status' => 1
                ),
                'limit' => 1
            ));

            if (empty($userdata)) {
                $array = array(
                    "message" => "Invalid Username or Password.",
                    "status" => false
                );
                echo json_encode($array);
            } else {
                $user_id = $userdata['user_id'];
                $dep_id = $userdata['dep_id'];
                $username = $userdata['user_username'];
                $fullname = $userdata['user_fullname'];
                
                $newdata = array(
                    'user_id' => $user_id,
                    'username' => $username,
                    'fullname' => $fullname,
                    'dep_id' => $dep_id,
                    'logged' => TRUE
                );

                $this->session->set_userdata($newdata);

                $array = array(
                    "message" => "Login Success.",
                    "status" => true
                );
                echo json_encode($array);
            }
        } else {
            $array = array(
                "message" => "Please Enter Username and Password.",
                "status" => false
            );
            echo json_encode($array);
        }
    }
}

?>
