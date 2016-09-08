<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">-->
<div id="pav-paneltool" class="hidden-sm hidden-xs">
   <form method="post" id="form-setting" action="">
   	  <div class="paneltool editortool">
        <div class="panelbutton">
           <i class="fa fa-cog"></i>
        </div>
        <div class="panelcontent editortool">
           <div class="panelinner">
              <h4>Cài đặt Website</h4>
              <div class="clearfix" id="customize-body">
                 <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#tab-template">Chọn Theme</a></li>
                    <li><a href="#tab-selectors">Cài đặt chung</a></li>
                    <li><a href="#tab-elements">Widget</a></li>
                 </ul>
                 <div class="tab-content">
                 	<div class="tab-pane active" id="tab-template">
                       <div class="accordion" id="custom-template" style="min-height: 160px;">
                       	  <ul class="list-template">
                       	  	<li><a href="#" data-template="3-column"><img src="<?php echo skin_url(); ?>/shop/bg/3-column.png"></a></li>
                       	  	<li><a href="#" data-template="sidebar-left"><img src="<?php echo skin_url(); ?>/shop/bg/left-sidebar.png"></a></li>
                       	  	<li><a href="#" data-template="sidebar-right"><img src="<?php echo skin_url(); ?>/shop/bg/right-sidebar.png"></a></li>
                       	  	<li><a href="#" data-template="full-width"><img src="<?php echo skin_url(); ?>/shop/bg/full-width.png"></a></li>
                       	  </ul>
                       	  <input type="hidden" name="layout_template" id="layout_template">
                       </div>
                    </div>
                 	<div class="tab-pane" id="tab-selectors">
                       <div class="accordion" id="custom-accordionselectors">
                       	  <?php $this->load->view('fontend/shop/edit/setting_header'); ?>
                          <?php $this->load->view('fontend/shop/edit/setting_menu'); ?>
                          <?php $this->load->view('fontend/shop/edit/setting_content'); ?>
                          <?php $this->load->view('fontend/shop/edit/setting_footer'); ?>
                          <?php $this->load->view('fontend/shop/edit/setting_powered'); ?>
                       </div>
                    </div>
                    <div class="tab-pane" id="tab-elements">
                       <div class="accordion" id="custom-accordionelements">
                          <div class="accordion-group panel panel-default">
                             <div class="accordion-heading panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#custom-accordionelements" href="#collapseproduct">
                                Products   
                                </a>
                             </div>
                             <div id="collapseproduct" class="accordion-body panel-collapse collapse  in ">
                                <div class="accordion-inner panel-body clearfix">
                                   <div class="form-group">
                                      <label>Color Price</label>
                                      <input value="" size="10" name="customize[product][]" data-match="product" type="text" class="input-setting" data-selector=".product-block .price" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
                                   </div>
                                   <div class="form-group">
                                      <label>Color Price New</label>
                                      <input value="" size="10" name="customize[product][]" data-match="product" type="text" class="input-setting" data-selector=".price .price-new" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
                                   </div>
                                   <div class="form-group">
                                      <label>Color Price Old</label>
                                      <input value="" size="10" name="customize[product][]" data-match="product" type="text" class="input-setting" data-selector=".price .price-old" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
                                   </div>
                                   <div class="form-group">
                                      <label>Color Price Tax</label>
                                      <input value="" size="10" name="customize[product][]" data-match="product" type="text" class="input-setting" data-selector=".price .price-tax" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
                                   </div>
                                   <div class="form-group">
                                      <label>BgColor Cart</label>
                                      <input value="" size="10" name="customize[product][]" data-match="product" type="text" class="input-setting" data-selector=".cart input" data-attrs="background-color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
                                   </div>
                                   <div class="form-group">
                                      <label>Color Cart</label>
                                      <input value="" size="10" name="customize[product][]" data-match="product" type="text" class="input-setting" data-selector=".cart input" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
                                   </div>
                                   <div class="form-group">
                                      <label>BgColor Wishlist</label>
                                      <input value="" size="10" name="customize[product][]" data-match="product" type="text" class="input-setting" data-selector=".product-block .compare a" data-attrs="background-color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
                                   </div>
                                   <div class="form-group">
                                      <label>BgColor Compare</label>
                                      <input value="" size="10" name="customize[product][]" data-match="product" type="text" class="input-setting" data-selector=".product-block .wishlist a" data-attrs="background-color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
                                   </div>
                                </div>
                             </div>
                          </div>
                          <div class="accordion-group panel panel-default">
                             <div class="accordion-heading panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#custom-accordionelements" href="#collapsemodules">
                                Modules default in Sidebar   
                                </a>
                             </div>
                             <div id="collapsemodules" class="accordion-body panel-collapse collapse ">
                                <div class="accordion-inner panel-body clearfix">
                                   <div class="form-group">
                                      <label>Heading Background</label>
                                      <input value="" size="10" name="customize[modules][]" data-match="modules" type="text" class="input-setting" data-selector=".sidebar .box .box-heading" data-attrs="background-color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
                                   </div>
                                   <div class="form-group">
                                      <label>Heading Color</label>
                                      <input value="" size="10" name="customize[modules][]" data-match="modules" type="text" class="input-setting" data-selector=".sidebar .box .box-heading span" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
                                   </div>
                                   <div class="form-group">
                                      <label>Content Background</label>
                                      <input value="" size="10" name="customize[modules][]" data-match="modules" type="text" class="input-setting" data-selector=".sidebar .box .box-content" data-attrs="background-color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
                                   </div>
                                   <div class="form-group">
                                      <label>Content Color</label>
                                      <input value="" size="10" name="customize[modules][]" data-match="modules" type="text" class="input-setting" data-selector=".sidebar .box .box-content" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
                                   </div>
                                   <div class="form-group">
                                      <label>Border Color</label>
                                      <input value="" size="10" name="customize[modules][]" data-match="modules" type="text" class="input-setting" data-selector=".sidebar .product-block, .box.nopadding ul li" data-attrs="border-bottom-color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
                                   </div>
                                </div>
                             </div>
                          </div>
                          <div class="accordion-group panel panel-default">
                             <div class="accordion-heading panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#custom-accordionelements" href="#collapsehighlighted-modules">
                                Modules highlighted  in Sidebar  
                                </a>
                             </div>
                             <div id="collapsehighlighted-modules" class="accordion-body panel-collapse collapse ">
                                <div class="accordion-inner panel-body clearfix">
                                   <div class="form-group">
                                      <label>Heading Background</label>
                                      <input value="" size="10" name="customize[highlighted-modules][]" data-match="highlighted-modules" type="text" class="input-setting" data-selector=".sidebar .box.highlighted  .box-heading" data-attrs="background-color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
                                   </div>
                                   <div class="form-group">
                                      <label>Heading Color</label>
                                      <input value="" size="10" name="customize[highlighted-modules][]" data-match="highlighted-modules" type="text" class="input-setting" data-selector=".sidebar .box.highlighted .box-heading span" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
                                   </div>
                                   <div class="form-group">
                                      <label>Content Background</label>
                                      <input value="" size="10" name="customize[highlighted-modules][]" data-match="highlighted-modules" type="text" class="input-setting" data-selector=".sidebar .box.highlighted .box-content" data-attrs="background-color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
                                   </div>
                                   <div class="form-group">
                                      <label>Content Color</label>
                                      <input value="" size="10" name="customize[highlighted-modules][]" data-match="highlighted-modules" type="text" class="input-setting" data-selector=".sidebar .box.highlighted .box-content" data-attrs="color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
                                   </div>
                                   <div class="form-group">
                                      <label>Border Color</label>
                                      <input value="" size="10" name="customize[highlighted-modules][]" data-match="highlighted-modules" type="text" class="input-setting" data-selector=".sidebar .product-block, .box.nopadding ul li" data-attrs="border-bottom-color" readonly="readonly"><a href="#" class="clear-bg btn btn-small btn-theme-default">Clear</a>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
              <p class="text-right">
	      	 	<button id="save-setting" class="btn btn-primary">Lưu</button>
	      	  </p>            
           </div>
        </div>
      </div>
    </form>
