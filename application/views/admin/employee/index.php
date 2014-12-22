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
                        array("title"=>"Users"),
                        array("title"=>"Employee","url"=>"admin/employee"),
                    );
                    $this->load->library('breadcrumb',$breadcrumb);
                    
                    $gridview->render(array(
                        "title" => "Employee",
                        "span" => 12,
                        "toolbar" => array(
                            "setting" => false,
                            "minimize" => true,
                            "close" => false
                        ),
                        "model" => "users",
                        "params" => array(
                            'join' => array(
                                array(
                                    'table' => 'departments',
                                    'condition'=>'departments.dep_id = users.dep_id'
                                 )
                            ),
                            'where' => array(
                                'user_id !='=>1
                            )
                        ),
                        "columns" => array(
                            "user_id" => "ID",
                            "user_fullname" => "Name",
                            "user_username" => "Username",
                            "user_email" => "Email",
                            "user_mobile" => "user_mobile",
                            "dep_name" => "Department",
                            "user_status" => array(
                                "header" => "Status",
                                "class" => "label",
                                "status" => array(
                                    '<span class="label center change-status cursor" value="0" id="{user_id}">Inactive</span>',
                                    '<span class="label label-success center change-status cursor" value="1" id="{user_id}">Active</span>',
                                    '<span class="label label-important center change-status cursor" value="2" id="{user_id}">Banned</span>',
                                    '<span class="label label-warning center change-status cursor" value="3" id="{user_id}">Pending</span>'
                                )
                            )
                        ),
                        "displayaction" => true,
                        "actions" => array(
                            "create" => array(
                                "url" => "employee/create"
                            ),
                            "view" => array(
                                "url" => "employee/view/{user_id}"
                            ),
                            "edit" => array(
                                "url" => "employee/edit/{user_id}"
                            ),
                            "delete" => array(
                                "url" => "employee/delete/{user_id}"
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
