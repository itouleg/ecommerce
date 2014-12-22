<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MetroMenu
{
    private $menu = array();
    
    function __construct() {
        
    }
    
    function render()
    {
        $this->setMenu();
        
        if(count($this->menu)>0)
        {
            echo '<div class="nav-collapse sidebar-nav">';
            echo '<ul class="nav nav-tabs nav-stacked main-menu">';
            foreach($this->menu as $m)
            {
                $title = isset($m['title'])?$m['title']:"No Title";
                $icon = isset($m['icon'])?$m['icon']:"";
                $class = isset($m['active'])?($m['active']?'class="active"':''):'';
                $url = isset($m['url'])?site_url($m['url']):"#";
                $notif = isset($m['notification'])?($m['notification']['active']?'<span class="label label-important"> '.$m['notification']['text'].' </span>':''):'';

                echo '<li '.$class.'>';
                if(isset($m['class']) && $m['class']=="dropdown")
                {
                    echo '<a class="dropmenu" href="#"><i class="'.$icon.'"></i><span class="hidden-tablet"> '.$title.'</span> '.$notif.'</a>';
                    if(isset($m['item']) && count($m['item'])>0)
                    {
                        echo '<ul>';
                        foreach($m['item'] as $item)
                        {
                            if(is_array($item))
                            {
                                $class = isset($item['active'])?($item['active']?"class=\"active\"":""):"";
                                $url = isset($item['url'])?site_url($item['url']):"#";
                                $icon = isset($item['icon'])?$item['icon']:"";
                                $title = isset($item['title'])?$item['title']:"No Title";
                                $notif = isset($item['notification'])?($item['notification']['active']?'<span class="label label-important"> '.$item['notification']['text'].' </span>':''):'';
                                
                                echo '<li '.$class.'><a class="submenu" href="'.$url.'"><i class="'.$icon.'"></i><span class="hidden-tablet"> '.$title.'</span> '.$notif.'</a></li>';
                            }
                        }
                        echo '</ul>';
                    }
                }else{
                    echo '<a href="'.$url.'"><i class="'.$icon.'"></i><span class="hidden-tablet"> '.$title.'</span> '.$notif.'</a>';
                }
                echo '</li>';
            }
            echo '</ul>';
            echo '</div>';
        }
    }
    
    function setMenu()
    {
        $CI =& get_instance();
        $CI->load->model('controllers');
        
        $params['where'] = "con_parent IS NULL and con_status = '1'";
        $params['orderby'] = array("con_order","con_id");
        $control = $CI->controllers->getData($params);
        $params = array();
        
        foreach($control as $con)
        {
            $con_id = $con['con_id'];
            $title = $con['con_title'];
            $class = $con['con_class']!=NULL?$con['con_class']:"";
            $url = $con['con_url'];
            $icon = $con['con_icon'];
            $notification_active = $con['notification_active'];
            $notification_text = $con['notification_text'];
            $active = $this->getActive($url);
            
            $item = array();
            $params = array();
            $params['where'] = "con_parent = '$con_id' and con_status = '1'";
            $params['orderby'] = array("con_order","con_id");
            $subcontrol = $CI->controllers->getData($params);
            if(count($subcontrol)>0)
            {
                foreach($subcontrol as $sub)
                {
                    $subtitle = $sub['con_title'];
                    $subclass = $sub['con_class']!=NULL?$sub['con_class']:"";
                    $suburl = $sub['con_url'];
                    $subactive = $this->getActive($suburl);
                    $subicon = $sub['con_icon'];
                    $subnotification_active = $sub['notification_active'];
                    $subnotification_text = $sub['notification_text'];
                    
                    $suburlper = str_replace("admin/", "", $suburl);
                    $sub_permission = $CI->cuserdata->getPermission($suburlper);
                    if($sub_permission['viewdata']==1)
                    {
                        $item[] = array(
                            "title" => $subtitle,
                            "class" => $subclass,
                            "icon" => $subicon,
                            "url" => $suburl,
                            "active" => $subactive,
                            "notification"=>array(
                                "active"=>$subnotification_active,
                                "text"=> $subnotification_text
                            )
                        );
                    }
                }
            }
            
            
            if($url!="#")
            {
                $urlper = str_replace("admin/", "", $url);
                $user_permission = $CI->cuserdata->getPermission($urlper);
                //var_dump($user_permission);
                //echo $urlper." ".$user_permission['viewdata']."<br />";
                if($user_permission['viewdata']==1)
                {
                    $this->menu[] = array(
                        "title" => $title,
                        "class" => $class,
                        "icon" => $icon,
                        "url" => $url,
                        "active" => $active,
                        "notification"=>array(
                            "active"=>$notification_active,
                            "text"=> $notification_text
                        ),
                        "item" => $item
                    );
                }
            }else{
                $this->menu[] = array(
                    "title" => $title,
                    "class" => $class,
                    "icon" => $icon,
                    "url" => $url,
                    "active" => $active,
                    "notification"=>array(
                        "active"=>$notification_active,
                        "text"=> $notification_text
                    ),
                    "item" => $item
                );
            }
        }
    }
    
    function getActive($url)
    {
        $CI =& get_instance();
        $class = $CI->router->class;
        
        if($url!="#" && !empty($url))
        {
            $controller = str_replace("admin/", "", $url);
            if(strtolower($controller)==strtolower($class))
            {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
?>
