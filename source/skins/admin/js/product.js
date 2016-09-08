var _type_member = "System";
var data_select = "false";
var width_move = 0;
var offset = 0;
var left_total = 0;
var lenght_element = 0;
var width_set = 0;
var input_clone = '<div class="item relative add-new"> <div class="remove-item">x</div> <div class="form-group"> <input class="default-values form-control not-null" type="text" placeholder="Tên Giá Trị Mặc Định"> </div> </div>';
var category_type = 0;
var name_attribute;
var type_hidden = "";
var _cat_type_id = $("#category_type_id").val();
$(document).ready(function () {
    update_address_product();
    $(this).on("mousedown", "#date-filed", function (e) {
        $(this).datepicker(
                {
                    format: 'yyyy-mm-dd',
                    ignoreReadonly: true
                }
        );
    });
    lenght_element = $("#box-tabs .nav-tabs li").length;
    $("#box-tabs .previous").click(function () {
        if (offset > 0) {
            get_width_move("+");
            offset--;
        }
    });
    $("#box-tabs .next").click(function () {
        if (offset < (lenght_element - 1)) {
            offset++;
            get_width_move("-");
        }
    });
    if ($("#content").length > 0)
    {
        $('#content').summernote({
            height: 300
        });
    }
    $("#startdate,#enddate").datepicker({
        format: 'yyyy-mm-dd',
        startDate: '-3d',
        ignoreReadonly: true
    });
    $.each($("#tree_attr li li "), function () {
        if ($(this).find(" > ul li").length > 0) {
            $(this).find(" > .list-group-item").append("<div class='more close'><i class='fa fa-caret-right'></i></div>");
        }
    });
    $("#product_city").change(function () {
        var id = $(this).val();
        var box_set = $("#product_districts");
        var level = 1;
        $("#product_districts").html('<option value="{[-]}" id="default">- Lựa chọn -</option>');
        $("#product_wards").html('<option value="{[-]}" id="default">- Lựa chọn -</option>');
        update_address_product();
        get_districts_wards(box_set, id, level);
    });
    $("#product_districts").change(function () {
        var id = $(this).val();
        var box_set = $("#product_wards");
        var level = 2;
        $("#product_wards").html('<option value="{[-]}" id="default">- Lựa chọn -</option>');
        update_address_product();
        get_districts_wards(box_set, id, level);
    });
    $("#product_districts_new").keyup(function () {
        update_address_product();
    });
    $("#product_wards").change(function () {
        update_address_product();
    });
});
function get_districts_wards(box_set, id, level) {
    $.ajax({
        url: base_url + "admin/countrys/get_districts",
        type: 'POST',
        dataType: 'json',
        data: {
            "id": id,
            "level": level
        }, success: function (data, textStatus, jqXHR) {
            var html = '';
            if (data.length > 0) {
                html = '<option value="{[-]}" id="default">- Lựa chọn -</option>';
                $.each(data, function (key, value) {
                    html += '<option value="' + value["ID"] + '">' + value["Levels"] + " " + value["Name"] + '</option>';
                });
                box_set.html(html);
            }
            update_address_product();
        }, error: function (jqXHR, textStatus, errorThrown) {
            update_address_product();
        }
    });
}
function update_address_product() {
    var city_value = $("#gruop-address-product #product_city").val();
    var wards_value = $("#gruop-address-product #product_wards").val();
    var districts_value = $("#gruop-address-product #product_districts").val();
    if (city_value !== "" && city_value != "{[-]}") {
        $("#gruop-address-product #product_city_new").prop('disabled', 'disabled');
        $("#gruop-address-product #product_districts").removeAttr("disabled");
        $("#gruop-address-product #product_districts_new").removeAttr("disabled");
        if (districts_value !== "" && districts_value != "{[-]}") {
            $("#gruop-address-product #product_districts_new").val("");
            $("#gruop-address-product #product_districts_new").prop('disabled', 'disabled');
            $("#gruop-address-product #product_wards").removeAttr("disabled");
            $("#gruop-address-product #product_wards_new").removeAttr("disabled");
            if (wards_value !== "" && wards_value != "{[-]}") {
                $("#gruop-address-product #product_wards_new").val("");
                $("#gruop-address-product #product_wards_new").prop('disabled', 'disabled');
            } else {
                var product_wards_new = $("#gruop-address-product #product_wards_new").val();
                if (product_wards_new !== "") {
                    $("#gruop-address-product #product_wards").prop('disabled', 'disabled');
                }
            }
        } else {
            var districts_value_new = $("#gruop-address-product #product_districts_new").val();
            if (districts_value_new !== "") {
                $("#gruop-address-product #product_wards").removeAttr("disabled");
                $("#gruop-address-product #product_wards_new").removeAttr("disabled");
            } else {
                $("#gruop-address-product #product_districts_new").removeAttr("disabled");
                $("#gruop-address-product #product_wards").prop('disabled', 'disabled');
                $("#gruop-address-product #product_wards_new").prop('disabled', 'disabled');
            }
            if (wards_value !== "" && wards_value != "{[-]}") {
                $("#gruop-address-product #product_wards_new").val("");
                $("#gruop-address-product #product_wards_new").prop('disabled', 'disabled');
            }
        }
    } else {
        $("#gruop-address-product #product_districts_new").val("");
        $("#gruop-address-product #product_wards_new").val("");
        $("#gruop-address-product #product_districts_new").prop('disabled', 'disabled');
        $("#gruop-address-product #product_districts").prop('disabled', 'disabled');
        $("#gruop-address-product #product_wards_new").prop('disabled', 'disabled');
        $("#gruop-address-product #product_wards").prop('disabled', 'disabled');
    }
}
$(document).on('keydown', '#add-method', function (e) {
    if (e.which == 13 || e.keyCode == 13) {
        e.preventDefault();
        _this = $(this);
        add_category();
    }
});
$(document).on('click', '#add-button', function () {
    _this = $(this).parents("#wrapp-box").find("#add-method");
    add_category();
    return false;
});
function get_width_move(operater) {
    if (offset > 0 || offset < lenght_element) {
        if (operater == "-") {
            $("#box-tabs .nav-tabs li:nth-child(" + (offset + 1) + ") a").trigger("click");
            width_move = width_move - $("#box-tabs .nav-tabs li:nth-child(" + offset + ")").width();
        }
        if (operater == "+") {
            $("#box-tabs .nav-tabs li:nth-child(" + offset + ") a").trigger("click");
            width_move = width_move + $("#box-tabs .nav-tabs li:nth-child(" + (offset) + ")").width();
        }
        $("#box-tabs .nav-tabs").animate({left: width_move}, 200);
    }
}
function add_category() {
    var title_new_cat = _this.val();
    var pid_catgorty = _this.parents("#wrapp-box").find("#newcategory_parent").val();
    var type = _this.attr("data-add");
    if (typeof pid_catgorty === "undefined") {
        pid_catgorty = 0;
    }
    if (title_new_cat.trim() != "" && _reset == 0) {
        _this.parents("#box-main").find("#add-button").append(loading());
        _reset = 1;
        $.ajax({
            url: base_url + "admin/category/addcategory",
            type: "post",
            dataType: "json",
            data: {
                "name": title_new_cat,
                "pid": pid_catgorty,
                "type": type,
                "cattypeid": catTypeID,
            },
            success: function (data) {
                if (typeof data !== "undefined" && data["id"] != null && data["pid"] != null) {
                    _this.val("");
                    var list_new = '<li><div class="checkbox"><input type="checkbox" value="' + data["id"] + '" name="' + data["type"] + '[]" id="' + data['slug'] + '" checked > <label for ="' + data['slug'] + '"><span>' + data["name"] + '</span></label></div><ul class="list no-list-style box-select" data-id="' + data["id"] + '" id="parent"></ul></li>';
                    _this.parents("#wrapp-box").find("[data-id = " + data["pid"] + "]").append(list_new);
                    if (data["pid"] == 0) {
                        _this.parents("#wrapp-box").find("#newcategory_parent").append('<option class="level-0" data-space="0" value="' + data["id"] + '">' + data["name"] + '</option>');
                    } else {
                        var data_space = parseInt(_this.parents("#wrapp-box").find("#newcategory_parent [value = " + data["pid"] + "]").attr("data-space"));
                        data_space = (data_space + 1);
                        var space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        var string_space = space.repeat(data_space);
                        _this.parents("#wrapp-box").find("#newcategory_parent [value = " + data["pid"] + "]").after('<option class="level-' + (data_space) + '" data-space="' + (data_space) + '" value="' + data["id"] + '">' + string_space + data["name"] + '</option>');
                    }
                } else {
                    alert("error");
                }
                _reset = 0;
                remove_loadding(_this.parents("#box-main").find("#add-button"));
                _this.parents("#box-main").find("#add-button").prop('disabled', 'disabled');
            },
            error: function () {
                _reset = 0;
                alert("error");
                remove_loadding(_this.parents("#box-main").find("#add-button"));
            }

        });
    }
}
$(document).on("keyup", "#srch-term", function () {
    var text_check;
    var matches;
    var val_search = to_slug($(this).val().trim());
    if (val_search.trim() != "") {
        $.each($("ul#category li,ul#category ul li"), function () {
            text_check = $(this).data("slug");
            if (text_check.indexOf(val_search) <= -1) {
                $(this).hide();
            } else {
                $(this).parents("li").show();
                $(this).show();
            }
        });
    } else {
        $.each($("ul#category li,ul#category ul li"), function () {
            $(this).show();
        });
    }
});

