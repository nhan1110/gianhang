<div class="content-box-large">
  <div class="panel-body">
    <div class="row">
        <div class="col-md-8">
          <a href="<?php echo base_url(); ?>profile/addpost" class="btn-add btn" title="Thêm mới"><i class="fa fa-plus-circle"></i> Thêm</a>
        </div>
        <div class="col-md-4">
          <form class="navbar-form" method="get" role="search">
              <div class="input-group">
                  <input type="text" class="form-control" value="<?php echo $this->input->get('q'); ?>" placeholder="Tìm kiếm" name="q">
                  <div class="input-group-btn">
                      <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                  </div>
              </div>
          </form>
        </div>
      </div>
    <div class="table-responsive">
      <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th style="width:85px;">Ảnh</th>
                <th style="width:180px;">Tiêu đề</th>
                <th style="width:300px;">Mô tả</th>
                <th>Ngày tạo</th>
                <th>Trạng thái</th>
                <th style="width:100px;"></th>
              </tr>
            </thead>
            <tbody>
              <?php if(isset($post) && $post!=null): ?>
                <?php foreach ($post as $key => $value) :?>
                    <tr>
                      <td>
                          <input type="checkbox" id="check-<?php echo $value->ID; ?>">
                          <label for="check-<?php echo $value->ID; ?>">&nbsp;</label>
                      </td>
                      <td><img style="width:100%;" src="<?php echo @$value->Path_Large; ?>"></td>
                      <td><?php echo $value->Title; ?></td>
                      <td><?php echo $value->Summary; ?></td>
                      <td><?php echo $value->Created_at; ?></td>
                      <td><?php echo $value->Status; ?></td>
                      <td style="width:80px;">
                          <a href="<?php echo base_url(); ?>profile/editpost/<?php echo $value->ID; ?>" class="edit-button"><i class="fa fa-pencil-square-o"></i></a>
                          <a href="<?php echo base_url(); ?>profile/deletepost/<?php echo $value->ID; ?>" class="delete-button" onclick="return confirm('Bạn có muốn xóa không?');"><i class="fa fa-times"></i></a>
                      </td>
                    </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
            <tfoot>
              <tr>
                <th>#</th>
                <th>Ảnh</th>
                <th>Tiêu đề</th>
                <th>Mô tả</th>
                <th>Ngày tạo</th>
                <th>Trạng thái</th>
                <th style="width:100px;"></th>
              </tr>
            </tfoot>
          </table>
      </div>
      <div class="row">
        <div class="col-md-5">
          <!--<span class="check-uncheck"><a href="#">Check/Uncheck all</a></span>
          <span>|</span>
          <span class="delete-all-check"><a href="#">Delete</a></span>-->
        </div>
        <div class="col-md-7">
            <div class="paging text-right">
               <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
      </div>
  </div>
</div>
