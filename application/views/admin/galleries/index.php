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
                        array("title"=>"Gallery"),
                    );
                    $this->load->library('breadcrumb',$breadcrumb);
                    
                    $gridview->render(array(
                        "title" => "Gallery",
                        "span" => 12,
                        "toolbar" => array(
                            "setting" => false,
                            "minimize" => true,
                            "close" => false
                        ),
                        "model" => "galleries",
                        "params" => NULL,
                        "columns" => array(
                            "gall_order" => array(
                                "header" => "Order",
                                "class" => "label",
                                "value" => "<input type=\"text\" class=\"order_input\" name=\"order[]\" gall_id=\"{gall_id}\" id=\"order_{gall_id}\" value=\"{gall_order}\" >"
                            ),
                            "gall_title" => "Title",
                            "gall_create" => "Create",
                            "gall_status" => array(
                                "header" => "Status",
                                "class" => "label",
                                "status" => array(
                                    '<span class="label center change-status cursor" value="0" id="{gall_id}">Inactive</span>',
                                    '<span class="label label-success center change-status cursor" value="1" id="{gall_id}">Active</span>',
                                    '<span class="label label-important center change-status cursor" value="2" id="{gall_id}">Banned</span>',
                                    '<span class="label label-warning center change-status cursor" value="3" id="{gall_id}">Pending</span>'
                                )
                            )
                        ),
                        "displayaction" => true,
                        "actions" => array(
                            "create" => array(
                                "url" => "galleries/create"
                            ),
                            "edit" => array(
                                "url" => "galleries/edit/{gall_id}"
                            ),
                            "delete" => array(
                                "url" => "galleries/delete/{gall_id}"
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
                       var gallid = $(this).attr("gall_id");
                       var order = $(this).val();
                       
                       $.ajax({
                           url:"<?=site_url('admin/galleries/updateorder');?>",
                           type:"post",
                           data:{gall_id:gallid,gall_order:order},
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
