<?php //Add your filters and actions here

function header_add(){
global $page;
$head = '
<link rel="stylesheet" type="text/css" href="'.tpl().'css/vibe.style.css" media="screen" />
<!-- Bootstrap -->
<link href="'.tpl().'css/bootstrap.css" rel="stylesheet" />
<link href="'.tpl().'css/responsive.css" rel="stylesheet" />
<link rel="stylesheet" href="'.tpl().'css/plugins.css"/>
<link rel="stylesheet" href="'.tpl().'css/font-awesome.css"/>
<link rel="stylesheet" href="'.tpl().'css/lightbox.css"/>
'.extra_css().'
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="'.tpl().'js/nprogress.js"></script>
<script>
   NProgress.start();
 </script>';
 if(com() == video) {
 $head .= '<script type="text/javascript" src="' . site_url() . 'lib/players/jwplayer/jwplayer.js"></script>';
if (get_option('jwkey')) { $head .= '<script type="text/javascript">jwplayer.key="' . get_option('jwkey') . '";</script>';}
     
 }
$head .= '</head>
<body class="touch-gesture body-'.$page.'" style="">
'.top_nav().'
<div id="wrapper" class="container">
<div class="row-fluid block" style="position:relative;">
';
return $head;
}
function meta_add(){
$meta = '<!doctype html> 
<html prefix="og: http://ogp.me/ns#"> 
 <html dir="ltr" lang="en-US">  
<head>  
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<title>'.seo_title().'</title>
<meta charset="UTF-8">  
<meta name="viewport" content="width=device-width,  height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<base href="'.site_url().'" />  
<meta name="description" content="'.seo_desc().'">
<meta name="generator" content="PHPVibe" />
<link rel="alternate" type="application/rss+xml" title="'.get_option('site-logo-text').' '._lang('All Media Feed').'" href="'.site_url().'feed/" />
<link rel="alternate" type="application/rss+xml" title="'.get_option('site-logo-text').' '._lang('Video Feed').'" href="'.site_url().'feed?m=1" />
<link rel="alternate" type="application/rss+xml" title="'.get_option('site-logo-text').' '._lang('Music Feed').'" href="'.site_url().'feed?m=2" />
<link rel="alternate" type="application/rss+xml" title="'.get_option('site-logo-text').' '._lang('Images Feed').'" href="'.site_url().'feed?m=3" />
<link rel="canonical" href="'.canonical().'" />
<meta property="og:site_name" content="'.get_option('site-logo-text').'" />
<meta property="fb:app_id" content="'.Fb_Key.'">
<meta property="og:url" content="'.canonical().'" />
';
if(com() == video) {
global $video;
if(isset($video) && $video) {
$meta .= '
<meta property="og:image" content="'.thumb_fix($video->thumb).'" />
<meta property="og:description" content="'.seo_desc().'"/>
<meta property="og:title" content="'._html($video->title).'" />';
}
}
if(com() == profile) {
global $profile;
if(isset($profile) && $profile) {
$meta .= '
<meta property="og:image" content="'.thumb_fix($profile->avatar).'" />
<meta property="og:description" content="'.seo_desc().'"/>
<meta property="og:title" content="'._html($profile->name).'" />';
}
}
return $meta;
}

