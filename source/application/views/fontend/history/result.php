<?php if(isset($result) && $result!=null ): $temp  = date("Y-m-d"); ?> 
  <div class="row">
      <?php foreach ($result as $key => $items):  ?>
        <?php
          if(isset($items['time_view']) && $items['time_view'] != null){
             $date = date("Y-m-d",strtotime(@$items['time_view']));
             $today = date("Y-m-d");
             if($key == 0){
                if(strtotime($date) == strtotime($today)) {
                   echo '</div><h4 style="padding-left:0px;">Ngày hôm nay</h4><div class="row">';
                }
                else{
                   $temp = $date;
                   echo '</div><h4 style="padding-left:0px;">Ngày '.date("d/m/Y",strtotime(@$items['time_view'])).'</h4><div class="row">';
                }
             }
             else{
                if(strtotime($temp) != strtotime($date)){
                   $temp = $date;
                   echo '</div><h4 style="padding-left:0px;">Ngày '.date("d/m/Y",strtotime(@$items['time_view'])).'</h4><div class="row">';
                }
             }
          }
        ?>
        <div class="col-sm-4 col-md-3">
            <div class="product-item" style="border: 1px solid #ddd;margin-bottom:15px;">
                <div class="product-item-top">
                    <div class="product-item-thumb">
                        <a href="<?php echo base_url().'san-pham/'.@$items['Slug']; ?>">
                            <div class="product-item-thumb-bg" style="background-image:url('<?php echo @$items['Path_Thumb']; ?>');"></div>
                        </a>
                    </div>
                </div>
                <div class="product-item-content">
                    <div class="product-item-title"><a href="<?php echo base_url().'san-pham/'.@$items['Slug']; ?>" title="<?php echo $items['Name']; ?>"><?php echo @$items['Name']; ?></a></div>
                    <div class="product-item-price" <?php if(@$is_login){ echo 'style="margin-bottom: 10px;"'; } ?>>
                        <?php $price = get_price($items['ID']); ?>
                        <?php if(isset($price['price']) && $price['price']!=null): ?>
                            <span class="price"><?php echo  $price['price']; ?> VND</span>
                        <?php endif; ?>
                        <?php if(isset($price['sale']) && $price['sale']!=null): ?>
                            <span class="sale-off"><?php echo $price['sale']; ?> VND</span>
                        <?php endif; ?>
                    </div>
                    <?php if(@$is_login): ?>
                        <p><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date("d/m/Y, g:i a",strtotime(@$items['time_view'])); ?></p>
                    <?php endif; ?>
                </div>
                <?php if(!@$is_login): ?>
                    <a href="<?php echo base_url().'san-pham/'.@$items['Slug']; ?>" class="btn btn-primary  btn-product-contact">Xem sản phẩm</a>
                <?php endif; ?>
            </div>    
        </div>
      <?php endforeach; ?>
  </div>
<?php else: ?>
  <h4 class="text-center">Không tồn tại kết quả.</h4>
<?php endif; ?>
<div style="height:15px;"></div>
<div class="row paging">
   <div class="col-xs-6">
      <?php if($offset-1 > 0 ) :?>
        <p><a href="#" class="loading-history-result" data-paging="<?php echo $offset-1; ?>" data-type="<?php echo $type; ?>" data-value="<?php echo $value; ?>">&laquo; Mới hơn</a></p>
      <?php endif; ?>
   </div>
   <div class="col-xs-6 text-right">
      <?php if( $offset*$per_page < $count ) :?>
        <p><a href="#" class="loading-history-result" data-paging="<?php echo $offset+1; ?>" data-type="<?php echo $type; ?>" data-value="<?php echo $value; ?>">Cũ hơn &raquo;</a></p>
      <?php endif; ?>
   </div>
</div>