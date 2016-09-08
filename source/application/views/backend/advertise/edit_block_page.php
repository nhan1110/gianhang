<?php
/*
  Author     : phanquanghiep
 */
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add block page&nbsp;&nbsp;&nbsp; <a href="<?php echo base_url("admin/advertises/add_block_page");?>" class="btn btn-primary" title="Thêm mới"><i class="fa fa-plus-circle"></i> Add new</a></h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url("admin/menu");?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="<?php echo base_url("admin/advertises");?>">Advertise</a></li>
          <li><a href="<?php echo base_url("admin/advertises/block_page");?>">Block page</a></li>
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
                                <label>Name*:</label>
                                <input type="text"  value="<?php echo @$record["block_page"]["Name"] ;?>" name="name" class="form-control required" placeholder="Name">
                                <?php echo form_error('name', '<div class="error">', '</div>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Block</label>
                                <select name="block" class="form-control">
                                    <?php if(isset($record["block"]) && !empty($record["block"])){
                                        foreach ($record["block"] as $key => $value) {
                                            if($value["ID"] == $record["block_page"]["Block_ID"]){
                                                echo '<option value="'.$value["ID"].'" selected>'.$value["Title"].'</option>';
                                            }else{
                                                 echo '<option value="'.$value["ID"].'">'.$value["Title"].'</option>';
                                            }
                                            
                                        }
                                    }?>
                                </select>
                                <?php echo form_error('block', '<div class="error">', '</div>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Page</label>
                                <select name="page" class="form-control">
                                    <?php if(isset($record["page"]) && !empty($record["page"])){
                                        foreach ($record["page"] as $key => $value) {
                                            if($value["ID"] == $record["block_page"]["Page_ID"]){
                                                echo '<option value="'.$value["ID"].'" selected>'.$value["Page"].'</option>';
                                            }else{
                                                 echo '<option value="'.$value["ID"].'">'.$value["Page"].'</option>';
                                            }
                                        }
                                    }?>
                                </select>
                                <?php echo form_error('page', '<div class="error">', '</div>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Description:</label>
                                <textarea name="description" class="form-control" placeholder="Description"><?php echo @$record["block_page"]['Description'] ;?></textarea>
                            </div> 
                            <div class="form-group">
                                <label>Price*:</label>
                                <input type="number" value="<?php echo @$record["block_page"]['Price'] ;?>" name="price" class="form-control required" placeholder="Price">
                                <?php echo form_error('price', '<div class="error">', '</div>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Number resgier*:</label>
                                <input type="number" min = "1" value="<?php echo @$record["block_page"]['Number_Resgier'] ;?>" name="number_resgier" class="form-control required" placeholder="Number resgier">
                                <?php echo form_error('number_resgier', '<div class="error">', '</div>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <?php if(isset($record["block_page"]["Disable"]) && $record["block_page"]["Disable"] == "0"):?>
                                        <option value="0" selected>Enable</option>
                                        <option value="1">Disable</option>
                                    <?php else:?>
                                        <option value="0">Enable</option>
                                        <option value="1" selected>Disable</option>
                                    <?php endif;?>    
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


