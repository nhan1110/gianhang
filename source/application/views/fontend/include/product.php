<?php if(isset($product)):?>
    <div class="product-item" style="border: 1px solid #ddd;margin-bottom:15px;">
        <div class="product-item-top">
            <div class="product-item-thumb">
                <a href="<?php echo base_url().'san-pham/'.@$product['Slug']; ?>">
                    <div class="product-item-thumb-bg" style="background-image:url('<?php echo @$product['Path_Thumb']; ?>');"></div>
                </a>
            </div>
            <div class="product-item-condition">
                <div class="condition-item condition-item-rating">
                    <span class="condition-item-title">ĐÁNH GIÁ</span>
                    <div class="condition-item-view horizontal">
                        <div class="view-wrapper">
                            <span class="rating">
                                <?php 
                                    $num_rate = 0;
                                    $temp = 0;
                                    if(isset($product['Rate_Number']) && @$product['Rate_Number']!=null && is_numeric(@$product['Rate_Number'])){
                                        $num_rate = @$product['Rate_Number'];
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
                            <span class="counter">(<?php echo ( isset($product['Rate_Number']) && is_numeric(@$product['Rate_Number']) ) ? @$product['Rate_Number'] : '0'; ?>)</span>
                        </div>
                    </div>
                </div>
                <div class="condition-item condition-item-share">
                    <span class="condition-item-title">Chia sẻ</span>
                    <div class="condition-item-view horizontal">
                        <div class="view-wrapper">
                            <span class="share-facebook">
                                <a href="javascript:"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                            </span>
                            <span class="counter"><?php echo ( isset($product['Num_Share_Facebook']) && is_numeric(@$product['Num_Share_Facebook']) ) ? @$product['Num_Share_Facebook'] : '0'; ?></span>
                        </div>
                        <div class="view-wrapper">
                            <span class="share-google-plus">
                                <a href="javascript:"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a>
                            </span>
                            <span class="counter"><?php echo ( isset($product['Num_Share_Google']) && is_numeric(@$product['Num_Share_Google']) ) ? @$product['Num_Share_Google'] : '0'; ?></span>
                        </div>
                    </div>
                </div>
                <div class="condition-item condition-item-other">
                    <span class="condition-item-title">Chia sẻ</span>
                    <div class="condition-item-view vertical">
                        <div class="view-wrapper">
                            <span class="other-view">
                                <a href="javascript:"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </span>
                            <span class="counter"><?php echo ( isset($product['Num_View']) && is_numeric(@$product['Num_View']) ) ? @$product['Num_View'] : '0'; ?></span>
                        </div>
                        <div class="view-wrapper">
                            <span class="other-comment">
                                <a href="javascript:"><i class="fa fa-comment-o" aria-hidden="true"></i></a>
                            </span>
                            <span class="counter"><?php echo (isset($product['Num_Comment']) && is_numeric(@$product['Num_Comment'])) ? @$product['Num_Comment'] : '0'; ?></span>
                        </div>
                        <div class="view-wrapper">
                            <span class="other-like">
                                <a href="#" data-type="product" data-id="<?php echo @$product['ID']; ?>">
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
                            <span class="counter"><?php echo (isset($product['Num_Like']) && is_numeric(@$product['Num_Like'])) ? @$product['Num_Like'] : '0'; ?></span>
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
            <div class="product-item-title"><a href="<?php echo base_url().'san-pham/'.@$product['Slug']; ?>" title="<?php echo @$product['Name']; ?>"><?php echo @$product['Name']; ?></a></div>
            <div class="product-item-price">
                <?php $price = get_price(@$product['ID']); ?>
                <?php if(isset($price['price']) && $price['price']!=null): ?>
                    <span class="price"><?php echo  $price['price']; ?> VND</span>
                <?php endif; ?>
                <?php if(isset($price['sale']) && $price['sale']!=null): ?>
                    <span class="sale-off"><?php echo $price['sale']; ?> VND</span>
                <?php endif; ?>
            </div>
        </div>
        <a href="<?php echo base_url().'san-pham/'.@$product['Slug']; ?>" class="btn btn-primary  btn-product-contact" title="">LIÊN HỆ NHÀ CUNG CẤP</a>
    </div>
<?php endif;?>