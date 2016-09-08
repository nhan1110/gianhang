<section id="rate">
    <h4 class="section-title">
        <?php 
            if($count > 0) {
                echo 'Có <span class="count-rate">'.$count.'</span> Đánh giá và Nhận xét.';
            }
            else{
                echo 'Chưa có Đánh giá và Nhận xét nào.';
            }
        ?>
    </h4>
    <span class="rating" style="font-size:24px;">
        <?php 
            $num_rate = 0;
            $temp = 0;
            if(isset($average) && $average!=null && is_numeric($average)){
                $num_rate = $average;
            }
            for ($i = 1; $i <= $num_rate ; $i++) { 
                $temp++;
                echo '<i class="fa fa-star" aria-hidden="true"></i>';
            }
            if($num_rate - $temp > 0){
               $temp++;
               echo '<i class="fa fa-star-half-o" aria-hidden="true"></i>'; 
            }
            for ($i = $temp; $i < 5 ; $i++) { 
               echo '<i class="fa fa-star-o" aria-hidden="true"></i>';
            }
        ?>
    </span>
    <strong><?php echo @$average; ?> trên 5</strong>
    
    <ul class="rating-list">
        <li class="rating-list-item">
            <?php $num_5 = isset($tracking_rate->Num_5) && $tracking_rate->Num_5 != null ? $tracking_rate->Num_5 : 0; ?>
            <span class="rating-item-label">Hài lòng tuyệt đối</span>
            <span class="rating-item-bar">
               <span class="progress">
                    <span class="progress-bar progress-bar-5" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $count == 0 ? 0 : ($num_5/$count)*100; ?>%"></span>
                </span>
            </span>
            <span class="rating-item-count tracking-num-5"><?php echo $num_5; ?></span>
        </li>
        <li class="rating-list-item">
            <?php $num_4 = isset($tracking_rate->Num_4) && $tracking_rate->Num_4 != null ? $tracking_rate->Num_4 : 0; ?>
            <span class="rating-item-label">Hơn cả mong đợi</span>
            <span class="rating-item-bar">
               <span class="progress">
                    <span class="progress-bar progress-bar-4" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $count == 0 ? 0 : ($num_4/$count)*100; ?>%"></span>
                </span>
            </span>
            <span class="rating-item-count tracking-num-4"><?php echo $num_4; ?></span>
        </li>
        <li class="rating-list-item">
            <?php $num_3 = isset($tracking_rate->Num_3) && $tracking_rate->Num_3 != null ? $tracking_rate->Num_3 : 0; ?>
            <span class="rating-item-label">Hài lòng</span>
            <span class="rating-item-bar">
               <span class="progress">
                    <span class="progress-bar progress-bar-3" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $count == 0 ? 0 : ($num_3/$count)*100; ?>%"></span>
                </span>
            </span>
            <span class="rating-item-count tracking-num-3"><?php echo $num_3; ?></span>
        </li>
        <li class="rating-list-item">
            <?php $num_2 = isset($tracking_rate->Num_2) && $tracking_rate->Num_2 != null ? $tracking_rate->Num_2 : 0; ?>
            <span class="rating-item-label">Dưới trung bình</span>
            <span class="rating-item-bar">
               <span class="progress">
                    <span class="progress-bar progress-bar-2" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $count == 0 ? 0 : ($num_2/$count)*100; ?>%"></span>
                </span>
            </span>
            <span class="rating-item-count tracking-num-2"><?php echo $num_2; ?></span>
        </li>
        <li class="rating-list-item">
            <?php $num_1 = isset($tracking_rate->Num_1) && $tracking_rate->Num_1 != null ? $tracking_rate->Num_1 : 0; ?>
            <span class="rating-item-label">Thất vọng</span>
            <span class="rating-item-bar">
               <span class="progress">
                    <span class="progress-bar progress-bar-1" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $count == 0 ? 0 : ($num_1/$count)*100; ?>%"></span>
                </span>
            </span>
            <span class="rating-item-count tracking-num-1"><?php echo $num_1; ?></span>
        </li>
    </ul>
    <?php   
        $ci =& get_instance();
        $user = $this->session->userdata('user_info');
        if(isset($user) && $user != null) :
    ?>
        <a href="#" class="btn btn-primary btn-add-edit-rate" data-toggle="modal" data-target="#rate-modal">Viết đánh giá</a>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <hr/>
            <div class="review-block">
               <div class="wrap-rate-content">
                <?php if(isset($result->ID) && $result->ID != null): ?>
                    <?php foreach ($result as $key => $value) : ?>
                        <div class="row" data-id="<?php echo @$value->ID; ?>">
                            <div class="col-sm-2 text-center" style="padding-right:0;">
                                <?php
                                    $avatar = skin_url('images/icon-avatar.png');
                                    if(isset($value->Avatar) && $value->Avatar!=null) {
                                        $avatar = $value->Avatar;
                                    }
                                ?>
                                <img style="margin: 0 auto;border-radius:50%;" width="80" src="<?php echo $avatar; ?>" class="img-rounded img-responsive">
                                <div class="review-block-name"><a href="#"><?php echo @$value->Firstname.' '.@$value->Lastname; ?></a></div>
                                <div class="review-block-date"><?php echo date('d-m-Y',strtotime(@$value->Createdat)); ?></div>
                            </div>
                            <div class="col-sm-10" style="padding-left:0;">
                                <div class="review-block-rate">
                                   <span class="rating" style="font-size:24px;"> 
                                        <?php 
                                          for($i = 1; $i<=5 ; $i++):
                                             if($i <= $value->Num_Rate){
                                                echo '<i class="fa fa-star" aria-hidden="true"></i>';
                                             } 
                                             else{
                                                echo '<i class="fa fa-star-o" aria-hidden="true"></i>';
                                             }
                                          endfor;
                                        ?>
                                   </span>
                                </div>
                                <h4 class="rate-title"><?php echo @$value->Title; ?></h4>
                                <div class="review-block-description"><?php echo @$value->Content; ?></div>
                            </div>
                        </div>
                        <hr/>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <h4 class="text-center rate-not-foundt">Chưa có đánh giá nào.</h4>
                    <?php endif;?>
               </div>
               <?php if($count > 6): ?>
                    <div class="row">
                        <div class="col-sm-12 text-center nav-paging"></div>
                    </div>
               <?php endif; ?>
            </div>
        </div>
    </div>
