<?php

class Vbox_display_class {
	
	
	function getSocialShareButtons($url) {
		$facebookShareLink="http://www.facebook.com/share.php?u=".$url;
		$twitterShareLink="http://twitter.com/share?url=".$url."&related=Montreal_city";
		$googlebuzzShareLink="http://www.google.com/buzz/post?url=".$url;
		$favosaurusShareLink = 'http://favosaurus.com/share?u='.$url;
		
		$embedCode .= '<table width=100% style="margin-top:5px;"><tr>';
		$embedCode .= '<td style="text-align:right;">';
		$embedCode .= '<a href="javascript:openPopup(\''.$favosaurusShareLink.'\',\'1080\',\'650\');" title="Share on Favosaurus"><img src="'.$GLOBALS['path_vbox'].'include/graph/social32/favosaurus.png" style="padding-top:2px"></a>&nbsp;';
		$embedCode .= '<a href="javascript:openPopup(\''.$googlebuzzShareLink.'\',\'800\',\'400\');" title="Share on Google buzz"><img src="'.$GLOBALS['path_vbox'].'include/graph/social32/google-buzz.png" style="padding-top:2px"></a>&nbsp;';
		$embedCode .= '<a href="javascript:openPopup(\''.$twitterShareLink.'\',\'800\',\'400\');" title="Share on Twitter"><img src="'.$GLOBALS['path_vbox'].'include/graph/social32/twitter.png" style="padding-top:2px"></a>&nbsp;';
		$embedCode .= '<a href="javascript:openPopup(\''.$facebookShareLink.'\',\'800\',\'400\');" title="Share on Facebook"><img src="'.$GLOBALS['path_vbox'].'include/graph/social32/facebook.png" style="padding-top:2px"></a>&nbsp;';
		$embedCode .= '</td></tr></table>';
		return $embedCode;
	}
	
	function displayVideosList($videosData,$criteria) {
		$type = $criteria['type'];
		
		//type=1: facebook type display
		if($type==1) {
			$this->displayVideosListFacebookLikeByVideosDatas($videosData,$criteria);
		}
		elseif($type==2) {
			$this->display_videos_list_mb_slider($videosData,$criteria);
		}
	}
	
	function display_videos_list_mb_slider($videosData,$criteria) {
		$pageNumber = $criteria['pageNumber'];
		$nb_display = $criteria['nb_display'];
		
		$nbTotal=$videosData['stats']['totalResults'];
		if($pageNumber=='') $pageNumber = 1;
		
		// patch for favorite's user videos
		if($nbTotal==0) {
			$nbTotal = count($videosData['videos']);
		}
		
		$start = $nb_display*$pageNumber-$nb_display;
		
		for($i=0;$i<count($videosData['videos']);$i++) {
			$videoid = $videosData['videos'][$i]['videoid'];
			$videoThumbnail = $videosData['videos'][$i]['thumbnail'];
			$title = $videosData['videos'][$i]['title'];
			$url = $videosData['videos'][$i]['url'];
			$duration = $videosData['videos'][$i]['duration'];
			$viewCount = $videosData['videos'][$i]['viewCount'];
			
			echo '<a href="'.$url.'" class="youtube_vid videoPlayBox">';
			echo '<img src="'.$videoThumbnail.'" class="thumbnail" style="width:80px; height:55px; margin-right:10px; margin-bottom:10px;" border=0>';
			echo '<span class="play"></span>';
			echo '</a> ';
		}
		
		$criteria3['nbTotal'] = $nbTotal;
		$criteria3['start'] = $start;
		$criteria3['nb_display'] = $nb_display;
		
		$this->display_pagination($criteria3);
		
		?>
		
		<?php
	}
	
	function displayVideosListFacebookLikeByVideosDatas($videosData,$criteria) {
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
		
		// display head menu
		$criteria3['nbTotal'] = $nbTotal;
		$criteria3['start'] = $start;
		$criteria3['nb_display'] = $nb_display;
		
		//$this->displayMenuPaginationNumber($criteria3);
		
		//$this->display_pagination($criteria3);
		//echo '<br>';
		
		$gf1 = new Vbox_general_functions_class;
		$j = 1;
		for($i=0;$i<count($videosData['videos']);$i++) {
		
			$videoid = $videosData['videos'][$i]['videoid'];
			$videoThumbnail = 'http://i4.ytimg.com/vi/'.$videoid.'/0.jpg';
			$title = substr($videosData['videos'][$i]['title'], 0, 29);
			$full_title = str_replace("\"", "",$videosData['videos'][$i]['title']);
			//$med_title = substr($videosData['videos'][$i]['title'], 0, 30);
			$url = $site_url.'video/'.$videoid.'/'.seo_clean_url($full_title) .'/';
			$duration = $videosData['videos'][$i]['duration'];
			$viewCount = $videosData['videos'][$i]['viewCount'];
			
			if (($j % 3 == 0)) { $the_float ="class=\"last\"";} else { $the_float ="";}
			
			
echo '<li style="margin-right:30px; margin-bottom:18px;" '.$the_float.'>
      <div class="content" style="width:200px;">
	  <div class="preview" style="height:125px;">
	  <div class="picture">
	  <div class="alpha">';
echo '<a href="'.$url.'" title="'.$full_title.'"><img src="'.$videoThumbnail.'" alt="'.$full_title.'" class ="resizeme" style="width:200px; height:125px;" /></a></div>';
echo '<div class="date"><a class="button red small icon clock" href="'.$url.'" >'.sec2hms($duration).'</a></div><div class="comment"><a class="button red small icon refresh repeat" href="http://www.youtube.com/watch?v='.$videoid.'">Repeat &nbsp;</a></div></div></div>
<div class="title"><a href="'.$url.'" title="'.$full_title.'">'.$title.'</a></div>
</div>
</li>
';
$j++;
		}
		
		if(count($videosData['videos'])==0) {
			echo 'No results found';
		}
		
		//echo '<br>';
		
		//$this->display_pagination($criteria3);
	}
}
	
?>