var paging = 0;
var isAjax = true;
var total_media = 0;
var jcrop_api_photo = null;
var number_upload = 0;
var new_image = 0;

$(document).ready(function(){ 

      $(document).on('click','#modal_upload #select-file',function(){
          $("#_upload #upload-media").trigger('click');
          return false;
      });


      $(document).on('click','.choose-upload',function(){
          choose_featured();
          return false;
      });


      /*-----------------
      //Choose gallery
      //-----------------*/
      $(document).on('click','#modal_upload .gallery .item',function(){
          if($(this).hasClass('active')){
          	 $(this).removeClass('active');
          }
          else{
          	 $(this).addClass('active');
          }
          return false;
      });

      /*-----------------
      //Choose featured
      //-----------------*/
      $(document).on('click','#modal_upload .featured .item',function(){
          if($(this).hasClass('active')){
          	 $(this).removeClass('active');
          }
          else{
          	$("#modal_upload .featured .item").removeClass('active');
          	$(this).addClass('active');
          }
          return false;
      });

      /*------------------
      //Close modal upload photo
      //------------------*/
      $('#modal_upload').on('hidden.bs.modal', function () {
          $("#modal_upload .item").removeClass('active');
          $("#modal_upload .grid-photo").removeClass('gallery');
          $("#modal_upload .grid-photo").removeClass('featured');
      });


      /*------------------
      //Load image scroll
      //------------------*/
      $('#modal_upload #history_image').scroll(function() {
          if( $(this).scrollTop() + $(this).innerHeight() + 10 >= $(this).prop("scrollHeight") ){
             if(isAjax==true && paging*12 < total_media){
                get_photo(0);
             }
          }
      });


      /*------------------
      //Delete Photo
      //------------------*/
      $(document).on('click','#modal_upload .action-image .delete',function(){
          if(confirm('Bạn có muốn xóa ảnh này không ?')){
              var data_id = $(this).attr('data-id');
              var current = $(this);
              var curren_new_image = 0;
              if($(this).parents('.item').hasClass('default-upload')){
              	  curren_new_image = 1;
              }
              if(typeof data_id !== 'undefined' && data_id!=null){
                  $.ajax({
                      url  : base_url+"medias/delete_photo",
                      type : "post",
                      dataType:'json',
                      data : {'photo_id':data_id},
                      success : function(data) {
                          if(data['status']=='success'){
                          		new_image = new_image - new_image;
                          		number_upload = data['number_upload'];
                          		//console.log(number_upload);
                          		current.parents('.item').fadeOut('slow',function(){
                                 	$(this).remove();
                              	});
                          }
                      },
                      complete:function(){
                        
                      }
                  });
              }
          }
          return false;
      });


      /*------------------
      //Get info Photo
      //------------------*/
      $(document).on('click','#modal_upload .action-image .edit',function(){
          var data_id = $(this).attr('data-id');
          var current = $(this);
          if(typeof data_id !== 'undefined' && data_id!=null){
              $.ajax({
                  url  : base_url+"medias/get_photo_by_id/"+data_id,
                  type : "post",
                  dataType:'json',
                  data : {},
                  success : function(data) {
                      if(data['status']=='success'){
                      	 $("#image-edit-info-modal #edit-image-form #photo_id").val(data['id']);
                      	 $("#image-edit-info-modal #edit-image-form #title").val(data['title']);
                      	 $("#image-edit-info-modal #edit-image-form #description").val(data['description']);
                         $("#image-edit-info-modal").css('z-index','1056').modal('show');
                         $('.modal-backdrop').css('z-index','1055');
                      }
                  },
                  complete:function(){
                    
                  }
              });
          }
          return false;
      });

      /*------------------
      //Edit Photo
      //------------------*/
      $("#edit-image-form").submit(function(){
      		var title = $("#edit-image-form #title").val();
      		if($.trim(title) == '' || $.trim(title) == null){
      			  $("#edit-image-form #title").addClass('warning');
      			  return false;
      		}
      		else{
      			  $("#edit-image-form #title").removeClass('warning');
      		}
          $("#edit-image-form .loading-image").show();
          $("#edit-image-form button").attr('disabled','disabled');
          var options = {
              dataType:'json',
              beforeSend: function(){
              },
              uploadProgress: function(event, position, total, percentComplete){
              },
              success: function(data){
                  //console.log(data);
                  if(data['status']=='success'){
                      $("#edit-image-form #title").val('');
                      $("#edit-image-form #description").val('');
  	                  $("#image-edit-info-modal").modal('toggle');
                  }
              },
              complete: function(response){
                 $("#edit-image-form .loading-image").hide();
                 $("#edit-image-form button").removeAttr('disabled');
              },
              error: function(){
              	 alert('Lỗi khi lưu');
              }
          }; 

          $(this).ajaxSubmit(options);
          return false;
      });

    /*------------------
    //Crop Photo
    //------------------*/
    $(document).on('click','#modal_upload .action-image .crop',function(){
          var data_id=$(this).attr('data-id');
          if(typeof data_id !== 'undefined' && data_id!=null){
              var src = $(this).parents('.item').find('.image-item').attr('src');
              //var p = $("#crop-photo-modal #uploadPreview");
              $("#crop-photo-modal #uploadPreview1").attr('src',src);
              $("#crop-photo-modal").css('z-index','1056').modal('show');
              $('.modal-backdrop').css('z-index','1055');
              $("#crop-photo-modal #photo_id").val(data_id);
              $("#crop-photo-modal .custom-loading").show();
              if (jcrop_api_photo!=null && typeof jcrop_api_photo != 'undefined') {
                  jcrop_api_photo.destroy();
                  jcrop_api_photo=null;
              }
              setTimeout(function(){
                  $("#crop-photo-modal #uploadPreview1").Jcrop({
                      setSelect: [0,0,600,600],
                      onChange:  setInfo_photo,
                      minSize:[320,250],
                      onRelease: clearCoords_photo,
                      boxWidth: 770,
                      //aspectRatio: 1/1,
                  }, function(){
                      jcrop_api_photo = this;
                  });
                  $("#crop-photo-modal .custom-loading").hide();
              },1000);
          }
          return false;
    });

    /*------------------
    // Upload Image
    //------------------*/
    $(document).on("change","#modal_upload #_upload #upload-media",function(){
         var html  ='<div class="col-xs-4 col-sm-3 col-md-2 item default-upload relative">';
              html +='  <div class="bg-item-image hidden"></div>';
              html +='  <div class="loadding-upload-ajax">';
              html +='      <div>';
              html +='          <img src ="'+base_url+'skins/images/loading.gif">';
              html +='      </div>';
              html +='  </div>';
              html +='  <div class="check-image"><img src="'+base_url+'skins/images/check-upload.jpg"></div>';
              html +='  <img class="image-item default" src = "'+base_url+'skins/images/thumbnail-default.jpg">';
              html +='</div>';
          var countFiles = $(this)[0].files.length;
          var _thisupload = $(this);
          if( (countFiles + number_upload) > 50){
          	 alert('Bạn đã upload vượt quá số lượng ảnh. Vui lòng nâng cấp tài khoản !');
          	 clearojb(_thisupload);
          	 return false;
          }
          if(countFiles > 0){
              html = html.repeat(countFiles);
              if($("#history_image .grid-photo .item-folder-last").length > 0){
                 $("#history_image .grid-photo .item-folder-last").after(html);
              }
              else{
                $("#history_image .grid-photo .box-upload-image").after(html);
              }
              $(this).parents("#_upload").ajaxSubmit({
                  beforeSubmit:function(){},
                  dataType:"json",
                  success: function(data){   
                      console.log(data);
                      if(data['status']=='success'){
                      	   number_upload = data['number_upload'];
                      	   //console.log(number_upload);
                           var loop_query = _thisupload.parents("#history_image").find(".grid-photo img.default");
                           var i = 0;
                           $.each(loop_query,function(key,value){
                              if(typeof data['response'][i] !== 'undefined'){
	                                $(this).attr("src",base_url + data['response'][i]['path_file_crop']).removeClass("default").addClass('hidden').attr("data-id",data['response'][i]["photo_id"]).attr("alt",data['response'][i]["alt"]).attr("id","success");
	                              	$(this).parent().find('.bg-item-image').css('background-image','url("' + data['response'][i]['path_file_crop']+ '")').removeClass('hidden');
	                              	$(this).parent().attr('data-id',data['response'][i]["photo_id"]);
	                              	var action ='<div class="action-image">';
	                              		action+='  <a class="crop" href="#" data-id="'+data['response'][i]["photo_id"]+'"><i class="fa fa-crop"></i></a>';
	                              		action+='  <a class="edit" href="#" data-id="'+data['response'][i]["photo_id"]+'"><i class="fa fa-pencil"></i></a>';
	                              		action+='  <a class="delete" href="#" data-id="'+data['response'][i]["photo_id"]+'"><i class="fa fa-times"></i></a>';
	                              		action+='</div>';
	                              	$(this).parent().append(action);
                              }
                              else{
                                	$(this).remove();
                              }
                              i++;
                              $(this).removeClass('default-upload');
                              $(this).parent().find(".loadding-upload-ajax").remove();
                              
                           });
						   new_image += i;
                           _thisupload.parents("#history_image").find(".item .default").removeClass("default");
                           clearojb(_thisupload);
                      }
                      else if(data['status'] == 'fail'){
                      	var loop_query = _thisupload.parents("#history_image").find(".grid-photo img.default");
                      	$.each(loop_query,function(key,value){
                      		$(this).parent().remove();
                      	});
                      	alert(data['message']);
                      }
                     
                  },
                  error: function(){
                      _thisupload.parents("#wrapp-box").find(".item .default").removeClass("default");
                  }
              });
          }
    });

    function clearojb(ojb) {
        ojb.replaceWith(ojb.clone());
    }


    /*------------------
    //Close modal crop photo
    //------------------*/
    $('#crop-photo-modal').on('hidden.bs.modal', function () {
          if (jcrop_api_photo!=null && typeof jcrop_api_photo != 'undefined') {
              jcrop_api_photo.destroy();
              jcrop_api_photo=null;
          }
          $("#crop-photo-modal").css('z-index','1051');
          $('.modal-backdrop').css('z-index','1040');
          $('body').addClass('modal-open');
          $('#crop-photo-modal #uploadPreview1').attr('src','');
          $('#crop-photo-modal #uploadPreview1').removeAttr('style');
    });

    /*------------------
    //Crop Photo
    //------------------*/
    $("#crop-photo").submit(function(){
          $("#crop-photo-modal .custom-loading").show();
          var data_id=$("#crop-photo-modal #photo_id").val();
          var options = {
            dataType:'json',
            beforeSend: function(){
            },
            uploadProgress: function(event, position, total, percentComplete){
            },
            success: function(data){
                console.log(data);
                if(data['status']=='success'){
                  $('#modal_upload .item[data-id="'+data_id+'"]').find('.image-item').attr('src',data['path_file']);
                  $('#modal_upload .item[data-id="'+data_id+'"]').find('.bg-item-image').css('background-image','url("'+data['path_file']+'")');
                  $('#crop-photo-modal').modal('toggle');
                }
            },
            complete: function(response){
              $("#crop-photo-modal .custom-loading").hide();
            },
            error: function(){
              //alert('error');
            }
        }; 
        $(this).ajaxSubmit(options);
        return false;
    });

    var setInfo_photo = function(c) {
        $("#crop-photo-modal #x").val(c.x);
        $("#crop-photo-modal #y").val(c.y);
        $("#crop-photo-modal #w").val(c.w);
        $("#crop-photo-modal #h").val(c.h);
        $('#crop-photo-modal #image_w').val($('#crop-photo-modal .jcrop-holder').width());
        $('#crop-photo-modal #image_h').val($('#crop-photo-modal .jcrop-holder').height());
        $("#crop-photo-modal #btnSaveView2").removeAttr('disabled');
    }

    var clearCoords_photo = function(){
        $("#crop-photo-modal #btnSaveView2").attr('disabled','disabled');
    }


  /*-----------------
  // Show model add folder
  /*------------------*/
  $('#folder-modal').on('show.bs.modal', function () {
	  $("#folder-modal").css('z-index','1056');
      $('.modal-backdrop').css('z-index','1055');
      $('#folder-modal .alert-danger').hide();
      $('#folder-modal input[name="title"]').val('');
      $('#folder-modal input[name="title"]').removeClass('warning');
  });

  /*------------------
  //Close modal add folder
  //------------------*/
  $('#folder-modal').on('hidden.bs.modal', function () {
	    $("#folder-modal").css('z-index','1051');
	    $('.modal-backdrop').css('z-index','1040');
	    $('body').addClass('modal-open');
  });

  /*------------------
  //Close modal edit info image
  //------------------*/
  $('#image-edit-info-modal').on('hidden.bs.modal', function () {
      $("#image-edit-info-modal").css('z-index','1051');
      $('.modal-backdrop').css('z-index','1040');
      $('body').addClass('modal-open');
  });

  /*------------------
  //Modal Add folder
  //------------------*/
  $(document).on('click','.tree-folder .action-folder .add', function () {
        var data_id = $(this).parents('.action-folder').parent().attr('data-id');
        $("#folder-modal #folder_id").val(data_id);
        $("#folder-modal").modal('show');
  });

  /*------------------
  //Modal Edit folder
  //------------------*/
  $(document).on('click','.tree-folder .action-folder .rename', function () {
        var data_id = $(this).parents('.action-folder').parent().attr('data-id');
        var parent_folder_id = $(this).parents('.action-folder').parent().parent().parent().attr('data-id');
        var name = $(this).parents('.action-folder').parent().find('.name').text();
        $("#folder-edit-modal input[name='title']").val(name);
        $("#folder-edit-modal #folder_id").val(data_id);
        $("#folder-edit-modal #parent_folder_id").val(parent_folder_id);
        $("#folder-edit-modal").modal('show');
  });

  /*-----------------
  // Show model edit folder
  /*------------------*/
  $('#folder-edit-modal').on('show.bs.modal', function () {
	    $("#folder-edit-modal").css('z-index','1056');
	    $('.modal-backdrop').css('z-index','1055');
	    $('#folder-edit-modal .alert-danger').hide();
	    $('#folder-edit-modal input[name="title"]').removeClass('warning');
  });
	
  /*------------------
  //Close modal edit folder
  //------------------*/
  $('#folder-edit-modal').on('hidden.bs.modal', function () {
	    $("#folder-edit-modal").css('z-index','1051');
	    $('.modal-backdrop').css('z-index','1040');
	    $('body').addClass('modal-open');
  });

  /*------------------
  //Delete folder
  //------------------*/
  $(document).on('click','.tree-folder .action-folder .delete', function () {
        var data_id = $(this).parents('.action-folder').parent().attr('data-id');
        if(confirm("Bạn có muốn xóa thư mục này không?")){
            $.ajax({
                url  : base_url+"medias/delete_folder/"+data_id,
                type : "post",
                dataType:'json',
                data : {},
                success : function(data) {
                  if(data['status']=='success'){
                    $('.tree-folder li[data-id="'+data_id+'"]').remove();
                    paging = 0;
                    new_image = 0;
                    get_photo(0);
                  }
                },
                complete:function(){
                    
                }
            });
        }
  });

  /*------------
  // Add folder
  /*------------*/
  $("#add-folder").submit(function(){
    	var name = $(this).find('input[name="title"]').val();
        var folder_id = $(this).find('#folder_id').val();
    	  if($.trim(name) == '' || $.trim(name) == null){
    	  	  $(this).find('input[name="title"]').addClass('warning');
    	  	  return false;
    	  }
    	  else{
    	  	  $(this).find('input[name="title"]').removeClass('warning');
    	  }
        $("#folder-modal #loading-add-folder").show();
        var current = $(this);
        current.find('#btnSaveView3').attr('disabled','disabled');
        var options = {
            dataType:'json',
            beforeSend: function(){
            },
            uploadProgress: function(event, position, total, percentComplete){
            },
            success: function(data){
                console.log(data);
                if(data['status']=='success'){
                   $('#folder-modal').modal('toggle');
                   var li = $('.tree-folder li[data-id="'+folder_id+'"]');
                   var li_drow = $('#modal_upload .dropdown-menu li[data-id="'+folder_id+'"]');
                   var html  = '<li data-id="'+data['folder_id']+'">';
                       html += '  <i class="fa-folder-open-o fa"></i>  <span class="name">'+name+'</span>';
                       html += '  <div class="action-folder">';
                       html += '    <p><a title="Thêm thư mục" class="add" href="#"><i class="fa fa-plus"></i> Thêm thư mục</a></p>';
                       html += '    <p><a title="Chỉnh sữa thư mục" class="rename"><img src="'+base_url+'skins/images/edit.png"> Sữa tên thư mục</a></p>';
                       html += '    <p><a title="Xóa thư mục" class="delete"><img src="'+base_url+'skins/images/cross.png"> Xóa thư mục</a></p>';
                       html += '  </div>';
                       html += '</li>';
                   if(li.find('> ul').length > 0){
                      li.find('> ul').append(html);
                      li_drow.find('> ul').append(html);
                   }
                   else{
                      li.prepend('<span class="toggle"><i class="fa fa-caret-down"></i></span>');
                      li.append('<ul>'+html+'</ul>');
                      li.addClass('sub-folder');
                      li_drow.append('<ul>'+html+'</ul>');
                   }
                }
                else if(data['status'] == 'fail'){
                	$('#folder-modal .alert-danger p').text(data['message']);
                	$('#folder-modal .alert-danger').show();
                }
            },
            complete: function(response){
              $("#folder-modal #loading-add-folder").hide();
              current.find('#btnSaveView3').removeAttr('disabled');
            },
            error: function(){
              //alert('error');
            }
        }; 
        $(this).ajaxSubmit(options);
        return false;
  });

  /*------------
  // Edit folder
  /*------------*/
  $("#edit-folder").submit(function(){
    	var name = $(this).find('input[name="title"]').val();
      	var folder_id = $(this).find('#folder_id').val();
    	if($.trim(name) == '' || $.trim(name) == null){
    	  	$(this).find('input[name="title"]').addClass('warning');
    	  	return false;
    	}
    	else{
    	  	$(this).find('input[name="title"]').removeClass('warning');
    	}
        $("#folder-edit-modal #loading-add-folder").show();
        var current = $(this);
        current.find('#btnSaveView4').attr('disabled','disabled');
        var options = {
            dataType:'json',
            beforeSend: function(){
            },
            uploadProgress: function(event, position, total, percentComplete){
            },
            success: function(data){
                //console.log(data);
                if(data['status']=='success'){
                   $('#folder-edit-modal').modal('toggle');
                   var li = $('.tree-folder li[data-id="'+folder_id+'"]');
                   var li_drow = $('#modal_upload .dropdown-menu li[data-id="'+folder_id+'"]');
                   li.find('> .name').text(name);
                   li_drow.find('> .name').text(name);
                   $('#modal_upload .nav-tabs .dropdown-toggle .drow-text').text(name);
                   paging = 0;
        		   new_image = 0;
        		   get_photo(0);
                }
                else if(data['status'] == 'fail'){
                	$('#folder-edit-modal .alert-danger p').text(data['message']);
                	$('#folder-edit-modal .alert-danger').show();
                }
            },
            complete: function(response){
              $("#folder-edit-modal #loading-add-folder").hide();
              current.find('#btnSaveView4').removeAttr('disabled');
            },
            error: function(){
              //alert('error');
            }
        }; 
        $(this).ajaxSubmit(options);
        return false;
  });
  
  /*-----------------
  // Toggle tree
  /*-----------------*/
  $(document).on('click','.tree-folder .sub-folder .toggle',function(){
     if($(this).parent().hasClass('closes')){
        $(this).parent().find('> ul').show();
        $(this).parent().removeClass('closes');
        $(this).find('i').removeClass('fa-caret-left').addClass('fa-caret-down');
     }
     else{
        $(this).parent().find('> ul').hide();
        $(this).parent().addClass('closes');
        $(this).find('i').removeClass('fa-caret-down').addClass('fa-caret-left');
     }
     return false;
  });

  /*---------------
  // Click right event folder
  /*-------------------*/
  $(document).on("contextmenu",".tree-folder li",function(e){
      $(".tree-folder li").removeClass('opens');
      $(this).addClass('opens');
      return false;
  });

  $(document).on("click","#modal_upload .tree-folder li > .name, #modal_upload .dropdown-menu li > .name",function(e){
      $('#modal_upload form.form-search-media #search-term').val('');
      $('.tree-folder li').removeClass('current');
      var folder_id = $(this).parent().attr('data-id');
      var folder_parent_id = 0;
      if($(this).parent().parent().parent().attr('data-id')!=null){
      	 folder_parent_id = $(this).parent().parent().parent().attr('data-id');
      }
      $("#modal_upload #_upload #folder_id").val(folder_id);
      $(this).parent().parents('li').each(function(i){
         $(this).addClass('current');
      });
      $(this).parent().addClass('current');
      /*get photo*/
      $("#modal_upload .grid-photo .item").not('.defaul').each(function(){
          $(this).remove();
      });
      $('#modal_upload .list-action a').attr('data-id',folder_id);
      $('#modal_upload .list-action a').attr('parent-data-id',folder_parent_id);
      $('#modal_upload .list-action,#modal_upload .list-action a').show();
      if(folder_id == 0){
         $('#modal_upload .list-action a.edit').hide();
         $('#modal_upload .list-action a.delete').hide();
      }
      $('#modal_upload .nav-tabs .dropdown-toggle .drow-text').text($(this).text());
      paging = 0;
      new_image = 0;
      get_photo(folder_id);
  });

  $(document).on("click","#modal_upload .grid-photo .wrap-folder",function(e){
      $('#modal_upload form.form-search-media #search-term').val('');
      var folder_id = $(this).parent().attr('folder-id');
      $("#modal_upload #_upload #folder_id").val(folder_id);
      /*get photo*/
      $("#modal_upload .grid-photo .item").not('.defaul').each(function(){
          $(this).remove();
      });
      paging = 0;
      new_image = 0;
      get_photo(folder_id);
      return false;
  });

  $(document).on("click","body,html",function(e){
     $(".tree-folder li").removeClass('opens');
  });

  /*Action Mobile*/


  /*------------------
  //Delete folder
  //------------------*/
  $(document).on('click','#modal_upload .list-action .delete', function () {
        var data_id = $(this).attr('data-id');
        if(confirm("Bạn có muốn xóa thư mục này không?")){
            $.ajax({
                url  : base_url+"medias/delete_folder/"+data_id,
                type : "post",
                dataType:'json',
                data : {},
                success : function(data) {
                  if(data['status']=='success'){
                    $('.tree-folder li[data-id="'+data_id+'"]').remove();
                    $('.dropdown-menu li[data-id="'+data_id+'"]').remove();
                    paging = 0;
                    new_image = 0;
                    get_photo(0);
                  }
                },
                complete:function(){
                    
                }
            });
        }
        return false;
  });

  /*------------------
  //Add folder
  //------------------*/
  $(document).on('click','#modal_upload .list-action .add', function () {
        var data_id = $(this).attr('parent-data-id');
        $("#folder-modal #folder_id").val(data_id);
        $("#folder-modal").modal('show');
        return false;
  });

  /*------------------
  //Edit folder
  //------------------*/
  $(document).on('click','#modal_upload .list-action .edit', function () {
        var data_id = $(this).attr('data-id');
        var parent_data_id = $(this).attr('parent-data-id');
        var name = $('.dropdown-menu li[data-id="'+data_id+'"]').find('> .name').text();
        $("#folder-edit-modal input[name='title']").val(name);
        $("#folder-edit-modal #folder_id").val(data_id);
        $("#folder-edit-modal #parent_folder_id").val(parent_folder_id);
        $("#folder-edit-modal").modal('show');
        return false;
  });
  /*------------------
  //Form search submit
  //------------------*/
  $('#modal_upload form.form-search-media').submit(function(){
      $("#modal_upload .grid-photo .item").not('.defaul').each(function(){
       	 $(this).remove();
      });
      $(this).addClass('submit');
      var folder_id = $("#modal_upload #_upload #folder_id").val();
      paging = 0;
      new_image = 0;
      get_photo(folder_id);
  	  return false;
  });

  /*------------------
  //Set heigth content
  //------------------*/
  function set_height_content(){
      var height = $(window).height();
      var height_header = $('#modal_upload .modal-header').outerHeight();
      var height_footer = $('#modal_upload .modal-footer').outerHeight();
      $('#modal_upload .modal-dialog').outerHeight(height);
      var content_height = height - height_header - height_footer;
      var nav_tabs_height = $('#modal_upload .modal-body .nav-tabs').outerHeight();
      var search_height = 0;//$('#modal_upload .modal-body #search-images').outerHeight();
      if($(window).width() <= 768){
          search_height = 50;
      }
      $('#modal_upload .modal-body').outerHeight(content_height);
      $('#modal_upload .modal-body #history_image').outerHeight(content_height - nav_tabs_height - search_height - 15);
      $('#modal_upload .modal-body .tree-folder').outerHeight(content_height - nav_tabs_height - search_height - 15);
  }
  $(window).load(function(){
      set_height_content();
  });
});

