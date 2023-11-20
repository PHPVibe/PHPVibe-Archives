<? 

require_once('mainfile.php');
require_once('includes/functions.php');



if ($_GET['video_id'] == "") { redirect($site_url); } {



require_once("apifunctions.php");

$video_id = str_replace('_player','',$_GET['video_id']);	

$video_id = str_replace('/','',$_GET['video_id']);



	

// set video data feed URL

$feedURL = 'http://gdata.youtube.com/feeds/api/videos/'.$video_id;

// read feed into SimpleXML object

$entry = simplexml_load_file($feedURL);

$video = parseVideoEntry($entry);	

$meta_description = str_replace('"', '-', $video->description);

$meta_description = substr($meta_description, 0, 150);  

$description = $video->description;

$video_views = $video->viewCount;

$video_yt_rate = $video->rating;

$video_time = number_format( $video->length/60, 2 );




/*-----------------------------------------*/

 // set author data feed URL

$authorFeed = simplexml_load_file($video->authorURL);   

$authorData = $authorFeed->children('http://gdata.youtube.com/schemas/2007');





/*-----------------------------------------*/





function Keywords($keywords)

{

	$keywords_array = explode(' ', $keywords);

	if (count($keywords_array) > 0):

		foreach ($keywords_array as $keyword):

			if ($keyword != ""):

				$rkeywords .= $keyword.', ';

			endif;

		endforeach;

	else:

		$rkeywords = '';

	endif;

		

	if (substr($rkeywords, -2) == ", "):

		return substr($rkeywords, 0, -2);

	else:

		return $rkeywords;

	endif;

}



/*-----------------------------------------*/



function VideoTags($tags)

{

	$tags_array = explode(', ', $tags);

	if (count($tags_array) > 0):

		foreach ($tags_array as $tag):

			if ($tag != ""): $tag_links .= '<a href="show/'.$tag.'">'.$tag.'</a>, ';

			endif;

		endforeach;

	else:

		$tag_links = '';

	endif;

		

	if (substr($tag_links, -2) == ", "):

		echo substr($tag_links, 0, -2);

	else:

		echo $tag_links;

	endif;

}





// Show Template

if(isset($template)):

	if(is_file('templates/'.$template.'/show_video.php')):

		require_once('templates/'.$template.'/show_video.php');

	else:

		die("Your template appears to be corrupt. Try re-uploading the folder.".'/templates/'.$template.'/index.php');

	endif;

else:

	die("Your default template doesn't appear to be set.");

endif;

  

}

$check = dbrows(dbquery("SELECT * FROM recent WHERE video_id = '".$video_id."'"));

        if($check == 0):

       $gtitle = str_replace("'", "-", $video->title);
		
	 	  
	    $insert = dbquery("INSERT INTO recent (`video_id`, `thumb`, `title`, `time`, `duration` ) VALUES ('".addslashes($video_id)."', '".$video->thumbnailURL."', '".addslashes($gtitle)."', '".time()."' , '".$video_time."')");
		
	else:

	dbquery("UPDATE recent SET time='".time()."' WHERE video_id = '".mysql_real_escape_string($video_id)."'");

	endif;
	

//$checkvideo = dbrows(dbquery("SELECT * FROM videos WHERE video_id = '".$video_id."'"));

       /* if($checkvideo == 0):

       $thetitle = str_replace("'", "-", $video->title);
		
	    $insertvideo = dbquery("INSERT INTO videos (`video_id`, `description`, `title`) VALUES ('".addslashes($video_id)."', '".addslashes($description)."', '".addslashes($thetitle)."')");		
	endif;
*/

ob_end_flush();

?>

