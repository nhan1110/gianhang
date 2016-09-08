<div class="row"> 

    <div class="col-md-8 add-product">

        <div class="panel panel-default">

            <div class="panel-heading"><strong>Thuộc tính liên quan</strong></div>

            <div class="panel-body">

                <div id="box-tree-attribute" class="tree_ui">

                    <?php echo isset($tree_attr) ? $tree_attr : '<ul id="tree_attr" class="list-group"></ul>'; ?>

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="panel panel-default" for-top=".main-header">

            <div class="panel-heading"><strong>Thêm mới nhóm thuộc tính</strong></div>

            <div class="panel-body">

                <div id="box-main">

                    <div class="box-add-attribute-group" data-category="<?php echo @$cat_type; ?>" data-group="null">

                        <div id="box-add">

                            <div class="form-group row">

                                <div class="col-md-12">

                                    <p>Tên nhóm:</p>

                                    <input type="text" id="name-attribute-group" class="form-control not-null" data-add="attribute-group" placeholder="Tên nhóm" autocomplete="on">

                                    <input type="hidden" id="category-type" value="<?php echo @$cat_type; ?>">

                                </div>

                            </div> 

                            <div class="form-group row"> 

                                <div class="col-md-12 text-right"><button href="#" id="save-attribute-group" class="btn btn-success relative controller" disabled="">Khởi Tạo</button></div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



    </div>

</div>

