var clone_text_required = '<div class="col-md-6"> <div class="form-group"> <label>Số kí tự ít nhất:</label> <input type="number" id="min-data" min="0" class="form-control required-value" placeholder="Giá trị"> </div> </div> <div class="col-md-6"> <div class="form-group"> <label>Số kí tự nhiều nhất:</label> <input type="number" id="max-data" min="0" class="form-control required-value" placeholder="Giá trị"> </div> </div>';
var clone_number_required = '<div class="col-md-6"> <div class="form-group"> <label>Số nhỏ nhất:</label> <input type="number" id="min-data" min="0" class="form-control required-value" placeholder="Giá trị"> </div> </div> <div class="col-md-6"> <div class="form-group"> <label>Số lớn nhất:</label> <input type="number" id="max-data" min="0" class="form-control required-value" placeholder="Giá trị"> </div> </div>';
if ($("#box-tree-category-type ul").length > 0) {
    $(".tree_ui ul").sortable({
        connectWith: ">ul",
    });
    $(document).on("mouseover", ".tree_ui ul", function () {
        var level = ">ul";
        $(this).sortable({
            connectWith: level,
            stop: function (e, ui) {
                _this = $(this);
                var sort_set = "";
                var element_attr_set = "";
                var sort_set_m = "";
                var element_attr_set_m = "";
                var sort_get = _this.find(">input#sort_get").val();
                var ojb_type = _this.find(">input#sort_get").data("type");
                var emlent = ui.item[0];
                var id_attribute = $(emlent).data("attrid");
                var id_group = $(emlent).parent().parent().data("id");
                var sort_group = $(emlent).parent().find(" > input#element_attr").val();
                $.each(_this.find(">li"), function () {
                    sort_set += $(this).data("id") + ",";
                    element_attr_set += $(this).data("attrid") + ",";
                });
                $.each($(emlent).parent().find(">li"), function () {
                    sort_set_m += $(this).data("id") + ",";
                    element_attr_set_m += $(this).data("attrid") + ",";
                });
                _this.find(">input#sort_get").val(sort_set);
                _this.find(">input#element_attr").val(element_attr_set);
                $(emlent).parent().find(">input#sort_get").val(sort_set_m);
                $(emlent).parent().find(">input#element_attr").val(element_attr_set_m);
                if (_reset == 0 && typeof sort_group != "undefined" && sort_group.indexOf(id_attribute) <= -1 && $(emlent).parent().find(" > input#element_attr").length > 0) {
                    _reset = 1;
                    $.ajax({
                        url: base_url + "admin/attributes/move/",
                        type: "post",
                        dataType: "json",
                        data: {"sort": sort_set_m, "id_attribute": id_attribute, "id_group": id_group},
                        success: function (data) {
                            if (data["success"] = "success") {
                            } else {
                                alert("error");
                            }
                            _reset = 0;
                        },
                        error: function () {
                            _reset = 0;
                            alert("error");
                        }
                    });
                } else {
                    if (sort_set !== sort_get && _reset == 0) {
                        _reset = 1;
                        $.ajax({
                            url: base_url + "admin/attributes/updatesort/" + ojb_type,
                            type: "post",
                            dataType: "json",
                            data: {"sort": sort_set},
                            success: function (data) {
                                if (data["success"] == "success") {

                                } else {
                                    alert("error");
                                }
                                _reset = 0;
                            },
                            error: function () {
                                _reset = 0;
                                alert("error");
                            }
                        });
                    }
                }
            }
        });
    });
}
$(document).on("change", ".tree_ui #change-type", function () {
    var value = $(this).val();
    var id = $(this).data("id");
    var type = $(this).data("type");
    if (_reset == 0) {
        _reset = 1;
        $.ajax({
            url: base_url + "admin/attributes/update_type/" + type,
            type: "post",
            dataType: "json",
            data: {"value": value, "id": id},
            success: function (data) {
                if (data["success"] = "success") {
                } else {
                    alert("error");
                }
                _reset = 0;
            },
            error: function () {
                _reset = 0;
                alert("error");
            }
        })
    }
});
$(document).on("click", "#box-tree-attribute #action-delete", function (e) {
    var id = $(this).parents(".list-group-item").parent().data("id");
    var type = $(this).data("type");
    _this = $(this).parents(".list-group-item").parent();
    action_delete(base_url + "admin/attributes/delete/" + type + "/" + id, _this);
    return false;
});
$(document).on("click", ".tree_ui #action-add", function () {
    _this = $(this);
    $(".warring").removeClass("warring");
    category_type = $("#root-type").val();
    var group_id = _this.parents(".list-group-item").parent().data("slug");
    $("#modal_add_attribute .box-add-attribute").attr("data-group", group_id);
    $("#modal_add_attribute .box-add-attribute").attr("data-category", category_type);
    $("#modal_add_attribute_child .box-add-attribute").attr("data-category", category_type);
    if (_this.data("type") == "attribute-group") {
        $("#modal_add_attribute").modal();
    } else if (_this.data("type") == "attribute-group-attribute") {
        $("#modal_add_attribute_child").modal();
    }
    return false;
});
$(document).on("click", ".tree_ui #action-edit", function () {
    _this = $(this);
    var id = $(this).data("id");
    var type = $(this).data("type");
    if(type == "attribute-group" || type == "attribute"){
        if ($(this).hasClass("open") == true) {
            var data_name = $(this).parents(".list-group-item").find("#name-attribute #update-name-cancel").data("name");
            $(this).parents(".list-group-item").find("#name-attribute").html(data_name);
            $(this).removeClass("open");
        } else {
            _this = $(this);
            var type = _this.data("type");
            var id_attribute = _this.parents(".list-group-item").parent().data("id");
            if (type == "attribute-group-attribute") {
                id_attribute = _this.parents(".list-group-item").parent().data("attrid");
            }
            name_attribute = _this.parents(".list-group-item").find(">#name-attribute").text();
            var html = "<div id='box-main'>";
            html += "<input class='form-control not-null' type='text' id='name-get-set' value ='" + name_attribute + "'>";
            html += "<button href='#' data-name ='" + name_attribute + "' data-id='" + id_attribute + "' data-type='" + type + "' id='update-name-cancel' class='btn btn-success relative' ><i class='fa fa-times-circle'></i></button>";
            html += "<button href='#' data-name ='" + name_attribute + "' data-id='" + id_attribute + "' data-type='" + type + "' id='update-name-ok' class='btn btn-success relative controller' disabled ><i class='fa fa-location-arrow'></i></button>";
            html += "</div>";
            _this.parents(".list-group-item").find(">#name-attribute").html(html);
            $(this).addClass("open");
        }
    }else{
        $("#modal-edit-attribute #box-required .data-grup-required").hide();
            $("#modal-edit-attribute #attribute-type option").prop("selected",false);
        if(_reset == 0){
            _reset = 1;
            $.ajax({
                url : base_url + "admin/attributes/edit",
                type: "post",
                dataType: "json",
                data:{"id":id,"type":type},
                success:function(data){
                    $("#modal-edit-attribute #attribute-type").removeAttr("disabled");
                    $("#modal-edit-attribute #attribute-type option").removeAttr("selected");
                    $("#modal-edit-attribute #name-attribute").val(data["Name"]);
                    $("#modal-edit-attribute #messenger_error").val(data["Messenger_Error"]);
                    $("#modal-edit-attribute #id-attribute").val(data["ID"]);
                    $("#modal-edit-attribute #attribute-type").val(data["Value"]);
                    $("#modal-edit-attribute #unit").val(data["Unit"]);
                    $("#modal-edit-attribute #attribute-type #"+data["Value"].trim()+"").prop("selected",true);
                    if(data["Require"] == 1){
                        $("#modal-edit-attribute #required-field-edit-attr").prop("checked", true);
                    }else{
                        $("#modal-edit-attribute #required-field-edit-attr").prop("checked", false);
                    }
                    var html_rq = "";
                    if(data["Value"] == "text" || data["Value"] == "textarea"){
                        html_rq = clone_text_required;
                    }
                    if(data["Value"] == "number"){
                        html_rq = clone_number_required;
                    }
                    $("#modal-edit-attribute #box-required .data-grup-required").html(html_rq);
                    if(data["Validate"] != ""){
                        var validate = JSON.parse(data["Validate"]);
                        $("#modal-edit-attribute #box-required .data-grup-required #min-data").val(validate["min_length"]);
                        $("#modal-edit-attribute #box-required .data-grup-required #max-data").val(validate["max_length"]);
                    }
                    
                    if(data["Parent_ID"] == "0"){
                        var html_show_seach = "<p><label>Là thuộc tìm kiếm:</label></p>";
                        if(data["Show_Search"] == "1"){
                            html_show_seach += '<select id="show-search" class="form-control"><option value="1" selected >Có</option><option value="0">Không</option></select>';
                        }else{
                            html_show_seach += '<select id="show-search" class="form-control"><option value="1">Có</option><option value="0" selected>Không</option></select>';
                        }
                        $("#modal-edit-attribute #show_search_box").html(html_show_seach).show();
                    }else{
                        $("#modal-edit-attribute #show_search_box").hide();
                    }
                    $("#modal-edit-attribute #attribute-type ."+data["Value"]+"").attr("selected");
                    $("#modal-edit-attribute #box-required .data-grup-required").show();
                    $("#modal-edit-attribute").modal();
                    _reset = 0;
                }
            });
        }
    }
    return false;
});
$(document).on("click", ".tree_ui #name-attribute #update-name-cancel", function () {
    $(this).parents(".list-group-item").find("#action-edit").removeClass("open");
    $(this).parents("#name-attribute").html($(this).data("name"));
});
$(document).on("click", ".tree_ui #name-attribute #update-name-ok", function () {
    _this = $(this);
    var new_name = _this.parents("#name-attribute").find("#name-get-set").val();
    var old_name = _this.data("name");
    if (new_name.trim() !== old_name) {
        if (_reset == 0) {
            _reset = 1;
            var type = _this.data("type");
            var id = _this.data("id");
            $.ajax({
                url: base_url + "admin/attributes/change_name",
                type: "post",
                dataType: "json",
                data: {"type": type, "id": id, "new_name": new_name},
                success: function (data, textStatus, jqXHR) {
                    if (data["success"].trim() == "success") {
                        _reset = 0;
                        _this.parents("#name-attribute").html(new_name);
                    } else {
                        alert("error");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    _reset = 0;
                    alert("error");
                }
            });
        }
    } else {
        _this.parents("#name-attribute").html($(this).data("name"));
    }
});
$(document).on("click", "li .list-group-item .more", function () {
    $(this).parent().parent().toggleClass("open");
    $(this).toggleClass("open").toggleClass("close");
    $(this).find(" > i").toggleClass("fa-caret-right").toggleClass("fa-caret-down");
    $(this).parent().parent().find(" > ul").toggleClass("block");
    return false;
});
$(document).on("click", "#box-main #save-attribute-group", function () {
    _this = $(this);
    var name_att_group = $("#name-attribute-group").val();
    category_type = _this.parents("#box-main").find("#category-type").val();
    if (_reset == 0) {
        _reset = 1;
        $(this).append(loading());
        $.ajax({
            url: base_url + "admin/attributes/add_group",
            type: 'POST',
            dataType: 'json',
            data: {"name": name_att_group, "category_type": category_type},
            success: function (data) {
                if (data["success"] == "success") {
                    var html = '<li class="item ui-state-default ui-sortable-handle" data-id="' + data['response']['ID'] + '" data-slug="' + data['response']['Slug'] + '" data-sort="' + data['response']['Sort'] + '">';
                    html += '<div class="list-group-item">';
                    html += '<span id = "name-attribute" > ' + data['response']['Name'] + ' </span> (Group attribute).';
                    html += '<div class="actions">';
                    if (data["type_member"] == _type_member) {
                        html += "<select data-type='attribute' id='change-type' data-id ='" + data['response']["ID"] + "'>";
                        if (data['response']["Type"] == "System") {
                            html += "<option value = 'System' selected>System</option><option value = 'Member'>Member</option>";
                        } else {
                            html += "<option value = 'System'>System</option><option value = 'Member' selected>Member</option>";
                        }
                        html += "</select>";
                    }
                    html += '<a href="#" id="action-edit" data-type ="attribute-group"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>';
                    html += '<a href="#" id="action-delete" data-type ="attribute-group"> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
                    html += '<a href="#" id="action-add" data-type="attribute-group"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>';
                    html += '</div>';
                    html += '<div class="more close"><i class="fa fa-caret-right"></i></div>';
                    html += '</div>';
                    html += '<ul class="list-group droptrue level-1 ui-sortable" data-level="1">';
                    html += '<input type="hidden" id="sort_get" value="" data-type="attribute-group-attribute" class="ui-sortable-handle"><input type="hidden" id="element_attr" value="" data-type="attribute-group-attribute" class="ui-sortable-handle">';
                    html += '</ul></li>';
                    var sort_default = $("#box-tree-attribute > ul#tree_attr > #sort_get").val();
                    $("#box-tree-attribute > ul#tree_attr > #sort_get").val(sort_default + data['response']['ID'] + ",");
                    $("#box-tree-attribute > ul#tree_attr > #sort_get").before(html);
                    _this.parents("#box-main").find("#name-attribute-group").val("");
                } else {
                    alert("error");
                }
                _reset = 0;
                remove_loadding(_this);
            },
            error: function () {
                alert("error");
                _reset = 0;
                remove_loadding(_this);
            }
        });
    }
});
$(document).on("click", ".box-add-attribute #save-attribute", function (e) {
    e.preventDefault();
    $(".warring").removeClass("warring");
    _ajax_this = $(this);
    var type_add = $(this).data("type");
    $(this).parents(".box-add-attribute").find("#attribute-parent").removeClass("warring");
    var data_category = $(this).parents(".box-add-attribute").data("category");
    var data_group = $(this).parents(".box-add-attribute").data("group");
    var name = $(this).parents(".box-add-attribute").find("#name-attribute").val();
    var type = $(this).parents(".box-add-attribute").find("#attribute-type").val();
    var show_search = $(this).parents(".box-add-attribute").find("#show-search").val();
    var parent = 0;
    var validate = "";
    var min_validate = "";
    var max_validate = "";
    var unit = $(this).parents(".box-add-attribute").find("#unit").val();
    var messenger_error = $(this).parents(".box-add-attribute").find("#messenger_error").val();
    if ((type == "text" || type == "textarea" || type == "number") && $(this).parents(".box-add-attribute").find(".required-value").length > 0) {
        validate = "";
        var offset_i = 0;
        $.each($(this).parents(".box-add-attribute").find(".required-value"), function () {
            if($(this).val() != ""){
                if ( !isNaN($(this).val())) {
                    if (offset_i == 0) {
                        validate += '"min_length" : "' + $(this).val() + '"';
                        min_validate = $(this).val();
                    }
                    if (offset_i == 1) {
                        if (validate == "")
                            validate += '"max_length" : "' + $(this).val() + '"';
                        else
                            validate += ',"max_length" : "' + $(this).val() + '"';
                        max_validate = $(this).val();
                    }

                }else{
                    $(this).addClass("warring");
                    return false;
                }
                offset_i++;
            }
            
        });
        if (validate != "") {
            validate = "{" + validate + "}";
        }

    }

    if ($(this).data("type") == "product") {
        parent = $(this).parents(".box-add-attribute").find("#attribute-parent").val();
    }
    var required = $(this).parents(".box-add-attribute").find(".required-field:checked").val();
    if ($(this).parents(".box-add-attribute").find("#attribute-parent:enabled").length > 0 && parent == "0") {
        $(this).parents(".box-add-attribute").find("#attribute-parent:enabled").addClass("warring");
        return false;
    }
    if (type == 0) {
        $(this).parents(".box-add-attribute").find("#attribute-type").addClass("warring");
        return false;
    }
    var default_values = "";
    if (type == "select" || type == "multipleradio" || type == "multipleselect") {
        $.each($(this).parents(".box-add-attribute").find(".default-values"), function () {
            if ($(this).val() != "") {
                default_values += $(this).val() + "[*_*]";
            }
        });
    }
    var multivalue = $(this).parents(".box-add-attribute").find("#multivalue").val();
    if ((type == "select" || type == "multipleradio" || type == "multipleselect") && (default_values == "" && multivalue == "")) {
        $(this).parents(".box-add-attribute").find(".default-values").addClass("warring");
        $(this).parents(".box-add-attribute").find("#multivalue").addClass("warring");
        return false;
    }
    if (name.trim() != "" && _reset == 0) {
        _reset = 1;
        $(this).parents(".attribute").find(".warring").removeClass("warring");
        $(this).append(loading());
        $.ajax({
            url: base_url + "admin/attributes/add",
            type: "post",
            dataType: "json",
            data: {
                "data_category": data_category,
                "data_group": data_group,
                "name": name,
                "type": type,
                "unit":unit,
                "parent": parent,
                "default_values": default_values,
                "multivalue": multivalue,
                "required": required,
                "validate": validate,
                "messenger_error" : messenger_error,
                "show_search" : show_search

            },
            success: function (data) {
                if (data["success"].trim() == "success") {
                    var attribute = data["response"]['attribute'];
                    var arg_parents = data["response"]['arg_parents'];
                    if (type_add == "attribute") {
                        var html = "";
                        var id_get = attribute["Attribute_Group_Attribute"] == 0 ? attribute["ID"] : attribute["Attribute_Group_Attribute"];
                        html = '<li class="item ui-state-default ui-sortable-handle" data-attrid="' + attribute["ID"] + '" data-id="' + id_get + '" data-slug="' + attribute["Slug"] + '" data-sort="' + attribute["Sort"] + '">';
                        html += '<div class="list-group-item"><span id ="name-attribute">' + attribute["Name"] + '</span> ';
                        html += '<div class="actions">';
                        if (data["type_member"] == _type_member) {
                            html += "<select data-type='attribute' id='change-type' data-id ='" + attribute["ID"] + "'>";
                            if (attribute["Type"] == "System") {
                                html += "<option value = 'System' selected>System</option><option value = 'Member'>Member</option>";
                            } else {
                                html += "<option value = 'System'>System</option><option value = 'Member' selected>Member</option>";
                            }
                            html += "</select>";
                        }
                        html += '<a href="#" id="action-edit" data-id="'+attribute["ID"]+'" data-type ="attribute-group-attribute"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>';
                        html += '<a href="#" id="action-delete" data-id="'+attribute["ID"]+'" data-type ="attribute-group-attribute"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
                        if (attribute["Value"] == "select" || attribute["Value"] == "multipleradio" || attribute["Value"] == "multipleselect") {
                            html += '<a href="#" data-type="attribute-group-attribute" id="action-add" data-categorytype="' + category_type + '"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>';
                        }
                        html += '</div>';
                        if (arg_parents.length > 0) {
                            html += '<div class="more close"><i class="fa fa-caret-right"></i></div>';
                        }
                        html += '</div>';
                        if (arg_parents.length > 0) {
                            var get_sort = "";
                            html += '<ul id="tree_attr_parent" class="list-group level-2" data-level="2">';
                            $.each(arg_parents, function (key, value) {
                                get_sort += value["ID"] + ",";
                                html += '<li class="item ui-state-default" data-id="' + value["ID"] + '" data-slug="' + value["Slug"] + '" data-sort="' + value["Sort"] + '">';
                                html += '<div class="list-group-item"><span id="name-attribute">' + value["Name"] + '</span>';
                                html += '<div class="actions">';
                                if (data["type_member"] == _type_member) {
                                    html += "<select data-type='attribute' id='change-type' data-id ='" + value["ID"] + "'>";
                                    if (value["Type"] == "System") {
                                        html += "<option value = 'System' selected>System</option><option value = 'Member'>Member</option>";
                                    } else {
                                        html += "<option value = 'System'>System</option><option value = 'Member' selected>Member</option>";
                                    }
                                    html += "</select>";
                                }
                                html += '<a href="#" id="action-edit" data-id="'+value["ID"]+'" data-type ="attribute"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>';
                                html += '<a href="#" id="action-delete" data-id="'+value["ID"]+'" data-type ="attribute"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
                                html += '</div>';
                                html += '</div>';
                                html += '</li>';
                            });
                            html += '<input type="hidden" id="sort_get" value="' + get_sort + '">';
                            html += '</ul>';
                        }
                        html += '</li>';
                        _this.parents(".list-group-item").parent().find(" > ul > #sort_get").before(html);
                        if (_this.parents(".list-group-item").find(" > .more").hasClass("close") == true) {
                            _this.parents(".list-group-item").find(" > .more").trigger("click");
                        }
                        var sort_update = _this.parents(".list-group-item").parent().find(" > ul > #sort_get").val();
                        sort_update = sort_update + id_get + ",";
                        _this.parents(".list-group-item").parent().find(" > ul > #sort_get").val(sort_update);
                    }
                }
                _ajax_this.parents(".box-add-attribute").find("#name-attribute").val("");
                var value_set = _ajax_this.parents(".box-add-attribute").find("#name-attribute").val();
                var ojb = _ajax_this;
                set_box_add_attribute(value_set, ojb);
                _ajax_this.parents(".box-add-attribute").find(".box-default-values .add-new").remove();
                remove_loadding(_ajax_this);
                _reset = 0;
                _ajax_this.parents(".box-add-attribute").find(".data-grup-required").slideUp("slow");
            },
            error: function () {
                remove_loadding(_ajax_this);
                _reset = 0;
                _ajax_this.parents(".box-add-attribute").find(".data-grup-required").slideUp("slow");
            }
        });
    }
    return false;
});
$(document).on("change", "#attribute-type", function () {
    var value_set = $(this).val();
    $(this).parents(".box-add-attribute").find("#data-grup-required").html("");
    $(this).parents(".box-add-attribute").find("#attribute-parent option").show();
    if (value_set != "0") {
        $(this).parents(".box-add-attribute").find("#attribute-parent").removeAttr('disabled');
        if (value_set == "text" || value_set == "number" || value_set == "textarea" || value_set == "select" || value_set == "multipleradio" || value_set == "multipleselect" || value_set == "date") {
            $(this).parents(".box-add-attribute").find("#attribute-parent").prop('disabled', 'disabled');
            if (value_set == "select" || value_set == "multipleradio" || value_set == "multipleselect") {
                $(this).parents(".box-add-attribute").find(".box-default-values").slideDown("slow");
            } else {
                $(this).parents(".box-add-attribute").find(".box-default-values").slideUp("slow");
                $(this).parents(".box-add-attribute").find("#attribute-parent option").removeAttr('selected');
                $(this).parents(".box-add-attribute").find("#attribute-parent option.default").prop("selected", "selected");
            }
            if (value_set == "text" || value_set == "textarea") {
                $(this).parents(".box-add-attribute").find(".data-grup-required").slideDown("slow")
                $(this).parents(".box-add-attribute").find(".data-grup-required").html(clone_text_required);
            } else if (value_set == "number") {
                $(this).parents(".box-add-attribute").find(".data-grup-required").slideDown("slow");
                $(this).parents(".box-add-attribute").find(".data-grup-required").html(clone_number_required);
            } else {
                $(this).parents(".box-add-attribute").find(".data-grup-required").slideUp("slow");
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
$(document).on("click","#modal-edit-attribute #update-attribute",function(){
    var _button = $(this);
    var name = $("#modal-edit-attribute #name-attribute").val();
    var id = $("#modal-edit-attribute #id-attribute").val();
    var required = $("#modal-edit-attribute .required-field:checked").val();
    var type = $("#modal-edit-attribute #attribute-type").val();
    console.log(type);
    var unit = $("#modal-edit-attribute #unit").val();
    var min_validate = "";
    var max_validate = "";
    var messenger_error = $("#modal-edit-attribute #messenger_error").val();
    var show_search = $(this).parents(".box-add-attribute").find("#show-search").val();
    var validate ="";
    if ((type == "text" || type == "textarea" || type == "number") && $(this).parents(".box-add-attribute").find(".required-value").length > 0) {
        var offset_i = 0;
        $.each($(this).parents(".box-add-attribute").find(".required-value"), function () {
            if($(this).val() != ""){
                if ( !isNaN($(this).val())) {
                    if (offset_i == 0) {
                        validate += '"min_length" : "' + $(this).val() + '"';
                        min_validate = $(this).val();
                    }
                    if (offset_i == 1) {
                        if (validate == "")
                            validate += '"max_length" : "' + $(this).val() + '"';
                        else
                            validate += ',"max_length" : "' + $(this).val() + '"';
                        max_validate = $(this).val();
                    }

                }else{
                    $(this).addClass("warring");
                    return false;
                }
                offset_i++;
            }
        });
        if (validate != "") {
            validate = "{" + validate + "}";
        }
    }
    if (name.trim() != "" && _reset == 0 && id != "") {
            _reset = 1;
            $(_button).append(loading());
            $.ajax({
                url: base_url + "admin/attributes/update_attribute",
                type: "post",
                dataType: "json",
                data: {
                    "id" : id,
                    "name": name,
                    "required": required,
                    "unit" : unit,
                    "validate": validate,
                    "messenger_error" : messenger_error,
                    "show_search" : show_search,
                    "type":type
                },
                success: function (data) {
                    if (data["success"].trim() == "success") {
                       _this.parents(".list-group-item").find("#name-attribute").html(name.trim());
                       $("#modal-edit-attribute").modal("hide"); 
                    }else{
                        alert("error");
                        $("#modal-edit-attribute").modal("hide"); 
                    }
                    _reset = 0;
                    remove_loadding(_button);
                },
                error: function () {
                    remove_loadding(_button);
                    _reset = 0;
                }
            });
        }
    return false;
});
if ($("#box-tree-attribute ul").length > 0) {
    $("#box-tree-attribute ul").sortable({
        connectWith: ">ul",
    });
    $(document).on("mouseover", "#box-tree-attribute ul", function () {
        var level = ">ul";
        if ($(this).data("level") == 1) {
            level = ".level-" + (parseInt($(this).data("level")));
        }
        $(this).sortable({
            connectWith: level,
            stop: function (e, ui) {
                _this = $(this);
                var sort_set = "";
                var element_attr_set = "";
                var sort_set_m = "";
                var element_attr_set_m = "";
                var sort_get = _this.find(">input#sort_get").val();
                var ojb_type = _this.find(">input#sort_get").data("type");
                var emlent = ui.item[0];
                var id_attribute = $(emlent).data("attrid");
                var id_group = $(emlent).parent().parent().data("id");
                var sort_group = $(emlent).parent().find(" > input#element_attr").val();
                $.each(_this.find(">li"), function () {
                    sort_set += $(this).data("id") + ",";
                    element_attr_set += $(this).data("attrid") + ",";
                });
                $.each($(emlent).parent().find(">li"), function () {
                    sort_set_m += $(this).data("id") + ",";
                    element_attr_set_m += $(this).data("attrid") + ",";
                });
                _this.find(">input#sort_get").val(sort_set);
                _this.find(">input#element_attr").val(element_attr_set);
                $(emlent).parent().find(">input#sort_get").val(sort_set_m);
                $(emlent).parent().find(">input#element_attr").val(element_attr_set_m);
                if (_reset == 0 && typeof sort_group != "undefined" && sort_group.indexOf(id_attribute) <= -1 && $(emlent).parent().find(" > input#element_attr").length > 0) {
                    _reset = 1;
                    $.ajax({
                        url: base_url + "admin/attributes/move/",
                        type: "post",
                        dataType: "json",
                        data: {"sort": sort_set_m, "id_attribute": id_attribute, "id_group": id_group},
                        success: function (data) {
                            if (data["success"] = "success") {
                            } else {
                                alert("error");
                            }
                            _reset = 0;
                        },
                        error: function () {
                            _reset = 0;
                            alert("error");
                        }
                    });
                } else {
                    if (sort_set !== sort_get && _reset == 0) {
                        _reset = 1;
                        $.ajax({
                            url: base_url + "admin/attributes/updatesort/" + ojb_type,
                            type: "post",
                            dataType: "json",
                            data: {"sort": sort_set},
                            success: function (data) {
                                if (data["success"] = "success") {

                                } else {
                                    alert("error");
                                }
                                _reset = 0;
                            },
                            error: function () {
                                _reset = 0;
                                alert("error");
                            }
                        });
                    }
                }
            }
        });
    });
}
$(document).on("click", "#save-attribute-child", function () {
    _ajax_this = $(this);
    var data_category = $(this).parents(".box-add-attribute").data("category");
    var parent = _this.parents(".list-group-item").parent().data("attrid");
    var default_values = "";
    $.each($(this).parents(".box-add-attribute").find(".default-values"), function () {
        if ($(this).val() != "") {
            default_values += $(this).val() + "[*_*]";
        }
    });
    var multivalue = $(this).parents(".box-add-attribute").find("#multivalue").val();
    if (_reset == 0 && parent != "" && (default_values != "" || multivalue != "") && data_category != "") {
        _reset = 1;
        $(this).append(loading());
        $.ajax({
            url: base_url + "admin/attributes/add_child",
            type: "post",
            dataType: "json",
            data: {"data_category": data_category, "parent": parent, "default_values": default_values, "multivalue": multivalue},
            success: function (data) {
                if (data["success"] == "success") {
                    var arg_parents = data["response"]['arg_parents'];
                    var html = '';
                    $.each(arg_parents, function (key, value) {
                        html += '<li class="item ui-state-default" data-id="' + value["ID"] + '" data-slug="' + value["Slug"] + '" data-sort="' + value["Sort"] + '">';
                        html += '<div class="list-group-item"><span id="name-attribute">' + value["Name"] + '</span>';
                        html += '<div class="actions">';
                        if (data["type_member"] == _type_member) {
                            html += "<select data-type='attribute' id='change-type' data-id ='" + value["ID"] + "'>";
                            if (value["Type"] == "System") {
                                html += "<option value = 'System' selected>System</option><option value = 'Member'>Member</option>";
                            } else {
                                html += "<option value = 'System'>System</option><option value = 'Member' selected>Member</option>";
                            }
                            html += "</select>";
                        }
                        html += '<a href="#" id="action-edit" data-type ="attribute"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>';
                        html += '<a href="#" id="action-delete" data-type ="attribute"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
                        html += '</div>';
                        html += '</div>';
                        html += '</li>';
                    });
                    _this.parents(".list-group-item").parent().find(">ul").append(html);
                    if (_this.parents(".list-group-item").find(".more").length == 0) {
                        _this.parents(".list-group-item").append('<div class="more close"><i class="fa fa-caret-right"></i></div>');
                    }
                    var sort_set = "";
                    $.each(_this.parents(".list-group-item").parent().find(" >ul > li"), function () {
                        sort_set += $(this).data("id") + ",";
                    });
                    _this.parents(".list-group-item").parent().find(" >ul > #sort_get").val(sort_set);
                    _this.parents(".list-group-item").find(".more").trigger("click");
                } else {
                    alert("error");
                }
                remove_loadding(_ajax_this);
                _reset = 0;
                $("#modal_add_attribute_child").modal("hide");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("error");
                remove_loadding(_ajax_this);
                _reset = 0;
                $("#modal_add_attribute_child").modal("hide");
            }
        });
    }
});