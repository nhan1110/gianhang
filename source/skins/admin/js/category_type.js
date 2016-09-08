var _id_single ;
$(document).ready(function(){
	$("#category-type-page #save-cattype-group").click(function(){
		_this = $(this);
		var name_ct = $("#name-cattype-group").val();
		var parent_id = $("#root-category-type").val();
		if(name_ct.trim() != "" && _reset == 0){
			_reset  = 1;
			_this.append(loading());
			var options = { 
	            beforeSend: function(){
	            },
	            dataType:'json',
	            uploadProgress: function(event, position, total, percentComplete){
	            },
	            success: function(data){      	
	                if(data["success"] == "success"){
						var response = data["response"];
						var html_insert = "";
						html_insert+='<li class="item ui-state-default ui-sortable-handle" data-id="'+response["ID"]+'" data-slug="'+response["Slug"]+'" data-sort="0">';
						    html_insert+='<div class="list-group-item"><span id="name-attribute">'+response["Name"]+'</span>';
						        html_insert+='<div class="actions">';
					        		html_insert+='<a data-type="attribute-group" data-id="'+response["ID"]+'" data-src=\''+response["Images"]+'\' data-icon=\''+response["Icon"]+'\' id="action-edit-cattype" href="#"><span aria-hidden="true" class="glyphicon glyphicon-edit"></span></a>';
					            	html_insert+='<a href="'+base_url+"admin/categories_type/disable/"+response["ID"]+'" id="action-disable" data-type="disable"><i class="fa fa-lock"></i></a>';
					            	html_insert+='<a href="'+base_url+"admin/categories_type/delete/"+response["ID"]+'" id="action-delete" data-type="delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
					            	html_insert+='</div>';
					            	if(response['Parent_ID'] == 0){
					     		    	html_insert+='<div class="more close"><i class="fa fa-caret-down"></i></div>';
					    			}
						    html_insert+='</div>';
						    html_insert+='<ul class="list-group droptrue level-0 ui-sortable" data-level="0" data-id="'+response["ID"]+'"><input type="hidden" id="sort_get" value="" data-type="attribute-group-attribute" class="ui-sortable-handle"></ul>';
						html_insert+='</li>';
						$("#box-tree-category-type ul[data-id = "+response['Parent_ID']+"] ").append(html_insert);
						if(response['Parent_ID'] == 0){
							var add_select = "<option class='level-0' data-space='0' value='"+response["ID"]+"' >"+response['Name']+"</option>";
							$("#root-category-type").append(add_select);
						}
					}
					_reset = 0;
					remove_loadding(_this);
	            },
	            complete: function(response){
	            	$("#name-cattype-group").val('');
	            	$("#root-category-type").val(0);
	            	$('.form-add-category-type input[name="images"]').val("");
	            },
	            error: function(error){
	            	console.log(error);
	              	_reset = 0;
					alert("error");
					remove_loadding(_this);
	            }
	        }; 
	        $('.form-add-category-type').ajaxSubmit(options);
		}
		return false;
	});
});
$(document).on("click", "#box-tree-category-type #action-delete", function (e) {
	$("#modal_delete .modal-title").html("Xóa !!!");
    _this = $(this).parents(".list-group-item").parent();
    action_delete($(this).attr("href"),_this,true);
    return false;
});
$(document).on("click", "#box-tree-category-type #action-disable", function (e) {
	_action = $(this).data("type");
    _this = $(this).parents(".list-group-item").parent();
    $("#modal_delete .modal-title").html("Ẩn !!!");
    action_delete($(this).attr("href"),_this);
    return false;
});
$(document).on("click","#box-tree-category-type #action-edit-cattype",function(event){
	event.stopPropagation();
	$("#modal_edit_cat_type #name-cat").removeClass("warning");
	_this = $(this);
	var name_ct = $(this).parent().parent().find("#name-attribute").text();
	var images_src =  $(this).attr('data-src');
	var icon =  $(this).attr('data-icon');
	var id = $(this).data("id");
	_id_single = id;
	if(id != "" && _reset == 0){
		$.ajax({
			url: base_url + "admin/categories_type/show",
			type:"post",
			dataType:"json",
			data:{id:id},
			success:function(data){ 
				console.log(data);
				var html = "";
				var not_show_g = "";
				var not_show_a = "";
				if(Object.keys(data).length > 0){					
					$.each(data,function(key,value){
						if(jQuery.isEmptyObject(value["Not_Show"]))
							not_show_g = "checked";
						else
							not_show_g = "";
						html += '<ul class="attribute_group_not_show_cattype">';
							html +='<li><div class="checkbox"><input class ="root-attribute-click" type="checkbox" id="not_show-'+value["Slug"]+'" data-type="group" class="custom" value="'+value["ID"]+'" '+not_show_g+'><label for="not_show-'+value["Slug"]+'"><span>'+value["Name"]+'<span></span></span></label></div>';
								html +='<ul class="attribute_not_show_cattype">';
									$.each(value["Attribute"],function(key,value_1){
										if(jQuery.isEmptyObject(value_1["Not_Show"]))
											not_show_a = "checked";
										else
											not_show_a = "";
										html +='<li><div class="checkbox"><input type="checkbox" id="not_show-'+value_1["Slug"]+'" data-type="attribute" class="custom" value="'+value_1["ID"]+'" '+not_show_a+'><label for="not_show-'+value_1["Slug"]+'"><span>'+value_1["Name"]+'<span></span></span></label></div></li>';
									});
								html +='</ul>';
							html +='</li>';
						html += '</ul>';
					});	
				}
				$("#modal_edit_cat_type #list-gr-attr").html(html);
				$("#modal_edit_cat_type #name-cat").val(name_ct);
				$("#modal_edit_cat_type #icon").val(icon);
				if(images_src!=''){
					$("#modal_edit_cat_type .images-view").attr('src',base_url + images_src).show();
				}
				else{
					$("#modal_edit_cat_type .images-view").hide();
				}
				$("#modal_edit_cat_type").modal();
			},
			error:function(){
				alert("error");
			}
		})
	}
	
	return false;
});
$(document).on("click","#modal_edit_cat_type .root-attribute-click",function(){
 if($(this).is(':checked')){
 	$.each($(this).parents("li").find("li input[type = checkbox]"),function(){
 		$(this).prop( "checked", true );
 	})
 }else{
 	$.each($(this).parents("li").find("li input[type = checkbox]"),function(){
 		$(this).prop( "checked", false );
 	})
 }
});
$(document).on("click","#modal_edit_cat_type .attribute_not_show_cattype input[type = checkbox]",function(){
	var check_input = 0;
 	$.each($(this).parents(".attribute_not_show_cattype").find("li input[type = checkbox]"),function(){
 		if($(this).is(':checked')){
 			check_input++;
 		}
 	});
 	if(check_input != 0){
 		$(this).parents(".attribute_group_not_show_cattype").find(".root-attribute-click").prop( "checked", true );
 	}
});
$(document).on("click","#modal_edit_cat_type #edit_attribute_set",function(){
	var string_sent_not_show  = "";
	var string_sent_show  = "";
	var text_single = "";
	var name = $("#modal_edit_cat_type #name-cat").val();
	var icon = $("#modal_edit_cat_type #icon").val();
	if(name == ""){
		$("#modal_edit_cat_type #name-cat").addClass("warning");
		return false;
	}
	$.each($(".attribute_group_not_show_cattype li input[type = checkbox]"),function(){
		if($(this).val() != "" && !isNaN($(this).val()))
			text_single = $(this).data("type")+":"+$(this).val();
			if(text_single != ""){
				if(!$(this).is(':checked'))
				string_sent_not_show +=  text_single + ",";
			else
				string_sent_show += text_single + ",";
		        text_single = "";
		}
	});
	var _this_new = $(this);
	_this_new.append(loading());
	var data_form = 'cattype_id=' + encodeURIComponent(_id_single);
	data_form += '&not_show=' + encodeURIComponent(string_sent_not_show);
	data_form += '&show=' + encodeURIComponent(string_sent_show);

	var options = { 
        beforeSend: function(){
        },
        url : base_url + "admin/categories_type/un_set_ag/?"+data_form,
		type: "post",
        dataType:'json',
        uploadProgress: function(event, position, total, percentComplete){
        },
        success: function(data){      	
            console.log(data);
			if(data["success"] == "success"){
				_this.parent().parent().find("#name-attribute").text(name);
				_this.parents('#modal_edit_cat_type').find("input[type='file']").clone();
				$("#action-edit-cattype[data-id='"+_id_single+"']").attr('data-icon',data["icon"]);
				if(data["images"] != null){
					$("#action-edit-cattype[data-id='"+_id_single+"']").attr('data-src',data["images"]);
					$("#modal_edit_cat_type .images-view").attr('src',base_url + data["images"]).show();
				}
				$("#modal_edit_cat_type").modal("hide");
			}
			else{
				alert("error");
			}
			remove_loadding(_this_new);
        },
        error: function(error){
        	alert("error");
			remove_loadding(_this_new);
        }
    }; 
    $('.form-edit-category-type').ajaxSubmit(options);
    return false;
});