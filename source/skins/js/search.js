var _reset_page = 0;
var _number_of_pages = null ; 
var _current_page = 0;
var _min_price  = null;
var _max_price  = null;
var _attribute  = [];
var _categories = [];
var _type_set = ["category-type", "categories", "attribute"];
var _sorted_by = null;
var _country = null;
var box_inner = $("#box-product");
var bnt_more = $("#more-product");
var progress = 95;
var width_progress = 0;
$(document).ready(function(){
    get_all_page(true);
    if($("#price-range").length > 0){
        var percentSlide = $('#price-range').slider();
        percentSlide.on("slide", function(ev){
            var value = ev.value;
            $(".price-range .tooltip-inner").html("");
            var text_tip = fomat_string(value[0]+"")+"vnd : " +fomat_string(value[1]+"")+"nvd";
            $(".price-range .tooltip-inner").html(text_tip);
        });
        percentSlide.on("slideStop", function(ev){
           _current_page = 0;
           var value = ev.value;
           _min_price = value[0];
           _max_price = value[1];
           get_result_product(false);
        });
        var value = ($(".price-range .tooltip-inner").html()).split(":" );
        if(value != null){
            var text_tip = fomat_string(value[0]+"")+"vnd : " +fomat_string(value[1]+"")+"nvd";
            _min_price = value[0];
            _max_price = value[1];
            $(".price-range .tooltip-inner").html(text_tip);
        }
    }
    $("#box-filter-search ul li input.styled").click(function(){
        var type_click = $(this).data("type");
        var parents = $(this).parent().parent().find("ul");
        if(parents.find("li").length > 0){
            if(!$(this).is(':checked')){
                parents.find("input[type=checkbox]").prop( "checked",false);
            }else{
                parents.find("input[type=checkbox]").prop( "checked",true);
            }
        }
        //return parent .
        var lenght_cheked = $(this).parent().parent().parent().find("> li > .checkbox input[type=checkbox]:checked").length;
        var all_cheked = $(this).parent().parent().parent().find("> li > .checkbox input[type=checkbox]").length;
        if(lenght_cheked >= all_cheked ){
            $(this).parent().parent().parent().parent().find("> .checkbox input[type=checkbox]").prop("checked",true).addClass("select");
        }else{
          $(this).parent().parent().parent().parent().find("> .checkbox input[type=checkbox]").prop("checked",false).removeClass("select");;   
        }
        if($.inArray(type_click, _type_set ) > -1 ){
            switch (type_click) {
                case "category-type":
                    _category_type = $(this).val();
                    break;
                case "categories":
                    _categories = [] ;
                    $.each($(this).parents("#box-filter-search").find("li input[type=checkbox]:checked"),function(){
                        _categories.push($(this).val());
                    });
                    break;
                case "attribute":
                    _attribute = [];
                    $.each($(this).parents("#box-filter-search").find("li input[type=checkbox]:checked"),function(){
                        _attribute.push($(this).val());
                    });
                    break;
            }
            _current_page = 0;
            get_result_product(false);
        }
    });
    $("#sorted_by").change(function(){
        _current_page = 0;
        _sorted_by = $(this).val();
        get_result_product(false);
    });
    $(document).on("click","#more-product",function(){
        $(this).append(loading());
        if(_current_page == 0){
            _current_page = 1;
        }
    	if(_current_page < _number_of_pages){
    		get_result_product(true);
    	}       
    });
    $(document).on("change","#filter-country .selectpicker",function(){
        if(_reset == 0){
            _reset = 1;
            _this = $(this);
            var box_set = $("#"+_this.data("find"));
            var id = $(this).val();
            var level = $(this).data("level");
            var i = 1;
            _country = "null";
            box_set.prop('disabled', true);
            box_set.find("option").prop("selected", false);
            box_set.find("#default").prop("selected", true);
            box_set.parents(".bootstrap-select").addClass("disabled").find(".dropdown-toggle").addClass("disabled"); 
            box_set.parents(".bootstrap-select").find(".dropdown-toggle .pull-left").text(box_set.attr("title"));        
            box_set.val("null");
            var parent_find = $("#"+box_set.data("find"));
            if(typeof parent_find !== "undefined"){
                parent_find.val("null");
                parent_find.find("option").prop("selected", false);
                parent_find.find("#default").prop("selected", true);
                parent_find.parents(".bootstrap-select").addClass("disabled").find(".dropdown-toggle").addClass("disabled");
                parent_find.prop('disabled', true);
                parent_find.parents(".bootstrap-select").find("ul.dropdown-menu").html('<li data-original-index="'+i+'"><a tabindex="0" data-tokens="null"><span class="text">'+parent_find.attr("title")+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>');
                parent_find.html('<option class="bs-title-option" value="">'+parent_find.attr("title")+'</option><option value="null" id="default">'+parent_find.attr("title")+'</option>')    
                parent_find.parents(".bootstrap-select").find(".dropdown-toggle .pull-left").text(parent_find.attr("title"));
            } 
            $.each($("#filter-country .selectpicker:not(.disabled)"),function(){
                if($(this).val() != "" && $(this).val() != "null" && $(this).val() != null){
                    _country = $(this).val();
                }   
            });
            _current_page = 0;
            get_result_product(false);
            $.ajax({
                url: base_url + "countrys/get_districts",
                type: 'POST',
                dataType: 'json',
                data: {
                    "id": id,
                    "level": level,
                    "category_type":_category_type
                }, success: function (data, textStatus, jqXHR) {
                    var html = '';
                    var html_dr = '';
                    html_dr = '<li data-original-index="'+i+'"><a tabindex="0" data-tokens=""><span class="text">'+box_set.attr("title")+'</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
                    html = '<option class="bs-title-option" value="null">'+box_set.attr("title")+'</option><option value="null" id="default">'+box_set.attr("title")+'</option>';
                    if (data.length > 0) {
                        $.each(data, function (key, value) {
                            var order =  (value["Order"] != null && value["Order"] != "") ? value["Order"] : "0";
                            i++;
                            html_dr += '<li data-original-index="'+i+'"><a tabindex="0" data-tokens=""><span class="text">'+ value["Levels"] + " " + value["Name"]  +'<span class="count"> ('+order+')</span></span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>';
                            html += '<option value="' + value["ID"] + '">' + value["Levels"] + " " + value["Name"] + '<span class="count"> ('+order+')</span></option>';
                        });
                        box_set.prop('disabled', false);
                        box_set.parents(".bootstrap-select").removeClass("disabled").find(".dropdown-toggle").removeClass("disabled");

                    }
                    box_set.parents(".bootstrap-select").find("ul.dropdown-menu").html(html_dr);
                    box_set.html(html);
                    _reset = 0;
                }, error: function (jqXHR, textStatus, errorThrown) {
                    _reset = 0;
                }
            });
        }
       
    });
});
function get_all_page(more_product) {
    _reset_page = 1;
    var page = _total_product / _number_product_on_page;
    page = ("" + page).split(".");
    if (page.length > 1) _number_of_pages = parseInt(page[0]) + 1; else  _number_of_pages = parseInt(page[0]);
    if(more_product == true) _current_page ++; else _current_page = 0;
    if(_current_page >= _number_of_pages || more_product == false && _number_of_pages == 1) $("#more-product").hide(); else $("#more-product").show();
    _reset_page = 0;
}
function befor_search(more_product){
    $("#progress #bar-success").css({"width": "0","height":"0"});
    progress = 95;
    width_progress = 0;
    progress_bar();
    if(more_product == false){
        box_inner.html("");
    }
}
function progress_bar(){
    setTimeout(function(){
        if(progress < 100){
            width_progress = width_progress + 0.1;
            if(width_progress <= 95){
                $("#progress #bar-success").css({"width":width_progress+"%","height":"3px"});
            }
            progress_bar();
        }else{
            $("#progress #bar-success").css({
                "width": "100%",
                "height":"3px"
            });
            setTimeout(function(){
                $("#progress #bar-success").css({
                    "width": "0",
                    "height":"0"
                });
            },1000);
        }
    },10);
}
function get_result_product(more_product){
    if(_reset_page == 0){
        _reset_page = 1;
        $.ajax({
            url  : base_url + "search/filter",
            beforeSend:befor_search(),
            type : "post",
            dataType: "json",
            data:{
                "current_uri"   : _current_uri,
                "keyword"       : _keyword,
                "category_type" : _category_type,
                "attribute"     : _attribute,
                "categories"    : _categories,
                "min_price"     : _min_price,
                "max_price"     : _max_price,
                "current_page"  : _current_page,
                "sorted_by"     : _sorted_by,
                "country"       : _country
            },
            success:function(res){
                search_success(res,more_product);
                get_all_page(more_product);
            },
            error:function(res){
                console.log(res);
                get_all_page(more_product);
            }
        }).done(after_search(more_product));
    }
    
}
function search_success(data,more_product){
    if(data["status"] == "success"){
        progress = 100;
        if(more_product == false){
            box_inner.html(data["responsive"]);
        }else{
            box_inner.append(data["responsive"]);
        }
        _number_product_on_page  = data["product_on_page"];
        _total_product  = data["total_product"];
        $(".total-product #number-total").html("Đã tìm thấy <strong>"+_total_product+"</strong> bài viết liên quan.");
        remove_loadding($("#more-product"));

    }
}
function after_search(more_product){
    if(more_product == false){
        var offset = $("body #box-product").offset();
        $("body").animate({scrollTop:0}, '500');
    }
}