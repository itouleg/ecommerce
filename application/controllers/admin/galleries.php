<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Galleries extends CI_Controller {

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

                $this->load->view('admin/galleries/index', $data);
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
                $this->load->model("mgalleries");
                
                if (isset($_POST['gall_title'])) {
                    $params = array(
                        'gall_id' => $this->input->post('gall_id'),
                        'gall_title' => $this->input->post('gall_title'),
                        'gall_order' => $this->input->post('gall_order'),
                        'gall_create' => date("Y-m-d H:i:s"),
                        'gall_status' => $this->input->post('gall_status')
                    );

                    if ($this->mgalleries->add($params)) {
                        
                        $photo = $this->input->post('photo_src');
                        $phototitle = $this->input->post('photo_title');
                        foreach($photo as $key => $value)
                        {
                            $photoid = $this->mgalleries->getMaxPhoto($this->input->post('gall_id'));
                            
                            $this->mgalleries->addPhoto(array(
                                "photo_id" => ($photoid['photo_id']+1),
                                "photo_gallid" => $this->input->post('gall_id'),
                                "photo_src" => $value,
                                "photo_title" => $phototitle[$key]
                            ));
                        }
                        
                        redirect("admin/galleries", "refresh");
                    }
                } else {
                    $maxid = $this->mgalleries->getMax();
                    $data['gallid'] = $maxid['gall_id']+1;
                    $this->load->view('admin/galleries/create',$data);
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
                $this->load->model("mgalleries");

                if (isset($_POST['gall_id'])) {
                    $params = array(
                        'data' => array(
                            'gall_title' => $this->input->post('gall_title'),
                            'gall_order' => $this->input->post('gall_order'),
                            'gall_status' => $this->input->post('gall_status')
                        ),
                        'gall_id' => $this->input->post('gall_id')
                    );

                    if ($this->mgalleries->update($params)) {
                        $this->mgalleries->deleteAllPhoto($this->input->post('gall_id'));
                        $photo = $this->input->post('photo_src');
                        $phototitle = $this->input->post('photo_title');
                        foreach($photo as $key => $value)
                        {
                            $photoid = $this->mgalleries->getMaxPhoto($this->input->post('gall_id'));
                            
                            $this->mgalleries->addPhoto(array(
                                "photo_id" => ($photoid['photo_id']+1),
                                "photo_gallid" => $this->input->post('gall_id'),
                                "photo_src" => $value,
                                "photo_title" => $phototitle[$key]
                            ));
                        }
                        
                        $data['gallery'] = $this->mgalleries->getData(array(
                            "where" => array("gall_id" => $id),
                            "limit" => 1
                        ));
                        $data['photo'] = $this->mgalleries->getPhotoData(array(
                            "where" => array("photo_gallid" => $id),
                            "limit" => NULL
                        ));
                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );

                        $this->load->view('admin/galleries/edit', $data);
                    }
                } else {
                    
                    $data['gallery'] = $this->mgalleries->getData(array(
                        "where" => array("gall_id" => $id),
                        "limit" => 1
                    ));
                    $data['photo'] = $this->mgalleries->getPhotoData(array(
                        "where" => array("photo_gallid" => $id),
                        "limit" => NULL
                    ));
                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/galleries/edit', $data);
                }
            }
        }
    }
    
    public function updateorder() {
        if (!$this->session->userdata('logged')) {
            redirect("admin/login", "refresh");
        } else {
            $this->load->model("mgalleries");
            
            $params = array(
                'data' => array(
                    'gall_order' => $this->input->post('gall_order'),
                ),
                'gall_id' => $this->input->post('gall_id')
            );
            if($this->mgalleries->update($params))
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
                $this->deleteGallPhoto($id);
                
                $this->load->model("mgalleries");
                $this->mgalleries->delete($id);
                
                redirect("admin/galleries", "refresh");
            }
        }
    }
    
    public function deleteGallPhoto($gallid) {
        $this->load->model("mgalleries");
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/images/galleries/'.$gallid.'/';
        
        $files = glob($targetPath.'*'); // get all file names
        foreach($files as $file){ // iterate files
          if(is_file($file))
            unlink($file); // delete file
        }
        
        rmdir($targetPath);
    }
    
    public function deletePhoto() {
        $this->load->model("mgalleries");
        $gallid = $this->input->post('gall_id');
        $photoid = $this->input->post('photo_id');
        
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/images/galleries/'.$gallid.'/';
        $photo = $this->mgalleries->getPhotoData(array(
            "where" => array("photo_gallid" => $gallid,"photo_id"=>$photoid),
            "limit" => 1
        ));
        unlink($targetPath.$photo['photo_src']);
        
        $this->mgalleries->deletePhoto($photoid,$gallid);
        
        echo json_encode(array("status"=>true,"gallid"=>$gallid,"photoid"=>$photoid));
    }
    
    public function deletePhotoByImg() {
        $gallid = $this->input->post('gall_id');
        $photosrc = $this->input->post('photo_src');
        
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/images/galleries/'.$gallid.'/';
        
        unlink($targetPath.$photosrc);
        
        echo json_encode(array("status"=>true));
    }
    
    public function upload() 
    {
        $gallid = $this->input->post('gall_id');
        if (!empty($_FILES)) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/images/galleries/'.$gallid.'/';

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
                
                $return = array(
                    "status" => true,
                    "imgname" => $imgname,
                    "src" => base_url("images/galleries/".$gallid."/".$imgname)
                );
                echo json_encode($return);
            }
        }
    }
}

?>
