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
//delete menu item
$(document).on('click', '.delete-menu', function () {
    var li_current = $(this).parent('.ns-actions').parent('.ns-row').parent('.sortable');
    var id = li_current.find('#menu_id').val();
    if (confirm('Do you delete menu item?')) {
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/menu/delete_menu_item/' + id,
            data: {},
            success: function (data) {
                if (data.trim() == 'true') {
                    li_current.fadeOut(800, function () {
                        $(this).remove();
                    });
                }
            }
        });
    }
    return false;
});

//edit menu item
$(document).on('click', '.edit-menu', function () {
    // var li_current = $(this).parent('.ns-actions').parent('.ns-row').parent('.sortable');
    var id = $(this).attr('data-id');// li_current.find('#menu_id').val();
    $('#edit-id').val(id);
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: base_url + "admin/menu/get_item_menu/" + id,
        data: {},
        success: function (data) {
            //console.log(data);
            if (data['status'] == 'success') {
                $('#edit-title').val(data.title);
                $('#edit-url').val(data.url);
                $('#edit-class').val(data.class);
                if (data['target'] == "blank") {
                    $("#target-add").attr('checked', true);
                } else {
                    $("#target-add").removeAttr('checked');
                }
            }
        }
    });
});


//Get category
$(document).on('click', '.list-item .category-type', function () {
    var type_id = $(this).attr('type-id');
    var status = $(this).attr('status');
    var current = $(this);
    if (status == 'on') {
        $.ajax({
            type: 'POST',
            url: base_url + "admin/menu/get_category/",
            data: {"id": type_id},
            success: function (data) {
                if (data != 'error') {
                    current.parent().append(data);
                }
            },
            complete: function () {
                current.attr('status', 'off');
            }
        });
    }
    return false;
});

//Add list menu
$(document).on('click', '.box .add-menu-list', function () {
    var current = $(this).parents('.box').find('form');
    if (current.find('input[type="checkbox"]:checked').length > 0) {
        var data = current.serialize();
        current.parents('.box').find('.image-load').show();
        current.parents('.box').find('.add-menu-list').attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: base_url + "admin/menu/add_menu_list/",
            data: data,
            success: function (data) {
                if (data['status'] == 'success') {
                    for (var i = 0; i < data['reponse'].length; i++) {
                        var html = '<li id="menu-' + parseInt(data['reponse'][i]['id']) + '" class="sortable">';
                        html += '	      <div class="ns-row">';
                        html += '            <div class="ns-title">' + data['reponse'][i]['title'] + '</div>';
                        html += '            <div class="ns-url">' + data['reponse'][i]['url'] + '</div>';
                        html += '            <div class="ns-class"></div>';
                        html += '            <div class="ns-actions">';
                        html += '               <a href="#" class="edit-menu" data-toggle="modal" data-target="#editModal" title="Edit Menu"><img src="' + base_url + '/skins/images/edit.png" alt="Edit"></a>';
                        html += '               <a href="#" class="delete-menu"><img src="' + base_url + '/skins/images/cross.png" alt="Delete"></a>';
                        html += ' 			  <a href="#" class="slider-menu"><i class="fa fa-chevron-down"></i></a>';
                        html += '               <input type="hidden" id="menu_id" name="menu_id" value="' + parseInt(data['reponse'][i]['id']) + '">';
                        html += '            </div>';
                        html += '         </div>';
                        html += '	  </li>';
                        $('#easymm').append(html).SortableAddItem($('#menu-' + parseInt(data['reponse'][i]['id']))[0]);
                    }
                }
            },
            complete: function () {
                current.parents('.box').find('.image-load').hide();
                current.parents('.box').find('.add-menu-list').removeAttr('disabled');
                current.find('input[type="checkbox"]').removeAttr('checked');
            }
        });
    }
    return false;
});

