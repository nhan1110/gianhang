<div class="content-box-large">
  	<div class="panel-body">
    	<?php if(isset($error) && $error != null ): ?>
	    	<div class="alert alert-danger">
	    	  <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
			  <?php echo $error; ?>
			</div>
		<?php endif; ?>
		<?php if(isset($success) && $success != null): ?>
			<div class="alert alert-success">
			  <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
			  <?php echo $success; ?>
			</div>
		<?php endif; ?>
    	<form role="form" method="post" action="<?php echo @$action; ?>">
		    <div class="row">
		       <div class="col-md-8 col-sm-7">
		       		<div class="form-group">
					    <label for="title">Tiêu đề:</label>
					    <input type="text" class="form-control required" value="<?php echo @$post->Title; ?>" name="title" id="title">
				    </div>
				    <div class="form-group">
					    <label for="title">Nội dung:</label>
					    <?php echo $this->ckeditor->editor('content',@$post->Content);?>
				    </div>
				    <div class="form-group">
					    <label for="title">Trạng thái:</label>
					    <select data-value="<?php echo @$post->Status; ?>" class="form-control required" name="status">
					    	<option value="publish">Publish</option>
					    	<option value="draft">Draft</option>
					    </select>
				    </div>
				    <div class="form-group">
					    <label for="title">Type:</label>
					    <select data-value="<?php echo @$post->Type_News; ?>" class="form-control required" name="type">
					    	<option value="normal">Normal</option>
					    	<option value="focus">Focus</option>
					    	<option value="promotion">Promotion</option>
					    </select>
				    </div>
				    <div class="form-group text-right">
				  		<a class="btn btn-default" href="<?php echo base_url(); ?>profile/post/">Quay lại</a>
				    	<button type="submit" class="btn btn-primary">Save</button>
					</div>
		       </div>
		       <div class="col-md-4 col-sm-5">
		       		<div class="box-custom box">
		                <h3>Chọn thể loại :</h3>
		                <div class="box-add-menu" id="form-add-menu-page">
		                    <ul class="list-item">
		                    	<?php if(isset($category) && $category!=null): ?>
			                       <?php foreach ($category as $key => $value) : ?>
			                          <li>
					                       <input type="checkbox" <?php if(is_array($cn) && in_array($value->ID,$cn)){ echo 'checked'; }?> id="cat-<?php echo $value->ID; ?>" value="<?php echo $value->ID; ?>" name="cat[]">
					                       <label for="cat-<?php echo $value->ID; ?>"><span><?php echo $value->Name; ?></span></label>
				                      </li>
				                   <?php endforeach; ?>
			                    <?php endif; ?>
			               	</ul>
		                </div>
		            </div>
		            <div class="form-group">
		            	<label for="title">Chọn ảnh:</label>
		            	<?php
		            		$bg = '';
		            		$cls = '';
		            		if(isset($post->Path_Large) && $post->Path_Large!=null) {
		            			$bg = 'style = "background-image:url(\''.$post->Path_Large.'\');"';
		            			$cls = 'active';
		            		}
		            	?>
			            <div class="media <?php echo $cls; ?>" <?php echo $bg;  ?>>
			            	<span class="remove-media"><a href="#"><i class="fa fa-times"></i></a></span>
			            	<a href="#" class="choose-upload">
				            	<i class="fa fa-plus"></i>
				            	<input type="hidden" name="media_id" id="media_id" value="<?php echo @$post->Media_ID; ?>">
			            	</a>
			            </div>
			        </div>
		       </div>
			</div>
		</form>
	</div>
</div>
<style type="text/css">
	.box-add-menu{
      height: 220px;
      overflow-y: scroll;
      border: 1px solid #ccc;
      padding: 15px 0;
      margin-bottom: 10px;
      background: #fff;
   }
   .list-item,
   .list-item ul{
      list-style: none;
      padding-left: 20px;
   }
   .list-item li a{
      display: block;
      margin-bottom: 5px;
      font-size: 16px;
   }
   .box-custom{
      padding: 20px;
      background: rgba(204, 204, 204, 0.2);
      margin-bottom: 20px;
   }
   .box-custom h3{
      font-size: 13px;
      text-transform: capitalize;
      margin-top: 0;
   }
   .panel-default{
      box-shadow: none;
   }
   .media{
   	  width: 100%;
	  height: 220px;
	  border: 2px dashed #ccc;
	  text-align: center;
	  background-repeat: no-repeat;
	  background-size: cover;
	  z-index: 1;
	  position: relative;
   }
   .media .remove-media{
	  position: absolute;
	  top: 7px;
	  right: 10px;
	  font-size: 16px;
	  z-index: 100;
	  display: none;
   }
   .media .remove-media i{
   	  color: red;
   }
   .media a.choose-upload{
   	  display: block;
      height: 100%;
      line-height: 230px;
   }
   .media.active .remove-media,
   .media.active .remove-media i{
   	  display: inline-block;
   }
   .media.active i{
   	  display: none;
   }
   .media.active{
   	   border:1px solid #ccc;
   }
   .media a.choose-upload i{
   	  font-size: 30px;
   }
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$("#modal_upload #select-image").on('click',function(){
			if($("#modal_upload .grid-photo > .active").length > 0 ){
				var current = $("#modal_upload .grid-photo > .active");
				var media_id = current.attr('data-id');
				var src = current.find('.image-item').attr('src');
				if(isNaN(media_id) == false){
					$("#media_id").val(media_id);
					$(".media").addClass('active');
					$(".media").css('background-image','url("'+src+'")');
					$("#modal_upload").modal('toggle');
				}
			}
		});

		$(".media .remove-media a").on('click',function(){
			$("#media_id").val('');
			$(".media").css('background-image','');
			$(".media").removeClass('active');
			return false;
		});
	});
</script>