<?php function youtubelinks($txt = '') {
return $txt.'
<li><a href="'.admin_url('youtube').'"><i class="icon-youtube-play"></i>Youtube automated</a></li>
<li><a href="'.admin_url('youtube-1by1').'"><i class="icon-youtube-square"></i>Youtube by choice</a></li>
';
}
add_filter('importers_menu', 'youtubelinks')

?>