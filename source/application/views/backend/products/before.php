<?php
/*
  Created on : Feb 16, 2016, 10:00:18 PM
  Author     : phanquanghiep
 */
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo @$title_curent;?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url("admin") ?>">Dashboard</a></li>
            <?php
            if (isset($title_curent) && $title_curent != "")
                echo '<li class="active">' . @$title_curent . '</li>';
            ?>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <div class="row"> 
                            <div id="product" class="main">
                                <div class="col-md-12">
                                    <h4>Chọn Danh Mục Của Sản Phẩm</h4>
                                    <hr>
                                </div> 
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="cented col-xs-12 col-md-7">
                                            <form method="get">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 control-label" for="formGroupInputSmall">Loại Hình Của Sản Phẩm *</label>
                                                    <div class="col-sm-8">
                                                        <div id="box-category-type">
                                                        <select name="category-type" class="form-control">
                                                            <option value="default">-- Loại Hình Của Sản Phẩm --</option>
                                                            <?php
                                                            if (isset($all_cat_type)):
                                                                echo $all_cat_type;
                                                            endif;
                                                            ?>
                                                        </select>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12 text-right">
                                                        <button type="submit" class="btn btn-primary">Tiếp Tục</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<link rel="stylesheet" href="<?php echo skin_url(); ?>/admin/page/products.css">
<link href="<?php echo skin_url() ?>/js/summernote/summernote.css" rel="stylesheet">
<script src="<?php echo skin_url() ?>/js/summernote/summernote.js"></script>
<script>
    $(document).ready(function () {
        $('#content').summernote({
            height: 300
        });
    });
</script>