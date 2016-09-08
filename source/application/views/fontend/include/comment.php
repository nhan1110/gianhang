<section id="rate">
    <h4 class="section-title">Có 12 Đánh giá và Nhận xét</h4>
    <span class="rating">
        <i class="fa fa-star" aria-hidden="true"></i> 
        <i class="fa fa-star" aria-hidden="true"></i> 
        <i class="fa fa-star" aria-hidden="true"></i> 
        <i class="fa fa-star-half-o" aria-hidden="true"></i>
        <i class="fa fa-star-o" aria-hidden="true"></i>
    </span> <strong>4.5 trên 5</strong>
    
    <ul class="rating-list">
        <li class="rating-list-item">
            <span class="rating-item-label ">Hài lòng tuyệt đối</span>
            <span class="rating-item-bar">
               <span class="progress">
                    <span class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:60%"></span>
                </span>
            </span>
            <span class="rating-item-count">1</span>
        </li>
        <li class="rating-list-item">
            <span class="rating-item-label ">Hơn cả mong đợi</span>
            <span class="rating-item-bar">
               <span class="progress">
                    <span class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:60%"></span>
                </span>
            </span>
            <span class="rating-item-count">1</span>
        </li>
        <li class="rating-list-item">
            <span class="rating-item-label ">Hài lòng</span>
            <span class="rating-item-bar">
               <span class="progress">
                    <span class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:60%"></span>
                </span>
            </span>
            <span class="rating-item-count">1</span>
        </li>
        <li class="rating-list-item">
            <span class="rating-item-label ">Dưới trung bình</span>
            <span class="rating-item-bar">
               <span class="progress">
                    <span class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:60%"></span>
                </span>
            </span>
            <span class="rating-item-count">1</span>
        </li>
        <li class="rating-list-item">
            <span class="rating-item-label ">Thất vọng</span>
            <span class="rating-item-bar">
               <span class="progress">
                    <span class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:60%"></span>
                </span>
            </span>
            <span class="rating-item-count">1</span>
        </li>
    </ul>

</section>

<section id="comments">
          <h4 class="section-title">Vui lòng đánh giá và nhận xét về Tên sản phẩm</h4>   
           <div class="comment-form">
              <div class="row">
                 <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2">
                    <a href="#" class="comment-thumb">
                        <?php
                            $ci =& get_instance();
                            $user = $this->session->userdata('user_info');
                            $avatar = skin_url("/images/icon-avatar.png");
                            if (isset($user['avatar']) && $user['avatar'] != null) {
                                if(!preg_match("~^(?:f|ht)tps?://~i", $user['avatar'])){
                                    if(file_exists('.' . $user['avatar'])){
                                        $avatar = $user['avatar'];
                                    }
                                }
                                else{// avatar facebook,google+
                                   $avatar = $user['avatar']; 
                                }
                            }
                        ?>
                        <img src="<?php  echo $avatar; ?>" alt="...">
                    </a>
                 </div>
                 <div class="col-lg-11 col-md-11 col-sm-10 col-xs-10">
                    <div class="form-group">
                        <span class="rating rating-submit">
                            <i class="fa fa-star-o" aria-hidden="true"></i> 
                            <i class="fa fa-star-o" aria-hidden="true"></i> 
                            <i class="fa fa-star-o" aria-hidden="true"></i> 
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                        </span> Nhấn vào đây để đánh giá
                    </div>
                    <div class="form-group">
                       <textarea maxlength="200" onkeypress="if(event.keyCode==13){ func_name(this);}"  class="form-control" rows="3" placeholder="Viết nhận xét..."></textarea>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary">Gửi đánh giá</button>
                    </div>
                    <!--<button class="btn btn-primary">Send <span class="glyphicon glyphicon-arrow-right"></span></button>-->
                 </div>
              </div>
           </div>
          
           <ol class="comment-list">
           </ol>
    
