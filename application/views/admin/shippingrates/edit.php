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
                        array("title" => "Shop"),
                        array("title" => "Shipping Rates", "url" => "admin/shippingrates"),
                        array("title" => "Edit"),
                    );
                    $this->load->library('breadcrumb', $breadcrumb);
                    ?>

                    <div class="row-fluid sortable">
                        <div class="box span12">
                            <div class="box-header" data-original-title>
                                <h2><i class="halflings-icon edit"></i><span class="break"></span><strong>Edit Bank</strong></h2>
                                <div class="box-icon">
                                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <?=$this->messagealert->alert($alert['message'],$alert['type']);?>
                                <form class="form-horizontal" name="form1" id="form1" method="post" action="<?=site_url("admin/shippingrates/edit/".$shipping['ship_id']);?>">
                                    <input name="ship_id" id="ship_id" type="hidden" value="<?=$shipping['ship_id'];?>">
                                    <fieldset>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">From</label>
                                                <div class="controls">
                                                    <select name="ship_from" id="ship_from" required>
                                                        <option value="">-- Select Country --</option>
                                                        <?php
                                                        foreach($country as $con)
                                                        {
                                                            if($shipping['ship_from']==$con['country_id'])
                                                            {
                                                                echo '<option value="'.$con['country_id'].'" selected>'.$con['country_name'].'</option>';
                                                            }else{
                                                                echo '<option value="'.$con['country_id'].'">'.$con['country_name'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">To</label>
                                                <div class="controls">
                                                    <select name="ship_to" id="ship_to" required>
                                                        <option value="">-- Select Country --</option>
                                                        <?php
                                                        foreach($country as $con)
                                                        {
                                                            if($shipping['ship_to']==$con['country_id'])
                                                            {
                                                                echo '<option value="'.$con['country_id'].'" selected>'.$con['country_name'].'</option>';
                                                            }else{
                                                                echo '<option value="'.$con['country_id'].'">'.$con['country_name'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Type</label>
                                                <div class="controls">
                                                    <select name="ship_type" id="ship_type" required>
                                                        <option value="">-- Select Type --</option>
                                                        <?php
                                                        foreach($masstype as $type)
                                                        {
                                                            if($shipping['ship_type']==$type['mass_id'])
                                                            {
                                                                echo '<option value="'.$type['mass_id'].'" selected>'.$type['mass_name'].'</option>';
                                                            }else{
                                                                echo '<option value="'.$type['mass_id'].'">'.$type['mass_name'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">By</label>
                                                <div class="controls">
                                                    <select name="ship_by" id="ship_by" required>
                                                        <option value="">-- Select By --</option>
                                                        <?php
                                                        foreach($massby as $by)
                                                        {
                                                            if($shipping['ship_by']==$by['massby_id'])
                                                            {
                                                                echo '<option value="'.$by['massby_id'].'" selected>'.$by['massby_name'].'</option>';
                                                            }else{
                                                                echo '<option value="'.$by['massby_id'].'">'.$by['massby_name'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Weight From(g.)</label>
                                                <div class="controls">
                                                    <input type="text" name="ship_weightfrom" id="ship_weightfrom" placeholder="0.00" value="<?=$shipping['ship_weightfrom'];?>" required>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Weight To(g.)</label>
                                                <div class="controls">
                                                    <input type="text" name="ship_weightto" id="ship_weightto" placeholder="0.00" value="<?=$shipping['ship_weightto'];?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Price(THB)/g.</label>
                                                <div class="controls">
                                                    <input type="text" name="ship_price" id="ship_price" placeholder="0.00" value="<?=$shipping['ship_price'];?>" required>
                                                </div>
                                            </div>
                                            <div class="control-group span6">
                                                <label class="control-label">Price(CNY)/g.</label>
                                                <div class="controls">
                                                    <input type="text" name="ship_price_yuan" id="ship_price_yuan" placeholder="0.00" value="<?=$shipping['ship_price_yuan'];?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="control-group span6">
                                                <label class="control-label">Status</label>
                                                <div class="controls">
                                                    <select name="ship_status" id="ship_status">
                                                        <option value="1" <?=$shipping['ship_status']==1?"selected":"";?> >Active</option>
                                                        <option value="0" <?=$shipping['ship_status']==0?"selected":"";?> >Inactive</option>
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