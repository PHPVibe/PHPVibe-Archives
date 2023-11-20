<?php require_once('settings.php'); 
//load Youtube API class
require_once('youtube_api.php'); 
// Define cache and set expiery time (in seconds)
require_once("cache.php");
$Cache = new CacheSys("cache/", 43200);
$Cache->SetTtl(43200);

$pageNumber = $_GET["p"];

$searched_term = $_GET['s'];
if(empty($searched_term)) {
$searched_term = $_POST['s'];
}

$searched_term  = str_replace(" ", "+",$searched_term );

if($pageNumber=='') $pageNumber = 1; //default
if($nb_display=='') $nb_display=10; //default

$startIndex = $nb_display*$pageNumber-$nb_display+1;
$criteria2['q'] = $searched_term;
$criteria2['start-index'] = $startIndex;
$criteria2['max-results'] = $nb_display;

	$v1 = new Youtube_class();
	$url = $v1->getYoutubeSearchVideosFeeds($criteria2);
	$videosData = $v1->returnYoutubeVideosDatasByURL($url);
	if($pageNumber=='') $pageNumber = 1;	
    if($nbTotal==0) {
			$nbTotal = count($videosData['videos']);
		}
    $start = $nb_display*$pageNumber-$nb_display;
	
	require_once('tpl/search_tpl.php'); 	
?>