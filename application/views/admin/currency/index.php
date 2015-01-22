<!DOCTYPE html>
<html lang="en">
    <head>
        <?=$this->load->view('admin/header');?>
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
                    <a class="brand" href="<?=site_url('main');?>"><span><?=$this->config->item('version');?></span></a>

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
                        array("title"=>"Currency Exchange"),
                    );
                    $this->load->library('breadcrumb',$breadcrumb);
                    ?>
                    <div class="row-fluid">
                        <div class="box span12">
                            <div class="box-header" data-original-title="">
                                <h2><i class="halflings-icon th-large"></i><span class="break"></span><strong>Currency Exchange</strong></h2>
                                <div class="box-icon">
                                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <form class="form-horizontal">
                                <fieldset>
                                    <div class="row">
                                        <div class="control-group span6">
                                            <label class="control-label">Currency</label>
                                            <div class="controls">
                                                <select name="currency" id="currency">
                                                    <?php                  
                                                    foreach($currency as $cur)
                                                    {
                                                        echo '<option value="'.$cur['currency_rate'].'">('.$cur['currency_symbol'].')'.$cur['currency_name'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group span6">
                                            <label class="control-label">Price</label>
                                            <div class="controls">
                                                <input type="text" name="price" id="price" placeholder="0.00" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="control-group span6">
                                            <label class="control-label">THB</label>
                                            <div class="controls">
                                                <input type="text" name="THB" id="THB" placeholder="0.00" readonly>
                                            </div>
                                        </div>
                                        <div class="control-group span6">
                                            <div class="controls">
                                                <button id="calc-btn" type="button" class="btn btn-primary">Calculate</button>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                    $gridview->render(array(
                        "title" => "Currency Exchange",
                        "span" => 12,
                        "toolbar" => array(
                            "setting" => false,
                            "minimize" => true,
                            "close" => false
                        ),
                        "model" => "currency",
                        "params" => NULL,
                        "columns" => array(
                            "currency_name" => "Currency",
                            "currency_code" => "Code",
                            "currency_rate" => "Rate",
                            "currency_symbol" => "Symbols",
                            "currency_status" => array(
                                "header" => "Status",
                                "class" => "label",
                                "status" => array(
                                    '<span class="label center change-status cursor" value="0" id="{currency_id}">Inactive</span>',
                                    '<span class="label label-success center change-status cursor" value="1" id="{currency_id}">Active</span>',
                                    '<span class="label label-important center change-status cursor" value="2" id="{currency_id}">Banned</span>',
                                    '<span class="label label-warning center change-status cursor" value="3" id="{currency_id}">Pending</span>'
                                )
                            )
                        ),
                        "displayaction" => true,
                        "actions" => array(
                            "create" => array(
                                "url" => "currency/create"
                            ),
                            "edit" => array(
                                "url" => "currency/edit/{currency_id}"
                            ),
                            "delete" => array(
                                "url" => "currency/delete/{currency_id}"
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
               $("#calc-btn").click(function(){
                   var rate = parseFloat($("#currency option:selected").val());
                   var price = parseFloat($("#price").val());
                   $("#THB").val(rate*price);
               }); 
            });
        </script>
    </body>
</html>
