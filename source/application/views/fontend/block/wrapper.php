<?php if(isset($breadcrumb) && $breadcrumb != ""):?>
<div class="content-top">
    <div class="container">
        <ol class="breadcrumb">
            <!--<li><a href="http://gianhangcuatoi.com/">Home</a></li>
            <li>Sản phẩm</li>
            <li class="active">Kẹp tóc hoa Oosewaya HA1000 (Vàng)</li>-->
            <?php echo @$breadcrumb ;?>
        </ol>
    </div>
</div>
<?php endif;?>
<?php if(isset($is_main) && $is_main ) : ?>
    <section id="section-home-top" class="section">
        <div class="container flexbox">
            <div class="section-right" style="width: 100%;">
                <div class="nav-sub-holder hidden-xs hidden-sm">
                    <ul class="nav-sub-menu-holder"></ul>
                </div>
                
                <div class="slider-home-outer">
                    <div id="carousel-example-generic" class="carousel slide slider-home" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active">
                                <div class="block-user-info">
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="#">
                                                <img class="media-object user-info-avatar" src="<?php echo skin_url("data/avatar.png"); ?>" alt="...">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading user-info-name">Mega avatar</h4>
                                            <span class="user-info-location"><i class="fa fa-map-marker" aria-hidden="true"></i> HCM</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li data-target="#carousel-example-generic" data-slide-to="1">
                                <div class="block-user-info">
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="#">
                                                <img class="media-object user-info-avatar" src="<?php echo skin_url("data/avatar.png"); ?>" alt="...">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading user-info-name">Mega avatar</h4>
                                            <span class="user-info-location"><i class="fa fa-map-marker" aria-hidden="true"></i> HCM</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li data-target="#carousel-example-generic" data-slide-to="2">
                                <div class="block-user-info">
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="#">
                                                <img class="media-objec user-info-avatar" src="<?php echo skin_url("data/avatar.png"); ?>" alt="...">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading user-info-name">Mega avatar</h4>
                                            <span class="user-info-location"><i class="fa fa-map-marker" aria-hidden="true"></i> HCM</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <div class="item-inner" style="background-image: url(<?php echo skin_url("data/slider.png"); ?>);">

                                    <div class="carousel-caption">
                                        <a class="btn btn-lg btn-primary" href="">LIÊN HỆ NHÀ CUNG CẤP</a>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="item-inner" style="background-image: url(<?php echo skin_url("data/slider.png"); ?>);">

                                    <div class="carousel-caption">
                                        <a class="btn btn-lg btn-primary" href="">LIÊN HỆ NHÀ CUNG CẤP</a>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="item-inner" style="background-image: url(<?php echo skin_url("data/slider.png"); ?>);">

                                    <div class="carousel-caption">
                                        <a class="btn btn-lg btn-primary" href="">LIÊN HỆ NHÀ CUNG CẤP</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.home-slider-outer-->
            </div>
        </div>
    </section>
<?php else: ?>
<?php endif; ?>

