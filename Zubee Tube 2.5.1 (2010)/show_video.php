<? 
require_once('mainfile.php');

if ($_GET['video_id'] == "") { redirect($site_url); } {

require_once("includes/class/apifunctions.php");
	
$video_id = $_GET['video_id'];
	
// set video data feed URL
$feedURL = 'http://gdata.youtube.com/feeds/api/videos/'.$video_id;
// read feed into SimpleXML object
$entry = simplexml_load_file($feedURL);
$video = parseVideoEntry($entry);
	
$meta_description = str_replace('"', '-', $video->description);
$meta_description = substr($meta_description, 0, 150);
  
$description = $video->description;
if(!is_porn($video->title) OR !is_porn($video->description)) { header("location:$site_url/index.php?msg=That%20video%20is%20banned!%20Try%20more%20non-adult%20searches%20pls!"); } else {  
if ($video->thumbnailURL != ""):
	
	$check = dbrows(dbquery("SELECT id FROM videos WHERE video_id = '".$video_id."'"));
				
	if($check == 0):
		dbquery("INSERT INTO videos VALUES (NULL, '".mysql_real_escape_string($video_id)."', '".mysql_real_escape_string($video->thumbnailURL)."', '".mysql_real_escape_string($video->title)."', '1', '0', '0', '0')");
	else:
		dbquery("UPDATE videos SET views=views+1 WHERE video_id = '".mysql_real_escape_string($video_id)."'");
	endif;

	$check = dbrows(dbquery("SELECT * FROM recent WHERE video_id = '".$video_id."'"));
        
	if($check == 0):
		$gtitle = str_replace("'", "-", $video->title);
		dbquery("INSERT INTO recent VALUES ('".$video_id."', '".$video->thumbnailURL."', '".$gtitle."', '".time()."')");
	else:
		dbquery("UPDATE recent SET time='".time()."' WHERE video_id = '".mysql_real_escape_string($video_id)."'");
	endif;
        
endif;
}

/*-----------------------------------------*/
 



$showvideofunctions= 'ZnVuY3Rpb24gZ2V0Zm9vdGVyKCkgew0KZ2xvYmFsICRzaXRlX3VybCwgJHRlbXBsYXRlOw0KCSRsID0gJzxhIGhyZWY9Imh0dHA6Ly93d3cucm95YWx3YXlzLnJvIiB0aXRsZT0iU2VydmljaWkgU0VPIiB0YXJnZXQ9Il9ibGFuayI+U0VPPC9hPic7DQoNCgkkZiA9IGZpbGVfZ2V0X2NvbnRlbnRzKCRzaXRlX3VybC4idGVtcGxhdGVzLyIuJHRlbXBsYXRlLicvZm9vdGVyLnBocCcpOw0KCSBpZiAoc3RycG9zKCRmLCAkbCkgPT0gMCkgew0KDQoJZWNobyAnPHN0cm9uZz5IZWxsbyEgV2VsY29tZSB0byBadWJlZSBUdWJlISA8YnIvPiBJZiB5b3UgaGF2ZW5cJ3Qgc2V0dXAgY29yZWN0bHkgeW91ciB3ZWJzaXRlIHVybCBpbiBjb25maWcucGhwIHlvdVwnbGwgZ2V0IHRoaXMgZXJyb3IhIDxici8+IElmIHlvdSBoYXZlIHJlbW92ZWQgdGhlIHByb3RlY3RlZCBsaW5rIGluIHRlbXBsYXRlXCdzIGZvb3RlciwgdGhpcyBzY3JpcHQgd2VcJ2xsIG5vIGxvbmdlciB3b3JrISA8YnIvPlB1dCBiYWNrIHRoZSBsaW5rIHRvIG91ciBzZW8gd2Vic2l0ZSBvciBzZXR1cCBjb3JlY3Qgd2Vic2l0ZSBsaW5rIGluIGFkbWluIHRvIGNvbnRpbnVlIHVzaW5nIFp1YmVlIFR1YmUhPC9zdHJvbmc+IDxici8+IElmIHlvdSBkb25cJ3QgaGF2ZSB0aGUgbGluayBqdXN0IHBhc3RlIHRoaXMgaW4geW91ciB0aGVtZSBmb290ZXIucGhwIGZpbGU8YnIvID4nOw0KZWNobyAnPHRleHRhcmVhPg0KCTxhIGhyZWY9Imh0dHA6Ly93d3cucm95YWx3YXlzLnJvIiB0aXRsZT0iU2VydmljaWkgU0VPIiB0YXJnZXQ9Il9ibGFuayI+U0VPPC9hPg0KCTwvdGV4dGFyZWE+JzsNCiAgICANCg0KCX0NCg0KfQ0KDQoNCmdldGZvb3RlcigpOw==';
base64_decode($showvideofunctions);


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
			if ($tag != ""): $tag_links .= '<a href="show-videos/'.$tag.'" style="color:blue;">'.$tag.'</a>, ';
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

/*-----------------------------------------*/
	
function ShowRating($video_id)
{

	echo "
            <script type=\"text/javascript\">
              function SH_Rating()
              {
                el = document.getElementById('voting');
                if (el.style.display == 'none')
                {
                  el.style.display = '';
                  elink = document.getElementById('sh_voting');
                  elink.innerHTML = 'Hide Rating';
                } else {
                  el.style.display = 'none';
                  elink = document.getElementById('sh_voting');
                  elink.innerHTML = 'Rate this video';
                }
              }
            </script>
      ";
      
	echo "<a href=\"#\" id=\"sh_voting\" onclick=\"SH_Rating(); return false;\">Rate this video</a>";
      
	echo "<div id=\"voting\" style=\"display: none;\">";
	echo "<select onchange=\"new Ajax.Request('/rating.php?video_id=".$video_id."&rating='+this.options[this.selectedIndex].value); document.getElementById('voting').innerHTML='Thank you!';\">";
	echo "<option value=\"1\">1</option>";
	echo "<option value=\"2\">2</option>";
	echo "<option value=\"3\">3</option>";
	echo "<option value=\"4\">4</option>";
	echo "<option value=\"5\">5</option>";
	echo "<option value=\"6\">6</option>";
	echo "<option value=\"7\">7</option>";
	echo "<option value=\"8\">8</option>";
	echo "<option value=\"9\">9</option>";
	echo "<option value=\"10\">10</option>";
	echo "</select>";
	echo "</div>";
	
}

/*-----------------------------------------*/

function ShowCommenting($video_id, $title)
{
    echo "
            <script type=\"text/javascript\">
              function SH_CommentForm()
              {
                el = document.getElementById('commenting');
                if (el.style.display == 'none')
                {
                  el.style.display = '';
                  elink = document.getElementById('sh_commenting');
                  elink.innerHTML = 'Hide Comment Form';
                } else {
                  el.style.display = 'none';
                  elink = document.getElementById('sh_commenting');
                  elink.innerHTML = 'Post Your Comment';
                }
              }
            </script>
    ";
    
	echo "<h2>".Stats('comments', $video_id)." Comments (<a href=\"#\" id=\"sh_commenting\" onclick=\"SH_CommentForm(); return false;\" style=\"font-size: 14px;\">Click here to post!</a>)</h2>";
      
	echo '<div id="commenting" style="display: none; border: 1px dotted gray; padding-left: 10px; margin-top: 10px;">';
	echo '<form id="comment_form" action="'.$site_url.'commenting.php" method="post">';
	echo '<input type="hidden" name="redirect" value="'.$video_id.'-X-'.$title.'"  />';
	echo '<label for="uname">Username:</label><br /><input type="text" size="25" id="uname" name="uname" class="comment_form_input" /><br />';
	echo '<label for="uwebsite">Website:</label><br /><input type="text" size="25" id="uwebsite" name="uwebsite" class="comment_form_input" /><br />';
	echo '<label for="comment">Your Comment:</label><br /><textarea rows="4" cols="70" id="comment" name="comment" class="comment_form_input"></textarea><br /><br />';
	echo '<input type="submit" value="Post Comment" name="post_comment" />';
	echo '</form><br />';
	echo '</div>';
	
}

/*-----------------------------------------*/
	
$comments       = dbcount("*", "videos", "video_id = '".$video_id."'");
$comments_array = dbquery("SELECT * FROM comments WHERE vid='".$video_id."' ORDER BY id DESC");

 
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

ob_end_flush();
?>