function extra_js() {
return apply_filter( 'filter_extrajs', false );
}
function extra_css() {
return apply_filter( 'filter_extracss', false );
}
function lang_menu() {
global $cachedb;
$row = $cachedb->get_results( "SELECT `lang_code`, `lang_name` FROM ".DB_PREFIX."languages LIMIT 0,100" );
$menu = ''; $cr = ''; $fmenu = '';
if($row) {
$menu .= '<ul class="dropdown-menu pull-left"><div class="triangle"></div> ';
foreach($row as $l) {
$menu .= '<li><a href="'.canonical().'&clang='.$l->lang_code.'">'.$l->lang_name.'</a></li>';
if($l->lang_code == current_lang()) {$cr = $l->lang_name;}
}
$menu .= '</ul>';
}
$fmenu = '<div class="user-quick clang pull-right"><span class="username ldr">'.$cr.'</span><a class="dropdown-toggle" data-toggle="dropdown" original-title="'._lang("Change language").'"><img src="'.tpl().'images/lang-icon.png"/></a>
'.$menu.'
</div>
';

return $fmenu;
}
function top_nav(){
$nav = '';
$nav .= '
		<div class="fixed-top">
		<div class="container">
		<div class="row-fluid block" style="position:relative;">

		<div class="span2 logo-wrapper nomargin">';
			if(com() !== video) {
	$nav .= '<a id="show-sidebar" class="tipN visible-phone visible-tablet hidden-desktop" href="javascript:void(0)" title="'._lang('Show sidebar').'"><i class="icon-reorder"></i></a>';
    }
		$nav .= '	<a href="'.site_url().'" title="" class="logo hidden-phone visible-tablet visible-desktop">'.show_logo().'</a>
			<a href="'.site_url().'" title="" class="logo visible-phone hidden-tablet hidden-desktop">'._html(get_option('site-logo-mobi')).'</a>
		<br style="clear:both;"/>
		</div>		
		<div class="span10 nomargin">
		<div class="searchWidget hidden-phone visible-tablet visible-desktop">
            <form action="" method="get" id="searchform" onsubmit="location.href=\''.site_url().show.'/\' + encodeURIComponent(this.tag.value).replace(/%20/g, \'+\'); return false;">
                <input type="text" name="tag" id="suggest-videos" value="'._lang("Search videos").'" onfocus="if (this.value == \''._lang("Search videos").'\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \''._lang("Search videos").'\';}" />
             <button type="submit" class="btn btn-primary pull-right"><i class="icon-search"></i></button>
			 </form>       
		</div>
		
		';
	
		if(!is_user()) {
		$nav .= '	<div class="user-quick">						
					<a class="dropdown-toggle" data-toggle="dropdown" original-title="Login">					
					<span class="username">'._lang("Visitor").'</span>		<img src="'.thumb_fix("uploads/def-avatar.jpg", true, 25, 25).'" alt="">			
					</a>
					
					<ul class="dropdown-menu enhanced userx pull-left">
          <div class="triangle"></div>';
					if(get_option('allowfb') == 1 ) {
                    $nav .= '<li ><a  href="'.site_url().'index.php?action=login&type=facebook" title="'._lang('Facebook login').'"><i class="icon-facebook-sign"></i><span>'._lang('Facebook').'</a></span></li>';
                    }
					if(get_option('allowtw') == 1 ) {
					$nav .= '<li><a href="'.site_url().'index.php?action=login&type=twitter" title="'._lang('Twitter login').'"><i class="icon-twitter"></i><span>'._lang('Twitter').'</span></a></li>';
                    }
					if(get_option('allowg') == 1 ) {
					$nav .= '  <li ><a href="'.site_url().'index.php?action=login&type=google" title="'._lang('Google login').'"><i class="icon-google-plus-sign"></i><span>'._lang('Google').'</span></a></li>';
				    }
				$nav .= '<li><a  href="'.site_url().'login/" title="'._lang('Login').'"><i class="icon-user"></i><span>'._lang('User & pass').'</span></a></li>                        
               <li><a  href="'.site_url().'login/&do=forgot" title="'._lang('Forgot password').'"><i class="icon-envelope"></i><span>'._lang('Recover').'</span></a></li>                        

				 ';
           if(get_option('allowlocalreg') == 1 ) {
           $nav .= ' <li><a href="'.site_url().'register/" class="login-more"><i class="icon-double-angle-right"></i><span>'._lang('Classic registration').'</span>  </a></li>';
          }
		 $nav .= ' </ul>
		 </div>
		
		';
		
		} else {
if((get_option('upmenu') == 1) ||  is_moderator()) {		
	$nav .= '
<div class="user-quick"><a class="dropdown-toggle " title="'._lang('Upload video').'" data-toggle="dropdown">	
	<span class="username">'._lang('Upload').'</span><i class="icon-cloud-upload uqi"></i>
	
	</a>			
	<ul class="dropdown-menu enhanced userx pull-left">
<div class="triangle"></div>';
if((get_option('sharingrule') == 1) ||  is_moderator()) {
$nav .= '<li><a href="'.site_url().share.'"><i class="icon-youtube"></i>'._lang('Web video').'</a></li>';
}
if((get_option('mp3rule') == 1) ||  is_moderator()) {
$nav .= '<li><a href="'.site_url().upmusic.'"><i class="icon-music"></i>'._lang('Music').'</a></li>';
}
if((get_option('imgrule') == 1) ||  is_moderator()) {
$nav .= '<li><a href="'.site_url().upimage.'"><i class="icon-picture"></i>'._lang("Picture").'</a></li>';
}
if((get_option('uploadrule') == 1) ||  is_moderator()) {
$nav .= '<li><a href="'.site_url().add.'"><i class="icon-cloud-upload"></i> '. _lang('Upload video').'</a> </li>';
}
$nav .= '</ul>	
</div>';
}
$nav .= '	<div class="user-quick"><a class="dropdown-toggle " title="'.user_name().'" data-toggle="dropdown">	
	<span class="username">'.user_name().'</span><img src="'.user_avatar().'" />
	
	</a>			
	<ul class="dropdown-menu enhanced userx pull-left">
<div class="triangle"></div>
<li><a href="'.site_url().me.'"><i class="icon-check"></i> '. _lang('My Media').'</a> </li>
<li><a href="'.site_url().me.'&sk=likes"><i class="icon-thumbs-up"></i> '. _lang('Likes').'</a> </li>
<li><a href="'.site_url().buzz.'" title="'._lang('Notifications').'"><i class="icon-bell"></i>'._lang('Notifications').'</a></li>
<li><a href="'.site_url().me.'&sk=new-playlist"><i class="icon-plus"></i> '. _lang('New Playlist').'</a> </li>
<li><a href="'.site_url().me.'&sk=playlists"><i class="icon-edit"></i> '. _lang('Playlists').'</a> </li>
<li><a href="'.site_url().'index.php?action=logout"><i class="icon-off"></i>'._lang("Logout").'</a></li>
<li><a href="'.profile_url(user_id(), user_name()).'"><i class="icon-cog"></i>'._lang("My Profile").'</a></li>
</ul>	
</div>';
		
		}
		
		$nav .= lang_menu().'
		</div>
		</div>
		</div>
	</div>

	';
	
return $nav;
}