</div>
<script type="text/javascript">
  $('#myTab a').click(function(e) {
      e.preventDefault();
      $(this).tab('show');
  })
  $('#myTab a:first').tab('show');


  var $MAINCONTAINER = $("html");

  /**
   * BACKGROUND-IMAGE SELECTION
   */
  $(".background-images").each(function() {
      var $parent = this;
      var $input = $(".input-setting", $parent);
      $(".bi-wrapper > div", this).click(function() {
          $input.val($(this).data('val'));
          $('.bi-wrapper > div', $parent).removeClass('active');
          $(this).addClass('active');

          if ($input.data('selector')) {
              $($input.data('selector'), $($MAINCONTAINER)).css($input.data('attrs'), 'url(' + $(this).data('image') + ')');
          }
      });
  });

  $('input.change-control').change(function(){
  		var text = $(this).val();
  		var selector = $(this).attr('data-selector');
  		$(selector).text(text);
  });

  $('.change-control-menu').change(function(){
  		var group_id = $(this).val();
  		var selector = $(this).attr('data-selector');
  		var current = $(this);
  		if($.trim(group_id) == '' || $.trim(group_id) == null){
  			$(selector).remove();
  		}
  		else{
  			current.attr('disabled','disabled');
  			$.ajax({
	            url: '<?php echo base_url(); ?>shop/get_menu_by_group/'+group_id,
	            type: 'POST',
	            data: {},
	            dataType:'json',
	            success: function(reponse) {
	                if(reponse['status'] == 'success'){
	                    $('#mainmenutop .navbar-collapse').html(reponse['reponse']);
	                }
	            },
	            complete: function() {
	            	current.removeAttr('disabled');
	            },
	            error:function(data){
	                console.log(data['responseText']);
	            }
	        });
  		}
  });

  $(".clear-bg").click(function() {
      var $parent = $(this).parent();
      var $input = $(".input-setting", $parent);
      if ($input.val('')) {
          if ($parent.hasClass("background-images")) {
              $('.bi-wrapper > div', $parent).removeClass('active');
              $($input.data('selector'), $("#main-preview iframe").contents()).css($input.data('attrs'), 'none');
          } else {
              $input.attr('style', '')
          }
          $($input.data('selector'), $($MAINCONTAINER)).css($input.data('attrs'), 'inherit');

      }
      $input.val('');

      return false;
  });



  $('.accordion-group input.input-setting').each(function() {
      var input = this;
      $(input).attr('readonly', 'readonly');
      $(input).ColorPicker({
          onChange: function(hsb, hex, rgb) {
              $(input).css('backgroundColor', '#' + hex);
              $(input).val(hex);
              if ($(input).data('selector')) {
                  $($MAINCONTAINER).find($(input).data('selector')).css($(input).data('attrs'), "#" + $(input).val())
              }
          }
      });
  });
  $('.accordion-group select.input-setting').change(function() {
      var input = this;
      if ($(input).data('selector')) {
          var ex = $(input).data('attrs') == 'font-size' ? 'px' : "";
          $($MAINCONTAINER).find($(input).data('selector')).css($(input).data('attrs'), $(input).val() + ex);
      }
  });

  $('.panel-collapse').on('show.bs.collapse', function (e) {
    	//alert('Event fired on #' + e.currentTarget.id);
  });

  $(document).ready(function() {
  	  //$("#sidebar-left .sidebar,#sidebar-right .sidebar,#footer .sort-ui").sortable();
      //$("#sidebar-left .sidebar,#sidebar-right .sidebar,#footer .sort-ui").disableSelection();
  	  $("#sidebar-left .sidebar,#sidebar-right .sidebar,#footer .sort-ui" ).sortable({
      	connectWith: ".sidebar"
      }).disableSelection();
      
  	  $('#custom-template .list-template li a').click(function(){
  	  	 var template = $(this).attr('data-template');
  	  	 $('#custom-template .list-template li img').removeClass('border-red');
  	  	 $(this).find('img').addClass('border-red');
  	  	 if(template == '3-column'){
  	  	 	$(".wrap-content #sidebar-main").removeClass('col-md-9').removeClass('col-md-12').addClass('col-md-6');
  	  	 	$(".wrap-content #sidebar-left").show();
  	  	 	$(".wrap-content #sidebar-right").show();
  	  	 	$("#layout_template").val('3-column');
  	  	 }
  	  	 else if(template == 'sidebar-left'){
  	  	 	$(".wrap-content #sidebar-main").removeClass('col-md-6').removeClass('col-md-12').addClass('col-md-9');
  	  	 	$(".wrap-content #sidebar-left").show();
  	  	 	$(".wrap-content #sidebar-right").hide();
  	  	 	$("#layout_template").val('sidebar-left');
  	  	 }
  	  	 else if(template == 'sidebar-right'){
  	  	 	$(".wrap-content #sidebar-main").removeClass('col-md-6').removeClass('col-md-12').addClass('col-md-9');
  	  	 	$(".wrap-content #sidebar-left").hide();
  	  	 	$(".wrap-content #sidebar-right").show();
  	  	 	$("#layout_template").val('sidebar-right');
  	  	 }
  	  	 else{
  	  	 	$(".wrap-content #sidebar-main").removeClass('col-md-6').removeClass('col-md-9').addClass('col-md-12');
  	  	 	$(".wrap-content #sidebar-left").hide();
  	  	 	$(".wrap-content #sidebar-right").hide();
  	  	 	$("#layout_template").val('full-width');
  	  	 }
  	  	 return false;
  	  });

      $(".paneltool .panelbutton").click(function() {
        $(this).parent().toggleClass("active");
      });

      $("#form-setting #save-setting").click(function(){
      	 var data  = $("#form-setting").serialize();
      	 var current = $(this);
      	 current.addClass('loading');
      	 current.attr('disabled','disabled');
      	  $.ajax({
            url: '<?php echo base_url(); ?>shop/save_setting_website',
            type: 'POST',
            data: data,
            dataType:'json',
            success: function(reponse) {
                console.log(reponse);
                if(reponse['status']=='success'){
                    //location.reload();
                }
           },
           complete: function() {
                current.removeAttr('disabled');
                current.removeClass('loading');
           },
           error:function(data){
                console.log(data['responseText']);
           }
        });
      	return false;
      });
  });
</script>
<style type="text/css">
	.accordion-group input.form-control,
	.accordion-group select.form-control{
		width: 100% !important;
		color: #292929 !important;
		margin-bottom: 10px !important;
	}
	.accordion-group .accordion-body{
		overflow-y: scroll;
    	max-height: 300px;
	}
	.list-template li{
		display: inline-block;
	}
	.list-template li img{
		width: 70px;
		margin-right: 10px;
	}
	.border-red{
		border: 1px solid red !important;
	}
</style>