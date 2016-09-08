<div class="accordion-group panel panel-default">
   <div class="accordion-heading panel-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#custom-accordionselectors" href="#collapsebody">
          Nội dung chính  
      </a>
   </div>
   <div id="collapsebody" class="accordion-body panel-collapse collapse">
      <div class="accordion-inner panel-body clearfix">
         <div class="form-group row">
            <label class="col-sm-12">Số sản phẩm slider</label>
            <div class="col-sm-12">
                 <select name="customize[body][number_slider]" class="form-control">
                    <option value="">Số sản phẩm slider</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                 </select>
              </div>
         </div>
         <div class="form-group">
            <label>Màu nền website</label>
            <input value="" size="10" name="customize[body][background-color]" data-match="body" type="text" class="input-setting" data-selector="body" data-attrs="background-color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
          <div class="form-group">
            <label>Background repeat</label>
            <select name="customize[body][background-repeat]" data-match="body" class="input-setting" data-selector="body" data-attrs="background-repeat" style="margin-right: 2px;">
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
            <select name="customize[body][background-position]" data-match="body" class="input-setting" data-selector="body" data-attrs="background-position" style="margin-right: 2px;">
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
            <select name="customize[body][background-size]" data-match="body" class="input-setting" data-selector="body" data-attrs="background-size" style="margin-right: 2px;">
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
            <select name="customize[body][background-attachment]" data-match="body" class="input-setting" data-selector="body" data-attrs="background-attachment" style="margin-right: 2px;">
               <option value="">Background Attachment</option>
               <option value="fixed">Fixed</option>
               <option value="scroll">Scroll</option>
               <option value="inherit">Inherit</option>
            </select>
            <a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
         <div class="form-group background-images">
            <label>Ảnh nền website</label>
            <a class="clear-bg btn btn-small btn-theme-default" href="#">Xóa</a>
            <input value="" type="hidden" name="customize[body][background-image]" data-match="body" class="input-setting" data-selector="body" data-attrs="background-image" readonly="readonly">
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
         <div style="height:40px;"></div>
         <div class="form-group">
            <label>Màu nền nội dung chính</label>
            <input value="" size="10" name="customize[content][backgroung-color]" data-match="wrap-content" type="text" class="input-setting" data-selector="body .wrap-content" data-attrs="background-color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
         <div class="form-group">
            <label>Font chữ</label>
            <select name="customize[content][font-family]" data-match="wrap-content" class="input-setting" data-selector="body .wrap-content" data-attrs="font-family" style="margin-right: 2px;">
               <option value="">Font chữ</option>
               <option value="arial">Arial</option>
               <option value="georgia">Georgia</option>
               <option value="helvetica">Helvetica</option>
               <option value="palatino">Palatino</option>
               <option value="tahoma">Tahoma</option>
               <option value="times">Times New Roman</option>
               <option value="trebuchet">Trebuchet</option>
               <option value="verdana">Verdana</option>
            </select>
            <a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
         <div class="form-group">
            <label>Loại chữ</label>
            <select name="customize[content][text-transform]" data-match="body .wrap-content" class="input-setting" data-selector="body .wrap-content" data-attrs="text-transform" style="margin-right: 2px;">
               <option value="">Loại chữ</option>
               <option value="capitalize">Capitalize</option>
               <option value="inherit">Inherit</option>
               <option value="lowercase">Lowercase</option>
               <option value="none">None</option>
               <option value="uppercase">Uppercase</option>
            </select>
            <a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
         <div class="form-group">
            <label>Font weight</label>
            <select name="customize[content][font-weight]" data-match="body .wrap-content" class="input-setting" data-selector="body .wrap-content" data-attrs="font-weight" style="margin-right: 2px;">
               <option value="">Font weight</option>
               <option value="normal">Normal</option>
               <option value="bold">Bold</option>
               <option value="bolder">Bolder</option>
               <option value="lighter">Lighter</option>
               <option value="100">100</option>
               <option value="200">200</option>
               <option value="300">300</option>
               <option value="400">400</option>
               <option value="500">500</option>
               <option value="600">600</option>
               <option value="700">700</option>
               <option value="800">800</option>
               <option value="900">900</option>
               <option value="inherit">Inherit</option>
            </select>
            <a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
         <div class="form-group">
            <label>Cỡ chữ</label>
            <select name="customize[content][font-size]" data-match="body .wrap-content" class="input-setting" data-selector="body .wrap-content" data-attrs="font-size" style="margin-right: 2px;">
               <option value="">Chọn</option>
               <option value="9">9</option>
               <option value="10">10</option>
               <option value="11">11</option>
               <option value="12">12</option>
               <option value="13">13</option>
               <option value="14">14</option>
               <option value="15">15</option>
               <option value="16">16</option>
               <option value="17">17</option>
               <option value="18">18</option>
            </select>
            <a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
         <div class="form-group">
            <label>Màu chữ</label>
            <input value="" size="10" name="customize[body][color_body_text]" data-match="body" type="text" class="input-setting" data-selector="body #page" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Xóa</a>
         </div>
         <div class="form-group">
            <label>Màu liên kết</label>
            <input value="" size="10" name="customize[body][color_body_link]" data-match="body" type="text" class="input-setting" data-selector="body #page a" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Xóa</a>
         </div>
         <div class="form-group">
            <label>Màu liên kết khi rê chuột</label>
            <input value="" size="10" name="customize[body][color_body_link_hover]" data-match="body" type="text" class="input-setting" data-selector="a:hover" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
      </div>
   </div>
</div>