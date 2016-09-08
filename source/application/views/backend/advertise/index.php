<?php
/*
  Author     : phanquanghiep
 */
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Advertise &nbsp;&nbsp;&nbsp; <a href="<?php echo base_url("admin/advertises/add");?>" class="btn btn-primary" title="Thêm mới"><i class="fa fa-plus-circle"></i> Add new</a></h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url("admin/menu");?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><strong>Advertise</strong></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Gói quảng cáo</th>
                                        <!--<th>Giá</th>-->
                                        <th>Tên công ty</th> 
                                        <th>Email</th>
                                        <th>Mô tả</th>
                                        <th>Điện thoại</th>
                                        <th style="min-width:80px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php if (isset($record) && is_array($record)): ?>
                                    <?php
                                    foreach ($record as $key => $value) {
                                        echo "<tr>";
                                        echo "<td>" . $value["Name"] . "</td>";
                                        //echo "<td>" . $value["Price"] . "</td>";
                                        echo "<td>" . $value["Company_Name"] . "</td>";
                                        echo "<td>" . $value["Email"] . "</td>";
                                        echo "<td>" . $value["Description"] . "</td>";
                                        echo "<td>" . $value["Phone"] . "</td>";
                                        echo'<td class="text-center">
                                                <a class="btn btn-success" data-type="edit" data-id ="' . $value["ID"] . '" href="' . base_url("admin/advertises/edit/" . $value["ID"]) . '"><i class="fa fa-edit"></i> </a>';
                                        if ($value["Disable"] == 0) {
                                            echo '<a class="btn btn-info" href="'.base_url("admin/advertises/disable/advertises/".$value["ID"]).'" data-type="disabled" data-id ="' . $value["ID"] . '" id="action-disabled"><i class="fa fa-lock"></i></a>';
                                        } else {
                                            echo '<a class="btn btn-info" href="'.base_url("admin/advertises/disable/advertises/".$value["ID"]).'" data-type="disabled" data-id ="' . $value["ID"] . '" id="action-disabled"><i class="fa fa-unlock"></i></a>';
                                        }
                                        echo '<a class="btn btn-danger" href="'.base_url("admin/advertises/delete/advertises/".$value["ID"]).'" data-type="delete" data-id ="' . $value["ID"] . '" id="action-delete"><i class="fa fa-trash-o"></i></a> 
                                        </td>';
                                        echo "</tr>";
                                    }
                                    ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        
                    </div><!-- /.box-body -->  
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<link rel="stylesheet" href="<?php echo skin_url(); ?>/admin/page/products.css">


