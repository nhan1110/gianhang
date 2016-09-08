<div id = "add-new-group-parent-block" class = "tab-pane fade in">
    <?php if (isset($tabs_not_show)): ?>
        <div class = "col-md-6 add-product add-product" id = "content-left">
            <div class="panel panel-default">
                <div class="panel-heading"><p>Thêm tabs mới</p></div>
                <div class="panel-body">
                    <div class = "form-group row">
                        <label for = "name" class = "col-sm-3">Tên Tabs Mới:</label>
                        <div class = "col-sm-9">
                            <div class="row">     
                                <div class="col-md-12 form-group"><input type = "text" class = "form-control" data-validation = "true" id = "name-group" placeholder = "Tên Tabs"></div>
                            </div>
                        </div>
                    </div>
                    <div class = "form-group row">
                        <label for = "name" class = "col-sm-3">Sắp Xếp:</label>
                        <div class = "col-sm-9">
                            <div class="row">     
                                <div class="col-md-12 form-group"><input type = "number" value ="0" min="0" class = "form-control"  id = "sort" placeholder = "Sắp Xếp"></div>
                            </div>
                        </div>
                    </div>
                    <div class = "form-group row">
                        <div class="col-md-12 form-group text-right"><button href="#" id="add-tabs-new" class="btn btn-success relative" data-category ="<?php echo @$category_type_slug; ?>">Khởi Tạo</button></div>
                    </div>
                </div>
            </div>
        </div>
        <div class = "col-md-6 add-product add-product" id = "content-left">
            <div class="panel panel-default">
                <div class="panel-heading"><p>Thêm tabs có sẳn</p></div>
                <div class="panel-body">

                    <div class = "form-group row">
                        <div class="col-md-12 form-group text-right"><button href="#" id="add-tabs-new" class="btn btn-success relative" data-category ="<?php echo @$category_type_slug; ?>">Thêm</button></div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class = "col-md-10 add-product cented add-product" id = "content-left">
            <fieldset>
                <legend>Tên Tabs Mới:</legend>
                <div clas="form-group">
                    <input type = "text" class = "form-control" id = "name-group" placeholder = "Tên Tabs">
                </div>
            </fieldset>
            <fieldset>
                <legend>Sắp Xếp:</legend>
                <div clas="form-group">
                    <input type = "number" value ="0" min="0" class = "form-control"  id = "sort" placeholder = "Sắp Xếp">
                </div>
            </fieldset>
            <div class = "form-group row">
                <div class="col-md-12 form-group text-right"><button href="#" id="add-tabs-new" class="btn btn-success relative" data-category ="<?php echo @$category_type_slug; ?>">Khởi Tạo</button></div>
            </div>
        </div>
    <?php endif ?>
</div>
