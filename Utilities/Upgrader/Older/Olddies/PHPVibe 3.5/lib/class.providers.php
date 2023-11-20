<?php
  //constants
  define('UNKNOWN_PROVIDER', _lang('Unknown provider or incorrect URL. Please try again.'));
  define('INVALID_URL', _lang('This URL is invalid or the video is removed by the provider.'));
  class Vibe_Providers
  {
      protected $height = 300;
      protected $width = 600;
      protected $link = "";
      function __construct($width = null, $height = null)
      {
          $this->setDimensions($width, $height);
      }
      //check if video link is valid
      public function isValid($videoLink)
      {
          $this->link    = $videoLink;
          $videoProvider = $this->decideVideoProvider();
          if (!empty($videoProvider) && $videoProvider != "") {
              return true;
          } else {
              return false;
          }
      }
      // getEmbedCode
      public function getEmbedCode($videoLink, $width = null, $height = null)
      {
          $this->setDimensions($width, $height);
          if ($videoLink != "") {
              if (!is_numeric(strpos($videoLink, "http://")) && !is_numeric(strpos($videoLink, "https://")) ) {
                  $videoLink = "http://" . $videoLink;
              }
              $this->link    = $videoLink;
              $embedCode     = "";
              $videoProvider = $this->decideVideoProvider();
              if ($videoProvider == "") {
                  $embedCode = UNKNOWN_PROVIDER;
              } else {
                  $embedCode = $this->generateEmbedCode($videoProvider);
              }
          } else {
              $embedCode = INVALID_URL;
          }
          return $embedCode;
      }
      // decide video provider
      private function decideVideoProvider()
      {
          $videoProvider = "";
          //providers list
          $hostings      = array(
              'youtube',
              'vimeo',
              'metacafe',
              'dailymotion',
              'hell',
              'trilulilu',
              'viddler',
              'blip',
              'myspace',
              'twitcam',
              'ustream',
              'liveleak',
              'livestream',
              'vplay',
              'facebook',
              'localfile',
              'localimage',
              'peteava',
              'vk',
			  'vine',
              'telly',
              'putlocker',
              'gametrailers',
			  'docs.google.com'
          );
          //hook for more sources
          $hostings      = apply_filter('vibe-video-sources', $hostings);
          //check	provider	
          for ($i = 0; $i < count($hostings); $i++) {
              if (is_numeric(strpos($this->link, $hostings[$i]))) {
                  $videoProvider = $hostings[$i];
              }
          }
          return $videoProvider;
      }
      // generate video ıd from link
      public function VideoProvider($link = null)
      {
          if (is_null($link)) {
              $thisProvider = $this->decideVideoProvider();
          } else {
              $this->link   = $link;
              $thisProvider = $this->decideVideoProvider();
          }
          return $thisProvider;
      }
       public function getVideoId($operand, $optionaOperand = null)
      {
          $videoId      = null;
          $startPosCode = strpos($this->link, $operand);
          if ($startPosCode != null) {
              $videoId = substr($this->link, $startPosCode + strlen($operand), strlen($this->link) - 1);
              if (!is_null($optionaOperand)) {
                  $startPosCode = strpos($videoId, $optionaOperand);
                  if ($startPosCode > 0) {
                      $videoId = substr($videoId, 0, $startPosCode);
                  }
              }
          }
          return $videoId;
      }
	  public function _jwplayer6 ($file,$thumb, $logo = null, $type=null) {
	  global $video;
	  $embed = '<div id="video-setup" class="full">' . _lang("Loading the player...") . '</div>';
              $embed .= ' <script type="text/javascript">
			
		jwplayer("video-setup").setup({ primary : "html5",  file: "' . $file . '",  image: "' . $thumb . '", title: "' . _html($video->title) . '",  modes: [
        { type: "html5" },
        { type: "flash", src: "' . site_url() . 'lib/players/jwplayer/player.swf" }
    ],  height: ' . $this->height . ',   repeat: "always",		aspectratio: "16:9",  width: "100%"';
if($type) {   $embed .= ', type: "' . strtolower($type) . '" '; }
if($logo && !nullval($logo)) {	  $embed .= ',	logo: {         file: "'.$logo.'",  position: "bottom-left",  link: "'.site_url().'"    }'; }
              $embed .= '  }); </script>';
			  return $embed;
	  }
	   public function _jwplayer5 ($file,$thumb, $logo = null, $type=null) {
	  	$embed = '<script type="text/javascript" src="'.site_url().'lib/players/jwplayer5/swfobject.js"></script>';
		$embed .= '<div id="mediaspace">You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and a browser with JavaScript support.</div>';
		$embed .= "	<script type='text/javascript'>
  var so = new SWFObject('".site_url()."lib/players/jwplayer5/player.swf','mpl','".$this->width."','".$this->height."','9');
  so.addParam('allowfullscreen','true');
  so.addParam('allowscriptaccess','always');
  so.addParam('wmode','opaque');
  so.addVariable('file','".$file."');";
  if($type == 'mp3') {
   $embed .= " so.addVariable('provider','sound');";
  } elseif($type) {
  $embed .= " so.addVariable('provider','video');";
   }
  $embed .= " so.addVariable('image','".$thumb."');
  so.addVariable('skin','".site_url()."lib/players/jwplayer5/newtube.zip');
  so.addVariable('controlbar','over');
  so.addVariable('logo.file','".$logo."');
  so.addVariable('logo.link','".site_url()."');
  so.addVariable('autostart','true');
  so.addVariable('logo.hide','false');
  so.addVariable('logo.position','bottom-left');    
  so.addVariable('repeat','always');
  //so.addVariable('stretching','fill');
  so.addVariable('plugins', 'fbit-1,tweetit-1');
  so.write('mediaspace');
</script>";
return  $embed;	
	  }
	  public function _jwplayer($file,$thumb, $logo = null, $type=null) {
	  /** Switch jwplayer versions **/
	  if(get_option('jwp_version') == 5 ) {
	  return $this->_jwplayer5($file,$thumb, $logo, $type);
	  } else {
	  return $this->_jwplayer6($file,$thumb, $logo, $type);
	  }	  
	  }
      public function remotevideo($url)
      {
          global $video;
          $embedCode = '';
          if ($url) {
		   $pieces_array     = explode('.', $url);
           $ext  = end($pieces_array);		  
		  $embedCode = $this->_jwplayer ($url,$video->thumb,thumb_fix(get_option('player-logo')),$ext);
           }
          return $embedCode;
      }
      // generate video embed code via using standart templates
      private function generateEmbedCode($videoProvider)
      {
          global $video;
          $embedCode = "";
          switch ($videoProvider) {
              case 'localimage':
                  $path = $this->getVideoId("localimage/").'@@'.get_option('mediafolder');
				  $real_link        = site_url() . 'stream.php?type=1&file=' . base64_encode(base64_encode($path));
                  $embedCode .= '<a rel="lightbox" class="media-href" title="' . stripslashes($video->title) . '" href="' . $real_link . '"><img class="media-img" src="' . $real_link . '" /></a>';
                  break;
              case 'localfile':
                  $path             = $this->getVideoId("localfile/").'@@'.get_option('mediafolder');
				  
                  if(!isIOS()) {
				  $real_link        = site_url() . 'stream.php?file=' . base64_encode(base64_encode($path));
				  } else {
				  $real_link        = thumb_fix(get_option('mediafolder').'/'.$this->getVideoId("localfile/"));
				  }
                  //$ext = explode(".", $this->link);
                  //$ext = $ext[1];
                  $pieces_array     = explode('.', $this->link);
                  $ext              = end($pieces_array);
                  $choice           = get_option('choosen-player');
                  $mobile_supported = array(
                      "mp4",
                      "webm",
                      "ogv",
                      "m3u8",
                      "ts",
                      "tif"
                  );
                  if (!in_array($ext, $mobile_supported)) {
                      /*force jwplayer always on non-mobi formats, as flowplayer it's just html5 */
                      $choice = 1;
                  }
                  if ($choice == 1) {
				  $embedCode = $this->_jwplayer($real_link,$video->thumb,thumb_fix(get_option('player-logo')),$ext);
                    } elseif ($choice == 2) {
                      $embedCode = ' <link rel="stylesheet" type="text/css"href="http://releases.flowplayer.org/5.4.3/skin/minimalist.css">';
                      $embedCode .= ' <script src="http://releases.flowplayer.org/5.4.3/flowplayer.min.js"></script>';
              $embedCode .= '<div data-swf="http://releases.flowplayer.org/5.4.3/flowplayer.swf"  class="flowplayer fullscreen full aside-time play-button color-light"  data-ratio="0.5625" data-embed="false" data-analytics="' . get_option("googletracking") . '">
              <video poster="' . $video->thumb . '" loop="loop">
              <source type="video/' . str_replace("ogv", "ogg", $ext) . '" src="' . $real_link . '"/>';
                      if ($video->srt) {  $embedCode .= ' <track src="' . $video->srt . '"/>'; }
                      $embedCode .= '</video>   </div>';
                  } else {
                      $embedCode .= '<script src="' . site_url() . 'lib/players/media/mediaelement-and-player.min.js"></script> ';
                      $embedCode .= '<link rel="stylesheet"  href="' . site_url() . 'lib/players/media/mediaelementplayer.css" />';
                      $embedCode .= '<video height: "' . $this->height . '" width: "' . $this->width . '" poster="' . $video->thumb . '" controls="controls" preload="none"><source type="video/' . str_replace("ogv", "ogg", $ext) . '" src="' . $real_link . '"/>';
                      if ($video->srt) {  $embedCode .= ' <track src="' . $video->srt . '"/>'; }
         $embedCode .= '         
         <object height: "' . $this->height . '" width: "' . $this->width . '" type="application/x-shockwave-flash" data="' . site_url() . 'lib/players/media/flashmediaelement.swf">
        <param name="movie" value="' . site_url() . 'lib/players/media/flashmediaelement.swf" />
        <param name="flashvars" value="controls=true&file=' . $real_link . '" />      
        <img src="' . $video->thumb . '" height: "' . $this->height . '" width: "' . $this->width . '" title="No video playback capabilities" />
          </object>
          </video>';
                  }
                  break;
			case 'vine':
			$videoId = $this->getVideoId("/v/");
			if ($videoId != null) {
			 $embedCode .= '<iframe class="vine-embed" src="https://vine.co/v/'.$videoId.'/embed/simple?audio=1" width="' . $this->width . '" height="' . $this->height . '" frameborder="0"></iframe><script async src="//platform.vine.co/static/scripts/embed.js" charset="utf-8"></script>';
} else {
                      $embedCode = INVALID_URL;
                  }
            break;			
              case 'facebook':
                  $videoId = $this->getVideoId("v=", "&");
                  if (empty($videoId)) {
                      $videoId = $this->getVideoId("v/");
                  }
                  if ($videoId != null) {
                      $embedCode .= '<iframe src="https://www.facebook.com/video/embed?video_id=' . $videoId . '" type="application/x-shockwave-flash" allowfullscreen="true" width="' . $this->width . '" height="' . $this->height . '"  frameborder="0"></iframe>';
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
				  case 'docs.google.com':
                  $videoId = str_replace('/edit','/preview',$this->link);
                  if ($videoId != null) {
                      $embedCode .= '<iframe src="' . $videoId . '" width="' . $this->width . '" height="' . $this->height . '"  frameborder="0"></iframe>';
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;  
				  
              case 'youtube':
                  $videoId = $this->getVideoId("v=", "&");
                  if ($videoId != null) {
                      $choice = get_option('youtube-player');
                      if ($choice < 2) {
                          $embedCode .= "<iframe width=\"" . $this->width . "\" height=\"" . $this->height . "\" src=\"http://www.youtube.com/embed/" . $videoId . "?&amp;title=&amp;html5=1&amp;iv_load_policy=3&amp;modestbranding=1&amp;nologo=1&amp;vq=large&amp;autoplay=1&amp;ps=docs\" frameborder=\"0\" allowfullscreen=\"true\"></iframe>";
                      } else {
					  $real_link = 'http://www.youtube.com/watch?v=' . $videoId;
					  $img = 'http://i2.ytimg.com/vi/' . $videoId . '/0.jpg';
					  $embedCode = $this->_jwplayer ($real_link,$img, thumb_fix(get_option('player-logo')));
                             }
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'vimeo':
                  $videoIdForChannel = $this->getVideoId('#');
                  if (strlen($videoIdForChannel) > 0) {
                      $videoId = $videoIdForChannel;
                  } else {
                      $videoId = $this->getVideoId(".com/");
                  }
                  //$videoId = $videoForChannel;
                  if ($videoId != null) {
                      $embedCode .= '<iframe src="http://player.vimeo.com/video/' . $videoId . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff&amp;autoplay=1" width="' . $this->width . '" height="' . $this->height . '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'peteava':
                  $videoId = $this->getVideoId("/id-", "/");
                  $pieces  = explode("-", $videoId);
                  $videoId = $pieces[0];
                  //$videoId = $this->getLastNr($this->link);
                  if ($videoId != null) {
                      $embedCode .= '<iframe width="' . $this->width . '" height="' . $this->height . '" src="http://www.peteava.ro/static/swf/player.swf?http://content.peteava.ro/stream.php&file=' . $videoId . '_standard.mp4&image=http://storage2.peteava.ro/serve/thumbnail/' . $videoId . '/playerstandard&hd_file=' . $videoId . '_high.mp4&hd_image=http://storage2.peteava.ro/serve/thumbnail/' . $videoId . '/playerhigh&autostart=true" frameborder="0" scrolling="no" allowfullscreen></iframe>';
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'putlocker':
                  $videoId = $this->getVideoId("file/");
                  if ($videoId != null) {
                      $embedCode .= '<iframe width="' . $this->width . '" height="' . $this->height . '" src="http://www.putlocker.com/embed/' . $videoId . '" frameborder="0" scrolling="no" allowfullscreen></iframe>';
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'hell':
                  $videoId = $this->getVideoId("videos/");
                  //$videoId = $this->getLastNr($this->link);
                  if ($videoId != null) {
                      $embedCode .= '<iframe width="' . $this->width . '" height="' . $this->height . '" src="http://www.hell.tv/embed/video/' . $videoId . '" frameborder="0" scrolling="no" allowfullscreen></iframe>';
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'dailymotion':
                  $videoId = $this->getVideoId("video/");
                  if ($videoId != null) {
                      $embedCode .= '<iframe frameborder="0" width="' . $this->width . '" height="' . $this->height . '" src="http://www.dailymotion.com/embed/video/' . $videoId . '"></iframe>';
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'trilulilu':
                  $videoId = $this->getVideoId(".ro/");
                  if ($videoId != null) {
                      $embedCode .= '<iframe width="' . $this->width . '" height="' . $this->height . '" src="http://embed.trilulilu.ro/' . $videoId . '" frameborder="0" allowfullscreen></iframe> ';
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'liveleak':
                  $videoId = $this->getVideoId("i=");
                  if ($videoId != null) {
                      $embedCode .= '<iframe width="' . $this->width . '" height="' . $this->height . '" src="http://www.liveleak.com/e/' . $videoId . '" frameborder="0" allowfullscreen></iframe> ';
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'metacafe':
                  $videoId = $this->getVideoId("watch/", "/");
                  if ($videoId != null) {
                      $embedCode .= '<iframe src="http://www.metacafe.com/embed/' . $videoId . '/" width="' . $this->width . '" height="' . $this->height . '" allowFullScreen frameborder=0></iframe>';
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'viddler':
                  $videoId = $this->getVideoId("v/");
                  if ($videoId != null) {
                      $embedCode .= "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" width=\"" . $this->width . "\" height=\"" . $this->height . "\" ";
                      $embedCode .= "id=\"viddler_1f72e4ee\">";
                      $embedCode .= "<param name=\"movie\" value=\"http://www.viddler.com/player/" . $videoId . "\" />";
                      $embedCode .= "<param name=\"allowScriptAccess\" value=\"always\" />";
                      $embedCode .= "<param name=\"allowFullScreen\" value=\"true\" />";
                      $embedCode .= "<embed src=\"http://www.viddler.com/player/" . $videoId . "\"";
                      $embedCode .= " width=\"" . $this->width . "\" height=\"" . $this->height . "\" type=\"application/x-shockwave-flash\" ";
                      $embedCode .= "allowScriptAccess=\"always\"";
                      $embedCode .= "allowFullScreen=\"true\" name=\"viddler_" . $videoId . "\"\"></embed></object>";
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'blip':
                  $videoId = $this->getLastNr($this->link);
                  if ($videoId != null) {
                      $embedCode .= "<embed src=\"http://blip.tv/file/" . $videoId . "\" ";
                      $embedCode .= "type=\"application/x-shockwave-flash\" width=\"" . $this->width . "\" height=\"" . $this->height . "\"";
                      $embedCode .= " allowscriptaccess=\"always\" allowfullscreen=\"true\"></embed>";
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'myspace':
                  $this->link = strtolower($this->link);
                  $videoId    = $this->getVideoId("vid/", "&");
                  if ($videoId != null) {
                      $embedCode .= "<object width=\"" . $this->width . "\" height=\"" . $this->height . "\" ><param name=\"allowFullScreen\" ";
                      $embedCode .= "value=\"true\"/><param name=\"wmode\" value=\"transparent\"/><param name=\"movie\" ";
                      $embedCode .= "value=\"http://mediaservices.myspace.com/services/media/embed.aspx/m=" . $videoId . ",t=1,mt=video\"/>";
                      $embedCode .= "<embed src=\"http://mediaservices.myspace.com/services/media/embed.aspx/m=" . $videoId . ",t=1,mt=video\" ";
                      $embedCode .= "width=\"" . $this->width . "\" height=\"" . $this->height . "\" allowFullScreen=\"true\" type=\"application/x-shockwave-flash\" ";
                      $embedCode .= "wmode=\"transparent\"></embed></object>";
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'vplay':
                  $videoId = $this->getVideoId("watch/");
                  $videoId = str_replace("/", "", $videoId);
                  if ($videoId != null) {
                      $embedCode .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="' . $this->width . '" height="' . $this->height . '"><param name="movie" value="http://i.vplay.ro/f/embed.swf?key=' . $videoId . '"><param name="allowfullscreen" value="true"><param name="wmode" value="opaque"><param name="quality" value="high"><embed src="http://i.vplay.ro/f/embed.swf?key=' . $videoId . '" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="' . $this->width . '" height="' . $this->height . '" allowfullscreen="true" wmode="opaque" ></embed></object>';
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'ustream':
                  $videoId = $this->getVideoId("recorded/", '/');
                  if ($videoId != null) {
                      $embedCode .= "<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" ";
                      $embedCode .= "width=\"" . $this->width . "\" height=\"" . $this->height . "\" ";
                      $embedCode .= "id=\"utv867721\" name=\"utv_n_859419\"><param name=\"flashvars\" ";
                      $embedCode .= "value\"beginPercent=0.0236&amp;endPercent=0.2333&amp;autoplay=false&locale=en_US\" />";
                      $embedCode .= "<param name=\"allowfullscreen\" value=\"true\" /><param name=\"allowscriptaccess\" ";
                      $embedCode .= "value=\"always\" />";
                      $embedCode .= "<param name=\"src\" value=\"http://www.ustream.tv/flash/video/" . $videoId . "\" />";
                      $embedCode .= "<embed flashvars=\"beginPercent=0.0236&amp;endPercent=0.2333&amp;autoplay=false&locale=en_US\" ";
                      $embedCode .= "width=\"" . $this->width . "\" height=\"" . $this->height . "\" ";
                      $embedCode .= "allowfullscreen=\"true\" allowscriptaccess=\"always\" id=\"utv867721\" ";
                      $embedCode .= "name=\"utv_n_859419\" src=\"http://www.ustream.tv/flash/video/" . $videoId . "\" ";
                      $embedCode .= "type=\"application/x-shockwave-flash\" /></object>";
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'livestream':
                  $firstID  = $this->getVideoId("com/", '/');
                  $secondID = $this->getVideoId("?clipId=", '&');
                  if ($firstID != null && $secondID != null) {
                      $embedCode .= "<object width=\"" . $this->width . "\" height=\"" . $this->height . "\" id=\"lsplayer\" ";
                      $embedCode .= "classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\">";
                      $embedCode .= "<param name=\"movie\" ";
                      $embedCode .= "value=\"http://cdn.livestream.com/grid/LSPlayer.swf?channel=" . $firstID . "&amp;";
                      $embedCode .= "clip=" . $secondID . "&amp;autoPlay=false\"></param>";
                      $embedCode .= "<param name=\"allowScriptAccess\" value=\"always\"></param><param name=\"allowFullScreen\" ";
                      $embedCode .= "value=\"true\"></param><embed name=\"lsplayer\" wmode=\"transparent\" ";
                      $embedCode .= "src=\"http://cdn.livestream.com/grid/LSPlayer.swf?channel=" . $firstID . "&amp;";
                      $embedCode .= "clip=" . $secondID . "&amp;autoPlay=false\" ";
                      $embedCode .= "width=\"" . $this->width . "\" height=\"" . $this->height . "\" allowScriptAccess=\"always\" allowFullScreen=\"true\" ";
                      $embedCode .= "type=\"application/x-shockwave-flash\"></embed></object>	";
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'gametrailers':
                  $videoFullID = $this->getVideoId("video/");
                  $videoId     = strpos($videoFullID, "/");
                  $videoId     = substr($videoFullID, $videoId + 1, strlen($videoFullID));
                  if ($videoId != null) {
                      $embedCode .= '<embed src="http://media.mtvnservices.com/mgid:moses:video:gametrailers.com:' . $videoId . '" width="' . $this->width . '" height="' . $this->height . '" type="application/x-shockwave-flash" allowFullScreen="true" allowScriptAccess="always" base="." flashVars=""></embed>';
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'vk':
                  $firstIDs  = $this->getVideoId("video", '_');
                  $secondIDs = $this->getVideoId("_", '?');
                  $thirdIDs  = $this->getVideoId("hash=");
                  if ($firstIDs != null && $secondIDs != null && $thirdIDs != null) {
                      $embedCode .= "<iframe src=\"http://vk.com/video_ext.php?oid=" . $firstIDs . "&id=" . $secondIDs . "&hash=" . $thirdIDs . "&sd\" width=\"" . $this->width . "\" height=\"" . $this->height . "\" frameborder=\"0\"></iframe>";
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'telly':
                  $videoIdForChannel = $this->getVideoId('guid=');
                  if (strlen($videoIdForChannel) > 0) {
                      $videoId = $videoIdForChannel;
                  } else {
                      $videoId = $this->getVideoId(".com/", '?');
                  }
                  if ($videoId != null) {
                      $embedCode .= "<iframe src=\"http://telly.com/embed.php?guid=" . $videoId . "&#038;autoplay=0\" title=\"Telly video player \" class=\"twitvid-player\" type=\"text/html\" width=\"" . $this->width . "\" height=\"" . $this->height . "\" frameborder=\"0\"></iframe>";
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
          }
          return $embedCode;
      }
      // get id from weird rewrites
      public function getLastNr($url)
      {
          $pieces_array = explode('/', $url);
          $end_piece    = end($pieces_array);
          $id_pieces    = explode('-', $end_piece);
          $last_piece   = end($id_pieces);
          $videoId      = preg_replace("/[^0-9]/", "", $last_piece);
          return $videoId;
      }
      private function setDimensions($width = null, $height = null)
      {
          if ((!is_null($width)) && ($width != "")) {
              $this->width = $width;
          }
          if ((!is_null($height)) && ($height != "")) {
              $this->height = $height;
          }
      }
      private function match($regex, $str, $i = 0)
      {
          if (preg_match($regex, $str, $match) == 1) {
              return $match[$i];
          } else {
              return null;
          }
      }
      function get_data()
      {
          $provider = $this->decideVideoProvider();
          switch ($provider) {
		    case 'vine':
                 $videoId = $this->getVideoId("/v/");
				  $video = array();
				  $video['description'] ='';
				   $video['title'] ='';
				   $video['thumbnail'] ='';
    $url = "https://vine.co/v/". $videoId;
    $data = file_get_contents($url);
    preg_match('~<\s*meta\s+property="(twitter:description)"\s+content="([^"]*)~i', $data, $matches);
    if ( isset($matches[2]) ) {
       $video['description'] = $matches[2];
    }
	unset($matches);
	 preg_match('/property="twitter:title" content="(.*?)"/', $data, $matches);
 if ( isset($matches[1]) ) {
       $video['title'] = $matches[1];
    }
unset($matches);
	 preg_match('/property="twitter:image" content="(.*?)"/', $data, $matches);
 if ( isset($matches[1]) ) {
      $video['thumb'] = explode('?versionId',$matches[1]);
	  $video['thumbnail'] = $video['thumb']['0'];
    }
	  $video['duration']    = 6;
unset($matches);
unset($data);
return $video;
                  break;
              case 'vimeo':
                  $json_url              = "http://vimeo.com/api/v2/video/" . $this->getLastNr($this->link) . ".json";
                  $content               = $this->getDataFromUrl($json_url);
                  $video                 = json_decode($content, true);
                  $video[0]['thumbnail'] = $video[0]['thumbnail_medium'];
                  return $video[0];
                  break;
              case 'youtube':
                  $vid                        = preg_replace('/^.*(\?|\&)v\=/', '', $this->link);
                  $vid                        = preg_replace('/[^\w\-\_].*$/', '', $vid);
                  $json_url                   = 'http://gdata.youtube.com/feeds/api/videos/' . $vid . '?v=2&alt=jsonc';
                  $content                    = $this->getDataFromUrl($json_url);
                  $video                      = json_decode($content, true);
                  $video['data']['thumbnail'] = "http://i4.ytimg.com/vi/" . $video['data']['id'] . "/0.jpg";
                  if (isset($video['data']['tags'])) {
                      $taglist               = $video['data']['tags'];
                      $video['data']['tags'] = null;
                      $count                 = count($taglist);
                      for ($i = 0; $i < $count; $i++) {
                          $video['data']['tags'] .= $taglist[$i] . ', ';
                      }
                  } else {
                      $video['data']['tags'] = '';
                  }
                  return $video['data'];
                  break;
              case 'metacafe':                  
                   $idvid = $this->getVideoId("watch/","/");
                  
                  $file_data            = "http://www.metacafe.com/api/item/" . $idvid;
                  $video                = array();
                  $xml                  = new SimpleXMLElement(file_get_contents($file_data));
                  $title_query          = $xml->xpath('/rss/channel/item/title');
                  $video['title']       = $title_query ? strval($title_query[0]) : '';
                  $description_query    = $xml->xpath('/rss/channel/item/media:description');
                  $video['description'] = $description_query ? strval($description_query[0]) : '';
                  $tags_query           = $xml->xpath('/rss/channel/item/media:keywords');
                  $video['tags']        = $tags_query ? explode(',', strval(trim($tags_query[0]))) : null;
                  if (isset($video['tags']) && !empty($video['tags'])) {
                      $video['tags'] = implode(', ', $video['tags']);
                  } else{
				  $video['tags'] = '';
				  }
				 
                  $date_published_query = $xml->xpath('/rss/channel/item/pubDate');
                  $video['uploaded']    = $date_published_query ? ($date_published_query[0]) : null;
                  $thumbnails_query     = $xml->xpath('/rss/channel/item/media:thumbnail/@url');
				  if(isset($thumbnails_query[0])) {
                  $video['thumbnail']   = strval($thumbnails_query[0]);
				  } else {
				  $video['thumbnail']   = '';
				  }
                  $video['duration']    = null;
				  
                  return $video;
                  break;
              case 'dailymotion':
                  if (preg_match('#http://www.dailymotion.com/video/([A-Za-z0-9]+)#s', $this->link, $match)) {
                      $idvid = $match[1];
                  }
                  $file_data            = "http://www.dailymotion.com/rss/video/" . $idvid;
                  $video                = array();
                  $xml                  = new SimpleXMLElement(file_get_contents($file_data));
                  $title_query          = $xml->xpath('/rss/channel/item/title');
                  $video['title']       = $title_query ? strval($title_query[0]) : '';
                  $description_query    = $xml->xpath('/rss/channel/item/itunes:summary');
                  $video['description'] = $description_query ? strval($description_query[0]) : '';
                  $tags_query           = $xml->xpath('/rss/channel/item/itunes:keywords');
				  if(!empty($tags_query) && $tags_query) {
                  $video['tags']        = $tags_query ? explode(',', strval(trim($tags_query[0]))) : null;
                  $video['tags']        = implode(', ', $video['tags']);
				  } else {
				  $video['tags'] = '';
				  }
                  $date_published_query = $xml->xpath('/rss/channel/item/pubDate');
                  $video['uploaded']    = $date_published_query ? ($date_published_query[0]) : null;
                  $thumbnails_query     = $xml->xpath('/rss/channel/item/media:thumbnail/@url');
                  $video['thumbnail']   = strval($thumbnails_query[0]);
                  $duration_query       = $xml->xpath('/rss/channel/item/media:group/media:content/@duration');
                  $video['duration']    = $duration_query ? intval($duration_query[0]) : null;
                  return $video;
              case 'myspace':
                  # Get XML data URL
                  $file_data            = "http://mediaservices.myspace.com/services/rss.ashx?type=video&videoID=" . $this->getLastNr($this->link);
                  # XML
                  $xml                  = new SimpleXMLElement(file_get_contents($file_data));
                  $video                = array();
                  # Get video title
                  $title_query          = $xml->xpath('/rss/channel/item/title');
                  $video['title']       = $title_query ? strval($title_query[0]) : '';
                  # Get video description
                  $description_query    = $xml->xpath('/rss/channel/item/media:content/media:description');
                  $video['description'] = $description_query ? strval($description_query[0]) : '';
                  # Get video tags
                  $tags_query           = $xml->xpath('/rss/channel/item/media:keywords');
                  $video['tags']        = $tags_query ? explode(',', strval(trim($tags_query[0]))) : null;
                  $video['tags']        = implode(', ', $video['tags']);
                  # Fet video duration
                  $duration_query       = $xml->xpath('/rss/channel/item/media:content/@duration');
                  $video['duration']    = $duration_query ? intval($duration_query[0]) : null;
                  # Get video publication date
                  $date_published_query = $xml->xpath('/rss/channel/item/pubDate');
                  $video['uploaded']    = $date_published_query ? ($date_published_query[0]) : null;
                  # Get video thumbnails
                  $thumbnails_query     = $xml->xpath('/rss/channel/item/media:thumbnail/@url');
                  $video['thumbnail']   = strval($thumbnails_query[0]);
                  return $video;
                  break;
              case 'vplay':
                  $video              = array();
                  $videoId            = $this->getVideoId("watch/");
                  $videoId            = str_replace("/", "", $videoId);
                  $pre                = substr($videoId, 0, 2);
                  $video['thumbnail'] = "http://i.vplay.ro/th/" . $pre . "/" . $videoId . "/0.jpg";
                  return $video;
                  break;
          }
      }
      function getDataFromUrl($url)
      {
          $ch      = curl_init();
          $timeout = 15;
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
          $data = curl_exec($ch);
          curl_close($ch);
          return $data;
      }
  }
?>