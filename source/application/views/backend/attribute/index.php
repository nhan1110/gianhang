<?php
/*
  Created on : Feb 15, 2016, 7:00:18 PM
  Author     : phanquanghiep
 */
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo @$title_curent;?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><a href="<?php echo base_url("admin/attributes") ?>">Attributes</a></li>
            <?php
            if (isset($title_curent) && $title_curent != "")
                echo '<li class="active">' . $title_curent . '</li>';
            ?>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content attribute-page">
        <div class="row">
            <div class="col-lg-12">
            <?php 
            /*$data_wrapper an array*/
            if(isset($load_view) && file_exists(APPPATH."views/backend/attribute/block/{$load_view}.php")){
                echo "<div class='".@$data_wrapper."'>";
                $load_view =  "backend/attribute/block/".$load_view;  
                $this->load->view($load_view);
                echo "</div>";
            } ?>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php $this->load->view("backend/include/modal-add-attribute");?>
<?php $this->load->view("backend/include/modal-edit-attribute");?>
<?php $this->load->view("backend/include/modal-add-attribute-child");?>
<link rel="stylesheet" href="<?php echo skin_url(); ?>/admin/page/products.css">
<script src="<?php echo base_url("skins/js/jquery-ui.js")?>"></script>
<script src="<?php echo skin_url() ?>/admin/js/product.js"></script>
<script src="<?php echo skin_url() ?>/admin/js/attribute.js"></script>