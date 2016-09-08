<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Notification <?php if ($label !='Add') : ?>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="<?php echo base_url(); ?>admin/notification/add">Add New</a> <?php endif; ?></h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>admin/dashboard/"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url(); ?>admin/notification">Notification</a></li>
      <li class="active"><?php echo @$label; ?></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
          <div class="box">
              <div class="box-header hidden">
                <h3 class="box-title">Notification</h3>
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
                        <input type="text" value="<?php echo @$row->Title; ?>" name="title" class="form-control required" placeholder="Title" />
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <?php echo $this->ckeditor->editor('content', @$row->Content);?>
                    </div>
                    <div class="form-group">
                        <label>Type Notification</label>
                        <select name="type_notification" class="form-control">
                          <option <?php echo @$row->Type_Notification == 0 ? 'selected' : ''; ?> value="0">System</option>
                          <option <?php echo @$row->Type_Notification == 1 ? 'selected' : ''; ?> value="1">Member</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                          <option <?php echo @$row->Status == 0 ? 'selected' : ''; ?> value="0">Enable</option>
                          <option <?php echo @$row->Status == 1 ? 'selected' : ''; ?> value="1">Disable</option>
                        </select>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-primary" type="submit">Save / Update</button>
      					<button class="btn" type="button" onclick="document.location.href='<?php echo $cancel; ?>'">Cancel</button>
                    </div>
                 </form>
              </div><!-- /.box-body -->
          </div><!-- /.box -->
      </div>
    </div>
  </section>
</div>