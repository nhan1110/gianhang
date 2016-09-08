<div class="form-group">
    <label for="from-name">Paypal app Client ID: </label>
    <input type="text" data-required="true" data-validate = "true" class="form-control" id="from-name" name="setting[client-id]" value="<?php echo @$setting["client-id"];?>" placeholder="Client ID">
</div>
<div class="form-group">
    <label for="from-mail">Secret: </label>
    <input type="text" data-required="true" data-validate = "true" name="setting[secret]" class="form-control" id="from-mail" value="<?php echo @$setting["secret"];?>" placeholder="Secret">
</div>
