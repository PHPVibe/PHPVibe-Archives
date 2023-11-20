<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
	
		<title><?=$video->title." - ".$site_title?></title>
		
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		
		<meta name="keywords" content="<?=$video->keywords?>">
		<meta name="description" content="<?=$meta_description?>">
		
		<base href="<?=$site_url?>" />
		
		<link href="<?=$site_url?>templates/<?=$template?>/style.css" rel="stylesheet" type="text/css" />
		<link rel="alternate" type="application/rss+xml" title="<?php echo $site_title; ?> Feed" href="<?php echo $site_url; ?>rss" />
		<link rel="shortcut icon" href="<?=$site_url?>templates/<?=$template?>/images/favicon.ico">
		
		<script type="text/javascript" src="<?=$site_url?>includes/prototype.js"></script>
				
<link href="<?=$site_url?>templates/<?=$template?>/dropdown/dropdown.css" media="all" rel="stylesheet" type="text/css" />
<link href="<?=$site_url?>templates/<?=$template?>/dropdown/themes/mainmenu/default.ultimate.css" media="all" rel="stylesheet" type="text/css" />

<!--[if lt IE 7]>
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<script type="text/javascript" src="js/jquery/jquery.dropdown.js"></script>
<![endif]-->

<script>
var RecaptchaOptions = {
   theme : 'clean'
};
</script>

	</head>
	
<body>
<?php error_reporting(0); ?>
<!-- Page Content -->
<div id="content">
	<?php include("header.php"); ?>
							
		<div id="left">
			
			<div class="left_articles" style="text-align: center;">
				<h2><?=$video->title?> <?=VideoDuration($video->length)?></h2>
          
          <table style="width: 100%; text-align: center; margin-top: 10px; margin-bottom: 10px;" cellspacing="0" cellpadding="0">
          <tr><td colspan="2" style=\"width: 100%; text-align: center;\">
            <script type='text/javascript' src='embed/swfobject.js'></script>
<div id='mediaspace'>Enable javascript.</div>
<script type='text/javascript'>
var s1 = new SWFObject('embed/player.swf','ply','620','387','9','#ffffff');
s1.addParam('allowfullscreen','true');
s1.addParam('allowscriptaccess','always');
s1.addParam('wmode','opaque');
s1.addVariable('file','http://www.youtube.com/watch?v=<?php echo $video_id; ?>');
s1.addVariable('image','http://i4.ytimg.com/vi/<?php echo $video_id; ?>/0.jpg');
s1.addVariable('stretching','exactfit');
s1.write('mediaspace');
</script>
          </td></tr>
          
          <tr>          
            <td style="width: 50%; text-align: center; padding-left: 60px;"><?=Stats('rating', $video_id)?></td>
            <td style="width: 50%; text-align: center;"><?=ShowRating($video_id)?></td>
          </tr>
          </table>
       
					
</div>

	<div class="left_articles">		

<p><?=$meta_description.'...'?></p>				
<p>Video Tags</p>
<p><? VideoTags($video->keywords); ?></p>
        	
<p><label for="embed_code">Add it on your site:</label></p>
<p>
<input id="embed_code" type="text" value='&lt;object width="400" height="325">&lt;param name="movie" value="http://www.youtube.com/v/<?=$_GET['video_id'];?>" />&lt;/param>&lt;param name="wmode" value="transparent" />&lt;/param>&lt;embed src="http://www.youtube.com/v/<?=$_GET['video_id'];?>" type="application/x-shockwave-flash" wmode="transparent" width="400" height="325">&lt;/embed>&lt;/object>&lt;br>&lt;a href="<?=$site_url?>"><?=$site_title." - ".$site_slogan?>&lt;/a>' onClick="javascript:this.select();" readonly />
</p>

</div>

<? if ($overall_tag == ""):
         $recent_videos_limit = 30;
         $result = dbquery("SELECT * FROM recent LIMIT ".$recent_videos_limit."");  $check = dbrows($result);
         if ($check > 0) {
        ?>
		<!-- Videos Being Watched Right Now -->
		<div class="left_articles">
		     <marquee direction="left" onmouseover="this.stop()" onmouseout="this.start()"><?
                    while($row = dbarray($result)){
                     echo "
                      <a href=\"".$site_url.$row['video_id']."/".Friendly_URL($row['title']).".html\" title=\"".$row['title']."\">
                      <img src=\"".$row['thumb']."\" style=\"margin-right: 10px; border: 0; width: 100px; height: 70px;\" alt=\"".$row['title']."\"/>
                      </a>";
                    }
              ?></marquee>
		</div>
		<!-- Videos Being Watched Right Now / END -->
        <?
          }endif; ?>
		  
<p><?=ShowCommenting($video_id, $video->title)?></p>


