<div id="sidaber-advertise">
    <div class="tems-sidebar"><a href="#" id="show_hide"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></div>
    <div class="header-sidebar">
    	<div class="profile-image">
            <img src="/uploads/user/2f9cc186ff453508115b92572625b01d_5770f7339bc90.jpg" class="avatar img-circle img-thumbnail" alt="avatar">
            <div class="profile-edit-photo custom-logo">
                <div class="profile-action-edit">
                    <a class="text-white" href="#" onclick="$('#imageCropper-modal #ImageUploader_image').click();return false;"><i class="fa fa-camera"></i></a>
                </div>
            </div>
        </div>
    	<h3 class="text-center"> Phan Quang Hiệp</h3>
    </div>
	<div class="lis-menu">
		<ul>
			<li><a href="#"><i class="fa fa-user" aria-hidden="true"></i> Thông tin tài khoản</a></li>
			<li><a href="#"><i class="fa fa-pencil" aria-hidden="true"></i> Chỉnh sữa tài khoản</a></li>
			<li><a href="#"><i class="fa fa-list-ul" aria-hidden="true"></i>Thông tin quảng cáo</a></li>
			<li><a href="#"><i class="fa fa-cog"></i> Cài đặt</a></li>
		</ul>
	</div>
</div>
<style type="text/css">
	#sidaber-advertise{
		position: fixed;
	    right: 0;
	    top: 0;
	    bottom: 0;
	    width: 250px;
	    z-index: 99;
	    display: none;
	    background-color: #fff;
	    border-left: 1px solid #ccc;
	}
	#sidaber-advertise .header-sidebar .profile-image{
		max-width:150px;
		margin: 20px auto;
	}
	#sidaber-advertise .lis-menu li {
    	margin: 0;
    	border-bottom: 1px dashed #eee;
    	list-style: none;
	}
	#sidaber-advertise .lis-menu li a{
		font-size: 14px;
	    line-height: 20px;
	    padding: 15px 15px;
	    color: #999;
	    display: block;
	    font-weight: bold;
	    background: none;
	    text-decoration: none;
	    border-top: 0px;
	    font-weight: bold;
	}
	#sidaber-advertise .lis-menu li:last-child {border-bottom: 0px;}
	#sidaber-advertise .tems-sidebar {
	    background-color: #fff;
	    border: 1px solid #ccc;
	    float: left;
	    border-top-left-radius: 10px;
	    border-bottom-left-radius: 10px;
	    padding: 10px 10px;
	    position: absolute;
	    top: 50px;
	    left: -40px;
	    border-right: none;
	    width: 40px;
	    height: 40px;
	    cursor: pointer;
	}

</style>
<script type="text/javascript">
	$(window).load(function(){
		var header_offset = $("#hotdeal_container .container").offset();
		console.log(header_offset);
		$("#sidaber-advertise").css("top",header_offset.top + "px").show();
		var scroll = 0;
		var current_scroll;
		$(window).scroll(function () {
			current_scroll = $(window).scrollTop();
			if(scroll != current_scroll){
				scroll = current_scroll
				if(scroll >= header_offset.top){
					$("#sidaber-advertise").css({top:0},100);
				}else{
					$("#sidaber-advertise").css({top:header_offset.top},100);
				}
			}
		});
	});
	jQuery(document).ready(function(){
	    jQuery(".tems-sidebar").click(function() {
	        jQuery(this).toggleClass("open");
	        if (jQuery(this).hasClass("open") == true) {
	            jQuery(this).find(".fa").removeClass("fa-arrow-right").addClass("fa-arrow-left");
	            jQuery(this).parents("#sidaber-advertise").animate({
	                right: "0"
	            }, 400);
	         } else {
	            jQuery(this).find(".fa").removeClass("fa-arrow-left").addClass("fa-arrow-right");
	            jQuery(this).parents("#sidaber-advertise").animate({
	                 right: "-250px"
	            }, 400);
	         }
	         return false;
	     });
	});
</script>