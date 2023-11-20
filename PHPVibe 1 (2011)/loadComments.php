<?php
    require_once('req/funcs.inc.php');
    ## check if there is a moderation action ###
    #
    $actionType     = null;
    $actionComleted = false;
    if($_GET['emAct'] and $_GET['emCommentKey'] and $_GET['emCommentID'] and $_GET['emCommentOID']){
        //check if the comment exists and I have access
        if($comment = $db->query("SELECT * FROM em_comments WHERE id = ".(int)$_GET['emCommentID']." AND object_id = ".(int)$_GET['emCommentOID']." AND access_key = ".$db->quote($_GET['emCommentKey']))->fetch()){
            switch($_GET['emAct']){
                case 'delete':  {
                                    $actionCompleted = true;
                                    $actionType      = 'delete';
                                    $db->query("DELETE FROM em_comments WHERE id = ".(int)$_GET['emCommentID']." AND object_id = ".(int)$_GET['emCommentOID']." AND access_key = ".$db->quote($_GET['emCommentKey']));
                                    break;
                                }
                                
                case 'allow':   {
                                    $actionCompleted = true;
                                    $actionType      = 'allow';
                                    $db->query("UPDATE em_comments SET visible = '1' WHERE id = ".(int)$_GET['emCommentID']." AND object_id = ".(int)$_GET['emCommentOID']." AND access_key = ".$db->quote($_GET['emCommentKey']));
                                    break;
                                }
            }
        }        
    }
    #
    ## end check ###############################



    //get comments from database
    $myip       = ip2long($_SERVER['REMOTE_ADDR']);
    $comments   = $db->query("SELECT DISTINCT
                                    em_comments.*,
                                    em_likes.vote
                                FROM em_comments 
                                LEFT JOIN em_likes ON em_comments.id = em_likes.comment_id AND em_likes.sender_ip = ".$myip."                                    
                                WHERE 
                                    object_id = ".$db->quote($object_id)." AND
                                    visible   = '1'
                                ORDER BY id")->fetchAll();

    // -- form output ------------------------------------------------
    $total    = count($comments);
    $counter  = 1;
    $html     = '<div id="emContent_'.$object_id.'" class="emContent">';
    
    if($actionCompleted){
        $html .= '<div class="emInfoMessage">';
        $html .= $lang['cid'].' '.(int)$_GET['emCommentID'].' '.$lang['wassuc'].' '.($actionType=='delete'?$lang['deleted']:$lang['moderated']).'!';
        $html .= '</div>';
    }
    
    if($total > $CCOUNT){
        $html .= '<div class="emShowAllComments" id="emShowAllComments_'.$object_id.'">
                    <a href="javascript:viewAllComments(\''.$object_id.'\');">'.$lang['view'].' <span id="total_em_comments_'.$object_id.'">'.$total.'</span> '.$lang['view2'].'</a> <noscript><em>This page needs JavaScript to display all comments</em></noscript>
                  </div>
                  <div class="emHideAllComments" id="emHideAllComments_'.$object_id.'" style="display: none;">
                    <a href="javascript:hideAllComments(\''.$object_id.'\');">'.$lang['hide'].' <span id="total_em_comments_to_hide_'.$object_id.'">'.$total.'</span> '.$lang['view2'].'</a>
                  </div>';
    }
    
    foreach($comments as $comment){
        if($comment['sender_name']){
            if($comment['sender_id']){
                $comment['sender_name'] = jsEncode($comment['sender_id'], $comment['sender_name']);
            }
            $sender = '<span class="emSenderName">'.$comment['sender_name'].'</span>: ';
        }else{
            $sender = '';
        }
        
        
        if($comment['vote']){            
            $likeText = commentLikeText($comment['rating_cache']-1);
        }else{
            $likeText = '<a href="javascript:iLikeThisComment('.$comment['id'].')">'.$lang['ilike'].'</a>';
            if($comment['rating_cache']){
                $likeText .= ' &mdash; '.commentLikeText($comment['rating_cache'],false);
            }
        }
        
        
        $html .= '<div class="emComment emComment_'.$object_id.' '.($counter < ($total - ($CCOUNT - 1))?'emHiddenComment emHiddenComment_'.$object_id:'').'" id="comment_'.$comment['id'].'" '.($counter < ($total - ($CCOUNT - 1))?'style="display:none"':'').'>
                    <div class="emCommentImage">
                        <img src="'.$comment['sender_ip'].'" width="32" height="32" alt="Gravatar" />
                    </div>
                    <div class="emCommentText">
                        '.$sender.stripslashes($comment['comment_text']).'                        
                    </div>
                    <div class="emCommentInto">                        
                        '.strftime($DATEFORMAT,strtotime($comment['created'])).'
     
                        <div class="emCommentLike" style="'.($ALLOWLIKE?'':'display:none;').'">
                            <span id="iLikeThis_'.$comment['id'].'">
                                <em>'.$likeText.'</em>                               
                            </span>
                        </div>

                    </div>
                  </div>';
        $counter++;
    }
    $html .= '</div>';

if( $user->isAuthorized() ){
    $html .= '<div id="emAddComment_'.$object_id.'" class="emAddComment">
                <form method="post" action="commentanything/php/addComment.php" onsubmit="return false;">
                    <span '.($SHOWNAME?'':'style="display: none;"').' id="emNameSpan_'.$object_id.'" class="emNameSpan">
                        <label for="addEmName_'.$object_id.'">'.$lang['name'].':</label>
                        <input type="text" placeholder="'.$lang['enterName'].'" id="addEmName_'.$object_id.'" class="addEmName" name="sender_name" />
                    </span>

                    <span '.($SHOWMAIL?'':'style="display: none;"').' id="emMailSpan_'.$object_id.'">
                        <label for="addEmMail_'.$object_id.'">'.$lang['mail'].':</label>
                        <input type="text" placeholder="'.$lang['enterMail'].'" id="addEmMail_'.$object_id.'" class="addEmMail" name="sender_id" />
                    </span>

                    <textarea placeholder="'.$lang['enterComment'].'" id="addEmComment_'.$object_id.'" class="addEmComment" name="comment"></textarea>

                    <input type="text"   name="email"     value="" id="addEmPot_'.$object_id.'" class="addEmPot" />
                    <input type="hidden" name="object_id" value="'.$object_id.'" />

                    <span class="emButton">
                        <input type="submit" class="emButton" id="emAddButton_'.$object_id.'" value="'.$lang['comment'].'" onclick="addEMComment(\''.$object_id.'\')" />
                    </span>
                </form>
              </div>';
}
    //send reply to client
    echo '<div id="'.$object_id.'" class="emComments" object="'.$object_id.'" class="ignorejsloader">'.$html.'</div>';
