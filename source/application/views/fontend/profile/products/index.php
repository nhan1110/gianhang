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
            Dashboard
            <small>Version 2.0</small>
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
                <div class="box">
                    <div class="box-body">
                        <?php if (isset($product_record) && is_array($product_record)): ?>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Ảnh đại diện</th>
                                        <th>Loại hình giá</th>
                                        <th>Giá</th>
                                        <th>Giá đặc biệt</th>
                                        <th>Ngày bắt dặc biệt</th>
                                        <th>Ngày kết thúc đặc biệt</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($product_record as $key => $value) {
                                        echo "<tr>";
                                        echo "<td>" . $value["Name"] . "</td>";
                                        echo "<td class='text-center'><img style='width: 60px;' src ='" . $value["Path_Thumb"] . "'/></td>";
                                        $is_main = ($value["Is_Main"] == 0) ? "Liên Hệ" : "Giá cụ thể";
                                        echo "<td>" . $is_main . "</td>";
                                        echo "<td>" . $value["Price"] . "</td>";
                                        echo "<td>" . $value["Special_Price"] . "</td>";
                                        echo "<td>" . $value["Special_Start"] . "</td>";
                                        echo "<td>" . $value["Special_End"] . "</td>";
                                        echo'<td class="text-center">
                                                <a class="btn btn-success" data-type="edit" data-id ="' . $value["ID"] . '" href="' . base_url("admin/product/edit/" . $value["Slug"] . "/?category-type=" . $slug_cattype) . '"><i class="fa fa-edit"></i> </a>';
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
