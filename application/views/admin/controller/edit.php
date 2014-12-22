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
                        array("title" => "Users"),
                        array("title" => "Controller", "url" => "admin/controller"),
                        array("title" => "Edit"),
                    );
                    $this->load->library('breadcrumb', $breadcrumb);
                    ?>

                    <div class="row-fluid sortable">
                        <div class="box span12">
                            <div class="box-header" data-original-title>
                                <h2><i class="halflings-icon edit"></i><span class="break"></span><strong>Edit Controller</strong></h2>
                                <div class="box-icon">
                                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <?=$this->messagealert->alert($alert['message'],$alert['type']);?>
                                <form class="form-horizontal" name="form1" id="form1" method="post" action="<?=site_url("admin/controller/edit/".$con['con_id']);?>">
                                    <input name="con_id" id="con_id" type="hidden" value="<?=$con['con_id'];?>">
                                    <input name="con_active" id="con_active" type="hidden" value="<?=$con['con_active'];?>">
                                    <fieldset>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Title</label>
                                                <div class="controls">
                                                    <input name="con_title" id="con_title" type="text" value="<?=$con['con_title'];?>" required>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Url</label>
                                                <div class="controls">
                                                    <input name="con_url" id="con_url" type="text" value="<?=$con['con_url'];?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">icon</label>
                                                <div class="controls">
                                                    <input name="con_icon" id="con_icon" type="text" value="<?=$con['con_icon'];?>" required>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Class</label>
                                                <div class="controls">
                                                    <select name="con_class" id="con_class">
                                                        <option value=""></option>
                                                        <option value="dropdown" <?=$con['con_class']=="dropdown"?"selected":"";?> >Dropdown</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Nofication Active</label>
                                                <div class="controls">
                                                    <select name="notification_active" id="notification_active">
                                                        <option value="0" <?=$con['notification_active']==0?"selected":"";?> >No</option>
                                                        <option value="1" <?=$con['notification_active']==1?"selected":"";?> >Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Nofication Text</label>
                                                <div class="controls">
                                                    <input name="notification_text" id="notification_text" value="<?=$con['notification_text'];?>" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Menu Active</label>
                                                <div class="controls">
                                                    <select name="con_active" id="con_active">
                                                        <option value="0" <?=$con['con_active']==0?"selected":"";?> >No</option>
                                                        <option value="1" <?=$con['con_active']==1?"selected":"";?> >Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Menu Order</label>
                                                <div class="controls">
                                                    <input name="con_order" id="con_order" type="number" value="<?=$con['con_order'];?>" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Main Menu</label>
                                                <div class="controls">
                                                    <select name="con_parent" id="con_parent">
                                                        <option value="">-- Main Menu --</option>
                                                        <?php
                                                        foreach($parent as $pa)
                                                        {
                                                            if($con['con_parent']==$pa['con_id'])
                                                            {
                                                                echo '<option value="'.$pa['con_id'].'" selected>'.$pa['con_title'].'</option>';
                                                            }else{
                                                                echo '<option value="'.$pa['con_id'].'">'.$pa['con_title'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Status</label>
                                                <div class="controls">
                                                    <select name="con_status" id="con_status">
                                                        <option value="1" <?=$con['con_status']==1?"selected":"";?> >Active</option>
                                                        <option value="0" <?=$con['con_status']==0?"selected":"";?> >Inactive</option>
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