$(document).on("keyup", ".box-add-attribute #name-attribute", function () {
    var value_set = $(this).val();
    set_box_add_attribute(value_set, $(this));
});
$(document).on("click", ".box-items .item  .remove-item", function () {
    $(this).parent().remove();
});
$(document).on("click", ".box-default-values #add-item", function (e) {
    e.preventDefault();
    $(this).parents(".box-default-values").find(".box-items").append(input_clone);
    return false;
});
$(document).on("click", "#add-tabs-new", function (e) {
    e.preventDefault();
    _this = $(this);
    _this.parents("#add-new-group-parent-block").find("#name-group").removeClass("warring");
    var name_group = _this.parents("#add-new-group-parent-block").find("#name-group").val();
    var sort = _this.parents("#add-new-group-parent-block").find("#sort").val();
    if (name_group.trim() == "") {
        _this.parents("#add-new-group-parent-block").find("#name-group").addClass("warring");
    } else if (_reset === 0) {
        var data_category = _this.data("category");
        _this.append(loading());
        _reset = 1;
        $.ajax({
            url: base_url + "admin/product/addgroup",
            type: "post",
            dataType: "json",
            data: {
                "data_category": data_category,
                "name": name_group,
                "sort": sort
            },
            success: function (data) {
                _this.parents("#add-new-group-parent-block").find("#name-group").val('');
                if (data["success"].trim() == "success") {
                    _this.parents("#box-tabs-parent").find("ul #control-add-tabs").before('<li class=""><div class="romove" id="romove-attribute" data-type="group"><i class="fa fa-close"></i></div><a data-toggle="tab" href="#' + data["slug"] + '-parent-block">' + data["name"] + '</a></li>');
                    _this.parents("#box-tabs-parent").find("#add-new-group-parent-block").before(add_html_tabs(data["slug"], data["category"]));
                    _this.parents("#box-tabs-parent").find("li a[href = #" + data["slug"] + "-parent-block]").trigger("click");
                    _this.parents("#add-new-group-parent-block").find("#name-group").val("");
                    lenght_element = $("#box-tabs .nav-tabs li").length;
                } else {
                    _this.parents("#box-tabs-parent").find("li a[href = #" + data["slug"] + "-parent-block]").addClass("warring");
                    _this.parents("#box-tabs-parent").find("li a[href = #" + data["slug"] + "-parent-block]").trigger("click");
                    setTimeout(function () {
                        _this.parents("#box-tabs-parent").find("li a[href = #" + data["slug"] + "-parent-block]").removeClass("warring");
                    }, 2000);
                }
                remove_loadding(_this);
                _reset = 0;
            },
            error: function () {
                remove_loadding(_this);
                _reset = 0;
            }
        });
    }
    return false;
});
$(document).on("click", "#romove-attribute", function () {
    _ajax_this = $(this);
    var type = $(this).data("type");
    var id = $(this).data("id");
    var reference_type = $(this).data("group");
    var parent_remove = $(this).parent("li").find("a").attr("href");
    var token = $("#token_set").val();
    if (typeof token !== "undefined" && token !== "" && _reset == 0) {
        _reset = 1;
        $.ajax({
            url: base_url + "admin/product/remove_attribute",
            type: "post",
            dataType: "json",
            data: {"id": id, "type": type, "token": token, "reference_type": reference_type},
            success: function (data, textStatus, jqXHR) {
                if (typeof parent_remove !== "undefined") {
                    _ajax_this.parents("li").remove();
                    $(parent_remove).remove();
                } else {
                    _ajax_this.parents("fieldset").parent().parent().remove();
                }
                lenght_element = $("#box-tabs .nav-tabs li").length;
                _reset = 0;
            }, error: function (jqXHR, textStatus, errorThrown) {
                _reset = 0;
            }
        });
    }
});
function set_box_add_attribute(value_set, ojb) {
    if (value_set.trim() != "") {
        ojb.parents(".box-add-attribute").find(".title-defaut .name").text(value_set);
        ojb.parents(".box-add-attribute").find("#attribute-type").removeAttr('disabled');
        ojb.parents(".box-add-attribute").find("#save-attribute").removeAttr('disabled');
    } else {
        ojb.parents(".box-add-attribute").find("#attribute-type").prop('disabled', 'disabled');
        ojb.parents(".box-add-attribute").find("#attribute-type option").removeAttr('selected');
        ojb.parents(".box-add-attribute").find("#attribute-type option.default").prop("selected", "selected");
        ojb.parents(".box-add-attribute").find("#attribute-parent").prop('disabled', 'disabled');
        ojb.parents(".box-add-attribute").find("#attribute-parent option").removeAttr('selected');
        ojb.parents(".box-add-attribute").find("#save-attribute").prop("disabled", "disabled");
        ojb.parents(".box-add-attribute").find("#attribute-parent option.default").prop("selected", "selected");
        ojb.parents(".box-add-attribute").find(".box-default-values").slideUp("slow");
        ojb.parents(".box-add-attribute").find(".title-defaut .name").text("Thuộc Tính");
    }
}
function show_html_attribute(type, name, pid, id, slug, parent_return, min, max, required, group) {
    var html_mm = "";
    var value_name = group + "-" + id;
    var html_required = "";
    var required_text = "";
    var required_in = "";
    if (required == 1) {
        html_required = "(*";
        required_text = "data-validate = 'true'";
        required_in = "data-required='true'";
    }
    if (min != "") {
        html_mm = 'data-min = "' + min + '"';
        required_text = "data-validate = 'true'";
        if (html_required == "") {
            html_required += "(Min: " + min + "";
        } else {
            html_required += " Min: " + min + "";
        }
    }
    if (max != "") {
        html_mm += ' data-max = "' + max + '"';
        required_text = "data-validate = 'true'";
        if (html_required == "") {
            html_required += "(Max: " + max + "";
        } else {
            html_required += " Max: " + max + "";
        }

    }
    if (html_required != "") {
        html_required += ")";
    }
    var html = "null";
    switch (type) {
        case "option":
            html = '<option id="' + slug + '" value="' + name + '">' + name + '</option>';
            break;
        case "radio":
            html = '<li> <div class="checkbox"> <input type="radio" id="' + slug + '" value="' + name + '" name="attribute[' + group + "-" + pid + '][]"> <label for="' + slug + '"><span>' + name + '</span></label> </div> </li>';
            break;
        case "checkbox":
            html = '<li> <div class="checkbox"> <input type="checkbox" id="' + slug + '" value="' + name + '" name="attribute[' + group + "-" + pid + '][]"> <label for="' + slug + '"><span>' + name + '</span></label> </div> </li>';
            break;
        case "number":
            html = '<div class="row" id="' + slug + '"><div class="col-md-12">';
            html += '<fieldset><legend>' + name + ' ' + html_required + '</legend>';
            html += '<div class="romove" id="romove-attribute" data-id="' + id + '" data-group ="' + group + '" data-type="attribute"><i class="fa fa-close"></i></div>';
            html += '<div id="' + id + '">';
            html += '<input type="number" ' + html_mm + ' class="form-control" name="attribute[' + value_name + '][]" ' + required_in + ' ' + required_text + '>';
            html += '</div></div></div></fieldset>';
            break;
        case "textarea":
            html = '<div class="row" id="' + slug + '"><div class="col-md-12">';
            html += '<fieldset><legend>' + name + ' ' + html_required + '</legend>';
            html += '<div class="romove" id="romove-attribute" data-id="' + id + '" data-group ="' + group + '" data-type="attribute"><i class="fa fa-close"></i></div>';
            html += '<div id="' + id + '">';
            html += '<textarea class="form-control" ' + html_mm + ' name="attribute[' + value_name + '][]" ' + required_in + ' ' + required_text + '></textarea>';
            html += '</div></div></div></fieldset>';
            break;
        case "date":
            html = '<div class="row" id="' + slug + '"><div class="col-md-12">';
            html += '<fieldset><legend>' + name + ' ' + html_required + '</legend>';
            html += '<div class="romove" id="romove-attribute" data-id="' + id + '" data-group ="' + group + '" data-type="attribute"><i class="fa fa-close"></i></div>';
            html += '<div id="' + id + '">';
            html += '<div class="input-group"><div class="input-group-addon"> <i class="fa fa-calendar"></i></div><input type="text" value="" class="form-control pull-right" name="attribute[' + value_name + '][]" id="date-filed" ' + required_in + ' ' + required_text + '></div>';
            html += '</div></div></div></fieldset>';
            break;
        case "select":
            html = '<div class="row" id="' + slug + '"><div class="col-md-12">';
            html += '<fieldset><legend>' + name + ' ' + html_required + '</legend>';
            html += '<div class="romove" id="romove-attribute" data-id="' + id + '" data-group ="' + group + '" data-type="attribute"><i class="fa fa-close"></i></div>'
            html += '<div id="' + id + '">';
            html += '<select class = "form-control" name = "attribute[' + value_name + '][]" ' + required_in + ' ' + required_text + '>';
            html += '<option value="{[-]}" id="default">- Lựa chọn -</option>';
            if (parent_return != "null") {
                $.each(parent_return, function (key, value) {
                    html += '<option id="' + value["Slug"] + '" value="' + value["Name"] + '">' + value["Name"] + '</option>';
                });
            }
            html += '< /select>';
            html += '</div></div></div></fieldset>';
            break;
        case "multipleselect":
            html = '<div class="row" id="' + slug + '"><div class="col-md-12">';
            html += '<fieldset><legend>' + name + ' ' + html_required + '</legend>';
            html += '<div class="romove" id="romove-attribute" data-id="' + id + '" data-group ="' + group + '" data-type="attribute"><i class="fa fa-close"></i></div>'
            html += '<div id="' + id + '">';
            html += '<ul class = "nav-check attribute" data-group="true" ' + required_in + ' ' + required_text + '>';
            if (parent_return != "null") {
                var offset = 0;
                $.each(parent_return, function (key, value) {
                    if (offset == 0) {
                        html += '<li class="none"><input type="checkbox" value="{[-]}" name="attribute[' + value_name + '][]" checked> </li>';
                    }
                    html += '<li><div class="checkbox"> <input type="checkbox" id="attribute-' + value["Slug"] + '-' + value["ID"] + '" value="' + value["Name"] + '" name="attribute[' + value_name + '][]"> <label for="attribute-' + value["Slug"] + '-' + value["ID"] + '"><span>' + value["Name"] + '</span></label> </div> </li>';
                    offset++;
                });
            }
            html += '</ul>';
            html += '</div></div></div></fieldset>';
            break;
        case "multipleradio":
            html = '<div class="row" id="' + slug + '"><div class="col-md-12">';
            html += '<fieldset><legend>' + name + ' ' + html_required + '</legend>';
            html += '<div class="romove" id="romove-attribute" data-id="' + id + '" data-group ="' + group + '" data-type="attribute"><i class="fa fa-close"></i></div>'
            html += '<div id="' + id + '">';
            html += '<ul class = "nav-check attribute" data-group="true" ' + required_in + ' ' + required_text + '>';
            if (parent_return != "null") {
                var offset = 0;
                $.each(parent_return, function (key, value) {
                    if (offset == 0) {
                        html += '<li class="none"><input type="radio" value="{[-]}" name="attribute[' + value_name + '][]" checked> </li>';
                    }
                    html += '<li> <div class="checkbox"> <input type="radio" id="attribute-' + value["Slug"] + '-' + value["ID"] + '" value="' + value["Name"] + '" name="attribute[' + value_name + '][]"> <label for="attribute-' + value["Slug"] + '-' + value["ID"] + '"><span>' + value["Name"] + '</span></label> </div> </li>';
                    offset++;
                });
            }
            html += '</ul>';
            html += '</div></div></div></fieldset>';
            break;
        default:
            html = '<div class="row" id="' + slug + '"><div class="col-md-12">';
            html += '<fieldset><legend>' + name + ' ' + html_required + '</legend>';
            html += '<div class="romove" id="romove-attribute" data-id="' + id + '" data-group ="' + group + '" data-type="attribute"><i class="fa fa-close"></i></div>'
            html += '<div id="' + id + '">';
            html += '<input type="text" class="form-control" ' + html_mm + ' name="attribute[' + value_name + '][]" ' + required_in + ' ' + required_text + '>';
            html += '</div></div></div></fieldset>';
    }
    return html;
}
function add_html_tabs(slug, category) {
    var html = '<div id="' + slug + '-parent-block" class="tab-pane fade master-attribute attribute in"> <div class="col-md-8 add-product"> <div class="panel panel-default"> <div class="panel-heading">Thuộc Tính Liên Quan</div> <div class="panel-body"> </div> </div> </div> <div class="col-md-4"> <div class="panel panel-default"> <div class="panel-heading">Thêm Mới Thuộc Tính</div> <div class="panel-body"> <div class="box-add-attribute" data-category="' + category + '" data-group="' + slug + '"><div id="box-add"> <div class="form-group row"> <div class="col-md-12"> <p>Tên Thuộc Tính Khởi Tạo:</p> <input type="text" id="name-attribute" class="form-control" data-add="attribute" placeholder="Tên Thuộc Tính" autocomplete="on"> </div> </div> <div class="form-group row"> <div class="col-md-12"> <div class="checkbox"> <input type="checkbox" id="' + slug + '" class="required-field" value="1"> <label for="' + slug + '"><span>Là Thuộc Tính Bắt Buộc.</span></label> </div> </div> </div> <div class="form-group row"> <div class="col-md-12"> <select id="attribute-type" class="form-control" disabled=""> <option class="default" value="0" selected="">—— Chọn Thể Loại Thuộc Tính ——</option> <option value="text">Text Filed</option> <option value="textarea">Text Area Filed</option> <option value="number">Number Filed</option> <option value="date">Date Filed</option> <option value="select">Select</option> <option value="option">Option</option> <option value="radio">Radio</option> <option value="multipleradio">Multi radio</option> <option value="multipleselect">Multi select</option> <option value="checkbox">Checkbox</option> </select> </div> </div> <div class="row"> <div id="box-required"> <div class="data-grup-required"> <div class="col-md-6"> <div class="form-group"> <label>Số kí tự ít nhất:</label> <input type="number" min="0" class="form-control required-value" placeholder="Giá trị"> </div> </div> <div class="col-md-6"> <div class="form-group"> <label>Số kí tự nhiều nhất:</label> <input type="number" min="0" class="form-control required-value" placeholder="Giá trị"> </div> </div> </div> </div> </div> <div class="box-default-values"> <p class="title-defaut">Giá Trị Mặc Định Của <span class="name">Thuộc Tính</span></p> <div class="box-items"> <div class="item relative"> <div class="form-group"> <input class="default-values form-control" type="text" placeholder="Tên Giá Trị Mặc Định"> </div> </div> </div> <p class="text-right"><button class="btn btn-default" id="add-item">Thêm </button></p> </div> <div class="form-group row"> <div class="col-md-12"> <select id="attribute-parent" class="form-control" disabled=""> <option class="default" value="0" selected="">—— Chọn Thuộc Tính Cha ——</option> </select> </div> </div> <div class="form-group row"> <div class="col-md-12"><button href="#" id="save-attribute" data-type="product" class="btn btn-success relative" disabled="">Khởi Tạo</button></div> </div> </div></div></div></div> </div></div>';
    return html;
}
$(document).on("change", "#price-type", function () {
    var set_value = $(this).val();
    if (set_value == "0") {
        $(this).parents("#price-parent-block").find("#price_product").prop('disabled', 'disabled').removeAttr('name').val("").removeAttr("data-validate").removeAttr("data-required");
        $(this).parents("#price-parent-block").find("#special_price").prop('disabled', 'disabled').removeAttr('name').val("");
    } else {
        $(this).parents("#price-parent-block").find("#price_product").removeAttr('disabled').attr("name", "price[price_product]").attr("data-validate", "true").attr("data-required", "true");
        $(this).parents("#price-parent-block").find("#special_price").removeAttr('disabled').attr("name", "price[special_price]");
    }
});
$(document).on("keyup", ".box-add-attribute #add-attribute", function () {
    var value_set = $(this).val();
    set_box_add_attribute(value_set, $(this));
});

$(document).on("click", "tr #action-delete", function (e) {
    $("#modal_delete .modal-title > strong").text("Xóa !!!");
    $("#modal_delete .modal-body > p").text("Bạn muốn muốn thực hiện điều này ?");
    var id = $(this).data("id");
    _this = $(this).parents("tr");
    data = action_delete(base_url + "admin/product/delete/" + id, _this);
    return false;
});
$(document).on("click", "tr #action-disabled", function (e) {
    $("#modal_delete .modal-title > strong").text("Ẩn hiện sản phẩm !!!");
    $("#modal_delete .modal-body > p").text("Bạn muốn muốn thực hiện điều này ?");
    var id = $(this).data("id");
    _this = $(this);
    action_delete(base_url + "admin/product/disabled/" + id, _this);
    return false;
});
