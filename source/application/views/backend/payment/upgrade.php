<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Gói thanh toán
           <a href="<?php echo base_url("admin/payment/upgrade/add");?>" class="btn btn-success" title="Thêm mới"><i class="fa fa-plus-circle"></i> Add new</a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url("admin") ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url("admin/payment");?>">Cấu hình thanh toán</a></li>
            <li class="active">Gói thanh toán</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content attribute-page">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                        <div class="panel-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Stt</th>
                                        <th>Số tháng</th>
                                        <th>Giá một tháng</th>
                                        <th>Mức giảm giá</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Tổng cộng</th>
                                        <th style="min-width:80px;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($upgrade) && $upgrade!=null): ?>
                                    <?php foreach ($upgrade as $key => $value) : ?>
                                    <tr>
                                        <td>
                                            <?php echo ($key+1); ?>
                                        </td>
                                        <td>
                                            <?php echo $value["Number_Month"]; ?>
                                        </td>
                                        <td>
                                            <?php echo number_format($value["Price_One_Month"]).' VND'; ?>
                                        </td>
                                        <td>
                                            <?php echo number_format($value["Sale"]).' '.$value["Unit"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $value["Date_Start"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $value["Date_End"]; ?>
                                        </td>
                                        
                                        <td>
                                            <?php 
                                                $total = ($value["Number_Month"] * $value["Price_One_Month"]);
                                                if($value["Unit"] == 'VND'){
                                                    $total = $total - $value["Sale"];
                                                }
                                                else if($value["Unit"] == '%'){
                                                    $total = $total - (($total*$value["Sale"])/100);
                                                }
                                                echo number_format($total).' VND';
                                            ?>
                                        </td>
                                        <td style="width:30px;">
                                            <a style="margin-right:5px;" href="<?php echo base_url(); ?>admin/payment/upgrade/edit/<?php echo $value["ID"]; ?>"><img src="<?php echo skin_url(); ?>/images/edit.png" alt="Edit"></a>
                                            <a onclick="return confirm('Bạn có muốn xóa không?');" href="<?php echo base_url(); ?>admin/payment/upgrade/delete/<?php echo $value["ID"]; ?>"><img src="<?php echo skin_url(); ?>/images/cross.png" alt="Edit"></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Stt</th>
                                        <th>Số tháng</th>
                                        <th>Giá một tháng</th>
                                        <th>Mức giảm giá</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Tổng cộng</th>
                                        <th style="min-width:80px;">Hành động</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->

</div>
<script>
      $(function () {
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
</script>