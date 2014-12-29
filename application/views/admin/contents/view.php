<!DOCTYPE html>
<html lang="en">
    <head>
        <?= $this->load->view('admin/header'); ?>
        <style>
            .form-horizontal .controls{
                margin-top: 5px !important;
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
                    <a class="brand" href="<?= site_url('main'); ?>"><span><?=$this->config->item('version');?></span></a>

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
                        array("title" => "CMS"),
                        array("title" => "Contents", "url" => "admin/contents"),
                        array("title" => $content['con_title']),
                    );
                    $this->load->library('breadcrumb', $breadcrumb);
                    ?>

                    <div class="row-fluid sortable">
                        <div class="box span12">
                            <div class="box-header" data-original-title>
                                <h2><i class="halflings-icon search"></i><span class="break"></span><strong><?= $content['con_title']; ?></strong></h2>
                                <div class="box-icon">
                                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <?= $this->messagealert->alert($alert['message'], $alert['type']); ?>
                                <p class="pull-right">
                                    <a class="btn btn-danger btn-edit" href="<?=site_url("admin/contents/edit/".$content['con_id']);?>">
                                        <i class="halflings-icon edit white"></i> Edit
                                    </a>
                                    <a class="btn btn-success btn-create" href="<?=site_url("admin/contents/create");?>">
                                        <i class="halflings-icon plus white"></i> Create
                                    </a>
                                </p>
                                <form class="form-horizontal">
                                    <div class="row">
                                        <div class="control-group span12">
                                            <label class="control-label"><strong>Category</strong></label>
                                            <div class="controls"><?= $content['cat_name']; ?></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="control-group span12">
                                            <label class="control-label"><strong>Title</strong></label>
                                            <div class="controls"><?= $content['con_title']; ?></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="control-group span12">
                                            <label class="control-label"></label>
                                            <div class="controls"><?= $content['con_content']; ?></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="control-group span6">
                                            <label class="control-label">Create</label>
                                            <div class="controls"><?= $content['con_create']; ?></div>
                                        </div>
                                        <div class="control-group span6">
                                            <label class="control-label">TAG</label>
                                            <div class="controls"><?= $content['con_tag']; ?></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="control-group span6">
                                            <label class="control-label"><strong>Language</strong></label>
                                            <div class="controls"><?= $content['lang_alias']; ?></div>
                                        </div>
                                        <div class="control-group span6">
                                            <label class="control-label"><strong>Status</strong></label>
                                            <div class="controls"><?= $content['con_status'] == 1 ? "Active" : "Inactive"; ?></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!--/span-->
                    </div><!--/row-->
                </div><!--/.fluid-container-->

                <!-- end: Content -->
            </div><!--/#content.span10-->
        </div><!--/fluid-row-->
        <div class="clearfix"></div>
        <?= $this->load->view('admin/footer'); ?>
    </body>
</html>