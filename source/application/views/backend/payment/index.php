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
            Dashboard
            <small>Version 2.0</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url("admin") ?>">Dashboard</a></li>
            <li class="active">Payment</li>
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
                <div class="panel panel-primary">
                    <div class="panel-heading"><h2><i class="halflings-icon edit"></i><span class="break"></span>Tùy chọn thanh toán  <?php echo @$record["Title"];?></h2></div>
                        <div class="panel-body">
                            <div class="row"> 
                            <?php if(isset($record) && $record != null)
                                    $data["setting"] = json_decode($record["Setting"],true);
                            ?>
                            <div id="setting-email" class="main">
                                <div class="col-md-12">
                                    <form method="post">
                            <?php
                                if(isset($load_view) && file_exists(APPPATH."views/backend/payment/block/{$load_view}.php")){
                                    echo "<div class='".@$data_wrapper."'>";
                                    $load_view =  "backend/payment/block/".$load_view;  
                                    $this->load->view($load_view,$data);
                                    echo "</div>";
                                } 
                            ?>
                            <?php if($load_view != "payment"):?>
                                <div class="form-group">
                                    <label>Description*:</label>
                                    <textarea name="description" class="form-control" placeholder="Description"><?php echo @$record["Description"];?></textarea>
                                </div>
                            <?php endif?>
                                        <div class="form-group text-right"><button type="submit" id="save-payment-function" class="btn btn-primary">Save</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->

</div><!-- /.content-wrapper -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url("skins/admin/ColorPicker/style.css");?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("skins/admin/ColorPicker/mod.css");?>">
<script type="text/javascript" src="<?php echo base_url("skins/admin/ColorPicker/colors.js");?>"></script>
<script type="text/javascript" src="<?php echo base_url("skins/admin/ColorPicker/jqColorPicker.js");?>"></script>
<script type="text/javascript" src="<?php echo base_url("skins/admin/ColorPicker/main.js");?>"></script>
<style type="text/css">
    body .checkbox,body .radio{margin: 0;}
    .checkbox label{padding-left: 0;}
</style>
<script type="text/javascript">
    $("#save-payment-function").click(function(){
        return validateform($(this).parents("form"));
    });
    
</script>