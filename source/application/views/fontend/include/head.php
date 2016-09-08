 <!--Fonts-->
<link href="<?php echo skin_url("css/font-awesome.min.css");?>" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,500italic,700,700italic,900,900italic&subset=latin,vietnamese' rel='stylesheet' type='text/css'>

<!-- Bootstrap -->
<link href="<?php echo skin_url("css/bootstrap.min.css");?>" rel="stylesheet" type="text/css">
<link href="<?php echo skin_url("libs/bootstrap-select/bootstrap-select.css");?>" rel="stylesheet">
<link href="<?php echo skin_url("css/bootstrap.custom.css");?>" rel="stylesheet" type="text/css">
<link href="<?php echo skin_url("css/bootstrap-checkbox.css");?>" rel="stylesheet">

<!--Flexsilder-->
<link href="<?php echo skin_url("css/flexslider.css");?>" rel="stylesheet" type="text/css">

<!--Bxslider-->
<link href="<?php echo skin_url("libs/bxslider/jquery.bxslider.css");?>" rel="stylesheet">
<!--mmmenu-->
<link href="<?php echo skin_url("libs/mmenu/jquery.mmenu.all.css");?>" rel="stylesheet">
    
<!--Jquery CSS-->
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.Jcrop.css">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.Jcrop.min.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<!--Main style-->
<link href="<?php echo skin_url("css/style.css");?>" rel="stylesheet" type="text/css">

<!--Custom page-->
<!--<link href="<?php echo skin_url("css/custom.css");?>" rel="stylesheet" type="text/css">-->
<link href="<?php echo skin_url("css/page/profile.css");?>" rel="stylesheet" type="text/css">
<link href="<?php echo skin_url("css/slider.css");?>" rel="stylesheet" type="text/css">

<!--JS-->
<script src="<?php echo skin_url("js/jquery-1.11.3.min.js");?>" type="text/javascript"></script>
<script type="text/javascript">
	var base_url =  "<?php echo base_url();?>";
	var _token   =  "<?php echo @$_token; ?>";
	var frontend = true;
	var _current_uri = "<?php echo implode("/", $this->uri->segment_array());?>";
	var _keyword = "<?php echo $this->input->get("tu-khoa");?>";
	var _category_type = "<?php echo @$path;?>";
	var _total_product = "<?php echo (isset($total_product) && $total_product != "") ? $total_product : "0" ;?>";
	var _number_product_on_page = "<?php echo (@$product_on_page != "" && is_numeric($product_on_page)) ? $product_on_page : "0" ;?>";
</script>
<script src="<?php echo skin_url("js/jquery.form.js");?>" type="text/javascript"></script>
<script src="<?php echo skin_url("js/bootstrap.min.js");?>" type="text/javascript"></script>
<script src="<?php echo skin_url("js/jquery.flexslider-min.js");?>" type="text/javascript"></script>
<script src="<?php echo skin_url() ?>/js/jquery.Jcrop.js"></script>
<script src="<?php echo skin_url() ?>/js/jquery.Jcrop.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=myCallBack&render=explicit" async defer></script>
<script type="text/javascript">
	var grecaptcha_signup = null;
    var grecaptcha_review = null;
    var grecaptcha_contact = null;
    var grecaptcha_forgot = null;
    var myCallBack = function() {
        if($("#g-recaptcha-signup").length > 0){
        	grecaptcha_signup = grecaptcha.render('g-recaptcha-signup', {
	          'sitekey' : '6LejPCcTAAAAAGHIq_DlVWaMf1e_24V0zIvqbmDy'
	        });
        }
        
        if($("#g-recaptcha-review").length > 0){
	        grecaptcha_review = grecaptcha.render('g-recaptcha-review', {
	          'sitekey' : '6LejPCcTAAAAAGHIq_DlVWaMf1e_24V0zIvqbmDy'
	        });
	    }

	    if($("#g-recaptcha-contact").length > 0){
	        grecaptcha_contact = grecaptcha.render('g-recaptcha-contact', {
	          'sitekey' : '6LejPCcTAAAAAGHIq_DlVWaMf1e_24V0zIvqbmDy'
	        });
	    }

	    if($("#g-recaptcha-forgot").length > 0){
	        grecaptcha_forgot = grecaptcha.render('g-recaptcha-forgot', {
	          'sitekey' : '6LejPCcTAAAAAGHIq_DlVWaMf1e_24V0zIvqbmDy'
	        });
	    }
    };
</script>
<script src="<?php echo skin_url("libs/bootstrap-select/bootstrap-select.js");?>"></script>
<script src="<?php echo skin_url("libs/mmenu/jquery.mmenu.all.min.js");?>"></script>
<script src="<?php echo skin_url("libs/bxslider/jquery.bxslider.min.js");?>"></script>
<script src="<?php echo skin_url("js/ui.js");?>" type="text/javascript"></script>
<script src="<?php echo skin_url("js/common.js");?>" type="text/javascript"></script>
<script src="<?php echo skin_url() ?>/js/bootstrap-slider.js"></script>
<script src="<?php echo skin_url("js/main.js");?>" type="text/javascript"></script>