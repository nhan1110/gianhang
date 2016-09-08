
<div class="col-sm-9">
    <div id="content-profile" class="content">
        <div class="panel">
            <?php
            /* $wrapper an array */
            if (isset($view) && file_exists(APPPATH . "views/{$view}.php")):
                $this->load->view($view);
            endif;
            ?>
        </div>
    </div>
</div>
<div class="col-sm-3">
    <div id="sidebar-profile" class="sidebar relative">
        <div class="fixt" data-element-bottom ="#footer">
            <div class="box-sidebar">
                <form role="search" class="search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Tìm Kiếm : Sản Phẩm, Dịch Vụ" name="srch-term" id="srch-term">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
                <ul class="nav menu">
                    <li class="multi"> <a href="<?php echo base_url('profile'); ?>"><i class="fa fa-user"></i>My Profile</a></li>
                    <li class="multi"> <a href="<?php echo base_url('profile/edit'); ?>"><i class="fa fa-pencil"></i>Edit Profile</a></li>
                    <li class="multi"> <a href="<?php echo base_url('profile/my_product'); ?>"><i class="fa fa-send-o"></i>Bài Viết</a></li>
                    <li class="multi"> <a href="<?php echo base_url('profile/add_product'); ?>"><i class="fa fa-edit"></i>Đăng Bài Viết</a></li>
                    <li class="multi"> <a href="<?php echo base_url('profile/categories'); ?>"><i class="fa fa-list-ul"></i>Danh Mục Sản Phẩm</a></li>
                    <li class="multi"> <a href="<?php echo base_url('profile/my_attribute'); ?>"><i class="fa fa-book"></i>Tập Thuộc Tính</a></li>
                    <li class="multi"> <a href="#"><i class="fa fa-photo"></i>Ảnh Của Bạn</a></li>
                    <li class="multi"> <a href="#"><i class="fa fa-thumbs-o-up"></i>Ưa Thích</a></li>
                    <li class="multi"> <a href="#"><i class="fa fa-commenting-o"></i>Bình Luận & Góp Ý</a></li>
                    <li class="multi"> <a href="<?php echo base_url('profile/setting')?>"><i class="fa fa-cog"></i>Cài Đặt</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>