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
                        array("title"=>"CMS"),
                        array("title"=>"Menus","url"=>"admin/menus"),
                        array("title" => "Edit"),
                    );
                    $this->load->library('breadcrumb', $breadcrumb);
                    ?>

                    <div class="row-fluid sortable">
                        <div class="box span12">
                            <div class="box-header" data-original-title>
                                <h2><i class="halflings-icon edit"></i><span class="break"></span><strong>Edit Menu</strong></h2>
                                <div class="box-icon">
                                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <?=$this->messagealert->alert($alert['message'],$alert['type']);?>
                                <form class="form-horizontal" name="form1" id="form1" method="post" action="<?=site_url("admin/menus/edit/".$menu['menu_id']);?>">
                                    <input name="menu_id" id="menu_id" type="hidden" value="<?=$menu['menu_id'];?>">
                                    <fieldset>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Title</label>
                                                <div class="controls">
                                                    <input name="menu_title" id="menu_title" type="text" value="<?=$menu['menu_title'];?>" required>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Title (EN)</label>
                                                <div class="controls">
                                                    <input name="menu_title_en" id="menu_title_en" value="<?=$menu['menu_title_en'];?>" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Parent</label>
                                                <div class="controls">
                                                    <select name="menu_parent" id="menu_parent">
                                                        <option value=""></option>
                                                        <?php
                                                        foreach($parentmenu as $parent)
                                                        {
                                                            if($menu['menu_parent'] == $parent['menu_id'])
                                                            {
                                                                echo '<option value="'.$parent['menu_id'].'" selected>'.$parent['menu_title'].'</option>';
                                                            }else{
                                                                echo '<option value="'.$parent['menu_id'].'">'.$parent['menu_title'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Status</label>
                                                <div class="controls">
                                                    <select name="menu_status" id="menu_status">
                                                        <option value="1" <?=($menu['menu_status']==1?"selected":"");?>>Active</option>
                                                        <option value="0" <?=($menu['menu_status']==0?"selected":"");?>>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="page-header"></div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Type</label>
                                                <div class="controls">
                                                    <select name="menu_type" id="menu_type">
                                                        <option value=""></option>
                                                        <option value="links" <?=($menu['menu_type']=="links"?"selected":"");?> >Links</option>
                                                        <option value="pages" <?=($menu['menu_type']=="pages"?"selected":"");?> >Pages</option>
                                                        <option value="contents" <?=($menu['menu_type']=="contents"?"selected":"");?> >Contents</option>
                                                        <option value="contentcategory" <?=($menu['menu_type']=="contentcategory"?"selected":"");?>>Content Category</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group span6 selecttype <?=isset($menu_params)?'':'hidden';?>">
                                                <label class="control-label">Select</label>
                                                <div class="controls">
                                                    <select name="menu_params" id="menu_params">
                                                        <?=isset($menu_params)?$menu_params:'';?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Link</label>
                                                <div class="controls">
                                                    <input name="menu_link" id="menu_link" type="text" value="<?=$menu['menu_link'];?>" <?=($menu['menu_type']!="links"?"disabled":'');?> >
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Link Method</label>
                                                <div class="controls">
                                                    <select name="menu_linktype" id="menu_linktype" <?=($menu['menu_type']!="links"?"disabled":'');?>>
                                                        <option value=""></option>
                                                        <option value="_self" <?=($menu['menu_linktype']=="_self"?"selected":"");?> >Self Page</option>
                                                        <option value="_blank" <?=($menu['menu_linktype']=="_blank"?"selected":"");?> >New Page</option>
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
        <script>
        $(function(){
           $("#menu_type").change(function(){
               var data = $("option:selected",this).val();
               switch(data)
               {
                   case "pages":
                       $("#menu_link").attr("disabled",true);
                       $("#menu_linktype").attr("disabled",true);
                       $.ajax({
                           url:'<?=site_url("admin/menus/getpages");?>',
                           success:function(response){
                               $("#menu_params").html(response);
                           }
                       });
                       $(".selecttype").removeClass("hidden");
                       break;
                   case "contents": 
                       $("#menu_link").attr("disabled",true);
                       $("#menu_linktype").attr("disabled",true);
                       $.ajax({
                           url:'<?=site_url("admin/menus/getcontents");?>',
                           success:function(response){
                               $("#menu_params").html(response);
                           }
                       });
                       $(".selecttype").removeClass("hidden");
                       break;
                   case "contentcategory": 
                       $("#menu_link").attr("disabled",true);
                       $("#menu_linktype").attr("disabled",true);
                       
                       $.ajax({
                           url:'<?=site_url("admin/menus/getcontentcategory");?>',
                           success:function(response){
                               $("#menu_params").html(response);
                           }
                       });
                       $(".selecttype").removeClass("hidden");
                       break;
                   default: 
                       $("#menu_link").attr("disabled",false);
                       $("#menu_linktype").attr("disabled",false);
                       $("#menu_params").html("");
                       $(".selecttype").addClass("hidden");
               }
           }); 
        });
        </script>
    </body>
</html>