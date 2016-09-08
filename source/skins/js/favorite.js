var jcrop_banner_favorite_api = null;
var favorite_current = null;
$(document).ready(function(){
    /*------------------
    //Close modal avatar
    //------------------*/
    $('#banner-favorite-modal').on('hidden.bs.modal', function () {
          if (jcrop_banner_favorite_api!=null && typeof jcrop_banner_favorite_api != 'undefined') {
              jcrop_banner_favorite_api.destroy();
              jcrop_banner_favorite_api=null;
          }
          $('#banner-favorite-modal #uploadPreview').removeAttr('style');
    });

    /*------------------
    //Crop Avatar
    //------------------*/
    $("#crop-banner-favorite").submit(function(){
          $("#banner-favorite-modal .custom-loading").show();
          var options = { 
            beforeSend: function(){
            },
            dataType:'json',
            uploadProgress: function(event, position, total, percentComplete){
            },
            success: function(data){
                //console.log(data);
                if(data['status']=='success'){
                   favorite_current.css('background-image','url("'+data['banner']+'")');
                   favorite_current.removeClass('default');
                   $('#banner-favorite-modal').modal('toggle');
                }
            },
            complete: function(response){
               $("#banner-favorite-modal .custom-loading").hide();
            },
            error: function(data){
               alert('Lỗi!');
               //console.log(data['responseText']);
            }
        }; 
        $(this).ajaxSubmit(options);
        return false;
    });

    $(".favorite-item .change-banner-favorite").on('click',function(){
        var slug = $(this).attr('data-slug');
        if (typeof slug !== typeof undefined && slug !== false) {
            $("#banner-favorite-modal #slug").val(slug);
            favorite_current = $(this).parents('.favorite-item');
            $("#banner-favorite-modal #banner-favorite-image").trigger('click');
        }
        return false;
    });

    $(".favorite-item .edit-favorite").on('click',function(){
        var slug = $(this).attr('data-slug');
        var name = $(this).parents('.favorite-item').find('.favorite-info h3').text();
        if (typeof slug !== typeof undefined && slug !== false) {
            $("#edit-favorite-modal #slug").val(slug);
            $("#edit-favorite-modal #name").val(name);
            favorite_current = $(this).parents('.favorite-item');
            $("#edit-favorite-modal").modal('show');
        }
        return false;
    });

    $(".favorite-action .move-favorite").on('click',function(){
        var id = $(this).attr('data-id');
        if (typeof id !== typeof undefined && id !== false) {
            $("#move-favorite-modal #product_id").val(id);
            $("#move-favorite-modal").modal('show');
        }
        return false;
    });

    /*------------------
    // Edit favorite
    //------------------*/
    $("#edit-favorite-form").submit(function(){
          var name = $(this).find('#name').val();
          if($.trim(name)!=null && $.trim(name) != ''){
               $(this).find('#name').removeClass('waring');
          }
          else{
               $(this).find('#name').addClass('waring');
               return false;
          }
          $("#edit-favorite-form .custom-loading").show();
          var options = { 
            beforeSend: function(){
            },
            dataType:'json',
            uploadProgress: function(event, position, total, percentComplete){
            },
            success: function(data){
                //console.log(data);
                if(data['status']=='success'){
                   $('#edit-favorite-modal').modal('toggle');
                   location.reload();
                }
            },
            complete: function(response){
               $("#edit-favorite-form .custom-loading").hide();
            },
            error: function(data){
               alert('Lỗi!');
               //console.log(data['responseText']);
            }
        }; 
        $(this).ajaxSubmit(options);
        return false;
    });

    /*------------------
    // move item to favorite
    //------------------*/
    $("#move-favorite-form").submit(function(){
          $("#move-favorite-form .custom-loading").show();
          $("#move-favorite-form .alert").hide();
          var options = { 
            beforeSend: function(){
            },
            dataType:'json',
            uploadProgress: function(event, position, total, percentComplete){
            },
            success: function(data){
                //console.log(data);
                if(data['status'] == 'success'){
                   $("#move-favorite-form .alert-success").show();
                   //$('#edit-favorite-modal').modal('toggle');
                   setTimeout(function(){
                      location.reload();
                   },2000);
                }
                else if(data['status'] == 'fail'){
                   $("#move-favorite-form .alert-danger p").html(data['message']);
                   $("#move-favorite-form .alert-danger").show();
                }
            },
            complete: function(response){
               $("#move-favorite-form .custom-loading").hide();
            },
            error: function(data){
               alert('Lỗi!');
               //console.log(data['responseText']);
            }
        }; 
        $(this).ajaxSubmit(options);
        return false;
    });
    /*------------------
    // add favorite
    //------------------*/
    $("#add-favorite-form").submit(function(){
          var name = $(this).find('#name').val();
          var type = $(this).find('#type').val();
          var check = true;
          if($.trim(name)!=null && $.trim(name) != ''){
               $(this).find('#name').removeClass('waring');
          }
          else{
               $(this).find('#name').addClass('waring');
               check = false;
          }

          if($.trim(type)!=null && $.trim(type) != ''){
               $(this).find('#type').removeClass('waring');
          }
          else{
               $(this).find('#type').addClass('waring');
               check = false;
          }

          if(check == false){
            return check;
          }
          $("#add-favorite-form .custom-loading").show();
          $('#add-favorite-form .alert').hide();
          var options = { 
            beforeSend: function(){
            },
            dataType:'json',
            uploadProgress: function(event, position, total, percentComplete){
            },
            success: function(data){
                console.log(data);
                if(data['status'] == 'success'){
                   $('#add-favorite-modal').modal('toggle');
                   location.reload();
                }
                else if(data['status'] == 'fail'){
                    $('#add-favorite-form .alert').html(data['message']).show();
                }
            },
            complete: function(response){
               $("#add-favorite-form .custom-loading").hide();
            },
            error: function(data){
               //alert('Lỗi!');
               console.log(data['responseText']);
            }
        }; 
        $(this).ajaxSubmit(options);
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
//Read Image avatar
//------------------*/
function readURL(input) {
    if (input.files && input.files[0]) {
        if (!checkUploadSize(input)) {
            return false;
        }
        var p = $("#banner-favorite-modal #uploadPreview");
        $("#banner-favorite-modal").modal("show");
        p.fadeOut();
        // prepare HTML5 FileReader
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("banner-favorite-image").files[0]);
        oFReader.onload = function(oFREvent) {
            p.attr("src", oFREvent.target.result).fadeIn();
            p.css('max-width','100%');
            //p.css('max-height', $(window).height());
            //p.class('large-11 large-centered columns');
        };
        $("#banner-favorite-modal .custom-loading").show();
        if (jcrop_banner_favorite_api!=null && typeof jcrop_banner_favorite_api != 'undefined') {
           jcrop_banner_favorite_api.destroy();
           jcrop_banner_favorite_api=null;
        }
        setTimeout(function(){
            p.Jcrop({
                setSelect: [0,0,400,400],
                onChange:  setInfo,
                minSize:[260,260],
                onRelease: clearCoords,
                boxWidth: 600,
                aspectRatio: 1/1,
            }, function(){
                jcrop_banner_favorite_api = this;
            });
            $("#banner-favorite-modal .custom-loading").hide();
        },1000);
    }
}
function setInfo(c) {
    $("#banner-favorite-modal #x").val(c.x);
    $("#banner-favorite-modal #y").val(c.y);
    $("#banner-favorite-modal #w").val(c.w);
    $("#banner-favorite-modal #h").val(c.h);
    $('#banner-favorite-modal #image_w').val($('#banner-favorite-modal .jcrop-holder').width());
    $('#banner-favorite-modal #image_h').val($('#banner-favorite-modal .jcrop-holder').height());
    $("#banner-favorite-modal #btnSaveView2").removeAttr('disabled');
}

function clearCoords(){
    $("#banner-favorite-modal #btnSaveView2").attr('disabled','disabled');
}