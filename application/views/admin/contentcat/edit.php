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
                        array("title"=>"Content Categories","url"=>"admin/contentcat"),
                        array("title" => "Edit"),
                    );
                    $this->load->library('breadcrumb', $breadcrumb);
                    ?>

                    <div class="row-fluid sortable">
                        <div class="box span12">
                            <div class="box-header" data-original-title>
                                <h2><i class="halflings-icon edit"></i><span class="break"></span><strong>Edit Category</strong></h2>
                                <div class="box-icon">
                                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <?= $this->messagealert->alert($alert['message'], $alert['type']); ?>
                                <form class="form-horizontal" name="form1" id="form1" method="post" action="<?= site_url("admin/contentcat/edit/" . $cat['cat_id']); ?>">
                                    <input name="cat_id" id="cat_id" type="hidden" value="<?= $cat['cat_id']; ?>">
                                    <fieldset>
                                        <div class="row">
                                            <div class="control-group span12">
                                                <label class="control-label">Name</label>
                                                <div class="controls">
                                                    <input name="cat_name" id="cat_name" type="text" value="<?=$cat['cat_name'];?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span12">
                                                <label class="control-label">Description</label>
                                                <div class="controls">
                                                    <textarea name="cat_desc" id="cat_desc" class="editor"><?=$cat['cat_desc'];?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Language</label>
                                                <div class="controls">
                                                    <select name="cat_lang" id="cat_lang">
                                                        <?php
                                                        foreach($lang as $la)
                                                        {
                                                            if($cat['cat_lang']==$la['lang_id'])
                                                            {
                                                                echo '<option value="'.$la['lang_id'].'" selected>'.$la['lang_name'].'</option>';
                                                            }else{
                                                                echo '<option value="'.$la['lang_id'].'">'.$la['lang_name'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Parent</label>
                                                <div class="controls">
                                                    <select name="cat_parent" id="cat_parent">
                                                        <option value=""></option>
                                                        <?php
                                                        foreach($parentcat as $parent)
                                                        {
                                                            if($cat['cat_parent']==$parent['cat_id'])
                                                            {
                                                                echo '<option value="'.$parent['cat_id'].'" selected>'.$parent['cat_name'].'</option>';
                                                            }else{
                                                                echo '<option value="'.$parent['cat_id'].'">'.$parent['cat_name'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Status</label>
                                                <div class="controls">
                                                    <select name="cat_status" id="cat_status">
                                                        <option value="1" <?= ($cat['cat_status'] == 1 ? "selected" : ""); ?> >Active</option>
                                                        <option value="0" <?= ($cat['cat_status'] == 0 ? "selected" : ""); ?> >Inactive</option>
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