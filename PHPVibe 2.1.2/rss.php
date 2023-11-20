<?php  header ("content-type: text/xml");
//Vital file include
include("phpvibe.php");
// Include routing class
include( "components/RSSFeedClass.php" );
require_once("com/youtube_api.php");
function cutText($str,$nb=10) {
	    if (strlen($str) > $nb) {
		mb_internal_encoding("UTF-8");
	        $str = mb_substr($str, 0, $nb);
	        $str = $str."... ";
	    }
	    return $str;
	}
	
function removeSpaces($text) {
		$text = trim($text);
		$text = preg_replace("/ -+/","-",$text);
		$text = preg_replace("/- +/","-",$text);
		$text = preg_replace("/ +/","-",$text); // remplace les espaces par -
		return $text;
	}
	
	function cleanURLString($string) {
	    $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ';
	    $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby';
	    $string = strtr($string, $a, $b);
	    $string = strtolower($string);
	    $string = eregi_replace("[^a-z0-9]",' ',$string);
	    $string = removeSpaces($string);
	    return $string;
	}

function clean_feed($input) 
{
	$original = array("<", ">", "&", '"', "'", "<br/>", "<br>");
	$replaced = array("&lt;", "&gt;", "&amp;", "&quot;","&apos;", "", "");
	$newinput = str_replace($original, $replaced, $input);
	
	return $newinput;
}

function url_title($fix){

$fix = cleanURLString($fix);
//$fix = removeSpaces($fix);
$fix = clean_feed($fix);
return $fix;
}
	//Create a new Feed
	$feed = new Feed( );
  
	//Setting the channel elements
	//Helper -> http://www.rssboard.org/rss-specification
	$feed->setFeedTitle($config->site->name);
	$feed->setFeedLink( $config->site->url );
	$feed->setFeedDesc( $lang['home-desc'] );
	$feed->setFeedImage( $config->site->name,  $config->site->url,  $config->site->url , '100', '50' );
  
	//Is possible to use setChannelElm() function for setting other optional channel elements
	$feed->setChannelElm( 'language', 'en-us' );
    
	$vbox_result = dbquery("select * from videos WHERE views > 0 ORDER BY id DESC limit 0,20");
	
	$i = 1;
	while($row = mysql_fetch_array($vbox_result))
{
$titles = $row["title"];
$video_description  = cutText($row["description"], 50);
$v1 	=  new Youtube_class();
$youtube = $v1->getYoutubeVideoDataByVideoId($row["youtube_id"]);
if (empty($row["description"])) :
$video_description = cutText($youtube['description'], 50);
endif;
if (empty($row["title"])) :
$titles = $youtube['title'];
endif;
$item[$i] = new Item( );
//echo $titles;
$item[$i]->setItemTitle( clean_feed($titles) );
//$cleantitle = seo_clean_url($titles);
$cleantitle = url_title($titles);
$url = $site_url.'video/'.$row["youtube_id"].'/'.$cleantitle.'/';
//echo $url;
	$item[$i]->setItemLink( $url );
	$item[$i]->setItemDate(gmdate(DATE_RFC822) );
	$item[$i]->setItemDesc( clean_feed($video_description) );	
$i++;
}


	for ($ij = 1; $ij <= 20; $ij++) {
	if(isset($item[$ij])):
    $feed->addItem( $item[$ij] );
	endif;
}

	
  
	//Now we're ready to generate the Feed, Awesome!
	$feed->genFeed( );
  
?>
