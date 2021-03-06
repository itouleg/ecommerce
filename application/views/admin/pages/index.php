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
                        array("title"=>"Pages"),
                    );
                    $this->load->library('breadcrumb',$breadcrumb);
                    
                    $gridview->render(array(
                        "title" => "Pages",
                        "span" => 12,
                        "toolbar" => array(
                            "setting" => false,
                            "minimize" => true,
                            "close" => false
                        ),
                        "model" => "pages",
                        "params" => array(
                            'join' => array(
                                array(
                                    'table' => 'language',
                                    'condition'=>'language.lang_id = pages.page_lang'
                                 )
                            )
                        ),
                        "columns" => array(
                            "page_title" => "Title",
                            "page_create" => "Created",
                            "page_tag" => "TAG",
                            "lang_alias" => "Lang",
                            "page_status" => array(
                                "header" => "Status",
                                "class" => "label",
                                "status" => array(
                                    '<span class="label center change-status cursor" value="0" id="{page_id}">Inactive</span>',
                                    '<span class="label label-success center change-status cursor" value="1" id="{page_id}">Active</span>',
                                    '<span class="label label-important center change-status cursor" value="2" id="{page_id}">Banned</span>',
                                    '<span class="label label-warning center change-status cursor" value="3" id="{page_id}">Pending</span>'
                                )
                            )
                        ),
                        "displayaction" => true,
                        "actions" => array(
                            "view" => array(
                                "url" => "pages/view/{page_id}"
                            ),
                            "create" => array(
                                "url" => "pages/create"
                            ),
                            "edit" => array(
                                "url" => "pages/edit/{page_id}"
                            ),
                            "delete" => array(
                                "url" => "pages/delete/{page_id}"
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
