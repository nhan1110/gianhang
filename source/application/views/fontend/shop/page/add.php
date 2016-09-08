<div class="container">
    <div class="row">
	    <?php $this->load->view('/fontend/shop/sidebar'); ?>
	    <section id="sidebar-main" class="col-md-9">
	    	<h3><?php echo @$title; ?></h3>
	    	<div style="height:15px;"></div>
	    	<?php if($this->session->flashdata('error')): ?>
		    	<div class="alert alert-danger">
		    	  <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
				  <?php echo $this->session->flashdata('error'); ?>
				</div>
			<?php endif; ?>

			<?php if($this->session->flashdata('success')): ?>
				<div class="alert alert-success">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
				  <?php echo $this->session->flashdata('success'); ?>
				</div>
			<?php endif; ?>

	    	<form role="form" method="post" action="<?php echo @$action; ?>">
			    <div class="form-group">
				    <label for="title">Tiêu đề:</label>
				    <input type="text" class="form-control" value="<?php echo @$page->Title; ?>" name="title" id="title">
			    </div>
			    <div class="form-group">
				    <label for="title">Nội dung:</label>
				    <textarea name="content" class="textarea form-control" rows="20"><?php echo @$page->Content; ?></textarea>
			    </div>
			  	<div class="form-group text-right">
			  		<a class="btn btn-default" href="<?php echo base_url(); ?>shop/page/">Quay lại</a>
			    	<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
	    </section>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/shop/css/bootstrap-wysihtml5.css" />
<script src="<?php echo skin_url(); ?>/shop/js/wysihtml5-0.3.0.js"></script>
<script src="<?php echo skin_url(); ?>/shop/js/bootstrap3-wysihtml5.js"></script>
<script>
    $('.textarea').wysihtml5();
</script>
<style type="text/css">
	.wysihtml5-toolbar .btn{
		border: 1px solid #ccc !important;
	}
</style>