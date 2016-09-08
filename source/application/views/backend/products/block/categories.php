<div id = "categories-parent-block" class = "tab-pane fade in">
    <div class = "col-md-12 add-product" id = "content-left">
        <div id="wrapp-box">
            <div class="row">
                <div class="col-md-7">
                    <div class="panel panel-default">
                        <div class="panel-heading">Tất Cả Các Danh Mục Liên Quan (* vui lòng chọn ít nhất một loại danh muc)</div>
                        <div class="panel-body">
                            <div class="box" id="box-show-category">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Tìm Kiếm" id="srch-term">
                                    <div class="input-group-btn">
                                        <a class="btn btn-default"><i class="glyphicon glyphicon-search"></i></a>
                                    </div>
                                </div>
                                <div class="box-category" data-required="true" data-validate = "true" data-group= 'true' for="#category">
                                    <?php
                                    if (isset($cat_tree) && trim($cat_tree) != "") {
                                        echo $cat_tree;
                                    } else {
                                        echo '<ul class="list no-list-style box-select" data-id="0" id="category"></ul>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">Tạo Mới Danh Mục Sản Phẩm</div>
                        <div class="panel-body" id="box-main">
                            <div id="box-add">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <p>Tên Danh Mục Khởi Tạo:</p>
                                        <input type="text" id="add-method" class="form-control not-null" data-add="category" placeholder="Tên Danh Mục">
                                    </div>
                                </div>
                                <div class="form-group row"> 
                                    <div class="col-md-12">
                                        <select id="newcategory_parent" class="form-control">
                                            <option  class="default" value="0" selected>—— Chọn Danh Mục Cha ——</option> 
                                            <?php if (isset($select_cat)) echo $select_cat; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row"> 
                                    <div class="col-md-12"><button id="add-button" disabled class="btn btn-success relative controller">Khởi Tạo</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
