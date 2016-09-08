<div class="form-group">
    <label for="from-name">Ngân Lượng Merchant ID: </label>
    <input type="text" data-required="true" data-validate = "true" class="form-control" id="from-name" name="setting[merchant_id]" value="<?php echo @$setting["merchant_id"];?>" placeholder="Ngân Lượng Merchant ID">
</div>
<div class="form-group">
    <label for="from-mail">Merchant Password: </label>
    <input type="text" data-required="true" data-validate = "true" name="setting[merchant_password]" class="form-control" id="from-mail" value="<?php echo @$setting["merchant_password"];?>" placeholder="Merchant Password">
</div>
<div class="form-group">
    <label for="from-mail">Receiver Email: </label>
    <input type="text" data-required="true" data-validate = "true" name="setting[receiver_email]" class="form-control" id="from-mail" value="<?php echo @$setting["receiver_email"];?>" placeholder="Receiver Email">
</div>
