        </div>
        <!--/.site-main-->
        <footer class="site-footer">
            <div class="footer-top">
                <div class="footer-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <ul>
                                    <span style="margin-right:20px;">KẾT NỐI</span>
                                    <li><a href="" title="Facebook" class="fb"><i class="fb-color fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="" title="Twitter" class="tw"><i class="tw-color fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="" title="Google-plus" class="gg"><i class="gg-color fa fa-google-plus" aria-hidden="true"></i></a></li>
                                    <li><a href="" title="Linkedin" class="lk"><i class="lk-color fa fa-linkedin" aria-hidden="true"></i></a></li>
                                    <li><a href="" title="Instagram" class="interg"><i class="interg-color fa fa-instagram" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                            <div class="col-md-3 text-center">ĐĂNG KÝ NHẬN TIN</div>
                            <div class="col-md-5">
                                <div class="input-group"> 
                                    <input class="form-control" placeholder="Địa chỉ email">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit">ĐĂNG KÝ</button>
                                    </span> 
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            	$pages = new Pages();
            	$pages->where(array('ID' => 13))->get(1);
            	echo $pages->Page_Content;
            ?>
        </div>
                        
        <div class="footer-bottom">
          <div class="container">
              <p class="copyright">Gianhangcuatoi © 2016 gianhangcuatoi.com. All rights reserved.</p>
          </div>
        </div>
        <?php $this->load->view("fontend/include/messenger_box");?>
        <?php $this->load->view("fontend/include/error_messenger");?>
        <?php $this->load->view("fontend/include/events");?>
        <?php $this->load->view("fontend/include/fixed-bar-left");?>
    </footer>
</div>
<!--/.site-page-->
</body>
<script src="<?php echo skin_url("js/search.js");?>" type="text/javascript"></script>
</html>