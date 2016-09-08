<div class="container">
	<h1 class="page-header">Đăng kí quảng cáo <?php echo @$record["Name"];?></h1>
	<div class="row">
		<div class="col-md-12">
			<form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Company name*:</label>
                    <input type="text" value="" name="company_name" class="form-control required" placeholder="Company name">
                    <?php echo form_error('company_name', '<div class="error">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label>Email company*:</label>
                    <input type="email" value="" name="email" class="form-control" placeholder="Email company">
                    <?php echo form_error('email', '<div class="error">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label>Logo company:</label>
                    <input type="file" value="" name="logo" class="form-control required" placeholder="Logo company" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Address company:</label>
                    <input type="text" value="" name="address" class="form-control" placeholder="Address company">
                </div>
                <div class="form-group">
                    <label>Phone company:</label>
                    <input type="text" value="" name="phone_number" class="form-control" placeholder="Phone company">
                </div>
                <div class="form-group">
                    <label>Web addresses company*:</label>
                    <input type="text" name="web_addresses" class="form-control" placeholder="Web addresses company">
                    <?php echo form_error('web_addresses', '<div class="error">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label>Description*:</label>
                    <textarea name="description" class="form-control" placeholder="Description"></textarea>
                    <?php echo form_error('description', '<div class="error">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <label>Content:</label>
                     <?php echo $this->ckeditor->editor('content',@$pages->Content);?>
                </div>  
                <div class="form-group text-right">
                    <button class="btn btn-primary" type="submit">Save / Update</button>
                </div>
            </form>
		</div>
	</div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("skins/css/page/advertise.css");?>">