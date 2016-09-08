var _this;
var screen_width = $(window).width();
var screen_height = $(window).height();
var _reload = false;
var _url_reload = window.location.href;
var _ajax_this;
var _reset = 1;
var _action;
$(window).load(function(){
    _reset= 0;
});
$(document).on("click", "#modal_delete #ok-delete", function () {
    $(this).append(loading());
    var ajax_this = $(this);
    var type = _this.data("type");
    $.ajax({
        url: $(this).parents("#modal_delete").find("#action").val(),
        type: "post",
        dataType: 'json',
        data: {"id": 0},
        success: function (data) {
            console.log(data);
            if (data["success"] == "success") {
                if (type == "disabled" || _action == "disabled") {
                    if (data["number"] == 1) {
                        _this.find("i").removeClass("fa-lock").addClass("fa-unlock");
                    } else {
                        _this.find("i").removeClass("fa-unlock").addClass("fa-lock");
                    }
                    $("#modal_delete").modal('hide');
                } else {
                    $("#modal_delete").modal('hide');
                    _this.fadeOut("slow", function () {
                        _this.remove();
                    });
                }

            } else {
                alert("error");
                $("#modal_delete").modal('hide');
            }
            if(_reload == true){
                _reload = false;
                location.reload();
            }
            remove_loadding(ajax_this);
        },
        error: function () {
            alert("error");
            $("#modal_delete").modal('hide');
            remove_loadding(ajax_this);
        }
    });
});
function action_delete(url, ojb,reload) {
    _reload = reload;
    _this = ojb;
    $("#modal_delete #action").val(url);
    $("#modal_delete").modal();
}
$(document).ready(function () {

    $(document).on('click', "#header .header-signup", function () {
        $("#header .header-login").parent().removeClass('open');
        if ($(this).parent().hasClass('open')) {
            $(this).parent().removeClass('open');
        } else {
            $(this).parent().addClass('open');
        }
        return false;
    });
    $(document).on('click', "#header .header-login", function () {
        $("#header .header-signup").parent().removeClass('open');
        if ($(this).parent().hasClass('open')) {
            $(this).parent().removeClass('open');
        } else {
            $(this).parent().addClass('open');
        }
        return false;
    });

    $(document).on('click', '#header .menu-bar', function () {
        $("#header #top_bar").addClass('open');
        return false;
    });
    $(document).on('click', '#header #top_bar .close-mobile-menu', function () {
        $("#header #top_bar").removeClass('open');
        return false;
    });
    if (screen_width > 960) {
        $.each($(".fixt"), function () {
            var width_el = $(this).width();
            var left_el = $(this).offset().left;
            var top_el = $(this).offset().top;
            $(this).css({"left": left_el + "px", "width": width_el + "px", "float": "left"}).attr("data-top", top_el);
        });
    }
    $('#form-signup').submit(function () {
        _this = $(this);
        var check = true;
        _this.find('input[type="text"],input[type="email"],input[type="password"]').each(function(){
            var value = $(this).val();
            if($.trim(value) == null || $.trim(value) == ''){
                $(this).addClass('waring');
                check = false;
            }
            else{
                 $(this).removeClass('waring');
            }
        });


        var v = grecaptcha.getResponse();
        if(v.length == 0)
        {
            $('#g-recaptcha-signup iframe').addClass('waring');
            check = false;
        }
        else{
            $('#g-recaptcha-signup iframe').removeClass('waring');
            $("input#recaptcha").val(v);
        }
        if(check){
            login_signup();
            grecaptcha.reset();
        }
        return false;
    });

    $('#form-login').submit(function () {
        _this = $(this);
        var check = true;
        _this.find('input[type="email"],input[type="password"]').each(function(){
            var value = $(this).val();
            if($.trim(value) == null || $.trim(value) == ''){
                $(this).addClass('waring');
                check = false;
            }
            else{
                 $(this).removeClass('waring');
            }
        });
        if(check){
            login_signup();
        }
        return false;
    });

    var get_offset_footer = 0;
    var height_footer = 0
    $(window).scroll(function () {
        $.each($(".fixt"), function () {
            if (screen_height > $(this).height()) {
                get_offset_footer = $($(this).attr("data-element-bottom")).offset().top;
                height_footer = $("#footer").height();
                if ($(window).scrollTop() >= $(this).attr("data-top") && ($(window).scrollTop() + $(this).height()) < get_offset_footer) {
                    $(this).css({"position": "fixed", "top": 0, "bottom": "auto"});
                } else if (($(window).scrollTop() + $(this).height()) >= get_offset_footer) {
                    $(this).css({"top": "auto", "bottom": (height_footer + 10) + "px"});
                } else {
                    $(this).css({"position": "static", "top": "auto", "bottom": "auto"});
                }
            }

        });
    });
    var _event = [];
    var _event_cookie;
    var display = 0;
    var timeout = 0.1;
    //get_event();
    var _eventopen = 0;
    var befor_event = 0;
    if(frontend == true){
    	var time_load_chat = setInterval(function(){
	        if(_event.length > 0 && getCookie("events_"+_event[0]["ID"]) == ""){
	        	if(_eventopen == 0){
	        		set_event();
	        	}
	        }else{
	        	if(_event.length > 0){
	        		_event.splice(0, 1);
	        	}
	        }
	        if(_event.length == 0){
	        	//get_event();
	        }
	    }, timeout * (60 * 1000));
    }
    $("#modal-events .modal-dialog .close").click(function(e){
    	e.stopPropagation();
    	_eventopen = 0;
    	$("#modal-events").modal("hide");
    });
    function get_event(){
        $.ajax({
            url: base_url+"home/get_events",
            type: "post",
            dataType: 'json',
            data: {"id": 0},
            success: function (data) {
               _event = data;
               if(befor_event == 0 && _event.length > 0 && getCookie("events_"+_event[0]["ID"]) == ""){
               		setTimeout(function(){
	                   set_event();
	                }, 5000);
               }
            },
            error: function () {
              
            }
        });
    }
    function set_event(){
    	_eventopen = 1;
        $.ajax({
            url: base_url+"home/events",
            type: "post",
            dataType: 'json',
            data: {"id": _event[0]["ID"]},
            success: function (data) {
                setCookie("events_"+_event[0]["ID"]+"", _event[0]["Title"], _event[0]["Set_Cookie"]);
                display = parseInt(_event[0]["Time_Display"]) * (60 * 1000) ;
                $("#modal-events .modal-dialog").removeClass("modal-sm");
                $("#modal-events .modal-dialog").removeClass("modal-md");
                $("#modal-events .modal-dialog").removeClass("modal-lg");
                $("#modal-events .modal-dialog").addClass(data["Width"]);
                $("#modal-events #box-header").html(data["Hearder"]);
                $("#modal-events .modal-body").html(data["Main"]);
                $("#modal-events .modal-footer").html(data["Footer"]);
                $("#modal-events").modal();
                setTimeout(function(){
                    $("#modal-events").modal("hide");
                    _eventopen = 0;
                }, display);
               _event.splice(0, 1);
            },
            error: function () {
              
            }
        });
    }
    function setCookie(cname, cvalue, exdays) {
        var date = new Date();
        date.setTime(date.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + date.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires + ";Path=/;";
    }
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ')
                c = c.substring(1);
            if (c.indexOf(name) == 0)
                return replaceAll(c.substring(name.length, c.length),"%2C",",");
        }
        return "";
    }
    function deleteCookie(name) {
      document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }
    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(find, 'g'), replace);
    }

});
function loading() {
    return "<div class ='loadding'><img src ='" + base_url + "skins/images/loading-2.gif" + "'></div>";
}
function remove_loadding(object) {
    object.find(".loadding").remove();
}
function messenger_box(title, warning) {
    $("#title-messenger").html(title);
    $("#warning-messenger").html(warning);
    $("#messenger-box").modal();
}
$(document).on("click", ".loadding", function (event) {
    event.stopPropagation();
    return false;
});

