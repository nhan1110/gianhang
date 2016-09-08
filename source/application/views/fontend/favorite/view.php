<div class="site-main">
    <div class="content-top">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Trang chủ</a></li>
                <li><a  href="<?php echo base_url('/yeu-thich/'); ?>">Sản phẩm yêu thích</a></li>
                <li><?php echo @$favorite->Name; ?></li>
            </ol>
        </div>
    </div>
    <section class="section section-favorite">
        <div class="container">
            <div class="panel">
                <div class="panel-body">
                    <div class="cat-products" id="products-<?php echo @$cate_type->Slug; ?>" id="content-box-product">
                        <div class="row row-md-gutter-16" id="box-product">
                            <?php if(isset($result) && is_array($result) && $result!=null):?>
                                <?php foreach ($result as $key => $items):?>
                                    <div class="col-sm-3 col-md-20">
                                        <div class="favorite-action">
                                            <div class="dropdown">
                                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-chevron-down"></i></a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="<?php echo base_url().'san-pham/'.@$items['Slug']; ?>"><i class="fa fa-eye" aria-hidden="true"></i> Xem sản phẩm</a></li>
                                                    <li><a href="#" class="move-favorite" data-id="<?php echo @$items['ID']; ?>"><i class="fa fa-arrows-alt" aria-hidden="true"></i> Chuyển chuyên mục</a></li>
                                                    <li><a href="<?php echo base_url('/favorite/delete_item/'.@$favorite->Slug.'/'.@$items['ID']); ?>" onclick="return confirm('Bạn có thật sự muốn xóa?');"><i class="fa fa-times" aria-hidden="true"></i> Xóa sản phẩm này</a></li>
                                                </ul>
                                            </div>
                                        </div>
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
                                <?php endforeach;?>
                            <?php else:?>
                              <h3 style="margin-left:10px;">Không tồn tại sản phẩm nào.</h3>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo skin_url(); ?>/js/favorite.js"></script>
<div class="modal fade" id="move-favorite-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" data-backdrop="static" style="display: none;">
   <div class="modal-dialog" role="document" style="max-width:440px;">
      <div class="modal-content"  style="position: relative;">
        <form method="POST" action="<?php echo base_url('/yeu-thich/chuyen-chuyen-muc'); ?>" enctype="multipart/form-data" id="move-favorite-form">
           <div class="modal-header box-cyan text-white">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="modal-label">Chuyển chuyên mục</h4>
           </div>
           <div class="modal-body">
              <div class="alert alert-danger fade in" style="display:none;">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                  <p></p>
              </div>
              <div class="alert alert-success fade in" style="display:none;">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                  <p>Chuyển sản phẩm thành công.</p>
              </div>
              <div class="form-group">
                 <label>Chọn chuyên mục</label>
                 <select name="favorite_id" class="form-control">
                    <?php if(isset($cat_favorite->ID) && $cat_favorite->ID != null): ?>
                        <?php foreach ($cat_favorite as $key => $value) : ?>
                            <option <?php if(@$value->ID == $favorite->ID){echo 'selected';} ?> value="<?php echo @$value->ID; ?>"><?php echo @$value->Name; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                 </select>
              </div>
              <div class="custom-loading">
                 <div>
                   <i class="ic ic-md ic-loading"></i>
                 </div>
              </div>
              <input type="hidden" class="hidden" value="" name="product_id" id="product_id">
              <input type="hidden" class="hidden" value="<?php echo @$favorite->ID; ?>" name="cat_current_id" id="cat_current_id">
           </div>
           <div class="modal-footer text-right">
              <button class="btn btn-gray" class="close" data-dismiss="modal" aria-label="Close">Hủy bỏ</button>
              <button class="btn btn-primary" type="submit" name="yt2">Chuyển chuyên mục</button>
           </div>
        </form>
      </div>
   </div>
</div>