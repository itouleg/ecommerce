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
                        array("title"=>"Customers"),
                        array("title"=>"Members","url"=>"admin/members"),
                        array("title" => "Create"),
                    );
                    $this->load->library('breadcrumb', $breadcrumb);
                    ?>

                    <div class="row-fluid sortable">
                        <div class="box span12">
                            <div class="box-header" data-original-title>
                                <h2><i class="halflings-icon edit"></i><span class="break"></span><strong>Create Member</strong></h2>
                                <div class="box-icon">
                                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <?=$this->messagealert->alert("");?>
                                <form class="form-horizontal" name="form1" id="form1" method="post">
                                    <input name="mem_photo" id="mem_photo" type="hidden" value=""> 
                                    <fieldset>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Member Type</label>
                                                <div class="controls">
                                                    <select name="type_id" id="type_id">
                                                        <option value="">--- Select Member Type ---</option>
                                                        <?php
                                                        foreach($type as $t)
                                                        {
                                                          echo '<option value="'.$t['type_id'].'">'.$t['type_name'].'</option>';  
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Name & Surname</label>
                                                <div class="controls">
                                                    <input name="mem_fullname" id="mem_fullname" type="text" required>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Nick Name</label>
                                                <div class="controls">
                                                    <input name="mem_nickname" id="mem_nickname" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Username</label>
                                                <div class="controls">
                                                    <input name="mem_username" id="mem_username" type="text" required>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Password</label>
                                                <div class="controls">
                                                    <input name="mem_password" id="mem_password" type="password" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Email</label>
                                                <div class="controls">
                                                    <input name="mem_email" id="mem_email" type="email" required>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Tel.</label>
                                                <div class="controls">
                                                    <input name="mem_mobile" id="mem_mobile" type="tel">
                                                </div>
                                            </div>
                                        </div>
                                        <fieldset>
                                            <legend>Address</legend>
                                            <div class="row">
                                                <div class="control-group span12">
                                                    <label class="control-label">Address</label>
                                                    <div class="controls">
                                                        <textarea name="mem_address" id="mem_address" ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="control-group span6">
                                                    <label class="control-label">Sub District</label>
                                                    <div class="controls">
                                                        <input name="mem_subdistrict" id="mem_subdistrict" type="text">
                                                    </div>
                                                </div>
                                                <div class="control-group span6">
                                                    <label class="control-label">District</label>
                                                    <div class="controls">
                                                        <input name="mem_district" id="mem_district" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="control-group span6">
                                                    <label class="control-label">Province</label>
                                                    <div class="controls">
                                                        <input name="mem_province" id="mem_province" type="text">
                                                    </div>
                                                </div>
                                                <div class="control-group span6">
                                                    <label class="control-label">Zip Code</label>
                                                    <div class="controls">
                                                        <input name="mem_zip" id="mem_zip" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Status</label>
                                                <div class="controls">
                                                    <select name="mem_status" id="mem_status">
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
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