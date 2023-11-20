<?php 
function admin_url($sk = null){
if(is_null($sk)) {
return site_url().ADMINCP.'/';
} else {
return site_url().ADMINCP.'/?sk='.$sk;
}
}
function video_importer_links() {
$imp = '
<a class="accordion-toggle" href="'.admin_url('youtube').'"><span>Youtube automated</span></a>
<a class="accordion-toggle" href="'.admin_url('youtube-1by1').'"><span>Youtube by choice</span></a>
';
return apply_filters('importers_menu', $imp);
}
//filter

function admin_h(){
$head= '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>phpVibe - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="phpVibe.com">
    <link rel="stylesheet" href="'.admin_url().'css/bootstrap.min.css">
	<link rel="stylesheet" href="'.admin_url().'css/responsive.css">
    <link rel="stylesheet" href="'.admin_url().'css/font-awesome.css">
    <link rel="stylesheet" href="'.admin_url().'css/style.css" type="text/css" media="screen" >
	<link rel="stylesheet" href="'.admin_url().'css/plugins.css"/>

    <link href=\'http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800\' rel=\'stylesheet\' type=\'text/css\'>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="'.admin_url().'js/jquery.imagesloaded.min.js"></script>
<script type="text/javascript" src="'.admin_url().'js/jquery.tipsy.js"></script>
<script type="text/javascript" src="'.admin_url().'js/bootstrap.min.js"></script>
<script type="text/javascript" src="'.admin_url().'js/jquery.validation.js"></script>
<script type="text/javascript" src="'.admin_url().'js/jquery.validationEngine-en.js"></script> 	
<script type="text/javascript" src="'.admin_url().'js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="'.admin_url().'js/jquery.tagsinput.min.js"></script>	
<script type="text/javascript" src="'.admin_url().'js/jquery.select2.min.js"></script>	
<script type="text/javascript" src="'.admin_url().'js/jquery.listbox.js"></script>	
<script type="text/javascript" src="'.admin_url().'js/jquery.inputmask.js"></script>
<script type="text/javascript" src="'.admin_url().'js/jquery.inputlimiter.min.js"></script>
<script type="text/javascript" src="'.admin_url().'js/jquery.autosize.js"></script>
<script type="text/javascript" src="'.admin_url().'js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="'.admin_url().'js/jquery.form.js"></script>
<script type="text/javascript" src="'.admin_url().'js/phpvibe.js"></script>

   </head>
   <div id="wrap">
<div class="container-fluid">';
$head .= adm_sidebar();
$head .=  '<div id="header">
   <div id="logo">
   <h1><i class="icon-check"></i>  '.get_option("site-logo-text").'</h1>
   <span>+ phpVibe</span>
   </div>
   <div id="header-menu">
<div class="topnav">
<ul>
<li><a href="'.site_url().'" target="_blank" title="Open the website"><i class="icon-external-link"></i></a></li>
<li><a href="'.site_url().'index.php?action=logout" title="Logout"><i class="icon-eject"></i></a></li>

</ul>
</div>
   </div>
   </div>
   
';
return $head;
}
add_filter('adm_head', 'admin_h');
//common
function admin_head () {
echo apply_filters('adm_head', false);
}
add_action('ahead','admin_head', 1);
function admin_header() {
do_action('ahead');
}
function add_active($sub) {
$a = _get('sk');
$c = explode(",",$sub);
if(!in_array($a, $c)) {
return '';
} else {
return 'in';
}
}
//style
function adm_sidebar(){
$sb = '
<div class="navbar themebgcolor">
          <div class="sidebar-nav nav-collapse collapse themebgcolor">
            <div class="navbar-inner themebgcolor">
              <div class="user_side clearfix centeralign">
              </div>
              <div class="accordion" id="main-accordion">
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" href="'.admin_url().'"><div class="menubg"></div><i class="icon-home"></i> <span>Administration</span></a>
                  </div>
                </div>
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" href="'.admin_url('setts').'"><div class="menubg"></div><i class="icon-magic"></i> <span>Configuration</span></a>
                  </div>
                </div>
				<div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" href="'.admin_url('login').'"><div class="menubg"></div><i class="icon-key"></i> <span>Login Settings</span></a>
                  </div>
                </div>
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#main-accordion" href="#collapse0"><div class="menubg"></div><i class="icon-list"></i> <span>Videos</span></a>
                  </div>
                  <div id="collapse0" class="accordion-body '.add_active('videos,unvideos,videos,add-video,add-video,add-by-iframe').' collapse">
                    <div class="accordion-inner">
                      <a class="accordion-toggle green-leftstripe" href="'.admin_url('videos').'"><span>Video manager</span></a>
                      <a class="accordion-toggle green-leftstripe" href="'.admin_url('unvideos').'"><span>Unpublished videos</span></a>
					  <a class="accordion-toggle green-leftstripe" href="'.admin_url('videos').'&sort=featured"><span>Featured videos</span></a>
                      <a class="accordion-toggle green-leftstripe" href="'.admin_url('add-video').'"><span>Add video</span></a>
            		  <a class="accordion-toggle green-leftstripe" href="'.admin_url('add-by-iframe').'"><span>Video by embed code</span></a>
					</div>
                  </div>
                </div>
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#main-accordion" href="#collapse1"><div class="menubg"></div><i class="icon-signin"></i> <span>Video Importers</span></a>
                  </div>
                  <div id="collapse1" class="accordion-body '.add_active('youtube,youtube-1by1').' collapse">
                    <div class="accordion-inner">
                     '.video_importer_links().'
                    </div>
                  </div>
                </div>
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#main-accordion" href="#collapse2"><div class="menubg"></div><i class="icon-table"></i> <span>Channels</span></a>
                  </div>
                  <div id="collapse2" class="accordion-body '.add_active('channels,create-channel').' collapse">
                    <div class="accordion-inner">
                      <a class="accordion-toggle" href="'.admin_url('channels').'"><span>Manage</span></a>
                      <a class="accordion-toggle" href="'.admin_url('create-channel').'"><span>Create</span></a>
                    </div>
                  </div>
                </div>
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" href="'.admin_url('playlists').'"><div class="menubg"></div><i class="icon-forward"></i> <span>Playlists</span></a>
                  </div>
                </div>
               
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#main-accordion" href="#collapse4"><div class="menubg "></div><i class="icon-user"></i> <span>Users</span></a>
                  </div>
                  <div id="collapse4" class="accordion-body '.add_active('users').' collapse">
                    <div class="accordion-inner">
					 <a class="accordion-toggle" href="'.admin_url('users').'"><span>All users</span></a>
                    <a class="accordion-toggle" href="'.admin_url('users').'&sort=active"><span>Active</span></a> 
                      <a class="accordion-toggle" href="'.admin_url('users').'&sort=innactive"><span>Innactive</span></a>             
                   </div>
                  </div>
                </div> 
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" href="'.admin_url('comments').'"><div class="menubg"></div><i class="icon-comments-alt"></i> <span>Comments</span></a>
                  </div>
                </div>
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" href="'.admin_url('reports').'"><div class="menubg"></div><i class="icon-flag"></i> <span>Reports</span></a>
                  </div>
                </div>
				   <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" href="'.admin_url('homepage').'"><div class="menubg"></div><i class="icon-edit"></i> <span>Homepage builder</span></a>
                  </div>
                </div>
				<div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" href="'.admin_url('langs').'"><div class="menubg"></div><i class="icon-globe"></i> <span>Languages</span></a>
                  </div>
                </div>
				<div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" href="'.admin_url('crons').'"><div class="menubg"></div><i class="icon-retweet"></i> <span>Scheduled tasks</span></a>
                  </div>
                </div>
				 <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#main-accordion" href="#collapse3"><div class="menubg"></div><i class="icon-cogs"></i> <span>Tools</span></a>
                  </div>
                  <div id="collapse3" class="accordion-body collapse">
                    <div class="accordion-inner">
                      '.tools_menu().'                     
					 </div>
                  </div>
                </div> 
             </div>
            </div>
          </div>
        </div>


';
return $sb;
}
function tools_menu() {
return apply_filters('filter-tools-menu',false);
}
function support_links($tools){
return $tools.'
<a class="accordion-toggle" href="'.admin_url('clean-cache').'"><span>Clean cache</span></a>
<a class="accordion-toggle" href="'.admin_url('options').'"><span>Options API</span></a>
<a class="accordion-toggle" target="_blank" href="http://www.phpvibe.com/forum/"><span>phpVibe Support</span></a>
<a class="accordion-toggle" target="_blank" href="http://www.phpvibe.com/"><span>Get plugins</span></a>                  
';
}
add_filter('filter-tools-menu','support_links');

