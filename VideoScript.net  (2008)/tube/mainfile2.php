<?php 
if (eregi("mainfile2.php", $_SERVER['PHP_SELF'])) { die(); }
ob_start();

require_once("config.php");
require_once("db.connection.php");
require_once("db.functions.php");


function Friendly_URL($video_id){

 
  
  $new_url= $site_url.'/video/'.$video_id.'/';
  
    return $new_url;
}
function Get_Thumb($video_id){
 $thumb_url= 'http://i4.ytimg.com/vi/'.$video_id.'/2.jpg';
 return $thumb_url;
}
function SpecialChars($string){

  if ( is_array($string) ):
    return $string;
  else:
    return htmlspecialchars($string);
  endif;

}

function Stats($what, $video_id){
              
   $query     = dbquery("SELECT * FROM videos where video_id = '".$video_id."'");
   $query     = dbarray($query);
   
   $result    = $query[$what];
   
   if ($what == "rating"):
            
            $query = dbquery("SELECT * FROM videos WHERE video_id='".$video_id."'");
            $query = dbarray($query);
            
            $rating = $query['rating'];
            $votes  = $query['votes'];
                          
            if ($votes != 0) {
                          
            $rating = $rating / $votes;
            if (strlen($rating) > 2) { $rating = number_format($rating, 2); }
                          
            } else { $rating = 0; }
            
            if ($votes == "") { $votes = 0; }
            
            $result = "Rating: <strong>".$rating."</strong> from <strong>".$votes."</strong> votes.";
            
   elseif ($result == ""):
    $result=0;
   endif;
   
   return $result;
   
}
    
  function VideoDuration($seconds){
    $lenght = $seconds / 60;
    $duration = number_format($lenght, 2);
    
    return ''.$duration.' min';
  }

function Security($string){

  $security_vulns = "DELETE |INSERT |UPDATE |RENAME |MYSQL |SQL ";
  
  $string_check = strtoupper($string);
  $do_it = explode("|", $security_vulns);
  
  static $isok = true;
  
  foreach($do_it as $vuln):
    if ( strstr($string_check, $vuln) ) { $isok = false; }
  endforeach;
  
  if ($isok) { return $string; } else { die(); }

}

function redirect($location, $type="header")
{
  if ($type == "header"):
    header("Location: ".$location);
  else:
    echo "<script type='text/javascript'>document.location.href='".$location."'</script>\n";
  endif;
}

function site_homepage_select($show) {
?>
<select name="site_homepage">
	<option value="random_tag" <?php if($show=='random_tag') echo 'selected="selected"'; ?>>Random tag</option>
	<option value="top_rated" <?php if($show=='top_rated') echo 'selected="selected"'; ?>>Top rated on youtube.com</option>
	<option value="most_viewed" <?php if($show=='most_viewed') echo 'selected="selected"'; ?>>Most viewed on youtube.com</option>
	<option value="most_popular" <?php if($show=='most_popular') echo 'selected="selected"'; ?>>Most popular on youtube.com</option>
	<option value="most_recent" <?php if($show=='most_recent') echo 'selected="selected"'; ?>>Most recent on youtube.com</option>
	<option value="most_discussed" <?php if($show=='most_discussed') echo 'selected="selected"'; ?>>Most discussed on youtube.com</option>
</select>
<?php
}

?>
<?php
function MenuVideos()
{
	$check = dbrows(dbquery("SELECT tagid FROM tags"));
	if($check > 0):
		$result = dbquery("SELECT * FROM tags ORDER BY tcount DESC limit 15");
		while($row = dbarray($result)):
			
			echo "<li><a href=\"show/".str_replace(' ', '+', $row['tag'])."\">".ucfirst($row['tag'])."</a></li>";
			
		endwhile;
	endif;
}
?>
<?php


function is_porn($string) {
$interzis = array('blowjob');
$i = 0;
foreach($interzis AS $cuvant) {
$cuvant = trim($cuvant);
if (preg_match("/$cuvant/i", $string)) {
   $i++;
} else {}
}
if($i==0) { return true; } else { return false; }
}

// Filtering Function

function filterBadWords($str,$badWordsFile) {
  $badFlag = 0;
  if(!is_file($badWordsFile)) {
    echo "ERROR: file missing: ".$badWordsFile;
    exit;
  }
  else {
    $badWordsFH = fopen($badWordsFile,"r");
    $badWordsArray = explode("\n", fread($badWordsFH, filesize($badWordsFile)));
    fclose($badWordsFH);
  }
  foreach ($badWordsArray as $badWord) {
    if(!$badWord) continue; 
    else {
      $regexp = "/\b".$badWord."\b/i";
      if(preg_match($regexp,$str)) $badFlag = 1;
    }
  }
    if(preg_match("/\[url/",$str)) $badFlag = 1;
  return $badFlag;
}


?>