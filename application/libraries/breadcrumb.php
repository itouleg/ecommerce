<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Breadcrumb
{
    private  $list = array();
    
    function __construct($params = NULL) {
        $this->list = $params==NULL?array():$params;
        $this->render();
    }
    
    function render()
    {
        $num = count($this->list);
        
        echo '<ul class="breadcrumb">';
        echo '<li>
                <i class="icon-home"></i>
                <a href="'.site_url("dashboard").'">Home</a>'; 
        if($num>0)
        {
            echo '<i class="icon-angle-right"></i>';
        }
        echo '</li>';
        
        if($num>0)
        {
            $count = 1;
            foreach($this->list as $bread)
            {
                $url = isset($bread['url'])?site_url($bread['url']):"#";
                $title = isset($bread['title'])?$bread['title']:"";
                echo '<li><a href="'.$url.'">'.$title.'</a>';
                if($count<$num)
                {
                    echo '<i class="icon-angle-right"></i>';
                }
                echo '</li>';
                $count++;
            }
        }            
         echo '</ul>';
    }
}