function login_signup() {
    _this.ajaxSubmit({
        beforeSubmit: function () {
            _this.find(".alert").hide();
            _this.find('.btn').attr('disabled', 'disabled');
            _this.find('.custom-loading').show();
        },
        dataType: "json",
        success: function (data) {
            //console.log(data);
            if (data['status'] == 'success') {
                window.location.reload();
            } else if (data['status'] == 'fail') {
                _this.find(".alert p").html(data['message']);
                _this.find(".alert").show();
            } else {
                _this.find(".alert p").html('Đã xảy ra lỗi. Vui lòng thử lại!');
                _this.find(".alert").show();
            }
        },
        error: function () {
            _this.find(".alert p").html('Đã xảy ra lỗi. Vui lòng thử lại!');
            _this.find(".alert").show();
        },
        complete: function () {
            _this.find('.btn').removeAttr('disabled');
            _this.find('.custom-loading').hide();
        }
    });
}
$(document).on("click", "#modal_action_product #ok-delete", function () {
    $(this).append(loading());
    var ajax_this = $(this);
    var type = _this.data("type");
    if(_reset == 0 ){
        _reset = 1;
        $.ajax({
            url: $(this).parents("#modal_action_product").find("#action").val(),
            type: "post",
            dataType: 'json',
            data: {"id": 0},
            success: function (data) {
                if (data["success"] == "success") {
                    _reset = 0;
                    if (_reload == true) {
                        window.location.href = _url_reload;
                    } else {
                        if (type == "disabled") {
                            if (data["number"] == 1) {
                                _this.find("i").removeClass("fa-lock").addClass("fa-unlock");
                            } else {
                                _this.find("i").removeClass("fa-unlock").addClass("fa-lock");
                            }
                            $("#modal_action_product").modal('hide');
                        } else {
                            $("#modal_action_product").modal('hide');
                            _this.fadeOut("slow", function () {
                                _this.remove();
                            });
                        }
                    }

                } else {
                    alert("error");
                    $("#modal_action_product").modal('hide');
                }
                remove_loadding(ajax_this);
            },
            error: function () {
                _reset = 0;
                alert("error");
                $("#modal_action_product").modal('hide');
                remove_loadding(ajax_this);
            }
        });
    }
});


