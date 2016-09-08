<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) && $title != null ? $title : 'Gian hàng của tôi';  ?></title>
    <!-- Bootstrap -->
    <link href="<?php echo skin_url(); ?>/shop/admin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="<?php echo skin_url(); ?>/shop/admin/css/styles.css" rel="stylesheet">
    <!-- Grid Custom -->
    <link href="<?php echo skin_url(); ?>/shop/admin/css/bootstrap-grid-custom.css" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.Jcrop.css">
    <link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.Jcrop.min.css">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo skin_url(); ?>/shop/admin/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo skin_url(); ?>/js/main.js"></script>
    <script src="<?php echo skin_url(); ?>/shop/admin/js/custom.js"></script>
    <script src="<?php echo skin_url(); ?>/js/jquery.form.js"></script>
    <script src="<?php echo skin_url(); ?>/js/jquery.Jcrop.js"></script>
    <script src="<?php echo skin_url(); ?>/js/jquery.Jcrop.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
    	var base_url = '<?php echo base_url(); ?>';
    </script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
   	<div class="wrap">
	  	<div class="header">
		     <div class="container">
		        <div class="row">
		           <div class="col-md-5 col-sm-4">
		              <!-- Logo -->
		              <div class="logo">
		                 <h1><a href="<?php echo base_url('/profile/'); ?>">VN-Market</a></h1>
		              </div>
		           </div>
		           <div class="col-md-5 col-sm-4">
		           </div>
		           <div class="col-md-2 col-sm-4">
		              <div class="navbar navbar-inverse" role="banner">
		                  <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
		                    <ul class="nav navbar-nav">
		                      <li class="dropdown">
		                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-bottom:10px;padding-top:10px;">
		                        	<?php
	                                    $avatar = skin_url("/images/default_avatar.png");
	                                    if (isset($member->Avatar) && $member->Avatar != null) {
	                                        if( !preg_match("~^(?:f|ht)tps?://~i", $member->Avatar) ) {
	                                            if(file_exists('.' . $member->Avatar)) {
	                                                $avatar = $member->Avatar;
	                                            }
	                                        }
	                                        else {// avatar facebook,google+
	                                           $avatar = $member->Avatar; 
	                                        }
	                                    }
	                                ?>
	                                <img class="avatar" style="width:30px;border-radius:50%;" src="<?php echo $avatar; ?>">
		                        	Tài khoản <b class="caret"></b>
		                        </a>
		                        <ul class="dropdown-menu animated fadeInUp">
		                          <li><a href="<?php echo base_url('/profile/'); ?>"><i class="fa fa-user"></i> Thông tin tài khoản</a></li>
		                          <li><a href="<?php echo base_url('/profile/changepassword/'); ?>"><i class="fa fa-pencil-square-o"></i> Thay đổi mật khẩu</a></li>
		                          <li><a href="<?php echo base_url('/profile/logout/'); ?>"><i class="fa fa-sign-out"></i> Đăng xuất</a></li>
		                        </ul>
		                      </li>
		                    </ul>
		                  </nav>
		              </div>
		           </div>
		        </div>
		     </div>
		</div>

	    <div class="page-content">
      		<div class="container">
    			<div class="row">
					<div class="col-md-3">
					    <div class="sidebar content-box" style="display: block;">
			                <ul class="nav">
			                    <!-- Main menu -->
			                    <li><a href="<?php echo base_url('/profile/'); ?>"><i class="fa fa-user"></i> Thông tin tài khoản</a></li>
			                    <li><a href="<?php echo base_url('/profile/edit'); ?>"><i class="fa fa-pencil"></i> Chỉnh sữa tài khoản</a></li>
			                    <li><a href="<?php echo base_url('/profile/menu'); ?>"><i class="glyphicon glyphicon-list"></i> Menu</a></li>
			                    <li><a href="<?php echo base_url('/profile/page'); ?>"><i class="fa fa-file-o"></i> Trang</a></li>
			                    <li><a href="<?php echo base_url('/profile/post'); ?>"><i class="fa fa-paper-plane"></i> Bài viết</a></li>
			                    <li><a href="<?php echo base_url('/profile/category_news'); ?>"><i class="fa fa-rocket"></i> Thể loại bài viết</a></li>
			                    <li><a href="<?php echo base_url('/profile/add_product'); ?>"><i class="fa fa-edit"></i> Đăng sản phẩm</a></li>
			                    <li><a href="<?php echo base_url('/profile/my_product/'); ?>"><i class="fa fa-list-ul"></i> Danh sách sản phẩm</a></li>
			                    <li><a href="#"><i class="fa fa-thumbs-o-up"></i> Sản phẩm ưa thích</a></li>
			                    <li><a href="#" class="choose-upload"><i class="fa fa-photo"></i> Ảnh đã đăng</a></li>
			                    <li><a href="#"><i class="fa fa-user-plus"></i> Tài khoản ưa thích</a></li>
			                    <li><a href="<?php echo base_url('/profile/payment/'); ?>"><i class="fa fa-credit-card-alt"></i> Lịch sử thanh toán</a></li>
			                    <li><a href="#"><i class="fa fa-commenting-o"></i> Bình luận & góp ý</a></li>
			                	<li><a href="#"><i class="fa fa-cog"></i> Cài đặt</a></li>
			                </ul>
			            </div>
					</div>
					<div class="col-md-9 ">