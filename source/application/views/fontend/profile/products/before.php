<?php
/*
  Created on : Feb 16, 2016, 10:00:18 PM
  Author     : phanquanghiep
 */
?>
<div class="content-box-large">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row"> 
                    <div class="main">
                        <div class="col-md-12">
                        </div> 
                        <div class="col-md-12">
                            <div class="row">
                                <div class="cented col-xs-12 col-md-10">
                                    <form method="get">
                                        <div class="form-group row">
                                            <label class="col-sm-4 control-label" for="formGroupInputSmall">Loại Hình Của Sản Phẩm *</label>
                                            <div class="col-sm-8">
                                                <div id="box-category-type">
                                                <select name="category-type" class="form-control">
                                                    <option value="default">-- Loại Hình Của Sản Phẩm --</option>
                                                    <?php
                                                    if (isset($all_cat_type)):
                                                        echo $all_cat_type;
                                                    endif;
                                                    ?>
                                                </select>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" class="btn btn-primary">Tiếp Tục</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
    if(@$user_info["category_type"] == null){
        $this->load->view("fontend/include/chose-category-type"); ?>
        <script>
            $(document).ready(function(){
                $("#chose-category-type").modal({backdrop: 'static', keyboard: false});
            });
        </script>
<?php } ?>
<link rel="stylesheet" href="<?php echo skin_url(); ?>/admin/page/products.css">
<link href="<?php echo skin_url() ?>/js/summernote/summernote.css" rel="stylesheet">
<script src="<?php echo skin_url() ?>/js/summernote/summernote.js"></script>
<script>
    $(document).ready(function () {
        $('#content').summernote({
            height: 300
        });
        $.each($("#box-category-type .level-0"),function (){
           $(this).prop( "disabled", true );
        });
    });
</script>