function action_product(url, ojb, reload, url_reload) {
    _this = ojb;
    if (reload == true) {
        _reload = reload;
        if(typeof url_reload !="undefined" && url_reload != null ){
            _url_reload = url_reload;
        }
    }
    $("#modal_action_product #action").val(url);
    $("#modal_action_product").modal();
}
function to_slug(str) {
    str = str.toLowerCase();
    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
    str = str.replace(/(đ)/g, 'd');
    str = str.replace(/([^0-9a-z-\s])/g, '');
    str = str.replace(/(\s+)/g, '-');
    str = str.replace(/^-+/g, '');
    str = str.replace(/-+$/g, '');
    return str;
}
$(document).on("click", ".loadding", function (e) {
    e.stopPropagation();
    return false;
});
function error_messenger(message,class_modal){
    $("#modal_error_messenger .modal-dialog").removeClass("modal-sm");
    $("#modal_error_messenger .modal-dialog").removeClass("modal-md");
    $("#modal_error_messenger .modal-dialog").removeClass("modal-lg");
    var modal_width = "modal-sm";
    if(typeof class_modal !== "undefined"){
        modal_width = class_modal;
    }
    $("#modal_error_messenger .modal-dialog").addClass(modal_width);
    $("#modal_error_messenger .messenger").html(message);
    $("#modal_error_messenger").modal();
}
function validateform(ojb,showmessenger) {
    var check_all = true;
    var check = true;
    var errormessenger  = [];
    ojb.find(".warning").removeClass("warning");
    $.each(ojb.find("[data-validate = true]"), function () {
        var name = $(this).attr("name");
        var value = $(this).val();
        var type = $(this).attr("type");
        var tag = $(this).prop("tagName");
        var lenght_value = value.length;
        var min = $(this).data("min");
        var max = $(this).data("max");
        var required = $(this).data("required");
        var for_show = $(this).data("for");
        var matches = $(this).data("matches");
        var data_group = $(this).data("group");
        var data_url  = $(this).data("url");
        var data_number = $(this).data("number");
        var data_email = $(this).data("email");
        var data_password = $(this).data("password");
        var data_phone   = $(this).data("phone");
        var check = true;  
        if (typeof data_group !== "undefined") {
            //data-group = "true"
            if ($(this).find("input:checked").length < 1) { 
                check_all = false;
                check = false;
            }
        } else {
            //data-required = "true"
            if (typeof required != "undefined" && value == "") {
                check_all = false;
                check = false;
            }
            //data-matches = "element" (ex:confirm password)
            if (typeof matches != "undefined" && ojb.find(matches).val() != value) {
                check_all = false;
                check = false;
            }
            //data-number = "true" || type == "number"
            if ((type == "number" || typeof data_number != "undefined") && value != "" && isNaN(value) == true) {
                check_all = false;
                check = false;
            }
            //data-min = "number" & data-max == "number"
            if(( type == "number" || typeof data_number != "undefined") &&  typeof min != "undefined" && parseFloat(value) < parseFloat(min) ){
                check_all = false;
                check = false;
            }
            if(( type == "number" || typeof data_number != "undefined") &&  typeof max != "undefined" && parseFloat(value) > parseFloat(max) ){
                check_all = false;
                check = false;
            }
            //data-password = "true"
            if ((type == "password" || typeof data_password != "undefined") && !valid_password(value) && value != "") {
                check_all = false;
                check = false;
            }
            //data-email = "true"
            if ((type == "email" || typeof data_email != "undefined") && value != "" && !valid_email(value) ) {
                check_all = false;
                check = false;
            }
            //data-min = "number" & data-max == "number" in text or TEXTAREA
            if ((type == "text" || tag == "TEXTAREA") && typeof data_number === "undefined" && ((typeof min != "undefined" && lenght_value < min) || (typeof max != "undefined" && lenght_value > max))) {
                check_all = false;
                check = false;
            }
            //data-url = "true" 
            if (typeof data_url != "undefined" && valid_url(value)  && value != "") {
                check_all = false;
                check = false;
            }
            if (typeof data_phone != "undefined" && phonenumber(value)  && value != "") {
                check_all = false;
                check = false;
            }
        }
        if(!check){
            if (typeof data_for !== "undefined") {
                $(data_for).addClass("warning");
            } else {
                $(this).addClass("warning");
            }
        }
        
    });
    return check_all;
}
function valid_password(text) {
    if (text.trim().length < 6) {
        return false;
    } else {
        return true;
    }
}
function valid_email(text) {
    filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filter.test(text)) {
        return false;
    } else {
        return true;
    }
}
function valid_url(text){
    if(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(text)){
        return false;
    } else {
        return true;
    }
}
function phonenumber(inputtxt)  
{  
    var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;  
    if( inputtxt.value.match(phoneno) ){  
      return true;  
    }else {  
        return false;  
    }  
}
function isValidDate(date)
{


    var formatted = $.datepicker.formatDate("Y,M,d", new Date(date));
    var matches = /^(\d{2})[-\/](\d{2})[-\/](\d{4})$/.exec(formatted);
    if (matches == null) return false;
    var d = matches[2];
    var m = matches[1] - 1;
    var y = matches[3];
    var composedDate = new Date(y, m, d);
    return composedDate.getDate() == d &&
            composedDate.getMonth() == m &&
            composedDate.getFullYear() == y;
}
function isValidDate(date)
{
    var matches = /^(\d{2})[-\/](\d{2})[-\/](\d{4})$/.exec(date);
    if (matches == null) return false;
    var d = matches[1];
    var m = matches[2]-1;
    var y = matches[3];
    var composedDate = new Date(y, m, d);
    return composedDate.getDate() == d &&
           composedDate.getMonth() == m &&
           composedDate.getFullYear() == y;
}

