<?php
require_once('mainfile.php');
require_once("includes/class/apifunctions.php");

$overall_tag = '';

// set default tag
if($site_homepage == 'random_tag' || $_GET['tag']) {
	
	$default_tag = SetDefaultTag();
	$overall_tag = Security($_GET['tag']);
	
}
    
if (strlen($default_tag) < 3):
	$default_tag = $settings['default_tag'];
endif;
	
if(empty($_GET['page'])): $currentpage = 1; else: $currentpage = $_GET['page']; endif;
if(empty($overall_tag)): $tag = $default_tag; else: $tag = $overall_tag; endif;
	

$tag = urlencode($tag);
	
if (!isset($_GET['page']) || $_GET['page'] <= 0) {
	$o = 1;  
} else {        
	$page = htmlentities($_GET['page']);
	$o = (int) ($page * 10)-9;  
}

if($site_homepage == 'random_tag' || $_GET['tag']) {
	$source = listBytag($tag, $o, 10);
} else {
	$source = indexpagefeed($site_homepage, $o, 10);
}

$total = $source[0]['total'];

$pages = ceil($total/10);
          
if($pages > 1):
	//if($overall_tag != "" and $_GET['page'] != 1):
	if(isset($_GET['page']) && $_GET['page'] != 1):
		$pageless = $_GET['page']-1;
		$pagemore = $_GET['page']+1;
	else:
		$pageless = 1;
		$pagemore = 2;
	endif;
if($overall_tag != "" && ereg("/",$overall_tag) == 0):
		$newtag = str_replace(' ', '+', $overall_tag);
	else:
		$newtag = str_replace(' ', '+', $default_tag);
	endif;
endif;

/*-----------------------------------------*/

// create the tag cloud
function TagCloud($nr)
{
	
	$result = dbquery("SELECT * FROM tags WHERE tag != '' ORDER BY RAND() LIMIT 0,".$nr."");
	$tags = "";
	while ($info = dbarray($result)):
		$tags .= $info['tag'].", ";
	endwhile;
    
    $tags_array = explode(', ', substr($tags, 0, -2));
    shuffle($tags_array);
      
    foreach($tags_array as $tag):
	
		$font_size = rand(1,5);
		$color_array = array('black', 'blue', 'green', 'red', 'chartreuse', 'gray', 'yellowgreen', 'yellow');
		shuffle($color_array);
		$font_color = $color_array[0];
      
		if (strlen($tag) >= 2):
			$taglink = str_replace(' ', '+', $tag);
			echo '<a href="show-videos/'.$taglink.'" style="text-decoration:none">'.$tag.',</a> ';    
		endif;
      
	endforeach;
      		
}

/*-----------------------------------------*/

// random tag pagination

$random_tag_pagination = '';

	//Set Pages
	if($pages>7) {
		if($currentpage>4) {
			$random_tag_pagination .= '<a href="'.$site_url.'show-videos/'.$newtag.'/page-1">First</a>&nbsp;';
		}
	}
					
	if($currentpage > 1) {
		$random_tag_pagination .= '&nbsp;<a href="'.$site_url.'show-videos/'.$newtag.'/page-'.$pageless.'">Prev</a>&nbsp;';
	}
					
	$startpage = $currentpage-3<1?1:$currentpage-3;
	$endpage = $startpage+6>$pages?$pages:$startpage+6;
				
	for($i=0;$i<$pages;$i++) {
		if($i+1>=$startpage && $i+1<=$endpage) {
			if($i+1==$currentpage) {
				$current = 1;
			}else{
				$current = 0;
			}
						
			if(!isset($_GET['page'])) {$next = $i+1; $page_nr = 1;} else { $next = $i+1; $page_nr = $i+1; }

			if($current == 1){ $random_tag_pagination .= '&nbsp;<strong>'.$page_nr.'</strong>&nbsp;'; } 
			else { $random_tag_pagination .= '<a href="'.$site_url.'show-videos/'.$newtag.'/page-'.$next.'">'.$next.'</a>'; }
				
		}
	}
	
	if($currentpage!=$endpage && $currentpage<=85) {
		$random_tag_pagination .= '&nbsp;<a href="'.$site_url.'show-videos/'.$newtag.'/page-'.$pagemore.'">Next</a>&nbsp;';
	}
	
	if($pages>7) {
		if($currentpage<$pages-3 && $currentpage<=85) {
			$random_tag_pagination .= '&nbsp;<a href="'.$site_url.'show-videos/'.$newtag.'/page-'.$pages.'">Last</a>&nbsp;';
		}
	}
	
