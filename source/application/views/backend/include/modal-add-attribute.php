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
                                        <p><label>Tên thuộc tính khởi tạo:</label></p>
                                        <input type="text" id="name-attribute" class="form-control" data-add="attribute" placeholder="Tên thuộc tính" autocomplete="of">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <input type="checkbox" id="required-field-attr" class="required-field" value="1">
                                            <label for="required-field-attr"><span>Là thuộc tính bắt buộc:</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row"> 
                                    <div class="col-md-12">
                                        <p><label>Là thuộc tìm kiếm:</label></p>
                                        <select id="show-search" class="form-control">
                                            <option class="default" value="0" selected="">—— Chọn một loại ——</option>
                                            <option value="1">Có</option>
                                            <option value="0">Không</option>
                                    	</select>
                                    </div>
                                </div>
                                <div class="form-group row"> 
                                    <div class="col-md-12">
                                        <p><label>Thể loại thuộc tính:</label></p>
                                        <select id="attribute-type" class="form-control" disabled="">
                                            <option class="default" value="0" selected="">—— Chọn thể loại thuộc tính ——</option>
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
                                <div class="row">
                                    <div id="box-required">
                                        <div class="data-grup-required">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Số kí tự ít nhất:</label>
                                                    <input type="number" class="form-control" placeholder="Giá trị">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Số kí tự nhiều nhất:</label>
                                                    <input type="number" class="form-control" placeholder="Giá trị">
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
                                    <p class="text-right"><button class="btn btn-default" id="add-item">Thêm </button> Hoặc đưa nhiều giá trị vào text bên dưới</p>
    								<textarea name="multivalue" id="multivalue" rows="5" class="form-control"></textarea>
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
                                    <div class="col-md-12"><button id="save-attribute" data-type="attribute" class="btn btn-success relative" disabled="">Khởi tạo</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    #modal_add_attribute .checkbox label, .radio label{padding-left:0;}
</style>