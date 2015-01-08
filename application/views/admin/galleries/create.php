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
                        array("title" => "CMS"),
                        array("title" => "Gallery", "url" => "admin/galleries"),
                        array("title" => "Create"),
                    );
                    $this->load->library('breadcrumb', $breadcrumb);
                    ?>

                    <div class="row-fluid sortable">
                        <div class="box span12">
                            <div class="box-header" data-original-title>
                                <h2><i class="halflings-icon edit"></i><span class="break"></span><strong>Create Gallery</strong></h2>
                                <div class="box-icon">
                                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <?=$this->messagealert->alert("");?>
                                <form class="form-horizontal" name="form1" id="form1" method="post">
                                    <input name="gall_id" id="gall_id" type="hidden" value="<?=$gallid;?>">
                                    <input name="gall_order" id="gall_order" type="hidden" value="<?=$gallid;?>">
                                    <fieldset>
                                        <div class="row">
                                            <div class="control-group span12">
                                                <label class="control-label">Title</label>
                                                <div class="controls">
                                                    <input name="gall_title" id="gall_title" type="text"  style="width:90%;" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Status</label>
                                                <div class="controls">
                                                    <select name="gall_status" id="gall_status">
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="page-header"><strong>Photo</strong></p>
                                        <div class="row">
                                            <div class="control-group span12">
                                                <div class="controls">
                                                    <input type="file" name="Filedata" id="Filedata">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span12">
                                                <div class="controls thumblist">
                                                    <!-- Gallery List -->
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
                'uploader':'<?=site_url("admin/galleries/upload");?>',
                'formData':{'gall_id':'<?=$gallid;?>'},
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
                        var leng = $(".thumbnails").length;
                        if(leng===0)
                        {
                            $(".thumblist").prepend('<ul class="thumbnails"><li class="span4"><div class="thumbnail"><img src="'+res.src+'" alt=""><h3 class="text-center"><input type="text" name="photo_title[]" placeholder="Title"><button id="delete-img-btn" data-gallid="<?=$gallid;?>" data-src="'+res.imgname+'" type="button" class="btn btn-danger"><i class="halflings-icon trash"></i></button></h3><input type="hidden" name="photo_src[]" value="'+res.imgname+'"></div></li></ul>');
                        }else{
                            var liLeng = $(".thumbnails:first-child>li.span4").length;
                            if(liLeng<3)
                            {
                                $(".thumbnails:first-child").append('<li class="span4"><div class="thumbnail"><img src="'+res.src+'" alt=""><h3 class="text-center"><input type="text" name="photo_title[]" placeholder="Title"><button id="delete-img-btn" type="button" data-gallid="<?=$gallid;?>" data-src="'+res.imgname+'" class="btn btn-danger"><i class="halflings-icon trash"></i></button></h3><input type="hidden" name="photo_src[]" value="'+res.imgname+'"></div></li>');
                            }else{
                                $(".thumblist").prepend('<ul class="thumbnails"><li class="span4"><div class="thumbnail"><img src="'+res.src+'" alt=""><h3 class="text-center"><input type="text" name="photo_title[]" placeholder="Title"><button id="delete-img-btn" data-gallid="<?=$gallid;?>" data-src="'+res.imgname+'" type="button" class="btn btn-danger"><i class="halflings-icon trash"></i></button></h3><input type="hidden" name="photo_src[]" value="'+res.imgname+'"></div></li></ul>');
                            }
                        }
                    }
                },
                'onQueueComplete': function(queueData){
                    console.log(queueData);
                }
            });
            
            $(document).on("click","#delete-img-btn",function(){
                var _this = $(this);
                var gallid = $(this).attr("data-gallid");
                var photosrc = $(this).attr("data-src");
                
                console.log("deletePhotoByImg  gallid:"+gallid+" photo_src:"+photosrc);
                $.ajax({
                    url:'<?= site_url('admin/galleries/deletePhotoByImg'); ?>',
                    type:'post',
                    data:{'gall_id':gallid,'photo_src':photosrc},
                    success:function(response){
                        console.log(response);
                        _this.parent().parent().parent().remove();
                    }
                });
            });
        });
        </script>
    </body>
</html>