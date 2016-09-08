<div id = "price-parent-block" class = "tab-pane fade in price">
    <div class = "col-md-12 add-product ">
        <fieldset>
            <legend>Loại Hình (*)</legend>
            <div class = "form-group">
                <?php $disabled = "disabled"; ?>
                <select name="price[type_price]" class = "form-control" id="price-type">
                    <?php if (isset(@$price)): ?>
                        <?php if (@$price["Is_Main"] == 0 || @$price["Is_Main"] == "0") { ?>
                            <option value="0" selected>Liên Hệ</option>
                            <option value="1">Giá Xác Định</option>
                        <?php } else { ?>
                            <option value="0" >Liên Hệ</option>
                            <option value="1" selected>Giá Xác Định</option>
                            <?php $disabled = ""; ?>
                        <?php } ?>
                    <?php else: ?>
                        <option value="0">Liên Hệ</option>
                        <option value="1">Giá Xác Định</option>
                    <?php endif; ?>
                </select>
            </div>  
        </fieldset>
        <fieldset>
            <legend>Giá (*)</legend>
            <div class = "form-group">
                <div class="input-group"> <span class="input-group-addon">VND</span> 
                    <?php if (isset(@$price)) { ?>
                        <?php if (@$price["Is_Main"] == 0 || @$price["Is_Main"] == "0") { ?>
                            <input type = "number" data-min = "1" value="<?php echo (isset(@$price["Price"]) && @$price["Price"] != 0) ? @$price["Price"] : "" ?>" class = "form-control" id = "price_product" placeholder = "Giá(VND)" <?php echo $disabled; ?>> 
                        <?php } else { ?>
                            <input type="number" data-min="1" value="<?php echo (isset(@$price["Price"]) && @$price["Price"] != 0) ? @$price["Price"] : "" ?>" class="form-control" id="price_product" placeholder="Giá(VND)" name="price[price_product]" data-validate="true" data-required="true">
                        <?php } ?>
                    <?php }else {?>
                        <input type = "number" data-min = "1" value="" class = "form-control" id = "price_product" placeholder = "Giá(VND)" <?php echo $disabled; ?>> 
                    <?php }?>
                </div> 
            </div>     
        </fieldset>
    </div>
</div>