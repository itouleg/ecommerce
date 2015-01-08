<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menus extends CI_Controller {

    public $user_permission;

    public function __construct() {
        parent::__construct();
        $this->load->library("MY_Output", '', 'nocache');
        $this->user_permission = $this->cuserdata->getPermission("contentcat");
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

                $this->load->view('admin/menus/index', $data);
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
                if (isset($_POST['menu_title'])) {
                    if($this->input->post('menu_parent')=="")
                    {
                        $params = array(
                            'menu_title' => $this->input->post('menu_title'),
                            'menu_title_en' => $this->input->post('menu_title_en'),
                            'menu_link' => $this->input->post('menu_link'),
                            'menu_linktype' => $this->input->post('menu_linktype'),
                            'menu_type' => $this->input->post('menu_type'),
                            'menu_params' => $this->input->post('menu_params'),
                            'menu_status' => $this->input->post('menu_status')
                        );
                    }else{
                        $params = array(
                            'menu_parent' => $this->input->post('menu_parent'),
                            'menu_title' => $this->input->post('menu_title'),
                            'menu_title_en' => $this->input->post('menu_title_en'),
                            'menu_link' => $this->input->post('menu_link'),
                            'menu_linktype' => $this->input->post('menu_linktype'),
                            'menu_type' => $this->input->post('menu_type'),
                            'menu_params' => $this->input->post('menu_params'),
                            'menu_status' => $this->input->post('menu_status')
                        );
                    }

                    $this->load->model("mmenus");
                    if ($this->mmenus->add($params)) {
                        redirect("admin/menus", "refresh");
                    }
                } else {
                    $this->load->model("mmenus");
                    $data['parentmenu'] = $this->mmenus->getData(array(
                        'where' => array('f.menu_status'=>1),
                        'limit' => NULL
                    ));
                    
                    $this->load->view('admin/menus/create',$data);
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
                $this->load->model("mmenus");

                if (isset($_POST['menu_id'])) {
                    if($this->input->post('menu_parent')=="")
                    {
                        $params = array(
                            'data' => array(
                                'menu_title' => $this->input->post('menu_title'),
                                'menu_title_en' => $this->input->post('menu_title_en'),
                                'menu_link' => $this->input->post('menu_link'),
                                'menu_linktype' => $this->input->post('menu_linktype'),
                                'menu_type' => $this->input->post('menu_type'),
                                'menu_params' => $this->input->post('menu_params'),
                                'menu_status' => $this->input->post('menu_status')
                            ),
                            'menu_id' => $this->input->post('menu_id')
                        );
                    }else{
                        $params = array(
                            'data' => array(
                                'menu_parent' => $this->input->post('menu_parent'),
                                'menu_title' => $this->input->post('menu_title'),
                                'menu_title_en' => $this->input->post('menu_title_en'),
                                'menu_link' => $this->input->post('menu_link'),
                                'menu_linktype' => $this->input->post('menu_linktype'),
                                'menu_type' => $this->input->post('menu_type'),
                                'menu_params' => $this->input->post('menu_params'),
                                'menu_status' => $this->input->post('menu_status')
                            ),
                            'menu_id' => $this->input->post('menu_id')
                        );
                    }

                    if ($this->mmenus->update($params)) {
                    
                        $data['menu'] = $this->mmenus->getData(array(
                            "where" => array("f.menu_id" => $id),
                            "limit" => 1
                        ));
                        
                        switch($data['menu']['menu_type'])
                        {
                            case "pages": 
                                $this->load->model("mpages");
                                $pages = $this->mpages->getData(array(
                                    "where" => array("page_status"=>1),
                                    "limit"=>NULL
                                ));
                                $data['menu_params'] = '<option value="">-- Select Page --</option>';
                                foreach($pages as $page)
                                {
                                    if($data['menu']['menu_params']==$page['page_id'])
                                    {
                                        $data['menu_params'] .= '<option value="'.$page['page_id'].'" selected>'.$page['page_title'].'</option>';
                                    }else{
                                        $data['menu_params'] .= '<option value="'.$page['page_id'].'">'.$page['page_title'].'</option>';
                                    }
                                }
                                break;
                            case "contents": 
                                $this->load->model("mcontents");
                                $content = $this->mcontents->getData(array(
                                    "where" => array("con_status"=>1),
                                    "limit"=>NULL
                                ));
                                $data['menu_params'] = '<option value="">-- Select Content --</option>';
                                foreach($content as $con)
                                {
                                    if($data['menu']['menu_params']==$con['con_id'])
                                    {
                                        $data['menu_params'] .= '<option value="'.$con['con_id'].'" selected>'.$con['con_title'].'</option>';
                                    }else{
                                        $data['menu_params'] .= '<option value="'.$con['con_id'].'">'.$con['con_title'].'</option>';
                                    }
                                }
                                break;
                            case "contentcategory": 
                                $this->load->model("mcontentcat");
                                $concat = $this->mcontentcat->getData(array(
                                    "where" => array("f.cat_status"=>1),
                                    "limit"=>NULL
                                ));
                                $data['menu_params'] = '<option value="">-- Select Category --</option>';
                                foreach($concat as $cat)
                                {
                                    if($data['menu']['menu_params']==$cat['cat_id'])
                                    {
                                        $data['menu_params'] .= '<option value="'.$cat['cat_id'].'" selected>'.$cat['cat_name'].'</option>';
                                    }else{
                                        $data['menu_params'] .= '<option value="'.$cat['cat_id'].'">'.$cat['cat_name'].'</option>';
                                    }
                                }
                                break;
                        }
                        
                        $data['parentmenu'] = $this->mmenus->getData(array(
                            'where' => array('f.menu_status'=>1,'f.menu_id !='=>$id),
                            'limit' => NULL
                        ));
                        
                        $data['alert'] = array(
                            'type' => 'success',
                            'message' => 'Update successful.'
                        );

                        $this->load->view('admin/menus/edit', $data);
                    }
                } else {
                    
                    $data['menu'] = $this->mmenus->getData(array(
                        "where" => array("f.menu_id" => $id),
                        "limit" => 1
                    ));
                    
                    switch($data['menu']['menu_type'])
                    {
                        case "pages": 
                            $this->load->model("mpages");
                            $pages = $this->mpages->getData(array(
                                "where" => array("page_status"=>1),
                                "limit"=>NULL
                            ));
                            $data['menu_params'] = '<option value="">-- Select Page --</option>';
                            foreach($pages as $page)
                            {
                                if($data['menu']['menu_params']==$page['page_id'])
                                {
                                    $data['menu_params'] .= '<option value="'.$page['page_id'].'" selected>'.$page['page_title'].'</option>';
                                }else{
                                    $data['menu_params'] .= '<option value="'.$page['page_id'].'">'.$page['page_title'].'</option>';
                                }
                            }
                            break;
                        case "contents": 
                            $this->load->model("mcontents");
                            $content = $this->mcontents->getData(array(
                                "where" => array("con_status"=>1),
                                "limit"=>NULL
                            ));
                            $data['menu_params'] = '<option value="">-- Select Content --</option>';
                            foreach($content as $con)
                            {
                                if($data['menu']['menu_params']==$con['con_id'])
                                {
                                    $data['menu_params'] .= '<option value="'.$con['con_id'].'" selected>'.$con['con_title'].'</option>';
                                }else{
                                    $data['menu_params'] .= '<option value="'.$con['con_id'].'">'.$con['con_title'].'</option>';
                                }
                            }
                            break;
                        case "contentcategory": 
                            $this->load->model("mcontentcat");
                            $concat = $this->mcontentcat->getData(array(
                                "where" => array("f.cat_status"=>1),
                                "limit"=>NULL
                            ));
                            $data['menu_params'] = '<option value="">-- Select Category --</option>';
                            foreach($concat as $cat)
                            {
                                if($data['menu']['menu_params']==$cat['cat_id'])
                                {
                                    $data['menu_params'] .= '<option value="'.$cat['cat_id'].'" selected>'.$cat['cat_name'].'</option>';
                                }else{
                                    $data['menu_params'] .= '<option value="'.$cat['cat_id'].'">'.$cat['cat_name'].'</option>';
                                }
                            }
                            break;
                    }
                    
                    $data['parentmenu'] = $this->mmenus->getData(array(
                            'where' => array('f.menu_status'=>1,'f.menu_id !='=>$id),
                            'limit' => NULL
                        ));
                    
                    $data['alert'] = array(
                        'type' => NULL,
                        'message' => NULL
                    );
                    $this->load->view('admin/menus/edit', $data);
                }
            }
        }
    }
    
    public function updateorder() {
        if (!$this->session->userdata('logged')) {
            redirect("admin/login", "refresh");
        } else {
            $this->load->model("mmenus");
            
            $params = array(
                'data' => array(
                    'menu_order' => $this->input->post('menu_order'),
                ),
                'menu_id' => $this->input->post('menu_id')
            );
            if($this->mmenus->update($params))
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
                $this->load->model("mmenus");
                $this->mmenus->delete($id);
                redirect("admin/menus", "refresh");
            }
        }
    }
    
    public function getpages()
    {
        $this->load->model("mpages");
        $data = $this->mpages->getData(array(
            "where" => array("page_status"=>1),
            "limit"=>NULL
        ));
        echo '<option value="">-- Select Page --</option>';
        foreach($data as $page)
        {
            echo '<option value="'.$page['page_id'].'">'.$page['page_title'].'</option>';
        }
    }
    
    public function getcontents()
    {
        $this->load->model("mcontents");
        $data = $this->mcontents->getData(array(
            "where" => array("con_status"=>1),
            "limit"=>NULL
        ));
        echo '<option value="">-- Select Content --</option>';
        foreach($data as $con)
        {
            echo '<option value="'.$con['con_id'].'">'.$con['con_title'].'</option>';
        }
    }
    
    public function getcontentcategory()
    {
        $this->load->model("mcontentcat");
        $data = $this->mcontentcat->getData(array(
            "where" => array("f.cat_status"=>1),
            "limit"=>NULL
        ));
        echo '<option value="">-- Select Category --</option>';
        foreach($data as $cat)
        {
            echo '<option value="'.$cat['cat_id'].'">'.$cat['cat_name'].'</option>';
        }
    }
}

?>
