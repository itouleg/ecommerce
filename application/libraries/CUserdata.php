<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CUserdata
{
    public $username;
    public $user_id;
    public $fullname;
    public $dep_id;
    private $CI;
    
    function __construct() {
        $this->CI = & get_instance();
        
        $this->username = $this->CI->session->userdata("username");
        $this->user_id = $this->CI->session->userdata("user_id");
        $this->fullname = $this->CI->session->userdata("fullname");
        $this->dep_id = $this->CI->session->userdata("dep_id");
    }
    
    function getPermission($controller_name = NULL)
    {
        $class = $this->CI->router->class;
        if(!empty($controller_name))
        {
            if(strtolower($controller_name)==strtolower($class))
            {
                $this->CI->load->model("controllers");
                $condata = $this->CI->controllers->getData(array(
                    'where' => "con_url like 'admin/$class'",
                    'limit' => 1
                ));
                $this->CI->load->model("mpermissions");
                $permission = $this->CI->mpermissions->getData(array(
                    'where' => array(
                        'con_id' => $condata['con_id'],
                        'dep_id' => $this->dep_id
                    ),
                    'limit' => 1
                ));
            }else{
                $this->CI->load->model("controllers");
                $condata = $this->CI->controllers->getData(array(
                    'where' => "con_url like 'admin/$controller_name'",
                    'limit' => 1
                ));
                $this->CI->load->model("mpermissions");
                $permission = $this->CI->mpermissions->getData(array(
                    'where' => array(
                        'con_id' => $condata['con_id'],
                        'dep_id' => $this->dep_id
                    ),
                    'limit' => 1
                ));
            }
            
            return $permission;
        }else{
            return NULL;
        }
    }
    
    function getDepartment()
    {
        $this->CI->load->model("mdepartments");
        $depdata = $this->CI->mdepartments->getData(
                array(
                    'where' => array("dep_id"=>$this->dep_id),
                    'limit' => 1
                )
        );
        return $depdata;
    }
    
    function render()
    {
        echo '<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="halflings-icon white user"></i>'.$this->fullname.'
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li class="dropdown-menu-title">
                    <span>Account Settings</span>
                </li>
                <li><a href="'.site_url('admin/employee/profile').'"><i class="halflings-icon user"></i> Profile</a></li>
                <li><a href="'.site_url('admin/logout').'"><i class="halflings-icon off"></i> Logout</a></li>
            </ul>';
    }
}
?>