//add menu item
$(document).on('click', '#add-menu', function () {
    var title = $('#add-title').val();
    var url = $('#add-url').val();
    var clas = $('#add-class').val();
    var bool = true;
    var target = 'inner';

    if ($("#target").is(":checked")) {
        target = 'blank';
    }
    if (title.trim() == '' || title.trim() == null) {
        bool = false;
        $('#add-title').addClass('border-error');
    } else {
        $('#add-title').removeClass('border-error');
    }

    if (url.trim() == '' || url.trim() == null) {
        bool = false;
        $('#add-url').addClass('border-error');
    } else {
        $('#add-url').removeClass('border-error');
    }

    if (bool) {
        $('#form-add-menu .image-load').show();
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: base_url + '/admin/menu/add_item_menu/',
            data: {"title": title, "url": url, "class": clas, "target": target, "group_id": group_id},
            dataType: 'json',
            success: function (data) {
                if (data['status'] == 'success') {
                    var html = '<li id="menu-' + parseInt(data['id']) + '" class="sortable">';
                    html += '	      <div class="ns-row">';
                    html += '            <div class="ns-title">' + title + '</div>';
                    html += '            <div class="ns-url">' + url + '</div>';
                    html += '            <div class="ns-class">' + clas + '</div>';
                    html += '            <div class="ns-actions">';
                    html += '               <a href="#" class="edit-menu" data-toggle="modal" data-target="#editModal" title="Edit Menu"><img src="/skins/images/edit.png" alt="Edit"></a>';
                    html += '               <a href="#" class="delete-menu"><img src="/skins/images/cross.png" alt="Delete"></a>';
                    html += ' 			  <a href="#" class="slider-menu"><i class="fa fa-chevron-down"></i></a>';
                    html += '               <input type="hidden" id="menu_id" name="menu_id" value="' + parseInt(data['id']) + '">';
                    html += '            </div>';
                    html += '         </div>';
                    html += '	  </li>';
                    $('#easymm').append(html).SortableAddItem($('#menu-' + parseInt(data['id']))[0]);
                    $('#add-title').val('');
                    $('#add-url').val('');
                    $('#add-class').val('');
                    $("#target").removeAttr('checked');
                }
            },
            complete: function () {
                $('#add-menu').removeAttr('disabled');
                $('#form-add-menu .image-load').hide();
            }
        });
    }
});

//save edit menu
$(document).on('click', '.btn-edit', function () {
    var title = $('#edit-title').val();
    var url = $('#edit-url').val();
    var clas = $('#edit-class').val();
    var id = $('#edit-id').val();
    var bool = true;
    var target = 'inner';

    if ($("#target-add").is(":checked")) {
        target = 'blank';
    }

    if (title.trim() == '' || title.trim() == null) {
        bool = false;
        $('#edit-title').addClass('border-error');
    } else {
        $('#edit-title').removeClass('border-error');
    }

    if (url.trim() == '' || url.trim() == null) {
        bool = false;
        $('#edit-url').addClass('border-error');
    } else {
        $('#edit-url').removeClass('border-error');
    }

    if (bool) {
        $('#editModal .image-load').show();
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/menu/update_item_menu/' + id,
            data: {"title": title, "url": url, "class": clas, 'target': target},
            success: function (data) {
                var li = $('#menu-' + id + ' .ns-row');
                $('#menu-' + id + ' > .ns-row .ns-title').html(title);
                $('#menu-' + id + ' > .ns-row .ns-url').html(url);
                $('#menu-' + id + ' > .ns-row .ns-class').html(clas);
                $('#edit-title').val();
                $('#edit-url').val();
                $('#edit-class').val();
            },
            complete: function () {
                $('.btn-edit').removeAttr('disabled');
                $('#editModal .image-load').hide();
                $('#editModal .btn-close').trigger('click');
            }
        });
    }
});

//add group menu
$(document).on('click', '.btn-add-group', function () {
    var name = $("#add-name").val();
    var bool = true;
    if (name.trim() == '' || name.trim() == null) {
        bool = false;
        $("#add-name").addClass('border-error');
    } else {
        $("#add-name").removeClass('border-error');
    }

    if (bool) {
        $('#addModal .image-load').show();
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/menu/add_menu_group/',
            data: {"name": name},
            dataType: 'json',
            success: function (data) {
                if (data['status'] == 'success') {
                    location.href = base_url + "/admin/menu/edit/" + data['id'];
                }
            },
            complete: function () {
                $(".btn-add-group").removeAttr('disabled');
                $('#addModal .image-load').hide();
            }
        });
    }
});