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
		    <div class="form-group">
			    <label for="title">Tiêu đề:</label>
			    <input type="text" class="form-control required" value="<?php echo @$category_news->Name; ?>" name="title" id="title">
		    </div>
		    <div class="form-group">
			    <label for="title">Slug:</label>
			    <input type="text" class="form-control required" value="<?php echo @$category_news->Slug; ?>" name="slug" id="<?php if(@$disable != 'yes') { echo 'slug'; }  ?>">
		    </div>
		    <!--<div class="form-group">
			    <label for="title">Chọn cha:</label>
			    <select class="form-control required" name="parent_id">
			    	<option value="0">Chọn</option>
			    </select>
		    </div>-->
		  	<div class="form-group text-right">
		  		<a class="btn btn-default" href="<?php echo base_url(); ?>profile/category_news/">Quay lại</a>
		    	<button type="submit" class="btn btn-primary">Save</button>
			</div>
		</form>
	</div>
</div>
