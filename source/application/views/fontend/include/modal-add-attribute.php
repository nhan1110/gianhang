<div id="modal_add_attribute" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <input type="hidden" id="action" value="">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title"><strong>Thêm mới thuộc tính</strong></h3>
            </div>
            <div class="modal-body">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="box-add-attribute" data-category="<?php echo @$cat_type; ?>" data-group="null">
                            <div id="box-add">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <p><label>Tên Thuộc Tính Khởi Tạo:</label></p>
                                        <input type="text" id="name-attribute" class="form-control" data-add="attribute" placeholder="Tên Thuộc Tính" autocomplete="on">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <input type="checkbox" id="required-field-attr" class="required-field" value="1">
                                            <label for="required-field-attr"><span>Là Thuộc Tính Bắt Buộc.</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row"> 
                                    <div class="col-md-12">
                                        <p><label>Thể Loại Thuộc Tính:</label></p>
                                        <select id="attribute-type" class="form-control" disabled="">
                                            <option class="default" value="0" selected="">—— Chọn Thể Loại Thuộc Tính ——</option>
                                            <option value="text">Text Filed</option>
                                            <option value="textarea">Text Area Filed</option>
                                            <option value="number">Number Filed</option>
                                            <option value="date">Date Filed</option>
                                            <option value="select">Select</option>              
                                            <option value="multipleradio">Multiple radio</option>
                                            <option value="multipleselect">Multiple select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="box-required">
                                        <div class="data-grup-required">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Số kí tự ít nhất:</label>
                                                    <input type="text" class="form-control required-value" placeholder="Giá trị">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Số kí tự nhiều nhất:</label>
                                                    <input type="text" class="form-control required-value" placeholder="Giá trị">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-default-values">
                                    <p class="title-defaut"><label>Giá Trị Mặc Định Của <span class="name">Thuộc Tính</span></label></p>
                                    <div class="box-items">
                                        <div class="item relative">
                                            <div class="form-group"> 
                                                <input class="default-values form-control" type="text" placeholder="Tên Giá Trị Mặc Định">
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-right"><button class="btn btn-default" id="add-item">Thêm </button></p>
                                </div>
                                <div class="form-group row"> 
                                    <div class="col-md-12"><button id="save-attribute" data-type="attribute" class="btn btn-success relative" disabled="">Khởi Tạo</button></div>
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