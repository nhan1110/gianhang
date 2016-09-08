var add_rate = function(title,content,num_rate){
    $.ajax({
        url: base_url + "rate/add",
        type: 'POST',
        dataType: 'json',
        data: {"title": title,"content": content,'num_rate':num_rate,'url':url,'g-recaptcha-response':grecaptcha.getResponse()}, 
        success:function(data) {
            console.log(data);
            if(data['status'] == 'success'){
                var count = data['update_tracking']['count'];
                var average = data['update_tracking']['average'];
                var Num_1 = data['update_tracking']['tracking_rate']['Num_1'];
                var Num_2 = data['update_tracking']['tracking_rate']['Num_2'];
                var Num_3 = data['update_tracking']['tracking_rate']['Num_3'];
                var Num_4 = data['update_tracking']['tracking_rate']['Num_4'];
                var Num_5 = data['update_tracking']['tracking_rate']['Num_5'];
                $('.count-rate').html(count);
                $(".average-rate").html(average);
                $('.tracking-num-1').html(Num_1);
                $('.tracking-num-2').html(Num_2);
                $('.tracking-num-3').html(Num_3);
                $('.tracking-num-4').html(Num_4);
                $('.tracking-num-5').html(Num_5);
                if(count != 0){
                    $('.progress-bar-1').width((Num_1/count)*100 + '%');
                    $('.progress-bar-2').width((Num_2/count)*100 + '%');
                    $('.progress-bar-3').width((Num_3/count)*100 + '%');
                    $('.progress-bar-4').width((Num_4/count)*100 + '%');
                    $('.progress-bar-5').width((Num_5/count)*100 + '%');
                    $(".choose-rate .rate-average span").width((average/5)*100 + '%');
                }
                if(data['action'] == 'add'){
                    $("#rate_view .review-block .wrap-rate-content").prepend(data['responsive']);
                }
                else if(data['action'] == 'edit'){
                    if( $(".review-block .wrap-rate-content > .row[data-id='"+data['rate_id']+"']").length > 0 ){
                        var current_rate = $(".review-block .wrap-rate-content > .row[data-id='"+data['rate_id']+"']");
                        current_rate.find('h4.rate-title').html(data['record']['title']);
                        current_rate.find('.review-block-description').html(data['record']['content']);
                        current_rate.find('.review-block-rate > button').each(function(i){
                            if(data['record']['num_rate'] >= i+1 ){
                                $(this).addClass('btn-warning').removeClass('btn-default btn-grey');
                            }
                            else{
                                $(this).removeClass('btn-warning').addClass('btn-default btn-grey');
                            }
                        });
                    }
                }
                grecaptcha.reset();
                $("#rate-modal").modal('toggle');
            }
            else if(data['status'] == 'fail'){
                alert(data['message']);
            }
        },
        complete:function() {
            $("#rate-modal .custom-loading").hide();
            $("#rate-modal .send_rate").removeAttr('disabled','disabled');
        },
        error:function(data){
            console.log(data);
        }
    });
}

var pagination = function(max,current){
	var paging = '';
	if(parseInt(max) > 10){
        var number_paging = parseInt(max/10);
        paging += '<ul class="pagination">';
        if(max%10 > 0){
            number_paging++;
        }
        if(parseInt(current) - 5 > 1){
          	paging += '<li><a href="#" data-index="'+(current-5)+'" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
        }
        for(var j=parseInt(current)-3; j<=parseInt(current)+3 ; j++){
            if(j > 0 && j <= number_paging){
	              var cl="";
	              if(j==current){
	                  	cl="active";
	              }
	              paging += '<li class="'+cl+'"><a href="#" data-index="'+j+'" >'+j+'</a></li>';
            }
        }
        if(parseInt(current) + 3 < number_paging){
          	paging += '<li><a href="#" data-index="'+(parseInt(current) + 4)+'" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
        }
        paging += '</ul>';
    }
    return paging;
}

