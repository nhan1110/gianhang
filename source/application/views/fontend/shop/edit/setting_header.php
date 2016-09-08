<div class="accordion-group panel panel-default">
   <div class="accordion-heading panel-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#custom-accordionselectors" href="#collapseheader-main">
        Header   
      </a>
   </div>
   <div id="collapseheader-main" class="accordion-body panel-collapse collapse ">
      <div class="accordion-inner panel-body clearfix">
         <div class="form-group row">
            <label class="col-sm-12">Tiêu đề website</label>
            <div class="col-sm-12">
            	  <input name="customize[header_main][title]"  type="text" class="form-control change-control" data-selector="head title">
         	  </div>
         </div>
         <div class="form-group">
            <label>Màu nền</label>
            <input value="" size="10" name="customize[header_main][background-color]" data-match="header-main" type="text" class="input-setting" data-selector="#header" data-attrs="background-color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Xóa</a>
         </div>
          <div class="form-group background-images">
            <label>Ảnh nền</label>
            <a class="clear-bg btn btn-small btn-theme-default" href="#">Xóa</a>
            <input value="" type="hidden" name="customize[header_main][background-image]" data-match="body" class="input-setting" data-selector="#header" data-attrs="background-image" readonly="readonly">
            <div class="clearfix"></div>
            <div class="bi-wrapper clearfix">
               <?php for($i=1;$i<=16;$i++): ?>
               	<div style="background:url('<?php echo skin_url(); ?>/shop/bg/pattern<?php echo $i; ?>.png') no-repeat center center;" class="pull-left" data-image="../skins/shop/bg/pattern<?php echo $i; ?>.png" data-val="../skins/shop/bg/pattern<?php echo $i; ?>.png"></div>
               <?php endfor; ?>
               <div class="custom" style="width: 40px;">
                 <a href="#">Tải lên</a>
               </div>
            </div>
         </div>
         <div class="form-group">
            <label>Background repeat</label>
            <select name="customize[header_main][background-repeat]" data-match="header-main" class="input-setting" data-selector="#header" data-attrs="background-repeat" style="margin-right: 2px;">
               <option value="">Background repeat</option>
               <option value="no-repeat">No Repeat</option>
               <option value="repeat">Repeat All</option>
               <option value="repeat-x">Repeat Horizontally</option>
               <option value="repeat-y">Repeat Vertically</option>
               <option value="inherit">Inherit</option>
            </select>
            <a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
         <div class="form-group">
            <label>Background position</label>
            <select name="customize[header_main][background-position]" data-match="header-main" class="input-setting" data-selector="#header" data-attrs="background-position" style="margin-right: 2px;">
               <option value="">Background position</option>
               <option value="left top">Left Top</option>
               <option value="left center">Left Center</option>
               <option value="left bottom">Left Bottom</option>
               <option value="center top">Center Top</option>
               <option value="center center">Center Center</option>
               <option value="center bottom">Center Bottom</option>
               <option value="right top">Right Top</option>
               <option value="right center">Right Center</option>
               <option value="right bottom">Right Bottom</option>
            </select>
            <a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
         <div class="form-group">
            <label>Background size</label>
            <select name="customize[header_main][background-size]" data-match="header-main" class="input-setting" data-selector="#header" data-attrs="background-size" style="margin-right: 2px;">
               <option value="">Background size</option>
               <option value="contain">Contain</option>
               <option value="cover">Cover</option>
               <option value="100% 100%">100% 100%</option>
               <option value="inherit">Inherit</option>
               <option value="initial">Initial</option>
            </select>
            <a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
         <div class="form-group">
            <label>Background Attachment</label>
            <select name="customize[header_main][background-attachment]" data-match="header-main" class="input-setting" data-selector="#header" data-attrs="background-attachment" style="margin-right: 2px;">
               <option value="">Background Attachment</option>
               <option value="fixed">Fixed</option>
               <option value="scroll">Scroll</option>
               <option value="inherit">Inherit</option>
            </select>
            <a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
         <div class="form-group">
            <label>Màu chữ</label>
            <input value="" size="10" name="customize[header_main][color_text]" data-match="header-main" type="text" class="input-setting" data-selector="#header" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Xóa</a>
         </div>
         <div class="form-group">
            <label>Màu liên kết</label>
            <input value="" size="10" name="customize[header_main][color_text_link]" data-match="header-main" type="text" class="input-setting" data-selector="#header a" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Xóa</a>
         </div>
         <div class="form-group">
            <label>Màu liên kết khi rê chuột</label>
            <input value="" size="10" name="customize[header_main][color_text_link_hover]" data-match="header-main" type="text" class="input-setting" data-selector="#header a:hover" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Xóa</a>
         </div>
      </div>
   </div>
</div>