$(document).on("keyup", ".not-null", function () {
    var check_next = 0;
    $.each($(this).parents("#box-main").find(".not-null"), function () {
        if ($(this).val().trim() == "") {
            check_next++;
        }
    });
    if (check_next == 0) {
        $(this).parents("#box-main").find(".controller").removeAttr('disabled');
    } else {
        $(this).parents("#box-main").find(".controller").prop('disabled', 'disabled');
    }
});
function fomat_string(number){
    number = number.replace(/\D/g,'');
    var number_lenght =  number.length;
    var balances =  number_lenght % 3;
    var number_return = "";
    if(number_lenght > 3){
        if(balances != 0){
            number_return = number.slice(0, balances)+".";
        }
        for (var i_2 = balances; i_2 < number_lenght; i_2 = i_2 + 3) {
            if(i_2 + 3 == number_lenght){
                number_return += number.slice((i_2), i_2 + 3 );
            }else{
                number_return += number.slice((i_2), i_2 + 3 ) + ".";
            }
        }  
    }else{
        number_return = number;
    }
    return number_return ;
}
function read_number(number,unti){
    number = number.replace(/\D/g,'');
    var number_lenght =  number.length;
    if(number_lenght < 22){
        number_unti = new Array(
            "",
            "ngàn ",
            "triệu ",
            "tỉ ",
            "ngàn tỉ ",
            "triệu tỉ ",
            "tỉ tỉ "
        );
        var balances =  number_lenght % 3;
        var str_number = "";
        var i_number = Math.floor(number_lenght/3) ;
        var number_return = "";
        if(balances != 0){
            number_return = read_three_number(number.slice(0, balances)) + number_unti[i_number];
        }
        for (var i_2 = balances; i_2 < number_lenght; i_2 = i_2+3) {
            str_number = number.slice((i_2),i_2+3);
            i_number--;
            if(str_number != "000"){
                number_return += (read_three_number(str_number)+number_unti[i_number]) ;
            }
        }
        if(number_return != "")
            return number_return + unti;
        else
            return "";
    }
    return "Số tiền quá lớn!.";
    
}
function read_three_number(number){
    var string = "";
    var number_read = {"0":"không ","1":"một ","2":"hai ","3":"ba ","4":"bốn ","5":"năm ","6":"sáu ","7":"bảy ","8":"tám ","9":"chín "};
    var unti  = {"3":"trăm ","2":"mươi ","1":""};
    var int_i = 0;
    if(number != "000"){
        if(number != "10" ){
            for(var i = number.length ; i > 0 ; i--){
                int_i++;
                if(i == 2 && number.slice((int_i-1),int_i) == "0"){
                    if( number.slice((int_i),int_i + 1) != "0"){
                        string += "linh ";
                    }
                }else{
                    if(i != 1 || number.slice((int_i-1),int_i) != "0"){
                        if(i == 1 && number.slice((int_i-1),int_i) == "5" && number.slice((int_i-2),int_i-1) != "0" && number.length > 1){
                            string += "lăm " +unti[i];
                        }
                        else if( i == 1 && number.slice((int_i-1),int_i) == "1" && number.length > 1 &&  (number.slice((int_i-2),int_i-1) != "1" && number.slice((int_i-2),int_i-1) != "0")  ){
                            string += "mốt ";    
                        }
                        else {
                            if(i == 2 && number.slice((int_i-1),int_i) == "1"){
                                string += "mười ";
                            }else{
                                string += number_read[number.slice((int_i-1),int_i)] + unti[i];
                            }
                        }
                    }    
                        
                }
            }
        }else{
            string ="mười ";
        }
    }
    return string;
}
$(document).ready(function(){

    $("#price_product").keyup(function(){
        var val_text = $(this).val();
        $(this).val(fomat_string(val_text));
        var text = read_number($(this).val(),"đồng");
        $(this).parents(".box-price-product").find("#show").html(text);
    });

    $.each($("#price_product"),function(){
        var val_text = $(this).val();
        $(this).val(fomat_string(val_text));
        var text = read_number($(this).val(),"đồng");
        $(this).parents(".box-price-product").find("#show").html(text);
    });

    $(".user-menu-holder .not-login .dropdown .dropbtn").click(function(){
        if(!$(this).parent().hasClass('open')){
            $(".user-menu-holder .not-login .dropdown").removeClass('open');
        }
        $(this).parent().toggleClass('open');
        return false;
    });
});
$(document).on("click","#signup-newsletter",function(){
    var email = $(this).parents("form").find("input[type = email]").val();
    var event_id = $(this).parents("form").find("input[name = Event_ID]").val();
    if(valid_email(email)){
        $.ajax({
            "url":base_url + "home/newsletter",
            "type":"post",
            "dataType":"json",
            "data":{"Email" : email,"Event_ID":event_id},
            success:function(data){
                if(data["success"] == "success"){
                    setTimeout(function(){
                        $("#modal-events").modal("hide");
                        _eventopen = 0;
                    }, 10000);
                }else{

                }
                $("#newsletter-form .messenger-newsletter").html("<p>"+data["messenger"]+"</p>");
            },
            error:function(){

            }
        });
    }else{
        $(this).parents("form").find("input[type = email]").addClass("warning");
    }    
    return false;
});

