<div class="accordion-group panel panel-default">
   <div class="accordion-heading panel-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#custom-accordionselectors" href="#collapsepowered">
      	Powered  
      </a>
   </div>
   <div id="collapsepowered" class="accordion-body panel-collapse collapse ">
      <div class="accordion-inner panel-body clearfix">
         <div class="form-group row">
            <label class="col-sm-12">Văn bản</label>
            <div class="col-sm-12">
            	  <input value="" size="10" name="customize[powered][text]"  type="text" class="form-control change-control" data-selector="#powered .copyright">
         	  </div>
         </div>
         <div class="form-group">
            <label>Font chữ</label>
            <select name="customize[powered][font-family]" data-match="body" class="input-setting" data-selector="#powered .copyright" data-attrs="font-family" style="margin-right: 2px;">
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
            <select name="customize[powered][text-transform]" data-match="body" class="input-setting" data-selector="#powered .copyright" data-attrs="text-transform" style="margin-right: 2px;">
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
            <select name="customize[powered][font-weight]" data-match="body" class="input-setting" data-selector="#powered .copyright" data-attrs="font-weight" style="margin-right: 2px;">
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
            <select name="customize[powered][font-size]" data-match="body" class="input-setting" data-selector="#powered .copyright" data-attrs="font-size" style="margin-right: 2px;">
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
            <label>Màu nền</label>
            <input value="" size="10" name="customize[powered][background-color]" data-match="powered" type="text" class="input-setting" data-selector="#powered" data-attrs="background-color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
         <div class="form-group">
            <label>Màu chữ</label>
            <input value="" size="10" name="customize[powered][color]" data-match="powered" type="text" class="input-setting" data-selector="#powered" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
         <div class="form-group">
            <label>Màu liên kết</label>
            <input value="" size="10" name="customize[powered][color_text_link]" data-match="powered" type="text" class="input-setting" data-selector="#powered a" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
         <div class="form-group background-images">
            <label>Ảnh nền</label>
            <a class="clear-bg btn btn-small btn-theme-default" href="#">Clear</a>
            <input value="" type="hidden" name="customize[powered][background-image]" data-match="powered" class="input-setting" data-selector="#powered" data-attrs="background-image" readonly="readonly">
            <div class="clearfix"></div>
            <div class="bi-wrapper clearfix">
               <?php for($i=1;$i<=16;$i++): ?>
               	<div style="background:url('<?php echo skin_url(); ?>/shop/bg/pattern<?php echo $i; ?>.png') no-repeat center center;" class="pull-left" data-image="../skins/shop/bg/pattern<?php echo $i; ?>.png" data-val="../skins/shop/bg/pattern<?php echo $i; ?>.png"></div>
               <?php endfor; ?>
            </div>
         </div>
      </div>
   </div>
</div>