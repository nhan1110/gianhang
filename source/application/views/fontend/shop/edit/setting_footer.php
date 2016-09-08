<div class="accordion-group panel panel-default">
   <div class="accordion-heading panel-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#custom-accordionselectors" href="#collapsefooter-center">
        Footer 
      </a>
   </div>
   <div id="collapsefooter-center" class="accordion-body panel-collapse collapse ">
      <div class="accordion-inner panel-body clearfix">
         <div class="form-group">
            <label>Màu nền</label>
            <input value="" size="10" name="customize[footer][background-color]" data-match="footer-center" type="text" class="input-setting" data-selector=".footer-center" data-attrs="background-color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
         <div class="form-group">
            <label>Background repeat</label>
            <select name="customize[footer][background-repeat]" data-match="footer-center" class="input-setting" data-selector=".footer-center" data-attrs="background-repeat" style="margin-right: 2px;">
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
            <select name="customize[footer][background-position]" data-match="footer-center" class="input-setting" data-selector=".footer-center" data-attrs="background-position" style="margin-right: 2px;">
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
            <select name="customize[footer][background-size]" data-match="footer-center" class="input-setting" data-selector=".footer-center" data-attrs="background-size" style="margin-right: 2px;">
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
            <select name="customize[footer][background-attachment]" data-match="footer-center" class="input-setting" data-selector=".footer-center" data-attrs="background-attachment" style="margin-right: 2px;">
               <option value="">Background Attachment</option>
               <option value="fixed">Fixed</option>
               <option value="scroll">Scroll</option>
               <option value="inherit">Inherit</option>
            </select>
            <a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
         <div class="form-group background-images">
            <label>Ảnh nền</label>
            <a class="clear-bg btn btn-small btn-theme-default" href="#">Clear</a>
            <input value="" type="hidden" name="customize[footer][background-image]" data-match="footer-center" class="input-setting" data-selector=".footer-center" data-attrs="background-image" readonly="readonly">
            <div class="clearfix"></div>
            <div class="bi-wrapper clearfix">
               <?php for($i=1;$i<=16;$i++): ?>
                  <div style="background:url('<?php echo skin_url(); ?>/shop/bg/pattern<?php echo $i; ?>.png') no-repeat center center;" class="pull-left" data-image="../skins/shop/bg/pattern<?php echo $i; ?>.png" data-val="../skins/shop/bg/pattern<?php echo $i; ?>.png"></div>
               <?php endfor; ?>
            </div>
         </div>
         <div class="form-group">
            <label>Màu chữ</label>
            <input value="" size="10" name="customize[footer][color]" data-match="footer-center" type="text" class="input-setting" data-selector=".footer-center *" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
         <div class="form-group">
            <label>Font chữ</label>
            <select name="customize[footer][font-family]" data-match="footer-center" class="input-setting" data-selector=".footer-center *" data-attrs="font-family" style="margin-right: 2px;">
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
            <select name="customize[footer][text-transform]" data-match="footer-center" class="input-setting" data-selector=".footer-center *" data-attrs="text-transform" style="margin-right: 2px;">
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
            <select name="customize[footer][font-weight]" data-match="footer-center" class="input-setting" data-selector=".footer-center *" data-attrs="font-weight" style="margin-right: 2px;">
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
            <select name="customize[footer][font-size]" data-match="footer-center" class="input-setting" data-selector=".footer-center *" data-attrs="font-size" style="margin-right: 2px;">
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
            <label>Màu liên kết</label>
            <input value="" size="10" name="customize[footer][color_text_link]" data-match="footer-center" type="text" class="input-setting" data-selector="#footer .column a" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
         <div class="form-group">
            <label>Màu liên kết rê chuột</label>
            <input value="" size="10" name="customize[footer][color_text_link_hover]" data-match="footer-center" type="text" class="input-setting" data-selector="#footer .column a:hover" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
         </div>
      </div>
   </div>
</div>