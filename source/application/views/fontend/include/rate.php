<div class="rate" id="rate_view"></div>
<?php
   $ci =& get_instance();
   $user = $this->session->userdata('user_info');
   if(isset($user) && $user != null) :
?>
    <div id="rate-modal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content" style="position: relative;">
          <div class="custom-loading" style="bottom: 0;">
            <div>
                <i class="ic ic-md ic-loading"></i>
            </div>
          </div>
          <div class="modal-header" style="padding: 5px 15px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <?php
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
                    <img width="40" style="border-radius: 50%;margin-right: 10px;border: 1px solid #ccc;" class="avatar" src="<?php echo $avatar; ?>">
                    Bài viết đánh giá của <?php echo @$user['first_name'] . ' ' . @$user['last_name']; ?>
                </h4>
          </div>
          <div class="modal-body">
              <div class="form-group">
                 <label>Tiêu đề đánh giá:</label>
                 <input type="text" class="form-control" id="title-rate" placeholder="Tiêu đề đánh giá">
              </div>
              <div class="form-group">
                 <label>Nội dung đánh giá:</label>
                 <textarea name="content" id="content-rate" class="form-control" rows="6" placeholder="Hãy cho người khác biết suy nghỉ của bạn về sản phẩm này."></textarea>
                 <small>Phần lớn các bài đánh giá hữu ích đều có từ 50 từ trở lên</small>
              </div>
              <div class="form-group row">
                <div class="col-md-5 col-xs-12">
                    <div class="choose-rate">
                        <span class="rating" style="font-size:30px;"> 
                            <?php 
                              for($i = 1; $i<=5 ; $i++):
                                echo '<i class="fa fa-star-o" data-index="'.$i.'" aria-hidden="true"></i>';
                              endfor;
                            ?>
                        </span>
                        <input type="hidden" name="num_rate" id="num-rate">
                    </div>
                </div>
                <div class="col-md-7 col-xs-12">
                    <div class="g-recaptcha" id="g-recaptcha-review"></div>
                </div>
              </div>
              <div class="form-group text-right">
                  <button type="submit" class="btn btn-default" data-dismiss="modal">Hủy</button>
                  <button type="submit" class="btn btn-primary send_rate">Gửi</button>
              </div>
          </div>
        </div>
      </div>
    </div>
<?php endif; ?>
<script src="<?php echo skin_url(); ?>/js/rate.js" type="text/javascript"></script>
<style type="text/css">
    .btn-rate-active.btn{
        background-color: #ffc107;
        border-color: #ffc107;
        color:#fff !important;
    }
    .choose-rate .rate-average{
        background: url('../../skins/images/rate.png') 0 -40px repeat-x;
        width: 210px;
        height: 40px;
        display: block;
        margin-top: -10px;
        overflow: hidden;
    }
    .choose-rate .rate-average span{
        background-position: 0 0;
        background-image: url('../../skins/images/rate.png');
        background-repeat: repeat-x;
        height: 40px;
        display: block;
        width: 0;
    }
    .review-block .wrap-rate-content{
        position: relative;
    }
    .review-block .wrap-rate-content:last-child hr{
        display: none;
    }
    .review-block .wrap-rate-content .rate-loading-wrap{
        position: absolute;
        background-color: #FAFAFA;
        top: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 100;
    }
    .review-block .wrap-rate-content .rate-loading-wrap p{
        margin-bottom: 0;
        position: absolute;
        left: 0;
        width: 100%;
        top: 80%;
    }
    .border-error{
        border:1px solid red !important;
    }
    i.hover{
        color: #ec971f;
    }
    i.rate-active{
        color: #feaf02;
    }
    i.rate-active:before,
    i.hover:before{
        content: "\f005";
    }
</style>