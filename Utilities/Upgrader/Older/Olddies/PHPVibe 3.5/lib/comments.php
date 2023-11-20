<?php  
function comments() {
global $video;
if (get_option('video-coms') == 1) {
//Facebook comments
return '<div id="coments" class="fb-comments" data-href="'.video_url($video->id,$video->title).'" data-width="470" data-num-posts="15" data-notify="true"></div>						
';
} else {
return show_comments('video_'.$video->id);
}


}

function show_comments($object_id, $limit=50000, $moreurl = null, $ALLOWLIKE = true) {
global $db;
$CCOUNT = $limit;
$html = '';
//get comments from database
//$totals = $db->get_row("SELECT count(*) as nr from ".DB_PREFIX."em_comments WHERE object_id =  '".$object_id."'");
$comments   = $db->get_results("SELECT ".DB_PREFIX."em_comments . * , ".DB_PREFIX."em_likes.vote , ".DB_PREFIX."users.name, ".DB_PREFIX."users.avatar
FROM ".DB_PREFIX."em_comments
LEFT JOIN ".DB_PREFIX."em_likes ON ".DB_PREFIX."em_comments.id = ".DB_PREFIX."em_likes.comment_id
LEFT JOIN ".DB_PREFIX."users ON ".DB_PREFIX."em_comments.sender_id = ".DB_PREFIX."users.id
WHERE object_id =  '".$object_id."'
ORDER BY  ".DB_PREFIX."em_comments.id desc limit 0,".$limit."");

    // -- form output ------------------------------------------------
   // $total    =  $totals->nr;
   $uhtml = '';
   if( is_user() ){
    $uhtml .= '<li class="addcm">
	<img class="avatar" src="'.thumb_fix(user_avatar(), true, 55, 55).'">
	<div class="message">
<span class="arrow"> </span>
<a class="name" href="'.profile_url(user_id(), user_name()).'">'.user_name().'</a>
                <form class="body" method="post" action="'.site_url().'ajax/addComment.php" onsubmit="return false;">
				 <textarea placeholder="'._lang('Write your comment').'" id="addEmComment_'.$object_id.'" class="addEmComment auto" name="comment" /></textarea>
				  <button type="submit" class="buttonS " id="emAddButton_'.$object_id.'" onclick="addEMComment(\''.$object_id.'\')" /><i class="icon-check"></i></button>
                   <input type="hidden" name="object_id" value="'.$object_id.'" />
   </form>
  </div></li>';
}
	if($comments) {
	
      
    $html     .= '<ul id="emContent_'.$object_id.'" class="chat full">';
	$ci = 1;
	 foreach( $comments as $comment) {
	$cls = ($ci % 2 == 0) ? "right" : "left";
	 if($comment->vote){            
            $likeText = commentLikeText($comment->rating_cache - 1);
        }else{
            $likeText = '<a class="tipS" href="javascript:iLikeThisComment('.$comment->id.')" title="'._lang('Like this comment').'"> <i class="icon-heart icon-large"></i>  </a>';
            if($comment->rating_cache){
                $likeText .= ' &mdash; '.commentLikeText($comment->rating_cache,false);
            }
        }
    $html .= ' <li id="comment-id-'.$comment->id.'" class="'.$cls.'">
<img class="avatar" src="'.thumb_fix($comment->avatar, true, 55, 55).'">
<div class="message">
<span class="arrow"> </span>
<a class="name" href="'.profile_url($comment->sender_id,$comment->name).'">'.print_data(stripslashes($comment->name)).'</a> <span class="date-time"> '.time_ago($comment->created).' </span> <span class="like-com" id="iLikeThis_'.$comment->id.'">'.$likeText.'</span>
<span class="body">'._html($comment->comment_text).'</span>
</div>
</li>
';
$ci++;
}
$html .=  $uhtml;
 $html .= '</ul>';

} else {
 $html .= '<ul id="emContent_'.$object_id.'" class="chat full">';
 $html .=  $uhtml;
 $html .= '</ul>';

}

    //send reply to client
    return '<div id="'.$object_id.'" class="emComments" object="'.$object_id.'" class="ignorejsloader">'.$html.'</div>';

}

function commentLikeText($total, $me=true){
        global $lang;
        
        if($me){
            if($total == 0){
                return _lang('You like this');
            }elseif($total == 1){
                return _lang('You +1 like this');
            }else{
                return str_replace('XXX',$total,_lang('You and XXX others like this'));
            }       
        }else{
            if($total == 1){
                return _lang('One like');
            }else{
                return str_replace('XXX',$total,_lang('XXX like this'));
            }
        }
    }	
 ?>