<?php
/*
  Author     : phanquanghiep
 */
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Block page &nbsp;&nbsp;&nbsp; <a href="<?php echo base_url("admin/advertises/add_block_page");?>" class="btn btn-primary" title="Thêm mới"><i class="fa fa-plus-circle"></i> Add new</a></h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url("admin/menu");?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="<?php echo base_url("admin/advertises");?>">Advertise</a></li>
          <li><strong>Block page</strong></li>
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
                                        <th>Tên</th>
                                        <th>Khối hiển thị</th>
                                        <th>Trang</th>
                                        <th>Giá</th>
                                        <th>Giảm giá</th>
                                        <th>Tổng giá</th>
                                        <th>Số lượng đăng ký</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php if (isset($record) && is_array($record)): ?>
                                    <?php
                                    foreach ($record as $key => $value) {
                                        $apbp = new Advertise_Promo_Block_Page();
                                        $result = $apbp->get_list_promo_by_block_page($value["ID"]);
                                        $sale = 0;
                                        $sale_text = '';
                                        if(isset($result) && $result!=null){
                                            foreach ($result as $item) {
                                                if($item['Unit'] == '%'){
                                                    $sale += $item['Sale'];
                                                    $sale_text .= $item['Sale'].' % <br>';
                                                }
                                            }
                                        }
                                        else{
                                            $sale_text = '0 %';
                                        }
                                        echo "<tr>";
                                        echo "<td>" . $value["Name"] . "</td>";
                                        echo "<td>" . $value["Title"] . "</td>";
                                        echo "<td>" . $value["Page"] . "</td>";
                                        echo "<td>" . number_format($value["Price"]) . " VNĐ</td>";
                                        echo "<td>" . $sale_text . "</td>";
                                        echo "<td>" . number_format( $value["Price"] - ($value["Price"]*$sale)/100 ) . " VNĐ</td>";
                                        echo "<td>" . $value["Number_Resgier"] . "</td>";
                                        echo'<td class="text-center">
                                                <a class="btn btn-success" data-type="edit" data-id ="' . $value["ID"] . '" href="' . base_url("admin/advertises/edit_block_page/" . $value["ID"]) . '"><i class="fa fa-edit"></i> </a>';
                                        if ($value["Disable"] == 0) {
                                            echo '<a class="btn btn-info" href="'.base_url("admin/advertises/disable/block_page/".$value["ID"]).'" data-type="disabled" data-id ="' . $value["ID"] . '" id="action-disabled"><i class="fa fa-lock"></i></a>';
                                        } else {
                                            echo '<a class="btn btn-info" href="'.base_url("admin/advertises/disable/block_page/".$value["ID"]).'" data-type="disabled" data-id ="' . $value["ID"] . '" id="action-disabled"><i class="fa fa-unlock"></i></a>';
                                        }
                                        echo '<a class="btn btn-danger" href="'.base_url("admin/advertises/delete/block_page/".$value["ID"]).'" data-type="delete" data-id ="' . $value["ID"] . '" id="action-delete"><i class="fa fa-trash-o"></i></a> 
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

