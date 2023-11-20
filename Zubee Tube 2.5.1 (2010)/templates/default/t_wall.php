<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
	
		<title>Wall</title>
		
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		
		<meta name="keywords" content="<?=$site_keywords?>">
		<meta name="description" content="<?=$site_description?>">
		
		<base href="<?=$site_url?>" />
		
		<link href="<?=$site_url?>templates/<?=$template?>/style.css" rel="stylesheet" type="text/css" />
		<link rel="alternate" type="application/rss+xml" title="<?php echo $site_title; ?> Feed" href="<?php echo $site_url; ?>rss" />
		<link rel="shortcut icon" href="<?=$site_url?>templates/<?=$template?>/images/favicon.ico">
		
<link href="<?=$site_url?>templates/<?=$template?>/dropdown/dropdown.css" media="all" rel="stylesheet" type="text/css" />
<link href="<?=$site_url?>templates/<?=$template?>/dropdown/themes/mainmenu/default.ultimate.css" media="all" rel="stylesheet" type="text/css" />

<!--[if lt IE 7]>
<script type="text/javascript" src="js/jquery/jquery.dropdown.js"></script>
<![endif]-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/
libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript">
$(function() 
{
$('.more').live("click",function() 
{
var ID = $(this).attr("id");
if(ID)
{
$("#more"+ID).html('<img src="moreajax.gif" />');

$.ajax({
type: "POST",
url: "ajax_more.php",
data: "lastmsg="+ ID, 
cache: false,
success: function(html){
$("ol#updates").append(html);
$("#more"+ID).remove(); // removing old more button
}
});
}
else
{
$(".morebox").html('The End');// no results
}

return false;
});
});
</script>
	</head>
	
<body>

<!-- Page Content -->
<div id="content">
	<?php include("header.php"); ?>
	<div id="featured">
	<script type='text/javascript' src='embed/swfobject.js'></script>
 
<div id='mediaspace'>Pls update your Flash Player!</div>
 
<script type='text/javascript'>
  var so = new SWFObject('embed/player.swf','mpl','960','350','9');
  so.addParam('allowfullscreen','true');
  so.addParam('allowscriptaccess','always');
  so.addParam('wmode','opaque');
  so.addVariable('playlistfile','http://gdata.youtube.com/feeds/api/standardfeeds/top_rated?time=today');
  so.addVariable('playlistsize','300');
  so.addVariable('playlist','right');
  so.addVariable('stretching','fill');
  so.write('mediaspace');
</script>
</div>
	<!-- Left Side Content -->
	<div id="left">
	
	
		<? if ($overall_tag == ""):
         $recent_videos_limit = 30;
         $result = dbquery("SELECT * FROM recent LIMIT ".$recent_videos_limit."");  $check = dbrows($result);
         if ($check > 0) {
        ?>
		<!-- Videos Being Watched Right Now -->
		<div class="left_articles">
		<h2>Videos Being Watched Right Now</h2><br />
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
			
		<!-- Search Results & Random Videos -->
		<div class="left_articles">
		<a href="<?=$site_url?>wall.php"><h2>Status Wall</h2></a><br/>
		
	<div id='tweet_container'>
<ol class="timeline" id="updates">	
<?php
// Let's get the tweets
$sql = dbquery("SELECT * FROM timeline ORDER BY tid DESC LIMIT 25");
while($row = mysql_fetch_array($sql)) {
$name = $row['user'];
$tweet = toLink($row['tweets']);
$msg_id = $row['tid'];
echo '<li>';
echo '<a href="'.$site_url.'user/'.$name.'">'.$name.'</a> : ';
echo $tweet;
echo '</li>';
}

?>
</ol>
<div id="more<?php echo $msg_id; ?>" class="morebox">
<a href="#" class="more" id="<?php echo $msg_id; ?>">more</a>
</div>

</div>

		</div>
		<!-- Pages / END -->
			
	</div>
	<!-- Left Side Content / END -->
	
	<!-- Right Side Content -->
	<div id="right">
	
        
        <?php include("sidebar.php"); ?>	
	</div>
	<!-- Right Side Content / END -->
	
	<!-- Footer -->
	<?php include("footer.php"); ?>
	<!-- Footer / END -->
		
</div>
<!-- Page Content / END -->
</body>
</html>