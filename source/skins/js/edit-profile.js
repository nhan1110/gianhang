var jcrop_api=null;
$(document).ready(function(){
    /*------------------
    //Close modal avatar
    //------------------*/
    $('#imageCropper-modal').on('hidden.bs.modal', function () {
          if (jcrop_api!=null && typeof jcrop_api != 'undefined') {
              jcrop_api.destroy();
              jcrop_api=null;
          }
          $('#imageCropper-modal #uploadPreview').removeAttr('style');
    });

    /*------------------
    //Crop Avatar
    //------------------*/
    $("#crop-avatar").submit(function(){
          $("#imageCropper-modal button.btn-primary").addClass('loading');
          var options = { 
            beforeSend: function(){
            },
            dataType:'json',
            uploadProgress: function(event, position, total, percentComplete){
            },
            success: function(data){
                console.log(data);
                if(data['status']=='success'){
                  $(".avatar").attr('src',data['name']);
                  $('#imageCropper-modal').modal('toggle');
                }
            },
            complete: function(response){
               $("#imageCropper-modal button.btn-primary").removeClass('loading');
            },
            error: function(){
              //alert('error');
            }
        }; 
        $(this).ajaxSubmit(options);
        return false;
  });

  /*-----------------------
  //Save Profile
  //-----------------------
  $(document).on('click','#save-profile',function(){
    var bool=true;
    $("#form-edit-profile input.required").each(function(){
        if($.trim($(this).val())==''){
            bool=false;
            $(this).addClass('border-error');
        }
        else{
            $(this).removeClass('border-error');
        }
    });

    if( $('#form-edit-profile').find("#password").length>0 ){
        var password =$('#form-edit-profile').find("#password").val();
        var confirmpassword =$('#form-edit-profile').find("#confirmpassword").val();
        if(password!='' || confirmpassword!=''){
            if(password!='' && password.length < 6){
                messenger_box("Chỉnh sữa thông tin", 'Vui lòng nhập mật khẩu trên 6 ký tự.');
                $('#form-edit-profile #password').addClass('border-error');
                return false;
            }
            else{
                 $('#form-edit-profile #password').removeClass('border-error');
                 if(confirmpassword=='' || confirmpassword.length < 6){
                    messenger_box("Chỉnh sữa thông tin", 'Vui lòng nhập mật khẩu trên 6 ký tự.');
                    $('#form-edit-profile #confirmpassword').addClass('border-error');
                    return false;
                 }
                 else{
                    $('#form-edit-profile #confirmpassword').removeClass('border-error');
                 }
            }

            if(password!=confirmpassword){
                messenger_box("Chỉnh sữa thông tin", 'Mật khẩu không trùng khớp.');
                $('#form-edit-profile #password').addClass('border-error');
                $('#form-edit-profile #confirmpassword').addClass('border-error');
                return false;
            }
            else{
                $('#form-edit-profile #password').removeClass('border-error');
                $('#form-edit-profile #confirmpassword').removeClass('border-error');
            }
        }
    }
    if(bool==false){
        messenger_box("Chỉnh sữa thông tin","Vui lòng nhập đầy đủ thông tin.");
    }
    else{
        var data_form=$('#form-edit-profile').serialize();
        var current=$(this);
        current.addClass('loding');
        current.attr('disabled','disabled');
        $.ajax({
            url: base_url+'/profile/save_edit',
            type: 'POST',
            data: data_form,
            dataType:'json',
            success: function(reponse) {
                console.log(reponse);
                if(reponse['status']=='success'){
                    location.reload();
                }
           },
           complete: function() {
                current.removeAttr('disabled');
                 current.removeClass('loding');
                
           },
           error:function(data){
                console.log(data['responseText']);
           }
        });
    }
    return false;
  });*/

});
/*------------------
//Check file read
//------------------*/
var checkUploadSize=function(input) {
    if (input.files[0].size > 8400000) {
        alert("Ảnh quá lớn. Vui lòng chọn lại !");
        return false;
    }
    var legal_types = Array("image/jpeg", "image/png", "image/jpg");
    if (!inArray(input.files[0].type, legal_types)) {
        alert("File format is invalid. Only upload jpeg or png");
        return false;
    }
    return true;
}
var inArray= function(needle, haystack) {
    var length = haystack.length;
    for (var i = 0; i < length; i++) {
        if (typeof haystack[i] == 'object') {
            if (arrayCompare(haystack[i], needle))
                return true;
        } else {
            if (haystack[i] == needle)
                return true;
        }
    }
    return false;
}
/*------------------
//Read Image avatar
//------------------*/
function readURL(input) {
    if (input.files && input.files[0]) {
        if (!checkUploadSize(input)) {
            return false;
        }
        var p = $("#imageCropper-modal #uploadPreview");
        $("#imageCropper-modal").modal("show");
        p.fadeOut();
        // prepare HTML5 FileReader
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("ImageUploader_image").files[0]);
        oFReader.onload = function(oFREvent) {
            p.attr("src", oFREvent.target.result).fadeIn();
            p.css('max-width','100%');
            //p.css('max-height', $(window).height());
            //p.class('large-11 large-centered columns');
        };
        $("#imageCropper-modal #loading-custom").show();
        if (jcrop_api!=null && typeof jcrop_api != 'undefined') {
      jcrop_api.destroy();
      jcrop_api=null;
    }
    setTimeout(function(){
            p.Jcrop({
                setSelect: [0,0,400,400],
                onChange:  setInfo,
                minSize:[190,190],
                onRelease: clearCoords,
                boxWidth: 600,
                aspectRatio: 1/1,
            }, function(){
                jcrop_api = this;
            });
            $("#imageCropper-modal #loading-custom").hide();
        },1000);
    }
}
function setInfo(c) {
    $("#imageCropper-modal #x").val(c.x);
    $("#imageCropper-modal #y").val(c.y);
    $("#imageCropper-modal #w").val(c.w);
    $("#imageCropper-modal #h").val(c.h);
    $('#image_w').val($('#imageCropper-modal .jcrop-holder').width());
    $('#image_h').val($('#imageCropper-modal .jcrop-holder').height());
    $("#imageCropper-modal #btnSaveView2").removeAttr('disabled');
}

function clearCoords(){
    $("#imageCropper-modal #btnSaveView2").attr('disabled','disabled');
}