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
<link rel="stylesheet" href="'.tpl().'css/prettyPhoto.css"/>
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
<div id="content">
<div class="row">
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
<meta name="generator" content="phpVibe 3.3" />
<meta name="author" content="www.phpVibe.com">
<link rel="canonical" href="'.canonical().'" />
<meta property="og:site_name" content="'.get_option('site-logo-text').'" />
<meta property="fb:app_id" content="'.Fb_Key.'">
<meta property="og:url" content="'.canonical().'" />
';
if(com() == video) {
global $video;
$meta .= '
<meta property="og:image" content="'.thumb_fix($video->thumb).'" />
<meta property="og:description" content="'.seo_desc().'"/>
<meta property="og:title" content="'._html($video->title).'" />';
}
return $meta;
}


function footer_add(){
$footer =  '
</div>
</div>
</div>
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
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.infinitescroll.min.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.imagesloaded.min.js"></script>
<script type="text/javascript" src="'.tpl().'js/jquery.tipsy.js"></script>
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
<script type="text/javascript" src="'.tpl().'js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="'.tpl().'js/hammer.js"></script>
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
function extra_js() {
return apply_filter( 'filter_extrajs', false );
}
function extra_css() {
return apply_filter( 'filter_extracss', false );
}
function top_nav(){
$nav = '';
$nav .= '
<div id="top">
		<div class="fixed">
		<div class="container">
		<div class="span2 logo-wrapper nomargin">
			<a href="'.site_url().'" title="" class="logo hidden-phone visible-tablet visible-desktop">'.show_logo().'</a>
			<a href="'.site_url().'" title="" class="logo visible-phone hidden-tablet hidden-desktop"><span>'.get_option('site-logo-mobi').'</span></a>
		</div>		
		<div class="span5 nomargin">
	<ul class="top-menu pull-left">
	<li><a id="show-sidebar" class="topicon tipN visible-phone visible-tablet hidden-desktop" href="javascript:void(0)" title="'._lang('Show sidebar').'"><i class="icon-reorder"></i></a></li>		
   <li><a class="topicon dropdown-toggle head-button-link tipN" href="#" data-toggle="dropdown" title="'._lang('Change language').'"><i class="icon-globe"></i></a>
<ul class="dropdown-menu catmenu pull-right">
<div class="triangle pull-right"></div>
<div class="notice-title">'._lang('Change language').'</div>

';
$nav .= lang_menu();
$nav .= '
</ul>
 </li>
			';
				if(!is_user()) {
					$nav .= '	
				<li>
					<a id="guest" class="showthelog user-menu dropdown-toggle head-button-link" data-toggle="dropdown" original-title="Login"><img src="'.tpl().'/images/userpic.png" alt=""><span></span></a>
					<div class="dropdown-menu pull-left login-list">
          <div class="triangle pull-left"></div>
          
            <div class="notice-title">'._lang('Login').'</div>
            <div class="login-content">
                <nav>
                    <ul>';
					if(get_option('allowfb') == 1 ) {
                    $nav .= '<li class="new"><a  href="'.site_url().'index.php?action=login&type=facebook" title="'._lang('Facebook login').'"><i class="icon-facebook-sign"></i>'._lang('Facebook').'</a></li>';
                    }
					if(get_option('allowtw') == 1 ) {
					$nav .= '<li class="new"><a href="'.site_url().'index.php?action=login&type=twitter" title="'._lang('Twitter login').'"><i class="icon-twitter"></i>'._lang('Twitter').'</a></li>';
                    }
					if(get_option('allowg') == 1 ) {
					$nav .= '  <li class="new"><a href="'.site_url().'index.php?action=login&type=google" title="'._lang('Google login').'"><i class="icon-google-plus"></i>'._lang('Google').'</a></li>';
				    }
				$nav .= '<li class="new"><a  href="'.site_url().'login/" title="'._lang('Login').'"><i class="icon-user"></i>'._lang('Username & password').'</a></li>                        
                     </ul>
                </nav>
            </div>';
           if(get_option('allowlocalreg') == 1 ) {
           $nav .= ' <a href="'.site_url().'register/" class="login-more">'._lang('Classic registration').' <i class="icon-double-angle-right"></i> </a>';
          }
		 $nav .= ' </div>
        
				</li>';
				} else {
if((get_option('uploadrule') == 1) ||  is_moderator()) {		
$nav .= '<li><a class="topicon tipN" href="'.site_url().share.'" title="'._lang('Upload a file').'"><i class="icon-upload-alt"></i></a></li>	';
}	
	$nav .= '	
  <li><a class="topicon tipN" href="'.site_url().share.'&type=2" title="'._lang('Share media by link').'"><i class="icon-link"></i></a></li>		
 <li><a class="topicon tipN" href="'.site_url().buzz.'" title="'._lang('Notifications').'"><i class="icon-bullhorn"></i></a></li>
 <li><a class="topimg dropdown-toggle head-button-link" title="'.user_name().'" data-toggle="dropdown"><img src="'.user_avatar().'" style="width:22px; height: 22px;"></a>			
	<ul class="dropdown-menu catmenu pull-right">
<div class="triangle pull-right"></div>
<div class="notice-title">'.user_name().'</div>
<li><a href="'.profile_url(user_id(), user_name()).'"><i class="icon-double-angle-right"></i>'._lang("My profile").'</a></li>
<li><a href="'.site_url().me.'/"><i class="icon-check"></i>'._lang("Profile Management").'</a></li>
<li><a href="'.site_url().me.'&sk=password"><i class="icon-lock"></i>'._lang("Change password").'</a></li>
<li><a href="'.site_url().'index.php?action=logout"><i class="icon-remove-sign"></i>'._lang("Logout").'</a></li>
</ul>	
</li>
	';	
		}		
	$nav .= '</ul>
	</div>
	<div class="span5 nomargin">
		<div class="searchWidget hidden-phone visible-tablet visible-desktop">
            <form action="" method="get" id="searchform" onsubmit="location.href=\''.site_url().show.'/\' + encodeURIComponent(this.tag.value).replace(/%20/g, \'+\'); return false;">
                <input type="text" name="tag" id="suggest-videos" value="'._lang("Search videos").'" onfocus="if (this.value == \''._lang("Search videos").'\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \''._lang("Search videos").'\';}" />
             </form>
        </div>
		</div>
		</div>
		</div>
	</div>';
	
return $nav;
}
function lang_menu() {
global $cachedb;
$row = $cachedb->get_results( "SELECT `lang_code`, `lang_name` FROM ".DB_PREFIX."languages LIMIT 0,100" );
$menu = '';
if($row) {
foreach($row as $l) {
$menu .= '<li><a href="'.canonical().'&clang='.$l->lang_code.'">'.$l->lang_name.'</a></li>';
}
}
return $menu;
}

?>