<div class="section-list-category-type">
<?php if(isset($results) && $results!=null) : $sidebar = ''; ?>
  <?php foreach ($results as $key => $value) :  ?>
        <?php $product = $value['product_new']; ?>
        <?php $sidebar .= '<li><a href="#products-'.$value['Slug'].'"><i class="fa fa-camera"></i>'.$value['Icon'].'<span class="name">'.$value['Name'].'</span></a></li>'; ?>
        <section data-slug="<?php echo $value['Slug']; ?>" id="products-<?php echo $value['Slug']; ?>" class="section section-products">
            <div class="container" style="position: relative;">
                <div class="custom-loading">
                    <div>
                        <i class="ic ic-md ic-loading"></i>
                    </div>
                </div>
                <div class="section-products-top">
                    <?php if(isset($is_main) && $is_main) :?>
                        <h2>
                            <a href="<?php echo base_url('danh-muc'.$value['Path']); ?>"><?php echo $value['Name']; ?></a> <a class="btn btn-transparent-dark pull-right hidden-sm hidden-md hidden-lg" href=""><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                        </h2>
                    <?php endif; ?>
                    <div class="products-filter">
                        <div class="text-right hidden-sm hidden-md hidden-lg">
                            <a class="btn btn-transparent-dark" role="button" data-toggle="collapse" href="#products-filter-trang-phuc" aria-expanded="false" aria-controls="products-filter-trang-phuc">Bộ lọc <i class="fa fa-filter" aria-hidden="true"></i></a>
                        </div>

                        <div id="products-filter-<?php echo $value['Slug']; ?>" class="collapse">
                            <div class="row">
                                <div class="col-sm-4">
                                    <?php if(isset($is_main) && $is_main) :?>
                                        <select class="selectpicker" data-selected-text-format="count" data-style="btn-transparent-dark" title="Tất cả danh mục">
                                            <option value="">Tất cả chuyên mục</option>
                                            <?php if(isset($value['cat_type_children'])): ?>
                                                <?php foreach ($value['cat_type_children'] as $item) : ?> 
                                                    <option value="<?php echo $item['Slug']; ?>"><?php echo $item['Name']; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    <?php else: ?>
                                        <h2><?php echo $value['Name']; ?></h2>
                                    <?php endif; ?>
                                </div>
                                <div class="col-sm-8">
                                    <ul class="list-inline filter-list">
                                        <li>
                                            <div class="checkbox">
                                                <input id="checkbox-new-<?php echo $value['ID']; ?>" class="styled" type="checkbox" value="news" checked>
                                                <label for="checkbox-new-<?php echo $value['ID']; ?>">
                                                    Mới nhất
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="checkbox">
                                                <input id="checkbox-view-<?php echo $value['ID']; ?>" class="styled" value="view" type="checkbox">
                                                <label for="checkbox-view-<?php echo $value['ID']; ?>">
                                                   Phổ biến
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="checkbox">
                                                <input id="checkbox-sale-<?php echo $value['ID']; ?>" class="styled" value="sale" type="checkbox">
                                                <label for="checkbox-sale-<?php echo $value['ID']; ?>">
                                                    Giảm giá
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/.products-filter-->
                </div>
                <div class="flexbox">
                    <div class="section-left hidden-xs hidden-sm">
                        <div class="products-cat-thumb" style="background-image: url('<?php echo @$value["Images"]; ?>')">
                            <div class="overlay"></div>
                            <a class="btn btn-white" href="<?php echo base_url('danh-muc'.$value['Path']); ?>">XEM TẤT CẢ</a>
                        </div>
                    </div>
                    <div class="section-right">
                        <div class="products-list-slider-outer">
                            <ul class="products-list products-list-slider">
                                <?php foreach ($product as $key => $items) : ?>
                                    <li>
                                        <div class="product-item">
                                            <div class="product-item-top">
                                                <div class="product-item-thumb">
                                                    <a href="<?php echo base_url().'san-pham/'.@$items['Slug']; ?>">
                                                        <div class="product-item-thumb-bg" style="background-image:url('<?php echo @$items['Path_Thumb']; ?>');"></div>
                                                    </a>
                                                </div>
                                                <div class="product-item-condition">
                                                    <div class="condition-item condition-item-rating">
                                                        <span class="condition-item-title">ĐÁNH GIÁ</span>
                                                        <div class="condition-item-view horizontal">
                                                            <div class="view-wrapper">
                                                              <a href="<?php echo base_url().'san-pham/'.@$items['Slug']; ?>/#review">
                                                                <span class="rating">
                                                                    <?php 
                                                                        $num_rate = 0;
                                                                        $temp = 0;
                                                                        if(isset($items['num_rate']) && $items['num_rate']!=null && is_numeric($items['num_rate'])){
                                                                            $num_rate = $items['num_rate'];
                                                                        }
                                                                        for ($i = 1; $i <= $num_rate ; $i++) { 
                                                                            $temp++;
                                                                            echo '<i class="fa fa-star" aria-hidden="true"></i>';
                                                                        }
                                                                        if($num_rate - $temp > 0){
                                                                           $temp++;
                                                                           echo '<i class="fa fa-star-half-o" aria-hidden="true"></i>'; 
                                                                        }
                                                                        for ($i = $temp; $i < 5 ; $i++) { 
                                                                           echo '<i class="fa fa-star-o" aria-hidden="true"></i>';
                                                                        }
                                                                    ?>
                                                                </span>
                                                                <span class="counter">(<?php echo ( isset($items['Num_Rate']) && is_numeric($items['Num_Rate']) ) ? @$items['Num_Rate'] : '0'; ?>)</span>
                                                              </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="condition-item condition-item-share">
                                                        <span class="condition-item-title">Chia sẻ</span>
                                                        <div class="condition-item-view horizontal">
                                                            <div class="view-wrapper">
                                                                <span class="share-facebook">
                                                                    <a href="<?php echo base_url().'san-pham/'.@$items['Slug']; ?>/#share-fb"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                                                                </span>
                                                                <span class="counter"><?php echo ( isset($items['Num_Share_Facebook']) && is_numeric($items['Num_Share_Facebook']) ) ? @$items['Num_Share_Facebook'] : '0'; ?></span>
                                                            </div>
                                                            <div class="view-wrapper">
                                                                <span class="share-google-plus">
                                                                    <a href="<?php echo base_url().'san-pham/'.@$items['Slug']; ?>/#share-gl"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a>
                                                                </span>
                                                                <span class="counter"><?php echo ( isset($items['Num_Share_Google']) && is_numeric($items['Num_Share_Google']) ) ? @$items['Num_Share_Google'] : '0'; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="condition-item condition-item-other">
                                                        <span class="condition-item-title">Chia sẻ</span>
                                                        <div class="condition-item-view vertical">
                                                            <div class="view-wrapper">
                                                                <span class="other-view">
                                                                    <a href="<?php echo base_url().'san-pham/'.@$items['Slug']; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                                </span>
                                                                <span class="counter"><?php echo ( isset($items['Num_View']) && is_numeric($items['Num_View']) ) ? @$items['Num_View'] : '0'; ?></span>
                                                            </div>
                                                            <div class="view-wrapper">
                                                                <span class="other-comment">
                                                                    <a href="<?php echo base_url().'san-pham/'.@$items['Slug']; ?>/#comment"><i class="fa fa-comment-o" aria-hidden="true"></i></a>
                                                                </span>
                                                                <span class="counter"><?php echo (isset($items['Num_Comment']) && is_numeric($items['Num_Comment'])) ? $items['Num_Comment'] : '0'; ?></span>
                                                            </div>
                                                            <div class="view-wrapper">
                                                                <span class="other-like">
                                                                    <a href="#" class="<?php if (@$is_login){echo 'login';} ?>" data-type="product" data-id="<?php echo @$items['ID']; ?>">
                                                                        <?php 
                                                                            if(isset($items['Is_Like']) && @$items['Is_Like'] == 1){
                                                                                echo '<i class="fa fa-heart" aria-hidden="true"></i>';
                                                                            }
                                                                            else{
                                                                                echo '<i class="fa fa-heart-o" aria-hidden="true"></i>';
                                                                            }
                                                                        ?>
                                                                        
                                                                    </a>
                                                                </span>
                                                                <span class="counter"><?php echo (isset($items['Num_Like']) && is_numeric($items['Num_Like'])) ? $items['Num_Like'] : '0'; ?></span>
                                                            </div>
                                                            <div class="view-wrapper">
                                                                <span class="other-pin state-default">
                                                                    <a href="#" class="<?php if (@$is_login){echo 'login';} ?>" data-id="<?php echo @$items['ID']; ?>"><i class="fa fa-thumb-tack" aria-hidden="true"></i></a>
                                                                </span>
                                                                <span class="counter">Pin</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-item-content">
                                                <div class="product-item-title"><a href="<?php echo base_url().'san-pham/'.@$items['Slug']; ?>" title="<?php echo $items['Name']; ?>"><?php echo @$items['Name']; ?></a></div>
                                                <div class="product-item-price">
                                                    <?php $price = get_price($items['ID']); ?>
                                                    <?php if(isset($price['price']) && $price['price']!=null): ?>
                                                        <span class="price"><?php echo  $price['price']; ?> VND</span>
                                                    <?php endif; ?>
                                                    <?php if(isset($price['sale']) && $price['sale']!=null): ?>
                                                        <span class="sale-off"><?php echo $price['sale']; ?> VND</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <a href="<?php echo base_url().'san-pham/'.@$items['Slug']; ?>" class="btn btn-primary  btn-product-contact" title="">LIÊN HỆ NHÀ CUNG CẤP</a>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
  <?php endforeach; ?>
  <div class="fixed-bar fixed-bar-light fixed-bar-category hidden-xs">
    <ul>
        <?php echo $sidebar; ?>
    </ul>
  </div>
<?php endif; ?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var section_list_top = $(".section-list-category-type").offset().top;
		$(window).scroll(function(){
	        var scroll_top = $(window).scrollTop();
	        if(scroll_top >= section_list_top){
	        	$(".fixed-bar-category").show();
	        	$(".fixed-bar-category li a").each(function(){
	        		var id = $(this).attr('href');
	        		var section_top = $(id).offset().top;
	        		var section_height = $(id).outerHeight();
	        		if(scroll_top >= section_top && scroll_top <= section_top + section_height){
	        			$(".fixed-bar-category li a").removeClass('active');
	        			$(this).addClass('active');
	        		}
	        	});
	        }
	        else{
	        	$(".fixed-bar-category").hide();
	        	$(".fixed-bar-category li a").removeClass('active');
	        }

	    });
	    $(".fixed-bar-category li a").click(function(){
	    	$(".fixed-bar-category li a").removeClass('active');
	    	$(this).addClass('active');
	    	var id = $(this).attr('href');
	    	var body = $("body,html");
	    	body.animate({ scrollTop: $(id).offset().top }, '500');
	    	return false;
	    });
	});
</script>