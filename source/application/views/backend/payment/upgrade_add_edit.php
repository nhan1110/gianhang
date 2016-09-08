<script src="<?php echo skin_url(); ?>/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo skin_url(); ?>/admin/plugins/datepicker/datepicker3.css">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Thêm mới
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url("admin") ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url("admin/payment");?>">Cấu hình thanh toán</a></li>
            <li><a href="<?php echo base_url("admin/payment/upgrade");?>">Gói thanh toán</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content attribute-page">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                        <div class="panel-body">
                         <form method="post">
                         <?php if(@$error) :?>
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                <?php echo @validation_errors();?>                     
                          </div>
                        <?php endif;?>
                            <div class="form-group">
                                <label for="from-name">Số tháng*: </label>
                                <input type="number" max="12" min="1" data-required="true" data-validate="true" class="form-control" id="from-name" name="Number_Month" value="<?php echo @$record["Number_Month"] ?>" placeholder="Số tháng">
                            </div>
                            <div class="form-group">
                                <label for="from-mail">Giá một tháng*: </label>
                                <input type="number" min="1" data-required="true" data-validate="true" name="Price_One_Month" class="form-control" id="from-mail" value="<?php echo @$record["Price_One_Month"] ?>" placeholder="Giá một tháng">
                            </div>
                            <div class="form-group">
                                <label>Mô tả:</label>
                                <textarea name="Description" class="form-control" placeholder="Mô tả"><?php echo @$record["Description"] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Giảm giá:</label>
                                <input type="number" class="form-control" name="Sale" value="<?php echo @$record["Sale"] ?>">
                            </div>
                            <div class="form-group">
                                <label>Đơn vị:</label>
                                <select class="form-control" name="Unit">
                                    <option value="">Chọn đơn vị</option>
                                    <option <?php if(@$record["Unit"] == 'VND'){ echo 'selected'; } ?> value="VND">VND</option>
                                    <option <?php if(@$record["Unit"] == '%'){ echo 'selected'; } ?> value="%">%</option>
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