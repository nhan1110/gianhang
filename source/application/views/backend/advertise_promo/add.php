<script src="<?php echo skin_url(); ?>/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo skin_url(); ?>/admin/plugins/datepicker/datepicker3.css">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>&nbsp;</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url("admin") ?>">Dashboard</a></li>
            <li class="active"><a href="<?php echo base_url("admin/payment/upgrade");?>">Khuyến mãi quảng cáo</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content attribute-page">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-body">
                         <form method="post">
                            <?php if(isset($error) && $error) :?>
                                <div class="alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                    <?php echo @validation_errors();?>                     
                              </div>
                            <?php endif;?>
                            <div class="form-group">
                                <label>Giảm giá:</label>
                                <input type="number" class="form-control" name="Sale" value="<?php echo @$record["Sale"]; ?>">
                            </div>
                            <div class="form-group">
                                <label>Đơn vị:</label>
                                <select class="form-control" name="Unit">
                                    <option <?php if(@$record["Unit"] == '%'){ echo 'selected'; } ?> value="%">%</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label> Áp dụng:</label>
                                <select class="form-control" name="Apply">
                                    <option value="-1">Tất cả</option>
                                    <?php
                                        if(isset($advertise_block_page->ID) && $advertise_block_page->ID!=null){
                                            foreach ($advertise_block_page as $key => $value) {
                                                $selected = '';
                                                if(@$record["Apply"] == $value->ID){
                                                    $selected = 'selected';
                                                }
                                                echo '<option '.$selected.' value="'.$value->ID.'">'.$value->Name.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Ngày bắt đầu:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="Date_Start" value="<?php echo @$record["Date_Start"]; ?>" class="form-control pull-right datepicker">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label>Ngày kết thúc:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="Date_End" value="<?php echo @$record["Date_End"]; ?>" class="form-control pull-right datepicker">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label>Trạng thái:</label>
                                <select class="form-control" name="Status">
                                    <option <?php if(@$record["Status"] == 1){ echo 'selected'; } ?> value="1">Enable</option>
                                    <option <?php if(@$record["Status"] == 0){ echo 'selected'; } ?> value="0">Disable</option>
                                </select>
                            </div>
                            <div class="form-group text-right"><button type="submit" id="save-function" class="btn btn-primary">Save</button></div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.datepicker').datepicker({
           autoclose: true,
           format: 'yyyy-mm-dd'
        });
    });
</script>