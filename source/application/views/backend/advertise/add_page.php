<?php
/*
  Author     : phanquanghiep
 */
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add page&nbsp;&nbsp;&nbsp; </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url("admin/menu");?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="<?php echo base_url("admin/advertises");?>">Advertise</a></li>
          <li><a href="<?php echo base_url("admin/advertises/page");?>">Page</a></li>
          <li><strong>Add new</strong></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Title*:</label>
                                <input type="text" value="<?php echo @$_POST['title'] ;?>" name="title" class="form-control required" placeholder="Title">
                                <?php echo form_error('title', '<div class="error">', '</div>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Description*:</label>
                                <textarea name="description" class="form-control" placeholder="Description"><?php echo @$_POST['description'] ;?></textarea>
                                <?php echo form_error('description', '<div class="error">', '</div>'); ?>
                            </div> 
                            <div class="form-group">
                                <label>Template*:</label>
                                 <?php echo $this->ckeditor->editor('template_view',@$_POST['template_view']);?>
                                <?php echo form_error('template_view', '<div class="error">', '</div>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="0">Enable</option>
                                    <option value="1">Disable</option>
                                </select>
                                <?php echo form_error('status', '<div class="error">', '</div>'); ?>
                            </div>
                            <div class="form-group text-right">
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                         </form>
                    </div><!-- /.box-body --> 
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<style type="text/css">
    textarea{min-height: 150px;}
    .error{color: red;}
</style>
<link rel="stylesheet" href="<?php echo skin_url(); ?>/admin/css/bootstrap-datepicker.min.css">
<script src="<?php echo skin_url() ?>/admin/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#start_day,#end_day").datepicker(
            {
                format: 'dd-mm-yyyy',
                ignoreReadonly: true,
                changeMonth: true,
                changeYear: true,
                yearRange: "1:c+10" // 1AD to 2013AD + 10
            }
        );
    });
</script>


