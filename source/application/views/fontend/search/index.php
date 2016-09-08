<div class="site-main">
    <div class="content-top">
        <div class="container">
            <ol class="breadcrumb">
                <?php echo @$breadcrumb ;?>
            </ol>
        </div>
    </div>
    <section id="section-category" class="section">
        <div class="container">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                       <div class="col-md-5">
                       <div class="row">
                            <?php if(intval(@$min_price) != intval(@$max_price)):?>
                               <div class="col-md-3"><label>Tìm theo giá:</label></div>
                               <div class="col-md-9"><!--price-range-->
                                    <div class="price-range">
                                        <input type="hidden" class="span6" value="" data-slider-min="<?php echo (isset($min_price) && is_numeric($min_price)) ? intval($min_price) : "0" ;?>" data-slider-max="<?php echo (isset($max_price) && is_numeric($max_price)) ? intval($max_price) : "0" ;?>"  data-slider-value="[<?php echo (isset($min_price) && is_numeric($min_price)) ? intval($min_price) : "0" ;?>,<?php echo (isset($max_price) && is_numeric($max_price)) ? intval($max_price) : "5000000" ;?>]" id="price-range">
                                    </div>
                                </div><!--/price-range-->
                            <?php endif;?>
                       </div>
                            
                        </div>
                        <div class="col-md-7">
                            <div class="cat-nav">
                                <label>Sắp xếp theo</label>
                                <select class="selectpicker" id="sorted_by" data-style="btn-transparent-dark" title="Tất cả">
                                    <option value="null">Tất cả</option>
                                    <option value="rate">Đánh giá</option>
                                    <option value="view">Xem nhiều</option>
                                    <option value="price-high">Giá từ cao đến thấp</option>
                                    <option value="price-low">Giá từ thấp đến cao</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="cat-products" id="content-box-product">
                        <div class="row row-md-gutter-16" id="box-product">
                            <?php if(isset($products) && is_array($products)):?>
                                <?php foreach ($products AS $key => $items):?>
                                    <div class="col-sm-3">
                                        <?php 
                                            $data["product"] = $items;
                                            $this->load->view("fontend/include/product",$data);
                                        ?>    
                                    </div>
                                <?php endforeach;?>
                            <?php endif;?>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="button" id="more-product" class="btn btn-default">Xem Thêm <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></button>
                                <div id = box-data></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

