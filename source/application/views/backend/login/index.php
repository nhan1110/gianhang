<!DOCTYPE html>



<html>

    <head>

        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>AdminLTE 2 | Dashboard</title>

        <!-- Tell the browser to be responsive to screen width -->

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- Bootstrap 3.3.5 -->

        <link rel="stylesheet" href="<?php echo skin_url(); ?>/admin/bootstrap/css/bootstrap.min.css">

        <!-- Font Awesome -->

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

        <!-- Ionicons -->

        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

        <!--[if lt IE 9]>

            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

        <![endif]-->



        <script>

            var base_url = "<?php echo base_url(); ?>";

        </script>

        <script src="<?php echo skin_url(); ?>/admin/plugins/jQuery/jQuery-2.1.4.min.js"></script>

        <script src="<?php echo skin_url(); ?>/admin/bootstrap/js/bootstrap.min.js"></script>

    </head>

    <body class="hold-transition skin-blue sidebar-mini">

        <div class="wrapper">

            <div class="container">

                <div class="row">

                    <div class="col-sm-6 col-md-4 col-md-offset-4">
                        <div class="account-wall">
                            <h1 class="text-center" ><img src="<?php echo skin_url("images/logo.png"); ?>" alt=""></h1>
                            <form class="form-signin" action="/admin/login" method="post" name="login">
                                <input type="text" name="email" class="form-control" placeholder="Email" >
                                <span class="red"><?php echo form_error('email'); ?></span>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                                <span class="red"><?php echo form_error('password'); ?></span>
                                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                                <label class="checkbox pull-left"> <input type="checkbox" value="remember-me" name="rememberme"> Remember me</label>
                                <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
                                <span class="red"><?php if(isset($error_login)) { echo $error_login;} ?></span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <style>

    	.red{color: red;}

        .form-signin

        {

            max-width: 330px;

            padding: 15px;

            margin: 0 auto;

        }

        .form-signin .form-signin-heading, .form-signin .checkbox

        {

            margin-bottom: 10px;

        }

        .form-signin .checkbox

        {

            font-weight: normal;

        }

        .form-signin .form-control

        {

            position: relative;

            font-size: 16px;

            height: auto;

            padding: 10px;

            -webkit-box-sizing: border-box;

            -moz-box-sizing: border-box;

            box-sizing: border-box;

        }

        .form-signin .form-control:focus

        {

            z-index: 2;

        }

        .form-signin input[type="text"]

        {

            margin-bottom: -1px;

            border-bottom-left-radius: 0;

            border-bottom-right-radius: 0;

        }

        .form-signin input[type="password"]

        {

            margin-bottom: 10px;

            border-top-left-radius: 0;

            border-top-right-radius: 0;

        }

        .account-wall

        {

            margin-top: 20px;

            padding: 40px 0px 20px 0px;

            background-color: #f7f7f7;

            -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);

            -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);

            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);

        }

        .login-title

        {

            color: #555;

            font-size: 18px;

            font-weight: 400;

            display: block;

        }

        .profile-img

        {

            width: 96px;

            height: 96px;

            margin: 0 auto 10px;

            display: block;

            -moz-border-radius: 50%;

            -webkit-border-radius: 50%;

            border-radius: 50%;

        }

        .need-help

        {

            margin-top: 10px;

        }

        .new-account

        {

            display: block;

            margin-top: 10px;

        }

        .checkbox.pull-left{padding-left: 20px;}

    </style>

</html>