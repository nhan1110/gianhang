<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Từ khóa </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>admin/dashboard/"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Tập từ khóa ở các chuyên mục</li>
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
                                            <option value="">-- Loại hình của sản phẩm --</option>                                    
                                            <?php echo @$all_cat_type; ?>
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
                              <th>Tên</th>
                              <th>Slug</th>
                              <th>Ngày tạo</th>
                              <th style="width:30px;">Actions</th>
                          </tr>
                          <?php if (isset($collections) && count($collections) > 0) : 
                              $i = 0;
                              foreach ($collections as $key => $value) : $i++;
                              ?>
                              <tr class="row-item">
                                  <td><?php echo $i;?>.</td>
                                  <td><?php echo $value->Name; ?></td>
                                  <th><?php echo $value->Slug; ?></th>
                                  <td><?php echo $value->Created_at; ?></td>
                                  <td style="width:30px;">
                                     <a style="margin-right:5px;" href="<?php echo base_url(); ?>admin/keyword/edit/<?php echo $value->ID; ?>"><i class="fa fa-edit"></i></a>
                                     <a onclick="return confirm('Bạn có muốn xóa không?');" href="<?php echo base_url(); ?>admin/keyword/delete/<?php echo $value->ID; ?>"><i class="fa fa-close"></i></a>
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
                      <?php echo paging($total_rows, $per_page, site_url("admin/keywordm/index/?" . $_SERVER['QUERY_STRING']), $current_page, $show_number_page); ?>
                  </div>
              </div><!-- /.box -->
          </div>
      </div>
  </section>
</div>