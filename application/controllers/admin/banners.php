<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Banners extends CI_Controller {

    public $user_permission;

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->library("MY_Output", '', 'nocache');
        $this->user_permission = $this->cuserdata->getPermission("banners");
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

                $this->load->view('admin/banners/index', $data);
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
                $this->load->model("mbanners", "banners");
                
                if (isset($_POST['banner_src'])) {
                    $params = array(
                        'banner_title' => $this->input->post('banner_title'),
                        'banner_desc' => $this->input->post('banner_desc'),
                        'banner_src' => $this->input->post('banner_src'),
                        'banner_link' => $this->input->post('banner_link'),
                        'banner_linktype' => $this->input->post('banner_linktype'),
                        'banner_order' => $this->input->post('banner_order'),
                        'banner_create' => date("Y-m-d H:i:s"),
                        'banner_status' => $this->input->post('banner_status')
                    );
                    
                    if($this->input->post('banner_startdate')!="")
                    {
                        $params['banner_startdate'] = $this->input->post('banner_startdate');
                    }
                    
                    if($this->input->post('banner_expiredate')!="")
                    {
                        $params['banner_expiredate'] = $this->input->post('banner_expiredate');
                    }

                    if ($this->banners->add($params)) {
                        redirect("admin/banners", "refresh");
                    }
                } else {
                    $_SESSION['userfile'] = "banners";
                    $this->load->view('admin/banners/create');
                }
            }
        }
    }

    public function edit($id) {
        if (!$this->session->userdata('logged')) {
            redirect("admin/login", "refresh");
        } else {
            $_SESSION['userfile'] = "banners";
            
            if (!$this->user_permission['updatedata'] == 1) {
                $this->load->view('admin/accessdeny');
            } else {
                $this->load->model("mbanners");

                if (isset($_POST['banner_id'])) {
                    $params = array(
                        'data' => array(
                            'banner_title' => $this->input->post('banner_title'),
                            'banner_desc' => $this->input->post('banner_desc'),
                            'banner_src' => $this->input->post('banner_src'),
                            'banner_link' => $this->input->post('banner_link'),
                            'banner_linktype' => $this->input->post('banner_linktype'),
                            'banner_order' => $this->input->post('banner_order'),
                            'banner_status' => $this->input->post('banner_status')
                        ),
                        'banner_id' => $this->input->post('banner_id')
                    );
                    
                    if($this->input->post('banner_startdate')!="")
                    {
                        $params['data']['banner_startdate'] = $this->input->post('banner_startdate');
                    }
                    
                    if($this->input->post('banner_expiredate')!="")
                    {
                        $params['data']['banner_expiredate'] = $this->input->post('banner_expiredate');
                    }

                    if ($this->mbanners->update($params)) {
                        
                        $data['banner'] = $this->mbanners->getData(array(
                            "where" => array("banner_id" => $id),
                            "limit" => 1
                        ));
                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );

                        $this->load->view('admin/banners/edit', $data);
                    }
                } else {
                    
                    $data['banner'] = $this->mbanners->getData(array(
                        "where" => array("banner_id" => $id),
                        "limit" => 1
                    ));
                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/banners/edit', $data);
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
                $this->load->model("mbanners");
                $this->mbanners->delete($id);
                
                $banner = $this->mbanners->getData(array(
                    "where"=> array("banner_id"=>$id),
                    "limit"=>1
                ));
                
                if(!empty($banner["banner_src"]))
                {
                    $targetPath = $_SERVER['DOCUMENT_ROOT'].'/images/banners/'.$banner["banner_src"];
                    @unlink($targetPath);
                }
                redirect("admin/banners", "refresh");
            }
        }
    }
    
    public function upload() 
    {
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/images/banners/';

            $imgname = date("Ymd") . rand(1111, 9999) . "_" . $_FILES['Filedata']['name'];
            $targetFile = str_replace('//', '/', $targetPath) . $imgname;

            if (!is_dir($targetPath)) {
                mkdir($targetPath);
            }
            if (move_uploaded_file($tempFile, $targetFile) != 1) {
                $return = array(
                    "status" => false,
                    "message" => "Upload Fail!"
                );
                echo json_encode($return);
            } else {
                /*$this->load->library('image_lib');

                $config['image_library'] = 'gd2';
                $config['source_image'] = $targetFile;
                $config['width'] = 940;
                $config['height'] = 452;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $config['source_image'] = $targetFile;
                $config['new_image'] = $targetFileThumb;
                $config['width'] = 400;
                $config['height'] = 120;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();*/
                
                if(isset($_POST['banner_src']) && $_POST['banner_src']!="")
                {
                    @unlink(str_replace('//', '/', $targetPath).$_POST['banner_src']);
                }
                
                $return = array(
                    "status" => true,
                    "imgname" => $imgname,
                    "src" => base_url("images/banners/".$imgname)
                );
                echo json_encode($return);
            }
        }
    }
}

?>
