<div class="content-top">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Trang chủ</a></li>
            <li>Đã xem</li>
        </ol>
    </div>
</div>
<section class="section section-favorite section-history">
	<div class="container">
  	<div class="panel">
      <div class="panel-body" style="position: relative;">
        <div class="custom-loading">
            <div>
                <i class="ic ic-md ic-loading"></i>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-9 col-md-10 col-md-push-2 col-sm-push-3 history-result">
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
            </div>
            <div class="col-sm-3 col-sm-2 col-md-pull-10 col-sm-pull-9 history-setting">
              <h5>Sản phẩm</h5>
              <ul>
                <li><a href="#" class="loading-history-result active" data-type="product" data-value="today">Hôm nay</a></li>
                <?php if(@$is_login): ?>
                    <li><a href="#" class="loading-history-result" data-type="product" data-value="yesterday">Hôm qua</a></li>
                    <li><a href="#" class="loading-history-result" data-type="product" data-value="-3 Day">3 ngày trước</a></li>
                    <li><a href="#" class="loading-history-result" data-type="product" data-value="-7 Day">7 ngày trước</a></li>
                    <li><a href="#" class="loading-history-result" data-type="product" data-value="-15 Day">15 ngày trước</a></li>
                    <li><a href="#" class="loading-history-result" data-type="product" data-value="-1 Month">1 tháng trước</a></li>
                    <li><a href="#" class="loading-history-result" data-type="product" data-value="-2 Month">2 tháng trước</a></li>
                    <li><a href="#" class="loading-history-result" data-type="product" data-value="-3 Month">3 tháng trước</a></li>
                    <li><a href="#" class="loading-history-result" data-type="product" data-value="-6 Month">6 tháng trước</a></li>
                    <li><a href="#" class="loading-history-result" data-type="product" data-value="-1 Year">1 năm trước</a></li>
                    <li><a href="#" class="loading-history-result" data-type="product" data-value="All">Tất cả</a></li>
                <?php endif; ?>
              </ul>
              <div style="height:30px;"></div>
              <h5>Gian hàng</h5>
              <ul>
                <li><a href="#" class="loading-history-result" data-type="stand" data-value="today">Hôm nay</a></li>
                <?php if(@$is_login): ?>
                    <li><a href="#" class="loading-history-result" data-type="stand" data-value="yesterday">Hôm qua</a></li>
                    <li><a href="#" class="loading-history-result" data-type="stand" data-value="-3 Day">3 ngày trước</a></li>
                    <li><a href="#" class="loading-history-result" data-type="stand" data-value="-7 Day">7 ngày trước</a></li>
                    <li><a href="#" class="loading-history-result" data-type="stand" data-value="-15 Day">15 ngày trước</a></li>
                    <li><a href="#" class="loading-history-result" data-type="stand" data-value="-1 Month">1 tháng trước</a></li>
                    <li><a href="#" class="loading-history-result" data-type="stand" data-value="-2 Month">2 tháng trước</a></li>
                    <li><a href="#" class="loading-history-result" data-type="stand" data-value="-3 Month">3 tháng trước</a></li>
                    <li><a href="#" class="loading-history-result" data-type="stand" data-value="-6 Month">6 tháng trước</a></li>
                    <li><a href="#" class="loading-history-result" data-type="stand" data-value="-1 Year">1 năm trước</a></li>
                    <li><a href="#" class="loading-history-result" data-type="stand" data-value="All">Tất cả</a></li>
                <?php endif; ?>
              </ul>
            </div>
    		</div>
      </div>
    </div>  
	</div>
</section>
<style type="text/css">
  .history-setting{
     border-right: 1px solid #ccc;
  }
  .history-setting h5{
      font-size: 18px;
      font-weight: 400;
  }
  .history-setting ul{
      list-style: none;
      padding-left: 0;
      margin-left: 0;
  }
  .history-setting ul li:first-child{
      border-top: 1px dotted #ccc;
  }
  .history-setting ul li{
      padding-top: 7px;
      padding-bottom: 7px;
      border-bottom: 1px dotted #ccc;
  }
  .history-setting ul li a.active{
      color: #feaf02;
  }
</style>
<script type="text/javascript">
   $(document).ready(function(){
       $(document).on('click','.section-history .loading-history-result',function(){
           var type = $(this).attr('data-type');
           var value = $(this).attr('data-value');
           var paging = $(this).attr('data-paging');
           if ( !(typeof paging !== typeof undefined && paging !== false) ) {
              paging = 1;
           }
           if($(this).parents('.history-setting').length > 0){
              $(".history-setting li > a").removeClass('active');
              $(this).addClass('active');
           }
           get_member_history(type,value,paging);
           return false;
       });
       var get_member_history = function(type,value,paging){
          $(".section-history .custom-loading").show();
          $.ajax({
              url: base_url + 'da-xem/cap-nhap',
              type: "post",
              dataType: 'json',
              data: {"type": type,'value':value,'paging':paging},
              success: function (data) {
                  if (data["status"] == "success") {
                      $(".history-result").html(data['responsive']);
                      $("html,body").animate({scrollTop: $(".section-history").offset().top - 150 }, 'slow');
                  }
              },
              complete: function(){
                 $(".section-history .custom-loading").hide();
              },
              error: function (data) {
                //console.log(data['responseText']);
              }
          });
       }
   });
</script>