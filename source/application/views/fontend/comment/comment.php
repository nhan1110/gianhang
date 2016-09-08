<?php if(isset($result) && $result != null): ?>
  <?php foreach ($result as $key => $item) { ?>
      <?php
          $member = new Member();
          $comment = new Comments();
          $sqc = "SELECT count(*) AS count
              FROM $comment->table AS c
              INNER JOIN $member->table AS m ON m.ID = c.Member_ID
              WHERE c.URL = '$url' AND c.Parent_ID = '$item->ID'";

          $sql = "SELECT c.*,m.Avatar,m.Firstname,m.Lastname
              FROM $comment->table AS c
              INNER JOIN $member->table AS m ON m.ID = c.Member_ID
              WHERE c.URL = '$url' AND c.Parent_ID = '$item->ID'
              ORDER BY c.ID DESC
              LIMIT 0,3";
          $count_comment_children = $comment->query($sqc);
          $comment_children = $comment->query($sql);
      ?>
    	<li class="comment-item" data-id="<?php echo @$item->ID; ?>">
    		<?php if($user_id == @$item->Member_ID): ?>
	    		<p class="action-comment">
  	    			<a href="#" class="edit"><span class="glyphicon glyphicon-pencil"></span></a>
  	    			<a href="#" class="delete"><span class="glyphicon glyphicon-remove"></span></a>
	    		</p>
	    	<?php endif; ?>
    		<div class="comment-body">
      			<div class="comment-author">
                <?php
                    $avatar=skin_url('images/icon-avatar.png');
                    if(isset($item->Avatar) && $item->Avatar!=null) {
                        $avatar = $item->Avatar;
                    }
                ?>
        				<img width="48" src="<?php  echo $avatar;  ?>" alt="...">
        				<cite class="fn"><a href="/profile/index/<?php echo @$item->Member_ID; ?>"><?php echo @$item->Firstname.' '.@$item->Lastname;  ?></a></cite>
      			</div>
      			<p><?php echo @$item->Content;  ?></p>
    		</div>
    		<div class="comment-footer">
      			<span class="comment-reply"><a href="#">Trả lời</a> (<?php echo @$count_comment_children->count;  ?>)</span>
      			<span class="separator"></span> 
      			<span class="comment-meta"><?php echo @$item->Updatedat;  ?></span>
    		</div>
    		<ul class="children" data-offset="0" data-count="<?php echo @$count_comment_children->count;  ?>">
            <?php
              if(isset($comment_children->ID) && $comment_children->ID !=null ) { ?>
                  <li class="comment-item content-comment">
                      <input type="text" onkeypress="if(event.keyCode==13){ func_name(this);}" class="form-control" maxlength="200" placeholder="Viết bình luận ...">
                  </li>
                  <?php foreach($comment_children as  $key => $value): ?>
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
                  <?php endforeach;?>
                  <?php if(isset($count_comment_children->count) && $count_comment_children->count > 3 ): ?>
                      <li class="comment-item text-center" style="margin-bottom: 10px;">
                          <a href="#" class="load-more">Xem thêm ...</a>
                      </li>
                  <?php endif; ?>
              <?php } ?>
    		</ul>
    	</li>
  <?php } ?>
  <?php if(isset($count->count) && $count->count >= $current):?>
        <p class="text-center load-more-parent"><a href="#">Xem thêm ...</a></p>
  <?php endif;?>
<?php endif;?>