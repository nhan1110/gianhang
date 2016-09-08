<div id="modal_add_attribute_child" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <input type="hidden" id="action" value="">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title"><strong>Thêm mới thuộc tính con</strong></h3>
            </div>
            <div class="modal-body">
                <div class="panel panel-default">
                    <div class="panel-body" id="box-main">
                        <div class="box-add-attribute" data-category="<?php echo @$cat_type; ?>" data-group="null">
                            <div id="box-add">
                                <div class="box-default-values">
                                    <p class="title-defaut">Giá Trị Mặc Định Của <span class="name">Thuộc Tính</span></p>
                                    <div class="box-items">
                                        <div class="item relative">
                                            <div class="form-group"> 
                                                <input class="default-values form-control not-null" type="text" placeholder="Tên Giá Trị Mặc Định">
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-right"><button class="btn btn-default" id="add-item">Thêm </button></p>
                                </div>
                                <div class="form-group row"> 
                                    <div class="col-md-12"><button id="save-attribute-child" class="btn btn-success controller relative" disabled="">Khởi Tạo</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<style>
    #modal_add_attribute .checkbox label, .radio label{padding-left:0;}
</style>