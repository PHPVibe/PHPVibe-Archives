<?php
require_once("_inc.php");
require_once("library/video.func.php");
if (!empty($_GET['tag'])){
$tag = $_GET['tag']; }
elseif (!empty($_GET['search'])){ 
$tag = $_GET['search']; }
 else { die("Hmm...no keyword?");}
 $head_title = array();

if (filterBadWords($config->site->banned, $tag) != 0) {
die("You used a bad word. Wash your mouth with soap my friend! For now, click back and be aware this it's not a porn website!");
}
if (!isset($_GET['page'])) {
	$o = 1;  
} else {        
	$page = htmlentities($_GET['page']);
	$o = (int) (($page - 1) * 34)+1;  
}
//echo $o;
$source = listBytag($tag, $o, 34);
$total = $source[0]['total'];
function ucname($string) {
    $string =ucwords(strtolower($string));

    foreach (array('+', '\'') as $delimiter) {
      if (strpos($string, $delimiter)!==false) {
        $string =implode($delimiter, array_map('ucfirst', explode($delimiter, $string)));
		$string = str_replace("+", " ", $string );
      }
    }
    return $string;
}

$head_title = array();
$head_desc = array();
$head_title[] = ucname($tag).'\'s Best videos'; 
$head_desc[] = 'Showing the best videos for '.ucname($tag); 
include_once("tpl/php/global_header.php");

?>
<div class="clearfix" id="main-content">
<div class="col col9">
  <div class="col-bkg clearfix">
    <h1><?php echo ucname($tag);?></h1>
	
<div class="vibe_contain">
 <ul>
	<?php 
	if ($total < 2):
          echo "
            	<div style=\"text-align:center;\">No result, try other keyword!</div>
          ";
        else:
        
          $i=0;
         
$video = $source[1];
while ($i<26):
          
          $video_id = $video[$i]['id'];
         
          if (empty($video_id)): $i++; elseif (empty($video[$i]['thumbnail'])): $i++; else:
            echo '<li>
                        	<div class="vibekeep">
                            	<a href="'.$site_url.'get_video.php?video_id='.$video_id.'"><img src="http://i4.ytimg.com/vi/'.$video_id.'/default.jpg" width="147" height="99" alt="" />
                                	<span class="time">'.sec2hms($video[$i]['duration']).'</span>
                                </a>
                            	<a href="http://www.youtube.com/watch?v='.$video_id.'" title="'.$video[$i]['title'].' on '.$config->site->name.'" class="addtoplaylist"><img src="'. $config->site->url.'tpl/images/plusicon.png" alt="" /></a>
                            </div>
							<div class="clear"></div>

                        	<p class="ttle"><a class="tip_trigger"  href="'.$site_url.'get_video.php?video_id='.$video_id.'">'.$video[$i]['title'].' <span class="tip" style="width: 450px;"><img src="http://i4.ytimg.com/vi/'.$video_id.'/default.jpg" style="float: left; margin-right: 20px;" alt="" /> 
 '.$video[$i]['description'].'</span></a></p>
							
                        </li>';
            $i++;
            endif;
            endwhile;
        
         endif; 
	?>                	
 </ul>



                </div>			
						<?php
   include 'library/pagination.php';
   $url = $config->site->url.'show/'.$tag.'/page-';

$c_page = (int) $_GET['page'];

$a = new pagination;	

$a->set_current($c_page);

$a->set_pages_items(12);

$a->set_per_page(34);

$a->set_values($total);

$a->show_pages($url);
     ?>
  </div>

</div>

<?php      
//Update Tags


$tag = mysql_real_escape_string($tag);
$tag = ucname($tag);

  if($tag != "" && ereg("/",$tag) == 0):
	if(!is_numeric($tag)):
		$check = dbrows(dbquery("SELECT tagid FROM tags WHERE tag='".$tag."'"));
		if($check == 0):
			dbquery("INSERT INTO tags VALUES (NULL, '".$tag."', '1')");
		else:
			dbquery("UPDATE tags SET tcount=tcount+1 WHERE tag='".$tag."'");
		endif;
	endif;
  endif;


include_once("sidebar.php");
include_once("tpl/php/footer.php");
?>

