<!DOCTYPE html>
<html lang="en">
    <head>
        <?=$this->load->view('admin/header');?>
        <style>
            .order_input{
                width:50px;
            }
        </style>
    </head>
    <body>
        <!-- start: Header -->
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="<?=site_url('main'); ?>"><span><?=$this->config->item('version');?></span></a>

                    <!-- start: Header Menu -->
                    <div class="nav-no-collapse header-nav">
                        <ul class="nav pull-right">
                            <li class="dropdown hidden-phone">
                                <!-- Notify library --> 
                            </li>
                            <!-- start: Notifications Dropdown -->
                            <li class="dropdown hidden-phone">
                                <!-- Task library -->
                            </li>
                            <!-- end: Notifications Dropdown -->
                            <!-- start: Message Dropdown -->
                            <li class="dropdown hidden-phone">
                                <!-- Message library-->
                            </li>
                            <!-- end: Message Dropdown -->
                            <li>
                                <!--<a class="btn" href="#">
                                    <i class="halflings-icon white wrench"></i>
                                </a>-->
                            </li>
                            <!-- start: User Dropdown -->
                            <li class="dropdown">
                                <?=$this->cuserdata->render();?>
                            </li>
                            <!-- end: User Dropdown -->
                        </ul>
                    </div>
                    <!-- end: Header Menu -->

                </div>
            </div>
        </div>
        <!-- start: Header -->

        <div class="container-fluid-full">
            <div class="row-fluid">

                <!-- start: Main Menu -->
                <div id="sidebar-left" class="span2">
                    <?php $this->metromenu->render(); ?>
                </div>
                <!-- end: Main Menu -->

                <!-- start: Content -->
                <div id="content" class="span10">
                    <?php 
                    $breadcrumb = array(
                        array("title"=>"CMS"),
                        array("title"=>"Menus","url"=>"admin/menus"),
                    );
                    $this->load->library('breadcrumb',$breadcrumb);
                    
                    $gridview->render(array(
                        "title" => "Menus",
                        "span" => 12,
                        "toolbar" => array(
                            "setting" => false,
                            "minimize" => true,
                            "close" => false
                        ),
                        "model" => "menus f",
                        "params" => array(
                            'cols' => "f.menu_id,f.menu_order,f.menu_title,f.menu_title_en,f.menu_link,f.menu_linktype,f.menu_type,f.menu_params,f.menu_parent,f.menu_status,IFNULL(s.menu_id,'') as parent_id,IFNULL(s.menu_title,'') as parent_title,IFNULL(s.menu_title_en,'') as parent_title_en",
                            'join' => array(
                                array(
                                    'table' => 'menus s',
                                    'condition'=>'s.menu_id = f.menu_parent',
                                    'refby' => 'left'
                                 )
                            )
                        ),
                        "columns" => array(
                            "menu_order" => array(
                                "header" => "Order",
                                "class" => "label",
                                "value" => "<input type=\"text\" class=\"order_input\" name=\"order[]\" menu_id=\"{menu_id}\" id=\"order_{menu_id}\" value=\"{menu_order}\" >"
                            ),
                            "menu_title" => "Title",
                            "menu_title_en" => "Title(EN)",
                            "menu_type" => "Type",
                            "parent_title" => "Main Menu",
                            "menu_status" => array(
                                "header" => "Status",
                                "class" => "label",
                                "status" => array(
                                    '<span class="label center change-status cursor" value="0" id="{menu_id}">Inactive</span>',
                                    '<span class="label label-success center change-status cursor" value="1" id="{menu_id}">Active</span>',
                                    '<span class="label label-important center change-status cursor" value="2" id="{menu_id}">Banned</span>',
                                    '<span class="label label-warning center change-status cursor" value="3" id="{menu_id}">Pending</span>'
                                )
                            )
                        ),
                        "displayaction" => true,
                        "actions" => array(
                            "create" => array(
                                "url" => "menus/create"
                            ),
                            "edit" => array(
                                "url" => "menus/edit/{menu_id}"
                            ),
                            "delete" => array(
                                "url" => "menus/delete/{menu_id}"
                            )
                        )
                    ));
                    ?>
                    
                </div><!--/.fluid-container-->

                <!-- end: Content -->
            </div><!--/#content.span10-->
        </div><!--/fluid-row-->
        <div class="clearfix"></div>
        <?=$this->load->view('admin/footer');?>
        <script>
            $(function(){
               $(".order_input").keyup(function(event){
                   if(event.keyCode===13)
                   {
                       var menuid = $(this).attr("menu_id");
                       var order = $(this).val();
                       
                       $.ajax({
                           url:"<?=site_url('admin/menus/updateorder');?>",
                           type:"post",
                           data:{menu_id:menuid,menu_order:order},
                           success:function(response){
                               var res = $.parseJSON(response);
                               if(res.status===true)
                               {
                                   window.location.href="";
                               }
                           }
                       });
                   }
               }) ;
            });
        </script>
    </body>
</html>