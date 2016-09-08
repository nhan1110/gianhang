<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Members &nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="<?php echo base_url(); ?>admin/members/add">Add New</a></h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>admin/dashboard/"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Members</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
      <div class="row">
          <div class="col-lg-12 col-md-12">
              <div class="box">
                  <div class="box-header with-border">
                      <h3 class="box-title">Collections</h3>
                  </div><!-- /.box-header -->
                  <div class="box-body">
                      <div class="box-search-product">
                        <form method="GET" id="search-form">
                          <div class="row">
                              <div class="col-md-8 right">
                                  <div class="form-group row text-right">
                                      <div class="col-md-5">
                                          <select name="group" id="group" class="form-control">
                                              <option value=""> -- Tất cả -- </option>
                                              <?php
                                                foreach ($member_group as $value_group) :
                                                  if ($value_group->ID == @$group) {
                                                    echo '<option selected="selected" value="' . $value_group->ID . '">' . $value_group->Group_Title . '</option>';  
                                                  } else {
                                                    echo '<option value="' . $value_group->ID . '">' . $value_group->Group_Title . '</option>';  
                                                  }
                                                endforeach;
                                              ?>
                                          </select>
                                      </div>
                                      <div class="col-md-5">
                                          <input type="text" class="form-control" id="keyword" value="<?php echo @$this->input->get("keyword");?>" name="keyword" placeholder="Từ khóa" />
                                      </div>
                                      <div class="col-md-2"><input type="submit" class="btn btn-primary" value="Search"></div>
                                  </div>
                              </div>
                          </div>
                        </form>
                        </div>
                      <table class="table table-bordered" id="data-grid">
                          <tr>
                              <th>Stt</th>
                              <th>Họ tên</th>
                              <th>Email</th>
                              <th>Địa chỉ</th>
                              <th>Số điện thoại</th>
                              <th>Trạng thái</th>
                              <th>Ngày tạo</th>
                              <th style="width:30px;">Actions</th>
                          </tr>
                          <?php if (isset($collections) && count($collections) > 0) : 
                              $i = 0;
                              foreach ($collections as $key => $value) : $i++;
                              ?>
                              <tr class="row-item">
                                  <td><?php echo $i;?>.</td>
                                  <td><?php echo $value->Firstname.' '.$value->Lastname; ?></td>
                                  <th><?php echo $value->Email; ?></th>
                                  <td><?php echo $value->Address; ?></td>
                                  <td><?php echo $value->Phone; ?></td>
                                  <td><?php echo $value->Status==0 ? 'Enable' : 'Disable'; ?></td>
                                  <td><?php echo $value->Createat; ?></td>
                                  <td style="width:30px;">
                                     <a style="margin-right:5px;" href="<?php echo base_url(); ?>admin/members/edit/<?php echo $value->ID; ?>"><i class="fa fa-edit"></i></a>
                                     <a onclick="return confirm('Bạn có muốn xóa không?');" href="<?php echo base_url(); ?>admin/members/delete/<?php echo $value->ID; ?>"><i class="fa fa-close"></i></a>
                                  </td>
                              </tr>
                              <?php
                              endforeach;
                              ?>
                          </div>
                          <?php endif; ?>
                      </table>
                  </div><!-- /.box-body -->
                  <div class="box-footer clearfix">
                      <?php echo paging($total_rows, $per_page, site_url("admin/members/index"), $current_page, $show_number_page); ?>
                  </div>
              </div><!-- /.box -->
          </div>
      </div>
  </section>
</div>