<script type="text/javascript">
    var url = '/product/details/<?php echo @$product['ID']; ?>';
</script>
<div class="content-top">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li>Sản phẩm</li>
            <li class="active"><?php echo @$product["Name"]; ?></li>
        </ol>
    </div>
</div>

<div class="content">
    <div class="container">
        <div class="content-main">
            <div class="panel">
                <div class="panel-body">
                    <div class="product">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="product-thumbnail text-center" style="border:1px solid #ccc;">
                                    <?php $featured_image = (isset($featured) && $featured != null && file_exists(FCPATH . $featured)) ? $featured : "skins/images/thumbnail-default.jpg"; ?>
                                    <img class="img-responsive" id="image" src="<?php echo base_url($featured_image) ?>" title="<?php echo @$product[" Name "]; ?>">
                                </div>
                                <div class="gallery-product" style="margin-top:10px;">
                                    <ul class="gallery-slider">
                                         <li><a href="#" data-src="<?php echo @$featured_image; ?>"><img src="<?php echo @$featured_image; ?>"></a></li>
                                         <?php if(isset($gallery) && $gallery!=null) : ?>
                                            <?php foreach ($gallery as $key => $value): ?>
                                                <li><a href="#" data-src="<?php echo @$value['Path']; ?>"><img src="<?php echo @$value['Path_Thumb']; ?>"></a></li>
                                            <?php endforeach;?>
                                         <?php endif; ?>
                                    </ul>
                                </div>   
                            </div>
                            <div class="col-md-6">
                                <div class="product-detail">
                                    <h3 class="title"><?php echo @$product["Name"]; ?></h3>
                                    <div class="product-like">
                                        <iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo $current_url_router; ?>&layout=button_count&show_faces=false&width=90&action=like&share=false&font=verdana&colorscheme=light" allowtransparency="true" style="border:medium none; overflow: hidden; width: 90px; height: 24px;" frameborder="0" scrolling="no"></iframe>
                                        <iframe src="https://apis.google.com/u/0/se/0/_/+1/fastbutton?url=<?php echo $current_url_router; ?>" allowtransparency="true" style="border:medium none; overflow: hidden; width: 90px; height: 24px;" frameborder="0" scrolling="no"></iframe>
                                    </div>
                                    <div class="product-price" style="margin-bottom:0;">
                                        <div class="product-item-content" style="padding-left: 0;min-height:auto;">
                                            <div class="product-item-price" style="margin-bottom:0;">
                                                <?php $price = get_price(@$product['ID']); ?>
                                                <?php if(isset($price['price']) && $price['price']!=null): ?>
                                                    <span class="price"><?php echo  $price['price']; ?> VND</span>
                                                <?php endif; ?>
                                                <?php if(isset($price['sale']) && $price['sale']!=null): ?>
                                                    <span class="sale-off"><?php echo $price['sale']; ?> VND</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-excerpt">
                                        <?php echo @$product["Description"]; ?>
                                    </div>
                                    <?php if(isset($keyword) && $keyword!=null && count($keyword) > 0) : ?>
                                        <div class="product-keyword" style="margin-top: 20px;">
                                            <p>
                                                Từ khóa: 
                                                <?php foreach ($keyword as $key => $value) : ?>
                                                    <a href="<?php echo $value['Slug']; ?>"><?php echo $value['Name']; ?></a>
                                                <?php endforeach;?>
                                            </p>
                                        </div>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="product-meta">
                                    <div class="condition-item condition-item-rating">
                                        <span class="condition-item-title">ĐÁNH GIÁ</span>
                                        <div class="condition-item-view horizontal">
                                            <div class="view-wrapper">
                                                <a href="#">  
                                                    <span class="rating">
                                                        <?php 
                                                            $num_rate = 0;
                                                            $temp = 0;
                                                            if(isset($product['num_rate']) && $product['num_rate']!=null && is_numeric($product['num_rate'])){
                                                                $num_rate = $product['num_rate'];
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
                                                    <span class="counter">(<?php echo ( isset($product['Num_Rate']) && is_numeric($product['Num_Rate']) ) ? @$product['Num_Rate'] : '0'; ?>)</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="condition-item condition-item-share">
                                        <span class="condition-item-title">Chia sẻ</span>
                                        <div class="condition-item-view horizontal">
                                            <div class="view-wrapper">
                                                <span class="share-facebook">
                                                    <a href="#" class="share-facebook" data-title="<?php echo @$product["Name"]; ?>" data-url="<?php echo base_url('/san-pham/'.@$product["Slug"]); ?>" data-image="<?php echo base_url(@$featured_image); ?>"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                                                </span>
                                                <span class="counter"><?php echo ( isset($product['Num_Share_Facebook']) && is_numeric($product['Num_Share_Facebook']) ) ? @$product['Num_Share_Facebook'] : '0'; ?></span>
                                            </div>
                                            <div class="view-wrapper">
                                                <meta property="og:title" content="<?php echo @$product["Name"]; ?>"/>
                                                <meta property="og:image" content="<?php echo base_url(@$featured_image); ?>"/>
                                                <meta itemprop="og:description" content="<?php echo substr(htmlspecialchars(strip_tags(@$product["Content"])),30); ?>"/>
                                                <meta itemprop="og:headline" content="<?php echo @$product["Name"]; ?>" />
                                                <span class="share-google-plus">
                                                    <a href="#" class="share-google" data-url="<?php echo base_url('/san-pham/'.@$product["Slug"]); ?>"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a>
                                                </span>
                                                <span class="counter"><?php echo ( isset($product['Num_Share_Google']) && is_numeric($product['Num_Share_Google']) ) ? @$product['Num_Share_Google'] : '0'; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="condition-item condition-item-other">
                                        <span class="condition-item-title">Chia sẻ</span>
                                        <div class="condition-item-view vertical">
                                            <div class="view-wrapper">
                                                <span class="other-view">
                                                    <a href="javascript:;"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                </span>
                                                <span class="counter"><?php echo ( isset($product['Num_View']) && is_numeric($product['Num_View']) ) ? @$product['Num_View'] : '0'; ?></span>
                                            </div>
                                            <div class="view-wrapper">
                                                <span class="other-comment">
                                                    <a href="#"><i class="fa fa-comment-o" aria-hidden="true"></i></a>
                                                </span>
                                                <span class="counter"><?php echo (isset($product['Num_Comment']) && is_numeric($product['Num_Comment'])) ? $product['Num_Comment'] : '0'; ?></span>
                                            </div>
                                            <div class="view-wrapper">
                                                <span class="other-like">
                                                    <a href="#" class="<?php if (@$is_login){echo 'login';} ?>"  data-type="product" data-id="<?php echo @$product['ID']; ?>">
                                                        <?php 
                                                            if(isset($product['Is_Like']) && @$product['Is_Like'] == 1){
                                                                echo '<i class="fa fa-heart" aria-hidden="true"></i>';
                                                            }
                                                            else{
                                                                echo '<i class="fa fa-heart-o" aria-hidden="true"></i>';
                                                            }
                                                        ?>
                                                    </a>
                                                </span>
                                                <span class="counter"><?php echo (isset($product['Num_Like']) && is_numeric($product['Num_Like'])) ? $product['Num_Like'] : '0'; ?></span>
                                            </div>
                                            <div class="view-wrapper">
                                                <span class="other-pin state-default">
                                                    <a href="#" class="<?php if (@$is_login){echo 'login';} ?>" data-id="<?php echo @$product['ID']; ?>"><i class="fa fa-thumb-tack" aria-hidden="true"></i></a>
                                                </span>
                                                <span class="counter">Pin</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="condition-item condition-item-qrcode">
                                        <?php if(@$product["QrCode"] !=null): ?>
                                            <img src="<?php echo @$product["QrCode"]; ?>" class="img-responsive" style="max-width:150px;"> 
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="product-contact">
                                    <a href="mailto:<?php echo @$member->Email; ?>" class="btn btn-primary btn-block">
                                        LIÊN HỆ KHÁCH HÀNG
                                    </a>
                                    <p class="divider">hoặc gọi điện trực tiếp</p>
                                    <a href="callto:<?php echo @$member->Phone; ?>" class="btn btn-block btn-secondary btn-number-only">
                                        <i class="fa fa-phone" aria-hidden="true"></i> <?php echo @$member->Phone; ?> <span class="phone"><?php echo @$member->Phone; ?></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-bottom: 20px;">
    <div class="row row-height">
        <div class="col-md-9 col-sm-8 col-xs-12">
            <div class="panel full-height">
                <div class="panel-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tab-product" role="tablist">
                        <li class="active">
                            <a href="#detail" role="tab" data-toggle="tab">
                                <h5 class="text-uppercase">Thông tin chi tiết</h5>
                            </a>
                        </li>
                        <li>
                            <a href="#review" role="tab" data-toggle="tab">
                                <h5 class="text-uppercase">Đánh giá & Nhận xét</h5>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                            <div class="tab-pane fade active in" id="detail">
                                <?php if(isset($attribute) && $attribute != null): ?>
                                    <h4 style="margin-top:0;">Thuộc tính sản phẩm</h4>
                                    <div class="table-responsive">
                                        <table class="specification-table">
                                            <?php foreach ($attribute as $key => $value): ?>
                                                <tr>
                                                    <td><?php echo $value['Name']; ?></td>
                                                    <td>
                                                        <?php 
                                                            echo $value['Value'];
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </div>
                                    <h4 style="margin-top:20px;">Chi tiết sản phẩm</h4>
                                <?php endif; ?>
                                <?php echo @$product["Content"]; ?>
                            </div>
                            <!--end detail-->
                            <div class="tab-pane fade" id="review">
                                <?php $this->load->view('fontend/include/rate'); ?>
                                <hr>
                                <h3>Bình luận</h3>
                                <div class="fb-comments" width="100%" data-href="<?php echo @$current_url_router; ?>" data-numposts="5"></div>
                            </div>
                            <!--end Comment-->
                    </div>
                    <!-- End Tab panes -->
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-4 col-xs-12">
            <div class="panel full-height">
               <div class="panel-heading"><h3 class="panel-title">Sản phẩm cùng gian hàng</h3></div>
                <div class="panel-body">
                    <?php if(isset($product_by_user) && $product_by_user!=null): ?>
                        <?php foreach ($product_by_user as $key => $items): ?>
                            <div class="product-item" style="border: 1px solid #ddd;margin-bottom:15px;">
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
                                                        <a href="#" data-type="product" data-id="<?php echo @$items['ID']; ?>">
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
                                                        <a href="javascript:"><i class="fa fa-thumb-tack" aria-hidden="true"></i></a>
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
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End review product -->
<?php if(isset($results) && $results!=null) : ?>
  <section class="section-equivalent-product">
    <div class="container list-product-equivalent">
        <div class="row">
            <?php foreach ($results as $key => $items) :  ?>
                <div class="col-sm-3">
                    <div class="product-item" style="border: 1px solid #ddd;margin-bottom:15px;">
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
                                                <a href="#" data-type="product" data-id="<?php echo @$items['ID']; ?>">
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
                                                <a href="javascript:"><i class="fa fa-thumb-tack" aria-hidden="true"></i></a>
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
                </div>
                <?php if( ($key+1) % 4 == 0 ): ?>
                    </div><div class="row">
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
  </section>
<?php endif; ?>
<!--End same product -->
<script src="<?php echo skin_url(); ?>/js/share.js" type="text/javascript"></script>
<script src="<?php echo skin_url(); ?>/js/elevatezoom-min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        if($(window).width() > 768){
            var zoomCollection = '#image';
            $(zoomCollection).elevateZoom({
                lensShape : "basic",
                lensSize : 500,
                zoomWindowHeight:300,
                zoomWindowWidth:300,
                easing:true,
                cursor: 'pointer',
                galleryActiveClass: "active"
            });
        }
        $(".gallery-slider li > a").click(function(){
            $.removeData('#image', 'elevateZoom');
            $('.zoomContainer').remove();
            $(".product-thumbnail img").attr('src',$(this).attr('data-src'));
            if($(window).width() > 768){
                $(zoomCollection).elevateZoom({
                    lensShape : "basic",
                    lensSize : 500,
                    zoomWindowHeight:300,
                    zoomWindowWidth:300,
                    easing:true,
                    cursor: 'pointer',
                    galleryActiveClass: "active"
                });
            }
            return false;
        });
        function realImgDimension(src) {
            var i = new Image();
            i.src = src;
            return {
                naturalWidth: i.width, 
                naturalHeight: i.height
            };
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $(window).load(function(){
            var hash = window.location.hash;
            if(hash == '#comment'){
                $(".content .content-main .other-comment > a").trigger('click');
            }
            else if(hash == '#review'){
                $(".content .content-main .view-wrapper > a").trigger('click');
            }
            else if(hash == '#share-fb'){
                $(".content .content-main .share-facebook").trigger('click');
            }
            else if(hash == '#share-gl'){
                $(".content .content-main .share-google").trigger('click');
            }
        });
        $(".content .content-main .other-comment > a").click(function(){
            $(".tab-product a[href='#review']").trigger('click');
            setTimeout(function(){
                var top = $(".fb-comments").offset().top;
                var body = $("body,html");
                console.log(top);
                body.animate({ scrollTop: top }, 'slow');
            },400);
            return false;
        });

        $(".content .content-main .view-wrapper > a").click(function(){
            $(".tab-product a[href='#review']").trigger('click');
            setTimeout(function(){
                var top = $("#rate_view").offset().top;
                var body = $("body,html");
                console.log(top);
                body.animate({ scrollTop: top }, 'slow');
            },400);
            return false;
        });
    });
</script>