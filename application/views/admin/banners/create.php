<!DOCTYPE html>
<html lang="en">
    <head>
        <?= $this->load->view('admin/header'); ?>
        <style>
            .banner-img{
                max-width: 800px !important;
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
                        array("title" => "CMS"),
                        array("title" => "Banners", "url" => "admin/banners"),
                        array("title" => "Create"),
                    );
                    $this->load->library('breadcrumb', $breadcrumb);
                    ?>

                    <div class="row-fluid sortable">
                        <div class="box span12">
                            <div class="box-header" data-original-title>
                                <h2><i class="halflings-icon edit"></i><span class="break"></span><strong>Create Banner</strong></h2>
                                <div class="box-icon">
                                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <?=$this->messagealert->alert("");?>
                                <form class="form-horizontal" name="form1" id="form1" method="post">
                                    <input name="banner_order" id="banner_order" type="hidden" value="1">
                                    <input name="banner_src" id="banner_src" type="hidden">
                                    <fieldset>
                                        <div class="row">
                                            <div class="control-group span12">
                                                <div class="controls">
                                                    <input type="file" name="Filedata" id="Filedata">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span12">
                                                <label class="control-label"><label>
                                                <div class="controls">
                                                    <img class="banner-img img-thumbnail hidden" id="img_show">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span12">
                                                <label class="control-label">Title</label>
                                                <div class="controls">
                                                    <input name="banner_title" id="banner_title" type="text"  style="width:90%;" required>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="page-header"><strong>Optionals</strong></p>
                                        <div class="row">
                                            <div class="control-group span12">
                                                <label class="control-label">Description</label>
                                                <div class="controls">
                                                    <textarea class="editor" name="banner_desc" id="banner_desc"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">URL</label>
                                                <div class="controls">
                                                    <input name="banner_link" id="banner_link" type="text">
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Target</label>
                                                <div class="controls">
                                                    <select name="banner_linktype" id="banner_linktype">
                                                        <option value=""></option>
                                                        <option value="_self">Same Page</option>
                                                        <option value="_blank">New Page</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Start Date</label>
                                                <div class="controls">
                                                    <input name="banner_startdate" id="banner_startdate" class="datepicker" type="datetime">
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Expire Date</label>
                                                <div class="controls">
                                                    <input name="banner_expiredate" id="banner_expiredate" class="datepicker" type="datetime">
                                                </div>
                                            </div>
                                        </div>
                                        <p class="page-header"></p>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Status</label>
                                                <div class="controls">
                                                    <select name="banner_status" id="banner_status">
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
        <script>
        $(function(){
           $('#Filedata').uploadify({
                'swf'  : '<?= base_url("themes/metro/js/uploadify.swf"); ?>',
                'uploader':'<?=site_url("admin/banners/upload");?>',
                //'formData':{'banner_src':''},
                'multi' : false,
                'auto' : true,
                'fileTypeExts' : '*.jpg;*.gif;*.png',
                'fileTypeDesc' : 'Image Files (.JPG, .GIF, .PNG)',
                'fileSizeLimit' : '100MB',
                'removeCompleted': true,
                'buttonText' : 'SELECT FILES',
                'method' : 'post',
                'onUploadSuccess' : function(file, data, response) {
                    console.log(data);
                    var res = $.parseJSON(data);
                    if(res.status)
                    {
                        console.log(res);
                        $("#banner_src").val(res.imgname);
                        $("#img_show").attr("src",res.src).removeClass("hidden");
                    }
                },
                'onQueueComplete': function(queueData){
                    console.log(queueData);
                }
            });
        });
        </script>
    </body>
</html>