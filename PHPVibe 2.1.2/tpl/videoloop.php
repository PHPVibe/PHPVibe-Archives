<?php

function videoThumb($vid) {
global $config;

if($config->video->thumbs == "1"){
$thumb_link = $site_url.'com/timthumb.php?src=http://i4.ytimg.com/vi/'.$vid.'/0.jpg'.'&h=125&w=200&crop&q=100';
} else {
$thumb_link = 'http://i4.ytimg.com/vi/'.$vid.'/0.jpg';
}

return $thumb_link;

}

function showVideoList($videosData,$criteria) {
		global $site_url;
		$pageNumber = $criteria['pageNumber'];
		$nb_display = $criteria['nb_display'];

		
		$nbTotal=$videosData['stats']['totalResults'];
		if($pageNumber=='') $pageNumber = 1;
		
		// patch for favorite's user videos
		if($nbTotal==0) {
			$nbTotal = count($videosData['videos']);
		}
		
		$start = $nb_display*$pageNumber-$nb_display;
		
		$videoType=0; //0=youtube
		
		
		$criteria3['nbTotal'] = $nbTotal;
		$criteria3['start'] = $start;
		$criteria3['nb_display'] = $nb_display;
		
		$j = 1;
		for($i=0;$i<count($videosData['videos']);$i++) {
		
			
			$videoThumbnail =  videoThumb($videosData['videos'][$i]['videoid']);
			$title =  mb_substr($videosData['videos'][$i]['title'], 0, 29,'utf-8');
			$full_title = $videosData['videos'][$i]['title'];
			$url = $site_url.'video/'.$videosData['videos'][$i]['videoid'].'/'.seo_clean_url($full_title) .'/';
			
			$viewCount = $videosData['videos'][$i]['viewCount'];
			
			if (($j % 3 == 0)) { $the_float ="class=\"last\"";} else { $the_float ="";}
			
			
echo '<li style="margin-right:30px; margin-bottom:18px;" '.$the_float.'>
      <div class="content" style="width:200px;">
	  <div class="preview" style="height:125px;">
	  <div class="picture">
	  <div class="alpha">';
echo '<a href="'.$url.'" title="'.$full_title.'"><img src="'.$videoThumbnail.'" alt="'.$full_title.'" width="200" height="125"/></a></div>';
echo '<div class="date"><a class="button red small icon clock" href="'.$url.'" >'.sec2hms($videosData['videos'][$i]['duration']).'</a><a class="button red small icon refresh repeat" href="http://www.youtube.com/watch?v='.$videosData['videos'][$i]['videoid'].'">Repeat &nbsp;</a></div></div></div>
<div class="title"><a href="'.$url.'" title="'.$full_title.'">'.$title.'</a></div>
</div>
</li>
';
$j++;
		}
		
		if(count($videosData['videos'])==0) {
			echo 'Huston we have a problem! Damn alliens have unplugged the search again! <br /> We will fix it asap! Try a refresh...';
		}
		
		
	}

function ShowComments($videoid){
 global $VidCache;
	    $VidCache->SetTtl(600000);
		 $cache_file= "com_".$videoid;  
		 
		if(!$com_list = $VidCache->Load("$cache_file")){
$comments_url = "https://gdata.youtube.com/feeds/api/videos/".$videoid."/comments";
$commentsFeed = simplexml_load_file( $comments_url );    
$com_list= "<div class=\"comment-data\">";
$i = 0;
foreach( $commentsFeed->entry as $comment ) 
			{
			 if(++$i > 8)  break;
	
			
				$com_list.= "<div class=\"emComment emComment_status_\" id=\"comment_\" >
				  <div class=\"emCommentImage\"> 
				  <img src=\"".$site_url."tpl/images/userPic.png\" width=\"32\" height=\"32\"/>
                    </div>
				<span class=\"emSenderName\">".$comment->author->name."</span> : ".$comment->content." </div>";
	
			}
$com_list.= "</div>";
if(!empty($com_list)):
$VidCache->Save($com_list, "$cache_file");
endif;
}
return $com_list;		
}	

	
?>