</section>   
<!--<div class="row">
    <div class="col-md-4 col-sm-5">
        <div class="rating-block">
            <h4>Đánh giá</h4>
            <h2 class="bold padding-bottom-7"><span class="average-rate"><?php echo @$average; ?></span> <small>/ 5</small></h2>
            <div class="row">
                <div class="col-sm-8">
                    <div class="choose-rate">
                        <span class="rate-average">
                            <span></span>
                        </span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <?php   
                        $ci =& get_instance();
                        $user = $this->session->userdata('user_info');
                        if(isset($user) && $user != null) :
                    ?>
                        <a href="#" class="btn btn-primary btn-add-edit-rate" data-toggle="modal" data-target="#rate-modal">Viết đánh giá</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-5">
        <h4>
            <?php 
                if($count > 0) {
                    echo 'Có <span class="count-rate">'.$count.'</span> đánh giá sản phẩm này.';
                }
                else{
                    echo 'Chưa có đánh giá nào.';
                }
            ?>
            
        </h4>
        <div class="pull-left">
            <?php $num_5 = isset($tracking_rate->Num_5) && $tracking_rate->Num_5 != null ? $tracking_rate->Num_5 : 0; ?>
            <div class="pull-left" style="width:35px; line-height:1;">
                <div style="height:9px; margin:5px 0;">5 <span class="glyphicon glyphicon-star"></span></div>
            </div>
            <div class="pull-left" style="width:180px;">
                <div class="progress" style="height:9px; margin:8px 0;">
                    <div class="progress-bar progress-bar-success progress-bar-5" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $count == 0 ? 0 : ($num_5/$count)*100; ?>%">
                        <span class="sr-only"></span>
                    </div>
                </div>
            </div>
            <div class="pull-right tracking-num-5" style="margin-left:10px;"><?php echo $num_5;  ?></div>
        </div>
        <div class="pull-left">
            <?php $num_4 = isset($tracking_rate->Num_4) && $tracking_rate->Num_4 != null ? $tracking_rate->Num_4 : 0; ?>
            <div class="pull-left" style="width:35px; line-height:1;">
                <div style="height:9px; margin:5px 0;">4 <span class="glyphicon glyphicon-star"></span></div>
            </div>
            <div class="pull-left" style="width:180px;">
                <div class="progress" style="height:9px; margin:8px 0;">
                    <div class="progress-bar progress-bar-primary progress-bar-4" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $count == 0 ? 0 : ($num_4/$count)*100; ?>%">
                        <span class="sr-only"></span>
                    </div>
                </div>
            </div>
            <div class="pull-right tracking-num-4" style="margin-left:10px;"><?php echo $num_4; ?></div>
        </div>
        <div class="pull-left">
            <?php $num_3 = isset($tracking_rate->Num_3) && $tracking_rate->Num_3 != null ? $tracking_rate->Num_3 : 0; ?>
            <div class="pull-left" style="width:35px; line-height:1;">
                <div style="height:9px; margin:5px 0;">3 <span class="glyphicon glyphicon-star"></span></div>
            </div>
            <div class="pull-left" style="width:180px;">
                <div class="progress" style="height:9px; margin:8px 0;">
                    <div class="progress-bar progress-bar-info progress-bar-3" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $count == 0 ? 0 : ($num_3/$count)*100; ?>%">
                        <span class="sr-only"></span>
                    </div>
                </div>
            </div>
            <div class="pull-right tracking-num-3" style="margin-left:10px;"><?php echo isset($tracking_rate->Num_3) && $tracking_rate->Num_3 != null ? $tracking_rate->Num_3 : 0; ?></div>
        </div>
        <div class="pull-left">
            <?php $num_2 = isset($tracking_rate->Num_2) && $tracking_rate->Num_2 != null ? $tracking_rate->Num_2 : 0; ?>
            <div class="pull-left" style="width:35px; line-height:1;">
                <div style="height:9px; margin:5px 0;">2 <span class="glyphicon glyphicon-star"></span></div>
            </div>
            <div class="pull-left" style="width:180px;">
                <div class="progress" style="height:9px; margin:8px 0;">
                    <div class="progress-bar progress-bar-warning progress-bar-2" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $count == 0 ? 0 : ($num_2/$count)*100; ?>%">
                        <span class="sr-only"></span>
                    </div>
                </div>
            </div>
            <div class="pull-right tracking-num-2" style="margin-left:10px;"><?php echo $num_2; ?></div>
        </div>
        <div class="pull-left">
            <?php $num_1 = isset($tracking_rate->Num_1) && $tracking_rate->Num_1 != null ? $tracking_rate->Num_1 : 0; ?>
            <div class="pull-left" style="width:35px; line-height:1;">
                <div style="height:9px; margin:5px 0;">1 <span class="glyphicon glyphicon-star"></span></div>
            </div>
            <div class="pull-left" style="width:180px;">
                <div class="progress" style="height:9px; margin:8px 0;">
                    <div class="progress-bar progress-bar-danger progress-bar-1" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $count == 0 ? 0 : ($num_1/$count)*100; ?>%">
                        <span class="sr-only"></span>
                    </div>
                </div>
            </div>
            <div class="pull-right tracking-num-1" style="margin-left:10px;"><?php echo $num_1; ?></div>
        </div>
    </div>
</div>-->
