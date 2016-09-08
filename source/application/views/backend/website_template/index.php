<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Website Template &nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="<?php echo base_url(); ?>admin/website_template/add">Add New</a></h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>admin/dashboard/"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Website Template</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
          <div class="box">
              <div class="box-header hidden">
                <h3 class="box-title">Hover Data Table</h3>
              </div><!-- /.box-header -->
              <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Stt</th>
                      <th>Title</th>
                      <th>Key</th>
                      <th>Date Create</th>
                      <th>Status</th>
                      <th style="width:30px;">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php if(isset($website_templates) && $website_templates!=null): ?>
                  	  <?php foreach ($website_templates as $key => $value) : ?>
	                    <tr>
	                      <td><?php echo ($key+1); ?></td>
	                      <td><?php echo $value->Title; ?></td>
	                      <th><?php echo $value->Key; ?></th>
                        <th><?php echo $value->Date_Create; ?></th>
	                      <td><?php echo $value->Status == 0 ? 'Enable' : 'Disable'; ?></td>
	                      <td style="width:30px;">
	                      	 <a style="margin-right:5px;" href="<?php echo base_url(); ?>admin/website_template/edit/<?php echo $value->ID; ?>"><img src="<?php echo skin_url(); ?>/images/edit.png" alt="Edit"></a>
	                      	 <a onclick="return confirm('Bạn có muốn xóa không?');" href="<?php echo base_url(); ?>admin/website_template/delete/<?php echo $value->ID; ?>"><img src="<?php echo skin_url(); ?>/images/cross.png" alt="Edit"></a>
	                      </td>
	                    </tr>
	                  <?php endforeach; ?>
	                <?php endif; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Stt</th>
                      <th>Title</th>
                      <th>Key</th>
                      <th>Date Create</th>
                      <th>Status</th>
                      <th style="width:30px;">Actions</th>
                    </tr>
                  </tfoot>
                </table>
              </div><!-- /.box-body -->
          </div><!-- /.box -->
      </div>
    </div>
  </section>
</div>
<!-- DataTables -->
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