
        <? if ($comments >= 1): ?>
        <div style="padding:3px; height:200px; overflow: auto;">
          <?
              while ($comment = dbarray($comments_array)) {
              
                echo '<div style="border-bottom: 1px solid #E6E6E6; margin-bottom: 10px;">';
                echo 'Posted by: <strong>';
                
                  if ($comment['uwebsite']){
                    echo '<a rel="nofollow" href="redirect.php?url='.$comment['uwebsite'].'">'.$comment['uname'].'</a>';
                  } else {
                    echo $comment['uname'];
                  }
                
                echo '</strong> @ '.$comment['date'];
                echo '<br />';
                echo '<div style="color:#000000; padding-left:5px;">'.SpecialChars($comment['comment']).'</div>';
                echo '</div>';
              
              }
          ?>
		  </div>
        <? endif; ?>