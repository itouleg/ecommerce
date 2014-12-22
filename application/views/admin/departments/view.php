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
                        array("title" => "Users"),
                        array("title" => "Departments", "url" => "admin/departments"),
                        array("title" => $dep['dep_name']),
                    );
                    $this->load->library('breadcrumb', $breadcrumb);
                    ?>

                    <div class="row-fluid sortable">
                        <div class="box span12">
                            <div class="box-header" data-original-title>
                                <h2><i class="halflings-icon search"></i><span class="break"></span><strong><?= $dep['dep_name']; ?> Detail</strong></h2>
                                <div class="box-icon">
                                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <?= $this->messagealert->alert($alert['message'], $alert['type']); ?>
                                <p class="pull-right">
                                    <a class="btn btn-danger btn-edit" href="<?=site_url("admin/departments/edit/".$dep['dep_id']);?>">
                                        <i class="halflings-icon edit white"></i> Edit
                                    </a>
                                    <a class="btn btn-success btn-create" href="<?=site_url("admin/departments/create");?>">
                                        <i class="halflings-icon plus white"></i> Create
                                    </a>
                                </p>
                                <form class="form-horizontal">
                                    <div class="row">
                                        <div class="control-group span12">
                                            <label class="control-label"><strong>Name</strong></label>
                                            <div class="controls"><?= $dep['dep_name']; ?></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="control-group span12">
                                            <label class="control-label"><strong>Description</strong></label>
                                            <div class="controls"><?= $dep['dep_desc']; ?></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="control-group span12">
                                            <label class="control-label"><strong>Status</strong></label>
                                            <div class="controls"><?= $dep['dep_status'] == 1 ? "Active" : "Inactive"; ?></div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <h3 class="page-header">Permissions</h3>
                                    <div class="row">
                                        <div class="control-group span11">
                                            <label class="control-label"></label>
                                            <div class="controls">
                                                <table class="table table-striped table-bordered">
                                                    <tr>
                                                        <th class="center">Page</th>
                                                        <th class="center">View</th>
                                                        <th class="center">Create</th>
                                                        <th class="center">Edit</th>
                                                        <th class="center">Delete</th>
                                                    </tr>
                                                    <?php
                                                    if (is_array($controller)) {
                                                        foreach ($controller as $con) {
                                                            $per = getPermission($permission, $con['con_id']);
                                                            if ($per == NULL) {
                                                                $per = array(
                                                                    'viewdata' => false,
                                                                    'createdata' => false,
                                                                    'updatedata' => false,
                                                                    'deletedata' => false
                                                                );
                                                            }
                                                            echo '<tr>';
                                                            echo '<td>' . $con['con_title'] . '</td>';
                                                            echo '<td class="center">' . ($per['viewdata'] == true ? '<i class="halflings-icon ok"></i>' : '<i class="halflings-icon remove"></i>') . '</td>';
                                                            echo '<td class="center">' . ($per['createdata'] == true ? '<i class="halflings-icon ok"></i>' : '<i class="halflings-icon remove"></i>') . '</td>';
                                                            echo '<td class="center">' . ($per['updatedata'] == true ? '<i class="halflings-icon ok"></i>' : '<i class="halflings-icon remove"></i>') . '</td>';
                                                            echo '<td class="center">' . ($per['deletedata'] == true ? '<i class="halflings-icon ok"></i>' : '<i class="halflings-icon remove"></i>') . '</td>';
                                                            echo '</tr>';
                                                        }
                                                    }
                                                    ?>

                                                </table>
                                            </div>
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

<?php

function getPermission($permission, $conid) {
    foreach ($permission as $per) {
        if ($per['con_id'] == $conid) {
            return $per;
        }
    }

    return null;
}
?>