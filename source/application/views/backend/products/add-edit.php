<?php
/*
  Created on : Feb 15, 2016, 7:00:18 PM
  Author     : phanquanghiep
 */
?>
<!-- Main content -->
<div class="content-wrapper admin-page-product">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Products <?php echo @$action;?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url("admin") ?>">Dashboard</a></li>
            <li class="active"><a href="<?php echo base_url("admin/products") ?>">Products</a></li>
            <?php
            if (isset($title_curent) && $title_curent != "")
                echo '<li class="active">' . $title_curent . '</li>';
            ?>
        </ol>
    </section>
    <section class="content product-page">
        <div class="row">
            <?php if ($this->input->get("success") || isset($success)): ?>
                <div class="col-md-12">
                <?php if ($this->input->get("success") == "done" || (isset($success) && $success == "done")) { ?>
                    <div class = "alert alert-success" style=" margin-top: 30px; ">
                        <a href = "#" class = "close" data-dismiss = "alert" aria-label = "close">&times;
                        </a>
                        <strong>Success!</strong> Indicates a successful or positive action.
                    </div>
                <?php } ?>
                <?php if ($this->input->get("success") == "error" || (isset($success) && $success == "error")) { ?>
                    <div class = "alert alert-danger" style=" margin-top: 30px; ">
                        <a href = "#" class = "close" data-dismiss = "alert" aria-label = "close">&times;
                        </a>
                        <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
                    </div>
                <?php } ?> 
                </div>
            <?php endif; ?>
            <div class="col-md-12">
                <div id="box-tabs-parent" class="member_upload">
                    <div class="main">
                        <form action="<?php base_url("admin/product/save") ?>" method="post">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-primary general">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" class="click-collapse" data-parent="#accordion" href="#collapse-general">Tổng Quát*</a>
                                        </h4>
                                    </div>
                                    <div id="collapse-general" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <?php $this->load->view("fontend/profile/products/block/general"); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-primary price">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" class="click-collapse" data-parent="#accordion" href="#collapse-price">Giá*</a>
                                        </h4>
                                    </div>
                                    <div id="collapse-price" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <?php $this->load->view("fontend/profile/products/block/price"); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-primary media">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" class="click-collapse" data-parent="#accordion" href="#collapse-media">Hình Ảnh Sản Phẩm*</a>
                                        </h4>
                                    </div>
                                    <div id="collapse-media" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <?php $this->load->view("fontend/profile/products/block/media"); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-primary categories">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" class="click-collapse" data-parent="#accordion" href="#collapse-categories">Danh Mục Sản Phẩm*</a>
                                        </h4>
                                    </div>
                                    <div id="collapse-categories" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <?php $this->load->view("fontend/profile/products/block/categories"); ?>
                                        </div>
                                    </div>
                                </div>

                            <?php 
                            if(isset($arg_tabs)):
                                $data["attribute"] = [];
                                if (isset($attribute_owner) && is_array($attribute_owner) && count($attribute_owner) > 0) {
                                    $data["attribute"] = $attribute_owner;
                                }
                                $data["attribute_activer"] = [];
                                if (isset($att_activer) && is_array($att_activer) && count($att_activer) > 0) {
                                    $data["attribute_activer"] = $att_activer;
                                }
                                foreach ($arg_tabs AS $key => $value):?>
                                    <div class="panel panel-primary <?php echo $value["Slug"];?>">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" class="click-collapse" data-parent="#accordion" href="#collapse-<?php echo $value["Slug"];?>"><?php echo $value["Name"];?></a>
                                            </h4>
                                        </div>
                                        <div id="collapse-<?php echo $value["Slug"];?>" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <?php 
                                                    $data["content"]["key"] = @$value["Slug"];
                                                    $data["content"]["value"] = @$value["items"];
                                                    $this->load->view("fontend/profile/products/block/master", $data);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                            <?php   
                                endforeach;
                            endif;?>
                            </div>
                            <div class="col-md-12 text-right">
                                <div id="button-save">
                                    <?php if (isset($cat_type_id)): ?>
                                        <input type="hidden" name="category_type" id="category_type_id"  value="<?php echo @$cat_type_id; ?>">
                                    <?php endif; ?>
                                    <?php if (isset($product_slug)): ?>
                                        <input type="hidden" name="product_slug" id="product_slug" value="<?php echo $product_slug; ?>">
                                    <?php endif; ?>
                                    <?php if (isset($product_id)): ?>
                                        <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>">
                                    <?php endif; ?>
                                    <button type="submit" class="btn btn btn-primary relative" id="save_product"><i class="fa fa-save"></i><?php echo @$text_button; ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $this->load->view("fontend/include/add-attribute-old"); ?>
