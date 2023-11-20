<?php
echo '<div class="msg-win">Cache cleared</div>';
$debug = $db->clean_cache();
foreach ($debug as $d) {
echo $d;
}

?>