<?php
require_once "mainfile.php";

if (isset($_GET['video_id']) && isset($_GET['rating'])) {

  $video_id   = $_GET['video_id'];
  $rating     = $_GET['rating'];
      
  dbquery("UPDATE `videos` SET `rating` = `rating` + ".mysql_real_escape_string($rating)." WHERE `video_id` = '".mysql_real_escape_string($video_id)."'");
  dbquery("UPDATE `videos` SET `votes` = `votes` + 1 WHERE `video_id` = '".mysql_real_escape_string($video_id)."'");

} { redirect($site_url); }

ob_end_flush();
?>