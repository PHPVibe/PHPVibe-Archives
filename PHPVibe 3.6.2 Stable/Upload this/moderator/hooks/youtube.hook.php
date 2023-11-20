<?php function youtubelinks($txt = '') {
return $txt.'
<a class="accordion-toggle" href="'.admin_url('youtube').'"><i class="icon-youtube-play"></i><span>Youtube automated</span></a>
<a class="accordion-toggle" href="'.admin_url('youtube-1by1').'"><i class="icon-youtube-square"></i><span>Youtube by choice</span></a>
';
}
add_filter('importers_menu', 'youtubelinks')

?>