<div class="content-box-large">
    <div class="panel-body">
        <div class="product-page">
            <div class="row">
                <div class="col-md-8">
                  <a href="<?php echo base_url(); ?>profile/add_product" class="btn-add btn" title="Thêm mới"><i class="fa fa-plus-circle"></i> Thêm</a>
                </div>
                <div class="col-md-4">
                  <form class="navbar-form" method="get" role="search">
                      <div class="input-group">
                          <input type="text" class="form-control" value="<?php echo $this->input->get('q'); ?>" placeholder="Tìm kiếm" name="q">
                          <div class="input-group-btn">
                              <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                          </div>
                      </div>
                  </form>
                </div>
            </div>
            <hr/>
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
    </div>
</div>
<?php $this->load->view("fontend/include/modal_action_product");?>
<script src="<?php echo skin_url("js/product.js"); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("css/style.css"); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("css/custom.css"); ?>">