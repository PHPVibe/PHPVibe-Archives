<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
	
		<title>Member List</title>
		
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
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<script type="text/javascript" src="js/jquery/jquery.dropdown.js"></script>
<![endif]-->

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
		<table border="0" align="center">
<?php
echo '<tr>';
echo '<td width="90">';
echo 'Member';
echo '</td>';


echo '<td width="60">';
echo 'Location';
echo '</td>';

echo '<td width="180">';
echo 'About';
echo '</td>';

echo '<td width="140">';
echo 'Blog';
echo '</td>';

echo '<td width="50">';
echo 'Tweets';
echo '</td>';

echo '<td width="50">';
echo 'Followers';
echo '</td>';
echo '</tr>';

while($row = mysql_fetch_array($sql)) {
$name = $row['uname'];
$avatar = $row['uimg'];
$city = $row['uloc'];
$details = $row['uabout'];
$blog = $row['uweb'];
$tweets = $row['utweet'];
$followers = $row['ufollow'];


echo '<tr>';
echo '<td width="90">';
echo '<a href="'.$site_url.'user/'.$name.'"><img src="'.$avatar.'"/></a>';
echo $name;
echo '</td>';


echo '<td width="60">';
echo $city;
echo '</td>';

echo '<td width="180">';
echo $details;
echo '</td>';

echo '<td width="140">';
echo '<a href="'.$blog.'" target="_blank">Visit '.$name.'\'s blog</a>';
echo '</td>';

echo '<td width="50">';
echo $tweets;
echo '</td>';

echo '<td width="50">';
echo $followers;
echo '</td>';
 echo '</tr>';
}
?>
</table>

<center>

</center>
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