<div class="modal fade" id="add-favorite-all-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" data-backdrop="static" style="display: none;">
   <div class="modal-dialog" role="document" style="max-width:440px;">
      <div class="modal-content"  style="position: relative;">
        <form method="POST" action="<?php echo base_url('/yeu-thich/them-chuyen-muc'); ?>" enctype="multipart/form-data" id="add-favorite-all-form">
           <div class="modal-header box-cyan text-white">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="modal-label">Thêm chuyên mục</h4>
           </div>
           <div class="modal-body">
              <div class="alert alert-danger" style="display:none;">
                 <p></p>
              </div>
              <div class="form-group">
                 <label>Tên chuyên mục</label>
                 <input type="text" class="form-control" name="name" id="name" value="">
              </div>
              <div class="custom-loading">
                 <div>
                   <i class="ic ic-md ic-loading"></i>
                 </div>
              </div>
           </div>
           <div class="modal-footer text-right">
              <input type="hidden" name="type" id="favorite_type_id">
              <button class="btn btn-gray" class="close" data-dismiss="modal" aria-label="Close">Hủy bỏ</button>
              <button class="btn btn-primary" type="submit" name="yt2">Thêm mới</button>
           </div>
        </form>
      </div>
   </div>
</div>

<div class="modal fade" id="add-product-to-favorite-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" data-backdrop="static" style="display: none;">
   <div class="modal-dialog" role="document" style="max-width:440px;">
      <div class="modal-content"  style="position: relative;">
        <form method="POST" action="<?php echo base_url('/favorite/add_product'); ?>" enctype="multipart/form-data" id="add-product-to-favorite-form">
           <div class="modal-header box-cyan text-white">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="modal-label">Thêm chuyên mục</h4>
           </div>
           <div class="modal-body">
              <div class="alert alert-success fade in" style="display:none;">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                  <p></p>
              </div>
              <div class="alert alert-danger" style="display:none;">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                 <p></p>
              </div>
              <div class="form-group">
                 <label>Chọn chuyên mục</label>
                 <select name="favorite_id" id="favorite_id" class="form-control"></select>
              </div>
              <p><a href="#" data-toggle="modal" data-target="#add-favorite-all-modal">Tạo mới chuyên mục</a></p>
              <div class="custom-loading">
                 <div>
                   <i class="ic ic-md ic-loading"></i>
                 </div>
              </div>
           </div>
           <div class="modal-footer text-right">
              <input type="hidden" name="product_id" id="product_id">
              <button class="btn btn-gray" class="close" data-dismiss="modal" aria-label="Close">Hủy bỏ</button>
              <button class="btn btn-primary" type="submit" name="yt2">Thêm vào chuyên mục</button>
           </div>
        </form>
      </div>
   </div>
</div>