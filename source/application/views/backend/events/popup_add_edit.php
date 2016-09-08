<script src="<?php echo skin_url(); ?>/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo skin_url(); ?>/admin/plugins/datepicker/datepicker3.css">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           <?php echo @$title_page_template; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url("admin") ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url("admin/newsletter");?>">Newsletter</a></li>
            <li><a href="<?php echo base_url("admin/newsletter/popup");?>">Popup newslette</a></li>
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
                                <label>Hearder</label>
                                <?php echo $this->ckeditor->editor('Hearder',@$record["Hearder"]);?>
                            </div>  
                            <div class="form-group">
                                <label>Footer</label>
                                <?php echo $this->ckeditor->editor('Footer',@$record["Footer"]);?>
                            </div>
                            <div class="form-group">
                                <label>Chiều rộng của Popup:</label>
                                <?php $w = ["modal-sm" => "Nhỏ","modal-md" => "Trung bình","modal-lg" => "Lớn"];?>
                                <select name="Width" class="form-control" id="price-type">
                                <?php
                                    foreach ($w as $key => $value) {
                                        if(@$record["Width"] == $key){
                                            echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                        }else {
                                            echo '<option value="'.$key.'">'.$value.'</option>';
                                        }
                                        
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