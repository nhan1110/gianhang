<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $title; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard/'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $title; ?></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered" id="data-grid">
                            <tr>
                                <th style="width: 5%">#</th>
                                <th>Tiêu đề</th>
        						<th>Slug</th>
                                <th>Path</th>
                                <th style="width: 10%"><?php echo $this->lang->line('admin_role_grid_action'); ?></th>
                            </tr>
                            <?php if (isset($collections) && count($collections) > 0) : 
                                $i = 0;
                                foreach ($collections as $item) : $i++;
                                ?>
                                <tr class="row-item">
                                    <td><?php echo $i;?>.</td>
                                    <td class="title"><?php echo $item['Name']; ?></td>
                                    <td class="key_identify"><?php echo $item['Slug']; ?></td>
                                    <td class="path"><?php echo $item['Path']; ?></td>
                                    <td class="action">
                                    	<?php if ($max_level <= 2) :?>
                                    	<a class="list" title="List child" data-id="<?php echo $item['ID']; ?>" href="<?php echo base_url('admin/countrys/index/' . $max_level . '/?slug=' . $item['Path']); ?>"><i class="fa fa-table"></i></a>&nbsp;
                                		<?php endif; ?>
                                        <a class="edit" title="Edit" data-id="<?php echo $item['ID']; ?>" href="javascript:;"><i class="fa fa-edit"></i></a>&nbsp;
                                        <a class="delete" title="Delete" data-id="<?php echo $item['ID']; ?>" href="<?php echo base_url('admin/countrys/delete/' . $item['ID']); ?>" onclick="return confirm('Do you want to delete');"><i class="fa fa-close"></i></a>
                                       	<input type="hidden" value="<?php echo $item['Parent_ID']; ?>" class="group" />
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add/Edit</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="<?php echo base_url('admin/countrys/edit/'); ?>" name="form" id="form" method="POST">
                        <div class="box-body">
                            <?php if (isset($message) && count($message) > 0) : ?>
                            <div class="form-group error">
                                <?php 
                                foreach ($message as $item_message) :
                                    echo $item_message;
                                endforeach;
                                ?>
                            </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label>Key Identify</label>
                                <input type="text" class="form-control" required="required" name="key_identify" id="key_identify" placeholder="Enter Slug">
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" required="required" name="title" id="title" placeholder="Enter title">
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <input type="hidden" id="id" name="id" value="" />
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#data-grid a.edit').click(function () {
            var row_item = $(this).closest('.row-item');
            $("#form #title").val(row_item.find('.title').html());
            $("#form #key_identify").val(row_item.find('.key_identify').html());
            $("#form #id").val($(this).attr('data-id'));
            if (row_item.find('.group').val() == '0') {
            	$("#form #group").prop("disabled", true);
            } else {
            	$("#form #group").prop("disabled", false);
            }
        });
    });
</script>