<div id = "general-parent-block" class = "tab-pane fade in active general">
    <div class = "col-md-12 add-product" id = "content-left">
        <fieldset>
            <legend>Tên sản phẩm (*)</legend>
            <div clas ="form-group">
                <input type = "text" value="<?php echo @str_replace('"', "&quot;", $product["Name"]); ?>" class = "form-control" data-required="true" data-validate = "true"  name = "general[name]" id = "name" placeholder = "Tên Sản Phẩm">
            </div>
        </fieldset>
        <fieldset>
            <legend>Mô tả sản phẩm</legend>
            <div class = "form-group">
                <textarea class = "form-control" name = "general[description]" placeholder = "Mô Tả Sản Phẩm"><?php echo @$product["Description"] ?></textarea>
            </div>
        </fieldset>
        <fieldset>
            <legend>Mô tả chi tiết sản phẩm</legend>
            <div class = "form-group ">
                <textarea class = "form-control" id = "content" name = "general[content]" rows = "8" placeholder = "Mô Tả Chi Tiết Sản Phẩm"><?php echo @$product["Content"] ?></textarea>
            </div>
        </fieldset>
        <fieldset>
            <legend>Keyword</legend>
            <div class = "form-group ">
                <ul id = "keyword">
                    <?php
                    if (isset($keywords) && is_array($keywords)) {
                        foreach ($keywords as $key => $value) {
                            echo "<li>" . $value["Name"] . "</li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </fieldset>
        <fieldset id="gruop-address-product">
            <legend>Địa chỉ sản phẩm</legend>
            <div class = "form-group row">
                <div class="col-md-12">
                    <p>Tỉnh, thành phố</p>
                    <select name ="address[city]" id="product_city" class = "form-control"> 
                        <option value="{[-]}" id="default">- Lựa chọn -</option>
                        <?php
                        if (isset($city) && is_array($city)) {
                            foreach ($city as $key => $value) {
                                if (isset($city_activer) && $value["ID"] == $city_activer) {
                                    echo '<option value="' . $value["ID"] . '" selected >' . $value["Levels"] . " " . $value["Name"] . '</option>';
                                } else {
                                    echo '<option value="' . $value["ID"] . '" >' . $value["Levels"] . " " . $value["Name"] . '</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class = "form-group row ">
                <div class="col-md-6">
                    <p>Quận, huyện</p>
                    <select name ="address[districts]" id="product_districts" class = "form-control" disabled> 
                        <option value="{[-]}" id="default">- Lựa chọn -</option>
                        <?php
                        if (isset($districts_arg) && is_array($districts_arg)) {
                            foreach ($districts_arg as $key => $value) {
                                if (isset($districts_activer) && $value["ID"] == $districts_activer) {
                                    echo '<option value="' . $value["ID"] . '" selected >' . $value["Levels"] . " " . $value["Name"] . '</option>';
                                } else {
                                    echo '<option value="' . $value["ID"] . '" >' . $value["Levels"] . " " . $value["Name"] . '</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <p>Quân, huyện khác</p>
                    <input type="text" name ="address[districts_new]" id="product_districts_new" class = "form-control" disabled/>   
                </div>
            </div>
            <div class = "form-group row">
                <div class="col-md-6">
                    <p>Phường, xã</p>
                    <select name ="address[wards]" id="product_wards" class = "form-control" disabled> 
                        <option value="{[-]}" id="default">- Lựa chọn -</option>
                        <?php
                        if (isset($wards_arg) && is_array($wards_arg)) {
                            foreach ($wards_arg as $key => $value) {
                                if (isset($wards_activer) && $value["ID"] == $wards_activer) {
                                    echo '<option value="' . $value["ID"] . '" selected >' . $value["Levels"] . " " . $value["Name"] . '</option>';
                                } else {
                                    echo '<option value="' . $value["ID"] . '" >' . $value["Levels"] . " " . $value["Name"] . '</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <p>Phường, xã khác</p>
                    <input type="text" name ="address[wards_new]" id="product_wards_new" class = "form-control" disabled/>   
                </div>
            </div>
            <?php if(isset($page_product)&& $page_product == "add") :?>
            <div class="form-group row" id="save-address">
                <div class="checkbox"><input type="checkbox" id="save-address-input" class="custom" value="1" name="address[save]" checked><label for="save-address-input"><span>Bạn có muốn lưu địa chỉ này cho sản phẩm sau không ?<span></span></span></label></div>
            </div>
            <?php endif;?>
        </fieldset>
    </div>

</div>
