<?php  header ("content-type: text/xml");
//Vital file include
include("phpvibe.php");
function clean_feed($input) 
{
	$original = array("<", ">", "&", '"', "'", "<br/>", "<br>");
	$replaced = array("&lt;", "&gt;", "&amp;", "&quot;","&apos;", "", "");
	$newinput = str_replace($original, $replaced, $input);
	
	return $newinput;
}


echo'<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
<channel>
';
echo '
<title>'.$seo_title.'</title>
<description>'.$seo_desc.'</description>
<link>'.$site_url.'</link>
';
$vbox_result = dbquery("select * from videos WHERE views > 0 ORDER BY id DESC limit 0, 30");
while($videosData = mysql_fetch_array($vbox_result))
{
	$url = $site_url.'video/'.$videosData["id"].'/'.seo_clean_url($videosData['title']) .'/';
	$rss_datetime = $videosData["date"];
 echo '
	 <item>
<title>'.strip_tags($videosData['title']).'</title>
<link><![CDATA['.$url.']]></link>
<guid><![CDATA['.$url.']]></guid>
<pubDate>'.$rss_datetime.'</pubDate>
<description>[CDATA['.clean_feed($videosData["description"]).' ]]</description>
</item>
	 
	 ';

}

echo'</channel>
</rss>';		
?>