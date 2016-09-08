<!DOCTYPE html>
<html dir="ltr" class="ltr" lang="en">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Pav FoodStore - Responsive Opencart Theme</title>
      <link href="<?php echo skin_url(); ?>/shop/css/bootstrap.css" rel="stylesheet">
      <link href="<?php echo skin_url(); ?>/shop/css/stylesheet.css" rel="stylesheet">
      <link href="<?php echo skin_url(); ?>/shop/css/paneltool.css" rel="stylesheet">
      <link href="<?php echo skin_url(); ?>/shop/css/colorpicker.css" rel="stylesheet">
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
      <link href="<?php echo skin_url(); ?>/shop/css/magnific-popup.css" rel="stylesheet">
      <link href="<?php echo skin_url(); ?>/shop/css/owl.carousel.css" rel="stylesheet">
      <link href="<?php echo skin_url(); ?>/shop/css/owl.transitions.css" rel="stylesheet">
      <link href="<?php echo skin_url(); ?>/shop/css/typo.css" rel="stylesheet">
      <link href="<?php echo skin_url(); ?>/shop/css/pavproductcarousel.css" rel="stylesheet">
      <link href="<?php echo skin_url(); ?>/shop/css/magnific-popup.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.Jcrop.css">
	   <link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.Jcrop.min.css">


      <script type="text/javascript" src="<?php echo skin_url(); ?>/shop/js/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="<?php echo skin_url(); ?>/shop/js/jquery.magnific-popup.min.js"></script>
      <script type="text/javascript" src="<?php echo skin_url(); ?>/shop/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="<?php echo skin_url(); ?>/shop/js/common.js"></script>
      <script type="text/javascript" src="<?php echo skin_url(); ?>/shop/js/commons.js"></script>
      <script type="text/javascript" src="<?php echo skin_url(); ?>/shop/js/owl.carousel.min.js"></script>
      <script type="text/javascript" src="<?php echo skin_url(); ?>/shop/js/colorpicker.js"></script>
      <script src="<?php echo skin_url("js/jquery.form.js");?>" type="text/javascript"></script>
   	<script src="<?php echo skin_url() ?>/js/jquery.Jcrop.js"></script>
	   <script src="<?php echo skin_url() ?>/js/jquery.Jcrop.min.js"></script>
	   <script src="<?php echo skin_url(); ?>/shop/js/edit.js" type="text/javascript"></script>
   </head>
   <body id="offcanvas-container" class="offcanvas-container common-home page-home">
      <section class="row-offcanvas row-offcanvas-left offcanvas-pusher">
        <div id="page">
         <!-- header -->
         <header id="header" style="background-image:url('<?php echo @$company->Company_Banner; ?>');">
         	<span class="edit-builder-banner">
	         	<a class="text-white" href="#" onclick="$('#update-banner #ImageUploader_banner').click();return false;">
	         		<i class="fa fa-3 fa-pencil"></i> <small>Thay đổi Banner</small>
	         	</a>
         	</span>
            <div id="header-main">
               <div class="container">
                  <div class="row header-wrap">
                     <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 inner">
                        <span class="edit-builder inline-block" style="margin-top:20px;">
	                        <a class="action-builder" href="#" onclick="$('#imageCropper-modal #ImageUploader_image').click();return false;"><i class="fa-pencil fa"></i></a>
	                        <?php
	                        	$logo = skin_url().'/shop/images/logo1.png';
	                        	if(isset($company->Company_Logo) && $company->Company_Logo!=null && file_exists('.'.$company->Company_Logo)){
	                        		$logo = $company->Company_Logo;
	                        	}
	                        ?>
	                        <img class="logo-shop" src="<?php echo $logo; ?>">
                        </span>
                     </div>
                     <div class="header-right col-lg-2 col-md-2 col-sm-12 header-hidden inner">
                        <div id="cart" class="cart">
                           <span class="fa fa-shopping-cart pull-left"></span>
                           <div data-toggle="dropdown" data-loading-text="Loading..." class="heading dropdown-toggle">
                              <div class="cart-inner media-body">
                                 <h4>Giỏ hàng</h4>
                                 <a><span id="cart-total">0 item(s) - $0.00</span></a>
                              </div>
                           </div>
                           <ul class="dropdown-menu">
                              <li>
                                 <p class="text-center">Your shopping cart is empty!</p>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div id="pav-mainnav">
               <div class="container">
                  <div class="mainnav-wrap">
                     <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                           <div class="navbar navbar-inverse">
                               <div id="mainmenutop" class="megamenu" role="navigation">
                                    <div class="navbar-header">
                                       <a href="javascript:;" data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle">
                                          <span class="icon-bar"></span>
                                          <span class="icon-bar"></span>
                                          <span class="icon-bar"></span>
                                       </a>
                                       <div class="collapse navbar-collapse navbar-ex1-collapse">
                                          <ul class="nav navbar-nav megamenu"></ul>
                                       </div>
                                    </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
                           <div id="search" class="pull-right">
                              <input type="text" name="search" value="" placeholder="Tìm kiếm" class="input-search">
                              <span class="button-search"></span>                      
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
        </header>
        <!-- /header -->

		<!--model bootstrap logo-->
		<div class="modal fade" id="imageCropper-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" data-backdrop="static" style="display: none;">
		   <div class="modal-dialog" role="document">
		      <div class="modal-content">
		        <form method="POST" action="<?php echo base_url('/shop/save_logo'); ?>" enctype="multipart/form-data" id="crop-logo">
		           <div class="modal-header box-cyan text-white">
		              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		              <h4 class="modal-title" id="modal-label">Thay đổi logo</h4>
		           </div>
		           <div class="modal-body" style="position: relative;">
		              <div id="loading-custom" class="custom-loading"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
		              <input type="hidden" class="hidden" id="choose" name="choose" value="avatar">
		              <input type="hidden" class="hidden" id="x" name="x">
		              <input type="hidden" class="hidden" id="y" name="y">
		              <input type="hidden" class="hidden" id="w" name="w">
		              <input type="hidden" class="hidden" id="h" name="h">
		              <input type="hidden" class="hidden" value="" name="image_w" id="image_w">
		              <input type="hidden" class="hidden" value="" name="image_h" id="image_h">
		              <input style="display:none;" accept="image/*" onchange="readURL(this);" name="fileupload" id="ImageUploader_image" type="file">
		              <img id="uploadPreview" src="" style="display:none; max-width:100%;">
		           </div>
		           <div class="modal-footer text-right">
		              <button class="btn btn-gray" class="close" data-dismiss="modal" aria-label="Close">Hủy bỏ</button>
		              <button id="btnSaveView2" disabled="disabled" class="btn btn-primary" type="submit" name="yt2">Lưu và xem</button>
		           </div>
		        </form>
		      </div>
		   </div>
		</div>

		<!--model bootstrap avatar-->
		<div id="update-banner" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-label">
		   <div class="modal-dialog modal-lg">
		      <!--modal-lg-->
		      <div class="modal-content">
		         <form method="POST" action="<?php echo base_url('/shop/save_banner'); ?>" enctype="multipart/form-data" id="crop-banner">
		            <div class="modal-header box-cyan text-white">
		              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		              <h4 class="modal-title" id="modal-label">Thay đổi banner</h4>
		            </div>
		            <div class="modal-body" style="position: relative;">
		              <div id="loading-custom" class="custom-loading"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
		              <input type="hidden" class="hidden" id="choose" name="choose" value="avatar">
		              <input type="hidden" class="hidden" id="x" name="x">
		              <input type="hidden" class="hidden" id="y" name="y">
		              <input type="hidden" class="hidden" id="w" name="w">
		              <input type="hidden" class="hidden" id="h" name="h">
		              <input type="hidden" class="hidden" value="" name="image_w" id="image_w">
		              <input type="hidden" class="hidden" value="" name="image_h" id="image_h">
		              <input style="display:none;" accept="image/*" onchange="readURL1(this);" name="fileupload" id="ImageUploader_banner" type="file">
		              <img id="uploadPreview" src="" style="display:none; max-width:100%;">
		            </div>
		            <div class="modal-footer text-right">
		              <button class="btn btn-gray" class="close" data-dismiss="modal" aria-label="Close">Hủy bỏ</button>
		              <button id="btnSaveView3" disabled="disabled" class="btn btn-primary" type="submit" name="yt2">Lưu và xem</button>
		            </div>
		        </form>
		      </div>
		   </div>
		</div>