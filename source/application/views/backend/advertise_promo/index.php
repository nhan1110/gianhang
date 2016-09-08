<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Khuyến mãi quảng cáo
           <a href="<?php echo base_url("admin/advertise_promo/add");?>" class="btn btn-success" title="Thêm mới"><i class="fa fa-plus-circle"></i> Add new</a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url("admin") ?>">Dashboard</a></li>
            <li class="active"><a href="<?php echo base_url("admin/advertise_promo");?>">Khuyến mãi quảng cáo</a></li>
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
                                        <th>Mức giảm giá</th>
                                        <th>Áp dụng</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Trạng thái</th>
                                        <th style="min-width:80px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($advertise_promo) && $advertise_promo!=null): ?>
                                        <?php foreach ($advertise_promo as $key => $value) : ?>
                                        <tr>
                                            <td>
                                                <?php echo ($key+1); ?>
                                            </td>
                                            <td>
                                                <?php echo number_format($value->Sale).' '.@$value->Unit; ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    if(@$value->Apply == -1){
                                                        echo 'Tất cả';
                                                    }
                                                    else{
                                                        $advertise_block_page_id = @$value->Apply;
                                                        $advertise_block_page = new Advertise_Block_Page();
                                                        $advertise_block_page->where(array('ID' => $advertise_block_page_id))->get(1);
                                                        echo @$advertise_block_page->Name;
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo @$value->Date_Start; ?>
                                            </td>
                                            <td>
                                                <?php echo @$value->Date_End; ?>
                                            </td>
                                            <td>
                                                <?php echo @$value->Status == 1 ? 'Enable' : 'Disable'; ?>
                                            </td>
                                            <td style="width:30px;">
                                                <a style="margin-right:5px;" href="<?php echo base_url(); ?>admin/advertise_promo/edit/<?php echo $value->ID; ?>"><img src="<?php echo skin_url(); ?>/images/edit.png" alt="Edit"></a>
                                                <a onclick="return confirm('Bạn có muốn xóa không?');" href="<?php echo base_url(); ?>admin/advertise_promo/delete/<?php echo $value->ID; ?>"><img src="<?php echo skin_url(); ?>/images/cross.png" alt="Edit"></a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Stt</th>
                                        <th>Mức giảm giá</th>
                                        <th>Áp dụng</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Trạng thái</th>
                                        <th style="min-width:80px;"></th>
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