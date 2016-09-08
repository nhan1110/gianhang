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
            <div class="flexbox-md">
                <div class="section-left">
                    <div class="panel-group" role="tablist" aria-multiselectable="true">
                        <?php if (isset($category_type)):?>
                            <div class="panel panel-default">
                                <a class="panel-heading" role="button" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                  Danh mục liên quan
                                </a>
                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body" id="box-filter-search">
                                        <?php echo @$category_type;?>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>
                        <?php if (isset($categories)):?>
                            <div class="panel panel-default">
                                <a class="panel-heading" role="button" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                  Loại sản phẩm
                                </a>
                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body" id="box-filter-search">
                                        <?php echo @$categories;?>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>
                        <?php if (isset($attribute)):?>
                        <div class="panel panel-default">
                            <a class="collapsed panel-heading" role="button" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                              Thuộc tính liên quan
                            </a>
                            <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body" id="box-filter-search">
                                    <?php echo @$attribute;?>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
                        <?php if (isset($keyword) && is_array($keyword) && $keyword != null):?>
                        <div class="panel panel-default">
                            <a class="collapsed panel-heading" role="button" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                              Từ khóa
                            </a>
                            <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    <?php if (isset($keyword) && is_array($keyword) && $keyword != null ):?>
                                    	<?php 
                                    	    echo '<ul class="box-keyword">';
                                    		foreach ($keyword as $key => $value) {
                                    			echo '<li><div class="bootstrap-tagsinput"><a href ="'.base_url("search?tu-khoa=".trim($value["Slug"])."").'"><span class="tag label label-info">'.$value["Name"].'</span></a></div></li>';
                                    		}
                                    		echo '</ul>';
                                    	?>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
                <div class="section-right">
                    <div id="content-oo"></div>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="box-sorted_by">
                                   <div class="col-md-7">
                                       <div class="row">
                                           <div class="box-range">
                                               <?php if(intval(@$min_price) != intval(@$max_price)):?>
                                               <div class="col-md-4"><label class="price-range-text">Tìm theo giá:</label></div>
                                               <div class="col-md-8"><!--price-range-->
                                                    <div class="price-range">
                                                        <input type="hidden" class="span6" value="" data-slider-min="<?php echo (isset($min_price) && is_numeric($min_price)) ? intval($min_price) : "0" ;?>" data-slider-max="<?php echo (isset($max_price) && is_numeric($max_price)) ? intval($max_price) : "0" ;?>"  data-slider-value="[<?php echo (isset($min_price) && is_numeric($min_price)) ? intval($min_price) : "0" ;?>,<?php echo (isset($max_price) && is_numeric($max_price)) ? intval($max_price) : "5000000" ;?>]" id="price-range">
                                                    </div>
                                                </div><!--/price-range-->
                                                <?php endif;?>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="cat-nav">
                                            <label>Sắp xếp theo</label>
                                            <select class="selectpicker" id="sorted_by" data-style="btn-transparent-dark" title="Tất cả">
                                                <option value="null">Tất cả danh mục</option>
                                                <option value="rate">Đánh giá</option>
                                                <option value="view">Xem nhiều</option>
                                                <option value="price-high">Giá từ cao đến thấp</option>
                                                <option value="price-low">Giá từ thấp đến cao</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="box-country" id="filter-country">
                                    <div class="col-md-4">
                                        <div class="cat-nav">
                                            <select class="selectpicker" id="citys" data-level="1" data-style="btn-transparent-dark" title="--Chọn Tỉnh/Thành phố--" data-find="districts">
                                                <option value="null">--Tất cả Tỉnh/Thành phố--</option>
                                                <?php if(isset($city)&& is_array($city)){
                                                    foreach ($city as $key => $value) {
                                                      $order = ($value["Order"] != null && $value["Order"] != "") ? $value["Order"] : "0";
                                                      echo '<option value="'.$value["ID"].'">'.$value["Name"].'<span class="count"> ('.$order.')</span></option>';
                                                    }
                                                }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="cat-nav text-center">
                                            <select class="selectpicker" id="districts" data-style="btn-transparent-dark" data-find="wards" title="--Chọn Quận/Huyện--" data-level="2" disabled></select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="cat-nav text-right">
                                            <select class="selectpicker" id="wards" data-level="3" data-style="btn-transparent-dark" title="--Chọn Phường/Xã--" disabled></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cat-products" id="content-box-product">
                                <div class="total-product"><p id="number-total">Đã tìm thấy <strong><?php echo @$total_product?></strong> bài viết liên quan.</p></div>
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
            </div>
        </div>
    </section>
</div>
