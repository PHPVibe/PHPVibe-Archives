<?php

class Vbox_class {
	
	
	function display_vbox_js_css() {
		?>
		<script type='text/javascript'> 
		/* <![CDATA[ */
		var Vbox = {
			ajaxurl: "<?=$GLOBALS['path_vbox']?>"
		};
		/* ]]> */
		</script>
		<?php
		echo "\n";
		echo '<link rel="stylesheet" type="text/css" href="'.$GLOBALS['path_vbox'].'include/css/style.css" media="screen">'."\n";
		echo '<script type="text/javascript" src="'.$GLOBALS['path_vbox'].'include/js/js_videos.js"></script>'."\n\n";
	}
	
	function getVimeoVideoData($videoCode) {
		$url = 'http://vimeo.com/api/v2/video/'.$videoCode.'.php';
		$contents = @file_get_contents($url);
		$thumb = @unserialize(trim($contents));
		$thumbnail = $thumb[0][thumbnail_small];
		$videoData['thumbnail'] = $thumbnail;
		return $videoData;
	}
	
	function getVideoDataFromUrl($url) {
		
		// Youtube
		if(preg_match("/http:\/\/www.youtube.com\/watch\?v=/", $url, $matches)) {
			$videoCode = str_replace($matches[0],"",$url);
			$pos = stripos($videoCode,'&');
			if($pos!='') $videoCode = substr($videoCode,0,$pos);
			$videoData['type'] = 0; //0=youtube
			$videoData['videoCode'] = $videoCode;
			$videoData['thumbnail'] = 'http://img.youtube.com/vi/'.$videoCode.'/1.jpg';
		}
		elseif(preg_match("/http:\/\/www.youtube.com\/v\//", $url, $matches)) {
			$videoCode = str_replace($matches[0],"",$url);
			$videoData['type'] = 0; //0=youtube
			$videoData['videoCode'] = $videoCode;
			$videoData['thumbnail'] = 'http://img.youtube.com/vi/'.$videoCode.'/1.jpg';
		}
		
		// Dailymotion => http://www.dailymotion.com/video/xbudb1_bomb-the-bass-the-infinites-video_music
		elseif(preg_match("/http:\/\/www.dailymotion.com\/video\//", $url, $matches)) {
			$videoCode = str_replace($matches[0],"",$url);
			$pos = stripos($videoCode,'_');
			if($pos!='') $videoCode = substr($videoCode,0,$pos);
			$videoData['type'] = 1; //1=dailymotion
			$videoData['videoCode'] = $videoCode;
			$videoData['thumbnail'] = 'http://www.dailymotion.com/thumbnail/80x60/video/'.$videoCode;
		}
		
		// Vimeo => http://www.vimeo.com/8769046
		elseif(preg_match("/http:\/\/www.vimeo.com\//", $url, $matches)) {
			$videoData['type'] = 2; //2=vimeo
			$videoCode = str_replace($matches[0],"",$url);
			$videoCode = substr($videoCode,0,7);
			$videoData['videoCode'] = $videoCode;
			$tmpTab = $this->getVimeoVideoData($videoCode);
			$videoData['thumbnail'] = $tmpTab['thumbnail'];
		}
		elseif(preg_match("/http:\/\/vimeo.com\//", $url, $matches)) {
			$videoData['type'] = 2; //2=vimeo
			$videoCode = str_replace($matches[0],"",$url);
			$videoCode = substr($videoCode,0,7);
			$videoData['videoCode'] = $videoCode;
			$tmpTab = $this->getVimeoVideoData($videoCode);
			$videoData['thumbnail'] = $tmpTab['thumbnail'];
		}
		
		// Ustream => http://www.ustream.tv/recorded/3971656
		elseif(preg_match("/http:\/\/www.ustream.tv\/recorded\//", $url, $matches)) {
			$videoData['type'] = 3; //3=ustream
			$videoData['videoCode'] = str_replace($matches[0],"",$url);
			$videoData['videoCode'] = substr($videoData['videoCode'],0,7);
		}
		
		// Myspace => http://vids.myspace.com/index.cfm?fuseaction=vids.individual&videoid=102335883
		elseif(preg_match("/http:\/\/vids.myspace.com\/index.cfm\?fuseaction=vids.individual&videoid=/", $url, $matches)) {
			$videoData['type'] = 4; //4=myspace
			$videoData['videoCode'] = str_replace($matches[0],"",$url);
			$videoData['videoCode'] = $videoData['videoCode'];
		}
		
		// Metacafe => http://www.metacafe.com/watch/1429026/legacy_of_kain_soul_reaver_intro/
		elseif(preg_match("/http:\/\/www.metacafe.com\/watch\//", $url, $matches)) {
			$videoCode = str_replace($matches[0],"",$url);
			//$pos = stripos($videoCode,'/');
			//if($pos!='') $videoCode = substr($videoCode,0,$pos);
			$videoCodeTab = explode("/",$videoCode);
			$videoCode = $videoCodeTab[0].'/'.$videoCodeTab[1];
			$videoData['type'] = 5; //5=metacafe
			$videoData['videoCode'] = $videoCode;
			$videoData['thumbnail'] = 'http://s4.mcstatic.com/thumb/'.$videoCode.'.jpg';
		}
		// => http://metacafe.com/w/1429026/
		elseif(preg_match("/http:\/\/www.metacafe.com\/w\//", $url, $matches)) {
			$videoCode = str_replace($matches[0],"",$url);
			//$pos = stripos($videoCode,'/');
			//if($pos!='') $videoCode = substr($videoCode,0,$pos);
			$videoCodeTab = explode("/",$videoCode);
			$videoCode = $videoCodeTab[0].'/'.$videoCodeTab[1];
			$videoData['type'] = 5; //5=metacafe
			$videoData['videoCode'] = $videoCode;
			$videoData['thumbnail'] = 'http://s4.mcstatic.com/thumb/'.$videoCode.'.jpg';
		}
		
		// Yahoo music => http://new.music.yahoo.com/videos/KellyClarkson/Because-Of-You--24511947
		elseif(preg_match("/http:\/\/new.music.yahoo.com\/videos\//", $url, $matches)) {
			$videoCode = str_replace($matches[0],"",$url);
			$pos = stripos($videoCode,'--');
			if($pos!='') $videoCode = substr($videoCode,($pos+2),8);
			$videoData['type'] = 6; //6=yahoo music
			$videoData['videoCode'] = $videoCode;
			$videoData['thumbnail'] = 'http://d.yimg.com/ec/image/v1/video/'.$videoCode.'?size=60';
		}
		
		return $videoData;
	}
	
	
	function getEmbedVideoCode($criteria) {
		global $path_vbox;
		$videoProviderId = $criteria['videoProviderId'];
		$videoCode = $criteria['videoCode'];
		$width = $criteria['width'];
		$height = $criteria['height'];
		$autoplay = $criteria['autoplay'];
		$url = $criteria['url'];
		
		if($autoplay=='') $autoplay = 0;
		if($width=='') $width=500;
		if($height=='') $height=350;
		
		if($videoCode!='') {
			if($videoProviderId==0) { //0=youtube
				$embedCode = '<object width="'.$width.'" height="'.$height.'"><param name="movie" value="http://www.youtube.com/v/'.$videoCode.'&hl=en_US&fs=1&iv_load_policy=3&rel=0&autoplay='.$autoplay.'"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/'.$videoCode.'&hl=en_US&fs=1&iv_load_policy=3&rel=0&autoplay='.$autoplay.'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="'.$width.'" height="'.$height.'" wmode="transparent"></embed></object>';
			}
			elseif($videoProviderId==1) { //1=dailymotion
				$embedCode = '<object width="'.$width.'" height="'.$height.'"><param name="movie" value="http://www.dailymotion.com/swf/'.$videoCode.'&related=0&autoplay='.$autoplay.'"></param><param name="allowFullScreen" value="true"></param><param name="allowScriptAccess" value="always"></param><embed src="http://www.dailymotion.com/swf/'.$videoCode.'&related=0&autoplay='.$autoplay.'" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" allowfullscreen="true" allowscriptaccess="always" wmode="transparent"></embed></object>';
			}
			elseif($videoProviderId==2) { //2=vimeo
				$embedCode = '<object width="'.$width.'" height="'.$height.'"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id='.$videoCode.'&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id='.$videoCode.'&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="'.$width.'" height="'.$height.'" wmode="transparent"></embed></object>';
			}
			elseif($videoProviderId==3) { //3=ustream
				if($autoplay) $autoplay=true;
				else $autoplay=false;
				$embedCode = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="'.$width.'" height="'.$height.'" id="utv194455" name="utv_n_614698"><param name="flashvars" value="autoplay='.$autoplay.'" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="src" value="http://www.ustream.tv/flash/video/'.$videoCode.'" /><embed flashvars="autoplay='.$autoplay.'" width="'.$width.'" height="'.$height.'" allowfullscreen="true" allowscriptaccess="always" id="utv194455" name="utv_n_614698" src="http://www.ustream.tv/flash/video/'.$videoCode.'" type="application/x-shockwave-flash" wmode="transparent" /></object>';
			}
			elseif($videoProviderId==4) { //4=myspace
				$embedCode = '<object width="'.$width.'px" height="'.$height.'px" ><param name="allowFullScreen" value="true"/><param name="wmode" value="transparent"/><param name="movie" value="http://mediaservices.myspace.com/services/media/embed.aspx/m='.$videoCode.',t=1,mt=video"/><embed src="http://mediaservices.myspace.com/services/media/embed.aspx/m='.$videoCode.',t=1,mt=video" width="'.$width.'" height="'.$height.'" allowFullScreen="true" type="application/x-shockwave-flash" wmode="transparent"></embed></object>';
			}
			elseif($videoProviderId==5) { //5=metacafe
				$embedCode = '<embed src="http://www.metacafe.com/fplayer/'.$videoCode.'.swf" width="'.$width.'" height="'.$height.'" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" allowFullScreen="true" allowScriptAccess="always" wmode="transparent"> </embed>';
			}
			elseif($videoProviderId==6) { //6=yahoo music
				$embedCode = '<object width="'.$width.'" height="'.$height.'" id="uvp_fop" allowFullScreen="true"><param name="movie" value="http://d.yimg.com/m/up/fop/embedflv/swf/fop.swf"/><param name="flashVars" value="id=v'.$videoCode.'&amp;eID=1301797&amp;lang=us&amp;enableFullScreen=0&amp;shareEnable=1"/><param name="wmode" value="transparent"/><embed height="'.$height.'" width="'.$width.'" id="uvp_fop" allowFullScreen="true" src="http://d.yimg.com/m/up/fop/embedflv/swf/fop.swf" type="application/x-shockwave-flash" flashvars="id=v'.$videoCode.'&amp;eID=1301797&amp;lang=us&amp;ympsc=4195329&amp;enableFullScreen=1&amp;shareEnable=1" wmode="transparent" /></object>';
			}
		}
		
		return $embedCode;
	}
	
}

?>