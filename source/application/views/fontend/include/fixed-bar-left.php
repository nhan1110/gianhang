<div class="fixed-bar fixed-bar-right fixed-bar-dark hidden-xs">
    <ul class="fixed-bar-list">
        <li class="item item-header">
            <a href="<?php echo base_url('tai-khoan/chinh-sua-thong-tin/'); ?>"><span class="item-icon"><i class="fa fa-user" aria-hidden="true"></i></span><span class="item-text">Tài <br>khoản</span></a>
        </li>
        <li class="item">
            <a href="<?php echo base_url('/yeu-thich/'); ?>"><span class="item-icon"><i class="fa fa-heart" aria-hidden="true"></i></span><span class="item-text">Yêu  <br>thích</span></a>
        </li>
        <li class="item">
            <a href="<?php echo base_url('/da-xem/'); ?>"><span class="item-icon"><i class="fa fa-eye" aria-hidden="true"></i></span><span class="item-text">Đã  <br>xem</span></a>
        </li>
        <li class="item item-footer">
            <a href=""><span class="item-icon"><i class="fa fa-question-circle" aria-hidden="true"></i></span><span class="item-text">Hỗ trợ</span></a>
        </li>
        <li class="item item-footer">
            <a href="javascript:void(0);" class="btn-top" title="Page top" style="display:none;" ><span class="item-icon"><i class="fa fa-arrow-up" aria-hidden="true"></i></span><span class="item-text">Đầu  <br>trang</span></a>
        </li>
    </ul>
</div>
</style>
<script type="text/javascript">
jQuery(document).ready(function($){     
    if(jQuery(".btn-top").length > 0){
        jQuery(window).scroll(function () {
            var e = $(window).scrollTop();
            if (e > 500) {
                jQuery(".btn-top").show()
            } else {
                jQuery(".btn-top").hide()
            }
        });
        jQuery(".btn-top").click(function () {
            jQuery('body,html').animate({
                scrollTop: 0
            })
        })
    }       
});
</script>