<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Website Template <?php if($label !='Add' ) : ?>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="<?php echo base_url(); ?>admin/website_template/add">Add New</a> <?php endif; ?></h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>admin/dashboard/"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url(); ?>admin/website_template">Website Template</a></li>
      <li class="active"><?php echo @$label; ?></li>
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
                 <form action="<?php echo @$action; ?>" method="post">
                    <?php if(isset($message) && $message!=null ): ?>
                      <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                          <?php echo $message; ?>
                      </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" value="<?php echo @$website_templates->Title; ?>" name="title" class="form-control required" placeholder="Title">
                    </div>
                    <div class="form-group">
                        <label>Key</label>
                        <input type="text" value="<?php echo @$website_templates->Key; ?>" name="key" class="form-control required" placeholder="Type">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                          <option <?php echo @$website_templates->Status == 0 ? 'selected' : ''; ?> value="0">Enable</option>
                          <option <?php echo @$website_templates->Status == 1 ? 'selected' : ''; ?> value="1">Disable</option>
                        </select>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-primary" type="submit" >Save / Update</button>
                    </div>
                 </form>
              </div><!-- /.box-body -->
          </div><!-- /.box -->
      </div>
    </div>
  </section>
</div>