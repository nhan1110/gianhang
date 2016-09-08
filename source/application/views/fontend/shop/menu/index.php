<link rel="stylesheet" href="<?php echo skin_url('shop/css/menu.css'); ?>" />
<script type="text/javascript"> var group_id = "<?php echo @$id; ?>";</script>
<script src="<?php echo skin_url('shop/js/menu.js'); ?>"></script>
<script src="<?php echo skin_url('admin/dist/js/jquery.1.4.1.min.js'); ?>"></script>
<script src="<?php echo skin_url('admin/dist/js/interface-1.2.js'); ?>"></script>
<script src="<?php echo skin_url('admin/dist/js/inestedsortable.js'); ?>"></script>
<script src="<?php echo skin_url('shop/js/update-menu.js'); ?>"></script>
<div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="panel panel-default">
               <div class="panel-body">
                  <div class="row">
                     <div class="col-sm-9">
                        <div class="row">
                           <div class="col-sm-12">
                              <ul style="float: left;padding-left: 10px;width:100%;border-bottom: 5px solid #009900;" class="menu-tab-group" id="menu-group">
                                 <?php
                                    if (isset($menu_group) && $menu_group != null):
                                        foreach ($menu_group as $value) :
                                            $current = '';
                                            if ($value->ID == $id) {
                                                $current = 'class="current"';
                                            }
                                            echo '<li ' . $current . '><a href="#"><img class="edit-menu" data-id="' . $value->ID . '" data-toggle="modal" title="Edit" src="' . skin_url('images/edit.png') . '" alt="Edit"> <span onclick="javascript:document.location.href=\'' . base_url() . 'shop/menu/' . $value->ID . '\'">' . $value->Title . '</span></a></li>';
                                        endforeach;
                                    endif;
                                    ?>
                                 <li id="add-group"><a data-toggle="modal" data-target="#addModal" href="#" title="Add Item">+</a></li>
                              </ul>
                           </div>
                        </div>
                        <!--end row-->
                        <div class="ns-row" id="ns-header">
                           <div class="ns-actions">Xử lí</div>
                           <div class="ns-url">Liên kết</div>
                           <div class="ns-title">Tiêu đề</div>
                        </div>
                        <?php
                           if (isset($menu) && $menu != null) {
                               echo $menu;
                           } else {
                               echo '<ul id="easymm"></ul>';
                           }
                           ?>
                        <div id="ns-footer">
                           <button type="submit" disabled="disabled" class="btn btn-save btn-primary" id="btn-save-menu">Cập nhập menu</button>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="box-custom box">
                           <h3>Thêm menu</h3>
                           <div id="form-add-menu">
                              <div class="form-group">
                                 <label for="exampleInputName2">Tiêu đề</label>
                                 <input type="text" class="form-control" id="add-title">
                              </div>
                              <div class="form-group">
                                 <label for="exampleInputName2">Liên kết</label>
                                 <input type="text" class="form-control" id="add-url">
                              </div>
                              <div class="form-group">
                                 <input type="checkbox" id="target" value="_blank" name="target">
                                 <label for="target"><span>Cửa sổ mới<span></label>
                              </div>
                              <div class="form-group">
                                 <button id="add-menu" type="submit" class="btn btn-primary">Thêm mới</button>
                              </div>
                           </div>
                        </div>
                        <!--end box -->
                        <div class="box-custom box">
                           <form action="" method="post">
                              <h3>Thêm menu thể loại</h3>
                              <div class="box-add-menu" id="form-add-menu-page">
                                 <ul class="list-item">
                                    <?php
                                       if (isset($category_type) && $category_type != null):
                                           foreach ($category_type as $key => $value) {
                                               echo '<li><a href="#" class="category-type" status="on" type-id="' . $value->ID . '">' . $value->Name . '</a></li>';
                                           }
                                       endif;
                                       ?>
                                 </ul>
                              </div>
                              <input type="hidden" name="group_id" value="<?php echo @$id; ?>">
                           </form>
                           <div class="form-group">
                              <button type="submit" class="btn btn-primary add-menu-list">Thêm mới</button>
                          </div>
                        </div>
                        <!--end box -->
                        <div class="box-custom box">
                           <form action="" method="post">
                              <h3>Thêm menu trang</h3>
                              <div class="box-add-menu" id="form-add-menu-page">
                                 <ul class="list-item">
                                    <?php
                                       if (isset($page) && $page != null):
                                           foreach ($page as $key => $value) {
                                               echo '<li>
                                                       <input type="checkbox" id="page-' . $key . '" value="/shop/page/' . $value->ID . '|' . $value->Title . '" name="item[]">
                                                       <label for="page-' . $key . '"><span>' . $value->Title . '</span></label>
                                                     </li>';
                                           }
                                       endif;
                                       ?>
                                 </ul>
                              </div>
                              <input type="hidden" name="group_id" value="<?php echo @$id; ?>">
                           </form>
                           <div class="form-group">
                              <button type="submit" class="btn btn-primary add-menu-list">Thêm mới</button>
                           </div>
                        </div>
                        <!--end box -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Tạo mới menu</h4>
         </div>
         <div class="modal-body">
            <div class="form-group">
               <label >Tên:</label>
               <input type="text" name="menu" class="form-control" id="add-name" required>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            <button type="button" class="btn btn-primary btn-add-group">Lưu</button>
         </div>
      </div>
   </div>
</div>
<!--model chang menu item-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Menu item</h4>
         </div>
         <div class="modal-body">
            <div class="form-group">
               <label >Tiêu đề</label>
               <input type="text" name="title" class="form-control" id="edit-title">
            </div>
            <div class="form-group">
               <label >Liên kết</label>
               <input type="text" name="url" class="form-control" id="edit-url">
            </div>
            <div class="form-group">
               <input type="checkbox" id="target-add" value="_blank" name="target">
               <label for="target-add"><span>Cửa sổ mới</span></label>
            </div>
         </div>
         <div class="modal-footer">
            <input type="hidden" name="class" class="form-control" id="edit-id">
            <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Đóng</button>
            <button type="button" class="btn btn-primary btn-edit">Lưu</button>
         </div>
      </div>
   </div>
</div>
<style>
   .border-error{
      border: 1px solid red !important;
   }
   .box-add-menu{
      height: 180px;
      overflow-y: scroll;
      border: 1px solid #ccc;
      padding: 15px 0;
      margin-bottom: 10px;
      background: #fff;
   }
   .list-item,
   .list-item ul{
      list-style: none;
      padding-left: 20px;
   }
   .list-item li a{
      display: block;
      margin-bottom: 5px;
      font-size: 16px;
   }
   .box-custom{
      padding: 20px;
      background: rgba(204, 204, 204, 0.2);
   }
   .box-custom h3{
      font-size: 16px;
      text-transform: capitalize;
   }
   .panel-default{
      box-shadow: none;
   }
   .modal-sm.modal-dialog{
      max-width: 400px;
   }
</style>