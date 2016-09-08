<div id="form-signup-container" style="position: relative;">
    <div class="row">
        <div class="col-md-12 text-right">
            <button id="hide_signup"><i class="fa fa-times" style="margin-left:2px;" aria-hidden="true"></i></button>
        </div>
    </div>
    <form action="<?php echo base_url(); ?>accounts/signup" method="post" id="form-signup">
        <div class="custom-loading" style="bottom:0;">
            <div>
                <i class="ic ic-md ic-loading"></i>
            </div>
        </div>
        <div class="alert alert-danger fade in" style="display:none;">
            <p><strong>Danger!</strong> This alert box indicates a dangerous or potentially negative action.</p>
        </div>

        <div class="form-group has-feedback">
            <input type="text" name="first_name" class="form-control" placeholder="Họ đệm">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="text" name="last_name" class="form-control" placeholder="Tên">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="email" name="email" class="form-control" placeholder="Địa chỉ email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" name="confirm_password" class="form-control" placeholder="Xác nhận lại mật khẩu">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>
        <div class="form-group">
            <div id="g-recaptcha-signup"></div>
            <input type="hidden" name="g-recaptcha-response" id="recaptcha">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
    </form>
    <p class="form-label-divider text-center">Hoặc đăng ký bằng</p>

    <div class="social-auth-links text-center">
        <a href="<?php echo base_url(); ?>social/facebook/" class="btn btn-social btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
        <a href="<?php echo base_url(); ?>social/google/" class="btn btn-social btn-google"><i class="fa fa-google-plus"></i> Google+</a>
    </div>
    
</div>