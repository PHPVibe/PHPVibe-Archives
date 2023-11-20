<?php 
if (eregi("mainfile.php", $_SERVER['PHP_SELF'])) { die(); }
ob_start();

require_once("config.php");
require_once("includes/db.connection.php");
require_once("includes/db.functions.php");
// include Epi classes for Twitter
require_once 'keys.php';
require_once 'EpiCurl.php';
require_once 'EpiOAuth.php';
require_once 'EpiTwitter.php';


$settings = dbquery("SELECT * FROM settings");
$settings = dbarray($settings);


$site_title          = $settings['site_title'];
$site_slogan         = $settings['site_slogan'];
$site_description    = $settings['site_description'];
$site_keywords       = $settings['site_keywords'];
$dev_id              = $settings['dev_id'];

if (empty($settings['site_homepage'])) 
$site_homepage="most_popular";
else $site_homepage = $settings['site_homepage'];
;
$autoplay            = $settings['autoplay'];
$template            = $settings['template'];

$feautured_video_id    = $settings['fvideo_id'];
$feautured_video_title = $settings['fvideo_title'];
	
	if (substr($site_url, -1) != "/"):
    $new_site_url = $site_url;
    $site_url = $new_site_url.'/';
	endif;

function Friendly_URL($url){

  $new_url = preg_replace("/[^a-z0-9\\040]/i", "", $url);
  
  if ( strstr($new_url, " ") ) { $new_url = str_replace(" ", "-", $new_url); }
  if ( strstr($new_url, "--") ) { $new_url = str_replace("--", "-", $new_url); }
  if ( strstr($new_url, "amp-") ) { $new_url = str_replace("amp-", "-", $new_url); }
  if ( strstr($new_url, "amp") ) { $new_url = str_replace("amp", "", $new_url); }
  
    return $new_url;
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
    
    return '['.$duration.' min]';
  }

function Security($string){

  $security_vulns = "DELETE |INSERT INTO |UPDATE ";
  
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
			
			echo "<li><a href=\"show-videos/".str_replace(' ', '+', $row['tag'])."\">".ucfirst($row['tag'])."</a></li>";
			
		endwhile;
	endif;
}
?>
<?php

function first_words($string, $num)
{
        /** words into an array **/
        $words = str_word_count($string, 2);

        /*** get the first $num words ***/
        $firstwords = array_slice( $words, 0, $num);

        /** return words in a string **/
        return  implode(' ', $firstwords);
}

function strip_html_tags( $text )
{
    $text = preg_replace(
        array(
          // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
          // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
        ),
        array(
            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
            "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
            "\n\$0", "\n\$0",
        ),
        $text );
    return strip_tags( $text );
}

function cleanQuery($string){
if(get_magic_quotes_gpc()){
$string = stripslashes($string);
}
if (phpversion() >= '4.3.0'){
$string = mysql_real_escape_string($string);
}
else{
    $string = mysql_escape_string($string);
}
return $string;
}

function newmembers() {
$sql = dbquery("SELECT * FROM users ORDER BY uid DESC LIMIT 6");
 $j=1;
 echo '<table width="90%">';
while($row = mysql_fetch_array($sql)) {
$name = $row['uname'];
$avatar = $row['uimg'];
$details = $row['uabout'];
$tweets = $row['utweet'];
$followers = $row['ufollow'];

if ($j == "1" or $j == "4" ) {
echo '<tr>';
}
echo '<td width="30%">';
echo '<a href="'.$site_url.'user/'.$name.'" title="'.$details.'"><img src="'.$avatar.'" alt="'.$details.'"/></a>';
echo '<br/><a href="'.$site_url.'user/'.$name.'" title="'.$details.'"><strong>'.$name.'</strong></a><br/>';
echo '</td>';
if ($j == "3" or $j == "6" ) {
echo '</tr>';
}
$j++;

}
if(($j % 3) != 0) {
echo '</tr>';
}
echo '</table>';
}

function is_porn($string) {
$interzis = array('sex','xxx','porn', 'annal', 'Porn', 'slut', 'blowjob');
$i = 0;
foreach($interzis AS $cuvant) {
$cuvant = trim($cuvant);
if (preg_match("/$cuvant/i", $string)) {
   $i++;
} else {}
}
if($i==0) { return true; } else { return false; }
}


function toLink($text){
        $text = html_entity_decode($text);
        $text = " ".$text;
        $text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
                '<a href="\\1">\\1</a>', $text);
        $text = eregi_replace('(((f|ht){1}tps://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
                '<a href="\\1">\\1</a>', $text);
        $text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
        '\\1<a href="http://\\2">\\2</a>', $text);
        $text = eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})',
        '<a href="mailto:\\1">\\1</a>', $text);
        return $text;
}
function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}


?>