</section>
<script type="text/javascript">
    var start_paging = 0;
    var comment_ajax = true;
    var get_comment = function(){
        $.ajax({
            type: "POST",
            url: "/comment/get_comment/",
            data: {'url' : url , 'start' : start_paging},
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                if(data['status'] == 'success'){
                    $("#comments .comment-list").html(data['responsive']);
                }
            },
            complete: function () {
            }
        });
    }
    var edit_comment= function(element){
        var current=$(element).parent('p');
        var text=$(element).val();
        var comment_id=$(element).attr('data-id');
        if(text!=null && text.trim()!='' && typeof (comment_id) != "undefined" && comment_id!=null){
            current.html('<img style="width:16px;" src="/skins/images/loading.gif" >');
            $.ajax({
                type: "POST",
                url: base_url+"comment/edit/"+comment_id,
                dataType: 'json',
                data: {"content": text},
                success: function (data) {
                   // console.log(data);
                    if (data['status'] == 'success') {
                        current.html(text);
                    }
                },
                complete: function () {
                }
            });
        }
        return false;
    }

    function func_name(element) {
        var parents = $(element).parents('#comments');
        var product_id = parents.attr('data-id');
        var children = $(element).parents('.children');
        var comment_parent_id = 0;
        $('#product-detail .comment-form textarea').val('');
        
        if (typeof (children.attr('class')) != "undefined" && children.attr('class') == 'children') {
            comment_parent_id = children.parents('.comment-item').attr('data-id');
        }
        var value = $(element).val();
        if (value.trim() != null && value.trim() != '') {
            if (comment_parent_id == 0) {
                parents.find('.comment-list').prepend('<li class="comment-item load-comment-before"><img src="/skins/images/loading.gif "style="width: 15px;"></li>');
            } else {
                children.find('.content-comment').after('<li class="comment-item load-comment-before"><img src="/skins/images/loading.gif "style="width: 15px;"></li>');
            }
            $.ajax({
                type: "POST",
                url: base_url + "comment/add/",
                dataType: 'json',
                data: {
                    "url": url,
                    "content": value,
                    "parent_id": comment_parent_id
                },
                success: function (data) {
                    //console.log(data);
                    if (data['status'] == 'success') {
                        parents.find('.load-comment-before').hide().remove();
                        var image = base_url+'skins/images/icon-avatar.png';
                        if (data['responsive']['avatar'] != null) {
                            image = data['responsive']['avatar'];
                        }

                        var num_reply = 0;
                        if (data['count_comment_children'] != null) {
                            num_reply = data['responsive']['count_comment_children'];
                        }

                        var html = '<li class="comment-item" data-id="' + data['responsive']['comment_id'] + '">';
                        html += '     <p class="action-comment">';
                        html += '       <a href="#" class="edit"><span class="glyphicon glyphicon-pencil"></span></a>';
                        html += '       <a href="#" class="delete"><span class="glyphicon glyphicon-remove"></span></a> ';
                        html += '     </p>';
                        html += '     <div class="comment-body">';
                        html += '       <div class="comment-author ss">';
                        html += '           <img width="48" src="' + image + '" alt="...">';
                        html += '           <cite class="fn"><a href="/profile/index/'+data['responsive']['user_id']+'">' + data['responsive']['full_name'] + '</a></cite>';
                        html += '       </div>';
                        html += '       <p><strong>Tiêu đề nhận xét</strong> - ' + data['responsive']['content'] + '</p>';
                        html += '     </div>';
                        html += '     <div class="comment-footer">';
                        if (comment_parent_id == 0) {
                            html += '    <span class="comment-reply"><a href="">Trả lời</a> (' + num_reply + ')</span>';
                            html += '    <span class="separator"></span>';
                        }
                        html += '    <span class="comment-meta">' + data['responsive']['date'] + '</span>';
                        html += ' </div>';
                        if (comment_parent_id == 0) {
                            html += '<ul class="children"></ul>'
                        }
                        html += '</li>';
                        if (comment_parent_id == 0) {
                            parents.find('.comment-list').prepend(html);
                        } else {
                            if (children.find('li').length > 1) {
                                children.find('.content-comment').after(html);
                            } else {
                                children.append(html);
                            }
                        }
                        $(element).val('');
                    }
                },
                complete: function () {
                    parents.find('.load-comment-before').hide().remove();
                }
            });
        }
        return false;
    }


    $(document).ready(function(){
        $(window).load(function(){
            get_comment();
        });

        $(document).on('click', '#comments .comment-list .comment-reply', function () {
            var parents = $(this).parents('.comment-item');
            if (parents.find('.children li').length <= 0) {
                parents.find('.children').append('<li class="comment-item content-comment"><input type="text" maxlength="200" onkeypress="if(event.keyCode==13){ func_name(this);}" class="form-control" placeholder="Viết bình luận ..."></li>');
            }
            else{
                parents.find('.children').find('input[type="text"].form-control').focus();
            }
            return false;
        });

        $(document).on('click', '#comments .load-more-parent', function () {
            var parents = $(this).parents('#comments');
            var element = $(this);
            element.html('<img style="width:16px;" src="'+base_url+'/skins/images/loading.gif" >');
            start_paging++;
            if(comment_ajax){
                comment_ajax = false;
                $.ajax({
                    type: "POST",
                    url: base_url + "comment/get_comment/",
                    data: {"start": start_paging,"url": url },
                    dataType: 'json',
                    success: function (data) {
                        if(data['status'] == 'success'){
                            parents.find(".comment-list").append(data['responsive']);
                        }
                        element.hide().remove();
                    },
                    complete: function () {
                        element.hide().remove();
                        comment_ajax = true;
                    }
                });
            }
            return false;
        });

        $(document).on('click', '#comments .comment-list .load-more', function () {
            $(this).html('<img style="width:16px;" src="/skins/images/loading.gif" >');
            var parents = $(this).parents('.children').parents('.comment-item');
            var data_offset = $(this).parents('.children').attr('data-offset');
            var data_count = $(this).parents('.children').attr('data-count');
            var comment_id = parents.attr('data-id');
            if(typeof (comment_id) == "undefined" || comment_id == null || isNaN(data_offset)){
                data_offset = 0;
            }

            if (typeof (comment_id) != "undefined" && comment_id != null) {
                data_offset++;
                $(this).parents('.children').attr('data-offset',data_offset);
                if(comment_ajax){
                    comment_ajax = false;
                    $.ajax({
                        type: "POST",
                        url: base_url + "comment/get_more_comment/" + comment_id,
                        data: {"url": url,'offset': data_offset},
                        dataType: 'json',
                        success: function (data) {
                            if(data['status'] == 'success'){
                                parents.find('.load-more').parent().before(data['responsive']);
                            }
                            if(data_count <= 3*data_offset + 3){
                                parents.find('.load-more').hide();
                            }
                        },
                        complete: function () {
                            parents.find('.load-more').html('Xem thêm ...');
                            comment_ajax = true;
                        }
                    });
                }
            }
            return false;
        });

        $(document).on('click', '#comments .action-comment .edit', function () {
            var children=$(this).parents('.children');
            var comment_id=$(this).parent('.action-comment').parent('.comment-item').attr('data-id');
            if (typeof (children.attr('class')) != "undefined" && children.attr('class') == 'children') {
                var content = children.find('.comment-item[data-id="'+comment_id+'"] .comment-body p').text();
                children.find('.comment-item[data-id="'+comment_id+'"] .comment-body p').html('<textarea class="edit-comment" data-id="'+comment_id+'" maxlength="200" onkeypress="if(event.keyCode==13){ edit_comment(this);}" style="width: 100%;min-height: 50px;">'+content+'</textarea><span class="cancel-edit"><a href="#">Cancel</a></span>');
                children.find('.comment-item[data-id="'+comment_id+'"] .comment-body p textarea').focus();
            }
            else{
                var content = $(this).parent('.action-comment').parent('.comment-item').find('.comment-body:first p').text();
                $(this).parent('.action-comment').parent('.comment-item').find('.comment-body:first p').html('<textarea class="edit-comment" data-id="'+comment_id+'" style="width: 100%;min-height: 50px;" maxlength="200" onkeypress="if(event.keyCode==13){ edit_comment(this);}">'+content+'</textarea><span class="cancel-edit"><a href="#">Cancel</a></span>');;
                $(this).parent('.action-comment').parent('.comment-item').find('.comment-body:first p textarea').focus();
            }
            $(this).hide();
            return false;
        });

        $(document).on('click', '#comments .comment-list .cancel-edit', function () {
            $(this).parent('p').parent('.comment-body').parent('.comment-item').find('.edit').show();
            var content = $(this).parent('p').find('textarea').val();
            $(this).parent('p').html(content);
            return false;
        });

        $(document).on('click', '#comments .comment-list .action-comment .delete', function () {
            var parents=$(this).parent('.action-comment').parent('.comment-item');
            var comment_id=parents.attr('data-id');
            if(typeof (comment_id) != "undefined" && comment_id!=null){
                $.ajax({
                    type: "POST",
                    url: base_url + "comment/delete/"+comment_id,
                    dataType: 'json',
                    data: {},
                    success: function (data) {
                        if(data['status']=='success'){
                            parents.fadeOut('slow',function(){
                                parents.remove();
                            });
                        }
                    },
                    complete: function(){

                    }
                });
            }
            return false;
        });

    });
</script>
<style type="text/css">
    #comments .action-comment{
        position: absolute;
        right: 0px;
        top: 0;
        z-index: 100;
    }
    ol > .comment-item,
    ul > .comment-item{
        position: relative;
    }
</style>