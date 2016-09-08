<section class="section section-reset" style="margin-top: 30px;">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
			   <div class="panel panel-default">
			      <div class="panel-body">
			         <div class="text-center">
			            <h2 class="text-center">Đặt lại mật khẩu?</h2>
			            <p>Bạn có thể khôi phục mật khẩu ở đây.</p>
			            <div class="panel-body">
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
							<?php else: ?>
				                <form class="form" method="post" action="<?php echo base_url('/accounts/reset/?token='.@$token.'&email='.@$email); ?>">
				                  	<fieldset>
					                    <div class="form-group has-feedback">
								            <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
								            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
								        </div>
								        <div class="form-group has-feedback">
								            <input type="password" name="confirm_password" class="form-control" placeholder="Xác nhận lại mật khẩu" required>
								            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
								        </div>
					                    <div class="form-group">
					                        <input class="btn btn-lg btn-primary btn-block" value="Gửi yêu cầu" type="submit">
					                    </div>
				                  	</fieldset>
				                </form>
			                <?php endif; ?>
			            </div>
			         </div>
			      </div>
			   </div>
			</div>
		</div>
	</div>
</section>