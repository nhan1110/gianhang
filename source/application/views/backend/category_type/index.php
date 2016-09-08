<?php
/*
  Created on : Feb 16, 2016, 10:00:18 PM
  Author     : phanquanghiep
 */
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="category-type-page">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo @$title_curent;?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <?php
            if (isset($title_curent) && $title_curent != "")
                echo '<li class="active">' . @$title_curent . '</li>';
            ?>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Danh sách nhóm loại sản phẩm</strong></div>
                    <div class="panel-body">
                        <div id="box-tree-category-type" class="tree_ui">
                            <?php echo @$tree_type;?>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default" for-top=".main-header">
                    <div class="panel-heading"><strong>Thêm nhóm loại sản phẩm</strong></div>
                    <div class="panel-body">
                        <div id="box-main">
                            <form class="form-add-category-type" action="<?php echo base_url('admin/categories_type/add'); ?>" method="post" enctype="multipart/form-data">
                                <div class="box-add-attribute-group">
                                    <div id="box-add">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <p>Tên Loại sản phẩm:</p>
                                                <input type="text" name="name" id="name-cattype-group" class="form-control not-null" data-add="attribute-group" placeholder="Tên nhóm" autocomplete="on">
                                            </div>
                                        </div> 
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <p>Chon loại sản phẩm cha:</p>
                                                <select id="root-category-type" name="root" class="form-control">
                                                    <option class="default" value="0" selected="">—— Chọn Danh Mục Cha ——</option>
                                                    <?php echo @$select_root; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                              <label>Icon</label>
                                              <input type="text" name="icon" class="form-control" placeholder="Icon">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                              <label>Ảnh đại diện</label>
                                              <input type="file" name="images" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="form-group row"> 
                                            <div class="col-md-12 text-right"><button id="save-cattype-group" class="btn btn-success relative controller" disabled>Khởi Tạo</button></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div id="modal_edit_cat_type" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <input type="hidden" id="action" value="">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title"><strong>Edit attribute set</strong></h3>
            </div>
            <div class="modal-body">
                <form class="form-edit-category-type" action="<?php echo base_url(); ?>admin/categories_type/un_set_ag" method="post" enctype="multipart/form-data">
                    <div class="list-attr">
                        <h4><b>List attribute</b></h4>
                        <div id="list-gr-attr"></div>
                    </div>
                    <div class="form-group">
                        <label>Name*:</label>
                        <input type="text" value="" name="name" id="name-cat" class="form-control required" placeholder="Name">
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                          <label>Icon</label>
                          <input type="text" name="icon" class="form-control" id="icon" placeholder="Icon">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ảnh đại diện:</label>
                        <img src="" class="img-responsive images-view" style="display:none;max-width: 200px;margin-bottom: 10px;">
                        <input type="file" name="images" accept="image/*">
                    </div>
                </form>
            </div>
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success relative" id="edit_attribute_set">Ok</button>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo skin_url(); ?>/admin/page/products.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("skins/admin/page/category-type.css");?>">
<script src="<?php echo base_url("skins/js/jquery-ui.js")?>"></script>
<script src="<?php echo skin_url() ?>/admin/js/attribute.js"></script>
<script type="text/javascript" src="<?php echo base_url("skins/admin/js/category_type.js");?>"></script>

