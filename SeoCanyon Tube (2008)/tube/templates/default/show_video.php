<?php

//start like system

$check = dbrows(dbquery("SELECT * FROM zu_ratings WHERE vid = '".$video_id."'"));	
	 if($check == 0) {
	 
	 $insert = dbquery("INSERT INTO `zu_ratings` (`vid`, `liked`, `dislike`) VALUES
('".$video_id."', 2, 1)");

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.ohtml4/strict.dtd">

<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title><?php echo $before_title ?> <?php echo $video->title ?> <?php echo $after_title ?></title>

		

		<meta http-equiv="content-type" content="text/html; charset=utf-8">

		

		<meta name="keywords" content="<?=$video->keywords?>">

		<meta name="description" content="<?php echo $meta_description?>">

		<meta name="video_type" content="application/x-shockwave-flash" /> 

        <meta name="medium" content="video" /> 

		<meta property="og:title" content="<?php echo $video->title ?>" /> 

        <meta property="og:url" content="<?php echo $site_url.'video/'.$video_id.'/'; ?>" /> 

        <meta property="og:description" content="<?php echo $meta_description?>" /> 

        <meta property="og:image" content="<?php echo $site_url.'media.php?type=big&id='.$video_id; ?>" /> 

		<base href="<?=$site_url?>" />

    <!-- Zubee's STYLESHEET --> 
<link href="<?=$site_url?>templates/<?=$template?>/style.css" rel="stylesheet" type="text/css" />
<link href="<?=$site_url?>templates/<?=$template?>/css/jquery.tweet.css"  media="all" rel="stylesheet" type="text/css"/>
<!-- Zubee's Javascripts --> 
<script type="text/javascript" src="<?=$site_url?>templates/<?=$template?>/js/iepngfix_tilebg.js"></script>
	<!--[if IE 7]>	
	<link rel="stylesheet" href="<?=$site_url?>templates/<?=$template?>/css/ie7.css" type="text/css" media="screen" title="ie8" charset="utf-8" />
	<![endif]-->
<!--[if IE 6]>
<script src="<?=$site_url?>templates/<?=$template?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
<link rel="stylesheet" href="css/ie6.css" type="text/css" media="screen," />
<script>
  
  DD_belatedPNG.fix('#header'); 
  DD_belatedPNG.fix('.pngfix'); 
 
</script>
<![endif]--> 


<link rel="stylesheet" href="<?=$site_url?>templates/<?=$template?>/css/general.css" type="text/css" media="screen" />

<link rel="shortcut icon" href="<?=$site_url?>templates/<?=$template?>/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="<?php echo $site_title; ?> Feed" href="<?php echo $site_url; ?>rss" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write('<script src="<?=$site_url?>templates/<?=$template?>/js/jquery/jquery-1.4.2.min.js"><\/script>')</script>
	
	<script type="text/javascript" src="<?=$site_url?>templates/<?=$template?>/js/cufon/cufon-yui.js"></script>
	<script type="text/javascript" src="<?=$site_url?>templates/<?=$template?>/js/jquery.tweet.js"></script>
	<script type="text/javascript" src="<?=$site_url?>templates/<?=$template?>/js/cufon/TitilliumText22L_300.font.js"></script>	
		<script type="text/javascript" src="<?=$site_url?>templates/<?=$template?>/js/main.js"></script>	
		<script type="text/javascript" src="<?=$site_url?>templates/<?=$template?>/js/tabs.js"></script>
        <script type="text/javascript" src="<?=$site_url?>templates/<?=$template?>/js/jquery.livequery.js"></script>
        

<script type="text/javascript">
    jQuery(document).ready(function($) {	
$("#query").tweet({
        avatar_size: 48,
        count: 15,
        query: "<?php echo $video->title ?>",
        loading_text: "searching twitter for <?php echo $video->title ?>...",
		refresh_interval: 15
      });	  
 })
  </script>	  

<script type="text/javascript">

 $(document).ready(function() {

	$('.like_button').mouseenter(function(e) {

		$('.tooltip').show();

		$('.ilikethis').fadeIn(200);

	}).mouseleave(function(e) {

		$('.ilikethis').fadeOut(200);

		$('.tooltip').hide();

	});

	$('.dislike_button').mouseenter(function(e) {

		$('.tooltip2').show();

		$('.idislikethis').fadeIn(200);

	}).mouseleave(function(e) {

	   $('.tooltip2').hide();

		$('.idislikethis').fadeOut(200);

	});

	

	$('.totalstatsbutton').livequery("mouseenter", function(e){

		$('.greenBar').css("background-color","#AADA37");

		 $('.redbar').css("background-color","#CF362F");

		$('.tooltip3').show();

		$('.totalstats').fadeIn(200);

	}).livequery("mouseleave", function(e){

		$('.tooltip3').hide();

		$('.greenBar').css("background-color","#DDDDDD");

		$('.redbar').css("background-color","#DDDDDD");

		$('.totalstats').fadeOut(200);

	});

});



$(document).ready(function(){	

	//$('#voting_result').fadeOut();

	$('button').click(function(){

		var a = $(this).attr("id");
		var b = "<?php echo $video_id;?>";
		var dataString = 'value='+ a + '&val=' + b;

		

		$.post("voting.php?"+ dataString, {

		}, function(response){

			$('#voting_result').fadeIn();

			$('#voting_result').html($(response).fadeIn('slow'));

			// now update box bar			
            
			$.post("update_box.php"+ dataString, {

			}, function(update){

				$('#update_count').html(unescape(update));				

			});

			////////////

			// now update tooltip count			

			$.post("update_tooltip.php"+ dataString, {

			}, function(updates){

				$('.tooltip3').html(unescape(updates));				

			});

			////////////

		});

	});	

});	



function hideMesg(){



	$('.rating_message').fadeOut();

}	

</script>



</head>

<body>
	<!--START HEADER  -->
    <div id="header">
    
      <div id="head_wrap" class="container_12">
            
           <!--START LOGO  --> 
           <div id="logo" class="grid_8">
           
           		<h2><strong><?=$site_title?></strong></h2>
        </div>
           <!-- END LOGO -->
        
          <!-- START USERPANEL --> 
          <div id="user_panel" class="grid_4">
           <?php include("usermenu.php"); ?>	
            
    </div>
          <!-- END USERPANEL --> 
        
        
			<!--START NAVIGATION  -->
            <div id="nav" class="grid_12">
            
            <!-- Start .zumega -->
<div class="zumega red">
 <?php include("menu.php"); ?>	
	
</div> <!-- .zumega --> 
                
                    
        </div>
        <!-- END NAV -->       
         
          
   	 </div>
     <!-- END HEAD_WRAP (CONTAINER FOR LOGO AND NAVIGATION -->
     
    </div>
    <!--END HEADER (FULLL WIDTH WRAPPER WITH BG) -->
	      
 <div id="content" class="container_16">
 
 <div class="grid_16">
        <div class="grid_11">
 <?php echo '<h1>'.$video->title.'</h1>'; ?>
 <hr>
<script type="text/javascript" src="<?=$site_url?>embed/swfobject.js"></script>
<div id="mediaspace">

You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and

	a browser with JavaScript support.

</div>

 

<script type='text/javascript'>

  var so = new SWFObject('<?=$site_url?>embed/player.swf','mpl','640','380','9');

  so.addParam('allowfullscreen','true');

  so.addParam('allowscriptaccess','always');

  so.addParam('wmode','opaque');

  so.addVariable('file','http://www.youtube.com/watch?v=<?php echo $video_id; ?>');

  so.addVariable('image','http://i2.ytimg.com/vi/<?php echo $video_id; ?>/0.jpg');

  so.addVariable('controlbar','over');

  so.addVariable('logo.file','http://www.videoinedit.com/player/playerlogo.png');
   
  so.addVariable('autostart','true');

  so.addVariable('logo.hide','false');

  so.addVariable('logo.position','top-left');

  so.addVariable('stretching','fill');

 

  so.write('mediaspace');

 

</script>
<div class="grid_11">
<div class="grid_4">
<div align="left" style="margin-left:0px;">
	<button type="button" class="like_button" onClick=";return false;" id="like" >

	<img src="pixel-vfl73.gif" alt=""> 

	<span>Like</span></button>



	&nbsp;

	

	<button  type="button" class="dislike_button" onClick=";return false;" id="dislike" >

	<img src="pixel-vfl73.gif" alt=""> 

	</button>



	&nbsp;

	<div id="update_count" style="float:left;">
<?php include('templates/'.$template.'/update_box.php'); ?>
		

	</div>
	<br clear="all" /><br clear="all" />
	<div align="left" style="height:0px;">

		<div class="tooltip">

			<span class="ilikethis">

			I like this

			</span>

		</div>

		<div class="tooltip2">

			<span class="idislikethis">

			I dislike this

			</span>

		</div>

		<div class="tooltip3">
<?php include('templates/'.$template.'/update_tooltip.php'); ?>
			</div>

	</div>


	
</div>
</div>
<div class="grid_7">
<div class="grid_4">
<div class="grid_2">
 <fb:like href="<?php echo $site_url.'video/'.$video_id.'/'; ?>" layout="button_count" width="200"></fb:like>
   </div>
 <div class="grid_2">
 <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="MisterDevil">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
   </div>
 	  </div>
 <div class="grid_3">
<?php


$add = '<form id="form1" name="form1" method="post" action="">
  <label><input type="submit" name="addto" id="addto" value="Add to playlist" class="glowbutton pink" /></label>
</form>
';

$remove = '<form id="form1" name="form1" method="post" action="">
  <label><input type="submit" name="remto" id="remto" value="Playlist remove" class="glowbutton red" /></label>
</form>
';

//echo $add;

//echo $video_id;
if($_SESSION['id']){
$sql = mysql_query("SELECT id FROM playlists WHERE pid='".$_SESSION['id']."'");
$numpl = mysql_num_rows($sql);

//user-right - add/remove from playlist
$sql = mysql_query("SELECT id FROM playlists WHERE value='$video_id' AND pid='".$_SESSION['id']."'");
if(!$sql){
	die('error ' . mysql_error());
	}
$numr = mysql_num_rows($sql);
	if($numr==0){
		echo $add;
		if(isset($_POST['addto'])){
			$vtitle = addslashes($video->title);
			
			//echo $vtitle;
			echo $video_description = addslashes($video_description);
			$sql = "INSERT INTO `playlists` (`pid`, `value`, `title`) VALUES ('".$_SESSION['id']."','".$video_id."','".$vtitle."')"; 
			
			$sql = mysql_query($sql);
			if(!$sql){
				die('error 2 ' . mysql_error());
				} 
		} 
		
			 
		
		}else {
		echo $remove;
		if(isset($_POST['remto'])){
			
			$sql2 = mysql_query("DELETE FROM playlists WHERE pid='".$_SESSION['id']."' AND value='$video_id'");
			if(!$sql2){
				die('error ' . mysql_error());
				}  
		}		
		}	
		
		
//end statament

echo $numpl.' videos in <a href="../../playlist.php?id='.$_SESSION['id'].'">playlist</a>.';		

}


?>
		  </div>
</div>
</div>
<div class="grid_11">
<div id="voting_result">
</div>
</div>

<div class="grid_11">
          <div class="grid_5">
         <h3> <?php echo 'Video by '.$video->author;  ?>	</h3>
		 <?php 
 $authorFeed = simplexml_load_file('http://gdata.youtube.com/feeds/api/users/'.$video->author);  
$authorData = $authorFeed->children('http://gdata.youtube.com/schemas/2007');
	$attrs = $authorData->statistics->attributes();
    $viewCount = $attrs['viewCount']; 
	$subscriberCount = $attrs['subscriberCount'];
    $media = $authorFeed->children('http://search.yahoo.com/mrss/');
	$attrs = $media->thumbnail[0]->attributes();
    $athumbnail = $attrs['url']; 

	?>
	<div class="grid_2">
	<center> <?php echo ' <a href="'.$site_url.'profile/'.$video->author.'"><img src="'.$athumbnail.'" border="0" width="100" height="80"/></a>'; ?> <br /><?php echo ' <a href="'.$site_url.'profile/'.$video->author.'">'.$video->author.'</a>'; ?>	</center>
	</div>
	<div class="grid_2">
	<?php  echo 'Views: '.$viewCount.'<br />Subscribers: '.$subscriberCount;
	echo '<br />';
	if (!empty($authorData->gender)) {
    echo 'Gender: '.strtoupper($authorData->gender);
	echo '<br />';
	}
	if (!empty($authorData->location)) {
    echo 'Location: '.$authorData->location;	
	}
	
	?>
	
	</div>
 </div>
         <div class="grid_5">
<h3>Video Description</h3>
          <p><?=$meta_description.'...'?>	
		  <br /><? VideoTags($video->keywords); ?></p>
</div>	 
</div>		  
<div class="grid_11">
      
 <div id="container">
		<ul class="menu">
			<li id="ucomments">Comments</li>
			<li id="utweets">Tweets about the video</li>
			<li id="videoresp">Video Responses</li>
		</ul>
		<span class="clear"></span>
		<div class="content ucomments">
			<h3>Comment it with Facebook </h3>
<fb:comments xid="<?php echo $video_id; ?>" numposts="40" width="455"></fb:comments>
			
		</div>
		<div class="content utweets">
		<h3>Tweets on <?php echo $video->title ?> </h3> 
<div id="query" class='query'></div>
		
		</div>
		<div class="content videoresp">
			
<h3>Video comments on <?php echo $video->title ?></h3>
<table style="width: 100%; border: 0" cellspacing="0" cellpadding="0">

<?php if ($video->responsesURL) {
$responseFeed = simplexml_load_file($video->responsesURL);  


	 ?>
<?php
    $ij = 1;
      foreach ($responseFeed->entry as $response) {

        $responseVideo = parseVideoEntry($response);

      	$responseid = str_replace("http://www.youtube.com/watch?v=", "",$responseVideo->watchURL);

		$responseid = str_replace("&feature=youtube_gdata", "",$responseid);

		$responseid = str_replace("_player", "",$responseid);

        $response_link = Friendly_URL($responseid);
if($ij%2==0) {
					echo '<tr style="background-color:#eee">';
					}
					else {
					 echo '<tr>';
					}
		

                     echo'<td style="width:101px; text-align: center;">';

        echo '<a href="'.$response_link.'" title="'.$responseVideo->title.'">

        <img src="'.Get_Thumb($responseid).'" style="width:99px;height:56px;border: 0;" alt="'.$responseVideo->description.'" style="width: 100px; height: 70px; border: 0;" /></a>';

		echo '</td>

                      <td style="padding-left: 3px;" valign="top">';

					  echo '<a href="'.$response_link.'" title="'.$responseVideo->title.'">'.$responseVideo->title.'</a>';

					   echo '<div style="padding-top: 5px;">

                            Duration: '.VideoDuration($responseVideo->length).' | Author : <a href="'.$site_url.'/profile/'.$responseVideo->author.'">'.$responseVideo->author.'</a>

                          </div>';

     echo '</td>

                    </tr>';

       $ij++;

      }

 	    

    }

?>
</table>
			
		</div>
	</div>


</div>



</div>

		 <div class="grid_5">
		
		 <h3>Related Videos</h3>
		
	<p> <table style="width: 100%; border: 0" cellspacing="0" cellpadding="0">

            <?

			$relatedFeed = simplexml_load_file($video->relatedURL.'?format=5');



			$i = 0;
            $iz = 1;
                while($i<20){

				$relatedVideo = parseVideoEntry($relatedFeed->entry[$i]);

				$videoid = str_replace("http://www.youtube.com/watch?v=", "",$relatedVideo->watchURL);

				$videoid = str_replace("&feature=youtube_gdata", "",$videoid);

				$videoid = str_replace("_player", "",$videoid);

                  if (empty($videoid) or empty($relatedVideo->thumbnailURL)) { $i++; } else {

                    $related_link = Friendly_URL($videoid);

					if($iz%2==0) {
					echo '<tr style="background-color:#eee">';
					}
					else {
					 echo '<tr>';
					}

                    echo '

               

                      <td style="width:101px; height:56px; text-align: center;">

                        <a href="'.$related_link.'">

                        <img src="'.Get_Thumb($videoid).'" style="width:99px;height:56px;border: 0;" alt="'.$relatedVideo->title.'" title="'.$relatedVideo->title.'" onmouseover="document.getElementById(\"relateds\").innerHTML=\"('.$relatedVideo->title.')\";" onmouseout="document.getElementById(\"relateds\").innerHTML=\"\";" />

                        </a>
                      </td>
                      <td style="padding-left: 3px;height:56px;" valign="top" width="150px">

                        <a href="'.$related_link.'"><small>'.substr($relatedVideo->title,0,60).'...</small></a>
       </td>
</tr>';

                    $i++;
					$iz++;

                  }

                }

            ?>

           </table></p>
		</div>
	  </div>	
 
  
	  <div class="grid_16">
	  <hr>
      <h2 class="alt"><?php echo $video->title.'</a> Video uploaded by '.$video->author; ?></h2>
      <hr>
      <p>
        &copy; 2010 <a href="<?=$site_url?>">   <?php echo $site_title ?>
        </a> </p>
		  </div>	
 
 <div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#appId=<?php echo $fbappis ?>&amp;xfbml=1"></script>
 </div>	
	</body>
	</html>