function footer_add(){
$next = 'var next_time = \'0\';';

if(com() == video) {
global $video;
if((isset($video) && $video) && has_list()) {
$new = guess_next();
if(isset($new['link']) && !nullval($new['link'])) {
$next = 'var next_time = \''.intval($video->duration * 1000 + 1000).'\';';
$next .= 'var next_url = \''.$new['link'].'&list='._get('list').'\';';
}
}
}
$next .= 'var nv_lang = \''._lang("Next video starting soon").'\';';
$footer =  '
</div>
</div>
</div>
</div>
<a href="#" id="linkTop" class="backtotop"><i class="icon-arrow-up"></i></a>
<div id="footer">
<div class="container">
<div class="row">
<div class="span2 footer-logo nomargin">
'.show_logo().'
</div>
<div class="span8 footer-content">
'.apply_filters('tfc', get_option('site-copyright')).'
</div>
</div>
</div>
</div>
<script type="text/javascript">
var site_url = \''.site_url().'\';
'.$next.'
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="'.tpl().'js/phpvibe_plugins.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="'.tpl().'js/phpvibe_forms.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.slide.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.multi-select.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.lightbox-2.6.min.js"></script>
<script type="text/javascript" src="'.tpl().'js/typeahead.min.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.autosize.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.gritter.js"></script>
<script type="text/javascript" src="'.tpl().'js/phpvibe_app.js"></script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId='.Fb_Key.'";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>
'.extra_js().'
'._html(get_option('googleanalitycs')).'
</body>
</html>';

return $footer;
}

?>