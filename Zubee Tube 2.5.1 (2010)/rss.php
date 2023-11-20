<?php
header("Content-Type: application/xml; charset=UTF-8");
@include('config.php');
@include('mainfile.php');

	// feed details
	$details = '<?xml version="1.0" encoding="UTF-8" ?>
			<rss version="2.0">
				<channel>
					<title>'.$site_title .'</title>
					<link>'.$site_url.'</link>
					<description>'.$site_description.'</description>
					<language>en</language>';
	
	//get the latest videos from database
	$result2 = dbquery("SELECT * FROM videos ORDER BY id DESC LIMIT 0,20");
	while ($row = dbarray($result2)) {
		$details .= '<item>
				<title>'. htmlspecialchars($row["title"]) .'</title>
				<link>'.$site_url.$row['video_id'].'/'.Friendly_URL($row['title']).'.html</link>
				<guid isPermaLink="false">'.$site_url.'show_video.php?video_id='.$row['video_id'].'</guid>
				<description><![CDATA[Watch '. $row["title"] .']]></description>
				</item>';
	}
	
	$details .= '</channel>
				</rss>';
	
	// output
	echo $details;
?>