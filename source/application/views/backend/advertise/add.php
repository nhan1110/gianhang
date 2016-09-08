<?php
/*
  Author     : phanquanghiep
 */
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Advertise add new &nbsp;&nbsp;&nbsp; </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url("admin/menu");?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="<?php echo base_url("admin/advertises");?>">Advertise</a></li>
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
                                <label>Gói quảng cáo*:</label>
                                <select name="block_page" class="form-control required">
                                    <?php if(isset($block_page) && !empty($block_page)):
                                        foreach ($block_page as $key => $value) {
                                            echo '<option value="'.$value["ID"].'">'.$value["Name"].'</option>';
                                        } ?>
                                    <?php endif;?>
                                </select>
                                <?php echo form_error('block_page', '<div class="error">', '</div>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Company name*:</label>
                                <input type="text" value="" name="company_name" class="form-control required" placeholder="Company name">
                                <?php echo form_error('company_name', '<div class="error">', '</div>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Email company*:</label>
                                <input type="email" value="" name="email" class="form-control" placeholder="Email company">
                                <?php echo form_error('email', '<div class="error">', '</div>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Logo company:</label>
                                <input type="file" value="" name="logo" class="form-control required" placeholder="Logo company" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label>Address company:</label>
                                <input type="text" value="" name="address" class="form-control" placeholder="Address company">
                            </div>
                            <div class="form-group">
                                <label>Phone company:</label>
                                <input type="text" value="" name="phone_number" class="form-control" placeholder="Phone company">
                            </div>
                            <div class="form-group">
                                <label>Web addresses company*:</label>
                                <input type="text" name="web_addresses" class="form-control" placeholder="Web addresses company">
                                <?php echo form_error('web_addresses', '<div class="error">', '</div>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Description*:</label>
                                <textarea name="description" class="form-control" placeholder="Description"></textarea>
                                <?php echo form_error('description', '<div class="error">', '</div>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Content:</label>
                                 <?php echo $this->ckeditor->editor('content',@$pages->Content);?>
                            </div>  
                            <div class="form-group">
                                <label>Start day:</label>
                                <input type="text" id="start_day" name="start_day" class="form-control" placeholder="Start day">
                            </div>
                            <div class="form-group">
                                <label>End day:</label>
                                <input type="text" id="end_day" name="end_day" class="form-control" placeholder="End day">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="0">Enable</option>
                                    <option value="1">Disable</option>
                                </select>
                            </div>
                            <div class="form-group text-right">
                                <button class="btn btn-primary" type="submit">Save / Update</button>
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


