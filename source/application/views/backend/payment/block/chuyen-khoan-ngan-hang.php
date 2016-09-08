<div class="form-group">
    <label for="merchant-id">Merchant ID: </label>
    <input type="text" data-required="true" data-validate = "true" class="form-control" id="merchant-id" name="setting[merchant-id]" value="<?php echo @$setting["merchant-id"];?>" placeholder="Tên ngưởi gửi">
</div>
<div class="form-group">
    <label for="merchant-accesscode">Merchant AccessCode</label>
    <input type="text" data-required="true" data-validate = "true" name="setting[merchant-accesscode]" class="form-control" id="merchant-accesscode" value="<?php echo @$setting["merchant-accesscode"];?>" placeholder="Merchant AccessCode">
</div>
<div class="form-group">
    <label for="hash-code">Hash Code</label>
    <input type="text" data-required="true" data-validate = "true" name="setting[hash-code]" class="form-control" id="hash-code" value="<?php echo @$setting["hash-code"];?>" placeholder="Merchant AccessCode">
</div>
