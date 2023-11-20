<?php  function show_comments($object_id) {
global $user,$site_url, $lang, $CCOUNT , $SHOWNAME, $SHOWMAIL, $ALLOWLIKE;
//get comments from database
 $comments   = dbquery("SELECT DISTINCT em_comments . * , em_likes.vote , users.display_name, users.avatar
FROM em_comments
LEFT JOIN em_likes ON em_comments.id = em_likes.comment_id
LEFT JOIN users ON em_comments.sender_id = users.id
WHERE object_id =  '".$object_id."'
ORDER BY  em_comments.created desc limit 0,10000");

    // -- form output ------------------------------------------------
    $total    = mysql_num_rows($comments);
    $counter  = 1;
    $html     = '<div id="emContent_'.$object_id.'" class="emContent">';
    
    if($total > $CCOUNT){
        $html .= '<div class="emShowAllComments" id="emShowAllComments_'.$object_id.'">
                    <a href="javascript:viewAllComments(\''.$object_id.'\');">'.$lang['view'].' <span id="total_em_comments_'.$object_id.'">'.$total.'</span> </a> <noscript><em>This page needs JavaScript to display all comments</em></noscript>
                  </div>
                  <div class="emHideAllComments" id="emHideAllComments_'.$object_id.'" style="display: none;">
                    <a href="javascript:hideAllComments(\''.$object_id.'\');">'.$lang['hide'].' </a>
                  </div>';
    }
    
	while($comment= mysql_fetch_array($comments)) {
       
            if($comment['sender_id']){
                $comment['sender_name'] = '<a href="'.$site_url.'user/'.$comment['sender_id'].'/'.$comment['display_name'].'">'. $comment['display_name'].'</a>';
            }
            $sender = '<span class="emSenderName">'.$comment['sender_name'].'</span>';
       
        
        
        if($comment['vote']){            
            $likeText = commentLikeText($comment['rating_cache']-1);
        }else{
            $likeText = '<a href="javascript:iLikeThisComment('.$comment['id'].')" title="'.$lang['ilike'].'"><img src="'.$site_url.'tpl/images/icons/gray_18/heart.png" alt="'.$lang['ilike'].'"/>  </a>';
            if($comment['rating_cache']){
                $likeText .= ' &mdash; '.commentLikeText($comment['rating_cache'],false);
            }
        }
        
        
        $html .= '<div class="emComment emComment_'.$object_id.' '.($counter < ($total - ($CCOUNT - 1))?'emHiddenComment emHiddenComment_'.$object_id:'').'" id="comment_'.$comment['id'].'" '.($counter < ($total - ($CCOUNT - 1))?'style="display:none"':'').'>
                    <div class="emCommentImage">';
				
				  $html .= ' <a href="'.$site_url.'user/'.$comment['sender_id'].'/'.$comment['display_name'].'"><img src="'.$site_url.'com/timthumb.php?src='.$comment['avatar'].'&h=36&w=37&crop&q=100" width="37" height="36" alt="'.$comment['display_name'].'" />
                    </a></div>';
						
                  
					
                    $html .= ' <div class="emCommentText">
                        '.$sender.' <span class="ago"> '.time_ago($comment['created']).'</spanl>
						<div class="emCommentLike" style="'.($ALLOWLIKE?'':'display:none;').'">
                            <span id="iLikeThis_'.$comment['id'].'">
                               <em>'.$likeText.'</em>                              
                            </span>
                        </div>
						<p class="com_txt">'.stripslashes($comment['comment_text']).' </p>                       
                    </div> </div>';
        $counter++;
    }
    $html .= '</div>';

if( $user->isAuthorized() ){
    $html .= '<div id="emAddComment_'.$object_id.'" class="emAddComment">
                <form method="post" action="'.$site_url.'components/addComment.php" onsubmit="return false;">
				 <input type="text" placeholder="'.$lang['enterComment'].'" id="addEmComment_'.$object_id.'" class="addEmComment" name="comment">
				  <div class="sendBtn">  <input type="submit" class="buttonS LBlue" id="emAddButton_'.$object_id.'" value="'.$lang['comment'].'" onclick="addEMComment(\''.$object_id.'\')" /></div>

                    <span '.($SHOWNAME?'':'style="display: none;"').' id="emNameSpan_'.$object_id.'" class="emNameSpan">
                        <label for="addEmName_'.$object_id.'">'.$lang['name'].':</label>
                        <input type="text" placeholder="'.$lang['enterName'].'" id="addEmName_'.$object_id.'" class="addEmName" name="sender_name" />
                    </span>

                    <span '.($SHOWMAIL?'':'style="display: none;"').' id="emMailSpan_'.$object_id.'">
                        <label for="addEmMail_'.$object_id.'">'.$lang['mail'].':</label>
                        <input type="text" placeholder="'.$lang['enterMail'].'" id="addEmMail_'.$object_id.'" class="addEmMail" name="sender_id" />
                    </span>

                   

                    <input type="text"   name="email"     value="" id="addEmPot_'.$object_id.'" class="addEmPot" />
                    <input type="hidden" name="object_id" value="'.$object_id.'" />

                   
                   
                </form>
              </div>';
}
    //send reply to client
    return '<div id="'.$object_id.'" class="emComments" object="'.$object_id.'" class="ignorejsloader">'.$html.'</div>';

}
 ?>