function count_uvid($u){
global $db;
$sub = $db->get_row("Select count(*) as nr from ".DB_PREFIX."videos where user_id ='".$u."'");
return $sub->nr;
}
function count_uact($u){
global $db;
$sub = $db->get_row("Select count(*) as nr from ".DB_PREFIX."activity where user ='".$u."'");
return $sub->nr;
}
function delete_activity_by_video($id){
global $db;
$db->query("delete from ".DB_PREFIX."activity where object ='".$id."'");
}
function delete_user($id){
global $db;
$user = $db->get_row("select id,name,avatar from ".DB_PREFIX."users where id = ".$id."");
if($user){
//remove avatar
if($user->avatar){
$thumb = $user->avatar;
if($thumb && ($thumb != "uploads/noimage.png")) {
$vurl = parse_url(trim($thumb, '/')); 
if(!isset($vurl['scheme']) || $vurl['scheme'] !== 'http'){ 
$thumb = ABSPATH.'/'.$thumb;
//remove avatar file
 remove_file($thumb);
 }
}
}
//remove videos
$videos = $db->get_results("Select id from ".DB_PREFIX."videos where user_id ='".$id."' limit 0,10000000");
if($videos) {
foreach ($videos as $re) {
delete_video($re->id);
delete_activity_by_video($re->id);
}
}
//remove likes
$likes = $db->get_results("Select vid from ".DB_PREFIX."likes where uid ='".$id."' limit 0,10000000");
if($likes){
foreach ($likes as $lre) {
unlike_video($lre->vid, $id);
}
}
//remove friendships
$db->query("delete from ".DB_PREFIX."users_friends where uid ='".$id."' or fid='".$id."'");
//remove comments
$db->query("delete from ".DB_PREFIX."em_comments where sender_id ='".$id."'");
//remove playlists
$play = $db->get_results("Select id from ".DB_PREFIX."playlists where owner ='".$id."' limit 0,10000000");
if($play){
foreach ($play as $pl) {
delete_playlist($pl->id);
}
}
//remove activity 
$db->query("delete from ".DB_PREFIX."activity where user ='".$id."'");
//finally remove user
$db->query("delete from ".DB_PREFIX."users where id ='".$id."'");
echo '<div class="msg-info">User '.$user->name.' deleted.</div>';
} else {
echo '<div class="msg-warning">User with id #'.$id.' does not exist.</div>';
}
}
function delete_cron($id) {
global $db;
$db->query("delete from ".DB_PREFIX."crons where cron_id ='".$id."'");
}
function add_cron($args = array(), $title = null) {
global $db;
unset($args["sk"]);
unset($args["docreate"]);
unset($args["p"]);
$value = maybe_serialize($args);
$type = escape($args["type"]);
if(is_null($title)) {
$name = ucfirst($type).' - '.ucfirst($args["action"]).' - '.date('l jS \of F Y h:i:s A');
} else {
$name = escape($title);
}
$db->query( "INSERT INTO  ".DB_PREFIX."crons (`cron_type`, `cron_name`, `cron_value`) VALUES ('$type','$name', '$value')" );
echo '<div class="msg-info">Cron '.$name.' created .</div>';
}
function cron_fastest($new) {
$old = get_option('cron_interval');
if($old > $new ) {
update_option('cron_interval', $new);
}
}
?>