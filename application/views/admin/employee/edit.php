<!DOCTYPE html>
<html lang="en">
    <head>
        <?= $this->load->view('admin/header'); ?>
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
                        array("title" => "Edit"),
                    );
                    $this->load->library('breadcrumb', $breadcrumb);
                    ?>

                    <div class="row-fluid sortable">
                        <div class="box span12">
                            <div class="box-header" data-original-title>
                                <h2><i class="halflings-icon edit"></i><span class="break"></span><strong>Edit Employee</strong></h2>
                                <div class="box-icon">
                                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <?=$this->messagealert->alert($alert['message'],$alert['type']);?>
                                <form class="form-horizontal" name="form1" id="form1" method="post" action="<?=site_url("admin/employee/edit/".$user['user_id']);?>">
                                    <input name="user_id" id="user_id" type="hidden" value="<?=$user['user_id'];?>">
                                    <fieldset>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Name & Surname</label>
                                                <div class="controls">
                                                    <input name="user_fullname" id="user_fullname" type="text" value="<?=$user['user_fullname'];?>" required>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Departments</label>
                                                <div class="controls">
                                                    <select name="dep_id" id="dep_id">
                                                        <option value="">--- Select Departments ---</option>
                                                        <?php
                                                        foreach($department as $dep)
                                                        {
                                                            if($user['dep_id']==$dep['dep_id'])
                                                            {
                                                                echo '<option value="'.$dep['dep_id'].'" selected>'.$dep['dep_name'].'</option>';
                                                            }else{
                                                                echo '<option value="'.$dep['dep_id'].'">'.$dep['dep_name'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Username</label>
                                                <div class="controls">
                                                    <input name="user_username" id="user_username" type="text" value="<?=$user['user_username'];?>" required>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Password</label>
                                                <div class="controls">
                                                    <input name="user_password" id="user_password" type="password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Email</label>
                                                <div class="controls">
                                                    <input name="user_email" id="user_email" type="email" value="<?=$user['user_email'];?>" required>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Mobile</label>
                                                <div class="controls">
                                                    <input name="user_mobile" id="user_mobile" type="tel" value="<?=$user['user_mobile'];?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Status</label>
                                                <div class="controls">
                                                    <select name="user_status" id="user_status">
                                                        <option value="1" <?=($user['user_status']==1?"selected":"");?> >Active</option>
                                                        <option value="0" <?=($user['user_status']==0?"selected":"");?> >Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button id="reset-btn" type="reset" class="btn btn-danger pull-right"><i class="icon-repeat"></i> Cancel</button>
                                            <button id="submit-btn" type="submit" class="btn btn-primary pull-right"><i class="icon-save"></i> Save</button>
                                        </div>
                                    </fieldset>
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