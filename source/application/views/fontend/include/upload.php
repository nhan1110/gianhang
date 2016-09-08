<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/upload.css">
<script type="text/javascript" src="<?php echo skin_url(); ?>/js/upload.js"></script>
<?php $tree_folder = get_folder_photo(); ?>
<div id="modal_upload" class="modal modal-fullscreen fade" role="dialog" data-backdrop="static">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div class="modal-header relative" style="height:65px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Chọn ảnh</h3>
         </div>
         <div class="modal-body text-right">
            <div id="search-images">
                <form class="form-search-media" action="" method="post">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Tìm kiếm ảnh" name="search-term" id="search-term">
                      <div class="input-group-btn">
                         <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                      </div>
                    </div>
                </form>
            </div>
            <ul class="nav nav-tabs" style="height:42px;">
               <li class="active">
                  <div class="show-mobile">
          					<div class="btn-group">
          					    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><span class="drow-text">Chọn thư mục ảnh</span> <span class="caret"></span></button>
          					    <ul class="dropdown-menu noclose">
                            <li data-id='0' class="sub-folder">
                              <span class="toggle"><i class="fa fa-caret-down"></i></span>
                              <i class='fa-folder-open-o fa'></i>  
                              <span class='name'>Tất Cả</span>
                              <div class='action-folder'>
                                 <p><a title='Thêm thư mục' class='add' href='#'><i class='fa fa-plus'></i> Thêm thư mục</a></p>
                              </div>
                              <?php echo $tree_folder; ?>
                            </li> 
                        </ul>
          					</div>
          					<span class="list-action" style="display:none;">
          						<a style="margin-right:10px; margin-left:10px;" title="Thêm thư mục" class="add" href="#"><i class="fa fa-plus"></i></a>
          						<a style="margin-right:10px;" href="#" title="Chỉnh sữa thư mục" class="edit"><img src="<?php echo skin_url(); ?>/images/edit.png" alt="Edit"></a>
          						<a onclick="return confirm('Bạn có muốn xóa không?');" title="Xóa thư mục" href="#" class="delete"><img src="<?php echo skin_url(); ?>/images/cross.png" alt="Edit"></a>
          					</span>
                  </div>
               </li>
            </ul>
            <div class="tab-content">
              <div class="container custom-container">
                <div class="row">
                	<div class="col-md-20 col-sm-3 col-xs-12">
                		<div class="tree-folder">
	                	 <ul>
  	                		<li data-id='0' class="sub-folder">
                             <span class="toggle"><i class="fa fa-caret-down"></i></span>
                             <i class='fa-folder-open-o fa'></i>  
                             <span class='name'>Tất Cả</span>
                             <div class='action-folder'>
                                   <p><a title='Thêm thư mục' class='add' href='#'><i class='fa fa-plus'></i> Thêm thư mục</a></p>
                             </div>
                             <?php echo $tree_folder; ?>
  	                    </li>
                		 </ul>
                		</div>
                	</div>
                	<div class="col-md-80 col-sm-9 col-xs-12">
                		<div id="history_image" class = "tab-pane fade in active">
		                  <div class="container" style="max-width:100%;">
		                     <div class="row grid-photo">
		                          <div class="col-xs-4 col-sm-3 col-md-2 item defaul box-upload-image">
		                              <div class="add_image" id="select-file" for="#upload-media"><i class="fa fa-plus"></i></div>
		                          </div>
		                     </div>
		                     <form class="form-horizontal hidden" id="_upload" action ="<?php echo base_url('medias/upload'); ?>" method="post" role="form" enctype="multipart/form-data">
		                        <input type="file" name="upload[]" class="hidden" id="upload-media" multiple accept="image/*">
		                        <input type="hidden" name="folder_id" id="folder_id" value="0">
		                        <input type="hidden" name="_token" value="">
		                     </form>
		                     <div id="loading-custom" class="text-center"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
		                  </div>
		               </div>
                	</div>
                </div>
              </div>
            </div>
         </div>
         <div class="modal-footer" style="height:65px;">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" id ="select-image" class="btn btn-success btn-sm">Select</button>
         </div>
      </div>
   </div>
</div>

