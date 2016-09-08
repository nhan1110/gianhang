<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Member group
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard/'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="active">Member group</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Group member list</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered" id="data-grid">
                            <tr>
                                <th style="width: 5%">#</th>
                                <th><?php echo $this->lang->line('admin_role_grid_title'); ?></th>
                                <th><?php echo $this->lang->line('admin_role_grid_description'); ?></th>
                                <th style="width: 15%"><?php echo $this->lang->line('admin_role_grid_action'); ?></th>
                            </tr>
                            <?php if (isset($collections) && count($collections) > 0) : 
                                $i = 0;
                                foreach ($collections as $item) : $i++;
                                ?>
                                <tr class="row-item">
                                    <td><?php echo $i;?>.</td>
                                    <td class="title"><?php echo $item->Role_Title; ?></td>
                                    <td class="description"><?php echo $item->Role_Description; ?></td>
                                    <td class="action">
                                        <a class="edit" title="Edit" data-id="<?php echo $item->ID; ?>" href="javascript:;"><i class="fa fa-edit"></i></a>&nbsp;
                                		<a class="rule" title="Rule" data-id="<?php echo $item->ID; ?>" href="<?php echo site_url('admin/member_group/setrule/?id='.$item->ID); ?>"><i class="fa fa-user-plus"></i></a>&nbsp;
                                        <a class="delete" title="Delete" data-id="<?php echo $item->ID; ?>" href="<?php echo base_url('admin/member_group/delete/' . $item->ID); ?>" onclick="return confirm('Do you want to delete');"><i class="fa fa-close"></i></a>
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
                        <?php echo paging($total_rows, $per_page, site_url("admin/member_group/index"), $current_page, $show_number_page); ?>
                    </div>
                </div><!-- /.box -->
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add/Edit</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="<?php echo base_url('admin/member_group/index/' . $current_page); ?>" name="form" id="form" method="POST">
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
                                <label>Title</label>
                                <input type="text" class="form-control" required="required" name="text_title" id="text_title" placeholder="Enter title">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" class="form-control" required="required" name="text_description" id="text_description" placeholder="Enter description">
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
            $("#form #text_title").val(row_item.find('.title').html());
            $("#form #text_description").val(row_item.find('.description').html());
            $("#form #id").val($(this).attr('data-id'));
        });
    });
</script>