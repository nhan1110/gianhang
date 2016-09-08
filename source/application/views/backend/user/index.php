<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Users <a class="btn btn-primary" href="<?php echo site_url('admin/users/index/?action=add'); ?>">Add New</a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard/'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="active">Users</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
        	<div class="col-lg-12 col-sm-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add/Edit</h3>
        				<a class="toggle-button float-right" data-toggle="collapse" data-target="#form">Toggle</a>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="<?php echo $url_form; ?>" class="collapse<?php echo ($action) ? " in" : ""; ?>" name="form" id="form" method="POST">
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
                            <div class="row">
                            	<div class="col-lg-6 col-sm-6">
                            		<div class="form-group">
		                                <label>Role</label>
		                                <?php echo select_option($group, @$post['role'], '', ' class="form-control" id="role" name="role" '); ?>
		                            </div>
		                            <div class="form-group">
		                                <label>Nick</label>
		                                <input type="text" class="form-control" required="required" value="<?php echo @$post['user_nick']; ?>" name="user_nick" id="user_nick" placeholder="Enter Nick">
		                            </div>
		                            <div class="form-group">
		                                <label>Name</label>
		                                <input type="text" class="form-control" required="required" value="<?php echo @$post['user_name']; ?>" name="user_name" id="user_name" placeholder="Enter Name">
		                            </div>
		                            <div class="form-group">
		                                <label>Email</label>
		                                <input type="email" class="form-control" required="required" value="<?php echo @$post['user_email']; ?>" name="user_email" id="user_email" placeholder="Enter Email">
		                            </div>
                            	</div>
                            	<div class="col-lg-6 col-sm-6">
                            		<div class="form-group">
				                        <label>Avatar</label>
				                        <input type="hidden" id="xImagePath" name="ImagePath"  value="<?php echo @$post['ImagePath']; ?>" type="text" size="60" class="form-control" />
				                        <img src="<?php echo @$post['ImagePath']; ?>" style="display:<?php echo ($addnew || empty($post['ImagePath'])) ? 'none' : '';  ?>;" id="xImagePathClient" width="100px" />
				                        <input type="button" value="Browse Server" onclick="BrowseServer( 'xImagePath' );" />
				                        <input type="button" value="Remove File" onclick="ClearFile( 'xImagePath' );" />
				                    </div>
		                            <div class="form-group">
		                                <label>Password</label>
		                                <input type="password" class="form-control" <?php if ($addnew) : ?> required="required" <?php endif; ?> name="user_pwd" id="user_pwd" placeholder="Enter Password">
		                            </div>
		                            <div class="form-group">
		                                <label>Confirm</label>
		                                <input type="password" class="form-control" <?php if ($addnew) : ?> required="required" <?php endif; ?> name="user_confirm" id="user_confirm" placeholder="Enter Confirm Password">
		                            </div>
		                            <div class="form-group">
		                                <label>Status</label>
		                                <?php echo select_option(array('0' => 'no', '1' => 'yes'), @$post['user_status'], '0', ' class="form-control" id="user_status" name="user_status" '); ?>
		                            </div>
                            	</div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Collections</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered" id="data-grid">
                            <tr>
                                <th style="width: 5%">#</th>
                                <th><?php echo $this->lang->line('admin_nick'); ?></th>
                                <th><?php echo $this->lang->line('admin_email'); ?></th>
        						<th><?php echo $this->lang->line('admin_status'); ?></th>
        						<th><?php echo $this->lang->line('admin_createdat'); ?></th>
                                <th style="width: 10%"><?php echo $this->lang->line('admin_role_grid_action'); ?></th>
                            </tr>
                            <?php if (isset($collections) && count($collections) > 0) : 
                                $i = 0;
                                foreach ($collections as $item) : $i++;
                                ?>
                                <tr class="row-item">
                                    <td><?php echo $i;?>.</td>
                                    <td class="user_nick"><?php echo $item->User_Nick; ?></td>
                                    <td class="user_email"><?php echo $item->User_Email; ?></td>
                                    <td class="user_status"><?php echo $item->User_Status; ?></td>
                                    <td class="createdat"><?php echo $item->Createdat; ?></td>
                                    <td class="action">
                                        <a class="edit" title="Edit" data-id="<?php echo $item->ID; ?>" href="<?php echo site_url('admin/users/index/?id=' . $item->ID); ?>"><i class="fa fa-edit"></i></a>&nbsp;
                                        <a class="delete" title="Delete" data-id="<?php echo $item->ID; ?>" href="<?php echo base_url('admin/users/delete/' . $item->ID); ?>" onclick="return confirm('Do you want to delete');"><i class="fa fa-close"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; endif; ?>
                            </div>
                        </table>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <?php echo paging($total_rows, $per_page, site_url("admin/user/index"), $current_page, $show_number_page); ?>
                    </div>
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
        $('#addnew').click(function () {
        	$("#form")[0].reset();
        });
    });
</script>

<script type="text/javascript" src="<?php echo skin_url('js/ckfinder/ckfinder_v1.js'); ?>"></script>
<script type="text/javascript">
function BrowseServer( inputId )
{
    var finder = new CKFinder() ;
    finder.BasePath = '<?php echo skin_url('js/ckfinder/'); ?>';
    finder.SelectFunction = SetFileField ;
    finder.SelectFunctionData = inputId ;
    finder.Popup() ;
}

function ClearFile( inputId )
{
    document.getElementById( inputId ).value = '' ;
    document.getElementById( inputId + "Client" ).src = '' ;
    document.getElementById( inputId + "Client" ).style.display = 'none' ;
}

function SetFileField( fileUrl, data )
{
    document.getElementById( data["selectActionData"] ).value = fileUrl ;
    document.getElementById( data["selectActionData"] + "Client" ).src = fileUrl ;
    document.getElementById( data["selectActionData"] + "Client" ).style.display = '' ;
}
</script>