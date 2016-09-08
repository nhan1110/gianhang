<?php if(isset($result) && count($result) > 0) : ?>
 <?php foreach ($result as $key => $value):  ?>
        <li class="comment-item" data-id="<?php echo $value->ID; ?>">
            <?php if($user_id == $value->Member_ID): ?>
                <p class="action-comment">
                    <a href="#" class="edit"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="#" class="delete"><span class="glyphicon glyphicon-remove"></span></a>
                </p>
            <?php endif; ?>
            <div class="comment-body">
            	<div class="comment-author">
                    <?php
                        $avatar=skin_url('images/icon-avatar.png');
                        if(isset($value->Avatar) && $value->Avatar != null) {
                            $avatar = $value->Avatar;
                        }
                    ?>
            		<img width="48" src="<?php  echo $avatar; ?>" alt="...">
            		<cite class="fn"><a href="/profile/index/<?php echo $value->Member_ID; ?>"><?php echo $value->Firstname.' '.$value->Lastname;  ?></a></cite>
            	</div>
            	<p><?php echo @$value->Content;  ?></p>
            </div>
            <div class="comment-footer">
            	<span class="comment-meta"><?php echo @$value->Updatedat;  ?></span>
            </div>
        </li>
  <?php endforeach; ?>
<?php endif; ?>