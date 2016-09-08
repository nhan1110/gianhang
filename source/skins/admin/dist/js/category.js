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
    if (confirm('Do you delete menu item?')) {
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/category/delete_category_item/' + id,
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
    // var id = li_current.find('#menu_id').val();
    // var li_current = $(this).parent('.ns-actions').parent('.ns-row').parent('.sortable');
    var id = $(this).attr('data-id');// li_current.find('#menu_id').val();
    $('#edit-id').val(id);
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: base_url + "admin/category/get_item_category/" + id,
        data: {},
        success: function (data) {
            if (data['status'] == 'success') {
                $('#edit-title').val(data['name']);
            }
        }
    });
});

//add menu item
$(document).on('click', '#add-menu', function () {
    var title = $('#add-title').val();
    var bool = true;

    if (title.trim() == '' || title.trim() == null) {
        bool = false;
        $('#add-title').addClass('border-error');
    } else {
        $('#add-title').removeClass('border-error');
    }


    if (bool) {
        $('#form-add-menu .image-load').show();
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: base_url + '/admin/category/add_item_category/',
            data: {"name": title, "group_id": group_id},
            dataType: 'json',
            success: function (data) {
                if (data['status'] == 'success') {
                    var html = '<li id="menu-' + parseInt(data['id']) + '" class="sortable">';
                    html += '	      <div class="ns-row">';
                    html += '            <div class="ns-title">' + title + '</div>';
                    html += '            <div class="ns-url">' + data['slug'] + '</div>';
                    html += '            <div class="ns-class"></div>';
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
    var id = $('#edit-id').val();
    var bool = true;

    if (title.trim() == '' || title.trim() == null) {
        bool = false;
        $('#edit-title').addClass('border-error');
    } else {
        $('#edit-title').removeClass('border-error');
    }

    if (bool) {
        $('#editModal .image-load').show();
        $(this).attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/category/update_item_category/' + id,
            data: {"name": title},
            success: function (data) {
                var li = $('#menu-' + id + ' .ns-row');
                $('#menu-' + id + ' > .ns-row .ns-title').html(title);
                $('#edit-title').val();
            },
            complete: function () {
                $('.btn-edit').removeAttr('disabled');
                $('#editModal .image-load').hide();
                $('#editModal .btn-close').trigger('click');
            }
        });
    }
});

//add Type
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
            url: base_url + 'admin/category/add_type_group/',
            data: {"name": name},
            dataType: 'json',
            success: function (data) {
                if (data['status'] == 'success') {
                    location.href = base_url + "/admin/category/edit/" + data['id'];
                }
            },
            complete: function () {
                $(".btn-add-group").removeAttr('disabled');
                $('#addModal .image-load').hide();
            }
        });
    }
});