<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Rule
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard/'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="active">Rule</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Collections</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
        				<form method="POST" action="" id="form-rule">
                        <table class="table table-bordered" id="data-grid">
                            <tr>
                                <th>Module Name</th>
                                <th class="text-center">View</th>
                                <th class="text-center">Approve</th>
                                <th class="text-center">Add</th>
                                <th class="text-center">Update</th>
                                <th class="text-center">Delete</th>
                            </tr>
        					<?php echo $category; ?>
                        </table>
        				</form>
                    </div><!-- /.box-body -->
        			<div class="box-footer with-border">
                        <button type="submit" class="btn btn-save btn-primary" id="btn-save">Update</button>
        				<button type="button" class="btn btn-cancel" id="btn-cancel">Cancel</button>
                        <span class="image-load" style="display:none;"><img style="width:15px;" src="/skins/images/loading.gif"></span>
                    </div><!-- /.box-header -->
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<style>input[type="checkbox"] {display:inline-block;}</style>

<script>
$(document).ready(function() {
    /*Update position menu item*/
    $('#btn-save').click(function() {
        $('.box-footer .image-load').show();
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: base_admin_url + 'role/update_rule/?id=<?php echo $role_id; ?>',
            data: $('#form-rule').serialize(),
            success: function(data) {
            	console.log(data);
                if (data == 'error') {
					
                }
            },
            complete: function() {
                $('#btn-save').removeAttr('disabled');
                $('.box-footer .image-load').hide();
                location.reload();
            }
        });
        return false;
    });
    
    $('#data-grid input[type="checkbox"]').click(function() {
    	var val = $(this).val();
    	var parent = $(this).attr('data-parent');
    	var name = $(this).attr('name');
    	var current_status = $(this).prop('checked');
    	if (parent == 0) { // Root level
    		// Finde child level
    		var size = $('input[name="'+name+'"][data-parent="'+val+'"]').length;
    		$('input[name="'+name+'"][data-parent="'+val+'"]').prop('checked', current_status);
    	} else { // Set checked for parent
    		var size = $('input[name="'+name+'"][data-parent="'+parent+'"]').length;
    		var size_checked = $('input[name="'+name+'"][data-parent="'+parent+'"]:checked').length;
    		var status = (size_checked < size) ? false : true;
    		// console.log(size + '===' + size_checked);
    		$('input[name="'+name+'"][value="'+parent+'"]').prop('checked', status);
    	}
    });
    
    
});
</script>