<!DOCTYPE html>
<html lang="en">
    <head>
        <?= $this->load->view('admin/header'); ?>
        <style>
            .form-horizontal .controls{
                margin-top: 5px !important;
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
                    <a class="brand" href="<?= site_url('main'); ?>"><span><?= $this->config->item('version'); ?></span></a>

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
                                <?= $this->cuserdata->render(); ?>
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
                        array("title" => "Ingo")
                    );
                    $this->load->library('breadcrumb', $breadcrumb);
                    ?>

                    <div class="row-fluid sortable">
                        <div class="box span12">
                            <div class="box-header" data-original-title>
                                <h2><i class="halflings-icon search"></i><span class="break"></span><strong>Update Infomation</strong></h2>
                                <div class="box-icon">
                                    <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="box-content">
                                <form class="form-horizontal">
                                    <div class="row">
                                        <div class="control-group span12">
                                            <label class="control-label"><strong>E-Commerce V0.4</strong></label>
                                            <div class="controls">
                                                <ul>
                                                    <li><span class="label label-warning">(2014/12/29)</span> Remove Sortable in Gridview</li>
                                                    <li><span class="label label-info">(2014/12/29)</span> เพิ่มระบบจัดการบทความ</li>
                                                    <li><span class="label label-info">(2014/12/29)</span> เพิ่มระบบจัดการหมวดหมู่บทความ</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="control-group span12">
                                            <label class="control-label"><strong>E-Commerce V0.3</strong></label>
                                            <div class="controls">
                                                <ul>
                                                    <li><span class="label label-info">(2014/12/19)</span> เพิ่มภาษาให้กับ Page</li>
                                                    <li><span class="label label-success">(2014/12/15)</span> แก้ไข Directory ในการ Upload ไฟล์ของ Editor</li>
                                                    <li><span class="label label-success">(2014/12/13)</span> เพิ่ม Pages และ Banks</li>
                                                    <li><span class="label label-success">(2014/12/08)</span> เพิ่ม Permission ของ Menu</li>
                                                    <li><span class="label label-success">(2014/12/08)</span> เพิ่ม Permission ของ Action ใน Gridview</li>
                                                    <li><span class="label label-warning">(2014/12/02)</span> เพิ่มระบบ Login และ Permission </li>
                                                    <li><span class="label label-warning">(2014/12/01)</span> Update version ckeditor & ckfinder </li>
                                                    <li><span class="label label-warning">(2014/11/27)</span> แก้ไขฐานข้อมูลประเภทสมาชิก เพื่อรองรับส่วนลดสินค้า </li>
                                                    <li><span class="label label-warning">(2014/11/25)</span> แก้ไขเมนูให้สามารถเรียงลำดับตามการตั้งค่าใน Controller Component ได้ </li>
                                                    <li><span class="label label-warning">(2014/11/25)</span> แก้ไข Controller Component ให้สามารถจัดการการเรียงลำดับเมนูได้ </li>
                                                    <li><span class="label label-warning">(2014/11/25)</span> แก้ไข Controller Component ให้สามารถเลือกเมนูหลักได้ </li>
                                                    <li><span class="label label-warning">(2014/11/25)</span> ย้ายเมนู Member Review,Member Type,Members ไปไว้ภายใต้เมนู Customers </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="control-group span12">
                                            <label class="control-label"><strong>E-Commerce V0.2</strong></label>
                                            <div class="controls">
                                                <ul>
                                                    <li><span class="label label-success">(2014/11/23)</span> เพิ่ม Employee Component </li>
                                                    <li><span class="label label-success">(2014/11/24)</span> เพิ่ม Department Component </li>
                                                    <li><span class="label label-success">(2014/11/25)</span> เพิ่ม Member Type Component </li>
                                                    <li><span class="label label-success">(2014/11/25)</span> เพิ่ม Members Component </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="control-group span12">
                                            <label class="control-label"><strong>E-Commerce V0.1</strong></label>
                                            <div class="controls">
                                                <ul>
                                                    <li><span class="label label-success"> < (2014/11/23)</span> N/A </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="control-group span12">
                                            <label class="control-label"><strong>รายละเอียดที่ต้องทำ</strong></label>
                                            <div class="controls">
                                                <ul>
                                                    <li><span class="label label-success">ประเภทสมาชิก</span> ส่วนลดสินค้าตามประเภทสมาชิก (ไม่แยกประเภทสินค้า)</li>
                                                    <li><span class="label label-success">ประเภทสมาชิก</span> ส่วนลดสินค้าตามประเภทสมาชิก (แยกตามประเภทสินค้า)</li>
                                                    
                                                    <li><span class="label label-success">สมาชิก</span> ส่วนลดสินค้าตามประเภทสินค้า ของสมาชิกแต่ละคน</li>
                                                    <li><span class="label label-success">สมาชิก</span> Review สินค้า</li>
                                                    
                                                    <li><span class="label label-success">User</span> Profile</li>
                                                    
                                                    <li><span class="label label-success">สินค้า</span> ส่วนลดที่ตัวสินค้าสินค้า</li>
                                                    <li><span class="label label-success">สินค้า</span> ให้เลือกได้ว่า ถ้าตัวสินค้ามีส่วนลด แล้วส่วนลดสมาชิกจากลดจากราคาสินค้าที่ลดแล้ว(default) หรือราคาสินค้าเต็ม</li>
                                                    
                                                    <li><span class="label label-success">CMS</span> บทความ</li>
                                                    <li><span class="label label-success">CMS</span> เมนู</li>
                                                    <li><span class="label label-success">CMS</span> แบนเนอร์</li>
                                                    <li><span class="label label-success">CMS</span> Gallery</li>
                                                    <li><span class="label label-success">CMS</span> หมวดหมู่ Gallery</li>
                                                    <li><span class="label label-success">CMS</span> Slide</li>
                                                    
                                                    <li><span class="label label-success">Shops</span> Currency Exchange</li>
                                                    <li><span class="label label-success">Shops</span> Shipping Rates</li>
                                                    <li><span class="label label-success">Shops</span> Payment Gateway</li>
                                                    <li><span class="label label-success">Shops</span> Product Category</li>
                                                    <li><span class="label label-success">Shops</span> Product Types</li>
                                                    <li><span class="label label-success">Shops</span> Brands</li>
                                                    <li><span class="label label-success">Shops</span> Models</li>
                                                    <li><span class="label label-success">Shops</span> Quotations</li>
                                                    <li><span class="label label-success">Shops</span> Receive</li>
                                                    <li><span class="label label-success">Shops</span> Stock</li>
                                                    <li><span class="label label-success">Shops</span> Products</li>
                                                    <li><span class="label label-success">Shops</span> Customer Payment</li>
                                                    <li><span class="label label-success">Shops</span> Order Shipping</li>
                                                    <li><span class="label label-success">Shops</span> Orders</li>
                                                    
                                                    <li><span class="label label-success">Settings</span> On/off</li>
                                                    <li><span class="label label-success">Settings</span> Meta/Title/description</li>
                                                    <li><span class="label label-success">Settings</span> Map Lat/Long</li>
                                                    <li><span class="label label-success">Settings</span> Address</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
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

<?php

function getPermission($permission, $conid) {
    foreach ($permission as $per) {
        if ($per['con_id'] == $conid) {
            return $per;
        }
    }

    return null;
}
?>