<!--model bootstrap crop photo-->
<div class="modal fade" id="crop-photo-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" data-backdrop="static" style="display: none;">
   <div class="modal-dialog modal-crop-photo" role="document">
      <div class="modal-content">
        <form method="POST" action="<?php echo base_url('medias/crop_photo'); ?>" enctype="multipart/form-data" id="crop-photo">
           <div class="modal-header box-cyan text-white">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="modal-label">Crop ảnh</h4>
           </div>
           <div class="modal-body" style="position: relative;min-height:300px;">
              <div class="custom-loading">
                  <div>
                      <i class="ic ic-md ic-loading"></i>
                  </div>
              </div>
              <input type="hidden" class="hidden" id="choose" name="choose" value="avatar">
              <input type="hidden" class="hidden" id="x" name="x">
              <input type="hidden" class="hidden" id="y" name="y">
              <input type="hidden" class="hidden" id="w" name="w">
              <input type="hidden" class="hidden" id="h" name="h">
              <input type="hidden" class="hidden" value="" name="image_w" id="image_w">
              <input type="hidden" class="hidden" value="" name="image_h" id="image_h">
              <input type="hidden" class="hidden" value="" name="photo_id" id="photo_id">
              <img id="uploadPreview1" src="">
           </div>
           <div class="modal-footer text-right">
              <button class="btn btn-gray" class="close" data-dismiss="modal" aria-label="Close">Hủy bỏ</button>
              <input id="btnSaveView2" disabled="disabled" class="btn btn-primary" type="submit" name="yt2" value="Crop ảnh">
           </div>
        </form>
      </div>
   </div>
</div>

<!--model bootstrap folder-->
<div class="modal fade" id="folder-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" data-backdrop="static" style="display: none;">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <form method="POST" action="<?php echo base_url('medias/add_folder'); ?>" enctype="multipart/form-data" id="add-folder">
           <div class="modal-header box-cyan text-white">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="modal-label">Thêm thư mục</h4>
           </div>
           <div class="modal-body">
              <div class="alert alert-danger" style="display:none;">
                  <p></p>
              </div>
              <div class="form-group">
                 <label>Tên thư mục</label>
                 <input type="text" class="form-control" name="title" placeholder="Tên thư mục">
              </div>
           </div>
           <div class="modal-footer text-right">
              <input type="hidden" id="folder_id" name="folder_id" value="0">
              <button class="btn btn-gray" class="close" data-dismiss="modal" aria-label="Close">Hủy bỏ</button>
              <input id="btnSaveView3" class="btn btn-primary" type="submit" name="yt2" value="Lưu thư mục">
              <span id="loading-add-folder" style="display:none;"><img width="24" src="<?php echo skin_url(); ?>/images/loading.gif"></span>
           </div>
        </form>
      </div>
   </div>
</div>

<!--model bootstrap edit folder-->
<div class="modal fade" id="folder-edit-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" data-backdrop="static" style="display: none;">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <form method="POST" action="<?php echo base_url('medias/edit_folder'); ?>" enctype="multipart/form-data" id="edit-folder">
           <div class="modal-header box-cyan text-white">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="modal-label">Sữa thư mục</h4>
           </div>
           <div class="modal-body">
              <div class="alert alert-danger" style="display:none;">
                  <p></p>
              </div>
              <div class="form-group">
                 <label>Tên thư mục cần chỉnh sữa</label>
                 <input type="text" class="form-control" name="title" placeholder="Tên thư mục cần chỉnh sữa">
              </div>
           </div>
           <div class="modal-footer text-right">
              <input type="hidden" id="folder_id" name="folder_id" value="0">
              <input type="hidden" id="parent_folder_id" name="parent_folder_id" value="0">
              <button class="btn btn-gray" class="close" data-dismiss="modal" aria-label="Close">Hủy bỏ</button>
              <input id="btnSaveView4" class="btn btn-primary" type="submit" name="yt2" value="Lưu chỉnh sửa">
              <span id="loading-add-folder" style="display:none;"><img width="24" src="<?php echo skin_url(); ?>/images/loading.gif"></span>
           </div>
        </form>
      </div>
   </div>
</div>

<!--model bootstrap edit info image-->
<div class="modal fade" id="image-edit-info-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" data-backdrop="static" style="display: none;">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <form method="POST" action="<?php echo base_url('medias/save_photo'); ?>" enctype="multipart/form-data" id="edit-image-form">
           <div class="modal-header box-cyan text-white">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="modal-label">Chỉnh sửa thông tin ảnh</h4>
           </div>
           <div class="modal-body">
              <div class="form-group">
                  <label>Tên thư mục cần chỉnh sữa</label>
                  <input class="form-control" placeholder="Tiêu đề" type="text" id="title" name="title" value="">
              </div>
              <div class="form-group">
                  <label>Mô tả</label>
                  <textarea class="form-control" id="description" name="description" placeholder="Mô tả" style="margin-top: 0px; margin-bottom: 0px; height: 280px;"></textarea>
              </div>
           </div>
           <div class="modal-footer text-right">
              <input type="hidden" id="photo_id" name="photo_id" value="0">
              <button class="btn btn-gray" class="close" data-dismiss="modal" aria-label="Close">Hủy bỏ</button>
              <input id="btnSaveView4" class="btn btn-primary" type="submit" name="yt2" value="Lưu chỉnh sửa">
              <span class="loading-image" style="display:none;"><img width="24" src="<?php echo skin_url(); ?>/images/loading.gif"></span>
           </div>
        </form>
      </div>
   </div>
</div>