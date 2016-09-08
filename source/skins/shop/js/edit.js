var jcrop_api=null;
var jcrop_api_banner=null;
$(document).ready(function(){
    /*------------------
    //Close modal logo
    //------------------*/
    $('#imageCropper-modal').on('hidden.bs.modal', function () {
          if (jcrop_api!=null && typeof jcrop_api != 'undefined') {
              jcrop_api.destroy();
              jcrop_api=null;
          }
          $('#imageCropper-modal #uploadPreview').removeAttr('style');
    });

    /*------------------
    //Close modal banner
    //------------------*/
    $('#update-banner').on('hidden.bs.modal', function () {
          if (jcrop_api_banner!=null && typeof jcrop_api_banner != 'undefined') {
              jcrop_api_banner.destroy();
              jcrop_api_banner=null;
          }
          $('#update-banner #uploadPreview').removeAttr('style');
    });

    /*------------------
    //Crop logo
    //------------------*/
    $("#crop-logo").submit(function(){
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
                  $(".logo-shop").attr('src',data['name']);
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

    /*------------------
    //Crop logo
    //------------------*/
    $("#crop-banner").submit(function(){
          $("#update-banner button.btn-primary").addClass('loading');
          var options = { 
            beforeSend: function(){
            },
            dataType:'json',
            uploadProgress: function(event, position, total, percentComplete){
            },
            success: function(data){
                console.log(data);
                if(data['status']=='success'){
                  $("#header").css("background-image", "url('"+data['name']+"')");
                  $('#update-banner').modal('toggle');
                }
            },
            complete: function(response){
               $("#update-banner button.btn-primary").removeClass('loading');
            },
            error: function(){
            }
        }; 
        $(this).ajaxSubmit(options);
        return false;
    });

    /*----------------
    // Edit item
    //------------------*/
    $(".wrap-action .action-builder").click(function(){
        if(!$(this).hasClass('closes')){
            $(this).parents('.wrap-action').find('.action-edit').show();
            $(this).parents('.wrap-action').find('.action-view').hide();
            $(this).addClass('closes');
            $(this).find('i').removeClass('fa-pencil').addClass('fa-times');
        }
        else{
            $(this).parents('.wrap-action').find('.action-edit').hide();
            $(this).parents('.wrap-action').find('.action-view').show();
            $(this).find('i').removeClass('fa-times').addClass('fa-pencil');
            $(this).removeClass('closes');
        }
        return false;
    });

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
//Read Image Logo
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
                setSelect: [0,0,360,120],
                onChange:  setInfo,
                minSize:[180,60],
                onRelease: clearCoords,
                boxWidth: 600,
                aspectRatio: 3/1,
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
    $('#imageCropper-modal #image_w').val($('#imageCropper-modal .jcrop-holder').width());
    $('#imageCropper-modal #image_h').val($('#imageCropper-modal .jcrop-holder').height());
    $("#imageCropper-modal #btnSaveView2").removeAttr('disabled');
}

function clearCoords(){
    $("#imageCropper-modal #btnSaveView2").attr('disabled','disabled');
}

/*------------------
//Read Image Banner
//------------------*/
function readURL1(input) {
    if (input.files && input.files[0]) {
        if (!checkUploadSize(input)) {
            return false;
        }
        var p = $("#update-banner #uploadPreview");
        $("#update-banner").modal("show");
        p.fadeOut();
        // prepare HTML5 FileReader
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("ImageUploader_banner").files[0]);
        oFReader.onload = function(oFREvent) {
            p.attr("src", oFREvent.target.result).fadeIn();
            p.css('max-width','100%');
            //p.css('max-height', $(window).height());
            //p.class('large-11 large-centered columns');
        };
        $("#update-banner #loading-custom").show();
        if (jcrop_api_banner!=null && typeof jcrop_api_banner != 'undefined') {
          jcrop_api_banner.destroy();
          jcrop_api_banner=null;
        }
        setTimeout(function(){
            p.Jcrop({
                setSelect: [0,0,900,300],
                onChange:  setInfo1,
                minSize:[180,60],
                onRelease: clearCoords1,
                boxWidth: 900,
                aspectRatio: 3/1,
            }, function(){
                jcrop_api_banner = this;
            });
            $("#update-banner #loading-custom").hide();
        },1000);
    }
}
function setInfo1(c) {
    $("#update-banner #x").val(c.x);
    $("#update-banner #y").val(c.y);
    $("#update-banner #w").val(c.w);
    $("#update-banner #h").val(c.h);
    $('#update-banner #image_w').val($('#update-banner .jcrop-holder').width());
    $('#update-banner #image_h').val($('#update-banner .jcrop-holder').height());
    $("#update-banner #btnSaveView3").removeAttr('disabled');
}

function clearCoords1(){
    $("#update-banner #btnSaveView3").attr('disabled','disabled');
}