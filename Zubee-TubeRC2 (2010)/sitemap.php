<?php
@include('config.php');
@include('mainfile.php');

	
global $handle, $counter, $file_number, $filename;

$counter = 0;

	
$file_number = 1;


function write_dabv_sitemap_xml($url,$priority = 0.5)
    {
    global $handle, $counter, $file_number, $filename;

   if($counter == 10000)
        {
        $file_number++;
        $counter = 0;
        // Attach end of file, and close it here.
        fwrite($handle,"</urlset>\n");
        fclose($handle);
        }

    if($counter == 0)
        {
       // Open next file here.
        $filename = "sitemap" . $file_number . ".xml";
        $handle = fopen($filename,"w+");
        fwrite($handle,'<?xml version="1.0" encoding="UTF-8"?>' . "\n");
        fwrite($handle,'<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">' . "\n");
        }
    if($url != "" && $url != "END")
        {
        fwrite($handle," <url>\n");
        fwrite($handle,"  <loc>$url</loc>\n");
        fwrite($handle,"  <priority>$priority</priority>\n");
        fwrite($handle," </url>\n");
        }
    if($url == "END")
        {
        fwrite($handle,"</urlset>\n");
        fclose($handle);
        }
// Increment counter for every URL.
    $counter++;
    }
	

$result2 = dbquery("SELECT * FROM videos ORDER BY id DESC LIMIT 0,10000");
while ($row = dbarray($result2)) {
$url = $site_url.$row['video_id'].'/'.Friendly_URL($row['title']).'.html';
write_dabv_sitemap_xml($url,$priority = 0.5);
}
fwrite($handle,"</urlset>\n");
fclose($handle); 

?>