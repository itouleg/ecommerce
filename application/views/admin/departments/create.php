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
                        array("title" => "Departments", "url" => "admin/departments"),
                        array("title" => "Create"),
                    );
                    $this->load->library('breadcrumb', $breadcrumb);
                    ?>

                    <div class="row-fluid sortable">
                        <div class="box span12">
                            <div class="box-header" data-original-title>
                                <h2><i class="halflings-icon edit"></i><span class="break"></span><strong>Create Department</strong></h2>
                                <div class="box-icon">
                                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <?=$this->messagealert->alert("");?>
                                <form class="form-horizontal" name="form1" id="form1" method="post">
                                    <fieldset>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Name</label>
                                                <div class="controls">
                                                    <input name="dep_name" id="dep_name" type="text" required>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Description</label>
                                                <div class="controls">
                                                    <input name="dep_desc" id="dep_desc" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Status</label>
                                                <div class="controls">
                                                    <select name="dep_status" id="dep_status">
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="control-group span11">
                                                <label class="control-label">Permissions</label>
                                                <div class="controls">
                                                    <table class="table table-striped table-bordered">
                                                        <tr>
                                                            <th class="center">Page</th>
                                                            <th class="center">View<br />
                                                            <input type="checkbox" class="chkall" value="view">
                                                            </th>
                                                            <th class="center">Create<br />
                                                            <input type="checkbox" class="chkall" value="create"></th>
                                                            <th class="center">Edit<br />
                                                            <input type="checkbox" class="chkall" value="edit"></th>
                                                            <th class="center">Delete<br />
                                                            <input type="checkbox" class="chkall" value="delete"></th>
                                                        </tr>
                                                        <?php
                                                        if(is_array($controller))
                                                        {
                                                            foreach($controller as $con)
                                                            {
                                                                echo '<tr>
                                                                    <td>'.$con['con_title'].' <input type="hidden" name="con_id[]" value="'.$con['con_id'].'"></td>
                                                                    <td class="center"><input type="checkbox" class="viewdata" name="view_'.$con['con_id'].'" value="1" checked></td>
                                                                    <td class="center"><input type="checkbox" class="createdata" name="create_'.$con['con_id'].'" value="1" checked></td>
                                                                    <td class="center"><input type="checkbox" class="editdata" name="edit_'.$con['con_id'].'" value="1" checked></td>
                                                                    <td class="center"><input type="checkbox" class="deletedata" name="delete_'.$con['con_id'].'" value="1" checked></td>
                                                                </tr>';
                                                            }
                                                        }
                                                        ?>
                                                        
                                                    </table>
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
            $(document).on("change",".chkall",function(){
               var _this = $(this);
               var func = _this.val();
               if(_this.prop("checked")==true)
               {
                   $("."+func+"data").each(function(){
                        $(this).parent("span").addClass("checked");
                        $(this).prop("checked",true);
                    });
               }else{
                   $("."+func+"data").each(function(){
                        $(this).parent("span").removeClass("checked");
                        $(this).prop("checked",false);
                    });
               }
            });
        });
        </script>
    </body>
</html>