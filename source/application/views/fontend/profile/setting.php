
<div class="container">
  <h1 class="page-header">Member Setting</h1>
  <div class="row">
    <div class="col-md-12">
      <form method="post" id="form-setting">
        <div class="form-group">
          <fieldset>
            <legend>Số sản phẩm trên một trang:</legend>
            <input class="form-control" name="per_page" data-min ="21" data-max = "100" data-validate="true" data-number="true"  value="<?php echo @$member["Item_Per_Page"];?>" type="text" placeholder = "Nhỏ nhất là 21 và lớn nhất là 100">
          </fieldset>
        </div>
        <div class="form-group">
          <fieldset>
            <legend>Sắp xếp theo sản phẩm:</legend>
            <select name="order_by_follow" class="form-control">
            <?php if(isset($member["Order_By_Follow"]) && $member["Order_By_Follow"] == "view") :?>
              <option value="date">Ngày tháng</option>
              <option value="view" selected>Lượt xem</option>
            <?php else:?>
              <option value="date">Ngày tháng</option>
              <option value="view">Lượt xem</option>
            <?php endif;?>
              
            </select>
          </fieldset>
        </div>
        <div class="form-group">
          <fieldset>
            <legend>Tên Liên lạc:</legend>
            <input class="form-control" name="contact_name" value="<?php echo @$member["Contact_Name"];?>" type="text" placeholder = "Tên Liên lạc">
          </fieldset>
        </div>
        <div class="form-group">
          <fieldset>
            <legend>Địa chỉ email liên lạc:</legend>
            <input class="form-control" name="contact_email" data-validate="true" data-email="true" value="<?php echo @$member["Contact_Email"];?>" type="text" placeholder = "Địa chỉ email liên lạc">
          </fieldset>
        </div>
        <div class="form-group">
          <fieldset id="contact-infor">
            <legend>Thông tin liên hê:</legend>
            <div class="col-sm-4">Tên:</div><div class="col-sm-8">Thông tin</div>
            <div class="contact-infor-content">
            <?php 
              $infor = json_decode(@$member["Contact_Info"],true);
              if(is_array($infor) && count($infor) > 0){
                foreach ($infor as $key => $value) {?>
                  <div class="item relative">
                    <a href="#" class="remove-item"><i class="fa fa-times" aria-hidden="true"></i></a>
                    <div class="col-sm-4"><input class="form-control" name="contact_infor_name[]" value="<?php echo $key;?>" type="text" id="name-contact-infor" /></div>
                    <div class="col-sm-8"><input class="form-control" name="contact_infor_infor[]" value="<?php echo $value;?>" type="text" id="infor-contact-infor"/></div>
                  </div>
                <?php }
              }else{ ?>
              <div class="item relative">
                <div class="col-sm-4"><input class="form-control" name="contact_infor_name[]" type="text" id="name-contact-infor" /></div>
                <div class="col-sm-8"><input class="form-control" name="contact_infor_infor[]" type="text" id="infor-contact-infor"/></div>
              </div>
            <?php   }
            ?>
            </div>
            <div class="col-sm-12 text-right"><a href="#" class="btn btn-success ml-10px relative" id="add-infor">Thêm</a></div>
          </fieldset>
        </div>
        <div class="form-group">
          <fieldset>
            <legend>Tiêu đề trang web:</legend>
            <input class="form-control" name="title_site" value="<?php echo @$member["Title_Site"];?>" type="text" placeholder = "Tiêu đề trang web">
          </fieldset>  
        </div>
        <div class="form-group">
          <fieldset>
            <legend>Mô tả trang web:</legend>
            <textarea class="form-control" name="description_site" placeholder = "Mô tả trang web"><?php echo @$member["Description_Site"];?></textarea>
          </fieldset>  
        </div>
        <div class="form-group text-right">
          <button type="submit" class="btn btn btn-primary relative" id="save_setting"><i class="fa fa-save"></i> Lưu</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  var infor_clone = '<div class="item relative"> <a href="#" class="remove-item"><i class="fa fa-times" aria-hidden="true"></i></a> <div class="col-sm-4"><input class="form-control" name="contact_infor_name[]" type="text" id="name-contact-infor" /></div> <div class="col-sm-8"><input class="form-control" name="contact_infor_infor[]" type="text" id="infor-contact-infor"/></div> </div>';
  $(document).ready(function(){
      $("#add-infor").click(function(){
        var item = $("#contact-infor .contact-infor-content .item").length;
        if(item <= 20){
          $("#contact-infor .contact-infor-content").append(infor_clone);
        }else{
          error_messenger("Số lượng đã vượt quá.");
        }
        return false;
      });
      $("#form-setting").submit(function(){
        if(!validateform($(this))){
          $("body").animate({scrollTop: 0}, '500');
        }   
        return validateform($(this));
      });
  });
  $(document).on("click","#contact-infor .item .remove-item",function(){
      $(this).parents(".item").remove();
      return false;
  });
</script>