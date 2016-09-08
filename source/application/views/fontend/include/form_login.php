<div id="form-login-container" style="position: relative;">
    <div class="row">
        <div class="col-md-12 text-right">
            <button id="hide_login"><i class="fa fa-times" style="margin-left:2px;" aria-hidden="true"></i></button>
        </div>
    </div>
    <form action="<?php echo base_url(); ?>accounts/login" method="post" id="form-login">
        <div class="custom-loading" style="bottom:0;">
            <div>
                <i class="ic ic-md ic-loading"></i>
            </div>
        </div>
        <?php
            $text = '';
            $style = 'display:none;';
            if(isset($message) && $message!=''){
                $text = $message;
                $style = '';
            }
        ?>
        <div class="alert alert-danger fade in" style="<?php echo @$style; ?>">
            <p><?php echo @$text; ?></p>
        </div>

        <div class="form-group has-feedback">
            <input type="email" name="email" class="form-control" placeholder="Địa chỉ email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-xs-6">
                    <div class="checkbox">
                        <input type="checkbox" id="remember" class="styled" name="remember">
                        <label for="checkbox1">
                            Ghi nhớ.
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-6">
                    <p class="text-right"><a class="text-lost-password" href="<?php echo base_url(); ?>accounts/forgot/">Quên mật khẩu?</a></p>
                </div>
                <!-- /.col -->
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
    </form>
    <p class="form-label-divider text-center">Hoặc đăng nhập bằng</p>
    <div class="social-auth-links text-center">
        <a href="<?php echo base_url(); ?>social/facebook/" class="btn btn-social btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
        <a href="<?php echo base_url(); ?>social/google/" class="btn btn-social btn-google"><i class="fa fa-google-plus"></i> Google+</a>
    </div>
    
</div>
<!-- /.social-auth-links -->
<script>
$(document).ready(function(){
    $("#hide_login").click(function(){
        $(".dropdown-content").hide();
        $(".user-menu-holder .not-login .dropdown").removeClass('open');
        $(".user-menu-holder .not-login .dropdown").hasClass('color_active');
    });
    
    $(".dropbtn").click(function(){
        $(".dropdown-content").show();
        $(".user-menu-holder .not-login .dropdown .dropdown-content").addClass('active');
    });
    
    $("#hide_signup").click(function(){
        $(".dropdown-content").hide();
        $(".user-menu-holder .not-login .dropdown").removeClass('open');
        $(".user-menu-holder .not-login .dropdown").hasClass('color_active');
    });
});
</script>