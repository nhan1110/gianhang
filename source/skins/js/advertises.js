function register_advertises(ojb){
    if(_reset == 0){
    	_reset = 1;
    	$.ajax({
    		"url":base_url + "advertises/check_user",
    		"type":"POST",
    		"dataType":"json",
    		"data":{
    			"url":ojb.href
    		},success:function(data){
    			if(data["success"] == "success"){
    				if(data["login"] == "false"){
    					$("#messenger-register").modal();
    				}else{
    					window.location.href = ojb.href;
    				}
    			}else{
    				alert("Error");
    			}
    			_reset = 0;
    		},error:function(){
    			alert("Error");
    			_reset = 0;
    		}
    	});
    }
	return false;
}
$(document).ready(function(){
    $("#messenger-register #form-login-advertises").submit(function(){
        var email = $(this).find("#advertises-email").val();
        var password = $(this).find("#advertises-password").val();
        if(!validateform($(this))){ return false; }
        if(_reset == 0){
            _reset = 1;
            $.ajax({
                "url": base_url + "advertises/signin",
                "type":"POST",
                "dataType":"json",
                "data":{"email":email,"password":password},
                success: function(data){
                    var html = "";
                    $.each(data["messenger"],function(key,value){
                        html+="<p>"+value+"</p>";
                    });
                    $("#messenger-register .messenger").addClass(data["status"]).html(html).show();
                    if(data["status"] == "success"){
                        window.location.reload();
                    }
                    _reset = 0;
                },
                error:function(){
                    _reset = 0;
                    alert("Error");
                }
            });
        }
        return false;
    });
    $(document).on("submit","#messenger-register #form-signup-advertises",function(){
        $("#messenger-register .messenger").hide();
        var email = $(this).find("#advertises-email").val();
        var company = $(this).find("#advertises-company").val();
        if(!validateform($(this))){ return false; }
        if(_reset == 0){
            _reset = 1;
            $.ajax({
                "url": base_url + "advertises/signup",
                "type":"POST",
                "dataType":"json",
                "data":{"email":email,"company":company},
                success: function(data){
                    var html = "";
                    $.each(data["messenger"],function(key,value){
                        html+="<p>"+value+"</p>";
                    });
                    $("#messenger-register .messenger").addClass(data["status"]).html(html).show();
                    _reset = 0;
                },
                error:function(){
                    _reset = 0;
                    alert("Error");
                }
            });
        }
        return false;
    }); 
});