/*------------------
// Get Photo
//------------------*/
var get_photo = function(folder_id) {
    $('#modal_upload .box-upload-image').show();
    $('#modal_upload #history_image #loading-custom').show();
    var data = {
        'paging' : paging,
        'new_image' : new_image,
        'folder_id' : folder_id
    };
    var keyword = $('#modal_upload form.form-search-media #search-term').val();
    if($('#modal_upload form.form-search-media').hasClass('submit') && $.trim(keyword)!=null && $.trim(keyword) != ''){
    	$('#modal_upload .box-upload-image').hide();
    	data = {
	        'paging' : paging,
	        'new_image' : new_image,
	        'folder_id' : folder_id,
	        'keyword' : keyword
	    };
    }
    isAjax=false;
    $.ajax({
        url  : base_url+"medias/get_my_photo",
        type : "post",
        dataType:'json',
        data : data,
        success : function(data) {
            //console.log(data);
            if(data['status']=='success'){
                total_media = data['total'];
                number_upload = data['number_upload'];
                //console.log(total_media);
                var html = '';
                for(var i=0; i < data['folder'].length; i++){
                    var last = '';
                    if(i == data['folder'].length-1){ last = 'item-folder-last'; }
                    html +='<div class="col-xs-4 col-sm-3 col-md-2 '+last+' item relative" folder-id="'+data['folder'][i]['id']+'">';
                    html +='  <div class="wrap-folder"><a href="#"><i class="fa-folder-open-o fa"></i><br>'+data['folder'][i]['name']+'</a></div>';
                    html +='</div>';
                }

                for(var i=0; i < data['response'].length; i++){
                    html +='<div class="col-xs-4 col-sm-3 col-md-2 item relative" data-id="'+data['response'][i]['id']+'">';
                    html +='  <div class="action-image">';
                    html +='      <a class="crop" href="#" data-id="'+data['response'][i]['id']+'"><i class="fa fa-crop"></i></a>';     
                    html +='      <a class="edit" href="#" data-id="'+data['response'][i]['id']+'"><i class="fa fa-pencil"></i></a>';
                    html +='      <a class="delete" href="#" data-id="'+data['response'][i]['id']+'"><i class="fa fa-times"></i></a>';    
                    html +='  </div>';
                    html +='  <div class="bg-item-image" style="background-image:url(\''+data['response'][i]['path_file']+'\')"></div>';
                    html +='  <div class="check-image"><img src="'+base_url+'skins/images/check-upload.jpg"></div>';
                    html +='  <img class="image-item hidden" src = "'+data['response'][i]['path_file']+'">';
                    html +='</div>';
                }
                isAjax=true;
                //$('#modal_upload .grid-photo').prepend(html);
                $('#modal_upload .grid-photo').append(html);
                paging++;
            }
        },
        complete:function(){
          $('#modal_upload #history_image #loading-custom').hide();
        }
    });
    return false;
}
/*------------------
//Show model featured
//------------------*/
var choose_featured = function(){
    $("#modal_upload").modal('show');
    $("#modal_upload .grid-photo").addClass('featured');
    $("#modal_upload .grid-photo .item").not('.defaul').each(function(){
        $(this).remove();
    });
    $(".tree-folder li").removeClass('current');
    paging = 0;
    new_image = 0;
    get_photo(0);
}

/*-----------------
//Choose gallery
//-----------------*/
var choose_gallery = function(obj){
    $("#modal_upload").modal('show');
    $("#modal_upload .grid-photo").addClass('gallery');
    $("#modal_upload .grid-photo .item").not('.defaul').each(function(){
        $(this).remove();
    });
    $(".tree-folder li").removeClass('current');
    paging = 0;
    new_image = 0;
    get_photo(0);
}