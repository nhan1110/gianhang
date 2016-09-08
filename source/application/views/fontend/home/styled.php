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