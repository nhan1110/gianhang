<?php
/*
  Created on : Feb 15, 2016, 7:00:18 PM
  Author     : phanquanghiep
 */
?>
<!-- Content Wrapper. Contains page content -->
<div class="member_upload">
    <section class="attribute-page">
        <div class="col-lg-12">
        <?php 
        /*$data_wrapper an array*/
        if(isset($load_view) && file_exists(APPPATH."views/fontend/profile/attribute/block/{$load_view}.php")){
            echo "<div class='".@$data_wrapper."'>";
            $load_view =  "fontend/profile/attribute/block/".$load_view;  
            $this->load->view($load_view);
            echo "</div>";
        } ?>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php $this->load->view("fontend/include/modal-add-attribute");?>
<?php $this->load->view("fontend/include/modal-add-attribute-child");?>
<link rel="stylesheet" href="<?php echo skin_url(); ?>/admin/page/products.css">
<script src="<?php echo base_url("skins/js/jquery-ui.js")?>"></script>
<script>
    var catTypeID = 0;
<?php if (isset($cat_type_id) && is_numeric($cat_type_id)): ?>
        catTypeID = "<?php echo $cat_type_id ?>";
<?php endif; ?>
</script>
<script src="<?php echo skin_url() ?>/js/product.js"></script>