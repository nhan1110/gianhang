<div id="modal-edit-attribute" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <input type="hidden" id="action" value="">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title"><strong>Cập nhật thuộc tính</strong></h3>
            </div>
            <div class="modal-body">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="box-add-attribute" id="box-main" data-category="<?php echo @$cat_type; ?>" data-group="null">
                            <div id="box-add">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <p><label>Tên thuộc tính cập nhật:</label></p>
                                        <input type="text" id="name-attribute" class="form-control not-null" data-add="attribute" placeholder="Tên thuộc tính" autocomplete="of">
                                    </div>
                                </div>
                                <div class="form-group row"> 
                                    <div class="col-md-12">
                                        <p><label>Thể loại thuộc tính cập nhật:</label></p>
                                        <select id="attribute-type" class="form-control">
                                            <option value="text">Text filed</option>
                                            <option value="textarea">Text area filed</option>
                                            <option value="number">Number filed</option>
                                            <option value="date">Date filed</option>
                                            <option value="select">Select</option>              
                                            <option value="multipleradio">Multiple radio</option>
                                            <option value="multipleselect">Multiple select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <input type="checkbox" id="required-field-edit-attr" class="required-field" value="1">
                                            <label for="required-field-edit-attr"><span>Là thuộc tính bắt buộc.</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="show_search_box"> 
                                    <p><label>Là thuộc tìm kiếm:</label></p>
                                    <select id="show-search" class="form-control">
                                        <option class="default" value="0" selected="">—— Chọn một loại ——</option>
                                        <option value="1">Có</option>
                                        <option value="0">Không</option>
                                    </select>
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
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <p><label>Đơn vị tính:</label></p>
                                        <input type="text" id="unit" class="form-control" placeholder="Đơn vị(km, lg, l...)" autocomplete="of">
                                    </div>
                                </div>
                                <div class="messenger_error_box">
                                    <div class="form-group"> 
                                        <label>Câu thông báo khi gặp lỗi:</label>
                                        <textarea id="messenger_error" class="form-control" placeholder="Messenger error "></textarea>
                                    </div>
                                </div>
                                <div class="form-group row"> 
                                    <input type="hidden" id="id-attribute" name="id-attribute">
                                    <input type="hidden" id="attribute-type" name="attribute-type">
                                    <div class="col-md-12"><button id="update-attribute" data-type="attribute" class="btn controller btn-success relative">Cập nhật</button></div>
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
    #modal-edit-attribute .checkbox label, .radio label{padding-left:0;}
</style>