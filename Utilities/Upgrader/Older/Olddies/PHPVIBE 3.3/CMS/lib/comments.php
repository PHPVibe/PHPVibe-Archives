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
if( is_user() ){
    $html = '<div id="emAddComment_'.$object_id.'" class="emAddComment">
                <form method="post" action="'.site_url().'ajax/addComment.php" onsubmit="return false;">
				 <input type="text" placeholder="'._lang('enterComment').'" id="addEmComment_'.$object_id.'" class="addEmComment auto" name="comment" />
				  <div class="sendBtn" style="z-index:2;">  <input type="submit" class="buttonS sBlue" id="emAddButton_'.$object_id.'" value="'._lang('comment').'" onclick="addEMComment(\''.$object_id.'\')" /></div>
                   <input type="hidden" name="object_id" value="'.$object_id.'" />
   </form>
              </div>';
}
    // -- form output ------------------------------------------------
   // $total    =  $totals->nr;
	if($comments) {
      
    $html     .= '<div id="emContent_'.$object_id.'" class="comment-list block full">';
	 foreach( $comments as $comment) {
	 if($comment->vote){            
            $likeText = commentLikeText($comment->rating_cache - 1);
        }else{
            $likeText = '<a href="javascript:iLikeThisComment('.$comment->id.')" title="'._lang('ilike').'"> <i class="icon-thumbs-up icon-large"></i>  </a>';
            if($comment->rating_cache){
                $likeText .= ' &mdash; '.commentLikeText($comment->rating_cache,false);
            }
        }
    $html .= ' <article id="comment-id-'.$comment->id.'" class="comment-item media arrow-left">
<a class="pull-left thumb-small com-avatar" href="'.profile_url($comment->sender_id,$comment->name).'"><img src="'.thumb_fix($comment->avatar).'"></a>
<section class="media-body panel">
<header class="panel-heading clearfix">
<a href="'.profile_url($comment->sender_id,$comment->name).'">'.print_data(stripslashes($comment->name)).'</a> - '.time_ago($comment->created).' <span class="text-muted m-l-small pull-right" id="iLikeThis_'.$comment->id.'">'.$likeText.'</span>
</header>
<div>'.print_data(stripslashes($comment->comment_text)).'</div>
                
              </section>
</article>
';
}
 $html .= '</div>';

} else {
 $html .= '<div id="emContent_'.$object_id.'" class="comment-list block full">';
 $html .= '</div>';
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
                return _lang('You and one');
            }else{
                return str_replace('XXX',$total,_lang('You and XXX'));
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