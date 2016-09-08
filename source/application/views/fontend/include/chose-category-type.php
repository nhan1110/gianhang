<?php 
  $category_type = new Category_Type();
  $cat_type_root = $category_type->where("Parent_ID",0)->get_raw()->result_array();
?>
<div class="modal fade popup" id="chose-category-type" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Thông Báo !!!</h3>
      </div>
      <div class="modal-body">
        <p id="warning-messenger">Vui lòng chọn thể loại sản phẩm, giá trị này sẽ được sử dụng cho tất cả các sản phẩm sau này</p>
        <select name="category-type" id="slug-category-type" data-validate="true" data-required="true" class="form-control">
          <option value="">-- Loại Hình Của Sản Phẩm --</option>
          <?php 
            if(is_array($cat_type_root) && count($cat_type_root) > 0) :
              foreach ($cat_type_root as $key => $value) {
                echo '<option value="'.$value["Slug"].'">'.$value["Name"].'</option>';
              }
            endif;
          ?>                                         
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary relative" id="save-category-type">OK</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
  $(document).ready(function(){
    $("#chose-category-type #save-category-type").click(function(){
      var slug_cattype = $(this).parents("#chose-category-type").find("#slug-category-type").val();
      if(validateform($(this).parents("#chose-category-type")) && _reset == 0){
        _reset = 1;
        $.ajax({
            url :base_url + "profile/update_category_type",
            type:"post",
            dataType:"json",
            data : {"slug" : slug_cattype},
            success:function(data){
              console.log(data);
              if(data["success"] == "success"){
                window.location.reload();
              }
            },
            error:function(){
              _reset = 0;
            }
        });
      }
    });
  });
</script>