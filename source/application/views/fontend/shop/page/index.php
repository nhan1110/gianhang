<div class="container">
    <div class="row">
      <?php $this->load->view('/fontend/shop/sidebar'); ?>
        <section id="sidebar-main" class="col-md-9">
           <p class="text-right">
             <a class="btn btn-primary" href="<?php echo base_url(); ?>shop/add_page">Thêm trang</a>
           </p>
           <table class="table table-bordered">
            <thead>
                <tr>
                  <th style="border-bottom:0;">Stt</th>
                  <th style="width:200px;border-bottom:0;">Tiêu đề</th>
                  <th style="border-bottom:0;">Mô tả</th>
                  <th style="width:150px;border-bottom:0;">Ngày tạo</th>
                  <th style="border-bottom:0;"></th>
                </tr>
            </thead>
            <tbody>
              <?php if(isset($page) && $page!=null): ?>
                <?php foreach ($page as $key => $value) :?>
                    <tr>
                      <td><?php echo ($key+1); ?></td>
                      <td><?php echo $value->Title; ?></td>
                      <td><?php echo $value->Summary; ?></td>
                      <td><?php echo $value->Date_Creater; ?></td>
                      <td style="width:80px;">
                         <a style="margin-right:5px;" href="<?php echo base_url(); ?>shop/edit_page/<?php echo $value->ID; ?>"><img src="<?php echo skin_url(); ?>/images/edit.png" alt="Edit"></a>
                         <a onclick="return confirm('Bạn có muốn xóa không?');" href="<?php echo base_url(); ?>shop/delete_page/<?php echo $value->ID; ?>"><img src="<?php echo skin_url(); ?>/images/cross.png" alt="Edit"></a>
                      </td>
                    </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </section>
    </div>
</div>