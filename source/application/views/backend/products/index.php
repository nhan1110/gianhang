<?php
/*
  Author     : phanquanghiep
 */
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo @$title_curent;?>
            <a href="<?php echo base_url("admin/product/add");?>" class="btn btn-success" title="Thêm mới"><i class="fa fa-plus-circle"></i> Thêm mới</a>
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
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="box-search-product">
                        <form method="GET" id="search-product-form">
                        <div class="row">
                            <div class="col-md-8 right">
                                <div class="form-group row text-right">
                                    <div class="col-md-5">
                                        <select name="category-type" id="category-type" class="form-control">
                                            <option value="">-- Loại Hình Của Sản Phẩm --</option>                                    
                                            <?php if(isset($all_cat_type)){
                                                echo $all_cat_type;
                                            }?>
                                        </select>     
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id = "product-name" value="<?php echo @$this->input->get("product-name");?>" name="product-name" placeholder="Search product name" />
                                    </div>
                                    <div class="col-md-2"><input type="submit" class="btn btn-primary" value="Search"></div>
                                </div>
                            </div>
                        </div>
                        </form>
                        </div>
                        <?php if (isset($product_record) && is_array($product_record)): ?>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="min-width: 100px;">Tên sản phẩm</th>
                                        <th style="min-width: 100px;">Ảnh đại diện</th>
                                        <th style="min-width: 100px;">Mô tả</th>
                                        <th style="min-width: 100px;">Loại hình giá</th>
                                        <th style="min-width: 100px;">Giá</th>
                                        <th style="min-width: 100px;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($product_record as $key => $value) {
                                        echo "<tr>";
                                        echo "<td>" . $value["Name"] . "</td>";
                                        echo "<td class='text-center'><img style='width: 60px;' src ='" . $value["Path_Thumb"] . "'/></td>";
                                        echo "<td>" . $value["Description"] . "</td>";
                                        $is_main = ($value["Is_Main"] == 0) ? "Liên Hệ" : "Giá cụ thể";
                                        echo "<td>" . $is_main . "</td>";
                                        echo "<td>" . $value["Price"] . "</td>";
                                        echo'<td class="text-center">
                                                <a class="btn btn-success" data-type="edit" data-id ="' . $value["ID"] . '" href="' . base_url("admin/product/edit/" . $value["Slug"] . "/?category-type=" . $value["Slug_Type"]) . '"><i class="fa fa-edit"></i> </a>';
                                        if ($value["Disable"] == 0) {
                                            echo '<a class="btn btn-info" href="#" data-type="disabled" data-id ="' . $value["ID"] . '" id="action-disabled"><i class="fa fa-lock"></i></a>';
                                        } else {
                                            echo '<a class="btn btn-info" href="#" data-type="disabled" data-id ="' . $value["ID"] . '" id="action-disabled"><i class="fa fa-unlock"></i></a>';
                                        }
                                        echo '<a class="btn btn-danger" href="#" data-type="delete" data-id ="' . $value["ID"] . '" id="action-delete"><i class="fa fa-trash-o"></i></a> 
                                        </td>';
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>

                            </table>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-md-12 text-right"><?php echo $this->pagination->create_links();?></div>
                        </div>
                    </div><!-- /.box-body --> 
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<link rel="stylesheet" href="<?php echo skin_url(); ?>/admin/page/products.css">
<script src="<?php echo skin_url() ?>/admin/js/product.js"></script>
<script>
    $(document).ready(function () {
        $('#content').summernote({
            height: 300
        });
    });
</script>
<script type="text/javascript">
  $(document).on("change","#category-type",function(){
    $("#search-product-form").submit();
  });
</script>
