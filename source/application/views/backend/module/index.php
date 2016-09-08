<link rel="stylesheet" href="<?php echo skin_admin_url('dist/css/menu.css'); ?>" />
<script src="<?php echo skin_admin_url('dist/js/module.js'); ?>"></script>
<script src="<?php echo skin_admin_url('dist/js/jquery.1.4.1.min.js'); ?>"></script>
<script src="<?php echo skin_admin_url('dist/js/interface-1.2.js'); ?>"></script>
<script src="<?php echo skin_admin_url('dist/js/inestedsortable.js'); ?>"></script>
<div class="content-wrapper">
    <div class="col-sm-12 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('admin/dashboard/'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
                <li class="active">Module</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-9 col-sm-12">
                                <div class="ns-row" id="ns-header">
                                    <div class="ns-actions">Actions</div>
    								<div class="ns-url">Url</div>
                                    <div class="ns-title">Title</div>
                                </div>
                                <?php
                                if (isset($category) && $category != null) {
                                    echo $category;
                                } else {
                                    echo '<ul id="easymm"></ul>';
                                }
                                ?>
                                <div id="ns-footer">
                                    <button type="submit" disabled="disabled" class="btn btn-save btn-primary" id="btn-save-menu">Update Sort</button>
                                    <span class="image-load" style="display:none;"><img style="width:15px;" src="/skins/images/loading.gif"></span>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="box">
                                    <h3>Create Item</h3>
                                    <div id="form-add-menu">
                                        <div class="form-group">
                                            <label for="exampleInputName2">Name</label>
                                            <input type="text" class="form-control" id="add-title" required="required" />
                                        </div>
                                    	<div class="form-group">
                                            <label for="exampleInputName2">Key</label>
                                            <input type="text" class="form-control" id="add-key" required="required" />
                                        </div>
                                    	<div class="form-group">
                                            <label for="exampleInputName2">Url</label>
                                            <input type="text" class="form-control" id="add-url" required="required" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName2">Class <i id="show-class" class=""></i></label>
                                            <input type="text" class="form-control" id="add-class" required="required" />
                                            <select id="select-class" class="form-control">
                                                <option value=""> -- Select -- </option>
                                                <option value="fa fa-table">fa fa-table</option>
                                                <option value="fa fa-folder">fa fa-folder</option>
                                                <option value="fa fa-edit">fa fa-edit</option>
                                                <option value="fa fa-share">fa-share</option>
                                                <option value="fa fa-envelope">fa-envelope</option>
                                                <option value="fa fa-link">fa-link</option>
                                                <option value="fa fa-leanpub">fa-leanpub</option>
                                                <option value="fa fa-list-ul">fa-list-ul</option>
                                                <option value="fa fa-dashboard">fa-dashboard</option>
                                                <option value="fa fa-globe">fa-globe</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button id="add-menu" type="submit" class="btn btn-primary">Save</button>
                                    		<input type="hidden" id="id" name="id" value="" />
                                            <span class="image-load" style="display:none;"><img style="width:15px;" src="/skins/images/loading.gif"></span>
                                        </div>
                                    </div>
                                </div><!--end box -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .box {
        border: 1px solid #e5e5e5;
        background: #fafafa;
        margin-bottom: 10px;
        max-width: 100%;
        width: 100%;
        padding: 0 20px;
        margin-top: 0px;
    }
    .form-group label{
        font-weight: 0;
    }
    .border-error{
        border: 1px solid red !important;
    }
    .box-add-menu{
        height: 180px;
        overflow-y: scroll;
        border: 1px solid #ccc;
        padding: 15px 0;
        margin-bottom: 10px;
        background: #fff;
    }
    .list-item,
    .list-item ul{
        list-style: none;
        padding-left: 20px;
    }
    .list-item li a{
        display: block;
        margin-bottom: 5px;
        font-size: 16px;
    }
</style>

<script>

$(document).ready(function() {
    var menu_serialized;
    var fixSortable = function() {
        if (!$.browser.msie) return;
        //this is fix for ie
        $('#easymm').NestedSortableDestroy();
        $('#easymm').NestedSortable({
            accept: 'sortable',
            helperclass: 'ns-helper',
            opacity: .8,
            handle: '.ns-title',
            onStop: function() {
                fixSortable();
            },
            onChange: function(serialized) {
                menu_serialized = serialized[0].hash;
                $('#btn-save-menu').attr('disabled', false);
            }
        });
    };

    $('#easymm').NestedSortable({
        accept: 'sortable',
        helperclass: 'ns-helper',
        opacity: .8,
        handle: '.ns-title',
        onStop: function() {
            fixSortable();
        },
        onChange: function(serialized) {
            menu_serialized = serialized[0].hash;
            $('#btn-save-menu').attr('disabled', false);
        }
    });

    $('#select-class').change(function() {
        $('#add-class').val($(this).val());
        $('#show-class').attr('class', $(this).val());
    });

    /*Update position menu item*/
    $('#btn-save-menu').click(function() {
        $('#ns-footer .image-load').show();
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: base_admin_url + 'module/update_position_action',
            data: menu_serialized,
            success: function(data) {
                if (data == 'true') {

                }
            },
            complete: function() {
                $('#btn-save-menu').removeAttr('disabled');
                $('#ns-footer .image-load').hide();
                location.reload();
            }
        });
        return false;
    });
});
</script>