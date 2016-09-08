<?php if(isset($result) && $result != null): ?>
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
                <div class="review-block-date"><?php echo date('d-m-Y s:i:H',strtotime(@$value->Createdat)); ?></div>
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
<?php endif;?>