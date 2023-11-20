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
echo '<div class="date">'.sec2hms($duration).'</div><div class="comment"><a class="repeat" href="http://www.youtube.com/watch?v='.$videoid.'">Repeat &nbsp;</a></div></div></div>
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
	
	/*
	function displayMenuPaginationNumber($criteria) {
		$jsName = $criteria['jsName'];
		$jsCriteria = $criteria['jsCriteria'];
		$nbTotal = $criteria['nbTotal'];
		$pageNumber = $criteria['pageNumber'];
		$nb_display = $criteria['nb_display'];
		$headTitle = $criteria['headTitle'];
		$dom = $criteria['dom'];
		$noCount = $criteria['noCount'];
		$jsLeft = $criteria['jsLeft'];
		$jsRight = $criteria['jsRight'];
		
		if($jsLeft=='') $jsLeft = $jsName.'(\''.$dom.'\',\''.($pageNumber-1).'\',\''.$jsCriteria.'\')';
		if($jsRight=='') $jsRight = $jsName.'(\''.$dom.'\',\''.($pageNumber+1).'\',\''.$jsCriteria.'\')';
		
		//echo '<table border=0 width="100%" cellpadding=0 cellspacing=0 style="border-collapse:collapse"><tr><td style="padding:2px">';
		//if($nbTotal>$nb_display) {
			echo '<table width=100% border=0 class="titleHeaderBox">';
			echo '<tr>';
				if($noCount!=1) echo '<td style="padding:3px"><b>'.number_format($nbTotal).' '.$headTitle.'</b></td>';
				else echo '<td style="padding:3px"><b>'.$headTitle.'</b></td>';
				if($nbTotal>$nb_display) {
					echo '<td align="right" style="padding:3px">';
					echo '<a id="'.$dom.'_reload"></a>&nbsp;';
					if($pageNumber>1) { 
						echo '&nbsp; <a href="javascript:" onClick="'.$jsLeft.'" title="'.htmlentities('Previous').'">
						<img src="/'.$GLOBALS['path_vbox'].'include/graph/icons/leftarrow.png" style="padding-bottom:3px;" border=0></a>';
					}
					if($pageNumber>0) echo '&nbsp;<small><b>'.$pageNumber.'/'.ceil($nbTotal/$nb_display).'</b></small>';
					if($nbTotal>($nb_display*$pageNumber)) {
						echo ' <a href="javascript:" onClick="'.$jsRight.'" title="Next">
						<img src="/'.$GLOBALS['path_vbox'].'include/graph/icons/rightarrow.png" style="padding-bottom:3px;" border=0></a>';
					}
					echo '&nbsp;</td>';
				}
			echo '</tr>';
			echo '</table>';
			echo '<table><tr height=5><td></td></tr></table>';
		//}
		//echo '</td></tr></table>';
	}
	*/
	
	// Pagination general function
	function display_pagination($criteria) {
		$nbTotal = $criteria['nbTotal'];
		$start = $criteria['start'];
		$nb_display = $criteria['nb_display'];
		$nbPageMax = $criteria['nbPageMax'];
		
		if($nbPageMax=='') $nbPageMax=10;
		
		// Pagination display
		if($nb_display!=0) $begin = $start/$nb_display;
		$debut = $begin-round($nbPageMax/2);
		$fin = $begin+round($nbPageMax/2);
		if($nb_display!=0) $nbPageResult = $nbTotal/$nb_display;
		
		/*
		echo '$nbTotal: '.$nbTotal.'<br>';
		echo '$start: '.$start.'<br>';
		echo '$nb_display: '.$nb_display.'<br>';
		*/
		
		if($nbTotal>0 && $nbTotal>$nb_display) {
			if($fin<$nbPageMax)$fin = $nbPageMax;
			if($debut<0)$debut = 0;
			$previous = $begin-1;
			$next = $begin+1;
			
			echo '<center>';
			if($previous>=0) {
				$tmpStart = ($previous*$nb_display);
				echo '<a class="vbox_pagination" href="#" title="'.($previous+1).'"><small><<</small></a>&nbsp;'; //($previous+1)
			}
			
			for ($i=$debut; $i<$fin && $i<$nbPageResult;$i++) {
			  $d = $i+1;
			  $start = $i*$nb_display;
			  $tmpStart = $start;
			  
			  if ($i == $begin)  echo '<font color="red"><small>'.$d.'</small>&nbsp;</font>';
			  else {
			  	echo '<a class="vbox_pagination" href="#" title="'.($i+1).'"><small>'.$d.'</small></a>&nbsp;'; //($i+1)
			  }
			}
			
			if($next<$nbPageResult) {
				$tmpStart = ($next*$nb_display);
				echo '&nbsp;<a class="vbox_pagination" href="#" title="'.($next+1).'"><small>>></small></a>'; //($next+1)
			}
			echo '</center>';
		}
	}

}
	
?>