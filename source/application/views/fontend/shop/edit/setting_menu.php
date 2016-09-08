<div class="accordion-group panel panel-default">
   <div class="accordion-heading panel-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#custom-accordionselectors" href="#collapsepav-mainnav">
        Menu chính  
      </a>
   </div>
   <div id="collapsepav-mainnav" class="accordion-body panel-collapse collapse ">
      <div class="accordion-inner panel-body clearfix">
         <div class="form-group row">
            <label class="col-sm-12">Chọn Menu</label>
            <div class="col-sm-12">
            	  <select name="customize[pav_mainnav][menu_group]" class="form-control change-control-menu" data-selector=".mainnav-wrap .navbar-collapse ul.megamenu">
         	  	  	  <option value="">Select Menu</option>
         	  	  	  <?php
         	  	  	  	 $CI = & get_instance();
         	  	  	  	 $user_info = @$CI->session->userdata('user_info');
         	  	  	  	 $user_id = @$user_info['id'];
         	  	  	  	 $member_menu_group = new Member_Group_Menu();
         	  	  	  	 $member_menu_group->where('Member_ID',$user_id)->get();
         	  	  	  	 if(isset($member_menu_group)){
         	  	  	  	 	foreach ($member_menu_group as $key => $value) {
         	  	  	  	 		echo '<option value="'.$value->ID.'">'.$value->Title.'</option>';
         	  	  	  	 	}
         	  	  	  	 }
         	  	  	  ?>
         	  	  </select>
         	  </div>
         </div>
         <div class="form-group">
            <label>Màu nền</label>
            <input value="" size="10" name="customize[pav_mainnav][bg_color]" data-match="pav-mainnav" type="text" class="input-setting" data-selector="#pav-mainnav .mainnav-wrap" data-attrs="background-color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Xóa</a>
         </div>
         <div class="form-group">
            <label>Màu nền</label>
            <input value="" size="10" name="customize[pav_mainnav][text_color]" data-match="pav-mainnav" type="text" class="input-setting" data-selector="#pav-mainnav .mainnav-wrap a" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Xóa</a>
         </div>
         <div class="form-group">
            <label>Màu liên kết</label>
            <input value="" size="10" name="customize[pav_mainnav][text_color_link]" data-match="pav-mainnav" type="text" class="input-setting" data-selector="#pav-mainnav .mainnav-wrap a:hover" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Xóa</a>
         </div>
      </div>
   </div>
</div>