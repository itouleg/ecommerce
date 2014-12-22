<!DOCTYPE html>
<html lang="en">
    <head>
        <?=$this->load->view('admin/header');?>
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
                        array("title"=>"Content Categories","url"=>"admin/contentcat"),
                    );
                    $this->load->library('breadcrumb',$breadcrumb);
                    
                    $gridview->render(array(
                        "title" => "Content Categories",
                        "span" => 12,
                        "toolbar" => array(
                            "setting" => false,
                            "minimize" => true,
                            "close" => false
                        ),
                        "model" => "content_categories as f",
                        "params" => array(
                            'cols' => 'f.cat_id,f.cat_name,f.cat_desc,f.cat_lang,f.cat_parent,f.cat_status,s.cat_id,s.cat_name',
                            'join' => array(
                                array(
                                    'table' => 'content_categories as s',
                                    'condition'=>'s.cat_id = f.cat_parent',
                                    'refby' => 'left'
                                 )
                            )
                        ),
                        "columns" => array(
                            "f.cat_id" => "ID",
                            "f.cat_name" => "Name",
                            "f.cat_lang" => "Lang",
                            "f.cat_status" => array(
                                "header" => "Status",
                                "class" => "label",
                                "status" => array(
                                    '<span class="label center change-status cursor" value="0" id="{f.cat_id}">Inactive</span>',
                                    '<span class="label label-success center change-status cursor" value="1" id="{f.cat_id}">Active</span>',
                                    '<span class="label label-important center change-status cursor" value="2" id="{f.cat_id}">Banned</span>',
                                    '<span class="label label-warning center change-status cursor" value="3" id="{f.cat_id}">Pending</span>'
                                )
                            )
                        ),
                        "displayaction" => true,
                        "actions" => array(
                            "create" => array(
                                "url" => "contentcat/create"
                            ),
                            "edit" => array(
                                "url" => "contentcat/edit/{f.cat_id}"
                            ),
                            "delete" => array(
                                "url" => "contentcat/delete/{f.cat_id}"
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
    </body>
</html>
