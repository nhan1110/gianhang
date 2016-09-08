<section class="section section-forgot" style="margin-top: 30px;">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
			   <div class="panel panel-default">
			      <div class="panel-body">
			         <div class="text-center">
			            <h4><i class="fa fa-lock fa-4x"></i></h4>
			            <h2 class="text-center">Quên mật khẩu?</h2>
			            <p>Bạn có thể khôi phục mật khẩu ở đây.</p>
			            <div class="panel-body">
			               <form class="form" method="post" action="<?php echo base_url('/accounts/forgot/'); ?>">
			                  	<?php if(isset($message) && $message !=null ) : ?>
				                  	<div class="alert alert-danger fade in">
									    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
									    <?php echo $message; ?>
									</div>
								<?php endif; ?>
								<?php if(isset($success) && $success !=null ) : ?>
				                  	<div class="alert alert-success fade in">
									    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
									    <?php echo $success; ?>
									</div>
								<?php endif; ?>
			                  	<fieldset>
				                    <div class="form-group">
				                        <div class="input-group">
				                           <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
				                           <input placeholder="Địa chỉ email" class="form-control" name="email" type="email" required>
				                        </div>
				                    </div>
				                    <div class="form-group">
				                    	<div id="g-recaptcha-forgot" class="g-recaptcha"></div>
				                    </div>
				                    <div class="form-group">
				                        <input class="btn btn-lg btn-primary btn-block" value="Gửi yêu cầu" type="submit">
				                    </div>
			                  	</fieldset>
			               </form>
			            </div>
			         </div>
			      </div>
			   </div>
			</div>
		</div>
	</div>
</section>