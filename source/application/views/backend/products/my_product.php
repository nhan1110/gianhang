<div class="container">
    <h1 class="page-header"><?php echo @$title; ?></h1>
    <div class="row">
        <div class="col-xs-12 content-search">
            <div class="panel">
                <div class="row thumbnails custom-product">
                    <?php
                    if (isset($record_product) && is_array($record_product)):
                        foreach ($record_product as $key => $value) :
                            $data["product"] = $value;
                            $data["page"] = "my_product";
                            echo '<div class="col-sm-4 col-mxs-6 col-xs-12">';
                            $this->load->view("fontend/block/product", $data);
                            echo '</div>';
                        endforeach;
                    endif;
                    ?>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right"><?php echo $this->pagination->create_links();?></div>
                </div>
            </div>
            <!--.panel-->
        </div>
    </div>
</div>
<script src="<?php echo skin_url("js/product.js"); ?>"></script>