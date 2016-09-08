$(document).on('click', '.ns-row .slider-menu', function () {
    var li = $(this).parent().parent().parent();
    var ul = li.children('ul');
    if (li.hasClass('closes')) {
        li.removeClass('closes');
        ul.slideDown('slow');
        $(this).find('i').removeClass('fa-chevron-right').addClass('fa-chevron-down');
    } else {
        li.addClass('closes');
        ul.hide();
        $(this).find('i').removeClass('fa-chevron-down').addClass('fa-chevron-right');
    }
    return false;
});

$(document).on('click', '.sidebar-toggle', function () {
    if ($(window).width() > 768) {
        $('body').toggleClass('sidebar-collapse');
    } else {
        $('body').toggleClass('sidebar-open');
    }
    return false;
});

$(document).on('click', 'a[data-toggle="control-sidebar"]', function () {
    $('.control-sidebar').toggleClass('control-sidebar-open');
    return false;
});

$(document).on('click', '.sidebar-menu li.treeview', function () {
    $(this).toggleClass('active');
    return false;
});
//delete category item
$(document).on('click', '.delete-menu', function () {
    var li_current = $(this).parent('.ns-actions').parent('.ns-row').parent('.sortable');
    var id = li_current.find('#menu_id').val();
	if (li_current.find('ul').length > 0) {
		alert('Please remove child before this item.');
		return false;
	}
    if (confirm('Do you delete menu item?')) {
        $.ajax({
            type: 'POST',
            url: base_admin_url + 'module/delete_action/' + id,
            data: {},
            success: function (data) {
                if (data.trim() == 'true') {
                    li_current.fadeOut(800, function () {
                        $(this).remove();
                    });
	            } else {
		            if (data.trim() == 'child') {
		            	alert('Please remove child before this item.');
						return false;
		            }
	            }
            },
            error : function(data){
                console.log(data);
            }
        });
    }
    return false;
});

//edit menu item
$(document).on('click', '.edit-menu', function () {
    var id = $(this).attr('data-id');
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: base_admin_url + "module/get_item/" + id,
        data: {},
        success: function (data) {
            if (data['status'] == 'success') {
                $('#add-title').val(data['name']);
                $('#add-url').val(data['url']);
                $('#add-key').val(data['key']);
                $('#add-class').val(data['class']);
                $('#select-class').val(data['class']);
                $('#show-class').attr('class', data['class']);
                $('#id').val(id);
            }
        }
    });
});

function check_validate(field) {
	var val = field.val();
	if (typeof(val) === 'undefined' || val == null || val.trim() == '') {
        field.addClass('border-error');
        return false;
    }
    field.removeClass('border-error');
    return true;
}

// Add item
$(document).on('click', '#add-menu', function () {
	var title = $('#add-title').val();
	var url = $('#add-url').val();
	var key = $('#add-key').val();
    var clas = $('#add-class').val();
	var id = $('#id').val();
    var bool = check_validate($('#add-title')) && check_validate($('#add-url')) && check_validate($('#add-key'));
	
    if (bool) {
    	var url_action = base_admin_url + 'module/add_action/';
		var edit = false;
		if (typeof(id) !== 'undefined' && id.trim() != '' && !isNaN(id)) {
			url_action = base_admin_url + 'module/update_action/' + id;
			edit = true;
		}
    	
        $('#form-add-menu .image-load').show();
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: url_action,
            data: {"name": title, "url": url, "key": key ,"class":clas},
            dataType: 'json',
            success: function (data) {
                if (data['status'] == 'success') {
	                if (edit) {
	                	var li = $('#menu-' + id + ' .ns-row');
		                $('#menu-' + id + ' > .ns-row .ns-title').html(title);
		                $('#menu-' + id + ' > .ns-row .ns-url').html(url);
		                $('#menu-' + id + '').attr('data-key',key);
	                } else {
	                    var html = '<li id="menu-' + parseInt(data['id']) + '" data-key="' + data['key'] + '" class="sortable">';
	                    html += '	      <div class="ns-row">';
	                    html += '            <div class="ns-title">' + title + '</div>';
	                    html += '            <div class="ns-url">' + data['url'] + '</div>';
	                    html += '            <div class="ns-class"></div>';
	                    html += '            <div class="ns-actions">';
	                    html += '               <a href="#" class="edit-menu" data-toggle="modal" data-target="#editModal" title="Edit Menu"><i class="fa fa-edit"></i></a>';
	                    html += '               <a href="#" class="delete-menu"><i class="fa fa-close"></i></a>';
	                    html += ' 			  	<a href="#" class="slider-menu"><i class="fa fa-chevron-down"></i></a>';
	                    html += '               <input type="hidden" id="menu_id" name="menu_id" value="' + parseInt(data['id']) + '">';
	                    html += '            </div>';
	                    html += '         </div>';
	                    html += '	  </li>';
	                    $('#easymm').append(html).SortableAddItem($('#menu-' + parseInt(data['id']))[0]);
	                }
                    $('#add-title').val('');
                    $('#add-url').val('');
                    $('#add-key').val('');
                    $('#id').val('');
                    $('#add-class').val('');
                }
            },
            complete: function () {
                $('#add-menu').removeAttr('disabled');
                $('#form-add-menu .image-load').hide();
            }
        });
    }
});
