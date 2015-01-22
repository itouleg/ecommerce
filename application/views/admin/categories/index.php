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
                        array("title"=>"Shop"),
                        array("title"=>"Categories","url"=>"admin/categories"),
                    );
                    $this->load->library('breadcrumb',$breadcrumb);
                    
                    $gridview->render(array(
                        "title" => "Categories",
                        "span" => 12,
                        "toolbar" => array(
                            "setting" => false,
                            "minimize" => true,
                            "close" => false
                        ),
                        "model" => "categories f",
                        "params" => array(
                            'cols' => "f.cat_id,f.cat_name,f.cat_name_en,f.cat_order,f.cat_status,IFNULL(s.cat_id,'') as parent_id,IFNULL(s.cat_name,'') as parent_name",
                            'join' => array(
                                array(
                                    'table' => 'categories s',
                                    'condition'=>'s.cat_id = f.cat_parent',
                                    'refby' => 'left'
                                 )
                            )
                        ),
                        "columns" => array(
                            "cat_id" => "ID",
                            "cat_name" => "Name",
                            "cat_name_en" => "Name(EN)",
                            "parent_name" => "Main Category",
                            "cat_order" => array(
                                "header" => "Order",
                                "class" => "label",
                                "value" => "<input type=\"text\" class=\"order_input\" name=\"order[]\" cat_id=\"{cat_id}\" id=\"order_{cat_id}\" value=\"{cat_order}\" >"
                            ),
                            "cat_status" => array(
                                "header" => "Status",
                                "class" => "label",
                                "status" => array(
                                    '<span class="label center change-status cursor" value="0" id="{cat_id}">Inactive</span>',
                                    '<span class="label label-success center change-status cursor" value="1" id="{cat_id}">Active</span>',
                                    '<span class="label label-important center change-status cursor" value="2" id="{cat_id}">Banned</span>',
                                    '<span class="label label-warning center change-status cursor" value="3" id="{cat_id}">Pending</span>'
                                )
                            )
                        ),
                        "displayaction" => true,
                        "actions" => array(
                            "create" => array(
                                "url" => "categories/create"
                            ),
                            "edit" => array(
                                "url" => "categories/edit/{cat_id}"
                            ),
                            "delete" => array(
                                "url" => "categories/delete/{cat_id}"
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
                       var catid = $(this).attr("cat_id");
                       var order = $(this).val();
                       
                       $.ajax({
                           url:"<?=site_url('admin/categories/updateorder');?>",
                           type:"post",
                           data:{cat_id:catid,cat_order:order},
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
