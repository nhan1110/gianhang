<div class="container">
  <div class="panel" style="margin-bottom: 0;border-bottom: 1px solid #ccc;">
      <div class="panel-body">
          <h2>Nâng cấp tài khoản <?php echo @$upgrade["Number_Month"];?> tháng</h2>
          <hr>
          <?php if(isset($message) && $message != null):?>
            <div class="alert alert-danger fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                <?php echo @$message; ?>
            </div>
          <?php endif;?>

          <form method="post" id="box-upgrade" action="">
              <div class="form-group row">
                 <label class="col-md-2 col-sm-3 sm-remove-padding-right text-right control-label">Họ <sup>*</sup></label>
                 <div class="col-md-8 col-sm-9 ">
                    <input class="form-control" name="first_name" data-required="true" data-validate="true" value="<?php echo @$user_info["first_name"]?>" type="text">
                 </div>
              </div>
              <div class="form-group row">
                 <label class="col-md-2 col-sm-3 sm-remove-padding-right text-right control-label">Tên <sup>*</sup></label>
                 <div class="col-md-8 col-sm-9">
                    <input class="form-control" name="last_name" data-required="true" data-validate="true" value="<?php echo @$user_info["last_name"]?>" type="text">
                 </div>
              </div>
              <div class="form-group row">
                 <label class="col-md-2 col-sm-3 sm-remove-padding-right text-right control-label">Tên công ty</label>
                 <div class="col-md-8 col-sm-8">
                    <input class="form-control" name="company" value="" type="text">
                 </div>
              </div>
              <div class="form-group row">
                 <label class="col-md-2 col-sm-3 sm-remove-padding-right text-right control-label">Địa chỉ email <sup>*</sup></label>
                 <div class="col-md-8 col-sm-9">
                    <input class="form-control" name="email" data-required="true" data-validate="true" value="<?php echo @$user_info["email"]?>" type="email">
                 </div>
              </div>
              <div class="form-group row">
                 <label class="col-md-2 col-sm-3 sm-remove-padding-right text-right control-label">Số điện thoại <sup>*</sup></label>
                 <div class="col-md-8 col-sm-9">
                    <input class="form-control" name="phone_number" value="" data-required="true" data-validate="true" value="" type="text">
                 </div>
              </div>
              <div class="form-group row">
                 <label class="col-md-2 col-sm-3 sm-remove-padding-right text-right control-label">Địa chỉ <sup>*</sup></label>
                 <div class="col-md-8 col-sm-9">
                    <input class="form-control" name="address" value="" data-required="true" data-validate="true" value="" type="text">
                 </div>
              </div>
              <div class="form-group row">
                 <label class="col-md-2 col-sm-3 sm-remove-padding-right text-right control-label">Phương thức thanh toán <sup>*</sup></label>
                 <div class="col-md-10 col-md-9">
                   <?php if(isset($payments) && is_array($payments) && $payments != null):?>
                      <?php foreach ($payments AS $key => $value):?>
                        <div class="checkbox">
                            <input type="radio" data-for=".payment-<?php echo $value["Slug"] ;?>" data-required="true" data-validate="true" id="payment-<?php echo $value["Slug"] ;?>" value="<?php echo $value["ID"];?>" name="payment">
                            <label class="payment-<?php echo $value["Slug"] ;?>" for ="payment-<?php echo  $value["Slug"] ;?>"><span><?php echo  $value["Title"] ;?></span></label>
                            <p><?php echo $value["Description"];?></p>
                            <?php if($value["Slug"] == 'thanh-toan-bang-sms'):  ?>
                                <div class="row form-input-sms" style="display:none;">
                                   <div class="col-xs-12 col-sm-8 col-md-6">
                                        <div class="form-group">
                                           <strong>Số serial trên thẻ cào</strong>
                                           <input type="text" name="card_serial" class="form-control">
                                        </div>
                                        <div class="form-group">
                                           <strong>Số pin trên thẻ cào</strong>
                                           <input type="text" name="pin_card" class="form-control">
                                        </div>
                                        <div class="form-group">
                                           <strong>Loại thẻ cào</strong>
                                           <select name="type_card" class="form-control">
                                              <option value="">Loại thẻ cào</option>
                                              <option value="MOBI">Thẻ cào MobiFone</option>
                                              <option value="VINA">Thẻ cào VinaPhone</option>
                                              <option value="VIETEL">Thẻ cào Viettel</option>
                                              <option value="VTC">Thẻ cào VTC Coin</option>
                                              <option value="GATE">Thẻ cào FPT Gate</option>
                                           </select>
                                        </div>
                                   </div>
                                </div>
                            <?php endif; ?>
                        </div>
                      <?php endforeach;?>
                   <?php endif;?>
                 </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <h3>Đơn hàng của bạn</h3>
                  <table class="table-upgrade">
                  <thead>
                      <tr>
                          <th class="product-name">Sản phẩm</th>
                          <th class="product-name">Số tháng</th>
                          <th class="product-total">Số tiền trên tháng</th>
                          <th class="product-total">Tổng cộng</th>
                      </tr>
                  </thead>
                  <tbody>
                  <tr class="cart_item">
                  <td>Nâng cấp tài khoản</td>
                  <td><?php echo @$upgrade["Number_Month"];?></td>
                  <td><?php if(@$upgrade["Price_One_Month"] !=null){ echo number_format($upgrade["Price_One_Month"],3);}?> VND</td>
                  <td><?php echo number_format(@$upgrade["Number_Month"] * @$upgrade["Price_One_Month"]);?> VND</td>
                </tr>
                  </tbody>
              </table>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-12 text-right">
                      <button type="submit" class="btn btn-primary" id="payment-success">Tiếp Tục</button>
                  </div>
              </div>
          </form>
        </div>
  </div> 
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("skins/css/page/upgrade.css");?>">
<script type="text/javascript">
	$(document).ready(function(){
		$("#payment-success").click(function(){
			$('body').animate({
		        scrollTop: 0
		  }, 'slow');
      var check = true;
      var method_payment = $('input[name="payment"]:checked').val();
			if(method_payment != null && method_payment != ''){
          $('input[name="payment"]').each(function(){
             $(this).parent().find('label').removeClass('validate');
          });
      }
      else{
          check = false;
          $('input[name="payment"]').each(function(){
             $(this).parent().find('label').addClass('validate');
          });
      }
      return validateform($(this).parents("form")) && check;
		});

    $(document).on('click','input[name="payment"]',function(){
        var method_payment = $(this).val();
        if(method_payment == 9){
            $(".form-input-sms").show();
            $(".form-input-sms input,.form-input-sms select").attr('data-required','true');
            $(".form-input-sms input,.form-input-sms select").attr('data-validate','true');
        }
        else{
            $(".form-input-sms input,.form-input-sms select").removeAttr('data-required');
            $(".form-input-sms input,.form-input-sms select").removeAttr('data-validate');
            $(".form-input-sms").hide();
        }
    });
	});
</script>