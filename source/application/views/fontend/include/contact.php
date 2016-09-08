<section class="contact">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h1>LIÊN HỆ</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="contact_page">
					<div class="row">
						<div class="col-md-6 map_contact">
							<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3826.320253804668!2d107.57932121439!3d16.459313733238652!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3141a1361ff5681d%3A0x5d007eaf4a1f4db1!2zVHJ1bmcgVMOibSBDw7RuZyBuZ2jhu4cgVGjDtG5nIHRpbiBUaOG7q2EgVGhpw6puIEh14bq_!5e0!3m2!1svi!2s!4v1470125966593" width="100%" height="300" frameborder="0" allowfullscreen></iframe>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-12">
									<h4>Giới thiêu về gianhangcuatoi.com</h4>
									<div class="content_contact">
										<p>
											<?php
												$pages = new Pages();
										    	$pages->where(array('Page_Slug' => 'contact'))->get(1);
										    	echo $pages->Page_Content;
										    ?>
										</p>
									</div>
									<div class="contac_social">
										<h4>Thông tin liên hệ</h4>
										<ul>
											<li><i class="fa fa-home" aria-hidden="true"></i>06 Lê Lợi, Phường Vĩnh Ninh, Thành phố Huế, Việt Nam.</li>
											<li><i class="fa fa-envelope" aria-hidden="true"></i>Example@gmail.com</li>
											<li><i class="fa fa-phone-square" aria-hidden="true"></i>0123 678910</li>
											<li><i class="glyphicon glyphicon-phone-alt"></i>054 3 012345</li>
											<li><i class="fa fa-user"></i>   Người liên hệ : </li>
											<li><i class="fa fa-info-circle" aria-hidden="true"></i>Chăm sóc khách hàng: <strong>Hotline</strong></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
        	<div class="col-md-12">
        		<?php echo $this->session->flashdata('email_send'); ?>
        	</div>
        </div>
		
		<div class="row">
			<div class="col-md-12">
				<form class="controls" method="POST" action="<?php echo base_url('help/contact/'); ?>" role="form">
					<h5><a href="<?php echo base_url(); ?>" title=""><img src="<?php echo skin_url("images/logo.png"); ?>" alt="" title=""></a><strong>trân trọng ý kiến của bạn.</strong></h5>
					<h5>Bạn vui lòng gửi thắc mắc hoặc ý kiến đóng góp qua biểu mẫu dưới đây.</h5>
					<div class="row">
			        	<div class="col-md-12">
				        	<div class="row">
				        		<div class="col-md-12 text-center">
				        			<div id="loading"></div>
				        		</div>
				        	</div>
					        <div id="success" class="alert alert-info fade in">
							    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
							    <strong>Gửi email thành công!</strong> Chúng tôi đã gửi email xác nhận khi nhận được email của bạn. Nội dung email của bạn sẽ được xem xét và trả lời trong vòng 24h. Cảm ơn bạn.
							</div>
		                	<div id="error" class="alert alert-danger fade in">
							    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
							    <strong>Lỗi !!!</strong> Không gửi được email.
							</div>
							<div class="alert alert-danger fade in" class="error"  id="titleError" >
							    <!--<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>-->
							    <strong>Lỗi !!!</strong> Vui lòng nhập tiêu đề của bạn.
							</div>
							<div class="alert alert-danger fade in" class="error"  id="fullnameError" >
							    <strong>Lỗi !!!</strong> Vui lòng nhập đầy đủ họ và tên của bạn.
							</div>
							<div class="alert alert-danger fade in" class="error"  id="emailError" >
							    <strong>Lỗi !!!</strong> Vui lòng nhập địa chỉ email của bạn.
							</div>
							<div class="alert alert-danger fade in" class="error"  id="phoneError" >
							    <strong>Lỗi !!!</strong> Vui lòng nhập số điện thoại của bạn.
							</div>
							<div class="alert alert-danger fade in" class="error"  id="contentError" >
							    <strong>Lỗi !!!</strong> Vui lòng nhập nội dung tin nhắn / câu hỏi của bạn.
							</div>
							<div class="alert alert-danger fade in" class="error"  id="numricphoneError" >
							    <strong>Lỗi !!!</strong> Vui lòng nhập chữ số.
							</div>
							<div class="alert alert-danger fade in" class="error"  id="titleLenghtError" >
							    <strong>Lỗi !!!</strong> Vui lòng nhập tiêu đề từ 4-100 ký tự.
							</div>
							<div class="alert alert-danger fade in" class="error"  id="fullnameLenghtError" >
							    <strong>Lỗi !!!</strong> Vui lòng nhập họ và tên từ 4-50 ký tự.
							</div>
							<div class="alert alert-danger fade in" class="error"  id="phoneLenghtError" >
							    <strong>Lỗi !!!</strong> Vui lòng nhập số điện thoại từ 9-12 chữ số.
							</div>
							<div class="alert alert-danger fade in" class="error"  id="grecaptchaError" >
							    <strong>Lỗi !!!</strong> dfhbfghghhgh.
							</div>
			        	</div>
			        </div>
			        <div class="row">
			            <div class="col-md-6">
			            	<div class="form-group">
			            		<div class="input-group">
	        						<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
				                    <input id="title" required="required" minlength="4" type="text" name="title" class="form-control" placeholder="Tiêu đề" >
			                    </div>
			                    <?php echo form_error('title', '<div class="error">', '</div>'); ?>
			                </div>
			                <div class="form-group">
    							<div class="input-group">
				                	<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				                    <input id="fullname" required minlength="4" type="text" name="fullname" class="form-control" placeholder="Họ và tên" >
								</div>
								<?php echo form_error('fullname', '<div class="error">', '</div>'); ?>
			                </div>
			                <div class="form-group">
			                	<div class="input-group">
	        						<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
				                    <input id="email" required type="email" name="email" class="form-control" placeholder="Email" >
			                    </div>
			                    <?php echo form_error('email', '<div class="error">', '</div>'); ?>
			                </div>
			                <div class="form-group">
			                	<div class="input-group">
	        						<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
				                    <input id="phone" type="tel" pattern="^([0|\+[0-9]{1,5})?([1-9][0-9]{8})$" title="Nhập số điện thoại ít nhất 9 chữ số." required name="phone" class="form-control"  placeholder="Số điện thoại">
			                    </div>
			                    <?php echo form_error('phone', '<div class="error">', '</div>'); ?>
			                </div>
			            </div>
			            <div class="col-md-6">
			                <div class="form-group">
				                <div class="input-group">
				                    <textarea id="content" required name="content" class="form-control" placeholder="Nội dung tin nhắn" rows="4" maxlength="1000" title="Vui lòng nhập tin nhắn/câu hỏi. "></textarea>
				                    <span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
				                </div>
			                    <?php echo form_error('content', '<div class="error">', '</div>'); ?>
			                </div>
			                <div class="row">
			                	<div class="col-md-12 text-center">
				                	<div class="input-group" style="margin-bottom:15px;">
				                		<input type="submit" id="submit" class="btn btn-success" name="submit" value="Gửi tin nhắn">
				                		<span class="input-group-addon"><i class="glyphicon glyphicon-send"></i></span>
			                		</div>
			                	</div>
			            	</div>
			        	</div>
			        </div>
			        <div class="form-group">
				        <div id="g-recaptcha-contact"></div>
				        <input type="hidden" name="response" id="ggrecaptcha">
			        </div>
				</form>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$(window).bind("load", function() {
	    window.setTimeout(function() {
		    $(".email_send").fadeTo(300, 0).slideUp(1000, function(){
		        $(this).remove();
		    });
	    }, 4000);
	});

	$('.email_send').dialog({
	    close:function(){
	    }
	});

	$(document).ready(function() {
	    $("#submit").click(function() {
	    	var check = true;
	    	var title    = $("#title").val();
	        var fullname = $("#fullname").val();
	        var email    = $("#email").val();
	        var phone    = $("#phone").val();
	        var content  = $("#content").val();
	        var numricphone = /^[0-9]+$/;
	        var email_regex = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
	        var data_string = 'title=' + title + '&fullname=' + fullname + '&email=' + email + '&phone=' + phone + '&content=' + content;

	        if(title == "") {
	            $("#titleError").slideDown('fast').delay(4000).slideUp('fast');
	            $("#title").focus();
	            return false;
	        }
	        if(document.getElementById("title").value.length < 4 || document.getElementById("title").value.length >= 100) {
	            $("#titleLenghtError").slideDown('fast').delay(4000).slideUp('fast');
	            $("#title").focus();
	            return false;
	        }
	        if(fullname == "") {
	            $("#fullnameError").slideDown('fast').delay(4000).slideUp('fast');
	            $("#fullname").focus();
	            return false;
	        }
	        if(document.getElementById("fullname").value.length < 4 || document.getElementById("fullname").value.length >= 50) {
	            $("#fullnameLenghtError").slideDown('fast').delay(4000).slideUp('fast');
	            $("#fullname").focus();
	            return false;
	        }
	        if(!email_regex.test(email) || email == "") {
	            $("#emailError").slideDown('fast').delay(4000).slideUp('fast');
	            $("#email").focus()
	            return false;
	        }
	        if(phone == "") {
	            $("#phoneError").slideDown('fast').delay(4000).slideUp('fast');
	            $("#phone").focus()
	            return false;
	        }
	        if(!numricphone.test(phone)) {
	        	$("#numricphoneError").slideDown('fast').delay(4000).slideUp('fast');
		        $("#phone").focus()
		        return false;
	        }
	        if(document.getElementById("phone").value.length < 9 || document.getElementById("phone").value.length > 12) {
	            $("#phoneLenghtError").slideDown('fast').delay(4000).slideUp('fast');
	            $("#phone").focus();
	            return false;
	        }
	        if(content == "") {
	            $("#contentError").slideDown('fast').delay(2000).slideUp('fast');
	            $("#content").focus()
	            return false;
	        }
	 				    
		    var res = grecaptcha.getResponse();
		    if (res == "" || res == undefined || res.length == 0) {
		    	$('#g-recaptcha-contact iframe').addClass('waring');
		    }else{
		    	$('#g-recaptcha-contact iframe').removeClass('waring');
		    	$("input#ggrecaptcha").val(res);
		    }
		    
	        if(check){
	            grecaptcha.reset();
	        }
	        return false;
		    
		    	        
	        $("#loading").html("<i class='ic ic-md ic-loading'></i>").fadeIn('fast');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('help/contact/'); ?>",
                data: data_string,
                success: function(data_form) {
                    if(data_form) {
                        $('#loading').fadeOut('fast');
                        $("#success").slideDown('fast').delay(20000).slideUp('fast');
                        clear_form();
				    }else {
                        $('#loading').fadeOut('fast');
                        $("#error").slideDown('fast').delay(20000).slideUp('fast');
                    }
                }
            });
	        return false;
	    });
	 
	    function clear_form() {
	    	$("#title").val('');
	        $("#fullname").val('');
	        $("#email").val('');
	        $("#phone").val('');
	        $("#content").val('');
	    }
	    
	});
</script>