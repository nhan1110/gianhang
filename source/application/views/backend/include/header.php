<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="language" content="en" />
        <title>Administration</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo skin_admin_url(); ?>/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="<?php echo skin_admin_url(); ?>/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo skin_admin_url(); ?>/dist/css/AdminLTE.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo skin_admin_url(); ?>/dist/css/skins/_all-skins.min.css">
        <!-- Multi Checkbox-->
        <link rel="stylesheet" href="<?php echo skin_admin_url(); ?>/dist/css/style.css">
        <link rel="stylesheet" href="<?php echo skin_admin_url(); ?>/plugins/datatables/dataTables.bootstrap.css">
       
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script>
            var base_url = "<?php echo base_url(); ?>";
        	  var base_admin_url = "<?php echo base_url(); ?>/admin/";
            var frontend = false;
        </script>
        <!-- jQuery 2.1.4 -->
        <script src="<?php echo skin_admin_url(); ?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="<?php echo skin_admin_url(); ?>/bootstrap/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="<?php echo skin_admin_url(); ?>/plugins/fastclick/fastclick.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo skin_admin_url(); ?>/dist/js/app.min.js"></script>
        <!-- Sparkline -->
        <script src="<?php echo skin_admin_url(); ?>/plugins/sparkline/jquery.sparkline.min.js"></script>
        <!-- jvectormap -->
        <script src="<?php echo skin_admin_url(); ?>/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="<?php echo skin_admin_url(); ?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <!-- SlimScroll 1.3.0 -->
        <script src="<?php echo skin_admin_url(); ?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- ChartJS 1.0.1 -->
        <script src="<?php echo skin_admin_url(); ?>/plugins/chartjs/Chart.min.js"></script>
        <script src="<?php echo skin_admin_url(); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo skin_admin_url(); ?>/plugins/datatables/dataTables.bootstrap.min.js"></script>

        <script src="<?php echo skin_url();?>/js/jquery.form.js" type="text/javascript"></script>
        <script src="<?php echo skin_url() ?>/js/jquery.Jcrop.js"></script>
        <script src="<?php echo skin_url() ?>/js/jquery.Jcrop.min.js"></script>
        <script src="<?php echo skin_url("js/main.js") ;?>"></script>
        <?php
	     	$model = new Cronjobnotification_model();
	        $model->where('Status','0')->order_by('Createdat', 'DESC');
	        $model->get(10);
	        $notification_admin_model = $model;
	        $model_count = new Cronjobnotification_model();
	        $notification_admin_count = $model_count->where('Status','0')->count();
	        
	        // =======================================
	    	// Load inbox
	        $model = new Notification_model();
	        $model->where('Status','0')->where('Type_Notification','0')->order_by('Created_at', 'DESC');
	        $model->get(10);
	        $inbox_admin_model = $model;
	        $model_count = new Notification_model();
	        $inbox_admin_count = $model_count->where('Status','0')->where('Type_Notification','0')->count();
	     ?>
	    <?php $admin_info = $this->session->userdata('admin_info'); ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
               <!-- Logo -->
               <a href="index2.html" class="logo">
                  <!-- mini logo for sidebar mini 50x50 pixels -->
                  <span class="logo-mini"><b>A</b>VM</span>
                  <!-- logo for regular state and mobile devices -->
                  <span class="logo-lg"><b>Admin</b>VM</span>
               </a>
               <!-- Header Navbar: style can be found in header.less -->
               <nav class="navbar navbar-static-top" role="navigation">
                  <!-- Sidebar toggle button-->
                  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                  <span class="sr-only">Toggle navigation</span>
                  </a>
                  <!-- Navbar Right Menu -->
                  <div class="navbar-custom-menu">
                     <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
             			<li class="dropdown messages-menu">
                           	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                           		<i class="fa fa-envelope-o"></i>
                           		<span class="label label-success"><?php echo @$inbox_admin_count; ?></span>
                           	</a>
                           	<ul class="dropdown-menu">
                              	<li class="header">Bạn có <?php echo @$inbox_admin_count; ?> tin nhắn</li>
                              	<li>
                                 	<!-- inner menu: contains the actual data -->
                                 	<ul class="menu">
             						<?php
             							if (isset($inbox_admin_model) && $inbox_admin_model != null) {
									        foreach ($inbox_admin_model as $key => $value) {
									        	echo '		<li>
								                               	<a href="#"><i class="fa fa-users text-aqua"></i> ' . $value->Title . '</a>
								                            </li>';
									        }
								        }
             						?>
             						</ul>
                              	<li class="footer"><a href="<?php echo base_url('admin/inbox/'); ?>">Xem tất cả</a></li>
                           	</ul>
                        </li>
                        <li class="dropdown notifications-menu">
                           	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                           		<i class="fa fa-bell-o"></i>
                           		<span class="label label-warning"><?php echo $notification_admin_count; ?></span>
                           	</a>
                           	<ul class="dropdown-menu">
                              	<li class="header">Bạn có <?php echo $notification_admin_count; ?> thông báo</li>
                              	<li>
                                 	<!-- inner menu: contains the actual data -->
                                 	<ul class="menu">
             						<?php
             							if (isset($notification_admin_model) && $notification_admin_model != null) {
									        foreach ($notification_admin_model as $key => $value) {
									        	echo '		<li>
								                               	<a href="#"><i class="fa fa-users text-aqua"></i> ' . $value->Title . '</a>
								                            </li>';
									        }
								        }
             						?>
             						</ul>
                              	<li class="footer"><a href="<?php echo base_url('admin/notification/notify'); ?>">Xem tất cả</a></li>
                           	</ul>
                        </li>
                        
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                           <img src="<?php echo base_url(); ?><?php echo $admin_info['user_avatar']; ?>" class="user-image" alt="User Image">
	                           <span class="hidden-xs"><?php echo $admin_info['user_nick']; ?></span>
                           </a>
                           <ul class="dropdown-menu">
                              <!-- User image -->
                              <li class="user-header">
                                 <img src="<?php echo base_url(); ?><?php echo $admin_info['user_avatar']; ?>" class="img-circle" alt="User Image">
                                 <p>
                                    <?php echo $this->session->userdata('user_nick'); ?>
                                    <small><?php echo $this->session->userdata('user_nick'); ?></small>
                                 </p>
                              </li>
                              <!-- Menu Footer-->
                              <li class="user-footer">
                                 <div class="pull-left">
                                    <a href="<?php echo base_url('admin/profile'); ?>" class="btn btn-default btn-flat">Profile</a>
                                 </div>
                                 <div class="pull-right">
                                    <a href="<?php echo base_url('admin/profile/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                                 </div>
                              </li>
                           </ul>
                        </li>
                     </ul>
                  </div>
               </nav>
            </header>

            <!-- Left side column. contains the logo and sidebar -->

            <aside class="main-sidebar">
               <!-- sidebar: style can be found in sidebar.less -->
               <section class="sidebar">
                  <!-- Sidebar user panel -->
                  <div class="user-panel">
                     <div class="pull-left image">
                        <img src="<?php echo base_url(); ?><?php echo $admin_info['user_avatar']; ?>" class="img-circle" alt="User Image">
                     </div>
                     <div class="pull-left info">
                        <p><?php echo $this->session->userdata('user_nick'); ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                     </div>
                  </div>
                  <!-- sidebar menu: : style can be found in sidebar.less -->
				  <?php echo $this->session->userdata('menu_admin'); ?>
               </section>
               <!-- /.sidebar -->
            </aside>