//INSERT JS//

//JS fix scroll header
jQuery(document).ready(function($) {
    var $filter = jQuery('.site-header');
    var $filterSpacer = jQuery('<div />', {
        "class": "vnkings-spacer",//class isert bottom (height)
        "height": $filter.outerHeight()
        });
    if ($filter.size()){
        jQuery(window).scroll(function (){
           if (!$filter.hasClass('fix') && jQuery(window).scrollTop() > $filter.offset().top){
                $filter.before($filterSpacer);
                $filter.addClass("fix");
            }else if ($filter.hasClass('fix')  && jQuery(window).scrollTop() < $filterSpacer.offset().top){
                $filter.removeClass("fix");
                $filterSpacer.remove();
            }
        });
    }

});

jQuery(document).ready(function($) {
    var $filter = jQuery('');
    var $filterSpacer = jQuery('<div />', {
        "class": "vnkings-spacer",//class isert bottom (height)
        "height": $filter.outerHeight()
        });
    if ($filter.size()){
        jQuery(window).scroll(function (){
           if (!$filter.hasClass('fix') && jQuery(window).scrollTop() > $filter.offset().top){
                $filter.before($filterSpacer);
                $filter.addClass("fix");
            }else if ($filter.hasClass('fix')  && jQuery(window).scrollTop() < $filterSpacer.offset().top){
                $filter.removeClass("fix");
                $filterSpacer.remove();
            }
        });
    }

});

jQuery(window).scroll(function() {
    if (jQuery(window).scrollTop() > 90) {
        jQuery(".top-search").hide("fast");
    }
    else {
        jQuery(".top-search").show("fast");
    }
});
