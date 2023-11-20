<?php include("sidebar.tpl.php");
$box_title = ucfirst($q);
?>
<div class="main">

<?php
include("video_box.tpl.php");
echo '<div class="clear"></div>';
$a->show_pages($pagi_url);
?>
</div>