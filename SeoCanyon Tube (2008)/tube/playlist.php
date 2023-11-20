<?php 
require_once('mainfile.php');
require_once('includes/functions.php');
$user_id  = $_REQUEST['id'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Youtube Player</title>

<link rel="stylesheet" type="text/css" href="play/stylesheet.css" />
<script language="javascript" type="text/javascript" src="play/mootools-1.2.3-core.js"></script>
<script language="javascript" type="text/javascript" src="play/mootools-1.2.3.1-more.js"></script>
<script language="javascript" type="text/javascript" src="play/zu.js"></script>
</head>

<body>
	<div id="ZU_movies">
    	<div id="ZU_playback"></div>
  <div id="ZU_playlist">
        	<ul>
<?php 
$result = dbquery("SELECT * FROM playlists WHERE pid = '".$user_id."' ORDER BY RAND() LIMIT 0,100");
while($row = dbarray($result)){

echo '
<li><a class="ZU_video" href="#" rel="{vidId:\''.$row['value'].'\',volume:10, paused: 0, end:0}">'.$row['title'].'</a></li>';

}

?>
</ul>
        </div>
        <div id="infoPanel">
			<span id="movie_state">Loading....</span>
			<a id="playlist_repeat" class="playlist_repeat tooltiped" title="toggle repeat" href="#"></a>  
			<a id="playlist" class="playlist tooltiped" title="toggle playlist" href="#"></a>
		</div>
    </div>
</body>
</html>

 <?php 
ob_end_flush();
?>
