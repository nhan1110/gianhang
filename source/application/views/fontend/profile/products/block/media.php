<div id = "media-parent-block" class = "tab-pane fade in media">
    <div class = "col-md-12 add-product" id = "content-left">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Hình Ảnh Đại Diện (*)</div>
                    <div class="panel-body relative show_error">
                        <div id="wrapp-box" class="box-featured">
                            <div class="box">
                                <div class="change-image set-image" data-multiple="false"><i class="fa fa-edit"></i></div>
                                <div class="product-image" id="box-featured" data-multiple="false">                      		
                                    <div id="box-photos">
                                        <?php
                                        if (isset($thumbnail) && is_array($thumbnail) && count($thumbnail) > 0):
                                            echo '<div class="item relative"><span id="remove-img" data-id="' . $thumbnail["ID"] . '"><i class="fa fa-trash-o"></i></span><img src="' . $thumbnail["Path_Thumb"] . '" id="select" data-id="' . $thumbnail["ID"] . '"></div>';
                                        endif;
                                        ?>
                                    </div>    
                                </div>	
                                <input type="hidden" class="file-media" data-required="true" data-validate = "true" for=".show_error" name="media[featured]" value="<?php echo @$thumbnail["ID"]; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Hình Ảnh Liên Quan</div>
                    <div class="panel-body">
                        <div id="wrapp-box"> 
                            <div class="list-photos" id="box-photos">
                                <div class="row">
                                    <div id="not-image">
                                        <h3 class="text-center">Tất Cả Hình Ảnh Đã Chọn</h3>
                                        <h2 class="text-center"><a href="#" class="btn btn-default set-image" data-multiple="true">Chọn Ảnh</a></h2>
                                    </div>
                                </div>
                                <?php
                                $media_active = "";
                                if (isset($media_activer) && is_array($media_activer)):
                                    foreach ($media_activer as $key => $value) {
                                        $media_active.= $value["ID"] . ",";
                                        echo '<div class="item relative"><span id="remove-img" data-id="' . $value["ID"] . '"><i class="fa fa-trash-o"></i></span><img src="' . $value["Path_Thumb"] . '" id="select" data-id="' . $value["ID"] . '"></div>';
                                    }
                                endif;
                                ?>
                                <input type="hidden" class="file-media" name="media[list_photos]" value="<?php echo $media_active; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>