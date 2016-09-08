$(document).ready(function(){
	$(document).on('click','.other-like > a',function(){
	  	if($(this).hasClass('login')){	
			var id = $(this).attr('data-id');
			var type = $(this).attr('data-type');
			var current = $(this);
			$.ajax({
		        url: base_url+'like',
		        type: "post",
		        dataType: 'json',
		        data: {"id": id,'type':type},
		        success: function (data) {
		        	if(data['status'] == 'success'){
		        		var like = data['like'];
		        		var count = current.parent().parent().find('span.counter').text();
		        		if(like == 1){
		        			current.parent().find('i').removeClass('fa-heart-o').addClass('fa-heart');
		        			count++;
		        		}
		        		else{
		        			current.parent().find('i').removeClass('fa-heart').addClass('fa-heart-o');
		        			count--;
		        		}
		        		current.parent().parent().find('span.counter').text(count);
		        	}
		        },
		        error: function (){
		        }
		    });
		}
		else{
			$(".dropbtn-login").addClass('open');
		}
		return false;
	});

	var is_ajax_styled = true;
	$(document).on('click','.section-products input.styled',function(){
		var value = $(this).val();
		var slug = $(this).parents('.section-products').attr('data-slug');
		var current = $(this);
		if($(this).parents('.section-products').find('.selectpicker').length > 0){
			var temp = $(this).parents('.section-products').find('.selectpicker').val();
			if(temp !=null && temp!= ''){
				slug = temp;
			}
		}
		$(this).prop('checked',true);
		$(this).parents('.section-products').find('input.styled').not(this).prop('checked',false);
		get_product_by_type(slug,value,current);
	});

	$('.section-products .selectpicker').change(function(){
		var value = 'news';
		var slug = $(this).val();
		var current = $(this);
		if(slug == '' || slug == null){
			slug = $(this).parents('.section-products').attr('data-slug');
		}
		$(this).parents('.section-products').find('input.styled').prop('checked',false);
		$(this).parents('.section-products').find('input.styled[value="news"]').prop('checked',true);
		get_product_by_type(slug,value,current);
	});

	var get_product_by_type = function(slug,value,current){
		if(is_ajax_styled){
			is_ajax_styled = false;
			current.parents('.section-products').find('.custom-loading').show();
			$.ajax({
		        url: base_url+'home/styled',
		        type: "post",
		        dataType: 'json',
		        data: {"slug": slug,'value':value},
		        success: function (data) {
		        	console.log(data);
		        	if(data['status'] == 'success'){
		        		current.parents('.section-products').find('.section-right').html(data['response']);
		        		current.parents('.section-products').find('.products-list-slider').bxSlider({
					        slideWidth: 225
					        , minSlides: 1
					        , maxSlides: 4
					        , moveSlides: 1
					        , slideMargin: 10
					        , pager: false
					    });
		        	}
		        },
		        complete:function(){
		        	current.parents('.section-products').find('.custom-loading').hide();
		        	is_ajax_styled = true;
		        },
		        error: function (){
		        }
		    });
		}
	}
});

/*Favorite*/
$(document).on("click", ".other-pin > a", function (event) {
    if($(this).hasClass('login')){
        var product_id = $(this).attr('data-id');
        $.ajax({
            url: base_url + 'favorite/get_favorite/',
            type: "post",
            dataType: 'json',
            data: {"product_id": product_id},
            success: function (data) {
                //console.log(data);
                if(data['status'] == 'success'){
                    var responsive = data['responsive'];
                    var html = '';
                    $("#add-product-to-favorite-modal .alert").hide();
                    $("#add-favorite-all-modal #favorite_type_id").val(data['favorite_type_id']);
                    for (var i = 0; i < responsive.length; i++) {
                        html += '<option value="'+responsive[i]['id']+'">'+responsive[i]['name']+'</option>';
                    }
                    $("#add-product-to-favorite-modal #favorite_id").html(html);
                    $("#add-product-to-favorite-modal #product_id").val(product_id);
                    $("#add-product-to-favorite-modal").modal('show');
                }
            },
            complete: function(){

            },
            error: function () {
               alert('Lỗi!');
            }
        });
    }
    else{
    	$(".dropbtn-login").addClass('open');
    }
    return false;
});

$(document).ready(function(){
    $('#add-favorite-all-modal').on('show.bs.modal', function () {
        $("#add-favorite-all-modal").css('z-index','1056');
        $('#add-product-to-favorite-modal').css('z-index','1054');
        $('.modal-backdrop').css('z-index','1055');
    });
    $('#add-favorite-all-modal').on('hidden.bs.modal', function () {
        $("#add-favorite-all-modal").css('z-index','1051');
        $('.modal-backdrop').css('z-index','1040');
        $('body').addClass('modal-open');
    });

    $("#add-favorite-all-modal #add-favorite-all-form").submit(function(){
        var current = $(this);
        $(this).ajaxSubmit({
            beforeSubmit: function () {
                current.find('.custom-loading').show();
            },
            dataType: "json",
            success: function (data) {
                if(data['status'] == 'success'){
                    var responsive = data['responsive'];
                    var html = '';
                    for (var i = 0; i < responsive.length; i++) {
                        html += '<option value="'+responsive[i]['id']+'">'+responsive[i]['name']+'</option>';
                    }
                    current.find('#name').val('');
                    $("#add-product-to-favorite-modal #favorite_id").html(html);
                    $("#add-favorite-all-modal").modal('toggle');
                }
            },
            error: function () {
            },
            complete: function () {
                current.find('.custom-loading').hide();
            }
        });
        return false;
    });

    $("#add-product-to-favorite-modal #add-product-to-favorite-form").submit(function(){
        var current = $(this);
        $(this).ajaxSubmit({
            beforeSubmit: function () {
                current.find('.custom-loading').show();
                current.find('.alert').hide();
            },
            dataType: "json",
            success: function (data) {
                if(data['status'] == 'success'){
                    var html = 'Đã thêm sản phẩm vào chuyên mục <a href="'+data['url']+'">'+data['name']+'</a>.';
                    current.find(".alert-success p").html(html);
                    current.find(".alert-success").show();
                }
                else if(data['status'] == 'fail'){
                    current.find(".alert-danger p").html(data['message']);
                    current.find(".alert-danger").show();
                }
            },
            error: function () {
            },
            complete: function () {
                current.find('.custom-loading').hide();
            }
        });
        return false;
    });

});
/*End Favorite*/