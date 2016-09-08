<div class="form-group">
    <label for="from-name">Thứ tự hiển thị cổng thanh toán:</label>
    <table class="table table-bordered">
        <thead>
          <tr>
            <th>Cổng thanh toán</th>
            <th>ID cổng thanh toán</th>
            <th>Bật</th>
          </tr>
        </thead>
        <tbody>
          <?php if(isset($payments) && $payments != null):
            foreach ($payments as $key => $value) { 
                $active = "";?>
              <tr>
                <td><a href="<?php echo base_url("admin/payment/gateway/".$value["Slug"])?>"><?php echo $value["Title"];?></a></td>
                <td><?php echo $value["Slug"];?></td>
                <td>
                    <div class="checkbox">
                        <?php if( $value["Status"] == 1){
                            $active = "checked";
                        }?>
                        <input type="checkbox" id="payment-id-<?php echo $value["ID"];?>" class="set-active" value="<?php echo $value["ID"];?>" <?php echo $active;?>>
                        <label for="payment-id-<?php echo $value["ID"];?>"><span></span></label>
                    </div>
                </td>
              </tr>
          <?php }
           endif; ?>
        </tbody>
    </table>
</div>
<div class="form-group">
    <label for="from-name">Tên ngưởi gửi: </label>
    <input type="text" data-required="true" data-validate = "true" class="form-control" id="from-name" name="from-name" value="<?php echo @$setting["from-name"];?>" placeholder="Tên ngưởi gửi">
</div>
<div class="form-group">
    <label for="from-mail">Email gửi đi: </label>
    <input type="email" data-required="true" data-validate = "true" name="from-mail" class="form-control" id="from-mail" value="<?php echo @$setting["from-mail"];?>" placeholder="Email gửi đi">
</div>
<div class="form-group">
    <label>
        <div class="checkbox">
        <?php if(isset($setting["sell"])){?>
            <input type="checkbox" name="sell" id="on-off-sell" class="set-active" value="1" checked>
        <?php } else{ ?>
            <input type="checkbox" name="sell" id="on-off-sell" class="set-active" value="1">
        <?php } ?>
            <label for="on-off-sell"><span>Bật/tắt mã giảm giá</span></label>
        </div>
    </label>
</div>
<div class="form-group">
    <label for="from-mail">Email Template: </label>
    <select class="form-control" name="email-template" data-required="true" data-validate="true">
        <option value="0">-- Lựa chọn --</option>
        <?php 
        if(isset($email_template) && $email_template != null){
            foreach ($email_template as $key => $value) {
               $selected = (isset($setting["email-template"]) && $value["Key"] == $setting["email-template"]) ? "selected" : "";
               echo "<option value ='".$value["Key"]."' ".$selected.">".$value["Title"]."</option>";
            }
        }
        ?>
    </select>
</div>
<style type="text/css">
	.checkbox label{padding-left: 0;}
</style>
<script type="text/javascript">
    $(".set-active").click(function(){
        var id = $(this).val();
        $.ajax({
            url : base_url + "admin/payment/active",
            type:"POST",
            dataType:"json",
            data:{id:id},
            success:function(data){
                console.log(data);
            }
        })
    });
	
</script>