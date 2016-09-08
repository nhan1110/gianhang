<div class="content-top">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Trang chủ</a></li>
            <li>Danh mục yêu thích</li>
        </ol>
    </div>
</div>
<section  class="section section-favorite">
	<div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 text-right">
          <a href="#" data-toggle="modal" data-target="#add-favorite-modal" class="btn btn-primary" title="Thêm chuyên mục"><i class="fa fa-plus" aria-hidden="true"></i></a>
          <select name="order_by" id="order_by" class="form-control" style="display: inline-block;width: auto;min-height: 40px">
            <option value="">Sắp xếp theo:</option>
             <option value="name">Tên chuyên mục (A-Z)</option>
             <option value="name">Tên chuyên mục (Z-A)</option>
             <option value="date">Ngày tạo</option>
          </select>
      </div>
    </div>
    <div style="height:20px;"></div>
		<div class="row">
		  <?php if(isset($result->ID) && $result->ID != null ): ?>
		  	 <?php foreach ($result as $key => $value): ?>
				<div class="col-md-3 col-sm-4 col-xs-12">
					<?php
						$class = 'default';
						$style = '';
						if(isset($value->Banner) && $value->Banner!=null){
							$style = 'style="background-image:url(\''.$value->Banner.'\');"';
							$class = ''; 
						}
					?>
					<div data-id="<?php echo @$value->ID; ?>" class="favorite-item <?php echo $class; ?>" <?php echo $style; ?>>
						<div class="favorite-action">
							<div class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-chevron-down"></i></a>
								<ul class="dropdown-menu">
								    <li><a href="<?php echo base_url('/yeu-thich/chuyen-muc/'.@$value->Slug); ?>"><i class="fa fa-eye" aria-hidden="true"></i> Xem chuyên mục</a></li>
								    <li><a href="#" class="edit-favorite" data-slug="<?php echo @$value->Slug; ?>"><i class="fa fa-pencil" aria-hidden="true"></i> Chỉnh sửa chuyên mục</a></li>
								    <li><a href="<?php echo base_url('/favorite/delete/'.@$value->Slug); ?>" onclick="return confirm('Bạn có thật sự muốn xóa?');"><i class="fa fa-times" aria-hidden="true"></i> Xóa chuyên mục</a></li>
								    <li><a href="#" class="change-banner-favorite" data-slug="<?php echo @$value->Slug; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Chỉnh sửa ảnh đại diện</a></li>
								</ul>
							</div>
						</div>	
						<div class="favorite-info">
							<a href="<?php echo base_url('/yeu-thich/chuyen-muc/'.@$value->Slug); ?>"><h3><?php echo @$value->Name; ?></h3></a>
						</div>
					</div>
				</div>
			 <?php endforeach; ?>
		  <?php endif; ?>
		</div>
		<div class="row">
			<div class="col-xs-12 text-center">
				<?php echo $this->pagination->create_links(); ?>
			</div>
		</div>
	</div>
</section>
<script src="<?php echo skin_url(); ?>/js/favorite.js"></script>
<div class="modal fade" id="banner-favorite-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" data-backdrop="static" style="display: none;">
   <div class="modal-dialog" role="document">
      <div class="modal-content" style="position: relative;">
        <form method="POST" action="<?php echo base_url('/yeu-thich/thay-doi-anh'); ?>" enctype="multipart/form-data" id="crop-banner-favorite">
           <div class="modal-header box-cyan text-white">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="modal-label">Chỉnh sữa ảnh đại diện</h4>
           </div>
           <div class="modal-body">
              <div class="custom-loading">
                 <div>
                   <i class="ic ic-md ic-loading"></i>
                 </div>
              </div>
              <input type="hidden" class="hidden" id="x" name="x">
              <input type="hidden" class="hidden" id="y" name="y">
              <input type="hidden" class="hidden" id="w" name="w">
              <input type="hidden" class="hidden" id="h" name="h">
              <input type="hidden" class="hidden" value="" name="image_w" id="image_w">
              <input type="hidden" class="hidden" value="" name="image_h" id="image_h">
              <input type="hidden" class="hidden" value="" name="slug" id="slug">
              <input style="display:none;" accept="image/*" onchange="readURL(this);" name="fileupload" id="banner-favorite-image" type="file">
              <img id="uploadPreview" src="" style="display:none; max-width:100%;">
           </div>
           <div class="modal-footer text-right">
              <button class="btn btn-gray" class="close" data-dismiss="modal" aria-label="Close">Hủy bỏ</button>
              <button id="btnSaveView2" disabled="disabled" class="btn btn-primary" type="submit" name="yt2">Cập nhập / Lưu</button>
           </div>
        </form>
      </div>
   </div>
</div>
<div class="modal fade" id="edit-favorite-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" data-backdrop="static" style="display: none;">
   <div class="modal-dialog" role="document" style="max-width:440px;">
      <div class="modal-content"  style="position: relative;">
        <form method="POST" action="<?php echo base_url('/yeu-thich/chinh-sua-chuyen-muc'); ?>" enctype="multipart/form-data" id="edit-favorite-form">
           <div class="modal-header box-cyan text-white">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="modal-label">Chỉnh sữa chuyên mục</h4>
           </div>
           <div class="modal-body">
              <div class="form-group">
              	 <label>Tên chuyên mục</label>
              	 <input type="text" class="form-control" name="name" id="name" value="">
              </div>
              <div class="custom-loading">
                 <div>
                   <i class="ic ic-md ic-loading"></i>
                 </div>
              </div>
              <input type="hidden" class="hidden" value="" name="slug" id="slug">
           </div>
           <div class="modal-footer text-right">
              <button class="btn btn-gray" class="close" data-dismiss="modal" aria-label="Close">Hủy bỏ</button>
              <button class="btn btn-primary" type="submit" name="yt2">Cập nhập / Lưu</button>
           </div>
        </form>
      </div>
   </div>
</div>
<div class="modal fade" id="add-favorite-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" data-backdrop="static" style="display: none;">
   <div class="modal-dialog" role="document" style="max-width:440px;">
      <div class="modal-content"  style="position: relative;">
        <form method="POST" action="<?php echo base_url('/yeu-thich/them-chuyen-muc'); ?>" enctype="multipart/form-data" id="add-favorite-form">
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
              <div class="form-group">
                 <label>Thể loại:</label>
                 <select name="type" id="type" class="form-control">
                    <?php 
                      if(isset($cat->ID) && $cat->ID!=null ):
                        foreach ($cat as $key => $value) {
                           echo '<option value="'.@$value->ID.'">'.@$value->Name.'</option>';
                        }
                      endif;
                    ?>
                 </select>
              </div>
              <div class="custom-loading">
                 <div>
                   <i class="ic ic-md ic-loading"></i>
                 </div>
              </div>
           </div>
           <div class="modal-footer text-right">
              <button class="btn btn-gray" class="close" data-dismiss="modal" aria-label="Close">Hủy bỏ</button>
              <button class="btn btn-primary" type="submit" name="yt2">Cập nhập / Lưu</button>
           </div>
        </form>
      </div>
   </div>
</div>