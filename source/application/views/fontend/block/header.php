<?php
	// Query something for every page
	/*
	1. Config page
	2. Menu
	3. Search
	4. Top Keyword
	*/
	// $CI = &get_instance();
	$category_Type = new Category_Type();
    $cat_array = $category_Type->get_raw()->result_array();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="UTF-8">
        <title><?echo (isset($title_page) ? $title_page : "vn-market");?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Rao Vặt">
        <meta name="keywords" content="Rao Vặt">
        <link rel="shortcut icon" type="text/css" href="<?php echo skin_url(); ?>/images/logo-mobile.png" type="image/*"/>
        <?php
            $data["_token"] = @$_token;
            $this->load->view("fontend/include/head", $data);
        ?>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <div id="fb-root"></div>
        <script>
            (function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.7&appId=1067037869998313";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
    </head>
    <body>
        <div class="site-page">
           <header class="site-header">
            <nav id="menu-mobile" class="hidden-md hidden-lg">
                <ul>
                    <li><a href="/about/">dang nhap</a>
                        <ul>
                            <li><a href="/contact/">Contact</a></li>
                            <li><a href="/contact/">Contact</a></li>
                            <li><a href="/contact/">Contact</a></li>
                        </ul>
                    </li>
                    <li><a href="/">Home</a></li>

                    <li><a href="/contact/">Contact</a></li>
                </ul>
            </nav>

            <div class="header-top">
                <div class="container">
                    <div class="row">
                        <div class="header-top-left col-md-3">
                            <div class="site-brand">
                                <a id="btn-open-menu" href="#menu-mobile" class="hidden-md hidden-lg"><i class="icon-right ic ic-menu-color"></i></a>
                                <a href="<?php echo base_url(); ?>" title="">
                                    <img class="hidden-xs" src="<?php echo skin_url("images/logo.png"); ?>" alt="" title="">
                                    <img class="hidden-sm hidden-md hidden-lg" src="<?php echo skin_url("images/logo-mobile.png"); ?>" alt="" title="" width="32">
                                </a>
                            </div>
                        </div>
                        <div class="site-search col-md-6">
                            <form class="form form-search" action="<?php echo base_url("tim-kiem");?>" method="get">
                                <div class="input-group">
                                    <input type="text" name="tu-khoa" value="<?php echo $this->input->get("tu-khoa")?>" class="form-control" aria-label="Text input with segmented button dropdown" placeholder="Từ khóa tìm kiếm">
                                    <div class="input-group-btn">
                                        <select class="selectpicker" id="category_search" name="danh-muc" style="height:150px;">
                                            <option value="all">Tất cả danh mục</option>
                                            <?php echo get_option_multilevel($cat_array,$this->input->get('danh-muc'),false,0,2,0); ?>
                                        </select>
                                        <button id="search-submit" type="submit" class="btn btn-primary">Tìm</button>
                                    </div>
                                </div>
                            </form>
                            <div class="top-search">
                                <span class="label-list">Top tìm kiếm</span>
                                <ul class="list-inline">
                                    <li><a href="">Camera</a></li>
                                    <li>Laptop</li>
                                    <li>Áo sơ mi nam</li>
                                    <li>Ghế Tutalasa</li>
                                    <li>Đầm đen cao cấp</li>
                                    <li>Iphone 7</li>
                                </ul>
                            </div>
                        </div>
                        <div class="header-top-right col-md-3">
                            <div class="user-menu-holder">
                               <?php $CI = &get_instance(); ?>
                               <?php if (@$is_login): ?>
                               <?php
                                    $user = $CI->session->userdata('user_info');
                                    $avatar = skin_url("/images/default_avatar.png");
                                    if (isset($user['avatar']) && $user['avatar'] != null) {
                                        if(!preg_match("~^(?:f|ht)tps?://~i", $user['avatar'])){
                                            if(file_exists('.' . $user['avatar'])){
                                                $avatar = $user['avatar'];
                                            }
                                        }
                                        else{// avatar facebook,google+
                                           $avatar = $user['avatar']; 
                                        }
                                    }
                                ?>
                                <?php $name = @$user['first_name'] . ' ' . @$user['last_name']; ?>
                                <div class="dropdown user-menu-logged">
                                    <div class="user-menu-control" <?php echo 'style="background-image: url(\''.$avatar.'\')"'; ?>></div>
                                    <div class="user-info"><?php echo $name; ?></div>
                                    <div class="dropdown-menu user-menu-list dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                        <ul>
                                            <li><a href="<?php echo base_url("tai-khoan/chinh-sua-thong-tin");?>">Chỉnh sửa thông tin</a></li>
                                            <li><a href="<?php echo base_url("tai-khoan/thay-doi-mat-khau");?>">Thay đổi mật khẩu</a></li>
                                            <li><a href="<?php echo base_url("tai-khoan/dang-ky-gian-hang");?>">Đăng ký gian hàng</a></li>
                                            <li><a href="<?php echo base_url("upgrade");?>">Nâng cấp tài khoản</a></li>
                                            <li><a href="<?php echo base_url("profile/logout");?>">Đăng xuất</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <?php else : ?>
                                    <?php
                                        $error = @$CI->session->userdata('error_login');
                                        $class = '';
                                        $data1['message'] = '';
                                        if (isset($error) && $error != null) {
                                            $class = 'open';
                                            $data1['message'] = $error;
                                            @$CI->session->unset_userdata('error_login');
                                        }
                                    ?>
                                    <div class="user-menu-control not-login">
                                        <div class="user-info">GIAN HÀNG CỦA TÔI</div>
                                        <div class="dropdown <?php echo $class; ?> dropbtn-login">
                                            <button class="dropbtn color_active">Đăng nhập</button>
                                            <div class="dropdown-content" >
                                                <?php $this->load->view('fontend/include/form_login', $data1); ?>
                                            </div>
                                        </div>
                                        <span role="separator" class="sep">|</span>
                                        <div class="dropdown dropbtn-signup">
                                            <button class="dropbtn color_active">Đăng ký</button>
                                            <div class="dropdown-content" style="right:-12px;">
                                                <?php $this->load->view('fontend/include/form_signup'); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div><!--/.user-menu-holder-->
                        </div>
                    </div>
                </div>
            </div>
            <!--/.header-top-->
            <div class="header-bottom">
                <div class="container">
                    <div class="row">
                        <div class="header-bottom-left col-md-3 hidden-xs hidden-sm">
                            <button id="btn-menu" class="btn btn-transparent-light btn-icon-right btn-block">DANH MỤC <i class="icon-right ic ic-menu"></i></button>
                            <nav class="site-nav">
                                <ul>
                                    <?php 
                                        $category_type = new Category_Type();
                                        $where = array('Parent_ID' => 0);
                                        $category_type->where($where)->order_by('Sort','ASC')->get();
                                        if(isset($category_type->ID) && $category_type->ID!=null) :
                                          foreach ($category_type as $key => $value) :
                                    ?>
                                        <li>
                                            <a href="<?php echo base_url('/danh-muc/'.$value->Slug); ?>"><?php echo $value->Name; ?> <?php echo $value->Icon; ?></a>
                                            <?php
                                                $category_type_children = new Category_Type();
                                                $category_type_children->where(array('Parent_ID' => $value->ID))->order_by('Sort','ASC')->get();
                                                if(isset($category_type_children->ID) && $category_type_children->ID != null) :
                                            ?>
                                                <ul class="nav-sub-menu">
                                                  <?php foreach ($category_type_children as $key => $item): ?>
                                                     <li class="item" style="height:152px;">
                                                            <span class="item-bg" style="background-image: url('<?php echo $item->Images; ?>');"></span>
                                                            <a href="<?php echo base_url('/danh-muc'.$item->Path); ?>">
                                                                <span class="item-inner">
                                                                    <span class="item-icon"><?php echo $item->Icon; ?></span>
                                                                    <span class="item-name"><?php echo $item->Name; ?></span>
                                                                </span>
                                                            </a>
                                                     </li>
                                                  <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </li>
                                    <?php 
                                          endforeach;
                                        endif;
                                    ?>
                                </ul>
                            </nav>
                        </div>
                        <div class="site-call-to-action col-xs-10 col-sm-8 col-md-6">
                            <marquee align="center" direction="left" height="" scrollamount="5" width="100%">
                                <p><strong>Notoshop</strong> Mới đăng sản phẩm Giày Nam.... <a href="">Xem ngay</a></p>
                            </marquee>
                        </div>
                        <div class="header-bottom-right col-xs-2 col-sm-4 col-md-3">
                            <a id="btn-post-add" class="btn btn-secondary btn-block" href="<?php echo base_url("profile/add_product");?>" class="bar-add-product"><i class="ic ic-plus hidden-sm hidden-md hidden-lg"></i> <span class="hidden-xs">ĐĂNG BÀI VIẾT</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.header-bottom-->
            <div id="progress"><div id="bar-success"></div>
        </header>
          
        <div class="site-main">
        <?php if (@$is_login): ?>
            <?php $this->load->view("fontend/include/upload");?>
            <?php $this->load->view("fontend/include/favorite");?>
            <?php $this->load->view("fontend/include/modal_action_product");?>
        <?php endif; ?>