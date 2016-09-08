/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var _this;
var _screen_width = $(window).width();
var _screen_height = $(window).height();
var width_move = 0;
var offset = 0;
var left_total = 0;
var lenght_element = 0;
var width_set = 0;
var input_clone = '<div class="item relative add-new"> <div class="remove-item">x</div> <div class="form-group"> <input class="default-values form-control" type="text" placeholder="Tên Giá Trị Mặc Định"> </div> </div>';
var reset = 0;
$(document).ready(function () {
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
    $('#content').summernote({
        height: 300
    });
    $("[data-mask]").inputmask();
    $("#startdate,#enddate").datepicker({
        format: 'mm-dd-yyyy',
        startDate: '-3d'
    });
    $( "#box-tree-attribute ul" ).accordion({
        heightStyle: "content",
        collapsible: true,
        active: false

    });
});
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
    if (title_new_cat.trim() != "") {
        $.ajax({
            url: base_url + "admin/product/addcategory",
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
                }
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
function to_slug(str) {
    str = str.toLowerCase();
    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
    str = str.replace(/(đ)/g, 'd');
    str = str.replace(/([^0-9a-z-\s])/g, '');
    str = str.replace(/(\s+)/g, '-');
    str = str.replace(/^-+/g, '');
    str = str.replace(/-+$/g, '');
    return str;
}

$(document).on("change", "#attribute-type", function () {
    var value_set = $(this).val();
    $(this).parents(".box-add-attribute").find("#attribute-parent option").show();
    if (value_set != "0") {
        $(this).parents(".box-add-attribute").find("#attribute-parent").removeAttr('disabled');
        if (value_set == "text" || value_set == "number" || value_set == "textarea" || value_set == "select" || value_set == "multipleradio" || value_set == "multipleselect") {
            $(this).parents(".box-add-attribute").find("#attribute-parent").prop('disabled', 'disabled');
            if (value_set == "select" || value_set == "multipleradio" || value_set == "multipleselect") {
                $(this).parents(".box-add-attribute").find(".box-default-values").slideDown("slow");
            } else {
                $(this).parents(".box-add-attribute").find(".box-default-values").slideUp("slow");
                $(this).parents(".box-add-attribute").find("#attribute-parent option").removeAttr('selected');
                $(this).parents(".box-add-attribute").find("#attribute-parent option.default").prop("selected", "selected");
            }
        } else {
            $(this).parents(".box-add-attribute").find(".box-default-values").slideUp("slow");
            if (value_set == "option") {
                $(this).parents(".box-add-attribute").find("#attribute-parent option:not(.select,.default)").hide();
            } else if (value_set == "radio") {
                $(this).parents(".box-add-attribute").find("#attribute-parent option:not(.multipleradio,.default)").hide();
            } else {
                $(this).parents(".box-add-attribute").find("#attribute-parent option:not(.multipleselect,.default)").hide();
            }
            $(this).parents(".box-add-attribute").find("#attribute-parent").removeAttr('disabled');
        }
    } else {
        $(this).parents(".box-add-attribute").find("#attribute-parent").prop('disabled', 'disabled');
        $(this).parents(".box-add-attribute").find("#attribute-parent option").removeAttr('selected');
        $(this).parents(".box-add-attribute").find("#attribute-parent option.default").prop("selected", "selected");
    }

});
$(document).on("keyup", ".box-add-attribute #add-attribute", function () {
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
$(document).on("click", ".box-add-attribute #save-attribute", function (e) {
    e.preventDefault();
    _this = $(this);
    _this.parents(".box-add-attribute").find("#attribute-parent").removeClass("warring");
    var data_category = _this.parents(".box-add-attribute").data("category");
    var data_group = _this.parents(".box-add-attribute").data("group");
    var name = _this.parents(".box-add-attribute").find("#add-attribute").val();
    var type = _this.parents(".box-add-attribute").find("#attribute-type").val();
    var parent = _this.parents(".box-add-attribute").find("#attribute-parent").val();
    var required = _this.parents(".box-add-attribute").find("#required-field-attr:checked").val();
    if (_this.parents(".box-add-attribute").find("#attribute-parent:enabled").length > 0 && parent == "0") {
        _this.parents(".box-add-attribute").find("#attribute-parent:enabled").addClass("warring");
        return false;
    }
    var default_values = "";
    if (type == "select" || type == "multipleradio" || type == "multipleselect") {
        $.each(_this.parents(".box-add-attribute").find(".default-values"), function () {
            if ($(this).val() != "") {
                default_values += $(this).val() + ",";
            }
        });
    }
    if ((type == "select" || type == "multipleradio" || type == "multipleselect") && default_values == "") {
        _this.parents(".box-add-attribute").find(".default-values").addClass("warring");
        return false;
    }
    if  (name.trim() != "") {
        _this.parents(".attribute").find(".warring").removeClass("warring");
        _this.append(loading());
        $.ajax({
            url: base_url + "admin/attributes/add",
            type: "post",
            dataType: "json",
            data: {
                "data_category": data_category,
                "data_group": data_group,
                "name": name,
                "type": type,
                "parent": parent,
                "default_values": default_values,
                "required": required
            },
            success: function (data) {
                if (data["success"].trim() == "success") {
                    var attribute = data["response"]['attribute'];
                    var arg_parents = data["response"]['arg_parents'];
                    var html = show_html_attribute(attribute["Value"], attribute["Name"], attribute["Parent_ID"], attribute["ID"], attribute["Slug"], arg_parents);
                    if (attribute["Parent_ID"] == "0" || attribute["Parent_ID"] == 0) {
                        _this.parents(".tab-pane").find(".add-product .panel-body").append(html);
                        _this.parents(".box-add-attribute").find("#attribute-parent").append('<option class="' + attribute["Value"] + '" value="' + attribute["ID"] + '">' + attribute["Name"] + '</option>');
                    } else {
                        if (attribute["Value"] != "option") {
                            _this.parents(".tab-pane").find(".add-product .panel-body #" + attribute["Parent_ID"] + " ul").append(html);
                        } else {
                            _this.parents(".tab-pane").find(".add-product .panel-body #" + attribute["Parent_ID"] + " select").append(html);
                        }
                    }


                }else{
                    var attribute = data["response"]["attribute"];
                    if(attribute["Value"] == "option"){
                        $("select #"+attribute["Slug"]+"").prop("selected", "selected");
                        _this.parents(".attribute").find("#"+attribute["Slug"]+"").parent().addClass("warring");
                    }else if(attribute["Parent_ID"] == 0 || attribute["Parent_ID"] == "0" ){
                        $("#"+attribute["Slug"]).find("fieldset").addClass("warring");
                    }else{
                        _this.parents(".attribute").find("#"+attribute["Slug"]).trigger("click");
                        _this.parents(".attribute").find("#"+attribute["Slug"]).parents("fieldset").addClass("warring");
                    } 
                }
                _this.parents(".box-add-attribute").find("#add-attribute").val("");
                var value_set = _this.parents(".box-add-attribute").find("#add-attribute").val();
                var ojb = _this.parents(".box-add-attribute").find("#add-attribute");
                set_box_add_attribute(value_set, ojb);
                _this.parents(".box-add-attribute").find(".box-default-values .add-new").remove();
                remove_loadding(_this);
            },
            error: function () {
                remove_loadding(_this);
            }
        });
    }
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
    } else {
        var data_category = _this.data("category");
        _this.append(loading());
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
                    _this.parents("#box-tabs-parent").find("ul #control-add-tabs").before('<li class=""><a data-toggle="tab" href="#' + data["slug"] + '-parent-block">' + data["name"] + '</a></li>');
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
            },
            error: function () {
                remove_loadding(_this);
            }
        });
    }
    return false;
});
function loading() {
    return "<div class ='loadding'><img src ='" + base_url + "skins/images/loading-2.gif" + "'></div>";
}
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
function remove_loadding(object) {
    object.find(".loadding").remove();
}
function show_html_attribute(type, name, pid, id, slug, parent_return) {
    var html = "null";
    switch (type) {
        case "option":
            html = '<option id="'+slug+'" value="' + name + '">' + name + '</option>';
            break;
        case "radio":
            html = '<li> <div class="checkbox"> <input type="radio" id="' + slug + '" value="' + name + '" name="attribute[' + pid + '][]"> <label for="' + slug + '"><span>' + name + '</span></label> </div> </li>';
            break;
        case "checkbox":
            html = '<li> <div class="checkbox"> <input type="checkbox" id="' + slug + '" value="' + name + '" name="attribute[' + pid + '][]"> <label for="' + slug + '"><span>' + name + '</span></label> </div> </li>';
            break;
        case "number":
            html = '<div class="row" id="' + slug + '"><div class="col-md-12">';
            html += '<fieldset><legend>' + name + '</legend>';
            html += '<div id="' + id + '">';
            html += '<input type="number" class="form-control" name="attribute[' + id + '][]">';
            html += '</div></div></div></fieldset>';
            break;
        case "select":
            html = '<div class="row" id="' + slug + '"><div class="col-md-12">';
            html += '<fieldset><legend>' + name + '</legend>';
            html += '<div id="' + id + '">';
            html += '<select class = "form-control" name = "attribute[' + id + '][]">';
            if (parent_return != "null") {
                $.each(parent_return, function (key, value) {
                    html += '<option id="'+value["Slug"]+'" value="' + value["Name"] + '">' + value["Name"] + '</option>';
                });
            }
            html += '< /select>';
            html += '</div></div></div></fieldset>';
            break;
        case "multipleselect":
            html = '<div class="row" id="' + slug + '"><div class="col-md-12">';
            html += '<fieldset><legend>' + name + '</legend>';
            html += '<div id="' + id + '">';
            html += '<ul class = "nav-check attribute">';
            if (parent_return != "null") {
                $.each(parent_return, function (key, value) {
                    html += '<li> <div class="checkbox"> <input type="checkbox" id="' + value["Slug"] + '" value="' + value["Name"] + '" name="attribute[' + id + '][]"> <label for="' + value["Slug"] + '"><span>' + value["Name"] + '</span></label> </div> </li>';
                });
            }
            html += '</ul>';
            html += '</div></div></div></fieldset>';
            break;
        case "multipleradio":
            html = '<div class="row" id="' + slug + '"><div class="col-md-12">';
            html += '<fieldset><legend>' + name + '</legend>';
            html += '<div id="' + id + '">';
            html += '<ul class = "nav-check attribute">';
            if (parent_return != "null") {
                $.each(parent_return, function (key, value) {
                    html += '<li> <div class="checkbox"> <input type="radio" id="' + value["Slug"] + '" value="' + value["Name"] + '" name="attribute[' + id + '][]"> <label for="' + value["Slug"] + '"><span>' + value["Name"] + '</span></label> </div> </li>';
                });
            }
            html += '</ul>';
            html += '</div></div></div></fieldset>';
            break;
        default:
            html = '<div class="row" id="' + slug + '"><div class="col-md-12">';
            html += '<fieldset><legend>' + name + '</legend>';
            html += '<div id="' + id + '">';
            html += '<input type="text" class="form-control" name="attribute[' + id + '][]">';
            html += '</div></div></div></fieldset>';
    }
    return html;
}
function add_html_tabs(slug, category) {
    var html = '<div id="' + slug + '-parent-block" class="tab-pane fade master-attribute in"> <div class="col-md-8 add-product"> <div class="panel panel-default"> <div class="panel-heading">Thuộc Tính Liên Quan</div> <div class="panel-body"> </div> </div> </div> <div class="col-md-4"> <div class="panel panel-default"> <div class="panel-heading">Thêm Mới Thuộc Tính</div> <div class="panel-body"> <div class="box-add-attribute" data-category="' + category + '" data-group="' + slug + '"> <div id="box-add"> <div class="form-group row"> <div class="col-md-12"> <p>Tên Thuộc Tính Khởi Tạo:</p> <input type="text" id="add-attribute" class="form-control" data-add="attribute" placeholder="Tên Thuộc Tính" autocomplete="on"> </div> </div> <div class="form-group row"> <div class="col-md-12"> <select id="attribute-type" class="form-control" disabled=""> <option class="default" value="0" selected="">—— Chọn Thể Loại Thuộc Tính ——</option> <option value="text">Text</option> <option value="number">Number</option> <option value="select">Select</option> <option value="option">Option</option> <option value="multipleradio">multiple radio</option> <option value="radio">Radio</option> <option value="multipleselect">multiple select</option> <option value="check">Check</option> </select> </div> </div> <div class="box-default-values"> <p class="title-defaut">Giá Trị Mặc Định Của <span class="name">Thuộc Tính</span></p> <div class="box-items"> <div class="item relative"> <div class="form-group"> <input class="default-values form-control" type="text" placeholder="Tên Giá Trị Mặc Định"> </div> </div> </div> <p class="text-right"><button class="btn btn-default" id="add-item">Thêm </button></p> </div> <div class="form-group row"> <div class="col-md-12"> <select id="attribute-parent" class="form-control" disabled=""> <option class="default" value="0" selected="">—— Chọn Thuộc Tính Cha ——</option> </select> </div> </div> <div class="form-group row"> <div class="col-md-12"><button href="#" id="save-attribute" class="btn btn-success relative" disabled="">Khởi Tạo</button></div> </div> </div> </div> </div> </div> </div> </div>';
    return html;
}
$(document).on("change", "#price-type", function () {
    var set_value = $(this).val();
    if (set_value == "0") {
        $(this).parents("#price").find("#price_product").prop('disabled', 'disabled').removeAttr('name');
        $(this).parents("#price").find("#special_price").prop('disabled', 'disabled').removeAttr('name');

    } else {
        $(this).parents("#price").find("#price_product").removeAttr('disabled').attr("name", "price[price_product]")
        $(this).parents("#price").find("#special_price").removeAttr('disabled').attr("name", "price[special_price]");
    }
});

$("#box-tree-attribute ul").sortable({
    connectWith: " > ul",
    stop :function(){ 
        var sort_set = "";
        var sort_get = $(this).find(">input#sort_get").val();
        $.each( $(this).find(">li"),function(){ sort_set+=$(this).data("id")+",";});
        if(sort_set !== sort_get && reset == 0){
            reset = 1;
            _this = $(this);
            $.ajax({
                url : base_url+"admin/attributes/updatesort",
                type : "post",
                dataType :"json",
                data :{"sort" : sort_set},
                success: function(data){
                    if(data["success"] = "success"){
                        _this.find(">input#sort_get").val(sort_set);
                    }else{
                        alert("error");
                    }  
                    reset = 0;
                },
                error:function(){
                    reset = 0;
                    alert("error");
                }
            });
        }
    }
});