// standard feed pagination
$standard_feed_pagination = '';

	//Set Pages
	if($pages>7) {
		if($currentpage>4) {
			$standard_feed_pagination .= '<a href="'.$site_url.'random-videos/page-1">First</a>&nbsp;';
		}
	}
					
	if($currentpage > 1) {
		$standard_feed_pagination .= '&nbsp;<a href="'.$site_url.'random-videos/page-'.$pageless.'">Prev</a>&nbsp;';
	}
					
	$startpage = $currentpage-3<1?1:$currentpage-3;
	$endpage = $startpage+6>$pages?$pages:$startpage+6;
				
	for($i=0;$i<$pages;$i++) {
		if($i+1>=$startpage && $i+1<=$endpage) {
			if($i+1==$currentpage) {
				$current = 1;
			}else{
				$current = 0;
			}
						
			if(!isset($_GET['page'])) {$next = $i+1; $page_nr = 1;} else { $next = $i+1; $page_nr = $i+1; }

			if($current == 1){ $standard_feed_pagination .= '&nbsp;<strong>'.$page_nr.'</strong>&nbsp;'; } 
			else { $standard_feed_pagination .= '<a href="'.$site_url.'random-videos/page-'.$next.'">'.$next.'</a>'; }
				
		}
	}
	
	if($currentpage!=$endpage) {
		$standard_feed_pagination .= '&nbsp;<a href="'.$site_url.'random-videos/page-'.$pagemore.'">Next</a>&nbsp;';
	}
	
	if($pages>7) {
		if($currentpage<$pages-3) {
			$standard_feed_pagination .= '&nbsp;<a href="'.$site_url.'random-videos/page-'.$pages.'">Last</a>&nbsp;';
		}
	}

/*-----------------------------------------*/

//Update Tags
if($overall_tag != "" && ereg("/",$overall_tag) == 0):
	if(!is_numeric($overall_tag)):
		$check = dbrows(dbquery("SELECT tagid FROM tags WHERE tag='".$overall_tag."'"));
		if($check == 0):
			dbquery("INSERT INTO tags VALUES (NULL, '".$overall_tag."', '1')");
		else:
			dbquery("UPDATE tags SET tcount=tcount+1 WHERE tag='".$overall_tag."'");
		endif;
	endif;
endif;

/*-----------------------------------------*/

// show top tags
function TopVideos()
{
	$check = dbrows(dbquery("SELECT tagid FROM tags"));
	if($check > 0):
		$result = dbquery("SELECT * FROM tags ORDER BY tcount DESC limit 13");
		while($row = dbarray($result)):
			echo "<tr>";
			echo "<td style=\"width: 90%; padding-left: 10px;\"><a href=\"show-videos/".str_replace(' ', '+', $row['tag'])."\">".ucfirst($row['tag'])."</a></td>";
			echo "<td style=\"width: 10%;\">".$row['tcount']."</td>";
			echo "</tr>";
		endwhile;
	endif;
}

/*-----------------------------------------*/

// set the default tag for homepage
function SetDefaultTag()
{
	$result = dbquery("SELECT * FROM tags ORDER BY RAND() limit 30");
	$tags = "";
	while ($row = dbarray($result)):
		$tags .= $row['tag'].',';
	endwhile;
    
	$tags = substr($tags, 0, -1);
	$tags_array = explode(',', $tags);
    
	shuffle($tags_array);
      
	return $tags_array[0];
}
	
/*-----------------------------------------*/

// delete recently viewed videos
dbquery("DELETE FROM recent WHERE ((".time()."-time) > 300)");

/*-----------------------------------------*/

// Show Template
if($template != "") {
	if(is_file('templates/'.$template.'/index.php')) {
		require_once('templates/'.$template.'/index.php');
	} else {
		die("Your template appears to be corrupt. Try re-uploading the folder.".'/templates/'.$template);
	}
} else {
	die("Your default template doesn't appear to be set.");
}

/*-----------------------------------------*/

ob_end_flush();
?>