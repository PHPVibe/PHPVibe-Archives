<?php require_once("load.php");
//Run Youtube
$crons = $db->get_results("select * from ".DB_PREFIX."crons where cron_type = 'youtube' or cron_type = 'youtube-1by1' order by cron_lastrun ASC limit 0,100000");
if($crons) {
//echo "Got crons";
// loop crons
foreach ($crons as $cron) {
//Check periods
//echo time() - strtotime($cron->cron_lastrun );
if($cron->cron_period < (time() - strtotime($cron->cron_lastrun ))) {
echo "<br /> Executed ".$cron->cron_name;
//Set lastrun
$db->query("UPDATE ".DB_PREFIX."crons SET cron_lastrun =now() WHERE cron_id = '".$cron->cron_id ."'");
$db->debug();
//Assign values
$importer = maybe_unserialize($cron->cron_value);
for($p=1;$p < ($cron->cron_pages + 1);$p++) {
//echo "Pages loop started ".$p;
//var_dump($importer);
$nb_display = 25;
$startIndex = $nb_display * $p - $nb_display + 1;
if (isset($importer['action'])) {
if($importer['action'] == "search") {
$importer['q'] = str_replace(" ", "+",$importer['key'] );
$importer['start-index'] = $startIndex;
$importer['max-results'] = $nb_display;
$importer['format'] = 5;
$v1 = new Youtube_class();
$url = $v1->getYoutubeSearchVideosFeeds($importer);
//echo $url;
$videosData = $v1->returnYoutubeVideosDatasByURL($url);
$nbTotal=$videosData['stats']['totalResults'];
if($nbTotal==0) { $nbTotal = count($videosData['videos']); 	}
}elseif($importer['action'] == "feed") {
$importer['feed'] = str_replace(" ", "+",$importer['feed_id'] );
$importer['start-index'] = $startIndex;
$importer['max-results'] = $nb_display;
$importer['format'] = 5;
$v1 = new Youtube_class();
$url = $v1->getYoutubeStandardVideosFeeds($importer);
$videosData = $v1->returnYoutubeVideosDatasByURL($url);
$nbTotal=$videosData['stats']['totalResults'];
if($nbTotal==0) { $nbTotal = count($videosData['videos']);	}
}elseif($importer['action'] == "user") {
$importer['start-index'] = $startIndex;
$importer['max-results'] = $nb_display;
$importer['format'] = 5;
$v1 = new Youtube_class();
$url = $v1->getYoutubeUsernameVideos($importer);
$videosData = $v1->returnYoutubeVideosDatasByURL($url);
$nbTotal=$videosData['stats']['totalResults'];
if($nbTotal==0) { $nbTotal = count($videosData['videos']); 	}
}elseif($importer['action'] == "category") {
$importer['start-index'] = $startIndex;
$importer['max-results'] = $nb_display;
$importer['format'] = 5;
$v1 = new Youtube_class();
$url = $v1->getYoutubeVideosByCategory($importer);
$videosData = $v1->returnYoutubeVideosDatasByURL($url);
$nbTotal=$videosData['stats']['totalResults'];
if($nbTotal==0) { $nbTotal = count($videosData['videos']); 	}
} 
// Do the import
if(isset($videosData['videos']) && (count($videosData['videos'] > 0))) {
//Start loop import
for($i=0;$i<count($videosData['videos']);$i++) {
if(!has_youtube_duplicate($videosData['videos'][$i]['videoid'])) {
youtube_import($videosData['videos'][$i],$importer['categ'],$importer['owner'] );
echo "Imported id ".$videosData['videos'][$i]['videoid']." onto ".$importer['categ']."<br />";
}
}
} 
}
// end pages loop
}
// end period check
} else {
echo "Not in cron execution range (cron time not meet)";
}
}
} 

?>