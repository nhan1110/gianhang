<div class="container">
	<h1 class="page-header">Đăng kí quảng cáo</h1>
	<div class="row">
		<div class="col-md-12">
			<?php if(isset($advertise)) echo $advertise;?>
		</div>
	</div>
</div>
<div class="modal fade popup" id="messenger-register" tabindex="-1" role="dialog">
  	<div class="modal-dialog modal-md">
	    <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 id="title-messenger">Avertises</h2>
			</div>
		    <div class="modal-body">
		        <ul class="nav nav-tabs">
				  <li class="active"><a data-toggle="tab" href="#signin">Đăng nhập</a></li>
				  <li><a data-toggle="tab" href="#signup">Tạo tài khoản</a></li>
				</ul>
				<div class="tab-content">
				    <div class="messenger" style="display :none;"></div>
  					<div id="signin" class="tab-pane fade in active">
				      	<form action="" method="post" id="form-login-advertises">
							<div class="form-group has-feedback">
							 	<input type="email" id="advertises-email" data-validate = true data-required ="true" required class="form-control" placeholder="Email" autocomplete="off">
							 	<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
							 	<input type="password" id="advertises-password" data-validate = true data-required ="true" required class="form-control" placeholder="Password" autocomplete="off">
							 	<span class="glyphicon glyphicon-lock form-control-feedback"></span>
							</div>
							<div class="form-group text-right">
								<button type="submit" class="btn btn-danger">Đăng nhập</button>
							</div>
						</form>
					</div>
					<div id="signup" class="tab-pane fade">
						<form action="" method="post" id="form-signup-advertises">
							<div class="form-group has-feedback">
							 	<input type="email" id="advertises-email" data-validate = "true" data-required ="true" required class="form-control" placeholder="Email" autocomplete="off">
							 	<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							<div class="form-group has-feedback">
							 	<input type="text" id="advertises-company" data-validate = "true" data-required ="true" required class="form-control" placeholder="Tên công ty" autocomplete="off">
							 	<span class="glyphicon glyphicon-briefcase form-control-feedback"></span>
							</div>
							<div class="form-group text-right">
								<button type="submit" class="btn btn-danger">Đăng ký</button>
							</div>
						</form>
					</div>
				</div>
		    </div><!-- /.modal-content -->
	  	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("skins/css/page/advertise.css");?>">
<script type="text/javascript" src="<?php echo skin_url("js/advertises.js")?>"></script>
<?php if($this->input->get("signin") == "true"):?>
<script type="text/javascript">
    $("#messenger-register").modal();
</script>
<?php endif;?>