<table border= "0.5">

        <? if ($comments >= 1): ?>
		<div id="comments">
         <?
              while ($comment = dbarray($comments_array)) {
              
                echo '<tr>';
				echo '<td>';
                echo '<img src='.$site_url.'templates/'.$template.'/images/user-icon.png /><br/>';
                                
				echo '</td>';
                echo '<td>';
				if ($comment['uwebsite']){
                    echo '<a rel="nofollow" href="redirect.php?url='.$comment['uwebsite'].'" target="_blank">'.$comment['uname'].'</a>';
                  } else {
                    echo $comment['uname'];
                  }           
                echo '<br />'.strip_html_tags($comment['comment']).'';
				echo '</td>';
                echo '</tr>';
              
              }
          ?>
      
        <? endif; ?>
	  </div>	
			</div>


</table>
</div>
<div id="right">
<div class="right_ads">
<?php include("ads.php"); ?>	
</div>
<div class="right_articles" style="clear:both;">
        <p class="title">Related Videos</p>
        <p>
          <div style="padding:2px; height:450px; overflow: auto;">
            <table style="width: 100%; border: 0" cellspacing="0" cellpadding="0">
            <?
			$relatedFeed = simplexml_load_file($video->relatedURL.'?format=5');

			$i = 0;
                while($i<20){
				$relatedVideo = parseVideoEntry($relatedFeed->entry[$i]);
				$videoid = str_replace("http://www.youtube.com/watch?v=", "",$relatedVideo->watchURL);
				$videoid = str_replace("&feature=youtube_gdata", "",$videoid);
                  if (empty($videoid) or empty($relatedVideo->thumbnailURL)) { $i++; } else {
                    $link = Friendly_URL($relatedVideo->title);
					
                    echo '
                    <tr>
                      <td style="width:101px; text-align: center;">
                        <a href="'.$videoid.'/'.$link.'.html">
                        <img src="'.$relatedVideo->thumbnailURL.'" style="width: 100px; height: 70px; border: 0;" alt="'.$relatedVideo->title.'" title="'.$relatedVideo->title.'" onmouseover="document.getElementById(\"relateds\").innerHTML=\"('.$relatedVideo->title.')\";" onmouseout="document.getElementById(\"relateds\").innerHTML=\"\";" />
                        </a>
                      </td>
                      <td style="padding-left: 3px;" valign="top">
                        <a href="'.$videoid.'/'.$link.'.html">'.$relatedVideo->title.'</a>
                          <div style="padding-top: 10px;">
                            Duration: '.VideoDuration($relatedVideo->length).'
                          </div>
                      </td>
                    </tr>';
                    $i++;
                  }
                }
            ?>
           </table>
         </div>
        </p>
			</div>
<div class="right_articles" style="clear:both;">			
<p class="title">Twitter opinions</p>
<table>
<?php
include('twitterapi.php');
 $smalltitle = first_words( $video->title, 5);
 // echo $smalltitle;
	$twitter_query= $smalltitle;
	$search = new TwitterSearch($twitter_query);
	$results = $search->results();
	
	foreach($results as $result){
	echo '<tr>';
			echo '<td>';
			echo '<img src="'.$result->profile_image_url.'" width="48" height="48" class="twitter_image"> <br /><a href="http://www.twitter.com/'.$result->from_user.'" target="_blank">'.$result->from_user.'</a>';
			$text_n=toLink($result->text);
			echo '</td>';
			echo '<td>';
			echo ''.strip_html_tags($text_n).'';
			echo '</td>';
			
			echo '</tr>';
			}
?>
</table>
		</div>	
		</div>
		
<?php

if ($video->commentsURL && $video->commentsCount > 0) {
      $commentsFeed = simplexml_load_file('http://gdata.youtube.com/feeds/videos/'.$video_id.'/comments?&max-results=50&start-index=1');    
       
      foreach ($commentsFeed->entry as $comment) {
	  $date = date("d/m/y - G:i A");
	  $SQL = 'select count(*) as `num` from comments where 
`author` = \''.cleanQuery($comment->author->name).'\' AND 
`text` = \''.cleanQuery($comment->content).'\' AND 
`video_id` = \''.cleanQuery($video_id).'\' 
LIMIT 1;';
			$Rez = mysql_query($SQL);
			if($Rez){
				if($R['num'] == 0){
					dbquery("INSERT INTO `comments` VALUES (null, '".$video_id."', '".cleanQuery($comment->author->name)."', 'http://www.youtube.com/user/".cleanQuery($comment->author->name)."', '".cleanQuery($comment->content)."', '".cleanQuery($date)."');");
					dbquery("UPDATE `videos` SET comments = comments+1 WHERE video_id = '".$video_id."'");
				}	
			}
			else {
				dbquery("INSERT INTO `comments` VALUES (null, '".$video_id."', '".cleanQuery($comment->author->name)."', 'http://www.youtube.com/user/".cleanQuery($comment->author->name)."', '".cleanQuery($comment->content)."', '".cleanQuery($date)."');");
			    dbquery("UPDATE `videos` SET comments = comments+1 WHERE video_id = '".$video_id."'");
			}
	}
	}



	
?>
		
	<!-- Footer -->
	<?php include("footer.php"); ?>
	<!-- Footer / END -->
		
</div>

<!-- Page Content / END -->
</body>
</html>

