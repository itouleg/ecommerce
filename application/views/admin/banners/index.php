<!DOCTYPE html>
<html lang="en">
    <head>
        <?=$this->load->view('admin/header');?>
        <style>
            .order_input{
                width:50px;
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
                        array("title"=>"CMS"),
                        array("title"=>"Banners"),
                    );
                    $this->load->library('breadcrumb',$breadcrumb);
                    
                    $gridview->render(array(
                        "title" => "Banners",
                        "span" => 12,
                        "toolbar" => array(
                            "setting" => false,
                            "minimize" => true,
                            "close" => false
                        ),
                        "model" => "banners",
                        "params" => NULL,
                        "columns" => array(
                            "banner_order" => array(
                                "header" => "Order",
                                "class" => "label",
                                "value" => "<input type=\"text\" class=\"order_input\" name=\"order[]\" banner_id=\"{banner_id}\" id=\"order_{banner_id}\" value=\"{banner_order}\" >"
                            ),
                            "banner_title" => "Title",
                            "banner_src" => array(
                                "header" => "Pic",
                                "class" => "label",
                                "value" => '<img src="/images/banners/{banner_src}" style="height:60px;">'
                            ),
                            "banner_link" => "URL",
                            "banner_create" => "Create",
                            "banner_startdate" => "Start",
                            "banner_expiredate" => "Expire",
                            "banner_status" => array(
                                "header" => "Status",
                                "class" => "label",
                                "status" => array(
                                    '<span class="label center change-status cursor" value="0" id="{banner_id}">Inactive</span>',
                                    '<span class="label label-success center change-status cursor" value="1" id="{banner_id}">Active</span>',
                                    '<span class="label label-important center change-status cursor" value="2" id="{banner_id}">Banned</span>',
                                    '<span class="label label-warning center change-status cursor" value="3" id="{banner_id}">Pending</span>'
                                )
                            )
                        ),
                        "displayaction" => true,
                        "actions" => array(
                            "create" => array(
                                "url" => "banners/create"
                            ),
                            "edit" => array(
                                "url" => "banners/edit/{banner_id}"
                            ),
                            "delete" => array(
                                "url" => "banners/delete/{banner_id}"
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
        <script>
            $(function(){
               $(".order_input").keyup(function(event){
                   if(event.keyCode===13)
                   {
                       var bannerid = $(this).attr("banner_id");
                       var order = $(this).val();
                       
                       $.ajax({
                           url:"<?=site_url('admin/banners/updateorder');?>",
                           type:"post",
                           data:{banner_id:bannerid,banner_order:order},
                           success:function(response){
                               var res = $.parseJSON(response);
                               if(res.status===true)
                               {
                                   window.location.href="";
                               }
                           }
                       });
                   }
               }) ;
            });
        </script>
    </body>
</html>