var get_rate = function(){
    $("#rate_view").html('<p class="text-center" style="margin-bottom: 0;"><img width="36" src="'+base_url+'skins/images/loading.gif"></p>');
    $.ajax({
        url: base_url + "rate/get_rate/",
        type: 'POST',
        dataType: 'json',
        data: {'url': url}, 
        success : function(data) {
            //console.log(data);
            if(data['status'] == 'success'){
                $("#rate_view").html(data['responsive']);
                $("#rate_view .nav-paging").html(pagination(data['count'],1));
                
                if(data['record']['title'] != null){
                    $("#rate-modal #title-rate").val(data['record']['title']);
                }

                $(".choose-rate .rate-average span").width((data['average']/5)*100 + '%');

                if(data['record']['content'] != null){
                    $("#rate-modal #content-rate").val(data['record']['content']);
                }

                if(data['record']['num_rate'] != null){
                    $("#rate-modal #num-rate").val(data['record']['num_rate']);
                    var parents = $("#rate-modal #num-rate").parents('.choose-rate');
                    parents.find(' i').each(function() {
                        var i = $(this).attr('data-index');
                        if (i <= data['record']['num_rate']) {
                            $(this).addClass('rate-active');
                        } else {
                            $(this).removeClass('rate-active');
                        }
                    });
                    $("#rate_view .btn-add-edit-rate").html('Sửa bình luận');
                }
            }
        },
        complete : function() {

        }
    });
}
var get_rate_paging = function(paging){
    $("#rate_view .review-block .wrap-rate-content").append('<div class="rate-loading-wrap"><p class="text-center" style="margin-bottom: 0;"><img width="36" src="'+base_url+'skins/images/loading.gif"></p></div>');
    $.ajax({
        url: base_url + "rate/get_rate_more/",
        type: 'POST',
        dataType: 'json',
        data: {'url': url,'paging': paging}, 
        success : function(data) {
            if(data['status'] == 'success'){
                var top  = $("#rate_view .review-block").offset().top - 100;
                $("#rate_view .review-block .wrap-rate-content").html(data['responsive']);
                $("#rate_view .nav-paging").html(pagination(data['count'],paging));
                $('html,body').animate({ scrollTop: top }, 800);
            }
        },
        complete : function() {

        }
    });
}
$(document).ready(function(){
    $(window).load(function(){
        get_rate();
    });

    $(document).on('click',"#rate-modal .send_rate",function(){
        var title    = $("#rate-modal #title-rate").val();
        var content  = $("#rate-modal #content-rate").val();
        var num_rate = $("#rate-modal #num-rate").val();
        var check = true;
        var arr_title = $.trim(title).split(" ");
        if($.trim(title) == '' || $.trim(title) == null){
            $("#rate-modal #title-rate").addClass('border-error');
            check = false;
        }
        else{
            $("#rate-modal #title-rate").removeClass('border-error');
        }

        var arr = $.trim(content).split(" ");
        if($.trim(content) == '' || $.trim(content) == null){
            $("#rate-modal #content-rate").addClass('border-error');
            check = false;
        }
        else{
            $("#rate-modal #content-rate").removeClass('border-error');
        }

        if(isNaN(num_rate) || num_rate >5 || num_rate < 1){
            $("#rate-modal .choose-rate button").addClass('border-error');
            check = false;
        }
        else{
            $("#rate-modal .choose-rate button").removeClass('border-error');
        }

        var v = grecaptcha.getResponse();
        if(v.length == 0)
        {
            $('.g-recaptcha iframe').addClass('border-error');
            check = false;
        }
        else{
            $('.g-recaptcha iframe').removeClass('border-error');
        }

        if(check){
            $("#rate-modal .custom-loading").show();
            $(this).attr('disabled','disabled');
            add_rate(title,content,num_rate);
        }
        return false;
    });

    $(document).on('click',"#rate_view .pagination li > a",function(){
        var paging = $(this).attr('data-index');
        if(typeof (paging) != "undefined" && paging!=null && !isNaN(paging)){
            get_rate_paging(paging);
        }
        return false;
    });

    $(document).on('click',"#rate-modal .choose-rate i",function(){
        var num_rate = $(this).attr('data-index');
        $("#rate-modal #num-rate").val(num_rate);
        var parents = $(this).parents('.choose-rate');
        parents.find('i').each(function() {
            var i = $(this).attr('data-index');
            if (i <= num_rate) {
                $(this).addClass('rate-active');
            } else {
                $(this).removeClass('rate-active');
            }
        });
        return false;
    });
    $(document).on({
        mouseenter: function () {
           var num_rate = $(this).attr('data-index');
           var parents = $(this).parents('.choose-rate');
           parents.find('i').each(function() {
                var i = $(this).attr('data-index');
                if (i <= num_rate) {
                    $(this).addClass('hover');
                } else {
                    $(this).removeClass('hover');
                }
           });
        },
        mouseleave: function () {
           var parents = $(this).parents('.choose-rate');
           parents.find('i').each(function() {
               $(this).removeClass('hover');
           });
        }
    }, "#rate-modal .choose-rate i");
});