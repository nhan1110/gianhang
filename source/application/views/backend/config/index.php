<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Config Website
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard/'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="active">Config</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Collections</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered" id="data-grid">
                            <tr>
                                <th style="width: 5%">#</th>
                                <th><?php echo $this->lang->line('admin_role_grid_title'); ?></th>
                                <th><?php echo $this->lang->line('admin_identify'); ?></th>
                                <th style="width: 10%"><?php echo $this->lang->line('admin_role_grid_action'); ?></th>
                            </tr>
                            <?php if (isset($collections) && count($collections) > 0) : 
                                $i = 0;
    							$group_child = $collections;
                                foreach ($collections as $item) : $i++;
                                	if ($item->Group_ID == 0) :
                                ?>
                                <tr class="row-item">
                                    <td><?php echo $i;?>.</td>
                                    <td class="title"><?php echo $item->Title; ?></td>
                                    <td class="key_identify"><?php echo $item->Key_Identify; ?></td>
                                    <td class="action">
                                        <a class="edit" title="Edit" data-id="<?php echo $item->ID; ?>" href="javascript:;"><i class="fa fa-edit"></i></a>&nbsp;
                                        <a class="delete" title="Delete" data-id="<?php echo $item->ID; ?>" href="<?php echo base_url('admin/config/delete/' . $item->ID); ?>" onclick="return confirm('Do you want to delete');"><i class="fa fa-close"></i></a>
                                       	<input type="hidden" value="<?php echo $item->Group_ID; ?>" class="group" />
                                    </td>
                                </tr>
                                <?php
                                		$j = 0;
                                		foreach ($group_child as &$item_child) {
                                			if ($item->ID == $item_child->Group_ID) : $j++; ?>
                                				<tr class="row-item">
				                                    <td><?php echo $i . "." . $j . ".";?></td>
				                                    <td class="title"><?php echo $item_child->Title; ?></td>
				                                    <td class="key_identify"><?php echo $item_child->Key_Identify; ?></td>
				                                    <td class="action">
				                                        <a class="edit" title="Edit" data-id="<?php echo $item_child->ID; ?>" href="javascript:;"><i class="fa fa-edit"></i></a>&nbsp;
				                                        <a class="delete" title="Delete" data-id="<?php echo $item_child->ID; ?>" href="<?php echo base_url('admin/config/delete/' . $item_child->ID); ?>" onclick="return confirm('Do you want to delete');"><i class="fa fa-close"></i></a>
				                                       	<input type="hidden" value="<?php echo $item_child->Group_ID; ?>" class="group" />
				                                    </td>
				                                </tr>
                                			<?php
                                				unset($item_child);
                                			endif;
                                		}
                                	endif;
                                endforeach;
                                ?>
                            </div>
                            <?php endif; ?>
                        </table>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <?php echo paging($total_rows, $per_page, site_url("admin/config/index"), $current_page, $show_number_page); ?>
                    </div>
                </div><!-- /.box -->
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add/Edit</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="<?php echo base_url('admin/config/index/' . $current_page); ?>" name="form" id="form" method="POST">
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
                                <label>Group</label>
                                <?php echo select_option($group, '0', '0', ' class="form-control" id="group" name="group" '); ?>
                            </div>
                            <div class="form-group">
                                <label>Key Identify</label>
                                <input type="text" class="form-control" required="required" name="key_identify" id="key_identify" placeholder="Enter Key Identify">
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
            $("#form #group").val(row_item.find('.group').val());
            $("#form #id").val($(this).attr('data-id'));
            if (row_item.find('.group').val() == '0') {
            	$("#form #group").prop("disabled", true);
            } else {
            	$("#form #group").prop("disabled", false);
            }
        });
    });
</script>