<?php if (isset($error) && is_array($error) && count($error) > 0): ?>
    <style>
    <?php foreach ($error["key_error"] as $key => $value) { ?>
            .category-type .<?php echo $value; ?> > a{
                color: red !important;
            }
    <?php } ?>
    <?php foreach ($error["input_error"] as $key => $value) { ?>
            .tab-pane #<?php echo $value; ?>{
                border:1px solid red !important;
            }
    <?php } ?>
    </style>
<?php endif ?>
<script src="<?php echo skin_url("js/jquery-ui.js");?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo skin_url(); ?>/admin/js/tag-it.js"></script>
<script src="<?php echo skin_url(); ?>/admin/js/tag-it.min.js"></script>
<link rel="stylesheet" href="<?php echo skin_url(); ?>/admin/page/products.css">
<link rel="stylesheet" href="<?php echo skin_url(); ?>/admin/css/jquery.tagit.css">
<link rel="stylesheet" href="<?php echo skin_url(); ?>/admin/css/tagit.ui-zendesk.css">
<link rel="stylesheet" href="<?php echo skin_url(); ?>/admin/css/bootstrap-datepicker.min.css">
<script src="<?php echo skin_url() ?>/admin/js/bootstrap-datepicker.js"></script>
<script src="<?php echo skin_url() ?>/admin/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo skin_url() ?>/admin/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo skin_url() ?>/admin/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<link href="<?php echo skin_url() ?>/js/summernote/summernote.css" rel="stylesheet">
<script src="<?php echo skin_url() ?>/js/summernote/summernote.js"></script>
<script>
    var catTypeID = 0;
<?php if (isset($cat_type_id) && is_numeric($cat_type_id)): ?>
        catTypeID = "<?php echo $cat_type_id ?>";
<?php endif; ?>
</script>
<script src="<?php echo skin_url() ?>/js/product.js"></script>
<script type="text/javascript" src="<?php echo skin_url('js/ckfinder/ckfinder_v1.js'); ?>"></script>
<script type="text/javascript">
  var object;
  function BrowseServerCustom(obj){
      object = obj;
      var finder = new CKFinder() ;
      finder.BasePath = '<?php echo skin_url('js/ckfinder/'); ?>';
      finder.SelectFunction = SetFileFieldCustom ;
      finder.SelectFunctionData = obj ;
      finder.Popup() ;
  }

  function ClearFileCustom(obj){
      $(obj).parents('.box-featured').find('.xImagePath').val('');
      $(obj).parents('.box-featured').find('#box-featured').css('background-image','');
  }

  function SetFileFieldCustom( fileUrl, data ,files){
      console.log(fileUrl);
      $(object).parents('.box-featured').find('.file-media').val(fileUrl);
      $(object).parents('.box-featured').find('.product-image').css('background-image','url("'+fileUrl+'")');
  }

  //Gallery
  var object_gallery;
  function BrowseServerGallery(obj){
      object_gallery = obj;
      var finder = new CKFinder() ;
      finder.BasePath = '<?php echo skin_url('js/ckfinder/'); ?>';
      finder.SelectFunction = SetFileFieldGallery ;
      finder.SelectFunctionData = obj ;
      finder.Popup() ;
  }

  function ClearFileItemGallery(obj){
      $(obj).parents('li').remove();
  }

  function SetFileFieldGallery( fileUrl, data ,files){
      var html = '';
      for ( var i = 0; i < files.length; i++ ) {
          //console.log( files[i].url );
      }
      //$(object_gallery)
  }
</script>

