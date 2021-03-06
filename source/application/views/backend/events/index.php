<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Events&nbsp;&nbsp;&nbsp; <a href="<?php echo base_url("admin/events/add");?>" class="btn btn-primary" title="Thêm mới"><i class="fa fa-plus-circle"></i> Thêm mới</a></h1>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url("admin") ?>">Dashboard</a></li>
            <li class="active">Events</a></li>
        </ol>
    </section>
    <!-- Main content -->
     <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="panel-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Stt</th>
                                        <th>Tiêu đề</th>
                                        <th style="min-width:80px;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($template) && $template!=null): ?>
                                    <?php foreach ($template as $key => $value) : ?>
                                    <tr>
                                        <td>
                                            <?php echo ($key+1); ?>
                                        </td>
                                        <td>
                                            <?php echo $value["Title"]; ?>
                                        </td>
                                        <td style="width:30px;">
                                            <a style="margin-right:5px;" href="<?php echo base_url(); ?>admin/events/edit/<?php echo $value["ID"]; ?>"><img src="<?php echo skin_url(); ?>/images/edit.png" alt="Edit"></a>
                                            <a onclick="return confirm('Bạn có muốn xóa không?');" href="<?php echo base_url(); ?>admin/events/delete/<?php echo $value["ID"]; ?>"><img src="<?php echo skin_url(); ?>/images/cross.png" alt="Edit"></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Stt</th>
                                        <th>Tiêu đề</th>
                                        <th style="min-width:80px;">Hành động</th>
                                    </tr>
                                </tfoot>
                            </table>
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