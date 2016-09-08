<div class="form-group">
    <label for="from-name">Bảo Kim Merchant ID: </label>
    <input type="text" data-required="true" data-validate = "true" class="form-control" id="from-name" name="setting[merchant_id]" value="<?php echo @$setting["merchant_id"];?>" placeholder="Bảo Kim Merchant ID">
</div>
<div class="form-group">
    <label for="from-mail">Secure Password: </label>
    <input type="text" data-required="true" data-validate = "true" name="setting[secure_pass]" class="form-control" id="from-mail" value="<?php echo @$setting["secure_pass"];?>" placeholder="Secure Password">
</div>
<div class="form-group">
    <label for="from-mail">Email Business: </label>
    <input type="text" data-required="true" data-validate = "true" name="setting[business]" class="form-control" id="from-mail" value="<?php echo @$setting["business"];?>" placeholder="Email Business">
</div>
