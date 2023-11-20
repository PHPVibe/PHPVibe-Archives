<?php //Add your filters and actions here

function header_add(){
global $page;
$head = '
<link rel="stylesheet" type="text/css" href="'.tpl().'css/vibe.style.css" media="screen" />
<!-- Bootstrap -->
<link href="'.tpl().'css/bootstrap.css" rel="stylesheet" />
<link href="'.tpl().'css/responsive.css" rel="stylesheet" />
<link rel="stylesheet" href="'.tpl().'css/plugins.css"/>
<link rel="stylesheet" href="'.tpl().'css/slide.css"/>
<link rel="stylesheet" href="'.tpl().'css/font-awesome.css"/>
<link rel="stylesheet" href="'.tpl().'css/lightbox.css"/>
'.extra_css().'
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
</head>
<body class="touch-gesture body-'.$page.'">
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
<meta name="generator" content="phpVibe 3.4" />
<meta name="author" content="www.phpVibe.com">
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
function top_nav(){
$nav = '';
$nav .= '
		<div class="fixed-top">
		<div class="container">
		<div class="span2 logo-wrapper nomargin">
			<a href="'.site_url().'" title="" class="logo hidden-phone visible-tablet visible-desktop">'.show_logo().'</a>
			<a href="'.site_url().'" title="" class="logo visible-phone hidden-tablet hidden-desktop">'.get_option('site-logo-mobi').'</a>
		</div>		
		<div class="span10 nomargin">
		<div class="searchWidget hidden-phone visible-tablet visible-desktop">
            <form action="" method="get" id="searchform" onsubmit="location.href=\''.site_url().show.'/\' + encodeURIComponent(this.tag.value).replace(/%20/g, \'+\'); return false;">
                <input type="text" name="tag" id="suggest-videos" value="'._lang("Search videos").'" onfocus="if (this.value == \''._lang("Search videos").'\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \''._lang("Search videos").'\';}" />
             </form>       
		</div>
		'.topnavi().'
		<div class="pull-right">';

		if(!is_user()) {
		$nav .= '	<div class="user-quick">						
					<a class="dropdown-toggle" data-toggle="dropdown" original-title="Login">
					<img src="'.thumb_fix("uploads/def-avatar.jpg", true, 25, 25).'" alt="">
					<span class="username">'._lang("Visitor").'</span>
					<b class="caret"></b>
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
				$nav .= '<li ><a  href="'.site_url().'login/" title="'._lang('Login').'"><i class="icon-user"></i><span>'._lang('User & pass').'</span></a></li>                        
                    ';
           if(get_option('allowlocalreg') == 1 ) {
           $nav .= ' <li><a href="'.site_url().'register/" class="login-more"><i class="icon-double-angle-right"></i><span>'._lang('Classic registration').'</span>  </a></li>';
          }
		 $nav .= ' </ul>
		 </div>
		
		';
		
		} else {
	$nav .= '	<div class="user-quick"><a class="dropdown-toggle " title="'.user_name().'" data-toggle="dropdown">
	<img src="'.user_avatar().'" />
	<span class="username">'.user_name().'</span>
	<b class="caret"></b>
	</a>			
	<ul class="dropdown-menu enhanced userx pull-left">
<div class="triangle"></div>
<li><a href="'.profile_url(user_id(), user_name()).'"><i class="icon-user"></i>'._lang("My profile").'</a></li>
<li><a href="'.profile_url(user_id(), user_name()).'&sk=edit"><i class="icon-pencil"></i>'._lang("Edit ").'</a></li>
<li><a href="'.site_url().me.'&sk=password"><i class="icon-lock"></i>'._lang("Password").'</a></li>
<li><a href="'.site_url().me.'&sk=new-playlist"><i class="icon-plus"></i> '. _lang('New playlist').'</a> </li>
<li><a href="'.site_url().me.'&sk=playlists"><i class="icon-edit"></i> '. _lang('My playlists').'</a> </li>
<li><a href="'.site_url().me.'&sk=likes"><i class="icon-remove-circle"></i> '. _lang('My likes').'</a> </li>
<li><a href="'.site_url().me.'"><i class="icon-check"></i> '. _lang('My videos').'</a> </li>
<li><a href="'.site_url().'index.php?action=logout"><i class="icon-off"></i>'._lang("Logout").'</a></li>
</ul>	
</div>';
		
		}
		
		$nav .= '</div>
		</div>
		</div>
	</div>

	';
	
return $nav;
}
function lang_menu() {
global $cachedb;
$row = $cachedb->get_results( "SELECT `lang_code`, `lang_name` FROM ".DB_PREFIX."languages LIMIT 0,100" );
$menu = '';
if($row) {
foreach($row as $l) {
$menu .= '<li><a href="'.canonical().'&clang='.$l->lang_code.'"><i class="icon-arrow-right"></i>'.$l->lang_name.'</a></li>';
}
}
return $menu;
}
function topnavi() {
$mm = '
<nav id="channels-nav">
<ul id="main-nav">
	<li><a id="show-sidebar" class="topicon tipN" href="javascript:void(0)" title="'._lang('Show sidebar').'"><i class="icon-reorder"></i></a></li>	
		<li><a id="search-short" class="topicon tipN" href="'.site_url().show.'" title="'._lang('Search').'"><i class="icon-search"></i></a></li>	
<li><a href="javascript:void(0)"><i class="icon-film"></i><span class="hidden-phone hidden-tablet visible-desktop">'._lang("Channels").'</span></a>
';
$mm .= the_nav();
$mm .= '
</li>
';
	if(is_user()){
if((get_option('uploadrule') == 1) ||  is_moderator()) {		
$mm .= '<li><a class="topicon" href="'.site_url().share.'" title="'._lang('Upload video').'"><i class="icon-upload-alt"></i><span class="hidden-phone hidden-tablet visible-desktop">'._lang('Upload video').'</span></a>
<ul>
<li><a href="'.site_url().share.'" title="'._lang('Upload a video from your PC').'"><i class="icon-circle-arrow-up"></i>'._lang('Upload a video from your PC').'</a>
<li><a href="'.site_url().share.'&type=2" title="'._lang('Share a web video').'"><i class="icon-youtube-square"></i><i class="icon-vimeo-square"></i>'._lang('Share a web video').'</a>
<li><a href="'.profile_url(user_id(), user_name()).'#shareTowall" title="'._lang('Upload an image from your PC').'"><i class="icon-picture"></i>'._lang('Upload image from your PC').'</a>
</ul>
</li>	';
}	
$mm .= '<li><a class="topicon" href="'.site_url().buzz.'" title="'._lang('Notifications').'"><i class="icon-bell"></i></a></li>';
}
$mm .= '
<li><a class="topicon" href="#"><i class="icon-globe"></i><b class="caret"></b></a>
<ul>
'.lang_menu().'
</ul>
</li>
</ul>
</nav>';		
return $mm;
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
<script type="text/javascript" src="'.tpl().'js/jquery.infinitescroll.min.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.imagesloaded.min.js"></script>
<script type="text/javascript" src="'.tpl().'js/bootstrap.min.js"></script>
<script type="text/javascript" src="'.tpl().'js/modernizr.js"></script>   
<script type="text/javascript" src="'.tpl().'js/jquery.validation.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.validationEngine-en.js"></script> 	
<script type="text/javascript" src="'.tpl().'js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.tagsinput.min.js"></script>	
<script type="text/javascript" src="'.tpl().'js/jquery.select2.min.js"></script>	
<script type="text/javascript" src="'.tpl().'js/jquery.listbox.js"></script>	
<script type="text/javascript" src="'.tpl().'js/jquery.inputmask.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.inputlimiter.min.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.autosize.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.infinitescroll.min.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.form.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.slide.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.lightbox-2.6.min.js"></script>
<script type="text/javascript" src="'.tpl().'js/hammer.js"></script>
<script type="text/javascript" src="'.tpl().'js/typeahead.min.js"></script>
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