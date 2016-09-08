 <div class="site-main">
    <div class="content-top light">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <ul class="nav-step">
                        <li class="step-item active">
                            <a href=""><span class="step-counter">1.</span> Danh mục</a>
                        </li>
                        <li class="step-item">
                            <a href=""><span class="step-counter">2.</span> Nội dung</a>
                        </li>
                        <li class="step-item">
                            <a href=""><span class="step-counter">3.</span> Thuộc tính</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-5 nav-buttons">
                    <button class="btn btn-primary">Lưu</button>
                    <button class="btn btn-secondary">Tiếp tục</button>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">

            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4>Oh snap! You got an error!</h4>
                <p>Change this and that and try again. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum.</p>
            </div>

            <div id="add-product-step-1">
                <div class="panel">
                    <div class="panel-body">
                        <label>Loại Hình Của Sản Phẩm</label>
                        <div class="form-group">
                            <select class="selectpicker" data-style="btn-transparent-dark">
                                <option>Tất cả danh mục</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div id="add-product-step-2" class="row">
                <div class="col-md-3">
                    <div class="sidebar sidebar-section">
                        <ul class="list-group list-group-links">
                            <li class="list-group-item active"><a href="">Tổng quát</a></li>
                            <li class="list-group-item"><a href="">Giá</a></li>
                            <li class="list-group-item"><a href="">Hình ảnh</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Tổng quát</h3>
                        </div>
                        <div class="panel-body">

                            <div class="form-group limited">
                                <label>Tên Sản Phẩm</label>
                                <input type="text" value="" class="form-control" data-required="true" data-validate="true" name="general[name]" id="name" placeholder="Tên Sản Phẩm">
                            </div>

                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea class="form-control" name="general[description]" placeholder="Mô Tả Sản Phẩm"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Từ khóa</label>
                                <input type="text" value="" class="form-control" data-required="true" data-validate="true" name="general[name]" id="name" placeholder="Tên Sản Phẩm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/.site-main-->