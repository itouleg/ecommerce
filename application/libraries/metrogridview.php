<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Metrogridview{

    public function __construct() {
        //parent::__construct();
    }

    public function render($params = NULL) {

        $config = array(
            "title" => isset($params['title']) ? $params['title'] : "Title",
            "icon" => isset($params['icon']) ? $params['icon'] : "halflings-icon th-large",
            "span" => isset($params['span']) ? $params['span'] : "12",
            "toolbar" => array(
                "setting" => isset($params['toolbar']['setting']) ? $params['toolbar']['setting'] : false,
                "minimize" => isset($params['toolbar']['minimize']) ? $params['toolbar']['minimize'] : true,
                "close" => isset($params['toolbar']['close']) ? $params['toolbar']['close'] : false
            ),
            "model" => isset($params['model']) ? $params['model'] : NULL,
            "params" => isset($params['params']) ? $params['params'] : NULL,
            "columns" => isset($params['columns']) ? $params['columns'] : NULL,
            "displayaction" => isset($params['displayaction']) ? $params['displayaction'] : true,
            "actions" => isset($params['actions']) ? $params['actions'] : NULL
        );

        echo '<div class="row-fluid sortable">		
                <div class="box span' . $config['span'] . '">
                    <div class="box-header" data-original-title>
                        <h2><i class="' . $config['icon'] . '"></i><span class="break"></span><strong>' . $config['title'] . '</strong></h2>
                        <div class="box-icon">
                            ' . ($config['toolbar']['setting'] ? '<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>' : '') . '
                            ' . ($config['toolbar']['minimize'] ? '<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>' : '') . '
                            ' . ($config['toolbar']['close'] ? '<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>' : '') . '
                        </div>
                    </div>
                    <div class="box-content">';

        if ($config['model'] != NULL) {
            $CI = & get_instance();
            $class = $CI->router->class;
            $user_permission = $CI->cuserdata->getPermission($class);
            if(isset($config['params']['cols']))
            {
                $CI->db->select($config['params']['cols'],false);
            }else{
                $CI->db->select("*");
            }
            $CI->db->from($config['model']);
            if($config['params']['join'] != NULL)
            {
                if(count($config['params']['join'])>0)
                {
                    foreach($config['params']['join'] as $table)
                    {
                        if(isset($table['refby']))
                        {
                            $CI->db->join($table['table'],$table['condition'],$table['refby']);
                        }else{
                            $CI->db->join($table['table'],$table['condition']);
                        }
                    }
                }
            }
            
            
            if (isset($config['params']['where'])) {
                $CI->db->where($config['params']['where']);
            }

            if (isset($config['params']['groupby'])) {
                $CI->db->group_by($config['params']['groupby']);
            }

            if (isset($config['params']['having'])) {
                $CI->db->having($config['params']['having']);
            }

            if (isset($config['params']['orderby'])) {
                $config['params']['orderby'] = implode(",", $config['params']['orderby']);
                $CI->db->order_by($config['params']['orderby']);
            }
            if (isset($config['params']['limit']) && $config['params']['limit'] != NULL) {
                $CI->db->limit($config['params']['limit'], $config['params']['start']);
            }
            $query = $CI->db->get();
            
            $fields = $this->getField($query->list_fields(),$config['columns']);
            $data = $query->result_array();
            
            if(isset($config['actions']['create']))
            {
                if($user_permission['createdata']==1)
                {
                    $url = $config['actions']['create']['url'];
                    echo '<p>
                            <a class="btn btn-success btn-delete" href="'.$url.'">
                                <i class="halflings-icon plus white"></i> CREATE
                            </a>
                        </p>';
                }
            }
            echo '<table class="table table-responsive table-striped table-hover table-bordered bootstrap-datatable datatable">
                <thead>
                    <tr>';
            foreach($fields as $key => $field)
            {
                echo '<th>'.$field.'</th>';
            }
            if($config['displayaction']!=false)
            {
                echo '<th>Actions</th>';
            }
            echo '</tr>
                </thead>   
                <tbody>';
            $count = 0;
            foreach($data as $rec)
            {
                echo '<tr>';
                foreach($fields as $key => $field)
                {
                    if(is_array($config['columns'][$key]))
                    {
                        if(isset($rec[$key]))
                        {
                            if(isset($config['columns'][$key]['class']))
                            {
                                switch($config['columns'][$key]['class'])
                                {
                                    case "label":
                                        if(isset($config['columns'][$key]['status']))
                                        {
                                            echo '<td class="center">'.$this->replaceTag2Data($config['columns'][$key]['status'][$rec[$key]],$rec).'</td>';
                                        }
                                        break;
                                }
                            }else{
                                //No Class
                                echo '<td>'.$rec[$key].'</td>';
                            }
                        }else{
                            //Not in Record
                        }
                    }else{
                        //Not Array
                        echo '<td>'.$rec[$key].'</td>';
                    }
                }
                if($config['displayaction']!=false)
                {
                    echo '<td class="center">';
                    if(isset($config['actions']['view']))
                    {
                        if($user_permission['viewdata']==1)
                        {
                            $url = isset($config['actions']['view']['url'])?$config['actions']['view']['url']:"#";
                            echo '<a class="btn btn-success btn-view" href="'.$this->replaceTag2Data($url,$rec).'">
                                    <i class="halflings-icon white zoom-in"></i>                                            
                                </a>';
                        }
                    }
                    if(isset($config['actions']['edit']))
                    {
                        if($user_permission['updatedata']==1)
                        {
                            $url = isset($config['actions']['edit']['url'])?$config['actions']['edit']['url']:"#";
                            echo '<a class="btn btn-info btn-edit" href="'.$this->replaceTag2Data($url,$rec).'">
                                    <i class="halflings-icon white edit"></i>                                            
                                </a>';
                        }
                    }
                    if(isset($config['actions']['delete']))
                    {
                        if($user_permission['deletedata']==1)
                        {
                            $url = isset($config['actions']['delete']['url'])?$config['actions']['delete']['url']:"#";
                            echo '<a class="btn btn-danger btn-delete" href="'.$this->replaceTag2Data($url,$rec).'">
                                    <i class="halflings-icon white trash"></i>
                                </a>';
                             echo '</td>';
                        }
                    }
                }
                 echo '</tr>';
                 $count++;
            }
            echo '</tbody>
            </table>';
        } else {
            echo '<table class="table table-striped table-hover table-bordered bootstrap-datatable datatable">
                    <tbody>
                        <tr>
                          <td class="center">No Data</td>
                        </tr>
                    </tbody>
                  </table>';
        }

        echo '</div>
                </div><!--/span-->
            </div><!--/row-->';
    }
    
    protected function getField($fields,$columns = NULL)
    {
        if($columns==NULL)
        {
            return $fields;
        }else{
            $field = array();
            foreach($columns as $key => $col)
            {
                if(is_array($col))
                {
                    $field[$key] = $col['header'];
                }else{
                    $field[$key] = $col;
                }
            }
            
            return $field;
        }
    }
    
    protected function replaceTag2Data($str,$rec)
    {
        $list = explode("{",$str);
        if(count($list)==1)
        {
            return $list[0];
        }else{
            $list2 = explode("}", $list[1]);
            $value = $rec[$list2[0]];
            $text = $list[0].$value.$list2[1];

            return $text;
        }
    }

}

?>