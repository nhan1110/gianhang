<link rel="stylesheet" href="<?php echo skin_url('admin/dist/css/menu.css'); ?>" />
<script type="text/javascript"> var group_id = "<?php echo $id; ?>";</script>
<script src="<?php echo skin_url('admin/dist/js/category.js'); ?>"></script>
<script src="<?php echo skin_url('admin/dist/js/jquery.1.4.1.min.js'); ?>"></script>
<script src="<?php echo skin_url('admin/dist/js/interface-1.2.js'); ?>"></script>
<script src="<?php echo skin_url('admin/dist/js/inestedsortable.js'); ?>"></script>
<script src="<?php echo skin_url('admin/dist/js/update-category.js'); ?>"></script>
<div class="content-wrapper">
    <div class="col-sm-12 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('admin/dashboard/'); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
                <li class="active">Category</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-9 col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul style="float: left;padding-left: 10px;width:100%;border-bottom: 5px solid #009900;" class="menu-tab-group" id="menu-group">
                                            <?php
                                            if (isset($category_type) && $category_type != null):
                                                foreach ($category_type as $value) :
                                                    $current = '';
                                                    if ($value->ID == $id) {
                                                        $current = 'class="current"';
                                                    }
                                                    echo '<li ' . $current . '><a href="'.base_url('admin/category/index/' . $value->ID).'" ><img class="edit-menu" data-id="'.$value->ID.'" data-toggle="modal" data-target="#editModal" title="Edit" src="' . skin_url('images/edit.png') . '" alt="Edit"> <span>' . $value->Name . '</span></a></li>';
                                                endforeach;
                                            endif;
                                            ?>
                                            <li id="add-group"><a data-toggle="modal" data-target="#addModal" href="#" title="Add Item">+</a></li>
                                        </ul>
                                    </div>
                                </div><!--end row-->

                                <div class="ns-row" id="ns-header">
                                    <div class="ns-actions">Actions</div>
                                    <div class="ns-url">Slug</div>
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
                                            <input type="text" class="form-control" id="add-title">
                                        </div>
                                        <div class="form-group">
                                            <button id="add-menu" type="submit" class="btn btn-primary">Save</button>
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

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Create item</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="menu" class="form-control" id="add-name" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-add-group">Save</button>
                <span class="image-load" style="display:none;"><img style="width:15px;" src="/skins/images/loading.gif"></span>
            </div>
        </div>
    </div>
</div>

<!--model chang menu item-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit item</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="title" class="form-control" id="edit-title">
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="class" class="form-control" id="edit-id">
                <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-edit">Save</button>
                <button type="button" class="btn btn-primary delete-menu">Delete</button>
                <span class="image-load" style="display:none;"><img style="width:15px;" src="/skins/images/loading.gif"></span>
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