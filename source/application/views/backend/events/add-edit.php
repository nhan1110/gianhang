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
            <li><a href="<?php echo base_url("admin/events");?>">Events</a></li>
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
                                <label for="from-name">Tiêu đề*: </label>
                                <input type="text" class="form-control" id="from-name" name="Title" value="<?php echo @$record["Title"] ?>" placeholder="Tiêu đề" required>
                            </div>
                            <div class="form-group">
                                <label>Mô tả:</label>
                                <textarea name="Description" class="form-control" placeholder="Mô tả"><?php echo @$record["Description"] ?></textarea>
                            </div> 
                            <div class="form-group">
                                <label>Giao diện thông báo(content):</label>
                                <?php echo $this->ckeditor->editor('Content',@$record["Content"]);?>
                            </div>  
                            <div class="form-group">
                                <label>Biểu mẫu đăng ký*:</label>
                                <select class="form-control" name="Popup_ID" required>
                                     <?php if(isset($popup_template) && is_array($popup_template)):
                                   		foreach ($popup_template as $key => $value) { 
                                   			if(@$record["Popup_ID"] == $value["ID"]) 
                                                echo "<option value='".$value["ID"]."' selected>".$value["Title"]."</option>";
                                            else
                                                echo "<option value='".$value["ID"]."'>".$value["Title"]."</option>";
                                 		}
                                    endif; ?>
                                </select>
                            </div>   
                            <div class="form-group">
                                <label>Mẫu email template gửi đi*:</label>
                                <select class="form-control" name="Email_ID" required>
                                   <?php if(isset($email_template) && is_array($email_template)):
                                   		foreach ($email_template as $key => $value) {
                                            if(@$record["Email_ID"] == $value["ID"]) 
                                   			    echo "<option value='".$value["ID"]."' selected>".$value["Title"]."</option>";
                                            else
                                                echo "<option value='".$value["ID"]."'>".$value["Title"]."</option>";
                                 		}
                                    endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Ngày bắt đầu*:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="Start_Day" value="<?php echo @$record["Start_Day"]; ?>" class="form-control pull-right datepicker" required>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label>Ngày kết thúc*:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="End_Day" value="<?php echo @$record["End_Day"]; ?>" class="form-control pull-right datepicker" required>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label for="from-name">Thời gian hiển thị (đơn vị phút, mặc định 1 phút): </label>
                                <input type="number" min="1" class="form-control" id="from-name" name="Time_Display" value="<?php echo (isset($record["Time_Display"])) ? $record["Time_Display"] : "1"; ?>" placeholder="Thời gian hiển thị" required>
                            </div>
                            <div class="form-group">
                                <label for="from-name">Thời gian xóa cookie (đơn vị ngày, mặc định 1 ngày): </label>
                                <input type="number" min="1" class="form-control" id="from-name" name="Set_Cookie" value="<?php echo (isset($record["Set_Cookie"])) ? $record["Set_Cookie"] : "1"; ?>" placeholder="Thời gian xóa cookie" required>
                            </div>
                            <div class="form-group">
                                <label>Chỉ dành cho:</label>
                                <?php $w = ["0" => "Tất cả người dùng","1" => "Tất cả người dùng đã đăng nhập","2" => "Tất cả người dùng chưa đăng nhập"];?>
                                <select name="Is_Show" class="form-control" id="price-type">
                                <?php
                                    foreach ($w as $key => $value) {
                                        if(@$record["Is_Show"] == $key){
                                            echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                        }else {
                                            echo '<option value="'.$key.'">'.$value.'</option>';
                                        }
                                        
                                    }
                                ?>
                                </select>
                            </div>
                             <div class="form-group">
                                <label>Vô hiệu hóa</label>
                                <select class="form-control" name="Disable">
                                   <?php 
                                        if(@$record["Disable"] == "1"){
                                            echo "<option value='0' >Hiện</option>";
                                            echo "<option value='1' selected>Ẩn</option>";
                                        }   
                                        else {
                                            echo "<option value='0' selected>Hiện</option>";
                                            echo "<option value='1' >Ẩn</option>";
                                        }
                                                
                                    ?>
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